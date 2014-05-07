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
		/* get gallery pictures... or pictures in post */
		$album_pics = get_post_gallery_images(get_the_ID());
		$album_images = array();
		$images = array();
		if(sizeof($album_pics) > 0) {
			// process the gallery images
			foreach ( $album_pics as $pic ) {
				$string = str_replace(array("-75x75", "-170x170", "-300x300"), "", $pic);
				$string = explode("?", $string);
				$string = $string[0];
				$album_images[] = $string;
			}
		}
		else {
			// get the pictures in the post
			$images =& get_children( array (
				'post_parent' => get_the_ID(),
				'post_type' => 'attachment',
				'post_mime_type' => 'image'
			));
		}

		$cover_stories->the_post();
		$category = get_the_category(); $category = $category[0];
		if($category->category_parent == "0") {
			$post_cat_slug = $category->slug;
		}
		else {
			$parent = get_category($category->category_parent);
			$post_cat_slug = $parent->slug;
		}
?>


	<div class="skdslider-wrapper" id="featured-carousel">
		<div class="skdslider">
			<ul class="slides">
				<?php
					// If one array is populated the other will be empty, simpler this way
					foreach($album_images as $pic) {
				?>	
					<li class="<?php echo $post_cat_slug; ?>">
						<div class="featured-meta">
							<div class="container">
								<a href="<?php echo $permalink;  ?>" class="nice-button">View Article</a>
								<a href="<?php echo $permalink;  ?>"><h1><?php echo $title; ?></a></h1>
							</div>
						</div>
						<div class="featured-image"><img src="<?php echo $pic; ?>"/></div>
					</li>
				<?php
					}
				?>
				<?php
					foreach($images as $pic) {
				?>	
					<li class="<?php echo $post_cat_slug; ?>">
						<div class="featured-meta">
							<div class="container">
								<a href="#" class="nice-button">View Article</a>
								<a href="<?php echo $permalink;  ?>"><h1><?php echo $title; ?></a></h1>
							</div>
						</div>
						<div class="featured-image"><img src="<?php echo $pic->guid; ?>"/></div>
					</li>
				<?php
					}
				?>
			</ul>
		</div>
	</div>


<?php
	endwhile;
	endif;
?>
