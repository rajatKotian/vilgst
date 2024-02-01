<?php 
	$page = 'showIframe';
	include('header.php');
?>
<?php 
function getGSTNotiDropdown($fieldName, $gstType) {

$fieldType = $fieldName;

$getVal = isset($_GET[$fieldName]) ? $_GET[$fieldName] : $fieldName;

$fieldName = ($fieldName == 'noti_date' || $fieldName == 'effective_date') ? 'YEAR('.$fieldName.')' : $fieldName;


  $gstNotiSelect = '<select id="'.$fieldType.'" name="'.$fieldType.'" class="form-control" onchange="gstSelectFilter('.'\''.$fieldType.'\''.',this.value)">';
	$result = mysqli_query($GLOBALS['con'],"SELECT DISTINCT $fieldName 'field' FROM casedata_gstnoticsv WHERE UPPER(gst_type) = '$gstType' ORDER BY $fieldName");
    $gstNotiSelect .= "<option value=''>Select one</option>";
  while($row = mysqli_fetch_array($result)) {
    $gstNotiSelect .= "<option ";
       if($getVal == $row['field']) {
         $gstNotiSelect .= " selected='selected' ";  
       }     
    $gstNotiSelect .= " value='".$row['field']."'>".$row['field']."</option>";
  } 
  mysqli_free_result($result);

   $gstNotiSelect .= '</select>';
  return $gstNotiSelect;
}
?>
<style type="text/css">
	html, body {
		overflow: auto !important;
	}
	.data-summary {
	    background: #fafafa;
	    border: 1px solid #eee;
	    border-radius: 4px;		
	    -moz-border-radius: 4px;		
	    -webkit-border-radius: 4px;		
	    border-radius: 4px;		
	    font-size: 13px;

	    font-style: italic;	    

	    padding: 5px 10px;

	}

</style>
<script type="text/javascript">
	function searchtype(val) {
		if(val == 'CGST') {
			window.location.href ="gst_notifications.php?WjNOMGRIbHdaUT09=UTBkVFZBPT0=";
		} else if (val == 'IGST') {
			window.location.href ="gst_notifications.php?WjNOMGRIbHdaUT09=U1VkVFZBPT0=";
		} else {
			window.location.href ="gst_notifications.php?WjNOMGRIbHdaUT09=WVd4c2RIbHdaUT09";
		}
	}

	function gstSelectFilter(fieldName, val) {
		window.location.href = window.location.href+'&'+fieldName+'='+val;
	}
</script>

<?php  

	//$WjNOMGRIbHdaUT09 = base64_encode(base64_encode('gsttype'));
	//$gstType = base64_encode(base64_encode($_GET['gsttype']));
	// UTBkVFZBPT0=   = base64_encode(base64_encode('CGST'));
	// U1VkVFZBPT0=   = base64_encode(base64_encode('IGST'));
	// WVd4c2RIbHdaUT09 =  base64_encode(base64_encode('alltype'));
