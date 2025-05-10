<?php

namespace TwentyTwentyChild;

use TwentyTwentyChild\Ajax\Interfaces\NonceVerifierInterface;

class NonceVerifier implements NonceVerifierInterface {
    public function verify($nonce) {
        if ( ! isset($nonce) || ! wp_verify_nonce($nonce, 'custom_ajax_nonce') ) {
            wp_send_json_error('Nonce verification failed.');
            wp_die();
        }
    }
}