<?php
	if(isset($_POST['downloadFile'])) {

	$filename = $_POST['file_path'];
	$file_extn = strtolower(substr($filename,-3));
	if($file_extn != 'pdf') {
		$fp = fopen($filename,"r");
		$strContent = fread($fp, filesize($filename));
		fclose($fp);
		$curDate = date('m/d/Y h:i:s a', time());
		$content = "<div style='font-family:Verdana; font-size:8.5pt; padding:5px; border:1px solid #c6bdac; margin:10px; background:#faf8f4; color:#422b03'>Downloaded from www.vatinfoline.com on $curDate </div>".$strContent;

		$filesize = filesize($filename)+149;
		header('Content-Disposition: attachment; filename='.basename($filename));
		//header("Content-Length: " . $filesize);
		echo $content;
		echo "<div style='font-family:Verdana; font-size:8.5pt; padding:5px; border:1px solid #c6bdac; margin:10px; background:#faf8f4; color:#422b03'>Downloaded from www.vatinfoline.com on $curDate </div>";
		exit();
   } else {	
 
		header('Content-Description: File Transfer'); 
		header('Content-Type: application/pdf'); 
		header('Content-Disposition: attachment; filename="'.basename($filename).'"'); 
		header('Content-Transfer-Encoding: binary'); 
		header('Expires: 0'); 
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0'); 
		header('Pragma: public'); 
		header('Content-Length: ' . filesize($filename)); 
		ob_clean(); 
		flush(); 
		readfile($filename);      
		exit();

	   }
   }
?>
<?php 
	$page = 'showIframe';
	include('header.php');
?>
<style type="text/css">
	html, body {
		overflow: auto !important;
	}
	.data-summary {
	    background: #fafafa;
	    border: 1px solid #eee;
	    border-radius: 4px;		
	    -moz-border-radius: 4px;		
	    -webkit-border-radius: 4px;		
	    border-radius: 4px;		
	    font-size: 13px;
	    font-style: italic;	    
	    padding: 5px 10px;
	}
</style>
<script type="text/javascript">
	var calcHeight = function() {
	  var the_height= document.getElementById('iFramePopupFrame').contentWindow.document.body.scrollHeight + 50;
	  document.getElementById('iFramePopupFrame').height= the_height;
	} 

