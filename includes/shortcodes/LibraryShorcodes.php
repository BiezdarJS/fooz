<?php

namespace TwentyTwentyChild;

class LibraryShorcodes {

    // Constructor to register shortcodes for latest_book and genre_books
    public function __construct() {
        add_shortcode('latest_book', [$this, 'latestBook']);
        add_shortcode('genre_books', [$this, 'booksByGenre']);
    }
  
    // Method to display the latest book added to the library
    public function latestBook($atts) {
        // Arguments for the WP_Query to get the latest library post (book)
        $args = array(
            'post_type' => 'library',  // Custom post type for library
            'posts_per_page' => 1,     // Get only one post
            'orderby' => 'date',       // Order by date (newest first)
            'order' => 'DESC'          // Descending order (latest first)
        );
  
        // Run the query to fetch the latest book
        $query = new \WP_Query($args);
        ob_start(); // Start output buffering
  
        // Check if there are any posts returned by the query
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                echo '<div class="latest-book">'; // HTML wrapper for the book
                echo '<h3>' . get_the_title() . '</h3>'; // Display book title
                echo '<div>' . get_the_excerpt() . '</div>'; // Display book excerpt
                echo '</div>';
            }
            wp_reset_postdata(); // Reset the post data after the loop
        } else {
            echo '<p>' . __('No books found.', 'twentytwenty-child') . '</p>'; // Message if no books found
        }
  
        return ob_get_clean(); // Return the buffered content
    }
  
    // Method to display books belonging to a specific genre
    public function booksByGenre($atts) {
        // Set default attributes for the genre shortcode
        $atts = shortcode_atts(array(
            'term_id' => 0, // Default term_id is 0 (no genre)
        ), $atts, 'genre_books');
  
        // Check if a valid genre term ID was provided
        if (!$atts['term_id']) {
            return '<p>No genre selected.</p>'; // Message if no genre is selected
        }
  
        // Arguments for the WP_Query to fetch books in a specific genre
        $args = array(
            'post_type'      => 'library', // Custom post type for library
            'posts_per_page' => 5,         // Limit to 5 books
            'orderby'        => 'title',   // Order by book title
            'order'          => 'ASC',     // Ascending order
            'tax_query'      => array(     // Query by taxonomy (genre)
                array(
                    'taxonomy' => 'book-genre', // Taxonomy for book genre
                    'field'    => 'term_id',    // Use term_id to query
                    'terms'    => (int) $atts['term_id'], // Genre term ID
                ),
            ),
        );
  
        // Run the query to fetch books in the specified genre
        $query = new \WP_Query($args);
  
        // Check if there are any books found in the genre
        if (!$query->have_posts()) {
            return '<p>No books found for this genre.</p>'; // Message if no books found
        }
  
        // Start creating the output HTML
        $output = '<ul class="genre-book-list">';
        while ($query->have_posts()) {
            $query->the_post();
            // Add each book as a list item with a link to the book
            $output .= '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
        }
        $output .= '</ul>';
  
        wp_reset_postdata(); // Reset the post data after the loop
        return $output; // Return the list of books
    }
  }