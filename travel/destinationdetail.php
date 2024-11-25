<?php
require "header.php";
require "connection.php"; // Database connection

// Function to check and retrieve destination ID
function getDestinationId() {
    if (isset($_GET['id'])) {
        return $_GET['id'];
    } else {
        echo "<script>
                alert('No destination ID provided.');
                window.location.href ='index.php'; // Redirect to homepage or a default page
              </script>";
        exit;
    }
}

// Handle posting new comment
if (isset($_POST['sub'])) {
    $comment = mysqli_real_escape_string($conn, $_POST['comment']);
    $destination_id = getDestinationId();

    if (isset($_SESSION['UserID'])) {
        $user_id = $_SESSION['UserID'];

        if (!empty($comment)) {
            $sql = "INSERT INTO destination_comments (destination_id, user_id, comment, created_at) 
                    VALUES ('$destination_id', '$user_id', '$comment', NOW())";
            if (mysqli_query($conn, $sql)) {
                echo "<script>
                        alert('Comment posted successfully.');
                        window.location.href ='destinationdetail.php?id=$destination_id';
                      </script>";
            } else {
                echo "<script>
                        alert('Error posting comment: " . mysqli_error($conn) . "');
                        window.location.href ='destinationdetail.php?id=$destination_id';
                      </script>";
            }
        } else {
            echo "<script>
                    alert('Comment cannot be empty.');
                    window.location.href ='destinationdetail.php?id=$destination_id';
                  </script>";
        }
    } else {
        echo "<script>
                alert('Please log in to leave a comment.');
                window.location.href ='login.php'; // Redirect to login page
              </script>";
    }
}

