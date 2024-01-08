<?php

//echo "you called me";die;
$page = 'explorerAjax';
include('conn.php');
include('functions.php');
include('mapping_functions.php');
// error_reporting(E_ALL);
// ini_set('display_errors','on');
include('explorer-functions.php');

//verifying that call is coming from valid sources - validating csfrtoken from session.
//echo "i mhere";
//die;
$csrfToken = trim($_REQUEST['csrf-token_explorer']);
//echo $_SESSION['explorer_csrf_token'] . ":" . $csrfToken;
$valid_prod_ids = array('cgst' => '10', 'gst' => '3', 'sgst' => '7', 'igst' => '9');
$response = array();
$response['success'] = false;
$response['msg'] = '';
$response['data'] = '';
if ($csrfToken == $_SESSION['explorer_csrf_token']) {
    if (isset($_POST['gst_prod_name']) && $_POST['gst_prod_name'] != '') {
        $pan1Selection = $_POST['gst_prod_name'];
        if (array_key_exists($pan1Selection, $valid_prod_ids)) {
            // echo $valid_prod_ids[$pan1Selection];die;
            $explorer_pan_data = getProdDataForExplorer($valid_prod_ids[$pan1Selection], $pan1Selection);
//            echo json_encode($explorer_pan_data);die;
            $response['success'] = true;
            $response['msg'] = 'data found';
            $response['data'] = $explorer_pan_data;
        } else {
            $response['msg'] = 'invalid product name provided';
        }
    }
} else {
    $response['msg'] = 'invalid csrf token';
    die;
}

if ($csrfToken == $_SESSION['explorer_csrf_token']) {
    if (isset($_POST['gst_prod_name']) && $_POST['gst_prod_name'] != '') {
        $pan1Selection = $_POST['gst_prod_name'];
        if (isset($_POST['sub_prod_id5'])) {
            $decryptID = $_POST['sub_prod_id5'];
            if (array_key_exists($pan1Selection, $valid_prod_ids)) {
                // echo $valid_prod_ids[$pan1Selection];die;
                $expand_pan_data = getsimilarDataForExplorer($valid_prod_ids[$pan1Selection], $pan1Selection, $decryptID);
    //            echo json_encode($expand_pan_data);die;
                $response['success'] = true;
                $response['msg'] = 'data found';
                $response['data'] = $expand_pan_data;
            } else {
                $response['msg'] = 'invalid data provided';
            }
        }
    }
} else {
    $response['msg'] = 'invalid csrf token';
    die;
}

                    
ouptutJsonData($response);
die;