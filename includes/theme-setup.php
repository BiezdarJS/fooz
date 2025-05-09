<?php


// Enqueue Scripts
add_action('wp_enqueue_scripts', 'ttc_child_theme_scripts', 10);
function ttc_child_theme_scripts() {
  // Task 1
	wp_enqueue_style('custom-styles', get_stylesheet_directory_uri() . '/assets/css/custom.css');
  // Task 2
  wp_enqueue_script('custom-scripts', get_stylesheet_directory_uri() . '/assets/js/scripts.js', array('jquery'), '1.0.0', true ); 
  
}





// Add library to taxonomy queries
function ttc_add_library_to_tax_queries($query) {
  if (!is_admin() && $query->is_main_query() && is_tax('book-genre')) {
      $query->set('post_type', 'library');
      $query->set('posts_per_page', 5);
  }
}
add_action('pre_get_posts', 'ttc_add_library_to_tax_queries');



// Enqueue custom script and styles for Ajax content loading
function ttc_enqueue_ajax_script() {
      wp_localize_script('custom-scripts', 'getJsonData', array(
          'ajax_url' => admin_url('admin-ajax.php'),
          'nonce'    => wp_create_nonce('custom_ajax_nonce')
      ));
}
add_action('wp_enqueue_scripts', 'ttc_enqueue_ajax_script', 20);