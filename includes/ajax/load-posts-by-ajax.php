<?php

class BookAjaxHandler {

    public static function register() {
        add_action('wp_ajax_20_books_in_json', [self::class, 'handle']);
        add_action('wp_ajax_nopriv_20_books_in_json', [self::class, 'handle']);
    }

    public static function handle() {
        if ( ! isset($_POST['nonce']) || ! wp_verify_nonce($_POST['nonce'], 'custom_ajax_nonce') ) {
            wp_send_json_error('Nonce verification failed.');
            wp_die();
        }

        $books = self::getBooksData();

        if (!empty($books)) {
            wp_send_json_success($books);
        } else {
            wp_send_json_error('No books found.');
        }

        wp_die();
    }

    private static function getBooksData($limit = 20) {
        $args = array(
            'post_type'      => 'library',
            'post_status'    => 'publish',
            'posts_per_page' => $limit,
        );

        $query = new WP_Query($args);
        $books = array();

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $books[] = self::formatBookData(get_the_ID());
            }
            wp_reset_postdata();
        }

        return $books;
    }

    private static function formatBookData($post_id) {
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

BookAjaxHandler::register();