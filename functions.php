<?php 


/****************************************************************
 * DO NOT DELETE
 ****************************************************************/
if ( STYLESHEETPATH == TEMPLATEPATH ) {
	define('OOTHEME_PATH', TEMPLATEPATH . '/');
	define('OOTHEME_URL', get_bloginfo('template_directory') . '/');
} else {
	
	define('OOTHEME_PATH', STYLESHEETPATH . '/');
	define('OOTHEME_URL', get_bloginfo('stylesheet_directory') . '/');
}

require_once OOTHEME_PATH . '/init.php';
function SearchFilter($query) {
  if ($query->is_search && !is_admin()) {
    if (isset($query->query["post_type"])) {
      $query->set('post_type', $query->query["post_type"]);
    } else {
      $query->set('post_type', 'product');
    }
  }
  return $query;
}
add_filter('pre_get_posts','SearchFilter');

//Add thumbnail support
add_theme_support( 'post-thumbnails' );

if ( ! isset( $content_width ) )
    $content_width = 670;


//Add menu support and register main menu
if ( function_exists( 'register_nav_menus' ) ) {
  	register_nav_menus(
  		array(
  		  'main_menu' => 'Main Menu'
  		)
  	);
}


// Limit results on category page before pagination
function limit_posts_per_archive_page() {
	if ( is_category() )
		set_query_var('posts_per_archive_page', 16); // or use variable key: posts_per_page
}
add_filter('pre_get_posts', 'limit_posts_per_archive_page');


// filter the Gravity Forms button type
add_filter("gform_submit_button", "form_submit_button", 10, 2);
function form_submit_button($button, $form){
    return "<button class='button btn' id='gform_submit_button_{$form["id"]}'><span>Submit</span></button>";
}

if ( function_exists('register_sidebar') )
    register_sidebar(array(
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4>',
        'after_title' => '</h4>',
     ));



add_action( 'after_setup_theme', 'bootstrap_setup' );
 
if ( ! function_exists( 'bootstrap_setup' ) ):
 
	function bootstrap_setup(){
 
		add_action( 'init', 'register_menu' );
			
		function register_menu(){
			register_nav_menu( 'top-bar', 'Bootstrap Top Menu' ); 
		}
 
		class Bootstrap_Walker_Nav_Menu extends Walker_Nav_Menu {
 
			
			function start_lvl( &$output, $depth ) {
 
				$indent = str_repeat( "\t", $depth );
				$output	   .= "\n$indent<ul class=\"dropdown-menu\">\n";
				
			}
 
			function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
				
				$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
 
				$li_attributes = '';
				$class_names = $value = '';
 
				$classes = empty( $item->classes ) ? array() : (array) $item->classes;
				$classes[] = ($args->has_children) ? 'dropdown' : '';
				$classes[] = ($item->current || $item->current_item_ancestor) ? 'active' : '';
				$classes[] = 'menu-item-' . $item->ID;
 
 
				$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
				$class_names = ' class="' . esc_attr( $class_names ) . '"';
 
				$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
				$id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';
 
				$output .= $indent . '<li' . $id . $value . $class_names . $li_attributes . '>';
 
				$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
				$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
				$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
				$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
				$attributes .= ($args->has_children) 	    ? ' class="dropdown-toggle" data-toggle="dropdown"' : '';
 
				$item_output = $args->before;
				$item_output .= '<a'. $attributes .'>';
				$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
				$item_output .= ($args->has_children) ? ' <b class="caret"></b></a>' : '</a>';
				$item_output .= $args->after;
 
				$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
			}
 
			function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {
				
				if ( !$element )
					return;
				
				$id_field = $this->db_fields['id'];
 
				//display this element
				if ( is_array( $args[0] ) ) 
					$args[0]['has_children'] = ! empty( $children_elements[$element->$id_field] );
				else if ( is_object( $args[0] ) ) 
					$args[0]->has_children = ! empty( $children_elements[$element->$id_field] ); 
				$cb_args = array_merge( array(&$output, $element, $depth), $args);
				call_user_func_array(array(&$this, 'start_el'), $cb_args);
 
				$id = $element->$id_field;
 
				// descend only when the depth is right and there are childrens for this element
				if ( ($max_depth == 0 || $max_depth > $depth+1 ) && isset( $children_elements[$id]) ) {
 
					foreach( $children_elements[ $id ] as $child ){
 
						if ( !isset($newlevel) ) {
							$newlevel = true;
							//start the child delimiter
							$cb_args = array_merge( array(&$output, $depth), $args);
							call_user_func_array(array(&$this, 'start_lvl'), $cb_args);
						}
						$this->display_element( $child, $children_elements, $max_depth, $depth + 1, $args, $output );
					}
						unset( $children_elements[ $id ] );
				}
 
				if ( isset($newlevel) && $newlevel ){
					//end the child delimiter
					$cb_args = array_merge( array(&$output, $depth), $args);
					call_user_func_array(array(&$this, 'end_lvl'), $cb_args);
				}
 
				//end this element
				$cb_args = array_merge( array(&$output, $element, $depth), $args);
				call_user_func_array(array(&$this, 'end_el'), $cb_args);
				
			}
			
		}
 
	}
 
