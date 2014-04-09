<?php get_header(); ?>

<div class="row" id="post-page">

	<?php if(have_posts()) : ?>
		<?php while(have_posts()) : the_post(); ?>

			<?php 
				if ( function_exists('yoast_breadcrumb') ) {
					yoast_breadcrumb('<p id="breadcrumbs">','</p>');
				}
			?>

			<h2><?php the_title(); ?></h2>

			<?php the_content(); ?>

		<?php endwhile; ?>

	<?php else : ?>

		<div class="alert alert-info">
			<strong>No content in this loop</strong>
		</div>

	<?php endif; ?>	


Single page

</div>



<?php get_footer(); ?>a