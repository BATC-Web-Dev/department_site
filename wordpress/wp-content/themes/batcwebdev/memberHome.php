<?php
/*
Template Name: memberHome
*/
?>
<?php get_header(); ?>

	<div class="container-fluid">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<div class="row">
				<div class="col-md-12 lead">Member Home<hr></div>
			</div>
			<div class="row">
			
			
			<?php
			if ( is_user_logged_in() ):
				$current_user = wp_get_current_user();

				if ( ($current_user instanceof WP_User) ) {
					echo "<div class='center'><div class='col-sm-4 col-md-2'>". get_avatar( $current_user->user_email, 150 ).
					"<br><button>edit profile</button></div></div>";
					echo "<div class='col-sm-4 col-md-4'>";
					echo "<h3>Welcome:  $current_user->display_name</h3>";
					echo "<ul class='list-group'>
							<li class='list-group-item'>Email: $current_user->user_email</li>
							<li class='list-group-item'>Primary Website: $current_user->user_url</li>
							<li class='list-group-item'>Second Website: $current_user->user_url_2</li>
							<li class='list-group-item'>Third Website: $current_user->user_url_3</li>
							<li class='list-group-item'>Employment: $current_user->user_job</li>
							<li class='list-group-item'>Specialization: $current_user->user_spec</li>
							</ul></div>";
					echo "<div class='col-sm-4 col-md-6'>";
					echo "<p>Bio: $current_user->description</p>";
				}
			endif;


			?>
					</div>

			</div>
			<div class="row">
				<div class="col-md-4"><!--First Column-->
					<h3>Recent Posts</h3>
					<ul class="list-group">
						<?php
						$args = array( 'numberposts' => '5' );
						$recent_posts = wp_get_recent_posts( $args );
						foreach( $recent_posts as $recent ){
							echo '<li class="list-group-item"><a href="' . get_permalink($recent["ID"]) . '">' .   $recent["post_title"].'</a> </li> ';
						}
						wp_reset_query();
						?>
					</ul>
				</div>

				<div class="col-md-4"><!--Second Column-->
					<h3>Recent Forum Replies</h3>
					<ul class="list-group">
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
								echo "<li class='list-group-item'><a href='?topic=$reply_parent->post_name'>$reply_parent->post_title</a></li>";
							}
						}
						?>
					</ul>
				</div>

				<div class="col-md-4"><!--Third Column-->
					<h3>Recent Forum Topics</h3>
					<ul class="list-group">
						<?php
						global $wpdb;
						$query="SELECT * FROM wp_posts WHERE post_type='topic' ORDER BY post_date DESC LIMIT 5";
						$results=$wpdb->get_results($query);
						foreach ($results as $result) {
							echo "<li class='list-group-item'><a href='?topic=$result->post_name'>$result->post_title</a></li>";
						}
						?>
					</ul>
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


<!-- start of form handling -->
<?php
global $wpdb;
$results = $wpdb->get_results("SELECT * FROM notifications WHERE student_id=$current_user->ID");
$update_user = $results[0];
if (isset ($_POST['profile_update_submit'])) {
	global $wpdb;
	$new_description = stripslashes($_POST["new_description"]);
    $new_user_email = stripslashes($_POST["new_user_email"]);
    $new_user_url = ($_POST["new_user_url"]);
    $new_user_url_2 = ($_POST["new_user_url_2"]);
    $new_user_url_3 = ($_POST["new_user_url_3"]);
    $new_user_job = stripslashes($_POST["new_user_job"]);
    $new_user_spec = stripslashes($_POST["new_user_spec"]);
		
	// update the request
	if ($update_user->student_id) {
		$updated = $wpdb->update( 
		'notifications', 
		array( 
			'new_description' => $new_description, 
			'new_email' => $new_user_email, 
			'new_url' => $new_user_url, 
			'new_url_2' => $new_user_url_2, 
			'new_url_3' => $new_user_url_3, 
			'new_job' => $new_user_job,
			'new_spec' => $new_user_spec,
		),
		array(
			'student_id' => $current_user->ID,
		) 
	);
	}
	// create a new request
	else {
	$updated = $wpdb->insert( 
		'notifications', 
		array(
			'student_id' => $current_user->ID, 
			'new_description' => $new_description, 
			'new_email' => $new_user_email, 
			'new_url' => $new_user_url, 
			'new_url_2' => $new_user_url_2, 
			'new_url_3' => $new_user_url_3, 
			'new_job' => $new_user_job,
			'new_spec' => $new_user_spec,
		),
		array( 
			'%d', 
			'%s', 
			'%s', 
			'%s', 
			'%s', 
			'%s', 
			'%s',
			'%s',
		) 
	);
	}
}
?>
<!-- end of form handling -->
			
