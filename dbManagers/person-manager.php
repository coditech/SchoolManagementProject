<?php



class PersonManager
{
    public $db;
    
    public function __construct(PDO $db){
        $this->db = $db;
    }
    
    public function addPerson($id,$name, $lastName, $gender, $email, $telephone, $userType,$username,$password)
    {
        $date = date("Y/m/d");
        $insert    = "INSERT INTO person (id,name,lastName,gender,email,telephone,userType,username,password,date) VALUES (:id,:name,:lastName,:gender,:email,:telephone,:userType,:username,:password,:date)";
        $statement = $this->db->prepare($insert);
        $statement->execute([':id'=>$id, ':name'=> $name,':lastName'=> $lastName,':gender'=> $gender,':email'=> $email,':telephone'=> $telephone,':userType'=> $userType,':username'=> $username,':password'=> $password,':date'=>$date]);
    }
    
    public function deletePerson($id)
    {
        $delete    = "DELETE FROM person WHERE id=:id";
        $statement = $this->db->prepare($delete);
        $statement->execute([':id'=>$id]);
    }

    public function editPerson($id,$name, $lastName, $gender, $email, $telephone, $userType,$username,$password){
        $update = "UPDATE person SET      name=:name,    lastName=:lastName,      gender=:gender,     email=:email,      telephone=:telephone,       userType=:userType,                     username=:username,  password=:password WHERE id=:id";
        $statement = $this->db->prepare($update);
        $statement->execute([':id'=> $id,':name'=> $name,':lastName'=> $lastName,':gender'=> $gender,':email'=> $email,':telephone'=> $telephone,':userType'=> $userType,':username'=> $username,':password'=> $password]);
    }

    public function getPersonData($id){

        $person = "SELECT * FROM person WHERE id=:id";
        $statement = $this->db->prepare($person);
        $statement->execute([':id' => $id]);
        $personData = $statement->fetchAll()[0];

        return $personData;
    }

    public function getChildren($parentId){

        $children = "SELECT p.id, p.name, p.lastName  FROM person  p, student  s WHERE parentId = :parentId AND p.id = s.id";
        $statement = $this->db->prepare($children);
        $statement->execute([':parentId'=>$parentId]);

        return $statement->fetchAll();
    }

    public function getTeachers($parentId){
        $teachers= "SELECT DISTINCT p.id, p.name, p.lastName FROM person p, student s, course c WHERE s.class=c.courseClass
                                                                                                AND   s.parentId=:parentId
                                                                                                AND   c.teacherId=p.id ";
        $statement = $this->db->prepare($teachers);
        $statement->execute([':parentId'=>$parentId]);

        return $statement->fetchAll();

    }

    public function getStudents($teacherId){
        $students = "SELECT p.id, p.name, p.lastName FROM person p, student s, course c WHERE s.class=c.courseClass
                                                                                        AND   c.teacherId=:teacherId
                                                                                        AND   s.id = p.id  ";
        $statement = $this->db->prepare($students);
        $statement->execute([':teacherId'=>$teacherId]);

        $studentsData = $statement->fetchAll();
        $data = array();

        foreach($studentsData as $student){
            $dataTemp = array();
            $parent   = $this->getParent($student['id']);
            $dataTemp['studentid']=$student['id'];
            $dataTemp['studentname']=$student['name'];
            $dataTemp['studentlastname']=$student['lastName'];
            $dataTemp['parentid']=$parent['id'];
            $dataTemp['parentid']=$parent['name'];
            $dataTemp['parentid']=$parent['lastName'];
            $data[] = $dataTemp;
        }

        return $data;

    }

    public function getParent($studentId){
        $parent = "SELECT p.id, p.name, p.lastName,p.telephone FROM person p, student s WHERE s.id=:studentId AND p.id = s.parentId";
        $statement = $this->db->prepare($parent);
        $statement->execute([':studentId'=>$studentId]);

        return $statement->fetchAll()[0];
    }


    public function login($username,$password){

        $person = "SELECT * FROM person WHERE username = :username AND password = :password";
        $statement = $this->db->prepare($person);
        $statement->execute([':username'=>$username,':password'=>$password]);

        $personData = $statement->fetchAll()[0];

        if(empty($personData)){
            return false;
        } else{
            $_SESSION['id']=$personData['id'];
            $_SESSION['username']=$personData['username'];
            $_SESSION['userType']=$personData['userType'];
            return true;
        }
        
    }

    public function logout(){
            session_destroy();
    }

    public function personIdExists($id){

        $success=$this->getPersonData($id);
        if (empty($success)) return false;
        else return true;

    }

    
    public function getErrorPersonId($id){
        if($this->personIdExists($id)==false){
            return "Invalid Id or Id does not exist";
        } else {
            return "All Good No Errors";
        }
    }

    public function getErrorType($usertype){
        if($this->typeExists($usertype)==false){
            return "Invalid Type or Type does not exist";
        } else {
            return "All Good No Errors";
        }
    }

    public function getErrorName($name,$lastName){
        if (empty($name) && empty($lastName)){
            return "You Need To Input At Least A First Name or A Last Name";
        }else if($this->nameExists($name, $lastName)==false) {
            return "Name Does Not Exist";
        }
        else return "All Good No Errors";
    }

    public function getErrorLogin($username,$password){

        if($this->login($username,$password)==false){
            return "Incorrect Username Or Password";
        }else return "All Good No Errors";

    }

    
    public function search($id,$name, $lastName, $gender, $email, $telephone, $userType,$username){
        $search = "SELECT * FROM person WHERE
                                            id LIKE :id AND
                                            name LIKE :name AND
                                            lastName LIKE :lastName AND
                                            gender LIKE :gender AND
                                            email LIKE :email AND
                                            telephone LIKE :telephone AND
                                            userType LIKE :userType AND
                                            username LIKE :username ";
        $statement = $this->db->prepare($search);
        $statement->execute([':id' => '%'.$id.'%',
                             ':name' => '%'.$name.'%',
                             ':lastName' => '%'.$lastName.'%',
                             ':gender' => '%'.$gender.'%',
                             ':email' => '%'.$email.'%',
                             ':telephone' => '%'.$telephone.'%',
                             ':userType' => '%'.$userType.'%',
                             ':username' => '%'.$username.'%']);
        $searchData = $statement->fetchAll();
        return $searchData;
    }
}

?>