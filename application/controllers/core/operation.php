<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

ini_set('mssql.connect_timeout',0);
ini_set('mssql.timeout',0);
ini_set('memory_limit', '-1');
ini_set('mssql.max_execution_time',0);
set_time_limit(0);

class Operation extends CI_Controller {

	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('core/operation_model','operation');
		$this->load->model('core/asset_model','asset');
		$this->load->helper('core/operation_helper');
		//$this->load->library('My_excel_reader');
		$this->load->library('excel');
		//$this->load->model('Auto_model','auto');
		
		$user    = $this->session->userdata('user');
        $user_branch = $user['branch'];
        $this->bdb = $this->load->database($user_branch,TRUE);
		if(empty($this->bdb->conn_id)){
			
			$this->db->reconnect();
			//show_error();
		}
	}

	function index(){
		
	}

	function check_connection()
	{
		//$data = $this->Auto_model->sample();
		$rs = $this->operation->get_connection();
		echo json_encode(array('msg'=>$rs));
	}



	function recount(){

		$data = $this->syter->spawn('operation');
		$user    = $this->session->userdata('user');
        $user_id = $user['id']; 
        $user_branch = $user['branch']; 
        $aria_db = $this->operation->get_aria_db($user_branch);
		$data['page_subtitle'] = "Manual Count : ".$aria_db->description;
		$next_trans = $this->operation->get_next_trans($aria_db->aria_db);	
		$next_trans = $next_trans + 1;



		$results = $this->operation->r_get_cc($user_branch);	
		$items = array();
		if ($results) {
			$items = $results;		
		}
		
		$data['code'] = recount_form($items,$auto,$cat,$next_trans,$user_id);
		$data['load_js'] = "core/OperationJS.php";
		$data['use_js'] = "Recount";
		$this->load->view('page',$data);
		
	}


	public function user_form($id=null)
	{
        $data = $this->syter->spawn('control');
        $data['page_subtitle'] = "Users";
        $items = null;
        $receive_cart = array();

        if($id != null){
           	$details = $this->operation->get_users($id);
            $items = $details[0];
			
        }
        $data['code'] = user_form($items);
		
        $data['add_js'] = 'js/site_list_forms.js';
        $data['load_js'] = "core/OperationJS.php";
        $data['use_js'] = "usersJs";
        $this->load->view('page',$data);
    }

	 public function users($ref='')
    {
        $data = $this->syter->spawn('control');
        $data['page_subtitle'] = "Users";
        $user = $this->operation->get_users();
        $data['code'] = users_page($user);
        $this->load->view('page',$data);
        
    }

    public function user_details_db()
	{
		$user = $this->session->userdata('user');
		$status = "";
		$short_desc_exist="";
		  $items = array(
                "username"=>$this->input->post('uname'),
                "password"=>md5($this->input->post('password')),
                "fname"=>$this->input->post('fname'),
                "mname"=>$this->input->post('mname'),
                "lname"=>$this->input->post('lname'),
                "role"=>$this->input->post('role'),
                "suffix"=>$this->input->post('suffix'),
                "gender"=>$this->input->post('gender'),
                "email"=>$this->input->post('email'),
                
            );
		  $items_edit = array(
		  		"password"=>md5($this->input->post('password')),
                "fname"=>$this->input->post('fname'),
                "mname"=>$this->input->post('mname'),
                "lname"=>$this->input->post('lname'),
                "role"=>$this->input->post('role'),
                "suffix"=>$this->input->post('suffix'),
                "gender"=>$this->input->post('gender'),
                "email"=>$this->input->post('email'),
                "inactive"=>$this->input->post('inactive'),

            );
		
		// echo var_dump($items);
		$mode = $this->input->post('mode');
		//echo "Mode : ".$mode."<br>";
		
		if($mode == 'add'){
			$short_desc_exist = $this->operation->ename_exist_add_mode($this->input->post('fname'), $this->input->post('mname'), $this->input->post('lname'));
	
		}else if($mode == 'edit'){
			$short_desc_exist = $this->operation->ename_exist_edit_mode($this->input->post('fname'), $this->input->post('mname'), $this->input->post('lname'), $this->input->post('id'));
		}
		 //echo "Product Code exist : ".$abbrev_exist."<br>";
		
		if($short_desc_exist){
			$id = '';
			$msg = "WARNING : Name [ ".$this->input->post('fname').' '.$this->input->post('mname').' '.$this->input->post('lname')." ] already exists!";
			$status = "warning";
		}else{
			if ($this->input->post('id')) {
				$id = $this->input->post('id');
				$this->operation->update_users($items_edit,$id);
				$msg = 'Update User '.$this->input->post('fname').' '.$this->input->post('lname');
				$status = "success";
			}else{
				$id = $this->operation->add_users($items);
				 $msg = 'Added  new User '.$this->input->post('fname').' '.$this->input->post('lname');
				$status = "success";
			}
		}
		

		echo json_encode(array('status'=>$status, 'id'=>$id,'msg'=>$msg));
	}
	
	public function negative_inventory(){
		$user    = $this->session->userdata('user');
        $user_id = $user['id']; 
        $user_branch = $user['branch']; 
        $aria_db = $this->operation->get_aria_db($user_branch);
        $results = $this->operation->get_viewing_details();
		$next_trans = $this->operation->get_next_trans($aria_db->aria_db);
		
		$next_trans = $next_trans + 1;

		$data = $this->syter->spawn('operation');
		$data['page_subtitle'] = "NEGATIVE INVENTORY : ".$aria_db->description;
		$data['code'] = neg_item_list($next_trans); 
		$data['load_js'] = "core/OperationJS.php";
		$data['use_js'] = "NegativeInventory";
		$this->load->view('page',$data);
	}
	
	public function negative_inventory_excel(){
		$category = $this->input->get('category');
        $supplier = $this->input->get('supplier');
		$print_items = array(
        	'category' => $category,
            'supplier' => $supplier
        ); 
        $data['print_items'] = $print_items; 
       $this->load->view('contents/prints/negative_inventory_excel.php',$data);
	}

	public function adjustment_inquiry(){
		$user    = $this->session->userdata('user');
        $user_id = $user['id']; 
        $user_branch = $user['branch']; 
		$aria_db = $this->asset->get_aria_db($user_branch);
		$branch_name = $this->operation->get_branch_name($user_branch);
		$data = $this->syter->spawn('operation');
		$data['page_subtitle'] = "Adjustment Inquiry";
		$results = $this->operation->get_adjustment_inquiry($aria_db);
		$items = array();
		if ($results) {
			$items = $results;
			
		}
		$data['code'] = adjustment_inquiry($items,$branch_name);
		$data['load_js'] = "core/OperationJS.php";
		$data['use_js'] = "AdjustmentInquiry";
		$this->load->view('page',$data);
	}

	public function load_no_display(){
		$date = $this->input->post('date');	
		$category = $this->input->post('cat');			
		$user    = $this->session->userdata('user');
        $user_id = $user['id']; 
        $user_branch = $user['branch'];
		$results = $this->operation->get_no_display_search($user_branch,$date,$category);
		$items = array();
		if ($results) {
			$items = $results;
		}
		$data['code'] = no_display_result($items,$user_branch);
		$data['load_js'] = "core/OperationJS.php";
		$data['use_js'] = "NoDisplay";
		$this->load->view('load',$data);
	
	}



	public function print_posible_no_display($date=null){

		$user    = $this->session->userdata('user');
        $user_id = $user['id']; 
        $user_branch = $user['branch'];

		$details= array('date_' => $date,
						'branch' => $user_branch);

		$data['print_items'] = $details ; 

		$this->load->view('contents/prints/print_posible_no_display.php',$data); //full details

	}

	public function print_recount($date=null){

		$user    = $this->session->userdata('user');
        $user_id = $user['id']; 
        $user_branch = $user['branch'];

		$details= array('date_' => $date,
						'branch' => $user_branch);

		$data['print_items'] = $details ; 

		$this->load->view('contents/prints/print_recount.php',$data); //full details

	}

	//prrint variance report -Van
	public function print_variance_report($id=null){
		$user    = $this->session->userdata('user');
        	$user_id = $user['id']; 
        	$user_branch = $user['branch'];

		$details= array('branch' => $user_branch,
						'id' => $id);

		$data['print_items'] = $details ; 

		$this->load->view('contents/prints/print_variance_report.php',$data);

	}

	public function print_cc_auto($id=null){

		$user    = $this->session->userdata('user');
        $user_id = $user['id']; 
        $user_branch = $user['branch'];

		$details= array('branch' => $user_branch,
						'id' => $id);

		$data['print_items'] = $details ; 

		$this->load->view('contents/prints/print_cyclecount_auto.php',$data); //full details

	}

	public function print_asset_history($id=null){

	$data['asset_id'] = array('id' => $id); 


	$this->load->view('contents/prints/print_asset_history.php',$data); //full details

	}

	public function no_display(){
		$data = $this->syter->spawn('operation');
		$user    = $this->session->userdata('user');
        $user_id = $user['id']; 
        $user_branch = $user['branch']; 
		$aria_db = $this->operation->get_aria_db($user_branch);
		
		$data['page_subtitle'] = "NO DISPLAY : ".$aria_db->description;

		$user    = $this->session->userdata('user');
        $user_id = $user['id']; 
        $user_branch = $user['branch']; 
		$results = $this->operation->get_no_display($user_branch);
		$items = array();
		if ($results) {
			$items = $results;
			
		}
		$data['code'] = no_display($items,$user_branch);
		$data['load_js'] = "core/OperationJS.php";
		$data['use_js'] = "NoDisplay";
		$this->load->view('page',$data);
	}

	public function show_auto_cc(){
		//$data = $this->syter->spawn('operation');
		$user    = $this->session->userdata('user');
        $user_id = $user['id']; 
        $user_branch = $user['branch']; 
		$results = $this->operation->get_auto_cc();	
		$items = array();	
		if ($results) {
			$items = $results;	
		}
		$data['code'] = cycle_count_auto_reload($items);
		$data['load_js'] = "core/OperationJS.php";
		$data['use_js'] = "CycleCount";
		$this->load->view('load',$data);
	}

	public function certify()
	{
		$user    = $this->session->userdata('user');
        $user_id = $user['id']; 
        $user_branch = $user['branch']; 
		//$aria_db = $this->asset->get_aria_db($user_branch);
		$user = $this->input->post('user');
		$pass = $this->input->post('pass');

		$results = $this->operation->certify($user,$pass);

		echo json_encode(array('msg'=>$results));

	}
	
	public function show_cat(){
		//$data = $this->syter->spawn('operation');
		$user    = $this->session->userdata('user');
        $user_id = $user['id']; 
        $user_branch = $user['branch']; 


		$results = $this->operation->getcat();	
		$items = array();	
		if ($results) {
			$items = $results;	
		}
		$data['code'] = cc_category_reload($items);
		$data['load_js'] = "core/OperationJS.php";
		$data['use_js'] = "CycleCount";
		$this->load->view('load',$data);
	}

	public function show_cc(){
		//$data = $this->syter->spawn('operation');
		$user    = $this->session->userdata('user');
        $user_id = $user['id']; 
        $user_branch = $user['branch']; 
		$results = $this->operation->get_cc();	
		$items = array();	
		if ($results) {
			$items = $results;	
		}
		$data['code'] = cycle_count_reload($items);
		$data['load_js'] = "core/OperationJS.php";
		$data['use_js'] = "CycleCount";
		$this->load->view('load',$data);
	}

	public function r_show_cc(){
		//$data = $this->syter->spawn('operation');
		$user    = $this->session->userdata('user');
        $user_id = $user['id']; 
        $user_branch = $user['branch']; 
         $aria_db = $this->operation->get_aria_db($user_branch);
        $next_trans = $this->operation->get_next_trans($aria_db->aria_db);	
		$next_trans = $next_trans + 1;

		$results = $this->operation->r_get_cc();
		$items = array();	
		if ($results) {
			$items = $results;	
		}
		$data['code'] = recount_reload($items,$next_trans,$user_id);
		$data['load_js'] = "core/OperationJS.php";
		$data['use_js'] = "Recount";
		$this->load->view('load',$data,$next_trans);
	}


