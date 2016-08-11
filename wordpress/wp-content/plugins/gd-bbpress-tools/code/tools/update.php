<?php

if (!defined('ABSPATH')) exit;

function d4p_bbp_shortcodes_wp44_build_query() {
    global $wpdb;

    $bbcodes = array('quote', 'url', 'size', 'color', 'area', 'anchor', 'img', 'youtube', 'vimeo');

    $where = " WHERE `post_type` in ('".bbp_get_topic_post_type()."', '".bbp_get_reply_post_type()."');";

    $query = array();
    foreach ($bbcodes as $code) {
        $query[] = "UPDATE ".$wpdb->posts." SET post_content = REPLACE(post_content, '[".$code."=', '[".$code." ".$code."=')".$where;
    }

    return $query;
}

function d4p_bbp_shortcodes_wp44_update() {
    global $wpdb;

    $count = 0;
    $queries = d4p_bbp_shortcodes_wp44_build_query();

    foreach ($queries as $query) {
        $num = $wpdb->query($query);

        if ($num !== false) {
            $count+= $num;
        }
    }

    return $count;
}
