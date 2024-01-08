<?php
	$page = '';
	
	include('header.php');  

	//echo $_SERVER['REQUEST_URI'];
	//print_r($_SESSION);

		// function wordval($text)
		// {
		// 	$value=trim(preg_replace('/[^A-Za-z0-9]/', ' ', $text)); // Removes special chars.
		// 	$value1=explode(' ',$value);
		// 	return implode('%%',$value1); 
		// }
		function clean($string){
	   		return preg_replace('/[^A-Za-z0-9\& ]/', '', $string); // Removes special chars.
		}

		function shortForm($text)
		{
			$replace=array();
			$rep_data=array();
			if(!empty($text))
			{
				$value=explode(' ', $text);
				foreach ($value as $k=>$v) {
					$result = mysqli_query($GLOBALS['con'],"SELECT * FROM `short_form` WHERE `short_form` LIKE '$v'") or die(mysql_error());	
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

		function tableUnion($conditions,$table,$ids,$sub_prod_name){
			//$table=array("casedata_ce","casedata_cu","casedata_gst","casedata_st","casedata_vat");
			//print_r($sub_prod_name); die();
			if(!empty($conditions)){
				$value=" WHERE " . implode(' AND ', $conditions);
			}else{
				$value="";
			}
			$count=0;
			foreach ($table as $tbl) {
				$qry = mysqli_query($GLOBALS['con'],"SELECT p.prod_id,p.dbsuffix,sp.sub_prod_id FROM product as p LEFT JOIN sub_product as sp ON p.prod_id=sp.prod_id WHERE p.prod_id= '".$ids[$count]."'".$sub_prod_name) or die(mysql_error());
				$where=[];

				if(mysqli_num_rows($qry)>0)
				{
					while ($data = mysqli_fetch_array($qry, MYSQL_ASSOC)) {	
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
		  		while($rows = mysqli_fetch_array($query, MYSQL_ASSOC)){
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

		if(isset($_REQUEST['searchButton'])) 
		{
			//print_r($_REQUEST); 
			$seoTitle = $_REQUEST['pagename'].'- Advanced Search';
			$seoKeywords = $_REQUEST['pagename'].'- Advanced Search';
			$seoDesc = $_REQUEST['pagename'].'- Advanced Search';
			if($_REQUEST['pagename']=='Acts and Rules')
	    	{
				$text=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['keyword']);
	    		function act(){
	    			//print_r($_REQUEST); die();
	    			$conditions = array();
	    			// for keyword
					if($_REQUEST['keyword']!="")
					{
						$keyword=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['keyword']);
						$string=trim(clean($keyword));
						$rep_data=shortForm($string);
						
						$conditions[] = "((a.cir_subject LIKE '%".$string."%' OR a.file_data LIKE '%".$string."%' OR a.party_name LIKE '%".$string."%') OR(a.cir_subject LIKE '%".$rep_data[0]."%' OR a.file_data LIKE '%".$rep_data[0]."%' OR a.party_name LIKE '%".$rep_data[0]."%')) ";
					}

					// for section and rule number
					if($_REQUEST['type']=="Acts"){
						if(!empty($_REQUEST['section_no'])){
				    		$conditions[]="a.section_no LIKE = '".$_REQUEST['section_no']."'";
				    	}
				    }else{
						if(!empty($_REQUEST['rule_no'])){
				    		$conditions[]="a.rule_no LIKE = '".$_REQUEST['rule_no']."'";
				    	}
					}

					// for category
					if($_REQUEST['prod_id']!=0)
					{

						$result = mysqli_query($GLOBALS['con'],"SELECT p.prod_id,p.dbsuffix,sp.sub_prod_id FROM product as p LEFT JOIN sub_product as sp ON p.prod_id=sp.prod_id WHERE p.prod_id= '".$_REQUEST['prod_id']."' AND (sp.sub_prod_type LIKE 'Acts') AND sp.sub_prod_name LIKE '%".$_REQUEST['type']."%'") or die(mysql_error());
						$sub_prod=[];
						if(mysqli_num_rows($result)>0)
						{
							while ($data = mysqli_fetch_array($result)) {	
								$sub_prod[]="a.sub_prod_id = '".$data['sub_prod_id']."'";
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
						$sql=$query."WHERE ".implode(' AND ', $conditions).$where_subprod;
					}
					else
					{
						$id=['5','6','7','8','9','10'];
						$table=array("casedata_cu","casedata_dgft","casedata_sgst","casedata_utgst","casedata_igst","casedata_cgst");
						$sub_prod_name="AND (sp.sub_prod_type LIKE 'Acts') AND sp.sub_prod_name LIKE '%".$_REQUEST['type']."%'";
						$sql=implode(" UNION ",(tableUnion($conditions,$table,$id,$sub_prod_name)));

					}
					return $sql;
				}
			
			} 

			if($_REQUEST['pagename']=='Notification')
		    {
				$text=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['keyword']);
		      	function notification(){
					$conditions = array();

					// for keyword
					if($_REQUEST['keyword']!="")
					{
						$keyword=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['keyword']);
						$string=trim(clean($keyword));
						$rep_data=shortForm($string);
						
						$conditions[] = "((a.cir_subject LIKE '%".$string."%' OR a.file_data LIKE '%".$string."%' OR a.party_name LIKE '%".$string."%') OR(a.cir_subject LIKE '%".$rep_data[0]."%' OR a.file_data LIKE '%".$rep_data[0]."%' OR a.party_name LIKE '%".$rep_data[0]."%')) ";
					}

					// for notification number
					if($_REQUEST['noti_no']!='')
					{	
						$not_no=trim(mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['noti_no']));
						$conditions[]="a.circular_no LIKE '%".$not_no."%'";
					}

					// for Date
					if($_REQUEST['date']!="")
					{
						$date=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['date']);
						$conditions[] = "a.circular_date LIKE '$date%'";
					}

					// for Date Range
					if($_REQUEST['dt_from']!="" || $_REQUEST['dt_to']!="" )
					{
						$fromDate=$_REQUEST['dt_from'];
						$toDate=$_REQUEST['dt_to'];
				    	if($_REQUEST['dt_from']==""){
				    		$fromDate='1942-01-01';
				    	}
				    	if($_REQUEST['dt_to']==""){
				    		$toDate=date('Y-m-d');
				    	}
				      $conditions[] = "(a.circular_date BETWEEN '$fromDate%' AND '$toDate%')";
				    }

					// for category
					if($_REQUEST['prod_id']!=0)
					{
						$result = mysqli_query($GLOBALS['con'],"SELECT prod_id,dbsuffix FROM product WHERE prod_id= '".$_REQUEST['prod_id']."'") or die(mysql_error());
							$data = mysqli_fetch_array($result);
							$data_db=$data['dbsuffix'];

						// For  State
						if($_REQUEST['prod_id']=='7' && $_REQUEST['state_id']!='0')
						{
							$conditions[] = "a.state_id = '".$_REQUEST['state_id']."'";
						}

						// for sub product id
						if($_REQUEST['sub_product_id']!='0')
						{
							if(isset($_REQUEST['type']) && $_REQUEST['type']!='0')
							{
								$conditions[]="a.sub_subprod_id = '".$_REQUEST['type']."'"; //sub product type
							}
							if(!empty($conditions)){
								$where_subprod="AND a.sub_prod_id = '".$_REQUEST['sub_product_id']."'"; //sub product id
							}else{
								$where_subprod="a.sub_prod_id = '".$_REQUEST['sub_product_id']."'"; //sub product id
							}
						}
						else
						{
							$result = mysqli_query($GLOBALS['con'],"SELECT p.prod_id,p.dbsuffix,sp.sub_prod_id FROM product as p LEFT JOIN sub_product as sp ON p.prod_id=sp.prod_id WHERE p.prod_id= '".$_REQUEST['prod_id']."' AND (sp.sub_prod_name='Circular' OR sp.sub_prod_name='Notification')") or die(mysql_error());
							$sub_prod=[];
							if(mysqli_num_rows($result)>0)
							{
								while ($data = mysqli_fetch_array($result)) {	
									$sub_prod[]="a.sub_prod_id = '".$data['sub_prod_id']."'";
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
						}
						
						$query="SELECT a.*,DATE_FORMAT(circular_date,GET_FORMAT(DATE,'EUR'))'Date',p.prod_name,p.dbsuffix,sp.sub_prod_name,sm.state_name FROM casedata_".$data_db." as a LEFT JOIN product as p ON a.prod_id=p.prod_id LEFT JOIN sub_product as sp ON a.sub_prod_id=sp.sub_prod_id LEFT JOIN state_master as sm ON a.state_id=sm.state_id ";
						return $sql=$query."WHERE ".implode(' AND ', $conditions).$where_subprod;
					}
					else
					{
						$id=['1','2','4','5','6','7','9','10'];
						$table=array("casedata_vat","casedata_st","casedata_ce","casedata_cu","casedata_dgft","casedata_sgst","casedata_igst","casedata_cgst");
						$sub_prod_name="AND (sp.sub_prod_name='Circular' OR sp.sub_prod_name='Notification')";
						return $sql=implode(" UNION ",(tableUnion($conditions,$table,$id,$sub_prod_name)));

					}
				}
			}

			if($_REQUEST['pagename']=='Articles'){
				//print_r($_REQUEST); die();
				$prod_id=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['prod_id']);
				$text=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['text']);
				$topic=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['topic']);
				$fromDate=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['fromDate']);
				$toDate=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['toDate']);
				$dbsuffix=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['dbsuffix']);
				$author=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['author']);

				function articles(){
			     	$prod_id=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['prod_id']);
					$text=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['text']);
					$topic=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['topic']);
					$fromDate=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['fromDate']);
					$toDate=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['toDate']);
					$dbsuffix=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['dbsuffix']);
					$author=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['author']);

					$query = "SELECT *,article_id 'id',DATE_FORMAT( article_date, GET_FORMAT( DATE, 'EUR' ) )  'Date' FROM $dbsuffix";
		     		$conditions = array();
				    if($author!='0') {
				      $conditions[]= "author='$author'";
				    }
				    if($prod_id!='0') {
				      $conditions[]= "category='$prod_id'";
				    }
				    if(! empty($text)) {
				    	$rep_data=shortForm($text,'','');
				      	$conditions[] = "(summary LIKE '%".$text."%' OR summary LIKE '%".$rep_data[0]."%') ";
				    }
				    if(! empty($topic)) {
				    	$rep_data=shortForm($topic,'','');
				      	$conditions[] = "(summary LIKE '%".$topic."%' OR summary LIKE '%".$rep_data[0]."%')";
				    }
				    if(! empty($fromDate) || ! empty($toDate)) {
				    	if(empty($fromDate)){
				    		$fromDate='2015-01-01';
				    	}
				    	if(empty($toDate)){
				    		$toDate=date('Y-m-d');
				    	}
				      $conditions[] = "(article_date BETWEEN '$fromDate%' AND '$toDate%')";
				    }
				    $sql = $query;
				    $query2= " ORDER BY article_id DESC";
				    //print_r($conditions);
				    if (count($conditions) > 0) {
				      return $sql .= " WHERE " . implode(' AND ', $conditions).$query2;
				    }else{
				    	return $sql.=$query2;
				    }
				}
			}

			if($_REQUEST['pagename']=='News'){
				//print_r($_REQUEST);
				
				$text=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['text']);
				$filter_text=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['filter_text']);
				$dbsuffix=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['dbsuffix']);

				function news(){
					$text=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['text']);
					$filter_text=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['filter_text']);
					$dbsuffix=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['dbsuffix']);

					$query = "SELECT *,feature_id 'id',DATE_FORMAT( feature_date, GET_FORMAT( DATE, 'EUR' ) )  'Date' FROM ";
		     		
		     		//$conditions[] ="a.sub_prod_id = '".$result['sub_prod_id']."'";
		     		$conditions=array();
				    if(!empty($text) && !empty($filter_text)) {
				    	$conditions[] = "(SELECT *,feature_id 'id',DATE_FORMAT( feature_date, GET_FORMAT( DATE, 'EUR' ) )  'Date' FROM $dbsuffix WHERE `subject` LIKE '%".$text."%' AND `summary` LIKE '%".$text."%') as a WHERE a.`subject` LIKE '%".$filter_text."%' AND a.`summary` LIKE '%".$filter_text."%'";
				    }
				    else if(!empty($text)){
				    	$rep_data=shortForm($text,'','');
				    	$conditions[] = "$dbsuffix WHERE (`subject` LIKE '%".$text."%' AND `summary` LIKE '%".$text."%') OR(`subject` LIKE '%".$rep_data[0]."%' AND `summary` LIKE '%".$rep_data[0]."%')";
				    }
				    else if(!empty($filter_text)){
				    	$rep_data=shortForm($text,'','');
				    	$conditions[] = "$dbsuffix WHERE (`subject` LIKE '%".$filter_text."%' AND `summary` LIKE '%".$filter_text."%') OR (`subject` LIKE '%".$rep_data[0]."%' AND `summary` LIKE '%".$rep_data[0]."%')";
				    }
				    
				    $sql = $query;
				    $query2= " ORDER BY a.data_id DESC";
				    //print_r($conditions);
				    if (count($conditions) > 0) {
				      return $sql .= implode(' AND ', $conditions).$query2;
				    }else{
				    	return $sql.=$dbsuffix.$query2;
				    }
				}
			}


			if($_REQUEST['pagename']=='Case Laws')
			{
				//print_r($_REQUEST); die();
				$text=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['Keyword']);
				function case_data()
				{
					// $orderby="order by CAST(SUBSTR(circular_no,1) AS SIGNED) DESC";  
					$orderby="ORDER BY substring_index(`circular_no`,'-',3) DESC";  
					$conditions = array();

					// for keyword
					if($_REQUEST['Keyword']!="")
					{
						$keyword=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['Keyword']);
						$string=trim(clean($keyword));
						$rep_data=shortForm($string);
						if($_REQUEST['search_in']==1) //search in summary
						{
							$conditions[] ="(a.cir_subject LIKE '%".$string."%' OR a.cir_subject LIKE '%".$rep_data[0]."%')";
						}
						else if($_REQUEST['search_in']==2) //search in file data
						{
							$conditions[] ="(a.file_data LIKE '%".$string."%' OR a.file_data LIKE '%".$rep_data[0]."%')";
						}
						else
						{
							$conditions[] ="(a.cir_subject LIKE '%".$string."%' OR a.cir_subject LIKE '%".$rep_data[0]."%' OR a.file_data LIKE '%".$string."%' OR a.file_data LIKE '%".$rep_data[0]."%')";
						}

					}

					// for Party name
					if($_REQUEST['party_name']!="")
					{
						$party_name=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['party_name']);
						$string=trim($party_name);
						$rep_data=shortForm($string);

						$conditions[] ="(a.party_name LIKE '%".$string."%' OR a.party_name LIKE '%".$rep_data[0]."%')";
					}

					// for Date
					if($_REQUEST['date']!="")
					{
						$date=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['date']);
						$conditions[] = "a.circular_date LIKE '$date%'";
					}

					// for Date Range
					if($_REQUEST['dt_from']!="" || $_REQUEST['dt_to']!="" )
					{
						$fromDate=$_REQUEST['dt_from'];
						$toDate=$_REQUEST['dt_to'];
				    	if($_REQUEST['dt_from']==""){
				    		$fromDate='1942-01-01';
				    	}
				    	if($_REQUEST['dt_to']==""){
				    		$toDate=date('Y-m-d');
				    	}
				      $conditions[] = "(a.circular_date BETWEEN '$fromDate%' AND '$toDate%')";
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
				    	$conditions[]="a.circular_no = '%$c_no%'";
				    }elseif (!empty($year)) {
				    	$c_no=$year."-VIL-";
				    	$conditions[]="a.circular_no = '%$c_no%'";
				    }elseif (!empty($volume)) {
				    	$c_no="-VIL-".$volume;
				    	$conditions[]="a.circular_no = '%$c_no%'";
				    }elseif (!empty($c_value)) {
				    	$c_no=$c_value;
				    	$conditions[]="a.circular_no LIKE '%$c_no%'";
				    }
				    //<--------End of  Citation number--------->


				    // for cgst section 
				    if($_REQUEST['cgst_section']!="")
				    {
				    	if($_REQUEST['prod_id']=="0" || $_REQUEST['prod_id']=="7")
				    	{
				    		$cgst_section=trim(mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['cgst_section']));
				    		$conditions[]="a.section_no LIKE '%$cgst_section%'";
				    	}
				    }

				    // for cgst rules
				    if($_REQUEST['cgst_rule']!="")
				    {
				    	if($_REQUEST['prod_id']=="0" || $_REQUEST['prod_id']=="7")
				    	{
				    		$cgst_rule=trim(mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['cgst_rule']));
				    		$conditions[]="a.rule_no LIKE '%$cgst_rule%'";
				    	}
				    }

				    // for court
				    if($_REQUEST['court']!='0')
					{
						if($_REQUEST['court']=="HC"){
							$courtType= " AND (sp.sub_prod_name LIKE 'High Court Cases')";
							if($_REQUEST['courtCity']!='0')
							{
								$conditions[]="a.circular_no LIKE '%".$_REQUEST['courtCity']."%'";
							}
						}else if($_REQUEST['court']=="SC"){
							$courtType= " AND (sp.sub_prod_name LIKE 'Supreme Court Cases')";
						}else if($_REQUEST['court']=="TRI"){
							$courtType= " AND (sp.sub_prod_name LIKE 'Tribunal')";
							if($_REQUEST['courtCity1']!='0')
							{
								$conditions[]="a.circular_no LIKE '%".$_REQUEST['courtCity1']."%'";
							}
						}else if($_REQUEST['court']=="AAR"){
							$courtType= " AND (sp.sub_prod_name LIKE 'Advance Ruling Authority')";
						}else if($_REQUEST['court']=="AAAR"){
							$courtType= " AND (sp.sub_prod_name LIKE 'AAAR')";
						}else if($_REQUEST['court']=="NAA"){
							$courtType= " AND (sp.sub_prod_name LIKE 'National Anti/Profiteering Authority')";
						}
					}else{
						$courtType= "";
					}

				    
				    // for category
					if($_REQUEST['prod_id']!=0)
					{

						$result = mysqli_query($GLOBALS['con'],"SELECT p.prod_id,p.dbsuffix,sp.sub_prod_id FROM product as p LEFT JOIN sub_product as sp ON p.prod_id=sp.prod_id WHERE p.prod_id= '".$_REQUEST['prod_id']."' AND (sp.sub_prod_type LIKE 'Judgements')".$courtType) or die(mysql_error());
						$sub_prod=[];
						if(mysqli_num_rows($result)>0)
						{
							while ($data = mysqli_fetch_array($result)) {	
								$sub_prod[]="a.sub_prod_id = '".$data['sub_prod_id']."'";
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
						$sub_prod_name="AND (sp.sub_prod_type LIKE 'Judgements')".$courtType;
						$sql=implode(" UNION ",(tableUnion($conditions,$table,$id,$sub_prod_name)))." ".$orderby;

					}
					return $sql;
				}
					
			}

			$query=$_REQUEST['function_name']($_REQUEST);
			//print_r($query); die();
		}

		// for case law only keyword search
		if(isset($_REQUEST['searchIn_btn']))
		{
			
			$text=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['Keyword']);
			if($_REQUEST['Keyword']!="")
			{
				$conditions = array();
				$keyword=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['Keyword']);
				$string=trim(clean($keyword));
				$rep_data=shortForm($string);
				if($_REQUEST['Keyword']!="")
				{
					$keyword=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['Keyword']);
					$string=trim(clean($keyword));
					$rep_data=shortForm($string);
					if($_REQUEST['search_in']==1) //search in summary
					{
						$conditions[] ="(a.cir_subject LIKE '%".$string."%' OR a.cir_subject LIKE '%".$rep_data[0]."%')";
					}
					else if($_REQUEST['search_in']==2) //search in file data
					{
						$conditions[] ="(a.file_data LIKE '%".$string."%' OR a.file_data LIKE '%".$rep_data[0]."%')";
					}
					else
					{
						$conditions[] ="(a.cir_subject LIKE '%".$string."%' OR a.cir_subject LIKE '%".$rep_data[0]."%' OR a.file_data LIKE '%".$string."%' OR a.file_data LIKE '%".$rep_data[0]."%')";
					}

				}

				$id=['1','2','4','5','7'];
				$table=array("casedata_vat","casedata_st","casedata_ce","casedata_cu","casedata_sgst");
				$sub_prod_name="AND (sp.sub_prod_type LIKE 'Judgements')";
				$query=implode(" UNION ",(tableUnion($conditions,$table,$id,$sub_prod_name)));

			}
		}

		// for case law only party name search
		if(isset($_REQUEST['partyName_btn']))
		{
			
			$text=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['party_name']);
			if($_REQUEST['party_name']!="")
			{
				$conditions = array();
				$party_name=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['party_name']);
				$string=trim($party_name);
				$rep_data=shortForm($string);

				$conditions[] ="(a.party_name LIKE '%".$string."%' OR a.party_name LIKE '%".$rep_data[0]."%')";

				$id=['1','2','4','5','7'];
				$table=array("casedata_vat","casedata_st","casedata_ce","casedata_cu","casedata_sgst");
				$sub_prod_name="AND (sp.sub_prod_type LIKE 'Judgements')";
				$query=implode(" UNION ",(tableUnion($conditions,$table,$id,$sub_prod_name)));

			}
		}

		// for notification  only keyword search
		if(isset($_REQUEST['keyword_btn']))
		{
			
			$text=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['keyword']);
			if($_REQUEST['keyword']!="")
			{
				$conditions = array();
				$keyword=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['keyword']);
				$string=trim(clean($keyword));
				$rep_data=shortForm($string);
				
				$conditions[] ="((a.cir_subject LIKE '%".$string."%' OR a.file_data LIKE '%".$string."%' OR a.party_name LIKE '%".$string."%') OR(a.cir_subject LIKE '%".$rep_data[0]."%' OR a.file_data LIKE '%".$rep_data[0]."%' OR a.party_name LIKE '%".$rep_data[0]."%')) ";
				
				$id=['1','2','4','5','6','7','9','10'];
				$table=array("casedata_vat","casedata_st","casedata_ce","casedata_cu","casedata_dgft","casedata_sgst","casedata_igst","casedata_cgst");
				$sub_prod_name="AND (sp.sub_prod_name='Circular' OR sp.sub_prod_name='Notification')";
				$query=implode(" UNION ",(tableUnion($conditions,$table,$id,$sub_prod_name)));

			}
		}

		// for notification  only Notification number search
		if(isset($_REQUEST['noti_no_btn']))
		{
			
			$text=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['noti_no']);
			if($_REQUEST['noti_no']!="")
			{
				$conditions = array();
				$keyword=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['noti_no']);
				$string=trim(clean($keyword));
				$rep_data=shortForm($string);
				
				$conditions[] ="(a.circular_no LIKE '%".$string."%')";
				
				$id=['1','2','4','5','6','7','9','10'];
				$table=array("casedata_vat","casedata_st","casedata_ce","casedata_cu","casedata_dgft","casedata_sgst","casedata_igst","casedata_cgst");
				$sub_prod_name="AND (sp.sub_prod_name='Circular' OR sp.sub_prod_name='Notification')";
				$query=implode(" UNION ",(tableUnion($conditions,$table,$id,$sub_prod_name)));

			}
		}
			//print_r($query); die();
			// $search=$_REQUEST['q'];
			// $text=preg_replace("/[<>?''_\"\"|{};:=]/","",$search);
			$showRecordPerPage =20;
	        if(isset($_GET['page']) && !empty($_GET['page'])){
	            $currentPage = $_GET['page'];
	        }else{
	            $currentPage = 1;
	        }
		    $startFrom = ($currentPage * $showRecordPerPage) - $showRecordPerPage;
		    //include('count_query.php');
		    $res = mysqli_query($GLOBALS['con'],$query) or die(mysql_error(mysql_connect($db_host, $db_user, $db_pwd)));
		    $count = mysqli_num_rows($res);
		    //$totalEmployee = mysqli_fetch_array($allEmpResult)[0];
		    $lastPage = ceil($count/$showRecordPerPage);
		    $firstPage = 1;
		    $nextPage = $currentPage + 1;
		    $previousPage = $currentPage - 1;
		    $query."LIMIT $startFrom, $showRecordPerPage";
		    $res1=mysqli_query($GLOBALS['con'],$query." LIMIT $startFrom, $showRecordPerPage") or die(mysql_error());
		    $tocount=mysqli_num_rows($res1);

		   
	
