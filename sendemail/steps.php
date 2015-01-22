<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<h3><?php _e('Steps to Send Email', 'wp_mail'); ?></h3>
<ol>
  <li><?php _e('Select email address from the list.', 'wp_mail'); ?></li>
  <li><?php _e('Select available email subject.', 'wp_mail'); ?></li>
  <li><?php _e('Click send email button.', 'wp_mail'); ?></li>
</ol>
