<?php 
session_start();
include '../config/db_connect.php'; // Ensure this path is correct

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $user_type = $_POST['user_type']; // 'admin' or 'user'

    if ($user_type == "admin") {
        // Admin Login
        $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ?");
    } else {
        // User Login
        $stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
    }
    
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();

        // Check password (supports plain text & hashed)
        if ($password === $data['password'] || password_verify($password, $data['password'])) {
            $_SESSION['username'] = $data['username'];
            $_SESSION['user_id'] = $data['id'];

            if ($user_type == "admin") {
                header("Location: dashboard.php"); // Redirect to admin dashboard
            } else {
                header("Location: index.php"); // Redirect to timesheet for users
            }
            exit();
        } else {
            echo "<script>alert('Invalid password!'); window.location='login.php';</script>";
        }
    } else {
        echo "<script>alert('Invalid username!'); window.location='login.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Timesheet Portal</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #1E3A75; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-container { background: white; padding: 30px; border-radius: 10px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2); text-align: center; width: 350px; }
        .login-container h2 { margin-bottom: 20px; color: #1E3A75; }
        .login-container input, .login-container select { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ccc; border-radius: 5px; font-size: 16px; }
        .login-container button { width: 100%; padding: 10px; background-color: #1E3A75; color: white; border: none; border-radius: 5px; font-size: 18px; cursor: pointer; margin-top: 10px; }
        .login-container button:hover { background-color: #14305E; }
    </style>
</head>
<body>

    <div class="login-container">
        <h2>Timesheet Portal</h2>
        <form method="POST" action="">
            <select name="user_type">
                <option value="admin">Admin</option>
                <option value="user">User</option>
            </select>
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
    </div>

</body>
</html>
