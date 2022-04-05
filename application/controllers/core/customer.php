<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customer extends CI_Controller {

	var $data = null;
	
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('core/customer_model');
		$this->load->helper('core/customer_helper');
	}
	
	
	
	//ARCHIE
	
	public function customer_master(){
	
		$data = $this->syter->spawn('sales');
		$data['page_subtitle'] = "Customer List";
		$cust = $this->customer_model->get_customer_master();
		//print_r($cust);
		$data['code'] = customerMasterPage($cust);
		$this->load->view('page',$data);
	}
	
	
	public function manage_customer_master($id=null){

		$data = $this->syter->spawn('sales');
		$data['page_subtitle'] = "Add New Customer";
	    $items = null;
		
		if($id != null){
           $details = $this->customer_model->get_customer_master($id);
           $items = $details[0];
        }
		echo var_dump($items);
		$data['code'] = customer_master_form($items);
		$data['add_js'] = 'js/site_list_forms.js';
        $data['load_js'] = "core/customer.php";
        $data['use_js'] = "customerJS";
		$this->load->view('page',$data);
	}
	
	public function customer_master_details_db(){
	
	$name_exist ="";
		$items = array(
	
			'cust_code' => $this->input->post('cust_code'),
			'description' => $this->input->post('desc'),
			'street' => $this->input->post('street'),
			'email_address' => $this->input->post('email'),
			'brgy' => $this->input->post('barangay'),
			'city' => $this->input->post('city'),
			'tel_no' => $this->input->post('tel'),
			'mobile_no' => $this->input->post('mobile'),
			'referred_by' => $this->input->post('referred_by'),
			'birthday' => date('Y-m-d', strtotime($this->input->post('bday'))),
			'disc_percent_1' => $this->input->post('ds1'),
			'disc_percent_2' => $this->input->post('ds2'),
			'disc_percent_3' => $this->input->post('ds3'),
			'disc_amount_1' => $this->input->post('amt1'),
			'disc_amount_2' => $this->input->post('amt2'),
			'disc_amount_3' => $this->input->post('amt3'),
			'credit_limit' => $this->input->post('credit_limit'),
			'inactive' => $this->input->post('inactive'),
		);
			$mode = $this->input->post('mode');
		if($mode == 'add')
			$name_exist = $this->customer_model->customer_master_exist_add_mode($this->input->post('cust_code'));
		else if($mode == 'edit')
			$name_exist = $this->customer_model->customer_master_exist_edit_mode($this->input->post('cust_code'), $this->input->post('cust_id'));
		
		if($name_exist){
			$id = '';
			$msg = "WARNING : Customer Code [ ".$this->input->post('cust_code')." ] already exists!";
			$status = "warning";
		}else{
		if ($this->input->post('cust_id')){
		
			$id = $this->input->post('cust_id');
			$this->customer_model->update_customer_master($items,$id);
			$msg = "Updated Customer: ".ucwords($this->input->post('cust_code'));
			$status = "success";
		
		} else {	
			$id = $this->customer_model->add_customer_master($items);
			$msg = "Added New Customer: ".ucwords($this->input->post('cust_code'));
			$status = "success";
			
		}
		
	}
		echo json_encode(array('status'=>$status,'id'=>$id,'msg'=>$msg));	
	
	}
	

	//ARCHIE END
	
	public function customers($ref='')
	{
		$data = $this->syter->spawn('sales');
        $data['page_subtitle'] = "Customer List";
        $cust = $this->customer_model->get_debtors();
        //echo $this->db->last_query();
        $data['code'] = customerPage($cust);
        $this->load->view('page',$data);
	}

	public function manage_customers($debtor_id=null){
	
	
        $data = $this->syter->spawn('sales');
        $data['page_subtitle'] = "Manage Customer";
        $items = null;
        $receive_cart = array();

        if($debtor_id != null){
           	$details = $this->customer_model->get_debtors($debtor_id);
            $items = $details[0];
        }

        $data['code'] = manage_customer_form($items);

        $data['add_js'] = 'js/site_list_forms.js';
        $data['load_js'] = "core/customer.php";
        $data['use_js'] = "customerJS";
        $this->load->view('page',$data);
    }
	

	
	
    public function customer_details_db()
	{
		// if (!$this->input->post())
			// header("Location:".base_url()."items");

		$items = array(
			'debtor_code' => $this->input->post('debtor_code'),
			'name' => $this->input->post('name'),
			'address' => $this->input->post('address'),
			'email' => $this->input->post('email'),
			'tax_no' => $this->input->post('tax_no'),
			'currency' => $this->input->post('currency'),
			'sales_type' => $this->input->post('sales_type'),
			'discount' => $this->input->post('discount'),
			'payment_discount' => $this->input->post('payment_discount'),
			'credit_limit' => $this->input->post('credit_limit'),
			'payment_term' => $this->input->post('payment_term'),
			'payment_status' => $this->input->post('credit_status'),
			'business_style' => $this->input->post('business_style'),
		);

		// if($fromDel){
		// 	// unset($items['tax_exempt']);
		// 	unset($items['inactive']);
		// }

		if ($this->input->post('debtor_id')) {
		
			$id = $this->input->post('debtor_id');
			$this->customer_model->update_customer($items,$id);
			$msg = "Updated Customer: ".ucwords($this->input->post('name'));
			
		} else {
		
			$id = $this->customer_model->add_customer($items);
			$msg = "Added New Customer: ".ucwords($this->input->post('name'));
			
		}

		echo json_encode(array('id'=>$id,'msg'=>$msg));
	}
	// public function customer_branches($ref=null)
	// {
	// 	$data = $this->syter->spawn('sales');
	// 	if ($ref)
	// 		$this->customer_branches_container($ref,$data);
	// 	else {
	// 		$results = $this->customer_model->get_debtor_branches();
	// 		$data['page_subtitle'] = "Customer Branches Management";
	// 		$data['code'] = build_customer_branches_display($results);
	// 	}
	// 	$this->load->view('page',$data);
	// }
	// private function customer_branches_container($ref,&$data)
	// {
	// 	if (!strcasecmp($ref, 'new'))
	// 		$data['page_subtitle'] = "New Customer Branch";
	// 	else
	// 		$data['page_subtitle'] = "Edit Customer Branch";
	// 	$data['code'] = build_account_type_container($ref);
	// 	$data['load_js'] = "core/general_ledger.php";
	// 	$data['use_js'] = "customerFormContainerJs";
	// }
	// public function customer_branch_info_form($ref)
	// {
	// 	$customer_branch = array();
	// 	if (strcasecmp($ref, 'new')) {
	// 		$results = $this->gl_model->get_debtor_branches(array('debtor_branches.debtor_branch_id'=>$ref));
	// 		if ($results)
	// 			$customer_branch = $results[0];
	// 	}
	// 	$data['code'] = build_customer_branch_info_form($customer_branch);
	// 	$data['load_js'] = "core/customer.php";
	// 	$data['use_js'] =  "branchInfoFormJs";
	// 	$this->load->view('load',$data);
	// }
	// public function customer_branch_sales_form($ref)
	// {
	// 	$customer_branch = array();
	// 	if (strcasecmp($ref, 'new')) {
	// 		$results = $this->gl_model->get_debtor_branches(array('debtor_branches.debtor_branch_id'=>$ref));
	// 		if ($results)
	// 			$customer_branch = $results[0];
	// 	}
	// }
	/*
	public function account_type_form($ref)
	{
		$account_type = array();
		if (!strcasecmp($ref, 'new')) {
			$data['page_subtitle'] = "New Account Type";
		} else {
			$results = $this->gl_model->get_chart_types(array('chart_types.id'=>$ref));
			if ($results)
				$account_type = $results[0];
			$data['page_subtitle'] = "Edit Account Type";
		}
		$data['code'] = build_account_type_form($account_type);
		$data['load_js'] = "core/general_ledger.php";
		$data['use_js'] = "typeFormJs";
		$this->load->view('load',$data);
	}
	public function account_type_db()
	{
		$items = array(
			'type_name' => $this->input->post('type_name'),
			'parent' => ($this->input->post('parent') ? $this->input->post('parent') : null),
			'class_id' => $this->input->post('class_id'),
			);
		if (!$this->input->post('id')) {
			$id = $this->gl_model->write_chart_types($items);
			echo json_encode(array('result'=>'success','msg'=>"Successfully added new Account Type"));
		} else {
			$id = $this->input->post('id');
			if ($items['parent'] == $id) {
				echo json_encode(array('result'=>'error','msg'=>"Account Type cannot become sub-type of itself"));
			} else {
				$this->gl_model->change_chart_types($items,array('id'=>$id));
				echo json_encode(array('result'=>'success','msg'=>"Successfully updated Account Type"));
			}
		}
	}

	*/
	public function customer_branches($ref=null)
	{
		$data = $this->syter->spawn('sales');
        $data['page_subtitle'] = "Customer List";
        $cust = $this->customer_model->get_debtors();
        //echo $this->db->last_query();
        $data['code'] = customerBranchPage($cust);
        $this->load->view('page',$data);
	}
	public function manage_customers_branch($debtor_id=null){
        $data = $this->syter->spawn('sales');
        $data['page_subtitle'] = "Manage Customer Branch";
        $items = null;
        $details = null;
        $receive_cart = array();

        if($debtor_id != null){
        	$where = array('debtor_branches.debtor_id'=>$debtor_id);
           	$details = $this->customer_model->get_debtor_branches($where);
           	// if(count($details) > 0)
            // 	$items = $details[0];
        }

        //var_dump($details);

        $data['code'] = manage_customerBranches_form($details,$debtor_id);

        $data['add_js'] = 'js/site_list_forms.js';
        $data['load_js'] = "core/customer.php";
        $data['use_js'] = "customerBranchJS";
        $this->load->view('page',$data);
    }
    public function add_branch($debtor_id=null,$debtor_branch_id=null){
        $data = $this->syter->spawn('sales');
        $data['page_subtitle'] = "Add Branch";
        $items = null;
        $receive_cart = array();

        if($debtor_branch_id != null){
        	$where = array('debtor_branches.debtor_id'=>$debtor_id,'debtor_branches.debtor_branch_id'=>$debtor_branch_id);
           	$details = $this->customer_model->get_debtor_branches($where);
           	if(count($details) > 0)
            	$items = $details[0];
        }

        $data['code'] = add_branches_form($items,$debtor_id);

        $data['add_js'] = 'js/site_list_forms.js';
        $data['load_js'] = "core/customer.php";
        $data['use_js'] = "customerBranchAddJS";
        $this->load->view('page',$data);
    }
    public function branch_details_db()
	{
		$user = $this->session->userdata('user');
		// if (!$this->input->post())
			// header("Location:".base_url()."items");

		// if($this->input->post('inactive') == ""){
		// 	$inactive = 0;
		// }else{
		// 	$inactive = 1;
		// }

		$items = array(
			'debtor_id' => $this->input->post('debtor_id'),
			'branch_name' => $this->input->post('branch_name'),
			'branch_address' => $this->input->post('branch_address'),
			'branch_post_address' => $this->input->post('branch_post_address'),
			'area' => $this->input->post('area'),
			'phone' => $this->input->post('phone'),
			'fax' => $this->input->post('fax'),
			'contact_person' => $this->input->post('contact_person'),
			'email' => $this->input->post('email'),
			'sales_person_id' => (int) $this->input->post('sales_person_id'),
			'default_shipper' => (int) $this->input->post('default_shipper'),
			'tax_grp' => (int) $this->input->post('tax_grp'),
			'inv_location' => $this->input->post('inv_location'),
			'currency' => (int) $this->input->post('currency'),
			'inactive' => (int) $this->input->post('inactive')
		);

		//var_dump($items);
		//var_dump($this->input->post('debtor_branch_id'));

		// if($fromDel){
		// 	// unset($items['tax_exempt']);
		// 	unset($items['inactive']);
		// }

		if ($this->input->post('debtor_branch_id')) {
			$id = $this->input->post('debtor_branch_id');
			$where = array('debtor_branch_id'=>$id);
			$this->customer_model->change_debtor_branch($items,$where);
			$msg = "Updated Branch: ".ucwords($this->input->post('branch_name'));
		} else {
			$id = $this->customer_model->write_debtor_branch($items);
			##########AUDIT TRAIL [START]##########
				$audit_items = array(
				'type'=>0,
				'trans_no'=>0,
				'type_desc'=>ADD_CUSTOMER_BRANCHES,
				'description'=>'id:'.$id.'||debtor_id:"'.strtoupper($this->input->post('debtor_id')).'"||branch_name:"'.ucfirst($this->input->post('branch_name')).'"',
				'user'=>$user['id']
				);
				
				$audit_id = $this->customer_model->write_to_audit_trail($audit_items);
				##########AUDIT TRAIL [END]##########
			$msg = "Added New Branch: ".ucwords($this->input->post('branch_name'));
		}

		//echo $msg;

		echo json_encode(array('id'=>$id,'msg'=>$msg));
	}
	
//Controllers - END
}