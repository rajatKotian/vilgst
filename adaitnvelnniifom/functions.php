<?php
//$getBaseUrl = 'https://localhost/vatinfolinenew/adm/';
//$getBaseUrl = 'https://vilgst/adaitnvelnniifom/';

$getBaseUrl = $common_base_url.'adaitnvelnniifom/';
$currentUrl = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";


// Get the protocol used for the current request
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';

// Get the domain name
$domain = $_SERVER['HTTP_HOST'];

// Combine the protocol and domain name to form the URL
$url = $protocol . '://' . $domain.'/';
$common_base_url=$url;

function getBaseUrl() {
    // output: /myproject/index.php
    $currentPath = $_SERVER['PHP_SELF'];

    // output: Array ( [dirname] => /myproject [basename] => index.php [extension] => php [filename] => index ) 
    $pathInfo = pathinfo($currentPath);

    // output: localhost
    $hostName = $_SERVER['HTTP_HOST'];

    // output: https://
    $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"], 0, 5)) == 'https://' ? 'https://' : 'https://';

    // return: https://localhost/myproject/
    return $protocol . $hostName . $pathInfo['dirname'] . "/";
}

function cleanname($thename) {

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
        '93' => ']', '94' => '^', '95' => '_', '96' => '`', '97' => 'a', '98' => 'b', '99' => 'c', '100' => 'd', '101' => 'e', '102' => 'f',
        '103' => 'g', '104' => 'h', '105' => 'i', '106' => 'j', '107' => 'k', '108' => 'l', '109' => 'm', '110' => 'n', '111' => 'o', '112' => 'p',
        '113' => 'q', '114' => 'r', '115' => 's', '116' => 't', '117' => 'u', '118' => 'v', '119' => 'w', '120' => 'x', '121' => 'y', '122' => 'z',
        '123' => '{', '124' => '|', '125' => '}', '126' => '~', '127' => ' ', '128' => '&#8364;', '129' => ' ', '130' => ',', '131' => ' ', '132' => '"',
        '133' => '.', '134' => ' ', '135' => ' ', '136' => '^', '137' => ' ', '138' => ' ', '139' => '<', '140' => ' ', '141' => ' ', '142' => ' ',
        '143' => ' ', '144' => ' ', '145' => "'", '146' => "'", '147' => '"', '148' => '"', '149' => '.', '150' => '-', '151' => '-', '152' => '~',
        '153' => ' ', '154' => ' ', '155' => '>', '156' => ' ', '157' => ' ', '158' => ' ', '159' => ' ', '160' => ' ', '161' => '¡', '162' => '¢',
        '163' => '£', '164' => '¤', '165' => '¥', '166' => '¦', '167' => '§', '168' => '¨', '169' => '©', '170' => 'ª', '171' => '«', '172' => '¬',
        '173' => '­', '174' => '®', '175' => '¯', '176' => '°', '177' => '±', '178' => '²', '179' => '³', '180' => '´', '181' => 'µ', '182' => '¶',
        '183' => '·', '184' => '¸', '185' => '¹', '186' => 'º', '187' => '»', '188' => '¼', '189' => '½', '190' => '¾', '191' => '¿', '192' => 'À',
        '193' => 'Á', '194' => 'Â', '195' => 'Ã', '196' => 'Ä', '197' => 'Å', '198' => 'Æ', '199' => 'Ç', '200' => 'È', '201' => 'É', '202' => 'Ê',
        '203' => 'Ë', '204' => 'Ì', '205' => 'Í', '206' => 'Î', '207' => 'Ï', '208' => 'Ð', '209' => 'Ñ', '210' => 'Ò', '211' => 'Ó', '212' => 'Ô',
        '213' => 'Õ', '214' => 'Ö', '215' => '×', '216' => 'Ø', '217' => 'Ù', '218' => 'Ú', '219' => 'Û', '220' => 'Ü', '221' => 'Ý', '222' => 'Þ',
        '223' => 'ß', '224' => 'à', '225' => 'á', '226' => 'â', '227' => 'ã', '228' => 'ä', '229' => 'å', '230' => 'æ', '231' => 'ç', '232' => 'è',
        '233' => 'é', '234' => 'ê', '235' => 'ë', '236' => 'ì', '237' => 'í', '238' => 'î', '239' => 'ï', '240' => 'ð', '241' => 'ñ', '242' => 'ò',
        '243' => 'ó', '244' => 'ô', '245' => 'õ', '246' => 'ö', '247' => '÷', '248' => 'ø', '249' => 'ù', '250' => 'ú', '251' => 'û', '252' => 'ü',
        '253' => 'ý', '254' => 'þ', '255' => 'ÿ'
    );

    $search = Array();
    $replace = Array();

    foreach ($map as $s => $r) {
        $search[] = chr((int) $s);
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
    for ($i = 0; $i < strlen($string); $i++) {
        $char = substr($string, $i, 1);
        $keychar = substr($key, ($i % strlen($key)) - 1, 1);
        $char = chr(ord($char) + ord($keychar));

        $test[$char] = ord($char) + ord($keychar);
        $result.=$char;
    }

    return urlencode(base64_encode($result));
}

function decrypt_url($string) {
    $key = "VAT_123456789"; //key to encrypt and decrypts.
    $result = '';
    $string = base64_decode(urldecode($string));
    for ($i = 0; $i < strlen($string); $i++) {
        $char = substr($string, $i, 1);
        $keychar = substr($key, ($i % strlen($key)) - 1, 1);
        $char = chr(ord($char) - ord($keychar));
        $result.=$char;
    }
    return $result;
}

function dbRowInsert($table_name, $form_data) {
    global $con;
    // retrieve the keys of the array (column titles)
    $fields = array_keys($form_data);

    // build the query
    $sql = "INSERT INTO " . $table_name . "
    (`" . implode('`,`', $fields) . "`)
    VALUES('" . implode("','", $form_data) . "')";

    // run and return the query result resource
    //return mysqli_query($GLOBALS['con'],$sql);
    $a = mysqli_query($GLOBALS['con'],$sql);
    if (!$a) {
        die('Could not enter data: ' . mysqli_error($con));
    } else {
        return $a;
    }
}

// the where clause is left optional incase the user wants to delete every row!
function dbRowDelete($table_name, $where_clause = '') {
    global $con;
    // check for optional where clause
    $whereSQL = '';
    if (!empty($where_clause)) {
        // check to see if the 'where' keyword exists
        if (substr(strtoupper(trim($where_clause)), 0, 5) != 'WHERE') {
            // not found, add keyword
            $whereSQL = " WHERE " . $where_clause;
        } else {
            $whereSQL = " " . trim($where_clause);
        }
    }
    // build the query
    $sql = "DELETE FROM " . $table_name . $whereSQL;

    // run and return the query result resource
    return mysqli_query($GLOBALS['con'],$sql);
}

// again where clause is left optional
function dbRowUpdate($table_name, $form_data, $where_clause = '') {
    global $con;
    // check for optional where clause
    $whereSQL = '';
    if (!empty($where_clause)) {
        // check to see if the 'where' keyword exists
        if (substr(strtoupper(trim($where_clause)), 0, 5) != 'WHERE') {
            // not found, add key word
            $whereSQL = " WHERE " . $where_clause;
        } else {
            $whereSQL = " " . trim($where_clause);
        }
    }
    // start the actual SQL statement
    $sql = "UPDATE " . $table_name . " SET ";

    // loop and build the column /
    $sets = array();
    foreach ($form_data as $column => $value) {
        $sets[] = "`" . $column . "` = '" . $value . "'";
    }
    $sql .= implode(', ', $sets);

    // append the where statement
    $sql .= $whereSQL;

    // run and return the query result
    return mysqli_query($GLOBALS['con'],$sql);
}

function getDbRecord($table_name, $fieldname, $value) {
    global $con;

    $whereSQL = '';
    if (!empty($fieldname) && !empty($value)) {
        $whereSQL = " WHERE " . $fieldname . " = '" . $value . "' ";
    }

    // start the actual SQL statement
    $sql = "SELECT * FROM " . $table_name;

    // append the where statement
    $sql .= $whereSQL;

    $result = mysqli_query($GLOBALS['con'],$sql);

    $listingdata = array();
    while ($row = mysqli_fetch_array($result))
        $listingdata[] = $row;

    return $listingdata;
}

function getDbRecordWhere($table_name, $where) {
    global $con;
    $whereSQL = '';
    if (!empty($where)) {
        $whereSQL = $where;
    }

    // start the actual SQL statement 
    $sql = "SELECT * FROM " . $table_name;

    // append the where statement
    $sql .= $whereSQL;

    $result = mysqli_query($GLOBALS['con'],$sql);

    $listingdata = array();
    while ($row = mysqli_fetch_array($result))
        $listingdata[] = $row;

    return $listingdata;
}


function getDbColumnWhere($table_name, $column, $where) {
    global $con;
    $whereSQL = '';
    if (!empty($where)) {
        $whereSQL = $where;
    }

    // start the actual SQL statement 
    $sql = "SELECT $column FROM " . $table_name;

    // append the where statement
    $sql .= $whereSQL;
    echo $sql;
    $result = mysqli_query($GLOBALS['con'],$sql);

    $listingdata = array();
    while ($row = mysqli_fetch_array($result))
        $listingdata[] = $row;

    return $listingdata;
}

