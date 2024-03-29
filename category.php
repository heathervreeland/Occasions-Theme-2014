<?php get_header(); ?>


<?php
	$queried_object = get_queried_object();
	if( $queried_object->slug == "from-the-editor" ) {
		oo_part("editors-blog");
	}
	else {
?>



		<div class="row" id="category_list">

			<?php if ( function_exists('yoast_breadcrumb') ) {
					yoast_breadcrumb('<p id="breadcrumbs">','</p>');
			} ?>

			<div class="section-divider">
				<div class="line"></div>
				<span class="before">&#8226;</span>
				<h1 class="heading"><?php single_cat_title(); ?></h1>
				<span class="after">&#8226;</span>
			</div>

			<div class="cat-description"><?php echo category_description(); ?></div>

			<?php if(have_posts()) : ?>

				<ul>
				<?php while(have_posts()) : the_post(); ?>

					<li class="col-md-3 category-block">
						<a href="<?php echo get_permalink(get_the_ID()); ?>">
							<div class="category-post-preview">
								<?php 
									if(get_the_post_thumbnail() != '') {
										the_post_thumbnail("large");
									} 
									else {
										$images =& get_children( array (
											'post_parent' => get_the_ID(),
											'post_type' => 'attachment',
											'post_mime_type' => 'image'
										));
										if(empty($images)) {
											echo "<img src=\"" . catch_that_image() . "\"/>";
										}
										else {
											$images = reset($images);
											echo "<img src=\"" . $images->guid . "\"/>";
										}
									}
								?>
							</div>
							<h2><?php echo truncate_string(get_the_title(), 50); ?></h2>
							<div class="date">
								Posted <span><?php the_date("F j, Y"); ?></span>
							</div>
						</a>
					</li>

				<?php endwhile; ?>
				</ul>
			<?php else : ?>

				<div class="alert alert-info">
				<strong>No content in this loop</strong>
				</div>

			<?php endif; ?>

			<?php 
				pagination();
			 ?>

		</div>

<?php 
	}

?>

<?php get_footer(); ?>