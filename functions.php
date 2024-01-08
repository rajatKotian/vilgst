<?php 
 
  //$getBaseUrl = 'https://localhost/vatinfoline/';
  // $getBaseUrl = 'https://www.vatinfoline.com/';
   $getBaseUrl = 'https://vilgst.com/';
   $getBaseUrl_org='https://vilgst.com/';
    $currentUrl = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

 $loginInErrorMsg = 'This is <strong>Member Area </strong>- Please <a class="open-popup-link" href="#log-in" data-effect="mfp-zoom-in">Login</a> to view this page.';


function getBaseUrl() {
	// output: /myproject/index.php
	$currentPath = $_SERVER['PHP_SELF']; 
	
	// output: Array ( [dirname] => /myproject [basename] => index.php [extension] => php [filename] => index ) 
	$pathInfo = pathinfo($currentPath); 
	
	// output: localhost
	$hostName = $_SERVER['HTTP_HOST']; 
	
	// output: https://
	$protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https://'?'https://':'https://';
	
	// return: https://localhost/myproject/
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
  global $con;
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
  global $con;
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
  global $con;
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
    $rowCount = mysqli_fetch_array(mysqli_query($GLOBALS['con'],$sql),MYSQLI_NUM); 

    return $rowCount;
}

function getRecordByProduct($prodId, $prodType, $limit, $recordType, $limitStart =0) {
  global $con;
    global $getBaseUrl;

    if ($prodId != '') {
        if ($prodType == 'Notifications' && $recordType == 'recent' && $prodId == 1) {
            $filterByProductId = ' AND (vd.prod_id = ' . $prodId .' OR vd.prod_id = 7 )';
        } else {
            $filterByProductId = ' AND vd.prod_id = ' . $prodId;
        }
    } else {
        $filterByProductId = ' ';
    }

    if ($prodType != '') {
        $filterByProductType = ' sp.sub_prod_type = "' . $prodType . '"';
    } else {
        $filterByProductType = ' sp.sub_prod_type LIKE "%" ';
    }

    if ($recordType == 'recent') {
        $tableName = ' recent_data ';
        $tableType = '';
    } 
    // else {
    //     $getDbRecord = getDbRecord('product', 'prod_id', $prodId);
    //     $dataType = $getDbRecord['dbsuffix'];

    //     $tableName = 'casedata_' . $dataType;
    //     $tableType = '&t=' . $dataType;
    // }

    $sql = "SELECT 
                    vd.data_id, 
                    vd.image_path, 
                    DATE_FORMAT( circular_date, GET_FORMAT( DATE, 'EUR' ) ) 'Date', 
                    vd.circular_no 'Circular No', 
                    vd.new_flag 'New',
                    vd.state_id 'State',
                    p.prod_name 'ProductName', 
                    sp.sub_prod_name 'SubProductName', 
                    vd.cir_subject 'Subject',
                    vd.single_line_title 'Title',
                    vd.file_path 'Path' 
                    FROM $tableName vd, product p, sub_product sp 
                    WHERE $filterByProductType
                    $filterByProductId 
                    AND vd.prod_id = p.prod_id 
                    AND vd.sub_prod_id = sp.sub_prod_id 
                    AND vd.active_flag = 'Y' 
                    order by vd.updated_dt DESC LIMIT $limitStart, $limit";
  //  echo $sql;die;
    $result = mysqli_query($GLOBALS['con'],$sql);
        $row_count = mysqli_num_rows($result);

    if ($row_count == 0) {
        mysqli_free_result($result);
        return 0;
    }

    while ($row = mysqli_fetch_array($result)) {
//        echo $row['data_id'];
        $subProduct = str_replace('Cases', '', $row['SubProductName']);

        $encryptID = base64_encode(base64_encode($row['data_id']));
        if ($prodType == 'Judgements') {
            echo '<div class="widget-box updates-widget updates-widget-left ">';
        } else {
            echo '<div class="widget-box updates-widget" >';
        }
        
        $p_name = 'GST';
        
        if ($prodType == 'Notifications' && $prodId == '1') {

            $getStatename = mysqli_query($GLOBALS['con'],"SELECT state_name FROM state_master where state_id  = '" . $row['State'] . "'");
            $rowStatename = mysqli_fetch_array($getStatename);

            $stateName = ($rowStatename['state_name'] == 'Central' && $row['ProductName'] == 'SGST') ? 'Compensation Cess' : $rowStatename['state_name'];

            echo '<h4>' . $stateName . ' <span>' . $subProduct . '</span></h4>';
        } elseif ($prodType == 'Judgements' && $prodId == '7') {
          echo '<h4>' . $p_name . ' <span>' . $subProduct . '</span></h4>';
        } else {
            echo '<h4>' . $row['ProductName'] . ' <span>' . $subProduct . '</span></h4>';
        }

        echo '<div class="widget-content';

        if ($row['New'] == 'Y') {
            echo ' new-flag';
        }

        echo '">';
        //if(isLogeedIn()) { 
        $string = $row['Subject'];
        $shortSubject = substr(cleanname($row['Subject']), 0, 250);
        $judgementClass = "";
        if ($prodType == 'Judgements') {
            $subjectLength = strlen($string);
            //$judgementClass="judgement";
            // $subjectLength = strlen($string);
            //       $pattern = '/(\d\d.\d\d.\d\d\d\d)/';
            // preg_match_all($pattern, $string, $matches, PREG_OFFSET_CAPTURE);
            // $CharLastPosition = $matches[0][0][1] + 13;

            $CharLastPosition = 0;
            if ($row['image_path'] != '' && $row['image_path'] != null) {
                $imgPath = $getBaseUrl . $row['image_path'];
                echo "<div style='float:left;width:140px;height:140px;display:block;'><img src='$imgPath'></div>";
            }

            $Title = ($row['Title'] != '') ? $row['Title'] : ((strlen($row['Subject']) > 250) ? $shortSubject . "..." : $shortSubject);
        } else {
            $CharLastPosition = 0;

            $Title = (strlen($row['Subject']) > 250) ? $shortSubject . "..." : $shortSubject;
        }

        echo "<a class='judgement' target='_blank' href='$getBaseUrl" . '' . "dataDetails?V1Zaa1VsQlJQVDA9=$encryptID&type=" . $prodType . "" . $tableType . "'>" . $Title;
        $subjectLength = strlen($row['Subject']);

        if ($row['New'] == 'Y') {
            echo '<span class="badge">New</span>';
        }

        echo '</a>
              </div>  
              <div class="widget-actions"> ';


//        echo "<a  target='_blank' href='$getBaseUrl" . '' . "dataDetails?V1Zaa1VsQlJQVDA9=$encryptID&type=" . $prodType . "" . $tableType . "' class='ion-android-archive' title='Click here to download the file'></a>";



        echo '</div>
                  </div>';
    }

    mysqli_free_result($result);
    return 1;
}

