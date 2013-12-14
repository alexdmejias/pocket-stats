<?php

class Count extends CI_Model {
	var $count = '';
	var $date = '' ;

	function __construct() {
		parent::__construct();
	}

	function get_last_ten_entries() {
		$query = $this->db->get('counts', 10);
	}

	function insert_entry($count) {
		$this->count = $count;
		$this->date =  date('U');

		$this->db->insert('counts', $this);

	}


}