<?php
include '../config/db_connection.php';

$sql = "SELECT * FROM timesheets";
$result = $conn->query($sql);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
?>
