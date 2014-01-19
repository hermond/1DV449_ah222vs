<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Hello World
 * Date: 2014-01-05
 * Time: 15:51
 * To change this template use File | Settings | File Templates.
 */

namespace controller;

use model\ArticleDAL;
use view\Page;

class DoApplication {

    private $articleDAL;
    private $pageView;

    public function __construct(){
        $this->articleDAL = new ArticleDAL();
        $this->pageView = new Page();

    }

    public function doApplication()
    {
        if($this->pageView->showLast24HoursArticles())
        {

            return json_encode($this->articleDAL->getArticles($this->articleDAL->last24HoursSql));

        }
        else if($this->pageView->showLast48HoursArticles())
        {
            return json_encode($this->articleDAL->getArticles($this->articleDAL->last48HoursSql));
        }
        else if($this->pageView->showLast7DaysArticles())
        {

            return json_encode($this->articleDAL->getArticles($this->articleDAL->last7DaysSql));
        }

        else if($this->pageView->showLast30DaysArticles())
        {
            return json_encode($this->articleDAL->getArticles($this->articleDAL->last30DaysSql));
        }

    }


}