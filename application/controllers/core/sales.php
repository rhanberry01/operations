<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR | E_PARSE);


class Sales extends CI_Controller {
    var $data = null;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('core/sales_model');
        $this->load->model('site/site_model');

        
        $this->load->helper('site/site_forms_helper');
        $this->load->helper('core/sales_helper');
        $this->load->helper('pdf_helper');
        $this->load->library('excel');
        $this->load->library('zip');


    
    // //asset js
    // $this->load->model('core/asset_model');
    // $this->load->helper('core/asset_helper');
  

    }
  
  
  // function Single(){
  
    // $data = $this->syter->spawn('asset');
    // $data['page_subtitle'] = "Asset List";
     // $asset_list = $this->asset_model->get_asset();
    // $data['code'] = asset_list($asset_list);
    // $data['add_js'] = 'js/site_list_forms.js';
        // $data['load_js'] = "core/assetJS.php";
        // $data['use_js'] = "newassetJS";
    // $this->load->view('page',$data);
  
  // }
  
     // public function Single(){
     //     $sales_order = $this->sales_model->singlevendor();
     // // echo var_dump($sales_order);
     //    // echo var_dump($sales_order);
     //     $data = $this->syter->spawn('sales');
         
     //     //$data['code'] = site_list_form("sales/sales_order_form","sales_order_form","Sales Orders",$sales_order,array('role'),"id");
     //     $data['code'] = SingleVendorForm($sales_order);
     //     $data['add_js'] = 'js/site_list_forms.js';
         
     //     $data['load_js'] = 'core/sales.php';

     //     $data['use_js'] = 'zzz';
     //     $this->load->view('page',$data);
     // }
     public function Single($ref='')
    {
        $data = $this->syter->spawn('sales');
        $data['page_title'] = fa('fa-cube')."Single Vendor";
        $description = $this->sales_model->get_description();
        //$customers = $this->customer_model->get_all_customers();
         $data['code'] = SingleVendorForm($description);
        $data['add_js'] = 'js/site_list_forms.js';
        
        $data['add_css']= 'css/daterangepicker/daterangepicker-bs3.css';
        $data['add_js'] = 'js/plugins/daterangepicker/daterangepicker.js';
        
        $data['load_js'] = "core/sales.php";
        $data['use_js'] = "SingleJs";
        $this->load->view('page',$data);
    }


    public function delete_vendor_list(){
        $user = $this->session->userdata('user');
            $user_id = $user['id'];
         $results = $this->sales_model->delete_v_list($user_id);

    }


    public function reloadvendorlist(){

        $vendorcode = $this->input->post('vendorcode');
        $branch = $this->input->post('branch');
        $user = $this->session->userdata('user');
            $user_id = $user['id'];
            $items = array(
                            'user'=>$user_id,
                            'vendorcode'=>$vendorcode,
                            );
        $this->sales_model->add_vendor($items);
        $results = $this->sales_model->get_v_list($user_id);
        $data['code'] = reloaodvendorlist($results);
        $data['load_js'] = "core/sales.php";
        $data['use_js'] = "reloaodvendorlist";
        $this->load->view('load',$data);
    }


    public function Single_branch_drop(){

        $branch = $this->input->post('branch');
        $user = $this->session->userdata('user');
            $user_id = $user['id'];
        $results = $this->sales_model->ReloadSingleVendorDP($branch);
        $data['code'] = Singledrop($results,$user_id);
        $data['load_js'] = "core/sales.php";
        $data['use_js'] = "SingleBranchJs";
        $this->load->view('load',$data);
    }



    public function singlevendor_results(){
        $this->load->model('core/sales_model');
        $thisval = "";
        $results = array();
        $description = $this->input->post('description');
        $daterange = $this->input->post('daterange');
        $branch = $this->input->post('branch');
        $dates = explode(" to ",$daterange);
        $date_from = (empty($dates[0]) ? '' : date('Y-m-d',strtotime($dates[0])));
        $date_to = (empty($dates[1]) ? '' : date('Y-m-d',strtotime($dates[1])));
        $results = $this->sales_model->get_vendor($date_from,$date_to,$description,$branch);
        //echo var_dump($results);
        $data['load_js'] = 'core/sales.php';
        $data['use_js'] = 'SingleVResultJs';
        $data['code'] = singlevendor_results($results,$branch);

       $this->load->view('load',$data);
    }

      public function AllVendor($ref=''){
         $data = $this->syter->spawn('sales');
        $data['page_title'] = fa('fa-cube')." All Vendors";
        $avendors = $this->sales_model->AVendor();
        $data['code'] = AllVendor($avendors);
        $data['add_js'] = 'js/site_list_forms.js';
        
        $data['add_css']= 'css/daterangepicker/daterangepicker-bs3.css';
        $data['add_js'] = 'js/plugins/daterangepicker/daterangepicker.js';
        
        $data['load_js'] = "core/sales.php";
        $data['use_js'] = "AllVendorJs";
        $this->load->view('page',$data);
     }
      
      public function allvendor_results(){
        $this->load->model('core/sales_model');
        $thisval = "";
        $results = array();
        $daterange = $this->input->post('daterange');
        $branch = $this->input->post('branch');
        $dates = explode(" to ",$daterange);
        $date_from = (empty($dates[0]) ? '' : date('Y-m-d',strtotime($dates[0])));
        $date_to = (empty($dates[1]) ? '' : date('Y-m-d',strtotime($dates[1])));
        $results = $this->sales_model->get_allvendor($date_from,$date_to,$branch);
        //echo var_dump($results);
        $data['load_js'] = 'core/sales.php';
        $data['use_js'] = 'CustomerJS';
        $data['code'] = allvendor_results2($results,$branch);

       $this->load->view('load',$data);
    }


     //=================================END==========================================

      public function Category(){
         $this->load->model('core/sales_model');
         $this->load->helper('core/sales_helper');
         $this->load->helper('site/site_forms_helper');
         
         $sales_order = $this->sales_model->Category();
        // echo var_dump($sales_order);
         $data = $this->syter->spawn('sales');
         $data['page_title'] = fa('fa-cube')."Category";
         
         //$data['code'] = site_list_form("sales/sales_order_form","sales_order_form","Sales Orders",$sales_order,array('role'),"id");
         $data['code'] = CatVen($sales_order);
          $data['add_js'] = 'js/site_list_forms.js';
        
        $data['add_css']= 'css/daterangepicker/daterangepicker-bs3.css';
        $data['add_js'] = 'js/plugins/daterangepicker/daterangepicker.js';
        
        $data['load_js'] = "core/sales.php";
        $data['use_js'] = "CustomerJS";
         $this->load->view('page',$data);
     }


     public function SMARTPOS(){
         $this->load->model('core/sales_model');
         $this->load->helper('core/sales_helper');
         $this->load->helper('site/site_forms_helper');
         $data = $this->syter->spawn('sales');
         $data['page_title'] = fa('fa-cube')."SMART";
         
         $data['code'] = SMARTPOSHELPER();
         $data['add_js'] = 'js/site_list_forms.js';
        
        $data['add_css']= 'css/daterangepicker/daterangepicker-bs3.css';
        $data['add_js'] = 'js/plugins/daterangepicker/daterangepicker.js';
        
        $data['load_js'] = "core/sales.php";
        $data['use_js'] = "SMARTPOS";
         $this->load->view('page',$data);
     }


    public function SPECIAL_FRESH(){
         $this->load->model('core/sales_model');
         $this->load->helper('core/sales_helper');
         $this->load->helper('site/site_forms_helper');
         $data = $this->syter->spawn('sales');
         $data['page_title'] = fa('fa-cube')."FRESH SECTION";
         
         $data['code'] = SPECIAL_FRESH_HELPER();
         $data['add_js'] = 'js/site_list_forms.js';
        
        $data['add_css']= 'css/daterangepicker/daterangepicker-bs3.css';
        $data['add_js'] = 'js/plugins/daterangepicker/daterangepicker.js';
        
        $data['load_js'] = "core/sales.php";
        $data['use_js'] = "SPECIALFRESH";
         $this->load->view('page',$data);
     }



    public function Category_results(){
        $this->load->model('core/sales_model');
        $thisval = "";
        $results = array();
        $description = $this->input->post('description');
        $daterange = $this->input->post('daterange');
        $branch = $this->input->post('name');
        $dates = explode(" to ",$daterange);
        $date_from = (empty($dates[0]) ? '' : date('Y-m-d',strtotime($dates[0])));
        $date_to = (empty($dates[1]) ? '' : date('Y-m-d',strtotime($dates[1])));
        $results = $this->sales_model->get_cat($branch,$date_from,$date_to,$description);

        //echo var_dump($results);
        $data['load_js'] = 'core/sales.php';
        $data['use_js'] = 'CustomerJS';
        $data['code'] = Category_results($results,$branch,$date_from,$date_to,$description);

       $this->load->view('load',$data);
    }


     //>>>>
     public function OfftakeSingle($ref=''){
         $this->load->model('core/sales_model');
         $this->load->helper('core/sales_helper');
         $this->load->helper('site/site_forms_helper');
        
         $sales_order = $this->sales_model->singlevendor();
        // echo var_dump($sales_order);
         $data = $this->syter->spawn('sales');
          $data['page_title'] = fa('fa-folder')."Offtake Single Vendor";
         //$data['code'] = site_list_form("sales/sales_order_form","sales_order_form","Sales Orders",$sales_order,array('role'),"id");
         $data['code'] = OfftakeSVendor($sales_order);
         $data['add_js'] = 'js/site_list_forms.js';
        
        $data['add_css']= 'css/daterangepicker/daterangepicker-bs3.css';
        $data['add_js'] = 'js/plugins/daterangepicker/daterangepicker.js';
        
        $data['load_js'] = "core/sales.php";
        $data['use_js'] = "OfftakeSingleJS";
         $this->load->view('page',$data);
     }
     public function OfftakeSingle_branch_drop(){

        $branch = $this->input->post('branch');
        
        $results = $this->sales_model->ReloadSingleVendorDP($branch);
        $data['code'] = offtakesingledrop($results);
        $data['load_js'] = "core/sales.php";
        $data['use_js'] = "OfftakeSingleBranchJs";
        $this->load->view('load',$data);
    }

        public function OfftakeSvendor_results(){
        $this->load->model('core/sales_model');
        $thisval = "";
        $results = array();
        $description = $this->input->post('description');
        $daterange = $this->input->post('daterange');
        $dates = explode(" to ",$daterange);
        $date_from = (empty($dates[0]) ? '' : date('Y-m-d',strtotime($dates[0])));
        $date_to = (empty($dates[1]) ? '' : date('Y-m-d',strtotime($dates[1])));
        $branch = $this->input->post('branch');
        $results = $this->sales_model->get_offtakeSvendor($date_from,$date_to,$description,$branch);
        // echo var_dump($results);
        $data['load_js'] = 'core/sales.php';
        $data['use_js'] = 'CustomerJS';
        $data['code'] = OfftakeSvendor_results($results,$branch);

       $this->load->view('load',$data);
    }

     //>>>
      public function OfftakeAllVendor($ref=''){
         $data = $this->syter->spawn('sales');
        $data['page_title'] = fa('fa-folder')."Offtake All Vendor";
        $avendors = $this->sales_model->OfftakeAVendor();
        $data['code'] = OfftakeAllVendor($avendors);
        $data['add_js'] = 'js/site_list_forms.js';
        
        $data['add_css']= 'css/daterangepicker/daterangepicker-bs3.css';
        $data['add_js'] = 'js/plugins/daterangepicker/daterangepicker.js';
        
        $data['load_js'] = "core/sales.php";
        $data['use_js'] = "OfftakeAllVendorJs";
        $this->load->view('page',$data);
     }
     //=================================WAKOL========================================
      public function Offtakeallvendor_results(){
        $this->load->model('core/sales_model');
        $thisval = "";
        $results = array();
        $daterange = $this->input->post('daterange');
        $dates = explode(" to ",$daterange);
        $branch = $this->input->post('branch');
        $date_from = (empty($dates[0]) ? '' : date('Y-m-d',strtotime($dates[0])));
        $date_to = (empty($dates[1]) ? '' : date('Y-m-d',strtotime($dates[1])));
        $results = $this->sales_model->get_Offtakeallvendor($date_from,$date_to,$branch);
        //echo var_dump($results);
        $data['load_js'] = 'core/sales.php';
        $data['use_js'] = 'CustomerJS';
        $data['code'] = Offtakeallvendor_results($results,$branch);

       $this->load->view('load',$data);
    }
      public function OfftakeCustomer(){
         $this->load->model('core/sales_model');
         $this->load->helper('core/sales_helper');
         $this->load->helper('site/site_forms_helper');
         
         $sales_order = $this->sales_model->singlevendor();
        // echo var_dump($sales_order);
         $data = $this->syter->spawn('sales');
         $data['page_title'] = fa('fa-folder')."Offtake By Customer Vendor";
         //$data['code'] = site_list_form("sales/sales_order_form","sales_order_form","Sales Orders",$sales_order,array('role'),"id");
         $data['code'] = OfftakeCustomer($sales_order);
         $data['add_js'] = 'js/site_list_forms.js';
          $data['load_js'] = 'core/sales.php';

         $data['use_js'] = 'zzz';
         $this->load->view('page',$data);
     }

     public function Overstock($ref=''){
        $this->load->model('core/sales_model');
        $this->load->helper('core/sales_helper');
        $this->load->helper('site/site_forms_helper');
        $sales_order = $this->sales_model->Overstock();
        // echo var_dump($sales_order);
        $data = $this->syter->spawn('sales');
        $data['page_title'] = fa('fa-archive')."Single Overstock";
         //$data['code'] = site_list_form("sales/sales_order_form","sales_order_form","Sales Orders",$sales_order,array('role'),"id");
        $data['code'] = Overstock($sales_order);
        $data['add_js'] = 'js/site_list_forms.js';
        
        $data['add_css']= 'css/daterangepicker/daterangepicker-bs3.css';
        $data['add_js'] = 'js/plugins/daterangepicker/daterangepicker.js';
        
        $data['load_js'] = "core/sales.php";
        $data['use_js'] = "OverstockJs";
        $this->load->view('page',$data);
     }

     public function overstock_branch_drop(){

        $branch = $this->input->post('branch');
        
        $results = $this->sales_model->ReloadSingleVendorDP($branch);
       // echo var_dump($results);
        $data['code'] = overstockdrop($results);
        $data['load_js'] = "core/sales.php";
        $data['use_js'] = "OverstockBranchJs";
        $this->load->view('load',$data);
    }   



// View Finished Sales
     public function load_finished_sales_data(){

		$user    = $this->session->userdata('user');
		$user_branch = $user['branch'];
        $from = $this->input->post('from');
        $to = $this->input->post('to');
        $barcode = $this->input->post('barcode');
    	if($barcode){
         $results = $this->sales_model->get_fsales_data($user_branch,$from,$to,$barcode);
	}else{
	 $results = $this->sales_model->get_fsales_data_($user_branch,$from,$to,$barcode);
	}
    
        $data['code'] = finishedsales_data_result($results,$user_branch);
       $data['load_js'] = "core/sales.php";
       $data['use_js'] = "CsalesJs";
        $this->load->view('load',$data);
    }   

    public function print_check_sales(){
	    $user_branch = $this->input->get('user_branch');
		$from_date = $this->input->get('from_date');
        $t_date = $this->input->get('t_date');
        $barcode = $this->input->get('barcode');
		
		$print_items= array('user_branch' => $user_branch,
						'from_date' => $from_date,
                        't_date' => $t_date,
                    'barcode' => $barcode,);
		$data['print_items'] = $print_items ; 
		$this->load->view('contents/prints/print_check_sales.php',$data); 

	}
    // View Finished Sales

     public function update_qty_fsales(){



        $branch = $this->input->post('branch');
        $LineID = $this->input->post('LineID');
        $ProductID = $this->input->post('ProductID');
        $Qty = $this->input->post('Qty');
        $Packing = $this->input->post('Packing');
        $TotalQty = $this->input->post('TotalQty');
       
        $results = $this->sales_model->upd_sales_line($branch,$ProductID,$LineID,$Qty,$Packing,$TotalQty);

        echo $results;
        //echo $branch.'-'.$ProductID.'-'.$LineID.'-'.$Qty.'-'.$Packing.'-'.$TotalQty.'<<<<<<<<<<<<<<>>>>>>>>>>>>>>>>';
     }



        public function update_cost_fsales(){

        $id = $this->input->post('id');
        $results = $this->sales_model->get_upcost_list_id($id);
        
        $branch = $results->branch;
        $ProductID = $results->productid;
        $From = $results->datef;
        $To = $results->datet;

        $result = $this->sales_model->upd_sales_line_cost($branch,$ProductID,$From,$To);

        $res = $this->sales_model->upd_cost_sales($id);

        echo $res;
        //echo $branch.'-'.$ProductID.'-'.$LineID.'-'.$Qty.'-'.$Packing.'-'.$TotalQty.'<<<<<<<<<<<<<<>>>>>>>>>>>>>>>>';
     }


     public function get_fsales_data_ER(){

        $branch = $this->input->post('branch');
        $LineID = $this->input->post('LineID');
        $ProductID = $this->input->post('ProductID');
       
    
        $results = $this->sales_model->get_fsales_data_ER($branch,$LineID,$ProductID);
       // echo $results;
        $data['code'] = finishedsales_data_result_er($results);
        $data['load_js'] = "core/sales.php";
        $data['use_js'] = "updCsalesJs";
        $this->load->view('load',$data);
    } 



     public function add_view_upcost(){

        $branch = $this->input->post('branch');
        $ProductID = $this->input->post('ProductID');
        $From = $this->input->post('From');
        $To = $this->input->post('To');
        $user = $this->session->userdata('user');
        $items = array(
                        'branch'=>$branch,
                        'datef'=>date('Y-m-d',strtotime($From)),
                        'datet'=>date('Y-m-d',strtotime($To)),
                        'productid'=>$ProductID,
                        'req_by'=>$user['id']
                        );
    
        $this->sales_model->add_data_up_cost($items);
        $results = $this->sales_model->get_upcost_list();
       // echo var_dump($results);
        $data['code'] = finishedsales_data_upd_result_er($results);
        $data['load_js'] = "core/sales.php";
        $data['use_js'] = "updCsalesJs";
        $this->load->view('load',$data);
    } 
   

        
   
   

     public function Overstock_results(){
        $this->load->model('core/sales_model');
        $thisval = "";
        $results = array();
        $description = $this->input->post('description');
        $daterange = $this->input->post('daterange');
        $dates = explode(" to ",$daterange);
        $branch = $this->input->post('branch');
        $date_from = (empty($dates[0]) ? '' : date('Y-m-d',strtotime($dates[0])));
        $date_to = (empty($dates[1]) ? '' : date('Y-m-d',strtotime($dates[1])));
        $results = $this->sales_model->get_overstock($date_from,$date_to,$description,$branch);
        //echo var_dump($results);
        $data['load_js'] = 'core/sales.php';
        $data['use_js'] = 'CustomerJS';
        $data['code'] = Overstock_results($results,$branch);

       $this->load->view('load',$data);
    }
     public function Overstock_all($ref=''){
        $this->load->model('core/sales_model');
        $this->load->helper('core/sales_helper');
        $this->load->helper('site/site_forms_helper');
        $sales_order = $this->sales_model->OverstockAll();
        // echo var_dump($sales_order);
        $data = $this->syter->spawn('sales');
         $data['page_title'] = fa('fa-archive')."All Overstock";
         
         //$data['code'] = site_list_form("sales/sales_order_form","sales_order_form","Sales Orders",$sales_order,array('role'),"id");
        $data['code'] = AllOverstock($sales_order);
        $data['add_js'] = 'js/site_list_forms.js';
        
        $data['add_css']= 'css/daterangepicker/daterangepicker-bs3.css';
        $data['add_js'] = 'js/plugins/daterangepicker/daterangepicker.js';
        
        $data['load_js'] = "core/sales.php";
        $data['use_js'] = "OverstockA";
        $this->load->view('page',$data);
     }

         public function AllOverstock_results(){
        $this->load->model('core/sales_model');
        $thisval = "";
        $results = array();
        $daterange = $this->input->post('daterange');
        $branch = $this->input->post('branch');
        $dates = explode(" to ",$daterange);
        $date_from = (empty($dates[0]) ? '' : date('Y-m-d',strtotime($dates[0])));
        $date_to = (empty($dates[1]) ? '' : date('Y-m-d',strtotime($dates[1])));
        $results = $this->sales_model->get_overstockAll($date_from,$date_to,$branch);
        //echo var_dump($results);
        $data['load_js'] = 'core/sales.php';
        $data['use_js'] = 'OverstockA';
        $data['code'] = AllOverstock_results($results,$branch);

       $this->load->view('load',$data);
    }

    public function UpdateFsLine($ref=''){

        $this->load->model('core/sales_model');
        $this->load->helper('core/sales_helper');
        $this->load->helper('site/site_forms_helper');

        $data = $this->syter->spawn('sales');
        $data['page_title'] = fa('fa-database')." Update Finished Sales line Error";
        $data['code'] = updateERForm();
        $data['add_js'] = 'js/site_list_forms.js';

        $data['load_js'] = "core/sales.php";
        $data['use_js'] = "CsalesJs";
        $this->load->view('page',$data);   

    }

    // View Finished Sales

    public function Csales($ref=''){
        $this->load->model('core/sales_model');
        $this->load->helper('core/sales_helper');
        $this->load->helper('site/site_forms_helper');

        $user    = $this->session->userdata('user');
		$user_branch = $user['branch'];
        $data = $this->syter->spawn('sales');
        $data['page_title'] = fa('fa-database')."Check Sales";
        $data['code'] = checkSalesForm($user_branch);
        $data['add_js'] = 'js/site_list_forms.js';

        $data['load_js'] = "core/sales.php";
        $data['use_js'] = "CsalesJs";
        $this->load->view('page',$data);   
     }
     // View Finished Sales



    public function Inventory($ref=''){
        $this->load->model('core/sales_model');
        $this->load->helper('core/sales_helper');
        $this->load->helper('site/site_forms_helper');
         // $sales_order = $this->sales_model->get_inventory_details($qwe,$branch,$box);
        // echo var_dump($sales_order);
        $data = $this->syter->spawn('sales');
        $data['page_title'] = fa('fa-database')."Inventory Level";
         //$data['code'] = site_list_form("sales/sales_order_form","sales_order_form","Sales Orders",$sales_order,array('role'),"id");
        $data['code'] = InventoryList();
        $data['add_js'] = 'js/site_list_forms.js';
        
        $data['add_css']= 'css/daterangepicker/daterangepicker-bs3.css';
        $data['add_js'] = 'js/plugins/daterangepicker/daterangepicker.js';
        
        $data['load_js'] = "core/sales.php";
        $data['use_js'] = "InventoryListBranchJS";
        $this->load->view('page',$data);
     }

      public function inventory_results(){
        $this->load->model('core/sales_model');
        $thisval = "";
        $results = array();
        $qwe = $this->input->post('qwe');
        $branch = $this->input->post('branch');
        $box = $this->input->post('chckbox');
        $results = $this->sales_model->get_inventory_details($qwe,$branch,$box);
        //echo var_dump($results);
        $data['load_js'] = 'core/sales.php';
        $data['use_js'] = 'InventoryJS';
        $data['code'] = inventory_results($results);
       $this->load->view('load',$data);

    }

     public function looseinventory_results(){
        $this->load->model('core/sales_model');
        $thisval = "";
        $results = array();
        $qwe = $this->input->post('qwe');
        $box = $this->input->post('chckbox');
        $branch = $this->input->post('branch');
        $results = $this->sales_model->get_inventoryloose_details($qwe,$branch,$box);
        //echo var_dump($results);
        $data['load_js'] = 'core/sales.php';
        $data['use_js'] = 'InventoryJS';
        $data['code'] = inventoryloose_results($results);
       $this->load->view('load',$data);
    }
    
       public function inventorylevel_excel(){
       $qwe=$this->input->get('qwe');
       $branch=$this->input->get('branch');
      

        $print_items=array(

            'qwe'=>$qwe,
            'branch'=>$branch

            
            );

         $data['print_items'] = $print_items; 
        $this->load->view('contents/prints/inventory_level_excel.php',$data);
        
    }
    public function inventorylevelloose_excel(){
       $qwe=$this->input->get('qwe');
       $branch=$this->input->get('branch');
      

        $print_items=array(

            'qwe'=>$qwe,
            'branch'=>$branch

            
            );

         $data['print_items'] = $print_items; 
        $this->load->view('contents/prints/Inventory_resuly_loose.php',$data);
        
    }

    function dept_results(){
        $this->load->model('core/sales_model');
        $thisval = "";
        $results = array();
        $department = $this->input->post('depart');
        $box1 = $this->input->post('chckbox');
        $branch = $this->input->post('branch');
        $results = $this->sales_model->get_dept_details($department,$branch,$box1);
        //echo var_dump($results);
        $data['load_js'] = 'core/sales.php';
        $data['use_js'] = 'DeptInventJS';
        $data['code'] = dept_result($results);
        $this->load->view('load',$data);
    }
    function deptloose_results(){
        $this->load->model('core/sales_model');
        $thisval = "";
        $results = array();
        $department = $this->input->post('depart');
        $box1 = $this->input->post('chckbox');
        $branch = $this->input->post('branch');
        $results = $this->sales_model->get_deptloose_details($department,$branch,$box1);
        //echo var_dump($results);
        $data['load_js'] = 'core/sales.php';
        $data['use_js'] = 'DeptInventJS';
        $data['code'] = deptloose_result($results);
        $this->load->view('load',$data);
    }
    public function dept_show(){
       $department=$this->input->get('depart');
       $branch=$this->input->get('branch');
      

        $print_items=array(

            'depart'=>$department,
            'branch'=>$branch

            
            );

         $data['print_items'] = $print_items; 
        $this->load->view('contents/prints/Dept_result.php',$data);
        
    }
    public function dept_loose(){
       $department=$this->input->get('depart');
       $branch=$this->input->get('branch');
      

        $print_items=array(

            'depart'=>$department,
            'branch'=>$branch

            
            );

         $data['print_items'] = $print_items; 
        $this->load->view('contents/prints/Dept_loose.php',$data);
        
    }
    function brand_results(){
       $this->load->model('core/sales_model');
       $thisval = "";
       $results = array();
       $brand = $this->input->post('brand');
       $box2 = $this->input->post('chckbox');
       $branch = $this->input->post('branch');
       $results = $this->sales_model->get_brand_details($brand,$branch,$box2);
        //echo var_dump($results);
       $data['load_js'] = 'core/sales.php';
       $data['use_js'] = 'BrandInventJS';
       $data['code'] = brand_result($results);
       $this->load->view('load',$data);
    }
    function brand_looseresults(){
       $this->load->model('core/sales_model');
       $thisval = "";
       $results = array();
       $brand = $this->input->post('brand');
       $box2 = $this->input->post('chckbox');
       $branch = $this->input->post('branch');
       $results = $this->sales_model->get_loosebrand_details($brand,$branch,$box2);
        //echo var_dump($results);
       $data['load_js'] = 'core/sales.php';
       $data['use_js'] = 'BrandInventJS';
       $data['code'] = brandloose_result($results);
       $this->load->view('load',$data);
    }
    public function brand_show(){
       $brand=$this->input->get('brand');
       $branch=$this->input->get('branch');
      

        $print_items=array(

            'brand'=>$brand,
            'branch'=>$branch

            
            );

         $data['print_items'] = $print_items; 
        $this->load->view('contents/prints/Brand_showResult.php',$data);
        
    }
    public function brand_loose(){
       $brand=$this->input->get('brand');
       $branch=$this->input->get('branch');
      

        $print_items=array(

            'brand'=>$brand,
            'branch'=>$branch

            
            );

         $data['print_items'] = $print_items; 
        $this->load->view('contents/prints/Brand_looseResult.php',$data);
        
    }
    function class_results(){
       $this->load->model('core/sales_model');
       $thisval = "";
       $results = array();
       $cls = $this->input->post('category');
       $box3 = $this->input->post('chckbox');
       $branch = $this->input->post('branch');
       $results = $this->sales_model->get_class_details($cls,$branch,$box3);
        //echo var_dump($results);
       $data['load_js'] = 'core/sales.php';
       $data['use_js'] = 'ClassInventJS';
       $data['code'] = class_result($results);

       $this->load->view('load',$data);

    }
    function classloose_results(){
       $this->load->model('core/sales_model');
       $thisval = "";
       $results = array();
       $cls = $this->input->post('category');
       $box3 = $this->input->post('chckbox');
       $branch = $this->input->post('branch');
       $results = $this->sales_model->get_classloose_details($cls,$branch,$box3);
        //echo var_dump($results);
       $data['load_js'] = 'core/sales.php';
       $data['use_js'] = 'ClassInventJS';
       $data['code'] = classloose_result($results);

       $this->load->view('load',$data);

    }
     public function class_show(){
       $cls=$this->input->get('category');
       $branch=$this->input->get('branch');
      

        $print_items=array(

            'category'=>$cls,
            'branch'=>$branch

            
            );

         $data['print_items'] = $print_items; 
        $this->load->view('contents/prints/Class_result.php',$data);
        
    }
    public function class_loose(){
       $cls=$this->input->get('category');
       $branch=$this->input->get('branch');
      

        $print_items=array(

            'category'=>$cls,
            'branch'=>$branch

            
            );

         $data['print_items'] = $print_items; 
        $this->load->view('contents/prints/Class_loose.php',$data);
        
    }
    function country_results(){
       $this->load->model('core/sales_model');
       $thisval = "";
       $results = array();
       $ctry = $this->input->post('country');
       $boxcountry = $this->input->post('chckbox');
       $branch = $this->input->post('branch');
       $results = $this->sales_model->get_country_details($ctry,$branch,$boxcountry);
        //echo var_dump($results);
       $data['load_js'] = 'core/sales.php';
       $data['use_js'] = 'CountryInventJS';
       $data['code'] = country_result($results);

       $this->load->view('load',$data);

    }
    function country_loose(){
       $this->load->model('core/sales_model');
       $thisval = "";
       $results = array();
       $ctry = $this->input->post('country');
       $boxcountry = $this->input->post('chckbox');
       $branch = $this->input->post('branch');
       $results = $this->sales_model->country_loose($ctry,$branch,$boxcountry);
        //echo var_dump($results);
       $data['load_js'] = 'core/sales.php';
       $data['use_js'] = 'CountryInventJS';
       $data['code'] = country_loose($results);

       $this->load->view('load',$data);

    }
     public function country_show(){
       $ctry=$this->input->get('country');
       $branch=$this->input->get('branch');
      

        $print_items=array(

            'country'=>$ctry,
            'branch'=>$branch

            
            );

         $data['print_items'] = $print_items; 
        $this->load->view('contents/prints/Country_show.php',$data);
        
    }
    public function country_loose1(){
       $ctry=$this->input->get('country');
       $branch=$this->input->get('branch');
      

        $print_items=array(

            'country'=>$ctry,
            'branch'=>$branch

            
            );

         $data['print_items'] = $print_items; 
        $this->load->view('contents/prints/Country_loose.php',$data);
        
    }
    function category_ILresults(){
       $this->load->model('core/sales_model');
       $thisval = "";
       $results = array();
       $catego = $this->input->post('cls');
       $box4 = $this->input->post('chckbox');
       $branch = $this->input->post('branch');
       $results = $this->sales_model->get_category_det($catego,$branch,$box4);
        //echo var_dump($results);
       $data['load_js'] = 'core/sales.php';
       $data['use_js'] = 'CategoInventJS';
       $data['code'] = categoryInvent_result($results);

       $this->load->view('load',$data);

    }
    function get_categoryloose_det(){
       $this->load->model('core/sales_model');
       $thisval = "";
       $results = array();
       $catego = $this->input->post('cls');
       $box4 = $this->input->post('chckbox');
       $branch = $this->input->post('branch');
       $results = $this->sales_model->get_categoryloose_det($catego,$branch,$box4);
        //echo var_dump($results);
       $data['load_js'] = 'core/sales.php';
       $data['use_js'] = 'CategoInventJS';
       $data['code'] = category_loose($results);

       $this->load->view('load',$data);

    }
    public function Category_show(){
       $catego=$this->input->get('cls');
       $branch=$this->input->get('branch');
      

        $print_items=array(

            'cls'=>$catego,
            'branch'=>$branch

            
            );

         $data['print_items'] = $print_items; 
        $this->load->view('contents/prints/Category_show.php',$data);
        
    }
    public function Category_loose(){
       $catego=$this->input->get('cls');
       $branch=$this->input->get('branch');
      

        $print_items=array(

            'cls'=>$catego,
            'branch'=>$branch

            
            );

         $data['print_items'] = $print_items; 
        $this->load->view('contents/prints/Category_loose.php',$data);
        
    }

    


