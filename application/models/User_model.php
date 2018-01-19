<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends MY_Model
{
    function __construct()
    {
    	$this->table = 'm_user';
        $this->primary_key = 'id';
        $this->soft_deletes = FALSE;
        $this->timestamps = TRUE;
        $this->fillable = array('user_id','user_name','password','is_user_logged','last_user_login','icon_file','role_id','gender','is_active','created_by','updated_by');

        parent::__construct();
    }

    public function getAllUser()
    {
        return $this->db->query("SELECT a.*,b.role_name FROM m_user a JOIN m_role b ON a.role_id = b.id")->result();
    }

    public function getAllMenuByRole($id)
    {
        return $this->db->query("SELECT *,(case when b.role_id is null then 0 else 1 end) is_checked from m_menu a LeFT JOIN m_menu_role b on a.id = b.menu_id and b.role_id=".$id)->result();
    }

    public function getUserNotAdmin()
    {
        return $this->db->query("SELECT * FROM m_user WHERE is_active = 1 AND user_id NOT IN ('admin')")->result();   
    }
}