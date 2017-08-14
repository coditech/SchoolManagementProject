<?php

    class ArticleManager{
    public $db;
    
    public function __construct(PDO $db){
        $this->db = $db;
    }

    public function addArticle($title,$text){
        $insert = "INSERT INTO article (title,text) VALUES (:title,:text)";
        $statement = $this->db->prepare($insert);
        $statement->execute([':title'=> $title,':text'=> $text]);
    }

    public function deleteArticle($id){
        $delete = "DELETE FROM article WHERE id=:id";
        $statement = $this->db->prepare($delete);
        $statement->execute([':id'=>$id]);
    }

    public function editArticle($id,$title,$text){
        $update = "UPDATE article SET title=:title, text=:text WHERE id=:id";
        $statement = $this->db->prepare($update);
        $statement->execute([':id'=> $id,':title'=> $title,':text'=> $text]
        );
    }

    function getArticlesPage($page,$limit){
        $start = ($page - 1) * $limit;
        $pages = "SELECT * FROM article LIMIT :start,:limit";
        $statement = $this->db->prepare($pages);
        $statement->execute([':start'=>$start,':limit'=> $limit]);
        return $statement;
    }

    function getArticleFeaturedImagePath($articleId){
        $getImage = "SELECT pathToImg FROM image WHERE articleId=:articleId LIMIT 1";
        $statement = $this->db->prepare($getImage);
        $statement->execute([':articleId'=>$articleId]
    );
    foreach($statement as $image){
        $imagePath = $statement['pathToImg'];
        break;
    }
    return $imagePath;
    }

    function success($page,$limit){
        $statement = $this->getArticlesPage($page,$limit);
        $success = $statement->fetchAll();
        if (empty($success))return "false";
        else return "true";
    }

    

    }

?>