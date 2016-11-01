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

<!-- Footer -->
<footer>
	<div class="container">
		<div class="col-sm-3">
			<p><a href="/"><img src="<?php bloginfo('template_url'); ?>/assets/images/batc_logo.png" alt="BATC | Web &amp; Mobile Development"></a></p>
		</div><!-- col-sm 3 -->
		<div class="col-sm-6">
			<nav>
				<ul class="list-unstyled list-inline">
					<li><a href="/">Home</a></li>
					<li><a href="/contact">Contact</a></li>
					<li><a href="/resource">Resources</a></li>
					<li><a href="https://www.facebook.com/batcwebdev/"><i class="fa fa-facebook-square fa-2x" aria-hidden="true"></i></a></li>
				</ul>
			</nav>
		</div><!-- col sm 6 -->
		<div class="col-sm-3">
			<p class="pull-right">&copy; BATC | Web &amp; Mobile Development</p>
		</div><!-- col sm 3 -->
	</div><!-- container -->
</footer>
<?php wp_footer(); ?>

</body>
</html>
