<?php  

	$page = '';
	$seoTitle = 'Advanced Search';
	$seoKeywords = 'Advanced Search';
	$seoDesc = 'Advanced Search'; 
	include('header.php'); 


	function getCatDropdown($value,$data) {  
		if($data=='1'){
			$prodSelect = '<select id="prod_id" name="prod_id" class="form-control required" multiple >';	
		}else{
			$prodSelect = '<select id="prod_id" name="prod_id" class="form-control required" >';	
		}
		$prodSelect .= "<option ";
	    $prodSelect .= " value='0'>Select</option>";                
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
	 		if(isset($_REQUEST['author']) && $_REQUEST['author']==$row['author'])
	 		{
	 			$author .= "<option value='".$row['author']."' selected='selected'>".$row['author']."</option>";
	 		}
	 		else
	 		{
	 			$author .= "<option value='".$row['author']."'>".$row['author']."</option>";
	 		}
		    
		}
		mysqli_free_result($result);
	   	$author .= '</select>';
	  	return $author;
	}
	 
	function getCategory($table,$value){
		
	  	
	  	$result = mysqli_query($GLOBALS['con'],"SELECT * FROM $table  WHERE sub_prod_type = '$value'");
	  	if(mysqli_num_rows($result)>0){
	  		$row = mysqli_fetch_array($result);
	  		$data_id=explode(',',$row['prod_id']);
	  		$conditions=array();
	  		foreach ($data_id as $key) {
	  			$conditions[]="prod_id='$key'";
	  		}
	  		return $where=implode(' OR ', $conditions);
	  	}
	}
