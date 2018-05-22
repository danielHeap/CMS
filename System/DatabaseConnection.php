<?php

class DatabaseConnetion
{
    public static $databaseConnection;
    public static $databaseConfig;

    public function __destruct()
    {
        self::disconectDatabase();
    }

    public static function connectToDatabase()
    {
        self::$databaseConnection = new \mysqli(self::$databaseConfig['MYSQL']['DB_HOST'], self::$databaseConfig['MYSQL']['DB_USERNAME'], self::$databaseConfig['MYSQL']['DB_PASSWORD'], self::$databaseConfig['MYSQL']['DB_DATABASE']);
        
        if (self::$databaseConnection->connect_error) {
            return false;
        } else if (!self::$databaseConnection->set_charset("utf8")) {
            return false;
        } else return true;
    }

    public static function setDatabaseConfig()
    {
        self::$databaseConfig = parse_ini_file(".dbaccess", true);
    }

    public static function disconectDatabase()
    {
        self::$databaseConnection->close();
    }
}

?>