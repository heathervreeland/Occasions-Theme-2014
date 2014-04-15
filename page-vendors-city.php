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

<div class="row vendors-city" id="single-post-row">

	<?php if(have_posts()) : ?>
		<?php while(have_posts()) : the_post(); ?>

			<?php 
				if ( function_exists('yoast_breadcrumb') ) {
					yoast_breadcrumb('<p id="breadcrumbs">','</p>');
				}
			?>
			<div class="page-block" id="main">

				<?php get_sidebar('blog'); ?>

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

						<div class="service-breaker">
							Select by Service
						</div>

						<div class="vendors-services-list">

							<ul class="services-list">
								<li class="service-title"><a href="/<?php echo $state->slug; ?>/<? echo $city->slug ?>-weddings/planning-and-coordination"><h2>Planning & Coordination</h2></a></li>
								<li><a href="/<?php echo $state->slug; ?>/<? echo $city->slug ?>-weddings/wedding-planners"><?php echo $city->name; ?> Wedding Planners</a></li>
								<li><a href="/<?php echo $state->slug; ?>/<? echo $city->slug ?>-weddings/party-planners"><?php echo $city->name; ?> Party Planners</a></li>
								<li><a href="/<?php echo $state->slug; ?>/<? echo $city->slug ?>-weddings/event-planning-and-coordination"><?php echo $city->name; ?> Day-Of Coordination</a></li>
								
								<li class="service-title"><a href="/<?php echo $state->slug; ?>/<? echo $city->slug ?>-weddings/photographers"><h2>Photographers</h2></a></li>
								<li><a href="/<?php echo $state->slug; ?>/<? echo $city->slug ?>-weddings/wedding-photographers"><?php echo $city->name; ?> Wedding Photographers</a></li>
								<li><a href="/<?php echo $state->slug; ?>/<? echo $city->slug ?>-weddings/bar-bat-mitzvah-photographers"><?php echo $city->name; ?> Bar/Bat Mitzvah Photographers</a></li>
								<li><a href="/<?php echo $state->slug; ?>/<? echo $city->slug ?>-weddings/photobooth"><?php echo $city->name;; ?> Photobooths</a></li>
								<li><a href="/<?php echo $state->slug; ?>/<? echo $city->slug ?>-weddings/wedding-videographers"><?php echo $city->name;; ?> Wedding Videographers</a></li>
								
								<li class="service-title"><a href="/<?php echo $state->slug; ?>/<? echo $city->slug ?>-weddings/bands-and-musicians"><h2>Bands, DJs &amp; Musicians</a></h2></li>
								<li><a href="/<?php echo $state->slug; ?>/<? echo $city->slug ?>-weddings/djs"><?php echo $city->name;; ?> DJs</a></li>
								<li><a href="/<?php echo $state->slug; ?>/<? echo $city->slug ?>-weddings/wedding-ceremony-musicians"><?php echo $city->name;; ?> Wedding Ceremony Musicians</a></li>
								<li><a href="/<?php echo $state->slug; ?>/<? echo $city->slug ?>-weddings/wedding-bands"><?php echo $city->name;; ?> Wedding Bands</a></li>
								<li><a href="/<?php echo $state->slug; ?>/<? echo $city->slug ?>-weddings/wedding-cellists"><?php echo $city->name;; ?> Wedding Cellists</a></li>
								<li><a href="/<?php echo $state->slug; ?>/<? echo $city->slug ?>-weddings/wedding-guitarists"><?php echo $city->name;; ?> Wedding Guitarists</a></li>
								<li><a href="/<?php echo $state->slug; ?>/<? echo $city->slug ?>-weddings/wedding-harpists"><?php echo $city->name;; ?> Wedding Harpists</a></li>
								<li><a href="/<?php echo $state->slug; ?>/<? echo $city->slug ?>-weddings/wedding-jazz-musicians"><?php echo $city->name;; ?> Wedding Jazz Musicians</a></li>
								<li><a href="/<?php echo $state->slug; ?>/<? echo $city->slug ?>-weddings/wedding-pianists"><?php echo $city->name;; ?> Wedding Pianists</a></li>
								<li><a href="/<?php echo $state->slug; ?>/<? echo $city->slug ?>-weddings/wedding-string-quartets"><?php echo $city->name;; ?> Wedding String Quartets</a></li>
								<li><a href="/<?php echo $state->slug; ?>/<? echo $city->slug ?>-weddings/wedding-swing-bands"><?php echo $city->name;; ?> Wedding Swing Bands</a></li>
								<li><a href="/<?php echo $state->slug; ?>/<? echo $city->slug ?>-weddings/wedding-violinists"><?php echo $city->name;; ?> Wedding Violinists</a></li>
								<li><a href="/<?php echo $state->slug; ?>/<? echo $city->slug ?>-weddings/wedding-vocalists"><?php echo $city->name;; ?> Wedding Vocalists</a></li>
								
								<li class="service-title"><h2>Catering &amp; Beverage</h2></li>
								<li><a href="/<?php echo $state->slug; ?>/<? echo $city->slug ?>-weddings/wedding-caterers"><?php echo $city->name;; ?> Wedding Caterers</a></li>
								<li><a href="/<?php echo $state->slug; ?>/<? echo $city->slug ?>-weddings/party-caterers"><?php echo $city->name;; ?> Party Caterers</a></li>
								<li><a href="/<?php echo $state->slug; ?>/<? echo $city->slug ?>-weddings/kosher-caterers"><?php echo $city->name;; ?> Kosher Caterers</a></li>
								<li><a href="/<?php echo $state->slug; ?>/<? echo $city->slug ?>-weddings/bartenders-2"><?php echo $city->name;; ?> Bartenders</a></li>
								
								<li class="service-title"><h2>Stationery &amp; Invitations</h2></li>
								<li><a href="/<?php echo $state->slug; ?>/<? echo $city->slug ?>-weddings/wedding-invitations"><?php echo $city->name;; ?> Wedding Invitations</a></li>
								<li><a href="/<?php echo $state->slug; ?>/<? echo $city->slug ?>-weddings/party-invitations"><?php echo $city->name;; ?> Party Invitations</a></li>
								<li><a href="/<?php echo $state->slug; ?>/<? echo $city->slug ?>-weddings/wedding-calligraphy"><?php echo $city->name;; ?> Wedding Calligraphy</a></li>
								
								<li class="service-title"><h2>Cakes &amp; Dessert</h2></li>
								<li><a href="/<?php echo $state->slug; ?>/<? echo $city->slug ?>-weddings/wedding-cakes-2"><?php echo $city->name;; ?> Wedding Cakes</a></li>
								<li><a href="/<?php echo $state->slug; ?>/<? echo $city->slug ?>-weddings/grooms-cakes"><?php echo $city->name;; ?> Groom's Cakes</a></li>
								<li><a href="/<?php echo $state->slug; ?>/<? echo $city->slug ?>-weddings/party-cakes"><?php echo $city->name;; ?> Party Cakes</a></li>
							</ul>
							
							<ul class="services-list">
								<li class="service-title"><a href="/<?php echo $state->slug; ?>/<? echo $city->slug ?>-weddings/venues"><h2>Event Venues</h2></a></li>
								<li><a href="/<?php echo $state->slug; ?>/<? echo $city->slug ?>-weddings/wedding-venues"><?php echo $city->name;; ?> Wedding Venues</a></li>
								<li><a href="/<?php echo $state->slug; ?>/<? echo $city->slug ?>-weddings/wedding-ceremony-venues"><?php echo $city->name;; ?> Wedding Ceremony Venues</a></li>
								<li><a href="/<?php echo $state->slug; ?>/<? echo $city->slug ?>-weddings/hotels"><?php echo $city->name;; ?> Hotel Venues</a></li>
								<li><a href="/<?php echo $state->slug; ?>/<? echo $city->slug ?>-weddings/mitzvah-venues"><?php echo $city->name;; ?> Mitzvah Venues</a></li>
								<li><a href="/<?php echo $state->slug; ?>/<? echo $city->slug ?>-weddings/rehearsal-dinner-venue"><?php echo $city->name;; ?> Rehearsal Dinner Venues</a></li>
								<li><a href="/<?php echo $state->slug; ?>/<? echo $city->slug ?>-weddings/venues-with-amazing-views"><?php echo $city->name;; ?> Venues with Amazing Views</a></li>
								<li><a href="/<?php echo $state->slug; ?>/<? echo $city->slug ?>-weddings/country-club-venues"><?php echo $city->name;; ?> Country Club Venues</a></li>
								<li><a href="/<?php echo $state->slug; ?>/<? echo $city->slug ?>-weddings/city-and-private-clubs-venues"><?php echo $city->name;; ?> City and Private Club Venues</a></li>
								<li><a href="/<?php echo $state->slug; ?>/<? echo $city->slug ?>-weddings/antebellum-homes-venues"><?php echo $city->name;; ?> Antebellum Home Venues</a></li>
								<li><a href="/<?php echo $state->slug; ?>/<? echo $city->slug ?>-weddings/ballroom-venues"><?php echo $city->name;; ?> Ballroom Venues</a></li>
								<li><a href="/<?php echo $state->slug; ?>/<? echo $city->slug ?>-weddings/barn-venues"><?php echo $city->name;; ?> Barn Venues</a></li>
								<li><a href="/<?php echo $state->slug; ?>/<? echo $city->slug ?>-weddings/banquet-halls"><?php echo $city->name;; ?> Banquet Hall Venues</a></li>
								<li><a href="/<?php echo $state->slug; ?>/<? echo $city->slug ?>-weddings/conference-centers"><?php echo $city->name;; ?> Conference Center Venues</a></li>
								<li><a href="/<?php echo $state->slug; ?>/<? echo $city->slug ?>-weddings/galleries-museums"><?php echo $city->name;; ?> Galleries &amp; Museum Venues</a></li>
								<li><a href="/<?php echo $state->slug; ?>/<? echo $city->slug ?>-weddings/gardens-venues"><?php echo $city->name;; ?> Garden Venues</a></li>
								<li><a href="/<?php echo $state->slug; ?>/<? echo $city->slug ?>-weddings/golf-course"><?php echo $city->name;; ?> Golf Course Venues</a></li>
								<li><a href="/<?php echo $state->slug; ?>/<? echo $city->slug ?>-weddings/historic-venues"><?php echo $city->name;; ?> Historic Venues</a></li>
								<li><a href="/<?php echo $state->slug; ?>/<? echo $city->slug ?>-weddings/outdoor-venues"><?php echo $city->name;; ?> Outdoor Venues</a></li>
								<li><a href="/<?php echo $state->slug; ?>/<? echo $city->slug ?>-weddings/private-home-mansion-venues"><?php echo $city->name;; ?> Private Home/Mansions Venues</a></li>
								<li><a href="/<?php echo $state->slug; ?>/<? echo $city->slug ?>-weddings/rooftop-venues"><?php echo $city->name;; ?> Rooftop Venues</a></li>
								<li><a href="/<?php echo $state->slug; ?>/<? echo $city->slug ?>-weddings/waterfront-venues"><?php echo $city->name;; ?> Waterfront Venues</a></li>
								<li><a href="/<?php echo $state->slug; ?>/<? echo $city->slug ?>-weddings/winery-vineyard-venues"><?php echo $city->name;; ?> Wineries &amp; Vineyards</a></li>
								<li><a href="/<?php echo $state->slug; ?>/<? echo $city->slug ?>-weddings/beachfront-venues"><?php echo $city->name;; ?> Beach Venues</a></li>
								
								<li class="service-title"><a href="/<?php echo $state->slug; ?>/<? echo $city->slug ?>-weddings/floral-and-event-design"><h2>Floral and Event Design</a></h2></li>
								<li><a href="/<?php echo $state->slug; ?>/<? echo $city->slug ?>-weddings/event-lighting"><?php echo $city->name;; ?> Event Lighting</a></li>
								<li><a href="/<?php echo $state->slug; ?>/<? echo $city->slug ?>-weddings/party-rentals"><?php echo $city->name;; ?> Party Rentals</a></li>
								<li><a href="/<?php echo $state->slug; ?>/<? echo $city->slug ?>-weddings/tent-rentals"><?php echo $city->name;; ?> Tent Rentals</a></li>
								<li><a href="/<?php echo $state->slug; ?>/<? echo $city->slug ?>-weddings/chair-covers-and-linens"><?php echo $city->name;; ?> Chair Covers &amp; Linens</a></li>
								<li><a href="/<?php echo $state->slug; ?>/<? echo $city->slug ?>-weddings/event-drapery-2"><?php echo $city->name;; ?> Event Drapery</a></li>
								<li><a href="/<?php echo $state->slug; ?>/<? echo $city->slug ?>-weddings/wedding-florist"><?php echo $city->name;; ?> Wedding Florist</a></li>
								
								<li class="service-title"><h2>Other Services</h2></li>
								<li><a href="/<?php echo $state->slug; ?>/<? echo $city->slug ?>-weddings/bridal-shows"><?php echo $city->name;; ?> Bridal Shows</a></li>
								<li><a href="/<?php echo $state->slug; ?>/<? echo $city->slug ?>-weddings/party-expos"><?php echo $city->name;; ?> Party Expos</a></li>
								<li><a href="/<?php echo $state->slug; ?>/<? echo $city->slug ?>-weddings/convention-visitor-bureaus"><?php echo $city->name;; ?> Convention &amp; Visitor Bureaus</a></li>
							</ul>

						</div>

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
								<li><a href="/vendors/atlanta">Atlanta</a></li>
								<li><a href="/vendors/savannah">Savannah</a></li>
							</ul>
						</div>

						<div class="location-box florida">
							<h2>Florida</h2>
							<ul>
								<li><a href="/vendors/orlando">Orlando</a></li>
								<li><a href="/vendors/tampa">Tampa</a></li>
								<li><a href="/vendors/south-florida">South Florida</a></li>
								<li><a href="/vendors/jacksonville">Jacksonville</a></li>
							</ul>
						</div>
					</div>


				</section>

			</div>

		<?php endwhile; ?>

	<?php else : ?>

		<div class="alert alert-info">
			<strong>No content in this loop</strong>
		</div>

	<?php endif; ?>	

</div>



<?php get_footer(); ?>