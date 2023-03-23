<?php

    include_once '../../config/Database.php';
    include_once '../../models/Author.php';



    // Instantiate DB & connect
    $result = $author->read_all();

        // Get row count
        $num = $result->rowCount();

        // Check if any categories
        if($num > 0) {
            // Cat array
            $cat_arr = array();
            //$cat_arr['data'] = array();

            while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                extract($row);

                $cat_item = array(
                    'id' => $id,
                    'author' => $author
                );

                // Push to "data"
                //array_push($cat_arr['data'], $cat_item);
                array_push($cat_arr, $cat_item);
            }

            // Turn into JSON & output
            echo json_encode($cat_arr);

        } else {
            // No Categories
            echo json_encode(
                array('message' => 'No Categories Found')
            );
        }