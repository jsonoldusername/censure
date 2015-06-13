<?php

class socialPost {
	
	public $score;
    public $text;
	public $date;
	public $day;
	public $like_equivalent;
	public $share_equivalent;
	public $username;
	public $profile_picture;
	public $identifier;
	public $reason;
	public $media;
	public $url;
	public $picture;
	public $date_pretty;
	
	public function __construct() {	
	    $this->score = -1;
	}
	
	public function setScore($score){
	    $this->score = $score;
	}

	public function getText() {
        return $this->text;
    }
	
	public function getDate() {
		return $this->date;
	}
	
	public function getDay() {
	    return $this->day;
	}
	
	public function get_likes() {
	    return $this->like_equivalent;
	}
	
	public function get_shares() {
	    return $this->share_equivalent;
	}
	
	public function getScore(){
	    return $this->score;
	}
	
	public function getIdentifier(){
	    return $this->identifier;
	}
	public function getReason(){
	    return $this->reason;
	}
    public function getUrl(){
        return $this->url;
    }
    public function getPicture(){
        return $this->picture;
    }
}

?>