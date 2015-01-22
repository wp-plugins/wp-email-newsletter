<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>

<?php
$wmail_errors = array();
$wmail_success = '';
$wmail_error_found = FALSE;

$search = isset($_GET['search']) ? $_GET['search'] : 'A,B,C';
if (isset($_POST['wmail_sendmail_subscriber']) && $_POST['wmail_sendmail_subscriber'] == 'yes')
{
	//	Just security thingy that wordpress offers us
	check_admin_referer('wmail_sendmail_subscriber');
	
	$mailsubject_name =  sanitize_text_field( $_POST['wmail_subject_drop'] );
 
	$form['wmail_subject_drop'] = isset($mailsubject_name) ? $mailsubject_name : '';
	if ($form['wmail_subject_drop'] == '')
	{
		$wmail_errors[] = __('Please select email subject.', 'wp_mail');
		$wmail_error_found = TRUE;
	}
	
	$form['wmail_checked'] = isset($_POST['wmail_checked']) ? $_POST['wmail_checked'] : '';
	if ($form['wmail_checked'] == '')
	{
		$wmail_errors[] = __('Please select email address.', 'wp_mail');
		$wmail_error_found = TRUE;
	}
	$recipients = $_POST['wmail_checked'];
	
	//	No errors found, we can add this Group to the table
	if ($wmail_error_found == FALSE)
	{
		$sSql = $wpdb->prepare(
				"SELECT COUNT(*) AS `count` FROM ".WN_mail_TABLE."
				WHERE `wmail_id` = %d",
				array($form['wmail_subject_drop'])
			);
			$result = '0';
			$result = $wpdb->get_var($sSql);
			
			if ($result != '1')
			{
				?><div class="error fade"><p><strong><?php _e('Oops, selected details doesnt exist', 'wp_mail'); ?></strong></p></div><?php
			}
			else
			{
				$num_sent = 0;
				$num_sent = wmail_send_mail($form['wmail_checked'], $form['wmail_subject_drop'], "subscriber" );
				?>
				<div class="updated fade">
				<strong><p>Email has been sent to <?php echo $num_sent; ?> user(s), and <?php echo count($recipients);?> recipient(s) were originally found.</p></strong>
				</div>
				<?php
			}
	}
}
if ($wmail_error_found == TRUE && isset($wmail_errors[0]) == TRUE)
{
	?><div class="error fade"><p><strong><?php echo $wmail_errors[0]; ?></strong></p></div><?php
}
?>
<script language="javascript" src="<?php echo mail_plugin_url();?>/sendemail/sendmail-setting.js"></script>
<div class="wrap">
  <div class="form-wrap">
    <div id="icon-plugins" class="icon32"></div>
    <h2><?php _e(WN_mail_TITLE, 'wp_mail'); ?> <?php _e('(Send email to subscribed users)', 'wp_mail'); ?></h2>
	<h3><?php _e('Select email address from subscribed users list:', 'wp_mail'); ?></h3>
	<div style="padding-bottom:14px;padding-top:5px;">
		
	</div>
	<form name="form_wmail" method="post" action="#" onsubmit="return _wmail_send_email_submit()"  >
	<?php
	$sSql = "select distinct wmail_email_sub, wmail_id_sub from ".WN_mail_TABLE_SUB." where 1=1"; 
	$sSql = $sSql . " and (wmail_status_sub ='YES' OR wmail_status_sub ='SIG' OR wmail_status_sub ='CON')";
	$sSql = $sSql . " ORDER BY wmail_email_sub";
	$data = $wpdb->get_results($sSql);
	$count = 0;
	if ( !empty($data) ) 
	{
		echo "<table border='0' cellspacing='0'><tr>";
		$col=3;
		foreach ( $data as $data )
		{
			$to = $data->wmail_email_sub;
			$wmail_id_sub = $data->wmail_id_sub;
			$ToAddress = trim($to) . '<||>' . trim($wmail_id_sub);
			if($to <> "")
			{
				echo "<td style='padding-top:4px;padding-bottom:4px;padding-right:10px;'>";
				?>
				<input class="radio" type="checkbox" checked="checked" value='<?php echo $ToAddress; ?>' id="wmail_checked[]" name="wmail_checked[]">
				&nbsp;<?php echo $to; ?>
				<?php
				if($col > 1) 
				{
					$col=$col-1;
					echo "</td><td>"; 
				}
				elseif($col = 1)
				{
					$col=$col-1;
					echo "</td></tr><tr>";;
					$col=3;
				}
				$count = $count + 1;
			}
		}
		echo "</tr></table>";
	}
	else
	{
		$searchdisplay = "";
		if($search == "0,1,2,3,4,5,6,7,8,9")
		{
			$searchdisplay = "0 - 9";
		}
		else
		{
			$searchdisplay = $search;
		}
		_e($searchdisplay . ' - No email address available for this search result. Please click above buttons to search.', 'wp_mail');
	}
	?>
	<div style="padding-top:14px;">
		<?php _e('Total emails:', 'wp_mail'); ?> <?php echo $count; ?>
	</div>
	<div style="padding-top:14px;">
		<input class="button add-new-h2" type="hidden" name="send" value="true" />
		<input class="button add-new-h2" type="button" name="CheckAll" value="Check All" onClick="wamil_SetAllCheckBoxes('form_wmail', 'wmail_checked[]', true);">
		<input class="button add-new-h2" type="button" name="UnCheckAll" value="Uncheck All" onClick="wamil_SetAllCheckBoxes('form_wmail', 'wmail_checked[]', false);">
	</div>
	<?php
	$data = $wpdb->get_results("select wmail_id, wmail_subject  from ".WN_mail_TABLE." where 1=1 and wmail_status='YES' order by wmail_id desc");
	if ( !empty($data) ) 
	{
		foreach ( $data as $data )
		{
			if($data->wmail_subject <> "")
			{
				@$wmail_subject_drop_val = @$wmail_subject_drop_val . '<option value="'.$data->wmail_id.'">' . stripcslashes($data->wmail_subject) . '</option>';
			}
		}
	}
	?>
	<h3><?php _e('Select email subject', 'wp_mail'); ?></h3>
	<div>
		<select name="wmail_subject_drop" id="wmail_subject_drop">
			<option value=""><?php _e(' == Select Email Subject == ', 'wp_mail'); ?></option>
			<?php echo $wmail_subject_drop_val; ?>
		</select>
	</div>
	<div style="padding-top:20px;">
	<input type="submit" name="Submit" class="button add-new-h2" value="<?php _e('Send Email', 'wp_mail'); ?>" style="width:160px;" />&nbsp;&nbsp;
	<input name="publish" lang="publish" class="button add-new-h2" onclick="_wmail_redirect()" value="<?php _e('Cancel', 'wp_mail'); ?>" type="button" />&nbsp;&nbsp;
    <input name="Help" lang="publish" class="button add-new-h2" onclick="_wmail_help()" value="<?php _e('Help', 'wp_mail'); ?>" type="button" />
	</div>
	<?php wp_nonce_field('wmail_sendmail_subscriber'); ?>
	<input type="hidden" name="wmail_sendmail_subscriber" id="wmail_sendmail_subscriber" value="yes"/>
	</form>
	</div>
	<?php include_once("steps.php"); ?>
</div>