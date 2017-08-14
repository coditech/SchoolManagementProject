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

        if($path[0]=="articles" && $path[1]=="home"){

            if (isset($_GET["page"])) {
	        $page = $_GET["page"];
            if($page<1){
                $page =1;
            }
            }
            else {
	        $page = 1;
            }               

            $limit=$_GET["limit"];
            $data = $this->sqlToArray($this->articleMan->getArticlesPage($page,$limit));
            $success = $this->articleMan->success($page,$limit);
            $previous = $this->articleMan->previousPages($page,$limit);
            $next = $this->articleMan->nextPages($page,$limit);
            $error = $this->articleMan->getError($page,$limit);

            $jsonArray['success']= $success;
            $jsonArray['data']= $data;
            $jsonArray['previous']=$previous;
            $jsonArray['next']=$next;
            $jsonArray['error']=$error;            

        } else if ($path[0]=="articles" && $path[1]=="article"){

        }


            echo "<pre>";
            print_r($jsonArray);
            echo "</pre>";  
    }

   
}



?>
