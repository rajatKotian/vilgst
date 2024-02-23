<?php

include('../conn.php');
 
$table = 'userlogins';
 
$primaryKey = 'user_id';
 
$columns = array(
    array( 'db' => 'user_id', 'dt' => 'id' ),
    array( 'db' => 'username', 'dt' => 'username' ),    
    array( 'db' => 'pwd', 'dt' => 'pwd' ),
    array( 'db' => 'comapany_name', 'dt' => 'comapany' ),
    array( 'db' => 'email_id', 'dt' => 'email' ),
    array(
        'db'        => 'email_id',
        'dt'        => 'email',
        'formatter' => function( $d, $row ) {
          return '<a href="mailto:'.$d.'" title="Click here to send mail">'.$d.'</a>';
        }
    ),
    array(
        'db'        => 'from_date',
        'dt'        => 'user_date',
        'formatter' => function( $d, $row ) {
          return date( 'd-M-Y', strtotime($row['from_date'])).'<br />'.date( 'd-M-Y', strtotime($row['to_date']));
        }
    ),
    array(
        'db'        => 'to_date',
        'dt'        => 'to_date',
        'formatter' => function( $d, $row ) {
          return date( 'm-d-Y', strtotime($d));
        }
    ),
    array(
        'db'        => 'user_type',
        'dt'        => 'user_type',
        'formatter' => function( $d, $row ) {
                if($d == 'A') { $color = 'teal'; }
                else if($d == 'S') { $color = 'purple'; }
                else if($d == 'T') { $color = 'fuchsia'; }

                return '<span class="badge bg-'.$color.'">'.$d.'</span>';  
        }
    ),
    array( 'db' => 'totalhitcount', 'dt' => 'totalhitcount' )
);

if (isset($_GET['start_date']) && isset($_GET['end_date'])) {

    if(isset($_GET['user_type']) && $_GET['user_type'] != '0') {
        $whereAll = ' (created_dt BETWEEN  "'.$_GET['start_date'].'" AND  "'.$_GET['end_date'].'")' . " AND user_type='".$_GET['user_type']."'";
    } else {
        $whereAll = ' (created_dt BETWEEN  "'.$_GET['start_date'].'" AND  "'.$_GET['end_date'].'")';
    }

} else if (isset($_GET['user_type'])) {

    if($_GET['user_type'] != '0') {
        $whereAll = " user_type='".$_GET['user_type']."'";
    } else {
        $whereAll = NULL;
    }

} else {
    $whereAll = NULL;
}


require( 'scripts/ssp.class.php' );
 
echo json_encode(
 	SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, $whereResult = null, $whereAll)
);

?>