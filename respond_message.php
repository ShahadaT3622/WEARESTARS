<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'communications_manager') {
    header("Location: login.php");
    exit();
}

include 'db.php';

$message_id = $_GET['id'];

// Handle message response
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $response = filter_input(INPUT_POST, 'response', FILTER_SANITIZE_STRING);

    $sql = "UPDATE messages SET responded=TRUE, response='$response' WHERE id='$message_id'";
    if ($conn->query($sql) === TRUE) {
        $success_message = "Response sent successfully!";
    } else {
        $error_message = "Error: " . $conn->error;
    }
}

// Fetch the message
$sql = "SELECT * FROM messages WHERE id='$message_id'";
$result = $conn->query($sql);
$message = $result->fetch_assoc();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Respond to Message - We Are Stars</title>
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
        .message-form {
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            width: 80%;
            margin-bottom: 20px;
            text-align: center;
        }
        .message-form h2 {
            color: #333;
        }
        .message-form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        .message-form input[type="submit"] {
            background-color: #6b2875;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }
        .message-form input[type="submit"]:hover {
            background-color: #10a89c;
        }
        .success-message {
            color: green;
            margin-top: 20px;
        }
        .error-message {
            color: red;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="message-form">
            <h2>Respond to Message</h2>
            <?php if (isset($success_message)): ?>
                <p class="success-message"><?php echo $success_message; ?></p>
            <?php endif; ?>
            <?php if (isset($error_message)): ?>
                <p class="error-message"><?php echo $error_message; ?></p>
            <?php endif; ?>
            <p><strong>Name:</strong> <?php echo $message['name']; ?></p>
            <p><strong>Email:</strong> <?php echo $message['email']; ?></p>
            <p><strong>Message:</strong> <?php echo $message['message']; ?></p>
            <form action="respond_message.php?id=<?php echo $message_id; ?>" method="post">
                <textarea name="response" placeholder="Your Response" required></textarea>
                <input type="submit" value="Send Response">
            </form>
        </div>
    </div>
</body>
</html>
