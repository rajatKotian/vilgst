<?php
	$db_host = 'localhost';
 
 	$db_user = 'root';
 	$db_pwd = '';
 	$database = 'vilgst12_vilgstprod';

	//$db_pwd = '7d@pPn_zkwdb'; 
	//$db_user = 'vilgst12_gstweb';
	//$database = 'vilgst12_vilgstprod';

	if (!mysql_connect($db_host, $db_user, $db_pwd)) { 
		die("Can't connect to database");
	}   

	if (!mysql_select_db($database)) {
	die("Can't select database");
	} 

	
	

	function getCatDropdown($value,$data) {  
		if($data=='1'){
			$prodSelect = '<select id="prod_id" name="prod_id" class="form-control required" multiple >';	
		}else{
			$prodSelect = '<select id="prod_id" name="prod_id" class="form-control required" >';	
		}
		
	                     
		$result = mysqli_query($GLOBALS['con'],"SELECT prod_id, prod_name, dbsuffix FROM $value");
		while($row = mysqli_fetch_array($result)) {
	    	$prodSelect .= "<option ";
	    	$prodSelect .= " value='".$row['prod_id']."' data-dbsuffix='".$row['dbsuffix']."'>".$row['prod_name']."</option>";
	    }
	    mysqli_free_result($result);
	    $prodSelect .= '</select>';
	    return $prodSelect;
	} 

	function getStatDropdown($state_id, $selectValue) {
 
	  	$stateSelect = '<select id="state_id" name="state_id" class="form-control required" >
	                    <option value="0">Select State</option>';
	  	$state=$state_id; 
	  	$result = mysqli_query($GLOBALS['con'],"SELECT state_id, state_name FROM state_master");
	 	while($row = mysqli_fetch_array($result)) {
		    if($selectValue == 'statenames') {
		      $value = $row['state_name'];
		    } else {
		      $value = $row['state_id'];      
		    }

		    if($row['state_name']==@$state || $row['state_id']==@$state) {
		      $stateSelect .= "<option selected='selected' value='".$value."'>".$row['state_name']."</option>";
		    } else {
		      $stateSelect .= "<option value='".$value."'>".$row['state_name']."</option>";
		    }
	  } 
	  mysqli_free_result($result);

	   $stateSelect .= '</select>';
	  return $stateSelect;
	}   
	function getNotficationType($state_id, $selectValue) {
 
	  	$stateSelect = '<select id="state_id" name="state_id" class="form-control required" >
	                    <option value="0">Select State</option>';
	  	$state=$state_id; 
	  	$result = mysqli_query($GLOBALS['con'],"SELECT state_id, state_name FROM state_master");
	 	while($row = mysqli_fetch_array($result)) {
		    if($selectValue == 'statenames') {
		      $value = $row['state_name'];
		    } else {
		      $value = $row['state_id'];      
		    }

		    if($row['state_name']==@$state || $row['state_id']==@$state) {
		      $stateSelect .= "<option selected='selected' value='".$value."'>".$row['state_name']."</option>";
		    } else {
		      $stateSelect .= "<option value='".$value."'>".$row['state_name']."</option>";
		    }
	  } 
	  mysqli_free_result($result);

	   $stateSelect .= '</select>';
	  return $stateSelect;
	}

	function getAuthor($value){
		$author = '<select id="author" name="author" class="form-control required" >
	                    <option value="0">Select Author</option>';
	  	
	  	$result = mysqli_query($GLOBALS['con'],"SELECT author FROM $value  WHERE author <> '' GROUP BY author ASC");
	 	while($row = mysqli_fetch_array($result)) {
		    $author .= "<option value='".$row['author']."'>".$row['author']."</option>";
		}
		mysqli_free_result($result);

	   	$author .= '</select>';
	  	return $author;
	}

	// function getCourtState(){
	// 	$query=mysqli_query($GLOBALS['con'],"SELECT sp.*,p.`dbsuffix` FROM `sub_product` as sp LEFT JOIN `product` as p ON sp.`prod_id`= p.`prod_id`WHERE sp.`sub_prod_name`='High Court Cases'") or die(mysql_error());
	// 		$result=array();
	// 	while($res=mysqli_fetch_array($query, MYSQL_ASSOC)) {
	// 		$result[]="SELECT a.state_id, sm.state_name FROM casedata_".$res['dbsuffix']." as a LEFT JOIN state_master as sm ON a.state_id=sm.state_id WHERE a.sub_prod_id='".$res['sub_prod_id']."'";
	// 	}
	// 	return $sql= implode(' UNION ', $result);
	// 	return $result;
	// }

	if(isset($_REQUEST['datatype'])){

		
		if($_REQUEST['datatype']=='notification'){
?>

			<div class="col-md-16 table-container t-margin-20" style="margin: 0;">
				<form name="form2" id="form2" action="adv_search.php" method="GET" class="form padding-b-15" onSubmit="return ValidateForm()">  
	      			<input type="hidden" name="pagename" value="notification">
	      			<input type="hidden" name="function_name" value="notification">
	      			<input type="hidden" id="dbsuffix" name="dbsuffix" value="vat">
	      			<div class="col-md-8">
						<label>Category</label>
						<div class="form-group" id= "product">
								<?php echo getCatDropdown('product','');?>		
						</div>
					</div>
					<div class="col-md-8" id="state" style="display: none;">
						<label id="searchTypeLabel">State</label>
						<div class="form-group">
							<?php echo getStatDropdown('','state_id');?>
		    			</div>
	      			</div>
	      			<div class="col-md-8" id="notification_type" style="display: none;">
						<label id="searchTypeLabel">Notification Type</label>
						<div class="form-group" id="noti_div">
							<!-- <select id="not_type" name="not_type" class="form-control required">

							</select> -->
		    			</div>
	      			</div>
					<div class="clear"></div>
					<div class="col-md-8">
						<label id="searchTypeLabel"> Notification No.</label>
						<div class="form-group">
							<input type="text" class="form-control" id="notification_no" name="no" value=""/>
		    			</div>
	      			</div>
	      			<div class="col-md-8">   	      			      	
						<label id="searchTypeLabel">Keyword</label>
						<div class="form-group" >
							<input type="text" class="form-control" id="text" name="text" value=""/>
						</div>
			    	</div>	
		  			<div class="clear"></div>
					<div class="col-md-8">   	      			      	
						<label id="searchTypeLabel">Select Date</label>
						<div class="form-group" >
							<input type="date" class="form-control" id="selectDate"  placeholder="DD.MM.YYYY"  name="date" maxlength="10" value=""/>
						</div>
			    	</div>
			    	<div class="clear"></div>	      	
			      	<div class="col-md-8">
						<label id="searchTypeLabel">Select From Date</label>
						<div class="form-group">
							<input type="date" class="form-control" placeholder="From Date" id="fromDate" name="fromDate" value=""/> 	
					    </div>
			      	</div>
			      	<div class="col-md-8">
			      		<label id="searchTypeLabel">Select To Date</label>
						<div class="form-group">
			      			<input type="date" class="form-control" placeholder="To Date"  id="toDate"  name="toDate" value=""/>
			      		</div>
			      	</div>
				   	<!-- <div class="clear"></div>
			      	<div class="col-md-16">
						<label id="searchTypeLabel" style="margin-right: 3%; width: 7%;  margin-left: 56px;">Keyword</label>
						<div class="form-group">
							<?php  //search_form  ($HTTP_GET_VARS, $PHP_SELF ); ?>
							<input type="text" class="form-control" id="keyword" name="keyword"

				     		value="<?php if(isset($_GET['keyword'])) {echo $_GET['keyword'];}?>"/> 
			    		</div>
			      	</div> -->
			      	<div class="clear"></div>
	      			<div class="col-md-8">
	      				<label></label>      	
						<div class="form-group">
							<input type="submit" name="searchButton" id="searchButton" value="Search" class="btn"/>
						    <!-- <input type="reset" name="resetBtn" id="resetBtn" value="Reset Search" class="btn" onClick="window.location.href='searchCaseLawAdv';" /> -->
					    </div>
				    </div>
	      			<div class="clear"></div>
	      			<!-- <div><a href="searchCaseLaw"  class="pull-right">Quick Search</a></div> -->
				</form>
			</div>
<?php 
		}
		else if($_REQUEST['datatype']=='articles1'){
?>
			<div class="col-md-16 table-container t-margin-20" style="margin: 0;">
				<form name="form2" id="form2" action="adv_search.php" method="GET" class="form padding-b-15" onSubmit="return ValidateForm()">  
	      			<input type="hidden" name="pagename" value="articles">
	      			<input type="hidden" name="function_name" value="articles">
	      			<input type="hidden" id="dbsuffix" name="dbsuffix" value="articles">
	      			<div class="col-md-8">
						<label>Category</label>
						<div class="form-group">
							<?php echo getCatDropdown('product','');?>				
						</div>
					</div>
					<div class="col-md-8" id="state" style="display: none;">
						<label id="searchTypeLabel">State</label>
						<div class="form-group">
							<?php echo getStatDropdown('','state_id');?>
		    			</div>
	      			</div>
					<div class="col-md-8">
						<label id="searchTypeLabel">Author</label>
						<div class="form-group">
							<?php echo getAuthor('articles');?>
		    			</div>
	      			</div>
		  			<div class="clear"></div>
					<div class="col-md-8">   	      			      	
						<label id="searchTypeLabel">Keywords</label>
						<div class="form-group" >
							<input type="text" class="form-control" id="text" name="text" value=""/> 
						</div>
			    	</div>	
			    	<div class="clear"></div>      	
			      	<div class="col-md-8">
						<label id="searchTypeLabel">Select From Date</label>
						<div class="form-group">
							<input type="date" class="form-control" placeholder="From Date" id="fromDate" name="fromDate" value=""/> 	
					    </div>
			      	</div>
			      	<div class="col-md-8">
			      		<label id="searchTypeLabel">Select To Date</label>
						<div class="form-group">
			      			<input type="date" class="form-control" placeholder="To Date"  id="toDate"  name="toDate" value=""/>
			      		</div>
			      	</div>		
				   	<div class="clear"></div>
			      	<div class="col-md-16">
						<label id="searchTypeLabel" style="margin-right: 3%; width: 7%;  margin-left: 56px;">Topic</label>
						<div class="form-group">
							<?php  //search_form  ($HTTP_GET_VARS, $PHP_SELF ); ?>
							<input type="text" class="form-control" id="topic" placeholder="Enter Topic"  name="topic" value=""/>
			    		</div>
			      	</div>
			      	<div class="clear"></div>
	      			<div class="col-md-8">
	      				<label></label>      	
						<div class="form-group">
							<input type="submit" name="searchButton" id="searchButton" value="Search" class="btn"/>
						    <!-- <input type="reset" name="resetBtn" id="resetBtn" value="Reset Search" class="btn" onClick="window.location.href='searchCaseLawAdv';" /> -->
					    </div>
				    </div>
	      			<div class="clear"></div>
	      			<!-- <div><a href="searchCaseLaw"  class="pull-right">Quick Search</a></div> -->
				</form>
			</div>
<?php			
		}
		else if($_REQUEST['datatype']=='act'){
?>
			<div class="col-md-16 table-container t-margin-20" style="margin: 0;">
				<form name="form2" id="form2" action="adv_search.php" method="GET" class="form padding-b-15" onSubmit="return ValidateForm()">  
	      			<input type="hidden" name="pagename" value="Acts and Rules">
	      			<input type="hidden" name="function_name" value="act">
	      			<input type="hidden" id="dbsuffix" name="dbsuffix" value="vat">
	      			<div class="col-md-8">
						<label>Category</label>
						<div class="form-group" id= "product">
								<?php echo getCatDropdown('product','');?>		
						</div>
					</div>
					<div class="col-md-8" id="state" style="display: none;">
						<label id="searchTypeLabel">State</label>
						<div class="form-group">
							<?php echo getStatDropdown('','state_id');?>
		    			</div>
	      			</div>
		  			<div class="clear"></div>
		  			<div class="col-md-8">   	      			      	
						<label id="searchTypeLabel">Type</label>
						<div class="form-group" >
							<select id="type" name="type" class="form-control required">
								<option value="Acts">Acts</option>
								<option value="Rules">Rules</option>
							</select>
						</div>
			    	</div>
					<div class="col-md-8">   	      			      	
						<label id="searchTypeLabel">Text</label>
						<div class="form-group" >
							<input type="text" class="form-control" id="text" name="text" value=""/>
						</div>
			    	</div>	      	
			      	<!-- <div class="col-md-8">   	      			      	
						<label id="searchTypeLabel">Referred in</label>
						<div class="form-group" >
							<input type="text" class="form-control" id="partyName" name="partyName" value=""/>
						</div>
			    	</div> -->
			    	<div class="clear"></div>
	      			<div class="col-md-8">
	      				<label></label>      	
						<div class="form-group">
							<input type="submit" name="searchButton" id="searchButton" value="Search" class="btn"/>
						    <!-- <input type="reset" name="resetBtn" id="resetBtn" value="Reset Search" class="btn" onClick="window.location.href='searchCaseLawAdv';" /> -->
					    </div>
				    </div>
	      			<div class="clear"></div>
	      			<!-- <div><a href="searchCaseLaw"  class="pull-right">Quick Search</a></div> -->
				</form>
			</div>
<?php
		}
		else if($_REQUEST['datatype']=='forms'){
?>	
			<div class="col-md-16 table-container t-margin-20" style="margin: 0;">
				<form name="form2" id="form2" action="" method="GET" class="form padding-b-15" onSubmit="return ValidateForm()">  
	      
	      			<div class="col-md-8">
						<label>Text</label>
						<div class="form-group">
							<input type="text" class="form-control" id="partyName" name="partyName" value=""/>			
						</div>
					</div>
					<div class="clear"></div>
					<div class="col-md-8">
						<label id="searchTypeLabel">Law</label>
						<div class="form-group">
							<select name="searchCat"  id="searchCat" class="form-control" style="width: 60%;">
								<option value="0">Please select </option>
							</select>
		    			</div>
	      			</div>
		  			<div class="clear"></div>
					<div class="col-md-8">   	      			      	
						<label id="searchTypeLabel">Results</label>
						<div class="form-group" >
							<select name="searchCat"  id="searchCat" class="form-control" style="width: 60%;">
								<option value="0">Please select </option>
							</select>
						</div>
			    	</div>	      	
	      			<div class="clear"></div>
	      			<div class="col-md-8">
	      				<label></label>      	
						<div class="form-group">
							<input type="submit" name="searchButton" id="searchButton" value="Search" class="btn"/>
						    <!-- <input type="reset" name="resetBtn" id="resetBtn" value="Reset Search" class="btn" onClick="window.location.href='searchCaseLawAdv';" /> -->
					    </div>
				    </div>
	      			<div class="clear"></div>
	      			<!-- <div><a href="searchCaseLaw"  class="pull-right">Quick Search</a></div> -->
				</form>
			</div>
<?php		
		}
		else if($_REQUEST['datatype']=='news'){
?>	
			<div class="col-md-16 table-container t-margin-20" style="margin: 0;">
				<form name="form2" id="form2" action="adv_search.php" method="GET" class="form padding-b-15" onSubmit="return ValidateForm()">  
	      			<input type="hidden" name="pagename" value="news">
	      			<input type="hidden" name="function_name" value="news">
	      			<input type="hidden" id="dbsuffix" name="dbsuffix" value="features">
	      			<div class="col-md-8">
						<label>Text</label>
						<div class="form-group">
							<input type="text" class="form-control" id="text" name="text" value=""/>			
						</div>
					</div>
					<div class="clear"></div>
					<div class="col-md-8">
						<label id="searchTypeLabel">Filter Text</label>
						<div class="form-group">
							<input type="text" class="form-control" id="filter_text" name="filter_text" value=""/>
		    			</div>
	      			</div>
		  			<div class="clear"></div>
					<!-- <div class="col-md-8">   	      			      	
						<label id="searchTypeLabel">Results</label>
						<div class="form-group" >
							<select name="searchCat"  id="searchCat" class="form-control" style="width: 60%;">
								<option value="0">Please select </option>
							</select>
						</div>
			    	</div>	      	
	      			<div class="clear"></div> -->
	      			<div class="col-md-8">
	      				<label></label>      	
						<div class="form-group">
							<input type="submit" name="searchButton" id="searchButton" value="Search" class="btn"/>
						   <!--  <input type="reset" name="resetBtn" id="resetBtn" value="Reset Search" class="btn" onClick="window.location.href='searchCaseLawAdv';" /> -->
					    </div>
				    </div>
	      			<div class="clear"></div>
	      			<!-- <div><a href="searchCaseLaw"  class="pull-right">Quick Search</a></div> -->
				</form>
			</div>
<?php		
		}
		else if($_REQUEST['datatype']=='case_law'){
?>	
			<div class="col-md-16 table-container t-margin-20">
			<form name="form2" id="form2" action="adv_search.php" method="GET" class="form padding-b-15" onSubmit="return ValidateForm()">
	      	<input type="hidden" name="pagename" value="case">
	      	<input type="hidden" name="function_name" value="case_data">
	      	<input type="hidden" id="dbsuffix" name="dbsuffix" value="vat">
	      	<div class="col-md-8">
				<label>Category</label>
				<div class="form-group" id= "product">
					<?php echo getCatDropdown('product','');?>		
				</div>
			</div>
			<div class="col-md-8" id="state" style="display: none;">
				<label id="searchTypeLabel">State</label>
				<div class="form-group">
					<?php echo getStatDropdown('','state_id');?>
    			</div>
  			</div>
			<div class="clear"></div>
			<div class="col-md-8">
				<label id="searchTypeLabel">Select Court</label>
				<div class="form-group">
					<select id='courtType' name='courtType' class="form-control">
				        <option value="High Court Cases">High Court Cases</option>
				        <option value="Supreme Court Cases">Supreme Court Cases</option>                        
				        <option value="Tribunal">Tribunal</option>           
				        <option value="Advance Ruling Authority">Advance Ruling Authority</option>
				        <option value="AAAR">AAAR</option>
				        <option value="National Anti/Profiteering Authority">NAA</option>
				    </select>
			    </div>
	      	</div>
	      	<div class="col-md-8" id='hc'>
				<label >Select Bench/City</label>
				<div class="form-group">
					<select id='courtCityHC' name='courtCity' class="form-control" >
				   	 	<option value="0">Select City</option>
				        <option value="ALH">Allahabad</option>
				        <option value="AP">Andhra Pradesh</option>
				        <option value="GAU">Gauhati</option>
				        <option value="CHG">Chhattishgarh</option>
				        <option value="DEL">Delhi</option>
				        <option value="BOM">Bombay</option>
				        <option value="GUJ">Gujarat</option>
				        <option value="P_H">Punjab & Haryana</option>
				        <option value="J_K">Jammu & Kashmir</option>
				        <option value="JHR">Jharkhand</option>
				        <option value="KER">Kerala</option>
				        <option value="KAR">Karnataka</option>
				        <option value="RAJ">Rajasthan</option>
				        <option value="ORI">Odisha</option>
				        <option value="MAD">Madras</option>
				        <option value="UTR">Uttarakhand</option>
				        <option value="CAL">Calcutta</option>
				        <option value="MP">Madhya Pradesh</option>
				        <option value="SIK">Sikkim</option>
				        <option value="MEG">Meghalaya</option>
				        <option value="HP">Himachal Pradesh</option>
				        <option value="PAT">Patna</option>
				        <option value="ORI">Orissa</option>
				        <option value="TEL">Telangana</option>
				        <option value="TRI">Tripura</option>
			 		</select>
			 	</div>
		  	</div>

		  	<div class="col-md-8" id='tri' style="display: none;">
				<label >Select Bench/City</label>
				<div class="form-group">
					<select id='courtCityHC' name='courtCity1' onchange="" class="form-control" >
				   	 	<option value="0">Select City</option>
				        <option value="AHM">Ahmedabad</option>
				        <option value="ALH">Allahabad</option>
				        <option value="BLR">Bangalore</option>
				        <option value="CHD">Chandigarh</option>
				        <option value="CHE">Chennai</option>
				        <option value="DEL">Delhi</option>
				        <option value="HYD">Hyderabad</option>
				        <option value="KOL">Kolkata</option>
				        <option value="MUM">Mumbai</option>
			 		</select>
			 	</div>
			</div>
	      	<div class="clear"></div>      	
	      	<div class="col-md-8">
				<label id="searchTypeLabel">Select From Date</label>
				<div class="form-group">
					<input type="date" class="form-control" placeholder="From Date" id="fromDate" name="fromDate" value=""/> 	
			    </div>
	      	</div>
	      	<div class="col-md-8">
	      		<label id="searchTypeLabel">Select To Date</label>
				<div class="form-group">
	      			<input type="date" class="form-control" placeholder="To Date"  id="toDate"  name="toDate" value=""/>
	      		</div>
	      	</div>		
	      	<div class="clear"></div>
		    <div class="col-md-16">
				<label id="searchTypeLabel" style="margin-right: 3%; width: 7%;  margin-left: 56px;">Party Name</label>
				<div class="form-group">
					<input type="text" class="form-control" id="party_name" name="party_name" value=""/> 
		    	</div>
	      	</div>
			<div class="clear"></div>
		  	<div class="col-md-16">  
		  		<div class="col-md-5">
	      			<label id="searchTypeLabel">Citation No.</label>
					<div class="form-group">
	      				<!-- <input type="text" class="form-control" placeholder="Year"  id="toDate"  name="toDate" value="" style="    width: 66%;margin-left:36%;"/> -->
	      				<select class="form-control" id="year" name="year" style="width: 66%;margin-left:36%;">
	      					
	      				</select>
	      			</div>
	      		</div>

	      		<div class="col-md-3">
	      			<label id="searchTypeLabel" style="margin-right: 4%; width: 25%;">-VIL-</label>
					<div class="form-group">
	      				<!-- <input type="text" class="form-control" placeholder="Volume"  id="toDate"  name="toDate" value="" style="width: 100%;" /> -->
	      				<select class="form-control" id="volume" name="volume" style="width: 100%;">
	      					
	      				</select>
	      			</div>
	      		</div>

	      		<div class="col-md-3">
	      			<label id="searchTypeLabel" style="margin-right: 12%; width: 2%;">-</label>
					<div class="form-group">
	      				<input type="text" class="form-control" id="c_value"  name="c_value" value="" style="width:86px;" />
	      			</div>
	      		</div>     		
		   	</div>	
		   	
	      	<div class="clear"></div>
	      	<div class="col-md-16">
				<label id="searchTypeLabel" style="margin-right: 3%; width: 7%;  margin-left: 56px;">Keyword</label>
				<div class="form-group">
					<?php  //search_form  ($HTTP_GET_VARS, $PHP_SELF ); ?>
					<input type="text" class="form-control" id="text" name="text" value=""/> 
		    	</div>
	      	</div>
	      	<div class="clear"></div>
	      	<div class="col-md-8">
				<label>Include Text</label>
				<div class="form-group">
					<input type="text" class="form-control" id="inc_txt" name="inc_txt" value="">		
				</div>
			</div>
			<div class="col-md-8">
				<label>Exclude Text</label>
				<div class="form-group">
					<input type="text" class="form-control" id="exc_txt" name="exc_txt" value="">
    			</div>
  			</div>
  			<div class="clear"></div>
	      	<div class="col-md-8">
	      	<label></label>      	
			<div class="form-group">
				<input type="submit" name="searchButton" id="searchButton" value="Search" class="btn"/>
			    <!-- <input type="reset" name="resetBtn" id="resetBtn" value="Reset Search" class="btn" onClick="window.location.href='searchCaseLawAdv';" /> -->
		    </div>
	      	</div>
	      	<div class="clear"></div>
	      	<!-- <div><a href="searchCaseLaw"  class="pull-right">Quick Search</a></div> -->
			
		</form>
	</div> 
<?php		
		}	
	} 

