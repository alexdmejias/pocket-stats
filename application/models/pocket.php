<?php

class Pocket extends CI_Model {
	var $count = '';
	var $date = '' ;

	function __construct() {
		parent::__construct();
	}

	function select_first() {
		$query = $this->db->get('pockets', 1);
		return $query->result();
	}

	function insert_entry($count) {
		$this->count = $count;
		$this->date = date("Y-m-d H:i:s");

		$this->db->insert('pockets', $this);
	}

	// will update the first entry
	function update($count) {
		$this->count = $count;
		$this->date = date("Y-m-d H:i:s");

		$this->db->update('pockets', $this, array('id' => 1));
	}

}