<?php 
	$page = '';
$seoTitle = 'Union Budget';
$seoKeywords = 'Union Budget';
$seoDesc = 'Union Budget';
	include('header.php'); 
  //WlZkV2FHTm5QVDA9 = echo base64_encode(base64_encode(base64_encode('year')));
  //WkVoc2QxcFJQVDA9 = echo base64_encode(base64_encode(base64_encode('type')));
//YjNSb1pYST0=  =  base64_encode(base64_encode('other'));
//WW5Wa1oyVjBRVzVoYkhsemFYTT0=  =  base64_encode(base64_encode('budgetAnalysis'));

  if(isset($_GET["WlZkV2FHTm5QVDA9"])) {
    $decryptYear = base64_decode(base64_decode($_GET['WlZkV2FHTm5QVDA9']));
  } 

  if(isset($_GET["WkVoc2QxcFJQVDA9"])) {
    $decryptType = base64_decode(base64_decode($_GET['WkVoc2QxcFJQVDA9']));
    $array = explode('_',$decryptType);
    $prodId = $array[0];
    $subProdId = $array[1];
 
  } 

?> 
    <!-- left sec start <div class="col-md-16 col-sm-16"> -->
    <div class="col-md-11 col-sm-9 left-section">
  <h1>Union Budget
   <?php 
      if(isset($decryptYear) && isset($decryptType) && $decryptType != 'budgetAnalysis') {  

        echo " | ".$decryptYear."-".(substr($decryptYear,2)+1);

        if($decryptType == 'other') { 
          echo " | Other Documents"; 
        } else {

          $prod_Result = mysqli_query($GLOBALS['con'],"SELECT prod_name FROM product where prod_id = ".$prodId);  
          $prod_Row = mysqli_fetch_array($prod_Result); 
          $prod_id = ' |  '.$prod_Row['prod_name'].'  '; 

          $sub_prod_Result = mysqli_query($GLOBALS['con'],"SELECT sub_prod_name FROM sub_product where sub_prod_id = ".$subProdId);  
          $sub_prod_Row = mysqli_fetch_array($sub_prod_Result); 
          $sub_prod_id = ' |  '.$sub_prod_Row['sub_prod_name'].'  '; 

          echo $prod_id.' '.$sub_prod_id; 
        } 

      } else if(isset($decryptYear)) {

        echo " | ".$decryptYear."-".(substr($decryptYear,2)+1);

      }
    ?>
  		<ol class="breadcrumb">
        <li><a href="<?php echo $getBaseUrl; ?>">Home</a></li>
            <?php 
              if(isset($decryptYear)) {
            echo '<li><a href="/unionBudgets">Union Budget</a></li>';
          }
            ?>
         <li class="active">
            <?php 

            if(isset($decryptYear) && isset($decryptType) && $decryptType != 'budgetAnalysis') {  
              
               echo  $decryptYear."-".(substr($decryptYear,2)+1);

              if($decryptType =='other') { 
                echo " | Other Documents"; 
              } else {
                $prod_Result = mysqli_query($GLOBALS['con'],"SELECT prod_name FROM product where prod_id = ".$prodId);  
                $prod_Row = mysqli_fetch_array($prod_Result); 
                $prod_id = ' |  '.$prod_Row['prod_name'].'  '; 

                $sub_prod_Result = mysqli_query($GLOBALS['con'],"SELECT sub_prod_name FROM sub_product where sub_prod_id = ".$subProdId);  
                $sub_prod_Row = mysqli_fetch_array($sub_prod_Result); 
                $sub_prod_id = ' |  '.$sub_prod_Row['sub_prod_name'].'  '; 

                echo $prod_id.' '.$sub_prod_id; 
              } 

          } else if(isset($decryptYear)) {

            echo  $decryptYear."-".(substr($decryptYear,2)+1);

          } else {
             echo "Union Budget";
          }
        ?>
      </li>       
    </ol>
  </h1>
  <div class="col-md-16">
  <?php  if(isset($decryptYear) && isset($decryptType) && $decryptType != 'budgetAnalysis') {  

            if($decryptType =='other') {
              $type = "AND vd.prod_id = '0' ";
            } else {

            $array = explode('_',$decryptType);
            $prodId = $array[0];
            $subProdId = $array[1];

              $type = " AND vd.prod_id = ".$prodId." AND vd.sub_prod_id = ".$subProdId." ";
            }
 
            $result = mysqli_query($GLOBALS['con'],"SELECT vd.data_id, DATE_FORMAT(circular_date,GET_FORMAT(DATE,'EUR'))'Date', 
              vd.circular_no 'Circular No',
              vd.prod_id 'prod_id',
              vd.sub_prod_id 'sub_prod_id',
              vd.sub_subprod_id 'sub_subprod_id',
              vd.cir_subject 'Subject',
              vd.budget_path 'Path'
            FROM budgets_union vd 
            WHERE year( circular_date ) = '$decryptYear'
            $type
            AND vd.active_flag = 'Y' 
            AND vd.budget_flag = 'Y' 
            order by vd.circular_date desc, vd.prod_id, vd.sub_subprod_id, vd.circular_no ");



            if(mysqli_num_rows($result) == 0) {   

              echo "<div class='alert alert-danger'>No Data Found</div>";
            } 
            else { 
              $fields_num = mysqli_num_fields($result);
                 while($row = mysqli_fetch_array($result))
                {
                  $file_path = $row['Path'];
                  $file_extn = strtolower(substr($file_path,-3));
                  $encryptID = base64_encode(base64_encode($row['data_id']));
                  $productName = '';
                  if($row['prod_id'] == 1 ) { $productName = 'VAT'; }
                    else if($row['prod_id'] == 2 ) { $productName = 'SERVICE TAX'; }
                    else if($row['prod_id'] == 3 ) { $productName = 'GOODS & SERVICES TAX'; }
                    else if($row['prod_id'] == 4 ) { $productName = 'CENTRAL EXCISE'; }
                    else if($row['prod_id'] == 5 ) { $productName = 'CUSTOMS'; }
                    else if($row['prod_id'] == 6 ) { $productName = 'DGFT'; }
                    else if($row['prod_id'] == 7 ) { $productName = 'SGST'; }
                    else if($row['prod_id'] == 8 ) { $productName = 'UTGST'; }
                    else if($row['prod_id'] == 9 ) { $productName = 'IGST'; }
                    else if($row['prod_id'] == 10 ) { $productName = 'CGST'; }
 
                    if($productName != '') { 
                      $productName = '<span  style="float: left;">  &nbsp;|  '.$productName.' </span>'; 
                    } else {
                      $productName = '';
                    }

                    $sub_prod_Result = mysqli_query($GLOBALS['con'],"SELECT sub_prod_name FROM sub_product where sub_prod_id = ".$row['sub_prod_id']);  
                    $sub_prod_Row = mysqli_fetch_array($sub_prod_Result); 

                    if($row['sub_prod_id'] != '') { 
                      $sub_prod_id = '<span  style="float: left;">  &nbsp;|  '.$sub_prod_Row['sub_prod_name'].' </span>'; 
                    } else {
                      $sub_prod_id = '';
                    }
                      
                    if($row['sub_subprod_id'] != '') { 
                      $sub_subprod_id = '<span  style="float: left;">  &nbsp;|  '.$row['sub_subprod_id'].' </span>';
                    } else {
                      $sub_subprod_id = '';
                    }
                  //    echo $file_extn;
                    echo "<div class='widget-box'>";  
                    echo "<h4><strong style='float: left;'><a href='javascript:void(0)' onclick='showFrame(\"$encryptID\",\"unionBudget\")' title='Click here to download the file'>{$row['Circular No']}</a> </strong> $productName  $sub_prod_id $sub_subprod_id <strong style='float: right; margin-right: 10px; margin-top: 0px;'>{$row['Date']}</strong></h4>";
                    echo "<div class='widget-content'>
                            <div class='widget-actions  pull-right'><a href='javascript:void(0)' onclick='showFrame(\"$encryptID\",\"unionBudget\")' title='Click here to download the file' class='btn btn-text-icon pull-right t-margin-none'><i class='ion-android-archive'></i> Download File</a></div>
                              <p>{$row['Subject']}&nbsp;</p>
                            </div>";
                    echo "</div>";
                }  
              }
            mysqli_free_result($result);    

  } else {  

        if(isset($decryptYear)) {
          $year = 'AND year( circular_date ) = '.$decryptYear;
        } else {
          $year = '';
        }

        $sql = "SELECT  DISTINCT(year(circular_date))'year'
                FROM budgets_union 
                WHERE active_flag = 'Y' 
                AND budget_flag = 'Y'
                $year
                ORDER BY circular_date DESC LIMIT 1"; 
        $result = mysqli_query($GLOBALS['con'],$sql);

        
        $fields_num = mysqli_num_fields($result);
  
        echo "<ul class='boxed-list'>"; 
        
        while($row = mysqli_fetch_array($result)) {

          $encryptYear = base64_encode(base64_encode($row['year']));

          $encryptStNoti = base64_encode(base64_encode('2_6'));//ST- Notification 2_6 
          $encryptStCir = base64_encode(base64_encode('2_7'));//ST- Circular 2_7 
          $encryptCeNoti = base64_encode(base64_encode('4_21'));//CE- Notification 4_21 
          $encryptCeCir = base64_encode(base64_encode('4_22'));//CE- Circular 4_22 
          $encryptCuNoti = base64_encode(base64_encode('5_35'));//CU- Notification 5_35
          $encryptCuCir = base64_encode(base64_encode('5_36'));//CU- Circular 5_36 

          $encryptSGSTNoti = base64_encode(base64_encode('7_53'));//CU- Notification 5_35
          $encryptSGSTCir = base64_encode(base64_encode('7_54'));//CU- Circular 5_36 

          $encryptUTGSTNoti = base64_encode(base64_encode('8_63'));//CU- Notification 5_35
          $encryptUTGSTCir = base64_encode(base64_encode('8_64'));//CU- Circular 5_36 

          $encryptIGSTNoti = base64_encode(base64_encode('9_73'));//CU- Notification 5_35
          $encryptIGSTCir = base64_encode(base64_encode('9_74'));//CU- Circular 5_36 

          $encryptCGSTNoti = base64_encode(base64_encode('10_84'));//CU- Notification 5_35
          $encryptCGSTCir = base64_encode(base64_encode('10_85'));//CU- Circular 5_36                                         

          $encryptOther =  base64_encode(base64_encode('other'));
          $encryptBudgetAnalysis = base64_encode(base64_encode('budgetAnalysis'));         

          echo "<li class='padding-b-15' style='width: 100%; ' >
                  <div class='table-container'>
                    <h3 class='t-margin-10'>Union Budget {$row['year']}-". (substr($row['year'],2)+1)."</h3>
                    <ul class='boxed-list' style='width:99%'>
                      <li style='width:33%'>
                        <div class='table-container'>
                          <h4 class='t-margin-10'>Service Tax</h4>
                          <ul class='boxed-list' style='width: 100%;'>";
                          echo "<li style='width:50%; padding: 0;'><a target='_blank' href='".$getBaseUrl."unionBudgets?WkVoc2QxcFJQVDA9=".$encryptStNoti."&WlZkV2FHTm5QVDA9=".$encryptYear."'>Notifications</a></li>";
                          echo "<li style='width:50%; padding: 0;'><a target='_blank' href='".$getBaseUrl."unionBudgets?WkVoc2QxcFJQVDA9=".$encryptStCir."&WlZkV2FHTm5QVDA9=".$encryptYear."'>Circulars</a></li>";
                          echo "</ul>
                        </div>
                      </li>
                      <li style='width:33%'>
                        <div class='table-container'>
                          <h4 class='t-margin-10'>Central Excise</h4>
                          <ul class='boxed-list' style='width: 100%;'>";
                          echo "<li style='width:50%; padding: 0;'><a target='_blank' href='".$getBaseUrl."unionBudgets?WkVoc2QxcFJQVDA9=".$encryptCeNoti."&WlZkV2FHTm5QVDA9=".$encryptYear."'>Notifications</a></li>";
                          echo "<li style='width:50%; padding: 0;'><a target='_blank' href='".$getBaseUrl."unionBudgets?WkVoc2QxcFJQVDA9=".$encryptCeCir."&WlZkV2FHTm5QVDA9=".$encryptYear."'>Circulars</a></li>";
                          echo "</ul>
                        </div>
                      </li>
                      <li style='width:33%'>
                        <div class='table-container'>
                          <h4 class='t-margin-10'>Customs</h4>
                          <ul class='boxed-list' style='width: 100%;'>";
                          echo "<li style='width:50%; padding: 0;'><a target='_blank' href='".$getBaseUrl."unionBudgets?WkVoc2QxcFJQVDA9=".$encryptCuNoti."&WlZkV2FHTm5QVDA9=".$encryptYear."'>Notifications</a></li>";
                          echo "<li style='width:50%; padding: 0;'><a target='_blank' href='".$getBaseUrl."unionBudgets?WkVoc2QxcFJQVDA9=".$encryptCuCir."&WlZkV2FHTm5QVDA9=".$encryptYear."'>Circulars</a></li>";
                          echo "</ul>
                        </div>
                      </li>
                    </ul>
                    <ul class='boxed-list' style='width:99 ; display:none;'>
                      <li style='width:49%'>
                        <div class='table-container'>
                          <h4 class='t-margin-10'>SGST</h4>
                          <ul class='boxed-list' style='width: 100%;'>";
                          echo "<li style='width:50%; padding: 0;'><a target='_blank' href='".$getBaseUrl."unionBudgets?WkVoc2QxcFJQVDA9=".$encryptSGSTNoti."&WlZkV2FHTm5QVDA9=".$encryptYear."'>Notifications</a></li>";
                          echo "<li style='width:50%; padding: 0;'><a target='_blank' href='".$getBaseUrl."unionBudgets?WkVoc2QxcFJQVDA9=".$encryptSGSTCir."&WlZkV2FHTm5QVDA9=".$encryptYear."'>Circulars</a></li>";
                          echo "</ul>
                        </div>
                      </li>
                      <li style='width:49%'>
                        <div class='table-container'>
                          <h4 class='t-margin-10'>UTGST</h4>
                          <ul class='boxed-list' style='width: 100%;'>";
                          echo "<li style='width:50%; padding: 0;'><a target='_blank' href='".$getBaseUrl."unionBudgets?WkVoc2QxcFJQVDA9=".$encryptUTGSTNoti."&WlZkV2FHTm5QVDA9=".$encryptYear."'>Notifications</a></li>";
                          echo "<li style='width:50%; padding: 0;'><a target='_blank' href='".$getBaseUrl."unionBudgets?WkVoc2QxcFJQVDA9=".$encryptUTGSTCir."&WlZkV2FHTm5QVDA9=".$encryptYear."'>Circulars</a></li>";
                          echo "</ul>
                        </div>
                      </li>
                     
                    </ul>
                     <ul class='boxed-list' style='width:99%; display:none;'>
                      <li style='width:49%'>
                        <div class='table-container'>
                          <h4 class='t-margin-10'>IGST</h4>
                          <ul class='boxed-list' style='width: 100%;'>";
                          echo "<li style='width:50%; padding: 0;'><a target='_blank' href='".$getBaseUrl."unionBudgets?WkVoc2QxcFJQVDA9=".$encryptIGSTNoti."&WlZkV2FHTm5QVDA9=".$encryptYear."'>Notifications</a></li>";
                          echo "<li style='width:50%; padding: 0;'><a target='_blank' href='".$getBaseUrl."unionBudgets?WkVoc2QxcFJQVDA9=".$encryptIGSTNCir."&WlZkV2FHTm5QVDA9=".$encryptYear."'>Circulars</a></li>";
                          echo "</ul>
                        </div>
                      </li>
                      <li style='width:49%'>
                        <div class='table-container'>
                          <h4 class='t-margin-10'>CGST</h4>
                          <ul class='boxed-list' style='width: 100%;'>";
                          echo "<li style='width:50%; padding: 0;'><a target='_blank' href='".$getBaseUrl."unionBudgets?WkVoc2QxcFJQVDA9=".$encryptCGSTNoti."&WlZkV2FHTm5QVDA9=".$encryptYear."'>Notifications</a></li>";
                          echo "<li style='width:50%; padding: 0;'><a target='_blank' href='".$getBaseUrl."unionBudgets?WkVoc2QxcFJQVDA9=".$encryptCGSTCir."&WlZkV2FHTm5QVDA9=".$encryptYear."'>Circulars</a></li>";
                          echo "</ul>
                        </div>
                      </li>
                     
                    </ul>
                    <ul class='boxed-list' style='width: 50%;'>";
                      echo "<li style='width:50%; padding: 0;'><a target='_blank' href='".$getBaseUrl."unionBudgets?WkVoc2QxcFJQVDA9=".$encryptOther."&WlZkV2FHTm5QVDA9=".$encryptYear."'>Other Documents</a></li>";
                      echo "<li style='width:50%; padding: 0;'><a target='_blank' href='".$getBaseUrl."showMoreData?data=budgets_analysis&WlZkV2FHTm5QVDA9=".$encryptYear."'>Budget Analysis</a></li>";
                      echo "</ul>
                  </div>
              </li>"; 

        }

          echo "</ul>";

        mysqli_free_result($result);

      if(!isset($decryptYear)) {
        $sql = "SELECT  DISTINCT(year(circular_date))'year'
                FROM budgets_union 
                WHERE active_flag = 'Y' 
                AND budget_flag = 'Y'
                ORDER BY circular_date DESC LIMIT 999 OFFSET 1"; 
        $result = mysqli_query($GLOBALS['con'],$sql);

        if(mysqli_num_rows($result) == 0) {   

          echo "<div class='alert alert-danger'>No Data Found</div>";

        } else {
          $fields_num = mysqli_num_fields($result);
    
          echo "<ul class='boxed-list'>"; 
          echo "<li class='padding-b-15' style='width: 80%; ' >
                  <div class='table-container'>
                    <h3 class='t-margin-10'>Previous Year Budgets </h3>
                    <ul class='boxed-list'>";
          while($row = mysqli_fetch_array($result)) {
          $encryptYear = base64_encode(base64_encode($row['year']));

            echo "<li><a target='_blank' href='".$getBaseUrl."unionBudgets?WlZkV2FHTm5QVDA9=".$encryptYear."'>Union Budget {$row['year']}-".(substr($row['year'],2)+1)." </a></li>";
          }

            echo "</ul>
                    </div>
                  </li></ul>";
        }
        mysqli_free_result($result);
      }
 } ?>
      
  </div> 
</div>
<!-- left sec end --> 
<?php include('footer.php'); ?>