?>
<script type="text/javascript">
	$("#prod_id").change(function(){
		debugger;
		var val=$(this).val();
		var dbsuffix=$(this).find('option:selected').attr('data-dbsuffix');
		$("#dbsuffix").val(dbsuffix);
		if(val=='7'){
			$("#state").css("display","block");
		}else{
			$("#state").css("display","none");
		}
		var table='casedata_'+dbsuffix;
		$.ajax({
            data :{id: val, table : table},
            url  :"adv_search_notification_type.php", //php page URL where we post this data to view from database
            type :'POST',
            dataType: 'html',  
            success: function(data){
	            	if(data!="no"){
	            		$('#notification_type').css("display","block");
	            		$("#noti_div").html(data);
	            	}else{
	            		$('#notification_type').css("display","none");
	            	}
                }
            });
	});

</script>

<script type="text/javascript">
	var start = 1945;
	var end = new Date().getFullYear();
	var options = "<option value=''>Year</option>";
	for(var years = end ; years >=start; years--){
  		options += "<option>"+ years +"</option>";
	}
	document.getElementById("year").innerHTML = options;
</script>

<script type="text/javascript">
	var start = 1;
	var end = 100;
	var options = "<option value=''>Volume</option>";
	for(var vol = start ; vol <=end; vol++){
  		options += "<option>"+ vol +"</option>";
	}
	document.getElementById("volume").innerHTML = options;
</script>

<script type="text/javascript">
	$("#courtType").change(function(){
		debugger;
		var type=$(this).val();
		if(type=='High Court Cases'){
			
			$("#tri").css('display','none');
			$("#hc").css('display','block');
		}
		else if(type=='Tribunal'){
			
			$("#hc").css('display','none');
			$("#tri").css('display','block');
		}
		else{
			$("#tri").css('display','none');
			$("#hc").css('display','none');
		}
	});
</script>

<style type="text/css">
	.circular{
		width: 50px! important;
	}
</style>