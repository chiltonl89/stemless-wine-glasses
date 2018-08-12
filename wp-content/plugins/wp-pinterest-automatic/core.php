<?php
function echome($val){
	echo str_repeat(' ',1024*64);
	echo $val;
}

//wp-load
@include('../../../wp-load.php');
 
 
// spintax
require_once('inc/class.spintax.php');
 
/* ------------------------------------------------------------------------*
* Auto Link Builder Class
* ------------------------------------------------------------------------*/
class pinterest{
public $ch='';
public $db='';
public $spintax='';

/* ------------------------------------------------------------------------*
* Class Constructor
* ------------------------------------------------------------------------*/
function pinterest(){
 	//plugin url
 	
	//db 
	global $wpdb;
	$this->db=$wpdb;
	$this->db->show_errors();
	@$this->db->query("set session wait_timeout=28800");


	$this->ch = curl_init();
 	//verbose	

	//verbose	
	//$verbose=fopen('verbose.txt', 'w');
	
	
	//curl_setopt($this->ch, CURLOPT_VERBOSE , 1);
	//curl_setopt($this->ch, CURLOPT_STDERR,$verbose);
	
	
	
	
	curl_setopt($this->ch, CURLOPT_HEADER,0);
	curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($this->ch, CURLOPT_CONNECTTIMEOUT, 10);
	curl_setopt($this->ch, CURLOPT_TIMEOUT,20);
	curl_setopt($this->ch, CURLOPT_REFERER, 'http://www.bing.com/');
	curl_setopt($this->ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.8) Gecko/2009032609 Firefox/3.0.8');
	curl_setopt($this->ch, CURLOPT_MAXREDIRS, 5); // Good leeway for redirections.
//    curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, 1); // Many login forms redirect at least once.
	curl_setopt($this->ch, CURLOPT_COOKIEJAR , "cookie.txt"); 	
	curl_setopt($this->ch, CURLOPT_HEADER, 1);
	
	//spintax
	$this->spintax = new Spintax();
	
	$this->log('ini','initializing for a new pin...');
}
 

 
/* ------------------------------------------------------------------------*
* Pinterest Post
* ------------------------------------------------------------------------*/
function pinterest_post($post_id,$pin_text,$pin_board) {
	
	$original_pin=$pin_board;
	
	if(!is_numeric($pin_board)){
		//get id 
		$pin_board=$this->pinterest_getboard($pin_board);
		
		if(!is_numeric($pin_board)){
			
			$this->log('Error','Failed to get id for board url cancel pin');
			echo '<br>Failed to get board id';
			return false;
			
		}else{
			
			//update the id 
			$query="update wp_amazonpin_camps set camp_pinterest_board = '$pin_board' where camp_pinterest_board ='$original_pin'  ";
			$this->db->query($query);
			
		}		
		
	}
	

	
	//verify account
	$puser=get_option('wp_amazonpin_pu','');
	$ppass=get_option('wp_amazonpin_pp','');
	
	if(trim($puser)=='' || trim($ppass)== '' ){
		echo '<br>No pinterest Account added';
		return false;
	}
	
	//get first image from post or return
	$post=get_post($post_id);
	$html=$post->post_content;
	$post_link=get_permalink($post->ID); 
	
	 
	$images = array();
	
    if (stripos($html, '<img') !== false) {
            $imgsrc_regex = '#<\s*img [^\>]*src\s*=\s*(["\'])(.*?)\1#im';
            preg_match($imgsrc_regex, $html, $matches);
            unset($imgsrc_regex);
            unset($html);
            
            if (is_array($matches) && !empty($matches)) {
                $img= $matches[2];
            } else {
                //alternate added image
                $img=get_option('product_img','');
				                
            }
            
            if(trim($img) == '') {
            	echo '<br>No Images found to pin';
            	return false;
            }
            
            //let's pin 
            $tocken=$this->pinterest_login($puser,$ppass);
            
            if(trim($tocken) != ''){
            	$this->pinterest_pin($tocken,$pin_board,$pin_text,$post_link,$img);
            }else{
            	echo '<br>Faild to login canel pinning...';
            }
            
            
     }  

	
}
 

function pinterest_getboards(){
	//we already logged get https://pinterest.com/settings/

 
//curl get
$x='error';
$url='https://pinterest.com/settings/';
curl_setopt($this->ch, CURLOPT_HTTPGET, 1);
curl_setopt($this->ch, CURLOPT_URL, trim($url));
while (trim($x) != ''  ){
	$exec=curl_exec($this->ch);
	$x=curl_error($this->ch);
	//echo $x;
}

//echo $exec;
//echo 'ops';

//echo $exec;
//echo $exec;<div class="BoardList">

preg_match_all("{<div class=\"BoardList\">((.|\s)*?)</ul>}",$exec,$matches,PREG_PATTERN_ORDER);
$res=$matches[1];
$list=$res[0];

preg_match_all("{<li data=\"(.*?)\"((.|\s)*?)<span>(.*?)</span>}",$list,$matches,PREG_PATTERN_ORDER);
 
@$ids=$matches[1];
@$titles=$matches[4];


if (count($ids)>=1){
	
	update_option('wp_pinterest_boards',array('ids'=> $ids , 'titles' => $titles ));
	
	$res['ids']=$ids;
	$res['titles']=$titles;
	$res['status']='success';
}else{
	
	$res['status']='fail';
}

print_r(json_encode($res));

}

/* ------------------------------------------------------------------------*
* Get board id from url
* ------------------------------------------------------------------------*/
function pinterest_getboard($board_url){
	if (trim($board_url)== '') return false;

	//curl ini
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_HEADER,0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
	curl_setopt($ch, CURLOPT_TIMEOUT,20);
	curl_setopt($ch, CURLOPT_REFERER, 'http://www.bing.com/');
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.8) Gecko/2009032609 Firefox/3.0.8');
	curl_setopt($ch, CURLOPT_MAXREDIRS, 5); // Good leeway for redirections.
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // Many login forms redirect at least once.
	curl_setopt($ch, CURLOPT_COOKIEJAR , "cookie2.txt");
	
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	
   
