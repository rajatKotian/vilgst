<?php
 include('conn.php');
    // $db_host = 'localhost';

    // $db_user = 'root';
    // $db_pwd = '';
    // $database = 'vilgst12_vilgstprod';
   

    // $db_pwd = '7d@pPn_zkwdb'; 
    // $db_user = 'vilgst12_gstweb';
    // $database = 'vilgst12_vilgstprod';
    
    // $db_pwd = 'Tjew7=Ag)OuO'; 
    // $db_user = 'vilgst12_new';
    // $database = 'vilgst12_vilgstprod';

    if (!mysqli_connect($db_host, $db_user, $db_pwd,$database)) {
      die("Can't connect to database");
    }   

    // if (!mysqli_select_db($con,$database)) {
    //   die("Can't select database");
    // }    
  

    // Highlight words in text
    if(isset($_REQUEST['keyword']) && isset($_REQUEST['searchby']) && isset($_REQUEST['type']))
    {
      $key_word=mysqli_real_escape_string($con,$_REQUEST['keyword']);
      //highlight the search word
      function highlight($data,$keywords){
        foreach($keywords as $keyword)
        {
            $data = str_ireplace($keyword, "<b>$keyword</b>", $data);
            //$data=preg_replace("/".preg_quote($keyword, "/")."/i","<b>$1</b>",$data);
        }
        return $data; 
      }

      $value1=[];
      if($_REQUEST['searchby']=='0') // 0 for like search and 1 for  exactly search
      {
        $value=trim(preg_replace('/[^A-Za-z0-9]/', ' ', $key_word)); // Removes special chars.
        $value1=explode(' ',$value);
      }
      else
      {
        $value=$key_word;
        $value1[]=$key_word;
      }


      if($_REQUEST['type']=='goods')
      {   
        $where="";
        $count=0; 
        if($_REQUEST['searchby']=='0')
        {
          foreach($value1 as $word)
          {
            if ($count > 0){
              $where .= " AND";
            }
            $where .= "`chapter` LIKE '%$word%' OR `desc` LIKE '%$word%' OR`cgst_rate` LIKE '%$word%' OR`igst_rate` LIKE '%$word%' OR `sgst/utgst_rate` LIKE '%$word%' OR `cess` LIKE '%$word%'";
            $count++;
          }
        }
        else
        {
            foreach($value1 as $word)
            {
              $where .= "`chapter` regexp '[[:<:]]".$word."[[:>:]]' OR `desc` regexp '[[:<:]]".$word."[[:>:]]' OR`cgst_rate` regexp '[[:<:]]".$word."[[:>:]]' OR`igst_rate` regexp '[[:<:]]".$word."[[:>:]]' OR `sgst/utgst_rate` regexp '[[:<:]]".$word."[[:>:]]' OR `cess` regexp '[[:<:]]".$word."[[:>:]]'";
            }
        }
        $result = mysqli_query($GLOBALS['con'],"SELECT * FROM `gst_rate_gd` WHERE $where ") or die(mysqli_error());
        $num = mysqli_num_rows($result);
        $middle='';
        if(empty($num))
        {
          $middle='<tr><td colspan="6" align="center">keyword Not Found</td></tr>';            
        }
        else
        {
          while($rate_res=mysqli_fetch_array($result))
          {
            $middle.='<tr>'.
            
              '<td>'.preg_replace("`(".$value.")`i","<b>$1</b>",$rate_res['chapter']).'</td>'.
              //'<td>'.preg_replace("/($value1[0])/i/($value1[0])/i","<b>$1</b>",$rate_res['desc']).'</td>'.
              '<td>'.highlight($rate_res['desc'], $value1).'</td>'.
              '<td>'.preg_replace("`(".$value.")`i","<b>$1</b>",$rate_res['cgst_rate']).'</td>'.
              '<td>'.preg_replace("`(".$value.")`i","<b>$1</b>",$rate_res['sgst/utgst_rate']).'</td>'.
              '<td>'.preg_replace("`(".$value.")`i","<b>$1</b>",$rate_res['igst_rate']).'</td>'.
              '<td>'.preg_replace("`(".$value.")`i","<b>$1</b>",$rate_res['cess']).'</td>'.
             '</tr>';
          }
          
        }
        $count=mysqli_num_rows($result);
      } 

      if($_REQUEST['type']=='service')
      {   
        //print_r($value1); die();
        $where="";
        $count=0;
        if($_REQUEST['searchby']=='0')
        {
          foreach($value1 as $word)
          {
            if ($count > 0){
              $where .= " AND";
            }
            $where .= " `section` LIKE '%$word%' OR `chapter` LIKE '%$word%' OR `desc` LIKE '%$word%' OR`cgst_rate` LIKE '%$word%' OR`igst_rate` LIKE '%$word%' OR `sgst/utgst_rate` LIKE '%$word%' OR `condition` LIKE '%$word%'";
            $count++;
          }
        }
        else
        {
          $where .= "`section` regexp '[[:<:]]".$word."[[:>:]]' OR `chapter` regexp '[[:<:]]".$word."[[:>:]]' OR `desc` regexp '[[:<:]]".$word."[[:>:]]' OR`cgst_rate` regexp '[[:<:]]".$word."[[:>:]]' OR`igst_rate` regexp '[[:<:]]".$word."[[:>:]]' OR `sgst/utgst_rate` regexp '[[:<:]]".$word."[[:>:]]' OR `condition` regexp '[[:<:]]".$word."[[:>:]]'";
        }
        
        $result = mysqli_query($GLOBALS['con'],"SELECT * FROM `gst_rate_se` WHERE $where ") or die(mysqli_error());
        $num = mysqli_num_rows($result);
        $middle='';
        if(empty($num))
        {
          $middle='<tr><td colspan="7" align="center">keyword Not Found</td></tr>';            
        }
        else
        {
          while($rate_res=mysqli_fetch_array($result))
          {
            $middle.='<tr>'.
              '<td>'.preg_replace("`(".$value.")`i","<b>$1</b>",$rate_res['section']).'</td>'.  
              '<td>'.preg_replace("`(".$value.")`i","<b>$1</b>",$rate_res['chapter']).'</td>'.
              //'<td>'.preg_replace("/($value1[0])/i/($value1[0])/i","<b>$1</b>",$rate_res['desc']).'</td>'.
              '<td>'.highlight($rate_res['desc'], $value1).'</td>'.
              '<td>'.preg_replace("`(".$value.")`i","<b>$1</b>",$rate_res['cgst_rate']).'</td>'.
              '<td>'.preg_replace("`(".$value.")`i","<b>$1</b>",$rate_res['sgst/utgst_rate']).'</td>'.
              '<td>'.preg_replace("`(".$value.")`i","<b>$1</b>",$rate_res['igst_rate']).'</td>'.
              '<td>'.highlight($rate_res['condition'], $value1).'</td>'.
             '</tr>';
          }
          
        }
        $count=mysqli_num_rows($result);
      } 

      if($_REQUEST['type']=='hsn')
      {   
        $where="";
        $count=0;
        if($_REQUEST['searchby']=='0')
        {
          foreach($value1 as $word)
          {
            if ($count > 0){
              $where .= " AND";
            }
            $where .= " `hsn_code` LIKE '%$word%' OR `desc` LIKE '%$word%'";
            $count++;
          }
        }
        else
        {
          $where .= "`hsn_code` regexp '[[:<:]]".$word."[[:>:]]' OR `desc` regexp '[[:<:]]".$word."[[:>:]]'";
        }

        $result = mysqli_query($GLOBALS['con'],"SELECT * FROM `gst_rate_hsn` WHERE $where ") or die(mysqli_error());
        $num = mysqli_num_rows($result);
        $middle='';
        if(empty($num))
        {
          $middle='<tr><td colspan="2" align="center">keyword Not Found</td></tr>';            
        }
        else
        {
          while($rate_res=mysqli_fetch_array($result))
          {
            $middle.='<tr>'.
              '<td>'.preg_replace("`(".$value.")`i","<b>$1</b>",$rate_res['hsn_code']).'</td>'.
              '<td>'.highlight($rate_res['desc'], $value1).'</td>'.
             '</tr>';
          }
          
        }
        $count=mysqli_num_rows($result);
      } 
      //echo "hello";
      //echo $count; die(); 
      $tot_count=$count." Record Found";
      $ret_data=array($middle,$tot_count);
      $returnValues=$ret_data;
      echo json_encode($returnValues);
      die();
    }
