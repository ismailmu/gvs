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
  <title>GVS | Top up Page</title>
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
        Top up Menu page
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>index.php/home"><i class="fa fa-home"></i> Home</a></li>
        <li><a href="#"><i class="fa fa-object-group"></i> Top up Menu</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h1 class="box-title">Top up Menu</h1>
          <div class="box-tools pull-right">
          </div>
        </div>
        <div class="box-body">
        <?php echo empty($result)?"":$result; ?>
          <div class="row">
            <form role="form" method="post" action="<?php print_r(base_url().'index.php/card/cardShow'); ?>">
              <div class="col-sm-4">
                <label>Scan Card: </label>
                <?php 
                  $readonly=(empty($show))?"":"readonly"; 
                  $value = '';

                  if (empty($show)) {
                    $value='';
                  }else {
                    if (!empty($content->card_id)) {
                      $value = $content->card_id;
                    }else {
                      $value = $card_id;
                    }
                  }
                ?>

                <input id="card_id" type="password" name="card_id" value="<?php echo $value; ?>" <?php print_r($readonly); ?>>
                <?php if (empty($show)) { ?>
                  <button style="position: absolute;margin-left: 10px" type="submit" class="btn btn-info pull-right">Go</button>
                <?php } ?>
              </div>
           
            </form>
          </div>
          <div class="row" style="padding: 10px">
          <?php if (!empty($show)) { ?>
            <form id="form" role="form" method="post" action="<?php print_r(base_url().'index.php/card/save'); ?>">
              <input type="hidden" name="card_id" value="<?php echo set_value('card_id',(empty($content->card_id))?$card_id:$content->card_id); ?>">
              <section class="invoice">
                <!-- title row -->
                <div class="row">
                  <div class="col-xs-12">
                    <h2 class="page-header">
                      <i class="fa fa-credit-card"></i> #########<?php print_r(empty($content->card_id_suffix)?'':$content->card_id_suffix); ?>.
                      <small class="pull-right">Last Top up: <?php print_r(empty($content->last_topup_at)?'-':date_format(date_create($content->last_topup_at),'Y-m-d H:i')); ?></small>
                    </h2>
                  </div>
                  <!-- /.col -->
                </div>
                <!-- info row -->
                <div class="row invoice-info">
                  <div class="col-sm-4 invoice-col">
                    Name <span class="error-label"><?php print_r(form_error('card_name')); ?></span>
                    <address>

                      <strong><input type="text" name="card_name" value="<?php print_r(empty($content->card_name)?'':$content->card_name); ?>"></strong>
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
                          <input type="hidden" name="balance" value="<?php print_r(empty($content->balance)?'0':$content->balance); ?>">
                          <td class="amount-label">Rp.<span id="balance"><?php print_r(empty($content->balance)?'0':number_format($content->balance)); ?></span></td>
                        </tr>
                        <tr>
                          <th>Top Up:</th>
                          <td class="amount-label"><span class="error-label"><?php print_r(form_error('amount')); ?></span>Rp.<input class="amount-label" type="text" name="amount" id="amount" value="<?php print_r(empty($amount)?'0':$amount); ?>"></td>
                        </tr>
                        <tr>
                          <th>Total:</th>
                          <td style="text-align: right;">Rp.<span id="total"><?php print_r(empty($content->balance)?'0':number_format($content->balance)); ?></span></td>
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
  $(function () {
    $("#card_id").focus();
    
    $("#form").submit(function(){
      var amount = $('#amount').val();
      $('#amount').val( amount.replace(/,/g, '') );
    });

    $("#cancel").click(function() {
      window.location.href='<?php echo base_url(); ?>index.php/card'
    });

    $("#alert").fadeTo(2000, 500).slideUp(500, function(){
      $("#alert").slideUp(500);
    });

    $('#amount').val( format_number($('#amount').val() ) );
    $('#total').val( format_number($('#total').val() ) );

    $('#amount').keyup(function() {
      var amount=$(this).val();
      $(this).val( format_number(amount) );

      amount=amount.replace(/,/g, '');

      var balance=$('#balance').html();
      balance=balance.replace(/,/g, '');

      //console.log(amount);
      //console.log(balance);

      var total=(parseInt(balance) + parseInt(amount)).toString();
      
      $('#total').html( format_number( total ) );
    });
  })
</script>
</body>
</html>