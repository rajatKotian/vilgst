<?php
    date_default_timezone_set("Asia/Calcutta");
    $page = 'AdvancedSearch';
    include('header.php');
    $seoTitle = 'Advanced Search';
    $seoKeywords = 'Advanced Search';
    $seoDesc = 'Advanced Search';
//     ini_set('display_errors',0);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
?>
<?php
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
        die('Could not enter data: ' . mysqli_error());
    } else {
        return $a;
    }
}

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

function getsubproductnoti($table, $value, $id) {
    global $con;
    if (is_array($id)) {
        foreach ($id as $key) {
            $prod_id[] = "prod_id='$key'";
        }
        return $p_id = implode(' OR ', $prod_id);
    } else {
        $p_id = "prod_id='$id'";
    }


    $result = mysqli_query($GLOBALS['con'],"SELECT * FROM $table  WHERE sub_prod_type = '$value' AND (sub_prod_name='Notification' OR sub_prod_name='Circular') AND ($p_id)");
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $subprod_id[] = $row['sub_prod_id'];
        }
        foreach ($subprod_id as $key) {
            $s_id[] = "a.sub_prod_id='$key'";
        }
        return implode(' OR ', $s_id);
    }
}

function getsubproduct($table, $value, $id) {
    if (is_array($id)) {
        foreach ($id as $key) {
            $prod_id[] = "prod_id='$key'";
        }
        $p_id = implode(' OR ', $prod_id);
    } else {
        $p_id = "prod_id='$id'";
    }


    $result = mysqli_query($GLOBALS['con'],"SELECT * FROM $table  WHERE sub_prod_type = '$value' AND ($p_id)");
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $subprod_id[] = $row['sub_prod_id'];
        }
        foreach ($subprod_id as $key) {
            $s_id[] = "a.sub_prod_id='$key'";
        }
        return implode(' OR ', $s_id);
    }
}

function getCategory($table, $value) {
    global $con;
    $result = mysqli_query($GLOBALS['con'],"SELECT * FROM $table  WHERE sub_prod_type = '$value'");
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        $data_id = explode(',', $row['prod_id']);
        $conditions = array();
        foreach ($data_id as $key) {
            $conditions[] = "prod_id='$key'";
        }
        return $where = implode(' OR ', $conditions);
    }
}

function getCatDropdown($value, $data) {
    global $con;
    if ($data == '1') {
        $prodSelect = '<select id="prod_id" name="prod_id" class="form-control required" multiple >';
    } else {
        $prodSelect = '<select id="prod_id" name="prod_id" class="form-control required" >';
    }
    $prodSelect .= "<option ";
    $prodSelect .= " value='0'>Select</option>";
    $result = mysqli_query($GLOBALS['con'],"SELECT prod_id, prod_name, dbsuffix FROM $value");
    while ($row = mysqli_fetch_array($result)) {
        $prodSelect .= "<option ";
        $prodSelect .= " value='" . $row['prod_id'] . "' data-dbsuffix='" . $row['dbsuffix'] . "'>" . $row['prod_name'] . "</option>";
    }
    mysqli_free_result($result);
    $prodSelect .= '</select>';
    return $prodSelect;
}