?>
<?php 
  $page = 'homePage';
  $seoTitle = 'Home';
  $pageType = 'index';
  include('header.php');
?>
</div>
</div>

  <div class="container main-container main_div">

  <div class="row"> 
<div class="col-md-16 col-sm-16 text-center left-section homepage">

  <div class="tab">
    <button class="tablinks active" onclick="openCity(event, 'London')"><i class="fa fa-snowflake-o"></i> &nbsp;Services</button>
    <button class="tablinks" onclick="openCity(event, 'Paris')"><i class="fa fa-industry"></i> &nbsp;Goods</button>
    <button class="tablinks" onclick="openCity(event, 'Tokyo')"> <i class="fa fa-barcode"></i> &nbsp;GST HSN Code</button>
  </div>

  <div id="London" class="tabcontent" style="display: block;">
    <div class="rate-finder">
      <div class="gst-search">
        <h2>Service Rate Finder</h2>
        <div class="row"  style="padding-right: 15px;">
          <div class="col-md-8 col-md-offset-3 text-left">
            <form class="">
              <input type="seach" placeholder="Search by Keywords " class="form-control" name="service_search" id="service_search" autofocus>
              <p id="service_error" style="color: red; font-size: 12px; text-align: center; display: none;"><i>Insert Some keyword for Search</i></p>
              <div class="text-center">
                <div class="row">
                  <div class="col-md-16  col-xs-16">
                    <div class="row">
                      <div class="col-md-8 col-xs-6 text-right">
                        <p> <input type="radio" class="service" name="service" value="1" checked>&nbsp; Exactly</p>
                      </div>
                      <div class="col-md-8 col-xs-6 text-left">
                        <p> <input type="radio" class="service" value="0" name="service">&nbsp; Like</p>
                      </div>
                    </div>
                  </div> 
                </div>
              </div>
            </form>
          </div>

          <div class="col-md-2">
            <button class="btn btn-search" id="service_btn" >Search</button>
          </div>

        </div>
        <br> <br>
        <?php 
        if(isLogeedIn()) {
            if($_SESSION["userStatus"]=="expired") {
              include('expiredUserError.php'); 
            } else {
                if($_SESSION["type"]!="T")
                {
        ?>
                <div class="loader" style="display: none">
          <img src="images/loader.gif">
        </div>
                <div class="row show_service"  style="display: none">
          
          <p style="text-align: right; margin-right: 40px; padding: 0px; margin: 0px 34px 0px 0px;" id="show_service_count"></p>
          <div class="table-responsive" style="height: 500px; padding-right: 15px; overflow: scroll; box-shadow: 2px 2px 3px #c1c1c1;">
            <table class="table table-bordered table-hover table-striped">
              <thead>
                <tr>
                  <th>Section</th>
                  <th>Chapter/Section/Heading</th>
                  <th>Description of Service</th>
                  <th>CGST Rate(%)</th>
                  <th>SGST/UTGST Rate(%)</th>
                  <th>IGST Rate(%)</th>
                  <th width="300">Condition</th>
                </tr>
              </thead>
              <tbody id="show_service">
                
              </tbody>
            </table>
          </div>
        </div>
      
        <?php
            }else{
              include('tempUsererror.php');
            }
            }
        }
        else 
        {
            include('loggedInError.php');
        }
        ?>
      </div>
    </div>
  </div>

  <div id="Paris" class="tabcontent">
    <div class="rate-finder">
      <div class="gst-search">
        <h2>Goods Rate Finder</h2>
        <div class="row"  style="padding-right: 15px;">
          <div class="col-md-8 col-md-offset-3 text-left">
            <form>
              <input type="seach" placeholder="Search by Keywords " class="form-control" name="good_search" id="good_search" autofocus>
              <p id="good_error" style="color: red; font-size: 12px; text-align: center; display: none;"><i>Insert Some keyword for Search</i></p>
              <div class="text-center">
                <div class="row">
                  <div class="col-md-16  col-xs-16">
                    <div class="row">
                      <div class="col-md-8 col-xs-6 text-right">
                        <p> <input type="radio" class="goods" value="1" name="goods" checked>&nbsp; Exactly</p>
                      </div>
                      <div class="col-md-8 col-xs-6 text-left">
                        <p> <input type="radio" class="goods" value="0" name="goods">&nbsp; Like</p>
                      </div>
                    </div>
                  </div> 
                </div>
              </div>
            </form>
          </div>
          <div class="col-md-2">
            <button class="btn btn-search" id="good_btn" >Search</button>
          </div>
        </div>
        <br> <br>
        <?php
        if(isLogeedIn())
        {
            if($_SESSION["userStatus"]=="expired") {
              include('expiredUserError.php'); 
            } else {
                if($_SESSION["type"]!="T")
                {
        ?>
                <div class="loader" style="display: none">
                  <img src="images/loader.gif">
                </div>
                <div class="row show_goods" style="display: none;">
                  <p style="text-align: right; margin-right: 40px; padding: 0px; margin: 0px 34px 0px 0px;" id="show_goods_count"></p>
                  <div class="table-responsive" style="height: 500px; padding-right: 15px; overflow: scroll; box-shadow: 2px 2px 3px #c1c1c1;">
                    <table class="table table-bordered table-hover table-striped">
                      <thead>
                        <tr>
                          <th>Chapter/Section/Heading</th>
                          <th>Description of Service</th>
                          <th>CGST Rate(%)</th>
                          <th>SGST/UTGST Rate(%)</th>
                          <th>IGST Rate(%)</th>
                          <th>CESS</th>
                        </tr>
                      </thead>
                      <tbody id="show_goods">
                        
                      </tbody>
                    </table>
                  </div>
                </div>
        <?php
            }else{
              include('tempUsererror.php');
            }
            }
          } 
          else 
          {
            include('loggedInError.php');
          }
        ?>
      </div>
    </div>
  </div>

  <div id="Tokyo" class="tabcontent">
    <div class="rate-finder">
      <div class="gst-search">
        <h2>HSN Code List Finder</h2>
        <div class="row"  style="padding-right: 15px;">
          <div class="col-md-8 col-md-offset-3 text-left">
            <form>
              <input type="seach" placeholder="Search by HSN Code (e.g. 1011090) or Keywords " class="form-control" name="hsn_search" id="hsn_search" autofocus>
              <p id="hsn_error" style="color: red; font-size: 12px; text-align: center; display: none;"><i>Insert Some keyword for Search</i></p>
              <div class="text-center">
                <div class="row">
                  <div class="col-md-16  col-xs-16">
                    <div class="row">
                      <div class="col-md-8 col-xs-6 text-right">
                        <p> <input type="radio" class="hsn" name="hsn" checked value="1">&nbsp; Exactly</p>
                      </div>
                      <div class="col-md-8 col-xs-6 text-left">
                        <p> <input type="radio" class="hsn" name="hsn" value="0">&nbsp; Like</p>
                      </div>
                    </div>
                  </div> 
                </div>
              </div>
            </form>
          </div>

          <div class="col-md-2">
            <button class="btn btn-search" id="hsn_btn" >Search</button>
          </div>
        </div>
        <br> <br>
        <?php
        if(isLogeedIn())
        {
            if($_SESSION["userStatus"]=="expired") {
              include('expiredUserError.php'); 
            } else {
            if($_SESSION["type"]!="T")
              {
        ?>
                <div class="loader" style="display: none">
                  <img src="images/loader.gif">
                </div>
                <div class="row show_hsn" style="display: none;">
                  <p style="text-align: right; margin-right: 40px; padding: 0px; margin: 0px 34px 0px 0px;" id="show_hsn_count"></p>
                  <div class="table-responsive" style="height: 500px; padding-right: 15px; overflow: scroll; box-shadow: 2px 2px 3px #c1c1c1;">
                    <table class="table table-bordered table-hover table-striped">
                      <thead>
                        <tr>
                          <th>HSN Code</th>
                          <th>Description</th>
                        </tr>
                      </thead>
                      <tbody id="show_hsn">
                        
                      </tbody>
                    </table>
                  </div>
                </div>
        <?php
             }else{
              include('tempUsererror.php');
            }
            }
          } 
          else 
          {
            include('loggedInError.php');
          }
        ?>
      </div>
    </div>
  </div>

