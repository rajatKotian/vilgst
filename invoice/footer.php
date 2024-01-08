</div>
</div>
<!-- Main Container end -->
  <!-- Footer start -->
  <footer>
    <div class="bottom-section">
      <div class="container">
        <div class="row">
          <div class="col-sm-16">
            <div class="row">
              <div class="col-sm-10 col-xs-16 f-nav wow fadeInDown animated" data-wow-delay="0.05s" data-wow-offset="10">
                <span class="copyright-info">Copyright &copy; <?php echo date("Y");?> <span>|</span> VATINFOLINE MULTIMEDIA <span>|</span> All rights reserved </span>
              </div>
              <div class="col-sm-6 col-xs-16 text-right wow fadeInDown animated powered-by" data-wow-delay="0.05s" data-wow-offset="10">
                <span>Designed &amp; developed by <a href="http://webrhythms.com/" target="_blank">WebRythmStudio</a></span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </footer>
  <!-- Footer end -->
 
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
