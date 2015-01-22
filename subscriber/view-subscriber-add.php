<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<div class="wrap">
<?php
$wmail_errors = array();
$wmail_success = '';
$wmail_error_found = FALSE;

// Preset the form fields
$form = array(
	'wmail_email_sub' => ''
);

// Form submitted, check the data
if (isset($_POST['wmail_form_submit']) && $_POST['wmail_form_submit'] == 'yes')
{
	//	Just security thingy that wordpress offers us
	check_admin_referer('wmail_form_importemails');
	
	$form['importemails'] = isset($_POST['importemails']) ? $_POST['importemails'] : '';
	$form['importemails_status'] = isset($_POST['importemails_status']) ? $_POST['importemails_status'] : 'CON';
	if ($form['importemails'] == '')
	{
		$wmail_errors[] = __('Please enter email address.', 'wp_mail');
		$wmail_error_found = TRUE;
	}

	//	No errors found, we can add this Group to the table
	if ($wmail_error_found == FALSE)
	{
		$ArrayEmail = explode(',', $form['importemails']);
		$Inserted = 0;
		$Duplicate = 0;
		$CurrentDate = date('Y-m-d G:i:s'); 
		for ($i = 0; $i < count($ArrayEmail); $i++)
		{
			$cSql = "select * from ".WN_mail_TABLE_SUB." where wmail_email_sub='" . trim($ArrayEmail[$i]). "'";
			$data = $wpdb->get_results($cSql);
			if ( empty($data) ) 
			{
				$sql = $wpdb->prepare(
					"INSERT INTO `".WN_mail_TABLE_SUB."`
					(`wmail_name_sub`,`wmail_email_sub`, `wmail_status_sub`, `wmail_date_sub`)
					VALUES(%s, %s, %s, %s)",
					array('No Name', $ArrayEmail[$i], $form['importemails_status'], $CurrentDate)
				);
				$wpdb->query($sql);
				$Inserted = $Inserted + 1;
			}
			else
			{
				$Duplicate = $Duplicate + 1;
			}
		}
		$wmail_success[] = __($Inserted . ' Email(s) was successfully imported.', 'wp_mail');
		$wmail_success[] = __($Duplicate . ' Email(s) are already in our database.', 'wp_mail');
		
		// Reset the form fields
		$form = array(
			'wmail_email_sub' => ''
		);
	}
}

if ($wmail_error_found == TRUE && isset($wmail_errors[0]) == TRUE)
{
	?>
	<div class="error fade">
		<p><strong><?php echo $wmail_errors[0]; ?></strong></p>
	</div>
	<?php
}
if ($wmail_error_found == FALSE && isset($wmail_success[0]) == TRUE)
{
	?>
	  <div class="updated fade">
		<p>
		<strong>
		<?php echo $wmail_success[0]; ?> <br />
		<?php echo $wmail_success[1]; ?> <br />
		<a href="<?php echo get_option('siteurl'); ?>/wp-admin/admin.php?page=view-subscriber"><?php _e('Click here', 'wp_mail'); ?></a> <?php _e(' to view the details', 'wp_mail'); ?></strong>
		</p>
	  </div>
	  <?php
	}
?>
<script language="javaScript" src="<?php echo mail_plugin_url();?>/subscriber/subscriber-setting.js"></script>
<div class="form-wrap">
	<div id="icon-plugins" class="icon32"></div>
	<h2><?php _e(WN_mail_TITLE, 'wp_mail'); ?></h2>
	<form name="form_importemails" method="post" action="#" onsubmit="return _wmail_import()"  >
      <h3><?php _e('Add email/Import email', 'wp_mail'); ?></h3>
      
	  <label for="tag-image"><?php _e('Enter email subject.', 'wp_mail'); ?></label>
      <textarea name="importemails" cols="120" rows="8"></textarea>
      <p><?php _e('Enter the email address with comma separated (No comma at the end).', 'wp_mail'); ?></p>
	  
	  <label for="tag-display-status"><?php _e('Status', 'wp_mail'); ?></label>
      <select name="importemails_status" id="importemails_status">
		<option value='PEN'>Not confirmed</option>
		<option value='CON' selected="selected">Confirmed</option>
		<option value='UNS'>Unsubscribed</option>
      </select>
      <p><?php _e('Unsubscribed, Not confirmed emails not display in send mail page.', 'wp_mail'); ?></p>
	  
	  <input name="wmail_id" id="wmail_id" type="hidden" value="">
      <input type="hidden" name="wmail_form_submit" value="yes"/>
	  <div style="padding-top:5px;"></div>
      <p>
        <input name="publish" lang="publish" class="button add-new-h2" value="<?php _e('Insert Details', 'wp_mail'); ?>" type="submit" />
        <input name="publish" lang="publish" class="button add-new-h2" onclick="_wmail_redirect()" value="<?php _e('Cancel', 'wp_mail'); ?>" type="button" />
        <input name="Help" lang="publish" class="button add-new-h2" onclick="_wmail_help()" value="<?php _e('Help', 'wp_mail'); ?>" type="button" />
      </p>
	  <?php wp_nonce_field('wmail_form_importemails'); ?>
    </form>
</div>
<h3><?php _e('Note', 'wp_mail'); ?></h3>
<ol>
	<li><?php _e('Enter your email address with comma separated.', 'wp_mail'); ?></li>
	<li><?php _e('Enter maximum 25 email address at one time.', 'wp_mail'); ?></li>
	<li><?php _e('Comma not allowed at the end of the string.', 'wp_mail'); ?></li>
</ol>
<h3><?php _e('Wrong format', 'wp_mail'); ?></h3>
<ol>
	<li>abc@gmail.com,abc1@gmail.com, &nbsp;&nbsp;&nbsp;&nbsp;<?php _e('(Comma at the end)', 'wp_mail'); ?></li>
	<li>abc@gmail.com,,abc1@gmail.com &nbsp;&nbsp;&nbsp;&nbsp;<?php _e('(Two comma)', 'wp_mail'); ?></li>
</ol>
<h3><?php _e('Correct format', 'wp_mail'); ?></h3>
<ol>
	<li>abc@gmail.com,abc1@gmail.com</li>
</ol>
</div>