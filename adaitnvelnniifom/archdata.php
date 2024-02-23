<?php 
	$page = '';
	include('header.php');
?> 

    <!-- left sec start <div class="col-md-16 col-sm-16"> -->
    <div class="col-md-11 col-sm-9 left-section">
      <h1>
      	<?php 	
      		$getProdname = mysqli_query($GLOBALS['con'],"SELECT prod_name FROM product where prod_id	 = '".$_GET['prod_id']."'");	
       		$rowProdname = mysqli_fetch_array($getProdname);
			echo $rowProdname['prod_name'];
			

	    	$getSubProdname = mysqli_query($GLOBALS['con'],"SELECT sub_prod_name FROM sub_product where sub_prod_id = '".$_GET['sub_prod_id']."'");	
       		$rowSubProdname = mysqli_fetch_array($getSubProdname);
       		if(!isset($_GET["sub_subprod_id"])) {
				echo ' - '.$rowSubProdname['sub_prod_name'];
			}
			echo ' - ';

  			if($_GET['prod_id']=='1' || $_GET['prod_id']=='7' || $_GET['prod_id']=='8') { 
  				if($_GET['state'] == 'Central' && $_GET['prod_id']=='7') {
  					echo 'Compensation Cess'; 
  				} else {
  					echo $_GET['state']; 	
  				}
  				
  			} else if($_GET['prod_id']=='2') { echo "Service Tax"; } 

      		if(isset($_GET["sub_subprod_id"])) {

				$subSubprod = $_GET["sub_subprod_id"];		

				if($subSubprod=='N') 	{ echo ' - Notification '; }
				else if($subSubprod=='RN') 	{ echo ' - Rate Notification '; }

			}
      	?>
  		  <ol class="breadcrumb">
	        <li><a href="<?php echo $getBaseUrl; ?>">Home</a></li>
	        <li><a href="javascript:void(0)" onclick="javascript:history.go(-1);return false;"><?php 

	        	$getProdname = mysqli_query($GLOBALS['con'],"SELECT prod_name FROM product where prod_id	 = '".$_GET['prod_id']."'");	
       			$rowProdname = mysqli_fetch_array($getProdname);
				echo $rowProdname['prod_name'];

				if(isset($_GET['sub_prod_id'])) { 
					 
                    $getSubProdname = mysqli_query($GLOBALS['con'],"SELECT sub_prod_name FROM sub_product where sub_prod_id = '".$_GET['sub_prod_id']."'");	
		       		$rowSubProdname = mysqli_fetch_array($getSubProdname);
		       		if(!isset($_GET["sub_subprod_id"])) {
					echo ' - '.$rowSubProdname['sub_prod_name'];       
					}      
				}
        		?></a></li>
	        <li class="active"><?php 
	        		if($_GET['prod_id']=='1' || $_GET['prod_id']=='7' || $_GET['prod_id']=='8') { 
		  				if($_GET['state'] == 'Central' && $_GET['prod_id']=='7') {
		  					echo 'Compensation Cess'; 
		  				} else {
		  					echo $_GET['state']; 	
		  				}	  				
	  				} else if($_GET['prod_id']=='2') { echo "Service Tax"; } 

					if(isset($_GET["sub_subprod_id"])) {

						$subSubprod = $_GET["sub_subprod_id"];		

						if($subSubprod=='N') 	{ echo ' - Notification '; }
						else if($subSubprod=='RN') 	{ echo ' - Rate Notification '; }
					}
	         ?></li>
	      </ol>
      </h1>

      <div class="col-md-16">
