<?php 
/**
 * Template Name: Template About Child
 */
get_header(); ?>
<div id="main">
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<?php $about = get_page_by_path('about'); ?>
		<div id="page-about">
			<?php oo_page_title($about->post_title) ?>
			<?php oo_part('about-nav') ?>rthtrhtr
			<article <?php post_class(); ?>>
				<div class="story">

					<?php
						$siblings = array();

						$query = new WP_Query(array(
							'post_parent' 	=> $post->post_parent,
							'post_type'		=> 'page',
							'orderby'		=> 'menu_order',
							'order'			=> 'ASC',
							'posts_per_page'=> -1,
						));
					?>
					<?php if ($query->have_posts()): ?>
						<nav class="cf">
							<ul>
								<?php while($query->have_posts()) : $query->the_post(); ?>
									<li <?php echo is_page(get_the_ID()) ? 'class="current"' : '' ?>>
										<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
									</li>
								<?php endwhile; ?>
							</ul>
						</nav>
					<?php endif; wp_reset_query(); ?>

								


				</div>
			</article>
		</div>
	<?php endwhile; else: ?>
		<?php oo_part('notfound')?>
	<?php endif; ?>
</div>
<?php get_sidebar('about'); ?>
<?php get_footer(); ?>