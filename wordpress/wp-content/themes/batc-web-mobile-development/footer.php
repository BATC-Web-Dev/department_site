<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Test_Underscores_Based_Theme
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
<!--
        <div class="site-info">
			<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'batc-web-mobile-development' ) ); ?>"><?php printf( esc_html__( 'Proudly powered by %s', 'batc-web-mobile-development' ), 'WordPress' ); ?></a>
			<span class="sep"> | </span>
			<?php printf( esc_html__( 'Theme: %1$s by %2$s.', 'batc-web-mobile-development' ), 'batc-web-mobile-development', '<a href="#" rel="designer"></a>' ); ?>
		</div><!-- .site-info -->
        
<!-- From Static Bootstraps Site -->
<div class="container">
  <div class="row">
      <h3 class="text-center">BATC</h3>
      <p class="text-center">Employment Through Training</p>
  </div> <!-- Row -->

<div class="row">
<nav>
  <div class="col-xs-6 col-sm-4">
    <ul class="list-unstyled">
      <li><a href="#">Home</a></li>
      <li><a href="#">About</a></li>
      <li><a href="#">Classes</a></li>
      <li><a href="#">Blog</a></li>
    </ul>
  </div> <!-- col-sm-4 -->
  <div class="col-xs-6 col-sm-4">
    <ul class="list-unstyled">
      <li><a href="#">Resources</a></li>
      <li><a href="#">Contact</a></li>
      <li><a href="#">Login</a></li>
      <li><a href="#">Sitemap</a></li>
    </ul>
  </div> <!-- col-sm-4 -->
  <div class="col-xs-6 col-sm-4">
    <ul class="list-unstyled">
      <li>1301 N 600 W</li>
      <li>Logan, UT 84321</li>
      <li>(435) ...-....</li>
    </ul>
  </div> <!-- col-sm-4 -->
</nav>

</div> <!-- Row -->
</div> <!-- Column -->
</div> <!-- Row -->
</div> <!-- Container -->


	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

<!-- Includes from Static Bootstraps Homepage -->
<script src="http://localhost:8888/wordpress/wp-content/themes/batc-web-mobile-development/js/jquery-3.1.0.slim.min.js"></script>
<script src="http://localhost:8888/wordpress/wp-content/themes/batc-web-mobile-development/js/bootstrap.min.js"></script>

</body>
</html>
