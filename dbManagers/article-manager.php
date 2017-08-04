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

    }

?>