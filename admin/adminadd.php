<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style/style.css">
    <title>Register</title>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h2>Sign Up</h2>
                    </div>
                    <div class="card-body">
                        <?php 
                            include("connection.php");
                            if(isset($_POST['submit'])){
                                $name = $_POST['name'];
                                $email = $_POST['email'];
                                $phone = $_POST['phone'];
                                $password = $_POST['password'];
                                $role = 'Admin';  // default role

                                // Verifying the unique email
                                $verify_query = mysqli_query($conn, "SELECT Email FROM user WHERE Email='$email'");

                                if(mysqli_num_rows($verify_query) != 0 ){
                                    echo "<div class='alert alert-danger' role='alert'>
                                              This email is already used. Please try another one!
                                          </div>";
                                    echo "<a href='javascript:self.history.back()' class='btn btn-secondary'>Go Back</a>";
                                }
                                else{
                                    mysqli_query($conn, "INSERT INTO admin_user (Name, Email, Password, Phone, Role) VALUES('$name','$email','$password','$phone','$role')") or die("Error Occurred");

                                    echo "<div class='alert alert-success' role='alert'>
                                              Registration successful!
                                          </div>";
                                    echo "<a href='login.php' class='btn btn-primary'>Login Now</a>";
                                }
                            } else {
                        ?>
                        <form action="" method="post" onsubmit="return validateForm()">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control" autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" class="form-control" autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="text" name="phone" id="phone" class="form-control" autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" class="form-control" autocomplete="off" required>
                            </div>
                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-success" name="submit">Register</button>
                            </div>
                            <div class="form-group text-center">
                                Already a member? <a href="index.php">Sign In</a>
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
    <script>
        function validateForm() {
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const phone = document.getElementById('phone').value;

            const namePattern = /^[A-Za-z\s]+$/;
            const emailPattern = /^[a-zA-Z0-9._-]+@gmail\.com$/;
            const phonePattern = /^[0-9]{11}$/;

            if (!namePattern.test(name)) {
                alert("Name should contain only alphabets.");
                return false;
            }

            if (!emailPattern.test(email)) {
                alert("Email should be a valid Gmail address (e.g., user@gmail.com).");
                return false;
            }

            if (!phonePattern.test(phone)) {
                alert("Phone number should be exactly 11 digits.");
                return false;
            }

            return true;
        }
    </script>
</body>
</html>
