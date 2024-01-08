<?php 

	$page = '';
	$seoTitle = 'Case Law - Advanced Search';
	$seoKeywords = 'Case Law - Advanced Search';
	$seoDesc = 'Case Law - Advanced Search';
	include('header.php');
	//print_r($_SESSION);
	if(isset($_REQUEST['q']))
	{
		$search=$_REQUEST['q'];
		$txt=preg_replace("/[<>?''_\"\"|{};:=]/","",$search);
		$value=explode(' ', $txt);
		$replace=array();
		foreach ($value as $k=>$v) {
			$result = mysqli_query($GLOBALS['con'],"SELECT * FROM `short_form` WHERE `short_form` LIKE '%$v%'") or die(mysql_error());	
			while($data = mysqli_fetch_array($result))
			if(mysqli_num_rows($result)>0){
				$replace[]=$data['full_form'];
				
			}
		}
		 $rep_data=implode(' ', array_replace($value, $replace));
		 $text=implode(' ',$value);
		 
		

			$showRecordPerPage =20;
             if(isset($_GET['page']) && !empty($_GET['page'])){
             $currentPage = $_GET['page'];
             }else{
             $currentPage = 1;
             }
             $startFrom = ($currentPage * $showRecordPerPage) - $showRecordPerPage;
             include('count_query.php');
             $res1 = mysqli_query($GLOBALS['con'],$query) or die(mysql_error(mysql_connect($db_host, $db_user, $db_pwd)));
             $count = mysqli_num_rows($res1);
             //$totalEmployee = mysqli_fetch_array($allEmpResult)[0];
             $lastPage = ceil($count/$showRecordPerPage);
             $firstPage = 1;
             $nextPage = $currentPage + 1;
             $previousPage = $currentPage - 1;
             $query."LIMIT $startFrom, $showRecordPerPage";
		     $res1=mysqli_query($GLOBALS['con'],$query." LIMIT $startFrom, $showRecordPerPage") or die(mysql_error());
		     $tocount=mysqli_num_rows($res1);
             


		
		//echo $query;

		$sql="SELECT ce.*,p.prod_name,p.dbsuffix,sp.sub_prod_name,sm.state_name FROM casedata_ce as ce LEFT JOIN product as p ON ce.prod_id=p.prod_id LEFT JOIN sub_product as sp ON ce.sub_prod_id=sp.sub_prod_id LEFT JOIN state_master as sm ON ce.state_id=sm.state_id WHERE (ce.circular_no LIKE '%".$text."%' OR ce.cir_subject LIKE '%".$text."%' OR ce.file_data LIKE '%".$text."%' OR ce.party_name LIKE '%".$text."%') OR (ce.circular_no LIKE '%".$rep_data."%' OR ce.cir_subject LIKE '%".$rep_data."%' OR ce.file_data LIKE '%".$rep_data."%' OR ce.party_name LIKE '%".$rep_data."%')
           UNION
           SELECT ce.*,p.prod_name,p.dbsuffix,sp.sub_prod_name,sm.state_name FROM casedata_cgst as ce LEFT JOIN product as p ON ce.prod_id=p.prod_id LEFT JOIN sub_product as sp ON ce.sub_prod_id=sp.sub_prod_id LEFT JOIN state_master as sm ON ce.state_id=sm.state_id WHERE ce.circular_no LIKE '%".$text."%' OR ce.cir_subject LIKE '%".$text."%' OR ce.file_data LIKE '%".$text."%' OR ce.party_name LIKE '%".$text."%' OR (ce.circular_no LIKE '%".$rep_data."%' OR ce.cir_subject LIKE '%".$rep_data."%' OR ce.file_data LIKE '%".$rep_data."%' OR ce.party_name LIKE '%".$rep_data."%') 
           UNION
           SELECT ce.*,p.prod_name,p.dbsuffix,sp.sub_prod_name,sm.state_name FROM casedata_dgft as ce LEFT JOIN product as p ON ce.prod_id=p.prod_id LEFT JOIN sub_product as sp ON ce.sub_prod_id=sp.sub_prod_id LEFT JOIN state_master as sm ON ce.state_id=sm.state_id WHERE (ce.circular_no LIKE '%".$text."%' OR ce.cir_subject LIKE '%".$text."%' OR ce.file_data LIKE '%".$text."%' OR ce.party_name LIKE '%".$text."%') OR (ce.circular_no LIKE '%".$rep_data."%' OR ce.cir_subject LIKE '%".$rep_data."%' OR ce.file_data LIKE '%".$rep_data."%' OR ce.party_name LIKE '%".$rep_data."%')
           UNION
           SELECT ce.*,p.prod_name,p.dbsuffix,sp.sub_prod_name,sm.state_name FROM casedata_gst as ce LEFT JOIN product as p ON ce.prod_id=p.prod_id LEFT JOIN sub_product as sp ON ce.sub_prod_id=sp.sub_prod_id LEFT JOIN state_master as sm ON ce.state_id=sm.state_id WHERE (ce.circular_no LIKE '%".$text."%' OR ce.cir_subject LIKE '%".$text."%' OR ce.file_data LIKE '%".$text."%' OR ce.party_name LIKE '%".$text."%') OR (ce.circular_no LIKE '%".$rep_data."%' OR ce.cir_subject LIKE '%".$rep_data."%' OR ce.file_data LIKE '%".$rep_data."%' OR ce.party_name LIKE '%".$rep_data."%')
           UNION
           SELECT ce.*,p.prod_name,p.dbsuffix,sp.sub_prod_name,sm.state_name FROM casedata_igst as ce LEFT JOIN product as p ON ce.prod_id=p.prod_id LEFT JOIN sub_product as sp ON ce.sub_prod_id=sp.sub_prod_id LEFT JOIN state_master as sm ON ce.state_id=sm.state_id WHERE (ce.circular_no LIKE '%".$text."%' OR ce.cir_subject LIKE '%".$text."%' OR ce.file_data LIKE '%".$text."%' OR ce.party_name LIKE '%".$text."%') OR (ce.circular_no LIKE '%".$rep_data."%' OR ce.cir_subject LIKE '%".$rep_data."%' OR ce.file_data LIKE '%".$rep_data."%' OR ce.party_name LIKE '%".$rep_data."%')
           UNION
           SELECT ce.*,p.prod_name,p.dbsuffix,sp.sub_prod_name,sm.state_name FROM casedata_sgst as ce LEFT JOIN product as p ON ce.prod_id=p.prod_id LEFT JOIN sub_product as sp ON ce.sub_prod_id=sp.sub_prod_id LEFT JOIN state_master as sm ON ce.state_id=sm.state_id WHERE (ce.circular_no LIKE '%".$text."%' OR ce.cir_subject LIKE '%".$text."%' OR ce.file_data LIKE '%".$text."%' OR ce.party_name LIKE '%".$text."%') OR (ce.circular_no LIKE '%".$rep_data."%' OR ce.cir_subject LIKE '%".$rep_data."%' OR ce.file_data LIKE '%".$rep_data."%' OR ce.party_name LIKE '%".$rep_data."%')
           UNION
           SELECT ce.*,p.prod_name,p.dbsuffix,sp.sub_prod_name,sm.state_name FROM casedata_st as ce LEFT JOIN product as p ON ce.prod_id=p.prod_id LEFT JOIN sub_product as sp ON ce.sub_prod_id=sp.sub_prod_id LEFT JOIN state_master as sm ON ce.state_id=sm.state_id WHERE (ce.circular_no LIKE '%".$text."%' OR ce.cir_subject LIKE '%".$text."%' OR ce.file_data LIKE '%".$text."%' OR ce.party_name LIKE '%".$text."%') OR (ce.circular_no LIKE '%".$rep_data."%' OR ce.cir_subject LIKE '%".$rep_data."%' OR ce.file_data LIKE '%".$rep_data."%' OR ce.party_name LIKE '%".$rep_data."%')
           UNION
           SELECT ce.*,p.prod_name,p.dbsuffix,sp.sub_prod_name,sm.state_name FROM casedata_utgst as ce LEFT JOIN product as p ON ce.prod_id=p.prod_id LEFT JOIN sub_product as sp ON ce.sub_prod_id=sp.sub_prod_id LEFT JOIN state_master as sm ON ce.state_id=sm.state_id WHERE (ce.circular_no LIKE '%".$text."%' OR ce.cir_subject LIKE '%".$text."%' OR ce.file_data LIKE '%".$text."%' OR ce.party_name LIKE '%".$text."%') OR (ce.circular_no LIKE '%".$rep_data."%' OR ce.cir_subject LIKE '%".$rep_data."%' OR ce.file_data LIKE '%".$rep_data."%' OR ce.party_name LIKE '%".$rep_data."%')
           UNION
           SELECT ce.*,p.prod_name,p.dbsuffix,sp.sub_prod_name,sm.state_name FROM casedata_cu as ce LEFT JOIN product as p ON ce.prod_id=p.prod_id LEFT JOIN sub_product as sp ON ce.sub_prod_id=sp.sub_prod_id LEFT JOIN state_master as sm ON ce.state_id=sm.state_id WHERE (ce.circular_no LIKE '%".$text."%' OR ce.cir_subject LIKE '%".$text."%' OR ce.file_data LIKE '%".$text."%' OR ce.party_name LIKE '%".$text."%') OR (ce.circular_no LIKE '%".$rep_data."%' OR ce.cir_subject LIKE '%".$rep_data."%' OR ce.file_data LIKE '%".$rep_data."%' OR ce.party_name LIKE '%".$rep_data."%')
           UNION
           SELECT ce.*,p.prod_name,p.dbsuffix,sp.sub_prod_name,sm.state_name FROM casedata_vat as ce LEFT JOIN product as p ON ce.prod_id=p.prod_id LEFT JOIN sub_product as sp ON ce.sub_prod_id=sp.sub_prod_id LEFT JOIN state_master as sm ON ce.state_id=sm.state_id WHERE (ce.circular_no LIKE '%".$text."%' OR ce.cir_subject LIKE '%".$text."%' OR ce.file_data LIKE '%".$text."%' OR ce.party_name LIKE '%".$text."%') OR (ce.circular_no LIKE '%".$rep_data."%' OR ce.cir_subject LIKE '%".$rep_data."%' OR ce.file_data LIKE '%".$rep_data."%' OR ce.party_name LIKE '%".$rep_data."%') ORDER by data_id DESC LIMIT $startFrom, $showRecordPerPage";
		//$res = mysqli_query($GLOBALS['con'],$sql) or die(mysql_error(mysql_connect($db_host, $db_user, $db_pwd)));
		
		$res = mysqli_query($GLOBALS['con'],$sql) or die(mysql_error(mysql_connect($db_host, $db_user, $db_pwd)));

		//var_dump(mysqli_num_rows($res));
		//print_r(mysqli_fetch_array($res, MYSQL_ASSOC));

			
	} 
