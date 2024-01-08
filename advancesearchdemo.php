<?php  

	$page = ''; 
	$seoTitle = 'Advanced Search';
	$seoKeywords = 'Advanced Search';
	$seoDesc = 'Advanced Search'; 
	include('header.php');
	 
?>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">


<style type="text/css"> 

a:hover,a:focus{
    text-decoration: none;
    outline: none;
}
#accordion .panel{
    border: none;
    border-radius: 5px;
    box-shadow: none;
    margin-bottom: 10px;
    background: transparent;
}
#accordion .panel-heading{
    padding: 0;
    border: none;
    border-radius: 5px;
    background: transparent;
    position: relative;
}
#accordion .panel-title a{
    display: block;
    padding: 15px 30px;
    margin: 0;
    background: linear-gradient(to bottom, #007ba0 0%,#005389 100%);
    font-size: 15px;
    font-weight: bold;
    color: #fff;
    text-transform: uppercase;
    letter-spacing: 1px;
    border: none;
    border-radius: 5px;
    position: relative;
}
#accordion .panel-title a.collapsed{ border: none; }
#accordion .panel-title a:before,
#accordion .panel-title a.collapsed:before{
    /*content: "\f107";*/
    font-family: "Font Awesome 5 Free";
    width: 30px;
    height: 30px;
    line-height: 27px;
    text-align: center;
    font-size: 25px;
    font-weight: 900;
    color: #fff;
    position: absolute;
    top: 15px;
    right: 30px;
    transform: rotate(180deg);
    transition: all .4s cubic-bezier(0.080, 1.090, 0.320, 1.275);
}
#accordion .panel-title a.collapsed:before{
    color: rgba(255,255,255,0.5);
    transform: rotate(0deg);
}
#accordion .panel-body{
    padding: 0px;
    margin-top: -23px;

    border-top: none;
    border-radius: 5px;
</style>
<!-- left sec start <div class="col-md-16 col-sm-16"> -->
<div class="col-md-11 col-sm-9 left-section">
    <h1>Advance Search
  		<ol class="breadcrumb">
	        <li><a href="<?php echo $getBaseUrl; ?>">Home</a></li>
	        <li class="active">Advance Search</li>
        </ol>
    </h1>
    <div class="col-md-16">
		<?php 
			if(isLogeedIn()) { 
		?>
    		<div class="col-md-16">
    			<div class="col-sm-16 col-md-16 right-section">
    				<div class="bordered" id="articles">
				        <div class="row">
				            <div class="col-sm-16 bt-space sidebar-widget"> 
				                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
				                    <div class="panel panel-default">
				                        <div class="panel-heading" role="tab" id="headingOne" onClick="return searchBody('Case Laws')">
				                            <h4 class="panel-title">
				                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
				                                    Case Laws
				                                </a>
				                            </h4>
				                        </div>
				                        <!-- <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
				                            <div class="panel-body" id="case_law">
				                                
				                            </div>
				                        </div> -->
				                    </div>
				                    <div class="panel panel-default">
				                        <div class="panel-heading" role="tab" id="headingTwo" onClick="return searchBody('Acts and Rules')">
				                            <h4 class="panel-title">
				                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
				                                    Acts/ Rules/ Regulations
				                                </a>
				                            </h4>
				                        </div>
				                        <!-- <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
				                            <div class="panel-body" id='act'>
				                                
				                            </div>
				                        </div> -->
				                    </div>
				                    <div class="panel panel-default">
				                        <div class="panel-heading" role="tab" id="headingThree" onClick="return searchBody('Notification')">
				                            <h4 class="panel-title">
				                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
				                                    Notifications
				                                </a>
				                            </h4>
				                        </div>
				                       <!--  <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
				                            <div class="panel-body" id="notification">
				                                
				                            </div>
				                        </div> -->
				                    </div>
				                    <div class="panel panel-default">
				                        <div class="panel-heading" role="tab" id="headingFour" onClick="return searchBody('Forms')">
				                            <h4 class="panel-title">
				                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
				                                    Forms
				                                </a>
				                            </h4>
				                        </div>
				                        <!-- <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
				                            <div class="panel-body" id="forms">
				                                
				                            </div>
				                        </div> -->
				                    </div>
				                    <div class="panel panel-default">
				                        <div class="panel-heading" role="tab" id="headingFive" onClick="return searchBody('Articles')">
				                            <h4 class="panel-title">
				                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
				                                    Articles
				                                </a>
				                            </h4>
				                        </div>
				                        <!-- <div id="collapseFive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFive">
				                            <div class="panel-body" id="articles1">
				                                
				                            </div>
				                        </div> -->
				                    </div>
				                    <div class="panel panel-default">
				                        <div class="panel-heading" role="tab" id="headingSix" onClick="return searchBody('News')">
				                            <h4 class="panel-title">
				                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
				                                    News
				                                </a>
				                            </h4>
				                        </div>
				                        <!-- <div id="collapseSix" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSix">
				                            <div class="panel-body" id="news">
				                                
				                            </div>
				                        </div> -->
				                    </div>
				                    
				                </div>
				            </div>
				        </div>
				    </div>
			    </div>
			</div>
		<?php		
			} 
			else 
			{
	  			include('loggedInError.php');
	  		}
		?>   
    </div> 
</div>
    <!-- left sec end -->
<?php include('footer.php') ?>
<script type="text/javascript">
	var searchBody=function(data){
		debugger;
		window.location='searchBodydemo?search='+data;
	}
</script>

