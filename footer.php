<?php 
  if($page != 'showIframe' && $page != 'showCOI' && $page != 'paidService' && $page != 'AdvancedSearch') {
    include('sidebar.php');  
  }
?>
  </div>
</div>
<style>
  footer .footer-left
  {
    min-height: 150px!important;
  }
  .search-input textarea { height: 80px; width: 100%; outline: none; border: none; border-radius: 5px; padding: 10px 60px 0 20px;
    font-size: 16px; box-shadow: 0px 1px 5px rgb(0 0 0 / 10%); }
  .search-input input { height: 40px; width: 100%; outline: none; border: none; border-radius: 5px; padding: 0 60px 0 20px;
    font-size: 16px; box-shadow: 0px 1px 5px rgb(0 0 0 / 10%); }
  </style>
<!-- Main Container end -->
  <!-- Footer start -->
  <footer>
    <div class="top-section">
      <div class="container ">
        <div class="row match-height-container">
          <div class="col-sm-11 wow fadeInDown animated footer-left" data-wow-delay="0.2s" data-wow-offset="40">
            <div class="row">
              <div class="col-sm-16 ">
                <h2>about us</h2>
                  <p><b>Welcome to VILGST - Your Premier Destination for Indirect Taxes updates</b>
    <br><br>
    We are your trusted partner in the world of Indirect Tax Solutions. With a comprehensive suite of services, we are dedicated to providing you with the most up-to-date and accurate Tax Information and Tax Solutions. Our commitment is to empower Professionals and Businesses, enabling them to navigate the complex landscape of Indirect Taxes effortlessly. Our team is dedicated to delivering the latest Tax News and GST Updates promptly, keeping you ahead of the curve.
    <br><br>
    Stay ahead of the curve with our extensive collection of GST news and GST updates. Our team diligently tracks the latest GST Information and Updates to keep you informed and compliant. Our exclusive GST newsletter ensures you are well-informed about changes that may impact your business. Stay informed and up-to-date with the latest Indirect Taxes News at VILGST.<i>[Read More...</i><a href="<?php echo $getBaseUrl; ?>about"><span style="color: #ffa200;">about us</span></a>]<!--  We take pride in the fact that almost all leading Corporates, Tax Consulting firm and CA firms are our subscribing member. We offer bouquet of products to cater to all your needs in the area of Indirect Taxes. Our products are useful for Corporate, Tax Consultants, Law firm, Government Department, Students and the entire tax fraternity. --></p> 

                  <p style="padding-top: 30px; color: #ffa200;"><span class="copyright-info">Copyright &copy; <?php echo date("Y");?> <span>|</span> VATINFOLINE MULTIMEDIA <span>|</span> All rights reserved </span></p>               
              </div>
            </div>
          </div>
          <div class="col-sm-5 wow fadeInDown animated footer-right" data-wow-delay="0.2s" data-wow-offset="40">
            <h2>quick links</h2>
            <ul class="list-unstyled">
              <!-- <li><a class="ion-ios-arrow-right" href="<?php echo $getBaseUrl; ?>showMoreData?data=articles">articles</a></li>
              <li><a class="ion-ios-arrow-right" href="<?php echo $getBaseUrl; ?>showMoreData?data= features">Features</a></li> -->
              <!-- <li><a class="ion-ios-arrow-right" href="<?php echo $getBaseUrl; ?>about">about us</a></li>
              <li><a class="ion-ios-arrow-right" href="<?php echo $getBaseUrl; ?>clients">clients</a></li> -->              
              <li><a class="ion-ios-arrow-right" href="<?php echo $getBaseUrl; ?>contacts">contact us</a></li>
              <li><a class="ion-ios-arrow-right" href="<?php echo $getBaseUrl; ?>disclaimer">disclaimer</a></li>
              <li><a class="ion-ios-arrow-right" href="<?php echo $getBaseUrl; ?>sitemap">sitemap </a></li>
              <li><a class="ion-ios-arrow-right" href="<?php echo $getBaseUrl; ?>terms">Terms of Use </a></li>
              <li><a class="ion-ios-arrow-right" href="<?php echo $getBaseUrl; ?>privacy_policy">Privacy Policy </a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <!-- <div class="bottom-section">
      <div class="container">
        <div class="row">
          <div class="col-sm-16">
            <div class="row">
              <div class="col-sm-10 col-xs-16 f-nav wow fadeInDown animated" data-wow-delay="0.05s" data-wow-offset="10">
                <span class="copyright-info">Copyright &copy; <?php echo date("Y");?> <span>|</span> VATINFOLINE MULTIMEDIA <span>|</span> All rights reserved </span>
              </div>
              <div class="col-sm-6 col-xs-16 text-right wow fadeInDown animated powered-by" data-wow-delay="0.05s" data-wow-offset="10">
                <span>Designed &amp; developed by <a href="https://webrhythms.com/" target="_blank">WebRythmStudio</a></span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div> -->
  </footer>
  <!-- Footer end -->
