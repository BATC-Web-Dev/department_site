<?php
/*
Template Name: RemoveClasses
*/
/**
 * The template for displaying pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

get_header();
if (isset($_POST['submit'])) {
    $id = $_POST['submit'];
    $wpdb->delete( 'wp9c_class', array( 'ID' => $id ) );
    $wpdb->delete( 'wp9c_classes', array( 'class_id' => $id ) );
    echo "<p>Class Removed From Table</p>";

}
?>
<script>
	//Change the color of the tr based on the class type
	jQuery(document).ready(function( $ ) {
		//Core
		$(".classType1").css("color", "black");
		//Front-End
		$(".classType2").css("color", "blue");
		//Backend
		$(".classType3").css("color", "orange");
	});
</script>
<div class="container">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<div class="row">
				<div class="col-md-12 lead">Remove Classes<hr></div>
			</div>
			<ul class="color-key"><!-- Change the class color key here-->
				Class Type Color Codes:
				<li style="color: black">Core,</li>
				<li style="color: blue">Front-End,</li>
				<li style="color: orange">Back-End</li>
			</ul>
			<form name="classForm" method="post" action="<?php echo get_permalink(); ?>">
				<table class="table">
					<tr class="header">
						<td>Table ID</td>
						<td>Course ID</td>
						<td>Course Name</td>
						<td>Hours</td>
						<td>Remove</td>
					</tr>
					<?php
					global $wpdb;
					$currentUser = get_current_user_id();
					$result = $wpdb->get_results("SELECT * FROM wp9c_class");
					//TODO: add error checking for database call
					foreach($result as $row)
					{
						echo "<tr class='classType$row->class_type'>";
						echo "<td>".$row->ID."</td>";
						echo "<td>".$row->course_id."</td>";
						echo "<input type='hidden' name='class_id[]' value='$row->class_id'>";
						echo "<td>".$row->course_name."</td>";
						echo "<td id='hours'>".$row->hours."</td>";
						echo "<td><button type='submit' value='$row->ID' name='submit'>Delete</button></td>";
						echo "</tr>";
					}
					?>
				</table>
			</form>
		</main><!-- .site-main -->
	</div><!-- .content-area -->
</div>
<?php get_footer(); ?>
