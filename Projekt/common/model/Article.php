<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Hello World
 * Date: 2014-01-13
 * Time: 00:33
 * To change this template use File | Settings | File Templates.
 */

namespace model;


class Article {
    public $articleID;

    public $title;

    public $url;

    public $date;

    public $publisherID;

    public $facebookShare;

    public $twitterShare;


    public function __construct($articleID = 0, $title, $url, $date, $publisherID, $facebookShare, $twitterShare)
    {
        $this->articleID = $articleID;
        $this->title = $title;
        $this->url = $url;
        $this->date = $date;
        $this->publisherID = $publisherID;
        $this->facebookShare = $facebookShare;
        $this->twitterShare = $twitterShare;

    }

    public function getArticleID()
    {
        return $this->articleID;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getPublisherID()
    {
        return $this->publisherID;
    }



}