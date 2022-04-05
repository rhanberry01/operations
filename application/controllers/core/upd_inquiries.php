<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Upd_inquiries extends CI_Controller {
	var $data = null;
	public function __construct()
	{
		parent::__construct();
		$this->load->model('core/inventory_model');
		$this->load->model('core/upd_inquiries_model');
		$this->load->model('site/site_model');
		$this->load->helper('core/inventory_helper');
		$this->load->helper('core/upd_inquiries_helper');
		$this->load->model('core/main_model');
	}
	public function index()
	{

	}
	public function update_inquiry_container($act_tabs = null){
		
		//$act_tabs = $this->input->post('tab_action');

		$data = $this->syter->spawn('inventory');
		$data['page_title'] = "Approval Inquiry (For Update)";
		$data['code'] = upd_approval_header_page($act_tabs);
        $data['load_js'] = 'core/upd_inquiries.php';
        $data['use_js'] = 'updateInquiryJs';
        $this->load->view('page',$data);
	}
	//rhan start approval_inquiry 
	public function approval_update_inquiry($ref='')
	{
		$data = $this->syter->spawn('inventory');
	//	$results = $this->inv_inquiries_model->get_stock_barcode_scheduled_markdown_temp();
		$results = $this->upd_inquiries_model->get_stock_logs();
		$data['page_subtitle'] = "Approval Inquiry (For Update)";
		$data['code'] = for_approval_update_list($results);
		$data['add_js'] = 'js/site_list_forms.js';
		$data['load_js'] = "core/upd_inquiries.php";
		$data['use_js'] = "updateJs";
		$this->load->view('load',$data);
	}
	//rhan end
	//mhae start approval supplier biller code
	public function approval_supplier_biller_code($ref='')
	{
		$data = $this->syter->spawn('inventory');
		$results = $this->upd_inquiries_model->get_supplier_biller_code();
		$data['page_subtitle'] = "Approval Inquiry (For Update)";
		$data['code'] = for_approval_list_form_supplier_biller_code($results);
		$data['add_js'] = 'js/site_list_forms.js';
		$data['load_js'] = "core/upd_inquiries.php";
		$data['use_js'] = "SupplierBillerCodeJS";
		$this->load->view('load',$data);
	}
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
				}
			}
	$results = $this->main_model->multiple_updates_approvals($all_ids,$user['id']);
	echo $results;
	}
	//mhae end
	public function check_biller_code(){
	    $_id      = $this->input->post('_id');
		$intvalue  = filter_var($_id , FILTER_SANITIZE_NUMBER_INT);
		$authorize = $this->upd_inquiries_model->check_biller_code($intvalue);	
		if($authorize != '')	{	
			foreach($authorize as $check){
				$new = $check->biller_code_new;
				$id = $check->id;
				$supp_id = $check->supplier_id;
				$supp_name = $check->supp_name;
				$intvalue1 = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
				$status ='success';
				$msg='user is authorized';
			}
	
		}else{
			$status = $msg = $authorize ;	

		}	
		echo $status.'|'.$intvalue1.'|'.$supp_id.'|'.$new.'|'.$supp_name;   
   }
	public function reject_add_supplier_biller_code($ref='')
	{
		$user = $this->session->userdata('user');
		$_id = $this->input->post('_id');	
		$items = array(
			'status' => 2,
			'checked_by' => $user['id'],
			'datetime_checked'=> date("Y-m-d H:i:s"),
			'remarks' => $this->input->post('remarks')
			
		);
		$results = $this->upd_inquiries_model->reject_add_supplier_biller_code($items, $_id);
		$results_ = $this->upd_inquiries_model->check_biller_code($_id);
		foreach($results_ as $val){
			$supp_id = $val->supplier_id;
			$supp_name = $val->supp_name;
			$biller_code = $val->biller_code_new;
		}
		##########AUDIT TRAIL [START]##########
			$audit_items = array(
			'type'=>0,
			'trans_no'=>0,
			'type_desc'=>REJECTED_BILLER_CODE,
			'description'=>'supp_id:'.$supp_id.'||supp_name:"'.$supp_name.'||biller_code:"'.$biller_code.'||remarks:"'.$this->input->post('remarks').'"',
			'user'=>$user['id']
			);
			
			$audit_id = $this->upd_inquiries_model->write_to_audit_trail($audit_items);
		##########AUDIT TRAIL [END]##########
		echo $results;
	}		
	public function approve_add_supplier_biller_code($ref='')
	{
		$user = $this->session->userdata('user');
		$id = $this->input->post('id');
		$supp_id = $this->input->post('supp_id');
		$code = $this->input->post('code');
		$supp_name = $this->input->post('supp_name');
		
		$item = array(
			'biller_code' => $code
		);
		
		$items = array(
			'status' => 1,
			'checked_by' => $user['id'],
			'datetime_checked'=> date("Y-m-d H:i:s")
		);
		##########AUDIT TRAIL [START]##########
			$audit_items = array(
			'type'=>0,
			'trans_no'=>0,
			'type_desc'=>APPROVED_BILLER_CODE,
			'description'=>'supp_id:'.$supp_id.'||supp_name:"'.$supp_name.'||biller_code:"'.$code.'"',
			'user'=>$user['id']
			);
			
			$audit_id = $this->upd_inquiries_model->write_to_audit_trail($audit_items);
		##########AUDIT TRAIL [END]##########
		$this->upd_inquiries_model->approve_branch_add_supplier_master_biller_code($item, $supp_id, $id);
		$results = $this->upd_inquiries_model->approve_add_supplier_biller_code($items, $id);
		echo $results;
	}	
	public function update_approval($ref='')
	{
	$this->load->model('core/main_model');
		$user = $this->session->userdata('user');
		$_id = $this->input->post('_id');	
			$id_and_branch = explode(':',$_id);
	
					$id = $id_and_branch[0];
					$type = $id_and_branch[2];
					$branch_id = $id_and_branch[1];
					
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
	public function reject_prices_update($ref='')
	{
	$_id = $this->input->post('_id');	
	$results = $this->upd_inquiries_model->reject_prices_update($_id);
	echo $results;
	}	
	
}