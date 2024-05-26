s<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'communications_manager') {
    header("Location: login.php");
    exit();
}

include 'db.php';

// Define the author ID
$author_id = $_SESSION['user_id'];

// Handle blog post creation
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
    $summary = filter_input(INPUT_POST, 'summary', FILTER_SANITIZE_STRING);
    $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_STRING);

    $sql = "INSERT INTO blog_posts (title, summary, content, author_id) VALUES ('$title', '$summary', '$content', '$author_id')";
    if ($conn->query($sql) === TRUE) {
        $success_message = "Blog post created successfully!";
    } else {
        $error_message = "Error: " . $conn->error;
    }
}

// Fetch all blog posts
$blogs_sql = "SELECT * FROM blog_posts WHERE author_id='$author_id'";
$blogs_result = $conn->query($blogs_sql);
$blogs = [];
if ($blogs_result->num_rows > 0) {
    while($row = $blogs_result->fetch_assoc()) {
        $blogs[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Blogs - We Are Stars</title>
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
        .blog-form, .blog-list {
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            width: 80%;
            margin-bottom: 20px;
            text-align: center;
        }
        .blog-form h2, .blog-list h2 {
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
        .blog-list ul {
            list-style: none;
            padding: 0;
        }
        .blog-list ul li {
            background: #f9f9f9;
            margin: 10px 0;
            padding: 10px;
            border-radius: 5px;
            text-align: left;
        }
        .blog-list ul li h3 {
            margin: 0;
        }
        .blog-list ul li p {
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="blog-form">
            <h2>Create a Blog Post</h2>
            <?php if (isset($success_message)): ?>
                <p class="success-message"><?php echo $success_message; ?></p>
            <?php endif; ?>
            <?php if (isset($error_message)): ?>
                <p class="error-message"><?php echo $error_message; ?></p>
            <?php endif; ?>
            <form action="manage_blogs.php" method="post">
                <input type="text" name="title" placeholder="Title" required>
                <textarea name="summary" placeholder="Summary" required></textarea>
                <textarea name="content" placeholder="Content" required></textarea>
                <input type="submit" value="Create">
            </form>
        </div>
        <div class="blog-list">
            <h2>Blog Posts</h2>
            <ul>
                <?php foreach ($blogs as $blog): ?>
                    <li>
                        <h3><?php echo $blog['title']; ?></h3>
                        <p><?php echo $blog['summary']; ?></p>
                        <p><?php echo $blog['content']; ?></p>
                        <p><small>Created at: <?php echo $blog['created_at']; ?></small></p>
                        <a href="edit_blog.php?id=<?php echo $blog['id']; ?>">Edit</a> | 
                        <a href="delete_blog.php?id=<?php echo $blog['id']; ?>">Delete</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</body>
</html>
