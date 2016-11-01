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
    <!-- start form handling -->
<?php
// define variables and set to empty values
if (isset ($_POST["reset"])) {
    $contact_name = "";
    $contact_phone = "";
    $contact_email = "";
    $contact_comment = "";
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
} // end of test_input function

if (isset ($_POST['contact_submit'])) {

    $contact_is_a = ($_POST["contact_is_a"]);
    $contact_name = test_input($_POST["contact_name"]);
    $contact_phone = test_input($_POST["contact_phone"]);
    $contact_email = test_input($_POST["contact_email"]);
    $contact_comment = test_input($_POST["contact_comment"]);
    $contact_comment = wordwrap($contact_comment, 50);
//echo "name: '$contact_name', phone: '$contact_phone', email: '$contact_email'";
} // end of if isset

// if required fields
if ($contact_name && ($contact_phone || $contact_email) ) {
    if(isset($_POST['g-recaptcha-response'])){
        $captcha=$_POST['g-recaptcha-response'];
    }
    $secretKey = "6LdPbQgUAAAAABbGHcCMOY5Vig5Aji_fSv__flsF";
    $ip = $_SERVER['REMOTE_ADDR'];
    $response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha."&remoteip=".$ip);
    $responseKeys = json_decode($response,true);
    if(intval($responseKeys["success"]) !== 1) {
        $result='<div class="alert alert-danger">Please fill out all fields and the Captcha</div>';
    } else {
        $to = "webdev@batc.edu";
        $subject = "Contact Form Submission";
        $txt = "Name: $contact_name\nRelation: $contact_is_a\nPhone: $contact_phone\nEmail: $contact_email\n\n$contact_comment";
        $headers = "From: $contact_email";

        wp_mail($to,$subject,$txt,$headers);
        $result='<div class="alert alert-success">Thank You! We will be in touch</div>';
    }
} // end of if required fields
else {
    if (isset ($_POST['contact_submit'])) {
        echo '<div class="contact_form_error">';
        if (!$contact_name || (!$contact_phone && !$contact_email)) {
            $result='<div class="alert alert-success">Sorry, Form did not submit</div>';
        }
        if (!$contact_name) {
            echo "Please enter a name.<br>";
        }
        if (!$contact_phone && !$contact_email) {
            echo "Please enter a phone number or email.<br>";
        }
        echo "</div>"; // .contact_form_error
    } // end of if isset
}
?>

<section id="sect-carousel">
    <div class="col-sm-12" id="index-contact-alert">
        <?php echo $result; ?>
    </div>
    <div class="carousel slide" data-ride="carousel" id="featured">
        <div class="carousel-inner">
            <ol class="carousel-indicators">
                <li data-target="#featured" data-slide-to="0" class="active"></li>
                <li data-target="#featured" data-slide-to="1"></li>
                <li data-target="#featured" data-slide-to="2"></li>
            </ol>
            <div class="item active">
                <img class="img-responsive center-block" src="<?php bloginfo('template_url'); ?>/assets/images/slide1.jpg" alt="">
                <div class="carousel-caption">
                    <h1>Welcome to BATC Web and Mobile Development</h1>
                </div>
            </div>
            <div class="item">
                <a href="/contact">
                    <img class="img-responsive center-block" src="<?php bloginfo('template_url'); ?>/assets/images/slide2.jpg" alt="">
                    <div class="carousel-caption">
                        <h1>Contact Us</h1>
                    </div>
                </a>
            </div>
            <div class="item">
                <a href="/resource">
                    <img class="img-responsive center-block" src="<?php bloginfo('template_url'); ?>/assets/images/slide3.jpg" alt="">
                    <div class="carousel-caption">
                        <h1>Resources</h1>
                    </div>
                </a>
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
                    <a href="http://batc.edu/programs/web-mobile-development" class="btn btn-success btn-lg btn-block" target="_blank">I'm Ready</a>
                </p>
                </strong>
            </div>
        </div>
    </div>
</section>

<section id="project-features">
    <div class="container">
        <h2>Is Web Development for you?</h2>
        <p class="lead">Not sure if a career in Web &amp; Mobile Development is for you?</p>
        <div class="row">
            <div class="col-sm-4">
                <img src="<?php bloginfo('template_url'); ?>/assets/images/html_code.png" alt="Design">
                <h3>Make the internet yours</h3>
                <p>Do you look at webpages on the internet and think "I could do better" or "Wow, that's a neat website"?  Web Developers have the opportunity to work on projects that could possibly be seen by millions of people.</p>
            </div><!-- end col -->

            <div class="col-sm-4">
                <img src="<?php bloginfo('template_url'); ?>/assets/images/css_code.png" alt="Design">
                <h3>Design webpages</h3>
                <p>Do you like the idea of coding a beautiful website?  Websites aren't just about a pretty design, they are also about well designed UX and beautiful code that can be just as much of an art as the finished website itself.</p>
            </div><!-- end col -->

            <div class="col-sm-4">
                <img src="<?php bloginfo('template_url'); ?>/assets/images/js_code.png" alt="Design">
                <h3>Write code</h3>
                <p>Do you enjoy feeling a sense of accomplishment when you see something you created?  Much like an engineer, Web Developers build what we see on the internet and can feel pride in what they have done.</p>
            </div><!-- end col -->
        </div><!-- row -->
    </div><!-- container -->
</section><!-- project features -->

<!-- Who Benefits -->

