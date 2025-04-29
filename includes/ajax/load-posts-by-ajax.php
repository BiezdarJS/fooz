<?php

add_action('wp_ajax_20_books_in_json', 'get_books_in_json');
add_action('wp_ajax_nopriv_20_books_in_json', 'get_books_in_json');


function get_books_in_json() {
    // Verify nonce
    if ( ! isset($_POST['nonce']) || ! wp_verify_nonce($_POST['nonce'], 'custom_ajax_nonce') ) {
        wp_send_json_error('Nonce verification failed.');
        exit;
    }

    $args = array(
        'post_type' => 'library',
        'post_status' => 'publish',
        'posts_per_page' => 20,
    );
    $query = new WP_Query($args);
    
    if ($query->have_posts()) {
        $books = array(); 


        while ($query->have_posts()) {
            $query->the_post();

            // Get genre(s) as an array of names
            $genres = get_the_terms(get_the_ID(), 'book-genre');
            $genre_names = array();
            if ($genres) {
                foreach ($genres as $genre) {
                    $genre_names[] = $genre->name;
                }
            }

            $book_data = array(
                'name'    => get_the_title(),  
                'date'    => get_the_date('m.d.Y'), 
                'genre'   => $genre_names,
                'excerpt' => get_the_excerpt(),
            );

            $books[] = $book_data;
        }

        wp_reset_postdata();
        // Send data
        wp_send_json_success($books);

    } else {
        wp_send_json_error('No books found.');
    }
    wp_die();
}