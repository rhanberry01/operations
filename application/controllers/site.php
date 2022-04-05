<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Site extends CI_Controller {

	public function index(){

		$this->load->model('core/operation_model','operation');
		$this->load->model('core/asset_model','asset');
		$this->load->helper('core/operation_helper');
		$user = $this->session->userdata('user');
        	$user_id = $user['id']; 
        	$user_branch = $user['branch']; 
        	$aria_db = $this->asset->get_aria_db($user_branch);
        	$branch = $this->operation->get_aria_db($user_branch);
        	$branchdesc = $branch->description;
		$data = $this->syter->spawn('dashboard');
		//$this->load->helper('site/login_helper');
		$data['page_subtitle'] = "Dashboard : ".$branchdesc;
		//$data['code'] = dashboard();
		//
		$total4 = $this->operation->get_trans_no_count($aria_db);
		$trans = array();
		if($total4)
		{
			$trans = $total4;
		}
		$trans2 = "";
		foreach($trans as $t)
		{
			$trans2 .= "'".$t->trans_no."',";
		}
		$trans2 = rtrim($trans2,",");
		$total = $this->operation->get_count_neg($aria_db,$trans2);	
		$total2 = $this->operation->get_count_nodisp($user_branch);
		$total3 = $this->operation->get_count_cyc($user_branch);
		// LAWRENZE
		$pricematch_report = $this->operation->get_pricematch_report();
		// ./LAWRENZE

		$items2 = array();
		if($total2)
		{
			$items2 = $total2;
		}
			$date_format2 = 'l';
			$date_format = 'Y-m-d';
			$today = strtotime('now');
		 	$tod = gmdate($date_format, $today);

		 	$tomorrow = strtotime('+1 day', $today);
		   	$tom = gmdate($date_format2, $tomorrow);
		 	$dateArray = explode("-", $tod);
		  	$date = new DateTime();
		  	$date->setDate($dateArray[0], $dateArray[1], $dateArray[2]);
		  	$week = floor((date_format($date, 'j') - 1) / 7) + 1;  
		  
			$results = $this->operation->get_tomorrow($tom,$week);
			$items = array();	
			if ($results) {
				$items = $results;	
			}
		// LAWRENZE
		$data['code'] = dashboard($user_branch,$total,$items2,$total3,$branchdesc,$items, $pricematch_report);
		// ./LAWRENZE
		$data['load_js'] = "core/OperationJS.php";
		$data['use_js'] = "Dashboard";
		$this->load->view('page',$data);

	
		
	//	$data['load_js'] = "site/admin.php";
	//	$data['use_js'] = "dashboard";
	//	$this->load->view('page',$data);
	 }

	 
	public function error_db(){
		$data = $this->syter->spawn('dashboard');
		$this->load->helper('site/login_helper');
		$data['page_subtitle'] = "ERROR CONNECTION";

		
		$data['code'] = error_db();
		$data['load_js'] = "site/admin.php";
		$data['use_js'] = "dashboard";
		$this->load->view('page',$data);
	}
	 
	public function login(){
		$this->load->helper('site/login_helper');
		$data = $this->syter->spawn(null,false);
 
		$data['load_js'] = 'site/login';
		$data['use_js'] = 'loginJs';
		$this->load->view('login',$data);
	}
	public function go_login(){
		$this->load->model('site/site_model');
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$pin = $this->input->post('pin');
		$branch = $this->input->post('branch');
		
		
			
			$user = $this->site_model->get_user_details(null,$username,$password,$pin);
				
			if($user){
					$error_msg = null;
					$path = null;
					if(!isset($user->id)){
						$error_msg = "Error! Wrong login!";
					}
					else{
						$session_details['user'] = array(
							"id"=>$user->id,
							"fname"=>$user->fname,
							"lname"=>$user->lname,
							"mname"=>$user->mname,
							"suffix"=>$user->suffix,
							"full_name"=>$user->fname." ".$user->mname." ".$user->lname." ".$user->suffix,
							"role_id"=>$user->user_role_id,
							"role"=>$user->user_role,
							"access"=>$user->access,
							// "emp_number"=>$user->emp_number,
							// "department_id"=>$user->department_id,
							"branch"=>$branch
						);
						$this->session->set_userdata($session_details);
					}
					echo json_encode(array('error_msg'=>$error_msg));
				}else{

					$db_obj = $this->load->database($branch,TRUE);
					
					$connected = $db_obj->initialize();
					
					if($connected){
						$branch_check_new_user = $this->site_model->get_branch_users($branch, $username, $password);
						
						if($branch_check_new_user){
						
						$branch_checkuser = $this->site_model->get_user_details(null,$username,$password,$pin);
						
									
									if(!$branch_checkuser){
									
										foreach($branch_check_new_user as $val){
											$new_users_details = array(
												"username"=>$val->user_id,
												"password"=>$val->password,
												"fname"=>$val->real_name,
												"lname"=>'',
												"emp_number"=>'',
												"role"=>4,
												"department_id"=>10
											);	
										}				
											$this->site_model->insert_orange_users($new_users_details);				
									}
						
							}		
								
								$user = $this->site_model->get_user_details(null,$username,$password,$pin);
								$error_msg = null;
								$path = null;
								if(!isset($user->id)){
									$error_msg = "Error! Wrong login!";
								}
								else{
									$session_details['user'] = array(
										"id"=>$user->id,
										"fname"=>$user->fname,
										"lname"=>$user->lname,
										"mname"=>$user->mname,
										"suffix"=>$user->suffix,
										"full_name"=>$user->fname." ".$user->mname." ".$user->lname." ".$user->suffix,
										"role_id"=>$user->user_role_id,
										"role"=>$user->user_role,
										"access"=>$user->access,
										"emp_number"=>$user->emp_number,
										"department_id"=>$user->department_id,
										"branch"=>$branch
									);
									$this->session->set_userdata($session_details);
								}
								echo json_encode(array('error_msg'=>$error_msg));
									
	
						
						
					}else{
						
						echo json_encode(array('error_msg'=> 'Not Connected'));
					}
		
					
				} 

	}
	public function go_logout(){
		$this->session->sess_destroy();
		redirect(base_url()."login",'refresh');
	}
	public function site_alerts(){
		$site_alerts = array();
		$alerts = array();
		if($this->session->userdata('site_alerts')){
			$site_alerts = $this->session->userdata('site_alerts');
		}

		foreach ($site_alerts as $alert) {
			$alerts[] = $alert;
		}
		echo json_encode(array("alerts"=>$alerts));
	}
	public function clear_site_alerts(){
		if($this->session->userdata('site_alerts'))
			$this->session->unset_userdata('site_alerts');
	}
	public function get_load(){
		$load = sess('site_load');
		echo json_encode(array('load'=>$load));
	}
}
