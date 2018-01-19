<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$sess=$this->session->userdata('user_session');
if (empty($sess)) {
  print_r("<script>window.location.href='".base_url()."index.php/home'</script>");
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>GVS | Change Password Page</title>
  <?php $this->view('layout/meta_header'); ?>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">

  <?php $this->view('layout/header'); ?>
  <!-- =============================================== -->

  <!-- Left side column. contains the sidebar -->
  <?php $this->view('layout/menu'); ?>
  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Change Password page
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>index.php/home"><i class="fa fa-home"></i> Home</a></li>
        <li><a href="#"><i class="fa fa-user"></i> Change Password</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h1 class="box-title">Change Password</h1>
          <div class="box-tools pull-right">
          </div>
        </div>
        <div class="box-body">
        <?php echo empty($result)?"":$result; ?>
          <form role="form" method="post" action="<?php print_r(base_url().'index.php/home/saveChange/'.$sess->id); ?>">
            <div class="form-group">
              <label>Old Passowrd <span class="error-label"><?php print_r(form_error('old_password')); ?></span></label>
              <input name="old_password" class="form-control" placeholder="Input Old Passowrd" type="password">
            </div>
            <div class="form-group">
              <label>Password <span class="error-label"><?php print_r(form_error('password')); ?></span></label>
              <input name="password" class="form-control" placeholder="Input Passowrd" type="password">
            </div>
            <div class="form-group">
              <label>Confirm Passowrd <span class="error-label"><?php print_r(form_error('confirm_password')); ?></span></label>
              <input name="confirm_password" class="form-control" placeholder="Input Passowrd Again" type="password">
            </div>
            <div class="box-footer">
              <button type="button" id="cancel" class="btn btn-default">Cancel</button>
              <button type="submit" class="btn btn-info pull-right">Save</button>
            </div>
          </form>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php $this->view('layout/footer'); ?>
</div>
<?php $this->view('layout/meta_js'); ?>
<script type="text/javascript">
  $(function () {
    $("#cancel").click(function() {
      window.location.href='<?php echo base_url(); ?>index.php/home'
    });

    $("#alert").fadeTo(2000, 500).slideUp(500, function(){
      $("#alert").slideUp(500);
    });
  })
</script>
</body>
</html>