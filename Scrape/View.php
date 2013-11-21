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
        <meta charset='UTF-8'>
        <meta http-equiv='content-language' content='sv'>
        <link rel='stylesheet' type='text/css' href='style/frontend.css'>
        </head>

        <body>
        <div id ='container'>
        <div id = 'navigation'>
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
            <p><span class='bold'>Producent ID: </span>".$producer->getID()."</p>
            <p><span class='bold'>Hemsida: </span>".$producer->getWebsite()."</p>
            <p><span class='bold'>Ort: </span>".$producer->getCity()."</p>
            <p><span class='bold'>Http-status: </span>".$producer->getStatus()."</p>
            <p><span class='bold'>Senaste skrapad: </span>".$producer->getDateScraped()."</p>
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
