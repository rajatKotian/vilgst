<?php
include('../conn.php');

$table = 'search_history';

$primaryKey = 'search_id';

$columns = array(

    array( 'db' => 'search_id', 'dt' => 'id' ),

    array( 'db' => 'user_id', 'dt' => 'userID' ),

    array(

        'db'        => 'search_id',

        'dt'        => 'encrypt_id',

        'formatter' => function( $d, $row ) {

            return base64_encode(base64_encode($d));
        }

    ),

    array( 'db' => 'user_name', 'dt' => 'Name' ),

    array(

        'db'        => 'keyword',

        'dt'        => 'Key',

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

        'db'        => 'party_name',

        'dt'        => 'Party',

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

        'db'        => 'topic',

        'dt'        => 'Topic',

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

    
    array( 'db' => 'pagename', 'dt' => 'Page' ),


    array( 'db' => 'search_in', 'dt' => 'Search' ),

    array( 'db' => 'row_count', 'dt' => 'Row' ),

    array(

        'db'        => 'updated_dt',

        'dt'        => 'date',

        'formatter' => function( $d, $row ) {

          return date( 'd-M-Y', strtotime($d));

        }

    ),

);

if (isset($_GET['start_date']) && isset($_GET['end_date'])) {

    if(isset($_GET['sub_prod_id']) && $_GET['sub_prod_id'] != '0') {

        $whereAll = ' (updated_dt BETWEEN  "'.$_GET['start_date'].'" AND  "'.$_GET['end_date'].'")' . " AND sub_prod_id='".$_GET['sub_prod_id']."'";

    } else {

        $whereAll = ' (updated_dt BETWEEN  "'.$_GET['start_date'].'" AND  "'.$_GET['end_date'].'")';

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

?>