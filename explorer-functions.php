<?php

function getSubProuctsByProdId($prod_id, $sub_prod_type, $sub_prod_name) {
    $query = "SELECT sub_prod_id FROM sub_product where prod_id = $prod_id and sub_prod_type='$sub_prod_type' and sub_prod_name='$sub_prod_name'";
    $result = mysqli_query($GLOBALS['con'],$query);
    $return_array = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $return_array[] = $row['sub_prod_id'];
    }
 
    return $return_array;
}

function getCaseDataFromTable($sub_prod_ids, $table, $sub_prod_name) {
    $return_array = array();

    if (is_array($sub_prod_ids) && count($sub_prod_ids) > 0) {
        $imploded_sub_prod_ids = implode(',', $sub_prod_ids);
        // echo "<br>";
        
        if($sub_prod_name =='Acts' || $sub_prod_name=='Rules'){
            $query = "SELECT data_id, circular_no, cir_subject, file_path FROM casedata_$table where sub_prod_id in ($imploded_sub_prod_ids) order by circular_no ASC";    
        }else{
            $query = "SELECT data_id, circular_no, cir_subject, file_path FROM casedata_$table where sub_prod_id in ($imploded_sub_prod_ids) order by circular_date DESC";
        }
        
        
        $result = mysqli_query($GLOBALS['con'],$query);
        while ($row = mysqli_fetch_assoc($result)) {
            $return_array[] = array('data_id'=>$row['data_id'], 'display'=>$row['circular_no']);
        }
    }

    return $return_array;
}

function getProdDataForExplorer($prod_id, $prod_name) {
//    $prod_id = '10';
    //get list of sections
    $sub_prod_ids = getSubProuctsByProdId($prod_id, 'Acts', 'Acts');
    $sectionList = getCaseDataFromTable($sub_prod_ids, $prod_name, 'Acts');
    

    //get list of rules
    $sub_prod_ids = getSubProuctsByProdId($prod_id, 'Acts', 'Rules');
    $rulesList = getCaseDataFromTable($sub_prod_ids, $prod_name, 'Rules');

    //get list of notifications
    $sub_prod_ids = getSubProuctsByProdId($prod_id, 'Notifications', 'Notification');
    $notificationList = getCaseDataFromTable($sub_prod_ids, $prod_name, 'Notification');

    //get list of circulars
    $sub_prod_ids = getSubProuctsByProdId($prod_id, 'Notifications', 'Circular');
    $circularList = getCaseDataFromTable($sub_prod_ids, $prod_name, 'Circular');

    $caseDataArray = array(
        'sections' => $sectionList,
        'rules' => $rulesList,
        'notifications' => $notificationList,
        'circulars' => $circularList
    );

    return $caseDataArray;
}

function getsimilarDataForExplorer($prod_id, $prod_name, $sub_prod_id3) {
    $tableName = 'casedata_' . $prod_name;
    $sqlProduct = "SELECT  p.prod_name 'ProductName', p.dbsuffix 'product_suffix' FROM $tableName vd, product p WHERE vd.data_id = '$sub_prod_id3' AND vd.prod_id = p.prod_id";
    $resultProduct = mysqli_query($GLOBALS['con'],$sqlProduct);
    $rowProduct = mysqli_fetch_array($resultProduct);
    $originalDecryptId = $sub_prod_id3;

    if (isset($rowProduct['ProductName']) && $rowProduct['ProductName'] != '') {
        $similar_cases = getSimilarCaseLaws($originalDecryptId, $rowProduct['product_suffix']);
        $mapping_data = getMappingInfoByDataId($originalDecryptId, $rowProduct['product_suffix']);
        $citeIn = getCitedIn($originalDecryptId, $rowProduct['product_suffix']);

        $section_count1 = count($mapping_data['Acts']);
        $rule_count1 = count($mapping_data['Rules']);
        $notifications_count1 = count($mapping_data['Notifications']);
        $ciculars_count1 = count($mapping_data['Circular']);
        $cites_count1 = count($mapping_data['Judgements']);
        $citedin_count1 = count($citeIn);
        $citedin_count = 10;

        $citeIn_case1 = count($citeIn['Case']);
        $citeIn_Notification1 = count($citeIn['Notification']);
        $citeIn_Circular1 = count($citeIn['Circular']);
        $citeIn_Section1 = count($citeIn['Section']);
        $citeIn_Rule1 = count($citeIn['Rule']);

        $section_count = getDataFromTable1($section_count1, $mapping_data['Acts']);
        $rule_count = getDataFromTable2($rule_count1, $mapping_data['Rules']);
        $notifications_count = getDataFromTable3($notifications_count1, $mapping_data['Notifications']);
        $ciculars_count = getDataFromTable4($ciculars_count1, $mapping_data['Circular']);
        $cites_count = getDataFromTable5($cites_count1, $mapping_data['Judgements']);

        $citeIn_case = getDataFromTable6($citeIn_case1, $citeIn['Case'], $citedin_count);
        $citeIn_Notification = getDataFromTable7($citeIn_Notification1, $citeIn['Notification'], $citedin_count);
        $citeIn_Circular = getDataFromTable8($citeIn_Circular1, $citeIn['Circular'], $citedin_count);
        $citeIn_Section = getDataFromTable9($citeIn_Section1, $citeIn['Section'], $citedin_count);
        $citeIn_Rule = getDataFromTable10($citeIn_Rule1, $citeIn['Rule'], $citedin_count);
    }

    $caseDataArray2 = array(
        'sections' => $section_count,
        'sections1' => $section_count1,
        'rules' => $rule_count,
        'rules1' => $rule_count1,
        'notifications' => $notifications_count,
        'notifications1' => $notifications_count1,
        'circulars' => $ciculars_count,
        'circulars1' => $ciculars_count1,
        'judgements' => $cites_count,
        'judgements1' => $cites_count1,
        'citeIn_Case' => $citeIn_case,
        'citeIn_Case1' => $citeIn_case1,
        'citeIn_Notification' => $citeIn_Notification,
        'citeIn_Notification1' => $citeIn_Notification1,
        'citeIn_Circular' => $citeIn_Circular,
        'citeIn_Circular1' => $citeIn_Circular1,
        'citeIn_Section' => $citeIn_Section,
        'citeIn_Section1' => $citeIn_Section1,
        'citeIn_Rule' => $citeIn_Rule,
        'citeIn_Rule1' => $citeIn_Rule1
    );

    return $caseDataArray2;
}

