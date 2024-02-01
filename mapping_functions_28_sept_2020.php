<?php

include('conn.php');

// include('functions.php');
//error_reporting(E_ALL);
//ini_set('display_errors', 'on');



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

/**
 * Returns unique array of sections/rules by removing strings, converting upto sub level 1
 * @param type $sectionString
 * @param type $dataType section/rule
 * @return type array
 */
function getCleanSectionRules($sectionString, $dataType = 'section') {

    $sectionString = strtolower($sectionString); //converting lowercase
    //remove section string fromt he string.
    $sectionString = str_replace($dataType, '', $sectionString);
    // $sectionString = str_replace('schedule', '', $sectionString);
    //trim from both side
    $sectionString = trim($sectionString);

    //converting to array by saperating through comma
    $sections = explode(',', $sectionString);

    $finalSectionArray = array();
    foreach ($sections as $section) {
        //remove simple 2 if any
        $newSection = trim($section);

//        if ($dataType == 'section') {
//            if ($newSection == '2') {
//                $newSection = '';
//            }
//        }
        //keep data upto one bracket only;
        $firstOpening_brace = strpos($newSection, '(', 0);
        $firstClosing_brace = strpos($newSection, ')', 0);
        if ($firstOpening_brace && $firstClosing_brace) {
            $newSection = substr($newSection, 0, $firstClosing_brace + 1);
        }

        if (!in_array($newSection, array_values($finalSectionArray))) {
            $finalSectionArray[] = $newSection;
        }
    }
    return $finalSectionArray;
}

function getOnlyRelatedActs($string, $actNo, $actType = 'section') {
    $exploded_array = explode(',', $string);
    // print_r($exploded_array);
    // echo "<br>";
    $finalSecArray = array();
    foreach ($exploded_array as $secString) {
        $cleanStr = getCleanSectionRules($secString, $actType);
        // print_r($cleanStr[0]);
        if (strpos($cleanStr[0], "(")) {
           $mainSec = trim(substr($cleanStr[0], 0, strpos($cleanStr[0], "("))) ;
          
        } else {
            $mainSec = trim($cleanStr[0]);
        }
        // echo $mainSec .":". $actNo . ":". $cleanStr[0] . "<br>";
        if ($mainSec == $actNo) {
            $finalSecArray[] = $cleanStr[0];
        }
    }
    // die;
    // print_r($finalSecArray);die;
    return $finalSecArray;
}

function getCommonRowData($row2, $reference_prod_name) {
    $c_date = date("Y-m-d", strtotime($row2['circular_date']));

    $rowtemp['display_name'] = "<b style='color:#777777'>" . $row2['circular_no'] . " [" . $c_date . "]</b> <br><span style='color:#00008b'>" . $row2['party_name'] . "</span>";


    $rowtemp['title'] = substr($row2['cir_subject'], 0, 400);
    if(strlen($row2['cir_subject'])>0){
        $rowtemp['title'] .= "...";
    }

    $encryptId = base64_encode(base64_encode($row2['data_id']));
    $file_extn = strtolower(substr($row2['file_path'], -3));
    $rowtemp['file_link'] = $row2['file_path'];
    $rowtemp['party_name'] = $row2['party_name'];
    $rowtemp['file_ext'] = $file_extn;
    $rowtemp['perm_link'] = "showiframe?V1Zaa1VsQlJQVDA9=$encryptId&datatable=$reference_prod_name";
//    $rowtemp['type'] = $reference_type;
    return $rowtemp;
}

function customSort($a, $b) {

    if(strpos($a, "(")){
        $start_pos_a = strpos($a, "(");
        $end_pos_a = strpos($a, ")");
        $str_len_a = $end_pos_a - $start_pos_a;
        $x = substr($a, strpos($a, "(")+1, $str_len_a-1);
    }else{
        //$x = $a;
        return -1;
    }
    
    if(strpos($b, "(")){
        $start_pos_b = strpos($b, "(");
        $end_pos_b = strpos($b, ")");
        $str_len_b = $end_pos_b - $start_pos_b;
        $y = substr($b, strpos($b, "(")+1, $str_len_b-1);
    }else{
        //$y=$b;
        return 1;
    }
    
    if ($x == $y)
        return 0;
    return ($x < $y) ? -1 : 1;
}

