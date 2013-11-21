<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Hello World
 * Date: 2013-11-21
 * Time: 02:47
 * To change this template use File | Settings | File Templates.
 */

class Controller {

    private $view;
    private $scrape;

    public function __construct()
    {
        $this->view = new View();
        $this->scrape = new Scrape();
    }

    public function doControll()
    {

        if ($this->view->isScraping())
        {
            $this->scrape->ScrapeIt();
            return $this->view->getPage();
        }
        else{
            return $this->view->getPage();
        }

    }
}