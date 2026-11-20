
<?php

include 'db.php';

if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    exit("Invalid Order ID.");
}

$orderId = (int)$_GET['id'];

$stmt = $conn->prepare(
    "SELECT * FROM orders WHERE id = ?"
);

$stmt->bind_param("i", $orderId);
$stmt->execute();

$order = $stmt->get_result()->fetch_assoc();

if (!$order) {
    exit("Order not found.");
}

$itemStmt = $conn->prepare(
    "SELECT * FROM order_items WHERE order_id = ?"
);

$itemStmt->bind_param("i", $orderId);
$itemStmt->execute();

$items = $itemStmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Order Details</title>

<style>

body {
    font-family: Arial, sans-serif;
    background: #f5eee6;
    padding: 30px;
}

.container {
    max-width: 800px;
    margin: auto;
    background: white;
    padding: 30px;
    border-radius: 12px;
}

h1, h2 {
    color: #6b4226;
    margin-bottom: 20px;
}

p {
    margin: 12px 0;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

th, td {
    padding: 13px;
    border-bottom: 1px solid #ddd;
    text-align: left;
}

th {
    background: #6b4226;
    color: white;
}

a {
    display: inline-block;
    margin-top: 25px;
    background: #6b4226;
    color: white;
    padding: 12px 20px;
    text-decoration: none;
    border-radius: 6px;
}

</style>

</head>

<body>

<div class="container">

    <h1>☕ Order Details</h1>

    <h2>Customer Information</h2>

    <p><strong>Order ID:</strong>
        <?php echo $order['id']; ?>
    </p>

    <p><strong>Name:</strong>
        <?php echo htmlspecialchars($order['customer_name']); ?>
    </p>

    <p><strong>Email:</strong>
        <?php echo htmlspecialchars($order['customer_email']); ?>
    </p>

    <p><strong>Phone:</strong>
        <?php echo htmlspecialchars($order['customer_phone']); ?>
    </p>

    <p><strong>Status:</strong>
        <?php echo htmlspecialchars($order['order_status']); ?>
    </p>

    <p><strong>Total:</strong>
        Rs. <?php echo number_format($order['total_amount'], 2); ?>
    </p>

    <h2>Ordered Products</h2>

    <table>

        <tr>
            <th>Product</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Subtotal</th>
        </tr>

        <?php while ($item = $items->fetch_assoc()) { ?>

        <tr>

            <td>
                <?php echo htmlspecialchars($item['product_name']); ?>
            </td>

            <td>
                Rs. <?php echo number_format($item['price'], 2); ?>
            </td>

            <td>
                <?php echo $item['quantity']; ?>
            </td>

            <td>
                Rs. <?php echo number_format(
                    $item['price'] * $item['quantity'], 2
                ); ?>
            </td>

        </tr>

        <?php } ?>

    </table>

    <a href="admin.php">Back to Dashboard</a>

</div>

</body>
</html>
