<?php
// Start the session

require "header.php";
require "connection.php"; // Database connection

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Handle posting new comment
if (isset($_POST['sub'])) {
    // Validate and sanitize comment input
    $comment = mysqli_real_escape_string($conn, $_POST['comment']);

    // Get the destination ID from URL parameter
    if (isset($_GET['id'])) {
        $blog_id = $_GET['id'];
    } else {
        // Handle the case where destination ID is not provided
        echo "<script>alert('Blog ID is missing.'); window.location.href='blog-detail.php';</script>";
        exit;
    }

    // Check if user is logged in
    if (isset($_SESSION['UserID'])) {
        $user_id = $_SESSION['UserID']; // Get the user ID from session

        if (!empty($comment)) {
            // Insert comment into blog_form table
            $sql = "INSERT INTO blog_form (blog_id, user_id, comment, created_at) 
                    VALUES ('$blog_id', '$user_id', '$comment', NOW())";
            if (mysqli_query($conn, $sql)) {
                echo "<script>alert('Comment posted successfully.'); window.location.href='blog-detail.php?id=$blog_id';</script>";
            } else {
                echo "<script>alert('Error posting comment: " . mysqli_error($conn) . "'); window.location.href='blog-detail.php?id=$blog_id';</script>";
            }
        } else {
            echo "<script>alert('Comment cannot be empty.'); window.location.href='blog-detail.php?id=$blog_id';</script>";
        }
    } else {
        echo "<script>alert('Please log in to leave a comment.'); window.location.href='login.php';</script>";
    }
}

// Handle posting reply
if (isset($_POST['sub_reply'])) {
    // Validate and sanitize reply input
    $reply = mysqli_real_escape_string($conn, $_POST['reply']);
    $parent_comment_id = $_POST['parent_comment_id'];

    // Get the destination ID from URL parameter
    if (isset($_GET['id'])) {
        $blog_id = $_GET['id'];
    } else {
        // Handle the case where destination ID is not provided
        echo "<script>alert('Blog ID is missing.'); window.location.href='blog-detail.php';</script>";
        exit;
    }

    if (isset($_SESSION['UserID']) && !empty($reply) && !empty($parent_comment_id)) {
        $user_id = $_SESSION['UserID'];

        // Insert reply into blog_form table
        $sql = "INSERT INTO blog_form (comment, blog_id, user_id, created_at, parent_comment_id) 
                VALUES ('$reply', '$blog_id', '$user_id', NOW(), '$parent_comment_id')";
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Reply posted successfully.'); window.location.href='blog-detail.php?id=$blog_id';</script>";
        } else {
            echo "<script>alert('Error posting reply: " . mysqli_error($conn) . "'); window.location.href='blog-detail.php?id=$blog_id';</script>";
        }
    } else {
        echo "<script>alert('Please log in to leave a reply.'); window.location.href='login.php';</script>";
    }
}

