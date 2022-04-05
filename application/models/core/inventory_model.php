<?php
class Inventory_model extends CI_Model{
	public function __construct(){
		parent::__construct();
	}
	public function get_item_categories($where=null)
	{
		$this->db->select('*');
		$this->db->from('stock_categories');
		if ($where)
			$this->db->where($where);
		$this->db->order_by('category_name ASC');
		$query = $this->db->get();
		return $query->result();
	}
	public function write_item_categories($items)
	{
		$this->db->insert('stock_categories',$items);
		$id = $this->db->insert_id();
		return $id;
	}
	public function write_stock_for_deletion($items)
	{
		$this->db->insert('stock_deletion_approval',$items);
		$id = $this->db->insert_id();
		return $id;
	}
	public function change_item_categories($items,$where=null)
	{
		if ($where)
			$this->db->where($where);
		$this->db->update('stock_categories',$items);
	}
	public function get_uoms($where=null)
	{
		$this->db->select('*');
		$this->db->from('uoms');
		if ($where)
			$this->db->where($where);
		$this->db->order_by('name ASC');
		$query = $this->db->get();
		return $query->result();
	}
	public function write_uom($items)
	{
		$this->db->insert('uoms',$items);
		$id = $this->db->insert_id();
		return $id;
	}
	public function change_uom($items,$where=null)
	{
		if ($where)
			$this->db->where($where);
		$this->db->update('uoms',$items);
	}
	public function get_item_types($where=null)
	{
		$this->db->select('*');
		$this->db->from('stock_types');
		if ($where)
			$this->db->where($where);
		$this->db->order_by('type_name ASC');
		$query = $this->db->get();
		return $query->result();
	}
	public function get_barcodes_count(){
		$sql = "SELECT COUNT(*) as line
				FROM stock_barcodes_new_temp";			
		$query = mysql_query($sql);
		$res = mysql_fetch_object($query);
		return $res->line;

	}
	public function get_masters_new_count(){
		$sql = "SELECT COUNT(*) as line
				FROM stock_master_new_temp";			
		$query = mysql_query($sql);
		$res = mysql_fetch_object($query);
		return $res->line;

	}
	public function get_barcode_scheduled_markdown_count(){
		$sql = "SELECT COUNT(*) as line
				FROM stock_barcode_scheduled_markdown_temp";			
		$query = mysql_query($sql);
		$res = mysql_fetch_object($query);
		return $res->line;

	}
	public function get_barcode_price_stock_logs_count(){
		$sql = "SELECT COUNT(*) as line
				FROM stock_logs
				WHERE approval_status = 0";			
		$query = mysql_query($sql);
		$res = mysql_fetch_object($query);
		return $res->line;

	}
	public function get_supplier_biller_code_count(){
		$sql = "SELECT COUNT(*) as line
				FROM supplier_biller_code_approval WHERE status = 0";			
		$query = mysql_query($sql);
		$res = mysql_fetch_object($query);
		return $res->line;

	}
	public function get_marginal_markdown_count(){
		$sql = "SELECT COUNT(*) as line
				FROM stock_barcode_marginal_markdown_temp";			
		$query = mysql_query($sql);
		$res = mysql_fetch_object($query);
		return $res->line;

	}
		public function get_stock_deletion(){
		$sql = "SELECT COUNT(*) as line
				FROM stock_deletion_approval where approval_status = 0";			
		$query = mysql_query($sql);
		$res = mysql_fetch_object($query);
		return $res->line;

	}	
	public function get_stock_price_update(){
		$sql = "SELECT COUNT(*) as line
				FROM stock_barcode_prices_approval where approval_status = 0";			
		$query = mysql_query($sql);
		$res = mysql_fetch_object($query);
		return $res->line;

	}
	public function get_supplier_stocks_count(){
		$sql = "SELECT COUNT(*) as line
				FROM supplier_stocks_temp";			
		$query = mysql_query($sql);
		$res = mysql_fetch_object($query);
		return $res->line;

	}
	
