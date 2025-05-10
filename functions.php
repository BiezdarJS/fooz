<?php

// Theme setup
require_once get_stylesheet_directory() . '/includes/theme-setup.php';
// Autoload class
require_once __DIR__ . '/vendor/autoload.php';

// Initialize Taxonomy Class
new \TwentyTwentyChild\BookGenreTaxonomy();

// Initialize Library Post Type
new \TwentyTwentyChild\LibraryPostType();

// Initialize Shortcodes
$bookQuery = new \TwentyTwentyChild\LatestBookQuery();
$shortcodeRenderer = new \TwentyTwentyChild\BookShortcodeRenderer($bookQuery);
$libraryShortcodes = new \TwentyTwentyChild\LibraryShortcodes($shortcodeRenderer);

// Ajax Handler Class
// Initialize and Register Ajax Handler Class
$library_ajax_handler = new \TwentyTwentyChild\LibraryAjaxHandler(
	new \TwentyTwentyChild\NonceVerifier(),
	new \TwentyTwentyChild\BookDataFetcher(),
	new \TwentyTwentyChild\BookDataFormatter()
);
$library_ajax_handler->register();



// Initialize child theme
add_action( 'wp_enqueue_scripts', 'ttc_enqueue_styles' );
function ttc_enqueue_styles() {
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