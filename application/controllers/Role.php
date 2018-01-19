<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Role extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/home
	 *	- or -
	 * 		http://example.com/index.php/home/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/home/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function index()
	{
		$data['result'] = NULL;
		$this->setIndex($data);
	}

	private function setIndex($data)
	{
		if($this->session->userdata('user_session'))
		{
			$this->load->model('role_model');
			$data['table'] = $this->role_model->get_all();
			$this->load->view('role',$data);
		}
		else
		{
			$data['session_desc']='';
			$this->load->view('login',$data);
		}
	}

	public function add()
	{
		if($this->session->userdata('user_session'))
		{
			$data['flag'] = "Add";
			$data['content'] = NULL;
			$this->load->view('role_action',$data);
		}
		else
		{
			$data['session_desc']='';
			$this->load->view('login',$data);
		}
	}

	public function edit($id)
	{
		$data['flag'] = "Edit";
		if($this->session->userdata('user_session'))
		{
			$this->load->model('role_model');
			$data['content'] = $this->role_model->get($id);
			
			$this->load->view('role_action',$data);
		}
		else
		{
			$data['session_desc']='';
			$this->load->view('login',$data);
		}
	}

	public function rolename_check($str,$pre)
    {
    	$flag=explode('~', $pre)[0];
    	$id=explode('~', $pre)[1];
    	//echo $pre;
    	$this->load->model('role_model');
		$unique=$this->role_model->where('role_name',$str)->get();
    	
    	if ($flag == "Add") 
    	{
    		if (empty($unique)) {
    			return true;
    		}
    		else 
    		{
    			$this->form_validation->set_message('rolename_check', 'The {field} field not unique.');
    			return false;
    		}
    		
    	}
    	else //Edit
    	{
    		if (empty($unique))
    		{
    			return true;
    		}
    		else
    		{
    			$before=strtolower($this->role_model->get($id)->role_name);
    			//echo $before.'-'.$str.'-'.$unique->role_name;
    			$str=strtolower($str);

    			if ($str == $before)
    			{
    				return true;
    			}
    			else if (empty($unique)) 
				{
					return true;
				}
    			else if ($str == strtolower($unique->role_name)) 
	    		{
	    			$this->form_validation->set_message('rolename_check', 'The {field} field not unique');
    				return false;
	    		}
	    		else
	    		{
	    			return true;
	    		}
	    	}
    	}
    }

	public function save($flag)
	{
		$this->load->model('role_model');

		$id=$this->input->post('id');

		$role_name=$this->input->post('role_name');
		$is_active=$this->input->post('activeCbo');

		$this->form_validation->reset_validation();
		$this->form_validation->set_rules('role_name', 'Role Name', 'required|callback_rolename_check['.$flag.'~'.$id.']');

		if($flag == "Add")
		{
			if ($this->form_validation->run())
			{
				$this->role_model->insert(array('role_name' => $role_name,'is_active' => $is_active,'created_by' => $this->session->userdata('user_session')->id));
				$data['result']='<div id="alert" class="alert alert-success fade in alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a><strong>Insert success</strong></div>';
				$this->setIndex($data);
			}
			else
			{
				$data['flag'] = "Add";
				$this->load->view('role_action',$data);
			}
		}
		else //update
		{
			if ($this->form_validation->run())
			{
				$this->role_model->update(array('role_name' => $role_name,'is_active' => $is_active,'updated_by' => $this->session->userdata('user_session')->id),$id);
				$data['result']='<div id="alert" class="alert alert-success fade in alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a><strong>Edit success</strong></div>';
				$this->setIndex($data);
			}
			else
			{
				$data['flag'] = "Edit";
				$this->load->view('role_action',$data);
			}
		}
	}
}//end class