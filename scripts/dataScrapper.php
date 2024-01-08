<?php

exit("Do not use this file again");

include('../conn.php');
include('../functions.php');
error_reporting(E_ALL);
ini_set('display_errors', 'on');

set_time_limit(0);

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
//get records from ce
//tables to process
// $tables_to_process = array('casedata_ce' => array('ce', 4), 'casedata_sgst' => array('sgst', 7), 'casedata_cu' => array('cu', 5), 'casedata_vat' => array('vat', 1), 'casedata_st' => array('st', 2));
// $tables_to_process = array('casedata_ce' => array('sgst', 7));

$prod_ids = getProducts();

$subProducts = getSubProducts();

function getSubProducts() {
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
    $productlistquery = "select * from product";
    $result1 = mysqli_query($GLOBALS['con'],$productlistquery);
    // $subProductIds = '';
    $ProdIds = array();
    while ($r = mysqli_fetch_array($result1)) {
        $ProdIds[$r['prod_id']] = $r['dbsuffix'];
    }
    
    return $ProdIds;
}


$tables_to_process = array('casedata_vat' => array('vat', 1));
$caseCounter = 0;

foreach ($tables_to_process as $tablename => $table_data) {
//    print_r($tablename);
//    print_r($table_data);
    //get the records in the ce and try to identify the files.
    //get subproduct ids for this table
    $selectsubProductsQuery = "SELECT sub_prod_id FROM `sub_product` where prod_id=" . $table_data[1] . " AND sub_prod_type='Judgements' AND `active_flag` = 'Y'";
    $result1 = mysqli_query($GLOBALS['con'],$selectsubProductsQuery);
    $subProductIds = '';
    while ($r = mysqli_fetch_array($result1)) {
        if ($subProductIds != '') {
            $subProductIds .=", ";
        }
        $subProductIds .= $r['sub_prod_id'];
    }
    $recordsPerLoop = 100;
    $numberOfLoops = 39;
    // $maxRecords = 4600;
    for ($i = 0; $i < ($numberOfLoops * $recordsPerLoop); $i = $i + $recordsPerLoop) {
        $selectRecordsQuery = "SELECT data_id, file_path, active_flag FROM `$tablename` where `active_flag` = 'Y' and sub_prod_id IN ($subProductIds) Order by data_id desc LIMIT $i, $recordsPerLoop";
        //$selectRecordsQuery = "SELECT data_id, file_path, active_flag FROM `$tablename` where `active_flag` = 'Y' and sub_prod_id IN ($subProductIds) AND data_id=20235 Order by data_id desc";
        $result = mysqli_query($GLOBALS['con'],$selectRecordsQuery);
        $records_found = mysqli_num_rows($result);
        echo "<pre>";
        // echo "<br>Total Records Found:" . $records_found;
        if ($records_found > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $doc_root = getenv("DOCUMENT_ROOT") . "/";
                $folder_path = $doc_root;
                $file_name = $row['file_path'];
                if (file_exists($folder_path . $file_name)) {
//                    echo "<br>File found: ". $folder_path . $file_name . "<br>";
//                    print_r(array($row['data_id'], 'ce', $folder_path . $file_name));
//                    die;
                    $caseInfo = process_document($row['data_id'], $table_data[0], $folder_path . $file_name, $subProducts, $prod_ids);
                    $caseCounter++;
                    // exit();
                } else {
                    echo "<br> File not found:" . $folder_path . $file_name;
                    
                }
                // exit();
            }
        }
    }
    echo "Total Cases Processed: " . $caseCounter;
}

