<?php
// Include database connection file
include_once __DIR__ . '/../config/db_connect.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List</title>
    <link rel="stylesheet" href="style.css"> <!-- Using the same CSS as dashboard.php -->
</head>
<body>

<div class="sidebar">
    <h2>Timesheet Portal <span></span></h2>
    <ul>
        <li><a href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a></li>
        <li><a href="userlist.php"><i class="fas fa-users"></i> User List</a></li>
        <li><a href="timesheetentries.php"><i class="fas fa-clock"></i> Timesheet Entries</a></li>
        <li><a href="logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
    </ul>
</div>

<div class="main-content">
    <header>
        <h1>User List</h1>
    </header>

    <section class="table-section">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Employee ID</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Corrected query with proper column names
                $query = "SELECT userName, userEmail, employeeId FROM user";
                $result = mysqli_query($conn, $query);
                
                // Debugging: Check for SQL errors
                if (!$result) {
                    die("Query failed: " . mysqli_error($conn));
                }
                
                // Display user data
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['userName']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['userEmail']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['employeeId']) . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </section>
</div>

</body>
</html>
