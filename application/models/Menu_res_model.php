<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_res_model extends MY_Model
{
    function __construct()
    {
    	$this->table = 'm_menu_res';
        $this->primary_key = 'id';
        $this->soft_deletes = FALSE;
        $this->timestamps = TRUE;
        $this->fillable = array('menu_name','menu_type','stock','amount','is_active','created_by','updated_by');

        parent::__construct();
    }
}