<?php
// pay_per_view.php
session_start();
include('db.php'); // Make sure to include your database connection

// Fetch videos
$query = "SELECT * FROM videos WHERE pay_per_view = 1";
$result = mysqli_query($conn, $query);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Pay-Per-View Videos</title>
</head>
<body>
    <h1>Pay-Per-View Videos</h1>
    <div>
        <?php while($row = mysqli_fetch_assoc($result)): ?>
            <div>
                <h2><?php echo $row['title']; ?></h2>
                <p><?php echo $row['description']; ?></p>
                <p>Price: $<?php echo $row['price']; ?></p>
                <a href="pay.php?video_id=<?php echo $row['id']; ?>">Pay to View</a>
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html>
