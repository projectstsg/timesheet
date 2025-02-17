<?php
include '../db_connect.php'; // Ensure this connects to your MySQL database
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $employee_id = $_POST['employee_id'];

    // Fetch user details from the database
    $query = "SELECT * FROM users WHERE userEmail = ? AND employeeID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $email, $employee_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        $_SESSION["userEmail"] = $user["userEmail"];
        $_SESSION["userName"] = $user["userName"];
        $_SESSION["employeeID"] = $user["employeeID"];

        echo json_encode(["status" => "success", "message" => "Login successful!", "user" => $user]);
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid email or employee ID"]);
    }

    $stmt->close();
    $conn->close();
}
?>
