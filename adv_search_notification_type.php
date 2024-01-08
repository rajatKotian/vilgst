<?php 
	include('conn.php');
	header('Content-type:application/json');
  

	if(isset($_REQUEST['table'])){
		
		$table=$_REQUEST['table'];

		$res=mysqli_query($GLOBALS['con'],"SELECT sub_prod_id,sub_prod_name FROM sub_product WHERE prod_id = '".$_REQUEST['id']."' AND (sub_prod_name='Circular' OR sub_prod_name='Notification')") or die(mysql_error());
		$data="";
		if(mysqli_num_rows($res)>0){
			$data.='<option value="0">Select Type</option>';
		
			while ($result=mysqli_fetch_array($res)) {
				if(isset($_REQUEST['sub_product_id']) && $_REQUEST['sub_product_id']== $result['sub_prod_id'])
				{
					$data.='<option value="'.$result['sub_prod_id'].'" selected>'.$result['sub_prod_name'].'</option>';
				}
				else
				{
					$data.='<option value="'.$result['sub_prod_id'].'">'.$result['sub_prod_name'].'</option>';
				}		
			}

			echo $data;
		}
		else
		{ 
			echo "no";
		} 
	}
?>




