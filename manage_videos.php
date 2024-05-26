<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'ceo') {
    header("Location: login.php");
    exit();
}

include 'db.php';

// Handle video upload
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
    $price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
    move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);

    $sql = "INSERT INTO videos (title, description, file_path, price) VALUES ('$title', '$description', '$target_file', '$price')";
    if ($conn->query($sql) === TRUE) {
        $success_message = "Video uploaded successfully!";
    } else {
        $error_message = "Error: " . $conn->error;
    }
}

// Fetch existing videos
$videos_sql = "SELECT * FROM videos";
$videos_result = $conn->query($videos_sql);
$videos = [];
if ($videos_result->num_rows > 0) {
    while($row = $videos_result->fetch_assoc()) {
        $videos[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Videos - We Are Stars</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="video-form">
            <h2>Upload New Video</h2>
            <?php if (isset($success_message)): ?>
                <p class="success-message"><?php echo $success_message; ?></p>
            <?php endif; ?>
            <?php if (isset($error_message)): ?>
                <p class="error-message"><?php echo $error_message; ?></p>
            <?php endif; ?>
            <form action="manage_videos.php" method="post" enctype="multipart/form-data">
                <input type="text" name="title" placeholder="Video Title" required>
                <textarea name="description" placeholder="Description" required></textarea>
                <input type="number" name="price" placeholder="Price" required step="0.01">
                <input type="file" name="file" required>
                <input type="submit" value="Upload">
            </form>
        </div>
        <div class="videos-list">
            <h2>Existing Videos</h2>
            <ul>
                <?php foreach ($videos as $video): ?>
                    <li>
                        <h3><?php echo $video['title']; ?></h3>
                        <p><?php echo $video['description']; ?></p>
                        <p>Price: $<?php echo $video['price']; ?></p>
                        <a href="edit_video.php?id=<?php echo $video['id']; ?>">Edit</a>
                        <a href="delete_video.php?id=<?php echo $video['id']; ?>">Delete</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</body>
</html>
