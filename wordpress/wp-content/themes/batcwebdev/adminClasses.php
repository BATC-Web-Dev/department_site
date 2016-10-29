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
if (isset($_POST['submit'])) {
    $id = $_POST['submit'];
    $wpdb->delete( 'wp9c_class', array( 'ID' => $id ) );
    $wpdb->delete( 'wp9c_classes', array( 'class_id' => $id ) );
    echo "<script>alert('Class Removed From Table')</script>";

}
?>
<body>
<script type="text/javascript">
    var $jq = jQuery.noConflict();

    //Change the color of the tr based on the class type
    $jq(document).ready(function() {
        //Core
        $jq(".classType1").css("color", "Black");
        //Digital Media
        $jq(".classType2").css("color", "DarkBlue");
        //Front End
        $jq(".classType3").css("color", "DarkRed");
        //Backend
        $jq(".classType4").css("color", "DarkOrange");
        //Web Organization
        $jq(".classType5").css("color", "DarkViolet");
        //Electives
        $jq(".classType6").css("color", "Green");
        //Stripe
        $jq( "tr:odd" ).css( "background-color", "#C9C9C9" );
        //Hide save table sort button
        $jq("#save-sort-class-btn").hide();
        $jq("#classTable .index").hide();
        $jq("#classTable .position-header").hide();
        $jq("#classTable .edit-header").show();
        $jq("#classTable .remove-header").show();

        $jq( "#add-class-btn" ).click(function() {
            var classModal = $jq('#class-modal');
            $jq(".modal-title").text("Add Class");
            $jq(".modal-footer #add").show();
            $jq(".modal-footer #edit").hide();
            $jq(classModal.find('#courseId').val(''));
            $jq(classModal.find('#courseName').val(''));
            $jq(classModal.find('#hours').val(''));
            $jq(classModal.find("#comment").val(''));
            $jq(classModal.find("#sel1").val(1));
            $jq(classModal).appendTo('body');
        });

        $jq( ".edit" ).click(function() {
            var classModal = $jq('#class-modal');
            $jq(".modal-title").text("Edit Class");
            $jq(".modal-footer #edit").show();
            $jq(".modal-footer #add").hide();
            var tr = $jq(this).closest('tr');
            var courseID = tr.find('td:eq(1)').text();
            $jq(classModal.find('#courseId').val(courseID));
            var courseName = tr.find('td:eq(2)').text();
            $jq(classModal.find('#courseName').val(courseName));
            var hours = tr.find('td:eq(3)').text();
            $jq(classModal.find('#hours').val(hours));
            var description = tr.next('tr').text();
            $jq(classModal.find("#comment").val(description));
            var classType = tr.find(".class_type").val();
            $jq(classModal.find("#sel1").val(classType));
            var id = tr.find(".ID").val();
            $jq(classModal.find("#id").val(id));
            $jq(classModal).modal('show');
        });

        $jq( "#sort-class-btn" ).click(function() {
            $jq("#save-sort-class-btn").show();
            $jq("#sort-class-btn").hide();
            $jq("#add-class-btn").hide();
            $jq("#classTable .descRow").hide();
            $jq("#classTable .index").show();
            $jq("#classTable .position-header").show();
            $jq("#classTable .edit-header").hide();
            $jq("#classTable .remove-header").hide();
            $jq("#classTable .edit-td").hide();
            $jq("#classTable .delete-td").hide();

            var fixHelperModified = function(e, tr) {
                    var $originals = tr.children();
                    var $helper = tr.clone();
                    $helper.children().each(function(index) {
                        $jq(this).width($originals.eq(index).width())
                    });
                    return $helper;
                },
                updateIndex = function(e, ui) {
                    $jq('td.index', ui.item.parent()).each(function (i) {
                        $jq(this).html(i + 1);
                    });
                };

            $jq("#tableBody").sortable({
                items: "tr",
                helper: fixHelperModified,
                stop: updateIndex
            }).disableSelection();

            $jq("#save-sort-class-btn").click(function() {
                var data = [];
                $jq( ".ID" ).each(function( index ) {
                    data.push($jq(this).val());
                });
                $jq.post("/test/position",{'position': data},function(data) {
                    location.reload();
                });
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
            <div class="row">
                <button type="button" class="btn btn-info col-sm-2 pull-right" data-toggle="modal" id="add-class-btn" data-target="#class-modal">Add Class</button>
                <button type="button" class="btn btn-default col-sm-2" id="sort-class-btn">Sort Table</button>
                <button type="button" class="btn btn-info col-sm-2" id="save-sort-class-btn">Save Table Order</button>
                <ul class="color-key col-sm-10"><!-- Change the class color key here-->
                    Class Type Color Codes:
                    <li style="color: Black">Core,</li>
                    <li style="color: DarkBlue">Digital Media,</li>
                    <li style="color: DarkRed">Front End Development</li>
                    <li style="color: DarkOrange">Backend Development</li>
                    <li style="color: DarkViolet">Web Site Organization</li>
                    <li style="color: Green">Front End Development</li>
                </ul>
            </div>
                <table id="classTable" class="table responsive">
                    <thead>
                    <tr class="header">
                        <th class="position-header">Position</th>
                        <th>Course ID</th>
                        <th>Course Name</th>
                        <th>Hours</th>
                        <th class="edit-header">Edit</th>
                        <th class="remove-header">Remove</th>
                    </tr>
                    </thead>
                    <tbody id="tableBody">
                    <?php
                    global $wpdb;
                    $count = 1;
                    $currentUser = get_current_user_id();
                    $result = $wpdb->get_results("SELECT * FROM wp9c_class ORDER BY position ASC");
                    //TODO: add error checking for database call
                    foreach($result as $row) {
                            echo "<tr id='position_$count' class='classType$row->class_type'>";
                            echo "<td class='index'></td>";
                            echo "<input type='hidden' value='$row->ID' class='ID'>";
                            echo "<input type='hidden' class='class_type' value='$row->class_type'>";
                            echo "<input type='hidden' name='class_type[]' value='$row->class_type'>";
                            echo "<td><p>".$row->course_id."</p></td>";
                            echo "<input type='hidden' name='class_id[]' value='$row->class_id'>";
                            echo "<td><p>".$row->course_name."</p></td>";
                            echo "<td id='hours'><p>".$row->hours."</p></td>";
                            echo "<input type='hidden' value='0' name='checkbox[]'>";
                            echo "<td class='edit-td'><button type='button' class='btn btn-default edit' id='edit-class-btn' data-target=#class-modal'>Edit</button></td>";
                            echo "<td class='delete-td'><button type='submit' class='btn btn-danger' name='submit' id='delete' data-record-title='$row->course_name' data-record-id='$row->ID' data-toggle='modal' data-target='#confirm-delete'>Delete</button></td>";
                            echo "</tr>";
                            echo "<tr class='descRow'><td colspan='5''><div><p>".$row->course_desc."</p></div></td></tr>";
                        $count = $count + 1;
                    }
                    ?>
                    </tbody>
                    <tfoot>
                    </tfoot>
                </table>

            <!--Form Modal -->
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
                            <form class="form-horizontal" id="classForm" method="post" action="">
                                <div class="form-group">
                                    <input type="hidden" id="id" value="">
                                    <label for="courseId">Class ID: </label>
                                    <span class="error">*</span>
                                    <input type="text" name="courseId" value="" class="form-control" id="courseId" placeholder="Enter Class ID">
                                </div>
                                <div class="form-group">
                                    <label for="courseName">Class Name: </label>
                                    <span class="error">*</span>
                                    <input type="text" name="courseName" value="" class="form-control" id="courseName" placeholder="Enter Class Name">
                                </div>
                                <div class="form-group">
                                    <label for="comment">Class Description:</label>
                                    <textarea class="classForm" rows="5" id="comment" name="courseDesc" placeholder="Description:"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="courseName">Hours: </label>
                                    <span class="error">*</span>
                                    <input type="text" name="hours" value="" class="form-control" id="hours" placeholder="Enter Class Hours">
                                </div>
                                <div class="form-group">
                                    <label for="sel1">Class Type:</label>
                                    <select class="form-control" id="sel1" name="classType">
                                        <option value="1">Core</option>
                                        <option value="2">Digital Media</option>
                                        <option value="3">Front End Development</option>
                                        <option value="4">Backend Development</option>
                                        <option value="5">Website Organization</option>
                                        <option value="6">General Electives</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-default" id="edit">Edit Class</button>
                            <button type="submit" class="btn btn-default" id="add">Add Class</button>
                        </div>
                    </div>
                </div>
            </div><!--Modal-->

            <!-- Delete Confirm Modal-->
            <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
                        </div>
                        <div class="modal-body">
                            <p>You are about to delete <b><i class="title"></i></b> record, this procedure is irreversible.</p>
                            <p>Do you want to proceed?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-danger btn-ok">Delete</button>
                        </div>
                    </div>
                </div>
            </div>
        </main><!-- .site-main -->
    </div><!-- .content-area -->
</div><!--container-->
</body>
<script>
    jQuery(document).ready(function($) {
        jQuery('#add').on('click', function() {
            jQuery.post("/test/addclass",$('#classForm').serialize(),function(data){
                jQuery('#class-modal').modal('toggle');

                location.reload();
            });
            return false;
        });

        jQuery('#edit').on('click', function() {
            var data = $('#classForm').serializeArray();
            var id = $('#id').val();
            data.push({name: 'ID', value: id});
            jQuery.post("/test/editClass",data,function(data){
                jQuery('#class-modal').modal('toggle');
                location.reload();
            });
            return false;
        });

        jQuery('#confirm-delete').on('click', '.btn-ok', function(e) {
            var id = $(this).data('recordId');
            var data = [];
            data.push({name: 'ID', value: id});
            // $.ajax({url: '/api/record/' + id, type: 'DELETE'})
            jQuery.post("/test/deleteClass",data,function(data) {
                location.reload();
            });
        });

        jQuery('#confirm-delete').on('show.bs.modal', function(e) {
            jQuery(".modal-title").text("Delete Class");
            var data = $(e.relatedTarget).data();
            jQuery('.title', this).text(data.recordTitle);
            jQuery('.btn-ok', this).data('recordId', data.recordId);
            console.log($('.btn-ok', this).data('recordId', data.recordId));
        });
    });
</script>
<?php get_footer(); ?>

