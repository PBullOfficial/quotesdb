<?php  
function isValid($requested_id, $model){
      // Set the id on the model
      $model->id = $requested_id;
      // Call read_single query on model
      $result = $model->read_single();
      return $result;
    }
?>