<?php

	$page = '';
	date_default_timezone_set("Asia/Calcutta");
	include('header.php');  
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
	//echo $_SERVER['REQUEST_URI'];
	//print_r($_SESSION);

		// function wordval($text)
		// {
		// 	$value=trim(preg_replace('/[^A-Za-z0-9]/', ' ', $text)); // Removes special chars.
		// 	$value1=explode(' ',$value);
		// 	return implode('%%',$value1); 
		// }
		
		function dbRowInsert($table_name, $form_data) {

			global $con;
		    // retrieve the keys of the array (column titles)
		    $fields = array_keys($form_data);

		    // build the query
		    $sql = "INSERT INTO " . $table_name . "
		    (`" . implode('`,`', $fields) . "`)
		    VALUES('" . implode("','", $form_data) . "')";

		    // run and return the query result resource
		    //return mysqli_query($GLOBALS['con'],$sql);
		    $a = mysqli_query($GLOBALS['con'],$sql);
		    if (!$a) {
		        die('Could not enter data: ' . mysqli_error());
		    } else {
		        return $a;
		    }
		}

		function dbRowUpdate($table_name, $form_data, $where_clause = '') {
		    // check for optional where clause
			global $con;
		    $whereSQL = '';
		    if (!empty($where_clause)) {
		        // check to see if the 'where' keyword exists
		        if (substr(strtoupper(trim($where_clause)), 0, 5) != 'WHERE') {
		            // not found, add key word
		            $whereSQL = " WHERE " . $where_clause;
		        } else {
		            $whereSQL = " " . trim($where_clause);
		        }
		    }
		    // start the actual SQL statement
		    $sql = "UPDATE " . $table_name . " SET ";

		    // loop and build the column /
		    $sets = array();
		    foreach ($form_data as $column => $value) {
		        $sets[] = "`" . $column . "` = '" . $value . "'";
		    }
		    $sql .= implode(', ', $sets);

		    // append the where statement
		    $sql .= $whereSQL;

		    // run and return the query result
		    return mysqli_query($GLOBALS['con'],$sql);
		}

		function dbRowDelete($table_name, $where_clause = '') {
		    // check for optional where clause
		    $whereSQL = '';
		    if (!empty($where_clause)) {
		        // check to see if the 'where' keyword exists
		        if (substr(strtoupper(trim($where_clause)), 0, 5) != 'WHERE') {
		            // not found, add keyword
		            $whereSQL = " WHERE " . $where_clause;
		        } else {
		            $whereSQL = " " . trim($where_clause);
		        }
		    }
		    // build the query
		    $sql = "DELETE FROM " . $table_name . $whereSQL;

		    // run and return the query result resource
		    return mysqli_query($GLOBALS['con'],$sql);
		}
		
		function clean($string){
	   		return preg_replace('/[^A-Za-z0-9\& ]/', '', $string); // Removes special chars.
		}

		function shortForm($text)
		{
			global $con;

			$replace=array();
			$rep_data=array();
			if(!empty($text))
			{
				$value=explode(' ', $text);
				foreach ($value as $k=>$v) {
					$result = mysqli_query($GLOBALS['con'],"SELECT * FROM `short_form` WHERE `short_form` LIKE '$v'") or die(mysqli_error());	
					$data = mysqli_fetch_array($result);
					if(mysqli_num_rows($result)>0){
						$replace[]=$data['full_form'];	
					}else{
						$replace[]=$v;
					}
				}
				$rep_data[]=implode(' ', $replace);
				//$rep_data[]=implode(' ', array_replace($value, $replace));	
			}
			return $rep_data; 		
		}
		
		function getStatDropdown($state_id, $selectValue) {
			global $con;
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

		function tableUnion($conditions,$table,$ids,$sub_prod_name){
			global $con;
			//$table=array("casedata_ce","casedata_cu","casedata_gst","casedata_st","casedata_vat");
			//print_r($sub_prod_name); die();
			if(!empty($conditions)){
				$value=" WHERE " . implode(' AND ', $conditions);
			}else{
				$value="";
			}
			$count=0;
			foreach ($table as $tbl) {
				$qry = mysqli_query($GLOBALS['con'],"SELECT p.prod_id,p.dbsuffix,sp.sub_prod_id FROM product as p LEFT JOIN sub_product as sp ON p.prod_id=sp.prod_id WHERE p.prod_id= '".$ids[$count]."'".$sub_prod_name) or die(mysqli_error());
				$where=[];

				if(mysqli_num_rows($qry)>0)
				{
					while ($data = mysqli_fetch_array($qry)) {	
						$where[]="a.sub_prod_id = '".$data['sub_prod_id']."'";
					}	
				}
				if(!empty($where))
				{
					if(!empty($conditions)){
						$where_data=" AND (".implode(' OR ', $where).")";
					}else{
						$where_data=" where ".implode(' OR ', $where);
					}	
				}
				else
				{
					$where_data="";
				}
				$query[]="SELECT a.data_id,a.prod_id,a.sub_prod_id,a.sub_subprod_id,a.state_id,a.circular_date,a.eq_citation,a.section_no,a.rule_no,a.circular_no,a.cir_subject,a.file_path,a.file_data,a.party_name,a.active_flag,a.new_flag,a.created_dt, DATE_FORMAT(circular_date,GET_FORMAT(DATE,'EUR'))'Date',p.prod_name,p.dbsuffix,sp.sub_prod_name,sm.state_name FROM $tbl as a LEFT JOIN product as p ON a.prod_id=p.prod_id LEFT JOIN sub_product as sp ON a.sub_prod_id=sp.sub_prod_id LEFT JOIN state_master as sm ON a.state_id=sm.state_id".$value.$where_data;

				//$query[]="SELECT a.*, DATE_FORMAT(circular_date,GET_FORMAT(DATE,'EUR'))'Date',p.prod_name,p.dbsuffix,sp.sub_prod_name,sm.state_name FROM $tbl as a LEFT JOIN product as p ON a.prod_id=p.prod_id LEFT JOIN sub_product as sp ON a.sub_prod_id=sp.sub_prod_id LEFT JOIN state_master as sm ON a.state_id=sm.state_id".$value.$where_data;
				$count++;
			}
			//return implode(' UNION ', $query);
			return $query;
		}

		function allCaseDataQuery($conditions,$table)
		{
			//$table=array("casedata_ce","casedata_cu","casedata_gst","casedata_st","casedata_vat");
			if(!empty($conditions)){
				$value=" WHERE " . implode(' AND ', $conditions);
			}else{
				$value="";
			}
			foreach ($table as $data) {
				$query[]="SELECT a.*,DATE_FORMAT(circular_date,GET_FORMAT(DATE,'EUR'))'Date',p.prod_name,p.dbsuffix,sp.sub_prod_name,sm.state_name FROM $data as a LEFT JOIN product as p ON a.prod_id=p.prod_id LEFT JOIN sub_product as sp ON a.sub_prod_id=sp.sub_prod_id LEFT JOIN state_master as sm ON a.state_id=sm.state_id".$value;
			}
			//return implode(' UNION ', $query);
			return $query;
		}

		function getCategory($table,$value){
			global $con;
	  		$result = mysqli_query($GLOBALS['con'],"SELECT * FROM $table  WHERE sub_prod_type = '$value'");
	  		if(mysqli_num_rows($result)>0){
		  		$row = mysqli_fetch_array($result);
		  		$data_id=explode(',',$row['prod_id']);
		  		$conditions=array();
		  		foreach ($data_id as $key) {
		  			$conditions[]="prod_id='$key'";
		  		}
		  		$where=implode(' OR ', $conditions);
		  		$dbsuffix=array();
		  		$query=mysqli_query($GLOBALS['con'],"SELECT * FROM product WHERE $where");
		  		while($rows = mysqli_fetch_array($query)){
		  			$dbsuffix['db'][]="casedata_".$rows['dbsuffix'];
		  			$dbsuffix['id'][]=$rows['prod_id'];
		  		}
		  		return $dbsuffix;
		  	}
		}

		function getsubproductnoti($table,$value,$id){
			if(is_array($id)){
				foreach ($id as $key) {
					$prod_id[]="prod_id='$key'";
				}
				return $p_id=implode(' OR ', $prod_id);
			}else{
				$p_id="prod_id='$id'";
			}
			
			
	  		$result = mysqli_query($GLOBALS['con'],"SELECT * FROM $table  WHERE sub_prod_type = '$value' AND (sub_prod_name='Notification' OR sub_prod_name='Circular') AND ($p_id)");
	  		if(mysqli_num_rows($result)>0){
		  		while($row = mysqli_fetch_array($result)){
		  			$subprod_id[]=$row['sub_prod_id'];
		  		}
		  		foreach ($subprod_id as $key) {
		  			$s_id[]="a.sub_prod_id='$key'";
		  		}
		  		return implode(' OR ', $s_id);
		  	}
		}

		function getsubproduct($table,$value,$id){
			if(is_array($id)){
				foreach ($id as $key) {
					$prod_id[]="prod_id='$key'";
				}
				$p_id=implode(' OR ', $prod_id);
			}else{
				$p_id="prod_id='$id'";
			}
			
			
	  		$result = mysqli_query($GLOBALS['con'],"SELECT * FROM $table  WHERE sub_prod_type = '$value' AND ($p_id)");
	  		if(mysqli_num_rows($result)>0){
		  		while($row = mysqli_fetch_array($result)){
		  			$subprod_id[]=$row['sub_prod_id'];
		  		}
		  		foreach ($subprod_id as $key) {
		  			$s_id[]="a.sub_prod_id='$key'";
		  		}
		  		return implode(' OR ', $s_id);
		  	}
		}
	?>
<script type="text/javascript">
	var calcHeight = function () {
		var the_height = document.getElementById('iFramePopupFrame').contentWindow.document.body.scrollHeight + 50;
		//isPdf=0

		if ($('#iFramePopupFrame').attr('isPdf') == '0') {
			document.getElementById('iFramePopupFrame').height = the_height;
		}
	}


</script>

<?php

		if(isset($_REQUEST['searchButton'])) 
		{
			//print_r($_REQUEST); 
			$seoTitle = $_REQUEST['pagename'].'- Quick Search';
			$seoKeywords = $_REQUEST['pagename'].'- Quick Search';
			$seoDesc = $_REQUEST['pagename'].'- Quick Search';
			

			if($_REQUEST['pagename']=='Notification')
		    {
		    	// print_r($_REQUEST); die();
				$row_count = $_SESSION['row'];
				$text=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['notification_keyword']);
                $user_id = $_SESSION["id"];
                $user_name = $_SESSION["user"];
                $page_name = "Notification";
                $search_in = "Quick Search";
                $search_form_data = array(
                    'user_id' => $user_id,
                    'user_name' => $user_name,
                    'keyword' => $text,
                    'pagename' => $page_name,
                    'search_in' => $search_in,
                    'row_count' => $row_count,
                    'updated_dt' => date('Y-m-d H:i:s')
                );
                dbRowInsert('search_history', $search_form_data);
		      	function notification(){
		      	    $orderby = " ORDER BY circular_date DESC";
					$conditions = array();
					$conditions[]="a.active_flag = 'Y'";

					//print_r($_REQUEST);
					// for keyword
					if($_REQUEST['notification_keyword']!="")
					{
						$keyword=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['notification_keyword']);
						$string=trim(clean($keyword));
						$rep_data=shortForm($string);
						
						$conditions[] = "((a.cir_subject LIKE '%".$string."%' OR a.file_data LIKE '%".$string."%' OR a.party_name LIKE '%".$string."%') OR(a.cir_subject LIKE '%".$rep_data[0]."%' OR a.file_data LIKE '%".$rep_data[0]."%' OR a.party_name LIKE '%".$rep_data[0]."%')) ";
					}

					// for notification number
					if($_REQUEST['noti_cir']!='')
					{	
						$not_no=trim(mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['noti_cir']));
						$conditions[]="a.circular_no LIKE '%".$not_no."%'";
					}

					// for category
					if($_REQUEST['notification_prod_id']!=0)
					{
						$result = mysqli_query($GLOBALS['con'],"SELECT p.prod_id,p.dbsuffix,sp.sub_prod_id FROM product as p LEFT JOIN sub_product as sp ON p.prod_id=sp.prod_id WHERE p.prod_id= '".$_REQUEST['notification_prod_id']."' AND (sp.sub_prod_name='Circular' OR sp.sub_prod_name='Notification')") or die(mysqli_error());
						$sub_prod=[];
						if(mysqli_num_rows($result)>0)
						{
							while ($data = mysqli_fetch_array($result)) {	
								// $sub_prod[]="a.sub_prod_id = '".$data['sub_prod_id']."'";
								$data_db=$data['dbsuffix'];
							}	
						}
						
						if($_REQUEST['notification_prod_id']=='7' && $_REQUEST['state_id']!='0')
						{
							$conditions[] = "a.state_id = '".$_REQUEST['state_id']."'";
						}
						if (
							isset($_REQUEST['yearFrom']) 
							&& isset($_REQUEST['yearTo']) 
							&& !empty($_REQUEST['yearFrom']) 
							&& !empty($_REQUEST['yearTo'])) {
							
							$yearFrom = $_REQUEST['yearFrom'];
							$yearTo = $_REQUEST['yearTo'];
							
							$conditions[] = "(a.circular_date BETWEEN '".$yearFrom."' AND '".$yearTo."')";
						}
	
						
						$query="SELECT a.*,DATE_FORMAT(circular_date,GET_FORMAT(DATE,'EUR'))'Date',p.prod_name,p.dbsuffix,sp.sub_prod_name,sm.state_name FROM casedata_".$data_db." as a LEFT JOIN product as p ON a.prod_id=p.prod_id LEFT JOIN sub_product as sp ON a.sub_prod_id=sp.sub_prod_id LEFT JOIN state_master as sm ON a.state_id=sm.state_id ";
						if(count($conditions)>0)
						{
							return $sql=$query."WHERE (".implode(' OR ', $sub_prod).") AND ".implode(' AND ', $conditions)." ".$orderby;
						}
						else
						{
							return $sql=$query."WHERE ".implode(' OR ', $sub_prod)." ".$orderby;
						}
						
					}
					else
					{
						$id=['1','2','4','5','6','7','9','10'];
						$table=array("casedata_vat","casedata_st","casedata_ce","casedata_cu","casedata_dgft","casedata_sgst","casedata_igst","casedata_cgst");
						$sub_prod_name="AND (sp.sub_prod_name='Circular' OR sp.sub_prod_name='Notification')";
						return $sql=implode(" UNION ",(tableUnion($conditions,$table,$id,$sub_prod_name)))." ".$orderby;

					}
				}
			}


			if($_REQUEST['pagename']=='Case Laws')
			{
				
				$row_count = $_SESSION['row'];
				$text=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['case_keyword']);
                $user_id = $_SESSION["id"];
                $user_name = $_SESSION["user"];
                $page_name = "Case Laws";
                $search_in = "Quick Search";
                $party_name = mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['party_name']);
                $search_form_data = array(
                    'user_id' => $user_id,
                    'user_name' => $user_name,
                    'keyword' => $text,
                    'party_name' => $party_name,
                    'pagename' => $page_name,
                    'search_in' => $search_in,
                    'row_count' => $row_count,
                    'updated_dt' => date('Y-m-d H:i:s')
                );
                dbRowInsert('search_history', $search_form_data);
				function case_data()
				{
					global $con;
					// $orderby="order by CAST(SUBSTR(circular_no,1) AS SIGNED) DESC";  
					//$orderby="ORDER BY substring_index(`circular_no`,'-',3) DESC";  
					$orderby = " ORDER BY circular_date DESC";
					$conditions = array();
					$conditions[]="a.active_flag = 'Y'";

					// for keyword
					if($_REQUEST['case_keyword']!="")
					{
						$keyword=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['case_keyword']);
						$string=trim(clean($keyword));
						$rep_data=shortForm($string);
						
						$conditions[] ="(a.cir_subject LIKE '%".$string."%' OR a.cir_subject LIKE '%".$rep_data[0]."%' OR a.file_data LIKE '%".$string."%' OR a.file_data LIKE '%".$rep_data[0]."%')";
						

					}

					// for Party name
					if($_REQUEST['party_name']!="")
					{
						$party_name=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['party_name']);
						$string=trim($party_name);
						$rep_data=shortForm($string);

						$conditions[] ="(a.party_name LIKE '%".$string."%' OR a.party_name LIKE '%".$rep_data[0]."%')";
					}
					// For year filter
					if (
						isset($_REQUEST['yearFrom']) 
						&& isset($_REQUEST['yearTo']) 
						&& !empty($_REQUEST['yearFrom']) 
						&& !empty($_REQUEST['yearTo'])) {
						
						$yearFrom = $_REQUEST['yearFrom'];
						$yearTo = $_REQUEST['yearTo'];
						
						$conditions[] = "(a.circular_date BETWEEN '".$yearFrom."' AND '".$yearTo."')";
					}
					// for sub product id
					if (
						isset($_REQUEST['sub_prod_id']) 
						&& !empty($_REQUEST['sub_prod_id'])
						) {
						$sub_prod_id = $_REQUEST['sub_prod_id'];
						$conditions[] = "(a.sub_prod_id = " . $sub_prod_id .")";
					}

				    //<--------Condition For Citation number--------->
				    $year=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['year']);
				    $volume=trim(mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['vol']));
				    $c_value=trim(mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['Citation']));
				    if(!empty($year) && !empty($volume) && !empty($c_value)){
				    	$c_no=$year."-VIL-".$volume."-".$c_value;
				    	$conditions[]="a.circular_no LIKE '%$c_no%'";
				    }elseif (!empty($year) && !empty($volume)) {
				    	$c_no=$year."-VIL-".$volume;
				    	$conditions[]="a.circular_no LIKE '%$c_no%'";
				    }elseif (!empty($volume) && !empty($c_value)) {
				    	$c_no="-VIL-".$volume."-".$c_value;
				    	$conditions[]="a.circular_no LIKE '%$c_no%'";
				    }elseif (!empty($year)) {
				    	$c_no=$year."-VIL-";
				    	$conditions[]="a.circular_no LIKE '%$c_no%'";
				    }elseif (!empty($volume)) {
				    	$c_no="-VIL-".$volume;
				    	$conditions[]="a.circular_no LIKE '%$c_no%'";
				    }elseif (!empty($c_value)) {
				    	$c_no=$c_value;
				    	$conditions[]="a.circular_no LIKE '%$c_no%'";
				    }

					if ($_REQUEST['court'] != '0') {
						if ($_REQUEST['court'] == "HC") {
							$conditions[] = "(sp.sub_prod_name LIKE 'High Court Cases')";
						} else if ($_REQUEST['court'] == "SC") {
							$conditions[] = "(sp.sub_prod_name LIKE 'Supreme Court Cases')";
						} else if ($_REQUEST['court'] == "TRI") {
							$conditions[] = "(sp.sub_prod_name LIKE 'CESTAT Cases')";
						} else if ($_REQUEST['court'] == "AAR") {
							$conditions[] = "(sp.sub_prod_name LIKE 'Advance Ruling Authority')";
						} else if ($_REQUEST['court'] == "AAAR") {
							$conditions[] = "(sp.sub_prod_name LIKE 'AAAR')";
						} else if ($_REQUEST['court'] == "NAA") {
							$conditions[] = "(sp.sub_prod_name LIKE 'National Anti-Profiteering Authority')";
						}
					} 
				    //<--------End of  Citation number--------->

				    // for category
					if($_REQUEST['case_prod_id']!=0)
					{

						$result = mysqli_query($GLOBALS['con'],"SELECT p.prod_id,p.dbsuffix,sp.sub_prod_id FROM product as p LEFT JOIN sub_product as sp ON p.prod_id=sp.prod_id WHERE p.prod_id= '".$_REQUEST['case_prod_id']."' AND (sp.sub_prod_type LIKE 'Judgements')") or die(mysqli_error());
						$sub_prod=[];
						if(mysqli_num_rows($result)>0)
						{
							while ($data = mysqli_fetch_array($result)) {	
								// $sub_prod[]="a.sub_prod_id = '".$data['sub_prod_id']."'";
								$data_db=$data['dbsuffix'];
							}	
						}
						if(!empty($sub_prod))
						{
							if(!empty($conditions)){
								$where_subprod=" AND (".implode(' OR ', $sub_prod).")";	
							}else{
								$where_subprod=implode(' OR ', $sub_prod);
							}
						}
						else
						{
							$where_subprod="";
						}

						$query="SELECT a.*,DATE_FORMAT(circular_date,GET_FORMAT(DATE,'EUR'))'Date',p.prod_name,p.dbsuffix,sp.sub_prod_name,sm.state_name FROM casedata_".$data_db." as a LEFT JOIN product as p ON a.prod_id=p.prod_id LEFT JOIN sub_product as sp ON a.sub_prod_id=sp.sub_prod_id LEFT JOIN state_master as sm ON a.state_id=sm.state_id ";

						$sql=$query."WHERE ".implode(' AND ', $conditions).$where_subprod." ".$orderby;
						

					}
					else
					{
						$id=['1','2','4','5','7'];
						$table=array("casedata_vat","casedata_st","casedata_ce","casedata_cu","casedata_sgst");
						//$id=['1','2'];
						//$table=array("casedata_vat","casedata_vat");
						$sub_prod_name="AND (sp.sub_prod_type LIKE 'Judgements')";
						$sql=implode(" UNION ",(tableUnion($conditions,$table,$id,$sub_prod_name)))." ".$orderby;

					}

					return $sql;
				}
					
			}

			$query=$_REQUEST['function_name']($_REQUEST);
			// print_r($query);die(); 
		}

		$showRecordPerPage =20;
        if(isset($_GET['page']) && !empty($_GET['page'])){
            $currentPage = $_GET['page'];
        }else{
            $currentPage = 1;
        }
	    $startFrom = ($currentPage * $showRecordPerPage) - $showRecordPerPage;
	    //include('count_query.php');
	    $res = mysqli_query($GLOBALS['con'],$query) or die(mysqli_error(mysqli_connect($db_host, $db_user, $db_pwd)));
	    $count = mysqli_num_rows($res);
	    $_SESSION['row'] = $count;
	    //$totalEmployee = mysqli_fetch_array($allEmpResult)[0];
	    $lastPage = ceil($count/$showRecordPerPage);
	    $firstPage = 1;
	    $nextPage = $currentPage + 1;
	    $previousPage = $currentPage - 1;
	    $query."LIMIT $startFrom, $showRecordPerPage";
	    $res1=mysqli_query($GLOBALS['con'],$query." LIMIT $startFrom, $showRecordPerPage") or die(mysqli_error());
	    $tocount=mysqli_num_rows($res1);

		  
	
