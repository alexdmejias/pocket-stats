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

	function remove_entry($id) {
		$this->db->delete('counts', array('id' => $id));
	}

	function insert_entry($count) {
		$this->count = $count;
		$this->date =  date("Y-m-d H:i:s");

		$this->db->insert('counts', $this);

	}


}