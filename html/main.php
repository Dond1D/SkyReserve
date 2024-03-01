<?php

    $conn = new mysqli("127.0.0.1:3390", "root", "", "roi");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if(isset($_POST['submit'])) {
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $telephone = $_POST['telephone'];
        $address = $_POST['address'];
        $email = $_POST['email'];
        $destination = $_POST['destination'];
        $message = '';
    
        // Perform validation here if necessary
    
        $query = $conn->prepare("INSERT INTO reservation (firstname, lastname, telephone, address ,email, destination) VALUES (?, ?, ?, ?, ?, ?)");
        $query->bind_param('ssssss', $firstname, $lastname, $telephone, $address,$email, $destination);
    
        if ($query->execute() === false) {
            echo("Error in query: " . $query->error);
        }
        
        echo'<script>alert("Successfully reserved trip! Enjoy?");</script>';
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SKyReserve</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/4fe040270a.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/main.css">
    <script src="../js/script.js"></script>
</head>
<body>
<nav class="navbar navbar-expand-sm bg-dark navbar-dark ">
        <div class="container-fluid ">
            <div class="container  d-flex justify-content-between">
                <a class="navbar-brand" href="./index.html">
                    <img src="../images/dd-logo-letter-monogram-slash-with-modern-vector-27833344-removebg-preview.png"
                        alt="Logo" width="100px" height="100px">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapsibleNavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="d-flex">
                    <div class="collapse navbar-collapse " id="collapsibleNavbar">
                        <ul class="navbar-nav ">
                            <li class="nav-item">
                                <a class="nav-link" href="./contact.php">Contact</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./about.html">About</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./index.html">Log Out</a>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </nav>


    <section class="my-5">
        <div class="container-fluid">
            <div class="container">
                <div class="row">
                <?php
                        $sql = "SELECT s.*, c.name AS country_name FROM services AS s INNER JOIN category AS c ON s.category_id = c.id";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                
                            echo '<div class="col-sm-4 mb-5">
                            <div class="card">
                                <img class="card-img-top img-rounded" style="height: 300px;"
                                src="../images/'. $row["image_path"] .'">
                                    <div class="card-body text-center">
                                        <h1 class="card-title">'.$row["name"].'</h1>
                                        <p class="card-text my-4">'.$row["description"].'</p>
                                        <h4>$'.$row["price"].'</h4>
                                        <h4>Country : '.$row["country_name"].'</h4>
                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#myModal">
                                        Reserve </button>
                                    </div>
                                </div>
                            </div>';
                            }
                        } 
                        if (!$result) {
                            die("Error in SQL query: " . $conn->error);
                        }
                        

                        $conn->close();
                        ?>
                </div>
            </div>
        </div>
    </section>


    <div class="modal" id="myModal">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title text-center">Reserve your flight right now</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <form action="main.php" method="post">
                            <div class="reserve-wrapper">
                                <label for="firstname">First Name:</label>
                                <input type="text" name="firstname" placeholder="Type your name" required>
                            </div>
                            <div class="reserve-wrapper">
                                <label for="lastname">Last Name:</label>
                                <input type="text" name="lastname" placeholder="Type your lastname" required>
                            </div>
                            <div class="reserve-wrapper">
                                <label for="telephone">Phone:</label>
                                <input type="text" name="telephone" placeholder="Type your phone" required>
                            </div>
                            <div class="reserve-wrapper">
                                <label for="address">Address:</label>
                                <input type="text" class="mb-2" name="address" placeholder="Type your address" required>
                            </div>
                            <div class="reserve-wrapper">
                                <label for="email">Email:</label>
                                <input type="email" class="mb-2" name="email" placeholder="Type your email" required>
                            </div>
                            <div class="reserve-wrapper">
                                <label for="destination">Destination:</label>
                                <input type="text" class="mb-2" name="destination" placeholder="Type your city" required>
                            </div>
                            <input type="submit" class="btn btn-success" name="submit" value="Submit">
                        </form>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
        </div>


        
   

</body>
</html>