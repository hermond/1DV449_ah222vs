<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Hello World
 * Date: 2014-01-13
 * Time: 00:51
 * To change this template use File | Settings | File Templates.
 */


namespace controller;

require_once("model/RssDAL.php");
require_once("../common/model/Article.php");
use model\Article;
use model\RssDAL;

class DoRss {

    private static $searchEngineLandFeed = "http://feeds.searchengineland.com/searchengineland";
    private static $searchEngineWatchFeed = "http://searchenginewatch.com/rss";
    private static $searchEngineJournalFeed = "http://feeds.feedburner.com/SearchEngineJournal";
    private static $mozFeed = "http://feeds.feedburner.com/MozBlog?format=xml";

    private $articles = array();

    private $rssDal;

    public function __construct()
    {
        $this->rssDal = new RssDAL();
    }

    public function doRss()
    {

    $this->readSearchEngineLandRss(self::$searchEngineLandFeed);
    $this->readSearchEngineWatchRss(self::$searchEngineWatchFeed);
    $this->readSearchEngineJournalRss(self::$searchEngineJournalFeed);
    $this->readMozRss(self::$mozFeed);
    $this->rssDal->insertArticles($this->articles);
    }

    public function readSearchEngineLandRss($feedUrl)
    {
        libxml_use_internal_errors(true);
        $xmlDoc = simpleXML_load_file($feedUrl);

        if (!$xmlDoc) {
            echo "Failed loading XML\n";
            foreach(libxml_get_errors() as $error) {
                echo "\t", $error->message;
            }
        }
        foreach($xmlDoc->channel->item as $xmlItem)
        {
            $title = $xmlItem->title;
            $date = strtotime($xmlItem->pubDate);
            $date = date("Y-m-d H:i:s", $date);
            $url= substr($xmlItem->comments, 0, -9);
            if (date('Y-m-d') == date('Y-m-d', strtotime($date))){
                $article = new Article(0 , $title, $url, $date, 1, 0, 0);
                array_push($this->articles, $article);
            }

        }

    }

    public function readSearchEngineWatchRss($feedUrl)
    {
        libxml_use_internal_errors(true);
        $xmlDoc = simpleXML_load_file($feedUrl);

        if (!$xmlDoc) {
            echo "Failed loading XML\n";
            foreach(libxml_get_errors() as $error) {
                echo "\t", $error->message;
            }
        }

        foreach($xmlDoc->channel->item as $xmlItem)
        {
            $title = $xmlItem->title;
            $date = strtotime($xmlItem->pubDate);
            $date = date("Y-m-d H:i:s", $date);
            $url = $xmlItem->link;

            if (date('Y-m-d') == date('Y-m-d', strtotime($date))){
                $article = new Article(0 , $title, $url, $date, 2, 0, 0);
                array_push($this->articles, $article);
            }
        }

    }

    public function readSearchEngineJournalRss($feedUrl)
    {
        libxml_use_internal_errors(true);
        $xmlDoc = simpleXML_load_file($feedUrl);

        if (!$xmlDoc) {
            echo "Failed loading XML\n";
            foreach(libxml_get_errors() as $error) {
                echo "\t", $error->message;
            }
        }
        foreach($xmlDoc->channel->item as $xmlItem)
        {
            $title = $xmlItem->title;
            $date = strtotime($xmlItem->pubDate);
            $date = date("Y-m-d H:i:s", $date);
            $url =substr($xmlItem->comments, 0, -10);

            if (date('Y-m-d') == date('Y-m-d', strtotime($date))){
                $article = new Article(0 , $title, $url, $date, 3, 0, 0);
                array_push($this->articles, $article);
            }
        }

    }

    public function readMozRss($feedUrl)
    {
        libxml_use_internal_errors(true);
        $xmlDoc = simpleXML_load_file($feedUrl);

        if (!$xmlDoc) {
            echo "Failed loading XML\n";
            foreach(libxml_get_errors() as $error) {
                echo "\t", $error->message;
            }
        }

        foreach($xmlDoc->item as $xmlItem)
        {
            $title = $xmlItem->title;
            $date = strtotime($xmlItem->children('dc', true)->date);
            $date = date("Y-m-d H:i:s", $date);
            $url = $xmlItem->children('feedburner', true)->origLink;

            if (date('Y-m-d') == date('Y-m-d', strtotime($date))){
                $article = new Article(0 , $title, $url, $date, 4, 0, 0);
                array_push($this->articles, $article);
            }
        }

    }
}