function getStateDropdown($state_id, $selectValue) {
global $con;
    $stateSelect = '<select id="state_id" name="state_id" class="form-control required" >
                    <option value="0">Select State</option>';
    $state = $state_id;
    $result = mysqli_query($GLOBALS['con'],"SELECT state_id, state_name FROM state_master");
    while ($row = mysqli_fetch_array($result)) {
        if ($selectValue == 'statenames') {
            $value = $row['state_name'];
        } else {
            $value = $row['state_id'];
        }

        if ($row['state_name'] == @$state || $row['state_id'] == @$state) {
            $stateSelect .= "<option selected='selected' value='" . $value . "'>" . $row['state_name'] . "</option>";
        } else {
            $stateSelect .= "<option value='" . $value . "'>" . $row['state_name'] . "</option>";
        }
    }
    mysqli_free_result($result);

    $stateSelect .= '</select>';
    return $stateSelect;
}

/*
function getFilePathInput($file_path, $fieldType) {

    if ($file_path == null || $file_path == '') {
        $filePathInput = '<input type="hidden" name="' . $fieldType . '_status"  id="' . $fieldType . '_status" value="Y" />
                  <input type="file" name="' . $fieldType . '" id="' . $fieldType . '" class="form-control required" required placeholder="File Path" />';
    } else {

        $filePathInput = '<input type="hidden" name="' . $fieldType . '_status"  id="' . $fieldType . '_status" value="N" />
                  <div id="' . $fieldType . '_link_container" class="file-link-container">            
                    <a href="https://www.vatinfoline.com/' . $file_path . '" target="_blank">' . $file_path . '</a>
                    <a href="#" class="remove-file" data-status="' . $fieldType . '_status" title="remove file">X</a>
                    <input type="hidden" name="' . $fieldType . '_old" id="' . $fieldType . '_old" class="form-control" placeholder="File Path" value="' . $file_path . '"  />
                  </div>
                  <div style="display:none" id="' . $fieldType . '_input_container" class="file-input-container">
                    <input type="file" name="' . $fieldType . '" id="' . $fieldType . '" class="form-control required" required placeholder="File Path" />
                  </div>';
    }



    return $filePathInput;
}
*/

function getFilePathInput($file_path, $fieldType) {
    global $con;
    global $common_base_url;
    $required = 'required';
    
    if($fieldType=='image_path'){
        $required = '';
    }
    
    if ($file_path == null || $file_path == '') {
        $filePathInput = '<input type="hidden" name="' . $fieldType . '_status"  id="' . $fieldType . '_status" value="Y" />
                  <input type="file" name="' . $fieldType . '" id="' . $fieldType . '" class="form-control '.$required.'" "'.$required.'" placeholder="File Path" />';
    } else {

        $filePathInput = '<input type="hidden" name="' . $fieldType . '_status"  id="' . $fieldType . '_status" value="N" />
                  <div id="' . $fieldType . '_link_container" class="file-link-container">            
                    <a href="'.$common_base_url. $file_path . '" target="_blank">' . $file_path . '</a>
                    <a href="#" class="remove-file" data-status="' . $fieldType . '_status" title="remove file">X</a>
                    <input type="hidden" name="' . $fieldType . '_old" id="' . $fieldType . '_old" class="form-control" placeholder="File Path" value="' . $file_path . '"  />
                  </div>
                  <div style="display:none" id="' . $fieldType . '_input_container" class="file-input-container">
                    <input type="file" name="' . $fieldType . '" id="' . $fieldType . '" class="form-control '.$required.'" '.$required.' placeholder="File Path" />
                  </div>';
    }
    return $filePathInput;
}

function getImagePathInput($file_path, $fieldType) {
    global $common_base_url;
    $required = 'required';
    
    if($fieldType=='image_path'){
        $required = '';
    }
    
    if ($file_path == null || $file_path == '') {
        $filePathInput = '<input type="hidden" name="' . $fieldType . '_status"  id="' . $fieldType . '_status" value="Y" />
                  <input type="file" name="' . $fieldType . '" id="' . $fieldType . '" class="form-control '.$required.'" "'.$required.'" placeholder="File Path" />';
    } else {

        $filePathInput = '<input type="hidden" name="' . $fieldType . '_status"  id="' . $fieldType . '_status" value="N" />
                  <div id="' . $fieldType . '_link_container" class="file-link-container">            
                    <a href="'.$common_base_url . $file_path . '" target="_blank">' . $file_path . '</a>
                    <a href="#" class="remove-file" data-status="' . $fieldType . '_status" title="remove file">X</a>
                    <input type="hidden" name="' . $fieldType . '" id="' . $fieldType . '" class="form-control" placeholder="File Path" value="' . $file_path . '"  />
                  </div>
                  <div style="display:none" id="' . $fieldType . '_input_container" class="file-input-container">
                    <input type="file" name="' . $fieldType . '" id="' . $fieldType . '" class="form-control '.$required.'" '.$required.' placeholder="File Path" />
                  </div>';
    }
    return $filePathInput;
}

function getProdDropdown($prod_id) {
    global $con;
    global $con;
    $prodSelect = '<select id="prod_id" name="prod_id" class="form-control required" >
                    <option value="">Select Product </option>';
    $result = mysqli_query($GLOBALS['con'],"SELECT prod_id, prod_name, dbsuffix FROM product");
    while ($row = mysqli_fetch_array($result)) {
        $prodSelect .= "<option ";
        if ($prod_id == $row['prod_id']) {
            $prodSelect .= " selected='selected' ";
        }
        $prodSelect .= " value='" . $row['prod_id'] . "' data-dbsuffix='" . $row['dbsuffix'] . "'>" . $row['prod_name'] . "</option>";
    }
    mysqli_free_result($result);

    $prodSelect .= '</select>';
    return $prodSelect;
}

function getSubProdDropdown($value, $prod_id) {
    global $con;
    $subProdSelect = '<select id="sub_prod_id" name="sub_prod_id" class="form-control required" >
                    <option value="">Select Sub Product </option>';

    $result = mysqli_query($GLOBALS['con'],"SELECT sub_prod_id, sub_prod_name FROM sub_product WHERE prod_id=" . $prod_id);
    while ($row = mysqli_fetch_array($result)) {

        if ($row['sub_prod_id'] == $value) {
            $subProdSelect .= "<option selected='selected' value='" . $row['sub_prod_id'] . "'>" . $row['sub_prod_name'] . "</option>";
        } else {
            $subProdSelect .= "<option value='" . $row['sub_prod_id'] . "'>" . $row['sub_prod_name'] . "</option>";
        }
    }
    mysqli_free_result($result);

    $subProdSelect .= '</select>';
    return $subProdSelect;
}

function getNotificationTypeDropdown($value, $prod_id) {
    global $con;
    $subSubProdSelect = '<select id="notification-type" name="sub_subprod_id_hidden" class="form-control required" style="display:none" >
                       <option value="">Select Notification Type </option>';

    if ($prod_id == 4 || $prod_id == 5) {
        $subSubProdSelect .= '<option value="Tariff">Tariff</option>
                        <option value="Non-Tariff">Non-Tariff</option>';
    }

    if ($prod_id == 5) {
        $subSubProdSelect .= '<option value="Safeguards">Safeguards</option>
                        <option value="Anti Dumping Duty">Anti Dumping Duty</option>
                        <option value="Others">Others</option>';
    }

    if ($prod_id == 7 || $prod_id == 8 || $prod_id == 9 || $prod_id == 10) {
        $subSubProdSelect .= '<option  value="Notification">Notification</option>
                        <option value="Rate Notification">Rate Notification</option>';
    }

    $subSubProdSelect .= '</select>';

    $subSubProdSelect .= '<select id="circular-type" name="sub_subprod_id_hidden" class="form-control required" style="display:none">
                        <option value="">Select circular Type </option>
                        <option value="Circulars">Circulars</option>
                        <option value="Instructions">Instructions</option>
                      </select>';

    $subSubProdSelect .= '<input type="hidden" id="notification_value" name="notification_value" value="' . $value . '" />';

    $subSubProdSelect .= '<script> $("#circular-type, #notification-type").on("change", function() {
    var notification_type = $(this).val();
    $("#notification_value").val(notification_type);
  });</script>';

    return $subSubProdSelect;
}

function getLibDropdown($library_id) {
    global $con;
    $libType = '<select id="library_id" name="library_id" class="form-control required" >
                    <option value="">Select State</option>';

    $result = mysqli_query($GLOBALS['con'],"SELECT library_id, library_name FROM library_master");
    while ($row = mysqli_fetch_array($result)) {


        if ($row['library_id'] == @$library_id) {
            $libType .= "<option selected='selected' value='" . $row['library_id'] . "'>" . $row['library_name'] . "</option>";
        } else {
            $libType .= "<option value='" . $row['library_id'] . "'>" . $row['library_name'] . "</option>";
        }
    }
    mysqli_free_result($result);

    $libType .= '</select>';
    return $libType;
}

