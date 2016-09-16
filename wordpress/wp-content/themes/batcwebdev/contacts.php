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

    /jQuery.validator.addMethod('phoneUS', function(phone_number, element) {
    phone_number = phone_number.replace(/\s+/g, '');
    return this.optional(element) || phone_number.length > 9 &&
        phone_number.match(/^(1-?)?(\([2-9]\d{2}\)|[2-9]\d{2})-?[2-9]\d{2}-?\d{4}$/);
    }, 'Please enter a valid phone number.');

    });
    jQuery.validator.addMethod("validate_email",function(value, element) {
        if(/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test( value ))
        {
            return true;
        }
        else
        {
            return false;
        }
    },"Please enter a valid Email.");

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

<!-- start of BATC contact info -->
<div id="primary" class="container">
	<main id="main" class="site-main" role="main">
		<h2>BATC Contact info</h2>

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
?>
	<span class="thank_you_contact_form">Thank you for submitting your contact information.</span>
<?php
} // end of if required fields
else {
  if (isset ($_POST['contact_submit'])) {
	echo '<div class="contact_form_error">';
    if (!$contact_name || (!$contact_phone && !$contact_email) ) {
      echo "<h3>Form did not submit:</h3>";
    }
    if (!$contact_name) {
	    echo "Please enter a name.<br>";
    }
    if (!$contact_phone && !$contact_email) {
	  echo "Please enter a phone number or email.<br>";
    }
	echo "</div>"; // .contact_form_error
  } // end of if isset
?>
    <img src="<?php bloginfo('template_url'); ?>/assets/images/GoogleScreenGrab.png" alt="">
<button type="button" class="btn btn-info col-sm-2" data-toggle="modal" id="add-class-btn" data-target="#contact-modal">Contact Us</button>
	<!--Form Modal -->
    <form class="form-horizontal" id="contactForm" method="post" action="">
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
                                <textarea class="classForm" rows="5" id="contact_comment" name="contact_comment"></textarea>
                            </div>
    
                    </div>
                    <div class="modal-footer">
                        <input type="submit" value="Submit" name="contact_submit">
                        <input type="reset" value="Reset">
                    </div>
                </div>
            </div>
        </div><!--Modal-->
    </form>
<?php
} // end of else
?>
<!-- end of form handling -->
<section>
    <div class="container">

    </div>
</section>


	</main><!-- .site-main -->
</div><!-- .content-area -->
<?php get_footer(); ?>