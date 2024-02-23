<?php 
	$page = '';
	$seoTitle = 'Case Law - Advanced Search';
	$seoKeywords = 'Case Law - Advanced Search';
	$seoDesc = 'Case Law - Advanced Search';
	include('header.php'); 
?>
  

<script>

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
		else if (($('#YearInput').css('display')=='block') && ($('#year').val() == '0'))
		{			
			alert("Please Select Year")
			document.form2.year.focus()
			return false
		}
		else if (($('#searchKeywordInput').css('display')=='block') && (($('#keyword').val() == '') || ($('#keyword').val() == null) ))
		{			
			alert("Please Insert Keyword")
			document.form2.keyword.focus()
			return false			
		}		
		return true;
		//}
	}	

function selectCourtType(val)
	{
		if(val == "HC")
		{
			$('#courtCityInputHC').show();
			$('#courtCityInputTribunal').hide();
			$('#courtCityHC').val(0);
			$('#courtCityTribunal').val(0);
		}
		else if(val == "Tribunal")
		{
			$('#courtCityInputHC').hide();
			$('#courtCityInputTribunal').show();
			$('#courtCityHC').val(0);
		}
		else
		{
			$('#courtCityInputHC').hide();
			$('#courtCityInputTribunal').hide();
			$('#courtCityHC').val(0);
			$('#courtCityTribunal').val(0);
		}

	}
</script>

