<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Hello World
 * Date: 2014-01-15
 * Time: 11:48
 * To change this template use File | Settings | File Templates.
 */

namespace model;
require_once("../common/model/BaseDAL.php");

use model\Article;
use model\BaseDAL;

class SharedCountDAL extends BaseDAL {

    public function getAllArticles(){

        $statement = parent::getDBConnection()->prepare("SELECT ArticleID, Title, Url, Date, PublisherID, FacebookShare, TwitterShare FROM Article");


        $statement->execute();

        $articles = array();

        while ($row = $statement->fetch(\PDO::FETCH_ASSOC)) {
            try {

                $articles[] = new Article($row['ArticleID'], $row['Title'], $row['Url'], $row['Date'], $row['PublisherID'], $row['FacebookShare'], $row['TwitterShare']);

            }

            catch (\Exception $e) {

            }

        }

        return $articles;


    }

    public function updateAllArticles($articles){

    foreach($articles as $article)
    {

     $statement = parent::getDBConnection()->prepare("UPDATE Article SET Title = :title, Url = :url, Date = :date,
     PublisherID = :publisherID,FacebookShare = :facebookShare, TwitterShare = :twitterShare WHERE ArticleID = :articleID");

    $statement->bindParam(':title', $article->title, \PDO::PARAM_STR);
    $statement->bindParam(':url', $article->url, \PDO::PARAM_STR);
    $statement->bindParam(':date', $article->date, \PDO::PARAM_STR);
    $statement->bindParam(':publisherID', $article->publisherID, \PDO::PARAM_INT);
    $statement->bindParam(':facebookShare', $article->facebookShare, \PDO::PARAM_INT);
    $statement->bindParam(':twitterShare', $article->twitterShare, \PDO::PARAM_INT);
    $statement->bindParam(':articleID', $article->articleID, \PDO::PARAM_INT);

    $statement->execute();
    }

    }

}