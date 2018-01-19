<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class TService_model extends MY_Model
{
    function __construct()
    {
    	$this->table = 't_service';
        $this->primary_key = 'id';
        $this->soft_deletes = FALSE;
        $this->timestamps = TRUE;
        $this->fillable = array('id_card','transaction_at','duration','total','created_by','updated_by');

        parent::__construct();
    }
}