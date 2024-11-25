<?php
require "connection.php";
require "header.php";

// Get the blog form ID from the URL
$blog_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch the main blog comment details
$query = "SELECT bf.`id`, bf.`blog_id`, u.`Name` AS `user_name`, bf.`comment`, bf.`created_at`, b.`blog_text` AS `blog_title` 
          FROM `blog_form` bf 
          JOIN `user` u ON bf.`user_id` = u.`UserID`
          JOIN `blog` b ON bf.`blog_id` = b.`blog_id`
          WHERE bf.`id` = $blog_id";
$result = mysqli_query($conn, $query);
$blog = mysqli_fetch_assoc($result);

// Fetch all replies to the main blog comment
$replies_query = "SELECT bf.`id`, bf.`blog_id`, u.`Name` AS `user_name`, bf.`comment`, bf.`created_at` 
                  FROM `blog_form` bf 
                  JOIN `user` u ON bf.`user_id` = u.`UserID` 
                  WHERE bf.`parent_comment_id` = $blog_id
                  ORDER BY bf.`created_at` ASC";
$replies_result = mysqli_query($conn, $replies_query);
?>

<div class="container">
    <h1 class="mt-5 text-center">Blog Comment Details for "<?php echo htmlspecialchars($blog['blog_title']); ?>"</h1>

    <!-- Main Blog Comment -->
    <div class="card mb-3">
        <div class="card-header">
            <strong><?php echo htmlspecialchars($blog['user_name']); ?></strong> commented on 
            <?php echo date('F j, Y, g:i a', strtotime($blog['created_at'])); ?>
        </div>
        <div class="card-body">
            <p class="card-text"><?php echo nl2br(htmlspecialchars($blog['comment'])); ?></p>
        </div>
    </div>

    <!-- Replies to the Main Blog Comment -->
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
        <a href="blogformshow.php" class="btn btn-primary">Back to Blog List</a>
    </div>
</div>

<?php
require "footer.php";
?>
