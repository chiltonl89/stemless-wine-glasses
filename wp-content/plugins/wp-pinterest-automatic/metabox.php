<?php 
$dir = WP_PLUGIN_URL.'/wp-pinterest-automatic/'; 

$pin_options=get_option('wp_pinterest_options',array());
$pin_options=implode('|',$pin_options);


$pin_text=get_option('wp_pinterest_default','{awesome|nice|cool} [post_title]');
$wp_pinterest_boards=get_option('wp_pinterest_boards',array('ids'=>array() ,  'titles'=> array() ));
$wp_pinterest_boards_ids=$wp_pinterest_boards['ids'];
$wp_pinterest_boards_titles=$wp_pinterest_boards['titles'];
$wp_pinterest_board=get_option('wp_pinterest_board','');


?>


<link href="<?php echo $dir; ?>css/style.css" media="screen" rel="stylesheet" type="text/css"/>
<link href="<?php echo $dir; ?>css/uniform.css" media="screen" rel="stylesheet" type="text/css"/>
<link href="<?php echo $dir; ?>css/tabs.css" media="screen" rel="stylesheet" type="text/css" >
<link href="<?php echo $dir; ?>css/jquery.gcomplete.default-themes.css" media="screen" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="<?php echo $dir; ?>js/jquery.tools.js"></script>
<script type="text/javascript" src="<?php echo $dir; ?>js/jquery.uniform.min.js"></script>
<script type="text/javascript" src="<?php echo $dir; ?>js/main.js"></script>
<script type="text/javascript" src="<?php echo $dir; ?>js/jquery.gcomplete.0.1.2.js"></script>
<script type="text/javascript" src="<?php echo $dir; ?>js/jquery.tools.tabs.min.js"></script>


<div class="TTWForm-container">
      <div class="TTWForm" style="width:250px !important">
      
      <?php
		 
                     
       ?>
      
      <div id="field-pin_options-container" class="field f_100" >
           <div class="option clearfix">
               <input     name="pin_options[]" id="field-pin_options-1" value="OPT_PIN" type="checkbox">     
                <span class="option-title">
       			 Pin this post ?
                </span>
           </div>
      </div> 
      
      <div class="clear"></div>
      
      
      <div id="pin-contain">
      
      <div id="pin-images"> <!-- pin images here --> 
      
      <?php // images in queue 
       global $post;
        @$pin_images=get_post_meta($post->ID,'pin_images',1);
        //print_r($pin_images);
         
         
      	if(is_array($pin_images)){
      		$pin_text=get_post_meta($post->ID,'pin_text',1);
      		$wp_pinterest_board=get_post_meta($post->ID,'pin_board',1);
      		
      		
      		foreach ($pin_images as $pin_img){
      			//@$pin_img=$pin_img[0];
      			if(trim($pin_img) != ''){
      				?>
      			
      			  <div class="pin_img_contain">
			      	<input   type="checkbox"   name="pin_images[]"value="<?php echo $pin_img ?>" checked="checked"  class="pin_check">
			      	
			      	<img src="<?php echo trim($pin_img) ?>" class="pin_img" />      	
			      </div>
			      				
      			<?php 
      			}
      		}
      	}
      
      ?>
      
      </div>
      
      <div class="clear"></div>
 
      <div id="field-pin_options-container" class="field f_100" >
           <div class="option clearfix">
               <input     name="pin_options[]" id="field-pin_options-2" value="OPT_PIN_VAR" type="checkbox">     
                <span class="option-title">
       			 Modify Pin Variables
                </span>
           </div>
      </div>
      
      <div id="pin_vars"><!-- pin vars -->
      <div id="field-pin_text-container" class="field f_100">
      	<label for="field-pin_text">
      	    Pin Text :
      	</label>
      	<input value="<?php echo $pin_text  ?>" name="pin_text" id="field-pin_text" required="required" type="text">
      </div>
      
      
      <div id="field-PIN_BOARD-container" class="field f_100" >
      	<label for="field-PIN_BOARD">
      		Pin Board :
      	</label>

		<select name="PIN_BOARD"  >
      		
      		<?php
      		$i=0;

      		foreach($wp_pinterest_boards_ids as $id){ ?>
      		
			<option  value="<?php echo $id ?>"  <?php opt_selected( $id ,$wp_pinterest_board) ?> ><?php echo $wp_pinterest_boards_titles[$i]?></option>
      			
      		<?php
      			$i++; 	
      		}
      		
      		?> 
      	</select>
      </div>
      
      </div><!-- / pin vars -->
    
      </div><!-- pin contain -->
      
    
      
      <div class="clear"></div>
      </div><!--/TTWForm-->
      
      <!-- image template -->
      <div id="img_template" style="visibility:hidden;width:0px;height:0px;overflow:hidden	">
      <div class="pin_img_contain">
      	<input     name="pin_images[]"value="1" type="checkbox" class="pin_check">
      	<img src="http://www.veryicon.com/icon/png/Object/Magnets/Alarm%20clock.png" class="pin_img" />      	
      </div>
      </div>
      <!-- /image template -->
      
  
</div><!--/TTWForm-contain-->
<?php @$pin_images =implode('|',$pin_images)?>
<script type="text/javascript">
    var vals = '<?php echo  $pin_images ?>';
    val_arr = vals.split('|');
     jQuery('.TTWForm-container input:checkbox').removeAttr('checked');
    jQuery.each(val_arr, function (index, value) {
        if (value != '') {
            
            jQuery('input:checkbox[value="' + value + '"]').attr('checked', 'checked');
        }
    });
</script> 

<script type="text/javascript">
    var vals = '<?php echo  $pin_options ?>';
    val_arr = vals.split('|');
    //jQuery('input:checkbox').removeAttr('checked');
    jQuery.each(val_arr, function (index, value) {
        if (value != '') {
            
            jQuery('input:checkbox[value="' + value + '"]').attr('checked', 'checked');
        }
    });
</script> 