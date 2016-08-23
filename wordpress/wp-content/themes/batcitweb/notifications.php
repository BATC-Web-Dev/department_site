<?php
/*
Template Name: notifications
*/

/**
 *
 *
 *
 * @package WordPress
 * @subpackage batcitweb
 */

get_header(); ?>
<?php
if ( is_user_logged_in() && current_user_can('administrator')) {
?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
		<h1>Notifications</h1>
		<?php
		
        global $wpdb;
        $result = $wpdb->get_results("SELECT * FROM notices");

        foreach($result as $row)
        {
            echo "$row->user wants to change his/her $row->field from $row->old_val to $row->new_val" ;
			
			echo "<form method='post' action=''>";
			echo "<input type='submit' name='accept$j' value='accept'>";
			echo "<input type='submit' name='decline$j' value='decline'><br>";
			echo "<a class='linkbutton' href='members.php?view=" . $requester . "'><button class='button'>View Profile</button></a>";
        }
        $result = $wpdb->get_results("SELECT * FROM notices");
	$rows = $result->num_rows;

	if ($rows == 0)
	{
		echo "You have no notices at this time.<br>";
	}
	else
	{
		for ($j = 0 ; $j < $rows ; ++$j)
		{
			$result->data_seek($j);
			$row = $result->fetch_array(MYSQLI_ASSOC);
			// $requester = $row['requester'];
			
			
			if (isset($_POST['accept' . $j]))
			{
				// addFriend($user, $requester);
				// echo "<script>window.location.assign('notices.php?view=$user');</script>";
			}
            echo "$row->user wants to change his/her $row->field from $row->old_val to $row->new_val" ;
			echo "<form method='post' action=''>";
			echo "<input class='button' type='submit' name='accept$j' value='accept'>";
			echo "<input class='button' type='submit' name='decline$j' value='decline'><br>";
			// add link to subscriber's profile page
			// echo "<a href=""><button>View Profile</button></a>";
			
		?>
        </table>
	
	</main><!-- .site-main -->
	<?php get_sidebar( 'content-bottom' ); ?>

</div><!-- .content-area -->

<?php
} // end if administrator
?>
<?php get_sidebar(); ?>
<?php get_footer(); ?>