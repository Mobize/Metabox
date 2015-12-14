<?php
/**
 * Template Name: Template Evenement
 *
 * @package WordPress
 * @subpackage starter
 * @since starter 1.0
 */

get_header();

$event_id = !empty($_GET['id']) ? (int) $_GET['id'] : 0;

$vars = array(
	'post_type' => 'evenement',
	'post_status' => 'publish',
	'posts_per_page' => -1,
	/*
	'meta_query' => array(
		array(
	        'key' => 'evenement_key',
			'compare' => 'IN',
			'value' => array('1', '2', '3')
		),
		array(
            'key' => 'project_key2',
			'type' => 'NUMERIC',
			'value' => 1
		)
 	),
	*/
 	'orderby' => 'evenement_start_date',
	'order' => 'DESC'
);

if (!empty($event_id)) {
	$vars['p'] = $event_id;
}

$events = new WP_Query($vars);

?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
		<?php
		$prefix = 'evenement_';

		// Start the loop.
		while ( $events->have_posts() ) : $events->the_post();

			$event_title = rwmb_meta($prefix.'title');
			$event_content = rwmb_meta($prefix.'content');

			$event_start_date = rwmb_meta($prefix.'start_date');
			$event_start_time = strtotime($event_start_date);
			$event_start_date_full = date_i18n(__('l j F Y', 'starter'), $event_start_time);

			$event_end_date = rwmb_meta($prefix.'end_date');
			$event_end_time = strtotime($event_end_date);
			$event_end_date_full = date_i18n(__('l j F Y', 'starter'), $event_end_time);

			$event_images = rwmb_meta($prefix.'image', array('type' => 'image'), $post->ID);
			$event_image_src = '';
			if (!empty($event_images)) {
				$event_image = array_shift($event_images);

				$event_image_src = $event_image['full_url'];
				$event_image_alt = $event_image['alt'];
			}
		?>
			<article>
				<h2><?= $event_title ?></h2>
				<em>Du <strong><?= $event_start_date_full ?></strong> au <strong><?= $event_end_date_full ?></strong>

				<?php if (!empty($event_image)): ?>
				<img height="150" src="<?= $event_image_src ?>" alt="<?= $event_image_alt ?>">
				<?php endif; ?>

				<blockquote>
					<?= $event_content ?>
				</blockquote>
			</article>

			<hr>
		<?php
		// End of the loop.
		endwhile;
		?>

	</main><!-- .site-main -->

	<?php get_sidebar( 'content-bottom' ); ?>

</div><!-- .content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
