<?php
include_once 'socialPost.php';
class facebookPostArray extends socialPost {
	
	public function __construct($post){
	    parent::__construct();
	    $this->created_at = $post["created_time"];
	    $this->username = $post["from"]["name"];
	    //$this->profile_picture = $post->user->profile_image_url;
	    if (array_key_exists('message', $post)) {
	        
	        $this->text = $post['message'];
	    }
	    //$this->share_equivalent = $post["shares"];
	    if (array_key_exists('likes', $post)) {
	    $this->like_equivalent = count($post['likes']);
	    }
	    if (array_key_exists('created_time', $post)) {
	    $this->date = date_parse($post["created_time"]);
	    }
	    $date1 = new DateTime($this->created_at);
	    
	    $this->date_pretty = $date1->format('H:i d/m/Y');
	    
	    if (array_key_exists('created_time', $post)) {
	    $this->date_raw = $post["created_time"];
	    }
	    if (array_key_exists('id', $post)) {
	    $this->identifier = $post["id"];
	    }
	    $break = $post["id"];
	    $pieces = explode("_", $break);
	    $this->url = "http://facebook.com/".$pieces[0]."/posts/".$pieces[1];
	    // && strcmp($post["story"], "You changed your profile picture.") == 0 
	    
	    if (array_key_exists('object_id', $post) && array_key_exists('story', $post)){
	        $this->picture = "https://graph.facebook.com/".$post['object_id']."/picture";
	        
	    }
	    if (array_key_exists('picture', $post) ){
	        $this->picture = $post['picture'];
	    }
	    $this-> day = date('w', strtotime(date_format(new DateTime($post["created_time"]), "d/m/Y"))); ;
	    }
	
	public function addReason($reason){
	    $this->reason = $reason;
	}
	
	public function getClass() {
		return "facebookPostArray";
	}
	
}

?>