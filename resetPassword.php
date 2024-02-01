<?php 
require_once 'conn.php';

if(isset($_POST['txtCurrPass'])) { 

$txtCurrPass = mysqli_real_escape_string($con,stripslashes($_POST['txtCurrPass']));
$txtNewPass = mysqli_real_escape_string($con,stripslashes($_POST['txtNewPass']));
$txtConfNewPass = mysqli_real_escape_string($con,stripslashes($_POST['txtConfNewPass']));
$loginby = $_SESSION['id']; 

$sql = "SELECT pwd FROM userlogins WHERE user_id = '$loginby'";
$result = mysqli_query($GLOBALS['con'],$sql);
$count = mysqli_num_rows($result);

  if($count == 1) {
    $row = mysqli_fetch_array($result);
    $pwd = $row[0];
 
    if ($txtCurrPass == $pwd) {
      $qrsql = "UPDATE userlogins SET pwd = '$txtNewPass', updated_by = '$loginby', updated_dt = NOW() WHERE user_id = '$loginby'";

      mysqli_query($GLOBALS['con'],$qrsql);

      $resultStatus = 'success';
    } else {
      $resultStatus = 'wrong';
    }
    
  }

echo $resultStatus;
} else {

  header('Location:index.php');
}
?>