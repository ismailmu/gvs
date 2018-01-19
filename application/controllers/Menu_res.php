<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_res extends CI_Controller {

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
			$this->load->model('menu_res_model');
			$data['table'] = $this->menu_res_model->get_all();
			$this->load->view('menu_res',$data);
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
			$this->load->view('menu_res_action',$data);
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
			$this->load->model('menu_res_model');
			$data['content'] = $this->menu_res_model->get($id);
			
			$this->load->view('menu_res_action',$data);
		}
		else
		{
			$data['session_desc']='';
			$this->load->view('login',$data);
		}
	}

	public function menuname_check($str,$pre)
    {
    	$flag=explode('~', $pre)[0];
    	$id=explode('~', $pre)[1];

    	$this->load->model('menu_res_model');
    	$unique=$this->menu_res_model->where('menu_name',$str)->get();

    	if ($flag == "Add") 
    	{
    		if (empty($unique)) {
    			return true;
    		}
    		else 
    		{
    			$this->form_validation->set_message('menuname_check', 'The {field} field not unique.');
    			return false;
    		}
    	}
    	else //Edit
    	{
    		$before=strtolower($this->menu_res_model->get($id)->menu_name);
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
			else if ($str == strtolower($unique->menu_name)) 
			{
				$this->form_validation->set_message('menuname_check', 'The {field} field not unique');
				return false;
			}
			else
			{
				return true;
			}
    	}
    }

	public function save($flag)
	{
		$this->load->model('menu_res_model');

		$id=$this->input->post('id');

		$menu_name=$this->input->post('menu_name');
		$amount=$this->input->post('amount');
		$menu_type=$this->input->post('menu_type');
		$stock=$this->input->post('stock');
		$is_active=$this->input->post('activeCbo');

		$this->form_validation->reset_validation();
		$this->form_validation->set_rules('menu_name', 'Menu Name', 'required|callback_menuname_check['.$flag.'~'.$id.']');
		$this->form_validation->set_rules('menu_type', 'Menu Type', 'required');
		$this->form_validation->set_rules('stock', 'Stock', 'required|greater_than_equal_to[0]');
		$this->form_validation->set_rules('amount', 'Amount', 'required|greater_than_equal_to[0]');

		if($flag == "Add")
		{
			if ($this->form_validation->run())
			{
				$this->menu_res_model->insert(array('menu_name' => $menu_name,'is_active' => $is_active,'amount' => $amount,'menu_type' => $menu_type,'stock' => $stock,'created_by' => $this->session->userdata('user_session')->id));
				$data['result']='<div id="alert" class="alert alert-success fade in alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a><strong>Insert success</strong></div>';
				$this->setIndex($data);
			}
			else
			{
				$data['flag'] = "Add";
				$this->load->view('menu_res_action',$data);
			}
		}
		else //update
		{
			if ($this->form_validation->run())
			{
				$this->menu_res_model->update(array('menu_name' => $menu_name,'is_active' => $is_active,'amount' => $amount,'menu_type' => $menu_type,'stock' => $stock,'updated_by' => $this->session->userdata('user_session')->id),$id);
				$data['result']='<div id="alert" class="alert alert-success fade in alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a><strong>Edit success</strong></div>';
				$this->setIndex($data);
			}
			else
			{
				$data['flag'] = "Edit";
				$this->load->view('menu_res_action',$data);
			}
		}
	}
}//end class