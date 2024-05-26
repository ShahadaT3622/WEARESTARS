<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'ceo') {
    header("Location: login.php");
    exit();
}

include 'db.php';

// Fetch user details
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id='$user_id'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CEO Dashboard - We Are Stars</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
        }
        .dashboard-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }
        .profile-container, .user-management-container, .project-management-container, .reports-container {
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            width: 80%;
            margin-bottom: 20px;
            text-align: center;
        }
        .profile-container h2, .user-management-container h2, .project-management-container h2, .reports-container h2 {
            color: #333;
        }
        .profile-container p, .user-management-container p, .project-management-container p, .reports-container p {
            font-size: 18px;
            color: #555;
            margin-bottom: 10px;
        }
        .logout-button {
            background-color: #ff4b5c;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            margin-top: 20px;
        }
        .logout-button:hover {
            background-color: #ff1c34;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="profile-container">
            <h2>Welcome, <?php echo $user['username']; ?>!</h2>
            <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
            <p><strong>Member Since:</strong> <?php echo $user['created_at']; ?></p>
        </div>
        <div class="user-management-container">
            <h2>User Management</h2>
            <a href="manage_users.php">Manage Users</a>
        </div>
        <div class="project-management-container">
            <h2>Manage Projects</h2>
            <a href="manage_projects.php">Manage Projects</a>
        </div>
        <div class="project-management-container">
            <h2>Assign Projects</h2>
            <a href="assign_projects.php">Assign Projects</a>
        </div>
        <div class="reports-container">
            <h2>Reports</h2>
            <a href="view_reports.php">View Reports</a>
        </div>
        <a href="logout.php" class="logout-button">Logout</a>
    </div>
</body>
</html>
