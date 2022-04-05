<?php
class Mail_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

	public function email_configuration(){
		$this->db->select('email_config.*');
		$this->db->from('email_config');
		$query = $this->db->get();
		// echo $this->db->last_query();
		return $query->result();
	}
	
}