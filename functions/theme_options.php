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
