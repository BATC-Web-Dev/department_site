<?php
/*
Template Name: resources
*/

get_header(); ?>
<main id="main" class="site-main" role="main">

    <div class="jumbotron" id="resource-jumbotron">
        <h1>Resources</h1>
        <h2>
            <i class="glyphicon glyphicon-briefcase"></i>
            We feel it's important to learn to code and work with the same tools you will be using in the industry
        </h2>
    </div>

    <section id="res_hosting">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <h3>Host</h3>
                    <p>We recommend you use SiteGround for you hosting service. They have proven to be a fast, reliable
                        and secure hosting service, but still priced at reasonable rate. They have an awesome 1 click
                        WordPress installer that doesn't add "extra features" you don't need to the install, but still
                        has all of the features that a developer or blogger wants. They also provide you with a free
                        SSL certificate, great customer service and all the features you would expect from a high
                        quality Hosting service. <a href="http://www.siteground.com">Get started with SightGround</a>
                    </p>
                </div>
                <div class="col-md-4">
                    <img class="img center-block img-circle" src="<?php bloginfo('template_url'); ?>/assets/images/siteGround2.jpg" alt="">
                </div>
            </div>
        </div>
    </section>

    <section id="res_IDE">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <img class="img center-block img-circle" src="<?php bloginfo('template_url'); ?>/assets/images/IDE.png" alt="">
                </div>
                <div class="col-md-8">
                    <h3>Development</h3>
                    <p>In the classroom we provide a verity of different development tools so you can try them and
                        decide which ones you like the best. The following tools are installed on our machines:
                        <a href="https://atom.io/" target="_blank">Atom</a>, <a href="http://brackets.io/" target="_blank">Brackets</a>,
                        <a href="https://www.sublimetext.com/3" target="_blank">Sublime</a>,
                        <a href="https://notepad-plus-plus.org/" target="_blank">Notepad++</a>,
                        <a href="http://www.barebones.com/products/TextWrangler/" target="_blank">TextWrangler</a> to
                        name a few. You may also want to try Coda 2 if you are using a mac or (add whatever one that
                        you use that you like storm something).
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section id="res_slack">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <h3>Team Development and collaboration</h3>
                    <p>Even though many of the students are at different points in the program and different schedules,
                        we use <a href="https://slack.com/" target="_blank">Slack </a> to help communicate between
                        students and instructors. When we need version control for a project we naturally us
                        <a href="https://github.com/" target="_blank">Git hub</a>
                        in the classroom and <a href="https://trello.com/charlesswann/recommend" target="_blank">Trello</a>
                        for project organization between multiple students and instructors. All of which are free to
                        use and often used in the Web Development industry.
                    </p>
                </div>
                <div class="col-md-4">
                    <img class="img center-block img-circle" src="<?php bloginfo('template_url'); ?>/assets/images/slack.jpeg" alt="">
                </div>
            </div>
        </div>
    </section>

    <section id="res_git">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <img class="img center-block img-circle" src="<?php bloginfo('template_url'); ?>/assets/images/adobe.png" alt="">
                </div>
                <div class="col-md-8">
                    <h3>Photo and Image editing</h3>
                    <p>We have the full suite of Adobe Creative cloud for your use in our machines. If you are
                        interested in having a Creative Cloud membership and you are a student in the program check the
                        newsletter for special student only deals.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section id="res_slack">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <h3>Local Server</h3>
                    <p>MAMP is pretty much the simplest, most robust local server we have found. We love it because you
                        can easily change your server destination files, installation is quick and easy, and the User
                        Interface is simple to understand and use. In the class room you will generally just use the
                        free version but when are ready to go pro the paid pro version of MAMP offers some significant
                        advantage but the biggest one is the ability to set it up to host multiple local hosts at one
                        time. Allowing you to easily start your projects for the day and keep everything tidy with its
                        own folder and location instead of having to move your files around constantly.
                    </p>
                </div>
                <div class="col-md-4">
                    <img class="img center-block img-circle" src="<?php bloginfo('template_url'); ?>/assets/images/mamp.png" alt="">
                </div>
            </div>
        </div>
    </section>

    <section id="res_git">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <img class="img center-block img-circle" src="<?php bloginfo('template_url'); ?>/assets/images/dynadot.jpg" alt="">
                </div>
                <div class="col-md-8">
                    <h3>Domain</h3>
                    <p>We recommend buying your domains though Dynadot. Dynadot has a great UI that makes managing
                        multiple domains simple and Easy as well as they are upfront about their pricing and
                        reasonable. <a href="http://www.anrdoezrs.net/click-8154329-12589594-1463602213000" target="_blank">Get started with Dynadot</a>
                    </p>
                </div>
            </div>
        </div>
    </section>

</main>
<?php
get_footer();
