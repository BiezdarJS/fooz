<?php

// Task 3
require_once get_stylesheet_directory() . '/includes/content-types/post-type-library.php';
require_once get_stylesheet_directory() . '/includes/content-types/register-taxonomy-book-genre.php';
require_once get_stylesheet_directory() . '/includes/shortcodes/latest-book.php';
require_once get_stylesheet_directory() . '/includes/shortcodes/list-books-by-genre.php';
require_once get_stylesheet_directory() . '/includes/theme-setup.php';
// Task 6
require_once get_stylesheet_directory() . '/includes/ajax/load-posts-by-ajax.php';


// Initialize child theme
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
function my_theme_enqueue_styles() {
	$parenthandle = 'parent-style'; 
	$theme        = wp_get_theme();
	wp_enqueue_style( $parenthandle,
		get_template_directory_uri() . '/style.css',
		array(), 
		$theme->parent()->get( 'Version' )
	);
	wp_enqueue_style( 'child-style',
		get_stylesheet_uri(),
		array( $parenthandle ),
		$theme->get( 'Version' )
	);
}