<?php
session_start();

// Check if user is logged in and role is admin
if (isset($_SESSION['Role']) && $_SESSION['Role'] == "Admin") {
    // Include your database connection file
    include('connection.php');

    // Fetch admin details from the database
    $adminID = $_SESSION['AdminID'];
    $query = "SELECT `AdminID`, `Name`, `Email`, `Phone` FROM `admin_user` WHERE `AdminID` = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $adminID);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();
    
    // Assign values to variables
    $name = htmlspecialchars($admin['Name']);
    $email = htmlspecialchars($admin['Email']);
    $phone = htmlspecialchars($admin['Phone']);
} else {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Edit Profile</title>
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
        .alert {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="content">
        <div class="container-fluid">
            <div class="centered-content">
                <h2 class="profile-header">Edit Profile</h2>

                <?php if (isset($_SESSION['message'])): ?>
                    <div class="alert alert-info">
                        <?php
                        echo $_SESSION['message'];
                        unset($_SESSION['message']);
                        ?>
                    </div>
                <?php endif; ?>

                <div class="card">
                    <div class="card-body">
                        <form action="update_profile.php" method="POST">
                            <input type="hidden" name="AdminID" value="<?php echo $adminID; ?>">
                            <div class="form-group">
                                <label for="Name">Name</label>
                                <input type="text" class="form-control" id="Name" name="Name" value="<?php echo $name; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="Email">Email</label>
                                <input type="email" class="form-control" id="Email" name="Email" value="<?php echo $email; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="Phone">Phone</label>
                                <input type="text" class="form-control" id="Phone" name="Phone" value="<?php echo $phone; ?>" required>
                            </div>
                            <button type="submit" class="btn btn-primary mt-3">Update Profile</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
