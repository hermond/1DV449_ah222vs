<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Hello World
 * Date: 2014-01-16
 * Time: 15:57
 * To change this template use File | Settings | File Templates.
 */

namespace view;


class Page {

    public function showLast24HoursArticles()
    {
        return isset($_GET["last24hours"]);
    }

    public function showLast48HoursArticles()
    {
        return isset($_GET["last48hours"]);
    }
    public function showLast7DaysArticles()
    {
        return isset($_GET["last7days"]);
    }
    public function showLast30DaysArticles()
    {
        return isset($_GET["last30days"]);
    }

}