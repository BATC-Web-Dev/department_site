<?php
/*
Template Name: contacts
*/

/**
 *
 *
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

get_header(); ?>


<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
		<h1>BATC Contact info</h1>
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
		<?php
// define variables and set to empty values
$name = $email = $gender = $comment = $website = "";


function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
} // end of function

if (isset ($_POST['contact_submit'])) {
  $am_a = test_input($_POST["am_a"]);
  $name = test_input($_POST["name"]);
  $phone = test_input($_POST["phone"]);
  $email = test_input($_POST["email"]);
  $comment = test_input($_POST["comment"]);
  $comment = wordwrap($comment, 50);

$to = "pitcher834@gmail.com";
$subject = "Contact Form Submission";
$txt = "Name: $name\nRelation: $is_a\nPhone: $phone\nEmail: $email\n\n$comment";
$headers = "From: $email";

wp_mail($to,$subject,$txt,$headers);
} // end of if isset
?>

		<h1>Contact Us</h1>
			<!-- contact form goes here? -->
			<form method="post" action="">
				I am a:<br>
				<select name="am_a">
					<option value='prospect'>Prospective Student</option>
					<option value='prospect'>Current Student</option>
					<option value='employer'>Employer</option>
					<option value='other'>Other</option>
				</select><br>
				Name:<br>
				<input type="text" name="name"><br>
				Phone:<br>
				<input type="tel" name="phone"><br>
				Email:<br>
				<input type="email" name="mail"><br>
				Comment:<br>
				<input type="text" name="comment" size="50" height="4"><br><br>
				<input type="submit" value="Submit" name="contact_submit">
				<input type="reset" value="Reset">
			</form>
	<h2>
		<a href="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2976.35541350576!2d-111.8528185845627!3d41.755994379232014!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8754875042360493%3A0x963754131e8c4ce1!2sBridgerland+Applied+Technology+College!5e0!3m2!1sen!2sus!4v1470891615172" target="BATCMap">Main Campus</a> -
		<a href="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3643.108327289421!2d-111.85675363006234!3d41.75792752479762!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x46a978a3c2839d66!2sBridgerland+Applied+Technology+College+West+Campus!5e0!3m2!1sen!2sus!4v1470892622603" target="BATCMap">West Campus</a>
	</h2>
	
	
	<div id="map" style="position: relative;padding-bottom: 75%;height: 0;overflow: hidden;">
	<iframe style="position: absolute;top: 0;left: 0;width: 100% !important;height: 100% !important;" name="BATCMap" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3643.108327289421!2d-111.85675363006234!3d41.75792752479762!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x46a978a3c2839d66!2sBridgerland+Applied+Technology+College+West+Campus!5e0!3m2!1sen!2sus!4v1470892622603" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
	</div><!-- #map -->
	</main><!-- .site-main -->
	<?php get_sidebar( 'content-bottom' ); ?>

</div><!-- .content-area -->


<?php get_sidebar(); ?>
<?php get_footer(); ?>