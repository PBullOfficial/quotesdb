<?php
    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    // Set ID to update
    $quote->id = $data->id;

    $quote->title = $data->title;
    $quote->body = $data->body;
    $quote->author = $data->authore;
    $quote->categoryId = $data->categoryId;

	if(!isset($data->id) || !isset($data->quote) || !isset($data->author_id) || !isset($data->category_id)) {
		echo json_encode(
			array('message' => 'Missing Required Parameters')
		);
		exit();
	}

    // Update post
    if($post->create()) {
        echo json_encode(
            array('message' => 'Post Updated')
        );
    } else {
        echo json_encode(
            array('message' => 'Post Not Updated')
        );
    }
    