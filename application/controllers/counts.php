<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Counts extends CI_Controller {

	// get q number of records
	public function getcounts($q = 10, $offset = 0) {
		$this->load->model('Count');
		echo json_encode($this->Count->get_counts($q, $offset));
	}

	// get every N entry from the db
	public function getEvery($e = 12) {
		$this->load->model('Count');
		echo json_encode($this->Count->get_every($e));
	}

	// will attempt to insert a record into the database
	// will only insert at the beginning of every hour
	// or if the current count is different than that last count
	public function insert() {
		$this->load->model('Count');

		$current_count = file_get_contents(base_url('/pocket/getTotalCount/1'));

		// var_dump($current_count);
		$latest_count = $this->Count->get_latest();
		$latest_count = $latest_count[0]->count;

		$date = date('i');

		if(($date == 00) || ($current_count != $latest_count)){
			$this->Count->insert_entry($current_count);
			echo 'inserted';
		} else {
			echo 'nothing to insert';
		}

	}

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