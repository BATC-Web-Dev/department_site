<?php
/*
Template Name: adminClasses
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
//TODO: add error checking for database call
if (isset($_POST['delete'])) {
    $id = $_POST['submit'];
    $wpdb->delete( 'class', array( 'ID' => $id ) );
    $wpdb->delete( 'classes', array( 'class_id' => $id ) );
    echo "<p>Class Removed From Table</p>";

}
?>
<body>
<script type="text/javascript">
    //Change the color of the tr based on the class type
    jQuery(document).ready(function( $ ) {
        //Core
        $(".classType1").css("color", "black");
        //Front-End
        $(".classType2").css("color", "blue");
        //Backend
        $(".classType3").css("color", "orange");
        //Stripe
        $( "tr:odd" ).css( "background-color", "#eee" );

        $(".modal-title").text("Edit Modal");

        $( "#add-class-btn" ).click(function() {
            var modal = $('#class-modal');
            $(".modal-title").text("Add Class");
            $(".modal-footer #add").show();
            $(".modal-footer #edit").hide();
            $(modal.find('#courseId').val(''));
            $(modal.find('#courseName').val(''));
            $(modal.find('#hours').val(''));
            $(modal.find("#comment").val(''));
            $(modal.find("#sel1").val(1));
            $(modal).modal('show');
        });

        $( ".edit" ).click(function() {
            var modal = $('#class-modal');
            $(".modal-title").text("Edit Class");
            $(".modal-footer #edit").show();
            $(".modal-footer #add").hide();
            var tr = $(this).closest('tr');
            var courseID = tr.find('td:eq(1)').text();
            $(modal.find('#courseId').val(courseID));
            var courseName = tr.find('td:eq(2)').text();
            $(modal.find('#courseName').val(courseName));
            var hours = tr.find('td:eq(3)').text();
            $(modal.find('#hours').val(hours));
            var description = tr.next('tr').text();
            $(modal.find("#comment").val(description));
            var classType = tr.find(".class_type").val();
            $(modal.find("#sel1").val(classType));
            var id = tr.find(".ID").val();
            $(modal.find("#ID").val(id));
            console.log(id);
            $(modal).modal('show');
        });
    });
</script>
<div class="container">
    <div id="primary">
        <main id="main" class="site-main" role="main">
            <div class="row">
                <div class="col-md-12 lead">Classes<hr></div>
            </div>
            <div class="row">
                <button type="button" class="btn btn-info col-sm-2" data-toggle="modal" id="add-class-btn">Add Class</button>
                <ul class="color-key col-sm-10"><!-- Change the class color key here-->
                    Class Type Color Codes:
                    <li style="color: black">Core,</li>
                    <li style="color: blue">Front-End,</li>
                    <li style="color: orange">Back-End</li>
                </ul>
            </div>
                <table id="classTable" class="table">
                    <thead>
                    <tr class="header">
                        <th>Edit</th>
                        <th>Course ID</th>
                        <th>Course Name</th>
                        <th>Hours</th>
                        <th>Remove</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    global $wpdb;
                    $currentUser = get_current_user_id();
                    $result = $wpdb->get_results("SELECT * FROM class");
                    //TODO: add error checking for database call
                    foreach($result as $row) {
                        echo "<tr class='classType$row->class_type'>";
                        echo "<input type='hidden' value='$row->ID' class='ID'>";
                        echo "<input type='hidden' class='class_type' value='$row->class_type'>";
                        echo "<td><button type='button' class='btn btn-default edit' id='edit-class-btn'>Edit</button>";
                        echo "<input type='hidden' name='class_type[]' value='$row->class_type'>";
                        echo "<td><p>".$row->course_id."</p></td>";
                        echo "<input type='hidden' name='class_id[]' value='$row->class_id'>";
                        echo "<td><p>".$row->course_name."</p></td>";
                        echo "<td id='hours'><p>".$row->hours."</p></td>";
                        echo "<input type='hidden' value='0' name='checkbox[]'>";
                        echo "<td><button type='button' class='btn btn-danger' name='delete' id='delete'>Delete</button></td>";
                        echo "</tr>";
                        echo "<tr class='descRow'><td colspan='5' style='padding: 0px'><p>".$row->course_desc."</p></td></tr>";
                    }
                    ?>
                    </tbody>
                    <tfoot>
                    </tfoot>
                </table>

            <!-- Modal -->
            <div id="class-modal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"></h4>
                        </div>
                        <div class="modal-body">
                            <p><span class="error">* required field.</span></p>
                            <form class="form-horizontal" id="classForm" method="post" action="?page_id=76">
                                <div class="form-group">
                                    <input type="text" value="<?php echo $ID; ?>" id="ID" readonly>
                                </div>
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
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-default" name="submit" id="edit">Edit Class</button>
                            <button type="submit" class="btn btn-default" name="submit" id="add">Add Class</button>
                        </div>
                    </div>
                </div>
            </div><!--Modal-->
        </main><!-- .site-main -->
    </div><!-- .content-area -->
</div><!--container-->
</body>
<script>
    /*jQuery(function () {
        $('#submit').on('click', function (e) {
            e.preventDefault();
            console.log($('#classForm').serialize());
        });
    });*/
    $(document).ready(function() {
        $('#add').on('click', function(msg) {
            alert($('#classForm').serialize()); // check to show that all form data is being submitted
            $.post("?page_id=76",$('#classForm').serialize(),function(data){
                alert(data); //post check to show that the mysql string is the same as submit
                $('#class-modal').modal('toggle');
                location.reload();
            });
            return false; // return false to stop the page submitting. You could have the form action set to the same PHP page so if people dont have JS on they can still use the form
        });

        $('#edit').on('click', function(msg) {
            alert($('#classForm').serialize()); // check to show that all form data is being submitted
            $.post("?page_id=76",$('#classForm').serialize(),function(data){
                alert(data); //post check to show that the mysql string is the same as submit
                $('#class-modal').modal('toggle');
                location.reload();
            });
            return false; // return false to stop the page submitting. You could have the form action set to the same PHP page so if people dont have JS on they can still use the form
        });
    });


</script>
<?php get_footer(); ?>

