<?php

    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';

    // Get ID
    $post->id = isset($_GET['id']) ? $_GET['id'] : die();

    // Get quote
    $post->read_single();

    // Create array
    $quote_arr = array(
        'id' => $post->id,
        'quote' => $post->quote,
        'authorId' => $post->authorId,
        'author' => $post->author,
        'categoryId' => $post->categoryId,
        'category' => $post->category
    );

    // Make JSON
    print_r(json_encode($quote_arr));
