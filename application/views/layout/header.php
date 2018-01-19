<?php $sess=$this->session->userdata('user_session'); ?>
<header class="main-header">
  <!-- Logo -->
  <a href="#" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"><b>A</b>LT</span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><b>GVS</b></span>
  </a>
  <!-- Header Navbar: style can be found in header.less -->
  <nav class="navbar navbar-static-top">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </a>

    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        <!-- User Account: style can be found in dropdown.less -->
        <li class="dropdown user user-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <img src="<?php echo base_url(); ?>public/dist/img/<?php print_r($sess->icon_file); ?>" class="user-image" alt="User Image">
            <span class="hidden-xs"><?php print_r($sess->user_name); ?></span>
          </a>
          <ul class="dropdown-menu">
            <!-- User image -->
            <li class="user-header">
              <img src="<?php echo base_url(); ?>public/dist/img/<?php print_r($sess->icon_file); ?>" class="img-circle" alt="User Image">
              <p>
                <?php print_r($sess->user_name); ?>
                <small>Last login <?php print_r(date_format(date_create($sess->last_user_login),"d-M-Y H:i:s")); ?></small>
              </p>
            </li>
            <!-- Menu Body -->
            <li class="user-body">
            </li>
            <!-- Menu Footer-->
            <li class="user-footer">
              <div class="pull-left">
                <a href="<?php echo base_url(); ?>index.php/home/change" class="btn btn-default btn-flat">Change Password</a>
              </div>
              <div class="pull-right">
                <a href="<?php echo base_url(); ?>index.php/home/logout" class="btn btn-default btn-flat">Sign out</a>
              </div>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </nav>
</header>