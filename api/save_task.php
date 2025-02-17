<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$conn = new mysqli("localhost", "root", "", "digitalteam_timesheet");

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Database connection failed"]));
}

// Get input data
$employee_id = $_POST['employee_id'] ?? '';
$task_name = $_POST['task_name'] ?? '';
$task_day = $_POST['task_day'] ?? '';
$hours_utilized = $_POST['hours_utilized'] ?? '';
$week_start_date = $_POST['week_start_date'] ?? '';

if (!$employee_id || !$task_name || !$task_day || !$hours_utilized || !$week_start_date) {
    echo json_encode(["status" => "error", "message" => "All fields are required"]);
    exit();
}

// Insert task into the database with the correct week start date
$sql = "INSERT INTO timesheet (employee_id, task_name, task_day, hours_utilized, week_start_date) 
        VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $employee_id, $task_name, $task_day, $hours_utilized, $week_start_date);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Task saved successfully"]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to save task"]);
}

$stmt->close();
$conn->close();
?>
