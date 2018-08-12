<?php
/*
Plugin Name: AdSense Privacy Policy
Plugin URI: http://cybec.com/privacy-policy-plugin-for-wordpress/
Description: Automatically adds an AdSense-compliant privacy page. <a href="options-general.php?page=privacy-policy.php">Options configuration panel</a>
Version: 1.1.1
Author: Fernando Torros
Author URI: http://cybec.com
*/
 
/*
To install:
 
1. Upload privacy-policy.zip to the /wp-content/plugins/ directory for your blog.
2. Unzip it into /wp-content/plugins/privacy-policy/privacy-policy.php
3. Activate the plugin through the 'Plugins' menu in WordPress by clicking "Privacy Policy"
4. Go to your Options Panel and open the "Privacy Policy" submenu. /wp-admin/options-general.php?page=privacy-policy.php
5. Configure the privacy policy options you want.

License:

Copyright by Fernando Torros. You are free to use this plugin on 
any WordPress blog. No warranty is provided -- it's up to you to
ensure that the privacy policy it generates is good enough for
your site and/or jurisdiction.
*/

$privacy_policy_ver = '1.1';

$pp_default_sitename = get_bloginfo( 'name' );
$pp_default_before_heading = '<h2>';
$pp_default_after_heading = '</h2>';
$pp_default_before_paragraph = '<p>';
$pp_default_after_paragraph = '</p>';
$pp_default_contact = get_bloginfo( 'admin_email' );
$pp_default_title = 'AdSense Privacy Policy';
$pp_default_slug = 'privacy-policy';
$pp_default_pp_help = true;
$pp_default_browser_help = true;
$pp_default_credit = true;

add_option( 'privacy_policy_sitename', $pp_default_sitename );
add_option( 'privacy_policy_before_heading', $pp_default_before_heading );
add_option( 'privacy_policy_after_heading', $pp_default_after_heading );
add_option( 'privacy_policy_before_paragraph', $pp_default_before_paragraph );
add_option( 'privacy_policy_after_paragraph', $pp_default_after_paragraph );
add_option( 'privacy_policy_contact', $pp_default_contact );
add_option( 'privacy_policy_title', $pp_default_title );
add_option( 'privacy_policy_slug', $pp_default_slug );
add_option( 'privacy_policy_pp_help', $pp_default_pp_help );
add_option( 'privacy_policy_browser_help', $pp_default_browser_help );
add_option( 'privacy_policy_credit', $pp_default_credit );

function privacy_policy_options_setup() {
    if( function_exists( 'add_options_page' ) ){
        add_options_page( 'Adsense Privacy Policy', 'Adsense Privacy Policy', 8, 
                          basename(__FILE__), 'privacy_policy_options_page');
    }

}

