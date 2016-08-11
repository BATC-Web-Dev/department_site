<?php

if (!defined('ABSPATH')) exit;

class gdbbMod_Signature {
    public $active = false;
    public $max_length;
    public $enhanced;
    public $method;
    public $profile_group;

    public $bbcodes = false;
    public $html = false;

    function __construct($max_length = 512, $enhanced = true, $method = 'bbcode', $profile_group = 1) {
        $this->max_length = $max_length;
        $this->enhanced = $enhanced;
        $this->method = $method;
        $this->profile_group = $profile_group;

        if ($this->enhanced) {
            if ($method == 'bbcode' || $method == 'full') {
                $this->bbcodes = true;
            }

            if ($method == 'html' || $method == 'full') {
                $this->html = true;
            }
        }
        
        add_action('bbtoolbox_init', array($this, 'init'));
    }

    public function init() {
        if ($this->active) {
            add_action('show_user_profile', array(&$this, 'editor_form_profile'));
            add_action('edit_user_profile', array(&$this, 'editor_form_profile'));
            add_action('edit_user_profile_update', array($this, 'editor_save'));
            add_action('personal_options_update', array($this, 'editor_save'));
            add_action('xprofile_updated_profile', array($this, 'editor_save'));

            add_action('bbp_user_edit_after', array(&$this, 'editor_form_bbpress'));
            add_action('bbp_user_edit_signature_info', array(&$this, 'signature_info'));

            add_action('bp_custom_profile_edit_fields', array(&$this, 'editor_form_buddypress'));
        }

        $this->add_content_filters();
    }

    public function add_content_filters() {
        add_filter('bbp_get_topic_content', array(&$this, 'reply_content'), 10000, 2);
        add_filter('bbp_get_reply_content', array(&$this, 'reply_content'), 10000, 2);
    }

    public function remove_content_filters() {
        remove_filter('bbp_get_topic_content', array(&$this, 'reply_content'), 10000, 2);
        remove_filter('bbp_get_reply_content', array(&$this, 'reply_content'), 10000, 2);
    }

    public function editor_form_profile() {
        if (!is_admin()) return;

        global $profileuser;

        $old_filter = $profileuser->filter;
        $profileuser->filter = 'display';

        $_signature = d4p_bbp_update_shorthand_bbcodes($profileuser->signature);

        $profileuser->filter = $old_filter;

        $form = apply_filters('d4p_bbpresstools_signature_editor_file', GDBBPRESSTOOLS_PATH.'forms/tools/signature_profile.php');
        include_once($form);
    }

    public function editor_form_bbpress() {
        $_signature = d4p_bbp_update_shorthand_bbcodes(bbp_get_displayed_user_field('signature'));

        $form = apply_filters('d4p_bbpresstools_signature_editor_file', GDBBPRESSTOOLS_PATH.'forms/tools/signature_bbpress.php');
        include_once($form);
    }

    public function editor_form_buddypress() {
        if (bp_get_current_profile_group_id() == $this->profile_group) {
            $user_id = bp_displayed_user_id();

            if ($user_id > 0) {
                $user = get_user_by('id', $user_id);

                $old_filter = $user->filter;
                $user->filter = 'display';

                $_signature = d4p_bbp_update_shorthand_bbcodes($user->signature);

                $user->filter = $old_filter;

                $form = apply_filters('d4p_bbpresssignature_bbpress_editor_file', GDBBPRESSTOOLS_PATH.'forms/tools/signature_buddypress.php');
                include_once($form);
            }

            remove_action('bp_custom_profile_edit_fields', array(&$this, 'editor_form_buddypress'));
        }
    }

    public function signature_info() {
        $message = array();

        if (!$this->html && !$this->bbcodes) {
            $message[] = __("You can use only plain text. HTML and BBCodes will be stripped.", "gd-bbpress-tools");
        } else {
            if ($this->html) {
                $message[] = __("You can use HTML.", "gd-bbpress-tools");
            }

            if ($this->bbcodes) {
                $message[] = __("You can use BBCodes.", "gd-bbpress-tools");
            }

            if (!$this->html) {
                $message[] = __("HTML will be stripped.", "gd-bbpress-tools");
            }

            if (!$this->bbcodes) {
                $message[] = __("BBCodes will be stripped.", "gd-bbpress-tools");
            }
        }
        
        echo join(' ', $message);
    }

    public function format_signature($sig) {
        if (!$this->html) {
            $sig = strip_tags($sig);
        }

        if (!$this->bbcodes) {
            $sig = strip_shortcodes($sig);
        }

        if (!current_user_can('unfiltered_html')) {
            $sig = stripslashes(wp_filter_post_kses(addslashes($sig)));
        }

        if (strlen($sig) > $this->max_length) {
            $sig = substr($sig, 0, $this->max_length);
        }

        return trim($sig);
    }

    public function editor_save($user_id) {
        if (isset($_POST['signature'])) {
            $sig = $this->format_signature($_POST['signature']);

            update_user_meta($user_id, 'signature', $sig);
        }
    }

    public function reply_content($content, $reply_id = 0) {
        if ($reply_id == 0) {
            global $post;

            $user_id = $post->post_author;
        } else {
            $user_id = bbp_get_reply_author_id($reply_id);
        }

        $signature = get_user_meta($user_id, 'signature', true);

        $sig = d4p_bbp_update_shorthand_bbcodes($signature);

        if ($sig != $signature) {
            update_user_meta($user_id, 'signature', $sig, $signature);
        }

        if ($sig != '') {
            $sig = convert_smilies($sig);
            $sig = convert_chars($sig);
            $sig = wpautop($sig);
            $sig = shortcode_unautop($sig);
            $sig = do_shortcode($sig);

            $content.= '<div class="bbp-signature">'.$sig.'</div>';
        }

        return $content;
    }
}

?>