// Fetch destination details from the database
if (isset($_GET['id'])) {
    $blog_id = $_GET['id'];
    $sql = "SELECT * FROM `blog` 
            WHERE blog_id = $blog_id";
    $result = mysqli_query($conn, $sql);

    if ($row = mysqli_fetch_array($result)) {
        $description_paragraphs = explode("\n", $row['blog_desc']);
        $images = ['img1' => $row['img1'], 'img2' => $row['img2'], 'img3' => $row['img3']];
        $cardImage = $row['blog_img'];
        $filteredImages = array_filter($images, function ($image) use ($cardImage) {
            return $image != $cardImage;
        });
        $filteredImages = array_values($filteredImages); // Re-index the array

        if (count($filteredImages) < 2) {
            echo "<script>alert('Not enough images available for this blog.'); window.location.href='bloglist.php';</script>";
            exit;
        }
    } else {
        echo "<script>alert('No blog found with ID: $blog_id'); window.location.href='bloglist.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('No blog ID provided.'); window.location.href='bloglist.php';</script>";
    exit;
}
?>

<!-- Header Start -->
<div class="container-fluid page-header">
    <div class="container">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 400px">
            <h3 class="display-4 text-white text-uppercase">Blog Detail</h3>
            <div class="d-inline-flex text-white">
                <p class="m-0 text-uppercase"><a class="text-white" href="">Home</a></p>
                <i class="fa fa-angle-double-right pt-1 px-3"></i>
                <p class="m-0 text-uppercase">Blog Detail</p>
            </div>
        </div>
    </div>
</div>
<!-- Header End -->

<div class="container mt-5">
    <h1 class="text-center"><?php echo $row['blog_head']; ?> Blog Detail</h1>
    <div class="content-wrapper">
        <div class="main-content">
            <?php
            if (isset($description_paragraphs[0])) {
                echo '<p>' . $description_paragraphs[0] . '</p>';
            }
            echo '<img src="../admin/' . $filteredImages[0] . '" alt="Image 1">';
            for ($i = 1; $i < count($description_paragraphs); $i++) {
                echo '<p>' . $description_paragraphs[$i] . '</p>';
            }
            echo '<img src="../admin/' . $filteredImages[1] . '" alt="Image 2">';
            ?>
        </div>
        <div class="sidebar">
            <p><strong>Blog Heading:</strong> <?php echo $row['blog_head']; ?></p>
            <p><strong>Blog Text:</strong> <?php echo $row['blog_text']; ?></p>
            <p><strong>Date:</strong> <?php echo $row['blog_date']; ?></p>
            <p><strong>Month:</strong> <?php echo $row['blog_month']; ?></p>
        </div>
    </div>

    <!-- Comment Form Start -->
    <div class="bg-white mb-3" style="padding: 30px;">
        <h4 class="text-uppercase mb-4" style="letter-spacing: 5px;">Leave a comment</h4>
        <form action="#" method="POST">
            <div class="form-group">
                <label for="message">Message *</label>
                <textarea id="message" cols="30" rows="5" class="form-control" name="comment" required></textarea>
            </div>
            <div class="form-group mb-0">
                <input type="submit" value="Leave a comment" class="btn btn-primary font-weight-semi-bold py-2 px-3"
                    name="sub">
            </div>
        </form>
    </div>
    <!-- Comment Form End -->

    <!-- Comments List Start -->
    <div class="bg-white" style="padding: 30px; margin-top: 30px;">
        <h4 class="text-uppercase mb-4" style="letter-spacing: 5px;">Comments</h4>
        <?php
        // Fetch comments from the database
        $sql = "SELECT blog_form.*, user.Name FROM blog_form 
                JOIN user ON blog_form.user_id = user.UserID 
                WHERE blog_id = $blog_id AND parent_comment_id IS NULL 
                ORDER BY created_at DESC";
              
        $result = mysqli_query($conn, $sql);

        if (!$result) {
            echo "<script>alert('Error fetching comments: " . mysqli_error($conn) . "');</script>";
        } else {
            while ($row = mysqli_fetch_array($result)) {
                ?>
                <div class="border p-3 mb-3">
                    <p><strong><?php echo $row['Name']; ?></strong> -
                        <?php echo date('F j, Y, g:i a', strtotime($row['created_at'])); ?>
                    </p>
                    <p><?php echo nl2br($row['comment']); ?></p>
                    <!-- Reply Button -->
                    <button class="reply-button" onclick="showReplyForm(<?php echo $row['id']; ?>)">Reply</button>

                    <!-- Reply Form -->
                    <div id="replyForm<?php echo $row['id']; ?>" style="display: none; margin-top: 10px;">
                        <form action="#" method="POST">
                            <input type="hidden" id="parent_comment_id" name="parent_comment_id"
                                value="<?php echo $row['id']; ?>">
                            <div class="form-group">
                                <label for="reply">Your Reply *</label>
                                <textarea id="reply" cols="30" rows="2" class="form-control" name="reply" required></textarea>
                            </div>
                            <div class="form-group mb-0">
                                <input type="submit" value="Post Reply" class="btn btn-primary font-weight-semi-bold py-2 px-3"
                                    name="sub_reply">
                            </div>
                        </form>
                    </div>

                    <!-- Display Replies -->
                    <?php
                    // Fetch replies for this comment
                    $parent_comment_id = $row['id'];
                    $sql_replies = "SELECT blog_form.*, user.Name FROM blog_form 
                                    JOIN user ON blog_form.user_id = user.UserID 
                                    WHERE blog_id = $blog_id AND parent_comment_id = $parent_comment_id 
                                    ORDER BY created_at DESC";
                    $result_replies = mysqli_query($conn, $sql_replies);

                    if (!$result_replies) {
                        echo "<script>alert('Error fetching replies: " . mysqli_error($conn) . "');</script>";
                    } else {
                        while ($reply = mysqli_fetch_array($result_replies)) {
                            ?>
                            <div class="border p-3 mt-3">
                                <p><strong><?php echo $reply['Name']; ?></strong> -
                                    <?php echo date('F j, Y, g:i a', strtotime($reply['created_at'])); ?>
                                </p>
                                <p><?php echo nl2br($reply['comment']); ?></p>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
                <?php
            }
        }
        ?>
    </div>
    <!-- Comments List End -->
</div>

<script>
function showReplyForm(commentId) {
    var replyForm = document.getElementById('replyForm' + commentId);
    if (replyForm.style.display === 'none') {
        replyForm.style.display = 'block';
    } else {
        replyForm.style.display = 'none';
    }
}
</script>

<?php require "footer.php"; ?>