function process_document($case_id, $case_type, $filepath, $subProductsArray, $prod_ids) {

//    $doc_root = getenv("DOCUMENT_ROOT");
//    $folder_path = $doc_root . "vilgst/samplefiles/";
//    $file_name = '2020-VIL-129-AAR.htm';
    $urlContent = file_get_contents($filepath);

    $dom = new DOMDocument();
    @$dom->loadHTML($urlContent);
    $xpath = new DOMXPath($dom);
    $hrefs = $xpath->evaluate("/html/body//a");

    $caseInfo = array();

    $caseId = $case_id;
//    $caseName = '2020-VIL-129-AAR';
    $datatable = array();

    $cites = array();
    $notifications = array();
    $rules = array();
    $sections = array();
    $unknown = array();
    $circulars = array();

    $validTypeArray = array('cu', 'cgst', 'ce', 'igst', 'dgft', 'vat', 'sgst', 'gst', 'st', 'utgst');

    for ($i = 0; $i < $hrefs->length; $i++) {
        $href = $hrefs->item($i);
        $url = $href->getAttribute('href');
        $text = $href->nodeValue;

        $url = filter_var($url, FILTER_SANITIZE_URL);
        $pUrl = parse_url($url);
        if (isset($pUrl['query']) && $pUrl['query'] != '') {
            $querypart = explode('&', $pUrl['query']);

            $qp1 = explode("=", $querypart[0], 2);
            if ($qp1[0] == 'V1Zaa1VsQlJQVDA9') {
                $rowid = base64_decode(base64_decode($qp1[1]));
                if(isset($querypart[1]) && $querypart[1]!=''){
                    $qp2 = explode("=", $querypart[1], 2);
                    if(isset($qp2[1]) && $qp2[1]!=''){
                        $type = str_replace(".","",$qp2[1]);
                        $fulltype = "`casedata_' . $type . '`";
                    }else{
                        $type = 'vat';
                        $fulltype= 'vat_data';
                    }
                }else{
                    $type = 'vat';
                    $fulltype= 'vat_data';                    
                }
                
                if (in_array($type, $validTypeArray)) {
                
                
                    if($fulltype!='vat_data'){
                        $getcasedetails = 'SELECT data_id, prod_id, sub_prod_id from `casedata_' . $type . '` where data_id = ' . $rowid;
                    }else{
                        $getcasedetails = 'SELECT vat_data_id as data_id, prod_id, sub_prod_id from `'.$fulltype.'` where vat_data_id = ' . $rowid;
                    }
                    
                    $resultcasedata = mysqli_query($GLOBALS['con'],$getcasedetails);
                    $majorType = '';
                    if (mysqli_num_rows($resultcasedata) > 0) {
                        // print_r($recordCaseRow);
                        
                        $recordCaseRow = mysqli_fetch_array($resultcasedata);
                        $type = $prod_ids[$recordCaseRow['prod_id']];
                        $sub_prod_id = $recordCaseRow['sub_prod_id'];
                        $prodtype = $subProductsArray[$sub_prod_id]['sub_prod_type'];
                        $type_name = $subProductsArray[$sub_prod_id]['sub_prod_name'];
                        switch ($prodtype) {
                            case 'Judgements':
                                $majorType = 'case';
                                break;
                            case 'Notifications':
                                if ($type_name == 'Circular') {
                                    //cicular
                                    $majorType = 'circular';
                                } else if ($type_name == 'Notification' || $type_name == 'Notifications') {
                                    //notification
                                    $majorType = 'notification';
                                }
                                break;
                            case 'Acts':
                                if ($type_name == 'Acts') {
                                    //section
                                    $majorType = 'Section';
                                } else if ($type_name == 'Rules') {
                                    $majorType = 'Rule';
                                }
                        }
                    }else{
                        echo "<br>No Records found for Row id: " . $rowid . " <br>Debug: <br>caseID: ".$caseId ."<br>Filepath:".$filepath." <br>SQL:" . $getcasedetails . "<br>URL:".$url ."<br>Text:".$text."<hr>";
                    }
        
                    switch ($majorType) {
                        case 'case';
                            $cites[$type][$rowid] = $text;
                            break;
                        case 'notification':
                            $notifications[$type][$rowid] = $text;
                            break;
                        case 'circular':
                            $circulars[$type][$rowid] = $text;
                            break;
                        case 'Section':
                            $sections[$type][$rowid] = $text;
                            break;
                        case 'Rule':
                            $rules[$type][$rowid] = $text;
                            break;
                    }
                }
            }
        }
    }

    $caseInfo['caseid'] = $caseId;
//    $caseInfo['casename'] = $caseName;
    $caseInfo['cites'] = $cites;
    $caseInfo['notifications'] = $notifications;
    $caseInfo['rules'] = $rules;
    $caseInfo['circulars'] = $circulars;
    $caseInfo['sections'] = $sections;
    // $caseInfo['unknown'] = $unknown;

    // print_r($caseInfo);
//    print_r(array($caseId, $case_type));die;
    // addRecordToCites($cites, $caseId, $case_type);
    // addRecordToSections($sections, $caseId, $case_type);
    // addRecordToCirculars($circulars, $caseId, $case_type);
    // addRecordTNotification($notifications, $caseId, $case_type);
    // addRecordTRule($rules, $caseId, $case_type);

    return $caseInfo;
}

function addRecordToCites($cites, $caseId, $caseType) {
    if (is_array($cites) && count($cites) > 0) {
        foreach ($cites as $citeType => $citeCases) {
            foreach ($citeCases as $case => $caseText) {
//                $typearray = array('sgst', 'st', 'ce', 'vat');
                //checking if record is already exists
                $selectQuery = "Select * from mapping_case_cites where case_id= $caseId AND case_type = '$caseType' AND  cited_case_id = $case AND cited_case_type = '$citeType'";
                $selectResult = mysqli_query($GLOBALS['con'],$selectQuery);
                $foundRecords = mysqli_num_rows($selectResult);
                if ($foundRecords < 1) {
                    $sqlQuery = "insert into mapping_case_cites (case_id, case_type, cited_case_id,cited_case_type) values($caseId, '$caseType', $case, '$citeType')";
                    //echo "<br>" . $sqlQuery;
                    mysqli_query($GLOBALS['con'],$sqlQuery);
                } else {
                    //echo "<br>Record already exists: " . $caseId, '$caseType', $case, '$citeType';
                }
            }
        }
    }
}

