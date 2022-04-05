<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {
	var $data = null;
	public function __construct()
	{
		parent::__construct();
		$this->load->model('core/admin_model');
		$this->load->model('core/main_model');
		$this->load->helper('core/admin_helper');
	}
    public function roles(){
        $this->load->model('core/admin_model');
        $this->load->helper('site/site_forms_helper');
        
        $role_list = $this->admin_model->get_user_roles();
        $data = $this->syter->spawn('roles');
        $data['code'] = site_list_form("admin/roles_form","roles_form","Roles List",$role_list,array('role'),"id");
        $data['add_js'] = 'js/site_list_forms.js';
        $this->load->view('page',$data);
    }
    public function roles_form($ref=null){
        $this->load->helper('core/admin_helper');
        $this->load->model('core/admin_model');
        $role = array();
        $access = array();
        if($ref != null){
            $roles = $this->admin_model->get_user_roles($ref);
            $role = $roles[0];
            $access = explode(',',$role->access);
        }
        $navs = $this->syter->get_navs();
        $this->data['code'] = rolesForm($role,$access,$navs);
        $this->data['load_js'] = 'site/admin';
        $this->data['use_js'] = 'rolesJs';
        $this->load->view('load',$this->data);
    }
    public function roles_db(){
        $this->load->model('core/admin_model');
        $links = $this->input->post('roles');
        $role = $this->input->post('role');
        $desc = $this->input->post('description');
        $access = "";
        foreach ($links as $li) {
            $access .= $li.",";
        }
        $access = substr($access,0,-1);
        $items = array(
            "role"=>$role,
            "description"=>$desc,
            "access"=>$access
        );
        if($this->input->post('role_id')){
            $this->admin_model->update_user_roles($items,$this->input->post('role_id'));
            $id = $this->input->post('role_id');
            $act = 'update';
            $msg = 'Updated role '.$role;
        }
        else{
            $id = $this->admin_model->add_user_roles($items);
            $act = 'add';
            $msg = 'Added  new role '.$role;
        }
        echo json_encode(array("id"=>$id,"desc"=>$role,"act"=>$act,'msg'=>$msg));
    }

    /*********************************/
    public function uoms(){
        $this->load->model('core/admin_model');
        $this->load->helper('site/site_forms_helper');
        $uom_list = $this->admin_model->get_uoms();
        $data = $this->syter->spawn('uoms');
        $data['code'] = site_list_form("admin/uoms_form","uoms_form","Unit Of Measurement",$uom_list,array('description'),"uom_id");
        $data['add_js'] = 'js/site_list_forms.js';
        $this->load->view('page',$data);
    }
	
    public function uoms_form($ref=null){
        $this->load->helper('core/admin_helper');
        $this->load->model('core/admin_model');
        $uom = array();
        $access = array();
        if($ref != null){
            $uoms = $this->admin_model->get_uoms($ref);
            $uom = $uoms[0];
        }
        $navs = $this->syter->get_navs();
        $this->data['code'] = uomsForm($uom);
        $this->data['load_js'] = 'site/admin';
        $this->data['use_js'] = 'rolesJs';
        $this->load->view('load',$this->data);
    }
    public function uoms_db(){
        $this->load->model('core/admin_model');
        $name = $this->input->post('name');
        $decimal_places = $this->input->post('decimal_places');
        $desc = $this->input->post('description');
        $items = array(
            "name"=>$name,
            "description"=>$desc,
            "decimal_places"=>$decimal_places
        );
        if($this->input->post('uom_id')){
            $this->admin_model->update_uoms($items,$this->input->post('uom_id'));
            $id = $this->input->post('uom_id');
            $act = 'update';
            $msg = 'Updated uom '.$uom;
        }
        else{
            $id = $this->admin_model->add_uoms($items);
            $act = 'add';
            $msg = 'Added  new uom '.$uom;
        }
        echo json_encode(array("id"=>$id,"desc"=>$role,"act"=>$act,'msg'=>$msg));
    }
    /*********************************/
    public function item_types(){
        $this->load->model('core/admin_model');
        $this->load->helper('site/site_forms_helper');
        $stock_types_list = $this->admin_model->get_stock_tax_types();
        $data = $this->syter->spawn('stock_tax_types');
        $data['code'] = site_list_form("admin/item_tax_types_form","item_tax_types_form","Item Tax Types",$stock_types_list,array('stock_tax_type_code'),"stock_tax_type_id");
        $data['add_js'] = 'js/site_list_forms.js';
        $this->load->view('page',$data);
    }
    public function item_tax_types_form($ref=null){
        $this->load->helper('core/admin_helper');
        $this->load->model('core/admin_model');
        $uom = array();
        $access = array();
        if($ref != null){
            $uoms = $this->admin_model->get_stock_tax_types($ref);
            $uom = $uoms[0];
        }
        $navs = $this->syter->get_navs();
        $this->data['code'] = itemTaxTypesForm($uom);
        $this->data['load_js'] = 'site/admin';
        $this->data['use_js'] = 'rolesJs';
        $this->load->view('load',$this->data);
    }
    /*********************************/
    public function item_categories(){
        $this->load->model('core/admin_model');
        $this->load->helper('site/site_forms_helper');
        $stock_types_list = $this->admin_model->get_stock_categories();
        $data = $this->syter->spawn('stock_tax_types');
        $data['code'] = site_list_form("admin/item_categories_form","item_categories_form","Item Categories",$stock_types_list,array('category_name'),"stock_category_id");
        $data['add_js'] = 'js/site_list_forms.js';
        $this->load->view('page',$data);
    }
    public function item_categories_form($ref=null){
	
        $this->load->helper('core/admin_helper');
        $this->load->model('core/admin_model');
        $cat = array();
        $access = array();
        if($ref != null){
            $cats = $this->admin_model->get_stock_categories($ref);
            $cat = $cats[0];
        }
        $navs = $this->syter->get_navs();
        $this->data['code'] = itemCategoriesForm($cat);
        $this->data['load_js'] = 'site/admin';
        $this->data['use_js'] = 'rolesJs';
        $this->load->view('load',$this->data);
    }
    public function item_categories_db(){
	
        $this->load->model('core/admin_model');
        $items = array();

        if($this->input->post('stock_category_id')){
            $items = array(
                "category_name"=>$this->input->post('category_name')
            );

            $this->admin_model->update_stock_categories($items,$this->input->post('stock_category_id'));
            $id = $this->input->post('stock_category_id');
            $act = 'update';
            $msg = 'Updated category '.$this->input->post('category_name');
        }
        else{
            $items = array(
                "category_name"=>$this->input->post('category_name')
            );

            $id = $this->admin_model->add_stock_categories($items);
            $act = 'add';
            $msg = 'Added  new stock category. '.$this->input->post('category_name');
        }
        echo json_encode(array("id"=>$id,"desc"=>$this->input->post('fname'),"act"=>$act,'msg'=>$msg));
    }
    /*********************************/
    public function items(){
        $this->load->model('core/admin_model');
        $this->load->helper('site/site_forms_helper');
        $item_list = $this->admin_model->get_stock_master();
        $data = $this->syter->spawn('stock_tax_types');
        $data['code'] = site_list_form("admin/items_form","items_form","Items",$item_list,array('brand_name'),"id");
        $data['add_js'] = 'js/site_list_forms.js';
        $this->load->view('page',$data);
    }
    public function items_form($ref=null){
        $this->load->helper('core/admin_helper');
        $this->load->model('core/admin_model');
        $item = array();
        $access = array();
        if($ref != null){
            $items = $this->admin_model->get_stock_master($ref);
            $item = $items[0];
        }
        $navs = $this->syter->get_navs();
        $this->data['code'] = items_form($item);
        $this->data['load_js'] = 'site/admin';
        $this->data['use_js'] = 'rolesJs';
        $this->load->view('load',$this->data);
    }
	//********************Payment Terms*****start
	public function payment_terms(){
        $this->load->model('core/admin_model');
        $this->load->helper('site/site_forms_helper');
        $payment_term_list = $this->admin_model->get_payment_terms();
        $data = $this->syter->spawn('payment_terms');
        $data['code'] = site_list_form("admin/payment_terms_form","payment_terms_form","Payment Terms",$payment_term_list,array('term_name'),"payment_id");
        $data['add_js'] = 'js/site_list_forms.js';
        $this->load->view('page',$data);
    }
    public function payment_terms_form($ref=null){
        $this->load->helper('core/admin_helper');
        $this->load->model('core/admin_model');
        $payment_term = array();
        $access = array();
        if($ref != null){
            $payment_terms = $this->admin_model->get_payment_terms($ref);
            $payment_term = $payment_terms[0];
        }

        $this->data['code'] = paymentTermsForm($payment_term);
		 $this->data['load_js'] = 'site/admin';
        $this->data['use_js'] = 'paymentTermsJs';
        $this->load->view('load',$this->data);
    }
    public function payment_terms_db(){
        $this->load->model('core/admin_model');
        $term_name = $this->input->post('term_name');
        $days_before_due = $this->input->post('days_before_due');
        $day_in_following_month = $this->input->post('day_in_following_month');

	    $items = array(
            "term_name"=>$term_name,
            "days_before_due"=>($days_before_due == '' ? 0 : 1),
            "day_in_following_month"=>$day_in_following_month
        );

        if($this->input->post('payment_id')){
            $this->admin_model->update_payment_terms($items,$this->input->post('payment_id'));
            $id = $this->input->post('payment_id');
            $act = 'update';
            $msg = 'Updated Payment Term : '.$this->input->post('term_name');
        } else{
            $id = $this->admin_model->add_payment_terms($items);
            $act = 'add';
            $msg = 'Added Payment Term : '.$this->input->post('term_name');
        }

        echo json_encode(array("id"=>$id, "desc"=>$this->input->post('term_name'),"act"=>$act,'msg'=>$msg));
    }
	//********************Payment Terms*****end
	//********************Fiscal Year*****start
	public function fiscal_years(){
        $this->load->model('core/admin_model');
        $this->load->helper('site/site_forms_helper');
        $fiscal_year_list = $this->admin_model->get_fiscal_years();
        $data = $this->syter->spawn('fiscal_years');
        $data['code'] = site_list_form("admin/fiscal_years_form","fiscal_years_form","Fiscal Years",$fiscal_year_list,array('begin_date', ' to ', 'end_date'),"fiscal_year_id");
        $data['add_js'] = 'js/site_list_forms.js';
        $data['load_js'] = 'site/admin.php';
        $data['use_js'] = 'fiscalYearsJs';
        $this->load->view('page',$data);
    }
    public function fiscal_years_form($ref=null){
        $this->load->helper('core/admin_helper');
        $this->load->model('core/admin_model');
        $fiscal_year = array();
        $access = array();
        if($ref != null){
            $fiscal_years = $this->admin_model->get_fiscal_years($ref);
            $fiscal_year = $fiscal_years[0];
        }

        $this->data['code'] = fiscalYearsForm($fiscal_year);
		// $this->data['load_js'] = 'site/admin';
        // $this->data['use_js'] = 'paymentTermsJs';
        $this->load->view('load',$this->data);
    }
    public function fiscal_years_db(){
        $this->load->model('core/admin_model');

	    $items = array(
            "begin_date"=>date2Sql($this->input->post('begin_date')),
            "end_date"=>date2Sql($this->input->post('end_date')),
            "is_closed"=> (int)$this->input->post('is_closed'),
			'inactive' => (int)$this->input->post('inactive')
        );

        if ($items['begin_date'] > $items['end_date']) {
            $echo_json = array('error'=>true,'msg'=>'Please select proper date range');
            echo json_encode($echo_json);
            return false;
        }

        if (!$items['is_closed']) {
            $where_array = array();
            $where_array[] = array(
                "key" => "is_closed",
                "value" => 0,
                "escape" => false);
            $active = $this->admin_model->get_fiscal_years(null,$where_array);
            if ($active) {
                $echo_json = array('error'=>true,'msg'=>'Multiple active fiscal years are prohibited');
                echo json_encode($echo_json);
                return false;
            }
        }

        $where_array = array();
        $where_array[] = array(
            "key" => "('".$items['begin_date']."' BETWEEN begin_date AND end_date) OR ('".$items['end_date']."' BETWEEN begin_date AND end_date)",
            "value" => null,
            "escape" => false);
        if ($this->input->post('fiscal_year_id')) {
            $where_array[] = array('key'=>'fiscal_year_id != '.$this->input->post('fiscal_year_id'),
                'value'=>null,
                'escape'=>false);
        }
        $dups = $this->admin_model->get_fiscal_years(null,$where_array);
        if ($dups) {
            $echo_json = array('error'=>true,'msg'=>'Date range overlaps with an existing fiscal year');
            echo json_encode($echo_json);
            return false;
        }


        if($this->input->post('fiscal_year_id')){
            $this->admin_model->update_fiscal_years($items,$this->input->post('fiscal_year_id'));
            $id = $this->input->post('fiscal_year_id');
            $act = 'update';
            $msg = 'Updated Fiscal Year : '.$this->input->post('begin_date').' to '.$this->input->post('end_date');
        } else{
            $id = $this->admin_model->add_fiscal_years($items);
            $act = 'add';
            $msg = 'Added Fiscal Year : '.$this->input->post('begin_date').' to '.$this->input->post('end_date');
        }

        echo json_encode(array("id"=>$id, "desc"=>date2Sql($this->input->post('begin_date')).' to '.date2Sql($this->input->post('end_date')),"act"=>$act,'msg'=>$msg));
    }
	//********************Fiscal Year*****end

	
	public function currency_list($ref='')
	{
		$data = $this->syter->spawn('control');
		$data['page_subtitle'] = "Currency Maintenance";
		$currency = $this->admin_model->get_currencies();
		$data['code'] = currencyPage($currency);
		$this->load->view('page',$data);
		
	}
	public function manage_currencies($id=null){
        // $data = $this->syter->spawn('products_master');
        $data = $this->syter->spawn('control');
        $data['page_subtitle'] = "Manage Currencies";
        $items = null;
        $receive_cart = array();

        if($id != null){
           	$details = $this->admin_model->get_currencies($id);
            $items = $details[0];
        }

        $data['code'] = manage_currency_form($items);

        $data['add_js'] = 'js/site_list_forms.js';
        $data['load_js'] = "core/setup.php";
        $data['use_js'] = "currencySetupJs";
        $this->load->view('page',$data);
    }
	//-----DB VALIDATION/INSERT/UPDATE
	public function currency_details_db()
	{
		// if (!$this->input->post())
			// header("Location:".base_url()."items");
		$user = $this->session->userdata('user');
		$status = "";
		$abbrev_exist="";
		$items = array(
			'abbrev' => $this->input->post('abbrev'),
			'currency' => $this->input->post('currency'),
			'symbol' => $this->input->post('symbol'),
			'hundredths_name' => $this->input->post('hundredths_name'),
			'inactive' => $this->input->post('inactive')
		);
		
		$mode = $this->input->post('mode');
		//echo "Mode : ".$mode."<br>";
		
		if($mode == 'add')
			$abbrev_exist = $this->admin_model->abbrev_exist_add_mode($this->input->post('abbrev'));
		else if($mode == 'edit')
			$abbrev_exist = $this->admin_model->abbrev_exist_edit_mode($this->input->post('abbrev'), $this->input->post('id'));
		
		 //echo "Product Code exist : ".$abbrev_exist."<br>";
		
		if($abbrev_exist){
			$id = '';
			$msg = "WARNING : Abbreviation [ ".$this->input->post('abbrev')." ] already exists!";
			$status = "warning";
		}else{
			if ($this->input->post('id')) {
				$id = $this->input->post('id');
				$this->admin_model->update_currency($items,$id);
				$msg = "Updated Currency : ".ucwords($this->input->post('currency'));
				$status = "success";
			}else{
				$id = $this->admin_model->add_currency($items);
				##########AUDIT TRAIL [START]##########
				$audit_items = array(
				'type'=>0,
				'trans_no'=>0,
				'type_desc'=>ADD_CURRENCY,
				'description'=>'id:'.$id.'||abbrev:"'.strtoupper($this->input->post('abbrev')).'"||currency:"'.ucfirst($this->input->post('currency')).'"',
				'user'=>$user['id']
				);
				
				$audit_id = $this->admin_model->write_to_audit_trail($audit_items);
				##########AUDIT TRAIL [END]##########
				$msg = "Added New Currency: ".ucwords($this->input->post('currency'));
				$status = "success";
			}
		}
		
		// echo var_dump($items)."<br>";
		// echo "Current Status : ".$status."<br>";
		echo json_encode(array('status'=>$status, 'id'=>$id,'msg'=>$msg));
	}
	//********************Currencies*****end

    //*******************Jed Code******************

     public function tax_types(){
	 
        $this->load->model('core/admin_model');
        $this->load->helper('site/site_forms_helper');
        // $payment_term_list = $this->admin_model->get_payment_terms();
        // $data = $this->syter->spawn('payment_terms');
        // $data['code'] = site_list_form("admin/payment_terms_form","payment_terms_form","Payment Terms",$payment_term_list,array('term_name'),"payment_id");
        $types_list = $this->admin_model->get_tax_types();
        $data = $this->syter->spawn('stock_tax_types');
        $data['code'] = site_list_form("admin/tax_types_form","tax_form","Tax Types",$types_list,array('tax_type_name'),"id");
        $data['add_js'] = 'js/site_list_forms.js';
        $this->load->view('page',$data);
		
    }
    public function tax_types_form($ref=null){
        $this->load->helper('core/admin_helper');
        $this->load->model('core/admin_model');
        $taxs = array();
        if($ref != null){
            $tax = $this->admin_model->get_tax_types($ref);
            $taxs = $tax[0];
        }

        $this->data['code'] = TaxTypesForm($taxs);
        $this->data['load_js'] = 'site/admin';
        $this->data['use_js'] = 'rolesJs';
        $this->load->view('load',$this->data);
    }
    public function tax_type_db(){
        $this->load->model('core/admin_model');
		
        $tax_type_name = 	$this->input->post('tax_type_name');
        $default_rate = $this->input->post('default_rate');
		$inactive=		$this->input->post('inactive');
		
        $items = array(
            "tax_type_name"=>$tax_type_name,
            "default_rate"=>$default_rate,
            "sales_gl_code"=>0,
            "purchase_gl_code"=>0,
			"inactive"=>$inactive
			
        );

        if($this->input->post('id')){
            $this->admin_model->update_tax_types($items,$this->input->post('id'));
            $id = $this->input->post('id');

            $act = 'update';
            $msg = 'Updated Tax Type : '.$this->input->post('tax_type_name');
        }else{
            $id = $this->admin_model->add_tax_types($items);
            $act = 'add';
            $msg = 'Added Tax Type : '.$this->input->post('tax_type_name');
        }
        echo json_encode(array("id"=>$id,"desc"=>$tax_type_name,"act"=>$act,'msg'=>$msg));

    }

    public function shipping_company(){
        $this->load->model('core/admin_model');
        $this->load->helper('site/site_forms_helper');
        $shipping_list = $this->admin_model->get_shipping_comp();
        $data = $this->syter->spawn('stock_tax_types');
        $data['code'] = site_list_form("admin/shipping_form","shipping_form","Shipping Company",$shipping_list,array('company_name'),"ship_company_id");
        $data['add_js'] = 'js/site_list_forms.js';
        $this->load->view('page',$data);
    }
    public function shipping_form($ref=null){
        $this->load->helper('core/admin_helper');
        $this->load->model('core/admin_model');
        $ships = array();
        if($ref != null){
            $ship = $this->admin_model->get_shipping_comp($ref);
            $ships = $ship[0];
        }

        $this->data['code'] = shippingForm($ships);
        $this->data['load_js'] = 'site/admin';
        $this->data['use_js'] = 'rolesJs';
        $this->load->view('load',$this->data);
    }
    public function ship_company_db(){
        $this->load->model('core/admin_model');
        $items = array(
            "company_name"=>$this->input->post('company_name'),
            "contact_person"=>$this->input->post('contact_person'),
            "phone_no"=>$this->input->post('phone_no'),
            "address"=>$this->input->post('address')
        );

        if($this->input->post('ship_company_id')){
            $this->admin_model->update_ship_comp($items,$this->input->post('ship_company_id'));
            $id = $this->input->post('ship_company_id');

            $act = 'update';
            $msg = 'Updated Shipping Company : '.$this->input->post('company_name');
        } else{
            $id = $this->admin_model->add_ship_comp($items);
            $act = 'add';
            $msg = 'Added Shipping Comapny : '.$this->input->post('company_name');
        }
        echo json_encode(array("id"=>$id,"desc"=>$this->input->post('company_name'),"act"=>$act,'msg'=>$msg));

    }

    public function form_setup(){
        $this->load->model('core/admin_model');
        $this->load->helper('site/site_forms_helper');
        $this->load->helper('core/admin_helper');
        $form_setup_list = $this->admin_model->get_form_setup();
        //$det = $details[0];
        //var_dump($form_setup_list);
        $data = $this->syter->spawn('setup');
        $data['page_subtitle'] = 'Form Setup';
        $data['code'] = makeSetupForm($form_setup_list);
        // $data['add_js'] = array('js/plugins/timepicker/bootstrap-timepicker.min.js');
        // $data['add_css'] = array('css/timepicker/bootstrap-timepicker.min.css');
        $data['load_js'] = 'site/admin.php';
        $data['use_js'] = 'formsJS';
        $this->load->view('page',$data);
    }
    public function form_setup_db(){
        $this->load->model('core/admin_model');


        foreach($this->input->post('refs') as $ref_id => $ref_val){
            $items = array(
                "next_ref"=>$ref_val
            );
            $this->admin_model->update_form_setup($items,$ref_id);
        }

        $msg = 'Form Setup has been Updated.';

        echo json_encode(array('msg'=>$msg));

    }
    public function tax_groups(){
        $this->load->model('core/admin_model');
        $this->load->helper('site/site_forms_helper');
        // $payment_term_list = $this->admin_model->get_payment_terms();
        // $data = $this->syter->spawn('payment_terms');
        // $data['code'] = site_list_form("admin/payment_terms_form","payment_terms_form","Payment Terms",$payment_term_list,array('term_name'),"payment_id");
        $grp_list = $this->admin_model->get_tax_groups();
        $data = $this->syter->spawn('tax_groups');
        $data['code'] = site_list_form("admin/tax_groups_form","taxg_form","Tax Groups",$grp_list,array('group_name'),"tax_group_id");
        $data['add_js'] = 'js/site_list_forms.js';
        $this->load->view('page',$data);
    }
    public function tax_groups_form($ref=null){
        $this->load->helper('core/admin_helper');
        $this->load->model('core/admin_model');
        $taxgs = array();
        if($ref != null){
            $taxg = $this->admin_model->get_tax_groups($ref);
            $taxgs = $taxg[0];
        }

        $this->data['code'] = TaxGroupsForm($taxgs);
        $this->data['load_js'] = 'site/admin';
        $this->data['use_js'] = 'rolesJs';
        $this->load->view('load',$this->data);
    }
    public function tax_groups_db(){
        $this->load->model('core/admin_model');
        $group_name = $this->input->post('group_name');
        // $default_rate = $this->input->post('default_rate');
        $items = array(
            "group_name"=>$group_name,
        );

        if($this->input->post('tax_group_id')){
            $this->admin_model->change_tax_groups($items,$this->input->post('tax_group_id'));
            $items2 = array(
                "tax_type_id"=>$this->input->post('tax_type_id'),
                "tax_rate"=>$this->input->post('tax_rate'),
            );
            $this->admin_model->change_tax_groups_items($items2,$this->input->post('tax_group_id'));
            $id = $this->input->post('tax_group_id');

            $act = 'update';
            $msg = 'Updated Tax Group : '.$this->input->post('group_name');
        } else{
            $id = $this->admin_model->write_tax_groups($items);
            $items2 = array(
                "tax_group_id"=>$id,
                "tax_type_id"=>$this->input->post('tax_type_id'),
                "tax_rate"=>$this->input->post('tax_rate'),
            );
            $id = $this->admin_model->write_tax_groups_items($items2);
            $act = 'add';
            $msg = 'Added Tax Type : '.$this->input->post('group_name');
        }
        echo json_encode(array("id"=>$id,"desc"=>$group_name,"act"=>$act,'msg'=>$msg));

    }
	
	//----------BRANCHES----------JOSHUA-----START
	public function branch_list($ref='')
	{
		$data = $this->syter->spawn('control');
		$data['page_subtitle'] = "Branches";
		$branch = $this->admin_model->get_branches();
	    $data['add_js'] = 'js/site_list_forms.js';
		$data['load_js'] = "core/setup.php";
        $data['use_js'] = "branchSetupJs";
		$data['code'] = branchPage($branch);
		$this->load->view('page',$data);
		
	}
	public function manage_branches($id=null){
        // $data = $this->syter->spawn('products_master');
        $data = $this->syter->spawn('control');
        $data['page_subtitle'] = "Manage Branches";
        $items = null;
        $receive_cart = array();

        if($id != null){
           	$details = $this->admin_model->get_branches($id);
            $items = $details[0];
        }

        $data['code'] = manage_branch_form($items);

        $data['add_js'] = 'js/site_list_forms.js';
        $data['load_js'] = "core/setup.php";
        $data['use_js'] = "branchSetupJs";
        $this->load->view('page',$data);
    }
	
	// //-----DB VALIDATION/INSERT/UPDATE
	public function branches_details_db()
	{
		$user = $this->session->userdata('user');
		$status = "";
		$code_exist="";
			
		$items = array(
		
			'code' => $this->input->post('code'),
			'name' => $this->input->post('name'),
			'address' => $this->input->post('address'),
			'tin' => $this->input->post('tin'),
			'tel_no' => $this->input->post('tel_no'),
			'mobile_no' => $this->input->post('mobile_no'),
		
			'date_opened' => date('Y-m-d', strtotime($this->input->post('date_opened'))),
			'branch_database' => $this->input->post('database'),
			'branch_ip' => $this->input->post('ip'),
			'inactive' => $this->input->post('inactive'),
			'has_sa' => $this->input->post('has_sa'),
			'has_sr' => $this->input->post('has_sr'),
			'has_bo' => $this->input->post('has_bo')
		);
		
		$mode = $this->input->post('mode');
		//echo "Mode : ".$mode."<br>";
		
		if($mode == 'add'){
			$code_exist = $this->admin_model->code_exist_add_mode($this->input->post('code'));
			}
		else if($mode == 'edit'){
			$code_exist = $this->admin_model->code_exist_edit_mode($this->input->post('code'), $this->input->post('id'));
		}
		 //echo "Product Code exist : ".$abbrev_exist."<br>";
		
		if($code_exist){
			$id = '';
			$msg = "WARNING : Code [ ".$this->input->post('code')." ] or Branch [ ".$this->input->post('name')." ] already exists!";
			$status = "warning";
		}else{
			if ($this->input->post('id')) {
				$id = $this->input->post('id');
				$this->admin_model->update_branch($items,$id);
				
				
				$msg = "Updated Branch : ".ucwords($this->input->post('name'));
				$status = "success";
			}else{
				$branch_id = $this->admin_model->add_branch($items);
				##########AUDIT TRAIL [START]##########
				$audit_items = array(
				'type'=>0,
				'trans_no'=>0,
				'type_desc'=>ADD_BRANCH,
				'description'=>'id:'.$branch_id.'||code:"'.$this->input->post('code').'"||name:"'.ucfirst($this->input->post('name')).'"',
				'user'=>$user['id']
				);
				
				$audit_id = $this->admin_model->write_to_audit_trail($audit_items);
				##########AUDIT TRAIL [END]##########	
  					 $has_sa  =  $this->input->post('has_sa');
					 $has_sr  =	 $this->input->post('has_sr');	
					 $has_bo  =   $this->input->post('has_bo');

					for($i=1; $i<=3; $i++)
					{
					if(($i == 1 AND !$has_sa)
					OR ($i == 2 AND !$has_sr)
					OR ($i == 3 AND !$has_bo))
					continue;
					
					$this->admin_model->add_new_branch_stocks($branch_id,$i);
					$this->admin_model->add_new_per_branch_stocks($branch_id,$i);
					
					}
				$this->admin_model->add_per_branch($items);
				
				$msg = "Added New Branch: ".ucwords($this->input->post('name'));
				$status = "success";
			}
		}
		
		// echo var_dump($items)."<br>";
		// echo "Current Status : ".$status."<br>";
	echo json_encode(array('status'=>$status, 'msg'=>$msg));
	}
	
	
	//----------BRANCHES---------------JOSHUA-----END
	
	//----------PAYMENT TYPES----------JOSHUA-----START
	public function payment_types_list($ref='')
	{
		$data = $this->syter->spawn('control');
		$data['page_subtitle'] = "Payment Types";
		$payment_types = $this->admin_model->get_payment_types();
		$data['code'] = payment_typePage($payment_types);
		$this->load->view('page',$data);
		
	}
	
	
	public function manage_payment_types($id=null){
        // $data = $this->syter->spawn('products_master');
        $data = $this->syter->spawn('control');
        $data['page_subtitle'] = "Manage Payment Types";
        $items = null;
        $receive_cart = array();

        if($id != null){
           	$details = $this->admin_model->get_payment_types($id);
            $items = $details[0];
        }

        $data['code'] = manage_payment_types_form($items);

        $data['add_js'] = 'js/site_list_forms.js';
        $data['load_js'] = "core/setup.php";
        $data['use_js'] = "payment_typesSetupJs";
        $this->load->view('page',$data);
    }
	
	
	
	public function payment_types_details_db()
	{
		$user = $this->session->userdata('user');
		// if (!$this->input->post())
			// header("Location:".base_url()."items");
		$status = "";
		$code_exist="";
		$items = array(
			
			'name' => $this->input->post('name'),
			'is_cash' => $this->input->post('is_cash'),
			'has_change' => $this->input->post('has_change'),
			'charge_to_card' => $this->input->post('charge_to_card'),
			'has_validation' => $this->input->post('has_validation'),
			'has_account_no' => $this->input->post('has_account_no'),
			'is_swipeable' => $this->input->post('is_swipeable'),
			'inactive' => $this->input->post('inactive')
		);
		
		$mode = $this->input->post('mode');
		//echo "Mode : ".$mode."<br>";
		
		if($mode == 'add')
			$name_exist = $this->admin_model->name_exist_add_mode($this->input->post('name'));
		else if($mode == 'edit')
			$name_exist = $this->admin_model->name_exist_edit_mode($this->input->post('name'), $this->input->post('id'));
		
		 //echo "Product Code exist : ".$abbrev_exist."<br>";
		
		if($name_exist){
			$id = '';
			$msg = "WARNING : Name [ ".$this->input->post('name')." ] already exists!";
			$status = "warning";
		}else{
			if ($this->input->post('id')) {
				$id = $this->input->post('id');
				$this->admin_model->update_payment_types($items,$id);
				$msg = "Updated Payment Type : ".ucwords($this->input->post('name'));
				$status = "success";
			}else{
				$id = $this->admin_model->add_payment_types($items);
				##########AUDIT TRAIL [START]##########
				$audit_items = array(
				'type'=>0,
				'trans_no'=>0,
				'type_desc'=>ADD_PAYMENT_TYPE,
				'description'=>'id:'.$id.'||name:"'.strtoupper($this->input->post('name')).'"',
				'user'=>$user['id']
				);
				
				$audit_id = $this->admin_model->write_to_audit_trail($audit_items);
				##########AUDIT TRAIL [END]##########
				
				$msg = "Added New Payment Type: ".ucwords($this->input->post('name'));
				$status = "success";
			}
		}
		
		// echo var_dump($items)."<br>";
		// echo "Current Status : ".$status."<br>";
		echo json_encode(array('status'=>$status, 'id'=>$id,'msg'=>$msg));
	}
	//----------PAYMENT TYPES----------JOSHUA-----END
	
	//----------ACQUIRING BANKS--------MHAE------START
	public function acquiring_banks_list($ref='')
	{
		$data = $this->syter->spawn('control');
		$data['page_subtitle'] = "Acquiring Banks";
		$acquiring_banks = $this->admin_model->get_acquiring_banks();
		$data['code'] = AcquiringBanksPage($acquiring_banks);
		$this->load->view('page',$data);
		
	}
	
	public function manage_acquiring_banks($id=null){
        // $data = $this->syter->spawn('products_master');
        $data = $this->syter->spawn('control');
        $data['page_subtitle'] = "Manage Acquiring Bank";
        $items = null;
        $receive_cart = array();

        if($id != null){
           	$details = $this->admin_model->get_acquiring_banks($id);
            $items = $details[0];
        }

        $data['code'] = manage_acquiring_banks_form($items);

        $data['add_js'] = 'js/site_list_forms.js';
        $data['load_js'] = "core/setup.php";
        $data['use_js'] = "AcquiringBanksSetupJs";
        $this->load->view('page',$data);
    }
	
	public function acquiring_bank_details_db()
	{
		// if (!$this->input->post())
			// header("Location:".base_url()."items");
		$user = $this->session->userdata('user');
		$status = "";
		$code_exist="";
		$items = array(
			
			'acquiring_bank' => $this->input->post('acquiring_bank'),
			'gl_bank_account' => $this->input->post('gl_bank_account'),
			'gl_bank_debit_account' => $this->input->post('gl_bank_debit_account'),
			'gl_mfee_account' => $this->input->post('gl_mfee_account'),
			'gl_wtax_account' => $this->input->post('gl_wtax_account'),
			'dc_merchant_fee_percent' => $this->input->post('dc_merchant_fee_percent'),
			'cc_merchant_fee_percent' => $this->input->post('cc_merchant_fee_percent'),
			'cc_withholding_tax_percent' => $this->input->post('cc_withholding_tax_percent'),
			'inactive' => $this->input->post('inactive')
		);
		
		$mode = $this->input->post('mode');
		
		if($mode == 'add')
			$name_exist = $this->admin_model->bank_name_exist_add_mode($this->input->post('acquiring_bank'));
		else if($mode == 'edit')
			$name_exist = $this->admin_model->bank_name_exist_edit_mode($this->input->post('acquiring_bank'), $this->input->post('id'));
		
		if($name_exist){
			$id = '';
			$msg = "WARNING : Bank Name [ ".$this->input->post('acquiring_bank')." ] already exists!";
			$status = "warning";
		}else{
			if ($this->input->post('id')) {
				$id = $this->input->post('id');
				$this->admin_model->update_acquiring_banks($items,$id);
				$msg = "Updated Acquiring Bank : ".ucwords($this->input->post('acquiring_bank'));
				$status = "success";
			}else{
				$id = $this->admin_model->add_acquiring_banks($items);
				##########AUDIT TRAIL [START]##########
				$audit_items = array(
				'type'=>0,
				'trans_no'=>0,
				'type_desc'=>ADD_ACQUIRING_BANKS,
				'description'=>'id:'.$id.'||acquiring_bank:"'.strtoupper($this->input->post('acquiring_bank')).'"||gl_bank_account:"'.ucfirst($this->input->post('gl_bank_account')).'"',
				'user'=>$user['id']
				);
				
				$audit_id = $this->admin_model->write_to_audit_trail($audit_items);
				##########AUDIT TRAIL [END]##########
				$msg = "Added New  Acquiring Bank: ".ucwords($this->input->post('acquiring_bank'));
				$status = "success";
			}
		}

		echo json_encode(array('status'=>$status, 'id'=>$id,'msg'=>$msg));
	}
	//----------ACQUIRING BANKS--------MHAE------END
	

//----------PAYMENT TYPE CODES----------RHAN-----START
	public function payment_type_code_list($ref='')
	{
		$data = $this->syter->spawn('control');
		$data['page_subtitle'] = "Payment Type Codes ";
		$payment_types = $this->admin_model->get_payment_type_codes();
		$data['code'] = payment_type_codes_page($payment_types);
		$this->load->view('page',$data);
		
	}
	
	public function manage_payment_type_code($id=null)
	{
        $data = $this->syter->spawn('control');
        $data['page_subtitle'] = "Manage Payment Type Codes";
        $items = null;
        $receive_cart = array();

        if($id != null){
           	$details = $this->admin_model->get_payment_type_codes($id);
            $items = $details[0];
        }

        $data['code'] = manage_payment_type_code_form($items);

        $data['add_js'] = 'js/site_list_forms.js';
        $data['load_js'] = "core/setup.php";
        $data['use_js'] = "Payment_typesJS";
        $this->load->view('page',$data);
    }
	
	public function payment_type_code_details_db()
	{
		$user = $this->session->userdata('user');
		$status = "";
		$code_exist="";
		$items = array(
			
			'payment_type_id' => $this->input->post('payment_type_id'),
			'code' => $this->input->post('code'),
			'confirmation_code' => $this->input->post('confirmation_code'),
			'amount' => $this->input->post('amount'),
			'is_redeemed' => $this->input->post('is_redeemed'),
			'branch_id' => (int)$this->input->post('branch_id')

		);
		
		$mode = $this->input->post('mode');
		//echo "Mode : ".$mode."<br>";
		
		if($mode == 'add')
			$name_exist = $this->admin_model->type_code_exist_add_mode($this->input->post('code'));
		else if($mode == 'edit')
			$name_exist = $this->admin_model->type_code_exist_edit_mode($this->input->post('code'),$this->input->post('confirmation_code'), $this->input->post('id'));
		
		 //echo "Product Code exist : ".$abbrev_exist."<br>";
		
		if($name_exist){
			$id = '';
			$msg = "WARNING : code [ ".$this->input->post('code')." ] already exists!";
			$status = "warning";
		}else{
			if ($this->input->post('id')) {
				$id = $this->input->post('id');
				$this->admin_model->update_payment_type_codes($items,$id);
				$msg = "Updated Payment Type Code : ".ucwords($this->input->post('code'));
				$status = "success";
			}else{
				$id = $this->admin_model->add_payment_type_codes($items);
				##########AUDIT TRAIL [START]##########
				$audit_items = array(
				'type'=>0,
				'trans_no'=>0,
				'type_desc'=>ADD_PAYMENT_TYPE_CODE,
				'description'=>'id:'.$id.'||payment_type_id:"'.$this->input->post('payment_type_id').'"||code:"'.strtoupper($this->input->post('code')).'"',
				'user'=>$user['id']
				);
				
				$audit_id = $this->admin_model->write_to_audit_trail($audit_items);
				##########AUDIT TRAIL [END]##########
				
				$msg = "Added New Payment Type Code: ".ucwords($this->input->post('code'));
				$status = "success";
			}
		}
		
	
		echo json_encode(array('status'=>$status, 'id'=>$id,'msg'=>$msg));
	}
	
	
	//----------PAYMENT TYPE CODES----------RHAN-----END
	
	//----------Suppliers----------RHAN-----START
	
	public function supplier_master($ref='')
	{
		$data = $this->syter->spawn('control');
		$user = $this->session->userdata('user');
		$data['page_subtitle'] = "Suppliers";
		if($user['role'] == 'Administrator')
			$suppliers = $this->admin_model->get_supplier_master();
		else if($user['role'] == 'Purchaser')
			$suppliers = $this->admin_model->get_supplier_master_list($user['id']);		
		else
			$suppliers = $this->admin_model->get_supplier_master();
				
		$data['code'] = supplier_master_page($suppliers);
		$this->load->view('page',$data);
		
	}
	
	public function supplier_master_form($id=null)
	{
        $data = $this->syter->spawn('control');
        $data['page_subtitle'] = "Suppliers";
        $items = null;
        $receive_cart = array();

        if($id != null){
           	$details = $this->admin_model->get_supplier_master($id);
            $items = $details[0];
        }
	   // echo var_dump($items);
        $data['code'] = supplier_master_form($items);
		
        $data['add_js'] = 'js/site_list_forms.js';
        $data['load_js'] = "core/setup.php";
        $data['use_js'] = "supplierMasterJs";
        $this->load->view('page',$data);
    }
	public function suppliers_details_db()
	{
	
		$status = "";
		$code_exist="";
		$audit_items = array();
		$id = $msg = $checker_mode = "";
		
		$is_consignor = $is_cwo = 0;
		
		# get user data
		$user = $this->session->userdata('user');
		
		if($this->input->post('is_consignor') == '' || $this->input->post('is_consignor') == 0){
			$is_consignor = 0;
		}else{
			$is_consignor = 1;
		}
		
		if($this->input->post('is_cwo') == '' || $this->input->post('is_cwo') == 0){
			$is_cwo = 0;
		}else{
			$is_cwo = 1;
		}
		
		// echo "Is Consignor : ".$is_consignor." ~~~ Is CWO : ".$is_cwo."<br>";
		
		$items = array(
			
			'short_name' => $this->input->post('short_name'),
			'supp_name' => $this->input->post('supp_name'),
			'contact_nos' => $this->input->post('contact_nos'),
			'address' => $this->input->post('address'),
			'contact_person' => $this->input->post('contact_person'),
			'email_po' => $this->input->post('email_po'),
			'email_payment' => $this->input->post('email_payment'),
			'tin' => $this->input->post('tin'),
			'fax_no' => $this->input->post('fax_no'),
			'purchaser_id' => $this->input->post('purchaser_id'),
			'biller_code' => $this->input->post('biller_code'),
			// 'curr_code' => $this->input->post('curr_code'),
			'tax_group_id' => $this->input->post('tax_group_id'),
			'payment_terms' => $this->input->post('payment_terms'),
			'dr_inv' => $this->input->post('dr_inv'),
			'is_consignor'=>$is_consignor,
			'consignment_percent' => $this->input->post('consignment_percent'),
			'is_cwo'=>$is_cwo,
			'group_id'=>(int)$this->input->post('group_id'),
			'delivery_lead_time'=>$this->input->post('delivery_lead_time'),
			'po_schedule'=>$this->input->post('po_schedule'),
			'selling_days'=>$this->input->post('selling_days'),
			'inactive' => $this->input->post('inactive'),
			'payment_discount_account' => $this->input->post('payment_discount_account'),
			'payable_account' => $this->input->post('payable_account'),
			'purchase_account' => $this->input->post('purchase_account')
		);
		$items_ = array(
			
			'short_name' => $this->input->post('short_name'),
			'supp_name' => $this->input->post('supp_name'),
			'contact_nos' => $this->input->post('contact_nos'),
			'address' => $this->input->post('address'),
			'contact_person' => $this->input->post('contact_person'),
			'email_po' => $this->input->post('email_po'),
			'email_payment' => $this->input->post('email_payment'),
			'tin' => $this->input->post('tin'),
			'fax_no' => $this->input->post('fax_no'),
			'purchaser_id' => $this->input->post('purchaser_id'),
			'biller_code' =>  $this->input->post('biller_code_old'),
			// 'curr_code' => $this->input->post('curr_code'),
			'tax_group_id' => $this->input->post('tax_group_id'),
			'payment_terms' => $this->input->post('payment_terms'),
			'dr_inv' => $this->input->post('dr_inv'),
			'is_consignor'=>$is_consignor,
			'consignment_percent' => $this->input->post('consignment_percent'),
			'is_cwo'=>$is_cwo,
			'group_id'=>(int)$this->input->post('group_id'),
			'delivery_lead_time'=>$this->input->post('delivery_lead_time'),
			'po_schedule'=>$this->input->post('po_schedule'),
			'selling_days'=>$this->input->post('selling_days'),
			'inactive' => $this->input->post('inactive'),
			'payment_discount_account' => $this->input->post('payment_discount_account'),
			'payable_account' => $this->input->post('payable_account'),
			'purchase_account' => $this->input->post('purchase_account')
		);
			$biller_code = $this->input->post('biller_code');
			$biller_code_old = $this->input->post('biller_code_old');
			 
		$items_a = array(
			'supplier_id' => $this->input->post('supplier_id'),
			'short_name' => $this->input->post('short_name'),
			'supp_name' => $this->input->post('supp_name'),
			'biller_code_old' => $this->input->post('biller_code_old'),
			'biller_code_new' => $this->input->post('biller_code'),
			'added_by' => $user['id'],
			'datetime_added'=> date("Y-m-d H:i:s"),
			
		);
		
		// echo var_dump($items);
		$mode = $this->input->post('mode');
		//echo "Mode : ".$mode."<br>";
		
		if($mode == 'add'){
			// $name_exist = $this->admin_model->supplier_exist_add_mode($this->input->post('supplier_code'));
			$name_exist = $this->admin_model->supplier_name_exist_add_mode($this->input->post('supp_name'));
		}else if($mode == 'edit'){
			// $name_exist = $this->admin_model->supplier_exist_edit_mode($this->input->post('supplier_code'),$this->input->post('supplier_id'));
			$name_exist = $this->admin_model->supplier_name_exist_edit_mode($this->input->post('supp_name'),$this->input->post('supplier_id'));
		}
		 //echo "Product Code exist : ".$abbrev_exist."<br>";
		if($this->input->post('is_cwo') == 1){
			// echo "IFS 1<br>";
			if($this->input->post('email_payment') == ''){
				// echo "IFS 2<br>";
				$id = '';
				$checker_mode = 'cwo';
				$msg = "WARNING : Email Address is a required field for CWO.";
				$status = "warning";
			}else{
				if($name_exist){
					// echo "IFS 4<br>";
					$id = '';
					$checker_mode = 'code';
					$msg = "WARNING : name [ ".$this->input->post('supp_name')." ] already exists!";
					$status = "warning";
				}else{
					// echo "IFS 5<br>";
					if ($this->input->post('supplier_id')) {
						// echo "IFS 6<br>";
						$id = $this->input->post('supplier_id');
						$checker_mode = '';
					if($this->input->post('biller_code') == $this->input->post('biller_code_old')){	
						$this->admin_model->update_supplier($items,$id);
						$this->admin_model->update_per_branch_supplier($items,$id);
					}else{
						$this->admin_model->update_supplier($items_,$id);
						$this->admin_model->update_per_branch_supplier($items_,$id);
						$this->admin_model->add_supplier_biller_code($items_a);
					}
						$msg = "Updated Supplier Information: ".ucwords($this->input->post('supp_name'));
						$status = "success";
					}else{
						// echo "IFS 7<br>";
						$id = $this->admin_model->add_supplier($items);
						  $this->admin_model->add_per_branch_supplier($id);
						$checker_mode = '';
						$msg = "Added New Supplier Information: ".ucwords($this->input->post('supp_name'));
						$status = "success";
					}
				}
			}
		}else{
			// echo "IFS 3<br>";
			if($name_exist){
				// echo "IFS 4<br>";
				$id = '';
				$checker_mode = 'code';
				$msg = "WARNING : name [ ".$this->input->post('supp_name')." ] already exists!";
				$status = "warning";
			}else{
				// echo "IFS 5<br>";
				if ($this->input->post('supplier_id')) {
					// echo "IFS 6<br>";
					$id = $this->input->post('supplier_id');
					$checker_mode = '';
				 	if($this->input->post('biller_code') == $this->input->post('biller_code_old')){	
						$this->admin_model->update_supplier($items,$id);
						$this->admin_model->update_per_branch_supplier($items,$id);
					}else{
						$this->admin_model->update_supplier($items_,$id);
						$this->admin_model->update_per_branch_supplier($items_,$id);
						$this->admin_model->add_supplier_biller_code($items_a);
					} 
					$msg = "Updated Supplier Information: ".ucwords($this->input->post('supp_name'));
					$status = "success";
				}else{
					// echo "IFS 7<br>";
					$id = $this->admin_model->add_supplier($items);
					$this->admin_model->add_per_branch_supplier($id);
					$checker_mode = '';
						
					$msg = "Added New Supplier Information: ".ucwords($this->input->post('supp_name'));
					$status = "success";
				}
			}
		}

		echo json_encode(array('status'=>$status, 'id'=>$id,'msg'=>$msg, 'checker_mode'=>$checker_mode));
	}
	
	//----------Suppliers----------RHAN-----END
	
	
	//----------DISCOUNT TYPES----------JOSHUA-----START
	public function discount_types_list($ref='')
	{
		$data = $this->syter->spawn('control');
		$data['page_subtitle'] = "Discount Types";
		$discount_types = $this->admin_model->get_discount_types();
		$data['code'] = discount_typePage($discount_types);
		$this->load->view('page',$data);
	}
	
	public function manage_discount_types($id=null){
        // $data = $this->syter->spawn('products_master');
        $data = $this->syter->spawn('control');
        $data['page_subtitle'] = "Manage Discount Types";
        $items = null;
        $receive_cart = array();

        if($id != null){
           	$details = $this->admin_model->get_discount_types($id);
            $items = $details[0];
        }

        $data['code'] = manage_discount_types_form($items);

        $data['add_js'] = 'js/site_list_forms.js';
        $data['load_js'] = "core/setup.php";
        $data['use_js'] = "discount_typesSetupJs";
        $this->load->view('page',$data);
    }
	
	
		public function discount_types_details_db()
	{
		// if (!$this->input->post())
			// header("Location:".base_url()."items");
		$user = $this->session->userdata('user');
		$status = "";
		$code_exist="";
		$type = $this->input->post('type');
		$items = array(
			
			'short_desc' => $this->input->post('short_desc'),
			'description' => $this->input->post('description'),
			'percentage' => ($type == 'percent'? $this->input->post('amount'):0),
			'amount' => ($type == 'amount'? $this->input->post('amount'):0),
			'inactive' => $this->input->post('inactive')
		);
		
		// echo var_dump($items);
		$mode = $this->input->post('mode');
		//echo "Mode : ".$mode."<br>";
		
		if($mode == 'add')
	
			$short_desc_exist = $this->admin_model->short_desc_exist_add_mode($this->input->post('short_desc'));
		else if($mode == 'edit')
			$short_desc_exist = $this->admin_model->short_desc_exist_edit_mode($this->input->post('short_desc'), $this->input->post('id'));
		
		 //echo "Product Code exist : ".$abbrev_exist."<br>";
		
		if($short_desc_exist){
			$id = '';
			$msg = "WARNING : Short Description [ ".$this->input->post('short_desc')." ] already exists!";
			$status = "warning";
		}else{
			if ($this->input->post('id')) {
				$id = $this->input->post('id');
				$this->admin_model->update_discount_types($items,$id);
				$msg = "Updated Discount Type : ".ucwords($this->input->post('short_desc'));
				$status = "success";
			}else{
				$id = $this->admin_model->add_discount_types($items);
				##########AUDIT TRAIL [START]##########
				$audit_items = array(
				'type'=>0,
				'trans_no'=>0,
				'type_desc'=>ADD_DISCOUNT_TYPE,
				'description'=>'id:'.$id.'||short_desc:"'.strtoupper($this->input->post('short_desc')).'"||description:"'.ucfirst($this->input->post('description')).'"',
				'user'=>$user['id']
				);
				
				$audit_id = $this->admin_model->write_to_audit_trail($audit_items);
				##########AUDIT TRAIL [END]##########
				
				$msg = "Added New Discount Type: ".ucwords($this->input->post('short_desc'));
				$status = "success";
			}
		}
		
		// echo var_dump($items)."<br>";
		// echo "Current Status : ".$status."<br>";
		echo json_encode(array('status'=>$status, 'id'=>$id,'msg'=>$msg));
	}
	//----------DISCOUNT TYPES----------JOSHUA-----END
	public function load_supplier_master_group_adder(){
		
		// $sb_det = array(
		// 'stock_id'=>$stock_id,
		// 'barcode'=>$barcode,
		// 'sales_type_id'=>$sales_type_id,
		// 'price'=>$price,
		// );
		
		// $data['code'] = sched_markdown_popup_form($branch_id, $sb_det);
		$data['code'] = supplier_master_group_adder_form();

		$data['add_js'] = 'js/site_list_forms.js';
		$data['load_js'] = "core/setup.php";
		$data['use_js'] = "suppGroupAdderPopJS";
		// echo var_dump($data);
		$this->load->view('load',$data);
    }
	public function add_to_supplier_group_db()
	{
		$items = array(
			'name' => $this->input->post('supp_group_name'),
			'inactive' => 0
			);
			$id = $this->admin_model->write_to_supplier_master_group($items);
			$status = 'success';
			$msg = "Successfully added new supplier group";

		echo json_encode(array('id'=>$id,'status'=>$status,'msg'=>$msg));
	}
	public function get_supp_group(){
		$json = array();
		
		$where = array('inactive'=>0);
		$grps = $this->admin_model->get_all_active_supp_group($where,'supplier_master_group');
		
		$opts = array();
		// $opts[$grps[0]->name] = $grps[0]->id;
		foreach($grps as $grp_vals){
			// $opts[$grp_vals->name] = $grp_vals->id;
			$opts[$grp_vals->id] = $grp_vals->name;
		}
		$json['opts'] =  $opts;
		echo json_encode($json);
	}
	public function load_me(){
		$post_group_id = $this->input->post('post_group_id');
		if(!empty($post_group_id) || $post_group_id != '')
			$data['code'] = load_supplier_group_ddb_add($post_group_id);
		else
			$data['code'] = load_supplier_group_ddb();

		$data['add_js'] = 'js/site_list_forms.js';
		$data['load_js'] = "core/setup.php";
		$data['use_js'] = "deymJs";
		// echo var_dump($data);
		$this->load->view('load',$data);
    }
	public function get_supp_group_name(){
		$supp_name='';
		$supp_group_id = $this->input->post('group_id');
		$supp_group_name = $this->admin_model->get_supp_group_name_from_id($supp_group_id);
		echo $supp_group_name;
	}
	public function write_to_audit_trail($items=null){
		$audit_items = array();
		$items = $this->input->post('form_vals');
		$type_desc = $this->input->post('type_desc');
		// echo $items."<br>";
		# get user data
		$user = $this->session->userdata('user');
		$audit_items = array(
				'type'=>0,
				'trans_no'=>0,
				'type_desc'=>$type_desc,
				'description'=>$items,
				'user'=>$user['id']
				);
		$this->admin_model->write_to_audit_trail($audit_items);
		
	}
	// USERS 
	
	public function users($ref='')
	{
		$data = $this->syter->spawn('control');
		$data['page_subtitle'] = "Users";
		$user = $this->admin_model->get_users();
		$data['code'] = users_page($user);
		$this->load->view('page',$data);
		
	}
	public function user_form($id=null)
	{
        $data = $this->syter->spawn('control');
        $data['page_subtitle'] = "Suppliers";
        $items = null;
        $receive_cart = array();

        if($id != null){
           	$details = $this->admin_model->get_users($id);
            $items = $details[0];
			
        }
	   // echo var_dump($items);
        $data['code'] = user_form($items);
		
        $data['add_js'] = 'js/site_list_forms.js';
        $data['load_js'] = "core/setup.php";
        $data['use_js'] = "usersJs";
        $this->load->view('page',$data);
    }
	public function user_details_db()
	{
		// if (!$this->input->post())
			// header("Location:".base_url()."items");
		$user = $this->session->userdata('user');
		$status = "";
		$code_exist="";
		  $items = array(
                "emp_id"=>$this->input->post('emp_id'),
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
		
		// echo var_dump($items);
		$mode = $this->input->post('mode');
		//echo "Mode : ".$mode."<br>";
		
		if($mode == 'add'){
			$short_desc_exist = $this->admin_model->ename_exist_add_mode($this->input->post('fname'), $this->input->post('mname'), $this->input->post('lname'));
	
		}else if($mode == 'edit'){
			$short_desc_exist = $this->admin_model->ename_exist_edit_mode($this->input->post('fname'), $this->input->post('mname'), $this->input->post('lname'), $this->input->post('id'));
		}
		 //echo "Product Code exist : ".$abbrev_exist."<br>";
		
		if($short_desc_exist){
			$id = '';
			$msg = "WARNING : Name [ ".$this->input->post('fname').' '.$this->input->post('mname').' '.$this->input->post('lname')." ] already exists!";
			$status = "warning";
		}else{
			if ($this->input->post('id')) {
				$id = $this->input->post('id');
				$this->admin_model->update_users($items,$id);
				$this->admin_model->update_per_branch_users($items, $this->input->post('id'));
				$msg = 'Update User '.$this->input->post('fname').' '.$this->input->post('lname');
				$status = "success";
			}else{
				$id = $this->admin_model->add_users($items);
				$this->admin_model->add_per_branch_users($id);
					##########AUDIT TRAIL [START]##########
				$audit_items = array(
				'type'=>0,
				'trans_no'=>0,
				'type_desc'=>ADD_USER,
				'description'=>'id:'.$id.'||emp_id:"'.strtoupper($this->input->post('emp_id')).'"||name:"'.ucfirst($this->input->post('fname').' '.$this->input->post('lname')).'"',
				'user'=>$user['id']
				);
				
				$audit_id = $this->admin_model->write_to_audit_trail($audit_items);
				##########AUDIT TRAIL [END]##########
				
				 $msg = 'Added  new User '.$this->input->post('fname').' '.$this->input->post('lname');
				$status = "success";
			}
		}
		
		// echo var_dump($items)."<br>";
		// echo "Current Status : ".$status."<br>";
		echo json_encode(array('status'=>$status, 'id'=>$id,'msg'=>$msg));
	}
	// BRANCH COUNTER
	
	public function branch_counters($ref='')
	{
		$data = $this->syter->spawn('control');
		$data['page_subtitle'] = "Branch Counters";
		$branch_counters = $this->admin_model->get_branch_counters();
		$data['code'] = branch_counters_page($branch_counters);
		$this->load->view('page',$data);
		
	}
	public function branch_counters_form($id=null)
	{
        $data = $this->syter->spawn('control');
        $data['page_subtitle'] = "Branch Counter";
        $items = null;
        $receive_cart = array();

        if($id != null){
           	$details = $this->admin_model->get_branch_counters($id);
            $items = $details[0];
			
        }
	   // echo var_dump($items);
        $data['code'] = branch_counter_form($items);
		
        $data['add_js'] = 'js/site_list_forms.js';
        $data['load_js'] = "core/setup.php";
        $data['use_js'] = "branchCounterJs";
        $this->load->view('page',$data);
    }
	public function branch_counter_details_db()
	{
		// if (!$this->input->post())
			// header("Location:".base_url()."items");
		$user = $this->session->userdata('user');
		$status = "";
		$code_exist="";
		  $items = array(
                "branch_id"=>$this->input->post('branch_id'),
                "counter_no"=>$this->input->post('counter_no'),
                "serial_no"=>$this->input->post('serial_no'),
                "permit_no"=>$this->input->post('permit_no'),
                "tin"=>$this->input->post('tin'),
                "min"=>$this->input->post('min'),
                "inactive"=>$this->input->post('inactive'),
            );
		
		// echo var_dump($items);
		$mode = $this->input->post('mode');
		$branch = $this->admin_model->get_branch_code_from_id($this->input->post('branch_id'));
		//echo "Mode : ".$mode."<br>";
		
		if($mode == 'add'){
			$short_desc_exist = $this->admin_model->br_counter_exist_add_mode($this->input->post('branch_id'), $this->input->post('counter_no'));
	
		}else if($mode == 'edit'){
			$short_desc_exist = $this->admin_model->br_counter_exist_edit_mode($this->input->post('id'), $this->input->post('branch_id'), $this->input->post('counter_no'));
		}
		 //echo "Product Code exist : ".$abbrev_exist."<br>";
		
		if($short_desc_exist){
			$id = '';
			$msg = "WARNING : Branch Counter [ ".$this->input->post('counter_no')." ] in [ ".$branch." ] already exists!";
			$status = "warning";
		}else{
			if ($this->input->post('id')) {
				$id = $this->input->post('id');
				$this->admin_model->update_counter($items,$id);
				$this->admin_model->update_branch_counter($id, $items, $branch);
				$msg = 'Update Branch Counter '.$this->input->post('counter_no').' in '.$branch;
				$status = "success";
			}else{
				$id = $this->admin_model->add_counter($items);
				$this->admin_model->add_branch_counter($id, $items, $branch);
				 ##########AUDIT TRAIL [START]##########
				$audit_items = array(
				'type'=>0,
				'trans_no'=>0,
				'type_desc'=>ADDED_BRANCH_COUNTER,
				'description'=>'id:'.$id.'||branch:"'.$branch.'"||counter_no:"'.$this->input->post('counter_no').'"',
				'user'=>$user['id']
				);
				
				$audit_id = $this->admin_model->write_to_audit_trail($audit_items);
				##########AUDIT TRAIL [END]##########
				
				 $msg = 'Added  New Branch Counter '.$this->input->post('counter_no').' in '.$branch;
				$status = "success";
			}
		}
		
		// echo var_dump($items)."<br>";
		// echo "Current Status : ".$status."<br>";
		echo json_encode(array('status'=>$status, 'id'=>$id,'msg'=>$msg));
	}
	public function get_branch_tin(){
		$tin='';
		$branch_id = $this->input->post('branch_id');
		if($branch_id != ''){
			$tin=$this->admin_model->get_branch_tin($branch_id);
			// echo $this->po_model->db->last_query();
			echo $tin;
		}
	}
    // ______________________________________________________ new lester _________________________________________

    public function branch($ref='')
    {
        $data = $this->syter->spawn('control');
        $data['page_subtitle'] = "Branches";
        $branch = $this->admin_model->get_branch();
        $data['code'] = branch_page($branch);
        $this->load->view('page',$data);
        
    }

    public function branch_form($code=null)
    {
        $data = $this->syter->spawn('control');
        $data['page_subtitle'] = "Suppliers";
        $items = null;
        $receive_cart = array();

        if($code != null){
            $details = $this->admin_model->get_branch($code);
            $items = $details[0];
            
        }
        $data['code'] = branch_form($items);
        
        $data['add_js'] = 'js/site_list_forms.js';
        $data['load_js'] = "core/setup.php";
        $data['use_js'] = "usersJs";
        $this->load->view('page',$data);
    }

    public function save_branch()
    {
        $user = $this->session->userdata('user');

        $b_code = $this->input->post('b_code');
        $desc = $this->input->post('desc');
        $aria_db = $this->input->post('aria_db');
        $status = "";
        $code_exist="";
        $items = array('branch_code'=> $b_code,
                    'description'=> $desc,
                    'aria_db'=> $aria_db);
        
        $mode = $this->input->post('mode');
        if($mode == 'add'){
            $short_desc_exist = $this->admin_model->branch_name_exist($this->input->post('branch_code'));
    
        }else if($mode == 'edit'){
            $short_desc_exist = $this->admin_model->branch_name_edit($this->input->post('branch_code'));
        }
        
        if($short_desc_exist){
            $id = '';
            $msg = "WARNING : Branch Name [ ".$this->input->post('description')." ] already exists!";
            $status = "warning";
        }else{
            if ($this->input->post('branch_code')) {
                $branch_code = $this->input->post('branch_code');
                $this->admin_model->update_new_new_branch($items,$branch_code);
                $msg = 'Update Branch '.$this->input->post('description');
                $status = "success";
            }else{
                $code = $this->admin_model->add_new_branch($items);
                // $code = $this->admin_model->add_branch($items);
                ##########AUDIT TRAIL [START]##########
                $audit_items = array(
                'type'=>0,
                'trans_no'=>0,
                'type_desc'=>ADD_CURRENCY,
                'description'=>'code:'.$code.'||branch_name:"'.strtoupper($this->input->post('abbrev')).'"',
                'user'=>$user['id']
                );
                
                $audit_id = $this->admin_model->write_to_audit_trail($audit_items);
                ##########AUDIT TRAIL [END]##########
                
                 $msg = 'Added  new Branch '.$this->input->post('description');
                $status = "success";
            }
        }
        
        echo json_encode(array('status'=>$status,'msg'=>$msg));
    }
    // ______________________________________________________ new lester _________________________________________
    
}
    