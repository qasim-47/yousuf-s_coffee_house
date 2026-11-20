
<?php

session_start();
include 'db.php';

$error = "";
$success = "";

// Check whether an admin already exists
$result = $conn->query("SELECT COUNT(*) AS total FROM admins");
$adminCount = (int)$result->fetch_assoc()['total'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {

        $error = "Please enter username and password.";

    } elseif ($adminCount === 0) {

        // Create the first admin account
        if (strlen($password) < 8) {

            $error = "Password must be at least 8 characters.";

        } else {

            $hashedPassword = password_hash(
                $password,
                PASSWORD_DEFAULT
            );

            $stmt = $conn->prepare(
                "INSERT INTO admins (username, password) VALUES (?, ?)"
            );

            $stmt->bind_param(
                "ss",
                $username,
                $hashedPassword
            );

            if ($stmt->execute()) {

                session_regenerate_id(true);
                $_SESSION['admin_id'] = $conn->insert_id;
                $_SESSION['admin_username'] = $username;

                header("Location: admin.php");
                exit();

            } else {

                $error = "Unable to create admin account.";

            }
        }

    } else {

        // Existing admin login
        $stmt = $conn->prepare(
            "SELECT id, username, password FROM admins WHERE username = ?"
        );

        $stmt->bind_param("s", $username);
        $stmt->execute();

        $admin = $stmt->get_result()->fetch_assoc();

        if ($admin && password_verify($password, $admin['password'])) {

            session_regenerate_id(true);

            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];

            header("Location: admin.php");
            exit();

        } else {

            $error = "Incorrect username or password.";

        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Admin Login - Yousuf's Coffee</title>

<style>

* {
    box-sizing: border-box;
}

body {
    margin: 0;
    font-family: Arial, sans-serif;
    background: #f5eee6;
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
}

.login-box {
    background: white;
    width: 90%;
    max-width: 420px;
    padding: 35px;
    border-radius: 15px;
    box-shadow: 0 5px 20px #ddd;
}

h1 {
    color: #6b4226;
    text-align: center;
}

p {
    text-align: center;
    color: #777;
}

input {
    width: 100%;
    padding: 13px;
    margin: 10px 0 18px;
    border: 1px solid #ccc;
    border-radius: 7px;
}

label {
    color: #5c3520;
    font-weight: bold;
}

button {
    width: 100%;
    padding: 14px;
    background: #6b4226;
    color: white;
    border: none;
    border-radius: 7px;
    cursor: pointer;
    font-size: 16px;
}

button:hover {
    background: #4d2e1a;
}

.error {
    color: #c0392b;
    margin-bottom: 15px;
}

</style>

</head>

<body>

<div class="login-box">

    <h1>☕ Yousuf's Coffee</h1>

    <?php if ($adminCount === 0) { ?>

        <p>Create Your First Admin Account</p>

    <?php } else { ?>

        <p>Admin Login</p>

    <?php } ?>

    <?php if ($error !== '') { ?>

        <p class="error">
            <?php echo htmlspecialchars($error); ?>
        </p>

    <?php } ?>

    <form method="POST">

        <label>Username</label>

        <input
            type="text"
            name="username"
            placeholder="Enter username"
            required
        >

        <label>Password</label>

        <input
            type="password"
            name="password"
            placeholder="Enter password"
            required
        >

        <button type="submit">

            <?php
            echo $adminCount === 0
                ? "Create Admin Account"
                : "Login";
            ?>

        </button>

    </form>

</div>

</body>
</html>
