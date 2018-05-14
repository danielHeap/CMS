<?php 

require ("Classes/Article.php");

class AdministrationController extends Controller
{
    public $websiteName = "Strona testowa";
    public $errorLogin = false;

    public function Start()
    {
        if(!isset($_SESSION["logged"]) && System::getView() != "Administration/Login" && System::getView() != "Administration/Login/Error")
        {
            System::gotoView("Administration/Login");
        }
    }

    public function getUsername() { return System::getSession("login"); }
    
    public function RequestGET( $_params )
    {
        System::view( "Administration" ); 
    }

    public function loginUserForm( $_params )
    {
        if(isset($_params['error'])) $this->errorLogin = true;
        System::view( "Login", "Administration" ); 
    }

    public function viewPagesList( )
    {
        System::view( "Pages", "Administration" ); 
    }

    public function viewNewPageForm( $_params )
    {
        System::view( "NewPage", "Administration" ); 
    }

    public function addNewPage( $_params )
    {
        $page = new Page();
        $page->setParentID( "0" ); // $_params["parentID"] );
        $page->setTitle( $_params["title"] );
        $page->setName( $_params["name"] );
        $page->setDescription( $_params["description"] );
        if(DatabaseController::pushData( "pages", $page))
        {
            System::gotoView("Administration/Pages");
        }
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
            System::gotoView("Administration/Login/Error");
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

    public function getErrorLogin(){ return $this->errorLogin; }}

?>