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
			<?php
			if ( is_user_logged_in() ):
				$current_user = wp_get_current_user();
				if ( ($current_user instanceof WP_User) ) {
					echo "<div class='avatar col-sm-4'>"
						. get_avatar( $current_user->user_email, 200 ).
						"<div class='center'><a href='#'>Update Profile</a></div>
						<div class='center'><a href='#'>Other Profiles</a></div>
						</div>";
					echo "<div class='col-sm-4'>";
					echo "<h3 class='welcome-head'>Welcome:  $current_user->display_name</h3>";
					echo "<div class='list-group'>
							<a class='list-group-item'>Email: $current_user->user_email</a>
							<a class='list-group-item'>Primary Website: $current_user->user_url</a>
							<a class='list-group-item'>Second Website: $current_user->user_url_2</a>
							<a class='list-group-item'>Third Website: $current_user->user_url_3</a>
							<a class='list-group-item'>Employment: $current_user->user_job</a>
							<a class='list-group-item'>Specialization: $current_user->user_spec</a>
						</div>
						</div>";
					echo "<div class='col-sm-4'>";
					echo "<h3>Bio:</h3>";
					echo "<p>$current_user->description</p></div>";
				}
			endif;
			?>
			</div>
			<div class="row">
				<div class="col-sm-4"><!--First Column-->
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

				<div class="col-sm-4"><!--Second Column-->
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

				<div class="col-sm-4"><!--Third Column-->
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

		</main><!-- #main -->
	</div><!-- #primary -->
</div>

<?php
get_footer();
