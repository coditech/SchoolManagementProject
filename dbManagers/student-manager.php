<?php
class StudentManager{

    public $db;
    
    public function __construct(PDO $db){
        $this->db = $db;
    }

        public function addStudent($parentId,$class){
        $insert = "INSERT INTO student (parentId,class) VALUES (:parentId,:class)";
        $statement = $this->db->prepare($insert);
        $statement->execute([':parentId'=> $parentId,':class'=> $class]);
    }

            public function deleteStudent($id){
        $delete = "DELETE FROM student WHERE id=:id";
        $statement = $this->db->prepare($delete);
        $statement->execute([':id'=>$id]);
    }

        public function editStudent($id,$parentId,$class){
        $update = "UPDATE student SET parentId=:parentId, class=:class WHERE id=:id";
        $statement = $this->db->prepare($update);
        $statement->execute([':id'=> $id,':parentId'=> $parentId,':class'=> $class]);
    }

}


 ?>