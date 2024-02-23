<?php 
 
 //$getBaseUrl = 'https://localhost/vatinfolinenew/adm/';
    $getBaseUrl = 'https://www.vilgst.com/adaitnvelnniifom/';
    $currentUrl = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

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

function cleanname($thename){
    
  $find[] = 'Ã¢â‚¬Å“'; // left side double smart quote
  $find[] = 'Ã¢â‚¬Â'; // right side double smart quote
  $find[] = 'Ã¢â‚¬Ëœ'; // left side single smart quote
  $find[] = 'â€™'; // left side single smart quote
  $find[] = 'â€˜'; // left side single smart quote
  $find[] = 'Ã¢â‚¬â„¢'; // right side single smart quote
  $find[] = 'Ã¢â‚¬Â¦'; // elipsis
  $find[] = 'Ã¢â‚¬â€'; // em dash
  $find[] = 'Ã¢â‚¬â€œ'; // en dash
  $find[] = 'â€“'; // en dash
  $find[] = '�'; // en dash
  $find[] = 'â&#147'; // en dash
  $find[] = 'â'; // en dash
  $find[] = ' ? '; // en dash
  $find[] = ' ?'; // en dash
  $find[] = '? '; // en dash
 
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
  $replace[] = "";
  $replace[] = "'";
  $replace[] = "";
  $replace[] = " - ";
  $replace[] = " '";
  $replace[] = "' ";

  return stripslashes(str_replace($find, $replace, $thename));
}

function fixMSWord($string) {
    $map = Array(
        '33' => '!', '34' => '"', '35' => '#', '36' => '$', '37' => '%', '38' => '&', '39' => "'", '40' => '(', '41' => ')', '42' => '*', 
        '43' => '+', '44' => ',', '45' => '-', '46' => '.', '47' => '/', '48' => '0', '49' => '1', '50' => '2', '51' => '3', '52' => '4', 
        '53' => '5', '54' => '6', '55' => '7', '56' => '8', '57' => '9', '58' => ':', '59' => ';', '60' => '<', '61' => '=', '62' => '>', 
        '63' => '?', '64' => '@', '65' => 'A', '66' => 'B', '67' => 'C', '68' => 'D', '69' => 'E', '70' => 'F', '71' => 'G', '72' => 'H', 
        '73' => 'I', '74' => 'J', '75' => 'K', '76' => 'L', '77' => 'M', '78' => 'N', '79' => 'O', '80' => 'P', '81' => 'Q', '82' => 'R', 
        '83' => 'S', '84' => 'T', '85' => 'U', '86' => 'V', '87' => 'W', '88' => 'X', '89' => 'Y', '90' => 'Z', '91' => '[', '92' => '\\', 
        '93' => ']', '94' => '^', '95' => '_', '96' => '`', '97' => 'a', '98' => 'b', '99' => 'c', '100'=> 'd', '101'=> 'e', '102'=> 'f', 
        '103'=> 'g', '104'=> 'h', '105'=> 'i', '106'=> 'j', '107'=> 'k', '108'=> 'l', '109'=> 'm', '110'=> 'n', '111'=> 'o', '112'=> 'p', 
        '113'=> 'q', '114'=> 'r', '115'=> 's', '116'=> 't', '117'=> 'u', '118'=> 'v', '119'=> 'w', '120'=> 'x', '121'=> 'y', '122'=> 'z', 
        '123'=> '{', '124'=> '|', '125'=> '}', '126'=> '~', '127'=> ' ', '128'=> '&#8364;', '129'=> ' ', '130'=> ',', '131'=> ' ', '132'=> '"', 
        '133'=> '.', '134'=> ' ', '135'=> ' ', '136'=> '^', '137'=> ' ', '138'=> ' ', '139'=> '<', '140'=> ' ', '141'=> ' ', '142'=> ' ', 
        '143'=> ' ', '144'=> ' ', '145'=> "'", '146'=> "'", '147'=> '"', '148'=> '"', '149'=> '.', '150'=> '-', '151'=> '-', '152'=> '~', 
        '153'=> ' ', '154'=> ' ', '155'=> '>', '156'=> ' ', '157'=> ' ', '158'=> ' ', '159'=> ' ', '160'=> ' ', '161'=> '¡', '162'=> '¢', 
        '163'=> '£', '164'=> '¤', '165'=> '¥', '166'=> '¦', '167'=> '§', '168'=> '¨', '169'=> '©', '170'=> 'ª', '171'=> '«', '172'=> '¬', 
        '173'=> '­', '174'=> '®', '175'=> '¯', '176'=> '°', '177'=> '±', '178'=> '²', '179'=> '³', '180'=> '´', '181'=> 'µ', '182'=> '¶', 
        '183'=> '·', '184'=> '¸', '185'=> '¹', '186'=> 'º', '187'=> '»', '188'=> '¼', '189'=> '½', '190'=> '¾', '191'=> '¿', '192'=> 'À', 
        '193'=> 'Á', '194'=> 'Â', '195'=> 'Ã', '196'=> 'Ä', '197'=> 'Å', '198'=> 'Æ', '199'=> 'Ç', '200'=> 'È', '201'=> 'É', '202'=> 'Ê', 
        '203'=> 'Ë', '204'=> 'Ì', '205'=> 'Í', '206'=> 'Î', '207'=> 'Ï', '208'=> 'Ð', '209'=> 'Ñ', '210'=> 'Ò', '211'=> 'Ó', '212'=> 'Ô', 
        '213'=> 'Õ', '214'=> 'Ö', '215'=> '×', '216'=> 'Ø', '217'=> 'Ù', '218'=> 'Ú', '219'=> 'Û', '220'=> 'Ü', '221'=> 'Ý', '222'=> 'Þ', 
        '223'=> 'ß', '224'=> 'à', '225'=> 'á', '226'=> 'â', '227'=> 'ã', '228'=> 'ä', '229'=> 'å', '230'=> 'æ', '231'=> 'ç', '232'=> 'è', 
        '233'=> 'é', '234'=> 'ê', '235'=> 'ë', '236'=> 'ì', '237'=> 'í', '238'=> 'î', '239'=> 'ï', '240'=> 'ð', '241'=> 'ñ', '242'=> 'ò', 
        '243'=> 'ó', '244'=> 'ô', '245'=> 'õ', '246'=> 'ö', '247'=> '÷', '248'=> 'ø', '249'=> 'ù', '250'=> 'ú', '251'=> 'û', '252'=> 'ü', 
        '253'=> 'ý', '254'=> 'þ', '255'=> 'ÿ'
    );

    $search = Array();
    $replace = Array();

    foreach ($map as $s => $r) {
        $search[] = chr((int)$s);
        $replace[] = $r;
    }

    return str_replace($search, $replace, $string); 
}

