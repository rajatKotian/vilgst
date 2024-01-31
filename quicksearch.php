<?php 
	$page = 'vat';
	$seoTitle = 'Case Law - Quick Search';
	$seoKeywords = 'Case Law - Quick Search';
	$seoDesc = 'Case Law - Quick Search';
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
	
	function getSubProdDropdownVal($prod_id) {
		$subProdSelect = '<select id="cat" name="cat" class="form-control required" >';
		$result = mysqli_query($GLOBALS['con'],"SELECT sub_prod_name, sub_prod_id FROM sub_product");
		while($row = mysqli_fetch_array($result)) {
			$subProdSelect .= "<option selected='selected' value='".$row['sub_prod_id']."'>".$row['sub_prod_name']."</option>";
		} 
	  	mysqli_free_result($result);

	   	$subProdSelect .= '</select>';
	  	return $subProdSelect;
	}
	
	function getStatDropdown($state_id, $selectValue) {
 
	  	$stateSelect = '<select id="state_id" name="state_id" class="form-control required" >
	                    <option value="0">Select State</option>';
	  	$state=$state_id; 
		error_log('LOGG:::');
		error_log("SELECT state_id, state_name FROM state_master");
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

	function getYearValue($year) {
 
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
?>
<style>
	.q_menu{
		background: linear-gradient(to bottom, #007ba0 0%,#005389 100%); 
		
	}
	.q_menu a{
		color : white;
	}
	.case-law-one
	{
		padding: 10px 20px;
		border:2px solid #005d8f;
		border-radius: 3px;
		background: #f7f7f7;
		transition: 0.3s;
	}
	.case-law-one:hover
	{
		cursor: pointer;
		    box-shadow: 4px 4px 6px grey;
	}
	.case-law-one.q_active
	{
		background: linear-gradient(to bottom, #007ba0 0%,#005389 100%);
		color: #fff;
		    box-shadow: 4px 4px 6px grey;
	}
	.case-law-one.q_active a
	{
			color: #fff;
	}
</style>

<!-- left sec start <div class="col-md-16 col-sm-16"> -->
<div class="col-md-11 col-sm-9 left-section">
    <h1><span class="title">Case Law</span> - Quick Search
  		<ol class="breadcrumb">
	        <li><a href="<?php echo $getBaseUrl; ?>">Home</a></li>
	        <li class="active"><span class="title">Case Law</span> - Quick Search</li>
        </ol>
    </h1>
    <div class="col-md-16">
	<?php 
		if(isLogeedIn()) {
	?>
				<!---------- Advance search options ------------------>	
            <div class="col-md-8 searchbody" >
            	<div class="case-law-one q_active" id="q_case_law">
					<a  href="#.">Case Law &nbsp;<i class="ion-chevron-right" ></i><i class="ion-chevron-right"></i></a>
				</div>
			</div>
			<div class="col-md-8">
				<div class="case-law-one" id="q_cir">
					<a  href="#.">Notification/Circular &nbsp;<i class="ion-chevron-right" ></i><i class="ion-chevron-right"></i></a>
				</div>
			</div>
			<div class="col-md-16 table-container t-margin-20" >
				
				<!-- case law search Form -->
				<div id="case_law_section">	
					<form name="form1" method="get" class="form padding-b-15" id="case_form" action="quick_search.php">
						<input type="hidden" name="pagename" value="Case Laws">
						<input type="hidden" name="function_name" value="case_data"> 
						<div class="form-group">
							<label>Select Category </label>
							<div class="form-group">
								<select name="case_prod_id" id="prod_id" class="form-control">
			                		<option value="0" <?php if(isset($_REQUEST['prod_id']) && ($_REQUEST['prod_id'] == "0")){ echo "selected=selected";}?> data-dbsuffix="0" >Select</option>
			                   		<option value="7" <?php if(isset($_REQUEST['prod_id']) && ($_REQUEST['prod_id'] == "7")){ echo "selected=selected";}?> data-dbsuffix="0" >GST</option>
			                   		<option value="1" <?php if(isset($_REQUEST['prod_id']) && ($_REQUEST['prod_id'] == "1")){ echo "selected=selected";}?> data-dbsuffix="0">VAT/Sales Tax</option>
			                   		<option value="4" <?php if(isset($_REQUEST['prod_id']) && ($_REQUEST['prod_id'] == "4")){ echo "selected=selected";}?> data-dbsuffix="0">Central Excise</option>
			                   		<option value="2" <?php if(isset($_REQUEST['prod_id']) && ($_REQUEST['prod_id'] == "2")){ echo "selected=selected";}?> data-dbsuffix="0">Service Tax</option>
			                   		<option value="5" <?php if(isset($_REQUEST['prod_id']) && ($_REQUEST['prod_id'] == "5")){ echo "selected=selected";}?> data-dbsuffix="0">Customs</option>
			                	</select>
							</div>
						</div>

						<div class="form-group">
						<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css"> -->
						<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.7.5/css/bootstrap-select.min.css"> 
						<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> -->
						<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
						<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.7.5/js/bootstrap-select.min.js"></script>
						
						<label>Select Forum </label>
						<style>
							.dropdown-menu span{
								color: black;
							}
							.btn {
								background:#fff;
								color: black;
								border: 1px solid lightgrey;
								text-transform: capitalize;
								
							}
							.btn span{
								font-size: 14px;
							}
							.btn-group{
								width: 53% !important;
							}
							.btn:hover{
								background:#fff;
								color: black;
								border: 1px solid lightgrey;
							}
							
						</style>
								<div class="form-group">
									<select name="court[]" id="forum" data-style="btn-default"  class="selectpicker form-control" multiple title="Select" >
									<option value="SC" <?php if (isset($_REQUEST['court']) && in_array("SC", (array)$_REQUEST['court'])) { echo "selected=selected"; } ?> data-dbsuffix="0">Supreme Court</option>
										<option value="HC" <?php if (isset($_REQUEST['court']) && in_array("HC", (array)$_REQUEST['court'])) { echo "selected=selected"; } ?> data-dbsuffix="0">High Court</option>
										<option value="TRI" <?php if (isset($_REQUEST['court']) && in_array("TRI", (array)$_REQUEST['court'])) { echo "selected=selected"; } ?> data-dbsuffix="0">CESTAT Cases</option>
										<option value="AAR" <?php if (isset($_REQUEST['court']) && in_array("AAR", (array)$_REQUEST['court'])) { echo "selected=selected"; } ?> data-dbsuffix="0">AAR</option>
										<option value="NAA" <?php if (isset($_REQUEST['court']) && in_array("NAA", (array)$_REQUEST['court'])) { echo "selected=selected"; } ?> data-dbsuffix="0">NAA</option>
										<option value="AAAR" <?php if (isset($_REQUEST['court']) && in_array("AAAR", (array)$_REQUEST['court'])) { echo "selected=selected"; } ?> data-dbsuffix="0">AAAR</option>
									</select>
								</div>
						
					</div>

						<div class="form-group">
							<label>Select Type</label>
							<div class="form-group">
								<select name="case_searchType"  id="searchType" class="form-control">
								    <option value="1" <?php if(isset($_REQUEST['searchType']) && ($_REQUEST['case_searchType'] == "1")){ echo "selected=selected";}?>>Party Name</option>
									<option value="0" <?php if(isset($_REQUEST['searchType']) && ($_REQUEST['searchType'] == "0")){ echo "selected=selected";}?>>Keyword</option>   

						            <option value="2" <?php if(isset($_REQUEST['searchType']) && ($_REQUEST['searchType'] == "2")){ echo "selected=selected";}?>>VIL Citation No.</option> 	                    
							    </select>			
							</div>
						</div>

						<div class="form-group" id="keyword">
							<label id="searchTypeLabel">Keyword</label> 
							<div class="form-group">
				 				<input type="text" id="key" value="<?php if(isset($_REQUEST['keyword']) && (!empty($_REQUEST['keyword']))){ echo $_REQUEST['keyword'];}?>" placeholder="Keyword"  name="case_keyword" class="form-control" >
				 			</div>
				 		</div>

						<div class="form-group" id="party_name" style="display: none;">
							<label id="searchTypeLabel">Party Name</label> 
							<div class="form-group">
				 				<input type="text" id="party" value="<?php if(isset($_REQUEST['party_name']) && (!empty($_REQUEST['party_name']))){ echo $_REQUEST['party_name'];}?>" placeholder="Party Name" name="party_name" class="form-control" >
				 			</div>
					</div>
						<div class="form-group" id="citation" style="display: none;">
						    <label id="searchTypeLabel">VIL Citation</label>
				          	<div class="col-md-3  col-xs-4">
				             	<div class="form-group">
				                	<select class="form-control" id="year" name="year" style="width: 66%;margin-left:36%;">
				      					<option value=''>Year</option>	
				      					<?php 	
										   	for($i = 1945 ; $i <= date('Y'); $i++){
										?>   		
										      	<option <?php if(isset($_REQUEST['year']) && ($_REQUEST['year'] == $i)){ echo "selected=selected";}?>><?php echo $i; ?></option>
										<?php      	
										   	}
										?>
				      				</select>
				            	</div>
				          	</div>
				          	<div class="col-md-1 text-center  col-xs-2">
			            		<p class="text"> VIL</p>
				          	</div>
				          	<div class="col-md-2  col-xs-4">
				             	<div class="form-group">
				                	<input type="text" class="form-control" id="vol" placeholder="Volumn" name="vol" value="<?php if(isset($_REQUEST['vol']) && (!empty($_REQUEST['vol']))){ echo $_REQUEST['vol'];}?>" />
				            	</div>
				          	</div>
				          	<div class="col-md-1 text-center  col-xs-2">
				             -
				          	</div>
				          	<div class="col-md-2  col-xs-4">
				             	<div class="form-group">
				                	<input type="text" class="form-control" id="Cit_text" placeholder="" name="Citation" value="<?php if(isset($_REQUEST['Citation']) && (!empty($_REQUEST['Citation']))){ echo $_REQUEST['Citation'];}?>" />
				             	</div>
				          	</div>
					    </div>
						<div class="form-group" id="year_range" style="display: block;">
							<label id="searchTypeLabel">Year Range</label> 
							<input style ='border: 1px solid #ccc;' type="date" id="yearFrom" placeholder="Notification Date" name="yearFrom" value="<?php if (isset($_REQUEST['yearFrom']) && (!empty($_REQUEST['yearFrom']))) { echo $_REQUEST['yearFrom']; } ?>" />
							<input style ='border: 1px solid #ccc;' type="date" id="yearTo" placeholder="" name="yearTo" value="<?php if (isset($_REQUEST['yearTo']) && (!empty($_REQUEST['yearTo']))) { echo $_REQUEST['yearTo']; } ?>" />

				 		</div>

					    <div class="form-group text-center" >
							<input type="submit" name="searchButton" id="search_case_btn" value="Search" class="btn"/>
				    	</div>
					</form>
				</div>



				<!-- Notification/circular Search Form -->
				<div id="notification_section" style="display: none">
					<form name="form2" method="get" class="form padding-b-15 " id="cir_form" action="quick_search.php">
						<input type="hidden" name="pagename" value="Notification">
						<input type="hidden" name="function_name" value="notification"> 
						<div class="form-group">
							<label>Select Category </label>
							<div class="form-group">
								<select name="notification_prod_id" id="not_prod_id" class="form-control">
			                     	<option value="0" <?php if(isset($_REQUEST['prod_id']) && ($_REQUEST['prod_id'] == "0")){ echo "selected=selected";}?> data-dbsuffix="0">Select</option>
			                     	<option value="10" <?php if(isset($_REQUEST['prod_id']) && ($_REQUEST['prod_id'] == "10")){ echo "selected=selected";}?> data-dbsuffix="cgst">CGST</option>
			                     	<option value="9" <?php if(isset($_REQUEST['prod_id']) && ($_REQUEST['prod_id'] == "9")){ echo "selected=selected";}?> data-dbsuffix="igst">IGST</option>
			                     	<option value="7" <?php if(isset($_REQUEST['prod_id']) && ($_REQUEST['prod_id'] == "7")){ echo "selected=selected";}?> data-dbsuffix="sgst">SGST</option>
			                     	<option value="1" <?php if(isset($_REQUEST['prod_id']) && ($_REQUEST['prod_id'] == "1")){ echo "selected=selected";}?> data-dbsuffix="vat">VAT</option>
			                     	<option value="2" <?php if(isset($_REQUEST['prod_id']) && ($_REQUEST['prod_id'] == "2")){ echo "selected=selected";}?> data-dbsuffix="st">Service Tax</option>
			                     	<option value="4" <?php if(isset($_REQUEST['prod_id']) && ($_REQUEST['prod_id'] == "4")){ echo "selected=selected";}?> data-dbsuffix="ce">Central Excise</option>
			                     	<option value="5" <?php if(isset($_REQUEST['prod_id']) && ($_REQUEST['prod_id'] == "5")){ echo "selected=selected";}?> data-dbsuffix="cu">Customs</option>
			                     	<option value="6" <?php if(isset($_REQUEST['prod_id']) && ($_REQUEST['prod_id'] == "6")){ echo "selected=selected";}?> data-dbsuffix="dgft">DGFT</option>
			                  	</select>
							</div>
						</div>
						
						<div class="form-group">
							<label>Select Type</label>
							<div class="form-group">
								<select name="notification_searchType"  id="searchType1" class="form-control">
						        	<option value="0">Keyword</option>
						            <option value="1">Notification/Circular No.</option>                     
							    </select>			
							</div>
						</div>

						<div class="form-group" id="noti_keyword">
							<label id="searchTypeLabel">Keyword</label> 
							<div class="form-group">
				 				<input type="text" id="not_key" placeholder="Keyword"  name="notification_keyword"  value="<?php if(isset($_REQUEST['keyword']) && (!empty($_REQUEST['keyword']))){ echo $_REQUEST['keyword'];}?>" class="form-control" >
				 			</div>
				 		</div>

				 		<div class="form-group" id="noti_cir_no" style="display: none;">
							<label id="searchTypeLabel">Notification/Circular No.</label> 
							<div class="form-group">
				 				<input type="text" id="noti_cir" placeholder="Notification/Circular No."  name="noti_cir" value="<?php if(isset($_REQUEST['noti_cir']) && (!empty($_REQUEST['noti_cir']))){ echo $_REQUEST['noti_cir'];}?>" class="form-control" >
				 			</div>
				 		</div>
						 <!-- <div class="form-group" id="noti_year_range" style="display: block;">
							<label id="searchTypeLabel">Year Range</label> 
							<input style ='border: 1px solid #ccc;' type="date" id="yearFrom" placeholder="Notification Date" name="yearFrom" value="<?php if (isset($_REQUEST['yearFrom']) && (!empty($_REQUEST['yearFrom']))) { echo $_REQUEST['yearFrom']; } ?>" />
							<input style ='border: 1px solid #ccc;' type="date" id="yearTo" placeholder="" name="yearTo" value="<?php if (isset($_REQUEST['yearTo']) && (!empty($_REQUEST['yearTo']))) { echo $_REQUEST['yearTo']; } ?>" />
				 		</div> -->

				 		<div class="form-group text-center">
							<input type="submit" name="searchButton" id="search_case_btn" value="Search" class="btn"/>
				    	</div>

					</form>
				</div>

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
<script type="text/javascript">
	$(document).ready(function(){
		$("#q_case_law").click(function(){
			$("#q_cir").removeClass("q_active");
			$("#q_case_law").addClass("q_active");
			$("#case_law_section").css('display','block');
			$("#notification_section").css('display','none');
			$(".title").html('Case Law');
			//document.getElementById("cir_form").reset();
		});

		$("#q_cir").click(function(){
			//debugger;;
			$("#q_case_law").removeClass("q_active");
			$("#q_cir").addClass("q_active");
			$("#case_law_section").css('display','none');
			$("#notification_section").css('display','block');
			$(".title").html('Notification');
			//document.getElementById("case_form").reset();
		});

		// for case law
		$("#searchType").change(function(){
			//debugger;;
			var value=$(this).val();
			
			if(value=="0"){ //for keyword
				$("#keyword").css("display","block");
				$("#citation").css("display","none");
				$("#party_name").css("display","none");
				

				$("#party").val("");
				$("#year").find('option').prop("selected", false);
				$("#vol").val("");
				$("#Cit_text").val("");

			}else if(value=="1"){// for party name
				$("#keyword").css("display","none");
				$("#citation").css("display","none");
				$("#party_name").css("display","block");
				

				$("#key").val("");
				$("#vol").val("");
				$("#Cit_text").val("");
				$("#year").find('option').prop("selected", false);
			}else if(value=="3"){// for party name
				$("#year_range").css("display","block");
				$("#citation").css("display","none");
				$("#keyword").css("display","none");
				$("#party_name").css("display","none");

				$("#yearFrom").val("");
				$("#yearto").val("");
				$("#vol").val("");
				$("#Cit_text").val("");
			}else{
				$("#keyword").css("display","none");
				$("#citation").css("display","block");
				$("#party_name").css("display","none");
				

				$("#key").val("");
				$("#party").val("");
			}
		});
		
		$("#prod_id").change(function(){
			var productId = $(this).val();
			if(productId){ 
			    $.ajax({
                type: 'POST',
                url: 'get_select_options.php',
                data: {prod_id: productId, options_type: 'product_forum_fetch'},
                dataType: 'json',
                success: function (data) {
                    var optionsHtml = '<option value="0" data-dbsuffix="0" >Select</option>';
                    $.each(data, function (key, value) {
                        optionsHtml += '<option value="' + value.sub_prod_id + '">' + value.sub_prod_name + '</option>';
                    });
                    $('#sub_prod_id').html(optionsHtml);
                }
            });
				$("#sub_prod_id").css("display","block");
			} else {
			    $("#sub_prod_id").css("display","none");
			}
		});


		// for notification/circular
		$("#searchType1").change(function(){
			//debugger;;
			var value=$(this).val();
			if(value=="0"){ //for keyword
				$("#noti_keyword").css("display","block");
				$("#noti_year_range").css("display","none");
				$("#noti_cir_no").css("display","none");

				$("#noti_cir").val("");

			}else if(value=="1"){// for party name 
				$("#noti_keyword").css("display","none");
				$("#noti_year_range").css("display","none");
				$("#noti_cir_no").css("display","block");

				$("#not_key").val("");
			}
			else if(value=="2"){// for party name 
				$("#noti_year_range").css("display","block");
				$("#noti_keyword").css("display","none");
				$("#noti_cir_no").css("display","none");

				$("#not_key").val("");
			}
		});
		
		$("#not_prod_id").change(function(){
			//debugger;;
			var val=$(this).val();
			
			if(val=='7'){
				$("#state").css("display","block");
			}else{
				$("#state").css("display","none");
			}
		});

        $("#searchType").trigger('change');

	});
			
</script>
