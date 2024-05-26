<?php
// blog.php
include 'db.php'; // Include your database connection file

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$sql = "SELECT title, summary, content, created_at FROM blog_posts ORDER BY created_at DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h1>Blog Posts</h1>";
    while($row = $result->fetch_assoc()) {
        echo "<div>";
        echo "<h2>" . $row['title'] . "</h2>";
        echo "<p><strong>Summary:</strong> " . $row['summary'] . "</p>";
        echo "<p>" . $row['content'] . "</p>";
        echo "<p><em>Posted on: " . $row['created_at'] . "</em></p>";
        echo "</div>";
        echo "<hr>";
    }
} else {
    echo "No blog posts found.";
}

$conn->close();
?>
