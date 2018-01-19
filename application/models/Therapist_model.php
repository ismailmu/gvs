<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Therapist_model extends MY_Model
{
    function __construct()
    {
    	$this->table = 'm_therapist';
        $this->primary_key = 'id';
        $this->soft_deletes = FALSE;
        $this->timestamps = TRUE;
        $this->fillable = array('id_user','amount','amount_duration','amount_unit','is_active','created_by','updated_by');

        parent::__construct();
    }

    public function getTherapist() {
    	return $this->db->query("SELECT a.*,b.user_name FROM m_therapist a JOIN m_user b ON a.id_user = b.id")->result();
    }
}