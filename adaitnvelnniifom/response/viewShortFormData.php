<?php

//echo "hello"; die();

include('../conn.php');

 

$table = 'short_form';

 

$primaryKey = 'id';

 

$columns = array(

    array( 'db' => 'id', 'dt' => 'id' ),

    array( 'db' => 'short_form', 'dt' => 'short_form' ),

    array( 'db' => 'full_form', 'dt' => 'full_form' )

);



if (isset($_GET['start_date']) && isset($_GET['end_date'])) {



    $whereAll = ' (article_date BETWEEN  "'.$_GET['start_date'].'" AND  "'.$_GET['end_date'].'")';



} else {

    $whereAll = NULL;

}



require( 'scripts/ssp.class.php' );

 

echo json_encode(

 	SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, $whereResult = null, $whereAll)

);



?>
