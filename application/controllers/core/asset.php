<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

ini_set('mssql.connect_timeout',0);
ini_set('mssql.timeout',0);
ini_set('memory_limit', '-1');
set_time_limit(0);

class Asset extends CI_Controller {

	var $data = null;
	
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('core/asset_model');
		//$this->load->model('core/site_model');
		$this->load->helper('core/asset_helper');
		$this->load->library('My_excel_reader');
	}
	
	function index(){
		
		
	}
	
	
		
	function insert_request_asset_temp(){
	
		$user = $this->session->userdata('user');
		$asset_type = $this->input->post('asset_type');
		$asset_no = $this->input->post('asset_no');
		$description = $this->input->post('description');
		$quantity = $this->input->post('quantity');
		
		$request_asset_details = array(
			'asset_type'=>$asset_type,
			'asset_id'=>$asset_no,
			'description'=>$description,
			'quantity'=>$quantity,
			'user_id'=>$user['id']
		);
		
		$this->asset_model->insert_request_asset_temp($request_asset_details);
		

	}
	
	public function asset_dispose(){
		
		$data = $this->syter->spawn('asset');
		$data['page_subtitle'] = "Disposal Form ";
		$data['code'] = dispose_asset_form();
		$data['load_js'] = "core/assetJS.php";
		$data['use_js'] = "AssetDispose";
		$this->load->view('page',$data);
		
	}
	
	public function reload_asset_branch_drop(){

		$counter = $this->input->post('counter');
		$branch = $this->input->post('branch');

		$results = $this->asset_model->get_asset_branch_drop($branch);
		$data['code'] = reload_branch_asset_type($results,$counter);
		$data['load_js'] = "core/assetJS.php";
		$data['use_js'] = "reloadAssetTypeJs";
		$this->load->view('load',$data);
	}
	
	
	
	
	public function reload_asset_type_drop(){

		$asset_type = $this->input->post('asset_type');
		
		$results = $this->asset_model->get_asset_type_drop($asset_type);
		//echo var_dump($results);
		$data['code'] = reload_asset_type($results);
		$data['load_js'] = "core/assetJS.php";
		$data['use_js'] = "reloadAssetTypeJs";
		$this->load->view('load',$data);
	}
	
	public function get_asset_descripiton(){
	
		$asset_id = $this->input->post('asset_id');
		$results = $this->asset_model->get_asset_descripiton_db($asset_id);	
		echo $results;
	}
	
	public function load_asset_request_list(){
		
		$ref = $this->input->post('ref');

		$results = $this->asset_model->get_request_asset_list_temp($ref);

		$data['code'] = build_asset_request_list_form($results);
		$data['load_js'] = "core/assetJS.php";
		$data['use_js'] = "reloadAssetItemsJS";
		$this->load->view('load',$data);
	}
	
	
	function delete_asset_req_temp(){
		$ref = $this->input->post('ref');
		$results = $this->asset_model->del_request_temp($ref);
	}
	
	
	function insert_request_asset_details(){
	
		$user = $this->session->userdata('user');
		$branch_code = $this->input->post('branch_code');
		$department_code = $this->input->post('department_code');
		$unit_code = $this->input->post('unit_code');
		$date_needed = $this->input->post('date_needed');
		$remarks = $this->input->post('remarks');
		
		$request_asset_header_details = array(
		  'user_id'=>$user['id'],
		  'to_branch'=>$branch_code,
		  'to_department'=>$department_code,
		  'to_unit'=>$unit_code,
		  'remarks'=>$remarks,
		  'date_needed'=>date2sql($date_needed)	
		);
		
		//echo var_dump($request_asset_header_details);
		
		$results = $this->asset_model->get_request_asset_list_temp($user['id']);
		
		if($results != null){
			
			$return_id = $this->asset_model->insert_request_header_details($request_asset_header_details);

			foreach($results as $val){
				
					$request_asset_details = array(
						'request_id'=>$return_id,
						'asset_type'=>$val->asset_type,
						'asset_id'=>$val->asset_id,
						'description'=>$val->description,
						'quantity'=>$val->quantity,
						'user_id'=>$val->user_id,

					);
				
				$this->asset_model->insert_request_asset_details($request_asset_details);
				
				$this->asset_model->delete_temp_request_asset_details($user['id']);			
					
				}
		}else{
			echo 'err_msg';
		}
		
	}
	
	function asset_request(){
	
		$user = $this->session->userdata('user');
		$results = $this->asset_model->get_request_asset_list_temp($user['id']);
		$data = $this->syter->spawn('asset');
		$data['page_subtitle'] = "Asset Request Form";
		$data['code'] = request_asset_form($results);
		$data['add_js'] = 'js/site_list_forms.js';
        $data['load_js'] = "core/assetJS.php";
        $data['use_js'] = "ReqassetJS";
		$this->load->view('page',$data);
	}
	
	
	function asset_history_view($id){
	
		$asset_history_details = $this->asset_model->get_asset_history_details($id);
		
		//$request_asset_details = $this->asset_model->get_asset_request_details($id);
		$data['code'] = asset_history_view_list($asset_history_details,$id);
		$data['add_js'] = 'js/site_list_forms.js';
        $data['load_js'] = "core/assetJS.php";
       // $data['use_js'] = "ReqassetInqJS";
		$this->load->view('load',$data);
		
	}
	
	public function new_asset_list($act_tabs = null){
		
		//$act_tabs = $this->input->post('tab_action');

		$data = $this->syter->spawn('asset');
	//	$data['page_title'] = "Asset List";
		$data['code'] = asser_list_tab($act_tabs);
        $data['load_js'] = 'core/assetJS.php';
        $data['use_js'] = 'newassetTabJS';
        $this->load->view('page',$data);
	}
	function new_asset_list_(){
	
		$data = $this->syter->spawn('asset');
		$data['page_subtitle'] = " ";
		 $asset_list = $this->asset_model->get_asset();
		$data['code'] = asset_list($asset_list);
		$data['add_js'] = 'js/site_list_forms.js';
        $data['load_js'] = "core/assetJS.php";
        $data['use_js'] = "newassetJS";
		$this->load->view('load',$data);
	
	}
		
	function new_asset($asset_id = null){
		$items = array();
		if($asset_id != null){
           	$description = $this->asset_model->get_asset($asset_id);
			$items = $description[0];
        }
		$data = $this->syter->spawn('asset');
		$data['page_subtitle'] = "New Asset";
		$data['code'] = new_asset_form($items);
		$data['add_js'] = 'js/site_list_forms.js';
        $data['load_js'] = "core/assetJS.php";
        $data['use_js'] = "newassetJS";
		$this->load->view('page',$data);
	}

	function asset_file_upload(){
		$user = $this->session->userdata('user');

	  if($this->input->post('uploader')){
		
			if (!file_exists('asset_file'))
				mkdir('asset_file',0777,true);
			
			$config['upload_path'] = 'asset_file';
			$config['allowed_types'] = 'xls';
			//$config['max_size'] = '500';
				
			 $this->load->library('upload',$config);
		
			 if (!$this->upload->do_upload('asset_file')){
					$error = array('error' => $this->upload->display_errors());
					site_alert($error['error'],"error");
				}else{
					$log_upload_data = array('upload_data' => $this->upload->data());
					$file_type = $log_upload_data['upload_data']['file_ext'];
					$data_rows = $this->excelFileRowGeneratorAsset($log_upload_data);				
					site_alert('Asset has been uploaded',"success");
				}
		}
		
		$data = $this->syter->spawn('asset');
		$data['page_subtitle'] = "Asset Upload";
		$data['code'] = asset_file_uploader_form();
		$data['add_js'] = 'js/site_list_forms.js';
        $data['load_js'] = "core/assetJS.php";
        $data['use_js'] = "assetJS";
		$this->load->view('page',$data);
		
		
	}
	
	function excelFileRowGeneratorAsset($log_upload_data)
	{
			
			$excelreader = new Excel_reader();
			$excelreader->read($log_upload_data['upload_data']['full_path']);

			// Get the contents of the first worksheet
			$worksheet = $excelreader->sheets[0];

			$numRows = $worksheet['numRows']; // ex: 14
			$numCols = $worksheet['numCols']; // ex: 4
			$cells = $worksheet['cells']; // the 1st row are usually the field's name
		//	echo $numRows;
			$array_items = array('CARTS & WHEELERS','FURNITURES & FIXTURES','OFFICE & STORE EQUIPMENT','REF & AIRCON EQUIPMENT','MACHINERIES','TOOLS');
			
			$acquired_date ='';
			$asset_no = '';
			$acquired_dates = '';
			$description ='';
			$assigned_to = '';
			$remarks = '';
			$acquisition_cost = '';
			$life_span = '';
			$remaining_life = '';
			$branch_codes = '';
			$specification = '';
			$serial_no ='';
			$invoice_no ='';
			$supplier = '';

			 for($i=3; $i <=$numRows; $i++){
				if(!in_array($cells[$i][1], $array_items)) {
					
					$asset_no = $cells[$i][1];
					$acquired_dates = $cells[$i][2];
					$description = $cells[$i][3];
					$assigned_to = $cells[$i][5];
					$remarks = $cells[$i][6];
					$acquisition_cost = $cells[$i][7];
					$life_span = $cells[$i][8];
					$remaining_life = $cells[$i][9];
					$branch_codes = $cells[$i][10];
					$specification = $cells[$i][11];
					$serial_no = $cells[$i][12];
					$invoice_no = $cells[$i][13];
					$supplier = $cells[$i][14];

				
					if ($acquired_dates != ''){
						$acquired_date = $acquired_dates;
						//$acquired_dates;
					//$dates = explode('/',$acquired_dates);
				//	echo $dates[0];
				//	echo $dates[1]
				//	echo $dates[2];
				//	echo $acquired_dates.'----'.$acquired_date.'</br>';
						//$acquired_date = $dates[1].'/'.$dates[0].'/'.$dates[2];
						
					}else{
						$acquired_date = '00/00/0000';
					}
					
					$branch_code = $asset_type = $division_code = $department_code = $unit_code	= ''; 
					
					if (trim($asset_no) == '')
						continue;
					list($branch_code,$asset_type,$division_code,$department_code,$unit_code) = explode(' ',$asset_no);
					
					
					$life_span = trim(str_replace('YEARS','',$life_span));
					
					$row = $this->asset_model->check_duplicate_asset($asset_no);
					
					if($row == null){
						$this->generate_asset_no($asset_no,
												 '',
											     $description,
											     $acquired_date,
											     $acquisition_cost,
											     $life_span,
											     $remarks,
											     $branch_codes,
											     $asset_type,
											     $division_code,
											     $department_code,
											     $unit_code,
											     $assigned_to,
											     $remaining_life,
											     $specification,
											     $serial_no,
											     $invoice_no,
											     $supplier);
					}
				}
			 }
		

			
	}
	function check_asset_numbers(){
	
		$branch_code = $this->input->post('branch_code');
		$asset_type = $this->input->post('asset_type');
		$division_code = $this->input->post('division_code');
		$department_code = $this->input->post('department_code');
		$unit_code = $this->input->post('unit_code');
		
		if($unit_code == -1 OR $unit_code == ''){
			 $unit_code_pad = str_pad('0',3,STR_PAD_LEFT);	
		}else{
			 $unit_code_pad = $unit_code;
		}
		
		
		
		$pad = $this->asset_model->count_asset_numbers($branch_code,$asset_type,$division_code,$department_code,$unit_code_pad);
		$pad++;
		$new_asset_no 	= str_pad($pad, 4,'0', STR_PAD_LEFT );
		$new_asset 		= $branch_code ." ". $asset_type ." ". $division_code." ". $department_code ." ".  $unit_code_pad. " " . $new_asset_no;
		
		echo $new_asset;
		
		
	}
	
	function generate_asset_no($asset_no,
							   $gen_asset_no,
							   $description,
							   $acquired_date,
							   $acquisition_cost,
							   $life_span,
							   $remarks,
							   $branch_code,
							   $asset_type,
							   $division_code,
							   $department_code,
							   $unit_code,
							   $assigned_to,
							   $remaining_life,
							   $specification,
							   $serial_no,
							   $invoice_no,
							   $supplier ){
			//$pad = $unit_code_pad  = 0;
	$branch_ = $asset_ = $division_ = $department_ = $unit_ = $unit_pad	= '';

		if($asset_no == ""){
		
			$new_asset = $gen_asset_no;
			
				list($branch_,$asset_,$division_,$department_,$unit_,$unit_pad) = explode(' ',$new_asset);
				  $branch_code = $branch_;
				  $asset_type = $asset_;
				  $division_code = $division_;
				  $department_code = $department_;
				  $unit_code = $unit_;
		 
		}else{

			$new_asset 	= $asset_no;
			
			list($branch_,$asset_,$division_,$department_,$unit_,$unit_pad) = explode(' ',$new_asset);
				  $branch_code = $branch_;
				  $asset_type = $asset_;
				  $division_code = $division_;
				  $department_code = $department_;	
				  $unit_code = $unit_;
		}
		
			//return $unit_code;
			//insert 0_asset
			
//'date_acquired'=>date('Y-m-d', strtotime($acquired_date)),
			$asset_details = array(
				'asset_no'=>$new_asset,
				'item_description'=>$description,
				'date_acquired'=>date('Y-m-d',strtotime($acquired_date)),
				'acquisition_cost'=>$acquisition_cost,
				'life_span'=>$life_span,
				'asset_remarks'=>$remarks,
				'branch_code'=>$branch_code,
				'asset_type'=>$asset_type,
				'division_code'=>$division_code,
				'department_code'=>$department_code,
				'remaining_life'=>$remaining_life,
				'unit_code'=>$unit_code, 
				'assign_to'=>$assigned_to, 
				'specification'=>$specification, 
				'serial_no'=>$serial_no, 
				'invoice_no'=>$invoice_no, 
				'supplier'=>$supplier,
				'c_branch_code'=>$branch_code,
				'c_department_code'=>$department_code,
				'c_division_code'=>$division_code,
				'c_unit_code'=>$unit_code
			);
		
				$db_insert_id = $this->asset_model->insert_asset($asset_details);

				
				if($db_insert_id){
					//echo $db_insert_id.'>>>1';
					//insert depreciation details
						//insert 0_asset_history
						$user = $this->session->userdata('user');
							$asset_details_history = array(
								'asset_id'=>$db_insert_id,
								'asset_no'=>$new_asset,
								'branch_code'=>$branch_code,
								'asset_type'=>$asset_type,
								'division_code'=>$division_code,
								'department_code'=>$department_code,
								'unit'=>$unit_code,
								'date_'=>date('Y-m-d', strtotime($acquired_date)),
								'description'=>$description,
								'emp_assign'=>$assigned_to, 
								'user_id'=>$user['id']
							);
						
							$this->asset_model->insert_asset_history($asset_details_history);
				
							$asset_numbers = array(
								'branch_code'=>$branch_code,
								'asset_type'=>$asset_type,
								'division_code'=>$division_code,
								'department_code'=>$department_code,
								'unit_code'=>$unit_code,
								'count'=>$unit_pad
							);
							$this->asset_model->insert_asset_numbers($asset_numbers);
						
						
					 $gl_account = $this->asset_model->get_asset_gl_account($asset_type);
			
					  $debit = $gl_account->gl_debit;
					  $credit = $gl_account->gl_credit;
					 
					 $this->generate_depreciation_details($db_insert_id,$acquired_date,$life_span,$remaining_life,$acquisition_cost,$branch_code,$debit,$credit);
				

					echo 1;

				}else{
					echo 0;
				}
			

	}
	
	
	
	function generate_depreciation_details($db_insert_id,$date,$life_span,$remaining_life,$acquisition_cost,$branch_code,$debit,$credit){
		
		
		
		
		if($life_span == 0){
			
			$aria_db = $this->asset_model->get_aria_db($branch_code);
			$monthly_depreciation = 1;
			$current_date =  date('01-m-Y',strtotime($date));;
			$depreciation_details = array(
							'asset_id'=> $db_insert_id,
							'branch_code'=> $branch_code,
							'_date'=>date2sql($current_date),
							'amount'=> $monthly_depreciation,
							'with_gl'=> '0'
						);
				
					$dep_id = $this->asset_model->insert_depreciation_details($depreciation_details);
						//temporarily comment gl transaction 
						//$this->add_gl_trans(64, $db_insert_id, $current_date,$debit, 0, 0, null, $monthly_depreciation, null, 0 , null, null, null , $aria_db);
						//$this->add_gl_trans(64, $db_insert_id, $current_date,$credit, 0, 0, null, -$monthly_depreciation, null, 0, null, null, null , $aria_db );
		
			
			
		}else{
			
		//$monthly_depreciation = round($acquisition_cost/($life_span * 12),2);
		$monthly_depreciation_ = ($acquisition_cost/(($life_span * 12) + $remaining_life ));
		//$accumulated_depreciation = $monthly_depreciation*(($life_span * 12)-$remaining_life);
		$beggining_depre = $acquisition_cost - $monthly_depreciation_;

		$monthly_depreciation = ($beggining_depre/(($life_span * 12) + $remaining_life ));

		$monthly_depr_total = 0;

		//$current_date = $start_date = "04/01/2015";

		$current_date =  date('01-m-Y',strtotime($date));;
		
		$not_recorded_months = (($life_span*12) + $remaining_life);

		$salvage_value_itm = array(
							'salvage_value'=>$monthly_depreciation_
							);

		$upd_salvage_value = $this->asset_model->upd_salvage_value($db_insert_id,$salvage_value_itm);


		$aria_db = $this->asset_model->get_aria_db($branch_code);
	
			for($i=1;$i<=$not_recorded_months; $i++){
				
					if($i != $not_recorded_months){
							$depreciation_details = array(
								'asset_id'=> $db_insert_id,
								'branch_code'=> $branch_code,
								'_date'=>date2sql($current_date),
								'amount'=> $monthly_depreciation,
								'with_gl'=> '0'
							);
					
						$dep_id = $this->asset_model->insert_depreciation_details($depreciation_details);
						//temporarily comment gl transaction 
						//$this->add_gl_trans(64, $db_insert_id, $current_date,$debit, 0, 0, null, $monthly_depreciation, null, 0 , null, null, null , $aria_db);
						//$this->add_gl_trans(64, $db_insert_id, $current_date,$credit, 0, 0, null, -$monthly_depreciation, null, 0, null, null, null , $aria_db );
				
					}else{
					
						$monthly_depreciation_ = $monthly_depreciation;
						
						$depreciation_details = array(
								'asset_id'=> $db_insert_id,
								'branch_code'=> $branch_code,
								'_date'=>date2sql($current_date),
								'amount'=> $monthly_depreciation_,
								'with_gl'=> '0'
						);
					
						$dep_id = $this->asset_model->insert_depreciation_details($depreciation_details);
						//temporarily comment gl transaction 
						//$this->add_gl_trans(64, $db_insert_id, $current_date,$debit, 0, 0, null, -$monthly_depreciation_, null, 0, null, null , null ,  $aria_db);
				        //$this->add_gl_trans(64, $db_insert_id, $current_date,$credit, 0, 0, null, $monthly_depreciation_, null , 0 , null, null, null , $aria_db );
					
					
					}
				$current_date = date('Y-m-d', strtotime("+1 months", strtotime($current_date)));
			}
		
		
		}
	
		
			// for($j=1; $j <=$remaining_life; $j++){
				
					// if($j != $remaining_life){
					
						// $depreciation_details = array(
							// 'asset_id'=> $db_insert_id,
							// 'branch_code'=> $branch_code,
							// '_date'=>date2sql($current_date),
							// 'amount'=> $monthly_depreciation,
							// 'with_gl'=> '1'
						// );
						
						    // $dep_id  =  $this->asset_model->insert_depreciation_details($depreciation_details);
						
							// $data = $this->add_gl_trans(64, $db_insert_id, $current_date, null, 0, 0, null, $monthly_depreciation, null, 0 , null, null, null , $aria_db);
							
							// $this->add_gl_trans(64, $db_insert_id, $current_date, null, 0, 0, null, -$monthly_depreciation, null, 0, null, null, null , $aria_db );
							// $accumulated_depreciation += $monthly_depreciation;
		
						 
					// }else{
					
						// $adj_amt = $acquisition_cost - $accumulated_depreciation -1;
						// $depreciation_details = array(
							// 'asset_id'=> $db_insert_id,
							// 'branch_code'=> $branch_code,
							// '_date'=>date2sql($current_date),
							// 'amount'=> $adj_amt,
							// 'with_gl'=> '1'
						// );
						
						// $this->asset_model->insert_depreciation_details($depreciation_details);
							// $this->add_gl_trans(64, $db_insert_id, $current_date,null, 0, 0, null, -$adj_amt, null, 0, null, null , null ,  $aria_db);
							// $this->add_gl_trans(64, $db_insert_id, $current_date,null, 0, 0, null, $adj_amt, null , 0 , null, null, null , $aria_db );
						// $accumulated_depreciation += $adj_amt;
					
					// }
							
						// $current_date = date('Y-m-d', strtotime("+1 months", strtotime($current_date)));
	
			// }

	}
	

	function add_gl_trans($type, $trans_id, $date_, $account, $dimension, $dimension2, $memo_,$amount, $currency=null, $person_type_id=null, $person_id=null,	$err_msg="", $rate=0 , $ar)
	{		
		$gl_details = array(
			'type'=>$type,
			'type_no'=>$trans_id,
			'tran_date'=>date2sql($date_),
			'account'=>$account,
			'amount'=>$amount,
			'dimension_id'=>$dimension,
			'dimension2_id'=>$dimension2
		);	
		 $this->asset_model->insert_gl_trans($gl_details,$ar,$amount);
	}
	
	
	
	function asset_new_db(){

		$asset_id = $this->input->post('asset_id');
			if($asset_id != ''){
				die();
			}else{
			
			
				$ui_asset_no = $this->input->post('ui_asset_no');
				$gen_asset_no = $this->input->post('next_asset_no');
				$branch_code = $this->input->post('branch_code');
				$asset_type = $this->input->post('asset_type');
				$division_code = $this->input->post('division_code');
				$department_code = $this->input->post('department_code');
				$unit_code = $this->input->post('unit_code');
				$description = $this->input->post('asset_name');
				$acquired_date = $this->input->post('acquired_date');
				$acquisition_cost = $this->input->post('acquisition_cost');
				$life_span = $this->input->post('life_span');
				$remarks = $this->input->post('remarks');
				$assigned_to = $this->input->post('assign_to');
				$remaining_life = $this->input->post('remaining');
				$specification = $this->input->post('specification');
				$serial_no = $this->input->post('serial_no');
				$invoice_no = $this->input->post('invoice');
				$supplier = $this->input->post('supplier');
				
				  $data = $this->generate_asset_no(
										   $ui_asset_no,
										   $gen_asset_no,
										   $description,
										   $acquired_date,
										   $acquisition_cost,
										   $life_span,
										   $remarks,
										   $branch_code,
										   $asset_type,
										   $division_code,
										   $department_code,
										   $unit_code,
										   $assigned_to,
										   $remaining_life,
										   $specification,
										   $serial_no,
										   $invoice_no,
										   $supplier);	
				
				 /* if($data == 0){
						echo 0;

				  }else{
						echo 1;
				  }*/
										   
					

			}
	
	
	}
	
	function update_request_status(){
		$id = $this->input->post('header_id');
		$user = $this->session->userdata('user');
		$upd_details = array(
		'status' => '2',
		'manager_approval' => $user['id']
		);
		$upd_request_status = $this->asset_model->upd_request_status($upd_details,$id);
	}
	
	function update_request_status_admin(){
		$id = $this->input->post('header_id');
		$user = $this->session->userdata('user');
		$upd_details = array(
		'status' => '3',
		'approve_by' => $user['id']
		);
		$upd_request_status = $this->asset_model->upd_request_status($upd_details,$id);
	}
	
	
	
	function request_asset_view($id){
		 
		$request_asset__header_list = $this->asset_model->get_asset_request_header($id);
		
		$request_asset_details = $this->asset_model->get_asset_request_details($id);
		$data['code'] = request_asset_view_list($request_asset__header_list,$request_asset_details);
		$data['add_js'] = 'js/site_list_forms.js';
        $data['load_js'] = "core/assetJS.php";
       // $data['use_js'] = "ReqassetInqJS";
		$this->load->view('load',$data);
	}
	
	
	function asset_transfer_details_view($id){

		// echo '--------->'.$id;
		$asset_transfer_header = $this->asset_model->get_asset_transfer_header($id);
		
		$asset_transfer_details = $this->asset_model->get_asset_transfer_details($id);
		$data['code'] = asset_transfer_view_form($asset_transfer_header,$asset_transfer_details,$id);
		$data['add_js'] = 'js/site_list_forms.js';
        $data['load_js'] = "core/assetJS.php";
       // $data['use_js'] = "ReqassetInqJS";
		$this->load->view('load',$data);
	}
	
	function request_asset_inquiry($act_tabs = null){
	//$act_tabs = $this->input->post('tab_action');

		$data = $this->syter->spawn('asset');
	//	$data['page_title'] = "Asset List";
		$data['code'] = asser_list_inquiry_tab($act_tabs);
        $data['load_js'] = 'core/assetJS.php';
        $data['use_js'] = 'ReqassetInqTabJS';
        $this->load->view('page',$data);	
		
	}
	function request_asset_inquiry_(){
		
		$user = $this->session->userdata('user');
		$emp_number = $user['emp_number'];
		$data = $this->syter->spawn('asset');
		$data['page_subtitle'] = "Asset Request List";
		
		$depcode = $user['department_id'];
		$get_user_department_code = $this->asset_model->get_user_department_code($depcode);

		$is_manager = 0;
		$asset_department_code = $get_user_department_code->asset_dept_code;
		$department_id  = $get_user_department_code->department_id;
		$manager_id = $get_user_department_code->manager_id;

		  if($manager_id == $user['emp_number']){
			   $is_manager = 1;
		  }
			
		
		  $request_asset_header_list = $this->asset_model->get_asset_request_header_in($asset_department_code,$is_manager,$depcode);
		  
		
		//$get_manager_dept_code = $this->asset_model->get_manager_dept_code($emp_number);
		 
		// $dep_code = array();
		 
		// foreach($get_manager_dept_code as $val){
		//  array_push($dep_code,$val->department_code);
		// }	 
	//	$request_asset__header_list = $this->asset_model->get_asset_request_header($dep_code);
		//$request_asset__header_list= array();

		$data['code'] = request_asset_inquiry_list($request_asset_header_list,$is_manager,$user['emp_number'],$department_id);
		
		$data['add_js'] = 'js/site_list_forms.js';
        $data['load_js'] = "core/assetJS.php";
        $data['use_js'] = "ReqassetInqJS";
		$this->load->view('load',$data);
	
	}
	
	function asset_transfer_inquiry($act_tabs=null){
		//$act_tabs = $this->input->post('tab_action');

		$data = $this->syter->spawn('asset');
		//$data['page_title'] = "";
		$data['code'] = asser_transfer_header_list_tab($act_tabs);
        $data['load_js'] = 'core/assetJS.php';
        $data['use_js'] = 'transassetInqTabJS';
        $this->load->view('page',$data);
		
	}


	function asset_disposal_inquiry($act_tabs=null){
		//$act_tabs = $this->input->post('tab_action');

		$data = $this->syter->spawn('asset');
		//$data['page_title'] = "";
		$data['code'] = asser_disposal_list_tab($act_tabs);
        $data['load_js'] = 'core/assetJS.php';
        $data['use_js'] = 'DisposalInqTabJS';
        $this->load->view('page',$data);
		
	}




	function asset_disposal_inquiry_(){
		$is_manager = 0;
		$user = $this->session->userdata('user');
		$data = $this->syter->spawn('asset');
		$data['page_subtitle'] = "Asset Transfer List";
		$asset_disposal_details = $this->asset_model->get_asset_disposal();
		$data['code'] = asset_disposal_header_list($asset_disposal_details);
		$data['add_js'] = 'js/site_list_forms.js';
        $data['load_js'] = "core/assetJS.php";
        $data['use_js'] = "disposalInqJS";
		$this->load->view('load',$data);
	
	}





	function asset_transfer_inquiry_(){
		$is_manager = 0;
		$user = $this->session->userdata('user');
		$emp_number = $user['emp_number'];	
		$depcode = $user['department_id'];
		$get_user_department_code = $this->asset_model->get_user_department_code($depcode);

		$asset_department_code = $get_user_department_code->asset_dept_code;
		$manager_id = $get_user_department_code->manager_id;

		if($manager_id == $user['emp_number']){
			$is_manager = 1;
		}
			
		$data = $this->syter->spawn('asset');
		$data['page_subtitle'] = "Asset Transfer List";
		$asset_transfer_details = $this->asset_model->get_asset_transfer_details2();
		$data['code'] = asset_transfer_header_list($asset_transfer_details,$is_manager);
		$data['add_js'] = 'js/site_list_forms.js';
        $data['load_js'] = "core/assetJS.php";
        $data['use_js'] = "transassetInqJS";
		$this->load->view('load',$data);
	
	}
	
	function assign_asset($id){
	
		$request_asset_header_list = $this->asset_model->get_asset_request_header($id);
		
		$request_asset_details = $this->asset_model->get_asset_request_details($id);
		
		$data = $this->syter->spawn('asset');
		$data['page_subtitle'] = "Assign Asset";
		$data['code'] = assign_asset_form($request_asset_header_list,$request_asset_details);
		$data['add_js'] = 'js/site_list_forms.js';
        $data['load_js'] = "core/assetJS.php";
        $data['use_js'] = "assignAssetJS";
		$this->load->view('page',$data);

	}
	
	function process_assign_asset(){
		
		
		$count = $this->input->post('asset_request_count');
		$check_assigned_list = 0;
		for($i=1;$i<=$count;$i++){
			
			$asset_no = $this->input->post('asset_no_'.$i);
			if($asset_no){
				$check_assigned_list = $check_assigned_list + 1;
			}
		}
		
		if($check_assigned_list){
			

					$remarks = $this->input->post('remarks');
					$to_branch = $this->input->post('to_branch');
					$to_department = $this->input->post('to_department');
					$date_requested = $this->input->post('date_requested');
					$date_needed = $this->input->post('date_needed');
					$requested_by = $this->input->post('requested_by');
					$admin = $this->input->post('approved_by');
					$manager = $this->input->post('manager');
					$asset_request_id = $this->input->post('asset_request_id');
					$count = $this->input->post('asset_request_count');
					$branch_array = array();
					$user = $this->session->userdata('user');
					
					$upd_details = array(
					'status' => '4'
					);
					
					$this->asset_model->upd_request_status($upd_details,$asset_request_id);
					
					
					 for($i=1;$i<=$count;$i++){
						 $branch =  $this->input->post('branch_code_'.$i);
						 if(!in_array($branch,$branch_array)){
							array_push($branch_array,$branch);
						}
					
					}
					
					$asset_transfer_header_count = count($branch_array);
							
					 for($j=1;$j<=$asset_transfer_header_count;$j++){
					 
							 $asset_transfer_header = array(
								'from_branch'=>$branch_array[$j-1],
								'to_branch'=>$to_branch,
								'to_department'=>$to_department,
								'remarks'=>$remarks,
								'date_requested'=>$date_requested,
								'date_needed'=>$date_needed,
								'assigned_by'=>$user['id'],
								'requested_by'=>$requested_by,
								'approved_by_manager'=>$manager,
								'approved_by_admin'=>$admin
							  );
						
								 
						$id = $this->asset_model->insert_asset_transfer_header($asset_transfer_header);
							
						 for($i=1;$i<=$count;$i++){
						 
							 $branch =  $this->input->post('branch_code_'.$i);
							 $asset_type =  $this->input->post('asset_type_c'.$i);
							// $description =  $this->input->post('asset_description_'.$i);
							 $branch =  $this->input->post('branch_code_'.$i);
							 $asset_no = $this->input->post('asset_no_'.$i);	
							 $asset_details_id = $this->input->post('asset_details_id_'.$i);	
							// $asset_name = $this->asset_model->get_asset_no_db($asset_no);
							 $description = $this->asset_model->get_asset_descriptions_db($asset_no);
							 
							// echo $description;
							 $asset_transfer_details = array(
								'asset_type'=>$asset_type,
								'asset_id'=>$asset_no,
								'description'=>$description,					
								'asset_transfer_id'=>$id,
							);

								if($branch_array[$j-1] == $branch){
								  $this->asset_model->insert_asset_transfer_details($asset_transfer_details);
								}
								
							// $assign_asset_details =  array(
							// 'asset_request_id'=>$asset_request_id,
							// 'asset_request_detail_id'=>$asset_details_id,
							// 'asset_id'=>$asset_no,
							// 'asset_no'=>$asset_name
							// );
						
							// $this->asset_model->insert_assign_asset_details($asset_transfer_details);

						  }
						 
						 // echo $description;
					
						 
						 
					 }
					 
					 echo '1';
		 
		 }else{
				echo '0';	
		 }
		 
	##############################################################################################	 
		 
		 // for($i=1;$i<=$count;$i++){
			
			// // $asset_type =  $this->input->post('asset_type_c'.$i);
			 // $branch =  $this->input->post('branch_code_'.$i);
			 // $asset_no = $this->input->post('asset_no_'.$i);	
			 // $asset_details_id = $this->input->post('asset_details_id_'.$i);	
			 // $asset_name = $this->asset_model->get_asset_no_db($asset_no);
			 
			 
			 // $asset_transfer_header = array(
				// 'from_branch'=>
				// 'to_branch'=>
				// 'to_department'=>
				// 'remarks'=>
				// 'date_requested'=>
				// 'date_needed'=>
			 // );
			 
			 // $asset_transfer_details =  array(
				// 'asset_request_id'=>$asset_request_id,
				// 'asset_request_detail_id'=>$asset_details_id,
				// 'asset_id'=>$asset_no,
				// 'asset_no'=>$asset_name
			// );
			
			// //s$this->asset_model->insert_assign_asset_details($asset_transfer_details);
			
			
		 // }
		
	} 

	// ______________________________________________________ new lester _________________________________________

		public function asset_list_reload(){
	
		$c_branch = $this->input->post('c_branch');
		$asset_no = $this->input->post('asset_no');
		$assined_p = $this->input->post('assined_p');
		
		$results = $this->asset_model->get_asset_list($c_branch,$asset_no,$assined_p);

		$items = array();
		if ($results) {
			$items = $results;
			
		}
		// print_r($items);die();
		

		$data['code'] = asset_list_reload_form($items);
		$data['load_js'] = "core/assetJS.php";
		$data['use_js'] = "loadAssetJs";
		$this->load->view('load',$data);
	}

	public function print_asset_list($c_branch=null,$asset_no=null,$assined_p=null){

	$details= array('c_branch' => $c_branch,
				 'asset_no' => $asset_no,
				 'assined_p' => $assined_p);

	$data['print_items'] = $details ; 

	 $this->load->view('contents/prints/print_asset_list.php',$data); //full details

	}

	public function print_asset_history($id=null){

	$data['asset_id'] = array('id' => $id); 


	$this->load->view('contents/prints/print_asset_history.php',$data); //full details

	}

	// ______________________________________________________ new lester _________________________________________

	public function load_transfer_slips(){
		$items = array();
		$datefrom = $this->input->post('datefrom');
		$dateto = $this->input->post('dateto');
		$transferno = $this->input->post('transferno');
		
		$results = $this->asset_model->get_transfer_header($datefrom,$dateto,$transferno);
		
		if ($results) {
			$items = $results;
		}
		$data['code'] = transfer_slip_list($items);
		$data['load_js'] = "core/assetJS.php";
		$data['use_js'] = "transliploadJS";
		$this->load->view('load',$data);
	}
	
	
	function view_trans_slip(){
		$data = $this->syter->spawn('asset');
		$asset_transfer_header = $this->asset_model->get_asset_transfer_header_();
		$data['code'] = asset_transfer_Slip($asset_transfer_header);
        $data['load_js'] = 'core/assetJS.php';
        $data['use_js'] = 'TransSlipJS';
        $this->load->view('page',$data);
		
	}
	
	function asset_transfer($act_tabs = null){
			
		//$act_tabs = $this->input->post('tab_action');
		$data = $this->syter->spawn('asset');
		//$data['page_title'] = "Asset Transfer List";
		$data['code'] = asser_transfer_tab($act_tabs);
        $data['load_js'] = 'core/assetJS.php';
        $data['use_js'] = 'transAssetTabJS';
        $this->load->view('page',$data);
	}
	
	function asset_transfer_(){
		$data = $this->syter->spawn('asset');
		$data['page_subtitle'] = "Asset Transfer List";
		
		$is_manager = 0;
		$user = $this->session->userdata('user');
		$emp_number = $user['emp_number'];
		$depcode = $user['department_id'];
		$get_user_department_code = $this->asset_model->get_user_department_code($depcode);
		$asset_department_code = $get_user_department_code->asset_dept_code;
		
		$manager_id = $get_user_department_code->manager_id;
		
		  if($manager_id == $user['emp_number']){
			   $is_manager = 1;
		  }
		
		$asset_transfer_header = $this->asset_model->get_asset_transfer_header_in($asset_department_code,$depcode);
		$data['code'] = asset_transfer($asset_transfer_header,$is_manager);
		$data['add_js'] = 'js/site_list_forms.js';
        $data['load_js'] = "core/assetJS.php";
        $data['use_js'] = "transAssetJS";
		$this->load->view('load',$data);
	
	}
	public function asset_transfer_out($id=null){
		$user = $this->session->userdata('user');
		$data = $this->syter->spawn('po_entry');
		$data['page_title'] = fa('fa-share')." Transfer Out";
		$res = $this->asset_model->get_asset_transfer_header($id);
		$sub_items = $this->asset_model->get_asset_trans_details($id);
		$results = $this->asset_model->get_check_temp_out($user['id']);

		$items = $res[0];
		
		$data['code'] = asset_transfer_out_form($id,$items,$sub_items,$results);
		$data['load_js'] = 'core/assetJS.php';
        $data['use_js'] = 'transAssetOutJS';
		$this->load->view('page',$data);
	}
	public function load_transfer_items(){
		$items = array();
		$ref = $this->input->post('ref');
		$transid = $this->input->post('transid');
		
		$results = $this->asset_model->get_check_temp_out($ref,$transid);
		
		if ($results) {
			$items = $results;
		}
		
		$data['code'] = build_list_form($items);
		$data['load_js'] = "core/assetJS.php";
		$data['use_js'] = "transAssetOutReloadJS";
		$this->load->view('load',$data);
	}
	public function asset_transfer_in($id=null){
		$user = $this->session->userdata('user');
		$data = $this->syter->spawn('po_entry');
		$data['page_title'] = fa('fa-reply')." Transfer In";
		$res = $this->asset_model->get_asset_transfer_header($id);
		$sub_items = $this->asset_model->get_asset_trans_details($id);
		$results = $this->asset_model->get_check_temp_out($user['id']);

		$items = $res[0];
		$details_temp = $this->asset_model->get_check_temp_in($user['id'],$id);
		$data['code'] = asset_transfer_in_form($id, $items, $sub_items, $results,$details_temp);
		$data['load_js'] = 'core/assetJS.php';
        $data['use_js'] = 'transAssetInJS';
		$this->load->view('page',$data);
	}
	public function load_transfer_items_in(){
		$items = array();
		$ref = $this->input->post('ref');
		$hidden_trans_id = $this->input->post('hidden_trans_id');
		
		$results = $this->asset_model->get_check_temp_in($ref,$hidden_trans_id);
		
		if ($results) {
			$items = $results;
		}
		
		$data['code'] = build_list_form($items);
		$data['load_js'] = "core/assetJS.php";
		$data['use_js'] = "transAssetInReloadJS";
		$this->load->view('load',$data);
	}
	public function check_details_temp(){
		$user = $this->session->userdata('user');
		$asset_no = $this->input->post('asset_no');
		$trans_id = $this->input->post('trans_id');
		$id = $this->asset_model->check_details_temp($trans_id, $asset_no, $user['id']);
		if($id)
			echo "Asset has been enter.";
	}
	public function del_transfer_temp(){
		$user = $this->session->userdata('user');
		$asset_no = $this->input->post('asset_no');
		$trans_id = $this->input->post('trans_id');
		$this->asset_model->del_transfer_temp($trans_id, $user['id']);
		
			echo "Asset has been cancelled.";
	}
	public function get_asset_no_id_out(){
		
		$user = $this->session->userdata('user');
		$asset_no = $this->input->post('asset_no');
		$trans_id = $this->input->post('trans_id');
		//echo $asset_no.'dddd'.$trans_id;
		$id = $this->asset_model->get_asset_no_id($asset_no);
		$res = $this->asset_model->check_asset_id_out($trans_id, $id);
				
			if($res){ //kung nasa asset transfer out 
				
				$check_if_in_temp = $this->asset_model->check_details_temp($trans_id, $asset_no, $user['id']);
					if($check_if_in_temp == 'no_data'){
						$items = array(
								"type"=>$res->asset_type,
								"asset_transfer_id"=>$trans_id,
								"asset_no"=>$asset_no,
								"description"=>$res->description,
								"in"=>0,
								"out"=>1,
								"user_id"=>$user['id']
							);
						$this->asset_model->write_to_checking_temp($items);

						echo 1; // means true
					}else{
						echo 0; // 0 means false
					}
					
				}else{ // kung wala
					echo 0; // 0 means false
				}


	}
	public function get_asset_no_id_in(){

		$user = $this->session->userdata('user');
		$asset_no = $this->input->post('asset_no');
		$trans_id = $this->input->post('trans_id');
		$id = $this->asset_model->get_asset_no_id($asset_no);
		$res = $this->asset_model->check_asset_id_in($trans_id, $id);
		if($res){

				$check_if_in_temp = $this->asset_model->check_details_temp($trans_id, $asset_no, $user['id']);
						if($check_if_in_temp == 'no_data'){
				$items = array(
						"type"=>$res->asset_type,
						"asset_transfer_id"=>$trans_id,
						"asset_no"=>$asset_no,
						"description"=>$res->description,
						"in"=>1,
						"out"=>0,
						"user_id"=>$user['id']
					);
				$this->asset_model->write_to_checking_temp($items);
					echo 1;
			}else{
				echo 0;
			}
		}else{
			echo 0;
		}

	}
	public function process_out(){
		$user = $this->session->userdata('user');
		$w_id = $this->input->post('id');
		$trans_id = $this->input->post('trans_id');
		$branch_code = $this->input->post('branch_code');
		$dept_code = $this->input->post('dept_code');
		$unit_code = $this->input->post('unit_code');
		$result = $this->asset_model->process_check_temp_out($trans_id, $user['id']);
		//$this->asset_transfer_out_print($trans_id);			
		//echo var_dump($result);
			foreach($result as $val){
				$res = $this->asset_model->get_asset_no_id_details($val->asset_no);
			//	echo $res;
				$items = array(
					"asset_id"=>$res->id,
					"asset_no"=>$res->asset_no,
					"branch_code"=>$branch_code,
					"asset_type"=>$res->asset_type,
					"division_code"=>$res->division_code,
					"department_code"=>$dept_code,
					"unit"=>'000',
					"note"=>'',
					"description"=>$res->item_description,
					"user_id"=>$user['id'],
					"type"=>'OUT'
					
				);
				//echo var_dump($items);
				$this->asset_model->insert_asset_history($items);
				$this->asset_model->del_check_temp($trans_id, $res->asset_no, $user['id']);
				$out = array(
					"out"=>1,
					"date_out"=>date('Y-m-d')
				);
				$this->asset_model->upd_status($trans_id, $res->id, $out);			
			}
				$cnt_trans_det = $this->asset_model->count_asset_transfer_details($trans_id);
				$cnt = $this->asset_model->get_asset_transfer_details_with_out($trans_id);
				$id = $this->asset_model->get_trans_id($trans_id);
				
				if($cnt  == $cnt_trans_det){
					$header = array(
					"status"=>2,
					"delivered_by"=>$user['id'],
					"witnessed_by"=>$w_id,
					"date_delivered"=>date('Y-m-d')
					);
					$this->asset_model->upd_transfer_status($trans_id, $header);			
					
					echo "All Asset has been transfer.";
				}else{
					$id = $id + 1;
					$header = array(
					"out_trans_id" => $id
					);
					$this->asset_model->upd_transfer_status($trans_id, $header);			
					echo "Asset has been transfer.";
				}		
				
	}
	public function process_in(){
		$user = $this->session->userdata('user');
		$trans_id = $this->input->post('trans_id');
		$branch_code = $this->input->post('branch_code');
		$dept_code = $this->input->post('dept_code');
		$unit_code = $this->input->post('unit_code');
		$result = $this->asset_model->process_check_temp_in($trans_id, $user['id']);
		//echo var_dump($result);
			 foreach($result as $val){
				$res = $this->asset_model->get_asset_no_id_details($val->asset_no);
			//	echo $res;
				$items = array(
					"asset_id"=>$res->id,
					"asset_no"=>$res->asset_no,
					"branch_code"=>$branch_code,
					"asset_type"=>$res->asset_type,
					"division_code"=>$res->division_code,
					"department_code"=>$dept_code,
					"unit"=>'000',
					"note"=>'',
					"description"=>$res->item_description,
					"user_id"=>$user['id'],
					"type"=>'IN'
					
				);
				//echo var_dump($items);
				$date_in = date('Y-m-d');
				//$this->asset_model->insert_asset_history($items);
				$this->asset_model->del_check_temp($trans_id, $res->asset_no, $user['id']);
				$in = array(
					"in"=>1,
					"date_in"=>date2sql($date_in)
				);
				$this->asset_model->upd_status($trans_id, $res->id, $in);			
			}
				$cnt_trans_det = $this->asset_model->count_asset_transfer_details($trans_id);
				$cnt = $this->asset_model->get_asset_transfer_details_with_in($trans_id);
				if($cnt  == $cnt_trans_det){
					$header = array(
					"status"=>3,
					"date_received"=>date('Y-m-d'),					
					"received_by"=>$user['id']
					);
					$this->asset_model->upd_transfer_status($trans_id, $header);			
					echo "All Asset has been transfer.";
				}else{
					echo "Asset has been transfer.";
				
				}		 
	}
	
	function insert_repair_asset_capitalizable(){
	

		
		$user = $this->session->userdata('user');
		$asset_id = $this->input->post('asset_id');
		$asset_no = $this->asset_model->get_asset_no_db($asset_id);
		$type = $this->input->post('type');
		$remarks = $this->input->post('remarks');
		$new_repair_cost = $this->input->post('amount');
		$repair_life_years = $this->input->post('life_years');
		
		$row = $this->asset_model->get_asset_acquisition_life($asset_id);
		$acquisition_cost = $row->acquisition_cost;
		$old_life_span = $row->life_span ;
		
		
		$get_last_history = $this->asset_model->get_last_branch_history($asset_id);
		$get_last_branch_history = $get_last_history->branch_code;
		$get_last_department_history = $get_last_history->department_code;
		
		
		
		$branch_ = $asset_ = $division_ = $department_ = $unit_ = $unit_pad	 = '';
		list($branch_,$asset_,$division_,$department_,$unit_,$unit_pad) = explode(' ',$asset_no);
		
		//echo $acquisition_cost.' '.$old_life_span;
		$date_now = date('Y-m-d', strtotime("-1 months", strtotime(date('01-m-Y'))));
		//echo $asset_id;
	
		$other_repairs = $this->asset_model->get_asset_c_repair($asset_id);
		$other_repairs_life = $this->asset_model->get_asset_repair_life($asset_id);
		$get_total_depre_amount = $this->asset_model->get_total_depre_amount($date_now,$asset_id);
		$count_depre_months = $this->asset_model->get_count_depre_months($date_now,$asset_id);
	
		$total_amt = $acquisition_cost + $other_repairs + $new_repair_cost;
		$total_years = (($old_life_span + $other_repairs_life + $repair_life_years)*12);
		
		$remaining_amount = (($acquisition_cost + $other_repairs) - $get_total_depre_amount);
		
		$new_depre_amount = $remaining_amount + $new_repair_cost;
		$new_depre_months = ($count_depre_months + ($repair_life_years*12)) ;
		//echo $total_years.'</br>'.$new_depre_months;
		$new_monthly_depre = $new_depre_amount/$new_depre_months;
		
		 $aria_db = $this->asset_model->get_aria_db($get_last_branch_history);
		
		 $delete_old_dep = $this->asset_model->delete_remaining_months($asset_id,$date_now);
		 $delete_old_gl_dep = $this->asset_model->delete_remaining_gl_months($asset_id,$date_now,$aria_db);
		
		
		//echo $other_repairs_life;
	//	echo $new_depre_amount.'-<-'.$new_depre_months.'---->'.$new_monthly_depre.'--->'.$other_repairs_life;
		
		$current_date = $date_now = date('Y-m-d', strtotime(date('01-m-Y')));
		
		for($j=1; $j <= $new_depre_months; $j++){
			
			if($j != $new_depre_months){
				
				$depreciation_details = array(
					'asset_id'=> $asset_id,		
					'branch_code'=> $get_last_branch_history,
					'_date'=>$current_date,
					'amount'=>$new_monthly_depre,
					'with_gl'=> '0'
				);
		
					$this->asset_model->insert_depreciation_details($depreciation_details);
					//temporarily comment gl transaction 
					//$this->add_gl_trans(64, $asset_id, $current_date, 'Accumulated Depreciation', 0, 0, null, $new_monthly_depre, null, 0 , null, null, null , $aria_db);
					//$this->add_gl_trans(64, $asset_id, $current_date, 'Depreciation Expense', 0, 0, null, -$new_monthly_depre, null, 0, null, null, null , $aria_db );
			
			}else{
			
				$new_monthly_depre_ = $new_monthly_depre;
				$depreciation_details = array(
					'asset_id'=> $asset_id,		
					'branch_code'=> $get_last_branch_history,
					'_date'=>$current_date,
					'amount'=>$new_monthly_depre_,
					'with_gl'=> '0'
				);
		
					$this->asset_model->insert_depreciation_details($depreciation_details);
					//temporarily comment gl transaction 
					//$this->add_gl_trans(64, $asset_id, $current_date, 'Accumulated Depreciation', 0, 0, null, $new_monthly_depre_, null, 0 , null, null, null , $aria_db);
					//$this->add_gl_trans(64, $asset_id, $current_date, 'Depreciation Expense', 0, 0, null, -$new_monthly_depre_, null, 0, null, null, null , $aria_db );
			
			}
			
			$current_date = date('Y-m-d', strtotime("+1 months", strtotime($current_date)));
				
		 }
		
		
			$insert_repair_asset_details = array(
					'asset_id'=>$asset_id,				
					'asset_no'=>$asset_no,				
					'date_repaired'=>date('Y-m-d', strtotime(date('01-m-Y'))),
					'cost'=>$new_repair_cost,
					'additional_life'=>$repair_life_years,
					'remarks'=>$remarks,
					'type'=>$type
				);
				
				$this->asset_model->insert_repair_asset_details($insert_repair_asset_details);
		
			$insert_asset_history = array(
					'asset_id'=>$asset_id,				
					'asset_no'=>$asset_no,				
					'branch_code'=>$get_last_branch_history,
					'department_code'=>$get_last_department_history,	
					'type'=>'Repaired',				
					'user_id'=>$user['id']				
				);
				$this->asset_model->insert_asset_history($insert_asset_history);

		
	}
	
	function insert_repair_asset($asset_id = null){
			
		$user = $this->session->userdata('user');
		$asset_id = $this->input->post('asset_id');
		$asset_no = $this->asset_model->get_asset_no_db($asset_id);
		$type = $this->input->post('type');
		$remarks = $this->input->post('remarks');
		$amount = $this->input->post('amount');
		$life_years = $this->input->post('life_years');
					
		$insert_repair_asset_details = array(
				'asset_id'=>$asset_id,				
				'asset_no'=>$asset_no,				
				'date_repaired'=>'',
				'cost'=>$amount,
				'additional_life'=>'',
				'remarks'=>$remarks,
				'type'=>$type
			);
			
		$branch_ = $asset_ = $division_ = $department_ = $unit_ = $unit_pad	 = '';
		list($branch_,$asset_,$division_,$department_,$unit_,$unit_pad) = explode(' ',$asset_no);
			
		$insert_asset_history = array(
				'asset_id'=>$asset_id,				
				'asset_no'=>$asset_no,				
				'branch_code'=>$branch_,				
				'department_code'=>$department_,				
				'type'=>'Repaired',				
				'user_id'=>$user['id']				
			);
		$this->asset_model->insert_asset_history($insert_asset_history);
			
		$this->asset_model->insert_repair_asset_details($insert_repair_asset_details);
		
	}
	
	function repair_asset_form(){
		$items = array();
		$data = $this->syter->spawn('asset');
		$data['page_subtitle'] = "Asset Repair";
		$data['code'] = repair_asset_form();
		$data['add_js'] = 'js/site_list_forms.js';
        $data['load_js'] = "core/assetJS.php";
        $data['use_js'] = "assetRepairJS";
		$this->load->view('page',$data);
	}
	public function delete_asset(){
		$id = $this->input->post('id');
		
		$num = $this->asset_model->check_asset_in_history($id);
		if($num <= 1){
			$this->asset_model->del_asset($id);
			$this->asset_model->del_asset_history($id);
			echo 'success';
		}else{
			echo 'error';
		}
		
		//$this->asset_model->del_transfer_temp($trans_id, $user['id']);
	
	}
	public function confirmed_in(){
	
		$user = $this->session->userdata('user');
		$id = $this->input->post('id');
		$asset_id = $this->input->post('asset_id');
		$asset_no = $this->input->post('asset_no');
		$description = $this->input->post('description');
		$branch = $this->input->post('branch');
		$asset_type = $this->input->post('asset_type');
		$department_code = $this->input->post('to_department');

		$to_unit = $this->input->post('to_unit');
		$to_branch = $this->input->post('to_branch');
		$from_branch = $this->input->post('from_branch');
		$date_in = $this->input->post('date_in');
	
	/* commented  for aria entry	 
	//	echo $from_branch.'-> '.$to_branch.' ->'.$date_in;
		//$from_aria_db = $this->asset_model->get_aria_db($from_branch);
		//$to_aria_db = $this->asset_model->get_aria_db($to_branch);
	

	
		$res = $this->asset_model->get_transfer_dep_asset($date_in,$asset_id,$from_aria_db);
		

		foreach($res as $val){
	
			$depre_details = array(	
			"type"=>$val->type,
			"type_no"=>$val->type_no,
			"tran_date"=>$val->tran_date,
			"amount"=>$val->amount
			);
					
			$this->asset_model->insert_transfer_dep_details($depre_details,$to_aria_db);
		
		}
		
		//$this->asset_model->delete_transfered_dep_months($asset_id,$from_aria_db,$date_in);
	*/



		    $con_in_details = array(
				'asset_id'=>$asset_id,				
				'asset_no'=>$asset_no,				
				'department_code'=>$department_code,				
				'description'=>$description,				
				'branch_code'=>$branch,				
				'asset_type'=>$asset_type,				
				'unit'=>$to_unit,				
				'user_id'=>$user['id'],				
				'transfer_id'=>$id,				
				'type'=>'IN'				
			);

			$this->asset_model->insert_asset_history($con_in_details);

			$upd_current_asset_location = array(
				'c_branch_code'=>$to_branch,				
				'c_department_code'=>$department_code, 			
				'c_unit_code'=>$to_unit				
			);
			$this->asset_model->current_loc_upd_status($asset_id,$upd_current_asset_location);
			
			$upd_transfer_branch_code = array(
				'branch_code'=>$to_branch				
			);
			$this->asset_model->upd_transfer_branch_code($upd_transfer_branch_code,$asset_id,$date_in );
 	 	 
			$upd_details = array(
				'confirmed_in'=>'1',
				'confirmed_in_by'=>$user['id']
			);
			
			$this->asset_model->upd_status($id,$asset_id,$upd_details);
		
			echo 'success';	
		
		
    }
	

    public function insert_disposal_request(){

    	$user = $this->session->userdata('user');
		$asset_id = $this->input->post('asset_id');
		$asset_no = $this->asset_model->get_asset_no_db($asset_id);
		$disposal_date = date('Y-m-01', strtotime($this->input->post('disposal_date')));
		$remarks = $this->input->post('remarks');
		$user = $this->session->userdata('user');

    			$asset_disposal_details = array(
				'asset_id'=>$asset_id,				
				'asset_no'=>$asset_no,	
				'disposal_date'=>$disposal_date,	
				'remarks'=>$remarks,
				'requested_by'=>$user['id']	
			);
			
		$this->asset_model->insert_asset_disposal_details($asset_disposal_details);


    }


	public function process_asset_disposal(){





		$user = $this->session->userdata('user');
		$asset_id = $this->input->post('asset_id');
		$asset_no =$this->input->post('asset_no');
		$disposal_date = date('Y-m-01', strtotime($this->input->post('disposal_date')));
		$remarks = $this->input->post('remarks');


		
		//echo $asset_id."---".$get_asset_branch_c;
		


		$branch_ = $asset_ = $division_ = $department_ = $unit_ = $unit_pad	 = '';
		
		list($branch_,$asset_,$division_,$department_,$unit_,$unit_pad) = explode(' ',$asset_no);

		$branch_ = $this->asset_model->get_branch_c($asset_id);

		//echo $asset_id.'--'.$asset_no.'---'.$disposal_date.'--'.$remarks;


		
	
		/*$asset_disposal_details = array(
				'asset_id'=>$asset_id,				
				'asset_no'=>$asset_no,	
				'disposal_date'=>$disposal_date,	
				'remarks'=>$remarks	
			);
			*/
			
		//$this->asset_model->insert_asset_disposal_details($asset_disposal_details);
		


		// $get_total_depre_amount_disposal = $this->asset_model->get_total_depre_amount_for_disposal($disposal_date,$asset_id);
		// $total_acquisition = $row->acquisition_cost + $other_repairs;
		 //echo $total_acquisition.'---->'.$get_total_depre_amount_disposal;

		 //echo $asset_id;
		// echo  $salvage_value;
		 //echo  $get_total_remaining_disposal_amount + ;
		// $disposal_amt = $total_acquisition - $get_total_depre_amount_disposal;
		//echo $disposal_amt;

		
		 $other_repairs = $this->asset_model->get_asset_c_repair($asset_id);
		 $row = $this->asset_model->get_asset_acquisition_life($asset_id);
		 $aria_db = $this->asset_model->get_aria_db($branch_);
		 $get_total_remaining_disposal_amount = $this->asset_model->get_total_remaining_disposal_amount($disposal_date,$asset_id);
		 $salvage_value = $this->asset_model->get_salvage_value($asset_id);

		 $disposal_amt = $get_total_remaining_disposal_amount + $salvage_value;

		  if($disposal_amt < 1){
			 $disposal_amt = 1;
		  }
		
		$delete_old_dep = $this->asset_model->delete_remaining_months_for_disposal($asset_id,$disposal_date);
		$delete_old_gl_dep = $this->asset_model->delete_remaining_gl_months_for_disposal($asset_id,$disposal_date,$aria_db);
		
		$depreciation_details = array(
					'asset_id'=> $asset_id,		
					'branch_code'=> $branch_,
					'_date'=>$disposal_date,
					'amount'=>$disposal_amt,
					'with_gl'=> '0'
				);

		$gl_account = $this->asset_model->get_asset_gl_account($asset_);
		 
		 $debit = $gl_account->gl_debit;
		 $credit = $gl_account->gl_credit;
		
		$this->asset_model->insert_depreciation_details($depreciation_details);

		//temporarily comment gl transaction 
		//$this->add_gl_trans(64, $asset_id, $disposal_date,$debit, 0, 0, null, $disposal_amt, null, 0 , null, null, null , $aria_db);
		//$this->add_gl_trans(64, $asset_id, $disposal_date,$credit, 0, 0, null, -$disposal_amt, null, 0, null, null, null , $aria_db);
		
		 $disposed_asset_details = array(
				'asset_id'=>$asset_id,				
				'asset_no'=>$asset_no,				
				'department_code'=>$department_,				
				'branch_code'=>$branch_,							
				'user_id'=>$user['id'],				
				'type'=>'Disposed'				
			);
		
		$this->asset_model->insert_asset_history($disposed_asset_details);
		
		$upd_details = array(
				'disposed'=>'1'				
			);

		$upd_details_ = array(
				'is_disposed'=>'1'				
			);
			
		$this->asset_model->update_status_($asset_id,$upd_details_);


		$this->asset_model->update_status($asset_id,$upd_details);

		
	}





	
	function check_process_out(){
	
		$asset_no = $this->input->post('asset_no');
		$transfer_id = $this->input->post('transfer_id');
		
		$asset_id = $this->asset_model->get_asset_id($asset_no);
	
		 $check_process_out =  $this->asset_model->check_process_out_db($asset_id,$transfer_id);
		 
		 if($check_process_out != null ){
			echo $check_process_out;
			 
		 }else{
		 
		 }
	}

	public function translip(){
		
		$trans_id = $this->input->get('id');
		$user    = $this->session->userdata('user');
        $user_id = $user['id']; 
      //  $current_date = date("Y-m-d");
		$this->asset_model->update_reprint_tag($trans_id);
		$header = $this->asset_model->get_asset_trans_header($trans_id);
		

		$result = $this->asset_model->process_check_out($trans_id);
		
		echo "<table border='0'colspan='2'>";
			echo "<tr align='center'>";
			
				echo "<td colspan='2'>
						<font size='2'><b>San Roque Supermarket Retail Systems Inc.</b></font>
					  </td>";
			echo "</tr>";		
					  
			echo "<tr align='center'>";
				echo "<td colspan='2'>
					   <font size='1'>REG.TIN# 007-492-840-000</font>
					  </td>";
			echo "</tr>";	
			
			
			
			echo "<tr align='center'>";
				echo "<td colspan='2'></td>";
			echo "</tr>";
			
			echo "<tr align='center'>";
				echo "<td colspan='2'></td>";
			echo "</tr>";

			
			echo "<tr align='center'>";
				echo "<td colspan='2'></td>";
			echo "</tr>";	
			
			echo "<tr align='center'>";
				echo "<td colspan='2'></td>";
			echo "</tr>";
			
			echo "<tr align='center'>";
				echo "<td colspan='2'></td>";
			echo "</tr>";
			
			echo "<tr align='center'>";
				echo "<td colspan='2'><font size='2'>Asset Tranfer Slip</font></td>";
			echo "</tr>";
			
			echo "<tr align='center'>";
				echo "<td colspan='2'><font size='2'>Asset Tranfer # : ".$header->id."</font></td>";
			echo "</tr>";
			
			echo "<tr align='center'>";
				echo "<td colspan='2'></td>";
			echo "</tr>";
			
			echo "<tr align='center'>";
				echo "<td colspan='2'></td>";
			echo "</tr>";
			
			echo "<tr align='center'>";
				echo "<td colspan='2'></td>";
			echo "</tr>";
			
			echo "<tr align='center'>";
				echo "<td colspan='2'></td>";
			echo "</tr>";
			
			echo "<tr align='center'>";
				echo "<td colspan='2'></td>";
			echo "</tr>";
			
			echo "<tr align='center'>";
				echo "<td colspan='2'></td>";
			echo "</tr>";
			
			echo "<tr align='center'>";
				echo "<td colspan='2'></td>";
			echo "</tr>";
			
			echo "<tr align='left'>";
				echo "<td colspan='2'><font size='2'>Transfer Out Date :".date('Y-m-d',strtotime($header->date_delivered))."</font></td>";
			echo "</tr>";
			
			echo "<tr align='left'>";
				echo "<td colspan='2'><font size='2'>From : ".$this->asset_model->get_branch_desc($header->from_branch)."</font></td>";
			echo "</tr>";
			
			echo "<tr align='left'>";
				echo "<td colspan='2'><font size='2'>To : ".$this->asset_model->get_branch_desc($header->to_branch)."</font></td>";
			echo "</tr>";
			
			echo "<tr align='center'>";
				echo "<td colspan='2'>--------------------------------------------------</td>";
			echo "</tr>";
			
			echo "<tr align='left'>";
				echo "<td><font size='2'>Asset No.</font></td>";
				echo "<td align='right'><font size='2'>Description</td>";
			echo "</tr>";
			$qtycount = count($result);
			
			foreach($result as $res){
				
				echo "<tr align='left'>";
				echo "<td><font size='2'>".$this->asset_model->get_asset_no($res->asset_id)."</font></td>";
				echo "<td align='right'><font size='2'>".$res->description."</font></td>";
				echo "</tr>";
				
				echo "<tr align='center'>";
				echo "<td colspan='2'></td>";
				echo "</tr>";
				
				echo "<tr align='center'>";
				echo "<td colspan='2'></td>";
				echo "</tr>";
				
				echo "<tr align='center'>";
				echo "<td colspan='2'></td>";
				echo "</tr>";
				
				
			}
			echo "<tr align='center'>";
				echo "<td colspan='2'></td>";
			echo "</tr>";
			
			echo "<tr align='center'>";
				echo "<td colspan='2'></td>";
			echo "</tr>";	
				
			echo "<tr >";
				echo "<td colspan='2' align='right'><font size='2'>Total Quantity : ".$qtycount."</font></td>";
			echo "</tr>";
			
			echo "<tr align='center'>";
				echo "<td colspan='2'></td>";
			echo "</tr>";
			
			echo "<tr align='center'>";
				echo "<td colspan='2'></td>";
			echo "</tr>";
			
			echo "<tr align='center'>";
				echo "<td colspan='2'>--------------------------------------------------</td>";
			echo "</tr>";
				$assigned_by = $this->asset_model->get_asset_p_assigned($header->assigned_by);
			echo "<tr align='left'>";
				echo "<td colspan='2'><font size='2'>Requested by : ".$assigned_by->fname." ".$assigned_by->lname." </font></td>";
			echo "</tr>";
			
			echo "<tr align='left'>";
			echo "<td colspan='2'><font size='2'></br></font></td>";
			echo "</tr>";
			
			echo "<tr align='center'>";
				echo "<td colspan='2'></td>";
			echo "</tr>";
			
				$received_desc = '';
				$delivered_desc = '';
				$witnessed_desc = '';
				$manager_desc = '';
				$admin_desc = '';
				$manager = '';
				$admin = '';
				
				$delivered_by = $this->asset_model->get_asset_p_assigned($header->delivered_by);
				if($delivered_by){
					$delivered_desc = $delivered_by->fname." ".$delivered_by->lname;
				}
				$received_by = $this->asset_model->get_asset_p_assigned($header->received_by);
				if($received_by){
					$received_desc = $received_by->fname." ".$received_by->lname;
				}
				
				$witnessed_by = $this->asset_model->get_asset_p_assigned($header->witnessed_by);
				if($witnessed_by){				
					$witnessed_desc = $witnessed_by->fname." ".$witnessed_by->lname;
				}

				$manager = $this->asset_model->get_asset_p_assigned($header->approved_by_manager);
				if($manager){				
					$manager_desc = $manager->fname." ".$manager->lname;
				}

				$admin = $this->asset_model->get_asset_p_assigned($header->approved_by_admin);
				if($admin){				
					$admin_desc = $admin->fname." ".$admin->lname;
				}
			
			echo "<tr align='left'>";
			echo "<td colspan='2'><font size='2'>Dispatched by :_____________________________________</font></td>";
			echo "</tr>";
			echo "<tr align='center'>";
				echo "<td colspan='2'><font size='2'>".$delivered_desc."</font></td>";
			echo "</tr>";
			echo "</tr>";
			
			if($header->date_delivered){
				$date_delivered = date('Y-m-d',strtotime($header->date_delivered));
			}else{
				$date_delivered = '';
			}

			echo "<tr align='center'>";
				echo "<td colspan='2'><font size='2'>".$date_delivered."&nbsp;</font></td>";
			echo "</tr>";
			
			echo "<tr>";
			echo "<td colspan='2'><font size='2'>Witnessed by : _____________________________________</font></td>";
			echo "</tr>";

			echo "<tr align='center'>";
				echo "<td colspan='2'><font size='2'>".$witnessed_desc."</font></td>";
			echo "</tr>";
			
			echo "<tr align='center'>";
				echo "<td colspan='2'><font size='2'>".$date_delivered."&nbsp;</font></td>";
			echo "</tr>";


			echo "<tr align='left'>";
			echo "<td colspan='2'><font size='2'> Approved By : </br></font></td>";
			echo "</tr>";

			echo "<tr align='left'>";
			echo "<td colspan='2'><font size='2'></br></font></td>";
			echo "</tr>";

			echo "<tr>";
			echo "<td colspan='2'><font size='2'>(Manager) : _____________________________________</font></td>";
			echo "</tr>";

			echo "<tr align='center'>";
				echo "<td colspan='2'><font size='2'>".$manager_desc."</font></td>";
			echo "</tr>";
			
			echo "<tr align='center'>";
				echo "<td colspan='2'><font size='2'>".$date_delivered."&nbsp;</font></td>";
			echo "</tr>";

			echo "<tr align='left'>";
			echo "<td colspan='2'><font size='2'></br></font></td>";
			echo "</tr>";

			echo "<tr>";
			echo "<td colspan='2'><font size='2'>(Admin) : _____________________________________</font></td>";
			echo "</tr>";

			echo "<tr align='center'>";
				echo "<td colspan='2'><font size='2'>".$admin_desc."</font></td>";
			echo "</tr>";
			
			echo "<tr align='center'>";
				echo "<td colspan='2'><font size='2'>".$date_delivered."&nbsp;</font></td>";
			echo "</tr>";




			echo "<tr align='left'>";
			echo "<td colspan='2'><font size='2'></br></font></td>";
			echo "</tr>";



			echo "<tr align='left'>";
			echo "<td colspan='2'><font size='2'>Delivered by :_____________________________________</font></td>";
			echo "</tr>";

			echo "<tr align='left'>";
			echo "<td colspan='2'><font size='2'></br></font></td>";
			echo "</tr>";

			
			echo "<tr align='left'>";
			echo "<td colspan='2'><font size='2'>Received by :_____________________________________</font></td>";
			echo "</tr>";
			
			echo "<tr align='center'>";
				echo "<td colspan='2'><font size='2'>".$received_desc."</font></td>";
			echo "</tr>";
			


			if($header->date_received){
				$date_received = date('Y-m-d',strtotime($header->date_received));
			}else{
				$date_received = '';
			}
			
			echo "<tr align='center'>";
				echo "<td colspan='2'><font size='2'>".$date_received."&nbsp;</font></td>";
			echo "</tr>";
			
				  
		echo "</table>";
		
		
		
		// date_default_timezone_set('Asia/Manila');
		// $this->load->library('My_TCPDF');
		// $CI =& get_instance();
		
		// $trans_id = $this->input->get('id');
		// $user    = $this->session->userdata('user');
        // $user_id = $user['id']; 
        // $current_date = date("Y-m-d");
		// $header = $this->asset_model->get_asset_trans_header($trans_id);
		
		// $pdf = new TCPDF("P", PDF_UNIT, 'Folio', false, 'UTF-8', false);
		// $filename = "Transfer Slip.pdf";
		// $title = "Sales Reports";
		
		// $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		// $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		// $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		// $pdf->SetFooterMargin(PDF_MARGIN_BOTTOM);
		// $pdf->setPrintHeader(false);
		// $pdf->setPrintFooter(true);
		
		// //$results = $this->customer_model->get_reactivated_customers($datefrom, $dateto, $category, $barangay, $reference);
		
		// $no = 0;
		// $total = 0;
		// $pdf->AddPage();
		
		// $pdf->SetFont('helvetica', '', 15);
		// $result = $this->asset_model->process_check_out($trans_id);
			// //$c = var_dump($result);
		// $content = "<table width=\"100%\" cellpadding=\"2px\" border=\"1px\">";
		// $content .="<tbody>";
		// $content .="<tr><td style=\"font-size:12px;\">ASSET TRANSFER NO:".$header->id." </td><td></td></tr>";
		// $content .="<tr>
		// <td style=\"font-size:12px;\">FROM : ".$this->asset_model->get_branch_desc($header->from_branch)."</td>
		// <td style=\"font-size:12px;\">TO : ".$this->asset_model->get_branch_desc($header->to_branch)."</td>
		// </tr>";
	// //	$content .="<tr></tr>";
		// $content .="<tr><td style=\"text-align:left;font-size:12px;\">DATE : ".$current_date."</td></tr>";
		// $content .="<tr><td colspan=\"2\" style=\"text-align:center;font-size:12px;\">ASSET LIST</td></tr>";
		// $content .="<tr>
					// <td style=\"text-align:center; font-size:12px;\">ASSET NO</td>
					// <td style=\"text-align:center; font-size:12px;\">DESCRIPTION</td>
					// </tr>";
		 // foreach($result as $res){
			// // $content .= "<tr>
			// //	 <td style=\"text-align:Left; font-size:12px;\">".$res->asset_id."</td>
			// // </tr>";
			 
			 // $content .="<tr>
					// <td style=\"text-align:center; font-size:12px;\">".$this->asset_model->get_asset_no($res->asset_id)."</td>
					// <td style=\"text-align:center; font-size:12px;\">".$res->description."</td>
					// </tr>";
			 
			// // $no+=1;
			// // $total = $total + $res->grandtotal;
		 // }
			// $content .= "</tbody></table>";
			// // $content .="<tr>
				// // <th style=\"text-align:center; font-size:12px;\"></th>
				// // <th style=\"text-align:center; font-size:12px;\"></th>
				// // <th style=\"text-align:center; font-size:12px;\"></th>
				// // <th style=\"text-align:center; font-size:12px;\"></th>
				// // <th style=\"text-align:center; font-size:12px;\"></th>
				// // <th style=\"text-align:center; font-size:12px;\"></th>
				// // <th style=\"text-align:center; font-size:12px;\"></th>
				// // <th style=\"text-align:center; font-size:12px;\"></th>
				// // <th style=\"text-align:center; font-size:12px;\"><b># of Customers</b></th>
				// // <th style=\"text-align:center; font-size:12px;\"><b>".$no."</b></th>
				// // <th style=\"text-align:center; font-size:12px;\"><b></b></th>
				// // <th style=\"text-align:center; font-size:12px;\"><b>Total</b></th>
				// // <th style=\"text-align:center; font-size:12px;\"><b>".$total."</b></th>
				// // <th style=\"text-align:center; font-size:12px;\"></th>
			// // </tr>";
		
		// $pdf->writeHTML($content,true,false,false,false,'');
		
		// $pdf->Output($filename, 'I');
		
	}
	

		
	function check_temp_data(){
		$trans_id = $this->input->post('trans_id');
		$details = $this->asset_model->get_asset_transferout_details($trans_id);
		$asset_temp = $this->asset_model->get_asset_temp($trans_id);
		$R = count($details);
		$Ra = count($asset_temp);
		echo $R.'~'.$Ra;
	}
	
	public function check_users(){
		
		$user = $this->input->post('user');
		$pass = $this->input->post('pass');

		$main_user_details = $this->asset_model->get_user_details('',$user,$pass);
		 if(!$main_user_details){
				//echo var_dump($main_user_details);
				$orange_user_details = $this->asset_model->get_orange_users($user,md5($pass));	
				if($orange_user_details){
					foreach($orange_user_details as $val){
						$new_users_details = array(
							"username"=>$val->user_name,
							"password"=>$val->user_password,
							"fname"=>$val->first_name,
							"lname"=>$val->last_name,
							"emp_number"=>$val->emp_number,
							"role"=>4,
							"department_id"=>$val->department_id,
							"sub_department_id"=>$val->sub_department_id
						);	
					}				
					$this->asset_model->insert_orange_users($new_users_details);	
					
					$main_user_details = $this->asset_model->get_user_details($user,$pass);
			
						if($main_user_details){
							echo $main_user_details->id;
						}else{
							echo 'error';
						}
				}else{
					echo 'error';
				}
		 }else{
			echo $main_user_details->id;
		 }
		
		// if(!$checkuser){
						
			// foreach($check_new_user as $val){
				// $new_users_details = array(
					// "username"=>$val->user_name,
					// "password"=>$val->user_password,
					// "fname"=>$val->first_name,
					// "lname"=>$val->last_name,
					// "emp_number"=>$val->emp_number,
					// "role"=>4,
					// "department_id"=>$val->department_id
					// "sub_department_id"=>$val->sub_department_id
				// );	
			// }				
				// $this->site_model->insert_orange_users($new_users_details);				
		// }
		
	}
	public function oic_access($trans_id=null,$branch_code=null,$dept_code=null,$unit_code=null){
		$data['code'] = build_resigned_date_popup_form($trans_id,$branch_code,$dept_code,$unit_code);
		$data['add_js'] = 'js/site_list_forms.js';
		$data['load_js'] = "core/assetJS.php";
		$data['use_js'] = "PopJS";
		$this->load->view('load',$data);
	}
	
	function asset_transfer_out2($id){
		$user = $this->session->userdata('user');
		$header = $this->asset_model->get_asset_trans_header($id);
		$details = $this->asset_model->get_asset_transferout_details($id);
		$user    = $this->session->userdata('user');
        $user_id = $user['id']; 
		$details_temp = $this->asset_model->get_check_temp_out($user_id,$id);
		$data = $this->syter->spawn('asset');
		$data['page_subtitle'] = "Transfer Out";
		$data['code'] = asset_out_form($header,$details,$id,$details_temp);
		$data['add_js'] = 'js/site_list_forms.js';
        $data['load_js'] = "core/assetJS.php";
        $data['use_js'] = "AssetOutJS";
		$this->load->view('page',$data);
	}
	 private function align_center($string=NULL, $count=NULL, $char=null){
    		$spacessss = '';
        $rep_count = $count - strlen($string);
 		$space = ($count /2) - (strlen($string) / 2);
        for ($i=0; $i <=$space; $i++) {
           $spacessss = $spacessss.$char;
        }
        return $spacessss.$string.$spacessss;
    }
	  private function align_right($string=NULL, $count=NULL, $char=null){
    	$spacessss = '';
        $rep_count = $count - strlen($string);
 		//$space = ($count /2) - (strlen($string) / 2);
        if($rep_count){
	        for ($i=0; $i <=$rep_count; $i++) {
	           $spacessss = $spacessss.$char;
	        }
	        return $spacessss.$string;
		}else{
	        return substr($string,0,38).'...'; //$string.$spacessss
		}
    }
    private function align_left($string=NULL, $count=NULL, $char=null)
    {
    		$spacessss = '';
        $rep_count = $count - strlen($string);
 		//$space = ($count /2) - (strlen($string) / 2);
 		if($rep_count){
	        for ($i=0; $i <=$rep_count; $i++) {
	           $spacessss = $spacessss.$char;
	        }
	        return $string.$spacessss;
		}else{
	        return substr($string,0,38).'...'; //$string.$spacessss
		}
    }
	
	
	public function asset_transfer_out_print($trans_id = null){
		$root = dirname(BASEPATH);
        $filename = "Asset.txt";
		$fp = fopen(realpath($root."/".$filename),'w');
		
	    $user    = $this->session->userdata('user');
        $user_id = $user['id']; 
        $current_date = date("Y-m-d");
		$header = $this->asset_model->get_asset_trans_header($trans_id);
		
        $print_str = $this->align_left('Asset Order No.: '.$header->id,60," ")."\r\n";
        $print_str .= $this->align_left('Asset Transfer No.:'.$header->out_trans_id,60," ")."\r\n\r\n";
        $print_str .= "=============================================="."\r\n\r\n";  
        $print_str .= $this->align_left('From: '.$this->asset_model->get_branch_desc($header->from_branch),60," ")."\r\n";
        $print_str .= $this->align_left('To: '.$this->asset_model->get_branch_desc($header->to_branch),60," ")."\r\n";
        $print_str .= $this->align_left('Date: '.$current_date,60," ")."\r\n\r\n";
        $print_str .= "=============================================="."\r\n\r\n";  
        $print_str .= $this->align_center('Asset List',40," ")."\r\n\r\n";
		$print_str .= $this->align_left('Asset #			Description',35," ")."\r\n\r\n";
		$result = $this->asset_model->process_check_temp_out($trans_id, $user['id']);
		foreach($result as $val){
			$print_str .= $this->align_center($val->asset_no.'	'.$val->description,30," ")."\r\n";
		}
        $fp = fopen($filename, "w+");
        fwrite($fp,$print_str);
        fclose($fp);

        $batfile = "print.bat";
        $fh1 = fopen($batfile,'w+');
       // $root = dirname(BASEPATH);

        fwrite($fh1, "NOTEPAD /P \"".realpath($root."/".$filename)."\"");
        fclose($fh1);
		//echo 'success';
        session_write_close();
        exec($batfile);
       // exec($filename);
        session_start();
        
	}
	
//Controllers - END
}
?>