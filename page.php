<?php
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

		<?php

		$prefix = 'option_';

		// Start the loop.
		while ( have_posts() ) : the_post();

			$post_background_color = rwmb_meta($prefix.'background_color', array(), $post->ID);

			$post_background_images = rwmb_meta($prefix.'background_image', array('type' => 'image'), $post->ID);
			$post_background_image = '';
			if (!empty($post_background_images)) {
				$post_background_image = array_shift($post_background_images);
				$post_background_image = $post_background_image['full_url'];
			}

			// Include the page content template.
			get_template_part( 'template-parts/content', 'page' );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}
		?>
			<style>
			<?php
			if (!empty($post_background_color)):
			?>
			#post-<?= $post->ID ?> {
				background-color: <?= $post_background_color ?>;
				padding: 20px;
			}
			<?php
			endif;

			if (!empty($post_background_image)):
			?>
			#post-<?= $post->ID ?> {
				background-image: url(<?= $post_background_image ?>);
				background-repeat: no-repeat;
				background-size: cover;
				padding: 20px;
			}
			<?php
			endif;
			?>
			</style>
		<?php
		// End of the loop.
		endwhile;
		?>


	</main><!-- .site-main -->

	<?php get_sidebar( 'content-bottom' ); ?>

</div><!-- .content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
