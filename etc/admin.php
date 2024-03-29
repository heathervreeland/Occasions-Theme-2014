<?php
/**
 * Add admin scripts and styles
 */
function oo_add_scripts($hook) {
	
	// Add general scripts & styles
	wp_enqueue_style('flotheme_admin_css', OOTHEME_URL . '/assets/css/admin.css', array(), FLOTHEME_THEME_VERSION);
	wp_enqueue_script('flotheme_colorpicker', OOTHEME_URL.'/assets/js/colorpicker.js', array('jquery'));
	wp_enqueue_script('flotheme_admin_js', OOTHEME_URL . '/assets/js/admin.js', array('jquery', 'flotheme_colorpicker'), FLOTHEME_THEME_VERSION);
	
	// Add scripts for metaboxes
  	if ( $hook == 'post.php' || $hook == 'post-new.php' || $hook == 'page-new.php' || $hook == 'page.php' ) {
		wp_enqueue_script( 'flotheme_metaboxes', OOTHEME_URL . '/assets/js/metaboxes.js', array( 'jquery', 'jquery-ui-core', 'jquery-ui-datepicker', 'media-upload', 'thickbox') );
		wp_enqueue_script( 'flotheme_shortcodes', OOTHEME_URL . '/assets/js/shortcodes.js', array( 'jquery', 'thickbox') );
  	}
	
	// Add scripts for Theme Options page
	if (in_array($hook, array('toplevel_page_flotheme'))) {
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('options-custom', OOTHEME_URL.'/assets/js/options-custom.js', array('jquery'));
		// Add inline scripts for Theme Options page
		if (function_exists('flotheme_options_custom_scripts')) {
			add_action('admin_head', 'flotheme_options_custom_scripts');
		}
	}
}
add_action( 'admin_enqueue_scripts', 'oo_add_scripts', 10 );

/**
 * Add Flotheme Options to Admin Navigation 
 */
function oo_add_admin_menu() {
	add_menu_page('', __('Flotheme', 'flotheme'), 'edit_theme_options', 'flotheme', false, OOTHEME_URL . '/assets/images/flotheme_icon_16.png', 3);
	add_submenu_page('flotheme', __('Theme Options', 'flotheme'), __('Theme Options', 'flotheme'), 'edit_theme_options', 'flotheme','optionsframework_page');
	
	add_submenu_page('flotheme', __('Sliders', 'flotheme'), __('Sliders', 'flotheme'), 'edit_theme_options', 'flotheme_sliders','flotheme_sliders_page');	
}
add_action('admin_menu', 'oo_add_admin_menu', 1);

/**
 * Add custom post types to navigation 
 */
function oo_admin_custom_to_navigation() {
	$post_types = get_post_types(array(
		'show_in_nav_menus' => true
	), 'object' );
	
	foreach ( $post_types as $post_type ) {
		if ( $post_type->has_archive ) {
			add_filter( 'nav_menu_items_' . $post_type->name, 'oo_admin_custom_to_navigation_checkbox', null, 3 );
		}
	}
}
add_action( 'admin_head-nav-menus.php', 'oo_admin_custom_to_navigation');

/**
 * Add custom post type to navigation
 * @global int $_nav_menu_placeholder
 * @global object $wp_rewrite
 * @param array $posts
 * @param array $args
 * @param string $post_type
 * @return array 
 */
function oo_admin_custom_to_navigation_checkbox($posts, $args, $post_type) {
	global $_nav_menu_placeholder, $wp_rewrite;
	$_nav_menu_placeholder = ( 0 > $_nav_menu_placeholder ) ? intval($_nav_menu_placeholder) - 1 : -1;

	$archive_slug = $post_type['args']->has_archive === true ? $post_type['args']->rewrite['slug'] : $post_type['args']->has_archive;
	if ( $post_type['args']->rewrite['with_front'] )
		$archive_slug = substr( $wp_rewrite->front, 1 ) . $archive_slug;
	else
		$archive_slug = $wp_rewrite->root . $archive_slug;

	array_unshift( $posts, (object) array(
		'ID' => 0,
		'object_id' => $_nav_menu_placeholder,
		'post_content' => '',
		'post_excerpt' => '',
		'post_title' => $post_type['args']->labels->all_items,
		'post_type' => 'nav_menu_item',
		'type' => 'custom',
		'url' => site_url( $archive_slug ),
	) );
	
	return $posts;
}

