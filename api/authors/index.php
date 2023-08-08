<?php 
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    // Get the HTTP method
    $method = $_SERVER['REQUEST_METHOD']; 

    if ($method === 'OPTIONS') {
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
        header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
        return;
    }

    // Include config and model files
    include_once '../../config/Database.php';
    include_once '../../models/Author.php';

    // Instantiate DB object
    $database = new Database();
    $db = $database->connect();

    // Instantiate Author object
    $author_obj = new Author($db);
    $author_obj->id = intval($_GET["id"]);

    // Authors GET 
    if ($method === 'GET' && !isset($_GET["id"])) {
        $result = $author_obj->read();
        $num = $result->rowCount();

        if ($num > 0) {
            $author_arr = array();
            while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                extract($row);

                $author_item = array(
                    'id' => $id,
                    'author' => $author
                ); 
                // Push author to data 
                array_push($author_arr, $author_item);
            }
            echo json_encode($author_arr);
        } else {
            echo json_encode(
                array('message'=>"authorId Not Found")
            );
        }
    }
    // Author GET Single
    if ($method === 'GET' && isset($_GET["id"])) {
        $author_obj->read_single();
        $author_item = array(
            'id' => $author_obj->id,
            'author' => $author_obj->author
        ); 

        if (empty($author_obj->author)) {
            echo json_encode(
                array('message'=>"authorId Not Found")
            );

        } else {
        echo json_encode($author_item);
        }
    }
    // Author POST
    if ($method === 'POST') {
        
        // Get posted data
        $data = json_decode(file_get_contents("php://input"));
        $author_obj->author = $data->author;

        // Validate request
        if (empty($author_obj->author)) {
            echo json_encode(
                array('message'=>'Missing Required Parameters')
            );
            return;
        }

        // Create the author record
        if ($author_obj->create()) {
            $author_item = array(
                'id' => $author_obj->id,
                'author' => $author_obj->author
            ); 
            echo(json_encode($author_item));

        }
    }

    // Author PUT
    if ($method === 'PUT') {
        // Get posted data
        $data = json_decode(file_get_contents("php://input"));
        $author_obj->id = $data->id;
        $author_obj->author = $data->author;

        // Validate request
        if (empty($author_obj->author) || empty($author_obj->id)) {
            echo json_encode(
                array('message'=>'Missing Required Parameters')
            );
            return;
        }


        // Update the author
        if ($author_obj->update()) {
            
            $author_item = array(
                'id' => $author_obj->id,
                'author' => $author_obj->author
            ); 
            echo(json_encode($author_item));

        }
    }

    // Author DELETE
    if ($method === 'DELETE') {
        // get posted data
        $data = json_decode(file_get_contents("php://input"));
        $author_obj->id = $data->id;

        // Validate request
        if (empty($author_obj->id) ) {
            echo json_encode(
                array('message'=>'Missing Required Parameters')
            );
            return;
        }

        // Create the post
        if ($author_obj->delete()) {
            $author_item = array(
                'id' => $author_obj->id
            ); 
            echo(json_encode($author_item));
        }
    }

?>