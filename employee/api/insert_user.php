<?php
header("Content-Type: application/json");
include_once("../../config/db_connect.php");

$response = ["status" => "error", "message" => "An unknown error occurred."];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userEmail = $_POST['email'] ?? '';
    $employeeId = $_POST['employee_id'] ?? '';

    if (empty($userEmail) || empty($employeeId)) {
        echo json_encode(["status" => "error", "message" => "Email and Employee ID are required!"]);
        exit();
    }

    // CHECK IF USER ALREADY EXISTS
    $query = "SELECT * FROM user WHERE userEmail = ? AND employeeId = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $userEmail, $employeeId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // USER EXISTS → ALLOW LOGIN
        $user = $result->fetch_assoc();
        echo json_encode([
            "status" => "existing_user",
            "message" => "Login successful! Redirecting...",
            "user" => $user
        ]);
    } else {
        // USER DOES NOT EXIST → DENY ACCESS
        echo json_encode(["status" => "error", "message" => "Access denied! Only registered users can log in."]);
    }

    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}

$conn->close();
?>
