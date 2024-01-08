<?php
if (isset($_POST['downloadFile'])) {

    function decrypt_url_new($string) {
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

    $encryptUrl = $_POST['file_path'];
    $filename = decrypt_url_new($encryptUrl);

    $file_extn = strtolower(substr($filename, -3));
    if ($file_extn != 'pdf') {
        $fp = fopen($filename, "r");
        $strContent = fread($fp, filesize($filename));
        fclose($fp);
        $curDate = date('m/d/Y h:i:s a', time());
        $content = "<div style='font-family:Verdana; font-size:8.5pt; padding:5px; border:1px solid #c6bdac; margin:10px; background:#faf8f4; color:#422b03'>Downloaded from www.vatinfoline.com on $curDate </div>" . $strContent;

        $filesize = filesize($filename) + 149;
        header('Content-Disposition: attachment; filename=' . basename($filename));
        //header("Content-Length: " . $filesize);
        echo $content;
        echo "<div style='font-family:Verdana; font-size:8.5pt; padding:5px; border:1px solid #c6bdac; margin:10px; background:#faf8f4; color:#422b03'>Downloaded from www.vatinfoline.com on $curDate </div>";
        exit();
    } else {

        header('Content-Description: File Transfer');
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . basename($filename) . '"');
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filename));
        ob_clean();
        flush();
        readfile($filename);
        exit();
    }
}
?>
<?php
$page = 'showIframe';
include('header.php');
include('mapping_functions.php');
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
    .coi-article-nav-btn-prev, .coi-article-nav-btn-next{
        font-weight: bold;
        font-size: 18px;
        color:orange;
        padding:2px;
    }

    .coi-article-nav-btn-next{
        float:right;
    }
    .coi-article-nav-btn-prev{
        float:left;
    }

    .btn-orange{
        background: linear-gradient(to bottom, #FF9933 0%,#FF5733 100%);
    }

    .btn-orange:hover{
        background: linear-gradient(to bottom, #FF5733 0%,#FF9933 100%);
        box-shadow: inset 1px 1px 1px #FF5733;
    }

    #navigation-left{
        width:20%;float:left;
        font-family:'calibri';
        font-size:14px;
        /*margin-top:25px;*/
        display:table;
    }

    #navigation-left .expanding-blocks{
        /*width:95%;*/
        padding:10px 5px 10px 5px;
        border:1px solid gray;
        background:#e0e0e0;
        /*margin-bottom: 5px;*/
        cursor: pointer;
        font-weight: bold;
        font-size:15px;
        border-bottom:0px;
    }

    /*    #navigation-left .cited-in-block {
            background: #8ba6bf;
            padding:5px 0px;
        }*/
    /*    #navigation-left .cited-in-block .expanding-blocks{
            width:95%;
            margin-left: 2.5%;
        }*/
    #navigation-left .expanding-blocks-header{
        /*        background: #8ba6bf;
                padding:5px 0px;*/
        text-align: left;
        color:#FFF;
        font-weight: bold;
        margin:15px 0 0px 0px;
        /*margin-bottom: 10px;*/
        background-color:#ff7808;
        padding:10px 10px;
    }

    #navigation-left .expanding-blocks .expand{
        width:20px;
        float:right;
    }
    #navigation-left .listing-blocks{
        display:none;
        padding-left:0px;     
        list-style-type:none;
        max-height: 500px;
        overflow: auto;
        /*width: 95%;*/
        border:1px solid gray;
    }
    #navigation-left .listing-blocks li{
        margin:2px 0px;
        border-bottom:1px dashed #ccc;
        padding:3px;

    }

    #navigation-left .listing-blocks li:last-child{
        margin:2px 0px;
        border-bottom:0px;
        padding:3px;

    }

    #navigation-left .listing-blocks li:hover{
        /*background: #CCC; */
    }

    .bordered{
        border: 1px orange solid;
    }

    /* Tooltip */
    #navigation-left .listing-blocks li a:hover{
        color:orange;
        /*font-weight:bold;*/
    }
    #navigation-left .listing-blocks li a{
        font-size:14px;
    }

    #navigation-left .tooltip{
        max-width:500px;
        opacity:1;
    }
    #navigation-left .tooltip > .tooltip-inner {
        background-color: #F1F1f1 !important; 
        color: #000; 
        border: 1px solid green; 
        padding: 5px 10px;
        font-size: 15px;
        max-width: 500px;
        opacity:1 !important;
        text-align:left;
        /*text-transform:;*/
    }
    /*   Tooltip on top 
      #navigation-left .tooltip.top > .tooltip-arrow {
        border-top: 5px solid green;
      }
       Tooltip on bottom 
      #navigation-left .tooltip.bottom > .tooltip-arrow {
        border-bottom: 5px solid blue;
      }
       Tooltip on left 
      #navigation-left .tooltip.left > .tooltip-arrow {
        border-left: 5px solid red;
      }*/
    /* Tooltip on right */
    #navigation-left .tooltip.right > .tooltip-arrow {
        border-right: 5px solid green;
    }
    #navigation-left .border-bottom{
        border:1px solid gray;
    }

    .left-section h1{
        font-size:15px !important;
    }

</style>

<script type="text/javascript">
    var isReloaded = false;
    var calcHeight = function() {
        if (isReloaded) {
            var the_height = document.getElementById('iFramePopupFrame').contentWindow.document.body.scrollHeight + 50;
            document.getElementById('iFramePopupFrame').height = the_height;
//        document.getElementById('navigation-left').height = the_height;
            $('#navigation-left').css('height', the_height + 'px');
            $('.expanding-blocks').click(function() {
                if ($(this).find('.expand').html() == '+') {
                    $('.expand').html('+');
                    $('.listing-blocks').hide();
                    var data_block = $(this).attr('data-block');
                    $('#listing-' + data_block).show();
                    $(this).find('.expand').html('-');
                } else {
                    $('.expand').html('+');
                    $('.listing-blocks').hide();
                }
            });

            $('.listing-blocks a').click(function(e) {
                e.preventDefault();
                e.stopPropagation();
                e.stopImmediatePropagation();
                var linktoopen = $(this).attr('perm-link');

                var linktoOpenNew = $(this).attr('href');
                $('.btn_open_new_window').attr('href', linktoOpenNew);

                $('#iFramePreviewFrame').attr('src', linktoopen);
                var the_height2 = document.getElementById('iFramePreviewFrame').contentWindow.document.body.scrollHeight + 50;
                $('#iFramePreviewFrame').height('580px');
//            iFramePreviewFrame
                $('#recordInfoModal').modal('show');
            });
        } else {
            isReloaded = true;
            document.getElementById('iFramePopupFrame').contentDocument.location.reload(true);
        }
    }
