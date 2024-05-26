<?php
// Include the database connection file
include 'db.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connection successful!";
}

// Test query to check if the 'users' table exists and fetch data
$sql = "SELECT * FROM users LIMIT 1";
$result = $conn->query($sql);

if ($result) {
    if ($result->num_rows > 0) {
        echo "Data retrieved successfully!";
        // Fetch a row of data
        $row = $result->fetch_assoc();
        print_r($row);
    } else {
        echo "Table 'users' exists but no data found.";
    }
} else {
    echo "Error executing query: " . $conn->error;
}

// Close the connection
$conn->close();
?>
