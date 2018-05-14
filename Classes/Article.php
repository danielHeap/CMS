<?php 

class Article extends Model
{
    public $articleID;
    public $articleCategoryID;
    public $title;
    public $dateRelease = "0/0/0";
    public $datePublished = "0/0/0";
    public $content;

    /**
     * GET and SET methods
     */
    public function getArticleID(){ return $this->articleID; }
	public function setArticleID($_articleID)
	{
		$this->articleID = $_articleID;
		return $this;
	}

    public function getTitle(){ return $this->title; }
	public function setTitle($_title)
	{
		$this->title = $_title;
		return $this;
	}

    public function getDateRelease(){ return $this->dateRelease; }
	public function setDateRelease($_dateRelease)
	{
		$this->dateRelease = $_dateRelease;
		return $this;
	}

    public function getDatePublished(){ return $this->datePublished; }
	public function setDatePublished($_datePublished)
	{
		$this->datePublished = $_datePublished;
		return $this;
	}

    public function getContent(){ return $this->content; }
	public function setContent($_content)
	{
		$this->content = $_content;
		return $this;
    }
    
    public static function setDatabaseKeys()
    {
        $keysArray = array(
            "PRIMARY" => "articleID",
            "FOREIGN" => array(
                "articleCategoryID" => "articlecategories(articleCategoryID)"
            )
        );
        return $keysArray;
    }
}

?>