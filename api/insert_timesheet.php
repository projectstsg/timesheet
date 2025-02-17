<?php
include '../db_connect.php'; // Ensure this connects to your MySQL database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $employee_id = $_POST['employee_id'];

    // Check if the email already exists
    $checkQuery = "SELECT * FROM users WHERE userEmail = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Email already exists, return an error
        echo json_encode(["status" => "error", "message" => "Email already registered. Please log in."]);
    } else {
        // Insert the new user
        $insertQuery = "INSERT INTO users (userName, userEmail, employeeID) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("sss", $name, $email, $employee_id);
        
        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Registration successful!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Database error. Try again."]);
        }
    }
    
    $stmt->close();
    $conn->close();
}
?>
