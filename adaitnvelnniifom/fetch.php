<?php 
	include('conn.php');

	if(isset($_GET['chapter_act'])){
	    $chapter_act = $_GET['chapter_act'];
	    $query = "SELECT * FROM coi_sections_chapter WHERE section_act_type = '".$chapter_act."'";

	    $result = mysqli_query($GLOBALS['con'],$query);
	    $records = array();
	    if($result>0){
	        echo '<option value="">Select Chapter</option>';
	        while($row = mysqli_fetch_assoc($result)){
	            $chapter_id=$row['id'];
	            $chapter_number=$row['chapter_no'];
	            $records[] = $row;
	            echo "<option value='$chapter_id'>$chapter_number</option>";
	        }
	    }
	    else{
	        echo '<option value="">Chapter not available</option>';
	    }
	    
	    mysqli_free_result($result);
	    return $records;
	}

?>