<?php

session_start();
require('connection.php');


$food_sql = "SELECT * FROM food";
$cat_sql = "SELECT * FROM cat";
$_SESSION['newfood'] = 0;
$_SESSION['newcat'] = 0;
$sty = "";

if (isset($_GET['page'])) {
    if ($_GET['page'] == 'food') {
        $sty = "#cat{display: none;}";
    } else if ($_GET['page'] == 'cat') {
        $sty = "#food{display: none;}";
    }
}
     
?>

<!DOCTYPE html>
<html lang="en" style="height: 100%">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Dashboard</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="../css/styles.css?v=<?php echo time(); ?>">
        <style>html, body{height: 100%;} 
        <?php echo $sty; ?>
        </style>
    </head>
    <body style="height: 100%">
        <header class="header">
        <a href="/" class="logo">Burger<span class="yellow">Land</span></a>

        <nav class="navbar">
            <a href="home.php">Home</a>
            <a href="home.php#services">Services</a>
            <a href="menu.php">Menu</a>
            <a href="home.php#about">About Us</a>
            <a href="home.php#footer">Contact Us</a>
            <img class="avatar" src="../images/admin-avatar.png" alt="...">
            <p class="user"><?php echo $_SESSION['username']; ?></p>
            <a class= 'mybtn' href="sign_out.php" style="margin-left: 2rem;">Signout</a>
        </nav>

        </header>
        <div class="container-fluid" style="height: 100%">
            <form action="" method="post" style="height: 100%">
            <div class="row" style="height: 100%; margin-top: 8rem;">
                <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar collapse" style="background-color: #fff4d4">
                <div class="position-sticky pt-3 sidebar-sticky">
                    <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active nav-link-color: black" aria-current="page" href="dashboard.php?page=home" style="color: black">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home align-text-bottom" aria-hidden="true"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                        Dashboard
                        </a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link' href='dashboard.php?page=food' style="color: black">
                        Food
                        </a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link' href='dashboard.php?page=cat' style="color: black">
                        Category
                        </a>
                    </li>
                    </ul>
                </div>
                </nav>

                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" style="background-color: #fffaf1;">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Dashboard</h1>
                    <button type="submit" class="mybtn" name="newfood" value=1>NEW FOOD</button>
                    <?php
                        if (isset($_POST['newfood'])) {
                            $_SESSION['newfood'] = 1;
                            header("location: food.php");
                        }else{
                            $_SESSION['newfood'] = 0;
                        }
                    ?>
                    <button type="submit" class="mybtn" name="newcat" value=1>NEW CATEGORY</button>
                    <?php
                        if (isset($_POST['newcat'])) {
                            $_SESSION['newcat'] = 1;
                            header("location: category.php");
                        }else{
                            $_SESSION['newcat'] = 0;
                        }
                    ?>
                </div>
                <div class="container-fluid" id="food">
                    <h4>Foods:</h4>
                    <?php
                        echo "<table class='table table-striped'><tr><th>#</th><th>Name</th><th>Price</th><th>Category</th><th>Quantity</th><th>Option</th></tr>";
                        if (($result=mysqli_query($con,$food_sql)))
                        {

                            while($row=mysqli_fetch_row($result))
                                {
                                    $id=$row[0];
                                    echo "<tr>";
                                    echo "<td>" . "#" . "</td><td>" . $row[1] . 
                                    "</td><td>" . $row[4] . "</td><td>" . $row[2] . "</td><td>" . $row[5] ;
                                    echo "<td> <a href='food.php?id=$id'><button type='button' class='btn btn-lg btn-outline-primary'>Edit</button></a> ";
                                    echo " <a href='delete_food.php?id=$id'><button type='button' class='btn btn-lg btn-outline-danger'>Delete</button></a> </td>";
                                    echo "<tr/>";
                                }
                            
                        }
                        echo "</table>";
                    ?>
                </div>
                <div class="container-fluid" id="cat">
                    <h4>Categories:</h4>
                    <?php
                        echo "<table class='table table-striped'><tr><th>#</th><th>Name</th><th></th><th></th><th></th><th>Option</th></tr>";
                        if (($result=mysqli_query($con,$cat_sql)))
                        {

                            while($row=mysqli_fetch_row($result))
                                {
                                    $id=$row[0];
                                    echo "<tr>";
                                    echo "<td>" . $id . "</td><td>" . $row[1] . 
                                    "</td><td>" . "" . "</td><td>" . "" . "</td><td>" . "" . "</td>";
                                    echo "<td> <a href='category.php?id=$id'><button type='button' class='btn btn-lg btn-outline-primary'>Edit</button></a> ";
                                    echo " <a href='delete_cat.php?id=$id'><button type='button' class='btn btn-lg btn-outline-danger'>Delete</button></a> </td>";
                                    echo "<tr/>";
                                }
                            
                        }
                        echo "</table>";
                    ?>
                </div>
                </main>
            </form>    
            </div>
        </div>
    </body>
</html>