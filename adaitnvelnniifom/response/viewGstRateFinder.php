<?php

//echo "hello"; die();

include('../conn.php');

 

$table = 'gst_rate';

 

$primaryKey = 'id';

 

$columns = array(

    array( 'db' => 'id', 'dt' => 'id' ),

    array( 'db' => 'chapter', 'dt' => 'chapter' ),

    array(  'db' => 'desc', 
            'dt' => 'desc',

            'formatter' => function( $d, $row ) {

                return stripslashes($d);

            }
    ),

    array( 'db' => 'cgst_rate', 'dt' => 'cgst_rate' ),

    array( 'db' => 'sgst/utgst_rate', 'dt' => 'sgst/utgst_rate' ),

    array( 'db' => 'igst_rate', 'dt' => 'igst_rate' ),

    array( 'db' => 'cess', 'dt' => 'cess' )

);



if (isset($_GET['start_date']) && isset($_GET['end_date'])) {
	//echo "hello"; die();

    $whereAll = ' (article_date BETWEEN  "'.$_GET['start_date'].'" AND  "'.$_GET['end_date'].'")';



} else {
	//echo "hellonnnnn"; die();
    $whereAll = NULL;

}



require( 'scripts/ssp.class.php' );

 

echo json_encode(

 	SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, $whereResult = null, $whereAll)

);



?>