?>
<!-- left sec start <div class="col-md-16 col-sm-16"> -->
<div class="col-md-11 col-sm-9 left-section main_div">
    <h1><?php if(isset($_REQUEST['searchButton'])){echo $_REQUEST['pagename'].' - Advance Search';}else{echo 'Advance Search';}?>
  		<ol class="breadcrumb">
	        <li><a href="<?php echo $getBaseUrl; ?>">Home</a></li>
	        <li class="active"><?php if(isset($_REQUEST['searchButton'])){echo $_REQUEST['pagename'].' - Advance Search';}else{echo 'Advance Search';}?></li>
        </ol>

    </h1>
    <div class=" show-more">
		<a  href="#." id="advance_search">New Search / Advance Search &nbsp;<i class="ion-chevron-right" ></i><i class="ion-chevron-right"></i></a>
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
            <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                <div class="panel-body" id="case_law">
                    
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingTwo" onClick="return searchBody('Acts and Rules')">
                <h4 class="panel-title">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Acts/ Rules/ Regulations
                    </a>
                </h4>
            </div>
            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                <div class="panel-body" id='act'>
                    
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingThree" onClick="return searchBody('Notification')">
                <h4 class="panel-title">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        Notifications
                    </a>
                </h4>
            </div>
            <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                <div class="panel-body" id="notification">
                    
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingFour" onClick="return searchBody('Forms')">
                <h4 class="panel-title">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                        Forms
                    </a>
                </h4>
            </div>
            <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
                <div class="panel-body" id="forms">
                    
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingFive" onClick="return searchBody('Articles')">
                <h4 class="panel-title">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                        Articles
                    </a>
                </h4>
            </div>
            <div id="collapseFive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFive">
                <div class="panel-body" id="articles1">
                    
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingSix" onClick="return searchBody('News')">
                <h4 class="panel-title">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                        News
                    </a>
                </h4>
            </div>
            <div id="collapseSix" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSix">
                <div class="panel-body" id="news">
                    
                </div>
            </div>
        </div>
        
    </div>

     <div class=" show-more" style='background: linear-gradient(to bottom, #ff7708 1%,#ffa000 100%); text-align: left; padding: 10px 15px;'>
		<a  href='#.' id='refine_search' style='color: #fff;'>Refine / Filter Search &nbsp;<i class='ion-chevron-right'></i><i class='ion-chevron-right'></i></a>
	</div>
    <!-- <div class='' style='background : #ff7808;'>
		 
	</div><div class='clear'></div>	 -->
	<div class='refine_search_body' style='display : none;'>
					
	</div><div class='clear'></div>
			       
    <div class="col-md-16">
		<?php 

			
		// $b=0;
		// for($i = 1; $i <= $rec_count; $i++) {
		// 	$b++;
		// 	$j = $i;
		// 	$k = ($i - 1);
		// 	$i +=$rec_limit;
		// 	//echo ;
		// 	if(($rec_count-$i)>0) {
		// 	echo "<a  " ;
		// 		if(($currentPage!='all')) { 
		// 			if($k==$currentPage || ($currentPage==0) && ($i==20)) { 
		// 				echo "class='active'"; 
		// 			}   
		// 		}
		// 		echo " href='".$_SERVER['REQUEST_URI']."&&page=".$b."'>$j - $i</a>";
		// 	} else {
		// 	echo "<a ";
		// 			if(($k==$currentPage) || ($rec_count <19)) { 
		// 				echo "class='active'"; 
		// 			}  
		// 	echo "href='".$_SERVER['REQUEST_URI']."&&page=".$b."'>$j - $rec_count</a>";


		// 	}		
		// }

		// if($rec_count >20) {
		// 	echo "<a ";
		// 			if($currentPage=='all'){ echo "class='active'"; }  
		// 	echo "href='?q=".$text."&&page=".$b."'>All</a>";
		// }
		$rec_count = $count;
		$rec_limit = 19;
		$from=$startFrom+1;
		$to=$from+$tocount-1;

			if(isLogeedIn()) {
				if($_SESSION["userStatus"]=="expired") {
					include('expiredUserError.php'); 
				} else {
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
			    				<a class="page-link" href="<?php echo $_SERVER['REQUEST_URI'];?>&&page=<?php echo $firstPage ?>" tabindex="-1" aria-label="Previous">
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
		    					<a class="page-numbers" href="<?php echo $_SERVER['REQUEST_URI'];?>&&page=<?php echo $previousPage ?>"><?php echo $previousPage ?></a>
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
					    				<li class="page-item <?php if($c_page==$currentPage){echo "active";}?>">
					    					<a class="page-numbers" href="<?php echo $_SERVER['REQUEST_URI'];?>&&page=<?php echo $c_page ?>"><?php echo $c_page++;?></a>
					    				</li>
			    		<?php		
			    					}
			    				}
			    			} 
			    		?>
			    			<li class="page-item">
			          			<a class="page-numbers" href="<?php echo $_SERVER['REQUEST_URI'];?>&&page=<?php echo $lastPage ?>" aria-label="Next">
			          				<span aria-hidden="true">Last</span>
			          			</a>
			          		</li>	
					    </ul>
					</nav>
					<?php
					if($_REQUEST['pagename']=="Articles" || $_REQUEST['pagename']=="News"){
						
						while ($row=mysqli_fetch_array($res1, MYSQL_ASSOC)) {
							$encryptID = base64_encode(base64_encode($row['id']));
	                      	$author = '';
	                      	if($_REQUEST['pagename'] == 'articles') { $author = ' | '.$row['author']; }
		                     	echo "<div class='widget-box'>
		                              <h4><a href='javascript:void(0)' onclick='showFrame(\"$encryptID\",\"$dbsuffix\")'>".$row['subject']."</a> <span>".$row['Date']."".$author."</span></h4>
		                              <div class='widget-content'>";
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
						while($row = mysqli_fetch_array($res1, MYSQL_ASSOC))
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
						    if(empty($file_path)){
						    	echo getEmptyCircularLink($encryptID, $dataType, $circular_no);
						    	//echo "hello";
						    }else{
						    	//echo "hello";
								echo getCircularLink($encryptID, $dataType, $circular_no);
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
			    				<a class="page-link" href="<?php echo $_SERVER['REQUEST_URI'];?>&&page=<?php echo $firstPage ?>" tabindex="-1" aria-label="Previous">
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
		    					<a class="page-numbers" href="<?php echo $_SERVER['REQUEST_URI'];?>&&page=<?php echo $previousPage ?>"><?php echo $previousPage ?></a>
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
					    				<li class="page-item <?php if($c_page==$currentPage){echo "active";}?>">
					    					<a class="page-numbers" href="<?php echo $_SERVER['REQUEST_URI'];?>&&page=<?php echo $c_page ?>"><?php echo $c_page++;?></a>
					    				</li>
			    		<?php		
			    					}
			    				}
			    			} 
			    		?>
			    			<li class="page-item">
			          			<a class="page-numbers" href="<?php echo $_SERVER['REQUEST_URI'];?>&&page=<?php echo $lastPage ?>" aria-label="Next">
			          				<span aria-hidden="true">Last</span>
			          			</a>
			          		</li>	
					    </ul>
					</nav>
						
			<?php
					}
					else
					{ 
						echo '<div class="alert alert-danger always-show" ><strong>No Records Found</strong> - Please <a  href="advancesearch.php" data-effect="mfp-zoom-in">Advance Search</a> </div>';
					}
				}

					
			} 
			else 
			{
	  			include('loggedInError.php');
	  		}
				
	?>   
    </div> 
