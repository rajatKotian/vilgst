<?php 
 
  // $getBaseUrl = 'http://localhost/vilgst-invoice/';
  // $getBaseUrl = 'http://www.vatinfoline.com/';
   $getBaseUrl = 'http://www.vilgst.local/';
    // $currentUrl = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

 $loginInErrorMsg = 'This is <strong>Member Area </strong>- Please <a class="open-popup-link" href="#log-in" data-effect="mfp-zoom-in">Login</a> to view this page.';


function getBaseUrl() {
	// output: /myproject/index.php
	$currentPath = $_SERVER['PHP_SELF']; 
	
	// output: Array ( [dirname] => /myproject [basename] => index.php [extension] => php [filename] => index ) 
	$pathInfo = pathinfo($currentPath); 
	
	// output: localhost
	$hostName = $_SERVER['HTTP_HOST']; 
	
	// output: http://
	$protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https://'?'https://':'http://';
	
	// return: http://localhost/myproject/
	return $protocol.$hostName.$pathInfo['dirname']."/";
}

function encrypt_url($string) {
  $key = "VAT_123456789"; //key to encrypt and decrypts.
  $result = '';
  $test = "";
   for($i=0; $i<strlen($string); $i++) {
     $char = substr($string, $i, 1);
     $keychar = substr($key, ($i % strlen($key))-1, 1);
     $char = chr(ord($char)+ord($keychar));

     $test[$char]= ord($char)+ord($keychar);
     $result.=$char;
   }

   return urlencode(base64_encode($result));
}

function decrypt_url($string) {
    $key = "VAT_123456789"; //key to encrypt and decrypts.
    $result = '';
    $string = base64_decode(urldecode($string));
   for($i=0; $i<strlen($string); $i++) {
     $char = substr($string, $i, 1);
     $keychar = substr($key, ($i % strlen($key))-1, 1);
     $char = chr(ord($char)-ord($keychar));
     $result.=$char;
   }
   return $result;
}

function isLogeedIn() {
  if(isset($_SESSION['id'])) {
    if($_SESSION["login"]=='qwert') {
      return true;
    } else {
      return false;
    }    
  } else {
    return false;
  }
  
}

function cleanname($thename){
    
  $find[] = 'Ã¢â‚¬Å“'; // left side double smart quote
  $find[] = 'Ã¢â‚¬Â'; // right side double smart quote
  $find[] = 'Ã¢â‚¬Ëœ'; // left side single smart quote
  $find[] = 'â€™'; // left side single smart quote
  $find[] = 'â€˜'; // left side single smart quote
  $find[] = 'Ã¢â‚¬â„¢'; // right side single smart quote
  $find[] = 'Ã¢â‚¬Â¦'; // elipsis
  $find[] = 'Ã¢â‚¬â€'; // em dash
  $find[] = 'â€“'; // en dash
  $find[] = 'Ã¢â‚¬â€œ'; // en dash

  $replace[] = '"';
  $replace[] = '"';
  $replace[] = "'";
  $replace[] = "'";
  $replace[] = "'";
  $replace[] = "'";
  $replace[] = "...";
  $replace[] = "-";
  $replace[] = "-";
  $replace[] = "-";

  return stripslashes(str_replace($find, $replace, $thename));
 
}

function getDbRecord($table_name, $fieldname, $value) {

    $whereSQL = '';
    if(!empty($fieldname) && !empty($value)) {
      $whereSQL = " WHERE ".$fieldname." = '".$value."' " ;
    }

    // start the actual SQL statement
    $sql = "SELECT * FROM ".$table_name;

    // append the where statement
    $sql .= $whereSQL;

    $result = mysqli_fetch_assoc(mysqli_query($GLOBALS['con'],$sql));

   return $result;
}

function getDbRecordWhere($table_name, $where) {

    $whereSQL = '';
    if(!empty($where)) {
      $whereSQL = $where;
    }

    // start the actual SQL statement 
    $sql = "SELECT * FROM ".$table_name;

    // append the where statement
    $sql .= $whereSQL;

    $result = mysqli_query($GLOBALS['con'],$sql);

    $listingdata = array();
    while($row = mysqli_fetch_array($result))
        $listingdata[] = $row;

    return $listingdata;
}