function getSimilarCaseLaws($data_id, $data_type) {

    // error_reporting(E_ALL);
    // ini_set('display_errors', 'on');

    $data_type = strtolower($data_type);
    $tableName = 'casedata_' . $data_type;
    $primary_query = "SELECT  sub_prod_id, prod_id, section_no as cgst_section, rule_no as cgst_rule, igst_section_no, igst_rule_no FROM $tableName where data_id = $data_id";
    $result_primary = mysqli_query($GLOBALS['con'],$primary_query);
    $cgstSections = array();
    $igstSections = array();
    $cgstRules = array();
    $igstRules = array();
    $commonData = array();
    $commonDataByCase[] = array();

    $productsList = getProducts();

    while ($r = mysqli_fetch_assoc($result_primary)) {
        // print_r($r);die;
        $cgstSectionsStr = trim($r['cgst_section']);
        $igstSectionsStr = trim($r['igst_section_no']);
        $cgstRulesStr = trim($r['cgst_rule']);
        $igstRulesStr = trim($r['igst_rule_no']);
        $prod_id = trim($r['prod_id']);
        $sub_prod_id = trim($r['sub_prod_id']);

        if ($cgstSectionsStr != null && $cgstSectionsStr != '') {
            $cgstSections = getCleanSectionRules($cgstSectionsStr, 'section');
        }
        if ($igstSectionsStr != null && $igstSectionsStr != '') {
            $igstSections = getCleanSectionRules($igstSectionsStr, 'section');
        }
        if ($cgstRulesStr != null && $cgstRulesStr != '') {
            $cgstRules = getCleanSectionRules($cgstRulesStr, 'rule');
        }
        if ($igstRulesStr != null && $igstRulesStr != '') {
            $igstRules = getCleanSectionRules($igstRulesStr, 'rule');
        }
    }

    //prepare query now to get all the data
    $subproducts = getSubProducts();

    $currentSubProd = $subproducts[$sub_prod_id];
    $articleType = $currentSubProd['sub_prod_type'];
    $headerSectionName = 'SIMILAR CASES';
    if ($articleType == 'Judgements' || $articleType == 'Acts') {
    
    
        if($articleType=='Acts'){
            $headerSectionName = 'TAGGED CASELAWS';
        }
    
        $cgstSecionSearchSTR = '';
        foreach ($cgstSections as $cgstSec) {

            $cgstSecionSearchSTR = " data_id!=$data_id AND (";

            if ($articleType == 'Acts') {
                
                $cgstSecionSearchSTR .= " section_no LIKE '%, $cgstSec(%' ";
                $cgstSecionSearchSTR .= " OR section_no LIKE '$cgstSec(%' )";
            } else {

                if (strpos($cgstSec, ')')) {
                    $cgstSecionSearchSTR .= " section_no LIKE '%, $cgstSec(%' ";
                    $cgstSecionSearchSTR .= " OR section_no LIKE '$cgstSec(%' OR ";
                }

                $cgstSecionSearchSTR .= " section_no LIKE '%, $cgstSec,%' ";
                $cgstSecionSearchSTR .= " OR section_no LIKE '$cgstSec,%' ";
                $cgstSecionSearchSTR .= " OR section_no LIKE '%, $cgstSec' )";
            }
    
        if($_REQUEST['filterBy']=='Harshal'){
             echo   $getDataForThisRow = "Select section_no, data_id, prod_id, circular_no, circular_date, party_name, cir_subject, file_path from casedata_sgst where $cgstSecionSearchSTR order by circular_date desc";die;
        }else{
             $getDataForThisRow = "Select section_no, data_id, prod_id, circular_no, circular_date, party_name, cir_subject, file_path from casedata_sgst where $cgstSecionSearchSTR order by circular_date desc";
        }

            $result_primary = mysqli_query($GLOBALS['con'],$getDataForThisRow);
            // echo "<pre>";
            while ($r = mysqli_fetch_assoc($result_primary)) {
                // echo $r['section_no'] . "<br>";
                if ($articleType == 'Acts') {
                    $finalSections = getOnlyRelatedActs($r['section_no'], $cgstSec, $articleType);
                    $commonRowData = getCommonRowData($r, $productsList[$r['prod_id']]);
                    // print_r($finalSections) ;
                    // echo "<br><hr>";
                    foreach ($finalSections as $sec) {
                        $commonData['Section ' . $sec][] = $commonRowData;
                    }
                } else {
                    $commonData['CGST Section ' . $cgstSec][] = getCommonRowData($r, $productsList[$r['prod_id']]);
//                    $commonDataByCase[$r['data_id']] = getCommonRowData($r, $productsList[$r['prod_id']]);
                }
            }
            // die;
        }

        $cgstRuleSearchSTR = '';
        foreach ($cgstRules as $cgstRule) {

            $cgstRuleSearchSTR = " data_id!=$data_id AND (";

            if (strpos($cgstRule, ')')) {
                $cgstRuleSearchSTR .= " section_no LIKE '%, $cgstRule(%' ";
                $cgstRuleSearchSTR .= " OR section_no LIKE '$cgstRule(%' OR ";
            }

            $cgstRuleSearchSTR .= "  rule_no LIKE '%, $cgstRule,%' ";
            $cgstRuleSearchSTR .= " OR rule_no LIKE '$cgstRule,%' ";
            $cgstRuleSearchSTR .= " OR rule_no LIKE '%, $cgstRule' )";

            $getDataForThisRow = "Select rule_no, data_id, prod_id, circular_no, circular_date, party_name, cir_subject, file_path from casedata_sgst where $cgstRuleSearchSTR order by circular_date desc";

            $result_primary = mysqli_query($GLOBALS['con'],$getDataForThisRow);
            while ($r = mysqli_fetch_assoc($result_primary)) {

                if ($articleType == 'Acts') {
                    $finalSections = getOnlyRelatedActs($r['rule_no'], $cgstRule, $articleType);
                    $commonRowData = getCommonRowData($r, $productsList[$r['prod_id']]);
                    foreach ($finalSections as $sec) {
                        $commonData['Rule ' . $sec][] = $commonRowData;
                    }
                } else {
                    $commonData['CGST Rule ' . $cgstRule][] = getCommonRowData($r, $productsList[$r['prod_id']]);
                }
            }
        }

        $igstSecionSearchSTR = '';
        foreach ($igstSections as $igstSec) {

            $igstSecionSearchSTR = " data_id!=$data_id AND (";


            if (strpos($igstSec, ')')) {
                $igstSecionSearchSTR .= " section_no LIKE '%, $igstSec(%' ";
                $igstSecionSearchSTR .= " OR section_no LIKE '$igstSec(%' OR ";
            }

            $igstSecionSearchSTR .= " igst_section_no LIKE '%, $igstSec,%' ";
            $igstSecionSearchSTR .= " OR igst_section_no LIKE '$igstSec,%' ";
            $igstSecionSearchSTR .= " OR igst_section_no LIKE '%, $igstSec' )";

            $getDataForThisRow = "Select igst_section_no, data_id, prod_id, circular_no, circular_date, party_name, cir_subject, file_path from casedata_sgst where $igstSecionSearchSTR order by circular_date desc";

            $result_primary = mysqli_query($GLOBALS['con'],$getDataForThisRow);

            while ($r = mysqli_fetch_assoc($result_primary)) {
                if ($articleType == 'Acts') {
                    $finalSections = getOnlyRelatedActs($r['igst_section_no'], $igstSec, $articleType);
                    $commonRowData = getCommonRowData($r, $productsList[$r['prod_id']]);
                    foreach ($finalSections as $sec) {
                        $commonData['Section ' . $sec][] = $commonRowData;
                    }
                } else {
                    $commonData['IGST Section ' . $igstSec][] = getCommonRowData($r, $productsList[$r['prod_id']]);
                }

//                $commonData['IGST Section ' . $igstSec][] = getCommonRowData($r, $productsList[$r['prod_id']]);
//                $commonDataByCase[$r['data_id']] = getCommonRowData($r, $productsList[$r['prod_id']]);
            }
        }



        $igstRuleSearchSTR = '';
        foreach ($igstRules as $igstRule) {

            $igstRuleSearchSTR = " data_id!=$data_id AND (";

            if (strpos($igstRule, ')')) {
                $igstRuleSearchSTR .= " section_no LIKE '%, $igstRule(%' ";
                $igstRuleSearchSTR .= " OR section_no LIKE '$igstRule(%' OR ";
            }

            $igstRuleSearchSTR .= " igst_rule_no LIKE '%, $igstRule,%' ";
            $igstRuleSearchSTR .= " OR igst_rule_no LIKE '$igstRule,%' ";
            $igstRuleSearchSTR .= " OR igst_rule_no LIKE '%, $igstRule' )";

            $getDataForThisRow = "Select igst_rule_no, data_id, prod_id, circular_no, circular_date, party_name, cir_subject, file_path from casedata_sgst where $cgstRuleSearchSTR order by circular_date desc";

            $result_primary = mysqli_query($GLOBALS['con'],$getDataForThisRow);
            while ($r = mysqli_fetch_assoc($result_primary)) {
                
                if ($articleType == 'Acts') {
                    $finalSections = getOnlyRelatedActs($r['igst_rule_no'], $igstRule, $articleType);
                    $commonRowData = getCommonRowData($r, $productsList[$r['prod_id']]);
                    foreach ($finalSections as $sec) {
                        $commonData['Rule ' . $sec][] = $commonRowData;
                    }
                } else {
                    $commonData['IGST Rule ' . $igstRule][] = getCommonRowData($r, $productsList[$r['prod_id']]);
                }
              
            }
        }
        // print_r($commonData);;die;
        if($articleType=='Acts'){
            uksort($commonData,'customSort');
        }
        return array('bySection' => $commonData, 'byCase' => $commonDataByCase,'headerSectionName'=>$headerSectionName);
    } else {
        return array();
    }
}

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

