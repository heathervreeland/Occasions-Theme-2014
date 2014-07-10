<?php
/* 
Template Name: Vendors-City
*/

 	get_header(); 


	$city = $wp_query->query_vars["tag"];
	if(empty($city)) {
		$city = 'atlanta'; //default to Atlanta		
	}
	$term = get_terms('region', array('slug' => $city));
	$city = $term[0];
	$state = get_state_from_region($city);
 ?>

<div class="row vendors-city venue" id="single-post-row">

	<?php if(have_posts()) : ?>
		<?php while(have_posts()) : the_post(); ?>

			<p id="breadcrumbs">
				<span xmlns:v="http://rdf.data-vocabulary.org/#"><span typeof="v:Breadcrumb"><a href="/" rel="v:url" property="v:title">Home</a></span> • 
				<span typeof="v:Breadcrumb"><a href="/vendors" rel="v:url" property="v:title">Vendors &amp; Venues</a></span> • 
				<span typeof="v:Breadcrumb"><a href="/vendors/<?php echo $city->slug; ?>" rel="v:url" property="v:title"><?php echo $city->name; ?></a></span>
			</p>

			<div class="page-block" id="main">

				<section class="post-container">

					<div class="post-category-floater">
						<span class="nice-button dept">Venues &amp; Vendors</span>
					</div>

					<div class="post-content story ">

						<div class="city-map-block">
							<img src="<?php echo get_template_directory_uri(); ?>/images/<?php echo $state->slug; ?>_map.png"/>
							<div class="city-star<?php echo " " . $city->slug; ?>"></div>
							<div class="title"><h1><?php echo $city->name; ?></h1></div>
						</div>

						<p class="vendors-city-description">
							<?php echo $city->description; ?>
						</p>

						<div class="section-breaker inside">
							Select by Service
						</div>

						<?php oo_part("services-menu"); ?>

					</div>



					<div class="section-divider">
						<div class="line"></div>
						<span class="before">&#8226;</span>
						<span class="heading">Browse Other Areas</span>
						<span class="after">&#8226;</span>
					</div>

					<div id="vendors-locations">
						<div class="location-box georgia">
							<h2>Georgia</h2>
							<ul>
								<li><a href="/vendors/atlanta/">Atlanta</a></li>
								<li><a href="/vendors/savannah/">Savannah</a></li>
							</ul>
						</div>

						<div class="location-box florida">
							<h2>Florida</h2>
							<ul>
								<li><a href="/vendors/orlando/">Orlando</a></li>
								<li><a href="/vendors/tampa/">Tampa</a></li>
								<li><a href="/vendors/south-florida/">South Florida</a></li>
								<li><a href="/vendors/jacksonville/">Jacksonville</a></li>
							</ul>
						</div>
					</div>


				</section>

				<?php get_sidebar('blog'); ?>
				
			</div>

		<?php endwhile; ?>

	<?php else : ?>

		<div class="alert alert-info">
			<strong>No content in this loop</strong>
		</div>

	<?php endif; ?>	

</div>



<?php get_footer(); ?>