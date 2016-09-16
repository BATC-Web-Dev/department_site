<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package BATCWebDev
 */

?>

</div><!-- #content -->
</div><!-- #page -->
</div><!-- .container -->
<div class="container">
	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="container">
			<div class="site-info">
				<div class="col-sm-3">
				<a class="pull-left" href="#">
				<img src="<?php bloginfo('template_url'); ?>/assets/images/batc_logo.png" alt="">
				</a>
				</div>
				<div class="col-sm-6">
					<nav>
						<ul class="list-unstyled list-inline">
							<li>
								<a href="">Home</a>
							</li>
							<li>
								<a href="">Contact</a>
							</li>
							<li>
								<a href="">Resources</a>
							</li>
						</ul>
					</nav>
				</div>
				<div class="col-sm-3">
					<p class="pull-right">© BATC | Web & Mobile Development</p>
				</div>
			</div><!-- .site-info -->
			</div>
	</footer><!-- #colophon -->
</div><!-- #container -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