function getRecordByArchiveProduct($prodId, $prodType, $limit, $recordType, $limitStart =0) {
  global $con;
    global $getBaseUrl;

    if ($prodId != '') {
        if ($prodType == 'Notifications' && $recordType !== 'recent' && $prodId == 1) {
            $filterByProductId = ' AND (vd.prod_id = ' . $prodId .' OR vd.prod_id = 7 )';
        } else {
            $filterByProductId = ' AND vd.prod_id = ' . $prodId;
        }
    } else {
        $filterByProductId = ' ';
    }

    if ($prodType != '') {
        $filterByProductType = ' sp.sub_prod_type = "' . $prodType . '"';
    } else {
        $filterByProductType = ' sp.sub_prod_type LIKE "%" ';
    }

    if ($recordType !== 'recent') {
       $getDbRecord = getDbRecord('product', 'prod_id', $prodId);
        $dataType = $getDbRecord['dbsuffix'];

        $tableName = 'casedata_' . $dataType;
        $tableType = '&t=' . $dataType;
    }

    $sql = "SELECT 
                    vd.data_id, 
                    vd.image_path, 
                    DATE_FORMAT( circular_date, GET_FORMAT( DATE, 'EUR' ) ) 'Date', 
                    vd.circular_no 'Circular No', 
                    vd.new_flag 'New',
                    vd.state_id 'State',
                    p.prod_name 'ProductName', 
                    sp.sub_prod_name 'SubProductName', 
                    vd.cir_subject 'Subject',
                    vd.single_line_title 'Title',
                    vd.file_path 'Path' 
                    FROM $tableName vd, product p, sub_product sp 
                    WHERE $filterByProductType
                    $filterByProductId 
                    AND vd.prod_id = p.prod_id 
                    AND vd.sub_prod_id = sp.sub_prod_id 
                    AND vd.active_flag = 'Y'
                    AND vd.show_hide_flag = 'Y' 
                    order by vd.updated_dt DESC ";
//    echo $sql;die;
    $result = mysqli_query($GLOBALS['con'],$sql);
        $row_count = mysqli_num_rows($result);

    if ($row_count == 0) {
        mysqli_free_result($result);
        return 0;
    }
    while ($row = mysqli_fetch_array($result)) {
//        echo $row['data_id'];
        $subProduct = str_replace('Cases', '', $row['SubProductName']);

        $encryptID = base64_encode(base64_encode($row['data_id']));
        if ($prodType == 'Judgements') {
            echo '<div class="widget-boxs update-widgets updates-widget-left ">';
        } else {
            echo '<div class="widget-boxs update-widgets">';
        }
        
        $p_name = 'GST';
        
        if ($prodType == 'Notifications' && $prodId == '1') {

            $getStatename = mysqli_query($GLOBALS['con'],"SELECT state_name FROM state_master where state_id  = '" . $row['State'] . "'");
            $rowStatename = mysqli_fetch_array($getStatename);

            $stateName = ($rowStatename['state_name'] == 'Central' && $row['ProductName'] == 'SGST') ? 'Compensation Cess' : $rowStatename['state_name'];

            echo '<h4>' . $stateName . '  <span>[' . $subProduct . ']</span></h4>';
         } elseif ($prodType == 'Judgements' && $prodId == '7') {
           echo '<h4>' . $p_name . ' <span>' . $subProduct . '</span></h4>';
         } else {
            echo '<h4>' . $row['ProductName'] . '  <span>[' . $subProduct . ']</span></h4>';
        }

        echo '<div class="widget-content';

        if ($row['New'] == 'Y') {
            echo ' new-flag';
        }

        echo '">';
        //if(isLogeedIn()) { 
        $string = $row['Subject'];
        $shortSubject = substr(cleanname($row['Subject']), 0, 200);
        $judgementClass = "";
        if ($prodType == 'Judgements') {
            $subjectLength = strlen($string);
            //$judgementClass="judgement";
            // $subjectLength = strlen($string);
            //       $pattern = '/(\d\d.\d\d.\d\d\d\d)/';
            // preg_match_all($pattern, $string, $matches, PREG_OFFSET_CAPTURE);
            // $CharLastPosition = $matches[0][0][1] + 13;

            $CharLastPosition = 0;
            if ($row['image_path'] != '' && $row['image_path'] != null) {
                $imgPath = $getBaseUrl . $row['image_path'];
                echo "<div style='float:left;width:120px;height:100px;display:block;'><img src='$imgPath'></div>";
            }

            $Title = ($row['Title'] != '') ? $row['Title'] : ((strlen($row['Subject']) > 200) ? $shortSubject . "..." : $shortSubject);
        } else {
            $CharLastPosition = 0;

            $Title = (strlen($row['Subject']) > 250) ? $shortSubject . "..." : $shortSubject;
        }

        echo "<a class='judgements' target='_blank' href='$getBaseUrl" . '' . "dataDetails?V1Zaa1VsQlJQVDA9=$encryptID&type=" . $prodType . "" . $tableType . "'>" . $Title;
        $subjectLength = strlen($row['Subject']);


        if ($row['New'] == 'Y') {
            echo '<span class="badge">New</span>';
        }

        echo '</a>
              </div>  
              <div class="widget-actions"> ';


//        echo "<a  target='_blank' href='$getBaseUrl" . '' . "dataDetails?V1Zaa1VsQlJQVDA9=$encryptID&type=" . $prodType . "" . $tableType . "' class='ion-android-archive' title='Click here to download the file'></a>";



        echo '</div>
                  </div>';
    }

    mysqli_free_result($result);
    return 1;
}


