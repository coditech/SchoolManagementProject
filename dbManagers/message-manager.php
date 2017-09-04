<?php 

class MessageManager{
    public $db;
    
    public function __construct(PDO $db){
        $this->db = $db;
    }

    public function addMessage($senderId, $recipientId, $text){

        $date = date("Y/m/d");

        $insert = "INSERT INTO message (senderId,recipientId,date,text) VALUES (:senderId,:recipientId,:date,:text)";
        $statement = $this->db->prepare($insert);
        $statement->execute(["senderId"=>$senderId,":recipientId"=>$recipientId,":date"=>$date,":text"=>$text]);
        
    }

    public function getChatIds($id){

        $ids = array();

        $chatsRecieved = "SELECT DISTINCT recipientId WHERE senderId = :senderId";
        $chatsSent     = "SELECT DISTINCT senderId WHERE recipientId = :recipientId";

        $statement = $this->db->prepare($chatsRecieved);
        $statement->execute([':senderId'=>$id]);
        
        $ids[]=$statement->fetchAll();

        $statement = $this->db->prepare($chatsSent);
        $statement->execute([':recipientId'=>$id]);

        $ids[]=$statement->fetchAll();

        return $ids;
    }

    public function getChat($person1,$person2){

        $chat = "SELECT text FROM message WHERE senderId = :senderId1 AND recipientId = :recipientId1
                                            OR  senderId = :senderId2 AND recipientId = :recipientId2
                                            ORDER BY date ASC";
        $statement = $this->db->prepare($chat);  
        $statement->execute([':senderId1'=>$person1,':senderId2'=>$person2,':recipientId1'=>$person2,':recipientId2'=>$person2]);

        return $statement->fetchAll();                                  

    }

}


?>