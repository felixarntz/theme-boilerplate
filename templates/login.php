<?php
/**
 * Template Name: Login Page
 *
 * The login page template displays a login or logout form.
 *
 * @package Super_Awesome_Theme
 * @license GPL-3.0
 * @link    https://www.taco-themes.com/themes/super-awesome-theme/
 */

get_header();

?>

	<main id="main" class="site-main">

		<?php
		while ( have_posts() ) : the_post();

			if ( ! is_user_logged_in() ) :
				?>
				<div class="page-login-form">
					<?php
					wp_login_form( array(
						'redirect' => admin_url(),
					) );
					?>

					<p class="login-lost-password">
						<a href="<?php echo esc_url( wp_lostpassword_url( admin_url() ) ); ?>"><?php esc_html_e( 'Lost your password?', 'super-awesome-theme' ); ?></a>
					</p>
				</div>
				<?php
			else :
				?>
				<div class="page-login-form">
					<p class="login-logout">
						<a href="<?php echo esc_url( wp_logout_url( get_permalink() ) ); ?>"><?php esc_html_e( 'Lost your password?', 'super-awesome-theme' ); ?></a>
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
