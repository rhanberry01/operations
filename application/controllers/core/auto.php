<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

ini_set('mssql.connect_timeout',0);
ini_set('mssql.timeout',0);
ini_set('memory_limit', '-1');
ini_set('mssql.max_execution_time',0);
set_time_limit(0);

class Auto extends CI_Controller {

	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('core/operation_model','operation');
		$this->load->model('core/asset_model','asset');
		$this->load->helper('core/operation_helper');
		$this->load->library('My_excel_reader');
		$this->load->model("Auto_model");
		
		$user    = $this->session->userdata('user');
        $user_branch = $user['branch'];
        $this->bdb = $this->load->database($user_branch,TRUE);
		if(empty($this->bdb->conn_id)){
			
			$this->db->reconnect();
			show_error();
		}
	}

	public function start_process()
	{
		echo "Test Auto";
		echo 'auto start'.PHP_EOL;
		$data = $this->Auto_model->sample();
		echo $data;
    }


}

?>