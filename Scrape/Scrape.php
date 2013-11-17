<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Hello World
 * Date: 2013-11-13
 * Time: 14:25
 * To change this template use File | Settings | File Templates.
 */

class Scrape {

    public function Scrape()
    {
        $url = "http://vhost3.lnu.se:20080/~1dv449/scrape/check.php";
        return $this->getDataFromUrl($url);


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

        $theDOM = new DOM();

    }

}