<?php

include('../conn.php');
 
$table = 'schedules';
 
$primaryKey = 'schedule_id';
 
$columns = array(
    array( 'db' => 'schedule_id', 'dt' => 'id' ),
    array(
        'db'        => 'schedule_date',
        'dt'        => 'date',
        'formatter' => function( $d, $row ) {
          return date( 'd-M-Y', strtotime($d));
        }
    ),
    array( 'db' => 'state_id', 'dt' => 'state' ),
    array( 'db' => 'category', 'dt' => 'category' ),
    array( 'db' => 'schedule_narration', 'dt' => 'schedule_narration' ),
    array( 'db' => 'file_path', 'dt' => 'file_path' ), 
    array(
        'db'        => 'schedule_id',
        'dt'        => 'encrypt_id',
        'formatter' => function( $d, $row ) {
            return base64_encode(base64_encode($d));
        }
    )
);

if (isset($_GET['start_date']) && isset($_GET['end_date'])) {

    $whereAll = ' (schedule_date BETWEEN  "'.$_GET['start_date'].'" AND  "'.$_GET['end_date'].'")';

} else {
    $whereAll = NULL;
}

require( 'scripts/ssp.class.php' );
 
echo json_encode(
 	SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, $whereResult = null, $whereAll)
);

?>