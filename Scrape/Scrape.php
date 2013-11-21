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
    private static $loggedInUrl = "http://vhost3.lnu.se:20080/~1dv449/scrape/secure/";

    private $producers = array();

    public function __construct()
    {
        $this->ScrapeDAL = new ScrapeDAL();

    }

    public function ScrapeIt()
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

        curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__)."/".$cookie);
        curl_setopt($ch, CURLOPT_COOKIEFILE, dirname(__FILE__)."/".$cookie);


        $data = curl_exec($ch);

        $data = @mb_convert_encoding($data, 'HTML-ENTITIES', 'utf-8');
        curl_close($ch);
         $this->getDOMContent($data);
    }

    public function getDOMContent($data)
    {

        $theDOM = new DOMDocument();
        if ($theDOM->loadHTML($data))
        {
            $xpath = new DOMXPath($theDOM);
            $items = $xpath->query("//table[@class='table table-striped']/tr/td[1]/a");
            foreach ($items as $item)
            {

            $this->ScrapeProducerPage($item->nodeValue, $item->getAttribute("href") );

            }
        }
        else
        {
           echo "Error";
        }

    }

    public function ScrapeProducerPage($name, $link)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::$loggedInUrl.$link);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);


        $cookie = "kaka.txt";
        //curl_setopt($ch, CURLOPT_HEADER, 1);
        //curl_setopt($ch, CURLINFO_HEADER_OUT, true);

        curl_setopt($ch, CURLOPT_COOKIEFILE, dirname(__FILE__)."/".$cookie);

        $data = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);
        $producerID = filter_var($link, FILTER_SANITIZE_NUMBER_INT);
        $this->getDOMContentFromProducerPage($httpcode, $name, $producerID, $data);

    }

    public function getDOMContentFromProducerPage($httpCode, $name, $producerID, $data)
    {
        //echo $data;
        if($httpCode>=200 && $httpCode<300)
        {
        $htmlParser = new simple_html_dom();
        $htmlParser->load($data);

        $city = substr($htmlParser->find('span.ort', 0)->plaintext, 5);
            if ($htmlParser->find('div.hero-unit a', 0)!=null)
            {
                 $website = $htmlParser->find('div.hero-unit a', 0)->plaintext;
            }
            else{
                $website = "Hemsida saknas";
            }

            $producer = new Producer($name, $producerID, $website, $city, $httpCode, date("Y-m-d H:i:s"));
        }
        else
        {

            $producer = new Producer($name, $producerID, "Hemsida saknas", "Ort Saknas", $httpCode, date("Y-m-d H:i:s"));
        }

        $this->ScrapeDAL->AddProducer($producer);

    }
}