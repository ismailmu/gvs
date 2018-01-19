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
  <title>GVS | Trx Service Page</title>
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
        Trx Service Menu page
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>index.php/home"><i class="fa fa-home"></i> Home</a></li>
        <li><a href="#"><i class="fa fa-yc"></i> Trx Service Menu</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h1 class="box-title">Service Menu</h1>
          <div class="box-tools pull-right">
          </div>
        </div>
        <div class="box-body">
        <?php echo empty($result)?"":$result; ?>
          <div class="row">
            <form role="form" method="post" action="<?php print_r(base_url().'index.php/tservice/serviceShow'); ?>">
              <div class="col-sm-4">
                <label>Scan Card: </label>
                <?php 
                  $readonly=(empty($cardData))?"":"readonly"; 
                  $value = '';

                  if (empty($cardData)) {
                    $value='';
                  }else {
                    if (!empty($cardData->card_id)) {
                      $value = $cardData->card_id;
                    }else {
                      $value = $card_id;
                    }
                  }
                ?>

                <input id="card_id" type="password" name="card_id" value="<?php echo $value; ?>" <?php print_r($readonly); ?>>
                <?php if (empty($cardData)) { ?>
                  <button style="position: absolute;margin-left: 10px" type="submit" class="btn btn-info pull-right">Go</button>
                <?php } ?>
              </div>
           <?php print_r( (empty($empty_card))?"":$empty_card ); ?>
            </form>
          </div>
          <div class="row" style="padding: 10px">
          <?php if (!empty($cardData)) { ?>
            <form id="form" role="form" method="post" action="<?php print_r(base_url().'index.php/tservice/save'); ?>">
              <input type="hidden" name="card_id" value="<?php echo set_value('card_id',(empty($cardData->card_id))?$card_id:$cardData->card_id); ?>">
              <section class="invoice">
                <!-- title row -->
                <div class="row">
                  <div class="col-xs-12">
                    <h2 class="page-header">
                      <i class="fa fa-credit-card"></i> #########<?php print_r(empty($cardData->card_id_suffix)?'':$cardData->card_id_suffix); ?>.
                      <small class="pull-right">Last Top up: <?php print_r(empty($cardData->last_topup_at)?'-':date_format(date_create($cardData->last_topup_at),'Y-m-d H:i')); ?></small>
                    </h2>
                  </div>
                  <!-- /.col -->
                </div>
                <!-- info row -->
                <div class="row invoice-info">
                  <div class="col-sm-4 invoice-col">
                    Name <span class="error-label"><?php print_r(form_error('card_name')); ?></span>
                    <address>
                      <strong><?php print_r(empty($cardData->card_name)?'':$cardData->card_name); ?></strong>
                    </address>
                  </div>
                </div>
                <div class="row">
                  <!-- /.col -->
                  <div class="col-xs-12">
                    <div class="table-responsive">
                      <table class="table" style="font-size: 16px;">
                        <tr>
                          <th style="width:50%">Balance:</th>
                          <td class="amount-label">Rp.<span id="balance"><?php print_r(empty($cardData->balance)?'0':number_format($cardData->balance)); ?></span></td>
                        </tr>
                        <tr>
                          <th>Cost:</th>
                          <td class="amount-label">Rp.<span id="cost"><?php print_r(empty($therapistData->amount)?'0':number_format($therapistData->amount)); ?></span></td>
                        </tr>
                        <tr>
                          <th>Duration (Hours):</th>
                          <input type="hidden" name="duration" value="<?php print_r(empty($duration)?'1':$duration); ?>">
                          <td class="amount-label"><span class="error-label"><?php print_r(form_error('duration')); ?></span><input class="amount-label" type="text" name="duration" id="duration" value="<?php print_r(empty($duration)?'1':$duration); ?>"></td>
                        </tr>
                        <tr>
                          <th>Total:</th>
                          <span id="error_total" class="error-label"></span>
                          <input type="hidden" name="total" value="<?php print_r(empty($content->total)?'0':number_format($content->total)); ?>">
                          <td style="text-align: right;">Rp.<span id="total"><?php print_r(empty($content->total)?'0':number_format($content->total)); ?></span></td>
                        </tr>
                      </table>
                    </div>
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </section>
              <div class="col-sm-12" style="padding: 5px">
                <button type="button" id="cancel" class="btn btn-default">Cancel</button>
                <button type="submit" class="btn btn-info pull-right">Save</button>
              </div>
            </form>
          <?php } ?>
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
  function setTotal() {
    var duration=$("#duration").val();
    duration=duration.replace(/,/g, '');
    
    $("#duration").val( format_number(duration) );

    var cost=$('#cost').html();
    cost=cost.replace(/,/g, '');

    //console.log(amount);
    //console.log(balance);

    var total=(parseInt(cost) * parseInt(duration)).toString();
    
    $('#total').html( format_number( total ) );
  };

  $(function () {
    $("#card_id").focus();
    
    $("#form").submit(function(){
      var duration = $('#duration').val();
      $('#duration').val( duration.replace(/,/g, '') );

      var balance = $('#balance').html();
      balance = balance.replace(/,/g, '');

      var total = $('#total').html();
      total = total.replace(/,/g, '');
      console.log(total);console.log(balance);

      if ( parseInt(total) > parseInt(balance) ) {
        $("#error_total").html ('Total greater than balance, please top up');
        return false;
      }else {
        return true;
      }

    });

    $("#cancel").click(function() {
      window.location.href='<?php echo base_url(); ?>index.php/tservice'
    });

    $("#alert").fadeTo(2000, 500).slideUp(500, function(){
      $("#alert").slideUp(500);
    });

    $('#duration').val( format_number($('#duration').val() ) );
    $('#cost').val( format_number($('#cost').val() ) );

    $('#duration').keyup(function() {
      setTotal();
    });

    setTotal();
  })
</script>
</body>
</html>