<?php

include('../conn.php');


$table = 'budgets_union';
 
$primaryKey = 'data_id';

$prod_id = (isset($_GET['prod_id']) && $_GET['prod_id'] != '') ? " AND prod_id='".$_GET['prod_id']."'" : '';

$budget_flag = " budget_flag='Y' " . $prod_id;

 
$columns = array(
    array( 'db' => 'data_id', 'dt' => 'id' ),
    array(
        'db'        => 'circular_date',
        'dt'        => 'date',
        'formatter' => function( $d, $row ) {
          return date( 'd-M-Y', strtotime($d));
           //   return $d;
        }
    ),
     array(
        'db'        => 'linked_case_id',
        'dt'        => 'linked_case_id'
    ),
     array(
        'db'        => 'data_id',
        'dt'        => 'encrypt_id',
        'formatter' => function( $d, $row ) {
            return base64_encode(base64_encode($d));
        }
    ),
    array( 'db' => 'circular_no', 'dt' => 'circular_no' ),
    array(
        'db'        => 'cir_subject',
        'dt'        => 'summary',
        'formatter' => function( $d, $row ) {
        		$subjectLength = strlen($d);
				  if($subjectLength > 300) {
					  return  "<p>".substr($d,0,300)."... <a href='javascript:void(0)' class='read-more-subject'>[Read more +]</a></p>
					  		<p style='display:none'>".$d." <a href='javascript:void(0)' class='read-less-subject'>[Read less -]</a></p>";
				  } else {
					  return "<p>".$d."</p>";
					  
				  }	
        }
    ),
    array(
        'db'        => 'prod_id',
        'dt'        => 'prod',
        'formatter' => function( $d, $row ) {
                $result = mysqli_fetch_assoc(mysqli_query($GLOBALS['con'],"SELECT prod_id, prod_name FROM product WHERE prod_id = $d  LIMIT 1"));
                    if($result['prod_id'] == '1') { $color = 'purple'; }
                    else if($result['prod_id'] == '2') { $color = 'orange'; }
                    else if($result['prod_id'] == '3') { $color = 'fuchsia'; }
                    else if($result['prod_id'] == '4') { $color = 'blue'; }
                    else if($result['prod_id'] == '5') { $color = 'green'; }
                    else if($result['prod_id'] == '6') { $color = 'muted'; }
                    else { $color = 'yellow'; }

                return '<span class="badge bg-'.$color.'">'.$result['prod_name'].'</span>';        
            }
    ),
    array(
        'db'        => 'sub_prod_id',
        'dt'        => 'sub_prod',
        'formatter' => function( $d, $row ) {
				$result = mysqli_fetch_assoc(mysqli_query($GLOBALS['con'],"SELECT sub_prod_name, sub_prod_type FROM sub_product WHERE sub_prod_id = $d  LIMIT 1"));
                    if($result['sub_prod_type'] == 'Notifications') { $color = 'purple'; }
                    else if($result['sub_prod_type'] == 'Act') { $color = 'muted'; }
                    else if($result['sub_prod_type'] == 'Judgements') { $color = 'fuchsia'; }
                    else { $color = 'yellow'; }

                return '<span class="badge bg-'.$color.'">'.$result['sub_prod_name'].'</span>';        
            }
    ),
 	array( 
        'db' => 'sub_subprod_id', 
        'dt' => 'sub_subprod',
        'formatter' => function( $d, $row ) {
                return '<span class="badge bg-muted" style="padding-right: 10px;">'.$d.'</span>';        
            }
    ),
    array( 'db' => 'file_path', 'dt' => 'file_path' )    
);


if (isset($_GET['start_date']) && isset($_GET['end_date'])) {

    if(isset($_GET['sub_prod_id']) && $_GET['sub_prod_id'] != '0') {
        $whereAll = ' (circular_date BETWEEN  "'.$_GET['start_date'].'" AND  "'.$_GET['end_date'].'")' . " AND sub_prod_id='".$_GET['sub_prod_id']."' AND " . $budget_flag;
    } else {
        $whereAll = ' (circular_date BETWEEN  "'.$_GET['start_date'].'" AND  "'.$_GET['end_date'].'") AND ' . $budget_flag;
    }

} else if (isset($_GET['sub_prod_id'])) {

    if($_GET['sub_prod_id'] != '0') {
        $whereAll = " sub_prod_id='".$_GET['sub_prod_id']."' AND " . $budget_flag;
    } else {
        $whereAll = $budget_flag;
    }

} else {
    $whereAll = $budget_flag;
}

require( 'scripts/ssp.class.php' );
 
echo json_encode(
 	SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, $whereResult = null, $whereAll)
);

?>