<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$video_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$video_sql = "SELECT * FROM videos WHERE id='$video_id'";
$video_result = $conn->query($video_sql);
$video = $video_result->fetch_assoc();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $video['title']; ?> - Pay-per-view Video</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="video-player">
            <h2><?php echo $video['title']; ?></h2>
            <p><?php echo $video['description']; ?></p>
            <video controls>
                <source src="<?php echo $video['file_path']; ?>" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>
    </div>
</body>
</html>