<!-- left sec start -->
</div>
   </div>
    </div>
    <!-- left sec end --> 
    <!-- <div id="show_gst_rate" style="display: none;">
    </div> -->

<?php 
  include('footer.php');
?>
    <!-- left sec end -->
 <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

<style>

.table-responsive>.table>thead>tr>th
{
  background: #005c80;
    color: #fff;
}
.table-responsive>.table>thead>tr>th, .table-responsive>.table>tbody>tr>th, .table-responsive>.table>tfoot>tr>th, .table-responsive>.table>thead>tr>td, .table-responsive>.table>tbody>tr>td, .table-responsive>.table>tfoot>tr>td {
    white-space: inherit!important;
    text-align: left;
    vertical-align: top;
}
@media(max-width:767px)
{
.btn-search
{
      margin-top: 10px;
}
.table-responsive>.table>thead>tr>th:nth-child(3), .table-responsive>.table>thead>tr>th:nth-child(7)
{
 padding: 8px 100px;

}
}


  p
  {
    padding: 0px 20px;
    margin: 10px 0px 0px 0px;
  }
  input[type="radio"]
  {
    width: 16px;
    height: 16px;
    margin-left: 10px;
    position: absolute;
    margin-left: -10px;
    margin-top: 2px;
  }
  .right-section
  {
    display: none;
  }
    .btn-search
{
    width: 100%;
    padding: 8px;
}

