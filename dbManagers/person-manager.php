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


    public function login($username,$password){

        $person = "SELECT * FROM person WHERE username = :username AND password = :password";
        $statement = $this->db->prepare($person);
        $statement->execute([':username'=>$username,':password'=>$password]);

        $personData = $statement->fetchAll();

        if(empty($personData)){
            return 'false';
        } else{
            $_SESSION['id']=$personData['id'];
            $_SESSION['username']=$personData['username'];
            $_SESSION['userType']=$personData['userType'];
            return 'true';
        }
        
    }

    public function logout(){
                            session_destroy();
    }

    public function personIdExists($id){

        $success=$this->getPersonData($id);
        if (empty($success)) return "false";
        else return "true";

    }

    
    public function getErrorPersonId($id){
        if($this->personIdExists($id)=="false"){
            return "Invalid Id or Id does not exist";
        } else {
            return "All Good No Errors";
        }
    }

    public function getErrorType($usertype){
        if($this->typeExists($usertype)=="false"){
            return "Invalid Type or Type does not exist";
        } else {
            return "All Good No Errors";
        }
    }

    public function getErrorName($name,$lastName){
        if (empty($name) && empty($lastName)){
            return "You Need To Input At Least A First Name or A Last Name";
        }else if($this->nameExists($name, $lastName)=="false") {
            return "Name Does Not Exist";
        }
        else return "All Good No Errors";
    }

    public function getErrorLogin($username,$password){

        if($this->loginUser($username,$password)=="false"){
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