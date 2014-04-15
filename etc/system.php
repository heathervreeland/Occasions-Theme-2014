<?php
/**
 * Add Needed Post Types 
 */
function oo_init_post_types() {
	if (function_exists('ootheme_get_post_types')) {
		foreach (ootheme_get_post_types() as $type => $options) {
			oo_add_post_type($type, $options['config'], $options['singular'], $options['multiple']);
		}
	}
}
add_action('init', 'oo_init_post_types');

/**
 * Add Needed Taxonomies
 */
function oo_init_taxonomies() {

	if (function_exists('ootheme_get_taxonomies')) {
		foreach (ootheme_get_taxonomies() as $type => $options) {
			oo_add_taxonomy($type, $options['for'], $options['config'], $options['singular'], $options['multiple']);
		}
	}
}
add_action('init', 'oo_init_taxonomies');

/**
 * Initialize Theme Support Features 
 */
function oo_init_theme_support() {
	if (function_exists('ootheme_get_images_sizes')) {
		foreach (ootheme_get_images_sizes() as $post_type => $sizes) {
			foreach ($sizes as $config) {
				oo_add_image_size($post_type, $config);
			}
		}
	}
}
add_action('init', 'oo_init_theme_support');

function oo_after_setup_theme() {
	// add editor style for admin editor
	add_editor_style();

	// add post thumbnails support
	add_theme_support('post-thumbnails');
	
	// Set the theme's text domain using the unique identifier from above 
	load_theme_textdomain('ootheme', THEME_PATH . '/lang');	
	
	// add needed post formats to theme
	if (function_exists('ootheme_get_post_formats')) {
		add_theme_support('post-formats', ootheme_get_post_formats());
	}

/*
*/
  add_theme_support( 'infinite-scroll', array(
    'type'           => 'scroll',
    'footer_widgets' => false,
    'container'      => 'homepage',
    'footer'         => false,
    'wrapper'        => true,
    'render'         => false, 
    'posts_per_page' => '5' 
  ) );
}
add_action('after_setup_theme', 'oo_after_setup_theme');

function insert_oo_home_loop() {
    oo_part('post-full');
}

/**
 * Initialize Theme Navigation 
 */
function oo_init_navigation() {
	if (function_exists('register_nav_menus')) {
		register_nav_menus(array(
			// 'header_menu'	=> __('Header Menu', 'ootheme'),
			'footer_menu'	=> __('Footer Menu', 'ootheme'),
			'topbar_menu'	=> __('Top Bar Menu', 'ootheme'),
		));
	}
}
add_action('init', 'oo_init_navigation');


/**
 * Register Post Type Wrapper
 * @param string $name
 * @param array $config
 * @param string $singular
 * @param string $multiple
 */
function oo_add_post_type($name, $config, $singular = 'Entry', $multiple = 'Entries') {
	if (!isset($config['labels'])) {
		$config['labels'] = array(
			'name' => __($multiple, 'ootheme'),
			'singular_name' => __($singular, 'ootheme'),
			'not_found'=> __('No ' . $multiple . ' Found', 'ootheme'),
			'not_found_in_trash'=> __('No ' . $multiple . ' found in Trash', 'ootheme'),
			'edit_item' => __('Edit ', $singular, 'ootheme'),
			'search_items' => __('Search ' . $multiple, 'ootheme'),
			'view_item' => __('View ', $singular, 'ootheme'),
			'new_item' => __('New ' . $singular, 'ootheme'),
			'add_new' => __('Add New', 'ootheme'),
			'add_new_item' => __('Add New ' . $singular, 'ootheme'),
		);
	}

	register_post_type($name, $config);
}

/**
 * Add custom image size wrapper
 * @param string $post_type
 * @param array $config 
 */
function oo_add_image_size($post_type, $config) {
	add_image_size($config['name'], $config['width'], $config['height'], $config['crop']);
}

/**
 * Register taxonomy wrapper
 * @param string $name
 * @param mixed $object_type
 * @param array $config
 * @param string $singular
 * @param string $multiple
 */
function oo_add_taxonomy($name, $object_type, $config, $singular = 'Entry', $multiple = 'Entries') {
	
	if (!isset($config['labels'])) {
		$config['labels'] = array(
			'name' => __($multiple, 'ootheme'),
			'singular_name' => __($singular, 'ootheme'),
			'search_items' =>  __('Search ' . $multiple),
			'all_items' => __('All ' . $multiple),
			'parent_item' => __('Parent ' . $singular),
			'parent_item_colon' => __('Parent ' . $singular . ':'),
			'edit_item' => __('Edit ' . $singular), 
			'update_item' => __('Update ' . $singular),
			'add_new_item' => __('Add New ' . $singular),
			'new_item_name' => __('New ' . $singular . ' Name'),
			'menu_name' => __($multiple),
		);
	}
	register_taxonomy($name, $object_type, $config);
}

/**
 * Add specific image sizes for custom post types.
 * @global object $post 
 */
function oo_alter_image(){
	global $post;
	
	switch ($post->post_type) {
		case 'press':

			break;
		case 'gallery':

			break;
		default: break;
	}
}
add_action('edit','oo_alter_image');


/**
 * Remove unused image sizes for custom post types
 * 
 * @param type $available_sizes
 * @return type 
 */
function oo_init_custom_image_sizes($available_sizes) {
	if (!@$_REQUEST['post_id'] || !($_post = get_post($_REQUEST['post_id']))) {
		return $available_sizes;
	}
	
	$default_sizes = array('thumbnail', 'medium', 'large');
	$sizes = array();
	foreach ($available_sizes as $name => $data) {
		if (preg_match('~^' . $_post->post_type . '\-~si', $name) || in_array($name, $default_sizes)) {
			$sizes[$name] = $data;
		}
	}
	
	return $sizes;
}
add_action('intermediate_image_sizes_advanced', 'oo_init_custom_image_sizes');

function oo_change_toolbar() {
    global $wp_admin_bar;
	
    $wp_admin_bar->add_menu(array(
        'id' => 'ootheme',
        'title' => '<span class="ab-icon"></span>',
        'href' => admin_url('admin.php?page=ootheme'),
	));
	
	$wp_admin_bar->remove_node('wp-logo');  
}
add_action('admin_bar_menu', 'oo_change_toolbar', 40);


// move admin bar to bottom
function fb_change_toolbar_css() { 
	
	global $wp_admin_bar;
	
	if (!$wp_admin_bar) {
		return;
	}
	
	?>
	<style type="text/css">
		#wp-admin-bar-ootheme .ab-icon {
			background-image: url("<?php echo OOTHEME_URL?>/assets/images/ootheme_icon_16_light.png");
		}
	</style> <?php 
}
// on backend area
add_action( 'admin_head', 'fb_change_toolbar_css' );
// on frontend area
add_action( 'wp_head', 'fb_change_toolbar_css' );



// THIS INCLUDES THE THUMBNAIL IN OUR RSS FEED
function oo_insert_feed_image($content) {
global $post;

if ( has_post_thumbnail( $post->ID ) ){
	$content = ' ' . get_the_post_thumbnail( $post->ID, 'medium' ) . " " . $content;
}
return $content;
}

add_filter('the_excerpt_rss', 'oo_insert_feed_image');
add_filter('the_content_rss', 'oo_insert_feed_image');