<!-- start of edit profile form -->

<form id="your-profile" action="" method="post">

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
			
				<th><label for="new_description"><?php _e( $description_label ); ?></label></th>
				<td><textarea name="new_description" id="new_description" rows="3" cols="10" maxlength="140" + 
				><?php echo esc_html( $description_value ); ?></textarea>
				<span><?php _e("Share a bio that could fit in a Tweet. "); ?></span><span id="approve_textarea_feedback">info</span></td>
		<br>	
	<!-- end of description field -->

	<!-- start of email field -->
	<?php
	$email_field = $update_user->new_email;
	$email_label = "Email (required)";
	?>
	
	
		<th><label for="new_user_email"><?php _e( $email_label ); ?></label></th>
		<td><input type="text" name="new_user_email" id="new_user_email" value="<?php echo esc_attr( $email_field ); ?>" class="regular-text" /></td>
	<br>
	<!-- end of email field -->
	
	<!-- start of primary website field -->
	<?php
	$url_field = $update_user->new_url;
	$url_label = "Primary Website";
	?>
	
	
		<th><label for="new_user_url"><?php _e( $url_label ); ?></label></th>
		<td><input type="text" name="new_user_url" id="new_user_url" value="<?php echo esc_attr( $url_field ); ?>" class="regular-text" /></td>
	<br>
	<!-- end of primary website field -->
	
	<!-- start of second website field -->
	<?php
	$url_2_field = $update_user->new_url_2;
	$url_2_label = "Second Website";
	?>
	
	
		<th><label for="new_user_url_2"><?php _e( $url_2_label ); ?></label></th>
		<td><input type="text" name="new_user_url_2" id="new_user_url_2" value="<?php echo esc_attr( $url_2_field ); ?>" class="regular-text" /></td>
	<br>
	<!-- end of second website field -->
	
	<!-- start of third website field -->
	<?php
	$url_3_field = $update_user->new_url_3;
	$url_3_label = "Third Website";
	?>
	
	
		<th><label for="new_user_url_3"><?php _e( $url_3_label ); ?></label></th>
		<td><input type="text" name="new_user_url_3" id="new_user_url_3" value="<?php echo esc_attr( $url_3_field ); ?>" class="regular-text" /></td>
	<br>
	<!-- end of third website field -->
	
	<!-- start of job field -->
	<?php
	$job_field = $update_user->new_job;
	$job_label = "Employment";
	?>
	
	
		<th><label for="new_user_job"><?php _e( $job_label ); ?></label></th>
		<td><input type="text" name="new_user_job" id="new_user_job" value="<?php echo esc_attr( $job_field ); ?>" class="regular-text" /></td>
	<br>
	<!-- end of job field -->
	
	<!-- start of specialization field -->
	<?php
	$spec_field = $update_user->new_spec;
	$spec_label = "Specialization";
	?>
		<th><label for="new_user_spec"><?php _e( $spec_label ); ?></label></th>
		<td>
			<select name="new_user_spec" id="new_user_spec">
				<option value=''>-select-one-</option>
				<option value='Undecided'>Undecided</option>
				<option value='Front-End'>Front End</option>
				<option value='Back-End'>Back End</option>
			</select>
		</td>
	<br>
	<!-- end of specialization field -->

<input type="submit" value="<?php _e( 'Update Profile' ); ?>" name="profile_update_submit">
</form>
<!-- end of edit profile form -->

		</main><!-- #main -->
	</div><!-- #primary -->
	</div>
<?php get_footer(); ?>
