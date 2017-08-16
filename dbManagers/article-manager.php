<?php

    class ArticleManager{
    public $db;
    
    public function __construct(PDO $db){
        $this->db = $db;
    }

    public function addArticle($title,$text){
        $insert = "INSERT INTO article (title,text) VALUES (:title,:text)";
        $statement = $this->db->prepare($insert);
        $statement->execute([':title'=> $title,':text'=> $text]);
    }

    public function deleteArticle($id){
        $delete = "DELETE FROM article WHERE id=:id";
        $statement = $this->db->prepare($delete);
        $statement->execute([':id'=>$id]);
    }

    public function editArticle($id,$title,$text){
        $update = "UPDATE article SET title=:title, text=:text WHERE id=:id";
        $statement = $this->db->prepare($update);
        $statement->execute([':id'=> $id,':title'=> $title,':text'=> $text]
        );
    }

    public function getArticleData($id){
        $article = "SELECT * FROM article WHERE id=:id";
        $statement = $this->db->prepare($article);
        $statement->execute([':id'=> $id]);
        $articleData = $statement->fetchAll()[0];

        if (!empty($articleData)){
        $articleData['featuredimage'] = $this->getArticleFeaturedImagePath($id);
        $articleData[4] = $this->getArticleFeaturedImagePath($id);
        }
        
        return $articleData;
    }

    function getArticlesPage($page,$limit){
        $start = ($page - 1) * $limit;
        $pages = "SELECT * FROM article LIMIT :start,:limit";
        $statement = $this->db->prepare($pages);
        $statement->execute([':start'=>$start,':limit'=> $limit]);
        return $statement;
    }

    function getArticleFeaturedImagePath($articleId){
        $getImage = "SELECT pathToImg FROM image WHERE articleId=:articleId LIMIT 1";
        $statement = $this->db->prepare($getImage);
        $statement->execute([':articleId'=>$articleId]
    );
    foreach($statement as $image){
        $imagePath = $image['pathToImg'];
        break;
    }
        return $imagePath;
    }

    function getData($page,$limit){
        $articlePage = $this->getArticlesPage($page,$limit);
        $articlePageData = $articlePage->fetchAll();
        $data = array();
        foreach ($articlePageData as $article){
            $dataTemp = array();
            $dataTemp['id']=$article['id'];
            $dataTemp['title']=$article['title'];
            $dataTemp['text']=$article['text'];
            $dataTemp['date']=$article['date'];
            $dataTemp['featuredimage']=$this->getArticleFeaturedImagePath($article['id']);
            $data[]=$dataTemp;
        }
        return $data;    
    }

    function getTotalArticles(){
        $totalArticles = "SELECT count(*) FROM article";
        $statement = $this->db->prepare($totalArticles);
        $statement->execute();
        return $statement->fetchAll()[0][0];
    }

    function getNumberOfPages($limit){
        $totalArticles = $this->getTotalArticles();
        return ceil($totalArticles/$limit);
    }

    function successPage($page,$limit){
        $statement = $this->getArticlesPage($page,$limit);
        $success = $statement->fetchAll();
        if (empty($success))return "false";
        else return "true"; 
    }

    function successArticle($id){
        $success = $this->getArticleData($id);
         if (empty($success))return "false";
        else return "true"; 
    }

    function previousPages($page,$limit){
        $totalPages = $this->getNumberOfPages($limit);
        if ($page == 1) {
            return array("","");
        }  else if ($page == 2 && $page <= $totalPages ){
            return array("",1);
        }  else if ($page > 2 && $page <= $totalPages){
            return array($page-2,$page-1);
        }  else return array();
    }

    function nextPages($page,$limit){
        $totalPages = $this->getNumberOfPages($limit);
        if ($page == $totalPages){
            return array("","");
        } else if($page == ($totalPages-1)) {
            return array($totalPages,"");
        } else if ($page>0 && $page <= $totalPages-2){
            return array($page+1,$page+2);
        } else return array();
    }

    function nextArticle($id){
        $nextId = "SELECT id FROM article WHERE id > :id ORDER BY id ASC LIMIT 1";
        $statement = $this->db->prepare($nextId);
        $statement->execute([':id'=> $id]);
        $next=$statement->fetchAll()[0][0];

        if($this->successArticle($id)=="true"){
            return $this->getArticleData($next);
        } else {
            return array();
        }
    }

    function previousArticle($id){
        $previousId = "SELECT id FROM article WHERE id < :id ORDER BY id DESC LIMIT 1";
        $statement = $this->db->prepare($previousId);
        $statement->execute([':id'=> $id]);
        $prev=$statement->fetchAll()[0][0];

        if($this->successArticle($id)=="true"){
            return $this->getArticleData($prev);
        } else {
            return array();
        }
    }    

    function getErrorPage($page,$limit){
        if ($this->successPage($page,$limit)=="false"){
            $error = "This Page is Out Of Range";
        } else {
            $error = "All Good No Errors";
        }
        return $error;
    }

    function getErrorArticle($id){
        if ($this->successArticle($id)=="false"){
            $error = "This Article Id Does Not Exist";
        } else {
            $error = "All Good No Errors";
        }
        return $error;
    }

    }

?>