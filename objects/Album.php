<?php
class Album{
    public $id;
    public $title;

	public $img_url;
    public $rel_date;
    
    public $review;

    public $artist;

    public $genre;

    public $rating;

    
	public function setValues($title, $rel_date, $review, $artist, $genre, $rating, $img_url){
		$this->id = null;		
		$this->title = $title;
		$this->rel_date = $rel_date;
		$this->review = $review;
		$this->artist = $artist;
		$this->genre = $genre;
		$this->rating = $rating;
		$this->img_url = $img_url;
	}

	/**
	 * @return float
	 */
	public function getRating() {
		return $this->rating;
	}

		/**
	 * @return string
	 */
	public function getImgUrl() {
		return $this->img_url;
	}

	/**
	 * @return string
	 */
	public function getGenre() {
		return $this->genre;
	}

	/**
	 * @return string
	 */
	public function getArtist() {
		return $this->artist;
	}

	/**
	 * @return string
	 */
	public function getReview() {
		return $this->review;
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
     * Set the value of title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

	/**
	 * Set the value of img_url
	 */
	public function setImgUrl($img_url)
	{
		$this->img_url = $img_url;
	}

    /**
     * Set the value of rel_date
     */
    public function setRelDate($rel_date)
    {
        $this->rel_date = $rel_date;
    }

    /**
     * Set the value of review
     */
    public function setReview($review)
    {
        $this->review = $review;
    }

    /**
     * Set the value of artist
     */
    public function setArtist($artist)
    {
        $this->artist = $artist;
    }

    /**
     * Set the value of genre
     */
    public function setGenre($genre)
    {
        $this->genre = $genre;
    }

    /**
     * Set the value of rating
     */
    public function setRating($rating)
    {
        $this->rating = $rating;
    }
}