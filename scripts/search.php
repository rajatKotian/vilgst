<style>

.searchResult
{
	width:90%;
	padding:5px;
	border-radius:5px;
	padding:5px 5px 5px 15px;
	margin:5px auto;
	border:1px solid #CCC;
	background:#faf8f4;
	line-height:20px;
	font-size:14px;
	font-weight:bold
}
.searchResult a
{
	float:right; margin-right:10px;
	font-family: "Calibri", Arial, Helvetica, sans-serif;
color: #FFF;
font-size: 15px;
font-weight: normal;
background: #862b05;
border: 0px;
-moz-border-radius: 4px;
-webkit-border-radius: 4px;
border-radius: 4px;
padding: 5px 10px;
text-shadow: 1px 1px 1px #000;
box-shadow: 1px 1px 0px #ddd;

}
.searchResult span
{
	display:block;
	font-size:12px;
	font-weight:normal;
	width:85%;
	}


</style>
<?php
//Configuration variables
//ini_set('memory_limit', '7000M');


$server_name = "http://".getenv("SERVER_NAME").":".getenv("SERVER_PORT"); //Server name; typically, no change needed
$doc_root = getenv("DOCUMENT_ROOT"); //Document root; typically, no change needed
if($_GET['searchCat']=='1')
{
	
	if($_GET['state']=='0')
	{
		$search_dir = array("/data"); //Directories to search? For example, array("/dir1","/dir1/subdir2"); entire server, array("")
	}
	else
	{
		$stateSql = "select state_name from state_master WHERE state_id = '".$_GET['state']."'";
//echo $stateSql;
		$stateResult=mysqli_query($GLOBALS['con'],$stateSql);
		
		while ($stateRow = mysqli_fetch_array($stateResult)) {
			$stateRowName =  $stateRow["state_name"];
		}
		if($_GET['year']=='0')
		{
		$search_dir = array("/data/".$stateRowName); //Directories to search? For example, array("/dir1","/dir1/subdir2"); entire server, array("")
		}
		else
		{
		$search_dir = array("/data/".$stateRowName."/".$_GET['year']); //Directories to search? For example, array("/dir1","/dir1/subdir2"); entire server, array("")
		}
	}
}
else if($_GET['searchCat']=='2')
{
	if($_GET['year']=='0')
	{
	$search_dir = array("/data/SERVICE TAX"); //Directories to search? For example, array("/dir1","/dir1/subdir2"); entire server, array("")
	}
	else
	{
	$search_dir = array("/data/SERVICE TAX/".$_GET['year']); //Directories to search? For example, array("/dir1","/dir1/subdir2"); entire server, array("")
	}
}
else if($_GET['searchCat']=='4')
{
	if($_GET['year']=='0')
	{
	$search_dir = array("/data/CENTRAL EXCISE"); //Directories to search? For example, array("/dir1","/dir1/subdir2"); entire server, array("")
	}
	else
	{
	$search_dir = array("/data/CENTRAL EXCISE/".$_GET['year']); //Directories to search? For example, array("/dir1","/dir1/subdir2"); entire server, array("")
	}
}
else if($_GET['searchCat']=='5')
{
	if($_GET['year']=='0')
	{
	$search_dir = array("/data/CUSTOMS"); //Directories to search? For example, array("/dir1","/dir1/subdir2"); entire server, array("")
	}
	else
	{
	$search_dir = array("/data/CUSTOMS/".$_GET['year']); //Directories to search? For example, array("/dir1","/dir1/subdir2"); entire server, array("")
	}
}
else if($_GET['searchCat']=='6')
{
	if($_GET['year']=='0')
	{
	$search_dir = array("/data/DGFT"); //Directories to search? For example, array("/dir1","/dir1/subdir2"); entire server, array("")
	}
	else
	{
	$search_dir = array("/data/DGFT/".$_GET['year']); //Directories to search? For example, array("/dir1","/dir1/subdir2"); entire server, array("")
	}
}
$file_skip = array("..",".","image","cgi-bin"); //Files & directories to skip?
$file_types = "txt|html|htm"; //Files types to search?
$file_hits = "10000"; //Max number of files to display that contain a search hit?
$file_terms = "5"; //Max number of search hits per file to display?
$file_bytes = "100000"; //Max number of bytes per file to search?