?>
<style>
	.q_menu {
		background: linear-gradient(to bottom, #007ba0 0%, #005389 100%);

	}

	.q_menu a {
		color: white;
	}

	.case-law-one {
		padding: 10px 20px;
		border: 2px solid #005d8f;
		border-radius: 3px;
		background: #f7f7f7;
		transition: 0.3s;
	}

	.case-law-one:hover {
		cursor: pointer;
		box-shadow: 4px 4px 6px grey;
	}

	.case-law-one.q_active {
		background: linear-gradient(to bottom, #007ba0 0%, #005389 100%);
		color: #fff;
		box-shadow: 4px 4px 6px grey;
	}

	.case-law-one.q_active a {
		color: #fff;
	}
</style>
<!-- left sec start <div class="col-md-16 col-sm-16"> -->
<div class="col-md-11 col-sm-9 left-section main_div">
	<h1>
		<?php if(isset($_REQUEST['searchButton'])){echo $_REQUEST['pagename'].' - Quick Search';}else{echo 'Quick Search';}?>
		<ol class="breadcrumb">
			<li><a href="<?php echo $getBaseUrl; ?>">Home</a></li>
			<li class="active">
				<?php if(isset($_REQUEST['searchButton'])){echo $_REQUEST['pagename'].' - Quick Search';}else{echo 'Quick Search';}?>
			</li>
		</ol>

	</h1>
	<div class=" show-more">
		<a href="quicksearch.php" id="advance_search">New Search / Quick Search &nbsp;<i class="ion-chevron-right"></i><i
				class="ion-chevron-right"></i></a>
	</div>

	<div class=" show-more"
		style='background: linear-gradient(to bottom, #ff7708 1%,#ffa000 100%); text-align: left; padding: 10px 15px;'>
		<a href='#.' id='refine_search' style='color: #fff;'>Refine / Filter Search &nbsp;<i
				class='ion-chevron-right'></i><i class='ion-chevron-right'></i></a>
	</div>
	<!--  <div class='' style='background : #ff7808;'>
		 
	</div><div class='clear'></div>	 -->
	<div class='refine_search_body' style='display : block;'>
		<div class="col-md-8 searchbody">
			<div class="case-law-one q_active" id="q_case_law">
				<a href="#.">Case Law &nbsp;<i class="ion-chevron-right"></i><i class="ion-chevron-right"></i></a>
			</div>
		</div>
		<div class="col-md-8">
			<div class="case-law-one" id="q_cir">
				<a href="#.">Notification/Circular &nbsp;<i class="ion-chevron-right"></i><i
						class="ion-chevron-right"></i></a>
			</div>
		</div>
		<div class="col-md-16 table-container t-margin-20">

			<!-- case law search Form -->
			<div id="case_law_section">
				<form name="form1" method="get" class="form padding-b-15" id="case_form" action="quick_search.php">
					<input type="hidden" name="pagename" value="Case Laws">
					<input type="hidden" name="function_name" value="case_data">
					<div class="form-group">
						<label>Select Category </label>
						<div class="form-group">
							<select name="case_prod_id" id="prod_id" class="form-control">
								<option value="0" <?php if(isset($_REQUEST['case_prod_id']) &&
									($_REQUEST['case_prod_id']=="0" )){ echo "selected=selected" ;}?>
									data-dbsuffix="0">Select</option>
								<option value="7" <?php if(isset($_REQUEST['case_prod_id']) &&
									($_REQUEST['case_prod_id']=="7" )){ echo "selected=selected" ;}?>
									data-dbsuffix="0">GST</option>
								<option value="1" <?php if(isset($_REQUEST['case_prod_id']) &&
									($_REQUEST['case_prod_id']=="1" )){ echo "selected=selected" ;}?>
									data-dbsuffix="0">VAT/Sales Tax</option>
								<option value="4" <?php if(isset($_REQUEST['case_prod_id']) &&
									($_REQUEST['case_prod_id']=="4" )){ echo "selected=selected" ;}?>
									data-dbsuffix="0">Central Excise</option>
								<option value="2" <?php if(isset($_REQUEST['case_prod_id']) &&
									($_REQUEST['case_prod_id']=="2" )){ echo "selected=selected" ;}?>
									data-dbsuffix="0">Service Tax</option>
								<option value="5" <?php if(isset($_REQUEST['case_prod_id']) &&
									($_REQUEST['case_prod_id']=="5" )){ echo "selected=selected" ;}?>
									data-dbsuffix="0">Customs</option>
							</select>
						</div>
					</div>

					<div class="form-group">
							<label>Select Forum </label>
							<div class="form-group">
							    <select name="court" id="forum" class="form-control">
									<option value="0" <?php if (isset($_REQUEST['court']) && ($_REQUEST['court'] == "0")) { echo "selected=selected"; } ?>data-dbsuffix="0">Select</option>
                                	<option value="SC" <?php if (isset($_REQUEST['court']) && ($_REQUEST['court'] == "SC")) { echo "selected=selected"; } ?>data-dbsuffix="0">Supreme Court</option>
                                	<option value="HC" <?php if (isset($_REQUEST['court']) && ($_REQUEST['court'] == "HC")) { echo "selected=selected"; } ?>data-dbsuffix="0">High Court</option>
                                	<option value="TRI" <?php if (isset($_REQUEST['court']) && ($_REQUEST['court'] == "TRI")) { echo "selected=selected"; } ?>data-dbsuffix="0">CESTAT Cases</option>
                                	<option value="AAR" <?php if (isset($_REQUEST['court']) && ($_REQUEST['court'] == "AAR")) { echo "selected=selected"; } ?>data-dbsuffix="0">AAR</option>
                                	<option value="NAA" <?php if (isset($_REQUEST['court']) && ($_REQUEST['court'] == "NAA")) { echo "selected=selected"; } ?>data-dbsuffix="0">NAA</option>
                                	<option value="AAAR" <?php if (isset($_REQUEST['court']) && ($_REQUEST['court'] == "AAAR")) { echo "selected=selected"; } ?>data-dbsuffix="0">AAAR</option>
			                	</select>
							</div>
						</div>

					<div class="form-group">
						<label>Select Type</label>
						<div class="form-group">
							<select name="case_searchType" id="searchType" class="form-control">
								<option value="1" <?php if(isset($_REQUEST['case_searchType']) &&
									($_REQUEST['case_searchType']=="1" )){ echo "selected=selected" ;}?>>Party Name
								</option>
								<option value="0" <?php if(isset($_REQUEST['case_searchType']) &&
									($_REQUEST['case_searchType']=="0" )){ echo "selected=selected" ;}?>>Keyword
								</option>
								<option value="2" <?php if(isset($_REQUEST['case_searchType']) &&
									($_REQUEST['case_searchType']=="2" )){ echo "selected=selected" ;}?>>VIL Citation
									No.</option>
							</select>
						</div>
					</div>

					<div class="form-group" id="keyword">
						<label id="searchTypeLabel">Keyword</label>
						<div class="form-group">
							<input type="text" id="key"
								value="<?php if(isset($_REQUEST['case_keyword']) && (!empty($_REQUEST['case_keyword']))){ echo $_REQUEST['case_keyword'];}?>"
								placeholder="Keyword" name="case_keyword" class="form-control">
						</div>
					</div>

					<div class="form-group" id="party_name" style="display: none;">
						<label id="searchTypeLabel">Party Name</label>
						<div class="form-group">
							<input type="text" id="party"
								value="<?php if(isset($_REQUEST['party_name']) && (!empty($_REQUEST['party_name']))){ echo $_REQUEST['party_name'];}?>"
								placeholder="Party Name" name="party_name" class="form-control">
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
									<option <?php if(isset($_REQUEST['year']) && ($_REQUEST['year']==$i)){
										echo "selected=selected" ;}?>>
										<?php echo $i; ?>
									</option>
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
								<input type="text" class="form-control" id="vol" placeholder="Volumn" name="vol"
									value="<?php if(isset($_REQUEST['vol']) && (!empty($_REQUEST['vol']))){ echo $_REQUEST['vol'];}?>" />
							</div>
						</div>
						<div class="col-md-1 text-center  col-xs-2">
							-
						</div>
						<div class="col-md-2  col-xs-4">
							<div class="form-group">
								<input type="text" class="form-control" id="Cit_text" placeholder="" name="Citation"
									value="<?php if(isset($_REQUEST['Citation']) && (!empty($_REQUEST['Citation']))){ echo $_REQUEST['Citation'];}?>" />
							</div>
						</div>
					</div>
					<div class="form-group" id="noti_year_range" style="display: block;">
						<label id="searchTypeLabel">Year Range</label> 
						<input style ='border: 1px solid #ccc;' type="date" id="yearFrom" placeholder="Notification Date" name="yearFrom" value="<?php echo isset($_REQUEST['yearFrom']) ? htmlspecialchars($_REQUEST['yearFrom']) : 'DD/MM/YYY'; ?>" />
						<input style ='border: 1px solid #ccc;' type="date" id="yearTo" placeholder="" name="yearTo" value="<?php echo isset($_REQUEST['yearTo']) ? htmlspecialchars($_REQUEST['yearTo']) : 'DD/MM/YYY'; ?>" />
						<input type="button" name="resetDates" onclick="resetYearField()" value="Reset" class="btn" />
				 	</div>
					<div class="form-group text-center">
						<input type="submit" name="searchButton" id="search_case_btn" value="Search" class="btn" />
					</div>
					<script>
						function resetYearField() {
							event.preventDefault(); 
							document.getElementById("yearFrom").value = "";
							document.getElementById("yearTo").value = "";
						}
					</script>
				</form>
			</div>

			<!-- Notification/circular Search Form -->
			<div id="notification_section" style="display: none">
				<form name="form2" method="get" class="form padding-b-15 " id="cir_form" action="quick_search.php">
					<input type="hidden" name="pagename" value="Notification">
					<input type="hidden" name="function_name" value="Notification">
					<div class="form-group">
						<label>Select Category </label>
						<div class="form-group">
							<select name="notification_prod_id" id="not_prod_id" class="form-control">
								<option value="0" <?php if(isset($_REQUEST['notification_prod_id']) &&
									($_REQUEST['notification_prod_id']=="0" )){ echo "selected=selected" ;}?>
									data-dbsuffix="0">Select</option>
								<option value="10" <?php if(isset($_REQUEST['notification_prod_id']) &&
									($_REQUEST['notification_prod_id']=="10" )){ echo "selected=selected" ;}?>
									data-dbsuffix="cgst">CGST</option>
								<option value="9" <?php if(isset($_REQUEST['notification_prod_id']) &&
									($_REQUEST['notification_prod_id']=="9" )){ echo "selected=selected" ;}?>
									data-dbsuffix="igst">IGST</option>
								<option value="7" <?php if(isset($_REQUEST['notification_prod_id']) &&
									($_REQUEST['notification_prod_id']=="7" )){ echo "selected=selected" ;}?>
									data-dbsuffix="sgst">SGST</option>
								<option value="1" <?php if(isset($_REQUEST['notification_prod_id']) &&
									($_REQUEST['notification_prod_id']=="1" )){ echo "selected=selected" ;}?>
									data-dbsuffix="vat">VAT</option>
								<option value="2" <?php if(isset($_REQUEST['notification_prod_id']) &&
									($_REQUEST['notification_prod_id']=="2" )){ echo "selected=selected" ;}?>
									data-dbsuffix="st">Service Tax</option>
								<option value="4" <?php if(isset($_REQUEST['notification_prod_id']) &&
									($_REQUEST['notification_prod_id']=="4" )){ echo "selected=selected" ;}?>
									data-dbsuffix="ce">Central Excise</option>
								<option value="5" <?php if(isset($_REQUEST['notification_prod_id']) &&
									($_REQUEST['notification_prod_id']=="5" )){ echo "selected=selected" ;}?>
									data-dbsuffix="cu">Customs</option>
								<option value="6" <?php if(isset($_REQUEST['notification_prod_id']) &&
									($_REQUEST['notification_prod_id']=="6" )){ echo "selected=selected" ;}?>
									data-dbsuffix="dgft">DGFT</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label>Select Forum </label>
						<div class="form-group">
							<select name="court" id="noti_forum" class="form-control">
								<option value="0" <?php if (isset($_REQUEST['court']) && ($_REQUEST['court']=="0" )) {
									echo "selected=selected" ; } ?>data-dbsuffix="0">Select</option>
								<option value="SC" <?php if (isset($_REQUEST['court']) && ($_REQUEST['court']=="SC" )) {
									echo "selected=selected" ; } ?>data-dbsuffix="0">Supreme Court</option>
								<option value="HC" <?php if (isset($_REQUEST['court']) && ($_REQUEST['court']=="HC" )) {
									echo "selected=selected" ; } ?>data-dbsuffix="0">High Court</option>
								<option value="TRI" <?php if (isset($_REQUEST['court']) && ($_REQUEST['court']=="TRI" )) {
									echo "selected=selected" ; } ?>data-dbsuffix="0">CESTAT Cases</option>
								<option value="AAR" <?php if (isset($_REQUEST['court']) && ($_REQUEST['court']=="AAR" )) {
									echo "selected=selected" ; } ?>data-dbsuffix="0">AAR</option>
								<option value="NAA" <?php if (isset($_REQUEST['court']) && ($_REQUEST['court']=="NAA" )) {
									echo "selected=selected" ; } ?>data-dbsuffix="0">NAA</option>
								<option value="AAAR" <?php if (isset($_REQUEST['court']) && ($_REQUEST['court']=="AAAR" )) {
									echo "selected=selected" ; } ?>data-dbsuffix="0">AAAR</option>
							</select>
						</div>
					</div>

					<div class="form-group" id="state" style="display: none;">
						<label>state</label>
						<div class="form-group">
							<?php if(isset($_REQUEST['state_id'])){echo getStatDropdown($_REQUEST['state_id'],'state_id');}else{echo getStatDropdown('','state_id');}?>
						</div>
					</div>

					<div class="form-group">
						<label>Select Type</label>
						<div class="form-group">
							<select name="notification_searchType" id="searchType1" class="form-control">
								<option value="0" <?php if(isset($_REQUEST['notification_searchType']) &&
									($_REQUEST['notification_searchType']=="0" )){ echo "selected=selected" ;}?>>Keyword
								</option>
								<option value="1" <?php if(isset($_REQUEST['notification_searchType']) &&
									($_REQUEST['notification_searchType']=="1" )){ echo "selected=selected" ;}?>
									>Notification/Circular No.</option>
							</select>
						</div>
					</div>

					<div class="form-group" id="noti_keyword">
						<label id="searchTypeLabel">Keyword</label>
						<div class="form-group">
							<input type="text" id="not_key" placeholder="Keyword" name="notification_keyword"
								value="<?php if(isset($_REQUEST['notification_keyword']) && (!empty($_REQUEST['notification_keyword']))){ echo $_REQUEST['notification_keyword'];}?>"
								class="form-control">
						</div>
					</div>

					<div class="form-group" id="noti_cir_no" style="display: none;">
						<label id="searchTypeLabel">Notification/Circular No.</label>
						<div class="form-group">
							<input type="text" id="noti_cir" placeholder="Notification/Circular No." name="noti_cir"
								value="<?php if(isset($_REQUEST['noti_cir']) && (!empty($_REQUEST['noti_cir']))){ echo $_REQUEST['noti_cir'];}?>"
								class="form-control">
						</div>
					</div>
					<div class="form-group" id="noti_year_range" style="display: block;">
						<label id="searchTypeLabel">Date Range</label> 
						<input style ='border: 1px solid #ccc;' type="date" id="noti_yearFrom" placeholder="Notification Date" name="yearFrom" value="<?php if (isset($_REQUEST['yearFrom']) && (!empty($_REQUEST['yearFrom']))) { echo $_REQUEST['yearFrom']; } ?>" />
						<input style ='border: 1px solid #ccc;' type="date" id="noti_yearTo" placeholder="" name="yearTo" value="<?php if (isset($_REQUEST['yearTo']) && (!empty($_REQUEST['yearTo']))) { echo $_REQUEST['yearTo']; } ?>" />
						<input type="button" name="resetDates" onclick="resetYearFields()" value="Reset" class="btn" />
				 	</div>

					<div class="form-group text-center">
						<input type="submit" name="searchButton" id="search_case_btn" value="Search" class="btn" />
					</div>
					<script>
						function resetYearFields() {
							event.preventDefault(); 
							document.getElementById("noti_yearFrom").value = "";
							document.getElementById("noti_yearTo").value = "";
						}
					</script>

				</form>
			</div>

		</div>

	</div>
	<div class='clear'></div>

	<div class="col-md-16">
		<?php 

			$rec_count = $count;
			$rec_limit = 19;
			$from=$startFrom+1;
			$to=$from+$tocount-1;

            
            function getNewPageUrl($queryParam, $paramValue){
				global $getBaseUrl;
                $oldUrl = $_SERVER['REQUEST_URI'];
                //removePageOption from existing url
                $urlPrased = parse_url($oldUrl);
                // echo $oldUrl;
                // if($_GET['filterBy']=='Harshal'){
                //     echo $oldUrl;
                //     echo "<br>";
                //     print_r($urlPrased);
                //     parse_str($urlPrased['query'], $queries); 
                //     print_r($queries);die;
                // }
                
                parse_str($urlPrased['query'], $queries); 
                $newParamArray = array();
                foreach($queries as $q_param => $param_v){
                    if($q_param != $queryParam){
                        $newParamArray[$q_param] = $param_v;
                    }
                }
                $newParamArray[$queryParam] = $paramValue;
                
                //building url = 
                $newUrl = $getBaseUrl . "/quick_search.php?";
                
                foreach($newParamArray as $q_p=>$p_v){
                    $newUrl .= "&".  $q_p . "=". $p_v;
                }
                
                return $newUrl;
            }


			if(isLogeedIn()) {
				if($_SESSION["userStatus"]=="expired") {
					include('expiredUserError.php'); 
				} else {
				    if($_SESSION["type"]!="T")
               		{
					if(mysqli_num_rows($res1)>0){
					echo "<div class='new-pagination'>";
						echo "<a ";  
					 	echo "href='#.' style='color:black;'>Showing $from to $to of <b>$rec_count Records</b></a>";
					echo "</div><div class='clear'></div>";
					?>
		<nav class="navigation pagination pagination1 fontNeuron" role="navigation">
			<ul class="pagination">
				<?php
			    			//if($currentPage != $firstPage) {
			    		?>
				<li class="page-item active">
					<a class="page-link" href="<?php echo getNewPageUrl('page',$firstPage);?>" tabindex="-1"
						aria-label="Previous">
						<span aria-hidden="true">First</span>
					</a>
				</li>
				<!-- <li class="page-item">
			    				<a class="page-link" href="?q=<?php echo $text;?>&&page=<?php echo $currentPage-1 ?>" tabindex="-1" aria-label="Previous">
			          				<span aria-hidden="true">Previous</span>
			          			</a>		
			    			</li> -->
				<?php
			    			//}
			    			if($currentPage >= 2 && $previousPage!=1){
			    		?>
				<li class="page-item">
					<a class="page-numbers" href="<?php echo getNewPageUrl('page',$previousPage);?>">
						<?php echo $previousPage ?>
					</a>
				</li>
				<?php		
			    			}
			    			$c_page=$currentPage;
			    			for($i=1;$i<=10;$i++)
			    			{
			    				
			    				if($c_page<=$lastPage)
			    				{
			    					if($c_page==1){
			    						$c_page++;
			    					}else{	
			    		?>
				<li class="page-item <?php if($c_page==$currentPage){echo " active";}?>">
					<a class="page-numbers" href="<?php echo getNewPageUrl('page',$c_page);?>">
						<?php echo $c_page++;?>
					</a>
				</li>
				<?php		
			    					}
			    				}
			    			} 
			    		?>
				<li class="page-item">
					<a class="page-numbers" href="<?php echo getNewPageUrl('page',$lastPage);?>" aria-label="Next">
						<span aria-hidden="true">Last</span>
					</a>
				</li>
			</ul>
		</nav>
		<?php
					if($_REQUEST['pagename']=="Articles" || $_REQUEST['pagename']=="News"){
						
						while ($row=mysqli_fetch_array($res1)) {
							$encryptID = base64_encode(base64_encode($row['id']));
							$file_path = $row['file_path'];
                            $linkToShow = $getBaseUrl . $file_path;
                            $rowtemp['perm_link'] = "showiframe?V1Zaa1VsQlJQVDA9=$encryptID&page=$dbsuffix";
	                      	$author = '';
	                      	if($_REQUEST['pagename'] == 'Articles') { $author = ' | '.$row['author']; }
	                      	    echo "<div class='widget-box'>
                                          <h4>
                                            <strong style='color: #ea0081;'>
                                                &nbsp; " . $row['subject'] . " &nbsp; <a class='preview' href='" . $getBaseUrl . $rowtemp['perm_link'] . "' perm-link='$linkToShow' title='Preview' ><i class='fa fa-eye'></i></a> &nbsp;<a class='new' href='" . $getBaseUrl . $rowtemp['perm_link'] . "' target='_blank' title='Open In New Tab'><i class='fa fa-share-square-o'></i></a> <span>" . $row['Date'] . "" . $author . "</span>
                                            </strong>
                                          </h4>
                                      <div class='widget-content'>";
		                     	// echo "<div class='widget-box'>
		                      //        <h4><a href='javascript:void(0)' onclick='showFrame(\"$encryptID\",\"$dbsuffix\")'>".$row['subject']."</a> <span>".$row['Date']."".$author."</span></h4>
		                      //        <div class='widget-content'>";
		                              $subject=cleanname(stripslashes($row['summary']));
									  $subjectLength = strlen(stripslashes($row['summary']));
									  if(!$text){
										if($subjectLength > 650) {
			        						echo "<p>".substr($subject,0,650)."... <a href='javascript:void(0)' style='text-decoration:underline;color: #ff7808;' class='readMoreSubject'>[Read more]</a></p>";
			        						echo "<p style='display:none'>".$subject."</p>";
					        			} else {
						    	    		echo "<p>".$subject."</p>";
										} 
									  }else{
										if($subjectLength > 650) {
			        						echo "<p>".preg_replace("/($text)/i", "<mark>$1</mark>", substr($subject,0,650))."... <a href='javascript:void(0)' style='text-decoration:underline;color: #ff7808;' class='readMoreSubject'>[Read more]</a></p>";
			        						echo "<p style='display:none'>".$subject."</p>";
					        			} else {

						    	    		echo "<p>".$subject."</p>";
								
										} 	
									}
		                      	
		                      	echo "  <div class='widget-actions'><a href='javascript:void(0)' onclick='showFrame(\"$encryptID\",\"$dbsuffix\")' class='ion-android-archive' title='Click here to download the file'></a></div>";
		                      	echo "  </div> 
		                          </div>";
							}
					}
					else
					{
						while($row = mysqli_fetch_array($res1))
						{
							
							//echo $row['cir_subject']; die();
							$file_path = $row['file_path'];
							$file_extn = strtolower(substr($file_path,-3));
							$CatgoryClass = preg_replace('/\s+/', '', $row['prod_name'])."section";
							$encryptID = base64_encode(base64_encode($row['data_id']));
							$dataType=$row['dbsuffix'];
							
							$circular_no = $row['circular_no'] ? $row['circular_no'] : $row['cir_subject'];

					//		echo $file_extn;

						    echo "<div class='widget-box  $CatgoryClass'><h4>";
				// 		    if(empty($file_path)){
				// 		    	echo getEmptyCircularLink($encryptID, $dataType, $circular_no);
				// 		    	//echo "hello";
				// 		    }else{
				// 		    	//echo "hello";
				// 				echo getCircularLink($encryptID, $dataType, $circular_no);
				// 			}	
                            if (empty($file_path)) {
                                echo getEmptyCircularLink2($encryptID, $dataType, $circular_no);            
                            } else {
                                $link = "showiframe?V1Zaa1VsQlJQVDA9=$encryptID&datatable=$dataType";
                                echo getCircularLink2($encryptID, $dataType, $circular_no, $file_path);
                                echo "&nbsp;<strong style='color: #ea0081;'><a class='new' href='" . $link . "' target='_blank' title='Open In New Tab'><i class='fa fa-share-square-o'></i></a></strong>";
                            }
							
								echo "<span style='color:#ff7808'>{$row['sub_prod_name']} </span>   <span>&nbsp; | &nbsp;</span>";
								echo "<span style='color:#58a9da'>{$row['prod_name']} </span>    ";
					       		 if(isset($row['State']) != '') {

									echo " <span>&nbsp; | &nbsp;</span><span>{$row['state_name']} </span>   ";
					       		 }
					       		echo "<span>{$row['Date']} | &nbsp;</span>";
								echo "</h4>";

							
							if(!empty($row['party_name'])) {
								echo "<h4>";
								echo "<strong style='color:#cf4192; font-size: 13px;'>".$row['party_name']."</strong>";
								echo "</h4>";
					       	}
							
					        			
				        	echo getDownloadIcon($encryptID, $dataType);	
				        //	$searchKeyword = preg_replace("/\s+/i", "|", rtrim($searchKeyword));
						//echo "<strong style='float: right; margin-right: 10px; margin-top: 0px;'>{$row['Date']}</strong>";
					        echo "<div class='clear'></div>";
					        //echo $text;
							$subject = cleanname($row['cir_subject']);
							//echo $subject; die();
							$subjectLength = strlen($row['cir_subject']);
							if(!$text){
								if($subjectLength > 650) {
			        				echo "<p>".substr($subject,0,650)."... <a href='javascript:void(0)' style='text-decoration:underline;color: #ff7808;' class='readMoreSubject'>[Read more]</a></p>";
			        				echo "<p style='display:none'>".$subject."</p>";
					        	} else {
						    	    echo "<p>".$subject."</p>";
								} 
							}else{
								if($subjectLength > 650) {
			        				echo "<p>".preg_replace("`($text)`i", "<mark>$1</mark>", substr($subject,0,650))."... <a href='javascript:void(0)' style='text-decoration:underline';color: #ff7808; class='readMoreSubject'>[Read more]</a></p>";
			        				echo "<p style='display:none'>".$subject."</p>";
					        	} else {

						    	    echo "<p>".$subject."</p>";
								
								} 	
							}
					        		
						    echo "</div>";    
						}
					}?>

		<nav class="navigation pagination pagination1 fontNeuron" role="navigation">
			<ul class="pagination">
				<?php
			    			//if($currentPage != $firstPage) {
			    		?>
				<li class="page-item active">
					<a class="page-link" href="<?php echo getNewPageUrl('page',$firstPage);?>" tabindex="-1"
						aria-label="Previous">
						<span aria-hidden="true">First</span>
					</a>
				</li>
				<!-- <li class="page-item">
			    				<a class="page-link" href="?q=<?php echo $text;?>&&page=<?php echo $currentPage-1 ?>" tabindex="-1" aria-label="Previous">
			          				<span aria-hidden="true">Previous</span>
			          			</a>		
			    			</li> -->
				<?php
			    			//}
			    			if($currentPage >= 2 && $previousPage!=1){
			    		?>
				<li class="page-item">
					<a class="page-numbers" href="<?php echo getNewPageUrl('page',$previousPage);?>">
						<?php echo $previousPage ?>
					</a>
				</li>
				<?php		
			    			}
			    			$c_page=$currentPage;
			    			for($i=1;$i<=10;$i++)
			    			{
			    				
			    				if($c_page<=$lastPage)
			    				{
			    					if($c_page==1){
			    						$c_page++;
			    					}else{	
			    		?>
				<li class="page-item <?php if($c_page==$currentPage){echo " active";}?>">
					<a class="page-numbers" href="<?php echo getNewPageUrl('page',$c_page);?>">
						<?php echo $c_page++;?>
					</a>
				</li>
				<?php		
			    					}
			    				}
			    			} 
			    		?>
				<li class="page-item">
					<a class="page-numbers" href="<?php echo getNewPageUrl('page',$lastPage);?>" aria-label="Next">
						<span aria-hidden="true">Last</span>
					</a>
				</li>
			</ul>
		</nav>

		<?php
					}
					else
					{ 
						echo '<div class="alert alert-danger always-show" ><strong>No Records Found</strong> - Please try <a  href="advancesearch.php" data-effect="mfp-zoom-in">Advance Search</a> </div>';
						if ($_REQUEST['pagename'] == "Case Laws") { ?>
		<div class="alert alert-danger always-show">
			<h4>
				<strong style="color: #8d3400;">OR</strong>
				<p>Didnâ€™t find what you are searching for? No worries, please give us the following details and VIL
					will email you the desired Caselaws at the earliest:</p>
				<p>Please Click CRF Button</p>
				<strong><b><a href='#caselawForm' class='open-popup-link' data-effect="mfp-zoom-in"
							id='arrange'>CRF</a></b></strong>
			</h4>
		</div>
		<?php   }
					}
               		}else{
              		    include('tempUsererror.php');
            	    }
				}

					
			} 
			else 
			{
	  			include('loggedInError.php');
	  		}
	?>
		<?php 
        $isPDFLink = "isPdf=0";
        if ($file_extn == 'pdf') { 
            $isPDFLink =  "isPdf=1";
        }?>
		<div style="display: none;">
			<iframe onLoad="calcHeight();" <?php echo $isPDFLink ; ?> id='iFramePopupFrame' name='iFramePopupFrame'
				<?php
                if ($file_extn == 'pdf') {
                    ?> src='
				<?php echo $getBaseUrl . $file_path; ?>'
				<?php
                } else {
                    ?> src='
				<?php echo "-?ll=" . encrypt_url($getBaseUrl . $file_path); ?>'
				<?php
                }
                ?> frameborder='0' allowtransparency='true' scrolling='no' width="100%" >
			</iframe>
		</div>
	</div>
</div>

<!-- left sec end -->
<?php include('footer.php') ?>

<!-- Logout Modal-->
<div class="modal fade" id="recordInfoModal" tabindex="-1" role="dialog" aria-labelledby="recordInfoModal"
	aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<a class="btn btn-primary btn_open_new_window" target="_blank" href="">Open in New Window</a>
				<button class="close" type="button" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true"> X </span>
				</button>
			</div>
			<div class="modal-body" style='height:600px;'>
				<iframe id="iFramePreviewFrame" name="iFramePreviewFrame"
					src="-?l=ocq1xJlgYZ%2BjmJejoKjJtYPVmp6ap6llZpyayqKDooB7Ypedl6esnsigs8CjppyXoZuWa2e%2BtcE%3D"
					frameborder="0" allowtransparency="false" scrolling="yes" width="100%"></iframe>
			</div>
			<div class="modal-footer d-block float-left">
				<div class="pull-right text-right b-margin-10">
					<ul class="list-inline"></ul>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$("#advance_search").click(function () {
		$("#accordion").slideToggle();
		//$(".searchbody").toggle();
	});		
</script>
<script type="text/javascript">
	$("#refine_search").click(function () {
		$(".refine_search_body").slideToggle();
		//$(".searchbody").toggle();
	});		
</script>
<script type="text/javascript">
	var searchBody = function (data) {
		window.location = 'searchBody?search=' + data;
	}
</script>
<script>
	function reloadIt() {
		if (window.location.href.substr(-1) !== "&") {
			window.location = window.location.href + "&";
		}
	}
	setTimeout(function () { reloadIt() }, 500);
</script>

<script type="text/javascript">
	$(document).ready(function () {
		// //debugger;
		var section = "<?php echo $_REQUEST['pagename'];?>";
		var searchType = "<?php if(isset($_REQUEST['case_searchType'])){echo $_REQUEST['case_searchType'];}else{echo $_REQUEST['notification_searchType'];}?>";

		if (section == "Notification") {
			$("#q_case_law").removeClass("q_active");
			$("#q_cir").addClass("q_active");
			$("#case_law_section").css('display', 'none');
			$("#notification_section").css('display', 'block');
			$(".title").html('Notification');

			var prod_id = "<?php if(isset($_REQUEST['notification_prod_id'])){echo $_REQUEST['notification_prod_id'];}else{echo "";}?>";
			if (prod_id != '' && prod_id != '0') {
				if (prod_id == '7') {
					$("#state").css("display", "block");
				} else {
					$("#state").css("display", "none");
				}
			}

			if (searchType == "0") { //for keyword
				$("#noti_keyword").css("display", "block");
				$("#noti_cir_no").css("display", "none");

				$("#noti_cir").val("");

			} else if (searchType == "1") {// for party name 
				$("#noti_keyword").css("display", "none");
				$("#noti_cir_no").css("display", "block");

				$("#not_key").val("");
			}
		}

		if (section == "Case Laws") {
			$("#q_cir").removeClass("q_active");
			$("#q_case_law").addClass("q_active");
			$("#case_law_section").css('display', 'block');
			$("#notification_section").css('display', 'none');
			$(".title").html('Case Law');

			if (searchType == "0") { //for keyword
				$("#keyword").css("display", "block");
				$("#citation").css("display", "none");
				$("#party_name").css("display", "none");

				$("#party").val("");
				$("#year").find('option').prop("selected", false);
				$("#vol").val("");
				$("#Cit_text").val("");

			} else if (searchType == "1") {// for party name
				$("#keyword").css("display", "none");
				$("#citation").css("display", "none");
				$("#party_name").css("display", "block");

				$("#key").val("");
				$("#vol").val("");
				$("#Cit_text").val("");
				$("#year").find('option').prop("selected", false);
			} else {
				$("#keyword").css("display", "none");
				$("#citation").css("display", "block");
				$("#party_name").css("display", "none");

				$("#key").val("");
				$("#party").val("");
			}
		}

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

		$("#q_case_law").click(function () {
			$("#q_cir").removeClass("q_active");
			$("#q_case_law").addClass("q_active");
			$("#case_law_section").css('display', 'block');
			$("#notification_section").css('display', 'none');
			$(".title").html('Case Law');
			//document.getElementById("cir_form").reset();
		});

		$("#q_cir").click(function () {
			//debugger;
			$("#q_case_law").removeClass("q_active");
			$("#q_cir").addClass("q_active");
			$("#case_law_section").css('display', 'none');
			$("#notification_section").css('display', 'block');
			$(".title").html('Notification');
			//document.getElementById("case_form").reset();
		});

		// for case law
		$("#searchType").change(function () {
			//debugger;
			var value = $(this).val();
			if (value == "0") { //for keyword
				$("#keyword").css("display", "block");
				$("#citation").css("display", "none");
				$("#party_name").css("display", "none");

				$("#party").val("");
				$("#year").find('option').prop("selected", false);
				$("#vol").val("");
				$("#Cit_text").val("");

			} else if (value == "1") {// for party name
				$("#keyword").css("display", "none");
				$("#citation").css("display", "none");
				$("#party_name").css("display", "block");

				$("#key").val("");
				$("#vol").val("");
				$("#Cit_text").val("");
				$("#year").find('option').prop("selected", false);
			} else {
				$("#keyword").css("display", "none");
				$("#citation").css("display", "block");
				$("#party_name").css("display", "none");

				$("#key").val("");
				$("#party").val("");
			}
		});


		// for notification/circular
		$("#searchType1").change(function () {
			//debugger;
			var value = $(this).val();
			if (value == "0") { //for keyword
				$("#noti_keyword").css("display", "block");
				$("#noti_cir_no").css("display", "none");

				$("#noti_cir").val("");

			} else if (value == "1") {// for party name 
				$("#noti_keyword").css("display", "none");
				$("#noti_cir_no").css("display", "block");

				$("#not_key").val("");
			}
		});


		$("#not_prod_id").change(function () {
			//debugger;
			var val = $(this).val();

			if (val == '7') {
				$("#state").css("display", "block");
			} else {
				$("#state").css("display", "none");
			}
		});

	});

</script>
<script type="text/javascript">
	//  var copyLinkToClipboard = function() {
	// //debugger;
	// var copyEmailBtn = $('.copy-file-link');  

	$('.copy-file-link').on('click', function (event) {
		//debugger;
		// Select the email link anchor text 
		$(".clip").css('display', 'block');
		var emailLink = this.previousElementSibling;

		var range = document.createRange();
		range.selectNode(emailLink);
		window.getSelection().addRange(range);

		try {
			// Now that we've selected the anchor text, execute the copy command  
			var successful = document.execCommand('copy');
			var msg = successful ? 'successful' : 'unsuccessful';
			// console.log('Copy email command was ' + msg);  
		} catch (err) {
			console.log('Oops, unable to copy');
		}
		$(".clip").css('display', 'none');
		// Remove the selections - NOTE: Should use
		// removeRange(range) when it is supported  
		window.getSelection().removeAllRanges();

	});
	//}

	$('.widget-box .preview').click(function (e) {

		e.preventDefault();
		e.stopPropagation();
		e.stopImmediatePropagation();
		var linktoopen = $(this).attr('perm-link');
		var linktoOpenNew = $(this).attr('href');
		//console.log(linktoOpenNew);
		$('.btn_open_new_window').attr('href', linktoOpenNew);

		$('#iFramePreviewFrame').attr('src', linktoopen);
		var the_height2 = document.getElementById('iFramePreviewFrame').contentWindow.document.body.scrollHeight + 50;
		$('#iFramePreviewFrame').height('580px');
		//            iFramePreviewFrame
		$('#recordInfoModal').modal('show');
	});
</script>