</script>

<?php

function getNextChapterId($currentChapterSEQNo) {
//    echo $currentChapterSEQNo;
    $NextChapterQuery = "select id, chapter_seq_no from coi_chapter where chapter_seq_no = (select min(chapter_seq_no) from coi_chapter where chapter_seq_no > $currentChapterSEQNo)";
    $NextArticleIdResult2 = mysqli_query($GLOBALS['con'],$NextChapterQuery);
    $NextArticleIdRow2 = mysqli_fetch_array($NextArticleIdResult2);
    $nextArticleId2 = $NextArticleIdRow2[0];
    //check if articles exists in the chapter or not.
    if ($nextArticleId2) {
        $NextChapterQuery = "select count(*) from coi_articles where chapter_id = $nextArticleId2";
        $NextArticleIdResult3 = mysqli_query($GLOBALS['con'],$NextChapterQuery);
        $NextArticleIdRow3 = mysqli_fetch_array($NextArticleIdResult3);
        $total_count = $NextArticleIdRow3[0];
        if ($total_count == 0) {
            $nextArticleId2 = getNextChapterId($NextArticleIdRow2[1]);
        }
    }
    return $nextArticleId2;
}

function getPrevChapterId($currentChapterSEQNo) {
    $PrevChapterQuery = "select id,chapter_seq_no from coi_chapter where chapter_seq_no = (select max(chapter_seq_no) from coi_chapter where chapter_seq_no < $currentChapterSEQNo)";
    $PrevArticleIdResult2 = mysqli_query($GLOBALS['con'],$PrevChapterQuery);
    $PrevArticleIdRow2 = mysqli_fetch_array($PrevArticleIdResult2);
    $prevArticleId2 = $PrevArticleIdRow2[0];
    //checking if article exists or not
    if ($prevArticleId2) {
        $prevChapterQuery = "select count(*) from coi_articles where chapter_id = $prevArticleId2";
        $prevArticleIdResult3 = mysqli_query($GLOBALS['con'],$prevChapterQuery);
        $prevArticleIdRow3 = mysqli_fetch_array($prevArticleIdResult3);
        $total_count = $prevArticleIdRow3[0];
        if ($total_count == 0) {
            $prevArticleId2 = getPrevChapterId($PrevArticleIdRow2[1]);
        }
    }

    return $prevArticleId2;
}

function getNextArticleURL($c_article_seq_no, $c_chapter_id, $c_chapter_seq_no) {
//    echo "$c_article_seq_no, $c_chapter_id, $c_chapter_seq_no";die;
    $nextQuery = "select id from coi_articles where article_seq_no = (select min(article_seq_no) from coi_articles where article_seq_no > '$c_article_seq_no' and chapter_id=$c_chapter_id) and chapter_id=$c_chapter_id";

    $NextArticleIdResult = mysqli_query($GLOBALS['con'],$nextQuery);
    $NextArticleIdRow = mysqli_fetch_array($NextArticleIdResult);
    $nextArticleId = $NextArticleIdRow[0];

    if (!$nextArticleId) {
        $nextChapterId = getNextChapterId($c_chapter_seq_no);
        $nextQuery2 = "select id from coi_articles where article_seq_no = (select min(article_seq_no) from coi_articles where chapter_id=($nextChapterId)) and chapter_id = $nextChapterId";

        $NextArticleIdResult2 = mysqli_query($GLOBALS['con'],$nextQuery2);
        $NextArticleIdRow2 = mysqli_fetch_array($NextArticleIdResult2);
        $nextArticleId = $NextArticleIdRow2[0];
    }

    $NextPageUrl = '';

    if ($nextArticleId) {
        $encryptyNextId = base64_encode(base64_encode($nextArticleId));
        $NextPageUrl = 'showiframe?V1Zaa1VsQlJQVDA9=' . $encryptyNextId . '&showCOIarticles';
    }
    return $NextPageUrl;
}

function getPrevArticleURL($c_article_seq_no, $c_chapter_id, $c_chapter_seq_no) {
    $prevQuery = "select id from coi_articles where article_seq_no = (select max(article_seq_no) from coi_articles where article_seq_no < '$c_article_seq_no' and chapter_id = $c_chapter_id) and chapter_id = $c_chapter_id";
//    echo $prevQuery;
    $prevArticleIdResult = mysqli_query($GLOBALS['con'],$prevQuery);
    $prevArticleIdRow = mysqli_fetch_array($prevArticleIdResult);
    $prevArticleId = $prevArticleIdRow[0];
    if (!$prevArticleId) {

        //try for prev chapter
        //get prev chatper with ChapterSEQ No:
        $prevChapterId = getPrevChapterId($c_chapter_seq_no);
        if ($prevChapterId) {
            $prevQuery2 = "select id from coi_articles where article_seq_no = (select max(article_seq_no) from coi_articles where chapter_id = $prevChapterId) and chapter_id = $prevChapterId";
            $prevArticleIdResult2 = mysqli_query($GLOBALS['con'],$prevQuery2);
            $prevArticleIdRow2 = mysqli_fetch_array($prevArticleIdResult2);
            $prevArticleId = $prevArticleIdRow2[0];
        }
    }
    $PrevPageUrl = '';
    if ($prevArticleId) {
        $encryptyPrevId = base64_encode(base64_encode($prevArticleId));
        $PrevPageUrl = 'showiframe?V1Zaa1VsQlJQVDA9=' . $encryptyPrevId . '&showCOIarticles';
    }
    return $PrevPageUrl;
}
?>



