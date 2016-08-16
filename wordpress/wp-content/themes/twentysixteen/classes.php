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
<body onload="checkTotal()">
<script>
    function checkTotal() {
        var object = document.getElementsByTagName('input');
        document.classForm.total.value = '';
        var sum = 0;
        for(i=0; i<object.length; i++) {
            if (object[i].type == 'checkbox' && object[i].checked) {
                sum = sum + parseInt(object[i].value);
            }
        }
        document.classForm.total.value = sum;
    }
</script>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
        <h1>Classes</h1>
        <form name="classForm" method="post"action="">
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
                echo "<input type='hidden' value='0' name='checkbox[]'></input>";
                echo "<td><input type='checkbox' value='$checkboxVal' name='checkbox[]' onchange='checkTotal()' $checkboxState></td>";
                echo "</tr>";
            }
            ?>
                <tr>
                    <td></td>
                    <td>Completed Hours</td>
                    <td><input type="text" name="total" value="0" readonly></td>
                    <td><input type="submit" name="submit" value="Save Finished"></td>
                </tr>
            </table>
        </form>
        <?php
        $checkArray = $_POST['checkbox'];
        if (isset($_POST['submit'])) {
            print_r(count($checkArray));
            for($i = count($checkArray); $i > 0; $i--){
                if ($checkArray[$i] > 0){
                    $checkArray[$i] = 1;
                }
                if (($checkArray[$i] == 1) && ($checkArray[$i-1] == 0)){
                    unset($checkArray[$i-1]);
                }
            }
            $_POST['checkbox'] = array_values($checkArray);
            print_r($_POST['checkbox']);
        }
        ?>
	</main><!-- .site-main -->
	<?php get_sidebar( 'content-bottom' ); ?>

</div><!-- .content-area -->
</body>

<?php get_sidebar(); ?>
<?php get_footer(); ?>

