<?php
/*
Template Name: AddClasses
*/

/**
 * The template for displaying pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

get_header(); ?>
<script>
    //Change the color of the tr based on the class type
    jQuery(document).ready(function( $ ) {
        //Core
        $(".classType1").css("color", "red");
        //Front-End
        $(".classType2").css("color", "blue");
        //Backend
        $(".classType3").css("color", "green");

    });
</script>
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

    $classType = test_input($_POST["classType"]);
    $wpdb->insert(
        'class',
        array(
            'course_id' => $courseId,
            'course_name' => $courseName,
            'course_desc' => $courseDesc,
            'hours' => $hours,
            'class_type' => $classType
        ),
        array(
            '%s',
            '%s',
            '%s',
            '%d',
            '%d'
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
    echo "<p>Class Added To Table</p>";
}
//TODO: add error checking for database call

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
		<h1>Add Classes</h1>
		<!-- Add a form to handle adding, editing, and removing classes from the database-->
        <p><span class="error">* required field.</span></p>
        <form class="form-horizontal" id="classForm" method="post" action="<?php echo get_permalink(); ?>">
            <div class="form-group">
                <label for="courseId">Class ID: </label>
                <span class="error">* <?php echo $courseIDErr;?></span>
                <input type="text" name="courseId" value="<?php echo $courseId;?>" class="form-control" id="courseId" placeholder="Enter Class ID">
            </div>
            <div class="form-group">
                <label for="courseName">Class Name: </label>
                <span class="error">* <?php echo $courseNameErr;?></span>
                <input type="text" name="courseName" value="<?php echo $courseName;?>" class="form-control" id="courseName" placeholder="Enter Class Name">
            </div>
            <div class="form-group">
                <label for="comment">Class Description:</label>
                <textarea class="classForm" rows="5" id="comment" name="courseDesc" value="<?php echo $courseDesc;?>"></textarea>
            </div>
            <div class="form-group">
                <label for="courseName">Hours: </label>
                <span class="error">* <?php echo $hoursErr?></span>
                <input type="text" name="hours" value="<?php echo $Hours;?>" class="form-control" id="hours" placeholder="Enter Class Hours">
            </div>
            <div class="form-group">
                <label for="sel1">Class Type:</label>
                <select class="form-control" id="sel1" name="classType">
                    <option value="1">Core</option>
                    <option value="2">Front-End</option>
                    <option value="3">Back-end</option>
                </select>
            </div>
            <button type="submit" class="btn btn-default" name="submit">Add Class</button>
        </form>
	</main><!-- .site-main -->
    <h1>Current Courses in Database</h1>
    <ul class="color-key"><!-- Change the class color key here-->
        Class Type Color Codes:
        <li style="color: red">Core,</li>
        <li style="color: blue">Front-End,</li>
        <li style="color: green">Back-End</li>
    </ul>
    <?php
    $result = $wpdb->get_results("SELECT * FROM class ORDER BY ID DESC");
    foreach($result as $row){
        echo "<p class='classType$row->class_type'>$row->ID : $row->course_id : $row->course_name : $row->hours : $row->class_type</p><br>";
    }
    ?>
</div><!-- .content-area -->
<?php get_footer(); ?>
