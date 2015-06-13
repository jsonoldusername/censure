<?php
include_once 'socialPost.php';
class twitterPost extends socialPost {
	
	public function __construct($tweet){
	    parent::__construct();
	    $this->created_at = $tweet->created_at;
	    $this->day = substr($tweet->created_at, 0, 3);
	    $this->username = $tweet->user->screen_name;
	    $this->profile_picture = $tweet->user->profile_image_url;
	    $this->text = $tweet->text;
	    $this->share_equivalent = $tweet->retweet_count;
	    $this->like_equivalent = $tweet->favorite_count;
	    $this->date = date_parse($tweet->created_at);
	    $this->date['hour'] -= 5;
	    if ($this->date['hour'] < 0){
	        $this->date['hour'] += 24;
	        $this->date['day'] -= 1;
	    }
	    $this->date_raw = $tweet->created_at;
	    $date1 = new DateTime($tweet->created_at);
	    date_modify($date1, '-5 hours');
	    $this->date_pretty = $date1->format('H:i m/d/Y');
	    $this->identifier = $tweet->id;
	    $this->like_equivalent = $tweet->favorite_count;
	    $this->media = NULL;
	    $this->mediacode = "";
	    if (array_key_exists("extended_entities", $tweet)){
	        $this->media = array();
	        foreach($tweet->extended_entities->media as $pic){
	            array_push($this->media, $pic->media_url);
	            $this->mediacode = $this->mediacode."<img class=\"twitpics\" src=".$pic->media_url.">";
	        }
	    }
	}
	
	public function addReason($reason){
	    $this->reason = $reason;
	}
	
	public function getClass() {
		return "twitterPost";
	}
	
}

?>