<?php if (isset($_GET['page']) && ($_GET['page'] == "video")) {
    ?>



    <!-- left sec start <div class="col-md-16 col-sm-16"> -->

    <div class="col-md-16 col-sm-16 left-section">

        <h1>      	

            <ol class="breadcrumb">

                <li><a href="<?php echo $getBaseUrl; ?>">Home</a></li>

                <li class="active"></li>

            </ol>

        </h1>

        <div class="col-md-16">



            <h2>Highlights of 122nd Constitutional Amendment Bill - CA Bimal Jain</h2>



            <iframe width="560" height="315" src="https://www.youtube.com/embed/Is0QySCmcDc" style="margin:20px auto" frameborder="0" allowfullscreen></iframe>

            <hr />



            <h2>Overview of Dual GST Model - CA Bimal Jain</h2>



            <iframe width="560" height="315" src="https://www.youtube.com/embed/ASuOr5sud94" style="margin:20px auto" frameborder="0" allowfullscreen></iframe>

            <hr />



            <h2>Goods and Services Tax (GST) - Need and Necessity - CA Bimal Jain</h2>



            <iframe width="560" height="315" src="https://www.youtube.com/embed/apM_HDGynoc" style="margin:20px auto" frameborder="0" allowfullscreen></iframe>



        </div> 



    </div>

    <!-- left sec end -->  



    <?php
} else {

    //V1Zaa1VsQlJQVDA9 = echo base64_encode(base64_encode(base64_encode(base64_encode('id'))));

    if (isset($_GET['V1Zaa1VsQlJQVDA9'])) {

        //$encryptID = base64_encode(base64_encode($_GET['id']));

        $decryptID = base64_decode(base64_decode($_GET['V1Zaa1VsQlJQVDA9']));



        if (isset($_GET['page']) && ($_GET['page'] == "recent")) {

            $result = mysqli_query($GLOBALS['con'],"SELECT circular_no, file_path, cir_subject 'summary', sub_prod_id, prod_id FROM recent_data where  data_id = '$decryptID'");
        } else if (isset($_GET['page']) && ($_GET['page'] == "taxvista")) {

            $result = mysqli_query($GLOBALS['con'],"SELECT subject  'circular_no', file_path, summary, article_id 'sub_prod_id'  FROM taxvista where  article_id = '$decryptID'");
        } else if (isset($_GET['page']) && ($_GET['page'] == "features")) {

            $result = mysqli_query($GLOBALS['con'],"SELECT subject  'circular_no', file_path, summary, feature_id 'sub_prod_id' FROM features where  feature_id = '$decryptID'");
        } else if (isset($_GET['page']) && ($_GET['page'] == "articles")) {



            $result = mysqli_query($GLOBALS['con'],"SELECT subject  'circular_no', file_path, summary, article_id 'sub_prod_id'  FROM articles where  article_id = '$decryptID'");
        } else if (isset($_GET['page']) && ($_GET['page'] == "highlights")) {



            $result = mysqli_query($GLOBALS['con'],"SELECT subject  'circular_no', file_path, summary, highlight_id 'sub_prod_id'  FROM highlights where  highlight_id = '$decryptID'");
        } else if (isset($_GET['page']) && ($_GET['page'] == "budgets_analysis")) {



            $result = mysqli_query($GLOBALS['con'],"SELECT subject  'circular_no', file_path, summary, analysis_id 'sub_prod_id'  FROM budgets_analysis where  analysis_id = '$decryptID'");
        } else if (isset($_GET['page']) && ($_GET['page'] == "unionBudget")) {



            $result = mysqli_query($GLOBALS['con'],"SELECT circular_no, file_path, cir_subject 'summary', sub_prod_id FROM budgets_union where  data_id = '$decryptID'");
        } else if (isset($_GET['page']) && ($_GET['page'] == "stateBudget")) {



            $result = mysqli_query($GLOBALS['con'],"SELECT subject 'circular_no', file_path, summary, budget_id 'sub_prod_id'  FROM budgets_state where  budget_id = '$decryptID'");
        } else if (isset($_GET['datatable']) && $_GET['datatable'] != 'undefined') {

            $tableName = 'casedata_' . $_GET['datatable'];


            $result = mysqli_query($GLOBALS['con'],"SELECT circular_no, file_path, cir_subject 'summary', sub_prod_id, prod_id FROM $tableName where  data_id = '$decryptID'");
        } else if (isset($_GET['showCOIarticles'])) {
            //get COI Table to be shown here.
            $q = "SELECT ca.*,cc.chapter_no, cc.chapter_seq_no  FROM coi_articles ca LEFT OUTER JOIN coi_chapter cc on cc.id=ca.chapter_id where ca.id = $decryptID";
            $result = mysqli_query($GLOBALS['con'],$q);
        } else {

            $result = mysqli_query($GLOBALS['con'],"SELECT circular_no, file_path, sub_prod_id, prod_id FROM vat_data where  vat_data_id = '$decryptID'");
        }

        while ($row = mysqli_fetch_array($result)) {


            if (isset($_GET['showCOIarticles'])) {
                $file_path = $row['article_file'];
                $ArticleNumber = $row['article_no'];
                $ChapterNo = $row['chapter_no'];
                $ChapterId = $row['chapter_id'];
                $ChapterSEQNo = $row['chapter_seq_no'];
                $c_article_seq_no = $row['article_seq_no'];
                $article_type = $row['article_type'];

//                print_r($row);
                $destination_Path = '/data/COI/';

                $PrevPageUrl = getPrevArticleURL($c_article_seq_no, $ChapterId, $ChapterSEQNo, $article_type);
                $NextPageUrl = getNextArticleURL($c_article_seq_no, $ChapterId, $ChapterSEQNo, $article_type);
            } else {
                $file_path = $row['file_path'];
            }


            $file_extn = strtolower(substr($file_path, -3));

            $summary = $row['summary'];

            $sub_prod_id = $row['sub_prod_id'];



            $sub_prod_result = mysqli_fetch_assoc(mysqli_query($GLOBALS['con'],"SELECT sub_prod_type FROM sub_product WHERE sub_prod_id = $sub_prod_id  LIMIT 1"));
            ?>

            <!-- left sec start <div class="col-md-16 col-sm-16"> -->

            <div class="col-md-16 col-sm-16 left-section">

                <form method="post" action="" id="formDownload" name="formDownload">

                    <h1>

                        <?php
                        if ((isset($_GET['page']) && $_GET['page'] == "recent") || (isset($_GET['datatable']) && $_GET['datatable'] != 'undefined')) {



                            $getProdName = getDbRecord('product', 'prod_id', $row['prod_id']);

                            $getSubProdName = getDbRecord('sub_product', 'sub_prod_id', $row['sub_prod_id']);

                            echo "<span style='font-size: 16px; color: #666;'>" . $getProdName['prod_name'] . " - " . $getSubProdName['sub_prod_name'] . "</span> | ";
                        } else
                        if (isset($_GET['showCOIarticles'])) {

                            if ($article_type == 'Article') {
                                echo "<span style='font-size: 16px; color: #666;'>Constitution of India</span> |  Part $ChapterNo  - Article $ArticleNumber";
                            } else {
                                echo "<span style='font-size: 16px; color: #666;'>Constitution of India</span> |  $article_type - $ArticleNumber";
                            }
                        }
                        ?>

                        <?php
                        // echo $row['circular_no'];

                        if ($_GET['page'] == "taxvista") {
                            echo substr($row['circular_no'], 0, 100);
                            if ($row['circular_no'] > 100) {
                                echo "...";
                            }
                        } else {
                            echo $row['circular_no'];
                        }
                        ?>

                        <ol class="breadcrumb">

                            <li><a href="<?php echo $getBaseUrl; ?>">Home</a></li>

                            <?php if ($_GET['page'] == "taxvista") { ?>
                                <li class="active">Tax Vista</li>
                            <?php } else { ?>
                                <li class="active"><?php echo $row['circular_no']; ?></li>
                            <?php } ?>

                        </ol>

                    </h1>

                    <div class="col-md-16">

                        <?php
                        if (isset($_GET['page']) && ($_GET['page'] == "articles" || $_GET['page'] == "taxvista" || $_GET['page'] == "highlights" || $_GET['page'] == "features" || $_GET['page'] == "budgets_analysis" || $_GET['page'] == "unionBudget" || $_GET['page'] == "stateBudget")) {
                            ?>



                            <div class="pull-right text-right b-margin-10">

                                <ul class="list-inline" >
                                    <?php
                                    if ($_GET['page'] == "taxvista") {
                                        ?>
                                        <li><a href="#taxvistafeedback" class="ion-email  btn btn-orange open-popup-link" data-effect="mfp-zoom-in" title="Submit your feedback">Share Feedback</a></li>
                                        <?php
                                    }
                                    ?>

                                    <li><a href="#email-this-page" class="ion-email  btn open-popup-link" data-effect="mfp-zoom-in" title="Email this page">Email this page</a></li>

                                    <li><a href="javascript:void(0)" class="ion-printer btn " onclick="printIframe('iFramePopupFrame')" title="Print this page">Print this page </a></li>

                                    <li><button type="submit" class="btn" name="downloadFile" ><i class="ion-android-archive"></i> Download File</button></li>

                                </ul>

                                <?php if ($file_extn != 'pdf') { ?>

                                    <em>To download file as PDF, use PDF writer/printer. </em>

                                <?php } ?>

                            </div>

                            <div class="clear"></div>

                            <input type="hidden" value="<?php echo encrypt_url($file_path); ?>" name="file_path" id="file_path" />

                            <div class="bordered">

                                <iframe onLoad="calcHeight();"  id='iFramePopupFrame' name='iFramePopupFrame' <?php
                                if ($file_extn == 'pdf') {
                                    ?> src='<?php echo $getBaseUrl . $file_path; ?>' <?php
                                        } else {
                                            ?> src='<?php echo "-?ll=" . encrypt_url($getBaseUrl . $file_path); ?>' <?php
                                        }
                                        ?> frameborder='0' allowtransparency='true' scrolling='no' width="100%" <?php
                                        if ($file_extn == 'pdf') {
                                            echo " height='1130' ";
                                        }
                                        ?> ></iframe>



                            </div>

                            <div class="clear"></div>

                            <div class="pull-right text-right t-margin-10">

                                <ul class="list-inline" >

                                    <?php
                                    if ($_GET['page'] == "taxvista") {
                                        ?>
                                        <li><a href="#taxvistafeedback" class="ion-email  btn btn-orange open-popup-link" data-effect="mfp-zoom-in" title="Submit your feedback">Share Feedback</a></li>
                                        <?php
                                    }
                                    ?>

                                    <li><a href="#email-this-page" class="ion-email  btn open-popup-link" data-effect="mfp-zoom-in" title="Email this page">Email this page</a></li>

                                    <li><a href="javascript:void(0)" class="ion-printer btn " onclick="printIframe('iFramePopupFrame')" title="Print this page">Print this page </a></li>

                                    <li><button type="submit" class="btn" name="downloadFile" ><i class="ion-android-archive"></i> Download File</button></li>

                                </ul>

                                <?php if ($file_extn != 'pdf') { ?>

                                    <em>To download file as PDF, use PDF writer/printer. </em>

                                <?php } ?>

                            </div>



                            <?php
                        } else {



                            $moduleAccess = "false";



                            if (isset($_GET['page']) && ($_GET['page'] == "recent")) {

                                $tableName = 'recent_data';



                                $sqlProduct = "SELECT  p.prod_name 'ProductName', p.dbsuffix 'product_suffix' 

			                    FROM $tableName vd, product p

			                    WHERE vd.data_id ='$decryptID'

			                    AND vd.prod_id = p.prod_id";



                                $resultProduct = mysqli_query($GLOBALS['con'],$sqlProduct);
                                $rowProduct = mysqli_fetch_array($resultProduct);

                                $sqlToActualData = "SELECT data_id FROM casedata_" . $rowProduct['product_suffix'] . " WHERE linked_case_id=$decryptID";
                                $resultActuaData = mysqli_query($GLOBALS['con'],$sqlToActualData);
                                $rowActualData = mysqli_fetch_array($resultActuaData);
                                $originalDecryptId = $rowActualData['data_id'];
                            } else if (isset($_GET['datatable']) && $_GET['datatable'] != 'undefined') {

                                $tableName = 'casedata_' . $_GET['datatable'];

                                $sqlProduct = "SELECT  p.prod_name 'ProductName', p.dbsuffix 'product_suffix' 
			                    FROM $tableName vd, product p
			                    WHERE vd.data_id ='$decryptID'
			                    AND vd.prod_id = p.prod_id";

                                $resultProduct = mysqli_query($GLOBALS['con'],$sqlProduct);
                                $rowProduct = mysqli_fetch_array($resultProduct);
                                $originalDecryptId = $decryptID;
                            } else if (isset($_GET['showCOIarticles'])) {
                                $tableName = 'coi_articles';
                                $rowProduct['ProductName'] = 'COI';
                            }



                            if (($_SESSION['vatAccess'] == 'Y') || ($_SESSION['STAccess'] == 'Y') || ($_SESSION['CEAccess'] == 'Y') || ($_SESSION['customsAccess'] == 'Y') || ($_SESSION['gstAccess'] == 'Y')) {



                                if (($rowProduct['ProductName'] == "VAT" || $rowProduct['ProductName'] == "COI" || $rowProduct['ProductName'] == "SGST" || $rowProduct['ProductName'] == "UTGST") && ($_SESSION['vatAccess'] == 'Y')) {



                                    $moduleAccess = "true";
                                } else if (($rowProduct['ProductName'] == "SERVICE TAX" || $rowProduct['ProductName'] == "IGST") && ($_SESSION['STAccess'] == 'Y')) {



                                    $moduleAccess = "true";
                                } else if (($rowProduct['ProductName'] == "CENTRAL EXCISE" || $rowProduct['ProductName'] == "CGST") && ($_SESSION['CEAccess'] == 'Y')) {



                                    $moduleAccess = "true";
                                } else if (($rowProduct['ProductName'] == "CUSTOMS" || $rowProduct['ProductName'] == "DGFT") && ($_SESSION['customsAccess'] == 'Y')) {



                                    $moduleAccess = "true";
                                } else if (($rowProduct['ProductName'] == "GOODS & SERVICES TAX") && ($_SESSION['gstAccess'] == 'Y')) {



                                    $moduleAccess = "true";
                                }
                            }





                            if (isLogeedIn()) {



                                if ($_SESSION["userStatus"] == "expired") {



                                    include('expiredUserError.php');
                                } else if ($moduleAccess == "false" && $rowProduct['ProductName'] != "") {



                                    include('invalidModuleAccess.php');
                                } else {
                                    ?>

                                    <?php
                                    if ($sub_prod_result['sub_prod_type'] != 'Judgements') {

                                        echo '<p class="data-summary">' . $summary . '</p>';
                                    }
                                    ?>

                                    <div class="pull-right text-right b-margin-10">

                                        <ul class="list-inline" >

                                            <li><a href="#email-this-page" class="ion-email  btn open-popup-link" data-effect="mfp-zoom-in" title="Email this page">Email this page</a></li>

                                            <li><a href="javascript:void(0)" class="ion-printer btn " onclick="printIframe('iFramePopupFrame')" title="Print this page">Print this page </a></li>

                                            <li><button type="submit" class="btn" name="downloadFile" ><i class="ion-android-archive"></i> Download File</button></li>

                                        </ul>

                                        <?php if ($file_extn != 'pdf') { ?>

                                            <em>To download file as PDF, use PDF writer/printer. </em>

                                        <?php } ?>

                                    </div>

                                    <div class="clear"></div>
                                    <?php
                                    $bordered_width = "100%";
//                                    echo $rowProduct['ProductName'];die;
                                    if (isset($rowProduct['ProductName']) && $rowProduct['ProductName'] != '' && $rowProduct['ProductName'] != 'COI') {
                                        $similar_cases = getSimilarCaseLaws($originalDecryptId, $rowProduct['product_suffix']);
                                        // echo "<pre>";
                                        // print_r($similar_cases);
                                        // die;
                                        // echo $decryptID, $rowProduct['product_suffix'];die;

                                        $mapping_data = getMappingInfoByDataId($originalDecryptId, $rowProduct['product_suffix']);
                                        $citeIn = getCitedIn($originalDecryptId, $rowProduct['product_suffix']);
                                        $section_count = count($mapping_data['Acts']);
                                        $rule_count = count($mapping_data['Rules']);
                                        $notifications_count = count($mapping_data['Notifications']);
                                        $ciculars_count = count($mapping_data['Circular']);
                                        $cites_count = count($mapping_data['Judgements']);
                                        $citedin_count = count($citeIn);
                                        $bordered_width = "80%";
                                        ?>

                                        <div id="navigation-left">
                                            <div class="expanding-blocks-header" data-block='citedin'>VIEW RELATED RECORDS</div>
                                            <div class="expanding-blocks" data-block='section'>Section (<?php echo $section_count; ?>)<span class="expand">+</span></div>
                                            <?php
                                            if ($section_count > 0) {
                                                echo "<ul id='listing-section' class='listing-blocks'>";
                                                foreach ($mapping_data['Acts'] as $circular_map) {
                                                    echo "<li>";
                                                    if ($circular_map['file_ext'] == 'pdf') {
                                                        $linkToShow = $getBaseUrl . $circular_map['file_link'];
                                                    } else {
                                                        $linkToShow = "-?l=" . encrypt_url($getBaseUrl . $circular_map['file_link']);
                                                    }
                                                    echo "<a data-toggle='tooltip' href='" . $getBaseUrl . $circular_map['perm_link'] . "' data-placement='right' title='" . $circular_map['title'] . "' perm-link='$linkToShow'>" . $circular_map['display_name'] . " (" . $circular_map['prod_name'] . ") " . "</a>";
                                                    echo "</li>";
                                                }
                                                echo "</ul>";
                                            }
                                            ?>
                                            <div class="expanding-blocks" data-block='rule'>Rules (<?php echo $rule_count; ?>)<span class="expand">+</span></div>
                                            <?php
                                            if ($rule_count > 0) {
                                                echo "<ul id='listing-rule' class='listing-blocks'>";
                                                foreach ($mapping_data['Rules'] as $circular_map) {
                                                    echo "<li>";
                                                    if ($circular_map['file_ext'] == 'pdf') {
                                                        $linkToShow = $getBaseUrl . $circular_map['file_link'];
                                                    } else {
                                                        $linkToShow = "-?l=" . encrypt_url($getBaseUrl . $circular_map['file_link']);
                                                    }
                                                    echo "<a data-toggle='tooltip' href='" . $getBaseUrl . $circular_map['perm_link'] . "' data-placement='right' title='" . $circular_map['title'] . "' perm-link='$linkToShow'>" . $circular_map['display_name'] . " (" . $circular_map['prod_name'] . ") " . "</a>";
                                                    echo "</li>";
                                                }
                                                echo "</ul>";
                                            }
                                            ?>
                                            <div class="expanding-blocks" data-block='notification'>Notifications (<?php echo $notifications_count; ?>) <span class="expand">+</span></div>
                                            <?php
                                            if ($notifications_count > 0) {
                                                echo "<ul id='listing-notification' class='listing-blocks'>";
                                                foreach ($mapping_data['Notifications'] as $circular_map) {
                                                    echo "<li>";
                                                    if ($circular_map['file_ext'] == 'pdf') {
                                                        $linkToShow = $getBaseUrl . $circular_map['file_link'];
                                                    } else {
                                                        $linkToShow = "-?l=" . encrypt_url($getBaseUrl . $circular_map['file_link']);
                                                    }
                                                    echo "<a data-toggle='tooltip' href='" . $getBaseUrl . $circular_map['perm_link'] . "' data-placement='right' title='" . $circular_map['title'] . "' perm-link='$linkToShow'>" . $circular_map['display_name'] . "</a>";
                                                    echo "</li>";
                                                }
                                                echo "</ul>";
                                            }
                                            ?>
                                            <div class="expanding-blocks" data-block='circular'>Circular /Order/ROD (<?php echo $ciculars_count; ?>)<span class="expand">+</span></div>
                                            <?php
                                            if ($ciculars_count > 0) {
                                                echo "<ul id='listing-circular' class='listing-blocks'>";
                                                foreach ($mapping_data['Circular'] as $circular_map) {
                                                    echo "<li>";
                                                    if ($circular_map['file_ext'] == 'pdf') {
                                                        $linkToShow = $getBaseUrl . $circular_map['file_link'];
                                                    } else {
                                                        $linkToShow = "-?l=" . encrypt_url($getBaseUrl . $circular_map['file_link']);
                                                    }
                                                    echo "<a data-toggle='tooltip' href='" . $getBaseUrl . $circular_map['perm_link'] . "' data-placement='right' title='" . $circular_map['title'] . "' perm-link='$linkToShow'>" . $circular_map['display_name'] . "</a>";
                                                    echo "</li>";
                                                }
                                                echo "</ul>";
                                            }
                                            ?>
                                            <div class="expanding-blocks border-bottom" data-block='cites'>Cites (<?php echo $cites_count; ?>) <span class="expand">+</span></div>
                                            <?php
                                            if ($cites_count > 0) {
                                                echo "<ul id='listing-cites' class='listing-blocks'>";
                                                foreach ($mapping_data['Judgements'] as $judgement_map) {
                                                    echo "<li>";
                                                    if ($judgement_map['file_ext'] == 'pdf') {
                                                        $linkToShow = $getBaseUrl . $judgement_map['file_link'];
                                                    } else {
                                                        $linkToShow = "-?l=" . encrypt_url($getBaseUrl . $judgement_map['file_link']);
                                                    }
                                                    echo "<a data-toggle='tooltip' href='" . $getBaseUrl . $judgement_map['perm_link'] . "'  data-placement='right' title='" . $judgement_map['title'] . "' perm-link='$linkToShow'>" . $judgement_map['display_name'] . "</a>";
                                                    echo "</li>";
                                                }
                                                echo "</ul>";
                                            }
                                            ?>
                                            <div class='cited-in-block'>
                                                <div class="expanding-blocks-header" data-block='citedin'>CITED IN</div>
                                                <?php
                                                $citedin_count = 10;
                                                if ($citedin_count > 0) {
                                                    ?>
                                                    <div class="expanding-blocks" data-block='citedin-judgements'>Caselaws (<?php echo count($citeIn['Case']); ?>)<span class="expand">+</span></div>
                                                    <?php
                                                    if ($citedin_count > 0) {
                                                        echo "<ul id='listing-citedin-judgements' class='listing-blocks'>";
                                                        foreach ($citeIn['Case'] as $judgement_map) {
                                                            echo "<li>";
                                                            if ($judgement_map['file_ext'] == 'pdf') {
                                                                $linkToShow = $getBaseUrl . $judgement_map['file_link'];
                                                            } else {
                                                                $linkToShow = "-?l=" . encrypt_url($getBaseUrl . $judgement_map['file_link']);
                                                            }
                                                            echo "<a data-toggle='tooltip' href='" . $getBaseUrl . $judgement_map['perm_link'] . "' data-placement='right' title='" . $judgement_map['title'] . "' perm-link='$linkToShow'>" . $judgement_map['display_name'] . "</a>";
                                                            echo "</li>";
                                                        }
                                                        echo "</ul>";
                                                    }
                                                    ?>
                                                    <div class="expanding-blocks" data-block='citedin-notifications'>Notifications (<?php echo count($citeIn['Notification']); ?>)<span class="expand">+</span></div>
                                                    <?php
                                                    if ($citedin_count > 0) {
                                                        echo "<ul id='listing-citedin-notifications' class='listing-blocks'>";
                                                        foreach ($citeIn['Notification'] as $judgement_map) {
                                                            echo "<li>";
                                                            if ($judgement_map['file_ext'] == 'pdf') {
                                                                $linkToShow = $getBaseUrl . $judgement_map['file_link'];
                                                            } else {
                                                                $linkToShow = "-?l=" . encrypt_url($getBaseUrl . $judgement_map['file_link']);
                                                            }
                                                            echo "<a data-toggle='tooltip' href='" . $getBaseUrl . $judgement_map['perm_link'] . "' data-placement='right' title='" . $judgement_map['title'] . "' perm-link='$linkToShow'>" . $judgement_map['display_name'] . "</a>";
                                                            echo "</li>";
                                                        }
                                                        echo "</ul>";
                                                    }
                                                    ?>
                                                    <div class="expanding-blocks border-bottom" data-block='citedin-circular'>Circular /Order/ROD (<?php echo count($citeIn['Circular']); ?>)<span class="expand">+</span></div>
                                                    <?php
                                                    if ($citedin_count > 0) {
                                                        echo "<ul id='listing-citedin-circular' class='listing-blocks'>";
                                                        foreach ($citeIn['Circular'] as $judgement_map) {
                                                            echo "<li>";
                                                            if ($judgement_map['file_ext'] == 'pdf') {
                                                                $linkToShow = $getBaseUrl . $judgement_map['file_link'];
                                                            } else {
                                                                $linkToShow = "-?l=" . encrypt_url($getBaseUrl . $judgement_map['file_link']);
                                                            }
                                                            echo "<a data-toggle='tooltip' href='" . $getBaseUrl . $judgement_map['perm_link'] . "' data-placement='right' title='" . $judgement_map['title'] . "' perm-link='$linkToShow'>" . $judgement_map['display_name'] . "</a>";
                                                            echo "</li>";
                                                        }
                                                        echo "</ul>";
                                                    }
                                                    ?>

                                                    <div class="expanding-blocks border-bottom" data-block='citedin-section'>Sections (<?php echo count($citeIn['Section']); ?>)<span class="expand">+</span></div>
                                                    <?php
                                                    if ($citedin_count > 0) {
                                                        echo "<ul id='listing-citedin-section' class='listing-blocks'>";
                                                        foreach ($citeIn['Section'] as $judgement_map) {
                                                            echo "<li>";
                                                            if ($judgement_map['file_ext'] == 'pdf') {
                                                                $linkToShow = $getBaseUrl . $judgement_map['file_link'];
                                                            } else {
                                                                $linkToShow = "-?l=" . encrypt_url($getBaseUrl . $judgement_map['file_link']);
                                                            }
                                                            echo "<a data-toggle='tooltip' href='" . $getBaseUrl . $judgement_map['perm_link'] . "' data-placement='right' title='" . $judgement_map['title'] . "' perm-link='$linkToShow'>" . $judgement_map['display_name'] . " (" . $judgement_map['prod_name'] . ") " . "</a>";
                                                            echo "</li>";
                                                        }
                                                        echo "</ul>";
                                                    }
                                                    ?>
                                                    <div class="expanding-blocks border-bottom" data-block='citedin-rule'>Rules (<?php echo count($citeIn['Rule']); ?>)<span class="expand">+</span></div>
                                                    <?php
                                                    if ($citedin_count > 0) {
                                                        echo "<ul id='listing-citedin-rule' class='listing-blocks'>";
                                                        foreach ($citeIn['Rule'] as $judgement_map) {
                                                            echo "<li>";
                                                            if ($judgement_map['file_ext'] == 'pdf') {
                                                                $linkToShow = $getBaseUrl . $judgement_map['file_link'];
                                                            } else {
                                                                $linkToShow = "-?l=" . encrypt_url($getBaseUrl . $judgement_map['file_link']);
                                                            }
                                                            echo "<a data-toggle='tooltip' href='" . $getBaseUrl . $judgement_map['perm_link'] . "' data-placement='right' title='" . $judgement_map['title'] . "' perm-link='$linkToShow'>" . $judgement_map['display_name'] . " (" . $judgement_map['prod_name'] . ") " . "</a>";
                                                            echo "</li>";
                                                        }
                                                        echo "</ul>";
                                                    }
                                                    ?>

                                                <?php } ?>
                                            </div>
                                            <!--<div class="expanding-blocks">SIMILAR CASES <span class="expand">+</span></div>-->

                                            <?php
                                            if (count($similar_cases['bySection']) > 0) {
                                                ?>
                                                <div class='similar-cases-block'>
                                                    <div class="expanding-blocks-header" data-block='similar-cases'><?php echo $similar_cases['headerSectionName']; ?></div>
                                                    <?php
                                                    foreach ($similar_cases['bySection'] as $sim_section => $blockData) {
                                                        $section_block = str_replace("(", "_", $sim_section);
                                                        $section_block = str_replace(")", "_", $section_block);
                                                        $section_block = str_replace(" ", "", $section_block);
                                                        echo "<div class=\"expanding-blocks\" data-block='$section_block'>" . $sim_section . " &nbsp;&nbsp;[" . count($similar_cases['bySection'][$sim_section]) . "]<span class=\"expand\">+</span></div>";

                                                        echo "<ul id='listing-$section_block' class='listing-blocks'>";
                                                        foreach ($similar_cases['bySection'][$sim_section] as $judgement_map) {
                                                            echo "<li>";
                                                            if ($judgement_map['file_ext'] == 'pdf') {
                                                                $linkToShow = $getBaseUrl . $judgement_map['file_link'];
                                                            } else {
                                                                $linkToShow = "-?l=" . encrypt_url($getBaseUrl . $judgement_map['file_link']);
                                                            }
                                                            echo "<a data-toggle='tooltip' href='" . $getBaseUrl . $judgement_map['perm_link'] . "'  data-placement='right' title='" . $judgement_map['title'] . "' perm-link='$linkToShow'>" . $judgement_map['display_name'] . "</a>";
                                                            echo "</li>";
                                                        }
                                                        echo "</ul>";
                                                    }
                                                    ?>
                                                </div>
                                                <?php
                                            }
                                            ?>

                                        </div>

                                        <?php
                                    }
                                    //end of left navigation panel
                                    ?>
                                    <div class="bordered" style="width:<?php echo $bordered_width; ?>;float:right">
                                        <div class="col-md-8" >
                                            <?php if ($PrevPageUrl != '') { ?>
                                                <a href="<?php echo $PrevPageUrl; ?>"  class="coi-article-nav-btn-prev"><< Prev</a>
                                            <?php } ?>
                                        </div>
                                        <div class="col-md-8" >
                                            <?php if ($NextPageUrl != '') { ?>
                                                <a href="<?php echo $NextPageUrl; ?>" class="coi-article-nav-btn-next">Next >></a>
                                            <?php } ?>
                                        </div>
                                        <iframe onLoad="calcHeight();"  id='iFramePopupFrame' name='iFramePopupFrame' <?php
                                        if ($file_extn == 'pdf') {
                                            ?> src='<?php echo $getBaseUrl . $file_path; ?>' <?php
                                                } else {
                                                    ?> src='<?php echo "-?l=" . encrypt_url($getBaseUrl . $destination_Path . $file_path); ?>' <?php
                                                }
                                                ?> frameborder='0' allowtransparency='true' scrolling='no' width="100%" <?php
                                                if ($file_extn == 'pdf') {
                                                    echo " height='1130' ";
                                                }
                                                ?> ></iframe>
                                    </div>

                                    <div class="clear"></div>

                                    <div class="pull-right text-right t-margin-10">

                                        <ul class="list-inline" >

                                            <li><a href="#email-this-page" class="ion-email  btn open-popup-link" data-effect="mfp-zoom-in" title="Email this page">Email this page</a></li>

                                            <li><a href="javascript:void(0)" class="ion-printer btn " onclick="printIframe('iFramePopupFrame')" title="Print this page">Print this page </a></li>

                                            <li><input type="hidden" value="<?php echo encrypt_url($destination_Path . $file_path); ?>" name="file_path" id="file_path" />

                                                <button type="submit" class="btn" name="downloadFile" ><i class="ion-android-archive"></i> Download File</button></li>

                                        </ul>

                                        <?php if ($file_extn != 'pdf') { ?>

                                            <em>To download file as PDF, use PDF writer/printer. </em>

                                        <?php } ?>

                                    </div>



                                    <?php
                                }
                            } else {
                                include('loggedInError.php');
                            }
                        }
                    }
                }
                ?>



            </div> 

        </form>



    </div> 

<?php } ?> 



