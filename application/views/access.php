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
  <title>GVS | Access Menu Page</title>
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
        Access Menu page
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>index.php/home"><i class="fa fa-home"></i> Home</a></li>
        <li><a href="#"><i class="fa fa-get-pocket"></i> Access Menu</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h1 class="box-title">Access Menu</h1>
          <div class="box-tools pull-right">
          </div>
        </div>
        <div class="box-body">
        <?php echo empty($result)?"":$result; ?>
          <div class="row">
            <form role="form" method="post" action="<?php print_r(base_url().'index.php/user/accessShow'); ?>">
              <div class="col-sm-3">
                <label>Role <span class="error-label"><?php print_r(form_error('roleCbo')); ?></span></label>
                <select name="roleCbo" class="form-control">
                <option>--Select--</option>
                  <?php 
                    foreach ($roleData as $row)
                    {
                      $idRole=$row->id;
                      $role=set_value('roleCbo',empty($roleId)?'':$roleId);
                      $selected=($idRole == $role)?"selected":"";
                      print_r("<option ".$selected." value=\"".$idRole."\">".$row->role_name."</option>");
                    }
                  ?>
                </select>
              </div>
              <div class="col-sm-1" style="margin-top: 25px;margin-left:-40px;">
                <button type="submit" class="btn btn-info pull-right">Go</button>
              </div>
            </form>
          </div>
          <div class="row" style="padding: 10px">
          <?php
          if (!empty($table))
            {
              print_r("<form role=\"form\" method=\"post\" action=\"". base_url()."index.php/user/accessSave/". $sess->id ."\">");
              print_r("<input type=\"hidden\" name=\"role_id\" value=\"".$roleId."\">");
              foreach ($table as $row)
              {
          ?>
              <div class="col-sm-4">
              <label>
                <?php
                  $checked=($row->is_checked==1)?"checked ":" ";
                  print_r("<input " . $checked . " id=\"chk_" . $row->id ."\" type=\"checkbox\" name=\"menu_access[]\" value=\"" . $row->id . "\"> " . $row->menu_name ."<br>");
                ?>
              </label>
              </div>
            <?php } ?>
              <div class="col-sm-12" style="padding: 5px">
                <button type="button" id="cancel" class="btn btn-default">Cancel</button>
                <button type="submit" class="btn btn-info pull-right">Save</button>
              </div>
            <?php print_r("</form>"); } ?>
          </div>
          <div class="box-footer">
          </div>
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