//--------------------------PRODUCTLISTING-------------------------------------
     public function ProductListing($ref=''){
        $this->load->model('core/sales_model');
        $this->load->helper('core/sales_helper');
        $this->load->helper('site/site_forms_helper');
        $data = $this->syter->spawn('sales');
        $data['page_title'] = fa('fa-list')."Product Listing";
        $data['code'] = ProductList();
        $data['add_js'] = 'js/site_list_forms.js';
        $data['add_css']= 'css/daterangepicker/daterangepicker-bs3.css';
        $data['add_js'] = 'js/plugins/daterangepicker/daterangepicker.js';
        $data['load_js'] = "core/sales.php";
        $data['use_js'] = "ProductListing";
        $this->load->view('page',$data);
     }
       public function ProductListing_results(){
        $this->load->model('core/sales_model');
        $thisval = "";
        $results = array();
        $description = $this->input->post('venda');
        $price = $this->input->post('stock_location');
     	$branch = $this->input->post('productbranch');
        $chckbox = $this->input->post('active');
        $chckbox1 = $this->input->post('inactive');
        $chckbox2 = $this->input->post('AI');
        $results = $this->sales_model->productlisting($price,$description,$branch,$chckbox,$chckbox1,$chckbox2);
        $data['load_js'] = 'core/sales.php';
        $data['use_js'] = 'VendaJS';
        $data['code'] = Prodlist_results($results,$branch);
        $this->load->view('load',$data);
     }
     public function ProductListinginac_results(){
        $this->load->model('core/sales_model');
        $thisval = "";
        $results = array();
        $costdesinac = $this->input->post('venda');
        $priceinac = $this->input->post('stock_location');
        $branch = $this->input->post('productbranch');
        $costchckboxinac = $this->input->post('active');
        $costchckboxinac1 = $this->input->post('inactive');
        $costchckboxinac2 = $this->input->post('AI');
        $results = $this->sales_model->productlistinginact_det($priceinac,$costdesinac,$branch,$costchckboxinac,$costchckboxinac1,$costchckboxinac2);
        $data['load_js'] = 'core/sales.php';
        $data['use_js'] = 'VendaJS';
        $data['code'] = Prodlistinac_results($results,$branch);
        $this->load->view('load',$data);
     }
     public function ProductListingActinac_results(){
        $this->load->model('core/sales_model');
        $thisval = "";
        $results = array();
        $costdesinacact = $this->input->post('venda');
        $priceinacact = $this->input->post('stock_location');
        $branch = $this->input->post('productbranch');
        $costchckboxinacact = $this->input->post('active');
        $costchckboxinacact1 = $this->input->post('inactive');
        $costchckboxinacact2 = $this->input->post('AI');
        $results = $this->sales_model->productlistingActinact_det($priceinacact,$costdesinacact,$branch,$costchckboxinacact,$costchckboxinacact1,$costchckboxinacact2);
        $data['load_js'] = 'core/sales.php';
        $data['use_js'] = 'VendaJS';
        $data['code'] = ProdlistActinac_results($results,$branch);
        $this->load->view('load',$data);
     }
     public function ProductListingcost_results(){
        $this->load->model('core/sales_model');
        $thisval = "";
        $results = array();
        $costdes = $this->input->post('venda');
        $pricecost = $this->input->post('stock_location');
        $branch = $this->input->post('productbranch');
        $costchckbox = $this->input->post('active');
        $costchckbox1 = $this->input->post('inactive');
        $costchckbox2 = $this->input->post('AI');
        $cost = $this->input->post('cost');
        $results = $this->sales_model->productlistingcost_det($pricecost,$costdes,$branch,$costchckbox,$costchckbox1,$costchckbox2,$cost);
        //echo var_dump($results);
        $data['load_js'] = 'core/sales.php';
        $data['use_js'] = 'vendJS';
        $data['code'] = ProductListingcost_results($results,$branch);
        $this->load->view('load',$data);
     }
      	public function Productdepartment_results(){
        $this->load->model('core/sales_model');
        $thisval = "";
        $results = array();
        $ch = $this->input->post('active');
        $ch1 = $this->input->post('inactive');
        $ch2 = $this->input->post('AI');
        $cost = $this->input->post('cost');
        $dep = $this->input->post('pldept');
        $price = $this->input->post('stock_location');
     	$branch = $this->input->post('productbranch');
        $results = $this->sales_model->productdepartlisting($price,$dep,$branch,$ch,$ch1,$ch2);
        $data['load_js'] = 'core/sales.php';
        $data['use_js'] = 'DeptJS';
        $data['code'] = departactive_results($results);
        $this->load->view('load',$data);
     }
      public function Depart_activeyahoo(){
       $price =$this->input->get('stock_location');
       $branch = $this->input->get('productbranch');
       $dep=$this->input->get('pldept');
      

        $print_items=array(

            'stock_location'=>$price,
            'pldept'=>$dep,
            'productbranch'=>$branch
            );

         $data['print_items'] = $print_items; 
        $this->load->view('contents/prints/Depart_active.php',$data);

    }
    public function Productdepartmentinactive_results(){
        $this->load->model('core/sales_model');
        $thisval = "";
        $results = array();
        $ch = $this->input->post('active');
        $ch1 = $this->input->post('inactive');
        $ch2 = $this->input->post('AI');
        $cost = $this->input->post('cost');
        $dep = $this->input->post('pldept');
        $price = $this->input->post('stock_location');
        $branch = $this->input->post('productbranch');
        $results = $this->sales_model->productdepartlistinginactive($price,$dep,$branch,$ch,$ch1,$ch2);
        $data['load_js'] = 'core/sales.php';
        $data['use_js'] = 'DeptJS';
        $data['code'] = departinactive_results($results);
        $this->load->view('load',$data);
     }
      public function Depart_inactiveyahoo(){
       $price =$this->input->get('stock_location');
       $branch = $this->input->get('productbranch');
       $dep=$this->input->get('pldept');
      

        $print_items=array(

            'stock_location'=>$price,
            'pldept'=>$dep,
            'productbranch'=>$branch
            );

         $data['print_items'] = $print_items; 
        $this->load->view('contents/prints/Depart_inactive.php',$data);

    }
    public function ProductdepartmentActinactive_results(){
        $this->load->model('core/sales_model');
        $thisval = "";
        $results = array();
        $ch = $this->input->post('active');
        $ch1 = $this->input->post('inactive');
        $ch2 = $this->input->post('AI');
        $cost = $this->input->post('cost');
        $dep = $this->input->post('pldept');
        $price = $this->input->post('stock_location');
        $branch = $this->input->post('productbranch');
        $results = $this->sales_model->productdepartlistingActinactive($price,$dep,$branch,$ch,$ch1,$ch2);
        $data['load_js'] = 'core/sales.php';
        $data['use_js'] = 'DeptJS';
        $data['code'] = departActinactive_results($results);
        $this->load->view('load',$data);
     }
      public function Depart_Actinactiveyahoo(){
       $price =$this->input->get('stock_location');
       $branch = $this->input->get('productbranch');
       $dep=$this->input->get('pldept');
      

        $print_items=array(

            'stock_location'=>$price,
            'pldept'=>$dep,
            'productbranch'=>$branch
            );

         $data['print_items'] = $print_items; 
        $this->load->view('contents/prints/Depart_Actinactive.php',$data);

    }

     public function ProductListingdepartcost_results(){
        $this->load->model('core/sales_model');
        $thisval = "";
        $results = array();
        $deptcostdes = $this->input->post('pldept');
        $deptpricecost = $this->input->post('stock_location');
        $branch = $this->input->post('productbranch');
        $deptcostchckbox = $this->input->post('active');
        $deptcostchckbox1 = $this->input->post('inactive');
        $deptcostchckbox2 = $this->input->post('AI');
        $deptcost = $this->input->post('cost');
        $results = $this->sales_model->productlistingcost_depart($deptcost,$deptpricecost,$deptcostdes,$branch,$deptcostchckbox,$deptcostchckbox1,$deptcostchckbox2);
        $data['load_js'] = 'core/sales.php';
        $data['use_js'] = 'deptJS';
        $data['code'] = Prodlistcost_results($results);
        $this->load->view('load',$data);
     }
        public function Productbrand_results(){
        $this->load->model('core/sales_model');
        $thisval = "";
        $results = array();
        $brandch = $this->input->post('active');
        $brandch1 = $this->input->post('inactive');
        $brandch2 = $this->input->post('AI');
        $cost = $this->input->post('cost');
        $brand = $this->input->post('brands');
        $brandprice = $this->input->post('stock_location');
        $branch = $this->input->post('productbranch');
        $results = $this->sales_model->productbrandlisting($brandprice,$brand,$branch,$brandch,$brandch1,$brandch2);
        //echo var_dump($results);
        $data['load_js'] = 'core/sales.php';
        $data['use_js'] = 'BrandJS';
        $data['code'] = brandactive_results($results);

        $this->load->view('load',$data);
     }
       public function Brand_active(){
       $brandprice =$this->input->get('stock_location');
       $branch = $this->input->get('productbranch');
       $brand =$this->input->get('brands');
      

        $print_items=array(

            'stock_location'=>$brandprice,
            'brands'=>$brand,
            'productbranch'=>$branch
            );

         $data['print_items'] = $print_items; 
        $this->load->view('contents/prints/Brand_results.php',$data);

    }
       public function BrandInactive_results(){
        $this->load->model('core/sales_model');
        $thisval = "";
        $results = array();
        $brandinch = $this->input->post('active');
        $brandinch1 = $this->input->post('inactive');
        $brandinch2 = $this->input->post('AI');
        $cost = $this->input->post('cost');
        $brandin = $this->input->post('brands');
        $brandinprice = $this->input->post('stock_location');
        $branch = $this->input->post('productbranch');
        $results = $this->sales_model->productinactivebrandlisting($brandinprice,$brandin,$branch,$brandinch,$brandinch1,$brandinch2);
        //echo var_dump($results);
        $data['load_js'] = 'core/sales.php';
        $data['use_js'] = 'BrandJS';
        $data['code'] = brandinactive_results($results);

        $this->load->view('load',$data);
     }
       public function Brand_inactive(){
       $brandinprice =$this->input->get('stock_location');
       $branch = $this->input->get('productbranch');
       $brandin =$this->input->get('brands');
      

        $print_items=array(

            'stock_location'=>$brandinprice,
            'brands'=>$brandin,
            'productbranch'=>$branch
            );

         $data['print_items'] = $print_items; 
        $this->load->view('contents/prints/brandinactive_results.php',$data);

    }
    public function BrandActiveInactive_results(){
        $this->load->model('core/sales_model');
        $thisval = "";
        $results = array();
        $brandainch = $this->input->post('active');
        $brandainch1 = $this->input->post('inactive');
        $brandainch2 = $this->input->post('AI');
        $cost = $this->input->post('cost');
        $brandain = $this->input->post('brands');
        $brandainprice = $this->input->post('stock_location');
        $branch = $this->input->post('productbranch');
        $results = $this->sales_model->ActiveInactiveBrand($brandainprice,$brandain,$branch,$brandainch,$brandainch1,$brandainch2);
        //echo var_dump($results);
        $data['load_js'] = 'core/sales.php';
        $data['use_js'] = 'BrandJS';
        $data['code'] = brandactiveinactive_results($results);

        $this->load->view('load',$data);
     }
       public function Brand_Activeinactive(){
       $brandainprice =$this->input->get('stock_location');
       $branch = $this->input->get('productbranch');
       $brandain =$this->input->get('brands');
      

        $print_items=array(

            'stock_location'=>$brandainprice,
            'brands'=>$brandain,
            'productbranch'=>$branch
            );

         $data['print_items'] = $print_items; 
        $this->load->view('contents/prints/ActiveInactive_results.php',$data);

    }
     public function ProductListingbrandcost_results(){
        $this->load->model('core/sales_model');
        $thisval = "";
        $results = array();
        $branddesc = $this->input->post('brands');
        $brandprice = $this->input->post('stock_location');
        $branch = $this->input->post('productbranch');
        $brandcheck = $this->input->post('active');
        $brandcheck1 = $this->input->post('inactive');
        $brandcheck2 = $this->input->post('AI');
        $brandcost = $this->input->post('cost');
        $results = $this->sales_model->ProductListingbrandcost($brandprice,$branddesc,$branch,$brandcheck,$brandcheck1,$brandcheck2,$brandcost);
        //echo var_dump($results);
        $data['load_js'] = 'core/sales.php';
        $data['use_js'] = 'BrandJS';
        $data['code'] = Brand_Cost1($results);

        $this->load->view('load',$data);
     }
      public function Brand_cost(){
       $brandprice =$this->input->get('stock_location');
       $branch = $this->input->get('productbranch');
       $branddesc =$this->input->get('brands');
      

        $print_items=array(

            'stock_location'=>$brandprice,
            'brands'=>$branddesc,
            'productbranch'=>$branch
            );

         $data['print_items'] = $print_items; 
        $this->load->view('contents/prints/BrandCost.php',$data);

    }
     ///////////////////////////////////////////////////////////////////////////////HALO
     public function Productclass_results(){
        $this->load->model('core/sales_model');
        $thisval = "";
        $results = array();
        $classch = $this->input->post('active');
        $classch1 = $this->input->post('inactive');
        $classch2 = $this->input->post('AI');
        $cost = $this->input->post('cost');
        $class = $this->input->post('clss');
        $classprice = $this->input->post('stock_location');
        $branch = $this->input->post('productbranch');
        $results = $this->sales_model->productclasslisting($classprice,$class,$branch,$classch,$classch1,$classch2);
        $data['load_js'] = 'core/sales.php';
        $data['use_js'] = 'ClassJS';
        $data['code'] = Class_active($results);
        $this->load->view('load',$data);
     }
     public function Class_active(){
       $classprice =$this->input->get('stock_location');
       $branch = $this->input->get('productbranch');
       $class =$this->input->get('clss');
      

        $print_items=array(

            'stock_location'=>$classprice,
            'clss'=>$class,
            'productbranch'=>$branch
            );

         $data['print_items'] = $print_items; 
        $this->load->view('contents/prints/Class_Active.php',$data);

    }
     public function Productclass_inactive(){
        $this->load->model('core/sales_model');
        $thisval = "";
        $results = array();
        $classchinactive = $this->input->post('active');
        $classchinactive1 = $this->input->post('inactive');
        $classchinactive2 = $this->input->post('AI');
        $cost = $this->input->post('cost');
        $classinactive = $this->input->post('clss');
        $classpriceinactive = $this->input->post('stock_location');
        $branch = $this->input->post('productbranch');
        $results = $this->sales_model->classinactive($classpriceinactive,$classinactive,$branch,$classchinactive,$classchinactive1,$classchinactive2);
        $data['load_js'] = 'core/sales.php';
        $data['use_js'] = 'ClassJS';
        $data['code'] = Class_inactive($results);
        $this->load->view('load',$data);
     }
     public function Class_inactive(){
       $classpriceinactive =$this->input->get('stock_location');
       $branch = $this->input->get('productbranch');
       $classinactive =$this->input->get('clss');
      

        $print_items=array(

            'stock_location'=>$classpriceinactive,
            'clss'=>$classinactive,
            'productbranch'=>$branch
            );

         $data['print_items'] = $print_items; 
        $this->load->view('contents/prints/Class_Inactive.php',$data);

    }
    public function class_Actinactive1(){
        $this->load->model('core/sales_model');
        $thisval = "";
        $results = array();
        $classchactinactive = $this->input->post('active');
        $classchactinactive1 = $this->input->post('inactive');
        $classchactinactive2 = $this->input->post('AI');
        $cost = $this->input->post('cost');
        $classactinactive = $this->input->post('clss');
        $classpriceactinactive = $this->input->post('stock_location');
        $branch = $this->input->post('productbranch');
        $results = $this->sales_model->classactinactive($classpriceactinactive,$classactinactive,$branch,$classchactinactive,$classchactinactive1,$classchactinactive2);
        $data['load_js'] = 'core/sales.php';
        $data['use_js'] = 'ClassJS';
        $data['code'] = Class_Actinactive($results);
        $this->load->view('load',$data);
     }
     public function Class_Actinactive(){
       $classpriceactinactive =$this->input->get('stock_location');
       $branch = $this->input->get('productbranch');
       $classactinactive =$this->input->get('clss');
      

        $print_items=array(

            'stock_location'=>$classpriceactinactive,
            'clss'=>$classactinactive,
            'productbranch'=>$branch
            );

         $data['print_items'] = $print_items; 
        $this->load->view('contents/prints/Class_Actinactive.php',$data);

    }
     public function Productclasscost_results(){
        $this->load->model('core/sales_model');
        $thisval = "";
        $results = array();
        $cclassch = $this->input->post('active');
        $cclassch1 = $this->input->post('inactive');
        $cclassch2 = $this->input->post('AI');
        $cclasscost = $this->input->post('cost');
        $cclass = $this->input->post('clss');
        $cclassprice = $this->input->post('stock_location');
        $branch = $this->input->post('productbranch');
        $results = $this->sales_model->productclasslistingcost($cclassprice,$cclass,$branch,$cclassch,$cclassch1,$cclassch2,$cclasscost);
        $data['load_js'] = 'core/sales.php';
        $data['use_js'] = 'ClassJS';
        $data['code'] = Class_cost($results);
        $this->load->view('load',$data);
     }
     public function Class_Cost(){
       $cclassprice =$this->input->get('stock_location');
       $branch = $this->input->get('productbranch');
       $cclass =$this->input->get('clss');
      

        $print_items=array(

            'stock_location'=>$cclassprice,
            'clss'=>$cclass,
            'productbranch'=>$branch
            );

         $data['print_items'] = $print_items; 
        $this->load->view('contents/prints/Class_cost.php',$data);

    }
     public function Productyear_results(){
        $this->load->model('core/sales_model');
        $thisval = "";
        $results = array();
        $yearch = $this->input->post('active');
        $yearch1 = $this->input->post('inactive');
        $yearch2 = $this->input->post('AI');
        $cost = $this->input->post('cost');
        $year = $this->input->post('year');
        $yearprice = $this->input->post('stock_location');
        $branch = $this->input->post('productbranch');
        $results = $this->sales_model->productyearlisting($year,$yearprice,$branch,$yearch,$yearch1,$yearch2);
        $data['load_js'] = 'core/sales.php';
        $data['use_js'] = 'CustomerJS';
        $data['code'] = Prodlist_results($results);

        $this->load->view('load',$data);
     }
          public function Year_active(){
       $yearprice =$this->input->get('stock_location');
       $branch = $this->input->get('productbranch');
       $year =$this->input->get('category');
      

        $print_items=array(

            'stock_location'=>$yearprice,
            'year'=>$year,
            'productbranch'=>$branch
            );

         $data['print_items'] = $print_items; 
        $this->load->view('contents/prints/Category_active.php',$data);

    }
    public function Productinactiveyear_results(){
        $this->load->model('core/sales_model');
        $thisval = "";
        $results = array();
        $yearch = $this->input->post('active');
        $yearch1 = $this->input->post('inactive');
        $yearch2 = $this->input->post('AI');
        $cost = $this->input->post('cost');
        $year = $this->input->post('year');
        $yearprice = $this->input->post('stock_location');
        $branch = $this->input->post('productbranch');
        $results = $this->sales_model->productinactiveyearlisting($year,$yearprice,$branch,$yearch,$yearch1,$yearch2);
        $data['load_js'] = 'core/sales.php';
        $data['use_js'] = 'CustomerJS';
        $data['code'] = Prodlist_results($results);

        $this->load->view('load',$data);
     }
     public function ProductActinactiveyear_results(){
        $this->load->model('core/sales_model');
        $thisval = "";
        $results = array();
        $yearch = $this->input->post('active');
        $yearch1 = $this->input->post('inactive');
        $yearch2 = $this->input->post('AI');
        $cost = $this->input->post('cost');
        $year = $this->input->post('year');
        $yearprice = $this->input->post('stock_location');
        $branch = $this->input->post('productbranch');
        $results = $this->sales_model->country_Actinactive($year,$yearprice,$branch,$yearch,$yearch1,$yearch2);
        $data['load_js'] = 'core/sales.php';
        $data['use_js'] = 'CustomerJS';
        $data['code'] = Prodlist_results($results);

        $this->load->view('load',$data);
     }
   
    // public function Categinactive_results(){
    //     $this->load->model('core/sales_model');
    //     $thisval = "";
    //     $results = array();
    //     $yearch = $this->input->post('active');
    //     $yearch1 = $this->input->post('inactive');
    //     $yearch2 = $this->input->post('AI');
    //     $year = $this->input->post('year');
    //     $yearprice = $this->input->post('stock_location');
    //     $branch = $this->input->post('productbranch');
    //     $results = $this->sales_model->productcategorylistinginactive($catpriceinac1,$catinac1,$branch,$catac1,$catinc2,$catai3);
    //     $data['load_js'] = 'core/sales.php';
    //     $data['use_js'] = 'ClassJS';
    //     $data['code'] = CategoryInactive($results);
    //     $this->load->view('load',$data);
    //  }

     public function Productcountry_results(){
        $this->load->model('core/sales_model');
        $thisval = "";
        $results = array();
        $countrych = $this->input->post('active');
        $countrych1 = $this->input->post('inactive');
        $countrych2 = $this->input->post('AI');
        $cost = $this->input->post('cost');
        $country = $this->input->post('country');
        $countryprice = $this->input->post('stock_location');
        $branch = $this->input->post('productbranch');
        $results = $this->sales_model->productcountrylisting($countryprice,$country,$branch,$countrych,$countrych1,$countrych2);
        $data['load_js'] = 'core/sales.php';
        $data['use_js'] = 'CountryJs';
        $data['code'] = Country_active($results);
        $this->load->view('load',$data);
     }
      public function Countryactive(){
       $countryprice =$this->input->get('stock_location');
       $branch = $this->input->get('productbranch');
       $country =$this->input->get('country');
      

        $print_items=array(

            'stock_location'=>$countryprice,
            'country'=>$country,
            'productbranch'=>$branch
            );

         $data['print_items'] = $print_items; 
        $this->load->view('contents/prints/Country_results.php',$data);

    }
     public function Productcountrycost_results(){
        $this->load->model('core/sales_model');
        $thisval = "";
        $results = array();
        $countrycost = $this->input->post('active');
        $countrycost1 = $this->input->post('inactive');
        $countrycost2= $this->input->post('AI');
        $countrycost3 = $this->input->post('cost');
        $country = $this->input->post('country');
        $costprice = $this->input->post('stock_location');
        $branch = $this->input->post('productbranch');
        $results = $this->sales_model->productcountrylistingcost($costprice,$country,$branch,$countrycost,$countrycost1,$countrycost2,$countrycost3);
        //echo var_dump($results);
        $data['load_js'] = 'core/sales.php';
        $data['use_js'] = 'CountryJs';
        $data['code'] = Country_cost($results);

        $this->load->view('load',$data);
     }
      public function Countrycost(){
       $costprice =$this->input->get('stock_location');
       $branch = $this->input->get('productbranch');
       $country =$this->input->get('country');
      

        $print_items=array(

            'stock_location'=>$costprice,
            'country'=>$country,
            'productbranch'=>$branch
            );

         $data['print_items'] = $print_items; 
        $this->load->view('contents/prints/Country_cost.php',$data);

    }
      public function Country_inactive(){
        $this->load->model('core/sales_model');
        $thisval = "";
        $results = array();
        $countinac = $this->input->post('active');
        $countinac1 = $this->input->post('inactive');
        $countinac2= $this->input->post('AI');
        $countryinc= $this->input->post('country');
        $countryinac = $this->input->post('stock_location');
        $branch = $this->input->post('productbranch');
        $results = $this->sales_model->country_inac($countryinac,$countryinc,$branch,$countinac,$countinac1,$countinac2);
        $data['load_js'] = 'core/sales.php';
        $data['use_js'] = 'CountryJs';
        $data['code'] = Country_inactive($results);
        $this->load->view('load',$data);
     }
     public function Countryinactive(){
       $countryinac =$this->input->get('stock_location');
       $branch = $this->input->get('productbranch');
       $countryinc =$this->input->get('country');
      

        $print_items=array(

            'stock_location'=>$countryinac,
            'country'=>$countryinc,
            'productbranch'=>$branch
            );

         $data['print_items'] = $print_items; 
        $this->load->view('contents/prints/Country_inactive.php',$data);

    }
     public function Country_active_inactive(){
        $this->load->model('core/sales_model');
        $thisval = "";
        $results = array();
        $countinactive = $this->input->post('active');
        $countinactive1 = $this->input->post('inactive');
        $countinactive2= $this->input->post('AI');
        $country = $this->input->post('country');
        $country_price = $this->input->post('stock_location');
        $branch = $this->input->post('productbranch');
        $results = $this->sales_model->country_inac_active($country_price,$country,$branch,$countinactive,$countinactive1,$countinactive2);
        $data['load_js'] = 'core/sales.php';
        $data['use_js'] = 'CountryJs';
        $data['code'] = Country_Actinactive($results);
        $this->load->view('load',$data);
     }
     public function CountryActinactive(){
       $country_price =$this->input->get('stock_location');
       $branch = $this->input->get('productbranch');
       $country =$this->input->get('country');
      

        $print_items=array(

            'stock_location'=>$country_price,
            'country'=>$country,
            'productbranch'=>$branch
            );

         $data['print_items'] = $print_items; 
        $this->load->view('contents/prints/Country_actinactive.php',$data);

    }
     //  public function Country_cost(){
     //    $this->load->model('core/sales_model');
     //    $thisval = "";
     //    $results = array();
       
     //    //echo var_dump($results);
     //    $data['load_js'] = 'core/sales.php';
     //    $data['use_js'] = 'CountryJs';
     //    $data['code'] = Category_cost($results);

     //    $this->load->view('load',$data);
     // }
     public function Productcateg_results(){
        $this->load->model('core/sales_model');
        $thisval = "";
        $results = array();
        $catac = $this->input->post('active');
        $catinc = $this->input->post('inactive');
        $catai= $this->input->post('AI');
        $cat = $this->input->post('category');
        $catprice = $this->input->post('stock_location');
        $branch = $this->input->post('productbranch');
        $results = $this->sales_model->productcategorylisting($catprice,$cat,$branch,$catac,$catinc,$catai);
        //echo var_dump($results);
        $data['load_js'] = 'core/sales.php';
        $data['use_js'] = 'CategoryJS';
        $data['code'] = CategoryActive($results);

        $this->load->view('load',$data);
     }
     public function Category_active(){
       $catprice =$this->input->get('stock_location');
       $branch = $this->input->get('productbranch');
       $cat =$this->input->get('category');
      

        $print_items=array(

            'stock_location'=>$catprice,
            'category'=>$cat,
            'productbranch'=>$branch
            );

         $data['print_items'] = $print_items; 
        $this->load->view('contents/prints/Category_active.php',$data);

    }
   
    public function Categinactive_results(){
        $this->load->model('core/sales_model');
        $thisval = "";
        $results = array();
        $catac1 = $this->input->post('active');
        $catinc2 = $this->input->post('inactive');
        $catai3= $this->input->post('AI');
        $catinac1= $this->input->post('category');
        $catpriceinac1 = $this->input->post('stock_location');
        $branch = $this->input->post('productbranch');
        $results = $this->sales_model->productcategorylistinginactive($catpriceinac1,$catinac1,$branch,$catac1,$catinc2,$catai3);
        $data['load_js'] = 'core/sales.php';
        $data['use_js'] = 'ClassJS';
        $data['code'] = CategoryInactive($results);
        $this->load->view('load',$data);
     }
      public function Category_inactive(){
      $catpriceinac1 =$this->input->get('stock_location');
       $branch = $this->input->get('productbranch');
       $catinac1 =$this->input->get('category');
      

        $print_items=array(

            'stock_location'=>$catpriceinac1,
            'category'=>$catinac1,
            'productbranch'=>$branch
            );

         $data['print_items'] = $print_items; 
        $this->load->view('contents/prints/Category_inactive.php',$data);

    }

    public function Categactinc(){
        $this->load->model('core/sales_model');
        $thisval = "";
        $results = array();
        $catac2 = $this->input->post('active');
        $catinc3 = $this->input->post('inactive');
        $catai4= $this->input->post('AI');
        $catactinc1 = $this->input->post('category');
        $catpriceactinc1 = $this->input->post('stock_location');
        $branch = $this->input->post('productbranch');
        $results = $this->sales_model->product_active_inactive($catpriceactinc1,$catactinc1,$branch,$catac2,$catinc3,$catai4);
        $data['load_js'] = 'core/sales.php';
        $data['use_js'] = 'ClassJS';
        $data['code'] = CategoryActinactive($results);
        $this->load->view('load',$data);
     }
     public function Category_actinactive(){
      $catpriceactinc1 =$this->input->get('stock_location');
       $branch = $this->input->get('productbranch');
       $catactinc1 =$this->input->get('category');
      

        $print_items=array(

            'stock_location'=>$catpriceactinc1,
            'category'=>$catactinc1,
            'productbranch'=>$branch
            );

         $data['print_items'] = $print_items; 
        $this->load->view('contents/prints/Category_Actinactive.php',$data);

    }
    
     public function Productcategcost_results(){
        $this->load->model('core/sales_model');
        $thisval = "";
        $results = array();
        $categCB = $this->input->post('active');
        $categCB1 = $this->input->post('inactive');
        $categCB2= $this->input->post('AI');
        $categCB3 = $this->input->post('cost');
        $categdesc = $this->input->post('category');
        $categprice = $this->input->post('stock_location');
        $branch = $this->input->post('productbranch');
        $results = $this->sales_model->productcategorycost($categprice,$categdesc,$branch,$categCB,$categCB1,$categCB2,$categCB3);
        //echo var_dump($results);
        $data['load_js'] = 'core/sales.php';
        $data['use_js'] = 'CategoryJS';
        $data['code'] = Category_cost($results);

        $this->load->view('load',$data);
     }
     public function Category_cost(){
      $categprice =$this->input->get('stock_location');
       $branch = $this->input->get('productbranch');
       $categdesc =$this->input->get('category');
      

        $print_items=array(

            'stock_location'=>$categprice,
            'category'=>$categdesc,
            'productbranch'=>$branch
            );

         $data['print_items'] = $print_items; 
        $this->load->view('contents/prints/Category_cost.php',$data);

    }
       public function ProductListingbranchdrop(){

        $branch = $this->input->post('productbranch');
        $group = $this->input->post('group');
        
        $results = $this->sales_model->ProductVendorDrop($branch,$group);
       // echo var_dump($results);
        $data['code'] = productlistingvendordrop($results,$branch);
        $data['load_js'] = "core/sales.php";
        $data['use_js'] = "PLBranchJS";
        $this->load->view('load',$data);
    }

    public function InventoryListingbranchdrop(){

        $branch = $this->input->post('branch');
        $group = $this->input->post('group');
        
        $results = $this->sales_model->ReloadSingleVendorDP($branch,$group);
       // echo var_dump($results);
        $data['code'] = productlistingvendordrop($results);
        $data['load_js'] = "core/sales.php";
        $data['use_js'] = "PLBranchJS";
        $this->load->view('load',$data);
    }
    public function ProductListingDepartmentdrop(){

        $branch = $this->input->post('branch');
        
        $results = $this->sales_model->Departmentdb($branch);
       // echo var_dump($results);
        $data['code'] = productlistingdeptdrop($results);
        $data['load_js'] = "core/sales.php";
        $data['use_js'] = "PLBranchJS";
        $this->load->view('load',$data);
    }
    public function ProductListingbranddrop(){

        $branch = $this->input->post('branch');
        
        $results = $this->sales_model->Branddb($branch);
       // echo var_dump($results);
        $data['code'] = productlistingbranddrop($results);
        $data['load_js'] = "core/sales.php";
        $data['use_js'] = "PLBranchJS";
        $this->load->view('load',$data);
    }
    public function ProductListingclassdrop(){

        $branch = $this->input->post('branch');
        
        $results = $this->sales_model->CategoryDb($branch);
       // echo var_dump($results);
        $data['code'] = productlistingclassdrop($results);
        $data['load_js'] = "core/sales.php";
        $data['use_js'] = "PLBranchJS";
        $this->load->view('load',$data);
    }
    public function ProductListingYeardrop(){

        $branch = $this->input->post('branch');
        
        $results = $this->sales_model->Yeardb($branch);
       // echo var_dump($results);
        $data['code'] = productlistingyeardrop($results);
        $data['load_js'] = "core/sales.php";
        $data['use_js'] = "PLBranchJS";
        $this->load->view('load',$data);
    }
     public function ProductListingCountrydrop(){

        $branch = $this->input->post('branch');
        
        $results = $this->sales_model->Countrydb($branch);
       // echo var_dump($results);
        $data['code'] = ProductListingCountrydrop($results);
        $data['load_js'] = "core/sales.php";
        $data['use_js'] = "PLBranchJS";
        $this->load->view('load',$data);
    }
    public function ProductListingCategdrop(){

        $branch = $this->input->post('branch');
        
        $results = $this->sales_model->CategoryNewDb($branch);
       // echo var_dump($results);
        $data['code'] = ProductListingCatdrop($results);
        $data['load_js'] = "core/sales.php";
        $data['use_js'] = "PLBranchJS";
        $this->load->view('load',$data);
    }

