<?php

session_start();

if(isset($_SESSION['user']))
	If ($_SESSION["login"]=='qwert')
	{
		echo "Welcome ". $_SESSION['user'];
	}
	else
	{
		die("Annonymous Entry");
	}
else
	die("Please Log in");

//print_r($_POST);
$vat_data_id=$_POST['vat_data_id']; 

$creator = $_SESSION['user'];

$stateid=$_POST['state']; 

$cir_date=$_POST['txtCirDate']; 

$cir_no=$_POST['txtCirNo']; 

$product=$_POST['product']; 

$subproduct=$_POST['subproduct']; 
 
$sub_subprod_id=$_POST['sub_subprod_id']; 

$subject=$_POST['txtSub']; 

//$updfile=$_POST['uploadedfile'];

$code=$_POST['txtCode']; 



//-
	$db_host = 'localhost';

			$db_user = 'vatinfo1_ad';

		$db_pwd = 'adminc2';

		$database = 'vatinfo1_vatinfo';

	//$tbl_name = 'vat_data';

	
	
	

	// Connect to server and select databse.

	mysql_connect("$host", "$db_user", "$db_pwd")or die("cannot connect"); 

	mysql_select_db("$database")or die("cannot select DB");

	

	//qrState = "select state_name from state_master";

	

	

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

}

	else

	{
if(isset($_POST['state']) && $_POST['state']!='')
{
		$result = mysqli_query($GLOBALS['con'],"select state_name from state_master where state_id =" . $stateid);

		$row = mysqli_fetch_row($result);

		$state_name = $row[0]; 
}
	}

	

//------

    

if ($code == 'vat@^123')

{

	//echo "Passed";

}

else

{

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



if(is_dir($state_path)==false)

{

	mkdir($state_path, 0777);

	chmod($state_path, 0777);

}

if(is_dir($year_path)==false)

{

	mkdir($year_path, 0777);

	chmod($year_path, 0777);

}

print_r($_POST);
//exit();


if($_POST['fileStatus']=='new'){

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
 
$target_path = $year_path . "/" . $filenameOnly.$fileSuffix.'.'.$filenameExtn; 

// if(file_exists($target_path)) {
// 	die('File Already Exist at "<b>'. $target_path.' </b>" <br /> <a href="javascript:void(0)" onclick="javascript:history.go(-1);return false;">Go Back to upload new file</a> ');
// }

if(move_uploaded_file($_FILES['upload']['tmp_name'], $target_path)) 

{
//echo"new";
//echo $target_path;
   echo "The file ".  $filenameOnly.$fileSuffix.'.'.$filenameExtn.     " has been uploaded<br/>";

    $curDate = date("Y/m/d");



	// Connect to server and select databse.

	
	mysql_connect("$host", "$db_user", "$db_pwd")or die("cannot connect"); 

	mysql_select_db("$database")or die("cannot select DB");


	
			if(($subproduct==21) || ($subproduct==22) || ($subproduct==35) || ($subproduct==36)) { 
	$strQuery = "UPDATE  vat_data SET
				prod_id='$product',
			    sub_prod_id='$subproduct',
				sub_subprod_id='$sub_subprod_id',
				state_id='$stateid',
				circular_date='$cir_dt',
				circular_no='$cir_no',
				cir_subject='$subject',
			    file_path='$target_path',
			    updated_by='$creator',
	    		updated_dt='$curDate'
				WHERE  vat_data_id ='$vat_data_id';
				";
			}
			else
			{
	$strQuery = "UPDATE  vat_data SET
				prod_id='$product',
			    sub_prod_id='$subproduct',
				state_id='$stateid',
				circular_date='$cir_dt',
				circular_no='$cir_no',
				cir_subject='$subject',
			    file_path='$target_path',
			    updated_by='$creator',
	    		updated_dt='$curDate'
				WHERE  vat_data_id ='$vat_data_id';
				";
	}

    mysqli_query($GLOBALS['con'],$strQuery);
	

if(mysqli_query($GLOBALS['con'],$strQuery))
{

	echo "<script>window.alert('Data updated successfully.');</script>";
	echo "<script>window.location.href='admin/Admin.php';</script>";//echo "SELECT file_path FROM recent_data WHERE vat_data_id = $id";
}
else
{
echo 'Database query error';
}


} else

{

    echo "There was an error uploading the file, please try again!";

}

}
else
{
	echo"old";
    $curDate = date("Y/m/d");



	// Connect to server and select databse.

	
	mysql_connect("$host", "$db_user", "$db_pwd")or die("cannot connect"); 

	mysql_select_db("$database")or die("cannot select DB");



			if(($subproduct==21) || ($subproduct==22) || ($subproduct==35) || ($subproduct==36)) { 
	$strQuery = "UPDATE  vat_data SET
				prod_id='$product',
			    sub_prod_id='$subproduct',
				sub_subprod_id='$sub_subprod_id',
				state_id='$stateid',
				circular_date='$cir_dt',
				circular_no='$cir_no',
				cir_subject='$subject',
			    updated_by='$creator',
	    		updated_dt='$curDate'
				WHERE  vat_data_id ='$vat_data_id';
				";
			}
			else
			{
	$strQuery = "UPDATE  vat_data SET
				prod_id='$product',
			    sub_prod_id='$subproduct',
				state_id='$stateid',
				circular_date='$cir_dt',
				circular_no='$cir_no',
				cir_subject='$subject',
			    updated_by='$creator',
	    		updated_dt='$curDate'
				WHERE  vat_data_id ='$vat_data_id';
				";
	}

if(mysqli_query($GLOBALS['con'],$strQuery))
{

	echo "<script>window.alert('Data updated successfully.');</script>";
	echo "<script>window.location.href='admin/Admin.php';</script>";//echo "SELECT file_path FROM recent_data WHERE vat_data_id = $id";
}
else
{
echo 'Database query error';
}


}

?>

