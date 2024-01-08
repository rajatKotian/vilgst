<?php 
$page = 'vat';
	$seoTitle = 'Notification/Circular - Advanced Search';
	$seoKeywords = 'Notification/Circular - Advanced Search';
	$seoDesc = 'Notification/Circular - Advanced Search';
	include('header.php');


	function getProdDropdownVal($prod_id) {
 
	  $prodSelect = '<select id="cat" name="cat" class="form-control required" >';
	  $result = mysqli_query($GLOBALS['con'],"SELECT prod_id, prod_name, dbsuffix FROM product");
	  while($row = mysqli_fetch_array($result)) {
	    $prodSelect .= "<option ";
	      if($prod_id == $row['dbsuffix']) {
	        $prodSelect .= " selected='selected' ";  
	      }     
	    $prodSelect .= " value='".$row['dbsuffix']."'>".$row['prod_name']."</option>";
	  } 
	  mysqli_free_result($result);

	   $prodSelect .= '</select>';
	  return $prodSelect;
	}

function searchCombination($searchKeyword) {
	 	$string = strtolower($searchKeyword);
		$patterns = array();
		$replacements = array();
		$patterns = array(
						'limited',
						'Ltd',
						'private',
						'pvt',
						'cenvat credit rules',
						'ccr',
						'input tax credit',
						'itc',
						'authority for advance ruling',
						'aar',
						'goods and services tax',
						'gst',
						'central goods and services tax',
						'cgst',
						'state goods and services tax',
						'sgst',
						'integrated goods and services tax',
						'igst',
						'union territory goods and services tax',
						'utgst',
						'central sales tax',
						'cst',
						'value added tax',
						'vat',
						'business auxiliary service',
						'bas',
						'terminal handling charges',
						'thc',
						'central board of excise & customs',
						'cbec',
						'1944: central excise act, 1944',
						'cea',
						'complete knocked down',
						'ckd',
						'duty entitlement pass book scheme',
						'depb',
						'directorate general of foreign trade',
						'dgft',
						'domestic tariff area',
						'dta',
						'export oriented unit',
						'eou',
						'free on board',
						'fob',
						'maximum retail price',
						'mrp',
						'retail sale price',
						'rsp',
						'special economic zone',
						'sez',
						'semi knocked down',
						'skd',
						'standard input output norms',
						'sion',
						'section',
						'sec');

		$replacements = array(
						'Ltd',
						'Limited',
						'Pvt',
						'private',
						'CCR',
						'Cenvat Credit Rules',
						'ITC',
						'input tax credit',
						'AAR',
						'Authority for Advance Ruling',
						'GST',
						'goods and services tax',
						'CGST',
						'central goods and services tax',
						'SGST',
						'state goods and services tax',
						'IGST',
						'integrated goods and services tax',
						'UTGST',
						'union territory goods and services tax',
						'CST',
						'Central sales tax',
						'VAT',
						'value added tax',
						'BAS',
						'Business auxiliary service',
						'THC',
						'Terminal Handling Charges',
						'CBEC',
						'Central Board of Excise & Customs',
						'CEA',
						'1944: Central Excise Act, 1944',
						'CKD',
						'Complete Knocked Down',
						'DEPB',
						'Duty Entitlement Pass Book Scheme',
						'DGFT',
						'Directorate General of Foreign Trade',
						'DTA',
						'Domestic Tariff Area',
						'EOU',
						'Export Oriented Unit',
						'FOB',
						'Free on Board',
						'MRP',
						'Maximum Retail Price',
						'RSP',
						'Retail Sale Price',
						'SEZ',
						'Special Economic Zone',
						'SKD',
						'Semi Knocked Down',
						'SION',
						'Standard Input Output Norms',
						'Sec',
						'Section'
						);
		
		$words = explode(" ", $string);
		$replaceWord = '';
		foreach($words as $word) {
			$replaceWord .= $word.' ';
			$arrlength = count($patterns);

for($x = 0; $x < $arrlength; $x++) {


    if($word == $patterns[$x]) {
		$replaceWord .= ' '.$replacements[$x];

    	//$replaceWord = preg_replace($patterns[$x], $replacements[$x], $word);
		//$replaceWord .= '-'.$replaceWord.'-';
		$replaceWord .= $replaceWord ? "|".str_replace(" ", ".+", $replaceWord) : '';
    }
    
}


			 
			
		}

		return str_replace(" ", ".+", $string);
	}
	 ?>

