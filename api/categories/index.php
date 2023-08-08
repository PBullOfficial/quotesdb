<?php 
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    // 
    $method = $_SERVER['REQUEST_METHOD']; 

    if ($method === 'OPTIONS') {
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
        header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
        return;
    }

    // Include config and model files
    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    // Instantiate DB object
    $database = new Database();
    $db = $database->connect();