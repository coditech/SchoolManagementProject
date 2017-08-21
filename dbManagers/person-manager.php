<?php

class PersonManager
{
    public $db;
    
    public function __construct(PDO $db){
        $this->db = $db;
    }
    
    public function addPerson($id,$name, $lastName, $gender, $email, $telephone, $userType,$username,$password)
    {
        $insert    = "INSERT INTO person (id,name,lastName,gender,email,telephone,userType,username,password) VALUES (:id,:name,:lastName,:gender,:email,:telephone,:userType,:username,:password)";
        $statement = $this->db->prepare($insert);
        $statement->execute([':id'=>$id, ':name'=> $name,':lastName'=> $lastName,':gender'=> $gender,':email'=> $email,':telephone'=> $telephone,':userType'=> $userType,':username'=> $username,':password'=> $password ]
        );
    }
    
    public function deletePerson($id)
    {
        $delete    = "DELETE FROM person WHERE id=:id";
        $statement = $this->db->prepare($delete);
        $statement->execute([':id'=>$id]);
    }

    public function editPerson($id,$name, $lastName, $gender, $email, $telephone, $userType){
        $update = "UPDATE person SET name=:name, lastName=:lastName, gender=:gender, email=:email,telephone=:telephone WHERE id=:id";
        $statement = $this->db->prepare($update);
        $statement->execute([':id'=> $id,':name'=> $name,':lastName'=> $lastName,':gender'=> $gender,':email'=> $email,':telephone'=> $telephone,':userType'=> $userType]);
    }

    public function getPersonData($id){

        $person = "SELECT * FROM person WHERE id=:id";
        $statement = $this->db->prepare($article);
        $statement->execute([':id' => $id]);
        $personData = $statement->fetchAll()[0];

        return $personData;
    }

    public function personExists($id){

        $success=$this->getPersonData($id);
        if (empty($success)) return "false";
        else return "true";

    }
    
    
}

?>