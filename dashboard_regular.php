<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'regular') {
    header("Location: login.php");
    exit();
}

include 'db.php';

// Fetch user details
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id='$user_id'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

// Fetch all projects
$projects_sql = "SELECT * FROM projects";
$projects_result = $conn->query($projects_sql);
$projects = [];
if ($projects_result && $projects_result->num_rows > 0) {
    while($row = $projects_result->fetch_assoc()) {
        $projects[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regular User Dashboard - We Are Stars</title>
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
        .profile-container, .projects-container {
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            width: 80%;
            margin-bottom: 20px;
        }
        .profile-container h2, .projects-container h2 {
            color: #333;
        }
        .projects-container ul {
            list-style: none;
            padding: 0;
        }
        .projects-container ul li {
            background: #f9f9f9;
            margin: 10px 0;
            padding: 10px;
            border-radius: 5px;
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
        <div class="projects-container">
            <h2>Available Projects</h2>
            <ul>
                <?php if (empty($projects)): ?>
                    <li>No projects available.</li>
                <?php else: ?>
                    <?php foreach ($projects as $project): ?>
                        <li>
                            <h3><?php echo $project['project_name']; ?></h3>
                            <p><?php echo $project['description']; ?></p>
                            <p><strong>Status:</strong> <?php echo $project['status']; ?></p>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </div>
        <a href="logout.php" class="logout-button">Logout</a>
    </div>
</body>
</html>
