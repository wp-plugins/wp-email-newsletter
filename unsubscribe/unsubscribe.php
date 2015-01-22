<?php
$wmail_abspath = dirname(__FILE__);
$wmail_abspath_1 = str_replace('wp-content/plugins/wp-email-Newsletter/unsubscribe', '', $wmail_abspath);
$wmail_abspath_1 = str_replace('wp-content\plugins\wp-email-Newsletter\unsubscribe', '', $wmail_abspath_1);
require_once($wmail_abspath_1 .'wp-config.php');
$blogname = get_option('blogname');
?>
<html>
<head>
<title><?php echo $blogname; ?></title>
</head>
<body>
<?php
$form['rand'] = isset($_GET['rand']) ? $_GET['rand'] : '';
$form['user'] = isset($_GET['user']) ? $_GET['user'] : '';
$form['reff'] = isset($_GET['reff']) ? $_GET['reff'] : '';

if ($form['rand'] == '' || $form['user'] == '' || $form['reff'] == '')
{
	$message = get_option('wmail_msgdis_6');
	$message = str_replace("\r\n", "<br />", $message);
	if($message == "")
	{
		$message = __('Oops.. Unexpected error occurred. Please try again.', 'wp_mail');
	}
	echo $message;
	die;
}
else
{
	global $wpdb;
	$result = '0';
	$sSql = $wpdb->prepare("SELECT COUNT(*) AS count FROM ".WN_mail_TABLE_SUB." WHERE wmail_id_sub = %d and wmail_email_sub = '%s' and wmail_status_sub = 'CON'",
		$form['rand'], $form['user']);
	$result = $wpdb->get_var($sSql);

	if ($result != '1')
	{
		$message = get_option('wmail_msgdis_4');
		$message = str_replace("\r\n", "<br />", $message);
		if($message == "")
		{
			$message = __('Oops.. We are getting some technical error. Please try again or contact admin.', 'wp_mail');
		}
		echo $message;
	}
	else
	{
		  $sSql = $wpdb->prepare("UPDATE ".WN_mail_TABLE_SUB."
				SET wmail_status_sub = 'UNS' WHERE wmail_id_sub = %d and wmail_email_sub = '%s' LIMIT 1",array($form['rand'], $form['user']));
			$wpdb->query($sSql);
			
			$message = get_option('wmail_msgdis_3');
			$message = str_replace("\r\n", "<br />", $message);
			if($message == "")
			{
				$message = __('You have been successfully unsubscribed.', 'wp_mail');
			}
			echo $message;
	}
}
?>
</body>
</html>