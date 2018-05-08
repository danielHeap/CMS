<?php

require ("System/DatabaseConnection.php");

class DatabaseController extends DatabaseConnetion
{
    public function ReturnConnection()
    {
        return $this->database_connection;
    }
}

?>