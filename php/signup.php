<?php
session_start();
require('connection.php');

$error = "";

if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['pswd'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $pass = $_POST['pswd'];
    if (!empty($username) && !empty($email) && !empty($pass)) {
        $users_sql = "SELECT * FROM user WHERE email = '$email'";
        if (($result=mysqli_query($con,$users_sql))) {
            if($row=mysqli_fetch_row($result)) {
                $error = 'User already exists! Please Login';
            }else {
                $sql = "INSERT INTO user (username, pass, email)
                        VALUES ('$username', '$pass', '$email')";
                if (mysqli_query($con, $sql)) {
                    header("location: login.php");
                }  
            }
        }
    }else {
        $error = "Please fill all the parts!";
    }
}
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Sigup</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <style>
            html, body{
                height: 100%;
                background-color: #fffaf1;
            }
            .btn:hover {
                box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.1);
            }
        </style>
    </head>

    <body>
        <div class="d-flex justify-content-center align-items-center" style="height: 100%">
            <form method="post" action="signup.php" class="shadow col-4 p-3 rounded" style="background-color: #ffc554">
                <div class="mb-3">
                    <label for="email" class="form-label">Username:</label>
                    <input type="username" class="form-control" id="fn" placeholder="Enter username" name="username">
                    
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
                    
                </div>
                <div class="mb-3">
                    <label for="pwd" class="form-label">Password:</label>
                    <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pswd">
                    <span style="color: red"><?php echo $error ?></span>
                </div>
                <button type="submit" class="mb-3 col-12 btn btn-outline-secendory" style="background-color: #fff4d4">Signup</button>
                <a href="home.php" class="mb-3 col-12 btn btn-outline-secondry" style="background-color: #fff4d4">Home page</a>
                <label for="login" class="form-label">You Already Have An Account? Login</label>
                <a href="login.php" class="mb-3 col-12 btn btn-outline-secondry" style="background-color: #fff4d4">Login</a>
            </form>
        </div>
    </body>
</html>