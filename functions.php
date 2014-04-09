<?php 

//Add thumbnail support
add_theme_support( 'post-thumbnails' );

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
		if($paged > 1 && $morepages < $pages) echo '<a class="prev-link" href="'.get_pagenum_link($paged - 1).'">Previous</a>';
		if($paged > 2 && $paged > $range+1 && $morepages < $pages) echo '<a href="'.get_pagenum_link(1).'">1</a><span class="separate">...</span>';
		for ($i=1; $i <= $pages; $i++) {
			if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $morepages )) {
				echo ($paged == $i)? '<span class="current">'.$i.'</span>':'<a href="'.get_pagenum_link($i).'">'.$i.'</a>';
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



?>