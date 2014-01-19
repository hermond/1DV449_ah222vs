<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Hello World
 * Date: 2014-01-16
 * Time: 15:59
 * To change this template use File | Settings | File Templates.
 */

namespace model;
require_once("common/model/BaseDAL.php");
require_once("common/model/Article.php");

class ArticleDAL extends BaseDAL {

    public  $last24HoursSql = "> DATE_SUB( NOW(), INTERVAL 24 HOUR)";
    public $last48HoursSql = "> DATE_SUB( NOW(), INTERVAL 48 HOUR)";
    public $last7DaysSql = "<= NOW() AND Date >= DATE_SUB(Date, INTERVAL 7 DAY)";
    public $last30DaysSql = "<= NOW() AND Date >= DATE_SUB(Date, INTERVAL 30 DAY)";

    public function getArticles($sql)
    {

        $statement = parent::getDBConnection()->prepare("SELECT ArticleID, Title, Url, Date, PublisherID, FacebookShare, TwitterShare FROM Article WHERE DATE" . $sql . "ORDER BY (FacebookShare+TwitterShare) DESC");

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

}