<?php
include('footer.php');
include('gstexplorerview.php');
?>

<!-- Logout Modal-->
<div class="modal fade" id="recordInfoModal" tabindex="-1" role="dialog" aria-labelledby="recordInfoModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <!--                <h5 class="modal-title float-left" id="exampleModalLabel">Section 1</h5>-->

                <a class="btn btn-primary btn_open_new_window" target="_blank" >Open in New Window to view related records</a>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"> X </span>
                </button>
            </div>
            <div class="modal-body" style='height:600px;'>
                <iframe id="iFramePreviewFrame" name="iFramePreviewFrame" src="-?l=ocq1xJlgYZ%2BjmJejoKjJtYPVmp6ap6llZpyayqKDooB7Ypedl6esnsigs8CjppyXoZuWa2e%2BtcE%3D" frameborder="0" allowtransparency="false" scrolling="yes" width="100%"></iframe>
            </div>
            <div class="modal-footer d-block float-left">
                <!--                <a href="#" class="btn btn-primary btn-icon-split bg-info float-left" id='modal-btn-reprocess'>
                                    <span class="icon text-white-50">
                                        <i class="fas fa-mail-forward"></i>
                                    </span>
                                    <span class="text">Email This Page</span>
                                </a>
                                <a href="#" class="btn btn-primary btn-icon-split bg-info float-left" id='modal-btn-reprocess'>
                                    <span class="icon text-white-50">
                                        <i class="fas fa-print"></i>
                                    </span>
                                    <span class="text">Print This Page</span>
                                </a>
                                <a href="#" class="btn btn-primary btn-icon-split bg-info float-left" id='modal-btn-reprocess'>
                                    <span class="icon text-white-50">
                                        <i class="fas fa-download"></i>
                                    </span>
                                    <span class="text">Download File</span>
                                </a>
                                <br>-->
                <div class="pull-right text-right b-margin-10">

                    <ul class="list-inline">

                        <!--<li><a href="#email-this-page" class="ion-email  btn open-popup-link" data-effect="mfp-zoom-in" title="Email this page">Email this page</a></li>-->

                        <!--<li><a href="javascript:void(0)" class="ion-printer btn " onclick="printPreviewFrame('iFramePreviewFrame')" title="Print this page">Print this page </a></li>-->

                        <!--<li><button type="submit" class="btn" name="downloadFile"><i class="ion-android-archive"></i> Download File</button></li>-->

                    </ul>


                    <!--<em>To download file as PDF, use PDF writer/printer. </em>-->


                </div>
            </div>
        </div>
    </div>
</div>
<!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/8.3.1/firebase-app.js"></script>

<!-- TODO: Add SDKs for Firebase products that you want to use
     https://firebase.google.com/docs/web/setup#available-libraries -->
<script src="https://www.gstatic.com/firebasejs/8.3.1/firebase-analytics.js"></script>

<script>
    // Your web app's Firebase configuration
    // For Firebase JS SDK v7.20.0 and later, measurementId is optional
    var firebaseConfig = {
        apiKey: "AIzaSyDJ8GOjtJzXn0Osv8--fpf5PGtk7Y3aSSI",
        authDomain: "vilgst.firebaseapp.com",
        projectId: "vilgst",
        storageBucket: "vilgst.appspot.com",
        messagingSenderId: "493343969816",
        appId: "1:493343969816:web:2ea8047fba70f4980d696d",
        measurementId: "G-DQNYHJLPB3"
    };
    // Initialize Firebase
    firebase.initializeApp(firebaseConfig);
    firebase.analytics();
</script>