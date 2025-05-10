<?php

namespace TwentyTwentyChild;

use TwentyTwentyChild\Ajax\Interfaces\BookDataFetcherInterface;

class BookDataFetcher implements BookDataFetcherInterface {
    public function fetchBooks($limit = 20) {
        $args = array(
            'post_type'      => 'library',
            'post_status'    => 'publish',
            'posts_per_page' => $limit,
        );

        $query = new \WP_Query($args);
        $books = array();

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $books[] = get_the_ID();
            }
            wp_reset_postdata();
        }

        return $books;
    }
}