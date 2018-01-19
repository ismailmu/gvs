<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Card_model extends MY_Model
{
    function __construct()
    {
    	$this->table = 't_menu_detail';
        $this->primary_key = 'id';
        $this->soft_deletes = FALSE;
        $this->timestamps = TRUE;
        $this->fillable = array('id_summary','id_menu','quantity','amount','created_by','updated_at','updated_by');

        parent::__construct();
    }
}//end class