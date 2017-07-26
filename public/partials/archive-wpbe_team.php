<?php
/**
 * The template for displaying WP Business Essentials Team Members
 *
 * @link  * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @todo: Add Activate-Button to the settings page
 * @todo: Add settings page...
 * @todo: Test - twentyseventeen
 * @todo: Test - twentysixteen
 * @todo: Test - twentyfifteen
 *
 * @since      0.1.0
 * @package    Wp_Business_Essentials
 * @subpackage Wp_Business_Essentials/public
 * @author     Marvin Kronenfeld (WP-Styles.de) <hello@wp-styles.de>
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php
			printf( '<h2>%s</h2>', __( 'Team', 'wp-business-essentials' ) );

			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/content', get_post_format() );

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile; // End of the loop.

			the_posts_pagination();
			?>

		</main><!-- .site-main -->

		<?php get_sidebar(); ?>

	</div><!-- .content-area -->

<?php
get_footer();
