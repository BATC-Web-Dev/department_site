<?php
/*
Template Name: position
*/
?>
<?php
global $wpdb;
$i = 1;
foreach ($_POST['position'] as $value) {
    $wpdb->update(
        'class',
        array(
            'position' => $i,
        ),
        array( 'ID' => $value
        ),
        array( '%d',
        )
    );
    $i++;
}
    echo '{"status":"success"}';
?>