		//Get
	$x='error';
	while (trim($x) != ''  ){
		$url=$board_url;
		curl_setopt($ch, CURLOPT_HTTPGET, 1);
		curl_setopt($ch, CURLOPT_URL, trim($url));
		$exec=curl_exec($ch);
		echo $x=curl_error($ch);
	}
	
	//echo $exec;
	
	preg_match_all("{var board = (.*?);}",$exec,$matches,PREG_PATTERN_ORDER);
	$res=$matches[1];
	$id=$res[0];
	echo '<br>Board id:'.$id;
	
	 
	
	return $id;
		
}
 
/* ------------------------------------------------------------------------*
* Pinterest Log 
* ------------------------------------------------------------------------*/
function pinterest_login($email,$pass){
	
 

	// GET: https://pinterest.com/login/?next=%2Flogin%2F
 	$url='https://pinterest.com/login/?next=%2Flogin%2F';
 	//$url='http://coredue.com/php/test.php';
 
 	
 	//Get
	$x='error';
	while (trim($x) != ''  ){
		curl_setopt($this->ch, CURLOPT_HTTPGET, 1);
		curl_setopt($this->ch, CURLOPT_URL, trim($url));
		curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, false);
		$exec=curl_exec($this->ch);
		$x=curl_error($this->ch);
		if($x != 'error' & trim($x) != ''){
			$this->log('Curl Try Error',$x);
		}
 
	}
	
 
	
	//extract ' name='csrfmiddlewaretoken' value='9dd872d04d23903c8cd1287998b9ea5d'
	preg_match_all("{name='csrfmiddlewaretoken' value='(.*?)'}",$exec,$matches,PREG_PATTERN_ORDER);
 	$res=$matches[1];
	$tocken=$res[0];
	
	//echo "<br>Tockent : {$tocken}";
	
	if (trim($tocken) == ''){
		//echo $exec;
		$this->log('Error','Failed to fetch Pinterest tocken');
		return false;
	}
	
	//extract 
	preg_match_all("{_pinterest_sess=\"(.*?)\"}",$exec,$matches,PREG_PATTERN_ORDER);
 	$res=$matches[1];
	$sess=$res[0];
	
	//echo $exec;
	if( trim($sess) == ''){
	
		//echo '<br>Session Parameter failed';
		echo $exec;
		$this->log('Error','Failed to fetch Pinterest session num cancelling pinning this time ... ');
		return false;
	}
	 
	  
	//Post login email=sweetheatmn%40yahoo.com&password=01292 &next=%2F&csrfmiddlewaretoken=8e0371f9dac6d39b1fe26e00a0595606
	$email=urlencode($email);
	$pass=urlencode($pass);
	$curlurl='https://pinterest.com/login/?next=%2F';
	$x='error';
	while (trim($x) != ''  ){
		//curl post
		$curlpost="email=$email&password=$pass&next=%2F&csrfmiddlewaretoken=$tocken";
		//$curlpost="email=sweetheatmn%40yahoo.com&password=0129212211&next=%2Fsettings%2F&csrfmiddlewaretoken=$tocken"; 
		curl_setopt($this->ch, CURLOPT_REFERER, 'http://pinterest.com/login/?next=%2F');
		//curl_setopt($this->ch, CURLOPT_HTTPHEADER, "HOST:pinterest.com");
		//curl_setopt($this->ch,CURLOPT_COOKIE,"_pinterest_sess=\"$sess\";__utma=229774877.1960910657.1333904477.1333904477.1333904477.1; __utmb=229774877.1.10.1333904477; __utmc=229774877; __utmz=229774877.1333904477.1.1.utmcsr=(direct)|utmccn=(direct)|utmcmd=(none); __utmv=229774877.|2=page_name=login_screen=1"); 
		curl_setopt($this->ch, CURLOPT_URL, $curlurl);
		curl_setopt($this->ch, CURLOPT_POST, true);
		curl_setopt($this->ch, CURLOPT_POSTFIELDS, $curlpost); 
		$exec=curl_exec($this->ch);
				$x=curl_error($this->ch);
		if($x != 'error' & trim($x) != ''){
			$this->log('Curl Try Error',$x);
		}

		
		
	}
 

	 $url='https://pinterest.com/';
 	//$url='http://coredue.com/php/test.php';
 	 	
 	//Get
	//extract 
	preg_match_all("{_pinterest_sess=\"(.*?)\"}",$exec,$matches,PREG_PATTERN_ORDER);
 	$res=$matches[1];
	$sess=$res[0];
	
	 //echo $exec;
	if( trim($sess) == ''){
		//echo '<br>Session Parameter failed';
		$this->log('Error','Failed to fetch Pinterest session num 2');
		return false;
	}
	 	
	 	
	$x='error';
	while (trim($x) != ''  ){
		curl_setopt($this->ch,CURLOPT_COOKIE,"_pinterest_sess=\"$sess\";__utma=229774877.1960910657.1333904477.1333904477.1333904477.1; __utmb=229774877.1.10.1333904477; __utmc=229774877; __utmz=229774877.1333904477.1.1.utmcsr=(direct)|utmccn=(direct)|utmcmd=(none); __utmv=229774877.|2=page_name=login_screen=1");
		curl_setopt($this->ch, CURLOPT_HTTPGET, 1);
		curl_setopt($this->ch, CURLOPT_URL, trim($url));
		curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, false);
		$exec=curl_exec($this->ch);
				$x=curl_error($this->ch);
		if($x != 'error' & trim($x) != ''){
			$this->log('Curl Try Error',$x);
		}

	}
	 
 	
	 if (stristr($exec,'Add')){ 	
	 	$this->log('Success', 'Pinterest Login Success');
	 	return $tocken;
	 }else{
	 	$this->log('Fail', 'Pinterest Login Failed');
	 	return false;
	 }
	
}

