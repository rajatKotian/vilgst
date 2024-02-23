<?php

//echo "hello"; die();

include('../conn.php');

 

$table = 'gst_rate_hsn';

 

$primaryKey = 'id';

 

$columns = array(

    array( 'db' => 'id', 'dt' => 'id' ),

    array( 'db' => 'hsn_code', 'dt' => 'hsn_code' ),

    array(  'db' => 'desc', 
            'dt' => 'desc',

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
);



if (isset($_GET['start_date']) && isset($_GET['end_date'])) {
	//echo "hello"; die();

    $whereAll = ' (article_date BETWEEN  "'.$_GET['start_date'].'" AND  "'.$_GET['end_date'].'")';



} else {
	//echo "hellonnnnn"; die();
    $whereAll = NULL;

}



require( 'scripts/ssp.class.php' );

 

echo json_encode(

 	SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, $whereResult = null, $whereAll)

);



?>
