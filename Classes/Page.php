<?php 


class Page extends Model
{
    public $pageID;
    public $parentID;
    public $title;
    public $description;

    /**
     * GET and SET methods
     */
    public function getParentID(){ return $this->parentID; }
	public function setParentID($_parentID)
	{
		$this->parentID = $_parentID;
		return $this;
	}

    public function getPageID(){ return $this->pageID; }
	public function setPageID($_pageID)
	{
		$this->pageID = $_pageID;
		return $this;
    }

    public function getTitle(){ return $this->title; }
	public function setTitle($_title)
	{
		$this->title = $_title;
		return $this;
	}

    public function getDescription(){ return $this->description; }
	public function setDescription($_description)
	{
		$this->description = $_description;
		return $this;
	}
    
    public static function setDatabaseKeys()
    {
        $keysArray = array(
            "PRIMARY" => "pageID",
            "FOREIGN" => array(
                "parentID" => "pages(pageID)"
            )
        );
        return $keysArray;
    }
}

?>