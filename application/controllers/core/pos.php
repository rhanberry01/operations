<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pos extends CI_Controller {
	var $data = null;
	public function __construct()
	{
		parent::__construct();
		$this->load->model('site/site_model');
		$this->load->model('core/pos_model');
		$this->load->helper('core/pos_helper');
		date_default_timezone_set('Asia/Manila');
	}
	public function zread_controller(){
		$data = $this->syter->spawn('posted_receiving');
		$data['page_title'] = fa('fa-desktop')." Z-Read Controller";
		
		$details = array();
		// $current_date = date('Y-m-d');
		$current_date = date('Y-m-d', strtotime('2015-09-01'));
		// echo "Date Today : ".$current_date."<br>";
		$details = $this->pos_model->daily_zread($current_date);
		
		$data['code'] = build_zread_controller_header_form($details);
		$data['load_js'] = 'core/pos.php';
        $data['use_js'] = 'zreadControllerJs';
		$this->load->view('page',$data);
	}
	public function sync_to_stock_moves_branch(){
		$checker = 0;
		$result = array();
		// $current_date = date('Y-m-d');
		$current_date = date('Y-m-d', strtotime('2015-09-01'));
		$checker = $this->pos_model->check_current_day_branch_zread_controller(BRANCH_ID, $current_date);	
		if($checker == 0){
			$result = $this->pos_model->sync_daily_sales_transactions();
			// echo $checker."<--";
			echo $result."||success||".$checker;
			// echo "||success||".$checker;
		}else{
			// echo $checker."-->";
			echo $result."||error||".$checker;
			// echo "||danger||".$checker;
		}
		// echo var_dump($result);
		
	}
}