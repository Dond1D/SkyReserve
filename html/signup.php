<?php

    session_start();
    $conn = new mysqli("127.0.0.1:3390", "root", "", "roi");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if(!empty($_SESSION["id"])) {
        header("Location: /");
    }


    if(isset($_POST['submit'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $gender = $_POST['gender'];
    $user_type = 'USER';
    $message = '';

    // Perform validation here if necessary

    $query = $conn->prepare("INSERT INTO users (firstname, lastname, email, password ,gender, user_type) VALUES (?, ?, ?, ?, ?, ?)");
    $query->bind_param('ssssss', $firstname, $lastname, $email, $password, $gender, $user_type);

    if ($query->execute() === false) {
        echo("Error in query: " . $query->error);
    }

    // Redirect based on user type
    if ($user_type == 'admin') {
        header("Location: dashboard.php");
        exit;
    } else {
        header("Location: main.php");
        exit;
    }
}

?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/about.css">
</head>

<body>

    <form action="signup.php" method="post" id="signupForm"  class="d-flex flex-column justify-content-center signup-form  mt-5">
        <div class="login-logo">
            <h3 class="text-center">Create a new account</h3>
            <p class="text-center text-secondary">It's quick and easy</p>
        </div>
        <?php if(!empty($message)): ?>
            <div id="errorMsg"><?php echo $message ?></div> <?php endif; ?>
        <div class="row">
            <div class="col mt-4 mb-3">
                <input type="text" class="form-control" id="fname" placeholder="Type your firstname" name="firstname" required>
            </div>
            <div class="col mt-4">
                <input type="text" class="form-control" id="lname" placeholder="Type your lastname" name="lastname" required>
            </div>
        </div>

        <div class="mb-3">
            <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" required>
        </div>
        <div class="mb-3">
            <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="password" required>
        </div>
        <div class="row">
            <div class="col gender-radio">
                <div class="form-check">
                    <input type="radio" class="form-check-input" id="radioMale" name="gender" value="Male" required>Male
                    <label class="form-check-label" for="radio2"></label>
                </div>
            </div>
            <div class="col gender-radio">
                <div class="form-check">
                    <input type="radio" class="form-check-input" id="radioFemale" name="gender" value="Female" required>Female
                    <label class="form-check-label" for="radio2"></label>
                </div>
            </div>
        </div>
        <p class="info-signup">People who use our service may have uploaded your contact information to D&D. Learn more.
        </p>
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" id="mySwitch" name="darkmode" value="yes" checked required>
            <label class="form-check-label" for="mySwitch">
                <p class="info-signup">By clicking you agree to our
                    <button type="button" class="terms-condition" data-bs-toggle="modal" data-bs-target="#myModal">
                        Terms,</button>
                    <button type="button" class="terms-condition" data-bs-toggle="modal" data-bs-target="#myModal">
                        Privacy Policy</button>and 
                    <button type="button" class="terms-condition" data-bs-toggle="modal" data-bs-target="#myModal">
                       Cookies Policy.</button>You may
                    receive SMS
                    Notifications from us and can opt out any time.
                </p>
            </label>

        </div>

        <div class="modal" id="myModal">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Terms and Conditions</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <!-- <h2< /h2> -->
                            <p>Welcome to D & D. Before you proceed, please read our Terms and Conditions carefully. By
                                continuing to use our website, you agree to be bound by the following terms and
                                conditions:</p>
                            <ol>
                                <li>Use of the website is subject to acceptance of these terms.</li>
                                <li>Users must be at least 18 years old to use our services.</li>
                                <li>Users are responsible for maintaining the confidentiality of their account
                                    information.</li>
                                <li>Users agree not to engage in any illegal or unauthorized activities.</li>
                                <li>Content posted or shared by users must not violate any laws or infringe upon any
                                    rights.</li>
                                <li>We reserve the right to suspend or terminate accounts that violate these terms.</li>
                            </ol>
                            <p>By clicking "I Agree", you acknowledge that you have read, understood, and agreed to be
                                bound by the terms and conditions stated above.</p>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
        </div>



        <input type="submit" name="submit" class="btn btn-primary mb-2" value="Sign up">
        <a href="./login.php" class="mb-3 text-center text-decoration-none text-secondary">Already have an acount ?</a>
    </form>


    <script>
 

</script>

</body>

</html>