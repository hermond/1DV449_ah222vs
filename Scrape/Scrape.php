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
        $url = "http://vhost3.lnu.se:20080/~1dv449/scrape/";
        $data = $this->getDataFromUrl($url);
        var_dump($data);


    }

    public function getDataFromUrl($url)
    {
        $curl = curl_init();
        $username = $_REQUEST['username'];
        $password = $_REQUEST['password'];
        
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($curl);
        curl_close($curl);
        return $data;
    }

}