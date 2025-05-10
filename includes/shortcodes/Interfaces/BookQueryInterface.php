<?php

namespace TwentyTwentyChild\Shortcode\Interfaces;

// Interface for querying books
interface BookQueryInterface {
  public function getLatestBook();
  public function getBooksByGenre($term_id);
}