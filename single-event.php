<?php 

	get_header();
 
	$type 	= get_term_by('slug', get_query_var('type'), 'venue-type');
	$region = get_term_by('slug', get_query_var('region'), 'region');

 ?>

<div class="row" id="single-post-row">

	<?php if(have_posts()) : ?>
		<?php while(have_posts()) : the_post(); ?>

			<?php 

				// $city = oo_get_venue_city();
				// $service = oo_get_venue_service();
				// $state = get_state_from_region($city);
				$city = oo_get_post_city(get_the_ID());
				$state = get_state_from_region($city);
			    // get the service taxonomy obj
			?>

			<p id="breadcrumbs">
				<span xmlns:v="http://rdf.data-vocabulary.org/#"><span typeof="v:Breadcrumb"><a href="/" rel="v:url" property="v:title">Home</a></span> • 
				<span typeof="v:Breadcrumb"><a href="/<?php echo $state->slug; ?>/events" rel="v:url" property="v:title"><?php echo $state->name; ?></a></span> • 
				<span typeof="v:Breadcrumb"><a href="/<?php echo $state->slug; ?>/<?php echo $city->slug; ?>/events" rel="v:url" property="v:title"><?php echo $city->name; ?> Events</a></span> • 
				<span typeof="v:Breadcrumb"><span class="breadcrumb_last" property="v:title"><?php the_title() ?></span></span>
			</p>

			<div class="page-block <?php echo $parent_cat->slug; ?>" id="main">

				<section class="post-container venue event single-event" id="venue">

					<div class="post-category-floater">
						<span class="nice-button dept">Events</span>
					</div>

					<div class="post-content story ">

						<h1 class="title"><?php the_title(); ?></h1>

						<div class="venue-share">
							Share This 

							<?php oo_part("social-share"); ?>

						</div>


						<div class="border-line"></div>

							<div class="vendor-list-block event">

								<div class="vendor-list-block-actions">
									<figure>
										<a href="<?php the_permalink() ?>"><?php the_post_thumbnail('event-preview')?></a>
									</figure>
								</div>

								<div class="detail">
									<div class="descr">
										<?php echo apply_filters('the_content', oo_get_meta('description', true, get_the_ID())); ?>
									</div>

									<dt>Date(s)</dt>
									<dd>
										<?php echo oo_get_event_date('start', 'F d, Y', get_the_ID()) ?> 
										<?php if (oo_get_meta('date_end',get_the_ID())): ?>
											/ <?php echo oo_get_event_date('end', 'F d, Y', get_the_ID()) ?> 
										<?php endif ?>		
									</dd>			
									<dt>Hours:</dt>
									<dd>
										<?php oo_meta('hours', true, get_the_ID()) ?>
									</dd>			
									<dt>Address</dt>
									<dd>
										<?php oo_meta('event_address', true, get_the_ID()) ?>
										<?php if (oo_get_meta('event_address_city', true, get_the_ID())): ?>
											, <?php oo_meta('event_address_city', true, get_the_ID()) ?>
										<?php endif ?>
										<?php if (oo_get_meta('event_address_state', true, get_the_ID())): ?>
											, <?php oo_meta('event_address_state', true, get_the_ID()) ?>
										<?php endif ?>
										<?php if (oo_get_meta('event_address_zip', true, get_the_ID())): ?>
											, <?php oo_meta('event_address_zip', true, get_the_ID()) ?>
										<?php endif ?>
									</dd>						
									<?php if (oo_get_meta('location', true, get_the_ID())): ?>
										<dt>Location</dt>
										<dd><?php oo_meta('location', true, get_the_ID()) ?></dd>									
									<?php endif ?>
									
									<?php if (oo_get_meta('cost', true, get_the_ID())): ?>
										<dt>Cost</dt>
										<dd><?php oo_meta('cost', true, get_the_ID()) ?></dd>									
									<?php endif ?>

									<?php if (oo_get_meta('more_url', true, get_the_ID())): ?>
										<dt>More Info</dt>
										<dd><a href="<?php oo_meta('more_url', true, get_the_ID()) ?>" rel="external"><?php oo_meta('more_url', true, get_the_ID()) ?></a></dd>
									<?php endif ?>

								</div>


							</div>


					</div>		

					<?php if( $city->parent ) { ?>
						<div class="section-breaker">
							Venues in <?php echo $city->name; ?>
						</div>

						<?php oo_part("venues-menu"); ?>

						<div class="section-breaker">
							Services in <?php echo $city->name; ?>
						</div>

						<?php oo_part("services-menu"); ?>
					<?php } ?>

				</section>

				<?php get_sidebar('blog'); ?>

			</div>

		<?php endwhile; ?>

	<?php else : ?>

		<?php oo_part('notfound')?>

	<?php endif; ?>	

</div>



<?php get_footer(); ?>