function pinterest_pin($tocken,$board,$details,$link,$imgsrc){
	//curl post:http://pinterest.com/pin/create/
	$curlurl='http://pinterest.com/pin/create/';
	$curlpost="board=$board&details=$details&link=$link&img_url=$imgsrc&csrfmiddlewaretoken=$tocken";

	$x='error';
	while (trim($x) != ''  ){
		//curl post
	 	curl_setopt($this->ch, CURLOPT_URL, $curlurl);
		curl_setopt($this->ch, CURLOPT_POST, true);
		curl_setopt($this->ch, CURLOPT_POSTFIELDS, $curlpost); 
		$exec=curl_exec($this->ch);
		$x=curl_error($this->ch);
		if($x != 'error' & trim($x) != ''){
			$this->log('Curl Try Error',$x);
		}
	}

	//echo $exec;
	
	if (stristr($exec,'"success"')){
		
		//extract pin url
		preg_match_all("{/pin/(.*?)/}",$exec,$matches,PREG_PATTERN_ORDER);
			
		
		$res=$matches[0];
		$pin=$res[0];
		$url= 'http://pinterest.com'.$pin;
		$this->log('Success',"successful <a href=\"$url\">Pin</a>") ;		
	}else{
		
		if (stristr($exec,'captcha')){
			
			$this->log('Fail',"Pinterest asked for captcha please login manually to your account do a pin solve the captcha and pinning should back without problem also please don't pin very fast just let it be as a manual pin as posible") ;
			
		}	
 
		return false;
	}	
	
	
	
	}