//================================================END=========================================================
     
#######rhan
      public function DataCenterTracker($ref=''){   
       
        $data = $this->syter->spawn('sales');
      
        $data['page_title'] = fa('fa-suitcase')."Data Center Tracker";
        $data['code'] = DataCenterTrackerForm();
        $data['add_js'] = 'js/site_list_forms.js';
        
        $data['add_css']= 'css/daterangepicker/daterangepicker-bs3.css';
        $data['add_js'] = 'js/plugins/daterangepicker/daterangepicker.js';
        $data['load_js'] = "core/sales.php";
        $data['use_js'] = "DataTrackJS";
        $this->load->view('page',$data);
     }  

      public function getDatacenter(){

        $barcode = $this->input->post('barcode');  
        $branch = $this->input->post('branch');  
        $description = $this->input->post('description');  
        $data['code'] = getDatacenterRes($barcode,$branch,$description);
        $data['load_js'] = "core/sales.php";
        $data['use_js'] = "updCsalesJs";
        $this->load->view('load',$data);
    } 
   



########FRESH SECTION TRACKER########
    
    public function FreshSectionTracker($ref=''){   
       
        $data = $this->syter->spawn('sales');
      
        $data['page_title'] = fa('fa-suitcase')."Barcode Track";
        $user = $this->session->userdata('user');
        $data['code'] = FreshSectionTrackerForm($user);
        $data['add_js'] = 'js/site_list_forms.js';
        
        $data['add_css']= 'css/daterangepicker/daterangepicker-bs3.css';
        $data['add_js'] = 'js/plugins/daterangepicker/daterangepicker.js';
        
        $data['load_js'] = "core/sales.php";
        $data['use_js'] = "FreshSectionTrackerJS";
        $this->load->view('page',$data);
     }

    public function FreshSectionTracker_results(){
        $this->load->model('core/sales_model');
        $this->session->userdata('user');
        $barcode = $this->input->post('barcode');
        $data['load_js'] = 'core/sales.php';
        $data['use_js'] = 'FreshSectionTrackerJS';
        $data['code'] = FreshSectionTracker_results($barcode);
        $this->load->view('load',$data);
     }
    public function update_srp_branch(){
        $productid = $this->input->post('productid');
        $uom = $this->input->post('uom');
        $old_srp = $this->input->post('old_srp');
        $Markup = $this->input->post('Markup');
        $srp = $this->input->post('srp');
        $branch = $this->input->post('branch');
        $main_branch = $this->input->post('main_branch');
        $barcode = $this->input->post('barcode');
        $user = $this->session->userdata('user');
        $user_name  = $user['username'];

        //branch
        $results= $this->sales_model->update_srp($srp,$Markup,$branch,$user_name,$barcode,$old_srp,$uom,$productid);
        //main
        $results_main= $this->sales_model->update_srp($srp,$Markup,$main_branch,$user,$barcode,$old_srp,$uom,$productid);
        
    }
    
    public function update_markup_branch(){
        $productid = $this->input->post('productid');
        $uom = $this->input->post('uom');
        $old_srp = $this->input->post('old_srp');
        $Markup = $this->input->post('Markup');
        $srp = $this->input->post('srp');
        $branch = $this->input->post('branch');
        $main_branch = $this->input->post('main_branch');
        $barcode = $this->input->post('barcode');
        $user = $this->session->userdata('user');
        //branch
        $results= $this->sales_model->update_markup($srp,$Markup,$branch,$user,$barcode,$old_srp,$uom,$productid);
        //main
        $results_main= $this->sales_model->update_markup($srp,$Markup,$main_branch,$user,$barcode,$old_srp,$uom,$productid);
    
    }

########FRESH SECTION TRACKER########






##############3

     public function BarcodeTracker($ref=''){   
       
        $data = $this->syter->spawn('sales');
      
        $data['page_title'] = fa('fa-suitcase')."Barcode Track";
        $data['code'] = BarcodeForm();
        $data['add_js'] = 'js/site_list_forms.js';
        
        $data['add_css']= 'css/daterangepicker/daterangepicker-bs3.css';
        $data['add_js'] = 'js/plugins/daterangepicker/daterangepicker.js';
        
        $data['load_js'] = "core/sales.php";
        $data['use_js'] = "TrackJS";
        $this->load->view('page',$data);
     }





    public function ping($host,$port=80,$timeout=1)
    {

            $fsock = fsockopen($host, $port, $errno, $errstr, $timeout);
            
            if ( ! $fsock )
            {
                     error_reporting(0);
                    return FALSE;
            }
            else
            {

                    return TRUE;
            }

    }



    public function BarcodeTracker_results(){
        $this->load->model('core/sales_model');

        $this->session->userdata('user');
        $barcode = $this->input->post('barcode');
        $data['load_js'] = 'core/sales.php';
        $data['use_js'] = 'TrackJS';
        $data['code'] = Barcode_result($barcode);
        
        $this->load->view('load',$data);
     }
    public function Barcode_results(){
        $this->load->model('core/sales_model');
        $thisval="";
        $results=array();
        $this->session->userdata('user');
        $barcode = $this->input->post('barcode');
        $branch = $this->input->post('codebranch');
        $results= $this->sales_model->get_barcode_details($barcode,$branch);
        $data['load_js'] = 'core/sales.php';
        $data['use_js'] = 'TrackJS';
        $data['code'] = Barcodepopbox_result($results);

        $this->load->view('load',$data);

    }

    // =================END========================
    
 

    // =================DROPDOWN LIST===============
   
     public function Productbranchdrop(){

        $branch = $this->input->post('branch');
        
        $results = $this->sales_model->ProductVendorDrop($branch);
       // echo var_dump($results);
        $data['code'] = vendordrop($results);
        $data['load_js'] = "core/sales.php";
        $data['use_js'] = "PLBranchJS";
        $this->load->view('load',$data);
    }

    public function Inventorybranchdrop(){

        $branch = $this->input->post('branch');
        
        $results = $this->sales_model->ReloadSingleVendorDP($branch);
       // echo var_dump($results);
        $data['code'] = vendordrop($results);
        $data['load_js'] = "core/sales.php";
        $data['use_js'] = "PLBranchJS";
        $this->load->view('load',$data);
    }
      
    public function Departmentdrop(){

        $branch = $this->input->post('branch');
        
        $results = $this->sales_model->Departmentdb($branch);
       // echo var_dump($results);
        $data['code'] = deptdrop($results);
        $data['load_js'] = "core/sales.php";
        $data['use_js'] = "PLBranchJS";
        $this->load->view('load',$data);
    }

    public function Branddrop(){

        $branch = $this->input->post('branch');
        
        $results = $this->sales_model->Branddb($branch);
       // echo var_dump($results);
        $data['code'] = branddrop($results);
        $data['load_js'] = "core/sales.php";
        $data['use_js'] = "PLBranchJS";
        $this->load->view('load',$data);
    }
    public function Countrydrop(){

        $branch = $this->input->post('branch');
        
        $results = $this->sales_model->Countrydb($branch);
       // echo var_dump($results);
        $data['code'] = Countrydrop($results);
        $data['load_js'] = "core/sales.php";
        $data['use_js'] = "PLBranchJS";
        $this->load->view('load',$data);
    }
    public function Categdrop(){

        $branch = $this->input->post('branch');
        
        $results = $this->sales_model->CategoryDb($branch);
       // echo var_dump($results);
        $data['code'] = Catdrop($results);
        $data['load_js'] = "core/sales.php";
        $data['use_js'] = "PLBranchJS";
        $this->load->view('load',$data);
    }
    public function Yeardrop(){

        $branch = $this->input->post('branch');
        
        $results = $this->sales_model->Yeardb($branch);
       // echo var_dump($results);
        $data['code'] = Yeardrop($results);
        $data['load_js'] = "core/sales.php";
        $data['use_js'] = "PLBranchJS";
        $this->load->view('load',$data);
    }
    public function Classdrop(){

        $branch = $this->input->post('branch');
        
        $results = $this->sales_model->CategoryNewDb($branch);
       // echo var_dump($results);
        $data['code'] = Catdrop1($results);
        $data['load_js'] = "core/sales.php";
        $data['use_js'] = "PLBranchJS";
        $this->load->view('load',$data);
    }

    

//====================CHARLES===============

public function generate_svendor_excel_all(){
        $daterange  = $this->input->get('daterange');
        $description = $this->input->get('description');
        $branch = $this->input->get('branch');
        $dates = explode(" to ",$daterange);
        $datefrom = (empty($dates[0]) ? date('Y-m-d') : date('Y-m-d',strtotime($dates[0])));
        $dateto = (empty($dates[1]) ? date('Y-m-d') : date('Y-m-d',strtotime($dates[1])));


        $print_items = array(
            'date_from'=>$datefrom,
            'date_to' =>$dateto,
            'description'=>$description,  
            'branch'=>$branch
        ); 

        //echo var_dump($print_items);
        
       $data['print_items'] = $print_items; 
        $this->load->view('contents/prints/print_single_vendor_all.php',$data); //full details
}



    public function generate_svendor_excel(){
        $daterange  = $this->input->get('daterange');
        $description = $this->input->get('description');
        $branch = $this->input->get('branch');
        $dates = explode(" to ",$daterange);
        $datefrom = (empty($dates[0]) ? date('Y-m-d') : date('Y-m-d',strtotime($dates[0])));
        $dateto = (empty($dates[1]) ? date('Y-m-d') : date('Y-m-d',strtotime($dates[1])));


        $print_items = array(
            'date_from'=>$datefrom,
            'date_to' =>$dateto,
            'description'=>$description,  
            'branch'=>$branch
        ); 

        //echo var_dump($print_items);
        
       $data['print_items'] = $print_items; 
        $this->load->view('contents/prints/print_single_vendor.php',$data); //full details
    }

        public function generate_avendor_excel(){
        $daterange  = $this->input->get('daterange');
        $dates = explode(" to ",$daterange);
        $branch = $this->input->get('branch');
        $datefrom = (empty($dates[0]) ? date('Y-m-d') : date('Y-m-d',strtotime($dates[0])));
        $dateto = (empty($dates[1]) ? date('Y-m-d') : date('Y-m-d',strtotime($dates[1])));

        $print_items = array(
            'date_from'=>$datefrom,
            'date_to' =>$dateto, 
            'branch'=>$branch
        ); 

        //echo var_dump($print_items);
        
       $data['print_items'] = $print_items; 
        $this->load->view('contents/prints/print_all_vendor.php',$data);//full details
    }

        public function generate_offtakeSvendor_excel(){
        $daterange  = $this->input->get('daterange');
        $description = $this->input->get('description');
        $branch = $this->input->get('branch');
        $dates = explode(" to ",$daterange);
        $datefrom = (empty($dates[0]) ? date('Y-m-d') : date('Y-m-d',strtotime($dates[0])));
        $dateto = (empty($dates[1]) ? date('Y-m-d') : date('Y-m-d',strtotime($dates[1])));

        $print_items = array(
            'date_from'=>$datefrom,
            'date_to' =>$dateto,
            'description'=>$description,
            'branch'=>$branch, 
            'daterange'=>$daterange 
          );

       $data['print_items'] = $print_items; 
        $this->load->view('contents/prints/prints_offtakeSVendor_excel.php',$data);

    }
     public function generate_offtakeAllvendor_excel(){
        $daterange  = $this->input->get('daterange');
        $branch = $this->input->get('branch');
        $dates = explode(" to ",$daterange);
        $datefrom = (empty($dates[0]) ? date('Y-m-d') : date('Y-m-d',strtotime($dates[0])));
        $dateto = (empty($dates[1]) ? date('Y-m-d') : date('Y-m-d',strtotime($dates[1])));

        $print_items = array(
            'date_from'=>$datefrom,
            'date_to' =>$dateto,
            'branch'=>$branch , 
            'daterange'=>$daterange  
        ); 


       $data['print_items'] = $print_items; 


       
        $this->load->view('contents/prints/print_offtakeAllVendor_excel.php',$data);

    }

    public function generate_Overstockvendor_excel(){
        $daterange  = $this->input->get('daterange');
        $description = $this->input->get('description');
        $branch = $this->input->get('branch');
        $dates = explode(" to ",$daterange);
        $datefrom = (empty($dates[0]) ? date('Y-m-d') : date('Y-m-d',strtotime($dates[0])));
        $dateto = (empty($dates[1]) ? date('Y-m-d') : date('Y-m-d',strtotime($dates[1])));

        $print_items = array(
            'date_from'=>$datefrom,
            'date_to' =>$dateto,
            'description'=>$description,
            'branch'=>$branch ,
            'daterange'=>$daterange
        ); 


       $data['print_items'] = $print_items; 
        $this->load->view('contents/prints/Overstock_excel.php',$data);

    }
     public function generate_AllOverstockvendor_excel(){
        $daterange  = $this->input->get('daterange');
        $branch = $this->input->get('branch');
        $dates = explode(" to ",$daterange);
        $datefrom = (empty($dates[0]) ? date('Y-m-d') : date('Y-m-d',strtotime($dates[0])));
        $dateto = (empty($dates[1]) ? date('Y-m-d') : date('Y-m-d',strtotime($dates[1])));

        $print_items = array(
            'date_from'=>$datefrom,
            'date_to' =>$dateto,
            'branch'=>$branch,
            'daterange'=>$daterange
        ); 


       $data['print_items'] = $print_items; 
        $this->load->view('contents/prints/Overstock-All.php',$data);

    }

    public function Category_excel(){
        $daterange  = $this->input->get('daterange');
        $description = $this->input->get('description');
        $branch = $this->input->get('name');
        $dates = explode(" to ",$daterange);
        $datefrom = (empty($dates[0]) ? date('Y-m-d') : date('Y-m-d',strtotime($dates[0])));
        $dateto = (empty($dates[1]) ? date('Y-m-d') : date('Y-m-d',strtotime($dates[1])));

        $print_items = array(
            'name'=>$branch,
            'date_from'=>$datefrom,
            'date_to' =>$dateto,
            'description'=>$description  
        ); 


       $data['print_items'] = $print_items; 
        $this->load->view('contents/prints/Category_excel.php',$data);

    }

     public function Smart_exportAll(){

        $daterange  = $this->input->get('daterange');
        $dates = explode("to",$daterange);
        $datefrom = (empty($dates[0]) ? date('Y-m-d') : date('Y-m-d',strtotime($dates[0])));
        $dateto = (empty($dates[1]) ? date('Y-m-d') : date('Y-m-d',strtotime($dates[1])));

        $print_items = array(
            'date_from'=>$datefrom,
            'date_to' =>$dateto 
        ); 


       $data['print_items'] = $print_items; 
        $this->load->view('contents/prints/Smart_exportAll.php',$data);
    }

     public function Special_exportAll(){

        $daterange  = $this->input->get('daterange');
        $br  = $this->input->get('br');
        $dates = explode("to",$daterange);
        $datefrom = (empty($dates[0]) ? date('Y-m-d') : date('Y-m-d',strtotime($dates[0])));
        $dateto = (empty($dates[1]) ? date('Y-m-d') : date('Y-m-d',strtotime($dates[1])));

        $print_items = array(
            'date_from'=>$datefrom,
            'date_to' =>$dateto,
            'br' =>$br 
        ); 


       $data['print_items'] = $print_items; 
        $this->load->view('contents/prints/Special_Fresh_exportAll.php',$data);
    }






     public function Category_exportAll(){
       // $this->load->library('zip');
        $daterange  = $this->input->get('daterange');
        //$description = $this->input->get('description');
        $branch = $this->input->get('name');
        $dates = explode(" to ",$daterange);
        $datefrom = (empty($dates[0]) ? date('Y-m-d') : date('Y-m-d',strtotime($dates[0])));
        $dateto = (empty($dates[1]) ? date('Y-m-d') : date('Y-m-d',strtotime($dates[1])));

        $print_items = array(
            'name'=>$branch,
            'date_from'=>$datefrom,
            'date_to' =>$dateto,
           // 'description'=>$description  
        ); 


       $data['print_items'] = $print_items; 
        $this->load->view('contents/prints/Category_exportAll.php',$data);
    }



     public function Category_smart_exportAll(){
       // $this->load->library('zip');
        $daterange  = $this->input->get('daterange');
        $branch = $this->input->get('name');
        $dates = explode(" to ",$daterange);
        $datefrom = (empty($dates[0]) ? date('Y-m-d') : date('Y-m-d',strtotime($dates[0])));
        $dateto = (empty($dates[1]) ? date('Y-m-d') : date('Y-m-d',strtotime($dates[1])));

        $print_items = array(
            'name'=>$branch,
            'date_from'=>$datefrom,
            'date_to' =>$dateto,
           // 'description'=>$description  
        ); 


       $data['print_items'] = $print_items; 
        $this->load->view('contents/prints/smart_export.php',$data);
    }


    




     public function Category_share(){
        $daterange  = $this->input->get('daterange');
        $description = $this->input->get('description');
        $branch = $this->input->get('name');
        $dates = explode(" to ",$daterange);
        $datefrom = (empty($dates[0]) ? date('Y-m-d') : date('Y-m-d',strtotime($dates[0])));
        $dateto = (empty($dates[1]) ? date('Y-m-d') : date('Y-m-d',strtotime($dates[1])));

        $print_items = array(
            'name'=>$branch,
            'date_from'=>$datefrom,
            'date_to' =>$dateto,
            'description'=>$description  
        ); 


       $data['print_items'] = $print_items; 
        $this->load->view('contents/prints/Category_shares.php',$data);

    }



