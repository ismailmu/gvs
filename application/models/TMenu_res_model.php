<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class TMenu_res_model extends MY_Model
{
    function __construct()
    {
    	$this->table = 't_menu_summary';
        $this->primary_key = 'id';
        $this->soft_deletes = FALSE;
        $this->timestamps = TRUE;
        $this->fillable = array('id_menu','id_card','card_id_suffix','transaction_at','total','created_by','updated_at','updated_by');

        parent::__construct();
    }

    public function getTMenuSummaryByNow() {
    	 return $this->db->query("SELECT * FROM t_menu_summary WHERE transaction_at >= NOW()")->result();
    }
}//end class