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
  <title>GVS | User Page</title>
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
        User page
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>index.php/home"><i class="fa fa-home"></i> Home</a></li>
        <li><a href="<?php echo base_url(); ?>index.php/user"><i class="fa fa-user"></i> User</a></li>
        <li><a href="#"><i class="fa fa-user"></i> <?php print_r($flag); ?></a></li>
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
          <form role="form" method="post" action="<?php print_r(base_url().'index.php/user/save/'.$flag); ?>">
            <input type="hidden" name="id" value="<?php echo set_value('id',(empty($content->id))?'0':$content->id); ?>">
            <div class="form-group">
              <label class="control-label">User Id <span class="error-label"><?php print_r(form_error('user_id')); ?></span></label>
              <input name="user_id" class="form-control" placeholder="Input User Id" type="text" value="<?php echo set_value('user_id',(empty($content->user_id))?'':$content->user_id); ?>">
            </div>
            <div class="form-group">
              <label class="control-label">User Name <span class="error-label"><?php print_r(form_error('user_name')); ?></span></label>
              <input name="user_name" class="form-control" placeholder="Input User Name" type="text" value="<?php echo set_value('user_name',(empty($content->user_name))?'':$content->user_name); ?>">
            </div>
            <div class="form-group">
              <label class="control-label">Gender<span class="error-label"><?php print_r(form_error('genderCbo')); ?></span></label>
              <?php
                $gender=set_value('genderCbo',empty($content->gender)?'':$content->gender);
              ?>
              <select name="genderCbo" class="form-control">
                <option <?php print_r( ($gender==1)?"selected":""); ?> value="1">Male</option>
                <option <?php print_r( ($gender==0)?"selected":""); ?> value="0">Female</option>
              </select>
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
            <?php if ( ($flag == "Add") ) { ?>
            <div class="form-group">
              <label>Password <span class="error-label"><?php print_r(form_error('password')); ?></span></label>
              <input name="password" class="form-control" placeholder="Input Passowrd" type="password" value="<?php echo set_value('password'); ?>">
            </div>
            <div class="form-group">
              <label>Confirm Passowrd <span class="error-label"><?php print_r(form_error('confirm_password')); ?></span></label>
              <input name="confirm_password" class="form-control" placeholder="Input Passowrd Again" type="password" value="<?php echo set_value('confirm_password'); ?>">
            </div>
            <?php } ?>
            <div class="form-group">
              <label>Role <span class="error-label"><?php print_r(form_error('roleCbo')); ?></span></label>
              <select name="roleCbo" class="form-control">
              <option>--Select--</option>
                <?php 
                  foreach ($roleData as $row)
                  {
                    $idRole=$row->id;
                    $role=set_value('roleCbo',$content->role_id);
                    $selected=($idRole == $role)?"selected":"";
                    print_r("<option ".$selected." value=\"".$idRole."\">".$row->role_name."</option>");
                  }
                ?>
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
      window.location.href='<?php echo base_url(); ?>index.php/user'
    })
  })
</script>
</body>
</html>