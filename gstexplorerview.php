<style>
    /* Style the buttons that are used to open and close the accordion panel */
    .accordion {
      background: linear-gradient(130deg,#319197,#ff7a18 41.07%,#af002d 76.05%); font-size: 15px; color: white; cursor: pointer; padding: 11px;
      width: 100%; text-align: left; border: none; outline: none; transition: 0.4s;
    }

    /* Style the accordion panel. Note: hidden by default */
    .pane {
        background-color: #fff; display: none; overflow: auto;
        transition: max-height 0.2s ease-out;
    }
    .accordion:after {
      /*content: '\02795';*/ /* Unicode character for "plus" sign (+) */
      font-size: 12px; color: #777; float: right; margin-left: 5px;
    }

    .active:after {
        /*max-height: none;*/
      /*content: "\2796";*/ /* Unicode character for "minus" sign (-) */
    }

    #GSTExplorerDiv{
        display: none; background: #fffff0; position: fixed; left: 0; top: 100px; color: #4f013e;
        height: 650px; width: 600px; border-radius: 0 20px 20px 0px; border:5px orange solid; 
        order-left:0px; font-family:'calibri'; font-size:14px; z-index: 12000;
    }

    #ExplorerPinDiv{
        width: 50px; height: 200px; display: block; background: orange; position: fixed; left: 0px;
        top: 200px; color: #FFF; border-radius: 0 20px 20px 0px; padding: 20px; z-index: 12000;
        writing-mode: vertical-rl; text-align: center; font-weight: bold; cursor: pointer; 
        letter-spacing: 5px; 
    }

    #GSTExplorerDiv .explorer-header{
        text-align:left; width:100%; cursor: pointer; font-size: 20px; clear:both; color:#FFF;
        border-bottom: 1px solid orange; margin-bottom: 10px; background: orange; 
        padding: 10px 20px;
    }

    #GSTExplorerDiv .explorer-hide{
        text-align:right; width:50%; font-weight:normal; cursor: pointer; float:right;
        font-size: 12px; color:#FFF;
    }

    #GSTExplorerDiv .explorer-pane{
        width:44%; float:left; padding-left: 10px;
    }

    #GSTExplorerDiv .explorer-expanding-blocks{
        padding: 5px; border: 1px solid gray; background: #e0e0e0; cursor: pointer;font-size: 15px;
        border-bottom: 0px; color: black; width: 228px; margin-left: 0px;
    }

    #GSTExplorerDiv .explorer-expanding-blocks:last-child{
        border-bottom:1px solid gray;
    }

    #GSTExplorerDiv .explorer-expanding-blocks-header{
        text-align: center; color: #FFF; border-radius: 5px 5px 0px 0px; border: 2px solid orange;
        background: linear-gradient(to bottom, #007ba0 0%,#005389 100%); padding: 5px;width: 234px;
    }

    #GSTExplorerDiv .explorer-expanding-blocks-header > option{
        padding:10px;
    }

    #GSTExplorerDiv .explorer-expanding-blocks .expand{
        width:20px; float:right;
    }

    #GSTExplorerDiv .listing-blocks{
        display:none; padding-left:0px; list-style-type:none; max-height: 200px; overflow: auto;
        color:black; border:1px solid gray;
    }

    #GSTExplorerDiv .listing-blocks li{
        margin:2px 0px; border-bottom:1px dashed #ccc; padding:3px; color:black;
        font-weight: normal;
    }

    #GSTExplorerDiv .listing-blocks li:last-child{
        margin:2px 0px; border-bottom:0px; padding:3px;
    }

    .bordered{
        border: 1px orange solid;
    }

    #GSTExplorerDiv .listing-blocks li a:hover{
        color:orange;
    }

    #GSTExplorerDiv .listing-blocks li a{
        font-size:14px;
    }

    #GSTExplorerDiv .border-bottom{
        border:1px solid gray; color: #000; padding: 5px;
    }

    #GSTExplorerDiv .explorer-block-container{
        border: #007ba0 2px solid; width: 234px; max-height: 350px; min-height: 145px;
    }

    #navigation-left{
        width: 52% !important; float: left; font-family: 'calibri'; font-size: 14px; 
        display: table;
    }

    #navigation-left .ex-blocks{
        padding:10px 5px 10px 5px; border:1px solid gray; cursor: pointer; font-weight: bold;
        font-size:15px; border-bottom:0px;
    }

    #navigation-left .ex-blocks .expand{
        width:20px; float:right;
    }

    #navigation-left .listing-blocks{
        display:none; padding-left:0px; list-style-type:none; max-height: 400px; overflow: auto; border:1px solid gray;
    }

    #navigation-left .listing-blocks li{
        margin:2px 0px; border-bottom:1px dashed #ccc; padding:3px;
    }

    #navigation-left .listing-blocks li:last-child{
        margin:2px 0px; border-bottom:0px; padding:3px;
    }

    /* Tooltip */
    #navigation-left .listing-blocks li a:hover{
        color:orange; /*font-weight:bold;*/
    }
    #navigation-left .listing-blocks li a{
        font-size:14px;
    }
    #navigation-left .tooltip{
        max-width:500px; opacity:1;
    }
    #navigation-left .tooltip > .tooltip-inner {
        background-color: #F1F1f1 !important; color: #000; border: 1px solid green;
        max-width: 500px; padding: 5px 10px; font-size: 15px;  opacity:1 !important;
        text-align:left;
    }

    /*For Search Engine...*/
    #myInput01 {
      background-image: url('images/search_icon.png'); /* Add a search icon to input */
      background-position: 110px 0px; /* Position the search icon */
      background-size: contain; /* Size of the search icon */
      background-repeat: no-repeat; /* Do not repeat the icon image */
      width: 65%;
      border: none; /* Add No border */
    }

    #myInput02 {
      background-image: url('images/search_icon.png'); /* Add a search icon to input */
      background-position: 110px 0px; /* Position the search icon */
      background-size: contain; /* Size of the search icon */
      background-repeat: no-repeat; /* Do not repeat the icon image */
      width: 65%;
      border: none; /* Add No border */
    }

    #myInput03 {
      background-image: url('images/search_icon.png'); /* Add a search icon to input */
      background-position: 80px 0px; /* Position the search icon */
      background-size: contain; /* Size of the search icon */
      background-repeat: no-repeat; /* Do not repeat the icon image */
      width: 50%;
      border: none; /* Add No border */
    }

    #myInput04 {
      background-image: url('images/search_icon.png'); /* Add a search icon to input */
      background-position: 100px 0px; /* Position the search icon */
      background-size: contain; /* Size of the search icon */
      background-repeat: no-repeat; /* Do not repeat the icon image */
      width: 60%;
      border: none; /* Add No border */
    }

    #myInput05 {
      background-image: url('images/search_icon.png'); /* Add a search icon to input */
      background-position: 110px 0px; /* Position the search icon */
      background-size: contain; /* Size of the search icon */
      background-repeat: no-repeat; /* Do not repeat the icon image */
      width: 65%;
      border: none; /* Add No border */
    }

    #myInput06 {
      background-image: url('images/search_icon.png'); /* Add a search icon to input */
      background-position: 110px 0px; /* Position the search icon */
      background-size: contain; /* Size of the search icon */
      background-repeat: no-repeat; /* Do not repeat the icon image */
      width: 65%;
      border: none; /* Add No border */
    }

    #myInput07 {
      background-image: url('images/search_icon.png'); /* Add a search icon to input */
      background-position: 80px 0px; /* Position the search icon */
      background-size: contain; /* Size of the search icon */
      background-repeat: no-repeat; /* Do not repeat the icon image */
      width: 50%;
      border: none; /* Add No border */
    }

    #myInput08 {
      background-image: url('images/search_icon.png'); /* Add a search icon to input */
      background-position: 100px 0px; /* Position the search icon */
      background-size: contain; /* Size of the search icon */
      background-repeat: no-repeat; /* Do not repeat the icon image */
      width: 60%;
      border: none; /* Add No border */
    }

    #myInput09 {
      background-image: url('images/search_icon.png'); /* Add a search icon to input */
      background-position: 110px 0px; /* Position the search icon */
      background-size: contain; /* Size of the search icon */
      background-repeat: no-repeat; /* Do not repeat the icon image */
      width: 65%;
      border: none; /* Add No border */
    }

    #myInput010 {
      background-image: url('images/search_icon.png'); /* Add a search icon to input */
      background-position: 110px 0px; /* Position the search icon */
      background-size: contain; /* Size of the search icon */
      background-repeat: no-repeat; /* Do not repeat the icon image */
      width: 65%;
      border: none; /* Add No border */
    }

    #myInput011 {
      background-image: url('images/search_icon.png'); /* Add a search icon to input */
      background-position: 80px 0px; /* Position the search icon */
      background-size: contain; /* Size of the search icon */
      background-repeat: no-repeat; /* Do not repeat the icon image */
      width: 50%;
      border: none; /* Add No border */
    }

    #myInput012 {
      background-image: url('images/search_icon.png'); /* Add a search icon to input */
      background-position: 100px 0px; /* Position the search icon */
      background-size: contain; /* Size of the search icon */
      background-repeat: no-repeat; /* Do not repeat the icon image */
      width: 60%;
      border: none; /* Add No border */
    }

    #myInput {
      background-image: url('images/search_icon.png'); /* Add a search icon to input */
      background-position: 140px 0px; /* Position the search icon */
      background-size: contain; /* Size of the search icon */
      background-repeat: no-repeat; /* Do not repeat the icon image */
      border: none; /* Add No border */
    }

    #myInput2 {
      background-image: url('images/search_icon.png'); /* Add a search icon to input */
      background-position: 140px 0px; /* Position the search icon */
      background-size: contain; /* Size of the search icon */
      background-repeat: no-repeat; /* Do not repeat the icon image */
      border: none; /* Add No border */
    }

    #myInput3 {
      background-image: url('images/search_icon.png'); /* Add a search icon to input */
      background-position: 140px 0px; /* Position the search icon */
      background-size: contain; /* Size of the search icon */
      background-repeat: no-repeat; /* Do not repeat the icon image */
      border: none; /* Add No border */
    }

    #myInput4 {
      background-image: url('images/search_icon.png'); /* Add a search icon to input */
      background-position: 140px 0px; /* Position the search icon */
      background-size: contain; /* Size of the search icon */
      background-repeat: no-repeat; /* Do not repeat the icon image */
      border: none; /* Add No border */
    }

    #myInput5 {
      background-image: url('images/search_icon.png'); /* Add a search icon to input */
      background-position: 140px 0px; /* Position the search icon */
      background-size: contain; /* Size of the search icon */
      background-repeat: no-repeat; /* Do not repeat the icon image */
      border: none; /* Add No border */
    }

    #myInput6 {
      background-image: url('images/search_icon.png'); /* Add a search icon to input */
      background-position: 140px 0px; /* Position the search icon */
      background-size: contain; /* Size of the search icon */
      background-repeat: no-repeat; /* Do not repeat the icon image */
      border: none; /* Add No border */
    }

    #myInput7 {
      background-image: url('images/search_icon.png'); /* Add a search icon to input */
      background-position: 140px 0px; /* Position the search icon */
      background-size: contain; /* Size of the search icon */
      background-repeat: no-repeat; /* Do not repeat the icon image */
      border: none; /* Add No border */
    }

    #myInput8 {
      background-image: url('images/search_icon.png'); /* Add a search icon to input */
      background-position: 100px 0px; /* Position the search icon */
      background-size: contain; /* Size of the search icon */
      background-repeat: no-repeat; /* Do not repeat the icon image */
      width: 45%;
      border: none; /* Add No border */
    }

    #myInput9 {
      background-image: url('images/search_icon.png'); /* Add a search icon to input */
      background-position: 140px 0px; /* Position the search icon */
      background-size: contain; /* Size of the search icon */
      background-repeat: no-repeat; /* Do not repeat the icon image */
      border: none; /* Add No border */
    }

    #myInput10 {
      background-image: url('images/search_icon.png'); /* Add a search icon to input */
      background-position: 140px 0px; /* Position the search icon */
      background-size: contain; /* Size of the search icon */
      background-repeat: no-repeat; /* Do not repeat the icon image */
      border: none; /* Add No border */
    }

    #myInput11 {
      background-image: url('images/search_icon.png'); /* Add a search icon to input */
      background-position: 140px 0px; /* Position the search icon */
      background-size: contain; /* Size of the search icon */
      background-repeat: no-repeat; /* Do not repeat the icon image */
      border: none; /* Add No border */
    }

    #myInput12 {
      background-image: url('images/search_icon.png'); /* Add a search icon to input */
      background-position: 140px 0px; /* Position the search icon */
      background-size: contain; /* Size of the search icon */
      background-repeat: no-repeat; /* Do not repeat the icon image */
      border: none; /* Add No border */
    }

    #myInput13 {
      background-image: url('images/search_icon.png'); /* Add a search icon to input */
      background-position: 140px 0px; /* Position the search icon */
      background-size: contain; /* Size of the search icon */
      background-repeat: no-repeat; /* Do not repeat the icon image */
      border: none; /* Add No border */
    }

    #myInput14 {
      background-image: url('images/search_icon.png'); /* Add a search icon to input */
      background-position: 140px 0px; /* Position the search icon */
      background-size: contain; /* Size of the search icon */
      background-repeat: no-repeat; /* Do not repeat the icon image */
      border: none; /* Add No border */
    }

    #myInput15 {
      background-image: url('images/search_icon.png'); /* Add a search icon to input */
      background-position: 140px 0px; /* Position the search icon */
      background-size: contain; /* Size of the search icon */
      background-repeat: no-repeat; /* Do not repeat the icon image */
      border: none; /* Add No border */
    }

    #myInput16 {
      background-image: url('images/search_icon.png'); /* Add a search icon to input */
      background-position: 140px 0px; /* Position the search icon */
      background-size: contain; /* Size of the search icon */
      background-repeat: no-repeat; /* Do not repeat the icon image */
      border: none; /* Add No border */
    }

    #myInput17 {
      background-image: url('images/search_icon.png'); /* Add a search icon to input */
      background-position: 140px 0px; /* Position the search icon */
      background-size: contain; /* Size of the search icon */
      background-repeat: no-repeat; /* Do not repeat the icon image */
      border: none; /* Add No border */
    }

    #myInput18 {
      background-image: url('images/search_icon.png'); /* Add a search icon to input */
      background-position: 100px 0px; /* Position the search icon */
      background-size: contain; /* Size of the search icon */
      background-repeat: no-repeat; /* Do not repeat the icon image */
      width: 45%;
      border: none; /* Add No border */
    }

    #myInput19 {
      background-image: url('images/search_icon.png'); /* Add a search icon to input */
      background-position: 140px 0px; /* Position the search icon */
      background-size: contain; /* Size of the search icon */
      background-repeat: no-repeat; /* Do not repeat the icon image */
      border: none; /* Add No border */
    }

    #myInput20 {
      background-image: url('images/search_icon.png'); /* Add a search icon to input */
      background-position: 140px 0px; /* Position the search icon */
      background-size: contain; /* Size of the search icon */
      background-repeat: no-repeat; /* Do not repeat the icon image */
      border: none; /* Add No border */
    }

    #myInput21 {
      background-image: url('images/search_icon.png'); /* Add a search icon to input */
      background-position: 140px 0px; /* Position the search icon */
      background-size: contain; /* Size of the search icon */
      background-repeat: no-repeat; /* Do not repeat the icon image */
      border: none; /* Add No border */
    }

    #myInput22 {
      background-image: url('images/search_icon.png'); /* Add a search icon to input */
      background-position: 140px 0px; /* Position the search icon */
      background-size: contain; /* Size of the search icon */
      background-repeat: no-repeat; /* Do not repeat the icon image */
      border: none; /* Add No border */
    }

    #myInput23 {
      background-image: url('images/search_icon.png'); /* Add a search icon to input */
      background-position: 140px 0px; /* Position the search icon */
      background-size: contain; /* Size of the search icon */
      background-repeat: no-repeat; /* Do not repeat the icon image */
      border: none; /* Add No border */
    }

    #myInput24 {
      background-image: url('images/search_icon.png'); /* Add a search icon to input */
      background-position: 140px 0px; /* Position the search icon */
      background-size: contain; /* Size of the search icon */
      background-repeat: no-repeat; /* Do not repeat the icon image */
      border: none; /* Add No border */
    }

    #myInput25 {
      background-image: url('images/search_icon.png'); /* Add a search icon to input */
      background-position: 140px 0px; /* Position the search icon */
      background-size: contain; /* Size of the search icon */
      background-repeat: no-repeat; /* Do not repeat the icon image */
      border: none; /* Add No border */
    }

    #myInput26 {
      background-image: url('images/search_icon.png'); /* Add a search icon to input */
      background-position: 140px 0px; /* Position the search icon */
      background-size: contain; /* Size of the search icon */
      background-repeat: no-repeat; /* Do not repeat the icon image */
      border: none; /* Add No border */
    }

    #myInput27 {
      background-image: url('images/search_icon.png'); /* Add a search icon to input */
      background-position: 140px 0px; /* Position the search icon */
      background-size: contain; /* Size of the search icon */
      background-repeat: no-repeat; /* Do not repeat the icon image */
      border: none; /* Add No border */
    }

    #myInput28 {
      background-image: url('images/search_icon.png'); /* Add a search icon to input */
      background-position: 100px 0px; /* Position the search icon */
      background-size: contain; /* Size of the search icon */
      background-repeat: no-repeat; /* Do not repeat the icon image */
      width: 45%;
      border: none; /* Add No border */
    }

    #myInput29 {
      background-image: url('images/search_icon.png'); /* Add a search icon to input */
      background-position: 140px 0px; /* Position the search icon */
      background-size: contain; /* Size of the search icon */
      background-repeat: no-repeat; /* Do not repeat the icon image */
      border: none; /* Add No border */
    }

    #myInput30 {
      background-image: url('images/search_icon.png'); /* Add a search icon to input */
      background-position: 140px 0px; /* Position the search icon */
      background-size: contain; /* Size of the search icon */
      background-repeat: no-repeat; /* Do not repeat the icon image */
      border: none; /* Add No border */
    }

