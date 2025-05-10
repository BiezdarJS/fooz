<?php

namespace TwentyTwentyChild\Shortcode\Interfaces;

// Interfejs for rendering Shortcodes
interface ShortcodeRendererInterface {
  public function renderLatestBook();
  public function renderBooksByGenre($atts);
}