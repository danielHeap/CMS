<?php

class Identifier 
{
    public static $route = [];
    public static $redirect = [];
    public static $error;

    public static $tmp = [];
    
    public static function set( $_type, $_link, $_controller, $_method )
    {
        $link = explode("/", $_link);
        $number = count($link);

        if($number == 1)
        {
            self::$route[$link[0]][$_type]["controller"] = $_controller;
            self::$route[$link[0]][$_type]["method"] = $_method;
        } elseif($number == 2) {
            self::$route[$link[0]][$link[1]][$_type]["controller"] = $_controller;
            self::$route[$link[0]][$link[1]][$_type]["method"] = $_method;
        } elseif($number == 3) {
            self::$route[$link[0]][$link[1]][$link[2]][$_type]["controller"] = $_controller;
            self::$route[$link[0]][$link[1]][$link[2]][$_type]["method"] = $_method;
        } elseif($number == 4) {
            self::$route[$link[0]][$link[1]][$link[2]][$link[3]][$_type]["controller"] = $_controller;
            self::$route[$link[0]][$link[1]][$link[2]][$link[3]][$_type]["method"] = $_method;
        } elseif($number == 5) {
            self::$route[$link[0]][$link[1]][$link[2]][$link[3]][$link[4]][$_type]["controller"] = $_controller;
            self::$route[$link[0]][$link[1]][$link[2]][$link[3]][$link[4]][$_type]["method"] = $_method;
        }
    }

    public static function route( $_link, $_controller, $_method = "RequestGET" )
    {
        self::set("GET", $_link, $_controller, $_method);
    }

    public static function post( $_link, $_controller, $_method = "RequestPOST" )
    {
        self::set("POST", $_link, $_controller, $_method);
    }

    public function findArray( $_node, $_query )
    {
        foreach( $_node as $key => $array )
        {
            if($key == $_query) 
                return $array;
        }

        foreach( $_node as $key => $array )
        {
            if($key[0] == "{" && $key[strlen($key)-1] == "}" ) {
                self::$tmp[substr($key, 1, -1)] = $_query;
                return $array;
            }
        }

        return false;
    }

    public static function redirect( $_ilusionLink , $_realLink )
    {
        array_push(self::$redirect, array($_ilusionLink => $_realLink));
    }

    public static function checkRedirect( $_getVariables )
    {
        $getVarsCount = count($_getVariables);
        foreach(self::$redirect as $key => $val)
        {
            if(array_key_exists(
                    $_getVariables["param1"], 
                    $val
            ))
            {
                return $val[$_getVariables["param1"]];
            }
        } 
        return $_getVariables["param1"];
    }

    public static function getGETController( $_getVariables )
    {
        if($_getVariables["param1"] != $new = self::checkRedirect($_getVariables))
            $_getVariables["param1"] = self::checkRedirect($_getVariables);

        $getVarsCount = count($_getVariables);

        $tempArray = self::$route;
        for($i = 1; $i <= $getVarsCount; $i++)
        {
            $tempArray = self::findArray( $tempArray, $_getVariables["param" . $i] );
        }
        $tempArray["GET_PARAMS"] = self::$tmp;
        return $tempArray;
    }

    public static function error( $_link )
    {
        self::$error = $_link;
    }

    public function getError(){ return self::$error; }}

?>