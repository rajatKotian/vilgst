<?php
  $page = 'exploreInvoices';
  $seoTitle = 'Home';
  $pageType = 'index';
  include('header.php');
?>
     <!-- left sec start -->
    <div class="col-md-16" style="margin: 20px auto">
      <h1>Explore Invoices</h1>
      <div style="border: 1px solid #bebebe; background: #ffffeb; border-radius: 5px; padding: 20px; width: 80%; margin: 20px auto; box-shadow: inset 0px 0px 1px rgba(0,0,0,0.5); min-height: 200px;">
      <?php 

      $dir    = 'uploads';
$files = array_diff(scandir($dir), array('.', '..'));

foreach($files as $filename){
   //Simply print them out onto the screen.
  echo "<div style='width:100px;display:inline-block; margin: 10px 10px; text-align: center; font-size: 10px;'>";
   echo "<a href='uploads/".$filename."' target='_blank'><img src='images/pdf.png' /></a><br>";
   echo $filename, '<br>'; 
   echo "</div>";
}
      ?>


      </div>
 
    </div>
    <!-- left sec end --> 

<?php 
  include('footer.php');
?>
 
