<?php
/**
 * Template Name: Login Page
 *
 * The login page template displays a login or logout form.
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

// Never index login pages.
add_action( 'wp_head', 'wp_no_robots' );

$login_wp_error = new WP_Error();

$login_action = isset( $_REQUEST['action'] ) ? wp_unslash( $_REQUEST['action'] ) : 'login'; // phpcs:ignore WordPress.VIP.ValidatedSanitizedInput.InputNotSanitized
if ( isset( $_GET['key'] ) ) {
	$login_action = 'resetpass';
} elseif ( 'register' === $login_action ) {
	if ( is_multisite() ) {
		$login_action         = 'login';
		$_GET['registration'] = 'multisite';
	} elseif ( ! get_option( 'users_can_register' ) ) {
		$login_action         = 'login';
		$_GET['registration'] = 'disabled';
	}
}

$login_redirect_to = '';
if ( isset( $_REQUEST['redirect_to'] ) ) {
	$login_redirect_to = wp_unslash( $_REQUEST['redirect_to'] ); // phpcs:ignore WordPress.VIP.ValidatedSanitizedInput.InputNotSanitized
}

$login_page_title       = __( 'Log In', 'super-awesome-theme' );
$login_page_description = '';
switch ( $login_action ) {
	case 'lostpassword':
	case 'retrievepassword':
		$login_page_title       = __( 'Lost Password', 'super-awesome-theme' );
		$login_page_description = __( 'Please enter your username or email address. You will receive a link to create a new password via email.', 'super-awesome-theme' );
		if ( isset( $_REQUEST['error'] ) ) {
			switch ( $_REQUEST['error'] ) {
				case 'invalidkey':
					$login_wp_error->add( 'invalidkey', __( 'Your password reset link appears to be invalid. Please request a new link below.', 'super-awesome-theme' ) );
					break;
				case 'expiredkey':
					$login_wp_error->add( 'expiredkey', __( 'Your password reset link has expired. Please request a new link below.', 'super-awesome-theme' ) );
					break;
			}
		}
		break;

	case 'resetpass':
	case 'rp':
		break;

	case 'register':
		$login_page_title = __( 'Registration Form', 'super-awesome-theme' );
		break;

	case 'confirmaction':
		break;

	case 'login':
	default:
		if ( empty( $login_redirect_to ) ) {
			$login_redirect_to = admin_url();
		}

		if ( isset( $_GET['loggedout'] ) && 'true' === $_GET['loggedout'] ) {
			$login_wp_error->add( 'loggedout', __( 'You are now logged out.', 'super-awesome-theme' ), 'message' );
		} elseif ( isset( $_GET['registration'] ) ) {
			switch ( $_GET['registration'] ) {
				case 'multisite':
					/** This filter is documented in wp-login.php */
					$signup_url = apply_filters( 'wp_signup_location', network_site_url( 'wp-signup.php' ) );
					$login_wp_error->add( 'registermultisite', '<a href="' . esc_url( $signup_url ) . '">' . __( 'Click here to register.', 'super-awesome-theme' ) . '</a>', 'message' );
					break;
				case 'disabled':
					$login_wp_error->add( 'registerdisabled', __( 'User registration is currently not allowed.', 'super-awesome-theme' ) );
					break;
			}
		} elseif ( isset( $_GET['checkemail'] ) ) {
			switch ( $_GET['checkemail'] ) {
				case 'confirm':
					$login_wp_error->add( 'confirm', __( 'Check your email for the confirmation link.', 'super-awesome-theme' ), 'message' );
					break;
				case 'newpass':
					$login_wp_error->add( 'newpass', __( 'Check your email for your new password.', 'super-awesome-theme' ), 'message' );
					break;
				case 'registered':
					$login_wp_error->add( 'registered', __( 'Registration complete. Please check your email.', 'super-awesome-theme' ), 'message' );
					break;
			}
		}

		/** This filter is documented in wp-login.php */
		$login_wp_error = apply_filters( 'wp_login_errors', $login_wp_error, $login_redirect_to );
}

get_header();

