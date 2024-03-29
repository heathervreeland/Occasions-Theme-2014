<?php 
/**
 * Template Name: Template Editorial Child
 */
get_header(); ?>


<div class="row editorial-guidelines" id="single-post-row">
	<div id="page-editorial">
		<?php if(have_posts()) : ?>
			<?php while(have_posts()) : the_post(); ?>

				<?php
					$this_page = get_page_by_path('editorial'); 

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

					<section class="post-container">

						<div class="post-category-floater">
							<span class="nice-button dept">Editorial</span>
						</div>

						<div class="post-content story ">

							<h1><?php the_title(); ?></h1>

							<div class="border-line"></div>


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

					<?php oo_part('nav-w-short-titles') ?>
					<?php get_sidebar('blog'); ?>

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