<?php
/*
Template Name: deleteClass
*/
global $wpdb;
    $id = $_POST["ID"];
    $wpdb->delete( 'class', array( 'ID' => $id ) );
    $wpdb->delete( 'classes', array( 'class_id' => $id ) );
    echo "Class Removed From Table";

?>