function getDataFromTable1($section_count1, $section) {
    $return_array1 = array();
    //echo $section_count1;
    if ($section_count1 > 0) {
        foreach ($section as $circular_map) {
            $return_array1[] = array('data_id'=>$circular_map['perm_link'], 'display'=>$circular_map['display_name'], 'prod_name'=>$circular_map['prod_name']);
        }
    }
    return $return_array1;
}

function getDataFromTable2($rule_count1, $rules) {
    $return_array2 = array();
    //echo $rule_count1;
    if ($rule_count1 > 0) {
        foreach ($rules as $circular_map) {
            $return_array2[] = array('data_id'=>$circular_map['perm_link'], 'display'=>$circular_map['display_name'], 'prod_name'=>$circular_map['prod_name']);
        }
    }
    return $return_array2;
}

function getDataFromTable3($notifications_count1, $notifications) {
    $return_array3 = array();
    //echo $notifications_count1;
    if ($notifications_count1 > 0) {
        foreach ($notifications as $circular_map) {
            $return_array3[] = array('data_id'=>$circular_map['perm_link'], 'display'=>$circular_map['display_name'], 'prod_name'=>$circular_map['prod_name']);
        }
    }
    return $return_array3;
}

function getDataFromTable4($ciculars_count1, $circulars) {
    $return_array4 = array();
    //echo $ciculars_count1;
    if ($ciculars_count1 > 0) {
        foreach ($circulars as $circular_map) {
            $return_array4[] = array('data_id'=>$circular_map['perm_link'], 'display'=>$circular_map['display_name'], 'prod_name'=>$circular_map['prod_name']);
        }
    }
    return $return_array4;
}

function getDataFromTable5($cites_count1, $cites) {
    $return_array5 = array();
    //echo $cites_count1;
    if ($cites_count1 > 0) {
        foreach ($cites as $circular_map) {
            $return_array5[] = array('data_id'=>$circular_map['perm_link'], 'display'=>$circular_map['display_name'], 'prod_name'=>$circular_map['prod_name']);
        }
    }
    return $return_array5;
}

function getDataFromTable6($citeIn_case1, $Case, $citedin_count) {
    $return_array6 = array();
    //echo $citeIn_case1;
    if ($citedin_count > 0) {
        if ($citeIn_case1 > 0) {
            foreach ($Case as $judgement_map) {
                $return_array6[] = array('data_id'=>$judgement_map['perm_link'], 'display'=>$judgement_map['display_name'], 'prod_name'=>$judgement_map['prod_name']);
            }
        }
    }
    return $return_array6;
}

function getDataFromTable7($citeIn_Notification1, $Notification, $citedin_count) {
    $return_array7 = array();
    //echo $citeIn_Notification1;
    if ($citedin_count > 0) {
        if ($citeIn_Notification1 > 0) {
            foreach ($Notification as $judgement_map) {
                $return_array7[] = array('data_id'=>$judgement_map['perm_link'], 'display'=>$judgement_map['display_name'], 'prod_name'=>$judgement_map['prod_name']);
            }
        }
    }
    return $return_array7;
}

function getDataFromTable8($citeIn_Circular1, $Circular, $citedin_count) {
    $return_array8 = array();
    //echo $citeIn_Circular1;
    if ($citedin_count > 0) {
        if ($citeIn_Circular1 > 0) {
            foreach ($Circular as $judgement_map) {
                $return_array8[] = array('data_id'=>$judgement_map['perm_link'], 'display'=>$judgement_map['display_name'], 'prod_name'=>$judgement_map['prod_name']);
            }
        }
    }
    return $return_array8;
}

function getDataFromTable9($citeIn_Section1, $Section, $citedin_count) {
    $return_array9 = array();
    //echo $citeIn_Section1;
    if ($citedin_count > 0) {
        if ($citeIn_Section1 > 0) {
            foreach ($Section as $judgement_map) {
                $return_array9[] = array('data_id'=>$judgement_map['perm_link'], 'display'=>$judgement_map['display_name'], 'prod_name'=>$judgement_map['prod_name']);
            }
        }
    }
    return $return_array9;
}

function getDataFromTable10($citeIn_Rule1, $Rule, $citedin_count) {
    $return_array10 = array();
    //echo $citeIn_Rule1;
    if ($citedin_count > 0) {
        if ($citeIn_Rule1 > 0) {
            foreach ($Rule as $judgement_map) {
                $return_array10[] = array('data_id'=>$judgement_map['perm_link'], 'display'=>$judgement_map['display_name'], 'prod_name'=>$judgement_map['prod_name']);
            }
        }
    }
    return $return_array10;
}

function ouptutJsonData($data) {
   echo json_encode($data);
}