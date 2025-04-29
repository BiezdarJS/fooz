<?php


// Enqueue Scripts
add_action('wp_enqueue_scripts', 'child_theme_scripts', 10);
function child_theme_scripts() {
  // Task 1
	wp_enqueue_style('custom-styles', get_stylesheet_directory_uri() . '/assets/css/custom.css');
  // Task 2
  wp_enqueue_script('custom-scripts', get_stylesheet_directory_uri() . '/assets/js/scripts.js', array('jquery'), '1.0.0', true ); 
  
}


// FrontPage Include filter
function load_custom_front_page_template($template) {
  if (is_front_page()) {
      $custom_template = locate_template('templates/front-page.php');
      if ($custom_template) {
          return $custom_template;
      }
  }
  return $template;
}
add_filter('template_include', 'load_custom_front_page_template');



// Template Include filter
function custom_single_book_template($template) {
  if (is_singular('library')) {
      $custom_template = locate_template('templates/single-book.php');
      if ($custom_template) {
          return $custom_template;
      }
  }
  return $template;
}

add_filter('template_include', 'custom_single_book_template');



function custom_book_genre_template($template) {
  if (is_tax('book-genre')) {
      $custom_template = locate_template('templates/taxonomy-book-genre.php');
      if ($custom_template) {
          return $custom_template;
      }
  }
  return $template;
}
add_filter('template_include', 'custom_book_genre_template');



// Add library to taxonomy queries
function add_library_to_tax_queries($query) {
  if (!is_admin() && $query->is_main_query() && is_tax('book-genre')) {
      $query->set('post_type', 'library');
      $query->set('posts_per_page', 5);
  }
}
add_action('pre_get_posts', 'add_library_to_tax_queries');



// Enqueue custom script and styles for Ajax content loading
function enqueue_ajax_script() {
      wp_localize_script('custom-scripts', 'getJsonData', array(
          'ajax_url' => admin_url('admin-ajax.php'),
          'nonce'    => wp_create_nonce('custom_ajax_nonce')
      ));
}
add_action('wp_enqueue_scripts', 'enqueue_ajax_script', 20);