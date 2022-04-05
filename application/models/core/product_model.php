<?php
class Product_model extends CI_Model{

	public function __construct()
	{
		parent::__construct();
	}
	
	//Get listing of products - active record
	public function get_products($id=null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('product_master');
			if($id != null)
				$this->db->where('product_id',$id);
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	//Insert to DB
	public function add_product($items)
	{
		// $this->db->set('reg_date','NOW()',FALSE);
		$this->db->insert('product_master',$items);
		return $this->db->insert_id();
	}
	//Update DB
	public function update_product($items,$id){
		// $this->db->where('code', $id);
		$this->db->where('product_id', $id);
		$this->db->update('product_master', $items);
	}
	
	//validate product code
	public function product_code_exist_add_mode($product_code=null){
		$sql = "SELECT * FROM product_master WHERE product_code = '$product_code'";
		$query = mysql_query($sql);
		if(mysql_num_rows($query) == 0)
			return false;
		return true;
	}
	public function product_code_exist_edit_mode($product_code=null, $product_id=null){
		$sql = "SELECT * FROM product_master WHERE product_code = '$product_code' AND product_id != $product_id";
		$query = mysql_query($sql);
		if(mysql_num_rows($query) == 0)
			return false;
		return true;
	}
}
?>