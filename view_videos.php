<?php
session_start();
include 'db.php';

// Fetch all videos
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
    <title>Pay-per-view Videos - We Are Stars</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="videos-list">
            <h2>Pay-per-view Videos</h2>
            <ul>
                <?php foreach ($videos as $video): ?>
                    <li>
                        <h3><?php echo $video['title']; ?></h3>
                        <p><?php echo $video['description']; ?></p>
                        <p>Price: $<?php echo $video['price']; ?></p>
                        <a href="view_video.php?id=<?php echo $video['id']; ?>">Watch</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</body>
</html>
