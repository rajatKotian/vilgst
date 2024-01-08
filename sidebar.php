<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<!-- right sec start -->
<style>
    /*.adv-serch{*/
    /*    padding: 3px 15px;*/
    /*    border: 1px solid #ededed;*/
    /*}*/
    /*.adv-serch h2*/
    /*{*/
    /*    font-size: 18px;*/
    /*    color: #004e84;*/
    /*    border-bottom: 2px solid #005f90;*/
    /*    display: inline-block;*/
    /*    transition:0.4s;*/
    /*}*/
    /*.adv-serch span*/
    /*{*/

    /*}*/
    /*.adv-serch:hover*/
    /*{*/
    /*    background: #f7f7f7;*/
    /*    box-shadow: 0px 0px 3px grey;*/
    /*    cursor: pointer; */
    /*}*/
    /*.adv-serch:hover h2*/
    /*{*/
    /*    margin-left: 7px;*/
    /*}*/
    .advance-serch{
        padding: 3px 15px;
        border: 1px solid #ededed;
        background: #f7f7f7;
        box-shadow: 2px 2px 3px #c1c1c1;
        margin-bottom: 5px;
    }
    .advance-serch h2
    {
        font-size: 16px;
        display: inline-block;
        transition:0.4s;
        padding: 0px;
        margin: 0px 0;
        line-height: 24px;
    }
    .quicksearch {
        color: #004e84;
    }
    .advancesearch {
        color: #004e84;
    }
    .gstResources {
        color: #e705c1;
    }
    .gst-finder {
        color: #e705c1;
    }
    .quicksearch:hover
    {
        box-shadow: 0px 0px 3px grey;
        cursor: pointer;
        background: #fab765;
    }
    .advancesearch:hover
    {
        box-shadow: 0px 0px 3px grey;
        cursor: pointer;
        background: #fab765;
    }
    .gstResources:hover
    {
        background: #010f0d;
        box-shadow: 0px 0px 3px grey;
        cursor: pointer;
    }
    .gst-finder:hover
    {
        background: #010f0d;
        box-shadow: 0px 0px 3px grey;
        cursor: pointer;
    }
    .srch {
        color: #004e84;
        font-size: 18px;
        line-height: 25px;
        font-weight: 400;
    }
    .calc {
        color: #e705c1;
        font-size: 18px;
        line-height: 25px;
        font-weight: 400;
    }
    .span {
        color: #004e84;
        padding-left: 15px;
        font-size: 18px;
        line-height: 25px;
        font-weight: 400;
    }
    .span1 {
        color: #e705c1;
        padding-left: 4px;
        font-size: 18px;
        line-height: 25px;
        font-weight: 400;
    }
    
    h2.tax-vista{
        font-family: "Calibri","sans-serif";
        float:left;
        border-right:2px solid orange;
        padding-right: 10px;
        margin-right: 10px;
    }

    h5.tax-vista{
        display: block;
        margin-top: 2px;
        margin-bottom: 0px;
        font-style: normal;
        font-family: Maiandra GD;
        letter-spacing: 2px;
        /*width: 100%;*/
        TEXT-ALIGN: justify;
        float:left;
        color:white;
    }


    h2.gst-videos{
        /*font-family: 'Maiandra GD';*/
        /* display: block; */
        /* clear: both; */
        padding-right: 10px;
        margin-right: 10px;
        font-size: 18px;
        border-right: 2px orange solid;
        /* width: 100%; */
        padding-top: 8px;
        /* margin-bottom: 3px; */
        float: left;
        height: 34px;
        /*font-weight: bold;*/
    }

