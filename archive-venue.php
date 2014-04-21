<?php get_header();

	$city = $wp_query->query_vars['region'];
	$term = get_terms('region', array('slug' => $city));
	$city = $term[0];
	$state = get_state_from_region($city);
    // get the service taxonomy obj
    $service = get_term_by('slug', get_query_var('service'), 'service');
 ?>

<div class="row page">

	<?php if(have_posts()) : ?>

		<p id="breadcrumbs">
			<span xmlns:v="http://rdf.data-vocabulary.org/#"><span typeof="v:Breadcrumb"><a href="/" rel="v:url" property="v:title">Home</a></span> • 
			<span typeof="v:Breadcrumb"><a href="/vendors" rel="v:url" property="v:title">Vendors &amp; Venues</a></span> • 
			<span typeof="v:Breadcrumb"><a href="/vendors/<?php echo $city->slug; ?>" rel="v:url" property="v:title"><?php echo $city->name; ?></a></span> • 
			<span typeof="v:Breadcrumb"><span class="breadcrumb_last" property="v:title"><?php echo $city->name . " " . $service->name; ?></span></span>
		</p>


		<div class="page-block vendors-archive" id="main">

			<?php get_sidebar('blog'); ?>

			<section class="post-container">

				<div class="post-content story ">

					<?php echo insert_venue_header_content(); ?>

					<div id="vendors-archive-list">
						<?php while(have_posts()) : the_post(); ?>

						<div class="vendor-list-block">
							
							<div class="vendor-list-block-actions">
								<figure>
									<a href="<?php the_permalink() ?>"><?php the_post_thumbnail('venue-thumbnail') ?></a>
								</figure>

								<div class="vendor-rating stars<?php oo_venue_rating() ?>"></div>

									
								<a href="<?php the_permalink() ?>" class="nice-button">View Profile</a>

							</div>

							<div class="detail">
								<h2><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h2>
								<?php if (oo_get_meta('contact_address_show')): ?>
									<address>
										<?php oo_meta('contact_address') ?>
										<?php oo_meta('contact_address_city') ?>
										<?php oo_meta('contact_address_state') ?>,
										<?php oo_meta('contact_address_zip') ?>
										<?php if (oo_meta('contact_address_county')): ?>
											, <?php oo_meta('contact_address_county') ?>
										<?php endif ?>
									</address>
								<?php endif ?>
								<?php if (oo_get_meta('short_info')): ?>
									<div class="descr">
										<?php oo_meta('short_info') ?>
									</div>
								<?php endif ?>
							</div>


						</div>


						<?php endwhile; ?>


						<?php 
							pagination();
						 ?>

					</div>

				</div>


				<?php
					$events = get_events_for_region($city, 4);
					if ($events->have_posts()) : 
				?>

					<div class="section-breaker">
						Events in <?php echo $city->name; ?>
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
						<a href="/<?php echo $state->slug . "/" . $city->slug; ?>/events" class="nice-button">View More</a>
					</div>

				<?php endif; ?>


				<div class="section-breaker">
					Venues in <?php echo $city->name; ?>
				</div>

				<?php oo_part("venues-menu"); ?>

				<div class="section-breaker">
					Services in <?php echo $city->name; ?>
				</div>

				<?php oo_part("services-menu"); ?>


			</section>

		</div>

	<?php else : ?>

		<div class="alert alert-info">
			<strong>No content in this loop</strong>
		</div>

	<?php endif; ?>	

</div>



<?php get_footer(); ?>