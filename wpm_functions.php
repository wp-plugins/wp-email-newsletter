<?php
/**
 *	Plugin Name: Wordpress Email Newsletter
 *	Plugin URI: http://about.me/tushalbhanderi
 *	Description: Wordpress Simpale Email Newsletter For User Signup On website.admin simple manage subscribe use and send mail for site update
 *	Version: 1.0.1
 *	Author:  Bhanderi Tushal
 *	Author URI: http://about.me/tushalbhanderi
 *	License: GPLv2 or later
 *	Text Domain: wp_mail
 */
 global $wpdb;
define('WMAIL_URL',plugin_dir_url( __FILE__ ));
define('WMAIL_PATH',plugin_dir_path( __FILE__ ));
define("WN_mail_TITLE", "Wordpress Newsletter");
define("WN_mail_TABLE", $wpdb->prefix . "wmail_newsletter");
define("WN_mail_TABLE_SUB", $wpdb->prefix . "wmail_newsletter_list"); //Use For Get List form table
register_activation_hook(__FILE__, 'wmail_mail_activation');
function mail_plugin_url( $path = '' ) {
    return plugins_url( $path, plugin_basename( __FILE__ ) );
}
add_action('admin_print_scripts', 'wmail_do_jslibs' );
add_action('admin_print_styles', 'wmail_do_css' );
function wmail_do_css()
{
    wp_enqueue_style('thickbox');
}
function wmail_do_jslibs()
{
    wp_enqueue_script('editor');
    wp_enqueue_script('thickbox');
    wp_enqueue_script('tiny_mce');
    wp_enqueue_script('media-upload');
    wp_enqueue_script('editor-functions');
    add_action( 'admin_head', 'wp_tiny_mce' );
}

// Query String Manage
$QueryStringStart='?';
if( count($_GET)==0 ){
	$QueryStringStart='?';
}else{
	$QueryStringStart="&";	
}

/**
 *	Link stylesheet and javascript for Plugins
 */
function wmail_attech_scripts(){
	global $pageName;
	if(isset($_GET['page']) && $_GET['page']==$pageName): // Checking for IS page is 'wmail'
		wp_enqueue_script('jquery');
		wp_enqueue_style('wmail_style', WMAIL_URL.'css/wmail_style.css',array(), '1.0','screen');
	endif;
}
add_action( 'init', 'wmail_attech_scripts' );
/**
 *	Set up menu in admin panal in settings
 */
