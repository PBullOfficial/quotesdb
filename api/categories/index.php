<?php
// Please put the following at the top of each of the index.php files: 
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

if ($method === 'OPTIONS') {
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
    exit();
}
// And now you have your $method variable ready to go, too!

/*
require_once('../../config/Database.php');
require_once('../../models/Quote.php');
require_once('../../models/Author.php');
require_once('../../models/Category.php');
require_once('../../functions/isValid.php');
*/
if ($method === 'GET') {
    if (parse_url($uri, PHP_URL_QUERY)) {
        require('read_single_php');
    } else {
        require('read.php');
    }
}

elseif ($method === 'POST') {
    require('create.php');
}

elseif ($method === 'PUT') {
    require('update.php');
}

elseif ($method === 'DELETE') {
    require('delete.php');
}

?>