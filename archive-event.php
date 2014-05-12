<?php get_header();

	$city = $wp_query->query_vars['region'];
	$term = get_terms('region', array('slug' => $city));
	$city = $term[0];
	$state = get_state_from_region($city);
	$terms = get_term_children( $city->term_id, 'region' );
	if(empty($terms)) {
		$terms = array($city->term_id);
	}

	$querystr = "
	    SELECT *, STR_TO_DATE(m.meta_value,'%m/%d/%Y') date_value FROM occasionsmag_posts p
	    INNER JOIN occasionsmag_term_relationships ON (p.ID = occasionsmag_term_relationships.object_id)
	    LEFT JOIN occasionsmag_postmeta m ON p.ID = m.post_id
	    WHERE ( occasionsmag_term_relationships.term_taxonomy_id IN (" . implode(",",$terms) . ") )
	    AND p.post_type = 'event'
	    AND m.meta_key = 'flo_start_date'
	    AND STR_TO_DATE(m.meta_value,'%m/%d/%Y') > NOW()
	    ORDER BY date_value ASC
	    ";

 	$pageposts = $wpdb->get_results($querystr, OBJECT);

	$ppp = intval(get_query_var('posts_per_page'));

	$wp_query->found_posts = count($pageposts);

	$wp_query->max_num_pages = ceil($wp_query->found_posts / $ppp);

	$on_page = intval(get_query_var('paged'));	

	if($on_page == 0){ $on_page = 1; }		

	$offset = ($on_page-1) * $ppp;

	$wp_query->request = "SELECT *, STR_TO_DATE(m.meta_value,'%m/%d/%Y') date_value FROM occasionsmag_posts p
	    INNER JOIN occasionsmag_term_relationships ON (p.ID = occasionsmag_term_relationships.object_id)
	    LEFT JOIN occasionsmag_postmeta m ON p.ID = m.post_id
	    WHERE ( occasionsmag_term_relationships.term_taxonomy_id IN (" . implode(",",$terms) . ") )
	    AND p.post_type = 'event'
	    AND m.meta_key = 'flo_start_date'
	    AND STR_TO_DATE(m.meta_value,'%m/%d/%Y') > NOW()
	    ORDER BY date_value ASC
	    LIMIT " . $ppp . " OFFSET " . $offset;

	$pageposts = $wpdb->get_results($wp_query->request, OBJECT);

 ?>
<div class="row page" id="single-post-row">

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

			<section class="post-container">

				<div class="post-category-floater venue">
					<span class="nice-button dept"><?php echo $city->name; ?> Events</span>
				</div>	

				<div class="post-content story venue">

					<?php if($pageposts) : ?>

						<?php echo insert_venue_header_content(); ?>

						<div id="events-archive-list">
							<?php global $post; ?>
							<?php foreach ($pageposts as $post): ?>
								<?php setup_postdata($post); ?>
								<?php oo_part('event-loop') ?>
							<?php endforeach; ?>


							<?php 
								pagination();
							 ?>

						</div>

					<?php else : ?>

						We're sorry, there are currently no events in your area.
					<?php endif; ?>	
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


				<div class="section-breaker">
					Venues in <?php echo $city->name; ?>
				</div>

				<?php oo_part("venues-menu"); ?>

				<div class="section-breaker">
					Services in <?php echo $city->name; ?>
				</div>

				<?php oo_part("services-menu"); ?>



			</section>

			<?php get_sidebar('blog'); ?>

		</div>


</div>



<?php get_footer(); ?>