<?php 

class Page 
{
    private $title;
    private $description;

    /**
     * GET and SET methods
     */

    public function getTitle() { return $this->title; }
    public function getDescription() { return $this->description; }
    public function setTitle( $_title ) { $this->title = $_title; }
    public function setDescription( $_description ) { $this->description = $_description; }
}

?>