<?php


function list_books_by_genre_shortcode( $atts ) {
  $atts = shortcode_atts( array(
      'term_id' => 0,
  ), $atts, 'genre_books' );

  if ( ! $atts['term_id'] ) {
      return '<p>No genre selected.</p>';
  }

  $args = array(
      'post_type'      => 'library',
      'posts_per_page' => 5,
      'orderby'        => 'title',
      'order'          => 'ASC',
      'tax_query'      => array(
          array(
              'taxonomy' => 'book-genre',
              'field'    => 'term_id',
              'terms'    => (int) $atts['term_id'],
          ),
      ),
  );

  $query = new WP_Query( $args );

  if ( ! $query->have_posts() ) {
      return '<p>No books found for this genre.</p>';
  }

  $output = '<ul class="genre-book-list">';
  while ( $query->have_posts() ) {
      $query->the_post();
      $output .= '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
  }
  $output .= '</ul>';

  wp_reset_postdata();
  return $output;
}
add_shortcode( 'genre_books', 'list_books_by_genre_shortcode' );