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
  <title>GVS | Transaction Menu Page</title>
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
        Transaction Menu page
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>index.php/home"><i class="fa fa-home"></i> Home</a></li>
        <li><a href="<?php echo base_url(); ?>index.php/user"><i class="fa fa-gg"></i> Trx Menu</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h1 class="box-title">Trx Menu</h1>
          <div class="box-tools pull-right">
            <button id="add" type="button" class="btn btn-default">
              <i class="fa fa-plus"></i> Add
              </button>
          </div>
        </div>
        <div class="box-body">
        <?php echo empty($result)?"":$result; ?>
          <table id="idTable" class="table table-bordered table-hover">
            <thead>
            <tr>
              <th>Card Id</th>
              <th>Name</th>
              <th>Total</th>
              <th>Transaction date</th>
              <th>Action</th>
            </tr>
            </thead>
            <tbody>
              <?php
                if (!empty($table))
                {
                  foreach ($table as $row)
                  {
                    print_r("<tr>");
                    print_r("<td>#########". $row->card_id_sufix ."</td>");
                    print_r("<td>". $row->card_name ."</td>");
                    print_r("<td>". number_format($row->total) ."</td>");
                    print_r("<td>". date_format(date_create($row->transaction_date),'Y-m-d') ."</td>");
                    print_r("<td><a href=\"". base_url() . "index.php/tmenu_res/edit/" . $row->id . "\"><i class=\"fa fa-edit\"></i> Edit</a></td>");
                    print_r("</tr>");
                  }
                }
              ?>
            </tbody>
          </table>
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

    $("#alert").fadeTo(2000, 500).slideUp(500, function(){
      $("#alert").slideUp(500);
    });

     $("#add").click(function() {
      window.location.href='<?php echo base_url(); ?>index.php/tmenu_res/add'
    })
  })
</script>
</body>
</html>