<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Campaigns extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model("campaign");
		/*if ($this->session->userdata('user_id') == "") {
			$this->api->response(array("error"=>"Login", "message"=>"Please login"),400);
		}*/
		
	}
	
	public function index()
	{
		$this->load->view('campaigns/index');
	}
	
	public function getAll() {
		$id = $this->input->post('userId');

		$this->load->model("vote");
		$this->load->model("pledge");

		$findQuery = array("user_id"=>$id);

		$data = $this->campaign->getAll();

		$userVote = null;
		$userPledge = null;

		try
		{
			$userVote = $this->vote->find($findQuery);

		}
		catch(Exception $e) {}

		try
		{
			$userPledge = $this->pledge->find($findQuery);

		}
		catch(Exception $e) {}

		$data[0]["vote"] = $userVote['vote'];
		$data[0]["pledge"] = $userPledge['pledge'];
		$data[0]["pledgeAmount"] = $userPledge['amount'];

		$this->api->response($data,200);
	}
	
	public function get() {
		$id = $this->input->post('id');
		$data = array("id"=>$id);
		$result = $this->campaign->find($data);
		$this->api->response($result,200);
	}
	
	public function add() {
		
		$userId = $this->input->post('userId');
		$name = $this->input->post('name');
		$textDescription = $this->input->post('textDescription');
		$audioFilePath = 'google.com';
		$amountNeeded = $this->input->post('amountNeeded');
		$startDate = date('Y/m/d H:i:s');
		$endDate = date('Y/m/d H:i:s');
		$status = 'awaiting_approval';
		$additionalInformation = '-';
		$upVoteCount = 0;
		$downVoteCount = 0;
		$pledgeCount = 0;
		$amountFunded = 0;
		
		$data = array(
			'user_id'=> $userId,
			'name'=> $name,
			'text_description'=> $textDescription,
			'audio_file_path'=> $audioFilePath,
			'amount_needed'=> $amountNeeded,
			'start_date'=> $startDate,
			'end_date'=> $endDate,
			'status'=> $status,
			'additional_information'=> $additionalInformation,
			'up_vote_count'=> $upVoteCount,
			'down_vote_count'=> $downVoteCount,
			'pledge_count'=> $pledgeCount,
			'amount_funded'=> $amountFunded
		);

		$insert_id = $this->campaign->create($data);
		$data = array('id'=>$insert_id);
		$output = $this->campaign->find($data);
		
		$this->api->response($output,200);
	}
	
	public function delete() {
		$id = $this->input->post('id');
		$this->load->model("campaign");
		$this->campaign->deleteRow($id);
		$this->api->response("",200);
	}
}

/* End of file campaign.php */
/* Location: ./application/controllers/campaign.php */