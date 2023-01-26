<?php
 
session_start();
require('connection.php');


if ($_SESSION['newfood'] == 1) {
    $ans = array("", "", "",0 , "", "");
}else {
    $id=$_GET['id'];
    $sql="SELECT * from food WHERE id='$id'";

    if ($result=mysqli_query($con,$sql))
    {
        $ans=mysqli_fetch_row($result);
    }
}

$cat_sql = "SELECT * FROM cat";

$error = "";
if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $author = $_POST['auth'];
    $cat_id = $_POST['option'];
    $cap = $_POST['cap'];

    $src = "";
    if(!isset($_FILES["file"])){
        die(" No file uploaded.");
    }
    if ((($_FILES["file"]["type"] == "image/gif")
            || ($_FILES["file"]["type"] == "image/jpeg")
            || ($_FILES["file"]["type"] == "image/pjpeg")
            || ($_FILES["file"]["type"] == "image/png")
            || ($_FILES["file"]["type"] == "image/jpg"))) {
        if ($_FILES["file"]["error"] > 0) {
            die("Return Code: " . $_FILES["file"]["error"] . "<br />");
        } else {
            $src = "../images/" . $_FILES["file"]["name"];
            if (!file_exists($src)) {
                move_uploaded_file($_FILES["file"]["tmp_name"], $src);
            }
        }
    } else {
        die("Invalid file");
    }
    
    if(!empty($title) && !empty($author) && !empty($cat_id) && !empty($cap) && !empty($src)) {
        if ($_SESSION['newpost'] == 1) {
            $sql = "INSERT INTO posts (TITLE, AUTHOR, CAT_ID, CAP, IMG_A)
                    VALUES ('$title', '$author', '$cat_id', '$cap', '$src')";
        }else {
            $sql = "UPDATE posts
                    SET TITLE='$title', AUTHOR='$author', CAT_ID='$cat_id', CAP='$cap', IMG_A='$src'
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
        <title>Post</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    </head>
    <body class="text-center" style="margin: 8rem">
        <main class="form-signin w-400" style="padding-left: 14rem">
            <form style="width: 600px" action="" method="post" enctype="multipart/form-data">
                <h1 class="h3 mb-3 fw-normal">New Food</h1>
                <div class="form-floating">
                <?php
                    echo "<input type='text' class='form-control' placeholder='Title' name='title' value=$ans[1]>";
                ?>
                <label for="floatingInput">Title</label>
                </div>
                <div class="form-floating">
                <?php
                    echo "<input type='text' class='form-control' placeholder='Author' name='auth' value=$ans[2]>";
                ?>
                <label for="floatingInput">Author</label>
                </div>
                <div class="form-floating">
                <?php
                    echo "<select class='form-select' id='chooseCat' name='option' value=$ans[3]>";
                ?>
                    <?php
                        if (($result=mysqli_query($con,$cat_sql)))
                        {

                            while($row=mysqli_fetch_row($result))
                                {
                                    $name = $row[1];
                                    echo "<option value=$row[0]>$name</option>";
                                }
                            
                        }
                    ?>
                </select>
                </div>
                <div class="form-floating">
                <?php
                    echo "<textarea class='form-control' aria-label='With textarea' style='height: 200px' name='cap'>$ans[4]</textarea>";
                ?>
                <label for="floatingInput">Caption</label>
                </div>
                <div class="form-floating">
                <?php
                    echo "<input type='file' class='form-control' placeholder='img' name='file' id='file' value=$ans[5]>";
                ?>
                </div>
                <button class="w-100 btn btn-lg btn-secondary" type="submit" name="submit" value="1">Submit</button>
                <span style="color: red;"><?php echo $error; ?><span>
            </form>
        </main>
    </body>
</html>