<?php
	$prod = $_GET["prod_id"];
	$subprod = $_GET["sub_prod_id"];
	$table = 'recent_data';	
	$state = $_GET["state"];

	if(isset($_GET["sub_subprod_id"])) {
		$subSubprod = $_GET["sub_subprod_id"];
	}

	$getDbRecord = getDbRecord('product', 'prod_id', $prod);
	$dataType = $getDbRecord['dbsuffix']; 

	$tableName = 'casedata_'.$dataType;
	
	if($_GET["s"]=='1') {
		$startPage= 0;
	} else {
		$startPage= $_GET["s"];
	}
	
	$endPage = $_GET["e"];
	
	if(($_GET['s']) && ($_GET['s']=='all')) {
		$limit = '';
	} else {
		$limit = "LIMIT $startPage, 20";
	}

	$getProdType = mysqli_query($GLOBALS['con'],"SELECT sub_prod_type FROM sub_product where sub_prod_id	 = '".$subprod."'");	
	$rowProdType = mysqli_fetch_array($getProdType);
	$subProdType = $rowProdType['sub_prod_type'];

	if($subProdType=='Acts') {
		$orderby = "  ORDER BY LEFT(vd.circular_no,0), 
						CAST( SUBSTRING(vd.circular_no, INSTR(vd.circular_no,  ' ' ) +1 ) AS UNSIGNED),
						vd.circular_no ";

	} else {

		$orderby = "  ORDER BY vd.circular_date DESC ";

	} 

	if(isset($subSubprod)) {
		if($subSubprod=='N') {
			$sub_subprod = " AND vd.sub_subprod_id ='Notification' ";
		} else if($subSubprod=='RN') {
			$sub_subprod = " AND vd.sub_subprod_id ='Rate Notification' ";
		}
	} else {
		$sub_subprod = '';
	}

	$sql = "SELECT vd.data_id, DATE_FORMAT(circular_date,GET_FORMAT(DATE,'EUR'))'Date', 
				vd.circular_no 'Circular No', 
				sm.state_name 'State', 
				p.prod_name 'Statute', 
				sp.sub_prod_name 'Document Type', 
				vd.cir_subject 'Subject',		
				vd.file_path 'Path'
				FROM $tableName vd
				LEFT JOIN state_master sm ON vd.state_id = sm.state_id
				JOIN product p, sub_product sp
				WHERE 
				sm.state_name ='$state' 
				AND vd.prod_id =$prod
				AND vd.prod_id = p.prod_id
				AND vd.sub_prod_id =$subprod
				AND vd.sub_prod_id = sp.sub_prod_id
				$sub_subprod
				AND vd.active_flag = 'Y' 
				$orderby

				$limit ";

			//print_r($sql);
	$result = mysqli_query($GLOBALS['con'],$sql);

	if(mysqli_num_rows($result) == 0)  {    
		echo "<div class='alert alert-danger'>No Data Found</div>";
	} else {

	if(isLogeedIn()) {
		if($_SESSION["userStatus"]=="expired") {
			include('expiredUserError.php'); 
		} else {
			$sqlCount = "SELECT count(vd.data_id)
							FROM $tableName vd
							LEFT JOIN state_master sm ON vd.state_id = sm.state_id
							JOIN product p, sub_product sp
							WHERE 
							sm.state_name ='$state' 
							and vd.prod_id =$prod
							and vd.prod_id = p.prod_id
							AND vd.sub_prod_id =$subprod
							AND vd.sub_prod_id = sp.sub_prod_id
							$sub_subprod
							AND vd.active_flag = 'Y'";

			$resultCount = mysqli_query($GLOBALS['con'],$sqlCount);

			$rowCount = mysqli_fetch_array($resultCount, MYSQL_NUM );
			$rec_count = $rowCount[0];
			$rec_limit = 19;

		echo "<div class='new-pagination'>";
		for($i = 1; $i <= $rec_count;$i++) {
			$j = $i;
			$k = ($i - 1);
			$i +=$rec_limit;
			//echo ;
			if(($rec_count-$i)>0)
			{
			echo "<a " ;
				if(($_GET['s']!='all')) { if(($k==$_GET['s']) || ((($_GET['s']==0) && ($i==20))) ){ echo "class='active'"; }   }
				echo " href='".$_SERVER['REQUEST_URI']."&s=$k&e=$i"."'>$j - $i</a>";
			}
			else
			{
			echo "<a ";
					if(($j==$_GET['s']) || ($rec_count <19)){ echo "class='active'"; }  
			echo "href='".$_SERVER['REQUEST_URI']."&s=$k&e=$rec_count"."'>$j - $rec_count</a>";
			}
			//$j +=10;
		}
			if($rec_count >20) {
			echo "<a ";
					if($_GET['s']=='all'){ echo "class='active'"; }  
			echo "href='".$_SERVER['REQUEST_URI']."&s=all"."' >All</a>";
		
			}

		echo "</div><div class='clear'></div>";

		while($row = mysqli_fetch_array($result)) {
			$file_path = $row['Path'];
			$file_extn = strtolower(substr($file_path,-3));
					$CatgoryClass = preg_replace('/\s+/', '', $row['Statute'])."section";
			$encryptID = base64_encode(base64_encode($row['data_id']));

			echo "<div class='widget-box $CatgoryClass'>";	
			echo "<h4>";

			$circular_no = $row['Circular No'] ? $row['Circular No'] : $row['Subject'];

			echo getCircularLink($encryptID, $dataType, $circular_no);	

			echo getDownloadIcon($encryptID, $dataType);			         	 
		  
			if($subProdType == 'Judgements' || $subProdType == 'Acts') {				
				echo "&nbsp;";
			} else {
				echo "<strong style='float: right; margin-right: 10px; margin-top: 0px;'>{$row['Date']}</strong>";
			}

			echo "</h4>";
			echo "<div class='widget-content'>";
			$subjectRes = cleanname($row['Subject']);
			echo "<p>".$subjectRes."</p>";
			echo "</div>";
		echo "</div>";
		}	
		echo "<div class='new-pagination'>";
		for($i = 1; $i <= $rec_count;$i++)  {
			$j = $i;
			$k = ($i - 1);
			$i +=$rec_limit;
			//echo ;
			if(($rec_count-$i)>0)
			{
			echo "<a " ;
				if(($_GET['s']!='all')) { if(($k==$_GET['s']) || ((($_GET['s']==0) && ($i==20))) ){ echo "class='active'"; }   }
				echo " href='".$_SERVER['REQUEST_URI']."&s=$k&e=$i"."'>$j - $i</a>";
			}
			else
			{
			echo "<a ";
					if(($j==$_GET['s']) || ($rec_count <19)){ echo "class='active'"; }  
			echo "href='".$_SERVER['REQUEST_URI']."&s=$k&e=$rec_count"."'>$j - $rec_count</a>";
			}
			//$j +=10;
		}
			if($rec_count >20) {
			echo "<a ";
					if($_GET['s']=='all'){ echo "class='active'"; }  
			echo "href='".$_SERVER['REQUEST_URI']."&s=all"."' >All</a>";
			}

		echo "</div><div class='clear'></div>";
		mysqli_free_result($result);
		}
	} else {
		include('loggedInError.php');
 	}
}
?>	
    </div> 
  </div>
   <!-- left sec end --> 
<?php 
  include('footer.php');
?>
