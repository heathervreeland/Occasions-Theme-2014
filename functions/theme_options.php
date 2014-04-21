<?php 
function get_state_from_region( $region ) {

    // test if this is a parent ( aka a state )
    if ($region->parent) {

        // if it is a state, then set the $state variable to the parent taxonomy
        $state = get_term($region->parent, 'region');

    } else {

        // otherwise we assume that we are in a city

        // set the $state object to the $region object
        $state = $region;

        // set the $region object to false
        $region = false;

    }

    // testing to make sure there are not overlaps between city names across states ????? this is a guess
    if (!$region && !$state) {

        $region = get_term_by('slug', get_query_var('_region'), 'region');

        $state = $region;

    }

    return $state;

}


function oo_venue_rating($id = null) {
    if (null === $id) {
        $id = get_the_ID();
    }
    echo oo_get_venue_rating($id);
}

function oo_get_venue_rating($id = null) {
    global $wpdb;

    if (null === $id) {
        $id = get_the_ID();
    }

    $sql = 'SELECT ROUND(AVG(meta.meta_value)) FROM ' . $wpdb->comments . ' comments '
                    . ' INNER JOIN ' . $wpdb->commentmeta . ' meta ON comments.comment_ID = meta.comment_id '
                    . ' WHERE comment_post_ID=%d AND comment_approved=%d AND meta.meta_key = %s GROUP BY meta.meta_key';

    return $wpdb->get_var($wpdb->prepare($sql, $id, 1, 'rating'));

}


function get_events_for_region($region, $limit = 5) {

    return new WP_Query(array(
        'posts_per_page'    => $limit,
        'post_type'         => 'event',
        'tax_query'         => array(
            array(
                'taxonomy'  => 'region',
                'field'     => 'slug',
                'terms'     => $region->slug,
            ),
        ),
        'ignore_filter_changes' => true,
        'norewrite'         => true,
    ));

}


/********************
*
* EVENT STUFF
*
*********************/


function oo_get_event_date($type = 'start', $format = 'F d, Y', $id = null) {
    if (null === $id) {
        $id = get_the_ID();
    }
    $date = oo_get_meta($type . '_date', true, $id);

    return date($format, strtotime($date));
}

/*********************
* 
* VENDOR PROFILE STUFF
*
**********************/


function oo_vendor_profile_view($vid=0) {
    global $wpdb;

    if ($vid == 0) $vid = get_the_ID();

    $ip = oo_get_real_ip();
    $ua = getenv("HTTP_USER_AGENT");
    $ua = htmlspecialchars($ua);
    $tblname = $wpdb->prefix . "logs";

    $sql = "INSERT INTO $tblname VALUES(NULL, NULL, %s, %d, %s, %s)";

    $result = $wpdb->query($wpdb->prepare($sql, '$ip', $vid, 'view', '$ua'));

    return $result;
}

function oo_get_real_ip() {
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
      $ip=$_SERVER['REMOTE_ADDR'];
    }

    return $ip;
}


function oo_get_venue_city($id = null) {
    if (null === $id) {
        $id = get_the_ID();
    }
    $regions = wp_get_post_terms($id, 'region');

    $city = null;

    foreach ($regions as $region) {
        if ($region->parent) {
            $city = $region;
            break;
        }
    }
    return $city;
}

function oo_get_venue_state($id = null) {
    if (null === $id) {
        $id = get_the_ID();
    }
    $regions = wp_get_post_terms($id, 'region');

    $state = null;

    foreach ($regions as $region) {
        if (!$region->parent) {
            $state = $region;
            break;
        }
    }
    return $state;
}

function oo_get_venue_service($id = null) {
    if (null === $id) {
        $id = get_the_ID();
    }
    $services = wp_get_post_terms($id, 'service');

    if (count($services)) {
        return $services[0];
    } else {
        return null;
    }
}


/**
 * Get all attached images. Filter by hide_form_gallery meta key
 * @param integer $id
 * @param boolean $show_hidden
 * @return array
 */
