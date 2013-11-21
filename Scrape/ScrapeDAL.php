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
    private static $hostname = "mysql10.citynetwork.se";
    /**
     * @var string
     */
    private static $username = "112745-dd44690";
    /**
     * @var string
     */
    private static $password = "scrape11";
    /**
     * @var string
     */
    private static $dbName = "112745-scrape";
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

    public function AddProducer(Producer $producer)
    {
        $statement = $this->getDBConnection()->prepare("INSERT INTO Producers (Name, ID, Website, City, Status, DateScraped)
        VALUES (:name, :id, :website, :city, :status, :date)");

        $statement->bindParam(':name', $producer->getName(), \PDO::PARAM_STR);
        $statement->bindParam(':id', $producer->getID(), \PDO::PARAM_STR);
        $statement->bindParam(':website', $producer->getWebsite(), \PDO::PARAM_STR);
        $statement->bindParam(':city', $producer->getCity(), \PDO::PARAM_STR);
        $statement->bindParam(':status', $producer->getStatus(), \PDO::PARAM_STR);
        $statement->bindParam(':date', $producer->getDateScraped(), \PDO::PARAM_STR);
        $statement->execute();
    }

    public function getProducersFromLatestScrape()
    {
        $statement = $this->getDBConnection()->prepare("SELECT Name, ID, Website, City, Status, DateScraped FROM Producers");

        $statement->execute();

        $producers = array();
        while ($row = $statement->fetch(\PDO::FETCH_ASSOC)) {
            try {

                $producers[] = new Producer($row['Name'], $row['ID'], $row['Website'], $row['City'], $row['Status'], $row['DateScraped']);

            }

            catch (\Exception $e) {

            }

        }

        return $producers;
    }

    public function getProducersFromAllScrapes()
    {
        $statement = $this->getDBConnection()->prepare("SELECT Name, ID, Website, City, Status, DateScraped FROM Producers");

        $statement->execute();

        $producers = array();
        while ($row = $statement->fetch(\PDO::FETCH_ASSOC)) {
            try {

                $producers[] = new Producer($row['Name'], $row['ID'], $row['Website'], $row['City'], $row['Status'], $row['DateScraped']);

            }

            catch (\Exception $e) {

            }

        }

        return $producers;
    }

}