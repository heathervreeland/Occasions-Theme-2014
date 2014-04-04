<?php
	
	// Get the latest featured posts
	$featured_query = new WP_Query( "post_type=post&meta_key=featured_story&meta_value=1&posts_per_page=4&orderby=date&order=DESC" );

	if($featured_query->have_posts()) : 
    	
?>


	<div class="skdslider-wrapper" id="featured-carousel">
		<div class="skdslider">
			<ul class="slides">

				<?php

					while($featured_query->have_posts()) : 
						$featured_query->the_post();

						$postmeta = get_post_meta( get_the_ID() );
		    	?>

					<li class="<?php foreach(get_the_category() as $category) {echo $category->slug . ' '; break;} ?>">
						<div class="featured-meta">
							<div class="container">
								<a href="#" class="nice-button">View Article</a>
								<h1><?php the_title(); ?></h1>
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
