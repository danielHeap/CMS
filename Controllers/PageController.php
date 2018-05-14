<?php

require_once ("Classes/Page.php");

class PageController extends Controller
{
    private $page;

    public function RequestGET( $_requestGETArray )
    {
        $page = new Page();
        $page->setTitle( $_requestGETArray['name'] );
        $this->setPage( $page );

        //System::gotoErrorView();
    }



    public function getPage() { return $this->page; }
    public function setPage( $_page ) { $this->page = $_page; }
}

?>