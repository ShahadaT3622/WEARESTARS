<?php
// pay.php
session_start();
include('db.php'); // Make sure to include your database connection

if (isset($_GET['video_id'])) {
    $video_id = $_GET['video_id'];
    // Fetch video details
    $query = "SELECT * FROM videos WHERE id = $video_id";
    $result = mysqli_query($conn, $query);
    $video = mysqli_fetch_assoc($result);
}
?>
<!DOCTYPE html>
<html>
head>
    <title>Pay for Video</title>
</head>
<body>
    <h1>Pay for Video: <?php echo $video['title']; ?></h1>
    <p>Price: $<?php echo $video['price']; ?></p>
    <!-- Payment form (integration with payment gateway needed) -->
    <form action="process_payment.php" method="post">
        <input type="hidden" name="video_id" value="<?php echo $video['id']; ?>">
        <button type="submit">Pay Now</button>
    </form>
</body>
</html>
