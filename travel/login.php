<?php 
session_start();
require "connection.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style/style.css">
    <title>Login</title>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h2>Login</h2>
                    </div>
                    <div class="card-body">
                        <?php 
                           if(isset($_POST['submit'])){
                                $email = mysqli_real_escape_string($conn, $_POST['email']);
                                $password = mysqli_real_escape_string($conn, $_POST['password']);

                                $result = mysqli_query($conn, "SELECT * FROM user WHERE Email='$email' AND Password='$password'") or die("Select Error");
                                $row = mysqli_fetch_assoc($result);

                                if(is_array($row) && !empty($row)){
                                    $_SESSION['valid'] = $row['Email'];
                                    $_SESSION['name'] = $row['Name'];
                                    $_SESSION['phone'] = $row['Phone'];
                                    $_SESSION['UserID'] = $row['UserID']; // Set the session variable for UserID
                                    $_SESSION['Email'] = $row['Email']; // Store the email address in the session
                                    header("Location: index.php");
                                    exit();
                                } else {
                                    echo "<div class='alert alert-danger' role='alert'>
                                              Wrong Email or Password
                                          </div>";
                                    echo "<a href='index.php' class='btn btn-secondary'>Go Back</a>";
                                }
                            } else {
                        ?>
                        <form action="" method="post">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" class="form-control" autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" class="form-control" autocomplete="off" required>
                            </div>
                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-success" name="submit">Login</button>
                            </div>
                            <div class="form-group text-center">
                                Don't have an account? <a href="signup.php">Sign Up Now</a>
                            </div>
                        </form>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>