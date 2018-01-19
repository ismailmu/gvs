<?php $menu=$this->session->userdata('menu_session'); 
if (empty($menu)) {
  print_r("<script>window.location.href='".base_url()."index.php/home'</script>");
}
?>
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
    </div>
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">MAIN NAVIGATION</li>
      <?php
        foreach ($menu as $row)
        {
          print_r('<li class="active">');
          print_r("<a href=\"". base_url() . "index.php/" . $row->menu_url . "\">");
          print_r('<i class="'. $row->menu_icon . '"></i>');
          print_r('<span>' . $row->menu_name . '</span></a></li>');
        }
      ?>
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>