function getSingleRecordByProduct($recordId, $tableName) {
  global $con;
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
               $getStatename = mysqli_query("SELECT state_name FROM state_master where state_id  = '".$row['State']."'");  
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
                          // $subjectLength = strlen($string);
                    //       $pattern = '/(\d\d.\d\d.\d\d\d\d)/';
                    // preg_match_all($pattern, $string, $matches, PREG_OFFSET_CAPTURE);
                    // $CharLastPosition = $matches[0][0][1] + 13;
                    $CharLastPosition = 0;
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
  global $con;
          $sql = "SELECT circular_no FROM $tableName WHERE data_id ='$recordId'"; 
          $result = mysqli_query($GLOBALS['con'],$sql);
          $row = mysqli_fetch_array($result);          
          echo $row['circular_no'];
          mysqli_free_result($result);
}

function getRecentData($prodType, $days) {
  global $con;
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
           while($resProd =  mysqli_fetch_array($resultGetProdList,MYSQLI_ASSOC)) {
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
               $getStatename = mysqli_query("SELECT state_name FROM state_master where state_id  = '".$row['State']."'");  
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
                //   $pattern = '/(\d\d.\d\d.\d\d\d\d)/';
                //   preg_match_all($pattern, $string, $matches, PREG_OFFSET_CAPTURE);
                //   $CharLastPosition = $matches[0][0][1] + 13;
                $CharLastPosition = 0;
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
  global $con;
  $prodSelect = '<select id="prod_id" name="prod_id" class="form-control required" >';
  $result = mysqli_query("SELECT prod_id, prod_name FROM product");
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
        echo "<p><a class='clip' style='display : none;' href='showiframe?V1Zaa1VsQlJQVDA9=".$encryptID."&datatable=".$dataType."'>".$circular_no."</a><button data-id='$encryptID' data-type='$dataType' data-val='$circular_no' class='copy-file-link  bg-navy' style='cursor: pointer;' ><i class='fa fa-link' aria-hidden='true' data-toggle='tooltip' title='Copy Link'></i></button>&nbsp;&nbsp;<strong><a href='javascript:void(0)' title='Click here to download the file' onclick='showFrame(\"$encryptID\",null,\"".$dataType."\")'  >".$circular_no."</a></strong>  ";
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

function getEmptyCircularLink($encryptID, $dataType, $circular_no) {
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
        echo "<strong><a href='javascript:void(0)' title='Click here to download the file' onclick='showFrame(\"$encryptID\",\"emptypath\",\"".$dataType."\")'  >".$circular_no."</a></strong>";
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


function getCircularLink2($encryptID, $dataType, $circular_no, $file_path) {
  global $getBaseUrl;
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
        $linkToShow = $getBaseUrl . $file_path;
        $rowtemp['perm_link'] = "showiframe?V1Zaa1VsQlJQVDA9=$encryptID&datatable=$dataType";
        // <button data-id='$encryptID' data-type='$dataType' data-val='$circular_no' bg-navy' style='cursor: pointer;' ></button>
         echo "&nbsp;<strong style='color: #ea0081;'>".$circular_no." &nbsp;&nbsp;<a class='preview' href='" . $getBaseUrl . $rowtemp['perm_link'] . "' perm-link='$linkToShow' title='Preview'><i class='fa fa-eye'></i></a></strong>  ";
         //echo "<button data-id='$encryptID' data-type='$dataType' data-val='$circular_no' class='copy-file-link  bg-navy' style='cursor: pointer;' ></button>&nbsp;<strong style='color: #ea0081;'>".$circular_no." <a class='preview' href='" . $getBaseUrl . $rowtemp['perm_link'] . "' perm-link='$linkToShow' title='Preview'><img style='width: 5%;position: relative;bottom: 27px;left: 36%;'src='images/preview.jpg'></a></strong>  ";
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

function getEmptyCircularLink2($encryptID, $dataType, $circular_no) {
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
        echo "<strong><a href='javascript:void(0)' title='Click here to download the file' onclick='showFrame2(\"$encryptID\",\"emptypath\",\"".$dataType."\")'  >".$circular_no."</a></strong>";
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


?>

<script>
var main_url='<?php echo $getBaseUrl_org;?>';

</script>
