<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<script language="javascript" src="<?php echo mail_plugin_url();?>/pages/pages-setting.js"></script>
<div class="wrap">
  <div class="form-wrap">
    <div id="icon-plugins" class="icon32"></div>
    <h2><?php _e(WN_mail_TITLE, 'wp_mail'); ?></h2>
    <h3><?php _e('Email setting', 'wp_mail'); ?></h3>
	<?php
	$wmail_from_name = get_option('wmail_from_name');
	$wmail_from_email = get_option('wmail_from_email');
	
	$wmail_admin_email_option = get_option('wmail_admin_email_option');
	$wmail_admin_email_address = get_option('wmail_admin_email_address');
	$wmail_admin_email_content = get_option('wmail_admin_email_content');
	$wmail_user_email_option = get_option('wmail_user_email_option');
	$wmail_user_email_content = get_option('wmail_user_email_content');
	$wmail_email_type = get_option('wmail_email_type');
	
	$wmail_admin_email_subject = get_option('wmail_admin_email_subject');
	$wmail_user_email_subject = get_option('wmail_user_email_subject');
	
	if (@$_POST['wmail_submit']) 
	{
		//	Just security thingy that wordpress offers us
		check_admin_referer('wmail_form_email');
		
		$wmail_from_name = stripslashes($_POST['wmail_from_name']);
		$wmail_from_email = stripslashes($_POST['wmail_from_email']);
		
		$wmail_admin_email_option = stripslashes($_POST['wmail_admin_email_option']);
		$wmail_admin_email_address = stripslashes($_POST['wmail_admin_email_address']);
		$wmail_admin_email_content = stripslashes($_POST['wmail_admin_email_content']);
		$wmail_user_email_option = stripslashes($_POST['wmail_user_email_option']);
		$wmail_user_email_content = stripslashes($_POST['wmail_user_email_content']);
		$wmail_email_type = stripslashes($_POST['wmail_email_type']);
		
		$wmail_admin_email_subject = stripslashes($_POST['wmail_admin_email_subject']);
		$wmail_user_email_subject = stripslashes($_POST['wmail_user_email_subject']);
		
		update_option('wmail_from_name', $wmail_from_name );
		update_option('wmail_from_email', $wmail_from_email );
		
		update_option('wmail_admin_email_option', $wmail_admin_email_option );
		update_option('wmail_admin_email_address', $wmail_admin_email_address );
		update_option('wmail_admin_email_content', $wmail_admin_email_content );
		update_option('wmail_user_email_option', $wmail_user_email_option );
		update_option('wmail_user_email_content', $wmail_user_email_content );
		update_option('wmail_email_type', $wmail_email_type );
		
		update_option('wmail_admin_email_subject', $wmail_admin_email_subject );
		update_option('wmail_user_email_subject', $wmail_user_email_subject );
		
?>
		<div class="updated fade">
			<p><strong><?php _e('Details successfully updated.', 'wp_mail'); ?></strong></p>
		</div>
<?php
	}
	?>
	<form name="wmail_form" method="post" action="" onsubmit="return _email_setting()" >
	<label for="tag-title"><?php _e('From email name', 'wp_mail'); ?></label>
	<input name="wmail_from_name" id="wmail_from_name" type="text" value="<?php echo $wmail_from_name; ?>" maxlength="150" size="50" />
	<p><?php _e('Please enter your from email name.', 'wp_mail'); ?></p>
	
	<label for="tag-title"><?php _e('From email address', 'wp_mail'); ?></label>
	<input name="wmail_from_email" id="wmail_from_email" type="text" value="<?php echo $wmail_from_email; ?>" maxlength="150" size="50" />
	<p><?php _e('Please enter your from email address.', 'wp_mail'); ?></p>
	
	<label for="tag-title"><?php _e('Send auto email to admin', 'wp_mail'); ?></label>
	<select name="wmail_admin_email_option" id="wmail_admin_email_option">
		<option value=''><?php _e('Select', 'wp_mail'); ?></option>
		<option value='YES' <?php if($wmail_admin_email_option == 'YES') { echo 'selected' ; } ?>>Yes</option>
		<option value='NO' <?php if($wmail_admin_email_option == 'NO') { echo 'selected' ; } ?>>No</option>
	</select>
	<p><?php _e('Send email to admin when new user subscribed.', 'wp_mail'); ?></p>
	
	<label for="tag-title"><?php _e('Admin email address', 'wp_mail'); ?></label>
	<input name="wmail_admin_email_address" id="wmail_admin_email_address" type="text" value="<?php echo $wmail_admin_email_address; ?>" maxlength="150" size="50" />
	<p><?php _e('Please enter admin email address to received email.', 'wp_mail'); ?></p>
	
	<label for="tag-title"><?php _e('Admin email subject', 'wp_mail'); ?></label>
	<input name="wmail_admin_email_subject" id="wmail_admin_email_subject" type="text" value="<?php echo $wmail_admin_email_subject; ?>" maxlength="150" size="50" />
	<p><?php _e('Please enter admin email subject.', 'wp_mail'); ?></p>
	
	<label for="tag-title"><?php _e('Admin email content', 'wp_mail'); ?></label>
	<textarea name="wmail_admin_email_content" id="wmail_admin_email_content" cols="100" rows="6"><?php echo esc_html(stripslashes($wmail_admin_email_content)); ?></textarea>
	<p><?php _e('Please enter admin email content. (Keyword: ##USEREMAIL##)', 'wp_mail'); ?></p>
	
	<label for="tag-title"><?php _e('Send auto email to subscriber', 'wp_mail'); ?></label>
	<select name="wmail_user_email_option" id="wmail_user_email_option">
		<option value=''><?php _e('Select', 'wp_mail'); ?></option>
		<option value='YES' <?php if($wmail_user_email_option == 'YES') { echo 'selected' ; } ?>>Yes</option>
		<option value='NO' <?php if($wmail_user_email_option == 'NO') { echo 'selected' ; } ?>>No</option>
	</select>
	<p><?php _e('Send welcome email to subscriber.', 'wp_mail'); ?></p>
	
	<label for="tag-title"><?php _e('Subscriber email subject', 'wp_mail'); ?></label>
	<input name="wmail_user_email_subject" id="wmail_user_email_subject" type="text" value="<?php echo $wmail_user_email_subject; ?>" maxlength="150" size="50" />
	<p><?php _e('Please enter Subscriber email subject.', 'wp_mail'); ?></p>
	
	<label for="tag-title"><?php _e('Subscriber email content', 'wp_mail'); ?></label>
	<textarea name="wmail_user_email_content" id="wmail_user_email_content" cols="100" rows="6"><?php echo esc_html(stripslashes($wmail_user_email_content)); ?></textarea>
	<p><?php _e('Please enter subscriber welcome email content.', 'wp_mail'); ?></p>
	
	<label for="tag-title"><?php _e('Email type', 'wp_mail'); ?></label>
	<select name="wmail_email_type" id="wmail_email_type">
		<option value='HTML' <?php if($wmail_email_type == 'HTML') { echo 'selected' ; } ?>>HTML Email</option>
		<option value='PLAINTEXT' <?php if($wmail_email_type == 'PLAINTEXT') { echo 'selected' ; } ?>>Plain Text</option>
	</select>
	<p><?php _e('Please enter subscriber welcome email content.', 'wp_mail'); ?></p>
	
	<p style="padding-top:10px;">
		<input type="submit" id="wmail_submit" name="wmail_submit" lang="publish" class="button add-new-h2" value="<?php _e('Update Settings', 'wp_mail'); ?>" />
		<input name="publish" lang="publish" class="button add-new-h2" onclick="_wmail_redirect()" value="<?php _e('Cancel', 'wp_mail'); ?>" type="button" />
		<input name="Help" lang="publish" class="button add-new-h2" onclick="_wmail_help()" value="<?php _e('Help', 'wp_mail'); ?>" type="button" />
	</p>
	<?php wp_nonce_field('wmail_form_email'); ?>
	</form>
	</div><br />
</div>