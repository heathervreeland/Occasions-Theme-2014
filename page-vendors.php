<?php

/* 
Template Name: Vendors
*/

 	get_header(); ?>

<div class="row venue" id="vendors-page">
	<?php if(have_posts()) : ?>
		<?php while(have_posts()) : the_post(); ?>

			<?php 
				if ( function_exists('yoast_breadcrumb') ) {
					yoast_breadcrumb('<p id="breadcrumbs">','</p>');
				}
			?>
		<?php endwhile;
		endif;
	?>
	<div class="page-block <?php echo $parent_cat->slug; ?>" id="main">

		<section class="post-container">

			<div class="section-divider top-divider">
				<div class="line"></div>
				<span class="before">&#8226;</span>
				<span class="heading">Venues &amp; Vendors</span>
				<span class="after">&#8226;</span>
			</div>

			<div class="post-content story ">

					<div id="index_vv">
						<div id="index_vv_celebration">
							<h2>The Celebration Society</h2>
							<span class="pink cele1">Best Venues &#8226; Most Reputable Vendors</span>
						</div>
						<img src="<?php echo get_template_directory_uri(); ?>/images/map_picture_vendors_section.png" id="index_vv_map"/>
					</div>


					<p>
						So that you can quickly find that trustworthy team of event vendors without worry of their reputation and skill,
						we created the Celebration Society, a carefully curated network of only the most talented, quality-centric wedding venues and party services
						in the special events industry.
					</p>

					<p>
						The businesses invited to join are chosen with careful consideration for their impeccable reputation, innate talent, commitment to their craft,
						keen sense of style, quality of work, professionalism and unmatched customer service.
					</p>

					<p class="vendors-trust">All of this, so you can trust your vendors<br/>and have a worry-free party planning experience!</p>

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
								<li><a href="/vendors/atlanta">Atlanta</a></li>
								<li><a href="/vendors/savannah">Savannah</a></li>
							</ul>
						</div>

						<div class="location-box florida">
							<h2>Florida</h2>
							<ul>
								<li><a href="/vendors/orlando">Orlando</a></li>
								<li><a href="/vendors/tampa">Tampa</a></li>
								<li><a href="/vendors/south-florida">South Florida</a></li>
								<li><a href="/vendors/jacksonville">Jacksonville</a></li>
							</ul>
						</div>

					</div>


			</div>

		</section>

		<?php get_sidebar('blog'); ?>

	</div>


</div>



<?php get_footer(); ?>