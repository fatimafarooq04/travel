<?php
session_start();
require 'connection.php';

// Check if the user is logged in
if (!isset($_SESSION['valid'])) {
    header('Location: login.php');
    exit();
}

// Fetch user details from the database
$userEmail = $_SESSION['valid'];
$result = mysqli_query($conn, "SELECT * FROM user WHERE Email='$userEmail'") or die("Select Error");
$user = mysqli_fetch_assoc($result);

// Handle form submission
if (isset($_POST['update'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    // Update query
    $query = "UPDATE user SET Name='$name', Phone='$phone'";
    if (!empty($password)) {
        $password = password_hash($password, PASSWORD_BCRYPT); // Hash the password
        $query .= ", Password='$password'";
    }
    $query .= " WHERE Email='$userEmail'";
    
    if (mysqli_query($conn, $query)) {
        echo "<script>
                alert('Profile updated successfully!');
                window.location.href = 'profile.php';
              </script>";
    } else {
        echo "<script>
                alert('Error updating profile!');
                window.location.href = 'edit_profile.php';
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style/style.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .card-header {
            background-color: #343a40;
            color: #fff;
            border-bottom: 0;
            border-radius: 8px 8px 0 0;
        }
        .card-body {
            padding: 2rem;
        }
        .btn-custom {
            background-color: #007bff;
            color: #fff;
            border: none;
        }
        .btn-custom:hover {
            background-color: #0056b3;
            color: #fff;
        }
        .btn-back {
            background-color: #6c757d;
            color: #fff;
        }
        .btn-back:hover {
            background-color: #5a6268;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center">
                        <h2>Edit Profile</h2>
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control" value="<?php echo htmlspecialchars($user['Name']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="text" name="phone" id="phone" class="form-control" value="<?php echo htmlspecialchars($user['Phone']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password (Leave blank to keep current)</label>
                                <input type="password" name="password" id="password" class="form-control">
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-custom" name="update">Update Profile</button>
                                <a href="profile.php" class="btn btn-back">Back</a>
                            </div>
                        </form>
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
