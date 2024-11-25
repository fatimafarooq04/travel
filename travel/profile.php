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

// Check if user data is found
if (!$user) {
    echo "<div class='alert alert-danger' role='alert'>User not found!</div>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
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
        table {
            margin-bottom: 0;
        }
        th {
            background-color: #e9ecef;
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
                        <h2>My Profile</h2>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th>Name</th>
                                    <td><?php echo htmlspecialchars($user['Name']); ?></td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td><?php echo htmlspecialchars($user['Email']); ?></td>
                                </tr>
                                <tr>
                                    <th>Phone</th>
                                    <td><?php echo htmlspecialchars($user['Phone']); ?></td>
                                </tr>
                                <tr>
                                    <th>Role</th>
                                    <td><?php echo htmlspecialchars($user['Role']); ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="text-center">
                            <a href="edit_profile.php" class="btn btn-custom">Update Profile</a>
                            <a href="index.php" class="btn btn-back">Back</a>
                        </div>
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
