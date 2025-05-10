<?php

namespace TwentyTwentyChild;
use TwentyTwentyChild\Shortcode\Interfaces\BookQueryInterface;

class LatestBookQuery implements BookQueryInterface {
    public function getLatestBook() {
        $args = array(
            'post_type' => 'library',
            'posts_per_page' => 1,
            'orderby' => 'date',
            'order' => 'DESC'
        );
        return new \WP_Query($args);
    }

    public function getBooksByGenre($term_id) {
        $args = array(
            'post_type' => 'library',
            'posts_per_page' => 5,
            'orderby' => 'title',
            'order' => 'ASC',
            'tax_query' => array(
                array(
                    'taxonomy' => 'book-genre',
                    'field' => 'term_id',
                    'terms' => $term_id,
                ),
            ),
        );
        return new \WP_Query($args);
    }
}