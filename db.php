<?php
// Database credentials
$servername = "localhost"; // Usually localhost
$username = "root";        // Your database username
$password = "";            // Your database password (leave empty if no password)
$dbname = "we_are_stars";  // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>