// 	function action($iid = NULL)
// 	 {



// 	   $objPHPExcel = new PHPExcel();
// 		$objPHPExcel->setActiveSheetIndex(0);

// 		$styleArray = array(
//    		 'font'  => array(
//         	'bold'  => true,
//         	'size'  => 15,
//        		 'name'  => 'Calibri'
//    		 ));

// 		$Bstyletable = array(
// 			'alignment' => array(
//             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
//         )
// 		);
		
// 		$BStyle = array(
// 		  'borders' => array(
// 		    'allborders' => array(
// 		      'style' => PHPExcel_Style_Border::BORDER_THIN
// 		    )
// 		  )
		 
// 		);
// 		$results2 = $this->operation->get_auto_info($iid);
// 		$items2=array();	
// 		if ($results2) {
// 			$items2 = $results2;		
// 		}
// 		$i = 1;   
// 			foreach($items2 as $info)
// 			{
// 				$Cn=$info->CategoryName;
// 				$sched = $info->Day. " - ".$info->Schedule;			
// 			}
// 			$objPHPExcel->getActiveSheet()->setCellValue('A1', "Category Name: ".$Cn);
// 			$objPHPExcel->getActiveSheet()->setCellValue('A2', "Auto Cycle Schedule: ".$sched);
// 				//$objPHPExcel->getActiveSheet()->setCellValue('C'.$i, "Generated: ".$items2->CategoryName);
// 			$i=3;
 			