<section id="who-benefits">
    <div class="container">
        <div class="section-header">
            <h2>What careers can you choose from in our program?</h2>
        </div><!-- section header -->
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">

                <h3>Web Developer</h3>
                <p>A Web Developer is a programmer or coder who specializes in programming languages for the World Wide Web or the internet.  They write code which the computer translates into something usable by humans.  They are basically the engineers or builders of the Web.  Web Developers work with some of the following languages HTML5, CSS3, JavaScript, JQuery, PHP, MySQL, Ruby, Python and others depending on their specialization.  Sound like a lot?  Most Developers really only focus on or specialize in a few languages but often know a spattering of several.  In general, <strong>Web Developers make around $87,000 a year</strong> according to <a href="http://www.indeed.com/salary?q1=web+designer&l1=usa&q2=web+developer&l2=usa"> Indeed</a>.</p>

                <h3>Web Designer</h3>
                <p>Web Designers design the layout or visual appeal and flow of the website as well as the UI or UX (user interface or user experience) to make the website usable for the user.  This is generally done through a process called wire framing in either Photoshop or Sketch.  Wire framing allows you to layout the webpage graphically so you have an idea of how the website looks before being sent to the developers to be programmed.  Most designers spend their days looking at color palettes, typography, and possibly doing some graphic design as well as basic coding.  In general, <strong>Web Designers make about $66,000 a year</strong>, but more advanced designers can make into the 90k region.
                </p>

            </div><!-- col-sm and offset -->
        </div><!-- class row -->
    </div><!-- container -->
</section>

<!-- Who Benefits -->

<section id="who-benefits">
    <div class="container">
        <div class="section-header">
            <h2>Which one is right for you?</h2>
        </div><!-- section header -->
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">

                <h3>Web Developer</h3>
                <p>Web Developers tend to see the world in more of a logical fashion.  They see the world as something that can be quantified and put into a collection of data.  They enjoy solving problems and have a high attention to detail.</p>

                <h3>Web Designer</h3>
                <p>Web Designers see the world in a visual way.  Instead of seeing a path as a series of waypoints, they like landmarks and rely more on intuition and feel then logic.  They tend to be more creative in general and enjoy making things.</p>


            </div><!-- col-sm and offset -->
        </div><!-- class row -->
    </div><!-- container -->

</section>

<!-- Course Features -->

<section id="course-features">
    <div class="container">
        <div class="section-header">
            <h2>Why BATC's Web and Mobile Development program?</h2>
            <p>Ready to learn how to be a Web Developer or Designer? There are several reasons to come to BATC to learn.</p>
        </div>
        <div class="row">
            <div class="col-sm-2">
                <i class="fa fa-desktop fa-2x"></i>
                <h4>Develop with professional Tools</h4>
            </div>
            <div class="col-sm-2">
                <i class="fa fa-university fa-2x"></i>
                <h4>Start earning your certificate in HS</h4>
            </div>
            <div class="col-sm-2">
                <i class="fa fa-dashboard fa-2x"></i>
                <h4>Learn at your own pace</h4>
            </div>
            <div class="col-sm-2">
                <i class="fa fa-graduation-cap fa-2x"></i>
                <h4>Earn credits toward your degree at USU</h4>
            </div>
            <div class="col-sm-2">
                <i class="fa fa-money fa-2x"></i>
                <h4>Scholarships and grants available</h4>
            </div>
            <div class="col-sm-2">
                <i class="fa fa-calendar fa-2x"></i>
                <h4>Average completion is just a year</h4>
            </div>
        </div>
    </div>
</section>
<section id="contact">
    <div class="container">
        <div class="row">
            <div class="col-sm-8">
                <p class="lead">
                    <strong>Questions? Contact us for further information</strong>
                </p>
            </div>
            <div class="col-sm-4">
                <strong>
                    <p>
                        <a href="http://batc.edu/programs/web-mobile-development" class="btn btn-info btn-lg btn-block" data-toggle="modal" id="contact-btn" data-target="#contact-modal">Contact Us</a>
                    </p>
                </strong>
            </div>
        </div>
    </div>
</section>
    <!--Form Modal -->
    <form class="form-horizontal" id="contactForm" method="post" action="">
        <script src='https://www.google.com/recaptcha/api.js'></script>
        <div id="contact-modal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Contact Us</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="sel1">I am a:</label>
                            <select class="form-control" id="sel1" name="contact_is_a">
                                <option value=""> - select one - </option>
                                <option value='prospective student'>Prospective Student</option>
                                <option value='current student'>Current Student</option>
                                <option value='employer'>Employer</option>
                                <option value='other'>Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="contact_name">Name: </label>
                            <input type="text" name="contact_name" value="" class="form-control" id="contact_name" placeholder="Enter Name" required>
                        </div>
                        <div class="form-group">
                            <label for="contact_phone">Phone: </label>
                            <input type="tel" name="contact_phone" value="" class="form-control" id="contact_phone" placeholder="(xxx)xxx-xxxx" required>
                        </div>
                        <div class="form-group">
                            <label for="contact_email">Email: </label>
                            <input type="email" name="contact_email" value="" class="form-control" id="contact_email" placeholder="Enter Email Address" required>
                        </div>
                        <div class="form-group">
                            <label for="contact_comment">Comment:</label>
                            <textarea class="classForm" rows="5" id="contact_comment" name="contact_comment" required></textarea>
                        </div>
                        <div class="form-group">
                            <div class="g-recaptcha" data-sitekey="6LdPbQgUAAAAADEfVZ9Wz1y7QTYPBC1eHohj_mmf"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn" type="reset" value="Reset">Reset</button>
                        <button class="btn" type="submit" value="Submit" name="contact_submit">Submit</button>
                    </div>
                </div>
            </div>
        </div><!--Modal-->
    </form>
<?php
get_footer();
