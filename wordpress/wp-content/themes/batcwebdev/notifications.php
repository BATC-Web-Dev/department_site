<?php
/*
Template Name: notifications
*/

/**
 * @package BATCWebDev
 * @subpackage batcitweb
 */
?>
	<?php
	global $wpdb;
	$notifications = $wpdb->get_results("
				SELECT 
					notifications.notify_id,
					wp_users.display_name,
					wp_users.user_email
				FROM 
					notifications 
				INNER JOIN 
					wp_users 
				ON 
					notifications.student_id = wp_users.ID
				");
				
	if ($notifications[0]->notify_id) {
		$num_notifications = count($notifications);
		$to = "pitcher834@gmail.com"; 
		$subject = "Pending Notifications - BATCWebDev";
		$name_list = "\n";
		foreach($notifications as $person) {
			$name_list .= $person->display_name;
			$name_list .= "\n";
		}
		$are_num_people = ($num_notifications == 1 ? "is 1 person" : "are $num_notifications people");
		$txt = "There $are_num_people awaiting approval. $name_list";
		
		wp_mail($to,$subject,$txt);
	}
	?>