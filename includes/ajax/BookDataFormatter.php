<?php

namespace TwentyTwentyChild;

use TwentyTwentyChild\Ajax\Interfaces\BookDataFormatterInterface;

class BookDataFormatter implements BookDataFormatterInterface {
    public function format($post_id) {
        $genres = get_the_terms($post_id, 'book-genre');
        $genre_names = array();

        if ($genres && !is_wp_error($genres)) {
            foreach ($genres as $genre) {
                $genre_names[] = $genre->name;
            }
        }

        return array(
            'name'    => get_the_title($post_id),
            'date'    => get_the_date('m.d.Y', $post_id),
            'genre'   => $genre_names,
            'excerpt' => get_the_excerpt($post_id),
        );
    }
}