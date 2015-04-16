<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index()
	{
		if ($this->session->userdata('user_id') != "") {
			redirect('dashboard/index');
		} else {
			$this->load->view('login');
		}
	}
	
	public function forgot()
	{
		$this->load->view('forgot');
	}
	
	public function post() {
		
		$email = $_REQUEST['email'];
		$password = $_REQUEST['password'];
		
		$this->load->model("user");
		if (!$this->user->checkValueExist('email', $email)) {
			$this->api->response(array("error"=>"Invalid Email/Password", "message"=>"Please try again"),400);
			exit();
		}
		
		$data = array(
			'email'=> $email,
		);
		$user = $this->user->find($data);
		
		if ($user['status'] != "active") {
			$this->api->response(array("error"=>"Account Suspended", "message"=>"Please contact admin"),400);
			exit();
		}
		
		if ($user['password'] != $password) {
			$this->api->response(array("error"=>"Invalid Email/Password", "message"=>"Please try again"),400);
			exit();
		}
		
		$sessioData = array(
			'user_id'  => $user['id'],
		);
		$this->session->set_userdata($sessioData);
		$this->api->response(array("message"=>base_url('dashboard')),200);
	}
	
	public function forgot_post() {
		$email = $_REQUEST['email'];
		$this->load->model("user");
		if (!$this->user->checkValueExist('email', $email)) {
			$this->api->response(array("error"=>"Error", "message"=>"No such email address found"),400);
			exit();
		}
		$this->api->response(array("success"=>1),200);
	}
	
	public function logout()
	{
		if ($this->session->userdata('user_id') != "") {
			$sessioData = array(
				'user_id'  => ""
			);
			$this->session->set_userdata($sessioData);
			redirect('login');
		} else {
			$this->load->view('login');
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */