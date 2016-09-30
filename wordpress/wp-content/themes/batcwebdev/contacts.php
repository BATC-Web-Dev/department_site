<?php
/*
Template Name: contacts
*/

/**
 *
 *
 *
 * @package WordPress
 * @subpackage BATCITWEB
 */

get_header(); ?>
<script>
    jQuery(document).ready(function( $ ) {
        $.validator.addMethod("phoneUS", function (phone_number, element) {
            phone_number = phone_number.replace(/\s+/g, "");
            return this.optional(element) || phone_number.length > 9 &&
                phone_number.match(/\(?[\d\s]{3}\)[\d\s]{3}-[\d\s]{4}$/);
        }, "Invalid phone number");
        $('#contactForm').validate({
            rules: {
                contact_phone: {
                    required: true,
                    phoneUS: true
                }
                contact_email: {
                    required: true,
                    validate_email: true
                }
            }
        });
    });

//Finds y value of given object
function findPos(obj) {
    var curtop = 0;
    if (obj.offsetParent) {
        do {
            curtop += obj.offsetTop;
        } while (obj = obj.offsetParent);
    return [curtop];
    }
}
</script>
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
    $to = "joshua.aaron.brown@gmail.com"; 
    $subject = "Contact Form Submission";
    $txt = "Name: $contact_name\nRelation: $contact_is_a\nPhone: $contact_phone\nEmail: $contact_email\n\n$contact_comment";
    $headers = "From: $contact_email";

    wp_mail($to,$subject,$txt,$headers);	  
//  } // end of if has contact info
    $result='<div class="alert alert-success">Thank You! We will be in touch</div>';

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
<!-- start of BATC contact info -->
    <main id="main" class="site-main" role="main">
            <div class="col-sm-12">
                <?php echo $result; ?>
            </div>
        <section id=jumbo>
            <div class="jumbotron">

                    <h2><span>Make Contact</span></h2>
                    <p><span>
                        <i class="glyphicon glyphicon-envelope"> Address:</i><span class='spacer'></span><br>
                        <span class='spacer'></span>1410 North 1000 West<span class='spacer'></span><br>
                        <span class='spacer'></span>Logan, UT 84321<span class='spacer'></span><br>
                    </span></p>
                    <p><span>
                        <i class="glyphicon glyphicon-phone">Phone:</i><span class='spacer'></span><br>
                        <span class='spacer'></span>Main: <a href="tel:(435)-753-4708">(435)-753-4708</a><span class='spacer'></span><br>
                        <span class='spacer'></span>Fax: <a href="tel:(435)-753-5709">(435)-753-5709</a><span class='spacer'></span><br>
                     </span></p>

            </div>
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
        <section id="contact_form">
            <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <form class="form-horizontal" id="contactForm" method="post" action="">
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
                        <div>
                            <button class="btn pull-right" type="submit" value="Submit" name="contact_submit">Contact Us</button>
                            <button class="btn pull-left" type="reset" value="Reset">Reset Form</button>
                        </div>
                    </form>
                </div>
                <div class="col-md-6 col-sm-12" id="map">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d5952.578404199443!2d-111.85850495194497!3d41.75742211651987!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x87548761cbd58949%3A0x46a978a3c2839d66!2sBridgerland+Applied+Technology+College+West+Campus!5e0!3m2!1sen!2sus!4v1474922534989" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
                </div>
            </div>
        </section>

<!-- end of form handling -->
</main><!-- .site-main -->
<?php get_footer(); ?>