/**
 * Show alert message if default blog description is not changed
 * @global object $current_user 
 */
function oo_admin_notice_tagline() {
	if ((get_option('blogdescription') === 'Just another WordPress site')) {
		global $current_user;
		$user_id = $current_user->ID;

		if (!get_user_meta($user_id, 'ignore_tagline_notice')) {
		echo '<style>#blogdescription {border-color:red;}</style>';
		echo '<div class="error">';
			echo '<p><strong>', sprintf(__('Please update your <a href="%s">site tagline</a>', 'flotheme'), admin_url('options-general.php'), '?tagline_notice_ignore=0'), '</strong></p>';
		echo '</div>';
		}
	}
}
add_action('admin_notices', 'oo_admin_notice_tagline');

/**
 * Add custom columns to admin data tables 
 */
function oo_admin_table_columns() {
	if (function_exists('flotheme_get_post_types')) {
		foreach (flotheme_get_post_types() as $type => $config) {
			if (isset($config['columns']) && count($config['columns'])) {
				foreach ($config['columns'] as $column) {
					if (function_exists('oo_admin_posts_' . $column . '_column_head') && function_exists('oo_admin_posts_' . $column . '_column_content')) {
						add_filter('manage_' . $type . '_posts_columns', 'oo_admin_posts_' . $column . '_column_head', 10); 
						add_action('manage_' . $type . '_posts_custom_column', 'oo_admin_posts_' . $column . '_column_content', 10, 2);						
					}
				}
			}
		}
	}
}
add_action('admin_init', 'oo_admin_table_columns', 100);

/**
 * Change footer
 */
function oo_admin_remove_footer_admin() {
	echo '<span id="footer-thankyou">Developed by <a href="http://www.flosites.com" target="_blank">Flosites</a></span>';
}
add_filter('admin_footer_text', 'oo_admin_remove_footer_admin');

/**
 * Add custom icons for post types 
 */
function oo_post_type_icons() {
	?>
		<style type="text/css">
		<?php
		if (function_exists('flotheme_get_post_types')) {
			foreach (flotheme_get_post_types() as $type => $config) {
				?>
					#menu-posts-<?php echo $type ?> .wp-menu-image {
						background: url(<?php echo OOTHEME_URL ?>/assets/images/post_type_icons/<?php echo $type ?>.png) no-repeat 6px -17px !important;
					}
					#menu-posts-<?php echo $type ?>:hover .wp-menu-image {
						background-position: 6px 7px !important;
					}
				<?php
			}
		}
		?>
		</style>
	<?php
}
add_action( 'admin_head', 'oo_post_type_icons');

/**
 * Add featured image header column to admin data-table
 * 
 * @param array $defaults
 * @return array 
 */
function oo_admin_posts_featured_column_head($defaults) {
	array_put_to_position($defaults, 'Image', 1, 'featured-image');
	return $defaults;  
}

/**
 * Add featured image data column to admin data-table
 *
 * @param string $column_name
 * @param int $post_id 
 */
function oo_admin_posts_featured_column_content($column_name, $post_id) {
	if ($column_name == 'featured-image') {  
		$post_featured_image = oo_get_featured_image_src($post_id);  
		if ($post_featured_image) {  
			echo '<img src="' . $post_featured_image . '" alt="" width="60" />'; 
		}  
	}
}


/**
 * Add featured image header column to admin data-table
 * 
 * @param array $defaults
 * @return array 
 */
function oo_admin_posts_first_image_column_head($defaults) {  
	array_put_to_position($defaults, 'Image', 1, 'first-image');
	return $defaults;  
}

/**
 * Add featured image data column to admin data-table
 *
 * @param string $column_name
 * @param int $post_id 
 */
function oo_admin_posts_first_image_column_content($column_name, $post_id) {
	if ($column_name == 'first-image') {  
		if (has_post_thumbnail($post_id)) :
			$image = oo_get_featured_image_src($post_id);
		else :
			$image = oo_get_first_attached_image_src($post_id);
		endif;	

		if ($image) {  
			echo '<img src="' . $image . '" alt="" width="60" />'; 
		}  
	}
}




function oo_remove_dashboard_widgets() {
	global $wp_meta_boxes;

	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_plugins']);

	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['meandmymac_rss_widget']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['meandmymac_rss_widget']);
}

// Hoook into the 'wp_dashboard_setup' action to register our function
add_action('wp_dashboard_setup', 'oo_remove_dashboard_widgets' );