<script>

function reload(form,searchcase,keyword)
	{	
		self.location='searchNotificationCircular?searchcase=' + result + '&keyword='+keyword;
	}
function searchtype(val)
	{
		$('#searchKeyword').show();
		$('#searchTypeLabel').show();
		$('#searchTypeLabel').focus();
		$('.searchType').hide();
		$('#searchKeyword').val('');
		if(val == "circular_no")
		{
		$('#searchTypeLabel').html("Circular/Notification No")
		}
		
		else if(val == "Keyword")
		{
		$('#searchTypeLabel').html("Keyword")
		}
	}

function searchCategory(val)
	{
		//alert(val);
		//$('#StateInput').hide();
		//	$('#YearInput').hide();
		if(val == '0')
		{
			alert("Please Select Search Category")
		}
		else if(val == 'VAT')
		{
		//	$('#StateInput').show();
		//	$('#YearInput').show();
		///	$('#searchKeywordInput').show();
			$('#year').focus();
			var state=$('#state').val(); 	
			var searchCat=$('#searchCat').val(); 	
			self.location='searchNotificationCircularAdv?state=' + state + '&searchCat='+searchCat;
		}
		else
		{
		//			alert('non vat');
			//$('#YearInput').show();
		//	$('#searchKeywordInput').show();
			$('#year').focus()
			//var state=form2.state.options[form2.state.options.selectedIndex].value; 	
			var searchCat=$('#searchCat').val(); 		
			self.location='searchNotificationCircularAdv?searchCat='+searchCat;
		}		
			
	}
	
function searchState(val)
	{	
		var state=$('#state').val(); 	
		var searchCat=$('#searchCat').val(); 	
		self.location='searchNotificationCircularAdv?state=' + state + '&searchCat='+searchCat;
		
	}
function ValidateForm()
	{	
	//	alert($('#StateInput').css('display'));
		if ($('#searchCat').val() == '0')
		{
			alert("Please Select Search Category")
			document.form2.searchCat.focus()
			return false
		}
		 else if (($('#StateInput').css('display')=='block') && ($('#state').val() == '0'))
		{		
			alert("Please Select State")
			document.form2.state.focus()
			return false			
		}		
		else if (($('#searchKeyword').val() == '') || ($('#searchKeyword').val() == null) )
		{			
			alert("Please Insert Keyword")
			document.form2.keyword.focus()
			return false			
		}		
		return true; 
		//}
	}	
</script>

<!-- left sec start <div class="col-md-16 col-sm-16"> -->
<div class="col-md-11 col-sm-9 left-section">
	<h1>Notification/Circular - Quick Search
		<ol class="breadcrumb">
			<li><a href="<?php echo $getBaseUrl; ?>">Home</a></li>
			<li class="active">Notification/Circular - Quick Search</li>
		</ol>
	</h1>
<div class="col-md-16">