function getCitedIn($data_id, $data_type, $format = 'array') {
    $subProducts = getSubProducts();

    //get primary data info
    $data_type = strtolower($data_type);
    $tableName = 'casedata_' . $data_type;
    $primary_query = "SELECT circular_no, sub_prod_id, prod_id FROM $tableName where  data_id = $data_id";
    $result_primary = mysqli_query($GLOBALS['con'],$primary_query);
    $row_primary = mysqli_fetch_array($result_primary);
    // print_r($row_primary);
    $data_sub_prod_type = $subProducts[$row_primary['sub_prod_id']]['sub_prod_type'];
    $data_sub_prod_name = $subProducts[$row_primary['sub_prod_id']]['sub_prod_name'];

    $select_query = "Select * from mapping where reference_id=$data_id AND reference_type='$data_sub_prod_type' AND reference_prod_name='$data_type' order by data_prod_name ASC, data_id DESC";

    $result = mysqli_query($GLOBALS['con'],$select_query);
    $common_data = array();
    // echo "<pre>";
    while ($row = mysqli_fetch_assoc($result)) {
        // print_r($row);
        $reference_prod_name = $row['data_prod_name'];
        $reference_type = $row['data_type'];
        $reference_sub_prod_name = $row['data_sub_prod_name'];

        if ($reference_type == 'Judgements') {
            $reference_type = 'Case';
        } else if ($reference_type == 'Notifications' && $reference_sub_prod_name == 'Circular') {
            $reference_type = 'Circular';
        } else if ($reference_type == 'Notifications') {
            $reference_type = 'Notification';
        } else if ($reference_type == 'Acts' && ($reference_sub_prod_name == 'Rules' or $reference_sub_prod_name == 'Format')) {
            $reference_type = 'Rule';
        } else if ($reference_type == 'Acts') {
            $reference_type = 'Section';
        }

        $validTypeArray = array('cu', 'cgst', 'ce', 'igst', 'dgft', 'vat', 'sgst', 'gst', 'st', 'utgst');

        if (in_array($reference_prod_name, $validTypeArray)) {
            $table_name = 'casedata_' . $reference_prod_name;
            $datField = 'data_id';
            $reference_id = $row['data_id'];
        } else {
            $table_name = 'vat_data';
            $datField = ' vat_data_id ';
            $reference_id = $row['data_id'];
        }

        $getDataForThisRow = "Select circular_no, circular_date, party_name, cir_subject, file_path from " . $table_name . " where $datField = $reference_id";

        $result2 = mysqli_query($GLOBALS['con'],$getDataForThisRow);

        while ($row2 = mysqli_fetch_array($result2)) {
            $c_date = date("d-m-Y", strtotime($row2['circular_date']));

            if ($reference_type == 'Case') {
                $rowtemp['display_name'] = "<b style='color:#777777'>" . $row2['circular_no'] . " [" . $c_date . "]</b> <br><span style='color:#00008b'>" . $row2['party_name'] . "</span>";
            } else if ($reference_type == 'Circular' || $reference_type == 'Notification') {
                $rowtemp['display_name'] = $row2['circular_no'] . "<b style='color:#777777'> [" . $c_date . "] </b>";
            } else {
                $rowtemp['display_name'] = $row2['circular_no'];
            }

            $rowtemp['title'] = substr($row2['cir_subject'], 0, 400);
            if (strlen($row2['cir_subject']) > 400) {
                $rowtemp['title'] .= '...';
            }
            $encryptId = base64_encode(base64_encode($reference_id));
            $file_extn = strtolower(substr($row2['file_path'], -3));
            $rowtemp['file_link'] = $row2['file_path'];
            $rowtemp['party_name'] = $row2['party_name'];
            $rowtemp['file_ext'] = $file_extn;
            $rowtemp['prod_name'] = strtoupper($reference_prod_name);
            $rowtemp['perm_link'] = "showiframe?V1Zaa1VsQlJQVDA9=$encryptId&datatable=$reference_prod_name";
            $rowtemp['type'] = $reference_type;
            $common_data[$reference_type][] = $rowtemp;
        }
    }
    // print_r($common_data);die;
    return $common_data;
}

