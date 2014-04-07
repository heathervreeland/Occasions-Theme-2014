<!DOCTYPE html>
<html>
	<head>
		<title><?php wp_title(); ?> <?php bloginfo( 'name' ); ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="utf8" />
		
		<link href="<?php bloginfo('template_directory'); ?>/css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link href="<?php bloginfo('stylesheet_url');?>" type="text/css" rel="stylesheet" media="screen, projection" />		
		<link href='http://fonts.googleapis.com/css?family=Antic+Didone|Raleway:400,700|Oswald:300,400' rel='stylesheet' type='text/css'>
		
		<?php wp_head(); ?>
		
		<?php if ( is_front_page() ) { ?>

			<script>
				$(function() {
					$('.jcarousel').jcarousel();

					$('.jcarousel-control-prev')
							.on('jcarouselcontrol:active', function() {
									$(this).removeClass('inactive');
							})
							.on('jcarouselcontrol:inactive', function() {
									$(this).addClass('inactive');
							})
							.jcarouselControl({
									target: '-=1'
							});

					$('.jcarousel-control-next')
							.on('jcarouselcontrol:active', function() {
									$(this).removeClass('inactive');
							})
							.on('jcarouselcontrol:inactive', function() {
									$(this).addClass('inactive');
							})
							.jcarouselControl({
									target: '+=1'
							});

				});
			</script>

		<?php }    ?>
	</head>
 
	<body <?php body_class($class); ?>>

		<div id="top-bar">
			<div class="container">

				<form>
					<div id="search">
						<input type="text" id="search_terms" placeholder="SEARCH"/>
						<a href="#" id="search_go">GO</a>
					</div>
				</form>

				<div id="top-social">
					<ul>
						<li><a href="#" class="facebook"></a></li>
						<li><a href="#" class="twitter"></a></li>
						<li><a href="#" class="pinterest"></a></li>
						<li><a href="#" class="rss"></a></li>
					</ul>
				</div>

				<ul>
					<li><a hred="#">Local Blogs</a></li>
					<li>&#8226;</li>
					<li><a hred="#">Planning Checklists</a></li>
					<li>&#8226;</li>
					<li><a hred="#">Editor's Blog</a></li>
					<li>&#8226;</li>
					<li><a hred="#">Get Featured</a></li>
					<li>&#8226;</li>
					<li><a hred="#">Advertise</a></li>
				</ul>

			</div>
		</div>
		
		<div class="container">
			<nav id="main-navigation" class="navbar navbar-default" role="navigation">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="<?php echo home_url(); ?>">Occasions Online</a>
				</div>
		 
				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse">
					<ul id="main-nav">
						<li class="main-nav dept vendors">
							<a href="#" class="hv"><span class="icon"></span>Vendors</a>
						</li>
						<li class="main-nav dept cities">
							<a href="#" class="hv"><span class="icon"></span>Cities</a>
						</li>
						<li class="main-nav dept galleries">
							<a href="#" class="hv"><span class="icon"></span>Galleries</a>
						</li>
						<li class="main-nav dept entertaining">
							<a href="#" class="hv"><span class="icon"></span>Entertaining</a>
							<div class="preview-window">
								<div class="menu-arrow"></div>

								<div class="submenu_categories">
									<div class="sub_container">
										<h2>Categories</h2>
										
										<ul>
											<li><a href="#">Food &amp; Drink</a></li>
											<li><a href="#">Outdoor</a></li>
											<li><a href="#">Dinner Parties</a></li>
											<li><a href="#">Products</a></li>
											<li><a href="#">Holiday Parties</a></li>
											<li><a href="#">Decor &amp; Centerpieces</a></li>
											<li><a href="#">Seasonal Settings</a></li>
											<li><a href="#">Sports Themed</a></li>
											<li><a href="#">Themes &amp; Ideas</a></li>
											<li><a href="#">DIY &amp; Tutorials</a></li>
										</ul>

										<a href="#" class="nice-button">View All</a>
									</div>
								</div>

								<div class="submenu_recent">
									<div class="sub_container">
										<?php
											// get most recent weddings post 

											$most_recent = get_most_recent_post_from_category('entertaining-and-holidays', 4);
											if($most_recent->have_posts()) : 
											while($most_recent->have_posts()) : 
												$most_recent->the_post();
												foreach(get_the_category() as $category) { $post_cat =  $category->name; $post_cat_slug = $category->slug; break;}
										?>
											<div class="recent_post_grid_block">
												<div class="<?php echo $post_cat_slug;?> <?php echo $counter == 3 ? "last" : ""; ?> ">
													<span class="nice-button dept"><?php echo $post_cat; ?></span>
													<div class="post-image">
														<?php the_post_thumbnail("medium"); ?>
													</div>
													<div class="content">
														<h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
													</div>
													<p class="post-meta">Posted <span class="date"><?php the_date("F j, Y"); ?></span> by <span class="author"><?php the_author(); ?></span></p>
												</div>
											</div>
										<?php
												break;
												endwhile;
											endif;
										?>
									</div>
								</div>


								<div class="submenu_features">
									<div class="sub_container">
										<h2>Features</h2>
										<ul>
											<?php
												if($most_recent->have_posts()) : 
												while($most_recent->have_posts()) : 
													$most_recent->the_post();
													foreach(get_the_category() as $category) { $post_cat =  $category->name; $post_cat_slug = $category->slug; break;}
											?>
												<li class="features_block">
													<div class="post-image">
														<?php the_post_thumbnail("thumbnail"); ?>
													</div>
													<div class="post-content">
														<span><?php echo $post_cat; ?></span>
														<h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
													</div>
												</li>
											<?php
													endwhile;
												endif;
											?>
										</ul>
									</div>
								</div>

							</div>
						</li>
						<li class="main-nav dept parties">
							<a href="#" class="hv"><span class="icon"></span>Parties</a>
							<div class="preview-window">
								<div class="menu-arrow"></div>

								<div class="submenu_categories">
									<div class="sub_container">
										<h2>Categories</h2>
										
										<ul>
											<li><a href="#">Birthday Parties</a></li>
											<li><a href="#">Kids Parties</a></li>
											<li><a href="#">For Girls</a></li>
											<li><a href="#">Themes &amp; Ideas</a></li>
											<li><a href="#">Baby Showers</a></li>
											<li><a href="#">DIY &amp; Tutorials</a></li>
											<li><a href="#">Themed Parties</a></li>
											<li><a href="#">Real Mitzvahs</a></li>
											<li><a href="#">Adult Parties</a></li>
											<li><a href="#">Bridal Showers</a></li>
											<li><a href="#">Sweet 16</a></li>
											<li><a href="#">Quincea&Ntilde;eras</a></li>
											<li><a href="#">For Boys</a></li>
											<li><a href="#">For Business</a></li>
											<li><a href="#">Anniversaries</a></li>
											<li><a href="#">Decorations</a></li>
										</ul>

										<a href="#" class="nice-button">View All</a>
									</div>
								</div>

								<div class="submenu_recent">
									<div class="sub_container">
										<?php
											// get most recent weddings post 

											$most_recent = get_most_recent_post_from_category('parties-and-celebrations', 4);
											if($most_recent->have_posts()) : 
											while($most_recent->have_posts()) : 
												$most_recent->the_post();
												foreach(get_the_category() as $category) { $post_cat =  $category->name; $post_cat_slug = $category->slug; break;}
										?>
											<div class="recent_post_grid_block">
												<div class="<?php echo $post_cat_slug;?> <?php echo $counter == 3 ? "last" : ""; ?> ">
													<span class="nice-button dept"><?php echo $post_cat; ?></span>
													<div class="post-image">
														<?php the_post_thumbnail("medium"); ?>
													</div>
													<div class="content">
														<h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
													</div>
													<p class="post-meta">Posted <span class="date"><?php the_date("F j, Y"); ?></span> by <span class="author"><?php the_author(); ?></span></p>
												</div>
											</div>
										<?php
												break;
												endwhile;
											endif;
										?>
									</div>
								</div>

								<div class="submenu_features">
									<div class="sub_container">
										<h2>Features</h2>
										<ul>
											<?php
												if($most_recent->have_posts()) : 
												while($most_recent->have_posts()) : 
													$most_recent->the_post();
													foreach(get_the_category() as $category) { $post_cat =  $category->name; $post_cat_slug = $category->slug; break;}
											?>
												<li class="features_block">
													<div class="post-image">
														<?php the_post_thumbnail("thumbnail"); ?>
													</div>
													<div class="post-content">
														<span><?php echo $post_cat; ?></span>
														<h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
													</div>
												</li>
											<?php
													endwhile;
												endif;
											?>
										</ul>
									</div>
								</div>


							</div>
						</li>
						<li class="main-nav dept weddings">
							<a href="#" class="hv"><span class="icon"></span>Weddings</a>
							<div class="preview-window">
								<div class="menu-arrow"></div>

								<div class="submenu_categories">
									<div class="sub_container">
										<h2>Categories</h2>
										
										<ul>
											<li><a href="#">Real Weddings</a></li>
											<li><a href="#">Bridal Showers</a></li>
											<li><a href="#">Rehearsal Dinners</a></li>
											<li><a href="#">Destination Weddings</a></li>
											<li><a href="#">Planning &amp; Advice</a></li>
											<li><a href="#">Colors &amp; Themes</a></li>
											<li><a href="#">Invitations &amp; Stationery</a></li>
											<li><a href="#">Photography &amp; Videography</a></li>
											<li><a href="#">Fashion &amp; Accessories</a></li>
											<li><a href="#">Floral &amp; Decoration</a></li>
											<li><a href="#">Cakes &amp; Dessert</a></li>
											<li><a href="#">Catering &amp; Recipes</a></li>
											<li><a href="#">Music &amp; Entertainment</a></li>
											<li><a href="#">Rentals &amp; Event Design</a></li>
											<li><a href="#">Venues &amp; Reception Sites</a></li>
										</ul>

										<a href="#" class="nice-button">View All</a>
									</div>
								</div>

								<div class="submenu_recent">
									<div class="sub_container">
										<?php
											// get most recent weddings post 

											$most_recent = get_most_recent_post_from_category('weddings', 4);
											if($most_recent->have_posts()) : 
											$counter = 0;
											while($most_recent->have_posts()) : 
												$most_recent->the_post();
												foreach(get_the_category() as $category) { $post_cat =  $category->name; $post_cat_slug = $category->slug; break;}
										?>
											<div class="recent_post_grid_block">
												<div class="<?php echo $post_cat_slug;?> <?php echo $counter == 3 ? "last" : ""; ?> ">
													<span class="nice-button dept"><?php echo $post_cat; ?></span>
													<div class="post-image">
														<?php the_post_thumbnail("medium"); ?>
													</div>
													<div class="content">
														<h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
													</div>
													<p class="post-meta">Posted <span class="date"><?php the_date("F j, Y"); ?></span> by <span class="author"><?php the_author(); ?></span></p>
												</div>
											</div>
										<?php
												break;
												endwhile;
											endif;
										?>
									</div>
								</div>

								<div class="submenu_features">
									<div class="sub_container">
										<h2>Features</h2>
										<ul>
											<?php
												if($most_recent->have_posts()) : 
												while($most_recent->have_posts()) : 
													$most_recent->the_post();
													foreach(get_the_category() as $category) { $post_cat =  $category->name; $post_cat_slug = $category->slug; break;}
											?>
												<li class="features_block">
													<div class="post-image">
														<?php the_post_thumbnail("thumbnail"); ?>
													</div>
													<div class="post-content">
														<span><?php echo $post_cat; ?></span>
														<h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
													</div>
												</li>
											<?php
													endwhile;
												endif;
											?>
										</ul>
									</div>
								</div>

							</div>
						</li>
					</ul>
				</div><!-- /.navbar-collapse -->
			</nav>
		</div>

		<?php
			if( is_front_page() )
			{
				include get_template_directory() . "/inc/index_featured_carousel.php";
			}
		?>

		<div id="main-container" class="container">
		
		
		
			
			
