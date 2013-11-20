<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Hello World
 * Date: 2013-11-13
 * Time: 14:25
 * To change this template use File | Settings | File Templates.
 */

class Scrape {

    private $ScrapeDAL;

    private static $url = "http://vhost3.lnu.se:20080/~1dv449/scrape/check.php";

    public function construct__()
    {
        $this->ScrapeDAL = new ScrapeDAL();
    }

    public function Scrape()
    {

        $this->getDataFromUrl(self::$url);


    }

    public function getDataFromUrl($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $post_arr = array(
          "username"=>"admin",
            "password"=>"admin"
        );

        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_arr);
      $cookie = "kaka.txt";


        //curl_setopt($ch, CURLOPT_HEADER, 1);
        //curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__)."/".$cookie);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);



        $data = curl_exec($ch);
        curl_close($ch);
        //var_dump($data);
         $this->getDOMContent($data);
    }

    public function getDOMContent($data)
    {

        $theDOM = new DOMDocument();
        if ($theDOM->loadHTML($data))
        {
            $xpath = new DOMXPath($theDOM);
            $items = $xpath->query("//table[@class='table table-striped']/tr/td[1]/a/@href");
            for ($i=0; $i < $items->length; $i++)
            {
            $this->ScrapeProducerPage((string)$items->item($i)->nodeValue);
            }
        }
        else
        {
           echo "Error";
        }

    }

    public function ScrapeProducerPage($link)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::$url.$link);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);


        $cookie = "kaka.txt";

        curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__)."/".$cookie);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);



        $data = curl_exec($ch);
        curl_close($ch);

    }

}