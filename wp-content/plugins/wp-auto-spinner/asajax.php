<?php

//AJAX SEND TO SPIN QUEUE
add_action( 'wp_ajax_wp_auto_spinner_spin', 'wp_automatic_spin_callback' );

function wp_automatic_spin_callback() {
	
	
	$itms=$_POST['itms'];
	
 
	
	$itms_arr = explode(',', $itms);
	$itms_arr= array_filter($itms_arr);

	foreach($itms_arr as $post_id ){
		update_post_meta($post_id, 'wp_auto_spinner_scheduled', 'yes');
		update_post_meta($post_id, 'wp_auto_spinner_checked', 'yes');

		
		delete_post_meta($post_id, 'spinned_cnt');
	}

	die();
}