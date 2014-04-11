<?php
	// Exclude categories
	$inc_cats = array();
	foreach(array("weddings","parties-and-celebrations","entertaining-and-holidays") as $cat) {
		$cat = get_category_by_slug($cat);
		$taxonomy = 'category';
		$inc_cats = array_merge($inc_cats, get_term_children( $cat->cat_ID, $taxonomy ));
	}

	$exc_cats = array();
	foreach(array("atlanta","savannah","south florida","jacksonville","tampa","orlando") as $cat) {
		$cat = get_category_by_slug($cat);
		$taxonomy = 'category';
		$exc_cats = array_merge($exc_cats, get_term_children( $cat->cat_ID, $taxonomy ));
	}
	//for use in the loop, list 5 post titles related to first tag on current post
	$tags = wp_get_post_tags($post->ID);
	if ($tags) {
		$tag_ids = array();
		foreach ( $tags as $tag )
		{
			$tag_ids[] = $tag->term_id;
		}
		$args=array(
			'tag__in' => $tag_ids,
			'post__not_in' => array($post->ID),
			'category__in' => $inc_cats,
			'category__not_in' => $exc_cats,
			'posts_per_page'=> 2,
			'caller_get_posts'=> 1,
			'orderby' => 'rand'
		);
		$ymal_query = new WP_Query($args);
		if( $ymal_query->have_posts() ) {	?>
		<div class="you_may_like">
			<div class="section-divider">
				<div class="line"></div>
				<span class="before">&#8226;</span>
				<span class="heading">You may also like</span>
				<span class="after">&#8226;</span>
			</div>	


		<?php
			while ($ymal_query->have_posts()) : $ymal_query->the_post();
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
				
				<div class="col-md-6 <?php echo $post_cat_slug;?> post_grid_block">

					<span class="nice-button dept"><?php echo $post_cat; ?></span>
					<div class="post-image">
						<?php get_nice_image('medium');	?>
					</div>
					<div class="content">
						<h1><a href="<?php echo get_permalink($post->ID); ?>"><?php echo get_the_title($post->ID); ?></a></h1>
					</div>
					<p class="post-meta">Posted <span class="date"><?php echo date_format($date, "F j, Y"); ?></span> by <span class="author"><?php echo get_the_author($post->ID); ?></span></p>
				</div>


<?php
			endwhile;
?>
	</div>
<?php
		}
	wp_reset_query();
	}
?>
