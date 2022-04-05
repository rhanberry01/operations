<?php
class Pos_model extends CI_Model{
	public function __construct(){
		parent::__construct();
	}
	public function daily_zread($this_date=""){
		// $sql = "SELECT * FROM `daily_zread_status` ORDER BY counter_no ASC";
		$sql = "SELECT * FROM `daily_zread_status_copy` WHERE trans_date = '$this_date' ORDER BY counter_no ASC";
		$query = $this->db->query($sql);
		// echo $sql."<br>";
		$result = $query->result();
		return $result;
	}
	public function get_daily_sales_transactions($this_date=""){
		//-----PASS counter_no and branch_id here

		$sql = "SELECT *, main.id as main_id
		FROM sales_header main
		JOIN sales_details sub
		ON main.id = sub.sales_id
		WHERE DATE(main.trans_datetime) = '$this_date'";

		//-----For testing purposes only
		/*
		$sql = "SELECT *, main.id as main_id
		FROM sales_header main
		JOIN sales_details sub
		ON main.id = sub.sales_id
		WHERE DATE(main.trans_datetime) = '2015-08-28'";
		*/
		$query = $this->db->query($sql);
		$result = $query->result();
		return $result;
	}
	public function write_to_stock_moves_branch($items)
	{
		// $this->db->insert('stock_moves_branch', $items); //-----ORIGINAL
		$this->db->insert('stock_moves_branch_copy', $items); //-----TESTING
		$id = $this->db->insert_id();
		return $id;
	}
	public function write_to_branch_zread_controller($items)
	{
		// $this->db->insert('stock_moves_branch', $items); //-----ORIGINAL
		$this->db->insert('branch_zread_controller', $items); //-----TESTING
		$id = $this->db->insert_id();
		return $id;
	}
	public function get_branch_stock_cost_of_sales_row($stock_id=null, $branch_id=null){
		$sql = "SELECT * FROM `stock_cost_of_sales` WHERE stock_id = $stock_id AND branch_id=$branch_id";
		$query = $this->db->query($sql);
		$row = $query->row();
		if ($row != null){
			// $res = $row[0];
			return $row;
		}else{
			return false;
		}
	}
	public function check_current_day_branch_zread_controller($branch_id=null, $current_date=null){
		$fmt_date = date('Y-m-d', strtotime($current_date));
		$sql = "SELECT COUNT(*) as line FROM `branch_zread_controller` WHERE branch_id = $branch_id AND DATE(trans_datetime)='$fmt_date'";
		$query = $this->db->query($sql);
		$row = $query->row();
		if ($row != null)
			return $row->line;
		else
			return 0;
	}
	public function sync_daily_sales_transactions($this_date=""){
		//-----PASS counter_no and branch_id here
		/*
		$sql = "SELECT *
		FROM sales_header main
		JOIN sales_details sub
		ON main.id = sub.sales_id
		WHERE DATE(main.trans_datetime) = '$this_date'";
		*/
		$user = $this->session->userdata('user');
		$items = $si_next_val = $cos_line = $fin_items = array();
		$type_no = "";
		$cos = 0;
		
		//-----For testing purposes only
		// $current_date = date('Y-m-d');
		$current_date = date('Y-m-d', strtotime('2015-09-01'));
		$res = $this->get_daily_sales_transactions($current_date);
		foreach($res as $val)
		{
			// echo "Invoice No # ".$val->invoice_no."--- Total Vatable : ".$val->total_vatable." --- Total Tax : ".$val->total_tax."<br>";
			/*
			Stock Moves Branch [fields]
			id INT, branch_id INT, type INT, trans_no INT, reference VC, stock_id INT, barcode VC,
			stock_location INT, trans_date DATE, user_id INT, unit_cost DBL, unit_cost_pcs DBL,
			qty DBL, qty_pcs DBL, stock_uom VC, standard_cost DBL, disc_percent1 DBL, 
			disc_percent2 DBL, disc_percent3 DBL, disc_percent4 DBL, disc_percent5 DBL, disc_percent6 DBL
			*/
			$cos_line = $this->get_branch_stock_cost_of_sales_row($val->stock_id, $val->branch_id);
			$items = array(
				"branch_id"=>$val->branch_id,
				"type"=>SALES_INVOICE,
				"trans_no"=>$val->main_id,
				"reference"=>$val->counter_no."~".$val->invoice_no,
				"stock_id"=>$val->stock_id,
				"barcode"=>$val->barcode,
				"stock_location"=>SELLING_AREA,
				"trans_date"=>date('Y-m-d', strtotime($val->trans_datetime)),
				"user_id"=>$val->cashier_id,
				"qty_pcs"=>($val->packing * $val->qty),
				"price"=>$val->price,
				"stock_uom"=>$val->uom,
				"standard_cost"=>$cos_line->cost_of_sales,
				// "disc_percent1"=>0,
				"is_visible"=>1,
			);
			$this->write_to_stock_moves_branch($items);
		}
		$fin_items = array(
		"branch_id"=>BRANCH_ID,
		"user_id"=>$user['id']
		);
		$this->write_to_branch_zread_controller($fin_items);
	}
}