<?php

    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';

    // Get ID
    $quote->id = isset($_GET['id']) ? $_GET['id'] : die();

    // Get quote
    $quote->read_single();

    // Create array
    $quote_arr = array(
        'id' => $quote->id,
        'quote' => $quote->quote,
        'authorId' => $quote->authorId,
        'author' => $quote->author,
        'categoryId' => $quote->categoryId,
        'category' => $quote->category
    );

    // Make JSON
    print_r(json_encode($quote_arr));
