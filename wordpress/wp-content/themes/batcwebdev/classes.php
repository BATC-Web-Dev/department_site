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
            'wp9c_classes',
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
            $(".classType1").css("color", "Black");
            //Digital Media
            $(".classType2").css("color", "DarkBlue");
            //Front End
            $(".classType3").css("color", "DarkRed");
            //Backend
            $(".classType4").css("color", "DarkOrange");
            //Web Orginazation
            $(".classType5").css("color", "DarkViolet");
            //Electives
            $(".classType6").css("color", "Green");
            //Stripe
            $( "tbody tr:even" ).css( "background-color", "#C9C9C9" );

            $(function() {
                $("td[colspan=4]").css('pointer-events', 'none');
                $("td[colspan=4]").find("p").hide();
                $("tr").click(function(event) {
                    event.stopPropagation();
                    var $target = $(event.target);
                    if($($target).is('input[type=checkbox]')) {
                        return;
                    }
                    else if ( $target.closest("td").attr("colspan") > 1 ) {
                        $target.slideUp();
                    } else {
                        $target.closest("tr").next().find("p").slideToggle();
                    }
                });
            });
        });
    </script>
    <div class="container">
        <div id="primary">
            <main id="main" class="site-main" role="main">
                <div class="row">
                    <div class="col-md-12 lead">Classes<hr></div>
                </div>
                <ul class="color-key col-sm-10"><!-- Change the class color key here-->
                    Class Type Color Codes:
                    <li style="color: Black">Core,</li>
                    <li style="color: DarkBlue">Digital Media,</li>
                    <li style="color: DarkRed">Front End Development</li>
                    <li style="color: DarkOrange">Backend Development</li>
                    <li style="color: DarkViolet">Web Site Organization</li>
                    <li style="color: Green">Front End Development</li>
                </ul>
                <form name="classForm" method="post" action="<?php echo get_permalink(); ?>">
                    <table id="classTable" class="table">
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
                        $result = $wpdb->get_results("SELECT * FROM wp9c_classes INNER JOIN wp9c_class ON wp9c_class.ID = wp9c_classes.class_id WHERE wp9c_classes.user_id = '$currentUser' ORDER BY position ASC");
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
                            echo "<td><p>".$row->course_id."</p></td>";
                            echo "<input type='hidden' name='class_id[]' value='$row->class_id'>";
                            echo "<td><p>".$row->course_name."</p></td>";
                            echo "<td id='hours'><p>".$row->hours."</p></td>";
                            echo "<input type='hidden' value='0' name='checkbox[]'>";
                            echo "<td><input type='checkbox' value='$checkboxVal' name='checkbox[]' onchange='checkTotal()' $checkboxState></td>";
                            echo "</tr>";
                            echo "<tr class='descRow'><td colspan='4' style='padding: 0px'><p>".$row->course_desc."</p></td></tr>";
                        }
                        ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td></td>
                                <td>Completed Hours</td>
                                <td><input type="text" name="total" value="0" readonly></td>
                                <td><button type="submit" class="btn btn-default" name="submit" value="submit">Save Finished</button></td>
                            </tr>
                        </tfoot>
                    </table>
                </form>
            </main><!-- .site-main -->
        </div><!-- .content-area -->
    </div>
</body>
<?php get_footer(); ?>

