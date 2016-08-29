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
<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
		<h2>BATC Contact info</h2>
        <table class="contact-table" style="text-align: center">
            <tr class="header">
				<td></td>
                <td>Facebook</td>
                <td>Email</td>
                <td>Phone</td>
                <td>Location</td>
            </tr>
		<?php
		
        global $wpdb;
        $result = $wpdb->get_results("SELECT * FROM contact_info");

        foreach($result as $row)
        {
            echo "<tr>";
            echo "<td>".$row->campus ."</td>";
            echo "<td>".$row->facebook."</td>";
            echo "<td>".$row->email."</td>";
            echo "<td>".$row->phone."</td>";
            echo "<td>".$row->location."</td>";
            echo "</tr>";
        }
		?>
        </table>
<!-- end of BATC contact info -->


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
    $to = "pitcher834@gmail.com"; 
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


<!-- start of contact form -->
<div id="contact_us">
		<h2>Contact Us</h2>
			<!-- contact form goes here? -->
			<form method="post" action="">
				I am a:<br>
				<select name="contact_is_a">
					<option value=""> - select one - </option>
					<option value='prospective student'>Prospective Student</option>
					<option value='current student'>Current Student</option>
					<option value='employer'>Employer</option>
					<option value='other'>Other</option>
				</select><br>
				Name:<br>
				<input type="text" name="contact_name" value="<?php echo $contact_name; ?>"><br>
				Phone:<br>
				<input type="tel" name="contact_phone" value="<?php $contact_phone; ?>"><br>
				Email:<br>
				<input type="email" name="contact_email" value="<?php echo $contact_email; ?>"><br>
				Comment:<br>
				<textarea name="contact_comment"><?php echo $contact_comment; ?></textarea><br><br>
				<input type="submit" value="Submit" name="contact_submit">
				<input type="submit" value="Reset">
			</form>
</div> <!-- #contact_us -->
<!-- end of contact form -->			
<?php
} // end of else
?>
<!-- end of form handling -->

<!-- start of google maps -->
	<h2>
		<a href="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2976.35541350576!2d-111.8528185845627!3d41.755994379232014!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8754875042360493%3A0x963754131e8c4ce1!2sBridgerland+Applied+Technology+College!5e0!3m2!1sen!2sus!4v1470891615172" target="BATCMap">Main Campus</a> -
		<a href="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3643.108327289421!2d-111.85675363006234!3d41.75792752479762!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x46a978a3c2839d66!2sBridgerland+Applied+Technology+College+West+Campus!5e0!3m2!1sen!2sus!4v1470892622603" target="BATCMap">West Campus</a>
	</h2>
	
	
	<div id="map" style="position: relative;padding-bottom: 75%;height: 0;overflow: hidden;">
	<iframe style="position: absolute;top: 0;left: 0;width: 100% !important;height: 100% !important;" name="BATCMap" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3643.108327289421!2d-111.85675363006234!3d41.75792752479762!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x46a978a3c2839d66!2sBridgerland+Applied+Technology+College+West+Campus!5e0!3m2!1sen!2sus!4v1470892622603" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
	</div><!-- #map -->
<!-- end of google maps -->

	</main><!-- .site-main -->
	<?php// get_sidebar( 'content-bottom' ); ?>

</div><!-- .content-area -->


<?php// get_sidebar(); ?>
<?php get_footer(); ?>