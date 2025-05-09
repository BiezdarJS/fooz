<?php

namespace TwentyTwentyChild;

class BookGenreTaxonomy {

  // Constructor that registers the custom taxonomy during WordPress initialization
  public function __construct() {
      // Registers the 'init' action that triggers the 'register_taxonomy' method during WordPress initialization
      add_action('init', array($this, 'register_taxonomy'));
  }

  // Registers the custom taxonomy 'book-genre' for the 'library' post type
  public function register_taxonomy() {
      // Defines labels for the taxonomy, which will be used in the WordPress admin interface
      $labels = array(
          'name'                       => __('Genres', 'twentytwenty-child'),  
          'singular_name'              => __('Genre', 'twentytwenty-child'),
          'search_items'               => __('Search Genres', 'twentytwenty-child'),
          'popular_items'              => __('Popular Genres', 'twentytwenty-child'),
          'all_items'                  => __('All Genres', 'twentytwenty-child'), 
          'parent_item'                => __('Parent Genre', 'twentytwenty-child'), 
          'parent_item_colon'          => __('Parent Genre:', 'twentytwenty-child'),
          'edit_item'                  => __('Edit Genre', 'twentytwenty-child'),  
          'update_item'                => __('Update Genre', 'twentytwenty-child'),
          'add_new_item'               => __('Add New Genre', 'twentytwenty-child'), 
          'new_item_name'              => __('New Genre Name', 'twentytwenty-child'),
          'separate_items_with_commas' => __('Separate genres with commas', 'twentytwenty-child'),
          'add_or_remove_items'        => __('Add or remove genres', 'twentytwenty-child'),
          'choose_from_most_used'      => __('Choose from the most used genres', 'twentytwenty-child'),
          'not_found'                  => __('No genres found.', 'twentytwenty-child'),
          'menu_name'                  => __('Genres', 'twentytwenty-child'),
      );

      // Defines the arguments for the taxonomy registration
      $args = array(
          'hierarchical'      => true,
          'labels'            => $labels,
          'show_ui'           => true,
          'show_admin_column' => true,
          'query_var'         => true,
          'rewrite'           => array('slug' => 'book-genre', 'with_front' => false),
          'show_in_rest'      => true,
      );

      // Registers the 'book-genre' taxonomy for the 'library' post type
      register_taxonomy('book-genre', array('library'), $args);
  }
}