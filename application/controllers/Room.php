<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Room extends CI_Controller {

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
			$this->load->model('room_model');
			$data['table'] = $this->room_model->get_all();
			$this->load->view('room',$data);
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
			$this->load->view('room_action',$data);
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
			$this->load->model('room_model');
			$data['content'] = $this->room_model->get($id);
			
			$this->load->view('room_action',$data);
		}
		else
		{
			$data['session_desc']='';
			$this->load->view('login',$data);
		}
	}

	public function roomid_check($str,$pre)
    {
    	$flag=explode('~', $pre)[0];
    	$id=explode('~', $pre)[1];
    	//echo $pre.'-'.$str;
    	$this->load->model('room_model');
    	$unique=$this->room_model->where('room_id',$str)->get();
    	
    	if ($flag == "Add") 
    	{
    		if (empty($unique)) {
    			return true;
    		}
    		else 
    		{
    			$this->form_validation->set_message('roomid_check', 'The {field} field not unique.');
    			return false;
    		}
    		
    	}
    	else //Edit
    	{
    		$before=strtolower($this->room_model->get($id)->room_id);
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
			else if ($str == strtolower($unique->room_id)) 
    		{
    			$this->form_validation->set_message('roomid_check', 'The {field} field not unique');
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
		$this->load->model('room_model');

		$id=$this->input->post('id');

		$room_id=$this->input->post('room_id');
		$room_name=$this->input->post('room_name');
		$room_type=$this->input->post('typeCbo');
		$amount=$this->input->post('amount');
		$amount_duration=$this->input->post('amount_duration');
		$amount_unit='Hour';
		$is_active=$this->input->post('activeCbo');

		$this->form_validation->reset_validation();
		$this->form_validation->set_rules('room_id', 'Room Id', 'required|callback_roomid_check['.$flag.'~'.$id.']');
		$this->form_validation->set_rules('room_name', 'Room Name', 'required');
		$this->form_validation->set_rules('amount', 'Cost', 'required|greater_than_equal_to[1]');
		$this->form_validation->set_rules('amount_duration', 'Duration', 'required|greater_than_equal_to[1]');

		if($flag == "Add")
		{
			if ($this->form_validation->run())
			{
				$this->room_model->insert(array('room_id' => $room_id,'room_name' => $room_name,'room_type' => $room_type,'is_active' => $is_active,'amount' => $amount,'amount_duration' => $amount_duration,'amount_unit' => $amount_unit,'created_by' => $this->session->userdata('user_session')->id));
				$data['result']='<div id="alert" class="alert alert-success fade in alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a><strong>Insert success</strong></div>';
				$this->setIndex($data);
			}
			else
			{
				$data['flag'] = "Add";
				$this->load->view('room_action',$data);
			}
		}
		else //update
		{
			if ($this->form_validation->run())
			{
				$this->room_model->update(array('room_id' => $room_id,'room_name' => $room_name,'room_type' => $room_type,'is_active' => $is_active,'amount' => $amount,'amount_duration' => $amount_duration,'amount_unit' => $amount_unit,'updated_by' => $this->session->userdata('user_session')->id),$id);
				$data['result']='<div id="alert" class="alert alert-success fade in alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a><strong>Edit success</strong></div>';
				$this->setIndex($data);
			}
			else
			{
				$data['flag'] = "Edit";
				$this->load->view('room_action',$data);
			}
		}
	}
}//end class