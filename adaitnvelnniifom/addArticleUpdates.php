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

if($_POST['article_type'] == 'highlights') {
	$highlights_flag = 'Y';
} else {
	$highlights_flag = 'N';
}

$article_date=$_POST['article_date']; 

$subject=$_POST['subject']; 

$summary=$_POST['summary']; 

$author=$_POST['author']; 

$new_flag=$_POST['new_flag']; 

$code=$_POST['txtCode']; 



if ($code == 'vat@^123')

{

	//echo "Valid Entry Passed<br>";

}

else

{

	echo "Contact to Administrator<br>";

	exit;

}



$target_path_rec = "data/articles/";


$target_path_rec = $target_path_rec . basename( $_FILES['upload']['name']); 

//echo basename( $_FILES['upload']['name']);
//echo $target_path_rec;

if(move_uploaded_file($_FILES['upload']['tmp_name'], $target_path_rec)) 

{



   // $curDate = NOW();



	$db_host = 'localhost';

		$db_user = 'vatinfo1_ad';

		$db_pwd = 'adminc2';

		$database = 'vatinfo1_vatinfo';





	// Connect to server and select databse.

	mysql_connect("$host", "$db_user", "$db_pwd")or die("cannot connect"); 

	mysql_select_db("$database")or die("cannot select DB");








	$strQuery = "insert into articles (article_date,subject,summary,author,file_path,new_flag,highlights_flag,created_by,created_dt,updated_by,updated_dt) values (

	    '$article_date',

	    '$subject',
		
		'$summary',

		'$author',
	    
	    '$target_path_rec',

	    '$new_flag',

	    '$highlights_flag',

	    '$creator',

	    NOW(),

	    '$creator',

	    NOW())";
  

	mysqli_query($GLOBALS['con'],$strQuery);
	

	
	echo "<script>window.alert('Article added successfully.');</script>";
	echo "<script>window.location.href='admin/addArticleUpdates.php';</script>";

} else

{

    echo "There was an error uploading the file in recent cases, please try again!<br>";

}	




?>

