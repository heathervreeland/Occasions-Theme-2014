<?php 
	// wp_redirect(flo_get_permalink('map'));
	// exit;
?>

<?php get_header(); ?>
<?php 
	$region = get_term_by('slug', get_query_var('region'), 'region');
	if ($region->parent) {
		$state = get_term($region->parent, 'region');
	} else {
		$state = $region;
		$region = false;
	}
	global $stateonly;
	$stateonly = true;
?>

<div class="row page" id="single-post-row">

<?php

	$rargs = array(
		'post_type' => 'post',
		'posts_per_page' => 10,
		'norewrite' => true,
		'tax_query' => array(
			array(
				'taxonomy' => 'region',
				'field' => 'slug',
				'terms' => $state->slug
			),
		),
		'ignore_filter_changes' => true,

	);		

	$posts_query = new WP_Query($rargs);

?>

	<?php if($posts_query->have_posts()) : ?>

		<p id="breadcrumbs">
			<span xmlns:v="http://rdf.data-vocabulary.org/#"><span typeof="v:Breadcrumb"><a href="/" rel="v:url" property="v:title">Home</a></span> • 
			<span typeof="v:Breadcrumb"><span class="breadcrumb_last" property="v:title"><?php echo $state->name; ?></span></span>
		</p>


		<div class="page-block vendors-archive" id="main">

			<section class="post-container">

				<div class="post-category-floater venue">
					<span class="nice-button dept"><?php echo get_service_title(); ?></span>
				</div>	

				<div class="post-content story venue">

					<?php echo insert_venue_header_content(); ?>

					<div id="vendors-archive-list">
						<?php while($posts_query->have_posts()) : $posts_query->the_post(); ?>

						<div class="vendor-list-block">
							
							<div class="vendor-list-block-actions">
								<figure>
									<a href="<?php the_permalink() ?>"><?php the_post_thumbnail('venue-thumbnail') ?></a>
								</figure>

							</div>

							<div class="detail">
								<h2><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h2>
							
								<div class="descr">
									 <?php the_excerpt(); ?> 
								</div>
							</div>


						</div>


						<?php endwhile; ?>


						<?php 
							pagination();
						 ?>

					</div>

				</div>


				<?php
					$events = get_events_for_region($state, 4);
					if ($events->have_posts()) : 
				?>

					<div class="section-breaker">
						Events in <?php echo $state->name; ?>
					</div>

					<ul class="event-display-list">
					<?php while($events->have_posts()): $events->the_post(); ?>
						<li>
							<div class="image">
								<?php
									get_nice_image("small");
								?>
							</div>
							<a href="<?php the_permalink() ?>">
								<span class="title"><?php the_title(); ?></span>
								<time datetime="<?php the_time('Y-m-d'); ?>"><?php echo oo_get_event_date() ?></time>
							</a>
						</li>
					<?php endwhile; ?>
					</ul>

					<div class="button-separator">
						<a href="/<?php echo $state->slug; ?>/events" class="nice-button">View More</a>
					</div>

				<?php endif; ?>


				<div class="section-breaker">
					Venues in <?php echo $state->name; ?>
				</div>

				<?php oo_part("venues-menu"); ?>

				<div class="section-breaker">
					Services in <?php echo $state->name; ?>
				</div>

				<?php oo_part("services-menu"); ?>


			</section>

			<?php get_sidebar('blog'); ?>

		</div>

	<?php else : ?>

		<div class="alert alert-info">
			<strong>No content in this loop</strong>
		</div>

	<?php endif; ?>	

</div>

<?php get_footer(); ?>
