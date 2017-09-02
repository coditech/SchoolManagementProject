<?php 

class MessagesManager{
    public $db;
    
    public function __construct(PDO $db){
        $this->db = $db;
    }

    public function addMessage($senderId, $recipientId, $text){

        $insert = "INSERT INTO message (senderId,recipientId,text) VALUES (:senderId,:recipientId,:text)";
        $statement = $this->db->prepare($insert);
        $statement->execute(["senderId"=>$senderId,":recipientId"=>$recipientId,":text"=>$text]);
        
    }

}


?>