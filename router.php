<?php


require_once("./dbManagers/article-manager.php");


class Router
{

    public $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
        $this->articleMan = new ArticleManager($db);
    }

    public function getUrl()
    {
        return "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    }

    public function getPathArray()
    {
        return explode('/', trim(parse_url($this->getUrl(), PHP_URL_PATH), "/"));
    }

    public function sqlToArray($sql)
    {
        return $sql->fetchAll();
    }

    public function route()
    {
        $path = $this->getPathArray();
        $jsonArray = array();


        if ($path[0] == 'api') {
            if ($path[1] == "home") {

                if (isset($_GET["page"])) {
                    $page = $_GET["page"];
                    if ($page < 1) {
                        $page = 1;
                    }
                } else {
                    $page = 1;
                }

                $limit = $_GET["limit"];

                $data = $this->articleMan->getPageData($page, $limit);
                $success = $this->articleMan->successPage($page, $limit);
                $previous = $this->articleMan->previousPages($page, $limit);
                $next = $this->articleMan->nextPages($page, $limit);
                $error = $this->articleMan->getErrorPage($page, $limit);
                $lastPage = $this->articleMan->getNumberOfPages($limit);

                $jsonArray['success'] = $success;
                $jsonArray['data'] = $data;
                $jsonArray['previous'] = $previous;
                $jsonArray['next'] = $next;
                $jsonArray['last'] = $lastPage;
                $jsonArray['error'] = $error;

            } else if ($path[1] == "articles") {

                if($path[2]=="add"){

                $title=$_POST['title'];
                $text=$_POST['text'];
                $files=$_FILES['files'];

                
                $this->articleMan->addArticle($title, $text,$files);
                $success = $this->articleMan->successAddArticle($title,$text,$files);
                $error = $this->articleMan->getErrorAddArticle($title,$text,$files);

                $jsonArray['success'] = $success;
                $jsonArray['error'] = $error;

                } else {

                $id = $_GET["id"];

                $data = $this->articleMan->getArticleData($id);
                $success = $this->articleMan->successArticle($id);
                $error = $this->articleMan->getErrorArticle($id);
                $next = $this->articleMan->nextArticle($id);
                $previous = $this->articleMan->previousArticle($id);

                $jsonArray['success'] = $success;
                $jsonArray['data'] = $data;
                $jsonArray['next'] = $next;
                $jsonArray['previous'] = $previous;
                $jsonArray['error'] = $error;
                }
            }


            header('Content-Type: application/json');
            echo json_encode($jsonArray);
        } /**
         *  Front End Routes
         * */
        else {
            if ($path[0] == '') {
                require 'front/index.html';
            } else if ($path[0] == 'article') {

                require 'front/article.html';
            }
        }
//


    }


}
