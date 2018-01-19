<?php
defined('BASEPATH') OR exit('No direct script access allowed');
echo md5('ad1234');
?><!DOCTYPE html>
<html>
<head>
  <?php $this->view('layout/meta_header'); ?>
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo"><b>GVS</b>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg"><?php echo validation_errors(); ?><span class="error-label"><?php print_r($session_desc); ?></span></p>
    <form action="<?php echo base_url(); ?>index.php/home/login" method="post">
      <div class="form-group has-feedback">
        <input type="text" name="user_id" class="form-control" placeholder="User Name" value="<?php echo set_value('user_id'); ?>">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="password" class="form-control" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
  </div>
  <!-- /.login-box-body -->
</div>
<?php $this->view('layout/meta_js'); ?>
</body>
</html>
