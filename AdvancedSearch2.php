<?php 
    include('header.php');
    $page = 'AdvancedSearch';
    $seoTitle = 'Advanced Search';
    $seoKeywords = 'Advanced Search';
    $seoDesc = 'Advanced Search';
    ini_set('display_errors',0);
?>
<?php

function getCatDropdown($value, $data) {
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

function getNotficationType($state_id, $selectValue) {

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

function getCategory($table, $value) {
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
?>
<!-- Icons font CSS-->
<link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
<link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
<!-- Font special for pages-->
<link href="https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

<!-- Vendor CSS-->
<link href="vendor/select2/select2.min.css" rel="stylesheet" media="all">
<link href="vendor/datepicker/daterangepicker.css" rel="stylesheet" media="all">

<!-- Main CSS-->
<link href="css/main_copy.css" rel="stylesheet" type="text/css" media="all">
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
<style type="text/css">
    <?php include 'css/main.css'; ?>
    .card-4 { background: rgb(32 23 23 / 0%); }
    .form { width: 100%; }
    .form2 { 
        width: 100%; 
    }
    .display { display: none; }
    .input--style-1 { font-size: 15px; padding: 8px 0; color: #666; font-family: inherit;border: 1px solid #ccc;}
    .tab-list__link { display: block; text-transform: uppercase; font-family: "Poppins", "Arial", "Helvetica Neue", sans-serif;
        font-weight: 400; font-size: 19px; color: rgba(128, 128, 128, 0.6); padding: 0 5px; }
        .wrapper--w900 { max-width: 1140px;  margin-left: 0px; }
        .tab-list { list-style: none; padding: 0 25px; padding-top: 40px; }
    .input-group .form-control { position: relative; z-index: 2; float: none; width: 100%; margin-bottom: 0; }
    .wrapper .search-party { position: relative; background: #fff; width: 100%; border-radius: 5px; box-shadow: 0px 1px 5px 3px rgb(0 0 0 / 12%); margin-bottom: 10px; }
    .search-party input { height: 55px; width: 100%; outline: none; border: none; border-radius: 5px; padding: 0 60px 0 20px;
        font-size: 18px; box-shadow: 0px 1px 5px rgb(0 0 0 / 10%); }
    .inf { font-size: 22px; background: #034f44; color: #c1e305; border-radius: 5px;}
    .infor { font-size: 22px; color: #034f44; }
</style>
<style>
    .tool {position: relative; display: inline-block; }
    .tool .tooltiptext {visibility: hidden; width: 370px; background-color: black; color: #fff; text-align: center;border-radius: 6px; padding: 8px 0;/* Position the tooltip */position: absolute; z-index: 1;}
    .tool:hover .tooltiptext {visibility: visible; }
    .tool .tooltiptext2 { visibility: hidden; width: 200px; background-color: black; color: #fff; text-align: center; z-index: 99999;
        border-radius: 6px; padding: 8px 0; /* Position the tooltip */ position: absolute; z-index: 999; }
    .tool:hover .tooltiptext2 { visibility: visible;  }
</style>
<style>
    .tab-list {
        display: flex;
        list-style: none;
        padding: 20px;
        background: linear-gradient(to bottom, #00789e 0%,#00548a 100%);
        justify-content: center;
    }
    .tab-list::after {
        content: "";
        clear: both;
        display: table;
    }
    @media (max-width: 767px) {
        .tab-list {
            padding: 10px;
            display: flex;
            flex-direction: column;
        }
        .tab-list__link {
            font-size: 22px;
        }
        .tab-list__item {
            padding: 5px;
        }
    }

    .tab-list__item {
        float: none;
    }
    .tab-list__link:hover {
        color: #dbad14;
    }
    .tab-list__item {
        /* float: left; */
        display: inline-flex;
        flex-direction: row;
        justify-content: center;
    }
    .tab-list__link {
        display: block;
        text-transform: uppercase
        font-weight: normal;
        font-size: large;
        color: #fff;
        padding: 0 20px;
    }
    .tab-list .active .tab-list__link {
        color: #00548a;
        background-color:#dbad14
    }
    .tab-pane {
        border: solid;
        border-color: #00548a;
    }

    .table-container .form label {
        float: left;
        clear: left;
        margin: 7px 5% 0 0;
        text-align: right;
        width: 30%;
    }
    .input-group {
        position: relative;
        -webkit-border-radius: 10px;
        -moz-border-radius: 10px;
        border-radius: 10px;
        -webkit-box-align: center;
        -webkit-align-items: center;
        -moz-box-align: center;
        -ms-flex-align: center;
        align-items: center;
    }
    .display {
        display: none;
    }
    .input-group-big {
        padding: 7px 10px;
    }
    .label {
        font-size: 13px;
        color: #333;
        text-transform: capitalize;
        display: flex;
        align-items: center;
        font-weight: 500;
        white-space: nowrap;
        position: relative;
        text-align: left;
        margin-right: 11vw;
    }
    .label label{
        position: absolute;
        margin-inline-end: 9vw;
    }
    .btn-submit {
        display: block;
        width: 100%;
        line-height: 50px;
        font-family: inherit;
        background: #00548a;
        -webkit-border-radius: 10px;
        -moz-border-radius: 10px;
        border-radius: 10px;
        text-transform: uppercase;
        color: #fff;
        font-size: 18px;
        font-weight: 700;
        -webkit-transition: all 0.4s ease;
        -o-transition: all 0.4s ease;
        -moz-transition: all 0.4s ease;
        transition: all 0.4s ease;
    }

    .btn-submit:hover {
        background: #dbad14;
    }


</style>
<?php 
// if (isLogeedIn()) { 
    ?>
    <div class="page-wrapper col-md-16">
        <div class="wrapper--w900">
               
                <div class="card-body">
                    
                    <ul class="tab-list ">
                        <li class="tab-list__item active">
                            <a class="tab-list__link" href="#tab1" data-toggle="tab">
                            CaseLaws
                            </a>
                        </li>
                        <li class="tab-list__item">
                            <a class="tab-list__link" href="#tab2" data-toggle="tab">
                                Acts/ Rules
                            </a>
                        </li>
                        <li class="tab-list__item">
                            <a class="tab-list__link" href="#tab3" data-toggle="tab">
                            Notifications
                            </a>
                        </li>
                        <!-- <li class="tab-list__item">
                            <a class="tab-list__link" href="#tab4" data-toggle="tab">Forms</a>
                        </li> -->
                        <li class="tab-list__item">
                            <a class="tab-list__link" href="#tab5" data-toggle="tab">
                            Articles
                            </a>
                        </li>
                        <li class="tab-list__item">
                            <a class="tab-list__link" href="#tab6" data-toggle="tab">
                            Tax Vista
                            </a>
                        </li>
                    </ul>
                    <div class="card card-4">
                    
                    <button style="float: right; position: relative; top: 15px; right: 10px; bottom: 15px; "><a href="AdvancedSearch.php" class="btn btn-primary">Refresh</a></button>
                    <div class="btn btn-primary tool" style="background: #ff7808; float: left; position: relative;top: 15px;left: 10px; bottom: 15px;">
                        <a style="color: white;" href="#caselawForm" class="open-popup-link" data-effect="mfp-zoom-in">
                            &nbsp;&nbsp;CRF&nbsp;&nbsp;
                        </a>
                        <span class="tooltiptext">Didn’t find desired Caselaws? Please submit CRF.</span>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab1">
                            <form name="form2" id="form2" action="Advance_Search.php" method="GET" class="form padding-b-15">
                                <input type="hidden" name="pagename" value="CaseLaws">
                                <input type="hidden" name="function_name" value="case_data">
                                <input type="hidden" id="dbsuffix" name="dbsuffix" value="0">
                              
                                <div class="input-group input-group-big">
                                    <div class="label"><label>Keyword:</label></div>
                                    
                                    <input type="text" class="form-control" id="keyword" name="keyword" value="<?php if (isset($_REQUEST['keyword']) && !empty($_REQUEST['keyword'])) { echo $_REQUEST['keyword']; }?>" placeholder="Keyword"/>
                                    <div class = "form2">
                                        <div class="col-md-2" >
                                            <label class="label" style="color: #00548a;">Exact:</label>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="radio" class="form-control" id="exactSearch" <?php if(($_REQUEST['exact_search']=='exact') || ($_REQUEST['exact_search']=='')) { ?> checked    <?php } ?> name="exact_search" value="exact" style="height:20px;border:0px;margin-top:2px;box-shadow: 0 0 0 0;">
                                        </div>
                                        <div class="col-md-2 tool">
                                            <i class="fa fa-info-circle infor"></i>
                                            <span class="tooltiptext2">Search for exact Word or Phrase. Try with texts most likely to be present in Caselaw. You can search-in-search in next step.</span>
                                        </div>
                                        <div class="col-md-2" >
                                            <label class="label" style="color: #00548a;">Like:</label>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="radio" class="form-control" id="exactSearch" <?php if($_REQUEST['exact_search']=='like') { ?> checked <?php } ?> name="exact_search" value="like" style="height:20px;border:0px;margin-top:2px;box-shadow: 0 0 0 0;">
                                        </div>
                                        <div class="col-md-2 tool">
                                            <i class="fa fa-info-circle infor"></i>
                                            <span class="tooltiptext2">Search for multiple Words or Phrase in same Caselaw seprating them by comma e.g. Credit Note, Supplementary invoice. You can search-in-search in next step.</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group input-group-big">
                                    <div class="label"><label>Party Name:</label></div>
                                    
                                    <div class="form-control" style>
                                        <input type="text"  style="text-transform:uppercase;" onkeyup="javascript:load_data(this.value)" onfocus="javascript:load_search_history()" onblur="javascript:lose_focus()" id="party_name" placeholder="Type to Search" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" name="party_name" value="<?php if (isset($_REQUEST['party_name']) && (!empty($_REQUEST['party_name']))) { echo $_REQUEST['party_name']; } ?>" />
                                        <div id="search_result"></div>
                                    </div>                                    
                                </div>
                            <!--                                 
                                <div class="input-group input-group-big">
                                    <label class="label">Search In:</label>
                                    <select name="search_in" id="search_in" class="form-control">
                                        <option value="0" <?php if (isset($_REQUEST['search_in']) && ($_REQUEST['search_in'] == "0")) { echo "selected=selected"; } ?> data-dbsuffix="0">Select </option>   
                                        <option value="1" <?php if (isset($_REQUEST['search_in']) && ($_REQUEST['search_in'] == "1")) { echo "selected=selected"; } ?> data-dbsuffix="0">Headnote </option>
                                        <option value="2" <?php if (isset($_REQUEST['search_in']) && ($_REQUEST['search_in'] == "2")) { echo "selected=selected"; } ?>data-dbsuffix="0">Case Text</option>
                                    </select>
                                </div> -->
                                
                                <div class="input-group input-group-big">
                                    <!-- <label class="label"></label> -->
                                    <div class="label"><label>Search In:</label></div>
                                    <select name="search_in" id="search_in" class="form-control">
                                        <option value="0" <?php if (isset($_REQUEST['search_in']) && ($_REQUEST['search_in'] == "0")) { echo "selected=selected"; } ?> data-dbsuffix="0">Select </option>   
                                        <option value="1" <?php if (isset($_REQUEST['search_in']) && ($_REQUEST['search_in'] == "1")) { echo "selected=selected"; } ?> data-dbsuffix="0">Headnote </option>
                                        <option value="2" <?php if (isset($_REQUEST['search_in']) && ($_REQUEST['search_in'] == "2")) { echo "selected=selected"; } ?>data-dbsuffix="0">Case Text</option>
                                    </select>

                                    <div class="label" ><label>Category:</label></div>
                                    <select name="prod_id" id="prod_id" class="form-control">
                                        <option value="0" <?php if (isset($_REQUEST['prod_id']) && ($_REQUEST['prod_id'] == "0")) { echo "selected=selected"; } ?> data-dbsuffix="0">Select</option>
                                        <option value="7" <?php if (isset($_REQUEST['prod_id']) && ($_REQUEST['prod_id'] == "7")) { echo "selected=selected"; } ?> data-dbsuffix="0">GST</option>
                                        <option value="1" <?php if (isset($_REQUEST['prod_id']) && ($_REQUEST['prod_id'] == "1")) { echo "selected=selected"; } ?> data-dbsuffix="0">VAT/Sales Tax</option>
                                        <option value="4" <?php if (isset($_REQUEST['prod_id']) && ($_REQUEST['prod_id'] == "4")) { echo "selected=selected"; } ?> data-dbsuffix="0">Central Excise</option>
                                        <option value="2" <?php if (isset($_REQUEST['prod_id']) && ($_REQUEST['prod_id'] == "2")) { echo "selected=selected"; } ?> data-dbsuffix="0">Service Tax</option>
                                        <option value="5" <?php if (isset($_REQUEST['prod_id']) && ($_REQUEST['prod_id'] == "5")) { echo "selected=selected"; } ?> data-dbsuffix="0">Customs</option>
                                    </select>

                                    <div class="label"><label>Court/Forum:</label></div>
                                    <select id='court' name='court' class="form-control">
                                        <option value="0" <?php if (isset($_REQUEST['court']) && ($_REQUEST['court'] == "0")) { echo "selected=selected"; } ?>data-dbsuffix="0">Select</option>
                                        <option value="SC" <?php if (isset($_REQUEST['court']) && ($_REQUEST['court'] == "SC")) { echo "selected=selected"; } ?>data-dbsuffix="0">Supreme Court</option>
                                        <option value="HC" <?php if (isset($_REQUEST['court']) && ($_REQUEST['court'] == "HC")) { echo "selected=selected"; } ?>data-dbsuffix="0">High Court</option>
                                        <option value="TRI" <?php if (isset($_REQUEST['court']) && ($_REQUEST['court'] == "TRI")) { echo "selected=selected"; } ?>data-dbsuffix="0">CESTAT Cases</option>
                                        <option value="AAR" <?php if (isset($_REQUEST['court']) && ($_REQUEST['court'] == "AAR")) { echo "selected=selected"; } ?>data-dbsuffix="0">AAR</option>
                                        <option value="NAA" <?php if (isset($_REQUEST['court']) && ($_REQUEST['court'] == "NAA")) { echo "selected=selected"; } ?>data-dbsuffix="0">NAA</option>
                                        <option value="AAAR" <?php if (isset($_REQUEST['court']) && ($_REQUEST['court'] == "AAAR")) { echo "selected=selected"; } ?>data-dbsuffix="0">AAAR</option>
                                    </select>
                                </div>
                                
                                <div class="input-group input-group-big display" id='hc'>
                                    <div class="label"><label>Bench/City:</label></div>
                                    <select id='courtCityHC' name='courtCity' style="/* width: 82%;position: relative;bottom: 15px;left: 150px;*/" class="form-control" >
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
                                <div class="input-group input-group-big display" id='tri'>
                                    <div class="label"><label>Bench/City:</label></div>
                                    <select id='courtCityTRI' name='courtCity1' class="form-control" >
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
                                <div class="input-group input-group-big display" id='aar'>
                                    <div class="label"><label>Bench/City:</label></div>
                                    <select id='courtCityAAR' name='courtCityAAR'class="form-control" >
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
                                <div class="input-group input-group-big display" id='aaar'>
                                    <div class="label"><label>Bench/City:</label></div>
                                    <select id='courtCityAAAR' name='courtCityAAAR' class="form-control" >
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
                                <div class="input-group input-group-big">
                                    <div class="label"><label>CGST Section No.:</label></div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="cgst_section" placeholder="" name="cgst_section" value="<?php if (isset($_REQUEST['cgst_section']) && (!empty($_REQUEST['cgst_section']))) { echo $_REQUEST['cgst_section']; } ?>" onkeypress="return isNumberKey(event)" />
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" class="form-control" id="cgst_section" placeholder="" name="cgst_section1" value="<?php if (isset($_REQUEST['cgst_section1']) && (!empty($_REQUEST['cgst_section1']))) { echo $_REQUEST['cgst_section1']; } ?>" />
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" class="form-control" id="cgst_section2" placeholder="" name="cgst_section2" value="<?php if (isset($_REQUEST['cgst_section2']) && (!empty($_REQUEST['cgst_section2']))) { echo $_REQUEST['cgst_section2']; } ?>" />
                                    </div>
                                    <div class="col-md-4">
                                        <p class="text"> (only for GST Caselaws)</p>
                                    </div>
                                    <div class="tool">
                                        <i class="fa fa-info-circle infor"></i>
                                        <span class="tooltiptext2">Search for GST Caselaws by CGST Section. Selection of sub-sec./clause is optional.</span>
                                    </div>
                                </div>
                                <div class="input-group input-group-big">
                                    <div class="label"><label>CGST Rule No.:</label></div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="cgst_rule" placeholder="" name="cgst_rule" value="<?php if (isset($_REQUEST['cgst_rule']) && (!empty($_REQUEST['cgst_rule']))) { echo $_REQUEST['cgst_rule']; } ?>" onkeypress="return isNumberKey(event)" />
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" class="form-control" id="cgst_rule1" placeholder="" name="cgst_rule1" value="<?php if (isset($_REQUEST['cgst_rule1']) && (!empty($_REQUEST['cgst_rule1']))) { echo $_REQUEST['cgst_rule1']; } ?>" />
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" class="form-control" id="cgst_rule2" placeholder="" name="cgst_rule2" value="<?php if (isset($_REQUEST['cgst_rule2']) && (!empty($_REQUEST['cgst_rule2']))) { echo $_REQUEST['cgst_rule2']; } ?>" />
                                    </div>
                                    <div class="col-md-4">
                                        <p class="text"> (only for GST Caselaws)</p>
                                    </div>
                                    <div class="tool">
                                        <i class="fa fa-info-circle infor"></i>
                                        <span class="tooltiptext2">Search for GST Caselaws by CGST Rule. Selection of sub-rule/clause is optional.</span>
                                    </div>
                                </div>
                                <div class="input-group input-group-big">
                                    <div class="label"><label>IGST Section No.:</label></div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="igst_section" placeholder="" name="igst_section" value="<?php if (isset($_REQUEST['igst_section']) && (!empty($_REQUEST['igst_section']))) { echo $_REQUEST['igst_section']; } ?>" onkeypress="return isNumberKey(event)" />
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" class="form-control" id="igst_section" placeholder="" name="igst_section1" value="<?php if (isset($_REQUEST['igst_section1']) && (!empty($_REQUEST['igst_section1']))) { echo $_REQUEST['igst_section1']; } ?>" />
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" class="form-control" id="igst_section2" placeholder="" name="igst_section2" value="<?php if (isset($_REQUEST['igst_section2']) && (!empty($_REQUEST['igst_section2']))) { echo $_REQUEST['igst_section2']; } ?>" />
                                    </div>
                                    <div class="col-md-4">
                                        <p class="text"> (only for GST Caselaws)</p>
                                    </div>
                                    <div class="tool">
                                        <i class="fa fa-info-circle infor"></i>
                                        <span class="tooltiptext2">Search for GST Caselaws by IGST Section. Selection of sub-sec./clause is optional.</span>
                                    </div>
                                </div>
                                <div class="input-group input-group-big">
                                    <div class="label"><label>IGST Rule No.:</label></div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="igst_rule" placeholder="" name="igst_rule" value="<?php if (isset($_REQUEST['igst_rule']) && (!empty($_REQUEST['igst_rule']))) {  echo $_REQUEST['igst_rule']; } ?>" onkeypress="return isNumberKey(event)"/>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" class="form-control" id="igst_rule1" placeholder="" name="igst_rule1" value="<?php if (isset($_REQUEST['igst_rule1']) && (!empty($_REQUEST['igst_rule1']))) { echo $_REQUEST['igst_rule1']; } ?>" />
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" class="form-control" id="igst_rule2" placeholder="" name="igst_rule2" value="<?php if (isset($_REQUEST['igst_rule2']) && (!empty($_REQUEST['igst_rule2']))) { echo $_REQUEST['igst_rule2']; } ?>" />
                                    </div>
                                    <div class="col-md-4">
                                        <p class="text"> (only for GST Caselaws)</p>
                                    </div>
                                    <div class="tool">
                                        <i class="fa fa-info-circle infor"></i>
                                        <span class="tooltiptext2">Search for GST Caselaws by IGST Rule. Selection of sub-rule/clause is optional.</span>
                                    </div>
                                </div> 
                                
                                <div class="input-group input-group-big">
                                    <div class="label"><label>Judge Name:</label></div>
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
                                
                                <div class="input-group input-group-big" style="width: 100%">
                                    <div class="label"><label>VIL Citation:</label></div>
                                    <div class="col-md-4">
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
                                    <div class="col-md-1 text-center">
                                        <div class="label"><label>VIL</label></div>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" id="vol" placeholder="Volumn" name="vol" value="<?php if (isset($_REQUEST['vol']) && (!empty($_REQUEST['vol']))) { echo $_REQUEST['vol']; } ?>" onkeypress="return isNumberKey(event)"/>
                                    </div>
                                    <div class="col-md-1 text-center"> - </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" id="Citation" placeholder="" name="Citation" value="<?php if (isset($_REQUEST['Citation']) && (!empty($_REQUEST['Citation']))) { echo $_REQUEST['Citation']; } ?>" />
                                    </div>
                                </div>
                                <div style="display: flex; font-size: 13px;padding: 7px 10px;gap: 10em;">
                                    <div style="margin-bottom: 10px;display: inline-flex;align-items: center;padding: 0.2em 0.6em 0.3em;">
                                        <label style="margin-right: 2vw;">Date:</label>
                                        <input style="border: 1px solid #ccc; padding: 5px; font-size: 13px;" type="date" id="date" name="date" value="<?php if (isset($_REQUEST['date']) && (!empty($_REQUEST['date']))) { echo $_REQUEST['date']; } ?>" />
                                    </div>

                                    <div style="display: flex; align-items: center; margin-bottom: 10px;padding: 0.2em 0.6em 0.3em;">
                                        <label style="width: 100%;">Date Range:</label>
                                        <input style="border: 1px solid #ccc; padding: 5px; margin-right: 10px; font-size: 13px;" type="date" id="dt_from" name="dt_from" value="<?php if (isset($_REQUEST['dt_from']) && (!empty($_REQUEST['dt_from']))) { echo $_REQUEST['dt_from']; } ?>" />
                                        <label>To:</label>
                                        <input style="border: 1px solid #ccc; padding: 5px; font-size: 13px; margin-left: 5px;" type="date" id="dt_to" name="dt_to" value="<?php if (isset($_REQUEST['dt_to']) && (!empty($_REQUEST['dt_to']))) { echo $_REQUEST['dt_to']; } ?>" />
                                    </div>

                                </div>                            
                                <input type="submit" name="searchButton" id="searchButton" value="Search" class="btn-submit m-t-35"/>
                            </form>
                        </div>
                        <div class="tab-pane" id="tab2">
                            <form name="form2" id="form2" action="Advance_Search.php" method="GET" class="form padding-b-15">
                                <input type="hidden" name="pagename" value="Acts and Rules">
                                <input type="hidden" name="function_name" value="act">
                                <input type="hidden" id="dbsuffix" name="dbsuffix" value="<?php if (isset($_REQUEST['dbsuffix']) && (!empty($_REQUEST['dbsuffix']))) { echo $_REQUEST['dbsuffix']; } else { echo ""; }
                                ?>cgst">

                                <!-- <div class="wrapper">
                                    <div class="search-input">
                                        <input type="text" id="keyword" name="keyword" value="<?php //if (isset($_REQUEST['keyword']) && !empty($_REQUEST['keyword'])) { echo $_REQUEST['keyword']; }?>" placeholder="Type To Search in Keyword....">
                                        <div class="autocom-box">
                                            <li>Login Form In Html & Css</li>
                                            <li>Login Form In Html & Css</li>
                                            <li>Login Form In Html & Css</li>
                                            <li>Login Form In Html & Css</li>
                                            <li>Login Form In Html & Css</li>
                                        </div> -->
                                        <!-- <div class="icon">
                                            <i class="fa fa-search"></i>
                                        </div> -->
                                    <!-- </div>
                                </div> -->
                                <div class="input-group input-group-big">
                                    <div class="label"><label>Keyword:</label></div>
                                    <input type="text" class="form-control" id="keyword" name="keyword" value="<?php if (isset($_REQUEST['keyword']) && !empty($_REQUEST['keyword'])) { echo $_REQUEST['keyword']; }?>" placeholder="Keyword"/>
                                                    
                                    <div class="form2">
                                        <div class="col-md-2">
                                            <label class="label" style="color: #00548a;">Exact:</label>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="radio" class="form-control" id="exactSearch" <?php if(($_REQUEST['exact_search']=='exact' ) ||
                                                ($_REQUEST['exact_search']=='' )) { ?> checked
                                            <?php } ?> name="exact_search" value="exact" style="height:20px;border:0px;margin-top:2px;box-shadow: 0 0 0 0;">
                                        </div>
                                        <div class="col-md-2 tool">
                                            <i class="fa fa-info-circle infor"></i>
                                            <span class="tooltiptext2">Search for exact Word or Phrase. Try with texts most likely to be present in Caselaw.
                                                You can search-in-search in next step.</span>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="label" style="color: #00548a;">Like:</label>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="radio" class="form-control" id="exactSearch" <?php if($_REQUEST['exact_search']=='like' ) { ?>
                                            checked
                                            <?php } ?> name="exact_search" value="like" style="height:20px;border:0px;margin-top:2px;box-shadow: 0 0 0 0;">
                                        </div>
                                        <div class="col-md-2 tool">
                                            <i class="fa fa-info-circle infor"></i>
                                            <span class="tooltiptext2">Search for multiple Words or Phrase in same Caselaw seprating them by comma e.g.
                                                Credit Note, Supplementary invoice. You can search-in-search in next step.</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="col-md-16 form2">
                                    <div class="col-md-1">
                                         <label class="label" style="color: white;">Exact:</label>
                                     </div>
                                     <div class="col-md-3">
                                        <input type="radio" class="form-control" id="exactSearch" <?php if(($_REQUEST['exact_search']=='exact') || ($_REQUEST['exact_search']=='')) { ?> checked    <?php } ?> name="exact_search" value="exact" style="height:20px;border:0px;margin-top:-1px;box-shadow: 0 0 0 0;">
                                    </div>
                                    <div class="col-md-1">
                                        <label class="label" style="color: white;">Like:</label>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="radio" class="form-control" id="exactSearch" <?php if($_REQUEST['exact_search']=='like') { ?> checked <?php } ?> name="exact_search" value="like" style="height:20px;border:0px;margin-top:-1px;box-shadow: 0 0 0 0;">
                                    </div>
                                </div> -->
                                <div class="input-group input-group-big">
                                    <!-- <label class="label">Section No.:</label> -->
                                    <div class="label"><label>Section No.:</label></div>
                                    <input type="number" class="form-control" name="sect" value="<?php if (isset($_REQUEST['sect']) && !empty($_REQUEST['sect'])) { echo $_REQUEST['sect']; } ?>" placeholder="Section No." />
                                </div>
                                <div class="input-group input-group-big">
                                    <!-- <label class="label">Search Type:</label> -->
                                    <div class="label"><label>Search Type:</label></div>
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
                                    <!-- <label class="label">Category:</label> -->
                                    <div class="label"><label>Category:</label></div>
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
                                <div class="input-group input-group-big display" id="section">
                                    <!-- <label class="label" style="width: 0px; position: relative; top: 15px;">Section No.:</label> -->
                                    <div class="label"><label>Section No.:</label></div>
                                    <input type="text" class="form-control" id="section_no" name="section_no" value="<?php if (isset($_REQUEST['section_no']) && !empty($_REQUEST['section_no'])) { echo $_REQUEST['section_no']; } ?>" placeholder="Section No." />
                                </div>
                                <div class="input-group input-group-big display" id="rule">
                                    <!-- <label class="label" style="width: 0px; position: relative; top: 15px;">Rule No.:</label> -->
                                    <div class="label"><label>Rule No.:</label></div>
                                    <input type="text" class="form-control" id="rule_no" name="rule_no" value="<?php if (isset($_REQUEST['rule_no']) && !empty($_REQUEST['rule_no'])) { echo $_REQUEST['rule_no']; } ?>" placeholder="Rule No." />
                                </div>
                                <!-- <div class="input-group input-group-big display" id="notification">
                                    <label class="label" style="width: 0px; position: relative; top: 15px;">Notification:</label>
                                    <input  type="text" class="form-control" id="notification" name="notification" value="<?php if (isset($_REQUEST['notification']) && !empty($_REQUEST['notification'])) { echo $_REQUEST['notification']; } ?>" placeholder="Notification" />
                                </div> -->
                                <div class="input-group input-group-big display" id="policy">
                                    <!-- <label class="label" style="width: 0px; position: relative; top: 15px;">Policy:</label> -->
                                    <div class="label"><label>Policy:</label></div>
                                    <input type="text" class="form-control" id="policy" name="policy" value="<?php if (isset($_REQUEST['policy']) && !empty($_REQUEST['policy'])) { echo $_REQUEST['policy']; } ?>" placeholder="Policy" />
                                </div>
                                <div class="input-group input-group-big display" id="policy_circular">
                                    <!-- <label class="label" style="width: 0px; position: relative; top: 15px;">Policy Circular:</label> -->
                                    <div class="label"><label>Policy Circular:</label></div>
                                    <input type="text" class="form-control" id="policy_circular" name="policy_circular" value="<?php if (isset($_REQUEST['policy_circular']) && !empty($_REQUEST['policy_circular'])) { echo $_REQUEST['policy_circular']; } ?>" placeholder="Policy Circular" />
                                </div>
                                <div class="input-group input-group-big display" id="procedure">
                                    <!-- <label class="label" style="width: 0px; position: relative; top: 15px;">Procedure:</label> -->
                                    <div class="label"><label>Procedure:</label></div>
                                    <input type="text" class="form-control" id="procedure" name="procedure" value="<?php if (isset($_REQUEST['procedure']) && !empty($_REQUEST['procedure'])) { echo $_REQUEST['procedure']; } ?>" placeholder="Procedure" />
                                </div>
                                <div class="input-group input-group-big display" id="public_notice">
                                    <!-- <label class="label" style="width: 0px; position: relative; top: 15px;">Public Notice:</label> -->
                                    <div class="label"><label>Public Notice:</label></div>
                                    <input type="text" class="form-control" id="public_notice" name="public_notice" value="<?php if (isset($_REQUEST['public_notice']) && !empty($_REQUEST['public_notice'])) { echo $_REQUEST['public_notice']; } ?>" placeholder="Public Notice" />
                                </div>
                                <div class="input-group input-group-big display" id="trade_notice">
                                    <!-- <label class="label" style="width: 0px; position: relative; top: 15px;">Trade Notice:</label> -->
                                    <div class="label"><label>Trade Notice:</label></div>
                                    <input type="text" class="form-control" id="trade_notice" name="trade_notice" value="<?php if (isset($_REQUEST['trade_notice']) && !empty($_REQUEST['trade_notice'])) { echo $_REQUEST['trade_notice']; } ?>" placeholder="Trade Notice" />
                                </div>
                                <input type="submit" name="searchButton" id="searchButton" value="Search" class="btn-submit m-t-35"/>
                            </form>
                        </div>
                        <div class="tab-pane" id="tab3">
                            <form name="form2" id="form2" action="Advance_Search.php" method="GET" class="form padding-b-15">
                                <input type="hidden" id="sel_type" name="sel_type" value="<?php if (isset($_REQUEST['type'])) {  echo $_REQUEST['type']; } ?>">
                                <input type="hidden" id="cat_type" name="cat_type" value="<?php if (isset($_REQUEST['sub_product_id'])) { echo $_REQUEST['sub_product_id']; } ?>">
                                <input type="hidden" id="st_id" name="st_id" value="<?php if (isset($_REQUEST['state_id'])) {  echo $_REQUEST['state_id']; } ?>">
                                <input type="hidden" name="pagename" value="Notification">
                                <input type="hidden" name="function_name" value="notification">
                                <input type="hidden" id="dbsuffix" name="dbsuffix" value="0">

                                <!-- for Keyword -->
                                <!-- <div class="wrapper">
                                    <div class="search-input">
                                        <input type="text" id="keyword" name="keyword" value="<?php //if (isset($_REQUEST['keyword']) && !empty($_REQUEST['keyword'])) { echo $_REQUEST['keyword']; }?>" placeholder="Type To Search in Keyword....">
                                        <div class="autocom-box">
                                            <li>Login Form In Html & Css</li>
                                            <li>Login Form In Html & Css</li>
                                            <li>Login Form In Html & Css</li>
                                            <li>Login Form In Html & Css</li>
                                            <li>Login Form In Html & Css</li>
                                        </div> -->
                                        <!-- <div class="icon">
                                            <i class="fa fa-search"></i>
                                        </div> -->
                                    <!-- </div>
                                </div> -->
                                <div class="input-group input-group-big display">
                                    <!-- <label class="label">Keyword:</label> -->
                                    <div class="label"><label>Keyword:</label></div>
                                    <input type="text" class="form-control" id="keyword" placeholder="Keyword" name="keyword" value="<?php if (isset($_REQUEST['keyword']) && (!empty($_REQUEST['keyword']))) { echo $_REQUEST['keyword']; } ?>" />
                                    <div class="form2">
                                        <div class="col-md-2">
                                            <label class="label" style="color: #00548a;">Exact:</label>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="radio" class="form-control" id="exactSearch" <?php if(($_REQUEST['exact_search']=='exact' ) ||
                                                ($_REQUEST['exact_search']=='' )) { ?> checked
                                            <?php } ?> name="exact_search" value="exact" style="height:20px;border:0px;margin-top:2px;box-shadow: 0 0 0 0;">
                                        </div>
                                        <div class="col-md-2 tool">
                                            <i class="fa fa-info-circle infor"></i>
                                            <span class="tooltiptext2">Search for exact Word or Phrase. Try with texts most likely to be present in Caselaw.
                                                You can search-in-search in next step.</span>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="label" style="color: #00548a;">Like:</label>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="radio" class="form-control" id="exactSearch" <?php if($_REQUEST['exact_search']=='like' ) { ?>
                                            checked
                                            <?php } ?> name="exact_search" value="like" style="height:20px;border:0px;margin-top:2px;box-shadow: 0 0 0 0;">
                                        </div>
                                        <div class="col-md-2 tool">
                                            <i class="fa fa-info-circle infor"></i>
                                            <span class="tooltiptext2">Search for multiple Words or Phrase in same Caselaw seprating them by comma e.g.
                                                Credit Note, Supplementary invoice. You can search-in-search in next step.</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="form2">
                                    <div class="col-md-1">
                                         <label class="label" style="color: white;">Exact:</label>
                                     </div>
                                     <div class="col-md-3">
                                        <input type="radio" class="form-control" id="exactSearch" <?php if(($_REQUEST['exact_search']=='exact') || ($_REQUEST['exact_search']=='')) { ?> checked    <?php } ?> name="exact_search" value="exact" style="height:20px;border:0px;margin-top:-1px;box-shadow: 0 0 0 0;">
                                    </div>
                                    <div class="col-md-1">
                                        <label class="label" style="color: white;">Like:</label>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="radio" class="form-control" id="exactSearch" <?php if($_REQUEST['exact_search']=='like') { ?> checked <?php } ?> name="exact_search" value="like" style="height:20px;border:0px;margin-top:-1px;box-shadow: 0 0 0 0;">
                                    </div>
                                </div> -->
                                <div class="input-group input-group-big">
                                    <!-- <label class="label">Category:</label> -->
                                    <div class="label"><label>Category:</label></div>
                                    <select name="prod_id" id="product_id" class="form-control">
                                        <option value="0" <?php if (isset($_REQUEST['prod_id']) && ($_REQUEST['prod_id'] == "0")) { echo "selected=selected"; } ?> data-dbsuffix="0">Select</option>
                                        <option value="10" <?php if (isset($_REQUEST['prod_id']) && ($_REQUEST['prod_id'] == "10")) { echo "selected=selected"; } ?> data-dbsuffix="cgst">CGST</option>
                                        <option value="9" <?php if (isset($_REQUEST['prod_id']) && ($_REQUEST['prod_id'] == "9")) { echo "selected=selected"; } ?> data-dbsuffix="igst">IGST</option>
                                        <option value="7" <?php if (isset($_REQUEST['prod_id']) && ($_REQUEST['prod_id'] == "7")) { echo "selected=selected"; } ?> data-dbsuffix="sgst">SGST</option>
                                        <option value="1" <?php if (isset($_REQUEST['prod_id']) && ($_REQUEST['prod_id'] == "1")) { echo "selected=selected"; } ?> data-dbsuffix="vat">VAT</option>
                                        <option value="2" <?php if (isset($_REQUEST['prod_id']) && ($_REQUEST['prod_id'] == "2")) { echo "selected=selected"; } ?> data-dbsuffix="st">Service Tax</option>
                                        <option value="4" <?php if (isset($_REQUEST['prod_id']) && ($_REQUEST['prod_id'] == "4")) { echo "selected=selected"; } ?> data-dbsuffix="ce">Central Excise</option>
                                        <option value="5" <?php if (isset($_REQUEST['prod_id']) && ($_REQUEST['prod_id'] == "5")) { echo "selected=selected"; } ?> data-dbsuffix="cu">Customs</option>
                                        <option value="6" <?php if (isset($_REQUEST['prod_id']) && ($_REQUEST['prod_id'] == "6")) { echo "selected=selected"; } ?> data-dbsuffix="dgft">DGFT</option>
                                    </select>
                                </div>
                                <div class="input-group input-group-big display" id="state">
                                <div class="label"><label>State:</label></div>
                                    <!-- <label class="label" style="width: 0px; position: relative; top: 15px;">State:</label> -->
                                    <div class="form">
                                        <?php 
                                            if (isset($_REQUEST['state_id'])) {
                                                echo getStatDropdown($_REQUEST['state_id'], 'state_id');
                                            } else {
                                                echo getStatDropdown('', 'state_id');
                                            }
                                        ?>
                                    </div>
                                </div>
                                <div class="input-group input-group-big" id="category_type">
                                    <!-- <label class="label" style="width: 0px; position: relative; top: 15px;">Category Type:</label> -->
                                    <div class="label"><label>Category Type:</label></div>
                                    <div class="form" id="noti_div">
                                        <select id="sub_product_id" name="sub_product_id" class="form-control required" ></select>
                                    </div>
                                </div>
                                <div class="input-group input-group-big " id="notification_type">
                                    <div class="label"><label>Notification Type:</label></div>
                                    <!-- <label class="label" style="width: 0px; position: relative; top: 15px;">Notification Type:</label> -->
                                    <div class="form" id="noti_div">
                                        <select id="not_type" name="type" class="form-control required" ></select>
                                    </div>
                                </div>
                                <div class="input-group input-group-big">
                                    <div class="label"><label>Notification No.:</label></div>
                                    <input type="text" class="form-control" id="noti_no" placeholder="Notification No." name="noti_no" value="<?php if (isset($_REQUEST['noti_no']) && (!empty($_REQUEST['noti_no']))) {echo $_REQUEST['noti_no']; } ?>" />
                                </div>
                                
                                <div style="display: flex; font-size: 13px;padding: 7px 10px;gap: 10em;">
                                    <div style="margin-bottom: 10px;display: inline-flex;align-items: center;">
                                        <label style="margin-right: 2vw;width: 100%;">Notification Date:</label>
                                        <input style="border: 1px solid #ccc; padding: 5px; font-size: 13px;"  placeholder="Notification Date" type="date" id="date" name="date" value="<?php if (isset($_REQUEST['date']) && (!empty($_REQUEST['date']))) { echo $_REQUEST['date']; } ?>" />
                                    </div>

                                    <div style="display: flex; align-items: center; margin-bottom: 10px;">
                                        <label style="width: 100%;">Date Range:</label>                                        <input style="border: 1px solid #ccc; padding: 5px; margin-right: 10px; font-size: 13px;" type="date" id="dt_from" name="dt_from" value="<?php if (isset($_REQUEST['dt_from']) && (!empty($_REQUEST['dt_from']))) { echo $_REQUEST['dt_from']; } ?>" />
                                        <label>To:</label>
                                        <input style="border: 1px solid #ccc; padding: 5px; font-size: 13px; margin-left: 5px;" type="date" id="dt_to" name="dt_to" value="<?php if (isset($_REQUEST['dt_to']) && (!empty($_REQUEST['dt_to']))) { echo $_REQUEST['dt_to']; } ?>" />
                                    </div>

                                </div> 
                                <input type="submit" name="searchButton" id="searchButton" value="Search" class="btn-submit m-t-35"/>
                            </form>
                        </div>
                        <!-- <div class="tab-pane" id="tab4">
                            <form name="form2" id="form2" action="Advance_Search.php" method="GET" class="form padding-b-15">
                                <input type="hidden" name="pagename" value="News">
                                <input type="hidden" name="function_name" value="news">
                                <input type="hidden"  name="dbsuffix" value="features">
                                <div class="input-group input-group-big">
                                    <label class="label">Text:</label>
                                    <input type="text" class="form-control" id="text" name="text" value="<?php if (isset($_REQUEST['text']) && (!empty($_REQUEST['text']))) { echo $_REQUEST['text'];}?>"/>
                                </div>
                                <div class="input-group input-group-big">
                                    <label class="label">Filter Text:</label>
                                    <input type="text" class="form-control" id="text" name="text" value="<?php if (isset($_REQUEST['filter_text']) && (!empty($_REQUEST['filter_text']))) { echo $_REQUEST['filter_text']; }?>"/>
                                </div>
                                <div class="input-group input-group-big">
                                    <label class="label">Law:</label>
                                    <select name="searchCat"  id="searchCat" class="form-control">
                                        <option value="0">Please select </option>
                                    </select>
                                </div>
                                <div class="input-group input-group-big">
                                    <label class="label">Results:</label>
                                    <select name="searchCat"  id="searchCat" class="form-control">
                                        <option value="0">Please select </option>
                                    </select>
                                </div>
                                <input type="submit" name="searchButton" id="searchButton" value="Search" class="btn-submit m-t-35"/>
                            </form>
                        </div> -->
                        <div class="tab-pane" id="tab5">
                            <form name="form2" id="form2" action="Advance_Search.php" method="GET" class="form padding-b-15">
                                <input type="hidden" name="pagename" value="Articles">
                                <input type="hidden" name="function_name" value="articles">
                                <input type="hidden" id="" name="dbsuffix" value="articles">

                                <!-- <div class="wrapper">
                                    <div class="search-input">
                                        <input type="text" id="text" name="keyword" value="<?php //if (isset($_REQUEST['keyword']) && !empty($_REQUEST['keyword'])) { echo $_REQUEST['keyword']; }?>" placeholder="Type To Search in Keyword....">
                                        <div class="autocom-box">
                                            <li>Login Form In Html & Css</li>
                                            <li>Login Form In Html & Css</li>
                                            <li>Login Form In Html & Css</li>
                                            <li>Login Form In Html & Css</li>
                                            <li>Login Form In Html & Css</li>
                                        </div> -->
                                        <!-- <div class="icon">
                                            <i class="fa fa-search"></i>
                                        </div> -->
                                    <!-- </div>
                                </div> -->
                                <div class="input-group input-group-big">
                                    <div class="label"><label>Keyword:</label></div>
                                    
                                    <input type="text" class="form-control" id="keyword" name="keyword" value="<?php if (isset($_REQUEST['keyword']) && !empty($_REQUEST['keyword'])) { echo $_REQUEST['keyword']; }?>" placeholder="Keyword"/>
                                    <div class = "form2">
                                        <div class="col-md-2" >
                                            <label class="label" style="color: #00548a;">Exact:</label>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="radio" class="form-control" id="exactSearch" <?php if(($_REQUEST['exact_search']=='exact') || ($_REQUEST['exact_search']=='')) { ?> checked    <?php } ?> name="exact_search" value="exact" style="height:20px;border:0px;margin-top:2px;box-shadow: 0 0 0 0;">
                                        </div>
                                        <div class="col-md-2 tool">
                                            <i class="fa fa-info-circle infor"></i>
                                            <span class="tooltiptext2">Search for exact Word or Phrase. Try with texts most likely to be present in Caselaw. You can search-in-search in next step.</span>
                                        </div>
                                        <div class="col-md-2" >
                                            <label class="label" style="color: #00548a;">Like:</label>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="radio" class="form-control" id="exactSearch" <?php if($_REQUEST['exact_search']=='like') { ?> checked <?php } ?> name="exact_search" value="like" style="height:20px;border:0px;margin-top:2px;box-shadow: 0 0 0 0;">
                                        </div>
                                        <div class="col-md-2 tool">
                                            <i class="fa fa-info-circle infor"></i>
                                            <span class="tooltiptext2">Search for multiple Words or Phrase in same Caselaw seprating them by comma e.g. Credit Note, Supplementary invoice. You can search-in-search in next step.</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group input-group-big">
                                    <!-- <label class="label">Topic:</label> -->
                                    <div class="label"><label>Topic:</label></div>

                                    <input type="text" class="form-control" id="topic" placeholder="Enter Topic"  name="topic" value="<?php if (isset($_REQUEST['topic']) && (!empty($_REQUEST['topic']))) {
                                        echo $_REQUEST['topic']; } ?>"/>
                                </div>
                                <div class="input-group input-group-big">
                                    <!-- <label class="label">Category:</label> -->
                                    <div class="label"><label>Category:</label></div>

                                    <select id="" name="prod_id" class="form-control">
                                        <option value="0" <?php if (isset($_REQUEST['prod_id']) && ($_REQUEST['prod_id'] == '0')) { echo "selected=selected"; } ?>>Select</option>
                                        <option value="GST" <?php if (isset($_REQUEST['prod_id']) && ($_REQUEST['prod_id'] == 'GST')) { echo "selected=selected"; } ?>>GST</option>
                                        <option value="Others" <?php if (isset($_REQUEST['prod_id']) && ($_REQUEST['prod_id'] == 'Others')) { echo "selected=selected"; } ?>>Others</option>
                                    </select>
                                </div>
                                <div class="input-group input-group-big">
                                    <!-- <label class="label">Author:</label> -->
                                    <div class="label"><label>Author:</label></div>

                                    <div class="form">
                                        <?php echo getAuthor('articles'); ?>      
                                    </div>
                                </div>
                                <div class="row row-space">
                                    <div class="col-2">
                                        <div class="input-group">
                                            <div class="label"><label>Select From Date:</label></div>
                                            <!-- <label class="label">Select From Date:</label> -->
                                            <input class="input--style-1" type="date" name="check-in" placeholder="From Date" id="fromDate" name="fromDate" value="<?php if (isset($_REQUEST['fromDate']) && (!empty($_REQUEST['fromDate']))) { echo $_REQUEST['fromDate']; } ?>"/>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="input-group">
                                            <div class="label"><label>Select To Date:</label></div>
                                            <!-- <label class="label">Select To Date:</label> -->
                                            <input class="input--style-1" type="date" name="check-out" placeholder="To Date" id="toDate"  name="toDate" value="<?php if (isset($_REQUEST['toDate']) && (!empty($_REQUEST['toDate']))) { echo $_REQUEST['toDate']; } ?>"/>
                                        </div>
                                    </div>
                                </div>
                                <input type="submit" name="searchButton" id="searchButton" value="Search" class="btn-submit m-t-35"/>
                            </form>
                        </div>
                        <div class="tab-pane" id="tab6">
                            <form name="form2" id="form2" action="Advance_Search.php" method="GET" class="form padding-b-15">
                                <input type="hidden" name="pagename" value="tax vista">
                                <input type="hidden" name="function_name" value="tax_vista">
                                <input type="hidden" id="" name="dbsuffix" value="taxvista">

                                <!-- <div class="wrapper">-->
                                <!--    <div class="search-input">-->
                                        <!--<input type="text" id="text" name="keyword" value="<?php //if (isset($_REQUEST['keyword']) && !empty($_REQUEST['keyword'])) { echo $_REQUEST['keyword']; }?>" placeholder="Type To Search in Keyword....">-->
                                <!--        <div class="autocom-box">-->
                                <!--            <li>Login Form In Html & Css</li>-->
                                <!--            <li>Login Form In Html & Css</li>-->
                                <!--            <li>Login Form In Html & Css</li>-->
                                <!--            <li>Login Form In Html & Css</li>-->
                                <!--            <li>Login Form In Html & Css</li>-->
                                <!--        </div>-->
                                <!--         <div class="icon">-->
                                <!--            <i class="fa fa-search"></i>-->
                                <!--        </div>-->
                                <!--     </div>-->
                                <!--</div>-->
                                <div class="input-group input-group-big">
                                    <div class="label"><label>Keyword:</label></div>
                                    
                                    <input type="text" class="form-control" id="keyword" name="keyword" value="<?php if (isset($_REQUEST['keyword']) && !empty($_REQUEST['keyword'])) { echo $_REQUEST['keyword']; }?>" placeholder="Keyword"/>
                                    <div class = "form2">
                                        <div class="col-md-2" >
                                            <label class="label" style="color: #00548a;">Exact:</label>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="radio" class="form-control" id="exactSearch" <?php if(($_REQUEST['exact_search']=='exact') || ($_REQUEST['exact_search']=='')) { ?> checked    <?php } ?> name="exact_search" value="exact" style="height:20px;border:0px;margin-top:2px;box-shadow: 0 0 0 0;">
                                        </div>
                                        <div class="col-md-2 tool">
                                            <i class="fa fa-info-circle infor"></i>
                                            <span class="tooltiptext2">Search for exact Word or Phrase. Try with texts most likely to be present in Caselaw. You can search-in-search in next step.</span>
                                        </div>
                                        <div class="col-md-2" >
                                            <label class="label" style="color: #00548a;">Like:</label>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="radio" class="form-control" id="exactSearch" <?php if($_REQUEST['exact_search']=='like') { ?> checked <?php } ?> name="exact_search" value="like" style="height:20px;border:0px;margin-top:2px;box-shadow: 0 0 0 0;">
                                        </div>
                                        <div class="col-md-2 tool">
                                            <i class="fa fa-info-circle infor"></i>
                                            <span class="tooltiptext2">Search for multiple Words or Phrase in same Caselaw seprating them by comma e.g. Credit Note, Supplementary invoice. You can search-in-search in next step.</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row row-space" style="width: 100%;">
                                    <div class="col-2">
                                        <div class="input-group">
                                            <!-- <label class="label">Select From Date:</label> -->
                                            <div class="label"><label>Select From Date:</label></div>
                                            <input class="input--style-1" type="date" name="check-in" placeholder="From Date" id="fromDate" name="fromDate" value="<?php if (isset($_REQUEST['fromDate']) && (!empty($_REQUEST['fromDate']))) { echo $_REQUEST['fromDate']; } ?>"/>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="input-group">
                                            <!-- <label class="label">Select To Date:</label> -->
                                            <div class="label"><label>Select To Date:</label></div>
                                            <input class="input--style-1" type="date" name="check-out" placeholder="To Date" id="toDate"  name="toDate" value="<?php if (isset($_REQUEST['toDate']) && (!empty($_REQUEST['toDate']))) { echo $_REQUEST['toDate']; } ?>"/>
                                        </div>
                                    </div>
                                </div>
                                <input type="submit" name="searchButton" id="searchButton" value="Search" class="btn-submit m-t-35"/>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><?php
// } else {
//     include('loggedInError.php');
// }

include('footer.php');
?>
<!-- end document-->
<script src="js/script.js"></script>
<script src="js/suggestions.js"></script>
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

<script type="text/javascript">
    
    function delete_search_history($id) {
        return mysqli_query($GLOBALS['con'],"DELETE FROM search_history WHERE search_id = $id");
        // $result = mysqli_query($GLOBALS['con'],$query);
        // return $result;
    }

    function load_search_history() {

        var search_query = document.getElementsByName('party_name')[0].value;

        if(search_query == '')
        {

            fetch("process_data.php", {

                method: "POST",

                body: JSON.stringify({
                    action:'fetch'
                }),

                headers:{
                    'Content-type' : 'application/json; charset=UTF-8'
                }

            }).then(function(response){

                return response.json();

            }).then(function(responseData){

                if(responseData.length > 0)
                {

                    var html = '<ul class="list-group">';

                    html += '<li class="list-group-item d-flex justify-content-between align-items-center"><b class="text-primary"><i>Your Recent Searches</i></b></li>';

                    for(var count = 0; count < responseData.length; count++)
                    {

                        html += '<li class="list-group-item text-muted" style="cursor:pointer"><i class="fas fa-history mr-3"></i><span style="padding-left: 20px;" onclick="get_text(this)">'+responseData[count]+'</span> </li>';

                        // html += '<li class="list-group-item text-muted" style="cursor:pointer"><i class="fas fa-history mr-3"></i><span style="padding-left: 20px;" onclick="get_text(this)">'+responseData[count].party_name+'</span> <i class="far fa-trash-alt float-right mt-1" onclick="delete_search_history('+responseData[count].id+')"></i></li>';

                    }

                    html += '</ul>';

                    document.getElementById('search_result').innerHTML = html;

                }

            });

        }
    }


    function get_text(event) {

        var string = event.textContent;

        //fetch api

        //document.getElementsByName('party_name')[0].value = string;
        
        //document.getElementById('search_result').innerHTML = '';

        fetch("process_data.php", {

            method:"POST",

            body: JSON.stringify({
                party_name : string
            }),

            headers : {
                "Content-type" : "application/json; charset=UTF-8"
            }
        }).then(function(response){

            var data = response.json();

            //return data;

        }).then(function(responseData){

            document.getElementsByName('party_name')[0].value = string;
        
            document.getElementById('search_result').innerHTML = '';

        });

    }

    function load_data(query) {

        if(query.length > 0)
        {
            var form_data = new FormData();

            form_data.append('query', query);

            var ajax_request = new XMLHttpRequest();

            ajax_request.open('POST', 'process_data.php');

            ajax_request.send(form_data);

            ajax_request.onreadystatechange = function()
            {
                if(ajax_request.readyState == 4 && ajax_request.status == 200)
                {
                    var response = JSON.parse(ajax_request.responseText);

                    var html = '<div style="overflow: auto;height: 200px;" class="list-group">';

                    if(response.length > 0)
                    {
                        for(var count = 0; count < response.length; count++)
                        {
                            html += '<a href="#" class="list-group-item list-group-item-action" onclick="get_text(this)">'+response[count].party_name+'</a>';
                        }
                    }
                    else
                    {
                        html += '<a href="#" class="list-group-item list-group-item-action disabled">No Data Found</a>';
                    }

                    html += '</div>';

                    document.getElementById('search_result').innerHTML = html;
                }
            }
        }
        else
        {
            document.getElementById('search_result').innerHTML = '';
        }
    }
    function lose_focus() {

        document.getElementById('search_result').innerHTML = '';
    }
    
</script>

<script>
     function isNumberKey(evt)
    {
        // debugger;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode > 31
                && (charCode < 48 || charCode > 57))
            return false;

        return true;
    }
</script>
<script>
    // for act and rule
    $("#type").change(function() {
        // debugger;
        var value = $(this).val();
        if (value == "Acts") {
            $("#section_no").val("");
            $("#section").css("display", "flex");
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
            $("#notification").css("display", "flex");
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
            $("#policy").css("display", "flex");
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
            $("#policy_circular").css("display", "flex");
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
            $("#procedure").css("display", "flex");
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
            $("#public_notice").css("display", "flex");
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
            $("#trade_notice").css("display", "flex");
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
            $("#rule").css("display", "flex");
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
        var dbsuffix = $("#prod_id").find('option:selected').attr('data-dbsuffix');
        $("#dbsuffix").val(dbsuffix);

        //for case law
        $("#court").change(function() {
            var value = $(this).val();
            alert(value)
            if (value == "HC") {
                $("#hc").css('display', 'flex');
                $("#tri").css('display', 'none');
                $("#aar").css('display', 'none');
                $("#aaar").css('display', 'none');
            } else if (value == "TRI") {
                $("#hc").css('display', 'none');
                $("#tri").css('display', 'flex');
                $("#aar").css('display', 'none');
                $("#aaar").css('display', 'none');
            } else if (value == "AAR") {
                $("#hc").css('display', 'none');
                $("#tri").css('display', 'none');
                $("#aar").css('display', 'flex');
                $("#aaar").css('display', 'none');
            } else if (value == "AAAR") {
                $("#hc").css('display', 'none');
                $("#tri").css('display', 'none');
                $("#aar").css('display', 'none');
                $("#aaar").css('display', 'flex');
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
<script type="text/javascript">
    $(document).ready(function() {
        //for Notification
        $("#product_id").change(function() {
            var val = $(this).val();
            var dbsuffix = $("#product_id").find('option:selected').attr('data-dbsuffix');
            $("#dbsuffix").val(dbsuffix);

            if (val == '7') {
                $("#state").css("display", "flex");
                $('#category_type').css("display", "flex");
            } else {
                $("#state").css("display", "none");
            }
            if (dbsuffix != '0') {
                var table = 'casedata_' + dbsuffix;
            } else {
                $('#category_type').css("display", "none");
                return false;
            }

            if (val == '1' || val == '2' || val == '4' || val == '5' || val == '6' || val == '7' || val == '8' || val == '9' || val == '10') {
                $.ajax({
                    data: {id: val, table: table},
                    url: "adv_search_notification_type.php", //php page URL where we post this data to view from database
                    type: 'POST',
                    dataType: 'html',
                    success: function(data) {
                        // debugger;
                        //alert(data);
                        if (data != "no") {
                            $('#category_type').css("display", "flex");
                            $("#sub_product_id").html(data);
                        } else {
                            $('#category_type').css("display", "none");
                        }
                    }
                });
                return false;
            }
            $('#category_type').css("display", "none");
        });
        $("#sub_product_id").change(function() {
            var val = $("#product_id option:selected").val();
            var type = $(this).val();
            $('#not_type').find('option').remove();
            if (val == '7' || val == '8' || val == '9' || val == '10')
            {
                if (type == "Circular")
                {
                    $("#notification_type").css('display', 'none');
                }
                else
                {
                    $("#notification_type").css('display', 'flex');
                    $(".not_type_label").text('Notification Type');
                    $("#not_type").append('<option value="0">Select</option>' + '<option value="Notification">Notification</option>' +
                            '<option value="Rate Notification">Rate Notification</option>');
                }
            }

            if (val == '5')
            {
                $("#notification_type").css('display', 'flex');
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
                $("#notification_type").css('display', 'flex');
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