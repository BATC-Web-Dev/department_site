<?php
/*
Template Name: notifications
*/

/**
 * @package BATCWebDev
 * @subpackage batcitweb
 */
?>
<?php get_header(); ?>

<!-- start of notifications -->
<?php
	function decide_profile_action_taken($prime_key, $table, $ID, $meta_key, $value, $notification_field) {
		global $wpdb;
		if (isset($_POST["approve$prime_key"]) )
			{
				// if wp_usermeta table
				if ($table == 'wp_usermeta') {
					update_user_meta( 
						$ID, 
						$meta_key, 
						$value 
					);
				} // end if
				
				else {
					$updated = $wpdb->update( 
						$table, 
						array( 
							$meta_key => $value, 
						),
						array(
							'ID' => $ID,
						) 
					);
					
				} // end else
				
					$updated = $wpdb->update( 
							'notifications', 
							array( 
								$notification_field => '', 
							),
							array(
								'student_id' => $ID,
							) 
					);
					if ($updated == false) {
						echo "<script>alert('There was a problem updating notifications database.');</script>";
					}
					header("Refresh:0");
			}

		if (isset($_POST["deny$prime_key"]) )
			{
				//remove notification
				$updated = $wpdb->update( 
						'notifications', 
						array( 
							$notification_field => '', 
						),
						array(
							'student_id' => $ID,
						) 
					);
				if ($updated == false) {
					echo "<script>alert('There was a problem updating notifications database.');</script>";
				}
				header("Refresh:0");
			}

			echo "<form method='post' action=''>";
			echo "<input type='submit' name='approve$prime_key' value='approve'>";
			echo "<input type='submit' name='deny$prime_key' value='deny'><br>";
			echo "</form>";
	}
	global $wpdb;
