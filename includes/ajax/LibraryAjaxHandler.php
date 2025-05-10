<?php

namespace TwentyTwentyChild;

use TwentyTwentyChild\Ajax\Interfaces\NonceVerifierInterface;
use TwentyTwentyChild\Ajax\Interfaces\BookDataFetcherInterface;
use TwentyTwentyChild\Ajax\Interfaces\BookDataFormatterInterface;


class LibraryAjaxHandler {

    private $nonceVerifier;
    private $bookDataFetcher;
    private $bookDataFormatter;

    // Constructor injecting depenencies
    public function __construct(
        NonceVerifierInterface $nonceVerifier,
        BookDataFetcherInterface $bookDataFetcher,
        BookDataFormatterInterface $bookDataFormatter
    ) {
        $this->nonceVerifier = $nonceVerifier;
        $this->bookDataFetcher = $bookDataFetcher;
        $this->bookDataFormatter = $bookDataFormatter;
    }

    // AJAX action register
    public function register() {
        add_action('wp_ajax_20_books_in_json', [$this, 'handle']);
        add_action('wp_ajax_nopriv_20_books_in_json', [$this, 'handle']);
    }

    // AJAX Request handler
    public function handle() {
        // nonce Verification
        $this->nonceVerifier->verify($_POST['nonce']);

        // fetching books data
        $booksData = $this->bookDataFetcher->fetchBooks();

        if (!empty($booksData)) {
            $books = array_map([$this->bookDataFormatter, 'format'], $booksData);
            wp_send_json_success($books);
        } else {
            wp_send_json_error('No books found.');
        }

        wp_die();
    }
}