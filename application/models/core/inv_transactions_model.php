<?php
class Inv_transactions_model extends CI_Model{
	public function __construct(){
		parent::__construct();
	}
	public function get_uom_qty($unit_code=null){
		$sql = "SELECT qty FROM stock_uoms WHERE unit_code = '$unit_code' ";
		// echo $sql."<br>";
		$query = $this->db->query($sql);
		$row = $query->row();
		if ($row != null)
			return $row->qty;
		else
			return false;
	}
	public function get_movement_details($id=null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('movement_details');
			if($id != null)
				$this->db->where('line_id',$id);
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	public function get_movement_details_temp($id=null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('movement_details_temp');
			if($id != null)
				$this->db->where('header_id',$id);
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	public function get_partial_movement_details_temp($id=null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('movement_details_temp');
			if($id != null)
				$this->db->where('header_id',$id);
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	public function get_stock_id_from_barcode($barcode=null){
			$sql = "SELECT stock_id FROM stock_barcodes_new WHERE barcode = '$barcode'";
			$query = $this->db->query($sql);
			$row = $query->row();
			// echo $sql."<br>";
			if ($row != null)
				return $row->stock_id;
			else
				return false;
	}
	public function get_barcode_desc_from_barcode($barcode=null){
			$sql = "SELECT description FROM stock_barcodes_new WHERE barcode = '$barcode'";
			$query = $this->db->query($sql);
			$row = $query->row();
			// echo $sql."<br>";
			if ($row != null)
				return $row->description;
			else
				return false;
	}
	public function get_barcode_uom_from_barcode($barcode=null){
			$sql = "SELECT uom FROM stock_barcodes_new WHERE barcode = '$barcode'";
			$query = $this->db->query($sql);
			$row = $query->row();
			// echo $sql."<br>";
			if ($row != null)
				return $row->uom;
			else
				return false;
	}
	public function get_branch_stock_cost_of_sales($stock_id=null, $branch_id=null){
			$sql = "SELECT cost_of_sales FROM stock_cost_of_sales WHERE stock_id = '$stock_id' AND branch_id = $branch_id";
			$query = $this->db->query($sql);
			$row = $query->row();
			// echo $sql."<br>";
			if ($row != null)
				return $row->cost_of_sales;
			else
				return false;
	}
	public function get_movement_type_next_id($type_id=null){
			$sql = "SELECT next_id FROM movement_types WHERE movement_type_id = $type_id";
			$query = $this->db->query($sql);
			$row = $query->row();
			echo $sql."<br>";
			if ($row != null)
				return $row->next_id;
			else
				return false;
	}
	public function validate_barcode($barcode=null){
		$sql = "SELECT * FROM stock_barcodes_new WHERE barcode = '$barcode'";
		$query = mysql_query($sql);
		if(mysql_num_rows($query) == 0)
			return false;
		return true;
	}
	public function validate_movement_id($movement_id=null, $type_id=null){
		$sql = "SELECT * FROM movements WHERE movement_id = $movement_id AND movement_type_id = $type_id";
		$query = mysql_query($sql);
		if(mysql_num_rows($query) == 0)
			return false;
		return true;
	}
	public function write_to_movement_details_temp($items)
	{
		$this->db->insert('movement_details_temp',$items);
		$id = $this->db->insert_id();
		return $id;
	}
	public function write_to_movements($items)
	{
		$this->db->insert('movements',$items);
		$id = $this->db->insert_id();
		return $id;
	}
	public function write_to_movement_details($items)
	{
		$this->db->insert('movement_details',$items);
		$id = $this->db->insert_id();
		return $id;
	}
	public function update_movement_type_next_id($type_id=null, $items=array()){
		$this->db->where('movement_type_id', $type_id);
		$this->db->update('movement_types', $items);
		return $this->db->last_query();
	}
	public function delete_from_movement_details_temp($id=null){
		$this->db->where('header_id', $id);
		$this->db->delete('movement_details_temp');
	}
	public function delete_movement_details_temp_line_item($id=null){
		$this->db->where('line_id', $id);
		$this->db->delete('movement_details_temp');
	}
	public function get_branch_code($id=null){
		$sql = "SELECT code FROM branches WHERE id='".$id."'";
		$query = mysql_query($sql);
		$result = mysql_fetch_object($query); 
		return $result->code;
	}
	public function user_name($person_id=null){
		$sql = " SELECT CONCAT(fname, ' ', mname, ' ', lname, ' ', suffix) AS person FROM `users` WHERE id=".$person_id;
		$query = $this->db->query($sql);
		$result = $query->result();
		$res = $result[0];
		return $res->person;
	}
		//-----AUDIT TRAIL-----APM-----START
	public function write_to_audit_trail($items=array())
	{
		$this->db->insert('audit_trail',$items);
		$id = $this->db->insert_id();
		return $id;
	}
	//-----AUDIT TRAIL-----APM-----END
}

?>