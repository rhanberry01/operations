<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Receiving extends CI_Controller {
	var $data = null;
	public function __construct()
	{
		parent::__construct();
		$this->load->model('site/site_model');
		$this->load->model('core/receiving_model');
		$this->load->helper('core/receiving_helper');
		date_default_timezone_set('Asia/Manila');
	}
	//----------VALUE LOADER FUNCTIONS----------START
	public function get_purch_order_info(){
		$po_reference = $this->input->post('po_reference');
		$vals = $val_res = $this_res = array();
		if($po_reference != ''){
			$vals = $this->receiving_model->get_purch_order_info($po_reference);
			// echo var_dump($vals);
			if(!empty($vals)){
				
				$val_res = $this->receiving_model->validate_temp_receiving_header_if_existing($vals->order_no, $po_reference);

				if(!$val_res){
					echo $vals->order_no."||" //-->0
					.$vals->supplier_id."||" //-->1
					.$this->receiving_model->get_supplier_name($vals->supplier_id)."||" //-->2
					.date('m/d/Y', strtotime($vals->delivery_date))."||" //-->3
					.$vals->into_stock_location; //-->4
				}else{
					$this_res = $this->receiving_model->get_temp_receiving_header($vals->order_no, $po_reference);
					// echo var_dump($this_res);
					echo $vals->order_no."||" //-->0
					.$vals->supplier_id."||" //-->1
					.$this->receiving_model->get_supplier_name($vals->supplier_id)."||" //-->2
					.date('m/d/Y', strtotime($vals->delivery_date))."||" //-->3
					.$vals->into_stock_location."||" //-->4
					.$this_res->invoice_no."||" //-->5
					.$this_res->invoice_amt."||" //-->6
					.$this_res->receiving_notes; //-->7
				}
			}else{
				echo 'warning';
			}
		}
	}
	public function get_barcode_uom(){
		$barcode = $this->input->post('barcode');
		$uom = $this->receiving_model->get_barcode_uom($barcode);
		echo $uom;
	}
	//----------VALUE LOADER FUNCTIONS----------END
	// ======================================================================================= //
	//  					TRANSACTIONS																															
    // ======================================================================================= //
	//----------RECEIVING ENTRY----------START
	public function receiving_entry($rec_id=null){
		$data = $this->syter->spawn('receiving_entry');
		$data['page_title'] = fa('fa-download')." Receiving Entry";
		
		$data['code'] = build_receiving_entry_form($rec_id);
		$data['load_js'] = 'core/receiving.php';
        $data['use_js'] = 'receivingEntryJS';
		$this->load->view('page',$data);
	}
	public function load_receiving_items(){
		$items = array();
		$po_order_no = $this->input->post('order_no');
		$po_reference = $this->input->post('po_reference');
		
		$items = $this->receiving_model->get_receiving_details_temp($po_order_no, $po_reference);
		// echo var_dump($items);
		// $data['code'] = build_receiving_details_list_form($items, $mode, (!empty($ref) ? $ref : null)); //ORIGINAL
		$data['code'] = build_receiving_details_list_form($items);
		$data['load_js'] = "core/receiving.php";
		$data['use_js'] = "reloadReceivingItemsJS";
		$this->load->view('load',$data);
	}
	public function validate_receiving_item(){
		$res = array();
		$po_order_no = $this->input->post('order_no');
		$po_reference = $this->input->post('po_reference');
		$barcode = $this->input->post('barcode');
		$uom = $this->input->post('uom');
		
		$res = $this->receiving_model->validate_receiving_item_from_po($po_order_no, $po_reference, $barcode, $uom);
		if(!empty($res)){
			// echo var_dump($res);
			echo $res->qty_ordered;
		}else{
			echo "warning";
		}
	}
	public function save_to_receiving_temp_db(){
		$val_res = $res = $this_res = $barcode_res = array();
		$check_stat = $status = "";
		//-----VALIDATE IF RECEIVING HEADER TEMP ALREADY EXISTS:
		$val_res = $this->receiving_model->validate_temp_receiving_header_if_existing($this->input->post('order_no'), $this->input->post('po_reference'));
		
		// echo var_dump($val_res);
		
		if(!$val_res){
			$items = array(
				"purch_order_no"=>$this->input->post('order_no'),
				"po_reference"=>$this->input->post('po_reference'),
				"supplier_name"=>$this->input->post('supplier_name'),
				"invoice_no"=>$this->input->post('invoice_no'),
				"invoice_amt"=>$this->input->post('invoice_amt'),
				"delivery_date"=>date2Sql($this->input->post('delivery_date')),
				"stock_location"=>$this->input->post('stock_location'),
				"receiving_notes"=>$this->input->post('receiving_notes'),
				"user_id"=>$this->input->post('hidden_user'),
				"created_by"=>$this->input->post('hidden_user'),
				"datetime_created"=>date('Y-m-d H:i:s')
			);
			//-----INSERT TO receiving_headers_temp
			$id = $this->receiving_model->write_to_receiving_headers_temp($items);
		}else{
			$this_res = $this->receiving_model->get_temp_receiving_header($this->input->post('order_no'), $this->input->post('po_reference'));
			$id = $this_res->id;
			$items = array(
				"invoice_no"=>$this->input->post('invoice_no'),
				"invoice_amt"=>$this->input->post('invoice_amt'),
				"delivery_date"=>date2Sql($this->input->post('delivery_date')),
				"stock_location"=>$this->input->post('stock_location'),
				"receiving_notes"=>$this->input->post('receiving_notes'),
				"modified_by"=>$this->input->post('hidden_user'),
				"datetime_modified"=>date('Y-m-d H:i:s')
			);
			$this->receiving_model->update_receiving_headers_temp($items, $id, $this->input->post('order_no'), $this->input->post('po_reference'));
		}	
		
		//-----INSERTION OF RECEIVING DETAILS TEMP
		$res = $this->receiving_model->validate_receiving_item_from_po($this->input->post('order_no'), $this->input->post('po_reference'), $this->input->post('barcode'), $this->input->post('uom'));
		if(!empty($res)){
			// echo "MERON";
			$sub_items = array(
				"temp_receiving_id"=>$id,
				"po_line_id"=>$res->line_id, //---based from PO line_id
				"stock_id"=>$this->receiving_model->get_barcode_stock_id($this->input->post('barcode')),
				"barcode"=>$this->input->post('barcode'),
				"description"=>$this->receiving_model->get_barcode_description($this->input->post('barcode')),
				"uom"=>$res->uom, //---should be based from PO
				"qty_received"=>($this->input->post('qty') == '' ? 1 : $this->input->post('qty')), //qty entered upon receiving
				"po_extended"=>$res->extended, //---should be based from PO
				"last_scanned"=>1
			);
		}else{
			// echo "WALA";
			$sub_items = array();
		}
		
		if($this->input->post('barcode') != '' && $this->input->post('uom') != ''){
			#DO THIS
			$barcode_res = $this->receiving_model->validate_receiving_details_temp_if_item_exists($id, $this->receiving_model->get_barcode_stock_id($this->input->post('barcode')), $this->input->post('barcode'), $this->input->post('uom'));
			if(!$barcode_res){	
				//-----INSERT TO receiving_details_temp
				$this->receiving_model->reset_last_scanned_item($id, $this->receiving_model->get_barcode_stock_id($this->input->post('barcode')), $this->input->post('barcode'), $this->input->post('uom'));
				$this->receiving_model->write_to_receiving_details_temp($sub_items);
				$status="success";
			}else{
				//-----ADD TO EXISTING QTY OF LINE ITEM
				$check_stat = $this->receiving_model->add_to_existing_receiving_detail_temp_item($this->input->post('order_no'), $id, $this->receiving_model->get_barcode_stock_id($this->input->post('barcode')), $this->input->post('barcode'), $this->input->post('uom'), $this->input->post('qty'));
				// if(!$check_stat){
				if($check_stat == 1){
					$status="success";
				}else if($check_stat==0 || $check_stat==''){
					$status="error";
				}	
				// echo "===>".$check_stat."~~~>".$status;
			}	
		}else{
			$status="success";
		}
		// echo $id;
		echo json_encode(array('id'=>$id, 'status'=>$status));
	}
	public function post_receiving_to_db(){
		$this->load->model('core/inventory_model');
		$this->load->model('core/supplier_model');
		$user = $this->session->userdata('user');
		/*---------- Save to receiving MAIN table----------*/
		$po_ref_vals = $temp_sub_items = $temp_main_items = $main_items = $this_res = $sub_items = $movement_items = $upd_items = $cos_line = $qty_line = array();
		$trans_ref_items = $rec_next_val = $upd_cost_of_sales_item = $upd_branch_stocks_item = $po_line_item = array();
		$supp_tax_id = $reference = $type_no = $receiving_id = "";
		$uom_qty = $new_cost_of_sales = $new_qty = $received_qty = 0;
		
		$rec_next_val = $this->site_model->get_next_ref(PURCHASE_ORDER_DELIVERY);
		$type_no = $rec_next_val->next_type_no;
		$reference = ($this->input->post('reference') ? $this->input->post('reference') : $rec_next_val->next_ref);
		$reference = $this->site_model->check_duplicate_ref(PURCHASE_ORDER_DELIVERY,$reference);
		
		$po_ref_vals = $this->receiving_model->get_purch_order_header_for_reference($this->input->post('order_no'), $this->input->post('po_reference'));
		$this_res = $this->receiving_model->get_temp_receiving_header($this->input->post('order_no'), $this->input->post('po_reference'));
		$receiving_id = $this_res->id;
		
		$temp_main_items = $this->receiving_model->get_temp_receiving_header_for_posting($receiving_id, $this->input->post('order_no'), $this->input->post('po_reference'));
		$temp_sub_items = $this->receiving_model->get_temp_receiving_details_for_posting($receiving_id, $this->input->post('order_no'), $this->input->post('po_reference'));
		
		$main_items = array(
			"purch_order_no" => $this_res->purch_order_no,
			"branch_id" => $po_ref_vals->branch_id,
			"supplier_id" => $po_ref_vals->supplier_id,
			"reference" => $this_res->po_reference,
			"source_invoice_no" => $this_res->invoice_no,
			"delivery_date" =>date('Y-m-d', strtotime($this_res->delivery_date)),
			"stock_location" => $this_res->stock_location,
			"receiving_comments" => $this_res->receiving_notes,
			"status" => 1,
			"created_by" => $this_res->created_by,
			"datetime_created" => date('Y-m-d H:i:s', strtotime($this_res->datetime_created)),
			"posted_by" => $this->input->post('hidden_user'),
			"datetime_posted" =>date('Y-m-d H:i:s')
		);
		
		$main_id = $this->receiving_model->write_to_receiving_headers($main_items);
		
		$supp_tax_id = $this->supplier_model->get_supplier_tax_type($po_ref_vals->supplier_id);
		
		foreach($temp_sub_items as $sub_vals){
			$new_cost_of_sales = $new_qty = $unit_cost_w_vat = $ext_net_of_vat = $received_qty = 0;
			$po_line_item = $this->receiving_model->get_from_purch_order_details_line_item($this->input->post('order_no'), $sub_vals->stock_id);
			
			$unit_cost_w_vat = ($sub_vals->po_extended/$sub_vals->qty_received)+0;
			
			if($supp_tax_id == 1){
				//-----IF TAX TYPE ID = VAT
				$unit_tax = $this->inventory_model->get_stock_tax($sub_vals->stock_id,$unit_cost_w_vat);
			}else{
				//-----IF TAX TYPE ID = NONVAT
				$unit_tax = 0;
			}
			
			$ext_net_of_vat = ($unit_cost_w_vat - $unit_tax) * $sub_vals->qty_received;
			
			$sub_items = array(
				"branch_id" => $po_ref_vals->branch_id,
				"receiving_id" => $main_id,
				"po_line_id" => $sub_vals->po_line_id,
				"stock_id" => $sub_vals->stock_id,
				"description" => $sub_vals->description,
				"receiving_uom" => $sub_vals->uom,
				"receiving_qty" => $this->receiving_model->get_uom_qty($sub_vals->uom),
				"qty_received" => $sub_vals->qty_received,
				// "qty_invoiced" => $sub_vals->stock_id, //-----TEMPORARILY DISABLED
				"extended" => $sub_vals->po_extended,
				// "receiving_notes" => $sub_vals->stock_id, //-----KELANGAN PA BA NITO KUNG MERON NA SA HEADER
			);
			
			$movement_items = array(
				"trans_no" => $main_id,
				"type" => PURCHASE_ORDER_DELIVERY, //-----PURCHASE ORDER DELIVERY
				"reference" => $reference,
				"branch_id" => $po_ref_vals->branch_id,
				"stock_id" => $sub_vals->stock_id,
				"barcode" => $this->receiving_model->get_barcode_from_stock_id_and_uom($sub_vals->stock_id, $sub_vals->uom),
				"stock_location" => $this_res->stock_location,
				"trans_date" => date('Y-m-d'),
				"user_id" => $this->input->post('hidden_user'),
				"unit_cost" => $po_line_item->unit_cost,
				"unit_cost_pcs" => ($po_line_item->unit_cost/($sub_vals->qty_received*$this->receiving_model->get_uom_qty($sub_vals->uom))),
				"qty" => $this->receiving_model->get_uom_qty($sub_vals->uom),
				"qty_pcs" => ($sub_vals->qty_received*$this->receiving_model->get_uom_qty($sub_vals->uom)),
				"stock_uom" => $sub_vals->uom,
				"standard_cost" => $po_line_item->std_unit_cost,
				"disc_percent1" => ($po_line_item->disc_percent1)+0,
				"disc_percent2" => ($po_line_item->disc_percent2)+0,
				"disc_percent3" => ($po_line_item->disc_percent3)+0,
				"disc_percent4" => ($po_line_item->disc_amount1)+0,
				"disc_percent5" => ($po_line_item->disc_amount2)+0,
				"disc_percent6" => ($po_line_item->disc_amount3)+0,
				"is_visible" => 1,
			);
			
			 $this->receiving_model->write_to_receiving_details($sub_items);
			 
			 //-----WRITE IN STOCK_MOVES_BRANCH-----//
			 $this->receiving_model->write_to_stock_moves_branch($movement_items);
			 //-----WRITE IN STOCK_MOVES_MAIN-----//
			 
			 /*---------- Recompute Cost of Sales upon posting ----------*/
			$uom_qty = $this->receiving_model->get_uom_qty($sub_vals->uom);
			$cos_line = $this->receiving_model->get_branch_stock_cost_of_sales_row($sub_vals->stock_id, $po_ref_vals->branch_id);
			$qty_line = $this->receiving_model->get_branch_stock_qty_row($sub_vals->stock_id, $po_ref_vals->branch_id);
			
			// $new_cost_of_sales = (($qty_line->qty*$cos_line->cost_of_sales)+$sub_vals->po_extended)/($qty_line->qty+($sub_vals->qty_received*$uom_qty));
			$new_cost_of_sales = (($qty_line->qty*$cos_line->cost_of_sales)+$ext_net_of_vat)/($qty_line->qty+($sub_vals->qty_received*$uom_qty));
			$new_qty = $qty_line->qty+($sub_vals->qty_received*$uom_qty);
			$received_qty = round(($sub_vals->qty_received*$uom_qty), 4);
			
			$upd_cost_of_sales_item = array(
				"last_cost_of_sales"=>round($cos_line->cost_of_sales, 4),
				"cost_of_sales"=>round($new_cost_of_sales, 4)
			);
			
			// // $upd_branch_stocks_item = array(
				// // "qty"=>round($new_qty, 4)
			// // );
			
			$this->receiving_model->update_branch_stock_cost_of_sales($sub_vals->stock_id, $po_ref_vals->branch_id, $upd_cost_of_sales_item);
			// $this->receiving_model->update_branch_stock_qty($sub_vals->stock_id, $po_ref_vals->branch_id, $this_res->stock_location, $upd_branch_stocks_item);
			 $this->receiving_model->update_branch_stock_qty($sub_vals->stock_id, $po_ref_vals->branch_id, $this_res->stock_location, $received_qty); 
		}
		
		//-----INSERTION IN TRANS_REF-----//
		$trans_ref_items = array(
			'trans_type'=>PURCHASE_ORDER_DELIVERY,
			// 'type_no'=>$type_no,
			'type_no'=>$main_id, //---USE receiving ID instead of type_no from trans_types (since nakaauto increment yung receiving id). Ang gamitin nalang from trans_types ay si reference c/o ENJO
			'reference'=>$reference,
			'branch_id'=>$po_ref_vals->branch_id
		);
		$this->site_model->add_trans_ref($trans_ref_items); //-->This function inserts into trans_refs and updates the trans_types table at the same time
		
		$upd_items = array(
			"posted"=>1,
			"modified_by"=>$this->input->post('hidden_user'),
			"datetime_modified"=>date('Y-m-d H:i:s')
		);
		$this->receiving_model->update_receiving_headers_temp($upd_items, $receiving_id, $this->input->post('order_no'), $this->input->post('po_reference'));
		//---------------------MHAE
		##########AUDIT TRAIL [START]##########
			$audit_items = array(
			'type'=>0,
			'trans_no'=>0,
			'type_desc'=>RECEIVE_PURCHASE_ORDER,
			'description'=>'receiving_id:'.$main_id.'||purch_order_no:"'.$this_res->purch_order_no.'||po_reference:"'.$this_res->po_reference.'||invoice_no:"'.$this_res->invoice_no.'||delivery_date:"'.date('Y-M-d', strtotime($this_res->delivery_date)).'"',
			'user'=>$user['id']);
			
			$audit_id = $this->receiving_model->write_to_audit_trail($audit_items);
		##########AUDIT TRAIL [END]##########
		$this->load->model('core/main_model');
		$this->main_model->main_receiving_details($main_id);
		//---------------------MHAE
		echo "success";
		
	}
	public function remove_from_receiving_details_temp(){
		$this->receiving_model->delete_receiving_details_temp_line_item($this->input->post('line_id'));
	}
	//----------RECEIVING ENTRY----------END
	// ======================================================================================= //
	//  					INQUIRIES																															
    // ======================================================================================= //
	public function saved_receiving($tab_id=null){
		$data = $this->syter->spawn('saved_receiving');
		$data['page_title'] = fa('fa-bookmark')." Saved Receiving List";
		
		$data['code'] = build_saved_receiving($tab_id);
        $data['load_js'] = 'core/receiving.php';
        $data['use_js'] = 'savedReceivingJs';
        $this->load->view('page',$data);
	}
	public function saved_receiving_list(){
		$det = array();
		$det = $this->receiving_model->get_temp_receiving_header_list();
		
		$data['code'] = build_saved_receiving_list($det);
        $data['load_js'] = 'core/receiving.php';
        $data['use_js'] = 'savedReceivingListJs';
        $this->load->view('load',$data);
	}
	public function edit_receiving_entry($rec_id=null){
		$data = $this->syter->spawn('receiving_entry');
		$data['page_title'] = fa('fa-download')." Edit Receiving Entry";
		
		$items = array();
		// $det = $this->receiving_model->get_temp_receiving_header();
		$results = $this->receiving_model->get_temp_receiving_header_list($rec_id);
		if($results){
			$items = $results[0];
		}
		
		$data['code'] = build_edit_receiving_entry_form($rec_id, $items);
		$data['load_js'] = 'core/receiving.php';
        $data['use_js'] = 'editReceivingEntryJS';
		$this->load->view('page',$data);
	}
	public function load_edit_receiving_items(){
		$items = array();
		$po_order_no = $this->input->post('order_no');
		$po_reference = $this->input->post('po_reference');
		
		$items = $this->receiving_model->get_receiving_details_temp($po_order_no, $po_reference);
		// echo var_dump($items);
		$data['code'] = build_receiving_details_list_form($items);
		$data['load_js'] = "core/receiving.php";
		$data['use_js'] = "reloadEditReceivingItemsJS";
		$this->load->view('load',$data);
	}
	public function posted_receiving($tab_id=null){
		$data = $this->syter->spawn('posted_receiving');
		$data['page_title'] = fa('fa-floppy-o')." Posted Receiving List";
		
		$data['code'] = build_posted_receiving($tab_id);
        $data['load_js'] = 'core/receiving.php';
        $data['use_js'] = 'postedReceivingJs';
        $this->load->view('page',$data);
	}
	public function posted_receiving_list(){
		$det = array();
		$det = $this->receiving_model->get_posted_receiving_header_list();
		// echo var_dump($det);
		// echo $this->receiving_model->last_query();
		$data['code'] = build_posted_receiving_list($det);
        $data['load_js'] = 'core/receiving.php';
        $data['use_js'] = 'postedReceivingListJs';
        $this->load->view('load',$data);
	}
	//----------POSTED RECEIVING POP-UP VIEW----------APM----------START
	public function posted_receiving_popup($rec_id, $branch_id){
		//echo "Receiving ID: ".$rec_id." ".$branch_id."<br>";
		$res = $this->receiving_model->get_posted_header_details_posted($rec_id, $branch_id);
		$items = $res[0];
		//echo var_dump($items);
		//echo $items->purch_order_no."<--->".$items->reference."<br>";
		$sub_items = $this->receiving_model->get_receiving_details($items->purch_order_no, $items->reference);
		$data['code'] = build_posted_receiving_popup_form($rec_id, $items, $sub_items);
		$data['add_js'] = 'js/site_list_forms.js';
		$data['load_js'] = "core/receiving.php";
		$data['use_js'] = "postedReceivingPopJS";
		$this->load->view('load',$data);
	}
	//----------POSTED RECEIVING POP-UP VIEW----------APM----------END
}