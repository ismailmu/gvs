<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Card extends CI_Controller {

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
			$this->load->view('topup',$data);
		}
		else
		{
			$data['session_desc']='';
			$this->load->view('login',$data);
		}
	}

	public function cardShow()
	{
		$card_id=$this->input->post('card_id');
		$data['result']=NULL;
		$data['show']=TRUE;
		$data['card_id']=$card_id;

		$this->load->model('card_model');
		$data['content']=$this->card_model->where('card_id',$card_id)->get();

		$this->load->view('topup',$data);
	}

	public function save()
	{
		$this->load->model('card_model');

		$card_id=$this->input->post('card_id');
		$card_name=$this->input->post('card_name');
		$amount=str_replace(',', '', $this->input->post('amount') );
		$balance=str_replace(',', '', $this->input->post('balance') );
		
		$this->form_validation->reset_validation();
		$this->form_validation->set_rules('card_name', 'Name', 'required');
		$this->form_validation->set_rules('amount', 'Top Up', 'required|greater_than_equal_to[1]');
		//$this->form_validation->set_rules('balance', 'Balance', 'required|greater_than_equal_to[0]');

		if ($this->form_validation->run())
		{
			$this->load->model('card_model');
			$row=$this->card_model->where('card_id',$card_id)->get();

			if (empty($row)) //Insert
			{
				$card_suffix=substr($card_id, -3);
				
				$this->card_model->insert(array('card_id' => $card_id,'card_name' => $card_name,'balance' => $amount,'last_topup_at' => date("Y-m-d H:i:s"),'card_id_suffix' => $card_suffix,'is_active' => 1,'created_by' => $this->session->userdata('user_session')->id));
			}
			else //Edit
			{
				$id=$row->id;
				$this->card_model->update(array('card_name' => $card_name,'balance' => $amount + $balance,'last_topup_at' => date('Y-m-d H:i:s'),'is_active' => 1,'updated_by' => $this->session->userdata('user_session')->id),$id);
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