//functions added by Harshal
function isCOIChapterExists($chapter_seq_no, $chapter_name, $chapter_number, $excludeId = 0) {
    global $con;
    //checking chapter seq
    $query = "SELECT count(*) FROM coi_chapter where (chapter_seq_no = " . $chapter_seq_no . " OR 
              chapter_no = '" . $chapter_number . "' OR chapter_name='" . $chapter_name . "') AND id NOT IN ($excludeId)";

    $result = mysqli_query($GLOBALS['con'],$query);
    $record_exists = mysqli_fetch_array($result);
    $totalRecords = $record_exists[0];
    if ($totalRecords > 0) {
        //checking chapter_no
        $query1 = "SELECT count(*) FROM coi_chapter where chapter_no = '" . $chapter_number . "' AND id NOT IN ($excludeId)";
        $result1 = mysqli_query($GLOBALS['con'],$query1);
        $record_exists1 = mysqli_fetch_array($result1);
        $totalRecords1 = $record_exists1[0];

        if ($totalRecords1 > 0) {
            //checking chapter_name
            return $chapter_number;
        } else {
            $query2 = "SELECT count(*) FROM coi_chapter where chapter_name='" . $chapter_name . "' AND id NOT IN ($excludeId)";
            $result2 = mysqli_query($GLOBALS['con'],$query2);
            $record_exists2 = mysqli_fetch_array($result2);
            $totalRecords2 = $record_exists2[0];
            if ($totalRecords2 > 0) {
                return $chapter_name;
            } else {
                //chapter seq exists
                return $chapter_seq_no;
            }
        }
    }
    mysqli_free_result($result);
    mysqli_free_result($result1);
    mysqli_free_result($result2);

    return null;
}

function isCOISectionChapterExists($chapter_seq_no, $chapter_name, $chapter_number, $chapter_act_type, $excludeId = 0) {
    global $con;
    //checking chapter seq
    $query = "SELECT count(*) FROM coi_sections_chapter)";

    $result = mysqli_query($GLOBALS['con'],$query);
    $record_exists = mysqli_fetch_array($result);
    $totalRecords = $record_exists[0];
    if ($record_exists['section_act_type'] == 'LIMITATION') {
        //checking chapter_no
        $query1 = "SELECT count(*) FROM coi_sections_chapter where chapter_no='" . $chapter_number . "' AND id NOT IN ($excludeId)";
        $result1 = mysqli_query($GLOBALS['con'],$query1);
        $record_exists1 = mysqli_fetch_array($result1);
        $totalRecords1 = $record_exists1[0];

        if ($totalRecords1 > 0) {
            //checking chapter_name
            return $chapter_number;
        }
    }
    if ($record_exists['section_act_type'] == 'GENERAL') {
        //checking chapter_no
        $query2 = "SELECT count(*) FROM coi_sections_chapter where chapter_no='" . $chapter_number . "' AND id NOT IN ($excludeId)";
        $result2 = mysqli_query($GLOBALS['con'],$query2);
        $record_exists2 = mysqli_fetch_array($result2);
        $totalRecords2 = $record_exists2[0];

        if ($totalRecords2 > 0) {
            //checking chapter_name
            return $chapter_number;
        }
    }
    if ($record_exists['section_act_type'] == 'TRANSFER') {
        //checking chapter_no
        $query3 = "SELECT count(*) FROM coi_sections_chapter where chapter_no='" . $chapter_number . "' AND id NOT IN ($excludeId)";
        $result3 = mysqli_query($GLOBALS['con'],$query3);
        $record_exists3 = mysqli_fetch_array($result3);
        $totalRecords3 = $record_exists3[0];

        if ($totalRecords3 > 0) {
            //checking chapter_name
            return $chapter_number;
        }
    }
    if ($record_exists['section_act_type'] == 'SALE') {
        //checking chapter_no
        $query4 = "SELECT count(*) FROM coi_sections_chapter where chapter_no='" . $chapter_number . "' AND id NOT IN ($excludeId)";
        $result4 = mysqli_query($GLOBALS['con'],$query4);
        $record_exists4 = mysqli_fetch_array($result4);
        $totalRecords4 = $record_exist41[0];

        if ($totalRecords4 > 0) {
            //checking chapter_name
            return $chapter_number;
        }
    }
    if ($record_exists['section_act_type'] == 'INDIAN') {
        //checking chapter_no
        $query5 = "SELECT count(*) FROM coi_sections_chapter where chapter_no='" . $chapter_number . "' AND id NOT IN ($excludeId)";
        $result5 = mysqli_query($GLOBALS['con'],$query5);
        $record_exists5 = mysqli_fetch_array($result5);
        $totalRecords5 = $record_exists5[0];

        if ($totalRecords5 > 0) {
            //checking chapter_name
            return $chapter_number;
        }
    }
    mysqli_free_result($result);
    mysqli_free_result($result1);
    mysqli_free_result($result2);
    mysqli_free_result($result3);
    mysqli_free_result($result4);
    mysqli_free_result($result5);

    return null;
}

//functions added by Harshal
function isCOIArticleExists($article_type, $article_seq_no, $article_name, $article_number, $chapter_id, $excludeId = 0) {
    global $con;
    //checking chapter seq
    $query = "SELECT count(*) FROM coi_articles where (article_seq_no = " . $article_seq_no . " OR 
              article_no = '" . $article_number . "' OR article_name='" . $article_name . "' ) AND article_type='$article_type' AND chapter_id=$chapter_id AND id NOT IN ($excludeId)";

    $result = mysqli_query($GLOBALS['con'],$query);
    $record_exists = mysqli_fetch_array($result);
    $totalRecords = $record_exists[0];
    if ($totalRecords > 0) {
        //checking article_no
        $query1 = "SELECT count(*) FROM coi_articles where article_no = '" . $article_number . "' AND article_type='$article_type' AND chapter_id=$chapter_id AND id NOT IN ($excludeId)";
        $result1 = mysqli_query($GLOBALS['con'],$query1);
        $record_exists1 = mysqli_fetch_array($result1);
        $totalRecords1 = $record_exists1[0];

        if ($totalRecords1 > 0) {
            //checking article_name
            return $article_number;
        } else {
            $query2 = "SELECT count(*) FROM coi_articles where article_name='" . $article_name . "' AND article_type='$article_type' AND chapter_id=$chapter_id AND id NOT IN ($excludeId)";
            $result2 = mysqli_query($GLOBALS['con'],$query2);
            $record_exists2 = mysqli_fetch_array($result2);
            $totalRecords2 = $record_exists2[0];
            if ($totalRecords2 > 0) {
                return $article_name;
            } else {
                //article seq exists
                return $article_seq_no;
            }
        }
    }
    mysqli_free_result($result);
    mysqli_free_result($result1);
    mysqli_free_result($result2);

    return null;
}

function isCOISectionExists($section_type, $section_act_type, $section_seq_no, $section_name, $section_number, $chapter_id, $excludeId = 0) {
    global $con;
    //checking chapter seq
    $query = "SELECT count(*) FROM coi_sections where (section_seq_no = " . $section_seq_no . " OR 
              section_no = '" . $section_number . "' ) AND section_type='$section_type' AND section_act_type='$section_act_type' AND chapter_id=$chapter_id AND id NOT IN ($excludeId)";

    $result = mysqli_query($GLOBALS['con'],$query);
    $record_exists = mysqli_fetch_array($result);
    $totalRecords = $record_exists[0];
    if ($totalRecords > 0) {
        //checking article_no
        $query1 = "SELECT count(*) FROM coi_sections where section_no = '" . $section_number . "' AND section_type='$section_type' AND chapter_id=$chapter_id AND id NOT IN ($excludeId)";
        $result1 = mysqli_query($GLOBALS['con'],$query1);
        $record_exists1 = mysqli_fetch_array($result1);
        $totalRecords1 = $record_exists1[0];

        if ($totalRecords1 > 0) {
            //checking article_name
            return $section_number;
        } else {
                //article seq exists
                return $section_seq_no;
            }
        //     } else {
        //     $query2 = "SELECT count(*) FROM coi_sections where section_name='" . $section_name . "' AND section_type='$section_type' AND chapter_id=$chapter_id AND id NOT IN ($excludeId)";
        //     $result2 = mysqli_query($GLOBALS['con'],$query2);
        //     $record_exists2 = mysqli_fetch_array($result2);
        //     $totalRecords2 = $record_exists2[0];
        //     if ($totalRecords2 > 0) {
        //         return $section_name;
        //     } 
        // }
    }
    mysqli_free_result($result);
    mysqli_free_result($result1);
    //mysqli_free_result($result2);

    return null;
}

function updateCOIChapter($chapter_seq_no, $chapter_name, $chapter_number, $id) {
    global $con;
    $query = "update `coi_chapter` SET 
              `chapter_seq_no` = '" . $chapter_seq_no . "', 
              `chapter_no` = '" . $chapter_number . "', 
              `chapter_name` = '" . $chapter_name . "' , 
               `updated_on` = ' NOW() ',
              `last_modified_by` = '" . $_SESSION["id"] . "'
             WHERE id  = $id;";

    $result = mysqli_query($GLOBALS['con'],$query);

    mysqli_free_result($result);
}

function updateCOISectionChapter($chapter_act_type, $chapter_seq_no, $chapter_name, $chapter_number, $id) {
    global $con;
    $query = "update `coi_sections_chapter` SET 
              `section_act_type` = '" . $chapter_act_type . "',
              `chapter_seq_no` = '" . $chapter_seq_no . "', 
              `chapter_no` = '" . $chapter_number . "', 
              `chapter_name` = '" . $chapter_name . "' , 
               `updated_on` = ' NOW() ',
              `last_modified_by` = '" . $_SESSION["id"] . "'
             WHERE id  = $id;";

    $result = mysqli_query($GLOBALS['con'],$query);

    mysqli_free_result($result);
}

function getCOIChapterbyId($id) {
    global $con;
    $query = "SELECT * FROM coi_chapter where id = " . $id;

    $result = mysqli_query($GLOBALS['con'],$query);
    $records = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $records;
}

function getCOISectionChapterbyId($id) {
    global $con;
    $query = "SELECT * FROM coi_sections_chapter where id = " . $id;

    $result = mysqli_query($GLOBALS['con'],$query);
    $records = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $records;
}

function getCOIArticlebyId($id) {
    global $con;
    $query = "SELECT * FROM coi_articles where id = " . $id;

    $result = mysqli_query($GLOBALS['con'],$query);
    $records = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $records;
}

function getCOISectionbyId($id) {
    global $con;
    $query = "SELECT * FROM coi_sections where id = " . $id;

    $result = mysqli_query($GLOBALS['con'],$query);
    $records = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $records;
}

function listCOIChapter() {
    global $con;
    $query = "SELECT * FROM coi_chapter";

    $result = mysqli_query($GLOBALS['con'],$query);
    $records = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $records[] = $row;
    };

    mysqli_free_result($result);
    return $records;
}

function listCOISectionChapter() {
    global $con;
    $query = "SELECT * FROM coi_sections_chapter";

    $result = mysqli_query($GLOBALS['con'],$query);
    $records = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $records[] = $row;
    };

    mysqli_free_result($result);
    return $records;
}

function listCOIArticles($chapter_id = 0) {
    global $con;
    $whereCond = "";
    if ($chapter_id != 0) {
        $whereCond = " WHERE ca.chapter_id in ($chapter_id)";
    }
    $query = "SELECT ca.*, cc.chapter_no FROM coi_articles ca LEFT OUTER JOIN coi_chapter cc on cc.id = ca.chapter_id $whereCond";
    $result = mysqli_query($GLOBALS['con'],$query);
    $records = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $records[] = $row;
    };

    mysqli_free_result($result);
    return $records;
}

function listCOISections($chapter_id = 0) {
    global $con;
    $whereCond = "";
    if ($chapter_id != 0) {
        $whereCond = " WHERE cs.chapter_id in ($chapter_id)";
    }
    $query = "SELECT cs.*, cc.chapter_no FROM coi_sections cs LEFT OUTER JOIN coi_sections_chapter cc on cc.id = cs.chapter_id $whereCond";
    $result = mysqli_query($GLOBALS['con'],$query);
    $records = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $records[] = $row;
    };

    mysqli_free_result($result);
    return $records;
}

function addCOIChapter($chapter_seq_no, $chapter_name, $chapter_number) {
    global $con;
    $query = "INSERT INTO `coi_chapter` (`chapter_seq_no`, `chapter_no`, `chapter_name`, `created_on`, `updated_on`, `last_modified_by`) 
              VALUES ('$chapter_seq_no', '$chapter_number','$chapter_name',  NOW(), NOW()," . $_SESSION["id"] . ");";
    $result = mysqli_query($GLOBALS['con'],$query);

    mysqli_free_result($result);
}

function addCOISectionChapter($chapter_seq_no, $chapter_name, $chapter_number, $chapter_act_type) {
    global $con;
    $query = "INSERT INTO `coi_sections_chapter` (`chapter_seq_no`, `chapter_no`, `section_act_type`, `chapter_name`, `created_on`, `updated_on`, `last_modified_by`) 
              VALUES ('$chapter_seq_no', '$chapter_number', '$chapter_act_type', '$chapter_name',  NOW(), NOW()," . $_SESSION["id"] . ");";
    $result = mysqli_query($GLOBALS['con'],$query);

    mysqli_free_result($result);
}

function cleanForDB($str) {
    global $con;
    return mysqli_real_escape_string($con,trim($str));
}

function getChapterDropDown($chapter_id, $dropDownId, $chapters_list) {
    global $con;

    $chapterSelect = '<select id="sel_chapter[' . $dropDownId . ']" name="sel_chapter[' . $dropDownId . ']" class="form-control" >
                    <option value="">Select Chapter </option>';
    $chapters_list;
    foreach ($chapters_list as $chapter) {
        $chapterSelect .= "<option ";
        if ($chapter_id == $chapter['id']) {
            $chapterSelect .= " selected='selected' ";
        }

        $chapterSelect .= " value='" . $chapter['id'] . "' data-id='" . $chapter['id'] . "'>" . strtoupper($chapter['chapter_no']) . "</option>";
    }
//    mysqli_free_result($result);

    $chapterSelect .= '</select>';
    return $chapterSelect;
}

function getSectionActDropDown($section_act_type, $dropDownId, $sections_list) {
    global $con;

    $SectionActSelect = '<select id="section_act_type[' . $dropDownId . ']" name="section_act_type[' . $dropDownId . ']" class="form-control" >
                    <option value="">Select Act </option>';
    $sections_list;
    foreach ($sections_list as $section) {
        $SectionActSelect .= "<option ";
        if ($section_act_type == $section['section_act_type']) {
            $SectionActSelect .= " selected='selected' ";
        }

        $SectionActSelect .= " value='" . $section['section_act_type'] . "' data-id='" . $section['section_act_type'] . "'>" . strtoupper($section['section_act_type']) . "</option>";
    }
//    mysqli_free_result($result);

    $SectionActSelect .= '</select>';
    return $SectionActSelect;
}

function processFile($file, $index, $chapter_id, $article_no) {
    $error_type = '';
    $success = false;
    $file_content = "";
//    print_r($file);
    if ($file['size'][$index] > 0) { // for upload file
        $filenameOnly = pathinfo(basename($file['name'][$index]), PATHINFO_FILENAME);
        $filenameExtn = pathinfo(basename($file['name'][$index]), PATHINFO_EXTENSION);

        $root_path = $_SERVER['DOCUMENT_ROOT'] . "/data/COI/";
//        echo $root_path;
        if (is_dir($root_path) == false) {
            mkdir($root_path, 0777);
            chmod($root_path, 0777);
        }


        $file_path = 'chapter_' . $chapter_id . "_article_" . $article_no . "." . $filenameExtn;
        //echo $root_path.$file_path; die();
        if (file_exists($root_path . $file_path)) {
            //unlink file and upload new one.
            unlink($root_path . $file_path);
        }
        if (!move_uploaded_file($file['tmp_name'][$index], $root_path . $file_path)) {
            //echo "hiii";
            $error_type = "file_uploaderror";
            //return true;
        } else {
            $success = true;
        }

        if ($filenameExtn == "htm" || $filenameExtn == "html") {
            //echo "hi";
            $myfile = file_get_contents($root_path . $file_path);
            $searchContent = cleanname($myfile);
            $file_data_without_html = strip_tags($searchContent);
            $file_data = preg_replace('/\s+/', ' ', $file_data_without_html);
            $file_data = preg_replace('/[^a-zA-Z0-9\s]/', '', $file_data);
        } else {
            $file_data = "";
        }
    } else {
        $error_type = "Please select file for " . $article_no;
    }

    return array('success' => $success, 'content' => $file_data, 'filename' => $file_path, 'error' => $error_type);
}

function processFilesection($file, $index, $chapter_id, $section_no) {
    $error_type = '';
    $success = false;
    $file_content = "";
    $file_size = $file['size'][$index];
    $filetmp_name = $file['tmp_name'][$index];
    $file_name = $file['name'][$index];
    $filenameOnly = pathinfo(basename($file_name), PATHINFO_FILENAME);
    $filenameExtn = pathinfo(basename($file_name), PATHINFO_EXTENSION);
    $upload_path =  "../../../data/Section/";    
    $file_path = basename($file_name);
    $filepath = $upload_path.$file_path;

    if ($file_size > 0) { // for upload file        
        if (is_dir($upload_path) == false) {
            mkdir($upload_path, 0777);
            chmod($upload_path, 0777);
        }
        if (file_exists($filepath)) {
            //unlink file and upload new one.
            unlink($filepath);
        }
        if ($filenameExtn == "htm" || $filenameExtn == "html") {
            //echo "hi";
            $myfile = file_get_contents($filepath);
            $searchContent = cleanname($myfile);
            $file_data_without_html = strip_tags($searchContent);
            $file_data = preg_replace('/\s+/', ' ', $file_data_without_html);
            $file_data = preg_replace('/[^a-zA-Z0-9\s]/', '', $file_data);
            if (!move_uploaded_file($filetmp_name, $filepath)) {
                $error_type = "file_uploaderror";
            } else {
                $success = true;
            }
        } else {
            $file_data = "";
        } 
    } else {
        $error_type = "Please select file for " . $section_no;
    }

    return array('success' => $success, 'content' => $file_data, 'filename' => $file_path, 'error' => $error_type);
}

// *COUNCIL MEETING CHAPTER SECTION START* //

function isGSTCouncilMeetingChapterExists($chapter_name, $chapter_number, $excludeId = 0) {
    global $con;
    //checking chapter seq
    $query = "SELECT count(*) FROM gst_council_meeting_chapter where (chapter_no = '" . $chapter_number . "') AND id NOT IN ($excludeId)";

    $result = mysqli_query($GLOBALS['con'],$query);
    $record_exists = mysqli_fetch_array($result);
    $totalRecords = $record_exists[0];
    if ($totalRecords > 0) {
        // checking chapter_no
        $query1 = "SELECT count(*) FROM gst_council_meeting_chapter where chapter_no = '" . $chapter_number . "' AND id NOT IN ($excludeId)";
        $result1 = mysqli_query($GLOBALS['con'],$query1);
        $record_exists1 = mysqli_fetch_array($result1);
        $totalRecords1 = $record_exists1[0];

        if ($totalRecords1 > 0) {
            // checking chapter_name
            return $chapter_number;
        } else {
            $query2 = "SELECT count(*) FROM gst_council_meeting_chapter where chapter_name='" . $chapter_name . "' AND id NOT IN ($excludeId)";
            $result2 = mysqli_query($GLOBALS['con'],$query2);
            $record_exists2 = mysqli_fetch_array($result2);
            $totalRecords2 = $record_exists2[0];
            if ($totalRecords2 > 0) {
                return $chapter_name;
            } else {
            //     //chapter seq exists
                return $chapter_name;
            }
        }
    }
    mysqli_free_result($result);
    mysqli_free_result($result1);
    mysqli_free_result($result2);

    return null;
}

