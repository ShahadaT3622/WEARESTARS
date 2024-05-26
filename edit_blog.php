<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'communications_manager') {
    header("Location: login.php");
    exit();
}

include 'db.php';

$blog_id = $_GET['id'];

// Handle blog post update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
    $summary = filter_input(INPUT_POST, 'summary', FILTER_SANITIZE_STRING);
    $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_STRING);

    $sql = "UPDATE blog_posts SET title='$title', summary='$summary', content='$content' WHERE id='$blog_id'";
    if ($conn->query($sql) === TRUE) {
        $success_message = "Blog post updated successfully!";
    } else {
        $error_message = "Error: " . $conn->error;
    }
}

// Fetch the blog post
$sql = "SELECT * FROM blog_posts WHERE id='$blog_id'";
$result = $conn->query($sql);
$blog = $result->fetch_assoc();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Blog Post - We Are Stars</title>
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
        .blog-form {
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            width: 80%;
            margin-bottom: 20px;
            text-align: center;
        }
        .blog-form h2 {
            color: #333;
        }
        .blog-form input[type="text"],
        .blog-form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        .blog-form input[type="submit"] {
            background-color: #6b2875;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }
        .blog-form input[type="submit"]:hover {
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
        <div class="blog-form">
            <h2>Edit Blog Post</h2>
            <?php if (isset($success_message)): ?>
                <p class="success-message"><?php echo $success_message; ?></p>
            <?php endif; ?>
            <?php if (isset($error_message)): ?>
                <p class="error-message"><?php echo $error_message; ?></p>
            <?php endif; ?>
            <form action="edit_blog.php?id=<?php echo $blog_id; ?>" method="post">
                <input type="text" name="title" value="<?php echo $blog['title']; ?>" required>
                <textarea name="summary" required><?php echo $blog['summary']; ?></textarea>
                <textarea name="content" required><?php echo $blog['content']; ?></textarea>
                <input type="submit" value="Update">
            </form>
        </div>
    </div>
</body>
</html>

