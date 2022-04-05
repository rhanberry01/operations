<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inv_inquiries extends CI_Controller {
	var $data = null;
	public function __construct()
	{
		parent::__construct();
		$this->load->model('core/inventory_model');
		$this->load->model('core/inv_inquiries_model');
		$this->load->model('site/site_model');
		$this->load->helper('core/inventory_helper');
		$this->load->helper('core/inv_inquiries_helper');
		$this->load->model('core/main_model');
	}
	public function index()
	{

	}
	//----------BARCODES LIST-----START
	public function barcode_list($ref='')
	{
		$data = $this->syter->spawn('inventory');
		if ($ref) {
			$this->stocks_container($ref,$data);
		} else {
			$results = $this->inv_inquiries_model->get_stocks();
			$data['page_subtitle'] = "Barcode Inquiry";
			$data['code'] = build_barcode_list_form($results);
		}
		$this->load->view('page',$data);
	}
	//----------BARCODES LIST-----END	
	
	//rhan start approval_inquiry 
	public function approval_inquiry_new_item($ref='')
	{
		$data = $this->syter->spawn('inventory');
		$results = $this->inv_inquiries_model->get_stocks_master_temp();
		$data['page_subtitle'] = "Approval Inquiry";
		$data['code'] = for_approval_list_form_new_item($results);
		$data['add_js'] = 'js/site_list_forms.js';
		$data['load_js'] = "core/inv_inquiries.php";
		$data['use_js'] = "invApprovalJs";
		$this->load->view('load',$data);
	}
	//rhan end
	
	public function add_approval_inquiry_new_item($ref='')
	{
		$data = $this->syter->spawn('inventory');
		$results = $this->inv_inquiries_model->get_stocks_master_temp();
		$data['page_subtitle'] = "Approval Inquiry";
		$data['code'] = add_for_approval_list_form_new_item($results);
		$data['add_js'] = 'js/site_list_forms.js';
		$data['load_js'] = "core/inv_inquiries.php";
		$data['use_js'] = "AddinvApprovalJs";
		$this->load->view('load',$data);
	}
	
	
	
   //start rhan get_temp
	public function get_stock_temp($ref='')
	{
	$stock_id = $this->input->post('data');	
	$results = $this->inv_inquiries_model->get_stocks_temp($stock_id);
	$category = $this->inv_inquiries_model->get_category($results->category_id);
	}	
	//end rhan
	//start rhan reject
	public function reject_add_stock_master($ref='')
	{
	$stock_id = $this->input->post('stock_id');	
	$user = $this->session->userdata('user');
	$result = $this->inv_inquiries_model->get_stocks_master_temp($stock_id);
	foreach($result as $val){
		$stock_code = $val->stock_code;
		$description = $val->description;
	}
	##########AUDIT TRAIL [START]##########
			$audit_items = array(
			'type'=>0,
			'trans_no'=>0,
			'type_desc'=>REJECTED_STOCK,
			'description'=>'stock_code:'.$stock_code.'||description:"'.$description.'"',
			'user'=>$user['id']
			);
			
	$audit_id = $this->inv_inquiries_model->write_to_audit_trail($audit_items);
	##########AUDIT TRAIL [END]##########
//	$results = $this->inv_inquiries_model->reject_add_stock($stock_id);
	echo $results;
	}	
	//end rhan
	
	public function add_stock_barcode_approval($ref='')
	{
	$this->load->model('core/main_model');
	$stock_id = $this->input->post('stock_id');	
	$user = $this->session->userdata('user');
	$result = $this->inv_inquiries_model->get_stocks_master_temp($stock_id);
	foreach($result as $val){
		$stock_code = $val->stock_code;
		$description = $val->description;
	}
	##########AUDIT TRAIL [START]##########
			$audit_items = array(
			'type'=>0,
			'trans_no'=>0,
			'type_desc'=>APPROVED_STOCK,
			'description'=>'stock_code:'.$stock_code.'||description:"'.$description.'"',
			'user'=>$user['id']
			);
			
	$audit_id = $this->inv_inquiries_model->write_to_audit_trail($audit_items);
	##########AUDIT TRAIL [END]##########
	$results = $this->main_model->add_stock_barcode_approval($stock_id,$user['id']);
	echo $results;

	}
	

	
	//start rhan  approve
	public function stock_barcode_approval($ref='')
	{
	$this->load->model('core/main_model');
	$stock_id = $this->input->post('stock_id');	
	$results = $this->main_model->stock_barcode_approval($stock_id);
	echo $results;
	}
	//end rhan 
	
	
	//view start
	public function stock_main_form_load($ref='')
	{
		
		$results = $this->inv_inquiries_model->get_stocks_temp_load($ref);
		if ($results) {
			$items = $results[0];
			//$data['page_subtitle'] = "Edit Stock Item";
		}
		
		$data['code'] = build_stock_main_form_load($items);
		
		//$data['add_css '] = 'css/page.css';
		$data['load_js'] = "core/inventory.php";
		$data['use_js'] = "stockMasterFormJS";
		$this->load->view('load',$data);
	}
	//end
	
	//rhan  start tabs  
	public function approval_inquiry_container($act_tabs = null){
		
		//$act_tabs = $this->input->post('tab_action');

		$data = $this->syter->spawn('inventory');
		$data['page_title'] = "Approval Inquiry";
		$data['code'] = approval_header_page($act_tabs);
        $data['load_js'] = 'core/inv_inquiries.php';
        $data['use_js'] = 'approvalInquiryJs';
        $this->load->view('page',$data);
	}
	
	//rhan end
	
	//rhan start approval_inquiry_marginal 
	public function approval_inquiry_marginal_markdown($ref='')
	{
		$data = $this->syter->spawn('inventory');
		$results = $this->inv_inquiries_model->get_stock_barcode_marginal_markdown_temp();
		$data['page_subtitle'] = "Approval Inquiry";
		$data['code'] = for_approval_list_form_marginal_markdown($results);
		$data['add_js'] = 'js/site_list_forms.js';
		$data['load_js'] = "core/inv_inquiries.php";
		$data['use_js'] = "marginaldownJs";
		$this->load->view('load',$data);
	}
	//rhan end
	
	//rhan start approval_inquiry 
	public function approval_inquiry_schedule_markdown($ref='')
	{
		$data = $this->syter->spawn('inventory');
		$results = $this->inv_inquiries_model->get_stock_barcode_scheduled_markdown_temp();
		$data['page_subtitle'] = "Approval Inquiry";
		$data['code'] = for_approval_list_form_sched_markdown($results);
		$data['add_js'] = 'js/site_list_forms.js';
		$data['load_js'] = "core/inv_inquiries.php";
		$data['use_js'] = "scheduleMdownJs";
		$this->load->view('load',$data);
	}
	//rhan end
	
	//rhan start stock_deletion approval
	public function stock_deletion_approval($ref='')
	{
		$data = $this->syter->spawn('inventory');
		$results = $this->inv_inquiries_model->get_stock_deletion_approval();
		$data['page_subtitle'] = "Approval Inquiry";
		$data['code'] = stock_deletion_form_approval($results);
		$data['add_js'] = 'js/site_list_forms.js';
		$data['load_js'] = "core/inv_inquiries.php";
		$data['use_js'] = "StockDeletionJS";
		$this->load->view('load',$data);
	}
	//rhan end
	
	
	//mhae start approval supplier stocks
	public function approval_supplier_stocks($ref='')
	{
		$data = $this->syter->spawn('inventory');
		$results = $this->inv_inquiries_model->get_supplier_stocks();
		$data['page_subtitle'] = "Approval Inquiry";
		$data['code'] = for_approval_list_form_supplier_stocks($results);
		$data['add_js'] = 'js/site_list_forms.js';
		$data['load_js'] = "core/inv_inquiries.php";
		$data['use_js'] = "SupplierStocksJS";
		$this->load->view('load',$data);
	}
	//mhae end
	//rhan start approval_inquiry 
	public function approval_update_inquiry($ref='')
	{
		$data = $this->syter->spawn('inventory');
	//	$results = $this->inv_inquiries_model->get_stock_barcode_scheduled_markdown_temp();
		$results = $this->inv_inquiries_model->get_stock_logs();
		$data['page_subtitle'] = "Approval Inquiry";
		$data['code'] = for_approval_update_list($results);
		$data['add_js'] = 'js/site_list_forms.js';
		$data['load_js'] = "core/inv_inquiries.php";
		$data['use_js'] = "updateJs";
		$this->load->view('load',$data);
	}
	//rhan end
	
	//rhan start barcode_prices_approval 
	public function barcode_prices_approval($ref='')
	{
		$data = $this->syter->spawn('inventory');
		$results = $this->inv_inquiries_model->get_barcode_prices_update();
		$data['page_subtitle'] = "Approval Inquiry";
		$data['code'] = barcode_prices_update_approval_list($results);
		$data['add_js'] = 'js/site_list_forms.js';
		$data['load_js'] = "core/inv_inquiries.php";
		$data['use_js'] = "updateBarcodePricesJs";
		$this->load->view('load',$data);
	}
	//rhan end
	
	//rhan reject marginal markdown
	public function reject_marginal_markdown($ref='')
	{
	$_id = $this->input->post('_id');
	$user = $this->session->userdata('user');	
	$items = $this->inv_inquiries_model->get_stock_barcode_marginal_markdown_temp($_id);
	foreach($items as $val){
		$stock_code = $val->stock_id;
		$barcode = $val->barcode;
		$branch_code = $this->inv_inquiries_model->get_branch_code($val->branch_id);
	}
	##########AUDIT TRAIL [START]##########
			$audit_items = array(
			'type'=>0,
			'trans_no'=>0,
			'type_desc'=>REJECTED_MARGINAL_MARKDOWN,
			'description'=>'stock_id:'.$stock_code.'||barcode:"'.$barcode.'||branch_code:"'.$branch_code.'"',
			'user'=>$user['id']
			);
			
	$audit_id = $this->inv_inquiries_model->write_to_audit_trail($audit_items);
	##########AUDIT TRAIL [END]##########
	$results = $this->inv_inquiries_model->reject_marginal_markdown($_id);
	echo $results;
	}	
	//end rhan
	
	//rhan reject schedule markdown
	public function reject_schedule_markdown($ref='')
	{
	$_id = $this->input->post('_id');	
	$user = $this->session->userdata('user');
	$items = $this->inv_inquiries_model->get_stock_barcode_scheduled_markdown_temp($_id);
	foreach($items as $val){
		$stock_code = $val->stock_id;
		$barcode = $val->barcode;
		$branch_code = $this->inv_inquiries_model->get_branch_code($val->branch_id);
	}
	##########AUDIT TRAIL [START]##########
			$audit_items = array(
			'type'=>0,
			'trans_no'=>0,
			'type_desc'=>REJECTED_SCHEDULE_MARKDOWN,
			'description'=>'stock_id:'.$stock_code.'||barcode:"'.$barcode.'||branch_code:"'.$branch_code.'"',
			'user'=>$user['id']
			);
			
	$audit_id = $this->inv_inquiries_model->write_to_audit_trail($audit_items);
	##########AUDIT TRAIL [END]##########
	$results = $this->inv_inquiries_model->reject_schedule_markdown($_id);
	echo $results;
	}	
	//end rhan
	 //start rhan  marginal markdown approve
	public function schedule_marginal_approval($ref='')
	{
	$this->load->model('core/main_model');
	$user = $this->session->userdata('user');
	$_id = $this->input->post('_id');	
	$id_and_branch = explode(':',$_id);
	$id = $id_and_branch[0];
	$branch_id = $id_and_branch[1];
	$branch_code = $this->main_model->get_branch_code($branch_id);
	$items = $this->inv_inquiries_model->get_stock_barcode_marginal_markdown_temp($_id);
	foreach($items as $val){
		$stock_code = $val->stock_id;
		$barcode = $val->barcode;
		$branch_code = $this->inv_inquiries_model->get_branch_code($val->branch_id);
	}
	##########AUDIT TRAIL [START]##########
			$audit_items = array(
			'type'=>0,
			'trans_no'=>0,
			'type_desc'=>APPROVED_MARGINAL_MARKDOWN,
			'description'=>'stock_id:'.$stock_code.'||barcode:"'.$barcode.'||branch_code:"'.$branch_code.'"',
			'user'=>$user['id']
			);
			
	$audit_id = $this->inv_inquiries_model->write_to_audit_trail($audit_items);
	##########AUDIT TRAIL [END]##########
	$results = $this->main_model->schedule_marginal_approvals($branch_code,$id);
	echo $results;
	}
	//end rhan 
	
   //start rhan  schedule markdown approve
	public function schedule_markdown_approval($ref='')
	{
	$this->load->model('core/main_model');
	$user = $this->session->userdata('user');
	$_id = $this->input->post('_id');	
	$id_and_branch = explode(':',$_id);
	$id = $id_and_branch[0];
	$branch_id = $id_and_branch[1];
	$branch_code = $this->main_model->get_branch_code($branch_id);
	$items = $this->inv_inquiries_model->get_stock_barcode_scheduled_markdown_temp($id);
	foreach($items as $val){
		$stock_code = $val->stock_id;
		$barcode = $val->barcode;
		$branch_code = $this->inv_inquiries_model->get_branch_code($val->branch_id);
	}
	##########AUDIT TRAIL [START]##########
			$audit_items = array(
			'type'=>0,
			'trans_no'=>0,
			'type_desc'=>APPROVED_SCHEDULE_MARKDOWN,
			'description'=>'stock_id:'.$stock_code.'||barcode:"'.$barcode.'||branch_code:"'.$branch_code.'"',
			'user'=>$user['id']
			);
			
	$audit_id = $this->inv_inquiries_model->write_to_audit_trail($audit_items);
	##########AUDIT TRAIL [END]##########
	$results = $this->main_model->schedule_markdown_approvals($branch_code,$id);
	echo $results;
	}
	//end rhan 
	//rhan start barcode_price_update_approval
	public function barcode_prices_update_approval($ref='')
	{
		$this->load->model('core/main_model');
		$_id = $this->input->post('_id');	
		$barcode_price_details = explode(':',$_id);
			
			$stock_id  = $barcode_price_details[0];
			$barcode  = $barcode_price_details[1];
			$sales_type  = $barcode_price_details[2];
			$affected  = $barcode_price_details[3];
			$id  = $barcode_price_details[4];
			$user = $this->session->userdata('user');
			$res = $this->inv_inquiries_model->get_barcode_prices_update($id);
			foreach($res as $val){
				$fields_and_data = explode('||',$val->affected_values);
				$fields = $fields_and_data[0];
				if(strpos($fields,'*') !== false){
					//return $update_data.' '.$fields;
					$fields_branch = explode('*',$fields);
					$branch = $fields_branch[0];
				}else if (strpos($fields,'price') !== false) {
					$branch_price = explode('_',$fields);
					$branch =  $branch_price[0].'_'.$branch_price[1];
				}
			}
			##########AUDIT TRAIL [START]##########
			$audit_items = array(
			'type'=>0,
			'trans_no'=>0,
			'type_desc'=>APPROVED_UPDATE_STOCK_BARCODES_AND_PRICES,
			'description'=>'stock_id:'.$stock_id.'||barcode:"'.$barcode.'||branch:"'.$branch.'"',
			'user'=>$user['id']
			);
			
			$audit_id = $this->inv_inquiries_model->write_to_audit_trail($audit_items);
			##########AUDIT TRAIL [END]##########
			$result  = $this->main_model->update_barcode_prices_approval($stock_id,$barcode,$sales_type,$affected,$id,$user['id']);
		
		//echo $stock_id.' '.$affected;
		echo $result;
	}
	//rhan end
	
	//start rhan  schedule markdown approve
	public function update_approval($ref='')
	{
	$this->load->model('core/main_model');
		$user = $this->session->userdata('user');
		$_id = $this->input->post('_id');	
			$id_and_branch = explode(':',$_id);
	
					$id = $id_and_branch[0];
					$type = $id_and_branch[2];
					$branch_id = $id_and_branch[1];
					$res = $this->inv_inquiries_model->get_stock_logs($id);
					foreach($res as $val){
						$stock_id = $val->stock_id;
						$type = $val->type;
						$branch = $val->branch != 'All' ? $this->inv_inquiries_model->get_branch_code($val->branch) : $val->branch;
					}
					##########AUDIT TRAIL [START]##########
					$audit_items = array(
					'type'=>0,
					'trans_no'=>0,
					'type_desc'=>APPROVED_UPDATE_STOCK_GENERAL_AND_COST_DETAILS,
					'description'=>'stock_id:'.$stock_id.'||type:"'.$type.'||branch:"'.$branch.'"',
					'user'=>$user['id']
					);
					
					$audit_id = $this->inv_inquiries_model->write_to_audit_trail($audit_items);
					##########AUDIT TRAIL [END]##########
						  if($branch_id != 'All'){
							$branch_code = $this->main_model->get_branch_code($branch_id);
								$results = $this->main_model->updates_approvals($branch_id,$branch_code,$id,$user['id']);
									echo $results;
						}else{
							$results = $this->main_model->updates_approvals('','All',$id,$user['id']);
								echo $results;
						}

				
	// switch($type){
			
		// case 'Update Stock Master Details':	
			// $results = $this->main_model->updates_approvals('All',$id,$user['id']);
				// echo $results;
		// break;
		
		// case 'Update All Supplier Stock Details':	
			// $results = $this->main_model->updates_approvals('All',$id,$user['id']);
				// echo $results;
		// break;
		
		// case 'Update Supplier Stock Details':		
			// $branch_code = $this->main_model->get_branch_code($branch_id);
				// $results = $this->main_model->updates_approvals($branch_code,$id,$user['id']);
					// echo $results;
		// break;
		
			
	// }
	
	// if($type == 'Updated Stock Master Details'){
	// $branch_code = 'ALL';
	// }else{
	// }
	// $branch_code = $this->main_model->get_branch_code($branch_id);
	// $results = $this->main_model->updates_approvals($branch_code,$id,$user['id']);
	// echo $results;
	}
	//end rhan 
	
	//end rhan 
	
		//rhan start approval_barcode_price
	public function approval_stock_barcode_prices($ref='')
	{
		$data = $this->syter->spawn('inventory');
		$results = $this->inv_inquiries_model->get_stock_barcode_prices();
		$data['page_subtitle'] = "Approval Inquiry";

		$data['code'] = for_approval_list_form_barcode_prices($results);
		$data['add_js'] = 'js/site_list_forms.js';
		$data['load_js'] = "core/inv_inquiries.php";
		$data['use_js'] = "StockBarcodePricesJS";
		$this->load->view('load',$data);
	}
	//rhan end
	
	 //start rhan  barcode_prices approval
	public function stock_barcode_prices_approval($ref='')
	{
	$this->load->model('core/main_model');
	$user = $this->session->userdata('user');
	$stock_code = $this->input->post('_id');	
	$barcode = $this->input->post('barcode');	
	$items = $this->inv_inquiries_model->get_stock_barcode_prices_($barcode);
	foreach($items as $val){
		$stock_code = $val->stock_id;
		$barcode = $val->barcode;
		$short_desc = $val->short_desc;
		$description = $val->description;
	}
	##########AUDIT TRAIL [START]##########
			$audit_items = array(
			'type'=>0,
			'trans_no'=>0,
			'type_desc'=>APPROVED_STOCK_BARCODE_PRICE,
			'description'=>'stock_id:'.$stock_code.'||barcode:"'.$barcode.'||short_desc:"'.$short_desc.'||description:"'.$description.'"',
			'user'=>$user['id']
			);
			
			$audit_id = $this->inv_inquiries_model->write_to_audit_trail($audit_items);
		##########AUDIT TRAIL [END]##########
	//$branch_code = $this->main_model->get_branch_code($branch_id);
	$results = $this->main_model->barcode_prices_approvals($barcode);
	echo $results;
	}
	//end rhan 
	//start mhae  approve
	public function stock_supplier_stocks_approval($ref='')
	{
	$this->load->model('core/main_model');
	$id = $this->input->post('_id');	
	$user = $this->session->userdata('user');
	$items = $this->inv_inquiries_model->get_supplier_stocks($id);
	foreach($items as $val){
		$stock_code = $val->stock_id;
		$supp_stock_code = $val->supp_stock_code;
		$description = $val->description;
		$branch_id = $this->inv_inquiries_model->get_branch_code($val->branch_id);
	}
	
	##########AUDIT TRAIL [START]##########
			$audit_items = array(
			'type'=>0,
			'trans_no'=>0,
			'type_desc'=>APPROVED_SUPPLIER_STOCK,
			'description'=>'stock_id:'.$stock_code.'||supp_stock_code:"'.$supp_stock_code.'||description:"'.$description.'||branch_id:"'.$branch_id.'"',
			'user'=>$user['id']
			);
			
			$audit_id = $this->inv_inquiries_model->write_to_audit_trail($audit_items);
		##########AUDIT TRAIL [END]##########
	$results = $this->main_model->stock_supplier_stocks_approval($id, $user['id']);
	echo $results ;
	
	}
	//end mhae 
	

	public function approved_stock_deletion($ref='')
	{
		$this->load->model('core/main_model');
		$stock_id = $this->input->post('stock_id');
		$_id = $this->input->post('id');
		$user = $this->session->userdata('user');
		$results = $this->inv_inquiries_model->get_stock_deletion_details($stock_id);
		foreach($results as $val){
			$stock_code = $val->stock_code;
			$description = $val->description;
		}
		$results = $this->main_model->approved_stock_deletion($stock_id,$user['id'],$_id);
		##########AUDIT TRAIL [START]##########
			$audit_items = array(
			'type'=>0,
			'trans_no'=>0,
			'type_desc'=>APPROVED_STOCK_DELETION,
			'description'=>'stock_id:'.$stock_id.'||stock_code:"'.$stock_code.'||description:"'.$description.'"',
			'user'=>$user['id']
			);
			
			$audit_id = $this->inv_inquiries_model->write_to_audit_trail($audit_items);
		##########AUDIT TRAIL [END]##########
		echo $results;
	}	

	
   //rhan reject barcode _ prices
	public function reject_stock_barcode_price($ref='')
	{
	$_id = $this->input->post('_id');	
	$user = $this->session->userdata('user');
	$items = $this->inv_inquiries_model->get_stock_barcode_prices_($_id);
	foreach($items as $val){
		$stock_code = $val->stock_id;
		$barcode = $val->barcode;
		$short_desc = $val->short_desc;
		$description = $val->description;
	}
	##########AUDIT TRAIL [START]##########
			$audit_items = array(
			'type'=>0,
			'trans_no'=>0,
			'type_desc'=>REJECTED_STOCK_BARCODE_PRICE,
			'description'=>'stock_id:'.$stock_code.'||barcode:"'.$barcode.'||short_desc:"'.$short_desc.'||description:"'.$description.'"',
			'user'=>$user['id']
			);
			
			$audit_id = $this->inv_inquiries_model->write_to_audit_trail($audit_items);
		##########AUDIT TRAIL [END]##########
	$results = $this->inv_inquiries_model->reject_stock_barcode_price($_id);
	echo $results;
	}	
	//end rhan
	public function reject_add_supplier_stocks($ref='')
	{
	$_id = $this->input->post('_id');	
	$user = $this->session->userdata('user');
	$items = $this->inv_inquiries_model->get_supplier_stocks($_id);
	foreach($items as $val){
		$stock_code = $val->stock_id;
		$supp_stock_code = $val->supp_stock_code;
		$description = $val->description;
		$branch_id = $this->inv_inquiries_model->get_branch_code($val->branch_id);
	}
	
	##########AUDIT TRAIL [START]##########
			$audit_items = array(
			'type'=>0,
			'trans_no'=>0,
			'type_desc'=>REJECTED_SUPPLIER_STOCK,
			'description'=>'stock_id:'.$stock_code.'||supp_stock_code:"'.$supp_stock_code.'||description:"'.$description.'||branch_id:"'.$branch_id.'"',
			'user'=>$user['id']
			);
			
			$audit_id = $this->inv_inquiries_model->write_to_audit_trail($audit_items);
		##########AUDIT TRAIL [END]##########
	$results = $this->inv_inquiries_model->reject_add_supplier_stocks($_id);
	echo $results;
	}	
	public function reject_stock_deletion($ref='')
	{
	$user = $this->session->userdata('user');
	$_id = $this->input->post('_id');
	$stock_id = $this->inv_inquiries_model->get_stock_deletion_stock_id($_id);
	$results = $this->inv_inquiries_model->get_stock_deletion_details($stock_id);
		foreach($results as $val){
			$stock_code = $val->stock_code;
			$description = $val->description;
		}
	##########AUDIT TRAIL [START]##########
			$audit_items = array(
			'type'=>0,
			'trans_no'=>0,
			'type_desc'=>REJECTED_STOCK_DELETION,
			'description'=>'stock_id:'.$stock_id.'||stock_code:"'.$stock_code.'||description:"'.$description.'"',
			'user'=>$user['id']
			);
			
			$audit_id = $this->inv_inquiries_model->write_to_audit_trail($audit_items);
		##########AUDIT TRAIL [END]##########
	$results = $this->inv_inquiries_model->reject_stock_deletion($_id);
	echo $results;
	}
	
	public function add_get_all_checked()
	{
	$this->load->model('core/main_model');
	$ids = $this->input->post('ids');	
	$user = $this->session->userdata('user');

	$num = 0;
	$stock_ids = array();
	$ids_count = count($ids); 
			while($ids_count != $num){
					$num = $num + 1;
				$con_id  = explode('|',$ids[$num-1]);
				if($con_id[0] == 'true'){
					array_push($stock_ids,$con_id[1]);
				$result = $this->inv_inquiries_model->get_stocks_master_temp($con_id[1]);
				foreach($result as $val){
					$stock_code = $val->stock_code;
					$description = $val->description;
				}
				##########AUDIT TRAIL [START]##########
						$audit_items = array(
						'type'=>0,
						'trans_no'=>0,
						'type_desc'=>APPROVED_STOCK,
						'description'=>'stock_code:'.$stock_code.'||description:"'.$description.'"',
						'user'=>$user['id']
						);
						
				$audit_id = $this->inv_inquiries_model->write_to_audit_trail($audit_items);
				##########AUDIT TRAIL [END]##########
				}
			}
	$results = $this->main_model->add_multiple_stock_barcode_approval($stock_ids,$user['id']);
	echo $results;
	}
	
	
	
	public function get_all_checked()
	{
	$this->load->model('core/main_model');
	$ids = $this->input->post('ids');	
	//echo $ids;
	$num = 0;
	$stock_ids = array();
	$ids_count = count($ids); 
			while($ids_count != $num){
					$num = $num + 1;
				$con_id  = explode('|',$ids[$num-1]);
				if($con_id[0] == 'true'){
					array_push($stock_ids,$con_id[1]);
				}
			}
	$results = $this->main_model->multiple_stock_barcode_approval($stock_ids);
	echo $results;
	}
	public function get_all_checked_supplier_stocks()
	{
	$this->load->model('core/main_model');
	$ids = $this->input->post('ids');	
	$user = $this->session->userdata('user');
	//echo $ids;
	$num = 0;
	$stock_ids = array();
	$ids_count = count($ids); 
			while($ids_count != $num){
					$num = $num + 1;
				$con_id  = explode('|',$ids[$num-1]);
				if($con_id[0] == 'true'){
					array_push($stock_ids,$con_id[1]);
				$items = $this->inv_inquiries_model->get_supplier_stocks($con_id[1]);
				foreach($items as $val){
					$stock_code = $val->stock_id;
					$supp_stock_code = $val->supp_stock_code;
					$description = $val->description;
					$branch_id = $this->inv_inquiries_model->get_branch_code($val->branch_id);
				}
				
				##########AUDIT TRAIL [START]##########
						$audit_items = array(
						'type'=>0,
						'trans_no'=>0,
						'type_desc'=>APPROVED_SUPPLIER_STOCK,
						'description'=>'stock_id:'.$stock_code.'||supp_stock_code:"'.$supp_stock_code.'||description:"'.$description.'||branch_id:"'.$branch_id.'"',
						'user'=>$user['id']
						);
						
						$audit_id = $this->inv_inquiries_model->write_to_audit_trail($audit_items);
					##########AUDIT TRAIL [END]##########
				}
			}
	$results = $this->main_model->multiple_supplier_stocks_approvals($stock_ids, $user['id']);
	echo $results;
	//echo $stock_ids;
	}
	
	public function get_all_checked_stock_deletion()
	{
	$this->load->model('core/main_model');
	$ids = $this->input->post('ids');	
	$num = 0;
	$user = $this->session->userdata('user');
	$stock_ids = array();
	$ids_count = count($ids); 
			while($ids_count != $num){
					$num = $num + 1;
				$con_id  = explode('|',$ids[$num-1]);
				if($con_id[0] == 'true'){
					array_push($stock_ids,$con_id[1]);
				}
			}
	//return $stock_ids;
	$results = $this->main_model->multiple__stock_deletion_approval($stock_ids,$user['id']);	
	$ids = count($stock_ids);
	$nums = 0;
	while($ids != $nums){
		$nums = $nums + 1;
		$id_stock_id = explode(':',$stock_ids[$nums-1]);
		$stock_id = $id_stock_id[0];
		$id = $id_stock_id[1];
				$stock_id_ = $this->inv_inquiries_model->get_stock_deletion_stock_id($id);
				$results = $this->inv_inquiries_model->get_stock_deletion_details($stock_id_);
					foreach($results as $val){
						$stock_code = $val->stock_code;
						$description = $val->description;
					}
				##########AUDIT TRAIL [START]##########
						$audit_items = array(
						'type'=>0,
						'trans_no'=>0,
						'type_desc'=>APPROVED_STOCK_DELETION,
						'description'=>'stock_id:'.$stock_id_.'||stock_code:"'.$stock_code.'||description:"'.$description.'"',
						'user'=>$user['id']
						);
						
						$audit_id = $this->inv_inquiries_model->write_to_audit_trail($audit_items);
				##########AUDIT TRAIL [END]##########
	}
	echo $results;
	}
	
	//multiple prices approval
	
	public function get_all_checked_prices()
	{
	$this->load->model('core/main_model');
	$ids = $this->input->post('ids');	
	$user = $this->session->userdata('user');
	//echo $ids;
	$num = 0;
	$barcode_ids = array();
	$ids_count = count($ids); 
			while($ids_count != $num){
					$num = $num + 1;
				$con_id  = explode('|',$ids[$num-1]);
				if($con_id[0] == 'true'){
					array_push($barcode_ids,$con_id[1]);
				$items = $this->inv_inquiries_model->get_stock_barcode_prices_($con_id[1]);
					foreach($items as $val){
						$stock_code = $val->stock_id;
						$barcode = $val->barcode;
						$short_desc = $val->short_desc;
						$description = $val->description;
					}
					##########AUDIT TRAIL [START]##########
						$audit_items = array(
						'type'=>0,
						'trans_no'=>0,
						'type_desc'=>APPROVED_STOCK_BARCODE_PRICE,
						'description'=>'stock_id:'.$stock_code.'||barcode:"'.$con_id[1].'||short_desc:"'.$short_desc.'||description:"'.$description.'"',
						'user'=>$user['id']
						);
						
						$audit_id = $this->inv_inquiries_model->write_to_audit_trail($audit_items);
					##########AUDIT TRAIL [END]##########
				}
			}
	$results = $this->main_model->multiple_barcode_prices_approvals($barcode_ids);
					
	echo $results;
	//echo $stock_ids;
	}
	
	/////update
	
	public function get_all_checked_update()
	{
	$user = $this->session->userdata('user');	
	$this->load->model('core/main_model');
	$ids = $this->input->post('ids');	
	//echo $ids;
	$num = 0;
	$all_ids = array();
	$ids_count = count($ids); 
			while($ids_count != $num){
					$num = $num + 1;
				$con_id  = explode('|',$ids[$num-1]);
				if($con_id[0] == 'true'){
					array_push($all_ids,$con_id[1]);
					$res = $this->inv_inquiries_model->get_stock_logs($con_id[1]);
						foreach($res as $val){
							$stock_id = $val->stock_id;
							$type = $val->type;
							$branch = $val->branch != 'All' ? $this->inv_inquiries_model->get_branch_code($val->branch) : $val->branch;
						}
						##########AUDIT TRAIL [START]##########
						$audit_items = array(
						'type'=>0,
						'trans_no'=>0,
						'type_desc'=>APPROVED_UPDATE_STOCK_GENERAL_AND_COST_DETAILS,
						'description'=>'stock_id:'.$stock_id.'||type:"'.$type.'||branch:"'.$branch.'"',
						'user'=>$user['id']
						);
						
						$audit_id = $this->inv_inquiries_model->write_to_audit_trail($audit_items);
						##########AUDIT TRAIL [END]##########
				}
			}
	$results = $this->main_model->multiple_updates_approvals($all_ids,$user['id']);
	echo $results;
	}
	
	/////end update
	//barcode_prices update
	public function get_all_checked_for_barcode_prices_update()
	{
	$user = $this->session->userdata('user');	
	$this->load->model('core/main_model');
	$ids = $this->input->post('ids');	
	//echo $ids;
	$num = 0;
	$all_ids = array();
	$ids_count = count($ids); 
			while($ids_count != $num){
					$num = $num + 1;
				$con_id  = explode('/',$ids[$num-1]);
				if($con_id[0] == 'true'){
					array_push($all_ids,$con_id[1]);
					$barcode_price_details = explode(':',$con_id[1]);
					
					$id  = $barcode_price_details[4];
					$res = $this->inv_inquiries_model->get_barcode_prices_update($id);
						
					foreach($res as $val){
						$stock_id = $val->stock_id;
						$barcode = $val->barcode;
						$fields_and_data = explode('||',$val->affected_values);
						$fields = $fields_and_data[0];
						if(strpos($fields,'*') !== false){
							//return $update_data.' '.$fields;
							$fields_branch = explode('*',$fields);
							$branch = $fields_branch[0];
						}else if (strpos($fields,'price') !== false) {
							$branch_price = explode('_',$fields);
							$branch =  $branch_price[0].'_'.$branch_price[1];
						}

					//return var_dump($branch);
					}
					##########AUDIT TRAIL [START]##########
					$audit_items = array(
					'type'=>0,
					'trans_no'=>0,
					'type_desc'=>APPROVED_UPDATE_STOCK_BARCODES_AND_PRICES,
					'description'=>'stock_id:'.$stock_id.'||barcode:"'.$barcode.'||branch:"'.$branch.'"',
					'user'=>$user['id']
					);
					
					$audit_id = $this->inv_inquiries_model->write_to_audit_trail($audit_items);
					##########AUDIT TRAIL [END]##########
				}
			}
	$results = $this->main_model->multiple_barcode_prices_updates_approvals($all_ids);
	echo $results;
	
	}
	//end barcode prices update
	
	public function get_all_checked_marginal()
	{
	$this->load->model('core/main_model');
	$user = $this->session->userdata('user');	
	$ids = $this->input->post('ids');	
	//echo $ids;
	$num = 0;
	$barcode_ids = array();
	$ids_count = count($ids); 
			while($ids_count != $num){
					$num = $num + 1;
				$con_id  = explode('|',$ids[$num-1]);
				if($con_id[0] == 'true'){
					array_push($barcode_ids,$con_id[1]);
				$items = $this->inv_inquiries_model->get_stock_barcode_marginal_markdown_temp($con_id[1]);
				foreach($items as $val){
					$stock_code = $val->stock_id;
					$barcode = $val->barcode;
					$branch_code = $this->inv_inquiries_model->get_branch_code($val->branch_id);
				}
				##########AUDIT TRAIL [START]##########
						$audit_items = array(
						'type'=>0,
						'trans_no'=>0,
						'type_desc'=>APPROVED_MARGINAL_MARKDOWN,
						'description'=>'stock_id:'.$stock_code.'||barcode:"'.$barcode.'||branch_code:"'.$branch_code.'"',
						'user'=>$user['id']
						);
						
				$audit_id = $this->inv_inquiries_model->write_to_audit_trail($audit_items);
				##########AUDIT TRAIL [END]##########
				}
			}
	$results = $this->main_model->multiple_barcode_marginal_approvals($barcode_ids);
	echo $results;
	}
	
	public function get_all_checked_markdown()
	{
	$this->load->model('core/main_model');
	$user = $this->session->userdata('user');
	$ids = $this->input->post('ids');	
	//echo $ids;
	$num = 0;
	$barcode_ids = array();
	$ids_count = count($ids); 
			while($ids_count != $num){
					$num = $num + 1;
				$con_id  = explode('|',$ids[$num-1]);
				if($con_id[0] == 'true'){
					array_push($barcode_ids,$con_id[1]);
					$items = $this->inv_inquiries_model->get_stock_barcode_scheduled_markdown_temp($con_id[1]);
					foreach($items as $val){
						$stock_code = $val->stock_id;
						$barcode = $val->barcode;
						$branch_code = $this->inv_inquiries_model->get_branch_code($val->branch_id);
					}
					##########AUDIT TRAIL [START]##########
							$audit_items = array(
							'type'=>0,
							'trans_no'=>0,
							'type_desc'=>APPROVED_SCHEDULE_MARKDOWN,
							'description'=>'stock_id:'.$stock_code.'||barcode:"'.$barcode.'||branch_code:"'.$branch_code.'"',
							'user'=>$user['id']
							);
							
					$audit_id = $this->inv_inquiries_model->write_to_audit_trail($audit_items);
					##########AUDIT TRAIL [END]##########
				}
			}
	$results = $this->main_model->multiple_barcode_markdown_approvals($barcode_ids);
	echo $results;
	}
		//view start
	public function suuplier_stock_main_form_load($ref)
	{
		
		$results = $this->inv_inquiries_model->get_supplier_stocks_temp_load($ref);
		if ($results) {
			$items = $results[0];
			//$data['page_subtitle'] = "Edit Stock Item";
		}
		
		$data['code'] = build_supplier_stock_form_load($items);
		
		//$data['add_css '] = 'css/page.css';
		$data['load_js'] = "core/inventory.php";
		$data['use_js'] = "stockMasterFormJS";
		$this->load->view('load',$data);
	}
	//end
	public function schedule_markdown_view($id=null)
// public function branch_price_view($id=null)
	{
	$results = $this->inv_inquiries_model->schedule_markdown_view($id);
	foreach($results as $val){
		$details = array(
					'id' =>$val->id,
					'stock_id' =>$val->stock_id,
					'barcode' =>$val->barcode,
					'end_date' =>$val->end_date,
					'discounted_price' =>$val->discounted_price,
					'end_time' =>$val->end_time,
					'start_time' =>$val->start_time,
					'end_date' =>$val->end_date,
					'start_date' =>$val->start_date,
					'branch_id' =>$val->branch_id,
					'markdown' =>$val->markdown
						 );
	}
	$data['code'] = sched_markdown_view_form($details);
	$this->load->view('load',$data);
	}
	
    public function reject_prices_update($ref='')
	{
	$_id = $this->input->post('_id');
	$user = $this->session->userdata('user');
	$res = $this->inv_inquiries_model->get_stock_logs($_id);
	foreach($res as $val){
		$stock_id = $val->stock_id;
		$type = $val->type;
		$branch = $val->branch != 'All' ? $this->inv_inquiries_model->get_branch_code($val->branch) : $val->branch;
	}
	##########AUDIT TRAIL [START]##########
	$audit_items = array(
	'type'=>0,
	'trans_no'=>0,
	'type_desc'=>REJECTED_UPDATE_STOCK_GENERAL_AND_COST_DETAILS,
	'description'=>'stock_id:'.$stock_id.'||type:"'.$type.'||branch:"'.$branch.'"',
	'user'=>$user['id']
	);
	
	$audit_id = $this->inv_inquiries_model->write_to_audit_trail($audit_items);
	##########AUDIT TRAIL [END]##########
	$results = $this->inv_inquiries_model->reject_prices_update($_id);
	echo $results;
	}
	
	public function reject_barcode_prices_update($ref='')
	{
	$_id = $this->input->post('_id');	
	$user = $this->session->userdata('user');
	$res = $this->inv_inquiries_model->get_barcode_prices_update($_id);
			foreach($res as $val){
				$stock_id = $val->stock_id;
				$barcode = $val->barcode;
				$fields_and_data = explode('||',$val->affected_values);
				$fields = $fields_and_data[0];
				if(strpos($fields,'*') !== false){
					//return $update_data.' '.$fields;
					$fields_branch = explode('*',$fields);
					$branch = $fields_branch[0];
				}else if (strpos($fields,'price') !== false) {
					$branch_price = explode('_',$fields);
					$branch =  $branch_price[0].'_'.$branch_price[1];
				}
			}
			##########AUDIT TRAIL [START]##########
			$audit_items = array(
			'type'=>0,
			'trans_no'=>0,
			'type_desc'=>REJECTED_UPDATE_STOCK_BARCODES_AND_PRICES,
			'description'=>'stock_id:'.$stock_id.'||barcode:"'.$barcode.'||branch:"'.$branch.'"',
			'user'=>$user['id']
			);
			
			$audit_id = $this->inv_inquiries_model->write_to_audit_trail($audit_items);
			##########AUDIT TRAIL [END]##########
	$results = $this->inv_inquiries_model->reject_barcode_prices_update_db($_id);
	echo $results;
	}	
	
	
	public function barcode_prices_view($id=null)
	{
	$results = $this->inv_inquiries_model->barcode_prices_view($id);
	$data['code'] = build_stock_barcode_price_list_view($id);
	$this->load->view('load',$data);
	}
	public function approval_inquiry_container_movements($act_tabs = null){
		
		//$act_tabs = $this->input->post('tab_action');

		$data = $this->syter->spawn('inventory');
		$data['page_title'] = "Approval Inquiry";
		$data['code'] = approval_header_page_movements($act_tabs);
        $data['load_js'] = 'core/inv_inquiries.php';
        $data['use_js'] = 'approvalInquiryMovementsJs';
        $this->load->view('page',$data);
	}
	// Movements Approval - Mhae (start)
	public function movement_approval($ref='')
	{
		$data = $this->syter->spawn('inventory');
		$data['page_subtitle'] = "Movements";
		$Category = $this->inv_inquiries_model->get_movements_approval();
		//echo $this->db->last_query();
		
        $data['add_js'] = 'js/site_list_forms.js';
        $data['load_js'] = "core/inv_inquiries.php";
        $data['use_js'] = "MovementsApprovalJS";
		
		$data['code'] = movements_approval($Category);
		$this->load->view('load',$data);
	}
	public function reject_added_movements($ref='')
	{
		$user = $this->session->userdata('user');
		$_id = $this->input->post('_id');	
		$branch_id = $this->input->post('branch_id');	
		$remarks = $this->input->post('remarks');	
		$items = array(
			'status' => 3,
			'posted_by' => $user['id'],
			'date_posted'=> date("Y-m-d H:i:s"),
			'approval_remarks' => $remarks
		);
		$results = $this->inv_inquiries_model->reject_added_movements($items, $_id);
		##########AUDIT TRAIL [START]##########
			$audit_items = array(
			'type'=>0,
			'trans_no'=>0,
			'type_desc'=>REJECTED_MOVEMENT_ENTRY,
			'description'=>'id:'.$_id.'||branch_id:'.$branch_id.'||remarks:"'.$remarks.'"',
			'user'=>$user['id']
			);
			
			$audit_id = $this->inv_inquiries_model->write_to_audit_trail($audit_items);
		##########AUDIT TRAIL [END]##########
		echo $results;
	}
	public function approve_added_movements($ref='')
	{
		$this->load->model('core/main_model');
		$id = $this->input->post('_id');	
		$branch_id = $this->input->post('branch_id');	
		$user = $this->session->userdata('user');
		$result_ = $this->inv_inquiries_model->get_movements_details_approval($id, $branch_id);
		foreach($result_ as $val){
			$branch_code  = $this->inv_inquiries_model->get_branch_code($val->branch_id);
			$created_by  = $this->inv_inquiries_model->user_name($val->created_by);
			$transaction_date = $val->transaction_date; 
		}
		//echo $branch_id;
		$results = $this->main_model->approve_added_movements($id, $branch_id, $user['id']);
		##########AUDIT TRAIL [START]##########
			$audit_items = array(
			'type'=>0,
			'trans_no'=>0,
			'type_desc'=>APPROVED_MOVEMENT_ENTRY,
			'description'=>'id:'.$id.'||branch_code:"'.$branch_code.'||created_by:"'.$created_by.'||transaction_date:"'.date('Y-M-d', strtotime($transaction_date)).'"',
			'user'=>$user['id']
			);
			
			$audit_id = $this->inv_inquiries_model->write_to_audit_trail($audit_items);
		##########AUDIT TRAIL [END]##########
		echo $results ;
	}
	public function get_all_checked_added_movements()
	{
		$this->load->model('core/main_model');
		$ids = $this->input->post('ids');	
		$user = $this->session->userdata('user');
		//return $ids;
		$num = 0;
		
		$movement_ids = array();
		$ids_count = count($ids); 
				while($ids_count != $num){
						$num = $num + 1;
					$con_id  = explode('|',$ids[$num-1]);
					if($con_id[0] == 'true'){
						array_push($movement_ids,$con_id[1]);
					$id = explode('_', $con_id[1]);	
					$result_ = $this->inv_inquiries_model->get_movements_approval($id[0]);
					foreach($result_ as $val){
						$branch_code  = $this->inv_inquiries_model->get_branch_code($val->branch_id);
						$created_by  = $this->inv_inquiries_model->user_name($val->created_by);
						$transaction_date = $val->transaction_date; 
					}
					$audit_items = array(
						'type'=>0,
						'trans_no'=>0,
						'type_desc'=>APPROVED_MOVEMENT_ENTRY,
						'description'=>'id:'.$id[0].'||branch_code:"'.$branch_code.'||created_by:"'.$created_by.'||transaction_date:"'.date('Y-M-d', strtotime($transaction_date)).'"',
						'user'=>$user['id']
						);
					$audit_id = $this->inv_inquiries_model->write_to_audit_trail($audit_items);
					}
				}
		$results = $this->main_model->multiple_added_movement_approvals($movement_ids, $user['id']);
		echo $results;
		//echo $movement_ids;
	}
	public function movements_details_main_form_load($ref, $branch_id)
	{
		
		$results = $this->inv_inquiries_model->get_movements_details_approval($ref, $branch_id);
		// $items = $results[0];
		// echo var_dump($items);
		$data['code'] = build_movement_details_list_form($results);
		
		//$data['add_css '] = 'css/page.css';
		$data['add_js'] = 'js/site_list_forms.js';
        $data['load_js'] = "core/inv_inquiries.php";
        $data['use_js'] = "MovementsApprovalJS";
		$this->load->view('load',$data);
	}
	// Movements Approval - Mhae (end)
	// Stock Inquiry - Mhae (start)
	public function stock_list(){
		$data = $this->syter->spawn('inventory');
		$data['page_title'] = fa('fa-question-circle')."Stocks Inquiry";
		// $data['page_subtitle'] = "Branch Stocks Inquiry";
		$items = array();
		$results = $this->inv_inquiries_model->get_stocks_master();
		if ($results) {
			$items = $results;
		}
	//	echo var_dump($items);
		$data['load_js'] = 'core/inv_inquiries.php';
        $data['use_js'] = 'StockSearchJs';
		$data['code'] = build_stock_inq_form($items);
		$this->load->view('page',$data);
	}
	public function stock_result(){
		$category_id = $this->input->post('category_id');
		$start_date = date('Y-m-d', strtotime($this->input->post('start_date')));
		$end_date = date('Y-m-d', strtotime($this->input->post('end_date')));
		$results = $this->inv_inquiries_model->get_search_stock_details($category_id, $start_date, $end_date);
		$data['load_js'] = 'core/inventory.php';
        $data['use_js'] = 'StockSearchJs';
	//echo var_dump($results);
		$data['code'] = build_stock_list_display($results);
		$this->load->view('load',$data);
	}
	// Stock Inquiry - Mhae (end)
}