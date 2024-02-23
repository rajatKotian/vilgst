<?php session_start(); 
ini_set('display_errors', 0);
ob_start(); 
ini_set('upload_max_filesize','25M');
include_once('../mysql2i.class.php');
/* Localhost */
// $gaSql['user']       = "root";
// $gaSql['password']   = "";
// $gaSql['db']         = "vilgst12_vilgstprod";
// $gaSql['server']     = "localhost";

/* Server  */
$gaSql['user']       = "vilgstnewmay_new_user";
$gaSql['password']   = "!e_Z38]cTAmY";
$gaSql['db']         = "vilgstnewmay_vilgstprod";
$gaSql['server']     = "localhost";

// $gaSql['user']       = "vilgst12_new";
// $gaSql['password']   = "Tjew7=Ag)OuO";
// $gaSql['db']         = "vilgst12_vilgstprod";
// $gaSql['server']     = "localhost";

// $db_pwd = 'Tjew7=Ag)OuO';
// $db_user = 'vilgst12_new';
// $database = 'vilgst12_vilgstprod';

$sql_details = array(
    'user' => $gaSql['user'],
    'pass' => $gaSql['password'],
    'db'   => $gaSql['db'],
    'host' => $gaSql['server']
);

function fatal_error ( $sErrorMessage = '' ) {
    header( $_SERVER['SERVER_PROTOCOL'] .' 500 Internal Server Error' );
    die( $sErrorMessage );
}
      
/* MySQL connection */
$con=mysqli_connect( $gaSql['server'], $gaSql['user'], $gaSql['password'],$gaSql['db'] );
// print_r($GLOBALS['con']);
if ( ! $gaSql['link'] = $con ) {
    fatal_error( 'Could not open connection to server' );
}



// if ( ! mysqli_select_db( $gaSql['db'], $gaSql['link'] ) ) {
//     fatal_error( 'Could not select database ' );
// }
/*mysql_query ( "set character_set_client='utf8'" );
mysql_query ( "set character_set_results='utf8'" );
mysql_query ( "set collation_connection='utf8_unicode_ci'" );
*/ 
mysqli_set_charset($con,"utf8");

if(isset($_SESSION['user']) && ($_SESSION['type'] == 'A')  && ($_SESSION['login'] == 'qwert')) {
	
	if( $_SESSION['last_activity'] < time()-$_SESSION['expire_time'] ) {  
		$_SESSION['status']='out';
		header('Location: logout.php'); //redirect to logout.php 
	} else {  
		$_SESSION['last_activity'] = time(); //this was the moment of last activity.
		$_SESSION['status']='in';
		if(isset($pageType) && $pageType=='login') {
			header('Location: index.php');
		}
	}
} else {
	if(isset($pageType) && $pageType!='login') {
		header('Location: login.php');
	}
}

// Get the protocol used for the current request
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';

// Get the domain name
$domain = $_SERVER['HTTP_HOST'];

// Combine the protocol and domain name to form the URL
$url = $protocol . '://' . $domain.'/';
$common_base_url=$url;
	
?>
<?php include('functions.php'); ?>

