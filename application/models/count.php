<?php

class Count extends CI_Model {
	var $count = '';
	var $date = '' ;

	function __construct() {
		parent::__construct();
	}

	function get_counts($q = 10, $latest = false) {
		if($latest == true) {
			$this->db->order_by('id', 'desc');
		}

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

	function get_every($e) {
		$query = $this->db->query('SELECT *
			FROM (
				SELECT
					@row := @row +1 AS rownum, count, date
				FROM (
					SELECT @row :=0) r, counts
				) ranked
			WHERE rownum %'.$e.' =1 ');
		return $query->result();
	}
}