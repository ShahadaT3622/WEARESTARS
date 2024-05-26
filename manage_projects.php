<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'ceo') {
    header("Location: login.php");
    exit();
}

include 'db.php';

// Handle project creation
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $project_name = filter_input(INPUT_POST, 'project_name', FILTER_SANITIZE_STRING);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
    $status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING);

    $sql = "INSERT INTO projects (project_name, description, status) VALUES ('$project_name', '$description', '$status')";
    if ($conn->query($sql) === TRUE) {
        $success_message = "Project created successfully!";
    } else {
        $error_message = "Error: " . $conn->error;
    }
}

// Fetch all projects
$projects_sql = "SELECT * FROM projects";
$projects_result = $conn->query($projects_sql);
$projects = [];
if ($projects_result->num_rows > 0) {
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
    <title>Manage Projects - We Are Stars</title>
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
        .project-form, .project-list {
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            width: 80%;
            margin-bottom: 20px;
            text-align: center;
        }
        .project-form h2, .project-list h2 {
            color: #333;
        }
        .project-form input[type="text"],
        .project-form textarea,
        .project-form select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        .project-form input[type="submit"] {
            background-color: #6b2875;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }
        .project-form input[type="submit"]:hover {
            background-color: #10a89c;
        }
        .project-list ul {
            list-style: none;
            padding: 0;
        }
        .project-list ul li {
            background: #f9f9f9;
            margin: 10px 0;
            padding: 10px;
            border-radius: 5px;
            text-align: left;
        }
        .project-list ul li h3 {
            margin: 0;
        }
        .project-list ul li p {
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="project-form">
            <h2>Create a Project</h2>
            <?php if (isset($success_message)): ?>
                <p class="success-message"><?php echo $success_message; ?></p>
            <?php endif; ?>
            <?php if (isset($error_message)): ?>
                <p class="error-message"><?php echo $error_message; ?></p>
            <?php endif; ?>
            <form action="manage_projects.php" method="post">
                <input type="text" name="project_name" placeholder="Project Name" required>
                <textarea name="description" placeholder="Description" required></textarea>
                <select name="status" required>
                    <option value="">Select Status</option>
                    <option value="Pending">Pending</option>
                    <option value="In Progress">In Progress</option>
                    <option value="Completed">Completed</option>
                </select>
                <input type="submit" value="Create">
            </form>
        </div>
        <div class="project-list">
            <h2>Existing Projects</h2>
            <ul>
                <?php foreach ($projects as $project): ?>
                    <li>
                        <h3><?php echo $project['project_name']; ?></h3>
                        <p><?php echo $project['description']; ?></p>
                        <p><strong>Status:</strong> <?php echo $project['status']; ?></p>
                        <p><small>Created at: <?php echo $project['created_at']; ?></small></p>
                        <!-- Add functionality to edit or delete projects if needed -->
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</body>
</html>