///////////////////////////////wakollllllll
    public function productlisting_excel_active(){
       $pricemode =$this->input->get('stock_location');
       $branch = $this->input->get('productbranch');
       $department=$this->input->get('venda');
      $chckbox=$this->input->get('active');
       $chckbox1=$this->input->get('inactive');
        $chckbox2=$this->input->get('AI');

        $print_items=array(

            'stock_location'=>$pricemode,
            'productbranch'=>$branch,
            'venda'=>$department
            );

         $data['print_items'] = $print_items; 
        $this->load->view('contents/prints/productlisting_excel.php',$data);

    }
    public function productlisting_excel_inactive(){
       $priceinac =$this->input->get('stock_location');
       $branch = $this->input->get('productbranch');
       $costdesinac=$this->input->get('venda');
      

        $print_items=array(

            'stock_location'=>$priceinac,
            'venda'=>$costdesinac,
            'productbranch'=>$branch
            );

         $data['print_items'] = $print_items; 
        $this->load->view('contents/prints/productlisting_inactive.php',$data);

    }
    public function productlisting_excel_Actinact(){
       $priceinac =$this->input->get('stock_location');
       $branch = $this->input->get('productbranch');
       $costdesinac=$this->input->get('venda');
      

        $print_items=array(

            'stock_location'=>$priceinac,
            'venda'=>$costdesinac,
            'productbranch'=>$branch
            );

         $data['print_items'] = $print_items; 
        $this->load->view('contents/prints/Product_ActInac.php',$data);

    }
    public function Product_Cost(){
       $pricecost =$this->input->get('stock_location');
       $branch = $this->input->get('productbranch');
       $costdesinac=$this->input->get('venda');
      

        $print_items=array(

            'stock_location'=>$pricecost,
            'venda'=>$costdesinac,
            'productbranch'=>$branch
            );

         $data['print_items'] = $print_items; 
        $this->load->view('contents/prints/Cost_Product.php',$data);

    }

	//--------------------- DAN ------------------------//
    public function ProductHistory($ref=''){
        $this->load->model('core/sales_model');
        $this->load->helper('core/sales_helper');
        $this->load->helper('site/site_forms_helper');
        $data = $this->syter->spawn('sales');
        $data['page_title'] = fa('fa-cube')."Product History";
        $data['code'] = ProductHistory();
        $data['load_js'] = "core/sales.php";
        $data['use_js'] = "ProductHistory";
        $this->load->view('page',$data);
     }

         public function ProductHistoryOutput(){
        $this->load->model('core/sales_model');
        $this->load->helper('core/sales_helper');
        $this->load->helper('site/site_forms_helper');

        $data = $this->syter->spawn('sales');
        $user = $this->session->userdata('user');
        $user_id = $user['id'];
        $branch = $this->input->post('branch');
        $data['page_title'] = fa('fa-database')."Product History";
        $results  = $this->sales_model->GetProductHistory($branch);
        $items = array();
        if ($results){
            $items = $results;
        }

        $data['code'] = ProductHistoryOutput($items,$branch);
        $data['add_js'] = 'js/site_list_forms.js';
        $data['add_css']= 'css/daterangepicker/daterangepicker-bs3.css';
        $data['add_js'] = 'js/plugins/daterangepicker/daterangepicker.js';
        $data['load_js'] = "core/sales.php";
        $data['use_js'] = "ProductHistory";
        $this->load->view('load',$data);
     }

     public function ProductHistorySearch(){
        $this->load->model('core/sales_model');
        $this->load->helper('core/sales_helper');
        $this->load->helper('site/site_forms_helper');

        $branch_input = $this->input->post('branch_input');
		$branch_input = ltrim($branch_input);
		$branch_input = rtrim($branch_input);		
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
        $user = $this->session->userdata('user');
        $user_id = $user['id'];
        $results  = $this->sales_model->ProductHistoryGetViewData($branch_input,$description,$barcode,$fdate,$tdate);
        $items = array();
        if ($results){
            $items = $results;
        }

        $data['code'] = ProductHistorySearch($items,$branch_input);
        $data['add_js'] = 'js/site_list_forms.js';
        $data['add_css']= 'css/daterangepicker/daterangepicker-bs3.css';
        $data['add_js'] = 'js/plugins/daterangepicker/daterangepicker.js';
        $data['load_js'] = "core/sales.php";
        $data['use_js'] = "ProductHistory";
        $this->load->view('load',$data);
     }

     public function ProductHistoryButton($id,$branch_view){
        $this->load->model('core/sales_model');
        $this->load->helper('core/sales_helper');
        $this->load->helper('site/site_forms_helper');

        $data = $this->syter->spawn('sales');
        $user = $this->session->userdata('user');
        $user_id = $user['id'];
        $data['page_title'] = fa('fa-database')."Product History";
        $results  = $this->sales_model->ProductHistoryViewDataDisplay($id,$branch_view);
        $items = array();
        if ($results){
            $items = $results;
        }

        $data['code'] = ProductHistoryButton($items);
        $data['add_js'] = 'js/site_list_forms.js';
        $data['add_css']= 'css/daterangepicker/daterangepicker-bs3.css';
        $data['add_js'] = 'js/plugins/daterangepicker/daterangepicker.js';
        $data['load_js'] = "core/sales.php";
        $data['use_js'] = "ProductHistory";
        $this->load->view('load',$data);
     }

     //babalikan
     public function ViewMarkupButton($id,$branch_view){
        $this->load->model('core/sales_model');
        $this->load->helper('core/sales_helper');
        $this->load->helper('site/site_forms_helper');

        $data = $this->syter->spawn('sales');
        $user = $this->session->userdata('user');
        $user_id = $user['id'];
        $results  = $this->sales_model->ViewMarkupDisplay($id,$branch_view);
        $items = array();
        if ($results){
            $items = $results;
        }

        $data['code'] = ViewMarkupButton($items);
        $data['add_js'] = 'js/site_list_forms.js';
        $data['add_css']= 'css/daterangepicker/daterangepicker-bs3.css';
        $data['add_js'] = 'js/plugins/daterangepicker/daterangepicker.js';
        $data['load_js'] = "core/sales.php";
        $data['use_js'] = "ProductHistory";
        $this->load->view('load',$data);
     }

     public function ViewTN(){
        $this->load->model('core/sales_model');
        $this->load->helper('core/sales_helper');
        $this->load->helper('site/site_forms_helper');

        $data = $this->syter->spawn('sales');
        $user = $this->session->userdata('user');
        $user_id = $user['id'];
        $id = $_POST['id'];
        $branch_view = $_POST['branch_view'];
        $results  = $this->sales_model->ViewTN($id,$branch_view);
        $items = array();
        if ($results){
            $items = $results;
        }

        $data['code'] = ViewTN($items);
        $data['add_js'] = 'js/site_list_forms.js';
        $data['add_css']= 'css/daterangepicker/daterangepicker-bs3.css';
        $data['add_js'] = 'js/plugins/daterangepicker/daterangepicker.js';
        $data['load_js'] = "core/sales.php";
        $data['use_js'] = "ProductHistory";
        $this->load->view('load',$data);
     }
     
     public function PrintProductHistory($branch_view){
        $this->load->model('core/sales_model');
        $this->load->helper('core/sales_helper');
        $this->load->helper('site/site_forms_helper');

        $branch_view = $this->input->get('branch_view');
        $description = $this->input->get('description');
        $barcode = $this->input->get('barcode');
        $fdate = $this->input->get('fdate');
        $tdate = $this->input->get('tdate');

        $print_items = array('branch_view' => $branch_view,
                             'description' => $description,
                             'barcode'     => $barcode,
                             'fdate'       => $fdate,
                             'tdate'       => $tdate);
        $data['print_items'] = $print_items;
        $this->load->view('contents/prints/print_product_history.php',$data);
     }
	//--------------------- DAN ------------------------//


     /*   public function productlisting_excel_inactive(){
       $pricemode =$this->input->get('stock_location');
       $branch = $this->input->get('productbranch');
       $department=$this->input->get('venda');


        $print_items=array(

            'stock_location'=>$pricemode,
            'productbranch'=>$branch,
            'venda'=>$department
            );

         $data['print_items'] = $print_items; 
        $this->load->view('contents/prints/productlisting1_excel.php',$data);

    }
*/



    //full details
    // public function sample_excel_report(){



    //     $vendorcode = $this->input->get('vendorcode');
    //     $descr = $this->input->get('description');
    //     $address =$this->input->get('address');
    //     $print_items = array(
    //         'vendorcode'=>$vendorcode,
    //         'description'=>$description,
    //         'address'=>$address
    //     );
        
    //   $data['print_items'] = $print_items
      
    //   $this->load->view('contents/prints/print_customers.php',$data); //full details
    // }

    // public function generate_reports($id = null){
    //     $user = $this->session->userdata('user');
        
    //     date_default_timezone_set('Asia/Manila');
    //     $this->load->library('My_TCPDF');
    //     $CI =& get_instance();
    
    //     $pdf = new TCPDF("L", PDF_UNIT, 'Folio', false, 'UTF-8', false);
    //     $filename = "Sales Reports.pdf";
    //     $title = "Sales Reports ";
        
    //     $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    //     $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTO0M);
    //     $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    //     $pdf->SetFooterMargin(PDF_MARGIN_BOTTOM);
    //     $pdf->setPrintHeader(false);
    //     $pdf->setPrintFooter(true);
        
    //     $results = $this->sales_model->singlevendor($id);
    //     $this_item = $results[0];
    //     $logo = BASEPATH.'../img/header_logo.png';
    //     $no = 0;
    //     $total = 0;
    //     $pdf->AddPage();
        
    //     $pdf->SetFont('helvetica', '', 35);
            
    //         $payreg_content = "
    //     <table width=\"100%\" cellpadding=\"1px\" border=\"0px\">
    //         <tr>
    //             <td width=\"20%\">
    //                 <img src=\"$logo\" style=\"width:150px;height:75px;\">
    //             </td>
    //             <td width=\"80%\">
    //                 <table width=\"100%\" cellpadding=\"30px\" border=\"0px\">
    //                     ";
        
    //         $payreg_content .= "
    //                 </table>
    //             </td>
    //         </tr>
    //     </table>
    //     ";
    //         $pdf->writeHTML($payreg_content,true,false,false,false,'');
            
    //     $content = "
    //     <table width=\"70%\" cellpadding=\"3px\" border=\"0px\">";
    //         $content .="<tbody>";
    //         $content .= "<tr>
    //             <td width=\"20%\" style=\"text-align:left; font-size:15px;\"><b>Date:</b></td>
    //             <td  style=\"text-align:center; font-size:15px;\">".date('F j, Y', strtotime($this_item->datefrom))." to ".date('F j, Y', strtotime($this_item->dateto))."</td>
    //         </tr>";

    //         $content .= "<tr>
    //             <td width=\"32%\" style=\"text-align:left; font-size:15px;\"><b>With Suki Card:</b></td>
    //             <td  style=\"text-align:right; font-size:15px;\"><b>".number_format($this_item->suki_card_sales, 2)."</b></td>
    //         </tr>";
    //         $content .= "<tr>
    //             <td width=\"32%\" style=\"text-align:left; font-size:15px;\">Retained Customers:</td>
    //             <td  style=\"text-align:right; font-size:15px;\">".number_format($this_item->retained_customers, 2)."</td>
    //         </tr>";
    //         $content .= "<tr>
    //             <td width=\"32%\" style=\"text-align:left; font-size:15px;\">Reactivated Customers:</td>
    //             <td  style=\"text-align:right; font-size:15px;\">".number_format($this_item->reactivated_customers, 2)."</td>
    //         </tr>";
    //         $content .= "<tr>
    //             <td width=\"32%\" style=\"text-align:left; font-size:15px;\">New Applied Customers:</td>
    //             <td  style=\"text-align:right; font-size:15px;\">".number_format($this_item->new_applied_customers, 2)."</td>
    //         </tr>";
    //         $total = $this_item->new_applied_customers + $this_item->reactivated_customers + $this_item->retained_customers;
            
    //         $content .= "<tr>
    //             <td width=\"32%\" style=\"text-align:left; font-size:15px;\"><b>Total:</b></td>
    //             <td  style=\"text-align:right; font-size:15px;\"><b>".number_format($total, 2)."</b></td>
    //         </tr>";
    //         $content .= "<tr>
    //             <td width=\"32%\" style=\"text-align:left; font-size:15px;\"><b>Non Suki Card:</b></td>
    //             <td  style=\"text-align:right; font-size:15px;\"><b>".number_format($this_item->non_suki_card_sales, 2)."</b></td>
    //         </tr>";
    //         $content .= "</tbody></table>";
        
    //     $pdf->writeHTML($content,true,false,false,false,'');
    //         $pdf->Output($filename, 'I');

    // }

      

//======================END=================

}
   
    // public function sales_orders(){
    //      $this->load->model('core/sales_model');
    //      $this->load->helper('core/sales_helper');
    //      $this->load->helper('site/site_forms_helper');
    //      $sales_order = $this->sales_model->get_sales_order_header();
    //      $data = $this->syter->spawn('sales');
    //      $data['code'] = site_list_form("sales/sales_order_form","sales_order_form","Sales Orders",$sales_order,array('role'),"id");
    //      $data['code'] = salesOrderForm($sales_order);
    //      $data['add_js'] = 'js/site_list_forms.js';
    //         $this->load->view('page',$data);
    // }
    // public function sales_order_form($ref=null){
        // $this->load->helper('core/sales_helper');
        // $this->load->model('core/sales_model');
        // $sale = array();
        // $access = array();
        // if($ref != null){
            // $sales = $this->sales_model->get_sales_order_header($ref);
            // $sale = $sales[0];
            // $access = explode(',',$role->access);
        // }
        // $navs = $this->syter->get_navs();
        // $this->data['code'] = salesOrderForm($role,$access,$navs);
        // $this->data['load_js'] = 'site/admin';
        // $this->data['use_js'] = 'rolesJs';
        // $this->load->view('load',$this->data);
    // }
    // function newSOForm(){
        // $this->load->helper('core/sales_helper');
        // $this->load->model('core/sales_model');
        // $data = $this->syter->spawn('trans');
        // $data['page_title'] = "New Sales Order Entry";

        // $data['code'] = soFormPage();
        // // $data['add_css'] = 'js/plugins/typeaheadmap/typeaheadmap.css';
        // // $data['add_js'] = array('js/plugins/typeaheadmap/typeaheadmap.js');
        // // $data['load_js'] = 'dine/receive.php';
        // // $data['use_js'] = 'receiveJs';
        // $this->load->view('page',$data);
    // }
    
    //********************Sales Persons*****Allyn*****start
//     public function sales_persons(){
//         $this->load->model('core/sales_model');
//         $this->load->helper('site/site_forms_helper');
//         $sp_list = $this->sales_model->get_sales_persons();
//         $data = $this->syter->spawn('sales_persons');
//         $data['code'] = site_list_form("sales/sales_persons_form","sales_persons_form","Sales Persons",$sp_list,array('name'),"sales_person_id");
//         $data['add_js'] = 'js/site_list_forms.js';
//         $this->load->view('page',$data);
//     }
//     public function sales_persons_form($ref=null){
//         $this->load->helper('core/sales_helper');
//         $this->load->model('core/sales_model');
//         $sales_person = array();
//         $access = array();
//         if($ref != null){
//             $sales_persons = $this->sales_model->get_sales_persons($ref);
//             $sales_person = $sales_persons[0];
//         }

//         $this->data['code'] = salesPersonsForm($sales_person);
//          // $this->data['load_js'] = 'site/admin';
//         // $this->data['use_js'] = 'paymentTermsJs';
//         $this->load->view('load',$this->data);
//     }
//     public function sales_persons_db(){
//         $this->load->model('core/sales_model');

//         $inactive_val = 0;
//         if($this->input->post('inactive') == '' || $this->input->post('inactive') == 0)
//             $inactive_val = 0;
//         else
//             $inactive_val = 1;

//         $items = array(
//             "name"=>$this->input->post('name'),
//             "phone"=>$this->input->post('phone'),
//             "fax"=>$this->input->post('fax'),
//             "email"=>$this->input->post('email'),
//             "break_pt"=>($this->input->post('break_pt') ? $this->input->post('break_pt') : 0),
//             "provision_1"=>($this->input->post('provision_1') ? $this->input->post('provision_1') : 0),
//             "provision_2"=>($this->input->post('provision_2') ? $this->input->post('provision_2') : 0),
//             "inactive"=>$inactive_val
//         );

//         if($this->input->post('sales_person_id')){
//             $this->sales_model->update_sales_persons($items,$this->input->post('sales_person_id'));
//             $id = $this->input->post('sales_person_id');
//             $act = 'update';
//             $msg = 'Updated Sales Person : '.$this->input->post('name');
//         } else{
//             $id = $this->sales_model->add_sales_persons($items);
//             $act = 'add';
//             $msg = 'Added Sales Person : '.$this->input->post('name');
//         }

//         echo json_encode(array("id"=>$id, "desc"=>$this->input->post('name'),"act"=>$act,'msg'=>$msg));
//     }
//     //********************Sales Persons*****Allyn*****end
//     //********************Credit Status*****Allyn*****start
//     public function credit_status(){
//         $this->load->model('core/sales_model');
//         $this->load->helper('site/site_forms_helper');
//         $sp_list = $this->sales_model->get_credit_status();
//         $data = $this->syter->spawn('credit_status');
//         $data['code'] = site_list_form("sales/credit_status_form","credit_status_form","Credit Status",$sp_list,array('description'),"credit_status_id");
//         $data['add_js'] = 'js/site_list_forms.js';
//         $this->load->view('page',$data);
//     }
//     public function credit_status_form($ref=null){
//         $this->load->helper('core/sales_helper');
//         $this->load->model('core/sales_model');
//         $cs = array();
//         $access = array();
//         if($ref != null){
//             $credit_status = $this->sales_model->get_credit_status($ref);
//             $cs = $credit_status[0];
//         }

//         $this->data['code'] = creditStatusForm($cs);
//          // $this->data['load_js'] = 'site/admin';
//         // $this->data['use_js'] = 'paymentTermsJs';
//         $this->load->view('load',$this->data);
//     }
//     public function credit_status_db(){
//         $this->load->model('core/sales_model');

//         $items = array(
//             "status_code"=>$this->input->post('status_code'),
//             "description"=>$this->input->post('description'),
//             "disallow_invoice"=>(int)$this->input->post('disallow_invoice'),
//             "inactive"=>(int)$this->input->post('inactive')
//         );

//         if($this->input->post('credit_status_id')){
//             $this->sales_model->update_credit_status($items,$this->input->post('credit_status_id'));
//             $id = $this->input->post('credit_status_id');
//             $act = 'update';
//             $msg = 'Updated Credit Status : '.$this->input->post('description');
//         } else{
//             $id = $this->sales_model->add_credit_status($items);
//             $act = 'add';
//             $msg = 'Added Credit Status : '.$this->input->post('description');
//         }

//         echo json_encode(array("id"=>$id, "desc"=>$this->input->post('description'),"act"=>$act,'msg'=>$msg));
//     }
//     //********************Credit Status*****Allyn*****end
//     //********************Jed sales type**********
//     public function sales_type(){
//         $this->load->model('core/sales_model');
//         $this->load->helper('site/site_forms_helper');
//         $type_list = $this->sales_model->get_sales_type();
//         $data = $this->syter->spawn('sales_type');
//         $data['code'] = site_list_form("sales/sales_type_form","sales_type_form","Sales Type",$type_list,array('sales_type'),"id");
//         $data['add_js'] = 'js/site_list_forms.js';
//         $this->load->view('page',$data);
//     }
//     public function sales_type_form($ref=null){
//         $this->load->helper('core/sales_helper');
//         $this->load->model('core/sales_model');
//         $sales_type = array();
//         $access = array();
//         if($ref != null){
//             $sales_types = $this->sales_model->get_sales_type($ref);
//             $sales_type = $sales_types[0];
//         }

//         $this->data['code'] = salesTypeForm($sales_type);
//         $this->data['load_js'] = 'core/sales';
//         $this->data['use_js'] = 'salesTypeJS';
//         $this->load->view('load',$this->data);
//     }
//     public function sales_type_db(){
//         $this->load->model('core/sales_model');

//         if($this->input->post('tax_included') != null){
//             $tax_included = 1;
//         }else{
//             $tax_included = 0;
//         }


//         $items = array(
//             "sales_type"=>$this->input->post('sales_type'),
//             "tax_included"=>$tax_included
//         );

//         if($this->input->post('id')){
//             $this->sales_model->update_sales_type($items,$this->input->post('id'));
//             $id = $this->input->post('id');
//             $act = 'update';
//             $msg = 'Updated Sales Type : '.$this->input->post('sales_type');
//         } else{
//             $id = $this->sales_model->add_sales_type($items);
//             $act = 'add';
//             $msg = 'Added Sales Type : '.$this->input->post('sales_type');
//         }

//         echo json_encode(array("id"=>$id, "desc"=>$this->input->post('sales_type'),"act"=>$act,'msg'=>$msg));
//     }//********************SO Entry*****Allyn*****start
//     public function get_customer_branches($cust_id = null)
//     {
//         $results = $this->site_model->get_custom_val('debtor_branches',
//             array('debtor_branch_id,branch_name,branch_address'),
//             (is_null($cust_id) ? null : 'debtor_id'),
//             (is_null($cust_id) ? null : $cust_id),
//             true);
//         $echo_array = $branch_array = array();
//         foreach ($results as $val) {
//             // $echo_array[$val->debtor_branch_id] = $val->branch_name;
//             $echo_array[] = array(
//                 'id'      => $val->debtor_branch_id,
//                 'name'    => $val->branch_name,
//                 'address' => $val->branch_address,
//                 );
//         }
//         echo json_encode($echo_array);
//     }
//     public function sales_order_form($so_id=null){
//         $this->load->model('core/sales_model');
//         $this->load->helper('core/sales_helper');

//         $data = $this->syter->spawn('sales_order_entry');
//         $data['page_title'] = "Sales Order Entry";

//         $data['code'] = salesOrderHeaderPage($so_id);
//         $data['add_css'] = array('css/wizard-steps/jquery.steps.css');
//         $data['add_js'] = array('js/plugins/wizard-steps/jquery.steps.js');
//         $data['load_js'] = 'core/sales.php';
//         $data['use_js'] = 'salesOrderHeaderJS';
//         $this->load->view('page',$data);
//     }
//     public function details_load($so_id=null){
//         $this->load->model('core/sales_model');
//         $this->load->helper('core/sales_helper');
//         $so=array();
//         if($so_id != null){
//             $sos = $this->sales_model->get_so_header($so_id);
//             if ($sos) $so=$sos[0];
//             else $so_id = null;
//         }

//         $next_ref = $this->site_model->get_next_ref(SALES_ORDER);
//         $reference = $next_ref->next_ref;

//         $data['code'] = soHeaderDetailsLoad($so,$so_id,$reference);
//         $data['load_js'] = 'core/sales.php';
//         $data['use_js'] = 'soHeaderDetailsLoadJs';
//         $this->load->view('load',$data);
//     }
//    public function so_header_details_db(){
//              $this->load->model('core/sales_model');
//              $next_ref = $this->site_model->get_next_ref(SALES_ORDER);
//              $type_no = $next_ref->next_type_no;
//              $reference = ($this->input->post('reference') ? $this->input->post('reference') : $next_ref->next_ref);

//              $reference = $this->site_model->check_duplicate_ref(SALES_ORDER,$reference);

//           $user = $this->session->userdata('user');

//              $items = array(
//                  "trans_type"=>SALES_ORDER,
//                  "debtor_id"=>$this->input->post('debtor_id'),
//                  //"debtor_branch_id"=>(int)$this->input->post('debtor_branch_id') ? : null ,
//                  "type_no"=>$type_no,
//                  "order_date"=>date2Sql($this->input->post('order_date')),
//                  "sales_type"=>(int)$this->input->post('sales_type'),
//                  "customer_ref"=>$this->input->post('customer_ref'),
//                  "from_loc"=>$this->input->post('from_loc'),
//                  "deliver_to"=>$this->input->post('deliver_to'),
//                  "delivery_address"=>$this->input->post('delivery_address'),
//                  "delivery_date"=>date2Sql($this->input->post('delivery_date')),
//                  "remarks"=>$this->input->post('remarks'),
//                  "shipper_id"=>$this->input->post('shipper_id'),
//                   "shipping_cost"=>$this->input->post('shipping_cost'),
//                     'person_id' => $user['id'],
//                   "inactive"=>(int)$this->input->post('inactive'),
//                   "cost"=>$this->input->post('cost')
//              );
//               echo var_dump($items);
//             if($this->input->post('form_mod_id')){
//                  $this->sales_model->update_so_header($items,$this->input->post('form_mod_id'));
//                  $id = $this->input->post('form_mod_id');
//                  $act = 'update';
//                   $msg = 'Updated Sales Order Details '.$this->input->post('name');
//                  $msg = 'Updated Sales Order Details ';
//              }else{
//                  $items['reference'] = $reference;
//                 $id = $this->sales_model->add_so_header($items);

//                  $refs = array(
//                      'trans_type' => SALES_ORDER,
//                      'type_no' => $type_no,
//                      'reference' => $reference
//                      );