.tab {
overflow: hidden;
    border-bottom: 1px solid #ededed;
}

.tab button {
    border: none;
    outline: none;
    cursor: pointer;
    padding: 10px 20px;
    transition: 0.3s;
    font-size: 16px;
    font-weight: 600;
    color: #fdfdfd;
    background: #005f90;
}

.tab button:hover {
 background-color: #ff7808;
    color: #fff;
    font-weight: 600;
}

.tab button.active {
    background-color: #ff7808;
    color: #fff;
    font-weight: 600;
}

.tabcontent {
  display: none;
  padding: 6px 12px;
  border: 1px solid #ededed;
  border-top: none;
      background: #e6edf1;
}
.gst-search h2
{
  color: #ff7808;
    border-bottom: 1px solid #ff7808;
    box-shadow: 0 1px 0 #ccc;
    font-size: 20px;
    margin: 0 5px 15px 0;
    padding-bottom: 10px;
    overflow: hidden;
}
.btn-search
{
  transition: 0.3s;
    border:none;
}
.btn-search:hover
{
  letter-spacing: 4px;
  background:linear-gradient(to bottom, #ff7708 1%,#ffa000 100%);
  border:none;
}
.form-control::placeholder
{
  color: #868686;
}

.loader img 
{
    width: auto;
    height: 50px;
}
@media(max-width: 767px)
{
  .tab button
  {
    width: 100%;
  }
}
</style>

<script>
function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}
</script>