?>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
<div class="col-md-11 col-sm-9 left-section">
    <h1>Advance Search - <?php echo $_REQUEST['search'];?>
  		<ol class="breadcrumb">
	        <li><a href="<?php echo $getBaseUrl; ?>">Home</a></li>
	        <li class="active">Advance Search - <?php echo $_REQUEST['search'];?></li>
        </ol>
    </h1>
    <div class="col-md-16">
		<?php 
			if(isLogeedIn()) { 
		?>
    		<div class="col-md-16">
    			<div class="col-sm-16 col-md-16 right-section">
    				
    				<div class="bordered" id="articles">
				        <div class="row">

				            <div class="col-sm-16 bt-space sidebar-widget">
				    <!---------- Advance search options ------------------>	
				            <div class=" show-more">
        						<a  href="#." id="advance_search">Advanced Search &nbsp;<i class="ion-chevron-right" ></i><i class="ion-chevron-right"></i></a>
    						</div>
    						<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true" style="display: none;">
				                    <div class="panel panel-default">
				                        <div class="panel-heading" role="tab" id="headingOne" onClick="return searchBody('Case Laws')">
				                            <h4 class="panel-title">
				                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
				                                    Case Laws
				                                </a>
				                            </h4>
				                        </div>
				                       <!--  <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
				                            <div class="panel-body" id="case_law">
				                                
				                            </div>
				                        </div> -->
				                    </div>
				                    <div class="panel panel-default">
				                        <div class="panel-heading" role="tab" id="headingTwo" onClick="return searchBody('Acts and Rules')">
				                            <h4 class="panel-title">
				                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
				                                    Acts/ Rules/ Regulations
				                                </a>
				                            </h4>
				                        </div>
				                        <!-- <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
				                            <div class="panel-body" id='act'>
				                                
				                            </div>
				                        </div> -->
				                    </div>
				                    <div class="panel panel-default">
				                        <div class="panel-heading" role="tab" id="headingThree" onClick="return searchBody('Notification')">
				                            <h4 class="panel-title">
				                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
				                                    Notifications
				                                </a>
				                            </h4>
				                        </div>
				                        <!-- <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
				                            <div class="panel-body" id="notification">
				                                
				                            </div>
				                        </div> -->
				                    </div>
				                    <div class="panel panel-default">
				                        <div class="panel-heading" role="tab" id="headingFour" onClick="return searchBody('Forms')">
				                            <h4 class="panel-title">
				                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
				                                    Forms
				                                </a>
				                            </h4>
				                        </div>
				                        <!-- <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
				                            <div class="panel-body" id="forms">
				                                
				                            </div>
				                        </div> -->
				                    </div>
				                    <div class="panel panel-default">
				                        <div class="panel-heading" role="tab" id="headingFive" onClick="return searchBody('Articles')">
				                            <h4 class="panel-title">
				                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
				                                    Articles
				                                </a>
				                            </h4>
				                        </div>
				                        <!-- <div id="collapseFive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFive">
				                            <div class="panel-body" id="articles1">
				                                
				                            </div>
				                        </div> -->
				                    </div>
				                    <div class="panel panel-default">
				                        <div class="panel-heading" role="tab" id="headingSix" onClick="return searchBody('News')">
				                            <h4 class="panel-title">
				                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
				                                    News
				                                </a>
				                            </h4>
				                        </div>
				                        <!-- <div id="collapseSix" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSix">
				                            <div class="panel-body" id="news">
				                                
				                            </div>
				                        </div> -->
				                    </div>
				                    
				                </div>
				    <!---------- End of Advance search options ------------------>        

				    <!---------- Forms of search options ------------------>        
				                <?php 
								if(isset($_REQUEST['search']))
								{
									if($_REQUEST['search']=='Notification')
									{
								?>
									<div class="searchbody">
										<form name="form2" id="form2" action="adv_search.php" method="GET" class="form padding-b-15" onSubmit="return ValidateForm()">
											<input type="hidden" id="sel_type" name="sel_type" value="<?php if(isset($_REQUEST['type'])){ echo $_REQUEST['type']; }?>">
											<input type="hidden" id="cat_type" name="cat_type" value="<?php if(isset($_REQUEST['sub_product_id'])){ echo $_REQUEST['sub_product_id']; }?>">  
											<input type="hidden" id="st_id" name="st_id" value="<?php if(isset($_REQUEST['state_id'])){ echo $_REQUEST['state_id']; }?>"> 
								  			<input type="hidden" name="pagename" value="Notification">
								  			<input type="hidden" name="function_name" value="notification">
								  			<input type="hidden" id="dbsuffix" name="dbsuffix" value="0">

								  			<!-- for Keyword -->
								  			<div class="row">
										    	<div class="col-md-16">
										       		<div class="row">
											          	<div class="col-md-3 col-xs-16">
											             	<label id="searchTypeLabel">Keyword</label>
											          	</div>
										          		<div class="col-md-11 col-xs-12">
										             		<div class="form-group">
										                		<input type="text" class="form-control" id="keyword" placeholder="Keyword" name="keyword" value="<?php if(isset($_REQUEST['keyword']) && (!empty($_REQUEST['keyword']))){ echo $_REQUEST['keyword'];}?>" />
										             		</div>
										          		</div>
										          		<div class="col-md-2 col-xs-4">
										             		<input type="submit" id="keyword_btn" class="btn" name="keyword_btn" maxlength="10" value="Go" />
										          		</div>
										       		</div>
										    	</div>
										 	</div>
								  			
										   	<!-- for category -->
										   	<div class="row">
										      	<div class="col-md-16">
										         	<div class="row">
											            <div class="col-md-3">
											               <label id="searchTypeLabel">Category</label>
											            </div>
											            <div class="col-md-9">
											               	<div class="form-group">
											                  	<select name="prod_id" id="prod_id" class="form-control">
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
										         	</div>
										      	</div>
										   	</div>

										   	<div class="row" id="state" style="display: none;">
										      	<div class="col-md-16">
										         	<div class="row">
											            <div class="col-md-3">
											               <label id="searchTypeLabel">State</label>
											            </div>
											            <div class="col-md-9">
											               	<div class="form-group">
											                  	<?php if(isset($_REQUEST['state_id'])){echo getStatDropdown($_REQUEST['state_id'],'state_id');}else{echo getStatDropdown('','state_id');}?>
											               	</div>
											            </div>
										         	</div>
										      	</div>
										   	</div>

										   	<div class="row" id="category_type" style="display: none;">
										   		<div class="col-md-16">
										   			<div class="row">
										   				<div class="col-md-3">
															<label id="searchTypeLabel">Category Type</label>
														</div>	
														<div class="col-md-9 form-group" id="noti_div">
															<select id="sub_product_id" name="sub_product_id" class="form-control required">

															</select>
										    			</div>
										  			</div>
										  		</div>
										  	</div>

										   	<div class="row" id="notification_type" style="display: none;">
										      	<div class="col-md-16">
										         	<div class="row">
											            <div class="col-md-3">
											               <label id="searchTypeLabel">Notification Type</label>
											            </div>
											            <div class="col-md-9">
											               	<div class="form-group" id="noti_div">
											               		<select id="not_type" name="type" class="form-control required">

																</select>
											                  
											               	</div>
											            </div>
										         	</div>
										      	</div>
										   	</div>

										   	<!-- for notification no -->
										   	<div class="row">
										    	<div class="col-md-16">
										       		<div class="row">
											          	<div class="col-md-3 col-xs-16">
											             	<label id="searchTypeLabel">Notification No.</label>
											          	</div>
										          		<div class="col-md-11 col-xs-12">
										             		<div class="form-group">
										                		<input type="text" class="form-control" id="noti_no" placeholder="Notification No." name="noti_no" value="<?php if(isset($_REQUEST['noti_no']) && (!empty($_REQUEST['noti_no']))){ echo $_REQUEST['noti_no'];}?>" />
										             		</div>
										          		</div>
										          		<div class="col-md-2 col-xs-4">
										             		<input type="submit" id="noti_no_btn" class="btn" name="noti_no_btn" maxlength="10" value="Go" />
										          		</div>
										       		</div>
										    	</div>
										 	</div>

										 	<!-- for notification date -->
										   	<div class="row">
										      	<div class="col-md-16">
										         	<div class="row">
										            	<div class="col-md-3">
										               		<label id="searchTypeLabel">Notification Date</label>
										            	</div>
										            	<div class="col-md-9">
										               		<div class="form-group">
										                  		<input type="date" class="form-control" id="date" placeholder="Notification Date" name="date" value="<?php if(isset($_REQUEST['date']) && (!empty($_REQUEST['date']))){ echo $_REQUEST['date'];}?>" />
										               		</div>
										            	</div>
										      	   	</div>
										      	</div>
										   	</div>

										   	<!-- for notification date RANGE -->
										   	<div class="row">
										      	<div class="col-md-16 col-xs-16">
										         	<div class="row">
											            <div class="col-md-3 col-xs-16">
											               <label id="searchTypeLabel">Date Range</label>
											            </div>
											            <div class="col-md-4 col-xs-7">
											             	<div class="form-group">
											                	<input type="date" class="form-control" id="dt_from" placeholder="" name="dt_from" value="<?php if(isset($_REQUEST['dt_from']) && (!empty($_REQUEST['dt_from']))){ echo $_REQUEST['dt_from'];}?>" />
											             	</div>
											          	</div>
											            <div class="col-md-1 text-center col-xs-2">
											              	<p class="text"> to</p>
											            </div>
											            <div class="col-md-4 col-xs-7">
											             	<div class="form-group">
											                	<input type="date" class="form-control" id="dt_to" placeholder="" name="dt_to" value="<?php if(isset($_REQUEST['dt_to']) && (!empty($_REQUEST['dt_to']))){ echo $_REQUEST['dt_to'];}?>" />
											             	</div>
											          	</div>
										         	</div>
										      	</div>
										   	</div>

								  			
								  			<div class="col-md-8">
								  				<label></label>      	
												<div class="form-group">
													<input type="submit" name="searchButton" id="searchButton" value="Search" class="btn"/>
												    <!-- <input type="reset" name="resetBtn" id="resetBtn" value="Reset Search" class="btn" onClick="window.location.href='searchCaseLawAdv';" /> -->
											    </div>
										    </div>
										</form>
									</div>
								<?php 
									}
									else if($_REQUEST['search']=='Articles')
									{
								?>
										<div class="col-md-16 table-container t-margin-20 searchbody" style="margin: 0;">
											<form name="form2" id="form2" action="adv_search.php" method="GET" class="form padding-b-15" onSubmit="return ValidateForm()">  
									  			<input type="hidden" name="pagename" value="Articles">
									  			<input type="hidden" name="function_name" value="articles">
									  			<input type="hidden" id="" name="dbsuffix" value="articles">
									  			<div class="col-md-16">   	      			      	
													<label id="searchTypeLabel" style="margin-right: 3%; width: 7%;  margin-left: 56px;">Keywords</label>
													<div class="form-group">
														<input type="text" class="form-control" id="text" name="text" value="<?php if(isset($_REQUEST['text']) && (!empty($_REQUEST['text']))){ echo $_REQUEST['text'];}?>"/> 
													</div>
										    	</div>
										    	<div class="clear"></div> 
										    	<div class="col-md-16">
													<label id="searchTypeLabel" style="margin-right: 3%; width: 7%;  margin-left: 56px;">Topic</label>
													<div class="form-group">
														<?php  //search_form  ($HTTP_GET_VARS, $PHP_SELF ); ?>
														<input type="text" class="form-control" id="topic" placeholder="Enter Topic"  name="topic" value="<?php if(isset($_REQUEST['topic']) && (!empty($_REQUEST['topic']))){ echo $_REQUEST['topic'];}?>"/>
										    		</div>
										      	</div>
										      	<div class="clear"></div>	
									  			<div class="col-md-8">
													<label>Category</label>
													<div class="form-group">
														<!-- <?php echo getCatDropdown('product','');?> -->	
														<select id="" name="prod_id" class="form-control required">
															<option value="0" <?php if(isset($_REQUEST['prod_id']) && ($_REQUEST['prod_id'] == '0')){ echo "selected=selected";}?>>Select</option>
															<option value="GST" <?php if(isset($_REQUEST['prod_id']) && ($_REQUEST['prod_id'] == 'GST')){ echo "selected=selected";}?>>GST</option>
															<option value="Others" <?php if(isset($_REQUEST['prod_id']) && ($_REQUEST['prod_id'] == 'Others')){ echo "selected=selected";}?>>Others</option>
														</select>			
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
													<label id="searchTypeLabel">Select From Date</label>
													<div class="form-group">
														<input type="date" class="form-control" placeholder="From Date" id="fromDate" name="fromDate" value="<?php if(isset($_REQUEST['fromDate']) && (!empty($_REQUEST['fromDate']))){ echo $_REQUEST['fromDate'];}?>"/> 	
												    </div>
										      	</div>
										      	<div class="col-md-8">
										      		<label id="searchTypeLabel">Select To Date</label>
													<div class="form-group">
										      			<input type="date" class="form-control" placeholder="To Date"  id="toDate"  name="toDate" value="<?php if(isset($_REQUEST['toDate']) && (!empty($_REQUEST['toDate']))){ echo $_REQUEST['toDate'];}?>"/>
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
									else if($_REQUEST['search']=='Acts and Rules')
									{ 
								?>		
										<div class="searchbody">
											<form name="form2" id="form2" action="adv_search.php" method="GET" class="form padding-b-15" onSubmit="return ValidateForm()">
						                    <input type="hidden" name="pagename" value="Acts and Rules">
									  		<input type="hidden" name="function_name" value="act">
									  		<input type="hidden" id="dbsuffix" name="dbsuffix" value="<?php if(isset($_REQUEST['dbsuffix']) && (!empty($_REQUEST['dbsuffix']))){echo $_REQUEST['dbsuffix'];}else{echo "";}?>cgst">
						                    <div class="row">
						                        <div class="col-md-16">
						                           	<div class="row">
						                              	<div class="col-md-3">
						                                 	<label id="searchTypeLabel">Search Type</label>
						                              	</div>
						                              	<div class="col-md-9">
						                                 	<div class="form-group">
						                                    	<div class="form-group">
						                                       		<select name="type" id="type" class="form-control">
							                                          	<option value="Acts" <?php if(isset($_REQUEST['type']) && $_REQUEST['type']=='Acts'){echo "selected";}?>>Acts</option>
																		<option value="Rules" <?php if(isset($_REQUEST['type']) && $_REQUEST['type']=='Rules'){echo "selected";}?>>Rules</option>
																	</select>
						                                    	</div>
						                                 	</div>
						                              	</div>
						                           	</div>
						                        </div>
						                    </div>
						                    <div class="row">
						                        <div class="col-md-16">
						                           	<div class="row">
						                              	<div class="col-md-3">
						                                 	<label id="searchTypeLabel">Category</label>
						                              	</div>
						                              	<div class="col-md-9">
						                                 	<div class="form-group">
							                                    <select name="prod_id" id="prod_id" class="form-control">
							                                    	<option value="0" <?php if(isset($_REQUEST['prod_id']) && ($_REQUEST['prod_id'] == "0")){ echo "selected=selected";}?> data-dbsuffix="0">Select</option>
							                                       	<option value="10" <?php if(isset($_REQUEST['prod_id']) && ($_REQUEST['prod_id'] == "10")){ echo "selected=selected";}?> data-dbsuffix="cgst">CGST</option>
							                                       	<option value="9" <?php if(isset($_REQUEST['prod_id']) && ($_REQUEST['prod_id'] == "9")){ echo "selected=selected";}?> data-dbsuffix="IGST">IGST</option>
							                                       	<option value="7" <?php if(isset($_REQUEST['prod_id']) && ($_REQUEST['prod_id'] == "7")){ echo "selected=selected";}?> data-dbsuffix="SGST">SGST</option>
							                                       	<option value="8" <?php if(isset($_REQUEST['prod_id']) && ($_REQUEST['prod_id'] == "8")){ echo "selected=selected";}?> data-dbsuffix="UTGST">UTGST</option>
							                                       	<option value="5" <?php if(isset($_REQUEST['prod_id']) && ($_REQUEST['prod_id'] == "5")){ echo "selected=selected";}?> data-dbsuffix="Customs">Customs</option>
							                                       	<option value="6" <?php if(isset($_REQUEST['prod_id']) && ($_REQUEST['prod_id'] == "6")){ echo "selected=selected";}?> data-dbsuffix="DGFT">DGFT</option>
							                                    </select>
						                                 	</div>
						                              	</div>
						                           	</div>
						                        </div>
						                    </div>
						                    <div class="row">
						                        <div class="col-md-16">
						                           	<div class="row">
						                              	<div class="col-md-3">
						                                 	<label id="searchTypeLabel">Keyword</label>
						                              	</div>
						                              	<div class="col-md-9">
						                                 	<div class="form-group">
						                                    	<input type="text" class="form-control" id="keyword" name="keyword" value="<?php if(isset($_REQUEST['keyword']) && !empty($_REQUEST['keyword'])){echo $_REQUEST['keyword'];}?>" placeholder="Keyword"/>
						                                 	</div>
						                              	</div>
						                           	</div>
						                        </div>
						                    </div>
						                    <div class="row" id="section">
						                        <div class="col-md-16">
						                           	<div class="row">
						                              	<div class="col-md-3 col-xs-16">
						                                 	<label id="searchTypeLabel">Section No.</label>
						                              	</div>
						                              	<div class="col-md-7  col-xs-12">
						                                	<div class="form-group">
						                                    	<input type="text" class="form-control" id="section_no" name="section_no" value="<?php if(isset($_REQUEST['section_no']) && !empty($_REQUEST['section_no'])){echo $_REQUEST['section_no'];}?>" placeholder="Section No." />
						                                	</div>
						                              	</div>
						                              	<!-- <div class="col-md-2  col-xs-4">
						                                 	<input type="button" class="form-control" name="date" maxlength="10" value="Go" />
						                              	</div> -->
						                           	</div>
						                        </div>
						                    </div>
						                    <div class="row" id="rule" style="display: none;">
						                        <div class="col-md-16">
						                           	<div class="row">
						                              	<div class="col-md-3  col-xs-16">
						                                 	<label id="searchTypeLabel">Rule No. </label>
						                              	</div>
						                              	<div class="col-md-7  col-xs-12">
						                                 	<div class="form-group">
						                                    	<input type="text" class="form-control" id="rule_no" name="rule_no" value="<?php if(isset($_REQUEST['rule_no']) && !empty($_REQUEST['rule_no'])){echo $_REQUEST['rule_no'];}?>" placeholder="Rule No."/>
						                                 	</div>
						                              	</div>
						                              	<!-- <div class="col-md-2  col-xs-4">
						                                 	<input type="button" class="form-control" name="date" maxlength="10" value="Go" />
						                              	</div> -->
						                           	</div>
						                        </div>
						                    </div>
						                    <div class="col-md-8">
								  				<label></label>      	
												<div class="form-group">
													<input type="submit" name="searchButton" id="searchButton" value="Search" class="btn"/>
												    <!-- <input type="reset" name="resetBtn" id="resetBtn" value="Reset Search" class="btn" onClick="window.location.href='searchCaseLawAdv';" /> -->
											    </div>
										    </div>
					                  		</form>
					                  	</div>
								<?php
									}
									else if($_REQUEST['search']=='Forms')
									{
								?>	
										<div class="col-md-16 table-container t-margin-20 searchbody" style="margin: 0;">
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
									else if($_REQUEST['search']=='News')
									{
								?>	
										<div class="col-md-16 table-container t-margin-20 searchbody" style="margin: 0;">
											<form name="form2" id="form2" action="adv_search.php" method="GET" class="form padding-b-15" onSubmit="return ValidateForm()">  
								      			<input type="hidden" name="pagename" value="News">
								      			<input type="hidden" name="function_name" value="news">
								      			<input type="hidden"  name="dbsuffix" value="features">
								      			<div class="col-md-8">
													<label>Text</label>
													<div class="form-group">
														<input type="text" class="form-control" id="text" name="text" value="<?php if(isset($_REQUEST['text']) && (!empty($_REQUEST['text']))){echo $_REQUEST['text'];}?>"/>			
													</div>
												</div>
												<div class="clear"></div>
												<div class="col-md-8">
													<label id="searchTypeLabel">Filter Text</label>
													<div class="form-group">
														<input type="text" class="form-control" id="filter_text" name="filter_text" value="<?php if(isset($_REQUEST['filter_text']) && (!empty($_REQUEST['filter_text']))){echo $_REQUEST['filter_text'];}?>"/>
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
									else if($_REQUEST['search']=='Case Laws')
									{
										//include('caselaw_body.php');
								?>	<div class="searchbody">
										<form name="form2" id="form2" action="adv_search.php" method="GET" class="form padding-b-15" onSubmit="return ValidateForm()">
									      	<input type="hidden" name="pagename" value="Case Laws">
									      	<input type="hidden" name="function_name" value="case_data">
									      	<input type="hidden" id="dbsuffix" name="dbsuffix" value="0">
									      	<div class="row">
											    <div class="col-md-16">
											       	<div class="row">
											          	<div class="col-md-3">
											             	<label id="searchTypeLabel">Keyword</label>
											          	</div>
											          	<div class="col-md-13">
											             	<div class="form-group">
											                	<input type="text" class="form-control" placeholder="keyword" id="Keyword" name="Keyword" value="<?php if(isset($_REQUEST['Keyword']) && (!empty($_REQUEST['Keyword']))){ echo $_REQUEST['Keyword'];}?>"/>
											             	</div>
											          	</div>
											       	</div>
											    </div>
											</div>

											<div class="row">
										    	<div class="col-md-16">
										       		<div class="row">
										          		<div class="col-md-3 col-xs-16">
										             		<label id="searchTypeLabel">Search In</label>
										          		</div>
										          		<div class="col-md-11 col-xs-12">
										             		<div class="form-group">
												                <select name="search_in" id="search_in" class="form-control">
												                	<option value="0" <?php if(isset($_REQUEST['search_in']) && ($_REQUEST['search_in'] == "0")){ echo "selected=selected";}?> data-dbsuffix="0">Select </option>	
												                   	<option value="1" <?php if(isset($_REQUEST['search_in']) && ($_REQUEST['search_in'] == "1")){ echo "selected=selected";}?> data-dbsuffix="0">Headnote </option>

												                   	<option value="2" <?php if(isset($_REQUEST['search_in']) && ($_REQUEST['search_in'] == "2")){ echo "selected=selected";}?>data-dbsuffix="0">Case Text</option>
												                </select>
										             		</div>
										          		</div>
										          		<div class="col-md-2 col-xs-4">
										             		<input type="submit" id="searchIn_btn" class="btn" name="searchIn_btn" maxlength="10" value="Go" />
										          		</div>
										       		</div>
										    	</div>
										 	</div>

										 	<div class="row">
										    	<div class="col-md-16">
										       		<div class="row">
											          	<div class="col-md-3 col-xs-16">
											             	<label id="searchTypeLabel">Party Name</label>
											          	</div>
										          		<div class="col-md-11 col-xs-12">
										             		<div class="form-group">
										                		<input type="text" class="form-control" id="party_name" placeholder="Party Name" name="party_name" value="<?php if(isset($_REQUEST['party_name']) && (!empty($_REQUEST['party_name']))){ echo $_REQUEST['party_name'];}?>" />
										             		</div>
										          		</div>
										          		<div class="col-md-2 col-xs-4">
										             		<input type="submit" id="partyName_btn" class="btn" name="partyName_btn" maxlength="10" value="Go" />
										          		</div>
										       		</div>
										    	</div>
										 	</div>

										 	<div class="row">
										    	<div class="col-md-16">
										       		<div class="row">
										          		<div class="col-md-3 col-xs-16">
										             		<label id="searchTypeLabel">Category</label>
										          		</div>
											          	<div class="col-md-9">
											             	<div class="form-group">
											                	<select name="prod_id" id="prod_id" class="form-control">
											                		<option value="0" <?php if(isset($_REQUEST['prod_id']) && ($_REQUEST['prod_id'] == "0")){ echo "selected=selected";}?> data-dbsuffix="0">Select</option>
											                   		<option value="7" <?php if(isset($_REQUEST['prod_id']) && ($_REQUEST['prod_id'] == "7")){ echo "selected=selected";}?> data-dbsuffix="0">GST</option>
											                   		<option value="1" <?php if(isset($_REQUEST['prod_id']) && ($_REQUEST['prod_id'] == "1")){ echo "selected=selected";}?> data-dbsuffix="0">VAT/Sales Tax</option>
											                   		<option value="4" <?php if(isset($_REQUEST['prod_id']) && ($_REQUEST['prod_id'] == "4")){ echo "selected=selected";}?> data-dbsuffix="0">Central Excise</option>
											                   		<option value="2" <?php if(isset($_REQUEST['prod_id']) && ($_REQUEST['prod_id'] == "2")){ echo "selected=selected";}?> data-dbsuffix="0">Service Tax</option>
											                   		<option value="5" <?php if(isset($_REQUEST['prod_id']) && ($_REQUEST['prod_id'] == "5")){ echo "selected=selected";}?> data-dbsuffix="0">Customs</option>
											                	</select>
											             	</div>
											          	</div>
										       		</div>
										    	</div>
										 	</div>

										 	<div class="row">
										    	<div class="col-md-16">
										       		<div class="row">
										          		<div class="col-md-3 col-xs-16">
										             		<label id="searchTypeLabel">CGST Section No.</label>
										          		</div>
										          		<div class="col-md-9 col-xs-8">
										             		<div class="form-group">
										                		<input type="text" class="form-control" id="cgst_section" placeholder="CGST Section No." name="cgst_section" value="<?php if(isset($_REQUEST['cgst_section']) && (!empty($_REQUEST['cgst_section']))){ echo $_REQUEST['cgst_section'];}?>" />
										             		</div>
										          		</div>
										          		<div class="col-md-4 col-xs-8">
										             		<p class="text"> (only for GST Caselaws)</p>
										          		</div>
										       		</div>
												</div>
										 	</div>

										 	<div class="row">
										    	<div class="col-md-16">
										       		<div class="row">
										          		<div class="col-md-3 col-xs-16">
										             		<label id="searchTypeLabel">CGST Rule No.</label>
										          		</div>
										          		<div class="col-md-9 col-xs-8">
										             		<div class="form-group">
										                		<input type="text" class="form-control" id="cgst_rule" placeholder="CGST Rule No." name="cgst_rule" value="<?php if(isset($_REQUEST['cgst_rule']) && (!empty($_REQUEST['cgst_rule']))){ echo $_REQUEST['cgst_rule'];}?>"/>
										             		</div>
										          		</div>
										          		<div class="col-md-4 col-xs-8">
										             		<p class="text"> (only for GST Caselaws)</p>
										          		</div>
										       		</div>
										    	</div>
										 	</div>

										 	<div class="row">
										    	<div class="col-md-16">
										       		<div class="row">
										          		<div class="col-md-3 col-xs-16">
										             		<label id="searchTypeLabel">Court</label>
										          		</div>
											          	<div class="col-md-9 col-xs-16">
											             	<div class="form-group">
											                	<select id='court' name='court' class="form-control">
											                		<option value="0" <?php if(isset($_REQUEST['court']) && ($_REQUEST['court'] == "0")){ echo "selected=selected";}?>data-dbsuffix="0">Select</option>
											                   		<option value="SC" <?php if(isset($_REQUEST['court']) && ($_REQUEST['court'] == "SC")){ echo "selected=selected";}?>data-dbsuffix="0">Supreme Court</option>
											                   		<option value="HC" <?php if(isset($_REQUEST['court']) && ($_REQUEST['court'] == "HC")){ echo "selected=selected";}?>data-dbsuffix="0">High Court</option>
											                   		<option value="TRI" <?php if(isset($_REQUEST['court']) && ($_REQUEST['court'] == "TRI")){ echo "selected=selected";}?>data-dbsuffix="0">Tribunal</option>
											                   		<option value="AAR" <?php if(isset($_REQUEST['court']) && ($_REQUEST['court'] == "AAR")){ echo "selected=selected";}?>data-dbsuffix="0">AAR</option>
											                   		<option value="NAA" <?php if(isset($_REQUEST['court']) && ($_REQUEST['court'] == "NAA")){ echo "selected=selected";}?>data-dbsuffix="0">NAA</option>
											                   		<option value="AAAR" <?php if(isset($_REQUEST['court']) && ($_REQUEST['court'] == "AAAR")){ echo "selected=selected";}?>data-dbsuffix="0">AAAR</option>
											            		</select>
											             	</div>
											          	</div>
										       		</div>
												</div>
										 	</div>
										 	
										 	<div class="row" id='hc' style="display: none;">
										    	<div class="col-md-16">
										       		<div class="row">
										          		<div class="col-md-3 col-xs-16">
										             		<label id="searchTypeLabel">Bench/City</label>
										          		</div>
											          	<div class="col-md-9 col-xs-16">
											             	<div class="form-group">
											                	<select id='courtCityHC' name='courtCity' class="form-control" >
															   	 	<option value="0">Select City</option>
															        <option value="ALH" <?php if(isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == 'ALH')){ echo "selected=selected";}?>>Allahabad
															        </option>
															        <option value="AP" <?php if(isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == 'AP')){ echo "selected=selected";}?>>Andhra Pradesh</option>
															        <option value="GAU" <?php if(isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == 'GAU')){ echo "selected=selected";}?>>Gauhati
															        </option>
															        <option value="CHG" <?php if(isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == 'CHG')){ echo "selected=selected";}?>>Chhattishgarh
															        </option>
															        <option value="DEL" <?php if(isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == 'DEL')){ echo "selected=selected";}?>>Delhi
															        </option>
															        <option value="BOM" <?php if(isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == 'BOM')){ echo "selected=selected";}?>>Bombay
															        </option>
															        <option value="GUJ" <?php if(isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == 'GUJ')){ echo "selected=selected";}?>>Gujarat
															        </option>
															        <option value="P_H" <?php if(isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == 'P_H')){ echo "selected=selected";}?>>Punjab & Haryana</option>
															        <option value="J_K" <?php if(isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == 'J_K')){ echo "selected=selected";}?>>Jammu & Kashmir</option>
															        <option value="JHR" <?php if(isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == 'JHR')){ echo "selected=selected";}?>>Jharkhand
															        </option>
															        <option value="KER" <?php if(isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == 'KER')){ echo "selected=selected";}?>>Kerala
															        </option>
															        <option value="KAR" <?php if(isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == 'KAR')){ echo "selected=selected";}?>>Karnataka
															        </option>
															        <option value="RAJ" <?php if(isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == 'RAJ')){ echo "selected=selected";}?>>Rajasthan
															        </option>
															        <option value="ORI" <?php if(isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == 'ORI')){ echo "selected=selected";}?>>Odisha
															        </option>
															        <option value="MAD" <?php if(isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == 'MAD')){ echo "selected=selected";}?>>Madras
															        </option>
															        <option value="UTR" <?php if(isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == 'UTR')){ echo "selected=selected";}?>>Uttarakhand
															        </option>
															        <option value="CAL" <?php if(isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == 'CAL')){ echo "selected=selected";}?>>Calcutta
															        </option>
															        <option value="MP" <?php if(isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == 'MP')){ echo "selected=selected";}?>>Madhya Pradesh
															        </option>
															        <option value="SIK" <?php if(isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == 'SIK')){ echo "selected=selected";}?>>Sikkim
															        </option>
															        <option value="MEG" <?php if(isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == 'MEG')){ echo "selected=selected";}?>>Meghalaya
															        </option>
															        <option value="HP" <?php if(isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == 'HP')){ echo "selected=selected";}?>>Himachal Pradesh
															        </option>
															        <option value="PAT" <?php if(isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == 'PAT')){ echo "selected=selected";}?>>Patna
															        </option>
															        <option value="ORI" <?php if(isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == 'ORI')){ echo "selected=selected";}?>>Orissa
															        </option>
															        <option value="TEL" <?php if(isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == 'TEL')){ echo "selected=selected";}?>>Telangana
															        </option>
															        <option value="TRI" <?php if(isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == 'TRI')){ echo "selected=selected";}?>>Tripura
															        </option>
																</select>
											             	</div>
											          	</div>
										       		</div>
												</div>
										 	</div>
									      	
									      	<div class="row" id='tri' style="display: none;">
										    	<div class="col-md-16">
										       		<div class="row">
										          		<div class="col-md-3 col-xs-16">
										             		<label id="searchTypeLabel">Bench/City</label>
										          		</div>
											          	<div class="col-md-9 col-xs-16">
											             	<div class="form-group">
											                	<select id='courtCityTRI' name='courtCity1' onchange="" class="form-control" >
															   	 	<option value="0">Select City</option>
															        <option value="AHM" <?php if(isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == 'AHM')){ echo "selected=selected";}?>>Ahmedabad
															        </option>
															        <option value="ALH" <?php if(isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == 'ALH')){ echo "selected=selected";}?>>Allahabad
															        </option>
															        <option value="BLR" <?php if(isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == 'BLR')){ echo "selected=selected";}?>>Bangalore
															        </option>
															        <option value="CHD" <?php if(isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == 'CHD')){ echo "selected=selected";}?>>Chandigarh
															        </option>
															        <option value="CHE" <?php if(isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == 'CHE')){ echo "selected=selected";}?>>Chennai
															        </option>
															        <option value="DEL" <?php if(isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == 'DEL')){ echo "selected=selected";}?>>Delhi
															        </option>
															        <option value="HYD" <?php if(isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == 'HYD')){ echo "selected=selected";}?>>Hyderabad
															        </option>
															        <option value="KOL" <?php if(isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == 'KOL')){ echo "selected=selected";}?>>Kolkata
															        </option>
															        <option value="MUM" <?php if(isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == 'MUM')){ echo "selected=selected";}?>>Mumbai
															        </option>
														 		</select>
											             	</div>
											          	</div>
										       		</div>

												</div>
										 	</div>

										 	<div class="row">
											    <div class="col-md-16">
											       	<div class="row">
											          	<div class="col-md-3 col-xs-16">
											             	<label id="searchTypeLabel">Date</label>
											          	</div>
											          	<div class="col-md-9 col-xs-16">
											             	<div class="form-group">
											                	<input type="date" class="form-control" id="date" placeholder="" name="date" value="<?php if(isset($_REQUEST['date']) && (!empty($_REQUEST['date']))){ echo $_REQUEST['date'];}?>" />
											             	</div>
											          	</div>
											       	</div>
											    </div>
											</div>
											<div class="row">
											    <div class="col-md-16 col-xs-16">
											       	<div class="row">
											          	<div class="col-md-3 col-xs-16">
											             	<label id="searchTypeLabel">Date Range</label>
											          	</div>
											          	<div class="col-md-4 col-xs-7">
											             	<div class="form-group">
											                	<input type="date" class="form-control" id="dt_from" placeholder="" name="dt_from" value="<?php if(isset($_REQUEST['dt_from']) && (!empty($_REQUEST['dt_from']))){ echo $_REQUEST['dt_from'];}?>" />
											             	</div>
											          	</div>
											          	<div class="col-md-1 text-center col-xs-2">
											            	<p class="text"> to</p>
											          	</div>
											          	<div class="col-md-4 col-xs-7">
											             	<div class="form-group">
											                	<input type="date" class="form-control" id="dt_to" placeholder="" name="dt_to" value="<?php if(isset($_REQUEST['dt_to']) && (!empty($_REQUEST['dt_to']))){ echo $_REQUEST['dt_to'];}?>" />
											             	</div>
											          	</div>
											      	</div>
											    </div>
											</div>

											<div class="row">
											    <div class="col-md-16">
											       	<div class="row">
											          	<div class="col-md-3  col-xs-16">
											             	<label id="searchTypeLabel">Citation</label>
											          	</div>
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
											                	<input type="text" class="form-control" id="Citation" placeholder="" name="Citation" value="<?php if(isset($_REQUEST['Citation']) && (!empty($_REQUEST['Citation']))){ echo $_REQUEST['Citation'];}?>" />
											             	</div>
											          	</div>
											       	</div>
											    </div>
											</div>
									      	<div class="col-md-8">
									      		<label></label>      	
												<div class="form-group">
													<input type="submit" name="searchButton" id="searchButton" value="Search" class="btn"/>
											    <!-- <input type="reset" name="resetBtn" id="resetBtn" value="Reset Search" class="btn" onClick="window.location.href='searchCaseLawAdv';" /> -->
										    	</div>
									      	</div>
									  	<!-- <div><a href="searchCaseLaw"  class="pull-right">Quick Search</a></div> -->
										
										</form>
									</div>	
										
								<?php
									}	
								}
								?>
							<!---------- End of Forms search options ------------------>  		 
				            </div>
				        </div>
				    </div>
			    </div>
			</div>
		<?php		
			} 
			else 
			{
	  			include('loggedInError.php');
	  		}
		?>   
    </div> 
