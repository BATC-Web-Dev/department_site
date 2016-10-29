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
            Learn with Professional Tools
        </h2>
    </div>
    <section id="res_IDE">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <img class="img center-block img-circle" src="<?php bloginfo('template_url'); ?>/assets/images/IDE.png" alt="">
                </div>
                <div class="col-md-8">
                    <h3>Build</h3>
                    <p>An integrated development environment (IDE) is a software suite that consolidates the basic
                        tools developers need to write and test software. Typically, an IDE contains a code editor,
                        a compiler or interpreter and a debugger that the developer accesses through a single graphical
                        user interface (GUI). An IDE may be a standalone application, or it may be included as part of
                        one or more existing and compatible applications. Popular IDE's include <a href="https://notepad-plus-plus.org/">Notepad++</a>
                        <a href="https://www.sublimetext.com/">Sublime Text</a> or any from <a href="https://www.jetbrains.com/">Jetbrains</a>
                    </p>
                </div>
            </div>
        </div>
    </section>
    <section id="res_slack">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <h3>Connect</h3>
                    <p>Slack is basically a messaging app on steroids. It's meant for teams and workplaces, can be used
                        across multiple devices and platforms, and is equipped with robust features that allow you to
                        not only chat one-on-one with associates but also in groups. You're able to upload and share
                        files with them too, as well as integrate with other apps and services, such as Skype for video
                        calls, and you can granularly control almost every setting, including the ability to create
                        custom emoji. <a href="http://www.slack.com">Learn more at the Slack website.</a>
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
                    <img class="img center-block img-circle" src="<?php bloginfo('template_url'); ?>/assets/images/github.png" alt="">
                </div>
                <div class="col-md-8">
                    <h3>Save</h3>
                    <p>GitHub is a Git repository hosting service, but it adds many of its own features. While Git is
                        a command line tool, GitHub provides a Web-based graphical interface. It also provides access
                        control and several collaboration features, such as a wikis and basic task management tools
                        for every project. <a href="http://www.github.com">Learn more at the GitHub website.</a>
                    </p>
                </div>
            </div>
        </div>
    </section>
    <section id="res_hosting">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <h3>Host</h3>
                    <p>SiteGround is a great hosting solution for all your WordPress projects - both new and
                        established ones. The service they provide is stable, secure and super fast thanks to the
                        special tools they've developed in-house for WordPress users. <a href="http://www.siteground.com">Learn more at the Site Ground Website</a>
                    </p>
                </div>
                <div class="col-md-4">
                    <img class="img center-block img-circle" src="<?php bloginfo('template_url'); ?>/assets/images/siteGround.png" alt="">
                </div>
            </div>
        </div>
    </section>
</main>
<?php
get_footer();