if(isset($_GET['WjNOMGRIbHdaUT09'])) {

$gstType = base64_decode(base64_decode($_GET['WjNOMGRIbHdaUT09']));

?>

<!-- left sec start <div class="col-md-16 col-sm-16"> -->

<div class="col-md-16 col-sm-16 left-section">

    <form method="post" action="" id="formDownload" name="formDownload">

		<h1> GST Notifications |  <?php echo $gstType; ?>

				<ol class="breadcrumb">

		        <li><a href="<?php echo $getBaseUrl; ?>">Home</a></li>

		        <li class="active">GST Notifications |  <?php echo $gstType; ?></li>

		  </ol>

		</h1>
		<div class="col-md-16">

		<form name="form2" method="get" class="form padding-b-15 "  enctype="multipart/form-data"> 

	     	<table style="margin-bottom: 0; float: left;">
		 		<tr>
		 			<td style="vertical-align: middle; height: 30px;">
		 				<label>GST Notications - &nbsp; </label>	
		 			</td>
		 			<td style="vertical-align: middle; height: 30px;"><em style="font-weight: normal">Powered by Consult construction</em></td>
		 			 
		 		</tr>

		 	</table>
		 	<table style="margin-bottom: 10px; float: right;">
		 		<tr>
		 			<td>
		 				<label>Select GST Category &nbsp; &nbsp; </label>	
		 			</td>
		 			<td>
		 				<select name="gstType"  id="gstType" class="form-control" onchange="searchtype(this.value)">
					            <option value="CGST" <?php  if($gstType == 'CGST'){ echo "selected=selected";}?>>CGST</option>
					          	<option value="IGST" <?php  if($gstType == 'IGST'){ echo "selected=selected";}?>>IGST</option>                       
						    </select>
		 			</td>
		 			 
		 		</tr>

		 	</table>
		 	<div class="clear"></div>
 		

	<?php	
    $moduleAccess = "false";

  	if(($_SESSION['vatAccess'] == 'Y') || ($_SESSION['STAccess'] == 'Y') || ($_SESSION['CEAccess'] == 'Y')) {
      if(($gstType == "SGST" || $gstType == "UTGST") && ($_SESSION['vatAccess'] == 'Y')) { $moduleAccess = "true"; } 
      else if(($gstType == "IGST") && ($_SESSION['STAccess'] == 'Y')) { $moduleAccess = "true"; } 
      else if(($gstType == "CGST") && ($_SESSION['CEAccess'] == 'Y')) { $moduleAccess = "true"; }  
    }

    if(isLogeedIn()) { 
    	if($_SESSION["userStatus"]=="expired") { include('expiredUserError.php'); } 
    	else if( $moduleAccess == "false" &&  $rowProduct['ProductName'] != "") { include('invalidModuleAccess.php'); } 
    	else { 
  	?>
<table class="tabulator-table">
	<tr>
		<td width="150">
			<?php  echo getGSTNotiDropdown('rate_type', $gstType); ?>
		</td>
		<td width="200">
			&nbsp;
		</td>
		<td width="75">
			<?php  echo getGSTNotiDropdown('noti_date', $gstType); ?>
		</td>
		<td width="75">
			<?php  echo getGSTNotiDropdown('effective_date', $gstType); ?>
		</td>
		<td>
			&nbsp;
		</td>
		<td width="80">
			<?php  echo getGSTNotiDropdown('chapter', $gstType); ?>
		</td>
		<td width="80">
			<?php  echo getGSTNotiDropdown('industry', $gstType); ?>
		</td>
		<td width="80">
			<?php  echo getGSTNotiDropdown('business_type', $gstType); ?>
		</td>
		<td width="80">
			<?php  echo getGSTNotiDropdown('taxpayer_type', $gstType); ?>
		</td>
	</tr>
</table>

</form>
<div id="gst-noti-grid"></div>

	<?php

	$rate_type = (isset($_GET['rate_type']) && ($_GET['rate_type'] != '')) ? " AND rate_type = '".$_GET['rate_type']."'" : '';
	$noti_date = (isset($_GET['noti_date']) && ($_GET['noti_date'] != '')) ? " AND YEAR(noti_date) = '".$_GET['noti_date']."'" : '';
	$effective_date = (isset($_GET['effective_date']) && ($_GET['effective_date'] != '')) ? " AND YEAR(effective_date) = '".$_GET['effective_date']."'" : '';
	$chapter = (isset($_GET['chapter']) && ($_GET['chapter'] != '')) ? " AND chapter = '".$_GET['chapter']."'" : '';
	$industry = (isset($_GET['industry']) && ($_GET['industry'] != '')) ? " AND industry = '".$_GET['industry']."'" : '';
	$business_type = (isset($_GET['business_type']) && ($_GET['business_type'] != '')) ? " AND business_type = '".$_GET['business_type']."'" : '';
	$taxpayer_type = (isset($_GET['taxpayer_type']) && ($_GET['taxpayer_type'] != '')) ? " AND taxpayer_type = '".$_GET['taxpayer_type']."'" : '';


	$sql = "SELECT * FROM casedata_gstnoticsv WHERE UPPER(gst_type) = '$gstType' 
			$rate_type	
			$noti_date
			$effective_date
			$chapter
			$industry
			$business_type
			$taxpayer_type
			ORDER BY data_id DESC";

	//echo $sql;
	$result = mysqli_query($GLOBALS['con'],$sql);


	$gstnotiArray = array();
    while($row = mysqli_fetch_array($result)) {
     	// echo "<tbody>
      //         <tr>";
          

         

      //     echo "<td>";
              
      //     echo "</td>";

      //     echo "<td>";
      //       $linked_rule = $row['linked_rule_CGST'];
      //       if($linked_rule != '') {
      //         $linkedRuleArray = explode(',', $linked_rule);
      //         $count = 0;              
      //         foreach($linkedRuleArray as $Rule){
      //           $keys = array_keys($linkedRuleArray);
      //           $keys = end($keys);
      //           echo "<a href=''>Rule No. ".$Rule.'</a>';  
      //           if($keys != $count) {
      //             echo ",<br>";
      //           }
      //           $count++;
      //         }
      //       }
      //     echo "</td>";

      //     echo "<td>";
      //       $linked_notification = $row['linked_notification'];
      //       if($linked_notification != '') {
      //         $linkedNotiArray = explode(',', $linked_notification);
      //         $count = 0;              
      //         foreach($linkedNotiArray as $Rule){
      //           $keys = array_keys($linkedNotiArray);
      //           $keys = end($keys);
      //           echo "<a href=''>Notication No. ".$Rule.'</a>'; 
      //           if($keys != $count) {
      //             echo ",<br>";
      //           }
      //           $count++;
      //         }
      //       }
      //     echo "</td>";

      //     echo "<td>".$row['objective']."</td>
      //           <td>".$row['industry']."</td>
      //           <td>".$row['business_type']."</td>
      //           <td>".$row['taxpayer_type']."</td>
      //         </tr>
      //       </tbody>";




$myObj['gst_type'] = "<strong>".$row['gst_type']."</strong>";

$rate_type = (strtolower($row['rate_type']) == 'rate') ? " - Rate" : '';
$noti_number = preg_split("/\//", $row['noti_no']);
$circular_no = "Notification No. ".$noti_number[0].$rate_type."";

	$sqlNoti = "SELECT data_id FROM casedata_".strtolower($row['gst_type'])." where circular_no = '".$circular_no."' $noti_date ";
	$resultNoti = mysqli_query($GLOBALS['con'],$sqlNoti);  
    $rowNoti = mysqli_fetch_array($resultNoti); 
$resultCount = mysqli_num_rows($resultNoti);
$encryptID = base64_encode(base64_encode($rowNoti['data_id']));

//echo $resultCount;
// if($resultCount == 1) {
// 	$noti_no = "r".getCircularLink($encryptID, strtolower($row['gst_type']), $circular_no);
// } else {
// 	$noti_no = "n".$circular_no;

// }
if($encryptID != '') {
	$noti_no = "<a href='javascript:void(0)' href='javascript:void(0)' onclick='showFrame(\"$encryptID\",null,\"".strtolower($row['gst_type'])."\")' >".$circular_no."</a>";
} else {
	$noti_no = $circular_no;
}

$myObj['noti_no'] = $noti_no;

$myObj['noti_date'] = date('d-m-Y', strtotime($row['noti_date']));
$myObj['effective_date'] = date('d-m-Y', strtotime($row['effective_date']));


//linked_notification
$linked_notification = $row['linked_notification'];
$linkedNotification = '';
if($linked_notification != '' ) {
	if($linked_notification != '-') {
		$linkedNotification .= 'To notification : ';
		$linkedNotiArray = explode(',', $linked_notification);
		$count = 0;
		foreach($linkedNotiArray as $notification){
		$keys = array_keys($linkedNotiArray);
		$keys = end($keys);
		$notificationVal = preg_split("/\//", $notification);
		$linkedNotification .= "".$notificationVal[0].'';
		if($keys != $count) {
		  $linkedNotification .= ", ";
		}
		$count++;
		}
		$linkedNotification .= '<br />';
	}

}

//linked_section_CGST
$linked_section_CGST = $row['linked_section_CGST'];
$linkedSectionCGST = '';
if($linked_section_CGST != '' ) {
	if( $linked_section_CGST != '-') {	
		$linkedSectionCGST .= 'To section (CGST) : ';
		$linkedSecCGSTArray = explode(',', $linked_section_CGST);
		$count = 0;
		foreach($linkedSecCGSTArray as $sectionCGST){
		$keys = array_keys($linkedSecCGSTArray);
		$keys = end($keys);
		$linkedSectionCGST .= " ".$sectionCGST.' ';
		if($keys != $count) {
		  $linkedSectionCGST .= ", ";
		}
		$count++;
		}
	   	$linkedSectionCGST .= '<br />';
   	}
}

//linked_section_IGST
$linked_section_IGST = $row['linked_section_IGST'];
$linkedSectionIGST = '';
if($linked_section_IGST != '') {
	if( $linked_section_IGST != '-') {	
		$linkedSectionIGST .= 'To section (IGST) : ';
		$linkedSecIGSTArray = explode(',', $linked_section_IGST);
		$count = 0;
		foreach($linkedSecIGSTArray as $sectionIGST){
		$keys = array_keys($linkedSecIGSTArray);
		$keys = end($keys);
		$linkedSectionIGST .= " ".$sectionIGST.' ';
		if($keys != $count) {
		  $linkedSectionIGST .= ", ";
		}
		$count++;
		}
		$linkedSectionIGST .= '<br />';
	}
}

//linked_rule_CGST
$linked_rule_CGST = $row['linked_rule_CGST'];
$linkedRuleCGST = '';
if($linked_rule_CGST != '') {
	if( $linked_rule_CGST != '-') {
		$linkedRuleCGST .= 'To Rule (CGST) : ';
		$linkedRuleCGST_Array = explode(',', $linked_rule_CGST);
		$count = 0;
		foreach($linkedRuleCGST_Array as $ruleCGST){
		$keys = array_keys($linkedRuleCGST_Array);
		$keys = end($keys);
		$linkedRuleCGST .= "".$ruleCGST.' ';
		if($keys != $count) {
		  $linkedRuleCGST .= ", ";
		}
		$count++;
		}
		$linkedRuleCGST .= '<br />';
	}
}


//linked_section
$linked_section = $row['linked_section'];
$linkedSection = '';
if($linked_section != '') {
	if($linked_section != '-') {
		$linkedSection .= 'To section : ';
		$linkedSecArray = explode(',', $linked_section);
		$count = 0;
		foreach($linkedSecArray as $section){
		$keys = array_keys($linkedSecArray);
		$keys = end($keys);
		$linkedSection .= "".$section.'';
		if($keys != $count) {
		  $linkedSection .= ", ";
		}
		$count++;
		}
		$linkedSection .= '<br />';
	}
}

$myObj['linked_notification'] = $linkedNotification.$linkedSectionCGST.$linkedSectionIGST.$linkedRuleCGST;

if($row['gst_type'] == 'CGST') {
$getChapterLink = 'http://vilgst.local/showiframe?V1Zaa1VsQlJQVDA9=TVRjNA==&datatable=cgst';
} else if($row['gst_type'] == 'IGST') {
$getChapterLink = 'http://vilgst.local/showiframe?V1Zaa1VsQlJQVDA9=TWpZPQ==&datatable=igst';

}

$myObj['chapter'] = "<a href='".$getChapterLink."' title='".$row['chapter']."' target='_blank'>".$row['chapter']."</a>";

$myObj['objective'] = "<div style='white-space:	normal' title='".$row['objective']."'>";
if(strlen($row['objective']) > 100) {
	$objectiveText = substr($row['objective'],0,100)."...";
} else {
	$objectiveText = $row['objective'];
}

$myObj['objective'] .= $objectiveText."</div>";

$myObj['industry'] = $row['industry'];
$myObj['business_type'] = $row['business_type'];
$myObj['taxpayer_type'] = $row['taxpayer_type'];

	
	array_push($gstnotiArray,$myObj);
	
  } 
  mysqli_free_result($result);
        	 
?>

			 
	<?php   
		} 
	} else {
		include('loggedInError.php');
	} 
	
} 
?>



	  	</div> 
	</form>
