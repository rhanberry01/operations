<?php
class Cashier_model extends CI_Model{

	public function __construct(){
		parent::__construct();
	}
	
	//Get listing of products - active record	
	public function get_items($id=null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('salesline');
			//if($id != null)
			//	$this->db->where('id');
			$this->db->order_by('id DESC');
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	public function get_payment_types(){
		
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('payment_types');		
			$this->db->where('inactive',0);
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	
	public function get_payment_types_details($name=null){
		$sql = "SELECT * FROM payment_types WHERE ";
		if($name != null)
			$sql .=" name = '".$name."' AND";		
		$sql .=" inactive = 0";		
		
		$query = mysql_query($sql);
		if(mysql_num_rows($query) == 0)
			return false;
						
		return $query;
	}
	
	public function check_password($username=null,$password=null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('users');
			$this->db->where('username',$username);
			$this->db->where('password',md5($password));
			$query  = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	public function get_stock($id=null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('stock_master');
			$this->db->where('barcode',$id);
			$query  = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	
	//validate product code
	public function check_product($product_code=null){		
		$sql = "SELECT * FROM stock_barcodes_new WHERE barcode = '".$product_code."' AND inactive = 0";
		$query = mysql_query($sql);
		if(mysql_num_rows($query) == 0)
			return false;			
		return $query;
	}
	
	public function get_item_price($product_code=null, $sales_type_id=null){	
		$sql = "SELECT price FROM stock_barcode_prices WHERE barcode = '$product_code' AND sales_type_id = '$sales_type_id'";
		$query = mysql_query($sql);
		$row = mysql_fetch_row($query);
		if(mysql_num_rows($query) == 0)
			return false;	
		return $row[0];	
	}
	public function price_inq_on_db($product_code=null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('stock_barcodes_new');
			//$this->db->like('barcode', $product_code, 'both');  para sa look up
			$this->db->where('barcode',$product_code);
			$this->db->where('inactive',0);
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;		
		/*$sql = "SELECT * FROM stock_barcodes_new WHERE barcode LIKE '%$product_code%'";
		$query = mysql_query($sql);
		if(mysql_num_rows($query) == 0)
			return false;	
					
		return $query;
		*/
	}
	public function look_up_on_db($description=null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('stock_barcodes_new');
			$this->db->like('description', $description, 'both');  //para sa look up
			$this->db->where('inactive',0);
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;		
		
	}
	public function void_scanned($id=null){
		$sql = "DELETE FROM salesline";
		if($id != null)
			$sql .= " WHERE id=$id";	
					
		mysql_query($sql);
		return TRUE;
	}
	public function get_discount(){		
		$sql = "SELECT disc_code FROM discounts WHERE status = 1";
		$query = mysql_query($sql);
		$row = mysql_fetch_object($query);
		if(mysql_num_rows($query) == 0)
			return 'ND';	
								
		return $row->disc_code;
		/*$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('stock_master');
			$this->db->where('id',$product_code);			
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;		
		*/
	}
	
	//Insert to DB
	public function add_item($items)
	{
		// $this->db->set('reg_date','NOW()',FALSE);		
		 $this->db->insert('salesline',$items);
		 return $this->db->insert_id();
	}
	//Update Discount table
	public function update_discount($pwd,$sc){
		
		$sql = "UPDATE `discounts`
			   SET status = $pwd WHERE id = 1";
		mysql_query($sql); // PWD status
		
		$sql = "UPDATE `discounts`
			   SET status = $sc WHERE id = 2";
		mysql_query($sql); // Senior Citizen status
		
		// $this->db->where('code', $id);
		//$this->db->where('product_id', $id);
		//$this->db->update('product_master', $items);
	}
		
	/*
	//Update DB
	public function update_product($items,$id){
		// $this->db->where('code', $id);
		$this->db->where('product_id', $id);
		$this->db->update('product_master', $items);
	}
		
	public function product_code_exist_edit_mode($product_code=null, $product_id=null){
		$sql = "SELECT * FROM product_master WHERE product_code = '$product_code' AND product_id != $product_id";
		$query = mysql_query($sql);
		if(mysql_num_rows($query) == 0)
			return false;
		return true;
	}
	*/
}
?>