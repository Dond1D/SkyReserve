<?php 



$conn = new mysqli("127.0.0.1:3390", "root", "", "roi");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


session_start();

if (!empty($_SESSION['user_id'])) {
    header("Location: /");
}

if (isset($_POST['submit']) && isset($_FILES['image_path'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $date_created = $_POST['date_created'];
    $category_id = $_POST['category_id'];

    $img_name = $_FILES['image_path']['name'];
    $img_size = $_FILES['image_path']['size'];
    $tmp_name = $_FILES['image_path']['tmp_name'];
    $error = $_FILES['image_path']['error'];
    $message = '';

    if ($error === 0) {
        $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
        $img_ex_lc = strtolower($img_ex);

        $allowed_exs = array("jpg", "jpeg", "png");

        if (in_array($img_ex_lc, $allowed_exs)) {
            $new_img_name = uniqid("IMG-", true) . '.' . $img_ex_lc;
            $img_upload_path = 'photos/' . $new_img_name;
            move_uploaded_file($tmp_name, $img_upload_path);

            // Insert into Database using prepared statements
            $stmt = $conn->prepare("INSERT INTO services(name,description,date_created,category_id,image_path) VALUES(?,?,?)");
            $stmt->bind_param("sssss", $name, $description,$date_created,$category_id, $new_img_name );

            $stmt->execute();
            $stmt->close();
            $conn->close();
        } else {
            die("You can't upload files of this type");
        }
    }
    
     else {
         $message = 'Please fill the data';
           }
    echo"<script>alert('Succesfully submmited')</script>";
}


?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./cretateMovie.css"/>

</head>
<body>
    <header class="header">
        <h3 class="logo"> <img src="Logo.jpg"></h3>
        <nav class="navbar">
          <ul class="navbar-list">
            <!-- <li><a class="navbar-link" href="dashboard.php">Dashboard</a></li> -->
            <li><a class="navbar-link" href="./login.php">Log Out</a></li>
            
          </ul>
        </nav>
  </header>

  


<div class="forms">
    
    <form action="" method="post" enctype="multipart/form-data">
        <input type="text" name="emri" placeholder="Insert new movie name">
        <br>
        <input type="file" name="image_path" >
        <input type="text" name="description" placeholder=" Type the description of the movie">
        <br>
        <br>
        <input type="submit" name="submit" value="Submit">
        <?php if(!empty($message)): ?>
              <p style="color:red;"><?php echo $message ?></p>
        <?php endif; ?>
        
       
    </form>
</div>


 <br>
        <br>
        <br>
        <br>
<br><br><br><br>
<table class="styled-table">
    <thead>
        <tr>
            <th>Emri </th>
            <th>Image</th>
            <th>Descripton</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <tr class="active-row"></tr>
        <?php




    $conn2 = new mysqli("localhost", "root", "", "roi");

            $sql = "SELECT * FROM adminfilm";
            $result = $conn2->query($sql);
            if ($result->num_rows > 0) {
              while($row = $result->fetch_assoc()) {
                  
                echo "<tr>";
                echo "<td>" . $row["emri"] . "</td>";
                echo '<td> <img  width="50px" height="50px" src="photos/' . $row["image_path"] . '"></td>';
                echo "<td>" . $row["description"] . "</td>";
                echo '<td > <a href="edit.php?id='.$row['id'].'">Edit</a> </td>';
                echo '<td > <a href="delete.php?id='.$row['id'].'">Delete</a> </td>';
                echo "</tr>";
              }
              
             } else {
            echo "<tr><td colspan='4'>No results found</td></tr>";
             }
            
            $conn2->close();
        