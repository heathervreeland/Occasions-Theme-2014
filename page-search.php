<?php 
/**
 * Template Name: Template About Child
 */
get_header(); ?>


<div class="row search" id="single-post-row">
  <div id="page-search">

      <?php
        add_filter('the_content','wrap_image_credits', 20);
      ?>
      <div class="page-block" id="main">

        <section class="post-container">

          <div class="post-category-floater">
            <span class="nice-button dept">Search</span>
          </div>

          <div class="post-content story ">

            <h1>Search Results</h1>

            <div class="border-line"></div>

            <section class="vendor results">
                <h2 class="results-title">Vendors</h2>
                <?php
                    //venues
                    $s = isset($_GET["q"]) ? $_GET["q"] : "";
                    $args = array(
                        'post_type' => 'venue',
                        'post_status' => 'publish',
                    );
                    //search post_meta field 'flo_description' for venues.
                    $args['meta_query'][] = array(
                        'key' => 'flo_description',
                        'value' => $s,
                        'compare' => 'LIKE',
                    );

                    $posts = new WP_Query($args);
                    $num = $posts->found_posts?$posts->found_posts:"0";
                    echo "<h3>We found ".$num." vendors matching your search.</h3>";
                    if ( $posts->have_posts() ) :
                        $j-1;
                        while ( $posts->have_posts() && $j < 5 ) : $posts->the_post();
                            $post_id = get_the_id();
                            $permalink = get_permalink($post_id);
                            if(has_post_thumbnail($post_id)) {
                                $post_thumbnail_id = get_post_thumbnail_id( $post_id );
                                $img_url = wp_get_attachment_url( $post_thumbnail_id  );
                                $thumblink = '<a href="' . $permalink . '" class="search-thumb">' . '<img src="' . $img_url . '" class="alignleft" title="' . $post->title . '"></a>';
                            }   
                            echo "<article class=\"search-item cf\">";
                            echo $thumblink;
                            echo "  <h2><a href=\"$permalink\">".$post->post_title."</a></h2>";
                            echo "  <p>";
                            echo strip_tags(substr(strip_shortcodes($post->flo_description),0,150) ) . " ... <a href=\"" . $permalink . "\">Read More &rarr;</a>";
                            echo "  </p>";
                            echo "</article>";
                            $j++;
                        endwhile;
                        echo ($j<$num)?"<a href=\"/search/page/1/?q={$s}&type=venue\" class=\"nice-button\" title=\"View more venue results\">View more venue results</a>":"";
                    else :
                        echo "<p>No Vendors were found</p>";
                        wp_reset_postdata();
                    endif;
                  ?>
            </section>

            <section class="blog-search results">
                <h2 class="results-title">Posts</h2>
                <?php
                    $s = '';
                    if ( isset($_GET["q"] ) ) {
                        $s = $_GET["q"];
                    } else {
                        echo 'sorry, no results';
                    }
                    //echo $s;
                    $args = array(
                        's' => $s,
                        'post_type' => 'post',
                        'posts_per_page' => 10
                    );
                    $posts = new WP_Query( $args );
                    //$posts = new WP_Query("s=$s&post_type=post&posts_per_page=10");

                    $num = $posts->found_posts?$posts->found_posts:"0";
                    echo "<h3>We found ".$num." articles matching your search.</h3>";
                    if ( $posts->have_posts() ) :
                        $i-1;
                        while ( $posts->have_posts() && $i < 5 ) : $posts->the_post();
                            $post_id = get_the_id();
                            $permalink = get_permalink($post_id);
                            if(has_post_thumbnail($post_id)) {
                                $post_thumbnail_id = get_post_thumbnail_id( $post_id );
                                $img_url = wp_get_attachment_url( $post_thumbnail_id  );
                                $thumblink = '<a href="' . $permalink . '" class="search-thumb">' . '<img src="' . $img_url . '" class="alignleft" title="' . $post->title . '"></a>';
                            }
                            echo "<article class=\"search-item cf\">";
                            echo $thumblink;
                            echo "  <h2><a href=\"$permalink\">".$post->post_title."</a></h2>";
                            echo "  <p>";
                            echo strip_tags(substr(strip_shortcodes($post->post_content),0,150)) . ' ... <a href="' . $permalink . '">Read More &rarr;</a>';
                            echo "  </p>";
                            echo "</article>";
                            $i++;
                        endwhile;
                        echo ($i<$num)?"<a href=\"/search/page/1/?q={$s}&type=post\" class=\"nice-button\" title=\"View more article results\">View more article results</a>":"";
                    else :
                        echo "<p>No Posts were found</p>";
                        wp_reset_postdata();              
                    endif;
                ?>
            </section>

        </section>
        
        <?php get_sidebar('blog'); ?>

      </div>

  </div>

</div>


<?php get_footer(); ?>