//print_r($server_name);
//Don't change anything below this line
?>

	  


<?php
// PHP Functions defined and used to perform search
// 1. search_form($HTTP_GET_VARS, $PHP_SELF)
// 2. search_results_title($HTTP_GET_VARS)
// 3. search_keyword_length_check($HTTP_GET_VARS)
// 4. search_files($server_name, $doc_root, $search_dir, $file_types, $file_skip, $file_hits, $file_terms, $file_bytes, $HTTP_GET_VARS)
// 5. search_no_hits($HTTP_GET_VARS, $count_hits)

//search_form(): 
function search_form($HTTP_GET_VARS, $PHP_SELF) 
{
 @$keyword=$HTTP_GET_VARS['keyword'];
 echo 

 "<input type=\"hidden\" value=\"SEARCH\" name=\"action\">",
 "<input type=\"text\" class=\"form-control\" id=\"keyword\" name=\"keyword\" size=\"26\" maxlength=\"40\" value=\"$keyword\" \> ";

}

//search_results_title(): 
function search_results_title($HTTP_GET_VARS) 
{
 @$keyword=$HTTP_GET_VARS['keyword'];
 @$action=$HTTP_GET_VARS['action'];
 if($action == "SEARCH") 
 echo 
 "<div class='alert alert-success' style='margin-top: 20px; width:100%; text-align:left'><label>Search results for :</label> '<strong>".htmlentities(stripslashes($keyword))."</strong>'</div>\n";
 

}

//search_keyword_length_check(): 
function search_keyword_length_check($HTTP_GET_VARS) 
{
 global $HTTP_GET_VARS;
 @$keyword=$HTTP_GET_VARS['keyword'];
 @$action=$HTTP_GET_VARS['action'];
 if($action == "SEARCH") 
 { 
  if(strlen($keyword)<3||strlen($keyword)>40) 
  { 
   echo "<p><font size=\"+1\" color=\"#FF6633\"><b>Invalid search <i>term</i></b></font><br><b>Please type 3 to 40 characters</b></p>";
   $HTTP_GET_VARS['action'] = "ERROR"; 
  }
 }
}