</div> 
<?php   include('footer.php');?>

<script type="text/javascript" src="https://momentjs.com/downloads/moment.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/tabulator/3.3.2/css/tabulator.min.css" rel="stylesheet">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tabulator/3.3.2/js/tabulator.min.js"></script>
<style type="text/css">
	.tabulator {
		font-size: 11px;
		font-family: inherit;
		border-color: #aaa; 
	}
	.tabulator a {
		text-decoration: underline;
	}
.tabulator .tabulator-header .tabulator-col {

    border-right: 1px solid #ccc;
    background: #fafafa;  }

    .tabulator .tabulator-row .tabulator-cell {
padding-left: 3px;
    padding-right: 3px;    border-right: 1px solid #ccc;
}
.tabulator .tabulator-footer {
    
    background-color: #fff;}
    .tabulator input[type="search"]{
    	border : 1px solid #ccc;
    	font-weight: normal;
    }
    .tabulator .tabulator-row.tabulator-selectable:hover {
    background-color: #ccc;
    cursor: default;
}
.tabulator .tabulator-header .tabulator-col .tabulator-col-content .tabulator-col-title {
	white-space: normal;
}
.tabulator .tabulator-header .tabulator-col.tabulator-sortable .tabulator-col-title {
	padding-right: 10px;
	    min-height: 30px;
}

.tabulator .tabulator-header .tabulator-col .tabulator-col-content .tabulator-arrow{

    top: 9px;
    right: 4px;

    border-left: 3px solid transparent;
    border-right: 3px solid transparent;

} 

table.tabulator-table {
	  border-right: 2px solid #aaa;
    background: #fafafa; 
    font-size: 11px;
		font-family: inherit;
		border-color: #aaa; 
		width: 100%
}
table.tabulator-table td {
    background: #fafafa; 
    padding: 5px;
	  border: 1px solid #ccc;
	  border-bottom: 0

}
table.tabulator-table select {
	padding: 0px;
	border-radius: 0;
	width: 90%;
	height: 20px;
    font-size: 12px;
    margin: 0 auto; 
}
</style>
<script type="text/javascript">
$(document).ready(function(){

	var dataObject = <?php echo json_encode($gstnotiArray); ?>;


$("#gst-noti-grid").tabulator({
    resizableColumns:false,
    layout:"fitColumns",
    responsiveLayout:true,
    pagination:"local",
    paginationSize:25,
   	tooltipsHeader:true,
   	headerFilterPlaceholder: "search...",
    columns:[ 
        {title:"Notification", width:150, field:"noti_no", headerFilter:"input",  formatter: "html"},
        {title:"Linked Notifications/Section/Rule", width:200, field:"linked_notification", headerFilter:"input",  formatter: "html"},
        {title:"Notification Date", width:75, field:"noti_date", headerFilter:"input", sorter:"date"},
        {title:"Effective Date", width:75, field:"effective_date", headerFilter:"input", sorter:"date"},
        {title:"Objective",  headerFilter:"input", field:"objective",formatter: "html"},
        {title:"Chapter", width:80, headerFilter:"input", field:"chapter", formatter: "html"},
        {title:"Industry", width:80, headerFilter:"input", field:"industry"},
        {title:"Business Type", width:80, headerFilter:"input", field:"business_type"},
        {title:"Taxpayer Type", width:80, headerFilter:"input", field:"taxpayer_type"}
    ] 
}); 

//load sample data into the table
$("#gst-noti-grid").tabulator("setData", dataObject);
 
});

</script>
