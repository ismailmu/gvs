<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_model extends MY_Model
{
    function __construct()
    {
    	$this->table = 'm_menu';
        $this->primary_key = 'id';
        $this->soft_deletes = FALSE;
        $this->timestamps = TRUE;
        $this->fillable = array('menu_name','menu_url','menu_icon','menu_order');

        //$this->has_many['menuRole'] = array('Menu_Role_model','menu_id','id');
/*
        $this->has_many_pivot['menuRole'] = array(
            'foreign_model'=>'Role_model',
            'pivot_table'=>'m_menu_role',
            'local_key'=>'id',
            'pivot_local_key'=>'menu_id',
            'pivot_foreign_key'=>'role_id',
            'foreign_key'=>'id');
*/
        parent::__construct();
    }

    public function getMenuByRole($role_id)
    {
    	return $this->db->query("SELECT * FROM m_menu a JOIN m_menu_role b ON a.id = b.menu_id WHERE b.role_id = " . $role_id . " ORDER BY a.menu_order")->result();
    }
}//end class