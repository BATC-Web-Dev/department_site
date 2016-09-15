<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package BATCWebDev
 */

get_header(); ?>
    <div class="carousel slide hidden-xs" data-ride="carousel" id="featured">
        <div class="carousel-inner">
            <ol class="carousel-indicators">
                <li data-target="#featured" data-slide-to="0" class="active"></li>
                <li data-target="#featured" data-slide-to="1"></li>
                <li data-target="#featured" data-slide-to="2"></li>
                <li data-target="#featured" data-slide-to="3"></li>
                <li data-target="#featured" data-slide-to="4"></li>
            </ol>
            <div class="item active">
                <img src="<?php bloginfo('template_url'); ?>/assets/images/04304134.jpg" alt="">
            </div>
            <div class="item">
                <img src="<?php bloginfo('template_url'); ?>/assets/images/05144139.jpg" alt="">
            </div>
            <div class="item">
                <img src="<?php bloginfo('template_url'); ?>/assets/images/07237019.jpg" alt="">
            </div>
            <div class="item">
                <img src="<?php bloginfo('template_url'); ?>/assets/images/07237055.jpg" alt="">
            </div>
            <div class="item">
                <img src="<?php bloginfo('template_url'); ?>/assets/images/07237108.jpg" alt="">
            </div>
        </div><!--carousel inner-->

        <a class="left carousel-control" href="#featured" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left"></span>
        </a>

        <a class="right carousel-control" href="#featured" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right"></span>
        </a>
    </div><!--carousel-->
<div class="container-fluid">
    <div class="content-container">
        <div class="row">
            <section class="col-sm-12">
                <h2>Our Mission</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut congue in augue at rhoncus. Duis eu aliquet odio, ac pretium massa. Mauris a sem pretium, aliquet tortor a, elementum magna. Integer iaculis justo semper turpis consequat pretium. Integer dignissim fringilla scelerisque. Donec vestibulum nibh vitae sem efficitur ultrices. Donec hendrerit elit sit amet purus elementum, eu gravida mi ultrices. Integer vitae lobortis neque. Pellentesque placerat malesuada mauris, in gravida enim auctor eget.</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut congue in augue at rhoncus. Duis eu aliquet odio, ac pretium massa. Mauris a sem pretium, aliquet tortor a, elementum magna. Integer iaculis justo semper turpis consequat pretium. Integer dignissim fringilla scelerisque. Donec vestibulum nibh vitae sem efficitur ultrices. Donec hendrerit elit sit amet purus elementum, eu gravida mi ultrices. Integer vitae lobortis neque. Pellentesque placerat malesuada mauris, in gravida enim auctor eget.</p>
            </section>
        </div>
    </div>
</div>

<?php
get_footer();
