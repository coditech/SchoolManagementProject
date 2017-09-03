<?php


require_once("./dbManagers/course-manager.php");


class GradeManager{
    public $db;
    
    public function __construct(PDO $db){
        $this->db = $db;
        $this->courseMan = new CourseManager($db);
    }

    public function addGrade($score,$semester,$year,$courseId,$studentId){
        $insert    = "INSERT INTO grade (score,semester,year,courseId,studentId) VALUES (:score,:semester,:year,:courseId,:studentId)";
        $statement = $this->db->prepare($insert);
        $statement->execute([':score'=> $score,':semester'=> $semester,':year'=> $year,':courseId'=> $courseId,':studentId'=> $studentId]);
    }

    public function deleteGrade($id){
        $delete    = "DELETE FROM grade WHERE id=:id";
        $statement = $this->db->prepare($delete);
        $statement->execute([':id'=>$id]);
    }

    public function editGrade($id,$score,$semester,$year,$courseId,$studentId){
        $update = "UPDATE grade SET score=:score, semester=:semester, year=:year, courseId=:courseId,studentId=:studentId WHERE id=:id";
        $statement = $this->db->prepare($update);
        $statement->execute([':id'=> $id,':score'=> $score,':semester'=> $semester,':year'=> $year,':courseId'=> $courseId,':studentId'=> $studentId]);
    }

    public function smallerThanMaxGrade($id, $score){

        $maxGrade= "SELECT c.courseMaxGrade FROM course c, grade g WHERE c.:id = g.courseId ";
        $statement = $this->db->prepare($maxGrade);
        $statement->execute([':id'=> $id]);

        return $score < $statement;

    }

    public function getStudentGrades($studentId,$year){

        $grades = "SELECT * FROM grade WHERE studentId = :studentId AND year = :year";
        $statement = $this->db->prepare($grades);
        $statement->execute([':studentId'=> $studentId,':year'=>$year]);
        $gradeData = $statement->fetchAll();

        $data = array();

        foreach ($gradeData as $grade){
            $dataTemp = array();

            $courseData = $this->courseMan->getCourseData($grade['courseId']);

            $dataTemp['id']=$grade['id'];
            $dataTemp['score']=$grade['score'];
            $dataTemp['semester']=$grade['semester'];
            $dataTemp['year']=$grade['year'];
            $dataTemp['courseId']=$grade['courseId'];
            $dataTemp['studentId']=$grade['studentId'];
            $dataTemp['courseName']=$courseData['courseName'];
            $data[]=$dataTemp;
        }
        
            return $data;
    }

    public function search($score,$semester,$year,$courseId,$studentId){

        $grades = "SELECT * FROM course WHERE score > :score 
                                        AND semester LIKE :semester
                                        AND year LIKE :year
                                        AND courseId LIKE :courseId
                                        AND studentId LIKE :studentId";
        if ($score = null) {
            $score = 0;
        }
        $statement = $this->db->prepare($grades);
        $statement->execute([':score'=> $score,':semester'=> '%'.$semester.'%',':year'=> '%'.$year.'%',':courseId'=> '%'.$courseId.'%',':studentId'=> '%'.$studentId.'%']);

        return $statement->fetchAll();
        
    }

}

?>