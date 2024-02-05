<?php

include('conn.php');

$subProdCollection = getSubProducts($_POST['prod_id']);
$response = array('message' => $subProdCollection[0]);

echo json_encode($response);

function getSubProducts($prod_id) {
    $subProdCollection = [];
  	$statement = mysqli_prepare($GLOBALS['con'], "SELECT * FROM user_notes");
  
    mysqli_stmt_bind_param($statement, 'i', $prod_id);
    mysqli_stmt_execute($statement);

    $result = mysqli_stmt_get_result($statement);

    while ($row = mysqli_fetch_assoc($result)) {
        $subProdCollection[] = $row;
    }

    mysqli_stmt_close($statement);

    return $subProdCollection;
}
?>