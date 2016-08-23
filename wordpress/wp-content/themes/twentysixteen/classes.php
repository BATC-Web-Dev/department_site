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
<?php
global $wpdb;
$checkArray = $_POST['checkbox'];

if (isset($_POST['submit'])) {
    for ($i = count($checkArray); $i >= 0; $i--) {
        if ($checkArray[$i] > 0) {
            $checkArray[$i] = 1;
        }
        if (($checkArray[$i] == 1) && ($checkArray[$i - 1] == 0)) {
            unset($checkArray[$i - 1]);
        }
    }
    $_POST['checkbox'] = array_values($checkArray);
    for ($i=0; $i < count($_POST['checkbox']); $i++) {
        $wpdb->update(
            'classes',
            array(
                'finished' => $_POST['checkbox'][$i],
            ),
            array( 'class_id' => $_POST['class_id'][$i] ),
            array(
                '%d'
            ),
            array( '%d' )
        );
    }
}
//TODO: add error checking for database call
?>
<body onload="checkTotal()">
<script type="text/javascript">
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
    //Change the color of the tr based on the class type
    jQuery(document).ready(function( $ ) {
        //Core
        $(".classType1").css("color", "red");
        //Front-End
        $(".classType2").css("color", "blue");
        //Backend
        $(".classType3").css("color", "green");
        //Table Stripe
        $( "tr:odd" ).css( "background-color", "#eee" );


    });
</script>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
        <h1>Classes</h1>
            <ul><!-- Change the class color key here-->
                <li style="color: red">Core</li>
                <li style="color: blue">Front-End</li>
                <li style="color: green">Back-End</li>
            </ul>
        <form name="classForm" method="post" action="<?php echo get_permalink(); ?>">
            <table id="classTable">
                <thead>
                    <tr class="header">
                        <th>Course ID</th>
                        <th>Course Name</th>
                        <th>Hours</th>
                        <th>Finished</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                global $wpdb;
                $currentUser = get_current_user_id();
                $result = $wpdb->get_results("SELECT * FROM classes INNER JOIN class ON class.ID = classes.class_id WHERE classes.user_id = '$currentUser'");
                //TODO: add error checking for database call
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
                    echo "<tr class='classType$row->class_type'>";
                    echo "<input type='hidden' name='class_type[]' value='$row->class_type'>";
                    echo "<td>".$row->course_id."</td>";
                    echo "<input type='hidden' name='class_id[]' value='$row->class_id'>";
                    echo "<td>".$row->course_name."</td>";
                    echo "<td id='hours'>".$row->hours."</td>";
                    echo "<input type='hidden' value='0' name='checkbox[]'>";
                    echo "<td><input type='checkbox' value='$checkboxVal' name='checkbox[]' onchange='checkTotal()' $checkboxState></td>";
                    echo "</tr>";
                }
                ?>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td>Completed Hours</td>
                            <td><input type="text" name="total" value="0" readonly></td>
                            <td><input type="submit" name="submit" value="Save Finished"></td>
                        </tr>
                    </tfoot>
                </tbody>
            </table>
        </form>

	</main><!-- .site-main -->
	<?php get_sidebar( 'content-bottom' ); ?>

</div><!-- .content-area -->
</body>

<?php get_sidebar(); ?>
<?php get_footer(); ?>

