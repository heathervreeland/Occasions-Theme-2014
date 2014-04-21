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

					<div id="events-archive-list">
						<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
							<?php oo_part('event-loop') ?>
						<?php endwhile; else: ?>
							<?php oo_part('notfound')?>
						<?php endif; ?>


						<?php 
							pagination();
						 ?>

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

		</div>

	<?php else : ?>

		<div class="alert alert-info">
			<strong>No content in this loop</strong>
		</div>

	<?php endif; ?>	

</div>



<?php get_footer(); ?>