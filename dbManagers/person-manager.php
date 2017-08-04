<?php


class PersonManager
{
    public $db;
    
    public function __construct(PDO $db){
        $this->db = $db;
    }
    
    public function addPerson($name, $lastName, $gender, $email, $telephone, $userType,$username,$password)
    {
        $insert    = "INSERT INTO person (name,lastName,gender,email,telephone,userType,username,password) VALUES (:name,:lastName,:gender,:email,:telephone,:userType,:username,:password)";
        $statement = $this->db->prepare($insert);
        $statement->execute([':name'=> $name,':lastName'=> $lastName,':gender'=> $gender,':email'=> $email,':telephone'=> $telephone,':userType'=> $userType,':username'=> $username,':password'=> $password ]
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
    
}

?>