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

	<div class="col-md-4">
		<div class="pull-left">
			<a href="#">
				<div class="tile">
					<div class="title-cont">
						<div class="title">Venue &amp; Vendor<br/>Guide</div>
					</div>
					<img src="<?php echo get_template_directory_uri(); ?>/images/top_section_vendors.jpg"/>
				</div>
			</a>
			<a href="#">
				<div class="tile">
					<div class="title-cont">
						<div class="title">City Blog <span>Find Inspiration</span></div>
					</div>
					<img src="<?php echo get_template_directory_uri(); ?>/images/top_section_blog.jpg"/>
				</div>
			</a>
		</div>
	</div>

	<div class="col-md-4">
		<div id="sections-carousel-container">
			<div id="sections-carousel">
				<div class="sections-skdslider">
					<ul class="slides">
					<?php
						
						// Get the latest featured posts
						if($recent_featured_posts) : 
							$counter = 0;
							foreach($recent_featured_posts as $post) {
					?>
						<li>
							<a href="<?php echo get_permalink($post->ID); ?>"><div class="sections-slide-overlay"></div></a>
							<div class="featured-image"><?php get_nice_image("large"); ?></div>
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

	<div class="col-md-4">
		<div class="pull-right">
			<a href="#">
				<div class="tile">
					<div class="title-cont">
						<div class="title">Galleries</div>
					</div>
					<img src="<?php echo get_template_directory_uri(); ?>/images/top_section_galleries.jpg"/>
				</div>
			</a>
			<a href="#">
				<div class="tile">
					<div class="title-cont">
						<div class="title">Shop - Magazine <span>Subscribe to Occasions</span></div>
					</div>
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
		<span class="heading">Venue &amp; Vendor</span>
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
			<a href="#" class="nice-button">Find my Vendors</a>
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
		<div class="col-md-3 one cont">
			<div>
				<span>Galleries</span>
				<p>A curated collection of the most inspire wedding &amp; party images we've featured. Pin away.</p>
			</div>
		</div>
		<div class="col-md-3 two"></div>
		<div class="col-md-3 three cont">
			<div>
				<span>Real Weddings</span>
				<p>Chosen for their style, unique-details and great vendors these real wedding are guaranteed to inspire.</p>
			</div>
		</div>
		<div class="col-md-3 four"></div>

		<div class="col-md-3 five"></div>
		<div class="col-md-3 six cont">
			<div>
				<span>Tools &amp; Checklists</span>
				<p>Budgets, Checklists and Vendor Interviews will put your party planning in motion</p>
			</div>
		</div>
		<div class="col-md-3 seven"></div>
		<div class="col-md-3 eight cont">
			<div>
				<span>Holiday Inspirations</span>
				<p>Tasty Recipes and beautiful seasonal settings bound to bring out your inner hostess skills</p>
			</div>
		</div>

		<div class="col-md-3 nine cont">
			<div>
				<span>Party Ideas</span>
				<p>Make everyday an occasion with ideas from birthday parties to bridal shows</p>
			</div>
		</div>
		<div class="col-md-3 ten"></div>
		<div class="col-md-3 eleven cont">
			<div>
				<span>From the Editors</span>
				<p>Insider insights and a behind-the-scenes look from the team at Occasions</p>
			</div>
		</div>
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
						<?php echo get_the_post_thumbnail($post->ID, "medium"); ?>
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