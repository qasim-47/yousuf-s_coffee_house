
<?php

include 'db.php';

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit("Invalid request.");
}

$orderId = filter_input(
    INPUT_POST,
    'order_id',
    FILTER_VALIDATE_INT
);

$status = $_POST['order_status'] ?? '';

$allowedStatuses = [
    'Pending',
    'Processing',
    'Completed',
    'Cancelled'
];

if (!$orderId || !in_array($status, $allowedStatuses, true)) {
    exit("Invalid order ID or status.");
}

$stmt = $conn->prepare(
    "UPDATE orders SET order_status = ? WHERE id = ?"
);

$stmt->bind_param("si", $status, $orderId);

if ($stmt->execute() && $stmt->affected_rows >= 0) {

    header("Location: admin.php?updated=1");
    exit();

} else {

    echo "Unable to update order status.";

}

?>
