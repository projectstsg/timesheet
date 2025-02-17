<?php 
// Include database connection
require_once '../config/db_connect.php';

session_start();

// Get search query from URL parameters
$searchQuery = isset($_GET['search']) ? trim($_GET['search']) : "";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Timesheet Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</head>
<body>

<div class="sidebar">
    <h2>
        <img src="logo.png" alt="Timesheet Portal Logo" style="height: 40px; vertical-align: middle;"> Timesheet Portal
    </h2>
    <ul>
        <li><a href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a></li>
        <li><a href="userlist.php"><i class="fas fa-users"></i> User List</a></li>
        <li><a href="timesheetentries.php"><i class="fas fa-clock"></i> Timesheet Entries</a></li>
        <li><a href="logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
    </ul>
</div>

<div class="main-content">
    <header>
        <h1>Welcome, Admin!</h1>
    </header>

    <!-- User List Section -->
    <section class="table-section">
        <h2>User List</h2>
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
                // Fetch all users from the database
                $query = "SELECT userName, userEmail, employeeId FROM user ORDER BY userName ASC";
                $result = mysqli_query($conn, $query);
                
                if (!$result) {
                    die("Query Failed: " . mysqli_error($conn));
                }
                
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                                <td>" . htmlspecialchars($row['userName']) . "</td>
                                <td>" . htmlspecialchars($row['userEmail']) . "</td>
                                <td>" . htmlspecialchars($row['employeeId']) . "</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No users found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </section>

    <!-- Timesheet Entries Section -->
    <section class="table-section">
        <h2>Timesheet Entries</h2>
        <table>
            <thead>
                <tr>
                    <th>Employee Name
                        <section class="search-section">
                            <form method="GET">
                                <input type="text" name="search" placeholder="Search by Employee Name..." value="<?php echo htmlspecialchars($searchQuery); ?>">
                                <button type="submit">Search</button>
                            </form>
                        </section>
                    </th>
                    <th>Employee ID</th>
                    <th>Task Name</th>
                    <th>Task Day</th>
                    <th>Hours Utilized</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch timesheet entries based on search query
                $query_timesheet = "SELECT u.userName, t.employee_id, t.task_name, t.task_day, t.hours_utilized, t.created_at 
                                    FROM timesheet t
                                    JOIN user u ON t.employee_id = u.employeeId";

                if (!empty($searchQuery)) {
                    $searchQueryEscaped = mysqli_real_escape_string($conn, $searchQuery);
                    $query_timesheet .= " WHERE u.userName LIKE '%$searchQueryEscaped%'";
                }

                $query_timesheet .= " ORDER BY t.created_at DESC";
                $result_timesheet = mysqli_query($conn, $query_timesheet);

                if (!$result_timesheet) {
                    die("Query Failed: " . mysqli_error($conn));
                }

                if (mysqli_num_rows($result_timesheet) > 0) {
                    while ($row = mysqli_fetch_assoc($result_timesheet)) {
                        echo "<tr>
                                <td>" . htmlspecialchars($row['userName']) . "</td>
                                <td>" . htmlspecialchars($row['employee_id']) . "</td>
                                <td>" . htmlspecialchars($row['task_name']) . "</td>
                                <td>" . htmlspecialchars($row['task_day']) . "</td>
                                <td>" . htmlspecialchars($row['hours_utilized']) . "</td>
                                <td>" . htmlspecialchars($row['created_at']) . "</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No timesheet entries found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </section>
</div>

</body>
</html>
