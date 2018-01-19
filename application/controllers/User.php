<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

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
		$data['result']=NULL;
		$this->setIndex($data);
	}

	private function setIndex($data) 
	{
		if($this->session->userdata('user_session'))
		{
			$this->load->model('user_model');
			$data['table'] = $this->user_model->getAllUser();
			$this->load->view('user',$data);
		}
		else
		{
			$data['session_desc']='';
			$this->load->view('login',$data);
		}
	}

	public function access()
	{
		//$data['result']='<div id="alert" class="alert alert-success fade in alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a><strong>Insert success</strong></div>';
		$data['result']=NULL;
		$this->load->model('role_model');
		$data['roleData'] = $this->role_model->get_all();
		$data['role']=NULL;
		$this->load->view('access',$data);
	}

	public function accessShow()
	{
		$roleId=$this->input->post('roleCbo');
		$data['result']=NULL;
		$this->load->model('role_model');
		$data['roleData'] = $this->role_model->get_all();
		$data['roleId']=$roleId;
		$this->form_validation->reset_validation();
		$this->form_validation->set_rules('roleCbo', 'Role', 'required');
		if ($this->form_validation->run())
		{
			$this->load->model('user_model');
			$data['table'] = $this->user_model->getAllMenuByRole($roleId);
		}
		$this->load->view('access',$data);
	}

	public function accessSave()
	{
		$menu_arr=$this->input->post('menu_access');
		$role_id=$this->input->post('role_id');
		$data['result']=NULL;
		$this->load->model('menu_role_model');
		if (!empty($menu_arr))
		{
			//delete first
			/*
			$this->menu_role_model->where('role_id',$role_id)->delete();
			foreach ($menu_arr as $value) {
				$this->menu_role_model->insert(array('menu_id' => $value, 'role_id' => 1/0));
				//echo $value;
			}
			if ($this->db->trans_status())
			{
				$data['result']='<div id="alert" class="alert alert-success fade in alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a><strong>Edit success</strong></div>';
			}
			else
			{
				$data['result']='<div id="alert" class="alert alert-danger fade in alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a><strong>Edit success</strong></div>';
			}
			*/
			if ($this->menu_role_model->resetMenuRole($role_id,$menu_arr))
			{
				$data['result']='<div id="alert" class="alert alert-success fade in alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a><strong>Edit success</strong></div>';
			}
			else
			{
				$data['result']='<div id="alert" class="alert alert-danger fade in alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a><strong>Edit success</strong></div>';
			}
		}
		$this->load->model('role_model');
		$data['roleData'] = $this->role_model->get_all();
		$this->load->view('access',$data);
	}

	public function add()
	{
		if($this->session->userdata('user_session'))
		{
			$data['flag'] = "Add";
			$this->load->model('role_model');
			$data['roleData'] = $this->role_model->get_all();
			$data['content'] = NULL;
			$this->load->view('user_action',$data);
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
			$this->load->model('user_model');
			$data['content'] = $this->user_model->get($id);
			
			$this->load->model('role_model');
			$data['roleData'] = $this->role_model->get_all();
			
			$this->load->view('user_action',$data);
		}
		else
		{
			$data['session_desc']='';
			$this->load->view('login',$data);
		}
	}

	public function userid_check($str,$pre)
    {
    	$flag=explode('~', $pre)[0];
    	$id=explode('~', $pre)[1];

    	$this->load->model('user_model');
		$unique=$this->user_model->where('user_id',$str)->get();

    	if ($flag == "Add") 
    	{
    		if (empty($unique)) {
    			return true;
    		}
    		else 
    		{
    			$this->form_validation->set_message('userid_check', 'The {field} field not unique.');
    			return false;
    		}
    	}
    	else //Edit
    	{    		
    		if (empty($unique)) {
    			return true;
    		}
    		else
    		{
				$before=strtolower($this->user_model->get($id)->user_name);
    			//echo $before.'-'.$str.'-'.$unique->user_name;
    			$str=strtolower($str);

    			if ($str == $before)
    			{
    				return true;
    			}
    			else if (empty($unique)) 
				{
					return true;
				}
    			else if ($str == strtolower($unique->user_name)) 
	    		{
	    			$this->form_validation->set_message('userid_check', 'The {field} field not unique');
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
		$this->load->model('user_model');

		$id=$this->input->post('id');

		$user_id=$this->input->post('user_id');
		$user_name=$this->input->post('user_name');
		$pass=$this->input->post('password');
		$pass2=md5($user_id . $pass);
		$role=$this->input->post('roleCbo');
		$gender=$this->input->post('genderCbo');
		$avatar=($gender==1)?"avatar5.png":"avatar2.png";
		$is_active=$this->input->post('activeCbo');

		$this->form_validation->reset_validation();
		$this->form_validation->set_rules('user_id', 'User Id', 'required|callback_userid_check['.$flag.'~'.$id.']');
		$this->form_validation->set_rules('user_name', 'User Name', 'required');
		$this->form_validation->set_rules('roleCbo', 'Role', 'required');
		$this->form_validation->set_rules('genderCbo', 'Gender', 'required');

		if($flag == "Add")
		{
			$this->form_validation->set_rules('password', 'Password', 'required');
			$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');

			if ($this->form_validation->run())
			{
				$this->user_model->insert(array('user_id' => $user_id,'is_active' => $is_active,'gender' => $gender,'user_name' => $user_name,'password' => $pass2,'role_id' => $role, 'icon_file' => $avatar,'created_by' => $this->session->userdata('user_session')->id));
				$data['result']='<div id="alert" class="alert alert-success fade in alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a><strong>Insert success</strong></div>';
				$this->setIndex($data);
			}
			else
			{
				$this->load->model('role_model');
				$data['roleData'] = $this->role_model->get_all();
				$data['flag'] = "Add";
				$this->load->view('user_action',$data);
			}
		}
		else //update
		{
			if ($this->form_validation->run())
			{
				$this->user_model->update(array('user_id' => $user_id,'user_name' => $user_name,'gender' => $gender, 'is_active' => $is_active,'role_id' => $role, 'icon_file' => $avatar,'updated_by' => $this->session->userdata('user_session')->id),$id);
				$data['result']='<div id="alert" class="alert alert-success fade in alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a><strong>Edit success</strong></div>';
				$this->setIndex($data);
			}
			else
			{
				$this->load->model('role_model');
				$data['roleData'] = $this->role_model->get_all();
				$data['flag'] = "Edit";
				$this->load->view('user_action',$data);
			}
		}
	}
}//end class