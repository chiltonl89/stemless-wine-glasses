<?php $dir = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__)); 

$wp_pinterest_user=get_option('wp_pinterest_user','');
$wp_pinterest_pass=get_option('wp_pinterest_pass','');
$wp_pinterest_default=get_option('wp_pinterest_default','{awesome|nice|cool} [post_title]');
$wp_pinterest_board=get_option('wp_pinterest_board','');
$wp_pinterest_options=get_option('wp_pinterest_options',array());
$wp_pinterest_options=implode('|',$wp_pinterest_options);
$wp_pinterest_boards=get_option('wp_pinterest_boards',array('ids'=>array() ,  'titles'=> array() ));
$wp_pinterest_boards_ids=$wp_pinterest_boards['ids'];
$wp_pinterest_boards_titles=$wp_pinterest_boards['titles'];

?>

<link href="<?php echo $dir; ?>css/style.css" media="screen" rel="stylesheet" type="text/css"/>
<link href="<?php echo $dir; ?>css/uniform.css" media="screen" rel="stylesheet" type="text/css"/>
<link href="<?php echo $dir; ?>css/tabs.css" media="screen" rel="stylesheet" type="text/css" >
<link href="<?php echo $dir; ?>css/jquery.gcomplete.default-themes.css" media="screen" rel="stylesheet" type="text/css"/>

<script type="text/javascript" src="<?php echo $dir; ?>js/jquery.tools.js"></script>
<script type="text/javascript" src="<?php echo $dir; ?>js/jquery.uniform.min.js"></script>
<script type="text/javascript" src="<?php echo $dir; ?>js/main.js"></script>
<script type="text/javascript" src="<?php echo $dir; ?>js/options.js"></script>
<script type="text/javascript" src="<?php echo $dir; ?>js/jquery.gcomplete.0.1.2.js"></script>
<script type="text/javascript" src="<?php echo $dir; ?>js/jquery.tools.tabs.min.js"></script>


<div class="wrap">
    <div style="margin-left:8px" class="icon32" id="icon-options-general">
        <br>
    </div>
    <h2>Pinterest Automatic Settings</h2>
    <!--before  container-->
    <div class="metabox-holder" id="dashboard-widgets">
        <div style="width:49%;" class="postbox-container">
            <div style="min-height:1px;" class="meta-box-sortables ui-sortable" id="normal-sortables">
                <div class="postbox" id="dashboard_right_now">
                    <h3 class="hndle">
                        <span>general settings</span>
                    </h3>
                    <div class="inside" style="padding-bottom:20px">
                        <!--/ before container-->
                        <div class="TTWForm-container">
						      <form class="TTWForm" action="<?php echo $dir; ?>process_form.php" method="post" novalidate="" autocomplete="off">
						      
						                           
						      <div id="field-wp_pinterest_user-container" class="field f_100">
						      	<label for="field-wp_pinterest_user">
						      	    Pinterest Login Email :
						      	</label>
						      	<input value="<?php echo $wp_pinterest_user  ?>" name="wp_pinterest_user" id="field-wp_pinterest_user" required="required" type="text">
						      </div>
						      
						                           
						      <div id="field-wp_pinterest_pass-container" class="field f_100">
						      	<label for="field-wp_pinterest_pass">
						      	    Pinterest Password :
						      	</label>
						      	<input value="<?php echo $wp_pinterest_pass  ?>" name="wp_pinterest_pass" id="field-wp_pinterest_pass" required="required" type="password">
						      </div>
						      
						                           
						      <div id="field-wp_pinterest_default-container" class="field f_100">
						      	<label for="field-wp_pinterest_default">
						      	    Default Pin Text :
						      	</label>
						      	<input value="<?php echo $wp_pinterest_default  ?>" name="wp_pinterest_default" id="field-wp_pinterest_default" required="required" type="text">
						      </div>
						      
						      
						      
						      
						      <div id="field-wp_pinterest_board-container" class="field f_100" >
						      	<label for="field-wp_pinterest_board">
						      		Default Pin Board ? 
						      	</label>
						      	<select name="wp_pinterest_board" id="field1zz" required="required">
						      		
						      		<?php
						      		$i=0;

						      		foreach($wp_pinterest_boards_ids as $id){ ?>
						      		
									<option  value="<?php echo $id ?>"  <?php opt_selected( $id ,$wp_pinterest_board) ?> ><?php echo $wp_pinterest_boards_titles[$i]?></option>
						      			
						      		<?php
						      			$i++; 	
						      		}
						      		
						      		?> 
						      	</select>
						      	<img alt="" id="ajax-loading" class="ajax-loading" src="images/wpspin_light.gif" style="float:right;margin:3px" >
						      	<a href="<?php echo $dir ?>core.php"><button id="get_boards" class="preview button"> fetch boards</button></a>
						      </div>
						     
						     
						      
						      
						      <div id="field-wp_pinterest_options-container" class="field f_100" >
						           <div class="option clearfix">
						               <input     name="wp_pinterest_options[]" id="field-wp_pinterest_options-1" value="OPT_PIN" type="checkbox">     
						                <span class="option-title">
						       			 Activate Pin by default 
						                </span>
						           </div>
						      </div> 
						      

						      <div id="form-submit" class="field f_100   submit">
						          <input value="Save Options" type="submit">
						      </div>
						      
						     </form><!--/TTWForm-->
						</div><!--/TTWForm-contain--> 
						                        
                        
                        
                        
                        <!--after container-->
                        <div style="clear:both"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- / start container-->
</div><!-- /Wrap -->

<script type="text/javascript">
    var $vals = '<?php echo  $wp_pinterest_options ?>';
    $val_arr = $vals.split('|');
    jQuery('input:checkbox').removeAttr('checked');
    jQuery.each($val_arr, function (index, value) {
        if (value != '') {
            jQuery('input:checkbox[value="' + value + '"]').attr('checked', 'checked');
        }
    });
</script>