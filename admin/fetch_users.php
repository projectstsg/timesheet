<?php
include '../config/db_connect.php'; // Ensure correct path

$sql = "SELECT id, userName, userEmail, employeeId FROM user"; // Corrected column names
$result = $conn->query($sql);

if ($result === false) {
    die("Error executing query: " . $conn->error); // Show SQL error
}

if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Employee ID</th>
            </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row['userName'] ?? 'N/A') . "</td>
                <td>" . htmlspecialchars($row['userEmail'] ?? 'N/A') . "</td>
                <td>" . htmlspecialchars($row['employeeId'] ?? 'N/A') . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p>No users found.</p>";
}
?>
