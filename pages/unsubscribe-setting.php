<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<script language="javascript" src="<?php echo mail_plugin_url();?>/pages/pages-setting.js"></script>
<div class="wrap">
  <div class="form-wrap">
    <div id="icon-plugins" class="icon32"></div>
    <h2><?php _e(WN_mail_TITLE, 'wp_mail'); ?></h2>
    <h3><?php _e('Unsubscribe link setting', 'wp_mail'); ?></h3>
	<?php
	$wmail_un_option = get_option('wmail_un_option');
	$wmail_un_text = get_option('wmail_un_text');
	$wmail_un_link = get_option('wmail_un_link');
	$wmail_msgdis_3 = get_option('wmail_msgdis_3');
	$wmail_msgdis_4 = get_option('wmail_msgdis_4');
	$wmail_msgdis_5 = get_option('wmail_msgdis_5');
	
	if (@$_POST['wmail_submit']) 
	{
		//	Just security thingy that wordpress offers us
		check_admin_referer('wmail_form_unsubscribe');
		
		$wmail_un_option = stripslashes($_POST['wmail_un_option']);
		$wmail_un_text = stripslashes($_POST['wmail_un_text']);
		$wmail_un_link = stripslashes($_POST['wmail_un_link']);
		$wmail_msgdis_3 = stripslashes($_POST['wmail_msgdis_3']);
		$wmail_msgdis_4 = stripslashes($_POST['wmail_msgdis_4']);	
		$wmail_msgdis_5 = stripslashes($_POST['wmail_msgdis_5']);	
		
		update_option('wmail_un_option', $wmail_un_option );
		update_option('wmail_un_text', $wmail_un_text );
		update_option('wmail_un_link', $wmail_un_link );
		update_option('wmail_msgdis_3', $wmail_msgdis_3 );
		update_option('wmail_msgdis_4', $wmail_msgdis_4 );
		update_option('wmail_msgdis_5', $wmail_msgdis_5 );
?>
		<div class="updated fade">
			<p><strong><?php _e('Details successfully updated.', 'wp_mail'); ?></strong></p>
		</div>
<?php
	}
?>
	<form name="form_wmail" method="post" action="">
	
	<label for="tag-title"><?php _e('Unsubscribe Option', 'wp_mail'); ?></label>
	<select name="wmail_un_option" id="wmail_un_option">
		<option value="Yes" <?php if($wmail_un_option=='Yes') { echo 'selected' ; } ?>><?php _e('Yes, Add an unsubscribe link in email newletter.', 'wp_mail'); ?></option>
		<option value="No" <?php if($wmail_un_option=='No') { echo 'selected' ; } ?>><?php _e('No, Dont want unsubscribe link in email newletter.', 'wp_mail'); ?></option>
	</select>
	<p><?php _e('Please enter your option from the list.', 'wp_mail'); ?></p>
	
	<label for="tag-title"><?php _e('Unsubscribe text', 'wp_mail'); ?></label>
	 <?php wp_editor($wmail_un_text,'wmail_un_text');?>
	<p><?php _e('Please enter your unsubscribe text. ##LINK## is a keyword.', 'wp_mail'); ?></p>
	
	<label for="tag-title"><?php _e('Unsubscribe link', 'wp_mail'); ?></label>
	<input name="wmail_un_link" type="text" size="120" value="<?php echo $wmail_un_link; ?>" />
	<p><?php _e('Please enter your unsubscribe link.', 'wp_mail'); ?></p>
	
	<label for="tag-title"><?php _e('Static message 3', 'wp_mail'); ?></label>
	 <?php wp_editor($wmail_msgdis_3,'wmail_msgdis_3');?>
	<p><?php _e('Static message in unsubscribe page.', 'wp_mail'); ?></p>
	
	<label for="tag-title"><?php _e('Static message 4', 'wp_mail'); ?></label>
	 <?php wp_editor($wmail_msgdis_4,'wmail_msgdis_4');?>
	<p><?php _e('Static message in unsubscribe page, if no email found.', 'wp_mail'); ?></p>
	
	<label for="tag-title"><?php _e('Static message 5', 'wp_mail'); ?></label>
	 <?php wp_editor($wmail_msgdis_5,'wmail_msgdis_5');?>
	<p><?php _e('Static message for unexpected error.', 'wp_mail'); ?></p>
	
	<p style="padding-top:10px;">
		<input type="submit" id="wmail_submit" name="wmail_submit" lang="publish" class="button add-new-h2" value="<?php _e('Update Settings', 'wp_mail'); ?>" />
		<input name="publish" lang="publish" class="button add-new-h2" onclick="_wmail_redirect()" value="<?php _e('Cancel', 'wp_mail'); ?>" type="button" />
		<input name="Help" lang="publish" class="button add-new-h2" onclick="_wmail_help()" value="<?php _e('Help', 'wp_mail'); ?>" type="button" />
	</p>
	<?php wp_nonce_field('wmail_form_unsubscribe'); ?>
	</form>
	</div><br />
</div>