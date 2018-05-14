<?php

require_once ("Classes/Page.php");

class PageController extends Controller
{
    private $page;

    public function viewPage( $_params )
    {
        $page = DatabaseController::pullData( 
            "pages",
            "Page",
            array( "pageID", "title", "name", "description" ),
            array(
                "name" => $_params['namePage']
            )
        );
        if(!$page) System::gotoErrorView();
        $this->setPage($page);
        System::view( "Page" ); 
    }

    public function getPage() { return $this->page; }
    public function setPage( $_page ) { $this->page = $_page; }
}

?>