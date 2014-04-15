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
					</div>

				</div>

			</section>

		</div>

	<?php else : ?>

		<div class="alert alert-info">
			<strong>No content in this loop</strong>
		</div>

	<?php endif; ?>	

</div>



<?php get_footer(); ?>