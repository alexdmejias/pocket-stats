<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Counts extends CI_Controller {

	/* MOVE */
	public function getcounts($q = 10) {
		$this->load->model('Count');
		echo json_encode($this->Count->get_counts($q));
	}

	/* MOVE */
	public function insert() {
		$count = $this->_get_total_count();
		$this->load->model('Count');
		$this->Count->insert_entry($count);
	}

	/* MOVE */
	public function delete($id) {
		$this->load->model('Count');
		$this->Count->remove_entry($id);
	}

	public function index() {
		$this->load->view('welcome_message');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */