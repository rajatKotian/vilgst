<?php
$page = 'showCOI';
include('header.php');
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

    .coi-table{
        border:1px solid #000 !important;
    }

    .coi-table th, .coi-table td{
        font-family: "Verdana",sans-serif;
        text-align: left;
        color:#000;
        background:none;
        padding:5px !important;
        border:1px solid #000 !important;
    }

    .coi-table th a, .coi-table td a{
        color:blue;
        text-decoration: underline;
    }
    .coi-header{
        background:#EAF1DD;
        text-align: center;
        color:#000;
        font-family: "Verdana",sans-serif;
        font-size: 14px;
        font-weight: bold;
        letter-spacing: 2px;
        text-transform: uppercase;
    }
</style>

<div class="col-md-16 col-sm-16 left-section">

    <form method="post" action="" id="formDownload" name="formDownload">

        <h1>
            Constitution of India
            <ol class="breadcrumb">
                <li><a href="#">Home</a></li>
            </ol>
        </h1>
        <div class="col-md-16">

            <div class="pull-right text-right b-margin-10">

                <!--                <ul class="list-inline" >
                
                                    <li><a href="#email-this-page" class="ion-email  btn open-popup-link" data-effect="mfp-zoom-in" title="Email this page">Email this page</a></li>
                
                                    <li><a href="javascript:void(0)" class="ion-printer btn " onclick="printIframe('iFramePopupFrame')" title="Print this page">Print this page </a></li>
                
                                    <li><button type="submit" class="btn" name="downloadFile" ><i class="ion-android-archive"></i> Download File</button></li>
                
                                </ul>-->

                <!--<em>To download file as PDF, use PDF writer/printer. </em>-->

            </div>

            <div class="clear"></div>

            <input type="hidden" value="#" name="file_path" id="file_path" />

            <div class="bordered">
                <div class='coi-header'>
                    The constitution of India
                </div>
                <div class="box-body" id="dataresult-container" style="padding-top: 20px;width:80%;margin:auto">
                    <table id="dataResult" class="display table table-bordered table-hover table-blue coi-table" cellspacing="0" width="60%">
                        <tbody>
                            <?php
                            $tableData = "";

                            $tableData = "<tr>

                        </tr>";
                            $articleQuery = "SELECT * from coi_articles WHERE article_type='Preamble' order by article_seq_no ASC";
                            $ArticleResult = mysqli_query($GLOBALS['con'],$articleQuery);
                            while ($articleRow = mysqli_fetch_assoc($ArticleResult)) {
//                                    print_r($articleRow);
                                //showing articles data.
                                $encryptyId = base64_encode(base64_encode($articleRow['id']));
                                $tableData .="<tr>
                        <td><a target='_blank' href='" . $getBaseUrl . "showiframe?V1Zaa1VsQlJQVDA9=$encryptyId&showCOIarticles'>Preamble</a></td>
                        <td>" . strtoupper($articleRow['article_name']) . " </td>
                        </tr>";
                            }

                            echo $tableData;
                            ?>


<!--<tr><th>asdas</th><th>asdsad</th></tr>-->
                            <?php
                            $tableData = "";
                            //get list of all chapters and articles here. and show the list.
                            //ordered by sequence number
                            $query = "SELECT * from coi_chapter where chapter_seq_no not in (0,9998,9999,9997) order by chapter_seq_no ASC";
                            $result = mysqli_query($GLOBALS['con'],$query);
                            while ($row = mysqli_fetch_assoc($result)) {
                                //get list of articles for this chapter.
                                $tableData .="<tr>
                        <th style='min-width:130px'>Part " . $row['chapter_no'] . " </th>
                        <th>" . strtoupper($row['chapter_name']) . " </th>
                        </tr>";
                                $articleQuery = "SELECT * from coi_articles WHERE chapter_id=" . $row['id'] . " AND article_type='Article' order by article_seq_no ASC";
                                $ArticleResult = mysqli_query($GLOBALS['con'],$articleQuery);
                                while ($articleRow = mysqli_fetch_assoc($ArticleResult)) {
//                                    print_r($articleRow);
                                    //showing articles data.
                                    $encryptyId = base64_encode(base64_encode($articleRow['id']));
                                    $tableData .="<tr>
                        <td><a target='_blank' href='" . $getBaseUrl . "showiframe?V1Zaa1VsQlJQVDA9=$encryptyId&showCOIarticles'>Article " . $articleRow['article_no'] . " </a></td>
                        <td>" . strtoupper($articleRow['article_name']) . " </td>
                        </tr>";
                                }
                            }
                            echo $tableData;
                            ?>
                           

                            <?php
                            $tableData = "<tr>

                        </tr>";
                            $articleQuery = "SELECT * from coi_articles WHERE article_type='Schedule' order by article_seq_no ASC";
                            $ArticleResult = mysqli_query($GLOBALS['con'],$articleQuery);
                            while ($articleRow = mysqli_fetch_assoc($ArticleResult)) {
//                                    print_r($articleRow);
                                //showing articles data.
                                $encryptyId = base64_encode(base64_encode($articleRow['id']));
                                $tableData .="<tr>
                        <td><a target='_blank' href='" . $getBaseUrl . "showiframe?V1Zaa1VsQlJQVDA9=$encryptyId&showCOIarticles'>Schedule " . $articleRow['article_no'] . " </a></td>
                        <td>" . strtoupper($articleRow['article_name']) . " </td>
                        </tr>";
                            }

                            echo $tableData;
                            ?>

                            <?php
                            $tableData = "<tr>

                        </tr>";
                            $articleQuery = "SELECT * from coi_articles WHERE article_type='Appendix' order by article_seq_no ASC";
                            $ArticleResult = mysqli_query($GLOBALS['con'],$articleQuery);
                            while ($articleRow = mysqli_fetch_assoc($ArticleResult)) {
//                                    print_r($articleRow);
                                //showing articles data.
                                $encryptyId = base64_encode(base64_encode($articleRow['id']));
                                $dispaly_name = '';
                                if($articleRow['article_no'] == 'C.O. 272' || $articleRow['article_no'] == 'C.O. 273'){
                                   $dispaly_name = $articleRow['article_no']; 
                                }else{
                                    $dispaly_name = 'Appendix '. $articleRow['article_no'] ;
                                }
                                    
                                
                                $tableData .="<tr>
                        <td><a target='_blank' href='" . $getBaseUrl . "showiframe?V1Zaa1VsQlJQVDA9=$encryptyId&showCOIarticles'>" . $dispaly_name . " </a></td>
                        <td>" . strtoupper($articleRow['article_name']) . " </td>
                        </tr>";
                            }

                            echo $tableData;
                            ?>
                        </tbody>
                    </table>

                </div>  

            </div>

            <div class="clear"></div>

            <div class="pull-right text-right t-margin-10">

                <!--                <ul class="list-inline" >
                
                                    <li><a href="#email-this-page" class="ion-email  btn open-popup-link" data-effect="mfp-zoom-in" title="Email this page">Email this page</a></li>
                
                                    <li><a href="javascript:void(0)" class="ion-printer btn " onclick="printIframe('iFramePopupFrame')" title="Print this page">Print this page </a></li>
                
                                    <li><button type="submit" class="btn" name="downloadFile" ><i class="ion-android-archive"></i> Download File</button></li>
                
                                </ul>-->

                <?php if ($file_extn != 'pdf') { ?>

                    <!--<em>To download file as PDF, use PDF writer/printer. </em>-->

                <?php } ?>

            </div>
        </div>
    </form>
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
<?php
include('footer.php');
?>