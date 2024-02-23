<?php

include('../conn.php');
 
$table = 'package_master';
 
$primaryKey = 'pid';
 
$columns = array(
    array( 'db' => 'pid', 'dt' => 'id' ),
    array( 'db' => 'pname', 'dt' => 'shortname' ),
    array( 'db' => 'pdescription', 'dt' => 'description' ),
    array( 'db' => 'pamount', 'dt' => 'amount' ),
    array( 'db' => 'addemailamount', 'dt' => 'addemailamount' )
);

$whereAll = NULL;

require( 'scripts/ssp.class.php' );
 
echo json_encode(
 	SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, $whereResult = null, $whereAll)
);

?>