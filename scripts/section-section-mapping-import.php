<?php
//error_reporting(E_ALL);
//ini_set('display_errors','on');


$page = 'importsectionmapping';
include('../header.php');
include('../mapping_functions.php');

$filename = "harshal_section.csv";
//$filecontent = file_get_contents($page);

$file_handel = fopen($filename, 'r');
echo "<pre>";
$lnCounter = 0;
$dataMapper = array();
while (($line = fgetcsv($file_handel)) !== FALSE) {

    if ($lnCounter > 0) {
        $cgstMainSection = $line[0];
        $cgstOtherSections = (isset($line[1]) && $line[1] != '') ? explode(',', $line[1]) : '';
        $igstSections = (isset($line[2]) && $line[2] != '') ? explode(',', $line[2]) : '';
        $cesssSections = (isset($line[3]) && $line[3] != '') ? explode(',', $line[3]) : '';
        $dataMapper[$cgstMainSection] = array(
            'cgst' => $cgstOtherSections,
            'igst' => $igstSections,
            'sgst' => $cesssSections
        );
    }

    $lnCounter++;
}

$prod_ids = getProducts();

$subProducts = getSubProducts();

foreach ($dataMapper as $section => $refSections) {
    //get section data from the cgst table
    
    $secstr = 'Section ';
            
    if(substr_count(strtolower($section), 'schedule')>0){
        $secstr = '';
    }

    $sectionstring = $secstr . trim($section);

    $sectionData = getDataFromTableBySectionRuleNo($sectionstring, 'casedata_cgst');
    
    $data_sub_prod_type = $subProducts[$sectionData['sub_prod_id']]['sub_prod_type'];
    $data_sub_prod_name = $subProducts[$sectionData['sub_prod_id']]['sub_prod_name'];
    $dataInfo = array();
    
    foreach ($refSections as $datatype => $referal_sections) {
        foreach ($referal_sections as $referal) {
            $secstr = 'Section ';
            
            if(substr_count(strtolower($referal), 'schedule')>0){
                $secstr = '';
            }
            
            if ($datatype == 'sgst') {
                $sectionstring = $secstr . trim($referal) . ' - ccess';
            } else {
                $sectionstring = $secstr . trim($referal);
            }
            
            $referal_data = getDataFromTableBySectionRuleNo($sectionstring, 'casedata_' . $datatype);

            $type = $prod_ids[$referal_data['prod_id']];
            $rowid = $referal_data['data_id'];
            $sub_prod_id = $referal_data['sub_prod_id'];
            $prodtype = $subProducts[$sub_prod_id]['sub_prod_type'];
            $type_name = $subProducts[$sub_prod_id]['sub_prod_name'];

            $dataInfo[] = array('ref_id' => $rowid, 'ref_type' => $prodtype, 'ref_prod_name' => $type, 'ref_sub_prod_name' => $type_name);
        }
    }
  
//   echo $sectionData['data_id'];
    // echo $sectionData['data_id'] .", $data_sub_prod_type, $data_sub_prod_name, 'cgst'";
    // print_r($dataInfo);
    
  addMappingData($dataInfo, $sectionData['data_id'], $data_sub_prod_type, $data_sub_prod_name, 'cgst');
//   die;
}
//die;
//print_r($dataInfo);die;


function getDataFromTableBySectionRuleNo($string, $table) {
    $query = "SELECT * FROM `$table` WHERE `circular_no` = '$string'";
    
    $query_result = mysqli_query($GLOBALS['con'],$query);
    if (mysqli_num_rows($query_result) > 0) {
        while ($row = mysqli_fetch_assoc($query_result)) {
            $rowData = $row;
        }
    }else{
        echo "<br> No Record found for this section: ". $query . "<br>";
    }
    
    return $rowData;
}

//datainfo array, data id, 'judgement/notifications etc','notification, circular, high court case', 'cu, cgst, igft, dgft'
function addMappingData($references, $data_id, $data_sub_prod_type, $data_sub_prod_name, $data_prod_name) {
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
            if ($countRow1['total_records'] == 0) {
                $columns = "(`data_id`,`data_type`,`data_prod_name`,`data_sub_prod_name`,`reference_id`,`reference_type`,`reference_prod_name`,`reference_sub_prod_name`)";
                $values = "($data_id, '$data_sub_prod_type', '$data_prod_name', '$data_sub_prod_name', " . $reference['ref_id'] . ", '" . $reference['ref_type'] . "', '" . $reference['ref_prod_name'] . "', '" . $reference['ref_sub_prod_name'] . "')";
                $insertQuery = "insert into mapping " . $columns . " values " . $values;
                mysqli_query($GLOBALS['con'],$insertQuery);
            }
            
            //checking reverse way
            $selectQuery2 = "select count(*) as 'total_records' from mapping where 
                reference_id=" . $data_id . " 
                AND reference_type='" . $data_sub_prod_type . "' 
                AND reference_prod_name='" . $data_prod_name . "'
                AND reference_sub_prod_name='" . $data_sub_prod_name . "'
                AND data_id = " . $reference['ref_id'] . "
                AND data_type = '" . $reference['ref_type'] . "'
                AND data_prod_name = '" . $reference['ref_prod_name'] . "'
                AND data_sub_prod_name = '" . $reference['ref_sub_prod_name'] . "'";

            // echo $selectQuery;
            // echo "<br>";
            $selectResult2 = mysqli_query($GLOBALS['con'],$selectQuery2);
            $countRow2 = mysqli_fetch_array($selectResult2);
            // print_r($countRow1);
            // echo "<br><hr>";
            if ($countRow2['total_records'] == 0) {
                $columns = "(`data_id`,`data_type`,`data_prod_name`,`data_sub_prod_name`,`reference_id`,`reference_type`,`reference_prod_name`,`reference_sub_prod_name`)";
                $values = "(".$reference['ref_id'].", '".$reference['ref_type']."', '".$reference['ref_prod_name']."', '".$reference['ref_sub_prod_name']."', " . $data_id . ", '" . $data_sub_prod_type . "', '" . $data_prod_name . "', '" . $data_sub_prod_name . "')";
                $insertQuery = "insert into mapping " . $columns . " values " . $values;
                mysqli_query($GLOBALS['con'],$insertQuery);
            }
            
        }
    }
}

fclose($file_handel);
