<?php get_header();

	$city = $wp_query->query_vars['region'];
	$term = get_terms('region', array('slug' => $city));
	$city = $term[0];
	$state = get_state_from_region($city);

 ?>

<div class="row page" id="single-post-row">

	<?php if(have_posts()) : ?>

		<p id="breadcrumbs">
			<span xmlns:v="http://rdf.data-vocabulary.org/#"><span typeof="v:Breadcrumb"><a href="/" rel="v:url" property="v:title">Home</a></span> • 
			<?php if ( $city->parent) { ?>
				<span typeof="v:Breadcrumb"><a href="/<?php echo $state->slug; ?>/events" rel="v:url" property="v:title"><?php echo $state->name; ?></a></span> • 
				<span typeof="v:Breadcrumb"><a href="/<?php echo $state->slug; ?>/<?php echo $city->slug; ?>/events" rel="v:url" property="v:title"><?php echo $city->name; ?></a></span> • 
				<span typeof="v:Breadcrumb"><span class="breadcrumb_last" property="v:title">Events</span></span>
			<?php } else { ?>
				<span typeof="v:Breadcrumb"><a href="/<?php echo $state->slug; ?>/events" rel="v:url" property="v:title"><?php echo $state->name; ?></a></span> • 
				<span typeof="v:Breadcrumb"><span class="breadcrumb_last" property="v:title">Events</span></span>
			<?php } ?>
		</p>


		<div class="page-block vendors-archive" id="main">

			<?php get_sidebar('blog'); ?>

			<section class="post-container">

				<div class="post-category-floater venue">
					<span class="nice-button dept"><?php echo $city->name; ?> Events</span>
				</div>	

				<div class="post-content story venue">

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