function get_url($url) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_ENCODING, 'gzip');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $data = curl_exec($curl);

    curl_close($curl);

    return $data;
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


function dbRowInsert($table_name, $form_data)
{
    // retrieve the keys of the array (column titles)
    $fields = array_keys($form_data);

    // build the query
    $sql = "INSERT INTO ".$table_name."
    (`".implode('`,`', $fields)."`)
    VALUES('".implode("','", $form_data)."')";
    
    // run and return the query result resource
    //return mysqli_query($GLOBALS['con'],$sql);
    $a=mysqli_query($GLOBALS['con'],$sql);
    if(! $a ) {
      die('Could not enter data: ' . mysql_error());
   }
   else{return $a;}
}


// the where clause is left optional incase the user wants to delete every row!
function dbRowDelete($table_name, $where_clause='')
{
    // check for optional where clause
    $whereSQL = '';
    if(!empty($where_clause))
    {
        // check to see if the 'where' keyword exists
        if(substr(strtoupper(trim($where_clause)), 0, 5) != 'WHERE')
        {
            // not found, add keyword
            $whereSQL = " WHERE ".$where_clause;
        } else
        {
            $whereSQL = " ".trim($where_clause);
        }
    }
    // build the query
    $sql = "DELETE FROM ".$table_name.$whereSQL;

    // run and return the query result resource
    return mysqli_query($GLOBALS['con'],$sql);
}

