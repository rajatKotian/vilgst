<?php



include('../conn.php');





$table = 'casedata_'.$_GET['data'];

 

$primaryKey = 'data_id';

 

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

        'db'        => 'data_id',

        'dt'        => 'encrypt_id',

        'formatter' => function( $d, $row ) {

            return base64_encode(base64_encode($d));

        }

    ),

    array( 'db' => 'circular_no', 'dt' => 'circular_no' ),
    
    array( 'db' => 'party_name', 'dt' => 'party_name' ),

    array(

        'db'        => 'search_subject',

        'dt'        => 'search_subject',

        'formatter' => function( $d, $row ) {

        		$subjectLength = strlen($d);

				  if($subjectLength > 300) {

					  return  "<p>".substr(cleanname(utf8_decode($d)),0,300)."... <a href='javascript:void(0)' class='read-more-subject'>[Read more +]</a></p>

					  		<p style='display:none'>".cleanname(utf8_decode($d))." <a href='javascript:void(0)' class='read-less-subject'>[Read less -]</a></p>";

				  } else {
					  return "<p>".cleanname(utf8_decode($d))."</p>";
				  }	
        }

    ),
    
    
    array(

        'db'        => 'cir_subject',

        'dt'        => 'summary',

        'formatter' => function( $d, $row ) {

        		$subjectLength = strlen($d);

				  if($subjectLength > 300) {

					  return  "<p>".substr(cleanname(utf8_decode($d)),0,300)."... <a href='javascript:void(0)' class='read-more-subject'>[Read more +]</a></p>

					  		<p style='display:none'>".cleanname(utf8_decode($d))." <a href='javascript:void(0)' class='read-less-subject'>[Read less -]</a></p>";

				  } else {
					  return "<p>".cleanname(utf8_decode($d))."</p>";
				  }	
        }

    ),
    
    
    
    // array(

    //     'db'        => 'file_data',

    //     'dt'        => 'file_data',

    //     'formatter' => function( $d, $row ) {

    //     		$subjectLength = strlen($d);

				//   if($subjectLength > 300) {

				// 	  return  "<p>".substr(cleanname(utf8_decode($d)),0,300)."... <a href='javascript:void(0)' class='read-more-subject'>[Read more +]</a></p>

				// 	  		<p style='display:none'>".cleanname(utf8_decode($d))." <a href='javascript:void(0)' class='read-less-subject'>[Read less -]</a></p>";

				//   } else {

				// 	  return "<p>".cleanname(utf8_decode($d))."</p>";

					  

				//   }	

    //     }

    // ),
    
    array( 'db' => 'show_hide_flag', 'dt' => 'show_hide_flag' ),
    
    array(

        'db'        => 'state_id',

        'dt'        => 'state',

        'formatter' => function( $d, $row ) {

				$result = mysqli_fetch_assoc(mysqli_query($GLOBALS['con'],"SELECT state_name FROM state_master WHERE state_id = $d LIMIT 1"));

        		return $result['state_name'];

        }

    ),

    array(

        'db'        => 'sub_prod_id',

        'dt'        => 'sub_prod',

        'formatter' => function( $d, $row ) {

				$result = mysqli_fetch_assoc(mysqli_query($GLOBALS['con'],"SELECT sub_prod_name, sub_prod_type FROM sub_product WHERE sub_prod_id = $d  LIMIT 1"));

                    if($result['sub_prod_type'] == 'Notifications') { 
                        $color = 'purple'; 
                        if($result['sub_prod_name'] == 'Circular') {
                           $sub_prod_type = "Cir"; 
                        } else {
                        $sub_prod_type = "Noti";
                      }
                    }

                    else if($result['sub_prod_type'] == 'Acts') { $color = 'muted'; $sub_prod_type = "Acts"; }

                    else if($result['sub_prod_type'] == 'Judgements') { $color = 'fuchsia'; $sub_prod_type ="Judge";}

                    else { $color = 'yellow'; $sub_prod_type = ''; }



                return '<span class="badge bg-'.$color.'">'.$sub_prod_type.'</span>';        

            }

    ),

 	array( 

        'db' => 'sub_subprod_id', 

        'dt' => 'sub_subprod',

        'formatter' => function( $d, $row ) {

                if($d == 'Tariff') { $sub_subprod_Name = "T";  }
                else if($d == 'Non-Tariff') { $sub_subprod_Name = "NT"; }
                else if($d == 'Circulars') { $sub_subprod_Name = "Cir"; }
                else if($d == 'Safeguards') { $sub_subprod_Name = "SG"; }
                else if($d == 'Instructions') { $sub_subprod_Name = "Ins"; }
                else if($d == 'Anti Dumping Duty') { $sub_subprod_Name ="ADT";}
                else if($d == 'Others') { $sub_subprod_Name ="Oth";}
                else if($d == 'Notification') { $sub_subprod_Name ="Noti";}
                else if($d == 'Rate Notification') { $sub_subprod_Name ="Rate";}
                else {  $sub_subprod_Name = ''; }

                return '<span class="badge bg-muted" style="padding-right: 10px;">'.$sub_subprod_Name.'</span>';    

            }

    ),

    array( 'db' => 'file_path', 'dt' => 'file_path' ),
    array( 'db' => 'tmi_reference', 'dt' => 'tmi_reference' )    

);





if (isset($_GET['start_date']) && isset($_GET['end_date'])) {



    if(isset($_GET['sub_prod_id']) && $_GET['sub_prod_id'] != '0') {

        $whereAll = ' (circular_date BETWEEN  "'.$_GET['start_date'].'" AND  "'.$_GET['end_date'].'")' . " AND sub_prod_id='".$_GET['sub_prod_id']."'";

    } else {

        $whereAll = ' (circular_date BETWEEN  "'.$_GET['start_date'].'" AND  "'.$_GET['end_date'].'")';

    }



} else if (isset($_GET['sub_prod_id']) || isset($_GET['party_name'])) {



    $sub_prod_id = isset($_GET['sub_prod_id']) ? $_GET['sub_prod_id'] : '0';

    $party_name = isset($_GET['party_name']) ? $_GET['party_name'] : '';



    if($sub_prod_id != '0' && $party_name != '') {

        $whereAll = " sub_prod_id='".$sub_prod_id."' AND party_name like '%".$party_name."%'";

    } else if($sub_prod_id != '0') {

        $whereAll = " sub_prod_id='".$sub_prod_id."'";

    } else if($party_name != '') {

        $whereAll = " party_name like '%".$party_name."%'";

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
