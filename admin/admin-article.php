<!DOCTYPE html>
<?php
require_once("../dbManagers/db-manager-sqlite.php");
require_once("../dbManagers/article-manager.php");
require_once("../dbManagers/image-manager.php");
$articleMan = new ArticleManager($db);
$imageMan = new ImageManager($db);

if(!empty($_POST['title']) && !empty($_POST['text']) && !empty($_FILES['files']) ){


$title=$_POST['title'];
$text=$_POST['text'];

$articleMan->addArticle($title,$text);

$id=$db->lastInsertId();

$extension=array("jpeg","jpg","png");
foreach($_FILES["files"]["tmp_name"] as $key=>$tmp_name){
    $file_name=$_FILES["files"]["name"][$key];
    $file_tmp=$_FILES["files"]["tmp_name"][$key];
    $ext=pathinfo($file_name,PATHINFO_EXTENSION);
    if(in_array($ext,$extension)){
         if(!file_exists("images/".$file_name)){
                 move_uploaded_file($file_tmp=$_FILES["files"]["tmp_name"][$key],"images/".$file_name);
                 $imageMan->addImage("images/".$file_name,$id);
         }else
             {
                 $filename=basename($file_name,$ext);
                 $newFileName=$filename.time().".".$ext;
                 move_uploaded_file($file_tmp=$_FILES["files"]["tmp_name"][$key],"images/".$newFileName);
                 $imageMan->addImage("images/".$newFileName,$id);
             }
         }
    }
}

 ?>
    <html>

    <head>
        <title>
        </title>
        <link rel="stylesheet" href="/style.css" />
    </head>

    <body>

        <div class="container">
            <form method="post" enctype="multipart/form-data">
                <input type="text" name="title" id="title" placeholder="Title" /><br />
                <textarea rows="4" cols="40" placeholder="Body" name="text">
                </textarea><br />
                <input type="file" name="files[]" multiple/><br /><br />
                <input type="submit" value="add article" />
            </form>
        </div>

    </body>

    </html>