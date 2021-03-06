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
  <title>GVS | Therapist Page</title>
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
        Therapist page
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>index.php/home"><i class="fa fa-home"></i> Home</a></li>
        <li><a href="<?php echo base_url(); ?>index.php/therapist"><i class="fa fa-houzz"></i> Therapist</a></li>
        <li><a href="#"><i class="fa fa-houzz"></i> <?php print_r($flag); ?></a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h1 class="box-title"><?php print_r($flag); ?> Therapist</h1>
          <div class="box-tools pull-right">
          </div>
        </div>
        <div class="box-body">
          <form id="form" role="form" method="post" action="<?php print_r(base_url().'index.php/therapist/save/'.$flag); ?>">
            <input type="hidden" name="id" value="<?php echo set_value('id',(empty($content->id))?'0':$content->id); ?>">
           <div class="form-group">
              <label class="control-label">Therapist<span class="error-label"><?php print_r(form_error('therapistCbo')); ?></span></label>
              <?php
                $therapistCbo=set_value('therapistCbo',empty($content->id_user)?'1':$content->id_user);
              ?>
              <select name="therapistCbo" class="form-control">
              <option value="">--Select--</option>
              <?php
                foreach ($userData as $row)
                {
                  $idUser=$row->id;
                  $user=set_value('therapistCbo',$content->id_user);
                  //echo $id_user.'-'.$user;
                  $selected=($idUser == $user)?"selected":"";
                  print_r("<option ".$selected." value=\"".$idUser."\">".$row->user_name."</option>");
                }
              ?>
              </select>
            </div>
            <div class="form-group">
              <label class="control-label">Cost <span class="error-label"><?php print_r(form_error('amount')); ?></span></label>
              <input id="amount" name="amount" class="form-control" placeholder="Input Cost" type="text" value="<?php echo set_value('amount',(empty($content->amount))?'':$content->amount); ?>">
            </div>
            <div class="form-group">
              <label class="control-label">Duration (Hour) <span class="error-label"><?php print_r(form_error('amount_duration')); ?></span></label>
              <input id="amount_duration" name="amount_duration" class="form-control" placeholder="Input Duration" type="text" value="<?php echo set_value('amount_duration',(empty($content->amount_duration))?'1':$content->amount_duration); ?>">
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

    $('#amount').val( format_number($('#amount').val() ) );

    $('#amount').keyup(function() {
      $(this).val( format_number( $(this).val() ) );
    });

    $("#form").submit(function(){
      var amount = $('#amount').val();
      $('#amount').val( amount.replace(/,/g, '') );
    });

    $("#cancel").click(function() {
      window.location.href='<?php echo base_url(); ?>index.php/role'
    })
  })
</script>
</body>
</html>