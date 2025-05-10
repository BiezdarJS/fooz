<?php

namespace TwentyTwentyChild;
use TwentyTwentyChild\Shortcode\Interfaces\ShortcodeRendererInterface;
use TwentyTwentyChild\Shortcode\Interfaces\BookQueryInterface;

class BookShortcodeRenderer implements ShortcodeRendererInterface {
  private $bookQuery;

  // Konstruktor z wstrzyknięciem zależności
  public function __construct(BookQueryInterface $bookQuery) {
      $this->bookQuery = $bookQuery;
  }

  public function renderLatestBook() {
      $query = $this->bookQuery->getLatestBook();
      ob_start();
      if ($query->have_posts()) {
          while ($query->have_posts()) {
              $query->the_post();
              echo '<div class="latest-book">';
              echo '<h3>' . get_the_title() . '</h3>';
              echo '<div>' . get_the_excerpt() . '</div>';
              echo '</div>';
          }
          wp_reset_postdata();
      } else {
          echo '<p>No books found.</p>';
      }
      return ob_get_clean();
  }

  public function renderBooksByGenre($atts) {
      $atts = shortcode_atts(array(
          'term_id' => 0,
      ), $atts, 'genre_books');

      if (!$atts['term_id']) {
          return '<p>No genre selected.</p>';
      }

      $query = $this->bookQuery->getBooksByGenre($atts['term_id']);
      if (!$query->have_posts()) {
          return '<p>No books found for this genre.</p>';
      }

      $output = '<ul class="genre-book-list">';
      while ($query->have_posts()) {
          $query->the_post();
          $output .= '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
      }
      $output .= '</ul>';

      wp_reset_postdata();
      return $output;
  }
}