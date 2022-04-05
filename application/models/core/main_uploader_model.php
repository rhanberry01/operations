<?php
class Main_uploader_model extends CI_Model{
	public function __construct(){
		parent::__construct();
		$this->mb = $this->load->database('central_db_default',true); //yung name ng main db sa database.php
	}
	
	public function check_all_customer_card_transaction_not_in(){
		$now = date('Y-m-d');
		$query = $this->db->query('SELECT card_no, cust_id FROM customer_cards WHERE inactive = 0 AND card_no NOT IN (SELECT card_no FROM customer_card_transactions  WHERE date(trans_datetime) BETWEEN "'. date('Y-m-d',(strtotime ('-1 year', strtotime($now)))). '" and "'.date('Y-m-d').'")');
		$res = $query->result();
		return $res;
	}
	public function update_inactive_customer_card_no($card_no){
		$sql = "UPDATE customer_cards SET inactive = 1 WHERE card_no =".$card_no;
		$query = $this->db->query($sql);
	}
	public function main_update_inactive_customer_card_no($card_no){
		$sql = "UPDATE customer_cards SET inactive = 1 WHERE card_no =".$card_no;
		$query = $this->mb->query($sql);
	}
	public function update_inactive_customer($cust_id){
		$sql = "UPDATE customer_master SET inactive = 1 WHERE cust_id =".$cust_id;
		$query = $this->db->query($sql);
	}
	public function main_update_inactive_customer($cust_id){
		$sql = "UPDATE customer_master SET inactive = 1 WHERE cust_id =".$cust_id;
		$query = $this->mb->query($sql);
	}
	public function get_all_sales_header(){
		$this->db->select('*');
		$this->db->from('sales_header');
		$query = $this->db->get();
		return $query;
	}
	public function add_to_main_sales_header($items){
		$this->mb->trans_begin();
		foreach ($items as $item) {
		   $insert_query = $this->mb->insert_string('sales_header', $item);
		   $insert_query = str_replace('INSERT INTO', 'INSERT IGNORE INTO', $insert_query);
		   $this->mb->query($insert_query);
		}
		if ($this->mb->trans_status() === FALSE){
			$this->mb->trans_rollback();
		}else{
			$this->mb->trans_commit();
		}
	}
	 public function get_all_sales_details(){
		$this->db->select('*');
		$this->db->from('sales_details');
		$query = $this->db->get();
		return $query;
	}
 	public function add_to_main_sales_details($items){
		//$this->mb->trans_begin();
		$this->mb->trans_start();
		foreach ($items as $item) {
		   $insert_query = $this->mb->insert_string('sales_details', $item);
		   $insert_query = str_replace('INSERT INTO', 'INSERT IGNORE INTO', $insert_query);
		   $this->mb->query($insert_query);
		}
		// if ($this->mb->trans_status() === FALSE){
			// $this->mb->trans_rollback();
		// }else{
			
			// $this->mb->trans_commit();
		// } 
		$this->mb->trans_complete();
	}

	public function get_all_payment(){
		$this->db->select('*');
		$this->db->from('sales_payments');
		$query = $this->db->get();
		return $query;
	}
	public function add_to_main_payment($items){
		$this->mb->trans_start();
		foreach ($items as $item) {
		   $insert_query = $this->mb->insert_string('sales_payments', $item);
		   $insert_query = str_replace('INSERT INTO', 'INSERT IGNORE INTO', $insert_query);
		   $this->mb->query($insert_query);
		}
		$this->mb->trans_complete();
	}
	public function get_all_payment_details(){
		$this->db->select('*');
		$this->db->from('sales_payment_details');
		$query = $this->db->get();
		return $query;
	}
	public function add_to_main_payment_details($items){
		$this->mb->trans_start();
		foreach ($items as $item) {
		   $insert_query = $this->mb->insert_string('sales_payment_details', $item);
		   $insert_query = str_replace('INSERT INTO', 'INSERT IGNORE INTO', $insert_query);
		   $this->mb->query($insert_query);
		}
		$this->mb->trans_complete();
	}
	public function get_all_customer_card_transaction(){
		$this->db->select('*');
		$this->db->from('customer_card_transactions');
		$query = $this->db->get();
		return $query;
	}
	public function add_to_main_customer_card_transaction($items){
		$this->mb->trans_start();
		foreach ($items as $item) {
		   $insert_query = $this->mb->insert_string('customer_card_transactions', $item);
		   $insert_query = str_replace('INSERT INTO', 'INSERT IGNORE INTO', $insert_query);
		   $this->mb->query($insert_query);
		}
		$this->mb->trans_complete();
	}   
}