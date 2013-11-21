<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Hello World
 * Date: 2013-11-21
 * Time: 00:09
 * To change this template use File | Settings | File Templates.
 */

class Producer {

    private $name;

    private $id;

    private $website;

    private $city;

    private $status;

    private $dateScraped;

    public function __construct($name, $id, $website, $city, $status, $dateScraped)
    {
        $this->name = $name;
        $this->id = $id;
        $this->website = $website;
        $this->city = $city;
        $this->status = $status;
        $this->dateScraped = $dateScraped;

    }

    public function getName()
    {
        return $this->name;
    }

    public function getID()
    {
        return $this->id;
    }

    public function getWebsite()
    {
        return $this->website;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getDateScraped()
    {
        return $this->dateScraped;
    }
}