<?php

class DatabaseConnetion
{
    public static $databaseConnection;
    private static $databaseConfig;

    public function __destruct()
    {
        self::disconectDatabase();
    }

    public static function connectToDatabase()
    {

        self::$databaseConnection = new \mysqli(self::$databaseConfig['host'], self::$databaseConfig['username'], self::$databaseConfig['password'], self::$databaseConfig['database']);
        if (self::$databaseConnection->connect_error) {
            return false;
        } else if (!self::$databaseConnection->set_charset("utf8")) {
            return false;
        } else return true;
    }

    public static function setDatabaseConfig( $_databaseConfig )
    {
        self::$databaseConfig = $_databaseConfig;
    }

    public static function getDatabaseConfigFile()
    {

    }

    public static function createDatabaseConfigFile( $_databaseConfig )
    {
        $myfile = fopen("../Classes/Database/DatabaseConfig.php", "w") or die("Unable to open file!");
$txt = "<?php
    protected $" . "databaseConfig = array(
        'host' => '" . $_databaseConfig['host'] . "',
        'database' => '" . $_databaseConfig['database'] . "',
        'username' => '" . $_databaseConfig['username'] . "',
        'password' => '" . $_databaseConfig['password'] . "'
    );
?>";
        fwrite($myfile, $txt);
        fclose($myfile);
    }

    public static function disconectDatabase()
    {
        self::$databaseConnection->close();
    }
}

?>