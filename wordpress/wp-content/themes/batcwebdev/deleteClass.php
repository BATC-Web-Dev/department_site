<?php
/*
Template Name: deleteClass
*/
global $wpdb;
    $id = $_POST["ID"];
    $wpdb->delete( 'wp9c_class', array( 'ID' => $id ) );
    $wpdb->delete( 'wp9c_classes', array( 'class_id' => $id ) );
    echo "Class Removed From Table";

?>
