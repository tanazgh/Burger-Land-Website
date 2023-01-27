<?php 
session_start();
require('connection.php');

$sql = "SELECT f.id, f.name, f.description, f.img_addr, f.price, f.qty
        from food as f join cat as c on f.cat_id = c.id where c.title = ";

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>BurgerLand</title>
        <!-- StyleSheets -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>
        <script src="../js/menu.js"></script>
        <link rel="stylesheet" href="../css/styles.css?v=<?php echo time(); ?>">
    </head>
    <body>

        <header class="header">
        <a href="/" class="logo">Burger<span class="yellow">Land</span></a>

        <nav class="navbar">
            <a href="home.php">Home</a>
            <a href="home.php#services">Services</a>
            <a class="current" href="#">Menu</a>
            <a href="home.php#about">About Us</a>
            <a href="home.php#footer">Contact Us</a>
            <a href="login.php" class="mybtn">Login</a>
        </nav>

        </header>
        <div class="page-header mb-0">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h2>Food Menu</h2>
                    </div>
                    <div class="col-12">
                        <a href="">Home</a>
                        <a href="">Menu</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center">
        <div class="mysidebar rounded">
            <h3><img src="../images/cart.svg"> your cart</h3>
            <br>
            <div id="order-list"></div>
            <br>
            <?php
            $user = '';
            if(isset($_SESSION['userid'])){
                $user = $_SESSION['userid'];
            }
            ?>
            <a style="width: 100%; text-align: center" onclick="submitOrder(
            <?php echo $user ?>
            )" class="mybtn">Buy</a>
        </div>
        <div class="menu">
        <!-- burger menu -->
        <?php
        $sql_cat = "SELECT title FROM cat";
        $cats = [];
        if (($result=mysqli_query($con,$sql_cat))){
            $count = 0;
            $cats = array();
            while($row1=mysqli_fetch_row($result)){
                $cats[$count] = $row1[0];
                $count += 1;
            }
        }
        for($i = 0; $i < count($cats); $i++){
            $sql_temp = $sql . "'$cats[$i]'";
            echo '<div class="album py-5 bg-light myalbum rounded"><h1 class="cat">' . $cats[$i] . '</h1>
                <hr><div class="container"><div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">';
            if (($result=mysqli_query($con,$sql_temp))){
                while($row=mysqli_fetch_row($result)){
                    $food_id = $row[0]; $name = $row[1]; $description = $row[2]; $img_addr = $row[3]; $price = $row[4]; $qty = $row[5];
                    echo "<div class='col'><div class='card shadow-sm'>";
                    echo "<img  class='bd-placeholder-img card-img-top' src='../images/$img_addr' width='100%' height='30%' alt='...'>";
                    echo "<div class='card-body'>";
                    echo "<h3 class='card-title'>$name</h3>";
                    echo "<p class='card-text'>$description</p>";
                    echo "<div class='d-flex justify-content-between align-items-center'>";
                    echo "<div id='number$food_id'>";
                    echo "<a onclick='addToCart($food_id, $qty, " . '"' . $name . '"' . ", $price)' class='orderbtn bi bi-cart-plus'>";
                    echo "<svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-cart-plus' viewBox='0 0 16 16'>" . 
                            "<path d='M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z'/>" .
                            "<path d='M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z'/>" .
                        "</svg>";
                    echo "add to cart</a>";
                    echo "</div>";
                    echo "<small class='price'>" . $price . "$</small>";
                    echo "</div></div></div></div>";
                }
    
            }
            echo "</div></div></div>";
        }
        ?>
        </div>
        </div>
    </body>
</html>    