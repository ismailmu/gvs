<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Room_model extends MY_Model
{
    function __construct()
    {
    	$this->table = 'm_room';
        $this->primary_key = 'id';
        $this->soft_deletes = FALSE;
        $this->timestamps = TRUE;
        $this->fillable = array('room_id','room_name','room_type','is_active','created_by','updated_by','amount','amount_duration','amount_unit','room_status');

        parent::__construct();
    }
}