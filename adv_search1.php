<?php  
	// if(isset($_REQUEST['searchButton'])){
 
	$page = '';
	include('header.php');

	//echo $_SERVER['REQUEST_URI'];
	//print_r($_SESSION);
	function shortForm($text,$text1,$text2){
		$replace=array();
		$rep_data=array();
		if(!empty($text)){
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

		if(!empty($text1)){
			$value=explode(' ', $text1);
			foreach ($value as $k=>$v) {
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

		if(!empty($text2)){
			$value=explode(' ', $text2);
			foreach ($value as $k=>$v) {
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
			$state_id=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['state_id']);
			$type=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['type']);
			$text=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['text']);

	    	function act(){
	    		$prod_id=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['prod_id']);
				$dbsuffix=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['dbsuffix']);
				$state_id=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['state_id']);
				$type=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['type']);
				$text=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['text']);
				//echo "SELECT * FROM casedata_$dbsuffix where prod_id='$prod_id' AND sub_subprod_id='$type'";
				 $getsubproduct=mysqli_query($GLOBALS['con'],"SELECT * FROM casedata_$dbsuffix where prod_id='$prod_id' AND sub_subprod_id LIKE '$type'");
				 $result=mysqli_fetch_array($getsubproduct,MYSQL_ASSOC);

				 // echo "SELECT a.*,p.prod_name,p.dbsuffix,sp.sub_prod_name,sm.state_name FROM casedata_$dbsuffix as a LEFT JOIN product as p ON a.prod_id=p.prod_id LEFT JOIN sub_product as sp ON a.sub_prod_id=sp.sub_prod_id LEFT JOIN state_master as sm ON a.state_id=sm.state_id";

				$query = "SELECT a.*,p.prod_name,p.dbsuffix,sp.sub_prod_name,sm.state_name FROM casedata_$dbsuffix as a LEFT JOIN product as p ON a.prod_id=p.prod_id LEFT JOIN sub_product as sp ON a.sub_prod_id=sp.sub_prod_id LEFT JOIN state_master as sm ON a.state_id=sm.state_id";
	    		$conditions = array();
	    		if(mysqli_num_rows($getsubproduct)>0){
	    			$conditions[] ="a.sub_prod_id = '".$result['sub_prod_id']."'";
	    		}
	    		else
	    		{
	    			$conditions[] ="a.sub_prod_id <'0'";	
	    		}
			    if(! empty($state_id)) {
			      $conditions[]= "a.state_id='$state_id'";
			    }
			    if(! empty($text)) {
			    	$rep_data=shortForm($text,'','');
			    	print_r($rep_data);
			      	$conditions[] = "(a.cir_subject LIKE '%$text%' OR a.file_data LIKE '%$text%' OR a.party_name LIKE '%$text%') OR (a.cir_subject LIKE '%$rep_data[0]%' OR a.file_data LIKE '%$rep_data[0]%' OR a.party_name LIKE '%$rep_data[0]%') ";
			    }
			    
			    $sql = $query;
			    if (count($conditions) > 0) {
			      return $sql .= " WHERE " . implode(' AND ', $conditions);
			    }else{
			    	return $sql;
			    }

			}
			
		} 

		if($_REQUEST['pagename']=='notification')
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

			 	$query = "SELECT a.*,p.prod_name,p.dbsuffix,sp.sub_prod_name,sm.state_name FROM casedata_$dbsuffix as a LEFT JOIN product as p ON a.prod_id=p.prod_id LEFT JOIN sub_product as sp ON a.sub_prod_id=sp.sub_prod_id LEFT JOIN state_master as sm ON a.state_id=sm.state_id";
	     		$conditions = array();
	     		//$conditions[] ="a.sub_prod_id = '".$result['sub_prod_id']."'";
			    if(! empty($state_id)) {
			      $conditions[]= "a.state_id='$state_id'";
			    }
			    if(! empty($text)) {
			    	$rep_data=shortForm($text,'','');
			      $conditions[] = "(a.cir_subject LIKE '%$text%' OR a.file_data LIKE '%$text%' OR a.party_name LIKE '%$text%') OR(a.cir_subject LIKE '%$rep_data[0]%' OR a.file_data LIKE '%$rep_data[0]%' OR a.party_name LIKE '%$rep_data[0]%') ";
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
			    $sql = $query;
			    print_r($conditions);
			    if (count($conditions) > 0) {
			      return $sql .= " WHERE " . implode(' AND ', $conditions);
			    }else{
			    	return $sql;
			    }

			}
			
		}

		if($_REQUEST['pagename']=='articles'){
			//print_r($_REQUEST);
			$prod_id=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['prod_id']);
			$state_id=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['state_id']);
			if(isset($_REQUEST['type']))
			{
				$not_type=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['type']);
			}
			$text=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['text']);
			$topic=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['topic']);
			$fromDate=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['fromDate']);
			$toDate=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['toDate']);
			$dbsuffix=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['dbsuffix']);
			$author=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['author']);

			function articles(){
		     	$prod_id=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['prod_id']);
				$state_id=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['state_id']);
				if(isset($_REQUEST['type']))
				{
					$not_type=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['type']);
				}
				$text=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['text']);
				$topic=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['topic']);
				$fromDate=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['fromDate']);
				$toDate=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['toDate']);
				$dbsuffix=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['dbsuffix']);
				$author=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['author']);

				$query = "SELECT *,article_id 'id',DATE_FORMAT( article_date, GET_FORMAT( DATE, 'EUR' ) )  'Date' FROM $dbsuffix";
	     		$conditions = array();
	     		//$conditions[] ="a.sub_prod_id = '".$result['sub_prod_id']."'";
			    if($author!='0') {
			      $conditions[]= "author='$author'";
			    }
			    if(! empty($text)) {
			    	$rep_data=shortForm($text,'','');
			      $conditions[] = "(summary LIKE '%$text%') OR (summary LIKE '%$rep_data[0]%') ";
			    }
			    if(! empty($topic)) {
			    	$rep_data=shortForm($topic,'','');
			      $conditions[] = "(summary LIKE '%$topic%') OR (summary LIKE '%$rep_data[0]%')";
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
			    //print_r($conditions);
			    if (count($conditions) > 0) {
			      return $sql .= " WHERE " . implode(' AND ', $conditions);
			    }else{
			    	return $sql;
			    }
			}
		}

		if($_REQUEST['pagename']=='news'){
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
			    	$conditions[] = "(SELECT *,feature_id 'id',DATE_FORMAT( feature_date, GET_FORMAT( DATE, 'EUR' ) )  'Date' FROM $dbsuffix WHERE `subject` LIKE '%$text%' AND `summary` LIKE '%$text%') as a WHERE a.`subject` LIKE '%$filter_text%' AND a.`summary` LIKE '%$filter_text%'";
			    }
			    else if(!empty($text)){
			    	$rep_data=shortForm($text,'','');
			    	$conditions[] = "$dbsuffix WHERE (`subject` LIKE '%$text%' AND `summary` LIKE '%$text%') OR(`subject` LIKE '%$rep_data[0]%' AND `summary` LIKE '%$rep_data[0]%')";
			    }
			    else if(!empty($filter_text)){
			    	$rep_data=shortForm($text,'','');
			    	$conditions[] = "$dbsuffix WHERE (`subject` LIKE '%$filter_text%' AND `summary` LIKE '%$filter_text%') OR (`subject` LIKE '%$rep_data[0]%' AND `summary` LIKE '%$rep_data[0]%')";
			    }
			    
			    $sql = $query;
			    //print_r($conditions);
			    if (count($conditions) > 0) {
			      return $sql .= implode(' AND ', $conditions);
			    }else{
			    	return $sql.=$dbsuffix;
			    }
			}
		}


		if($_REQUEST['pagename']=='case'){
			//print_r($_REQUEST);
			$text=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['text']);
			function case_data(){
				$prod_id=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['prod_id']);
				$state_id=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['state_id']);
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

				$courtType=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['courtType']);
				$courtCity=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['courtCity']);
				$courtCity1=mysqli_real_escape_string($GLOBALS['con'],$_REQUEST['courtCity1']);

				// echo "SELECT * FROM `sub_product` WHERE `prod_id`='".$_REQUEST['prod_id']."' AND `sub_prod_name`='".$_REQUEST['courtType']."'";
				$getsubproduct=mysqli_query($GLOBALS['con'],"SELECT * FROM `sub_product` WHERE `prod_id`='".$_REQUEST['prod_id']."' AND `sub_prod_name`='".$_REQUEST['courtType']."'") or die(mysql_error());
				$result=mysqli_fetch_array($getsubproduct,MYSQL_ASSOC);

				$query="SELECT a.*,p.prod_name,p.dbsuffix,sp.sub_prod_name,sm.state_name FROM casedata_$dbsuffix as a LEFT JOIN product as p ON a.prod_id=p.prod_id LEFT JOIN sub_product as sp ON a.sub_prod_id=sp.sub_prod_id LEFT JOIN state_master as sm ON a.state_id=sm.state_id";
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
			    	$rep_data=shortForm($party_name);
			      $conditions[] = "(a.party_name LIKE '%$party_name%') OR (a.party_name LIKE '%$rep_data%')";
			    }
			    if(! empty($citation_no)) {
			      $conditions[] = "a.circular_no LIKE '%$citation_no%'";
			    }

			    //<--------Condition for keyword,include Keyword and Exclude Keyword--------->
			    if(! empty($text) && !empty($inc_txt) && !empty($exc_txt)) {
			    	$rep_data=shortForm($text,$inc_txt,$exc_txt);
			      	$conditions[] = "((a.cir_subject LIKE '%$text%' OR a.file_data  LIKE '%$text%' OR a.party_name LIKE '%$text%') OR (a.cir_subject LIKE '%$rep_data[0]%' OR a.file_data  LIKE '%$rep_data[0]%' OR a.party_name LIKE '%$rep_data[0]%')) AND ((a.cir_subject LIKE '%$inc_txt%' OR a.file_data  LIKE '%$inc_txt%' OR a.party_name LIKE '%$inc_txt%') OR (a.cir_subject LIKE '%$rep_data[1]%' OR a.file_data  LIKE '%$rep_data[1]%' OR a.party_name LIKE '%$rep_data[1]%')) AND ((a.cir_subject NOT LIKE '%$exc_txt%' OR a.file_data NOT LIKE '%$exc_txt%' OR a.party_name NOT LIKE '%$exc_txt%') OR (a.cir_subject NOT LIKE '%$rep_data[2]%' OR a.file_data NOT LIKE '%$rep_data[2]%' OR a.party_name NOT LIKE '%$rep_data[2]%')) ";
			    }
			    else if(! empty($text) && !empty($inc_txt)){
			    	$rep_data=shortForm($text,$inc_txt,'');
			    	$conditions[] = "((a.cir_subject LIKE '%$text%' OR a.file_data  LIKE '%$text%' OR a.party_name LIKE '%$text%') OR (a.cir_subject LIKE '%$rep_data[0]%' OR a.file_data  LIKE '%$rep_data[0]%' OR a.party_name LIKE '%$rep_data[0]%')) AND ((a.cir_subject LIKE '%$inc_txt%' OR a.file_data  LIKE '%$inc_txt%' OR a.party_name LIKE '%$inc_txt%') OR (a.cir_subject LIKE '%$rep_data[1]%' OR a.file_data  LIKE '%$rep_data[1]%' OR a.party_name LIKE '%$rep_data[1]%'))";
			    }
			    else if(! empty($text) && !empty($exc_txt)){
			    	$rep_data=shortForm($text,$exc_txt,'');
			    	$conditions[] = "((a.cir_subject LIKE '%$text%' OR a.file_data  LIKE '%$text%' OR a.party_name LIKE '%$text%') OR (a.cir_subject LIKE '%$rep_data[0]%' OR a.file_data  LIKE '%$rep_data[0]%' OR a.party_name LIKE '%$rep_data[0]%')) AND ((a.cir_subject NOT LIKE '%$exc_txt%' OR a.file_data NOT LIKE '%$exc_txt%' OR a.party_name NOT LIKE '%$exc_txt%') OR (a.cir_subject LIKE '%$rep_data[1]%' OR a.file_data  LIKE '%$rep_data[1]%' OR a.party_name LIKE '%$rep_data[1]%')) ";
			    }
			    else if(! empty($inc_txt) && !empty($exc_txt)){
			    	$rep_data=shortForm($inc_txt,$exc_txt,'');
			    	$conditions[] = "((a.cir_subject LIKE '%$inc_txt%' OR a.file_data  LIKE '%$inc_txt%' OR a.party_name LIKE '%$inc_txt%') OR (a.cir_subject LIKE '%$rep_data[0]%' OR a.file_data  LIKE '%$rep_data[0]%' OR a.party_name LIKE '%$rep_data[0]%')) AND ((a.cir_subject NOT LIKE '%$exc_txt%' OR a.file_data NOT LIKE '%$exc_txt%' OR a.party_name NOT LIKE '%$exc_txt%') OR (a.cir_subject NOT LIKE '%$rep_data[1]%' OR a.file_data NOT LIKE '%$rep_data[1]%' OR a.party_name NOT LIKE '%$rep_data[1]%')";
			    }else if(!empty($text)){
			    	$rep_data=shortForm($text,'','');
			    	$conditions[] = "(a.cir_subject LIKE '%$text%' OR a.file_data  LIKE '%$text%' OR a.party_name LIKE '%$text%') OR (a.cir_subject LIKE '%$rep_data[0]%' OR a.file_data  LIKE '%$rep_data[0]%' OR a.party_name LIKE '%$rep_data[0]%')";
			    }else if(!empty($inc_txt)){
			    	$rep_data=shortForm($inc_txt,'','');
			    	$conditions[] = "(a.cir_subject LIKE '%$inc_txt%' OR a.file_data  LIKE '%$inc_txt%' OR a.party_name LIKE '%$inc_txt%') OR(a.cir_subject LIKE '%$rep_data[0]%' OR a.file_data  LIKE '%$rep_data[0]%' OR a.party_name LIKE '%$rep_data[0]%')";
			    }else if(!empty($exc_txt)){
			    	$rep_data=shortForm($exc_txt,'','');
			    	$conditions[] = "(a.cir_subject LIKE '%$exc_txt%' OR a.file_data  LIKE '%$exc_txt%' OR a.party_name LIKE '%$exc_txt%') OR (a.cir_subject LIKE '%$rep_data[0]%' OR a.file_data  LIKE '%$rep_data[0]%' OR a.party_name LIKE '%$rep_data[0]%')";
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

	    		$sql = $query;
	    		if (count($conditions) > 0) {
			      return $sql .= " WHERE " . implode(' AND ', $conditions);
			    }else{
			    	return $sql;
			    }
			}
		}



		echo $query=$_REQUEST['function_name']($_GET);
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

	}   
	
