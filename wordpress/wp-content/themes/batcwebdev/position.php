<?php
/*
Template Name: position
*/
?>
<?php
global $wpdb;
$i = 1git status;
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