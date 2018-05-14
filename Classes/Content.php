<?php 

class Content extends Model
{
    public $contentID;
    public $pageID;
    public $contentType;
    public $contentHTML;

    public function getContentID(){ return $this->contentID; }
	public function setContentID($_contentID)
	{
		$this->contentID = $_contentID;
		return $this;
	}

    public function getPageID(){ return $this->pageID; }
	public function setPageID($_pageID)
	{
		$this->pageID = $_pageID;
		return $this;
	}

    public function getContentType(){ return $this->contentType; }
	public function setContentType($_contentType)
	{
		$this->contentType = $_contentType;
		return $this;
	}

    public function getContentHTML(){ return $this->contentHTML; }
	public function setContentHTML($_contentHTML)
	{
		$this->contentHTML = $_contentHTML;
		return $this;
    }
    
    public static function setDatabaseKeys()
    {
        $keysArray = array(
            "PRIMARY" => "contentID",
            "FOREIGN" => array(
                "pageID" => "pages(pageID)"
            )
        );
        return $keysArray;
    }
}
    
?>