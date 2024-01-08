<?php

include('../conn.php');
include('../functions.php');

set_time_limit(0);
//  ini_set('display_errors', 1);
//     ini_set('display_startup_errors', 1);
//     error_reporting(E_ALL); 
    
// exit('completed all processes... bye.');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
//get records from ce
// tables to process
// $tables_to_process = array('casedata_ce' => array('ce', 4), 'casedata_sgst' => array('sgst', 7), 'casedata_cu' => array('cu', 5), 'casedata_vat' => array('vat', 1), 'casedata_st' => array('st', 2));
//  $tables_to_process = array('casedata_cgst' => array('cgst', 7));

$prod_ids = getProducts();

$subProducts = getSubProducts();

function getSubProducts() {
    global $con;
    $subproductlistquery = "select sub_prod_id, prod_id, sub_prod_name, sub_prod_type from sub_product";
    $result1 = mysqli_query($GLOBALS['con'],$subproductlistquery);
    $subProductIds = '';
    $subProdIds = array();
    while ($r = mysqli_fetch_array($result1)) {
        $subProdIds[$r['sub_prod_id']] = $r;
    }

    return $subProdIds;
}

function getProducts() {
    global $con;
    $productlistquery = "select * from product";
    $result1 = mysqli_query($GLOBALS['con'],$productlistquery);
    // $subProductIds = '';
    $ProdIds = array();
    while ($r = mysqli_fetch_array($result1)) {
        $ProdIds[$r['prod_id']] = $r['dbsuffix'];
    }

    return $ProdIds;
}

// $tables_to_process = array('casedata_igst' => array('igst', 9));
    // $tables_to_process = array('casedata_utgst' => array('utgst', 8));
    
$tables_to_process = array('casedata_ce' => array('ce', 4), 
    'casedata_sgst' => array('sgst', 7), 
    'casedata_cu' => array('cu', 5), 
    'casedata_vat' => array('vat', 1), 
    'casedata_st' => array('st', 2)
    ,'casedata_cgst' => array('cgst', 10)
    ,'casedata_dgft' => array('dgft', 6)
    ,'casedata_utgst' => array('utgst', 8)
    ,'casedata_igst' => array('igst', 9)
);

// $tables_to_process = array('casedata_cgst' => array('cgst', 10));
// $tables_to_process = array('casedata_dgft' => array('dgft', 6));
$caseCounter = 0;

foreach ($tables_to_process as $tablename => $table_data) {
   
//    print_r($tablename);
//    print_r($table_data);
    //get the records in the ce and try to identify the files.
    //get subproduct ids for this table
    $selectsubProductsQuery = "SELECT sub_prod_id FROM `sub_product` where prod_id=" . $table_data[1] . " AND `active_flag` = 'Y'";
    $result1 = mysqli_query($GLOBALS['con'],$selectsubProductsQuery);

  
    $subProductIds = '';
    while ($r = mysqli_fetch_array($result1)) {
        if ($subProductIds != '') {
            $subProductIds .=", ";
        }
        $subProductIds .= $r['sub_prod_id'];
    }
    
    $recordsPerLoop = 10;
    
    //getting totoal count of records
    $countQuery = "SELECT count(*) as 'total_records' FROM `$tablename` where sub_prod_id IN ($subProductIds) AND `updated_dt` > DATE_ADD(NOW(), INTERVAL -1 DAY) Order by data_id desc";
    //$countQuery = "SELECT count(*) as 'total_records' FROM `$tablename` where sub_prod_id IN ($subProductIds) AND `updated_dt` > '2020-09-13' Order by data_id desc";
    $countResult = mysqli_query($GLOBALS['con'],$countQuery);
    $countRow = mysqli_fetch_array($countResult);
    $totalRecords = $countRow['total_records'];
    echo "<pre>";
    
    echo "<br>Total Records Found for $tablename :" . $totalRecords . "<br>";
    echo     $countQuery ;
    for ($i = 0; $i < $totalRecords; $i = $i + $recordsPerLoop) {
        $selectRecordsQuery = "SELECT data_id, sub_prod_id, file_path, active_flag FROM `$tablename` where sub_prod_id IN ($subProductIds) AND `updated_dt` > DATE_ADD(NOW(), INTERVAL -1 DAY) Order by data_id desc LIMIT $i, $recordsPerLoop";
        //$selectRecordsQuery = "SELECT data_id, sub_prod_id, file_path, active_flag FROM `$tablename` where sub_prod_id IN ($subProductIds) AND `updated_dt` > '2020-09-13' Order by data_id desc LIMIT $i, $recordsPerLoop";
        $result = mysqli_query($GLOBALS['con'],$selectRecordsQuery);
        $records_found = mysqli_num_rows($result);
        echo  $selectRecordsQuery;
        $caseCounter1=0;
        if ($records_found > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $doc_root = getenv("DOCUMENT_ROOT") . "/";
                $folder_path = $doc_root;
                $file_name = $row['file_path'];
                if (file_exists($folder_path . $file_name)) {
//                    echo "<br>File found: ". $folder_path . $file_name . "<br>";
//                    print_r(array($row['data_id'], 'ce', $folder_path . $file_name));
//                    die;
                    $data_sub_prod_type = $subProducts[$row['sub_prod_id']]['sub_prod_type'];
                    $data_sub_prod_name = $subProducts[$row['sub_prod_id']]['sub_prod_name'];
                    process_document($row['data_id'], $data_sub_prod_type, $data_sub_prod_name, $table_data[0], $folder_path . $file_name, $subProducts, $prod_ids);
                    $caseCounter++;
                    $caseCounter1++;
                    // exit();
                } else {
                    echo "<br> File not found:" . $folder_path . $file_name;
                }
                // exit();
            }
        }
    }
    
    echo "<br>Total Records Processed for $tablename: " . $caseCounter;
    echo "<br>Total Records Processed until now: " . $caseCounter1;
    
    echo "<hr>";
    
}

