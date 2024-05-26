<?php
include 'db.php';

$success_message = "";
$error_message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize input
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);  // Hash the password
    $user_type = filter_input(INPUT_POST, 'user_type', FILTER_SANITIZE_STRING);

    // SQL query to insert the user into the database
    $sql = "INSERT INTO users (username, email, password, user_type) VALUES ('$username', '$email', '$password', '$user_type')";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        $success_message = "Registration successful!";
    } else {
        $error_message = "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Become a Star - We Are Stars</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .registration-container {
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            width: 400px;
            text-align: center;
        }
        .registration-container h2 {
            margin-bottom: 20px;
            color: #333;
        }
        .registration-container p {
            font-size: 18px;
            color: #555;
            margin-bottom: 30px;
        }
        .registration-container label {
            display: block;
            margin-bottom: 5px;
            color: #333;
            text-align: left;
        }
        .registration-container input[type="text"],
        .registration-container input[type="email"],
        .registration-container input[type="password"],
        .registration-container select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        .registration-container input[type="submit"] {
            background-color: #6b2875;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            margin-top: 10px;
        }
        .registration-container input[type="submit"]:hover {
            background-color: #10a89c;
        }
        .login-link {
            margin-top: 20px;
            font-size: 16px;
            color: #333;
        }
        .login-link a {
            color: #6b2875;
            text-decoration: none;
        }
        .login-link a:hover {
            text-decoration: underline;
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
    <div class="registration-container">
        <h2>Become a Star</h2>
        <p>Join We Are Stars and shine like never before. Register now to showcase your talent and connect with casting professionals.</p>
        <form action="register.php" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <label for="user_type">User Type:</label>
            <select id="user_type" name="user_type" required>
                <option value="regular">Regular</option>
                <option value="communications_manager">Communications Manager</option>
                <option value="ceo">CEO</option>
            </select>
            <input type="submit" value="Register">
        </form>
        <div class="login-link">
            Already a member? <a href="login.php">Login</a>
        </div>
        <a href="star.php" class="home-button">Return to Homepage</a>
        <?php if ($success_message): ?>
            <div class="success-message"><?php echo $success_message; ?></div>
        <?php endif; ?>
        <?php if ($error_message): ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>
    </div>
</body>
</html>
