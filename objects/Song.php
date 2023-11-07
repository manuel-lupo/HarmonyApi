<?php
class Song{
    public $id;

    public $title;
    
    public $rel_date;
    
    public $album_id;

	public $lyrics;

    public function setValues($id, $title, $rel_date, $album_id, $lyrics){
        $this->id = $id;
        $this->$title = $title;
        $this->rel_date = $rel_date;
        $this->album_id = $album_id;
        $this->lyrics = $lyrics;
    }
   

	    /**
	 * @return string
	 */
	public function getLyrics() {
		return $this->lyrics;
	}

    /**
	 * @return string
	 */
	public function getAlbum_id() {
		return $this->album_id;
	}

	/**
	 * @return string
	 */
	public function getRel_date() {
		return $this->rel_date;
	}

	/**
	 * @return string
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * @return int
	 */
	public function getId() {
		return $this->id;
	}

    
    /**
     * Set the value of id
     *
     * @return  self
     */ 

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */ 
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Set the value of rel_date
     *
     * @return  self
     */ 
    public function setRel_date($rel_date)
    {
        $this->rel_date = $rel_date;

        return $this;
    }

    /**
     * Set the value of album_id
     *
     * @return  self
     */ 
    public function setAlbum_id($album_id)
    {
        $this->album_id = $album_id;

        return $this;
    }

	/**
	 * Set the value of lyrics
	 *
	 * @return  self
	 */ 
	public function setLyrics($lyrics)
	{
		$this->lyrics = $lyrics;

		return $this;
	}
}