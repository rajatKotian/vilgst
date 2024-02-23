<?php 
include('conn.php');
 

$dataType = $_GET['data'];
$start = $_GET['start'];
$limit = $_GET['limit'];

$getDbRecord = getDbRecord('product', 'dbsuffix', $dataType);
$pageHead = $getDbRecord[0]['prod_name']; 
$dir = $getDbRecord[0]['filedir']; 
$prod_id = $getDbRecord[0]['prod_id'];

$tableName = 'casedata_'.$dataType;

$count = 1;			
$sql = "SELECT  data_id, file_path FROM $tableName LIMIT $start , $limit";
//$sql = "SELECT  data_id, file_path FROM $tableName WHERE data_id=7823";
$root_path = $_SERVER['DOCUMENT_ROOT']."/";

$result = mysqli_query($GLOBALS['con'],$sql);

 
	$fields_num = mysqli_num_fields($result);


	echo "<ul class='boxed-list'>";	
	
	while($row = mysqli_fetch_array($result)) {
		$data_id = $row['data_id'];
		$file_path = $row['file_path'];
		echo "<li>";
		echo "<b>".$count." | ".$data_id .' | '.$file_path."</b>"  ;

		$file_dir = pathinfo($file_path, PATHINFO_DIRNAME);
		$file_extn = pathinfo($file_path, PATHINFO_EXTENSION);
		$file_name = pathinfo($file_path, PATHINFO_FILENAME);
		if($file_extn == "pdf" || $file_extn == "doc"){
			$file_path = $file_dir."/".$file_name.".txt";
			echo "file exist : ".file_exists($root_path.$file_path);
	
		} 
		echo $root_path.$file_path;
			$searchContent = file_get_contents( $root_path.$file_path);
			//$searchContent = cleanname($searchContent);		
//print_r("--".$searchContent); 

	$content = strip_tags($searchContent);
    $realcontent = preg_replace('/\s+/',' ',$content);                  

			$search_form_data = array(
		      'data_id' => $data_id,
		      'core_tablename' => $tableName,
		      'file_content' => mysqli_real_escape_string($GLOBALS['con'],$realcontent),
		      'updated_dt' => date('Y-m-d H:i:s')
		    );
//print_r($searchContent); 
			if(dbRowInsert('casedata_search', $search_form_data)) {
				echo "Success";
			} else {
			echo "Fails";	
			}

		
		
		echo "</li>"; 
		$count++;
	}

    echo "</ul>";
 
mysqli_free_result($result);

?>