<?php 
  if(!isLogeedIn()) { 
?>
  <!-- Login Popup  -->
  <div id="create-account" class="white-popup mfp-with-anim mfp-hide">
    <form role="form" name="registerForm" id="registerForm" method="post" action="./"  autocomplete="off">
      <h3>Create Account</h3>
      <hr class="tb-margin-10">
      <div class="alert b-margin-10"></div>
      <div class="row">
        <div class="col-sm-8">
          <div class="form-group">
            <input type="text" name="txtFName" id="txtFName" class="form-control" placeholder="First Name" tabindex="1">
          </div>
        </div>
        <div class="col-sm-8">
          <div class="form-group">
            <input type="text" name="txtLName" id="txtLName" class="form-control" placeholder="Last Name" tabindex="2">
          </div>
        </div>
      </div>
      <div class="form-group">
        <input type="email" name="txtEmail" id="txtEmail" class="form-control " placeholder="Email Address" tabindex="3">
      </div>
      <div class="form-group">
        <label class="checkbox-inline"><input type="radio" name="txtGender" id="txtGenderMale" value="M" tabindex="4">Male</label>
        <label class="checkbox-inline"><input type="radio" name="txtGender" id="txtGenderFemale" value="F" tabindex="4">Female</label> 
      </div>
      <div class="form-group">
        <input type="text" name="txtComapny" id="txtComapny" class="form-control" placeholder="Company Name" tabindex="5">          
      </div>
      <div class="row">
        <div class="col-sm-8">
          <div class="form-group">
            <input type="text" name="txtOcc" id="txtOcc" class="form-control" placeholder="Occupation" tabindex="6">
          </div>
        </div>
        <div class="col-sm-8">
          <div class="form-group">
            <input type="text" name="txtDesignation" id="txtDesignation" class="form-control" placeholder="Designation" tabindex="7">
          </div>
        </div>
      </div>
      <div class="form-group">
        <textarea class="form-control" rows="2" name="txtAdd" id="txtAdd" placeholder="Address"  tabindex="8"></textarea>
      </div>
      <div class="row">
        <div class="col-sm-8">
          <div class="form-group">
            <input type="text" name="txtLandline" id="txtLandline" class="form-control" placeholder="Landline No." tabindex="9">
          </div>
        </div>
        <div class="col-sm-8">
          <div class="form-group">
            <input type="text" name="txtDirect" id="txtDirect" class="form-control" placeholder="Direct No." tabindex="10">
          </div>
        </div>
      </div>
      <div class="form-group">
        <input type="text" name="txtMobile" id="txtMobile" class="form-control" placeholder="Mobile No." tabindex="11">
      </div>
      <div class="row">
        <div class="col-sm-8">
          <div class="form-group">
            <img src="captcha/captcha.php" alt="Security-Code" title="michatronic-sicherheitscode" id="captcha" /><br />
            <a href="javascript:void(0);" onclick="javascript:document.getElementById('captcha').src='captcha/captcha.php?'+Math.random();"><span class="neuercode">New Code?</span></a>
          </div>
        </div>
        <div class="col-sm-8">
          <div class="form-group">
            <?php if ($fehler["captcha"] != "") { echo $fehler["captcha"]; } ?><input type="text" name="securitycode" id="securitycode" maxlength="150" tabindex="12" class="form-control" placeholder="Security Code" />
          </div>
        </div>
      </div>
      <hr class="tb-margin-10">
      <div class="row">
        <div class="col-sm-16">
          <input type="submit" value="Register" name="btnSubmitRegistration" id="btnSubmitRegistration" class="btn btn-block btn-lg" tabindex="13">
        </div>
      </div>
    </form>
  </div>
  <!-- Login Popup  -->
  <div id="log-in" class="white-popup mfp-with-anim mfp-hide">
    <form role="form" name="loginform" id="loginform" method="post" action=""  autocomplete="off">
      <h3>Log In</h3>
      <hr>
      <div class="alert" id="errorDiv"></div>
      <div class="form-group">
        <input type="text" name="txtuser" id ="txtuser" class="form-control" placeholder="User Name" tabindex="3">
      </div>
      <div class="form-group">
        <input type="password" name ="txtpass" id="txtpass" class="form-control " placeholder="Password" tabindex="4">
      </div>
      <hr>
      <div class="row">
        <div class="col-sm-16">
          <input type="submit" id="btnSubmitLogin" name="btnSubmitLogin" class="btn btn-block btn-lg" value="Log In" tabindex="7" />
          <hr>
        </div>

        <div class="col-sm-16">
          <a class="open-popup-link pull-left" href="#create-account" data-effect="mfp-zoom-in"  >New User ?</a>
          <a class="open-popup-link pull-right" href="#forgot-password" data-effect="mfp-zoom-in" >Forgot Password ?</a>  
        </div>
      </div>
    </form>     
  </div>
  <!-- Forgot Password Popup  -->
  <div id="forgot-password" class="white-popup mfp-with-anim mfp-hide">
    <form role="form" name="forgotPasswordForm" id="forgotPasswordForm" method="post" action="./"  autocomplete="off">
      <h3>Forgot Password</h3>
      <hr>
      <div class="alert" id="errorDiv"></div>
      <div class="form-group">
        <input type="text" name="userName" id="userName" class="form-control" placeholder="Enter your Registered Email ID" tabindex="3">
      </div>
      <div class="row">
        <div class="col-sm-8">
          <div class="form-group">
            <img src="/captcha/captcha.php" alt="Security-Code" title="michatronic-sicherheitscode" id="captcha" /><br />
            <a href="javascript:void(0);" onclick="javascript:document.getElementById('captcha').src='/captcha/captcha.php?'+Math.random();"><span class="neuercode">New Code?</span></a>
          </div>
        </div>
        <div class="col-sm-8">
          <div class="form-group">
            <?php if ($fehler["captcha"] != "") { echo $fehler["captcha"]; } ?><input type="text" name="securitycodeForgot" id="securitycodeForgot" maxlength="150" class="form-control" placeholder="Security Code" />
          </div>
        </div>
      </div>       
      <em>Please Note: This facility is only for Subscribing Members.</em>
      <hr>
      <div class="row">
        <div class="col-sm-16">
          <input type="submit" id="btnForgotPassword" name="btnForgotPassword" class="btn btn-block btn-lg" value="Submit" tabindex="7" />
          <hr>
        </div> 
      </div>
    </form>     
  </div>
  <?php 
  }

