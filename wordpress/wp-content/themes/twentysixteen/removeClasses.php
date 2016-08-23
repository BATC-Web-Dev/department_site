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
    $wpdb->delete( 'class', array( 'ID' => $id ) );
    $wpdb->delete( 'classes', array( 'class_id' => $id ) );
    echo "<p>Class Removed From Table</p>";

}
?>
<script>
	//Change the color of the tr based on the class type
	jQuery(document).ready(function( $ ) {
		//Core
		$(".classType1").css("color", "red");
		//Front-End
		$(".classType2").css("color", "blue");
		//Backend
		$(".classType3").css("color", "green");
		//Table Stripe
		$( "tr:odd" ).css( "background-color", "#eee" );

	});
</script>
<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
		<h1>Remove Classes</h1>
			<ul><!-- Change the class color key here-->
				<li style="color: red">Core</li>
				<li style="color: blue">Front-End</li>
				<li style="color: green">Back-End</li>
			</ul>
		<form name="classForm" method="post" action="<?php echo get_permalink(); ?>">
			<table class="class-table">
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
				$result = $wpdb->get_results("SELECT * FROM class");
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

	<?php get_sidebar( 'content-bottom' ); ?>

</div><!-- .content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
