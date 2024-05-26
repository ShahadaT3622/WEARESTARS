<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'communications_manager') {
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
    <title>Communications Manager Dashboard - We Are Stars</title>
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
        .profile-container, .blog-container, .messages-container {
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            width: 80%;
            margin-bottom: 20px;
            text-align: center;
        }
        .profile-container h2, .blog-container h2, .messages-container h2 {
            color: #333;
        }
        .profile-container p, .blog-container p, .messages-container p {
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
        <div class="blog-container">
            <h2>Blog Management</h2>
            <a href="manage_blogs.php">Manage Blogs</a>
        </div>
        <div class="messages-container">
            <h2>Message Management</h2>
            <a href="view_messages.php">View Messages</a>
        </div>
        <a href="logout.php" class="logout-button">Logout</a>
    </div>
</body>
</html>
