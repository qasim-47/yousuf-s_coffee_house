
<?php
include 'db.php';

$sql = "SELECT * FROM menu";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Our Coffee Menu</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5eee6;
            padding: 30px;
        }

        h1 {
            text-align: center;
            color: #5c3520;
        }

        .menu-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }

        .menu-item {
            background: white;
            width: 250px;
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 3px 10px #ccc;
        }

        .menu-item h2 {
            color: #6b4226;
        }

        .price {
            color: #a0522d;
            font-size: 20px;
            font-weight: bold;
        }
    </style>
</head>

<body>

<h1>Our Coffee Menu ☕</h1>

<div class="menu-container">

<?php
if ($result && $result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {
?>

    <div class="menu-item">

        <h2>
            <?php echo htmlspecialchars($row['name']); ?>
        </h2>

        <p>
            <?php echo htmlspecialchars($row['description']); ?>
        </p>

        <p class="price">
            Rs. <?php echo htmlspecialchars($row['price']); ?>
        </p>

        <p>
            <?php echo htmlspecialchars($row['category']); ?>
        </p>

    </div>

<?php
    }

} else {
    echo "<p>No coffee products found.</p>";
}
?>

</div>

</body>
</html>
