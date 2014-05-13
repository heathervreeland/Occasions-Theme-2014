<?php
	global $post;
	// Get cover stories
	$cover_stories = get_cover_stories();
	// Get the latest featured posts
	
	if($cover_stories->have_posts()) : 
    	
?>


<?php
	while($cover_stories->have_posts()) : $cover_stories->the_post();

		$pid = get_the_ID();
		$title = get_the_title($pid);
		$permalink = get_permalink($pid);
?>
<?

		$cover_stories->the_post();
		$category = get_the_category(); $category = $category[0];
		if($category->category_parent == "0") {
			$post_cat_slug = $category->slug;
		}
		else {
			$parent = get_category($category->category_parent);
			$post_cat_slug = $parent->slug;
		}

		// Get Cover Story Image
		$cover_image = get_post_meta( $pid, 'cover_story_image', true );

?>


	<div class="skdslider-wrapper" id="featured-carousel">
		<div class="skdslider">
			<ul>
				<li class="<?php echo $post_cat_slug; ?>">
					<div class="featured-meta">
						<div class="container">
							<a href="#" class="nice-button">View Article</a>
							<a href="<?php echo $permalink;  ?>"><h1><?php echo $title; ?></a></h1>
						</div>
					</div>
					<div class="featured-image"><img src="<?php echo $cover_image['guid'];?>"/></div>
				</li>
			</ul>
		</div>
	</div>


<?php
	endwhile;
	endif;
?>