endif;




/* ---------------------------------------------------------------------- */
/*	Theme scripts
/* ---------------------------------------------------------------------- */

if ( ! function_exists( 'load_external_jQuery' ) ) {

	function load_external_jQuery() { // load external file  
	    wp_deregister_script( 'jquery' ); // deregisters the default WordPress jQuery  
	    wp_register_script('jquery', ("http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"), false);
	    wp_enqueue_script('jquery');

	    wp_register_script('jcarousel', get_template_directory_uri() . '/js/jquery.jcarousel.min.js', array('jquery') );
	    wp_enqueue_script('jcarousel');

	    wp_register_script('bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery') );
	    wp_enqueue_script('bootstrap');

		wp_register_script('skdslider', get_template_directory_uri() . '/js/skdslider.min.js', array('jquery') );
	    wp_enqueue_script('skdslider');

	    wp_register_script('custom', get_template_directory_uri() . '/js/scripts.js', array('jquery') );
	    wp_enqueue_script('custom');

		wp_enqueue_script('tiled-gallery', plugins_url() .  '/jetpack/modules/tiled-gallery/tiled-gallery/tiled-gallery.js', array( 'jquery' ) );
		wp_enqueue_style('tiled-gallery', plugins_url() . '/jetpack/modules/tiled-gallery/tiled-gallery/tiled-gallery.css', array(), '2012-09-21' );

		wp_register_script( 'pnotify', get_template_directory_uri() . '/js/jquery.pnotify.min.js', array( 'jquery' ) );
		wp_enqueue_script( 'pnotify' );
	}  

	add_action('wp_enqueue_scripts', 'load_external_jQuery');
}

if ( ! function_exists( 'get_cover_stories' ) ) {

	function get_cover_stories($limit = 1) {

		// Exclude categories
		$inc_cats = array();
		foreach(array("weddings","parties-and-celebrations","entertaining-and-holidays") as $cat) {
			$cat = get_category_by_slug($cat);
			$taxonomy = 'category';
			$inc_cats = array_merge($inc_cats, get_term_children( $cat->cat_ID, $taxonomy ));
		}

		$exc_cats = array();
		foreach(array("atlanta","savannah","south florida","jacksonville","tampa","orlando") as $cat) {
			$cat = get_category_by_slug($cat);
			$taxonomy = 'category';
			$exc_cats = array_merge($exc_cats, get_term_children( $cat->cat_ID, $taxonomy ));
		}

		// Get the latest featured posts
		$args=array(
		  'post_status' => 'publish',
		  'posts_per_page' => $limit,
		  'caller_get_posts'=> 1,
		  'meta_key'         => 'cover_story',
		  'meta_value'       => '1',
		  'category__in' => $inc_cats,
		  'category__not_in' => $exc_cats,
		  'orderby' => 'date',
		  'order' => 'DESC'
		);
		return new WP_Query( $args );
	}
}

