<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Card_model extends MY_Model
{
    function __construct()
    {
    	$this->table = 'm_card';
        $this->primary_key = 'id';
        $this->soft_deletes = FALSE;
        $this->timestamps = TRUE;
        $this->fillable = array('card_id','card_name','balance','is_user_logged','last_topup_at','created_by','updated_at','updated_by','card_id_suffix','balance','is_active');

        parent::__construct();
    }
}//end class