<?php
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "digitalteam_timesheet";

// Create connection
$conn = new mysqli("localhost", "root", "", "digitalteam_timesheet");


// Check connection
if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Database connection failed: " . $conn->connect_error]));
}
?>