function addGSTCouncilMeetingChapter($chapter_name, $chapter_number, $chapter_date) {
    global $con;
    $query = "INSERT INTO `gst_council_meeting_chapter` (`chapter_no`, `chapter_name`, `chapter_date`, `created_on`, `updated_on`, `last_modified_by`) 
              VALUES ('$chapter_number', '$chapter_name', '$chapter_date',  NOW(), NOW()," . $_SESSION["id"] . ");";
    $result = mysqli_query($GLOBALS['con'],$query);

    mysqli_free_result($result);
}

function listGSTCouncilMeetingChapter() {
    global $con;
    $query = "SELECT * FROM gst_council_meeting_chapter";

    $result = mysqli_query($GLOBALS['con'],$query);
    $records = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $records[] = $row;
    };

    mysqli_free_result($result);
    return $records;
}

function getGSTCouncilMeetingChapterbyId($id) {
    global $con;
    $query = "SELECT * FROM gst_council_meeting_chapter where id = " . $id;

    $result = mysqli_query($GLOBALS['con'],$query);
    $records = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $records;
}

function updateGSTCouncilMeetingChapter($chapter_name, $chapter_number, $chapter_date, $id) {
    global $con;
    $query = "update `gst_council_meeting_chapter` SET  
              `chapter_no` = '" . $chapter_number . "', 
              `chapter_name` = '" . $chapter_name . "' ,
              `chapter_date` = '" . $chapter_date . "' , 
               `updated_on` = ' NOW() ',
              `last_modified_by` = '" . $_SESSION["id"] . "'
             WHERE id  = $id;";

    $result = mysqli_query($GLOBALS['con'],$query);

    mysqli_free_result($result);
}

// *COUNCIL MEETING CHAPTER SECTION END* //

// *COUNCIL MEETING SECTION START* //

function getGSTCouncilMeetingbyId($id) {
    global $con;
    $query = "SELECT * FROM gst_council_meeting where id = " . $id;

    $result = mysqli_query($GLOBALS['con'],$query);
    $records = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $records;
}

function listGSTCouncilMeeting($chapter_id = 0) {
    global $con;
    $whereCond = "";
    if ($chapter_id != 0) {
        $whereCond = " WHERE cm.chapter_id in ($chapter_id)";
    }
    $query = "SELECT cm.*, cmc.chapter_no FROM gst_council_meeting cm LEFT OUTER JOIN gst_council_meeting_chapter cmc on cmc.id = cm.chapter_id $whereCond";
    $result = mysqli_query($GLOBALS['con'],$query);
    $records = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $records[] = $row;
    };

    mysqli_free_result($result);
    return $records;
}

function isGSTCouncilMeetingExists($meeting_name, $meeting_number, $chapter_id, $excludeId = 0) {
    global $con;
    //checking chapter seq
    $query = "SELECT count(*) FROM gst_council_meeting where (meeting_no = '" . $meeting_number . "') AND chapter_id=$chapter_id AND id NOT IN ($excludeId)";

    $result = mysqli_query($GLOBALS['con'],$query);
    $record_exists = mysqli_fetch_array($result);
    $totalRecords = $record_exists[0];
    if ($totalRecords > 0) {
        //checking article_no
        $query1 = "SELECT count(*) FROM gst_council_meeting where meeting_no = '" . $meeting_number . "' AND chapter_id=$chapter_id AND id NOT IN ($excludeId)";
        $result1 = mysqli_query($GLOBALS['con'],$query1);
        $record_exists1 = mysqli_fetch_array($result1);
        $totalRecords1 = $record_exists1[0];

        if ($totalRecords1 > 0) {
            //checking article_name
            return $meeting_number;
        } else {
                //article seq exists
                return $meeting_name;
        }
    }
    mysqli_free_result($result);
    mysqli_free_result($result1);

    return null;
}

function processFileGSTCouncilMeeting($file, $index, $chapter_id) {
    global $con;
    $error_type = '';
    $success = false;
    $file_content = "";
    $file_size = $file['size'][$index];
    $filetmp_name = $file['tmp_name'][$index];
    $file_name = $file['name'][$index];
    $filenameOnly = pathinfo(basename($file_name), PATHINFO_FILENAME);
    $filenameExtn = pathinfo(basename($file_name), PATHINFO_EXTENSION);
    $upload_path =  "../../../data/GSTCouncilMeeting/";    
    $file_path = basename($file_name);
    $filepath = $upload_path.$file_path;

    if ($file_size > 0) { // for upload file        
        if (is_dir($upload_path) == false) {
            mkdir($upload_path, 0777);
            chmod($upload_path, 0777);
        }
        if (file_exists($filepath)) {
            //unlink file and upload new one.
            unlink($filepath);
        }
        if ($filenameExtn == "htm" || $filenameExtn == "html" || $filenameExtn == "pdf") {
            //echo "hi";
            $myfile = file_get_contents($filepath);
            $searchContent = cleanname($myfile);
            $file_data_without_html = strip_tags($searchContent);
            $file_data = preg_replace('/\s+/', ' ', $file_data_without_html);
            $file_data = preg_replace('/[^a-zA-Z0-9\s]/', '', $file_data);
            if (!move_uploaded_file($filetmp_name, $filepath)) {
                $error_type = "file_uploaderror";
            } else {
                $success = true;
            }
        } else {
            $file_data = "";
        } 
    } else {
        $error_type = "Please select file for " . $section_no;
    }

    return array('success' => $success, 'content' => $file_data, 'filename' => $file_path, 'error' => $error_type);
}

function getGSTCouncilMeetingChapterDropDown($chapter_id, $dropDownId, $chapters_list) {
    global $con;

    $chapterSelect = '<select id="sel_chapter[' . $dropDownId . ']" name="sel_chapter[' . $dropDownId . ']" class="form-control" >
                    <option value="">Select Chapter </option>';
    $chapters_list;
    foreach ($chapters_list as $chapter) {
        $chapterSelect .= "<option ";
        if ($chapter_id == $chapter['id']) {
            $chapterSelect .= " selected='selected' ";
        }

        $chapterSelect .= " value='" . $chapter['id'] . "' data-id='" . $chapter['id'] . "'>" . strtoupper($chapter['chapter_no']) . "</option>";
    }
//    mysqli_free_result($result);

    $chapterSelect .= '</select>';
    return $chapterSelect;
}


// *COUNCIL MEETING SECTION END* //

// *Mapping Section Start* //

function isMappingExists($data_id, $prod_name, $data_type, $sub_prod_name, $reference_prod_name, $reference_data_type, $reference_sub_prod_name, $reference_data_id, $excludeId = 0) {
    global $con;
    //checking data_id
    $query = "SELECT count(*) FROM mapping where (data_id = " . $data_id . " OR 
              reference_id = '" . $reference_data_id . "') AND id NOT IN ($excludeId)";

    $result = mysqli_query($GLOBALS['con'],$query);
    $record_exists = mysqli_fetch_array($result);
    $totalRecords = $record_exists[0];
    if ($totalRecords > 0) {
        //checking chapter_no
        $query1 = "SELECT count(*) FROM mapping where (data_id = " . $data_id . " OR 
              reference_id = '" . $reference_data_id . "') AND id NOT IN ($excludeId)";
        $result1 = mysqli_query($GLOBALS['con'],$query1);
        $record_exists1 = mysqli_fetch_array($result1);
        $totalRecords1 = $record_exists1[0];

        if ($totalRecords1 > 0) {
            //checking chapter_name
            return $reference_data_id;
        } else {
            return $data_id;
        }
    }
    mysqli_free_result($result);
    mysqli_free_result($result1);

    return null;
}

function addMapping($data_id, $prod_name, $data_type, $sub_prod_name, $reference_prod_name, $reference_data_type, $reference_sub_prod_name, $reference_data_id) {
    global $con;
   $query = "INSERT INTO `mapping` (`data_id`, `data_type`, `data_prod_name`, `data_sub_prod_name`, `reference_id`, `reference_type`, `reference_prod_name`, `reference_sub_prod_name`) 
              VALUES ('$data_id', '$data_type', '$prod_name', '$sub_prod_name', '$reference_data_id', '$reference_data_type', '$reference_prod_name', '$reference_sub_prod_name');";
    $result = mysqli_query($GLOBALS['con'],$query);

    mysqli_free_result($result);
}

function mappingalldatalist() {
    global $con;
    $query = "SELECT * FROM mapping";

    $result = mysqli_query($GLOBALS['con'],$query);
    $records = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $records[] = $row;
    };

    mysqli_free_result($result);
    return $records;
}

