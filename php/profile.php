<?php

session_start();
require('connection.php');

$id = $_SESSION['userid'];
$info_sql = "SELECT * FROM user where id=$id";
$preorder_sql = "SELECT c.id, c.date, f.name, o.order_qty
                FROM cart c inner join `order` o on c.id = o.cart_id
                inner join food f on f.id = o.food_id
                where c.user_id = $id";
$_SESSION['neworder'] = 0;
$sty = "";

if (isset($_GET['page'])) {
    if ($_GET['page'] == 'info') {
        $sty = "#preorder{display: none;}";
    } else if ($_GET['page'] == 'preorder') {
        $sty = "#info{display: none;}";
    }
}
     
?>

<!DOCTYPE html>
<html lang="en" style="height: 100%">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Profile</title>
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
            <img class="avatar" src="../images/burger-avatar.jpg" alt="...">
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
                        <a class="nav-link active nav-link-color: black" aria-current="page" href="profile.php?page=home" style="color: black">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home align-text-bottom" aria-hidden="true"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                        Profile
                        </a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link' href='profile.php?page=info' style="color: black">
                        Info
                        </a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link' href='profile.php?page=preorder' style="color: black">
                        Pre Orders
                        </a>
                    </li>
                    </ul>
                </div>
                </nav>

                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" style="background-color: #fffaf1;">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Profile</h1>
                    <button type="submit" class="mybtn" name="neworder" value=1>NEW ORDER</button>
                    <?php
                        if (isset($_POST['neworder'])) {
                            $_SESSION['neworder'] = 1;
                            header("location: menu.php");
                        }else{
                            $_SESSION['neworder'] = 0;
                        }
                    ?>
                </div>
                <div class="container-fluid" id="info">
                    <h4>Info:</h4>
                    <?php
                        echo "<table class='table table-striped'><tr><th>#</th><th>Username</th><th>Email</th><th>Password</th><th>Option</th></tr>";
                        if (($result=mysqli_query($con,$info_sql)))
                        {

                            if($row=mysqli_fetch_row($result))
                                {
                                    $id=$row[0];
                                    echo "<tr>";
                                    echo "<td>" . "#" . "</td><td>" . $row[1] . 
                                    "</td><td>" . $row[3] . "</td><td>" . $row[2] . "</td>";
                                    echo "<td> <a href='info.php?id=$id'><button type='button' class='btn btn-lg btn-outline-primary'>Edit</button></a> ";
                                    echo "</td>";
                                    echo "<tr/>";
                                }
                            
                        }
                        echo "</table>";
                    ?>
                </div>
                <div class="container-fluid" id="preorder">
                    <h4>Pre Orders:</h4>
                    <?php
                        echo "<table class='table table-striped'><tr><th>#</th><th>Date</th><th>Food</th><th>Quantity</th><th></th><th></th></tr>";
                        if (($result=mysqli_query($con,$preorder_sql)))
                        {
                            $preid = 0;
                            while($row=mysqli_fetch_row($result))
                                {
                                    $id=$row[0];
                                    echo "<tr>";
                                    if ($preid == $id) {
                                        echo "<td>" . "=>" . "</td><td>" . "=>" . 
                                        "</td><td>" . "$row[2]" . "</td><td>" . "$row[3]" . "</td><td>" . "" . "</td>";
                                        echo "<tr/>";
                                    }else {
                                        echo "<td>" . $id . "</td><td>" . $row[1] . 
                                        "</td><td>" . "$row[2]" . "</td><td>" . "$row[3]" . "</td><td>" . "" . "</td>";
                                        echo "<tr/>";
                                    }
                                    $preid = $id;
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