?>

			<main id="main" class="site-main">

				<?php
				while ( have_posts() ) {
					the_post();

					?>
					<div class="page-login-form">
						<h1><?php echo esc_html( $login_page_title ); ?></h1>

						<?php
						if ( ! empty( $login_page_description ) ) {
							echo '<div class="message notice notice-info"><p>' . esc_html( $login_page_description ) . '</p></div>';
						}
						?>

						<?php
						if ( ! empty( $login_wp_error->errors ) ) {
							$login_errors   = '';
							$login_messages = '';
							foreach ( $login_wp_error->get_error_codes() as $code ) {
								$severity = $login_wp_error->get_error_data( $code );
								foreach ( $login_wp_error->get_error_messages( $code ) as $error_message ) {
									if ( 'message' == $severity ) {
										$login_messages .= "\t" . $error_message . "<br>\n";
									} else {
										$login_errors .= "\t" . $error_message . "<br>\n";
									}
								}
							}
							if ( ! empty( $login_errors ) ) {
								/** This filter is documented in wp-login.php */
								echo '<div id="login_error" class="notice notice-error"><p>' . apply_filters( 'login_errors', $login_errors ) . '</p></div>'; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
							}
							if ( ! empty( $login_messages ) ) {
								/** This filter is documented in wp-login.php */
								echo '<div class="message notice notice-info"><p>' . apply_filters( 'login_messages', $login_messages ) . '</p></div>'; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
							}
						}
						?>

						<?php
						switch ( $login_action ) {
							case 'lostpassword':
							case 'retrievepassword':
								?>
								<form name="lostpasswordform" id="lostpasswordform" action="<?php echo esc_url( network_site_url( 'wp-login.php?action=lostpassword', 'login_post' ) ); ?>" method="post">
									<p>
										<label for="user_login" ><?php esc_html_e( 'Username or Email Address', 'super-awesome-theme' ); ?></label>
										<input type="text" name="user_login" id="user_login" class="input" value="" size="20" autocapitalize="off" />
									</p>
									<p class="login-submit">
										<input type="submit" name="wp-submit" id="wp-submit" class="button button-primary button-large" value="<?php esc_attr_e( 'Get New Password', 'super-awesome-theme' ); ?>" />
										<input type="hidden" name="redirect_to" value="<?php echo esc_attr( $login_redirect_to ); ?>" />
									</p>
								</form>

								<p class="login-links">
									<a href="<?php echo esc_url( wp_login_url( $login_redirect_to ) ); ?>"><?php esc_html_e( 'Log In', 'super-awesome-theme' ); ?></a>
									<?php if ( get_option( 'users_can_register' ) ) : ?>
										<span class="sep">|</span>
										<a href="<?php echo esc_url( wp_registration_url() ); ?>"><?php esc_html_e( 'Register', 'super-awesome-theme' ); ?></a>
									<?php endif; ?>
								</p>
								<?php
								break;

							case 'register':
								?>
								<form name="registerform" id="registerform" action="<?php echo esc_url( site_url( 'wp-login.php?action=register', 'login_post' ) ); ?>" method="post" novalidate="novalidate">
									<p>
										<label for="user_login"><?php esc_html_e( 'Username', 'super-awesome-theme' ); ?></label>
										<input type="text" name="user_login" id="user_login" class="input" value="" size="20" autocapitalize="off" />
									</p>
									<p>
										<label for="user_email"><?php esc_html_e( 'Email', 'super-awesome-theme' ); ?></label>
										<input type="email" name="user_email" id="user_email" class="input" value="" size="25" />
									</p>
									<p id="reg_passmail"><?php esc_html_e( 'Registration confirmation will be emailed to you.', 'super-awesome-theme' ); ?></p>
									<p class="login-submit">
										<input type="submit" name="wp-submit" id="wp-submit" class="button button-primary button-large" value="<?php esc_attr_e( 'Register', 'super-awesome-theme' ); ?>" />
										<input type="hidden" name="redirect_to" value="<?php echo esc_attr( $login_redirect_to ); ?>" />
									</p>
								</form>

								<p class="login-links">
									<a href="<?php echo esc_url( wp_login_url( $login_redirect_to ) ); ?>"><?php esc_html_e( 'Log In', 'super-awesome-theme' ); ?></a>
									<span class="sep">|</span>
									<a href="<?php echo esc_url( wp_lostpassword_url( $login_redirect_to ) ); ?>"><?php esc_html_e( 'Lost your password?', 'super-awesome-theme' ); ?></a>
								</p>
								<?php
								break;

							case 'login':
							default: // phpcs:ignore Generic.WhiteSpace.ScopeIndent.IncorrectExact
								wp_login_form( array( 'redirect' => $login_redirect_to ) ); // phpcs:ignore Generic.WhiteSpace.ScopeIndent.Incorrect
								?>

								<p class="login-links">
									<?php if ( get_option( 'users_can_register' ) ) : ?>
										<a href="<?php echo esc_url( wp_registration_url() ); ?>"><?php esc_html_e( 'Register', 'super-awesome-theme' ); ?></a>
										<span class="sep">|</span>
									<?php endif; ?>
									<a href="<?php echo esc_url( wp_lostpassword_url( $login_redirect_to ) ); ?>"><?php esc_html_e( 'Lost your password?', 'super-awesome-theme' ); ?></a>
								</p>
								<?php
						}
						?>
					</div>
					<script type="text/javascript">
						document.getElementById( 'user_login' ).focus();
					</script>
					<?php
				}
				?>

			</main><!-- #main -->

<?php

get_sidebar();
get_footer();
