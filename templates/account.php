<?php
/**
 * Template Name: Account Page
 *
 * The account page template requires the user to be logged-in to view the page content.
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

get_header();

?>

			<main id="main" class="site-main">

				<?php
				while ( have_posts() ) {
					the_post();

					if ( ! is_user_logged_in() ) {
						?>
						<header class="page-header">
							<?php the_title( '<h1>', '</h1>' ); ?>
						</header><!-- .page-header -->

						<div class="page-login-form">
							<p><?php esc_html_e( 'You must be logged in to view the content of this page.', 'super-awesome-theme' ); ?></p>

							<?php wp_login_form(); ?>

							<p class="login-links">
								<?php if ( get_option( 'users_can_register' ) ) : ?>
									<a href="<?php echo esc_url( wp_registration_url() ); ?>"><?php esc_html_e( 'Register', 'super-awesome-theme' ); ?></a>
									<span class="sep">|</span>
								<?php endif; ?>
								<a href="<?php echo esc_url( wp_lostpassword_url( get_permalink() ) ); ?>"><?php esc_html_e( 'Lost your password?', 'super-awesome-theme' ); ?></a>
							</p>
						</div>
						<?php
					} else {
						if ( super_awesome_theme_use_post_format_templates() ) {
							get_template_part( 'template-parts/content/content-' . get_post_type(), get_post_format() );
						} else {
							get_template_part( 'template-parts/content/content', get_post_type() );
						}

						if ( super_awesome_theme_display_post_navigation() ) {
							the_post_navigation();
						}

						if ( super_awesome_theme_display_post_comments() ) {
							comments_template();
						}
					}
				} // End of the loop.
				?>

			</main><!-- #main -->

<?php

get_sidebar();
get_footer();
