<?php
class Po_inquiries_model extends CI_Model{
	public function __construct(){
		parent::__construct();
	}
	public function get_user_name($id=null){
		$sql = "SELECT fname,mname,lname,suffix FROM users WHERE id=".$id;
		$query = mysql_query($sql);
		$result = mysql_fetch_object($query); 
		return $result->fname.' '.$result->mname.' '.$result->lname.' '.$result->suffix;
	}
	//Purchase Order Approval - Mhae
	public function get_purchase_orders_approval($id=null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('purch_orders');
		//	$this->db->join('purch_order_details', 'purch_orders.order_no = purch_order_details.order_no');
			if($id != null)
				$this->db->where('order_no',$id);
			//$this->db->where('status = 1');
			$this->db->order_by('date_created DESC');
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	public function reject_added_purchase_orders($items, $id){
		$this->db->where('order_no', $id);
		$this->db->update('purch_orders', $items);
		return 'success';
	}	
		//-----AUDIT TRAIL-----APM-----START
	public function write_to_audit_trail($items=array())
	{
		$this->db->insert('audit_trail',$items);
		$id = $this->db->insert_id();
		return $id;
	}
	//-----AUDIT TRAIL-----APM-----END
	//Purchase Order Approval - Mhae
	public function get_branch_code($id=null){
		$sql = "SELECT code FROM branches WHERE id=".$id;
		$query = mysql_query($sql);
		$result = mysql_fetch_object($query); 
		return $result->code;
	}
}