function getRowCountByProd($prodID, $subProdId=null) {

    $getDbRecord = getDbRecord('product', 'prod_id', $prodID);
    $dataType = $getDbRecord['dbsuffix']; 

    $tableName = 'casedata_'.$dataType;

    $whereSQL = '';
    if(!empty($subProdId)) {
      $whereSQL = " WHERE sub_prod_id = ".$subProdId;
    }

    // start the actual SQL statement 
    $sql = "SELECT COUNT(*) AS 'count' FROM ".$tableName ;
    $sql .= $whereSQL;

    $rowCount = mysql_result(mysqli_query($GLOBALS['con'],$sql),0); 

    return $rowCount;
}

function getRecordByProduct($prodId, $prodType, $limit, $recordType ) {

global $getBaseUrl;

  if($prodId != '') {
    if($prodId == 1) {
      $filterByProductId = ' AND (vd.prod_id = 1 OR vd.prod_id = 7 OR vd.prod_id = 8) ';
    } else if($prodId == 2) {
      $filterByProductId = ' AND (vd.prod_id = 2 OR vd.prod_id = 9) ';
    } else if($prodId == 4) {
      $filterByProductId = ' AND (vd.prod_id = 4 OR vd.prod_id = 10) ';
    } else {
      $filterByProductId = ' AND vd.prod_id = '.$prodId;  
    } 

    
  } else {
    $filterByProductId = ' ';
  }

  if($prodType != '') {
    $filterByProductType = ' sp.sub_prod_type = "'.$prodType.'"';
  } else {
    $filterByProductType = ' sp.sub_prod_type LIKE "%" ';
  }
  
  if($recordType == 'recent') {
    $tableName = ' recent_data ';
    $tableType = '';
  } else {
    $getDbRecord = getDbRecord('product', 'prod_id', $prodId);
    $dataType = $getDbRecord['dbsuffix'];   

    $tableName = 'casedata_'.$dataType;
    $tableType = '&t='.$dataType;
  }

          $sql = "SELECT 
                      vd.data_id, 
                      DATE_FORMAT( circular_date, GET_FORMAT( DATE, 'EUR' ) ) 'Date', 
                      vd.circular_no 'Circular No', 
                      vd.new_flag 'New',
                      vd.state_id 'State',
                      p.prod_name 'ProductName', 
                      sp.sub_prod_name 'SubProductName', 
                      vd.cir_subject 'Subject',  
                      vd.file_path 'Path' 
                    FROM $tableName vd, product p, sub_product sp 
                    WHERE $filterByProductType
                    $filterByProductId 
                    AND vd.prod_id = p.prod_id 
                    AND vd.sub_prod_id = sp.sub_prod_id 
                    AND vd.active_flag = 'Y' 
                    order by vd.updated_dt DESC LIMIT 0, $limit";
 //echo $sql;
            $result = mysqli_query($GLOBALS['con'],$sql);

          while($row = mysqli_fetch_array($result)) {

            $subProduct = str_replace('Cases', '', $row['SubProductName']);

            $encryptID = base64_encode(base64_encode($row['data_id']));

            echo '<div class="widget-box updates-widget">';

             if($prodType == 'Notifications' && $prodId == '1') {

              $getStatename = mysqli_query($GLOBALS['con'],"SELECT state_name FROM state_master where state_id  = '".$row['State']."'");  
              $rowStatename = mysqli_fetch_array($getStatename);

               $stateName = ($rowStatename['state_name'] == 'Central' && $row['ProductName'] == 'SGST') ? 'Compensation Cess' : $rowStatename['state_name'];

                echo '<h4>'.$stateName.' <span>'.$subProduct.'</span></h4>';

              } else {
                echo '<h4>'.$row['ProductName'].' <span>'.$subProduct.'</span></h4>';
              } 

             echo '<div class="widget-content';

             if($row['New'] == 'Y') { echo ' new-flag'; }

             echo '">';     
              //if(isLogeedIn()) { 
                  $string = $row['Subject'];

                  if($prodType == 'Judgements') {
                    $subjectLength = strlen($string);
                          $pattern = '/(\d\d.\d\d.\d\d\d\d)/';
                    preg_match_all($pattern, $string, $matches, PREG_OFFSET_CAPTURE);
                    $CharLastPosition = $matches[0][0][1] + 13;
                  } else {
                     $CharLastPosition = 0;
                  }

                  echo "<a target='_blank' href='$getBaseUrl".''."dataDetails?V1Zaa1VsQlJQVDA9=$encryptID&type=".$prodType."".$tableType."'>".substr(cleanname($row['Subject']),$CharLastPosition,135);                
                  $subjectLength = strlen($row['Subject']);
                  if($subjectLength > 135) {
                    echo '...';
                  }
             // }    


              if($row['New'] == 'Y') { echo '<span class="badge">New</span>'; }            

                  echo '</a>
                      </div>  
                   <div class="widget-actions"> ';


              echo "<a  target='_blank' href='$getBaseUrl".''."dataDetails?V1Zaa1VsQlJQVDA9=$encryptID&type=".$prodType."".$tableType."' class='ion-android-archive' title='Click here to download the file'></a>";

        

              echo '</div>
                  </div>';

          }

          mysqli_free_result($result);

}


