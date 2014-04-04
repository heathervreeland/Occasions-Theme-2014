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
              <a href="#" class="hv"><span></span>Vendors</a>
              <div class="preview-window">
                <div class="menu-arrow"></div>
                <?php include get_template_directory() . "/inc/submenu_categories.php"; ?>
              </div>
            </li>
            <li class="main-nav dept cities">
              <a href="#" class="hv"><span></span>Cities</a>
              <div class="preview-window">
                <div class="menu-arrow"></div>
                <?php include get_template_directory() . "/inc/submenu_categories.php"; ?>
              </div>
            </li>
            <li class="main-nav dept galleries">
              <a href="#" class="hv"><span></span>Galleries</a>
              <div class="preview-window">
                <div class="menu-arrow"></div>
                <?php include get_template_directory() . "/inc/submenu_categories.php"; ?>
              </div>
            </li>
            <li class="main-nav dept entertaining">
              <a href="#" class="hv"><span></span>Entertaining</a>
              <div class="preview-window">
                <div class="menu-arrow"></div>
                <?php include get_template_directory() . "/inc/submenu_categories.php"; ?>
              </div>
            </li>
            <li class="main-nav dept parties">
              <a href="#" class="hv"><span></span>Parties</a>
              <div class="preview-window">
                <div class="menu-arrow"></div>
                <?php include get_template_directory() . "/inc/submenu_categories.php"; ?>
              </div>
            </li>
            <li class="main-nav dept weddings">
              <a href="#" class="hv"><span></span>Weddings</a>
              <div class="preview-window">
                <div class="menu-arrow"></div>
                <?php include get_template_directory() . "/inc/submenu_categories.php"; ?>
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
    
    
    
    	
    	
