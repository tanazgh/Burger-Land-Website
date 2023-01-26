<?php
 
session_start();
require('connection.php');
 
 
if ($_SESSION['newcat'] == 1) {
    $ans = array("", "");
}else {
    $id=$_GET['id'];
    $sql="SELECT * from cat WHERE id='$id'";
 
    if ($result=mysqli_query($con,$sql))
    {
        $ans=mysqli_fetch_row($result);
    }
}

$error = "";
if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    
    if(!empty($title)) {
        if ($_SESSION['newcat'] == 1) {
            $sql = "INSERT INTO CAT (NAME)
            VALUES ('$title')";
        }else {
            $sql = "UPDATE cat
                    SET name='$title'
                    WHERE id='$id'";
        }
        if (mysqli_query($con, $sql)) {
            header("location: dashboard.php");
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
    </head>
    <body class="text-center" style="margin: 8rem">
        <main class="form-signin w-400" style="padding-left: 14rem">
            <form style="width: 600px" action="" method="post">
                <h1 class="h3 mb-3 fw-normal">New Category</h1>
                <div class="form-floating">
                <?php
                    echo "<input type='text' class='form-control' placeholder='Title' name='title' value=$ans[1]>";
                ?>
                <label for="floatingInput">Title</label>
                </div>
                <button class="w-100 btn btn-lg btn-secondary" type="submit" name="submit" value="1">Submit</button>
                <span style="color: red;"><?php echo $error; ?><span>
            </form>
        </main>
    </body>
</html>