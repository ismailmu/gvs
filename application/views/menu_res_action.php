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
  <title>GVS | Menu Restauran Page</title>
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
        Menu Restaurant page
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>index.php/home"><i class="fa fa-home"></i> Home</a></li>
        <li><a href="<?php echo base_url(); ?>index.php/menu_res"><i class="fa fa-cc-diners-club"></i> Menu Restaurant</a></li>
        <li><a href="#"><i class="fa fa-cc-diners-club"></i> <?php print_r($flag); ?></a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h1 class="box-title"><?php print_r($flag); ?> Menu Restaurant</h1>
          <div class="box-tools pull-right">
          </div>
        </div>
        <div class="box-body">
          <form id="form" role="form" method="post" action="<?php print_r(base_url().'index.php/menu_res/save/'.$flag); ?>">
            <input type="hidden" name="id" value="<?php echo set_value('id',(empty($content->id))?'0':$content->id); ?>">
            <div class="form-group">
              <label class="control-label">Menu Name <span class="error-label"><?php print_r(form_error('menu_name')); ?></span></label>
              <input name="menu_name" class="form-control" placeholder="Input Menu Name" type="text" value="<?php echo set_value('menu_name',(empty($content->menu_name))?'':$content->menu_name); ?>">
            </div>
            <div class="form-group">
              <label class="control-label">Amount <span class="error-label"><?php print_r(form_error('amount')); ?></span></label>
              <input id="amount" name="amount" class="form-control" placeholder="Input Amount" type="text" value="<?php echo set_value('amount',(empty($content->amount))?'':$content->amount); ?>">
            </div>
            <div class="form-group">
              <label class="control-label">Stock <span class="error-label"><?php print_r(form_error('stock')); ?></span></label>
              <input id="stock" name="stock" class="form-control" placeholder="Input Stock" type="text" value="<?php echo set_value('stock',(empty($content->stock))?'':$content->stock); ?>">
            </div>
            <div class="form-group">
              <label class="control-label">Menu Type <span class="error-label"><?php print_r(form_error('menu_type')); ?></span></label>
              <input name="menu_type" class="form-control" placeholder="Input Menu Type" type="text" value="<?php echo set_value('menu_type',(empty($content->menu_type))?'':$content->menu_type); ?>">
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
    $('#stock').val( format_number($('#stock').val() ) );

    $('#amount').keyup(function() {
      $(this).val( format_number( $(this).val() ) );
    });

    $('#stock').keyup(function() {
      $(this).val( format_number( $(this).val() ) );
    });

    $("#form").submit(function(){
      var amount = $('#amount').val();
      $('#amount').val( amount.replace(/,/g, '') );

      var stock = $('#stock').val();
      $('#stock').val( stock.replace(/,/g, '') );
    });

    $("#cancel").click(function() {
      window.location.href='<?php echo base_url(); ?>index.php/menu_res'
    })
  });
</script>
</body>
</html>