function getSingleRecordByProduct($recordId, $tableName) {

global $getBaseUrl;

if($tableName == "recent_data") {
  $iFrameParam = "\"recent\"";
} else {
  $iFrameParam = "null,\"".$tableName."\"";
  $tableName = 'casedata_'.$tableName;
}

          $sql = "SELECT 
                      vd.data_id, 
                      DATE_FORMAT( circular_date, GET_FORMAT( DATE, 'EUR' ) ) 'Date', 
                      vd.circular_no 'Circular No', 
                      vd.prod_id 'prodId',
                      vd.state_id 'State',                       
                      p.prod_name 'ProductName', 
                      sp.sub_prod_name 'SubProductName', 
                      sp.sub_prod_type 'SubProductType', 
                      vd.cir_subject 'Subject',  
                      vd.file_path 'Path' 
                    FROM $tableName vd, product p, sub_product sp 
                    WHERE vd.data_id ='$recordId'
                    AND vd.prod_id = p.prod_id 
                    AND vd.sub_prod_id = sp.sub_prod_id 
                    AND vd.active_flag = 'Y' ";
 
          $result = mysqli_query($GLOBALS['con'],$sql);

          while($row = mysqli_fetch_array($result)) {

            $encryptID = base64_encode(base64_encode($row['data_id']));

            echo '<div class="widget-box">';
              echo '<h4>';
              if($row['SubProductType'] != 'Judgements') {
                echo "<span class=''>&nbsp;|  {$row['Date']}</span>";
              } 
             if($row['SubProductType'] == 'Notifications' && $row['prodId'] == '1') {
               $getStatename = mysqli_query($GLOBALS['con'],"SELECT state_name FROM state_master where state_id  = '".$row['State']."'");  
               $rowStatename = mysqli_fetch_array($getStatename);

                echo ' <span class="pull-left"> '.$rowStatename['state_name'].'</span> <span> '.$row['SubProductName'].' </span>';

              } else {
                echo ' <span class="pull-left"> '.$row['ProductName'].' </span> <span> '.$row['SubProductName'].' </span>';
              } 

             
              echo '</h4>';
             echo '<div class="widget-content">';     
              //if(isLogeedIn()) { 
                  $string = $row['Subject'];

                  if($row['SubProductType'] == 'Judgements') {
                    $subjectLength = strlen($string);
                          $pattern = '/(\d\d.\d\d.\d\d\d\d)/';
                    preg_match_all($pattern, $string, $matches, PREG_OFFSET_CAPTURE);
                    $CharLastPosition = $matches[0][0][1] + 13;
                  } else {
                     $CharLastPosition = 0;
                  }

                  echo "<a href='javascript:void(0)' ";

                  if(isLogeedIn()) { 

                if(($_SESSION['vatAccess'] == 'Y') || ($_SESSION['STAccess'] == 'Y') || ($_SESSION['CEAccess'] == 'Y') || ($_SESSION['customsAccess'] == 'Y') || ($_SESSION['gstAccess'] == 'Y')) { 

                      if(($row['ProductName']== "VAT" || $row['ProductName']== "SGST" || $row['ProductName']== "UTGST") && ($_SESSION['vatAccess'] == 'Y')) {
                        
                            echo "onclick='showFrame(\"$encryptID\",$iFrameParam)' ";

                      } else if(($row['ProductName']== "SERVICE TAX" || $row['ProductName']== "IGST" ) && ($_SESSION['STAccess'] == 'Y')) {
                        
                            echo "onclick='showFrame(\"$encryptID\",$iFrameParam)' ";
                
                      } else if(($row['ProductName']== "CENTRAL EXCISE" || $row['ProductName']== "CGST" ) && ($_SESSION['CEAccess'] == 'Y')) {
                          
                            echo "onclick='showFrame(\"$encryptID\",$iFrameParam)' ";
                        
                      } else if(($row['ProductName']== "CUSTOMS" || $row['ProductName']== "DGFT") && ($_SESSION['customsAccess'] == 'Y')) {
                          
                            echo "onclick='showFrame(\"$encryptID\",$iFrameParam)' ";
                        
                      } else if(($row['ProductName']== "GOODS & SERVICES TAX") && ($_SESSION['gstAccess'] == 'Y')) {
                          
                            echo "onclick='showFrame(\"$encryptID\",$iFrameParam)' ";
                        
                      } else {
                        
                        echo "onClick='reqAccess()' ";
                      
                      }     

                    } else {

                          echo "onClick='reqAccess()' ";
                    
                    }

                  } else {
                      
                      echo "onClick='reqLogin()' ";
                   
                  }  

                  echo " >".substr(cleanname($row['Subject']),$CharLastPosition)."</a>";

                  echo ' <div class="widget-actions"><a href="javascript:void(0)" ';

              if(isLogeedIn()) { 

                if(($_SESSION['vatAccess'] == 'Y') || ($_SESSION['STAccess'] == 'Y') || ($_SESSION['CEAccess'] == 'Y') || ($_SESSION['customsAccess'] == 'Y') || ($_SESSION['gstAccess'] == 'Y')) { 

                  if(($row['ProductName']== "VAT" || $row['ProductName']== "SGST" || $row['ProductName']== "UTGST") && ($_SESSION['vatAccess'] == 'Y')) {
                    
                        echo "onclick='showFrame(\"$encryptID\",$iFrameParam)' ";

                  } else if(($row['ProductName']== "SERVICE TAX" || $row['ProductName']== "IGST" ) && ($_SESSION['STAccess'] == 'Y')) {
                    
                        echo "onclick='showFrame(\"$encryptID\",$iFrameParam)' ";
            
                  } else if(($row['ProductName']== "CENTRAL EXCISE"  || $row['ProductName']== "CGST" ) && ($_SESSION['CEAccess'] == 'Y')) {
                      
                        echo "onclick='showFrame(\"$encryptID\",$iFrameParam)' ";
                    
                  } else if(($row['ProductName']== "CUSTOMS" || $row['ProductName']== "DGFT") && ($_SESSION['customsAccess'] == 'Y')) {
                      
                        echo "onclick='showFrame(\"$encryptID\",$iFrameParam)' ";
                    
                  } else if(($row['ProductName']== "GOODS & SERVICES TAX") && ($_SESSION['gstAccess'] == 'Y')) {
                      
                        echo "onclick='showFrame(\"$encryptID\",$iFrameParam)' ";
                    
                  } else {
                    
                    echo "onClick='reqAccess()' ";
                  
                  }     

                } else {

                      echo "onClick='reqAccess()' ";
                
                }

              } else {
                  
                  echo "onClick='reqLogin()' ";
               
              }

              echo ' class="btn btn-text-icon pull-right" title="Click here to download the file"><i class="ion-android-archive"></i> Download File</a>';

              echo '</div>
                  </div> 
              </div>';

              if(isset($_GET['type'])) {
                echo '<div class=" show-more">
                      <a  class="pull-right"  target="_blank" href="'.$getBaseUrl.'showMoreData?data='.$_GET['type'].'">show more '.$_GET['type'].' &nbsp;<i class="ion-chevron-right"></i><i class="ion-chevron-right"></i></a>
                    </div>';
              }             


          }

          mysqli_free_result($result);



}

