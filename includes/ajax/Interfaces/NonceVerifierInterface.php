<?php

namespace TwentyTwentyChild\Ajax\Interfaces;

interface NonceVerifierInterface {
    public function verify($nonce);
}