<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

ini_set('mssql.connect_timeout',0);
ini_set('mssql.timeout',0);
ini_set('memory_limit', '-1');
set_time_limit(0);

class Cycle extends CI_Controller {

	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('core/cycle_model','cycle');
		$this->load->model('core/operation_model','operation');
		$this->load->model('core/asset_model','asset');
		$this->load->helper('core/cycle_helper');
		$this->load->library('My_excel_reader');
	}
	
	function index(){
		
	}

	public function add_sku(){ 
		$data = $this->syter->spawn('cycle');
		$data['page_subtitle'] = "Cycle Counts";
		$results = $this->cycle->get_cycle_count();
		$items = array();
		if ($results) {
			$items = $results;
		}
		$data['code'] = cycle_count_details($items);
		$data['load_js'] = "core/cycleJS.php";
		$data['use_js'] = "CycleCount";
		$this->load->view('page',$data);
	}

	public function SKU_reload(){
		$data = $this->syter->spawn('cycle');
		$results = $this->cycle->get_cycle_count();
		$items = array();
		if ($results) {
			$items = $results;
			
		}
		$data['page_subtitle'] = "Cycle Counts";
		$data['code'] = cycle_reload($items);
		$data['load_js'] = "core/cycleJS.php";
		$data['use_js'] = "reloadSku";
		$this->load->view('page',$data);
	}

	function get_prod_details($bcode,$branch_code){

		$results = $this->cycle->get_prod_details($bcode,$branch_code);

		echo json_encode($results);
	}

	function new_cycle_count(){
		$user    = $this->session->userdata('user');
        $user_id = $user['id']; 
        $user_branch = $user['branch']; 
		$aria_db = $this->asset->get_aria_db($user_branch);

        $uom = $this->input->post('uom');
        $cost = $this->input->post('cost');
        $branch_code = $this->input->post('branch_code');
        $bcode = $this->input->post('bcode');
        $date = $this->input->post('date');

        $data = array(
        		'user_id'=>$user_id,
        		'uom'=>$uom,
        		'cost'=>$cost,
        		'branch_code'=>$branch_code,
        		'bcode'=>$bcode,
        		'date'=>$date
        );

		$results = $this->cycle->add_new_count($data,$aria_db);
		echo json_encode($results);
	}

	function certify_item($id){
		$user    = $this->session->userdata('user');
        $role_id = $user['role_id']; 
        $user_branch = $user['branch']; 
		$aria_db = $this->asset->get_aria_db($user_branch);
		$results = '';

		if($role_id == 5){

			$results = $this->cycle->certify_item($id,$aria_db);

		}else{

			$results = array('status'=>400,'message'=>'Sorry your not allowed to Certify the Item.');
		}
		
		echo json_encode($results);
	}

	function delete_sku(){
		$user    = $this->session->userdata('user');
        $user_id = $user['id']; 
        $user_branch = $user['branch']; 
		$aria_db = $this->asset->get_aria_db($user_branch);
        $id = $this->input->post('data');

		$results = $this->cycle->delete_sku($id,$aria_db);

		echo json_encode($results);
	}
}
?>