?>
<?php 
  if(isLogeedIn()){ 
?>
  <!-- Change Password Popup  -->
  <div id="change-password" class="white-popup mfp-with-anim mfp-hide">
    <form role="form" name="resetPassForm" id="resetPassForm" method="post" action="./"  autocomplete="off">
      <h3>Change Password</h3>
      <hr>
      <div class="alert" id="errorDiv"></div>
      <div class="form-group">
        <input type="password" id="txtCurrPass" name="txtCurrPass" class="form-control" placeholder="Current Password" tabindex="1" />

      </div>
      <div class="form-group">
        <input type="password" id="txtNewPass" name="txtNewPass" class="form-control" placeholder="New Password" tabindex="2" />
      </div>
      <div class="form-group">
        <input type="password" id="txtConfNewPass" name="txtConfNewPass" class="form-control" placeholder="Confirm New Password" tabindex="3" />
      </div>
      <hr>
      <div class="row">
        <div class="col-sm-16">
          <input type="submit" id="btnSubmitResetPass" name="btnSubmitResetPass" class="btn btn-block btn-lg" value="Update" tabindex="4" />
        </div>
      </div>
    </form>     
  </div>
  

<?php } ?>

<?php if($page = 'showIframe') { ?>
<!-- Email this page Popup  -->
<div id="email-this-page" class="white-popup mfp-with-anim mfp-hide">
  <form role="form" name="emailThisPageForm" id="emailThisPageForm" method="post" action="./"  autocomplete="off">
    <h3>Email this page</h3>
    <hr>
    <div class="alert" id="errorDiv"></div>
    <div class="form-group">
      <input type="email" id="emailPageYourName" name="emailPageYourName" class="form-control" placeholder="Your name" tabindex="1" />

    </div>
    <div class="form-group">
      <input type="email" id="emailPageCompName" name="emailPageCompName" class="form-control" placeholder="Company name" tabindex="2" />

    </div>
    <div class="form-group">
      <input type="email" id="emailPageRecEmailID" name="emailPageRecEmailID" class="form-control" placeholder="Recipient Email-id " tabindex="3" />

    </div>
     
    <hr>
    <div class="row">
      <div class="col-sm-16">
        <input type="submit" id="emailThisPageFormSubmit" name="emailThisPageFormSubmit" class="btn btn-block btn-lg" value="Send" tabindex="4" />
      </div>
    </div>
  </form>     
</div>

<div id="add-notes" class="white-popup mfp-with-anim mfp-hide">
  <form role="form" name="addNotes" id="addNotes" method="post" action="./" autocomplete="off">
    <h3>Add Notes</h3>
    <hr>
    <div id="editor">
    </div>
    <hr>
    <div class="row">
      <div class="col-sm-16">
        <button type="button" id="saveButton" class="btn btn-block btn-lg">Save notes</button>
        <button type="button" id="updateButton" class="btn btn-block btn-lg" style="display:none;">Update notes</button>
      </div>
    </div>
  </form>  
</div>

</script>
</div>
    
</div>

<div id="taxvistafeedback" class="white-popup mfp-with-anim mfp-hide">
        <form role="form" name="taxvistafeedbackForm" id="taxvistafeedbackForm" method="post" action="./"  autocomplete="off">
            <h3>Feedback this page</h3>
            <hr>
            <div class="alert" id="errorDiv"></div>
            <div class="form-group">
                <input type="text" id="taxvistafeedbackName" name="taxvistafeedbackName" class="form-control" placeholder="Your name" tabindex="1" />
            </div>
            <div class="form-group">
                <input type="text" id="taxvistafeedbackCompanyName" name="taxvistafeedbackCompanyName" class="form-control" placeholder="Company name" tabindex="2" />
            </div>
            <div class="form-group">
                <input type="text" id="taxvistafeedbackContactNo" name="taxvistafeedbackContactNo" class="form-control" placeholder="Your mobile number" tabindex="3" />
            </div>
            <div class="form-group">
                <input type="email" id="taxvistafeedbackEmailId" name="taxvistafeedbackEmailId" class="form-control" placeholder="Your email id" tabindex="4" />
            </div>
            <div class="form-group">
                <textarea id="taxvistafeedbackArea" name="taxvistafeedbackArea" class="form-control" cols="10" rows="4" placeholder="Your feedback please" tabindex="5"></textarea>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-16">
                    <input type="submit" id="taxVistaFeedbackFormSubmit" name="taxVistaFeedbackFormSubmit" class="btn btn-block btn-lg" value="Submit" tabindex="6" />
                </div>
            </div>
        </form>     
</div>

 <?php } ?>