function getStatDropdown($state_id, $selectValue) {
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

function getAuthor($value) {
    global $con;
    $author = '<select id="author" name="author" class="form-control required" >
                        <option value="0">Select Author</option>';

    $result = mysqli_query($GLOBALS['con'],"SELECT author FROM $value  WHERE author <> '' GROUP BY author ASC");
    while ($row = mysqli_fetch_array($result)) {
        if (isset($_REQUEST['author']) && $_REQUEST['author'] == $row['author']) {
            $author .= "<option value='" . $row['author'] . "' selected='selected'>" . $row['author'] . "</option>";
        } else {
            $author .= "<option value='" . $row['author'] . "'>" . $row['author'] . "</option>";
        }
    }
    mysqli_free_result($result);
    $author .= '</select>';
    return $author;
}
?>
<?php
function clean($string) {
    return preg_replace("#[^0-9a-z ]#i", "", $string);

    //return preg_replace('/[^A-Za-z0-9\& ]/', '', $string); // Removes special chars.
}

function shortForm($text) {
    global $con;
    $replace = array();
    $rep_data = array();
    if (!empty($text)) {
        $value = explode(' ', $text);
        foreach ($value as $k => $v) {
            $result = mysqli_query($GLOBALS['con'],"SELECT * FROM `short_form` WHERE `short_form` LIKE '$v'") or die(mysqli_error());
            $data = mysqli_fetch_array($result);
            if (mysqli_num_rows($result) > 0) {
                $replace[] = $data['full_form'];
            } else {
                $replace[] = $v;
            }
        }
        $rep_data[] = implode(' ', $replace);   
    }
    return $rep_data;
}

function tableUnion($conditions, $table, $ids, $sub_prod_name) {
    global $con;
    
    if (!empty($conditions)) {
        $value = " WHERE " . implode(' AND ', $conditions);
    } else {
        $value = "";
    }
    $count = 0;
    foreach ($table as $tbl) {
        $qry = mysqli_query($GLOBALS['con'],"SELECT p.prod_id,p.dbsuffix,sp.sub_prod_id FROM product as p LEFT JOIN sub_product as sp ON p.prod_id=sp.prod_id WHERE p.prod_id= '" . $ids[$count] . "'" . $sub_prod_name) or die(mysqli_error());
        $where = [];

        if (mysqli_num_rows($qry) > 0) {
            while ($data = mysqli_fetch_array($qry)) {
                $where[] = "a.sub_prod_id = '" . $data['sub_prod_id'] . "'";
            }
        }
        if (!empty($where)) {
            if (!empty($conditions)) {
                $where_data = " AND (" . implode(' OR ', $where) . ")";
            } else {
                $where_data = " where " . implode(' OR ', $where);
            }
        } else {
            $where_data = "";
        }
        
        $query[] = "SELECT a.data_id,a.prod_id,a.sub_prod_id,a.sub_subprod_id,a.state_id,a.circular_date,a.eq_citation,a.section_no,a.rule_no,a.circular_no,a.cir_subject,a.file_path,a.file_data,a.party_name,a.active_flag,a.new_flag,a.created_dt, DATE_FORMAT(circular_date,GET_FORMAT(DATE,'EUR'))'Date',p.prod_name,p.dbsuffix,sp.sub_prod_name,sm.state_name FROM $tbl as a LEFT JOIN product as p ON a.prod_id=p.prod_id LEFT JOIN sub_product as sp ON a.sub_prod_id=sp.sub_prod_id LEFT JOIN state_master as sm ON a.state_id=sm.state_id" . $value . $where_data;

        $count++;
    }
    return $query;
}

function tableUnion2($conditions, $table, $ids, $sub_prod_name, $search_id) {
    global $con;
    //echo $search_id;
    if (!empty($conditions)) {
        $value = " WHERE a.data_id IN $search_id AND " . implode(' AND ', $conditions);
    } else {
        $value = "";
    }
    $count = 0;
    foreach ($table as $tbl) {
        $qry = mysqli_query($GLOBALS['con'],"SELECT p.prod_id,p.dbsuffix,sp.sub_prod_id FROM product as p LEFT JOIN sub_product as sp ON p.prod_id=sp.prod_id WHERE p.prod_id= '" . $ids[$count] . "'" . $sub_prod_name) or die(mysqli_error());
        $where = [];

        if (mysqli_num_rows($qry) > 0) {
            while ($data = mysqli_fetch_array($qry)) {
                $where[] = "a.sub_prod_id = '" . $data['sub_prod_id'] . "'";
            }
        }
        if (!empty($where)) {
            if (!empty($conditions)) {
                $where_data = " AND (" . implode(' OR ', $where) . ")";
            } else {
                $where_data = " where " . implode(' OR ', $where);
            }
        } else {
            $where_data = "";
        }

        $query[] = "SELECT a.data_id,a.prod_id,a.sub_prod_id,a.sub_subprod_id,a.state_id,a.circular_date,a.eq_citation,a.section_no,a.rule_no,a.circular_no,a.cir_subject,a.file_path,a.file_data,a.party_name,a.active_flag,a.new_flag,a.created_dt, DATE_FORMAT(circular_date,GET_FORMAT(DATE,'EUR'))'Date',p.prod_name,p.dbsuffix,sp.sub_prod_name,sm.state_name FROM $tbl as a LEFT JOIN product as p ON a.prod_id=p.prod_id LEFT JOIN sub_product as sp ON a.sub_prod_id=sp.sub_prod_id LEFT JOIN state_master as sm ON a.state_id=sm.state_id " . $value . $where_data;

        $count++;
    }
    return $query;
}

?>

<script type="text/javascript">
    var calcHeight = function() {
        // global $con;
        var the_height = document.getElementById('iFramePopupFrame').contentWindow.document.body.scrollHeight + 50;
         //isPdf=0
                              
        if ($('#iFramePopupFrame').attr('isPdf')=='0'){
            document.getElementById('iFramePopupFrame').height = the_height;    
        }

        $('.widget-box .preview').click(function(e) {
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();
            var linktoopen = $(this).attr('perm-link');
            var linktoOpenNew = $(this).attr('href');
            //console.log(linktoOpenNew);
            $('.btn_open_new_window').attr('href', linktoOpenNew);

            $('#iFramePreviewFrame').attr('src', linktoopen);
            var the_height2 = document.getElementById('iFramePreviewFrame').contentWindow.document.body.scrollHeight + 50;
            $('#iFramePreviewFrame').height('580px');
//            iFramePreviewFrame
            $('#recordInfoModal').modal('show');    
        });
    }
</script>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="css/adv_style.css">
<link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
<link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
<!-- Font special for pages-->
<!-- <link href="https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i" rel="stylesheet"> -->
<link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

<!-- Vendor CSS-->
<link href="vendor/select2/select2.min.css" rel="stylesheet" media="all">
<link href="vendor/datepicker/daterangepicker.css" rel="stylesheet" media="all">

<!-- Main CSS-->
<link href="css/main.css" rel="stylesheet" media="all">

<style type="text/css">
    .filt { color: white; padding-left: 5px; } 
    .form { width: 100%; }
    .form2 { padding-left: 50px; width: 100%; }
    .display { display: none; }
    .input-group { background: none !important; }
    .input-group-big { padding: 4px 10px; padding-right: 10px;}
    .daterangepicker { padding: 0; margin: 0; }
    #sidebar h1 { margin-bottom: 15px; font-weight: 600; font-size: 16px; }
    .label { font-size: 14px; color: #333; text-transform: capitalize; display: block; font-weight: 500;
        white-space: nowrap; margin-right: 5px; }
    input[type="date"], input[type="time"], input[type="datetime-local"], input[type="month"] { line-height: 15px;
       line-height: 1.42857143 \0; }
    .input--style-1 { font-size: 15px; padding: 8px 0; color: #666; font-family: inherit; border: 1px solid black; }
    .form-control { height: 30px !important; background: #fff; color: #000; font-size: 13px; border-radius: 4px;
        -webkit-box-shadow: none !important; box-shadow: none !important; border: 1px solid black; }
    .widget-box h4 span { color: #696c70; font-size: 14px; float: right; text-transform: capitalize; }
    #sidebar .custom-menu { border: 1px solid #dee2e6; display: inline-block;position: absolute;top: 0px;left: 0px;-webkit-transition: 0.3s;
        -o-transition: 0.3s;transition: 0.3s; background-co}
    #sidebar .custom-menu .btn.btn-primary:after, #sidebar .custom-menu .btn.btn-primary:before {
        color: #00789e;
    }
    .wrapper .mail-input { position: relative; background: #fff; width: 100%; border-radius: 5px; box-shadow: 0px 1px 5px 3px rgb(0 0 0 / 12%); }
    .mail-input input { height: 55px; width: 100%; outline: none; border: 1px solid black; border-radius: 5px; padding: 0 60px 0 20px;
        font-size: 18px; box-shadow: 0px 1px 5px rgb(0 0 0 / 10%); }
</style>
<style>
    .tool {position: relative; display: inline-block; }
    .tool .tooltiptext {visibility: hidden; width: 370px; background-color: black; color: #fff; text-align: center;border-radius: 6px; padding: 8px 0;/* Position the tooltip */position: absolute; z-index: 1;}
    .tool:hover .tooltiptext {visibility: visible; }
    .tool .tooltiptext2 { visibility: hidden; width: 200px; background-color: black; color: #fff; text-align: center; 
        border-radius: 6px; padding: 8px 0; /* Position the tooltip */ position: absolute; z-index: 1; }
    .tool:hover .tooltiptext2 { visibility: visible; }
</style>
<body>
<div class="wrapper d-flex align-items-stretch contain">
    <nav id="sidebar" class="order-last" class="img" >
        <div class="custom-menu" style="border-style: solid;border-color: #006995;">
            <button type="button" id="sidebarCollapse" class="btn btn-primary" 
                style="margin-bottom: 10px; background: #ffa100;"></button>
            <div>
                <div style="border-bottom: 1px solid #ff7808; padding:10px 0px; text-align: center; font-size: 17px; margin-bottom: 15px; margin-top: 5px; background: linear-gradient(to bottom, #00789e 0%,#00548a 100%);">
                    <strong>Search-in-Search</strong>
                </div>
                <ul class="list-unstyled components mb-5">
                    <?php if ($_REQUEST['pagename'] == 'CaseLaws') { ?>
                        <li class="active">
                            <form name="form2" id="form2" method="GET" class="form padding-b-15">
                                <!-- <div id="inexid">
                                    <div class="col-md-3">
                                        <label class="label" style="color: white;">INCLUDE:</label>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="radio" name="inex" id="inclu" value="include" style="margin-top: -1px; margin-left: 25px; height:20px;border:0px; box-shadow: 0 0 0 0;">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="label" style="color: white;">EXCLUDE:</label>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="radio" name="inex" id="exclu" value="exclude" style="margin-top: -1px; margin-left: 27px; height:20px;border:0px; box-shadow: 0 0 0 0;">
                                    </div>
                                </div> -->
                                <!-- <div id="include"> -->
                                <input type="hidden" name="pagename" value="CaseLaws">
                                <input type="hidden" name="function_name" value="case_data">
                                <input type="hidden" id="dbsuffix" name="dbsuffix" value="0">
                                <!-- <?php 
                                    $sp_ids = $_SESSION['sub_id'];
                                    $que = mysqli_query($GLOBALS['con'],"SELECT DISTINCT sub_prod_name FROM sub_product WHERE sub_prod_id IN $sp_ids");
                                     while ($row3 = mysqli_fetch_array($que)) {
                                        // echo $sp_id = $row3['sub_prod_id'];
                                        $sp_name = $row3['sub_prod_name'];
                                ?>
                                <div class="col-md-16">
                                    <?php if ($sp_name == "Supreme Court Cases") {?>
                                    <div class="col-md-3">
                                        <label class="label">SC:</label>
                                    </div>
                                    <div class="col-md-5">
                                        <input type="checkbox" value="Supreme Court Cases" <?php if(($_REQUEST['sc']=='Supreme Court Cases')){ ?> checked <?php } ?> name="sc">
                                    </div>
                                    <?php } ?>
                                    <?php if ($sp_name == "High Court Cases") {?>
                                    <div class="col-md-3">
                                        <label class="label">HC:</label>
                                    </div>
                                    <div class="col-md-5">
                                        <input type="checkbox" value="High Court Cases" <?php if(($_REQUEST['hc']=='High Court Cases')){ ?> checked <?php } ?> name="hc">
                                    </div>
                                    <?php } ?>
                                </div>
                                <div class="col-md-16">
                                    <?php if ($sp_name == "CESTAT Cases") {?>
                                    <div class="col-md-3">
                                        <label class="label">CESTAT:</label>
                                    </div>
                                    <div class="col-md-5">
                                        <input type="checkbox" value="CESTAT Cases" <?php if(($_REQUEST['cc']=='CESTAT Cases')){ ?> checked <?php } ?> name="cc">
                                    </div>
                                    <?php } ?>
                                    <?php if ($sp_name == "Advance Ruling Authority") {?>
                                    <div class="col-md-3">
                                        <label class="label">AAR:</label>
                                    </div>
                                    <div class="col-md-5">
                                        <input type="checkbox" value="Advance Ruling Authority" <?php if(($_REQUEST['aar']=='Advance Ruling Authority')){ ?> checked <?php } ?> name="aar">
                                    </div>
                                    <?php } ?>
                                </div>
                                <div class="col-md-16">
                                    <?php if ($sp_name == "National Anti-Profiteering Authority") {?>
                                    <div class="col-md-3">
                                        <label class="label">NAA:</label>
                                    </div>
                                    <div class="col-md-5">
                                        <input type="checkbox" value="National Anti-Profiteering Authority" <?php if(($_REQUEST['naa']=='National Anti-Profiteering Authority')){ ?> checked <?php } ?> name="naa">
                                    </div>
                                    <?php } ?>
                                    <?php if ($sp_name == "AAAR") {?>
                                    <div class="col-md-3">
                                        <label class="label">AAAR:</label>
                                    </div>
                                    <div class="col-md-5">
                                        <input type="checkbox" value="AAAR" <?php if(($_REQUEST['aaar']=='AAAR')){ ?> checked <?php } ?> name="aaar">
                                    </div>
                                    <?php } ?>
                                </div>
                            <?php } ?> -->
                                <div class="input-group input-group-big">
                                    <label class="label">Keyword:</label>
                                    <input type="text" class="form-control" id="keyword" name="keyword" placeholder="Keyword"/>
                                </div>
                                <div style="padding-left: 30px;">
                                    <div class="col-md-3">
                                         <label class="label" style="color: white;">Exact:</label>
                                     </div>
                                     <div class="col-md-3">
                                        <input type="radio" style="margin-top: -6px; margin-left: 20px;" class="form-control" id="exactSearch" <?php if(($_REQUEST['exact_search']=='exact') || ($_REQUEST['exact_search']=='')) { ?> checked    <?php } ?> name="exact_search" value="exact" style="height:20px;border:0px;margin-top:-1px;box-shadow: 0 0 0 0;">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="label" style="color: white;">Like:</label>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="radio" style="margin-top: -6px; margin-left: 20px;" class="form-control" id="exactSearch" <?php if($_REQUEST['exact_search']=='like') { ?> checked <?php } ?> name="exact_search" value="like" style="height:20px;border:0px;margin-top:-1px;box-shadow: 0 0 0 0;">
                                    </div>
                                </div>
                                <div class="input-group input-group-big">
                                    <label class="label">Search In:</label>
                                    <select name="search_in" id="search_in" class="form-control">
                                        <option value="0" <?php if (isset($_REQUEST['search_in']) && ($_REQUEST['search_in'] == "0")) { echo "selected=selected"; } ?> data-dbsuffix="0">Select </option>   
                                        <option value="1" <?php if (isset($_REQUEST['search_in']) && ($_REQUEST['search_in'] == "1")) { echo "selected=selected"; } ?> data-dbsuffix="0">Headnote </option>
                                        <option value="2" <?php if (isset($_REQUEST['search_in']) && ($_REQUEST['search_in'] == "2")) { echo "selected=selected"; } ?>data-dbsuffix="0">Case Text</option>
                                    </select>
                                </div>
                                <div class="input-group input-group-big">
                                    <label class="label">Party Name:</label>
                                    <input type="text" class="form-control" id="party_name" placeholder="Party Name" name="party_name" value="<?php if (isset($_REQUEST['party_name']) && (!empty($_REQUEST['party_name']))) { echo $_REQUEST['party_name']; } ?>" />
                                </div>
                                <div class="input-group input-group-big">
                                    <label class="label">Judge Name:</label>
                                    <input type="text" class="form-control" id="judge_name" placeholder="Judge Name" name="judge_name" value="<?php if (isset($_REQUEST['judge_name']) && (!empty($_REQUEST['judge_name']))) { echo $_REQUEST['judge_name']; } ?>" />
                                </div>
                                <!-- <div class="input-group input-group-big">
                                    <label class="label">Order No:</label>
                                    <input type="text" class="form-control" id="order_no" placeholder="Order No" name="order_no" value="<?php if (isset($_REQUEST['order_no']) && (!empty($_REQUEST['order_no']))) { echo $_REQUEST['order_no']; } ?>" />
                                </div>
                                <div class="input-group input-group-big">
                                    <label class="label">Case No:</label>
                                    <input type="text" class="form-control" id="case_no" placeholder="Case No" name="case_no" value="<?php if (isset($_REQUEST['case_no']) && (!empty($_REQUEST['case_no']))) { echo $_REQUEST['case_no']; } ?>" />
                                </div> -->
                                <div class="input-group input-group-big">
                                    <label class="label">Category:</label>
                                    <select name="prod_id" id="prod_id" class="form-control">
                                        <!-- <option value="<?php if (isset($_REQUEST['prod_id'])) { echo $_REQUEST['prod_id']; } ?>" data-dbsuffix="<?php echo $_REQUEST['prod_id']; ?>">
                                            <?php
                                                // if ($_REQUEST['prod_id'] == "1") {
                                                //     echo "VAT/Sales Tax";
                                                // } elseif ($_REQUEST['prod_id'] == "2") {
                                                //     echo "Service Tax";
                                                // } elseif ($_REQUEST['prod_id'] == "4") {
                                                //     echo "Central Excise";
                                                // } elseif ($_REQUEST['prod_id'] == "5") {
                                                //     echo "Customs";
                                                // } elseif ($_REQUEST['prod_id'] == "7") {
                                                //     echo "GST";
                                                // }
                                            ?>
                                        </option> -->
                                        <option value="0" <?php if (isset($_REQUEST['prod_id']) && ($_REQUEST['prod_id'] == "0")) { echo "selected=selected"; } ?> data-dbsuffix="0">Select</option>
                                        <option value="7" <?php if (isset($_REQUEST['prod_id']) && ($_REQUEST['prod_id'] == "7")) { echo "selected=selected"; } ?> data-dbsuffix="0">GST</option>
                                        <option value="1" <?php if (isset($_REQUEST['prod_id']) && ($_REQUEST['prod_id'] == "1")) { echo "selected=selected"; } ?> data-dbsuffix="0">VAT/Sales Tax</option>
                                        <option value="4" <?php if (isset($_REQUEST['prod_id']) && ($_REQUEST['prod_id'] == "4")) { echo "selected=selected"; } ?> data-dbsuffix="0">Central Excise</option>
                                        <option value="2" <?php if (isset($_REQUEST['prod_id']) && ($_REQUEST['prod_id'] == "2")) { echo "selected=selected"; } ?> data-dbsuffix="0">Service Tax</option>
                                        <option value="5" <?php if (isset($_REQUEST['prod_id']) && ($_REQUEST['prod_id'] == "5")) { echo "selected=selected"; } ?> data-dbsuffix="0">Customs</option>
                                    </select>
                                </div>
                                <div class="input-group input-group-big">
                                    <label class="label">Court/Forum:</label>
                                    <select id='court' name='court' class="form-control">
                                        <!-- <option value="<?php if (isset($_REQUEST['court'])) { echo $_REQUEST['court']; } ?>"data-dbsuffix="<?php echo $_REQUEST['court']; ?>">
                                            <?php
                                                // if ($_REQUEST['court'] == "SC") {
                                                //     echo "Supreme Court";
                                                // } elseif ($_REQUEST['court'] == "HC") {
                                                //     echo "High Court";
                                                // } elseif ($_REQUEST['court'] == "TRI") {
                                                //     echo "CESTAT Cases";
                                                // } elseif ($_REQUEST['court'] == "AAR") {
                                                //     echo "AAR";
                                                // } elseif ($_REQUEST['court'] == "NAA") {
                                                //     echo "NAA";
                                                // } elseif ($_REQUEST['court'] == "AAAR") {
                                                //     echo "AAAR";
                                                // }
                                            ?>
                                        </option> -->
                                        <option value="0" <?php if (isset($_REQUEST['court']) && ($_REQUEST['court'] == "0")) { echo "selected=selected"; } ?>data-dbsuffix="<?php echo $_REQUEST['court']; ?>">Select</option>
                                        <option value="SC" <?php if (isset($_REQUEST['court']) && ($_REQUEST['court'] == "SC")) { echo "selected=selected"; } ?>data-dbsuffix="<?php echo $_REQUEST['court']; ?>">Supreme Court</option>
                                        <option value="HC" <?php if (isset($_REQUEST['court']) && ($_REQUEST['court'] == "HC")) { echo "selected=selected"; } ?>data-dbsuffix="<?php echo $_REQUEST['court']; ?>">High Court</option>
                                        <option value="TRI" <?php if (isset($_REQUEST['court']) && ($_REQUEST['court'] == "TRI")) { echo "selected=selected"; } ?>data-dbsuffix="<?php echo $_REQUEST['court']; ?>">CESTAT Cases</option>
                                        <option value="AAR" <?php if (isset($_REQUEST['court']) && ($_REQUEST['court'] == "AAR")) { echo "selected=selected"; } ?>data-dbsuffix="<?php echo $_REQUEST['court']; ?>">AAR</option>
                                        <option value="NAA" <?php if (isset($_REQUEST['court']) && ($_REQUEST['court'] == "NAA")) { echo "selected=selected"; } ?>data-dbsuffix="<?php echo $_REQUEST['court']; ?>">NAA</option>
                                        <option value="AAAR" <?php if (isset($_REQUEST['court']) && ($_REQUEST['court'] == "AAAR")) { echo "selected=selected"; } ?>data-dbsuffix="<?php echo $_REQUEST['court']; ?>">AAAR</option>
                                    </select>
                                </div>
                                <div class="col-md-16 display" id='hc' style="margin-bottom: 10px;">
                                    <label class="col-md-6" style="color: #333; font-size: 14px; font-weight: 500;">Bench/City:</label>
                                    <select id='courtCityHC' name='courtCity' class="col-md-7 form-control">
                                        <option value="0">Select City</option>
                                        <option value="ALH" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == 'ALH')) { echo "selected=selected"; } ?>>Allahabad</option>
                                        <option value="AP" <?php  if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == 'AP')) {  echo "selected=selected"; } ?>>Andhra Pradesh</option>
                                        <option value="GAU" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == 'GAU')) { echo "selected=selected"; } ?>>Gauhati</option>
                                        <option value="CHG" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == 'CHG')) { echo "selected=selected"; } ?>>Chhattishgarh</option>
                                        <option value="DEL" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == 'DEL')) { echo "selected=selected"; } ?>>Delhi</option>
                                        <option value="BOM" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == 'BOM')) { echo "selected=selected"; } ?>>Bombay</option>
                                        <option value="GUJ" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == 'GUJ')) { echo "selected=selected"; } ?>>Gujarat</option>
                                        <option value="P_H" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == 'P_H')) { echo "selected=selected"; } ?>>Punjab & Haryana</option>
                                        <option value="J_K" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == 'J_K')) { echo "selected=selected"; } ?>>Jammu & Kashmir</option>
                                        <option value="JHR" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == 'JHR')) { echo "selected=selected"; } ?>>Jharkhand</option>
                                        <option value="KER" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == 'KER')) { echo "selected=selected"; } ?>>Kerala</option>
                                        <option value="KAR" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == 'KAR')) { echo "selected=selected"; } ?>>Karnataka</option>
                                        <option value="RAJ" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == 'RAJ')) { echo "selected=selected"; } ?>>Rajasthan</option>
                                        <option value="ORI" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == 'ORI')) { echo "selected=selected"; } ?>>Odisha</option>
                                        <option value="MAD" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == 'MAD')) { echo "selected=selected"; } ?>>Madras</option>
                                        <option value="UTR" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == 'UTR')) { echo "selected=selected"; } ?>>Uttarakhand</option>
                                        <option value="CAL" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == 'CAL')) { echo "selected=selected"; } ?>>Calcutta</option>
                                        <option value="MP" <?php  if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == 'MP')) { echo "selected=selected"; } ?>>Madhya Pradesh</option>
                                        <option value="SIK" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == 'SIK')) { echo "selected=selected"; } ?>>Sikkim</option>
                                        <option value="MEG" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == 'MEG')) { echo "selected=selected"; } ?>>Meghalaya</option>
                                        <option value="HP" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == 'HP')) { echo "selected=selected"; } ?>>Himachal Pradesh</option>
                                        <option value="PAT" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == 'PAT')) { echo "selected=selected"; } ?>>Patna</option>
                                        <option value="ORI" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == 'ORI')) { echo "selected=selected"; } ?>>Orissa</option>
                                        <option value="TEL" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == 'TEL')) { echo "selected=selected"; } ?>>Telangana</option>
                                        <option value="TRI" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == 'TRI')) { echo "selected=selected"; } ?>>Tripura</option>
                                    </select>
                                </div>
                                <div class="col-md-16 display" id='tri' style="margin-bottom: 10px;">
                                    <label class="col-md-6" style="color: #333; font-size: 14px; font-weight: 500;">Bench/City:</label>
                                    <select id='courtCityTRI' name='courtCity1' class="col-md-7 form-control">
                                        <option value="0">Select City</option>
                                        <option value="AHM" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == 'AHM')) { echo "selected=selected"; } ?>>Ahmedabad</option>
                                        <option value="ALH" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == 'ALH')) { echo "selected=selected"; } ?>>Allahabad</option>
                                        <option value="BLR" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == 'BLR')) { echo "selected=selected"; } ?>>Bangalore</option>
                                        <option value="CHD" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == 'CHD')) { echo "selected=selected"; } ?>>Chandigarh</option>
                                        <option value="CHE" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == 'CHE')) { echo "selected=selected"; } ?>>Chennai</option>
                                        <option value="DEL" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == 'DEL')) { echo "selected=selected"; } ?>>Delhi</option>
                                        <option value="HYD" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == 'HYD')) { echo "selected=selected"; } ?>>Hyderabad</option>
                                        <option value="KOL" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == 'KOL')) { echo "selected=selected"; } ?>>Kolkata</option>
                                        <option value="MUM" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == 'MUM')) { echo "selected=selected"; } ?>>Mumbai</option>
                                    </select>
                                </div>
                                <div class="col-md-16 display" id='aar' style="margin-bottom: 10px;">
                                    <label class="col-md-6" style="color: #333; font-size: 14px; font-weight: 500;">Bench/City:</label>
                                    <select id='courtCityAAR' name='courtCityAAR' class="col-md-7 form-control" >
                                        <option value="0">Select STATE</option>
                                        <option value="1" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == '1')) { echo "selected=selected"; } ?>>Andaman and Nicobar Islands</option>
                                        <option value="2" <?php  if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == '2')) {  echo "selected=selected"; } ?>>Andhra Pradesh</option>
                                        <option value="3" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == '3')) { echo "selected=selected"; } ?>>Arunachal Pradesh</option>
                                        <option value="4" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == '4')) { echo "selected=selected"; } ?>>Assam</option>
                                        <option value="5" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == '5')) { echo "selected=selected"; } ?>>Assam</option>
                                        <option value="6" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == '6')) { echo "selected=selected"; } ?>>Chandigarh</option>
                                        <option value="7" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == '7')) { echo "selected=selected"; } ?>>Chhattisgarh</option>
                                        <option value="8" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == '8')) { echo "selected=selected"; } ?>>Dadra and Nagar Haveli</option>
                                        <option value="9" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == '9')) { echo "selected=selected"; } ?>>Daman and Diu</option>
                                        <option value="10" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == '10')) { echo "selected=selected"; } ?>>Delhi</option>
                                        <option value="11" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == '11')) { echo "selected=selected"; } ?>>Goa</option>
                                        <option value="12" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == '12')) { echo "selected=selected"; } ?>>Gujarat</option>
                                        <option value="13" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == '13')) { echo "selected=selected"; } ?>>Haryana</option>
                                        <option value="14" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == '14')) { echo "selected=selected"; } ?>>Himachal Pradesh</option>
                                        <option value="15" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == '15')) { echo "selected=selected"; } ?>>Jammu and Kashmir</option>
                                        <option value="16" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == '16')) { echo "selected=selected"; } ?>>Jharkhand</option>
                                        <option value="17" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == '17')) { echo "selected=selected"; } ?>>Karnataka</option>
                                        <option value="18" <?php  if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == '18')) { echo "selected=selected"; } ?>>Kerala</option>
                                        <option value="19" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == '19')) { echo "selected=selected"; } ?>>Lakshadweep</option>
                                        <option value="20" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == '20')) { echo "selected=selected"; } ?>>Madhya Pradesh</option>
                                        <option value="21" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == '21')) { echo "selected=selected"; } ?>>Maharashtra</option>
                                        <option value="22" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == '22')) { echo "selected=selected"; } ?>>Manipur</option>
                                        <option value="23" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == '23')) { echo "selected=selected"; } ?>>Meghalaya</option>
                                        <option value="24" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == '24')) { echo "selected=selected"; } ?>>Mizoram</option>
                                        <option value="25" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == '25')) { echo "selected=selected"; } ?>>Nagaland</option>
                                        <option value="26" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == '26')) { echo "selected=selected"; } ?>>Orissa</option>
                                        <option value="27" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == '27')) { echo "selected=selected"; } ?>>Puducherry</option>
                                        <option value="28" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == '28')) { echo "selected=selected"; } ?>>Punjab</option>
                                        <option value="29" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == '29')) { echo "selected=selected"; } ?>>Rajasthan</option>
                                        <option value="30" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == '30')) { echo "selected=selected"; } ?>>Sikkim</option>
                                        <option value="31" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == '31')) { echo "selected=selected"; } ?>>Tamil Nadu</option>
                                        <option value="32" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == '32')) { echo "selected=selected"; } ?>>Tripura</option>
                                        <option value="33" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == '33')) { echo "selected=selected"; } ?>>Uttar Pradesh</option>
                                        <option value="34" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == '34')) { echo "selected=selected"; } ?>>Uttarakhand</option>
                                        <option value="35" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == '35')) { echo "selected=selected"; } ?>>West Bengal</option>
                                        <option value="36" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == '36')) { echo "selected=selected"; } ?>>Telangana</option>
                                        <option value="37" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == '37')) { echo "selected=selected"; } ?>>Central</option>
                                    </select>
                                </div>
                                <div class="col-md-16 display" id='aaar' style="margin-bottom: 10px;">
                                    <label class="col-md-6" style="color: #333; font-size: 14px; font-weight: 500;">Bench/City:</label>
                                    <select id='courtCityAAAR' name='courtCityAAAR' class="col-md-7 form-control" >
                                        <option value="0">Select STATE</option>
                                        <option value="1" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == '1')) { echo "selected=selected"; } ?>>Andaman and Nicobar Islands</option>
                                        <option value="2" <?php  if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == '2')) {  echo "selected=selected"; } ?>>Andhra Pradesh</option>
                                        <option value="3" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == '3')) { echo "selected=selected"; } ?>>Arunachal Pradesh</option>
                                        <option value="4" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == '4')) { echo "selected=selected"; } ?>>Assam</option>
                                        <option value="5" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == '5')) { echo "selected=selected"; } ?>>Assam</option>
                                        <option value="6" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == '6')) { echo "selected=selected"; } ?>>Chandigarh</option>
                                        <option value="7" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == '7')) { echo "selected=selected"; } ?>>Chhattisgarh</option>
                                        <option value="8" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == '8')) { echo "selected=selected"; } ?>>Dadra and Nagar Haveli</option>
                                        <option value="9" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == '9')) { echo "selected=selected"; } ?>>Daman and Diu</option>
                                        <option value="10" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == '10')) { echo "selected=selected"; } ?>>Delhi</option>
                                        <option value="11" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == '11')) { echo "selected=selected"; } ?>>Goa</option>
                                        <option value="12" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == '12')) { echo "selected=selected"; } ?>>Gujarat</option>
                                        <option value="13" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == '13')) { echo "selected=selected"; } ?>>Haryana</option>
                                        <option value="14" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == '14')) { echo "selected=selected"; } ?>>Himachal Pradesh</option>
                                        <option value="15" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == '15')) { echo "selected=selected"; } ?>>Jammu and Kashmir</option>
                                        <option value="16" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == '16')) { echo "selected=selected"; } ?>>Jharkhand</option>
                                        <option value="17" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == '17')) { echo "selected=selected"; } ?>>Karnataka</option>
                                        <option value="18" <?php  if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == '18')) { echo "selected=selected"; } ?>>Kerala</option>
                                        <option value="19" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == '19')) { echo "selected=selected"; } ?>>Lakshadweep</option>
                                        <option value="20" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == '20')) { echo "selected=selected"; } ?>>Madhya Pradesh</option>
                                        <option value="21" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == '21')) { echo "selected=selected"; } ?>>Maharashtra</option>
                                        <option value="22" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == '22')) { echo "selected=selected"; } ?>>Manipur</option>
                                        <option value="23" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == '23')) { echo "selected=selected"; } ?>>Meghalaya</option>
                                        <option value="24" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == '24')) { echo "selected=selected"; } ?>>Mizoram</option>
                                        <option value="25" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == '25')) { echo "selected=selected"; } ?>>Nagaland</option>
                                        <option value="26" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == '26')) { echo "selected=selected"; } ?>>Orissa</option>
                                        <option value="27" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == '27')) { echo "selected=selected"; } ?>>Puducherry</option>
                                        <option value="28" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == '28')) { echo "selected=selected"; } ?>>Punjab</option>
                                        <option value="29" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == '29')) { echo "selected=selected"; } ?>>Rajasthan</option>
                                        <option value="30" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == '30')) { echo "selected=selected"; } ?>>Sikkim</option>
                                        <option value="31" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == '31')) { echo "selected=selected"; } ?>>Tamil Nadu</option>
                                        <option value="32" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == '32')) { echo "selected=selected"; } ?>>Tripura</option>
                                        <option value="33" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == '33')) { echo "selected=selected"; } ?>>Uttar Pradesh</option>
                                        <option value="34" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == '34')) { echo "selected=selected"; } ?>>Uttarakhand</option>
                                        <option value="35" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == '35')) { echo "selected=selected"; } ?>>West Bengal</option>
                                        <option value="36" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == '36')) { echo "selected=selected"; } ?>>Telangana</option>
                                        <option value="37" <?php if (isset($_REQUEST['courtCity']) && ($_REQUEST['courtCity'] == '37')) { echo "selected=selected"; } ?>>Central</option>
                                    </select>
                                </div>
                                <div class="col-md-16">
                                    <label class="col-md-3" style="color: #333; font-size: 14px; font-weight: 500;">CGST Section:</label>
                                    <div class="col-md-5">
                                        <input type="text" class="form-control" id="cgst_section" placeholder="" name="cgst_section" value="<?php if (isset($_REQUEST['cgst_section']) && (!empty($_REQUEST['cgst_section']))) { echo $_REQUEST['cgst_section']; } ?>" onkeypress="return isNumberKey(event)" />
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" id="cgst_section" placeholder="" name="cgst_section1" value="<?php if (isset($_REQUEST['cgst_section1']) && (!empty($_REQUEST['cgst_section1']))) { echo $_REQUEST['cgst_section1']; } ?>" />
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" id="cgst_section2" placeholder="" name="cgst_section2" value="<?php if (isset($_REQUEST['cgst_section2']) && (!empty($_REQUEST['cgst_section2']))) { echo $_REQUEST['cgst_section2']; } ?>" />
                                    </div>
                                </div>
                                <div class="col-md-16">
                                    <label class="col-md-3" style="color: #333; font-size: 14px; font-weight: 500;">CGST Rule:</label>
                                    <div class="col-md-5">
                                        <input type="text" class="form-control" id="cgst_rule" placeholder="" name="cgst_rule" value="<?php if (isset($_REQUEST['cgst_rule']) && (!empty($_REQUEST['cgst_rule']))) { echo $_REQUEST['cgst_rule']; } ?>" onkeypress="return isNumberKey(event)" />
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" id="cgst_rule1" placeholder="" name="cgst_rule1" value="<?php if (isset($_REQUEST['cgst_rule1']) && (!empty($_REQUEST['cgst_rule1']))) { echo $_REQUEST['cgst_rule1']; } ?>" />
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" id="cgst_rule2" placeholder="" name="cgst_rule2" value="<?php if (isset($_REQUEST['cgst_rule2']) && (!empty($_REQUEST['cgst_rule2']))) { echo $_REQUEST['cgst_rule2']; } ?>" />
                                    </div>
                                </div>
                                <div class="col-md-16">
                                    <label class="col-md-3" style="color: #333; font-size: 14px; font-weight: 500;">IGST Section:</label>
                                    <div class="col-md-5">
                                        <input type="text" class="form-control" id="igst_section" placeholder="" name="igst_section" value="<?php if (isset($_REQUEST['igst_section']) && (!empty($_REQUEST['igst_section']))) { echo $_REQUEST['igst_section']; } ?>" onkeypress="return isNumberKey(event)" />
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" id="igst_section" placeholder="" name="igst_section1" value="<?php if (isset($_REQUEST['igst_section1']) && (!empty($_REQUEST['igst_section1']))) { echo $_REQUEST['igst_section1']; } ?>" />
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" id="igst_section2" placeholder="" name="igst_section2" value="<?php if (isset($_REQUEST['igst_section2']) && (!empty($_REQUEST['igst_section2']))) { echo $_REQUEST['igst_section2']; } ?>" />
                                    </div>
                                </div>
                                <div class="col-md-16">
                                    <label class="col-md-3" style="color: #333; font-size: 14px; font-weight: 500;">IGST Rule:</label>
                                    <div class="col-md-5">
                                        <input type="text" class="form-control" id="igst_rule" placeholder="" name="igst_rule" value="<?php if (isset($_REQUEST['igst_rule']) && (!empty($_REQUEST['igst_rule']))) {  echo $_REQUEST['igst_rule']; } ?>" onkeypress="return isNumberKey(event)"/>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" id="igst_rule1" placeholder="" name="igst_rule1" value="<?php if (isset($_REQUEST['igst_rule1']) && (!empty($_REQUEST['igst_rule1']))) { echo $_REQUEST['igst_rule1']; } ?>" />
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" id="igst_rule2" placeholder="" name="igst_rule2" value="<?php if (isset($_REQUEST['igst_rule2']) && (!empty($_REQUEST['igst_rule2']))) { echo $_REQUEST['igst_rule2']; } ?>" />
                                    </div>
                                </div>
                                <!-- <div class="input-group input-group-big">
                                    <label class="label">VIL Citation:</label>
                                    <div class="col-md-6">
                                        <select class="form-control" id="year" name="year" >
                                            <option value=''>Year</option>
                                            <?php
                                                for ($i = 1945; $i <= date('Y'); $i++) { ?>
                                            <option <?php
                                                if (isset($_REQUEST['year']) && ($_REQUEST['year'] == $i)) {
                                                    echo "selected=selected"; } ?>><?php echo $i; ?></option>
                                            <?php  }  ?>
                                        </select>
                                    </div>
                                    <div class="col-md-1 text-center" style="margin-top: 10px; padding-left: 40px;">
                                        <p class="text" style="font-size: 14px;"> VIL</p>
                                    </div>
                                    <div class="col-md-4" style="margin-top: 10px; padding-left: 20px;">
                                        <input type="text" class="form-control" id="vol" placeholder="Volumn" name="vol" value="<?php if (isset($_REQUEST['vol']) && (!empty($_REQUEST['vol']))) { echo $_REQUEST['vol']; } ?>" onkeypress="return isNumberKey(event)"/>
                                    </div>
                                    <div class="col-md-1 text-center" style="margin-top: 10px;"> - </div>
                                    <div class="col-md-4" style="margin-top: 10px;">
                                        <input type="text" class="form-control" id="Citation" placeholder="" name="Citation" value="<?php if (isset($_REQUEST['Citation']) && (!empty($_REQUEST['Citation']))) { echo $_REQUEST['Citation']; } ?>" />
                                    </div>
                                </div> -->
                                <div class="col-md-16 input-group" style="padding-left: 4px;">
                                    <label class="col-md-3" style="color: #333; font-size: 14px; font-weight: 500;">Date:</label>
                                    <input class="col-md-8 input--style-1" type="date" id="date" placeholder="Date" name="date" value="<?php if (isset($_REQUEST['date']) && (!empty($_REQUEST['date']))) { echo $_REQUEST['date']; } ?>" />
                                </div>
                                <div class="col-md-16 input-group" style="padding-left: 4px;">
                                    <label class="col-md-3" style="color: #333; font-size: 14px; font-weight: 500;">From Date:</label>
                                    <input class="col-md-8 input--style-1" type="date" id="dt_from" placeholder="" name="dt_from" value="<?php if (isset($_REQUEST['dt_from']) && (!empty($_REQUEST['dt_from']))) { echo $_REQUEST['dt_from']; } ?>" />
                                </div>
                                <div class="col-md-16 input-group" style="padding-left: 4px;">
                                    <label class="col-md-3" style="color: #333; font-size: 14px; font-weight: 500;">To Date:</label>
                                    <input class="col-md-8 input--style-1" type="date" id="dt_to" placeholder="" name="dt_to" value="<?php if (isset($_REQUEST['dt_to']) && (!empty($_REQUEST['dt_to']))) { echo $_REQUEST['dt_to']; } ?>" />
                                </div>    
                                <div style="
                                    display: flex;
                                    justify-content: center;
                                ">   
                                    <input type="submit" name="searchButton2" id="searchButton2" value="Search" class="btn-submit m-t-35" style="background: linear-gradient(to bottom, #00789e 0%,#00548a 100%);width: 10vw;">
                                </div>                       
                                <!-- </div>
                                <div id="exclude">test</div> -->
                            </form>
                    </li><?php } elseif ($_REQUEST['pagename'] == 'Acts and Rules') {?>
                    <li>
                        <form name="form2" id="form2" method="GET" class="form padding-b-15">
                            <input type="hidden" name="pagename" value="Acts and Rules">
                            <input type="hidden" name="function_name" value="act">
                            <input type="hidden" id="dbsuffix" name="dbsuffix" value="<?php if (isset($_REQUEST['dbsuffix']) && (!empty($_REQUEST['dbsuffix']))) { echo $_REQUEST['dbsuffix']; } else { echo ""; }
                            ?>cgst">

                            <div class="input-group input-group-big">
                                <label class="label">Keyword:</label>
                                <input type="text" class="form-control" id="keyword" name="keyword" placeholder="Keyword"/>
                            </div>
                            <div style="padding-left: 30px;">
                                <div class="col-md-3">
                                     <label class="label" style="color: white;">Exact:</label>
                                 </div>
                                 <div class="col-md-3">
                                    <input type="radio" style="margin-top: -6px; margin-left: 20px;" class="form-control" id="exactSearch" <?php if(($_REQUEST['exact_search']=='exact') || ($_REQUEST['exact_search']=='')) { ?> checked    <?php } ?> name="exact_search" value="exact" style="height:20px;border:0px;margin-top:-1px;box-shadow: 0 0 0 0;">
                                </div>
                                <div class="col-md-2">
                                    <label class="label" style="color: white;">Like:</label>
                                </div>
                                <div class="col-md-3">
                                    <input type="radio" style="margin-top: -6px; margin-left: 20px;" class="form-control" id="exactSearch" <?php if($_REQUEST['exact_search']=='like') { ?> checked <?php } ?> name="exact_search" value="like" style="height:20px;border:0px;margin-top:-1px;box-shadow: 0 0 0 0;">
                                </div>
                            </div>
                            <div class="input-group input-group-big">
                                <label class="label">Search Type:</label>
                                <select name="type" id="type" class="form-control">
                                    <option value="">Select Type</option>
                                        <option value="Acts" <?php if (isset($_REQUEST['type']) && $_REQUEST['type'] == 'Acts') { echo "selected"; } ?>>Acts</option>
                                        <option value="Rules" <?php if (isset($_REQUEST['type']) && $_REQUEST['type'] == 'Rules') { echo "selected"; } ?>>Rules</option>
                                        <!-- <option value="Notification" <?php if (isset($_REQUEST['type']) && $_REQUEST['type'] == 'Notification') { echo "selected"; } ?>>Notification</option> -->
                                        <option value="Policy" <?php if (isset($_REQUEST['type']) && $_REQUEST['type'] == 'Policy') { echo "selected"; } ?>>Policy</option>
                                        <option value="Policy Circular" <?php if (isset($_REQUEST['type']) && $_REQUEST['type'] == 'Policy Circular') { echo "selected"; } ?>>Policy Circular</option>
                                        <option value="Procedure" <?php if (isset($_REQUEST['type']) && $_REQUEST['type'] == 'Procedure') { echo "selected"; } ?>>Procedure</option>
                                        <option value="Public Notice" <?php if (isset($_REQUEST['type']) && $_REQUEST['type'] == 'Public Notice') { echo "selected"; } ?>>Public Notice</option>
                                        <option value="Trade Notice" <?php if (isset($_REQUEST['type']) && $_REQUEST['type'] == 'Trade Notice') { echo "selected"; } ?>>Trade Notice</option>
                                </select>
                            </div>
                            <div class="input-group input-group-big">
                                <label class="label">Category:</label>
                                <select name="prod_id" id="prod_id" class="form-control">
                                    <option value="0" <?php if (isset($_REQUEST['prod_id']) && ($_REQUEST['prod_id'] == "0")) { echo "selected=selected"; } ?> data-dbsuffix="0">Select</option>
                                    <option value="10" <?php if (isset($_REQUEST['prod_id']) && ($_REQUEST['prod_id'] == "10")) { echo "selected=selected"; } ?> data-dbsuffix="cgst">CGST</option>
                                    <option value="9" <?php if (isset($_REQUEST['prod_id']) && ($_REQUEST['prod_id'] == "9")) { echo "selected=selected"; } ?> data-dbsuffix="IGST">IGST</option>
                                    <option value="7" <?php if (isset($_REQUEST['prod_id']) && ($_REQUEST['prod_id'] == "7")) { echo "selected=selected"; } ?> data-dbsuffix="SGST">SGST</option>
                                    <option value="8" <?php if (isset($_REQUEST['prod_id']) && ($_REQUEST['prod_id'] == "8")) { echo "selected=selected"; } ?> data-dbsuffix="UTGST">UTGST</option>
                                    <option value="5" <?php if (isset($_REQUEST['prod_id']) && ($_REQUEST['prod_id'] == "5")) { echo "selected=selected"; } ?> data-dbsuffix="Customs">Customs</option>
                                    <option value="4" <?php if (isset($_REQUEST['prod_id']) && ($_REQUEST['prod_id'] == "4")) { echo "selected=selected"; } ?> data-dbsuffix="ce">Central Excise</option>
                                    <option value="6" <?php if (isset($_REQUEST['prod_id']) && ($_REQUEST['prod_id'] == "6")) { echo "selected=selected"; } ?> data-dbsuffix="DGFT">DGFT</option>
                                </select>
                            </div>
                            <div class="col-md-16 display" id="section">
                                <label class="col-md-5" style="color: #333; font-size: 14px; font-weight: 500;">Section No.:</label>
                                <input type="text" class="col-md-8 form-control" id="section_no" name="section_no" value="<?php if (isset($_REQUEST['section_no']) && !empty($_REQUEST['section_no'])) { echo $_REQUEST['section_no']; } ?>" placeholder="Section No." />
                            </div>
                            <div class="col-md-16 display" id="rule">
                                <label class="col-md-5" style="color: #333; font-size: 14px; font-weight: 500;">Rule No.:</label>
                                <input type="text" class="col-md-8 form-control" id="rule_no" name="rule_no" value="<?php if (isset($_REQUEST['rule_no']) && !empty($_REQUEST['rule_no'])) { echo $_REQUEST['rule_no']; } ?>" placeholder="Rule No." />
                            </div>
                            <!-- <div class="input-group input-group-big display" id="notification">
                                <label class="label" style="width: 1%;">Notification:</label>
                                <input style="width: 100%;" type="text" class="form-control" id="notification" name="notification" value="<?php if (isset($_REQUEST['notification']) && !empty($_REQUEST['notification'])) { echo $_REQUEST['notification']; } ?>" placeholder="Notification" />
                            </div> -->
                            <div class="col-md-16 display" id="policy">
                                <label class="col-md-5" style="color: #333; font-size: 14px; font-weight: 500;">Policy:</label>
                                <input type="text" class="col-md-8 form-control" id="policy" name="policy" value="<?php if (isset($_REQUEST['policy']) && !empty($_REQUEST['policy'])) { echo $_REQUEST['policy']; } ?>" placeholder="Policy" />
                            </div>
                            <div class="col-md-16 display" id="policy_circular">
                                <label class="col-md-5" style="color: #333; font-size: 14px; font-weight: 500;">Policy Circular:</label>
                                <input type="text" class="col-md-8 form-control" id="policy_circular" name="policy_circular" value="<?php if (isset($_REQUEST['policy_circular']) && !empty($_REQUEST['policy_circular'])) { echo $_REQUEST['policy_circular']; } ?>" placeholder="Policy Circular" />
                            </div>
                            <div class="col-md-16 display" id="procedure">
                                <label class="col-md-5" style="color: #333; font-size: 14px; font-weight: 500;">Procedure:</label>
                                <input type="text" class="col-md-8 form-control" id="procedure" name="procedure" value="<?php if (isset($_REQUEST['procedure']) && !empty($_REQUEST['procedure'])) { echo $_REQUEST['procedure']; } ?>" placeholder="Procedure" />
                            </div>
                            <div class="col-md-16 display" id="public_notice">
                                <label class="col-md-5" style="color: #333; font-size: 14px; font-weight: 500;">Public Notice:</label>
                                <input type="text" class="col-md-8 form-control" id="public_notice" name="public_notice" value="<?php if (isset($_REQUEST['public_notice']) && !empty($_REQUEST['public_notice'])) { echo $_REQUEST['public_notice']; } ?>" placeholder="Public Notice" />
                            </div>
                            <div class="col-md-16 display" id="trade_notice">
                                <label class="col-md-5" style="color: #333; font-size: 14px; font-weight: 500;">Trade Notice:</label>
                                <input type="text" class="col-md-8 form-control" id="trade_notice" name="trade_notice" value="<?php if (isset($_REQUEST['trade_notice']) && !empty($_REQUEST['trade_notice'])) { echo $_REQUEST['trade_notice']; } ?>" placeholder="Trade Notice" />
                            </div>
                            <input style="margin-top: 10px;" type="submit" name="searchButton2" id="searchButton2" value="Search" class="btn-submit m-t-35"/>
                        </form>
                    </li><?php } elseif ($_REQUEST['pagename'] == 'Notification') { ?>
                    <li>
                        <form name="form2" id="form2" method="GET" class="form padding-b-15">
                            <input type="hidden" id="sel_type" name="sel_type" value="<?php if (isset($_REQUEST['type'])) {  echo $_REQUEST['type']; } ?>">
                            <input type="hidden" id="cat_type" name="cat_type" value="<?php if (isset($_REQUEST['sub_product_id'])) { echo $_REQUEST['sub_product_id']; } ?>">
                            <input type="hidden" id="st_id" name="st_id" value="<?php if (isset($_REQUEST['state_id'])) {  echo $_REQUEST['state_id']; } ?>">
                            <input type="hidden" name="pagename" value="Notification">
                            <input type="hidden" name="function_name" value="notification">
                            <input type="hidden" id="dbsuffix" name="dbsuffix" value="0">
                            <!-- for Keyword -->
                            <div class="input-group input-group-big">
                                <label class="label">Keyword:</label>
                                <input type="text" class="form-control" id="keyword" placeholder="Keyword" name="keyword">
                            </div>
                            <div style="padding-left: 30px;">
                                <div class="col-md-3">
                                     <label class="label" style="color: white;">Exact:</label>
                                 </div>
                                 <div class="col-md-3">
                                    <input type="radio" style="margin-top: -6px; margin-left: 20px;" class="form-control" id="exactSearch" <?php if(($_REQUEST['exact_search']=='exact') || ($_REQUEST['exact_search']=='')) { ?> checked    <?php } ?> name="exact_search" value="exact" style="height:20px;border:0px;margin-top:-1px;box-shadow: 0 0 0 0;">
                                </div>
                                <div class="col-md-2">
                                    <label class="label" style="color: white;">Like:</label>
                                </div>
                                <div class="col-md-3">
                                    <input type="radio" style="margin-top: -6px; margin-left: 20px;" class="form-control" id="exactSearch" <?php if($_REQUEST['exact_search']=='like') { ?> checked <?php } ?> name="exact_search" value="like" style="height:20px;border:0px;margin-top:-1px;box-shadow: 0 0 0 0;">
                                </div>
                            </div>
                            <div class="input-group input-group-big">
                                <label class="label">Category:</label>
                                <select name="prod_id" id="product_id" class="form-control">
                                    <option value="<?php if (isset($_REQUEST['prod_id'])) { echo $_REQUEST['prod_id']; } ?>" data-dbsuffix="<?php echo $_REQUEST['prod_id']; ?>">
                                        <?php 
                                            if ($_REQUEST['prod_id']=="1") {
                                                echo "VAT";
                                            } elseif ($_REQUEST['prod_id']=="2"){
                                                echo "Service Tax";
                                            } elseif ($_REQUEST['prod_id']=="4"){
                                                echo "Central Excise";
                                            } elseif ($_REQUEST['prod_id']=="5"){
                                                echo "Customs";
                                            } elseif ($_REQUEST['prod_id']=="6"){
                                                echo "DGFT";
                                            } elseif ($_REQUEST['prod_id']=="7"){
                                                echo "SGST";
                                            } elseif ($_REQUEST['prod_id']=="9"){
                                                echo "IGST";
                                            } elseif ($_REQUEST['prod_id']=="10"){
                                                echo "CGST";
                                            }
                                        ?>
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-16 display" id="state" style="margin-bottom: 5px;">
                                <label class="col-md-7" style="color: #333; font-size: 14px; font-weight: 500;">State:</label>
                                <div class="col-md-9">
                                    <?php 
                                        if (isset($_REQUEST['state_id'])) {
                                            echo getStatDropdown($_REQUEST['state_id'], 'state_id');
                                        } else {
                                            echo getStatDropdown('', 'state_id');
                                        }
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-16 display" id="category_type" style="margin-bottom: 5px;">
                                <label class="col-md-7" style="color: #333; font-size: 14px; font-weight: 500;">Category Type:</label>
                                <div class="col-md-9" id="noti_div">
                                    <select id="sub_product_id" name="sub_product_id" class="form-control required"></select>
                                </div>
                            </div>
                            <div class="col-md-16 display" id="notification_type">
                                <label class="col-md-7" style="color: #333; font-size: 14px; font-weight: 500;">Notification Type:</label>
                                <div class="col-md-9" id="noti_div">
                                    <select id="not_type" name="type" class="form-control required"></select>
                                </div>
                            </div>
                            <div class="input-group input-group-big">
                                <label class="label">Notification No.:</label>
                                <input type="text" class="form-control" id="noti_no" placeholder="Notification No." name="noti_no" value="<?php if (isset($_REQUEST['noti_no']) && (!empty($_REQUEST['noti_no']))) {echo $_REQUEST['noti_no']; } ?>" />
                            </div>
                            <div class="col-md-16 input-group">
                                <label class="col-md-3" style="color: #333; font-size: 14px; font-weight: 500;">Date:</label>
                                <input class="col-md-8 input--style-1" type="date" id="date" placeholder="Notification Date" name="date" value="<?php if (isset($_REQUEST['date']) && (!empty($_REQUEST['date']))) { echo $_REQUEST['date']; } ?>" />
                            </div>       
                            <div class="col-md-16 input-group">
                                <label class="col-md-4" style="color: #333; font-size: 14px; font-weight: 500;">Date Range:</label>
                                <input class="col-md-7 input--style-1" type="date" id="dt_from" placeholder="" name="dt_from" value="<?php if (isset($_REQUEST['dt_from']) && (!empty($_REQUEST['dt_from']))) { echo $_REQUEST['dt_from']; } ?>" />
                            </div>
                        
                            <div class="col-md-16 input-group">
                                <label class="col-md-3" style="color: #333; font-size: 14px; font-weight: 500;">to:</label>
                                <input class="col-md-8 input--style-1" type="date" id="dt_to" placeholder="" name="dt_to" value="<?php if (isset($_REQUEST['dt_to']) && (!empty($_REQUEST['dt_to']))) { echo $_REQUEST['dt_to']; } ?>" />
                            </div>
                            <input type="submit" name="searchButton2" id="searchButton2" value="Search" class="btn-submit m-t-35"/>
                        </form>
                    </li><?php } elseif ($_REQUEST['pagename'] == 'Articles') { ?>
                    <li>
                        <form name="form2" id="form2" method="GET" class="form padding-b-15">
                            <input type="hidden" name="pagename" value="Articles">
                            <input type="hidden" name="function_name" value="articles">
                            <input type="hidden" id="" name="dbsuffix" value="articles">
                            <div class="input-group input-group-big">   
                                <label class="label">Keywords:</label>
                                <input type="text" class="form-control" id="text" name="keyword" placeholder="Keyword">
                            </div>
                            <div style="padding-left: 30px;">
                                <div class="col-md-3">
                                     <label class="label" style="color: white;">Exact:</label>
                                 </div>
                                 <div class="col-md-3">
                                    <input type="radio" style="margin-top: -6px; margin-left: 20px;" class="form-control" id="exactSearch" <?php if(($_REQUEST['exact_search']=='exact') || ($_REQUEST['exact_search']=='')) { ?> checked    <?php } ?> name="exact_search" value="exact" style="height:20px;border:0px;margin-top:-1px;box-shadow: 0 0 0 0;">
                                </div>
                                <div class="col-md-2">
                                    <label class="label" style="color: white;">Like:</label>
                                </div>
                                <div class="col-md-3">
                                    <input type="radio" style="margin-top: -6px; margin-left: 20px;" class="form-control" id="exactSearch" <?php if($_REQUEST['exact_search']=='like') { ?> checked <?php } ?> name="exact_search" value="like" style="height:20px;border:0px;margin-top:-1px;box-shadow: 0 0 0 0;">
                                </div>
                            </div>
                            <div class="input-group input-group-big">
                                <label class="label">Topic:</label>
                                <input type="text" class="form-control" id="topic" placeholder="Enter Topic"  name="topic" value="<?php if (isset($_REQUEST['topic']) && (!empty($_REQUEST['topic']))) {
                                    echo $_REQUEST['topic']; } ?>"/>
                            </div>
                            <div class="input-group input-group-big">
                                <label class="label">Category:</label>
                                <select id="" name="prod_id" class="form-control">
                                    <option value="0" <?php if (isset($_REQUEST['prod_id']) && ($_REQUEST['prod_id'] == '0')) { echo "selected=selected"; } ?>>Select</option>
                                    <option value="GST" <?php if (isset($_REQUEST['prod_id']) && ($_REQUEST['prod_id'] == 'GST')) { echo "selected=selected"; } ?>>GST</option>
                                    <option value="Others" <?php if (isset($_REQUEST['prod_id']) && ($_REQUEST['prod_id'] == 'Others')) { echo "selected=selected"; } ?>>Others</option>
                                </select>
                            </div>
                            <div class="col-md-16" style="margin-bottom: 5px;">
                                <label class="col-md-4" style="color: #333; font-size: 14px; font-weight: 500;">Author:</label>
                                <div class="col-md-12">
                                    <?php echo getAuthor('articles'); ?>      
                                </div>
                            </div>
                            <div class="col-md-16 input-group">
                                <label class="col-md-3" style="color: #333; font-size: 14px; font-weight: 500;">From Date:</label>
                                <input class="col-md-8 input--style-1" type="date" name="check-in" placeholder="From Date" id="fromDate" name="fromDate" value="<?php if (isset($_REQUEST['fromDate']) && (!empty($_REQUEST['fromDate']))) { echo $_REQUEST['fromDate']; } ?>"/>
                            </div>
                            <div class="col-md-16 input-group">
                                <label class="col-md-3" style="color: #333; font-size: 14px; font-weight: 500;">To Date:</label>
                                <input class="col-md-8 input--style-1" type="date" name="check-out" placeholder="To Date" id="toDate"  name="toDate" value="<?php if (isset($_REQUEST['toDate']) && (!empty($_REQUEST['toDate']))) { echo $_REQUEST['toDate']; } ?>"/>
                            </div>
                            <input type="submit" name="searchButton2" id="searchButton2" value="Search" class="btn-submit m-t-35"/>
                        </form>
                    </li><?php } elseif ($_REQUEST['pagename'] == 'tax vista') { ?>
                    <li>
                        <form name="form2" id="form2" method="GET" class="form padding-b-15">
                            <input type="hidden" name="pagename" value="tax vista">
                            <input type="hidden" name="function_name" value="tax_vista">
                            <input type="hidden" id="" name="dbsuffix" value="taxvista">
                            <div class="input-group input-group-big">   
                                <label class="label">Keywords:</label>
                                <input type="text" class="form-control" id="text" name="keyword" placeholder="Keyword">
                            </div>
                            <div style="padding-left: 30px;">
                                <div class="col-md-3">
                                     <label class="label" style="color: white;">Exact:</label>
                                 </div>
                                 <div class="col-md-3">
                                    <input type="radio" style="margin-top: -6px; margin-left: 20px;" class="form-control" id="exactSearch" <?php if(($_REQUEST['exact_search']=='exact') || ($_REQUEST['exact_search']=='')) { ?> checked    <?php } ?> name="exact_search" value="exact" style="height:20px;border:0px;margin-top:-1px;box-shadow: 0 0 0 0;">
                                </div>
                                <div class="col-md-2">
                                    <label class="label" style="color: white;">Like:</label>
                                </div>
                                <div class="col-md-3">
                                    <input type="radio" style="margin-top: -6px; margin-left: 20px;" class="form-control" id="exactSearch" <?php if($_REQUEST['exact_search']=='like') { ?> checked <?php } ?> name="exact_search" value="like" style="height:20px;border:0px;margin-top:-1px;box-shadow: 0 0 0 0;">
                                </div>
                            </div>
                            <div class="col-md-16 input-group">
                                <label class="col-md-3" style="color: #333; font-size: 14px; font-weight: 500;">From Date:</label>
                                <input class="col-md-8 input--style-1" type="date" name="check-in" placeholder="From Date" id="fromDate" name="fromDate" value="<?php if (isset($_REQUEST['fromDate']) && (!empty($_REQUEST['fromDate']))) { echo $_REQUEST['fromDate']; } ?>"/>
                            </div>
                            <div class="col-md-16 input-group">
                                <label class="col-md-3" style="color: #333; font-size: 14px; font-weight: 500;">To Date:</label>
                                <input class="col-md-8 input--style-1" type="date" name="check-out" placeholder="To Date" id="toDate"  name="toDate" value="<?php if (isset($_REQUEST['toDate']) && (!empty($_REQUEST['toDate']))) { echo $_REQUEST['toDate']; } ?>"/>
                            </div>
                            <input type="submit" name="searchButton2" id="searchButton2" value="Search" class="btn-submit m-t-35"/>
                        </form>
                    </li><?php } ?> 
                </ul>
            </div>
        </div>
    </nav>
    <div id="content" class="p-4 p-md-5 pt-5">
        <h2 class="mb-4">
            <?php 
                if (isset($_REQUEST['searchButton'])) {
                    echo $_REQUEST['pagename'] . ' - Advance Search';
                } else {
                    echo $_REQUEST['pagename'] . ' - Advance Search';
                }
            ?>
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo $getBaseUrl; ?>">Home</a>
                </li>
                <li class="active">
                    <?php
                        if (isset($_REQUEST['searchButton'])) {
                            echo $_REQUEST['pagename'] . ' - Advance Search';
                        } else {
                            echo $_REQUEST['pagename'] . ' - Advance Search';
                        }
                    ?>
                </li>
            </ol>
        </h2>
        <h4 style="color: #045854;">
            <?php 
                $key = $_SESSION['key'];
                if ($_REQUEST['keyword']) {?>
                    Showing Results For: <span style="color: #021147;"> <?php echo $key;
                    if (isset($_REQUEST['searchButton2'])) {
                        if ($_REQUEST['keyword']) {
                            echo "/".$_REQUEST['keyword'];
                        }
                    }?> </span>
            <?php } ?>
            
        </h4>
        <!--<h4 style="float: right;">-->
        <!--    <button class="btn btn-primary btn-lg" onclick="goBack()">Back</button>-->
        <!--    <script>-->
        <!--        function goBack() {-->
        <!--          window.history.back();-->
        <!--        }-->
        <!--    </script>-->
        <!--    <button class="btn btn-primary btn-lg" onclick="goForward()">Forward</button>-->
        <!--    <script>-->
        <!--        function goForward() {-->
        <!--            window.history.forward();-->
        <!--        }-->
        <!--    </script>-->
        <!--</h4>-->
        <div class="btn btn-primary tool" style="background: #ff7808; float: left; position: relative;top: 10px;left: 10px;">
            <a style="color: white;" href="#caselawForm" class="open-popup-link" data-effect="mfp-zoom-in">
                &nbsp;&nbsp;CRF&nbsp;&nbsp;
            </a>
            <span class="tooltiptext">Didn’t find desired Caselaws? Please submit CRF.</span>
        </div>
        <div style="float: right; font-size: 16px; background: #ff7808; border-radius: 6px; padding: 8px;">
            <a href="AdvancedSearch.php" style="color: white;">New Search</a>
        </div>
        <div class="card-body">
            <?php
                if (isset($_REQUEST['searchButton'])) {
                    $seoTitle = $_REQUEST['pagename'] . '- Advanced Search';
                    $seoKeywords = $_REQUEST['pagename'] . '- Advanced Search';
                    $seoDesc = $_REQUEST['pagename'] . '- Advanced Search';

                // Acts and Rules Page Search //
                    if ($_REQUEST['pagename'] == 'Acts and Rules') {
                        $row_count = $_SESSION['row_count'];
                        $text = mysqli_real_escape_string($con,$_REQUEST['keyword']);
                        $user_id = $_SESSION["id"];
                        $user_name = $_SESSION["user"];
                        $search_in = "Advance Search";
                        $page_name = "Acts & Rules";
                        $search_form_data = array(
                            'user_id' => $user_id,
                            'user_name' => $user_name,
                            'keyword' => $text,
                            'pagename' => $page_name,
                            'search_in' => $search_in,
                            'row_count' => $row_count,
                            'updated_dt' => date('Y-m-d H:i:s')
                        );
                        dbRowInsert('search_history', $search_form_data);
                        // $re = mysqli_query($GLOBALS['con'],"SELECT * FROM search_history");
                        // while($row = mysqli_fetch_array($re)) {
                        //     $search_id = $row['search_id'];
                        //     $user_id2 = $row['user_id'];
                        //     $user_name2 = $row['user_name'];
                        //     $keyword2 = $row['keyword'];
                        //     $page_name2 = $row['pagename'];
                        //     $updated_Date = $row['updated_dt'];
                        //     $search_form_data2 = array(
                        //         'search_id'=>$search_id,
                        //         'user_id' => $user_id2,
                        //         'user_name' => $user_name2,
                        //         'keyword' => $keyword2,
                        //         'pagename' => $page_name2,
                        //         'updated_dt' => date('Y-m-d H:i:s')
                        //     );
                        //     if (($user_id2 == $user_id) && ($keyword2 == $text) && ($page_name2 == $page_name) && ($updated_Date == $updated_Date)) {
                        //         //dbRowUpdate('search_history', $search_form_data2, " WHERE search_id = '" . $search_id . "'");
                        //         //dbRowDelete('search_history', " WHERE search_id = '" . $search_id . "' ");
                        //         // dbRowInsert('search_history', $search_form_data);
                        //     } else {
                                
                        //     }
                        // }

                        function act() {
                            global $con;
                            $conditions = array();
                            // for keyword
                            if ($_REQUEST['keyword'] != "") {
                                $keyword = mysqli_real_escape_string($con,$_REQUEST['keyword']);
                                $string = trim(clean($keyword));
                                $rep_data = shortForm($string);
                                $_SESSION['key'] = $keyword;

                                if($_REQUEST['exact_search']=='exact'){
                                    $variable = explode(",", $string);
                                    foreach ($variable as $v) {
                                        $conditions[] = "(a.cir_subject LIKE '%" . $v . "%' OR  
                                a.file_data LIKE '%" . $v . "%' OR  
                                a.party_name LIKE '%" . $v . "%' OR a.cir_subject LIKE '%" . $rep_data[0] . "%' OR  
                                a.file_data LIKE '%" . $rep_data[0] . "%' OR  
                                a.party_name LIKE '%" . $rep_data[0] . "%')";
                                    }
                                } else {
                                    $variable2 = explode(" ", $string);
                                    foreach ($variable2 as $v2) {
                                        $conditions[] = "(a.cir_subject LIKE '%" . $v2 . "%' OR  
                                a.file_data LIKE '%" . $v2 . "%' OR  
                                a.party_name LIKE '%" . $v2 . "%' OR a.cir_subject LIKE '%" . $rep_data[0] . "%' OR  
                                a.file_data LIKE '%" . $rep_data[0] . "%' OR  
                                a.party_name LIKE '%" . $rep_data[0] . "%')";
                                    }
                                }
                            }

                            // for section, rule, notification, etc.. number
                            if ($_REQUEST['type'] == "Acts") {
                                if (!empty($_REQUEST['section_no'])) {
                                    $conditions[] = "a.circular_no = 'Section " . $_REQUEST['section_no'] . "'";
                                }
                            } else if ($_REQUEST['type'] == "Rules") {
                                if (!empty($_REQUEST['rule_no'])) {
                                    $conditions[] = "a.circular_no = 'Rule " . $_REQUEST['rule_no'] . "'";
                                }
                            } else if ($_REQUEST['type'] == "Notification") {
                                if (!empty($_REQUEST['notification'])) {
                                    $conditions[] = "a.circular_no = 'Notification " . $_REQUEST['notification'] . "'";
                                }
                            } else if ($_REQUEST['type'] == "Policy") {
                                if (!empty($_REQUEST['policy'])) {
                                    $conditions[] = "a.circular_no = 'Policy " . $_REQUEST['policy'] . "'";
                                }
                            } else if ($_REQUEST['type'] == "Policy Circular") {
                                if (!empty($_REQUEST['policy_circular'])) {
                                    $conditions[] = "a.circular_no = 'Policy Circular " . $_REQUEST['policy_circular'] . "'";
                                }
                            } else if ($_REQUEST['type'] == "Procedure") {
                                if (!empty($_REQUEST['procedure'])) {
                                    $conditions[] = "a.circular_no = 'Procedure " . $_REQUEST['procedure'] . "'";
                                }
                            } else if ($_REQUEST['type'] == "Public Notice") {
                                if (!empty($_REQUEST['public_notice'])) {
                                    $conditions[] = "a.circular_no = 'Public Notice " . $_REQUEST['public_notice'] . "'";
                                }
                            } else {
                                if (!empty($_REQUEST['trade_notice'])) {
                                    $conditions[] = "a.circular_no = 'Trade Notice " . $_REQUEST['trade_notice'] . "'";
                                }
                            }

    
                            if (!empty($_REQUEST['sect'])) {
                                $sect = mysqli_real_escape_string($con,$_REQUEST['sect']);
                                $string = trim($sect);
                                $variable = explode(",", $string);
                                foreach ($variable as $v) {
                                    $conditions[] = "(a.file_data LIKE ' %" .'section '. $v . " %')";
                                }
                            }

                            // for category
                            if ($_REQUEST['prod_id'] != 0) {

                                $result = mysqli_query($GLOBALS['con'],"SELECT p.prod_id,p.dbsuffix,sp.sub_prod_id FROM product as p LEFT JOIN sub_product as sp ON p.prod_id=sp.prod_id WHERE p.prod_id= '" . $_REQUEST['prod_id'] . "' AND (sp.sub_prod_type LIKE 'Acts') AND sp.sub_prod_name LIKE '%" . $_REQUEST['type'] . "%'") or die(mysqli_error());
                                $sub_prod = [];
                                if (mysqli_num_rows($result) > 0) {
                                    while ($data = mysqli_fetch_array($result)) {
                                        $sub_prod[] = "a.sub_prod_id = '" . $data['sub_prod_id'] . "'";
                                        $data_db = $data['dbsuffix'];
                                    }
                                }
                                if (!empty($sub_prod)) {
                                    if (!empty($conditions)) {
                                        $where_subprod = " AND (" . implode(' OR ', $sub_prod) . ")";
                                    } else {
                                        $where_subprod = implode(' OR ', $sub_prod);
                                    }
                                } else {
                                    $where_subprod = "";
                                }
                                $orderby = " ORDER BY circular_date DESC";
                                $query = "SELECT a.*,DATE_FORMAT(circular_date,GET_FORMAT(DATE,'EUR'))'Date',p.prod_name,p.dbsuffix,sp.sub_prod_name,sm.state_name FROM casedata_" . $data_db . " as a LEFT JOIN product as p ON a.prod_id=p.prod_id LEFT JOIN sub_product as sp ON a.sub_prod_id=sp.sub_prod_id LEFT JOIN state_master as sm ON a.state_id=sm.state_id ";
                                $sql = $query . "WHERE " . implode(' AND ', $conditions) . $where_subprod . $orderby;
                //                echo $sql;
                                mysqli_query($GLOBALS['con'],"INSERT INTO search_history");
                            } else {
                                $orderby = " ORDER BY circular_date DESC";
                                $id = ['4', '5', '6', '7', '8', '9', '10'];
                                $table = array("casedata_ce", "casedata_cu", "casedata_dgft", "casedata_sgst", "casedata_utgst", "casedata_igst", "casedata_cgst");
                                $sub_prod_name = "AND (sp.sub_prod_type LIKE 'Acts') AND sp.sub_prod_name LIKE '%" . $_REQUEST['type'] . "%'";
                                $sql = implode(" UNION ", (tableUnion($conditions, $table, $id, $sub_prod_name))). " " . $orderby;
                            }
                            return $sql;
                        }
                    }

                // Notification Page Search //
                    if ($_REQUEST['pagename'] == 'Notification') {
                        $row_count = $_SESSION['row_count'];
                        $text = mysqli_real_escape_string($con,$_REQUEST['keyword']);
                        $user_id = $_SESSION["id"];
                        $user_name = $_SESSION["user"];
                        $page_name = "Notification";
                        $search_in = "Advance Search";
                        $search_form_data = array(
                            'user_id' => $user_id,
                            'user_name' => $user_name,
                            'keyword' => $text,
                            'pagename' => $page_name,
                            'search_in' => $search_in,
                            'row_count' => $row_count,
                            'updated_dt' => date('Y-m-d H:i:s')
                        );
                        dbRowInsert('search_history', $search_form_data);
                        function notification() {
                            $conditions = array();
                            $conditions[] = "a.active_flag = 'Y'";
                            // for keyword
                            if ($_REQUEST['keyword'] != "") {
                                $keyword = mysqli_real_escape_string($con,$_REQUEST['keyword']);
                                $string = trim(clean($keyword));
                                $rep_data = shortForm($string); 
                                $_SESSION['key'] = $keyword;

                                if($_REQUEST['exact_search']=='exact'){
                                    $variable = explode(",", $string);
                                    foreach ($variable as $v) {
                                        $conditions[] = "(a.search_subject LIKE '%" . $v . "%' OR a.cir_subject LIKE '%" . $v . "%' OR  
                                a.file_data LIKE '%" . $v . "%' OR  
                                a.party_name LIKE '%" . $v . "%' OR a.search_subject LIKE '%" . $rep_data[0] . "%' OR a.cir_subject LIKE '%" . $rep_data[0] . "%' OR  
                                a.file_data LIKE '%" . $rep_data[0] . "%' OR  
                                a.party_name LIKE '%" . $rep_data[0] . "%')";
                                    }
                                } else {
                                    $variable2 = explode(" ", $string);
                                    foreach ($variable2 as $v2) {
                                        $conditions[] = "(a.search_subject LIKE '%" . $v2 . "%' OR a.cir_subject LIKE '%" . $v2 . "%' OR  
                                a.file_data LIKE '%" . $v2 . "%' OR  
                                a.party_name LIKE '%" . $v2 . "%' OR a.search_subject LIKE '%" . $rep_data[0] . "%' OR a.cir_subject LIKE '%" . $rep_data[0] . "%' OR  
                                a.file_data LIKE '%" . $rep_data[0] . "%' OR  
                                a.party_name LIKE '%" . $rep_data[0] . "%')";
                                    }
                                }
                            }

                            // for notification number
                            if ($_REQUEST['noti_no'] != '') {
                                $not_no = trim(preg_replace('/[^A-Za-z0-9]/', '', $_REQUEST['noti_no']));
                                //$conditions[]="a.circular_no LIKE '%".$not_no."%'";
                                $conditions[] = "a.clean_circular_no LIKE '%" . $not_no . "%'";
                            }

                            // for Date
                            if ($_REQUEST['date'] != "") {
                                $date = mysqli_real_escape_string($con,$_REQUEST['date']);
                                $conditions[] = "a.circular_date LIKE '$date%'";
                            }

                            // for Date Range
                            if ($_REQUEST['dt_from'] != "" || $_REQUEST['dt_to'] != "") {
                                $fromDate = $_REQUEST['dt_from'];
                                $toDate = $_REQUEST['dt_to'];
                                if ($_REQUEST['dt_from'] == "") {
                                    $fromDate = '1942-01-01';
                                }
                                if ($_REQUEST['dt_to'] == "") {
                                    $toDate = date('Y-m-d');
                                }
                                $conditions[] = "(a.circular_date BETWEEN '$fromDate%' AND '$toDate%')";
                            }

                            // for category
                            if ($_REQUEST['prod_id'] != 0) {
                                $result = mysqli_query($GLOBALS['con'],"SELECT prod_id,dbsuffix FROM product WHERE prod_id= '" . $_REQUEST['prod_id'] . "'") or die(mysqli_error());
                                $data = mysqli_fetch_array($result);
                                $data_db = $data['dbsuffix'];

                                // For  State
                                if ($_REQUEST['prod_id'] == '7' && $_REQUEST['state_id'] != '0') {
                                    $conditions[] = "a.state_id = '" . $_REQUEST['state_id'] . "'";
                                }

                                // for sub product id
                                if ($_REQUEST['sub_product_id'] != '0') {
                                    if (isset($_REQUEST['type']) && $_REQUEST['type'] != '0') {
                                        $conditions[] = "a.sub_subprod_id = '" . $_REQUEST['type'] . "'"; //sub product type
                                    }
                                    if (!empty($conditions)) {
                                        $where_subprod = "AND a.sub_prod_id = '" . $_REQUEST['sub_product_id'] . "'"; //sub product id
                                    } else {
                                        $where_subprod = "a.sub_prod_id = '" . $_REQUEST['sub_product_id'] . "'"; //sub product id
                                    }
                                } else {
                                    $result = mysqli_query($GLOBALS['con'],"SELECT p.prod_id,p.dbsuffix,sp.sub_prod_id FROM product as p LEFT JOIN sub_product as sp ON p.prod_id=sp.prod_id WHERE p.prod_id= '" . $_REQUEST['prod_id'] . "' AND (sp.sub_prod_name='Circular' OR sp.sub_prod_name='Notification')") or die(mysqli_error());
                                    $sub_prod = [];
                                    if (mysqli_num_rows($result) > 0) {
                                        while ($data = mysqli_fetch_array($result)) {
                                            $sub_prod[] = "a.sub_prod_id = '" . $data['sub_prod_id'] . "'";
                                            $data_db = $data['dbsuffix'];
                                        }
                                    }
                                    if (!empty($sub_prod)) {
                                        if (!empty($conditions)) {
                                            $where_subprod = " AND (" . implode(' OR ', $sub_prod) . ")";
                                        } else {
                                            $where_subprod = implode(' OR ', $sub_prod);
                                        }
                                    } else {
                                        $where_subprod = "";
                                    }
                                }
                                $orderby = " ORDER BY circular_date DESC";
                                $query = "SELECT a.*,DATE_FORMAT(circular_date,GET_FORMAT(DATE,'EUR'))'Date',p.prod_name,p.dbsuffix,sp.sub_prod_name,sm.state_name FROM casedata_" . $data_db . " as a LEFT JOIN product as p ON a.prod_id=p.prod_id LEFT JOIN sub_product as sp ON a.sub_prod_id=sp.sub_prod_id LEFT JOIN state_master as sm ON a.state_id=sm.state_id ";
                                return $sql = $query . "WHERE " . implode(' AND ', $conditions) . $where_subprod . $orderby;
                            } else {
                                $orderby = " ORDER BY circular_date DESC";
                                $id = ['1', '2', '4', '5', '6', '7', '9', '10'];
                                $table = array("casedata_vat", "casedata_st", "casedata_ce", "casedata_cu", "casedata_dgft", "casedata_sgst", "casedata_igst", "casedata_cgst");
                                $sub_prod_name = "AND (sp.sub_prod_name='Circular' OR sp.sub_prod_name='Notification')";
                                return $sql = implode(" UNION ", (tableUnion($conditions, $table, $id, $sub_prod_name))) . " " . $orderby;
                                ;
                            }
                        }
                    }

                // Case Laws Page Search //
                    if ($_REQUEST['pagename'] == 'CaseLaws') {
                        $row_count = $_SESSION['row_count'];
                        $text = mysqli_real_escape_string($con,$_REQUEST['keyword']);
                        $user_id = $_SESSION["id"];
                        $user_name = $_SESSION["user"];
                        $page_name = "CaseLaws";
                        $search_in = "Advance Search";
                        $party_name = mysqli_real_escape_string($con,$_REQUEST['party_name']);
                        $search_form_data = array(
                            'user_id' => $user_id,
                            'user_name' => $user_name,
                            'keyword' => $text,
                            'party_name' => $party_name,
                            'pagename' => $page_name,
                            'search_in' => $search_in,
                            'row_count' => $row_count,
                            'updated_dt' => date('Y-m-d H:i:s')
                        );
                  
                        dbRowInsert('search_history', $search_form_data);
                        function case_data() {
                            global $con;
                            $keyword = mysqli_real_escape_string($con,$_REQUEST['keyword']);
                            $conditions = array();
                            //$file_data = $_SESSION['file_data'];
                            //$file_content = preg_replace("#[^0-9a-z ]#i", "", $file_data);
                                // for keyword
                                if (!empty($keyword)) {
                                    $string = trim(clean($keyword));
                                    $_SESSION['key'] = $keyword;
                                   // echo $test = $_SESSION['key'];
                                    $rep_data = shortForm($string);
                                    $rep_data2 = shortForm($keyword);
                                    if ($_REQUEST['search_in'] == 1) {
                                        if($_REQUEST['exact_search']=='exact'){
                                            $variable1 = explode(",", $keyword);
                                            foreach ($variable1 as $v1) {
                                                $conditions[] = "(a.cir_subject LIKE '% " . $v1 . " %' OR a.cir_subject LIKE '% " . $rep_data[0] . " %')";
                                            }
                                        } else {
                                            $variable2 = explode(" ", $keyword);
                                            foreach ($variable2 as $v2) {
                                                $conditions[] = "(a.cir_subject LIKE '%" . $v2 . "%' OR a.cir_subject LIKE '%" . $rep_data[0] . "%')";
                                            }
                                        }
                                    } else if ($_REQUEST['search_in'] == 2) {
                                        if($_REQUEST['exact_search']=='exact'){
                                            $variable3 = explode(",", $string);
                                            foreach ($variable3 as $v3) {
                                                $conditions[] = "(a.cir_subject LIKE '% " . $v3 . " %' OR 
                                                    a.file_data LIKE '% " . $v3 . " %' OR a.cir_subject LIKE '% " . $rep_data[0] . " %' OR 
                                                    a.file_data LIKE '% " . $rep_data[0] . " %')";
                                            }
                                        } else {
                                            $variable4 = explode(" ", $string);
                                            foreach ($variable4 as $v4) {
                                                $conditions[] = "(a.cir_subject LIKE '%" . $v4 . "%' OR  
                                                    a.file_data LIKE '%" . $v4 . "%' OR a.cir_subject LIKE '%" . $rep_data[0] . "%' OR  
                                                    a.file_data LIKE '%" . $rep_data[0] . "%')";
                                            }
                                        }
                                    } else {
                                        if($_REQUEST['exact_search']=='exact'){
                                            $variable5 = explode(",", $string);
                                            foreach ($variable5 as $v5) {
                                                $conditions[] = "(a.cir_subject LIKE '% " . $v5 . " %' OR 
                                                    a.file_data LIKE '% " . $v5 . " %' OR a.cir_subject LIKE '% " . $rep_data[0] . " %' OR 
                                                    a.file_data LIKE '% " . $rep_data[0] . " %')";
                                            }
                                        } else {
                                            $variable6 = explode(",", $_REQUEST['keyword']);
                                            foreach ($variable6 as $v6) {
                                                $conditions[] = "(a.cir_subject LIKE '%" . $v6 . "%' OR  
                                                    a.file_data LIKE '%" . $v6 . "%' OR a.cir_subject LIKE '%" . $rep_data2[0] . "%' OR  
                                                    a.file_data LIKE '%" . $rep_data2[0] . "%')";
                                            }
                                        }
                                    }
                                }

                                // for Party name
                                if ($_REQUEST['party_name'] != "") {
                                    $party_name = mysqli_real_escape_string($con,$_REQUEST['party_name']);
                                    $string = trim($party_name);
                                    $rep_data = shortForm($string);

                                    $conditions[] = "(a.party_name LIKE '%" . $string . "%' OR a.party_name LIKE '%" . $rep_data[0] . "%')";
                                }

                                // for Judge name
                                if ($_REQUEST['judge_name'] != "") {
                                    $judge_name = mysqli_real_escape_string($con,$_REQUEST['judge_name']);
                                    $string = trim($judge_name);
                                    $rep_data = shortForm($string);

                                    $conditions[] = "(a.judge_name LIKE '%" . $string . "%' OR a.file_data LIKE '%" . $string . "%' OR a.judge_name LIKE '%" . $rep_data[0] . "%' OR a.file_data LIKE '%" . $rep_data[0] . "%')";
                                }

                                // for Order No
                                if ($_REQUEST['order_no'] != "") {
                                    $order_no = mysqli_real_escape_string($con,$_REQUEST['order_no']);
                                    $string = trim($order_no);
                                    $rep_data = shortForm($string);

                                    $conditions[] = "(a.order_no LIKE '%" . $string . "%' OR a.order_no LIKE '%" . $rep_data[0] . "%')";
                                }

                                // for Case No
                                if ($_REQUEST['case_no'] != "") {
                                    $case_no = mysqli_real_escape_string($con,$_REQUEST['case_no']);
                                    $string = trim($case_no);
                                    $rep_data = shortForm($string);

                                    $conditions[] = "(a.case_no LIKE '%" . $string . "%' OR a.case_no LIKE '%" . $rep_data[0] . "%')";
                                }

                                // for Date
                                if ($_REQUEST['date'] != "") {
                                    $date = mysqli_real_escape_string($con,$_REQUEST['date']);
                                    $conditions[] = "a.circular_date LIKE '$date%'";
                                }

                                //for Date Range
                                if ($_REQUEST['dt_from'] != "" || $_REQUEST['dt_to'] != "") {
                                    $fromDate = $_REQUEST['dt_from'];
                                    $toDate = $_REQUEST['dt_to'];
                                    if ($_REQUEST['dt_from'] == "") {
                                        $fromDate = '1942-01-01';
                                    }
                                    if ($_REQUEST['dt_to'] == "") {
                                        $toDate = date('Y-m-d');
                                    }
                                    $conditions[] = "(a.circular_date BETWEEN '$fromDate%' AND '$toDate%')";
                                }

                                //<--------Condition For Citation number--------->
                                $year = mysqli_real_escape_string($con,$_REQUEST['year']);
                                $volume = trim(mysqli_real_escape_string($con,$_REQUEST['vol']));
                                $c_value = trim(mysqli_real_escape_string($con,$_REQUEST['Citation']));

                                if (!empty($year) && !empty($volume) && !empty($c_value)) {
                                    $c_no = $year . "-VIL-" . $volume . "-" . $c_value;
                                    $conditions[] = "a.circular_no LIKE '%$c_no%'";
                                } elseif (!empty($year) && !empty($volume)) {
                                    $c_no = $year . "-VIL-" . $volume;
                                    $conditions[] = "a.circular_no LIKE '%$c_no%'";
                                } elseif (!empty($volume) && !empty($c_value)) {
                                    $c_no = "-VIL-" . $volume . "-" . $c_value;
                                    $conditions[] = "a.circular_no = '%$c_no%'";
                                } elseif (!empty($year)) {
                                    $c_no = $year . "-VIL-";
                                    $conditions[] = "a.circular_no = '%$c_no%'";
                                } elseif (!empty($volume)) {
                                    $c_no = "-VIL-" . $volume;
                                    $conditions[] = "a.circular_no = '%$c_no%'";
                                } elseif (!empty($c_value)) {
                                    $c_no = $c_value;
                                    $conditions[] = "a.circular_no LIKE '%$c_no%'";
                                }
                                //<--------End of  Citation number--------->

                                // for cgst section 
                                if ($_REQUEST['cgst_section'] != "" || $_REQUEST['cgst_section1'] != "" || $_REQUEST['cgst_section2'] != "") {

                                    if ($_REQUEST['cgst_section'] != "") {
                                        $sec_no = trim(mysqli_real_escape_string($con,$_REQUEST['cgst_section']));
                                    } else {
                                        $sec_no = "";
                                    }

                                    if ($_REQUEST['cgst_section1'] != "") {
                                        $sec_no1 = "(" . trim(mysqli_real_escape_string($con,$_REQUEST['cgst_section1'])) . ")";
                                    } else {
                                        $sec_no1 = "";
                                    }
                                    if ($_REQUEST['cgst_section2'] != "") {
                                        $sec_alf = "(" . trim(mysqli_real_escape_string($con,$_REQUEST['cgst_section2'])) . ")";
                                    } else {
                                        $sec_alf = "";
                                    }

                                    $cgst_section = $sec_no . $sec_no1 . $sec_alf;
                                    if ($_REQUEST['prod_id'] == "0" || $_REQUEST['prod_id'] == "7") {
                                        if ($_REQUEST['prod_id'] == "0") {
                                            $conditions[] = "a.prod_id='7'";
                                        }
                                        
                                        if ($_REQUEST['exact_search'] == 'exact') {
                                            $conditions[] = "(a.section_no = '$cgst_section' OR a.section_no LIKE '%, $cgst_section,%' OR a.section_no LIKE '%, $cgst_section' OR a.section_no LIKE '%,$cgst_section,%' OR a.section_no LIKE '%,$cgst_section' OR a.section_no LIKE '$cgst_section,%')";
                                        } else {
                                            $conditions[] = "(a.section_no LIKE '%$cgst_section%')";
                                        }
                                    }
                                }

                                // for cgst rules
                                if ($_REQUEST['cgst_rule'] != "" || $_REQUEST['cgst_rule1'] != "" || $_REQUEST['cgst_rule2'] != "") {

                                    if ($_REQUEST['cgst_rule'] != "") {
                                        $rule_no = trim(mysqli_real_escape_string($con,$_REQUEST['cgst_rule']));
                                    } else {
                                        $rule_no = "";
                                    }

                                    if ($_REQUEST['cgst_rule1'] != "") {
                                        $rule_no1 = "(" . trim(mysqli_real_escape_string($con,$_REQUEST['cgst_rule1'])) . ")";
                                    } else {
                                        $rule_no1 = "";
                                    }
                                    if ($_REQUEST['cgst_rule2'] != "") {
                                        $rule_alf = "(" . trim(mysqli_real_escape_string($con,$_REQUEST['cgst_rule2'])) . ")";
                                    } else {
                                        $rule_alf = "";
                                    }
                                    $cgst_rule = $rule_no . $rule_no1 . $rule_alf;
                                    if ($_REQUEST['prod_id'] == "0" || $_REQUEST['prod_id'] == "7") {
                                        if ($_REQUEST['prod_id'] == "0") {
                                            $conditions[] = "a.prod_id='7'";
                                        }
                                        
                                        if ($_REQUEST['exact_search'] == 'exact') {
                                            $conditions[] = "(a.rule_no = '$cgst_rule' OR a.rule_no LIKE '%, $cgst_rule,%' OR a.rule_no LIKE '%, $cgst_rule' OR a.rule_no LIKE '%,$cgst_rule,%' OR a.rule_no LIKE '%,$cgst_rule' OR a.rule_no LIKE '$cgst_rule,%')";
                                        } else {
                                            $conditions[] = "(a.rule_no LIKE '%$cgst_rule%')";
                                        }
                                    }
                                }

                                // for igst section 
                                if ($_REQUEST['igst_section'] != "" || $_REQUEST['igst_section1'] != "" || $_REQUEST['igst_section2'] != "") {

                                    if ($_REQUEST['igst_section'] != "") {
                                        $sec_no = trim(mysqli_real_escape_string($con,$_REQUEST['igst_section']));
                                    } else {
                                        $sec_no = "";
                                    }

                                    if ($_REQUEST['igst_section1'] != "") {
                                        $sec_no1 = "(" . trim(mysqli_real_escape_string($con,$_REQUEST['igst_section1'])) . ")";
                                    } else {
                                        $sec_no1 = "";
                                    }
                                    if ($_REQUEST['igst_section2'] != "") {
                                        $sec_alf = "(" . trim(mysqli_real_escape_string($con,$_REQUEST['igst_section2'])) . ")";
                                    } else {
                                        $sec_alf = "";
                                    }

                                    $igst_section = $sec_no . $sec_no1 . $sec_alf;
                                    if ($_REQUEST['prod_id'] == "0" || $_REQUEST['prod_id'] == "7") {
                                        if ($_REQUEST['prod_id'] == "0") {
                                            $conditions[] = "a.prod_id='7'";
                                        }
                                        
                                        if ($_REQUEST['exact_search'] == 'exact') {
                                            $conditions[] = "(a.igst_section_no = '$igst_section' OR a.igst_section_no LIKE '%, $igst_section,%' OR a.igst_section_no LIKE '%, $igst_section' OR a.igst_section_no LIKE '%,$igst_section,%' OR a.igst_section_no LIKE '%,$igst_section' OR a.igst_section_no LIKE '$igst_section,%')";
                                        } else {
                                            $conditions[] = "(a.igst_section_no LIKE '%$igst_section%')";
                                        }
                                    }
                                }

                                // for igst rules
                                if ($_REQUEST['igst_rule'] != "" || $_REQUEST['igst_rule1'] != "" || $_REQUEST['igst_rule2'] != "") {

                                    if ($_REQUEST['igst_rule'] != "") {
                                        $rule_no = trim(mysqli_real_escape_string($con,$_REQUEST['igst_rule']));
                                    } else {
                                        $rule_no = "";
                                    }

                                    if ($_REQUEST['igst_rule1'] != "") {
                                        $rule_no1 = "(" . trim(mysqli_real_escape_string($con,$_REQUEST['igst_rule1'])) . ")";
                                    } else {
                                        $rule_no1 = "";
                                    }
                                    if ($_REQUEST['igst_rule2'] != "") {
                                        $rule_alf = "(" . trim(mysqli_real_escape_string($con,$_REQUEST['igst_rule2'])) . ")";
                                    } else {
                                        $rule_alf = "";
                                    }

                                    $igst_rule = $rule_no . $rule_no1 . $rule_alf;
                                    if ($_REQUEST['prod_id'] == "0" || $_REQUEST['prod_id'] == "7") {
                                        if ($_REQUEST['prod_id'] == "0") {
                                            $conditions[] = "a.prod_id='7'";
                                        }
                                        
                                        if ($_REQUEST['exact_search'] == 'exact') {
                                            $conditions[] = "(a.igst_rule_no = '$igst_rule' OR a.igst_rule_no LIKE '%, $igst_rule,%' OR a.igst_rule_no LIKE '%, $igst_rule' OR a.igst_rule_no LIKE '%,$igst_rule,%' OR a.igst_rule_no LIKE '%,$igst_rule' OR a.igst_rule_no LIKE '$igst_rule,%')";
                                        } else {
                                            $conditions[] = "(a.igst_rule_no LIKE '%$igst_rule%')";
                                        }
                                    }
                                }

                                // for court
                                if ($_REQUEST['court'] != '0') {
                                    if ($_REQUEST['court'] == "HC") {
                                        $courtType = " AND (sp.sub_prod_name LIKE 'High Court Cases')";
                                        if ($_REQUEST['courtCity'] != '0') {
                                            $conditions[] = "a.circular_no LIKE '%" . $_REQUEST['courtCity'] . "%'";
                                        }
                                    } else if ($_REQUEST['court'] == "SC") {
                                        $courtType = " AND (sp.sub_prod_name LIKE 'Supreme Court Cases')";
                                    } else if ($_REQUEST['court'] == "TRI") {
                                        // $courtType= " AND (sp.sub_prod_name LIKE 'Tribunal')";
                                        $courtType = " AND (sp.sub_prod_name LIKE 'CESTAT Cases')";
                                        if ($_REQUEST['courtCity1'] != '0') {
                                            $conditions[] = "a.circular_no LIKE '%" . $_REQUEST['courtCity1'] . "%'";
                                        }
                                    } else if ($_REQUEST['court'] == "AAR") {
                                        $courtType = " AND (sp.sub_prod_name LIKE 'Advance Ruling Authority')";
                                        if ($_REQUEST['courtCityAAR'] != '0') {
                                            $conditions[] = "a.state_id = " . $_REQUEST['courtCityAAR'] . "";
                                        }
                                    } else if ($_REQUEST['court'] == "AAAR") {
                                        $courtType = " AND (sp.sub_prod_name LIKE 'AAAR')";
                                        if ($_REQUEST['courtCityAAAR'] != '0') {
                                            $conditions[] = "a.state_id LIKE = " . $_REQUEST['courtCityAAAR'] . "";
                                        }
                                    } else if ($_REQUEST['court'] == "NAA") {
                                        $courtType = " AND (sp.sub_prod_name LIKE 'National Anti-Profiteering Authority')";
                                    }
                                } else {
                                    $courtType = "";
                                }
                                //echo "<pre>";
                                //print_r($conditions);die;

                                // for category
                                if ($_REQUEST['prod_id'] != 0) {
                                    $result = mysqli_query($GLOBALS['con'],"SELECT p.prod_id,p.dbsuffix,sp.sub_prod_id FROM product as p LEFT JOIN sub_product as sp ON p.prod_id=sp.prod_id WHERE p.prod_id= '" . $_REQUEST['prod_id'] . "' AND (sp.sub_prod_type LIKE 'Judgements')" . $courtType) or die(mysqli_error());
                                    $sub_prod = [];

                                    if (mysqli_num_rows($result) > 0) {
                                        while ($data = mysqli_fetch_array($result)) {
                                            $sub_prod[] = "a.sub_prod_id = '" . $data['sub_prod_id'] . "'";
                                            $data_db = $data['dbsuffix'];
                                        }
                                    }else{
                                    }
                                    if (!empty($sub_prod)) {
                                        if (!empty($conditions)) {
                                            $where_subprod = " AND (" . implode(' OR ', $sub_prod) . ")";
                                        } else {
                                            $where_subprod = implode(' OR ', $sub_prod);
                                        }
                                    } else {
                                        $where_subprod = "";
                                    }
                                    $orderby = " ORDER BY circular_date DESC";
                                    $query = "SELECT a.*,DATE_FORMAT(circular_date,GET_FORMAT(DATE,'EUR'))'Date',p.prod_name,p.dbsuffix,sp.sub_prod_name,sm.state_name FROM casedata_" . $data_db . " as a LEFT JOIN product as p ON a.prod_id=p.prod_id LEFT JOIN sub_product as sp ON a.sub_prod_id=sp.sub_prod_id LEFT JOIN state_master as sm ON a.state_id=sm.state_id ";
                                     $sql = $query . "WHERE " . implode(' AND ', $conditions) . $where_subprod . " " . $orderby;
                                
                                } else {
                                    $orderby = " ORDER BY circular_date DESC";
                                    $id = ['1', '2', '4', '5', '7'];
                                    $table = array("casedata_vat", "casedata_st", "casedata_ce", "casedata_cu", "casedata_sgst");
                                    $sub_prod_name = "AND (sp.sub_prod_type LIKE 'Judgements')" . $courtType;
                                    $sql = implode(" UNION ", (tableUnion($conditions, $table, $id, $sub_prod_name))) . " " . $orderby;
                            }
                            //echo "<br>".$sql;die;
                            return $sql;
                        }
                    }

                // Articles Page Search //
                    if ($_REQUEST['pagename'] == 'Articles') {
                        $prod_id = mysqli_real_escape_string($con,$_REQUEST['prod_id']);
                        $text = mysqli_real_escape_string($con,$_REQUEST['keyword']);
                        $topic = mysqli_real_escape_string($con,$_REQUEST['topic']);
                        $fromDate = mysqli_real_escape_string($con,$_REQUEST['fromDate']);
                        $toDate = mysqli_real_escape_string($con,$_REQUEST['toDate']);
                        $dbsuffix = mysqli_real_escape_string($con,$_REQUEST['dbsuffix']);
                        $author = mysqli_real_escape_string($con,$_REQUEST['author']);

                        $row_count = $_SESSION['row_count'];
                        $user_id = $_SESSION["id"];
                        $user_name = $_SESSION["user"];
                        $page_name = "Articles";
                        $search_in = "Advance Search";
                        $search_form_data = array(
                            'user_id' => $user_id,
                            'user_name' => $user_name,
                            'keyword' => $text,
                            'topic' => $topic,
                            'pagename' => $page_name,
                            'search_in' => $search_in,
                            'row_count' => $row_count,
                            'updated_dt' => date('Y-m-d H:i:s')
                        );
                        dbRowInsert('search_history', $search_form_data);
                        function articles() {
                            global $con;
                            $prod_id = mysqli_real_escape_string($con,$_REQUEST['prod_id']);
                            $text = mysqli_real_escape_string($con,$_REQUEST['keyword']);
                            $topic = mysqli_real_escape_string($con,$_REQUEST['topic']);
                            $fromDate = mysqli_real_escape_string($con,$_REQUEST['fromDate']);
                            $toDate = mysqli_real_escape_string($con,$_REQUEST['toDate']);
                            $dbsuffix = mysqli_real_escape_string($con,$_REQUEST['dbsuffix']);
                            $author = mysqli_real_escape_string($con,$_REQUEST['author']);
                            $_SESSION['key'] = $text;

                            $query = "SELECT *,article_id 'id',DATE_FORMAT( article_date, GET_FORMAT( DATE, 'EUR' ) )  'Date' FROM $dbsuffix";
                            $conditions = array();
                            if ($author != '0') {
                                $conditions[] = "author='$author'";
                            }
                            if ($prod_id != '0') {
                                $conditions[] = "category='$prod_id'";
                            }
                            if (!empty($text)) {
                                $rep_data = shortForm($text, '', '');
                                if($_REQUEST['exact_search']=='exact'){
                                    $variable = explode(",", $text);
                                    foreach ($variable as $v) {
                                        $conditions[] = "(file_data LIKE '%" . $v . "%')";
                                    }
                                } else {
                                    $variable2 = explode(" ", $text);
                                    foreach ($variable2 as $v2) {
                                        $conditions[] = "(file_data LIKE '%" . $v . "%')";
                                    }
                                }
                            }
                            if (!empty($topic)) {
                                $rep_data = shortForm($topic, '', '');
                                $conditions[] = "(summary LIKE '%" . $topic . "%' OR summary LIKE '%" . $rep_data[0] . "%')";
                            }
                            if (!empty($fromDate) || !empty($toDate)) {
                                if (empty($fromDate)) {
                                    $fromDate = '2015-01-01';
                                }
                                if (empty($toDate)) {
                                    $toDate = date('Y-m-d');
                                }
                                $conditions[] = "(article_date BETWEEN '$fromDate%' AND '$toDate%')";
                            }
                            $sql = $query;
                            $query2 = " ORDER BY article_id DESC";
                            if (count($conditions) > 0) {
                                return $sql .= " WHERE " . implode(' AND ', $conditions) . $query2;
                            } else {
                                return $sql.=$query2;
                            }
                        }
                    }

                    // Tax Vista Page Search //
                    if ($_REQUEST['pagename'] == 'tax vista') {
                        $text = mysqli_real_escape_string($con,$_REQUEST['keyword']);
                        $fromDate = mysqli_real_escape_string($con,$_REQUEST['fromDate']);
                        $toDate = mysqli_real_escape_string($con,$_REQUEST['toDate']);
                        $dbsuffix = mysqli_real_escape_string($con,$_REQUEST['dbsuffix']);

                        $row_count = $_SESSION['row_count'];
                        $user_id = $_SESSION["id"];
                        $user_name = $_SESSION["user"];
                        $page_name = "tax vista";
                        $search_in = "Advance Search";
                        $search_form_data = array(
                            'user_id' => $user_id,
                            'user_name' => $user_name,
                            'keyword' => $text,
                            'pagename' => $page_name,
                            'search_in' => $search_in,
                            'row_count' => $row_count,
                            'updated_dt' => date('Y-m-d H:i:s')
                        );
                        dbRowInsert('search_history', $search_form_data);
                        function tax_vista() {
                            global $con;
                            $text = mysqli_real_escape_string($con,$_REQUEST['keyword']);
                            $fromDate = mysqli_real_escape_string($con,$_REQUEST['fromDate']);
                            $toDate = mysqli_real_escape_string($con,$_REQUEST['toDate']);
                            $dbsuffix = mysqli_real_escape_string($con,$_REQUEST['dbsuffix']);
                            $_SESSION['key'] = $text;

                            $query = "SELECT *,article_id 'id',DATE_FORMAT( article_date, GET_FORMAT( DATE, 'EUR' ) )  'Date' FROM $dbsuffix";
                            $conditions = array();
                            if (!empty($text)) {
                                $rep_data = shortForm($text, '', '');
                                if($_REQUEST['exact_search']=='exact'){
                                    $variable = explode(",", $text);
                                    foreach ($variable as $v) {
                                        $conditions[] = "(file_data LIKE '%" . $v . "%')";
                                    }
                                } else {
                                    $variable2 = explode(" ", $text);
                                    foreach ($variable2 as $v2) {
                                        $conditions[] = "(file_data LIKE '%" . $v . "%')";
                                    }
                                }
                            }
                            if (!empty($topic)) {
                                $rep_data = shortForm($topic, '', '');
                                $conditions[] = "(summary LIKE '%" . $topic . "%' OR summary LIKE '%" . $rep_data[0] . "%')";
                            }
                            if (!empty($fromDate) || !empty($toDate)) {
                                if (empty($fromDate)) {
                                    $fromDate = '2015-01-01';
                                }
                                if (empty($toDate)) {
                                    $toDate = date('Y-m-d');
                                }
                                $conditions[] = "(article_date BETWEEN '$fromDate%' AND '$toDate%')";
                            }
                            $sql = $query;
                            $query2 = " ORDER BY article_id DESC";
                            if (count($conditions) > 0) {
                                return $sql .= " WHERE " . implode(' AND ', $conditions) . $query2;
                            } else {
                                return $sql.=$query2;
                            }
                        }
                    }

                    $query = $_REQUEST['function_name']($_REQUEST);
                    //print_r($query); die();
                }

                if (isset($_REQUEST['searchButton2'])) {
                    $search_id = $_SESSION['search_id'];
                    $seoTitle = $_REQUEST['pagename'] . '- Advanced Search';
                    $seoKeywords = $_REQUEST['pagename'] . '- Advanced Search';
                    $seoDesc = $_REQUEST['pagename'] . '- Advanced Search';

                    // Acts and Rules Page Search //
                    if ($_REQUEST['pagename'] == 'Acts and Rules') {
                        $row_count = $_SESSION['row_count'];
                        $text = mysqli_real_escape_string($con,$_REQUEST['keyword']);
                        $user_id = $_SESSION["id"];
                        $user_name = $_SESSION["user"];
                        $page_name = "Acts & Rules";
                        $search_in = "Advance Search";
                        $search_form_data = array(
                            'user_id' => $user_id,
                            'user_name' => $user_name,
                            'keyword' => $text,
                            'pagename' => $page_name,
                            'search_in' => $search_in,
                            'row_count' => $row_count,
                            'updated_dt' => date('Y-m-d H:i:s')
                        );
                        dbRowInsert('search_history', $search_form_data);
                        function act() {
                            global $con;
                            $search_id = $_SESSION['search_id'];
                            $conditions = array();
                            // for keyword
                            if ($_REQUEST['keyword'] != "") {
                                $keyword = mysqli_real_escape_string($con,$_REQUEST['keyword']);
                                $string = trim(clean($keyword));
                                $rep_data = shortForm($string);

                                if($_REQUEST['exact_search']=='exact'){
                                    $variable = explode(",", $string);
                                    foreach ($variable as $v) {
                                        $conditions[] = "(a.cir_subject LIKE '%" . $v . "%' OR  
                                a.file_data LIKE '%" . $v . "%' OR  
                                a.party_name LIKE '%" . $v . "%' OR a.cir_subject LIKE '%" . $rep_data[0] . "%' OR  
                                a.file_data LIKE '%" . $rep_data[0] . "%' OR  
                                a.party_name LIKE '%" . $rep_data[0] . "%')";
                                    }
                                } else {
                                    $variable2 = explode(" ", $string);
                                    foreach ($variable2 as $v2) {
                                        $conditions[] = "(a.cir_subject LIKE '%" . $v2 . "%' OR  
                                a.file_data LIKE '%" . $v2 . "%' OR  
                                a.party_name LIKE '%" . $v2 . "%' OR a.cir_subject LIKE '%" . $rep_data[0] . "%' OR  
                                a.file_data LIKE '%" . $rep_data[0] . "%' OR  
                                a.party_name LIKE '%" . $rep_data[0] . "%')";
                                    }
                                }
                            }

                            // for section, rule, notification, etc.. number
                            if ($_REQUEST['type'] == "Acts") {
                                if (!empty($_REQUEST['section_no'])) {
                                    $conditions[] = "a.circular_no = 'Section " . $_REQUEST['section_no'] . "'";
                                }
                            } else if ($_REQUEST['type'] == "Rules") {
                                if (!empty($_REQUEST['rule_no'])) {
                                    $conditions[] = "a.circular_no = 'Rule " . $_REQUEST['rule_no'] . "'";
                                }
                            } else if ($_REQUEST['type'] == "Notification") {
                                if (!empty($_REQUEST['notification'])) {
                                    $conditions[] = "a.circular_no = 'Notification " . $_REQUEST['notification'] . "'";
                                }
                            } else if ($_REQUEST['type'] == "Policy") {
                                if (!empty($_REQUEST['policy'])) {
                                    $conditions[] = "a.circular_no = 'Policy " . $_REQUEST['policy'] . "'";
                                }
                            } else if ($_REQUEST['type'] == "Policy Circular") {
                                if (!empty($_REQUEST['policy_circular'])) {
                                    $conditions[] = "a.circular_no = 'Policy Circular " . $_REQUEST['policy_circular'] . "'";
                                }
                            } else if ($_REQUEST['type'] == "Procedure") {
                                if (!empty($_REQUEST['procedure'])) {
                                    $conditions[] = "a.circular_no = 'Procedure " . $_REQUEST['procedure'] . "'";
                                }
                            } else if ($_REQUEST['type'] == "Public Notice") {
                                if (!empty($_REQUEST['public_notice'])) {
                                    $conditions[] = "a.circular_no = 'Public Notice " . $_REQUEST['public_notice'] . "'";
                                }
                            } else {
                                if (!empty($_REQUEST['trade_notice'])) {
                                    $conditions[] = "a.circular_no = 'Trade Notice " . $_REQUEST['trade_notice'] . "'";
                                }
                            }

                            // for category
                            if ($_REQUEST['prod_id'] != 0) {

                                $result = mysqli_query($GLOBALS['con'],"SELECT p.prod_id,p.dbsuffix,sp.sub_prod_id FROM product as p LEFT JOIN sub_product as sp ON p.prod_id=sp.prod_id WHERE p.prod_id= '" . $_REQUEST['prod_id'] . "' AND (sp.sub_prod_type LIKE 'Acts') AND sp.sub_prod_name LIKE '%" . $_REQUEST['type'] . "%'") or die(mysqli_error());
                                $sub_prod = [];
                                if (mysqli_num_rows($result) > 0) {
                                    while ($data = mysqli_fetch_array($result)) {
                                        $sub_prod[] = "a.sub_prod_id = '" . $data['sub_prod_id'] . "'";
                                        $data_db = $data['dbsuffix'];
                                    }
                                }
                                if (!empty($sub_prod)) {
                                    if (!empty($conditions)) {
                                        $where_subprod = " AND (" . implode(' OR ', $sub_prod) . ")";
                                    } else {
                                        $where_subprod = implode(' OR ', $sub_prod);
                                    }
                                } else {
                                    $where_subprod = "";
                                }
                                $orderby = " ORDER BY circular_date DESC";
                                $query = "SELECT a.*,DATE_FORMAT(circular_date,GET_FORMAT(DATE,'EUR'))'Date',p.prod_name,p.dbsuffix,sp.sub_prod_name,sm.state_name FROM casedata_" . $data_db . " as a LEFT JOIN product as p ON a.prod_id=p.prod_id LEFT JOIN sub_product as sp ON a.sub_prod_id=sp.sub_prod_id LEFT JOIN state_master as sm ON a.state_id=sm.state_id ";
                                $sql = $query . "WHERE data_id IN $search_id AND " . implode(' AND ', $conditions) . $where_subprod . $orderby;
                //                echo $sql;
                            } else {
                                $orderby = " ORDER BY circular_date DESC";
                                $id = ['4', '5', '6', '7', '8', '9', '10'];
                                $table = array("casedata_ce", "casedata_cu", "casedata_dgft", "casedata_sgst", "casedata_utgst", "casedata_igst", "casedata_cgst");
                                $sub_prod_name = "AND (sp.sub_prod_type LIKE 'Acts') AND sp.sub_prod_name LIKE '%" . $_REQUEST['type'] . "%'";
                                $sql = implode(" UNION ", (tableUnion2($conditions, $table, $id, $sub_prod_name, $search_id))). " " . $orderby;
                            }
                            return $sql;
                        }
                    }

                    // Notification Page Search //
                    if ($_REQUEST['pagename'] == 'Notification') {
                        $row_count = $_SESSION['row_count'];
                        $text = mysqli_real_escape_string($con,$_REQUEST['keyword']);
                        $user_id = $_SESSION["id"];
                        $user_name = $_SESSION["user"];
                        $page_name = "Notification";
                        $search_in = "Advance Search";
                        $search_form_data = array(
                            'user_id' => $user_id,
                            'user_name' => $user_name,
                            'keyword' => $text,
                            'pagename' => $page_name,
                            'search_in' => $search_in,
                            'row_count' => $row_count,
                            'updated_dt' => date('Y-m-d H:i:s')
                        );
                        dbRowInsert('search_history', $search_form_data);
                        function notification() {
                            global $con;
                            $search_id = $_SESSION['search_id'];
                            $conditions = array();
                            // for keyword
                            if ($_REQUEST['keyword'] != "") {
                                $keyword = mysqli_real_escape_string($con,$_REQUEST['keyword']);
                                $string = trim(clean($keyword));
                                $rep_data = shortForm($string);

                                if($_REQUEST['exact_search']=='exact'){
                                    $variable = explode(",", $string);
                                    foreach ($variable as $v) {
                                        $conditions[] = "(a.search_subject LIKE '%" . $v . "%' OR a.cir_subject LIKE '%" . $v . "%' OR  
                                a.file_data LIKE '%" . $v . "%' OR  
                                a.party_name LIKE '%" . $v . "%' OR a.search_subject LIKE '%" . $rep_data[0] . "%' OR a.cir_subject LIKE '%" . $rep_data[0] . "%' OR  
                                a.file_data LIKE '%" . $rep_data[0] . "%' OR  
                                a.party_name LIKE '%" . $rep_data[0] . "%')";
                                    }
                                } else {
                                    $variable2 = explode(" ", $string);
                                    foreach ($variable2 as $v2) {
                                        $conditions[] = "(a.search_subject LIKE '%" . $v2 . "%' OR a.cir_subject LIKE '%" . $v2 . "%' OR  
                                a.file_data LIKE '%" . $v2 . "%' OR  
                                a.party_name LIKE '%" . $v2 . "%' OR a.search_subject LIKE '%" . $rep_data[0] . "%' OR a.cir_subject LIKE '%" . $rep_data[0] . "%' OR  
                                a.file_data LIKE '%" . $rep_data[0] . "%' OR  
                                a.party_name LIKE '%" . $rep_data[0] . "%')";
                                    }
                                }
                            }

                            // for notification number
                            if ($_REQUEST['noti_no'] != '') {
                                $not_no = trim(preg_replace('/[^A-Za-z0-9]/', '', $_REQUEST['noti_no']));
                                //$conditions[]="a.circular_no LIKE '%".$not_no."%'";
                                $conditions[] = "a.clean_circular_no LIKE '%" . $not_no . "%'";
                            }

                            // for Date
                            if ($_REQUEST['date'] != "") {
                                $date = mysqli_real_escape_string($con,$_REQUEST['date']);
                                $conditions[] = "a.circular_date LIKE '$date%'";
                            }

                            // for Date Range
                            if ($_REQUEST['dt_from'] != "" || $_REQUEST['dt_to'] != "") {
                                $fromDate = $_REQUEST['dt_from'];
                                $toDate = $_REQUEST['dt_to'];
                                if ($_REQUEST['dt_from'] == "") {
                                    $fromDate = '1942-01-01';
                                }
                                if ($_REQUEST['dt_to'] == "") {
                                    $toDate = date('Y-m-d');
                                }
                                $conditions[] = "(a.circular_date BETWEEN '$fromDate%' AND '$toDate%')";
                            }

                            // for category
                            if ($_REQUEST['prod_id'] != 0) {
                                $result = mysqli_query($GLOBALS['con'],"SELECT prod_id,dbsuffix FROM product WHERE prod_id= '" . $_REQUEST['prod_id'] . "'") or die(mysqli_error());
                                $data = mysqli_fetch_array($result);
                                $data_db = $data['dbsuffix'];

                                // For  State
                                if ($_REQUEST['prod_id'] == '7' && $_REQUEST['state_id'] != '0') {
                                    $conditions[] = "a.state_id = '" . $_REQUEST['state_id'] . "'";
                                }

                                // for sub product id
                                if ($_REQUEST['sub_product_id'] != '0') {
                                    if (isset($_REQUEST['type']) && $_REQUEST['type'] != '0') {
                                        $conditions[] = "a.sub_subprod_id = '" . $_REQUEST['type'] . "'"; //sub product type
                                    }
                                    if (!empty($conditions)) {
                                        $where_subprod = "AND a.sub_prod_id = '" . $_REQUEST['sub_product_id'] . "'"; //sub product id
                                    } else {
                                        $where_subprod = "a.sub_prod_id = '" . $_REQUEST['sub_product_id'] . "'"; //sub product id
                                    }
                                } else {
                                    $result = mysqli_query($GLOBALS['con'],"SELECT p.prod_id,p.dbsuffix,sp.sub_prod_id FROM product as p LEFT JOIN sub_product as sp ON p.prod_id=sp.prod_id WHERE p.prod_id= '" . $_REQUEST['prod_id'] . "' AND (sp.sub_prod_name='Circular' OR sp.sub_prod_name='Notification')") or die(mysqli_error());
                                    $sub_prod = [];
                                    if (mysqli_num_rows($result) > 0) {
                                        while ($data = mysqli_fetch_array($result)) {
                                            $sub_prod[] = "a.sub_prod_id = '" . $data['sub_prod_id'] . "'";
                                            $data_db = $data['dbsuffix'];
                                        }
                                    }
                                    if (!empty($sub_prod)) {
                                        if (!empty($conditions)) {
                                            $where_subprod = " AND (" . implode(' OR ', $sub_prod) . ")";
                                        } else {
                                            $where_subprod = implode(' OR ', $sub_prod);
                                        }
                                    } else {
                                        $where_subprod = "";
                                    }
                                }
                                $orderby = " ORDER BY circular_date DESC";
                                $query = "SELECT a.*,DATE_FORMAT(circular_date,GET_FORMAT(DATE,'EUR'))'Date',p.prod_name,p.dbsuffix,sp.sub_prod_name,sm.state_name FROM casedata_" . $data_db . " as a LEFT JOIN product as p ON a.prod_id=p.prod_id LEFT JOIN sub_product as sp ON a.sub_prod_id=sp.sub_prod_id LEFT JOIN state_master as sm ON a.state_id=sm.state_id ";
                                return $sql = $query . " WHERE data_id IN $search_id AND " . implode(' AND ', $conditions) . $where_subprod . $orderby;
                                // echo $sql; die();
                            } else {
                                $orderby = " ORDER BY circular_date DESC";
                                $id = ['1', '2', '4', '5', '6', '7', '9', '10'];
                                $table = array("casedata_vat", "casedata_st", "casedata_ce", "casedata_cu", "casedata_dgft", "casedata_sgst", "casedata_igst", "casedata_cgst");
                                $sub_prod_name = "AND (sp.sub_prod_name='Circular' OR sp.sub_prod_name='Notification')";
                                return $sql = implode(" UNION ", (tableUnion2($conditions, $table, $id, $sub_prod_name, $search_id))) . " " . $orderby;
                                ;
                            }
                        }
                    }

                    // Case Laws Page Search //
                    if ($_REQUEST['pagename'] == 'CaseLaws') {
                        $row_count = $_SESSION['row_count'];
                        $text = mysqli_real_escape_string($con,$_REQUEST['keyword']);
                        $user_id = $_SESSION["id"];
                        $user_name = $_SESSION["user"];
                        $page_name = "CaseLaws";
                        $search_in = "Advance Search";
                        $party_name = mysqli_real_escape_string($con,$_REQUEST['party_name']);
                        $search_form_data = array(
                            'user_id' => $user_id,
                            'user_name' => $user_name,
                            'keyword' => $text,
                            'party_name' => $party_name,
                            'pagename' => $page_name,
                            'search_in' => $search_in,
                            'row_count' => $row_count,
                            'updated_dt' => date('Y-m-d H:i:s')
                        );
                        dbRowInsert('search_history', $search_form_data);
                        function case_data() {
                            global $con;
                            $search_id=$_SESSION['search_id'];
                            $keyword = mysqli_real_escape_string($con,$_REQUEST['keyword']);
                            $conditions = array();

                            // 1 Combination Start
                            if ($_REQUEST['sc'] == "Supreme Court Cases") {
                                $courtType2 = " AND (sp.sub_prod_name LIKE 'Supreme Court Cases')";
                            }
                            elseif ($_REQUEST['hc'] == "High Court Cases") {
                                $courtType2 = " AND (sp.sub_prod_name LIKE 'High Court Cases')";
                            }
                            elseif ($_REQUEST['cc'] == "CESTAT Cases") {
                                $courtType2 = " AND (sp.sub_prod_name LIKE 'CESTAT Cases')";
                            }
                            elseif ($_REQUEST['aar'] == "Advance Ruling Authority") {
                                $courtType2 = " AND (sp.sub_prod_name LIKE 'Advance Ruling Authority')";
                            }
                            elseif ($_REQUEST['naa'] == "National Anti-Profiteering Authority") {
                                $courtType2 = " AND (sp.sub_prod_name LIKE 'National Anti-Profiteering Authority')";
                            }
                            elseif ($_REQUEST['aaar'] == "AAAR") {
                                $courtType2 = " AND (sp.sub_prod_name LIKE 'AAAR')";
                            }

                            // 2 Combination start
                            if (($_REQUEST['sc'] == "Supreme Court Cases") && ($_REQUEST['hc'] == "High Court Cases")){
                                $courtType2 = " AND (sp.sub_prod_name LIKE 'Supreme Court Cases' OR sp.sub_prod_name LIKE 'High Court Cases')";
                            } elseif (($_REQUEST['sc'] == "Supreme Court Cases") && ($_REQUEST['cc'] == "CESTAT Cases")){
                                $courtType2 = " AND (sp.sub_prod_name LIKE 'Supreme Court Cases' OR sp.sub_prod_name LIKE 'CESTAT Cases')";
                            } elseif (($_REQUEST['hc'] == "High Court Cases") && ($_REQUEST['cc'] == "CESTAT Cases")){
                                $courtType2 = " AND (sp.sub_prod_name LIKE 'High Court Cases' OR sp.sub_prod_name LIKE 'CESTAT Cases')";
                            } elseif (($_REQUEST['sc'] == "Supreme Court Cases") && ($_REQUEST['naa'] == "National Anti-Profiteering Authority")){
                                $courtType2 = " AND (sp.sub_prod_name LIKE 'Supreme Court Cases' OR sp.sub_prod_name LIKE 'National Anti-Profiteering Authority')";
                            } elseif (($_REQUEST['hc'] == "High Court Cases") && ($_REQUEST['naa'] == "National Anti-Profiteering Authority")){
                                $courtType2 = " AND (sp.sub_prod_name LIKE 'High Court Cases' OR sp.sub_prod_name LIKE 'National Anti-Profiteering Authority')";
                            } elseif (($_REQUEST['cc'] == "CESTAT Cases") && ($_REQUEST['naa'] == "National Anti-Profiteering Authority")){
                                $courtType2 = " AND (sp.sub_prod_name LIKE 'CESTAT Cases' OR sp.sub_prod_name LIKE 'National Anti-Profiteering Authority')";
                            } elseif (($_REQUEST['sc'] == "Supreme Court Cases") && ($_REQUEST['aar'] == "Advance Ruling Authority")){
                                $courtType2 = " AND (sp.sub_prod_name LIKE 'Supreme Court Cases' OR sp.sub_prod_name LIKE 'Advance Ruling Authority')";
                            } elseif (($_REQUEST['hc'] == "High Court Cases") && ($_REQUEST['aar'] == "Advance Ruling Authority")){
                                $courtType2 = " AND (sp.sub_prod_name LIKE 'High Court Cases' OR sp.sub_prod_name LIKE 'Advance Ruling Authority')";
                            } elseif (($_REQUEST['cc'] == "CESTAT Cases") && ($_REQUEST['aar'] == "Advance Ruling Authority")){
                                $courtType2 = " AND (sp.sub_prod_name LIKE 'CESTAT Cases' OR sp.sub_prod_name LIKE 'Advance Ruling Authority')";
                            } elseif (($_REQUEST['sc'] == "Supreme Court Cases") && ($_REQUEST['aaar'] == "AAAR")){
                                $courtType2 = " AND (sp.sub_prod_name LIKE 'Supreme Court Cases' OR sp.sub_prod_name LIKE 'AAAR')";
                            } elseif (($_REQUEST['hc'] == "High Court Cases") && ($_REQUEST['aaar'] == "AAAR")){
                                $courtType2 = " AND (sp.sub_prod_name LIKE 'High Court Cases' OR sp.sub_prod_name LIKE 'AAAR')";
                            } elseif (($_REQUEST['cc'] == "CESTAT Cases") && ($_REQUEST['aaar'] == "AAAR")){
                                $courtType2 = " AND (sp.sub_prod_name LIKE 'CESTAT Cases' OR sp.sub_prod_name LIKE 'AAAR')";
                            } elseif (($_REQUEST['aar'] == "Advance Ruling Authority") && ($_REQUEST['aaar'] == "AAAR")){
                                $courtType2 = " AND (sp.sub_prod_name LIKE 'Advance Ruling Authority' OR sp.sub_prod_name LIKE 'AAAR')";
                            } elseif (($_REQUEST['naa'] == "National Anti-Profiteering Authority") && ($_REQUEST['aaar'] == "AAAR")){
                                $courtType2 = " AND (sp.sub_prod_name LIKE 'National Anti-Profiteering Authority' OR sp.sub_prod_name LIKE 'AAAR')";
                            } elseif (($_REQUEST['aar'] == "Advance Ruling Authority") && ($_REQUEST['naa'] == "National Anti-Profiteering Authority")){
                                $courtType2 = " AND (sp.sub_prod_name LIKE 'Advance Ruling Authority' OR sp.sub_prod_name LIKE 'National Anti-Profiteering Authority')";
                            }

                            //3 combination start
                            if (($_REQUEST['sc'] == "Supreme Court Cases") && ($_REQUEST['hc'] == "High Court Cases") && ($_REQUEST['cc'] == "CESTAT Cases")){
                                $courtType2 = " AND (sp.sub_prod_name LIKE 'Supreme Court Cases' OR sp.sub_prod_name LIKE 'High Court Cases' OR sp.sub_prod_name LIKE 'CESTAT Cases')";
                            } elseif (($_REQUEST['sc'] == "Supreme Court Cases") && ($_REQUEST['hc'] == "High Court Cases") && ($_REQUEST['aar'] == "Advance Ruling Authority")){
                                $courtType2 = " AND (sp.sub_prod_name LIKE 'Supreme Court Cases' OR sp.sub_prod_name LIKE 'High Court Cases' OR sp.sub_prod_name LIKE 'Advance Ruling Authority')";
                            } elseif (($_REQUEST['sc'] == "Supreme Court Cases") && ($_REQUEST['cc'] == "CESTAT Cases") && ($_REQUEST['aar'] == "Advance Ruling Authority")){
                                $courtType2 = " AND (sp.sub_prod_name LIKE 'Supreme Court Cases' OR sp.sub_prod_name LIKE 'CESTAT Cases' OR sp.sub_prod_name LIKE 'Advance Ruling Authority')";
                            } elseif (($_REQUEST['hc'] == "High Court Cases") && ($_REQUEST['cc'] == "CESTAT Cases") && ($_REQUEST['aar'] == "Advance Ruling Authority")){
                                $courtType2 = " AND (sp.sub_prod_name LIKE 'High Court Cases' OR sp.sub_prod_name LIKE 'CESTAT Cases' OR sp.sub_prod_name LIKE 'Advance Ruling Authority')";
                            } elseif (($_REQUEST['sc'] == "Supreme Court Cases") && ($_REQUEST['hc'] == "High Court Cases") && ($_REQUEST['naa'] == "National Anti-Profiteering Authority")){
                                $courtType2 = " AND (sp.sub_prod_name LIKE 'Supreme Court Cases' OR sp.sub_prod_name LIKE 'High Court Cases' OR sp.sub_prod_name LIKE 'National Anti-Profiteering Authority')";
                            } elseif (($_REQUEST['sc'] == "Supreme Court Cases") && ($_REQUEST['cc'] == "CESTAT Cases") && ($_REQUEST['naa'] == "National Anti-Profiteering Authority")){
                                $courtType2 = " AND (sp.sub_prod_name LIKE 'Supreme Court Cases' OR sp.sub_prod_name LIKE 'CESTAT Cases' OR sp.sub_prod_name LIKE 'National Anti-Profiteering Authority')";
                            } elseif (($_REQUEST['hc'] == "High Court Cases") && ($_REQUEST['cc'] == "CESTAT Cases") && ($_REQUEST['naa'] == "National Anti-Profiteering Authority")){
                                $courtType2 = " AND (sp.sub_prod_name LIKE 'High Court Cases' OR sp.sub_prod_name LIKE 'CESTAT Cases' OR sp.sub_prod_name LIKE 'National Anti-Profiteering Authority')";
                            } elseif (($_REQUEST['sc'] == "Supreme Court Cases") && ($_REQUEST['aar'] == "Advance Ruling Authority") && ($_REQUEST['naa'] == "National Anti-Profiteering Authority")){
                                $courtType2 = " AND (sp.sub_prod_name LIKE 'Supreme Court Cases' OR sp.sub_prod_name LIKE 'Advance Ruling Authority' OR sp.sub_prod_name LIKE 'National Anti-Profiteering Authority')";
                            } elseif (($_REQUEST['hc'] == "High Court Cases") && ($_REQUEST['aar'] == "Advance Ruling Authority") && ($_REQUEST['naa'] == "National Anti-Profiteering Authority")){
                                $courtType2 = " AND (sp.sub_prod_name LIKE 'High Court Cases' OR sp.sub_prod_name LIKE 'Advance Ruling Authority' OR sp.sub_prod_name LIKE 'National Anti-Profiteering Authority')";
                            } elseif (($_REQUEST['cc'] == "CESTAT Cases") && ($_REQUEST['aar'] == "Advance Ruling Authority") && ($_REQUEST['naa'] == "National Anti-Profiteering Authority")){
                                $courtType2 = " AND (sp.sub_prod_name LIKE 'CESTAT Cases' OR sp.sub_prod_name LIKE 'Advance Ruling Authority' OR sp.sub_prod_name LIKE 'National Anti-Profiteering Authority')";
                            } elseif (($_REQUEST['sc'] == "Supreme Court Cases") && ($_REQUEST['hc'] == "High Court Cases") && ($_REQUEST['aaar'] == "AAAR")){
                                $courtType2 = " AND (sp.sub_prod_name LIKE 'Supreme Court Cases' OR sp.sub_prod_name LIKE 'High Court Cases' OR sp.sub_prod_name LIKE 'AAAR')";
                            } elseif (($_REQUEST['sc'] == "Supreme Court Cases") && ($_REQUEST['cc'] == "CESTAT Cases") && ($_REQUEST['aaar'] == "AAAR")){
                                $courtType2 = " AND (sp.sub_prod_name LIKE 'Supreme Court Cases' OR sp.sub_prod_name LIKE 'CESTAT Cases' OR sp.sub_prod_name LIKE 'AAAR')";
                            } elseif (($_REQUEST['hc'] == "High Court Cases") && ($_REQUEST['cc'] == "CESTAT Cases") && ($_REQUEST['aaar'] == "AAAR")){
                                $courtType2 = " AND (sp.sub_prod_name LIKE 'High Court Cases' OR sp.sub_prod_name LIKE 'CESTAT Cases' OR sp.sub_prod_name LIKE 'AAAR')";
                            } elseif (($_REQUEST['sc'] == "Supreme Court Cases") && ($_REQUEST['aar'] == "Advance Ruling Authority") && ($_REQUEST['aaar'] == "AAAR")){
                                $courtType2 = " AND (sp.sub_prod_name LIKE 'Supreme Court Cases' OR sp.sub_prod_name LIKE 'Advance Ruling Authority' OR sp.sub_prod_name LIKE 'AAAR')";
                            } elseif (($_REQUEST['hc'] == "High Court Cases") && ($_REQUEST['aar'] == "Advance Ruling Authority") && ($_REQUEST['aaar'] == "AAAR")){
                                $courtType2 = " AND (sp.sub_prod_name LIKE 'High Court Cases' OR sp.sub_prod_name LIKE 'Advance Ruling Authority' OR sp.sub_prod_name LIKE 'AAAR')";
                            } elseif (($_REQUEST['cc'] == "CESTAT Cases") && ($_REQUEST['aar'] == "Advance Ruling Authority") && ($_REQUEST['aaar'] == "AAAR")){
                                $courtType2 = " AND (sp.sub_prod_name LIKE 'CESTAT Cases' OR sp.sub_prod_name LIKE 'Advance Ruling Authority' OR sp.sub_prod_name LIKE 'AAAR')";
                            } elseif (($_REQUEST['sc'] == "Supreme Court Cases") && ($_REQUEST['naa'] == "National Anti-Profiteering Authority") && ($_REQUEST['aaar'] == "AAAR")){
                                $courtType2 = " AND (sp.sub_prod_name LIKE 'Supreme Court Cases' OR sp.sub_prod_name LIKE 'National Anti-Profiteering Authority' OR sp.sub_prod_name LIKE 'AAAR')";
                            } elseif (($_REQUEST['hc'] == "High Court Cases") && ($_REQUEST['naa'] == "National Anti-Profiteering Authority") && ($_REQUEST['aaar'] == "AAAR")){
                                $courtType2 = " AND (sp.sub_prod_name LIKE 'High Court Cases' OR sp.sub_prod_name LIKE 'National Anti-Profiteering Authority' OR sp.sub_prod_name LIKE 'AAAR')";
                            } elseif (($_REQUEST['cc'] == "CESTAT Cases") && ($_REQUEST['naa'] == "National Anti-Profiteering Authority") && ($_REQUEST['aaar'] == "AAAR")){
                                $courtType2 = " AND (sp.sub_prod_name LIKE 'CESTAT Cases' OR sp.sub_prod_name LIKE 'National Anti-Profiteering Authority' OR sp.sub_prod_name LIKE 'AAAR')";
                            } elseif (($_REQUEST['aar'] == "Advance Ruling Authority") && ($_REQUEST['naa'] == "National Anti-Profiteering Authority") && ($_REQUEST['aaar'] == "AAAR")){
                                $courtType2 = " AND (sp.sub_prod_name LIKE 'Advance Ruling Authority' OR sp.sub_prod_name LIKE 'National Anti-Profiteering Authority' OR sp.sub_prod_name LIKE 'AAAR')";
                            }

                            // 4 combination start
                            if (($_REQUEST['sc'] == "Supreme Court Cases") && ($_REQUEST['hc'] == "High Court Cases") && ($_REQUEST['cc'] == "CESTAT Cases") && ($_REQUEST['aar'] == "Advance Ruling Authority")){
                                $courtType2 = " AND (sp.sub_prod_name LIKE 'Supreme Court Cases' OR sp.sub_prod_name LIKE 'High Court Cases' OR sp.sub_prod_name LIKE 'CESTAT Cases' OR sp.sub_prod_name LIKE 'Advance Ruling Authority')";
                            } elseif (($_REQUEST['sc'] == "Supreme Court Cases") && ($_REQUEST['hc'] == "High Court Cases") && ($_REQUEST['cc'] == "CESTAT Cases") && ($_REQUEST['naa'] == "National Anti-Profiteering Authority")){
                                $courtType2 = " AND (sp.sub_prod_name LIKE 'Supreme Court Cases' OR sp.sub_prod_name LIKE 'High Court Cases' OR sp.sub_prod_name LIKE 'CESTAT Cases' OR sp.sub_prod_name LIKE 'National Anti-Profiteering Authority')";
                            } elseif (($_REQUEST['sc'] == "Supreme Court Cases") && ($_REQUEST['hc'] == "High Court Cases") && ($_REQUEST['aar'] == "Advance Ruling Authority") && ($_REQUEST['naa'] == "National Anti-Profiteering Authority")){
                                $courtType2 = " AND (sp.sub_prod_name LIKE 'Supreme Court Cases' OR sp.sub_prod_name LIKE 'High Court Cases' OR sp.sub_prod_name LIKE 'Advance Ruling Authority' OR sp.sub_prod_name LIKE 'National Anti-Profiteering Authority')";
                            } elseif (($_REQUEST['sc'] == "Supreme Court Cases") && ($_REQUEST['cc'] == "CESTAT Cases") && ($_REQUEST['aar'] == "Advance Ruling Authority") && ($_REQUEST['naa'] == "National Anti-Profiteering Authority")){
                                $courtType2 = " AND (sp.sub_prod_name LIKE 'Supreme Court Cases' OR sp.sub_prod_name LIKE 'CESTAT Cases' OR sp.sub_prod_name LIKE 'Advance Ruling Authority' OR sp.sub_prod_name LIKE 'National Anti-Profiteering Authority')";
                            } elseif (($_REQUEST['hc'] == "High Court Cases") && ($_REQUEST['cc'] == "CESTAT Cases") && ($_REQUEST['aar'] == "Advance Ruling Authority") && ($_REQUEST['naa'] == "National Anti-Profiteering Authority")){
                                $courtType2 = " AND (sp.sub_prod_name LIKE 'High Court Cases' OR sp.sub_prod_name LIKE 'CESTAT Cases' OR sp.sub_prod_name LIKE 'Advance Ruling Authority' OR sp.sub_prod_name LIKE 'National Anti-Profiteering Authority')";
                            } elseif (($_REQUEST['sc'] == "Supreme Court Cases") && ($_REQUEST['hc'] == "High Court Cases") && ($_REQUEST['cc'] == "CESTAT Cases") && ($_REQUEST['aaar'] == "AAAR")){
                                $courtType2 = " AND (sp.sub_prod_name LIKE 'Supreme Court Cases' OR sp.sub_prod_name LIKE 'High Court Cases' OR sp.sub_prod_name LIKE 'CESTAT Cases' OR sp.sub_prod_name LIKE 'AAAR')";
                            } elseif (($_REQUEST['sc'] == "Supreme Court Cases") && ($_REQUEST['hc'] == "High Court Cases") && ($_REQUEST['aar'] == "Advance Ruling Authority") && ($_REQUEST['aaar'] == "AAAR")){
                                $courtType2 = " AND (sp.sub_prod_name LIKE 'Supreme Court Cases' OR sp.sub_prod_name LIKE 'High Court Cases' OR sp.sub_prod_name LIKE 'Advance Ruling Authority' OR sp.sub_prod_name LIKE 'AAAR')";
                            } elseif (($_REQUEST['sc'] == "Supreme Court Cases") && ($_REQUEST['cc'] == "CESTAT Cases") && ($_REQUEST['aar'] == "Advance Ruling Authority") && ($_REQUEST['aaar'] == "AAAR")){
                                $courtType2 = " AND (sp.sub_prod_name LIKE 'Supreme Court Cases' OR sp.sub_prod_name LIKE 'CESTAT Cases' OR sp.sub_prod_name LIKE 'Advance Ruling Authority' OR sp.sub_prod_name LIKE 'AAAR')";
                            } elseif (($_REQUEST['hc'] == "High Court Cases") && ($_REQUEST['cc'] == "CESTAT Cases") && ($_REQUEST['aar'] == "Advance Ruling Authority") && ($_REQUEST['aaar'] == "AAAR")){
                                $courtType2 = " AND (sp.sub_prod_name LIKE 'High Court Cases' OR sp.sub_prod_name LIKE 'CESTAT Cases' OR sp.sub_prod_name LIKE 'Advance Ruling Authority' OR sp.sub_prod_name LIKE 'AAAR')";
                            } elseif (($_REQUEST['sc'] == "Supreme Court Cases") && ($_REQUEST['hc'] == "High Court Cases") && ($_REQUEST['naa'] == "National Anti-Profiteering Authority") && ($_REQUEST['aaar'] == "AAAR")){
                                $courtType2 = " AND (sp.sub_prod_name LIKE 'Supreme Court Cases' OR sp.sub_prod_name LIKE 'High Court Cases' OR sp.sub_prod_name LIKE 'National Anti-Profiteering Authority' OR sp.sub_prod_name LIKE 'AAAR')";
                            } elseif (($_REQUEST['sc'] == "Supreme Court Cases") && ($_REQUEST['cc'] == "CESTAT Cases") && ($_REQUEST['naa'] == "National Anti-Profiteering Authority") && ($_REQUEST['aaar'] == "AAAR")){
                                $courtType2 = " AND (sp.sub_prod_name LIKE 'Supreme Court Cases' OR sp.sub_prod_name LIKE 'CESTAT Cases' OR sp.sub_prod_name LIKE 'National Anti-Profiteering Authority' OR sp.sub_prod_name LIKE 'AAAR')";
                            } elseif (($_REQUEST['hc'] == "High Court Cases") && ($_REQUEST['cc'] == "CESTAT Cases") && ($_REQUEST['naa'] == "National Anti-Profiteering Authority") && ($_REQUEST['aaar'] == "AAAR")){
                                $courtType2 = " AND (sp.sub_prod_name LIKE 'High Court Cases' OR sp.sub_prod_name LIKE 'CESTAT Cases' OR sp.sub_prod_name LIKE 'National Anti-Profiteering Authority' OR sp.sub_prod_name LIKE 'AAAR')";
                            } elseif (($_REQUEST['sc'] == "Supreme Court Cases") && ($_REQUEST['aar'] == "Advance Ruling Authority") && ($_REQUEST['naa'] == "National Anti-Profiteering Authority") && ($_REQUEST['aaar'] == "AAAR")){
                                $courtType2 = " AND (sp.sub_prod_name LIKE 'Supreme Court Cases' OR sp.sub_prod_name LIKE 'Advance Ruling Authority' OR sp.sub_prod_name LIKE 'National Anti-Profiteering Authority' OR sp.sub_prod_name LIKE 'AAAR')";
                            } elseif (($_REQUEST['hc'] == "High Court Cases") && ($_REQUEST['aar'] == "Advance Ruling Authority") && ($_REQUEST['naa'] == "National Anti-Profiteering Authority") && ($_REQUEST['aaar'] == "AAAR")){
                                $courtType2 = " AND (sp.sub_prod_name LIKE 'High Court Cases' OR sp.sub_prod_name LIKE 'Advance Ruling Authority' OR sp.sub_prod_name LIKE 'National Anti-Profiteering Authority' OR sp.sub_prod_name LIKE 'AAAR')";
                            } elseif (($_REQUEST['cc'] == "CESTAT Cases") && ($_REQUEST['aar'] == "Advance Ruling Authority") && ($_REQUEST['naa'] == "National Anti-Profiteering Authority") && ($_REQUEST['aaar'] == "AAAR")){
                                $courtType2 = " AND (sp.sub_prod_name LIKE 'CESTAT Cases' OR sp.sub_prod_name LIKE 'Advance Ruling Authority' OR sp.sub_prod_name LIKE 'National Anti-Profiteering Authority' OR sp.sub_prod_name LIKE 'AAAR')";
                            }

                            // 5 combination start
                            if (($_REQUEST['sc'] == "Supreme Court Cases") && ($_REQUEST['hc'] == "High Court Cases") && ($_REQUEST['cc'] == "CESTAT Cases") && ($_REQUEST['aar'] == "Advance Ruling Authority") && ($_REQUEST['naa'] == "National Anti-Profiteering Authority")){
                                $courtType2 = " AND (sp.sub_prod_name LIKE 'Supreme Court Cases' OR sp.sub_prod_name LIKE 'High Court Cases' OR sp.sub_prod_name LIKE 'CESTAT Cases' OR sp.sub_prod_name LIKE 'Advance Ruling Authority' OR sp.sub_prod_name LIKE 'National Anti-Profiteering Authority')";
                            } elseif (($_REQUEST['sc'] == "Supreme Court Cases") && ($_REQUEST['hc'] == "High Court Cases") && ($_REQUEST['cc'] == "CESTAT Cases") && ($_REQUEST['aar'] == "Advance Ruling Authority") && ($_REQUEST['aaar'] == "AAAR")){
                                $courtType2 = " AND (sp.sub_prod_name LIKE 'Supreme Court Cases' OR sp.sub_prod_name LIKE 'High Court Cases' OR sp.sub_prod_name LIKE 'CESTAT Cases' OR sp.sub_prod_name LIKE 'Advance Ruling Authority' OR sp.sub_prod_name LIKE 'AAAR')";
                            } elseif (($_REQUEST['sc'] == "Supreme Court Cases") && ($_REQUEST['hc'] == "High Court Cases") && ($_REQUEST['cc'] == "CESTAT Cases") && ($_REQUEST['naa'] == "National Anti-Profiteering Authority") && ($_REQUEST['aaar'] == "AAAR")){
                                $courtType2 = " AND (sp.sub_prod_name LIKE 'Supreme Court Cases' OR sp.sub_prod_name LIKE 'High Court Cases' OR sp.sub_prod_name LIKE 'CESTAT Cases' OR sp.sub_prod_name LIKE 'National Anti-Profiteering Authority' OR sp.sub_prod_name LIKE 'AAAR')";
                            } elseif (($_REQUEST['sc'] == "Supreme Court Cases") && ($_REQUEST['hc'] == "High Court Cases") && ($_REQUEST['aar'] == "Advance Ruling Authority") && ($_REQUEST['naa'] == "National Anti-Profiteering Authority") && ($_REQUEST['aaar'] == "AAAR")){
                                $courtType2 = " AND (sp.sub_prod_name LIKE 'Supreme Court Cases' OR sp.sub_prod_name LIKE 'High Court Cases' OR sp.sub_prod_name LIKE 'Advance Ruling Authority' OR sp.sub_prod_name LIKE 'National Anti-Profiteering Authority' OR sp.sub_prod_name LIKE 'AAAR')";
                            } elseif (($_REQUEST['sc'] == "Supreme Court Cases") && ($_REQUEST['cc'] == "CESTAT Cases") && ($_REQUEST['aar'] == "Advance Ruling Authority") && ($_REQUEST['naa'] == "National Anti-Profiteering Authority") && ($_REQUEST['aaar'] == "AAAR")){
                                $courtType2 = " AND (sp.sub_prod_name LIKE 'Supreme Court Cases' OR sp.sub_prod_name LIKE 'CESTAT Cases' OR sp.sub_prod_name LIKE 'Advance Ruling Authority' OR sp.sub_prod_name LIKE 'National Anti-Profiteering Authority' OR sp.sub_prod_name LIKE 'AAAR')";
                            } elseif (($_REQUEST['hc'] == "High Court Cases") && ($_REQUEST['cc'] == "CESTAT Cases") && ($_REQUEST['aar'] == "Advance Ruling Authority") && ($_REQUEST['naa'] == "National Anti-Profiteering Authority") && ($_REQUEST['aaar'] == "AAAR")){
                                $courtType2 = " AND (sp.sub_prod_name LIKE 'High Court Cases' OR sp.sub_prod_name LIKE 'CESTAT Cases' OR sp.sub_prod_name LIKE 'Advance Ruling Authority' OR sp.sub_prod_name LIKE 'National Anti-Profiteering Authority' OR sp.sub_prod_name LIKE 'AAAR')";
                            }

                            // All combination start
                            if (($_REQUEST['sc'] == "Supreme Court Cases") && ($_REQUEST['hc'] == "High Court Cases") && ($_REQUEST['cc'] == "CESTAT Cases") && ($_REQUEST['aar'] == "Advance Ruling Authority") && ($_REQUEST['naa'] == "National Anti-Profiteering Authority") && ($_REQUEST['aaar'] == "AAAR")){
                                $courtType2 = " AND (sp.sub_prod_name LIKE 'Supreme Court Cases' OR sp.sub_prod_name LIKE 'High Court Cases' OR sp.sub_prod_name LIKE 'CESTAT Cases' OR sp.sub_prod_name LIKE 'Advance Ruling Authority' OR sp.sub_prod_name LIKE 'National Anti-Profiteering Authority' OR sp.sub_prod_name LIKE 'AAAR')";
                            } 
                            

                            // for keyword
                            if (!empty($keyword)) {
                                $string = trim(clean($keyword));
                                $rep_data = shortForm($string);
                                if ($_REQUEST['search_in'] == 1) {
                                    if($_REQUEST['exact_search']=='exact'){
                                        $variable1 = explode(",", $keyword);
                                        foreach ($variable1 as $v1) {
                                            $conditions[] = "(a.cir_subject LIKE '% " . $v1 . " %' OR a.cir_subject LIKE '% " . $rep_data[0] . " %')";
                                        }
                                    } else {
                                        $variable2 = explode(" ", $keyword);
                                        foreach ($variable2 as $v2) {
                                            $conditions[] = "(a.cir_subject LIKE '%" . $v2 . "%' OR a.cir_subject LIKE '%" . $rep_data[0] . "%')";
                                        }
                                    }
                                } else if ($_REQUEST['search_in'] == 2) {
                                    if($_REQUEST['exact_search']=='exact'){
                                        $variable3 = explode(",", $string);
                                        foreach ($variable3 as $v3) {
                                            $conditions[] = "(a.cir_subject LIKE '% " . $v3 . " %' OR 
                                                a.file_data LIKE '% " . $v3 . " %' OR a.cir_subject LIKE '% " . $rep_data[0] . " %' OR 
                                                a.file_data LIKE '% " . $rep_data[0] . " %')";
                                        }
                                    } else {
                                        $variable4 = explode(" ", $string);
                                        foreach ($variable4 as $v4) {
                                            $conditions[] = "(a.cir_subject LIKE '%" . $v4 . "%' OR  
                                                a.file_data LIKE '%" . $v4 . "%' OR a.cir_subject LIKE '%" . $rep_data[0] . "%' OR  
                                                a.file_data LIKE '%" . $rep_data[0] . "%')";
                                        }
                                    }
                                } else {
                                    if($_REQUEST['exact_search']=='exact'){
                                        $variable5 = explode(",", $string);
                                        foreach ($variable5 as $v5) {
                                            $conditions[] = "(a.cir_subject LIKE '% " . $v5 . " %' OR 
                                                a.file_data LIKE '% " . $v5 . " %' OR a.cir_subject LIKE '% " . $rep_data[0] . " %' OR 
                                                a.file_data LIKE '% " . $rep_data[0] . " %')";
                                        }
                                    } else {
                                        $variable6 = explode(" ", $string);
                                        foreach ($variable6 as $v6) {
                                            $conditions[] = "(a.cir_subject LIKE '%" . $v6 . "%' OR  
                                                a.file_data LIKE '%" . $v6 . "%' OR a.cir_subject LIKE '%" . $rep_data[0] . "%' OR  
                                                a.file_data LIKE '%" . $rep_data[0] . "%')";
                                        }
                                    }
                                }
                            }

                            // for Party name
                            if ($_REQUEST['party_name'] != "") {
                                $party_name = mysqli_real_escape_string($con,$_REQUEST['party_name']);
                                $string = trim($party_name);
                                $rep_data = shortForm($string);

                                $conditions[] = "(a.party_name LIKE '%" . $string . "%' OR a.party_name LIKE '%" . $rep_data[0] . "%')";
                            }

                            // for Judge name
                            if ($_REQUEST['judge_name'] != "") {
                                $judge_name = mysqli_real_escape_string($con,$_REQUEST['judge_name']);
                                $string = trim($judge_name);
                                $rep_data = shortForm($string);

                                $conditions[] = "(a.judge_name LIKE '%" . $string . "%' OR a.judge_name LIKE '%" . $rep_data[0] . "%' OR a.file_data LIKE '%" . $string . "%' OR a.file_data LIKE '%" . $rep_data[0] . "%')";
                            }

                            // for Order No
                            if ($_REQUEST['order_no'] != "") {
                                $order_no = mysqli_real_escape_string($con,$_REQUEST['order_no']);
                                $string = trim($order_no);
                                $rep_data = shortForm($string);

                                $conditions[] = "(a.order_no LIKE '%" . $string . "%' OR a.order_no LIKE '%" . $rep_data[0] . "%')";
                            }

                            // for Case No
                            if ($_REQUEST['case_no'] != "") {
                                $case_no = mysqli_real_escape_string($con,$_REQUEST['case_no']);
                                $string = trim($case_no);
                                $rep_data = shortForm($string);

                                $conditions[] = "(a.case_no LIKE '%" . $string . "%' OR a.case_no LIKE '%" . $rep_data[0] . "%')";
                            }

                           // print_r($_REQUEST);die;
                            // for Date
                            if ($_REQUEST['date'] != "") {
                                $date = mysqli_real_escape_string($con,$_REQUEST['date']);
                                $conditions[] = "a.circular_date LIKE '$date%'";
                            }

                            //for Date Range
                            if ($_REQUEST['dt_from'] != "" || $_REQUEST['dt_to'] != "") {
                                $fromDate = $_REQUEST['dt_from'];
                                $toDate = $_REQUEST['dt_to'];
                                if ($_REQUEST['dt_from'] == "") {
                                    $fromDate = '1942-01-01';
                                }
                                if ($_REQUEST['dt_to'] == "") {
                                    $toDate = date('Y-m-d');
                                }
                                $conditions[] = "(a.circular_date BETWEEN '$fromDate%' AND '$toDate%')";
                            }

                            //<--------Condition For Citation number--------->
                            $year = mysqli_real_escape_string($con,$_REQUEST['year']);
                            $volume = trim(mysqli_real_escape_string($con,$_REQUEST['vol']));
                            $c_value = trim(mysqli_real_escape_string($con,$_REQUEST['Citation']));

                            if (!empty($year) && !empty($volume) && !empty($c_value)) {
                                $c_no = $year . "-VIL-" . $volume . "-" . $c_value;
                                $conditions[] = "a.circular_no LIKE '%$c_no%'";
                            } elseif (!empty($year) && !empty($volume)) {
                                $c_no = $year . "-VIL-" . $volume;
                                $conditions[] = "a.circular_no LIKE '%$c_no%'";
                            } elseif (!empty($volume) && !empty($c_value)) {
                                $c_no = "-VIL-" . $volume . "-" . $c_value;
                                $conditions[] = "a.circular_no = '%$c_no%'";
                            } elseif (!empty($year)) {
                                $c_no = $year . "-VIL-";
                                $conditions[] = "a.circular_no = '%$c_no%'";
                            } elseif (!empty($volume)) {
                                $c_no = "-VIL-" . $volume;
                                $conditions[] = "a.circular_no = '%$c_no%'";
                            } elseif (!empty($c_value)) {
                                $c_no = $c_value;
                                $conditions[] = "a.circular_no LIKE '%$c_no%'";
                            }
                            //<--------End of  Citation number--------->

                            // for cgst section 
                            if ($_REQUEST['cgst_section'] != "" || $_REQUEST['cgst_section1'] != "" || $_REQUEST['cgst_section2'] != "") {

                                if ($_REQUEST['cgst_section'] != "") {
                                    $sec_no = trim(mysqli_real_escape_string($con,$_REQUEST['cgst_section']));
                                } else {
                                    $sec_no = "";
                                }

                                if ($_REQUEST['cgst_section1'] != "") {
                                    $sec_no1 = "(" . trim(mysqli_real_escape_string($con,$_REQUEST['cgst_section1'])) . ")";
                                } else {
                                    $sec_no1 = "";
                                }
                                if ($_REQUEST['cgst_section2'] != "") {
                                    $sec_alf = "(" . trim(mysqli_real_escape_string($con,$_REQUEST['cgst_section2'])) . ")";
                                } else {
                                    $sec_alf = "";
                                }

                                $cgst_section = $sec_no . $sec_no1 . $sec_alf;
                                if ($_REQUEST['prod_id'] == "0" || $_REQUEST['prod_id'] == "7") {
                                    if ($_REQUEST['prod_id'] == "0") {
                                        $conditions[] = "a.prod_id='7'";
                                    }
                                    
                                    if ($_REQUEST['exact_search'] == 'exact') {
                                        $conditions[] = "(a.section_no = '$cgst_section' OR a.section_no LIKE '%, $cgst_section,%' OR a.section_no LIKE '%, $cgst_section' OR a.section_no LIKE '%,$cgst_section,%' OR a.section_no LIKE '%,$cgst_section' OR a.section_no LIKE '$cgst_section,%')";
                                    } else {
                                        $conditions[] = "(a.section_no LIKE '%$cgst_section%')";
                                    }
                                }
                            }

                            // for cgst rules
                            if ($_REQUEST['cgst_rule'] != "" || $_REQUEST['cgst_rule1'] != "" || $_REQUEST['cgst_rule2'] != "") {

                                if ($_REQUEST['cgst_rule'] != "") {
                                    $rule_no = trim(mysqli_real_escape_string($con,$_REQUEST['cgst_rule']));
                                } else {
                                    $rule_no = "";
                                }

                                if ($_REQUEST['cgst_rule1'] != "") {
                                    $rule_no1 = "(" . trim(mysqli_real_escape_string($con,$_REQUEST['cgst_rule1'])) . ")";
                                } else {
                                    $rule_no1 = "";
                                }
                                if ($_REQUEST['cgst_rule2'] != "") {
                                    $rule_alf = "(" . trim(mysqli_real_escape_string($con,$_REQUEST['cgst_rule2'])) . ")";
                                } else {
                                    $rule_alf = "";
                                }
                                $cgst_rule = $rule_no . $rule_no1 . $rule_alf;
                                if ($_REQUEST['prod_id'] == "0" || $_REQUEST['prod_id'] == "7") {
                                    if ($_REQUEST['prod_id'] == "0") {
                                        $conditions[] = "a.prod_id='7'";
                                    }
                                    
                                    if ($_REQUEST['exact_search'] == 'exact') {
                                        $conditions[] = "(a.rule_no = '$cgst_rule' OR a.rule_no LIKE '%, $cgst_rule,%' OR a.rule_no LIKE '%, $cgst_rule' OR a.rule_no LIKE '%,$cgst_rule,%' OR a.rule_no LIKE '%,$cgst_rule' OR a.rule_no LIKE '$cgst_rule,%')";
                                    } else {
                                        $conditions[] = "(a.rule_no LIKE '%$cgst_rule%')";
                                    }
                                }
                            }

                            // for igst section 
                            if ($_REQUEST['igst_section'] != "" || $_REQUEST['igst_section1'] != "" || $_REQUEST['igst_section2'] != "") {

                                if ($_REQUEST['igst_section'] != "") {
                                    $sec_no = trim(mysqli_real_escape_string($con,$_REQUEST['igst_section']));
                                } else {
                                    $sec_no = "";
                                }

                                if ($_REQUEST['igst_section1'] != "") {
                                    $sec_no1 = "(" . trim(mysqli_real_escape_string($con,$_REQUEST['igst_section1'])) . ")";
                                } else {
                                    $sec_no1 = "";
                                }
                                if ($_REQUEST['igst_section2'] != "") {
                                    $sec_alf = "(" . trim(mysqli_real_escape_string($con,$_REQUEST['igst_section2'])) . ")";
                                } else {
                                    $sec_alf = "";
                                }

                                $igst_section = $sec_no . $sec_no1 . $sec_alf;
                                if ($_REQUEST['prod_id'] == "0" || $_REQUEST['prod_id'] == "7") {
                                    if ($_REQUEST['prod_id'] == "0") {
                                        $conditions[] = "a.prod_id='7'";
                                    }
                                    
                                    if ($_REQUEST['exact_search'] == 'exact') {
                                        $conditions[] = "(a.igst_section_no = '$igst_section' OR a.igst_section_no LIKE '%, $igst_section,%' OR a.igst_section_no LIKE '%, $igst_section' OR a.igst_section_no LIKE '%,$igst_section,%' OR a.igst_section_no LIKE '%,$igst_section' OR a.igst_section_no LIKE '$igst_section,%')";
                                    } else {
                                        $conditions[] = "(a.igst_section_no LIKE '%$igst_section%')";
                                    }
                                }
                            }

                            // for igst rules
                            if ($_REQUEST['igst_rule'] != "" || $_REQUEST['igst_rule1'] != "" || $_REQUEST['igst_rule2'] != "") {

                                if ($_REQUEST['igst_rule'] != "") {
                                    $rule_no = trim(mysqli_real_escape_string($con,$_REQUEST['igst_rule']));
                                } else {
                                    $rule_no = "";
                                }

                                if ($_REQUEST['igst_rule1'] != "") {
                                    $rule_no1 = "(" . trim(mysqli_real_escape_string($con,$_REQUEST['igst_rule1'])) . ")";
                                } else {
                                    $rule_no1 = "";
                                }
                                if ($_REQUEST['igst_rule2'] != "") {
                                    $rule_alf = "(" . trim(mysqli_real_escape_string($con,$_REQUEST['igst_rule2'])) . ")";
                                } else {
                                    $rule_alf = "";
                                }

                                $igst_rule = $rule_no . $rule_no1 . $rule_alf;
                                if ($_REQUEST['prod_id'] == "0" || $_REQUEST['prod_id'] == "7") {
                                    if ($_REQUEST['prod_id'] == "0") {
                                        $conditions[] = "a.prod_id='7'";
                                    }
                                    
                                    if ($_REQUEST['exact_search'] == 'exact') {
                                        $conditions[] = "(a.igst_rule_no = '$igst_rule' OR a.igst_rule_no LIKE '%, $igst_rule,%' OR a.igst_rule_no LIKE '%, $igst_rule' OR a.igst_rule_no LIKE '%,$igst_rule,%' OR a.igst_rule_no LIKE '%,$igst_rule' OR a.igst_rule_no LIKE '$igst_rule,%')";
                                    } else {
                                        $conditions[] = "(a.igst_rule_no LIKE '%$igst_rule%')";
                                    }
                                }
                            }

                            // for court
                            if ($_REQUEST['court'] != '0') {
                                if ($_REQUEST['court'] == "HC") {
                                    $courtType = " AND (sp.sub_prod_name LIKE 'High Court Cases')";
                                    if ($_REQUEST['courtCity'] != '0') {
                                        $conditions[] = "a.circular_no LIKE '%" . $_REQUEST['courtCity'] . "%'";
                                    }
                                } else if ($_REQUEST['court'] == "SC") {
                                    $courtType = " AND (sp.sub_prod_name LIKE 'Supreme Court Cases')";
                                } else if ($_REQUEST['court'] == "TRI") {
                                    //          $courtType= " AND (sp.sub_prod_name LIKE 'Tribunal')";
                                    $courtType = " AND (sp.sub_prod_name LIKE 'CESTAT Cases')";
                                    if ($_REQUEST['courtCity1'] != '0') {
                                        $conditions[] = "a.circular_no LIKE '%" . $_REQUEST['courtCity1'] . "%'";
                                    }
                                } else if ($_REQUEST['court'] == "AAR") {
                                    $courtType = " AND (sp.sub_prod_name LIKE 'Advance Ruling Authority')";
                                } else if ($_REQUEST['court'] == "AAAR") {
                                    $courtType = " AND (sp.sub_prod_name LIKE 'AAAR')";
                                } else if ($_REQUEST['court'] == "NAA") {
                                    $courtType = " AND (sp.sub_prod_name LIKE 'National Anti-Profiteering Authority')";
                                }
                            } else {
                                $courtType = "";
                            }
                            //echo "<pre>";
                            //print_r($conditions);die;

                            // for category
                            if ($_REQUEST['prod_id'] != 0) {
                                $result = mysqli_query($GLOBALS['con'],"SELECT p.prod_id,p.dbsuffix,sp.sub_prod_id FROM product as p LEFT JOIN sub_product as sp ON p.prod_id=sp.prod_id WHERE p.prod_id= '" . $_REQUEST['prod_id'] . "' AND (sp.sub_prod_type LIKE 'Judgements')" . $courtType2 . $courtType) or die(mysqli_error());
                                $sub_prod = [];

                                if (mysqli_num_rows($result) > 0) {
                                    while ($data = mysqli_fetch_array($result)) {
                                        $sub_prod[] = "a.sub_prod_id = '" . $data['sub_prod_id'] . "'";
                                        $data_db = $data['dbsuffix'];
                                    }
                                }else{
                                }
                                if (!empty($sub_prod)) {
                                    if (!empty($conditions)) {
                                        $where_subprod = " AND (" . implode(' OR ', $sub_prod) . ")";
                                    } else {
                                        $where_subprod = implode(' OR ', $sub_prod);
                                    }
                                } else {
                                    $where_subprod = "";
                                }
                                $orderby = " ORDER BY circular_date DESC";
                                $query = "SELECT a.*,DATE_FORMAT(circular_date,GET_FORMAT(DATE,'EUR'))'Date',p.prod_name,p.dbsuffix,sp.sub_prod_name,sm.state_name FROM casedata_" . $data_db . " as a LEFT JOIN product as p ON a.prod_id=p.prod_id LEFT JOIN sub_product as sp ON a.sub_prod_id=sp.sub_prod_id LEFT JOIN state_master as sm ON a.state_id=sm.state_id ";
                                 $sql = $query . "WHERE data_id IN $search_id AND " . implode(' AND ', $conditions) . $where_subprod . " " . $orderby;
                            
                            } else {
                                $orderby = " ORDER BY circular_date DESC";
                                $id = ['1', '2', '4', '5', '7'];
                                $table = array("casedata_vat", "casedata_st", "casedata_ce", "casedata_cu", "casedata_sgst");
                                $sub_prod_name = "AND (sp.sub_prod_type LIKE 'Judgements')" . $courtType2 . $courtType;
                                return $sql = implode(" UNION ", (tableUnion2($conditions, $table, $id, $sub_prod_name, $search_id))) . " " . $orderby;
                            }
                            //echo "<br>".$sql;die;
                         return $sql;
                        }
                    }

                    // Articles Page Search //
                    if ($_REQUEST['pagename'] == 'Articles') {
                        $article_search_id = $_SESSION['article_search_id'];
                        $prod_id = mysqli_real_escape_string($con,$_REQUEST['prod_id']);
                        $text = mysqli_real_escape_string($con,$_REQUEST['keyword']);
                        $topic = mysqli_real_escape_string($con,$_REQUEST['topic']);
                        $fromDate = mysqli_real_escape_string($con,$_REQUEST['fromDate']);
                        $toDate = mysqli_real_escape_string($con,$_REQUEST['toDate']);
                        $dbsuffix = mysqli_real_escape_string($con,$_REQUEST['dbsuffix']);
                        $author = mysqli_real_escape_string($con,$_REQUEST['author']);

                        $row_count = $_SESSION['row_count'];
                        $user_id = $_SESSION["id"];
                        $user_name = $_SESSION["user"];
                        $page_name = "Articles";
                        $search_in = "Advance Search";
                        $search_form_data = array(
                            'user_id' => $user_id,
                            'user_name' => $user_name,
                            'keyword' => $text,
                            'topic' => $topic,
                            'pagename' => $page_name,
                            'search_in' => $search_in,
                            'row_count' => $row_count,
                            'updated_dt' => date('Y-m-d H:i:s')
                        );
                        dbRowInsert('search_history', $search_form_data);
                        function articles() {
                            global $con;
                            $article_search_id = $_SESSION['article_search_id'];
                            $prod_id = mysqli_real_escape_string($con,$_REQUEST['prod_id']);
                            $text = mysqli_real_escape_string($con,$_REQUEST['keyword']);
                            $topic = mysqli_real_escape_string($con,$_REQUEST['topic']);
                            $fromDate = mysqli_real_escape_string($con,$_REQUEST['fromDate']);
                            $toDate = mysqli_real_escape_string($con,$_REQUEST['toDate']);
                            $dbsuffix = mysqli_real_escape_string($con,$_REQUEST['dbsuffix']);
                            $author = mysqli_real_escape_string($con,$_REQUEST['author']);

                            $query = "SELECT *,article_id 'id',DATE_FORMAT( article_date, GET_FORMAT( DATE, 'EUR' ) )  'Date' FROM $dbsuffix";
                            $conditions = array();
                            if ($author != '0') {
                                $conditions[] = "author='$author'";
                            }
                            if ($prod_id != '0') {
                                $conditions[] = "category='$prod_id'";
                            }
                            if (!empty($text)) {
                                $rep_data = shortForm($text, '', '');
                                if($_REQUEST['exact_search']=='exact'){
                                    $variable = explode(",", $text);
                                    foreach ($variable as $v) {
                                        $conditions[] = "(file_data LIKE '%" . $v . "%')";
                                    }
                                } else {
                                    $variable2 = explode(" ", $text);
                                    foreach ($variable2 as $v2) {
                                        $conditions[] = "(file_data LIKE '%" . $v . "%')";
                                    }
                                }
                            }
                            if (!empty($topic)) {
                                $rep_data = shortForm($topic, '', '');
                                $conditions[] = "(summary LIKE '%" . $topic . "%' OR summary LIKE '%" . $rep_data[0] . "%')";
                            }
                            if (!empty($fromDate) || !empty($toDate)) {
                                if (empty($fromDate)) {
                                    $fromDate = '2015-01-01';
                                }
                                if (empty($toDate)) {
                                    $toDate = date('Y-m-d');
                                }
                                $conditions[] = "(article_date BETWEEN '$fromDate%' AND '$toDate%')";
                            }
                            $sql = $query;
                            $query2 = " ORDER BY article_id DESC";
                            if (count($conditions) > 0) {
                                return $sql .= " WHERE article_id IN $article_search_id AND " . implode(' AND ', $conditions) . $query2;
                            } else {
                                return $sql.=$query2;
                            }
                        }
                    }

                    // Tax Vista Page Search //
                    if ($_REQUEST['pagename'] == 'tax vista') {
                        $taxvista_id = $_SESSION['article_search_id'];
                        $text = mysqli_real_escape_string($con,$_REQUEST['keyword']);
                        $fromDate = mysqli_real_escape_string($con,$_REQUEST['fromDate']);
                        $toDate = mysqli_real_escape_string($con,$_REQUEST['toDate']);
                        $dbsuffix = mysqli_real_escape_string($con,$_REQUEST['dbsuffix']);

                        $row_count = $_SESSION['row_count'];
                        $user_id = $_SESSION["id"];
                        $user_name = $_SESSION["user"];
                        $page_name = "tax vista";
                        $search_in = "Advance Search";
                        $search_form_data = array(
                            'user_id' => $user_id,
                            'user_name' => $user_name,
                            'keyword' => $text,
                            'pagename' => $page_name,
                            'search_in' => $search_in,
                            'row_count' => $row_count,
                            'updated_dt' => date('Y-m-d H:i:s')
                        );
                        dbRowInsert('search_history', $search_form_data);
                        function tax_vista() {
                            global $con;
                            $taxvista_id = $_SESSION['article_search_id'];
                            $text = mysqli_real_escape_string($con,$_REQUEST['keyword']);
                            $fromDate = mysqli_real_escape_string($con,$_REQUEST['fromDate']);
                            $toDate = mysqli_real_escape_string($con,$_REQUEST['toDate']);
                            $dbsuffix = mysqli_real_escape_string($con,$_REQUEST['dbsuffix']);

                            $query = "SELECT *,article_id 'id',DATE_FORMAT( article_date, GET_FORMAT( DATE, 'EUR' ) )  'Date' FROM $dbsuffix";
                            $conditions = array();
                            if (!empty($text)) {
                                $rep_data = shortForm($text, '', '');
                                if($_REQUEST['exact_search']=='exact'){
                                    $variable = explode(",", $text);
                                    foreach ($variable as $v) {
                                        $conditions[] = "(file_data LIKE '%" . $v . "%')";
                                    }
                                } else {
                                    $variable2 = explode(" ", $text);
                                    foreach ($variable2 as $v2) {
                                        $conditions[] = "(file_data LIKE '%" . $v . "%')";
                                    }
                                }
                            }
                            if (!empty($topic)) {
                                $rep_data = shortForm($topic, '', '');
                                $conditions[] = "(summary LIKE '%" . $topic . "%' OR summary LIKE '%" . $rep_data[0] . "%')";
                            }
                            if (!empty($fromDate) || !empty($toDate)) {
                                if (empty($fromDate)) {
                                    $fromDate = '2015-01-01';
                                }
                                if (empty($toDate)) {
                                    $toDate = date('Y-m-d');
                                }
                                $conditions[] = "(article_date BETWEEN '$fromDate%' AND '$toDate%')";
                            }
                            $sql = $query;
                            $query2 = " ORDER BY article_id DESC";
                            if (count($conditions) > 0) {
                                return $sql .= " WHERE article_id IN $taxvista_id AND " . implode(' AND ', $conditions) . $query2;
                            } else {
                                return $sql.=$query2;
                            }
                        }
                    }
                    $query = $_REQUEST['function_name']($_REQUEST);
                }
                
                
                $showRecordPerPage = 20;

                if (isset($_GET['page']) && !empty($_GET['page'])) {
                    $currentPage = $_GET['page'];
                } else {
                    $currentPage = 1;
                }
                $startFrom = ($currentPage * $showRecordPerPage) - $showRecordPerPage;
                $res = mysqli_query($GLOBALS['con'],$query) or die(mysqli_error($GLOBALS['con']));
                // $resu = mysqli_query($GLOBALS['con'],$query) or die(mysqli_error($GLOBALS['con']));
                // $resul = mysqli_query($GLOBALS['con'],$query) or die(mysqli_error($GLOBALS['con']));
                $resu=$res;
                $resul=$res;
                $count = mysqli_num_rows($res);
                $_SESSION['row_count'] = $count;
                if ($_REQUEST['pagename'] == "Articles" || $_REQUEST['pagename'] == "tax vista") {
                    $strings2 = "(";
                        while ($row = mysqli_fetch_array($res)) {
                            $strings2 = $strings2.$row['id'].",";
                        }
                    $strings2 = trim($strings2,",");
                    $strings2 = $strings2.")";
                    $_SESSION['article_search_id'] = $strings2;
                    //echo $test = $_SESSION['article_search_id'];
                } else{
                    $strings = "(";
                        while ($row = mysqli_fetch_array($res)) {
                            $strings = $strings.$row['data_id'].",";
                        }
                    $strings = trim($strings,",");
                    $strings = $strings.")";
                    $_SESSION['search_id'] = $strings;
                    //echo $test = $_SESSION['search_id'];
                }

                if ($_REQUEST['pagename'] == "CaseLaws") {
                    $string3 = "(";
                        while ($row2 = mysqli_fetch_array($resu)) {
                            $string3 = $string3.$row2['sub_prod_id'].",";
                        }
                    $string3 = trim($string3,",");
                    $string3 = $string3.")";
                    $_SESSION['sub_id'] = $string3;
                    //echo $test = $_SESSION['sub_id'];
                }
                $lastPage = ceil($count / $showRecordPerPage);
                $firstPage = 1;
                $nextPage = $currentPage + 1;
                $previousPage = $currentPage - 1;
                //$query . "LIMIT $startFrom, $showRecordPerPage";
                $res1 = mysqli_query($GLOBALS['con'],$query . " LIMIT $startFrom, $showRecordPerPage") or die(mysqli_error());
                $tocount = mysqli_num_rows($res1);
            ?>
            
            <?php
                $rec_count = $count;
                $rec_limit = 19;
                $from = $startFrom + 1;
                $to = $from + $tocount - 1;

                function getNewPageUrl($queryParam, $paramValue){
                    global $con;
                    $oldUrl = $_SERVER['REQUEST_URI'];
                    //removePageOption from existing url
                    $urlPrased = parse_url($oldUrl);
                    
                    parse_str($urlPrased['query'], $queries); 
                    $newParamArray = array();
                    foreach($queries as $q_param => $param_v){
                        if($q_param != $queryParam){
                            $newParamArray[$q_param] = $param_v;
                        }
                    }
                    $newParamArray[$queryParam] = $paramValue;
                    
                    //building url = 
                    $newUrl = $getBaseUrl . "/Advance_Search.php?";
                    
                    foreach($newParamArray as $q_p=>$p_v){
                        $newUrl .= "&".  $q_p . "=". $p_v;
                    }
                    
                    return $newUrl;
                }

                if (isLogeedIn()) {
                    if ($_SESSION["userStatus"] == "expired") {
                        include('expiredUserError.php');
                    } 
                    else {
                        if ($_SESSION["type"] != "T") {
                            if (mysqli_num_rows($res1) > 0) {
                                echo "<div class='new-pagination'>";
                                echo "<a ";
                                echo "href='#.' style='color:black;'>Showing $from to $to of <b>$rec_count Records</b></a>";
                                echo "</div><div class='clear'></div>";
                                ?>
                                    <nav class="navigation pagination pagination1 fontNeuron" role="navigation">
                                        <ul class="pagination">
                                            <li class="page-item active">
                                                <a class="page-link" href="<?php echo getNewPageUrl('page',$firstPage); ?>" tabindex="-1" aria-label="Previous">
                                                    <span aria-hidden="true">First</span>
                                                </a>        
                                            </li>
                                                   
                                    <?php
                                        if ($currentPage >= 2 && $previousPage != 1) {
                                    ?>
                                            <li class="page-item">
                                                    <a class="page-numbers" href="<?php echo getNewPageUrl('page',$previousPage); ?>" tabindex="-1" aria-label="Previous">
                                                        <span aria-hidden="true">Previous</span>
                                                    </a>
                                            </li>
                                    <?php
                                        }
                                    $c_page = $currentPage;
                                    for ($i = 1; $i <= 10; $i++) {

                                        if ($c_page <= $lastPage) {
                                            if ($c_page == 1) {
                                                $c_page++;
                                            } 
                                            else { ?>
                                            <li class="page-item <?php if ($c_page == $currentPage) {
                                                echo "active"; } ?>">
                                                <a class="page-numbers" href="<?php echo getNewPageUrl('page',$c_page); ?>"><?php echo $c_page++; ?></a>
                                            </li>
                                            <?php
                                            }
                                        }
                                    }
                                    ?>
                                    <?php
                                        if ($nextPage && $currentPage < $lastPage) {
                                    ?>
                                            <li class="page-item">
                                                    <a class="page-numbers" href="<?php echo getNewPageUrl('page',$nextPage); ?>" tabindex="-1" aria-label="Next">
                                                        <span aria-hidden="true">Next</span>
                                                    </a>
                                            </li>
                                    <?php
                                        }?>
                                            <li class="page-item">
                                                <a class="page-numbers" href="<?php echo getNewPageUrl('page',$lastPage); ?>" aria-label="Next">
                                                    <span aria-hidden="true">Last</span>
                                                </a>
                                            </li>   
                                        </ul>
                                    </nav>
                        <?php
                        echo "<div style='margin-bottom: 15px;'></div>";
                        if ($_REQUEST['pagename'] == "Articles" || $_REQUEST['pagename'] == "News") {
                            while ($row = mysqli_fetch_array($res1)) {
                                $encryptID = base64_encode(base64_encode($row['id']));
                                $file_path = $row['file_path'];
                                $linkToShow = $getBaseUrl . $file_path;
                                $rowtemp['perm_link'] = "showiframe?V1Zaa1VsQlJQVDA9=$encryptID&page=$dbsuffix";
                                $author = '';
                                if ($_REQUEST['pagename'] == 'Articles') {
                                    $author = ' | ' . $row['author'];
                                }
                                echo "<div class='widget-box'>
                                          <h4>
                                            <strong style='color: #ea0081;'>
                                                &nbsp; " . $row['subject'] . " &nbsp; <a class='preview' href='" . $getBaseUrl . $rowtemp['perm_link'] . "' perm-link='$linkToShow' title='Preview' ><i class='fa fa-eye'></i></a> &nbsp;<a class='new' href='" . $getBaseUrl . $rowtemp['perm_link'] . "' target='_blank' title='Open In New Tab'><i class='fa fa-share-square-o'></i></a> <span>" . $row['Date'] . "" . $author . "</span>
                                            </strong>
                                          </h4>
                                      <div class='widget-content'>";
                                $subject = cleanname(stripslashes($row['summary']));
                                $subjectLength = strlen(stripslashes($row['summary']));
                                if (!$text) {
                                    if ($subjectLength > 650) {
                                        echo "<p>" . substr($subject, 0, 650) . "... <a href='javascript:void(0)' style='text-decoration:underline;color: #ff7808;' class='readMoreSubject'>[Read more]</a></p>";
                                        echo "<p style='display:none'>" . $subject . "</p>";
                                    } else {
                                        echo "<p>" . $subject . "</p>";
                                    }
                                } else {
                                    if ($subjectLength > 650) {
                                        echo "<p>" . preg_replace("/($text)/i", "<mark>$1</mark>", substr($subject, 0, 650)) . "... <a href='javascript:void(0)' style='text-decoration:underline;color: #ff7808;' class='readMoreSubject'>[Read more]</a></p>";
                                        echo "<p style='display:none'>" . $subject . "</p>";
                                    } else {

                                        echo "<p>" . $subject . "</p>";
                                    }
                                }

                                echo "  <div class='widget-actions'><a href='javascript:void(0)' onclick='showFrame2(\"$encryptID\",\"$dbsuffix\")' class='ion-android-archive' title='Click here to download the file'></a></div>";
                                echo "  </div> 
                                  </div>";
                            }
                        } else if ($_REQUEST['pagename'] == "tax vista"){
                            while ($row = mysqli_fetch_array($res1)) {
                                $encryptID = base64_encode(base64_encode($row['id']));
                                $file_path = $row['file_path'];
                                $linkToShow = $getBaseUrl . $file_path;
                                $rowtemp['perm_link'] = "showiframe?V1Zaa1VsQlJQVDA9=$encryptID&page=$dbsuffix";
                                echo "<div class='widget-box'>
                                          <h4>
                                            <strong style='color: #ea0081;'>
                                                &nbsp; " . $row['subject'] . " &nbsp; <a class='preview' href='" . $getBaseUrl . $rowtemp['perm_link'] . "' perm-link='$linkToShow' title='Preview'><i class='fa fa-eye'></i></a> &nbsp;<a class='new' href='" . $getBaseUrl . $rowtemp['perm_link'] . "' target='_blank' title='Open In New Tab'><i class='fa fa-share-square-o'></i></a><span>" . $row['Date'] . "</span>
                                            </strong>
                                          </h4>
                                      <div class='widget-content'>";
                                $subject = cleanname(stripslashes($row['summary']));
                                $subjectLength = strlen(stripslashes($row['summary']));
                                if (!$text) {
                                    if ($subjectLength > 650) {
                                        echo "<p>" . substr($subject, 0, 650) . "... <a href='javascript:void(0)' style='text-decoration:underline;color: #ff7808;' class='readMoreSubject'>[Read more]</a></p>";
                                        echo "<p style='display:none'>" . $subject . "</p>";
                                    } else {
                                        echo "<p>" . $subject . "</p>";
                                    }
                                } else {
                                    if ($subjectLength > 650) {
                                        echo "<p>" . preg_replace("/($text)/i", "<mark>$1</mark>", substr($subject, 0, 650)) . "... <a href='javascript:void(0)' style='text-decoration:underline;color: #ff7808;' class='readMoreSubject'>[Read more]</a></p>";
                                        echo "<p style='display:none'>" . $subject . "</p>";
                                    } else {

                                        echo "<p>" . $subject . "</p>";
                                    }
                                }

                                echo "  <div class='widget-actions'><a href='javascript:void(0)' onclick='showFrame2(\"$encryptID\",\"$dbsuffix\")' class='ion-android-archive' title='Click here to download the file'></a></div>";
                                echo "  </div> 
                                  </div>";
                            }
                        } else {
                            while ($row = mysqli_fetch_array($res1)) {
                                $file_path = $row['file_path'];
                                $file_extn = strtolower(substr($file_path, -3));
                                $CatgoryClass = preg_replace('/\s+/', '', $row['prod_name']) . "section";
                                $encryptID = base64_encode(base64_encode($row['data_id']));
                                $dataType = $row['dbsuffix'];
                                $circular_no = $row['circular_no'] ? $row['circular_no'] : $row['cir_subject'];

                                echo "<div class='widget-box  $CatgoryClass'><h4>";
                                if (empty($file_path)) {
                                    echo getEmptyCircularLink2($encryptID, $dataType, $circular_no);            
                                } else {
                                    $link = "showiframe?V1Zaa1VsQlJQVDA9=$encryptID&datatable=$dataType";
                                    echo getCircularLink2($encryptID, $dataType, $circular_no, $file_path);
                                    echo "&nbsp;<strong style='color: #ea0081;'><a class='new' href='" . $link . "' target='_blank' title='Open In New Tab'><i class='fa fa-share-square-o'></i></a></strong>";
                                    //echo "<strong style='color: #ea0081;'><a class='new' href='" . $link . "' target='_blank' title='Open In New Tab'><img style='width: 10%;position: relative;bottom: 60px;left: 123%;' src='images/new_tab.png'></a></strong>";
                                }

                                echo "<span style='color:#ff7808'>{$row['sub_prod_name']} </span>   <span>&nbsp; | &nbsp;</span>";
                                echo "<span style='color:#58a9da'>{$row['prod_name']} </span>    ";
                                if (isset($row['State']) != '') {

                                    echo " <span>&nbsp; | &nbsp;</span><span>{$row['state_name']} </span>   ";
                                }
                                if ($_REQUEST['pagename'] == "Acts and Rules") {
                                    echo "<span> &nbsp;</span>";
                                } else {
                                    echo "<span>{$row['Date']} | &nbsp;</span>";
                                }
                                echo "</h4>";

                                if (!empty($row['party_name'])) {
                                    echo "<h4>";
                                    echo "<strong style='color:#cf4192; font-size: 13px;'>" . $row['party_name'] . "</strong>";
                                    echo "</h4>";
                                }

                                echo getDownloadIcon($encryptID, $dataType);
                                echo "<div class='clear'></div>";
                                $subject = cleanname($row['cir_subject']);
                                $subjectLength = strlen($row['cir_subject']);
                                if (!$text) {
                                    if ($subjectLength > 650) {
                                        echo "<p>" . substr($subject, 0, 650) . "... <a href='javascript:void(0)' style='text-decoration:underline;color: #ff7808;' class='readMoreSubject'>[Read more]</a></p>";
                                        echo "<p style='display:none'>" . $subject . "</p>";
                                    } else {
                                        echo "<p>" . $subject . "</p>";
                                    }
                                } else {
                                    if ($subjectLength > 650) {
                                        echo "<p>" . preg_replace("`($text)`i", "<mark>$1</mark>", substr($subject, 0, 650)) . "... <a href='javascript:void(0)' style='text-decoration:underline';color: #ff7808; class='readMoreSubject'>[Read more]</a></p>";
                                        echo "<p style='display:none'>" . $subject . "</p>";
                                    } else {

                                        echo "<p>" . $subject . "</p>";
                                    }
                                }
                                $isPDFLink =  "isPdf=0";
                                if ($file_extn == 'pdf') {    
                                    $isPDFLink =  "isPdf=1";
                                }
                                echo "</div>";
                            }
                        }
                        ?>
                        <nav class="navigation pagination pagination1 fontNeuron" role="navigation">
                            <ul class="pagination">
                                <li class="page-item active">
                                    <a class="page-link" href="<?php echo getNewPageUrl('page',$firstPage); ?>" tabindex="-1" aria-label="Previous">
                                        <span aria-hidden="true">First</span>
                                    </a>        
                                </li>
                        <?php
                        if ($currentPage >= 2 && $previousPage != 1) {
                            ?>
                                <li class="page-item">
                                    <a class="page-numbers" href="<?php echo getNewPageUrl('page',$previousPage); ?>"><?php echo $previousPage ?></a>
                                </li>
                            <?php
                        }
                        $c_page = $currentPage;
                        for ($i = 1; $i <= 10; $i++) {

                            if ($c_page <= $lastPage) {
                                if ($c_page == 1) {
                                    $c_page++;
                                } else {
                                    ?>
                                <li class="page-item <?php if ($c_page == $currentPage) {
                                echo "active";
                            } ?>">
                                    <a class="page-numbers" href="<?php echo getNewPageUrl('page',$c_page); ?>"><?php echo $c_page++; ?></a>
                                </li>
                                    <?php
                                }
                            }
                        }
                        ?>
                        <?php
                            if ($nextPage && $currentPage < $lastPage) {
                        ?>
                                <li class="page-item">
                                        <a class="page-numbers" href="<?php echo getNewPageUrl('page',$nextPage); ?>" tabindex="-1" aria-label="Next">
                                            <span aria-hidden="true">Next</span>
                                        </a>
                                </li>
                        <?php
                            }?>
                                <li class="page-item">
                                    <a class="page-numbers" href="<?php echo getNewPageUrl('page',$lastPage); ?>" aria-label="Next">
                                        <span aria-hidden="true">Last</span>
                                    </a>
                                </li>   
                            </ul>
                        </nav>

                        <?php
                    } else {
                        echo '<div class="alert alert-danger always-show" style="margin-top: 50px;" >
                                <h3> <strong>No Record Found</strong> - Please try again with different combination</h3>
                                <h4> <strong><b><a  href="AdvancedSearch.php" data-effect="mfp-zoom-in">Advance Search</a></b></strong> </h4>
                            </div>';

                            if ($_REQUEST['pagename'] == "CaseLaws") { ?>
                                <div class="alert alert-danger always-show">
                                    <h4>
                                        <strong style="color: #8d3400;">OR</strong>
                                        <p>Didn’t find what you are searching for? No worries, please give us the following details and VIL will email you the desired Caselaws at the earliest:</p>
                                        <p>Please Click Form Button</p>
                                        <strong><b><a href='#caselawForm' class='open-popup-link' data-effect="mfp-zoom-in" id='arrange'>Form</a></b></strong>
                                    </h4>
                                </div>
                    <?php   }
                    }
                } else {
                    include('tempUsererror.php');
                }
            }
        } else {
            include('loggedInError.php');
        }
        ?>
        </div>
        <?php 
        $isPDFLink = "isPdf=0";
        if ($file_extn == 'pdf') { 
            $isPDFLink =  "isPdf=1";
        }?>
        <div style="display: none;">
            <iframe onLoad="calcHeight();" <?php echo $isPDFLink ; ?>   id='iFramePopupFrame' name='iFramePopupFrame' <?php
                if ($file_extn == 'pdf') {
                    ?> src='<?php echo $getBaseUrl . $file_path; ?>' <?php
                } else {
                    ?> src='<?php echo "-?ll=" . encrypt_url($getBaseUrl . $file_path); ?>' <?php
                }
                ?> frameborder='0' allowtransparency='true' scrolling='no' width="100%" >
            </iframe>
        </div>
    </div>