//  					$objPHPExcel->getActiveSheet()->setCellValue('A'.$i, "Product ID");
//  					$objPHPExcel->getActiveSheet()->setCellValue('B'.$i, "Barcode");
//                     $objPHPExcel->getActiveSheet()->setCellValue('C'.$i, "Item");
//                     $objPHPExcel->getActiveSheet()->setCellValue('D'.$i, "UoM");
//                     $objPHPExcel->getActiveSheet()->setCellValue('E'.$i, "Cost");
//                     $objPHPExcel->getActiveSheet()->setCellValue('F'.$i, "Quantity Inventory");

                    
//                     $results = $this->operation->get_auto_details2($iid);
// 		$items=array();	
// 		if ($results) {
// 			$items = $results;		
// 		}



// 			$i=4;
// 			$ctr=3;
//                foreach($items as $cc){
                        
//                		 $objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $cc->ProductID);
//                     $objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $cc->Barcode);
              
//                     $objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $cc->Description);
//                     $objPHPExcel->getActiveSheet()->setCellValue('D'.$i, $cc->uom);
//                      $objPHPExcel->getActiveSheet()->setCellValue('E'.$i, $cc->CostOfSales);
//                       $objPHPExcel->getActiveSheet()->setCellValue('F'.$i, $cc->SellingArea);
//                       $ctr++;
//                   $i++;
//                 }

//                 $objPHPExcel->getActiveSheet()->freezePane('A4');
//                 $objPHPExcel->getActiveSheet()->getStyle('A3:F3')->getFont()->setBold( true );
//                 $objPHPExcel->getActiveSheet()->mergeCells('A1:F1');
//                 $objPHPExcel->getActiveSheet()->mergeCells('A2:F2');
//                 $objPHPExcel->getActiveSheet()->getStyle('B2:B'.$ctr)->getNumberFormat()->setFormatCode('#');
//                 $objPHPExcel->getActiveSheet()->getStyle('A3:F'.$ctr)->applyFromArray($Bstyletable);
//                 $objPHPExcel->getActiveSheet()->getStyle('A1:F'.$ctr)->applyFromArray($BStyle);
//                  $objPHPExcel->getActiveSheet()->getStyle('A1:A2')->applyFromArray($styleArray);
//                 $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
//                 $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
//                 $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(45);
//                 $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
//                 $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
//                 $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);

// 		$objPHPExcel->getActiveSheet()->setTitle("Auto Cycle - ".$Cn);
// 		$objPHPExcel->setActiveSheetIndex(0);

// 		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
// 		ob_end_clean();

//        	$objWriter->save("CycleCountAutoList.xlsx");           

// exit();


// 	 }


// 	 function r_action()
// 	 {

// //$this->load->library('excel');

// 	   $objPHPExcel = new PHPExcel();
// 		$objPHPExcel->setActiveSheetIndex(0);

// 		$styleArray = array(
//    		 'font'  => array(
//         	'bold'  => true,
//         	'size'  => 15,
//        		 'name'  => 'Calibri'
//    		 ));

// 		$Bstyletable = array(
// 			'alignment' => array(
//             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
//         )
// 		);
		
// 		$BStyle = array(
// 		  'borders' => array(
// 		    'allborders' => array(
// 		      'style' => PHPExcel_Style_Border::BORDER_THIN
// 		    )
// 		  )
		 
// 		);
// 		// $results2 = $this->operation->get_auto_info($iid);
// 		// $items2=array();	
// 		// if ($results2) {
// 		// 	$items2 = $results2;		
// 		// }
// 		$i = 1;   
			
 			
//  					$objPHPExcel->getActiveSheet()->setCellValue('A'.$i, "Product ID");
//  					$objPHPExcel->getActiveSheet()->setCellValue('B'.$i, "Barcode");
//                     $objPHPExcel->getActiveSheet()->setCellValue('C'.$i, "Item");
//                     $objPHPExcel->getActiveSheet()->setCellValue('D'.$i, "UoM");
//                     $objPHPExcel->getActiveSheet()->setCellValue('E'.$i, "Cost");
//                     $objPHPExcel->getActiveSheet()->setCellValue('F'.$i, "Quantity Inventory");

                    
//                     $results = $this->operation->r_get_auto_details2();
// 		$items=array();	
// 		if ($results) {
// 			$items = $results;		
// 		}



// 			$i=2;
// 			$ctr=1;
//                foreach($items as $cc){
                        
//                		 $objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $cc->ProductID);
//                     $objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $cc->Barcode);
              
//                     $objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $cc->Description);
//                     $objPHPExcel->getActiveSheet()->setCellValue('D'.$i, $cc->uom);
//                      $objPHPExcel->getActiveSheet()->setCellValue('E'.$i, $cc->CostOfSales);
//                       $objPHPExcel->getActiveSheet()->setCellValue('F'.$i, $cc->SellingArea);
//                       $ctr++;
//                   $i++;
//                 }

