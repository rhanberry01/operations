<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

ini_set('mssql.connect_timeout',0);
ini_set('mssql.timeout',0);
ini_set('memory_limit', '-1');
set_time_limit(0);

class Operation extends CI_Controller {

	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('core/operation_model','operation');
		$this->load->model('core/asset_model','asset');
		$this->load->helper('core/operation_helper');
		$this->load->library('My_excel_reader');
	}
	
	function index(){
		
	}
	
	public function negative_inventory(){
		
		$data = $this->syter->spawn('operation');
		$data['page_subtitle'] = "Negative Inventory";
		$data['code'] = neg_item_list();
		$data['load_js'] = "core/OperationJS.php";
		$data['use_js'] = "NegativeInventory";
		$this->load->view('page',$data);
	}

	public function adjustment_inquiry(){
		$user    = $this->session->userdata('user');
        $user_id = $user['id']; 
        $user_branch = $user['branch']; 
		$aria_db = $this->asset->get_aria_db($user_branch);

		$data = $this->syter->spawn('operation');
		$data['page_subtitle'] = "Adjustment Inquiry";
		$results = $this->operation->get_adjustment_inquiry($aria_db);

		$items = array();
		if ($results) {
			$items = $results;
			
		}
		$data['code'] = adjustment_inquiry($items);
		$data['load_js'] = "core/OperationJS.php";
		$data['use_js'] = "AdjustmentInquiry";
		$this->load->view('page',$data);
	}

	public function negative_inventory_reload(){
		$category = $this->input->post('category');
		$supplier = $this->input->post('supplier');
		$results = $this->operation->get_sort_details($category,$supplier);

		$items = array();
		if ($results) {
			$items = $results;
			
		}
		$data['code'] = negative_inventory_reload($items);
		$data['load_js'] = "core/OperationJS.php";
		$this->load->view('load',$data);
	}

	function item_adjusment($id){
		$user    = $this->session->userdata('user');
        $user_id = $user['id']; 
        $user_branch = $user['branch']; 
		$aria_db = $this->asset->get_aria_db($user_branch);
		$next_trans = $this->operation->get_next_trans($aria_db);
		$results = $this->operation->item_adjustment_modal($id,$next_trans);
		$item_details = array();
		if ($results) {
			$item_details = $results;
		}
		$next_trans = $next_trans + 1;
		$data['code'] = item_adjustment_modal($item_details,$id,$next_trans);
		$data['add_js'] = 'js/site_list_forms.js';
        $data['load_js'] = "core/OperationJS.php";
		$this->load->view('load',$data);
		
	}

	function update_neg_item($product_id){
		$user = $this->session->userdata('user');
		$item_details = $this->operation->item_adjustment_update($product_id,$user['id']);
		
		$data['code'] = negative_inventory();
		$data['add_js'] = 'js/site_list_forms.js';
        $data['load_js'] = "core/OperationJS.php";
		$this->load->view('load',$data);
		
	}

	function add_stock_moves(){
		$user    = $this->session->userdata('user');
        $user_id = $user['id']; 
        $user_branch = $user['branch']; 
		$aria_db = $this->asset->get_aria_db($user_branch);
		$data = array(
				'user_id'=> $user_id,
				'trans_num'=>$this->input->post('trans_num'),
				'date_adjustment'=>$this->input->post('date_adjustment'),
				'product_id'=>$this->input->post('product_id'),
				'uom_qty'=>$this->input->post('uom_qty'),
				'cost'=>$this->input->post('cost'),
				'qty'=>$this->input->post('qty'),
				'unit'=>$this->input->post('unit'),
				'unit_cost'=>$this->input->post('unit_cost'),
				'total'=>$this->input->post('total'),
				'remarks'=>$this->input->post('remarks')
		);
		
		$results = $this->operation->add_new_stock_move($data,$aria_db);
		echo json_encode($results);
	}

	function uom_details($uom){

		$user = $this->session->userdata('user');
		$results = $this->operation->uom_details($uom);

		echo json_encode($results);
	}
}
?>