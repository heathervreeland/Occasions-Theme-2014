<?php get_header(); ?>

<div class="row page">

	<?php if(have_posts()) : ?>
		<?php while(have_posts()) : the_post(); ?>

			<?php 
				if ( function_exists('yoast_breadcrumb') ) {
					yoast_breadcrumb('<p id="breadcrumbs">','</p>');
				}

				//page slug
				$post_data = get_post(get_the_id(), ARRAY_A);
    			$slug = $post_data['post_name'];
			?>
			<div class="page-block <?php echo $slug; ?>" id="main">

				<?php get_sidebar('blog'); ?>

				<section class="post-container">

					<div class="post-content story ">

						<h1><?php the_title(); ?></h1>

						<div class="border-line"></div>

						<?php if ($_REQUEST['nggpage'] == '') : ?>
						<?php the_content(); ?>
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



<?php get_footer(); ?>