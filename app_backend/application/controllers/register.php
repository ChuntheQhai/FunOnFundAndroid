<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Register extends CI_Controller {

	public function index()
	{
		if ($this->session->userdata('user_id') != "") {
			redirect('dashboard/index');
		} else {
			$this->load->view('register');
		}
	}
	
	public function post() {
		
		$name = $_REQUEST['name'];
		$email = $_REQUEST['email'];
		$password = $_REQUEST['password'];
		$phone = $_REQUEST['phone'];
		
		$this->load->model("user");
		if ($this->user->checkValueExist('email', $email)) {
			$this->api->response(array("error"=>"Email Exists", "message"=>"Please try another one"),400);
			exit();
		}
		$data = array(
			'name'=> $name,
			'email'=> $email,
			'password'=> $password,
			'phone'=> $phone,
			'status'=> 'active',
		);
		$this->user->create($data);
		$this->api->response(array("message"=>base_url('index')),200);
	}
}

/* End of file register.php */
/* Location: ./application/controllers/register.php */