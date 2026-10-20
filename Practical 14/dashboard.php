<?php
include 'db.php';
include 'access.php';

// Dashboard Statistics
function getCount($conn, $table) {
    $allowedTables = ['users', 'students', 'events'];

    if (!in_array($table, $allowedTables)) {
        return 0;
    }

    $result = mysqli_query(
        $conn,
        "SELECT COUNT(*) AS total FROM $table"
    );

    if (!$result) {
        return 0;
    }

    $row = mysqli_fetch_assoc($result);
    return $row['total'];
}

$totalUsers = getCount($conn, 'users');
$totalStudents = getCount($conn, 'students');
$totalEvents = getCount($conn, 'events');

// Latest Registrations
$registrations = mysqli_query(
    $conn,
    "SELECT id, name, email, role, created_at
     FROM users
     ORDER BY id DESC
     LIMIT 5"
);

// Recent Audit Logs
$auditLogs = mysqli_query(
    $conn,
    "SELECT action, created_at
     FROM audit_logs
     ORDER BY id DESC
     LIMIT 5"
);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Dashboard</title>

    <link rel="stylesheet" href="style.css">

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            margin: 0;
            padding: 20px;
        }

        .dashboard {
            max-width: 1100px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
        }

        nav {
            background: #1e293b;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }

        nav a {
            color: white;
            text-decoration: none;
            margin-right: 20px;
        }

        .cards {
            display: flex;
            gap: 20px;
            margin: 25px 0;
            flex-wrap: wrap;
        }

        .card {
            flex: 1;
            min-width: 180px;
            background: #dbeafe;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0 30px;
            background: white;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background: #2563eb;
            color: white;
        }

        h2 {
            margin-top: 30px;
        }
    </style>
</head>

<body>

<div class="dashboard">

    <h1>Admin Dashboard</h1>

    <p>
        Welcome,
        <?php echo htmlspecialchars($_SESSION['name']); ?>!
    </p>

    <!-- Dynamic Menu -->
    <nav>

        <?php if ($_SESSION['role'] === 'admin') { ?>

            <a href="dashboard.php">Dashboard</a>
            <a href="#registrations">Latest Registrations</a>
            <a href="#audit">Audit Logs</a>

        <?php } else { ?>

            <a href="student_dashboard.php">Student Dashboard</a>
            <a href="profile.php">My Profile</a>
            <a href="results.php">My Results</a>

        <?php } ?>

        <a href="logout.php">Logout</a>

    </nav>

    <!-- Statistics -->
    <div class="cards">

        <div class="card">
            <h3>Total Users</h3>
            <h1><?php echo $totalUsers; ?></h1>
        </div>

        <div class="card">
            <h3>Total Students</h3>
            <h1><?php echo $totalStudents; ?></h1>
        </div>

        <div class="card">
            <h3>Total Events</h3>
            <h1><?php echo $totalEvents; ?></h1>
        </div>

    </div>

    <!-- Latest Registrations -->
    <h2 id="registrations">Latest Registrations</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Registered Date</th>
        </tr>

        <?php if ($registrations) { ?>

            <?php while ($row = mysqli_fetch_assoc($registrations)) { ?>

                <tr>
                    <td>
                        <?php echo (int)$row['id']; ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row['name']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row['email']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row['role']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row['created_at']); ?>
                    </td>
                </tr>

            <?php } ?>

        <?php } ?>

    </table>

    <!-- Audit Logs -->
    <h2 id="audit">Recent Audit Logs</h2>

    <table>
        <tr>
            <th>Action</th>
            <th>Date</th>
        </tr>

        <?php if ($auditLogs) { ?>

            <?php while ($log = mysqli_fetch_assoc($auditLogs)) { ?>

                <tr>
                    <td>
                        <?php echo htmlspecialchars($log['action']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($log['created_at']); ?>
                    </td>
                </tr>

            <?php } ?>

        <?php } ?>

    </table>

</div>

</body>
</html>