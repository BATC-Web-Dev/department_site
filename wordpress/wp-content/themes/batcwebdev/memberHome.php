<?php
/*
Template Name: memberHome
*/
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package BATCWebDev
 */
get_header(); ?>
<div class="member-home container-fluid">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<div class="row">
				<div class="col-md-12 lead">Member Home<hr></div>
			</div>

			<div class="row">

				<div class="col-md-6 col-sm-12 well" id="member_profile">

			<?php
			if ( is_user_logged_in() ):
				$current_user = wp_get_current_user();
				if (isset ($_POST['view-profile']) && $current_user->ID != $_POST['view-profile']) {
					$member_id = $_POST['view-profile'];
					$profile_viewing = get_user_by('ID', $member_id);
					$welcome_message = "$profile_viewing->display_name's profile";
					$avatar_header = "$profile_viewing->display_name's Avatar";
					$bio_header = "$profile_viewing->display_name's Bio";
					$profile_button = "<a href='?page_id=66'><big>Your Profile</big></a><br>";
				}
				else {
					$profile_viewing = $current_user;
					$welcome_message = $current_user->display_name;
					$avatar_header = "Your Avatar";
					$bio_header = "Your Bio";
					$profile_button = "<a data-toggle='modal' data-target='#approve-profile-modal'>Edit Profile</a><br>";
				}
					
				if ( ($profile_viewing instanceof WP_User) ) {
					echo "<div class='avatar col-sm-6 col-md-4' id='bio_avatar'><div class='center'>"
						. get_avatar( $profile_viewing->user_email, 200 );
					
						echo $profile_button;
						echo "<a data-toggle='modal' data-target='#other-members-modal'>Other Members</a>
							<p>
							$profile_viewing->user_spec<br>
							$profile_viewing->user_job
							</p>
							</div>
							</div>";
					echo "<div class='col-sm-6 col-md-8'>";

					echo "<h3>$welcome_message</h3>
							<p>$profile_viewing->description</p>
							<div class='list-group'>
							<a class='list-group-item'><i class='glyphicon glyphicon-envelope'>  $profile_viewing->user_email</i></a>
							<a class='list-group-item' href='$profile_viewing->user_url'><i class='glyphicon glyphicon-globe'> $profile_viewing->user_url</i></a>
							<a class='list-group-item' href='$profile_viewing->user_url_2'><i class='glyphicon glyphicon-globe'> $profile_viewing->user_url_2</i></a>
							<a class='list-group-item' href='$profile_viewing->user_url_3'><i class='glyphicon glyphicon-globe'> $profile_viewing->user_url_3</i></a>
						</div>
						</div>";
				}
			endif;
			?>
				</div>

				<div class="col-md-6 col-sm-12"><!--First Column-->
					<h3>Recent Posts</h3>
					<div class="list-group">
						<?php
						$args = array( 'numberposts' => '5' );
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
			<div class="row">
				<div class="col-md-6"><!--Second Column-->
					<h3>Recent Forum Replies</h3>
					<div class="list-group">
					<?php
						global $wpdb;
						$query="SELECT post_parent FROM wp_posts WHERE post_type='reply' ORDER BY post_date DESC LIMIT 5";
						$results=$wpdb->get_results($query);
						//print_r($reply_parent);
						foreach ($results as $result) {
							$query="SELECT post_title, post_name FROM wp_posts WHERE ID=$result->post_parent LIMIT 1";
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
						$query="SELECT * FROM wp_posts WHERE post_type='topic' ORDER BY post_date DESC LIMIT 5";
						$results=$wpdb->get_results($query);
						foreach ($results as $result) {
							echo "<a class='list-group-item' href='?topic=$result->post_name'>$result->post_title</a>";
						}
						?>
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
<!-- start of profile form handling -->
<?php
global $wpdb;
$results = $wpdb->get_results("SELECT * FROM notifications WHERE student_id=$current_user->ID");
$update_user = $results[0];
if (isset ($_POST['approve-profile-submit'])) {
			
	$new_description = stripslashes($_POST["new_description"]);
    $new_user_url = ($_POST["new_user_url"]);
    $new_user_url_2 = ($_POST["new_user_url_2"]);
    $new_user_url_3 = ($_POST["new_user_url_3"]);
    $new_user_job = stripslashes($_POST["new_user_job"]);
    $new_user_spec = stripslashes($_POST["new_user_spec"]);


// update the request
	// create row if doesn't exist
	if (!$update_user->student_id) {
		$updated = $wpdb->insert('notifications', array('student_id' => $current_user->ID), array('%d') );
	}
		//new_description
		if ($new_description != $_POST['old_description']) {
			$updated = $wpdb->update('notifications', array('new_description' => $new_description), array('student_id' => $current_user->ID) );
		}
			
		//new_url
		if ($new_user_url != $_POST['old_user_url']) {
			$updated = $wpdb->update('notifications', array('new_url' => $new_user_url), array('student_id' => $current_user->ID) );
		}
		//new_url_2
		if ($new_user_url_2 != $_POST['old_user_url_2']) {
			$updated = $wpdb->update('notifications', array('new_url_2' => $new_user_url_2), array('student_id' => $current_user->ID) );
		}
		
		//new_url_3
		if ($new_user_url_3 != $_POST['old_user_url_3']) {
			$updated = $wpdb->update('notifications', array('new_url_3' => $new_user_url_3), array('student_id' => $current_user->ID) );
		}
		
		//new_job
		if ($new_user_job != $_POST['old_user_job']) {
			$updated = $wpdb->update('notifications', array('new_job' => $new_user_job), array('student_id' => $current_user->ID) );
		}
		
		//new_spec
		if ($new_user_spec != $_POST['old_user_spec']) {
			$updated = $wpdb->update('notifications', array('new_spec' => $new_user_spec), array('student_id' => $current_user->ID) );
		}
	
	// delete row from table if all fields are blank
	if ($new_description == '' 
			&& $new_user_url != ''
			&& $new_user_url_2 != ''
			&& $new_user_url_3 != ''
			&& $new_user_job != ''
			&& $new_user_spec != '')
	{
		$updated = $wpdb->delete('notifications', array('student_id' => $current_user->ID) );	
	}
		
} // end of if isset submit

if (isset ($_POST['approve-profile-reset'])) {
	$updated = $wpdb->delete('notifications', array('student_id' => $current_user->ID) );
	
}
?>
<!-- end of profile form handling -->
			

	<!-- start of edit profile form modal -->
	<?php
	global $wpdb;
	$results = $wpdb->get_results("SELECT * FROM notifications WHERE student_id=$current_user->ID");
	$update_user = $results[0];
	
	$old_meta = $wpdb->get_results("SELECT meta_key, meta_value 
									FROM wp_usermeta 
									WHERE user_id=$current_user->ID 
									AND (meta_key='description'
									OR meta_key='user_url_2'
									OR meta_key='user_url_3'
									OR meta_key='user_job'
									OR meta_key='user_spec')
									");
	$old_user_data = $wpdb->get_results("SELECT display_name, user_email, user_url, ID FROM wp_users WHERE ID=$current_user->ID");
		
	foreach ($old_meta as $meta) {
		if ($meta->meta_key == 'description') $old_data->description = $meta->meta_value;
		if ($meta->meta_key == 'user_url_2') $old_data->user_url_2 = $meta->meta_value;
		if ($meta->meta_key == 'user_url_3') $old_data->user_url_3 = $meta->meta_value;
		if ($meta->meta_key == 'user_job') $old_data->user_job = $meta->meta_value;
		if ($meta->meta_key == 'user_spec') $old_data->user_spec = $meta->meta_value;
	}
	$old_data->display_name = $old_user_data[0]->display_name;
	$old_data->user_email = $old_user_data[0]->user_email;
	$old_data->user_url = $old_user_data[0]->user_url;
	$old_data->ID = $old_user_data[0]->ID;

	
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
			$description_label = "Biographical Info - <a>delete</a>";
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
			<input type='hidden' name='old_description' value='<?php echo $old_data->description; ?>'>
			<input type='hidden' name='old_user_url' value='<?php echo $old_data->user_url; ?>'>
			<input type='hidden' name='old_user_url_2' value='<?php echo $old_data->user_url_2; ?>'>
			<input type='hidden' name='old_user_url_3' value='<?php echo $old_data->user_url_3; ?>'>
			<input type='hidden' name='old_user_job' value='<?php echo $old_data->user_job; ?>'>
			<input type='hidden' name='old_user_spec' value='<?php echo $old_data->user_spec; ?>'>
	</div> <!-- end of form group -->
    
                    </div> <!-- end of modal-body -->
                    <div class="modal-footer">
                        <button type="submit" name="approve-profile-submit">Submit for Approval</button>
                        <button type="reset" name="approve-profile-reset">reset</button>
                    </div>
                </div>
            </div>
        </div><!--Modal-->
    </form>
<!-- end of edit profile form modal -->

	<!--Form Modal -->
	<form class="form-horizontal" id="viewProfileForm" method="post" action="">
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
		</main><!-- #main -->
	</div><!-- #primary -->
</div>

<?php
get_footer();
