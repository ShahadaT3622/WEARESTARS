<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'ceo') {
    header("Location: login.php");
    exit();
}

include 'db.php';

// Fetch all users
$users_sql = "SELECT * FROM users";
$users_result = $conn->query($users_sql);
$users = [];
if ($users_result->num_rows > 0) {
    while($row = $users_result->fetch_assoc()) {
        $users[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - We Are Stars</title>
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
        .user-list {
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            width: 80%;
            margin-bottom: 20px;
            text-align: center;
        }
        .user-list h2 {
            color: #333;
        }
        .user-list ul {
            list-style: none;
            padding: 0;
        }
        .user-list ul li {
            background: #f9f9f9;
            margin: 10px 0;
            padding: 10px;
            border-radius: 5px;
            text-align: left;
        }
        .user-list ul li h3 {
            margin: 0;
        }
        .user-list ul li p {
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="user-list">
            <h2>Manage Users</h2>
            <ul>
                <?php foreach ($users as $user): ?>
                    <li>
                        <h3><?php echo $user['username']; ?></h3>
                        <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
                        <p><strong>User Type:</strong> <?php echo $user['user_type']; ?></p>
                        <p><small>Member Since: <?php echo $user['created_at']; ?></small></p>
                        <!-- Add functionality to edit or delete users if needed -->
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</body>
</html>
