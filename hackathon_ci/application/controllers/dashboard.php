<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function index()
	{
		$this->load->view('dashboard/index');
	}
}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */