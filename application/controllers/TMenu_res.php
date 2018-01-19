<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TMenu_res extends CI_Controller {

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
		$data['show']=NULL;
		$this->setIndex($data);
	}

	private function setIndex($data) 
	{
		if($this->session->userdata('user_session'))
		{
			$this->load->model('tmenu_res_model');
			$data['table'] = $this->tmenu_res_model->getTMenuSummaryByNow();
			$this->load->view('tmenu_res',$data);
		}
		else
		{
			$data['session_desc']='';
			$this->load->view('login',$data);
		}
	}

	public function tMenuShow()
	{
		$card_id=$this->input->post('card_id');
		$data['result']=NULL;
		$data['show']=TRUE;
		$data['card_id']=$card_id;
		$data['flag'] = "Add";
		
		$this->load->model('card_model');
		$data['content']=$this->card_model->where('card_id',$card_id)->get();

		$this->load->model('menu_res_model');
		$data['menu'] = $this->menu_res_model->where('is_active','1')->get_all();

		$this->load->view('tmenu_res_action',$data);
	}

	public function add()
	{
		if($this->session->userdata('user_session'))
		{
			$data['flag'] = "Add";
			$this->load->model('menu_res_model');
			$data['menu'] = $this->menu_res_model->where('is_active','1')->get_all();

			$this->load->model('menu_res_model');
			$data['menu_res'] = $this->menu_res_model->get_all();

			$this->load->model('card_model');
			$data['content'] = NULL;
			$this->load->view('tmenu_res_action',$data);
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
			$this->load->model('tmenu_res_model');
			$data['content'] = $this->tmenu_res_model->get($id);
			
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

    	$this->load->model('tmenu_res_model');
		$unique=$this->tmenu_res_model->where('user_id',$str)->get();

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
				$before=strtolower($this->tmenu_res_model->get($id)->user_name);
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
		$this->load->model('tmenu_res_model');

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
				$this->tmenu_res_model->insert(array('user_id' => $user_id,'is_active' => $is_active,'gender' => $gender,'user_name' => $user_name,'password' => $pass2,'role_id' => $role, 'icon_file' => $avatar,'created_by' => $this->session->userdata('user_session')->id));
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
				$this->tmenu_res_model->update(array('user_id' => $user_id,'user_name' => $user_name,'gender' => $gender, 'is_active' => $is_active,'role_id' => $role, 'icon_file' => $avatar,'updated_by' => $this->session->userdata('user_session')->id),$id);
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