<div class="modal fade" id="loginInError" role="dialog" style="margin-top: 100px;">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Error !</h4>
      </div>
      <div class="modal-body text-center">
        <p><?php echo $loginInErrorMsg; ?></p>
      </div>
    </div>
  </div>
</div>


<div id="scheduleADemo" class="white-popup mfp-with-anim mfp-hide" style='max-width: 600px;width:600px;'>
    <div class="modal-header">
        <h4 class="modal-title">Schedule a Demo</h4>
    </div>
    <div class="modal-body text-left">
        <!--<p>Schedule a demo with our expert. Explore beautiful gems of vilgst.com. <br> Get Tips, tricks from our expert to find out expected results in faster way. </p>-->
        <p>Schedule a demo to know the features and advantages of VILGST portal. Get to know the tips to find the desired results in faster way.</p>
        <form role="form" name="frmscheduledemo" id="frmscheduledemo" method="post" action="./"  autocomplete="off">
            <div class="alert" id="errorDiv"></div>
            <div class="form-group">
                <input type="text" id="scheduledemoName" name="scheduledemoName" class="form-control" placeholder="*Please enter Your name" tabindex="1" />
            </div>
            <div class="form-group">
                <input type="text" id="scheduledemoCompanyName" name="scheduledemoCompanyName" class="form-control" placeholder="*Organisation name" tabindex="2" />
            </div>
            <div class="form-group">
                <input type="text" id="scheduledemoContactNo" name="scheduledemoContactNo" class="form-control" placeholder="*Your mobile number" tabindex="3" />
            </div>
            <div class="form-group">
                <input type="email" id="scheduledemoEmailId" name="scheduledemoEmailId" class="form-control" placeholder="*Your email id" tabindex="4" />
            </div>
            <div class="form-group">
                <textarea id="scheduledemoFeedbackArea" name="scheduledemoFeedbackArea" class="form-control" cols="10" rows="4" placeholder="You can add your comments here (If any)" tabindex="5"></textarea>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-16">
                    <input type="submit" id="frmscheduledemoSubmit" name="frmscheduledemoSubmit" class="btn btn-block btn-lg" value="Submit" tabindex="6" />
                </div>
            </div>
        </form> 
    </div>