function getCircularNumber($recordId, $tableName) {

          $sql = "SELECT circular_no FROM $tableName WHERE data_id ='$recordId'"; 
          $result = mysqli_query($GLOBALS['con'],$sql);
          $row = mysqli_fetch_array($result);          
          echo $row['circular_no'];
          mysqli_free_result($result);
}

function getRecentData($prodType, $days) {

global $getBaseUrl;


  $reportafter=date('Y-m-d G:i:s' , strtotime('-'.$days.' days') );  /// This will give you before Last 5 Days

  if($prodType=='Acts') {
    $orderby = "  ORDER BY LEFT(vd.circular_no,0), 
            CAST( SUBSTRING(vd.circular_no, INSTR(vd.circular_no,  ' ' ) +1 ) AS UNSIGNED),
            vd.circular_no ";

  } else {

    $orderby = "  ORDER BY vd.circular_date DESC ";

  }

    $sql = "SELECT 
              vd.data_id, 
              DATE_FORMAT( circular_date, GET_FORMAT( DATE, 'EUR' ) ) 'Date', 
              vd.circular_no 'Circular No', 
              vd.new_flag 'New',
              vd.state_id 'State',                       
              p.prod_name 'ProductName', 
              vd.prod_id 'prodId', 
              sp.sub_prod_name 'SubProductName', 
              vd.cir_subject 'Subject',  
              vd.file_path 'Path' 
            FROM recent_data vd, product p, sub_product sp 
            WHERE sp.sub_prod_type ='$prodType'
            AND vd.prod_id = p.prod_id 
            AND vd.sub_prod_id = sp.sub_prod_id 
            AND vd.active_flag = 'Y' 
            AND vd.created_dt >=  '$reportafter'
            $orderby";

    $result = mysqli_query($GLOBALS['con'],$sql);

    if (mysqli_num_rows($result) == 0) {    
      echo "<div class='alert alert-danger'>No Data Found</div>";
    } else {

       $sqlGetProdList = "SELECT prod_name,dbsuffix FROM product"; 
          $resultGetProdList = mysqli_query($GLOBALS['con'],$sqlGetProdList);
          echo "<div class='category-tags'>";
            echo "<a href='' class='active' data-tag='all'>All</a>";
           while($resProd = mysqli_fetch_array($resultGetProdList, MYSQL_ASSOC)) {
            $prodName = ($resProd['dbsuffix'] == 'gst') ? 'Pre-GST' : $resProd['prod_name'];
            echo "<a href='' data-tag='".$resProd['dbsuffix']."'>".$prodName."</a>";
           }
           echo "</div>";

    $result = mysqli_query($GLOBALS['con'],$sql);

      while($row = mysqli_fetch_array($result)) {

      $getDbRecord = getDbRecord('product', 'prod_id', $row['prodId']);
      $dbsuffix = $getDbRecord['dbsuffix']; 

        $subProduct = str_replace('Cases', '', $row['SubProductName']);

        $encryptID = base64_encode(base64_encode($row['data_id']));

        echo '<div class="widget-box" data-catrow="'.$dbsuffix.'">';


          echo "<h4><a href='".$getBaseUrl."dataDetails?V1Zaa1VsQlJQVDA9=$encryptID'>".$row['Circular No']."</a>";
              if($prodType != 'Judgements') {
                echo "<span>&nbsp;|  {$row['Date']}</span>";
              } 
             if($prodType == 'Notifications' && ($row['prodId'] == '1' || $row['prodId'] == '7')) {
               $getStatename = mysqli_query($GLOBALS['con'],"SELECT state_name FROM state_master where state_id  = '".$row['State']."'");  
               $rowStatename = mysqli_fetch_array($getStatename);

               $stateName = ($rowStatename['state_name'] == 'Central' && $row['prodId'] == 7) ? 'Compensation Cess' : $rowStatename['state_name'];

                echo ' <span>&nbsp;| '.$subProduct.' </span> <span>&nbsp;| '.$row['ProductName'].' </span> <span> '.$stateName.' </span>';

              } else {
                echo ' <span>&nbsp;| '.$subProduct.' </span> <span> '.$row['ProductName'].' </span>';
              } 

             
              echo '</h4>';

           

         echo '<div class="widget-content">';     

               $string = $row['Subject'];
               $subjectLength = strlen($string);
               if($prodType == 'Judgements') {
                  $pattern = '/(\d\d.\d\d.\d\d\d\d)/';
                  preg_match_all($pattern, $string, $matches, PREG_OFFSET_CAPTURE);
                  $CharLastPosition = $matches[0][0][1] + 13;
                } else {
                  $CharLastPosition = 0;
                }

                if($subjectLength > 630) {
                  echo "<p>".substr(cleanname($row['Subject']),$CharLastPosition,630)."... <a href='javascript:void(0)' style='text-decoration:underline' class='readMoreSubject'>[Read more]</a></p>";
                  echo "<p style='display:none'>".substr(cleanname($row['Subject']),$CharLastPosition)." <a href='javascript:void(0)' style='text-decoration:underline' class='readLessSubject'>[Read less]</a></p>";
                } else {
                  echo "<p>{$row['Subject']}</p>";                      
                }  

              echo '
                  </div>  
               <div class="widget-actions"><a href="javascript:void(0)" ';

          if(isLogeedIn()) { 

            if(($_SESSION['vatAccess'] == 'Y') || ($_SESSION['STAccess'] == 'Y') || ($_SESSION['CEAccess'] == 'Y') || ($_SESSION['customsAccess'] == 'Y') || ($_SESSION['gstAccess'] == 'Y')) { 

              if(($row['ProductName']== "VAT" || $row['ProductName']== "SGST" || $row['ProductName']== "UTGST") && ($_SESSION['vatAccess'] == 'Y')) {
                
                    echo "onclick='showFrame(\"$encryptID\",\"recent\")' ";

              } else if(($row['ProductName']== "SERVICE TAX" || $row['ProductName']== "IGST" ) && ($_SESSION['STAccess'] == 'Y')) {
                
                    echo "onclick='showFrame(\"$encryptID\",\"recent\")' ";
        
              } else if(($row['ProductName']== "CENTRAL EXCISE" || $row['ProductName']== "CGST" ) && ($_SESSION['CEAccess'] == 'Y')) {
                  
                    echo "onclick='showFrame(\"$encryptID\",\"recent\")' ";
                
              } else if(($row['ProductName']== "CUSTOMS" || $row['ProductName']== "DGFT") && ($_SESSION['customsAccess'] == 'Y')) {
                      
                    echo "onclick='showFrame(\"$encryptID\",\"recent\")' ";
                
              } else if(($row['ProductName']== "GOODS & SERVICES TAX") && ($_SESSION['gstAccess'] == 'Y')) {
                  
                    echo "onclick='showFrame(\"$encryptID\",\"recent\")' ";
                
              } else {
                
                echo "onClick='reqAccess()' ";
              
              }     

            } else {

                  echo "onClick='reqAccess()' ";
            
            }

          } else {
              
              echo "onClick='reqLogin()' ";
           
          }

              echo ' class="btn btn-text-icon pull-right" title="Click here to download the file"><i class="ion-android-archive"></i> Download File</a>';

          
          echo '</div>
              </div>';

      }
    }
  

  mysqli_free_result($result);
}

