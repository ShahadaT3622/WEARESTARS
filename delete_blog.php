<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'communications_manager') {
    header("Location: login.php");
    exit();
}

include 'db.php';

$blog_id = $_GET['id'];

// Delete the blog post
$sql = "DELETE FROM blog_posts WHERE id='$blog_id'";
if ($conn->query($sql) === TRUE) {
    header("Location: manage_blogs.php");
} else {
    echo "Error deleting record: " . $conn->error;
}

$conn->close();
?>
