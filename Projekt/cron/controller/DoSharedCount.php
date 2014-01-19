<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Hello World
 * Date: 2014-01-15
 * Time: 11:48
 * To change this template use File | Settings | File Templates.
 */

namespace controller;

require_once("model/SharedCountDAL.php");
use model\SharedCountDAL;

class DoSharedCount {

    private $sharedCountDAL;


    public function __construct()
    {
        $this->sharedCountDAL = new SharedCountDAL();
    }


    public function getSharedCount()
    {


        $articles = $this->sharedCountDAL->getAllArticles();

        $updatedArticles = array();
        foreach($articles as $article)
        {
            $facebookShares = $this->getSharesAndTweets($article->url, 1);
            $article->facebookShare = $facebookShares[0]["total_count"];
            $twitterShares = $this->getSharesAndTweets($article->url, 2);
            $article->twitterShare = $twitterShares["count"];
            $updatedArticles[] = $article;
        }

        $this->sharedCountDAL->updateAllArticles($articles);

    }

    public function getSharesAndTweets($url, $number)
    {
        if($number == 1){
        $api = "http://api.facebook.com/method/links.getStats?urls=".$url."&format=json";
        }else{
        $api = "http://urls.api.twitter.com/1/urls/count.json?url=".$url;
        }
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, $api);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $data = curl_exec($ch);
        $data = json_decode($data,true);
        curl_close($ch);

        //var_dump($data);
        return $data;

    }

}