// Handle posting reply
if (isset($_POST['sub_reply'])) {
    $reply = mysqli_real_escape_string($conn, $_POST['reply']);
    $parent_comment_id = $_POST['parent_comment_id'];
    $destination_id = getDestinationId();

    if (isset($_SESSION['UserID']) && !empty($reply) && !empty($parent_comment_id)) {
        $user_id = $_SESSION['UserID'];

        $sql = "INSERT INTO destination_comments (comment, destination_id, user_id, created_at, parent_comment_id) 
                VALUES ('$reply', '$destination_id', '$user_id', NOW(), '$parent_comment_id')";
        if (mysqli_query($conn, $sql)) {
            echo "<script>
                    alert('Reply posted successfully.');
                    window.location.href ='destinationdetail.php?id=$destination_id';
                  </script>";
        } else {
            echo "<script>
                    alert('Error posting reply: " . mysqli_error($conn) . "');
                    window.location.href ='destinationdetail.php?id=$destination_id';
                  </script>";
        }
    } else {
        echo "<script>
                alert('Please log in to reply.');
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Destination Detail</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <!-- Header Start -->
    <div class="container-fluid page-header">
        <div class="container">
            <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 400px">
                <h3 class="display-4 text-white text-uppercase">Destination Detail</h3>
                <div class="d-inline-flex text-white">
                    <p class="m-0 text-uppercase"><a class="text-white" href="index.php">Home</a></p>
                    <i class="fa fa-angle-double-right pt-1 px-3"></i>
                    <p class="m-0 text-uppercase">Destination Detail</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Header End -->

    <div class="container mt-5">
        <?php
        // Get the destination ID
        $destination_id = getDestinationId();

        // Fetch destination details
        $sql = "SELECT destination.*, city.CityName FROM `destination` 
                JOIN `city` ON destination.CityID = city.CityID WHERE `DestinationID` = $destination_id";
        $result = mysqli_query($conn, $sql);

        if ($row = mysqli_fetch_array($result)) {
            $description_paragraphs = explode("\n", $row['Description']);
            $images = ['Image1' => $row['Image1'], 'Image2' => $row['Image2'], 'Image3' => $row['Image3']];
            $cardImage = $row['CardImage'];
            $filteredImages = array_values(array_filter($images, fn($image) => $image != $cardImage));

            if (count($filteredImages) < 2) {
                echo "<p class='text-center'>Not enough images available for this destination.</p>";
                exit;
            }
            ?>
            <h1 class="text-center"><?php echo $row['Name']; ?> Destination Detail</h1>
            <div class="content-wrapper">
                <div class="main-content">
                    <?php
                    echo '<p>' . $description_paragraphs[0] . '</p>';
                    echo '<img src="../admin/' . $filteredImages[0] . '" alt="Image 1">';
                    for ($i = 1; $i < count($description_paragraphs); $i++) {
                        echo '<p>' . $description_paragraphs[$i] . '</p>';
                    }
                    echo '<img src="../admin/' . $filteredImages[1] . '" alt="Image 2">';
                    ?>
                </div>
                <div class="sidebar">
                    <p><strong>Destination Name:</strong> <?php echo $row['Name']; ?></p>
                    <p><strong>Country:</strong> <?php echo $row['Country']; ?></p>
                    <p><strong>State:</strong> <?php echo $row['State']; ?></p>
                    <p><strong>Best Time to Visit:</strong> <?php echo $row['BestTimeToVisit']; ?></p>
                    <p><strong>City Name:</strong> <?php echo $row['CityName']; ?></p>
                </div>
            </div>
            <?php
        } else {
            echo "<p class='text-center'>No destination found with ID: $destination_id</p>";
        }
        ?>

        <!-- Comment Form Start -->
        <div class="bg-white mb-3" style="padding: 30px;">
            <h4 class="text-uppercase mb-4" style="letter-spacing: 5px;">Leave a comment</h4>
            <form action="#" method="POST">
                <div class="form-group">
                    <label for="message">Message *</label>
                    <textarea id="message" cols="30" rows="5" class="form-control" name="comment" required></textarea>
                </div>
                <div class="form-group mb-0">
                    <input type="submit" value="Leave a comment" class="btn btn-primary font-weight-semi-bold py-2 px-3" name="sub">
                </div>
            </form>
        </div>
        <!-- Comment Form End -->

        <!-- Comments List Start -->
        <div class="bg-white" style="padding: 30px; margin-top: 30px;">
            <h4 class="text-uppercase mb-4" style="letter-spacing: 5px;">Comments</h4>
            <?php
            // Fetch comments from the database
            $sql = "SELECT destination_comments.*, user.Name FROM destination_comments 
                    JOIN user ON destination_comments.user_id = user.UserID 
                    WHERE destination_id = $destination_id AND parent_comment_id IS NULL 
                    ORDER BY created_at DESC";
            $result = mysqli_query($conn, $sql);

            while ($row = mysqli_fetch_array($result)) {
                ?>
                <div class="border p-3 mb-3">
                    <p><strong><?php echo $row['Name']; ?></strong> - <?php echo date('F j, Y, g:i a', strtotime($row['created_at'])); ?></p>
                    <p><?php echo nl2br($row['comment']); ?></p>
                    <button class="btn btn-primary btn-sm reply-btn" data-comment-id="<?php echo $row['destination_id']; ?>">Reply</button>

                    <!-- Replies List Start -->
                    <?php
                    $parent_comment_id = $row['destination_id'];
                    $reply_sql = "SELECT destination_comments.*, user.Name FROM destination_comments 
                                  JOIN user ON destination_comments.user_id = user.UserID 
                                  WHERE parent_comment_id = $parent_comment_id 
                                  ORDER BY created_at DESC";
                    $reply_result = mysqli_query($conn, $reply_sql);

                    while ($reply_row = mysqli_fetch_array($reply_result)) {
                        ?>
                        <div class="border p-3 ml-5 mb-3">
                            <p><strong><?php echo $reply_row['Name']; ?></strong> - <?php echo date('F j, Y, g:i a', strtotime($reply_row['created_at'])); ?></p>
                            <p><?php echo nl2br($reply_row['comment']); ?></p>
                        </div>
                        <?php
                    }
                    ?>
                    <!-- Replies List End -->
                </div>
                <?php
            }
            ?>
        </div>
        <!-- Comments List End -->

        <!-- Reply Modal Start -->
        <div class="modal fade" id="replyModal" tabindex="-1" role="dialog" aria-labelledby="replyModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="#" method="POST">
                        <div class="modal-header">
                            <h5 class="modal-title" id="replyModalLabel">Leave a Reply</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="reply">Reply *</label>
                                <textarea id="reply" cols="30" rows="5" class="form-control" name="reply" required></textarea>
                            </div>
                            <input type="hidden" name="parent_comment_id" id="parent_comment_id">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" name="sub_reply">Post Reply</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Reply Modal End -->
    </div>

    <script>
        $(document).ready(function(){
            $(".reply-btn").click(function(){
                var commentId = $(this).data("comment-id");
                $("#parent_comment_id").val(commentId);
                $("#replyModal").modal("show");
            });
        });
    </script>
<?php
require "footer.php";
?>
