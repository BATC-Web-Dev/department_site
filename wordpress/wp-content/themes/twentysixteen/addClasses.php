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
<?php
// define variables and set to empty values
$courseIDErr = $courseNameErr = $hoursErr  = "";
$courseId = $courseName = $hours = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["courseId"])) {
        $courseIDErr = "Course ID is required";
    } else {
        $courseId = test_input($_POST["courseId"]);
        print_r($courseId);
    }
    if (empty($_POST["courseName"])) {
        $courseNameErr = "Course Name is required";
    } else {
        $courseName = test_input($_POST["courseName"]);
        print_r($courseName);
    }
    if (empty($_POST["hours"])) {
        $hoursErr = "Hours are required";
    } else {
        $hours = test_input($_POST["hours"]);
    }
    $wpdb->insert(
        'class',
        array(
            'course_id' => $courseId,
            'course_name' => $courseName,
            'hours' => $hours
        ),
        array(
            '%s',
            '%s',
            '%d'
        )
    );
    echo "<p>Class Added To Table</p>";
}

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
        <form method="post" action="<?php echo get_permalink(); ?>">
            Class ID: <input type="text" name="courseId" value="<?php echo $courseId;?>">
            <span class="error">* <?php echo $courseIDErr;?></span>
            <br><br>
            Class Name: <input type="text" name="courseName" value="<?php echo $courseId;?>">
            <span class="error">* <?php echo $courseNameErr;?></span>
            <br><br>
            Hours: <input type="text" name="hours" value="<?php echo $Hours;?>">
            <span class="error"><?php echo $HoursErr;?></span>
            <br><br>
            <input type="submit" name="submit" value="Add Class">
        </form>
	</main><!-- .site-main -->
    <?php
    $result = $wpdb->get_results("SELECT * FROM class");
    foreach($result as $row){
        echo "<p>$row->course_id : $row->course_name : $row->hours</p><br>";
    }
    ?>
	<?php get_sidebar( 'content-bottom' ); ?>

</div><!-- .content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