</div>
</body>
<?php include('footer.php') ?>

<!-- Logout Modal-->
<div class="modal fade" id="recordInfoModal" tabindex="-1" role="dialog" aria-labelledby="recordInfoModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <a class="btn btn-primary btn_open_new_window" target="_blank" href="" >Open in New Window</a>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"> X </span>
                </button>
            </div>
            <div class="modal-body" style='height:600px;'>
                <iframe id="iFramePreviewFrame" name="iFramePreviewFrame" src="-?l=ocq1xJlgYZ%2BjmJejoKjJtYPVmp6ap6llZpyayqKDooB7Ypedl6esnsigs8CjppyXoZuWa2e%2BtcE%3D" frameborder="0" allowtransparency="false" scrolling="yes" width="100%"></iframe>
            </div>
            <div class="modal-footer d-block float-left">
                <div class="pull-right text-right b-margin-10">
                    <ul class="list-inline"></ul>
                </div>
            </div>
        </div>
    </div>
</div>

 <!-- Jquery JS-->
<!-- <script src="vendor/jquery/jquery.min.js"></script> -->
<!-- Vendor JS-->
<!-- <script src="vendor/select2/select2.min.js"></script>
<script src="vendor/jquery-validate/jquery.validate.min.js"></script>
<script src="vendor/bootstrap-wizard/bootstrap.min.js"></script>
<script src="vendor/bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>
<script src="vendor/datepicker/moment.min.js"></script>
<script src="vendor/datepicker/daterangepicker.js"></script> -->

