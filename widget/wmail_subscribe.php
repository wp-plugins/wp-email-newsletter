<?php
$Email = "";
$Email = isset($_POST['txt_email_newsletter']) ? $_POST['txt_email_newsletter'] : '';
$Email = trim($Email);

if($Email <> "")
{
	$regex = '/^[A-z0-9][\w.+-]*@[A-z0-9][\w\-\.]+\.[A-z0-9]{2,6}$/';
	$wmail_valid_email = preg_match($regex, $Email);
	if($wmail_valid_email)
	{
		$wmail_abspath  = dirname(__FILE__);
		$wmail_abspath_1 = str_replace('wp-content/plugins/wp-email-Newsletter/widget', '', $wmail_abspath);
		$wmail_abspath_1 = str_replace('wp-content\plugins\wp-email-Newsletter\widget', '', $wmail_abspath_1);
		require_once($wmail_abspath_1 .'wp-config.php');
		global $wpdb, $wp_version;
		global $user_login , $user_email;
		
		$result = '0';
		$sSql = $wpdb->prepare(
			"SELECT COUNT(*) AS `count` FROM ".WN_mail_TABLE_SUB."
			WHERE `wmail_email_sub` = %s", $Email);
		$result = $wpdb->get_var($sSql);
		
		if ($result == '0')
		{
			$wmail_opt_option = get_option('wmail_opt_option');
			if($wmail_opt_option == "double-optin")
			{
				$doubleoptin = "PEN";
			}
			else
			{
				$doubleoptin = "SIG";
			}
			
			$CurrentDate = date('Y-m-d G:i:s'); 
			$sql = $wpdb->prepare(
				"INSERT INTO `". WN_mail_TABLE_SUB ."`
				(`wmail_name_sub`,`wmail_email_sub`, `wmail_status_sub`, `wmail_date_sub`)
				VALUES(%s, %s, %s, %s)",
				array('NA', $Email, $doubleoptin, $CurrentDate)
			);
			$wpdb->query($sql);
			
			$wmail_admin_email_option =  strtoupper(get_option('wmail_admin_email_option'));
			$wmail_user_email_option = strtoupper(get_option('wmail_user_email_option'));
			$wmail_admin_email_address = get_option('wmail_admin_email_address');
			$wmail_from_name = get_option('wmail_from_name');
			$wmail_from_email = get_option('wmail_from_email');
			
			if($wmail_admin_email_address == "")
			{
				get_currentuserinfo();
				$wmail_admin_email_address = $user_email;
			}
				
			if($wmail_from_name == "" || $wmail_from_email == "")
			{
				get_currentuserinfo();
				$wmail_from_name = $user_login;
				$wmail_from_email = $user_email;
			}
			
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=utf-8" . "\r\n";
			$headers .= "From: \"$wmail_from_name\" <$wmail_from_email>\n";
			
			if(trim($wmail_admin_email_option) == "YES")
			{
				$to_email = $wmail_admin_email_address;
				$to_subject = get_option('wmail_admin_email_subject');
				$to_message = get_option('wmail_admin_email_content');
				$to_message = str_replace("\r\n", "<br />", $to_message);
				$to_message = str_replace("##USEREMAIL##", $Email, $to_message);
				@wp_mail($to_email, $to_subject, $to_message, $headers);
			}
			if($doubleoptin == "PEN")
			{
				$to_email = $Email;
				$wmail_opt_guid = wmail_opt_guid();
				$to_subject = get_option('wmail_opt_subject');
				$to_message = get_option('wmail_opt_content');
				$wmail_opt_link = get_option('wmail_opt_link');
				
				$sSql = $wpdb->prepare("SELECT * FROM ".WN_mail_TABLE_SUB." WHERE wmail_email_sub = '%s' LIMIT 1	", array($to_email));
				$data = array();
				$data = $wpdb->get_row($sSql, ARRAY_A);
				$emaildbid = 0;
				if(count($data) > 0)
				{
					$emaildbid = $data['wmail_id_sub'];
				}
				
				$wmail_opt_rand = str_replace("##rand##", $emaildbid, $wmail_opt_link);
				$wmail_opt_user = str_replace("##user##", $to_email, $wmail_opt_rand);
				$wmail_opt_link = str_replace("##guid##", $wmail_opt_guid, $wmail_opt_user);
				$to_message = str_replace('##LINK##', $wmail_opt_link, $to_message);		
				$to_message = str_replace("\r\n", "<br />", $to_message);
				
				@wp_mail($to_email, $to_subject, $to_message, $headers);
				echo "subscribed-pending-doubleoptin";
			}
			else
			{
				if(trim($wmail_user_email_option) == "YES")
				{
					$to_email = $Email;
					$to_subject = get_option('wmail_user_email_subject');
					$to_message = get_option('wmail_user_email_content');
					$to_message = str_replace("\r\n", "<br />", $to_message);
					@wp_mail($to_email, $to_subject, $to_message, $headers);
				}
				echo "subscribed-successfully";
			}
			
		}
		else
		{
			echo "already-exist";
		}
	}
	else
	{
		echo "invalid-email";
	}
}
else
{
	echo "unexpected-error";
}

function wmail_opt_guid() 
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
?>