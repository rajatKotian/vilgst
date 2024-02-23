<?php
session_start();

ini_set('upload_max_filesize','10M');

ini_set('max_execution_time','300');


if(isset($_SESSION['user']))

	If ($_SESSION["login"]=='qwert')

	{

		echo "Welcome ". $_SESSION['user'] . "<br>";

	}

	else

	{

		die("Annonymous Entry");

	}

else

	die("Please Log in");



$creator = $_SESSION['user'];



$stateid=$_POST['state']; 



$cir_date=$_POST['txtCirDate']; 



$cir_no=$_POST['txtCirNo']; 



$product=$_POST['product']; 



$subproduct=$_POST['subproduct'];



$sub_subprod_id=$_POST['sub_subprod_id']; 	 



$subject=$_POST['txtSub']; 



$updfile=$_POST['uploadedfile'];



$code=$_POST['txtCode']; 







//------



	$host = 'localhost';



			$db_user = 'vatinfo1_ad';



		$db_pwd = 'adminc2';



		$database = 'vatinfo1_vatinfo';



	//$tbl_name = 'vat_data';





	



//code to upload archieve





mysql_connect("$host", "$db_user", "$db_pwd")or die("cannot connect"); 

//mysql_connect("$host", "$username", "$password")or die("cannot connect"); 

mysql_select_db("$database")or die("cannot select DB");

//mysql_select_db("$db_name")or die("cannot select DB");

if($stateid=='0') {

	if($product =='1') { 

		$state_name = 'VAT'; 

	} else if($product =='3') {

		$state_name = 'GST'; 

	} else if($product =='4') {

		$state_name = 'CENTRAL EXCISE'; 

	} else if($product =='5') {

		$state_name = 'CUSTOMS'; 

	} else if($product =='6') {

		$state_name = 'DGFT'; 

	} else {

		if($product =='2') {

			$state_name = 'SERVICE TAX'; 

		} else {

			echo "error in state";
		}

	}

} else {

	$result = mysqli_query($GLOBALS['con'],"select state_name from state_master where state_id =" . $stateid);

	$row = mysqli_fetch_row($result);

	$state_name = $row[0]; 

}

if ($code == 'vat@^123') {

	//echo "Passed";

} else {

	echo "Contact to Administrator";

	exit;

}

$cir_date = new DateTime($cir_date);

$cir_dt = $cir_date->format('Y-m-d H:i:s');

$cir_year = $cir_date->format('Y');

//echo trim($cir_year);

//echo $cir_dt;

$target_path = "data/";

$state_path = $target_path . $state_name;

$year_path = $state_path . "/" . trim($cir_year);


if(is_dir($state_path)==false) {

	mkdir($state_path, 0777);

	chmod($state_path, 0777);
}


if(is_dir($year_path)==false) {

	mkdir($year_path, 0777);

	chmod($year_path, 0777);

}

if($sub_subprod_id == 'Non-Tariff') {
	$fileSuffix = '-NT';
} else if($sub_subprod_id == 'Safeguards') {
	$fileSuffix = '-SG';
} else if($sub_subprod_id == 'Anti Dumping Duty') {
	$fileSuffix = '-AD';
} else if($sub_subprod_id == 'Others') {
	$fileSuffix = '-O';
} else  {
	$fileSuffix = '';
} 

$filenameOnly = array_pop(array_reverse(explode(".", basename( $_FILES['upload']['name']))));
$filenameExtn = array_pop(explode(".", basename( $_FILES['upload']['name'])));

$TXTfilenameOnly = array_pop(array_reverse(explode(".", basename( $_FILES['upload']['name']))));
$TXTfilenameExtn = array_pop(explode(".", basename( $_FILES['uploadTXT']['name'])));
 
$target_path = $year_path . "/" . $filenameOnly.$fileSuffix.'.'.$filenameExtn; 
$target_pathTXT = $year_path . "/" . $TXTfilenameOnly.$fileSuffix.'.'.$TXTfilenameExtn; 

// if(file_exists($target_path)) {
// 	die('File Already Exist at "<b>'. $target_path.' </b>" <br /> <a href="javascript:void(0)" onclick="javascript:history.go(-1);return false;">Go Back to upload new file</a> ');
// }


if(move_uploaded_file($_FILES['upload']['tmp_name'], $target_path)) {

move_uploaded_file($_FILES['uploadTXT']['tmp_name'], $target_pathTXT);

    echo "The file ".  $filenameOnly.$fileSuffix.'.'.$filenameExtn.     " has been uploaded in archive case. <br>";

    $curDate = date("Y/m/d");

	// Connect to server and select databse.
	mysql_connect("$host", "$db_user", "$db_pwd")or die("cannot connect"); 

//mysql_connect("$host", "$username", "$password")or die("cannot connect"); 

mysql_select_db("$database")or die("cannot select DB");

//mysql_select_db("$db_name")or die("cannot select DB");


	$strQuery = "INSERT into recent_data (prod_id,sub_prod_id,sub_subprod_id,state_id,circular_date,circular_no,cir_subject,

	    file_path,active_flag,created_by,created_dt,updated_by,updated_dt) values (

	    $product,



	    $subproduct,

		

		'$sub_subprod_id',

		

	    $stateid,



	    '$cir_dt',



	    '$cir_no',



	    '$subject',



	    '$target_path',



	    'Y',



	    '$creator',



	    '$curDate',



	    '$creator',



	    '$curDate')";



    mysqli_query($GLOBALS['con'],$strQuery);



	$strQuery = "insert into vat_data (prod_id,sub_prod_id,sub_subprod_id,state_id,circular_date,circular_no,cir_subject,



	    file_path,active_flag,created_by,created_dt,updated_by,updated_dt) values (



	    $product,



	    $subproduct,

		

		'$sub_subprod_id',

		

	    $stateid,



	    '$cir_dt',



	    '$cir_no',



	    '$subject',



	    '$target_path',



	    'Y',



	    '$creator',



	    '$curDate',



	    '$creator',



	    '$curDate')";



    mysqli_query($GLOBALS['con'],$strQuery);



	$strQuery = "insert into vat_data_backup (prod_id,sub_prod_id,sub_subprod_id,state_id,circular_date,circular_no,cir_subject,



	    file_path,active_flag,created_by,created_dt,updated_by,updated_dt) values (



	    $product,



	    $subproduct,



		'$sub_subprod_id',

		

	    $stateid,



	    '$cir_dt',



	    '$cir_no',



	    '$subject',



	    '$target_path',



	    'Y',



	    '$creator',



	    '$curDate',



	    '$creator',



	    '$curDate')";



	







	mysqli_query($GLOBALS['con'],$strQuery);

echo "<script>window.alert('Data added successfully.');</script>";



	echo "<script>window.location.href='admin/addrecent.php';<script>";







} else



{



    echo "There was an error uploading the archieve file, please try again!<br>";



}	



//end of code to upload archieve







?>



