<?php
include '../config/db_connect.php'; // Ensure correct path

$sql = "SELECT t.id, u.userName, u.employeeId, t.task_name, t.task_day, t.hours_utilized, t.created_at 
        FROM timesheet t
        JOIN user u ON t.employee_id = u.employeeId 
        ORDER BY t.created_at DESC"; // Fetch latest entries first

$result = $conn->query($sql);

if ($result === false) {
    die("Error executing query: " . $conn->error); // Show SQL error
}

if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>Employee Name</th>
                <th>Employee ID</th>
                <th>Task Name</th>
                <th>Task Day</th>
                <th>Hours Utilized</th>
                <th>Created At</th>
            </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row['userName'] ?? 'N/A') . "</td>
                <td>" . htmlspecialchars($row['employeeId'] ?? 'N/A') . "</td>
                <td>" . htmlspecialchars($row['task_name'] ?? 'N/A') . "</td>
                <td>" . htmlspecialchars($row['task_day'] ?? 'N/A') . "</td>
                <td>" . htmlspecialchars($row['hours_utilized'] ?? 'N/A') . "</td>
                <td>" . htmlspecialchars($row['created_at'] ?? 'N/A') . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p>No timesheet records found.</p>";
}
?>
