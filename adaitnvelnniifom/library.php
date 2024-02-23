<?php 

	$page = '';
$seoTitle = 'Library';
$seoKeywords = 'Library';
$seoDesc = 'Library';
	include('header.php'); 

?>

 

<?php if(!isset($_GET['page']))  { header('Location: index.php'); } ?>

    <!-- left sec start <div class="col-md-16 col-sm-16"> -->
    <div class="col-md-11 col-sm-9 left-section">

      <h1><?php echo $_GET['page']; ?>

      		<ol class="breadcrumb">

            <li><a href="<?php echo $getBaseUrl; ?>">Home</a></li>           

            <li class="active"><?php echo $_GET['page']; ?></li>                       

          </ol>

          

      </h1>



      <div class="col-md-16">

              <div class="alert alert-danger"> Coming soon.</div>

 

      </div> 

    </div>

    <!-- left sec end --> 



<?php include('footer.php'); ?>
