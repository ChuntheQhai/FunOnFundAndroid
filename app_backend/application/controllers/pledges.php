<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pledges extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model("pledge");
		/*if ($this->session->userdata('user_id') == "") {
			$this->api->response(array("error"=>"Login", "message"=>"Please login"),400);
		}*/
		
	}
	
	public function index()
	{
		$this->load->view('pledges/index');
	}
	
	public function getAll() {
		
		$data = $this->pledge->getAll();
		$this->api->response($data,200);
	}
	
	public function get() {
		$id = $this->input->post('id');
		$data = array("id"=>$id);
		$result = $this->pledge->find($data);
		$this->api->response($result,200);
	}
	
	public function add() {
		
		$userId = $this->input->post('userId');
		$campaignId = $this->input->post('campaignId');
		$amount = $this->input->post('amount');
		$pledge = $this->input->post('pledge');

		$this->load->model("campaign");
		$findQuery = array("id"=>$campaignId);
		$currentCampaign = $this->campaign->find($findQuery);

		if ($pledge == 1)
		{
			$upPledgeCount = $currentCampaign['pledge_count'] + 1;
		}

		$upAmountFunded = $currentCampaign['amount_funded'] + $amount;

		$updateData = array(
			'pledge_count'=>$upPledgeCount,
			'amount_funded'=>$upAmountFunded
		);

		$this->campaign->update($campaignId, null, $updateData);
		
		$data = array(
			'user_id'=> $userId,
			'campaign_id'=> $campaignId,
			'amount'=> $amount,
			'pledge'=> $pledge,
		);

		$insert_id = $this->pledge->create($data);
		$data = array('id'=>$insert_id);
		$output = $this->pledge->find($data);
		
		$this->api->response($output,200);
	}
	
	public function delete() {
		$id = $this->input->post('id');
		$this->load->model("pledge");
		$this->pledge->deleteRow($id);
		$this->api->response("",200);
	}
}

/* End of file pledge.php */
/* Location: ./application/controllers/pledge.php */