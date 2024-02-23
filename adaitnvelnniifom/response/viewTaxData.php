<?php

include('../conn.php');
 
$table = 'tax_master';
 
$primaryKey = 'id';
 
$columns = array(
    array( 'db' => 'id', 'dt' => 'id' ),
    array( 'db' => 'taxname', 'dt' => 'taxname' ),
    array( 'db' => 'percentage', 'dt' => 'percentage' )
);

$whereAll = NULL;

require( 'scripts/ssp.class.php' );
 
echo json_encode(
 	SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, $whereResult = null, $whereAll)
);

?>