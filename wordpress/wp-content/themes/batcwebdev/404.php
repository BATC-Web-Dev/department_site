<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package BATCWebDev
 */

get_header(); ?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
		
                        
			<section class="error-404 not-found">
				<header class="page-header">

					<h1 class="page-title" style="text-align: center"><?php esc_html_e( 'Awe, bad timing.  Perhaps try the IT department.', 'batcwebdev' ); ?></h1>
				</header><!-- .page-header -->

				<div class="page-content">
					<div class="container">
						<img class="img-responsive center-block" src="<?php bloginfo('template_url'); ?>/assets/images/lunch.png">
					</div>
				</div><!-- .page-content -->
			</section><!-- .error-404 -->

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