function oo_get_attached_images($id = null, $show_hidden = true) {
    if (!$id) {
        $id = get_the_ID();
    }
    
    $attrs = array(
        'post_parent' => $id,
        'post_status' => null,
        'post_type' => 'attachment',
        'post_mime_type' => 'image',
        'order' => 'ASC',
        'numberposts' => -1,
        'orderby' => 'menu_order',
    );
    
    if (!$show_hidden) {
        $attrs['meta_query'] = array(
            array(
                'key'       => '_flo_hide_from_gallery',
                'value'     => 0,
                'type'      => 'DECIMAL',
            ),
        );
    }
    
    return get_children($attrs);
}

function oo_get_vendor_attached_files($id = null) {
    if (!$id) {
        $id = get_the_ID();
    }

    $attrs = array(
        'post_parent' => $id,
        'post_status' => null,
        'post_type' => 'attachment',
        'order' => 'ASC',
        'numberposts' => -1,
        'orderby' => 'menu_order',
    );

    $downloads = get_children($attrs);

    foreach ($downloads as $key => $file) {
        if (in_array($file->post_mime_type, array('image/jpeg'))) {
            unset($downloads[$key]);
        }
    }

    return $downloads;
}


function oo_travel_policies() {
    return array(
        array(
            'name' => 'none',
            'value' => '<none>',
        ),
        array(
            'name' => 'Locally',
            'value' => 'Locally',
        ),
        array(
            'name' => 'State Wide',
            'value' => 'State Wide',
        ),
        array(
            'name' => 'Regionally',
            'value' => 'Regionally',
        ),
        array(
            'name' => 'Nationally',
            'value' => 'Nationally',
        ),
        array(
            'name' => 'Internationally',
            'value' => 'Internationally',
        ),
    );
}


function oo_phone_types() {
    return array(
        array(
            'name'  => '',
            'value' => '',
        ),
        array(
            'name'  => 'Mobile',
            'value' => 'Mobile',
        ),
        array(
            'name'  => 'Toll-Free',
            'value' => 'Toll-Free',
        ),
        array(
            'name'  => 'Work',
            'value' => 'Work',
        ),
        array(
            'name'  => 'Work FAX',
            'value' => 'Work FAX',
        ),
        array(
            'name'  => 'Home',
            'value' => 'Home',
        ),
        array(
            'name'  => 'Home FAX',
            'value' => 'Home FAX',
        ),
        array(
            'name'  => 'Sales',
            'value' => 'Sales',
        ),
        array(
            'name'  => 'Management',
            'value' => 'Management',
        ),
    );
}


function oo_qr_codes() {
    $vid = (int) $_REQUEST['post'];
    $oldid = get_post_meta($vid,'flo_oldid', true);

    if (is_numeric($oldid)) $vid = $oldid;

    $link = urlencode('http://maglink.us/p'.$vid);
    $mlink = urlencode('http://maglink.us/m'.$vid);

    $result = '<h4>Below is a small and large QR Code for your Occasions profile page:</h4>';
    $result .= '<img src="http://chart.apis.google.com/chart?cht=qr&chs=200x200&chl='.$link.'&chld=H|0" />';
    $result .= '<img src="http://chart.apis.google.com/chart?cht=qr&chs=500x500&chl='.$link.'&chld=H|0" />';


    $result .= '<h4>Below is a small and large QR Code for your Occasions profile page <strong>designed for mobile devices</strong>:</h4>';
    $result .= '<img src="http://chart.apis.google.com/chart?cht=qr&chs=200x200&chl='.$mlink.'&chld=H|0" />';
    $result .= '<img src="http://chart.apis.google.com/chart?cht=qr&chs=500x500&chl='.$mlink.'&chld=H|0" />';

    return $result;
}


function oo_custom_excerpt_length($length) {
    return 22;
}


function oo_accepted_payments() {
    return array(
        'Visa' => 'Visa',
        'Mastercard' => 'Mastercard',
        'Amex' => 'American Express',
        'Discover' => 'Discover',
        'Checks' => 'Checks',
        'Bank Drafts' => 'Bank Drafts',
        'Paypal' => 'Paypal',
    );
}

function oo_metabox_vendors_select() {

    $users = get_users(array(
        'role' => 'advertiser',
    ));

    $options = array();
    foreach ($users as $user) {
        $options[] = array(
            'value' => $user->ID,
            'name'  => $user->display_name,
        );
    }

    return $options;
}


/* Review functions */



