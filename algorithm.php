<?php
    ini_set('display_errors', 'On');
    error_reporting(E_ALL | E_STRICT);
    require 'CensorWords.php';
    require_once 'socialPosts/socialPost.php';

class algorithm{
    
    private $censoredPost = "";
    private $post = "";
    private $date = "";
    private $weekDay;
    private $likes = 0;
    private $shares = 0;
    private $numberOfSwears = 0;
    public $numberOfMisspellings = 0;
    public $numberOfCustoms = 0;
    private $timeFlag = 0;
    private $dateFlag = 0;
    private $keyWords;
    private $strictness;
    private $dictarray;
    private $reason = "Reason:  ";
    private $classType = null;
    private $custom = null;
    
    public function __construct(socialPost $givenPost, $strictness, $dictarray, $custom) {	
        $this->post = $givenPost->getText();
        $this->date = $givenPost->getDate();
        $this->weekDay = $givenPost->getDay();
        $this->likes = $givenPost->get_likes();
        $this->shares = $givenPost->get_shares();
        $this->keyWords = null;
        $this->strictness = $strictness;
        $this->dictarray = $dictarray;
        $this->classType = $givenPost->getClass();
        if (strcmp($custom, "") != 0){
            $this->custom = preg_split('/[,]/', $custom);
        }
	}
	public function addKeywords($additionalFlagWords) {
        $this->keyWords = $additionalFlagWords;
	}
	
	function checkTime(){
	    if (strcmp($this->classType, "facebookPost" == 0)){
	        if ($this->date['hour'] < 5 || $this->date['hour'] > 23){
    	        $this->timeFlag = 1;
    	    }
	    }
	    else{
    	    if ($this->date['hour'] < 9 && $this->date['hour'] > 4){
    	        $this->timeFlag = 1;
    	    }
	    }
	}
	
	function checkDate(){
	    if (strcasecmp($this->weekDay, "Fri") == 0 || strcasecmp($this->weekDay, "Sat") == 0 ){
	        $this->dateFlag = 1;
	    }
	    if ($this->date['year'] < 2010){
	        $this->dateFlag += 1;
	    }
	    if ($this->date['month'] == 4 && $this->date['day'] == 20){
	        $this->dateFlag += 1;  //drop the blunt kid
	    }
	}

    /* Checks the number of swear words in the post and stores the 
    censored post and number of swears as member variables to algorithm */
    function checkSwears() 
	{
	    $censorWords = new CensorWords; 
	    $words = explode(" ", $this->post);
	    $length = count($words);
	    foreach ($words as $word){
    	    $result =  $censorWords->censorString($word);
    	    if ($words[$length - 1] != $word){
    	        $this->censoredPost .=$result['clean']." ";
    	    }
    	    else{
    	        $this->censoredPost .=$result['clean'];
    	    }
    	    $this->numberOfSwears +=$result['count'];
	    }
    }
    
    function check_word($word, $dictionary){
	    if (!ctype_alpha($word) || strlen($word) <= 3) return 1;

	    $min = 0;
    	$max = count($dictionary) - 1;
    	while($min <= $max){
    		$current = floor(($max - $min)/2 + $min);
	    	if (strcasecmp($dictionary[$current], $word) == 0) return 1;
	    	else if (strcasecmp($dictionary[$current], $word) > 0){
	    		$max = $current - 1;
	    	}
	    	else{
	    		$min = $current + 1;
	    	}
    	}
    	return 0;
    }
    
    function checkMisspellings()
    {
        preg_replace('/[ \t]+/', ' ', preg_replace('/\s*$^\s*/m', "\n", $this->post));
        $words = explode(" ", $this->post);
        foreach ($words as $word){
            if (!$this->check_word($word, $this->dictarray)) {
                $this->numberOfMisspellings++;
            }
        }
    }
    
    function checkCustoms(){
        
        $words = explode(" ", $this->post);
        
             
        foreach ($this->custom as $custom){
            foreach ($words as $word){
                $word = preg_replace('/[^a-z]+/i', '', $word);
                if (strcasecmp (trim($word), trim($custom)) == 0) {
                    $this->numberOfCustoms++;
                    $this->reason = $this->reason."Found custom flag ".$word."<br/>";
                    break;
                }
            }
        }
    }
    
    
    
    function runAlgorithm(){
        $this->checkSwears();
        $this->checkDate();
        $this->checkTime();
        $this->checkMisspellings();
    }
    
        function getCensoredPost(){
        if ($this->censoredPost == ""){
            checkSwears();
        }
        return $this->censoredPost;
    }
    
    function swearReason($threshHold){
         if ($this->numberOfSwears >= $threshHold){
            $this->reason = $this->reason.$this->getCensoredPost()."<br/>";
        }
    }
    
    function misspellReason($threshHold){
         if ($this->numberOfMisspellings >= $threshHold && $threshHold != 0){
            $this->reason = $this->reason."You had ".$this->numberOfMisspellings." mispellings"."<br/>";
        }
    }
    
    function timeReason($threshHold){
         if ($this->timeFlag >= $threshHold){
            $this->reason = $this->reason."Posted at high risk time"."<br/>";
        }
    }
    
    function dateReason($threshHold){
         if ($this->dateFlag >= $threshHold){
            $this->reason = $this->reason."Posted on high risk date"."<br/>";
        }
    }
    
    function getScore () {
        if (strcmp ($this->strictness,"Basic") == 0){
            $swearThreshold = 1;
            $misspellThreshold = .25;
            $this->swearReason($swearThreshold);
            $this->misspellReason($misspellThreshold);
            return $this->numberOfSwears * $swearThreshold + $this->numberOfMisspellings *  $misspellThreshold;
        }
        else if (strcmp ($this->strictness, "Moderate") == 0){
            $swearThreshold = 1;
            $misspellThreshold = .25;
            $timeThreshold = .5;
            $dateThreshold = .5;
            $this->swearReason($swearThreshold);
            $this->misspellReason($misspellThreshold);
            $this->timeReason($timeThreshold);
            $this->dateReason($dateThreshold);
            return $this->numberOfSwears * $swearThreshold + $this->numberOfMisspellings * $misspellThreshold + $this->timeFlag * $timeThreshold+ $this->dateFlag * $dateThreshold;
        }
        else if (strcmp ($this->strictness, "Strict") == 0){
            $swearThreshold = 1;
            $misspellThreshold = .25;
            $timeThreshold = 1;
            $dateThreshold = 1;
            $this->swearReason($swearThreshold);
            $this->misspellReason($misspellThreshold);
            $this->timeReason($timeThreshold);
            $this->dateReason($dateThreshold);
            return $this->numberOfSwears * $swearThreshold + $this->numberOfMisspellings * $misspellThreshold + $this->timeFlag * $timeThreshold+ $this->dateFlag * $dateThreshold;
        }
        else if (strcmp ($this->strictness, "Custom") == 0){
            $swearThreshold = 1;
            $misspellThreshold = .25;
            $timeThreshold = 1;
            $dateThreshold = 1;
            $this->swearReason($swearThreshold);
            $this->misspellReason($misspellThreshold);
            $this->timeReason($timeThreshold);
            $this->dateReason($dateThreshold);
            $this->checkCustoms();
            return $this->numberOfSwears * $swearThreshold + $this->numberOfMisspellings * $misspellThreshold + $this->timeFlag * $timeThreshold+ $this->dateFlag * $dateThreshold + $this->numberOfCustoms;
        }
    }
    

    

    
    function getReason(){
       return $this->reason;
    }
    
    function getPost(){
        return $this->post;
    }
    
}



?>