<?php
/*
Template Name: admin-home
*/

/**
 * @package BATCWebDev
 * @subpackage batcitweb
 */
?>
<?php
if ( is_user_logged_in() ) {
	$current_user = wp_get_current_user();
	if ( in_array( 'administrator', (array) $current_user->roles ) ) {
?>
<?php get_header(); ?>

<script>
 jQuery(document).ready(function( $ ) {
	$(".toggler").click(function(e){
        e.preventDefault();
        $('.cat'+$(this).attr('toggle_id')).toggle();
    });

	$(".check-all").change(function () {
		$(this).closest("table").find("input:checkbox").prop('checked', $(this).prop("checked"));
	});
	
	$(".is_checked").change(function () {
		var table = $(this).closest("table");
		if ($(":checkbox", table).is(":checked")) {
			$(this).closest("table").find(".approve_selected_button").prop('value', 'approve selected');
		}
		else {
			$(this).closest("table").find(".approve_selected_button").prop('value', 'deny all');
		}
	});
	
 });
</script>

<!-- start of notifications -->
<?php

	global $wpdb;
$notifications = $wpdb->get_results("
				SELECT 
					wp9c_notifications.notify_id,
					wp9c_users.display_name,
					wp9c_users.user_email
				FROM 
					wp9c_notifications 
				INNER JOIN 
					wp9c_users 
				ON 
					wp9c_notifications.student_id = wp9c_users.ID
				");
?>
		<div class="member-home container-fluid">
            <div class="row">
                <div class="col-md-12 lead">Admin Home<hr></div>
            </div>
	<table id="approve-deny-table-list" class="table">
	<thead>
		<tr class="header">
			<th>Pending Notifications</th>

		</tr>
	</thead>
	<tbody>
<?php
	if (!$notifications) {echo "<table class='approve-deny-table-single'><tr><td>There are no notifications pending.</td></tr></table>";}
foreach ($notifications as $row) {
	
	$results = $wpdb->get_results("SELECT * FROM wp9c_notifications WHERE notify_id=$row->notify_id");
	
	$new_data->email = ($results[0]->new_email == '' ? null : $results[0]->new_email);
	$new_data->url = ($results[0]->new_url == '' ? null : $results[0]->new_url);
	$new_data->url_2 = ($results[0]->new_url_2 == '' ? null : $results[0]->new_url_2);
	$new_data->url_3 = ($results[0]->new_url_3 == '' ? null : $results[0]->new_url_3);
	$new_data->description = ($results[0]->new_description == '' ? null : $results[0]->new_description);
	$new_data->job = ($results[0]->new_job == '' ? null : $results[0]->new_job);
	$new_data->spec = ($results[0]->new_spec == '' ? null : $results[0]->new_spec);

	$ID = $results[0]->student_id;
	$old_meta = $wpdb->get_results("SELECT meta_key, meta_value 
									FROM wp9c_usermeta 
									WHERE user_id=$ID 
									AND (meta_key='description'
									OR meta_key='user_url_2'
									OR meta_key='user_url_3'
									OR meta_key='user_job'
									OR meta_key='user_spec')
									");
									
	foreach ($old_meta as $meta) {
		if ($meta->meta_key == 'description') $old_data->description = $meta->meta_value;
		if ($meta->meta_key == 'user_url_2') $old_data->url_2 = $meta->meta_value;
		if ($meta->meta_key == 'user_url_3') $old_data->url_3 = $meta->meta_value;
		if ($meta->meta_key == 'user_job') $old_data->job = $meta->meta_value;
		if ($meta->meta_key == 'user_spec') $old_data->spec = $meta->meta_value;
	}
		
	$old_user_data = $wpdb->get_results("SELECT display_name, user_email, user_url, ID FROM wp9c_users WHERE ID=$ID");
		
	$old_data->display_name = $old_user_data[0]->display_name;
	$old_data->email = $old_user_data[0]->user_email;
	$old_data->url = $old_user_data[0]->user_url;
	$old_data->ID = $old_user_data[0]->ID;


	// counts pending changes for current student
	$num_pending = 0;
	foreach($new_data as $data) {
		if ($data != null) $num_pending++;
	}
	
	// add 's' if plural
	$plural = ($num_pending == 1 ? '' : 's');
	
	
	if (isset($_POST['approve' . $row->notify_id])) {
		
		if (isset($_POST['description'])) {
			update_user_meta( 
						$old_data->ID, 
						'description', 
						$new_data->description
			);
		}

		if (isset($_POST['url'])) {
			$updated = $wpdb->update( 
						wp9c_users,
						array( 
							user_url => $new_data->url, 
						),
						array(
							'ID' => $old_data->ID,
						)
			);
		}

		if (isset($_POST['url_2'])) {
			update_user_meta( 
						$old_data->ID, 
						'user_url_2', 
						$new_data->url_2
			);
		}

		if (isset($_POST['url_3'])) {
			update_user_meta( 
						$old_data->ID, 
						'user_url_3', 
						$new_data->url_3
			);
		}

		if (isset($_POST['job'])) {
			update_user_meta( 
						$old_data->ID, 
						'user_job', 
						$new_data->job
			);
		}

		if (isset($_POST['spec'])) {
			update_user_meta( 
						$old_data->ID, 
						'user_spec', 
						$new_data->spec
			);
		}

		$updated = $wpdb->delete('wp9c_notifications', array('student_id' => $old_data->ID) );
		
	}
	
	//display row if not empty
	if ($num_pending != 0) {
	?>	<tr class='body'>
	<?php echo "<td class='notify_summary'><a class='toggler' toggle_id='$row->notify_id' class='table'><span class='alignleft'>".get_avatar($row->user_email, 20)."</span>$row->display_name has $num_pending update$plural pending approval.</a>"; ?>
	<table class="approve-deny-table-single">
	<form method='post' action=''>
    <thead>
		<tr class='header cat<?php echo "$row->notify_id";?>' style='display:none'>
            <th>Field</th>
            <th>From</th>
            <th>To</th>
			<th>Selected</th>
		</tr>
    </thead>
	<tbody>
	<?php if ($new_data->description) { ?>
			<tr class='cat<?php echo "$row->notify_id";?>' style='display:none'>
				<td>
				Bio
				</td>
				<td>
				<?php echo "$old_data->description"; ?>
				</td>
				<td>
				<?php echo "$new_data->description"; ?>
				</td>
				<td>
				<input type='checkbox' class='is_checked' toggle_id='checkbox<?php echo "$row->notify_id";?>' name='description' value='description'>select
				</td>
			</tr>
	<?php } // end if ?>
	<?php if ($new_data->url) { ?>
			<tr class='cat<?php echo "$row->notify_id";?>' style='display:none'>
				<td>
				Primary Website
				</td>
				<td>
				<?php echo "$old_data->url"; ?>
				</td>
				<td>
				<?php echo "$new_data->url"; ?>
				</td>
				<td>
				<input type='checkbox' class='is_checked' toggle_id='checkbox<?php echo "$row->notify_id";?>' name='url' value='url'>select
				</td>
			</tr>
	<?php } // end if ?>
	<?php if ($new_data->url_2) { ?>
			<tr class='cat<?php echo "$row->notify_id";?>' style='display:none'>
				<td>
				Second Website
				</td>
				<td>
				<?php echo "$old_data->url_2"; ?>
				</td>
				<td>
				<?php echo "$new_data->url_2"; ?>
				</td>
				<td>
				<input type='checkbox' class='is_checked' toggle_id='checkbox<?php echo "$row->notify_id";?>' name='url_2' value='url_2'>select
				</td>
			</tr>
	<?php } // end if ?>
	<?php if ($new_data->url_3) { ?>
			<tr class='cat<?php echo "$row->notify_id";?>' style='display:none'>
				<td>
				Third Website
				</td>
				<td>
				<?php echo "$old_data->url_3"; ?>
				</td>
				<td>
				<?php echo "$new_data->url_3"; ?>
				</td>
				<td>
				<input type='checkbox' class='is_checked' toggle_id='checkbox<?php echo "$row->notify_id";?>' name='url_3' value='url_3'>select
				</td>
			</tr>
	<?php } // end if ?>
	<?php if ($new_data->job) { ?>
			<tr class='cat<?php echo "$row->notify_id";?>' style='display:none'>
				<td>
				Employment
				</td>
				<td>
				<?php echo "$old_data->job"; ?>
				</td>
				<td>
				<?php echo "$new_data->job"; ?>
				</td>
				<td>
				<input type='checkbox' class='is_checked' toggle_id='checkbox<?php echo "$row->notify_id";?>' name='job' value='job'>select
				</td>
			</tr>
	<?php } // end if ?>
	<?php if ($new_data->spec) { ?>
			<tr class='cat<?php echo "$row->notify_id";?>' style='display:none'>
				<td>
				Specialization
				</td>
				<td>
				<?php echo "$old_data->spec"; ?>
				</td>
				<td>
				<?php echo "$new_data->spec"; ?>
				</td>
				<td>
				<input type='checkbox' class='is_checked' toggle_id='checkbox<?php echo "$row->notify_id";?>' name='spec' value='spec'>select
				</td>
			</tr>
	<?php } // end if ?>
        </tbody>
		<tfoot>
			<tr class='cat<?php echo "$row->notify_id";?>' style='display:none'>
				<td></td>
				<td></td>
				<td><input type='submit' class='btn btn-default btn-lg approve_selected_button' name='<?php echo "approve$row->notify_id";?>' value='<?php echo "deny all";?>'></td>
				<td><input type='checkbox' class='check-all is_checked' value='check-all'>select all</td>
			</tr>
		</tfoot>
		</form>
		</table><!-- approve-deny-table-single -->
		</td></tr>
		<?php
	} // end of if(num_pending != 0)
} // end of foreach

?>
</tbody>

</table> <!-- approve-deny-table-list -->

<!-- Bio Data -->
<script>
	jQuery(document).ready(function( $ ) {
		$( ".external-link" ).click(function() {
			var external_href = $(this).prop('id');
			var modal = $('#external-link-modal');
			var href_external = $(modal.find("#external_href"));
			$(href_external).prop('href', external_href);
		});
	});
            
</script>

<div class='header cat-bio-data'>
    <div class="row">

        <div class="col-md-6 col-sm-12 well" id="member_profile">
            <div class='list-group'>

                <?php
                if ( is_user_logged_in() ):
                    $current_user = wp_get_current_user();
                    if (isset ($_POST['view-profile']) && $current_user->ID != $_POST['view-profile']) {
                        $member_id = $_POST['view-profile'];
                        $profile_viewing = get_user_by('ID', $member_id);
                        $welcome_message = "$profile_viewing->display_name's profile";
                        $avatar_header = "$profile_viewing->display_name's Avatar";
                        $bio_header = "$profile_viewing->display_name's Bio";
                        $profile_button = "<a class='list-group-item' href='?page_id=66'><big>Your Profile</big></a><br>";
                    }
                    else {
                        $profile_viewing = $current_user;
                        $welcome_message = $current_user->display_name;
                        $avatar_header = "Your Avatar";
                        $bio_header = "Your Bio";
                        $profile_button = "<a class='list-group-item list-group-item-info' data-toggle='modal' data-target='#approve-profile-modal'>Edit Profile</a><br>";
                    }

                    if ( ($profile_viewing instanceof WP_User) ) {
                        echo "<div class='avatar col-sm-6 col-md-4' id='bio_avatar'><div class='center'>"
                            . get_avatar( $profile_viewing->user_email, 200 );

                        echo $profile_button;
                        echo "<a class='list-group-item list-group-item-info' data-toggle='modal' data-target='#other-members-modal'>Other Members</a>
							<li class='list-group-item'>$profile_viewing->user_spec</li>
							<li class='list-group-item'>$profile_viewing->user_job</li>
							</div>
							</div>
							</div>";
                        echo "<div class='col-sm-6 col-md-8'>";

                        // adding http:// to the url if neither http:// nor https:// is present
                        if (!preg_match('#http://#', $profile_viewing->user_url) && !preg_match('#https://#', $profile_viewing->user_url)) {$qualify_url = 'http://' . $profile_viewing->user_url;}
                        else {$qualify_url = $profile_viewing->user_url;}
                        if ($qualify_url == null) {$qualify_url = "#";}
                        // adding http:// to the url if neither http:// nor https:// is present
                        if (!preg_match('#http://#', $profile_viewing->user_url_2) && !preg_match('#https://#', $profile_viewing->user_url_2)) {$qualify_url_2 = 'http://' . $profile_viewing->user_url_2;}
                        else {$qualify_url_2 =  $profile_viewing->user_url_2;}
                        if ($qualify_url_2 == null) {$qualify_url_2 = "#";}
                        // adding http:// to the url if neither http:// nor https:// is present
                        if (!preg_match('#http://#', $profile_viewing->user_url_3) && !preg_match('#https://#', $profile_viewing->user_url_3)) {$qualify_url_3 = 'http://' . $profile_viewing->user_url_3;}
                        else {$qualify_url_3 =  $profile_viewing->user_url_3;}
                        if ($qualify_url_3 == "http://") {$qualify_url_3 = "#";}

                        echo "<h3>$welcome_message</h3>
							<p>$profile_viewing->description</p>
							<div class='list-group'>
							<li class='list-group-item active'><i class='glyphicon glyphicon-envelope'>  $profile_viewing->user_email</i></li>";
                        if ($profile_viewing->user_url != null) {
                            echo "<a class='list-group-item external-link' id='$qualify_url' data-toggle='modal' data-target='#external-link-modal'><i class='glyphicon glyphicon-globe'> $profile_viewing->user_url</i></a>";
                        }
                        if ($profile_viewing->user_url_2 != null) {
                            echo "<a class='list-group-item external-link' id='$qualify_url_2' data-toggle='modal' data-target='#external-link-modal'><i class='glyphicon glyphicon-globe'> $profile_viewing->user_url_2</i></a>";
                        }
                        if ($profile_viewing->user_url_3 != null) {
                            echo "<a class='list-group-item external-link' id='$qualify_url_3' data-toggle='modal' data-target='#external-link-modal'><i class='glyphicon glyphicon-globe'> $profile_viewing->user_url_3</i></a>";
                        }
                        echo "</div></div>";
                    }
                endif;
                ?>
            </div>

		<div class="col-md-6 col-sm-12"><!--First Column-->
			<h3>Recent Posts</h3>
			<div class="list-group">
				<?php
                $args = array(
                    'numberposts' => '5',
                    'post_status' =>'publish');
				$recent_posts = wp_get_recent_posts( $args );
				foreach( $recent_posts as $recent ){
					echo '<li class="list-group-item"><a href="' . get_permalink($recent["ID"]) . '">' .   $recent["post_title"].'</a> </li> ';
				}
				wp_reset_query();
				?>
			</div>
		</div>

	</div>
</div>

<!-- Forum Data -->

<div class="row">
    <div class="col-md-6"><!--Second Column-->
        <h3>Recent Forum Replies</h3>
        <div class="list-group">
        <?php
            global $wpdb;
            $query="SELECT post_parent FROM wp9c_posts WHERE post_type='reply' ORDER BY post_date DESC LIMIT 5";
            $results=$wpdb->get_results($query);
            //print_r($reply_parent);
            foreach ($results as $result) {
                $query="SELECT post_title, post_name FROM wp9c_posts WHERE ID=$result->post_parent LIMIT 1";
                $reply_parents = $wpdb->get_results($query);
                //print_r($reply_parents);
                foreach($reply_parents as $reply_parent) {
                    echo "<a class='list-group-item' href='?topic=$reply_parent->post_name'>$reply_parent->post_title</a>";
                }
            }
            ?>
        </div>
    </div>
    <div class="col-md-6"><!--Third Column-->
        <h3>Recent Forum Topics</h3>
        <div class="list-group">
            <?php
            global $wpdb;
            $query="SELECT * FROM wp9c_posts WHERE post_type='topic' ORDER BY post_date DESC LIMIT 5";
            $results=$wpdb->get_results($query);
            foreach ($results as $result) {
                echo "<a class='list-group-item' href='?topic=$result->post_name'>$result->post_title</a>";
            }
            ?>
        </div>
    </div>
</div>
</div>
<?php
while ( have_posts() ) : the_post();
    // If comments are open or we have at least one comment, load up the comment template.
    if ( comments_open() || get_comments_number() ) :
        comments_template();
    endif;
endwhile; // End of the loop.
?>
<!--Form Modal -->
	<form class="form-horizontal" id="viewProfileForm" method="post" action="../member-home">
        <div id="other-members-modal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Other Members</h4>
                    </div>
                    <div class="modal-body">
                            <ul class="list-group">
                                <?php
								$members = get_users( 'orderby=display_name' );
								foreach ( $members as $member ) {
									if ($member->ID != $current_user->ID) {
										echo "<li class='list-group-item'><button type='submit' class='text_button' name='view-profile' value='" 
											. $member->ID . "'><div class='alignleft'>".get_avatar($member->user_email, 25)."</div>".$member->display_name . "</button></li>";
										}								
								}
								?>
							</ul>
                    </div>
                </div>
            </div>
        </div><!--Modal-->
    </form>
	
	<?php
	// update admin profile
	if (isset($_POST['profile-submit'])) {
		$new_description = stripslashes($_POST["new_description"]);
		$new_url = ($_POST["new_user_url"]);
		$new_url_2 = ($_POST["new_user_url_2"]);
		$new_url_3 = ($_POST["new_user_url_3"]);
		$new_job = stripslashes($_POST["new_user_job"]);
		$new_spec = stripslashes($_POST["new_user_spec"]);

		if ($new_description != '') {
			update_user_meta( 
						$current_user->ID, 
						'description', 
						$new_description
			);
		}

		if ($new_url != '') {
			$updated = $wpdb->update( 
						wp9c_users,
						array( 
							user_url => $new_url, 
						),
						array(
							'ID' => $current_user->ID,
						)
			);
		}

		if ($new_url_2 != '') {
			update_user_meta( 
						$current_user->ID, 
						'user_url_2', 
						$new_url_2
			);
		}

		if ($new_url_3 != '') {
			update_user_meta( 
						$current_user->ID, 
						'user_url_3', 
						$new_url_3
			);
		}

		if ($new_job != '') {
			update_user_meta( 
						$current_user->ID, 
						'user_job', 
						$new_job
			);
		}

		if ($new_spec) {
			update_user_meta( 
						$current_user->ID, 
						'user_spec', 
						$new_spec
			);
		}
	}
		?>
		<!-- start of edit profile form modal -->
	<?php
	global $wpdb;
	$results = $wpdb->get_results("SELECT * FROM wp9c_notifications WHERE student_id=$current_user->ID");
	$update_user = $results[0];
	?>
    <form class="form-horizontal" id="contactForm" method="post" action="">
        <div id="approve-profile-modal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Update Profile</h4>
                    </div>
                    <div class="modal-body">
                    <!-- start of description field -->
<script>
    jQuery(document).ready(function( $ ) {
        var approve_text_max = 140;
        $('#approve_textarea_feedback').html((approve_text_max - $('#new_description').val().length) + ' characters remaining. ');

        $('#new_description').keyup(function() {
            var approve_text_length = $('#new_description').val().length;
			var approve_text_remaining = approve_text_max - approve_text_length;

            $('#approve_textarea_feedback').html(approve_text_remaining + ' characters remaining. ');
        });
    });
</script>
			<?php
			$description_value = $update_user->new_description;
			$description_label = "Biographical Info";
			?>
			<div class="form-group">
				<label for="new_description"><?php echo( $description_label ); ?></label>
				<textarea class="form-control" name="new_description" id="new_description" rows="3" cols="10" maxlength="140" + 
				><?php echo esc_html( $description_value ); ?></textarea>
				<span><?php _e("Share a bio that could fit in a Tweet. "); ?></span><span id="approve_textarea_feedback">info</span>
			</div> <!-- end of form group -->		
	<!-- end of description field -->

	<!-- start of primary website field -->
	<?php
	$url_field = $update_user->new_url;
	$url_label = "Primary Website";
	?>
	
	<div class="form-group">
		<label for="new_user_url"><?php _e( $url_label ); ?></label>
		<input class="form-control" type="text" name="new_user_url" id="new_user_url" value="<?php echo esc_attr( $url_field ); ?>" class="regular-text" />
	</div> <!-- end of form group -->
	<!-- end of primary website field -->
	
	<!-- start of second website field -->
	<?php
	$url_2_field = $update_user->new_url_2;
	$url_2_label = "Second Website";
	?>
	
	<div class="form-group">
		<label for="new_user_url_2"><?php _e( $url_2_label ); ?></label>
		<input class="form-control" type="text" name="new_user_url_2" id="new_user_url_2" value="<?php echo esc_attr( $url_2_field ); ?>" class="regular-text" />
	</div> <!-- end of form group -->
	<!-- end of second website field -->
	
	<!-- start of third website field -->
	<?php
	$url_3_field = $update_user->new_url_3;
	$url_3_label = "Third Website";
	?>
	
	<div class="form-group">
		<label for="new_user_url_3"><?php _e( $url_3_label ); ?></label>
		<input class="form-control" type="text" name="new_user_url_3" id="new_user_url_3" value="<?php echo esc_attr( $url_3_field ); ?>" class="regular-text" />
	</div> <!-- end of form group -->
	<!-- end of third website field -->
	
	<!-- start of job field -->
	<?php
	$job_field = $update_user->new_job;
	$job_label = "Employment";
	?>
	
	<div class="form-group">
		<label for="new_user_job"><?php _e( $job_label ); ?></label>
		<input class="form-control" type="text" name="new_user_job" id="new_user_job" value="<?php echo esc_attr( $job_field ); ?>" class="regular-text" />
	</div> <!-- end of form group -->
	<!-- end of job field -->
	
	<!-- start of specialization field -->
	<?php
	$spec_field = $update_user->new_spec;
	$spec_label = "Specialization";
	?>
	<div class="form-group">
		<label for="new_user_spec"><?php _e( $spec_label ); ?></label>
			<select class="form-control" name="new_user_spec" id="new_user_spec">
				<option value=''>-select-one-</option>
				<option value='Undecided' 
					<?php if ($update_user->new_spec == 'Undecided') { echo "selected='selected'"; }?> >
					Undecided</option>
				<option value='Front-End' 
					<?php if ($update_user->new_spec == 'Front-End') { echo "selected='selected'"; }?> >
					Front End</option>
				<option value='Back-End' 
					<?php if ($update_user->new_spec == 'Back-End') { echo "selected='selected'"; }?> >
					Back End</option>
			</select>
	</div> <!-- end of form group -->
    
                    </div> <!-- end of modal-body -->
                    <div class="modal-footer">
						<button type="reset">Reset</button>
                        <button type="submit" name="profile-submit">Update Profile</button>
                    </div>
                </div>
            </div>
        </div><!--Modal-->
    </form>
<!-- end of edit profile form modal -->

			<!-- external-link-modal -->
			<div id="external-link-modal" class="modal fade" role="dialog">
				<div class="modal-dialog">
					<!-- Modal content-->
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">External Link</h4>
						</div>
						<div class="modal-body">
							<p>You are about to leave BATCWebDev.  Do you wish to continue?</p>
						</div> <!-- end of modal-body -->
						<div class="modal-footer">
							<button data-dismiss="modal">Stay</button>
							<button><a id='external_href' href='www.example.com'>Continue</a></button>
						</div>
					</div>
				</div>
			</div><!--Modal-->

		</main><!-- #main -->
	</div><!-- #primary -->
</div>

<?php get_footer(); ?>
<?php
	} // end of if administrator
	else {echo "You do not have access to this page.";}
} // end of if logged in
?>