</style>

<div id='ExplorerPinDiv'>
    GST&nbsp;&nbsp;EXPLORER
</div>

<div id='GSTExplorerDiv'>
    <div id='csrf-token_explorer' style='display:none'> <?php
        $getUniqueCSRFToken = uniqid('explorer');
        $_SESSION['explorer_csrf_token'] = $getUniqueCSRFToken;
        echo $getUniqueCSRFToken; ?>
    </div>

    <div class='explorer-header'>GST EXPLORER 
        <div class='explorer-hide'> << Hide Explorer</div>
    </div>
    <div class='explorer-pane'>

        <div id="target" class="explorer-expanding-blocks-header" data-target='cgst'>CGST
            <span class="expand">+</span>
        </div>
        <div class='explorer-block-container' id='explorer-block-container-cgst'>
            <div class="explorer-expanding-blocks" data-block='sections-cgst'>Section
                <span class="expand">+</span>
                <input type="text" id="myInput01" onkeyup="myFunction01()" placeholder="Search..">
            </div>
            <ul id='explorer-listing-sections-cgst' class='listing-blocks'></UL>
            <div class="explorer-expanding-blocks" data-block='rules-cgst'>Rules
                <span class="expand">+</span>
                <input type="text" id="myInput02" onkeyup="myFunction02()" placeholder="Search..">
            </div>
            <ul id='explorer-listing-rules-cgst' class='listing-blocks'></UL>
            <div class="explorer-expanding-blocks" data-block='notifications-cgst'>Notifications
                <span class="expand">+</span>
                <input type="text" id="myInput03" onkeyup="myFunction03()" placeholder="Search..">
            </div>
            <ul id='explorer-listing-notifications-cgst' class='listing-blocks'></UL>
            <div class="explorer-expanding-blocks" data-block='circulars-cgst'>Circulars
                <span class="expand">+</span>
                <input type="text" id="myInput04" onkeyup="myFunction04()" placeholder="Search..">
            </div>
            <ul id='explorer-listing-circulars-cgst' class='listing-blocks'></UL>
        </div>

        <div id="target2" class="explorer-expanding-blocks-header" data-target='igst'>IGST 
            <span class="expand">+</span>
        </div>
        <div class='explorer-block-container' id='explorer-block-container-igst'>
            <div class="explorer-expanding-blocks" data-block='sections-igst'>Section
                <span class="expand">+</span>
                <input type="text" id="myInput05" onkeyup="myFunction05()" placeholder="Search..">
            </div>
            <ul id='explorer-listing-sections-igst' class='listing-blocks'></UL>
            <div class="explorer-expanding-blocks" data-block='rules-igst'>Rules
                <span class="expand">+</span>
                <input type="text" id="myInput06" onkeyup="myFunction06()" placeholder="Search..">
            </div>
            <ul id='explorer-listing-rules-igst' class='listing-blocks'></UL>
            <div class="explorer-expanding-blocks" data-block='notifications-igst'>Notifications
                <span class="expand">+</span>
                <input type="text" id="myInput07" onkeyup="myFunction07()" placeholder="Search..">
            </div>
            <ul id='explorer-listing-notifications-igst' class='listing-blocks'></UL>
            <div class="explorer-expanding-blocks" data-block='circulars-igst'>Circulars
                <span class="expand">+</span>
                <input type="text" id="myInput08" onkeyup="myFunction08()" placeholder="Search..">
            </div>
            <ul id='explorer-listing-circulars-igst' class='listing-blocks'></UL>
        </div>

        <div id="target3" class="explorer-expanding-blocks-header" data-target='sgst'>CCESS 
            <span class="expand">+</span>
        </div>
        <div class='explorer-block-container' id='explorer-block-container-sgst'>
            <div class="explorer-expanding-blocks" data-block='sections-sgst'>Section
                <span class="expand">+</span>
                <input type="text" id="myInput09" onkeyup="myFunction09()" placeholder="Search..">
            </div>
            <ul id='explorer-listing-sections-sgst' class='listing-blocks'></UL>
            <div class="explorer-expanding-blocks" data-block='rules-sgst'>Rules
                <span class="expand">+</span>
                <input type="text" id="myInput010" onkeyup="myFunction010()" placeholder="Search..">
            </div>
            <ul id='explorer-listing-rules-sgst' class='listing-blocks'></UL>
            <div class="explorer-expanding-blocks" data-block='notifications-sgst'>Notifications
                <span class="expand">+</span>
                <input type="text" id="myInput011" onkeyup="myFunction011()" placeholder="Search..">
            </div>
            <ul id='explorer-listing-notifications-sgst' class='listing-blocks'></UL>            
            <div class="explorer-expanding-blocks" data-block='circulars-sgst'>Circulars
                <span class="expand">+</span>
                <input type="text" id="myInput012" onkeyup="myFunction012()" placeholder="Search..">
            </div>
            <ul id='explorer-listing-circulars-sgst' class='listing-blocks'></UL>
        </div>
    </div>

    <div class='explorer-pane' id="navigation-left" style='display:none'>
        <div class="accordion"> VIEW RELATED RECORDS </div>
        <div class="pane">
            <div class="ex-blocks" id="section"> Section 
                <span class="expand">+</span>                
            </div>
            <div class="ex-blocks" id="rule"> Rule 
                <span class="expand">+</span>
            </div>
            <div class="ex-blocks" id="notification"> Notification 
                <span class="expand">+</span>
            </div>
            <div class="ex-blocks" id="circular"> Circular 
                <span class="expand">+</span>
            </div>
            <div class="ex-blocks" id="cites"> Cites 
                <span class="expand">+</span>
            </div>
        </div>
        <div style="margin-top: 10px;"></div>
        <div class="accordion"> CITED IN </div>
        <div class="pane">
            <div class="ex-blocks" id="caselaws"> Caselaws 
                <span class="expand">+</span>
            </div>
            <div class="ex-blocks" id="notification1"> Notifications 
                <span class="expand">+</span>
            </div>
            <div class="ex-blocks" id="circular1"> Circular/Order/ROD 
                <span class="expand">+</span>
            </div>
            <div class="ex-blocks" id="section1"> Sections 
                <span class="expand">+</span>
            </div>
            <div class="ex-blocks" id="rule1"> Rules 
                <span class="expand">+</span>
            </div>
        </div>
    </div>
    <script>
        $('#target').click(function(){
            var cgst = $(this).attr('data-target');
            //console.log(cgst);

            // Related Records

            $("#section").attr("data-block", 'rsect-'+cgst);
            $('#section').append('<input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search..">');
            $('#section').append('<ul class="listing-blocks" id="expand-listing-rsect-'+cgst+'">'+ ''+'</ul>');

            $("#rule").attr("data-block", 'rrul-'+cgst);
            $('#rule').append('<input type="text" id="myInput2" onkeyup="myFunction2()" placeholder="Search..">');
            $('#rule').append('<ul class="listing-blocks" id="expand-listing-rrul-'+cgst+'">'+ ''+'</ul>');

            $("#notification").attr("data-block", 'rnoti-'+cgst);
            $('#notification').append('<input type="text" id="myInput3" onkeyup="myFunction3()" placeholder="Search..">');
            $('#notification').append('<ul class="listing-blocks" id="expand-listing-rnoti-'+cgst+'">'+ ''+'</ul>');

            $("#circular").attr("data-block", 'rcir-'+cgst);
            $('#circular').append('<input type="text" id="myInput4" onkeyup="myFunction4()" placeholder="Search..">');
            $('#circular').append('<ul class="listing-blocks" id="expand-listing-rcir-'+cgst+'">'+ ''+'</ul>');

            $("#cites").attr("data-block", 'rjud-'+cgst);
            $('#cites').append('<input type="text" id="myInput5" onkeyup="myFunction5()" placeholder="Search..">');
            $('#cites').append('<ul class="listing-blocks" id="expand-listing-rjud-'+cgst+'">'+ ''+'</ul>');

            // Cited In

            $("#caselaws").attr("data-block", 'cCase-'+cgst);
            $('#caselaws').append('<input type="text" id="myInput6" onkeyup="myFunction6()" placeholder="Search..">');
            $('#caselaws').append('<ul class="listing-blocks" id="expand-listing-cCase-'+cgst+'">'+ ''+'</ul>');

            $("#notification1").attr("data-block", 'cNotification-'+cgst);
            $('#notification1').append('<input type="text" id="myInput7" onkeyup="myFunction7()" placeholder="Search..">');
            $('#notification1').append('<ul class="listing-blocks" id="expand-listing-cNotification-'+cgst+'">'+ ''+'</ul>');

            $("#circular1").attr("data-block", 'cCircular-'+cgst);
            $('#circular1').append('<input type="text" id="myInput8" onkeyup="myFunction8()" placeholder="Search..">');
            $('#circular1').append('<ul class="listing-blocks" id="expand-listing-cCircular-'+cgst+'">'+ ''+'</ul>');

            $("#section1").attr("data-block", 'cSection-'+cgst);
            $('#section1').append('<input type="text" id="myInput9" onkeyup="myFunction9()" placeholder="Search..">');
            $('#section1').append('<ul class="listing-blocks" id="expand-listing-cSection-'+cgst+'">'+ ''+'</ul>');

            $("#rule1").attr("data-block", 'cRule-'+cgst);
            $('#rule1').append('<input type="text" id="myInput10" onkeyup="myFunction10()" placeholder="Search..">');
            $('#rule1').append('<ul class="listing-blocks" id="expand-listing-cRule-'+cgst+'">'+ ''+'</ul>');
        });
        $('#target2').click(function(){
            var igst = $(this).attr('data-target');
            
            // Related Records
            
            $("#section").attr("data-block", 'rsect-'+igst);
            $('#section').append('<input type="text" id="myInput11" onkeyup="myFunction11()" placeholder="Search..">');
            $('#section').append('<ul class="listing-blocks" id="expand-listing-rsect-'+igst+'">'+ ''+'</ul>');

            $("#rule").attr("data-block", 'rrul-'+igst);
            $('#rule').append('<input type="text" id="myInput12" onkeyup="myFunction12()" placeholder="Search..">');
            $('#rule').append('<ul class="listing-blocks" id="expand-listing-rrul-'+igst+'">'+ ''+'</ul>');

            $("#notification").attr("data-block", 'rnoti-'+igst);
            $('#notification').append('<input type="text" id="myInput13" onkeyup="myFunction13()" placeholder="Search..">');
            $('#notification').append('<ul class="listing-blocks" id="expand-listing-rnoti-'+igst+'">'+ ''+'</ul>');

            $("#circular").attr("data-block", 'rcir-'+igst);
            $('#circular').append('<input type="text" id="myInput14" onkeyup="myFunction14()" placeholder="Search..">');
            $('#circular').append('<ul class="listing-blocks" id="expand-listing-rcir-'+igst+'">'+ ''+'</ul>');

            $("#cites").attr("data-block", 'rjud-'+igst);
            $('#cites').append('<input type="text" id="myInput15" onkeyup="myFunction15()" placeholder="Search..">');
            $('#cites').append('<ul class="listing-blocks" id="expand-listing-rjud-'+igst+'">'+ ''+'</ul>');

            // Cited In

            $("#caselaws").attr("data-block", 'cCase-'+igst);
            $('#caselaws').append('<input type="text" id="myInput16" onkeyup="myFunction16()" placeholder="Search..">');
            $('#caselaws').append('<ul class="listing-blocks" id="expand-listing-cCase-'+igst+'">'+ ''+'</ul>');

            $("#notification1").attr("data-block", 'cNotification-'+igst);
            $('#notification1').append('<input type="text" id="myInput17" onkeyup="myFunction17()" placeholder="Search..">');
            $('#notification1').append('<ul class="listing-blocks" id="expand-listing-cNotification-'+igst+'">'+ ''+'</ul>');

            $("#circular1").attr("data-block", 'cCircular-'+igst);
            $('#circular1').append('<input type="text" id="myInput18" onkeyup="myFunction18()" placeholder="Search..">');
            $('#circular1').append('<ul class="listing-blocks" id="expand-listing-cCircular-'+igst+'">'+ ''+'</ul>');

            $("#section1").attr("data-block", 'cSection-'+igst);
            $('#section1').append('<input type="text" id="myInput19" onkeyup="myFunction19()" placeholder="Search..">');
            $('#section1').append('<ul class="listing-blocks" id="expand-listing-cSection-'+igst+'">'+ ''+'</ul>');

            $("#rule1").attr("data-block", 'cRule-'+igst);
            $('#rule1').append('<input type="text" id="myInput20" onkeyup="myFunction20()" placeholder="Search..">');
            $('#rule1').append('<ul class="listing-blocks" id="expand-listing-cRule-'+igst+'">'+ ''+'</ul>');
        });
        $('#target3').click(function(){
            var sgst = $(this).attr('data-target');
            
            // Related Records
            
            $("#section").attr("data-block", 'rsect-'+sgst);
            $('#section').append('<input type="text" id="myInput21" onkeyup="myFunction21()" placeholder="Search..">');
            $('#section').append('<ul class="listing-blocks" id="expand-listing-rsect-'+sgst+'">'+ ''+'</ul>');

            $("#rule").attr("data-block", 'rrul-'+sgst);
            $('#rule').append('<input type="text" id="myInput22" onkeyup="myFunction23()" placeholder="Search..">');
            $('#rule').append('<ul class="listing-blocks" id="expand-listing-rrul-'+sgst+'">'+ ''+'</ul>');

            $("#notification").attr("data-block", 'rnoti-'+sgst);
            $('#notification').append('<input type="text" id="myInput23" onkeyup="myFunction23()" placeholder="Search..">');
            $('#notification').append('<ul class="listing-blocks" id="expand-listing-rnoti-'+sgst+'">'+ ''+'</ul>');

            $("#circular").attr("data-block", 'rcir-'+sgst);
            $('#circular').append('<input type="text" id="myInput24" onkeyup="myFunction24()" placeholder="Search..">');
            $('#circular').append('<ul class="listing-blocks" id="expand-listing-rcir-'+sgst+'">'+ ''+'</ul>');

            $("#cites").attr("data-block", 'rjud-'+sgst);
            $('#cites').append('<input type="text" id="myInput25" onkeyup="myFunction25()" placeholder="Search..">');
            $('#cites').append('<ul class="listing-blocks" id="expand-listing-rjud-'+sgst+'">'+ ''+'</ul>');

            // Cited In

            $("#caselaws").attr("data-block", 'cCase-'+sgst);
            $('#caselaws').append('<input type="text" id="myInput26" onkeyup="myFunction26()" placeholder="Search..">');
            $('#caselaws').append('<ul class="listing-blocks" id="expand-listing-cCase-'+sgst+'">'+ ''+'</ul>');

            $("#notification1").attr("data-block", 'cNotification-'+sgst);
            $('#notification1').append('<input type="text" id="myInput27" onkeyup="myFunction27()" placeholder="Search..">');
            $('#notification1').append('<ul class="listing-blocks" id="expand-listing-cNotification-'+sgst+'">'+ ''+'</ul>');

            $("#circular1").attr("data-block", 'cCircular-'+sgst);
            $('#circular1').append('<input type="text" id="myInput28" onkeyup="myFunction28()" placeholder="Search..">');
            $('#circular1').append('<ul class="listing-blocks" id="expand-listing-cCircular-'+sgst+'">'+ ''+'</ul>');

            $("#section1").attr("data-block", 'cSection-'+sgst);
            $('#section1').append('<input type="text" id="myInput29" onkeyup="myFunction29()" placeholder="Search..">');
            $('#section1').append('<ul class="listing-blocks" id="expand-listing-cSection-'+sgst+'">'+ ''+'</ul>');

            $("#rule1").attr("data-block", 'cRule-'+sgst);
            $('#rule1').append('<input type="text" id="myInput30" onkeyup="myFunction30()" placeholder="Search..">');
            $('#rule1').append('<ul class="listing-blocks" id="expand-listing-cRule-'+sgst+'">'+ ''+'</ul>');
        });
    </script>
    <script>
        // SEARCH FILTER SECTION RECORDS

        // CGST RECORDS

        function myFunction01() {
          // Declare variables
          var input, filter, ul, li, a, i, txtValue;
          input = document.getElementById('myInput01');
          filter = input.value.toUpperCase();
          ul = document.getElementById("explorer-listing-sections-cgst");
          li = ul.getElementsByTagName('li');

          // Loop through all list items, and hide those who don't match the search query
          for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByTagName("a")[0];
            txtValue = a.textContent || a.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
              li[i].style.display = "";
            } else {
              li[i].style.display = "none";
            }
          }
        }

        function myFunction02() {
          // Declare variables
          var input, filter, ul, li, a, i, txtValue;
          input = document.getElementById('myInput02');
          filter = input.value.toUpperCase();
          ul = document.getElementById("explorer-listing-rules-cgst");
          li = ul.getElementsByTagName('li');

          // Loop through all list items, and hide those who don't match the search query
          for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByTagName("a")[0];
            txtValue = a.textContent || a.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
              li[i].style.display = "";
            } else {
              li[i].style.display = "none";
            }
          }
        }

        function myFunction03() {
          // Declare variables
          var input, filter, ul, li, a, i, txtValue;
          input = document.getElementById('myInput03');
          filter = input.value.toUpperCase();
          ul = document.getElementById("explorer-listing-notifications-cgst");
          li = ul.getElementsByTagName('li');

          // Loop through all list items, and hide those who don't match the search query
          for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByTagName("a")[0];
            txtValue = a.textContent || a.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
              li[i].style.display = "";
            } else {
              li[i].style.display = "none";
            }
          }
        }

        function myFunction04() {
          // Declare variables
          var input, filter, ul, li, a, i, txtValue;
          input = document.getElementById('myInput04');
          filter = input.value.toUpperCase();
          ul = document.getElementById("explorer-listing-circulars-cgst");
          li = ul.getElementsByTagName('li');

          // Loop through all list items, and hide those who don't match the search query
          for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByTagName("a")[0];
            txtValue = a.textContent || a.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
              li[i].style.display = "";
            } else {
              li[i].style.display = "none";
            }
          }
        }

        // IGST RECORDS

        function myFunction05() {
          // Declare variables
          var input, filter, ul, li, a, i, txtValue;
          input = document.getElementById('myInput05');
          filter = input.value.toUpperCase();
          ul = document.getElementById("explorer-listing-sections-igst");
          li = ul.getElementsByTagName('li');

          // Loop through all list items, and hide those who don't match the search query
          for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByTagName("a")[0];
            txtValue = a.textContent || a.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
              li[i].style.display = "";
            } else {
              li[i].style.display = "none";
            }
          }
        }

        function myFunction06() {
          // Declare variables
          var input, filter, ul, li, a, i, txtValue;
          input = document.getElementById('myInput06');
          filter = input.value.toUpperCase();
          ul = document.getElementById("explorer-listing-rules-igst");
          li = ul.getElementsByTagName('li');

          // Loop through all list items, and hide those who don't match the search query
          for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByTagName("a")[0];
            txtValue = a.textContent || a.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
              li[i].style.display = "";
            } else {
              li[i].style.display = "none";
            }
          }
        }

        function myFunction07() {
          // Declare variables
          var input, filter, ul, li, a, i, txtValue;
          input = document.getElementById('myInput07');
          filter = input.value.toUpperCase();
          ul = document.getElementById("explorer-listing-notifications-igst");
          li = ul.getElementsByTagName('li');

          // Loop through all list items, and hide those who don't match the search query
          for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByTagName("a")[0];
            txtValue = a.textContent || a.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
              li[i].style.display = "";
            } else {
              li[i].style.display = "none";
            }
          }
        }

        function myFunction08() {
          // Declare variables
          var input, filter, ul, li, a, i, txtValue;
          input = document.getElementById('myInput08');
          filter = input.value.toUpperCase();
          ul = document.getElementById("explorer-listing-circulars-igst");
          li = ul.getElementsByTagName('li');

          // Loop through all list items, and hide those who don't match the search query
          for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByTagName("a")[0];
            txtValue = a.textContent || a.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
              li[i].style.display = "";
            } else {
              li[i].style.display = "none";
            }
          }
        }

        // SGST RECORDS

        function myFunction09() {
          // Declare variables
          var input, filter, ul, li, a, i, txtValue;
          input = document.getElementById('myInput09');
          filter = input.value.toUpperCase();
          ul = document.getElementById("explorer-listing-sections-sgst");
          li = ul.getElementsByTagName('li');

          // Loop through all list items, and hide those who don't match the search query
          for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByTagName("a")[0];
            txtValue = a.textContent || a.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
              li[i].style.display = "";
            } else {
              li[i].style.display = "none";
            }
          }
        }

        function myFunction010() {
          // Declare variables
          var input, filter, ul, li, a, i, txtValue;
          input = document.getElementById('myInput010');
          filter = input.value.toUpperCase();
          ul = document.getElementById("explorer-listing-rules-sgst");
          li = ul.getElementsByTagName('li');

          // Loop through all list items, and hide those who don't match the search query
          for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByTagName("a")[0];
            txtValue = a.textContent || a.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
              li[i].style.display = "";
            } else {
              li[i].style.display = "none";
            }
          }
        }

        function myFunction011() {
          // Declare variables
          var input, filter, ul, li, a, i, txtValue;
          input = document.getElementById('myInput011');
          filter = input.value.toUpperCase();
          ul = document.getElementById("explorer-listing-notifications-sgst");
          li = ul.getElementsByTagName('li');

          // Loop through all list items, and hide those who don't match the search query
          for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByTagName("a")[0];
            txtValue = a.textContent || a.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
              li[i].style.display = "";
            } else {
              li[i].style.display = "none";
            }
          }
        }

        function myFunction012() {
          // Declare variables
          var input, filter, ul, li, a, i, txtValue;
          input = document.getElementById('myInput012');
          filter = input.value.toUpperCase();
          ul = document.getElementById("explorer-listing-circulars-sgst");
          li = ul.getElementsByTagName('li');

          // Loop through all list items, and hide those who don't match the search query
          for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByTagName("a")[0];
            txtValue = a.textContent || a.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
              li[i].style.display = "";
            } else {
              li[i].style.display = "none";
            }
          }
        }

        // SEARCH FILTER SECTION RELATED RECORDS

        // CGST RECORDS

        function myFunction() {
          // Declare variables
          var input, filter, ul, li, a, i, txtValue;
          input = document.getElementById('myInput');
          filter = input.value.toUpperCase();
          ul = document.getElementById("expand-listing-rsect-cgst");
          li = ul.getElementsByTagName('li');

          // Loop through all list items, and hide those who don't match the search query
          for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByTagName("a")[0];
            txtValue = a.textContent || a.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
              li[i].style.display = "";
            } else {
              li[i].style.display = "none";
            }
          }
        }

        function myFunction2() {
          // Declare variables
          var input, filter, ul, li, a, i, txtValue;
          input = document.getElementById('myInput2');
          filter = input.value.toUpperCase();
          ul = document.getElementById("expand-listing-rrul-cgst");
          li = ul.getElementsByTagName('li');

          // Loop through all list items, and hide those who don't match the search query
          for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByTagName("a")[0];
            txtValue = a.textContent || a.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
              li[i].style.display = "";
            } else {
              li[i].style.display = "none";
            }
          }
        }

        function myFunction3() {
          // Declare variables
          var input, filter, ul, li, a, i, txtValue;
          input = document.getElementById('myInput3');
          filter = input.value.toUpperCase();
          ul = document.getElementById("expand-listing-rnoti-cgst");
          li = ul.getElementsByTagName('li');

          // Loop through all list items, and hide those who don't match the search query
          for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByTagName("a")[0];
            txtValue = a.textContent || a.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
              li[i].style.display = "";
            } else {
              li[i].style.display = "none";
            }
          }
        }

        function myFunction4() {
          // Declare variables
          var input, filter, ul, li, a, i, txtValue;
          input = document.getElementById('myInput4');
          filter = input.value.toUpperCase();
          ul = document.getElementById("expand-listing-rcir-cgst");
          li = ul.getElementsByTagName('li');

          // Loop through all list items, and hide those who don't match the search query
          for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByTagName("a")[0];
            txtValue = a.textContent || a.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
              li[i].style.display = "";
            } else {
              li[i].style.display = "none";
            }
          }
        }

        function myFunction5() {
          // Declare variables
          var input, filter, ul, li, a, i, txtValue;
          input = document.getElementById('myInput5');
          filter = input.value.toUpperCase();
          ul = document.getElementById("expand-listing-rjud-cgst");
          li = ul.getElementsByTagName('li');

          // Loop through all list items, and hide those who don't match the search query
          for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByTagName("a")[0];
            txtValue = a.textContent || a.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
              li[i].style.display = "";
            } else {
              li[i].style.display = "none";
            }
          }
        }

        function myFunction6() {
          // Declare variables
          var input, filter, ul, li, a, i, txtValue;
          input = document.getElementById('myInput6');
          filter = input.value.toUpperCase();
          ul = document.getElementById("expand-listing-cCase-cgst");
          li = ul.getElementsByTagName('li');

          // Loop through all list items, and hide those who don't match the search query
          for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByTagName("a")[0];
            txtValue = a.textContent || a.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
              li[i].style.display = "";
            } else {
              li[i].style.display = "none";
            }
          }
        }

        function myFunction7() {
          // Declare variables
          var input, filter, ul, li, a, i, txtValue;
          input = document.getElementById('myInput7');
          filter = input.value.toUpperCase();
          ul = document.getElementById("expand-listing-cNotification-cgst");
          li = ul.getElementsByTagName('li');

          // Loop through all list items, and hide those who don't match the search query
          for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByTagName("a")[0];
            txtValue = a.textContent || a.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
              li[i].style.display = "";
            } else {
              li[i].style.display = "none";
            }
          }
        }

        function myFunction8() {
          // Declare variables
          var input, filter, ul, li, a, i, txtValue;
          input = document.getElementById('myInput8');
          filter = input.value.toUpperCase();
          ul = document.getElementById("expand-listing-cCircular-cgst");
          li = ul.getElementsByTagName('li');

          // Loop through all list items, and hide those who don't match the search query
          for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByTagName("a")[0];
            txtValue = a.textContent || a.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
              li[i].style.display = "";
            } else {
              li[i].style.display = "none";
            }
          }
        }

        function myFunction9() {
          // Declare variables
          var input, filter, ul, li, a, i, txtValue;
          input = document.getElementById('myInput9');
          filter = input.value.toUpperCase();
          ul = document.getElementById("expand-listing-cSection-cgst");
          li = ul.getElementsByTagName('li');

          // Loop through all list items, and hide those who don't match the search query
          for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByTagName("a")[0];
            txtValue = a.textContent || a.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
              li[i].style.display = "";
            } else {
              li[i].style.display = "none";
            }
          }
        }

        function myFunction10() {
          // Declare variables
          var input, filter, ul, li, a, i, txtValue;
          input = document.getElementById('myInput10');
          filter = input.value.toUpperCase();
          ul = document.getElementById("expand-listing-cRule-cgst");
          li = ul.getElementsByTagName('li');

          // Loop through all list items, and hide those who don't match the search query
          for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByTagName("a")[0];
            txtValue = a.textContent || a.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
              li[i].style.display = "";
            } else {
              li[i].style.display = "none";
            }
          }
        }

        // IGST RECORDS

        function myFunction11() {
          // Declare variables
          var input, filter, ul, li, a, i, txtValue;
          input = document.getElementById('myInput11');
          filter = input.value.toUpperCase();
          ul = document.getElementById("expand-listing-rsect-igst");
          li = ul.getElementsByTagName('li');

          // Loop through all list items, and hide those who don't match the search query
          for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByTagName("a")[0];
            txtValue = a.textContent || a.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
              li[i].style.display = "";
            } else {
              li[i].style.display = "none";
            }
          }
        }

        function myFunction12() {
          // Declare variables
          var input, filter, ul, li, a, i, txtValue;
          input = document.getElementById('myInput12');
          filter = input.value.toUpperCase();
          ul = document.getElementById("expand-listing-rrul-igst");
          li = ul.getElementsByTagName('li');

          // Loop through all list items, and hide those who don't match the search query
          for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByTagName("a")[0];
            txtValue = a.textContent || a.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
              li[i].style.display = "";
            } else {
              li[i].style.display = "none";
            }
          }
        }

        function myFunction13() {
          // Declare variables
          var input, filter, ul, li, a, i, txtValue;
          input = document.getElementById('myInput13');
          filter = input.value.toUpperCase();
          ul = document.getElementById("expand-listing-rnoti-igst");
          li = ul.getElementsByTagName('li');

          // Loop through all list items, and hide those who don't match the search query
          for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByTagName("a")[0];
            txtValue = a.textContent || a.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
              li[i].style.display = "";
            } else {
              li[i].style.display = "none";
            }
          }
        }

        function myFunction14() {
          // Declare variables
          var input, filter, ul, li, a, i, txtValue;
          input = document.getElementById('myInput14');
          filter = input.value.toUpperCase();
          ul = document.getElementById("expand-listing-rcir-igst");
          li = ul.getElementsByTagName('li');

          // Loop through all list items, and hide those who don't match the search query
          for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByTagName("a")[0];
            txtValue = a.textContent || a.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
              li[i].style.display = "";
            } else {
              li[i].style.display = "none";
            }
          }
        }

        function myFunction15() {
          // Declare variables
          var input, filter, ul, li, a, i, txtValue;
          input = document.getElementById('myInput15');
          filter = input.value.toUpperCase();
          ul = document.getElementById("expand-listing-rjud-igst");
          li = ul.getElementsByTagName('li');

          // Loop through all list items, and hide those who don't match the search query
          for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByTagName("a")[0];
            txtValue = a.textContent || a.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
              li[i].style.display = "";
            } else {
              li[i].style.display = "none";
            }
          }
        }

        function myFunction16() {
          // Declare variables
          var input, filter, ul, li, a, i, txtValue;
          input = document.getElementById('myInput16');
          filter = input.value.toUpperCase();
          ul = document.getElementById("expand-listing-cCase-igst");
          li = ul.getElementsByTagName('li');

          // Loop through all list items, and hide those who don't match the search query
          for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByTagName("a")[0];
            txtValue = a.textContent || a.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
              li[i].style.display = "";
            } else {
              li[i].style.display = "none";
            }
          }
        }

        function myFunction17() {
          // Declare variables
          var input, filter, ul, li, a, i, txtValue;
          input = document.getElementById('myInput17');
          filter = input.value.toUpperCase();
          ul = document.getElementById("expand-listing-cNotification-igst");
          li = ul.getElementsByTagName('li');

          // Loop through all list items, and hide those who don't match the search query
          for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByTagName("a")[0];
            txtValue = a.textContent || a.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
              li[i].style.display = "";
            } else {
              li[i].style.display = "none";
            }
          }
        }

        function myFunction18() {
          // Declare variables
          var input, filter, ul, li, a, i, txtValue;
          input = document.getElementById('myInput18');
          filter = input.value.toUpperCase();
          ul = document.getElementById("expand-listing-cCircular-igst");
          li = ul.getElementsByTagName('li');

          // Loop through all list items, and hide those who don't match the search query
          for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByTagName("a")[0];
            txtValue = a.textContent || a.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
              li[i].style.display = "";
            } else {
              li[i].style.display = "none";
            }
          }
        }

        function myFunction19() {
          // Declare variables
          var input, filter, ul, li, a, i, txtValue;
          input = document.getElementById('myInput19');
          filter = input.value.toUpperCase();
          ul = document.getElementById("expand-listing-cSection-igst");
          li = ul.getElementsByTagName('li');

          // Loop through all list items, and hide those who don't match the search query
          for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByTagName("a")[0];
            txtValue = a.textContent || a.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
              li[i].style.display = "";
            } else {
              li[i].style.display = "none";
            }
          }
        }

        function myFunction20() {
          // Declare variables
          var input, filter, ul, li, a, i, txtValue;
          input = document.getElementById('myInput20');
          filter = input.value.toUpperCase();
          ul = document.getElementById("expand-listing-cRule-igst");
          li = ul.getElementsByTagName('li');

          // Loop through all list items, and hide those who don't match the search query
          for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByTagName("a")[0];
            txtValue = a.textContent || a.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
              li[i].style.display = "";
            } else {
              li[i].style.display = "none";
            }
          }
        }

        // SGST RECORDS

        function myFunction21() {
          // Declare variables
          var input, filter, ul, li, a, i, txtValue;
          input = document.getElementById('myInput21');
          filter = input.value.toUpperCase();
          ul = document.getElementById("expand-listing-rsect-sgst");
          li = ul.getElementsByTagName('li');

          // Loop through all list items, and hide those who don't match the search query
          for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByTagName("a")[0];
            txtValue = a.textContent || a.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
              li[i].style.display = "";
            } else {
              li[i].style.display = "none";
            }
          }
        }

        function myFunction22() {
          // Declare variables
          var input, filter, ul, li, a, i, txtValue;
          input = document.getElementById('myInput22');
          filter = input.value.toUpperCase();
          ul = document.getElementById("expand-listing-rrul-sgst");
          li = ul.getElementsByTagName('li');

          // Loop through all list items, and hide those who don't match the search query
          for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByTagName("a")[0];
            txtValue = a.textContent || a.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
              li[i].style.display = "";
            } else {
              li[i].style.display = "none";
            }
          }
        }

        function myFunction23() {
          // Declare variables
          var input, filter, ul, li, a, i, txtValue;
          input = document.getElementById('myInput23');
          filter = input.value.toUpperCase();
          ul = document.getElementById("expand-listing-rnoti-sgst");
          li = ul.getElementsByTagName('li');

          // Loop through all list items, and hide those who don't match the search query
          for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByTagName("a")[0];
            txtValue = a.textContent || a.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
              li[i].style.display = "";
            } else {
              li[i].style.display = "none";
            }
          }
        }

        function myFunction24() {
          // Declare variables
          var input, filter, ul, li, a, i, txtValue;
          input = document.getElementById('myInput24');
          filter = input.value.toUpperCase();
          ul = document.getElementById("expand-listing-rcir-sgst");
          li = ul.getElementsByTagName('li');

          // Loop through all list items, and hide those who don't match the search query
          for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByTagName("a")[0];
            txtValue = a.textContent || a.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
              li[i].style.display = "";
            } else {
              li[i].style.display = "none";
            }
          }
        }

        function myFunction25() {
          // Declare variables
          var input, filter, ul, li, a, i, txtValue;
          input = document.getElementById('myInput25');
          filter = input.value.toUpperCase();
          ul = document.getElementById("expand-listing-rjud-sgst");
          li = ul.getElementsByTagName('li');

          // Loop through all list items, and hide those who don't match the search query
          for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByTagName("a")[0];
            txtValue = a.textContent || a.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
              li[i].style.display = "";
            } else {
              li[i].style.display = "none";
            }
          }
        }

        function myFunction26() {
          // Declare variables
          var input, filter, ul, li, a, i, txtValue;
          input = document.getElementById('myInput26');
          filter = input.value.toUpperCase();
          ul = document.getElementById("expand-listing-cCase-sgst");
          li = ul.getElementsByTagName('li');

          // Loop through all list items, and hide those who don't match the search query
          for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByTagName("a")[0];
            txtValue = a.textContent || a.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
              li[i].style.display = "";
            } else {
              li[i].style.display = "none";
            }
          }
        }

        function myFunction27() {
          // Declare variables
          var input, filter, ul, li, a, i, txtValue;
          input = document.getElementById('myInput27');
          filter = input.value.toUpperCase();
          ul = document.getElementById("expand-listing-cNotification-sgst");
          li = ul.getElementsByTagName('li');

          // Loop through all list items, and hide those who don't match the search query
          for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByTagName("a")[0];
            txtValue = a.textContent || a.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
              li[i].style.display = "";
            } else {
              li[i].style.display = "none";
            }
          }
        }

        function myFunction28() {
          // Declare variables
          var input, filter, ul, li, a, i, txtValue;
          input = document.getElementById('myInput28');
          filter = input.value.toUpperCase();
          ul = document.getElementById("expand-listing-cCircular-sgst");
          li = ul.getElementsByTagName('li');

          // Loop through all list items, and hide those who don't match the search query
          for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByTagName("a")[0];
            txtValue = a.textContent || a.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
              li[i].style.display = "";
            } else {
              li[i].style.display = "none";
            }
          }
        }

        function myFunction29() {
          // Declare variables
          var input, filter, ul, li, a, i, txtValue;
          input = document.getElementById('myInput29');
          filter = input.value.toUpperCase();
          ul = document.getElementById("expand-listing-cSection-sgst");
          li = ul.getElementsByTagName('li');

          // Loop through all list items, and hide those who don't match the search query
          for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByTagName("a")[0];
            txtValue = a.textContent || a.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
              li[i].style.display = "";
            } else {
              li[i].style.display = "none";
            }
          }
        }

        function myFunction30() {
          // Declare variables
          var input, filter, ul, li, a, i, txtValue;
          input = document.getElementById('myInput30');
          filter = input.value.toUpperCase();
          ul = document.getElementById("expand-listing-cRule-sgst");
          li = ul.getElementsByTagName('li');

          // Loop through all list items, and hide those who don't match the search query
          for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByTagName("a")[0];
            txtValue = a.textContent || a.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
              li[i].style.display = "";
            } else {
              li[i].style.display = "none";
            }
          }
        }
    </script>
</div>
<script src="<?php echo $getBaseUrl; ?>js/custom.js?ver=160720200100"></script>