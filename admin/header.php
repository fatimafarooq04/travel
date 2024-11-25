<?php
session_start();

// Check if user is logged in and role is admin
if (isset($_SESSION['Role']) && $_SESSION['Role'] == "Admin") {
    // Include your database connection file
    include('connection.php');

    // Ensure AdminID is set in the session
    if (isset($_SESSION['AdminID'])) {
        $adminID = $_SESSION['AdminID']; // Assuming you store AdminID in the session
        $query = "SELECT `Name`, `Email` FROM `admin_user` WHERE `AdminID` = ?";
        $stmt = $conn->prepare($query);

        if ($stmt) {
            $stmt->bind_param("i", $adminID);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
                $name = $user['Name'];
                $email = $user['Email'];
            } else {
                // Handle case where no user is found
                $name = "Unknown";
                $email = "Unknown";
            }
        } else {
            // Handle query preparation error
            $name = "Error";
            $email = "Error";
        }
    } else {
        // Handle case where AdminID is not set
        $name = "Error";
        $email = "Error";
    }
} else {
    header("Location: login.php");
    exit();
}
?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Travel Admin Dashboard</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href="assets/img/flight.jpg" type="image/x-icon" />

    <!-- Fonts and icons -->
    <script src="assets/js/plugin/webfont/webfont.min.js"></script>
    <script>
      WebFont.load({
        google: {
          families: ["Public Sans:300,400,500,600,700"]
        },
        custom: {
          families: [
            "Font Awesome 5 Solid",
            "Font Awesome 5 Regular",
            "Font Awesome 5 Brands",
            "simple-line-icons",
          ],
          urls: ["assets/css/fonts.min.css"],
        },
        active: function () {
          sessionStorage.fonts = true;
        },
      });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/plugins.min.css" />
    <link rel="stylesheet" href="assets/css/kaiadmin.min.css" />


  </head>

  <body>
    <div class="wrapper">
      <!-- Sidebar -->
      <div class="sidebar" data-background-color="dark">
        <div class="sidebar-logo">
          <!-- Logo Header -->
          <div class="logo-header" data-background-color="green">
            <a href="index.php" class="logo">
              <h1 style="color: white;">Traveler</h1>
            </a>
            <div class="nav-toggle">
              <button class="btn btn-toggle toggle-sidebar">
                <i class="gg-menu-right"></i>
              </button>
              <button class="btn btn-toggle sidenav-toggler">
                <i class="gg-menu-left"></i>
              </button>
            </div>
            <button class="topbar-toggler more">
              <i class="gg-more-vertical-alt"></i>
            </button>
          </div>
          <!-- End Logo Header -->
        </div>
        <div class="sidebar-wrapper scrollbar scrollbar-inner">
          <div class="sidebar-content">
            <ul class="nav nav-secondary">
              <li class="nav-item active">
                <a data-bs-toggle="collapse" href="#dashboard" class="collapsed" aria-expanded="false">
                  <i class="fas fa-home"></i>
                  <p>Dashboard</p>
                </a>

              </li>
              <!-- City -->
              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#City">
                  <i class="fas fa-map-marker-alt"></i>
                  <p>City</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="City">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="city.php">
                        <span class="sub-item">Add City</span>
                      </a>
                    </li>
                    <li>
                      <a href="cityshow.php">
                        <span class="sub-item">Show City</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
              <!-- destination -->
              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#destination">
                  <i class="fas fa-map-marker-alt"></i>
                  <p>Destination</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="destination">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="destination.php">
                        <span class="sub-item">Add Destination</span>
                      </a>
                    </li>
                    <li>
                      <a href="destinationshow.php">
                        <span class="sub-item">Show Destination</span>
                      </a>
                    </li>
                    <li>
                      <a href="destinationcomment.php">
                        <span class="sub-item">Show Destination Comments</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>

              <!-- hotels -->
              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#hotels">
                  <i class="fas fa-map-marker-alt"></i>
                  <p>Hotels</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="hotels">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="facilityadd.php">
                        <span class="sub-item">Add Facilities</span>
                      </a>
                    </li>
                    <li>
                      <a href="facilityshow.php">
                        <span class="sub-item">Show Facilities</span>
                      </a>
                    </li>

                    <li>
                      <a href="hotels.php">
                        <span class="sub-item">Add Hotels</span>
                      </a>
                    </li>
                    <li>
                      <a href="hotelshow.php">
                        <span class="sub-item">Show Hotels</span>
                      </a>
                    </li>
                    <li>
                      <a href="roomtypes.php">
                        <span class="sub-item">Add Room_Types</span>
                      </a>
                    </li>
                    <li>
                      <a href="roomstypesshow.php">
                        <span class="sub-item">Show Room_Types</span>
                      </a>
                    </li>
                    <!-- <li>
                      <a href="room.php">
                        <span class="sub-item">Add Rooms</span>
                      </a>
                    </li>
                    <li>
                      <a href="roomshow.php">
                        <span class="sub-item">Show Rooms</span>
                      </a>
                    </li> -->
                    <li>
                      <a href="table.php">
                        <span class="sub-item">Add Table</span>
                      </a>
                    </li>
                    <li>
                      <a href="tableshow.php">
                        <span class="sub-item">Show Table_Info</span>
                      </a>
                    </li>
                    <li>
                      <a href="show_hotelbooking.php">
                        <span class="sub-item">Show Hotel Booking</span>
                      </a>
                    </li>
                    <li>
                      <a href="h_bookingcancellation.php">
                        <span class="sub-item">Show Cancel H_Bookings</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>


              <!-- tour card -->
              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#card">
                  <i class="fas fa-map-marker-alt"></i>
                  <p>Packages</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="card">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="addday.php">
                        <span class="sub-item">Add days</span>
                      </a>
                    </li>
                    <li>
                      <a href="showday.php">
                        <span class="sub-item">Show days</span>
                      </a>
                    </li>
                    <li>
                      <a href="touradd.php">
                        <span class="sub-item">Add packages</span>
                      </a>
                    </li>
                    <li>
                      <a href="tourshow.php">
                        <span class="sub-item">Show packages</span>
                      </a>
                    </li>
                    <li>
                      <a href="packagedate.php">
                        <span class="sub-item">Add dates for package</span>
                      </a>
                    </li>
                    <li>
                      <a href="packagedateshow.php">
                        <span class="sub-item">Show dates for packages</span>
                      </a>
                    </li>
                    <li>
                      <a href="itinerary.php">
                        <span class="sub-item">Add Itinerary</span>
                      </a>
                    </li>
                    <li>
                      <a href="itineraryshow.php">
                        <span class="sub-item">show Itinerary</span>
                      </a>
                    </li>
                    <li>
                      <a href="packagebookingshow.php">
                        <span class="sub-item">show package booking</span>
                      </a>
                    </li>
                    <li>
                      <a href="p_bookingcancellation.php">
                        <span class="sub-item">Show Cancel P_Booking</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>

              <!-- about us  -->
              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#about">
                  <i class="fas fa-map-marker-alt"></i>
                  <p>About Us</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="about">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="aboutshow.php">
                        <span class="sub-item">Show About Us</span>
                      </a>
                    </li>
                    <li>
                      <a href="teamadd.php">
                        <span class="sub-item">Add Team Info</span>
                      </a>
                    </li>
                    <li>
                      <a href="teamshow.php">
                        <span class="sub-item">Show Team Info</span>
                      </a>
                    </li>
                    <li>
                      <a href="faqadd.php">
                        <span class="sub-item">Add FAQs</span>
                      </a>
                    </li>
                    <li>
                      <a href="faqshow.php">
                        <span class="sub-item">Show FAQs</span>
                      </a>
                    </li>
                  </ul>
                </div>

              </li>


              <!-- blogs -->
              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#blog">
                  <i class="fas fa-map-marker-alt"></i>
                  <p>Blog</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="blog">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="blogadd.php">
                        <span class="sub-item">Add Blog</span>
                      </a>
                    </li>
                    <li>
                      <a href="blogshow.php">
                        <span class="sub-item">Show Blog</span>
                      </a>
                    </li>
                    <li>
                      <a href="blogformshow.php">
                        <span class="sub-item">Show Blog Comments</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>


              <!-- services -->
              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#Service">
                  <i class="fas fa-map-marker-alt"></i>
                  <p>Service</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="Service">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="serviceadd.php">
                        <span class="sub-item">Add Service</span>
                      </a>
                    </li>
                    <li>
                      <a href="serviceshow.php">
                        <span class="sub-item">Show Service</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>

              <!-- contact -->
              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#contact">
                  <i class="fas fa-map-marker-alt"></i>
                  <p>Contact</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="contact">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="contactshow.php">
                        <span class="sub-item">Show Contact</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
              <!-- user/admin -->
              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#user">
                  <i class="fas fa-map-marker-alt"></i>
                  <p>User/Admin</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="user">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="adminadd.php">
                        <span class="sub-item">Add Admin</span>
                      </a>
                      <a href="adminshow.php">
                        <span class="sub-item">Show Admin</span>
                      </a>
                      <a href="usershow.php">
                        <span class="sub-item">Show User</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
              <!-- news -->
              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#news">
                  <i class="fas fa-map-marker-alt"></i>
                  <p>News Letter</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="news">
                  <ul class="nav nav-collapse">
                    <li>
                        <a href="shownews.php">
                        <span class="sub-item">Show Newsletter</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <!-- End Sidebar -->

      <div class="main-panel">
        <div class="main-header">
          <div class="main-header-logo">
            <!-- Logo Header -->
            <div class="logo-header" data-background-color="dark">
              <a href="index.php" class="logo">
                <img src="assets/img/kaiadmin/logo_light.svg" alt="navbar brand" class="navbar-brand" height="20" />
              </a>
              <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                  <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                  <i class="gg-menu-left"></i>
                </button>
              </div>
              <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
              </button>
            </div>
            <!-- End Logo Header -->
          </div>
          <!-- Navbar Header -->
          <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
            <div class="container-fluid">


            <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
    <li class="nav-item topbar-user dropdown hidden-caret">
        <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#" aria-expanded="false">
        <div class="avatar-sm">
                      <img src="assets/img/random.jpg" alt="..." class="avatar-img rounded-circle" />
                    </div>
            <span class="profile-username">
            
                <span class="fw-bold"><?php echo htmlspecialchars($name); ?></span>
             
            </span>
        </a>
        <ul class="dropdown-menu dropdown-user animated fadeIn">
            <div class="dropdown-user-scroll scrollbar-outer">
                <li>
                    <div class="user-box">
                        <div class="avatar-lg">
                            <img src="assets/img/random.jpg" alt="image profile" class="avatar-img rounded" />
                        </div>
                        <div class="u-text">
                            <h4><?php echo htmlspecialchars($name); ?></h4>
                            <p class="text-muted"><?php echo htmlspecialchars($email); ?></p>
                            <a href="profile.php" class="btn btn-xs btn-secondary btn-sm">View Profile</a>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="logout.php">Logout</a>
                </li>
            </div>
        </ul>
    </li>
</ul>
            </div>
          </nav>
          <!-- End Navbar -->
        </div>
    </body>
    </html>