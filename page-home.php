<?php

/* 
Template Name: Home
*/
	get_header(); 
	/* recent featured posts */
	global $recent_featured_posts;
	uasort($recent_featured_posts, "sort_recent_posts");
?>

<div class="row" id="index-sections">

	<? oo_part("mobile_ad_home"); ?>

	<div class="col-third">
		<div class="pull-left">
			<a href="/vendors">
				<div class="tile">
					<img src="<?php echo get_template_directory_uri(); ?>/images/top_section_vendors.jpg"/>
				</div>
			</a>
			<a href="#">
				<div class="tile">
					<img src="<?php echo get_template_directory_uri(); ?>/images/top_section_galleries.jpg"/>
				</div>
			</a>
		</div>
	</div>

	<div class="col-third">
		<div id="sections-carousel-container">
			<div id="sections-carousel">
				<div class="sections-skdslider">
					<ul class="slides">
					<?php
						
						// Get the latest featured posts
						if($recent_featured_posts) : 
							$counter = 0;
							foreach($recent_featured_posts as $post) {

								$category = get_the_category($post->ID); $category = $category[0];
								if($category->category_parent == "0") {
									$post_cat_slug = $category->slug;
								}
								else {
									$parent = get_category($category->category_parent);
									$post_cat_slug = $parent->slug;
								}
					?>
						<li class="<?php echo $post_cat_slug; ?>">
							<a href="<?php echo get_permalink($post->ID); ?>"><div class="sections-slide-overlay"></div></a>
							<div class="featured-image">
								<div class="featured-meta">
									<div class="container">
										<a href="<?php echo get_permalink($post->ID);  ?>" class="nice-button">View Article</a>
										<a href="<?php echo get_permalink($post->ID);  ?>"><h1><?php echo $post->post_title; ?></h1></a>
									</div>
								</div>
								<?php the_post_thumbnail('post-carousel-crop'); ?>
							</div>
						</li>
					<?php
							}
						endif;
					?>
					</ul>
				</div>
			</div>
		</div>

	</div>

	<div class="col-third">
		<div class="pull-right">
			<a href="#" id="sections-ad">
				<div class="tile">
					<?php oo_part('side-top-ad') ?>
				</div>
			</a>
			<a href="/subscribe">
				<div class="tile">
					<img src="<?php echo get_template_directory_uri(); ?>/images/top_section_shop.jpg"/>
				</div>
			</a>
		</div>
	</div>

</div>

<div class="row">
	
	<div class="section-divider">
		<div class="line"></div>
		<span class="before">&#8226;</span>
		<span class="heading">Venues &amp; Vendors</span>
		<span class="after">&#8226;</span>
	</div>

	<div id="index_vv">
		<div id="index_vv_celebration">
			<h2>The Celebration Society</h2>
			<span class="pink cele1">Best Venues &#8226; Most Reputable Vendors</span>
			<p class="cele2">
				So that you can quickly find that trustworthy team of event vendors without worry<br/>
				of their reputation and skills, we created the Celebration Society, a carefully curated<br/>
				network of only the most talented, quality-centric wedding venues and party<br/>
				services in the special events industry.
			</p>
			<a href="/vendors" class="nice-button">Find my Vendors</a>
			<span class="pink cele3">Don't see your company listed? Click to learn about our memberships</span>
		</div>
		<img src="<?php echo get_template_directory_uri(); ?>/images/map_picture_vendors_section.png" id="index_vv_map"/>
	</div>

</div>

<div class="row">
	
	<div class="section-divider">
		<div class="line"></div>
		<span class="before">&#8226;</span>
		<span class="heading">Department</span>
		<span class="after">&#8226;</span>
	</div>

	<div id="index_dept_grid">
		<a href="/galleries">
			<div class="col-md-3 one cont">
				<div>
					<span>Galleries</span>
					<p>A curated collection of the most inspire wedding &amp; party images we've featured. Pin away.</p>
				</div>
			</div>
		</a>
		<div class="col-md-3 two"></div>
		<a href="/real-weddings">
			<div class="col-md-3 three cont">
				<div>
					<span>Real Weddings</span>
					<p>Chosen for their style, unique-details and great vendors these real wedding are guaranteed to inspire.</p>
				</div>
			</div>
		</a>	
		<div class="col-md-3 four"></div>

		<div class="col-md-3 five"></div>
		<a href="#">
			<div class="col-md-3 six cont">
				<div>
					<span>Tools &amp; Checklists</span>
					<p>Budgets, Checklists and Vendor Interviews will put your party planning in motion</p>
				</div>
			</div>
		</a>
		<div class="col-md-3 seven"></div>
		<a href="/entertaining-and-holidays/holiday-party-ideas">
			<div class="col-md-3 eight cont">
				<div>
					<span>Holiday Inspirations</span>
					<p>Tasty Recipes and beautiful seasonal settings bound to bring out your inner hostess skills</p>
				</div>
			</div>
		</a>
		<a href="/entertaining-and-holidays/holiday-party-ideas">
			<div class="col-md-3 nine cont">
				<div>
					<span>Party Ideas</span>
					<p>Make everyday an occasion with ideas from birthday parties to bridal shows</p>
				</div>
			</div>
		</a>
		<div class="col-md-3 ten"></div>
		<a href="/from-the-editor">
			<div class="col-md-3 eleven cont">
				<div>
					<span>From the Editors</span>
					<p>Insider insights and a behind-the-scenes look from the team at Occasions</p>
				</div>
			</div>
		</a>
		<div class="col-md-3 twelve"></div>
	</div>

</div>

<div class="row" id="index_recent_posts">
	
	<div class="section-divider">
		<div class="line"></div>
		<span class="before">&#8226;</span>
		<span class="heading">Recent Posts</span>
		<span class="after">&#8226;</span>
	</div>

	<div id="index_recent_posts">

		<?php
			
			// Get the latest featured posts
			if($recent_featured_posts) : 
				$counter = 0;
				foreach($recent_featured_posts as $post) {
					$counter++;
					$category = get_the_category($post->ID); $category = $category[0];
					$post_cat =  $category->name; 
					if($category->category_parent == "0") {
						$post_cat_slug = $category->slug;
					}
					else {
						$parent = get_category($category->category_parent);
						$post_cat_slug = $parent->slug;
					}
					$date = date_create($post->post_date);
		?>

				<div class="col-md-4 <?php echo $post_cat_slug;?> <?php echo $counter == 3 ? "last" : ""; ?> ">

					<span class="nice-button dept"><?php echo $post_cat; ?></span>
					<div class="post-image">
						<?php 		if(get_the_post_thumbnail($post->ID) != '') {
										echo get_the_post_thumbnail($post->ID, $size);
									} 
									else {
										$images =& get_children( array (
											'post_parent' => $post->ID,
											'post_type' => 'attachment',
											'post_mime_type' => 'image'
										));
										if(empty($images)) {
											echo "<img src=\"" . catch_that_image() . "\"/>";
										}
										else {
											$images = reset($images);
											echo "<img src=\"" . $images->guid . "\"/>";
										}
									} ?>
					</div>
					<div class="content">
						<h1><a href="<?php echo get_permalink($post->ID); ?>"><?php echo get_the_title($post->ID); ?></a></h1>
					</div>
					<p class="post-meta">Posted <span class="date"><?php echo date_format($date, "F j, Y"); ?></span> by <span class="author"><?php echo get_the_author($post->ID); ?></span></p>
				</div>

      
		<?php
					if($counter == 3) break;
				}
			endif;
		?>

	</div>

</div>



<?php get_footer(); ?>