function updateMapping($data_id, $prod_name, $data_type, $sub_prod_name, $reference_prod_name, $reference_data_type, $reference_sub_prod_name, $reference_data_id, $id) {
    global $con;
    $query = "update `mapping` SET 
              `data_id` = '" . $data_id . "', 
              `data_type` = '" . $data_type . "', 
              `data_prod_name` = '" . $prod_name . "' , 
              `data_sub_prod_name` = '" . $sub_prod_name . "', 
              `reference_id` = '" . $reference_data_id . "', 
              `reference_type` = '" . $reference_data_type . "' ,
              `reference_prod_name` = '" . $reference_prod_name . "', 
              `reference_sub_prod_name` = '" . $reference_sub_prod_name . "'
             WHERE id  = $id;";

    $result = mysqli_query($GLOBALS['con'],$query);

    mysqli_free_result($result);
}

function getMappingDatabyId($id) {
    global $con;
    $query = "SELECT * FROM mapping where id = " . $id;

    $result = mysqli_query($GLOBALS['con'],$query);
    $records = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $records;
}

// *Mapping Section End* //

// *Mapping Case Circulars Section Start* //

function MappingCaseCircularlist() {
    global $con;
    $query = "SELECT * FROM mapping_case_circulars";

    $result = mysqli_query($GLOBALS['con'],$query);
    $records = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $records[] = $row;
    };

    mysqli_free_result($result);
    return $records;
}

function isMappingCaseCircularExists($case_id, $case_type, $circular_id, $circular_type, $excludeId = 0) {
    //checking Case_id
    global $con;
    $query = "SELECT count(*) FROM mapping_case_circulars where (case_id = " . $case_id . " OR 
              circular_id = '" . $circular_id . "') AND id NOT IN ($excludeId)";

    $result = mysqli_query($GLOBALS['con'],$query);
    $record_exists = mysqli_fetch_array($result);
    $totalRecords = $record_exists[0];
    if ($totalRecords > 0) {
        //checking chapter_no
        $query1 = "SELECT count(*) FROM mapping_case_circulars where (case_id = " . $case_id . " OR 
              circular_id = '" . $circular_id . "') AND id NOT IN ($excludeId)";
        $result1 = mysqli_query($GLOBALS['con'],$query1);
        $record_exists1 = mysqli_fetch_array($result1);
        $totalRecords1 = $record_exists1[0];

        if ($totalRecords1 > 0) {
            //checking chapter_name
            return $circular_id;
        } else {
            return $case_id;
        }
    }
    mysqli_free_result($result);
    mysqli_free_result($result1);

    return null;
}

function addMappingCaseCircular($case_id, $case_type, $circular_id, $circular_type) {
    global $con;
 $query = "INSERT INTO `mapping_case_circulars` (`case_id`, `case_type`, `circular_id`, `circular_type`) 
              VALUES ('$case_id', '$case_type', '$circular_id', '$circular_type');";
    $result = mysqli_query($GLOBALS['con'],$query);

    mysqli_free_result($result);
}

function getMappingCaseCircularDatabyId($id) {
    global $con;
    $query = "SELECT * FROM mapping_case_circulars where id = " . $id;

    $result = mysqli_query($GLOBALS['con'],$query);
    $records = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $records;
}

function getMappingCaseTypeDropDown($id, $dropDownId, $mapping_case_types) {
    global $con;
    $CaseTypeSelect = '<select id="case_type[' . $dropDownId . ']" name="case_type[' . $dropDownId . ']" class="form-control" >
                    <option value="">Select Case Type </option>';

    foreach ($mapping_case_types as $mapping_case_type) {
        $CaseTypeSelect .= "<option ";
        if ($id == $mapping_case_type['id']) {
            $CaseTypeSelect .= " selected='selected' ";
        }

        $CaseTypeSelect .= " value='" . $mapping_case_type['id'] . "' data-id='" . $mapping_case_type['id'] . "'>" . strtoupper($mapping_case_type['case_type']) . "</option>";
    }
//    mysqli_free_result($result);

    $CaseTypeSelect .= '</select>';
    return $CaseTypeSelect;
}

function getMappingCircularTypeDropDown($id, $dropDownId, $mapping_circular_types) {
    global $con;
    $CircularTypeSelect = '<select id="circular_type[' . $dropDownId . ']" name="circular_type[' . $dropDownId . ']" class="form-control" >
                    <option value="">Select Circular Type </option>';
    foreach ($mapping_circular_types as $mapping_circular_type) {
        $CircularTypeSelect .= "<option ";
        if ($id == $mapping_circular_type['id']) {
            $CircularTypeSelect .= " selected='selected' ";
        }

        $CircularTypeSelect .= " value='" . $mapping_circular_type['id'] . "' data-id='" . $mapping_circular_type['id'] . "'>" . strtoupper($mapping_circular_type['circular_type']) . "</option>";
    }
//    mysqli_free_result($result);

    $CircularTypeSelect .= '</select>';
    return $CircularTypeSelect;
}

// *Mapping Case Circulars Section End* //

// *Mapping Case Cites Section Start* //

function MappingCaseCitelist() {
    global $con;
    $query = "SELECT * FROM mapping_case_cites";

    $result = mysqli_query($GLOBALS['con'],$query);
    $records = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $records[] = $row;
    };

    mysqli_free_result($result);
    return $records;
}

function isMappingCaseCiteExists($case_id, $case_type, $cited_case_id, $cited_case_type, $excludeId = 0) {
    global $con;
    //checking Case_id
    $query = "SELECT count(*) FROM mapping_case_cites where (case_type = " . $case_type . ") AND id NOT IN ($excludeId)";

    $result = mysqli_query($GLOBALS['con'],$query);
    $record_exists = mysqli_fetch_array($result);
    $totalRecords = $record_exists[0];
    if ($totalRecords > 0) {
        //checking chapter_no
        $query1 = "SELECT count(*) FROM mapping_case_cites where (cited_case_type = '" . $cited_case_type . "') AND id NOT IN ($excludeId)";
        $result1 = mysqli_query($GLOBALS['con'],$query1);
        $record_exists1 = mysqli_fetch_array($result1);
        $totalRecords1 = $record_exists1[0];

        if ($totalRecords1 > 0) {
            //checking chapter_name
            return $cited_case_id;
        } else {
            return $case_id;
        }
    }
    mysqli_free_result($result);
    mysqli_free_result($result1);

    return null;
}

function addMappingCaseCite($case_id, $case_type, $cited_case_id, $cited_case_type) {
    global $con;
    $query = "INSERT INTO `mapping_case_cites` (`case_id`, `case_type`, `cited_case_id`, `cited_case_type`) 
              VALUES ('$case_id', '$case_type', '$cited_case_id', '$cited_case_type');";
    $result = mysqli_query($GLOBALS['con'],$query);

    mysqli_free_result($result);
}

function updateMappingCaseCite($case_id, $case_type, $cited_case_id, $cited_case_type, $id) {
    global $con;
    $query = "update `mapping_case_cites` SET 
              `case_id` = '" . $case_id . "', 
              `case_type` = '" . $case_type . "', 
              `cited_case_id` = '" . $cited_case_id . "' , 
              `cited_case_type` = '" . $cited_case_type . "'
             WHERE id  = $id;";

    $result = mysqli_query($GLOBALS['con'],$query);

    mysqli_free_result($result);
}

function getMappingCaseCiteDatabyId($id) {
    global $con;
    $query = "SELECT * FROM mapping_case_cites where id = " . $id;

    $result = mysqli_query($GLOBALS['con'],$query);
    $records = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $records;
}

function getMappingCitedCaseIDDropDown($id, $dropDownId, $Mapping_Case_Cite) {
    global $con;
    $CaseTypeSelect = '<select id="case_type[' . $dropDownId . ']" name="case_type[' . $dropDownId . ']" class="form-control" >
                    <option value="">Select Case Type </option>';
    $Mapping_Case_Cite;
    foreach ($Mapping_Case_Cite as $Case_Cite) {
        $CaseTypeSelect .= "<option ";
        if ($id == $Case_Cite['id']) {
            $CaseTypeSelect .= " selected='selected' ";
        }

        $CaseTypeSelect .= " value='" . $Case_Cite['id'] . "' data-id='" . $Case_Cite['id'] . "'>" . strtoupper($Case_Cite['case_type']) . "</option>";
    }

    $CaseTypeSelect .= '</select>';
    return $CaseTypeSelect;
}

function getMappingCitedCaseTypeDropDown($id, $dropDownId, $Mapping_Case_Cite) {
    global $con;

    $CitedCaseTypeSelect = '<select id="cited_case_type[' . $dropDownId . ']" name="cited_case_type[' . $dropDownId . ']" class="form-control" >
                    <option value="">Select Cited Case Type </option>';
    foreach ($Mapping_Case_Cite as $Case_Cite) {
        $CitedCaseTypeSelect .= "<option ";
        if ($id == $Case_Cite['id']) {
            $CitedCaseTypeSelect .= " selected='selected' ";
        }

        $CitedCaseTypeSelect .= " value='" . $Case_Cite['id'] . "' data-id='" . $Case_Cite['id'] . "'>" . strtoupper($Case_Cite['circular_type']) . "</option>";
    }

    $CitedCaseTypeSelect .= '</select>';
    return $CitedCaseTypeSelect;
}

// *Mapping Case Cites Section End* //

// *Mapping Case Notifications Section Start* //

function MappingCaseNotificationlist() {
    global $con;
    $query = "SELECT * FROM mapping_case_notifications";

    $result = mysqli_query($GLOBALS['con'],$query);
    $records = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $records[] = $row;
    };

    mysqli_free_result($result);
    return $records;
}

