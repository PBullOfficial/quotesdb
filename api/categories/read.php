<?php

    include_once '../../config/Database.php';
    include_once '../../models/Category.php';
    include_once 'index.php';


    
    // Category read query
    $result = $category->read();
    // Get row count
    $num = $result->rowCount();

    // Check if any categories
    if($num > 0) {
        // Cat array
        $cat_arr = array();
        $cat_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $cat_item = array(

            );

            // Push to "data"
            array_push($cat_arr['data'], $cat_item);
        }

        // Turn into JSON & output
        echo json_encode($cat_arr);

    } else {
        // No Categories
        echo json_encode(
            array('message' => 'No Categories Found')
        );
    }