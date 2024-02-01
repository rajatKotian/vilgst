<?php

session_start();
if(isset($_SESSION['user']))
	If ($_SESSION["login"]=='qwert')
	{
		//echo "Welcome ". $_SESSION['user'] . "<br>";
	}
	else
	{
		die("Annonymous Entry");
	}
else
	die("Please Log in");

$creator = $_SESSION['user'];

$content_id=$_POST['content_id']; 

$active_flag=$_POST['active_flag']; 

$code=$_POST['txtCode']; 

if(isset($_POST['contentTitle'])) {
	$title = $_POST['contentTitle'];
} else {
	$title = '';
}


if ($code == 'vat@^123')

{

	//echo "Valid Entry Passed<br>";

}

else

{

	echo "Contact to Administrator<br>";

	exit;

}



$target_path_rec = "uploads/";

if($_POST['fileStatus']=='new'){
$target_path_rec = $target_path_rec . basename( $_FILES['upload']['name']); 

//echo basename( $_FILES['upload']['name']);
//echo $target_path_rec;

if(move_uploaded_file($_FILES['upload']['tmp_name'], $target_path_rec)) 

{



  //  $curDate = NOW();



	$db_host = 'localhost';

		$db_user = 'vatinfo1_ad';

		$db_pwd = 'adminc2';

		$database = 'vatinfo1_vatinfo';





	// Connect to server and select databse.

	mysql_connect("$host", "$db_user", "$db_pwd")or die("cannot connect"); 

	mysql_select_db("$database")or die("cannot select DB");



	$strQuery = "UPDATE  contentblocks SET 
				title='$title',
				file_path='$target_path_rec',
				active_flag='$active_flag',
			    updated_by='$creator',
	    		updated_dt=NOW()
				WHERE  content_id ='$content_id';
				";


	
		if(mysqli_query($GLOBALS['con'],$strQuery))
		{
		echo "<script>window.alert('Updated successfully.');</script>";
		echo "<script>window.location.href='admin/Admin.php';</script>";
		}
		else
		{
		echo 'Database query error';
		}

	

} else

{

    echo "There was an error uploading the file in recent cases, please try again!<br>";

}	

}
else
{


  //  $curDate = NOW();



	$db_host = 'localhost';

		$db_user = 'vatinfo1_ad';

		$db_pwd = 'adminc2';

		$database = 'vatinfo1_vatinfo';





	// Connect to server and select databse.

	mysql_connect("$host", "$db_user", "$db_pwd")or die("cannot connect"); 

	mysql_select_db("$database")or die("cannot select DB");



	$strQuery = "UPDATE  contentblocks SET 
				title='$title',
				active_flag='$active_flag',
			    updated_by='$creator',
	    		updated_dt=NOW()
				WHERE  content_id ='$content_id';
				";


	
		if(mysqli_query($GLOBALS['con'],$strQuery))
		{
		echo "<script>window.alert('Setting Updated successfully.');</script>";
		echo "<script>window.location.href='admin/Admin.php';</script>";
		}
		else
		{
		echo 'Database query error';
		}



}


?>

