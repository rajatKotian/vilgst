<?php

include('../conn.php');
 
$table = 'marquee';
 
$primaryKey = 'marq_id';
 
$columns = array(
    array( 'db' => 'marq_id', 'dt' => 'id' ),
    array( 'db' => 'marq_text', 'dt' => 'marq_text' ),
    array(
        'db'        => 'updated_dt',
        'dt'        => 'date',
        'formatter' => function( $d, $row ) {
          return date( 'd-M-Y', strtotime($d));
        }
    ),    
    array(
        'db'        => 'status',
        'dt'        => 'status',
        'formatter' => function( $d, $row ) {
                if($d == '1') { 
                    return '<span class="badge bg-orange">Active</span>';  
                }
 
        }
    )
);

if (isset($_GET['start_date']) && isset($_GET['end_date'])) {

    $whereAll = ' (updated_dt BETWEEN  "'.$_GET['start_date'].'" AND  "'.$_GET['end_date'].'")';

} else {
    $whereAll = NULL;
}

require( 'scripts/ssp.class.php' );
 
echo json_encode(
 	SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, $whereResult = null, $whereAll)
);

?>