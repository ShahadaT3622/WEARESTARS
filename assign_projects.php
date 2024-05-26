<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'ceo') {
    header("Location: login.php");
    exit();
}

include 'db.php';

// Fetch all users and projects
$users_sql = "SELECT * FROM users";
$users_result = $conn->query($users_sql);
$users = [];
if ($users_result->num_rows > 0) {
    while($row = $users_result->fetch_assoc()) {
        $users[] = $row;
    }
}

$projects_sql = "SELECT * FROM projects";
$projects_result = $conn->query($projects_sql);
$projects = [];
if ($projects_result->num_rows > 0) {
    while($row = $projects_result->fetch_assoc()) {
        $projects[] = $row;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_NUMBER_INT);
    $project_id = filter_input(INPUT_POST, 'project_id', FILTER_SANITIZE_NUMBER_INT);

    // Assign user to project
    $assign_sql = "INSERT INTO user_projects (user_id, project_id) VALUES ('$user_id', '$project_id')";
    if ($conn->query($assign_sql) === TRUE) {
        $success_message = "Project assigned successfully!";
    } else {
        $error_message = "Error: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Projects - We Are Stars</title>
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
        .assignment-form, .assignment-list {
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            width: 80%;
            margin-bottom: 20px;
            text-align: center;
        }
        .assignment-form h2, .assignment-list h2 {
            color: #333;
        }
        .assignment-form select, .assignment-form input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        .assignment-form input[type="submit"] {
            background-color: #6b2875;
            color: white;
            cursor: pointer;
            margin-top: 10px;
        }
        .assignment-form input[type="submit"]:hover {
            background-color: #10a89c;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="assignment-form">
            <h2>Assign Project to User</h2>
            <?php if (isset($success_message)): ?>
                <p class="success-message"><?php echo $success_message; ?></p>
            <?php endif; ?>
            <?php if (isset($error_message)): ?>
                <p class="error-message"><?php echo $error_message; ?></p>
            <?php endif; ?>
            <form action="assign_projects.php" method="post">
                <select name="user_id" required>
                    <option value="">Select User</option>
                    <?php foreach ($users as $user): ?>
                        <option value="<?php echo $user['id']; ?>"><?php echo $user['username']; ?> (<?php echo $user['email']; ?>)</option>
                    <?php endforeach; ?>
                </select>
                <select name="project_id" required>
                    <option value="">Select Project</option>
                    <?php foreach ($projects as $project): ?>
                        <option value="<?php echo $project['id']; ?>"><?php echo $project['project_name']; ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="submit" value="Assign">
            </form>
        </div>
    </div>
</body>
</html>
