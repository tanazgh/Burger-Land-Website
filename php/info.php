<?php
 
session_start();
require('connection.php');
 
 
$id=$_GET['id'];
$sql="SELECT * from user WHERE id='$id'";

if ($result=mysqli_query($con,$sql))
{
    $ans=mysqli_fetch_row($result);
}

$error = "";
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    
    if(!empty($username) && !empty($email) && !empty($pass)) {
        $sql = "UPDATE user
                SET username='$username', pass='$pass', email='$email'
                WHERE id='$id'";
        if (mysqli_query($con, $sql)) {
            header("location: profile.php");
        }   
    }else {
        $error = "Fill Again!";
    }
}
     
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Category</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
        <style>
            .mybtn {
                display: inline-block;
                color: black;
                background-color: #fff4d4;
                padding: 1rem;
                border-radius: 0.5rem;
                transition: all 0.2s linear;
                border: 0;
                }

            .mybtn:hover {
            box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.1);
            }
        </style>
    </head>
    <body class="text-center" style="margin: 8rem; background-color: #fffaf1;">
        <main class="form-signin w-400 d-flex justify-content-center align-items-center">
            <form style="width: 600px; background-color: #ffc554;" action="" method="post" class="shadow col-4 p-5 rounded">
                <h1 class="h3 mb-3 fw-normal form-label" class="">Edit Info</h1>
                <div class="form-floating">
                <?php
                    echo "<input type='text' class='form-control' placeholder='Username' name='username' value=$ans[1]>";
                ?>
                <label for="floatingInput" class="form-label">Username</label>
                </div>
                <div class="form-floating">
                <?php
                    echo "<input type='email' class='form-control' placeholder='Email' name='email' value=$ans[3]>";
                ?>
                <label for="floatingInput" class="form-label">Email</label>
                </div>
                <div class="form-floating">
                <?php
                    echo "<input type='password' class='form-control' placeholder='Password' name='pass' value=$ans[2]>";
                ?>
                <label for="floatingInput" class="form-label">Password</label>
                </div>
                <button class="w-100 btn-lg mybtn" type="submit" name="submit" value="1">Submit</button>
                <span style="color: red;"><?php echo $error; ?><span>
            </form>
        </main>
    </body>
</html>