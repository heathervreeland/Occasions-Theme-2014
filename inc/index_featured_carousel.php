<?php
	
	// Get the latest featured posts
	$featured_query = new WP_Query( "post_type=post&post_status=publish&meta_key=featured_story&meta_value=1&posts_per_page=4&orderby=date&order=DESC" );

	if($featured_query->have_posts()) : 
    	
?>


	<div class="skdslider-wrapper" id="featured-carousel">
		<div class="skdslider">
			<ul class="slides">

				<?php

					while($featured_query->have_posts()) : 
						$featured_query->the_post();
						$category = get_the_category(); $category = $category[0];
						if($category->category_parent == "0") {
							$post_cat_slug = $category->slug;
						}
						else {
							$parent = get_category($category->category_parent);
							$post_cat_slug = $parent->slug;
						}
		    	?>

					<li class="<?php echo $post_cat_slug; ?>">
						<div class="featured-meta">
							<div class="container">
								<a href="#" class="nice-button">View Article</a>
								<a href="<?php the_permalink(); ?>"><h1><?php the_title(); ?></a></h1>
							</div>
						</div>
						<div class="featured-image"><?php the_post_thumbnail('full'); ?></div>
					</li>
				<?php
					endwhile;
				?>

			</ul>
		</div>
	</div>


      
<?php
	endif;
?>
