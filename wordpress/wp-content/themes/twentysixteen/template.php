<?php
/*
Template Name: Class
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

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
        <h1>Classes</h1>
        <form name="classForm">
            <table class="class-table">
                <tr class="header">
                    <td>Course ID</td>
                    <td>Course Name</td>
                    <td>Hours</td>
                    <td>Finished</td>
                </tr>
            <?php
            global $wpdb;
            $currentUser = get_current_user_id();
            $result = $wpdb->get_results("SELECT * FROM classes INNER JOIN class ON class.ID = classes.class_id WHERE classes.user_id = '$currentUser'");

            foreach($result as $row)
            {
                $checkboxVal = intval($row->hours);
                $checkboxQuery = intval($row->finished);
                $checkboxState = '';
                if ($checkboxQuery == 0){
                    $checkboxState = '';
                } else {
                    $checkboxState = 'checked';
                }
                echo "<tr>";
                echo "<td>".$row->course_id."</td>";
                echo "<td>".$row->course_name."</td>";
                echo "<td id='hours'>".$row->hours."</td>";
                echo "<td><input type='checkbox' value='$checkboxVal' name='checkbox' onchange='checkTotal()' $checkboxState></td>";
                echo "</tr>";
            }
            ?>
                <tr>
                    <td></td>
                    <td>Completed Hours</td>
                    <td><input type="text" name="total" value="0" readonly></td>
                    <td></td>
                </tr>
            </table>
        </form>
	</main><!-- .site-main -->
	<?php get_sidebar( 'content-bottom' ); ?>

</div><!-- .content-area -->


<?php get_sidebar(); ?>
<?php get_footer(); ?>

<script>
    function checkTotal() {
        document.classForm.total.value = '';
        var sum = 0;
        for(i=0; i<document.classForm.checkbox.length; i++) {
            if (document.classForm.checkbox[i].checked) {
                sum = sum + parseInt(document.classForm.checkbox[i].value);
            }
        }
        document.classForm.total.value = sum;
    }


</script>
