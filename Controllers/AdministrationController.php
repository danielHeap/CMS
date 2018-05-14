<?php 

require ("Classes/Article.php");

class AdministrationController extends Controller
{
    public $websiteName = "Strona testowa";

    public function Start()
    {
        if(!isset($_SESSION["logged"]) && System::getView() != "Administration/Login")
        {
            System::gotoView("Administration/Login");
        }
    }

    public function getUsername() { return System::getSession("login"); }
    
    public function RequestGET( $_params )
    {
        System::view( "Administration" ); 
    }

    public function loginUserForm( )
    {
        System::view( "Login", "Administration" ); 
    }

    public function viewPagesList( )
    {
        System::view( "Pages", "Administration" ); 
    }

    public function viewSettingsList( )
    {
        System::view( "Settings", "Administration" ); 
    }

    public function loginUser( $_params )
    {
        if($_params['login'] == "root" && $_params['password'] == "root"){
            System::setSessions(array(
                "logged"    => true,
                "login"     => $_params['login']
            ));
            System::gotoView("Administration");
        } else {
            echo "Bledne dane";
        }
    }

    public function logoutUser()
    {
        session_destroy();
        System::gotoView("Administration/Login");
    }

    public function getWebsiteName(){ return $this->websiteName; }
	public function setWebsiteName($_websiteName)
	{
		$this->websiteName = $_websiteName;
		return $this;
	}
}

?>