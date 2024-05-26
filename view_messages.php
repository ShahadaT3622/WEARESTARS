<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'communications_manager') {
    header("Location: login.php");
    exit();
}

include 'db.php';

// Fetch all messages
$messages_sql = "SELECT * FROM messages";
$messages_result = $conn->query($messages_sql);
$messages = [];
if ($messages_result->num_rows > 0) {
    while($row = $messages_result->fetch_assoc()) {
        $messages[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Messages - We Are Stars</title>
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
        .messages-container {
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            width: 80%;
            margin-bottom: 20px;
            text-align: center;
        }
        .messages-container h2 {
            color: #333;
        }
        .messages-container ul {
            list-style: none;
            padding: 0;
        }
        .messages-container ul li {
            background: #f9f9f9;
            margin: 10px 0;
            padding: 10px;
            border-radius: 5px;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="messages-container">
            <h2>Messages</h2>
            <ul>
                <?php foreach ($messages as $message): ?>
                    <li>
                        <p><strong>Name:</strong> <?php echo $message['name']; ?></p>
                        <p><strong>Email:</strong> <?php echo $message['email']; ?></p>
                        <p><strong>Message:</strong> <?php echo $message['message']; ?></p>
                        <p><small>Received at: <?php echo $message['created_at']; ?></small></p>
                        <a href="respond_message.php?id=<?php echo $message['id']; ?>">Respond</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</body>
</html>
