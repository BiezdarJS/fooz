<?php

namespace TwentyTwentyChild;

class LibraryAjaxHandler {

    // Registers AJAX actions to handle requests for both logged-in and non-logged-in users
    public function register() {
        // Registering action for logged-in users
        add_action('wp_ajax_20_books_in_json', [$this, 'handle']);
        // Registering action for non-logged-in users
        add_action('wp_ajax_nopriv_20_books_in_json', [$this, 'handle']);
    }

    // Handles AJAX request, checking nonce and returning book data
    public function handle() {
        // Check if nonce is set and verified
        if ( ! isset($_POST['nonce']) || ! wp_verify_nonce($_POST['nonce'], 'custom_ajax_nonce') ) {
            // If nonce is invalid, return error
            wp_send_json_error('Nonce verification failed.');
            wp_die(); // Ends the script execution
        }

        // Fetching book data
        $books = $this->getBooksData();

        // Check if book data is available and send response in JSON format
        if (!empty($books)) {
            wp_send_json_success($books); // Return books in case of success
        } else {
            wp_send_json_error('No books found.'); // Return error if no books are found
        }

        wp_die(); // Ends the script execution
    }

    // Fetches book data from the database, with an option to set a limit
    private function getBooksData($limit = 20) {
        // Prepare WP_Query to fetch books
        $args = array(
            'post_type'      => 'library', // Post type 'library'
            'post_status'    => 'publish', // Only published posts
            'posts_per_page' => $limit,    // Limit the number of books to fetch
        );

        // Run the query
        $query = new \WP_Query($args);
        $books = array(); // Array to store books

        // If the query returned some posts
        if ($query->have_posts()) {
            // Iterate through each post and fetch book data
            while ($query->have_posts()) {
                $query->the_post();
                // Format book data and add it to the array
                $books[] = $this->formatBookData(get_the_ID());
            }
            wp_reset_postdata(); // Reset post data after query
        }

        return $books; // Returns the list of books
    }

    // Formats book data into an array
    private function formatBookData($post_id) {
        // Fetching terms related to the book (e.g., genre)
        $genres = get_the_terms($post_id, 'book-genre');
        $genre_names = array(); // Array to store genre names

        // If genres were fetched and no error occurred
        if ($genres && !is_wp_error($genres)) {
            // Add each genre to the array
            foreach ($genres as $genre) {
                $genre_names[] = $genre->name;
            }
        }

        // Return the formatted book data
        return array(
            'name'    => get_the_title($post_id), // Book title
            'date'    => get_the_date('m.d.Y', $post_id), // Publication date
            'genre'   => $genre_names, // Book genres
            'excerpt' => get_the_excerpt($post_id), // Book excerpt
        );
    }
}