</script>

    
<?php  if(isset($_GET['page']) && ($_GET['page']=="video")) {
 ?>

    <!-- left sec start <div class="col-md-16 col-sm-16"> -->
    <div class="col-md-16 col-sm-16 left-section">
      	<h1>      	
      		<ol class="breadcrumb">
		        <li><a href="<?php echo $getBaseUrl; ?>">Home</a></li>
		        <li class="active"></li>
	      	</ol>
      	</h1>
      	<div class="col-md-16">

      		<h2>Highlights of 122nd Constitutional Amendment Bill - CA Bimal Jain</h2>

			<iframe width="560" height="315" src="https://www.youtube.com/embed/Is0QySCmcDc" style="margin:20px auto" frameborder="0" allowfullscreen></iframe>
			<hr />

			<h2>Overview of Dual GST Model - CA Bimal Jain</h2>

			<iframe width="560" height="315" src="https://www.youtube.com/embed/ASuOr5sud94" style="margin:20px auto" frameborder="0" allowfullscreen></iframe>
			<hr />

			<h2>Goods and Services Tax (GST) - Need and Necessity - CA Bimal Jain</h2>

			<iframe width="560" height="315" src="https://www.youtube.com/embed/apM_HDGynoc" style="margin:20px auto" frameborder="0" allowfullscreen></iframe>
      	 	
      	</div> 

    </div>
    <!-- left sec end -->  

<?php 
} else {
			//V1Zaa1VsQlJQVDA9 = echo base64_encode(base64_encode(base64_encode(base64_encode('id'))));
			if(isset($_GET['V1Zaa1VsQlJQVDA9'])) {				
			//$encryptID = base64_encode(base64_encode($_GET['id']));
			$decryptID = base64_decode(base64_decode($_GET['V1Zaa1VsQlJQVDA9']));

				if(isset($_GET['page']) && ($_GET['page']=="recent")) {

				   $result = mysqli_query($GLOBALS['con'],"SELECT circular_no, file_path, cir_subject 'summary', sub_prod_id, prod_id FROM recent_data where  data_id = '$decryptID'");

				} else if(isset($_GET['page']) && ($_GET['page']=="features")) {

				   $result = mysqli_query($GLOBALS['con'],"SELECT subject  'circular_no', file_path, summary, feature_id 'sub_prod_id' FROM features where  feature_id = '$decryptID'");

				} else if(isset($_GET['page']) && ($_GET['page']=="articles")) {

				   $result = mysqli_query($GLOBALS['con'],"SELECT subject  'circular_no', file_path, summary, article_id 'sub_prod_id'  FROM articles where  article_id = '$decryptID'");

				} else if(isset($_GET['page']) && ($_GET['page']=="highlights")) {

				   $result = mysqli_query($GLOBALS['con'],"SELECT subject  'circular_no', file_path, summary, highlight_id 'sub_prod_id'  FROM highlights where  highlight_id = '$decryptID'");

				} else if(isset($_GET['page']) && ($_GET['page']=="budgets_analysis")) {

				   $result = mysqli_query($GLOBALS['con'],"SELECT subject  'circular_no', file_path, summary, analysis_id 'sub_prod_id'  FROM budgets_analysis where  analysis_id = '$decryptID'");

				} else if(isset($_GET['page']) && ($_GET['page']=="unionBudget")) {

				  	$result = mysqli_query($GLOBALS['con'],"SELECT circular_no, file_path, cir_subject 'summary', sub_prod_id FROM budgets_union where  data_id = '$decryptID'");

				} else if(isset($_GET['page']) && ($_GET['page']=="stateBudget")) {

				  	$result = mysqli_query($GLOBALS['con'],"SELECT subject 'circular_no', file_path, summary, budget_id 'sub_prod_id'  FROM budgets_state where  budget_id = '$decryptID'");

				} else  if(isset($_GET['datatable']) && $_GET['datatable'] != 'undefined')  {
					$tableName = 'casedata_'.$_GET['datatable'];

					$result = mysqli_query($GLOBALS['con'],"SELECT circular_no, file_path, cir_subject 'summary', sub_prod_id, prod_id FROM $tableName where  data_id = '$decryptID'");
				} else {
		 			$result = mysqli_query($GLOBALS['con'],"SELECT circular_no, file_path, sub_prod_id, prod_id FROM vat_data where  vat_data_id = '$decryptID'");

				}
			        while($row = mysqli_fetch_array($result)) {
 	
					$file_path = $row['file_path'];	
					$file_extn = strtolower(substr($file_path,-3));	
					$summary = $row['summary'];	
					$sub_prod_id = $row['sub_prod_id'];	

					$sub_prod_result = mysqli_fetch_assoc(mysqli_query($GLOBALS['con'],"SELECT sub_prod_type FROM sub_product WHERE sub_prod_id = $sub_prod_id  LIMIT 1"));

			?>
    <!-- left sec start <div class="col-md-16 col-sm-16"> -->
    <div class="col-md-16 col-sm-16 left-section">
    <form method="post" action="" id="formDownload" name="formDownload">
			      <h1>
			      <?php  
			      	if((isset($_GET['page']) && $_GET['page']=="recent") || (isset($_GET['datatable']) && $_GET['datatable'] != 'undefined')) {

			      	 	$getProdName = getDbRecord('product', 'prod_id', $row['prod_id']);
			      	 	$getSubProdName = getDbRecord('sub_product', 'sub_prod_id', $row['sub_prod_id']);
						echo "<span style='font-size: 16px; color: #666;'>".$getProdName['prod_name']. " - ".$getSubProdName['sub_prod_name']."</span> | "; 
						
			      	}
			      ?>

			      
			      		<?php echo $row['circular_no']; ?>
			      		<ol class="breadcrumb">
					        <li><a href="<?php echo $getBaseUrl; ?>">Home</a></li>
					        <li class="active"><?php echo $row['circular_no']; ?></li>
				      </ol>
			      </h1>
			      <div class="col-md-16">

			      <?php 

			      if(isset($_GET['page']) && ($_GET['page']=="articles" || $_GET['page']=="highlights" || $_GET['page']=="features" || $_GET['page']=="budgets_analysis" || $_GET['page']=="unionBudget" || $_GET['page']=="stateBudget")) {

			      	?>

			      	<div class="pull-right text-right b-margin-10">
			      	 	<ul class="list-inline" >
				           	<li><a href="#email-this-page" class="ion-email  btn open-popup-link" data-effect="mfp-zoom-in" title="Email this page">Email this page</a></li>
				           	<li><a href="javascript:void(0)" class="ion-printer btn " onclick="printIframe('iFramePopupFrame')" title="Print this page">Print this page </a></li>
				        	<li><button type="submit" class="btn" name="downloadFile" ><i class="ion-android-archive"></i> Download File</button></li>
				       	</ul>
				       	<?php  if($file_extn != 'pdf') { ?>
					   		<em>To download file as PDF, use PDF writer/printer. </em>
					   	<?php } ?>
					</div>
					<div class="clear"></div>
					<input type="hidden" value="<?php echo $file_path; ?>" name="file_path" id="file_path" />
					<div class="bordered">
			        	<iframe onLoad="calcHeight();"  id='iFramePopupFrame' name='iFramePopupFrame'  src='<?php echo $file_path; ?>' frameborder='0' allowtransparency='true' scrolling='no' width="100%" <?php  if($file_extn == 'pdf') { echo " height='1130' "; } ?> ></iframe>
			        </div>
					<div class="clear"></div>
			        <div class="pull-right text-right t-margin-10">
			      	 	<ul class="list-inline" >
				           	<li><a href="#email-this-page" class="ion-email  btn open-popup-link" data-effect="mfp-zoom-in" title="Email this page">Email this page</a></li>
				           	<li><a href="javascript:void(0)" class="ion-printer btn " onclick="printIframe('iFramePopupFrame')" title="Print this page">Print this page </a></li>
				        	<li><button type="submit" class="btn" name="downloadFile" ><i class="ion-android-archive"></i> Download File</button></li>
				       	</ul>
				       	<?php  if($file_extn != 'pdf') { ?>
					   		<em>To download file as PDF, use PDF writer/printer. </em>
					   	<?php } ?>
					</div>

			     	<?php

			      } else {

			      	$moduleAccess = "false";

			      	if(isset($_GET['page']) && ($_GET['page']=="recent")) {
			      		$tableName = 'recent_data';

						$sqlProduct = "SELECT  p.prod_name 'ProductName' 
			                    FROM $tableName vd, product p
			                    WHERE vd.data_id ='$decryptID'
			                    AND vd.prod_id = p.prod_id";
		 
		         		$resultProduct = mysqli_query($GLOBALS['con'],$sqlProduct);
      					$rowProduct = mysqli_fetch_array($resultProduct);   

			      	} else if(isset($_GET['datatable']) && $_GET['datatable'] != 'undefined')  {
						$tableName = 'casedata_'.$_GET['datatable'];

						$sqlProduct = "SELECT  p.prod_name 'ProductName' 
			                    FROM $tableName vd, product p
			                    WHERE vd.data_id ='$decryptID'
			                    AND vd.prod_id = p.prod_id";
		 
		         		$resultProduct = mysqli_query($GLOBALS['con'],$sqlProduct);
      					$rowProduct = mysqli_fetch_array($resultProduct);          

          			} 

			      	if(($_SESSION['vatAccess'] == 'Y') || ($_SESSION['STAccess'] == 'Y') || ($_SESSION['CEAccess'] == 'Y') || ($_SESSION['customsAccess'] == 'Y') || ($_SESSION['gstAccess'] == 'Y')) { 

                      if(($rowProduct['ProductName']== "VAT" || $rowProduct['ProductName']== "SGST" || $rowProduct['ProductName']== "UTGST") && ($_SESSION['vatAccess'] == 'Y')) {
                        
			      			$moduleAccess = "true";

                      } else if(($rowProduct['ProductName']== "SERVICE TAX" || $rowProduct['ProductName']== "IGST") && ($_SESSION['STAccess'] == 'Y')) {
                        
			      			$moduleAccess = "true";
                
                      } else if(($rowProduct['ProductName']== "CENTRAL EXCISE" || $rowProduct['ProductName']== "CGST") && ($_SESSION['CEAccess'] == 'Y')) {
                          
			      			$moduleAccess = "true";
                        
                      } else if(($rowProduct['ProductName']== "CUSTOMS" || $rowProduct['ProductName']== "DGFT") && ($_SESSION['customsAccess'] == 'Y')) {
                          
			      			$moduleAccess = "true";
                        
                      } else if(($rowProduct['ProductName']== "GOODS & SERVICES TAX") && ($_SESSION['gstAccess'] == 'Y')) {
                          
			      			$moduleAccess = "true";
                        
                      } 
                  }


			      	if(isLogeedIn()) {

				      	if($_SESSION["userStatus"]=="expired") {

							include('expiredUserError.php');
						
						} else if( $moduleAccess == "false" &&  $rowProduct['ProductName'] != "") {

							include('invalidModuleAccess.php');
							
						} else {
			      ?>
			      	<?php 
			      		if($sub_prod_result['sub_prod_type'] != 'Judgements') {  
			      		 	echo '<p class="data-summary">'.$summary.'</p>'; 
			      		}
			      	?>
			      	<div class="pull-right text-right b-margin-10">
			      	 	<ul class="list-inline" >
				           	<li><a href="#email-this-page" class="ion-email  btn open-popup-link" data-effect="mfp-zoom-in" title="Email this page">Email this page</a></li>
				           	<li><a href="javascript:void(0)" class="ion-printer btn " onclick="printIframe('iFramePopupFrame')" title="Print this page">Print this page </a></li>
				        	<li><button type="submit" class="btn" name="downloadFile" ><i class="ion-android-archive"></i> Download File</button></li>
				       	</ul>
				       	<?php  if($file_extn != 'pdf') { ?>
					   		<em>To download file as PDF, use PDF writer/printer. </em>
					   	<?php } ?>
					</div>
					<div class="clear"></div>
					<input type="hidden" value="<?php echo $file_path; ?>" name="file_path" id="file_path" />
					<div class="bordered">
			        	<iframe onLoad="calcHeight();"  id='iFramePopupFrame' name='iFramePopupFrame'  src='<?php echo $getBaseUrl.$file_path; ?>' frameborder='0' allowtransparency='true' scrolling='no' width="100%" <?php  if($file_extn == 'pdf') { echo " height='1130' "; } ?> ></iframe>
			        </div>
					<div class="clear"></div>
			        <div class="pull-right text-right t-margin-10">
			      	 	<ul class="list-inline" >
				           	<li><a href="#email-this-page" class="ion-email  btn open-popup-link" data-effect="mfp-zoom-in" title="Email this page">Email this page</a></li>
				           	<li><a href="javascript:void(0)" class="ion-printer btn " onclick="printIframe('iFramePopupFrame')" title="Print this page">Print this page </a></li>
				        	<li><button type="submit" class="btn" name="downloadFile" ><i class="ion-android-archive"></i> Download File</button></li>
				       	</ul>
				       	<?php  if($file_extn != 'pdf') { ?>
					   		<em>To download file as PDF, use PDF writer/printer. </em>
					   	<?php } ?>
					</div>

					<?php   } 
					} else {

						include('loggedInError.php');
					 
					} 

					
			      }
	

				}

			} 

					?>

			      </div> 
			</form>

			    </div> 
<?php  } ?> 

<?php 
  include('footer.php');
?>
