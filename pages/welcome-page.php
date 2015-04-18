<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<link rel="stylesheet" type="text/css" href="<?php echo mail_plugin_url();?>/inc/admin-css.css" />
<div class="wrap">
  <div id="icon-plugins" class="icon32"></div>
  <h2><?php _e(WN_mail_TITLE, 'wmail_main'); ?></h2>
  <h3></h3>
  <div class="emailn-left">
    <div class="emailn-left-widgets">
      <div class="emailn-widgetsleft">
        <h3><?php _e('Welcome to Email Newsletter Plugin', 'wp_mail'); ?></h3>

			<table border="0">
        <tr>
        
      </tr>
      <tr>
        <td valign="top">
	   <p>            <?php _e( '<b>This Plugin Created For Email Newslatter for website. User Subscribe for newsletterwith His/Her Register Email Address and admin send email when New Updation arriving .And also Informe about website Activity.<br/></b>', 'wcp-plugin'); ?>


          </p></td>
      </tr>
	   <tr class="faq">
			<td class="faqs" colspan="2"><h3><?php _e( 'Frequently Asked Questions', 'wcp-plugin' ); ?></h3></td>
	   </tr>
	    <tr>
        <td valign="top"><p>
<p><b> Q: How can I display Email widget on my website?</b><br>

A: Add Email newsletter widget on <a href="<?php echo get_admin_url(); ?>widgets.php">your widget </a> area.(Appearance >> Widgets).add on widget where you want to display.</p>

<p><b>Q: How can I view subscribe list?</b>
<br>
A: On admin panel has <a href=" <?php echo get_admin_url(); ?>admin.php?page=view-subscriber">View Subscriber </a>tab,on there you can view all subscriber list and also change that user status and also9 you can remove from there.</p>
<p><b>Q: How can i send email to subscriber user ?</b>
<br>
A: You can send mail from Send <a href="<?php echo get_admin_url(); ?>admin.php?page=sendmail-subscriber"> mail to subscribed </a> tab.on here you can send mail to All user OR selected user.</p>


          </p></td>
      </tr>
	 
      <tr>
			<td width="33%"><h3><?php _e( 'PayPal Donation', 'wcp-plugin' ); ?></h3></td>
			<td width="33%"><h3><?php _e( 'Reviews', 'wcp-plugin' ); ?></h3></td>
			</tr>
			<tr>
			<td valign="top" width="33%" style="text-align: center;">
				<p><?php _e( 'Please donate to the development<br />of Custom Post Field:', 'wcp-plugin'); ?>
				
				<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
				<input type="hidden" name="cmd" value="_donations">
				<input type="hidden" name="business" value="btushal304@gmail.com">
				<input type="hidden" name="lc" value="US">
				<input type="hidden" name="item_name" value="Email Newslatter">
				<input type="hidden" name="no_note" value="0">
				<input type="hidden" name="currency_code" value="USD">
				<input type="hidden" name="bn" value="PP-DonationsBF:btn_donateCC_LG.gif:NonHostedGuest">
				<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
				<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
				</form>


				</p>
			</td>
			<td valign="top" width="33%" style="text-align: center;">
				<p><b><?php _e( 'Please Give Review For <br />This Plugins:', 'wcp-plugin'); ?></b></p>
				
				<a href="https://wordpress.org/support/view/plugin-reviews/wp-email-newsletter"><button class="reviews">Review</button></a>
			</td>
			</tr>
			<tr>
			
			</tr>
			<tr>
			
			</tr>
			
    </table>
        
      </div>
    </div>
  </div>
  
    