function isMappingCaseNotificationExists($case_id, $case_type, $notification_id, $notification_type, $excludeId = 0) {
    global $con;
    //checking Case_id
    $query = "SELECT count(*) FROM mapping_case_notifications where (case_type = " . $case_type . ") AND id NOT IN ($excludeId)";

    $result = mysqli_query($GLOBALS['con'],$query);
    $record_exists = mysqli_fetch_array($result);
    $totalRecords = $record_exists[0];
    if ($totalRecords > 0) {
        //checking chapter_no
        $query1 = "SELECT count(*) FROM mapping_case_notifications where (notification_type = '" . $notification_type . "') AND id NOT IN ($excludeId)";
        $result1 = mysqli_query($GLOBALS['con'],$query1);
        $record_exists1 = mysqli_fetch_array($result1);
        $totalRecords1 = $record_exists1[0];

        if ($totalRecords1 > 0) {
            //checking chapter_name
            return $notification_id;
        } else {
            return $case_id;
        }
    }
    mysqli_free_result($result);
    mysqli_free_result($result1);

    return null;
}

function addMappingCaseNotification($case_id, $case_type, $notification_id, $notification_type) {
    global $con;
    $query = "INSERT INTO `mapping_case_notifications` (`case_id`, `case_type`, `notification_id`, `notification_type`) 
              VALUES ('$case_id', '$case_type', '$notification_id', '$notification_type');";
    $result = mysqli_query($GLOBALS['con'],$query);

    mysqli_free_result($result);
}

function updateMappingCaseNotification($case_id, $case_type, $notification_id, $notification_type, $id) {
    global $con;
    $query = "update `mapping_case_notifications` SET 
              `case_id` = '" . $case_id . "', 
              `case_type` = '" . $case_type . "', 
              `notification_id` = '" . $notification_id . "' , 
              `notification_type` = '" . $notification_type . "'
             WHERE id  = $id;";

    $result = mysqli_query($GLOBALS['con'],$query);

    mysqli_free_result($result);
}

function getMappingCaseNotificationDatabyId($id) {
    global $con;
    $query = "SELECT * FROM mapping_case_notifications where id = " . $id;

    $result = mysqli_query($GLOBALS['con'],$query);
    $records = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $records;
}

function getMappingNotificationCaseIDDropDown($id, $dropDownId, $Mapping_Case_Notification) {
    $CaseTypeSelect = '<select id="case_type[' . $dropDownId . ']" name="case_type[' . $dropDownId . ']" class="form-control" >
                    <option value="">Select Case Type </option>';
    $Mapping_Case_Notification;
    foreach ($Mapping_Case_Notification as $Case_Notification) {
        $CaseTypeSelect .= "<option ";
        if ($id == $Case_Notification['id']) {
            $CaseTypeSelect .= " selected='selected' ";
        }

        $CaseTypeSelect .= " value='" . $Case_Notification['id'] . "' data-id='" . $Case_Notification['id'] . "'>" . strtoupper($Case_Notification['case_type']) . "</option>";
    }

    $CaseTypeSelect .= '</select>';
    return $CaseTypeSelect;
}

function getMappingNotificationTypeDropDown($id, $dropDownId, $Mapping_Case_Notification) {

    $NotificationTypeSelect = '<select id="notification_type[' . $dropDownId . ']" name="notification_type[' . $dropDownId . ']" class="form-control" >
                    <option value="">Select Notification Type </option>';
    foreach ($Mapping_Case_Notification as $Case_Notification) {
        $NotificationTypeSelect .= "<option ";
        if ($id == $Case_Notification['id']) {
            $NotificationTypeSelect .= " selected='selected' ";
        }

        $NotificationTypeSelect .= " value='" . $Case_Notification['id'] . "' data-id='" . $Case_Notification['id'] . "'>" . strtoupper($Case_Notification['circular_type']) . "</option>";
    }

    $NotificationTypeSelect .= '</select>';
    return $NotificationTypeSelect;
}

// *Mapping Case Notifications Section End* //

// *Mapping Case Rule Section Start* //

function MappingCaseRulelist() {
    global $con;
    $query = "SELECT * FROM mapping_case_rule";

    $result = mysqli_query($GLOBALS['con'],$query);
    $records = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $records[] = $row;
    };

    mysqli_free_result($result);
    return $records;
}

function isMappingCaseRuleExists($case_id, $case_type, $rule_id, $rule_type, $excludeId = 0) {
    global $con;
    //checking Case_id
    $query = "SELECT count(*) FROM mapping_case_rule where (case_type = " . $case_type . ") AND id NOT IN ($excludeId)";

    $result = mysqli_query($GLOBALS['con'],$query);
    $record_exists = mysqli_fetch_array($result);
    $totalRecords = $record_exists[0];
    if ($totalRecords > 0) {
        //checking chapter_no
        $query1 = "SELECT count(*) FROM mapping_case_rule where (rule_type = '" . $rule_type . "') AND id NOT IN ($excludeId)";
        $result1 = mysqli_query($GLOBALS['con'],$query1);
        $record_exists1 = mysqli_fetch_array($result1);
        $totalRecords1 = $record_exists1[0];

        if ($totalRecords1 > 0) {
            //checking chapter_name
            return $rule_id;
        } else {
            return $case_id;
        }
    }
    mysqli_free_result($result);
    mysqli_free_result($result1);

    return null;
}

function addMappingCaseRule($case_id, $case_type, $rule_id, $rule_type) {
    global $con;
    $query = "INSERT INTO `mapping_case_rule` (`case_id`, `case_type`, `rule_id`, `rule_type`) 
              VALUES ('$case_id', '$case_type', '$rule_id', '$rule_type');";
    $result = mysqli_query($GLOBALS['con'],$query);

    mysqli_free_result($result);
}

function updateMappingCaseRule($case_id, $case_type, $rule_id, $rule_type, $id) {
    global $con;
    $query = "update `mapping_case_rule` SET 
              `case_id` = '" . $case_id . "', 
              `case_type` = '" . $case_type . "', 
              `rule_id` = '" . $rule_id . "' , 
              `rule_type` = '" . $rule_type . "'
             WHERE id  = $id;";

    $result = mysqli_query($GLOBALS['con'],$query);

    mysqli_free_result($result);
}

function getMappingCaseRuleDatabyId($id) {
    global $con;
    $query = "SELECT * FROM mapping_case_rule where id = " . $id;

    $result = mysqli_query($GLOBALS['con'],$query);
    $records = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $records;
}

function getMappingRuleCaseIDDropDown($id, $dropDownId, $Mapping_Case_Rule) {
    global $con;
    $CaseTypeSelect = '<select id="case_type[' . $dropDownId . ']" name="case_type[' . $dropDownId . ']" class="form-control" >
                    <option value="">Select Case Type </option>';
    $Mapping_Case_Rule;
    foreach ($Mapping_Case_Rule as $Case_Rule) {
        $CaseTypeSelect .= "<option ";
        if ($id == $Case_Rule['id']) {
            $CaseTypeSelect .= " selected='selected' ";
        }

        $CaseTypeSelect .= " value='" . $Case_Rule['id'] . "' data-id='" . $Case_Rule['id'] . "'>" . strtoupper($Case_Rule['case_type']) . "</option>";
    }

    $CaseTypeSelect .= '</select>';
    return $CaseTypeSelect;
}

function getMappingRuleTypeDropDown($id, $dropDownId, $Mapping_Case_Rule) {
    global $con;

    $RuleTypeSelect = '<select id="rule_type[' . $dropDownId . ']" name="rule_type[' . $dropDownId . ']" class="form-control" >
                    <option value="">Select Rule Type </option>';
    foreach ($Mapping_Case_Rule as $Case_Rule) {
        $RuleTypeSelect .= "<option ";
        if ($id == $Case_Rule['id']) {
            $RuleTypeSelect .= " selected='selected' ";
        }

        $RuleTypeSelect .= " value='" . $Case_Rule['id'] . "' data-id='" . $Case_Rule['id'] . "'>" . strtoupper($Case_Rule['circular_type']) . "</option>";
    }

    $RuleTypeSelect .= '</select>';
    return $RuleTypeSelect;
}

// *Mapping Case Rule Section End* //

// *Mapping Case Sections Section Start* //

function MappingCaseSectionlist() {
    global $con;
    $query = "SELECT * FROM mapping_case_sections";

    $result = mysqli_query($GLOBALS['con'],$query);
    $records = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $records[] = $row;
    };

    mysqli_free_result($result);
    return $records;
}

function isMappingCaseSectionExists($case_id, $case_type, $section_id, $section_type, $excludeId = 0) {
    global $con;
    //checking Case_id
    $query = "SELECT count(*) FROM mapping_case_sections where (case_type = " . $case_type . ") AND id NOT IN ($excludeId)";

    $result = mysqli_query($GLOBALS['con'],$query);
    $record_exists = mysqli_fetch_array($result);
    $totalRecords = $record_exists[0];
    if ($totalRecords > 0) {
        //checking chapter_no
        $query1 = "SELECT count(*) FROM mapping_case_sections where (section_type = '" . $section_type . "') AND id NOT IN ($excludeId)";
        $result1 = mysqli_query($GLOBALS['con'],$query1);
        $record_exists1 = mysqli_fetch_array($result1);
        $totalRecords1 = $record_exists1[0];

        if ($totalRecords1 > 0) {
            //checking chapter_name
            return $section_id;
        } else {
            return $case_id;
        }
    }
    mysqli_free_result($result);
    mysqli_free_result($result1);

    return null;
}

