<?php 

require_once("./dbManagers/person-manager.php");

class MessageManager{
    public $db;
    
    public function __construct(PDO $db){
        $this->db = $db;
        $this->personMan  = new PersonManager($db);
    }

    public function addMessage($senderId, $recipientId, $text){

        $date = date("Y/m/d");

        $insert = "INSERT INTO message (senderId,recipientId,date,text) VALUES (:senderId,:recipientId,:date,:text)";
        $statement = $this->db->prepare($insert);
        $statement->execute(["senderId"=>$senderId,":recipientId"=>$recipientId,":date"=>$date,":text"=>$text]);
        
    }

    public function getChats($id){

        $ids = array();
        $data = array();

        $chatsRecieved = "SELECT DISTINCT recipientId FROM message WHERE senderId = :senderId";
        $chatsSent     = "SELECT DISTINCT senderId FROM message WHERE recipientId = :recipientId";

        $statement = $this->db->prepare($chatsRecieved);
        $statement->execute([':senderId'=>$id]);
        
        $ids = $statement->fetchAll();


        $statement = $this->db->prepare($chatsSent);
        $statement->execute([':recipientId'=>$id]);

        $ids2 = $statement->fetchAll();
        
        $extract = function($v){ return $v[0];};

        $ids = array_merge($ids,$ids2);
        $ids = array_map($extract,$ids);
    

        $uniqueIds = array_unique($ids);

        foreach($uniqueIds as $id){

            $dataTemp = array();

            $person = $this->personMan->getPersonData($id);

            $dataTemp['id']=$id;
            $dataTemp['name']=$person['name'];
            $dataTemp['lastname']=$person['lastName'];
            
            $data[]=$dataTemp;
        }

        return $data;
    }

    public function getChat($person1,$person2){

        $chat = "SELECT senderId, text FROM message WHERE senderId = :senderId1 AND recipientId = :recipientId1
                                            OR  senderId = :senderId2 AND recipientId = :recipientId2
                                            ORDER BY date ASC";
        $statement = $this->db->prepare($chat);  
        $statement->execute([':senderId1'=>$person1,':senderId2'=>$person2,':recipientId1'=>$person2,':recipientId2'=>$person1]);

        return $statement->fetchAll();                                  

    }

}


?>