</div>

<!-- Caselaw Email Section By Aryan -->
<div id="caselawForm" class="white-popup mfp-with-anim mfp-hide" style='max-width: 800px;width:800px;'>
  <div class="modal-header">
      <h4 class="modal-title" style="text-align: center; text-transform: uppercase;">Caselaw Request Form (CRF)</h4>
  </div>
  <div class="modal-body text-left">
      <p>Didn’t find what you are searching for? No worries, please give us the following details and VIL will email you the desired Caselaws at the earliest:</p>
      <form role="form" name="frmCaselaw" id="frmCaselaw" method="post" action="./"  autocomplete="off">
          <div class="alert" id="errorDiv"></div>
          <div class="wrapper" style="margin-bottom: 10px;">
              <div class="search-input">
                  <input type="text" id="caselawKeyword" tabindex="1" name="caselawKeyword" placeholder="Keyword/Party Name">
              </div>
          </div>
          <div class="wrapper" style="margin-bottom: 10px;">
              <div class="search-input">
                  <input type="text" id="caselawCitation" tabindex="2" name="caselawCitation" placeholder="Citation/Case No.:">
              </div>
          </div>
          <div class="wrapper" style="margin-bottom: 10px;">
              <div class="search-input">
                  <input type="text" id="caselawName" tabindex="3" name="caselawName" placeholder="* Your Name">
              </div>
          </div>
          <div class="wrapper" style="margin-bottom: 10px;">
              <div class="search-input">
                  <input type="text" id="caselawCompanyName" tabindex="4" name="caselawCompanyName" placeholder="* Company Name">
              </div>
          </div>
          <div class="wrapper" style="margin-bottom: 10px;">
              <div class="search-input">
                  <input type="number" id="caselawContactNo" tabindex="5" name="caselawContactNo" placeholder="* Mobile Number">
              </div>
          </div>
          <div class="wrapper" style="margin-bottom: 10px;">
              <div class="search-input">
                  <input type="text" id="caselawEmailId" tabindex="6" name="caselawEmailId" placeholder="* Email-id">
              </div>
          </div>
          <div class="wrapper" style="margin-bottom: 10px;">
              <div class="search-input">
                  <textarea id="caselawFeedbackArea" name="caselawFeedbackArea" cols="10" rows="4" placeholder="Remarks" tabindex="7"></textarea>
              </div>
          </div>
          <div class="wrapper" style="margin-bottom: 10px;">
            <img src="captcha/captcha.php" alt="Security-Code" title="michatronic-sicherheitscode" id="captcha">
            <br>
            <a href="javascript:void(0);" onclick="javascript:document.getElementById('captcha').src='captcha/captcha.php?'+Math.random();">
            <span class="neuercode">New Code?</span></a>
          </div>
          <div class="wrapper">
            <div class="search-input"><?php if ($fehler["captcha"] != "") { echo $fehler["captcha"]; } ?>
              <input type="text" name="caselawSecurityCode" id="caselawSecurityCode" placeholder="*Enter Code" tabindex="8" maxlength="150">
            </div>
          </div>
          <hr>
          <div class="row">
              <div class="col-sm-16">
                  <input type="submit" id="frmCaselawSubmit" name="frmCaselawSubmit" class="btn btn-block btn-lg" value="Submit" tabindex="9" />
              </div>
          </div>
      </form> 
  </div>
</div>

</div>
<!-- wrapper end --> 
<script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script>