function process_document($data_id, $data_sub_prod_type, $data_sub_prod_name, $data_prod_type, $filepath, $subProductsArray, $prod_ids) {
    
    global $con;
    $urlContent = file_get_contents($filepath);

    $dom = new DOMDocument();
    @$dom->loadHTML($urlContent);
    $xpath = new DOMXPath($dom);
    $hrefs = $xpath->evaluate("/html/body//a");
   
    $dataInfo = array();

    $validTypeArray = array('cu', 'cgst', 'ce', 'igst', 'dgft', 'vat', 'sgst', 'gst', 'st', 'utgst');

    for ($i = 0; $i < $hrefs->length; $i++) {
        $href = $hrefs->item($i);
        $url = $href->getAttribute('href');
        $text = $href->nodeValue;
       
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $pUrl = parse_url($url);
        if (isset($pUrl['query']) && $pUrl['query'] != '' && !in_array($text, array('<<Previous','Next>>'))) {
            $querypart = explode('&', $pUrl['query']);

            $qp1 = explode("=", $querypart[0], 2);
            $type='';
            if ($qp1[0] == 'V1Zaa1VsQlJQVDA9') {
                $rowid = base64_decode(base64_decode($qp1[1]));
                if (isset($querypart[1]) && $querypart[1] != '') {
                    $qp2 = explode("=", $querypart[1], 2);
                    if (isset($qp2[1]) && $qp2[1] != '') {
                        $type = str_replace(".", "", $qp2[1]);
                        $fulltype = "`casedata_' . $type . '`";
                    } else if($qp2[0]!='showCOIarticles') {
                        $type = 'vat';
                        $fulltype = 'vat_data';
                    }
                } else {
                    $type = 'vat';
                    $fulltype = 'vat_data';
                }

                if (in_array($type, $validTypeArray)) {


                    if ($fulltype != 'vat_data') {
                        $getcasedetails = 'SELECT data_id, prod_id, sub_prod_id from `casedata_' . $type . '` where data_id = ' . $rowid;
                    } else {
                        $getcasedetails = 'SELECT vat_data_id as data_id, prod_id, sub_prod_id from `' . $fulltype . '` where vat_data_id = ' . $rowid;
                    }

                    $resultcasedata = mysqli_query($GLOBALS['con'],$getcasedetails);
                    if (mysqli_num_rows($resultcasedata) > 0) {
                     

                        $recordCaseRow = mysqli_fetch_array($resultcasedata);
                        $type = $prod_ids[$recordCaseRow['prod_id']];
                        $sub_prod_id = $recordCaseRow['sub_prod_id'];
                        $prodtype = $subProductsArray[$sub_prod_id]['sub_prod_type'];
                        $type_name = $subProductsArray[$sub_prod_id]['sub_prod_name'];
                        $dataInfo[] = array('ref_id' => $rowid, 'ref_type' => $prodtype, 'ref_prod_name' => $type, 'ref_sub_prod_name' => $type_name);

                    } else {
                        echo "<br>No Records found Debug Info:<br>
                            data id: " . $data_id . " <br>
                            reference id: " . $rowid . "<br>
                            Filepath:" . $filepath . " <br>
                            SQL:" . $getcasedetails . "<br>
                            URL:" . $url . "<br>
                            Text:" . $text . "<hr>";
                    }
                }
            }
        }
    }

    //print_r($dataInfo);
    //datainfo array, data id, 'judgement/notifications etc','notification, circular, high court case', 'cu, cgst, igft, dgft'
    
    $deletedrecords = removeMappingData($data_id, $data_sub_prod_type, $data_sub_prod_name, $data_prod_type);
    $addedRecords = addMappingData($dataInfo, $data_id, $data_sub_prod_type, $data_sub_prod_name, $data_prod_type);
    echo "<br><br> Enteries for: for $data_id, $data_sub_prod_type, $data_sub_prod_name, $data_prod_type:--<bt>";
    echo "Deleted: " . $deletedrecords;
    echo "Added: " . $addedRecords;
    
   

    // echo "<br>New Entries for $data_id, $data_sub_prod_type, $data_sub_prod_name, $data_prod_type are deleted : " . $deletedrecords;


//    return $caseInfo;
}

