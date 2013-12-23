<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Counts extends CI_Controller {

	// get q number of records
	public function getcounts($q = 10, $latest = false) {
		$this->load->model('Count');
		echo json_encode($this->Count->get_counts($q, $latest));
	}

	/*will get the latest entry record */
	public function getLatest($q=1) {
		$this->load->model('Count');
		echo json_encode($this->Count->get_counts($q, 'latest'));
	}

	// will attempt to insert a record into the database
	// will only insert at the beginning of every hour
	// or if the current count is different than that last count
	public function insert() {
		$this->load->model('Count');
		$this->load->model('Pocket');

		$pocket_total = $this->Pocket->select_first();
		$pocket_total = $pocket_total[0]->count;

		echo '$pocket_total:' . $pocket_total;
		echo '<br>';

		$latest_count = $this->Count->get_counts(1, 'latest');
		$latest_count = $latest_count[0]->count;
		echo '$latest_count: ' . $latest_count;
		echo '<br>';


		$date = date('i');

		if(($date == 00) || ($pocket_total != $latest_count)){
			$this->Count->insert_entry($pocket_total);
			echo "inserted: $pocket_total";
		} else {
			echo 'nothing to insert<br>';
		}

	}

/*	public function delete($id) {
		$this->load->model('Count');
		$this->Count->remove_entry($id);
	}*/

	public function index() {
		$this->load->view('welcome_message');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */