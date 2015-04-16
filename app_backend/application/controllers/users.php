<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model("user");
		/*if ($this->session->userdata('user_id') == "") {
			$this->api->response(array("error"=>"Login", "message"=>"Please login"),400);
		}*/
		
	}
	
	public function index()
	{
		$this->load->view('users/index');
	}
	
	public function getAll() {
		
		$data = $this->user->getAll();
		$this->api->response($data,200);
	}
	
	public function get() {
		$id = $this->input->post('id');
		$data = array("id"=>$id);
		$result = $this->user->find($data);
		$this->api->response($result,200);
	}
	
	public function add() {
		
		$name = $this->input->post('name');
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$phone = $this->input->post('phone');
		
		$data = array(
			'name'=> $name,
			'email'=> $email,
			'password'=> $password,
			'status'=> 'active',
			'phone'=> $phone
		);
		
		$insert_id = $this->user->create($data);
		$data = array('id'=>$insert_id);
		$output = $this->user->find($data);
		
		$this->api->response($output,200);
	}
	
	public function delete() {
		$id = $this->input->post('id');
		$this->load->model("user");
		$this->user->deleteRow($id);
		$this->api->response("",200);
	}
}

/* End of file user.php */
/* Location: ./application/controllers/user.php */