if ( ! function_exists( 'get_most_recent_post_from_category' ) ) {

	function get_most_recent_post_from_category($cat, $limit = 1) {

		// Get the latest featured posts
		$cat = get_category_by_slug($cat);
		$taxonomy = 'category';
		$cata_children = get_term_children( $cat->cat_ID, $taxonomy );

		$args=array(
		  'category__in' => $cata_children,
		  'post_status' => 'publish',
		  'posts_per_page' => $limit,
		  'caller_get_posts'=> 1,
		  'orderby' => 'date',
		  'order' => 'DESC'
		);
		return new WP_Query( $args );
	}
}

/* get recent featured posts */

if ( ! function_exists( 'get_most_recent_featured_post_from_category' ) ) {

	function get_most_recent_featured_post_from_category($cat, $limit = 1) {

		// Get the latest featured posts
		$cat = get_category_by_slug($cat);
		$taxonomy = 'category';
		$cata_children = get_term_children( $cat->cat_ID, $taxonomy );

		$args=array(
		  'category__in' => $cata_children,
		  'post_status' => 'publish',
		  'posts_per_page' => $limit,
		  'meta_key'         => 'featured_story',
		  'meta_value'       => '1',
		  'caller_get_posts'=> 1,
		  'orderby' => 'date',
		  'order' => 'DESC'
		);
		return new WP_Query( $args );
	}
}

/* sort recent posts */

if ( ! function_exists("sort_recent_posts") ) {
	function sort_recent_posts($a, $b) {
	    if ($a == $b) {
	        return 0;
	    }
	    return ($a < $b) ? 1 : -1;
	}
}


/* get subcategories */

if ( ! function_exists( 'get_subcategories' ) ) {

	function get_subcategories($cat) {

		// Get the latest featured posts
		$cat = get_category_by_slug($cat);
		$categories = get_categories('child_of=' . $cat->cat_ID . '&hide_empty=0');

		return $categories;
	}

}

// add div.image and pinterest button
function wrap_image_credits ($content = null)
{
    if (!$content) {
        $content = get_the_content();
    }

	preg_match_all("/(<img[^>]+>)/sim", $content, $matches);

	$imgs=$matches[1];

	foreach($imgs as $k=>$img)
	{
		preg_match('~(src="([^"]+)")~simU', $img, $src);
		$img_md5 = md5($src[2]);
		$replace = '<div class="image '.$class[2].'" id="'.$img_md5.'"><img';
		$pinit = "javascript:void(showPinterest('".$img_md5."'))";
		$bottom_info = '<a href="'.$pinit.'" class="pinit"></a>';
		$after = '>'.$bottom_info.'</div>';
		$res=str_replace(array('>','<img'),array($after,$replace),$img);

		$content=str_replace($img,$res,$content);
	}

	return $content;
}


// Pagination

function pagination($pages = '', $range = 2) {
	$morepages = ($range * 2)+1;
	global $paged;
	if(empty($paged)) $paged = 1;
	if($pages == '') {
		global $wp_query;
		$pages = $wp_query->max_num_pages;
		if(!$pages) {
			$pages = 1;
		}
	}
	if(1 != $pages) {
		echo '<div class="pagination">';
		if($paged > 1 && $morepages < $pages) echo '<a class="prev-link" href="'.get_pagenum_link($paged - 1).'">Prev</a>';
		if($paged > 2 && $paged > $range+1 && $morepages < $pages) echo '<a href="'.get_pagenum_link(1).'">1</a><span class="separate">...</span>';
		for ($i=1; $i <= $pages; $i++) {
			if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $morepages )) {
				echo ($paged == $i)? '<span class="current">'.$i.'</span>':'<a class="pg" href="'.get_pagenum_link($i).'">'.$i.'</a>';
			}
		}
		if ($paged < $pages-1 && $paged+$range-1 < $pages && $morepages < $pages) echo '<span class="separate">...</span><a class="last-link" href="'.get_pagenum_link($pages).'">'.$pages.'</a>';
		if ($paged < $pages && $morepages < $pages) echo '<a class="next-link" href="'.get_pagenum_link($paged + 1).'">Next</a>';
		echo '</div>';
	}
}


function custom_pagination($pages = '', $range = 2, $query) {
	$morepages = ($range * 2)+1;
	global $paged;
	if(empty($paged)) $paged = 1;
	if($pages == '') {
		$pages = $query->max_num_pages;
		if(!$pages) {
			$pages = 1;
		}
	}
	if(1 != $pages) {
		echo '<div class="pagination">';
		if($paged > 1 && $morepages < $pages) echo '<a class="prev-link" href="'.get_pagenum_link($paged - 1).'">Prev</a>';
		if($paged > 2 && $paged > $range+1 && $morepages < $pages) echo '<a href="'.get_pagenum_link(1).'">1</a><span class="separate">...</span>';
		for ($i=1; $i <= $pages; $i++) {
			if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $morepages )) {
				echo ($paged == $i)? '<span class="current">'.$i.'</span>':'<a class="pg" href="'.get_pagenum_link($i).'">'.$i.'</a>';
			}
		}
		if ($paged < $pages-1 && $paged+$range-1 < $pages && $morepages < $pages) echo '<span class="separate">...</span><a class="last-link" href="'.get_pagenum_link($pages).'">'.$pages.'</a>';
		if ($paged < $pages && $morepages < $pages) echo '<a class="next-link" href="'.get_pagenum_link($paged + 1).'">Next</a>';
		echo '</div>';
	}
}

// Pagination

function truncate_string($string, $length = 50) {
	
	if (strlen($string) < $length) {
		return $string;
	}

	$position = strpos($string, ' ', $length);
	if ($position !== false) {
	  return substr($string, 0, $position) . "&hellip;";
	} else {
	  return $string;
	}

}

// Get first image in a post from its content

function catch_that_image() {
	global $post, $posts;
	$first_img = '';
	ob_start();
	ob_end_clean();
	$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
	$first_img = $matches[1][0];

	if(empty($first_img)) {
		$first_img = "/path/to/default.png";
	}
	return $first_img;
}

/* sort recent posts */

if ( ! function_exists("get_prev_next_post_links") ) {
	function get_prev_next_post_links() {
		global $wp_query;
	    $prevpost = get_previous_post(true);
		$nextpost = get_next_post(true);
		$prevpost = empty($prevpost) ? null : $prevpost;
		$nextpost = empty($nextpost) ? null : $nextpost;
		$both = ($prevpost && $nextpost) ? 'both' : '';

		echo '<div class="prev_next_links">';
		if($prevpost)
			echo '	<a href="' . get_permalink($prevpost->ID) . '">
						<div class="prev-post">
							<h2>Previous Article</h2>
							<span>' . $prevpost->post_title . '</span>
						</div>
					</a>
				';
		if($nextpost)
			echo '  <a href="' . get_permalink($nextpost->ID) . '">
						<div class="next-post ' . $both . '">
							<h2>Next Article</h2>
							<span>' . $nextpost->post_title . '</span>
						</div>
					</a>
				';
		echo '</div>';

		// return array('previous' => empty($prevpost) ? null : $prevpost, 'next' => empty($nextpost) ? null : $nextpost );

	}
}

if ( ! function_exists("get_prev_next_venue_links") ) {
	function get_prev_next_venue_links() {
		global $wp_query;
			
		$prev = be_previous_post_link('<li class="prev">%link</li>', 'Prev Vendor', true, '', array('region', 'venue-type'), false);
		$next = be_next_post_link('<li class="next">%link</li>', 'Next Vendor', true, '', array('region', 'venue-type'), false);


		echo '<div class="prev_next_links">';
		if($prev)
			echo '	<a href="' . $prev["link"] . '">
						<div class="prev-post">
							<h2>Previous Company</h2>
							<span>' . $prev["title"] . '</span>
						</div>
					</a>
				';
		if($next)
			echo '  <a href="' . $next["link"] . '">
						<div class="next-post ' . $both . '">
							<h2>Next Company</h2>
							<span>' . $next["title"] . '</span>
						</div>
					</a>
				';
		echo '</div>';

		// return array('previous' => empty($prevpost) ? null : $prevpost, 'next' => empty($nextpost) ? null : $nextpost );

	}
}


