<?php get_header(); ?>

<div class="row page">

	<?php if(have_posts()) : ?>
		<?php while(have_posts()) : the_post(); ?>

			<?php 
				if ( function_exists('yoast_breadcrumb') ) {
					yoast_breadcrumb('<p id="breadcrumbs">','</p>');
				}
			?>
			<div class="page-block" id="main">

				<?php get_sidebar('general'); ?>

				<section class="post-container">

					<div class="post-content story ">

						<h1><?php the_title(); ?></h1>
						<p class="post-meta">Posted <span class="date"><?php echo get_the_date("F j, Y"); ?></span> by <span class="author"><?php the_author(); ?></span></p>

						<div class="border-line"></div>

						<?php if ($_REQUEST['nggpage'] == '') : ?>
						<?php the_content(); ?>
						<?php else: ?>
							<?php preg_match('/\[nggallery.+id=\d+\]/i', $post->post_content, $ngg); ?>
							<?php echo do_shortcode( $ngg[0] ); ?>
						<?php endif; ?>
					</div>

					<?php 
						// Comments template
						comments_template(); ?>

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