function getProdDropdown($prod_id) {
 
  $prodSelect = '<select id="prod_id" name="prod_id" class="form-control required" >';
  $result = mysqli_query($GLOBALS['con'],"SELECT prod_id, prod_name FROM product");
  while($row = mysqli_fetch_array($result)) {
    $prodSelect .= "<option ";
      if($prod_id == $row['prod_id']) {
        $prodSelect .= " selected='selected' ";  
      }     
    $prodSelect .= " value='".$row['prod_id']."'>".$row['prod_name']."</option>";
  } 
  mysqli_free_result($result);

   $prodSelect .= '</select>';
  return $prodSelect;
}

function getDownloadIcon($encryptID, $dataType) {

  $moduleAccess = false;

  if(isLogeedIn()) {   
 
    if(($_SESSION['vatAccess'] == 'Y') || 
       ($_SESSION['STAccess'] == 'Y') || 
       ($_SESSION['CEAccess'] == 'Y') || 
       ($_SESSION['customsAccess'] == 'Y') || 
       ($_SESSION['gstAccess'] == 'Y')) { 

      if(($dataType == "vat" || $dataType == "sgst" || $dataType == "utgst") && ($_SESSION['vatAccess'] == 'Y')) {        
        $moduleAccess = true;        
      } else if(($dataType == "st" || $dataType == "igst") && ($_SESSION['STAccess'] == 'Y')) {        
        $moduleAccess = true;        
      } else if(($dataType == "ce" || $dataType == "cgst") && ($_SESSION['CEAccess'] == 'Y')) {        
        $moduleAccess = true;        
      } else if(($dataType == "cu" || $dataType == "dgft") && ($_SESSION['customsAccess'] == 'Y')) {                  
        $moduleAccess = true;                
      } else if(($dataType == "gst") && ($_SESSION['gstAccess'] == 'Y')) {                  
        $moduleAccess = true;                
      } 

      if($moduleAccess) {
        echo "<a href='javascript:void(0)' onclick='showFrame(\"$encryptID\",null,\"".$dataType."\")'  class='downloadIcon' title='Click here to download the file'></a>";
      } else {
        echo "<a href='javascript:void(0)' onClick='reqAccess()' title='Click here to download the file' class='downloadIcon'></a>";
      }
        
    } else {
      echo "<a href='javascript:void(0)' onClick='reqAccess()' title='Click here to download the file' class='downloadIcon'></a>";
    }

  } else {  
    echo "<a href='javascript:void(0)' onClick='reqLogin()' title='Click here to download the file' class='downloadIcon'></a>";
  }
 
}

