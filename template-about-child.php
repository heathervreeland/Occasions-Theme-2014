<?php 
/**
 * Template Name: Template About Child
 */
get_header(); ?>


<div class="row about" id="single-post-row">
	<div id="page-about">
		<?php if(have_posts()) : ?>
			<?php while(have_posts()) : the_post(); ?>

				<?php
					$this_page = get_page_by_path('about'); 

					if ( function_exists('yoast_breadcrumb') ) {
						yoast_breadcrumb('<p id="breadcrumbs">','</p>');
					}

					$categories = get_the_category();

					// Get parent category to change color dynamically
					$parent_cat;
					foreach($categories as $cat) {
						if ( $cat->parent != 0 )
							$parent_cat = get_category($cat->parent);
						else
							$parent_cat = $cat;
					}
					add_filter('the_content','wrap_image_credits', 20);
				?>
				<div class="page-block <?php echo $parent_cat->slug; ?>" id="main">

					<?php get_sidebar('blog'); ?>

					<section class="post-container">

						<div class="post-category-floater">
							<span class="nice-button dept">About</span>
						</div>

						<div class="post-content story ">

							<h1><?php oo_page_title($this_page->post_title) ?></h1>

							<div class="border-line"></div>


							<?php oo_part('about-nav') ?>
							<?php if ($_REQUEST['nggpage'] == '') : ?>
							<?php add_filter('the_content','wrap_image_credits', 20); ?>
							<?php the_content(); ?>
							<?php remove_filter('the_content','wrap_image_credits'); ?>
							<?php else: ?>
								<?php preg_match('/\[nggallery.+id=\d+\]/i', $post->post_content, $ngg); ?>
								<?php echo do_shortcode( $ngg[0] ); ?>
							<?php endif; ?>
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

</div>


<?php get_footer(); ?>