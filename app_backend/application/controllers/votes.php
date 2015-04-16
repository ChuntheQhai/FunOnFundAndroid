<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Votes extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model("vote");
		/*if ($this->session->userdata('user_id') == "") {
			$this->api->response(array("error"=>"Login", "message"=>"Please login"),400);
		}*/
		
	}
	
	public function index()
	{
		$this->load->view('votes/index');
	}
	
	public function getAll() {
		
		$data = $this->vote->getAll();
		$this->api->response($data,200);
	}
	
	public function get() {
		$id = $this->input->post('id');
		$data = array("id"=>$id);
		$result = $this->vote->find($data);
		$this->api->response($result,200);
	}
	
	public function add() {
		
		$campaignId = $this->input->post('campaignId');
		$userId = $this->input->post('userId');
		$vote = $this->input->post('vote');

		$this->load->model("campaign");
		$findQuery = array("id"=>$campaignId);
		$currentCampaign = $this->campaign->find($findQuery);

		if ($vote == 1)
		{
			$upVoteCount = $currentCampaign['up_vote_count'] + 1;
			$updateData = array("up_vote_count"=>$upVoteCount);
		}
		else if ($vote == 0)
		{
			$downVoteCount = $currentCampaign['down_vote_count'] + 1;
			$updateData = array("down_vote_count"=>$downVoteCount);
		}
		
		$this->campaign->update($campaignId, null, $updateData);

		$data = array(
			'campaign_id'=> $campaignId,
			'user_id'=> $userId,
			'vote'=> $vote,
		);

		$insert_id = $this->vote->create($data);
		$data = array('id'=>$insert_id);
		$output = $this->vote->find($data);
		
		$this->api->response($output,200);
	}
	
	public function delete() {
		$id = $this->input->post('id');
		$this->load->model("vote");
		$this->vote->deleteRow($id);
		$this->api->response("",200);
	}
}

/* End of file vote.php */
/* Location: ./application/controllers/vote.php */