<?php
include("db_connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $userEmail = $_POST["userEmail"];
    $employeeID = $_POST["employeeID"];

    // Check if user already exists
    $checkQuery = "SELECT * FROM users WHERE userEmail = '$userEmail'";
    $result = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($result) > 0) {
        // User exists, return success for login
        echo json_encode(["success" => true, "message" => "Login successful"]);
    } else {
        // New user, insert into database
        $insertQuery = "INSERT INTO users (username, userEmail, employeeID) VALUES ('$username', '$userEmail', '$employeeID')";
        
        if (mysqli_query($conn, $insertQuery)) {
            echo json_encode(["success" => true, "message" => "Registration successful"]);
        } else {
            echo json_encode(["success" => false, "error" => mysqli_error($conn)]);
        }
    }
}
?>