function privacy_policy_options_page(){
    global $privacy_policy_ver;
    global $pp_default_sitename;
    global $pp_default_before_heading;
    global $pp_default_after_heading;
    global $pp_default_before_paragraph;
    global $pp_default_after_paragraph;
    global $pp_default_contact;
    global $pp_default_title;
    global $pp_default_slug;
    global $pp_default_pp_help;
    global $pp_default_browser_help;
    global $pp_default_credit;

    if( isset( $_POST[ 'set_defaults' ] ) ){

        echo '<div id="message" class="updated fade"><p><strong>';

	update_option( 'privacy_policy_sitename', $pp_default_sitename );
	update_option( 'privacy_policy_before_heading', $pp_default_before_heading );
	update_option( 'privacy_policy_after_heading', $pp_default_after_heading );
	update_option( 'privacy_policy_before_paragraph', $pp_default_before_paragraph );
	update_option( 'privacy_policy_after_paragraph', $pp_default_after_paragraph );
	update_option( 'privacy_policy_contact', $pp_default_contact );
	update_option( 'privacy_policy_title', $pp_default_title );
	update_option( 'privacy_policy_slug', $pp_default_slug );
	update_option( 'privacy_policy_pp_help', $pp_default_pp_help );
	update_option( 'privacy_policy_browser_help', $pp_default_browser_help );
	update_option( 'privacy_policy_credit', $pp_default_credit );

	echo 'Default Privacy Policy options loaded!';
	echo '</strong></p></div>';

    } else if( isset( $_POST[ 'create_page' ] ) ){

        echo '<div id="message" class="updated fade"><p><strong>';

	$title = stripslashes( (string) $_POST[ 'privacy_policy_title' ] );
	$slug  = stripslashes( (string) $_POST[ 'privacy_policy_slug' ] );

	update_option( 'privacy_policy_title', $title );
	update_option( 'privacy_policy_slug', $slug );

	$post_title = $title;
	$post_content = '<!-- privacy-policy -->';
	$post_status = 'publish';
	$post_author = 1;
	$post_name = $slug;
	$post_type = 'page';

	$post_data = compact( 'post_title', 'post_content', 'post_status',
		              'post_author', 'post_name', 'post_type' );

	$postID = wp_insert_post( $post_data );

	if( !$postID ){
	    echo 'Privacy policy page could not be created';
	} else {
	    echo 'Privacy policy page (ID ' . $postID . ') was created';
	}

	echo '</strong></p></div>';
    } else if( isset( $_POST[ 'info_update' ] ) ){

        echo '<div id="message" class="updated fade"><p><strong>';

	update_option( 'privacy_policy_sitename', stripslashes( (string) $_POST['privacy_policy_sitename' ] ));
	update_option( 'privacy_policy_before_heading', stripslashes( (string) $_POST['privacy_policy_before_heading' ] ));
	update_option( 'privacy_policy_after_heading', stripslashes( (string) $_POST['privacy_policy_after_heading' ] ));
	update_option( 'privacy_policy_before_paragraph', stripslashes( (string) $_POST['privacy_policy_before_paragraph' ] ));
	update_option( 'privacy_policy_after_paragraph', stripslashes( (string) $_POST['privacy_policy_after_paragraph' ] ));
	update_option( 'privacy_policy_contact', stripslashes( (string) $_POST['privacy_policy_contact' ] ));
	update_option( 'privacy_policy_title', stripslashes( (string) $_POST['privacy_policy_title' ] ));
	update_option( 'privacy_policy_slug', stripslashes( (string) $_POST['privacy_policy_slug' ] ));
	update_option( 'privacy_policy_pp_help', (bool) $_POST['privacy_policy_pp_help'] );
	update_option( 'privacy_policy_browser_help', (bool) $_POST['privacy_policy_browser_help'] );
	update_option( 'privacy_policy_credit', (bool) $_POST['privacy_policy_credit'] );

	echo 'Configuration updated!';
	echo '</strong></p></div>';
    }

    ?>

    <div class="wrap">
    <h2>AdSense Privacy Policy <?php echo $privacy_policy_ver; ?></h2>
    <p>The <a href="http://cybec.com/privacy-policy-plugin/">AdSense Privacy 
    Policy Plugin for WordPress</a> automatically generates a privacy policy
    for your blog that is compliant with the AdSense terms and conditions.
    The policy is also general enough to be used even if you're not
    displaying AdSense ads.
    </p>

    <p>To use the plugin, insert the trigger text <strong>&lt;!--&nbsp;privacy-policy&nbsp;--&gt;</strong> into an existing page. The trigger will be
    automatically replaced with a complete privacy policy.</p>

    <p>For your convenience, the plugin can also create a new privacy page
    for you. Simply fill in the title and slug (path) details and press
    the "Create Page" button to create the privacy page. The trigger text
    will be added automatically to the new page.</p>

    <form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
    <input type="hidden" name="info_update" id="info_update" value="true" />

    <fieldset class="options">
    <legend>Details</legend>

    <table width="100%" border="0" cellspacing="0" cellpadding="6">

    <tr valign="top">
      <td align="right" valign="middle"><strong>Site Name</strong></td>
      <td align="left" valign="middle">
         <input name="privacy_policy_sitename" type="text" size="40" 
                value="<?php echo htmlspecialchars( get_option( 'privacy_policy_sitename' ) ); ?>" />
      </td>
    </tr>

    <tr valign="top">
      <td align="right" valign="middle"><strong>Contact</strong></td>
      <td align="left" valign="middle">
         <input name="privacy_policy_contact" type="text" size="40" 
                value="<?php echo htmlspecialchars( get_option( 'privacy_policy_contact' ) ); ?>" />
      </td>
    </tr>

    </table>
    </fieldset>

    <fieldset class="options">
    <legend>Formatting</legend>

    <table width="100%" border="0" cellspacing="0" cellpadding="6">

    <tr valign="top">
      <td align="right" valign="middle"><strong>Heading (before)</strong></td>
      <td align="left" valign="middle">
         <input name="privacy_policy_before_heading" type="text" size="20" 
                value="<?php echo htmlspecialchars( get_option( 'privacy_policy_before_heading' ) ); ?>" />
      </td>

      <td align="right" valign="middle"><strong>Heading (after)</strong></td>
      <td align="left" valign="middle">
         <input name="privacy_policy_after_heading" type="text" size="20" 
                value="<?php echo htmlspecialchars( get_option( 'privacy_policy_after_heading' ) ); ?>" />
      </td>
    </tr>

    <tr valign="top">
      <td align="right" valign="middle"><strong>Paragraph (before)</strong></td>
      <td align="left" valign="middle">
         <input name="privacy_policy_before_paragraph" type="text" size="20" 
                value="<?php echo htmlspecialchars( get_option( 'privacy_policy_before_paragraph' ) ); ?>" />
      </td>

      <td align="right" valign="middle"><strong>Paragraph (after)</strong></td>
      <td align="left" valign="middle">
         <input name="privacy_policy_after_paragraph" type="text" size="20" 
                value="<?php echo htmlspecialchars( get_option( 'privacy_policy_after_paragraph' ) ); ?>" />
      </td>
    </tr>

    </table>

    </fieldset>

    <fieldset class="options">
    <legend>Options</legend>

    <ul>

    <li><label for="privacy_policy_pp_help">
      <input type="checkbox" name="privacy_policy_pp_help"
             id="privacy_policy_pp_help"
             <?php echo ( get_option( 'privacy_policy_pp_help' ) == true ? "checked=\"checked\"" : "" ) ?> />
	     Include link to <a href="http://cybec.com/privacy/privacy-policies/">privacy policy help</a>
    </label></li>

    <li><label for="privacy_policy_browser_help">
      <input type="checkbox" name="privacy_policy_browser_help"
             id="privacy_policy_browser_help"
             <?php echo ( get_option( 'privacy_policy_browser_help' ) == true ? "checked=\"checked\"" : "" ) ?> />
	     Include link to <a href="http://cybec.com/privacy/browser-configuration/">browser configuration help</a>
    </label></li>

    <li><label for="privacy_policy_credit">
      <input type="checkbox" name="privacy_policy_credit"
             id="privacy_policy_credit"
             <?php echo ( get_option( 'privacy_policy_credit' ) == true ? "checked=\"checked\"" : "" ) ?> />
	     Include credit link for the <a href="http://cybec.com/plugins/privacy-policy/">AdSense Privacy Policy Plugin for WordPress</a> (thank you!)
    </label></li>

    </ul>

    </fieldset>

    <div class="submit">
      <input type="submit" name="set_defaults" value="<?php _e('Load Default Options'); ?> &raquo;" />
      <input type="submit" name="info_update" value="<?php _e('Update options' ); ?> &raquo;" />
    </div>

    <fieldset class="options">
    <legend>Page Creation</legend>

    <table width="100%" border="0" cellspacing="0" cellpadding="6">

    <tr valign="top">
      <td align="right" valign="middle"><strong>Page Title</strong></td>
      <td align="left" valign="middle">
         <input name="privacy_policy_title" type="text" size="40" 
                value="<?php echo htmlspecialchars( get_option( 'privacy_policy_title' ) ); ?>" />
      </td>
    </tr>

    <tr valign="top">
      <td align="right" valign="middle"><strong>Page Slug</strong></td>
      <td align="left" valign="middle">
         <input name="privacy_policy_slug" type="text" size="40" 
                value="<?php echo htmlspecialchars( get_option( 'privacy_policy_slug' ) ); ?>" />
      </td>
    </tr>

    </table>

    </fieldset>

    <div class="submit">
      <input type="submit" name="create_page" value="Create Page" />
    </div>

    </form>
    
    </div><?php
}

