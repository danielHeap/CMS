<?php 

class Setting extends Model
{
    public $name;
    public $title;
    public $value;

    public static function setDatabaseKeys()
    {
        $keysArray = array(
            "PRIMARY" => "name"
        );
        return $keysArray;
    }

    public function getName(){ return $this->name; }
	public function setName($_name)
	{
		$this->name = $_name;
		return $this;
	}

    public function getTitle(){ return $this->title; }
	public function setTitle($_title)
	{
		$this->title = $_title;
		return $this;
	}

    public function getValue(){ return $this->value; }
	public function setValue($_value)
	{
		$this->value = $_value;
		return $this;
	}
}

?>