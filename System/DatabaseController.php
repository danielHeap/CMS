<?php

require ("System/DatabaseConnection.php");

class DatabaseController extends DatabaseConnetion
{
    /**
     * Records methodes
     */
    public static function pushData( $_tableName , $_dataModels )
    {
        if(count($_dataModels == 1) && !is_array ($_dataModels))  $_dataModels = array($_dataModels);

        foreach ($_dataModels as $model) {
            $queryPushData = "";
            $queryPushData .= "
            INSERT INTO " . self::$databaseConfig['MYSQL']['DB_PREFIX'].$_tableName ." (";
            $index = 1;
            foreach ($model->getVariablesName() as $varName) {
                $queryPushData .= "" . $varName . "";
                if($index!=count($model->getVariablesName())) $queryPushData .= ", ";
                $index++;
            }
            $queryPushData .= ") VALUES (";
            $index = 1;
            foreach ($model->getVariables() as $var => $val) {
                $queryPushData .= ($val != null ? "'". $val . "'" : "NULL");
                if($index!=count($model->getVariables())) $queryPushData .= ", ";
                $index++;
            }
            $queryPushData .= "); ";
            if (self::$databaseConnection->query($queryPushData) !== TRUE) {
                echo "Error: " . $queryPushData . "<br>" . self::$databaseConnection->error;
                return false;
            }
        }
        return true;
    }

    public static function pullData( $_tableName, $_model, $_columnsName = null, $_conditions = null, $_limit = null, $_nameKey = null )
    {
        $syntax = "SELECT ";
        if($_columnsName) {
            $index = 1; 
            $columnsCount = count($_columnsName);
            foreach ($_columnsName as $value) {
                $syntax .= $value;
                if($index != $columnsCount) $syntax .= ", "; 
                $index ++;
            }
        } else {
            $syntax .= "*";
        }
        $syntax .= " FROM " . self::$databaseConfig['MYSQL']['DB_PREFIX'].$_tableName;
        if($_conditions) {
            $syntax .= " WHERE ";
            $index = 1; 
            $conditionsCount = count($_conditions);
            foreach ($_conditions as $columnName => $value) {
                if(is_array($value))
                {
                    $syntax .= $columnName . $value[0] . "'" . $value[1] . "'";
                } else {
                    $syntax .= $columnName . " = '" . $value . "'";
                } 
                if($index != $conditionsCount) $syntax .= ", "; 
                $index ++;
            }
        }
        if($_limit) {
            $syntax .= " LIMIT ";
            if($_limit['count']) $syntax .= $_limit['count'];
            if($_limit['from']) $syntax .= " OFFSET " . $_limit['from'];
        }
        $syntax .= ";";
        $result = self::$databaseConnection->query($syntax);
        if(!$result){
            return false;
        } else {
            $rowCount = mysqli_num_rows($result);
            if($rowCount > 0) {
                $tempArray = [];
                while($row = $result->fetch_assoc()){
                    $newObject = new $_model();
                    foreach ($row as $columnName => $value) {
                        $functionName = "set" . ucwords($columnName);
                        $newObject->$functionName($value);
                    }
                    if($_nameKey == null) array_push($tempArray, $newObject);
                    else $tempArray[$newObject->getName()] = $newObject;
                }
                return $tempArray;
            } 
            else return false;
        }
    }

    /**
     * TODO: Spróbować zintegrować INNER JOINY i CLASSES
     */
    public static function pullJoinData( $_tableName, $_model, $_columnsName = null, $_joins = null, $_conditions = null, $_limit = null )
    {
        $syntax = "SELECT ";
        if($_columnsName) {
            $index = 1; 
            $columnsCount = count($_columnsName);
            foreach ($_columnsName as $variable) {
                $syntax .= $variable[0] . "." . $variable[1];
                if($index != $columnsCount) $syntax .= ", "; 
                $index ++;
            }
        } else {
            $syntax .= "*";
        }
        $syntax .= " FROM " . self::$databaseConfig['MYSQL']['DB_PREFIX'].$_tableName;
        if($_joins) {
            $index = 1;
            foreach ($_joins as $value) {
                $syntax .= " " . $value['joinType'] . " JOIN ";
                $syntax .= $value['tableName'] . " AS " . $index;
                $index++;
            }
        }
        if($_conditions) {
            $syntax .= " WHERE ";
            $index = 1; 
            $conditionsCount = count($_conditions);
            foreach ($_conditions as $columnName => $value) {
                $syntax .= $columnName . " = '" . $value . "'";
                if($index != $conditionsCount) $syntax .= ", ";  
                $index ++;
            }
        }
        if($_limit) {
            $syntax .= " LIMIT ";
            if($_limit['count']) $syntax .= $_limit['count'];
            if($_limit['from']) $syntax .= " OFFSET " . $_limit['from'];
        }
        $syntax .= ";";
        $result = self::$databaseConnection->query($syntax);
        if(!$result){
            return false;
        } else {
            $rowCount = mysqli_num_rows($result);
            if($rowCount > 0) {
                $tempArray = [];
                while($row = $result->fetch_assoc()){
                    $newObject = new $_model();
                    foreach ($row as $columnName => $value) {
                        $functionName = "set" . ucwords($columnName);
                        $newObject->$functionName($value);
                    }
                    array_push($tempArray, $newObject);
                }
                return $tempArray;
            } 
            else return false;
        }
    }

    public static function deleteData( $_tableName, $_conditions )
    {
        $syntax = "DELETE FROM " . self::$databaseConfig['MYSQL']['DB_PREFIX'].$_tableName;
        $syntax .= " WHERE ";
        $index = 1; 
        $conditionsCount = count($_conditions);
        foreach ($_conditions as $columnName => $value) {
            $syntax .= $columnName . " = '" . $value . "'";
            if($index != $conditionsCount) $syntax .= ", ";  
            $index ++;
        }
        $syntax .= ";";
        $result = self::$databaseConnection->query($syntax);
        if(!$result) 
            return false;
        return true;
    }

    public static function modifyData( $_tableName, $_sets, $_conditions = null )
    {
        /**
         * UPDATE Customers
         * SET ContactName = 'Alfred Schmidt', City= 'Frankfurt'
         * WHERE CustomerID = 1;
         */

        $syntax = "UPDATE " . self::$databaseConfig['MYSQL']['DB_PREFIX'].$_tableName;
        $syntax .= " SET ";
        $index = 1; 
        $setsCount = count($_sets);
        foreach ($_sets as $columnName => $value) {
            $syntax .= $columnName . " = '" . $value . "'";
            if($index != $setsCount) $syntax .= ", ";  
            $index ++;
        }
        $syntax .= " WHERE ";
        $index = 1; 
        $conditionsCount = count($_conditions);
        foreach ($_conditions as $columnName => $value) {
            $syntax .= $columnName . " = '" . $value . "'";
            if($index != $conditionsCount) $syntax .= ", ";  
            $index ++;
        }
        $syntax .= ";";
        echo $syntax;
        $result = self::$databaseConnection->query($syntax);
        if(!$result) 
            return false;
        return true;
    }


    /**
     * Tables methodes
     */
    public static function createTable( $_tableName , $_model )
    {

        require_once("Classes/" . $_model . ".php");
        $queryCreateTable = "";
        $modelVariables = get_class_vars($_model);
        $modelKeys = $_model::setDatabaseKeys();
        $queryCreateTable .= "
        CREATE TABLE IF NOT EXISTS " . self::$databaseConfig['MYSQL']['DB_PREFIX'].$_tableName ." (";
        $index = 1;
        foreach ($modelVariables as $varName => $var) {
            $queryCreateTable .= $varName; 
            if(strtolower($modelKeys["PRIMARY"]) == strtolower($varName)) $queryCreateTable .= " int NOT NULL AUTO_INCREMENT";
            else if(is_array($modelKeys["FOREIGN"]) && array_key_exists($varName, $modelKeys["FOREIGN"])) $queryCreateTable .= " int NOT NULL";
            else $queryCreateTable .= " varchar(255)";
            $queryCreateTable .= ", ";
            $index++;
        } 
        if($modelKeys["PRIMARY"] != null) $queryCreateTable .= "PRIMARY KEY (" . $modelKeys["PRIMARY"] . ") ";
        if(is_array($modelKeys["FOREIGN"]))
        {
            foreach ($modelKeys["FOREIGN"] as $variable => $tableKey) {
                $queryCreateTable .= ", FOREIGN KEY (" . $variable . ") REFERENCES " . $tableKey;
            }
        }
        $queryCreateTable .= ") DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ; ";
        if (self::$databaseConnection->query($queryCreateTable) === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    public static function dropTable( $_tableName )
    {
        $queryDropTable .= "DROP TABLE " . self::$databaseConfig['MYSQL']['DB_PREFIX'].$_tableName .";";
        if (self::$databaseConnection->query($queryDropTable) === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    public static function syntax( $_sql )
    {
        if ($result = self::$databaseConnection->query($_sql) === TRUE) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * Trash
     */
    public static function ReturnConnection()
    {
        return self::database_connection;
    }
}

?>