if ( ! function_exists("get_nice_image") ) {
	function get_nice_image($size) {
		if(get_the_post_thumbnail() != '') {
			the_post_thumbnail($size);
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
	}
}


/*****************************
	CUSTOM REWRITE RULES     *
******************************/


function oo_add_rewrite_rules() {
	global $wp_rewrite;
	$new_rules = array(
		/* vendors */
		'vendors/([\w\d\-]+)/?$' => 'index.php?pagename=vendors-in-city&tag=' . $wp_rewrite->preg_index(1),
		'(florida|georgia)/([\w\d\-]+)-weddings/([\w\d\-]+)/?$' => 'index.php?post_type=venue&region=' . $wp_rewrite->preg_index(2) . '&service=' . $wp_rewrite->preg_index(3),
		'(florida|georgia)/([\w\d\-]+)-weddings/([\w\d\-]+)/page/([0-9]{1,})/?$' => 'index.php?post_type=venue&region=' . $wp_rewrite->preg_index(2) . '&service=' . $wp_rewrite->preg_index(3) . '&paged=' . $wp_rewrite->preg_index(4),

		'(florida|georgia)/events/?$'					   							=> 'index.php?post_type=event'. '&region=' . $wp_rewrite->preg_index(1) . '&norewrite=1',
		'(florida|georgia)/events/page/([0-9]{1,})/?$' 								=> 'index.php?post_type=event&paged=' . $wp_rewrite->preg_index(2) . '&region=' . $wp_rewrite->preg_index(1) . '&norewrite=1', // . '&type=' . $wp_rewrite->preg_index(3),
		
		'(florida|georgia)/([\w\d\-]+)/events/?$'					   				=> 'index.php?post_type=event' . '&region=' . $wp_rewrite->preg_index(2) . '&norewrite=1',
		'(florida|georgia)/([\w\d\-]+)/events/page/([0-9]{1,})/?$' 					=> 'index.php?post_type=event&paged=' . $wp_rewrite->preg_index(3) . '&region=' . $wp_rewrite->preg_index(2) . '&norewrite=1', // . '&type=' . $wp_rewrite->preg_index(3),

	);

	$wp_rewrite->rules = $new_rules + $wp_rewrite->rules;
	
}
add_action( 'generate_rewrite_rules', 'oo_add_rewrite_rules' );




/**
 * Comment callback function 
 * @param object $comment
 * @param array $args
 * @param int $depth 
 */
function oo_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class(); ?> data-comment-id="<?php echo $comment->comment_ID?>">
		<div id="comment-<?php comment_ID(); ?>" class="comment-container">
			<header class="comment-author vcard cf">
				<?php echo get_avatar($comment, 40) ? get_avatar($comment, 40) : '<img alt="" src="' . get_template_directory_uri() .'/images/default_comment_avatar.png" class="avatar avatar-40 photo" height="40" width="40">'; ?>
				<?php printf(__('<cite class="fn">%s</cite>', 'flotheme'), get_comment_author_link()); ?>
				<time datetime="<?php echo comment_date('Y-m-d'); ?>"><?php printf(__('Posted on %1$s', 'flotheme'), get_comment_date(),  get_comment_time()); ?></time>
				<?php edit_comment_link(__('(Edit)', 'flotheme'), '', ''); ?>
			</header>
			<?php if ($comment->comment_approved == '0') : ?>
				<p class="waiting"><?php _e('Your comment is awaiting moderation.', 'flotheme'); ?></p>
			<?php endif; ?>
			<section class="comment-body"><?php comment_text() ?></section>
			<div class="reply">
				<?php comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth']))); ?>
			</div>
		</div>
	</li>
<?php }


?>




