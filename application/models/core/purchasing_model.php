<?php
class Purchasing_model extends CI_Model{

	public function __construct(){
		parent::__construct();
	}
	//**********SUPPLIERS*****Allyn*****START
	public function get_supplier($id=null)
	{
		$this->db->select('*');
		$this->db->from('suppliers');
		// $this->db->join('categories','items.cat_id = categories.cat_id');
		// $this->db->join('subcategories','items.subcat_id = subcategories.sub_cat_id');
		// $this->db->join('item_types','items.type = item_types.id');
		// $this->db->join('suppliers','items.supplier_id = suppliers.supplier_id');
		if (!is_null($id)) {
			if (is_array($id))
				$this->db->where_in('suppliers.supplier_id',$id);
			else
				$this->db->where('suppliers.supplier_id',$id);
		}
		$this->db->order_by('suppliers.supp_name ASC');
		$query = $this->db->get();
		// echo $this->db->last_query();
		return $query->result();
	}
	public function get_supplier_info($telno=null)
	{
		// SELECT * FROM suppliers WHERE '4560987' = replace(`telno`, '-', '');
		$sql = "SELECT * FROM `suppliers` WHERE '$telno' = replace(telno,'-','') ORDER BY suppliers.supp_name ASC";
		$query = $this->db->query($sql);
		// echo $this->db->last_query();
		return $query->result();
	}
	public function get_all_supplier_count($telno=null){
		$sql = "SELECT COUNT(*) as total_count FROM `suppliers` WHERE '$telno' = replace(telno,'-','')";
		$query = $this->db->query($sql);
		// // echo $this->db->last_query();
		return $query->result();
	}
	public function add_supplier($items)
	{
		// $this->db->set('reg_date','NOW()',FALSE);
		$this->db->insert('suppliers',$items);
		return $this->db->insert_id();
	}
	public function update_supplier($items,$id)
	{
		// $this->db->set('update_date','NOW()',FALSE);
		$this->db->where('supplier_id',$id);
		$this->db->update('suppliers',$items);
	}
	public function search_customers($search=""){
		$this->db->trans_start();
			// $this->db->select('cust_id,fname,lname,mname,suffix,phone');
			$this->db->select('*');
			$this->db->from('suppliers');
			if($search != ""){
				$this->db->like('suppliers.telno', $search);
				$this->db->or_like('suppliers.supplier_code', $search);
				$this->db->or_like('suppliers.supp_name', $search);
				$this->db->or_like('suppliers.email', $search);
			}
			// $this->db->order_by('suppliers.fname,suppliers.lname');
			$this->db->order_by('suppliers.supp_name');
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	//**********SUPPLIERS*****Allyn*****END
	//************JED PO*******************
	public function get_po_header($id=null){
		$this->db->trans_start();
			$this->db->select('purch_orders.*');
			$this->db->from('purch_orders');
			if($id != null)
				if(is_array($id))
				{
					$this->db->where($id);
				}else{
					$this->db->where('purch_orders.order_id',$id);
				}
			$this->db->order_by('purch_orders.order_id desc');
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	public function get_po_header2($id=null){
		$this->db->trans_start();
			$this->db->select('purch_orders.*, sum(purch_order_details.quantity_ordered) as t_ordered, sum(purch_order_details.quantity_received) as t_received');
			$this->db->from('purch_orders');
			$this->db->join('purch_order_details','purch_order_details.order_id = purch_orders.order_id','LEFT');
			if($id != null)
				if(is_array($id))
				{
					$this->db->where($id);
				}else{
					$this->db->where('purch_orders.order_id',$id);
				}
			$this->db->where('purch_orders.close_po',0);
			$this->db->group_by('purch_orders.order_id');
			$this->db->order_by('purch_orders.order_id desc');
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	public function get_po_header_w_supp($where=null)
	{
		$this->db->select('purch_orders.order_no,
			purch_orders.comments,
			purch_orders.ord_date,
			purch_orders.reference,
			purch_orders.requisition_no,
			purch_orders.into_stock_location,
			purch_orders.delivery_address,
			purch_orders.status,
			suppliers.supplier_id,
			suppliers.supplier_code,
			suppliers.supp_name supplier_name,
			suppliers.address supplier_address,
			suppliers.telno supplier_tel,
			suppliers.faxno supplier_fax,
			stock_locations.loc_code,
			stock_locations.location_name,
			users.fname person_fname,
			users.mname person_mname,
			users.lname person_lname
		');
		$this->db->from('purch_orders');
		$this->db->join('suppliers','purch_orders.supplier_id = suppliers.supplier_id');
		$this->db->join('stock_locations','purch_orders.into_stock_location = stock_locations.loc_code','left');
		$this->db->join('users','purch_orders.person_id = users.id');
		if ($where)
			if (is_array($where)) {
				foreach ($where as $val) {
					if (isset($val['key'])) {
						$this->db->where($val['key'],$val['value'],$val['escape']);
					} else {
						$this->db->where($val);
					}
				}
			} else
				$this->db->where($where);
		$query = $this->db->get();
		return $query->result();
	}
	//--------PO NEW------APM-----START
	public function add_header($items)
	{
		// $this->db->set('reg_date','NOW()',FALSE);
		$this->db->insert('purch_orders',$items);
		return $this->db->insert_id();
	}
	public function update_header($items,$id)
	{
		// $this->db->set('update_date','NOW()',FALSE);
		$this->db->where('order_id',$id);
		$this->db->update('purch_orders',$items);
	}
	//--------PO NEW------APM-----END
	public function add_header_OLD($items)
	{
		// $this->db->set('reg_date','NOW()',FALSE);
		$this->db->insert('purch_orders',$items);
		return $this->db->insert_id();
	}
	public function update_header_OLD($items,$id)
	{
		// $this->db->set('update_date','NOW()',FALSE);
		$this->db->where('order_id',$id);
		$this->db->update('purch_orders',$items);
	}
	public function get_po_items($id=null){
		$this->db->trans_start();
			$this->db->select('purch_order_details.*');
			$this->db->from('purch_order_details');
			if($id != null)
				if(is_array($id))
				{
					$this->db->where_in('purch_order_details.order_id',$id);
				}else{
					$this->db->where('purch_order_details.order_id',$id);
				}
			//$this->db->order_by('purch_order_details.po_detail_item desc');
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	public function get_po_items_w_master($where=null)
	{
		$this->db->select('purch_order_details.*,
			stock_master.item_code,
			stock_master.name,
			stock_master.grade,
			stock_master.description stock_description
			');
		$this->db->from('purch_order_details');
		$this->db->join('purch_orders','purch_order_details.order_id = purch_orders.order_id');
		$this->db->join('stock_master','purch_order_details.item_code = stock_master.id');
		if ($where)
			if (is_array($where)) {
				foreach ($where as $val) {
					if (isset($val['key'])) {
						$this->db->where($val['key'],$val['value'],$val['escape']);
					} else {
						$this->db->where($val);
					}
				}
			} else {
				$this->db->where($where);
			}
		$query = $this->db->get();
		return $query->result();
	}
	public function get_item($id=null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('supplier_stocks');
			if($id != null)
				$this->db->where('supplier_stocks.stock_id',$id);
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	public function get_item_OLD($id=null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('stock_master');
			if($id != null)
				$this->db->where('stock_master.id',$id);
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	public function add_items($items)
	{
		// $this->db->set('reg_date','NOW()',FALSE);
		$this->db->insert('purch_order_details',$items);
		return $this->db->insert_id();
	}
	public function update_items($items,$id)
	{
		// $this->db->set('update_date','NOW()',FALSE);
		$this->db->where('po_detail_item',$id);
		$this->db->update('purch_order_details',$items);
	}
	public function delete_item($id)
	{
		// $this->db->set('update_date','NOW()',FALSE);
		$this->db->where('po_detail_item',$id);
		$this->db->delete('purch_order_details');
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
	public function get_po_items_details($where=null){
		$this->db->trans_start();
			$this->db->select('purch_order_details.*');
			$this->db->from('purch_order_details');
			if($where != null)
				$this->db->where($where);

			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	public function update_po_details($items,$id)
	{
		// $this->db->set('update_date','NOW()',FALSE);
		$this->db->where('po_detail_item',$id);
		$this->db->update('purch_order_details',$items);
	}
	public function get_deliveries($where=null){
		$this->db->trans_start();
			$this->db->select('delivery_details.*');
			$this->db->from('delivery_details');
			if($where != null)
				$this->db->where($where);

			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	public function add_delivery($items)
	{
		// $this->db->set('reg_date','NOW()',FALSE);
		$this->db->insert('delivery_details',$items);
		return $this->db->insert_id();
	}
	public function update_delivery($items,$id)
	{
		// $this->db->set('update_date','NOW()',FALSE);
		$this->db->where('delivery_id',$id);
		$this->db->update('delivery_details',$items);
	}
	public function add_stockmoves($items)
	{
		// $this->db->set('reg_date','NOW()',FALSE);
		$this->db->insert('stock_moves',$items);
		return $this->db->insert_id();
	}
	public function get_delivery_items($id=null){
		$this->db->trans_start();
			$this->db->select('delivery_details.*, purch_order_details.unit_price, purch_order_details.discount_percent, purch_order_details.discount_percent2, purch_order_details.discount_percent3, purch_order_details.stk_units');
			$this->db->from('delivery_details');
			$this->db->join('purch_order_details','purch_order_details.po_detail_item = delivery_details.po_detail_item');
			if($id != null)
				if(is_array($id))
				{
					$this->db->where($id);
				}else{
					$this->db->where('delivery_details.order_no',$id);
				}
			//$this->db->order_by('purch_order_details.po_detail_item desc');
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	public function add_supp_invoices($items)
	{
		// $this->db->set('reg_date','NOW()',FALSE);
		$this->db->insert('supplier_invoices',$items);
		return $this->db->insert_id();
	}
	public function add_supp_payment($items)
	{
		// $this->db->set('reg_date','NOW()',FALSE);
		$this->db->insert('supplier_payments',$items);
		return $this->db->insert_id();
	}
	public function get_supp_allocations($id=null){
		$this->db->trans_start();
			$this->db->select('supplier_payments.*, sum(supplier_allocations.amount) as alloc_amt');
			$this->db->from('supplier_payments');
			$this->db->join('supplier_allocations','supplier_payments.order_no = supplier_allocations.trans_no_from','LEFT');
			if($id != null)
				if(is_array($id))
				{
					$this->db->where($id);
				}else{
					$this->db->where('supplier_payments.supp_payment_id',$id);
				}
			$this->db->group_by('supplier_payments.supp_payment_id');
			// $this->db->order_by('purch_order_details.po_detail_item desc');
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	public function get_supp_invoices($id=null){
		$this->db->trans_start();
			$this->db->select('supplier_invoices.*, sum(supplier_allocations.amount) as alloc_amt, supplier_allocations.trans_no_from');
			$this->db->from('supplier_invoices');
			$this->db->join('supplier_allocations','supplier_invoices.order_no = supplier_allocations.trans_no_to','LEFT');
			if($id != null)
				if(is_array($id))
				{
					$this->db->where($id);
				}else{
					$this->db->where('supplier_invoices.trans_no',$id);
				}
			//$this->db->group_by('supplier_allocations.trans_no_to');
			$this->db->group_by('supplier_invoices.order_no');
			$this->db->order_by('supplier_invoices.order_no');
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	public function update_invoices($items,$id)
	{
		// $this->db->set('update_date','NOW()',FALSE);
		$this->db->where('trans_no',$id);
		$this->db->update('supplier_invoices',$items);
	}
	public function add_supp_allocation($items)
	{
		// $this->db->set('reg_date','NOW()',FALSE);
		$this->db->insert('supplier_allocations',$items);
		return $this->db->insert_id();
	}
	public function get_payments_totals($id=null){
		$this->db->trans_start();
			$this->db->select('supplier_invoices.*, sum(supplier_allocations.amount) as alloc_amt, supplier_allocations.trans_no_from');
			$this->db->from('supplier_invoices');
			$this->db->join('supplier_allocations','supplier_invoices.order_no = supplier_allocations.trans_no_to','LEFT');
			if($id != null)
				if(is_array($id))
				{
					$this->db->where($id);
				}else{
					$this->db->where('supplier_invoices.trans_no',$id);
				}
			$this->db->group_by('supplier_allocations.trans_no_from');
			$this->db->order_by('supplier_invoices.order_no');
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	public function has_po_items($po_no=null){
		$sql = "SELECT COUNT(*) as total_count FROM `purch_order_details` WHERE order_no = '$po_no'";
		$query = $this->db->query($sql);
		$result = $query->result();
		$res = $result[0];
		// echo $this->db->last_query();
		return $res->total_count;
	}
	public function add_supp_invoices_items($items)
	{
		// $this->db->set('reg_date','NOW()',FALSE);
		$this->db->insert('supplier_invoice_items',$items);
		return $this->db->insert_id();
	}
	public function get_supplier_invoices($where=null){
		$this->db->trans_start();
			$this->db->select('supplier_invoices.*');
			$this->db->from('supplier_invoices');
			if($where != null)
				$this->db->where($where);

			//$this->db->where('paid',0);
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	public function get_items_creditnote($id=null){
		$this->db->trans_start();
			$this->db->select('supplier_invoice_items.*,delivery_details.item_id, purch_order_details.stk_units, purch_order_details.unit_price,purch_order_details.discount_percent, purch_order_details.discount_percent2, purch_order_details.discount_percent3, delivery_details.qty_received, delivery_details.date_delivered');
			$this->db->from('supplier_invoice_items');
			$this->db->join('supplier_invoices','supplier_invoices.trans_no = supplier_invoice_items.supp_invoice_transno');
			$this->db->join('delivery_details','delivery_details.delivery_id = supplier_invoice_items.delivery_id');
			$this->db->join('purch_order_details','purch_order_details.po_detail_item = delivery_details.po_detail_item');
			if($id != null)
				if(is_array($id))
				{
					$this->db->where($id);
				}else{
					$this->db->where('supplier_invoices.trans_no',$id);
				}
			// $this->db->group_by('supplier_allocations.trans_no_from');
			// $this->db->order_by('supplier_invoices.order_no');
			$this->db->where('supplier_invoice_items.returned',0);
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	public function update_invoice_items($items,$id)
	{
		// $this->db->set('update_date','NOW()',FALSE);
		$this->db->where('id',$id);
		$this->db->update('supplier_invoice_items',$items);
	}
	public function get_item_cnote($where=null){
		$this->db->trans_start();
			$this->db->select('supplier_invoice_items.*');
			$this->db->from('supplier_invoice_items');
			if($where != null)
				$this->db->where($where);

			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	// public function get_items_tore($id=null){
	// 	$this->db->trans_start();
	// 		$this->db->select('delivery_details.*, purch_order_details.unit_price, purch_order_details.discount_percent, purch_order_details.discount_percent2, purch_order_details.discount_percent3, purch_order_details.stk_units');
	// 		$this->db->from('delivery_details');
	// 		$this->db->join('purch_order_details','purch_order_details.po_detail_item = delivery_details.po_detail_item');
	// 		if($id != null)
	// 			if(is_array($id))
	// 			{
	// 				$this->db->where($id);
	// 			}else{
	// 				$this->db->where('delivery_details.order_no',$id);
	// 			}
	// 		//$this->db->order_by('purch_order_details.po_detail_item desc');
	// 		$query = $this->db->get();
	// 		$result = $query->result();
	// 	$this->db->trans_complete();
	// 	return $result;
	// }


}
?>