<!-- Main JS-->
<!-- <script src="js/global.js"></script> -->

<!-- <script src="js/adv_js/jquery.min.js"></script> -->
<!-- <script src="js/adv_js/popper.js"></script> -->
<!-- <script src="js/adv_js/bootstrap.min.js"></script> -->
<script src="js/adv_js/main.js"></script>

<script type="text/javascript">
    function isNumberKey(evt)
    {
        //debugger;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode > 31
                && (charCode < 48 || charCode > 57))
            return false;

        return true;
    }

    function isAlfaKey(evt)
    {
        //debugger;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode > 31
                && (charCode < 96 || charCode > 123))
            return false;

        return true;
    }
</script>
<!-- <script type="text/javascript">
    document.form2.inex[0].checked=true;
    //var y = document.querySelector('input[name="inex"]:checked').value;
    // var value;
    // if (document.getElementById('inclu').checked) {
    //     value = document.getElementById('inclu').value;
    // } else {
    //     value = document.getElementById('exclu').value;
    // }
    // //console.log(y);
    // console.log(value);
    // if (value == "include") {
    //     $("#include").css("display", "block");
    //     $("#exclude").css("display", "none");
    // } else {
    //     $("#include").css("display", "none");
    //     $("#exclude").css("display", "block");
    // }
    
    var elements = document.getElementsByName('inex');
    var checkedButton;
    console.log(elements);
    elements.forEach(e => {
        if (e.checked) {
            //if radio button is checked, set sort style
            checkedButton = e.value;
        }
    });
    console.log(checkedButton);
    if (checkedButton == "include") {
        $("#include").css("display", "block");
        $("#exclude").css("display", "none");
    } else {
        $("#include").css("display", "none");
        $("#exclude").css("display", "block");
    }
