<?php
/*
If you would like to edit this file, copy it to your current theme's directory and edit it there.
Theme My Login will always look in your theme's directory first, before using this default template.
*/
?>
<?php
$user = wp_get_current_user();
if ( in_array( 'subscriber', (array) $user->roles ) ) {
    //The user has the "subscriber" role
	?>
	<div class="tml tml-profile" id="theme-my-login<?php $template->the_instance(); ?>">
		<?php $template->the_action_template_message( 'profile' ); ?>
		<?php $template->the_errors(); ?>
		<form id="your-profile" action="<?php $template->the_action_url( 'profile', 'login_post' ); ?>" method="post">
			<?php wp_nonce_field( 'update-user_' . $current_user->ID ); ?>
			<p>
				<input type="hidden" name="from" value="profile" />
				<input type="hidden" name="checkuser_id" value="<?php echo $current_user->ID; ?>" />
			</p>

			<h3><?php _e( 'Personal Options', 'theme-my-login' ); ?></h3>
	
			<table class="tml-form-table">
			<tr class="tml-user-admin-bar-front-wrap">
				<th><label for="admin_bar_front"><?php _e( 'Toolbar', 'theme-my-login' )?></label></th>
				<td>
					<label for="admin_bar_front"><input type="checkbox" name="admin_bar_front" id="admin_bar_front" value="1"<?php checked( _get_admin_bar_pref( 'front', $profileuser->ID ) ); ?> />
					<?php _e( 'Show Toolbar when viewing site', 'theme-my-login' ); ?></label>
				</td>
			</tr>
			<?php do_action( 'personal_options', $profileuser ); ?>
			</table>
	
			<?php do_action( 'profile_personal_options', $profileuser ); ?>

			<h3><?php _e( 'Name', 'theme-my-login' ); ?></h3>

			<table class="tml-form-table">
			<tr class="tml-user-login-wrap">
				<th><label for="user_login"><?php _e( 'Username', 'theme-my-login' ); ?></label></th>
				<td><input type="text" name="user_login" id="user_login" value="<?php echo esc_attr( $profileuser->user_login ); ?>" disabled="disabled" class="regular-text" /> <span class="description"><?php _e( 'Usernames cannot be changed.', 'theme-my-login' ); ?></span></td>
			</tr>

<!-- start of first name field -->
			<?php
			$display_old_val = "";
			if ($profileuser->approve_first_name) {
				if ($profileuser->first_name == "") {
					$old_first_name = "blank";
				}
				else {
					$old_first_name = "as $profileuser->first_name";
				}
				$first_name_value = $profileuser->approve_first_name;
				$first_name_label = "First Name - <span class='approval'>pending approval</span>";
				$display_old_val = "Your first name will remain $old_first_name until $first_name_value is approved.";
			}
			else {
				$first_name_value = $profileuser->first_name;
				$first_name_label = "First Name";
			}
				?>
			<tr class="tml-first-name-wrap">
				<th><label for="approve_first_name"><?php _e( $first_name_label, 'theme-my-login' ); ?></label></th>
				<td><input type="text" name="approve_first_name" id="approve_first_name" value="<?php echo esc_attr( $first_name_value ); ?>" class="regular-text" />
				<span class="approval"><?php _e( $display_old_val); ?></span></td>
			</tr>
<!-- end of first name field -->

<!-- start of last name field -->
			<?php
			$display_old_val = "";
			if ($profileuser->approve_last_name) {
				if ($profileuser->last_name == "") {
					$old_last_name = "blank";
				}
				else {
					$old_last_name = "as $profileuser->last_name";
				}
				$last_name_value = $profileuser->approve_last_name;
				$last_name_label = "Last Name - <span class='approval'>pending approval</span>";
				$display_old_val = "Your last name will remain $old_last_name until $last_name_value is approved.";
			}
			else {
				$last_name_value = $profileuser->last_name;
				$last_name_label = "Last Name";
			}
				?>
			<tr class="tml-last-name-wrap">
				<th><label for="approve_last_name"><?php _e( $last_name_label, 'theme-my-login' ); ?></label></th>
				<td><input type="text" name="approve_last_name" id="approve_last_name" value="<?php echo esc_attr( $last_name_value ); ?>" class="regular-text" />
				<span class="approval"><?php _e( $display_old_val); ?></span></td>
			</tr>
<!-- end of last name field -->

<!-- start of nickname field -->
			<?php
			$display_old_val = "";
			if ($profileuser->approve_nickname && $profileuser->approve_nickname != $profileuser->nickname) {
				if ($profileuser->nickname == "") {
					$old_nickname = "blank";
				}
				else {
					$old_nickname = "as $profileuser->nickname";
				}
				$nickname_value = $profileuser->approve_nickname;
				$nickname_label = "Nickname - <span class='approval'>pending approval</span>";
				$display_old_val = "Your nickname will remain $old_nickname until $nickname_value is approved.";
			}
			else {
				$nickname_value = $profileuser->nickname;
				$nickname_label = "Nickname ";
			}
				?>
			<tr class="tml-nick-name-wrap">
				<th><label for="approve_nickname"><?php _e( $nickname_label, 'theme-my-login' ); ?></label></th>
				<td><input type="text" name="approve_nickname" id="approve_nickname" value="<?php echo esc_attr( $nickname_value ); ?>" class="regular-text" />
				<span class="approval"><?php _e( $display_old_val); ?></span></td>
			</tr>
			
						<tr class="tml-nickname-wrap">
				
				<td><input type="hidden" name="nickname" id="nickname" value="<?php echo esc_attr( $profileuser->nickname ); ?>" class="regular-text" /></td>
			</tr>
<!-- end of nickname field -->

<!-- start of display name field -->
			<tr class="tml-display-name-wrap">
				<th><label for="display_name"><?php _e( 'Display name publicly as', 'theme-my-login' ); ?></label></th>
				<td>
					<select name="display_name" id="display_name">
					<?php
						$public_display = array();
						$public_display['display_nickname']  = $profileuser->nickname;
						$public_display['display_username']  = $profileuser->user_login;

						if ( ! empty( $profileuser->first_name ) )
							$public_display['display_firstname'] = $profileuser->first_name;

						if ( ! empty( $profileuser->last_name ) )
							$public_display['display_lastname'] = $profileuser->last_name;
	
						if ( ! empty( $profileuser->first_name ) && ! empty( $profileuser->last_name ) ) {
							$public_display['display_firstlast'] = $profileuser->first_name . ' ' . $profileuser->last_name;
							$public_display['display_lastfirst'] = $profileuser->last_name . ' ' . $profileuser->first_name;
						}

						if ( ! in_array( $profileuser->display_name, $public_display ) )// Only add this if it isn't duplicated elsewhere
							$public_display = array( 'display_displayname' => $profileuser->display_name ) + $public_display;

						$public_display = array_map( 'trim', $public_display );
						$public_display = array_unique( $public_display );

						foreach ( $public_display as $id => $item ) {
					?>
						<option <?php selected( $profileuser->display_name, $item ); ?>><?php echo $item; ?></option>
					<?php
						}
					?>
					</select>
				</td>
			</tr>
<!-- end of display name field -->
			</table>

			<h3><?php _e( 'Contact Info', 'theme-my-login' ); ?></h3>

			<table class="tml-form-table">
			
<!-- start of email field -->
			<tr class="tml-user-email-wrap">
				<th><label for="email"><?php _e( 'E-mail', 'theme-my-login' ); ?> <span class="description"><?php _e( '(required)', 'theme-my-login' ); ?></span></label></th>
				<td><input type="text" name="email" id="email" value="<?php echo esc_attr( $profileuser->user_email ); ?>" class="regular-text" /></td>
				<?php
				$new_email = get_option( $current_user->ID . '_new_email' );
				if ( $new_email && $new_email['newemail'] != $current_user->user_email ) : ?>
				<div class="updated inline">
				<p><?php
					printf(
						__( 'There is a pending change of your e-mail to %1$s. <a href="%2$s">Cancel</a>', 'theme-my-login' ),
						'<code>' . $new_email['newemail'] . '</code>',
						esc_url( self_admin_url( 'profile.php?dismiss=' . $current_user->ID . '_new_email' ) )
				); ?></p>
				</div>
				<?php endif; ?>
			</tr>
<!-- end of email field -->
			
<!-- start of primary website field -->
			<?php
			$display_old_val = "";
			if ($profileuser->approve_user_url) {
			//	if ($profileuser->last_name == "") {
			//		$old_last_name = "blank";
			//	}
			//	else {
					$old_user_url = "as $profileuser->user_url";
			//	}
				$user_url_value = $profileuser->approve_user_url;
				$user_url_label = "Primary Website - <span class='approval'>pending approval</span>";
				$display_old_val = "Your primary website will remain $old_user_url until $user_url_value is approved.";
			}
			else {
				$user_url_value = $profileuser->user_url;
				$user_url_label = "Primary Website";
			}
				?>
			<tr class="tml-user_url-wrap">
				<th><label for="approve_user_url"><?php _e( $user_url_label, 'theme-my-login' ); ?></label></th>
				<td><input type="text" name="approve_user_url" id="approve_user_url" value="<?php echo esc_attr( $user_url_value ); ?>" class="regular-text" />
				<span class="approval"><?php _e( $display_old_val); ?></span></td>
			</tr>
<!-- end of primary website field -->

<!-- start of second website field -->
			<?php
			$display_old_val = "";
			if ($profileuser->approve_user_url_2) {
				if ($profileuser->user_url_2 == "") {
					$old_user_url_2 = "blank";
				}
				else {
					$old_user_url_2 = "as $profileuser->user_url_2";
				}
				$user_url_value_2 = $profileuser->approve_user_url_2;
				$user_url_label_2 = "Second Website - <span class='approval'>pending approval</span>";
				$display_old_val = "This website url will remain $old_user_url_2 until $user_url_value_2 is approved.";
			}
			else {
				$user_url_value_2 = $profileuser->user_url_2;
				$user_url_label_2 = "Second Website";
			}
				?>
			<tr class="tml-user_url-wrap">
				<th><label for="approve_user_url_2"><?php _e( $user_url_label_2, 'theme-my-login' ); ?></label></th>
				<td><input type="text" name="approve_user_url_2" id="approve_user_url_2" value="<?php echo esc_attr( $user_url_value_2 ); ?>" class="regular-text" />
				<span class="approval"><?php _e( $display_old_val); ?></span></td>
			</tr>
<!-- end of second website field -->

<!-- start of third website field -->
			<?php
			$display_old_val = "";
			if ($profileuser->approve_user_url_3) {
				if ($profileuser->user_url_3 == "") {
					$old_user_url_3 = "blank";
				}
				else {
					$old_user_url_3 = "as $profileuser->user_url_3";
				}
				$user_url_value_3 = $profileuser->approve_user_url_3;
				$user_url_label_3 = "Third Website - <span class='approval'>pending approval</span>";
				$display_old_val = "This website url will remain $old_user_url_3 until $user_url_value_3 is approved.";
			}
			else {
				$user_url_value_3 = $profileuser->user_url_3;
				$user_url_label_3 = "Third Website";
			}
				?>
			<tr class="tml-user_url-wrap">
				<th><label for="approve_user_url_3"><?php _e( $user_url_label_3, 'theme-my-login' ); ?></label></th>
				<td><input type="text" name="approve_user_url_3" id="approve_user_url_3" value="<?php echo esc_attr( $user_url_value_3 ); ?>" class="regular-text" />
				<span class="approval"><?php _e( $display_old_val); ?></span></td>
			</tr>
<!-- end of third website field -->
			</table>

<!-- start of bio field -->
<script>
    jQuery(document).ready(function( $ ) {
        var approve_text_max = 140;
        $('#approve_textarea_feedback').html((approve_text_max - $('#approve_description').val().length) + ' characters remaining');

        $('#approve_description').keyup(function() {
            var approve_text_length = $('#approve_description').val().length;
			var approve_text_remaining = approve_text_max - approve_text_length;

            $('#approve_textarea_feedback').html(approve_text_remaining + ' characters remaining');
        });
    });
</script>
			<?php
			$display_old_val = "";
			if ($profileuser->approve_description) {
				$old_description = $profileuser->description;
				$description_value = $profileuser->approve_description;
				$description_label = "Bio max 140 characters - <span class='approval'>pending approval</span>";
				$display_old_val = "<br>Your old bio will remain until this one is approved.";
			}
			else {
				$description_value = $profileuser->description;
				$description_label = "Biographical Info";
			}
				?>
			<table class="tml-form-table">
			<tr class="tml-user-description-wrap">
				<th><label for="approve_description"><?php _e( $description_label, 'theme-my-login' ); ?></label></th><td><textarea name="approve_description" id="approve_description" rows="5" cols="30" maxlength="140">
				<?php echo esc_html( $description_value ); ?></textarea><br /><div id="approve_textarea_feedback">info</div>
				<span><?php _e("Share a bio that could fit in a Tweet."); ?></span><span class="approval"><?php _e( "$display_old_val", 'theme-my-login' ); ?></span></td>
				<th><label for "old_bio"><?php _e("Old Biographical Information"); ?></label></th>
				<td><div class="old_bio" name="old_bio"><?php _e( "$old_description" ); ?></div></td>
			</tr>
<!-- end of bio field -->

			<?php
			$show_password_fields = apply_filters( 'show_password_fields', true, $profileuser );
			if ( $show_password_fields ) :
			?>
			</table>

			<h3><?php _e( 'Account Management', 'theme-my-login' ); ?></h3>
			<table class="tml-form-table">
			<tr id="password" class="user-pass1-wrap">
				<th><label for="pass1"><?php _e( 'New Password', 'theme-my-login' ); ?></label></th>
				<td>
					<input class="hidden" value=" " /><!-- #24364 workaround -->
					<button type="button" class="button button-secondary wp-generate-pw hide-if-no-js"><?php _e( 'Generate Password', 'theme-my-login' ); ?></button>
					<div class="wp-pwd hide-if-js">
						<span class="password-input-wrapper">
							<input type="password" name="pass1" id="pass1" class="regular-text" value="" autocomplete="off" data-pw="<?php echo esc_attr( wp_generate_password( 24 ) ); ?>" aria-describedby="pass-strength-result" />
						</span>
						<div style="display:none" id="pass-strength-result" aria-live="polite"></div>
						<button type="button" class="button button-secondary wp-hide-pw hide-if-no-js" data-toggle="0" aria-label="<?php esc_attr_e( 'Hide password', 'theme-my-login' ); ?>">
							<span class="dashicons dashicons-hidden"></span>
							<span class="text"><?php _e( 'Hide', 'theme-my-login' ); ?></span>
						</button>
						<button type="button" class="button button-secondary wp-cancel-pw hide-if-no-js" data-toggle="0" aria-label="<?php esc_attr_e( 'Cancel password change', 'theme-my-login' ); ?>">
							<span class="text"><?php _e( 'Cancel', 'theme-my-login' ); ?></span>
						</button>
					</div>
				</td>
			</tr>
			<tr class="user-pass2-wrap hide-if-js">
				<th scope="row"><label for="pass2"><?php _e( 'Repeat New Password', 'theme-my-login' ); ?></label></th>
				<td>
				<input name="pass2" type="password" id="pass2" class="regular-text" value="" autocomplete="off" />
				<p class="description"><?php _e( 'Type your new password again.', 'theme-my-login' ); ?></p>
				</td>
			</tr>
			<tr class="pw-weak">
				<th><?php _e( 'Confirm Password', 'theme-my-login' ); ?></th>
				<td>
					<label>
						<input type="checkbox" name="pw_weak" class="pw-checkbox" />
						<?php _e( 'Confirm use of weak password', 'theme-my-login' ); ?>
					</label>
				</td>
			</tr>
			<?php endif; ?>

			</table>

			<?php do_action( 'show_user_profile', $profileuser ); ?>

			<p class="tml-submit-wrap">
				<input type="hidden" name="action" value="profile" />
				<input type="hidden" name="instance" value="<?php $template->the_instance(); ?>" />
				<input type="hidden" name="user_id" id="user_id" value="<?php echo esc_attr( $current_user->ID ); ?>" />
				<input type="submit" class="button-primary" value="<?php esc_attr_e( 'Update Profile', 'theme-my-login' ); ?>" name="submit" id="submit" />
			</p>
		</form>
	</div>
<?php
} // end if subscriber
else if ( in_array( 'administrator', (array) $user->roles ) ) {
    //The user has the "administrator" role
	?>
	<div class="tml tml-profile" id="theme-my-login<?php $template->the_instance(); ?>">
		<?php $template->the_action_template_message( 'profile' ); ?>
		<?php $template->the_errors(); ?>
		<form id="your-profile" action="<?php $template->the_action_url( 'profile', 'login_post' ); ?>" method="post">
			<?php wp_nonce_field( 'update-user_' . $current_user->ID ); ?>
			<p>
				<input type="hidden" name="from" value="profile" />
				<input type="hidden" name="checkuser_id" value="<?php echo $current_user->ID; ?>" />
			</p>

			<h3><?php _e( 'Personal Options', 'theme-my-login' ); ?></h3>
	
			<table class="tml-form-table">
			<tr class="tml-user-admin-bar-front-wrap">
				<th><label for="admin_bar_front"><?php _e( 'Toolbar', 'theme-my-login' )?></label></th>
				<td>
					<label for="admin_bar_front"><input type="checkbox" name="admin_bar_front" id="admin_bar_front" value="1"<?php checked( _get_admin_bar_pref( 'front', $profileuser->ID ) ); ?> />
					<?php _e( 'Show Toolbar when viewing site', 'theme-my-login' ); ?></label>
				</td>
			</tr>
			<?php do_action( 'personal_options', $profileuser ); ?>
			</table>
	
			<?php do_action( 'profile_personal_options', $profileuser ); ?>

			<h3><?php _e( 'Name', 'theme-my-login' ); ?></h3>

			<table class="tml-form-table">
			<tr class="tml-user-login-wrap">
				<th><label for="user_login"><?php _e( 'Username', 'theme-my-login' ); ?></label></th>
				<td><input type="text" name="user_login" id="user_login" value="<?php echo esc_attr( $profileuser->user_login ); ?>" disabled="disabled" class="regular-text" /> <span class="description"><?php _e( 'Usernames cannot be changed.', 'theme-my-login' ); ?></span></td>
			</tr>

			<tr class="tml-first-name-wrap">
				<th><label for="first_name"><?php _e( 'First Name', 'theme-my-login' ); ?></label></th>
				<td><input type="text" name="first_name" id="first_name" value="<?php echo esc_attr( $profileuser->first_name ); ?>" class="regular-text" /></td>
			</tr>

			<tr class="tml-last-name-wrap">
				<th><label for="last_name"><?php _e( 'Last Name', 'theme-my-login' ); ?></label></th>
				<td><input type="text" name="last_name" id="last_name" value="<?php echo esc_attr( $profileuser->last_name ); ?>" class="regular-text" /></td>
			</tr>

			<tr class="tml-nickname-wrap">
				<th><label for="nickname"><?php _e( 'Nickname', 'theme-my-login' ); ?> <span class="description"><?php _e( '(required)', 'theme-my-login' ); ?></span></label></th>
				<td><input type="text" name="nickname" id="nickname" value="<?php echo esc_attr( $profileuser->nickname ); ?>" class="regular-text" /></td>
			</tr>

			<tr class="tml-display-name-wrap">
				<th><label for="display_name"><?php _e( 'Display name publicly as', 'theme-my-login' ); ?></label></th>
				<td>
					<select name="display_name" id="display_name">
					<?php
						$public_display = array();
						$public_display['display_nickname']  = $profileuser->nickname;
						$public_display['display_username']  = $profileuser->user_login;

						if ( ! empty( $profileuser->first_name ) )
							$public_display['display_firstname'] = $profileuser->first_name;

						if ( ! empty( $profileuser->last_name ) )
							$public_display['display_lastname'] = $profileuser->last_name;
	
						if ( ! empty( $profileuser->first_name ) && ! empty( $profileuser->last_name ) ) {
							$public_display['display_firstlast'] = $profileuser->first_name . ' ' . $profileuser->last_name;
							$public_display['display_lastfirst'] = $profileuser->last_name . ' ' . $profileuser->first_name;
						}

						if ( ! in_array( $profileuser->display_name, $public_display ) )// Only add this if it isn't duplicated elsewhere
							$public_display = array( 'display_displayname' => $profileuser->display_name ) + $public_display;

						$public_display = array_map( 'trim', $public_display );
						$public_display = array_unique( $public_display );

						foreach ( $public_display as $id => $item ) {
					?>
						<option <?php selected( $profileuser->display_name, $item ); ?>><?php echo $item; ?></option>
					<?php
						}
					?>
					</select>
				</td>
			</tr>
			</table>

			<h3><?php _e( 'Contact Info', 'theme-my-login' ); ?></h3>

			<table class="tml-form-table">
			<tr class="tml-user-email-wrap">
				<th><label for="email"><?php _e( 'E-mail', 'theme-my-login' ); ?> <span class="description"><?php _e( '(required)', 'theme-my-login' ); ?></span></label></th>
				<td><input type="text" name="email" id="email" value="<?php echo esc_attr( $profileuser->user_email ); ?>" class="regular-text" /></td>
				<?php
				$new_email = get_option( $current_user->ID . '_new_email' );
				if ( $new_email && $new_email['newemail'] != $current_user->user_email ) : ?>
				<div class="updated inline">
				<p><?php
					printf(
						__( 'There is a pending change of your e-mail to %1$s. <a href="%2$s">Cancel</a>', 'theme-my-login' ),
						'<code>' . $new_email['newemail'] . '</code>',
						esc_url( self_admin_url( 'profile.php?dismiss=' . $current_user->ID . '_new_email' ) )
				); ?></p>
				</div>
				<?php endif; ?>
			</tr>

<!-- start of primary website field -->
			<?php
			$user_url_value = $profileuser->user_url;
			$user_url_label = "Primary Website";
			?>
			<tr class="tml-user_url-wrap">
				<th><label for="user_url"><?php _e( $user_url_label, 'theme-my-login' ); ?></label></th>
				<td><input type="text" name="user_url" id="user_url" value="<?php echo esc_attr( $user_url_value ); ?>" class="regular-text" /></td>
			</tr>
<!-- end of primary website field -->


<!-- start of second website field -->
			<?php
			$user_url_value_2 = $profileuser->user_url_2;
			$user_url_label_2 = "Second Website";
			?>
			<tr class="tml-user_url_2-wrap">
				<th><label for="user_url_2"><?php _e( $user_url_label_2, 'theme-my-login' ); ?></label></th>
				<td><input type="text" name="user_url_2" id="user_url_2" value="<?php echo esc_attr( $user_url_value_2 ); ?>" class="regular-text" /></td>
			</tr>
<!-- end of second website field -->

<!-- start of third website field -->
			<?php
			$user_url_value_3 = $profileuser->user_url_3;
			$user_url_label_3 = "Third Website";
			?>
			<tr class="tml-user_url_3-wrap">
				<th><label for="user_url_3"><?php _e( $user_url_label_3, 'theme-my-login' ); ?></label></th>
				<td><input type="text" name="user_url_3" id="user_url_3" value="<?php echo esc_attr( $user_url_value_3 ); ?>" class="regular-text" /></td>
			</tr>
<!-- end of third website field -->

			
			</table>
<!-- start of bio field -->
<script>
    jQuery(document).ready(function( $ ) {
        var text_max = 140;
        $('#textarea_feedback').html((text_max - $('#description').val().length) + ' characters remaining');

        $('#description').keyup(function() {
            var text_length = $('#description').val().length;
            var text_remaining = text_max - text_length;

            $('#textarea_feedback').html(text_remaining + ' characters remaining');
        });
    });
</script>
			<h3><?php _e( 'About Yourself', 'theme-my-login' ); ?></h3>

			<table class="tml-form-table">
			<tr class="tml-user-description-wrap">
				<th><label for="description"><?php _e( 'Biographical Info', 'theme-my-login' ); ?></label></th>
				<td><textarea name="description" id="description" rows="3" cols="30" maxlength="140"><?php echo esc_html( $profileuser->description ); ?></textarea><br />
				<div id="textarea_feedback"></div><span class="description">
				<?php _e( 'Share a little biographical information to fill out your profile. This may be shown publicly.', 'theme-my-login' ); ?></span></td>
			</tr>
<!-- end of bio field -->

			<?php
			$show_password_fields = apply_filters( 'show_password_fields', true, $profileuser );
			if ( $show_password_fields ) :
			?>
			</table>

			<h3><?php _e( 'Account Management', 'theme-my-login' ); ?></h3>
			<table class="tml-form-table">
			<tr id="password" class="user-pass1-wrap">
				<th><label for="pass1"><?php _e( 'New Password', 'theme-my-login' ); ?></label></th>
				<td>
					<input class="hidden" value=" " /><!-- #24364 workaround -->
					<button type="button" class="button button-secondary wp-generate-pw hide-if-no-js"><?php _e( 'Generate Password', 'theme-my-login' ); ?></button>
					<div class="wp-pwd hide-if-js">
						<span class="password-input-wrapper">
							<input type="password" name="pass1" id="pass1" class="regular-text" value="" autocomplete="off" data-pw="<?php echo esc_attr( wp_generate_password( 24 ) ); ?>" aria-describedby="pass-strength-result" />
						</span>
						<div style="display:none" id="pass-strength-result" aria-live="polite"></div>
						<button type="button" class="button button-secondary wp-hide-pw hide-if-no-js" data-toggle="0" aria-label="<?php esc_attr_e( 'Hide password', 'theme-my-login' ); ?>">
							<span class="dashicons dashicons-hidden"></span>
							<span class="text"><?php _e( 'Hide', 'theme-my-login' ); ?></span>
						</button>
						<button type="button" class="button button-secondary wp-cancel-pw hide-if-no-js" data-toggle="0" aria-label="<?php esc_attr_e( 'Cancel password change', 'theme-my-login' ); ?>">
							<span class="text"><?php _e( 'Cancel', 'theme-my-login' ); ?></span>
						</button>
					</div>
				</td>
			</tr>
			<tr class="user-pass2-wrap hide-if-js">
				<th scope="row"><label for="pass2"><?php _e( 'Repeat New Password', 'theme-my-login' ); ?></label></th>
				<td>
				<input name="pass2" type="password" id="pass2" class="regular-text" value="" autocomplete="off" />
				<p class="description"><?php _e( 'Type your new password again.', 'theme-my-login' ); ?></p>
				</td>
			</tr>
			<tr class="pw-weak">
				<th><?php _e( 'Confirm Password', 'theme-my-login' ); ?></th>
				<td>
					<label>
						<input type="checkbox" name="pw_weak" class="pw-checkbox" />
						<?php _e( 'Confirm use of weak password', 'theme-my-login' ); ?>
					</label>
				</td>
			</tr>
			<?php endif; ?>

			</table>

			<?php do_action( 'show_user_profile', $profileuser ); ?>

			<p class="tml-submit-wrap">
				<input type="hidden" name="action" value="profile" />
				<input type="hidden" name="instance" value="<?php $template->the_instance(); ?>" />
				<input type="hidden" name="user_id" id="user_id" value="<?php echo esc_attr( $current_user->ID ); ?>" />
				<input type="submit" class="button-primary" value="<?php esc_attr_e( 'Update Profile', 'theme-my-login' ); ?>" name="submit" id="submit" />
			</p>
		</form>
	</div>
<?php
} // end if administrator	
?>