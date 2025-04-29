<?php


function register_library_cpt() {
  register_post_type('library',
    array(
      'labels' => array(
          'name' => __('Books', 'twentytwenty-child'),
          'singular_name' => __('Book', 'twentytwenty-child'),
          'add_new' => __('Add New', 'twentytwenty-child'),
          'add_new_item' => __('Add New Book', 'twentytwenty-child'),
          'edit_item' => __('Edit Book', 'twentytwenty-child'),
          'new_item' => __('New Book', 'twentytwenty-child'),
          'view_item' => __('View Book', 'twentytwenty-child'),
          'view_items' => __('View Books', 'twentytwenty-child'),
          'search_items' => __('Search Books', 'twentytwenty-child'),
          'not_found' => __('No books found', 'twentytwenty-child'),
          'not_found_in_trash' => __('No books found in Trash', 'twentytwenty-child'),
          'all_items' => __('All Books', 'twentytwenty-child'),
          'archives' => __('Book Archives', 'twentytwenty-child'),
          'attributes' => __('Book Attributes', 'twentytwenty-child'),
          'insert_into_item' => __('Insert into book', 'twentytwenty-child'),
          'uploaded_to_this_item' => __('Uploaded to this book', 'twentytwenty-child'),
          'filter_items_list' => __('Filter books list', 'twentytwenty-child'),
          'items_list_navigation' => __('Books list navigation', 'twentytwenty-child'),
          'items_list' => __('Books list', 'twentytwenty-child'),
      ),
      'public' => true,
      'show_ui' => true,
      'show_in_rest' => true,
      'has_archive' => false,
      'rewrite' => array(
          'slug' => 'books',
          'with_front' => false
      ),
      'menu_icon' => 'dashicons-book',
      'supports' => array('title', 'thumbnail', 'excerpt')
    ));
}

add_action('init', 'register_library_cpt');