<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

$conn = new mysqli("localhost", "root", "", "digitalteam_timesheet");

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Database connection failed"]));
}

$employee_id = isset($_GET['employee_id']) ? trim($_GET['employee_id']) : '';

if (empty($employee_id)) {
    echo json_encode(["status" => "error", "message" => "Invalid Employee ID"]);
    exit();
}

// Check if user exists in the database
$sql = "SELECT * FROM timesheet WHERE employee_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $employee_id);
$stmt->execute();
$result = $stmt->get_result();

$tasks = [];
while ($row = $result->fetch_assoc()) {
    $tasks[] = $row;
}

if (empty($tasks)) {
    echo json_encode(["status" => "new_user", "message" => "No previous entries found"]);
} else {
    echo json_encode(["status" => "success", "tasks" => $tasks]);
}

$stmt->close();
$conn->close();
?>
