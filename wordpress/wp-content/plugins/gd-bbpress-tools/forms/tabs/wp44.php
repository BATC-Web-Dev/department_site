<h3><?php _e("WordPress 4.4: Update for shortcode parsing changes", "gd-bbpress-tools"); ?></h3>
<p><?php _e("WordPress 4.4 introduced some changes in the way it parses shortcodes, and this affected some of the BBCodes added by GD bbPress Tools.", "gd-bbpress-tools"); ?></p>
<h4 style="font-size: 15px; margin: 14px 0;"><?php _e("Solution", "gd-bbpress-tools"); ?></h4>
<p><?php _e("To fix the issue, plugin is updated to handle changes. But, all topics and replies created before contain BBCodes used in the way WordPress 4.4 no longer allows. The only way to fix this is to update all old topics and replies and replace old BBCodes with new BBCodes format. You can do it automatically using this tool (just click Auto Update button at the end of this page), or you can use SQL queries listed below and run them directly on your database.", "gd-bbpress-tools"); ?></p>
<h4 style="font-size: 15px; margin: 14px 0;"><?php _e("Disclaimer", "gd-bbpress-tools"); ?></h4>
<p style="color: #d00;"><?php _e("This operation is not reversible, and before using this tool, make sure you have backup of your database (or at least 'posts' table) so you can restore it if something goes wrong.", "gd-bbpress-tools"); ?></p>

<?php

require_once(GDBBPRESSTOOLS_PATH.'code/tools/update.php');

$queries = d4p_bbp_shortcodes_wp44_build_query();

?>

<h3><?php _e("List of SQL queries", "gd-bbpress-tools"); ?></h3>
<pre style="padding: 10px; border: 1px solid #ddd; background: #fff; color: #111;">
<?php echo join("\r\n", $queries); ?>
</pre>

<h3><?php _e("Auto Update", "gd-bbpress-tools"); ?></h3>
<p><?php _e("To perform auto update, click the button.", "gd-bbpress-tools"); ?></p>
<a class="button-primary" href="edit.php?post_type=forum&page=gdbbpress_tools&tab=update&run=wp44&_nonce=<?php echo wp_create_nonce('gdbbp-tools-wp44-update'); ?>"><?php _e("Click here for auto update", "gd-bbpress-tools"); ?></a>
