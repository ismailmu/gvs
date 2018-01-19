<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Therapist extends CI_Controller {

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
			$this->load->model('therapist_model');
			$this->load->model('user_model');
			$data['table'] = $this->therapist_model->getTherapist();
			$data['userData'] = $this->user_model->getUserNotAdmin();
			$this->load->view('therapist',$data);
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
			$this->load->model('user_model');
			$data['userData'] = $this->user_model->getUserNotAdmin();
			$data['content'] = NULL;
			$this->load->view('therapist_action',$data);
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
			$this->load->model('therapist_model');
			$data['content'] = $this->therapist_model->get($id);
			
			$this->load->model('user_model');
			$data['userData'] = $this->user_model->getUserNotAdmin();
			
			$this->load->view('therapist_action',$data);
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

    	$this->load->model('therapist_model');
		$unique=$this->therapist_model->where('id_user',$str)->get();
		//echo $str.'-'.$id;
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
				$before=$this->therapist_model->get($id)->id_user;
    			//echo $before.'-'.$str.'-'.$unique->id_user;
    			//$str=strtolower($str);

    			if ($str == $before)
    			{
    				return true;
    			}
    			else if (empty($unique)) 
				{
					return true;
				}
    			else if ($str == $unique->id)
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
		$this->load->model('therapist_model');

		$id=$this->input->post('id');
		$amount=$this->input->post('amount');
		$amount_duration=$this->input->post('amount_duration');
		$amount_unit='Hour';
		$therapistCbo=$this->input->post('therapistCbo');
		$is_active=$this->input->post('activeCbo');

		$this->form_validation->reset_validation();
		$this->form_validation->set_rules('therapistCbo', 'Therapist', 'required|callback_userid_check['.$flag.'~'.$id.']');
		$this->form_validation->set_rules('amount', 'Cost', 'required');
		$this->form_validation->set_rules('amount', 'Cost', 'required|greater_than_equal_to[1]');
		$this->form_validation->set_rules('amount_duration', 'Duration', 'required|greater_than_equal_to[1]');

		if($flag == "Add")
		{
			if ($this->form_validation->run())
			{
				$this->therapist_model->insert(array('id_user' => $therapistCbo,'is_active' => $is_active,'amount' => $amount,'amount_duration' => $amount_duration,'amount_unit' => $amount_unit,'created_by' => $this->session->userdata('user_session')->id));
				$data['result']='<div id="alert" class="alert alert-success fade in alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a><strong>Insert success</strong></div>';
				$this->setIndex($data);
			}
			else
			{
				$this->load->model('user_model');
				$data['userData'] = $this->user_model->getUserNotAdmin();
				$data['flag'] = "Add";
				$this->load->view('therapist_action',$data);
			}
		}
		else //update
		{
			if ($this->form_validation->run())
			{
				$this->therapist_model->update(array('id_user' => $therapistCbo,'is_active' => $is_active,'amount' => $amount,'amount_duration' => $amount_duration,'amount_unit' => $amount_unit,'updated_by' => $this->session->userdata('user_session')->id),$id);
				$data['result']='<div id="alert" class="alert alert-success fade in alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a><strong>Edit success</strong></div>';
				$this->setIndex($data);
			}
			else
			{
				$this->load->model('user_model');
				$data['userData'] = $this->user_model->getUserNotAdmin();
				$data['flag'] = "Edit";
				$this->load->view('therapist_action',$data);
			}
		}
	}
}//end class