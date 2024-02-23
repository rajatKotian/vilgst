<?php

include('../conn.php');
 
$table = 'client';
 
$primaryKey = 'cid';
 
$columns = array(
    array( 'db' => 'cid', 'dt' => 'id' ),
    array( 'db' => 'cname', 'dt' => 'cname' )
    
);

$whereAll = NULL;

require( 'scripts/ssp.class.php' );
 
echo json_encode(
 	SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, $whereResult = null, $whereAll)
);

?>