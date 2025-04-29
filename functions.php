<?php


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



function include_theme_files() {
	$files = [
			'/includes/content-types/post-type-library.php',
			'/includes/content-types/register-taxonomy-book-genre.php',
			'/includes/shortcodes/latest-book.php',
			'/includes/shortcodes/list-books-by-genre.php',
			'/includes/theme-setup.php',
			'/includes/ajax/load-posts-by-ajax.php',
	];

	foreach ( $files as $file ) {
			$path = get_stylesheet_directory() . $file;
			if ( file_exists( $path ) ) {
					require_once $path;
			} else {
					error_log( "File not found: " . $path );
			}
	}
}
add_action( 'after_setup_theme', 'include_theme_files' );