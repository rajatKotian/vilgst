<?php

include('conn.php');
if(isset($_POST['notes_id'])){
  $prod_id = filter_var($_POST['prod_id'], FILTER_SANITIZE_STRING);
  $sub_prod_id = filter_var($_POST['sub_prod_id'], FILTER_SANITIZE_STRING);
  $notes_id = filter_var($_POST['notes_id'], FILTER_SANITIZE_STRING);
  if (isset($_POST['delete'])){
    $response_data = deleteUserNotesById(
      $notes_id
    );
    echo json_encode($response_data);
  }
  else if(isset($_POST['data']) ){
    $data = $_POST['data'];
    $response_data = updateUserNotes(
      $data,
      $notes_id
    );
  
    echo json_encode($response_data);
  }
  else if (!isset($_POST['data']) && !isset($_POST['prod_id']) && !isset($_POST['sub_prod_id'])){
    $response_data = getUserNotesById(
      $notes_id
    );
    echo json_encode($response_data);
  }
  
}else if(isset($_POST['get_notes'])){
  $prod_id = filter_var($_POST['prod_id'], FILTER_SANITIZE_STRING);
  $sub_prod_id = filter_var($_POST['sub_prod_id'], FILTER_SANITIZE_STRING);
  
  $subProdCollection = getUserNotes(
    $prod_id,
    $sub_prod_id,
    $_SESSION["id"]
  );
  
  $response = array('message' => $subProdCollection);
  echo json_encode($response);
}else{
  $prod_id = filter_var($_POST['prod_id'], FILTER_SANITIZE_STRING);
  $sub_prod_id = filter_var($_POST['sub_prod_id'], FILTER_SANITIZE_STRING);
  $data = $_POST['data'];

  $response_data = addUserNotes(
    $prod_id,
    $sub_prod_id,
    $_SESSION["id"],
    $data
  );

  echo json_encode($response_data);
}



function deleteUserNotesById($notes_id) {
  $subProdCollection = [];
  $query= '';
  $response= array();
  $myObject = new stdClass();

  // Sanitize input

  // Check if user note exists
  $checkQuery = "SELECT COUNT(*) AS count FROM user_notes WHERE id = '$notes_id' AND status = 'active' ";
  $checkResult = mysqli_query($GLOBALS['con'], $checkQuery);
  
  if ($checkResult) {
      $row = mysqli_fetch_assoc($checkResult);
      $count = $row['count'];
      
      $query = "UPDATE user_notes 
      SET status = 'inactive'
      WHERE id = '$notes_id'";
      mysqli_query($GLOBALS['con'], $query);
      $myObject->data = "Record updated successfully";
      
      $myObject->success = true;
      $response = array('message' => $myObject);
      return $response; 

  } else {
      $myObject->success = false;
      $myObject->data = "Error: " . mysqli_error($GLOBALS['con']);
      $response = array('message' => $myObject);
      return $response; 
  }
};

function getUserNotesById($notes_id) {
    $subProdCollection = [];
    $cond = "(id = '".$notes_id."')";
    $query= "SELECT * FROM user_notes WHERE ".$cond." AND status = 'active' LIMIT 1";

  	$statement = mysqli_prepare($GLOBALS['con'], $query);  
    mysqli_stmt_execute($statement);

    $result = mysqli_stmt_get_result($statement);

    while ($row = mysqli_fetch_assoc($result)) {
        $subProdCollection[] = $row;
    }

    mysqli_stmt_close($statement);

    return $subProdCollection;
};

function getUserNotes($prod_id,$sub_prod_id,$user_id) {
    $subProdCollection = [];
    $cond = "(prod_id = '".$prod_id."' AND sub_prod_id = '".$sub_prod_id."' AND user_id = '".$user_id."' AND status = 'active')";
    $query= "SELECT * FROM user_notes WHERE ".$cond."";

  	$statement = mysqli_prepare($GLOBALS['con'], $query);  
    mysqli_stmt_execute($statement);

    $result = mysqli_stmt_get_result($statement);

    while ($row = mysqli_fetch_assoc($result)) {
        $subProdCollection[] = $row;
    }

    mysqli_stmt_close($statement);

    return $subProdCollection;
};

function updateUserNotes($data,$notes_id) {
  $subProdCollection = [];
  $query= '';
  $response= array();
  $myObject = new stdClass();

  // Sanitize input
  $prod_id = mysqli_real_escape_string($GLOBALS['con'], $prod_id);
  $sub_prod_id = mysqli_real_escape_string($GLOBALS['con'], $sub_prod_id);
  $user_id = mysqli_real_escape_string($GLOBALS['con'], $user_id);
  $data = mysqli_real_escape_string($GLOBALS['con'], $data);
  $title = extractTitleFromHTML($data);
  $timestamp = date("Y-m-d H:i:s");
  $timestamp = date("Y-m-d H:i:s");
  // Check if user note exists
  $checkQuery = "SELECT COUNT(*) AS count FROM user_notes WHERE id = '$notes_id' AND status = 'active' ";
  $checkResult = mysqli_query($GLOBALS['con'], $checkQuery);
  
  if ($checkResult) {
      $row = mysqli_fetch_assoc($checkResult);
      $count = $row['count'];
      
      $query = "UPDATE user_notes 
      SET input_data = '$data', updated_at = '$timestamp', title = '$title'
      WHERE id = '$notes_id'";
      mysqli_query($GLOBALS['con'], $query);
      $myObject->data = "Record updated successfully";
      
      $myObject->success = true;
      $response = array('message' => $myObject);
      return $response; 

  } else {
      $myObject->success = false;
      $myObject->data = "Error: " . mysqli_error($GLOBALS['con']);
      $response = array('message' => $myObject);
      return $response; 
  }
};

function addUserNotes($prod_id, $sub_prod_id, $user_id, $data) {
  $subProdCollection = [];
  $query= '';
  $response= array();
  $myObject = new stdClass();

  $prod_id = mysqli_real_escape_string($GLOBALS['con'], $prod_id);
  $sub_prod_id = mysqli_real_escape_string($GLOBALS['con'], $sub_prod_id);
  $user_id = mysqli_real_escape_string($GLOBALS['con'], $user_id);
  $data = mysqli_real_escape_string($GLOBALS['con'], $data);
  $title = extractTitleFromHTML($data);

  $timestamp = date("Y-m-d H:i:s");
  $timestamp = date("Y-m-d H:i:s");
 
  $row = mysqli_fetch_assoc($checkResult);
  $count = $row['count'];
  $query = "INSERT INTO user_notes (prod_id, sub_prod_id, user_id, input_data, created_at, updated_at,title ) 
        VALUES ('$prod_id', '$sub_prod_id', '$user_id', '$data', '$timestamp', '$timestamp', '$title')";

  mysqli_query($GLOBALS['con'], $query);
  $myObject->data = "Notes added";
  $myObject->success = true;
  $response = array('message' => $myObject);
  return $response; 
}

function extractTitleFromHTML($htmlString) {
  $plainText = strip_tags($htmlString);
  $title = substr($plainText, 0, 20);
  return $title;
}

?>