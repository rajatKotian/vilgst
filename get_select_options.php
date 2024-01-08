<?php

include('conn.php');

if (isset($_POST['options_type'])) {
    
    $optionsType = $_POST['options_type'];
    $options = [];
    switch ($optionsType) {
        case 'product_forum_fetch':
            $options = getSubProducts($_POST['prod_id']);
            break;
    }
    
    echo json_encode($options);
}

function getSubProducts($prod_id) {
    $subProdCollection = [];
  	$statement = mysqli_prepare($GLOBALS['con'], "SELECT sub_prod_name, sub_prod_id FROM sub_product WHERE prod_id = ?");
  
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
