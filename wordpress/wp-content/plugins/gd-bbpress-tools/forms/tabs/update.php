<?php

if (isset($_GET["wp44-updated"]) && $_GET["wp44-updated"] == "true") { 
    $count = isset($_GET['count']) ? intval($_GET['count']) : 0; ?>
<div class="updated settings-error" id="setting-error-settings_updated"> 
    <p><strong><?php _e("Database updated.", "gd-bbpress-tools"); ?> <?php echo sprintf(__("Total of %s posts are updated.", "gd-bbpress-tools"), $count); ?></strong></p>
</div>
<?php }

?>
<h3><?php _e("WordPress 4.4: Update for shortcode parsing changes", "gd-bbpress-tools"); ?></h3>
<p><?php _e("WordPress 4.4 introduced some changes in the way it parses shortcodes, and this affected some of the BBCodes added by GD bbPress Tools plugin.", "gd-bbpress-tools"); ?></p>
<a href="edit.php?post_type=forum&page=gdbbpress_tools&tab=update&tool=wp44&_nonce=<?php echo wp_create_nonce('gdbbp-tools-wp44'); ?>"><?php _e("Click here for more information and update", "gd-bbpress-tools"); ?></a>
