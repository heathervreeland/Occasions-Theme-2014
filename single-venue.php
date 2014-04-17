<?php 

	get_header();
 
	$type 	= get_term_by('slug', get_query_var('type'), 'venue-type');
	$region = get_term_by('slug', get_query_var('region'), 'region');
	oo_vendor_profile_view();

 ?>

<div class="row" id="single-post-row">

	<?php if(have_posts()) : ?>
		<?php while(have_posts()) : the_post(); ?>

			<?php 

				$city = oo_get_venue_city();
				$service = oo_get_venue_service();

				add_filter('the_content','wrap_image_credits', 20);
			?>

			<p id="breadcrumbs">
				<span xmlns:v="http://rdf.data-vocabulary.org/#"><span typeof="v:Breadcrumb"><a href="/" rel="v:url" property="v:title">Home</a></span> • 
				<span typeof="v:Breadcrumb"><a href="/vendors" rel="v:url" property="v:title">Vendors &amp; Venues</a></span> • 
				<span typeof="v:Breadcrumb"><a href="/vendors/<?php echo $city->slug; ?>" rel="v:url" property="v:title"><?php echo $city->name; ?></a></span> • 
				<span typeof="v:Breadcrumb"><a href="/vendors/<?php echo $city->slug; ?>-weddings/<?php echo $service->slug;?>" rel="v:url" property="v:title"><?php echo $city->name . " " . $service->name; ?></a></span> • 
				<span typeof="v:Breadcrumb"><span class="breadcrumb_last" property="v:title"><?php the_title() ?></span></span>
			</p>

			<div class="page-block <?php echo $parent_cat->slug; ?>" id="main">

				<?php get_sidebar('blog'); ?>

				<section class="post-container venue" id="venue">

					<div class="post-category-floater">
						<span class="nice-button dept"><?php echo $service->name?></span>
					</div>

					<div class="post-content story ">

						<h1 class="title"><?php the_title(); ?></h1>
						<div class="post-meta">
							<address>
							<?php if (oo_get_meta('contact_address_show')): ?>
									<?php oo_meta('contact_address') ?>
									<?php oo_meta('contact_address_city') ?>
									<?php oo_meta('contact_address_state') ?>,
									<?php oo_meta('contact_address_zip') ?>
									<?php if (oo_meta('contact_address_county')): ?>
										, <?php oo_meta('contact_address_county') ?>
									<?php endif ?>
							<?php endif ?>
							</address>
							<div class="contact">
								<?php if( oo_get_meta('contact_address_phone1') ) { ?>
								<span class="phone">Phone: <?php oo_meta('contact_address_phone1'); ?></span>
								<?php } ?>
								<?php if( oo_get_meta('contact_email') ) { ?>
								<span class="email">Email: <?php oo_meta('contact_email'); ?></span>
								<?php } ?>
							</div>

							<?php if (oo_get_meta('website')): ?>
								<a href="<?php oo_meta('website'); ?>" class="nice-button">View Website</a>
							<?php endif ?>
						</div>

						<div class="venue-share">
							Share This 

							<a href="#" class="facebook"></a>
							<a href="#" class="twitter"></a>
							<a href="#" class="pinterest"></a>
							<a href="#" class="rss"></a>

						</div>


						<div class="border-line"></div>


						<div class="vendor-list-block">
							
							<div class="vendor-list-block-actions">
								<figure>
									<a href="<?php the_permalink() ?>"><?php the_post_thumbnail('venue-thumbnail') ?></a>
								</figure>

								<div class="vendor-rating stars<?php oo_venue_rating() ?>"></div>
							</div>

							<div class="detail">
								<?php if (oo_get_meta('description')): ?>
									<div class="descr">
										<?php oo_meta('description') ?>
									</div>
								<?php endif ?>
							</div>


						</div>


						<?php $gallery_images = oo_get_attached_images(get_the_ID(), false);?>

						<?php if (count($gallery_images)): ?>
							<div class="gallery">
								<div id="venue-gallery" class="flexslider cf">
									<ul class="slides">
										<?php foreach($gallery_images as $image):?>
											<li>
												<figure>
													<?php echo wp_get_attachment_image($image->ID, 'venue-preview')?>
												</figure>
											</li>
										<?php endforeach;?>
									</ul>
								</div>
							</div>
							<div class="thumbs">
								<div id="venue-thumbnails" class="flexslider cf">
									<ul class="slides">
										<?php foreach($gallery_images as $image):?>
											<li><?php echo wp_get_attachment_image($image->ID, 'venue-gthumbnail')?></li>
										<?php endforeach;?>
									</ul>
								</div>
							</div>
						<?php endif ?>

						<div class="section-breaker inside">
							Information
						</div>

						<?php
							$video_url = oo_get_meta('video_url');
							$downloads = oo_get_vendor_attached_files();
							$from_the_blog = array();
							$events = array();
						?>


						<div id="venue-information">

							<div class="service details">
									<h2>Venue Details</h2>
									
									<dl class="cf">
										<dr>
											<dt>
												Spaces Available
											</dt>
											<dd>
												<?php 	if (oo_get_meta('additional_spaces') != '') {
															oo_meta('additional_spaces');
														}
														else {
															"-";
														}
												?>
											</dd>
										</dr>
										<dr>
											<dt>
												Capacity
											</dt>
											<dd>
												<?php 	if (oo_get_meta('additional_capacity') != '') {
															oo_meta('additional_capacity');
														}
														else {
															"-";														}
														}
												?>
											</dd>
										</dr>
										<dr>
											<dt>
												Square Footage
											</dt>
											<dd>
												<?php 	if (oo_get_meta('additional_footage') != '') {
															oo_meta('additional_footage');
														}
														else {
															"-";
														}
												?>
											</dd>
										</dr>
										<dr>
											<dt>
												Catering Policy
											</dt>
											<dd>
												<?php 	if (oo_get_meta('additional_cathering') != '') {
															oo_meta('additional_cathering');
														}
														else {
															echo "-";
														}
												?>
											</dd>
										</dr>
										<dr>
											<dt>
												Alcohol Policy
											</dt>
											<dd>
												<?php 	if (oo_get_meta('additional_alcohool')) {
															echo "Yes, outside alcohol vendors are permitted";
														}
														else {
															echo "No";	
														}
												?>
											</dd>
										</dr>
										<dr>
											<dt>
												Onsite Accommodations
											</dt>
											<dd>
												<?php 	if (oo_get_meta('additional_accomodations')) {
															echo "Yes";
														}
														else {
															echo "No";	
														}
												?>
											</dd>
										</dr>
										<dr>
											<dt>
												Handicap Accessible
											</dt>
											<dd>
												<?php 	if (oo_get_meta('additional_handicap')) {
															echo "Yes";
														}
														else {
															echo "No";														}
														}
												?>
											</dd>
										</dr>
										<dr>
											<dt>
												We Accept
											</dt>
											<dd>
												<?php
													if (empty(oo_get_meta('additional_accepted_payments', false))) { echo "-"; }
													foreach (oo_get_meta('additional_accepted_payments', false) as $payment): ?>
													<span>
														<img src="<?php echo get_template_directory_uri() . '/images/payments/logo-' . strtolower($payment) . '.jpg' ?>" alt="<?php $payment ?>" />
													</span>
												<?php endforeach ?>
											</dd>
										</dr>

									</dl>
								</div>


								<?php if (count($downloads)): ?>
									<div id="venue-downloads" class="tab">
										<h2>Downloads</h2>
										<?php foreach($downloads as $file):?>
											<li>
												<a href="<?php echo $file->guid; ?>" rel="external"><strong><?php echo $file->post_title; ?></strong></a> 
											</li>
										<?php endforeach; ?>
									</div>
								<?php endif ?>

								<?php if ($video_url): ?>
									<div id="venue-video" class="tab">
										<h2>Video</h2>
										<?php echo wp_oembed_get($video_url, array('width' => '600', 'height' => '400')) ?>
									</div>
								<?php endif ?>

						</div>

					</div>				

					<div class="venue-share after-story">
						Share This 

						<a href="#" class="facebook"></a>
						<a href="#" class="twitter"></a>
						<a href="#" class="pinterest"></a>
						<a href="#" class="rss"></a>

					</div>

					<?php 
						// Previous and Next Post Links
						get_prev_next_venue_links();	?>

					<?
						// Suggested posts
						oo_part("you_may_also_like"); ?>

					<?php 
						// Comments template
						comments_template(); ?>

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

