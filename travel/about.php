<?php
require "header.php";
?>

<!-- Header Start -->
<div class="container-fluid page-header">
    <div class="container">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 400px">
            <h3 class="display-4 text-white text-uppercase">About</h3>
            <div class="d-inline-flex text-white">
                <p class="m-0 text-uppercase"><a class="text-white" href="">Home</a></p>
                <i class="fa fa-angle-double-right pt-1 px-3"></i>
                <p class="m-0 text-uppercase">About</p>
            </div>
        </div>
    </div>
</div>
<!-- Header End -->

<!-- About Start -->
<div class="container-fluid py-5">
    <div class="container pt-5">
        <div class="row">
            <?php 
            $qry="SELECT * FROM `about_us`";
            $res=mysqli_query($conn, $qry);
            while($row=  mysqli_fetch_assoc($res)){
            ?>
            <div class="col-lg-6 fade-in-up">
                <div class="position-relative h-100">
                    <img class="position-absolute w-100 h-100" src="../admin/<?php echo $row['about_img'] ?>" style="object-fit: cover;">
                </div>
            </div>
            <div class="col-lg-6 pt-5 pb-lg-5 fade-in-up">
                <div class="about-text bg-white p-4 p-lg-5 my-lg-5">
                    <h6 class="text-primary text-uppercase" style="letter-spacing: 5px;"><?php echo $row['about_head'] ?></h6>
                    <h1 class="mb-3"><?php echo $row['about_subhead'] ?></h1>
                    <p><?php echo $row['about_text'] ?></p>
                    <div class="row mb-4">
                        <div class="col-6">
                            <img class="img-fluid" src="../admin/<?php echo $row['about_img2'] ?>" alt="">
                        </div>
                        <div class="col-6">
                            <img class="img-fluid" src="../admin/<?php echo $row['about_img3'] ?>" alt="">
                        </div>
                    </div>
                </div>
            </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>
<!-- About End -->

<!-- Team Start -->
<div class="container-fluid py-5">
    <div class="container pt-5 pb-3">
        <div class="text-center mb-3 pb-3 fade-in-up">
            <h6 class="text-primary text-uppercase" style="letter-spacing: 5px;">Guides</h6>
            <h1>Our Travel Guides</h1>
        </div>
        <div class="row">
            <?php 
            $qry="SELECT * FROM `team_info`";
            $res=mysqli_query($conn, $qry);
            while($row=  mysqli_fetch_assoc($res)){
            ?>
            <div class="col-lg-3 col-md-4 col-sm-6 pb-1 fade-in-up">
                <div class="team-item bg-white mb-4">
                    <div class="team-img position-relative overflow-hidden">
                        <img class="img-fluid w-100" src="../admin/<?php echo $row['team_img'] ?>" alt="">
                        <div class="team-social">
                            <a class="btn btn-outline-primary btn-square" href=""><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-outline-primary btn-square" href=""><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-outline-primary btn-square" href=""><i class="fab fa-instagram"></i></a>
                            <a class="btn btn-outline-primary btn-square" href=""><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                    <div class="text-center py-4">
                        <h5 class="text-truncate"><?php echo $row['team_name'] ?></h5>
                        <p class="m-0"><?php echo $row['team_desc'] ?></p>
                    </div>
                </div>
            </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>
<!-- Team End -->

<!-- FAQs Start -->
<div class="text-center mb-3 pb-3 fade-in-up">
    <h6 class="text-primary text-uppercase" style="letter-spacing: 5px;">FAQs</h6>
    <h1>Frequently Asked Questions</h1>
</div>
<div class="container">
    <section class="faq-section">
        <?php 
        $qry="SELECT * FROM `faqs`";
        $res=mysqli_query($conn, $qry);
        while($row=  mysqli_fetch_assoc($res)){
        ?>
        <details class="faq-item">
            <summary><?php echo $row['faq_ques'] ?></summary>
            <p><?php echo $row['faq_ans'] ?></p>
        </details>
        <?php
        }
        ?>
    </section>
</div>
<!-- FAQs End -->

<?php 
require "footer.php";
?>

<!-- Add CSS for Animations -->
<style>
  /* FAQ Section Styles */
.faq-section {
    margin: 30px 0;
}

.faq-item {
    margin-bottom: 15px;
    background-color: #f9f9f9;
    border-radius: 8px;
    padding: 15px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease-in-out;
}

.faq-item summary {
    font-weight: bold;
    font-size: 18px;
    cursor: pointer;
    padding: 10px 0;
    color: #333;
    list-style: none;
    position: relative;
}

.faq-item summary::-webkit-details-marker {
    display: none;
}

.faq-item summary:before {
    content: "\f067"; /* FontAwesome plus icon */
    font-family: "Font Awesome 5 Free";
    font-weight: 900;
    margin-right: 10px;
    transition: transform 0.3s ease-in-out, color 0.3s ease-in-out;
}

.faq-item[open] summary:before {
    content: "\f068"; /* FontAwesome minus icon */
    transform: rotate(180deg);
    color: #007bff;
}

.faq-item p {
    margin-top: 10px;
    line-height: 1.6;
    color: #555;
    padding: 0 10px;
    transition: max-height 0.3s ease-in-out, opacity 0.3s ease-in-out;
    max-height: 0;
    overflow: hidden;
    opacity: 0;
}

.faq-item[open] p {
    max-height: 500px; /* Adjust as needed */
    opacity: 1;
}

.faq-item[open] {
    background-color: #fff;
    border-left: 4px solid #007bff;
}

.faq-item:hover {
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
}

/* Responsive Design for Smaller Screens */
@media (max-width: 576px) {
    .faq-item summary {
        font-size: 16px;
    }

    .faq-item p {
        font-size: 14px;
    }
}

/* CSS Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(50px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.fade-in-up {
    opacity: 0;
    animation: fadeInUp 1s ease-out forwards;
}
</style>

<!-- Add JavaScript to Trigger Animations on Scroll -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const fadeElements = document.querySelectorAll('.fade-in-up');

    function handleScroll() {
        fadeElements.forEach(element => {
            const rect = element.getBoundingClientRect();
            const isVisible = rect.top <= window.innerHeight && rect.bottom >= 0;
            if (isVisible) {
                element.classList.add('fade-in-up');
            }
        });
    }

    window.addEventListener('scroll', handleScroll);
    handleScroll(); // Trigger on load in case elements are already in view
});
</script>
