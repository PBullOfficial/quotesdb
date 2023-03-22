<?php
// Please put the following at the top of each of the index.php files: 
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'OPTIONS') {
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
}
// And now you have your $method variable ready to go, too!

require_once('../../config/Database.php');
require_once('../../models/Quote.php');
require_once('../../models/Author.php');
require_once('../../models/Category.php');
require_once('../../functions/isValid.php');

?>

Deployed!