function addMappingCaseSection($case_id, $case_type, $section_id, $section_type) {
    global $con;
    $query = "INSERT INTO `mapping_case_sections` (`case_id`, `case_type`, `section_id`, `section_type`) 
              VALUES ('$case_id', '$case_type', '$section_id', '$section_type');";
    $result = mysqli_query($GLOBALS['con'],$query);

    mysqli_free_result($result);
}

function updateMappingCaseSection($case_id, $case_type, $section_id, $section_type, $id) {
    global $con;
    $query = "update `mapping_case_sections` SET 
              `case_id` = '" . $case_id . "', 
              `case_type` = '" . $case_type . "', 
              `section_id` = '" . $section_id . "' , 
              `section_type` = '" . $section_type . "'
             WHERE id  = $id;";

    $result = mysqli_query($GLOBALS['con'],$query);

    mysqli_free_result($result);
}

function getMappingCaseSectionDatabyId($id) {
    global $con;
    $query = "SELECT * FROM mapping_case_sections where id = " . $id;

    $result = mysqli_query($GLOBALS['con'],$query);
    $records = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $records;
}

function getMappingSectionCaseIDDropDown($id, $dropDownId, $Mapping_Case_Section) {
    global $con;
    $CaseTypeSelect = '<select id="case_type[' . $dropDownId . ']" name="case_type[' . $dropDownId . ']" class="form-control" >
                    <option value="">Select Case Type </option>';
    $Mapping_Case_Section;
    foreach ($Mapping_Case_Section as $Case_Section) {
        $CaseTypeSelect .= "<option ";
        if ($id == $Case_Section['id']) {
            $CaseTypeSelect .= " selected='selected' ";
        }

        $CaseTypeSelect .= " value='" . $Case_Section['id'] . "' data-id='" . $Case_Section['id'] . "'>" . strtoupper($Case_Section['case_type']) . "</option>";
    }

    $CaseTypeSelect .= '</select>';
    return $CaseTypeSelect;
}

function getMappingSectionTypeDropDown($id, $dropDownId, $Mapping_Case_Section) {
    global $con;

    $SectionTypeSelect = '<select id="section_type[' . $dropDownId . ']" name="section_type[' . $dropDownId . ']" class="form-control" >
                    <option value="">Select Section Type </option>';
    foreach ($Mapping_Case_Section as $Case_Section) {
        $SectionTypeSelect .= "<option ";
        if ($id == $Case_Section['id']) {
            $SectionTypeSelect .= " selected='selected' ";
        }

        $SectionTypeSelect .= " value='" . $Case_Section['id'] . "' data-id='" . $Case_Section['id'] . "'>" . strtoupper($Case_Section['circular_type']) . "</option>";
    }

    $SectionTypeSelect .= '</select>';
    return $SectionTypeSelect;
}

// *Mapping Case Sections Section End* //

// Menu Section Start //
    
    function menualldatalist() {
        global $con;
        $query = "SELECT * FROM menu";

        $result = mysqli_query($GLOBALS['con'],$query);
        $records = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $records[] = $row;
        };

        mysqli_free_result($result);
        return $records;
    }

    function isMenuExists($menu_name, $url, $parent_id, $excludeId = 0) {
        global $con;
    //checking menu_name
        $query = "SELECT count(*) FROM menu where (menu_name = " . $menu_name . " OR 
                  url = '" . $url . "') AND id NOT IN ($excludeId)";

        $result = mysqli_query($GLOBALS['con'],$query);
        $record_exists = mysqli_fetch_array($result);
        $totalRecords = $record_exists[0];
        if ($totalRecords > 0) {
            //checking menu_name
            $query1 = "SELECT count(*) FROM menu where (menu_name = " . $menu_name . " OR 
                  url = '" . $url . "') AND id NOT IN ($excludeId)";
            $result1 = mysqli_query($GLOBALS['con'],$query1);
            $record_exists1 = mysqli_fetch_array($result1);
            $totalRecords1 = $record_exists1[0];

            if ($totalRecords1 > 0) {
                //checking url
                return $url;
            } else {
                return $menu_name;
            }
        }
        mysqli_free_result($result);
        mysqli_free_result($result1);

        return null;
    }

    function addMenu($menu_name, $url, $parent_id) {
        global $con;
        $query = "INSERT INTO `menu` (`menu_name`, `url`, `parent_id`) 
                  VALUES ('$menu_name', '$url', '$parent_id');";
        $result = mysqli_query($GLOBALS['con'],$query);

        mysqli_free_result($result);
    }

    function getMenubyId($id) {
        global $con;
        $query = "SELECT * FROM menu where id = " . $id;

        $result = mysqli_query($GLOBALS['con'],$query);
        $records = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        return $records;
    }

    function updateMenu($menu_name, $url, $parent_id, $id) {
        global $con;
        $query = "update `menu` SET 
                  `menu_name` = '" . $menu_name . "', 
                  `url` = '" . $url . "', 
                  `parent_id` = '" . $parent_id . "'
                 WHERE id  = $id;";

        $result = mysqli_query($GLOBALS['con'],$query);

        mysqli_free_result($result);
    }

// Menu Section End //

// * Serach History Section Start * //

function SearchHistorylist() {
    global $con;
    $query = "SELECT * FROM search_history";

    $result = mysqli_query($GLOBALS['con'],$query);
    $records = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $records[] = $row;
    };

    mysqli_free_result($result);
    return $records;
}

function getSearchHistoryDatabyId($id) {
    global $con;
    $query = "SELECT * FROM search_history where search_id = " . $id;

    $result = mysqli_query($GLOBALS['con'],$query);
    $records = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $records;
}

function updateSearchHistory($user_id, $user_name, $keyword, $party_name, $topic, $pagename, $search_in, $row_count, $id) {
    global $con;
    $query = "update `search_history` SET 
              `user_id` = '" . $user_id . "',
              `user_name` = '" . $user_name . "',
              `keyword` = '" . $keyword . "', 
              `party_name` = '" . $party_name . "', 
              `topic` = '" . $topic . "' , 
              `pagename` = '" . $pagename . "',
              `search_in` = '" . $search_in . "',
              `row_count` = '" . $row_count . "',
              `updated_dt` = Now()
             WHERE search_id  = $id;";

    $result = mysqli_query($GLOBALS['con'],$query);

    mysqli_free_result($result);
}

// function isSearchHistoryExists($user_id, $keyword, $excludeId = 0) {
//     //checking user_id
//     $query = "SELECT count(*) FROM search_history where (user_id = " . $user_id . ") AND id NOT IN ($excludeId)";

//     $result = mysqli_query($GLOBALS['con'],$query);
//     $record_exists = mysqli_fetch_array($result);
//     $totalRecords = $record_exists[0];
//     if ($totalRecords > 0) {
//         //checking keyword
//         $query1 = "SELECT count(*) FROM search_history where (keyword = '" . $keyword . "') AND id NOT IN ($excludeId)";
//         $result1 = mysqli_query($GLOBALS['con'],$query1);
//         $record_exists1 = mysqli_fetch_array($result1);
//         $totalRecords1 = $record_exists1[0];

//         if ($totalRecords1 > 0) {
//             //checking keyword
//             return $keyword;
//         } else {
//             return $user_id;
//         }
//     }
//     mysqli_free_result($result);
//     mysqli_free_result($result1);

//     return null;
// }

// * Serach History Section END * //

// * Media Library Section Start * //

function getMediaLibrarybyId($id) {
    global $con;
    $query = "SELECT * FROM media_library where media_id = " . $id;

    $result = mysqli_query($GLOBALS['con'],$query);
    $records = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $records;
}

function updateMediaLibrary($file_path, $filenameExtn, $id) {
    global $con;
    $query = "update `media_library` SET 
              `media_type` = '" . $filenameExtn . "',
              `file_path` = '" . $file_path . "', 
              `uploaded_by` = '" . $_SESSION["user"] . "' , 
              `uploaded_dt` = ' NOW() ',
             WHERE media_id  = $id;";

    $result = mysqli_query($GLOBALS['con'],$query);

    mysqli_free_result($result);
}

function processImageMedia($file) {
    global $con;
    $error_type = '';
    $success = false;
    $file_content = "";
    $file_size = $file['size'][$index];
    $filetmp_name = $file['tmp_name'][$index];
    $file_name = $file['name'][$index];
    $filenameOnly = pathinfo(basename($file_name), PATHINFO_FILENAME);
    $filenameExtn = pathinfo(basename($file_name), PATHINFO_EXTENSION);
    $upload_path =  "/media/" . date('dmYHis').'-';    
    $file_path = basename($file_name);
    $filepath = $upload_path.$file_path;

    if ($file_size > 0) { // for upload file        
        if (is_dir($upload_path) == false) {
            mkdir($upload_path, 0777);
            chmod($upload_path, 0777);
        }

        if (file_exists($filepath)) {
            //unlink file and upload new one.
            unlink($filepath);
        }

        if (!move_uploaded_file($filetmp_name, $filepath)) {
            $error_type = "file_uploaderror";
        } else {
            $success = true;
        }

    } else {
        $error_type = "Please select Image";
    }

    return array('success' => $success, 'filename' => $file_path, 'fileExtension' => $filenameExtn, 'error' => $error_type);
}
// * Media Library Section END * //

?>