<?php
/*
Template Name: addClass
*/

?>
<?php
global $wpdb;
// define variables and set to empty values
$courseIDErr = $courseNameErr = $hoursErr  = "";
$courseId = $courseName = $courseDesc = $hours = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["courseId"])) {
        $courseIDErr = "Course ID is required";
    } else {
        $courseId = test_input($_POST["courseId"]);
    }
    if (empty($_POST["courseName"])) {
        $courseNameErr = "Course Name is required";
    } else {
        $courseName = test_input($_POST["courseName"]);
    }
    if (empty($_POST["hours"])) {
        $hoursErr = "Hours are required";
    } else {
        $hours = test_input($_POST["hours"]);
    }
    if ($_POST["classType"] == 0){
        $_POST["classType"] = 1;
    } else {
        $classType = test_input($_POST["classType"]);
    }
    if ($_POST['courseDesc']){
        $courseDesc = test_input($_POST['courseDesc']);
    }

    $resultObj = ($wpdb->get_results('SELECT MAX(position) as max_id FROM class'));
    $lastAddedPosition = $resultObj->max_id;
    $classType = test_input($_POST["classType"]);
    $wpdb->insert(
        'class',
        array(
            'course_id' => $courseId,
            'course_name' => $courseName,
            'course_desc' => $courseDesc,
            'hours' => $hours,
            'class_type' => $classType,
            'position' => 0
        ),
        array(
            '%s',
            '%s',
            '%s',
            '%d',
            '%d',
            '%d',
        )
    );
    $lastId = $wpdb->insert_id;
    $users = $wpdb->get_results("SELECT ID FROM $wpdb->users");
    foreach ($users as $user) {
        $wpdb->insert(
            'classes',
            array(
                'user_id' => $user->ID,
                'class_id' => $lastId,
                'finished' => 0,
            ),
            array(
                '%d',
                '%d',
                "%d",
            )
        );
    }
    $wpdb->last_error;
    echo "Thank you " . $courseId . " was added to the database.";
}
//TODO: add error checking for database call

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>