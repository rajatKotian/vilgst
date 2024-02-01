<?php 
	$page = '';
	include('header.php');
	ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
    <!-- left sec start <div class="col-md-16 col-sm-16"> -->
    <div id="show_gst_rate" style="display: none;"></div> 
    <div class="col-md-11 col-sm-9 left-section main_div">
    <h1>
      	<?php 

     		$getProdname = mysqli_query($GLOBALS['con'],"SELECT prod_name FROM product where prod_id	 = '".$_GET['prod_id']."'");	
       		$rowProdname = mysqli_fetch_array($getProdname);
       		if ($rowProdname['prod_name']=="SGST") {
       			echo "GST";
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
       		} else{
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
       		}
       	?>
 
      	<ol class="breadcrumb">
	        <li><a href="<?php echo $getBaseUrl; ?>">Home</a></li>
		        <?php 
		        	if(isset($_GET["year"])) {
						echo '<li><a href="javascript:void(0)" onclick="javascript:history.go(-1);return false;">'; 
						$getProdname = mysqli_query($GLOBALS['con'],"SELECT prod_name FROM product where prod_id	 = '".$_GET['prod_id']."'");	
		       			$rowProdname = mysqli_fetch_array($getProdname);
		       			if ($rowProdname['prod_name']=="SGST") {
		       				echo "GST";

							if(isset($_GET['sub_prod_id'])) { 
								 
			                    $getSubProdname = mysqli_query($GLOBALS['con'],"SELECT sub_prod_name FROM sub_product where sub_prod_id = '".$_GET['sub_prod_id']."'");	
					       		$rowSubProdname = mysqli_fetch_array($getSubProdname);
					       		if(!isset($_GET["sub_subprod_id"])) {
								echo ' - '.$rowSubProdname['sub_prod_name'];             
								}
							}
		       			} else{
		       				echo $rowProdname['prod_name'];

							if(isset($_GET['sub_prod_id'])) { 
								 
			                    $getSubProdname = mysqli_query($GLOBALS['con'],"SELECT sub_prod_name FROM sub_product where sub_prod_id = '".$_GET['sub_prod_id']."'");	
					       		$rowSubProdname = mysqli_fetch_array($getSubProdname);
					       		if(!isset($_GET["sub_subprod_id"])) {
								echo ' - '.$rowSubProdname['sub_prod_name'];             
								}
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
			
		if($_GET["s"]==0)
		{
			$startPage= 1;
		}
		else
		{
			$startPage= $_GET["s"];
		}
		//$endPage = $_GET["e"];
		$showRecordPerPage="20";
		$startFrom = ($startPage * $showRecordPerPage) - $showRecordPerPage;
		
		if(($_GET['s']) && ($_GET['s']=='all'))
		{
			$limit = '';
		}
		else
		{
		$limit = "LIMIT $startFrom, $showRecordPerPage";
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
		if(isset($_GET['year']) && $subProdType == 'Judgements')
		{
			$yearFilter = " AND CAST(SUBSTR(vd.circular_no,1) AS SIGNED) = '$year' ";
		}
		else if(isset($_GET['year'])){
			$yearFilter = " AND year( vd.circular_date ) = '$year' ";
		}
		else {
			$yearFilter = " ";
		}

			$sql = "SELECT vd.data_id, DATE_FORMAT( circular_date, 
							GET_FORMAT( DATE, 'EUR' ) ) 'Date', vd.circular_no 'Circular No', 
							p.prod_name 'Statute', sp.sub_prod_name 'Document Type', vd.cir_subject 'Subject',		
							vd.file_path 'Path',vd.party_name 'party_name',vd.eq_citation 'eq_citation'
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

		$res_count= mysqli_num_rows($result);
	if(isLogeedIn()) {

		if($_SESSION["userStatus"]=="expired") {
			
			include('expiredUserError.php');

		} else {
		
		if(isset($_GET['year']) && $subProdType == 'Judgements')
		{
			$yearFilter = " AND CAST(SUBSTR(vd.circular_no,1) AS SIGNED) = '$year' ";
		}
		else if(isset($_GET['year'])){
			$yearFilter = " AND year( vd.circular_date ) = '$year' ";
		}
		else {
			$yearFilter = " ";
		}
		//count(vd.data_id)
		$sqlCount = "SELECT vd.data_id
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
	
		$rowCount = mysqli_num_rows($resultCount);
		$rec_count = $rowCount;
		$rec_limit = 19;
		$from=$startFrom +1;
		$to=$from + $res_count-1;
		$lastPage = ceil($rec_count/$showRecordPerPage);

		echo "<div class='new-pagination'>";
			echo "<a ";  
			echo "style='color:black;'>Showing $from to $to of <b>$rec_count Records</b></a>";
		// for($i = 1; $i <= $rec_count;$i++) {
		// 	$j = $i;
		// 	$k = ($i - 1);
		// 	$i +=$rec_limit;
		// 	//echo ;
		// 	if(($rec_count-$i)>0) {
		// 	echo "<a  " ;
		// 		if(($_GET['s']!='all')) { if(($k==$_GET['s']) || ((($_GET['s']==0) && ($i==20))) ){ echo "class='active'"; }   }
		// 		echo " href='".$_SERVER['REQUEST_URI']."&s=$k&e=$i"."'>$j - $i</a>";
		// 	} else {
		// 	echo "<a ";
		// 			if(($k==$_GET['s']) || ($rec_count <19)){ echo "class='active'"; }  
		// 	echo "href='".$_SERVER['REQUEST_URI']."&s=$k&e=$rec_count"."'>$j - $rec_count</a>";

		// }		
		// }

		// if($rec_count >20) {
		// 	echo "<a ";
		// 			if($_GET['s']=='all'){ echo "class='active'"; }  
		// 	echo "href='".$_SERVER['REQUEST_URI']."&s=all"."' >All</a>";
		// }
		
		echo "</div><div class='clear'></div>";
		?>	
		<nav class="navigation pagination pagination1 fontNeuron" role="navigation">
			<ul class="pagination">
    		<?php
    			$previousPage = $startPage - 1;
    		?>
    			<li class="page-item active">
    				<a class="page-link" href="<?php echo $_SERVER['REQUEST_URI'];?>&s=0 &e=<?php echo $to;?>" tabindex="-1" aria-label="Previous">
          				<span aria-hidden="true">First</span>
          			</a>		
    			</li>
    			
    		<?php
    			if($startPage >= 2 && $previousPage!=1){
    		?>
				<li class="page-item">
					<a class="page-numbers" href="<?php echo $_SERVER['REQUEST_URI'];?>&s=<?php echo $previousPage; ?>"><?php echo $previousPage ?></a>
				</li>
    		<?php		
    			}
    			$c_page=$startPage;
    			for($i=1;$i<=10;$i++)
    			{
    				if($c_page<=$lastPage)
    				{
    					if($c_page==1){
    						$c_page++;
    					}else{	
    		?>
		    				<li class="page-item <?php if($c_page==$startPage){echo "active";}?>">
		    					<a class="page-numbers" href="<?php echo $_SERVER['REQUEST_URI'];?>&s=<?php echo $c_page ?>"><?php echo $c_page++;?></a>
		    				</li>
    		<?php		
    					}
    				}
    			} 
    		?>
    			<li class="page-item">
          			<a class="page-numbers" href="<?php echo $_SERVER['REQUEST_URI'];?>&s=<?php echo $lastPage ?>" aria-label="Next">
          				<span aria-hidden="true">Last</span>
          			</a>
          		</li>	
    		</ul>
    	</nav>
	<?php

		
		while($row = mysqli_fetch_array($result)) {

		$file_path = $row['Path'];
			$file_extn = strtolower(substr($file_path,-3));
			$CatgoryClass = preg_replace('/\s+/', '', $row['Statute'])."section";
			$encryptID = base64_encode(base64_encode($row['data_id']));

			echo "<div class='widget-box $CatgoryClass'>";	
	        echo "<h4>";

	        $circular_no = $row['Circular No'] ? $row['Circular No'] : $row['Subject'];

			if(empty($file_path)){
	        	echo getEmptyCircularLink($encryptID, $dataType, $circular_no);
	        }else{
	        	echo getCircularLink($encryptID, $dataType, $circular_no);
	        }			 
			echo getDownloadIcon($encryptID, $dataType);		         	 
			
			if($subProdType == 'Acts') {
				echo "&nbsp;";
			} else {
				echo "<span style='color:#ff7808'>{$row['Document Type']} </span>   <span>&nbsp; | &nbsp;</span>";
				if ($prod==7) {
			        $gst = "GST";
					echo "<span style='color:#58a9da'>{$gst} </span>    ";
				} else{
				    echo "<span style='color:#58a9da'>{$row['Statute']} </span>    ";
				}
           		 if(isset($row['State']) != '') {
    
    				echo " <span>&nbsp; | &nbsp;</span><span>{$row['state_name']} </span>   ";
           		 }
	       		echo "<span>{$row['Date']} | &nbsp;</span>";
				//echo "<strong style='float: right; margin-right: 10px; margin-top: 0px;'>{$row['Date']}</strong>";
			}
			echo "</h4>";

			echo "<div class='widget-content'>";
			
			$subjectLength = strlen($row['Subject']);
			$subjectRes = cleanname($row['Subject']);
			
            if(!empty($row['eq_citation'])) {
				echo "<h4>";
				echo "<p style='font-weight:550; color: #ff8305;margin-bottom: 0px; text-transform: capitalize; float : left;'> Equivalent Citation : &nbsp;&nbsp;</p><p style='margin-bottom: 0px; float : left;color:#444;font-weight:400;'>".$row['eq_citation']."</p>";
				echo "</h4>";
	       	}

			if(!empty($row['party_name'])) {
				echo "<h4>";
				echo "<strong style='color:#444; font-size: 13px;'>".$row['party_name']."</strong>";
				echo "</h4>";
	       	}
	       	
		if($subjectLength > 650) {

				echo "<p>".substr($subjectRes,0,650)."... <a href='javascript:void(0)' style='text-decoration:underline' class='readMoreSubject'>[Read more]</a></p>";
	    	    echo "<p style='display:none'>".$subjectRes."</p>";
			
			} else {

	    	    echo "<p>".$subjectRes."</p>";
			
			}
			  
			echo "</div>";		
			
		    echo "</div>";

		}	

	// echo "<div class='new-pagination'>";
	// //echo $_SERVER['REQUEST_URI'];

	// for($i = 1; $i <= $rec_count;$i++) {
	// 		$j = $i;
	// 		$k = ($i - 1);
	// 		$i +=$rec_limit;

	// 		if(($rec_count-$i)>0) {
	// 			echo "<a " ;
	// 			if(($_GET['s']!='all')) { if(($k==$_GET['s']) || ((($_GET['s']==0) && ($i==20))) ){ echo "class='active'"; }   }
	// 			echo " href='".$_SERVER['REQUEST_URI']."&s=$k&e=$i"."'>$j - $i</a>";
			
	// 		} else {
	// 			echo "<a ";
	// 				if(($k==$_GET['s']) || ($rec_count <19)){ echo "class='active'"; }  
	// 			echo "href='".$_SERVER['REQUEST_URI']."&s=$k&e=$rec_count"."'>$j - $rec_count</a>";
	// 		}
			
	// 	}

	// 	if($rec_count >20) {
	// 		echo "<a ";
	// 		if($_GET['s']=='all'){ echo "class='active'"; }  
	// 		echo "href='".$_SERVER['REQUEST_URI']."&s=all"."' >All</a>";			
	// 	}
		
	// 	echo "</div><div class='clear'></div>";

	// 	mysqli_free_result($result);
	?>
		<nav class="navigation pagination pagination1 fontNeuron" role="navigation">
    				<ul class="pagination">
		    		<?php
		    			$previousPage = $startPage - 1;
		    		?>
		    			<li class="page-item active">
		    				<a class="page-link" href="<?php echo $_SERVER['REQUEST_URI'];?>&s=0 &e=<?php echo $to;?>" tabindex="-1" aria-label="Previous">
		          				<span aria-hidden="true">First</span>
		          			</a>		
		    			</li>
		    			
		    		<?php
		    			if($startPage >= 2 && $previousPage!=1){
		    		?>
	    				<li class="page-item">
	    					<a class="page-numbers" href="<?php echo $_SERVER['REQUEST_URI'];?>&s=<?php echo $previousPage; ?>"><?php echo $previousPage ?></a>
	    				</li>
		    		<?php		
		    			}
		    			$c_page=$startPage;
		    			for($i=1;$i<=10;$i++)
		    			{
		    				if($c_page<=$lastPage)
		    				{
		    					if($c_page==1){
		    						$c_page++;
		    					}else{	
		    		?>
				    				<li class="page-item <?php if($c_page==$startPage){echo "active";}?>">
				    					<a class="page-numbers" href="<?php echo $_SERVER['REQUEST_URI'];?>&s=<?php echo $c_page ?>"><?php echo $c_page++;?></a>
				    				</li>
		    		<?php		
		    					}
		    				}
		    			} 
		    		?>
		    			<li class="page-item">
		          			<a class="page-numbers" href="<?php echo $_SERVER['REQUEST_URI'];?>&s=<?php echo $lastPage ?>" aria-label="Next">
		          				<span aria-hidden="true">Last</span>
		          			</a>
		          		</li>	
		    		</ul>
		    	</nav>
	<?php	    	
		}
	} else {

		include('loggedInError.php');
	 
	}

	 }	

	?>	   					

      </div> 

    </div>
    <!-- left sec end --> 
<!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/8.3.1/firebase-app.js"></script>

<!-- TODO: Add SDKs for Firebase products that you want to use
     https://firebase.google.com/docs/web/setup#available-libraries -->
<script src="https://www.gstatic.com/firebasejs/8.3.1/firebase-analytics.js"></script>

<script>
  // Your web app's Firebase configuration
  // For Firebase JS SDK v7.20.0 and later, measurementId is optional
  var firebaseConfig = {
    apiKey: "AIzaSyDJ8GOjtJzXn0Osv8--fpf5PGtk7Y3aSSI",
    authDomain: "vilgst.firebaseapp.com",
    projectId: "vilgst",
    storageBucket: "vilgst.appspot.com",
    messagingSenderId: "493343969816",
    appId: "1:493343969816:web:2ea8047fba70f4980d696d",
    measurementId: "G-DQNYHJLPB3"
  };
  // Initialize Firebase
  firebase.initializeApp(firebaseConfig);
  firebase.analytics();
</script>
<?php 
  include('footer.php');
?> 
<script type="text/javascript">
    //  var copyLinkToClipboard = function() {
      // debugger;
      // var copyEmailBtn = $('.copy-file-link');  

      $('.copy-file-link').on('click', function(event) {  
        debugger;
        // Select the email link anchor text 
        $(".clip").css('display','block');
        var emailLink = this.previousElementSibling;
       
        var range = document.createRange();  
        range.selectNode(emailLink);  
        window.getSelection().addRange(range);  
        
        try {  
          // Now that we've selected the anchor text, execute the copy command  
          var successful = document.execCommand('copy');  
          var msg = successful ? 'successful' : 'unsuccessful';  
         // console.log('Copy email command was ' + msg);  
        } catch(err) {  
          console.log('Oops, unable to copy');  
        }  
        $(".clip").css('display','none');
        // Remove the selections - NOTE: Should use
        // removeRange(range) when it is supported  
        window.getSelection().removeAllRanges(); 

      });
    //}
    </script>