</script> -->
<script>
    function reloadIt() {
        if (window.location.href.substr(-1) !== "&") {
            window.location = window.location.href + "&";
        }
    }

    setTimeout(() => {
        reloadIt()
    }, 500);

    // setTimeout('', 500)();
</script>
<script type="text/javascript">
    $(document).ready(function() {
        //for Notification
        // $("#product_id").change(function() {
            var val = $(this).val();
            var dbsuffix = $("#product_id").find('option:selected').attr('data-dbsuffix');
            $("#dbsuffix").val(dbsuffix);

            if (dbsuffix == '7') {
                $("#state").css("display", "block");
                $('#category_type').css("display", "block");
            } else {
                $("#state").css("display", "none");
            }
            if (dbsuffix != '0') {
                var table = 'casedata_' + dbsuffix;
            } else {
                $('#category_type').css("display", "none");
                return false;
            }

            if (dbsuffix == '1' || dbsuffix == '2' || dbsuffix == '4' || dbsuffix == '5' || dbsuffix == '6' || dbsuffix == '7' || dbsuffix == '8' || dbsuffix == '9' || dbsuffix == '10') {
                $.ajax({
                    data: {id: dbsuffix, table: table},
                    url: "adv_search_notification_type.php", //php page URL where we post this data to view from database
                    type: 'POST',
                    dataType: 'html',
                    success: function(data) {
                        //debugger;
                        //alert(data);
                        if (data != "no") {
                            $('#category_type').css("display", "block");
                            $("#sub_product_id").html(data);
                        } else {
                            $('#category_type').css("display", "none");
                        }
                    }
                });
                return false;
            }
            $('#category_type').css("display", "none");
        //});
        $("#sub_product_id").change(function() {
            var val = $("#product_id option:selected").val();
            var type = $(this).val();
            $('#not_type').find('option').remove();
            if (val == '7' || val == '8' || val == '9' || val == '10')
            {   
                //$("#notification_type").css('display', 'block');
                if (type == "Circular")
                {
                    $("#notification_type").css('display', 'none');
                    //$(".not_type_label").text('Circular Type');
                } else {
                    $("#notification_type").css('display', 'block');
                    $(".not_type_label").text('Notification Type');
                    $("#not_type").append('<option value="0">Select</option>' + '<option value="Notification">Notification</option>' +
                            '<option value="Rate Notification">Rate Notification</option>');
                }
            }

            if (val == '5')
            {
                $("#notification_type").css('display', 'block');
                if (type == "Notification")
                {
                    $(".not_type_label").text('Notification Type');
                    $("#not_type").append('<option value="0">Select</option>' + '<option value="Tariff">Tariff</option>' +
                            '<option value="Non-Tariff">Non-Tariff</option>' + '<option value="Safeguards">Safeguards</option>' +
                            '<option value="Anti Dumping Duty">Anti Dumping Duty</option>' +
                            '<option value="Others">Others</option>');
                }
                else
                {
                    $(".not_type_label").text('Circular Type');
                    $("#not_type").append('<option value="0">Select</option>' + '<option value="Circulars">Circulars</option>' +
                            '<option value="Instructions">Instructions</option>');
                }
            }

            if (val == '4')
            {
                $("#notification_type").css('display', 'block');
                if (type == "Notification")
                {
                    $(".not_type_label").text('Notification Type');
                    $("#not_type").append('<option value="0">Select</option>' + '<option value="Tariff">Tariff</option>' +
                            '<option value="Non-Tariff">Non-Tariff</option>');
                }
                else
                {
                    $(".not_type_label").text('Circular Type');
                    $("#not_type").append('<option value="0">Select</option>' + '<option value="Circulars">Circulars</option>' +
                            '<option value="Instructions">Instructions</option>');
                }
            }
        });
    });
