<!DOCTYPE html>
<html>
	<head>
		<title><?php wp_title(); ?> <?php bloginfo( 'name' ); ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="utf8" />
		
		<link href="<?php bloginfo('template_directory'); ?>/css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link href="<?php bloginfo('stylesheet_url');?>" type="text/css" rel="stylesheet" media="screen, projection" />		
		<link href='http://fonts.googleapis.com/css?family=Antic+Didone|Raleway:400,700|Oswald:300,400' rel='stylesheet' type='text/css'>
		
		<?php
		if (oo_get_option('google_ad')) {
		?>
			<script type='text/javascript' src='http://partner.googleadservices.com/gampad/google_service.js'></script>
			<script type='text/javascript'>
				GS_googleAddAdSenseService("<?php oo_option('google_ad') ?>");
				GS_googleEnableAllServices();
			</script>
			<script type='text/javascript'>
				<?php for($i = 1; $i <= oo_get_option('sidebar_ad_count'); $i++): ?>
					GA_googleAddSlot("<?php oo_option('google_ad') ?>", "300x125_spot_<?php echo $i ?>");
				<?php endfor; ?>
				<?php if (is_front_page()) : ?>
					GA_googleAddSlot("<?php oo_option('google_ad') ?>", "660x90_spot_1");
				<?php endif; ?>
			</script>
			<script type='text/javascript'>
				GA_googleFetchAds();
			</script>
		<?php
		}
		?>

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
					<?php oo_part("social-share-list"); ?>
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
		
		<?php 
			global $recent_featured_posts;
			$recent_featured_posts = array();
		?>

		<div id="menu">
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
								<a href="<?php echo get_permalink( get_page_by_path( 'vendors' ) ) ?>" class="hv"><span class="icon"></span>Vendors</a>
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
												<?php 
													$cats = get_subcategories('entertaining-and-holidays');
													foreach($cats as $cat) {
												?>
												<li><a href="<?php echo get_category_link($cat->cat_ID); ?>"><?php echo $cat->name; ?></a></li>
												<?php } ?>
											</ul>

											<a href="#" class="nice-button">View All</a>
										</div>
									</div>

									<div class="submenu_recent">
										<div class="sub_container">
											<?php
												// get most recent entertaining and holidays post 

												$most_recent = get_most_recent_featured_post_from_category('entertaining-and-holidays', 4);
												$recent_featured_posts = array_merge(array_slice($most_recent->posts,0,2), $recent_featured_posts);
												if($most_recent->have_posts()) : 
												while($most_recent->have_posts()) : 
													$most_recent->the_post();
													foreach(get_the_category() as $category) { $post_cat =  $category->name; $post_cat_slug = $category->slug; break;}
											?>
												<div class="post_grid_block">
													<div class="<?php echo $post_cat_slug;?> <?php echo $counter == 3 ? "last" : ""; ?> ">
														<span class="nice-button dept"><?php echo $post_cat; ?></span>
														<div class="post-image">
															<?php get_nice_image('large');	?>
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
															<?php get_nice_image('medium');	?>
														</div>
														<div class="post-content">
															<span><?php echo $post_cat; ?></span>
															<a href="<?php the_permalink(); ?>"><h1><?php the_title(); ?></h1></a>
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
												<?php 
													$cats = get_subcategories('parties-and-celebrations');
													foreach($cats as $cat) {
												?>
												<li><a href="<?php echo get_category_link($cat->cat_ID); ?>"><?php echo $cat->name; ?></a></li>
												<?php } ?>
											</ul>

											<a href="#" class="nice-button">View All</a>
										</div>
									</div>

									<div class="submenu_recent">
										<div class="sub_container">
											<?php
												// get most recent parties and celebrations post 

												$most_recent = get_most_recent_featured_post_from_category('parties-and-celebrations', 4);
												$recent_featured_posts = array_merge(array_slice($most_recent->posts,0,2), $recent_featured_posts);
												if($most_recent->have_posts()) : 
												while($most_recent->have_posts()) : 
													$most_recent->the_post();
													foreach(get_the_category() as $category) { $post_cat =  $category->name; $post_cat_slug = $category->slug; break;}
											?>
												<div class="post_grid_block">
													<div class="<?php echo $post_cat_slug;?> <?php echo $counter == 3 ? "last" : ""; ?> ">
														<span class="nice-button dept"><?php echo $post_cat; ?></span>
														<div class="post-image">
															<?php get_nice_image('large');	?>
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
															<?php get_nice_image('medium');	?>
														</div>
														<div class="post-content">
															<span><?php echo $post_cat; ?></span>
															<a href="<?php the_permalink(); ?>"><h1><?php the_title(); ?></h1></a>
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
												<?php 
													$cats = get_subcategories('weddings');
													foreach($cats as $cat) {
												?>
												<li><a href="<?php echo get_category_link($cat->cat_ID); ?>"><?php echo $cat->name; ?></a></li>
												<?php } ?>
											</ul>

											<a href="#" class="nice-button">View All</a>
										</div>
									</div>

									<div class="submenu_recent">
										<div class="sub_container">
											<?php
												// get most recent weddings post 

												$most_recent = get_most_recent_featured_post_from_category('weddings', 4);
												$recent_featured_posts = array_merge(array_slice($most_recent->posts,0,2), $recent_featured_posts);
												if($most_recent->have_posts()) : 
												$counter = 0;
												while($most_recent->have_posts()) : 
													$most_recent->the_post();
													foreach(get_the_category() as $category) { $post_cat =  $category->name; $post_cat_slug = $category->slug; break;}
											?>
												<div class="post_grid_block">
													<div class="<?php echo $post_cat_slug;?> <?php echo $counter == 3 ? "last" : ""; ?> ">
														<span class="nice-button dept"><?php echo $post_cat; ?></span>
														<div class="post-image">
															<?php get_nice_image('large');	?>
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
															<?php get_nice_image('medium');	?>
														</div>
														<div class="post-content">
															<span><?php echo $post_cat; ?></span>
															<a href="<?php the_permalink(); ?>"><h1><?php the_title(); ?></h1></a>
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

			<div id="nav-shadow"></div>
		</div>

		<?php
			if( is_front_page() )
			{
				oo_part("index_featured_carousel");
			}
		?>

		<div id="main-container" class="container">
		
		
		
			
			
