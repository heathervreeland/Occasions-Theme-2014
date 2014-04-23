<?php get_header(); ?>

<div class="row" id="subscribe">


	<?php 
		if ( function_exists('yoast_breadcrumb') ) {
			yoast_breadcrumb('<p id="breadcrumbs">','</p>');
		}
	?>
	<div class="page-block <?php echo $parent_cat->slug; ?>" id="main">

		<?php get_sidebar('blog'); ?>

		<section class="post-container">

			
			<?php $issues_query = new WP_Query(array(
				'post_type' 		=> 'issue',
				'order'				=> 'DESC',
				'orderby'			=> 'rank',
				'posts_per_page' 	=> -1,
			)); ?>
			<?php if ($issues_query->have_posts()): ?>
				<section class="issues">
					<ul>
						<?php while($issues_query->have_posts()): $issues_query->the_post(); ?>
							<li class="cf">
								<?php if (oo_get_meta('premier')): ?>
									<span class="premier">Premier Issue</span>
								<?php endif ?>
								<figure>
									<?php the_post_thumbnail('issue-preview'); ?>
								</figure>
								<div class="detail">
									<h2><?php the_title(); ?></h2>
									<p class="region">Region: <?php oo_meta('region') ?></p>
									<p class="descr">
										<?php echo nl2br(oo_get_meta('info')) ?>
									</p>
									<?php if (oo_get_meta('soldout')): ?>
										<p class="soldout">Sold Out</p>
									<?php else: ?>
										<?php
											$copy = oo_get_meta('single');
											$box = oo_get_meta('box');
										?>
										<?php if ($copy): ?>
											<?php oo_issue_cart_form($copy, true); ?>
										<?php endif ?>
										<?php if ($box): ?>
											<?php oo_issue_cart_form($box, true); ?>
										<?php endif ?>
									<?php endif ?>
								</div>
							</li>
						<?php endwhile;?>
					</ul>
				</section>
			<?php endif ?>

		</section>

	</div>


</div>



<?php get_footer(); ?>