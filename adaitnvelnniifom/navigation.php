<?php 

function checkCount($prodId,$subProdId=null) {

  if(getRowCountByProd($prodId,$subProdId) <= 0) { 
    echo " style='display: none;' " ; 
  }
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
  <li class="dropdown <?php if(isset($_GET['prod_id']) && $_GET['prod_id'] == 7) { echo 'active'; } ?>"> <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">SGST<span class="ion-chevron-down"></span></a>
    <ul class="dropdown-menu text-capitalize mega-menu full-width-menu" role="menu">
      <li>
        <div class="row">
          <div class="col-sm-16">
            <ul class="mega-sub">
              <li <?php echo checkCount(7,58); ?> ><a href="<?php echo $getBaseUrl; ?>vatArchive?prod_id=7&sub_prod_id=58"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(58); ?></a> </li>
              <li <?php echo checkCount(7,59); ?> ><a href="<?php echo $getBaseUrl; ?>vatArchive?prod_id=7&sub_prod_id=59"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(59); ?></a> </li>
              <li <?php echo checkCount(7,53); ?> ><a href="<?php echo $getBaseUrl; ?>vatArchive?prod_id=7&sub_prod_id=53"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(53); ?></a> </li>
              <li <?php echo checkCount(7,54); ?> ><a href="<?php echo $getBaseUrl; ?>vatArchive?prod_id=7&sub_prod_id=54"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(54); ?></a> </li>
              <li <?php echo checkCount(7,62); ?> ><a href="<?php echo $getBaseUrl; ?>vatyear?prod_id=7&sub_prod_id=62"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(62); ?></a> </li>
              <li <?php echo checkCount(7,57); ?> ><a href="<?php echo $getBaseUrl; ?>vatArchive?prod_id=7&sub_prod_id=57"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(57); ?></a> </li>
              <li <?php echo checkCount(7,60); ?> ><a href="<?php echo $getBaseUrl; ?>vatArchive?prod_id=7&sub_prod_id=60"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(60); ?></a> </li>
              <li <?php echo checkCount(7,92); ?> ><a href="<?php echo $getBaseUrl; ?>vatArchive?prod_id=7&sub_prod_id=92"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(92); ?></a> </li>
            </ul>
          </div>
        </div>
      </li>
    </ul>
  </li>
  <li class="dropdown <?php if(isset($_GET['prod_id']) && $_GET['prod_id'] == 8) { echo 'active'; } ?>"> <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">UTGST<span class="ion-chevron-down"></span></a>
    <ul class="dropdown-menu text-capitalize mega-menu full-width-menu" role="menu">
      <li>
        <div class="row">
          <div class="col-sm-16">
            <ul class="mega-sub">
              <li <?php echo checkCount(8,68); ?> ><a href="<?php echo $getBaseUrl; ?>vatyearfilter?prod_id=8&sub_prod_id=68&s=0&e=20"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(68); ?></a> </li>
              <li <?php echo checkCount(8,65); ?> ><a href="<?php echo $getBaseUrl; ?>vatyear?prod_id=8&sub_prod_id=65"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(65); ?></a> </li>
              <li <?php echo checkCount(8,69); ?> ><a href="<?php echo $getBaseUrl; ?>vatArchive?prod_id=8&sub_prod_id=69"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(69); ?></a> </li>
              <li <?php echo checkCount(8,66); ?> ><a href="<?php echo $getBaseUrl; ?>vatyear?prod_id=8&sub_prod_id=66"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(66); ?></a> </li>
              <li <?php echo checkCount(8,63); ?> ><a href="<?php echo $getBaseUrl; ?>vatArchive?prod_id=8&sub_prod_id=63"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(63); ?></a> </li>
              <li <?php echo checkCount(8,71); ?> ><a href="<?php echo $getBaseUrl; ?>vatyear?prod_id=8&sub_prod_id=71"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(71); ?></a> </li>
              <li <?php echo checkCount(8,64); ?> ><a href="<?php echo $getBaseUrl; ?>vatArchive?prod_id=8&sub_prod_id=64"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(64); ?></a> </li>
              <li <?php echo checkCount(8,72); ?> ><a href="<?php echo $getBaseUrl; ?>vatyear?prod_id=8&sub_prod_id=72"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(72); ?></a> </li>
              <li <?php echo checkCount(8,67); ?> ><a href="<?php echo $getBaseUrl; ?>vatArchive?prod_id=8&sub_prod_id=67"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(67); ?></a> </li>
              <li <?php echo checkCount(8,70); ?> ><a href="<?php echo $getBaseUrl; ?>vatArchive?prod_id=8&sub_prod_id=70"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(70); ?></a> </li>
              <li <?php echo checkCount(8,93); ?> ><a href="<?php echo $getBaseUrl; ?>vatyearfilter?prod_id=8&sub_prod_id=93&s=0&e=20"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(93); ?></a> </li>
            </ul>
          </div>
        </div>
      </li>
    </ul>
  </li>
  <li class="dropdown <?php if(isset($_GET['prod_id']) && $_GET['prod_id'] == 10) { echo 'active'; } ?>"> <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">CGST<span class="ion-chevron-down"></span></a>
    <ul class="dropdown-menu text-capitalize mega-menu full-width-menu" role="menu">
      <li>
        <div class="row">
          <div class="col-sm-16">
            <ul class="mega-sub">
              <li <?php echo checkCount(10,82); ?> ><a href="<?php echo $getBaseUrl; ?>vatyearfilter?prod_id=10&sub_prod_id=82&s=0&e=20"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(82); ?></a> </li>
              <li <?php echo checkCount(10,87); ?> ><a href="<?php echo $getBaseUrl; ?>centralExcise?prod_id=10&sub_prod_id=87"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(87); ?></a> </li>
              <li <?php echo checkCount(10,83); ?> ><a href="<?php echo $getBaseUrl; ?>vatyearfilter?prod_id=10&sub_prod_id=83&s=0&e=20"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(83); ?></a> </li>
              <li <?php echo checkCount(10,88); ?> ><a href="<?php echo $getBaseUrl; ?>centralExcise?prod_id=10&sub_prod_id=88"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(88); ?></a> </li>
              <li <?php echo checkCount(10,84); ?> ><a href="<?php echo $getBaseUrl; ?>centralExcise?prod_id=10&sub_prod_id=84"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(84); ?></a> </li>
              <li <?php echo checkCount(10,89); ?> ><a href="<?php echo $getBaseUrl; ?>centralExcise?prod_id=10&sub_prod_id=89"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(89); ?></a> </li>
              <li <?php echo checkCount(10,85); ?> ><a href="<?php echo $getBaseUrl; ?>centralExcise?prod_id=10&sub_prod_id=85"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(85); ?></a> </li>
              <li <?php echo checkCount(10,90); ?> ><a href="<?php echo $getBaseUrl; ?>centralExcise?prod_id=10&sub_prod_id=90"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(90); ?></a> </li>
              <li <?php echo checkCount(10,86); ?> ><a href="<?php echo $getBaseUrl; ?>centralExcise?prod_id=10&sub_prod_id=86"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(86); ?></a> </li>
              <li <?php echo checkCount(10,95); ?> ><a href="<?php echo $getBaseUrl; ?>vatyearfilter?prod_id=10&sub_prod_id=95&s=0&e=20"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(95); ?></a> </li>
            </ul>
          </div>
        </div>
      </li>
    </ul>
  </li>
  <li class="dropdown <?php if(isset($_GET['prod_id']) && $_GET['prod_id'] == 9) { echo 'active'; } ?>"> <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">IGST<span class="ion-chevron-down"></span></a>
    <ul class="dropdown-menu text-capitalize mega-menu full-width-menu" role="menu">
      <li>
        <div class="row">
          <div class="col-sm-16">
            <ul class="mega-sub">
              <li <?php echo checkCount(9,79); ?> ><a href="<?php echo $getBaseUrl; ?>vatyearfilter?prod_id=9&sub_prod_id=79&s=0&e=20"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(79); ?></a> </li>
              <li <?php echo checkCount(9,75); ?> ><a href="<?php echo $getBaseUrl; ?>vatyear?prod_id=9&sub_prod_id=75"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(75); ?></a> </li>
              <li <?php echo checkCount(9,80); ?> ><a href="<?php echo $getBaseUrl; ?>vatyearfilter?prod_id=9&sub_prod_id=80&s=0&e=20"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(80); ?></a> </li>
              <li <?php echo checkCount(9,76); ?> ><a href="<?php echo $getBaseUrl; ?>vatyear?prod_id=9&sub_prod_id=76"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(76); ?></a> </li>
              <li <?php echo checkCount(9,73); ?> ><a href="<?php echo $getBaseUrl; ?>centralExcise?prod_id=9&sub_prod_id=73"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(73); ?></a> </li>
              <li <?php echo checkCount(9,77); ?> ><a href="<?php echo $getBaseUrl; ?>vatyear?prod_id=9&sub_prod_id=77"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(77); ?></a> </li>
              <li <?php echo checkCount(9,74); ?> ><a href="<?php echo $getBaseUrl; ?>vatyear?prod_id=9&sub_prod_id=74"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(74); ?></a> </li>
              <li <?php echo checkCount(9,78); ?> ><a href="<?php echo $getBaseUrl; ?>vatyear?prod_id=9&sub_prod_id=78"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(78); ?></a> </li>
              <li <?php echo checkCount(9,94); ?> ><a href="<?php echo $getBaseUrl; ?>vatyearfilter?prod_id=9&sub_prod_id=94&s=0&e=20"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(94); ?></a> </li>
            </ul>
          </div>
        </div>
      </li>
    </ul>
  </li>
  <li class="dropdown <?php if(isset($_GET['prod_id']) && $_GET['prod_id'] == 1) { echo 'active'; } ?>"> <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">vat<span class="ion-chevron-down"></span></a>
    <ul class="dropdown-menu text-capitalize mega-menu" role="menu">
      <li>
        <div class="row">
          <div class="col-sm-16">
            <ul class="mega-sub">
              <li><a href="<?php echo $getBaseUrl; ?>vatArchive?prod_id=1&sub_prod_id=12"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(12); ?></a> </li>
              <li><a href="<?php echo $getBaseUrl; ?>vatyear?prod_id=1&sub_prod_id=3"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(3); ?></a> </li>
              <li><a href="<?php echo $getBaseUrl; ?>vatArchive?prod_id=1&sub_prod_id=13"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(13); ?></a> </li>
              <li><a href="<?php echo $getBaseUrl; ?>vatyear?prod_id=1&sub_prod_id=4"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(4); ?></a> </li>
              <li><a href="<?php echo $getBaseUrl; ?>vatArchive?prod_id=1&sub_prod_id=1"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(1); ?></a> </li>
              <li><a href="<?php echo $getBaseUrl; ?>vatyear?prod_id=1&sub_prod_id=28"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(28); ?></a> </li>
              <li><a href="<?php echo $getBaseUrl; ?>vatArchive?prod_id=1&sub_prod_id=2"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(2); ?></a> </li>
              <li><a href="<?php echo $getBaseUrl; ?>vatyear?prod_id=1&sub_prod_id=31"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(31); ?></a> </li>
              <li><a href="<?php echo $getBaseUrl; ?>schedules"><span class="ion-ios-arrow-right"></span>Schedules</a> </li>
              <li class="hidden-sm"> </li>
              <li><a href="<?php echo $getBaseUrl; ?>vatArchive?prod_id=1&sub_prod_id=5"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(5); ?></a> </li>
              <li class="hidden-sm"></li>
              <li><a href="<?php echo $getBaseUrl; ?>vatArchive?prod_id=1&sub_prod_id=14"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(14); ?></a> </li>
            </ul>
          </div>
        </div>
      </li>
    </ul>
  </li>
  <li class="dropdown <?php if(isset($_GET['prod_id']) && $_GET['prod_id'] == 2) { echo 'active'; } ?>"> <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">service tax<span class="ion-chevron-down"></span></a>
    <ul class="dropdown-menu text-capitalize mega-menu" role="menu">
      <li>
        <div class="row">
          <div class="col-sm-16">
            <ul class="mega-sub">
              <li><a href="<?php echo $getBaseUrl; ?>vatyearfilter?prod_id=2&sub_prod_id=15&s=0&e=20"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(15); ?></a> </li>
              <li><a href="<?php echo $getBaseUrl; ?>vatyear?prod_id=2&sub_prod_id=8"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(8); ?></a> </li>
              <li><a href="<?php echo $getBaseUrl; ?>vatyearfilter?prod_id=2&sub_prod_id=16&s=0&e=20"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(16); ?></a> </li>
              <li><a href="<?php echo $getBaseUrl; ?>vatyear?prod_id=2&sub_prod_id=9"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(9); ?></a> </li>
              <li><a href="<?php echo $getBaseUrl; ?>vatyear?prod_id=2&sub_prod_id=6"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(6); ?></a> </li>
              <li><a href="<?php echo $getBaseUrl; ?>vatyear?prod_id=2&sub_prod_id=10"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(10); ?></a> </li>
              <li><a href="<?php echo $getBaseUrl; ?>vatyear?prod_id=2&sub_prod_id=7"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(7); ?></a> </li>
              <li><a href="<?php echo $getBaseUrl; ?>vatyear?prod_id=2&sub_prod_id=11"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(11); ?></a> </li>
            </ul>
          </div>
        </div>
      </li>
    </ul>
  </li>
  <li class="dropdown <?php if(isset($_GET['prod_id']) && $_GET['prod_id'] == 4) { echo 'active'; } ?>"> <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">excise<span class="ion-chevron-down"></span></a>
    <ul class="dropdown-menu text-capitalize mega-menu" role="menu">
      <li>
        <div class="row">
          <div class="col-sm-16">
            <ul class="mega-sub">
              <li><a href="<?php echo $getBaseUrl; ?>vatyearfilter?prod_id=4&sub_prod_id=19&s=0&e=20"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(19); ?></a> </li>
              <li><a href="<?php echo $getBaseUrl; ?>centralExcise?prod_id=4&sub_prod_id=24"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(24); ?></a> </li>
              <li><a href="<?php echo $getBaseUrl; ?>vatyearfilter?prod_id=4&sub_prod_id=20&s=0&e=20"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(20); ?></a> </li>
              <li><a href="<?php echo $getBaseUrl; ?>centralExcise?prod_id=4&sub_prod_id=25"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(25); ?></a> </li>
              <li><a href="<?php echo $getBaseUrl; ?>centralExcise?prod_id=4&sub_prod_id=21"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(21); ?></a> </li>
              <li><a href="<?php echo $getBaseUrl; ?>centralExcise?prod_id=4&sub_prod_id=26"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(26); ?></a> </li>
              <li><a href="<?php echo $getBaseUrl; ?>centralExcise?prod_id=4&sub_prod_id=22"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(22); ?></a> </li>
              <li><a href="<?php echo $getBaseUrl; ?>centralExcise?prod_id=4&sub_prod_id=27"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(27); ?></a> </li>
              <li><a href="<?php echo $getBaseUrl; ?>centralExcise?prod_id=4&sub_prod_id=23"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(23); ?></a> </li>
            </ul>
          </div>
        </div>
      </li>
    </ul>
  </li>
  <li class="dropdown <?php if(isset($_GET['prod_id']) && $_GET['prod_id'] == 5) { echo 'active'; } ?>"> <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">customs<span class="ion-chevron-down"></span></a>
    <ul class="dropdown-menu text-capitalize mega-menu" role="menu">
      <li>
        <div class="row">
          <div class="col-sm-16">
            <ul class="mega-sub">
              <li <?php echo checkCount(5,33); ?> ><a href="<?php echo $getBaseUrl; ?>vatyearfilter?prod_id=5&sub_prod_id=33&s=0&e=20"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(33); ?></a> </li>
              <li <?php echo checkCount(5,39); ?> ><a href="<?php echo $getBaseUrl; ?>centralExcise?prod_id=5&sub_prod_id=39"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(39); ?></a> </li>
              <li <?php echo checkCount(5,34); ?> ><a href="<?php echo $getBaseUrl; ?>vatyearfilter?prod_id=5&sub_prod_id=34&s=0&e=20"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(34); ?></a> </li>
              <li <?php echo checkCount(5,35); ?> ><a href="<?php echo $getBaseUrl; ?>centralExcise?prod_id=5&sub_prod_id=35"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(35); ?></a> </li>              
              <li <?php echo checkCount(5,40); ?> ><a href="<?php echo $getBaseUrl; ?>centralExcise?prod_id=5&sub_prod_id=40"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(40); ?></a> </li>
              <li <?php echo checkCount(5,36); ?> ><a href="<?php echo $getBaseUrl; ?>centralExcise?prod_id=5&sub_prod_id=36"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(36); ?></a> </li>
              <li <?php echo checkCount(5,41); ?> ><a href="<?php echo $getBaseUrl; ?>centralExcise?prod_id=5&sub_prod_id=41"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(41); ?></a> </li>
              <li <?php echo checkCount(5,37); ?> ><a href="<?php echo $getBaseUrl; ?>centralExcise?prod_id=5&sub_prod_id=37"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(37); ?></a> </li>
              <li <?php echo checkCount(5,38); ?> ><a href="<?php echo $getBaseUrl; ?>centralExcise?prod_id=5&sub_prod_id=38"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(38); ?></a> </li>              
            </ul>
          </div>
        </div>
      </li>
    </ul>
  </li>
  <li class="dropdown <?php if(isset($_GET['prod_id']) && $_GET['prod_id'] == 6) { echo 'active'; } ?>"> <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">DGFT<span class="ion-chevron-down"></span></a>
    <ul class="dropdown-menu text-capitalize mega-menu" role="menu">
      <li>
        <div class="row">
          <div class="col-sm-16">
            <ul class="mega-sub">
              <li <?php echo checkCount(6,42); ?> ><a href="<?php echo $getBaseUrl; ?>vatyearfilter?prod_id=6&sub_prod_id=42&s=0&e=20"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(42); ?></a> </li>
              <li <?php echo checkCount(6,43); ?> ><a href="<?php echo $getBaseUrl; ?>vatyearfilter?prod_id=6&sub_prod_id=43&s=0&e=20"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(43); ?></a> </li>
              <li <?php echo checkCount(6,44); ?> ><a href="<?php echo $getBaseUrl; ?>vatyearfilter?prod_id=6&sub_prod_id=44&s=0&e=20"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(44); ?></a> </li>
              <li <?php echo checkCount(6,45); ?> ><a href="<?php echo $getBaseUrl; ?>vatyear?prod_id=6&sub_prod_id=45"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(45); ?></a> </li>
              <li <?php echo checkCount(6,46); ?> ><a href="<?php echo $getBaseUrl; ?>vatyear?prod_id=6&sub_prod_id=46"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(46); ?></a> </li>
              <li <?php echo checkCount(6,47); ?> ><a href="<?php echo $getBaseUrl; ?>vatyear?prod_id=6&sub_prod_id=47"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(47); ?></a> </li>
              <li <?php echo checkCount(6,48); ?> ><a href="<?php echo $getBaseUrl; ?>vatyear?prod_id=6&sub_prod_id=48"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(48); ?></a> </li>
              <li <?php echo checkCount(6,49); ?> ><a href="<?php echo $getBaseUrl; ?>vatyear?prod_id=6&sub_prod_id=49"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(49); ?></a> </li>
            </ul>
          </div>
        </div>
      </li>
    </ul>
  </li>
   <li class="dropdown <?php if(isset($_GET['prod_id']) && $_GET['prod_id'] == 7) { echo 'active'; } ?>"> <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">GST Caselaws<span class="ion-chevron-down"></span></a>
    <ul class="dropdown-menu text-capitalize mega-menu full-width-menu" role="menu">
      <li>
        <div class="row">
          <div class="col-sm-16">
            <ul class="mega-sub">
              <li <?php echo checkCount(7,55); ?> ><a href="<?php echo $getBaseUrl; ?>vatyear?prod_id=7&sub_prod_id=55"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(55); ?></a> </li>
              <li <?php echo checkCount(7,56); ?> ><a href="<?php echo $getBaseUrl; ?>vatyear?prod_id=7&sub_prod_id=56"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(56); ?></a> </li>
              <li <?php echo checkCount(7,61); ?> ><a href="<?php echo $getBaseUrl; ?>vatyear?prod_id=7&sub_prod_id=61"><span class="ion-ios-arrow-right"></span><?php echo getSubProdName(61); ?></a> </li>
              <li <?php echo checkCount(7,96); ?> ><a href="<?php echo $getBaseUrl; ?>vatyear?prod_id=7&sub_prod_id=96"><span class="ion-ios-arrow-right"></span>AAR</a> </li>
              <li <?php echo checkCount(7,98); ?> ><a href="<?php echo $getBaseUrl; ?>vatyear?prod_id=7&sub_prod_id=98"><span class="ion-ios-arrow-right"></span>AAAR</a> </li>
              <li <?php echo checkCount(7,97); ?> ><a href="<?php echo $getBaseUrl; ?>vatyear?prod_id=7&sub_prod_id=97"><span class="ion-ios-arrow-right"></span>NAA Order</a> </li>
              <li <?php echo checkCount(7,62); ?> ><a href="<?php echo $getBaseUrl; ?>vatyear?prod_id=7&sub_prod_id=62"><span class="ion-ios-arrow-right"></span>MISC</a> </li>
            </ul>
          </div>
        </div>
      </li>
    </ul>
  </li>

</ul>
<style>
.full-width-menu { min-width: 175px; }
.full-width-menu ul.mega-sub li { width: 100%; }
</style>
