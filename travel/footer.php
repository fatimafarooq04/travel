<!-- Footer Start -->
<div class="container-fluid bg-dark text-white-50 py-5 px-sm-3 px-lg-5" style="margin-top: 90px;">
    <div class="row pt-5">
        <div class="col-lg-3 col-md-6 mb-5">
            <a href="" class="navbar-brand">
                <h1 class="text-primary"><span class="text-white">TRAVEL</span>ER</h1>
            </a>
            <p>"Discover your next adventure with TravelExplorer! Our site offers detailed guides on top destinations, budget tips, and hotel options to help you plan the perfect trip."</p>
            <h6 class="text-white text-uppercase mt-4 mb-3" style="letter-spacing: 5px;">Follow Us</h6>
            <div class="d-flex justify-content-start">
                <a class="btn btn-outline-primary btn-square mr-2" href="https://www.twitter.com/"><i class="fab fa-twitter"></i></a>
                <a class="btn btn-outline-primary btn-square mr-2" href="https://www.facebook.com/"><i class="fab fa-facebook-f"></i></a>
                <a class="btn btn-outline-primary btn-square mr-2" href="https://pk.linkedin.com/"><i class="fab fa-linkedin-in"></i></a>
                <a class="btn btn-outline-primary btn-square" href="https://www.instagram.com/"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-5">
            <h5 class="text-white text-uppercase mb-4" style="letter-spacing: 5px;">Our Services</h5>
            <div class="d-flex flex-column justify-content-start">
                <a class="text-white-50 mb-2" href="about.php"><i class="fa fa-angle-right mr-2"></i>About</a>
                <a class="text-white-50 mb-2" href="destination.php"><i class="fa fa-angle-right mr-2"></i>Destination</a>
                <a class="text-white-50 mb-2" href="hotel.php"><i class="fa fa-angle-right mr-2"></i>Hotel Packages</a>
                <a class="text-white-50 mb-2" href="tour.php"><i class="fa fa-angle-right mr-2"></i>Tour Packages</a>
                <a class="text-white-50" href="blog.php"><i class="fa fa-angle-right mr-2"></i>Blog</a>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-5">
            <h5 class="text-white text-uppercase mb-4" style="letter-spacing: 5px;">Contact Us</h5>
            <p><i class="fa fa-map-marker-alt mr-2"></i>Block-C Nazimabad, Karachi, Pakistan.</p>
            <p><i class="fa fa-phone-alt mr-2"></i>+92313 2147483</p>
            <p><i class="fa fa-envelope mr-2"></i>travelinfo@gmail.com</p>
        </div>

        <div class="col-lg-3 col-md-6 mb-5">
            <h6 class="text-white text-uppercase mt-4 mb-3" style="letter-spacing: 5px;">Newsletter</h6>
            <div class="w-100">
                <form action="newsaction.php" method="POST">
                    <div class="input-group">
                        <input type="email" name="new_mail" class="form-control border-light" style="padding: 25px;" placeholder="Your Email" required>
                        <div class="input-group-append">
                            <button class="btn btn-primary px-3" type="submit" name="sub">Send</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid bg-dark text-white border-top py-4 px-sm-3 px-md-5" style="border-color: rgba(256, 256, 256, .1) !important;">
    <div class="row">
        <div class="col-lg-6 text-center text-md-left mb-3 mb-md-0">
            <p class="m-0 text-white-50">Copyright &copy; <a href="#">Traveler</a>. All Rights Reserved.</p>
        </div>
        <div class="col-lg-6 text-center text-md-right">
            <p class="m-0 text-white-50">Designed by <a href="https://travel.com">TRAVELER</a></p>
        </div>
    </div>
</div>
<!-- Footer End -->

<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
<script src="lib/easing/easing.min.js"></script>
<script src="lib/owlcarousel/owl.carousel.min.js"></script>
<script src="lib/tempusdominus/js/moment.min.js"></script>
<script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
<script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

<!-- Template Javascript -->
<script src="js/main.js"></script>

<script src="path_to_jquery.js"></script>
    <script src="path_to_datetimepicker_js.js"></script>
    <script>
        $(document).ready(function(){
            $('#date1').datetimepicker({
                format: 'L'
            });
            $('#date2').datetimepicker({
                format: 'L'
            });
        });
    </script>
</body>
</html>
