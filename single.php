<?php get_header(); ?>

<div class="row" id="single-post-row">

	<?php if(have_posts()) : ?>
		<?php while(have_posts()) : the_post(); ?>

			<?php 
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
						<span class="nice-button dept"><?php echo $categories[0]->cat_name; ?></span>
					</div>

					<div class="post-content story ">

						<h1><?php the_title(); ?></h1>
						<p class="post-meta">Posted <span class="date"><?php echo get_the_date("F j, Y"); ?></span> by <span class="author"><?php the_author(); ?></span></p>
							<div class="venue-share">
								Share This Post

								<?php oo_part("social-share"); ?>

							</div>
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

					<div class="venue-share after-story">
						Share This Post

						<?php oo_part("social-share"); ?>

					</div>

					<?php 
						// Previous and Next Post Links
						get_prev_next_post_links();	?>

					<?
						// Suggested posts
						oo_part("you_may_also_like"); ?>

					<?php 
						// Comments template
						comments_template(); ?>

				</section>

				<?php get_sidebar('blog'); ?>

			</div>

		<?php endwhile; ?>

	<?php else : ?>

		<div class="alert alert-info">
			<strong>No content in this loop</strong>
		</div>

	<?php endif; ?>	

</div>



<?php get_footer(); ?>