</script>
<script>
    // for act and rule
    $("#type").change(function() {
        var value = $(this).val();
        if (value == "Acts") {
            $("#section_no").val("");
            $("#section").css("display", "block");
            $("#rule").css("display", "none");
            $("#notification").css("display", "none");
            $("#policy").css("display", "none");
            $("#policy_circular").css("display", "none");
            $("#procedure").css("display", "none");
            $("#public_notice").css("display", "none");
            $("#trade_notice").css("display", "none");
        } 
        else if (value == "Notification") {
            $("#notification").val("");
            $("#notification").css("display", "block");
            $("#section").css("display", "none");
            $("#rule").css("display", "none");
            $("#policy").css("display", "none");
            $("#policy_circular").css("display", "none");
            $("#procedure").css("display", "none");
            $("#public_notice").css("display", "none");
            $("#trade_notice").css("display", "none");
        }
        else if (value == "Policy") {
            $("#policy").val("");
            $("#policy").css("display", "block");
            $("#section").css("display", "none");
            $("#rule").css("display", "none");
            $("#notification").css("display", "none");
            $("#policy_circular").css("display", "none");
            $("#procedure").css("display", "none");
            $("#public_notice").css("display", "none");
            $("#trade_notice").css("display", "none");
        }
        else if (value == "Policy Circular") {
            $("#policy_circular").val("");
            $("#policy_circular").css("display", "block");
            $("#section").css("display", "none");
            $("#rule").css("display", "none");
            $("#notification").css("display", "none");
            $("#policy").css("display", "none");
            $("#procedure").css("display", "none");
            $("#public_notice").css("display", "none");
            $("#trade_notice").css("display", "none");
        }
        else if (value == "Procedure") {
            $("#procedure").val("");
            $("#procedure").css("display", "block");
            $("#section").css("display", "none");
            $("#rule").css("display", "none");
            $("#notification").css("display", "none");
            $("#policy").css("display", "none");
            $("#policy_circular").css("display", "none");
            $("#public_notice").css("display", "none");
            $("#trade_notice").css("display", "none");
        }
        else if (value == "Public Notice") {
            $("#public_notice").val("");
            $("#public_notice").css("display", "block");
            $("#section").css("display", "none");
            $("#rule").css("display", "none");
            $("#notification").css("display", "none");
            $("#policy").css("display", "none");
            $("#policy_circular").css("display", "none");
            $("#procedure").css("display", "none");
            $("#trade_notice").css("display", "none");
        }
        else if (value == "Trade Notice") {
            $("#trade_notice").val("");
            $("#trade_notice").css("display", "block");
            $("#section").css("display", "none");
            $("#rule").css("display", "none");
            $("#notification").css("display", "none");
            $("#policy").css("display", "none");
            $("#policy_circular").css("display", "none");
            $("#procedure").css("display", "none");
            $("#public_notice").css("display", "none");
        }
        else {
            $("#rule_no").val("");
            $("#rule").css("display", "block");
            $("#section").css("display", "none");
            $("#notification").css("display", "none");
            $("#policy").css("display", "none");
            $("#policy_circular").css("display", "none");
            $("#procedure").css("display", "none");
            $("#public_notice").css("display", "none");
            $("#trade_notice").css("display", "none");
        }
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        //debugger;
        var dbsuffix = $("#prod_id").find('option:selected').attr('data-dbsuffix');
        $("#dbsuffix").val(dbsuffix);

        //for case law
        $("#court").change(function() {
            var value = $(this).val();
            //var value = $("#court").find('option:selected').attr('data-dbsuffix');
            if (value == "HC") {
                $("#hc").css('display', 'block');
                $("#tri").css('display', 'none');
                $("#aar").css('display', 'none');
                $("#aaar").css('display', 'none');
            } else if (value == "TRI") {
                $("#hc").css('display', 'none');
                $("#tri").css('display', 'block');
                $("#aar").css('display', 'none');
                $("#aaar").css('display', 'none');
            } else if (value == "AAR") {
                $("#hc").css('display', 'none');
                $("#tri").css('display', 'none');
                $("#aar").css('display', 'block');
                $("#aaar").css('display', 'none');
            } else if (value == "AAAR") {
                $("#hc").css('display', 'none');
                $("#tri").css('display', 'none');
                $("#aar").css('display', 'none');
                $("#aaar").css('display', 'block');
            } else {
                $("#courtCityHC").val("0");
                $("#courtCityTRI").val("0");
                $("#courtCityAAR").val("0");
                $("#courtCityAAAR").val("0");
                $("#hc").css('display', 'none');
                $("#tri").css('display', 'none');
                $("#aar").css('display', 'none');
                $("#aaar").css('display', 'none');
            }
        });
    });
</script>