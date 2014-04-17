<?php
	/* 
	Template Name: Profile
	*/

	oo_advertiser_logged_in();
	get_header();
?>
<div id="main">
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div id="advertisers">
			<?php the_title(); ?>
			<?php the_content(); ?>
		</div>
	<?php endwhile; else: ?>
		<?php oo_part('notfound')?>
	<?php endif; ?>
</div>
<?php get_sidebar('advertisers'); ?>
<?php get_footer(); ?>
