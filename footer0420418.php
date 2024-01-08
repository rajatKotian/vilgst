<?php 
    if($page != 'showIframe' && $page != 'paidService') {
      include('sidebar.php');  
    }
    

     ?> 

  </div>
</div>
<!-- Main Container end -->
  <!-- Footer start -->
  <footer>
    <div class="top-section">
      <div class="container ">
        <div class="row match-height-container">
          <div class="col-sm-11 wow fadeInDown animated footer-left" data-wow-delay="0.2s" data-wow-offset="40">
            <div class="row">
              <div class="col-sm-16">
                <h2>vatinfoline library</h2>
                  <ul class="list-unstyled">
                    <li><a class="ion-ios-arrow-right" href="<?php echo $getBaseUrl; ?>unionBudgets">Union Budget </a> </li>
                   <!--  <li><a href="< ?php echo $getBaseUrl; ?>library?page=Foreign Trade Policies">Foreign Trade Policies</a> </li>
                    <li><a href="< ?php echo $getBaseUrl; ?>library?page=Manuals">Manuals</a> </li>
                    <li><a href="< ?php echo $getBaseUrl; ?>library?page=Links">Links</a> </li> -->
                    <li><a href="<?php echo $getBaseUrl; ?>stateBudgets">State Budget </a> </li>
                    <!-- <li><a href="< ?php echo $getBaseUrl; ?>library?page=State Policies">State Policies</a> </li>
                    <li><a href="< ?php echo $getBaseUrl; ?>library?page=Rules">Rules</a> </li>
                    <li><a href="< ?php echo $getBaseUrl; ?>library?page=Acts">Acts</a> </li> -->
                  </ul>
              </div>
              <hr />
              <div class="col-sm-16 ">
                <h2>about us</h2>
                  <p>VATINFOLINE was launched in the year 2005 by a group of young professionals. In short span of time it has become a leading information service provider to Corporates, CA firms and Tax Consultants. Our commitment to quality and celerity has been the cornerstone our subsistence and the same is symbolises by our client list. We take pride in the fact that almost all leading Corporates, Tax Consulting firm and CA firms are our subscribing member. We offer bouquet of products to cater to all your needs in the area of Indirect Taxes. Our products are useful for Corporate, Tax Consultants, Law firm, Government Department, Students and the entire tax fraternity.</p>                
              </div>
            </div>
          </div>
          <div class="col-sm-5 wow fadeInDown animated footer-right" data-wow-delay="0.2s" data-wow-offset="40">
            <h2>quick links</h2>
            <ul class="list-unstyled">

              <li><a class="ion-ios-arrow-right" href="<?php echo $getBaseUrl; ?>showMoreData?data=articles">articles</a></li>
              <li><a class="ion-ios-arrow-right" href="<?php echo $getBaseUrl; ?>showMoreData?data=features">Features</a></li>
              <li><a class="ion-ios-arrow-right" href="<?php echo $getBaseUrl; ?>about">about us</a></li>
              <li><a class="ion-ios-arrow-right" href="<?php echo $getBaseUrl; ?>clients">clients</a></li>              
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
    <div class="bottom-section">
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
    </div>
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
            <img src="/captcha/captcha.php" alt="Security-Code" title="michatronic-sicherheitscode" id="captcha" /><br />
            <a href="javascript:void(0);" onclick="javascript:document.getElementById('captcha').src='/captcha/captcha.php?'+Math.random();"><span class="neuercode">New Code?</span></a>
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
    <form role="form" name="loginform" id="loginform" method="post" action="./"  autocomplete="off">
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

</div>
<!-- wrapper end --> 

<!-- jQuery --> 
<script src="<?php echo $getBaseUrl; ?>js/jquery.min.js"></script> 
<!--jQuery easing--> 
<script src="<?php echo $getBaseUrl; ?>js/jquery.easing.1.3.js"></script> 
<!-- bootstrab js --> 
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
<script src="<?php echo $getBaseUrl; ?>js/ajax.custom.js?ver=100620170101"></script>

<script src="<?php echo $getBaseUrl; ?>js/jquery.ui.widget.min.js"></script>

<script src="<?php echo $getBaseUrl; ?>js/jquery.simplyscroll.min.js"></script>

<script src="<?php echo $getBaseUrl; ?>js/custom.js?ver=250520170101"></script>

</body>
</html>
