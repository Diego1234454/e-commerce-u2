<?php

// Initialize the session
session_start();

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All-Games </title>
    <link rel="shortcut icon" href="images/studio.png" />
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>

    <div class="header">
    <div class="container" style="padding-bottom: 0px;">
        <div class="navbar">
            <div class="logo">
            <img src="images/All-GamesU.gif" alt="Funny image" width="120px">
            </div>
            <nav>
                <ul id="MenuItems">
                    <li><a href="./"><b>Home </b></a></li>


        <?php
            if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
            ?>
            <li><a href="products.php"><b>Products</b></a></li>
            <li><a href="./account/logout.php"><img src="images/logout.png" width="18px" height="18px"></a></li>
            <?php
            } else {
            ?>
            <li><a href="./account/login.php">Login</a></li>
            <?php

            }
            ?>

                </ul>
            </nav>
            <img src="images/console.png" width="25px" height="25px">
            <img src="images/menu.png" class="menu-icon" onclick="menutoggle()">
        </div>
    </div>
            <div class="row">
                <div class="col-3">
                    <h1>Buy Whatever<br>All in All-Games!</h1>
                    <p>If what you are looking for is unlimited entertainment, you are in the right place!</p>
                    <p>You have not registered? you can join from the comfort of a click!.</p>
                    <a href="./account/register.php" class="btn">Sing Up now! &#8594;</a>
                </div>
                <div class="col-2">
                    <img src="Assets/img/control.png">
                </div>
            </div>
        </div>
    </div>
    

    <!-- Foteer -->
    <div class="footer">
        <div class="container">
            <div class="copyright">
                &copy;
                <script>
                    document.write(new Date().getFullYear())
                </script> Developed by: <a href="" target="_blank">E-Commerce Website</a>
            </div>
        </div>
    </div>

    <!-- js for toggle menu -->
    <script>
        var MenuItems = document.getElementById("MenuItems");

        MenuItems.style.maxHeight = "0px";

        function menutoggle() {
            if (MenuItems.style.maxHeight == "0px") {
                MenuItems.style.maxHeight = "250px";
            } else {
                MenuItems.style.maxHeight = "0px";
            }
        }
    </script>

</body>

</html>