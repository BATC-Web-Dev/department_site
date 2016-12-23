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
$checkFinishedArray = $_POST['checkboxFinished'];
$checkInterestedArray = $_POST['checkboxInterested'];

if (isset($_POST['submit'])) {
    for ($i = count($checkFinishedArray); $i >= 0; $i--) {
        if ($checkFinishedArray[$i] > 0) {
            $checkFinishedArray[$i] = 1;
        }
        if (($checkFinishedArray[$i] == 1) && ($checkFinishedArray[$i - 1] == 0)) {
            unset($checkFinishedArray[$i - 1]);
        }
    }
    for ($i = count($checkInterestedArray); $i >= 0; $i--) {
        if ($checkInterestedArray[$i] > 0) {
            $checkInterestedArray[$i] = 1;
        }
        if (($checkInterestedArray[$i] == 1) && ($checkInterestedArray[$i - 1] == 0)) {
            unset($checkInterestedArray[$i - 1]);
        }
    }
    $_POST['checkboxFinished'] = array_values($checkFinishedArray);
    for ($i=0; $i < count($_POST['checkboxFinished']); $i++) {
        $wpdb->update(
            'wp9c_classes',
            array(
                'finished' => $_POST['checkboxFinished'][$i],
            ),
            array( 'class_id' => $_POST['class_id'][$i] ),
            array(
                '%d'
            ),
            array( '%d' )
        );
    }
    $_POST['checkboxInterested'] = array_values($checkInterestedArray);
    for ($i=0; $i < count($_POST['checkboxInterested']); $i++) {
        $wpdb->update(
            'wp9c_classes',
            array(
                'interested' => $_POST['checkboxInterested'][$i],
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
            var finished = document.getElementById('finished');
            document.classForm.total.value = '';
            var sum = 0;
            for(i=0; i<object.length; i++) {
                if (object.name != 'checkbox') {
                    if (object[i].type == 'checkbox' && object[i].checked) {
                        sum = sum + parseInt(object[i].value);
                    }
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

            $('input.check').on('change', function() {
                $(this).closest('tr').find('input').not(this).prop('checked', false);
            });

            $(function() {
                $("td[colspan=5]").css('pointer-events', 'none');
                $("td[colspan=5]").find("p").hide();
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
                    <li style="color: Green">General Electives</li>
                    <li style="color: Gold">Design</li>
                </ul>
                <form name="classForm" method="post" action="<?php echo get_permalink(); ?>">
                    <table id="classTable" class="table">
                        <thead>
                            <tr class="header">
                                <th class="col-md-3 col-sm-3">Course ID</th>
                                <th class="col-md-5 col-sm-5">Course Name</th>
                                <th class="col-md-2 col-sm-2">Hours</th>
                                <th class="col-md-2 col-sm-2">Planning on Taking</th>
                                <th class="col-md-2 col-sm-2">Finished</th>
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
                            $checkboxFinishedQuery = intval($row->finished);
                            $checkboxInterestedQuery = intval($row->interested);
                            $checkboxState = '';
                            if ($checkboxFinishedQuery == 0){
                                $checkboxStateFinished = '';
                            } else {
                                $checkboxStateFinished = 'checked';
                            }
                            if ($checkboxInterestedQuery == 0){
                                $checkboxStateInterested = '';
                            } else {
                                $checkboxStateInterested = 'checked';
                            }
                            echo "<tr class='classType$row->class_type'>
                             <input type='hidden' name='class_type[]' value='$row->class_type'>
                            <td class='col-md-3 col-sm-3'><p>".$row->course_id."</p></td>
                            <input type='hidden' name='class_id[]' value='$row->class_id'>
                            <td class='col-md-5 col-sm-5'><p>".$row->course_name."</p></td>
                            <td class='col-md-2 col-sm-2' id='hours'><p>".$row->hours."</p></td>
                            <input type='hidden' value='0' name='checkboxInterested[]'>
                            <td class='col-md-2 col-sm-2'><input type='checkbox' value='$checkboxVal' name='checkboxInterested[]' onchange='checkTotal()' $checkboxStateInterested class='check'></td>
                            <input type='hidden' value='0' name='checkboxFinished[]'>
                            <td class='col-md-2 col-sm-2' id='finished'><input type='checkbox' value='$checkboxVal' name='checkboxFinished[]' onchange='checkTotal()' $checkboxStateFinished class='check'></td>
                            </tr>
                            <tr class='descRow'><td colspan='5' style='padding: 0px'><p>".$row->course_desc."</p></td></tr>";
                        }
                        ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class='col-md-3 col-sm-3'></td>
                                <td class='col-md-5 col-sm-5' style="text-align:right">Calculated Hours</td>
                                <td class='col-md-2 col-sm-2'><input id="compHours" type="text" name="total" value="0" readonly></td>
                                <td class='col-md-2 col-sm-2'></td>
                                <td class='col-md-2 col-sm-2'><button type="submit" class="btn btn-default btn-sm" name="submit" value="submit">Save</button></td>
                            </tr>
                        </tfoot>
                    </table>
                </form>
            </main><!-- .site-main -->
        </div><!-- .content-area -->
    </div>
</body>


