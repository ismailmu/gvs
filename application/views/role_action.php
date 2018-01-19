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
  <title>GVS | Role Page</title>
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
        Role page
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>index.php/home"><i class="fa fa-home"></i> Home</a></li>
        <li><a href="<?php echo base_url(); ?>index.php/role"><i class="fa fa-industry"></i> User</a></li>
        <li><a href="#"><i class="fa fa-industry"></i> <?php print_r($flag); ?></a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h1 class="box-title"><?php print_r($flag); ?> User</h1>
          <div class="box-tools pull-right">
          </div>
        </div>
        <div class="box-body">
          <form role="form" method="post" action="<?php print_r(base_url().'index.php/role/save/'.$flag); ?>">
            <input type="hidden" name="id" value="<?php echo set_value('id',(empty($content->id))?'0':$content->id); ?>">
            <div class="form-group">
              <label class="control-label">Role Name <span class="error-label"><?php print_r(form_error('role_name')); ?></span></label>
              <input name="role_name" class="form-control" placeholder="Input Role Name" type="text" value="<?php echo set_value('role_name',(empty($content->role_name))?'':$content->role_name); ?>">
            </div>
            <div class="form-group">
              <label class="control-label">Active<span class="error-label"><?php print_r(form_error('activeCbo')); ?></span></label>
              <?php
                $is_active=set_value('activeCbo',empty($content->is_active)?'1':$content->is_active);
              ?>
              <select name="activeCbo" class="form-control">
                <option <?php print_r( ($is_active==1)?"selected":"") ?> value="1">True</option>
                <option <?php print_r( ($is_active==0)?"selected":"") ?> value="0">False</option>
              </select>
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
    $('#idTable').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    });
    $("#cancel").click(function() {
      window.location.href='<?php echo base_url(); ?>index.php/role'
    })
  })
</script>
</body>
</html>