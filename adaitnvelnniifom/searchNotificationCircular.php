<?php 
$page = 'vat';
	$seoTitle = 'Notification/Circular - Quick Search';
	$seoKeywords = 'Notification/Circular - Quick Search';
	$seoDesc = 'Notification/Circular - Quick Search';
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
function showFrame(id)
	{
		window.open("showiframe?V1Zaa1VsQlJQVDA9="+id, '_blank');
	}
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
	
function ValidateForm()
	{	
		if (document.form2.searchType.value == '')
		{
			alert("Please Select Search Type")
			document.form2.searchType.focus()
			return false
		}
		else if(document.form2.searchKeyword.value == '')
		{
			alert("Please Enter Keyword")
			document.form2.searchKeyword.focus()
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
					<?php 
					$prod_id = isset($_GET['cat']) ? $_GET['cat'] : 'vat';
					echo getProdDropdownVal($prod_id); ?>			
				</div>
			</div>
	      	<div class="form-group">
				<label>Select Type</label>
				<div class="form-group">
					<select name="searchType"  class="form-control" id="searchType" onchange="searchtype(this.value)">
				           	<option value="">Select One</option>
				           	<option value="circular_no" <?php  if(isset($_GET['searchType']) && ($_GET['searchType'] == 'circular_no')){ echo "selected=selected";}?>>Circular/Notification No</option>
				           	<option value="Keyword" <?php  if(isset($_GET['searchType']) && ($_GET['searchType'] == 'Keyword')){ echo "selected=selected";}?>>Keyword</option>                        
				    </select>			
				</div>
			</div> 

			<div>
				<label id="searchTypeLabel">  <?php 
					  		if(isset($_GET['searchType']))
								{
									echo $_GET['searchType'];
								}
								else
								{
									echo "Party Name";
								}
					    ?></label>
				<div class="form-group">
					 <input type="text" id="searchKeyword"   name="searchKeyword" class="form-control" 
				    <?php 
				  		if(isset($_GET['searchKeyword']))
							{
								echo "value='".$_GET['searchKeyword']."'";
							}
				    ?>
				    />
					<?php  if(isset($_GET['searchType']) && ($_GET['searchType'] == 'Citation')){ 
					echo "<span style='float:left; margin-top:10px;' id=''>(e.g. 2015-VIL-100-BOM-ST)</span>";
						} else { ?>
			    	<span style='float:left; margin-top:10px; display:none' id='citationExample'>(e.g. 2015-VIL-100-BOM-ST)</span>
				    <?php } ?> 
			    </div>
	      	</div>		

	      	<label></label>
			<div class="form-group">
				<input type="submit" value="submit" id="submit" class="btn">								
				<input type="reset" name="resetBtn" id="resetBtn" value="Reset Search" class="btn" onClick="window.location.href='searchCaseLaw';">
		 	</div>	

		 	<div><a href="searchNotificationCircularAdv" class="pull-right">Advance Search</a></div>
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

	if(isset($_GET['searchType']) && isset($_GET['searchKeyword']))
		{
		//	print_r($_POST);
		$searchType = $_GET["searchType"];
		$searchKeyword = $_GET["searchKeyword"];	

		$dataType = $_GET["cat"];

		// $getDbRecord = getDbRecord('product', 'prod_id', $prod);
		// $dataType = $getDbRecord['dbsuffix']; 	

		$tableName = 'casedata_'.$dataType;
		//	$month = $_GET["month"];
		//	echo "%".$searchType."%";
		if($searchType == 'circular_no')
		{
			$keywordCirNo = preg_replace('/[^A-Za-z0-9\-\']/', '%', $searchKeyword); 
			//print_r($keywordCirNo);
			// sending query
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
				AND vd.circular_no like '%".$searchKeyword."%'  
				AND sp.sub_prod_type ='Notifications'
				order by vd.data_id DESC ";
			$sqlWithLimit = $sql ." ".$limit;
		}
		else if($searchType == 'Keyword')
		{
		// sending query
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
			AND vd.cir_subject REGEXP '".$searchKeyword."'
			AND sp.sub_prod_type ='Notifications'
			order by vd.data_id DESC ";
			$sqlWithLimit = $sql ." ".$limit;
		}
	//echo $sql;


		//echo $sqlWithLimit;
		$result = mysqli_query($GLOBALS['con'],$sqlWithLimit);
		$fields_num = mysqli_num_fields($result);
		$num_rows = mysqli_num_rows(mysqli_query($GLOBALS['con'],$sql));
		
		if($num_rows == 0) {
	 		echo "<div class='alert alert-danger t-margin-20' >There are no records found for <strong>'".$searchKeyword."'</strong><br><br>
			You can also try <a href='searchNotificationCircularAdv'>Advance Search</a> to explore more.  </div>\n";
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