//                  $this->site_model->add_trans_ref($refs);
//              $act = 'add';
//              $msg = 'Added new Sales Order ';
//          }

//          site_alert($msg,'success');

//          echo json_encode(array("id"=>$id,"desc"=>'',"act"=>$act,'msg'=>$msg));
//      }
//     public function so_items_load($so_id=null){
//         $this->load->model('core/sales_model');
//         $this->load->helper('core/sales_helper');
//         $details = $this->sales_model->get_so_items(null,$so_id);

//         $sos = $this->sales_model->get_so_header($so_id);
//         $so=$sos[0];

//         $data['code'] = soItemsLoad($so_id,$details,$so);
//         $data['load_js'] = 'core/sales.php';
//         $data['use_js'] = 'soItemsLoadJs';
//         $this->load->view('load',$data);
//     }
//     public function search_items(){
//         $search = $this->input->post('search');
//         $this->load->model('core/sales_model');
//         $found = $this->sales_model->search_items($search);
//         $items = array();
//         if(count($found) > 0 ){
//             foreach ($found as $res) {
//                 $items[] = array('key'=>$res->item_code." ".$res->name,'value'=>$res->id);
//             }
//         }
//         echo json_encode($items);
//     }
//     public function get_item_details($item_id=null,$asJson=true){
//         $json = array();
//         $items = $this->sales_model->get_item($item_id);
//         $item = $items[0];

//         $json['item_id'] = $item->id;
//         $json['uom'] = $item->uom_id;
//         $json['price'] = $item->sales_price;

//    $this->load->model('core/inventory_model');
//         $qoh = $this->inventory_model->get_item_qoh($item->id);
//         $json['qoh'] = $qoh->qoh;

//         $where = array('uom_id'=>$item->uom_id);
//         $uoms = $this->sales_model->get_details($where,'uoms');

//         $opts = array();
//         $opts[$uoms[0]->name] = $uoms[0]->name;
//         // if($item->no_per_pack > 0)
//         //     $opts['Pack(@'.$item->no_per_pack.' '.$item->uom.')'] = $item->uom."-".'pack-'.$item->no_per_pack;
//         // if($item->no_per_case > 0)
//         //     $opts['Case(@'.$item->no_per_case.' Packs)'] = $item->uom."-".'case-'.$item->no_per_case;

//         $json['opts'] =  $opts;
//         // $json['ppack'] = $item->no_per_pack;
//         // $json['pcase'] = $item->no_per_case;
//         echo json_encode($json);
//     }
//     public function so_items_db(){
//         $this->load->model('core/sales_model');
//         $line_total=0;
//         $percent_dec_val = $disc_val = $disc_price = 0;
//         $so_id = $this->input->post('so_id');
//         $item_id = $this->input->post('item-id');
//         // $gotItem = $this->sales_model->get_so_items(null,$so_id,$item_id);
//         $line_total = $this->input->post('unit_price')*$this->input->post('qty_delivered');

//         $percent_dec_val = $this->input->post('discount_percentage')/100;
//         $disc_val = $line_total*$percent_dec_val;
//         $disc_price = $line_total-$disc_val;

//         $items = array(
//             "order_no"=>$so_id,
//             "stock_id"=>$item_id,
//             "uom_id"=>$this->input->post('item-uom'),
//             "qty"=>$this->input->post('qty_delivered'),
//             // "qty_delivered"=>$this->input->post('qty_delivered'),
//             "unit_price"=>$this->input->post('unit_price'),
//             "discount_percentage"=>$this->input->post('discount_percentage'),
//             "stock_category"=>$this->input->post('stock_category'),
//             "line_total"=>$disc_price,
//         );
//         if ($this->input->post('client_code'))
//             $items['client_code'] = $this->input->post('client_code');
//         // if(count($gotItem) > 0){
//             // $det = $gotItem[0];
//             // $this->mods_model->update_so_item($items,$det->mod_recipe_id);
//             // $id = $det->mod_recipe_id;
//             // $act = "update";
//             // $msg = "Updated Item ".$this->input->post('item-search');
//         // }else{
//             $id = $this->sales_model->add_so_item($items);
//             $act = "add";
//             // $msg = "Added New Item ".$this->sales_model->item_name_with_code($item_id);
//             $msg = "Added New Item ".$this->sales_model->item_name($item_id);
//             // $msg = "Added New Item ";
//         // }
//         $this->make->sRow(array('id'=>'row-'.$id));
//             // $this->make->td($this->sales_model->item_name_with_code($item_id));
//             $this->make->td($this->input->post('stock_category'));
//             $this->make->td($this->sales_model->item_name($item_id));
//             $this->make->td(num($this->input->post('qty_delivered')));
//             $this->make->td(num($this->input->post('unit_price')));
//             $this->make->td($this->input->post('discount_percentage'));
//             $this->make->td(num($disc_price));
//             $a = $this->make->A(fa('fa-trash-o fa-fw fa-lg'),'#',array('id'=>'del-'.$id,'return'=>true));
//             $this->make->td($a);
//         $this->make->eRow();
//         $row = $this->make->code();

//         $echo_array = array('row'=>$row,'msg'=>$msg,'act'=>$act,'id'=>$id);
//         if ($this->input->post('discount_percentage') > DISCOUNT_THRESHOLD)
//             $echo_array['underpriced_msg'] = "Item added is underpriced. Sales Order subjected for approval.";

//         echo json_encode($echo_array);
//     }
//     public function show_add_non_stock_item($stock_id)
//     {
//         $this->make->sForm('sales/non_stock_so_items_db',array('id'=>'frm-non-stock'));
//             $this->make->hidden('order_no',$stock_id);
//             $this->make->hidden('stock_category',LOCAL_ITEM);
//             $this->make->sDivRow();
//                 $this->make->sDivCol(6);
//                     $this->make->select(
//                                 'Hardware item',
//                                 'hd_item_code',
//                                 null,
//                                 null,
//                                 array(
//                                     'class'=>'selectpicker with-ajax',
//                                     'data-live-search'=>"true"
//                                 )
//                             );
//                 $this->make->eDivCol();
//             $this->make->eDivRow();
//             $this->make->sDivRow();
//                 $this->make->sDivCol(6);
//                     $this->make->sDivRow();
//                         $this->make->sDivCol(9);
//                             $this->make->input('Item code','item_code',null,'Type item code',array('class'=>'rOkay'));
//                         $this->make->eDivCol();
//                     $this->make->eDivRow();
//                     $this->make->sDivRow();
//                         $this->make->sDivCol();
//                             $this->make->input('Item name','name',null,'Type item name',array('class'=>'rOkay','maxlength'=>'50'));
//                             $this->make->textarea('Description','description','','Description',array('style'=>'resize:vertical;','maxlength'=>'255'));
//                             $this->make->taxTypeDrop('Tax type','item_tax_type','',null,array('class'=>'rOkay'));
//                         $this->make->eDivCol();
//                     $this->make->eDivRow();
//                 $this->make->eDivCol();
//                 $this->make->sDivCol(6);
//                     $this->make->sDivRow();
//                         $this->make->sDivCol(6);
//                             $this->make->decimal('Quantity on hand','qoh',null,null,2,array('class'=>'numbers-only input_form this_qty','readOnly'=>'readOnly'));
//                         $this->make->eDivCol();
//                         $this->make->sDivCol(6);
//                             $this->make->inventoryLocationsDrop('Location','loc_code','PHP',null,array('readOnly'=>'readOnly'));
//                         $this->make->eDivCol();
//                     $this->make->eDivRow();

//                     $this->make->sDivRow();
//                         $this->make->sDivCol(6);
//                             $this->make->decimal('Quantity','qty_delivered',null,null,2,array('class'=>'rOkay numbers-only input_form this_qty'));
//                         $this->make->eDivCol();
//                         $this->make->sDivCol(6);
//                             $this->make->uomDrop('Unit of Measure','uom_id',null,null,array('class'=>'rOkay input_form'));
//                         $this->make->eDivCol();
//                     $this->make->eDivRow();

//                     $this->make->sDivRow();
//                         $this->make->sDivCol(6);
//                             $this->make->decimal('Price','unit_price','0.00',null,2,array('class'=>'rOkay numbers-only input_form'));
//                         $this->make->eDivCol();
//                         $this->make->sDivCol(6);
//                             $this->make->decimal('Discount','discount_percentage','0.00',null,2,array('class'=>'rOkay numbers-only input_form'),'','%');
//                         $this->make->eDivCol();
//                     $this->make->eDivRow();

//                     $this->make->sDivRow();
//                         $this->make->sDivCol();
//                             $this->make->input('Client code','client_code','',null,array('class'=>'rOkay input_form','maxlength'=>20),'');
//                         $this->make->eDivCol();
//                     $this->make->eDivRow();
//                 $this->make->eDivCol();
//         $this->make->eForm();

//         $code = $this->make->code();

//         $data['code'] = $code;
//         $data['add_css'] = array(
//             'css/bootstrap-select/bootstrap-select.css',
//             'css/bootstrap-select/ajax-bootstrap-select.css',
//         );
//         $data['add_js'] = array(
//             'js/plugins/bootstrap-select/bootstrap-select.min.js',
//             'js/plugins/bootstrap-select/ajax-bootstrap-select.min.js',
//         );
//         $data['load_js'] = 'core/sales.php';
//         $data['use_js'] = 'nonStockLoadJs';
//         $this->load->view('load',$data);
//     }
//     public function search_non_stock_items($q=null)
//     {
//         if (!$this->input->post())
//             header('Location:'.base_url().'sales/sales_order_form');

//         $reference = $this->input->post('q') ? $this->input->post('q') : $q;

//         $where_array = array();
//         $where_array[] = array(
//             'key'=>"
//                 item_code LIKE '%$reference%' OR
//                 name LIKE '%$reference%' OR
//                 description LIKE '%$reference%'",'value'=>null,'escape'=>false);

//         $results = $this->sales_model->get_non_stock_items($where_array,true,10);

//         $json_array = array();
//         foreach ($results as $val) {
//             $json_array[] = array(
//                 'Id' => $val->id,
//                 'Text' => "[".$val->item_code."] ".$val->name,
//                 'Subtext' => $val->description
//                 );
//         }
//         if (!$json_array)
//             $json_array[] = array('Id'=>0,'Text'=>'Add \''.$reference.'\' as new item','Subtext'=>'Add new hardware item');
//         echo json_encode($json_array);
//     }
//     public function result_non_stock_items()
//     {
//         if (!$this->input->post())
//             header('Location:'.base_url().'sales/sales_order_form');

//         $item_id = $this->input->post('item_id') ? $this->input->post('item_id') : 0;

//         $where_array[] = array(
//             'key' => "non_stock_master.id",
//             'value' => $item_id,
//             'escape' => false
//             );

//         $results = $this->sales_model->get_non_stock_items($where_array);

//         if (!$results) {
//             $echo_array = array(
//                 'count' => '0',
//                 'id' => '',
//                 'item_code' => '',
//                 'name' => '',
//                 'description' => '',
//                 'item_tax_type' => 1,
//                 'uom_id' => 1,
//                 'qoh' => 0,
//              );
//         } else {
//             $results = $results[0];
//             $echo_array = array(
//                 'count' => 1,
//                 'id' => iSetObj($results,'id',''),
//                 'item_code' => iSetObj($results,'item_code',''),
//                 'name' => iSetObj($results,'name',''),
//                 'description' => iSetObj($results,'description',''),
//                 'item_tax_type' => iSetObj($results,'item_tax_type',1),
//                 'uom_id' => iSetObj($results,'uom_id',1),
//                 'qoh' => iSetObj($results,'qoh',''),
//                 );
//         }
//         echo json_encode($echo_array);
//     }
//     public function non_stock_so_items_db()
//     {
//         $line_total=0;
//         $percent_dec_val = $disc_val = $disc_price = 0;

//         if (!$this->input->post('hd_item_code')) {
//             $trans_items = array(
//                 'item_code'     => $this->input->post('item_code'),
//                 'name'          => $this->input->post('name'),
//                 'description'   => $this->input->post('description'),
//                 'item_tax_type' => $this->input->post('item_tax_type'),
//                 "uom_id"        => $this->input->post('uom_id'),
//                 );

//             $where_array      = array();
//             $where_array[]    = array('key'=>'non_stock_master.item_code','value'=>$trans_items['item_code'],'escape'=>true);
//             $check_duplicates = $this->sales_model->get_non_stock_items($where_array);

//             if ($check_duplicates) {
//                 echo json_encode(array('error'=>1,'msg'=>'Item code already exists. Please select a new one.'));
//                 return true;
//             }
//             $item_id = $this->sales_model->write_non_stock_items($trans_items);

//             $next_ref  = $this->site_model->get_next_ref(INVENTORY_ADJUSTMENT);
//             $type_no   = $next_ref->next_type_no;
//             $reference = $next_ref->next_ref;

//             $user = $this->session->userdata('user');

//             $items = array(
//                 "item_id"       => $item_id,
//                 "trans_type"    => INVENTORY_ADJUSTMENT,
//                 "type_no"       => $type_no,
//                 "trans_date"    => date('Y-m-d'),
//                 "loc_code"      => $this->input->post('loc_code'),
//                 "person_id"     => $user['id'],
//                 "qty"           => $this->input->post('qoh'),
//                 "visible"       => 1,
//                 "reference"     => $reference,
//                 "movement_type" => 'beginning'
//             );
//             $this->load->model('core/inventory_model');
//             $this->inventory_model->write_non_stock_movements($items,'single');

//         } else {
//             $item_id = $this->input->post('hd_item_code');

//             $where_array   = array();
//             $where_array[] = array('key'=>'non_stock_master.id','value'=>$item_id,'escape'=>true);
//             $get_data      = $this->sales_model->get_non_stock_items($where_array);

//             if (!$get_data) {
//                 echo json_encode(array('error'=>1,'msg'=>'Item details not found. Please try again.'));
//                 return true;
//             }

//             $get_data = $get_data[0];
//             $trans_items = array(
//                 'item_code'     => $get_data->item_code,
//                 'name'          => $get_data->name,
//                 'description'   => $get_data->description,
//                 'item_tax_type' => $get_data->item_tax_type,
//                 "uom_id"        => $get_data->uom_id,
//                 );
//         }

//         $so_id = $this->input->post('order_no');

//         $line_total = $this->input->post('unit_price')*$this->input->post('qty_delivered');

//         $percent_dec_val = $this->input->post('discount_percentage')/100;
//         $disc_val        = $line_total*$percent_dec_val;
//         $disc_price      = $line_total-$disc_val;

//         $items = array(
//             "order_no"            => $so_id,
//             "stock_id"            => $item_id,
//             "uom_id"              => $this->input->post('uom_id'),
//             "qty"                 => $this->input->post('qty_delivered'),
//             "unit_price"          => $this->input->post('unit_price'),
//             "discount_percentage" => $this->input->post('discount_percentage'),
//             "stock_category"      => $this->input->post('stock_category'),
//             "line_total"          => $disc_price,
//             "client_code"         => $this->input->post('client_code')
//         );

//         $id  = $this->sales_model->add_so_item($items);
//         $act = "add";
//         $msg = "Added New Item ".$trans_items['name'];

//         $this->make->sRow(array('id'=>'row-'.$id));
//             $this->make->td($items['stock_category']);
//             $this->make->td($trans_items['name']);
//             $this->make->td(num($this->input->post('qty_delivered')));
//             $this->make->td(num($this->input->post('unit_price')));
//             $this->make->td($this->input->post('discount_percentage'));
//             $this->make->td(num($disc_price));
//             $a = $this->make->A(fa('fa-trash-o fa-fw fa-lg'),'#',array('id'=>'del-'.$id,'return'=>true));
//             $this->make->td($a);
//         $this->make->eRow();
//         $row = $this->make->code();

//         $echo_array = array('row'=>$row,'msg'=>$msg,'act'=>$act,'id'=>$id);
//         if ($this->input->post('discount_percentage') > DISCOUNT_THRESHOLD)
//             $echo_array['underpriced_msg'] = "Item added is underpriced. Sales Order subjected for approval.";

//         echo json_encode($echo_array);
//     }
//     public function remove_so_item(){
//         $this->load->model('core/sales_model');
//         $this->sales_model->delete_so_item($this->input->post('so_item_id'));
//         $json['msg'] = "Item Deleted.";
//         echo json_encode($json);
//     }
//     //********************SO Entry*****Allyn*****end
//     // public function direct_invoice($ref=null){
//         // $data = $this->syter->spawn('sales');
//         // if ($ref) {
//             // $this->direct_invoice_container($ref,$data);
//         // } else {
//             // $results =
//             // $results = $this->inventory_model->get_items();
//             // $data['page_subtitle'] = "Item Maintenance";
//             // $data['code'] = build_items_display($results);
//         // }
//     // }
//     // private function direct_invoice_container($ref,&$data)
//     // {
//         // if (!strcasecmp($ref, 'new'))
//             // $data['page_title'] = fa('fa-file-o')." Create new Direct Invoice";
//         // else
//             // $data['page_title'] = fa('fa-file-o')." Edit Direct Invoice";
//     // }
//  //********************Direct Invoice Entry*****Allyn*****start
//  public function direct_invoice_form($so_id=null){
//    $this->load->model('core/sales_model');
//    $this->load->helper('core/sales_helper');

//    $data = $this->syter->spawn('direct_invoice_entry');
//    $data['page_title'] = "Direct Invoice Entry";

//    $data['code'] = directInvoiceHeaderPage($so_id);
//         $data['add_css'] = 'js/plugins/typeaheadmap/typeaheadmap.css';
//         $data['add_js'] = array('js/plugins/typeaheadmap/typeaheadmap.js');
//         $data['load_js'] = 'core/sales.php';
//         $data['use_js'] = 'directInvoiceHeaderJS';
//         $this->load->view('page',$data);
//  }
//  public function di_details_load($so_id=null){
//    $this->load->model('core/sales_model');
//    $this->load->helper('core/sales_helper');
//         $so=array();
//         if($so_id != null){
//             $sos = $this->sales_model->get_so_header($so_id);
//             $so=$sos[0];
//         }
//         $data['code'] = diHeaderDetailsLoad($so,$so_id);
//         $data['load_js'] = 'core/sales.php';
//         $data['use_js'] = 'diHeaderDetailsLoadJs';
//         $this->load->view('load',$data);
//     }
//  public function di_header_details_db(){
//         $this->load->model('core/sales_model');
//         $type_no = $this->sales_model->get_next_type_no(SALES_ORDER);

//    $items = array(
//             "trans_type"=>SALES_ORDER,
//             "debtor_id"=>$this->input->post('debtor_id'),
//             "debtor_branch_id"=>$this->input->post('debtor_branch_id'),
//             "type_no"=>$type_no,
//             "order_date"=>date2Sql($this->input->post('order_date')),
//             "sales_type"=>(int)$this->input->post('sales_type'),
//             "customer_ref"=>$this->input->post('customer_ref'),
//             "from_loc"=>$this->input->post('from_loc'),
//             "deliver_to"=>$this->input->post('deliver_to'),
//             "delivery_address"=>$this->input->post('delivery_address'),
//             "delivery_date"=>date2Sql($this->input->post('delivery_date')),
//             "remarks"=>$this->input->post('remarks'),
//             "shipper_id"=>$this->input->post('shipper_id'),
//             "shipping_cost"=>$this->input->post('shipping_cost')
//             // "inactive"=>(int)$this->input->post('inactive'),
//             // "cost"=>$this->input->post('cost')
//         );
//    // echo var_dump($items);
//         if($this->input->post('form_mod_id')){
//             $this->sales_model->update_so_header($items,$this->input->post('form_mod_id'));
//             $id = $this->input->post('form_mod_id');
//             $act = 'update';
//             // $msg = 'Updated Sales Order Details '.$this->input->post('name');
//             $msg = 'Updated Direct Invoice Details ';
//         }else{
//             $id = $this->sales_model->add_so_header($items);
//      $upd_ref = $this->sales_model->update_trans_types_next_ref($type_no, SALES_ORDER);
//             $act = 'add';
//             // $msg = 'Added  new Sales Order '.$this->input->post('name');
//             $msg = 'Added  new Direct Invoice ';
//         }

//         echo json_encode(array("id"=>$id,"desc"=>'',"act"=>$act,'msg'=>$msg));
//     }
//  public function di_items_load($so_id=null){
//         $this->load->model('core/sales_model');
//         $this->load->helper('core/sales_helper');
//         $details = $this->sales_model->get_so_items(null,$so_id);

//         $sos = $this->sales_model->get_so_header($so_id);
//         $so=$sos[0];

//         $data['code'] = diItemsLoad($so_id,$details,$so);
//         $data['load_js'] = 'core/sales.php';
//         $data['use_js'] = 'diItemsLoadJs';
//         $this->load->view('load',$data);
//     }
//  // public function search_items(){
//         // $search = $this->input->post('search');
//         // $this->load->model('core/sales_model');
//         // $found = $this->sales_model->search_items($search);
//         // $items = array();
//         // if(count($found) > 0 ){
//             // foreach ($found as $res) {
//                 // $items[] = array('key'=>$res->item_code." ".$res->name,'value'=>$res->id);
//             // }
//         // }
//         // echo json_encode($items);
//     // }
//  public function get_di_item_details($item_id=null,$asJson=true){
//         $json = array();
//         $items = $this->sales_model->get_item($item_id);
//         $item = $items[0];

//         $json['item_id'] = $item->id;
//         $json['uom'] = $item->uom_id;

//         $where = array('uom_id'=>$item->uom_id);
//         $uoms = $this->sales_model->get_details($where,'uoms');

//         $opts = array();
//         $opts[$uoms[0]->name] = $uoms[0]->name;
//         // if($item->no_per_pack > 0)
//         //     $opts['Pack(@'.$item->no_per_pack.' '.$item->uom.')'] = $item->uom."-".'pack-'.$item->no_per_pack;
//         // if($item->no_per_case > 0)
//         //     $opts['Case(@'.$item->no_per_case.' Packs)'] = $item->uom."-".'case-'.$item->no_per_case;

//         $json['opts'] =  $opts;
//         // $json['ppack'] = $item->no_per_pack;
//         // $json['pcase'] = $item->no_per_case;
//         echo json_encode($json);
//     }
//  public function di_items_db(){
//         $this->load->model('core/sales_model');
//    $line_total=0;
//    $percent_dec_val = $disc_val = $disc_price = 0;
//    $so_id = $this->input->post('so_id');
//         $item_id = $this->input->post('item-id');
//         // $gotItem = $this->sales_model->get_so_items(null,$so_id,$item_id);
//    $line_total = $this->input->post('unit_price')*$this->input->post('qty_delivered');

//    $percent_dec_val = $this->input->post('discount_percentage')/100;
//    $disc_val = $line_total*$percent_dec_val;
//    $disc_price = $line_total-$disc_val;

//         $items = array(
//             "order_no"=>$so_id,
//             "stock_id"=>$item_id,
//             "uom_id"=>$this->input->post('item-uom'),
//             "qty"=>$this->input->post('qty_delivered'),
//             "qty_delivered"=>$this->input->post('qty_delivered'),
//             "unit_price"=>$this->input->post('unit_price'),
//             "discount_percentage"=>$this->input->post('discount_percentage'),
//             // "line_total"=>$line_total
//             "line_total"=>$disc_price
//         );
//         // if(count($gotItem) > 0){
//             // $det = $gotItem[0];
//             // $this->mods_model->update_so_item($items,$det->mod_recipe_id);
//             // $id = $det->mod_recipe_id;
//             // $act = "update";
//             // $msg = "Updated Item ".$this->input->post('item-search');
//         // }else{
//             $id = $this->sales_model->add_so_item($items);
//             $act = "add";
//             // $msg = "Added New Item ".$this->sales_model->item_name_with_code($item_id);
//             $msg = "Added New Item ".$this->sales_model->item_name($item_id);
//             // $msg = "Added New Item ";
//         // }
//         $this->make->sRow(array('id'=>'row-'.$id));
//      // $this->make->td($this->sales_model->item_name_with_code($item_id));
//      $this->make->td($this->sales_model->item_name($item_id));
//             $this->make->td(num($this->input->post('qty_delivered')));
//             $this->make->td(num($this->input->post('unit_price')));
//             $this->make->td($this->input->post('discount_percentage'));
//             $this->make->td(num($disc_price));
//             $a = $this->make->A(fa('fa-trash-o fa-fw fa-lg'),'#',array('id'=>'del-'.$id,'return'=>true));
//             $this->make->td($a);
//         $this->make->eRow();
//         $row = $this->make->code();

//         echo json_encode(array('row'=>$row,'msg'=>$msg,'act'=>$act,'id'=>$id));
//     }
//  public function remove_di_item(){
//         $this->load->model('core/sales_model');
//         $this->sales_model->delete_so_item($this->input->post('so_item_id'));
//         $json['msg'] = "Item Deleted.";
//         echo json_encode($json);
//     }
//  //********************Direct Invoice Entry*****Allyn*****end
//  //********************CUSTOMER PAYMENT Entry*****Allyn*****start
//  public function cust_payment_form($so_id=null){
//    $this->load->model('core/sales_model');
//    $this->load->helper('core/sales_helper');

//    $data = $this->syter->spawn('sales_order_entry');
//    $data['page_title'] = "Customer Payment Entry";

//    $data['code'] = custPaymentHeaderPage($so_id);
//         $data['add_css'] = 'js/plugins/typeaheadmap/typeaheadmap.css';
//         $data['add_js'] = array('js/plugins/typeaheadmap/typeaheadmap.js');
//         $data['load_js'] = 'core/sales.php';
//         $data['use_js'] = 'custPaymentHeaderJS';
//         $this->load->view('page',$data);
//  }
//  public function cust_payment_details_load($so_id=null){
//    $this->load->model('core/sales_model');
//    $this->load->helper('core/sales_helper');
//         $so=array();
//         if($so_id != null){
//             $sos = $this->sales_model->get_so_header($so_id);
//             $so=$sos[0];
//         }
//         $next_ref_info = $this->site_model->get_next_ref(CUSTOMER_PAYMENT);
//         $next_ref = $next_ref_info->next_ref;
//         $next_type_no = $next_ref_info->next_type_no;

//         $data['code'] = cpHeaderDetailsLoad($so,$so_id,$next_ref);
//         $data['load_js'] = 'core/sales.php';
//         $data['use_js'] = 'cpHeaderDetailsLoadJs';
//         $this->load->view('load',$data);
//     }
//     public function process_customer_payment()
//     {
//         if (!$this->input->post())
//             header('Location:'.base_url().'sales/cust_payment_form');

//         $this->site_model->db->trans_start();
//         $this->sales_model->db->trans_start();

//         $next_ref_info = $this->site_model->get_next_ref(CUSTOMER_PAYMENT);
//         $next_ref = $next_ref_info->next_ref;
//         $next_type_no = $next_ref_info->next_type_no;

//         $user = $this->session->userdata('user');

//         $debtor_trans = array(
//             'trans_type'       => CUSTOMER_PAYMENT,
//             'type_no'          => $next_type_no,
//             'debtor_id'        => $this->input->post('debtor_id'),
//             'debtor_branch_id' => $this->input->post('debtor_branch_id'),
//             'remarks'          => $this->input->post('memo'),
//             'trans_date'       => date('Y-m-d',strtotime($this->input->post('order_date'))),
//             't_amount'         => $this->input->post('amount'),
//             'reference'        => $this->input->post('reference'),
//             'person_id'        => $user['id'],
//             // 'bank_id' => $this->input->post('into_bank_acct'),
//             );

