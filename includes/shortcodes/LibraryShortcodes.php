<?php

namespace TwentyTwentyChild;
use TwentyTwentyChild\Shortcode\Interfaces\ShortcodeRendererInterface;

class LibraryShortcodes {

    private $shortcodeRenderer;

    // Konstruktor teraz przyjmuje renderera jako zależność
    public function __construct(ShortcodeRendererInterface $shortcodeRenderer) {
        $this->shortcodeRenderer = $shortcodeRenderer;
        add_shortcode('latest_book', [$this, 'latestBook']);
        add_shortcode('genre_books', [$this, 'booksByGenre']);
    }

    // Przekazanie logiki do renderera
    public function latestBook($atts) {
        return $this->shortcodeRenderer->renderLatestBook();
    }

    // Przekazanie logiki do renderera
    public function booksByGenre($atts) {
        return $this->shortcodeRenderer->renderBooksByGenre($atts);
    }
}