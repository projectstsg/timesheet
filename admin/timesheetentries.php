<?php
// Include database connection file
require_once '../config/db_connect.php';

// Initialize search query variable
$searchQuery = "";

// Check if search parameter is set
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $searchQuery = mysqli_real_escape_string($conn, $_GET['search']);
    $searchCondition = "WHERE u.userName LIKE '%$searchQuery%'";
} else {
    $searchCondition = "";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Timesheet Entries</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="sidebar">
    <h2>Timesheet Portal</h2>
    <ul>
        <li><a href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a></li>
        <li><a href="userlist.php"><i class="fas fa-users"></i> User List</a></li>
        <li><a href="timesheetentries.php"><i class="fas fa-clock"></i> Timesheet Entries</a></li>
        <li><a href="logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
    </ul>
</div>

<div class="main-content">
    <header>
        <h1>Timesheet Entries</h1>
        <section class="search-section">
            <form method="GET">
                <input type="text" name="search" placeholder="Search by Employee Name..." value="<?php echo htmlspecialchars($searchQuery); ?>">
                <button type="submit">Search</button>
            </form>
        </section>
    </header>

    <section class="table-section">
        <table>
            <thead>
                <tr>
                    <th>Employee Name</th>
                    <th>Employee ID</th>
                    <th>Task Name</th>
                    <th>Task Day</th>
                    <th>Hours Utilized</th>
                    <th>Entry Date</th>
                    <th>Entry Time</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch timesheet entries with search filter
                $query = "SELECT u.userName, t.employee_id, t.task_name, t.task_day, t.hours_utilized, 
                                 DATE(t.created_at) AS entry_date, TIME(t.created_at) AS entry_time 
                          FROM timesheet t
                          JOIN user u ON t.employee_id = u.employeeId
                          $searchCondition
                          ORDER BY t.created_at DESC";

                $result = mysqli_query($conn, $query);

                if (!$result) {
                    die("Query failed: " . mysqli_error($conn));
                }

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                                <td>" . htmlspecialchars($row['userName']) . "</td>
                                <td>" . htmlspecialchars($row['employee_id']) . "</td>
                                <td>" . htmlspecialchars($row['task_name']) . "</td>
                                <td>" . htmlspecialchars($row['task_day']) . "</td>
                                <td>" . htmlspecialchars($row['hours_utilized']) . "</td>
                                <td>" . htmlspecialchars($row['entry_date']) . "</td>
                                <td>" . htmlspecialchars($row['entry_time']) . "</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No timesheet entries found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </section>
</div>

</body>
</html>