//         # write db
//         $id = $this->sales_model->write_debtor_trans($debtor_trans);

//         $bank_trans = array(
//             'trans_type' => $debtor_trans['trans_type'],
//             'type_no' => $debtor_trans['type_no'],
//             'reference' => $debtor_trans['reference'],
//             'bank_account_id' => $this->input->post('into_bank_acct'),
//             'trans_date' => $debtor_trans['trans_date'],
//             'bank_trans_type' => strtoupper($this->input->post('bank_payment_type')),
//             'amount' => $debtor_trans['t_amount'],
//             'person_id' => $debtor_trans['person_id'],
//             'is_cleared' => 0
//         );
//         $bank_trans_id = $this->sales_model->write_bank_trans($bank_trans);

//         if ($bank_trans['bank_trans_type'] == 'CHECK') {
//             $cheque_details = array(
//                 'trans_type' => $bank_trans['trans_type'],
//                 'bank_trans_id' => $bank_trans_id,
//                 'bank' => $this->input->post('bnk_chk_dep'),
//                 'branch' => $this->input->post('bch_chk_dep'),
//                 'chk_number' => $this->input->post('chk_no_chk_dep'),
//                 'chk_date' => date('Y-m-d',strtotime($this->input->post('chk_dte_chk_dep'))),
//             );
//             $this->sales_model->write_cheque_details($cheque_details);
//         }

//         $this->site_model->add_trans_ref(
//             array(
//                 'trans_type' => CUSTOMER_PAYMENT,
//                 'type_no'    => $debtor_trans['type_no'],
//                 'reference'  => $debtor_trans['reference']
//                 )
//             );

//         $this->site_model->db->trans_complete();
//         $this->sales_model->db->trans_complete();

//         site_alert('Customer Payment # '.$debtor_trans['reference'].' has been processed','success');
//     }
//  //********************CUSTOMER PAYMENT Entry*****Allyn*****end
//     // ======================================================================================= //
//     //          INQUIRIES
//     // ======================================================================================= //
//     public function sales_order_inquiry($status = null)
//     {
//         $data = $this->syter->spawn('sales');

//         $data['page_title'] = fa('fa-question-circle')." Sales Order Inquiry";

//         if (!strcasecmp($status,'approved')) {
//             $data['page_title'] = fa('fa fa-truck')." Dispatch Sales Orders";
//             $data['page_subtitle'] = "Sales Order Delivery";
//         }
//         $data['code'] = build_sales_order_inquiry($status);
//         $data['add_css'][] = 'css/daterangepicker/daterangepicker-bs3.css';
//         $data['add_js'][] = 'js/plugins/daterangepicker/daterangepicker.js';
//         $data['load_js'] = 'core/sales.php';
//         $data['use_js'] = 'salesOrderSearchJs';
//         $this->load->view('page',$data);
//     }
//     public function so_inquiry_results($status=null)
//     {
//         if (!$this->input->post())
//             header('Location:'.base_url().'sales/sales_order_inquiry');

//         $debtor_id = $this->input->post('debtor_id');
//         $person_id = $this->input->post('person_id');

//         $daterange = $this->input->post('daterange');
//         $dates = explode(" to ",$daterange);
//         $date_from = (empty($dates[0]) ? date('Y-m-d') : date('Y-m-d',strtotime($dates[0])));
//         $date_to = (empty($dates[1]) ? date('Y-m-d') : date('Y-m-d',strtotime($dates[1])));

//         $where_array = array();
//         $where_array[] = array('key'=>'`sales_orders`.`debtor_id`','value'=>(int) $debtor_id,'escape'=>true);
//         if ($person_id)
//             $where_array[] = array('key'=>'`sales_orders`.`person_id`','value'=>(int) $person_id,'escape'=>true);
//         // if ($debtor_branch_id !== '')
//         //     $where_array[] = array('key'=>'sales_orders.debtor_id','value'=>(int) $debtor_id,'escape'=>true);
//         $where_array[] = array('key'=>'`sales_orders`.`order_date` >=','value'=>$date_from,'escape'=>true);
//         $where_array[] = array('key'=>'`sales_orders`.`order_date` <=','value'=>$date_to,'escape'=>true);
//         if (is_null($status))
//             $where_array[] = array('key'=>"`sales_orders`.`status` IS NULL OR `sales_orders`.`status` NOT IN ('inactive','completed','on delivery')",'value'=>null,'escape'=>false);
//         else
//             $where_array[] = array('key'=>"`sales_orders`.`status` IS NULL OR `sales_orders`.`status` NOT IN ('inactive','completed')",'value'=>null,'escape'=>false);

//         $results = $this->sales_model->get_sales_orders($where_array);
//         $data['code'] = build_so_display($results,$status);
//         $data['load_js'] = 'core/sales.php';
//         $data['use_js'] = 'salesOrderResultsJs';
//         $this->load->view('load',$data);
//     }
  
//     public function approve_sales_order()
//     {
//         if (!$this->input->post('ref'))
//             header('Location:'.base_url().'sales/sales_order_inquiry');
//         $ref = $this->input->post('ref');

//         $items = array('status'=>'approved','approved_date'=>date('Y-m-d'));
//         $where_array = array('trans_type'=>SALES_ORDER,'type_no'=>$ref);
//         $this->sales_model->update_sales_order($items,$where_array);
//         site_alert('Successfully approved Sales Order # '.$ref,'success');
//     }
//     public function reject_sales_order()
//     {
//         if (!$this->input->post('ref'))
//             header('Location:'.base_url().'sales/sales_order_inquiry');
//         $ref = $this->input->post('ref');

//         $items = array('status'=>'rejected','inactive'=>'1');
//         $where_array = array('trans_type'=>SALES_ORDER,'type_no'=>$ref);
//         $this->sales_model->update_sales_order($items,$where_array);
//         site_alert('Sales Order # '.$ref.' made inactive','warning');
//     }
//     public function complete_sales_order()
//     {
//         if (!$this->input->post('ref'))
//             header('Location:'.base_url().'sales/sales_order_inquiry/approved');
//         $ref = $this->input->post('ref');

//         $items = array('status'=>'completed');
//         $where_array = array('trans_type'=>SALES_ORDER,'type_no'=>$ref);
//         $this->sales_model->update_sales_order($items,$where_array);
//         site_alert('Sales Order # '.$ref.' has been completed','success');
//     }
//     public function search_sales_order($so_id) // param counter
//     {
//         $where_array = array(array('key'=>'sales_orders.order_no','value'=>$so_id,'escape'=>true));
//         $results = $this->sales_model->get_sales_orders($where_array);
//         // echo $this->sales_model->db->last_query()."\n";
//         if ($results) {
//             echo json_encode(array('result'=>1,'items'=>$results[0]->order_total,'underpriced'=>$results[0]->underpriced_count));
//         } else {
//             echo json_encode(array('result'=>0));
//         }
//     }
//     public function order_dispatch($so_id,$view='page')
//     {
//         $data = $this->syter->spawn('sales');

//         $where_array = array();
//         $where_array[] = array('key'=>'sales_orders.order_no','value'=>$so_id,'escape'=>true);
//         $where_array[] = array('key'=>'sales_orders.trans_type','value'=>SALES_ORDER,'escape'=>true);
//         $where_array[] = array('key'=>'(sales_orders.status <> \'completed\' OR sales_orders.inactive <> \'1\')','value'=>null,'escape'=>true);
//         $results = $order_info = $this->sales_model->get_sales_orders($where_array);
//         if (!$order_info) {
//             site_alert('No Sales Order found for that id','warning');
//             header('Location:'.base_url().'sales/sales_order_inquiry/approved');
//         }

//         if ($results[0]->underpriced_count && strcasecmp($results[0]->status,'approved')) {
//             site_alert('Sales Order # '.$results[0]->reference.' has not been approved yet. Please check SO items to proceed.','warning');
//             header('Location:'.base_url().'sales/sales_order_inquiry/approved');
//         }

//         $so_items = $this->sales_model->view_sales_order_details(array('order_no'=>$order_info[0]->order_no));
//         if (!$so_items) {
//             site_alert('Sales Order has no items. Unable to proceed','warning');
//             header('Location:'.base_url().'sales/sales_order_inquiry/approved');
//         }

//         $is_complete = true;
//         foreach ($so_items as $val) {
//             if ($val->order_line_total != $val->delivered_line_total)
//                 $is_complete = false;
//         }
//         if ($is_complete) {
//             site_alert('Sales Order has already been completed','warning');
//             header('Location:'.base_url().'sales/sales_order_inquiry/approved');
//         }

//         $next_ref = $this->site_model->get_next_ref(DELIVERY_NOTE);
//         $next_ref = $next_ref->next_ref;
//         $data['page_title'] = fa('fa fa-truck')." Delivery for Sales Order # ".$order_info[0]->reference;
//         $data['code'] = build_order_dispatch($next_ref,$order_info[0],$so_items);
//         $data['load_js'] = 'core/sales.php';
//         $data['use_js'] = 'salesDeliveryJs';
//         $this->load->view($view,$data);
//     }
//     public function process_sales_delivery()
//     {
//         # restrict forced URL nav
//         // if (!$this->input->post())
//         //     header('Location'.base_url().'sales/sales_order_inquiry/approved');

//         $user = $this->session->userdata('user');
//         $next_ref_info = $this->site_model->get_next_ref(DELIVERY_NOTE);

//         $next_ref = ($this->input->post('delivery_ref') ? $this->input->post('delivery_ref') : $next_ref_info->next_ref);
//         $next_ref = $this->site_model->check_duplicate_ref(DELIVERY_NOTE,$next_ref);
//         $next_type_no = $next_ref_info->next_type_no;
//         # get POST data
//         // $delivery_details = array(
//         //     'delivery_no' => ($this->input->post('delivery_no') != $next_ref ? str_pad($next_ref, strlen($this->input->post('delivery_no'),'0',STR_PAD_LEFT)) : $next_ref),
//         //     'delivery_date' => date('Y-m-d',strtotime($this->input->post('delivery_date'))),
//         //     'order_no' => $this->input->post('order_no'),
//         //     'from_loc' => $this->input->post('from_loc'),
//         //     'shipper_id' => $this->input->post('shipper_id'),
//         //     'invoice_due_date' => date('Y-m-d',strtotime($this->input->post('invoice_due_date'))),
//         //     'pr_ref' => $this->input->post('pr_ref'),
//         //     'si_ref' => $this->input->post('si_ref'),
//         //     'bir_dr_ref' => $this->input->post('bir_dr_ref'),
//         //     'shipping_cost' => $this->input->post('shipping_cost'),
//         //     'remarks' => $this->input->post('remarks'),
//         //     'created_on' => date('Y-m-d H:i:s'),
//         //     'person_id' => $user['id']
//         //     );
//         $delivery_details = array(
//             'trans_type'       => DELIVERY_NOTE,
//             'type_no'          => $next_type_no,
//             'reference'        => $next_ref,
//             'debtor_id'        => $this->input->post('debtor_id'),
//             //'debtor_branch_id' => $this->input->post('debtor_branch_id') ?: null,
//             'trans_date'       => date('Y-m-d',strtotime($this->input->post('delivery_date'))),
//             'invoice_due_date' => date('Y-m-d',strtotime($this->input->post('invoice_due_date'))),
//             't_shipping_cost'  => $this->input->post('deliv_shipping_cost'),
//             'shipper_id'       => $this->input->post('shipper_id'),
//             'src_trans_type'   => $this->input->post('order_trans_type'),
//             'src_type_no'      => $this->input->post('order_type_no'),
//             'pr_ref'           => $this->input->post('pr_ref'),
//             'si_ref'           => $this->input->post('si_ref'),
//             'dr_ref'           => $this->input->post('bir_dr_ref'),
//             'address'          => $this->input->post('delivery_address'),
//             'loc_code'         => $this->input->post('from_loc'),
//             'remarks'          => $this->input->post('remarks'),
//             'person_id'        => $user['id']
//             );


//         $delivery_items = $this->input->post('delivery');
//         $so_no          = $this->input->post('order_type_no');
//         $order_no       = $this->input->post('order_no');
//         $order_ref      = $this->input->post('order_reference');

//         # get sales order details
//         $so_items = $this->sales_model->view_sales_order_details(array('order_no'=>$order_no));
//         # restrict empty SO
//         if (!$so_items)
//             header('Location'.base_url().'sales/sales_order_inquiry/approved');

//         # get stock variables
//         $stocks = array();
//         foreach ($so_items as $val) {
//             $stocks[$val->stock_category][$val->stock_id] = array(
//                 'unit_price'          => $val->unit_price,
//                 'uom_id'              => $val->uom_id,
//                 'discount_percentage' => $val->discount_percentage,
//                 'outstanding'         => $val->order_qty - $val->delivered_qty,
//                 'description'         => $val->description,
//                 'client_code'         => $val->client_code
//                 );
//         }
//         // # initialize moves variables
//         $non_stock_moves = $stock_moves = $debtor_trans_details = array();
//         $moves_total = 0;
//         $is_settled = false;
//         $same_item_count = true;
//         foreach ($delivery_items as $stock_category => $itemx) {
//             foreach ($itemx as $item_id => $qty) {
//                 if (!$qty) {
//                     $same_item_count = false;
//                     continue;
//                 }

//                 if (!isset($stocks[$stock_category][$item_id]))
//                     continue;

//                 $debtor_trans_details[] = array(
//                         'debtor_trans_type'   => DELIVERY_NOTE,
//                         'debtor_type_no'      => $delivery_details['type_no'],
//                         'stock_id'            => $item_id,
//                         'description'         => $stocks[$stock_category][$item_id]['description'],
//                         'unit_price'          => $stocks[$stock_category][$item_id]['unit_price'],
//                         'uom_id'              => (int) $stocks[$stock_category][$item_id]['uom_id'],
//                         'qty'                 => $qty,
//                         'discount_percentage' => $stocks[$stock_category][$item_id]['discount_percentage'],
//                         'client_code'         => $stocks[$stock_category][$item_id]['client_code'],
//                         'stock_category'      => $stock_category,
//                     );

//                 if ($stocks[$stock_category][$item_id]['outstanding'] == $qty)
//                     $is_settled = true;
//                 else
//                     $is_settled = false;

//                 # compute line price
//                 $moves_total += $qty
//                     * $stocks[$stock_category][$item_id]['unit_price']
//                     * ((100 - $stocks[$stock_category][$item_id]['discount_percentage']) / 100);

//                 # Filter NON-STOCK IMPORT ITEMS
//                 if ($stock_category == LOCAL_ITEM)
//                     $non_stock_moves[] = array(
//                     'item_id'     => $item_id,
//                     'trans_type'  => DELIVERY_NOTE,
//                     'type_no'     => $delivery_details['type_no'],
//                     'trans_date'  => $delivery_details['trans_date'],
//                     'loc_code'    => $delivery_details['loc_code'],
//                     'reference'   => $delivery_details['reference'],
//                     'person_id'   => $user['id'],
//                     'qty'         => -$qty,
//                     'visible'     => 1
//                     );
//                 else
//                     $stock_moves[] = array(
//                         'item_id'     => $item_id,
//                         'trans_type'  => DELIVERY_NOTE,
//                         'type_no'     => $delivery_details['type_no'],
//                         'trans_date'  => $delivery_details['trans_date'],
//                         'loc_code'    => $delivery_details['loc_code'],
//                         'reference'   => $delivery_details['reference'],
//                         'person_id'   => $user['id'],
//                         'qty'         => -$qty,
//                         'visible'     => 1
//                         );
//             }
//         }

//         # start db writing
//         $this->load->model('core/inventory_model');
//         $delivery_details['t_amount'] = $delivery_details['t_shipping_cost'] + $moves_total;
//         $this->sales_model->write_debtor_trans($delivery_details);
//         $this->sales_model->write_debtor_trans_details($debtor_trans_details,true);
//         if ($stock_moves)
//             $this->inventory_model->write_item_movements($stock_moves,'batch');
//         if ($non_stock_moves)
//             $this->inventory_model->write_non_stock_movements($non_stock_moves,'batch');
//         $this->site_model->add_trans_ref(
//             array(
//                 'trans_type' => DELIVERY_NOTE,
//                 'type_no'    => $delivery_details['type_no'],
//                 'reference'  => $delivery_details['reference']
//                 )
//             );

//         site_alert('Delivery Note # '.$delivery_details['reference'].' has been processed','success');

//         if ($is_settled && $same_item_count) {
//             $this->sales_model->update_sales_order(array('status'=>'completed'),array('sales_orders.order_no'=>$order_no));
//             site_alert('Sales Order # '.$order_ref.' has been completed','success');
//         } else {
//             $this->sales_model->update_sales_order(array('status'=>'on delivery'),array('sales_orders.order_no'=>$order_no));
//             site_alert('Sales Order # '.$order_ref.' status changed to \'On Delivery\'','success');
//         }
//     }
//     public function invoice_deliveries()
//     {
//         $data = $this->syter->spawn('sales');

//         $data['page_title'] = fa('fa fa-newspaper-o')." Issue Delivery Invoices";
//         $data['page_subtitle'] = "Issue invoice to deliveries";
//         $data['code'] = build_invoice_deliveries();
//         $data['add_css'][] = 'css/daterangepicker/daterangepicker-bs3.css';
//         $data['add_js'][] = 'js/plugins/daterangepicker/daterangepicker.js';
//         $data['load_js'] = 'core/sales.php';
//         $data['use_js'] = 'deliveryInvoiceJs';
//         $this->load->view('page',$data);
//     }
//     public function invoice_deliveries_results()
//     {
//         if (!$this->input->post('daterange'))
//             header('Location:'.base_url().'sales/invoice_deliveries');

//         $debtor_id = $this->input->post('debtor_id');

//         $daterange = $this->input->post('daterange');
//         $dates = explode(" to ",$daterange);
//         $date_from = (empty($dates[0]) ? date('Y-m-d') : date('Y-m-d',strtotime($dates[0])));
//         $date_to = (empty($dates[1]) ? date('Y-m-d') : date('Y-m-d',strtotime($dates[1])));

//         $where_array = array();
//         if ($debtor_id)
//             $where_array[] = array('key'=>'`sales_orders`.`debtor_id`','value'=>(int) $debtor_id,'escape'=>true);
//         $where_array[] = array('key'=>'debtor_trans.trans_date >=','value'=>$date_from,'escape'=>true);
//         $where_array[] = array('key'=>'debtor_trans.trans_date <=','value'=>$date_to,'escape'=>true);
//         $where_array[] = array('key'=>'debtor_trans.trans_type','value'=>DELIVERY_NOTE,'escape'=>true);
//         $where_array[] = array('key'=>'debtor_trans.tar_trans_type IS NULL','value'=>null,'escape'=>true);
//         $where_array[] = array('key'=>'debtor_trans.tar_type_no IS NULL','value'=>null,'escape'=>true);

//         $results = $this->sales_model->get_sales_deliveries($where_array);
//         // echo $this->sales_model->db->last_query();
//         $data['code'] = build_invoice_display($results);
//         $data['load_js'] = 'core/sales.php';
//         $data['use_js'] = 'deliveryDisplayJs';
//         $this->load->view('load',$data);
//     }
//     public function customer_invoice()
//     {
//         $data = $this->syter->spawn('sales');

//         $dr_no = $this->input->post('dr_no');

//         if (!$dr_no)
//             header('Location:'.base_url().'sales/invoice_deliveries');

//         $next_ref = $this->site_model->get_next_ref(SALES_INVOICE);
//         $next_ref =  $next_ref->next_ref;

//         $delivery_info = $this->sales_model->get_sales_deliveries(
//             array(
//                 array('key'=>'debtor_trans.id IN ','value'=>'('.implode(', ',$dr_no).')','escape'=> false),
//                 array('key'=>'debtor_trans.trans_type','value'=>DELIVERY_NOTE,'escape'=> false),
//                 array('key'=>'debtor_trans.tar_type_no IS NULL','value'=>null,'escape'=>true)
//                 )
//         );

//         if (!$delivery_info)
//             header('Location:'.base_url().'sales/invoice_deliveries');

//         $delivery_items = $this->sales_model->view_sales_delivery_items($dr_no);

//         if (!$delivery_items)
//             header('Location:'.base_url().'sales/invoice_deliveries');

//         $delivery_refs = array();
//         foreach ($delivery_items as $val) {
//             if (!in_array($val->delivery_ref, $delivery_refs))
//                 $delivery_refs[] = $val->delivery_ref;
//         }

//         $data['page_title'] = fa('fa fa-newspaper-o')." Customer Invoice # ".$next_ref;
//         $data['code'] = build_customer_invoice($dr_no,$next_ref,$delivery_info,$delivery_items,$delivery_refs);
//         $data['load_js'] = 'core/sales.php';
//         $data['use_js'] = 'customerInvoiceJs';
//         $this->load->view('page',$data);
//     }
//     public function process_sales_invoice()
//     {
//         if (!$this->input->post())
//             header('Location:'.base_url().'sales/invoice_deliveries');

//         $next_ref_info = $this->site_model->get_next_ref(SALES_INVOICE);
//         $next_ref = $next_ref_info->next_ref;
//         $next_type_no = $next_ref_info->next_type_no;

//         $user = $this->session->userdata('user');

//         $debtor_trans = array(
//             'trans_type'       => SALES_INVOICE,
//             'type_no'          => $next_type_no,
//             'reference'        => $next_ref,
//             'debtor_id'        => $this->input->post('debtor_id'),
//             //'debtor_branch_id' => $this->input->post('debtor_branch_id') ?: null,
//             'remarks'          => $this->input->post('remarks'),
//             'trans_date'       => date('Y-m-d',strtotime($this->input->post('trans_date'))),
//             'due_date'         => date('Y-m-d',strtotime($this->input->post('due_date'))),
//             't_amount'         => $this->input->post('total_cost'),
//             't_shipping_cost'  => $this->input->post('total_ship'),
//             'pr_ref'           => $this->input->post('pr_ref'),
//             'address'          => $this->input->post('address'),
//             'person_id'        => $user['id']
//             );

//         $delivery_no = $this->input->post('delivery_no');
//         $delivery_items = $this->sales_model->view_sales_delivery_items(null,
//             array(
//                 array('key'=>'delivery_no IN ','value'=>'('.$delivery_no.')','escape'=>false)
//                 )
//         );

//         $insert_delivery_items = array();
//         foreach ($delivery_items as $val) {
//             $insert_delivery_items[] = array(
//                 'debtor_trans_type'   => SALES_INVOICE,
//                 'debtor_type_no'      => $debtor_trans['type_no'],
//                 'stock_id'            => $val->stock_id,
//                 'description'         => $val->description,
//                 'unit_price'          => $val->unit_price,
//                 'uom_id'              => $val->uom_id,
//                 'qty'                 => $val->delivered_qty,
//                 'discount_percentage' => $val->discount_percentage,
//                 'stock_category'      => $val->stock_category,
//                 'client_code'         => $val->client_code,
//                 );
//         }

//         $id           = $this->sales_model->write_debtor_trans($debtor_trans);
//         $update_array = array('tar_trans_type'=>SALES_INVOICE,'tar_type_no'=>$next_type_no);
//         $this->sales_model->update_sales_deliveries($update_array,null,array(
//                 array('key'=>'id IN ','value'=>'('.$delivery_no.')','escape'=>false)
//                 )
//             );

//         $this->sales_model->write_debtor_trans_details($insert_delivery_items,true);
//          $this->site_model->add_trans_ref(
//             array(
//                 'trans_type' => SALES_INVOICE,
//                 'type_no'    => $debtor_trans['type_no'],
//                 'reference'  => $debtor_trans['reference']
//                 )
//             );
//         site_alert('Sales Invoice # '.$debtor_trans['reference'].' has been processed','success');
//     }
//     public function customer_payments()
//     {
//         $data = $this->syter->spawn('sales');

//         $where_array = array();
//         $where_array[] = array('key'=>'
//             (debtor_trans.trans_type = '.CUSTOMER_PAYMENT.' OR debtor_trans.trans_type = '.CUSTOMER_CREDIT_NOTE.')',
//             'value'=>null,'escape'=>false);
//         $where_array[] = array('key'=>'(debtor_trans.t_amount <> IFNULL(debtor_trans.allocated_amount,0))','value'=>null,'escape'=>false);
//         $payments = $this->sales_model->get_debtor_trans($where_array);

//         $data['page_title'] = fa('fa fa-money')." Customer Payments";
//         $data['code'] = build_customer_payments($payments);
//         $data['load_js'] = 'core/sales.php';
//         $data['use_js'] = 'customerPaymentJs';
//         $this->load->view('page',$data);
//     }
//     public function display_customer_payments()
//     {
//         $debtor_id = $this->input->post('debtor_id');
//         $where_array = array();
//         $where_array[] = array('key'=>'
//             (debtor_trans.trans_type = '.CUSTOMER_PAYMENT.' OR debtor_trans.trans_type = '.CUSTOMER_CREDIT_NOTE.')',
//             'value'=>null,'escape'=>false);
//         $where_array[] = array('key'=>'(debtor_trans.t_amount <> IFNULL(debtor_trans.allocated_amount,0))','value'=>null,'escape'=>false);
//         if ($debtor_id && is_numeric($debtor_id))
//             $where_array[] = array('key'=>'debtor_trans.debtor_id','value'=>$debtor_id,'escape'=>false);

//         $payments = $this->sales_model->get_debtor_trans($where_array);
//         $data['code'] = build_customer_payment_display($payments);
//         $data['load_js'] = 'core/sales.php';
//         $data['use_js'] = 'customerPaymentDisplayJs';
//         $this->load->view('load',$data);
//     }
//     public function allocate_customer_payment($trans=null)
//     {
//         $data = $this->syter->spawn('sales');

//         if (!$trans)
//             header('Location:'.base_url().'sales/customer_payments');

//         $where_array = array();
//         $where_array[] = array('key'=>'
//             (debtor_trans.trans_type = '.CUSTOMER_PAYMENT.' OR debtor_trans.trans_type = '.CUSTOMER_CREDIT_NOTE.')',
//             'value'=>null,'escape'=>false);
//         $where_array[] = array('key'=>'debtor_trans.id','value'=>$trans,'escape'=>true);
//         $where_array[] = array('key'=>'(debtor_trans.t_amount <> IFNULL(debtor_trans.allocated_amount,0))','value'=>null,'escape'=>false);

//         $payments = $this->sales_model->get_debtor_trans($where_array);

//         if (!$payments)
//             header('Location:'.base_url().'sales/customer_payments');

//         $debtor_id = $payments[0]->debtor_id;
//         // $debtor_branch_id = $payments[0]->debtor_branch_id;

//         $where_array = array();
//         $where_array[] = array('key'=>'debtor_trans.trans_type','value'=>SALES_INVOICE,'escape'=>true);
//         $where_array[] = array('key'=>'debtor_trans.debtor_id','value'=>$debtor_id,'escape'=>true);
//         // $where_array[] = array('key'=>'debtor_trans.debtor_branch_id','value'=>$debtor_branch_id,'escape'=>true);
//         $where_array[] = array('key'=>'(debtor_trans.t_amount <> IFNULL(debtor_trans.allocated_amount,0))','value'=>null,'escape'=>false);

