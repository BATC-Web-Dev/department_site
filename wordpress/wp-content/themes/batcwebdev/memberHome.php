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
					echo "<div class='avatar col-md-4'>". get_avatar( $current_user->user_email, 150 ). "</div>";
					echo "<div class='col-md-4'>";
					echo "<h3 class='welcome-head'>Welcome:  $current_user->display_name</h3>";
					echo "<ul class='list-group'>
							<li class='list-group-item'>www.one.com</li>
							<li class='list-group-item'>www.two.com</li>
							<li class='list-group-item'>www.three.com</li>
							</ul></div>";
					echo "<div class='col-md-4'>";
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
						<li class="list-group-item">Great Reply</li>
						<li class="list-group-item">Great Reply</li>
						<li class="list-group-item">Great Reply</li>
						<li class="list-group-item">Great Reply</li>
						<li class="list-group-item">Great Reply</li>
					</ul>
				</div>

				<div class="col-md-4"><!--Third Column-->
					<h3>Recent Forum Topics</h3>
					<ul class="list-group">
						<li class="list-group-item">New Topic</li>
						<li class="list-group-item">New Topic</li>
						<li class="list-group-item">New Topic</li>
						<li class="list-group-item">New Topic</li>
						<li class="list-group-item">New Topic</li>
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

		</main><!-- #main -->
	</div><!-- #primary -->
	</div>

<?php
get_footer();
