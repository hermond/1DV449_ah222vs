<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once("application/model/ArticleDAL.php");
require_once("application/view/Page.php");
require_once("application/controller/DoApplication.php");

$doApplication = new \controller\DoApplication();
header('Content-Type: application/json');
echo $doApplication->doApplication();


