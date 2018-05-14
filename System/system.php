<?php 

session_start(); 
ob_start();

require ("System/DatabaseController.php");
require ("System/Model.php");
require ("System/Controller.php");
require ("System/FormCreator.php");
require ("System/Identifier.php");

class System 
{
    private static $templateView;

    public static function debug( $_string )
    {
        echo "<pre>";
        var_dump($_string);
        echo "</pre>";
    }

    public static function run()
    {        
        require ("System/DatabaseConfig.php");
        DatabaseController::setDatabaseConfig($databaseConfig);
        if(!DatabaseController::connectToDatabase()){
            echo "Błąd połączenia z bazą danych";
        }
        require ("database.php");
        require ("web.php");

        $getArrayVariables = self::getGetArrayVariables();
        $getVariablesCount = count($getArrayVariables);

        $viewController    = Identifier::getGETController($getArrayVariables);

        if($viewController["GET"]["controller"] == null) self::gotoErrorView();

        //echo "<div style='display: none;'>";
       ///System::debug($viewController);
        //echo "</div>";

        require ( "Controllers/" . $viewController["GET"]["controller"] . ".php");

        $controller = new $viewController["GET"]["controller"]();
        $controller->Start();

        //echo "<pre>";
        //echo $viewController["GET"]["controller"];
        //echo "<br>";
        //echo $viewController["GET"]["method"];
        //echo "<br>";*/

        if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
            if(method_exists($controller, $method = $viewController["POST"]["method"])) {
                $postArrayVariables     = self::getPostArrayVariables();
                $controller->{$method}($postArrayVariables);
                //echo $viewController["POST"]["method"];
            }
        }
        if(method_exists($controller, $method = $viewController["GET"]["method"])) {
            $controller->{$method}($viewController["GET_PARAMS"]);
        }

        $controller->End();

    }

    public function view( $_view, $alternativeView = null )
    {
        self::$templateView = array(
            "head" => (
                ($alternativeView == null) 
                ?
                (file_exists("Views/" . $_view . "/head.php") ? ("Views/" . $_view . "/head.php") : ("Templates/head.php"))
                :
                (file_exists("Views/" . $_view . "/head.php") ? ("Views/" . $_view . "/head.php") : (file_exists("Views/" . $alternativeView . "/head.php")  ?  ("Views/" . $alternativeView . "/head.php") : ("Templates/head.php")))
            ),
            "body_start" => (
                ($alternativeView == null) 
                ?
                (file_exists("Views/" . $_view . "/body_start.php") ? ("Views/" . $_view . "/body_start.php") : ("Templates/body_start.php"))
                :
                (file_exists("Views/" . $_view . "/body_start.php") ? ("Views/" . $_view . "/body_start.php") : (file_exists("Views/" . $alternativeView . "/body_start.php") ?  ("Views/" . $alternativeView . "/body_start.php") : ("Templates/body_start.php")))
            ),
            "content_start" => (
                ($alternativeView == null) 
                ?
                (file_exists("Views/" . $_view . "/content_start.php") ? ("Views/" . $_view . "/content_start.php") : ("Templates/content_start.php"))
                :
                (file_exists("Views/" . $_view . "/content_start.php") ? ("Views/" . $_view . "/content_start.php") : (file_exists("Views/" . $alternativeView . "/content_start.php") ?  ("Views/" . $alternativeView . "/content_start.php") : ("Templates/content_start.php")))
            ),
            "content" => (
                ($alternativeView == null) 
                ?
                (file_exists("Views/" . $_view . "/content.php") ? ("Views/" . $_view . "/content.php") : ("Templates/content.php"))
                :
                (file_exists("Views/" . $_view . "/content.php") ? ("Views/" . $_view . "/content.php") : (file_exists("Views/" . $alternativeView . "/content.php") ? ("Views/" . $alternativeView . "/content.php") : ("Templates/content.php")))
            ),
            "content_end" => (
                ($alternativeView == null) 
                ?
                (file_exists("Views/" . $_view . "/content_end.php") ? ("Views/" . $_view . "/content_end.php") : ("Templates/content_end.php"))
                :
                (file_exists("Views/" . $_view . "/content_end.php") ? ("Views/" . $_view . "/content_end.php") : (file_exists("Views/" . $alternativeView . "/content_end.php") ?  ("Views/" . $alternativeView . "/content_end.php") : ("Templates/content_end.php")))
            ),
            "body_end" => (
                ($alternativeView == null) 
                ?
                (file_exists("Views/" . $_view . "/body_end.php") ? ("Views/" . $_view . "/body_end.php") : ("Templates/body_end.php"))
                :
                (file_exists("Views/" . $_view . "/body_end.php") ? ("Views/" . $_view . "/body_end.php") : (file_exists("Views/" . $alternativeView . "/body_end.php") ?  ("Views/" . $alternativeView . "/body_end.php") : ("Templates/body_end.php")))
            ),
            "footer" => (
                ($alternativeView == null) 
                ?
                (file_exists("Views/" . $_view . "/footer.php") ? ("Views/" . $_view . "/footer.php") : ("Templates/footer.php"))
                :
                (file_exists("Views/" . $_view . "/footer.php") ? ("Views/" . $_view . "/footer.php") : (file_exists("Views/" . $alternativeView . "/footer.php") ?  ("Views/" . $alternativeView . "/footer.php") : ("Templates/footer.php")))
            )
        );
        require ( self::$templateView["head"] );
        require ( self::$templateView["body_start"] );
        require ( self::$templateView["content_start"] );
        require ( self::$templateView["content"] );
        require ( self::$templateView["content_end"] );
        require ( self::$templateView["body_end"] );
        require ( self::$templateView["footer"] );
    }

    public static function gotoView( $_view, $_params = null )
    {
        header("Location: " . self::getActualURL() . "/" . $_view . "/" ); 
    }

    public static function gotoErrorView()
    {
        header("Location: " . self::getActualURL() . "/" . Identifier::getError() . "/" ); 
    }

    /**
     *  SET methods
     */
    public static function setBuildConfigArray( $_val ) { self::$buildConfigArray = $_val; }
    public static function setSessions( $_sessions ) {
        foreach ($_sessions as $sessionKey => $sessionValue) {
            $_SESSION[$sessionKey] = $sessionValue;
        }
    }
    /**
     *  GET methods
     */
    public static function getBuildConfigArray() { return self::$buildConfigArray; }
    public static function getGetArrayVariables() { return $_GET; }
    public static function getPostArrayVariables() { return $_POST; }
    public static function getSession( $_session ) { return $_SESSION[$_session]; }
    public static function getActualURL() { return "http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']); }
    public static function getView() { 
        $getArrayVariables = self::getGetArrayVariables();
        $view = "";
        if($getArrayVariables['param1']) $view .= $getArrayVariables['param1'];
        if($getArrayVariables['param2']) $view .= "/".$getArrayVariables['param2'];
        if($getArrayVariables['param3']) $view .= "/".$getArrayVariables['param3'];
        if($getArrayVariables['param4']) $view .= "/".$getArrayVariables['param4'];
        if($getArrayVariables['param5']) $view .= "/".$getArrayVariables['param5'];
        return $view;
    }
    public static function getVariableName( $_var ) {
        foreach($GLOBALS as $var_name => $value) {
            if ($value === $_var) {
                return $var_name;
            }
        }
        return false;
    }
    public static function getRealtimeDate( $_format )
    {
        return date( $_format );
    }
}

?>