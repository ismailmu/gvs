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
  <title>GVS | Room Page</title>
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
        Room page
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>index.php/home"><i class="fa fa-home"></i> Home</a></li>
        <li><a href="<?php echo base_url(); ?>index.php/room"><i class="fa fa-square"></i> room</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h1 class="box-title">Room</h1>
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
              <th>Room Id</th>
              <th>Room Name</th>
              <th>Room Type</th>
              <th>Room Status</th>
              <th>Cost</th>
              <th>Cost Unit</th>
              <th>Is Active</th>
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
                    print_r("<td>". $row->room_id ."</td>");
                    print_r("<td>". $row->room_name ."</td>");
                    print_r("<td>". $row->room_type ."</td>");
                    $flag=(empty($row->room_status))?"Open":($row->room_status == 1)?"Booked":"Open";
                    print_r("<td>". $flag ."</td>");
                    print_r("<td class=\"amount-label\">". number_format($row->amount) ."</td>");
                    print_r("<td>". $row->amount_duration .' '. $row->amount_unit ."</td>");
                    $flag=($row->is_active == 1)?"checked":"";
                    print_r("<td><input type=\"checkbox\"" . $flag . "></td>");
                    print_r("<td><a href=\"". base_url() . "index.php/room/edit/" . $row->id . "\"><i class=\"fa fa-edit\"></i> Edit</a></td>");
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

    $("#add").click(function() {
      window.location.href='<?php echo base_url(); ?>index.php/room/add'
    });

    $("#alert").fadeTo(2000, 500).slideUp(500, function(){
      $("#alert").slideUp(500);
    });
    
  })
</script>
</body>
</html>