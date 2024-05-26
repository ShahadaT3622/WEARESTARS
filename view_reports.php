<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'ceo') {
    header("Location: login.php");
    exit();
}

include 'db.php';

// Fetch necessary data for reports (this is a basic example)
$users_count_sql = "SELECT COUNT(*) AS total_users FROM users";
$users_count_result = $conn->query($users_count_sql);
$users_count = $users_count_result->fetch_assoc()['total_users'];

$projects_count_sql = "SELECT COUNT(*) AS total_projects FROM projects";
$projects_count_result = $conn->query($projects_count_sql);
$projects_count = $projects_count_result->fetch_assoc()['total_projects'];

$assignments_count_sql = "SELECT COUNT(*) AS total_assignments FROM user_projects";
$assignments_count_result = $conn->query($assignments_count_sql);
$assignments_count = $assignments_count_result->fetch_assoc()['total_assignments'];

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Reports - We Are Stars</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
        }
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }
        .report-container {
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            width: 80%;
            margin-bottom: 20px;
            text-align: center;
        }
        .report-container h2 {
            color: #333;
        }
        .report-container p {
            font-size: 18px;
            color: #555;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="report-container">
            <h2>Platform Reports</h2>
            <p><strong>Total Users:</strong> <?php echo $users_count; ?></p>
            <p><strong>Total Projects:</strong> <?php echo $projects_count; ?></p>
            <p><strong>Total Assignments:</strong> <?php echo $assignments_count; ?></p>
        </div>
    </div>
</body>
</html>
