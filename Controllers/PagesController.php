<?php 

class PagesController extends Controller
{
    public $websiteName = "Strona testowa";

    public function Start()
    {
        if(!isset($_SESSION["logged"]))
            System::gotoView("Login");
    }

    public function RequestGET( $_requestGETArray ) {}

    public function createNewPage( $_pageParams )
    {
        $page = new Page();
        $page->setParentID( $_pageParams["parentID"] );
        $page->setTitle( $_pageParams["title"] );
        $page->setDescription( $_pageParams["description"] );
        DatabaseController::pushData( "pages", $page);
        //DatabaseController::dropTable( "pages" );
    }
    public function getWebsiteName(){ return $this->websiteName; }
	public function setWebsiteName($_websiteName)
	{
		$this->websiteName = $_websiteName;
		return $this;
	}
}

?>