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
<section>
    <div class="carousel slide hidden-xs" data-ride="carousel" id="featured">
        <div class="carousel-inner">
            <ol class="carousel-indicators">
                <li data-target="#featured" data-slide-to="0" class="active"></li>
                <li data-target="#featured" data-slide-to="1"></li>
                <li data-target="#featured" data-slide-to="2"></li>
                <li data-target="#featured" data-slide-to="3"></li>
            </ol>
            <div class="item active">
                <img src="<?php bloginfo('template_url'); ?>/assets/images/slide1.jpg" alt="">
            </div>
            <div class="item">
                <img src="<?php bloginfo('template_url'); ?>/assets/images/slide2.jpg" alt="">
            </div>
            <div class="item">
                <img src="<?php bloginfo('template_url'); ?>/assets/images/slide3.png" alt="">
            </div>
            <div class="item">
                <img src="<?php bloginfo('template_url'); ?>/assets/images/slide4.png" alt="">
            </div>
        </div><!--carousel inner-->

        <a class="left carousel-control" href="#featured" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left"></span>
        </a>

        <a class="right carousel-control" href="#featured" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right"></span>
        </a>
    </div><!--carousel-->
</section>
<section id="optin">
    <div class="container">
        <div class="row">
            <div class="col-sm-8">
                <p class="lead">
                    <strong>Ready to find out more about our program?</strong>
                </p>
            </div>
            <div class="col-sm-4">
                <strong>
                <p>
                    <a href="http://batc.edu/programs/web-mobile-development" class="btn btn-success btn-lg btn-block">I'm Ready</a>
                </p>
                </strong>
            </div>
        </div>
    </div>
</section>

<section id="field-info">
    <div class="container">
        <div class="lead">
            <h2>Is Web Development for you?</h2>
        </div>
            <div class="row">
                <div class="col-sm-3">
                    <img class="img center-block" src="<?php bloginfo('template_url'); ?>/assets/images/html_code.png" alt="">
                </div>
                <div class="col-sm-9">
                    <h3>I want to be a web developer</h3>
                    <p>A Web Developer is a programmer or coder who specializes in programming languages for the World
                        Wide Web or the internet. They write code which the computer translates into something usable by
                        humans. They are basically the engineers or builders of the Web. Web Developers work with some
                        of the following languages HTML5, CSS3, JavaScript, JQuery, PHP, MySQL, Ruby, Python and others
                        depending on their specialization. Sound like a lot? Most Developers really only focus on or
                        specialize in a few languages but often know a spattering of several. In general, Web Developers
                        make around $87,000 a year according to Indeed.</p>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <img class="img center-block" src="<?php bloginfo('template_url'); ?>/assets/images/css_code.png" alt="">
                </div>
                <div class="col-sm-9">
                    <h3>I want to be a web designer</h3>
                    <p>Web Designers design the layout or visual appeal and flow of the website as well as the UI or UX
                        (user interface or user experience) to make the website usable for the user. This is generally
                        done through a process called wire framing in either Photoshop or Sketch. Wire framing allows
                        you to layout the webpage graphically so you have an idea of how the website looks before being
                        sent to the developers to be programmed. Most designers spend their days looking at color
                        palettes, typography, and possibly doing some graphic design as well as basic coding. In
                        general, Web Designers make about $66,000 a year, but more advanced designers can make into the
                        90k region.</p>
                </div>
            </div>
    </div>
</section>

<section id="course-features">
    <div class="container">
        <div class="section-header">
            <h2>Why BATC's Web and Mobile Development program?</h2>
            <p>Ready to learn how to be a Web Developer or Designer? There are several reasons to come to BATC to learn.</p>
        </div>
        <div class="row">
            <div class="col-sm-2">
                <i class="fa fa-desktop fa-4x"></i>
                <h4>Start when you turn 16</h4>
            </div>
            <div class="col-sm-2">
                <i class="fa fa-university fa-4x"></i>
                <h4>Start earning your certificate in HS</h4>
            </div>
            <div class="col-sm-2">
                <i class="fa fa-dashboard fa-4x"></i>
                <h4>Learn at your own pace</h4>
            </div>
            <div class="col-sm-2">
                <i class="fa fa-graduation-cap fa-4x"></i>
                <h4>Earn credits toward your degree at USU</h4>
            </div>
            <div class="col-sm-2">
                <i class="fa fa-money fa-4x"></i>
                <h4>Scholarships and grants available</h4>
            </div>
            <div class="col-sm-2">
                <i class="fa fa-calendar fa-4x"></i>
                <h4>Average completion is just a year</h4>
            </div>
        </div>
    </div>

</section>

<?php
get_footer();
