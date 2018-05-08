<?php

require ("System/Controller.php");

class LoginController extends Controller
{

    public function Start()
    {
        if(isset($_SESSION["logged"]))
            System::gotoView("Administration");
    }

    public function RequestGET( $_requestGETArray ) {}

    public function loginUser( $_loginParams )
    {
        if($_loginParams['login'] == "root" && $_loginParams['password'] == "root"){
            System::setSessions(array(
                "logged"    => true,
                "login"     => $_loginParams['login']
            ));
        } 
    }

    public function End()
    {
        //session_destroy();
    }
}

?>