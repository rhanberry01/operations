<?php
class Supplier_model extends CI_Model{

	public function __construct()
	{
		parent::__construct();
	}
	public function get_supplier_tax_type($supplier_id=null){
		$sql = "SELECT tax_group_id FROM `supplier_master` WHERE supplier_id = $supplier_id";
		$query = $this->db->query($sql);
		$row = $query->row();
		if ($row != null){
			return $row->tax_group_id;
		}else{
			return false;
		}
	}
	public function get_supplier_due_date($supplier_id, $this_date){
		$sql = "SELECT b.days_before_due 
					FROM `supplier_master` a
					JOIN `payment_terms` b ON a.payment_terms = b.payment_id
					WHERE a.supplier_id = $supplier_id";
		$query = $this->db->query($sql);
		$row = $query->row();
		$days = $row->days_before_due;
		
		return strtotime($this_date . " + ".$days." day");
	}
}
?>