<?php
session_start();
require('connection.php');

$admin = "admin@gmail.com";
$pass_admin = "admin";
$error = "";
if (isset($_SESSION["signedin"]) && $_SESSION["signedin"] == '1'){
    if (isset($_SESSION["isadmin"]) && $_SESSION['isadmin'] == 1 )
        header('Location: dashboard.php');
    else
        header('Location: profile.php');    
}
if (isset($_POST['email']) && isset($_POST['pswd'])) {
    $email = $_POST['email'];
    $pass = $_POST['pswd'];
    if (!empty($email) && !empty($pass) && $admin == $email && $pass_admin == $pass) {
        $_SESSION['signedin'] = 1;
        $_SESSION['isadmin'] = 1;
        $_SESSION['email'] = $admin;
        $_SESSION['username'] = 'Admin';
        header('Location: dashboard.php');
    } else {
        $users_sql = "SELECT * FROM user WHERE email = '$email'";
        if (($result=mysqli_query($con,$users_sql))) {
            if($row=mysqli_fetch_row($result)) {
                if (!empty($email) && !empty($pass) && $row[3] == $email && $row[2] == $pass) {
                    $_SESSION['signedin'] = 1;
                    $_SESSION['isadmin'] = 0;
                    $_SESSION['email'] = $email;
                    $_SESSION['username'] = $row[1];
                    $_SESSION['userid'] = $row[0];
                    header('Location: profile.php');   
                } else {
                    $error = 'Incorrect email or password! Check your information.';
                }
            }
        }
    }
}
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Login</title>
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
            <form method="post" action="login.php" class="shadow col-4 p-3 rounded" style="background-color: #ffc554">
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
                    <span style="color: red"></span>
                </div>
                <div class="mb-3">
                    <label for="pwd" class="form-label">Password:</label>
                    <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pswd">
                    <span style="color: red"><?php echo $error ?></span>
                </div>
                <button type="submit" class="mb-3 col-12 btn btn-outline-secendory" style="background-color: #fff4d4">Login</button>
                <a href="home.php" class="mb-3 col-12 btn btn-outline-secondry" style="background-color: #fff4d4">Home Page</a>
                <label for="signup" class="form-label">You Don't Have An Account? Create One</label>
                <a href="signup.php" class="mb-3 col-12 btn btn-outline-secondry" style="background-color: #fff4d4">Signup</a>
            </form>
        </div>
    </body>
</html>