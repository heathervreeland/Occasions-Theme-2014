<?php
	define('DONOTCACHEPAGE', true);
	get_header();

 ?>

<div class="row" id="subscribe">

	<?php oo_part("cart-widget"); ?>

	<p id="breadcrumbs">
		<span xmlns:v="http://rdf.data-vocabulary.org/#"><span typeof="v:Breadcrumb"><a href="/" rel="v:url" property="v:title">Home</a></span> • 
		<span typeof="v:Breadcrumb"><span class="breadcrumb_last" property="v:title">Subscribe</span></span>
	</p>
	<div class="page-block <?php echo $parent_cat->slug; ?>" id="main">

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

		<?php get_sidebar('blog'); ?>

	</div>


</div>



<?php get_footer(); ?>