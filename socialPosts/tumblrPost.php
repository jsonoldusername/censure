<?php
include_once 'socialPost.php';
//require dirname(__FILE__).'/../GrantTest/dbconfig.php';
class tumblrPost extends socialPost {
	
	public function __construct($post){
        //if (is_null($connection)) echo "null connection";
        //else echo "connection works";
        $connection = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE) or die('Unable');
	    parent::__construct();
	    $this->created_at = $post->date;
	    $this->username = $post->blog_name;
	    //$this->profile_picture = $tweet->user->profile_image_url;
	    //$post->body = strip_tags($post->body);
	    //if (is_null($post->title)) $post->title = 'no post title';
	    //if (is_null($post->body)) $post->body = 'no post body';
	    //$this->text = $connection->real_escape_string($post->title) . ' : ' . $connection->real_escape_string($post->body);
	    //$this->share_equivalent = $tweet->retweet_count;
	    $this->like_equivalent = $post->note_count;
	    $this->date = date_parse($post->date);
	    $this->date['hour'] -= 5;
	    if ($this->date['hour'] < 0){
	        $this->date['hour'] += 24;
	        $this->date['day'] -= 1;
	    }
	    $this->date_raw = $post->date;
        $date1 = new DateTime($this->created_at);
        date_modify($date1, '-5 hours');
	    $this->date_pretty = $date1->format('H:i m/d/Y');	    //$this->day = date('w', strtotime($post->date));
	    $this->identifier = $post->id;
	    $this->text = "";
	    $this->media = array();
	    $this->images = "";
	    if($post->type == "quote") {
	        $this->text = $post->source;
	    } else if($post->type == "photo") {
	        $this->text = $post->caption;
	        foreach($post->photos as $px) {
	            array_push($this->media, $px->alt_sizes[0]->url);
	            $this->images = $this->images."<img class=\"tumpics\" src=".$px->alt_sizes[0]->url.">";
	        }
	    } else if($post->type == "text" || $post->type == "chat") {
	        $this->text = $post->title." : ".$post->body;
	    } else if($post->type == "link") {
	        $this->text = $post->title." : ".$post->description;
	    } else if($post->type == "answer") {
	        $this->text = $post->question." : ".$post->answer;
	    } else if($post->type == "audio" || $post->type == "video") {
	        $this->text = $post->caption;
	    }
	    $this->text = $connection->real_escape_string($this->text);
	}
	
	public function addReason($reason){
	    $this->reason = $reason;
	}
	
	public function getClass() {
		return "tumblrPost";
	}
	
}

?>