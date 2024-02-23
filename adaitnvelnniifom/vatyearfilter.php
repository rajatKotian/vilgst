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

			if(isset($_GET["sub_subprod_id"])) {

				$subSubprod = $_GET["sub_subprod_id"];		

				if($subSubprod=='T') 		{ echo ' - Tariff '; }
				else if($subSubprod=='NT')	{ echo ' - Non-Tariff '; }
				else if($subSubprod=='SG') 	{ echo ' - Safeguards '; }
				else if($subSubprod=='ADD') { echo ' - Anti Dumping Duty '; }
				else if($subSubprod=='OTHERS') { echo ' - Others '; }
				else if($subSubprod=='C') 	{ echo ' - Circulars '; }
				else if($subSubprod=='I') 	{ echo ' - Instructions '; }
				else if($subSubprod=='N') 	{ echo ' - Notification '; }
				else if($subSubprod=='RN') 	{ echo ' - Rate Notification '; }

			}
			if(isset($_GET["year"])) {
				echo ' - '.$_GET['year'];
			}
		?>
 
      	<ol class="breadcrumb">
	        <li><a href="<?php echo $getBaseUrl; ?>">Home</a></li>
		        <?php 
		        	if(isset($_GET["year"])) {
						echo '<li><a href="javascript:void(0)" onclick="javascript:history.go(-1);return false;">'; 
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
						echo '</a></li>';
					}
	        	?>
	        <li class="active">
	        	<?php 
	        		if(isset($_GET["sub_subprod_id"])) {

						$subSubprod = $_GET["sub_subprod_id"];		

						if($subSubprod=='T') 		{ echo 'Tariff '; }
						else if($subSubprod=='NT')	{ echo 'Non-Tariff '; }
						else if($subSubprod=='SG') 	{ echo 'Safeguards '; }
						else if($subSubprod=='ADD') { echo 'Anti Dumping Duty '; }
						else if($subSubprod=='OTHERS') { echo 'Others '; }
						else if($subSubprod=='C') 	{ echo 'Circulars '; }
						else if($subSubprod=='I') 	{ echo 'Instructions '; }
						else if($subSubprod=='N') 	{ echo 'Notification '; }
						else if($subSubprod=='RN') 	{ echo 'Rate Notification '; }
					}

	        		if(isset($_GET["year"])) {
						echo ' - '.$_GET['year'];
					} else {
						$getProdname = mysqli_query($GLOBALS['con'],"SELECT prod_name FROM product where prod_id	 = '".$_GET['prod_id']."'");	
		       			$rowProdname = mysqli_fetch_array($getProdname);
						echo $rowProdname['prod_name'];

						if(isset($_GET['sub_prod_id'])) { 
							 
		                    $getSubProdname = mysqli_query($GLOBALS['con'],"SELECT sub_prod_name FROM sub_product where sub_prod_id = '".$_GET['sub_prod_id']."'");	
				       		$rowSubProdname = mysqli_fetch_array($getSubProdname);
							echo ' - '.$rowSubProdname['sub_prod_name'];             
						}
					}
				?>
			</li>
	    </ol>
    </h1>
	<div class="col-md-16">

	<?php
		$prod = $_GET["prod_id"];

		$getDbRecord = getDbRecord('product', 'prod_id', $prod);
		$dataType = $getDbRecord['dbsuffix']; 

		$tableName = 'casedata_'.$dataType;
 
 		$subprod = $_GET["sub_prod_id"];

		$getSubProdRow = getDbRecord('sub_product', 'sub_prod_id', $subprod);
		$subProdType = $getSubProdRow['sub_prod_type']; 

		if(isset($_GET["sub_subprod_id"])) {
			$subSubprod = $_GET["sub_subprod_id"];
		}

		$table = 'recent_data';
		if(isset($_GET["year"])) {
			$year = $_GET["year"];	
		}	
			
		if($_GET["s"]=='1')
		{
			$startPage= 0;
		}
		else
		{
			$startPage= $_GET["s"];
		}
		$endPage = $_GET["e"];
		
		if(($_GET['s']) && ($_GET['s']=='all'))
		{
			$limit = '';
		}
		else
		{
		$limit = "LIMIT $startPage, 20";
		}
			
		if(isset($subprod) && $subProdType == 'Judgements') {
			//judgements
			$orderby = "CAST(SUBSTR(vd.circular_no,10) AS SIGNED) DESC  ";
		} else if((isset($subprod)) && (($subprod=='23') || ($subprod=='33') ||  ($subprod=='34') || ($subprod=='37') || ($subprod=='42') || ($subprod=='43') ) )
		{
			//tariff
			$orderby = "CAST(SUBSTR(vd.circular_no,9) AS SIGNED) DESC  ";
		} 
		else
		{
			$orderby = "vd.circular_date DESC ";
		}

		if(isset($subSubprod))
		{
			if($subSubprod=='T') {
				$sub_subprod = "AND vd.sub_subprod_id ='Tariff' ";
			} else if($subSubprod=='NT') {
				$sub_subprod = "AND vd.sub_subprod_id ='Non-Tariff' ";
			} else if($subSubprod=='SG') {
				$sub_subprod = "AND vd.sub_subprod_id ='Safeguards' ";
			} else if($subSubprod=='ADD') {
				$sub_subprod = "AND vd.sub_subprod_id ='Anti Dumping Duty' ";
			} else if($subSubprod=='OTHERS') {
				$sub_subprod = "AND vd.sub_subprod_id ='Others' ";
			} else if($subSubprod=='C') {
				$sub_subprod = "AND vd.sub_subprod_id ='Circulars' ";
			} else if($subSubprod=='I') {
				$sub_subprod = "AND vd.sub_subprod_id ='Instructions' ";
			} else if($subSubprod=='N') {
				$sub_subprod = "AND vd.sub_subprod_id ='Notification' ";
			} else if($subSubprod=='RN') {
				$sub_subprod = "AND vd.sub_subprod_id ='Rate Notification' ";
			}
		}
		else
		{
			$sub_subprod = '';
		}
	//	else
		//{
		if(isset($_GET['year']))
		{
			$yearFilter = " AND year( vd.circular_date ) = '$year' ";
		}
		else {
			$yearFilter = " ";
		}

			$sql = "SELECT vd.data_id, DATE_FORMAT( circular_date, 
							GET_FORMAT( DATE, 'EUR' ) ) 'Date', vd.circular_no 'Circular No', 
							p.prod_name 'Statute', sp.sub_prod_name 'Document Type', vd.cir_subject 'Subject',		
							vd.file_path 'Path'
						FROM 
							$tableName vd, product p, sub_product sp
						WHERE 
							vd.prod_id =$prod
							AND vd.prod_id = p.prod_id
							AND vd.sub_prod_id =$subprod
							AND vd.sub_prod_id = sp.sub_prod_id
							$sub_subprod
							$yearFilter
							AND vd.active_flag = 'Y'
						order by  $orderby
					$limit";


		$result = mysqli_query($GLOBALS['con'],$sql);

			//print_r($sql);
		//}
		 
		if (mysqli_num_rows($result) == 0) {    
			echo "<div class='alert alert-danger'>No Data Found</div>";
		}		
		 else {

		
	if(isLogeedIn()) {

		if($_SESSION["userStatus"]=="expired") {
			
			include('expiredUserError.php');

		} else {
		
		if(isset($_GET['year'])) {
			$yearFilter = " AND year( vd.circular_date ) = '$year' ";
		} else {
			$yearFilter = " ";
		}
		
		$sqlCount = "SELECT count(vd.data_id)
						FROM 
							$tableName vd, product p, sub_product sp
						WHERE 
							vd.prod_id =$prod
							AND vd.prod_id = p.prod_id
							AND vd.sub_prod_id =$subprod
							AND vd.sub_prod_id = sp.sub_prod_id
							$sub_subprod
							$yearFilter
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
			if(($rec_count-$i)>0) {
			echo "<a  " ;
				if(($_GET['s']!='all')) { if(($k==$_GET['s']) || ((($_GET['s']==0) && ($i==20))) ){ echo "class='active'"; }   }
				echo " href='".$_SERVER['REQUEST_URI']."&s=$k&e=$i"."'>$j - $i</a>";
			} else {
			echo "<a ";
					if(($k==$_GET['s']) || ($rec_count <19)){ echo "class='active'"; }  
			echo "href='".$_SERVER['REQUEST_URI']."&s=$k&e=$rec_count"."'>$j - $rec_count</a>";

		}		
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
			
			$subjectLength = strlen($row['Subject']);
			$subjectRes = cleanname($row['Subject']);

		if($subjectLength > 650) {

				echo "<p>".substr($subjectRes,0,650)."... <a href='javascript:void(0)' style='text-decoration:underline' class='readMoreSubject'>[Read more]</a></p>";
	    	    echo "<p style='display:none'>".$subjectRes."</p>";
			
			} else {

	    	    echo "<p>".$subjectRes."</p>";
			
			}
			  
			echo "</div>";		
			
		    echo "</div>";

		}	

	echo "<div class='new-pagination'>";

	for($i = 1; $i <= $rec_count;$i++) {
			$j = $i;
			$k = ($i - 1);
			$i +=$rec_limit;

			if(($rec_count-$i)>0) {
				echo "<a " ;
				if(($_GET['s']!='all')) { if(($k==$_GET['s']) || ((($_GET['s']==0) && ($i==20))) ){ echo "class='active'"; }   }
				echo " href='".$_SERVER['REQUEST_URI']."&s=$k&e=$i"."'>$j - $i</a>";
			
			} else {
				echo "<a ";
					if(($k==$_GET['s']) || ($rec_count <19)){ echo "class='active'"; }  
				echo "href='".$_SERVER['REQUEST_URI']."&s=$k&e=$rec_count"."'>$j - $rec_count</a>";
			}
			
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