	public function write_item_type($items)
	{
		$this->db->insert('stock_types',$items);
		$id = $this->db->insert_id();
		return $id;
	}
	public function change_item_type($items,$where=null)
	{
		if ($where)
			$this->db->where($where);
		$this->db->update('stock_types',$items);
	}
	public function get_items($where=null)
	{
		$this->db->select('
			a.id,
			a.name,
			a.item_code,
			a.barcode,
			a.brand_name,
			a.grade,
			a.description,
			a.uom_id,
			b.name as "uom_name",
			b.decimal_places "decimals",
			a.category_id,
			e.category_name,
			a.item_tax_type,
			c.type_name tax_type_name,
			a.item_type,
			d.type_name item_type_name,
			a.currency_abrev,
			a.standard_cost,
			a.sales_price,
			a.sales_account,
			a.cogs_account,
			a.inventory_account,
			a.adjustment_account,
			a.assembly_cost_account
		');
		// $this->db->select('
			// a.id,
			// a.name,
			// a.item_code,
			// a.barcode,
			// a.brand_name,
			// a.description,
			// a.uom_id,
			// b.name as "uom_name",
			// b.decimal_places "decimals",
			// a.category_id,
			// e.category_name,
			// a.item_tax_type,
			// c.type_name tax_type_name,
			// a.item_type,
			// d.type_name item_type_name,
			// a.currency_abrev,
			// a.standard_cost,
			// a.sales_price,
			// a.sales_account,
			// a.cogs_account,
			// a.inventory_account,
			// a.adjustment_account,
			// a.assembly_cost_account
		// ');
		$this->db->from('stock_master a');
		$this->db->join('uoms b','a.uom_id = b.uom_id','LEFT');
		$this->db->join('tax_types c','a.item_tax_type = c.tax_type_id','LEFT');
		$this->db->join('stock_types d','a.item_type = d.id','LEFT');
		$this->db->join('stock_categories e','a.category_id = e.stock_category_id','LEFT');
		if ($where)
			$this->db->where($where);
		$query = $this->db->get();
		return $query->result();
	}
	public function write_item($items)
	{
		$this->db->insert('stock_master',$items);
		$id = $this->db->insert_id();
		return $id;
	}
	public function change_item($items,$where=null)
	{
		if ($where)
			$this->db->where($where);
		$this->db->update('stock_master',$items);
	}
	public function update_item_price($items,$where=null)
	{
		if ($where)
			$this->db->where($where);
		$this->db->update('stock_master',$items);
	}
	//**********INVENTORY LOCATIONS*****Allyn*****START
	public function get_inventory_locations($id=null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('stock_locations');
			if($id != null){
				$this->db->where('stock_locations.location_id',$id);
			}
			$this->db->order_by('location_id desc');
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	public function add_inventory_locations($items){
		$this->db->insert('stock_locations',$items);
		$x=$this->db->insert_id();
		return $x;
	}
	public function update_inventory_locations($user,$id){
		$this->db->where('location_id', $id);
		$this->db->update('stock_locations', $user);

		return $this->db->last_query();
	}
	//**********INVENTORY LOCATIONS*****Allyn*****END
	//----------------Stock Moves------------------------------------start
	public function get_item_movement($item_id=null, $loc_code=null, $start_date=null, $end_date=null)
	{
		if($start_date!=''){
			$fmt_start_date = date('Y-m-d', strtotime($start_date));
		}else{
			$fmt_start_date=null;
		}

		if($end_date!=''){
			$fmt_end_date = date('Y-m-d', strtotime($end_date));
		}else{
			$fmt_end_date=null;
		}

		$this->db->select('
			`stock_moves`.`counter` AS `counter`,
			`stock_moves`.`item_id` AS `item_id`,
			`stock_master`.`item_code` AS `item_code`,
			`stock_master`.`name` AS `item_name`,
			`stock_master`.`standard_cost` AS `standard_cost`,
			`stock_master`.`sales_price` AS `sales_price`,
			`stock_moves`.`trans_type` AS `trans_type`,
			`stock_moves`.`type_no` AS `type_no`,
			`stock_moves`.`trans_date` AS `trans_date`,
			`stock_moves`.`loc_code` AS `loc_code`,
			`stock_moves`.`person_id` AS `person_id`,
			`stock_moves`.`qty` AS `qty`,
			`stock_moves`.`visible` AS `visible`,
			`stock_moves`.`reference` AS `reference`,
			`trans_types`.`name` AS `trans_type_name`
			',false);
		$this->db->from('stock_moves');
		$this->db->join('stock_master','stock_master.id = stock_moves.item_id');
		// $this->db->join('trans_types','trans_types.type_id = stock_moves.trans_type'); //old
		$this->db->join('trans_types','trans_types.trans_type = stock_moves.trans_type');
		// $this->db->join('sales_types','sales_orders.sales_type = sales_types.id');
		// $this->db->join('shipping_company','sales_orders.shipper_id = shipping_company.ship_company_id');
		// $this->db->join('sales_order_details','sales_orders.order_no = sales_order_details.order_no','left');

		// if ($where)
			// if (is_array($where))
				// foreach ($where as $v) {
					// $this->db->where($v['key'],$v['value'],$v['escape']);
				// }
			// else
				// $this->db->where($where);

		if(!empty($item_id) OR $item_id != null){
			$this->db->where('stock_moves.item_id',$item_id);
		}

		if(!empty($loc_code) OR $loc_code != null){
			$this->db->where('stock_moves.loc_code',$loc_code);
		}

		if(!empty($start_date) OR $start_date != null){
			$this->db->where('stock_moves.trans_date >=',$fmt_start_date);
		}

		if(!empty($end_date) OR $end_date != null){
			$this->db->where('stock_moves.trans_date <=',$fmt_end_date);
		}

		// $this->db->group_by('stock_moves.trans_date');

		$query = $this->db->get();
		// echo $this->db->last_query();
		return $query->result();
	}
	// public function get_item_qoh($item_id=null, $loc_code=null, $start_date=null, $end_date=null){
		// if($start_date!=''){
			// $fmt_start_date = date('Y-m-d', strtotime($start_date));
		// }else{
			// $fmt_start_date=null;
		// }

		// if($end_date!=''){
			// $fmt_end_date = date('Y-m-d', strtotime($end_date));
		// }else{
			// $fmt_end_date=null;
		// }

		// $this->db->select('
			// SUM(qty) AS qoh
			// ',false);
		// $this->db->from('stock_moves');
		// if(!empty($item_id) OR $item_id != null){
			// $this->db->where('stock_moves.item_id',$item_id);
		// }

		// if(!empty($loc_code) OR $loc_code != null){
			// $this->db->where('stock_moves.loc_code',$loc_code);
		// }

		// if(!empty($start_date) OR $start_date != null){
			// $this->db->where('stock_moves.trans_date >=',$fmt_start_date);
		// }

		// if(!empty($end_date) OR $end_date != null){
			// $this->db->where('stock_moves.trans_date <=',$fmt_end_date);
		// }

		// $query = $this->db->get();
		// // echo $this->db->last_query();
		// $result = $query->result();
		// return $result[0];
	// }
	public function get_item_qoh($item_id=null, $loc_code=null){
		// if($start_date!=''){
			// $fmt_start_date = date('Y-m-d', strtotime($start_date));
		// }else{
			// $fmt_start_date=null;
		// }

		// if($end_date!=''){
			// $fmt_end_date = date('Y-m-d', strtotime($end_date));
		// }else{
			// $fmt_end_date=null;
		// }

		$this->db->select('
			SUM(qty) AS qoh
			',false);
		$this->db->from('stock_moves');
		if(!empty($item_id) OR $item_id != null){
			$this->db->where('stock_moves.item_id',$item_id);
		}

		if(!empty($loc_code) OR $loc_code != null){
			$this->db->where('stock_moves.loc_code',$loc_code);
		}

		// if(!empty($start_date) OR $start_date != null){
			// $this->db->where('stock_moves.trans_date >=',$fmt_start_date);
		// }

		// if(!empty($end_date) OR $end_date != null){
			// $this->db->where('stock_moves.trans_date <=',$fmt_end_date);
		// }

		$query = $this->db->get();
		// echo $this->db->last_query();
		$result = $query->result();
		return $result[0];
	}
	public function get_item_qoh_before($item_id=null, $loc_code=null, $start_date=null){
		if($start_date!=''){
			$fmt_start_date = date('Y-m-d', strtotime($start_date));
		}else{
			$fmt_start_date=null;
		}

		$this->db->select('
			SUM(qty) AS qoh
			',false);
		$this->db->from('stock_moves');
		if(!empty($item_id) OR $item_id != null){
			$this->db->where('stock_moves.item_id',$item_id);
		}

		if(!empty($loc_code) OR $loc_code != null){
			$this->db->where('stock_moves.loc_code',$loc_code);
		}

		if(!empty($start_date) OR $start_date != null){
			$this->db->where('stock_moves.trans_date <',$fmt_start_date);
		}

		$query = $this->db->get();

		$result = $query->result();
		return $result[0];
	}
	public function get_hardware_item_qoh_before($item_id=null, $loc_code=null, $start_date=null){
		if($start_date!=''){
			$fmt_start_date = date('Y-m-d', strtotime($start_date));
		}else{
			$fmt_start_date=null;
		}

		$this->db->select('
			SUM(qty) AS qoh
			',false);
		$this->db->from('non_stock_moves');
		if(!empty($item_id) OR $item_id != null){
			$this->db->where('non_stock_moves.item_id',$item_id);
		}

		if(!empty($loc_code) OR $loc_code != null){
			$this->db->where('non_stock_moves.loc_code',$loc_code);
		}

		if(!empty($start_date) OR $start_date != null){
			$this->db->where('non_stock_moves.trans_date <',$fmt_start_date);
		}

		$query = $this->db->get();

		$result = $query->result();
		return $result[0];
	}
	public function get_item_backorder_before($item_id=null, $loc_code=null, $start_date=null, $end_date=null){
		if($start_date!=''){
			$fmt_start_date = date('Y-m-d', strtotime($start_date));
		}else{
			$fmt_start_date=null;
		}

		if($end_date!=''){
			$fmt_end_date = date('Y-m-d', strtotime($end_date));
		}else{
			$fmt_end_date=null;
		}

		//-----------------
		/*
		SELECT a.item_code, (a.quantity_ordered-a.quantity_received) AS pending
		FROM purch_order_details a
		JOIN purch_orders b ON b.order_id = a.order_id
		JOIN stock_moves c ON c.item_id = a.item_code
		WHERE a.item_code = 3
		AND b.`status` = 'pending'
		AND b.ord_date BETWEEN '2015-01-01' AND '2015-01-10'
		AND c.loc_code = 'PHP'
		GROUP BY a.item_code;
		*/
		//-----------------

		$this->db->select('(purch_order_details.quantity_ordered-purch_order_details.quantity_received) AS backorder');
		$this->db->from('purch_order_details');
		$this->db->join('purch_orders','purch_orders.order_id = purch_order_details.order_id');
		$this->db->join('stock_moves','stock_moves.item_id = purch_order_details.item_code');

		if(!empty($item_id) OR $item_id != null){
			$this->db->where('purch_order_details.item_code',$item_id);
		}

		if(!empty($loc_code) OR $loc_code != null){
			$this->db->where('stock_moves.loc_code',$loc_code);
		}

		if(!empty($start_date) OR $start_date != null){
			$this->db->where('purch_orders.ord_date >',$fmt_start_date);
		}

		if(!empty($end_date) OR $end_date != null){
			$this->db->where('purch_orders.ord_date <=',$fmt_end_date);
		}

		$this->db->where('purch_orders.status','pending');
		$this->db->group_by('purch_order_details.item_code');

		$query = $this->db->get();
		// echo $this->db->last_query();
		$result = $query->result();
		if(!empty($result))
			return $result[0];
		else
			return 0;
		// return $result[0];
	}
	public function get_hw_trans_header($where=null)
	{
		$this->db->select('
			non_stock_moves.trans_type,
			non_stock_moves.type_no,
			trans_types.name as trans_name,
			non_stock_master.item_code,
			non_stock_master.name,
			non_stock_moves.qty,
			non_stock_moves.loc_code,
			non_stock_moves.trans_date,
			non_stock_moves.reference,
			non_stock_moves.movement_type,
			debtor_trans.debtor_id,
			debtor_trans.debtor_branch_id,
			debtor_trans.trans_date as dtrx_date,
			debtor_trans.due_date,
			debtor_trans.t_amount,
			debtor_trans.t_tax,
			debtor_trans.t_shipping_cost,
			debtor_trans.t_discount,
			debtor_trans.allocated_amount,
			debtor_trans.invoice_due_date,
			debtor_trans.pr_ref,
			debtor_trans.si_ref,
			debtor_trans.dr_ref,
			debtor_trans.person_id,
			debtor_master.`name` as debtor_name,
			debtor_branches.branch_name,
			non_stock_moves.person_id,
			users.fname,
			users.mname,
			users.lname,
			users.suffix
			');
		$this->db->from('non_stock_moves');
		$this->db->join('non_stock_master','non_stock_moves.item_id = non_stock_master.id');
		$this->db->join('trans_types','non_stock_moves.trans_type = trans_types.trans_type');
		$this->db->join('debtor_trans',
			'non_stock_moves.trans_type = debtor_trans.trans_type AND non_stock_moves.type_no = debtor_trans.type_no','left');
		$this->db->join('users','non_stock_moves.person_id = users.id','left');
		$this->db->join('debtor_master','debtor_trans.debtor_id = debtor_master.debtor_id','left');
		$this->db->join('debtor_branches','debtor_trans.debtor_branch_id = debtor_branches.debtor_branch_id','left');
		if ($where) {
			if (is_array($where))
				foreach ($where as $v) {
					if (isset($v['key']))
						$this->db->where($v['key'],$v['value'],$v['escape']);
					else
						$this->db->where($v);
				}
			else
				$this->db->where($where);
		}
		$query = $this->db->get();
		return $query->result();
	}
	public function write_item_movements($items,$method='batch')
	{
		if ($method != 'batch') {
			$this->db->insert('stock_moves',$items);
			$id = $this->db->insert_id();
			return $id;
		} else
			$this->db->insert_batch('stock_moves',$items);
	}
	public function write_non_stock_movements($items,$method='batch')
	{
		if ($method != 'batch') {
			$this->db->insert('non_stock_moves',$items);
			$id = $this->db->insert_id();
			return $id;
		} else
			$this->db->insert_batch('non_stock_moves',$items);
	}
	//----------------Stock Moves------------------------------------end
	public function get_inventory_item($id=null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('stock_master');
			if($id != null)
				$this->db->where('stock_master.id',$id);
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		// echo $this->db->last_query();
		return $result;
	}
	public function get_inventory_item_details($where,$table){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from($table);
			if($where)
				$this->db->where($where);
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	public function get_next_type_no($type_id=null){
		$this->db->select("next_ref");
		$this->db->from("trans_types");
		$this->db->where("type_id",$type_id);
		$query = $this->db->get();
		$result = $query->result();
		$res = $result[0];
		return $res->next_ref;
	}
	public function update_trans_types_next_ref($prev_ref,$trans_type_id){
		$new_ref = $prev_ref+1;
		$this->db->where('type_id', $trans_type_id);
		// $this->db->update('trans_types',array('next_ref'=>$new_ref),array('type_id'=>$trans_type));
		$this->db->update('trans_types',array('next_ref'=>$new_ref));
		// echo $this->db->last_query();
		return $this->db->last_query();
	}
	public function add_inventory_adjustment($items){
		// $this->db->set('reg_date', 'NOW()', FALSE);
		$this->db->insert('stock_moves',$items);
		$x=$this->db->insert_id();
		return $x;
	}
	public function get_item_movement_details($id=null,$type=null,$type_no=null,$ref=null){
		$this->db->trans_start();
			$this->db->select('stock_moves.*');
			if($type == 15){
				$this->db->select('purch_order_details.quantity_ordered');
			}
			$this->db->from('stock_moves');
			if($type == 15){
				$this->db->join('delivery_details','delivery_details.delivery_id = stock_moves.reference_link');
				$this->db->join('purch_order_details','purch_order_details.po_detail_item = delivery_details.po_detail_item');
			}
			// if($id != null){
			// 	$this->db->where('stock_moves.counter',$id);
			// }
			if($type != null){
				$this->db->where('stock_moves.trans_type',$type);
			}
			if($type_no != null){
				$this->db->where('stock_moves.type_no',$type_no);
			}
			if($ref != null){
				$this->db->where('stock_moves.reference',$ref);
			}
			$this->db->order_by('stock_moves.counter desc');

			// if($type == 15){
			// 	$this->db->group_by('delivery_details.po_detail_item');
			// }
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	public function created_by($person_id=null){
		$sql = " SELECT CONCAT(fname, ' ', lname, ' ', suffix) AS person FROM `users` WHERE id=".$person_id;
		$query = $this->db->query($sql);
		$result = $query->result();
		$res = $result[0];
		return $res->person;
	}

	//////////////////////JED////////////////////////////////////
	///////////////////////////////////////////////////////////
	public function get_hardware_movement($item_id=null, $loc_code=null, $start_date=null, $end_date=null)
	{
		if($start_date!=''){
			$fmt_start_date = date('Y-m-d', strtotime($start_date));
		}else{
			$fmt_start_date=null;
		}

		if($end_date!=''){
			$fmt_end_date = date('Y-m-d', strtotime($end_date));
		}else{
			$fmt_end_date=null;
		}

		$this->db->select('
			`non_stock_moves`.`counter` AS `counter`,
			`non_stock_moves`.`item_id` AS `item_id`,
			`non_stock_master`.`item_code` AS `item_code`,
			`non_stock_master`.`name` AS `item_name`,
			`non_stock_moves`.`trans_type` AS `trans_type`,
			`non_stock_moves`.`type_no` AS `type_no`,
			`non_stock_moves`.`trans_date` AS `trans_date`,
			`non_stock_moves`.`loc_code` AS `loc_code`,
			`non_stock_moves`.`person_id` AS `person_id`,
			`non_stock_moves`.`qty` AS `qty`,
			`non_stock_moves`.`visible` AS `visible`,
			`non_stock_moves`.`reference` AS `reference`,
			`trans_types`.`name` AS `trans_type_name`
			',false);
		$this->db->from('non_stock_moves');
		$this->db->join('non_stock_master','non_stock_master.id = non_stock_moves.item_id');
		// $this->db->join('trans_types','trans_types.type_id = stock_moves.trans_type'); //old
		$this->db->join('trans_types','trans_types.trans_type = non_stock_moves.trans_type');
		// $this->db->join('sales_types','sales_orders.sales_type = sales_types.id');
		// $this->db->join('shipping_company','sales_orders.shipper_id = shipping_company.ship_company_id');
		// $this->db->join('sales_order_details','sales_orders.order_no = sales_order_details.order_no','left');

		// if ($where)
			// if (is_array($where))
				// foreach ($where as $v) {
					// $this->db->where($v['key'],$v['value'],$v['escape']);
				// }
			// else
				// $this->db->where($where);

		if(!empty($item_id) OR $item_id != null){
			$this->db->where('non_stock_moves.item_id',$item_id);
		}

		if(!empty($loc_code) OR $loc_code != null){
			$this->db->where('non_stock_moves.loc_code',$loc_code);
		}

		if(!empty($start_date) OR $start_date != null){
			$this->db->where('non_stock_moves.trans_date >=',$fmt_start_date);
		}

		if(!empty($end_date) OR $end_date != null){
			$this->db->where('non_stock_moves.trans_date <=',$fmt_end_date);
		}

		// $this->db->group_by('stock_moves.trans_date');

		$query = $this->db->get();
		// echo $this->db->last_query();
		return $query->result();
	}
	public function get_details($where,$table){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from($table);
			if($where)
				$this->db->where($where);
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	//-----Maintenance: UOM-----start
	//Get Listing of UOM - active record
	public function get_uom_list($id=null){
		$this->db->trans_start();
		$this->db->select('*');
		$this->db->from('stock_uoms');
		if($id != null)
			$this->db->where('id',$id);
		$query = $this->db->get();
		$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	//Insert to DB
	public function add_uom($items)
	{
		// $this->db->set('reg_date','NOW()',FALSE);
		$this->db->insert('stock_uoms',$items);
		return $this->db->insert_id();
	}
	public function add_per_branch_uom($items){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('stock_uoms');		
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		
		$branch = array();
		$branch_name =  array();
			$test = $this->get_all_branches();
			foreach($test as $val){
				 array_push ($branch,$val->code);		
			}
			$num_branch = count($branch);
			$num =0;
			while($num_branch != $num){
				$num = $num + 1;
				$bdb = $this->load->database($branch[$num-1],TRUE);
				$connected = $bdb->initialize();
				if($connected){
					$sql1 = "TRUNCATE stock_uoms";
					mysql_query($sql1);	
				foreach($result as $val){
						$sql11 = "INSERT INTO stock_uoms(id,
														unit_code,
														description,
														qty,
														inactive) 
													VALUES( 
													 '".$val->id."',
													 '".$val->unit_code."',
													 '".$val->description."',
													 '".$val->qty."',
													 '".$val->inactive."')";
									mysql_query($sql11);		
				}
				}else{
					if($branch_name == null){
					array_push($branch_name,'add:'.$branch[$num-1]);
					}else{
					array_push($branch_name,'|'.$branch[$num-1]);	
					}
				}
			}
			$branch_name_con =  implode($branch_name);	
			
			$bdb = $this->load->database('default',TRUE);
			$cons = $bdb->initialize();
			if ($branch_name_con != ''){
					$sql11 = "UPDATE stock_uoms SET branch_no_con = '$branch_name_con'  WHERE unit_code = '".$items['unit_code']."' ";
					mysql_query($sql11);		
					//echo 'success';
			}	
}
	//Update DB
	public function update_uom($items,$id){
		$branch = array('default');
		$branch_name =  array();
			$test = $this->get_all_branches();
			foreach($test as $val){
				 array_push ($branch,$val->code);		
			}
			$num_branch = count($branch);
			$num =0;
			while($num_branch != $num){
				$num = $num + 1;
				$bdb = $this->load->database($branch[$num-1],TRUE);
				$connected = $bdb->initialize();
				if($connected){
					
					$sql11 = "UPDATE stock_uoms SET unit_code = '".$items['unit_code']."',
												description = '".$items['description']."',
												qty = '".$items['qty']."',
												inactive = '".$items['inactive']."'

							WHERE id = '$id' ";
					mysql_query($sql11);		
				}else{
					if($branch_name == null){
					array_push($branch_name,'update:'.$branch[$num-1]);
					}else{
					array_push($branch_name,'|'.$branch[$num-1]);	
					}
				}
			}
			$branch_name_con =  implode($branch_name);	
			$bdb = $this->load->database('default',TRUE);
			$cons = $bdb->initialize();
			if ($branch_name_con != ''){
					$sql11 = "UPDATE stock_uoms SET branch_no_con = '$branch_name_con'  WHERE id = '$id' ";
					mysql_query($sql11);		
											//echo 'success';
			}
	}
	
	//validate product code
	public function uom_name_exist_add_mode($unit_code=null){
		$sql = "SELECT * FROM stock_uoms WHERE unit_code = '$unit_code'";
		$query = mysql_query($sql);
		if(mysql_num_rows($query) == 0)
			return false;
		return true;
	}
	public function uom_name_exist_edit_mode($unit_code=null, $uom_id=null){
		$sql = "SELECT * FROM stock_uoms WHERE unit_code = '$unit_code' AND id != $uom_id";
		$query = mysql_query($sql);
		if(mysql_num_rows($query) == 0)
			return false;
		return true;
	}
	//-----Maintenance: UOM-----end
	public function get_all_branches($id=null){
		$this->db->trans_start();
			$this->db->select('code');
			$this->db->from('branches');
			if($id != null)
				$this->db->where('id',$id);
			$this->db->where('inactive',0);
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	
	
 //<--------------Start Stock Category db  -------- > //
	public function get_stock_category($id=null){
		$sql = "SELECT * FROM stock_categories_new";
		if($id != null)
		$sql.=" WHERE id = '".$id."' ";
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	//Insert to DB
	public function add_category($items)
	{
		// $this->db->set('reg_date','NOW()',FALSE);
		$this->db->insert('stock_categories_new',$items);
		return $this->db->insert_id();
	}
	//Update DB
	public function update_category($items,$id){
		// $this->db->where('code', $id);
		$this->db->where('id', $id);
		$this->db->update('stock_categories_new', $items);
	}
	
	//validate product code
	public function category_code_exist_add_mode($category_name=null){
		$sql = "SELECT * FROM stock_categories_new WHERE description = '$category_name'";
		$query = mysql_query($sql);
		if(mysql_num_rows($query) == 0)
			return false;
		return true;
	}
	public function category_code_exist_edit_mode($category_name=null, $stock_category_id=null){
		$sql = "SELECT * FROM stock_categories_new WHERE description = '$category_name' AND id != $stock_category_id";
		$query = mysql_query($sql);
		if(mysql_num_rows($query) == 0)
			return false;
		return true;
	}
	
	public function subcat_name($subcat_id){
		$sql = "SELECT description FROM stock_categories_new WHERE id = $subcat_id ";
		$query = $this->db->query($sql);
		$row = $query->row();
		if ($row != null)
		return $row->description;
		return false;
	}
 
 //<--------------End Stock Category db  -------- > //

	//-----Stock Locations----START
	public function get_stock_locations($id=null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('stock_locations_new');
			if($id != null)
				$this->db->where('id',$id);
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	public function stock_location_code_exist_add_mode($loc_code=null){
		$sql = "SELECT * FROM stock_locations_new WHERE loc_code = '$loc_code'";
		$query = mysql_query($sql);
		if(mysql_num_rows($query) == 0)
			return false;
		return true;
	}
	public function stock_location_code_exist_edit_mode($loc_code=null, $id=null){
		$sql = "SELECT * FROM stock_locations_new WHERE loc_code = '$loc_code' AND id != $id";
		$query = mysql_query($sql);
		if(mysql_num_rows($query) == 0)
			return false;
		return true;
	}
	public function add_stock_locations($items){
		$this->db->insert('stock_locations_new',$items);
		$x=$this->db->insert_id();
		return $x;
	}
	public function update_stock_locations($user,$id){
		$this->db->where('id', $id);
		$this->db->update('stock_locations_new', $user);

		return $this->db->last_query();
	}
	
	//----Stock Locations----END
	
	//-----POS DISCOUNTS-----CSR-----START
	public function get_discounts($id=null){
		$sql = "SELECT * FROM pos_discounts";
		if($id != null)
		$sql.=" WHERE id = '".$id."' ";
		$query = $this->db->query($sql);
		return $query->result();
	}
	//-----POS DISCOUNTS-----CSR-----END
	
	//-----STOCKS MASTER-----APM-----START
	//Get listing of products - active record
	public function get_stocks($id=null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('stock_master_new');
			if($id != null)
				$this->db->where('stock_id',$id);
				$this->db->where('inactive',0);
			$this->db->order_by('date_added DESC');
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	
	
	public function get_stocks_temp($id=null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('stock_master_new_temp');
			if($id != null)
				$this->db->where('stock_id',$id);
				$this->db->where('inactive',0);
			$this->db->order_by('date_added DESC');
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	
	public function get_purchaser_stocks($purchaser_id=null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('view_purchaser_stock_master');
			if($purchaser_id != null)
				$this->db->where('purchaser_id',$purchaser_id);
			$this->db->order_by('date_added DESC');
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	public function get_uom_qty($unit_code=null){
		// if ($unit_code != null){
			// $sql = "SELECT qty FROM stock_uoms_new WHERE unit_code = '$unit_code' ";
			$sql = "SELECT qty FROM stock_uoms WHERE unit_code = '$unit_code' ";
			// echo $sql."<br>";
			$query = $this->db->query($sql);
			$row = $query->row();
			if ($row != null)
				return $row->qty;
			else
				return false;
		// }else
			// return false;
	}
	public function get_branch_code_from_id($branch_id=null){
		// if ($unit_code != null){
			// $sql = "SELECT qty FROM stock_uoms_new WHERE unit_code = '$unit_code' ";
			$sql = "SELECT `code` AS branch_code FROM branches WHERE id = '$branch_id' ";
			// echo $sql."<br>";
			$query = $this->db->query($sql);
			$row = $query->row();
			if ($row != null)
				return $row->branch_code;
			else
				return false;
		// }else
			// return false;
	}
	public function write_stock_master_item($items){
		$this->db->insert('stock_master_new_temp',$items); //-----WITH APPROVAL ENABLED
		// $this->db->insert('stock_master_new',$items); //-----WITH APPROVAL DISABLED
		$x=$this->db->insert_id();
		return $x;
	}
	public function update_stock_master_item($items,$id){
		$this->db->where('stock_id', $id);
		// $this->db->update('stock_master_new_temp', $items); //-----WITH APPROVAL ENABLED
		$this->db->update('stock_master_new', $items); //-----WITH APPROVAL DISABLED
		return $this->db->last_query();
	}
	
	public function update_stock_master_item_temp($items,$id){
		$this->db->where('stock_id', $id);
		$this->db->update('stock_master_new_temp', $items); //-----WITH APPROVAL ENABLED
		return $this->db->last_query();
	}
	
	
	public function tax_type_id_to_name($id=''){
		$sql = "SELECT tax_type_name FROM stock_tax_types_new WHERE id = $id ";
		$query = $this->db->query($sql);
		$row = $query->row();
		if ($row != null)
		return $row->tax_type_name;
		return false;
	}
	public function category_short_desc($cat_id=''){
		$sql = "SELECT short_desc FROM stock_categories_new WHERE id = $cat_id ";
		$query = $this->db->query($sql);
		$row = $query->row();
		if ($row != null)
		return $row->short_desc;
		return false;
	}
	public function write_stock_barcode_item($items){
		
		$sql = "INSERT INTO stock_barcodes_new_temp (stock_id,
													barcode,
													short_desc,
													description,
													uom,
													qty,
													sales_type_id,
													inactive) 
													VALUES 
													('".$items['stock_id']."',
													 '".$items['barcode']."',
													 '".$items['short_desc']."',
													 '".$items['description']."',
													 '".$items['uom']."',
													 '".$items['qty']."',
													 '".$items['sales_type_id']."',
													 '".$items['inactive']."')
			ON DUPLICATE KEY UPDATE short_desc = '".$items['short_desc']."',description = '".$items['description']."' "; //-----WITH APPROVAL ENABLED
		$query = mysql_query($sql);
		
		$x=$this->db->insert_id();
		return $x;
		//return $sql;
		// $this->db->insert('stock_barcodes_new_temp',$items); //-----WITH APPROVAL ENABLED
		// // $this->db->insert('stock_barcodes_new',$items); //-----WITH APPROVAL DISABLED
		// $x=$this->db->insert_id();
		// return $x;
	}
	public function update_stock_barcode_item($items=array(), $barcode=null){
		$this->db->where('barcode', $barcode);
		$this->db->update('stock_barcodes_new',$items);
		$x=$this->db->insert_id();
		return $x;
	}
	public function write_stock_prices_logs($items){
		
			$affected_fields = 'barcode:'.$items['barcode'].'||sales_type_id:'.$items['sales_type_id'].'||price:'.$items['price'];
			
			$sql = "INSERT INTO stock_logs (
										type,
										barcode,
										branch,
										affected_tables,
										affected_field_values,
										old_field_values,
										modified_by
										)
										VALUES 
										('Update Price Details',
										 '".$items['barcode']."',
										 '".$items['branch_id']."',
										 'stock_barcode_prices',
										 '".$affected_fields."',
										 '',
										 ''
										 )";
						 $res  = mysql_query($sql);

	}
	
	public function write_stock_logs($items){

		$short_desc_stat = '';
		$description_stat = '';
		$affected_fields = '';
		$old_field_values = '';
		$res ='';
	if($items['short_desc'] != $items['short_desc_old'] ){
		$short_desc_stat = '1';
	}
	
	if($items['description'] != $items['desc_old'] ){
		$description_stat = '1';
	}
	
	if($short_desc_stat == '1' && $description_stat == '1'){
		
		$old_field_values = 'description:'.$items['desc_old'].'||short_desc:'.$items['short_desc_old'];
		$affected_fields = 'description:'.$items['description'].'||short_desc:'.$items['short_desc'];
		$sql = "INSERT INTO stock_logs (
										type,
										stock_id,
										barcode,
										branch,
										affected_tables,
										affected_field_values,
										old_field_values,
										modified_by
										)
										VALUES 
										('Update Stock Details',
										 '".$items['stock_id']."',
										 '".$items['barcode']."',
										 'All',
										 'stock_barcodes_new',
										 '".$affected_fields."',
										 '".$old_field_values."',
										 '".$items['user']."'
										 )";
						 $res  = mysql_query($sql);
		
	}else if($short_desc_stat == '1'){
		
		$old_field_values = 'short_desc:'.$items['short_desc_old'];
		$affected_fields = 'short_desc:'.$items['short_desc'];
		$sql = "INSERT INTO stock_logs (
										type,
										stock_id,
										barcode,
										branch,
										affected_tables,
										affected_field_values,
										old_field_values,
										modified_by
										)
										VALUES 
										('Update Stock Details',
										 '".$items['stock_id']."',
										 '".$items['barcode']."',
										 'All',
										 'stock_barcodes_new',
										 '".$affected_fields."',
										 '".$old_field_values."',
										 '".$items['user']."'
										 )";
						 $res  = mysql_query($sql);
		
	}else if($description_stat == '1'){
		$old_field_values = 'description:'.$items['desc_old'];
		$affected_fields = 'description:'.$items['description'];
		$sql = "INSERT INTO stock_logs (
										type,
										stock_id,
										barcode,
										branch,
										affected_tables,
										affected_field_values,
										old_field_values,
										modified_by
										)
										VALUES 
										('Update Stock Details',
										 '".$items['stock_id']."',
										 '".$items['barcode']."',
										 'All',
										 'stock_barcodes_new',
										 '".$affected_fields."',
										 '".$old_field_values."',
										 '".$items['user']."'
										 )";
						 $res  = mysql_query($sql);
		
	}
		
	return $res;
		
	}
	
	
	public function get_stock_barcodes($id=null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('stock_barcodes_new');
			if($id != null)
				$this->db->where('stock_id',$id);
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	
	public function get_stock_barcodes_temp($id=null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('stock_barcodes_new_temp');
			if($id != null)
				$this->db->where('stock_id',$id);
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	
	public function validate_barcode($barcode=null, $mode=null, $id=null){
		if($mode == 'add'){
			$sql = "SELECT * FROM stock_barcodes_new WHERE barcode = '$barcode'";
		}else{
			$sql = "SELECT * FROM stock_barcodes_new WHERE barcode = '$barcode' AND id != $id";
		}
		// echo "Mode --> $mode --- : ".$sql."<br>";
		$query = mysql_query($sql);
		if(mysql_num_rows($query) == 0)
			return false;
		return true;
	}
	public function barcode_exists_add_mode($barcode=null){
		$sql = "SELECT * FROM stock_barcodes_new WHERE barcode = '$barcode'";
		$query = mysql_query($sql);
		if(mysql_num_rows($query) == 0)
			return false;
		return true;
	}
	
	public function barcode_exists_add_mode_temp($barcode=null){
		$sql = "SELECT * FROM stock_barcodes_new_temp WHERE barcode = '$barcode'";
		$query = mysql_query($sql);
		if(mysql_num_rows($query) == 0)
			return false;
		return true;
	}
	public function barcode_exists_edit_mode($barcode=null, $id=null){
		$sql = "SELECT * FROM stock_barcodes_new WHERE barcode = '$barcode' AND stock_id != $id";
		$query = mysql_query($sql);
		if(mysql_num_rows($query) == 0)
			return false;
		return true;
	}
	
	public function barcode_exists_edit_mode_temp($barcode=null, $id=null){
		$sql = "SELECT * FROM stock_barcodes_new_temp WHERE barcode = '$barcode' AND stock_id != $id";
		$query = mysql_query($sql);
		if(mysql_num_rows($query) == 0)
			return false;
		return true;
	}
	
	public function stock_code_exists_add_mode($code=null){
		$sql = "SELECT * FROM stock_master_new WHERE stock_code = '$code'";
		$query = mysql_query($sql);
		if(mysql_num_rows($query) == 0)
			return false;
		return true;
	}
	public function stock_code_exists_edit_mode($code=null, $id=null){
		$sql = "SELECT * FROM stock_master_new WHERE stock_code = '$code' AND stock_id != $id";
		$query = mysql_query($sql);
		if(mysql_num_rows($query) == 0)
			return false;
		return true;
	}
	
	//rhan temp
	public function stock_code_exists_add_mode_temp($code=null){
		$sql = "SELECT * FROM stock_master_new_temp WHERE stock_code = '$code'";
		$query = mysql_query($sql);
		if(mysql_num_rows($query) == 0)
			return false;
		return true;
	}
	
	public function stock_code_exists_edit_mode_temp($code=null, $id=null){
		$sql = "SELECT * FROM stock_master_new_temp WHERE stock_code = '$code' AND stock_id != $id";
		$query = mysql_query($sql);
		if(mysql_num_rows($query) == 0)
			return false;
		return true;
	}
		//rhan end temp
	
	public function get_stock_barcode_details($id=null){
		$this->db->trans_start();
			$this->db->select('stock_barcodes_new.*');
			$this->db->from('stock_barcodes_new');
			if($id != null){
				$this->db->where('stock_barcodes_new.id',$id);
			}
			$this->db->order_by('stock_barcodes_new.id desc');

			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	public function get_sales_types($id=null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('sales_types');
			if($id != null)
				$this->db->where('id',$id);
			$this->db->where('inactive',0);
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	public function get_stock_barcode_prices($barcode=null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('stock_barcode_prices a');
			$this->db->join('stock_barcodes_new b','b.barcode = a.barcode', 'LEFT');
			if($barcode != null)
				$this->db->where('b.barcode',$barcode);
			$query = $this->db->get();
			$result = $query->result();
		// echo $this->db->last_query()."<br>";
		$this->db->trans_complete();
		return $result;
	}
	public function get_stock_barcode_prices_pk_id($barcode=null, $branch_id=null, $sales_type_id=null){
		// $this->db->trans_start();
			// $this->db->select('a.id');
			// $this->db->from('stock_barcode_prices a');
			// $this->db->join('stock_barcodes_new b','b.barcode = a.barcode', 'LEFT');
			// if($barcode != null)
				// $this->db->where('b.barcode',$barcode);
			// if($branch_id != null)
				// $this->db->where('a.branch_id',$branch_id);
			// if($sales_type_id != null)
				// $this->db->where('a.sales_type_id',$sales_type_id);
			// $query = $this->db->get();
			// $result = $query->result();
			// // echo $this->db->last_query()."<br>";
		// $this->db->trans_complete();
		// return $result;
		
		$sql = "SELECT a.id AS pk_id FROM stock_barcode_prices a LEFT JOIN stock_barcodes_new b ON b.barcode = a.barcode";
		if($barcode != null)
			$sql .= " WHERE b.barcode = '$barcode'";
		if($branch_id != null)
			$sql .= " AND a.branch_id = $branch_id";
		if($sales_type_id != null)
			$sql .= " AND a.sales_type_id = $sales_type_id";
		$query = $this->db->query($sql);
		$row = $query->row();
		// echo $sql."<br>";
		if ($row != null)
			return $row->pk_id;
		else
			return false;
	}
	public function get_stock_cost_of_sales($stock_id=null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('stock_cost_of_sales');
			// $this->db->join('stock_barcodes_new b','b.barcode = a.barcode', 'LEFT');
			if($stock_id != null)
				$this->db->where('stock_id',$stock_id);
			$query = $this->db->get();
			$result = $query->result();
			// echo $this->db->last_query()."<br>";
		$this->db->trans_complete();
		return $result;
	}
	
	public function get_stock_cost_of_sales_temp($stock_id=null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('stock_cost_of_sales_temp');
			// $this->db->join('stock_barcodes_new b','b.barcode = a.barcode', 'LEFT');
			if($stock_id != null)
				$this->db->where('stock_id',$stock_id);
			$query = $this->db->get();
			$result = $query->result();
			// echo $this->db->last_query()."<br>";
		$this->db->trans_complete();
		return $result;
	}
	
	public function get_complete_stock_barcode_prices($barcode=null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('stock_barcode_prices a');
			$this->db->join('stock_barcodes_new b','b.barcode = a.barcode', 'LEFT');
			$this->db->join('supplier_stocks c','c.stock_id = b.stock_id AND c.uom = b.uom', 'LEFT');
			if($barcode != null)
				$this->db->where('b.barcode',$barcode);
			$query = $this->db->get();
			$result = $query->result();
			// echo $this->db->last_query()."<br>";
		$this->db->trans_complete();
		return $result;
	}
	public function write_stock_barcode_price($items){
		//-----ORIG
		// $this->db->insert('stock_barcode_prices',$items);
		// $x=$this->db->insert_id();
		// return $x;
		//-----
		$sql = "INSERT INTO stock_barcode_prices_temp (barcode,sales_type_id,price,branch_id) VALUES ('".$items['barcode']."','".$items['sales_type_id']."','".$items['price']."','".$items['branch_id']."')
					  ON DUPLICATE KEY UPDATE price=".$items['price']; //-----WITH APPROVAL ENABLED
		// $sql = "INSERT INTO stock_barcode_prices (barcode,sales_type_id,price,branch_id) VALUES ('".$items['barcode']."','".$items['sales_type_id']."','".$items['price']."','".$items['branch_id']."')
					  // ON DUPLICATE KEY UPDATE price=".$items['price']; //-----WITH APPROVAL DISABLED
		// echo "SQL : ".$sql."<br>";
		$query = mysql_query($sql);
		$x=$this->db->insert_id();
		return $x;
	}
	public function write_stock_cost_of_sales($items){
		//-----ORIG
		// $this->db->insert('stock_cost_of_sales',$items);
		// $x=$this->db->insert_id();
		// return $x;
		//-----
		$sql = "INSERT INTO stock_cost_of_sales_temp (stock_id,branch_id,cost_of_sales) VALUES (".$items['stock_id'].",".$items['branch_id'].",".$items['cost_of_sales'].")
					  ON DUPLICATE KEY UPDATE cost_of_sales=".$items['cost_of_sales']; //-----WITH APPROVAL ENABLED
		// $sql = "INSERT INTO stock_cost_of_sales (stock_id,branch_id,cost_of_sales) VALUES (".$items['stock_id'].",".$items['branch_id'].",".$items['cost_of_sales'].")
					  // ON DUPLICATE KEY UPDATE cost_of_sales=".$items['cost_of_sales']; //-----WITH APPROVAL DISABLED
		// echo "SQL : ".$sql."<br>";
		$query = mysql_query($sql);
		$x=$this->db->insert_id();
		return $x;
	}
	
	public function update_stock_cost_of_sales($items){
		//-----ORIG
		// $this->db->insert('stock_cost_of_sales',$items);
		// $x=$this->db->insert_id();
		// return $x;
		//-----
		$sql = "INSERT INTO stock_cost_of_sales (stock_id,branch_id,cost_of_sales) VALUES (".$items['stock_id'].",".$items['branch_id'].",".$items['cost_of_sales'].")
					  ON DUPLICATE KEY UPDATE cost_of_sales=".$items['cost_of_sales']; //-----WITH APPROVAL ENABLED
		// $sql = "INSERT INTO stock_cost_of_sales (stock_id,branch_id,cost_of_sales) VALUES (".$items['stock_id'].",".$items['branch_id'].",".$items['cost_of_sales'].")
					  // ON DUPLICATE KEY UPDATE cost_of_sales=".$items['cost_of_sales']; //-----WITH APPROVAL DISABLED
		// echo "SQL : ".$sql."<br>";
		$query = mysql_query($sql);
		$x=$this->db->insert_id();
		return $x;
	}
	
	public function update_stock_barcode_price($items,$id){
		//-----IF checker = ID
		// $this->db->where('stock_id', $id);
		// $this->db->update('stock_barcode_prices', $items);
		//-----IF checker = BARCODE
		$this->db->where('barcode', $id);
		$this->db->update('stock_barcode_prices', $items);

		return $this->db->last_query();
	}
	public function write_branch_stocks_temp($items){
		$sql = "INSERT INTO branch_stocks_temp (stock_id,branch_id,qty,stock_loc_id) VALUES (".$items['stock_id'].",".$items['branch_id'].",".$items['qty'].",".$items['stock_loc_id'].")"; //-----WITH APPROVAL ENABLED
		// $sql = "INSERT INTO stock_cost_of_sales (stock_id,branch_id,cost_of_sales) VALUES (".$items['stock_id'].",".$items['branch_id'].",".$items['cost_of_sales'].")
					  // ON DUPLICATE KEY UPDATE cost_of_sales=".$items['cost_of_sales']; //-----WITH APPROVAL DISABLED
		// echo "SQL : ".$sql."<br>";
		$query = mysql_query($sql);
		$x=$this->db->insert_id();
		//return $x;
		return $sql;
	}
	public function write_branch_stocks($items){
		$sql = "INSERT INTO branch_stocks (stock_id,branch_id,qty,cost_of_sales) VALUES (".$items['stock_id'].",".$items['branch_id'].",".$items['qty'].",".$items['cost_of_sales'].")"; //-----WITH APPROVAL ENABLED
		// $sql = "INSERT INTO stock_cost_of_sales (stock_id,branch_id,cost_of_sales) VALUES (".$items['stock_id'].",".$items['branch_id'].",".$items['cost_of_sales'].")
					  // ON DUPLICATE KEY UPDATE cost_of_sales=".$items['cost_of_sales']; //-----WITH APPROVAL DISABLED
		// echo "SQL : ".$sql."<br>";
		$query = mysql_query($sql);
		$x=$this->db->insert_id();
		return $x;
	}
	public function validate_barcode_price($barcode=null, $sales_type_id=null){
		$sql = "SELECT * FROM stock_barcode_prices WHERE barcode = '$barcode' AND sales_type_id = $sales_type_id";
		$query = mysql_query($sql);
		if(mysql_num_rows($query) == 0)
			return false;
		return true;
	}
	public function get_pos_discount_types($id=null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('pos_discounts');
			if($id != null)
				$this->db->where('id',$id);
			$this->db->where('inactive',0);
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	
	
	
	
	//--->rhan
	
	public function validate_stock_discount_temp($stock_id=null, $pos_discount_id=null){
		$sql = "SELECT * FROM pos_stock_discounts_temp WHERE stock_id = '$stock_id' AND pos_discount_id = $pos_discount_id";
		$query = mysql_query($sql);
		if(mysql_num_rows($query) == 0)
			return false;
		return true;
	}
	
	//end
	public function get_pos_discount_types_per_stock($stock_id=null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('pos_stock_discounts');
			$this->db->join('pos_discounts','pos_discounts.id = pos_stock_discounts.pos_discount_id');
			if($stock_id != null)
				$this->db->where('pos_stock_discounts.stock_id',$stock_id);
			$this->db->where('pos_stock_discounts.inactive',0);
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	public function is_discount_type_enabled_temp($stock_id=null, $pos_discount_id=null){
		$sql = "SELECT pos_discount_id, disc_enabled FROM pos_stock_discounts_temp WHERE stock_id = '$stock_id' AND pos_discount_id = $pos_discount_id";
		$query = $this->db->query($sql);
		$row = $query->row();
		// echo $sql."<br>";
		// echo 'Value of '.$row->pos_discount_id.' : '.$row->disc_enabled."<br>";
		if ($row != null)
		return $row->disc_enabled;
		return false;
	}
	public function is_discount_type_enabled($stock_id=null, $pos_discount_id=null){
		$sql = "SELECT pos_discount_id, disc_enabled FROM pos_stock_discounts WHERE stock_id = '$stock_id' AND pos_discount_id = $pos_discount_id";
		$query = $this->db->query($sql);
		$row = $query->row();
		// echo $sql."<br>";
		// echo 'Value of '.$row->pos_discount_id.' : '.$row->disc_enabled."<br>";
		if ($row != null)
		return $row->disc_enabled;
		return false;
	}
	public function get_customer_card_types($id=null){
		$this->db->trans_start();
		$sql = "SELECT * FROM customer_card_types";
		$query = $this->db->query($sql);
		$result = $query->result();
		$this->db->trans_complete();
		 return $result;
	}

	
	public function get_customer_card_types_wo_sukicard($id=null){
		$this->db->trans_start();
		$sql = "SELECT * FROM customer_card_types WHERE name != 'SUKICARD' ";
		$query = $this->db->query($sql);
		$result = $query->result();
		$this->db->trans_complete();
		 return $result;
	}
	public function get_customer_card_types_w_sukicard($id=null){
		$this->db->trans_start();
		$sql = "SELECT * FROM customer_card_types WHERE name = 'SUKICARD' ";
		$query = $this->db->query($sql);
		$result = $query->result();
		$this->db->trans_complete();
		 return $result;
	}
	
	public function is_card_type_enabled_temp($stock_id=null, $card_type_id=null){
		$sql = "SELECT card_type_id, is_enabled FROM pos_stock_cards_temp WHERE stock_id = '$stock_id' AND card_type_id = $card_type_id";
		$query = $this->db->query($sql);
		$row = $query->row();
		// echo $sql."<br>";
		// echo 'Value of '.$row->card_type_id.' : '.$row->is_enabled."<br>";
		if ($row != null)
		return $row->is_enabled;
		return false;
	}
	
	public function is_card_type_enabled($stock_id=null, $card_type_id=null){
		$sql = "SELECT card_type_id, is_enabled FROM pos_stock_cards WHERE stock_id = '$stock_id' AND card_type_id = $card_type_id";
		$query = $this->db->query($sql);
		$row = $query->row();
		// echo $sql."<br>";
		// echo 'Value of '.$row->card_type_id.' : '.$row->is_enabled."<br>";
		if ($row != null)
		return $row->is_enabled;
		return false;
	}
	public function write_stock_discount($items){
		$this->db->insert('pos_stock_discounts_temp',$items);  //-----WITH APPROVAL ENABLED
		// $this->db->insert('pos_stock_discounts',$items);  //-----WITH APPROVAL DISABLED
		$x=$this->db->insert_id();
		return $x;
	}
	
	public function update_stock_discount_temp($items,$id,$disc_type_id){
		//-----IF checker = ID
		// $this->db->where('stock_id', $id);
		// $this->db->update('stock_barcode_prices', $items);
		//-----IF checker = BARCODE
		$this->db->where('stock_id', $id);
		$this->db->where('pos_discount_id', $disc_type_id);
		// $this->db->update('pos_stock_discounts_temp', $items);  //-----WITH APPROVAL ENABLED
		$this->db->update('pos_stock_discounts_temp', $items);  //-----WITH APPROVAL DISABLED
		// echo $this->db->last_query()."<br>";
		return $this->db->last_query();
	}
	
	
	public function update_stock_discount($items,$id,$disc_type_id){
		//-----IF checker = ID
		// $this->db->where('stock_id', $id);
		// $this->db->update('stock_barcode_prices', $items);
		//-----IF checker = BARCODE
		$this->db->where('stock_id', $id);
		$this->db->where('pos_discount_id', $disc_type_id);
		// $this->db->update('pos_stock_discounts_temp', $items);  //-----WITH APPROVAL ENABLED
		$this->db->update('pos_stock_discounts', $items);  //-----WITH APPROVAL DISABLED
		// echo $this->db->last_query()."<br>";
		return $this->db->last_query();
	}
	public function validate_stock_discount($stock_id=null, $pos_discount_id=null){
		$sql = "SELECT * FROM pos_stock_discounts WHERE stock_id = '$stock_id' AND pos_discount_id = $pos_discount_id";
		$query = mysql_query($sql);
		if(mysql_num_rows($query) == 0)
			return false;
		return true;
	}
	public function validate_stock_card_type($stock_id=null, $card_type_id=null){
		$sql = "SELECT * FROM pos_stock_cards WHERE stock_id = '$stock_id' AND card_type_id = $card_type_id";
		$query = mysql_query($sql);
		// echo $sql."<br>";
		if(mysql_num_rows($query) == 0)
			return false;
		return true;
	}
	
	public function validate_stock_card_type_temp($stock_id=null, $card_type_id=null){
		$sql = "SELECT * FROM pos_stock_cards_temp WHERE stock_id = '$stock_id' AND card_type_id = $card_type_id";
		$query = mysql_query($sql);
		// echo $sql."<br>";
		if(mysql_num_rows($query) == 0)
			return false;
		return true;
	}
	
	
	public function write_stock_card_type($items){
		$this->db->insert('pos_stock_cards_temp',$items);  //-----WITH APPROVAL ENABLED
		// $this->db->insert('pos_stock_cards',$items);  //-----WITH APPROVAL DISABLED
		$x=$this->db->insert_id();
		return $x;
	}
	public function update_stock_card_type($items,$id,$card_type_id){
		//-----IF checker = ID
		// $this->db->where('stock_id', $id);
		// $this->db->update('stock_barcode_prices', $items);
		//-----IF checker = BARCODE
		$this->db->where('stock_id', $id);
		$this->db->where('card_type_id', $card_type_id);
		// $this->db->update('pos_stock_cards_temp', $items);  //-----WITH APPROVAL ENABLED
		$this->db->update('pos_stock_cards', $items);  //-----WITH APPROVAL DISABLED
		// echo $this->db->last_query()."<br>";
		return $this->db->last_query();
	}
	
	public function update_stock_card_type_temp($items,$id,$card_type_id){
		//-----IF checker = ID
		// $this->db->where('stock_id', $id);
		// $this->db->update('stock_barcode_prices', $items);
		//-----IF checker = BARCODE
		$this->db->where('stock_id', $id);
		$this->db->where('card_type_id', $card_type_id);
		// $this->db->update('pos_stock_cards_temp', $items);  //-----WITH APPROVAL ENABLED
		$this->db->update('pos_stock_cards_temp', $items);  //-----WITH APPROVAL DISABLED
		// echo $this->db->last_query()."<br>";
		return $this->db->last_query();
	}
	
	
	public function get_active_branches($id=null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('branches');
			if($id != null)
				$this->db->where('id',$id);
			$this->db->where('inactive',0);
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	public function get_scheduled_markdown($barcode=null, $sale_type_id=null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('stock_barcode_scheduled_markdown');
			$this->db->where('barcode',$barcode);
			$this->db->where('sales_type_id',$sale_type_id);
			$this->db->where('inactive',0);
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	
	public function get_marginal_markdown($stock_id=null,$barcode=null,$branch_id=null,$sales_type_id=null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('stock_barcode_marginal_markdown');
			$this->db->where('stock_id',$stock_id);
			$this->db->where('barcode',$barcode);
			$this->db->where('sales_type_id',$sales_type_id);
			$this->db->where('branch_id',$branch_id);
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	
	public function get_branch_name($id=null){
		$sql = "SELECT code FROM branches WHERE id=".$id;
		$query = mysql_query($sql);
		$result = mysql_fetch_object($query); 
		return $result->code;
	}
	public function price_per_sales_type_and_branch($barcode=null, $sales_type_id=null, $branch_id=null){
		$sql = "SELECT price FROM stock_barcode_prices WHERE barcode = '$barcode' AND sales_type_id = $sales_type_id AND branch_id = $branch_id";
		$query = $this->db->query($sql);
		$row = $query->row();
		// echo $sql."<br>";
		// echo 'Value of '.$row->pos_discount_id.' : '.$row->disc_enabled."<br>";
		if ($row != null)
		return $row->price;
		return false;
	}
	
	//rhan start get sales_type name
	public function get_sales_type($id=null){
		$sql = "SELECT sales_type FROM sales_types WHERE id=".$id;
		$query = mysql_query($sql);
		$result = mysql_fetch_object($query); 
		return $result->sales_type;
	}
	//rhan end 
	public function get_supplier_stocks_temp($id=null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('supplier_stocks_temp');
			if($id != null)
				$this->db->where('stock_id',$id);
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
		
	}
	
	public function get_supplier_stocks($id=null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('supplier_stocks');
			if($id != null)
				$this->db->where('stock_id',$id);
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}

	//check data
	public function check_supplier_stocks($stock_id=null,$br_id = null)
	{
		
		$sql = "SELECT * FROM supplier_stocks WHERE stock_id = ".$stock_id." AND branch_id = ".$br_id." AND is_default = '1' ";
		$query  = mysql_query($sql);
		$rows = mysql_num_rows($query);
		
		return  $rows;
		// $this->db->select('*');
		// $this->db->from('supplier_stocks');
		// if ($stock_id)
			// $this->db->where('stock_id',$stock_id);
			// $this->db->where('branch_id',$br_id);
			// $this->db->where('is_default',1);
		// $query = $this->db->get();
	// //	return $query->result();
		// return $query->result();
	}
	//end
	
	public function get_supplier_stocks_detail($id=null, $supp_stock_id=null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('supplier_stocks');
			if($id != null)
				$this->db->where('stock_id',$id);
			if($supp_stock_id != null)
				$this->db->where('id',$supp_stock_id);
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	public function write_supplier_stock_item($items){
		$this->db->insert('supplier_stocks_temp',$items);
		// echo $this->db->last_query()."<br>";
		$x=$this->db->insert_id();
		return $x;
	}
	public function write_supplier_stock_item_all_branches($items){
		// $sql = "INSERT INTO stock_barcode_prices (barcode,sales_type_id,price,branch_id) VALUES ('".$items['barcode']."','".$items['sales_type_id']."','".$items['price']."','".$items['branch_id']."')
					  // ON DUPLICATE KEY UPDATE price=".$items['price'];
		$sql = "INSERT INTO supplier_stocks_temp (stock_id,supp_stock_code,description,supp_id,branch_id,uom,qty,unit_cost,disc_percent1,disc_percent2,disc_percent3,disc_amount1,disc_amount2,disc_amount3,avg_cost,net_cost,avg_net_cost,is_default,inactive,added_by,datetime_added) 
		VALUES (".$items['stock_id'].",'".$items['supp_stock_code']."','".$items['description']."',".$items['supp_id'].",".$items['branch_id'].",'".$items['uom']."',".$items['qty'].",".$items['unit_cost'].",".$items['disc_percent1'].",".$items['disc_percent2'].",".$items['disc_percent3'].",".$items['disc_amount1'].",".$items['disc_amount2'].",".$items['disc_amount3'].",".$items['avg_cost'].",".$items['net_cost'].",".$items['avg_net_cost'].",".$items['is_default'].",".$items['inactive'].",".$items['added_by'].",'".$items['datetime_added']."')
					  ON DUPLICATE KEY UPDATE supp_stock_code='".$items['supp_stock_code']."', 
					  description='".$items['description']."',
					  supp_id=".$items['supp_id'].",
					  branch_id=".$items['branch_id'].",
					  uom='".$items['uom']."',
					  qty=".$items['qty'].",
					  unit_cost=".$items['unit_cost'].",
					  disc_percent1=".$items['disc_percent1'].",
					  disc_percent2=".$items['disc_percent2'].",
					  disc_percent3=".$items['disc_percent3'].",
					  disc_amount1=".$items['disc_amount1'].",
					  disc_amount2=".$items['disc_amount2'].",
					  disc_amount3=".$items['disc_amount3'].",
					  avg_cost=".$items['avg_cost'].",
					  net_cost=".$items['net_cost'].",
					  avg_net_cost=".$items['avg_net_cost'].",
					  is_default=".$items['is_default'].",
					  inactive=".$items['inactive']." ,
					  added_by=".$items['added_by']." ,
					  datetime_added='".$items['datetime_added']."' ";
		// echo "SQL : ".$sql."<br>";
		$query = mysql_query($sql);
		$x=$this->db->insert_id();
		return $x;
	}
	public function update_supplier_stock_item($items=array(), $id=null){
		$this->db->where('id', $id);
		$this->db->update('supplier_stocks_temp',$items);
		// $x=$this->db->insert_id();
		// return $x;
		return $this->db->last_query();
	}
	public function get_branch_code($br_id=''){
		$sql = "SELECT code FROM branches WHERE id = $br_id ";
		$query = $this->db->query($sql);
		$row = $query->row();
		if ($row != null)
		return $row->code;
		return false;
	}
	public function get_branch_id_from_code($code=null){
		// if ($unit_code != null){
			$sql = "SELECT id FROM branches WHERE code = '$code' ";
			// echo $sql."<br>";
			$query = $this->db->query($sql);
			$row = $query->row();
			// echo $sql."<br>";
			if ($row != null)
				return $row->id;
			else
				return false;
		// }else
			// return false;
	}
	public function get_supp_name_from_id($supplier_id=null){
		// if ($unit_code != null){
			$sql = "SELECT supp_name FROM supplier_master WHERE supplier_id = '$supplier_id' ";
			// echo $sql."<br>";
			$query = $this->db->query($sql);
			$row = $query->row();
			// echo $sql."<br>";
			if ($row != null)
				return $row->supp_name;
			else
				return false;
		// }else
			// return false;
	}
	public function get_uom_code($code=null){
		// if ($unit_code != null){
			$sql = "SELECT unit_code FROM stock_uoms WHERE unit_code = '$code' ";
			// echo $sql."<br>";
			$query = $this->db->query($sql);
			$row = $query->row();
			// echo $sql."<br>";
			if ($row != null)
				return $row->unit_code;
			else
				return false;
		// }else
			// return false;
	}
	public function get_supp_id_from_name($code=null){
		// if ($unit_code != null){
			$sql = "SELECT supplier_id FROM supplier_master WHERE supp_name = '$code' ";
			// echo $sql."<br>";
			$query = $this->db->query($sql);
			$row = $query->row();
			// echo $sql."<br>";
			if ($row != null)
				return $row->supplier_id;
			else
				return false;
		// }else
			// return false;
	}
	public function supp_stock_exists_add_mode($supp_stock_code=null, $uom=null){
		$sql = "SELECT * FROM supplier_stocks WHERE supp_stock_code = '$supp_stock_code' AND uom='$uom'";
		$query = mysql_query($sql);
		// echo $sql."<hr><br>";
		if(mysql_num_rows($query) == 0)
			return false;
		return true;
	}
	public function supp_stock_exists_edit_mode($supp_stock_code=null, $uom=null, $id=null){
		$sql = "SELECT * FROM supplier_stocks WHERE supp_stock_code = '$supp_stock_code' AND uom='$uom' AND id != $id";
		$query = mysql_query($sql);
		// echo $sql."<hr><br>";
		if(mysql_num_rows($query) == 0)
			return false;
		return true;
	}
	
	public function get_all_supplier_stocks_temp($id=null){
		$this->db->trans_start();
			$this->db->select('
			a.stock_id,
			a.stock_code,
			a.category_id,
			a.tax_type_id,
			a.description AS sm_desc,
			a.report_uom AS sm_uom,
			a.report_qty AS sm_qty,
			b.id AS ss_id,
			b.stock_id AS ss_stock_id,
			b.supp_stock_code,
			b.description AS ss_desc,
			b.supp_id,
			b.branch_id,
			b.uom AS ss_uom,
			b.unit_cost,
			b.disc_percent1,
			b.disc_percent2,
			b.disc_percent3,
			b.disc_amount1,
			b.disc_amount2,
			b.disc_amount3,
			b.avg_cost,
			b.net_cost,
			b.avg_net_cost
			');
			$this->db->from('stock_master_new_temp a');
			// $this->db->join('supplier_stocks b','b.stock_id = a.stock_id'); //-----ORIGINAL
			$this->db->join('supplier_stocks_temp b','b.stock_id = a.stock_id', 'LEFT');
			if($id != null)
				$this->db->where('a.stock_id',$id);
			
			$this->db->group_by('b.stock_id');
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	
	
	public function get_all_supplier_stocks($id=null){
		$this->db->trans_start();
			$this->db->select('
			a.stock_id,
			a.stock_code,
			a.category_id,
			a.tax_type_id,
			a.description AS sm_desc,
			a.report_uom AS sm_uom,
			a.report_qty AS sm_qty,
			b.id AS ss_id,
			b.stock_id AS ss_stock_id,
			b.supp_stock_code,
			b.description AS ss_desc,
			b.supp_id,
			b.branch_id,
			b.uom AS ss_uom,
			b.unit_cost,
			b.disc_percent1,
			b.disc_percent2,
			b.disc_percent3,
			b.disc_amount1,
			b.disc_amount2,
			b.disc_amount3,
			b.avg_cost,
			b.net_cost,
			b.avg_net_cost
			');
			$this->db->from('stock_master_new a');
			// $this->db->join('supplier_stocks b','b.stock_id = a.stock_id'); //-----ORIGINAL
			$this->db->join('supplier_stocks b','b.stock_id = a.stock_id', 'LEFT');
			if($id != null)
				$this->db->where('a.stock_id',$id);
			
			$this->db->group_by('b.stock_id');
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	public function get_stock_cost_details($stock_id=null, $branch_id=null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('supplier_stocks');
			$this->db->join('stock_barcodes_new','stock_barcodes_new.stock_id = supplier_stocks.stock_id AND stock_barcodes_new.uom = supplier_stocks.uom');
			if($stock_id != null)
				$this->db->where('supplier_stocks.stock_id',$stock_id);
			if($branch_id != null)
				$this->db->where('supplier_stocks.branch_id ',$branch_id);
			$this->db->where('supplier_stocks.is_default ','1');
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	public function get_branch_stock_cost_of_sales($stock_id=null, $branch_id=null){
		// if ($unit_code != null){
			$sql = "SELECT cost_of_sales FROM stock_cost_of_sales WHERE stock_id = '$stock_id' AND branch_id = $branch_id";
			// echo $sql."<br>";
			$query = $this->db->query($sql);
			$row = $query->row();
			// echo $sql."<br>";
			if ($row != null)
				return $row->cost_of_sales;
			else
				return false;
		// }else
			// return false;
	}
	
	public function get_branch_stock_cost_of_sales_temp($stock_id=null, $branch_id=null){
		// if ($unit_code != null){
			$sql = "SELECT cost_of_sales FROM stock_cost_of_sales_temp WHERE stock_id = '$stock_id' AND branch_id = $branch_id";
			// echo $sql."<br>";
			$query = $this->db->query($sql);
			$row = $query->row();
			// echo $sql."<br>";
			if ($row != null)
				return $row->cost_of_sales;
			else
				return false;
		// }else
			// return false;
	}
	public function get_stock_id_from_barcode($barcode=null){
		// if ($unit_code != null){
			$sql = "SELECT stock_id FROM stock_barcodes_new WHERE barcode = '$barcode' ";
			// echo $sql."<br>";
			$query = $this->db->query($sql);
			$row = $query->row();
			// echo $sql."<br>";
			if ($row != null)
				return $row->stock_id;
			else
				return false;
		// }else
			// return false;
	}
	
	// public function write_marginal($items){
		// $this->db->insert('stock_barcode_marginal_markdown',$items);
		// $x=$this->db->insert_id();
		// return $x;
	// }
	
	public function write_marginal($items){
		$sql = "INSERT INTO stock_barcode_marginal_markdown_temp(stock_id,
															barcode,
															branch_id,
															sales_type_id,
															qty,
															markup,
															unit_price,
															datetime_added,
															modified_by) 
		VALUES (".$items['stock_id'].",'".$items['barcode']."',".$items['branch_id'].",".$items['sales_type_id'].",".$items['qty'].",'".$items['markup']."','".$items['unit_price']."','".date("Y-m-d H:i:s")."','".$items['modified_by']."')
					  ON DUPLICATE KEY UPDATE qty='".$items['qty']."', 
					  markup=".$items['markup'].",
					  unit_price='".$items['unit_price']."'";
		$query = mysql_query($sql);
		$x=$this->db->insert_id();
		return $x;
	}

	
	public function write_sched_stock_barcode_markdown($items){
		$this->db->insert('stock_barcode_scheduled_markdown_temp',$items);
		// echo $this->db->last_query()."<br>";
		$x=$this->db->insert_id();
		return $x;
	}
	public function write_sched_stock_barcode_markdown_all_branches($items){
		
		$sql = "INSERT INTO stock_barcode_scheduled_markdown_temp (stock_id,barcode,branch_id, sales_type_id,start_date,end_date,start_time,end_time,markdown,original_price,discounted_price,datetime_added,added_by,inactive) 
		VALUES (".$items['stock_id'].",'".$items['barcode']."',".$items['branch_id'].", ".$items['sales_type_id'].",'".$items['start_date']."','".$items['end_date']."','".$items['start_time']."','".$items['end_time']."',".$items['markdown'].",".$items['original_price'].",".$items['discounted_price'].",'".$items['datetime_added']."',".$items['added_by'].",".$items['inactive'].")
					  ON DUPLICATE KEY UPDATE branch_id='".$items['branch_id']."', 
					  sales_type_id=".$items['sales_type_id'].",
					  start_date='".$items['start_date']."',
					  end_date='".$items['end_date']."',
					  start_time='".$items['start_time']."',
					  end_time='".$items['end_time']."',
					  markdown=".$items['markdown'].",
					  original_price=".$items['original_price'].",
					  discounted_price=".$items['discounted_price'].",
					  datetime_added='".$items['datetime_added']."',
					  added_by=".$items['added_by'].",
					  inactive=".$items['inactive']." ";
		// echo "SQL : ".$sql."<br>";
		$query = mysql_query($sql);
		$x=$this->db->insert_id();
		return $x;
	}
	public function write_stock_barcode_srp_all_branches($items){
		$sql = "INSERT INTO stock_barcode_prices_temp (barcode, sales_type_id, price, branch_id, computed_srp, prevailing_unit_price, landed_cost_markup, cost_of_sales_markup) 
		VALUES ('".$items['barcode']."','".$items['sales_type_id']."',".$items['price'].", ".$items['branch_id'].", ".$items['computed_srp'].", ".$items['prevailing_unit_price'].", ".$items['landed_cost_markup'].", ".$items['cost_of_sales_markup'].")
					  ON DUPLICATE KEY UPDATE branch_id='".$items['branch_id']."', 
					  sales_type_id=".$items['sales_type_id'].",
					  price=".$items['price'].",
					  computed_srp=".$items['computed_srp'].",
					  prevailing_unit_price=".$items['prevailing_unit_price'].",
					  landed_cost_markup=".$items['landed_cost_markup'].",
					  cost_of_sales_markup=".$items['cost_of_sales_markup']." ";  //-----WITH APPROVAL ENABLED
		// $sql = "INSERT INTO stock_barcode_prices (barcode, sales_type_id, price, branch_id, computed_srp, prevailing_unit_price, landed_cost_markup, cost_of_sales_markup) 
		// VALUES ('".$items['barcode']."','".$items['sales_type_id']."',".$items['price'].", ".$items['branch_id'].", ".$items['computed_srp'].", ".$items['prevailing_unit_price'].", ".$items['landed_cost_markup'].", ".$items['cost_of_sales_markup'].")
					  // ON DUPLICATE KEY UPDATE branch_id='".$items['branch_id']."', 
					  // sales_type_id=".$items['sales_type_id'].",
					  // price=".$items['price'].",
					  // computed_srp=".$items['computed_srp'].",
					  // prevailing_unit_price=".$items['prevailing_unit_price'].",
					  // landed_cost_markup=".$items['landed_cost_markup'].",
					  // cost_of_sales_markup=".$items['cost_of_sales_markup']." ";  //-----WITH APPROVAL DISABLED
		// echo "SQL : ".$sql."<br>";
		$query = mysql_query($sql);
		$x=$this->db->insert_id();
		return $x;
	}
	//-----STOCKS MASTER-----APM-----END
	//-----AUDIT TRAIL-----APM-----START
	public function write_to_audit_trail($items=array())
	{
		$this->db->insert('audit_trail',$items);
		$id = $this->db->insert_id();
		return $id;
	}
	//-----AUDIT TRAIL-----APM-----END
	

	public function write_to_barcode_prices_approval($items=array())
	{
		$this->db->insert('stock_barcode_prices_approval',$items);
		$id = $this->db->insert_id();
		return $id;
	}

	
	//start mms stock_logs
	public function write_to_stock_logs_for_sm($items=array())
	{
		$this->db->insert('stock_logs',$items);
		$id = $this->db->insert_id();
		return $id;
	}
	//end
	//rhan get barcode prices in temp table 
	public function get_stock_barcode_prices_temp($barcode=null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('stock_barcode_prices_temp a');
			$this->db->join('stock_barcodes_new_temp b','b.barcode = a.barcode', 'LEFT');
			if($barcode != null)
				$this->db->where('b.barcode',$barcode);
			$query = $this->db->get();
			$result = $query->result();
			// echo $this->db->last_query()."<br>";
		$this->db->trans_complete();
		return $result;
	}	
	
	// rhan end
	//-----Movement Types Maintenance-----START
	public function get_movement_types($id=null){
		$sql = "SELECT * FROM movement_types";
		if($id != null)
		$sql.=" WHERE movement_type_id = ".$id." ";
		$query = $this->db->query($sql);
		return $query->result();
	}
	public function movement_type_exist_add_mode($description=null){
		$sql = "SELECT * FROM movement_types WHERE description = '$description'";
		$query = mysql_query($sql);
		if(mysql_num_rows($query) == 0)
			return false;
		return true;
	}
	public function movement_type_exist_edit_mode($description=null, $movement_type_id=null){
		$sql = "SELECT * FROM movement_types WHERE description = '$description' AND movement_type_id != $movement_type_id";
		$query = mysql_query($sql);
		if(mysql_num_rows($query) == 0)
			return false;
		return true;
	}
	//Insert to DB
	public function add_movement_type($items)
	{
		// $this->db->set('reg_date','NOW()',FALSE);
		$this->db->insert('movement_types',$items);
		return $this->db->insert_id();
	}
	//Update DB
	public function update_movement_type($items,$id){
		$this->db->where('movement_type_id', $id);
		$this->db->update('movement_types', $items);
	}
	//-----Movement Types Maintenance-----END
	public function get_movements_details_approval($ref=null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('movements');
			$this->db->join('movement_details', 'movements.id = movement_details.header_id');
			if($ref != null)
				$this->db->where('movement_details.stock_id',$ref);
				$this->db->where('status = 2');
				$this->db->order_by('date_posted DESC');
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	public function get_search_movements_details($ref=null,$start_date=null,$end_date=null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('movements');
			$this->db->join('movement_details', 'movements.id = movement_details.header_id');
			if($ref != null)
				$this->db->where('movement_details.stock_id',$ref);
				$this->db->where('date_posted >=', $start_date);
				$this->db->where('date_posted <=', $end_date);
				$this->db->where('status = 2');
				$this->db->order_by('date_posted DESC');
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	public function get_stock_movements_from_main($ref=null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('stock_moves_main');
			// $this->db->join('movement_details', 'movements.id = movement_details.header_id');
			if($ref != null)
				$this->db->where('stock_moves_main.stock_id',$ref);
			// $this->db->where('status = 2');
			$this->db->order_by('id DESC');
			$this->db->order_by('trans_date DESC');
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	public function search_stock_movements_from_main($ref=null,$start_date=null,$end_date=null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('stock_moves_main');
			// $this->db->join('movement_details', 'movements.id = movement_details.header_id');
			if($ref != null)
				$this->db->where('stock_moves_main.stock_id',$ref);
				$this->db->where('trans_date >=', $start_date);
				$this->db->where('trans_date <=', $end_date);
				// $this->db->where('status = 2');
				$this->db->order_by('id DESC');
				$this->db->order_by('trans_date DESC');
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	public function get_movement_types_desc($id=null){
		$sql= "SELECT description FROM movement_types WHERE movement_type_id = '".$id."' ";
		$query = mysql_query($sql);
		$result = mysql_fetch_object($query); 
		return $result->description;
		//return $sql;
	}
	public function get_stock_moves_types_desc($type_id=null){
		$sql = "SELECT name FROM `trans_types` WHERE `trans_type` = '$type_id' ";
		// echo $sql."<br>";
		$query = $this->db->query($sql);
		$row = $query->row();
		if ($row != null)
			return $row->name;
		else
			return false;
	}
	public function get_barcode_description($barcode=null){
		$sql = "SELECT `description` FROM `stock_barcodes_new` WHERE `barcode` = '$barcode' ";
		// echo $sql."<br>";
		$query = $this->db->query($sql);
		$row = $query->row();
		if ($row != null)
			return $row->description;
		else
			return false;
	}
	public function get_branch_stocks_current_count($stock_id=null, $branch_id=null, $loc_id=null){
		// $sql = "SELECT `qty` FROM `branch_stocks`";
		// if($stock_id != null){	
			// $sql .= " WHERE `stock_id` = $stock_id ";
		// }
		// if($branch_id != null){
			// $sql .= " AND `branch_id` = $branch_id ";
		// }
		// if($loc_id != null){
			// $sql .= " AND `stock_loc_id` = $loc_id ";
		// }
		$sql = "SELECT `qty` FROM `branch_stocks` WHERE stock_id=$stock_id AND branch_id=$branch_id AND stock_loc_id=$loc_id";
		// echo $sql."<br>";
		$query = $this->db->query($sql);
		$row = $query->row();
		if ($row != null)
			return $row->qty;
		else
			return 0;
	}
	public function get_all_branch_details($id=null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('branches');
			if($id != null)
				$this->db->where('id',$id);
			$this->db->where('inactive',0);
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	public function get_stock_tax($stock_id,$unit_cost){
		$sql = "SELECT b.default_rate 
					FROM `stock_master_new` a
					JOIN `stock_tax_types_new` b ON a.tax_type_id = b.id
					WHERE a.stock_id = $stock_id";
		$query = $this->db->query($sql);
		$row = $query->row();
		
		return round($unit_cost - ($unit_cost/(1+($row->default_rate/100))), 4);
		// return $unit_cost - ($unit_cost/(1+($row->default_rate/100)));
	}
	//----------FOR PO DASHBOARD----------START
	public function get_purchaser_stock_ids($purchaser_id=null){		
		$sql = "SELECT stock_id
					FROM view_purchaser_stock_master
				   ";
		if($purchaser_id != null){
			$sql .= " WHERE purchaser_id = $purchaser_id";
		}
		
		$sql .= " ORDER BY date_added DESC";
		
		$query = $this->db->query($sql);
		$stock_ids = array();
		// foreach($query->result_array() as $row) //---array
		foreach($query->result() as $row) //---object
		{
			// $stock_ids[] = $row['stock_id']; //---array
			$stock_ids[] = $row->stock_id; //---object
		}
		return $stock_ids;
	}
	public function get_all_purchaser_stock_ids($purchaser_id=null){		
		$sql = "SELECT stock_id
					FROM view_purchaser_stock_master
				   ";
		if($purchaser_id != null){
			$sql .= " WHERE purchaser_id = $purchaser_id";
		}
		
		$sql .= " ORDER BY date_added DESC";
		// echo $sql."<br>";
		$query = $this->db->query($sql);
		$result = $query->result();
		return $result;
	}
	public function get_stock_qoh($stock_id=null, $branch_id=null){
		$sql = "SELECT SUM(qty) AS total_qty 
					FROM `branch_stocks` 
					WHERE stock_id=$stock_id 
					AND branch_id=$branch_id
					AND stock_loc_id IN (".SELLING_AREA.", ".STOCK_ROOM.")
					GROUP BY stock_id;";
		// echo $sql."<br>";
		$query = $this->db->query($sql);
		$row = $query->row();
		if ($row != null)
			return $row->total_qty;
		else
			return 0;
	}
	//----------FOR PO DASHBOARD----------END
}