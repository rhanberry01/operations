<?php
class Po_model extends CI_Model{
	public function __construct(){
		parent::__construct();
	}
	
	public function get_branch_stocks($stock_id=null,$branch_id=null,$supp_id = null){
		
		if($branch_id == 'ALL'){
				$this->db->select('
						stock_master_new.stock_code,
						stock_master_new.description,
						supplier_stocks.supp_stock_code,
						supplier_stocks.description,
						branch_stocks.branch_id,
						branch_stocks.qty,
						branch_stocks.stock_loc_id,
						stock_cost_of_sales.cost_of_sales');
				$this->db->from('stock_master_new');
				$this->db->join('supplier_stocks','stock_master_new.stock_id = supplier_stocks.stock_id','inner');
				$this->db->join('branch_stocks','supplier_stocks.branch_id = branch_stocks.branch_id','inner');	
				$this->db->join('stock_cost_of_sales','supplier_stocks.branch_id = stock_cost_of_sales.branch_id','inner');	
				$this->db->where('supplier_stocks.supp_id',$supp_id);		
				$this->db->where('branch_stocks.stock_id',$stock_id);		
				$this->db->where('stock_cost_of_sales.stock_id',$stock_id);		
				$this->db->where('stock_master_new.stock_id',$stock_id);		
				$query = $this->db->get();		
				return $query->result();
			}else{
					$this->db->select('
						stock_master_new.stock_code,
						stock_master_new.description,
						supplier_stocks.supp_stock_code,
						supplier_stocks.description,
						branch_stocks.branch_id,
						branch_stocks.qty,
						branch_stocks.stock_loc_id,
						stock_cost_of_sales.cost_of_sales');
				$this->db->from('stock_master_new');
				$this->db->join('supplier_stocks','stock_master_new.stock_id = supplier_stocks.stock_id','inner');
				$this->db->join('branch_stocks','supplier_stocks.branch_id = branch_stocks.branch_id','inner');	
				$this->db->join('stock_cost_of_sales','supplier_stocks.branch_id = stock_cost_of_sales.branch_id','inner');	
				$this->db->where('supplier_stocks.supp_id',$supp_id);		
				$this->db->where('branch_stocks.stock_id',$stock_id);		
				$this->db->where('stock_cost_of_sales.stock_id',$stock_id);		
				$this->db->where('supplier_stocks.branch_id',$branch_id);		
				$this->db->where('stock_master_new.stock_id',$stock_id);	
				$query = $this->db->get();		
				return $query->result();
			}
				
	}
	
	public function get_branch_id($code=null){
		$sql = "SELECT id FROM branches WHERE code='".$code."'";
		$query = mysql_query($sql);
		$result = mysql_fetch_object($query); 
		return $result->id;
	}
	public function get_branch_code($id=null){
		$sql = "SELECT code FROM branches WHERE id='".$id."'";
		$query = mysql_query($sql);
		$result = mysql_fetch_object($query); 
		return $result->code;
	}
	public function get_out_of_stocks_count(){
		$sql = "SELECT COUNT(*) as tot_count FROM `branch_stocks` WHERE  qty <= 0";			
		$query = mysql_query($sql);
		$res = mysql_fetch_object($query);
		return $res->tot_count;

	}
	public function get_out_of_stocks_list(){
		$sql = "SELECT * FROM `branch_stocks` WHERE  qty <= 0";			
		$query = $this->db->query($sql);
		$result = $query->result();
		return $result;

	}
	public function get_critical_stocks_count(){
		// $sql = "SELECT COUNT(*) as tot_count FROM `branch_stocks` WHERE qty < critical_qty AND qty > 0 AND critical_qty != 0"; //-----OLD QUERY USED
		$sql = "SELECT COUNT(*) as tot_count FROM `branch_stocks` WHERE  qty <= 0";			
		$query = mysql_query($sql);
		$res = mysql_fetch_object($query);
		return $res->tot_count;

	}
	public function get_critical_stocks_list($critical_qty=''){
		// $sql = "SELECT * FROM `branch_stocks` WHERE qty < critical_qty AND qty > 0 AND critical_qty != 0";	 //ORIGINAL
		$sql = "SELECT * FROM `branch_stocks` WHERE qty < $critical_qty AND qty > 0";		
		$query = $this->db->query($sql);
		$result = $query->result();
		return $result;

	}
	public function get_pending_po_count(){
		// $sql = "SELECT order_no, SUM(qty_ordered),SUM(qty_received) 
		// FROM purch_order_details
		// WHERE 
		// GROUP BY order_no
		// HAVING SUM(qty_ordered) > SUM(qty_received)";
		// $query = mysql_query($sql);
		// $count = mysql_num_rows($query);
		// // $res = mysql_fetch_object($query);
		// // echo "----".$count;
		// return $count;
		
		//-----NEW
		$sql = "SELECT a.*, SUM(b.qty_ordered),SUM(b.qty_received) 
		FROM purch_orders a, purch_order_details b
		WHERE a.order_no = b.order_no
		AND a.status = 0
		GROUP BY b.order_no
		HAVING SUM(b.qty_ordered) > SUM(b.qty_received)";
		$query = mysql_query($sql);
		$count = mysql_num_rows($query);
		return $count;
	}
	public function get_unserved_po_count($current_date=''){
		/*
		FROM purch_orders a
		JOIN purch_order_details b ON a.order_id = b.order_id";
		*/
		// $sql = "SELECT order_no, SUM(qty_ordered),SUM(qty_received) 
		// FROM purch_order_details
		// GROUP BY order_no
		// HAVING SUM(qty_ordered) > SUM(qty_received)";
		
		// $sql = "SELECT * FROM purch_orders WHERE delivery_date < '$current_date' OR status != 3"; //-----OLD
		$sql = "SELECT * FROM purch_orders WHERE delivery_date < '$current_date' AND `status` = 0";
		$query = mysql_query($sql);
		$count = mysql_num_rows($query);
		// $res = mysql_fetch_object($query);
		// echo "----".$count;
		return $count;

	}
	public function get_decreasing_product_offtake_count(){
		// $sql = "SELECT order_no, SUM(qty_ordered),SUM(qty_received) 
		// FROM purch_order_details
		// WHERE 
		// GROUP BY order_no
		// HAVING SUM(qty_ordered) > SUM(qty_received)";
		// $query = mysql_query($sql);
		// $count = mysql_num_rows($query);
		// // $res = mysql_fetch_object($query);
		// // echo "----".$count;
		// return $count;
		
		//-----NEW
		$sql = "SELECT a.*, SUM(b.qty_ordered),SUM(b.qty_received) 
		FROM purch_orders a, purch_order_details b
		WHERE a.order_no = b.order_no
		AND a.status = 0
		GROUP BY b.order_no
		HAVING SUM(b.qty_ordered) > SUM(b.qty_received)";
		$query = mysql_query($sql);
		$count = mysql_num_rows($query);
		return $count;
	}
	//---DASHBOARD
	public function get_branch_name($id=null){
		$sql = "SELECT name FROM branches WHERE id=".$id;
		$query = mysql_query($sql);
		$result = mysql_fetch_object($query); 
		return $result->name;
	}
	public function get_po_branch_code($id=null){
		$sql = "SELECT code FROM branches WHERE id=".$id;
		$query = mysql_query($sql);
		$result = mysql_fetch_object($query); 
		return $result->code;
	}
	public function get_supplier_name($id=null){
		$sql = "SELECT supp_name FROM supplier_master WHERE supplier_id=".$id;
		$query = mysql_query($sql);
		$result = mysql_fetch_object($query); 
		return $result->supp_name;
	}
	public function get_stock_desc($id=null){
		$sql = "SELECT description FROM stock_master_new WHERE stock_id=".$id;
		$query = mysql_query($sql);
		$result = mysql_fetch_object($query); 
		return $result->description;
	}
	public function get_user_name($id=null){
		$sql = "SELECT fname,mname,lname,suffix FROM users WHERE id=".$id;
		$query = mysql_query($sql);
		$result = mysql_fetch_object($query); 
		return $result->fname.' '.$result->mname.' '.$result->lname.' '.$result->suffix;
	}
	public function get_branch_address($id=null){
		$sql = "SELECT address FROM branches WHERE id=".$id;
		// echo $sql."<br>";
		$query = mysql_query($sql);
		$result = mysql_fetch_object($query); 
		return $result->address;
	}
	public function get_stock_location_desc($id=null){
		$desc = "";
		if($id == 1){
			$desc = "SELLING AREA";
		}else if($id == 2){
			$desc = "STOCK ROOM";
		}else{
			$desc = "B.O. ROOM";
		}
		return $desc;
	}
	public function get_pending_po(){
		$sql = "SELECT a.*, SUM(b.qty_ordered),SUM(b.qty_received) 
		FROM purch_orders a, purch_order_details b
		WHERE a.order_no = b.order_no
		AND a.status = 0
		GROUP BY b.order_no
		HAVING SUM(b.qty_ordered) > SUM(b.qty_received)";
		$query = $this->db->query($sql);
		$result = $query->result();
		return $result;
	}
	public function get_pending_po_header($id=null){
		$sql = "SELECT *
		FROM purch_orders a";
		if($id != '')
			$sql .= " WHERE a.order_no = ".$id;
		$query = $this->db->query($sql);
		$result = $query->result();
		return $result;
	}
	public function get_pending_po_details($id=null){
		$sql = "SELECT *
		FROM purch_orders a
		JOIN purch_order_details b ON a.order_no = b.order_no";
		if($id != '')
			$sql .= " AND a.order_no = ".$id;
		$query = $this->db->query($sql);
		$result = $query->result();
		return $result;
	}
	public function get_unserved_po($current_date=null){
		// $sql = "SELECT * FROM purch_orders WHERE delivery_date < '$current_date' AND status != 3"; //-----OLD
		$sql = "SELECT * FROM purch_orders WHERE delivery_date < '$current_date' AND status = 0";
		$query = $this->db->query($sql);
		$result = $query->result();
		return $result;
	}
	//---DASHBOARD
	//-----LOAD VALUES-----START
	public function get_supplier_stock_details($stock_id=null, $branch_id=null){
			$sql = "SELECT * FROM supplier_stocks WHERE stock_id = $stock_id AND branch_id = $branch_id";
			$query = $this->db->query($sql);
			$row = $query->row();
			// echo $sql."<br>";
			if (!empty($row))
				return $row;
			else
				return false;
	}
	//-----LOAD VALUES-----END
	//-----PO ENTRY-----START
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
	public function get_unit_cost_from_branch_id_and_supp_id($stock_id=null, $branch_id=null, $supplier_id=null){
		$sql = "SELECT unit_cost FROM supplier_stocks WHERE stock_id=$stock_id AND branch_id=$branch_id AND supp_id=$supplier_id";
		$query = $this->db->query($sql);
		$row = $query->row();
		// echo $sql."<br>";
		if($row != null)
			return $row->unit_cost;
		else
			return false;
	}
	public function get_purch_orders_temp($id=null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('purch_orders_temp');
			if($id != null)
				$this->db->where('order_no',$id);
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	public function get_purch_orders($id=null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('purch_orders');
			if($id != null)
				$this->db->where('order_no',$id);
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	public function get_purch_order_details($id=null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('purch_order_details');
			if($id != null)
				$this->db->where('order_no',$id);
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	public function write_to_purch_orders_temp($items=array())
	{
		$this->db->insert('purch_orders_temp',$items);
		$id = $this->db->insert_id();
		return $id;
	}
	public function validate_po_order_no($order_no=null){
		$sql = "SELECT * FROM movements WHERE movement_id = $movement_id AND movement_type_id = $type_id";
		$query = mysql_query($sql);
		if(mysql_num_rows($query) == 0)
			return false;
		return true;
	}
	public function delete_purch_orders_temp_line_item($id=null){
		$this->db->where('line_id', $id);
		$this->db->delete('purch_orders_temp');
	}
	public function delete_purch_order_details_line_item($id=null){
		$this->db->where('line_id', $id);
		$this->db->delete('purch_order_details');
	}
	public function delete_from_purch_order_details_temp($id=null){
		$this->db->where('order_no', $id);
		$this->db->delete('purch_orders_temp');
	}
	public function write_to_po_header($items)
	{
		// $this->db->set('reg_date','NOW()',FALSE);
		$this->db->insert('purch_orders',$items);
		return $this->db->insert_id();
	}
	public function update_po_header($items,$id)
	{
		// $this->db->set('update_date','NOW()',FALSE);
		$this->db->where('order_no',$id);
		$this->db->update('purch_orders',$items);
	}
	public function write_to_purch_order_details($items)
	{
		$this->db->insert('purch_order_details',$items);
		$id = $this->db->insert_id();
		return $id;
	}
	public function write_to_purch_order_details_temp($items)
	{
		$this->db->insert('purch_orders_temp',$items);
		$id = $this->db->insert_id();
		return $id;
	}
	public function get_partial_purch_orders_details_temp($id=null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('purch_orders_temp');
			if($id != null)
				$this->db->where('order_no',$id);
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	public function get_partial_purch_orders_details_new($id=null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('purch_orders');
			$this->db->join('purch_order_details','purch_orders.order_no = purch_order_details.order_no','left');
			if($id != null)
				$this->db->where('purch_orders.order_no',$id);
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	//-----PO ENTRY-----END
	//-----AUDIT TRAIL-----APM-----START
	public function write_to_audit_trail($items=array())
	{
		$this->db->insert('audit_trail',$items);
		$id = $this->db->insert_id();
		return $id;
	}
	//-----AUDIT TRAIL-----APM-----END
	//-----PO PRINTOUT-----APM-----START
	public function get_supplier_details($supplier_id=null){
		// $branch = $this->session->userdata('srs_branch');
		// $this->sdb = $branch['database'];
		// $this->db = $this->load->database($this->sdb, TRUE);
		$this->db->select('supplier_master.*, payment_terms.term_name as term_desc');
		$this->db->from('supplier_master');
		$this->db->join('payment_terms','supplier_master.payment_terms = payment_terms.payment_id','left');
		if($supplier_id != null)
			$this->db->where('supplier_master.supplier_id =',$supplier_id);
		$query =  $this->db->get();
		// echo $this->db->last_query();
		return $query->result();
	}
	public function get_current_supplier_details($supplier_id=null){
		$this->db->select('supplier_master.*, payment_terms.term_name as term_desc');
		$this->db->from('supplier_master');
		$this->db->join('payment_terms','supplier_master.payment_terms = payment_terms.payment_id','left');
		// if($supplier_id != null)
			$this->db->where('supplier_master.supplier_id =',$supplier_id);
		$query =  $this->db->get();
		// echo $this->db->last_query();
		return $query->result();
	}
	//-----PO PRINTOUT-----APM-----END
	public function get_supplier_stock_code_from_stock_id($stock_id=null){
		$sql = "SELECT supp_stock_code FROM supplier_stocks WHERE stock_id = $stock_id ";
		// echo $sql."<br>";
		$query = $this->db->query($sql);
		$row = $query->row();
		if ($row != null)
			return $row->supp_stock_code;
		else
			return false;
	}
	public function get_branch_tin($branch_id=null){
		$sql = "SELECT tin FROM branches WHERE `id` = $branch_id ";
		// echo $sql."<br>";
		$query = $this->db->query($sql);
		$row = $query->row();
		if ($row != null)
			return $row->tin;
		else
			return false;
	}
	public function update_po_header_zero($items,$id)
	{
		// $this->db->set('update_date','NOW()',FALSE);
		$this->db->where('order_no',$id);
		$this->db->update('purch_order_details',$items);
	}
	//-----OFFTAKE COMPUTATION-----START
	// public function get_stock_offtake($date_from='', $date_to='', $stock_ids=array()){
	public function get_stock_offtake($date_from='', $date_to='', $stock_ids, $branch_id){
		$fmt_date_from = date('Y-m-d', strtotime($date_from));
		$fmt_date_to = date('Y-m-d', strtotime($date_to));
		
		$sql = "
			SELECT stock_id, SUM(a.sales_qty) as sales_total, 
			(SELECT COUNT(*) 
				FROM main_stocks_history b
				WHERE b.date_posted BETWEEN '$fmt_date_from' AND '$fmt_date_to'
				AND b.stock_id = a.stock_id
				AND b.branch_id = $branch_id
				AND (b.sales_qty > 0 OR b.qoh > 0)) as dividend
		FROM main_stocks_history a
		WHERE a.date_posted BETWEEN '$fmt_date_from' AND '$fmt_date_to'
		AND a.branch_id = $branch_id
		";
		
		if(is_array($stock_ids))
			$sql .= " AND a.stock_id IN (".implode(",", $stock_ids).")";
		else if(!empty($stock_ids))
			$sql .= " AND a.stock_id = $stock_ids";
		
		$sql .= "
		GROUP BY stock_id
		";
		
		// echo $sql."<br>";
		$query = $this->db->query($sql);
		$result = $query->result();
		return $result;
	}
	public function get_stocks_with_decreasing_offtake_count($date_from='', $date_to='', $branch_id='')
	{
		$fmt_date_from = date('Y-m-d', strtotime($date_from));
		$fmt_date_to = date('Y-m-d', strtotime($date_to));
		
		$sql = "
			SELECT stock_id, SUM(a.sales_qty) as sales_total, 
			(SELECT COUNT(*) 
				FROM main_stocks_history b
				WHERE b.date_posted BETWEEN '$fmt_date_from' AND '$fmt_date_to'
				AND b.stock_id = a.stock_id";
		if($branch_id != '')
		{
			$sql .= " AND b.branch_id = $branch_id";
		}
		$sql .="		
				AND (b.sales_qty > 0 OR b.qoh > 0)) as dividend
		FROM main_stocks_history a
		WHERE a.date_posted BETWEEN '$fmt_date_from' AND '$fmt_date_to'";
		if($branch_id != '')
		{
			$sql .= " AND a.branch_id = $branch_id";
		}
		$sql .= "
		GROUP BY stock_id
		";
		$query = $this->db->query($sql);
		$result = $query->result();
		$tot_count = $counter = 0;
		foreach($result as $val)
		{
			$counter++;
		}
		$tot_count = $counter;
		// echo $tot_count."~~~".$counter."<br>";
		return $tot_count;
	}
	//-----OFFTAKE COMPUTATION-----END
}