/* ------------------------------------------------------------------------*
* Logging Function
* ------------------------------------------------------------------------*/	
function log($type,$data){
	//$now= date("F j, Y, g:i a");
	$now = date( 'Y-m-d H:i:s');
	$data=mysql_real_escape_string($data);
	$query="INSERT INTO wp_pinterest_automatic (action,date,data) values('$type','$now','$data')";
	//echome$query;
	$this->db->query($query);
}
	
 

}//End



/* ------------------------------------------------------------------------*
* Testing the Plugin
* ------------------------------------------------------------------------*/	

if(trim($_POST['action']) == 'boards'){

$gm=new pinterest();
$tocken=$gm->pinterest_login($_POST['user'],$_POST['pass']);
$gm->pinterest_getboards();
	
}

//$img=$gm->pinterest_pin($tocken,'125819452028650965','Strawebery Awesome dress','http://coredue.com/wp','http://ecx.images-amazon.com/images/I/51zRBMa-lHL.jpg');

//$gm->process_campaigns();
//$gm->pinterest_post(2699);
//$gm->pinterest_getboard('http://pinterest.com/matef/products-i-love/');

//$gm->fetch_links('yup');
//$gm->process_campaigns();
//echo ($gm->spin('I love talking to relatives'));

//$gm->update_categories();
 //exit;

 //$alb->trackback('http://signdev.com/wp25/my-new-post/trackback','My blog','3a this is the excerpt','http://coredue.com');

// $alb->fetch_links('','');
/*$link='http://fightersmma.com/2011/07/how-to-make-a-successful-home-based-business/';

	$alb->c->set(CURLOPT_URL, trim($link));
	$alb->c->set(CURLOPT_CONNECTTIMEOUT, 7);
	$alb->c->set(CURLOPT_CONNECTTIMEOUT, 20);
	$page_content= $alb->c->execute();
	//echo $page_content; */
//echo $alb->is_wordpress('http://dailytop15.com/tag/fiverr/');

//$alb->fetch_links('wii');
//$alb->place_comment('http://signdev.com/?p=5','');
//$alb->process_campaigns();
//$alb->ShowFileExtension('http://top-ten-wii-games.com/play');

//echome  $alb->is_file('http://georges.gardarin.free.fr/Cours_XML/7b-XML%20Indexing%20Techniques.ppt');
?>
