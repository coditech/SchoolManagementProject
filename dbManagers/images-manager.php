<?php

class ImagesManager{
    public $db;
    
    public function __construct(PDO $db){
        $this->db = $db;
    }

    public function addImage($pathToImg,$articleId){
        $insert = "INSERT INTO image (pathToImg,articleId) VALUES (:pathToImg,:articleId)";
        $statement = $this->db->prepare($insert);
        $statement->execute([':pathToImg'=> $pathToImg,':articleId'=> $articleId]);        
    }

    public function deleteImage($id){
        $delete = "DELETE FROM article WHERE id=:id";
        $statement = $this->db->prepare($delete);
        $statement->execute([':id'=>$id]);
    }

    
}

?>