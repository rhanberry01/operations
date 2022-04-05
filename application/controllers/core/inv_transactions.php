<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inv_transactions extends CI_Controller {
	var $data = null;
	public function __construct()
	{
		parent::__construct();
		$this->load->model('core/inv_transactions_model');
		$this->load->model('site/site_model');
		$this->load->helper('site/site_forms_helper');
		$this->load->helper('core/inv_transactions_helper');
	}
	public function get_uom_qty(){
		$qty='';
		$uom = $this->input->post('uom');
		$qty = $this->inv_transactions_model->get_uom_qty($uom);
		echo $qty;
	}
	public function add_movement($trx_id=null){
		$data = $this->syter->spawn('inv_movements');
		$data['page_title'] = fa('fa-edit')." New Movement Entry";

		$data['code'] = build_movement_adder_form($trx_id);
        $data['add_css'] = 'js/plugins/typeaheadmap/typeaheadmap.css';
        $data['add_js'] = array('js/plugins/typeaheadmap/typeaheadmap.js');
        $data['load_js'] = 'core/inv_transactions.php';
        $data['use_js'] = 'addMovementJS';
        $this->load->view('page',$data);
	}
	public function load_movement_items(){
		$items = $barcode_prices = array();
		$ref = $this->input->post('ref');
		if (strcasecmp($ref,'new')) {
			$results = $this->inv_transactions_model->get_movement_details_temp($ref);
			// echo $this->inv_transactions_model->db->last_query();
			if ($results) {
				$items = $results;
			}
		}
		$data['code'] = build_movement_details_list_form($items, (!empty($ref) ? $ref : null));
		$data['load_js'] = "core/inv_transactions.php";
		$data['use_js'] = "reloadBarcodeDetailsJs";
		$this->load->view('load',$data);
	}
	public function get_barcode_details(){
		$qty='';
		$branch_id = $this->input->post('branch_id');
		$barcode = $this->input->post('barcode');
		$valid_barcode = $this->inv_transactions_model->validate_barcode($barcode);
		if($valid_barcode){
			$stock_id = $this->inv_transactions_model->get_stock_id_from_barcode($barcode);
			$barcode_uom = $this->inv_transactions_model->get_barcode_uom_from_barcode($barcode);
			$barcode_desc = $this->inv_transactions_model->get_barcode_desc_from_barcode($barcode);
			$cost_of_sales = $this->inv_transactions_model->get_branch_stock_cost_of_sales($stock_id, $branch_id);
			echo $stock_id."||".$barcode_desc."||".$barcode_uom."||".$cost_of_sales;
		}else{
			echo 'warning';
		}
	}
	public function add_to_movement_details_temp(){
		$user = $this->session->userdata('user');
		$items = array(
			'header_id' => $user['id'],
			'stock_id' => $this->input->post('stock_id'),
			'barcode' => $this->input->post('barcode'),
			'description' => $this->input->post('stock_desc'),
			'uom' => $this->input->post('uom'),
			'qty' => $this->input->post('qty'),
			'unit_cost' => $this->input->post('unit_cost'),
			'pack' => $this->input->post('qty'),
			'avg_unit_cost' => $this->input->post('unit_cost'),
			'line_total' => $this->input->post('total'),
			'movement_type_id' => $this->input->post('movement_type_id'),
			'branch_id' => $this->input->post('branch_id'),
			'total_amount' => $this->input->post('total_amount'),
			'remarks' => $this->input->post('remarks'),
			'stock_location' => $this->input->post('stock_location'),
		);
		$id = $this->inv_transactions_model->write_to_movement_details_temp($items);
		// echo $this->inv_transactions_model->db->last_query();
		// echo json_encode(array("branch_id"=>$this->input->post('branch_id'), 'user_id'=>$user['id']));
		echo json_encode(array("msg"=>'Added New Item', 'id'=>$id, 'desc'=>$this->input->post('stock_desc')));
	}
	public function add_to_main_movements_tbl(){
		$user = $this->session->userdata('user');
		$latest_id = $next_id_exists = $stat = "";
		$main_items = $sub_items = $partial_items = $upd_items = array();
		//$next_id = $this->inv_transactions_model->get_movement_type_next_id($this->input->post('movement_type_id'));
		//$next_id_exists = $this->inv_transactions_model->validate_movement_id($next_id, $this->input->post('movement_type_id'));
		$rec_next_val = ($this->input->post('movement_type_id') == 1 ? $this->site_model->get_next_ref(POSITIVE_ADJUSTMENT) : $this->site_model->get_next_ref(NEGATIVE_ADJUSTMENT));
		$id = $rec_next_val->trans_type;
		$type_no = $rec_next_val->next_type_no;
		$reference = $rec_next_val->next_ref;
		$next_id_exists = ($this->input->post('movement_type_id') == 1 ? $this->site_model->check_duplicate_ref(POSITIVE_ADJUSTMENT,$reference) : $this->site_model->check_duplicate_ref(NEGATIVE_ADJUSTMENT,$reference)) ;
		
		$trans_ref_items = array(
			'trans_type'=>($this->input->post('movement_type_id') == 1 ? POSITIVE_ADJUSTMENT : NEGATIVE_ADJUSTMENT),
			// 'type_no'=>$type_no,
			'type_no'=>$type_no, //---USE receiving ID instead of type_no from trans_types (since nakaauto increment yung receiving id). Ang gamitin nalang from trans_types ay si reference c/o ENJO
			'reference'=>$reference,
			'branch_id'=>$this->input->post('branch_id')
		);
		$this->site_model->add_trans_ref($trans_ref_items);
		
		// if($next_id_exists){
			// $stat = 'warning';
		// }else{
			$main_items = array(
				'movement_type_id' => $id,
				'movement_no' => $type_no,
				'reference' => $reference,
				'branch_id' => $this->input->post('branch_id'),
				'transaction_date' => date2Sql($this->input->post('transaction_date')),
				'created_by' => $user['id'],
				'total_amount' => $this->input->post('total_amount'),
				'remarks' => $this->input->post('remarks'),
				'stock_location' => $this->input->post('stock_location')
			);
			$id = $this->inv_transactions_model->write_to_movements($main_items);
			##########AUDIT TRAIL [START]##########
				$audit_items = array(
				'type'=>0,
				'trans_no'=>0,
				'type_desc'=>ADDED_MOVEMENT_ENTRY,
				'description'=>'id:'.$id.'||branch_code:"'.$this->inv_transactions_model->get_branch_code($this->input->post('branch_id')).'||user_name:"'.$this->inv_transactions_model->user_name($user['id']).'||transaction_date:"'.date('Y-M-d', strtotime($this->input->post('transaction_date'))).'"',
				'user'=>$user['id']
				);
				
				$audit_id = $this->inv_transactions_model->write_to_audit_trail($audit_items);
			##########AUDIT TRAIL [END]##########
			$partial_items = $this->inv_transactions_model->get_partial_movement_details_temp($user['id']);
			foreach($partial_items as $val){
				$sub_items = array(
					'branch_id' => $val->branch_id,
					'header_id' => $id,
					'stock_id' => $val->stock_id,
					'barcode' => $val->barcode,
					'description' => $val->description,
					'uom' =>$val->uom,
					'qty' => $val->qty,
					'unit_cost' => $val->unit_cost,
					'pack' => $val->pack,
					'avg_unit_cost' => $val->unit_cost,
				);
				$id2 = $this->inv_transactions_model->write_to_movement_details($sub_items);
			}
			
		//	$latest_id = ($next_id+1);
			
		//	$upd_items = array(
		//		'next_id' => $latest_id
		//	);
		//	$id3 = $this->inv_transactions_model->update_movement_type_next_id($this->input->post('movement_type_id'), $upd_items);
			// echo $this->inv_transactions_model->db->last_query();
			$this->inv_transactions_model->delete_from_movement_details_temp($user['id']);
			
			$this->load->model('core/main_model');
			$this->main_model->main_movement_details($id);
			$stat = 'success';
	//	}
		echo $stat;
		// echo json_encode(array("msg"=>'Successfully added item for MOVEMENT', 'id'=>$id, 'stat'=>$stat));
	}
	public function remove_movement_details_line_item(){
		$this->inv_transactions_model->delete_movement_details_temp_line_item($this->input->post('line_id'));
	}
	
}