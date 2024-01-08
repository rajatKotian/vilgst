<ul class="nav navbar-nav text-uppercase main-nav ">
  <li class="<?php if($page == 'exploreInvoices') { echo 'active'; } ?>">
    <a href="<?php echo $getBaseUrl; ?>invoice/index.php" style="padding-left: 0;"><span class="ion-clipboard" style="font-size: 20px; padding-right: 8px; margin-top: -1px; float: left;"></span>Explore Invoices</a>
  </li>
  <li class="<?php if($page == 'uploadInvoices') { echo 'active'; } ?>" style="padding-left: 15px;">
    <a href="<?php echo $getBaseUrl; ?>invoice/uploadFiles.php" style="padding-left: 0;"><span class="ion-share" style="font-size: 20px; padding-right: 8px; margin-top: -1px; float: left;"></span>Upload Invoices</a>
  </li>
</ul>
