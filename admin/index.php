<?php 
session_start();
include '../config/db_connect.php'; // Ensure this path is correct

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prevent SQL Injection
    $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();

        // Check password (supports plain text and hashed passwords)
        if ($password === $admin['password'] || password_verify($password, $admin['password'])) {
            $_SESSION['admin'] = $admin['username'];
            header("Location: dashboard.php"); // Redirect to admin dashboard
            exit();
        } else {
            echo "<script>alert('Invalid password!'); window.location='index.php';</script>";
        }
    } else {
        echo "<script>alert('Invalid username!'); window.location='index.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Timesheet Portal</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #1E3A75; /* Dark Blue Background */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 350px;
        }
        .login-container h2 {
            margin-bottom: 20px;
            color: #1E3A75;
        }
        .login-container input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        .login-container button {
            width: 100%;
            padding: 10px;
            background-color: #1E3A75;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            margin-top: 10px;
        }
        .login-container button:hover {
            background-color: #14305E;
        }
        .set-password {
            background-color: #102A51;
            margin-top: 10px;
        }
        .set-password:hover {
            background-color: #0C2141;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <h2>Timesheet Portal</h2>
        <p><strong>Admin Login</strong></p>
        <form method="POST" action="">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <!-- <button class="set-password" onclick="window.location.href='set_new_password.php'">
            Set New Username & Password
        </button> -->
    </div>

</body>
</html>
