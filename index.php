<!DOCTYPE html>
<?php

require_once("./dbManagers/db-manager-sqlite.php");

?>
<html>

<head>
    <title></title>
    <link rel="stylesheet" href="style.css" />
</head>

<body>


    <div class="container">


        <header>
            <div class="navigation-bar">
                <ul class="navigation-menu">

                    <li>
                        <a href="">Home</a>
                    </li>
                    <li>
                        <a href="login.php">Login</a>
                    </li>

                </ul>
            </div>
        </header>

        <div class="slideshow-container">
            <div class="mySlides fade">
                <img class="slider-image" src="images/1.jpg" style="width:100%" />
            </div>

            <div class="mySlides fade">
                <img class="slider-image" src="images/2.jpg" style="width:100%" />
            </div>

            <div class="mySlides fade">
                <img class="slider-image" src="images/3.jpg" style="width:100%" />
            </div>

            <div class="mySlides fade">
                <img class="slider-image" src="images/4.jpg" style="width:100%" />
            </div>

            <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
            <a class="next" onclick="plusSlides(1)">&#10095;</a>
        </div>
        <br />


    </div>


</body>

<script src="slideshow.js"></script>

</html>