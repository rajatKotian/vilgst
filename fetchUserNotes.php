<?php

include('conn.php');

if(isset($_POST['data']) && isset($_POST['prod_id']) && isset($_POST['sub_prod_id'])){

  $prod_id = filter_var($_POST['prod_id'], FILTER_SANITIZE_STRING);
  $sub_prod_id = filter_var($_POST['sub_prod_id'], FILTER_SANITIZE_STRING);
  $data = $_POST['data'];
  
  $response_data = updateUserNotes(
    $prod_id,
    $sub_prod_id,
    $_SESSION["id"],
    $data
  );

  echo json_encode($response_data);
}

else if(isset($_POST['prod_id']) && isset($_POST['sub_prod_id'])){
  $prod_id = filter_var($_POST['prod_id'], FILTER_SANITIZE_STRING);
  $sub_prod_id = filter_var($_POST['sub_prod_id'], FILTER_SANITIZE_STRING);
  
  
  $subProdCollection = getUserNotes(
    $prod_id,
    $sub_prod_id,
    $_SESSION["id"]
  );
  
  $response = array('message' => $subProdCollection[0]);
  echo json_encode($response);
}


function getUserNotes($prod_id,$sub_prod_id,$user_id) {
    $subProdCollection = [];
    $cond = "(prod_id = '".$prod_id."' AND sub_prod_id = '".$sub_prod_id."' AND user_id = '".$user_id."')";
    $query= "SELECT * FROM user_notes WHERE ".$cond." LIMIT 1";

  	$statement = mysqli_prepare($GLOBALS['con'], $query);  
    mysqli_stmt_execute($statement);

    $result = mysqli_stmt_get_result($statement);

    while ($row = mysqli_fetch_assoc($result)) {
        $subProdCollection[] = $row;
    }

    mysqli_stmt_close($statement);

    return $subProdCollection;
};

function updateUserNotes($prod_id, $sub_prod_id, $user_id, $data) {
  $subProdCollection = [];
  $query= '';
  $response= array();
  $myObject = new stdClass();

  // Sanitize input
  $prod_id = mysqli_real_escape_string($GLOBALS['con'], $prod_id);
  $sub_prod_id = mysqli_real_escape_string($GLOBALS['con'], $sub_prod_id);
  $user_id = mysqli_real_escape_string($GLOBALS['con'], $user_id);
  $data = mysqli_real_escape_string($GLOBALS['con'], $data);
  $timestamp = date("Y-m-d H:i:s");
  // Check if user note exists
  $checkQuery = "SELECT COUNT(*) AS count FROM user_notes WHERE prod_id = '$prod_id' AND sub_prod_id = '$sub_prod_id' AND user_id = '$user_id'";
  $checkResult = mysqli_query($GLOBALS['con'], $checkQuery);
  
  if ($checkResult) {
      $row = mysqli_fetch_assoc($checkResult);
      $count = $row['count'];
      if ($count > 0) {
          $query = "UPDATE user_notes 
                          SET input_data = '$data', updated_at = '$timestamp' 
                          WHERE prod_id = '$prod_id' AND sub_prod_id = '$sub_prod_id' AND user_id = '$user_id'";
          mysqli_query($GLOBALS['con'], $query);
          $myObject->message = "Record updated successfully";
      
          
      } else {
          $query = "INSERT INTO user_notes (prod_id, sub_prod_id, user_id, input_data, created_at, updated_at) 
                          VALUES ('$prod_id', '$sub_prod_id', '$user_id', '$data', '$timestamp', '$timestamp')";
          mysqli_query($GLOBALS['con'], $query);
          $myObject->message = "Record updated successfully";
      }
      $myObject->success = true;
      $response = array('message' => $myObject);
      return $response; 

  } else {
      $myObject->success = false;
      $myObject->message = "Error: " . mysqli_error($GLOBALS['con']);
      $response = array('message' => $myObject);
      return $response; 
      // Handle the query error, if any
  }
}
?>