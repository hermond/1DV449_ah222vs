<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Hello World
 * Date: 2013-11-21
 * Time: 02:46
 * To change this template use File | Settings | File Templates.
 */

class View {

    private $scrapeDAL;
    private static $isScraping = "scrape";
    private static $isShowingAll = "showall";

    public function __construct()
    {

        $this->scrapeDAL = new ScrapeDAL();
    }


    public function getPage()
    {

        $html =
        "<!DOCTYPE html>
        <html>
        <head>
        <title>Producenter</title>
        <meta http-equiv='content-type' content='text/html; charset=utf-8'/>
        <link rel='stylesheet' type='text/css' href='style.css'>
        </head>

        <body>
        <div id='container'>

        <div id='header'>
        <h1>Laboration 1 - ah222vs</h1>
        <a href='index.php'>Hem</a>
        <a href='?".self::$isScraping."'>Skrapa</a>
        <a href='?".self::$isShowingAll."'>Visa alla skrapningar som gjorts</a>
        </div>";

        if($this->isShowingAll())
        {
        $producers = $this->scrapeDAL->getProducersFromAllScrapes();
        }
        else
        {
         $producers = $this->scrapeDAL->getProducersFromLatestScrape();
        }

        foreach ($producers as $producer)
        {
            $html .= "<div class='producer-box'>
            <p><span class='bold'>Namn: </span>".$producer->getName()."</p>
            <p><span class='bold'>Producent ID: </span>".$producer->getID()."</p>";

            if(preg_match("/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/",$producer->getWebsite())){
            $html .= "<p><span class='bold'>Hemsida: </span><a href='".$producer->getWebsite()."'>".$producer->getWebsite()."</a></p>";
            }
            else
            {
            $html .= "<p><span class='bold'>Hemsida: </span>Finns ej eller fungerar inte</p>";
            }


            $html .= "<p><span class='bold'>Ort: </span>".$producer->getCity()."</p>
            <p><span class='bold'>Http-status: </span>".$producer->getStatus()."</p>
            <p><span class='bold'>Skrapad: </span>".$producer->getDateScraped()."</p>
            </div>
            ";


        }

        $html .=
        "
        </div>
        </body>
        </html>";

        return $html;

    }

    public function isScraping()
    {
        return isset($_GET[self::$isScraping]);
    }

    public function isShowingAll()
    {
        return isset($_GET[self::$isShowingAll]);
    }
}
