<header class="main-header">
        <!-- Logo -->
        <a href="index.php" class="logo">
          <span class="logo-lg"><img src="dist/img/vatinfoline-logo.png" /></span>
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><img src="dist/img/vatinfoline-logo-mini.png" /></span>
          <!-- logo for regular state and mobile devices -->
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- Notifications: style can be found in dropdown.less -->
               
              <?php 
                  $result = mysqli_query($GLOBALS['con'],"SELECT firstname,lastname,email_id FROM userlogins where user_id = '".$_SESSION['id']."'");  
                  $row = mysqli_fetch_array($result);    
                  $username = ($row['firstname'] == null) ? $_SESSION['user'] : $row['firstname'].' '.$row['lastname']; 
              ?>  
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="dist/img/avatar5.png" class="user-image" alt="User Image">
                  <span class="hidden-xs">
                      <?php echo $username; ?>
                  </span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <img src="dist/img/avatar5.png" class="img-circle" alt="User Image">
                    <p>
                      <?php echo $username; ?>
                      <small style="text-transform: lowercase; font-style: italic;"><?php echo $row['email_id']; ?></small>
                    </p>
                  </li>
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="profile.php" class="btn btn-default btn-flat">Profile</a>
                    </div>
                    <div class="pull-right">
                      <a href="logout.php" class="btn btn-default btn-flat">Sign out</a>
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
      </header>