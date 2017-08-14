<?php


require_once("./dbManagers/article-manager.php");

class Router{

    public $db;

    public function __construct(PDO $db){
        $this->db = $db;
        $this->articleMan = new ArticleManager($db);
    }

    public function getUrl(){
        return "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    }

    public function getPathArray(){
        return explode('/',trim(parse_url($this->getUrl(), PHP_URL_PATH),"/"));
    }

    public function sqlToArray($sql){
    return $sql->fetchAll();
    }

    public function route(){
        $path = $this->getPathArray();
        $jsonArray=array();

        if($path[0]=="articles"){

            if($_GET["page"]<1){
                $page = 1;
            }
            else if (isset($_GET["page"])) {
	        $page = $_GET["page"];
            }
            else {
	        $page = 1;
            }               

            $limit=$_GET["limit"];
            $data = $this->sqlToArray($this->articleMan->getArticlesPage($page,$limit));
            $success = $this->articleMan->success($page,$limit);
            

            $jsonArray['success']= $success;
            $jsonArray['data']= $data;
            



            echo "<pre>";
            print_r($jsonArray);
            echo "</pre>";

            $asd = array(1,3,4);
            
        }
    }

   
}



?>
