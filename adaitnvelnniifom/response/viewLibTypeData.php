<?php

include('../conn.php');
 
$table = 'library_master';
 
$primaryKey = 'library_id';
 
$columns = array(
    array( 'db' => 'library_id', 'dt' => 'id' ),
    array( 'db' => 'library_name', 'dt' => 'library_name' ),
    array(
        'db'        => 'active_flag',
        'dt'        => 'active_flag',
        'formatter' => function( $d, $row ) {
                if($d == 'Y') { 
                    return '<span class="badge bg-orange">Active</span>';  
                } else {
                    return '<span class="badge bg-muted">Inactive</span>';  
                }
 
        }
    )
);

$whereAll = NULL;

require( 'scripts/ssp.class.php' );
 
echo json_encode(
 	SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, $whereResult = null, $whereAll)
);

?>