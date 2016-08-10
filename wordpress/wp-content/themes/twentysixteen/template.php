<?php
/*
Template Name: Class
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

get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
        <h1>Classes</h1>
        <table class="class-table" style="text-align: center">
            <tr class="header">
                <td>Course ID</td>
                <td>Course Name</td>
                <td>Hours</td>
                <td>Finished</td>
            </tr>
		<?php
        global $wpdb;
        $result = $wpdb->get_results("SELECT * FROM class");

        foreach($result as $row)
        {
            echo "<tr>";
            echo "<td>".$row->course_id."</td>";
            echo "<td>".$row->course_name."</td>";
            echo "<td>".$row->hours."</td>";
            echo "<td><input type='checkbox'></td>";
            echo "</tr>";
        }

		?>
            <tr>
                <td></td>
                <td>Completed Hours</td>
                <!-- Find a way to add the selected cells to produce a sum -->
                <td></td>
                <td></td>
            </tr>
        </table>
	</main><!-- .site-main -->
	<?php get_sidebar( 'content-bottom' ); ?>

</div><!-- .content-area -->


<?php get_sidebar(); ?>
<?php get_footer(); ?>

<!--echo "<pre>"; print_r($result); echo "</pre>";
echo "ID"."  "."Name"."<br><br>" ;
echo $row->course_id."  ".$row->course_name."  ".$row->hours;
echo "<input type='checkbox'>.$row->finished"."<br><br>";-->
