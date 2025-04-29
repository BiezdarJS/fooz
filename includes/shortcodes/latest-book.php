<?php
function shortcode_latest_book($atts) {
    $args = array(
        'post_type' => 'library',
        'posts_per_page' => 1,
        'orderby' => 'date',
        'order' => 'DESC'
    );
    
    $query = new WP_Query($args);
    ob_start();
    
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            echo '<div class="latest-book">';
            echo '<h3>' . get_the_title() . '</h3>';
            echo '<div>' . get_the_excerpt() . '</div>';
            echo '</div>';
        }
        wp_reset_postdata();
    } else {
        echo '<p>' . __('No books found.', 'twentytwenty-child') . '</p>';
    }
    
    return ob_get_clean();
}

add_shortcode('latest_book', 'shortcode_latest_book');