<?php
include_once 'socialPost.php';
class facebookPost extends socialPost {
	
	public function __construct($post){
	    parent::__construct();
	    $this->created_at = $post->created_time;
	    $this->username = $post->from->name;
	    //$this->profile_picture = $post->user->profile_image_url;
	    if (property_exists( $post, 'message')) {
	        
	        $this->text = $post->message;
	    }
	    //$this->share_equivalent = $post["shares"];

	    
	    $this->date = date_parse($post->created_time);
	    $this->date['hour']-=5;
	    if ($this->date['hour'] < 0){
	        $this->date['hour'] += 24;
	        $this->date['day'] -= 1;
	    }
	    $date1 = new DateTime($this->created_at);
	    date_modify($date1, '-5 hours');
	    $this->date_pretty = $date1->format('H:i d/m/Y');
	    $this->date_raw = $post->created_time;
	    $this->identifier = $post->id;
	    $break = $post->id;
	    $pieces = explode("_", $break);
	    $this->url = "http://facebook.com/".$pieces[0]."/posts/".$pieces[1];
	    if (property_exists ( $post, "likes")){
	        $this->like_equivalent = count($post->likes);
	    }
	    // && strcmp($post["story"], "You changed your profile picture.") == 0 
	    
	    if (property_exists ($post, "object_id") && property_exists ($post, "story")){
	        
	        $this->picture = "https://graph.facebook.com/".$post->object_id."/picture";
	    }
	    if (property_exists ($post, "picture") ){
	        $this->picture = $post->picture;
	    }
	    $this-> day = date('w', strtotime(date_format(new DateTime($post->created_time), "d/m/Y"))); ;
	    }
	
	public function addReason($reason){
	    $this->reason = $reason;
	}
	
	public function getClass() {
		return "facebookPost";
	}
	
}

?>