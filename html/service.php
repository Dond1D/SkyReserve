
<?php 

$conn = new mysqli("127.0.0.1:3390","root", "","roi");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service</title>
    <link rel="stylesheet" href="../css/service.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
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
                            <!-- <li class="nav-item">
                                <a class="nav-link" href="./index.html">Home</a>
                            </li> -->
                            
                            <li class="nav-item">
                                <a class="nav-link" href="./admin.php">Contact</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./index.html">Log out</a>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </nav>




    <h1 class="text-center mt-5">Service Table</h1>
        <table class="styled-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Date Created</th>
                    <th>Category Name </th>
                </tr>
            </thead>
            <tbody>
                <tr class="active-row"></tr>
                <?php
            $sql = "SELECT s.name,s.description,s.date_created,c.name  as CategoryName
            FROM services as s inner join category c on s.category_id = c.id;";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    
                echo "<tr>";
                echo "<td>" . $row["name"] . "</td>";
                echo "<td>" . $row["description"] . "</td>";
                echo "<td>" . $row["date_created"] . "</td>";
                echo "<td>" . $row["CategoryName"] . "</td>";
                echo "</tr>";
                }
                
            } else {
            echo "<tr><td colspan='4'>No results found</td></tr>";
            }
            
            $conn->close();
            ?>
            </tbody>
        </table>
</body>
</html>