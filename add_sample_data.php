<?php
// Include the database connection file
include('db.php');

// Create the blog_posts table if it doesn't exist
$createTableQuery = "CREATE TABLE IF NOT EXISTS blog_posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($mysqli->query($createTableQuery) === TRUE) {
    echo "Table 'blog_posts' created successfully.<br>";
} else {
    echo "Error creating table: " . $mysqli->error . "<br>";
}

// Insert sample data into the blog_posts table
$insertDataQuery = "INSERT INTO blog_posts (title, content) VALUES
('First Blog Post', 'This is the content of the first blog post.'),
('Second Blog Post', 'This is the content of the second blog post.'),
('Third Blog Post', 'This is the content of the third blog post.')";

if ($mysqli->query($insertDataQuery) === TRUE) {
    echo "Sample data inserted successfully.<br>";
} else {
    echo "Error inserting data: " . $mysqli->error . "<br>";
}

// Close the database connection
$mysqli->close();
?>
