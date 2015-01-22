<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php
// Form submitted, check the data
$search = isset($_GET['search']) ? $_GET['search'] : 'A,B,C';
if (isset($_POST['frm_wmail_display']) && $_POST['frm_wmail_display'] == 'yes')
{
	$did = isset($_GET['did']) ? $_GET['did'] : '0';
	
	$wmail_success = '';
	$wmail_success_msg = FALSE;
	if (isset($_POST['frm_wmail_bulkaction']) && $_POST['frm_wmail_bulkaction'] != 'delete' && $_POST['frm_wmail_bulkaction'] != 'resend')
	{
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
			?>
			<div class="error fade">
			  <p><strong><?php _e('Oops, selected details doesnt exist (1).', 'wp_mail'); ?></strong></p>
			</div>
			<?php
		}
		else
		{
			// Form submitted, check the action
			if (isset($_GET['ac']) && $_GET['ac'] == 'del' && isset($_GET['did']) && $_GET['did'] != '')
			{
				//	Just security thingy that wordpress offers us
				check_admin_referer('wmail_form_show');
				
				//	Delete selected record from the table
				$sSql = $wpdb->prepare("DELETE FROM `".WN_mail_TABLE_SUB."`
						WHERE `wmail_id_sub` = %d
						LIMIT 1", $did);
				$wpdb->query($sSql);
				
				//	Set success message
				$wmail_success_msg = TRUE;
				$wmail_success = __('Selected record was successfully deleted.', 'wp_mail');
			}
			
			if (isset($_GET['ac']) && $_GET['ac'] == 'resend' && isset($_GET['did']) && $_GET['did'] != '')
			{
				$did = isset($_GET['did']) ? $_GET['did'] : '0';
				ViewSubscriberResendEmail($did);
				$wmail_success_msg = TRUE;
				$wmail_success  = __('Confirmation email resent successfully.', 'wp_mail');
			}
		}
	}
	else
	{
		check_admin_referer('wmail_form_show');
		
		if (isset($_POST['frm_wmail_bulkaction']) && $_POST['frm_wmail_bulkaction'] == 'delete')
		{
			$chk_delete = $_POST['chk_delete'];
			if(!empty($chk_delete))
			{			
				$count = count($chk_delete);
				for($i=0; $i<$count; $i++)
				{
					$del_id = $chk_delete[$i];
					$sql = "delete FROM ".WN_mail_TABLE_SUB." WHERE wmail_id_sub=".$del_id." Limit 1";
					$wpdb->get_results($sql);
				}
				
				//	Set success message
				$wmail_success_msg = TRUE;
				$wmail_success = __($count . ' Selected record was successfully deleted.', 'wp_mail');
			}
			else
			{
				?>
				<div class="error fade">
				  <p><strong><?php _e('Oops, No record was selected.', 'wp_mail'); ?></strong></p>
				</div>
				<?php
			}
		}
		elseif (isset($_POST['frm_wmail_bulkaction']) && $_POST['frm_wmail_bulkaction'] == 'resend')
		{
			$chk_delete = $_POST['chk_delete'];
			if(!empty($chk_delete))
			{			
				$count = count($chk_delete);
				for($i=0; $i<$count; $i++)
				{
					$del_id = $chk_delete[$i];
					ViewSubscriberResendEmail($del_id);
					$wmail_success  = __('Confirmation email resent successfully.', 'wp_mail');
				}
				
				//	Set success message
				$wmail_success_msg = TRUE;
				$wmail_success = __($count . ' Confirmation emails resent successfully.', 'wp_mail');
			}
			else
			{
				?>
				<div class="error fade">
				  <p><strong><?php _e('Oops, No record was selected.', 'wp_mail'); ?></strong></p>
				</div>
				<?php
			}
		}
	}
	
	if ($wmail_success_msg == TRUE)
	{
		?>
		<div class="updated fade">
		  <p><strong><?php echo $wmail_success; ?></strong></p>
		</div>
		<?php
	}
}
?>
<script language="javaScript" src="<?php echo mail_plugin_url();?>/subscriber/subscriber-setting.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo mail_plugin_url();?>/inc/admin-css.css" />
<div class="wrap">
  <div id="icon-plugins" class="icon32"></div>
  <h2><?php _e(WN_mail_TITLE, 'wp_mail'); ?></h2>
  <h3><?php _e('View subscriber', 'wp_mail'); ?> <a class="add-new-h2" href="<?php echo get_option('siteurl'); ?>/wp-admin/admin.php?page=view-subscriber&amp;ac=add"><?php _e('Add New', 'wp_mail'); ?></a></h3>
  <div class="tool-box">
    <?php
		$sSql = "SELECT * FROM `".WN_mail_TABLE_SUB."` ";
		$sSql = $sSql . " ORDER BY wmail_id_sub  DESC";
		$myData = array();
		$myData = $wpdb->get_results($sSql, ARRAY_A);
		?>
	<div class="tablenav">
		
		<span style="float:right;">
			<a class="button add-new-h2" href="<?php echo get_option('siteurl'); ?>/wp-admin/admin.php?page=view-subscriber&amp;ac=add"><?php _e('Add Email', 'wp_mail'); ?></a> 
		
		</span>
    </div>
    <form name="frm_wmail_display" method="post" onsubmit="return _wmail_subscribermultipledelete()">
      <table width="100%" class="widefat" id="straymanage">
        <thead>
          <tr>
            <th class="check-column" scope="col"><input type="checkbox" name="chk_delete[]" id="chk_delete[]" /></th>
            <th scope="col"><?php _e('Sno', 'wp_mail'); ?></th>
            <th scope="col"><?php _e('Email address', 'wp_mail'); ?></th>
			<th scope="col"><?php _e('Status', 'wp_mail'); ?></th>
            <th scope="col"><?php _e('DB id', 'wp_mail'); ?></th>
			<th scope="col"><?php _e('Action', 'wp_mail'); ?></th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th class="check-column" scope="col"><input type="checkbox" name="chk_delete[]" id="chk_delete[]" /></th>
            <th scope="col"><?php _e('Sno', 'wp_mail'); ?></th>
            <th scope="col"><?php _e('Email address', 'wp_mail'); ?></th>
			<th scope="col"><?php _e('Status', 'wp_mail'); ?></th>
            <th scope="col"><?php _e('DB id', 'wp_mail'); ?></th>
			<th scope="col"><?php _e('Action', 'wp_mail'); ?></th>
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
            <td align="left"><input name="chk_delete[]" id="chk_delete[]" type="checkbox" value="<?php echo $data['wmail_id_sub'] ?>" /></td>
            <td><?php echo $i; ?></td>
            <td><?php echo $data['wmail_email_sub']; ?></td>        
            <td>
			<?php
			if($data['wmail_status_sub'] == "YES")
			{
				?>Old Email<?php
			}
			elseif($data['wmail_status_sub'] == "PEN")
			{
				?>Not confirmed<?php
			}
			elseif($data['wmail_status_sub'] == "CON")
			{
				?>Confirmed<?php
			}
			elseif($data['wmail_status_sub'] == "UNS")
			{
				?>Unsubscribed<?php
			}
			else
			{
				?>Old Email<?php
			}
			?>
			</td>
			<td><?php echo $data['wmail_id_sub']; ?></td>
			<td><div> 
			<span class="edit"><a title="Edit" href="<?php echo get_option('siteurl'); ?>/wp-admin/admin.php?page=view-subscriber&amp;ac=edit&search=<?php echo $search; ?>&amp;did=<?php echo $data['wmail_id_sub']; ?>"><?php _e('Edit', 'wp_mail'); ?></a> | </span> 
			<span class="trash"><a onClick="javascript:_wmail_delete('<?php echo $data['wmail_id_sub']; ?>','<?php echo $search; ?>')" href="javascript:void(0);"><?php _e('Delete', 'wp_mail'); ?></a></span>
			<?php
			if($data['wmail_status_sub'] != "CON")
			{
				?>
					<span class="edit"> | <a onClick="javascript:_wmail_resend('<?php echo $data['wmail_id_sub']; ?>','<?php echo $search; ?>')" href="javascript:void(0);"><?php _e('Resend Confirmation', 'wp_mail'); ?></a></span> 
				<?php
			}
			?>
			</div>
			</td>
          </tr>
          <?php
					$i = $i+1;
				} 
			}
			else
			{
				?>
				<tr>
					<td colspan="6" align="center"><?php _e('No records available.', 'wp_mail'); ?></td>
				</tr>
				<?php 
			}
			?>
        </tbody>
      </table>
      <?php wp_nonce_field('wmail_form_show'); ?>
      <input type="hidden" name="frm_wmail_display" value="yes"/>
	  <input type="hidden" name="frm_wmail_bulkaction" value=""/>
	  <input name="searchquery" id="searchquery" type="hidden" value="<?php echo $search; ?>" />
	<div style="padding-top:10px;"></div>
    <div class="tablenav">
		<div class="alignleft">
			<select name="action" id="action">
				<option value=""><?php _e('Bulk Actions', 'wp_mail'); ?></option>
				<option value="delete"><?php _e('Delete', 'wp_mail'); ?></option>
				<option value="resend"><?php _e('Resend Confirmation', 'wp_mail'); ?></option>
			</select>
			<input type="submit" value="Apply" class="button action" id="doaction" name="">
		</div>
		<div class="alignright">
			<a class="button add-new-h2" href="<?php echo get_option('siteurl'); ?>/wp-admin/admin.php?page=view-subscriber&amp;ac=add"><?php _e('Add Email', 'wp_mail'); ?></a> 
		
		</div>
    </div>
	</form>
    <br />
  </div>
</div>