?>
<!-- left sec start <div class="col-md-16 col-sm-16"> -->
<div class="col-md-11 col-sm-9 left-section">
    <h1><?php if(isset($_REQUEST['searchButton'])){echo $_REQUEST['pagename'].' - Advanced Search';}else{echo 'Advanced Search';}?>
  		<ol class="breadcrumb">
	        <li><a href="<?php echo $getBaseUrl; ?>">Home</a></li>
	        <li class="active"><?php if(isset($_REQUEST['searchButton'])){echo $_REQUEST['pagename'].' - Advanced Search';}else{echo 'Advanced Search';}?></li>
        </ol>

    </h1>
    <div class=" show-more">
        <a  href="<?php echo $getBaseUrl; ?>advancesearch">Advanced Search &nbsp;<i class="ion-chevron-right"></i><i class="ion-chevron-right"></i></a>
    </div>
    <div class="col-md-16">
		<?php 

			$rec_count = $count;
			$rec_limit = 19;

		echo "<div class='new-pagination'>";
		$b=0;
		for($i = 1; $i <= $rec_count; $i++) {
			$b++;
			$j = $i;
			$k = ($i - 1);
			$i +=$rec_limit;
			//echo ;
			if(($rec_count-$i)>0) {
			echo "<a  " ;
				if(($currentPage!='all')) { 
					if($k==$currentPage || ($currentPage==0) && ($i==20)) { 
						echo "class='active'"; 
					}   
				}
				echo " href='".$_SERVER['REQUEST_URI']."&&page=".$b."'>$j - $i</a>";
			} else {
			echo "<a ";
					if(($k==$currentPage) || ($rec_count <19)) { 
						echo "class='active'"; 
					}  
			echo "href='".$_SERVER['REQUEST_URI']."&&page=".$b."'>$j - $rec_count</a>";


			}		
		}

		if($rec_count >20) {
			echo "<a ";
					if($currentPage=='all'){ echo "class='active'"; }  
			echo "href='?q=".$text."&&page=".$b."'>All</a>";
		}
		
		echo "</div><div class='clear'></div>";

			if(isLogeedIn()) {
				if(mysqli_num_rows($res1)>0){
					if($_REQUEST['pagename']=="articles" || $_REQUEST['pagename']=="news"){
						while ($row=mysqli_fetch_array($res1, MYSQL_ASSOC)) {
							$encryptID = base64_encode(base64_encode($row['id']));
	                      	$author = '';
	                      	if($_REQUEST['pagename'] == 'articles') { $author = ' | '.$row['author']; }

		                     	echo "<div class='widget-box'>
		                              <h4><a href='javascript:void(0)' onclick='showFrame(\"$encryptID\",\"$dbsuffix\")'>".$row['subject']."</a> <span>".$row['Date']."".$author."</span></h4>
		                              <div class='widget-content'>";
		                              $subject=stripslashes($row['summary']);
		                              if(!$text){
											echo "<p>".$subject."</p>";
										}else{
											echo "<p>".preg_replace("/($text)/i", "<mark>$1</mark>", $subject)."</p>";	
										}
		                      	
		                      	echo "  <div class='widget-actions'><a href='javascript:void(0)' onclick='showFrame(\"$encryptID\",\"$dbsuffix\")' class='ion-android-archive' title='Click here to download the file'></a></div>";
		                      	echo "  </div> 
		                          </div>";
							}
					}else{
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
						    }else{
								echo getCircularLink($encryptID, $dataType, $circular_no);
							}	

								echo "<span style='color:#ff7808'>{$row['sub_prod_name']} </span>   <span>&nbsp; | &nbsp;</span>";
								echo "<span style='color:#58a9da'>{$row['prod_name']} </span>    ";
					       		 if(isset($row['State']) != '') {

									echo " <span>&nbsp; | &nbsp;</span><span>{$row['state_name']} </span>   ";
					       		 }
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
							if(!$text){
								echo $subject;
							}else{
								echo "<p>".preg_replace("/($text)/i", "<mark>$1</mark>", $subject)."</p>";	
							}
					        		
						    echo "</div>";
						    
						}
					}
				}
				else
				{ 
					echo '<div class="alert alert-warning always-show" ><strong>No Records Found</strong>- Please <a  href="advancesearch.php" data-effect="mfp-zoom-in">Advance Search</a> to view this page. </div>';
				}

					
			} 
			else 
			{
	  			include('loggedInError.php');
	  		}
				
	?>   
    </div> 
    <nav class="navigation pagination pagination1 fontNeuron" role="navigation">
										
		<ul class="pagination">
          	<?php if($currentPage != $firstPage) { ?>
          		<li class="page-item">
          			<a class="page-link" href="<?php echo $_SERVER['REQUEST_URI'];?>&&page=<?php echo $firstPage ?>" tabindex="-1" aria-label="Previous">
          				<span aria-hidden="true">First</span>
          			</a>
          		</li>
          	<?php } ?>
          	<?php if($currentPage >= 2) { ?>
          		<li class="page-item"><a class="page-numbers" href="<?php echo $_SERVER['REQUEST_URI'];?>&&page=<?php echo $previousPage ?>"><?php echo $previousPage ?></a></li>
          	<?php } ?>
          		<li class="page-item active"><a class="page-numbers" href="<?php echo $_SERVER['REQUEST_URI'];?>&&page=<?php echo $currentPage ?>"><?php echo $currentPage ?></a></li>
          	<?php if($currentPage != $lastPage) { ?>
          		<li class="page-item"><a class="page-numbers" href="<?php echo $_SERVER['REQUEST_URI'];?>&&page=<?php echo $nextPage ?>"><?php echo $nextPage ?></a></li>
          		<li class="page-item">
          			<a class="page-numbers" href="<?php echo $_SERVER['REQUEST_URI'];?>&&page=<?php echo $lastPage ?>" aria-label="Next">
          				<span aria-hidden="true">Last</span>
          			</a>
          		</li>
          	<?php } ?>
        </ul>
	</nav>
</div>
    <!-- left sec end -->
<?php include('footer.php') ?>