//search_files(): 
function search_files($server_name, $doc_root, $search_dir, $file_types, $file_skip, $file_hits, $file_terms, $file_bytes, $HTTP_GET_VARS) 
{
 global $count_hits;
 @$keyword=$HTTP_GET_VARS['keyword'];
 @$action=$HTTP_GET_VARS['action'];
 if($action == "SEARCH") 
 { 
 // print_r($search_dir);
// exit();
  foreach($search_dir as $dir) 
  { 
   $handle = @opendir($doc_root.$dir);
   while($file = @readdir($handle)) 
   {
    if(in_array($file, $file_skip)) {continue;}
    elseif($count_hits>=$file_hits) {break;} 
    elseif(is_dir($doc_root.$dir."/".$file)) 
    { 
     $search_dir = array("$dir/$file");
     search_files($server_name, $doc_root, $search_dir, $file_types, $file_skip, $file_hits, $file_terms, $file_bytes, $HTTP_GET_VARS); 
    }
    elseif(preg_match("/($file_types)$/i", $file)) 
    { 
     $fd=fopen($doc_root.$dir."/".$file,"r");
     $text=fread($fd, $file_bytes); 
     $keyword_html = htmlentities($keyword);
     $do=stristr($text, $keyword)||stristr($text, $keyword_html);
     if($do)
     {
      $count_hits++; 
      if(preg_match_all("=<title[^>]*>(.*)</title>=siU", $text, $title)) 
      { 
       if(!$title[1][0]) 
       $link_title="No Title"; 
       else
       $link_title=$title[1][0];  
      }
      else {$link_title="No Title";}
$pathInfo = pathinfo($file);
$filePDF =  substr($search_dir[0], 1).'/'.$pathInfo['filename'];

/*
	  	$sql1 = "SELECT * FROM vat_data where  file_path like '%".$filePDF."%'";
		echo $sql1;
	   $result1 = mysqli_query($GLOBALS['con'],$sql1);
       	
        while($row1 = mysqli_fetch_array($result1, MYSQL_ASSOC))
        {
            $circular_no =  $row1['circular_no'];
        }
	  */
	  // Static Search Start
		
		//	print_r($_POST);
	//$searchType = $_POST["searchType"];
		//$searchKeyword = $_POST["searchKeyword"];

		
	//	$month = $_GET["month"];
//	echo "%".$searchType."%";
 $searchCat = $_GET["searchCat"];
 if($searchCat == '1') { $dataType = 'vat'; }     
else if($searchCat == '2') { $dataType = 'st'; }  
else if($searchCat == '4') { $dataType = 'ce'; }  
else if($searchCat == '5') { $dataType = 'cu'; }  
else if($searchCat == '6') { $dataType = 'dgft'; } 
else if($searchCat == '3') { $dataType = 'gst'; }  

			$tableName = 'casedata_'.$dataType;
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
AND vd.file_path like '%".$filePDF."%' 
AND sp.sub_prod_type ='Notifications'
order by vd.data_id DESC ";
	
	
	//echo $sql;
	$result = mysqli_query($GLOBALS['con'],$sql);
	
	if (!$result) 
	{    
		die("There are no records found");
	}		
	$fields_num = mysqli_num_fields($result);

		
	while($row = mysqli_fetch_array($result))
	{
		$file_path = $row['Path'];
		$file_extn = strtolower(substr($file_path,-3));
						$CatgoryClass = preg_replace('/\s+/', '', $row['Statute'])."section";
		$encryptID = base64_encode(base64_encode($row['data_id']));

//		echo $file_extn;
		  echo "<div class='widget-box $CatgoryClass'>";	
		  echo "<h4>";

		  if(isset($_SESSION['user']))

      	{  

			if(($_SESSION['vatAccess'] == 'Y') || ($_SESSION['STAccess'] == 'Y') || ($_SESSION['CEAccess'] == 'Y'))
			{  
				if(($row['Statute']== "VAT") && ($_SESSION['vatAccess'] == 'Y'))
				{
	         		 echo "<strong><a href='javascript:void(0)' onclick='showFrame(\"$encryptID\",null,\"".$dataType."\")' title='Click here to download the file'>{$row['Circular No']}</a>  </strong>";
					
				}
				else if(($row['Statute']== "SERVICE TAX") && ($_SESSION['STAccess'] == 'Y'))
				{
	         		 echo "<strong><a href='javascript:void(0)' onclick='showFrame(\"$encryptID\",null,\"".$dataType."\")' title='Click here to download the file'>{$row['Circular No']}</a>  </strong>";
				}
				else if(($row['Statute']== "CENTRAL EXCISE") && ($_SESSION['CEAccess'] == 'Y'))
				{
	         		 echo "<strong><a href='javascript:void(0)' onclick='showFrame(\"$encryptID\",null,\"".$dataType."\")' title='Click here to download the file'>{$row['Circular No']}</a> </strong>";
				}
				else if(($row['Statute']== "CUSTOMS" || $row['Statute']== "DGFT") && ($_SESSION['customsAccess'] == 'Y')) 
				{
	         		 echo "<strong><a href='javascript:void(0)' onclick='showFrame(\"$encryptID\",null,\"".$dataType."\")' title='Click here to download the file'>{$row['Circular No']}</a> </strong>";
				}
				else
				{
					  echo "<strong onClick='reqAccess()' >{$row['Circular No']} </strong>";				
				}
				
			

			}
			else
			{
				  echo "<strong onClick='reqAccess()' >{$row['Circular No']} </strong>";				
			}
         }
		 else
         {  
		  echo "<strong onClick='reqLogin()' >{$row['Circular No']} </strong>";
         }
		 
		 
		echo "<span>{$row['Date']}</span>";
		
		if($row['Statute']== "VAT") {
          echo "<span>{$row['State']}  &nbsp; | &nbsp;  </span>";
		}

          echo "<span>{$row['Document Type']} &nbsp; | &nbsp; </span>";
          echo "<span>{$row['Statute']} &nbsp; | &nbsp; </span>";
          

         if(isset($_SESSION['user']))
      	{
			if(($_SESSION['vatAccess'] == 'Y') || ($_SESSION['STAccess'] == 'Y') || ($_SESSION['CEAccess'] == 'Y'))
			{  
				if(($row['Statute']== "VAT") && ($_SESSION['vatAccess'] == 'Y'))
				{
			         	 echo "<a href='javascript:void(0)' onclick='showFrame(\"$encryptID\",null,\"".$dataType."\")' title='Click here to download the file' class='downloadIcon'></a>";
					

				}
				else if(($row['Statute']== "SERVICE TAX") && ($_SESSION['STAccess'] == 'Y'))
				{

			         	 echo "<a href='javascript:void(0)' onclick='showFrame(\"$encryptID\",null,\"".$dataType."\")' title='Click here to download the file' class='downloadIcon'></a>";

	
				}
				else if(($row['Statute']== "CENTRAL EXCISE") && ($_SESSION['CEAccess'] == 'Y'))
				{
			         	 echo "<a href='javascript:void(0)' onclick='showFrame(\"$encryptID\",null,\"".$dataType."\")' title='Click here to download the file' class='downloadIcon'></a>";

				}
				else if(($row['Statute']== "CUSTOMS" || $row['Statute']== "DGFT") && ($_SESSION['customsAccess'] == 'Y')) 
				{
			         	 echo "<a href='javascript:void(0)' onclick='showFrame(\"$encryptID\",null,\"".$dataType."\")' title='Click here to download the file' class='downloadIcon'></a>";

				}
				else
				{
				 echo "<a href='javascript:void(0)' onClick='reqAccess()' class='downloadIcon' title='Click here to download the file'></a>";
				}
			

			}
			else
			{
         	 echo "<a href='javascript:void(0)' onClick='reqAccess()' class='downloadIcon' title='Click here to download the file'></a>";
			}
         }
         else
         {
          echo "<a href='javascript:void(0)' onClick='reqLogin()' class='downloadIcon' title='Click here to download the file'></a>";
         }
		   
		
        echo "</h4>";

			echo "<div class='widget-content'>";
          $extract = strip_tags($text);
      $keyword = preg_quote($keyword); 
      $keyword = str_replace("/","\/","$keyword");
      $keyword_html = preg_quote($keyword_html); 
      $keyword_html = str_replace("/","\/","$keyword_html");
     // echo "<a href=\"$server_name$dir/$filePDF\" target=\"_self\">Download File</a>";
	  
	  
      if(preg_match_all("/((\s\S*){0,3})($keyword|$keyword_html)((\s?\S*){0,3})/i", $extract, $match, PREG_SET_ORDER)); 
      {
       $number=$file_terms; 
       for ($h=0;$h<$number;$h++) 
       { 
        if (!empty($match[$h][3]))
        printf("<i><b>...</b> %s</i><font color=\"#FF6633\"><b>%s</b></font><i>%s <b>...</b></i>", $match[$h][1], $match[$h][3], $match[$h][4]);
       }
      }
		  echo '</div>';
		
	    echo "</div>";

	}	

	mysqli_free_result($result); 
	  
      flush();
     }
     fclose($fd);
    }
   }
   @closedir($handle);
  }
 }
}

//search_no_hits(): 
function search_no_hits($HTTP_GET_VARS, $count_hits) 
{
 @$keyword=$HTTP_GET_VARS['keyword'];
 @$action=$HTTP_GET_VARS['action'];
 if($action == "SEARCH" && $count_hits<1) 
  echo "<div  class='alert alret-danger' style='margin-top: 20px; width:100%; text-align:left'><label>Keyword for </label> '<strong>".htmlentities(stripslashes($keyword))."</strong>' not found</div>\n";

}
?>


