<?php

class DatabaseConnetion
{
    public $databaseConnection;
    private $databaseConfig;

    public function __destruct()
    {
        $this->disconectDatabase();
    }

    public function connectToDatabase()
    {

        $this->databaseConnection = new \mysqli($this->databaseConfig['host'], $this->databaseConfig['username'], $this->databaseConfig['password'], $this->databaseConfig['database']);
        if ($this->databaseConnection->connect_error) {
            return false;
        } else if (!$this->databaseConnection->set_charset("utf8")) {
            return false;
        } else return true;
    }

    public function setDatabaseConfig( $_databaseConfig )
    {
        $this->databaseConfig = $_databaseConfig;
    }

    public function getDatabaseConfigFile()
    {

    }

    public function createDatabaseConfigFile( $_databaseConfig )
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

    public function disconectDatabase()
    {
        $this->databaseConnection->close();
    }
}

?>