?>
<!-- left sec start <div class="col-md-16 col-sm-16"> -->
<div class="col-md-11 col-sm-9 left-section">
    <h1>Case Law  - Quick Search
  		<ol class="breadcrumb">
	        <li><a href="<?php echo $getBaseUrl; ?>">Home</a></li>
	        <li class="active">Case Law  - Quick Search</li>
        </ol>
    </h1>
    <div class="col-md-16">
		<?php 
		// $b=0;
		// for($i = 1; $i <= $rec_count; $i++) {
		// 	$b++;
		// 	$j = $i;
		// 	$k = ($i - 1);
		// 	$i +=$rec_limit;
		// 	//echo ;
		// 	if(($rec_count-$i)>0) {
		// 	echo "<a  " ;
		// 		if(($currentPage!='all')) { 
		// 			if($k==$currentPage || ($currentPage==0) && ($i==20)) { 
		// 				echo "class='active'"; 
		// 			}   
		// 		}
		// 		echo " href='?q=".$text."&&page=".$b."'>$j - $i</a>";
		// 	} else {
		// 	echo "<a ";
		// 			if(($k==$currentPage) || ($rec_count <19)) { 
		// 				echo "class='active'"; 
		// 			}  
		// 	echo "href='?q=".$text."&&page=".$b."'>$j - $rec_count</a>";

		// 	}		
		// }

		// if($rec_count >20) {
		// 	echo "<a ";
		// 			if($currentPage=='all'){ echo "class='active'"; }  
		// 	echo "href='?q=".$text."&&page=".$b."'>All</a>";
		// }

		$rec_count = $count;
		$rec_limit = 19;
		$from=$startFrom+1;
		$to=$from+$tocount-1;

		if(isLogeedIn()) {
		 	if(mysqli_num_rows($res1)>0){
				echo "<div class='new-pagination'>";
					echo "<a ";  
		 			echo "href='#.' style='color:black;'>Showing $from to $to of <b>$rec_count Records</b></a>";
				echo "</div><div class='clear'></div>";

			
				while($row = mysqli_fetch_array($res, MYSQL_ASSOC))
				{
					$file_path = $row['file_path'];
					$file_extn = strtolower(substr($file_path,-3));
					$CatgoryClass = preg_replace('/\s+/', '', $row['prod_name'])."section";
					$encryptID = base64_encode(base64_encode($row['data_id']));
					$dataType=$row['dbsuffix'];
					
					$circular_no = $row['circular_no'] ? $row['circular_no'] : $row['cir_Subject'];

			//		echo $file_extn;

				    echo "<div class='widget-box  $CatgoryClass'><h4>";
				    if(empty($file_path)){
				    	echo getEmptyCircularLink($encryptID, $dataType, $circular_no);
				    }else{
						echo getCircularLink($encryptID, $dataType, $circular_no);
					}	

						echo "<span style='color:#ff7808'>{$row['sub_prod_name']} </span>   <span>&nbsp; | &nbsp;</span>";
						echo "<span style='color:#58a9da'>{$row['prod_name']} </span>    ";
			       		 if(isset($row['State']) != '') {

							echo " <span>&nbsp; | &nbsp;</span><span>{$row['state_name']} </span>   ";
			       		 }
						echo "</h4>";

					if(!empty($row['party_name'])) {
						echo "<h4>";
						echo "<strong style='color:#cf4192; font-size: 13px;'>".$row['party_name']."</strong>";
						echo "</h4>";
			       	}
			        			
		        	echo getDownloadIcon($encryptID, $dataType);	
		        //	$searchKeyword = preg_replace("/\s+/i", "|", rtrim($searchKeyword));
				//echo "<strong style='float: right; margin-right: 10px; margin-top: 0px;'>{$row['Date']}</strong>";
			        echo "<div class='clear'></div>";
					$subject = cleanname($row['cir_subject']);
					$subjectLength = strlen($row['cir_subject']);
					if($subjectLength > 650) {
			        	echo "<p>".preg_replace("/($text)/i", "<mark>$1</mark>", substr($subject,0,650))."... <a href='javascript:void(0)' style='text-decoration:underline;color: #ff7808;' class='readMoreSubject'>[Read more]</a></p>";
			        	echo "<p style='display:none'>".$subject."</p>";
		        	} else {

			    	    echo "<p>".$subject."</p>";
					
					} 		
						echo "</div>";   
				} 
				?>
				<nav class="navigation pagination pagination1 fontNeuron" role="navigation">
    				<ul class="pagination">
		    		<?php
		    			//if($currentPage != $firstPage) {
		    		?>
		    			<li class="page-item active">
		    				<a class="page-link" href="?q=<?php echo $text;?>&&page=<?php echo $firstPage ?>" tabindex="-1" aria-label="Previous">
		          				<span aria-hidden="true">First</span>
		          			</a>		
		    			</li>
		    			<!-- <li class="page-item">
		    				<a class="page-link" href="?q=<?php echo $text;?>&&page=<?php echo $currentPage-1 ?>" tabindex="-1" aria-label="Previous">
		          				<span aria-hidden="true">Previous</span>
		          			</a>		
		    			</li> -->
		    		<?php
		    			//}
		    			if($currentPage >= 2 && $previousPage!=1){
		    		?>
	    				<li class="page-item">
	    					<a class="page-numbers" href="?q=<?php echo $text;?>&&page=<?php echo $previousPage ?>"><?php echo $previousPage ?></a>
	    				</li>
		    		<?php		
		    			}
		    			$c_page=$currentPage;
		    			for($i=1;$i<=10;$i++)
		    			{
		    				
		    				if($c_page<=$lastPage)
		    				{
		    					if($c_page==1){
		    						$c_page++;
		    					}else{	
		    		?>
				    				<li class="page-item <?php if($c_page==$currentPage){echo "active";}?>">
				    					<a class="page-numbers" href="?q=<?php echo $text;?>&&page=<?php echo $c_page ?>"><?php echo $c_page++;?></a>
				    				</li>
		    		<?php		
		    					}
		    				}
		    			} 
		    		?>
		    			<li class="page-item">
		          			<a class="page-numbers" href="?q=<?php echo $text;?>&&page=<?php echo $lastPage ?>" aria-label="Next">
		          				<span aria-hidden="true">Last</span>
		          			</a>
		          		</li>	
		    		</ul>
		    	</nav>
	<?php  
			}
			else
			{ 
				echo '<div class="alert alert-danger always-show" ><strong>No Records Found</strong> - Please try with different word. </div>';
			} 
		}
		else 
		{
  			include('loggedInError.php');
  		}
	?>   
    </div> 
    
    <!-- <nav class="navigation pagination pagination1 fontNeuron" role="navigation">
										
		<ul class="pagination">
          <?php if($currentPage != $firstPage) { ?>
          <li class="page-item">
          <a class="page-link" href="?q=<?php echo $text;?>&&page=<?php echo $firstPage ?>" tabindex="-1" aria-label="Previous">
          	<span aria-hidden="true">First</span>
          </a>
          </li>
          <?php } ?>
          <?php if($currentPage >= 2){ ?>
          <li class="page-item"><a class="page-numbers" href="?q=<?php echo $text;?>&&page=<?php echo $previousPage ?>"><?php echo $previousPage ?></a></li>
          <?php } ?>
          <li class="page-item active"><a class="page-numbers" href="?q=<?php echo $text;?>&&page=<?php echo $currentPage ?>"><?php echo $currentPage ?></a></li>
          <?php if($currentPage != $lastPage) { ?>
          <li class="page-item"><a class="page-numbers" href="?q=<?php echo $text;?>&&page=<?php echo $nextPage ?>"><?php echo $nextPage ?></a></li>
          <li class="page-item">
          <a class="page-numbers" href="?q=<?php echo $text;?>&&page=<?php echo $lastPage ?>" aria-label="Next">
          <span aria-hidden="true">Last</span>
          </a>
          </li>
          <?php } ?>
        </ul>
	</nav> -->
</div>
    <!-- left sec end -->
<?php include('footer.php') ?>

