<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<script language="javascript" src="<?php echo mail_plugin_url();?>/pages/pages-setting.js"></script>
<div class="wrap">
  <div class="form-wrap">
    <div id="icon-plugins" class="icon32"></div>
    <h2><?php _e(WN_mail_TITLE, 'wp_mail'); ?></h2>
    <h3><?php _e('Widget setting', 'wp_mail'); ?></h3>
	<?php
	$wmail_title = get_option('wmail_title');
	$wmail_on_homepage = get_option('wmail_on_homepage');
	$wmail_on_posts = get_option('wmail_on_posts');
	$wmail_on_pages = get_option('wmail_on_pages');
	$wmail_on_search = get_option('wmail_on_search');
	$wmail_on_archives = get_option('wmail_on_archives');
	$wmail_widget_cap = get_option('wmail_widget_cap');
	$wmail_widget_txt_cap = get_option('wmail_widget_txt_cap');
	$wmail_widget_but_cap = get_option('wmail_widget_but_cap');
	
	if (@$_POST['wmail_submit']) 
	{
		//	Just security thingy that wordpress offers us
		check_admin_referer('wmail_form_widget');
		
		$wmail_title = stripslashes($_POST['wmail_title']);
		$wmail_on_homepage = stripslashes($_POST['wmail_on_homepage']);
		$wmail_on_posts = stripslashes($_POST['wmail_on_posts']);
		$wmail_on_pages = stripslashes($_POST['wmail_on_pages']);
		$wmail_on_search = stripslashes($_POST['wmail_on_search']);
		$wmail_on_archives = stripslashes($_POST['wmail_on_archives']);
		$wmail_widget_cap = stripslashes($_POST['wmail_widget_cap']);
		$wmail_widget_txt_cap = stripslashes($_POST['wmail_widget_txt_cap']);
		$wmail_widget_but_cap = stripslashes($_POST['wmail_widget_but_cap']);
		
		update_option('wmail_title', $wmail_title );
		update_option('wmail_on_homepage', $wmail_on_homepage );
		update_option('wmail_on_posts', $wmail_on_posts );
		update_option('wmail_on_pages', $wmail_on_pages );
		update_option('wmail_on_search', $wmail_on_search );
		update_option('wmail_on_archives', $wmail_on_archives );
		update_option('wmail_widget_cap', $wmail_widget_cap );
		update_option('wmail_widget_txt_cap', $wmail_widget_txt_cap );
		update_option('wmail_widget_but_cap', $wmail_widget_but_cap );
		
		?>
		<div class="updated fade">
			<p><strong><?php _e('Details successfully updated.', 'wp_mail'); ?></strong></p>
		</div>
		<?php
	}
	
	?>
	<form name="wmail_form" method="post" action="">
	
	<label for="tag-title"><?php _e('Title', 'wp_mail'); ?></label>
	<input name="wmail_title" id="wmail_title" type="text" value="<?php echo $wmail_title; ?>" maxlength="150" size="50" />
	<p><?php _e('Please enter widget title.', 'wp_mail'); ?></p>

<?php 	/****  Input field for dispaly widget on site****/  ?>


<?php /*?>	<label for="tag-title"><?php _e('Display option (Home page)', 'wp_mail'); ?></label>
	<input name="wmail_on_homepage" id="wmail_on_homepage" type="text" value="<?php echo $wmail_on_homepage; ?>" maxlength="3" />
	<p><?php _e('Display widget on website home pages. Enter YES (or) NO', 'wp_mail'); ?></p>
	
	<label for="tag-title"><?php _e('Display option (Posts)', 'wp_mail'); ?></label>
	<input name="wmail_on_posts" id="wmail_on_posts" type="text" value="<?php echo $wmail_on_posts; ?>" maxlength="3" />
	<p><?php _e('Display widget on all posts. Enter YES (or) NO', 'wp_mail'); ?></p>
	
	<label for="tag-title"><?php _e('Display option (Pages)', 'wp_mail'); ?></label>
	<input name="wmail_on_pages" id="wmail_on_pages" type="text" value="<?php echo $wmail_on_pages; ?>" maxlength="3" />
	<p><?php _e('Display widget on all pages. Enter YES (or) NO', 'wp_mail'); ?></p>
	
	<label for="tag-title"><?php _e('Display option (Search page)', 'wp_mail'); ?></label>
	<input name="wmail_on_search" id="wmail_on_search" type="text" value="<?php echo $wmail_on_search; ?>" maxlength="3" />
	<p><?php _e('Display widget on all search result pages. Enter YES (or) NO', 'wp_mail'); ?></p>
	
	<label for="tag-title"><?php _e('Display option (Archives page)', 'wp_mail'); ?></label>
	<input name="wmail_on_archives" id="wmail_on_archives" type="text" value="<?php echo $wmail_on_archives; ?>" maxlength="3" />
	<p><?php _e('Display widget on all archive pages. Enter YES (or) NO', 'wp_mail'); ?></p>
	<?php */?>
	
	<input name="wmail_on_homepage" id="wmail_on_homepage" type="hidden" value="<?php echo "YES" ;?>" maxlength="3" />
	<input name="wmail_on_posts" id="wmail_on_posts" type="hidden" value="<?php echo "YES" ;?>" maxlength="3" />
	<input name="wmail_on_pages" id="wmail_on_pages" type="hidden" value="<?php echo "YES" ;?>" maxlength="3" />
	<input name="wmail_on_search" id="wmail_on_search" type="hidden" value="<?php echo "YES" ;?>" maxlength="3" />
	<input name="wmail_on_archives" id="wmail_on_archives" type="hidden" value="<?php echo "YES"; ?>" maxlength="3" />

<?php /* ****** Input field end   *****/?>		

	<label for="tag-title"><?php _e('Short description', 'wp_mail'); ?></label>
	<input name="wmail_widget_cap" id="wmail_widget_cap" type="text" value="<?php echo $wmail_widget_cap; ?>" size="50" />
	<p><?php _e('Please enter short description about your widget.', 'wp_mail'); ?></p>
	
	<label for="tag-title"><?php _e('TextBox caption', 'wp_mail'); ?></label>
	<input name="wmail_widget_txt_cap" id="wmail_widget_txt_cap" type="text" value="<?php echo $wmail_widget_txt_cap; ?>" />
	<p><?php _e('Please enter text to show within email text box.', 'wp_mail'); ?></p>
	
	<label for="tag-title"><?php _e('Button caption', 'wp_mail'); ?></label>
	<input name="wmail_widget_but_cap" id="wmail_widget_but_cap" type="text" value="<?php echo $wmail_widget_but_cap; ?>" />
	<p><?php _e('Please enter text to shown on the widget submit button.', 'wp_mail'); ?></p>
	
	<p style="padding-top:10px;">
		<input type="submit" id="wmail_submit" name="wmail_submit" lang="publish" class="button add-new-h2" value="<?php _e('Update Settings', 'wp_mail'); ?>" />
		<input name="publish" lang="publish" class="button add-new-h2" onclick="_wmail_redirect()" value="<?php _e('Cancel', 'wp_mail'); ?>" type="button" />
	</p>
	<?php wp_nonce_field('wmail_form_widget'); ?>
	</form>
  </div><br />
</div>