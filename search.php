<?php get_header(); ?>

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
                  <?php
                    $uri_array = explode( '/', $_SERVER['REQUEST_URI'] );
                    $paged = $uri_array[3] ? $uri_array[3] : 1;
                    if(!isset($_GET["type"])) { $_GET["type"] = "post"; }
                      if($_GET["type"] == "post") {
                        $s = isset($_GET["q"]) ? $_GET["q"] : "";
                        $posts = new WP_Query("s=$s&post_type=post&posts_per_page=10&paged=$paged");
                        $num = $posts->found_posts?$posts->found_posts:"0";
                        if ( $posts->have_posts() ) :
                          while ( $posts->have_posts() && $i < 5 ) : $posts->the_post();
                            $permalink = get_permalink($post->ID);
                            if(has_post_thumbnail($post->ID)) {
                              //$attr = array('alt'=>$post->post_title,'align'=>'left','style'=>'padding-right:10px;padding-bottom:10px;');
                              $attr = array('alt'=>$post->post_title);
                              $thumblink = "<a href=\"$permalink\" class=\"search-thumb\">".get_the_post_thumbnail($post->ID,'thumbnail',$attr)."</a>";
                            }
                            echo "<article class=\"search-item cf\">";
                            echo $thumblink;
                            echo " <h2><a href=\"$permalink\">".$post->post_title."</a></h2>";
                            echo "<p>";
                            echo substr(strip_shortcodes($post->post_content),0,150) . " ... <a href=\"" . $post->guid . "\">Read More &rarr;</a>";
                            echo "</p>";
                            echo '<br clear="left" />';
                            echo "</article>";
                          endwhile;
                        else :
                          echo "<p>No Posts were found</p>";
                          wp_reset_postdata();
                      endif;

                    } else if($_GET["type"] == "venue") {

                  ?>

                    <h1 style="padding-top:20px;">Vendors</h1>
                    <?php
                    //vardump(explode( '/', $_SERVER['REQUEST_URI'] ));
                    //venues
                    //$uri_array = explode( '/', $_SERVER['REQUEST_URI'] );
                    //$paged = $uri_array[3] ? $uri_array[3] : 1;
                    $s = isset($_GET["q"]) ? $_GET["q"] : "";
                    $args = array(
                        'post_type' => 'venue',
                        'post_status' => 'publish',
                        'posts_per_page' => 10,
                        'paged' => $paged,
                    );
                    //search post_meta field 'oo_description' for venues.
                    $args['meta_query'][] = array(
                        'key' => 'flo_description',
                        'value' => $s,
                        'compare' => 'LIKE',
                    );

                    $posts = new WP_Query($args);
                    $num = $posts->post_count?$posts->post_count:"0";
                    //echo "<h3>We found ".$num." vendors matching your search.</h3>";
                    if ( $posts->have_posts() ) :
                    while ( $posts->have_posts() && $j < 5 ) : $posts->the_post();
                        $permalink = get_permalink($post->ID);
                        if(has_post_thumbnail($post->ID)) {
                            $attr = array('alt'=>$post->post_title);
                            $thumblink = "<a href=\"$permalink\" class=\"search-thumb\">".get_the_post_thumbnail($post->ID,'thumbnail',$attr)."</a>";
                        }
                        echo "<article class=\"search-item cf\">";
                        echo $thumblink;
                        echo " <h2><a href=\"$permalink\">".$post->post_title."</a></h2>";
                        echo "<p>";
                        echo substr(strip_shortcodes($post->flo_description),0,150)." ... ";
                        echo "</p>";
                        echo '<br clear="left" />';
                        echo "</article>";
                    endwhile;
                    else :
                        echo "<p>No Vendors were found</p>";
                        wp_reset_postdata();

                    endif;
                }
                ?>

                <?php
                    custom_pagination(null,null,$posts);
                    wp_reset_query();
                ?>

        </section>

        <?php get_sidebar('blog'); ?>

      </div>

  </div>

</div>

<?php get_footer(); ?>      