//get all circulars for by case id
//get data by case id
function getMappingInfoByDataId($data_id, $data_type, $format = 'array') {

    $subProducts = getSubProducts();

    //get primary data info
    $data_type = strtolower($data_type);
    $tableName = 'casedata_' . $data_type;
    $primary_query = "SELECT circular_no, sub_prod_id, prod_id FROM $tableName where  data_id = $data_id";
    $result_primary = mysqli_query($GLOBALS['con'],$primary_query);
    $row_primary = mysqli_fetch_array($result_primary);
    // print_r($row_primary);
    $data_sub_prod_type = $subProducts[$row_primary['sub_prod_id']]['sub_prod_type'];
    $data_sub_prod_name = $subProducts[$row_primary['sub_prod_id']]['sub_prod_name'];

    if($_REQUEST['filterBy']=='Harshal'){
        echo $select_query = "Select * from mapping where data_id=$data_id AND data_type='$data_sub_prod_type' AND data_prod_name='$data_type'";die;
    }else{
    $select_query = "Select * from mapping where data_id=$data_id AND data_type='$data_sub_prod_type' AND data_prod_name='$data_type'";    
    }

    

    $result = mysqli_query($GLOBALS['con'],$select_query);
    $common_data = array();
    // echo "<pre>";
    while ($row = mysqli_fetch_assoc($result)) {
        // print_r($row);
        $reference_prod_name = $row['reference_prod_name'];
        $reference_type = $row['reference_type'];
        $reference_sub_prod_name = $row['reference_sub_prod_name'];

        if ($reference_type == 'Notifications' && $reference_sub_prod_name == 'Circular') {
            $reference_type = 'Circular';
        }

        if ($reference_type == 'Acts' && ($reference_sub_prod_name == 'Rules' or $reference_sub_prod_name == 'Format')) {
            $reference_type = 'Rules';
        }

        $validTypeArray = array('cu', 'cgst', 'ce', 'igst', 'dgft', 'vat', 'sgst', 'gst', 'st', 'utgst');

        if (in_array($reference_prod_name, $validTypeArray)) {
            $table_name = 'casedata_' . $reference_prod_name;
            $datField = 'data_id';
            $reference_id = $row['reference_id'];
        } else {
            $table_name = 'vat_data';
            $datField = ' vat_data_id ';
            $reference_id = $row['reference_id'];
        }

        $getDataForThisRow = "Select circular_no,party_name,circular_date, cir_subject, file_path from " . $table_name . " where $datField = $reference_id";

        $result2 = mysqli_query($GLOBALS['con'],$getDataForThisRow);

        while ($row2 = mysqli_fetch_array($result2)) {

            $c_date = date("d-m-Y", strtotime($row2['circular_date']));

            if ($reference_type == 'Judgements') {
                $rowtemp['display_name'] = "<b style='color:#777777'>" . $row2['circular_no'] . " [" . $c_date . "]</b> <br><span style='color:#00008b'>" . $row2['party_name'] . "</span>";
            } else if ($reference_type == 'Circular' || $reference_type == 'Notifications') {
                $rowtemp['display_name'] = $row2['circular_no'] . "<b style='color:#777777'> [" . $c_date . "] </b>";
            } else {
                $rowtemp['display_name'] = $row2['circular_no'];
            }

            // $rowtemp['display_name'] = $row2['circular_no'];
            $rowtemp['title'] = substr($row2['cir_subject'], 0, 400);
            if (strlen($row2['cir_subject']) > 400) {
                $rowtemp['title'] .= '...';
            }
            $encryptId = base64_encode(base64_encode($reference_id));
            $file_extn = strtolower(substr($row2['file_path'], -3));
            $rowtemp['file_link'] = $row2['file_path'];
            $rowtemp['party_name'] = $row2['party_name'];
            $rowtemp['file_ext'] = $file_extn;
            $rowtemp['prod_name'] = strtoupper($reference_prod_name);
            $rowtemp['perm_link'] = "showiframe?V1Zaa1VsQlJQVDA9=$encryptId&datatable=$reference_prod_name";
            $common_data[$reference_type][] = $rowtemp;
        }
    }
    // print_r($common_data);
    // die;

    return $common_data;
}

