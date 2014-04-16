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


