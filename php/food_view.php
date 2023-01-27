<?php

session_start();
require('connection.php');

// if (isset($_GET['id'])) {
//     $id = $_GET['id'];
//     $food_sql = "SELECT f.name, f.description, f.img_addr, c.score, c.caption, u.username FROM food f 
//                 inner join `comment` c on f.id = c.food_id
//                 inner join `user` u on u.id = c.user_id
//                 WHERE f.id = 1";
// }
$food_sql = "SELECT f.name, f.description, f.img_addr, f.price, avg(c.score), c.caption, u.username FROM food f 
                inner join `comment` c on f.id = c.food_id
                inner join `user` u on u.id = c.user_id
                WHERE f.id = 1";
             
$comment_sql = "SELECT c.score, c.caption, u.username FROM food f 
                inner join `comment` c on f.id = c.food_id
                inner join `user` u on u.id = c.user_id
                WHERE f.id = 1"; 

$error ="";
if (isset($_POST['submit'])) {
    $caption = $_POST['caption'];
    $score = $_POST['score'];
    $userid = $_SESSION['userid'];
    
    if(!empty($caption) && !empty($score)) {
        if ($_SESSION['signin'] == 1) {
            $sql = "INSERT INTO comment (score, caption, food_id, `user_id`)
                    VALUES ($score, '$caption', $id, $userid)";
        }else {
            $error = "You Must Login!";
        }
        if (mysqli_query($con, $sql)) {
            header("location: food_view.php");
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
        <title>View</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="../css/styles.css?v=<?php echo time(); ?>">
    </head>
    <body>
    <header class="header">
      <a href="/" class="logo">Burger<span class="yellow">Land</span></a>

      <nav class="navbar">
        <a href="#home">Home</a>
        <a href="#services">Services</a>
        <a href="menu.php">Menu</a>
        <a href="#about">About Us</a>
        <a href="#footer">Contact Us</a>
        <a href="login.php" class="mybtn">Login</a>
      </nav>

    </header>
        <div class="album py-5" style="background-color: #fffaf1">
            <form action="" method="post">
            <div class="container" style="width: 40%; margin-top: 6rem;">
                    <?php
                        if (($result=mysqli_query($con,$food_sql)))
                        {

                            if($row=mysqli_fetch_row($result))
                            {
                                echo "<div class='col'><div class='card shadow-sm' style='background-color: #fff4d4'>";
                                echo "<img  class='bd-placeholder-img card-img-top' src='../images/$row[2]' width='100%' height='30%' alt='...'>";
                                echo "<div class='card-body'>";
                                echo "<div class='d-flex justify-content-between align-items-center'><h2 class='card-title'>$row[0]</h2>
                                <div><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='#ffc727' class='bi bi-star-fill' viewBox='0 0 16 16'>
                                <path d='M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z'/>
                                </svg><strong>" . floor($row[4] * 10) / 10 . "</strong></div></div>";
                                echo "<p class='card-text'>$row[1]</p>";
                                echo "<div class='d-flex justify-content-end align-items-center'>";
                                echo "<small class='price'>" . $row[3] . "$</small>";
                                echo "</div></div>";
                                echo "<div class='d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom'>";
                                echo "<h1 class='h2 card-title' style='margin-left: 8px'>Comments</h1>";
                                echo "</div>";
                                echo "<div class='container-fluid p-3'>";
                                if (($result=mysqli_query($con,$comment_sql)))
                                {
                                    while($row1=mysqli_fetch_row($result))
                                    {
                                        echo "<div class='rounded p-3 mb-3' style='background-color: #ffc554'><div class='d-flex justify-content-between align-items-center'><h3 class='card-title'>$row1[2]</h3>
                                        <div><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='#fff4d4' class='bi bi-star-fill' viewBox='0 0 16 16'>
                                        <path d='M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z'/>
                                        </svg><strong> $row1[0]</strong></div></div>";
                                        echo "<p class='card-text'>$row1[1]</p></div>";
                                    }
                                }
                                echo "</div>";
                                echo "<main class='form-signin w-400'>";
                                echo "<form style='background-color: #ffc554;' action='' method='post' class='shadow col-4 p-5 rounded' enctype='multipart/form-data'>
                                <h3 class='card-title' style='margin-left: 8px'>Add New Score & Comment</h3>
                                <div class='form-floating'>
                                <input type='number' max=5 min=1 class='form-control' placeholder='Score' name='score'>
                                </div>
                                <div class='form-floating'>
                                <textarea class='form-control' aria-label='With textarea' name='caption'></textarea>
                                </div>
                                <button class='w-100 btn-lg mybtn' type='submit' name='submit' value='1'>Submit</button>
                                <span style='color: red;'>$error<span>
                                </form></main>";
                                echo "</div></div>";
                            } 
                        }
                    ?>
            </div>
            </form>
        </div>
    </body>

</html>    