function getCircularLink($encryptID, $dataType, $circular_no) {
  $moduleAccess = false;

  if(isLogeedIn()) {   
 
    if(($_SESSION['vatAccess'] == 'Y') || 
       ($_SESSION['STAccess'] == 'Y') || 
       ($_SESSION['CEAccess'] == 'Y') || 
       ($_SESSION['customsAccess'] == 'Y') || 
       ($_SESSION['gstAccess'] == 'Y')) { 

      if(($dataType == "vat" || $dataType == "sgst" || $dataType == "utgst") && ($_SESSION['vatAccess'] == 'Y')) {        
        $moduleAccess = true;        
      } else if(($dataType == "st" || $dataType == "igst") && ($_SESSION['STAccess'] == 'Y')) {        
        $moduleAccess = true;        
      } else if(($dataType == "ce" || $dataType == "cgst") && ($_SESSION['CEAccess'] == 'Y')) {        
        $moduleAccess = true;        
      } else if(($dataType == "cu" || $dataType == "dgft") && ($_SESSION['customsAccess'] == 'Y')) {                  
        $moduleAccess = true;                
      } else if(($dataType == "gst") && ($_SESSION['gstAccess'] == 'Y')) {                  
        $moduleAccess = true;                
      } 

      if($moduleAccess) {
        echo "<strong><a href='javascript:void(0)' title='Click here to download the file' onclick='showFrame(\"$encryptID\",null,\"".$dataType."\")'  >".$circular_no."</a></strong>";
      } else {
        echo "<strong onClick='reqAccess()' >".$circular_no."</strong>";  
      }
        
    } else {
      echo "<strong onClick='reqAccess()' >".$circular_no."</strong>";        
    }

  } else {  
    echo "<strong onClick='reqLogin()' >".$circular_no."</strong>";
  }
 
}

function getLoginInErrorMsg() {
  echo '<div class="notification error alert alert-warning" >This is <strong>Member Area </strong>- Please <a class="open-popup-link" href="#log-in" data-effect="mfp-zoom-in">Login</a> to view this page.

  </div>';
}

function base64url_encode($data) {
return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

function base64url_decode($data) {
return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
}
?>
