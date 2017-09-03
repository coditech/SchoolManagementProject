<?php
class StudentManager{

    public $db;
    
    public function __construct(PDO $db){
        $this->db = $db;
    }

    public function addStudent($id,$parentId){
        $insert = "INSERT INTO student (id,parentId) VALUES (:id,:parentId)";
        $statement = $this->db->prepare($insert);
        $statement->execute([':id'=>$id,':parentId'=> $parentId]);
    }

    public function deleteStudent($id){
        $delete = "DELETE FROM student WHERE id=:id";
        $statement = $this->db->prepare($delete);
        $statement->execute([':id'=>$id]);
    }

    public function editStudent($id,$parentId){
        $update = "UPDATE student SET parentId=:parentId WHERE id=:id";
        $statement = $this->db->prepare($update);
        $statement->execute([':id'=> $id,':parentId'=> $parentId]);
    }
    
    public function getChildren($parentId){
        $children = "SELECT * FROM person  p, student  s WHERE parentId = :parentId AND p.id = s.id";
        $statement = $this->db->prepare($children);
        $statement->execute([':parentId'=>$parentId]);

        return $statement->fetchAll();
    }

}


 ?>