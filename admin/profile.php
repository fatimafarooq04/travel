<?php
session_start();

// Check if user is logged in and role is admin
if (isset($_SESSION['Role']) && $_SESSION['Role'] == "Admin") {
    // Include your database connection file
    include('connection.php');

    // Fetch admin details from the database
    $adminID = $_SESSION['AdminID']; // Assuming you store AdminID in the session
    $query = "SELECT `AdminID`, `Name`, `Email`, `Password`, `Phone`, `Role` FROM `admin_user` WHERE `AdminID` = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $adminID);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();
    
    // Assign values to variables
    $name = htmlspecialchars($admin['Name']);
    $email = htmlspecialchars($admin['Email']);
    $phone = htmlspecialchars($admin['Phone']);
    $role = htmlspecialchars($admin['Role']);
} else {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Admin Profile</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <style>
        .centered-content {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .profile-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .card {
            margin-top: 20px;
        }
        .btn-container {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="content">
        <div class="container-fluid">
            <div class="centered-content">
                <h2 class="profile-header">Admin Profile</h2>
                <div class="card">
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <th>ID</th>
                                <td><?php echo $adminID; ?></td>
                            </tr>
                            <tr>
                                <th>Name</th>
                                <td><?php echo $name; ?></td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td><?php echo $email; ?></td>
                            </tr>
                            <tr>
                                <th>Phone</th>
                                <td><?php echo $phone; ?></td>
                            </tr>
                            <tr>
                                <th>Role</th>
                                <td><?php echo $role; ?></td>
                            </tr>
                        </table>
                        <div class="btn-container">
                            <a href="edit_profile.php" class="btn btn-primary">Edit Profile</a>
                            <a href="index.php" class="btn btn-secondary">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
