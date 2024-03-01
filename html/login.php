<?php 

// session_start();

// $conn = new mysqli("127.0.0.1:3390", "root", "", "roi");
    require '../include/db_connect.php';
    if(!empty($_SESSION["user_id"])){
    header("Location:/");
    }
    if(isset($_POST["submit"])){
    // $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $result = mysqli_query($conn, "SELECT * FROM users WHERE  email = '$email'");
    $row = mysqli_fetch_assoc($result);
    $message = '';
    if(mysqli_num_rows($result) > 0){
    
    $_SESSION['user_id'] = $row['id'];
    
    //check per checkboxin
        if(!empty($_POST['remember'])){
        $remember = $_POST['remember'];

        //krijo cookies per checkbox remeber me
        setcookie('email',$email,time()+24*3600);
        setcookie('password',$password,time()+24*3600);
        
        }
        else{
        setcookie('email',$email,30);
        setcookie('password',$password,30);
        }

    
    if($password == $row['password']){
        $user_type = $row['user_type']; 
        if($user_type == 'ADMIN'){
            header("Location: admin.php");
            $_SESSION["login"] = true;
            $_SESSION["id"] = $row["id"];
            
        }  
        else {
            $_SESSION["login"] = true;
            $_SESSION["id"] = $row["id"];
            header("Location: main.php");
        }
        
        }
        else{
        
        $message = 'Sorry,credentials do not match' ;
        }
    }
    else{
        echo
        $message = 'User Not Registered' ;
    }
    }


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/about.css">
</head>

<body>


    <form action="login.php" method="post" class="was-validated form-login  d-flex flex-column justify-content-center  mt-5">
        <div class="login-logo">
           <h1 class="text-center">Log In</h1>
        </div>
        <?php if(!empty($message)): ?>
              <p style="color:red;"><?php echo $message ?></p>
    <?php endif; ?>
        <div class="mb-3 mt-3">
            <input type="text" 
                class="form-control" 
                id="uname" 
                placeholder="Type your username" 
                name="email"
                value="<?php if(isset($_COOKIE['email'])){echo $_COOKIE['email'];}; ?>" required>
            <div class="valid-feedback">Valid.</div>
            <div class="invalid-feedback">Please fill out this field.</div>
        </div>
        <div class="mb-3">
            <input type="password" class="form-control" id="pwd" placeholder="Type your password" 
            name="password"
            value="<?php if(isset($_COOKIE['password'])){echo $_COOKIE['password'];}; ?>"
            required>
            <div class="valid-feedback">Valid.</div>
            <div class="invalid-feedback">Please fill out this field.</div>
        </div>
            <div id="check">
                    <input type="checkbox" name="remember" id="remember" >
                    <label for="remember">Remember me</label>
            </div>
           
        <input type="submit" name="submit" class="btn btn-primary mt-2 mb-1" value="Submit">
        <a href="./signup.php" class="mb-3 text-center text-decoration-none text-secondary">Don't have an acount ? Signup instead</a>
    </form>

</body>

</html>