function oo_additional_fields () {
    echo '<p class="comment-form-title">'.
    '<label for="title">' . __( 'Comment Title' ) . '</label>'.
    '<input id="title" name="title" type="text" size="30"  tabindex="5" /></p>';

    echo '<p class="comment-form-rating">'.
    '<label for="rating">'. __('Rating') . '<span class="required">*</span></label>
    <span class="commentratingbox">';

        //Current rating scale is 1 to 5. If you want the scale to be 1 to 10, then set the value of $i to 10.
        for( $i=1; $i <= 5; $i++ )
        echo '<span class="commentrating"><input type="radio" name="rating" id="rating" value="'. $i .'"/>'. $i .'</span>';

    echo'</span></p>';

}




// Save the review rating
add_action( 'comment_post', 'oo_save_review_meta_data' );
function oo_save_review_meta_data($comment_id) {
    if (isset( $_POST['rating']) && $_POST['rating'] != '') {
        $rating = (int) $_POST['rating'];
        if ($rating > 5 || $rating < 1) {
            $rating = 5;
        }
        add_comment_meta($comment_id, 'rating', $rating);
    }
}





// Review callback
function ootheme_review($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment; ?>

    <li <?php comment_class(); ?> data-comment-id="<?php echo $comment->comment_ID?>">
        <div id="review-<?php comment_ID(); ?>" class="comment-container">
            <header class="review-author comment-author vcard cf">
                <?php printf(__('<cite class="fn">%s</cite>', 'flotheme'), get_comment_author_link()); ?>
                <span class="stars stars<?php echo get_comment_meta($comment->comment_ID, 'rating', true) ?>"></span>
                <time datetime="<?php echo comment_date('Y-m-d'); ?>"><?php printf(__('Posted on %1$s', 'flotheme'), get_comment_date(),  get_comment_time()); ?></time>
                <?php edit_comment_link(__('(Edit)', 'flotheme'), '', ''); ?>
            </header>
            <?php if ($comment->comment_approved == '0') : ?>
                <p class="waiting"><?php _e('Your comment is awaiting moderation.', 'flotheme'); ?></p>
            <?php endif; ?>
            <section class="comment-body"><?php comment_text() ?></section>
        </div>
    </li>    
<?}


// Add an edit option to comment editing screen
add_action( 'add_meta_boxes_comment', 'oo_extend_comment_add_meta_box' );
function oo_extend_comment_add_meta_box() {
    add_meta_box( 'title', __( 'Review Ratings' ), 'oo_extend_comment_meta_box', 'comment', 'normal', 'high' );
}

function oo_extend_comment_meta_box ( $comment ) {
    $rating = get_comment_meta( $comment->comment_ID, 'rating', true );
    wp_nonce_field( 'extend_comment_update', 'extend_comment_update', false );
    ?>
    <p>
        <label for="rating"><?php _e( 'Rating: ' ); ?></label>
            <span class="commentratingbox">
            <?php for( $i=1; $i <= 5; $i++ ) {
                echo '<span class="commentrating"><input type="radio" name="rating" id="rating" value="'. $i .'"';
                if ( $rating == $i ) echo ' checked="checked"';
                echo ' />'. $i .' </span>';
                }
            ?>
            </span>
    </p>
    <?php
}

// Update comment meta data from comment editing screen
add_action( 'edit_comment', 'oo_extend_comment_edit_metafields' );
function oo_extend_comment_edit_metafields( $comment_id ) {
    if( ! isset( $_POST['extend_comment_update'] ) || ! wp_verify_nonce( $_POST['extend_comment_update'], 'extend_comment_update' ) ) return;

    if ( ( isset( $_POST['rating'] ) ) && ( $_POST['rating'] != '') ):
    $rating = wp_filter_nohtml_kses($_POST['rating']);
    update_comment_meta( $comment_id, 'rating', $rating );
    else :
    delete_comment_meta( $comment_id, 'rating');
    endif;

}

// Add the filter to check whether the comment meta data has been filled

add_filter( 'preprocess_comment', 'oo_verify_comment_meta_data' );
function oo_verify_comment_meta_data( $commentdata ) {
    global $post;
    if ( ! isset( $_POST['rating'] ) && get_post_type($post->ID) == 'venue' )
    wp_die( __( 'Error: You did not add a rating. Hit the Back button on your Web browser and resubmit your comment with a rating.' ) );
    return $commentdata;
}


