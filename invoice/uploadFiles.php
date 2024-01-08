<?php
  $page = 'uploadInvoices';
  $seoTitle = 'Home';
  $pageType = 'index';
  include('header.php');
?>

<link href="css/uploadfile.css" rel="stylesheet">

    <!-- left sec start -->
    <div class="col-md-16" style="margin: 20px auto">
      <h1>Upload Invoices</h1>
      <div style="border: 1px solid #bebebe; background: #f5f0f0; border-radius: 5px; padding: 20px; width: 80%; margin: 20px auto; box-shadow: inset 0px 0px 1px rgba(0,0,0,0.5)">
        <div id="fileuploader">Upload</div>
      </div>
 
    </div>
    <!-- left sec end --> 

<?php 
  include('footer.php');
?>
<script src="js/jquery.uploadfile.min.js"></script>
<script>
$(document).ready(function()
{
   $("#fileuploader").uploadFile({
  url:"upload.php",
  multiple:true,
  dragDrop:true,
  fileName:"myfile"
  }); 
  });
</script>
