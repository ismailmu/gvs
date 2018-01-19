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
  <title>GVS | Trx Menu Restaurant Page</title>
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
        Trx Menu Restaurant page
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>index.php/home"><i class="fa fa-home"></i> Home</a></li>
        <li><a href="<?php echo base_url(); ?>index.php/menu_res"><i class="fa fa-gcc"></i> Trx Menu Restaurant</a></li>
        <li><a href="#"><i class="fa fa-gcc"></i> <?php print_r($flag); ?></a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h1 class="box-title"><?php print_r($flag); ?> Trx Menu Restaurant</h1>
          <div class="box-tools pull-right">
            <button id="add" type="button" class="btn btn-default">
              <i class="fa fa-plus"></i> Add Menu
            </button>
          </div>
        </div>
        <div class="box-body">
          <div class="row">
            <form role="form" method="post" action="<?php print_r(base_url().'index.php/tmenu_res/tMenuShow'); ?>">
              <div class="col-sm-4">
                <label>Scan Card: </label>
                <?php
                  $error = "";
                  if (!empty($show))
                  {
                    if (empty($content->card_id))
                    {
                      $error = "User not register, please top up first";
                      $show=false;
                    }
                    else 
                    {
                      if ($content->balance <= 0) 
                      {
                        $error = "Balance is zero, please top up first";
                        $show=false;
                      }
                      else
                      {
                        $error = "";
                        $show=true;
                      }
                    }
                  }

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
          <?php if (!empty($show)) { ?>
          <div class="row">
            <div class="col-xs-12">
              <h2 class="page-header">
                <span class="error-label"><?php print_r($error); ?></span></label><br/>
                <i class="fa fa-credit-card"></i> #########<?php print_r(empty($content->card_id_suffix)?'':$content->card_id_suffix); ?>.
                <span class="pull-right">Balance: Rp. <?php print_r(empty($content->balance)?'0':number_format($content->balance)); ?></span>
                <input type="hidden" id="balance" name="balance" value="<?php print_r(empty($content->balance)?'0':$content->balance); ?>">
              </h2>
            </div>
          <!-- /.col -->
          </div>
          <div class="row">
            <form id="form" role="form" method="post" action="<?php print_r(base_url().'index.php/tmenu_res/save/'.$flag); ?>">
              <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th>Menu</th>
                      <th>Stock</th>
                      <th>Price</th>
                      <th>Quantity</th>
                      <th>Sub Total</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    $max_row = 0;
                    if (!empty($table)) 
                    {
                      $max_row = count($table);
                    }
                    else
                    {
                      $max_row = 5;
                    }
                    print_r("<input type=\"hidden\" id=\"max_row\" value=\"".$max_row."\">");

                    for ($i = 1; $i <= $max_row; $i++)
                    {
                    ?>
                      <tr id="tr_<?php print_r($i); ?>">
                        <td><select id="menu_<?php print_r($i); ?>" class="form-control select2 select2-hidden-accessible" style="width: 100%" tabindex="-1" aria-hidden="true">
                        <option value="~~">--Select--</option>
                        <?php
                          foreach ($menu as $row)
                          {
                            $idMenu=$row->id;
                            $selected=($idMenu == '')?"selected":"";
                            $value = $idMenu . "~" . $row->amount . "~" . $row->stock;
                            print_r("<option ".$selected." value=\"".$value."\">".$row->menu_name."</option>");
                          }
                        ?>
                        </td>
                        <td><input id="stock_<?php print_r($i); ?>" class="amount-label" style="width: 100%;" type="text" readonly="true" name="stock[]" value="1"></td>
                        <td><input id="amount_<?php print_r($i); ?>" class="amount-label" style="width: 100%;" type="text" readonly="true" name="amount[]"></td>
                        <td><input readonly="true" id="quantity_<?php print_r($i); ?>" class="amount-label quantity-text" style="width: 100%;" type="text" name="quantity[]" value="1"></td>
                        <td><input id="sub_<?php print_r($i); ?>" class="amount-label" style="width: 100%;" type="text" readonly="true"></td>
                        <td><a id="cancel_<?php print_r($i); ?>" class="cancel-button" href="#"><i class="fa fa-close"></i> Cancel</a></td>
                      </tr>
                    <?php
                    }
                    ?>
                  </tbody>
                </table>
              </div>
              <div class="col-sm-12" style="padding: 5px">
                <button type="button" id="cancel" class="btn btn-default">Cancel</button>
                <button type="submit" class="btn btn-info pull-right">Save</button>
              </div>
            </form>
          </div>
          <?php } ?>
          <!-- /.row -->
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

    /*
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
    */

        //Initialize Select2 Elements
    $('.select2').select2();

    $(".cancel-button").click(function() {
      //console.log(this.id);
      var id=this.id.split('_')[1];
      $('#tr_'+id).remove();
      //console.log(id);
    });

    $("#add").click(function() {
      var max_row = parseInt($("#max_row").val());
      //console.log(max_row);

    });

    function setSubTotal(id) {
      var amount = $('#amount_'+id).val();
      amount = amount.replace(/,/g, '');
      amount = parseInt(amount);

      var stock = $('#stock_'+id).val();
      stock = parseInt(stock);

      var quantity = $("#quantity_"+id).val();
      quantity = quantity.replace(/,/g, '');
      quantity = parseInt(quantity);
      if ( isNaN(quantity) ) {
        quantity = 0;
      }
      if ( quantity <= 0 ) {
        quantity = 1;
      }
      if ( quantity > stock) {
        quantity = stock;
      }
      var total = amount * quantity;
      total = total.toString();
      quantity = quantity.toString();
      $("#quantity_"+id).val( format_number(quantity) );
      $('#sub_'+id).val( format_number(total) );
    }

    $(".select2").change(function() {
      console.log(this.id);
      var id=this.id.split('_')[1];
      var menu=$('#menu_'+id).val().split("~");
      $('#amount_'+id).val( format_number(menu[1]) );
      $('#stock_'+id).val(menu[2]);
      
      $('#quantity_'+id).attr("readonly", false); 
      setSubTotal(id);

    });

    $('.quantity-text').keyup(function() {
      var id=this.id.split('_')[1];
      setSubTotal(id);
    });

    $("#cancel").click(function() {
      window.location.href='<?php echo base_url(); ?>index.php/tmenu_res'
    });

    $("#form").submit(function(){
      var total = 0;
      $("input[type=text]").each(function() {
        var id = this.id.split("_")[0];
        if (id == "sub") {
          var sub = $(this).val();
          sub = sub.replace(/,/g, '');
          if (!(sub)) {
            sub = 0;
          }
          //console.log(sub);
          total += parseInt(sub);
        }
      });
      var balance=parseInt( $("#balance").val() );
      if (total > balance) {
        $(".error-label").html("Total must less than or equal balance");
        return false;
      }else {
        $(".error-label").html('');
        return true;
      }



    });
    $("#cancel").click(function() {
      window.location.href='<?php echo base_url(); ?>index.php/tmenu_res'
    });
  });
</script>
</body>
</html>