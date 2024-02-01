<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<!-- right sec start -->
<style>
    .adv-serch{
        padding: 5px 15px;
        border: 1px solid #ededed;
    }
    .adv-serch h2
    {
        font-size: 18px;
        color: #004e84;
        border-bottom: 2px solid #005f90;
        display: inline-block;
        transition:0.4s;
    }
    .adv-serch span
    {

    }
    .adv-serch:hover
    {
        background: #f7f7f7;
        box-shadow: 0px 0px 3px grey;
        cursor: pointer; 
    }
    .adv-serch:hover h2
    {
        margin-left: 7px;
    }

    h2.tax-vista{
        font-family: 'Maiandra GD';
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


</style>
<div class="col-sm-7 col-md-5 right-section">
    <!--<div>-->
    <!--    <div class="adv-serch" onclick="searchFileName('advancesearch')">-->
    <!--      <h2><span class="ion-ios-search"></span> Advance Search</h2>-->
    <!--    </div>-->
    <!--    <br>-->
    <!--</div>-->

    <div>
        <div class="adv-serch" onclick="searchFileName('quicksearch')">
            <div class="row">
                <div class="col-md-2">
                    <span class="fa fa-search"></span>
                </div>
                <div class="col-md-10">
                    <h2>Quick Search</h2>
                </div> 
            </div>

        </div>

        <div class="adv-serch" onclick="searchFileName('advancesearch')">
            <div class="row">
                <div class="col-md-2">
                    <span class="fa fa-search-plus"></span>
                </div>
                <div class="col-md-10">
                    <h2>Advance Search</h2>
                </div> 
            </div>

        </div>

        <div class="adv-serch">
            <div class="row">
                <a id="gst_rate" href="http://vilgst.local/gst-finder.php">

                    <div class="col-md-2">

                        <span class="fa fa-calculator"></span>
                    </div>
                    <div class="col-md-10">
                        <h2>Gst Rate Finder</h2>
                    </div> 
                </a>
            </div>

        </div>

    </div>

    <!--<div class="adv-serch">-->
    <!--  <div class="row">-->
    <!--    <a id="gst_rate" href='http://vilgst.local/gst-finder.php'>-->

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

                                            while ($contentRow = mysqli_fetch_array($contentResult, MYSQL_ASSOC)) {
                                                ?>

                                                <li style='border-bottom:0px;'> 
                                                    <div class='widget-box'>
                                                        <div class='widget-content'>
                                                            <div style='display: block;float:left;padding-right:5px;text-align: justify;padding-bottom: 5px;'>
                                                                <div style='width:100px;float:left;margin:0px 5px 5px 0px'><img src="<?php echo $getBaseUrl . "images/Gokul_Kishore_new.JPG" ?>" style="height:100px;">
                                                                    <br/>
                                                                </div>
                                                                <span class='article-date' style='display:block;margin-bottom:0px;color:blue;font-style: italic;'><?php echo date_format(date_create($contentRow['article_date']), "d-M-Y"); ?></span>
                                                                <b><?php echo $contentRow['subject']; ?></b> <br/><?php
                                                                echo substr($contentRow['summary'], 0, 215);
                                                                if (strlen($contentRow['summary']) > 215)
                                                                    echo "...";
                                                                ?>
                                                                <?php
                                                                $encryptyId = base64_encode(base64_encode($contentRow['article_id']));
                                                                echo "<a href='" . $getBaseUrl . "/showiframe?V1Zaa1VsQlJQVDA9=" . $encryptyId . "&page=taxvista' target='_blank' style=\"color:blue;\">(Read more)</a>";
                                                                ?>
                                                                <a style='float:right'> View All </a>
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
                                <div class="vert-carousel-container">
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

                                        $contentSql = "SELECT  *
                                   FROM $tableName 
                                   $where
                                   ORDER BY created_dt DESC
                                   $limit";

                                        $contentResult = mysqli_query($GLOBALS['con'],$contentSql);
                                        //var_dump($contentResult); die();

                                        if (mysqli_num_rows($contentResult) == 0) {
                                            echo "<div class='alert alert-danger'>No Data Found</div>";
                                        } else {
                                            $fields_num = mysqli_num_fields($contentResult);

                                            while ($contentRow = mysqli_fetch_array($contentResult, MYSQL_ASSOC)) {

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

    <div class="bordered" id="<?php echo $tableName; ?>">
        <div class="row ">        
            <div class="col-sm-16 bt-space sidebar-widget" > 
                <div class="sidebar-heading">
                    <h2>GST Videos</h2>
                    <!--<a href="<?php echo $getBaseUrl; ?>showMoreData?data=<?php echo $tableName; ?>">VIEW ALL</a>-->
                </div>
                <div class="tab-content">
                    <div class="tab-pane active">               
                        <div class="vert-carousel-container" style="padding:5px 0;max-height:240px">
                            <iframe width="340" height="191" src="https://www.youtube.com/embed/azlfZnVQwvA" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            <div class='widget-box'>
                                <div class='widget-content' style="font-weight:bold">
                                    ADVANCE GST COURSE VIDEO 1: INPUT TAX CREDIT
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

            </div>

        </div>


    </div>
    <!-- right sec end -->