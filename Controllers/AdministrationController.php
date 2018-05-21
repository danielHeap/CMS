<?php 

require ("Classes/Article.php");

class AdministrationController extends Controller
{
    public $websiteName = "Strona testowa";
    public $errorLogin = false;
    public $websiteSettings;

    public function Start()
    {
        $this->websiteSettings = DatabaseController::pullData( 
            "settings",
            "Setting",
            array( "name", "value", "title" ),
            array(
                "name" => array(
                    "!=",
                    "template"
                )
            ),
            null,
            true
        );   

        if(!isset($_SESSION["logged"]) && System::getView() != "Administration/Login" && System::getView() != "Administration/Login/Error")
        {
            System::gotoView("Administration/Login");
        }
    }
    
    public function RequestGET( $_params )
    {
        System::view( "Administration" ); 
    }

    ///////////////////////
    // LOGIN - LOGOWANIE
    ///////////////////////

    public function getUsername() { return System::getSession("login"); }

    public function loginUserForm( $_params )
    {
        if(isset($_params['error'])) $this->errorLogin = true;
        System::view( "Login", "Administration" ); 
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

    ///////////////////////
    // PAGES - STRONY
    ///////////////////////

    public function viewPagesList( )
    {
        System::view( "Pages", "Administration" ); 
    }

    public function viewPagesListTable( $_controller, $_parentID, $_parentName = null )
    {
        $pages = $_controller->getPages($_parentID);
        if($pages == null) return false;
        foreach($pages as $page)
        {
            echo '<div class="row">';
                echo '<div class="col col-200 text-to-left"><a href="' . System::getActualURL() . '/Administration/Page/' . $page->getPageID() . '">' . $page->getName() . '</a></div>';
                echo '<div class="col col-6 text-to-left">' . $_parentName . '</div>';
                echo '<div class="col col-5 text-to-left"><a href="' . System::getActualURL() . '/Administration/Page/' . $page->getPageID() . '">' . $page->getTitle() . '</a></div>';
                echo '<div class="col text-to-left" style="font-weight: 400;">' . $page->getDescription() . '</div>';
                echo '<div class="col col-4 text-to-right align-right"><a class="row-button" href="' . System::getActualURL() . '/Administration/Page/' . $page->getPageID() . '/New/">NOWA TREŚĆ</a><a class="row-button" href="' . System::getActualURL() . '/Administration/Page/' . $page->getPageID() . '/Modify/">MODYFIKUJ</a><a class="row-button" href="' . System::getActualURL() . '/Administration/Page/' . $page->getPageID() . '/DeleteConfirm/">USUŃ</a></div>';
            echo '</div>';
            $this->viewPagesListTable( $_controller, $page->getPageID(), $page->getName() );
    
        }
    }

    public function getPages( $_parentID = null )
    {
        if($_parentID == null)
        {
            $pages = DatabaseController::pullData( 
                "pages",
                "Page",
                array( "pageID", "parentID", "title", "name", "description")
            );
        }
        else {
            $pages = DatabaseController::pullData( 
                "pages",
                "Page",
                array( "pageID", "parentID", "title", "name", "description"),
                array(
                    "parentID" => $_parentID
                )
            );
        }
        return $pages;
    }

    /////////////////////////////////////
    // Variables for editing conrete page
    /////////////////////////////////////
    public $editPage;

    public function viewModifyPageFrom( $_params )
    {
        $page = DatabaseController::pullData( 
            "pages",
            "Page",
            null,
            array(
                "pageID" => $_params['pageID']
            )
        );
        if(!$page) System::gotoView("Administration/Pages");
        $this->editPage = $page;
        System::view( "ModifyPage", "Administration" ); 
    }

    public function modifyPage( $_params )
    {
        System::view( "ModifyPage", "Administration" ); 
    }

    public function viewDeletePageForm( $_params )
    {
        $page = DatabaseController::pullData( 
            "pages",
            "Page",
            array( "title", "pageID" ),
            array(
                "pageID" => $_params['pageID']
            )
        );
        if(!$page) System::gotoView("Administration/Pages");
        $this->editPage = $page;
        System::view( "DeletePage", "Administration" ); 
    }

    public function deletePage( $_params )
    {
        if(DatabaseController::deleteData( 'pages', array( "pageID" => $_params['pageID'] ) ) && DatabaseController::deleteData( 'pagescontent', array( "pageID" => $_params['pageID'] ) )) System::gotoView("Administration/Pages");
    }

    public function viewPageContent( $_params )
    {
        $page = DatabaseController::pullData( 
            "pages",
            "Page",
            array( "pageID", "title", "name", "description" ),
            array(
                "pageID" => $_params['pageID']
            )
        );
        if(!$page) System::gotoView("Administration/Pages");
        $this->setEditPage($page[0]);
        System::view( "Content", "Administration" );  
    }

    public function viewNewContentPageForm( $_params )
    {
        $page = DatabaseController::pullData( 
            "pages",
            "Page",
            array( "pageID", "title", "name", "description" ),
            array(
                "pageID" => $_params['pageID']
            )
        );
        if(!$page) System::gotoView("Administration/Pages");
        $this->setEditPage($page[0]);
        System::view( "NewContent", "Administration" ); 
    }

    public function addNewPageContent( $_params )
    {
        
    }

    public function viewNewPageForm( $_params )
    {
        System::view( "NewPage", "Administration" ); 
    }

    public function addNewPage( $_params )
    {
        $page = new Page();
        $page->setParentID( $_params["parentID"] );
        $page->setTitle( $_params["title"] );
        $page->setName( $_params["name"] );
        $page->setDescription( $_params["description"] );
        if(DatabaseController::pushData( "pages", $page))
        {
            System::gotoView("Administration/Pages");
        }
    }

    ///////////////////////
    // SETTINGS - USTAWIENIA
    ///////////////////////

    public function viewSettings( )
    {
        System::view( "Settings", "Administration" ); 
    }

    public function setSettings( $_params )
    {
    }

    public function viewSettingsUsers( )
    {
        System::view( "SettingsUsers", "Administration" ); 
    }
    public function viewSettingsTemplates( )
    {
        System::view( "SettingsTemplates", "Administration" ); 
    }

    public function getWebsiteName(){ return $this->websiteName; }
	public function setWebsiteName($_websiteName)
	{
		$this->websiteName = $_websiteName;
		return $this;
    }

    public function getEditPage(){ return $this->editPage; }
	public function setEditPage($_editPage)
	{
		$this->editPage = $_editPage;
		return $this;
	}

    public function getErrorLogin(){ return $this->errorLogin; }}

?>