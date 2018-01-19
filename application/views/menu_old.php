<?php
foreach ($menu as $row)
{
	print_r('<li class="treeview">');
	print_r('<a href="'. base_url() . 'index.php/' . $row->menu_url . '">');
	print_r('<i class="'. $row->icon_file . '></i>');
	print_r('<i class="'.$row->icon_file . '></i>');
	print_r('<span>' . $row->menu_name . '</span></a></li>');
}
?>