function getMappingInfoByDataId2($data_id, $data_type, $format = 'array') {

    $subProducts = getSubProducts();

    //get primary data info
    $data_type = strtolower($data_type);
    $tableName = 'casedata_' . $data_type;
    $primary_query = "SELECT circular_no, sub_prod_id, prod_id FROM $tableName where  data_id = $data_id";
    $result_primary = mysqli_query($GLOBALS['con'],$primary_query);
    $row_primary = mysqli_fetch_array($result_primary);
    // print_r($row_primary);
    $data_sub_prod_type = $subProducts[$row_primary['sub_prod_id']]['sub_prod_type'];
    $data_sub_prod_name = $subProducts[$row_primary['sub_prod_id']]['sub_prod_name'];

    $select_query = "Select * from mapping where data_id=$data_id AND data_type='$data_sub_prod_type' AND data_prod_name='$data_type'";

    $result = mysqli_query($GLOBALS['con'],$select_query);
    $common_data = array();
    // echo "<pre>";
    while ($row = mysqli_fetch_assoc($result)) {
        // print_r($row);
        $reference_prod_name = $row['reference_prod_name'];
        $reference_type = $row['reference_type'];
        $reference_sub_prod_name = $row['reference_sub_prod_name'];

        if ($reference_type == 'Notifications' && $reference_sub_prod_name == 'Circular') {
            $reference_type = 'Circular';
        }

        if ($reference_type == 'Acts' && $reference_sub_prod_name == 'Rules') {
            $reference_type = 'Rules';
        }

        $validTypeArray = array('cu', 'cgst', 'ce', 'igst', 'dgft', 'vat', 'sgst', 'gst', 'st', 'utgst');

        if (in_array($reference_prod_name, $validTypeArray)) {
            $table_name = 'casedata_' . $reference_prod_name;
            $datField = 'data_id';
            $reference_id = $row['reference_id'];
        } else {
            $table_name = 'vat_data';
            $datField = ' vat_data_id ';
            $reference_id = $row['reference_id'];
        }

        $getDataForThisRow = "Select circular_no,party_name,circular_date, cir_subject, file_path from " . $table_name . " where $datField = $reference_id";

        $result2 = mysqli_query($GLOBALS['con'],$getDataForThisRow);

        while ($row2 = mysqli_fetch_array($result2)) {

            $c_date = date("d-m-Y", strtotime($row2['circular_date']));

            if ($reference_type == 'Judgements') {
                $rowtemp['display_name'] = "<b style='color:#777777'>" . $row2['circular_no'] . " [" . $c_date . "]</b> <br><span style='color:#00008b'>" . $row2['party_name'] . "</span>";
            } else if ($reference_type == 'Circular' || $reference_type == 'Notifications') {
                $rowtemp['display_name'] = $row2['circular_no'] . "<b style='color:#777777'> [" . $c_date . "] </b>";
            } else {
                $rowtemp['display_name'] = $row2['circular_no'];
            }

            // $rowtemp['display_name'] = $row2['circular_no'];
            $rowtemp['title'] = substr($row2['cir_subject'], 0, 100);
            if (strlen($row2['cir_subject']) > 100) {
                $rowtemp['title'] .= '...';
            }
            $encryptId = base64_encode(base64_encode($reference_id));
            $file_extn = strtolower(substr($row2['file_path'], -3));
            $rowtemp['file_link'] = $row2['file_path'];
            $rowtemp['party_name'] = $row2['party_name'];
            $rowtemp['file_ext'] = $file_extn;
            $rowtemp['prod_name'] = strtoupper($reference_prod_name);
            $rowtemp['perm_link'] = "showiframe?V1Zaa1VsQlJQVDA9=$encryptId&datatable=$reference_prod_name";
            $common_data[$reference_type][] = $rowtemp;
        }
    }
    // print_r($common_data);
    // die;

    return $common_data;
}
