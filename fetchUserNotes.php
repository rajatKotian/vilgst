<?php
      ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
// ajax-partyName-search.php
$user_id = $_SESSION["id"];
$prod_id = isset($_POST['prod_id']) ? $_POST['prod_id'] : '8';
$sub_prod_id = isset($_POST['sub_prod_id']) ? $_POST['sub_prod_id'] : '68';

$content = $_POST['content'];
$cond =  "(user_id = '" . $user_id . "' AND prod_id = '" . $prod_id . "' AND sub_prod_id = '" . $sub_prod_id . "')";

$query = "
SELECT * FROM user_notes
    WHERE $cond
    LIMIT 1
";


$response = array('message' => 'Content saved successfully '.$user_id." ".$query);
echo json_encode($response);
?>

