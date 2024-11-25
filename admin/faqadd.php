<?php
require "connection.php";
require "header.php";
?>
<div class="container">
    <h1 class="mt-5">Add FAQs</h1>
    <form action="#" method="POST" class="mt-4" enctype="multipart/form-data" onsubmit="return validateForm()">
        <div class="form-group">
            <label for="name"> Question:</label>
            <input type="text" class="form-control" id="name" name="faq_ques" required>
            <small class="text-danger" id="nameErr"></small>
        </div>

        <div class="form-group">
            <label for="country">Answer:</label>
            <input type="text" class="form-control" id="country" name="faq_ans" required>
            <small class="text-danger" id="countryErr"></small>
        </div>
       
        
       
        <button type="submit" class="btn btn-primary">Add FAQs</button>
        <button type="reset" class="btn btn-secondary ml-2">Reset</button>
    </form>
</div>

<script>
function validateForm() {
    var name = document.getElementById('name').value;
    var country = document.getElementById('country').value;
   

    var isValid = true;

    if (!/^[A-Za-z\s]+$/.test(name)) {
        document.getElementById('nameErr').innerText = 'Only letters and spaces are allowed.';
        isValid = false;
    } else {
        document.getElementById('nameErr').innerText = '';
    }
    // if (!/^[A-Za-z\s]+$/.test(country)) {
    //     document.getElementById('countryErr').innerText = 'Only letters and spaces are allowed.';
    //     isValid = false;
    // } else {
    //     document.getElementById('countryErr').innerText = '';
    // }


    return isValid;
}
</script>



<?php
require "connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Initialize variables to store form data
    $faq_ques = $_POST['faq_ques'];
    $faq_ans = $_POST['faq_ans'];
   
            // Insert data into database
            $sql = "INSERT INTO FAQs (faq_ques, faq_ans)
                    VALUES ('$faq_ques', '$faq_ans')";

            if ($conn->query($sql) === TRUE) {
                // Close the database connection
                $conn->close();

                // Display success message
                echo "<script>
          alert('Faqs added Successfully');
          window.location.href='faqshow.php';
                </script>";
             
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
         
    
else {
    echo "Invalid request method.";
}
?>
<?php
require "footer.php";
?>