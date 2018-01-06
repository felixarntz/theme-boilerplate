<?php
/**
 * Template Name: Login Page
 *
 * The login page template displays a login or logout form.
 *
 * @package Super_Awesome_Theme
 * @license GPL-3.0
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

get_header();

?>

	<main id="main" class="site-main">

		<?php
		while ( have_posts() ) : the_post();

			if ( ! is_user_logged_in() ) :
				?>
				<div class="page-login-form">
					<?php if ( isset( $_GET['loggedout'] ) && 'true' === $_GET['loggedout'] ) : ?>
						<div class="notice notice-info">
							<p><?php esc_html_e( 'You are now logged out.', 'super-awesome-theme' ); ?></p>
						</div>
					<?php endif; ?>

					<?php
					wp_login_form( array(
						'redirect' => admin_url(),
					) );
					?>

					<p class="login-links">
						<?php if ( get_option( 'users_can_register' ) ) : ?>
							<a href="<?php echo esc_url( wp_registration_url() ); ?>"><?php esc_html_e( 'Register', 'super-awesome-theme' ); ?></a>
							<span class="sep">|</span>
						<?php endif; ?>
						<a href="<?php echo esc_url( wp_lostpassword_url( get_permalink() ) ); ?>"><?php esc_html_e( 'Lost your password?', 'super-awesome-theme' ); ?></a>
					</p>
				</div>
				<?php
			else :
				?>
				<div class="page-login-form">
					<p class="login-links">
						<a href="<?php echo esc_url( wp_logout_url( add_query_arg( 'loggedout', 'true', get_permalink() ) ) ); ?>"><?php esc_html_e( 'Logout', 'super-awesome-theme' ); ?></a>
					</p>
				</div>
				<?php
			endif;

		endwhile; // End of the loop.
		?>

	</main><!-- #main -->

<?php

get_sidebar();
get_footer();