</div>

    <!-- left sec end -->
<?php include('footer.php') ?>
<script type="text/javascript">
	$("#advance_search").click(function(){
		//debugger;
		$("#accordion").slideToggle();
		//$(".searchbody").toggle();
	});		
</script>
<script type="text/javascript">
	$("#refine_search").click(function(){
		//debugger;
		$(".refine_search_body").slideToggle();
		//$(".searchbody").toggle();
	});		
</script>
<script type="text/javascript">
	var searchBody=function(data){
		//debugger;
		window.location='searchBody?search='+data;
	}
</script>

<script type="text/javascript">
	
$(document).ready(function(){
	//debugger;
	var fun_name="<?php echo $_REQUEST['pagename'];?>";
	//alert(fun_name);
	var query="<?php echo str_replace('+',' ',$_SERVER['QUERY_STRING']);?>";
	var query1="searchBody.php?search="+fun_name+"&"+query;
	//alert(query1);
	$.ajax({
        //data :{search: value},
        url  : query1, //php page URL where we post this data to view from database
        type :'POST',
        dataType: 'html', 
        success: function(html){
        		//debugger;
            	if(html!=""){
            		$(html).find('.searchbody').appendTo('.refine_search_body');

            		// For caselaw
            		var dbsuffix = $("#prod_id").find('option:selected').attr('data-dbsuffix');
					$("#dbsuffix").val(dbsuffix);

					//-----------------This Script for Notification search when category already selected---------------------
            		if(fun_name == "Notification"){
            			var prod_id="<?php if(isset($_REQUEST['prod_id'])){echo $_REQUEST['prod_id'];}else{echo "";}?>";
            			if(prod_id!='' && prod_id !='0')
            			{
            				if(prod_id=='7'){
            					$("#state").css("display","block");
							}else{
								$("#state").css("display","none");
							}
							var table="casedata_<?php echo $_REQUEST['dbsuffix']?>";
							var sub_product_id="<?php if(isset($_REQUEST['sub_product_id'])){echo $_REQUEST['sub_product_id'];}else{echo "";}?>";
							var type="<?php if(isset($_REQUEST['type'])){echo $_REQUEST['type'];}else{echo "";}?>";
							$('#category_type').css("display","block");
							if(prod_id=='1' || prod_id=='2' || prod_id=='4' || prod_id=='5' || prod_id=='6' || prod_id=='7' || prod_id=='8' || prod_id=='9' || prod_id=='10')
							{
								$.ajax({
					            	data :{id: prod_id, table : table, sub_product_id : sub_product_id },
					            	url  :"adv_search_notification_type.php", //php page URL where we post this data to view from database
					            	type :'POST',
					            	dataType: 'html',  
					            	success: function(data){
					            		//debugger;
					            		//alert(data);
						            	if(data!="no"){

						            		$('#category_type').css("display","block");
						            		$("#sub_product_id").html(data);
						            		
					            			if(prod_id=='7' || prod_id=='8' || prod_id=='9' || prod_id=='10')
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

											if(prod_id=='5')
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

											if(prod_id=='4')
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
						            		
						            	}else{
						            		$('#category_type').css("display","none");
						            	}
					                }
					            });
							}
							$('#category_type').css("display","none");
            			}
            		}
            		//-----------------Ending Script for Notification search when category already selected ----------- 	


            		//-----------------This Script for Case law --------------------
            		if(fun_name == "Case Laws"){
            			var prod_id="<?php if(isset($_REQUEST['prod_id'])){echo $_REQUEST['prod_id'];}else{echo "";}?>";
            			var court ="<?php if(isset($_REQUEST['court'])){echo $_REQUEST['court'];}else{echo "";}?>"

            			if(court=="HC"){
							$("#tri").css('display','none');
							$("#hc").css('display','block');
						}else if(court=="TRI"){
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
            		}
            		//-----------------Ending Script for Case law  ----------- 	


            		//-----------------This Script for Acts and rules --------------------
            		if(fun_name == "Acts and Rules"){
            			var prod_id="<?php if(isset($_REQUEST['prod_id'])){echo $_REQUEST['prod_id'];}else{echo "";}?>";
            			var type ="<?php if(isset($_REQUEST['type'])){echo $_REQUEST['type'];}else{echo "";}?>"

            			// for act and rule
						if(type=="Acts"){
							$("#section_no").val("");
							$("#section").css("display","block");
							$("#rule").css("display","none");
						}else{
							$("#rule_no").val("");
							$("#rule").css("display","block");
							$("#section").css("display","none");
						}
            			
            		}
            		//-----------------Ending Script for Acts and rules  ----------- 	

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


					$("#prod_id").change(function(){
						//debugger;
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
				            		//debugger;
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
						//debugger;
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
						//debugger;
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
            		
            	}

            }
        });
});
</script>

<!-- <script type="text/javascript">
	// $("#advance_search").click(function(){
	// 	//debugger;
	// 	$("#accordion").slideToggle();
	// 	$(".searchbody").toggle();
	// });	

	var searchBody=function(data){
		//debugger;
		window.location='searchBody?search='+data;
	}

	$("#courtType").change(function(){
		//debugger;
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
		//debugger;
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
            		//debugger;
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
		//debugger;
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
		//debugger;
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
		//debugger;
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
	
</script> -->
<!-- when back to advance search page this script will show selected value -->
<!-- <script type="text/javascript">
	$(document).ready(function(){
		//debugger;
		var dbsuffix = $("#prod_id").find('option:selected').attr('data-dbsuffix');
		$("#dbsuffix").val(dbsuffix);

		if($('#courtType :selected').text()=='High Court Cases'){
  			$("#tri").css('display','none');
			$("#hc").css('display','block');
    	}
    	else if($('#courtType :selected').text()=='Tribunal'){
    		$("#hc").css('display','none');
			$("#tri").css('display','block');
    	}
    	else{
    		$("#hc option:first").attr('selected','selected');
    		$("#tri option:first").attr('selected','selected'); 
    	}
	});
	
</script> -->
<!-- <script type="text/javascript">
	$(".refine_search_body").find("#courtType").change(function(){
		//debugger;
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
</script> -->
<!-- <script type="text/javascript">
	$(document).ready(function(){
		//debugger;
		var dbsuffix = $("#prod_id").find('option:selected').attr('data-dbsuffix');
		$("#dbsuffix").val(dbsuffix);

		if($('#courtType').val()=='High Court Cases'){
  			$("#tri").css('display','none');
			$("#hc").css('display','block');
    	}
    	else if($('#courtType').val()=='Tribunal'){
    		$("#hc").css('display','none');
			$("#tri").css('display','block');
    	}
    	else{
    		$("#hc option:first").attr('selected','selected');
    		$("#tri option:first").attr('selected','selected'); 
    	}
	});
	
</script> -->