//                 $objPHPExcel->getActiveSheet()->freezePane('A2');
//                 $objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getFont()->setBold( true );
//                 $objPHPExcel->getActiveSheet()->getStyle('B2:B'.$ctr)->getNumberFormat()->setFormatCode('#');
//                 $objPHPExcel->getActiveSheet()->getStyle('A1:F'.$ctr)->applyFromArray($Bstyletable);
//                 $objPHPExcel->getActiveSheet()->getStyle('A1:F'.$ctr)->applyFromArray($BStyle);
//                  //$objPHPExcel->getActiveSheet()->getStyle('A1:A2')->applyFromArray($styleArray);
//                 $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
//                 $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
//                 $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(45);
//                 $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
//                 $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
//                 $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);

// 		$objPHPExcel->getActiveSheet()->setTitle("Recount - ");
// 		$objPHPExcel->setActiveSheetIndex(0);

// 		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
// 		ob_end_clean();

//        	$objWriter->save("ReCount.xlsx");           

// exit();


// 	 }

	public function addtocat()
	{
		$user    = $this->session->userdata('user');
        $user_id = $user['id']; 
        $user_branch = $user['branch']; 
		//$aria_db = $this->asset->get_aria_db($user_branch);
		$cat = $this->input->post('cat');

		$results = $this->operation->addto_cat($cat);

		echo json_encode(array('msg'=>$results));
	}

	public function checkauto($id = NULL)
	{
		$user    = $this->session->userdata('user');
        $user_id = $user['id']; 
        $user_branch = $user['branch']; 
		//$aria_db = $this->asset->get_aria_db($user_branch);
		//$cat = $this->input->post('cat');

		$results = $this->operation->checkauto($id);
		
		echo json_encode(array('msg'=>$results));
	}
	

	public function check_con()
	{
		$user    = $this->session->userdata('user');
        $user_id = $user['id']; 
        $user_branch = $user['branch']; 
        $results = $this->operation->get_connection();

        echo json_encode(array('msg'=>$results));
	}

	public function cycle_count(){
		$data = $this->syter->spawn('operation');
		$user    = $this->session->userdata('user');
        $user_id = $user['id']; 
        $user_branch = $user['branch']; 
        $aria_db = $this->operation->get_aria_db($user_branch);
		$data['page_subtitle'] = "CYCLE COUNT : ".$aria_db->description;

		$results3 = $this->operation->getcat();	
		$cat = array();
		if ($results3) 
		{
			$cat = $results3;		
		}

		$results = $this->operation->get_cc($user_branch);	
		$items = array();
		if ($results) {
			$items = $results;		
		}
		
		$results2 = $this->operation->get_auto_cc($user_branch);	
		$auto = array();
		if ($results2) {
			$auto = $results2;		
		}
		
		$data['code'] = cycle_count_form($items,$auto,$cat,$user_id);
		$data['load_js'] = "core/OperationJS.php";
		$data['use_js'] = "CycleCount";
		$this->load->view('page',$data);
	}

	//filter auto cc -Van
	public function filterAutoCC(){
		$from = $this->input->post('from');
		$to = $this->input->post('to');
		$status = $this->input->post('status');
		$result = $this->operation->filter_auto_cc($from,$to,$status);
		echo show_filtered_autocc($result);
		
	}

	public function savecat()
	{
		$user    = $this->session->userdata('user');
        $user_id = $user['id']; 
        $user_branch = $user['branch']; 
		//$aria_db = $this->asset->get_aria_db($user_branch);
		$cat = $this->input->post('cat');
		$days = $this->input->post('days');
		$weeks = $this->input->post('weeks');

		$results = $this->operation->save_cat($cat,$days,$weeks);

		echo json_encode(array('msg'=>$results));
	}

	public function upcat()
	{
		$user    = $this->session->userdata('user');
        $user_id = $user['id']; 
        $user_branch = $user['branch']; 
		//$aria_db = $this->asset->get_aria_db($user_branch);
		$id = $this->input->post('id');
		$cat = $this->input->post('cat');
		$days = $this->input->post('days');
		$weeks = $this->input->post('weeks');

		$results = $this->operation->up_cat($id,$cat,$days,$weeks);

		echo json_encode(array('msg'=>$results));
	}

	public function negative_inventory_reload(){
		$user    = $this->session->userdata('user');
        $user_id = $user['id']; 
        $user_branch = $user['branch']; 
		$aria_db = $this->asset->get_aria_db($user_branch);
		$category = $this->input->post('category');
		$supplier = $this->input->post('supplier');
		$results = $this->operation->get_sort_details($category,$supplier);
		$next_trans = $this->operation->get_next_trans($aria_db);
		$items = array();
		
		if ($results) {
			$items = $results;
			
		}

		$next_trans = $next_trans + 1;
		$data['code'] = negative_inventory_reload($items,$next_trans);
		$data['load_js'] = "core/OperationJS.php";
		$data['use_js'] = "operationsunit";
		$this->load->view('load',$data);
	}
	
	public function add_auto()
	{
		//echo 'auto start'.PHP_EOL;
		$user    = $this->session->userdata('user');
        $user_id = $user['id']; 
        $user_branch = $user['branch']; 

		$results = $this->operation->get_maxautoid_cc();
		$maxid=$results;

		if($maxid == NULL)
		{
			$maxid = 1;
		}
		else
		{
			$maxid++;
		}
		
		$results1 = $this->operation->add_info_cc($maxid);	
		$results2 = $this->operation->get_info_cc();
		$infoid = $results2;
		
		$results3 = $this->operation->add_details_cc($infoid);
		
		echo json_encode("Success");

		 echo  "<script type='text/javascript'>";
		    echo "window.close();";
		    echo "</script>";
	}
	
	// function delete_cc($id){
		// $user    = $this->session->userdata('user');
        // $user_id = $user['id']; 
        // $user_branch = $user['branch']; 
			// $aria_db = $this->asset->get_aria_db($user_branch);
		// $a_id = $id;
		// $this->operation->delete_cc($a_id);
		// $this->operation->delete_stock_moves($a_id,$aria_db);
		
	// }
	
	//add product to cycle count -Paul
	public function add_cc()
	{
		$user    = $this->session->userdata('user');
        $user_id = $user['id']; 
        $user_branch = $user['branch']; 
		//$aria_db = $this->asset->get_aria_db($user_branch);
		$barcode = $this->input->post('prod');
		
		$results = $this->operation->add_prod_cc($barcode);
		echo json_encode(array('msg'=>$results));
	}
	
	public function r_add_cc()
	{
		$user    = $this->session->userdata('user');
        $user_id = $user['id']; 
        $user_branch = $user['branch']; 
		//$aria_db = $this->asset->get_aria_db($user_branch);
		$barcode = $this->input->post('prod');
		
		$results = $this->operation->r_add_prod_cc($barcode);
		echo json_encode(array('msg'=>$results));
	}
	

	//get cc details for cycle count -Paul
	public function get_item()
	{
		$user    = $this->session->userdata('user');
        $user_id = $user['id']; 
        $user_branch = $user['branch']; 
		$barcode = $this->input->post('prod');
		$vendorcode = $this->input->post('supplier_code');
		$results = $this->operation->get_bar_details($barcode,$vendorcode);
		$items=array();	
		if ($results) {
			$items = $results;
			
		}	
		$data['code'] = show_search($items);
		$data['load_js'] = "core/OperationJS.php";
		$data['use_js'] = "CycleCount";
		$this->load->view('load',$data);	
	}

	public function r_get_item()
	{
		$user    = $this->session->userdata('user');
        $user_id = $user['id']; 
        $user_branch = $user['branch']; 
		$barcode = $this->input->post('prod');
		$results = $this->operation->r_get_bar_details($barcode);
		$items=array();	
		if ($results) {
			$items = $results;
			
		}	
		$data['code'] = r_show_search($items);
		$data['load_js'] = "core/OperationJS.php";
		$data['use_js'] = "Recount";
		$this->load->view('load',$data);	
	}

	public function get_category()
	{
		$user    = $this->session->userdata('user');
        $user_id = $user['id']; 
        $user_branch = $user['branch']; 

		$results = $this->operation->get_cat_list();
		echo json_encode($results);
	}


	public function view_cat_product($id = NULL)
	{
		$user    = $this->session->userdata('user');
        $user_id = $user['id']; 
        $user_branch = $user['branch']; 
		$aria_db = $this->operation->get_aria_db($user_branch);

		$results = $this->operation->get_cat_details($id);
		$items=array();	
		if ($results) {
			$items = $results;		
		}

		$results2 = $this->operation->get_cat_info($id);
		$items2=array();	
		if ($results2) {
			$items2 = $results2;		
		}


		//$role = $user['role'];
		$data['code'] = show_cat_details($items,$items2);
		$data['load_js'] = "core/OperationJS.php";
		$data['use_js'] = "CycleCount";
		$this->load->view('load',$data);	
	}

	public function view_auto_cc($id = NULL)
	{
		$user    = $this->session->userdata('user');
        $user_id = $user['id']; 
        $user_branch = $user['branch']; 
		$aria_db = $this->operation->get_aria_db($user_branch);
		$next_trans = $this->operation->get_next_trans($aria_db->aria_db);	
		$next_trans = $next_trans + 1;


		$results = $this->operation->get_auto_details($id);
		$items=array();	
		if ($results) {
			$items = $results;		
		}

		$results2 = $this->operation->get_auto_info($id);
		$items2=array();	
		if ($results2) {
			$items2 = $results2;		
		}


		$role = $user['role'];
		$data['code'] = show_auto_details($items,$role,$items2,$next_trans);
		$data['load_js'] = "core/OperationJS.php";
		$data['use_js'] = "CycleCount";
		$this->load->view('load',$data);	
	}

	public function view_auto_posted($id = NULL)
	{
		$user    = $this->session->userdata('user');
        $user_id = $user['id']; 
        $user_branch = $user['branch']; 
      	$aria_db2 = $this->asset->get_aria_db($user_branch);
		$aria_db = $this->operation->get_aria_db($user_branch);
		$next_trans = $this->operation->get_next_trans($aria_db->aria_db);	
		$next_trans = $next_trans + 1;


		$results = $this->operation->get_auto_details($id);
		$items=array();	
		if ($results) {
			$items = $results;		
		}

		$results2 = $this->operation->get_auto_info($id);
		$items2=array();	
		if ($results2) {
			$items2 = $results2;		
		}
	
		foreach($items2 as $info)
			{
				$trans=$info->TransNoIGSA;
				$trans2=$info->TransNoIGNSA;		
			}
			
		$results3 = $this->operation->get_trans_details($trans,$trans2,$aria_db->aria_db);
		$items3=array();	
		if ($results3) {
			$items3 = $results3;		
		}

		foreach($items3 as $info2)
			{
				$uid=$info2->a_created_by;	
			}
		
		$items4 = $this->operation->get_users($uid);
        

		$role = $user['role'];
		$data['code'] = show_trans_details($items,$items2,$items3,$items4);
		$data['load_js'] = "core/OperationJS.php";
		$data['use_js'] = "CycleCount";
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

	function add_stock_move(){
		$user    = $this->session->userdata('user');
        $user_id = $user['id']; 
        $user_branch = $user['branch']; 
		$aria_db = $this->asset->get_aria_db($user_branch);
        $trans_num = $this->input->post('trans_num');
        $date_adjustment = $this->input->post('date_adjustment');
        $total = $this->input->post('total');
        $remarks = $this->input->post('remarks');
        $input = $this->input->post('alldata');
        
        foreach ($input as $value) {

        	$data = array(
					'user_id'=> $user_id,
					'trans_num'=>$trans_num,
					'date_adjustment'=>$date_adjustment,
					'product_id'=>$value[5],
					'uom_qty'=>$value[2],
					'cost'=>$value[1],
					'ad_qty_'=>$value[0],
					'unit'=>$value[3],
					'unit_cost'=>$value[4],
					'total'=>($value[0] * $value[2])*$value[1],
					'remarks'=>$remarks
			);


			$results = $this->operation->add_stock_move($data,$aria_db);
        }
		echo json_encode($results);
	}

	function add_adjustment_headercc($cc = NULL){

		$user    = $this->session->userdata('user');
        $user_id = $user['id']; 
        $user_branch = $user['branch']; 
		$aria_db = $this->asset->get_aria_db($user_branch);
		$trans_num = $this->input->post('trans_num');
        $remarks = $this->input->post('remarks');
        $alldata = $this->input->post('conso_igsa_data');
        $alldata2 = $this->input->post('conso_ignsa_data');
        $ctr=0;

        $data = array(
				'user_id'=> $user_id,
				'trans_num'=>$this->input->post('trans_num'),
				'date_adjustment'=>$this->input->post('date_adjustment'),
		);

		//echo var_dump($alldata);

			if($alldata)
			{
				$resultigsa = $this->operation->add_adjustment_headerigsa($alldata,$remarks,$total,$trans_num,$data,$aria_db,$cc);
				if($resultigsa =='duplicate'){
					echo json_encode(array('msg'=>'duplicate'));
				}
				$trans_num = $trans_num + 1;	

			}else{
				$resultigsa = 'success';
			}

			if($alldata2)
			{
				$resultignsa = $this->operation->add_adjustment_headerignsa($alldata2,$remarks,$total,$trans_num,$data,$aria_db,$cc);	
				if($resultignsa =='duplicate'){
					echo json_encode(array('msg'=>'duplicate'));
				}
			}else{
				
				$resultignsa = 'success';
			}

			if($resultigsa == "success" && $resultignsa == "success")
			{
				$results = 'success';

			}else{

				$results = 'error';
			}
		
			echo json_encode(array('msg'=>$results));
	}

	function add_adjustment_headerrecount(){
		$user    = $this->session->userdata('user');
        $user_id = $user['id']; 
        $user_branch = $user['branch']; 
		$aria_db = $this->asset->get_aria_db($user_branch);
		$trans_num = $this->input->post('trans_num');
        $total = $this->input->post('total');
        $remarks = $this->input->post('remarks');
        $alldata = $this->input->post('alldata');
        $alldata2 = $this->input->post('alldata2');
        $ctr=0;

        $data = array(
				'user_id'=> $user_id,
				'trans_num'=>$this->input->post('trans_num'),
				'date_adjustment'=>$this->input->post('date_adjustment'),
		);



			if($alldata)
			{
				$resultigsa = $this->operation->r_add_adjustment_headerigsa($alldata,$remarks,$total,$trans_num,$data,$aria_db);
				$trans_num = $trans_num + 1;	
			}
			else
			{
				$resultigsa = 'success';
			}
			
			if($alldata2)
			{
				$resultignsa = $this->operation->r_add_adjustment_headerignsa($alldata2,$remarks,$total,$trans_num,$data,$aria_db);	
			}
			else
			{
				$resultignsa = 'success';
			}

			if($resultigsa == 'success' && $resultignsa == 'success')
			{
				$results = 'success';
			}
			else
			{
				$results = 'error';
			}
		
			$this->operation->delete_recount();
			
		
		echo json_encode(array('msg'=>$results));
	}


	function add_adjustment_header(){
		$user    = $this->session->userdata('user');
        $user_id = $user['id']; 
        $user_branch = $user['branch']; 
		$aria_db = $this->asset->get_aria_db($user_branch);
		$trans_num = $this->input->post('trans_num');
        $total = $this->input->post('total');
        $remarks = $this->input->post('remarks');
        $alldata = $this->input->post('alldata');

		$data = array(
				'user_id'=> $user_id,
				'trans_num'=>$this->input->post('trans_num'),
				'date_adjustment'=>$this->input->post('date_adjustment'),
		);

		$results = $this->operation->add_adjustment_header($alldata,$remarks,$total,$trans_num,$data,$aria_db);
		echo json_encode($results);
	}

	/*function add_adjustment_header(){
		$user    = $this->session->userdata('user');
        $user_id = $user['id']; 
        $user_branch = $user['branch']; 
		$aria_db = $this->asset->get_aria_db($user_branch);
		$data = array(
				'user_id'=> $user_id,
				'trans_num'=>$this->input->post('trans_num'),
				'date_adjustment'=>$this->input->post('date_adjustment')
		);

		$results = $this->operation->add_adjustment_header($data,$aria_db);
		echo json_encode($results);
	}*/

	function uom_details($uom){

		$user = $this->session->userdata('user');
		$results = $this->operation->uom_details($uom);

		echo json_encode($results);
	}

	function updateuser(){
		$user    = $this->session->userdata('user');
        $user_id = $user['id']; 
        $user_branch = $user['branch']; 
		$barcode = $this->input->post('Barcode_cc');
		
		$results = $this->operation->r_update_cc($barcode);
		echo json_encode($results);
	}

	public function r_delete_cc()
	{
		$user    = $this->session->userdata('user');
        $user_id = $user['id']; 
        $user_branch = $user['branch']; 
		//$aria_db = $this->asset->get_aria_db($user_branch);
		$barcode = $this->input->post('prod');
		
		$results = $this->operation->r_delete_cc($barcode);
		echo json_encode($results);
	}

	public function delete_cc()
	{
		$user    = $this->session->userdata('user');
        $user_id = $user['id']; 
        $user_branch = $user['branch']; 
		//$aria_db = $this->asset->get_aria_db($user_branch);
		$barcode = $this->input->post('prod');
		
		$results = $this->operation->delete_cc($barcode);
		echo json_encode($results);
	}

	//delete all tempcyclecount by branch -Van
	public function delete_all_cc(){
		$results = $this->operation->delete_all_cc();
		echo json_encode($results);
	}

	public function delete_cat()
	{
		$user    = $this->session->userdata('user');
        $user_id = $user['id']; 
        $user_branch = $user['branch']; 
		//$aria_db = $this->asset->get_aria_db($user_branch);
		$cat = $this->input->post('cat');
		
		$results = $this->operation->delete_cat($cat);
		echo json_encode($results);
	}
	
	public function delete_catprod()
	{
		$user    = $this->session->userdata('user');
        $user_id = $user['id']; 
        $user_branch = $user['branch']; 
		//$aria_db = $this->asset->get_aria_db($user_branch);
		$cat = $this->input->post('cat');
		$bar = $this->input->post('bar');
		
		$results = $this->operation->delete_catprod($cat,$bar);
		echo json_encode($results);
	}

	function delete_adjustment($id){
		$user    = $this->session->userdata('user');
        $user_id = $user['id']; 
        $user_branch = $user['branch']; 
		$aria_db = $this->asset->get_aria_db($user_branch);
		$a_id = $id;
		$this->operation->delete_adjustments($a_id,$aria_db);
		$this->operation->delete_stock_moves($a_id,$aria_db);
		
	}

	function adjustment_history_view($id){
		$user    = $this->session->userdata('user');
        $user_id = $user['id']; 
        $user_branch = $user['branch']; 
		$aria_db = $this->asset->get_aria_db($user_branch);

		$adjustment_history = $this->operation->get_adjustment_history($id,$aria_db);
		$ad_top_details = $this->operation->get_ad_top_details($id,$aria_db);
		$data['code'] = adjustment_history_view($adjustment_history,$ad_top_details,$id);
        $data['load_js'] = "core/OperationJS.php";
		$this->load->view('load',$data);
	}

	public function smart(){
		$data = $this->syter->spawn('operation');
		$user    = $this->session->userdata('user');
        $user_id = $user['id']; 
        $user_branch = $user['branch']; 
		$aria_db = $this->operation->get_aria_db($user_branch);
		$data['page_subtitle'] = "SMART TRANSACTION : ".$aria_db->description;
		$results = $this->operation->get_smart_display();
		$items = array();
		if ($results) {
			$items = $results;
			
		}
		$data['code'] = smart($items);
		$data['load_js'] = "core/OperationJS.php";
		$data['use_js'] = "SmartTrans";
		$this->load->view('page',$data);
	}


	public function smart_trans_search(){
		$branch = $this->input->post('branch');
		$branch = ltrim($branch);
		$branch = rtrim($branch);		
		$or_num = $this->input->post('or_num');		
		$or_num = ltrim($or_num);
		$or_num = rtrim($or_num);
		$cell_num = $this->input->post('cell_num');	
		$postype = $this->input->post('postype');	
		$cell_num = ltrim($cell_num);
		$cell_num = rtrim($cell_num);
		$user    = $this->session->userdata('user');
        $user_id = $user['id']; 
        $user_branch = $user['branch'];
		$results = $this->operation->get_smart_display_search($branch,$or_num,$cell_num,$postype);
		$items = array();
		if ($results) {
			$items = $results;
		}
		$data['code'] = smart_result($items);
		$this->load->view('load',$data);
	
	}

	public function print_smart_trans(){
		$branch = $this->input->get('bcode');
        $or_num = $this->input->get('or_num');
        $cell_num = $this->input->get('cell_num');
		$print_items = array(
        	'branch' => $branch,
            'or_num' => $or_num,
            'cell_num' => $cell_num
        ); 
        $data['print_items'] = $print_items; 
       $this->load->view('contents/prints/print_smart_trans.php',$data);
	}

	//--------------------- DAN ------------------------//
	public function view_data(){
		$data = $this->syter->spawn('operation');
		$user    = $this->session->userdata('user');
        $user_id = $user['id']; 
        $user_branch = $user['branch']; 
		$aria_db = $this->operation->get_aria_db($user_branch);
		$data['page_subtitle'] = "PRODUCT HISTORY : ".$aria_db->description;
		$results = $this->operation->get_view_data_display($user_branch);
		$items = array();
		if ($results) {
			$items = $results;
			
		}
		$data['code'] = view_data($items);
		$data['load_js'] = "core/OperationJS.php";
		$data['use_js'] = "ViewData";
		$this->load->view('page',$data);
	}
	
	public function view_data_trans_search(){
		$description = $this->input->post('description');
		$description = ltrim($description);
		$description = rtrim($description);		
		$barcode = $this->input->post('barcode');		
		$barcode = ltrim($barcode);
		$barcode = rtrim($barcode);
		$fdate = $this->input->post('fdate');	
		$fdate = ltrim($fdate);
		$fdate = rtrim($fdate);
		$tdate = $this->input->post('tdate');	
		$tdate = ltrim($tdate);
		$tdate = rtrim($tdate);
		$user    = $this->session->userdata('user');
        $user_id = $user['id']; 
        $user_branch = $user['branch'];
		$results = $this->operation->get_view_data_display_search($user_branch,$description,$barcode,$fdate,$tdate);
		$items = array();
		if ($results) {
			$items = $results;
		}
		$data['code'] = view_data_result($items,$user_branch);
		$data['load_js'] = "core/OperationJS.php";
		$data['use_js'] = "ViewData";
		$this->load->view('load',$data);
	}

	
	public function view_data_button($id){
		$user    = $this->session->userdata('user');
        $user_id = $user['id']; 
        $user_branch = $user['branch'];
		$data = $this->syter->spawn('operation');
		$results = $this->operation->view_data_display($id,$user_branch);
		$items = array();
		if ($results) {
			$items = $results;
			
		}
		$data['code'] = view_data_button($items);
		$data['load_js'] = "core/OperationJS.php";
		$data['use_js'] = "ViewData";
		$this->load->view('load',$data);
	}


	public function view_markup_button($id){
		$user    = $this->session->userdata('user');
        $user_id = $user['id']; 
        $user_branch = $user['branch'];
		$data = $this->syter->spawn('operation');
		$results = $this->operation->view_markup_display($id,$user_branch);
		$markup_srp = array();
		if ($results) {
			$markup_srp = $results;
			
		}
		$data['code'] = view_markup_button($markup_srp);
		$data['load_js'] = "core/OperationJS.php";
		$data['use_js'] = "ViewData";
		$this->load->view('load',$data);
	}


	public function view_srp_computation($id, $costofsales, $barcode){
		$user    = $this->session->userdata('user');
        $user_id = $user['id']; 
        $user_branch = $user['branch'];
		$data = $this->syter->spawn('operation');
		$results = $this->operation->view_srp_computation_display($id,$user_branch,$barcode);
		$items = array();
		if ($results) {
			$items = $results;
			
		}
		$data['code'] = view_srp_computation($items, $costofsales);
		$data['load_js'] = "core/OperationJS.php";
		$data['use_js'] = "ViewData";
		$this->load->view('load',$data);
	}


	public function view_tn(){
		$user    = $this->session->userdata('user');
        $user_id = $user['id']; 
		$user_branch = $user['branch'];
		$id = $_POST["id"];
		$data = $this->syter->spawn('operation');
		$results = $this->operation->view_tn($id,$user_branch);
		$view_tns = array();
		if ($results) {
			$view_tns = $results;
			
		}
		$data['code'] = view_tn($view_tns);
		$data['load_js'] = "core/OperationJS.php";
		$data['use_js'] = "ViewData";
		$this->load->view('load',$data);
	}

	public function view_name(){
		$user    = $this->session->userdata('user');
        $user_id = $user['id']; 
		$user_branch = $user['branch'];
		$id = $_POST["id"];
		$data = $this->syter->spawn('operation');
		$results = $this->operation->view_name($id,$user_branch);
		$view_name = array();
		if ($results) {
			$view_name = $results;
			
		}
		$data['code'] = view_name($view_name);
		$data['load_js'] = "core/OperationJS.php";
		$data['use_js'] = "ViewData";
		$this->load->view('load',$data);
	}
	
	public function print_product_history(){
	    $user_branch = $this->input->get('user_branch');
		$description = $this->input->get('description');
		$barcode = $this->input->get('barcode');
		$fdate = $this->input->get('fdate');
		$tdate = $this->input->get('tdate');
		
		$print_items= array('user_branch' => $user_branch,
						'description' => $description,
						'barcode' => $barcode,
						'fdate' => $fdate,
						'tdate' => $tdate);
		$data['print_items'] = $print_items ; 
		$this->load->view('contents/prints/print_product_history.php',$data); 

	}

	//--------------------- DAN ------------------------//

	public function get_prod_uom($prod_code){
		$user    = $this->session->userdata('user');
        $user_id = $user['id']; 
        $user_branch = $user['branch'];
		$results = $this->operation->get_prod_uom($user_branch,$prod_code);
		
		echo json_encode($results);
	}

	public function get_prod_uom2($bcode){
		$user    = $this->session->userdata('user');
        $user_id = $user['id']; 
        $user_branch = $user['branch'];
		$results = $this->operation->get_prod_uom2($user_branch,$bcode);
		echo json_encode($results);
	}

	function update_status(){
		$user    = $this->session->userdata('user');
        $user_id = $user['id']; 
        $user_branch = $user['branch']; 
		$aria_db = $this->asset->get_aria_db($user_branch);
        $prod_id = $this->input->post('data');
        $remarks = $this->input->post('remarks');

		$results = $this->operation->update_status($prod_id,$aria_db,$remarks);

		echo json_encode($results);
	}

	function update_statusUncheck(){
		$user    = $this->session->userdata('user');
        $user_id = $user['id']; 
        $user_branch = $user['branch']; 
		$aria_db = $this->asset->get_aria_db($user_branch);
        $prod_id = $this->input->post('data');

		$results = $this->operation->update_status($prod_id,$aria_db);

		echo json_encode($results);
	}

	// LAWRENZE
	public function price_match_report(){
		$data = $this->syter->spawn('operation');
		$user    = $this->session->userdata('user');
        $user_id = $user['id']; 
        $user_branch = $user['branch']; 
		$aria_db = $this->operation->get_aria_db($user_branch);
		
		$data['page_subtitle'] = "PRICE MATCH REPORT : ".$aria_db->description;

		$user    = $this->session->userdata('user');
        $user_id = $user['id']; 
        $user_branch = $user['branch']; 
		$data['code'] = price_match_report($user_branch);
		$data['load_js'] = "core/OperationJS.php";
		$data['use_js'] = "PriceMatchReport";
		$this->load->view('page',$data);
	}


	public function price_match_report_excel() {
		$this->load->library('excel');
		$objPHPExcel = new PHPExcel();
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $data_ = $this->input->post();
		$fDate =  date("Y-m-d", strtotime($data_['fdate']));
		$tDate =  date("Y-m-d", strtotime($data_['tdate']));
		$get_db_details = $this->operation->get_133_db($data_['branch']);
		$branch_name = array($get_db_details->description);
		$db_133 = $get_db_details->db_133;
		$objPHPExcel->createSheet();

		foreach ($branch_name as $sheet => $value) {

			$data = $this->operation->get_pricematch_report_excel($fDate, $tDate, $db_133);

			if($data == null) {
				die(json_encode("false"));
			}

			$objPHPExcel->setActiveSheetIndex($sheet);
			$objPHPExcel->getActiveSheet()->setTitle($value);

			foreach(range('A','J') as $columnID) {
				$objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
					->setAutoSize(true);
			}

			$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn('C')->setAutoSize(false);
			$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn('C')->setWidth('10');
			$objPHPExcel->getActiveSheet()->setCellValue('A1', 'ProductID');
			$objPHPExcel->getActiveSheet()->setCellValue('B1', 'Barcode');
			$objPHPExcel->getActiveSheet()->setCellValue('C1', 'PriceModeCode');
			$objPHPExcel->getActiveSheet()->setCellValue('D1', 'Date Posted');
			$objPHPExcel->getActiveSheet()->setCellValue('E1', 'Posted By');
			$objPHPExcel->getActiveSheet()->setCellValue('F1', 'From SRP');
			$objPHPExcel->getActiveSheet()->setCellValue('G1', 'To SRP');
			$objPHPExcel->getActiveSheet()->setCellValue('H1', 'UOM');
			$objPHPExcel->getActiveSheet()->setCellValue('I1', 'Markup');
			$objPHPExcel->getActiveSheet()->setCellValue('J1', 'Date Posted in Branch');

			$n = 2;
			foreach($data as $datas) {
				$objPHPExcel->getActiveSheet()->setCellValue('A'.$n, $datas->productid);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$n)
											->getNumberFormat()
											->setFormatCode(
												'0'
											);
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$n, $datas->barcode);
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$n, $datas->PriceModecode);
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$n, $datas->dateposted);
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$n, $datas->postedby);
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$n, $datas->fromsrp);
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$n, $datas->tosrp);
				$objPHPExcel->getActiveSheet()->setCellValue('H'.$n, $datas->UOM);
				$objPHPExcel->getActiveSheet()->setCellValue('I'.$n, $datas->markup);
				$objPHPExcel->getActiveSheet()->setCellValue('J'.$n, $datas->dateposted_branch);
				$n++;
			}
		}
		ob_start();
		$fileName = "Price_Match_Report_".$fDate."-".$tDate.".xlsx";
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $fileName . '"');
		header('Cache-Control: max-age=0');
		$objWriter->save('php://output');
		$xlsData = ob_get_contents();
		ob_end_clean();
		$response =  array(
		'op' => 'ok',
		'file' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData),
		'filename' => $fileName
		);
		
		die(json_encode($response));
	}

	public function fetch_pricematch_branches() {
		$get_branches = $this->operation->get_branches();

		$response = array();

		for($i = 0; $i<count($get_branches); $i++) {
			$sub_array = array();

			$sub_array['brcode'] = $get_branches[$i]['db_133'];
         	$sub_array['description'] = $get_branches[$i]['description'];	

         	$response[] = $sub_array;
		}


		echo json_encode($response);
	}

	// ./LAWRENZE

}
?>

