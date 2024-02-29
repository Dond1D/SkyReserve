<?php 

    $conn = new mysqli("127.0.0.1:3390","root", "","roi");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if(isset($_POST['submit'])){
        $name = $_POST['name'];
        $email = $_POST['email'];
        $description = $_POST['description'];
        $message = '';
        $query = $conn->prepare("INSERT INTO contact (name, email, description) VALUES (?, ?, ?)");
        $query->bind_param('sss', $name, $email, $description);
            
        if($query->execute() === false){
            die("Error in query: " . $query->error);
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/4fe040270a.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/contact.css">
    <script src="../js/script.js"></script>
</head>
<body>
    <section>
        <div class="hero">
            <div class="hero-content">
                <h1>Contact us</h1>
                <p>Let's talk about your website or project.Send us a message and we will be in touch within one business day.</p>
            </div>
        </div>

        <div class="row section-form">
            <div class="form-contact col-sm-8 ">
                <h3>Send us a message</h3>
                <hr>
                <form id="contactForm" action="" method="post" onSubmit="alert(`Successfully send data!`)">
                    <div class="row">
                        <?php if(!empty($message)): ?>
                            <p style="color:red;"><?php echo $message ?></p>
                        <?php endif; ?>
                        <div class="col">
                            <div class="content-wrapper">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" placeholder="Full Name" required>
                            </div>
                        </div>
                        <div class="col">
                            <div class="content-wrapper">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" placeholder="name@example.com" required>
                            </div>
                        </div>
                    </div>
                    <div class="content-wrapper">
                        <label for="message">Message</label>
                        <textarea id="description" name="description" rows="5" placeholder="Enter your message here" required></textarea>
                    </div>
                    <p class="terms">By clicking the "Submit" button below, you are indicating that you have read, understood, and agreed to our <a href="/terms">Terms and Conditions</a> and <a href="/privacy">Privacy Policy</a>. Please review these documents carefully before proceeding.</p>
                    <input type="submit" name="submit" class="submit-button"  value="Submit">
                </form>
            </div>
                
            <div class="col-sm-4">
                <div class="links">
                    <div class="link-content d-flex">
                        <i class="fa-solid fa-envelope icons-contact"></i>
                        <p class="mb-4"><a href="mailto:contact@skyreserve.com">contact@skyreserve.com</a></p>
                    </div>
                    <div class="link-content d-flex">
                    <i class="fa-brands fa-twitter  icons-contact"></i>
                        <p class="mb-4"><a href="http://twitter.com">Twitter</a></p>
                    </div>
                    <div class="link-content d-flex">
                    <i class="fa-brands fa-facebook   icons-contact"></i>
                        <p class="mb-4"><a href="http://facebook.com">Facebook</a></p>
                    </div>
                    <div class="link-content d-flex">
                    <i class="fa-brands fa-linkedin  icons-contact"></i>
                        <p class="mb-4"><a href="http://linkedin.com">LinkedIn</a></p>
                    </div>
                    <div class="link-content d-flex">
                    <i class="fa-brands fa-instagram  icons-contact"></i>
                        <p class="mb-4"><a href="#">Instagram</a></p>
                    </div>
                </div>
            </div>
    </div>
    </section>

    <script>
    function validateForm(event) {
        event.preventDefault();
        let name = document.getElementById("name").value;
        let email = document.getElementById("email").value;
        let description = document.getElementById("description").value; // Corrected ID here

        if (name.trim() === "" || email.trim() === "" || description.trim() === "") { // Changed 'message' to 'description'
            alert("Please fill out all fields");
            return false;
        }
        alert("Message sent successfully");
        document.getElementById("contactForm").reset(); // Optional: Reset the form after successful submission
        return true; // Optional: Allow the form to be submitted
    }
    </script>
</body>
</html>