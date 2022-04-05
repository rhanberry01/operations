<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Po extends CI_Controller {
	var $data = null;
	public function __construct()
	{
		parent::__construct();
		$this->load->model('site/site_model');
		$this->load->model('core/po_model');
		$this->load->helper('core/po_helper');
		$this->load->helper('email_helper');
		$this->load->model('core/mail_model');
		$this->load->library('My_PHPMailer');
		$this->load->helper('pdf_helper');
	}
	//----------DASHBOARD----------START
	public function dashboard($ref=''){
		$data = $this->syter->spawn('purchasing');
		$data['page_subtitle'] = "Purchasing Dashboard";
		
		$current_date = date('Y-m-d');
		$date_from = '2015-09-01';
		$date_to = '2015-09-07';
		
		$out_of_stocks = $this->po_model->get_out_of_stocks_count();
		// $critical_stocks = $this->po_model->get_critical_stocks_count(); //----ORIGINAL
		$critical_stocks = 0; //-----TEMP
		$pending_po = $this->po_model->get_pending_po_count();
		$unserved_po = $this->po_model->get_unserved_po_count($current_date);
		$offtake_count = $this->po_model->get_stocks_with_decreasing_offtake_count($date_from, $date_to);

		$data['code'] = build_dashboard($out_of_stocks, $critical_stocks, $pending_po, $unserved_po, $offtake_count);
		$data['add_css'] = array('css/morris/morris.css', 'css/AdminLTE.css');
		$data['add_js'] = array('js/plugins/morris/morris.js', 'js/raphael.js', 'js/site_list_forms.js');
		// $data['add_js'] = 'js/site_list_forms.js';

		// $data['add_js'] = array('js/site_list_forms.js', 'js/jquery-ui-1.10.3.js', 'js/AdminLTE/app.js', 'js/AdminLTE/dashboard.js');
		// $data['add_js'] = array('js/site_list_forms.js', 'js/AdminLTE/dashboard.js');
		$data['load_js'] = "core/po.php";
		$data['use_js'] = "poDashboardJs";
		$this->load->view('page',$data);
     }
	//----------DASHBOARD----------END
	//----------BRANCH STOCKS----------START
	public function branch_stocks_inq(){
		$data = $this->syter->spawn('purchasing');
		$data['page_title'] = fa('fa-question-circle')." Branch Stocks Inquiry";
		// $data['page_subtitle'] = "Branch Stocks Inquiry";
		
		$data['load_js'] = 'core/po.php';
        $data['use_js'] = 'branchStockSearchJs';
		$data['code'] = build_branch_stocks_inq_form();
		$this->load->view('page',$data);
	}
	//----------BRANCH STOCKS----------END
	public function brach_stock_inquiry_results(){
		$data = $this->syter->spawn('purchasing');
		$data['page_title'] = fa('fa-question-circle')." Branch Stocks Inquiry";

		 if($this->input->post('branch_id') == 'ALL'){
			$branch_id = $this->input->post('branch_id');
		 }else{
			$branch_id = $this->po_model->get_branch_id($this->input->post('branch_id'));
		 }
		 $supp_id = $this->input->post('supp_id');
		 $stock_id = $this->input->post('stock_id');
		 
		$results = $this->po_model->get_branch_stocks($stock_id,$branch_id,$supp_id);
		$data['load_js'] = 'core/purchasing.php';
        $data['use_js'] = 'branchStockSearchJs';
	
		$data['code'] = build_branch_stocks_display($results);
		$this->load->view('load',$data);
	}
	public function po_dashboard_container($act_tabs = null){
		
		//$act_tabs = $this->input->post('tab_action');

		$data = $this->syter->spawn('purchasing');
		$data['page_title'] = "PO Dashboard Inquiry";
		$data['code'] = po_dashboard_inquiry_page($act_tabs);
        $data['load_js'] = 'core/po.php';
        $data['use_js'] = 'poDashboardInquiryJs';
        $this->load->view('page',$data);
	}
	public function out_of_stock_list($ref='')
	{
		$data = $this->syter->spawn('purchasing');
		$results = $this->po_model->get_out_of_stocks_list();
		$data['page_subtitle'] = "Out of Stock Inquiry";
		$data['code'] = build_out_of_stock_list_form($results);
		$data['add_js'] = 'js/site_list_forms.js';
		$data['load_js'] = "core/po.php";
		$data['use_js'] = "outOfStockJs";
		$this->load->view('load',$data);
	}
	public function critical_stocks_list($ref='')
	{
		$data = $this->syter->spawn('purchasing');
		$results = $this->po_model->get_critical_stocks_list(CRITICAL_QTY);
		$data['page_subtitle'] = "Critical Stocks Inquiry";
		$data['code'] = build_critical_stocks_list_form($results);
		$data['add_js'] = 'js/site_list_forms.js';
		$data['load_js'] = "core/po.php";
		$data['use_js'] = "criticalStocksJs";
		$this->load->view('load',$data);
	}
	public function pending_po_list($ref='')
	{
		$data = $this->syter->spawn('purchasing');
		$results = $this->po_model->get_pending_po();
		$data['page_subtitle'] = "Pending PO Inquiry";
		$data['code'] = build_pending_po_list_form($results);
		$data['add_js'] = 'js/site_list_forms.js';
		$data['load_js'] = "core/po.php";
		$data['use_js'] = "pendingPOJs";
		$this->load->view('load',$data);
	}
	public function pending_po_popup($id=null)
	{
		$header = $this->po_model->get_pending_po_header($id);
		$results = $this->po_model->get_pending_po_details($id);

		$data['code'] = build_pending_po_details_popup_form($header, $results);
		$this->load->view('load',$data);
	}
	public function unserved_po_list($ref='')
	{
		$data = $this->syter->spawn('purchasing');
		$current_date = date('Y-m-d');
		$results = $this->po_model->get_unserved_po($current_date);

		$data['page_subtitle'] = "Unserved PO Inquiry";
		$data['code'] = build_unserved_po_list_form($results);
		$data['add_js'] = 'js/site_list_forms.js';
		$data['load_js'] = "core/po.php";
		$data['use_js'] = "unservedPOJs";
		$this->load->view('load',$data);
	}
	public function decreasing_offtake_list($ref='')
	{
		$this->load->model('core/inventory_model');
		$data = $this->syter->spawn('purchasing');
		$current_date = date('Y-m-d');
		$date_from = '2015-09-01';
		$date_to = '2015-09-07';
		$user = $this->session->userdata('user');
		$br_all_det = $all_stock_ids = $stock_ids = array();
		
		$latest_date_to = date('Y-m-d', strtotime("- 1 day"));
		$latest_date_from = date('Y-m-d', strtotime($latest_date_to."- 14 days"));
		// echo $latest_date_from." <--> ".$latest_date_to."<br>";
		
		$old_date_to = date('Y-m-d', strtotime($latest_date_from."- 1 day"));
		$old_date_from = date('Y-m-d', strtotime($old_date_to."- 14 days"));
		// echo $old_date_from." <--> ".$old_date_to."<br>";
		
		$old_offtake = $latest_offtake = $offtake_percent = 0;
		
		$stock_ids = $this->inventory_model->get_purchaser_stock_ids(4);
		$br_all_det = $this->inventory_model->get_active_branches();
		
		$user_role = $this->site_model->get_user_details($user['id']);
		
		$a=array();
		foreach($br_all_det as $br_vals){
			// $results = $this->po_model->get_stock_offtake($date_from, $date_to, $stock_ids); //---ORIGINAL
			// $latest_results = $this->po_model->get_stock_offtake($latest_date_from, $latest_date_to, $stock_ids); //---GET LATEST OFFTAKE
			// $old_results = $this->po_model->get_stock_offtake($old_date_from, $old_date_to, $stock_ids); //---GET OLD OFFTAKE
			
			//-----ROLE-RELATED-----START
			if($user_role->role == ADMINISTRATOR || $user_role->role == DEPT_HEAD)
			{
				$all_stock_ids = $this->inventory_model->get_all_purchaser_stock_ids();
			}else{
				$all_stock_ids = $this->inventory_model->get_all_purchaser_stock_ids($user['id']);
			}
			//-----ROLE-RELATED-----END
			
			foreach($all_stock_ids as $st_val)
			{
				$latest_results = $old_results = array();
				$old_offtake = $latest_offtake = $offtake_percent = 0;
				
				$latest_results = $this->po_model->get_stock_offtake($latest_date_from, $latest_date_to, $st_val->stock_id, $br_vals->id); //---GET LATEST OFFTAKE
				// $l_r = $latest_results[0];
				$old_results = $this->po_model->get_stock_offtake($old_date_from, $old_date_to, $st_val->stock_id, $br_vals->id); //---GET OLD OFFTAKE
				// $o_r = $old_results[0];
				

				if(empty($old_results))
					continue;
				
				if(empty($latest_results))
					continue;
				
				$old_offtake = $old_results[0]->sales_total/$old_results[0]->dividend;
				$latest_offtake = $latest_results[0]->sales_total/$latest_results[0]->dividend;
				
				$offtake_percent = 100-(($latest_offtake/$old_offtake)*100);
				
				// echo $st_val->stock_id." --- latest : ".$latest_offtake." --- old : ".$old_offtake." ~~~ percentage : ".$offtake_percent."<br>";
				
				if ($offtake_percent >= 20)
					$a[] = array($this->po_model->get_stock_desc($st_val->stock_id), $old_offtake, $latest_offtake,  round($offtake_percent,2).' %');
				
					
			}
		
		}
		// echo var_dump($latest_results)."<--LATEST<br>";
		// echo var_dump($old_results)."<--OLD<br>";		

		$data['page_subtitle'] = "Decreasing Offtake Inquiry";
		// $data['code'] = build_decreasing_offtake_list_form($results);
		$data['code'] = build_decreasing_offtake_list_form($a);
		$data['add_js'] = 'js/site_list_forms.js';
		$data['load_js'] = "core/po.php";
		$data['use_js'] = "decreasingOfftakeJs";
		$this->load->view('load',$data);
	}
	public function overstocked_items_list($ref='')
	{
		$this->load->model('core/inventory_model');
		$data = $this->syter->spawn('purchasing');
		$current_date = date('Y-m-d');
		$date_from = '2015-09-01';
		$date_to = '2015-09-07';
		$user = $this->session->userdata('user');
		$br_all_det = $all_stock_ids = $stock_ids = array();
		
		$latest_date_to = date('Y-m-d', strtotime("- 1 day"));
		$latest_date_from = date('Y-m-d', strtotime($latest_date_to."- 14 days"));
		// echo $latest_date_from." <--> ".$latest_date_to."<br>";
		
		$old_date_to = date('Y-m-d', strtotime($latest_date_from."- 1 day"));
		$old_date_from = date('Y-m-d', strtotime($old_date_to."- 14 days"));
		// echo $old_date_from." <--> ".$old_date_to."<br>";
		
		$old_offtake = $latest_offtake = $offtake_percent = $forecasted_30days_qty = $qoh = 0;
		
		$stock_ids = $this->inventory_model->get_purchaser_stock_ids(4);
		$br_all_det = $this->inventory_model->get_active_branches();
		
		$user_role = $this->site_model->get_user_details($user['id']);
		
		$a=array();
		foreach($br_all_det as $br_vals){
			// $results = $this->po_model->get_stock_offtake($date_from, $date_to, $stock_ids); //---ORIGINAL
			// $latest_results = $this->po_model->get_stock_offtake($latest_date_from, $latest_date_to, $stock_ids); //---GET LATEST OFFTAKE
			// $old_results = $this->po_model->get_stock_offtake($old_date_from, $old_date_to, $stock_ids); //---GET OLD OFFTAKE
			
			//-----ROLE-RELATED-----START
			if($user_role->role == ADMINISTRATOR || $user_role->role == DEPT_HEAD)
			{
				$all_stock_ids = $this->inventory_model->get_all_purchaser_stock_ids();
			}else{
				$all_stock_ids = $this->inventory_model->get_all_purchaser_stock_ids($user['id']);
			}
			//-----ROLE-RELATED-----END
			
			foreach($all_stock_ids as $st_val)
			{
				$latest_results = $old_results = array();
				$old_offtake = $latest_offtake = $offtake_percent = $forecasted_30days_qty = $qoh = 0;
				
				$latest_results = $this->po_model->get_stock_offtake($latest_date_from, $latest_date_to, $st_val->stock_id, $br_vals->id); //---GET LATEST OFFTAKE
				// $l_r = $latest_results[0];
				// $old_results = $this->po_model->get_stock_offtake($old_date_from, $old_date_to, $st_val->stock_id, $br_vals->id); //---GET OLD OFFTAKE
				// // $o_r = $old_results[0];
				

				// if(empty($old_results))
					// continue;
				
				if(empty($latest_results))
					continue;
				
				// $old_offtake = $old_results[0]->sales_total/$old_results[0]->dividend;
				$latest_offtake = $latest_results[0]->sales_total/$latest_results[0]->dividend;
				
				// $offtake_percent = 100-(($latest_offtake/$old_offtake)*100);
				
				$qoh = $this->inventory_model->get_stock_qoh($st_val->stock_id, $br_vals->id);
				$forecasted_30days_qty = $latest_offtake * OVERSTOCK_DAYS;
				
				// echo $st_val->stock_id." --- latest : ".$latest_offtake." --- old : ".$old_offtake." ~~~ percentage : ".$offtake_percent."<br>";
				
				// if ($offtake_percent >= 20)
				if($qoh > $forecasted_30days_qty)
					// $a[] = array($this->po_model->get_stock_desc($st_val->stock_id), $old_offtake, $latest_offtake,  round($offtake_percent,2).' %', $this->po_model->get_branch_code($br_vals->id), $qoh, $forecasted_30days_qty);
					$a[] = array($this->po_model->get_stock_desc($st_val->stock_id), $latest_offtake,  $this->po_model->get_branch_code($br_vals->id), $qoh, $forecasted_30days_qty);
				
					
			}
		
		}
		// echo var_dump($latest_results)."<--LATEST<br>";
		// echo var_dump($old_results)."<--OLD<br>";		

		$data['page_subtitle'] = "Overstocked Items Inquiry";
		// $data['code'] = build_decreasing_offtake_list_form($results);
		$data['code'] = build_overstocked_item_list_form($a);
		$data['add_js'] = 'js/site_list_forms.js';
		$data['load_js'] = "core/po.php";
		$data['use_js'] = "overstockedItemsJs";
		$this->load->view('load',$data);
	}
	public function extend_delivery_date_popup($id=null)
	{
		$header = $this->po_model->get_pending_po_header($id);
		$results = $this->po_model->get_pending_po_details($id);

		$data['code'] = build_extend_delivery_date_popup_form($id, $header, $results);
		$this->load->view('load',$data);
	}
	public function extend_delivery_date_to_db(){
		$user = $this->session->userdata('user');
		$details = array();
		$items = array(
		 "delivery_date"=>date2Sql($this->input->post('new_delivery_date')),
		 "old_delivery_date"=>date2Sql($this->input->post('delivery_date')),
		 "modified_by"=>$user['id'],
		 "datetime_modified"=>date('Y-m-d H:i:s')
		);
		
		$this->po_model->update_po_header($items, $this->input->post('hidden_po_order_no'));
		
		##########AUDIT TRAIL [START]##########
			$audit_items = array(
			'type'=>0,
			'trans_no'=>0,
			'type_desc'=>EXTEND_DELIVERY_DATE,
			'description'=>'order_no:'.$this->input->post('hidden_po_order_no').'||delivery_date:'.date2Sql($this->input->post('new_delivery_date')).'||old_delivery_date:'.date2Sql($this->input->post('delivery_date')),
			'user'=>$user['id']
			);
			
			$audit_id = $this->po_model->write_to_audit_trail($audit_items);
		##########AUDIT TRAIL [END]##########
		
		$supplier_id = $this->input->post('hidden_supplier_id');
		$supplier_name = $this->input->post('supplier_id');
		
		$details = array(
			"supplier_id"=>$supplier_id,
			"supplier_name"=>$supplier_name,
			"old_delivery_date"=>$this->input->post('delivery_date'),
			"new_delivery_date"=>$this->input->post('new_delivery_date'),
			"order_no"=>$this->input->post('hidden_po_order_no')
		);
		
		$this->send_email('test', $details);
		
	}
	//----------VALUE LOADER FROM DB----------START
	public function get_uom_qty(){
		$qty='';
		$uom = $this->input->post('uom');
		$qty = $this->po_model->get_uom_qty($uom);
		echo $qty;
	}
	public function get_supplier_stock_unit_cost(){
		$unit_cost=0;
		$branch_id = $this->input->post('branch_id');
		$supplier_id = $this->input->post('supplier_id');
		$stock_id = $this->input->post('stock_id');
		if($stock_id != '' AND $branch_id != '' AND $supplier_id != ''){
			$unit_cost = $this->po_model->get_unit_cost_from_branch_id_and_supp_id($stock_id, $branch_id, $supplier_id);
			// echo $this->po_model->db->last_query();
			echo $unit_cost;
		}
	}
	public function get_branch_address(){
		$branch_address='';
		$branch_id = $this->input->post('branch_id');
		if($branch_id != ''){
			$branch_address=$this->po_model->get_branch_address($branch_id);
			// echo $this->po_model->db->last_query();
			echo $branch_address;
		}
	}
	//----------VALUE LOADER FROM DB----------END
	//----------PURCHASE ORDER ENTRY----------START
	public function po_entry($po_id=null){
		$data = $this->syter->spawn('po_entry');
		$data['page_title'] = fa('fa-edit')." Purchase Order Entry";
		
		$data['code'] = build_po_entry_form($po_id);
		$data['load_js'] = 'core/po.php';
        $data['use_js'] = 'poEntryJS';
		$this->load->view('page',$data);
	}
	public function get_supplier_stock_details(){
		$qty='';
		$items=array();
		$branch_id = $this->input->post('branch_id');
		$stock_id = $this->input->post('stock_id');

		$vals = $this->po_model->get_supplier_stock_details($stock_id, $branch_id);
		echo $vals->stock_id."||" //-->0
				.$vals->supp_stock_code."||"  //-->1
				.$vals->uom."||" //-->2
				.$vals->unit_cost."||" //-->3
				.$vals->qty."||" //-->4
				.$vals->disc_percent1."||" //-->5
				.$vals->disc_percent2."||" //-->6
				.$vals->disc_percent3."||" //-->7
				.$vals->disc_amount1."||" //-->8
				.$vals->disc_amount2."||" //-->9
				.$vals->disc_amount3."||"//-->10
				.$vals->description; //-->11
		// echo var_dump($items);
	}
	public function get_supplier_master_details()
	{
		$new_lead_del_date = "";
		$supplier_id = $this->input->post('supplier_id');
		if($supplier_id != '')
		{
			$results = $this->po_model->get_current_supplier_details($supplier_id);
			$res = $results[0];
			$new_lead_del_date = date('m/d/Y',strtotime('+ '.$res->delivery_lead_time.' days'));
			// echo var_dump($res);
			// echo $res->delivery_lead_time."||".$new_lead_del_date;
			echo $new_lead_del_date."||".$res->selling_days;
		}else{
			return false;
		}
	}
	public function load_purch_order_items(){
		$items = array();
		$mode = $this->input->post('mode');
		$ref = $this->input->post('ref');
		// if (strcasecmp($ref,'new')) {
			// $results = $this->po_model->get_purch_orders_temp($ref);
			// echo "<br>".$this->po_model->db->last_query();
			// if ($results) {
				// $items = $results;
			// }
		// }
		
		// echo $ref."<br>";
		if($mode == 'add'){
			$results = $this->po_model->get_purch_orders_temp($ref);
		}else{
			$results = $this->po_model->get_purch_order_details($ref);
		}
		
		if ($results) {
			$items = $results;
		}
		
		$data['code'] = build_purch_order_details_list_form($items, $mode, (!empty($ref) ? $ref : null));
		$data['load_js'] = "core/po.php";
		$data['use_js'] = "reloadPoItemsJS";
		$this->load->view('load',$data);
	}
	//----------GENERATE SUGGESTED QTY----------START
	public function load_suggested_purch_order_items(){
		$items = array();
		$this->load->model('core/inventory_model');
		$user = $this->session->userdata('user');
		// $mode = $this->input->post('mode');
		// $ref = $this->input->post('ref');
		$branch_id = $this->input->post('branch_id');
		$selling_days = $this->input->post('selling_days');
		// echo "This Branch ID: ".$branch_id;
		
		$a = $all_stock_ids = $stock_ids = array();
		
		$latest_date_to = date('Y-m-d', strtotime("- 1 day"));
		$latest_date_from = date('Y-m-d', strtotime($latest_date_to."- 14 days"));
		
		$old_date_to = date('Y-m-d', strtotime($latest_date_from."- 1 day"));
		$old_date_from = date('Y-m-d', strtotime($old_date_to."- 14 days"));
		
		$old_offtake = $latest_offtake = $offtake_percent = $forecasted_qty = $qoh = $suggested_qty = 0;
		
		$user_role = $this->site_model->get_user_details($user['id']);
		
		//-----ROLE-RELATED-----START
		if($user_role->role == ADMINISTRATOR || $user_role->role == DEPT_HEAD)
		{
			$all_stock_ids = $this->inventory_model->get_all_purchaser_stock_ids();
		}else{
			$all_stock_ids = $this->inventory_model->get_all_purchaser_stock_ids($user['id']);
		}
		//-----ROLE-RELATED-----END
		if(!empty($all_stock_ids)){
			foreach($all_stock_ids as $st_val)
			{
				$latest_results = $old_results = array();
				$old_offtake = $latest_offtake = $offtake_percent = $forecasted_qty = $qoh = $suggested_qty = 0;
				
				$latest_results = $this->po_model->get_stock_offtake($latest_date_from, $latest_date_to, $st_val->stock_id, $branch_id); //---GET LATEST OFFTAKE
				// $l_r = $latest_results[0];
				// $old_results = $this->po_model->get_stock_offtake($old_date_from, $old_date_to, $st_val->stock_id, $br_vals->id); //---GET OLD OFFTAKE
				// // $o_r = $old_results[0];
				

				// if(empty($old_results))
					// continue;
				
				if(empty($latest_results))
					continue;
				
				// $old_offtake = $old_results[0]->sales_total/$old_results[0]->dividend;
				$latest_offtake = $latest_results[0]->sales_total/$latest_results[0]->dividend;
				
				// $offtake_percent = 100-(($latest_offtake/$old_offtake)*100);
				
				$qoh = $this->inventory_model->get_stock_qoh($st_val->stock_id, $branch_id);
				// $forecasted_30days_qty = $latest_offtake * OVERSTOCK_DAYS;
				$forecasted_qty = $latest_offtake * $selling_days;
				$suggested_qty = $forecasted_qty - $qoh;
				/*
				$CI->make->th('Item**',array('style'=>''));
				$CI->make->th('Avg. Offtake**',array('style'=>''));
				$CI->make->th('QoH**',array('style'=>''));
				$CI->make->th('Suggested Qty**',array('style'=>''));
				$CI->make->th('Qty**',array('style'=>''));
				$CI->make->th('UOM**',array('style'=>''));
				$CI->make->th('Unit Cost',array('style'=>''));
				*/
				
				// if($qoh > $forecasted_30days_qty)
				if($suggested_qty > 0)
					$a[] = array($this->po_model->get_stock_desc($st_val->stock_id), $latest_offtake,  $qoh, $suggested_qty);
					// $a[] = array($this->po_model->get_stock_desc($st_val->stock_id), $old_offtake, $latest_offtake,  round($offtake_percent,2).' %', $this->po_model->get_branch_code($br_vals->id), $qoh, $forecasted_30days_qty); //original for overstock items array
				
					
			}
			
		}
		// // echo $ref."<br>";
		// if($mode == 'add'){
			// $results = $this->po_model->get_purch_orders_temp($ref);
		// }else{
			// $results = $this->po_model->get_purch_order_details($ref);
		// }
		
		// if ($results) {
			// $items = $results;
		// }
		
		// echo var_dump($a); //-----UNCOMMENT MO TO FOR TESTING PURPOSES
		
		$data['code'] = build_suggested_purch_order_details_list_form($a);
		$data['load_js'] = "core/po.php";
		$data['use_js'] = "reloadPoItemsJS";
		$this->load->view('load',$data);
	}
	//----------GENERATE SUGGESTED QTY----------END
	public function add_to_purch_orders_temp(){
		$user = $this->session->userdata('user');
		$disc_type1 = $this->input->post('disc_type1');
		$disc_type2 = $this->input->post('disc_type2');
		$disc_type3 = $this->input->post('disc_type3');
		
		$items = array(
			'order_no' => $user['id'],
			'supplier_id' => $this->input->post('supplier_id'),
			'comments' => $this->input->post('comments'),
			'ord_date' => date2Sql($this->input->post('ord_date')),
			'into_stock_location' => $this->input->post('stock_location'),
			'into_stock_location' => $this->input->post('stock_location'),
			'delivery_address' => $this->input->post('delivery_address'),
			'delivery_date' => date2Sql($this->input->post('delivery_date')),
			'stock_id' => $this->input->post('stock_id'),
			'description' => $this->input->post('stock_desc'),
			'uom' => $this->input->post('uom'),
			'qty' => $this->input->post('uom_qty'),
			'pack' => $this->input->post('quantity_ordered'),
			// 'unit_cost' => $this->input->post('unit_cost'),
			'unit_cost' => $this->input->post('hidden_disc_unit_cost'),
			'std_unit_cost' => $this->input->post('hidden_unit_cost'),
			'qty_ordered' => $this->input->post('quantity_ordered'),
			'disc_percent1' => ($disc_type1 == 'percent' ? $this->input->post('discount1') : 0),
			'disc_percent2' => ($disc_type2 == 'percent' ? $this->input->post('discount2') : 0),
			'disc_percent3' => ($disc_type3 == 'percent' ? $this->input->post('discount3') : 0),
			'disc_amount1' => ($disc_type1 == 'amount' ? $this->input->post('discount1') : 0),
			'disc_amount2' => ($disc_type2 == 'amount' ? $this->input->post('discount2') : 0),
			'disc_amount3' => ($disc_type3 == 'amount' ? $this->input->post('discount3') : 0),
			'extended' => $this->input->post('total')
		);
		$id = $this->po_model->write_to_purch_orders_temp($items);
		// echo $this->inv_transactions_model->db->last_query();

		echo json_encode(array("msg"=>'Added New Item', "desc"=>$this->input->post('stock_desc')));
	}
	public function generate_suggested_supplier_stocks(){
		$user = $this->session->userdata('user');
		$disc_type1 = $this->input->post('disc_type1');
		$disc_type2 = $this->input->post('disc_type2');
		$disc_type3 = $this->input->post('disc_type3');
		
		// echo $this->inv_transactions_model->db->last_query();

		echo json_encode(array("msg"=>'Added New Item', "desc"=>$this->input->post('stock_desc')));
	}
	public function add_to_main_po_tbl(){
		$user = $this->session->userdata('user');
		$latest_id = $next_id_exists = $stat = $type_no  = $reference = "";
		$trans_ref_items = $po_next_val = $main_items = $sub_items = $partial_items = $upd_items = array();
		
		$po_next_val = $this->site_model->get_next_ref(PURCHASE_ORDER);
		$type_no = $po_next_val->next_type_no;
		$reference = ($this->input->post('reference') ? $this->input->post('reference') : $po_next_val->next_ref);
		
		 $reference = $this->site_model->check_duplicate_ref(PURCHASE_ORDER,$reference);
		
		// echo $type_no ."<--->". $reference ."<br>";
		
		$main_items = array(
			"order_no" => $type_no,
			"branch_id" => $this->input->post('branch_id'),
			"supplier_id" => $this->input->post('supplier_id'),
			"comments" => $this->input->post('comments'),
			"ord_date" => date2Sql($this->input->post('ord_date')),
			"reference" => $reference,
			"into_stock_location" => $this->input->post('stock_location'),
			"delivery_address" => $this->input->post('delivery_address'),
			"delivery_date" => date2Sql($this->input->post('delivery_date')),
			"total_amt" => $this->input->post('total_amt'),
			"created_by" => $user['id']
		);
		// echo var_dump($main_items);
		
		if($this->input->post('form_mode') == 'add'){
			// echo "Add Mode -> ".$this->input->post('hidden_po_order_no')."<br>";

			$id = $this->po_model->write_to_po_header($main_items);
			 
			//-----TRANSFER PO LINE ITEMS FROM TEMP TO MAIN PO DETAILS-----START
			$partial_items = $this->po_model->get_partial_purch_orders_details_temp($user['id']);
			foreach($partial_items as $val){
				$sub_items = array(
					'order_no' => $type_no,
					'stock_id' => $val->stock_id,
					'description' => $val->description,
					'uom' =>$val->uom,
					'qty' => $val->qty,
					'pack' => $val->pack,
					'unit_cost' => $val->unit_cost,
					'std_unit_cost' => $val->std_unit_cost,
					'qty_ordered' => $val->qty_ordered,
					'disc_percent1' => $val->disc_percent1,
					'disc_percent2' => $val->disc_percent2,
					'disc_percent3' => $val->disc_percent3,
					'disc_amount1' => $val->disc_amount1,
					'disc_amount2' => $val->disc_amount2,
					'disc_amount3' => $val->disc_amount3,
					'extended' => $val->extended,
				);
				$id2 = $this->po_model->write_to_purch_order_details($sub_items);
			}
			 //-----TRANSFER PO LINE ITEMS FROM TEMP TO MAIN PO DETAILS-----END
			##########AUDIT TRAIL [START]##########
				$audit_items = array(
				'type'=>0,
				'trans_no'=>0,
				'type_desc'=>ADDED_PURCHASE_ORDER,
				'description'=>'id:'.$id.'||branch_code:"'.$this->po_model->get_branch_code($this->input->post('branch_id')).'||user_name:"'.$this->po_model->get_user_name($user['id']).'||delivery_date:"'.date('Y-M-d', strtotime($this->input->post('delivery_date'))).'"',
				'user'=>$user['id']
				);
				
				$audit_id = $this->po_model->write_to_audit_trail($audit_items);
			##########AUDIT TRAIL [END]##########
			 //-----INSERTION IN TRANS_REF-----START
			$trans_ref_items = array(
				'trans_type'=>PURCHASE_ORDER,
				'type_no'=>$type_no,
                'reference'=>$reference,
                'branch_id'=>$this->input->post('branch_id')
			);
			$this->site_model->add_trans_ref($trans_ref_items); //-->This function inserts into trans_refs and updates the trans_types table at the same time
			//-----INSERTION IN TRANS_REF-----END
			
			$this->po_model->delete_from_purch_order_details_temp($user['id']);
			
			$msg = "Successfully ADDED P.O.";
			$status = "success";
			
		}else{
			// echo "Edit Mode -> ".$this->input->post('hidden_po_order_no')."<br>";
			$this->po_model->update_po_header($items,$this->input->post('hidden_po_order_no'));
			$id = $this->input->post('hidden_po_order_no');
			$msg = "Successfully UPDATED P.O.";
			$status = "success";
		}
		
		// echo $stat;
		echo json_encode(array("msg" => $msg, "status" => $status));
	}
	public function remove_po_details_line_item(){
		$this->po_model->delete_purch_orders_temp_line_item($this->input->post('line_id'));
	}
	public function remove_from_main_po_details_line_item(){
		$this->po_model->delete_purch_order_details_line_item($this->input->post('line_id'));
	}
	//----------PURCHASE ORDER ENTRY----------END
	//----------EDIT PURCHASE ORDER----------START
	public function edit_po_entry($po_id=null){
		$data = $this->syter->spawn('po_entry');
		$data['page_title'] = fa('fa-edit')." Edit Purchase Order Entry";

		$res = $this->po_model->get_purch_orders($po_id);

		$items = $res[0];
		$data['code'] = build_edit_po_entry_form($po_id, $items);
		$data['load_js'] = 'core/po.php';
        $data['use_js'] = 'editPoEntryJS';
		$this->load->view('page',$data);
	}
	public function load_edit_purch_order_items(){
		$items = array();
		$ref = $this->input->post('ref');
		
		$results = $this->po_model->get_purch_order_details($ref);
		
		if ($results) {
			$items = $results;
		}
		
		$data['code'] = build_purch_order_details_list_edit_form($items, (!empty($ref) ? $ref : null));
		$data['load_js'] = "core/po.php";
		$data['use_js'] = "reloadEditPoItemsJS";
		$this->load->view('load',$data);
	}
	public function add_to_purch_order_details(){
		$user = $this->session->userdata('user');
		$disc_type1 = $this->input->post('disc_type1');
		$disc_type2 = $this->input->post('disc_type2');
		$disc_type3 = $this->input->post('disc_type3');
		
		$items = array(
			'order_no' => $this->input->post('hidden_po_order_no'),
			'stock_id' => $this->input->post('stock_id'),
			'description' => $this->input->post('stock_desc'),
			'uom' => $this->input->post('uom'),
			'qty' => $this->input->post('uom_qty'),
			'pack' => $this->input->post('quantity_ordered'),
			'unit_cost' => $this->input->post('hidden_disc_unit_cost'),
			'std_unit_cost' => $this->input->post('hidden_unit_cost'),
			'qty_ordered' => $this->input->post('quantity_ordered'),
			'disc_percent1' => ($disc_type1 == 'percent' ? $this->input->post('discount1') : 0),
			'disc_percent2' => ($disc_type2 == 'percent' ? $this->input->post('discount2') : 0),
			'disc_percent3' => ($disc_type3 == 'percent' ? $this->input->post('discount3') : 0),
			'disc_amount1' => ($disc_type1 == 'amount' ? $this->input->post('discount1') : 0),
			'disc_amount2' => ($disc_type2 == 'amount' ? $this->input->post('discount2') : 0),
			'disc_amount3' => ($disc_type3 == 'amount' ? $this->input->post('discount3') : 0),
			'extended' => $this->input->post('total')
		);
		$id = $this->po_model->write_to_purch_order_details($items);
		// echo $this->inv_transactions_model->db->last_query();

		echo json_encode(array("msg"=>'Added New Item', "desc"=>$this->input->post('stock_desc')));
	}
	public function update_main_po_tbl(){
		$user = $this->session->userdata('user');
		$latest_id = $next_id_exists = $stat = $type_no  = $reference = "";
		$trans_ref_items = $po_next_val = $main_items = $sub_items = $partial_items = $upd_items = array();
		
		// $po_next_val = $this->site_model->get_next_ref(PURCHASE_ORDER);
		// $type_no = $po_next_val->next_type_no;
		// $reference = ($this->input->post('reference') ? $this->input->post('reference') : $po_next_val->next_ref);
		
		// $reference = $this->site_model->check_duplicate_ref(PURCHASE_ORDER,$reference);
		$order_no = $this->input->post('hidden_po_order_no');
		$main_items = array(
			// "order_no" => $this->input->post('hidden_po_order_no'),
			"branch_id" => $this->input->post('branch_id'),
			"supplier_id" => $this->input->post('supplier_id'),
			"comments" => $this->input->post('comments'),
			"ord_date" => date2Sql($this->input->post('ord_date')),
			// "reference" => $reference,
			"into_stock_location" => $this->input->post('stock_location'),
			"delivery_address" => $this->input->post('delivery_address'),
			"delivery_date" => date2Sql($this->input->post('delivery_date')),
			"total_amt" => $this->input->post('total_amt')
		);
		// echo var_dump($main_items);
		
		// echo "Edit Mode -> ".$this->input->post('hidden_po_order_no')."<br>";
		$this->po_model->update_po_header($main_items,$this->input->post('hidden_po_order_no'));
		$id = $this->input->post('hidden_po_order_no');
		$msg = "Successfully UPDATED P.O.";
		$status = "success";
		
		// echo $stat;
		echo json_encode(array("msg" => $msg, "status" => $status, "id" =>$order_no));
	}
	//----------EDIT PURCHASE ORDER----------END
	public function send_email($type=null, $details=null){
		 $mail = new PHPMailer();
		 $this->load->model('core/mail_model');
		 
		$thisrow = $this->mail_model->email_configuration();
		$e_config = $thisrow[0];
		
		/*
		//------------MS Exchange
		$mail->IsSMTP(); // we are going to use SMTP
		// $mail->SMTPDebug  = 2; //TEST
        $mail->SMTPAuth   = true; // enabled SMTP authentication
        // $mail->SMTPSecure = "ssl";  // prefix for secure protocol to connect to the server //FOR GMAIL
        $mail->SMTPSecure = "tls";  // prefix for secure protocol to connect to the server //FOR MS EXCHANGE
        $mail->Host       = $e_config->host_name; //"smtp.gmail.com";      // setting GMail as our SMTP server
        $mail->Port       = $e_config->port_number; //465 - port number pang SSL  //587 - port number pang SSL
        // $mail->Port       = "465"; // port number pang SSL
        // $mail->Port       = "587"; // port number pang TLS (working for MS EXCHANGE)
        $mail->Username   = $e_config->username; //"myusername@gmail.com";  // user email address
        $mail->Password   = $e_config->password; //"testmail00000"; //"password";            // password in GMail
        // $mail->SetFrom('mytest.email00000@gmail.com', 'HRIS');  //Who is sending the email
        $mail->SetFrom('hrd.info@inlandph.com', 'HRIS');  //Who is sending the email
		*/
		
		/*
		//------------GMAIL
        $mail->IsSMTP(); // we are going to use SMTP
        $mail->SMTPAuth   = true; // enabled SMTP authentication
        $mail->SMTPSecure = "ssl";  // prefix for secure protocol to connect to the server
        $mail->Host       = $e_config->host_name; //"smtp.gmail.com";      // setting GMail as our SMTP server
        $mail->Port       = $e_config->port_number;  //465;                   // SMTP port to connect to GMail
        $mail->Username   = $e_config->username; //"myusername@gmail.com";  // user email address
        $mail->Password   = $e_config->password; //"testmail00000"; //"password";            // password in GMail
        // $mail->SetFrom('mytest.email00000@gmail.com', 'HRIS');  //Who is sending the email
        $mail->SetFrom($e_config->sender_email, 'DATACENTER');  //Who is sending the email
        // $mail->AddReplyTo("allynmacalinao@yahoo.com","Firstname2 Lastname2");  //email address that receives the response
		*/
		
		//------------SRS Mailer
		$mail->IsSMTP(); // we are going to use SMTP
		// $mail->Host       = "192.168.0.213";      // setting SRS Mail as our SMTP server
		$mail->Host       = $e_config->host_name;      // setting SRS Mail as our SMTP server
		// $mail->Port       = 25;  //465;                   // SMTP port to connect to GMail
		$mail->Port       = $e_config->port_number;  //465;                   // SMTP port to connect to GMail
		// $mail->SetFrom('no-reply@srssulit.com', 'DATACENTER');  //Who is sending the email
		$mail->SetFrom($e_config->sender_email, 'DATACENTER');  //Who is sending the email
		
		switch($type){
			case 'test' : 
				// $mail->Subject    = $details['emp_full_name']." - Employee Update for Approval";
				
				$mail->Subject    = "Extension of Delivery Date for PO #".$details['order_no'];
					$body = "<p>Good day ".$details['supplier_name'].",</p>
									<br>
									Delivery Date for unserved PO # ".$details['order_no']." was changed from ".date('M-d-Y', strtotime($details['old_delivery_date']))." to <b>".date('M-d-Y', strtotime($details['new_delivery_date']))."</b>
									<br>
									<!--a href='http://tumblr.com'>Click this link to redirect...</a-->
									<b><i>Kindly deliver on or before the expected delivery date.</i></b>
									<br>
									<br>
									<hr>
									<label style='font-size: 12px; font-family: Trebuchet MS; color: red;'>This is a system generated email. Please do not reply to this message.</label>
									";
					// $mail->Body      = $body; //alt
					$mail->MsgHTML($body);
					$mail->AltBody    = "To view the message, please use an HTML compatible email viewer."; // optional, comment out and test
					
					// echo var_dump($e_config);
					
					//one recipient
					$hr_email = "allynmacalinao@gmail.com";
					// $hr_email = $e_config->sender_email;
					$mail->AddAddress($hr_email, $details['supplier_name']);
					
					/* //many recipients
					$recipients = array('allynmacalinao@yahoo.com' => 'HR Dept. Head');
					foreach($recipients as $email => $name)
					{
					   $mail->AddAddress($email, $name);
					   // $mail->AddCC($email, $name); //for CC
					}
					*/
					
					/*$mail->AddAttachment('system_attachments/Requirements.txt');
					$mail->AddAttachment('system_attachments/Map.jpg');*/
					break; //end of hr_emp_log_notification
			case 'po_details' : 
			
					break;
			case 'regenerate_po' : 
				// $mail->Subject    = $details['emp_full_name']." - Employee Update for Approval";
				$main_items = $sub_items = $this_item = array();
				
				$mail->Subject    = "Generation of NEW PO";
					$body = "<p>Good day ".$details['supplier_name'].",</p>
									<br>
									Please disregard PO # ".$details['order_no']." and use the one attached in this email (NEW PO # ".$details['new_order_no'].").
									<br>
									<!--a href='http://tumblr.com'>Click this link to redirect...</a-->
									<b><i>Kindly deliver on or before the expected delivery date.</i></b>
									<br>
									<br>
									<hr>
									<label style='font-size: 12px; font-family: Trebuchet MS; color: red;'>This is a system generated email. Please do not reply to this message.</label>
									";
					// $mail->Body      = $body; //alt
					$mail->MsgHTML($body);
					$mail->AltBody    = "To view the message, please use an HTML compatible email viewer."; // optional, comment out and test
					
					// echo var_dump($e_config);
					
					//one recipient
					$hr_email = "allynmacalinao@gmail.com";
					// $hr_email = $e_config->sender_email;
					$mail->AddAddress($hr_email, $details['supplier_name']);
					
					/* //many recipients
					$recipients = array('allynmacalinao@yahoo.com' => 'HR Dept. Head');
					foreach($recipients as $email => $name)
					{
					   $mail->AddAddress($email, $name);
					   // $mail->AddCC($email, $name); //for CC
					}
					*/
					
					/*$mail->AddAttachment('system_attachments/Requirements.txt');
					$mail->AddAttachment('system_attachments/Map.jpg');*/
					
					// $mail->AddAttachment('report.txt'); //if you are going to attach an actual file
					$order_no = $details['order_no'];
					
					$main_items = $this->po_model->get_purch_orders($order_no);
					$this_item = $main_items[0];
					$sub_items = $this->po_model->get_purch_order_details($order_no);
					
					$fileAttached = "";
					$fileAttached = $this->print_me_pdf($this_item, $sub_items);
					// echo $fileAttached;
					$mail->AddStringAttachment($fileAttached, 'po_printout.pdf');
					
					break; //end of hr_emp_log_notification
		}
		
		if(!$mail->Send()) {
			//echo "=====>Di nagsend====".$mail->ErrorInfo;
            // $data["message"] = "Error: " . $mail->ErrorInfo;
			// display_msg("error","Error: " . $mail->ErrorInfo);
			// echo $mail->ErrorInfo;
			// echo "warning";
			$mail->ClearAddresses();
			$mail->ClearAttachments();
        } else {
            // echo "=====Nagsend";
			// $data["message"] = "Message sent correctly!";
			$mail->ClearAddresses();
			$mail->ClearAttachments();
			// display_msg("success","Request sent!");
			// echo "Request Sent!";
			echo "success";
        }
		 
	}
	public function send_test_mail(){
		$this->send_email('test');
	}
	/*********************PRINT ME PDF-START**********************/
	// public function print_me_pdf($header_items=array(), $content_items=array()){
		// $this->load->library('My_TCPDF');
		// $pdf = new TCPDF("P", "mm", 'FOLIO', true, 'UTF-8', false);
		
		// date_default_timezone_set('Asia/Manila');
		
		// $filename = "Purchase Order Details.pdf";
		// $title = "Purchase Order Details for ".$header_items->reference;
		
		// $pdf->SetTitle($title);
		// $pdf->SetTopMargin(10);
		// $pdf->SetLeftMargin(10);
		// $pdf->SetRightMargin(10);
		// $pdf->SetFooterMargin(10);
		// $pdf->SetAutoPageBreak(true, 15);
		// // $pdf->SetAuthor('Author');
		// $pdf->SetDisplayMode('real','default');
		// $pdf->setPrintHeader(false);
		// $pdf->setPrintFooter(true);
		
		// $pdf->AddPage();
		// $pdf->SetFont('helvetica', '', 14);
		
		// $tin = "007-492-840-014";
		// $rep_content = "
		// <table width=\"100%\" cellpadding=\"1px\" border=\"0px\">
			// <tr>
				// <td width=\"80%\" style=\"font-size: 14px; font-weight: bold;\">SAN ROQUE SUPERMARKET RETAIL SYSTEMS, INC</td>
				// <td width=\"20%\" style=\"font-size: 14px; font-weight: bold;\">Purchase Order</td>
			// </tr>
			// <tr>
				// <td width=\"80%\" style=\"font-size: 14px; font-weight: none;\">".$header_items->delivery_address."</td>
				// <td width=\"20%\" style=\"font-size: 14px; font-weight: none;\">No.</td>
			// </tr>
			// <tr>
				// <td width=\"80%\" style=\"font-size: 14px; font-weight: bold;\">$tin</td>
				// <td width=\"20%\" style=\"font-size: 14px; font-weight: bold;\">".$header_items->reference."</td>
			// </tr>
			// <tr>
				// <td width=\"80%\" style=\"font-size: 14px; font-weight: bold;\">&nbsp;</td>
				// <td width=\"20%\" style=\"font-size: 14px; font-weight: none;\">Delivery Date</td>
			// </tr>
			// <tr>
				// <td width=\"80%\" style=\"font-size: 14px; font-weight: bold;\">&nbsp;</td>
				// <td width=\"20%\" style=\"font-size: 14px; font-weight: bold;\">".date('m/d/Y', strtotime($header_items->delivery_date))."</td>
			// </tr>
		// </table>
		// ";
		// $rep_content .= "</table><br><br>";
		
		// $rep_content .= "<table width=\"100%\" cellpadding=\"1px\" border=\"1px\">";
		// $rep_content .= "
			// <tr>
				// <td style=\"font-size: 11px; font-weight: bold; text-align: left;\">Description</td>
				// <td style=\"font-size: 11px; font-weight: bold; text-align: center;\">UOM</td>
				// <td style=\"font-size: 11px; font-weight: bold; text-align: center;\">Unit Cost</td>
				// <td style=\"font-size: 11px; font-weight: bold; text-align: center;\">Qty Ordered</td>
				// <td style=\"font-size: 11px; font-weight: bold; text-align: center;\">Extended</td>
			// </tr>
			// ";
		
		// $pdf->SetFont('courier', 'B', 9);
		// foreach($content_items as $val){
			// $rep_content .= "
			// <tr>
				// <td style=\"font-size: 11px; text-align: left;\">".$val->description."</td>
				// <td style=\"font-size: 11px; text-align: center;\">".$val->uom."</td>
				// <td style=\"font-size: 11px; text-align: center;\">".$val->unit_cost."</td>
				// <td style=\"font-size: 11px; text-align: center;\">".$val->qty_ordered."</td>
				// <td style=\"font-size: 11px; text-align: center;\">".$val->extended."</td>
			// </tr>
			// ";
		// }
		
		// $pdf->SetFont('helvetica', '', 14);
		// $rep_content .= "	
		// </table>
		// ";
		
		// $pdf->writeHTML($rep_content,true,false,false,false,'');
		
		// return $pdf->Output($filename, 'S');
		
	// }
	/*********************PRINT ME PDF-END**********************/
	public function print_me_pdf($header_items=array(), $content_items=array()){
		date_default_timezone_set('Asia/Manila');
		$this->load->library('My_TCPDF');
		// $pdf = new TCPDF("P", "mm", 'FOLIO', true, 'UTF-8', false);
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'Letter', false, 'UTF-8', false);
		
		$filename = "Purchase Order Details.pdf";
		$title = "Purchase Order Details for ".$header_items->reference;
		$tin = $this->po_model->get_branch_tin($header_items->branch_id);
		
		$supplier = $this->po_model->get_supplier_details($header_items->supplier_id);
		$supplier_det = $supplier[0];
		
		$pdf->po_no = $header_items->reference;
		
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_BOTTOM);
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(true);
		
		$pdf->AddPage();
		
		$pdf->SetFont('helvetica', 'B', 15);
		$pdf->Cell(150, 15, COMPANY_NAME, 0, false, 'L', 0, '', 0, false, 'M', 'M');
		$pdf->Cell(70, 15, "Purchase Order", 0, false, 'L', 0, '', 0, false, 'M', 'M');
		$pdf->Ln(5);
        $pdf->SetFont('helvetica', null, 12);
		$pdf->Cell(150, 15, $header_items->delivery_address, 0, false, 'L', 0, '', 0, false, 'M', 'M');
        $pdf->SetFont('helvetica', null, 10);
		$pdf->Cell(70, 15, "No.", 0, false, 'L', 0, '', 0, false, 'M', 'M');
        $pdf->Ln(5);
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(150, 15, $tin, 0, false, 'L', 0, '', 0, false, 'M', 'M');
		$pdf->Cell(70, 15, $header_items->reference, 0, false, 'L', 0, '', 0, false, 'M', 'M');
        $pdf->Ln(5);
        $pdf->SetFont('helvetica', null, 10);
		$pdf->Cell(150, 15, "", 0, false, 'L', 0, '', 0, false, 'M', 'M');
		$pdf->Cell(70, 15, "Delivery Date", 0, false, 'L', 0, '', 0, false, 'M', 'M');
        $pdf->Ln(5);
		$pdf->Cell(150, 15, "", 0, false, 'L', 0, '', 0, false, 'M', 'M');
		$pdf->SetFont('helvetica', 'B', 10);
		$pdf->Cell(70, 15, sql2Date($header_items->delivery_date), 0, false, 'L', 0, '', 0, false, 'M', 'M');
		
		$w = array(70, 90, 55,60);
		$pdf->Ln(10);
		$pdf->SetFont('helvetica', null, 10);
		$pdf->Cell(80, 15, "Supplier", 0, false, 'L', 0, '', 0, false, 'M', 'M');
		$pdf->Cell(100, 15, "Recieve At", 0, false, 'L', 0, '', 0, false, 'M', 'M');
		
		$pdf->Ln(1.5);
		$pdf->SetFont('helvetica', 'B', 12);
		$pdf->MultiCell(80, 15,$supplier_det->supp_name,0,'L',false,0);
		$pdf->MultiCell(100, 15, COMPANY_NAME,0,'L',false,1);
		
		$pdf->SetFont('helvetica', null, 9);
		$pdf->Cell(80, 15, $supplier_det->address, 0, false, 'L', 0, '', 0, false, 'M', 'M');
		$pdf->Cell(100, 15, $header_items->delivery_address, 0, false, 'L', 0, '', 0, false, 'M', 'M');
		$pdf->SetFont('helvetica', 'B', 12);
		$pdf->Ln(4);
		$pdf->SetFont('helvetica', null, 9);
		$pdf->Cell(80, 15, $supplier_det->contact_person, 0, false, 'L', 0, '', 0, false, 'M', 'M');
		$pdf->Cell(100, 15, $tin, 0, false, 'L', 0, '', 0, false, 'M', 'M');
		$pdf->Ln(5);
		
		$pdf->SetFont('helvetica', 'B', 12);
		$header = array();
		$header = array('Code', '   Particulars ', ' UOM ',' Qty ', 'Price  ' , '  Extended');
	    // Header
	    $w = array(25, 90, 15 , 15, 20 ,  20 );
	    $num_headers = count($header);
	    for($i = 0; $i < $num_headers; $i++) {
	        if($i > 2){
	        	$pdf->Cell($w[$i], 7, $header[$i], 0, 0, 'R', 0);
	        }
	        else
		        $pdf->Cell($w[$i], 7, $header[$i], 0, 0, 'L', 0);
	    }
        $pdf->Ln(6);
		
		$fill = 0;
		$po_total=0;
	    $qty_total=0;
		
		foreach($content_items as $val){
			$pdf->SetFont('courier', null, 8);
	        $pdf->Cell($w[0], 6, $this->po_model->get_supplier_stock_code_from_stock_id($val->stock_id), 0, 0, 'L', $fill);
			$pdf->SetFont('courier', 'B', 9);
	        $pdf->Cell($w[1], 6, ' '.$val->description, 0, 0, 'L', $fill);
	        $pdf->Cell($w[2], 6, ' '.$val->uom, 0, 0, 'L', $fill);
	        $pdf->Cell($w[3], 6, ' '.num($val->qty_ordered).' ', 0, 0, 'R', $fill);
	        $pdf->Cell($w[4], 6, ' '.num($val->unit_cost).' ', 0, 0, 'R', $fill);
	       	// $total = $row->ord_qty * $row->unit_price; //original
	       	$total = $val->extended;
	        // $discTxt = "";
			// if($row->discounts != "" || $row->discounts != 0){
				// $discounts = explode(',', $row->discounts);
				// foreach ($discounts as $discs) {
					// $disc = explode('=>',$discs);
					// if (count($disc) <= 1)
						// continue;
					// $discTxt .= $disc[0];
					// $total -= $disc[1];
				// }
			// }
	        $pdf->Cell($w[5], 6, num($total), 0, 0, 'R', $fill);
	        $po_total += $total;
	        $qty_total += $val->qty_ordered;
	        $pdf->Ln(4);
		}
		
		//~~~~~~~~~FOR TOTALS~~~~~~~~~~//
		$pdf->SetFont('courier', null, 9);
		$pdf->Ln(6);
		$pdf->Cell($w[0], 6, '', 0, 0, 'L', $fill);
        $pdf->Cell($w[1], 6, '', 0, 0, 'L', $fill);
        $pdf->SetFont('helvetica', 'B', 14);
        $pdf->Cell($w[2], 6, '', 0, 0, 'R', $fill);
        $pdf->Cell($w[3], 6, 'Total Qty', 0, 0, 'R', $fill);
        $pdf->Cell($w[4], 6, null, 0, 0, 'R', $fill);
		
		$pdf->SetFont('helvetica', 'B', 14);
        $pdf->Cell($w[5], 6, 'Grand Total', 0, 0, 'R', $fill);
		
		$pdf->Ln(6);
        $pdf->Cell($w[0], 6, '', 0, 0, 'L', $fill);
        $pdf->Cell($w[1], 6, '', 0, 0, 'L', $fill);
        $pdf->SetFont('helvetica', 'B', 14);
        $pdf->Cell($w[2], 6, '', 0, 0, 'R', $fill);
        $pdf->Cell($w[3], 6, num($qty_total), 0, 0, 'R', $fill);
		
		$pdf->Cell($w[4], 6, null, 0, 0, 'R', $fill);
		
		$pdf->SetFont('helvetica', 'B', 14);
        $pdf->Cell($w[5], 6,  num($po_total), 0, 0, 'R', $fill);
		
		$pdf->Ln(8);
		
		if ($pdf->GetY() > $pdf->getPageHeight() - (PDF_MARGIN_BOTTOM+13))
			$pdf->AddPage();
		
		$pdf->SetFont('helvetica', 'B', 12);
   		$pdf->Cell($w[0], 6, "Remarks", 0, 0, 'L', $fill);
   		$pdf->SetFont('helvetica', '', 8);
        $pdf->Cell($w[1], 6, null, 0, 0, 'R', $fill);
        $pdf->Cell($w[2], 6, null, 0, 0, 'R', $fill);
        $pdf->Cell($w[3], 6, null, 0, 0, 'R', $fill);
        $pdf->Cell($w[4], 6, null, 0, 0, 'R', $fill);
        $pdf->Cell($w[5], 6, null, 0, 0, 'L', $fill);
		
		if(count($header_items->comments) > 0 )
		{
	        $pdf->Ln(5);
			$pdf->SetFont('helvetica', null, 11);
	   		$pdf->Cell($w[0], 6, $header_items->comments, 0, 0, 'L', $fill);
	        $pdf->Cell($w[1], 6, null, 0, 0, 'R', $fill);
	        $pdf->Cell($w[2], 6, null, 0, 0, 'L', $fill);
	        $pdf->Cell($w[3], 6, null, 0, 0, 'R', $fill);
	        $pdf->Cell($w[4], 6, null, 0, 0, 'R', $fill);
	        $pdf->Cell($w[5], 6, null, 0, 0, 'R', $fill);
    	}
		
        $pdf->Ln();
		
		//~~~~~~~~~FOR SIGNATURES~~~~~~~~~~//
		// $prepared_by = $this->po_model->get_po_prepared_by(16, $branch->order_no);
		// $prepared_by_sign = $prepared_by[0]->sign;
		// $prepared_by = $prepared_by[0]->prepared_by;
		
		// $approved_by = $this->po_model->get_po_approved_by(16, $branch->order_no);
		// $approved_by_sign = $approved_by[0]->sign;
		// $approved_by = $approved_by[0]->approved_by;
		
		$prepared_by = $header_items->created_by;
		$prepared_by_sign = $header_items->created_by;
		
		$approved_by = $header_items->posted_by;
		$approved_by_sign = $header_items->posted_by;
		
		$p_sign = BASEPATH.'../signatures/'.$prepared_by_sign.'.png';
		$a_sign = BASEPATH.'../signatures/'.$approved_by_sign.'.png';

		if ($pdf->GetY() > $pdf->getPageHeight() - (PDF_MARGIN_BOTTOM+13))
			$pdf->AddPage();
			
		$pdf->SetY($pdf->getPageHeight() - (PDF_MARGIN_BOTTOM+13));
		$ww = 35;
		
		$pdf->SetFont('helvetica', '', 10);
		$pdf->Cell($ww-7, 6, '', 'LT', 0, 'L', $fill);
		$pdf->SetFont('helvetica', 'B', 10);
   		$pdf->Cell($ww, 6, '', 'RT', 0, 'L', $fill);
		$pdf->SetFont('helvetica', '', 10);
   		$pdf->Cell($ww-8, 6, '', 'LT', 0, 'L', $fill);
		$pdf->SetFont('helvetica', 'B', 10);
		$pdf->Cell($ww, 6, '', 'RT', 0, 'L', $fill);
		$pdf->SetFont('helvetica', '', 10);
   		$pdf->Cell($ww-8, 6, '', 'LT', 0, 'L', $fill);
		$pdf->SetFont('helvetica', 'B', 10);
		$pdf->Cell($ww, 6, '', 'RT', 0, 'L', $fill);
        $pdf->Ln();
		
		
		$pdf->SetFont('helvetica', '', 10);
   		$pdf->Cell($ww-13, 6, 'Prepared by: ', 'LB', 0, 'L', $fill);
		$pdf->SetFont('helvetica', 'B', 10);
   		$pdf->Cell($ww+6, 6, $this->po_model->get_user_name($prepared_by), 'RB', 0, 'L', $fill);
		$pdf->SetFont('helvetica', '', 10);
   		$pdf->Cell($ww-8, 6, 'Checked by: ', 'LB', 0, 'L', $fill);
		$pdf->SetFont('helvetica', 'B', 10);
		$pdf->Cell($ww, 6, '', 'RB', 0, 'L', $fill);
		$pdf->SetFont('helvetica', '', 10);
   		$pdf->Cell($ww-13, 6, 'Approved by: ', 'LB', 0, 'L', $fill);
		$pdf->SetFont('helvetica', 'B', 10);
		$pdf->Cell($ww+5, 6, ($approved_by != '' ? $this->po_model->get_user_name($approved_by) : ''), 'RB', 0, 'L', $fill);
		
		
		if ($prepared_by_sign != ''){
			$pdf->Image($p_sign,30,244,0,20);
		}

		if ($approved_by_sign != ''){
			// $pdf->Image($a_sign,154,249,0,20);
			$pdf->Image($a_sign,154,244,0,20);
		}
		
		// $pdf->Ln();
		
		$pdf->SetFont('helvetica', null, 8);
		$pdf->SetY($pdf->getPageHeight() - (PDF_MARGIN_BOTTOM+4));
		// $pdf->SetY($pdf->getPageHeight() - (PDF_MARGIN_BOTTOM));
		
		return $pdf->Output($filename, 'S');
		
	}
	public function generate_new_po(){
		$user = $this->session->userdata('user');
		$order_no = $this->input->post('order_no');
		$main_items = $sub_items = $details = array();
		$test_new_po = 0;
		
		$this_item = array();
		
		$items = array(
		 "status"=>3,
		 "modified_by"=>$user['id'],
		 "datetime_modified"=>date('Y-m-d H:i:s')
		);
		##########AUDIT TRAIL [START]##########
		$audit_items = array(
			'type'=>0,
			'trans_no'=>0,
			'type_desc'=>GENERATE_NEW_PURCHASE_ORDERS,
			'description'=>'order_no:'.$order_no.'||"',
			'user'=>$user['id']
			);
			
		$audit_id = $this->po_model->write_to_audit_trail($audit_items);
		##########AUDIT TRAIL [END]##########
		
		// $this->po_model->update_po_header($items, $order_no); //-----DISABLED FOR TESTING PURPOSES ONLY
		$partial_items = $this->po_model->get_partial_purch_orders_details_new($order_no); //-----DISABLED FOR TESTING PURPOSES ONLY
		foreach($partial_items as $val){
				$sub_items = array(
					'order_no' => $user['id'],
					'supplier_id' => $val->supplier_id,
					"ord_date" => date2Sql($val->ord_date),
					"into_stock_location" => $val->into_stock_location,
					"delivery_address" => $val->delivery_address,
					"delivery_date" => date2Sql($val->delivery_date),
					"total_amt" => $val->total_amt,
					'stock_id' => $val->stock_id,
					'description' => $val->description,
					'uom' =>$val->uom,
					'qty' => $val->qty,
					'pack' => $val->pack,
					'unit_cost' => $val->unit_cost,
					'std_unit_cost' => $val->std_unit_cost,
					'qty_ordered' => $val->qty_ordered,
					'disc_percent1' => $val->disc_percent1,
					'disc_percent2' => $val->disc_percent2,
					'disc_percent3' => $val->disc_percent3,
					'disc_amount1' => $val->disc_amount1,
					'disc_amount2' => $val->disc_amount2,
					'disc_amount3' => $val->disc_amount3,
					'extended' => $val->extended,
				);
		$id = $this->po_model->write_to_purch_order_details_temp($sub_items); //-----DISABLED FOR TESTING PURPOSES ONLY
		};
		//echo var_dump($items_temp);
		// //$test_new_po = ($order_no+1)+0;
		
		// $main_items = $this->po_model->get_purch_orders($order_no);
		// $this_item = $main_items[0];
		// $sub_items = $this->po_model->get_purch_order_details($order_no);
		
		// $details = array(
			// "supplier_name"=>$this->po_model->get_supplier_name($this_item->supplier_id),
			// "order_no"=>$order_no,
			// "new_order_no"=>$test_new_po
		// );
		echo 'success';
		// $this->send_email('regenerate_po', $details);
	}
	public function cancel_po(){
		$user = $this->session->userdata('user');
		$order_no = $this->input->post('order_no');
		$main_items = $sub_items = $details = array();
		$test_new_po = 0;

		$this_item = array();
		
		$items = array(
		 "status"=>3,
		 "modified_by"=>$user['id'],
		 "datetime_modified"=>date('Y-m-d H:i:s')
		);
		##########AUDIT TRAIL [START]##########
			$audit_items = array(
			'type'=>0,
			'trans_no'=>0,
			'type_desc'=>CANCELED_PURCHASE_ORDER,
			'description'=>'order_no:'.$order_no.'||"',
			'user'=>$user['id']
			);
			
			$audit_id = $this->po_model->write_to_audit_trail($audit_items);
		##########AUDIT TRAIL [END]##########
		$this->po_model->update_po_header($items, $order_no); //-----DISABLED FOR TESTING PURPOSES ONLY
		
		echo 'success';
	}
	public function checked_cancel_po(){
		$user = $this->session->userdata('user');
		$ids = $this->input->post('ids');
		$num = 0;
		
		$ppo_ids = array();
		$ids_count = count($ids); 
				while($ids_count != $num){
						$num = $num + 1;
					$con_id  = explode('|',$ids[$num-1]);
					if($con_id[0] == 'true'){
						array_push($ppo_ids,$con_id[1]);
						$items = array(
						 "status"=>3,
						 "modified_by"=>$user['id'],
						 "datetime_modified"=>date('Y-m-d H:i:s')
						);
						##########AUDIT TRAIL [START]##########
							$audit_items = array(
							'type'=>0,
							'trans_no'=>0,
							'type_desc'=>CANCELED_PURCHASE_ORDER,
							'description'=>'order_no:'.$con_id[1].'||"',
							'user'=>$user['id']
							);
							
							$audit_id = $this->po_model->write_to_audit_trail($audit_items);
						##########AUDIT TRAIL [END]##########
						$this->po_model->update_po_header($items, $con_id[1]);
					}
				}
		echo 'success';
	}
	/**FOR GENERATE NEW PURCHASE ORDERS**/
	public function generate_new_po_entry($po_id=null){
		$data = $this->syter->spawn('po_entry');
		$data['page_title'] = fa('fa-edit')."Generate New Purchase Order Entry";
		$res = $this->po_model->get_purch_orders($po_id);

		$items = $res[0];
		//echo var_dump($items);
		//$data['code'] = build_edit_po_entry_form($po_id, $items);
		$data['code'] = build_generate_new_po_entry_form($po_id, $items);
		$data['load_js'] = 'core/po.php';
        $data['use_js'] = 'genPOEntryJS';
		$this->load->view('page',$data);
	}
	public function add_to_gen_main_po_tbl(){
		$user = $this->session->userdata('user');
		$latest_id = $next_id_exists = $stat = $type_no  = $reference = "";
		$trans_ref_items = $po_next_val = $main_items = $sub_items = $partial_items = $upd_items = array();
		$test_new_po = 0;
		$po_next_val = $this->site_model->get_next_ref(PURCHASE_ORDER);
		$type_no = $po_next_val->next_type_no;
		$reference = ($this->input->post('reference') ? $this->input->post('reference') : $po_next_val->next_ref);
		
		 $reference = $this->site_model->check_duplicate_ref(PURCHASE_ORDER,$reference);
		
		// echo $type_no ."<--->". $reference ."<br>";
		
		$main_items = array(
			"order_no" => $type_no,
			"branch_id" => $this->input->post('branch_id'),
			"supplier_id" => $this->input->post('supplier_id'),
			"comments" => $this->input->post('comments'),
			"ord_date" => date2Sql($this->input->post('ord_date')),
			"reference" => $reference,
			"into_stock_location" => $this->input->post('stock_location'),
			"delivery_address" => $this->input->post('delivery_address'),
			"delivery_date" => date2Sql($this->input->post('delivery_date')),
			"total_amt" => $this->input->post('total_amt'),
			"created_by" => $user['id'],
			"status" => 1,
			"posted_by" => $user['id'],
			"date_posted" => date2Sql(date("Y-M-d"))
		);
		// echo var_dump($main_items);
		
		if($this->input->post('form_mode') == 'add'){
			

			$id = $this->po_model->write_to_po_header($main_items);
			 
			//-----TRANSFER PO LINE ITEMS FROM TEMP TO MAIN PO DETAILS-----START
			$partial_items = $this->po_model->get_partial_purch_orders_details_temp($user['id']);
			foreach($partial_items as $val){
				$sub_items = array(
					'order_no' => $type_no,
					'stock_id' => $val->stock_id,
					'description' => $val->description,
					'uom' =>$val->uom,
					'qty' => $val->qty,
					'pack' => $val->pack,
					'unit_cost' => $val->unit_cost,
					'std_unit_cost' => $val->std_unit_cost,
					'qty_ordered' => $val->qty_ordered,
					'disc_percent1' => $val->disc_percent1,
					'disc_percent2' => $val->disc_percent2,
					'disc_percent3' => $val->disc_percent3,
					'disc_amount1' => $val->disc_amount1,
					'disc_amount2' => $val->disc_amount2,
					'disc_amount3' => $val->disc_amount3,
					'extended' => $val->extended,
				);
				$id2 = $this->po_model->write_to_purch_order_details($sub_items);
			}
			 //-----TRANSFER PO LINE ITEMS FROM TEMP TO MAIN PO DETAILS-----END
			##########AUDIT TRAIL [START]##########
				$audit_items = array(
				'type'=>0,
				'trans_no'=>0,
				'type_desc'=>ADDED_PURCHASE_ORDER,
				'description'=>'id:'.$id.'||branch_code:"'.$this->po_model->get_branch_code($this->input->post('branch_id')).'||user_name:"'.$this->po_model->get_user_name($user['id']).'||delivery_date:"'.date('Y-M-d', strtotime($this->input->post('delivery_date'))).'"',
				'user'=>$user['id']
				);
				
				$audit_id = $this->po_model->write_to_audit_trail($audit_items);
			##########AUDIT TRAIL [END]##########
			 //-----INSERTION IN TRANS_REF-----START
			$trans_ref_items = array(
				'trans_type'=>PURCHASE_ORDER,
				'type_no'=>$type_no,
                'reference'=>$reference,
                'branch_id'=>$this->input->post('branch_id')
			);
			$this->site_model->add_trans_ref($trans_ref_items); //-->This function inserts into trans_refs and updates the trans_types table at the same time
			//-----INSERTION IN TRANS_REF-----END
				
			$this->po_model->delete_from_purch_order_details_temp($user['id']);
		$items = array(
		 "status"=>3,
		 "modified_by"=>$user['id'],
		 "datetime_modified"=>date('Y-m-d H:i:s')
		);
		$hid_id = $this->input->post('hidden_po_order_no');
		 $this->po_model->update_po_header($items, $hid_id); //-----DISABLED FOR TESTING PURPOSES ONLY
		
			 $this->load->model('core/main_model');
			$this->main_model->main_purchase_orders_details($id);
			$test_new_po = ($id+1)+0;
		
			$main_items = $this->po_model->get_purch_orders($id);
			$this_item = $main_items[0];
			$sub_items = $this->po_model->get_purch_order_details($id);
		
			$details = array(
			"supplier_name"=>$this->po_model->get_supplier_name($this_item->supplier_id),
			 "order_no"=>$id,
			 "new_order_no"=>$test_new_po
			);
		
		  $try = $this->send_email('regenerate_po', $details);
		  return $try;
		//	$msg = "Successfully ADDED P.O.";
			//$status = "success";
			
		}
		// echo $stat;
		//echo json_encode(array("msg" => $msg, "status" => $status));
	}
	public function remove_puchase_details_line_item(){
		$user = $this->session->userdata('user');
		$this->po_model->delete_from_purch_order_details_temp($user['id']);
		echo 'success';
	}
	/**FOR GENERATE NEW PURCHASE ORDERS**/
}