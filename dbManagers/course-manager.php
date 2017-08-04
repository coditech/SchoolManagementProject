<?php

class CourseManager{
public $db;
    
    public function __construct(PDO $db){
        $this->db = $db;
    }

    public function addCourse($courseCode, $courseName, $courseMaxGrade, $courseYear, $courseClass, $teacherId ){
        $insert = "INSERT INTO course (courseCode, courseName, courseMaxGrade, courseYear, courseClass, teacherId ) VALUES (:courseCode, :courseName, :courseMaxGrade, :courseYear, :courseClass, :teacherId )";
        $statement = $this->db->prepare($insert);
        $statement->execute([':courseCode'=> $courseCode,':courseName'=> $courseName,':courseMaxGrade'=> $courseMaxGrade,':courseYear'=> $courseYear,':courseClass'=> $courseClass,':teacherId'=> $teacherId]);
    }

    public function deleteCourse($id){
        $delete = "DELETE FROM course WHERE id=:id";
        $statement = $this->db->prepare($delete);
        $statement->execute([':id'=>$id]);
    }

    public function editCourse($id,$courseCode, $courseName, $courseMaxGrade, $courseYear, $courseClass, $teacherId ){
        $update = "UPDATE course  SET courseCode=:courseCode, courseName=:courseName, courseMaxGrade=:courseMaxGrade, courseYear=:courseYear, courseClass=:courseClass, teacherId=:teacherId WHERE id=:id";
        $statement = $this->db->prepare($udpate);
        $statement->execute([':id'=> $id,':courseCode'=> $courseCode,':courseName'=> $courseName,':courseMaxGrade'=> $courseMaxGrade,':courseYear'=> $courseYear,':courseClass'=> $courseClass,':teacherId'=> $teacherId]);
    }


}


?>