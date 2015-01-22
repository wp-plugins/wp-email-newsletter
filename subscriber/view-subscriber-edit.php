<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<div class="wrap">
<?php
$did = isset($_GET['did']) ? $_GET['did'] : '0';
$search = isset($_GET['search']) ? $_GET['search'] : 'A,B,C';

// First check if ID exist with requested ID
$sSql = $wpdb->prepare(
	"SELECT COUNT(*) AS `count` FROM ".WN_mail_TABLE_SUB."
	WHERE `wmail_id_sub` = %d",
	array($did)
);
$result = '0';
$result = $wpdb->get_var($sSql);

if ($result != '1')
{
	?><div class="error fade"><p><strong><?php _e('Oops, selected details doesnt exist.', 'wp_mail'); ?></strong></p></div><?php
}
else
{
	$wmail_errors = array();
	$wmail_success = '';
	$wmail_error_found = FALSE;
	
	$sSql = $wpdb->prepare("
		SELECT *
		FROM `".WN_mail_TABLE_SUB."`
		WHERE `wmail_id_sub` = %d
		LIMIT 1
		",
		array($did)
	);
	$data = array();
	$data = $wpdb->get_row($sSql, ARRAY_A);
	
	// Preset the form fields
	$form = array(
		'wmail_name_sub' => $data['wmail_name_sub'],
		'wmail_email_sub' => $data['wmail_email_sub'],
		'wmail_status_sub' => $data['wmail_status_sub'],
		'wmail_date_sub' => $data['wmail_date_sub']
	);
}
// Form submitted, check the data
if (isset($_POST['wmail_form_submit']) && $_POST['wmail_form_submit'] == 'yes')
{
	//	Just security thingy that wordpress offers us
	check_admin_referer('wmail_form_edit');
	
	$form['wmail_email_sub'] = isset($_POST['wmail_email_sub']) ? $_POST['wmail_email_sub'] : '';
	if ($form['wmail_email_sub'] == '')
	{
		$wmail_errors[] = __('Please enter email address.', 'wp_mail');
		$wmail_error_found = TRUE;
	}

	$form['wmail_name_sub'] = isset($_POST['wmail_name_sub']) ? $_POST['wmail_name_sub'] : '';
	$form['wmail_status_sub'] = isset($_POST['wmail_status_sub']) ? $_POST['wmail_status_sub'] : '';

	//	No errors found, we can add this Group to the table
	if ($wmail_error_found == FALSE)
	{	
		$sSql = $wpdb->prepare(
				"UPDATE `".WN_mail_TABLE_SUB."`
				SET `wmail_email_sub` = %s,
				`wmail_name_sub` = %s,
				`wmail_status_sub` = %s
				WHERE wmail_id_sub = %d
				LIMIT 1",
				array($form['wmail_email_sub'], $form['wmail_name_sub'], $form['wmail_status_sub'], $did)
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
    <p><strong><?php echo $wmail_success; ?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/admin.php?page=view-subscriber&search=<?php echo $search; ?>"><?php _e('Click here', 'wp_mail'); ?></a> <?php _e(' to view the details', 'wp_mail'); ?></strong></p>
  </div>
  <?php
}
?>
<script language="javaScript" src="<?php echo mail_plugin_url();?>/subscriber/subscriber-setting.js"></script>
<div class="form-wrap">
	<div id="icon-plugins" class="icon32"></div>
	<h2><?php _e(WN_mail_TITLE, 'wp_mail'); ?></h2>
	<form name="wmail_form" method="post" action="#" onsubmit="return _wmail_submit()"  >
      <h3><?php _e('Edit email', 'wp_mail'); ?></h3>
	  <label for="tag-image"><?php _e('Enter email address.', 'wp_mail'); ?></label>
      <input name="wmail_email_sub" type="text" id="wmail_email_sub" value="<?php echo esc_html(stripslashes($form['wmail_email_sub'])); ?>" size="50" />
      <p><?php _e('Please enter email address.', 'wp_mail'); ?></p>
	  <label for="tag-image"><?php _e('Enter name.', 'wp_mail'); ?></label>
      <input name="wmail_name_sub" type="text" id="wmail_name_sub" value="<?php echo esc_html(stripslashes($form['wmail_name_sub'])); ?>" size="50" />
      <p><?php _e('Please enter email name.', 'wp_mail'); ?></p>
      <label for="tag-display-status"><?php _e('Status', 'wp_mail'); ?></label>
      <select name="wmail_status_sub" id="wmail_status_sub">
        <option value=''><?php _e('Select', 'wp_mail'); ?></option>
		<option value='PEN' <?php if(strtoupper($form['wmail_status_sub'])=='PEN') { echo 'selected="selected"' ; } ?>>Not confirmed</option>
		<option value='CON' <?php if(strtoupper($form['wmail_status_sub'])=='CON') { echo 'selected="selected"' ; } ?>>Confirmed</option>
		<option value='UNS' <?php if(strtoupper($form['wmail_status_sub'])=='UNS') { echo 'selected="selected"' ; } ?>>Unsubscribed</option>
      </select>
      <p><?php _e('Unsubscribed, Not confirmed emails not display in send mail page.', 'wp_mail'); ?></p>
      <input name="wmail_id_sub" id="wmail_id_sub" type="hidden" value="">
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