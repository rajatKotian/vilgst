<?php

include('conn.php');

if(isset($_POST['prod_id']) && isset($_POST['sub_prod_id'])){
  $prod_id = filter_var($_POST['prod_id'], FILTER_SANITIZE_STRING);
  $sub_prod_id = filter_var($_POST['sub_prod_id'], FILTER_SANITIZE_STRING);
  
  $subProdCollection = getSubProducts(
    $prod_id,
    $sub_prod_id,
    $_SESSION["id"]
  );
  
  $response = array('message' => $subProdCollection[0]);
  echo json_encode($response);
}


function getSubProducts($prod_id,$sub_prod_id,$user_id) {
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
}
?>