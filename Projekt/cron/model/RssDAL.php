<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Hello World
 * Date: 2014-01-14
 * Time: 15:06
 * To change this template use File | Settings | File Templates.
 */

namespace model;
require_once("../common/model/BaseDAL.php");

class RssDAL extends BaseDAL{



    public function insertArticles($articles){
    foreach($articles as $article)
    {

        if($this->doesArticleExist($article->url) == false)
        {
         $statement = parent::getDBConnection()->prepare("INSERT INTO Article (Title, Url, Date, PublisherID)
        VALUES (:title, :url, :date, :publisherID)");

            $statement->bindParam(':title', $article->title, \PDO::PARAM_STR);
            $statement->bindParam(':url', $article->url, \PDO::PARAM_STR);
            $statement->bindParam(':date', $article->date, \PDO::PARAM_STR);
            $statement->bindParam(':publisherID', $article->publisherID, \PDO::PARAM_INT);

            $statement->execute();
        }
    }


    }

    private function doesArticleExist($url)
    {

        $statement = $this->getDBConnection()->prepare("SELECT Url FROM Article WHERE Url = :url");
        $statement->bindParam(':url', $url, \PDO::PARAM_STR);
        $statement->execute();
        $row = $statement->fetch(\PDO::FETCH_ASSOC);

        if($row)
        {
            return true;
        }else{
            return false;
        }

    }


}