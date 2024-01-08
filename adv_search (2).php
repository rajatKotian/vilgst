<?php
	$page = '';
	
	include('header.php');  

	//echo $_SERVER['REQUEST_URI'];
	//print_r($_SESSION);
	
// 	    function wordval($text)
// 		{
// 			$value=trim(preg_replace('/[^A-Za-z0-9]/', ' ', $text)); // Removes special chars.
// 			$value1=explode(' ',$value);
// 			return implode('%%',$value1); 
// 		}


		function shortForm($text,$text1,$text2)
		{
			$replace=array();
			$rep_data=array();
			if(!empty($text))
			{
				$value=explode(' ', $text);
				foreach ($value as $k=>$v) {
					$result = mysqli_query($GLOBALS['con'],"SELECT * FROM `short_form` WHERE `short_form` LIKE '%$v%'") or die(mysql_error());	
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

			if(!empty($text1))
			{
				$value=explode(' ', $text1);
				foreach ($value as $k=>$v) 
				{
					$result = mysqli_query($GLOBALS['con'],"SELECT * FROM `short_form` WHERE `short_form` LIKE '%$v%'") or die(mysql_error());	
					$data = mysqli_fetch_array($result);
					if(mysqli_num_rows($result)>0){
						$replace1[]=$data['full_form'];	
					}else{
						$replace1[]=$v;
					}
				}
				$rep_data[]=implode(' ', $replace1);
				//$rep_data[]=implode(' ', array_replace($value, $replace));	
			}

			if(!empty($text2))
			{
				$value=explode(' ', $text2);
				foreach ($value as $k=>$v) 
				{
					$result = mysqli_query($GLOBALS['con'],"SELECT * FROM `short_form` WHERE `short_form` LIKE '%$v%'") or die(mysql_error());	
					$data = mysqli_fetch_array($result);
					if(mysqli_num_rows($result)>0){
						$replace2[]=$data['full_form'];	
					}else{
						$replace2[]=$v;
					}
				}
				$rep_data[]=implode(' ', $replace2);
				//$rep_data[]=implode(' ', array_replace($value, $replace));	
			}

			return $rep_data; 
			
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
	    	    $prod_id=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['prod_id']);
				$dbsuffix=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['dbsuffix']);
				$type=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['type']);
				$text=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['text']);

	    		function act(){
	    			$prod_id=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['prod_id']);
					$dbsuffix=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['dbsuffix']);
					$type=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['type']);
					$text=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['text']);
					if($type=="Acts"){
						$section_no=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['section_no']);
					}else{
						$rule_no=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['rule_no']);
					}
					//echo "SELECT * FROM casedata_$dbsuffix where prod_id='$prod_id' AND sub_subprod_id='$type'";
				 	$getsubproduct=mysqli_query($GLOBALS['con'],"SELECT * FROM sub_product where prod_id='$prod_id' AND sub_prod_name LIKE '$type'");
				 	$result=mysqli_fetch_array($getsubproduct,MYSQL_ASSOC);

					$query = "SELECT a.*,DATE_FORMAT(circular_date,GET_FORMAT(DATE,'EUR'))'Date',p.prod_name,p.dbsuffix,sp.sub_prod_name,sm.state_name FROM casedata_$dbsuffix as a LEFT JOIN product as p ON a.prod_id=p.prod_id LEFT JOIN sub_product as sp ON a.sub_prod_id=sp.sub_prod_id LEFT JOIN state_master as sm ON a.state_id=sm.state_id";
					$query2= " ORDER BY a.data_id DESC";

	    			$conditions = array();
		    		if(mysqli_num_rows($getsubproduct)>0){
		    			$conditions[] ="a.sub_prod_id = '".$result['sub_prod_id']."'";
		    		}
		    	
			    	if(!empty($text)) {
				    	$rep_data=shortForm($text,'','');
				      	$conditions[] = "(a.cir_subject LIKE '%".$text."%' OR a.file_data LIKE '%".$text."%' OR a.party_name LIKE '%".$text."%') OR (a.cir_subject LIKE '%".$rep_data[0]."%' OR a.file_data LIKE '%".$rep_data[0]."%' OR a.party_name LIKE '%".$rep_data[0]."%') ";
				    }

				    if(!empty($section_no)){
				    	$conditions[]="a.section_no LIKE '%".$section_no."%'";
				    }

				    if(!empty($rule_no)){
				    	$conditions[]="a.rule_no LIKE '%".$rule_no."%'";
				    }
			    
				    $sql = $query;
				    if (count($conditions) > 0) {
				      	return $sql .= " WHERE " . implode(' AND ', $conditions).$query2;
				    }else{
				    	return $sql.=$query2;
				    }

				}
			
			} 

			if($_REQUEST['pagename']=='Notification')
		    {
		    	//print_r($_REQUEST);
		    	$prod_id=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['prod_id']);
				$state_id=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['state_id']);
				if(isset($_REQUEST['type']))
				{
					$not_type=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['type']);
				}
				$text=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['text']);
				$not_no=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['no']);
				$date=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['date']);
				$dbsuffix=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['dbsuffix']);

		      	function notification(){
			     	$prod_id=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['prod_id']);
					$state_id=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['state_id']);
					if(isset($_REQUEST['type']))
					{
						$not_type=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['type']);
					}
					$text=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['text']);
					$not_no=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['no']);
					$date=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['date']);
					$fromDate=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['fromDate']);
					$toDate=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['toDate']);
					$dbsuffix=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['dbsuffix']);

				 	// $getsubproduct=mysqli_query($GLOBALS['con'],"SELECT * FROM sub_product where prod_id='$prod_id' AND sub_prod_name='$type'");
				 	// $result=mysqli_fetch_array($getsubproduct);

				 	
		     		$conditions = array();
		     		//$conditions[] ="a.sub_prod_id = '".$result['sub_prod_id']."'";
				    if(! empty($state_id)) {
				      $conditions[]= "a.state_id='$state_id'";
				    }
				    if(! empty($text)) {
				    	$rep_data=shortForm($text,'','');
				      $conditions[] = "(a.cir_subject LIKE '%".$text."%' OR a.file_data LIKE '%".$text."%' OR a.party_name LIKE '%".$text."%') OR(a.cir_subject LIKE '%".$rep_data[0]."%' OR a.file_data LIKE '%".$rep_data[0]."%' OR a.party_name LIKE '%".$rep_data[0]."%') ";
				    }
				    if(! empty($not_type)) {
				      $conditions[] = "(a.sub_subprod_id = '$not_type')";
				    }
				    if(! empty($date)) {
				      $conditions[] = "(a.circular_date LIKE '$date%')";
				    }
				    if(! empty($not_no)) {
				      $conditions[] = "(a.circular_no LIKE '%$not_no%')";
				    }
				    if(! empty($fromDate) || ! empty($toDate)) {
				    	if(empty($fromDate)){
				    		$fromDate='1942-01-01';
				    	}
				    	if(empty($toDate)){
				    		$toDate=date('Y-m-d');
				    	}
				      $conditions[] = "(a.circular_date BETWEEN '$fromDate%' AND '$toDate%')";
				    }


				    if($dbsuffix=="0"){
				    	$table=getCategory('category','Notifications');
				    	$conditions[]="(".getsubproduct('sub_product','Notifications',$table['id']).")";
				    	//$table=array("casedata_ce","casedata_cu","casedata_gst","casedata_st","casedata_vat");
						$query=allCaseDataQuery($conditions,$table['db']);
					}else{
						$conditions[]="(".getsubproduct('sub_product','Notifications',$prod_id).")";
						$query = "SELECT a.*,DATE_FORMAT( a.circular_date, GET_FORMAT( DATE, 'EUR' ) )  'Date',p.prod_name,p.dbsuffix,sp.sub_prod_name,sm.state_name FROM casedata_$dbsuffix as a LEFT JOIN product as p ON a.prod_id=p.prod_id LEFT JOIN sub_product as sp ON a.sub_prod_id=sp.sub_prod_id LEFT JOIN state_master as sm ON a.state_id=sm.state_id";
						
					}
					//print_r($query); die();
				    $sql = $query;
				    $query2= " ORDER BY data_id DESC";
		    		if (count($conditions) > 0) {
		    			if($dbsuffix=="0"){
		    				return $sql=implode(" UNION ", $sql).$query2;
		    			}else{
				      		return $sql .= " WHERE " . implode(' AND ', $conditions).$query2;
		    			}
				    }else{
				    	if($dbsuffix=="0"){
				    		return $sql=implode(" UNION ", $sql).$query2;
				    	}else{
				    		return $sql.=$query2 ;
				    	}
				    }
				}
			}

			if($_REQUEST['pagename']=='Articles'){
				//print_r($_REQUEST);
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
				    $query2= " ORDER BY a.data_id DESC";
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


			if($_REQUEST['pagename']=='Case Laws'){
				 //print_r($_REQUEST);
				$text=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['text']);
				function case_data(){
					$prod_id=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['prod_id']);
					$dbsuffix=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['dbsuffix']);
					$fromDate=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['fromDate']);
					$toDate=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['toDate']);
					$party_name=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['party_name']);
					$inc_txt=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['inc_txt']);
					$exc_txt=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['exc_txt']);
					$text=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['text']);

					$year=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['year']);
					$volume=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['volume']);
					$c_value=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['c_value']);
					$eq_citation=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['c_value']);

					$courtType=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['courtType']);
					$courtCity=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['courtCity']);
					$courtCity1=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['courtCity1']);

					// echo "SELECT * FROM `sub_product` WHERE `prod_id`='".$_REQUEST['prod_id']."' AND `sub_prod_name`='".$_REQUEST['courtType']."'";
					$getsubproduct=mysqli_query($GLOBALS['con'],"SELECT * FROM `sub_product` WHERE `prod_id`='".$_REQUEST['prod_id']."' AND `sub_prod_name`='".$_REQUEST['courtType']."'") or die(mysql_error());
					$result=mysqli_fetch_array($getsubproduct,MYSQL_ASSOC);

					
					$conditions=array();
		
					if(mysqli_num_rows($getsubproduct)>0){
		    			$conditions[] ="a.sub_prod_id = '".$result['sub_prod_id']."'";
		    		}
		    		if(! empty($state_id)) {
				      $conditions[]= "a.state_id='$state_id'";
				    }
				    
				    if(! empty($fromDate) || ! empty($toDate)) {
				    	if(empty($fromDate)){
				    		$fromDate='1961-01-01';
				    	}
				    	if(empty($toDate)){
				    		$toDate=date('Y-m-d');
				    	}
				      $conditions[] = "(circular_date BETWEEN '$fromDate%' AND '$toDate%')";
				    }
				    if(! empty($party_name)) {
				    	$rep_data=shortForm($party_name,'','');
				      $conditions[] = "(a.party_name LIKE '%".$party_name."%' OR a.party_name LIKE '%".$rep_data[0]."%')";
				    }
				    if(! empty($citation_no)) {
				      $conditions[] = "a.circular_no LIKE '%".$citation_no."%'";
				    }
				    
				    //<--------Condition for keyword,include Keyword and Exclude Keyword--------->
				    if(!empty($text) && !empty($inc_txt) && !empty($exc_txt)) {
				    	$rep_data=shortForm($text,$inc_txt,$exc_txt);
				      	$conditions[] = "((a.cir_subject LIKE '%".$text."%' OR a.file_data  LIKE '%".$text."%' OR a.cir_subject LIKE '%".$rep_data[0]."%' OR a.file_data  LIKE '%".$rep_data[0]."%')) AND ((a.cir_subject LIKE '%".$inc_txt."%' OR a.file_data  LIKE '%".$inc_txt."%' OR a.cir_subject LIKE '%".$rep_data[1]."%' OR a.file_data  LIKE '%".$rep_data[1]."%')) AND ((a.cir_subject NOT LIKE '%".$exc_txt."%' OR a.file_data NOT LIKE '%".$exc_txt."%' OR a.cir_subject NOT LIKE '%".$rep_data[2]."%' OR a.file_data NOT LIKE '%".$rep_data[2]."%')) ";
				    }
				    else if(!empty($text) && !empty($inc_txt)){
				    	$rep_data=shortForm($text,$inc_txt,'');
				    	$conditions[] = "((a.cir_subject LIKE '%".$text."%' OR a.file_data  LIKE '%".$text."%' OR a.cir_subject LIKE '%".$rep_data[0]."%' OR a.file_data  LIKE '%".$rep_data[0]."%')) AND ((a.cir_subject LIKE '%".$inc_txt."%' OR a.file_data  LIKE '%".$inc_txt."%' OR a.cir_subject LIKE '%".$rep_data[1]."%' OR a.file_data  LIKE '%".$rep_data[1]."%'))";
				    }
				    else if(!empty($text) && !empty($exc_txt)){
				    	$rep_data=shortForm($text,$exc_txt,'');
				    	$conditions[] = "((a.cir_subject LIKE '%".$text."%' OR a.file_data  LIKE '%".$text."%' OR a.cir_subject LIKE '%".$rep_data[0]."%' OR a.file_data  LIKE '%".$rep_data[0]."%')) AND ((a.cir_subject NOT LIKE '%".$exc_txt."%' OR a.file_data NOT LIKE '%".$exc_txt."%' OR a.cir_subject LIKE '%".$rep_data[1]."%' OR a.file_data  LIKE '%".$rep_data[1]."%')) ";
				    }
				    else if(!empty($inc_txt) && !empty($exc_txt)){
				    	$rep_data=shortForm($inc_txt,$exc_txt,'');
				    	$conditions[] = "((a.cir_subject LIKE '%".$inc_txt."%' OR a.file_data  LIKE '%".$inc_txt."%' OR a.cir_subject LIKE '%".$rep_data[0]."%' OR a.file_data  LIKE '%".$rep_data[0]."%')) AND ((a.cir_subject NOT LIKE '%".$exc_txt."%' OR a.file_data NOT LIKE '%".$exc_txt."%' OR a.cir_subject NOT LIKE '%".$rep_data[1]."%' OR a.file_data NOT LIKE '%".$rep_data[1]."%')";
				    }else if(!empty($text)){

				    	$rep_data=shortForm($text,'','');
				    	$conditions[] = "(a.cir_subject LIKE '%".$text."%' OR a.file_data  LIKE '%".$text."%' OR a.cir_subject LIKE '%".$rep_data[0]."%' OR a.file_data  LIKE '%".$rep_data[0]."%')";
				    }else if(!empty($inc_txt)){
				    	$rep_data=shortForm($inc_txt,'','');
				    	$conditions[] = "(a.cir_subject LIKE '%".$inc_txt."%' OR a.file_data  LIKE '%".$inc_txt."%' OR a.cir_subject LIKE '%".$rep_data[0]."%' OR a.file_data  LIKE '%".$rep_data[0]."%')";
				    }else if(!empty($exc_txt)){
				    	$rep_data=shortForm($exc_txt,'','');
				    	$conditions[] = "(a.cir_subject LIKE '%".$exc_txt."%' OR a.file_data  LIKE '%".$exc_txt."%' OR a.cir_subject LIKE '%".$rep_data[0]."%' OR a.file_data  LIKE '%".$rep_data[0]."%')";
				    }
				    //<-------End of keyword,include Keyword and Exclude Keyword--------->

				    //<--------Condition For Citation number--------->
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
				    //<--------End of  Citation number--------->

			    	//<--------Condition For Hight Court bench/state number--------->
				    if(! empty($courtCity) && $courtCity!='0') {
				      $conditions[] = "a.circular_no LIKE '%$courtCity%'";
				    }
				    //<--------End of  Hight Court bench/state --------->

				    //<--------Condition For Tribunal bench/state number--------->
				    if(! empty($courtCity1) && $courtCity1!='0') {
				      $conditions[] = "a.circular_no LIKE '%$courtCity1%'";
				    }
				    //<--------End of Tribunal bench/state --------->
				    if($dbsuffix=="0"){
				    	$table=getCategory('category','Case Laws');
				    	$conditions[]="(".getsubproduct('sub_product','Judgements',$table['id']).")";
						$query=allCaseDataQuery($conditions,$table['db']);
					}else{
						$conditions[]="(".getsubproduct('sub_product','Judgements',$prod_id).")";
						$query="SELECT a.*,DATE_FORMAT(circular_date,GET_FORMAT(DATE,'EUR'))'Date',p.prod_name,p.dbsuffix,sp.sub_prod_name,sm.state_name FROM casedata_$dbsuffix as a LEFT JOIN product as p ON a.prod_id=p.prod_id LEFT JOIN sub_product as sp ON a.sub_prod_id=sp.sub_prod_id LEFT JOIN state_master as sm ON a.state_id=sm.state_id";
					}

		    		$sql = $query;
		    		$query2= " ORDER BY a.data_id DESC";
		    		if (count($conditions) > 0) {
		    			if($dbsuffix=="0"){
		    				return $sql=implode(" UNION ", $sql);
		    			}else{
				      		return $sql .= " WHERE " . implode(' AND ', $conditions).$query2;
		    			}
				    }else{
				    	if($dbsuffix=="0"){
				    		return $sql=implode(" UNION ", $sql).$query2;
				    	}else{
				    		return $sql.=$query2;
				    	}
				    }
				}
			}



			$query=$_REQUEST['function_name']($_GET);
			//echo $query;
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

	}   
	