if (!session_id()) { session_start(); }
function wmail_mail_activation() 
{
    global $wpdb, $wp_version;
    $admin_email = get_option('admin_email');
    add_option('wmail_title', "Email Newsletter");
    add_option('wmail_bcc', "0");
    add_option('wmail_widget_cap', "Sign up for our email newsletters");
    add_option('wmail_widget_txt_cap', "Enter email");
    add_option('wmail_widget_but_cap', "Submit");
    add_option('wmail_on_homepage', "YES");
    add_option('wmail_on_posts', "YES");
    add_option('wmail_on_pages', "YES");
    add_option('wmail_on_search', "NO");
    add_option('wmail_on_archives', "NO");
    add_option('my_plugin_do_activation_redirect', true);  
    add_option('wmail_from_name', "noreply");
    add_option('wmail_from_email', "noreply@mysite.com");
    
    add_option('wmail_admin_email_option', "YES");
    add_option('wmail_admin_email_address', $admin_email);
    add_option('wmail_admin_email_subject', "New email subscription");
    add_option('wmail_admin_email_content', "Hi Admin, We have received a request to subscribe new email address (##USEREMAIL##) to receive emails from our website. Thank you.");
    add_option('wmail_user_email_option', "YES");
    add_option('wmail_user_email_subject', "Confirm subscription");
    add_option('wmail_user_email_content', "Hi User, We have received a request to subscribe this email address to receive newsletter from our website. Thank you.");
    add_option('wmail_email_type', "HTML");
    
    if(strtoupper($wpdb->get_var("show tables like '". WN_mail_TABLE . "'")) != strtoupper(WN_mail_TABLE))  
    {
        $wpdb->query("
            CREATE TABLE IF NOT EXISTS `". WN_mail_TABLE . "` (
              `wmail_id` int(11) NOT NULL auto_increment,
              `wmail_subject` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ,
              `wmail_content` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ,
              `wmail_status` char(3) NOT NULL default 'YES',
              `wmail_date` datetime NOT NULL default '0000-00-00 00:00:00',
              PRIMARY KEY  (`wmail_id`) )
            ");
        
        $sql = "insert into ".WN_mail_TABLE.""
                    . " set `wmail_subject` = '" . 'Sample Subject'
                    . "', `wmail_content` = '" . 'This is sample mail content, Can add HTML content here.'
                    . "', `wmail_status` = '" . 'YES'
                    . "', `wmail_date` = CURDATE()";
                    
        $wpdb->get_results($sql);
        $Sample = '<strong style="color: #990000"> Email newsletter</strong><p>Email newsletter plugin have option to send HTML Mails/Newsletters to registered user,'; 
        $Sample .= ' Comment author, Subscriber and Users who contacted you. Sending email is much cheaper than most other forms of communication. Email marketing has proven very';
        $Sample .= ' successful for those who do it right. This plugin is very useful those who need to send Newsletters to users who subscribed to your blogs.</p>';
        $Sample .= ' <strong style="color: #990000">Advantage of this plugin</strong><ol>';
        $Sample .= ' <li>No coding knowledge required to setup this plugin.</li>';
        $Sample .= ' <li>Very easy installation and setup.</li><li>Option to send email newsletter to registered user.</li>';
        $Sample .= ' <li>Option to setup email subscription box and option to send email newsletter to subscriber.</li>';
        $Sample .= ' <li>Automatic welcome email to new subscriber.</li><li>Admin email notification for every new subscriber.</li>';
        $Sample .= ' </ol><strong style="color: #990000"></strong><br>.';
        $sql = "insert into ".WN_mail_TABLE.""
                    . " set `wmail_subject` = '" . 'Sample HTML Mail'
                    . "', `wmail_content` = '" . $Sample
                    . "', `wmail_status` = '" . 'YES'
                    . "', `wmail_date` = CURDATE()";
                   
        $wpdb->get_results($sql);
    }
    if(strtoupper($wpdb->get_var("show tables like '". WN_mail_TABLE_SUB . "'")) != strtoupper(WN_mail_TABLE_SUB))  
    {
        $wpdb->query("
            CREATE TABLE `". WN_mail_TABLE_SUB . "` (
                `wmail_id_sub` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
                `wmail_name_sub` VARCHAR( 250 ) NOT NULL ,
                `wmail_email_sub` VARCHAR( 250 ) NOT NULL ,
                `wmail_status_sub` VARCHAR( 3 ) NOT NULL ,
                `wmail_date_sub` DATE NOT NULL )
            ");
    }
    $unsubscribelink = mail_plugin_url."/unsubscribe/unsubscribe.php?rand=##rand##&reff=##reff##&user=##user##";
	
    add_option('wmail_un_option', "Yes");
    add_option('wmail_un_text', "If you do not want to receive any more newsletters, Please <a href='##LINK##'>click here</a>");
    add_option('wmail_un_link', $unsubscribelink);
    
    $wmail_msgdis_1 = '<html><head><title>Email Newsletter</title></head><body style="background:#F2F2F2;font-family:Verdana, Arial, Helvetica, sans-serif;padding-top:65px;text-align:center;"><div style="background:#FFF;border:1px solid #ddd;border-radius:6px;max-width:580px;margin:0 auto;padding:34px 0 24px;width:580px"><div class="title"><h2>Thank You</h2><p>You have been successfully subscribed to our newsletter.</p></div></div></body></html>';
    $wmail_msgdis_3 = '<html><head><title>Email Newsletter</title></head><body style="background:#F2F2F2;font-family:Verdana, Arial, Helvetica, sans-serif;padding-top:65px;text-align:center;"><div style="background:#FFF;border:1px solid #ddd;border-radius:6px;max-width:580px;margin:0 auto;padding:34px 0 24px;width:580px"><div class="title"><h2>Thank You</h2><p>You have been successfully unsubscribed. You will no longer hear from us.</p></div></div></body></html>';
    
    add_option('wmail_opt_subject', "Please confirm subscription (Email Newsletter Test)");
    add_option('wmail_opt_content', "
    			<div style=\"width:100%;border:1px solid #222;border-radius:5px;\">
					<div  style=\"background-color:#222222;padding:10px;display: inline-flex;width: 100%;\">				
						<h1 style=\"color: #fff;padding-left:60px;\">Newsletter Sign UP Request \"</h1>					
					</div>
					     Thank You For Connecting With Us.<br> A newsletter subscription request for this email address was received. Thanks.					
			</div>
					<div style=\"background-color:#222222;padding:10px;\">
						<p style=\"margin:0px;font-size:16px;color:#fff;text-align:right;\"></p>
					</div>
					</div>");
    add_option('wmail_msgdis_1', $wmail_msgdis_1);
    add_option('wmail_msgdis_2', "Oops.. This subscription cant be completed, sorry. The email address is blocked or already subscribed. Thank you.");
    add_option('wmail_msgdis_3', $wmail_msgdis_3);
    add_option('wmail_msgdis_4', "Oops.. We are getting some technical error. Please try again or contact admin.");
    add_option('wmail_msgdis_5', "Oops.. Unexpected error occurred. Please try again.");
    add_option('wmail_msgdis_6', "Oops.. Unexpected error occurred. Please try again.");
}

add_action('admin_menu','wmail_page_setup');
function wmail_page_setup(){
	global $wmailPageName;
	 
  add_menu_page( __( 'Email Newsletter', 'wp_mail' ), __( 'Email Newsletter', 'wp_mail' ), 'admin_dashboard', 'wp_mail', 'wmail_admin_option' );
    add_submenu_page('wp_mail', 'General Information', __( 'General Information', 'wp_mail' ), 'administrator', 'general-information', 'wmail_add_adminmenu_email_welcome');
    add_submenu_page('wp_mail', 'View subscribed user', __( 'View Subscriber', 'wp_mail' ), 'administrator', 'view-subscriber', 'wmail_add_adminmenu_subscriber');
    add_submenu_page('wp_mail', 'Compose Mail', __( 'Compose Mail', 'wp_mail' ), 'administrator', 'compose-email', 'wmail_add_adminmenu_email_compose');
    add_submenu_page('wp_mail', 'Send Mail to Subscribed Users', __( 'Mail to Subscriber', 'wp_mail' ), 'administrator', 'sendmail-subscriber', 'wmail_add_adminmenu_email_to_subscriber');
  
   add_submenu_page('wp_mail', 'Widget setting', __( 'Setup Widget', 'wp_mail' ), 'administrator', 'widget-setting', 'wmail_add_adminmenu_widget_option');
   add_submenu_page('wp_mail', 'Email setting', __( 'Setup Email', 'wp_mail' ), 'administrator', 'email-setting', 'wmail_add_adminmenu_email_option');
   add_submenu_page('wp_mail', 'Unsubscribe link option', __( 'Setup Unsubscribe', 'wp_mail' ), 'administrator', 'unsubscribe-setting', 'wmail_add_unsubscribe_option');
 }
add_action("plugins_loaded", "wmail_mail_widget_init");
add_action('init', 'wmail_mail_widget_init');

function wmail_add_adminmenu_email_welcome()
{
    global $wpdb;
    include_once('pages/welcome-page.php');
} 
function wmail_add_adminmenu_subscriber() 
{
    global $wpdb;
    $current_page = isset($_GET['ac']) ? $_GET['ac'] : '';
    switch($current_page)
    {
        case 'add':
            include('subscriber/view-subscriber-add.php');
            break;
        case 'edit':
            include('subscriber/view-subscriber-edit.php');
            break;
        default:
            include('subscriber/view-subscriber-show.php');
            break;
    }
}
function wmail_mail_widget_init()
{
    if(function_exists('wp_register_sidebar_widget')) 
    {
        wp_register_sidebar_widget( __('Email Newsletter', 'wp_mail'), __('Email Newsletter', 'wp_mail'), 'wmail_mail_widget');
    }
    
    if(function_exists('wp_register_widget_control')) 
    {
        wp_register_widget_control( __('Email Newsletter', 'wp_mail') , array( __('Email Newsletter', 'wp_mail') , 'widgets'), 'wmail_mail_control');
    } 
}
function wmail_mail_control() 
{
    _e('Email Newsletter', 'wp_mail');
}
function wmail_add_adminmenu_widget_option() 
{
    global $wpdb;
    include('pages/widget-setting.php');
}
function wmail_mail_show() 
{
    global $wpdb, $wp_version;
    include_once("widget/widget.php");
}
function wmail_mail_widget($args) 
{
    if(is_home() && get_option('wmail_on_homepage') == 'YES') { $display = "show";    }
    if(is_single() && get_option('wmail_on_posts') == 'YES') {    $display = "show"; }
    if(is_page() && get_option('wmail_on_pages') == 'YES') { $display = "show"; }
    if(is_archive() && get_option('wmail_on_search') == 'YES') { $display = "show"; }
    if(is_search() && get_option('wmail_on_archives') == 'YES') { $display = "show"; }
    if($display == "show")
    {
        extract($args);
        echo $before_widget;
        echo $before_title;
        echo get_option('wmail_title');
        echo $after_title;
        wmail_mail_show();
        echo $after_widget;
    }
}
function wmail_add_adminmenu_email_to_subscriber() 
{
    global $wpdb;
    include('sendemail/sendmail-subscriber.php');
}

function wmail_send_mail($recipients = array(), $wmail_id = 0, $source = "") 
{
    global $wpdb;
    global $user_login , $user_email;
    
    $arrSubscriber = array();
    $num_sent = 0;
    $sender_name = "";
    $sender_name = "";
    $wmail_email_type = "";
    $wmail_un_text = "";
    $wmail_un_link = "";
    $wmail_un_option = "NO";
    $wmail_errors = array();
    $wmail_error_found =  FALSE;
    $sender_name = get_option('wail_from_name');
    $sender_email = get_option('wmail_from_email');
    $wmail_email_type = get_option('wmail_email_type');
    $wmail_un_option = get_option('wmail_un_option');
    
    if($wmail_email_type == "")
    {
        $wmail_email_type = "HTML";
    }
    
    // Check emails from address and from name.
    if(trim($sender_name) == "" || trim($sender_email) == '')
    {
        get_currentuserinfo();
        $sender_name = $user_login;
        $sender_email = $user_email;
    }
    
    // Check recipients count.
    if(empty($recipients))
    {
        return $num_sent; 
    }
    
    // Check email content valid or not.
    if($wmail_id == 0)
    {
        return false;
    }

    $headers  = "From: \"$sender_name\" <$sender_email>\n";
    $headers .= "Return-Path: <" . $sender_email . ">\n";
    $headers .= "Reply-To: \"" . $sender_name . "\" <" . $sender_email . ">\n";
    $headers .= "X-Mailer: PHP" . phpversion() . "\n";
    // Load email subject and email newsletter details.
    $arrEmails = wmail_get_emails($wmail_id);
    if(count($arrEmails) > 0)
    {
        $form = array(
            'wmail_subject' => $arrEmails[0]['wmail_subject'],
            'wmail_content' => $arrEmails[0]['wmail_content']
        );
        $subject = $form['wmail_subject'];
        $message = $form['wmail_content'];
    }
    if($subject == "")
    {
        return false;
    }
    // Check unsubscribe option
    if( strtoupper($wmail_un_option) == "YES" )
    {
        $wmail_un_text = get_option('wmail_un_text');
        $wmail_un_link = get_option('wmail_un_link');
    }

    if( strtoupper($wmail_email_type) == "HTML" )  
    {
        $headers .= "MIME-Version: 1.0\n";
        $headers .= "Content-Type: " . get_bloginfo('html_type') . "; charset=\"". get_bloginfo('charset') . "\"\n";
        $headers .= "Content-type: text/html\r\n"; 
        $mailtext = "<html><head><title>" . $subject . "</title></head><body>" . $message . "</body></html>";
    } 
    else 
    {
        $headers .= "MIME-Version: 1.0\n";
        $headers .= "Content-Type: text/plain; charset=\"". get_bloginfo('charset') . "\"\n";
        $message = preg_replace('|&[^a][^m][^p].{0,3};|', '', $message);
        $message = preg_replace('|&amp;|', '&', $message);
        $mailtext = wordwrap(strip_tags($message), 80, "\n");
    }
    $mailtext = str_replace("\r\n", "<br />", $mailtext);
    if(count($recipients) > 0)
    {
        $emailaddress = "";
        $emaildbid = "";
        
        for ( $i = 0; $i < count($recipients); $i++) 
        {
            if($source == "subscriber")
            {
                $recipientsvalue = explode("<||>", $recipients[$i]);
                $recipientsvaluecount = count($recipientsvalue);
                if($recipientsvaluecount == 2)
                {
                    $emailaddress = $recipientsvalue[0];
                    $emaildbid = $recipientsvalue[1];
                }
                else
                {
                    $wmail_errors[] = __($emailaddress, 'wp_mail');
                    $wmail_error_found = TRUE;
                }
            }
            else
            {
                $emailaddress = $recipients[$i];
                $emaildbid = "";
            }

            if ( !wmail_valid_email($emailaddress) ) 
            { 
                $wmail_errors[] = __($emailaddress, 'wp_mail');
                $wmail_error_found = TRUE;
            }
            else
            {
                $unsubscribe = "";
                if($source == "subscriber")
                {
                    if( strtoupper($wmail_un_option) == "YES" )
                    {
                        $unsubscribemyguid = wmail_myguid();
                        if($emaildbid <> "0" && $emaildbid <> "")
                        {
                            $unsubscriberand = str_replace("##rand##", $emaildbid, $wmail_un_link);
                            $unsubscribeuser = str_replace("##user##", $emailaddress, $unsubscriberand);
                            $unsubscribelink = str_replace("##reff##", $unsubscribemyguid, $unsubscribeuser);
                            $unsubscribe = str_replace('##LINK##', $unsubscribelink, $wmail_un_text);
                        }
                        else
                        {
                            $unsubscribe = "";
                        }
                    }
                    else
                    {
                        $unsubscribe = "";
                    }
                    
                    if ( strtoupper($wmail_email_type) == "HTML" )
                    {
                        $unsubscribe = '<br>' . $unsubscribe;
                    }
                    else
                    {
                        $unsubscribe = '\n' . $unsubscribe;
                    }
                }

                @wp_mail($emailaddress, $subject, $mailtext . $unsubscribe, $headers);
                $num_sent = $num_sent + 1;
            }
        }
    }
    if($num_sent > 0) 
    { 
        _e('<div class="updated fade"><strong><p>Email has been sent successfully.</p></strong></div>', 'wp_mail');
    }

    if ($wmail_error_found == TRUE && isset($wmail_errors[0]) == TRUE)
    {
        $wmail_value = "";
        $value = "";
        $j = 0;
        foreach($wmail_errors as $value) 
        {
            if ($j % 4 == 0 && $j <> 0)
            {
                $wmail_value = $wmail_value . "<br>";
            }
            $wmail_value = $wmail_value . $value . ", ";

            $j = $j + 1;
        }?>
	<div class="error fade"><p><strong><?php _e('Some invalid email address found.', 'wp_mail');?></strong><br /><?php echo $wmail_value;?></p></div>
<?php }
    return $num_sent;
}
function wmail_get_emails( $wmail_id ) 
{
    global $wpdb;
    $arrData = array();
    $sSql = "select wmail_subject, wmail_content from " . WN_wmail_TABLE . " where";
    $sSql = $sSql . " wmail_id = " . trim($wmail_id);
    $sSql = $sSql . " order by wmail_id limit 0, 1";
    $data = $wpdb->get_results($sSql);
    if ( ! empty($data) )
    {
        $data = $data[0];
        $arrData[0]["wmail_subject"] = stripslashes($data->wmail_subject);
        $arrData[0]["wmail_content"] = stripslashes($data->wmail_content);
    }
    else
    {
        $arrData[0]["wmail_subject"] = "NA";
        $arrData[0]["wmail_content"] = "NA";
    }
    return $arrData;
}
function wmail_valid_email($email) 
{
   $regex = '/^[A-z0-9][\w.+-]*@[A-z0-9][\w\-\.]+\.[A-z0-9]{2,6}$/';
   return (preg_match($regex, $email));
}
function wmail_myguid() 
{
    $random_id_length = 60; 
    $rnd_id = crypt(uniqid(rand(),1)); 
    $rnd_id = strip_tags(stripslashes($rnd_id)); 
    $rnd_id = str_replace(".","",$rnd_id); 
    $rnd_id = strrev(str_replace("/","",$rnd_id)); 
    $rnd_id = strrev(str_replace("$","",$rnd_id)); 
    $rnd_id = strrev(str_replace("#","",$rnd_id)); 
    $rnd_id = strrev(str_replace("@","",$rnd_id)); 
    $rnd_id = substr($rnd_id,0,$random_id_length); 
    $rnd_id = strtolower($rnd_id);
    return $rnd_id;
}
function wmail_add_adminmenu_email_compose() 
{
    global $wpdb;
    $current_page = isset($_GET['ac']) ? $_GET['ac'] : '';
    switch($current_page)
    {
        case 'add':
            include('compose/compose-email-add.php');
            break;
        case 'edit':
            include('compose/compose-email-edit.php');
            break;
        default:
            include('compose/compose-email-show.php');
            break;
    }
}
function wmail_add_adminmenu_email_option() 
{
    global $wpdb;
    include('pages/email-setting.php');
}
function wmail_add_unsubscribe_option() 
{
    global $wpdb;
    include('pages/unsubscribe-setting.php');
}?>