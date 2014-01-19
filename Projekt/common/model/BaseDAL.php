<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Hello World
 * Date: 2014-01-15
 * Time: 16:36
 * To change this template use File | Settings | File Templates.
 */

namespace model;



class BaseDAL {

    private static $hostname = "mysql10.citynetwork.se";

    private static $username = "112745-bi50201";

    private static $password = "sharedIm7322YkL";

    private static $dbName = "112745-sharedim";

    private static $charset = "UTF8";


    public static function getDBConnection() {
        try {
            $pdo = new \PDO("mysql:host=" . self::$hostname . ";dbname=" . self::$dbName . ";charset=" . self::$charset
                , self::$username, self::$password);
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }
        catch (\PDOException $e) {

        }

        return $pdo;
    }
}