//         $invoices = $this->sales_model->get_debtor_trans($where_array);

//         // echo $this->sales_model->db->last_query();
//         if (!$invoices) {
//             site_alert('Customer (or branch) has no invoices. Please create one to proceed.','warning');
//             header('Location:'.base_url().'sales/customer_payments');
//         }

//         $data['page_title'] = fa('fa fa-check-square-o')." Customer Payment Allocation";
//         $data['code'] = build_customer_payment_allocation($trans,$payments,$invoices);
//         $data['load_js'] = 'core/sales.php';
//         $data['use_js'] = 'customerPaymentAllocationJs';
//         $this->load->view('page',$data);
//     }
//     public function process_payment_allocation()
//     {
//     # Check POST
//         if (!$this->input->post())
//             header('Location:'.base_url().'sales/customer_payments');
//     # Initialize variables
//         $user = $this->session->userdata('user');

//         $alloc = $this->input->post('alloc');
//         $payment_trans_type = $this->input->post('trans_type');
//         $payment_type_no = $this->input->post('type_no');

//     # Get payment information
//         $where_array = array();
//         $where_array[] = array('key'=>'debtor_trans.trans_type','value'=>$payment_trans_type,'escape'=>true);
//         $where_array[] = array('key'=>'debtor_trans.type_no','value'=>$payment_type_no,'escape'=>true);
//         $where_array[] = array('key'=>'(debtor_trans.t_amount <> IFNULL(debtor_trans.allocated_amount,0))','value'=>null,'escape'=>false);

//         $payments = $this->sales_model->get_debtor_trans($where_array);
//     # Check payment validity
//         if (!$payments) {
//             echo json_encode(array('error'=>1,'msg'=>'Unable to process this customer payment. Please reload page.'));
//             return false;
//         }
//     # Prepare DB variables
//         $payment = $payments[0];
//         $outstanding_amount = $payment->t_amount - $payment->allocated_amount;

//         $allocations = array();
//         $trans_alloc_amount = 0;
//         foreach ($alloc as $key => $val) {
//             $allocations[] = array(
//                 'trans_type' => $payment_trans_type,
//                 'type_no' => $payment_type_no,
//                 'target_trans_type' => SALES_INVOICE,
//                 'target_type_no' => $key,
//                 'amount' => $val,
//                 'person_id' => $user['id']
//                 );
//             $trans_alloc_amount += $val;
//         }
//     # Check payment validity 2
//         if ($trans_alloc_amount > $outstanding_amount) {
//             echo json_encode(array('error'=>1,'msg'=>'Total allocated amount exceeds remaining payment'));
//             return false;
//         }
//     # Write DB
//         # Write PA
//         $this->sales_model->write_payment_allocation($allocations,true);

//         # Update Sales Invoices
//         foreach ($allocations as $v) {
//             $_alloc = array();
//             $_alloc[] = array('column'=>'allocated_amount','value'=>'IFNULL(allocated_amount,0)+'.$v['amount'],'escape'=>false);
//             $where = array(
//                 'trans_type' => SALES_INVOICE,
//                 'type_no' => $v['target_type_no']
//                 );
//             $this->sales_model->update_debtor_trans_set($_alloc,$where);
//         }

//         # Update Customer Payment
//         $_pa = array();
//         $_pa[] = array('column'=>'allocated_amount','value'=>'IFNULL(allocated_amount,0)+'.$trans_alloc_amount,'escape'=>false);
//         $where = array('trans_type'=>$payment_trans_type,'type_no'=>$payment_type_no);
//         $this->sales_model->update_debtor_trans_set($_pa,$where);
//     # FINISH
//         site_alert('Customer Payment allocation has been processed','success');
//     }


//     //////////////////////////////JED///////////////////////////////////
//     /////////////////////////////////////////////////////////////////////
//     public function print_sales_invoices($trans_type=null,$type_no=null,$id=null,$print=null){

//         $checkbox_sess = array();
//         if($this->session->userData('checkbox_sess'))
//             $checkbox_sess = $this->session->userData('checkbox_sess');


//         $where_array = array();
//         $where_array['debtor_trans_details.debtor_trans_type'] = (int) $trans_type;
//         $where_array['debtor_trans_details.debtor_type_no'] = (int) $type_no;
//         $details = $this->sales_model->get_invoice_items($where_array,true);

//         // echo $this->sales_model->db->last_query();

//         $header = $this->sales_model->get_sales_invoices($id);
//         // // $attr_value = $this->asset_model->get_attributes_value($asset_id);
//         $head = $header[0];

//         // $get_company = $this->company_model->get_details(1);
//         // $company = $get_company[0];
//         // echo $this->db->last_query();
//         //var_dump($details);

//         $data['invoice_details'] = $details;
//         $data['head'] = $head;
//         $data['print'] = $print;
//         $data['cboxes'] = $checkbox_sess;
//         // $data['company'] = $company;
//         // // // $data['fs_details'] = $fs_details;

//         $this->load->view('contents/prints/print_sales_invoice.php',$data); //full details
//     }

//     public function credit_note($cn_id=null){
//         $this->load->model('core/sales_model');
//         $this->load->helper('core/sales_helper');

//         $data = $this->syter->spawn('sales_order_entry');
//         $data['page_title'] = "Credit Note";

//         $data['code'] = creditNoteHeaderPage($cn_id);
//         $data['add_css'] = array('css/wizard-steps/jquery.steps.css');
//         $data['add_js'] = array('js/plugins/wizard-steps/jquery.steps.js');
//         $data['load_js'] = 'core/sales.php';
//         $data['use_js'] = 'creditNoteHeaderJS';
//         $this->load->view('page',$data);
//     }
//     public function cn_details_load($cn_id=null){
//         $this->load->model('core/sales_model');
//         $this->load->helper('core/sales_helper');
//         $cn=array();
//         if($cn_id != null){
//             $type = 6;
//             $cns = $this->sales_model->get_cn_header($cn_id, $type);
//             if ($cns) $cn=$cns[0];
//             else $cn_id = null;
//         }
//         $next_ref = $this->site_model->get_next_ref(CUSTOMER_CREDIT_NOTE);
//         $reference = $next_ref->next_ref;

//         $data['code'] = cnHeaderDetailsLoad($cn,$cn_id,$reference);
//         $data['load_js'] = 'core/sales.php';
//         $data['use_js'] = 'cnHeaderDetailsLoadJs';
//         $this->load->view('load',$data);
//     }
//     public function cn_header_details_db(){
//         $this->load->model('core/sales_model');
//         $next_ref = $this->site_model->get_next_ref(CUSTOMER_CREDIT_NOTE);
//         $type_no = $next_ref->next_type_no;
//         $reference = ($this->input->post('reference') ? $this->input->post('reference') : $next_ref->next_ref);
//         $user = $this->session->userdata('user');

//         $items = array(
//             "trans_type"=>CUSTOMER_CREDIT_NOTE,
//             "debtor_id"=>$this->input->post('debtor_id'),
//             "debtor_branch_id"=>$this->input->post('debtor_branch_id'),
//             "type_no"=>$type_no,
//             "reference"=>$reference,
//             "trans_date"=>date2Sql($this->input->post('trans_date')),
//             'person_id' => $user['id'],
//             'remarks' => $this->input->post('remarks'),
//             'loc_code' => $this->input->post('loc_code'),
//             't_amount' => 0
//         );
//         // echo var_dump($items);
//         if($this->input->post('form_mod_id')){
//             $this->sales_model->update_cn_header($items,$this->input->post('form_mod_id'));
//             $id = $this->input->post('form_mod_id');
//             $act = 'update';
//             // $msg = 'Updated Sales Order Details '.$this->input->post('name');
//             $msg = 'Updated Credit Invoice Details ';
//         }else{
//             //$items['reference'] = $reference;
//             $id = $this->sales_model->add_cn_header($items);

//             $refs = array(
//                 'trans_type' => CUSTOMER_CREDIT_NOTE,
//                 'type_no' => $type_no,
//                 'reference' => $reference
//                 );

//             $this->site_model->add_trans_ref($refs);
//             $act = 'add';
//             $msg = 'Added new Credit Invoice ';
//         }

//         echo json_encode(array("id"=>$id,"desc"=>'',"act"=>$act,'msg'=>$msg));
//     }

//     public function cn_items_load($cn_id=null){
//         $this->load->model('core/sales_model');
//         $this->load->helper('core/sales_helper');

//         $details = $this->sales_model->get_cn_items(null,$cn_id);
//         // $sos = $this->sales_model->get_so_header($so_id);
//         // $so=$sos[0];

//         $data['code'] = cnItemsLoad($cn_id,$details);
//         $data['load_js'] = 'core/sales.php';
//         $data['use_js'] = 'cnItemsLoadJs';
//         $this->load->view('load',$data);
//     }
//     public function cn_items_db(){

//         if (!$this->input->post())
//             header('Location'.base_url().'sales/credit_note');

//         $user            = $this->session->userdata('user');
//         $line_total      = 0;
//         $percent_dec_val = $disc_val = $disc_price = 0;

//         $cn_id      = $this->input->post('_cn_id');

//         $where_array = array();
//         $where_array[] = array('key'=>'debtor_trans.id','value'=>$cn_id,'escape'=>true);
//         $cn_details = $this->sales_model->get_debtor_trans($where_array);

//         if (!$cn_details)
//             header('Location'.base_url().'sales/credit_note');
//         else
//             $cn_details = $cn_details[0];

//         $item_id    = $this->input->post('item-id');
//         $line_total = $this->input->post('unit_price')*$this->input->post('qty_delivered');

//         $percent_dec_val = $this->input->post('discount_percentage')/100;
//         $disc_val        = $line_total*$percent_dec_val;
//         $disc_price      = $line_total-$disc_val;

//         $items = array(
//             'debtor_trans_type'   => $cn_details->trans_type,
//             'debtor_type_no'      => $cn_details->type_no,
//             'stock_id'            => $item_id,
//             'unit_price'          => $this->input->post('unit_price'),
//             'uom_id'              => $this->input->post('item-uom'),
//             'qty'                 => $this->input->post('qty_delivered'),
//             'discount_percentage' => $this->input->post('discount_percentage'),
//             'stock_category'      => $this->input->post('stock_category')
//         );

//         $id = $this->sales_model->write_debtor_trans_details($items);
//         $act = "add";
//         $msg = "Added New Item ".$this->sales_model->item_name($item_id);

//         $this->make->sRow(array('id'=>'row-'.$id));
//             $this->make->td($this->input->post('stock_category'));
//             $this->make->td($this->sales_model->item_name($item_id));
//             $this->make->td(num($this->input->post('qty_delivered')));
//             $this->make->td(num($this->input->post('unit_price')));
//             $this->make->td($this->input->post('discount_percentage'));
//             $this->make->td(num($disc_price));
//             $a = $this->make->A(fa('fa-trash-o fa-fw fa-lg'),'#',array('id'=>'del-'.$id,'return'=>true));
//             $this->make->td($a);
//         $this->make->eRow();
//         $row = $this->make->code();

//     # Update CN header
//         $cn_item_array = array();
//         $cn_item_array[] = array('column'=>'t_amount','value'=>'IFNULL(t_amount,0)+'.$disc_price,'escape'=>false);
//         $where = array(
//             'trans_type'   => $cn_details->trans_type,
//             'type_no'      => $cn_details->type_no,
//             );

//         $this->sales_model->update_debtor_trans_set($cn_item_array,$where);

//     # Insert Stock Moves
//         $stock_moves_array = array(
//             'item_id' => $items['stock_id'],
//             'trans_type' => $items['debtor_trans_type'],
//             'type_no' => $items['debtor_type_no'],
//             'trans_date' => date('Y-m-d'),
//             'loc_code'=> $cn_details->loc_code,
//             'person_id' => $user['id'],
//             'qty' => $items['qty'],
//             'visible' => 1,
//             'reference' => $cn_details->reference,
//             'movement_type' => 'adjustment',
//             'reference_link' => $id
//             );
//         $this->load->model('core/purchasing_model');
//         $stock_move_id = $this->purchasing_model->add_stockmoves($stock_moves_array);

//         $echo_array = array('row'=>$row,'msg'=>$msg,'act'=>$act,'id'=>$id);
//         echo json_encode($echo_array);
//     }
//     public function remove_cn_item(){
//         $this->sales_model->delete_cn_trans_item($this->input->post('cn_item_id'));
//         $json['msg'] = "Item Deleted.";
//         $json['id'] = $this->input->post('cn_item_id');
//         echo json_encode($json);
//     }
//     public function show_add_non_stock_cn_item($cn_id)
//     {
//         $this->make->sForm('sales/non_stock_cn_items_db',array('id'=>'frm-non-stock'));
//             $this->make->hidden('cn_id',$cn_id);
//             $this->make->hidden('stock_category',LOCAL_ITEM);
//             $this->make->sDivRow();
//                 $this->make->sDivCol(6);
//                     $this->make->select(
//                                 'Hardware item',
//                                 'hd_item_code',
//                                 null,
//                                 null,
//                                 array(
//                                     'class'=>'selectpicker with-ajax',
//                                     'data-live-search'=>"true"
//                                 )
//                             );
//                 $this->make->eDivCol();

//             $this->make->eDivRow();
//             $this->make->sDivRow();
//                 $this->make->sDivCol(6);
//                     $this->make->sDivRow();
//                         $this->make->sDivCol(9);
//                             $this->make->input('Item code','item_code',null,'Type item code',array('class'=>'rOkay'));
//                         $this->make->eDivCol();
//                     $this->make->eDivRow();
//                     $this->make->sDivRow();
//                         $this->make->sDivCol();
//                             $this->make->input('Item name','name',null,'Type item name',array('class'=>'rOkay','maxlength'=>'50'));
//                             $this->make->textarea('Description','description','','Description',array('style'=>'resize:vertical;','maxlength'=>'255'));
//                             $this->make->taxTypeDrop('Tax type','item_tax_type','',null,array('class'=>'rOkay'));
//                         $this->make->eDivCol();
//                     $this->make->eDivRow();
//                 $this->make->eDivCol();
//                 $this->make->sDivCol(6);
//                     $this->make->sDivRow();
//                         $this->make->sDivCol(6);
//                             $this->make->decimal('Quantity on hand','qoh',null,null,2,array('class'=>'numbers-only input_form this_qty','disabled'=>'disabled'));
//                         $this->make->eDivCol();
//                         $this->make->sDivCol(6);
//                             $this->make->inventoryLocationsDrop('Location','loc_code',null,null,array('readOnly'=>'readOnly'));
//                         $this->make->eDivCol();
//                     $this->make->eDivRow();
//                     $this->make->sDivRow();
//                         $this->make->sDivCol(6);
//                             $this->make->decimal('Quantity','qty_delivered',null,null,2,array('class'=>'rOkay numbers-only input_form this_qty'));
//                         $this->make->eDivCol();
//                         $this->make->sDivCol(6);
//                             $this->make->uomDrop('Unit of Measure','uom_id',null,null,array('class'=>'rOkay input_form'));
//                         $this->make->eDivCol();
//                     $this->make->eDivRow();

//                     $this->make->sDivRow();
//                         $this->make->sDivCol(6);
//                             $this->make->decimal('Price','unit_price','0.00',null,2,array('class'=>'rOkay numbers-only input_form'));
//                         $this->make->eDivCol();
//                         $this->make->sDivCol(6);
//                             $this->make->decimal('Discount','discount_percentage','0.00',null,2,array('class'=>'rOkay numbers-only input_form'),'','%');
//                         $this->make->eDivCol();

//                     $this->make->eDivRow();
//                 $this->make->eDivCol();
//         $this->make->eForm();

//         $code = $this->make->code();

//         $data['code'] = $code;
//         $data['add_css'] = array(
//             'css/bootstrap-select/bootstrap-select.css',
//             'css/bootstrap-select/ajax-bootstrap-select.css',
//         );
//         $data['add_js'] = array(
//             'js/plugins/bootstrap-select/bootstrap-select.min.js',
//             'js/plugins/bootstrap-select/ajax-bootstrap-select.min.js',
//         );
//         $data['load_js'] = 'core/sales.php';
//         $data['use_js'] = 'nonStockLoadJs';
//         $this->load->view('load',$data);
//     }
//     public function non_stock_cn_items_db(){
//         // if (!$this->input->post())
//         //     header('Location'.base_url().'sales/credit_note');

//         $line_total=0;
//         $percent_dec_val = $disc_val = $disc_price = 0;

//         $user = $this->session->userdata('user');
//         $this->load->model('core/inventory_model');

//         if (!$this->input->post('hd_item_code')) {
//             $trans_items = array(
//                 'item_code' => $this->input->post('item_code'),
//                 'name' => $this->input->post('name'),
//                 'description' => $this->input->post('description'),
//                 'item_tax_type' => $this->input->post('item_tax_type'),
//                 "uom_id"=>$this->input->post('uom_id'),
//                 );

//             $where_array = array();
//             $where_array[] = array('key'=>'non_stock_master.item_code','value'=>$trans_items['item_code'],'escape'=>true);
//             $check_duplicates = $this->sales_model->get_non_stock_items($where_array);

//             if ($check_duplicates) {
//                 echo json_encode(array('error'=>1,'msg'=>'Item code already exists. Please select a new one.'));
//                 return true;
//             }
//             $item_id = $this->sales_model->write_non_stock_items($trans_items);

//             $next_ref  = $this->site_model->get_next_ref(INVENTORY_ADJUSTMENT);
//             $type_no   = $next_ref->next_type_no;
//             $reference = $next_ref->next_ref;

//             $items = array(
//                 "item_id"       => $item_id,
//                 "trans_type"    => INVENTORY_ADJUSTMENT,
//                 "type_no"       => $type_no,
//                 "trans_date"    => date('Y-m-d'),
//                 "loc_code"      => $this->input->post('loc_code'),
//                 "person_id"     => $user['id'],
//                 "qty"           => $this->input->post('qoh'),
//                 "visible"       => 1,
//                 "reference"     => $reference,
//                 "movement_type" => 'beginning'
//             );
//             $this->load->model('core/inventory_model');
//             $this->inventory_model->write_non_stock_movements($items,'single');

//         } else {
//             $item_id = $this->input->post('hd_item_code');

//             $where_array = array();
//             $where_array[] = array('key'=>'non_stock_master.id','value'=>$item_id,'escape'=>true);
//             $get_data = $this->sales_model->get_non_stock_items($where_array);

//             if (!$get_data) {
//                 echo json_encode(array('error'=>1,'msg'=>'Item details not found. Please try again.'));
//                 return true;
//             }

//             $get_data = $get_data[0];
//             $trans_items = array(
//                 'item_code' => $get_data->item_code,
//                 'name' => $get_data->name,
//                 'description' => $get_data->description,
//                 'item_tax_type' => $get_data->item_tax_type,
//                 "uom_id"=>$get_data->uom_id,
//                 );
//         }

//         // $trans_items = array(
//         //     'item_code'     => $this->input->post('item_code'),
//         //     'name'          => $this->input->post('name'),
//         //     'description'   => $this->input->post('description'),
//         //     'item_tax_type' => $this->input->post('item_tax_type'),
//         //     );
//         // $item_id = $this->sales_model->write_non_stock_items($trans_items);


//         $cn_id = $this->input->post('cn_id');
//         $where_array = array();
//         $where_array[] = array('key'=>'debtor_trans.id','value'=>$cn_id,'escape'=>true);
//         $cn_details = $this->sales_model->get_debtor_trans($where_array);

//         if (!$cn_details)
//             header('Location'.base_url().'sales/credit_note');
//         else
//             $cn_details = $cn_details[0];


//         $line_total = $this->input->post('unit_price')*$this->input->post('qty_delivered');

//         $percent_dec_val = $this->input->post('discount_percentage')/100;
//         $disc_val = $line_total*$percent_dec_val;
//         $disc_price = $line_total-$disc_val;


//         $items = array(
//             'debtor_trans_type'   => $cn_details->trans_type,
//             'debtor_type_no'      => $cn_details->type_no,
//             'stock_id'            => $item_id,
//             'unit_price'          => $this->input->post('unit_price'),
//             'uom_id'              => $this->input->post('uom_id'),
//             'qty'                 => $this->input->post('qty_delivered'),
//             'discount_percentage' => $this->input->post('discount_percentage'),
//             'stock_category'      => $this->input->post('stock_category'),
//             'description'         => $trans_items['description']
//         );

//         $id = $this->sales_model->write_debtor_trans_details($items);
//         $act = "add";
//         $msg = "Added New Item ".$trans_items['name'];


//         /* Non-stock movements */
//         $non_stock_moves[] = array(
//             'item_id'     => $item_id,
//             'trans_type'  => $cn_details->trans_type,
//             'type_no'     => $cn_details->type_no,
//             'trans_date'  => date('Y-m-d'),
//             'loc_code'    => $cn_details->loc_code,
//             'reference'   => $cn_details->reference,
//             'person_id'   => $user['id'],
//             'qty'         => $items['qty'],
//             'visible'     => 1
//             );
//         $this->inventory_model->write_non_stock_movements($non_stock_moves);


//         # Update CN header
//         $cn_item_array = array();
//         $cn_item_array[] = array('column'=>'t_amount','value'=>'IFNULL(t_amount,0)+'.$disc_price,'escape'=>false);
//         $where = array(
//             'trans_type'   => $cn_details->trans_type,
//             'type_no'      => $cn_details->type_no,
//             );

//         $this->sales_model->update_debtor_trans_set($cn_item_array,$where);

//         $this->make->sRow(array('id'=>'row-'.$id));
//             // $this->make->td($this->sales_model->item_name_with_code($item_id));
//             $this->make->td($items['stock_category']);
//             $this->make->td($trans_items['name']);
//             $this->make->td(num($items['qty']));
//             $this->make->td(num($items['unit_price']));
//             $this->make->td($items['discount_percentage']);
//             $this->make->td(num($disc_price));
//             $a = $this->make->A(fa('fa-trash-o fa-fw fa-lg'),'#',array('id'=>'del-'.$id,'return'=>true));
//             $this->make->td($a);
//         $this->make->eRow();
//         $row = $this->make->code();

//         $echo_array = array('row'=>$row,'msg'=>$msg,'act'=>$act,'id'=>$id);
//         if ($this->input->post('discount_percentage') > DISCOUNT_THRESHOLD)
//             $echo_array['underpriced_msg'] = "Item added is underpriced. Sales Order subjected for approval.";

//         echo json_encode($echo_array);
//     }
//     public function invoice_inquiry()
//     {
//         //$this->session->unset_userData('checkbox_sess');
//         $data = $this->syter->spawn('sales');

//         $data['page_title'] = fa('fa fa-newspaper-o')." Invoice Inquiry";
//         $data['code'] = build_invoice_inquiries();
//         $data['add_css'][] = 'css/daterangepicker/daterangepicker-bs3.css';
//         $data['add_js'][] = 'js/plugins/daterangepicker/daterangepicker.js';
//         $data['load_js'] = 'core/sales.php';
//         $data['use_js'] = 'salesInvoiceJs';
//         $this->load->view('page',$data);
//     }
//     public function invoice_inquiries_results()
//     {
//         if (!$this->input->post('daterange'))
//             header('Location:'.base_url().'sales/invoice_inquiry');

//         $debtor_id = $this->input->post('debtor_id');
//         $daterange = $this->input->post('daterange');

//         $dates = explode(" to ",$daterange);
//         $date_from = (empty($dates[0]) ? date('Y-m-d') : date('Y-m-d',strtotime($dates[0])));
//         $date_to = (empty($dates[1]) ? date('Y-m-d') : date('Y-m-d',strtotime($dates[1])));

//         $where_array = array();
//         if ($debtor_id)
//             $where_array[] = array('key'=>'`debtor_trans`.`debtor_id`','value'=>(int) $debtor_id,'escape'=>true);
//         $where_array[] = array('key'=>'debtor_trans.trans_date >=','value'=>$date_from,'escape'=>true);
//         $where_array[] = array('key'=>'debtor_trans.trans_date <=','value'=>$date_to,'escape'=>true);
//         $where_array[] = array('key'=>'debtor_trans.trans_type','value'=>5,'escape'=>true);

//         $results = $this->sales_model->get_sales_invoices($where_array);
//         //echo $this->sales_model->db->last_query();
//         $data['code'] = build_sales_invoice_display($results);
//         $data['load_js'] = 'core/sales.php';
//         $data['use_js'] = 'deliveryDisplayJs';
//         $this->load->view('load',$data);
//     }
//     public function pending_deliveries()
//     {
//         $data = $this->syter->spawn('sales');

//         $data['page_title'] = fa('fa fa-truck')." Delivery Inquiry";
//         $data['code'] = build_delivery_inquiry();
//         $data['add_js'] = array(
//             'js/plugins/bootstrap-select/bootstrap-select.min.js',
//             'js/plugins/bootstrap-select/ajax-bootstrap-select.min.js',
//             'js/plugins/daterangepicker/daterangepicker.js'
//         );
//         $data['add_css'] = array(
//             'css/bootstrap-select/bootstrap-select.css',
//             'css/bootstrap-select/ajax-bootstrap-select.css',
//             'css/daterangepicker/daterangepicker-bs3.css'
//         );
//         $data['load_js'] = 'core/sales.php';
//         $data['use_js'] = 'salesDeliveryInquiryJs';
//         $this->load->view('page',$data);
//     }
//     public function delivery_inquiry_results()
//     {
//         if (!$this->input->post())
//             header('Location:pending_deliveries');

//         $debtor_id = $this->input->post('debtor_id');
//         $daterange = $this->input->post('daterange');
//         $delivery_id = $this->input->post('delivery_id');

//         $dates = explode(" to ",$daterange);
//         $date_from = (empty($dates[0]) ? date('Y-m-d') : date('Y-m-d',strtotime($dates[0])));
//         $date_to = (empty($dates[1]) ? date('Y-m-d') : date('Y-m-d',strtotime($dates[1])));

//         $where_array = array();
//         if ($delivery_id)
//             $where_array[] = array('key'=>'debtor_trans.id','value'=>$delivery_id,'escape'=>true);
//         else {
//             if ($debtor_id)
//                 $where_array[] = array('key'=>'`debtor_trans`.`debtor_id`','value'=>(int) $debtor_id,'escape'=>true);
//             if ($dates) {
//                 $where_array[] = array('key'=>'debtor_trans.trans_date >=','value'=>$date_from,'escape'=>true);
//                 $where_array[] = array('key'=>'debtor_trans.trans_date <=','value'=>$date_to,'escape'=>true);
//             }
//         }
//         $where_array[] = array('key'=>'debtor_trans.trans_type','value'=>DELIVERY_NOTE,'escape'=>true);
//         $where_array[] = array('key'=>'debtor_trans.tar_trans_type IS NULL','value'=>null,'escape'=>false);
//         $where_array[] = array('key'=>'debtor_trans.tar_type_no IS NULL','value'=>null,'escape'=>false);

//         $results = $this->sales_model->get_delivery_header($where_array,true);
//         $data['code'] = build_delivery_display($results);
//         $data['load_js'] = 'core/sales.php';
//         $data['use_js'] = 'deliveryDisplayJs';
//         $this->load->view('load',$data);
//     }
//     public function search_sales_delivery()
//     {
//         if (!$this->input->post())
//             header('Location:pending_deliveries');

