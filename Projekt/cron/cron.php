<?php

require_once("../cron/controller/DoRss.php");
require_once("../cron/controller/DoSharedCount.php");
/**
 * Created by JetBrains PhpStorm.
 * User: Hello World
 * Date: 2014-01-13
 * Time: 00:31
 * To change this template use File | Settings | File Templates.
 */

$rss = new controller\DoRss();
$sharedCount = new \controller\DoSharedCount();

$rss->doRss();
$sharedCount->getSharedCount();