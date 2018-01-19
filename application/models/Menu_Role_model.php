<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_Role_model extends MY_Model
{
    function __construct()
    {
    	$this->table = 'm_menu_role';
        $this->primary_key = array('menu_id','role_id');
        $this->soft_deletes = FALSE;
        $this->timestamps = FALSE;

        $this->fillable = array('menu_id','role_id');

        parent::__construct();
    }

    public function resetMenuRole($role_id,$menu_arr)
    {
    	try
    	{
	    	$this->db->trans_begin();
	    	$this->where('role_id',$role_id)->delete();
	    	foreach ($menu_arr as $value) {
				$this->menu_role_model->insert(array('menu_id' => $value, 'role_id' => $role_id));
			}
	    	$this->db->trans_commit();

	    	return true;
	    }
	    catch (Exception $e) 
	    {
	    	$this->db->trans_rollback();
	    	return false;
	    }
    }
}