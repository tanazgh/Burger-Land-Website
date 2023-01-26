<?php
 
session_start();
require('connection.php');


if ($_SESSION['newfood'] == 1) {
    $ans = array("", "", 0,"" , 0, 0, "");
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
    $name = $_POST['name'];
    $price = $_POST['price'];
    $cat_id = $_POST['option'];
    $description = $_POST['description'];
    $qty = $_POST['qty'];

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
            $src = $_FILES["file"]["name"];
            if (!file_exists($src)) {
                move_uploaded_file($_FILES["file"]["tmp_name"], "../images/" . $src);
            }
        }
    } else {
        die("Invalid file");
    }

    echo $qty;
    
    if(!empty($name) && !empty($price) && !empty($cat_id) && !empty($description) && 
        !empty($qty) && !empty($src)) {
        if ($_SESSION['newfood'] == 1) {
            $sql = "INSERT INTO food (name, cat_id, description, price, qty, img_addr)
                    VALUES ('$name', $cat_id, '$description', $price, $qty, '$src')";
        }else {
            $sql = "UPDATE food
                    SET name='$name', cat_id=$cat_id, description='$description',
                    price=$price, qty=$qty,img_addr='$src'
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
        <title>Food</title>
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
            <form style="width: 600px; background-color: #ffc554;" action="" method="post" class="shadow col-4 p-5 rounded" enctype="multipart/form-data">
                <h1 class="h3 mb-3 fw-normal form-label">New Food</h1>
                <div class="form-floating">
                <?php
                    echo "<input type='text' class='form-control' placeholder='Name' name='name' value=$ans[1]>";
                ?>
                <label for="floatingInput" class="form-label">Name</label>
                </div>
                <div class="form-floating">
                <?php
                    echo "<input type='number' step='0.01' class='form-control' placeholder='Price' name='price' value=$ans[4]>";
                ?>
                <label for="floatingInput" class="form-label">Price</label>
                </div>
                <div class="form-floating">
                <?php
                    echo "<select class='form-select' id='chooseCat' name='option' value=$ans[2]>";
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
                    echo "<textarea class='form-control' aria-label='With textarea' style='height: 200px' name='description'>$ans[3]</textarea>";
                ?>
                <label for="floatingInput" class="form-label">Description</label>
                </div>
                <div class="form-floating">
                <?php
                    echo "<input type='number' class='form-control' placeholder='Quantity' name='qty' value=$ans[5]>";
                ?>
                <label for="floatingInput" class="form-label">Quantity</label>
                </div>
                <div class="form-floating">
                <?php
                    echo "<input type='file' class='form-control' placeholder='img' name='file' id='file' value=$ans[6]>";
                ?>
                </div>
                <button class="w-100 btn-lg mybtn" type="submit" name="submit" value="1">Submit</button>
                <span style="color: red;"><?php echo $error; ?><span>
                    </form>
        </main>
    </body>
</html>