// again where clause is left optional
function dbRowUpdate($table_name, $form_data, $where_clause='')
{
    // check for optional where clause
    $whereSQL = '';
    if(!empty($where_clause))
    {
        // check to see if the 'where' keyword exists
        if(substr(strtoupper(trim($where_clause)), 0, 5) != 'WHERE')
        {
            // not found, add key word
            $whereSQL = " WHERE ".$where_clause;
        } else
        {
            $whereSQL = " ".trim($where_clause);
        }
    }
    // start the actual SQL statement
    $sql = "UPDATE ".$table_name." SET ";

    // loop and build the column /
    $sets = array();
    foreach($form_data as $column => $value)
    {
         $sets[] = "`".$column."` = '".$value."'";
    }
    $sql .= implode(', ', $sets);

    // append the where statement
    $sql .= $whereSQL;

    // run and return the query result
    return mysqli_query($GLOBALS['con'],$sql);
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

    $result = mysqli_query($GLOBALS['con'],$sql);

    $listingdata = array();
    while($row = mysqli_fetch_array($result))
        $listingdata[] = $row;

    return $listingdata;
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

function getStateDropdown($state_id, $selectValue) {
 
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

function getFilePathInput($file_path,$fieldType) {
 
   if($file_path == null || $file_path == '') {
     $filePathInput = '<input type="hidden" name="'.$fieldType.'_status"  id="'.$fieldType.'_status" value="Y" />
                  <input type="file" name="'.$fieldType.'" id="'.$fieldType.'" class="form-control required" required placeholder="File Path" />';

   } else {

  $filePathInput = '<input type="hidden" name="'.$fieldType.'_status"  id="'.$fieldType.'_status" value="N" />
                  <div id="'.$fieldType.'_link_container" class="file-link-container">            
                    <a href="https://www.vatinfoline.com/'.$file_path.'" target="_blank">'.$file_path.'</a>
                    <a href="#" class="remove-file" data-status="'.$fieldType.'_status" title="remove file">X</a>
                    <input type="hidden" name="'.$fieldType.'_old" id="'.$fieldType.'_old" class="form-control" placeholder="File Path" value="'.$file_path.'"  />
                  </div>
                  <div style="display:none" id="'.$fieldType.'_input_container" class="file-input-container">
                    <input type="file" name="'.$fieldType.'" id="'.$fieldType.'" class="form-control required" required placeholder="File Path" />
                  </div>';
   }



  return $filePathInput;
}

function getProdDropdown($prod_id) {
 
  $prodSelect = '<select id="prod_id" name="prod_id" class="form-control required" >
                    <option value="">Select Product </option>';
  $result = mysqli_query($GLOBALS['con'],"SELECT prod_id, prod_name, dbsuffix FROM product");
  while($row = mysqli_fetch_array($result)) {
    $prodSelect .= "<option ";
      if($prod_id == $row['prod_id']) {
        $prodSelect .= " selected='selected' ";  
      }     
    $prodSelect .= " value='".$row['prod_id']."' data-dbsuffix='".$row['dbsuffix']."'>".$row['prod_name']."</option>";
  } 
  mysqli_free_result($result);

   $prodSelect .= '</select>';
  return $prodSelect;
}

function getSubProdDropdown($value, $prod_id) {
 
  $subProdSelect = '<select id="sub_prod_id" name="sub_prod_id" class="form-control required" >
                    <option value="">Select Sub Product </option>';

  $result = mysqli_query($GLOBALS['con'],"SELECT sub_prod_id, sub_prod_name FROM sub_product WHERE prod_id=".$prod_id);
  while($row = mysqli_fetch_array($result)) {

    if($row['sub_prod_id']== $value) {
      $subProdSelect .= "<option selected='selected' value='".$row['sub_prod_id']."'>".$row['sub_prod_name']."</option>";
    } else {
      $subProdSelect .= "<option value='".$row['sub_prod_id']."'>".$row['sub_prod_name']."</option>";
    }
  } 
  mysqli_free_result($result);

   $subProdSelect .= '</select>';
  return $subProdSelect;
}

function getNotificationTypeDropdown($value, $prod_id) {
 
  $subSubProdSelect = '<select id="notification-type" name="sub_subprod_id_hidden" class="form-control required" style="display:none" >
                       <option value="">Select Notification Type </option>';

  if($prod_id == 4 || $prod_id == 5) {
  $subSubProdSelect .= '<option value="Tariff">Tariff</option>
                        <option value="Non-Tariff">Non-Tariff</option>';
  }

  if($prod_id == 5) {
  $subSubProdSelect .= '<option value="Safeguards">Safeguards</option>
                        <option value="Anti Dumping Duty">Anti Dumping Duty</option>
                        <option value="Others">Others</option>';
  }

  if($prod_id == 7 || $prod_id == 8 || $prod_id == 9 || $prod_id == 10) {
  $subSubProdSelect .= '<option value="Notification">Notification</option>
                        <option value="Rate Notification">Rate Notification</option>';
  }
                
  $subSubProdSelect .= '</select>';

  $subSubProdSelect .= '<select id="circular-type" name="sub_subprod_id_hidden" class="form-control required" style="display:none">
                        <option value="">Select circular Type </option>
                        <option value="Circulars">Circulars</option>
                        <option value="Instructions">Instructions</option>
                      </select>';

  $subSubProdSelect .= '<input type="hidden" id="notification_value" name="notification_value" value="'.$value.'" />';

  $subSubProdSelect .= '<script> $("#circular-type, #notification-type").on("change", function() {
    var notification_type = $(this).val();
    $("#notification_value").val(notification_type);
  });</script>';

  return $subSubProdSelect;
}

function getLibDropdown($library_id) {
 
  $libType = '<select id="library_id" name="library_id" class="form-control required" >
                    <option value="">Select State</option>';

  $result = mysqli_query($GLOBALS['con'],"SELECT library_id, library_name FROM library_master");
  while($row = mysqli_fetch_array($result)) {
 

    if($row['library_id']==@$library_id) {
      $libType .= "<option selected='selected' value='".$row['library_id']."'>".$row['library_name']."</option>";
    } else {
      $libType .= "<option value='".$row['library_id']."'>".$row['library_name']."</option>";
    }
  } 
  mysqli_free_result($result);

   $libType .= '</select>';
  return $libType;
}


 
?>
