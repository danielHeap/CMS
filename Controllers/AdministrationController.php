<?php 

require ("System/Controller.php");

class AdministrationController extends Controller
{
    public function Start()
    {
        if(!isset($_SESSION["logged"]))
            System::gotoView("Login");
    }

    public function getUsername() { return System::getSession("login"); }
    
    public function RequestGET( $_requestGETArray )
    {
        if(isset($_requestGETArray["logout"]))
        {
            session_destroy();
            System::gotoView("Login");
        }
    }

}

?>