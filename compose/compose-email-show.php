<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php
// Form submitted, check the data
if (isset($_POST['frm_wmail_display']) && $_POST['frm_wmail_display'] == 'yes')
{
	$did = isset($_GET['did']) ? $_GET['did'] : '0';
	
	$wmail_success = '';
	$wmail_success_msg = FALSE;
	
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
		// Form submitted, check the action
		if (isset($_GET['ac']) && $_GET['ac'] == 'del' && isset($_GET['did']) && $_GET['did'] != '')
		{
			//	Just security thingy that wordpress offers us
			check_admin_referer('wmail_form_show');
			
			//	Delete selected record from the table
			$sSql = $wpdb->prepare("DELETE FROM `".WN_mail_TABLE."`
					WHERE `wmail_id` = %d
					LIMIT 1", $did);
			$wpdb->query($sSql);
			
			//	Set success message
			$wmail_success_msg = TRUE;
			$wmail_success = __('Selected record was successfully deleted.', 'wp_mail');
		}
	}
	
	if ($wmail_success_msg == TRUE)
	{
		?><div class="updated fade"><p><strong><?php echo $wmail_success; ?></strong></p></div><?php
	}
}
?>
<div class="wrap">
  <div id="icon-plugins" class="icon32"></div>
    <h2><?php _e(WN_mail_TITLE, 'wp_mail'); ?></h2>
	<h3><?php _e('Compose email', 'wp_mail'); ?>  <a class="add-new-h2" href="<?php echo get_option('siteurl'); ?>/wp-admin/admin.php?page=compose-email&amp;ac=add"><?php _e('Add New', 'wp_mail'); ?></a></h3>
    <div class="tool-box">
<?php
		$sSql = "SELECT * FROM `".WN_mail_TABLE."` order by wmail_id desc";
		$myData = array();
		$myData = $wpdb->get_results($sSql, ARRAY_A);
?>
		<script language="javascript" src="<?php echo mail_plugin_url();?>/compose/compose-email-setting.js"></script>
		<form name="frm_wmail_display" method="post">
      <table width="100%" class="widefat" id="straymanage">
        <thead>
          <tr>
            <th width="3%" class="check-column" scope="col"><input type="checkbox" name="wmail_group_item[]" /></th>
			<th scope="col"><?php _e('Email subject', 'wp_mail'); ?></th>
            <th scope="col"><?php _e('Status', 'wp_mail'); ?></th>
          </tr>
        </thead>
		<tfoot>
          <tr>
            <th class="check-column" scope="col"><input type="checkbox" name="wmail_group_item[]" /></th>
			<th scope="col"><?php _e('Email subject', 'wp_mail'); ?></th>
            <th scope="col"><?php _e('Status', 'wp_mail'); ?></th>
          </tr>
        </tfoot>
		<tbody>
<?php 
			$i = 0;
			$displayisthere = FALSE;
			if(count($myData) > 0)
			{
				$i = 1;
				foreach ($myData as $data)
				{
?>
					<tr class="<?php if ($i&1) { echo'alternate'; } else { echo ''; }?>">
						<td align="left"><input type="checkbox" value="<?php echo $data['wmail_id']; ?>" name="wmail_group_item[]"></td>
					  <td><?php echo esc_html(stripslashes($data['wmail_subject'])); ?>
						<div class="row-actions">
							<span class="edit"><a title="Edit" href="<?php echo get_option('siteurl'); ?>/wp-admin/admin.php?page=compose-email&amp;ac=edit&amp;did=<?php echo $data['wmail_id']; ?>">Edit</a> | </span>
							<span class="trash"><a onClick="javascript:_wmail_delete('<?php echo $data['wmail_id']; ?>')" href="javascript:void(0);">Delete</a></span> 
						</div>
					  </td>
						<td><?php echo $data['wmail_status']; ?></td>
					</tr>
<?php
					$i = $i+1;
				}
			}
			else
			{
				?><tr><td colspan="3" align="center"><?php _e('No records available.', 'wp_mail'); ?></td></tr><?php 
			}
			?>
		</tbody>
        </table>
		<?php wp_nonce_field('wmail_form_show'); ?>
		<input type="hidden" name="frm_wmail_display" value="yes"/>
      </form>	
	  <div class="tablenav">
		  <h2>
			<a class="button add-new-h2" href="<?php echo get_option('siteurl'); ?>/wp-admin/admin.php?page=compose-email&amp;ac=add"><?php _e('Compose New Email', 'wp_mail'); ?></a>
			<a class="button add-new-h2" href="<?php echo get_option('siteurl'); ?>/wp-admin/admin.php?page=view-subscriber&amp;ac=add"><?php _e('Add Email', 'wp_mail'); ?></a> 
		 </h2>
	  </div>
	  <div style="height:10px;"></div>
	</div>
</div>