<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Role_model extends MY_Model
{
    function __construct()
    {
    	$this->table = 'm_role';
        $this->primary_key = 'id';
        $this->soft_deletes = FALSE;
        $this->timestamps = TRUE;
        $this->fillable = array('role_name','is_active','created_by','updated_by');

        parent::__construct();
    }
}