<script type="text/javascript">
  $(document).ready(function(){
    $('#service_search').keypress(function (e) {
        if(e.which == 13)  // the enter key code
        {
          $('#service_btn').click();
          return false;  
        }
    });

    $('#good_search').keypress(function (e) {
        if(e.which == 13)  // the enter key code
        {
          $('#good_btn').click();
          return false;  
        }
    }); 

    $('#hsn_search').keypress(function (e) {
        if(e.which == 13)  // the enter key code
        {
          $('#hsn_btn').click();
          return false;  
        }
    });  
    $("#service_btn").click(function(){
      debugger;
      var val=$.trim($("#service_search").val());
      if(val=="")
      {
        $("#service_error").css('display','block');
        return false;
      }
      var searchby=$("input[name='service']:checked").val();
      
      getSearchResult(val,'show_service','service',searchby);
    });

    $("#good_btn").click(function(){
      debugger;
      var val=$.trim($("#good_search").val());
      if(val=="")
      {
        $("#good_error").css('display','block');
        return false;
      }
      var searchby=$("input[name='goods']:checked").val();

      getSearchResult(val,'show_goods','goods',searchby);
    });

    $("#hsn_btn").click(function(){
      debugger;
      var val=$.trim($("#hsn_search").val());
      if(val=="")
      {
        $("#hsn_error").css('display','block');
        return false;
      }
      var searchby=$("input[name='hsn']:checked").val();

      getSearchResult(val,'show_hsn','hsn',searchby);
    });


    function getSearchResult(keyword,datatable,type,searchby)
    {
      debugger;
      $.ajax({
          url  : 'gst-finderdemo.php', //php page URL where we post this data to view from database
          type :'POST',
          data : {'keyword':keyword,'type':type,'searchby':searchby},
          dataType: 'json',
          cache: false, 
          beforeSend: function(){
              $('.loader').show();
              $("."+datatable).css('display','none');
          },
          complete: function(){
              $('.loader').hide();
              //$("."+datatable).css('display','none');
          },
          success: function(data){
            org_data=$.trim(data[0]);
            debugger;
            $("."+datatable).css('display','block');
            $("#"+datatable).html(org_data);
            $("#"+datatable+'_count').html('<b>'+data[1]+'</b>');
          
            $("#show_gst_rate").css('display','block');
            $("#home_view").css('display','none');
          }

      });
    } 
  });
</script>