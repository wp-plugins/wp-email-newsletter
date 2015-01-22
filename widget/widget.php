<script language="javascript" type="text/javascript" src="<?php echo mail_plugin_url('widget/widget.js'); ?>"></script>
<link rel="stylesheet" media="screen" type="text/css" href="<?php echo mail_plugin_url('widget/widget.css'); ?>" />
<div>
  <div class="wmail_caption">
    <?php echo get_option('wmail_widget_cap'); ?>
  </div>
  <div class="wmail_msg">
    <span id="wmail_msg"></span>
  </div>
  <div class="wmail_textbox">
    <input class="wmail_textbox_class" name="wmail_txt_email" id="wmail_txt_email" onkeypress="if(event.keyCode==13) wmail_mail_ajax_submit('<?php echo mail_plugin_url('widget'); ?>')" onblur="if(this.value=='') this.value='<?php echo get_option('wmail_widget_txt_cap'); ?>';" onfocus="if(this.value=='<?php echo get_option('wmail_widget_txt_cap'); ?>') this.value='';" value="<?php echo get_option('wmail_widget_txt_cap'); ?>" maxlength="150" type="text">
  </div>

  <div class="wmail_button">
    <input class="wmail_textbox_button" name="wmail_txt_Button" id="wmail_txt_Button" onClick="return wmail_mail_ajax_submit('<?php echo mail_plugin_url('widget'); ?>','<?php echo get_option('readygraph_application_id', ''); ?>')" value="<?php echo get_option('wmail_widget_but_cap'); ?>" type="button">
  </div>
</div>