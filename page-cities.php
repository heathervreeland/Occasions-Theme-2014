<?php get_header(); ?>


<div class="row" id="single-post-row">

	<?php if(have_posts()) : ?>
		<?php while(have_posts()) : the_post(); ?>

			<?php 
				if ( function_exists('yoast_breadcrumb') ) {
					yoast_breadcrumb('<p id="breadcrumbs">','</p>');
				}

				add_filter('the_content','wrap_image_credits', 20);
			?>
			<div class="page-block cities" id="main">

				<section class="post-container">

					<div class="post-category-floater">
						<span class="nice-button dept"><?php the_title(); ?></span>
					</div>

					<div class="post-content story ">

						<h1>In Your Area</h1>
							<div class="venue-share">
								Share This

								<?php oo_part("social-share"); ?>

							</div>
						<div class="border-line"></div>


						<div class="section-divider">
							<div class="line"></div>
							<span class="before">&#8226;</span>
							<span class="heading">Select by Location</span>
							<span class="after">&#8226;</span>
						</div>
						<div id="vendors-locations">

							<div class="location-box georgia">
								<h2>Georgia</h2>
								<ul>
									<li><a href="/georgia/atlanta">Atlanta</a></li>
									<li><a href="/georgia/savannah">Savannah</a></li>
								</ul>
							</div>

							<div class="location-box florida">
								<h2>Florida</h2>
								<ul>
									<li><a href="/florida/orlando">Orlando</a></li>
									<li><a href="/florida/tampa">Tampa</a></li>
									<li><a href="/florida/south-florida">South Florida</a></li>
									<li><a href="/florida/jacksonville">Jacksonville</a></li>
								</ul>
							</div>

						</div>


					</div>

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