</div>
<?php
include('footer.php');
?>

<script type="text/javascript">
	$("#advance_search").click(function(){
		debugger;
		$("#accordion").slideToggle();
		$(".searchbody").toggle();
	});	

	var searchBody=function(data){
		debugger;
		window.location='searchBody?search='+data;
	}

	$("#courtType").change(function(){
		debugger;
		var type=$(this).val();
		if(type=='High Court Cases'){
			$("#tri option:first").attr('selected','selected');
			$("#tri").css('display','none');
			$("#hc").css('display','block');

		}
		else if(type=='Tribunal'){
			$("#hc option:first").attr('selected','selected');
			$("#hc").css('display','none');
			$("#tri").css('display','block');
		}
		else{
			$("#hc option:first").attr('selected','selected');
    		$("#tri option:first").attr('selected','selected');
			$("#tri").css('display','none');
			$("#hc").css('display','none');
		}
	});

	$("#prod_id").change(function(){
		debugger;
		var val=$(this).val();
		var dbsuffix=$(this).find('option:selected').attr('data-dbsuffix');
		$("#dbsuffix").val(dbsuffix);
		$("#notification_type").css('display','none');
		if(val=='7'){
			$("#state").css("display","block");
		}else{
			$("#state").css("display","none");
		}
		if(dbsuffix!='0'){
			var table='casedata_'+dbsuffix;
		}else{
			$('#category_type').css("display","none");
			return false;
		}
		if(val=='1' || val=='2' || val=='4' || val=='5' || val=='6' || val=='7' || val=='8' || val=='9' || val=='10')
		{
			$.ajax({
            	data :{id: val, table : table},
            	url  :"adv_search_notification_type.php", //php page URL where we post this data to view from database
            	type :'POST',
            	dataType: 'html',  
            	success: function(data){
            		debugger;
            		//alert(data);
	            	if(data!="no"){

	            		$('#category_type').css("display","block");
	            		$("#sub_product_id").html(data);
	            	}else{
	            		$('#category_type').css("display","none");
	            	}
                }
            });
            return false;
		}
		$('#category_type').css("display","none");
	});

	$("#sub_product_id").change(function(){
		debugger;
		var val=$("#prod_id option:selected").val();
		var type=$("#sub_product_id option:selected").text();
		$('#not_type').find('option').remove();
		if(val=='7' || val=='8' || val=='9' || val=='10')
		{
			if(type=="Notification")
			{
				$("#notification_type").css('display','block');
				$(".not_type_label").text('Notification Type');
				$("#not_type").append('<option value="0">Select</option>'+'<option value="Notification">Notification</option>'+
	                        '<option value="Rate Notification">Rate Notification</option>');
			}
			else
			{
				$("#notification_type").css('display','none');
			}
		}

		if(val=='5')
		{	
			$("#notification_type").css('display','block');
			if(type=="Notification")
			{
				$(".not_type_label").text('Notification Type');
				$("#not_type").append('<option value="0">Select</option>'+'<option value="Tariff">Tariff</option>'+
	                        '<option value="Non-Tariff">Non-Tariff</option>'+'<option value="Safeguards">Safeguards</option>'+
	                        '<option value="Anti Dumping Duty">Anti Dumping Duty</option>'+
	                        '<option value="Others">Others</option>');
			}
			else
			{
				$(".not_type_label").text('Circular Type');
				$("#not_type").append('<option value="0">Select</option>'+'<option value="Circulars">Circulars</option>'+
	                        '<option value="Instructions">Instructions</option>');
			}
		}

		if(val=='4')
		{	
			$("#notification_type").css('display','block');
			if(type=="Notification")
			{
				$(".not_type_label").text('Notification Type');
				$("#not_type").append('<option value="0">Select</option>'+'<option value="Tariff">Tariff</option>'+
	                        '<option value="Non-Tariff">Non-Tariff</option>');
			}
			else
			{
				$(".not_type_label").text('Circular Type');
				$("#not_type").append('<option value="0">Select</option>'+'<option value="Circulars">Circulars</option>'+
	                        '<option value="Instructions">Instructions</option>');
			}
		}
	});	

	// for act and rule
	$("#type").change(function(){
		debugger;
		var value=$(this).val();
		if(value=="Acts"){
			$("#section_no").val("");
			$("#section").css("display","block");
			$("#rule").css("display","none");
		}else{
			$("#rule_no").val("");
			$("#rule").css("display","block");
			$("#section").css("display","none");
		}

	});
</script>

<script type="text/javascript">
	$(document).ready(function(){
		debugger;
		var dbsuffix = $("#prod_id").find('option:selected').attr('data-dbsuffix');
		$("#dbsuffix").val(dbsuffix);

		//for case law
		$("#court").change(function(){
			var value=$(this).val();
			if(value=="HC"){
				$("#tri").css('display','none');
				$("#hc").css('display','block');
			}else if(value=="TRI"){
				$("#hc").css('display','none');
				$("#tri").css('display','block');
			}
			else{
				$("#courtCityHC").val("0");
				$("#courtCityTRI").val("0");
	    		//$("#courtCityHC").prop("selected", false);
	    		//$("#courtCityTRI").prop("selected", false);
	    		$("#tri").css('display','none');
	    		$("#hc").css('display','none');
	    	}
		});	
		
	});
	
</script>
