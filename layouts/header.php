<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Commerce Products</title>
    <link rel="shortcut icon" href="images/A.jpg" />
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="js/js-image-zoom.js"></script>
</head>

<body>

    <div class="container" style="padding-bottom: 0px;">
        <div class="navbar">
            <div class="logo">
            <img src="images/All-GamesU.gif" alt="Funny image" width="120px">
            </div>
            <nav>
                <ul id="MenuItems">
                    <li><a href="./"><b>Home</b></a></li>
 <?php
            if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
            ?>
            <li><a href="products.php"><b>Products</b></a></li>
            <li><a href="./account/logout.php"><img src="images/logout.png" width="30px" height="30px"></a></li>
            <?php
            } else {
            ?>
            <li><a href="./account/login.php">Login</a></li>
            <?php

            }
            ?>
                </ul>
            </nav>
            <img src="images/console.png" width="30px" height="30px">
            <img src="images/menu.png" class="menu-icon" onclick="menutoggle()">
        </div>
    </div>
</body>