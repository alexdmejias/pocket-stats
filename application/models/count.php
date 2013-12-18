<?php

class Count extends CI_Model {
	var $count = '';
	var $date = '' ;

	function __construct() {
		parent::__construct();
	}

	function get_counts($q = 10) {
		$query = $this->db->get('counts', $q);
		return $query->result();
	}

	function get_last_ten_counts() {
		return $this->get_counts(10);
	}

	function insert_entry($count) {
		$this->count = $count;
		$this->date =  date("Y-m-d H:i:s");

		$this->db->insert('counts', $this);

	}


}