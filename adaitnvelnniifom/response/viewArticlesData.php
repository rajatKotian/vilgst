<?php



include('../conn.php');

 

$table = 'articles';

 

$primaryKey = 'article_id';

 

$columns = array(

    array( 'db' => 'article_id', 'dt' => 'id' ),

    array(

        'db'        => 'article_date',

        'dt'        => 'date',

        'formatter' => function( $d, $row ) {

          return date( 'd-M-Y', strtotime($d));

        }

    ),

    array( 'db' => 'subject', 'dt' => 'subject' ),

    array(  'db' => 'summary', 
            'dt' => 'summary',
            'formatter' => function( $d, $row ) {

                return stripslashes($d);

            }
     ),

    array( 'db' => 'file_path', 'dt' => 'file_path' ),

    array(

        'db'        => 'new_flag',

        'dt'        => 'new_flag',

        'formatter' => function( $d, $row ) {

                if($d == 'Y') { 

                    return '<span class="badge bg-orange">New</span>';  

                }

 

        }

    ),    

    array( 'db' => 'author', 'dt' => 'author' ),
    array( 'db' => 'category', 'dt' => 'category' ),

    array(

        'db'        => 'article_id',

        'dt'        => 'encrypt_id',

        'formatter' => function( $d, $row ) {

            return base64_encode(base64_encode($d));

        }

    )

);



if (isset($_GET['start_date']) && isset($_GET['end_date'])) {



    $whereAll = ' (article_date BETWEEN  "'.$_GET['start_date'].'" AND  "'.$_GET['end_date'].'")';



} else {

    $whereAll = NULL;

}



require( 'scripts/ssp.class.php' );

 

echo json_encode(

 	SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, $whereResult = null, $whereAll)

);



?>
