<?php // grab editors blog posts 

	$args = array(
		'post_type' => 'post',
		'category_name' => 'from-the-editor',
		'posts_per_page' => 5,
		'paged' => $paged
	);
	$query = new WP_Query( $args );

?>


<?php
	oo_part("mobile_ad");
?>

<div class="row" id="single-post-row">

	<div class="page-block editors-blog" id="main">

		<section class="post-container">

			<div class="post-category-floater">
				<span class="nice-button dept">Editor's Blog</span>
			</div>

			<?php if($query->have_posts()) : ?>
				<?php while($query->have_posts()) : $query->the_post(); 
						add_filter('the_content','wrap_image_credits', 20);
					?>
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

				<?php endwhile; ?>


			<?php else : ?>

				<div class="alert alert-info">
					<strong>No content in this loop</strong>
				</div>

			<?php endif; ?>	

			<?php
                custom_pagination(null,null,$query);
            ?>
		</section>

		<?php get_sidebar('blog'); ?>

	</div>


</div>
