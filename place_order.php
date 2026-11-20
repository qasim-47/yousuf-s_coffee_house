
<?php

include 'db.php';

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit("Invalid request.");
}

$name = trim($_POST['customer_name'] ?? '');
$email = trim($_POST['customer_email'] ?? '');
$phone = trim($_POST['customer_phone'] ?? '');
$cartData = $_POST['cart_data'] ?? '';

$cart = json_decode($cartData, true);

if (
    $name === '' ||
    !filter_var($email, FILTER_VALIDATE_EMAIL) ||
    $phone === '' ||
    !is_array($cart) ||
    empty($cart)
) {
    exit("Please provide valid customer details and cart items.");
}

$conn->begin_transaction();

try {

    $total = 0;
    $items = [];

    // Verify product prices using the database
    $stmt = $conn->prepare(
        "SELECT name, price FROM menu WHERE name = ?"
    );

    foreach ($cart as $item) {

        $productName = $item['name'] ?? '';
        $quantity = filter_var(
            $item['quantity'] ?? null,
            FILTER_VALIDATE_INT,
            ["options" => ["min_range" => 1, "max_range" => 100]]
        );

        if ($productName === '' || $quantity === false) {
            throw new Exception("Invalid cart item.");
        }

        $stmt->bind_param("s", $productName);
        $stmt->execute();

        $product = $stmt->get_result()->fetch_assoc();

        if (!$product) {
            throw new Exception("Product not found.");
        }

        $price = (float)$product['price'];
        $total += $price * $quantity;

        $items[] = [
            'name' => $productName,
            'price' => $price,
            'quantity' => $quantity
        ];
    }

    // Save customer order
    $orderStmt = $conn->prepare(
        "INSERT INTO orders
        (customer_name, customer_email, customer_phone, total_amount)
        VALUES (?, ?, ?, ?)"
    );

    $orderStmt->bind_param(
        "sssd",
        $name,
        $email,
        $phone,
        $total
    );

    $orderStmt->execute();

    $orderId = $conn->insert_id;

    // Save individual order items
    $itemStmt = $conn->prepare(
        "INSERT INTO order_items
        (order_id, product_name, quantity, price)
        VALUES (?, ?, ?, ?)"
    );

    foreach ($items as $item) {

        $productName = $item['name'];
        $quantity = $item['quantity'];
        $price = $item['price'];

        $itemStmt->bind_param(
            "isid",
            $orderId,
            $productName,
            $quantity,
            $price
        );

        $itemStmt->execute();
    }

    $conn->commit();

    echo "<h1>Order Placed Successfully!</h1>";
    echo "<p>Thank you, " .
         htmlspecialchars($name, ENT_QUOTES, 'UTF-8') .
         "!</p>";
    echo "<p>Your Order ID: " . $orderId . "</p>";
    echo "<p>Total: Rs. " . number_format($total, 2) . "</p>";
    echo '<a href="index.php">Back to Coffee Shop</a>';

} catch (Throwable $e) {

    $conn->rollback();

    error_log($e->getMessage());

    http_response_code(500);
    echo "Your order could not be saved. Please check the PHP error log.";

}

?>
