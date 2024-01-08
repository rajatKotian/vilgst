<?php
include('conn.php');
include('functions.php'); 
error_reporting(E_ALL);
ini_set('display_errors',1);
$query = "SELECT * FROM `casedata_cgst` where  data_id=233"; //"; //35/36 - subprod ids for prod id 5 (customs)

$result = mysqli_query($GLOBALS['con'],$query);
$data = mysqli_fetch_array($result);
// echo "<pre>";
//print_r($data);
$datafile = $data['file_path'];
$filedata =  file_get_contents($datafile);
// echo $filedata;
// die;
$curl = curl_init();

$dataArray =  '{
                    "ProductType": "CGST",
                    "CircularDate": "'.$data['circular_date'].'",
                    "UploadDate": "'.$data['created_dt'].'",
                    "CircularNo": "'.$data['circular_no'].'",
                    "SubProductType": "Notification",
                    "EquivalentCitationNo": " ",
                    "Caseno": "",
                    "stateId": 0,
	                "Year" : "'.$data['year'].'",
                    "Judgename": "",
                    "Partyname":"",
                    "Notificationtype":"'.$data['sub_subprod_id'].'",
                    "singlelinetitle" : "",
                    "subject":"'.$data['cir_subject'].'",
                    "summary":"",
                    "filedata":"'.urlencode($filedata).'",                
                }';

// echo "<pre>";
// print_r($dataArray);
// die;

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://vatinfolinepoc.centralus-1.eventgrid.azure.net/api/events',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'[
    {
        "id": "1",
        "eventType": "VILGST POC",
        "subject": "VILGST POC",
        "eventTime": "2022-02-22T13:01:13Z",
        "data": '.$dataArray.',    
        "dataVersion": "1.0"
    }
]',
  CURLOPT_HTTPHEADER => array(
    'aeg-sas-key: bSbkL7ldKh3l07CCoGsggapXRL5GoU+aocbPKRMPk1U=',
    'Content-Type: application/json'
  ),
));

$response = curl_exec($curl);
$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

curl_close($curl);
echo "Data Passed: <br><pre>";
print_r($dataArray);
echo "</pre>";
echo "<hr><br>";
echo "Curl Response:<br>";

echo "Response: " . $response;
echo "<br /><br />";
echo "HTTP Reponse Code:" . $httpcode;
