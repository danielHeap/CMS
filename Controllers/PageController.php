<?php

require_once ("Classes/Page.php");

class PageController extends Controller
{
    public $page;
    public $content;

    public function viewPage( $_params )
    {
        $this->loadPage($_params['namePage']);
        if(!$this->getPage()) System::gotoErrorView();
        $this->loadContent($this->getPage()->getPageID());
        System::view( "Page" ); 
    }

    public function loadPage( $_pageName )
    {
        $page = DatabaseController::pullData( 
            "pages",
            "Page",
            array( "pageID", "title", "name", "description" ),
            array(
                "name" => $_pageName
            )
        );
        $this->setPage($page[0]);
    }

    public function loadContent( $_pageID )
    {
        $content = DatabaseController::pullData( 
            "pagescontent",
            "Content",
            array( "contentID", "contentType", "contentHTML" ),
            array(
                "pageID" => $_pageID
            )
        );
        $this->setContent($content);
    }

    public function viewMenu()
    {
        $pagesList = DatabaseController::pullData( 
            "pages",
            "Page",
            array( "title", "name" )
        );
        foreach($pagesList as $page)
        {
            echo '<ul>';
            echo '<li><a href="'. System::getActualURL() . '/Page/' . $page->getName() . '">' . $page->getTitle() . '</a></li>';
            echo '</ul>';
        }
    }

    public function getPage(){ return $this->page; }
	public function setPage($_page)
	{
		$this->page = $_page;
		return $this;
	}

    public function getContent(){ return $this->content; }
	public function setContent($_content)
	{
		$this->content = $_content;
		return $this;
	}
}

?>