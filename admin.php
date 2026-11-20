
<?php

session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}


include 'db.php';

// Total orders
$totalOrders = $conn->query(
    "SELECT COUNT(*) AS total FROM orders"
)->fetch_assoc()['total'];

// Total revenue
$totalRevenue = $conn->query(
    "SELECT SUM(total_amount) AS revenue FROM orders"
)->fetch_assoc()['revenue'] ?? 0;

// Pending orders
$pendingOrders = $conn->query(
    "SELECT COUNT(*) AS total FROM orders
     WHERE order_status = 'Pending'"
)->fetch_assoc()['total'];

// Get all orders
$orders = $conn->query(
    "SELECT * FROM orders ORDER BY id DESC"
);

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Yousuf's Coffee - Admin Dashboard</title>

<style>

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: Arial, sans-serif;
    background: #f5eee6;
    padding: 30px;
}

h1 {
    color: #5c3520;
    margin-bottom: 10px;
}

.subtitle {
    color: #777;
    margin-bottom: 30px;
}

.dashboard {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-bottom: 35px;
}

.card {
    background: white;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 3px 12px #ddd;
}

.card h3 {
    color: #777;
    margin-bottom: 15px;
}

.card p {
    color: #6b4226;
    font-size: 27px;
    font-weight: bold;
}

.orders-section {
    background: white;
    padding: 25px;
    border-radius: 12px;
    overflow-x: auto;
}

.orders-section h2 {
    color: #5c3520;
    margin-bottom: 20px;
}

table {
    width: 100%;
    border-collapse: collapse;
    min-width: 650px;
}

th, td {
    padding: 14px;
    text-align: left;
    border-bottom: 1px solid #eee;
}

th {
    background: #6b4226;
    color: white;
}

tr:hover {
    background: #faf5ef;
}

.status {
    color: #a0522d;
    font-weight: bold;
}

</style>

</head>

<body>

<h1>☕ Yousuf's Coffee Admin Panel</h1>

<p class="subtitle">
Welcome to your Coffee Shop Dashboard!
</p>

<div class="dashboard">

    <div class="card">
        <h3>Total Orders</h3>
        <p><?php echo $totalOrders; ?></p>
    </div>

    <div class="card">
        <h3>Total Revenue</h3>
        <p>Rs. <?php echo number_format($totalRevenue, 2); ?></p>
    </div>

    <div class="card">
        <h3>Pending Orders</h3>
        <p><?php echo $pendingOrders; ?></p>
    </div>

</div>

<div class="orders-section">

    <h2>Customer Orders</h2>

    <table>

        <tr>
            <th>Order ID</th>
            <th>Customer Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Total Amount</th>
            <th>Status</th>
            <th>Action</th>
        </tr>

        <?php if ($orders && $orders->num_rows > 0) { ?>

            <?php while ($order = $orders->fetch_assoc()) { ?>

                <tr>

                    <td>
                        <?php echo $order['id']; ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($order['customer_name']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($order['customer_email']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($order['customer_phone']); ?>
                    </td>

                    <td>
                        Rs. <?php echo number_format($order['total_amount'], 2); ?>
                    </td>

                    
<td>

    <form action="update_status.php" method="POST">

        <input
            type="hidden"
            name="order_id"
            value="<?php echo (int)$order['id']; ?>"
        >

        <select name="order_status">

            <option value="Pending"
                <?php if($order['order_status'] == 'Pending') echo 'selected'; ?>>
                Pending
            </option>

            <option value="Processing"
                <?php if($order['order_status'] == 'Processing') echo 'selected'; ?>>
                Processing
            </option>

            <option value="Completed"
                <?php if($order['order_status'] == 'Completed') echo 'selected'; ?>>
                Completed
            </option>

            <option value="Cancelled"
                <?php if($order['order_status'] == 'Cancelled') echo 'selected'; ?>>
                Cancelled
            </option>

        </select>

        <button type="submit">Update</button>

    </form>

</td>


                    <td>
    <a href="order_details.php?id=<?php echo (int)$order['id']; ?>">
        View Details
    </a>
</td>

                </tr>

            <?php } ?>

        <?php } else { ?>

            <tr>
                <td colspan="7">No orders found.</td>
            </tr>

        <?php } ?>

    </table>

</div>

</body>
</html>