<?php
	
			if(isLogeedIn()) { 

//	print_r($_POST);
?>
	<div class="col-md-16 table-container t-margin-20">
		<form name="form2" method="get" class="form padding-b-15"  enctype="multipart/form-data" onSubmit="return ValidateForm()"> 
	      	<div class="form-group">
				<label>Select Category </label>
				<div class="form-group">
					<select name="searchCat"  class="form-control" id="searchCat" onchange="searchCategory(this.value);">
	            	<option value="0">Please select </option>
	            	<option value="1" <?php  if(isset($_GET['searchCat']) && ($_GET['searchCat'] == '1')){ echo "selected=selected";}?>>VAT</option>
	            	<option value="2" <?php  if(isset($_GET['searchCat']) && ($_GET['searchCat'] == '2')){ echo "selected=selected";}?>>SERVICE TAX</option>
	            	<option value="4" <?php  if(isset($_GET['searchCat']) && ($_GET['searchCat'] == '4')){ echo "selected=selected";}?>>CENTRAL EXCISE</option>
	            	<option value="5" <?php  if(isset($_GET['searchCat']) && ($_GET['searchCat'] == '5')){ echo "selected=selected";}?>>CUSTOMS</option>      
	            	<option value="6" <?php  if(isset($_GET['searchCat']) && ($_GET['searchCat'] == '6')){ echo "selected=selected";}?>>DGFT</option>
	            	<option value="7" <?php  if(isset($_GET['searchCat']) && ($_GET['searchCat'] == '7')){ echo "selected=selected";}?>>SGST</option>
	            	<option value="8" <?php  if(isset($_GET['searchCat']) && ($_GET['searchCat'] == '8')){ echo "selected=selected";}?>>UTGST</option>
	            	<option value="9" <?php  if(isset($_GET['searchCat']) && ($_GET['searchCat'] == '9')){ echo "selected=selected";}?>>IGST</option>
	            	<option value="10" <?php  if(isset($_GET['searchCat']) && ($_GET['searchCat'] == '10')){ echo "selected=selected";}?>>CGST</option>
	            </select>		
				</div>
			</div>
			<div>
				 <div id="StateInput" 
		            <?php 
			  		 if(isset($_GET['searchCat']) && ($_GET['searchCat'] == '1'))
						{
							echo "style='display:block'";
						}
						else
						{
								echo "style='display:none'";
						}
		    		?>>
					<label>Select State</label>
				
					<div class="form-group">
						<select  class="form-control" id='state' name='state' onchange="searchState(this.value)">
						<option value="0">Select State</option>		
						<?php
							$state=$_GET['state'];

							$result = mysqli_query($GLOBALS['con'],"SELECT state_id,state_name FROM state_master");
							if (mysqli_num_rows($result) == 0) 
							{    
							die("Query to show fields from table failed");
							} else {
								while($row = mysqli_fetch_array($result))
								{
								//echo "<option value={$row['state_id']}>{$row['state_name']}</option>";
									if($row['state_id']==@$state)

									{
										echo "<option selected value='$row[state_id]'>$row[state_name]</option>"."<BR>";
									}
									else
									{
										echo "<option value='$row[state_id]'>$row[state_name]</option>";
									}
								}	
								mysqli_free_result($result);
							}							
						?>
						</select>						
				    </div>
			    </div>
	      	</div>		

	      	<div>
				<div id="YearInput" 
					<?php 
					if(isset($_GET['searchCat']) && ($_GET['searchCat'] != '0' || $_GET['searchCat'] != '1'))
					{
					echo "style='display:block'";
					}
					else
					{
					echo "style='display:none'";
					}
					?>>	                    
					<label>Select Year</label>                   
		
					<div class="form-group">
						<select  class="form-control" id='year' name='year'>
							<option value="0">Select Year</option>
							<?php
								$year= isset($_GET['year']) ? $_GET['year'] : '';
								$searchCat = isset($_GET['searchCat']) ? $_GET['searchCat'] : '1' ;

								$getDbRecord = getDbRecord('product', 'prod_id', $searchCat);
								$dataType = $getDbRecord['dbsuffix']; 

								$tableName = 'casedata_'.$dataType;

								//echo $year ."-".$state ."-".$searchCat;
								if((isset($_GET['state'])) && ($_GET['state'] !='0') && ($searchCat == '1') ) {
									$state=$_GET['state'];

 									$sql = "SELECT DISTINCT YEAR(circular_date) as year 
											FROM $tableName  where state_id = '$state' order by year";

								} else if($searchCat == '2' || $searchCat == '4' || $searchCat == '5' || $searchCat == '6') {
									
 									$sql = "SELECT DISTINCT YEAR(circular_date) as year 
											FROM $tableName  ORDER by year DESC";

								} else {

									$sql = "SELECT DISTINCT YEAR(circular_date) as year 
											FROM $tableName  order by year DESC";

								}
								//echo "$sql--$state";
								$result = mysqli_query($GLOBALS['con'],$sql);
								if (!$result) 
								{    
								die("Query to show fields from table failed");
								}		
									while($row = mysqli_fetch_array($result))
									{
									//echo "<option value={$row['state_id']}>{$row['state_name']}</option>";
									if($row['year']==@$year)
									{
										echo "<option selected value='$row[year]'>$row[year]</option>"."<BR>";
									}
									else
									{
										echo "<option value='$row[year]'>$row[year]</option>";
									}
									}	
									mysqli_free_result($result);
							?>
						</select>					
				    </div>
	      		</div>
	      	</div>		
	      	

			<div>
	      		<div id="searchKeywordInput"  <?php 
					if(isset($_GET['searchCat']) && ($_GET['searchCat'] != '0'))
					{
				echo "style='display:block'";
					}
					else
					{
					echo "style='display:none'";
					}
					?>>

					<label>Keyword </label>		   		 			    				
					<div class="form-group">
						<!-- < ?php
							search_form($HTTP_GET_VARS, $PHP_SELF);
						?> 	 -->
						<?php  //search_form  ($HTTP_GET_VARS, $PHP_SELF ); ?>
				<input type="text" class="form-control" id="searchKeyword" name="searchKeyword"
				     value="<?php if(isset($_GET['searchKeyword'])) {echo $_GET['searchKeyword'];}?>"/> 					
				    </div>
			    </div>
	      	</div>		

	      	<label></label>
			<div class="form-group">
				<input type="submit" value="submit" id="submit" class="btn">								
				<input type="reset" name="resetBtn" id="resetBtn" value="Reset Search" class="btn" onClick="window.location.href='searchCaseLaw';">
		 	</div>	

			<div><a href="searchNotificationCircular" class="pull-right">Quick Search</a></div>	
		</form>
	</div> 	

    <div class='contentBox mainContent'>    
   
<div class="clear t-margin-20"></div>
	<?php

	if(isset($_GET["s"]) && isset($_GET["e"])) {
			$limitStart = $_GET["s"];
			$limitEnd = $_GET["e"];
			
			if($_GET["s"] == 'all') { 
				$limit = " "; 
			} else {
				$limit = " LIMIT ".$limitStart.", ".$limitEnd." ";	
			}
		} else {
			$limitStart = 0;
			$limitEnd = 20;
			$limit = " LIMIT $limitStart, $limitEnd ";
		}

	if(isset($_GET['searchCat']) && isset($_GET['searchKeyword']))
		{
		//	print_r($_POST);
		$searchCat = $_GET["searchCat"];
		$searchKeyword = $_GET["searchKeyword"];	
				$year = $_GET["year"];

		$getDbRecord = getDbRecord('product', 'prod_id', $searchCat);
		$dataType = $getDbRecord['dbsuffix']; 

		$tableName = 'casedata_'.$dataType;

		if($dataType == 'vat') {
			$state = $_GET["state"];

			$whereQ = " AND vd.state_id = '".$state."' AND vd.circular_date like '%".$year."%'"; 
		}else {
			$whereQ = " AND vd.circular_date like '%".$year."%'"; 

		}


		// $getDbRecord = getDbRecord('product', 'prod_id', $prod);
		// $dataType = $getDbRecord['dbsuffix']; 	

		//	$month = $_GET["month"];
		//	echo "%".$searchType."%";
		$sql =  "SELECT vd.data_id, DATE_FORMAT(circular_date,GET_FORMAT(DATE,'EUR'))'Date', 
			vd.circular_no 'Circular No', 
			sm.state_name 'State', 
			p.prod_name 'Statute', 
			sp.sub_prod_name 'Document Type', 
			vd.cir_subject 'Subject',		
			vd.file_path 'Path'
			FROM $tableName vd
			LEFT JOIN state_master sm ON vd.state_id = sm.state_id
			JOIN product p, sub_product sp
			WHERE vd.prod_id = p.prod_id
			AND vd.sub_prod_id = sp.sub_prod_id
			AND vd.active_flag = 'Y' 
			$whereQ
			AND (vd.cir_subject REGEXP '".$searchKeyword."' OR  vd.circular_no like '%".$searchKeyword."%')  
			AND sp.sub_prod_type ='Notifications'	
			order by vd.data_id DESC ";
			$sqlWithLimit = $sql ." ".$limit;
	//echo $sql;


		//echo $sqlWithLimit;
		$result = mysqli_query($GLOBALS['con'],$sqlWithLimit);
		$fields_num = mysqli_num_fields($result);
		$num_rows = mysqli_num_rows(mysqli_query($GLOBALS['con'],$sql));
		
		if($num_rows == 0) {
	 		echo "<div class='alert alert-danger t-margin-20' >There are no records found for <strong>'".$searchKeyword."'</strong> </div>\n";
		} else {
	 		echo "<div class='alert alert-success t-margin-20' style='text-align: left;'>$num_rows  records found for <strong>'".$searchKeyword."'</strong>
	 		<a href='searchNotificationCircular' style='float:right;'>Reset Current Search Result</a></div>\n";
		}

	?>

	<?php		


	//	print_r($num_rows);
		$rec_count = $num_rows;
		$rec_limit = 19;

		echo "<div class='new-pagination'>";
		for($i = 1; $i <= $rec_count; $i++) {
			$j = $i;
			$k = ($i - 1);
			$i +=$rec_limit;
			//echo ;
			if(($rec_count-$i)>0) {
			echo "<a  " ;
				if(($limitStart!='all')) { 
					if($k==$limitStart || ($limitStart==0) && ($i==20)) { 
						echo "class='active'"; 
					}   
				}
				echo " href='".$_SERVER['REQUEST_URI']."&s=$k&e=$i"."'>$j - $i</a>";
			} else {
			echo "<a ";
					if(($k==$limitStart) || ($rec_count <19)) { 
						echo "class='active'"; 
					}  
			echo "href='".$_SERVER['REQUEST_URI']."&s=$k&e=$rec_count"."'>$j - $rec_count</a>";

			}		
		}

		if($rec_count >20) {
			echo "<a ";
					if($limitStart=='all'){ echo "class='active'"; }  
			echo "href='".$_SERVER['REQUEST_URI']."&s=all"."' >All</a>";
		}
		
		echo "</div><div class='clear'></div>";

	while($row = mysqli_fetch_array($result))
	{
		$file_path = $row['Path'];
		$file_extn = strtolower(substr($file_path,-3));
		$CatgoryClass = preg_replace('/\s+/', '', $row['Statute'])."section";
		$encryptID = base64_encode(base64_encode($row['data_id']));

		$circular_no = $row['Circular No'] ? $row['Circular No'] : $row['Subject'];
 
        $circular_no = preg_replace("/($searchKeyword)/i", "<mark>$1</mark>", $circular_no)."</p>";	
		echo "<div class='widget-box   $CatgoryClass'><h4>";

		echo getCircularLink($encryptID, $dataType, $circular_no);	

			echo "<span style='color:#ff7808'>{$row['Document Type']} </span>   <span>&nbsp; | &nbsp;</span>";
				echo "<span style='color:#58a9da'>{$row['Statute']} </span>    ";
	       		 if(isset($row['State']) != '') {

					echo " <span>&nbsp; | &nbsp;</span><span>{$row['State']} </span>   ";
	       		 }
			echo "<span>{$row['Date']} | &nbsp;</span>";
				echo "</h4>";

			echo getDownloadIcon($encryptID, $dataType);			         	 

        echo "<div class='clear'></div>";
		$subject = cleanname($row['Subject']);
	    echo "<p>".preg_replace("/($searchKeyword)/i", "<mark>$1</mark>", $subject)."</p>";		
	    echo "</div>";
	}	

	echo "<div class='new-pagination'>";
		for($i = 1; $i <= $rec_count; $i++) {
			$j = $i;
			$k = ($i - 1);
			$i +=$rec_limit;
			//echo ;
			if(($rec_count-$i)>0) {
			echo "<a  " ;
				if(($limitStart!='all')) { 
					if($k==$limitStart || ($limitStart==0) && ($i==20)) { 
						echo "class='active'"; 
					}   
				}
				echo " href='".$_SERVER['REQUEST_URI']."&s=$k&e=$i"."'>$j - $i</a>";
			} else {
			echo "<a ";
					if(($k==$limitStart) || ($rec_count <19)) { 
						echo "class='active'"; 
					}  
			echo "href='".$_SERVER['REQUEST_URI']."&s=$k&e=$rec_count"."'>$j - $rec_count</a>";

			}		
		}

		if($rec_count >20) {
			echo "<a ";
					if($limitStart=='all'){ echo "class='active'"; }  
			echo "href='".$_SERVER['REQUEST_URI']."&s=all"."' >All</a>";
		}
		
		echo "</div><div class='clear'></div>";

		mysqli_free_result($result);
			}
			?>
			</div> 
			<?php
	  			} else {
	  				include('loggedInError.php');
	  			}
  	?>		
  	  
    </div> 
</div>
    <!-- left sec end -->

<?php include('footer.php') ?>
