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


    public function getPeopleByType($usertype){

        $people = "SELECT * FROM person WHERE usertype=:usertype";
        $statement = $this->db->prepare($people);
        $statement->execute([':usertype' => $usertype]);
        $peopleData = $statement->fetchAll()[0];

        return $peopleData;
    }

    public function getPeopleByName($name,$lastName){

        $people = "SELECT * FROM person WHERE name LIKE '%:name%' AND lastName LIKE '%:lastName%'";
        $statement = $this->db->prepare($people);
        $statement->execute([':name'=>$name,':lastName'=>$lastName]);
        $peopleData = $statement->fetchAll();

        return $peopleData;
    }


    public function personIdExists($id){

        $success=$this->getPersonData($id);
        if (empty($success)) return "false";
        else return "true";

    }

    public function nameExists($name, $lastName){

	    if (!empty($name) || !empty($lastName))
	    	{
	    	$success = $this->getPeopleByName($name, $lastName);
	    	if (empty($success)) return "false";
	    	  else return "true";
	    	}

	    return "false";
	}

    public function typeExists($usertype){
        $success=$this->getPeopleByType($usertype);
        if (empty($success)) return "false";
        else return "true";
    }

    
    public function getErrorPersonId($id){
        if($this->personExists($id)=="false"){
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



}

?>