<?php

class Model 
{
    public function getVariablesName()
    {
        return array_keys(get_object_vars($this));
    }
    public function getVariables()
    {
        return get_object_vars($this);
    }
    public static function setDatabaseKeys()
    {
        $keysArray = array(
            "PRIMARY" => strtolower (get_called_class()) . "ID",
            "FOREIGN" => null
        );
        return $keysArray;
    }
}

?>