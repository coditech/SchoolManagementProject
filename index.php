<!DOCTYPE html>
<?php

require_once("./dbManagers/db-manager-sqlite.php");

function getArticlesPage($db,$page,$limit){
    $start = ($page - 1) * $limit;
    $articles = $db->query("SELECT * FROM article LIMIT $start,$limit");
    return $articles;
}

function getArticleFeaturedImagePath($db,$articleId){
    $images = $db->query("SELECT pathToImg FROM image WHERE articleId=$articleId LIMIT 1");
    foreach($images as $image){
        $imagePath = $image['pathToImg'];
        break;
    }
    return $imagePath;
}

function articleTemplate($db,$article){
    $title = $article['title'];
    $text = $article['text'];
    $recap = explode(" ",$text);
    $date = $article['date'];
    $id = $article['id'];
    $featuredImagePath = getArticleFeaturedImagePath($db,$id);
    ?>
    <div class="article-title">
        <h1>
            <?php echo $title; ?>
        </h1>
    </div>
    <div class="article-image">
        <img class="article-image" src="<?php echo $featuredImagePath ?>" />
    </div>
    <div class="article-text">
        <p>
            <?php for($i=0;$i<15;$i++){
        echo $recap[$i] . " ";
    }
     ?>
        </p>
    </div>
    <div class="article-link">

        <?php
        echo "<a href=''>Read More</a>";
        ?>
    </div>
    <?php
}

$limit = 2;


if (isset($_GET["page"])) {
	$page = $_GET["page"];
}
else {
	$page = 1;
}

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
                  <div class="pagination">
                <?php

                            $prevPage=$page-1; 
            $nextPage=$page+1;

            if($page == 1){
                echo "<<";
            }   else {
                echo "<a  href='index.php?page=$prevPage'><< </a>";
            }
            
            echo "<a  href='index.php?page=$nextPage'> >></a>";?>
            </div>
            <?php
            
            $list = getArticlesPage($db,$page,$limit);
            foreach($list as $article){
                echo articleTemplate($db,$article);
            }
            ?>
                    <div class="pagination">
            <?php

            $prevPage=$page-1; 
            $nextPage=$page+1;

            if($page == 1){
                echo "<<";
            }   else {
                echo "<a  href='index.php?page=$prevPage'><< </a>";
            }
            
            echo "<a  href='index.php?page=$nextPage'> >></a>";
            

            ?>
 
                    </div>
            </div>
        </body>

        <script src="slideshow.js"></script>

        </html>