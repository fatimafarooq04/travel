<?php
require "connection.php";
require "header.php";

// Get the comment ID from the URL
$comment_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch the main comment details
$query = "SELECT dc.`id`, dc.`destination_id`, d.`Name` AS `destination_name`, u.`Name` AS `user_name`, dc.`comment`, dc.`created_at` 
          FROM `destination_comments` dc 
          JOIN `user` u ON dc.`user_id` = u.`UserID` 
          JOIN `destination` d ON dc.`destination_id` = d.`DestinationID` 
          WHERE dc.`id` = $comment_id";
$result = mysqli_query($conn, $query);
$comment = mysqli_fetch_assoc($result);

// Fetch all replies to the main comment
$replies_query = "SELECT dc.`id`, dc.`destination_id`, u.`Name` AS `user_name`, dc.`comment`, dc.`created_at` 
                  FROM `destination_comments` dc 
                  JOIN `user` u ON dc.`user_id` = u.`UserID` 
                  WHERE dc.`parent_comment_id` = $comment_id
                  ORDER BY dc.`created_at` ASC";
$replies_result = mysqli_query($conn, $replies_query);
?>

<div class="container">
    <h1 class="mt-5 text-center">Comment Details for "<?php echo htmlspecialchars($comment['destination_name']); ?>"</h1>

    <!-- Main Comment -->
    <div class="card mb-3">
        <div class="card-header">
            <strong><?php echo htmlspecialchars($comment['user_name']); ?></strong> commented on 
            <?php echo date('F j, Y, g:i a', strtotime($comment['created_at'])); ?>
        </div>
        <div class="card-body">
            <p class="card-text"><?php echo nl2br(htmlspecialchars($comment['comment'])); ?></p>
        </div>
    </div>

    <!-- Replies to the Main Comment -->
    <?php while ($reply = mysqli_fetch_assoc($replies_result)) { ?>
        <div class="card mb-3 ms-5">
            <div class="card-header">
                <strong><?php echo htmlspecialchars($reply['user_name']); ?></strong> replied on 
                <?php echo date('F j, Y, g:i a', strtotime($reply['created_at'])); ?>
            </div>
            <div class="card-body">
                <p class="card-text"><?php echo nl2br(htmlspecialchars($reply['comment'])); ?></p>
            </div>
        </div>
    <?php } ?>

    <!-- Back to List Button -->
    <div class="text-center">
        <a href="destinationcomment.php" class="btn btn-primary">Back to Comments List</a>
    </div>
</div>

<?php
require "footer.php";
?>
