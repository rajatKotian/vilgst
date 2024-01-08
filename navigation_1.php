<?php 

function checkCount($prodId,$subProdId=null) {

  if(getRowCountByProd($prodId,$subProdId) <= 0) { 
    echo " style='display: none;' " ; 
  }
} 

function GetMenu($parentid=0){
  return getDbRecord('menu','parent_id',$parentid);
}

function getSubProdName($subProdId) {
  $getDbRecord = getDbRecord('sub_product', 'sub_prod_id', $subProdId);
  echo $getDbRecord['sub_prod_name']; 
}
?>
<ul class="nav navbar-nav text-uppercase main-nav ">
  <li class="<?php if($page == 'homePage') { echo 'active'; } ?>">
    <a href="<?php echo $getBaseUrl; ?>" style="padding-left: 0;"><span class="ion-ios-home" style="font-size: 20px; padding-right: 8px; margin-top: -1px; float: left;"></span>home</a>
  </li>
  <?php

    
    $res=mysqli_query($GLOBALS['con'],'SELECT * FROM menu where parent_id=0');
    while($value=mysqli_fetch_array($res)){
      # code...
     
      $submenuCountQuery = mysqli_query($GLOBALS['con'],"SELECT count(*) FROM menu where parent_id='".$value['id']."'");
      $countrow = mysqli_fetch_array($submenuCountQuery);
	  $countValue = $countrow[0];
   
      
      ?>
      <li class="dropdown "> 
	  <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
	  <?php if($value["menu_name"]=="SGST"){echo $value["menu_name"].' + Cess';}else{echo $value["menu_name"] ;} ?>
	  
	  <!-- commented by harshal on 11-05-2020 -->
	  <?php if($value["menu_name"]=="MISC") { ?>
	   <span class="ion-chevron-down"></span>
	  <?php } ?>
	  </a>
      <?php if($countValue) {
		$ressubmenu=mysqli_query($GLOBALS['con'],"SELECT * FROM menu where parent_id='".$value['id']."'");
		?> 
			<ul class="dropdown-menu text-capitalize mega-menu full-width-menu" role="menu">
      <li>
        <div class="row">
          <div class="col-sm-16">
            <ul class="mega-sub">
              <?php
                while ($submenu=mysqli_fetch_array($ressubmenu)) {
                  // continue;
                //preg_match_all('#=([^\s]+)#', $submenu["url"], $matches);
                  preg_match_all('#=([0-9]+)#', $submenu["url"], $matches);
                  // print_r($submenu);
                  // continue;
                    if ($submenu["menu_name"] == 'Tribunal') {
                           continue;
                           }
              ?>
                <li <?php if(!empty($matches[1][0] )){echo checkCount($matches[1][0],$matches[1][1]);} ?> ><a href="<?php echo $getBaseUrl . $submenu["url"]; ?>"><span class="ion-ios-arrow-right"></span>
                <?php
               
                      if (in_array(strtolower($submenu["menu_name"]), array('aar', 'naa order', 'aaar'))) {
                          
                        echo strtoupper($submenu["menu_name"]);
                        } else {
                            echo ucwords(strtolower($submenu["menu_name"]));
                        }
                ?>
                </a></li>
              <?php
              }
              ?>
            </ul>
          </div>
        </div>
      </li>
    </ul>
	  <?php } ?>
    
  </li>
      <?php    
    }
  ?>
  
 
</ul>
<style>
.full-width-menu { min-width: 175px; }
.full-width-menu ul.mega-sub li { width: 100%; }
</style>
