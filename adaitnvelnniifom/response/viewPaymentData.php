<?php

include('../conn.php');
 
$table = 'payment_history';
 
$primaryKey = 'id';
 
$columns = array(
    array( 'db' => 'id', 'dt' => 'id' ),
    array(
        'db'        => 'userid',
        'dt'        => 'userid',
        'formatter' => function( $d, $row ) {
                $result = mysqli_query($GLOBALS['con'],"SELECT username FROM userlogins WHERE user_id = $d LIMIT 1");
                while ($row = mysqli_fetch_array($result)) {  
                return '<a href="javascript:void(0)" title="'.$d.'"  data-toggle="popover" data-content="'.$row['username'].'">'.$d.'</a>';                 
                }                 
        }
    ), 
    array(
        'db'        => 'firstName',
        'dt'        => 'name',
        'formatter' => function( $d, $row ) {
            return $row['firstName'].' '.$row['lastName'];                
        }
    ), 
    array( 'db' => 'lastName', 'dt' => 'lastName' ),
    array( 'db' => 'txnid', 'dt' => 'txnid' ),
    array( 'db' => 'txnrefno', 'dt' => 'txnrefno' ),
    array(
        'db'        => 'txnstatus',
        'dt'        => 'txnstatus',
        'formatter' => function( $d, $row ) {
                $color = '';
                if($d == 'CANCELED') { $color = 'red'; }
                else if($d == 'SUCCESS') { $color = 'green'; }
                    return '<span class="badge bg-'.$color.'">'.$d.'</span>';  
        }
    ),
    array( 'db' => 'amount', 'dt' => 'amount' ),   
    array(
        'db'        => 'paymentdate',
        'dt'        => 'date',
        'formatter' => function( $d, $row ) {
          return date( 'm-d-Y', strtotime($d));
        }
    ),
    array( 'db' => 'paymentMode', 'dt' => 'paymentMode' )
);

$whereAll = NULL;

require( 'scripts/ssp.class.php' );
 
echo json_encode(
 	SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, $whereResult = null, $whereAll)
);

?>