function addRecordToSections($sections, $caseId, $caseType) {
    if (is_array($sections) && count($sections) > 0) {
        foreach ($sections as $sectionType => $section_datas) {
            foreach ($section_datas as $section => $sectionText) {
//                $typearray = array('sgst', 'st', 'ce', 'vat');
                //checking if record is already exists
                $selectQuery = "Select * from mapping_case_sections where case_id= $caseId AND case_type = '$caseType' AND  section_id = $section AND section_type = '$sectionType'";
                $selectResult = mysqli_query($GLOBALS['con'],$selectQuery);
                $foundRecords = mysqli_num_rows($selectResult);
                if ($foundRecords < 1) {
                    $sqlQuery = "insert into mapping_case_sections (case_id, case_type, section_id,section_type) values($caseId, '$caseType', $section, '$sectionType')";
                    //echo "<br>" . $sqlQuery;
                    mysqli_query($GLOBALS['con'],$sqlQuery);
                } else {
                    //echo "<br>Record already exists: " . $caseId, '$caseType', $case, '$citeType';
                }
            }
        }
    }
}

function addRecordToCirculars($circulars, $caseId, $caseType) {
    if (is_array($circulars) && count($circulars) > 0) {
        foreach ($circulars as $circularType => $circular_data) {
            foreach ($circular_data as $circular => $circularText) {
//                $typearray = array('sgst', 'st', 'ce', 'vat');
                //checking if record is already exists
                $selectQuery = "Select * from mapping_case_ciculars where case_id= $caseId AND case_type = '$caseType' AND  circular_id = $circular AND circular_type = '$circularType'";
                $selectResult = mysqli_query($GLOBALS['con'],$selectQuery);
                $foundRecords = mysqli_num_rows($selectResult);
                if ($foundRecords < 1) {
                    $sqlQuery = "insert into mapping_case_circulars (case_id, case_type, circular_id, circular_type) values($caseId, '$caseType', $circular, '$circularType')";
                    mysqli_query($GLOBALS['con'],$sqlQuery);
                } else {
                    //echo "<br>Record already exists: " . $caseId, '$caseType', $case, '$citeType';
                }
            }
        }
    }
}

function addRecordTNotification($notifications, $caseId, $caseType) {
    if (is_array($notifications) && count($notifications) > 0) {
        foreach ($notifications as $notificationType => $notification_data) {
            foreach ($notification_data as $notification => $Text) {
//                $typearray = array('sgst', 'st', 'ce', 'vat');
                //checking if record is already exists
                $selectQuery = "Select * from mapping_case_notifications where case_id= $caseId AND case_type = '$caseType' AND  notification_id = $notification AND notification_type = '$notificationType'";
                $selectResult = mysqli_query($GLOBALS['con'],$selectQuery);
                $foundRecords = mysqli_num_rows($selectResult);
                if ($foundRecords < 1) {
                    $sqlQuery = "insert into mapping_case_notifications (case_id, case_type, notification_id, notification_type) values($caseId, '$caseType', $notification, '$notificationType')";
                    mysqli_query($GLOBALS['con'],$sqlQuery);
                } else {
                    //echo "<br>Record already exists: " . $caseId, '$caseType', $case, '$citeType';
                }
            }
        }
    }
}

function addRecordTRule($rules, $caseId, $caseType) {
    if (is_array($rules) && count($rules) > 0) {
        foreach ($rules as $ruleType => $rule_data) {
            foreach ($rule_data as $rule => $Text) {
//                $typearray = array('sgst', 'st', 'ce', 'vat');
                //checking if record is already exists
                $selectQuery = "Select * from mapping_case_rule where case_id= $caseId AND case_type = '$caseType' AND  rule_id = $rule AND rule_type = '$ruleType'";
                $selectResult = mysqli_query($GLOBALS['con'],$selectQuery);
                $foundRecords = mysqli_num_rows($selectResult);
                if ($foundRecords < 1) {
                    $sqlQuery = "insert into mapping_case_rule (case_id, case_type, rule_id, rule_type) values($caseId, '$caseType', $rule, '$ruleType')";
                    mysqli_query($GLOBALS['con'],$sqlQuery);
                } else {
                    //echo "<br>Record already exists: " . $caseId, '$caseType', $case, '$citeType';
                }
            }
        }
    }
}

//$string = 'sec. u/s 120 12/2017 - Central Tax';
//echo checkForSynonims($string, $section_synonims);

function contains_substr($mainStr, $str, $loc = false) {
    $mainStr = strtolower($mainStr);
    if ($loc === false)
        return (strpos($mainStr, $str) !== false);
    if (strlen($mainStr) < strlen($str))
        return false;
    if (($loc + strlen($str)) > strlen($mainStr))
        return false;
    return (strcmp(substr($mainStr, $loc, strlen($str)), $str) == 0);
}

function checkForSynonims($text, $synonims) {
    $text = strtolower($text);
    foreach ($synonims as $synonim) {
//        echo $text . "<br>" . $synonim . "<br>";
        if (strpos($text, $synonim) !== false) {
//            echo "Found: " . $text . " :: " . $synonim . "<br>";
            return true;
        }
    }
    return false;
}