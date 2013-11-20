<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Hello World
 * Date: 2013-11-20
 * Time: 14:29
 * To change this template use File | Settings | File Templates.
 */

class ScrapeDAL {
    /**
     * @var string
     */
    private static $hostname = "mysql08.citynetwork.se";
    /**
     * @var string
     */
    private static $username = "112745-eb11930";
    /**
     * @var string
     */
    private static $password = "MakeMake22";
    /**
     * @var string
     */
    private static $dbName = "112745-projektet";
    /**
     * @var string
     */
    private static $charset = "UTF8";

    /**
     * @return PDO
     */
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

    public function getProducers()
    {
        $statement = $this->getDBConnection()->prepare("SELECT MainStoreUrl, Hostname, Username, Password, Name FROM MainStoreDBSettings");

        $statement->execute();


        while ($row = $statement->fetch(\PDO::FETCH_ASSOC)) {
            try {

                $DBsettings = new MainStoreDBSettings($row['MainStoreUrl'], $row['Hostname'], $row['Username'], $row['Password'], $row['Name']);

            }

            catch (\Exception $e) {

            }

        }

        return $DBsettings;
    }

}