function removeMappingData($data_id, $data_sub_prod_type, $data_sub_prod_name, $data_prod_name) {
        global $con;
    //array('ref_id' => $rowid, 'ref_type' => $prodtype, 'ref_prod_name' => $type, 'ref_sub_prod_name' => $type_name);
    $deleteQuery = "DELETE from mapping where 
                data_id = " . $data_id . "
                AND data_type = '" . $data_sub_prod_type . "'
                AND data_prod_name = '" . $data_prod_name . "'
                AND data_sub_prod_name = '" . $data_sub_prod_name . "'";
    // echo $deleteQuery;die;
    $result=mysqli_query($GLOBALS['con'],$deleteQuery);
    return mysqli_affected_rows($result);
}

//datainfo array, data id, 'judgement/notifications etc','notification, circular, high court case', 'cu, cgst, igft, dgft'
function addMappingData($references, $data_id, $data_sub_prod_type, $data_sub_prod_name, $data_prod_name) {
        global $con;
    $t_record_added = 0;
    if (is_array($references) && count($references) > 0) {
        foreach ($references as $reference) {
            //array('ref_id' => $rowid, 'ref_type' => $prodtype, 'ref_prod_name' => $type, 'ref_sub_prod_name' => $type_name);
            $selectQuery = "select count(*) as 'total_records' from mapping where 
                reference_id=" . $reference['ref_id'] . " 
                AND reference_type='" . $reference['ref_type'] . "' 
                AND reference_prod_name='" . $reference['ref_prod_name'] . "'
                AND reference_sub_prod_name='" . $reference['ref_sub_prod_name'] . "'
                AND data_id = " . $data_id . "
                AND data_type = '" . $data_sub_prod_type . "'
                AND data_prod_name = '" . $data_prod_name . "'
                AND data_sub_prod_name = '" . $data_sub_prod_name . "'";

            // echo $selectQuery;
            // echo "<br>";
            $selectResult = mysqli_query($GLOBALS['con'],$selectQuery);
            $countRow1 = mysqli_fetch_array($selectResult);
            // print_r($countRow1);
            // echo "<br><hr>";
            if($countRow1['total_records'] == 0) {
                $columns = "(`data_id`,`data_type`,`data_prod_name`,`data_sub_prod_name`,`reference_id`,`reference_type`,`reference_prod_name`,`reference_sub_prod_name`)";
                $values = "($data_id, '$data_sub_prod_type', '$data_prod_name', '$data_sub_prod_name', " . $reference['ref_id'] . ", '" . $reference['ref_type'] . "', '" . $reference['ref_prod_name'] . "', '" . $reference['ref_sub_prod_name'] . "')";
                $insertQuery = "insert into mapping " . $columns . " values " . $values;
                mysqli_query($GLOBALS['con'],$insertQuery);
                $t_record_added++;
            }
        }
    }
    return $t_record_added;
}