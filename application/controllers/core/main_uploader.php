<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main_uploader extends CI_Controller {
	var $data = null;
	public function __construct()
	{
		parent::__construct();
		$this->load->model('core/main_uploader_model');
		$this->load->model('site/site_model');
		$this->load->helper('core/main_uploader_helper');
	}
	public function index()
	{
		$data = $this->syter->spawn('main_uploader');
		$data['page_subtitle'] = "Data Center Main Uploader";
		$data['code'] = data_center_main_uploader();
		$data['add_js'] = 'js/site_list_forms.js';
        $data['load_js'] = "core/setup.php";
        $data['use_js'] = "main_uploaderJs";
		$this->load->view('page',$data);
	}
	public function send_to_main_server(){
		$this->load->model('core/main_uploader_model');
		$db_obj = $this->load->database('central_db_default',TRUE);
		$connected = $db_obj->initialize();
		
		if($connected){
			//Sales Header	
			$latest_rows = $this->main_uploader_model->get_all_sales_header();
			$retrieved_data = $latest_rows->result();
			$cols = $latest_rows->list_fields();	
			$thisrows = array();
			if(count($retrieved_data) > 0){
				foreach($retrieved_data as $ret_data){
					$row = array();
					//$row = array();
					foreach($cols as $col){
						 if($col != 'id')
							//continue;
							$row[$col] = $ret_data->$col;
						
					}
					$row['id'] = $ret_data->id;
					$thisrows[] = $row;
				}
				$res = $this->main_uploader_model->add_to_main_sales_header($thisrows);			
			 }
				
			//Sales Details		
			$latest_rows = $this->main_uploader_model->get_all_sales_details();
			$retrieved_data = $latest_rows->result();
			$cols = $latest_rows->list_fields();	
			$thisrows = array();
			if(count($retrieved_data) > 0){
				foreach($retrieved_data as $ret_data){
					$row = array();
					//$row = array();
					foreach($cols as $col){
						 if($col != 'id')
						//	 continue;
						$row[$col] = $ret_data->$col;
						
					}
				    $row['id'] = $ret_data->id;
					$thisrows[] = $row;
				}
				$this->main_uploader_model->add_to_main_sales_details($thisrows);
				
			}
			 //Sales Payments		
			$latest_rows = $this->main_uploader_model->get_all_payment();
			$retrieved_data = $latest_rows->result();
			$cols = $latest_rows->list_fields();	
			$thisrows = array();
			if(count($retrieved_data) > 0){
				foreach($retrieved_data as $ret_data){
					$row = array();
					//$row = array();
					foreach($cols as $col){
						 if($col != 'id')
							// continue;
						$row[$col] = $ret_data->$col;
						
					}
				    $row['id'] = $ret_data->id;
					$thisrows[] = $row;
				}
				$this->main_uploader_model->add_to_main_payment($thisrows);
				
			}
			//Sales Payment Details 	
			$latest_rows = $this->main_uploader_model->get_all_payment_details();
			$retrieved_data = $latest_rows->result();
			$cols = $latest_rows->list_fields();	
			$thisrows = array();
			if(count($retrieved_data) > 0){
				foreach($retrieved_data as $ret_data){
					$row = array();
					//$row = array();
					foreach($cols as $col){
						 if($col != 'id')
						//	 continue;
						$row[$col] = $ret_data->$col;
						
					}
					$row['id'] = $ret_data->id;
					$thisrows[] = $row;
				}
				$this->main_uploader_model->add_to_main_payment_details($thisrows);
				
			}
			//Customer Card Transaction 		
			$latest_rows = $this->main_uploader_model->get_all_customer_card_transaction();
			$retrieved_data = $latest_rows->result();
			$cols = $latest_rows->list_fields();	
			$thisrows = array();
			if(count($retrieved_data) > 0){
				foreach($retrieved_data as $ret_data){
					$row = array();
					//$row = array();
					foreach($cols as $col){
						 if($col != 'id')
						//	 continue;
						 $row[$col] = $ret_data->$col;
						
					}
					 $row['id'] = $ret_data->id;
					$thisrows[] = $row;
				}
				$this->main_uploader_model->add_to_main_customer_card_transaction($thisrows);
				
			}
			//Customer Card Transaction(inactive)
			$row = $this->main_uploader_model->check_all_customer_card_transaction_not_in(); 
			foreach($row as $val){
				$card_no = $val->card_no;
				$cust_id  = $val->cust_id;
				$this->main_uploader_model->update_inactive_customer_card_no($card_no);
				$this->main_uploader_model->main_update_inactive_customer_card_no($card_no);
				$this->main_uploader_model->update_inactive_customer($cust_id);
				$this->main_uploader_model->main_update_inactive_customer($cust_id);
			}
			
			echo 'success'; 
		}
		else{
			echo 'no server connection'; 
		} 
	}
	
}