function privacy_policy_process($content) {

    $tag = "<!-- privacy-policy -->";
	
    // Quickly leave if nothing to replace
    
    if( strpos( $content, $tag ) == false ) return $content;

    // Otherwise generate the privacy policy and sub it in

    return str_replace( $tag, privacy_policy_html(), $content );
}


function privacy_policy_html(){
    $sitename = get_option( 'privacy_policy_sitename' );
    $beginheading = get_option( 'privacy_policy_before_heading' );
    $endheading = get_option( 'privacy_policy_after_heading' );
    $beginpara = get_option( 'privacy_policy_before_paragraph' );
    $endpara = get_option( 'privacy_policy_after_paragraph' );
    $contact = get_option( 'privacy_policy_contact' );

    $link_pp_help = get_option( 'privacy_policy_pp_help' );
    $link_browser_help = get_option( 'privacy_policy_browser_help' );
    $link_credit = get_option( 'privacy_policy_credit' );

    $pp = $beginpara 
	. "<strong>$sitename</strong> takes your privacy seriously. This "
        . 'privacy policy describes what personal information we collect and '
	. 'how we use it.' 

	. ( $link_pp_help ? ' See this <a target="_blank" href="http://cybec.com/what-is-a-privacy-policy/">privacy policy primer</a> to learn more about privacy policies in general.' : '' )


	. $endpara . "\n"

	. $beginheading . 'Routine Information Collection' . $endheading . "\n" 

	. $beginpara 
	. 'All web servers track basic information about their '
	. 'visitors. This information includes, but is not limited to, IP '
	. 'addresses, browser details, timestamps and referring '
	. 'pages. None of this information can personally identify specific '
	. 'visitors to this site. The information is tracked for routine '
	. 'administration and maintenance purposes.' 
	. $endpara . "\n"

	. $beginheading . 'Cookies and Web Beacons' . $endheading . "\n"

	. $beginpara 
	. "Where necessary, $sitename uses cookies to store "
	. 'information about a visitor\'s preferences and history in order '
	. 'to better serve the visitor and/or present the visitor with '
	. 'customized content.' 
	. $endpara . "\n"

	. $beginpara 
	. 'Advertising partners and other third parties may also use '
	. 'cookies, scripts and/or web beacons to track visitors to our site '
	. 'in order to display advertisements and other useful information. '
	. 'Such tracking is done directly by the third parties through their '
	. 'own servers and is subject to their own privacy policies. '
	. $endpara . "\n"
	
        . $beginheading . 'Controlling Your Privacy' . $endheading . "\n"
	
	. $beginpara 
	. 'Note that you can change your browser settings to disable '
	. 'cookies if you have privacy concerns. Disabling cookies for '
	. 'all sites is not recommended as it may interfere with your '
	. 'use of some sites. The best option is to disable or enable '
	. 'cookies on a per-site basis. Consult your browser documentation '
	. 'for instructions on how to block cookies and other tracking '
	. 'mechanisms.'

	. ( $link_browser_help ? ' This list of <a target="_blank" href="http://cybec.com/web-browser-privacy-management/">web browser privacy management</a> links may also be useful.' : '' )

	. $endpara . "\n"
	
	. $beginheading . 'Special Note About Google Advertising' . $endheading . "\n"
	
	. $beginpara
	. 'Any advertisements served by Google, Inc., and affiliated companies may be controlled using cookies. '
	. 'These cookies allow Google to display ads based on your visits to '
	. 'this site and other sites that use Google advertising services. '
	. 'Learn how to <a href="http://www.google.com/privacy_ads.html">opt out of Google\'s cookie usage</a>. '
	. 'As mentioned above, any tracking done by Google through cookies and other '
	. 'mechanisms is subject to Google\'s own privacy policies. '
	. $endpara . "\n"

	. $beginheading . 'Contact Information' . $endheading . "\n"

	. $beginpara
	. 'Concerns or questions about this privacy policy can be '
	. "directed to $contact for further clarification."
	. $endpara . "\n"

	;

    if( $link_credit ){
        $pp .= $beginpara 
	    .  'This privacy policy was generated by the '
	    . '<a target="_blank" href="http://cybec.com/privacy-policy-plugin-for-wordpress/">Privacy'
	    . ' Policy for WordPress</a> plugin.'
	    . $endpara . "\n";
    }


    return $pp;
}

add_filter('the_content', 'privacy_policy_process');
add_action('admin_menu', 'privacy_policy_options_setup');



?>
