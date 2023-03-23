<?php
	header('Access-Control-Allow-Origin: *');
	header('Content-Type: application/json');
	
	include_once '../../config/Database.php';
	include_once '../../models/Category.php';
	
    // Instantiate DB & connect
	$database = new Database();
	$db = $database->connect();
	
	$category = new Category($db);
	
	$category->id = isset($_GET['id']) ? $_GET['id'] : die();
	
	$category->read_single();
	
	if ($category->category != null) {
		$cat_arr = array(
			'id' => $category->id,
			'category' => $category->category
		);
			
		echo json_encode($cat_arr);
	} else {
		echo json_encode(
			array('message' => 'category_id Not Found')
		);
	}