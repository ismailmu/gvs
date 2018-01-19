<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

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
		//$this->output->enable_profiler(TRUE);
		if($this->session->userdata('user_session'))
		{
			$data['user']=$this->session->userdata('user_session');
			$this->load->view('home',$data);
		}
		else 
		{
			$data['session_desc']='';
			$this->load->view('login',$data);
		}
	}
	
	public function login()
	{
		$this->form_validation->set_rules('user_id', 'User Id', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required',array('required' => 'You must provide a %s.'));
		
		if (!$this->form_validation->run())
		{
			$data['session_desc']='';
			$this->load->view('login',$data);
		}
		else
		{		
			$user=$this->input->post('user_id');
			$pass=$this->input->post('password');
			$pass2=md5($user . $pass);

			$this->load->model('user_model');
			$data['user']=$this->user_model->where(array('user_id' => $user, 'password' => $pass2))->get();

			if (!empty($data['user'])) 
			{
				$id=$data['user']->id;
				if ($data['user']->is_active == 1)
				{
					$id=$data['user']->id;
					//echo date("Y-m-d H:i:s");
					$this->load->model('menu_model');
					$data['menu'] = $this->menu_model->getMenuByRole($data['user']->role_id);
					$this->user_model->update(array('is_user_logged' => '1', 'last_user_login' => date("Y-m-d H:i:s")),$id);
					$this->session->set_userdata('user_session', $data['user']);
					$this->session->set_userdata('menu_session', $data['menu']);
					$this->load->view('home');
				}
				else 
				{
					$data['session_desc']='User Name is disabled';
					$this->load->view('login',$data);
				}
			}
			else
			{
				$data['session_desc']='Invalid User Name or Password';
				$this->load->view('login',$data);
			}
		}
	}

	public function change() 
	{
		$data['result']=NULL;
		$this->load->view('change',$data);
	}

	public function oldpass_check($str,$user)
	{
		$oldPass=md5($user . $str);

    	$this->load->model('user_model');

    	$unique=$this->user_model->where(array('user_id' => $user, 'password' => $oldPass))->get();

		if (empty($unique)) {
			$this->form_validation->set_message('oldpass_check', 'Invalid old password.');
			return false;
		}
		else 
		{
			return true;
		}
	}

	public function saveChange($id) 
	{
		$user=$this->session->userdata('user_session')->user_id;
		//$oldPass=$this->input->post('old_password');
		//$oldPass2=md5($user . $oldPass);

		$pass=$this->input->post('password');
		$confPass=$this->input->post('confirm_password');
		$pass2=md5($user . $pass);


		$this->form_validation->reset_validation();
		$this->form_validation->set_rules('old_password', 'Old Password', 'required|callback_oldpass_check['.$user.']');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');

		if ($this->form_validation->run())
		{
			$this->load->model('user_model');
			$this->user_model->update(array('password' => $pass2,'updated_by' => $id),$id);
			$data['result']='<div id="alert" class="alert alert-success fade in alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a><strong>Edit success</strong></div>';
			$this->load->view('change',$data);
		}
		else
		{
			$data['result']=NULL;
			$this->load->view('change',$data);
		}
	}

	public function logout() 
	{
		$data['user']=$this->session->userdata('user_session');
		$this->session->sess_destroy();
		$data['session_desc']='';
		$this->load->model('user_model');
		if (!empty($data['user']))
		{
			$this->user_model->update(array('is_user_logged' => '0'),$data['user']->id);
		}
		$this->load->view('login',$data);
	}
}