<!-- jQuery --> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script> 
<!-- <script src="<?php echo $getBaseUrl; ?>js/jquery.min.js"></script>  -->
<!--jQuery easing--> 
<script src="<?php echo $getBaseUrl; ?>js/jquery.easing.1.3.js"></script> 
<!-- bootstrap js --> 
<script src="<?php echo $getBaseUrl; ?>js/bootstrap.js"></script> 
<!-- Wow js --> 
<script src="<?php echo $getBaseUrl; ?>js/wow.min.js"></script> 
<!-- time and date --> 
<script src="<?php echo $getBaseUrl; ?>js/moment.min.js"></script> 
<!--news ticker--> 
<script src="<?php echo $getBaseUrl; ?>js/jquery.ticker.js?ver=100620170101"></script>  
<!-- magnific popup --> 
<script src="<?php echo $getBaseUrl; ?>js/jquery.magnific-popup.js"></script> 
<!-- go to top --> 
<script src="<?php echo $getBaseUrl; ?>js/jquery.scrollUp.js"></script>  
<!--media queries to js--> 
<script src="<?php echo $getBaseUrl; ?>js/enquire.js"></script> 
<!--custom functions--> 
<script src="<?php echo $getBaseUrl; ?>js/ajax.custom.js?ver=151220202006"></script>

<script src="<?php echo $getBaseUrl; ?>js/jquery.ui.widget.min.js"></script>

<script src="<?php echo $getBaseUrl; ?>js/jquery.simplyscroll.min.js"></script>

<script src="<?php echo $getBaseUrl; ?>js/custom.js?ver=160720200100"></script>
<script src="<?php echo $getBaseUrl; ?>js/vilgst.explorer.js?ver=08092020_01"></script>

<script>
    let editorInstance; 
    let loader = false; 
    const prodId = "<?php echo $prod_id; ?>";
    const subProdId = "<?php echo $sub_prod_id; ?>";
    const notesId = "<?php echo $notes_id; ?>";
    let data = ''
    let setData = ''
     // Asynchronous function to save content
    async function deleteContentById(id) {
        try {
          const body= 'notes_id=' + encodeURIComponent(id) + '&delete=true' 
          const response = await fetch('fetchUserNotes.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded',
            },
            body
          });
          const responseData = await response.json();
          console.log('responseData:::',responseData)
          return responseData
        } catch (error) {
          console.error('Error:', error);
        }
    }

    async function fetchContentAsync(content) {
        try {
          const body= 'prod_id=' + encodeURIComponent(prodId) + '&sub_prod_id=' + encodeURIComponent(subProdId) + '&get_notes=true'
          const response = await fetch('fetchUserNotes.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded',
            },
            body
          });
          const responseData = await response.json();
          return responseData
        } catch (error) {
          console.error('Error:', error);
        }
    }

    async function updateContentAsync(content,notes_id) {
        try {
        const body ='prod_id=' + encodeURIComponent(prodId) + '&notes_id=' + encodeURIComponent(notes_id) + '&sub_prod_id=' + encodeURIComponent(subProdId) + '&data=' + encodeURIComponent(content)
        
        const response = await fetch('fetchUserNotes.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded',
            },
            body,
          });
         
          return await response.json();
        } catch (error) {
          console.error('Error:', error);
        }
    }

    async function addNotes(content) {
        try {
        const body ='prod_id=' + encodeURIComponent(prodId) + '&sub_prod_id=' + encodeURIComponent(subProdId) + '&data=' + encodeURIComponent(content)
        const response = await fetch('fetchUserNotes.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded',
            },
            body,
          });         
          return await response.json();
        } catch (error) {
          console.error('Error:', error);
        }
    }
    const saveButton = document.getElementById('saveButton');
    function updateButtonState() {
        if (loader) {
            saveButton.disabled = true; // Disable the button
        } else {
            saveButton.disabled = false; // Enable the button
        }
    }

    ClassicEditor
        .create(document.querySelector('#editor'))
        .then(editor => {
            editorInstance = editor;
            editor.model.document.on('change:data', () => {
                if(editor.getData()){
                  data = editor.getData()
                }
              });

            document.getElementById('saveButton').onclick = function() {
              loader =true;
              updateButtonState();
              
              if(data){
                addNotes(data).then(res=>{
                  loader =false;
                  editor.setData('')
                  updateButtonState();

                  console.log(res)
                 
                }).catch(()=>{
                  loader = false;
                  updateButtonState();
                })   

              }
            };
        }).catch(error => {
            console.error(error)
        });

          
        document.getElementById('updateButton').onclick = function() {
           if(data&&notesId){
            updateContentAsync(data,notesId).then(res=>{
                loader =false;
                updateButtonState();
                console.log(res)
              }) .catch(()=>{
                loader = false;
                updateButtonState();

            })           
            }
        };     
</script>

</body>
</html>
<script type="text/javascript">
/* Remove this once in production */ 
/* 
if (window.location.protocol != 'https:') {
      location.href = location.href.replace("http://", "https://");

}*/ 
</script> 