?>
<!-- left sec start <div class="col-md-16 col-sm-16"> -->
<div id="show_gst_rate" style="display: none;"></div>
<div class="col-md-11 col-sm-9 left-section main_div">
    <h1><?php if(isset($_REQUEST['searchButton'])){echo $_REQUEST['pagename'].' - Advanced Search';}else{echo 'Advanced Search';}?>
  		<ol class="breadcrumb">
	        <li><a href="<?php echo $getBaseUrl; ?>">Home</a></li>
	        <li class="active"><?php if(isset($_REQUEST['searchButton'])){echo $_REQUEST['pagename'].' - Advanced Search';}else{echo 'Advanced Search';}?></li>
        </ol>

    </h1>
    <div class=" show-more">
		<a  href="#." id="advance_search">New Search / Advanced Search &nbsp;<i class="ion-chevron-right" ></i><i class="ion-chevron-right"></i></a>
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
			        						echo "<p>".preg_replace("`($text)`i", "<mark>$1</mark>", substr($subject,0,650))."... <a href='javascript:void(0)' style='text-decoration:underline;color: #ff7808;' class='readMoreSubject'>[Read more]</a></p>";
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
		$(".searchbody").toggle();
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
	//debugger;

	var value="<?php echo $_REQUEST['pagename'];?>";
	var query="<?php echo str_replace('+',' ',$_SERVER['QUERY_STRING']);?>";
	var query1="searchBody?search="+value+"&"+query;
	//alert(query1);
	$.ajax({
        //data :{search: value},
        url  : query1, //php page URL where we post this data to view from database
        type :'POST',
        dataType: 'html', 
        success: function(html){
            	if(html!=""){
            		//alert(html);
            		$(html).find('.searchbody').appendTo('.refine_search_body');
            		//debugger;

            		//-----------------This Script for Notification search when category already selected---------------------
            		if(value == "Notification"){
            			var not_type=$("#sel_type").val();
            			if(not_type!=""){
            				var prodid=$("#prod_id").val();
            				var dbsuffix=$("#prod_id").find('option:selected').attr('data-dbsuffix');
	            			$("#dbsuffix").val(dbsuffix);
							if(prodid=='7'){
								$("#state").css("display","block");
							}else{
								$("#state").css("display","none");
							}
							if(dbsuffix!='0'){
								var table='casedata_'+dbsuffix;
							}else{
								return false;
							}
							$.ajax({
				            	data :{id: prodid, table : table, noti : not_type},
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
						}
					}
				    //-----------------Ending Script for Notification search when category already selected ----------- 



            		//-----------------This Script for case law search---------------------
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

					//-----------------Ending Script for case law search---------------------

					//-----------------This Script for Acts and Rules search---------------------
					$("#type").change(function(){
						//debugger;
						var value=$(this).val();
						if(value=="Acts"){
							$(".vat").html("Section No.");
							$("#vat").attr("name","section_no");
						}else{
							$(".vat").html("Rule No.");
							$("#vat").attr("name","rule_no");
						}
					});
					//-----------------Ending  Script for Acts and Rules search---------------------

					$("#prod_id").change(function(){
						//debugger;
						var val=$(this).val();
						var dbsuffix=$(this).find('option:selected').attr('data-dbsuffix');
						$("#dbsuffix").val(dbsuffix);
						if(val=='7'){
							$("#state").css("display","block");
						}else{
							$("#state").css("display","none");
						}
						if(dbsuffix!='0'){
							var table='casedata_'+dbsuffix;
						}else{
							return false;
						}
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
            	}
            }
        });
</script>
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