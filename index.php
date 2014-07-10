<?php
    get_header();
	/* recent featured posts */
	global $recent_featured_posts;
	uasort($recent_featured_posts, "sort_recent_posts");
	
?>


<div class="row">
	
	<div class="section-divider">
		<div class="line"></div>
		<span class="before">&#8226;</span>
		<span class="heading">Page Not Found</span>
		<span class="after">&#8226;</span>
	</div>

	<div>
          <h4>We are sorry! The page you're looking for does not
          exist. Visit the <a href="/">home page</a> for great ideas on
          planning your next event!</h4>
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
