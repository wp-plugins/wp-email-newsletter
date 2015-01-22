<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<div class="wrap">
<?php
$did = isset($_GET['did']) ? $_GET['did'] : '0';

// First check if ID exist with requested ID
$sSql = $wpdb->prepare(
	"SELECT COUNT(*) AS `count` FROM ".WN_mail_TABLE."
	WHERE `wmail_id` = %d",
	array($did)
);
$result = '0';
$result = $wpdb->get_var($sSql);

if ($result != '1')
{
	?><div class="error fade"><p><strong><?php _e('Oops, selected details doesnt exist (1).', 'wp_mail'); ?></strong></p></div><?php
}
else
{
	$wmail_errors = array();
	$wmail_success = '';
	$wmail_error_found = FALSE;
	
	$sSql = $wpdb->prepare("
		SELECT *
		FROM `".WN_mail_TABLE."`
		WHERE `wmail_id` = %d
		LIMIT 1
		",
		array($did)
	);
	$data = array();
	$data = $wpdb->get_row($sSql, ARRAY_A);
	
	// Preset the form fields
	$form = array(
		'wmail_subject' => $data['wmail_subject'],
		'wmail_content' => $data['wmail_content'],
		'wmail_status' => $data['wmail_status'],
		'wmail_date' => $data['wmail_date']
	);
}
// Form submitted, check the data
if (isset($_POST['wmail_form_submit']) && $_POST['wmail_form_submit'] == 'yes')
{
	//	Just security thingy that wordpress offers us
	check_admin_referer('wmail_form_edit');
	
	$form['wmail_subject'] = isset($_POST['wmail_subject']) ? $_POST['wmail_subject'] : '';
	if ($form['wmail_subject'] == '')
	{
		$wmail_errors[] = __('Please enter email subject.', 'wp_mail');
		$wmail_error_found = TRUE;
	}

	$form['wmail_content'] = isset($_POST['wmail_content']) ? $_POST['wmail_content'] : '';
	$form['wmail_status'] = isset($_POST['wmail_status']) ? $_POST['wmail_status'] : '';

	//	No errors found, we can add this Group to the table
	if ($wmail_error_found == FALSE)
	{	
		$sSql = $wpdb->prepare(
				"UPDATE `".WN_mail_TABLE."`
				SET `wmail_subject` = %s,
				`wmail_content` = %s,
				`wmail_status` = %s
				WHERE wmail_id = %d
				LIMIT 1",
				array($form['wmail_subject'], $form['wmail_content'], $form['wmail_status'], $did)
			);
		$wpdb->query($sSql);
		$wmail_success = __('Email was successfully updated.', 'wp_mail');
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
if ($wmail_error_found == FALSE && strlen($wmail_success) > 0)
{
?>
	<div class="updated fade">
		<p>
			<strong>
<?php echo $wmail_success; ?>
				<a href="<?php echo get_option('siteurl'); ?>/wp-admin/admin.php?page=compose-email"><?php _e('Click here', 'wp_mail'); ?></a>
<?php _e(' to view the details', 'wp_mail'); ?>
			</strong>
		</p>
	</div>
<?php
}
?>
<script language="javascript" src="<?php echo mail_plugin_url();?>/compose/compose-email-setting.js"></script>
<div class="form-wrap">
	<div id="icon-plugins" class="icon32"></div>
	<h2><?php _e(WN_mail_TITLE, 'wp_mail'); ?></h2>
	<form name="wmail_form" method="post" action="#" onsubmit="return _wmail_submit()"  >
      <h3><?php _e('Edit email', 'wp_mail'); ?></h3>
	  <label for="tag-image"><?php _e('Enter email subject.', 'wp_mail'); ?></label>
      <input name="wmail_subject" type="text" id="wmail_subject" value="<?php echo esc_html(stripslashes($form['wmail_subject'])); ?>" size="90" />
      <p><?php _e('Please enter your email subject.', 'wp_mail'); ?></p>
	  <label for="tag-link"><?php _e('Enter email content', 'wp_mail'); ?></label>
     <?php wp_editor(esc_html(stripslashes($form['wmail_content'])),'wmail_content');?>
      <p><?php _e('This page is where you write, save your email messages. We can add HTML content.', 'wp_mail'); ?></p>
      <label for="tag-display-status"><?php _e('Display status', 'wp_mail'); ?></label>
      <select name="wmail_status" id="wmail_status">
        <option value=''><?php _e('Select', 'wp_mail'); ?></option>
		<option value='YES' <?php if($form['wmail_status']=='YES') { echo 'selected="selected"' ; } ?>>Yes</option>
        <option value='NO' <?php if($form['wmail_status']=='NO') { echo 'selected="selected"' ; } ?>>No</option>
      </select>
      <p><?php _e('Do you want to show this email in Send Mail admin pages?.', 'wp_mail'); ?></p>
      <input name="wmail_id" id="wmail_id" type="hidden" value="">
      <input type="hidden" name="wmail_form_submit" value="yes"/>
      <p class="submit">
        <input name="publish" lang="publish" class="button add-new-h2" value="<?php _e('Update Details', 'wp_mail'); ?>" type="submit" />
        <input name="publish" lang="publish" class="button add-new-h2" onclick="_wmail_redirect()" value="<?php _e('Cancel', 'wp_mail'); ?>" type="button" />
        <input name="Help" lang="publish" class="button add-new-h2" onclick="wmail_help()" value="<?php _e('Help', 'wp_mail'); ?>" type="button" />
      </p>
	  <?php wp_nonce_field('wmail_form_edit'); ?>
    </form>
</div>
</div>