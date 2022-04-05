<?php
class Setup_model extends CI_Model{

	public function __construct()
	{
		parent::__construct();
	}
	// public function get_branch_details(){
	// 	$this->db->trans_start();
	// 		$this->db->select('*');
	// 		$this->db->from('branch_details');
	// 		$this->db->where('branch_details.branch_code',BRANCH_CODE);
	// 		$query = $this->db->get();
	// 		$result = $query->result();
	// 	$this->db->trans_complete();
	// 	return $result;
	// }
	//-----------Categories-----start-----allyn
	public function get_details($id=null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('company_setup');
			$this->db->where('company_setup.company_id',$id);
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	public function update_details($items,$id){
		// $this->db->where('code', $id);
		$this->db->where('company_id', $id);
		$this->db->update('company_setup', $items);
	}
	//-----------Categories-----end-----allyn
}
?>