</style>
<div class="col-sm-7 col-md-5 right-section">
    <!--<div>-->
    <!--    <div class="adv-serch" onclick="searchFileName('advancesearch')">-->
    <!--      <h2><span class="ion-ios-search"></span> Advance Search</h2>-->
    <!--    </div>-->
    <!--    <br>-->
    <!--</div>-->

    <div>
        <!--<div class="adv-serch" onclick="searchFileName('quicksearch')">-->
        <!--    <div class="row">-->
        <!--        <div class="col-md-2">-->
        <!--            <span class="fa fa-search"></span>-->
        <!--        </div>-->
        <!--        <div class="col-md-10">-->
        <!--            <h2>Quick Search</h2>-->
        <!--        </div> -->
        <!--    </div>-->
        <!--</div>-->

        <!--<div class="adv-serch" onclick="searchFileName('advancesearch')">-->
        <!--    <div class="row">-->
        <!--        <div class="col-md-2">-->
        <!--            <span class="fa fa-search-plus"></span>-->
        <!--        </div>-->
        <!--        <div class="col-md-10">-->
        <!--            <h2>Advance Search</h2>-->
        <!--        </div> -->
        <!--    </div>-->
        <!--</div>-->
        
        <div class="advance-serch">
            <div class="row">
                <div class="col-md-2">
                    <span class="fa fa-search srch"></span>
                </div>
                <div class="col-md-7" onclick="searchFileName('quicksearch')">
                    <a href="quicksearch.php">
                        <h2 class="quicksearch">Quick Search</h2>
                    </a>
                    <!-- <h2 class="quicksearch">Quick Search</h2>
                    <span class="span"> /</span> -->
                </div>
                <!--<div class="col-md-7" onclick="searchFileName('advancesearch')">-->
                <!--    <h2 class="advancesearch">Advance Search</h2>-->
                <!--</div> -->
                <div class="col-md-7">
                    <a href="AdvancedSearch.php">
                        <h2 class="advancesearch">Advance Search</h2>
                    </a>
                </div>
            </div>
        </div>

        <div class="advance-serch">
            <div class="row">
                <div class="col-md-2">
                    <span class="fa fa-calculator calc"></span>
                </div>
                <div class="col-md-14">
                    <a href="gstResources.php">  
                        <h2 class="gstResources">GST Resources</h2>
                        <span class="span1"> /</span>
                </a>
                <a id="gst_rate" href="https://www.vilgst.com/gst-finder.php">
                        <h2 class="gst-finder">Gst Rate Finder</h2>
                </a>
                </div>
            </div>
        </div>
        
        <!--<div class="adv-serch">-->
        <!--    <div class="row">-->
        <!--        <a id="gst_rate" href="https://www.vilgst.com/gst-finder.php">-->

        <!--            <div class="col-md-2">-->

        <!--                <span class="fa fa-calculator"></span>-->
        <!--            </div>-->
        <!--            <div class="col-md-10">-->
        <!--                <h2>Gst Rate Finder</h2>-->
        <!--            </div> -->
        <!--        </a>-->
        <!--    </div>-->

        <!--</div>-->

    </div>

    <!--<div class="adv-serch">-->
    <!--  <div class="row">-->
    <!--    <a id="gst_rate" href='https://www.vilgst.com/gst-finder.php'>-->

    <!--    <div class="col-md-2">-->

    <!--        <span class="fa fa-calculator" style="font-size: 23px;    margin-top: 9px;"></span>-->
    <!--    </div>-->
    <!--    <div class="col-md-10">-->
    <!--         <h2>Gst Rate Finder</h2>-->
    <!--    </div> -->
    <!--    </a>-->
    <!--  </div>-->

    <!--</div>-->
    <?php
    $result = mysqli_query($GLOBALS['con'],"SELECT * FROM sidebar_widgets WHERE active_flag = 'Y' ORDER BY widget_id");
    while ($row = mysqli_fetch_array($result)) {
        $tableName = $row['widget_type'];
        $limit = '';
        $where = '';
        ?>
        <div class="bordered" id="<?php echo $tableName; ?>">
            <div class="row ">        

                <div class="col-sm-16 bt-space sidebar-widget" > 

                    <?php if ($tableName == 'taxvista') { ?>
                        <div class = "sidebar-heading">
                            <h2 class="tax-vista"><?php echo $row['title']; ?></h2>
                            <!--<a href="<?php echo $getBaseUrl; ?>showMoreData?data=<?php echo $tableName; ?>">VIEW ALL</a>-->
                            <h5 class="tax-vista" style='margin-top:0px;border-bottom:2px orange;padding-bottom:2px;float:left;'>Your Weekly Tax Recap</h5><br>
                            <div class='author' style='margin:0px 0px;font-style: italic;color:white;text-align:left;float:left;'>By Dr. G. Gokul Kishore</div>
                        </div>
                        <?php
                    } else {
                        ?>
                        <div class="sidebar-heading">
                            <h2><?php echo $row['title']; ?></h2>
                            <a href="<?php echo $getBaseUrl; ?>showMoreData?data=<?php echo $tableName; ?>">VIEW ALL</a>
                        </div>
                        <?php
                    }
                    ?>


                    <?php
                    if ($tableName == 'taxvista') {
                        ?>

                        <div class="tab-content">
                            <div class="tab-pane active">               
                                <div class="vert-carousel-container">
                                    <ul id="<?php echo $row['widget_type']; ?>-carousel" class="list-unstyled">
                                        <?php
                                        $contentSql = "SELECT  *
                                        FROM $tableName 
                                        ORDER BY article_date DESC
                                        LIMIT 0, 1";

                                        $contentResult = mysqli_query($GLOBALS['con'],$contentSql);

                                        if (mysqli_num_rows($contentResult) == 0) {
                                            echo "<div class='alert alert-danger'>No Data Found</div>";
                                        } else {
                                            $fields_num = mysqli_num_fields($contentResult);

                                            while ($contentRow = mysqli_fetch_array($contentResult)) {
                                                ?>

                                                <li style='border-bottom:0px;'> 
                                                    <div class='widget-box'>
                                                        <div class='widget-content'>
                                                            <div style='display: block;float:left;padding-right:5px;text-align: left;padding-bottom: 5px;'>
                                                                <div style='width:100px;float:left;margin:0px 5px 5px 0px'><img src="<?php echo $getBaseUrl . "images/Gokul.png" ?>" style="height:100px;">
                                                                    <br/>
                                                                </div>
                                                                <span class='article-date' style='display:block;margin-bottom:0px;color:blue;font-style: italic;'><?php echo date_format(date_create($contentRow['article_date']), "d-M-Y"); ?></span>
                                                                <b><?php echo $contentRow['subject']; ?></b> <br/><?php
                                                                echo substr($contentRow['summary'], 0, 235);
                                                                if (strlen($contentRow['summary']) > 235)
                                                                    echo "...";
                                                                ?>
                                                                <?php
                                                                $encryptyId = base64_encode(base64_encode($contentRow['article_id']));
                                                                echo "<a href='".$getBaseUrl."/showiframe?V1Zaa1VsQlJQVDA9=" . $encryptyId . "&page=taxvista' target='_blank' style=\"color:blue;\">(Read more)</a>";
                                                                ?>
                                                                <a style="float:right" href="<?php echo $getBaseUrl; ?>showMoreData?data=<?php echo $tableName; ?>">VIEW ALL</a>
                                                                <!--<a style='float:right'> View All </a>-->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li> 


                                                <?php
                                            }
                                        }
                                        ?>


                                    </ul>
                                </div>
                            </div>
                        </div>


                        <?php
                    } else {
                        ?>

                        <div class="tab-content">
                            <div class="tab-pane active">               
                                <div class="vert-carousel-container"
                                >
                                    <ul id="<?php echo $row['widget_type']; ?>-carousel" class="list-unstyled">
                                        <?php
                                        if ($tableName == 'articles' || $tableName == 'features') {
                                            $limit = ' LIMIT 0, 3 ';
                                        }

                                        if ($tableName == 'highlights') {
                                            $where = ' WHERE active_flag = "Y" ';
                                        } else if ($tableName == 'budgets_analysis') {
                                            $latestYear = date("Y");
                                            $where = ' WHERE analysis_date like "%' . $latestYear . '%" ';
                                        }


                                        if($tableName == 'features'){
                                            $contentSql = "SELECT  *
                                   FROM $tableName 
                                   $where
                                   ORDER BY feature_date DESC
                                   $limit";    
                                        }else{
                                            
                                            $contentSql = "SELECT  *
                                   FROM $tableName 
                                   $where
                                   ORDER BY article_date DESC
                                   $limit";
                                            
                                        }
                                        
                                        

                                        $contentResult = mysqli_query($GLOBALS['con'],$contentSql);
                                        //var_dump($contentResult); die();

                                        if (mysqli_num_rows($contentResult) == 0) {
                                            echo "<div class='alert alert-danger'>No Data Found</div>";
                                        } else {
                                            $fields_num = mysqli_num_fields($contentResult);

                                            while ($contentRow = mysqli_fetch_array($contentResult)) {

                                                if ($tableName == 'budgets_analysis') {
                                                    $encryptID = base64_encode(base64_encode($contentRow['analysis_id']));
                                                } else if ($tableName == 'highlights') {
                                                    $encryptID = base64_encode(base64_encode($contentRow['highlight_id']));
                                                } else if ($tableName == 'articles') {
                                                    $encryptID = base64_encode(base64_encode($contentRow['article_id']));
                                                } else if ($tableName == 'features') {
                                                    $encryptID = base64_encode(base64_encode($contentRow['feature_id']));
                                                }

                                                $summary = $contentRow['summary'];

                                                echo "<li>
                                    <div class='widget-box'>
                                      <div class='widget-content'>
                                      <a href='javascript:void(0)' onclick='showFrame(\"$encryptID\",\"$tableName\")'>" . stripslashes($summary) . "</a>";

                                                if ($contentRow['new_flag'] == 'Y') {
                                                    echo '<span class="badge">New</span>';
                                                }

                                                if ($tableName != 'features') {
                                                    if ($contentRow['author'] != '') {
                                                        echo "<em>by " . $contentRow['author'] . "</em>";
                                                    }
                                                }

                                                echo "    </div>
                                    </div>
                                  </li>";
                                            }
                                        }
                                        mysqli_free_result($contentResult);
                                        ?>                    
                                    </ul>
                                </div>
                            </div>
                        </div>

    <?php } ?>
                </div>

            </div>
        </div>

<?php } ?>
    
    <div class="adv-serch">
        <div class="row">
            <a href="viewhighlightsyearly.php">
                <div class="col-md-2">
                    <span style="color: #720432;" class="fa fa-file"></span>
                </div>
                <div class="col-md-10">
                    <h2 style="color: #720432; font-size: 18px; border: none;">Weekly Summary</h2>
                </div> 
            </a>
        </div>
    </div>

    <div class="bordered" id="<?php echo $tableName; ?>">
        <div class="row ">        
            <div class="col-sm-16 bt-space sidebar-widget" > 
                <div class="sidebar-heading">
                   
                    <h2 class="gst-videos">VIL Video</h2>
                    <div class='author' style='margin: 0px 0px;color: white;text-align: left;float: left;font-size: 12px'>Service of Notices/Orders under GST…<br>CA Vivek Jalan</div>
               
                    <!--<a href="<?php echo $getBaseUrl; ?>showMoreData?data=<?php echo $tableName; ?>">VIEW ALL</a>-->
                </div>
                <div class="tab-content">
                    <div class="tab-pane active">               
                        <div class="vert-carousel-container" style="padding:5px 0;max-height:240px">
                            <iframe width="340" height="191" src="https://www.youtube.com/embed/hh554ZYG_r0" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            <!--<iframe width="340" height="191" src="https://youtu.be/lC9FTFC8gZQ" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>-->
                        </div>
                    </div>

                </div>

            </div>

        </div>


    </div>

</div>
<!-- right sec end -->

<!-- The core Firebase JS SDK is always required and must be listed first -->
<!--<script src="https://www.gstatic.com/firebasejs/8.3.1/firebase-app.js"></script>-->

<!-- TODO: Add SDKs for Firebase products that you want to use
     https://firebase.google.com/docs/web/setup#available-libraries -->
<!--<script src="https://www.gstatic.com/firebasejs/8.3.1/firebase-analytics.js"></script>-->

<script>
  // Your web app's Firebase configuration
  // For Firebase JS SDK v7.20.0 and later, measurementId is optional
//   var firebaseConfig = {
//     apiKey: "AIzaSyDJ8GOjtJzXn0Osv8--fpf5PGtk7Y3aSSI",
//     authDomain: "vilgst.firebaseapp.com",
//     projectId: "vilgst",
//     storageBucket: "vilgst.appspot.com",
//     messagingSenderId: "493343969816",
//     appId: "1:493343969816:web:2ea8047fba70f4980d696d",
//     measurementId: "G-DQNYHJLPB3"
//   };
//   // Initialize Firebase
//   firebase.initializeApp(firebaseConfig);
//   firebase.analytics();
</script>