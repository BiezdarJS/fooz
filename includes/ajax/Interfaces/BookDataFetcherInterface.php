<?php

namespace TwentyTwentyChild\Ajax\Interfaces;

interface BookDataFetcherInterface {
    public function fetchBooks($limit = 20);
}