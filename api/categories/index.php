<?php 
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    // Get HTTP method
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

    // Instantiate Category object
    $category_obj = new Category($db);
    $category_obj->id = intval($_GET["id"]);

    // Categories GET method
    if ($method === 'GET' && !isset($_GET["id"])) {
        $result = $category_obj->read();
        $num = $result->rowCount();

        if ($num > 0) {
            $category_arr = array();
            while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                extract($row);

                $category_item = array(
                    'id' => $id,
                    'category' => $category
                ); 
                // Push category to data 
                array_push($category_arr, $category_item);
            }
            echo json_encode($category_arr);

        } 
        else {
            echo json_encode(
                array('message'=>"categoryId Not Found")
            );
        }
    }
    // Category GET Single
    if ($method === 'GET' && isset($_GET["id"])) {
        $category_obj->read_single();
        $category_item = array(
            'id' => $category_obj->id,
            'category' => $category_obj->category
        ); 

        if (empty($category_obj->category)) {
            echo json_encode(
                array('message'=>"categoryId Not Found")
            );
        } else {
        echo json_encode($category_item);
        }
    }
    // Category POST
    if ($method === 'POST') {
        // Get posted data
        $data = json_decode(file_get_contents("php://input"));
        $category_obj->category = $data->category;

        // Validate request
        if (empty($category_obj->category)) {
            echo json_encode(
                array('message'=>'Missing Required Parameters')
            );
            return;
        }

        // Create the category
        if ($category_obj->create()) {
            $category_item = array(
                'id' => $category_obj->id,
                'category' => $category_obj->category
            ); 
            echo(json_encode($category_item));

        }
    }

    // Category PUT
    if ($method === 'PUT') {
        // get posted data
        $data = json_decode(file_get_contents("php://input"));
        $category_obj->id = $data->id;
        $category_obj->category = $data->category;

        // Validate request
        if (empty($category_obj->id) || empty($category_obj->category)) {
            echo json_encode(
                array('message'=>'Missing Required Parameters')
            );
            return;
        }

        // Create the post
        if ($category_obj->update()) {
            $category_item = array(
                'id' => $category_obj->id,
                'category' => $category_obj->category
            ); 
            echo(json_encode($category_item));
        }
    }

    // Category DELETE
    if ($method === 'DELETE') {
        // Get posted data
        $data = json_decode(file_get_contents("php://input"));
        $category_obj->id = $data->id;

        // Validate request
        if (empty($category_obj->id)) {
            echo json_encode(
                array('message'=>'Missing Required Parameters')
            );
        }

        // Create the post
        if ($category_obj->delete()) {
            $category_item = array(
                'id' => $category_obj->id
            ); 
            echo(json_encode($category_item));
        }
    }
?>