<!-- left sec start <div class="col-md-16 col-sm-16"> -->
<div class="col-md-11 col-sm-9 left-section">
	<h1>Case Law - Advance  Search
		<ol class="breadcrumb">
			<li><a href="<?php echo $getBaseUrl; ?>">Home</a></li>
			<li class="active">Case Law - Advance  Search</li>
		</ol>
	</h1>

    <div class="col-md-16">
	<?php		
		if(isLogeedIn()) { 

	?>
	<?php include "scripts/searchCaseLaw.php"; ?>
	<div class="col-md-16 table-container t-margin-20">
			<form name="form2" id="form2" action="" method="GET" class="form padding-b-15" onSubmit="return ValidateForm()">  
	      
	      	<div class="col-md-8">
				<label>Select Subject</label>
				<div class="form-group">
					<select name="searchCat"  id="searchCat" class="form-control" style="width: 60%;">
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
			<div class="clear"></div>
			<div class="col-md-8">
				<label id="searchTypeLabel">Select Court</label>
				<div class="form-group">
					<select id='courtType' name='courtType' onchange="selectCourtType(this.value);" class="form-control">
				        <option value="0">Select Court</option>
				        <option value="HC" <?php if(isset($_GET['courtType']) && $_GET['courtType']=='HC') {echo 'selected="selected"';}?>>High Court Cases</option>
				        <option value="SC" <?php if(isset($_GET['courtType']) && $_GET['courtType']=='SC') {echo 'selected="selected"';}?>>Supreme Court Cases</option>                        
				        <option value="Tribunal" <?php if(isset($_GET['courtType']) && $_GET['courtType']=='Tribunal') {echo 'selected="selected"';}?>>Tribunal</option>           
				        <option value="AAR" <?php if(isset($_GET['courtType']) && $_GET['courtType']=='AAR') {echo 'selected="selected"';}?>>Advance Ruling Authority</option>
				    </select>
			    </div>
	      	</div>
	      	<div class="col-md-8" id="courtCityInputHC" style='
		    <?php if($_GET['courtCityHC']!= '0' && $_GET['courtType']== 'HC') { echo "display:block; ";} else { echo "display:none; "; } ?>' >
			<label >Select Bench/City</label>
			<div class="form-group">

			    <select id='courtCityHC' name='courtCityHC' onchange="" class="form-control" >
			   	 	<option value="0">Select City</option>
			        <option value="ALH" <?php if(isset($_GET['courtCityHC']) && $_GET['courtCityHC']=='ALH') {echo 'selected="selected"';}?>>Allahabad</option>
			        <option value="AP" <?php if(isset($_GET['courtCityHC']) && $_GET['courtCityHC']=='AP') {echo 'selected="selected"';}?>>Andhra Pradesh</option>
			        <option value="GAU" <?php if(isset($_GET['courtCityHC']) && $_GET['courtCityHC']=='GAU') {echo 'selected="selected"';}?>>Gauhati</option>
			        <option value="CHG" <?php if(isset($_GET['courtCityHC']) && $_GET['courtCityHC']=='CHG') {echo 'selected="selected"';}?>>Chhattishgarh</option>
			        <option value="DEL" <?php if(isset($_GET['courtCityHC']) && $_GET['courtCityHC']=='DEL') {echo 'selected="selected"';}?>>Delhi</option>
			        <option value="BOM" <?php if(isset($_GET['courtCityHC']) && $_GET['courtCityHC']=='BOM') {echo 'selected="selected"';}?>>Bombay</option>
			        <option value="GUJ" <?php if(isset($_GET['courtCityHC']) && $_GET['courtCityHC']=='GUJ') {echo 'selected="selected"';}?>>Gujarat</option>
			        <option value="P_H" <?php if(isset($_GET['courtCityHC']) && $_GET['courtCityHC']=='P_H') {echo 'selected="selected"';}?>>Punjab & Haryana</option>
			        <option value="J_K" <?php if(isset($_GET['courtCityHC']) && $_GET['courtCityHC']=='J_K') {echo 'selected="selected"';}?>>Jammu & Kashmir</option>
			        <option value="JHR" <?php if(isset($_GET['courtCityHC']) && $_GET['courtCityHC']=='JHR') {echo 'selected="selected"';}?>>Jharkhand</option>
			        <option value="KER" <?php if(isset($_GET['courtCityHC']) && $_GET['courtCityHC']=='KER') {echo 'selected="selected"';}?>>Kerala</option>
			        <option value="KAR" <?php if(isset($_GET['courtCityHC']) && $_GET['courtCityHC']=='KAR') {echo 'selected="selected"';}?>>Karnataka</option>
			        <option value="RAJ" <?php if(isset($_GET['courtCityHC']) && $_GET['courtCityHC']=='RAJ') {echo 'selected="selected"';}?>>Rajasthan</option>
			        <option value="ORI" <?php if(isset($_GET['courtCityHC']) && $_GET['courtCityHC']=='ORI') {echo 'selected="selected"';}?>>Odisha</option>
			        <option value="MAD" <?php if(isset($_GET['courtCityHC']) && $_GET['courtCityHC']=='MAD') {echo 'selected="selected"';}?>>Madras</option>
			        <option value="UTR" <?php if(isset($_GET['courtCityHC']) && $_GET['courtCityHC']=='UTR') {echo 'selected="selected"';}?>>Uttarakhand</option>
			        <option value="CAL" <?php if(isset($_GET['courtCityHC']) && $_GET['courtCityHC']=='CAL') {echo 'selected="selected"';}?>>Calcutta</option>
			        <option value="MP" <?php if(isset($_GET['courtCityHC']) && $_GET['courtCityHC']=='MP') {echo 'selected="selected"';}?>>Madhya Pradesh</option>
			        <option value="SIK" <?php if(isset($_GET['courtCityHC']) && $_GET['courtCityHC']=='SIK') {echo 'selected="selected"';}?>>Sikkim</option>
			        <option value="MEG" <?php if(isset($_GET['courtCityHC']) && $_GET['courtCityHC']=='MEG') {echo 'selected="selected"';}?>>Meghalaya</option>
			        <option value="HP" <?php if(isset($_GET['courtCityHC']) && $_GET['courtCityHC']=='HP') {echo 'selected="selected"';}?>>Himachal Pradesh</option>
			        <option value="PAT" <?php if(isset($_GET['courtCityHC']) && $_GET['courtCityHC']=='PAT') {echo 'selected="selected"';}?>>Patna</option>
			 	</select>
			 	</div>
		  	</div>
		  
		    <div class="col-md-8" id="courtCityInputTribunal"  style='
		        <?php if($_GET['courtCityTribunal']!= '0' && $_GET['courtType']== 'Tribunal') { echo "display:block; ";} else { echo "display:none; "; }  ?>'  >
			<label >Select Bench/City</label>
			<div class="form-group">

			    <select id='courtCityTribunal' name='courtCityTribunal' onchange="" class="form-control" >
			    	<option value="0">Select City</option>
			        <option value="DEL" <?php if(isset($_GET['courtCityTribunal']) && $_GET['courtCityTribunal']=='DEL') {echo 'selected="selected"';}?>>Delhi</option>
			        <option value="AHM" <?php if(isset($_GET['courtCityTribunal']) && $_GET['courtCityTribunal']=='AHM') {echo 'selected="selected"';}?>>Ahmedabad</option>
			        <option value="BLR" <?php if(isset($_GET['courtCityTribunal']) && $_GET['courtCityTribunal']=='BLR') {echo 'selected="selected"';}?>>Bangalore</option>
			        <option value="MUM" <?php if(isset($_GET['courtCityTribunal']) && $_GET['courtCityTribunal']=='MUM') {echo 'selected="selected"';}?>>Mumbai</option>
			        <option value="CHE" <?php if(isset($_GET['courtCityTribunal']) && $_GET['courtCityTribunal']=='CHE') {echo 'selected="selected"';}?>>Chennai</option>
			 	</select>
			 	</div>
		  	</div>

	      	<div class="clear"></div>
	      	<div class="col-md-8">
	      		<label id="searchTypeLabel">Enter Year</label>
				<div class="form-group">
					<input type="text" class="form-control" style="width: 22%;" id="year" placeholder="YYYY" maxlength="4" name="year" value="<?php if(isset($_GET['year'])) {echo $_GET['year'];}?>"/> 
				</div>
			</div>

			<div class="col-md-8">   	      			      	
				<label id="searchTypeLabel">Select Date</label>
				<div class="form-group" >
					<input type="text" class="form-control" id="selectDate" style="width: 43%;" placeholder="DD.MM.YYYY"  name="selectDate"   maxlength="10" value="<?php if(isset($_GET['selectDate'])) {echo $_GET['selectDate'];}?>"/>
				</div>
	    	</div>
	    	<div class="clear"></div>	      	
	      	<div class="col-md-8">
				<label id="searchTypeLabel">Select Date Range</label>
				<div class="form-group">
					<input type="text" class="form-control" placeholder="From Date" style="width : 43%;" name="fromDate" value="<?php if(isset($_GET['fromDate'])) {echo $_GET['fromDate'];}?>"/>
			      	<input type="text" class="form-control" placeholder="To Date" style="width: 43%; margin-left: 10px;"  id="toDate"  name="toDate" value="<?php if(isset($_GET['toDate'])) {echo $_GET['toDate'];}?>"/>
			    </div>
	      	</div>		
	      	<div class="clear"></div>
		    <div class="col-md-8">
		      	<label id="searchTypeLabel">Party Name</label>
				<div class="form-group ">
					<input type="text" class="form-control" id="partyName" name="partyName"

				     value="<?php if(isset($_GET['partyName'])) {echo $_GET['partyName'];}?>"/> 
			    </div>
			</div>

		  	<div class="col-md-8">     
				<label id="searchTypeLabel">Citation No.</label>
				<div class="form-group ">
					<input type="text" class="form-control" id="circular_no" name="circular_no" 
				     value="<?php if(isset($_GET['circular_no'])) {echo $_GET['circular_no'];}?>"/> 
			    </div>		   		
		   	</div>	
		   	<div class="clear"></div>
	      	<div class="col-md-16">
				<label id="searchTypeLabel" style="margin-right: 3%; width: 7%;  margin-left: 56px;">Keyword</label>
				<div class="form-group">
					<?php  //search_form  ($HTTP_GET_VARS, $PHP_SELF ); ?>
				<input type="text" class="form-control" id="keyword" name="keyword"

			     value="<?php if(isset($_GET['keyword'])) {echo $_GET['keyword'];}?>"/> 
		    </div>
	      	</div>
	      	<div class="clear"></div>
	      	<div class="col-md-8">
	      	<label></label>      	
			<div class="form-group">
				<input type="submit" name="searchButton" id="searchButton" value="Search" class="btn"/>
			    <input type="reset" name="resetBtn" id="resetBtn" value="Reset Search" class="btn" onClick="window.location.href='searchCaseLawAdv';" />
		    </div>
	      	</div>
	      	<div class="clear"></div>
	      	<div><a href="searchCaseLaw"  class="pull-right">Quick Search</a></div>
			
		</form>
	</div> 
 
	<div class='contentBox mainContent'>
		<div class="resultContainerStatus" style="display:none; <?php if(isset($_GET['prod_id'])){ echo 'display:block';}?>" id="productResult">
			<label><strong>Total (<?php echo $total_pages; ?>)  </strong></label> Records for Main Product Type = <b style="color:#060">
				<?php 
						if($_GET['prod_id'] == 'ALL')
						{
							echo "ALL";
						}
						else
						{
				        $result = mysqli_query($GLOBALS['con'],"SELECT prod_name FROM product where prod_id = '".$_GET['prod_id']."'");	
			       		$row = mysqli_fetch_array($result);
						echo $row['prod_name'];					
						}	        
				?></b>
		    <a href="vatData" style="float:right; margin-top:8px;">Reset Current Search Result</a>    
		</div>    
		   
		<?php
/*
		if(isset($_GET['keyword']) && $_GET['keyword'] != '')
		{
			
		search_results_title($HTTP_GET_VARS);
		search_keyword_length_check($HTTP_GET_VARS);

		search_files($server_name, $doc_root, $search_dir, $file_types, $file_skip, $file_hits, $file_terms, $file_bytes, $HTTP_GET_VARS);

		search_no_hits($HTTP_GET_VARS, $count_hits);

		}else 
*/

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

		if(isset($_GET['searchCat']))
			{
					//	print_r($_GET);
			//print_r($_GET);
			$searchCat = $_GET["searchCat"];

			$getDbRecord = getDbRecord('product', 'prod_id', $searchCat);
			$dataType = $getDbRecord['dbsuffix']; 	

			$tableName = 'casedata_'.$dataType;

			if($_GET["courtType"]=='0')			{	$courtType = 'null';		}	else	{	$courtType = $_GET["courtType"];					}
			if($_GET["courtCityHC"]=='0')		{	$courtCityHC = 'null';		}	else	{	$courtCityHC = $_GET["courtCityHC"];				}
			if($_GET["courtCityTribunal"]=='0')	{	$courtCityTribunal = 'null';}	else	{	$courtCityTribunal = $_GET["courtCityTribunal"];	}
			if($_GET["year"]=='')				{	$year = 'null';				}	else	{	$year = $_GET["year"];								}
			if($_GET["partyName"]=='')			{	$partyName = 'null';		}	else	{	$partyName = $_GET["partyName"];					}
			if($_GET["circular_no"]=='')		{	$circular_no = 'null';		}	else	{	$circular_no = $_GET["circular_no"];				}
			if($_GET["keyword"]=='')			{	$keyword = 'null';			}	else	{	$keyword = $_GET["keyword"];						}
			if($_GET["selectDate"]=='')			{	$selectDate = 'null';		}	else	{	$selectDate = $_GET["selectDate"];					}


			//HC Court List
			if ($courtCityHC == 'P_H')
			{
				$courtCityHCSQL = " AND vd.circular_no like '%-P&H%'" ;
			}
			else if ($courtCityHC == 'J_K')
			{
				$courtCityHCSQL = " AND vd.circular_no like '%-J&K%'" ;
			}
			else if($courtCityHC == 'GAU')
			{
				$courtCityHCSQL = " AND (vd.circular_no like '%-GAU%' OR vd.circular_no like '%-GHT%')" ;
			}
			else if ($courtCityHC == 'CHG')
			{
				$courtCityHCSQL = " AND (vd.circular_no like '%-CHG%' OR vd.circular_no like '%-CHHG%')" ;
			}
			else if ($courtCityHC == 'JHR')
			{
				$courtCityHCSQL = " AND (vd.circular_no like '%-JHR%' OR vd.circular_no like '%-JHAR%')" ;
			}
			else if ($courtCityHC == 'KER')
			{
				$courtCityHCSQL = " AND (vd.circular_no like '%-KER%' OR vd.circular_no like '%-ERNK%')" ;
			}
			else if ($courtCityHC == 'KAR')
			{
				$courtCityHCSQL = " AND (vd.circular_no like '%-KAR%' OR vd.circular_no like '%-BANG%'  OR vd.circular_no like '%-BLR%')" ;
			}
			else if ($courtCityHC == 'RAJ')
			{
				$courtCityHCSQL = " AND (vd.circular_no like '%-RAJ%' OR vd.circular_no like '%-JDPR%'  OR vd.circular_no like '%-JAI%')" ;
			}
			else if ($courtCityHC == 'ORI')
			{
				$courtCityHCSQL = " AND (vd.circular_no like '%-ORI%' OR vd.circular_no like '%-ODI%')" ;
			}
			else if ($courtCityHC == 'UTR')
			{
				$courtCityHCSQL = " AND (vd.circular_no like '%-UTR%' OR vd.circular_no like '%-UTTR%')" ;
			}
			else if ($courtCityHC == 'CAL')
			{
				$courtCityHCSQL = " AND (vd.circular_no like '%-CAL%' OR vd.circular_no like '%-KOL%')" ;
			}
			else if ($courtCityHC == 'MP')
			{
				$courtCityHCSQL = " AND (vd.circular_no like '%-MP%' OR vd.circular_no like '%-IND%'  OR vd.circular_no like '%-GWA%'  OR vd.circular_no like '%-INDR%')" ;
			}
			else
			{
				$courtCityHCSQL = " AND vd.circular_no like '%-".$courtCityHC."%'" ;
			}


			//Tribunal Court List
			if($courtCityTribunal == 'AHM')
			{
				$courtCityTribunalSQL = " AND (vd.circular_no like '%-AHM%' OR vd.circular_no like '%-AH%')" ;
			}
			else if ($courtCityTribunal == 'BLR')
			{
				$courtCityTribunalSQL = " AND (vd.circular_no like '%-BLR%' OR vd.circular_no like '%-BANG%')" ;
			}
			else
			{
				$courtCityTribunalSQL = " AND vd.circular_no like '%-".$courtCityTribunal."%'" ;
			}

			$fromDate = $_GET["fromDate"];
			$toDate = $_GET["toDate"];
			$searchButton = $_GET["searchButton"];

				if($searchCat == '1')
				{
					if($courtType == 'HC') 				{	$courtTypeSQL = " AND (vd.sub_prod_id =  '4')"; }
					else if($courtType == 'SC') 		{	$courtTypeSQL = " AND (vd.sub_prod_id =  '3')"; }
					else 								{	$courtTypeSQL = " AND (vd.sub_prod_id =  '3' OR vd.sub_prod_id =  '4')"; }
				}
				else if($searchCat == '2')
				{
					if($courtType == 'HC') 				{	$courtTypeSQL = " AND (vd.sub_prod_id =  '9')"; }
					else if($courtType == 'SC') 		{	$courtTypeSQL = " AND (vd.sub_prod_id =  '8')"; }
					else if($courtType == 'Tribunal') 	{	$courtTypeSQL = " AND (vd.sub_prod_id =  '10')"; }
					else if($courtType == 'AAR') 		{	$courtTypeSQL = " AND (vd.sub_prod_id =  '11')"; }
					else 								{	$courtTypeSQL = " AND (vd.sub_prod_id =  '8' OR vd.sub_prod_id =  '9' OR vd.sub_prod_id =  '10' OR vd.sub_prod_id =  '11')"; }
				}
				else if($searchCat == '4')
				{
					if($courtType == 'HC') 				{	$courtTypeSQL = " AND (vd.sub_prod_id =  '25')"; }
					else if($courtType == 'SC') 		{	$courtTypeSQL = " AND (vd.sub_prod_id =  '24')"; }
					else if($courtType == 'Tribunal') 	{	$courtTypeSQL = " AND (vd.sub_prod_id =  '26')"; }
					else if($courtType == 'AAR') 		{	$courtTypeSQL = " AND (vd.sub_prod_id =  '27')"; }
					else 								{	$courtTypeSQL = " AND (vd.sub_prod_id =  '24' OR vd.sub_prod_id =  '25' OR vd.sub_prod_id =  '26' OR vd.sub_prod_id =  '27')"; }
				}
				else if($searchCat == '5')
				{
					if($courtType == 'HC') 				{	$courtTypeSQL = " AND (vd.sub_prod_id =  '40')"; }
					else if($courtType == 'SC') 		{	$courtTypeSQL = " AND (vd.sub_prod_id =  '39')"; }
					else if($courtType == 'Tribunal') 	{	$courtTypeSQL = " AND (vd.sub_prod_id =  '41')"; }
					else if($courtType == 'AAR') 		{	$courtTypeSQL = " AND (vd.sub_prod_id =  '38')"; }
					else 								{	$courtTypeSQL = " AND (vd.sub_prod_id =  '38' OR vd.sub_prod_id =  '39' OR vd.sub_prod_id =  '40' OR vd.sub_prod_id =  '41')"; }
				}
				 

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
				 ";
					if($searchCat != '0')
					{
					$sql = $sql." ".$courtTypeSQL;
					}
						
					if($fromDate!='' && $toDate != '')
					{
					$sql = $sql." AND vd.circular_date between '$fromDate' and '$toDate'";
					}	

					if($courtCityHC != 'null')
					{
					$sql = $sql." ".$courtCityHCSQL;
					}
					
					if($courtCityTribunal != 'null')
					{
					$sql = $sql." ".$courtCityTribunalSQL;
					}
					
					if($circular_no != 'null' && $partyName != 'null' && $keyword != 'null') {	

					$sql = $sql." AND (vd.circular_no like '%".$circular_no."%' AND SUBSTR(vd.cir_subject,1,230) like '%".$partyName."%' AND vd.cir_subject like '%".$keyword."%' )"; 	

					} else  if($circular_no != 'null' && $partyName != 'null' ) {	

					$sql = $sql." AND (vd.circular_no like '%".$circular_no."%' AND SUBSTR(vd.cir_subject,1,230) like '%".$partyName."%' )"; 	

					} else  if($circular_no != 'null' && $keyword != 'null') {	

					$sql = $sql." AND (vd.circular_no like '%".$circular_no."%' AND vd.cir_subject like '%".$keyword."%' )"; 	

					} else if($partyName != 'null' && $keyword != 'null') {	

					$sql = $sql." AND (SUBSTR(vd.cir_subject,1,230) like '%".$partyName."%' AND vd.cir_subject like '%".$keyword."%' )"; 	

					} else if($circular_no != 'null') {	

					$sql = $sql." AND vd.circular_no like '%".$circular_no."%'"; 	

					} else  if($partyName != 'null') {	

					$sql = $sql." AND SUBSTR(vd.cir_subject,1,230) like '%".$partyName."%'";

					} else if($keyword != 'null') {	

					$sql = $sql." AND vd.cir_subject like '%".$keyword."%' ";

					}

	
					if($year != 'null')
					{		
					$sql = $sql." AND SUBSTR(vd.circular_no,1,5)='".$year."-'";
					}
					
					if($selectDate != 'null')
					{
						$sql = $sql." AND SUBSTR(vd.cir_subject,1,100) like '%".$selectDate."%'"; 
					}

					$sql = $sql." order by  CAST(SUBSTR(vd.circular_no,10) AS SIGNED) DESC ";
						
					//echo '<div style="display:none">'.$sql.'</div>';
				//echo $sql;
			$sqlWithLimit = $sql ." ".$limit;

			$result = mysqli_query($GLOBALS['con'],$sqlWithLimit);
		$fields_num = mysqli_num_fields($result);
		$num_rows = mysqli_num_rows(mysqli_query($GLOBALS['con'],$sql));
		
		if($num_rows == 0) {
	 		echo "<div class='alert alert-danger t-margin-20' >There are no records found for <strong>'".$searchKeyword."'</strong> </div>\n";
		} else {
	 		echo "<div class='alert alert-success t-margin-20' style='text-align: left;'>$num_rows  records found for Search
	 		<a href='searchCaseLawAdv' style='float:right;'>Reset Current Search Result</a></div>\n";
		}
 
			?>

	<?php	

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

        	$circular_no = preg_replace("/($keyword)/i", "<mark>$1</mark>", $circular_no)."</p>";	
		//		echo $file_extn;
				echo "<div class='contentBox widget-box $CatgoryClass'><h4>";	

				echo getCircularLink($encryptID, $dataType, $circular_no);	


				echo "<span style='color:#ff7808'>{$row['Document Type']} </span>   <span>&nbsp; | &nbsp;</span>";
				echo "<span style='color:#58a9da'>{$row['Statute']} </span>    ";
	       		 if(isset($row['State']) != '') {

					echo " <span>&nbsp; | &nbsp;</span><span>{$row['State']} </span>   ";
	       		 }
				echo "<span>{$row['Date']} | &nbsp;</span>";
				echo "</h4>";

	        	echo getDownloadIcon($encryptID, $dataType);			         	 
		   
					//echo "<strong style='float: right; margin-right: 10px; margin-top: 0px;'>{$row['Date']}</strong>";

					echo "<div class='clear'></div>";
			$subject = cleanname($row['Subject']);

       // echo "<p>".$subject."</p>";		
       echo "<p>".preg_replace("/($keyword)/i", "<mark>$1</mark>", $subject)."</p>";		
 
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

<?php include('footer.php') ?>
