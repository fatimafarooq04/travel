<?php
require "header.php";
?>

<!-- Header Start -->
<div class="container-fluid page-header">
    <div class="container">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 400px">
            <h3 class="display-4 text-white text-uppercase">Contact</h3>
            <div class="d-inline-flex text-white">
                <p class="m-0 text-uppercase"><a class="text-white" href="">Home</a></p>
                <i class="fa fa-angle-double-right pt-1 px-3"></i>
                <p class="m-0 text-uppercase">Contact</p>
            </div>
        </div>
    </div>
</div>
<!-- Header End -->

<!-- Contact Start -->
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="text-center mb-3 pb-3">
            <h6 class="text-primary text-uppercase" style="letter-spacing: 5px;">Contact</h6>
            <h1>Contact For Any Query</h1>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="contact-form bg-white" style="padding: 30px;">
                    <div id="success"></div>

                    <form action="contactaction.php" method="POST" name="sentMessage" id="contactForm" novalidate="novalidate">
                        <div class="form-row">
                            <div class="control-group col-sm-6">
                                <div class="input-group">
                                    <input type="text" class="form-control p-4 input-field" id="name" name="name" placeholder=" " required="required" data-validation-required-message="Please enter your name" />
                                    <label for="name">Your Name</label>
                                </div>
                                <p class="help-block text-danger"></p>
                            </div>
                            <div class="control-group col-sm-6">
                                <div class="input-group">
                                    <input type="email" class="form-control p-4 input-field" id="email" name="mail" placeholder=" " required="required" data-validation-required-message="Please enter your email" />
                                    <label for="email">Your Email</label>
                                </div>
                                <p class="help-block text-danger"></p>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="input-group">
                                <input type="text" class="form-control p-4 input-field" id="subject" name="sub" placeholder=" " required="required" data-validation-required-message="Please enter a subject" />
                                <label for="subject">Subject</label>
                            </div>
                            <p class="help-block text-danger"></p>
                        </div>
                        <div class="control-group">
                            <div class="input-group">
                                <textarea class="form-control py-3 px-4 input-field" rows="5" id="message" name="msg" placeholder=" " required="required" data-validation-required-message="Please enter your message"></textarea>
                                <label for="message">Message</label>
                            </div>
                            <p class="help-block text-danger"></p>
                        </div>
                        <div class="text-center">
                            <button class="btn btn-primary py-3 px-4" type="submit" id="sendMessageButton">Send Message</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- Contact End -->

<script>
    document.getElementById('contactForm').addEventListener('submit', function(event) {
        event.preventDefault();

        var name = document.getElementById('name').value;
        var email = document.getElementById('email').value;
        var subject = document.getElementById('subject').value;
        var message = document.getElementById('message').value;
        var valid = true;

        // Name validation: alphabets only
        if (!/^[A-Za-z\s]+$/.test(name)) {
            alert('Name must contain only alphabets.');
            valid = false;
        }

        // Email validation: specific domains only
        if (!/^[a-zA-Z0-9._%+-]+@(gmail\.com|yahoo\.com|hotmail\.com)$/.test(email)) {
            alert('Email must be a valid email address with @gmail.com, @yahoo.com, or @hotmail.com');
            valid = false;
        }

        // Subject validation: alphabets only
        if (!/^[A-Za-z\s]+$/.test(subject)) {
            alert('Subject must contain only alphabets.');
            valid = false;
        }

        // Message validation: not empty
        if (message.trim() === '') {
            alert('Please enter your message.');
            valid = false;
        }

        if (valid) {
            this.submit();
        }
    });
</script>

<style>
    /* Define the fade-in animation */
    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    /* Apply the fade-in animation to the form section */
    .contact-form {
        animation: fadeIn 1s ease-out;
    }

    /* Apply fade-in animation to text elements */
    .page-header h3,
    .page-header .d-inline-flex p,
    .text-center h6,
    .text-center h1 {
        animation: fadeIn 1s ease-out;
        opacity: 0; /* Start as invisible */
        animation-fill-mode: forwards; /* Retain the final state of animation */
    }

    /* Ensure that the text is visible after the animation ends */
    .text-center h6,
    .text-center h1 {
        opacity: 1;
    }

    .input-group {
        position: relative;
        margin-bottom: 1.5rem;
    }
    
    .input-field {
        padding: 1rem;
        border: 1px solid #ddd;
        border-radius: 0.25rem;
        background: transparent;
        transition: border-color 0.3s ease;
        outline: none;
        width: 100%;
    }
    
    .input-field:focus {
        border-color: transparent; /* Hide border when focused */
    }

    .input-group label {
        position: absolute;
        top: 50%;
        left: 1rem;
        font-size: 1rem;
        color: #aaa;
        pointer-events: none;
        transition: all 0.3s ease;
        transform: translateY(-50%); /* Center label vertically */
    }

    .input-field:focus + label,
    .input-field:not(:placeholder-shown) + label {
        top: -0.75rem;
        left: 0.75rem;
        font-size: 0.75rem;
        color: #007bff;
        background-color: white; /* Background to cover input border */
        padding: 0 0.25rem; /* Padding to ensure label covers input border */
    }
</style>

<?php
require "footer.php";
?>