//         $reference = $this->input->post('q');

//         $where_array = array();
//         $where_array[] = array('key'=>'debtor_trans.trans_type','value'=>DELIVERY_NOTE,'escape'=>true);
//         $where_array[] = array('key'=>'debtor_trans.tar_trans_type IS NULL','value'=>null,'escape'=>false);
//         $where_array[] = array('key'=>'debtor_trans.tar_type_no IS NULL','value'=>null,'escape'=>false);
//         if ($reference !== "")
//             $where_array[] = array('key'=>'debtor_trans.reference LIKE ','value'=>"%$reference%",'escape'=>true);

//         $results = $this->sales_model->get_delivery_header($where_array,true,10);

//         $json_array = array();
//         foreach ($results as $val) {
//             $json_array[] = array(
//                 'Id' => $val->id,
//                 'Text' => $val->reference,
//                 'Subtext' => '<br/>'.$val->customer_branch.'<br/>Created on '.$val->created_on
//                 );
//         }
//         echo json_encode($json_array);
//     }
//     public function delivery_returns($reference)
//     {
//         $data = $this->syter->spawn('sales');

//         $where_array = array();
//         $where_array[] = array('key'=>'debtor_trans.reference','value'=>$reference,'escape'=>true);
//         $where_array[] = array('key'=>'debtor_trans.trans_type','value'=>DELIVERY_NOTE,'escape'=>true);
//         $where_array[] = array('key'=>'debtor_trans.tar_trans_type IS NULL','value'=>null,'escape'=>false);
//         $where_array[] = array('key'=>'debtor_trans.tar_type_no IS NULL','value'=>null,'escape'=>false);
//         $delivery_info = $this->sales_model->get_delivery_header($where_array,true);

//         if (!$delivery_info) {
//             site_alert('No delivery found for that reference','error');
//             header('Location:'.base_url().'sales/pending_deliveries');
//         }

//         $delivery_items = $this->sales_model->view_sales_delivery_items(array('delivery_no'=>$delivery_info[0]->id));

//         if (!$delivery_items) {
//             site_alert('Delivery has no items. Unable to proceed','error');
//             header('Location:'.base_url().'sales/pending_deliveries');
//         }

//         $next_ref_info = $this->site_model->get_next_ref(DELIVERY_RETURN);
//         $next_ref = $this->site_model->check_duplicate_ref(DELIVERY_RETURN,$next_ref_info->next_ref);

//         $data['page_title'] = fa('fa fa-history')." Return items for Delivery # ".$delivery_info[0]->reference;
//         $data['code'] = build_delivery_return($next_ref,$delivery_info[0],$delivery_items);
//         $data['load_js'] = 'core/sales.php';
//         $data['use_js'] = 'deliveryReturnJs';
//         $this->load->view('page',$data);
//     }
//     public function process_delivery_return()
//     {
//     # Filter URL non-POST request
//         if (!$this->input->post())
//             header('Location:'.base_url().'sales/pending_deliveries');

//         $delivery_ref = $this->input->post('delivery_ref');
//         $where_array = array();
//         $where_array[] = array('key'=>'debtor_trans.reference','value'=>$delivery_ref,'escape'=>true);
//         $where_array[] = array('key'=>'debtor_trans.trans_type','value'=>DELIVERY_NOTE,'escape'=>true);
//         $where_array[] = array('key'=>'debtor_trans.tar_trans_type IS NULL','value'=>null,'escape'=>false);
//         $where_array[] = array('key'=>'debtor_trans.tar_type_no IS NULL','value'=>null,'escape'=>false);
//         $delivery_info = $this->sales_model->get_delivery_header($where_array,true);

//     # Filter non-existent Delivery
//         if (!$delivery_info) {
//             echo json_encode(array('status'=>'error','msg'=>'No info found for delivery # '.$delivery_ref));
//             header('Location:'.base_url().'sales/pending_deliveries');
//             return false;
//         }

//     # Retrieve initial variables
//         # set retrieved delivery info
//         $delivery_info = $delivery_info[0];

//         # get user data
//         $user = $this->session->userdata('user');

//         # get post, saved delivery items
//         $post_delivery_items = $this->input->post('delivery');
//         $db_delivery_items = $this->sales_model->view_sales_delivery_items(array('delivery_no'=>$delivery_info->id));

//         if (!$db_delivery_items) {
//             echo json_encode(array('status'=>'error','msg'=>'No items found for delivery # '.$delivery_ref));
//             header('Location:'.base_url().'sales/pending_deliveries');
//             return false;
//         }

//         $stocks = array();
//         foreach ($db_delivery_items as $val) {
//             $stocks[$val->stock_category][$val->details_id] = array(
//                 'stock_id'            => $val->stock_id,
//                 'unit_price'          => $val->unit_price,
//                 'unit_tax'            => $val->unit_tax,
//                 'uom_id'              => $val->uom_id,
//                 'qty'                 => $val->delivered_qty,
//                 'discount_percentage' => $val->discount_percentage,
//                 'description'         => $val->description
//                 );
//         }

//     # Start DB variables
//         # identify next transaction references
//         $next_ref_info = $this->site_model->get_next_ref(DELIVERY_RETURN);
//         $next_ref = ($this->input->post('delivery_ret_ref') ? $this->input->post('delivery_ret_ref') : $next_ref_info->next_ref);
//         $next_ref = $this->site_model->check_duplicate_ref(DELIVERY_RETURN,$next_ref);
//         $next_type_no = $next_ref_info->next_type_no;

//         # trans details
//         $return_details = array(
//             'trans_type'       => DELIVERY_RETURN,
//             'type_no'          => $next_type_no,
//             'reference'        => $next_ref,
//             'debtor_id'        => $this->input->post('debtor_id'),
//             'debtor_branch_id' => $this->input->post('debtor_branch_id'),
//             'trans_date'       => date('Y-m-d'),
//             't_shipping_cost'  => $this->input->post('deliv_shipping_cost'),
//             'loc_code'         => $this->input->post('to_loc'),
//             'shipper_id'       => $delivery_info->shipper_id,
//             'src_trans_type'   => $delivery_info->trans_type,
//             'src_type_no'      => $delivery_info->type_no,
//             'remarks'          => $this->input->post('remarks'),
//             'person_id'        => $user['id']
//             );

//         // # initialize moves variables
//         $non_stock_moves = $stock_moves = $debtor_trans_details = $_update_trans_details = array();
//         $moves_total = 0;
//         $is_settled = false;
//         $same_item_count = true;
//         foreach ($post_delivery_items as $stock_category => $itemx) {
//             foreach ($itemx as $details_id => $qty) {
//                 if (!$qty) {
//                     $same_item_count = false;
//                     continue;
//                 }

//                 if (!isset($stocks[$stock_category][$details_id]))
//                     continue;

//                 $debtor_trans_details[] = array(
//                     'debtor_trans_type'   => $return_details['trans_type'],
//                     'debtor_type_no'      => $return_details['type_no'],
//                     'stock_id'            => $stocks[$stock_category][$details_id]['stock_id'],
//                     'description'         => $stocks[$stock_category][$details_id]['description'],
//                     'unit_price'          => $stocks[$stock_category][$details_id]['unit_price'],
//                     'uom_id'              => (int) $stocks[$stock_category][$details_id]['uom_id'],
//                     'qty'                 => $qty,
//                     'discount_percentage' => $stocks[$stock_category][$details_id]['discount_percentage'],
//                     'stock_category'      => $stock_category,
//                 );

//                 $_update_trans_details[] = array(
//                     'debtor_trans_type'   => $return_details['src_trans_type'],
//                     'debtor_type_no'      => $return_details['src_type_no'],
//                     'id'                  => $details_id,
//                     'qty'                 => $qty,
//                 );

//                 # compute line price
//                 $moves_total += $qty
//                     * $stocks[$stock_category][$details_id]['unit_price']
//                     * ((100 - $stocks[$stock_category][$details_id]['discount_percentage']) / 100);

//                 # Filter NON-STOCK IMPORT ITEMS
//                 if ($stock_category == LOCAL_ITEM)
//                     $non_stock_moves[] = array(
//                         'item_id'     => $stocks[$stock_category][$details_id]['stock_id'],
//                         'trans_type'  => DELIVERY_RETURN,
//                         'type_no'     => $return_details['type_no'],
//                         'trans_date'  => $return_details['trans_date'],
//                         'loc_code'    => $return_details['loc_code'],
//                         'reference'   => $return_details['reference'],
//                         'person_id'   => $return_details['person_id'],
//                         'qty'         => $qty,
//                         'visible'     => 1
//                         );
//                 else
//                     $stock_moves[] = array(
//                         'item_id'     => $stocks[$stock_category][$details_id]['stock_id'],
//                         'trans_type'  => DELIVERY_RETURN,
//                         'type_no'     => $return_details['type_no'],
//                         'trans_date'  => $return_details['trans_date'],
//                         'loc_code'    => $return_details['loc_code'],
//                         'reference'   => $return_details['reference'],
//                         'person_id'   => $return_details['person_id'],
//                         'qty'         => $qty,
//                         'visible'     => 1
//                         );
//                 # Start stock moves for STOCK ITEMS

//                 # add to stock dump
//             }
//         }

//         # start db writing
//         $this->load->model('core/inventory_model');

//         $this->sales_model->db->trans_start();
//         $this->inventory_model->db->trans_start();
//         $this->site_model->db->trans_start();

//         $return_details['t_amount'] = $return_details['t_shipping_cost'] + $moves_total;

//         $this->sales_model->write_debtor_trans($return_details);
//         $this->sales_model->write_debtor_trans_details($debtor_trans_details,true);
//         foreach ($_update_trans_details as $val) {
//             $detail = array();
//             $detail[] = array('column'=>'qty','value'=>'qty - '.$val['qty'],'escape'=>false);
//             $where = array(
//                 'id'                => $val['id'],
//                 'debtor_trans_type' => $val['debtor_trans_type'],
//                 'debtor_type_no'    => $val['debtor_type_no']
//             );
//             $this->sales_model->update_debtor_trans_details_set($detail,$where);
//         }
//         $debtor_detail = array();
//         $debtor_detail[] = array('column'=>'t_amount','value'=>'t_amount - '.$return_details['t_amount'],'escape'=>false);
//         $debtor_detail[] = array('column'=>'t_shipping_cost','value'=>'t_shipping_cost - '.$return_details['t_shipping_cost'],'escape'=>false);
//         $where = array(
//             'trans_type' => $return_details['src_trans_type'],
//             'src_type_no' => $return_details['src_type_no'],
//             );
//         $this->sales_model->update_debtor_trans_set($debtor_detail,$where);
//         if ($stock_moves)
//             $this->inventory_model->write_item_movements($stock_moves,'batch');
//         if ($non_stock_moves)
//             $this->inventory_model->write_non_stock_movements($non_stock_moves,'batch');
//         $this->site_model->add_trans_ref(
//             array(
//                 'trans_type' => DELIVERY_RETURN,
//                 'type_no'    => $return_details['type_no'],
//                 'reference'  => $return_details['reference']
//                 )
//             );

//         $this->sales_model->db->trans_complete();
//         $this->inventory_model->db->trans_complete();
//         $this->site_model->db->trans_complete();

//         site_alert('Delivery Return # '.$return_details['reference'].' has been processed','success');
//     }
  
//  //----------SALES MAINTENANCE FUNCTIONS----------START

// //----------CUSTOMER MASTER----------START 

//  public function customer_master($ref=''){
//    $data = $this->syter->spawn('customer_master');
//    $data['page_title'] = fa('fa-users fa-fw')." Customer Master";
//    // $data['page_subtitle'] = "Customer Master";
//    $items = $this->sales_model->get_customer_master();
//    //echo $this->db->last_query();
//    $data['code'] = customer_master_form($items);
//    $data['add_js'] = 'js/site_list_forms.js';
//         // $data['load_js'] = "core/sales.php";
//    // $data['use_js'] = "maintenanceCustomerMasterJS";
//    $this->load->view('page',$data);
//     }
//  public function manage_customer_master($cust_id=null){
//         $data = $this->syter->spawn('customer_master');
//    $data['page_title'] = fa('fa-users fa-fw')." Customer Master";
//         $data['page_subtitle'] = "Manage Customer Details";
//         $items = null;

//         if($cust_id != null){
//              $details = $this->sales_model->get_customer_master($cust_id);
//             $items = $details[0];
//         }

//         $data['code'] = manage_customer_master_form($items);

//         $data['add_js'] = 'js/site_list_forms.js';
//         $data['load_js'] = "core/sales.php";
//         $data['use_js'] = "maintenanceCustomerMasterJS";
//         $this->load->view('page',$data);
//     }
//  public function customer_details_db()
//  {
//    $user = $this->session->userdata('user');
//    // if (!$this->input->post())
//      // header("Location:".base_url()."items");
//    $status = $item_exist = "";
//    $items = array(
//      'cust_code' => $this->input->post('cust_code'),
//      'description' => $this->input->post('description'),
//      'house_no' => $this->input->post('house_no'),
//      'street' => $this->input->post('street'),
//      'street' => $this->input->post('street'),
//      'brgy' => $this->input->post('brgy'),
//      'city' => $this->input->post('city'),
//      'birthday' => date('Y-m-d', strtotime($this->input->post('birthday'))),
//      'tel_no' => $this->input->post('tel_no'),
//      'mobile_no' => $this->input->post('mobile_no'),
//      'email_address' => $this->input->post('email_address'),
//      'cust_type_id' => (int)$this->input->post('cust_type_id'),
//      // 'referred_by' => $this->input->post('referred_by'),
//      'sales_person_id' => (int)$this->input->post('sales_person_id'),
//      // 'credit_limit' => $this->input->post('credit_limit'),
//      'fb_account' => $this->input->post('fb_account'),
//      // 'inactive' => (int)$this->input->post('inactive'),
//      'disc_percent_1' => $this->input->post('disc_percent1'),
//      'disc_amount_1' => $this->input->post('disc_amount1'),
//      'disc_percent_2' => $this->input->post('disc_percent2'),
//      'disc_amount_2' => $this->input->post('disc_amount2'),
//      'disc_percent_3' => $this->input->post('disc_percent3'),
//      'disc_amount_3' => $this->input->post('disc_amount3')
//    );
    
//    $mode = $this->input->post('mode');
//    // echo "Mode : ".$mode."<br>";
    
//    if($mode == 'add')
//      $item_exist = $this->sales_model->customer_code_exist_add_mode($this->input->post('cust_code'));
//    else if($mode == 'edit')
//      $item_exist = $this->sales_model->customer_code_exist_edit_mode($this->input->post('cust_code'), $this->input->post('cust_id'));
    
//    // echo "Product Code exist : ".$product_code_exist."<br>";
    
//    if($item_exist){
//      $id = '';
//      $msg = "WARNING : Customer Code [ ".$this->input->post('cust_code')." ] already exists!";
//      $status = "warning";
//    }else{
//      if ($this->input->post('cust_id')) {
//        $id = $this->input->post('cust_id');
//        $this->sales_model->update_customer($items,$id);
//        $msg = "Updated Customer : ".ucwords($this->input->post('description'));
//        $status = "success";
//      }else{
//        $id = $this->sales_model->add_customer($items);
        
//        ##########AUDIT TRAIL [START]##########
//        $audit_items = array(
//        'type'=>0,
//        'trans_no'=>0,
//        'type_desc'=>ADD_CUSTOMER,
//        'description'=>'cust_id:'.$id.'||cust_code:"'.strtoupper($this->input->post('cust_code')).'"||description:"'.ucfirst($this->input->post('description')).'"',
//        'user'=>$user['id']
//        );
        
//        $audit_id = $this->sales_model->write_to_audit_trail($audit_items);
//        ##########AUDIT TRAIL [END]##########
        
//        $msg = "Added New Customer : ".ucwords($this->input->post('description'));
//        $status = "success";
//      }
//    }
    
//    // echo var_dump($items)."<br>";
//    // echo "Current Status : ".$status."<br>";
//    echo json_encode(array('status'=>$status, 'id'=>$id,'msg'=>$msg));
//  }
//  //----------CUSTOMER MASTER----------END
  
  
//  //----------CUSTOMER CARD TYPES----------START - made by adoneza  move from customer to sales  - rhan (galing sa customer na nilipat sa sales ^_^ isakaling di maintindihan ang barok kung english ahaha)

//  public function customer_card_types($ref=''){
//    $data = $this->syter->spawn('sales');
//    $data['page_subtitle'] = "Customer Card Types";
//    $customerCardTypes = $this->sales_model->get_customer_card_types();
//    //echo $this->db->last_query();
//    $data['code'] = CustomerCardTypesPage($customerCardTypes);
//    $data['add_js'] = 'js/site_list_forms.js';
//         $data['load_js'] = "core/customer.php";
//         $data['use_js'] = "CustomerCardTypesJS";
//    $this->load->view('page',$data);
//     }
  
//  public function manage_customer_card_types($cct_id=null){
     
//         $data = $this->syter->spawn('sales');
//    $cct = null;
//        if (is_null($cct_id)){
//      $data['page_title'] = fa('fa-credit-card fa-fw')." Add New Customer Card Types";
//    }else {
//      $cct= $this->sales_model->get_customer_card_types($cct_id);
//      $cct = $cct[0];
//      if (!empty($cct->id)) {
//        $data['page_title'] = fa('fa-credit-card fa-fw')." ".iSetObj($cct,'name');
//      } else {
//        header('Location:'.base_url().'sales/manage_customer_card_types');
//      }
//    }
//         $data['code'] = CustomerCardTypesForm($cct);

//         $data['add_js'] = 'js/site_list_forms.js';
//         $data['load_js'] = "core/sales.php";
//         $data['use_js'] = "CustomerCardTypesJS";
//         $this->load->view('page',$data);
//     }
//  public function customer_card_types_details_db()
//  {
//    $user = $this->session->userdata('user');
//    $status = "";
//    $items = array(
//      'name' => $this->input->post('name'),
//      'description' => $this->input->post('description'),
//      'min_purchased_amt' => $this->input->post('min_purchased_amt'),
//      'inactive' => $this->input->post('inactive'),
//    );
//    $mode = $this->input->post('mode');
    
//    if($mode == 'add')
//      $name_exist = $this->sales_model->customer_card_types_exist_add_mode($this->input->post('name'));
//    else if($mode == 'edit')
//      $name_exist = $this->sales_model->customer_card_types_exist_edit_mode($this->input->post('name'), $this->input->post('id'));
    
//    if($name_exist){
//      $id = '';
//      $msg = "WARNING : Card Type Name [ ".$this->input->post('name')." ] already exists!";
//      $status = "warning";
//    }else{
//      if ($this->input->post('id')) {
//        $id = $this->input->post('id');
//        $this->sales_model->update_customer_card_types($items,$id);
//        $msg = "Updated Location : ".ucwords($this->input->post('name'));
//        $status = "success";
//      }else{
//        $id = $this->sales_model->add_customer_card_types($items);
//        ##########AUDIT TRAIL [START]##########
//        $audit_items = array(
//        'type'=>0,
//        'trans_no'=>0,
//        'type_desc'=>ADD_CUSTOMER_CARD_TYPES,
//        'description'=>'id:'.$id.'||name:"'.strtoupper($this->input->post('name')).'"||description:"'.ucfirst($this->input->post('description')).'"',
//        'user'=>$user['id']
//        );
        
//        $audit_id = $this->sales_model->write_to_audit_trail($audit_items);
//        ##########AUDIT TRAIL [END]##########
//        $msg = "Added New Stock Location: ".ucwords($this->input->post('name'));
//        $status = "success";
//      }
//    }
//    echo json_encode(array('status'=>$status, 'id'=>$id,'msg'=>$msg));
//  }
  
//  //----------CUSTOMER CARD TYPES----------END -rhan
  
  
//  //----------CUSTOMER CARD ---------START -rhan
  
//    public function customer_cards($ref='')
//    {
//    $data = $this->syter->spawn('sales');
//         $data['page_subtitle'] = "Customer Cards";
//    $cust = $this->sales_model->get_cust_cards();
//         $data['code'] = customer_cards_page($cust);
//         $this->load->view('page',$data);
//    }
  
//    public function manage_customer_cards($id=null)
//    {
//         $data = $this->syter->spawn('sales');
//         $data['page_subtitle'] = "Manage Customer Cards";
//         $items = null;
//         $receive_cart = array();

//         if($id != null)
//    {
//    $details = $this->sales_model->get_cust_cards($id);
//    $items = $details[0];
//    }

//         $data['code'] = manage_customer_cards_form($items);
//         $data['add_js'] = 'js/site_list_forms.js';
//         $data['load_js'] = "core/sales.php";
//         $data['use_js'] = "customerCards";
//         $this->load->view('page',$data);
//     }
    
//  public function customer_card_details_db(){
  
//    $status = "";
//    $user = $this->session->userdata('user');

//    $items = array(
//      'id' => $this->input->post('id'),
//      'cust_id' => $this->input->post('cust_id'),
//      'card_type' => $this->input->post('card_type'),
//      'card_no' => $this->input->post('card_no'),
//      'card_display_name' => $this->input->post('card_display_name'),
//      'issuance_date' => date2Sql($this->input->post('issuance_date')),
//      'expiry_date' => date2Sql($this->input->post('expiry_date')),
//      'available_points' => $this->input->post('available_points'),
//      'inactive' => $this->input->post('inactive')      
//    );
    
//    $mode = $this->input->post('mode');
  
//    if($mode == 'add')
//      $customer_card_exist = $this->sales_model->cust_card_exist_add_mode($this->input->post('cust_id'), $this->input->post('card_type'));
//    else if($mode == 'edit')
//      $customer_card_exist = $this->sales_model->cust_card_exist_edit_mode($this->input->post('cust_id'),$this->input->post('card_type'),$this->input->post('id'));

//    if($customer_card_exist){
//      $id = '';
//      $msg = "WARNING : Customer Card  [ ".$this->input->post('card_display_name')." ] already exists!";
//      $status = "warning";
      
//    }else{
    
//      if ($this->input->post('id')) {
//        $id = $this->input->post('id');
//        $this->sales_model->update_customer_card($items,$id);
//        $msg = "Updated Customer Card Details: ".ucwords($this->input->post('card_display_name'));
//        $status = "success";
//      }else{
//        $id = $this->sales_model->add_customer_card($items);
//        ##########AUDIT TRAIL [START]##########
//        $audit_items = array(
//        'type'=>0,
//        'trans_no'=>0,
//        'type_desc'=>ADD_CUSTOMER_CARDS,
//        'description'=>'id:'.$id.'||card_no:"'.strtoupper($this->input->post('card_no')).'"||card_name:"'.ucfirst($this->input->post('card_display_name')).'"',
//        'user'=>$user['id']
//        );
        
//        $audit_id = $this->sales_model->write_to_audit_trail($audit_items);
//        ##########AUDIT TRAIL [END]##########
//        $msg = "Added Customer Card Details: ".ucwords($this->input->post('card_display_name'));
//        $status = "success";
//      }
//    }
    
//    // echo var_dump($items)."<br>";
//    // echo "Current Status : ".$status."<br>";
//    echo json_encode(array('status'=>$status, 'id'=>$id,'msg'=>$msg));
//  }
  
//  //----------CUSTOMER CARD ----------END -rhan
  
//  //----------SALES PERSON MASTER----MHAE------START
//  public function sales_person_master($ref=''){
//    $data = $this->syter->spawn('sales_person_master');
//    $data['page_title'] = fa('fa-users fa-fw')." Sales Person Master";
//    $items = $this->sales_model->get_sales_person_master();
//    $data['code'] = sales_person_master_form($items);
//    $data['add_js'] = 'js/site_list_forms.js';
//    $this->load->view('page',$data);
//     }
//  public function manage_sales_person_master($id=null){
//         $data = $this->syter->spawn('sales_person_master');
//    $data['page_title'] = fa('fa-users fa-fw')." Sales Person Master";
//         $data['page_subtitle'] = "Manage Sales Person Details";
//         $items = null;

//         if($id != null){
//              $details = $this->sales_model->get_sales_person_master($id);
//             $items = $details[0];
//         }

//         $data['code'] = manage_sales_person_master_form($items);

//         $data['add_js'] = 'js/site_list_forms.js';
//         $data['load_js'] = "core/sales.php";
//         $data['use_js'] = "maintenanceSalesPersonMasterJS";
//         $this->load->view('page',$data);
//     }
//  public function sales_person_details_db()
//  {
//    // if (!$this->input->post())
//      // header("Location:".base_url()."items");
//    $user = $this->session->userdata('user');
//    $status = $item_exist = "";
//    $items = array(
//      'name' => $this->input->post('name'),
//      'phone' => $this->input->post('phone'),
//      'email_address' => $this->input->post('email_address'),
//      'inactive' => (int)$this->input->post('inactive')
//    );
    
//    $mode = $this->input->post('mode');
    
//    if($mode == 'add')
//      $item_exist = $this->sales_model->sales_person_name_exist_add_mode($this->input->post('name'));
//    else if($mode == 'edit')
//      $item_exist = $this->sales_model->sales_person_name_exist_edit_mode($this->input->post('name'), $this->input->post('id'));
    
//    if($item_exist){
//      $id = '';
//      $msg = "WARNING : Sales Person [ ".$this->input->post('name')." ] already exists!";
//      $status = "warning";
//    }else{
//      if ($this->input->post('id')) {
//        $id = $this->input->post('id');
//        $this->sales_model->update_sales_person($items,$id);
//        $msg = "Updated Sales Person : ".ucwords($this->input->post('name'));
//        $status = "success";
//      }else{
//        $id = $this->sales_model->add_sales_person($items);
//          ##########AUDIT TRAIL [START]##########
//        $audit_items = array(
//        'type'=>0,
//        'trans_no'=>0,
//        'type_desc'=>ADD_SALES_PERSONS,
//        'description'=>'id:'.$id.'||name:"'.strtoupper($this->input->post('name')).'"',
//        'user'=>$user['id']
//        );
        
//        $audit_id = $this->sales_model->write_to_audit_trail($audit_items);
//        ##########AUDIT TRAIL [END]##########
//        $msg = "Added New Sales Person : ".ucwords($this->input->post('name'));
//        $status = "success";
//      }
//    }
    
//    // echo var_dump($items)."<br>";
//    // echo "Current Status : ".$status."<br>";
//    echo json_encode(array('status'=>$status, 'id'=>$id,'msg'=>$msg));
//  }
//  //----------SALES PERSON MASTER-----MHAE-----END
  
//  //----------SALES MAINTENANCE FUNCTIONS----------END
//    public function write_to_audit_trail($items=null){
//    $audit_items = array();
//    $items = $this->input->post('form_vals');
//    $type_desc = $this->input->post('type_desc');
//    // echo $items."<br>";
//    # get user data
//    $user = $this->session->userdata('user');
//    $audit_items = array(
//        'type'=>0,
//        'trans_no'=>0,
//        'type_desc'=>$type_desc,
//        'description'=>$items,
//        'user'=>$user['id']
//        );
//    $this->sales_model->write_to_audit_trail($audit_items);
    
//  }



