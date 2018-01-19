<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TService extends CI_Controller {

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
		$data['card_id']='';
		$this->setIndex($data);
	}

	private function setIndex($data) 
	{
		if($this->session->userdata('user_session'))
		{
			$this->load->view('tservice',$data);
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
			$this->load->model('tservice_model');
			$data['content']=NULL;
			$data['empty_card']=NULL;
			$this->load->view('tservice_action',$data);
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

	public function serviceShow()
	{
		$card_id=$this->input->post('card_id');
		$data['result']=NULL;
		$data['card_id']=$card_id;

		$this->load->model('card_model');
		$data['cardData']=$this->card_model->where('card_id',$card_id)->get();

		if (empty($data['cardData']))
		{
			$data['content']=NULL;
			$data['empty_card']='<span class="error-label">Card not register, top up first</span>';
		}
		else
		{
			$data['empty_card']='';
			$this->load->model('tservice_model');
			$data['content']=$this->tservice_model->where('id_card',$data['cardData']->id)->get();

			$this->load->model('therapist_model');
			$data['therapistData']=$this->therapist_model->where('id_user',$this->session->userdata('user_session')->id)->get();
		}

		$this->load->view('tservice_action',$data);
	}

	public function save()
	{
		$this->load->model('tservice_model');

		$card_id=$this->input->post('card_id');
		$total=$this->input->post('total');
		$duration=$this->input->post('duration');
		
		$this->form_validation->reset_validation();
		$this->form_validation->set_rules('duration', 'Duration', 'required|greater_than_equal_to[1]');

		if ($this->form_validation->run())
		{
			$this->load->model('tservice_model');
			$this->load->model('card_model');
			$row=$this->card_model->where('card_id',$card_id)->get();

			if (empty($row)) //Insert
			{
				$this->tservice_model->insert(array('id_card' => $id_card,'duration' => $duration,'total' => $total,'transaction_at' => date("Y-m-d H:i:s"),'created_by' => $this->session->userdata('user_session')->id));
			}
			else //Edit
			{
				$id=$row->id;
				$this->tservice_model->update(array('duration' => $duration,'total' => $total,'updated_by' => $this->session->userdata('user_session')->id),$id);
			}

			$data['result']='<div id="alert" class="alert alert-success fade in alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a><strong>Save success</strong></div>';

			$data['card_id']=NULL;
			$data['show']=NULL;
			$this->setIndex($data);
		}
		else
		{
			$data['card_id']=$card_id;
			$this->cardShow();
		}
	}
}//end class