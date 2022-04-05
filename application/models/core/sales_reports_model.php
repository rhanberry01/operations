<?php
class Sales_reports_model extends CI_Model{
	public function __construct(){
		parent::__construct();
	}
	public function get_branch_details($id=null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('branches');
			if($id != null)
				$this->db->where('id',$id);
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
}