<?php
require_once("Scrape.php");
require_once("simple_html_dom.php");
require_once("Producer.php");
require_once("ScrapeDAL.php");
require_once("View.php");
require_once("Controller.php");

/**
 * Created by JetBrains PhpStorm.
 * User: Hello World
 * Date: 2013-11-13
 * Time: 14:50
 * To change this template use File | Settings | File Templates.
 */


$controller = new Controller();
echo $controller->doControll();

