<?php 
  $pageType = 'login';
  include('header.php'); 
?>
<style>
  


.login-page {
  /* Permalink - use to edit and share this gradient: https://colorzilla.com/gradient-editor/#ffffff+20,e5e5e5+100 */
  background: #ffffff; /* Old browsers */
  background: -moz-linear-gradient(top, #ffffff 20%, #e5e5e5 100%); /* FF3.6-15 */
  background: -webkit-linear-gradient(top, #ffffff 20%,#e5e5e5 100%); /* Chrome10-25,Safari5.1-6 */
  background: linear-gradient(to bottom, #ffffff 20%,#e5e5e5 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
  filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#e5e5e5',GradientType=0 ); /* IE6-9 */
}

.login-box-wrapper {
  box-shadow: 0 0 20px rgba(0,0,0,0.3), inset 0 0 30px rgba(0,0,0,0.1);
  border-radius: 10px;
  padding: 20px;
  padding-top: 10px;
  border-bottom: #3C8DBA 3px solid;
}
.login-box-wrapper .box-header{
  margin-bottom: 30px;
  padding: 0 20px 10px;
  font-size: 25px;
  text-align: center; 
  font-weight: bold;
  color: #3C8DBA;
}

.login-logo { margin-bottom: 80px; }

.login-box .box-header .box-title {
  margin: 15px 0;
}

.login-box.error .alert { 
  display: block;
  margin-bottom: 10px; 
}

.login-box.error .login-box-wrapper .box-header {  margin-bottom: 10px;  }

.login-box .form-control {
  box-shadow: 0 0 6px rgba(0,0,0,0.15), inset 2px 2px 2px rgba(0,0,0,0.1);
  border-radius: 3px;
  border: 1px solid #ccc;
    /* Permalink - use to edit and share this gradient: https://colorzilla.com/gradient-editor/#fffcfc+0,f5f9f0+100 */
  background: #fffcfc; /* Old browsers */
  background: -moz-linear-gradient(top, #fffcfc 0%, #f5f9f0 100%); /* FF3.6-15 */
  background: -webkit-linear-gradient(top, #fffcfc 0%,#f5f9f0 100%); /* Chrome10-25,Safari5.1-6 */
  background: linear-gradient(to bottom, #fffcfc 0%,#f5f9f0 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
  filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#fffcfc', endColorstr='#f5f9f0',GradientType=0 ); /* IE6-9 */

}
</style>
<?php 

if(isset($_POST['loginsubmit'])) { 
 
  $myusername=$_POST['login-username']; 
  $mypassword=$_POST['login-password']; 

  $myusername = stripslashes($myusername);
  $mypassword = stripslashes($mypassword);
  $myusername = mysqli_real_escape_string($con,$myusername);
  $mypassword = mysqli_real_escape_string($con,$mypassword);
   
  $sql="SELECT user_id,user_type FROM userlogins WHERE username='$myusername' and pwd='$mypassword' and user_type = 'A' and active_flag= 'Y'";

  $result=mysqli_query($GLOBALS['con'],$sql);
  $count=mysqli_num_rows($result);
  $row=mysqli_fetch_assoc($result);
   
  if($count==1) {
    $_SESSION["user"] = $myusername;
    $_SESSION["login"] = 'qwert';
    $_SESSION['logged_in'] = true; 
    $_SESSION['last_activity'] = time(); //your last activity was now, having logged in.
    if($row['user_type'] == 'A') {
        $_SESSION['expire_time'] = 40 * 60; 
    //   $_SESSION['expire_time'] = 9999 * 24 * 60 * 60; 
    } else {
        $_SESSION['expire_time'] =  40 * 60;
    //   $_SESSION['expire_time'] = 2 * 30 * 60; 
    }

    $_SESSION["id"] = $row['user_id'];
    $_SESSION["type"] = $row['user_type']; 
    $_SESSION["vatAccess"] = 'Y'; 
    $_SESSION["STAccess"] = 'Y';  
    $_SESSION["CEAccess"] =  'Y';  
    $_SESSION["customsAccess"] = 'Y'; 
    $_SESSION["gstAccess"] = 'Y'; 
    $_SESSION["userStatus"]= 'active';

    $resultSettings = mysqli_query($GLOBALS['con'],"SELECT value FROM settings where keyname = 'securitycode'");  
    $rowSettings = mysqli_fetch_array($resultSettings);    
    $_SESSION["securitycode"] = $rowSettings['value']; 

    header("location:index.php");
  } else  {
    header("location:login.php?error=y");
  }
}
?>
    <div class="login-box <?php if(isset($_GET['error']) && $_GET['error'] == 'y') { echo 'error'; } ?>">
      <div class="login-logo" >
        <a href="index.php"><img src="dist/img/vatinfoline-logo.png" /></a>
      </div><!-- /.login-logo -->
      <div class="login-box-wrapper box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Welcome to Admin Panel</h3>
        </div>
        <div class="alert alert-danger alert-dismissable">
          Wrong Username or Password. 
        </div>

        <form action="" name="loginform" method="post">
          <div class="form-group has-feedback">
            <input type="name" name="login-username" class="form-control" placeholder="Username">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password"  name="login-password" class="form-control" placeholder="Password">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-8">
              <div class="checkbox icheck" style="display: none;">
                <label>
                  <input type="checkbox"> Remember Me
                </label>
              </div>
            </div><!-- /.col -->
            <div class="col-xs-4">
              <button type="submit" id="loginsubmit" name="loginsubmit" class="btn btn-primary btn-lg">Sign In</button>
            </div><!-- /.col -->
          </div>
        </form>
      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->
    

<?php include('footer.php'); ?>