$notifications = $wpdb->get_results("
				SELECT 
					notifications.notify_id,
					wp_users.display_name
				FROM 
					notifications 
				INNER JOIN 
					wp_users 
				ON 
					notifications.student_id = wp_users.ID
				");

echo "<ul>";
foreach ($notifications as $row) {
	
	$results = $wpdb->get_results("
				SELECT 
					notifications.notify_id,
					notifications.new_description,
					notifications.new_email,
					notifications.new_url,
					notifications.new_url_2,
					notifications.new_url_3,
					notifications.new_job,
					notifications.new_spec,
					wp_users.display_name, 
					wp_users.user_email,
					wp_users.user_url,
					wp_users.ID
				FROM 
					notifications 
				INNER JOIN 
					wp_users 
				ON 
					notifications.student_id = wp_users.ID
				WHERE
					notify_id=$row->notify_id
				");
	$result = $results[0];
				
	$meta_description = $wpdb->get_results("SELECT meta_value FROM wp_usermeta WHERE user_id=$result->ID AND meta_key='description'");
	$meta_user_url_2 = $wpdb->get_results("SELECT meta_value FROM wp_usermeta WHERE user_id=$result->ID AND meta_key='user_url_2'");
	$meta_user_url_3 = $wpdb->get_results("SELECT meta_value FROM wp_usermeta WHERE user_id=$result->ID AND meta_key='user_url_3'");
	$meta_user_job = $wpdb->get_results("SELECT meta_value FROM wp_usermeta WHERE user_id=$result->ID AND meta_key='user_job'");
	$meta_user_spec = $wpdb->get_results("SELECT meta_value FROM wp_usermeta WHERE user_id=$result->ID AND meta_key='user_spec'");
	
	
	 $num_pending = 0;
	if ($result->new_description != $meta_description[0]->meta_value && $result->new_description != '') {$num_pending++;}
	if ($result->new_email != $result->user_email && $result->new_email != '') {$num_pending++;}
	if ($result->new_url != $result->user_url && $result->new_url != '') {$num_pending++;}
	if ($result->new_url_2 != $meta_user_url_2[0]->meta_value && $result->new_url_2 != '') {$num_pending++;}
	if ($result->new_url_3 != $meta_user_url_3[0]->meta_value && $result->new_url_3 != '') {$num_pending++;}
	if ($result->new_job != $meta_user_job[0]->meta_value && $result->new_job != '') {$num_pending++;}
	if ($result->new_spec != $meta_user_spec[0]->meta_value && $result->new_spec != '') {$num_pending++;}
	
	// delete row from table if empty
	if($num_pending == 0) {
		$updated = $wpdb->delete( 
			'notifications',
			array(
				'student_id' => $result->ID,
			) 
		);
	}
	//display row if not empty
	else {
		if ($num_pending == 1) $plural = '';
		else $plural = 's';
		
		echo "<li><a id='notification$row->notify_id'>$row->display_name has $num_pending update$plural pending approval.</a></li>";
		
		
		/***** start: pull out of loop and put in modal *****/

				
		echo "<h3>$result->display_name wants to change his/her:</h3>";
		echo "<ul>";
	
		if ($result->new_description != $meta_description[0]->meta_value && $result->new_description != '') {
			echo "<li>Bio from '" . $meta_description[0]->meta_value . "' to '$result->new_description'<br>";
				decide_profile_action_taken("bio$result->notify_id", "wp_usermeta", $result->ID, "description", $result->new_description, "new_description");
			echo "</li>";
		}
	
		if ($result->new_email != $result->user_email && $result->new_email != '') {
			echo "<li>Email from '$result->user_email' to '$result->new_email'<br>";
				//email needs handled differently because it has to be unique
				//decide_profile_action_taken("email$result->notify_id", $result->ID);
			echo "</li>";
		}
	
		if ($result->new_url != $result->user_url && $result->new_url != '') {
			echo "<li>Primary Website from '$result->user_url' to '$result->new_url'<br>";
				decide_profile_action_taken("url_$result->notify_id", "wp_users", $result->ID, "user_url", $result->new_url, "new_url");
			echo "</li>";
		}
	
		if ($result->new_url_2 != $meta_user_url_2[0]->meta_value && $result->new_url_2 != '') {
			echo "<li>Second Website from '" . $meta_user_url_2[0]->meta_value . "' to '$result->new_url_2'<br>";
				decide_profile_action_taken("url2_$result->notify_id", "wp_usermeta", $result->ID, "user_url_2", $result->new_url_2, "new_url_2");
			echo "</li>";
		}
	
		if ($result->new_url_3 != $meta_user_url_3[0]->meta_value && $result->new_url_3 != '') {
			echo "<li>Third Website from '" . $meta_user_url_3[0]->meta_value . "' to '$result->new_url_3'<br>";
				decide_profile_action_taken("url3_$result->notify_id", "wp_usermeta", $result->ID, "user_url_3", $result->new_url_3, "new_url_3");
			echo "</li>";
		}
	
		if ($result->new_job != $meta_user_job[0]->meta_value && $result->new_job != '') {
			echo "<li>Employment from '" . $meta_user_job[0]->meta_value . "' to '$result->new_job'<br>";
				decide_profile_action_taken("job$result->notify_id", "wp_usermeta", $result->ID, "user_job", $result->new_job, "new_job");
			echo "</li>";
		}
	
		if ($result->new_spec != $meta_user_spec[0]->meta_value && $result->new_spec != '') {
			echo "<li>Specialization from '" . $meta_user_spec[0]->meta_value . "' to '$result->new_spec'<br>";
				decide_profile_action_taken("spec$result->notify_id", "wp_usermeta", $result->ID, "user_spec", $result->new_spec, "new_spec");
			echo "</li>";
		}
	
		echo "</ul>";
	
		/***** end of: pull out of loop and put in modal *****/
	}
} // end of foreach
echo "</ul>";
?>

<?php

?>

<?php get_footer(); ?>