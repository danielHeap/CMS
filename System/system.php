<?php 

session_start(); 
ob_start();

require ("System/DatabaseController.php");
require ("System/FormCreator.php");

class System 
{
    private static $buildConfigArray;
    private static $templateView;

    public static function debug( $_string )
    {
        echo "<pre>";
        print_r($_string);
        echo "</pre>";
    }

    private function loadAndDecodeBuild( $_buildPath )
    {
        $buildFile = file_get_contents( $_buildPath );
        $buildFileDecoded = json_decode ( $buildFile , true);
        return $buildFileDecoded;
    }

    public static function loadBuildJSON( $_buildPath )
    {
        $buildJSON = self::loadAndDecodeBuild( $_buildPath );
        self::setBuildConfigArray($buildJSON);
    }

    private function createDatabaseConnection()
    {
        $databaseConnection = new DatabaseConnetion();
        require ("System/DatabaseConfig.php");
        $databaseConnection->setDatabaseConfig($databaseConfig);
        if(!$databaseConnection->connectToDatabase()){
            echo "Błąd połączenia z bazą danych";
        }
        return $databaseConnection;
    }

    public static function run()
    {
        $databaseConnection = self::createDatabaseConnection();
        
        $getArrayVariables = self::getGetArrayVariables();
        $view = $getArrayVariables['view'];

        if(empty($view))
        {
            $view = self::$buildConfigArray["start"]["view"];
        } 

        $viewController     = self::$buildConfigArray["views"][$view]["controller"];
        $viewControllerSRC  = self::$buildConfigArray["views"][$view]["controllerSRC"];
        $alternativeView         = self::$buildConfigArray["views"][$view]["alternativeView"];

        if($viewController == null) self::gotoErrorView();

        require ( $viewControllerSRC );

        $controller = new $viewController();
        $controller->Load();

        if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
            $postArrayVariables     = self::getPostArrayVariables();
            $actionControllerName   = $postArrayVariables['actionController'];
            $actionMethodName       = $postArrayVariables['actionMethod'];
            $actionController       = new $actionControllerName();
            unset($postArrayVariables['actionController']);
            unset($postArrayVariables['actionMethod']);
            $actionController->{$actionMethodName}($postArrayVariables);
        }
        $controller->RequestGET( $getArrayVariables );

        $controller->Start();
        self::setTemplateView( $view, $alternativeView ); 
        require ( self::$templateView["head"] );
        require ( self::$templateView["body_start"] );
        require ( self::$templateView["content_start"] );
        require ( self::$templateView["content"] );
        require ( self::$templateView["content_end"] );
        require ( self::$templateView["body_end"] );
        require ( self::$templateView["footer"] );
        $controller->End();

    }

    private function setTemplateView( $_view, $alternativeView = null )
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
        //self::debug(self::$templateView);
    }

    public static function gotoView( $_view, $_params = null )
    {
        header("Location: ../" . $_view . "/" . (($_params) ? "&" . $_params : "" )); 
    }

    public static function gotoErrorView()
    {
        header("Location: ../" . self::$buildConfigArray["error"]["view"] . "/" ); 
    }

    /**
     *  GET and SET methods
     */

    public static function setBuildConfigArray( $_val ) { self::$buildConfigArray = $_val; }
    public static function setSessions( $_sessions ) {
        foreach ($_sessions as $sessionKey => $sessionValue) {
            $_SESSION[$sessionKey] = $sessionValue;
        }
    }

    public static function getBuildConfigArray() { return self::$buildConfigArray; }
    public static function getGetArrayVariables() { return $_GET; }
    public static function getPostArrayVariables() { return $_POST; }
    public static function getSession( $_session ) { return $_SESSION[$_session]; }
    public static function getView() { 
        $getArrayVariables = self::getGetArrayVariables();
        $view = $getArrayVariables['view'];
        return $view;
    }
    public static function getActualURL() { return "http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']); }

}

?>