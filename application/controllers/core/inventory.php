<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inventory extends CI_Controller {
	var $data = null;
	public function __construct()
	{
		parent::__construct();
		$this->load->model('core/inventory_model');
		$this->load->model('site/site_model');
		$this->load->helper('core/inventory_helper');
	}
	public function index()
	{

	}
	//----------DASHBOARD----------START
	public function dashboard($ref=''){
		$data = $this->syter->spawn('inventory');
		$data['page_subtitle'] = "Dashboard";
		// $stockLocation = $this->inventory_model->get_stock_locations();
		$barcodes = $this->inventory_model->get_barcodes_count();
		$new_items = $this->inventory_model->get_masters_new_count();
		$barcode_scheduled = $this->inventory_model->get_barcode_scheduled_markdown_count();
		$barcode_price_stock_logs = $this->inventory_model->get_barcode_price_stock_logs_count();
		$supplier_stocks_logs = $this->inventory_model->get_supplier_stocks_count();
		$supplier_biller_code_logs = $this->inventory_model->get_supplier_biller_code_count();
		$stock_deletion_approval = $this->inventory_model->get_stock_deletion();
		$stock_marginal_markdown_approval = $this->inventory_model->get_marginal_markdown_count();
		$stock_barcode_price_approval = $this->inventory_model->get_stock_price_update();		// $data['code'] = build_dashboard($stockLocation);
		$data['code'] = build_dashboard('',$new_items, $barcodes, $barcode_scheduled, $barcode_price_stock_logs, $supplier_stocks_logs, $supplier_biller_code_logs, $stock_deletion_approval, $stock_barcode_price_approval, $stock_marginal_markdown_approval);
		$data['add_css'] = array('css/morris/morris.css', 'css/AdminLTE.css');
		$data['add_js'] = array('js/plugins/morris/morris.js', 'js/raphael.js', 'js/site_list_forms.js');
		// $data['add_js'] = 'js/site_list_forms.js';

		// $data['add_js'] = array('js/site_list_forms.js', 'js/jquery-ui-1.10.3.js', 'js/AdminLTE/app.js', 'js/AdminLTE/dashboard.js');
		// $data['add_js'] = array('js/site_list_forms.js', 'js/AdminLTE/dashboard.js');
		$data['load_js'] = "core/inventory.php";
		$data['use_js'] = "dashboardJs";
		$this->load->view('page',$data);
     }
	//----------DASHBOARD----------END
	public function item_categories_maintenance()
	{
		$this->load->helper('site/site_forms_helper');

		$results = $this->inventory_model->get_item_categories();
		$data = $this->syter->spawn('inventory');
		$data['page_subtitle'] = "Item Categories Management";
		$data['code'] = site_list_form(
			"inventory/item_category_form",
			"category_form",
			"Item Categories",
			$results,
			array('category_name'),
			'stock_category_id');
		$data['add_js'] = 'js/site_list_forms.js';
		$this->load->view('page',$data);
	}
	public function item_category_form($ref=null)
	{
		$categories = array();
		if ($ref) {
			$category = $this->inventory_model->get_item_categories(array('stock_category_id'=>$ref));
			if ($category)
				$categories = $category[0];
		}
		$data['code'] = build_category_maintenace_form($categories);
		$data['load_js'] = "core/inventory.php";
		$data['use_js'] = "formContainerJs";
		$this->load->view('load',$data);
	}
	//rhan start stock_deletion
	public function stock_deletion()
	{
	  $user = $this->session->userdata('user');
	  $items = array(
			'stock_id' =>$this->input->post('stock_id'),
			'stock_code'=>$this->input->post('stock_code'),
			'modified_by'=> $user['id']
			);
	  $result = $this->inventory_model->write_stock_for_deletion($items); 
		if($result)
			echo 'stock deletion is for approval';
		
	}
	//rhan end
	
	public function item_category_db()
	{
		$items = array(
			'category_name' => $this->input->post('category_name'),
			'inactive' => (int) $this->input->post('inactive')
			);

		if (!$this->input->post('stock_category_id')) {
			$id = $this->inventory_model->write_item_categories($items);
			$act = 'add';
			$msg = "Successfully added new item category";
		} else {
			$id = $this->input->post('stock_category_id');
			$this->inventory_model->change_item_categories($items,array('stock_category_id'=>$id));
			$act = 'update';
			$msg = "Successfully updated item category";
		}

		echo json_encode(array('id'=>$id,'desc'=>$items['category_name'],'act'=>$act,'msg'=>$msg));
	}
	public function uoms_maintenance()
	{
		$this->load->helper('site/site_forms_helper');

		$results = $this->inventory_model->get_uoms();
		$data = $this->syter->spawn('inventory');
		$data['page_subtitle'] = "UOM Management";
		$data['code'] = site_list_form(
			"inventory/uom_form",
			"uom_form",
			"Units of Measurement",
			$results,
			array('name'),
			'uom_id');
		$data['add_js'] = 'js/site_list_forms.js';
		$this->load->view('page',$data);
	}
	public function uom_form($ref=null)
	{
		$uoms = array();
		if ($ref) {
			$uom = $this->inventory_model->get_uoms(array('uom_id'=>$ref));
			if ($uom)
				$uoms = $uom[0];
		}
		$data['code'] = build_uom_maintenace_form($uoms);
		$data['load_js'] = "core/inventory.php";
		$data['use_js'] = "formContainerJs";
		$this->load->view('load',$data);
	}
	public function uom_db()
	{
		$items = array(
			'name' => $this->input->post('name'),
			'description' => $this->input->post('description'),
			'decimal_places' => $this->input->post('decimal_places')
					? $this->input->post('decimal_places')
					: null
			);

		if (!$this->input->post('uom_id')) {
			$id = $this->inventory_model->write_uom($items);
			$act = 'add';
			$msg = "Successfully added new UOM";
		} else {
			$id = $this->input->post('uom_id');
			$this->inventory_model->change_uom($items,array('uom_id'=>$id));
			$act = 'update';
			$msg = "Successfully updated UOM";
		}

		echo json_encode(array('id'=>$id,'desc'=>$items['name'],'act'=>$act,'msg'=>$msg));
	}
	public function item_types_maintenance()
	{
		$this->load->helper('site/site_forms_helper');

		$results = $this->inventory_model->get_item_types();
		$data = $this->syter->spawn('inventory');
		$data['page_subtitle'] = "Item Types Management";
		$data['code'] = site_list_form(
			"inventory/item_type_form",
			"item_type_form",
			"Item Types",
			$results,
			array('type_name'),
			'id');
		$data['add_js'] = 'js/site_list_forms.js';
		$this->load->view('page',$data);
	}
	public function item_type_form($ref=null)
	{
		$types = array();
		if ($ref) {
			$type = $this->inventory_model->get_item_types(array('id'=>$ref));
			if ($type)
				$types = $type[0];
		}
		$data['code'] = build_item_type_form($types);
		$data['load_js'] = "core/inventory.php";
		$data['use_js'] = "formContainerJs";
		$this->load->view('load',$data);
	}
	public function item_type_db()
	{
		$items = array(
			'type_name' => $this->input->post('type_name'),
			);

		if (!$this->input->post('id')) {
			$id = $this->inventory_model->write_item_type($items);
			$act = 'add';
			$msg = "Successfully added new item type";
		} else {
			$id = $this->input->post('id');
			$this->inventory_model->change_item_type($items,array('id'=>$id));
			$act = 'update';
			$msg = "Successfully updated item type";
		}

		echo json_encode(array('id'=>$id,'desc'=>$items['type_name'],'act'=>$act,'msg'=>$msg));
	}
	public function items_maintenance($ref='')
	{
		$data = $this->syter->spawn('inventory');
		if ($ref) {
			$this->items_container($ref,$data);
		} else {
			$results = $this->inventory_model->get_items();
			$data['page_subtitle'] = "Item Maintenance";
			$data['code'] = build_items_display($results);
		}
		$this->load->view('page',$data);
	}
	private function items_container($ref,&$data)
	{
		if (!strcasecmp($ref, 'new'))
			$data['page_subtitle'] = "New Inventory Item";
		else
			$data['page_subtitle'] = "Edit Inventory Item";

		$data['code'] = build_item_container($ref);
		$data['load_js'] = "core/inventory.php";
		$data['use_js'] = "inventoryFormContainerJs";
	}
	public function item_main_form($ref)
	{
		$items = array();
		$data['page_subtitle'] = "New Inventory Item";
		if (strcasecmp($ref,'new')) {
			$results = $this->inventory_model->get_items(array('a.id'=>$ref));
			if ($results) {
				$items = $results[0];
				$data['page_subtitle'] = "Edit Inventory Item";
			}
		}
		$data['code'] = build_item_main_form($items);
		$data['load_js'] = "core/inventory.php";
		$data['use_js'] = "inventoryFormJs";
		$this->load->view('load',$data);
	}
	public function item_db()
	{
		$items = array(
			'name' => ucfirst($this->input->post('name')),
			'item_code' => strtoupper($this->input->post('item_code')),
			'barcode' => $this->input->post('barcode'),
			'brand_name' => $this->input->post('brand_name'),
			'grade' => $this->input->post('grade'),
			'description' => $this->input->post('description'),
			'category_id' => (int) $this->input->post('category_id'),
			'uom_id' => (int) $this->input->post('uom_id'),
			'item_type' => (int) $this->input->post('item_type'),
			'item_tax_type' => (int) $this->input->post('item_tax_type'),
			'sales_account' => (int) $this->input->post('sales_account'),
			'cogs_account' => (int) $this->input->post('cogs_account'),
			'inventory_account' => (int) $this->input->post('inventory_account'),
			'adjustment_account' => (int) $this->input->post('adjustment_account'),
			'assembly_cost_account' => (int) $this->input->post('assembly_cost_account'),
		);
		if (!$this->input->post('id')) {
			$this->inventory_model->write_item($items);
			echo json_encode(array('result'=>'success','msg'=>'Successfully added new inventory item'));
		} else {
			$this->inventory_model->change_item($items,array('id'=>$this->input->post('id')));
			echo json_encode(array('result'=>'success','msg'=>'Successfully updated inventory item'));
		}
	}
	public function item_pricing_form($ref)
	{
		// echo 'haha';
		$items = array();
		// $data['page_subtitle'] = "New Inventory Item";
		if (strcasecmp($ref,'new')) {
			$results = $this->inventory_model->get_items(array('a.id'=>$ref));
			if ($results) {
				$items = $results[0];
				// $data['page_subtitle'] = "Edit Inventory Item";
			}
		}
		// echo var_dump($items);
		$data['code'] = build_item_pricing_form($items);
		$data['load_js'] = "core/inventory.php";
		$data['use_js'] = "inventoryPricingFormJs";
		$this->load->view('load',$data);
	}
	public function item_pricing_db()
	{
		$items = array(
			'currency_abrev' => $this->input->post('currency_abrev'),
			'standard_cost' => $this->input->post('standard_cost'),
			'sales_price' => $this->input->post('sales_price'),
		);
		// echo var_dump($items);
		// if (!$this->input->post('id')) {
			// $this->inventory_model->write_item($items);
			// echo json_encode(array('result'=>'success','msg'=>'Successfully added new inventory item'));
		// } else {
			$this->inventory_model->update_item_price($items,array('id'=>$this->input->post('id')));
			echo json_encode(array('result'=>'success','msg'=>'Successfully updated item price details'));
		// }
	}
	//********************Inventory Locations*****Allyn*****start
    public function locations_maintenance(){
        $this->load->model('core/inventory_model');
        $this->load->helper('site/site_forms_helper');
        $il_list = $this->inventory_model->get_inventory_locations();
        $data = $this->syter->spawn('locations');
        $data['code'] = site_list_form("inventory/inventory_locations_form","inventory_locations_form","Inventory Locations",$il_list,array('location_name'),"location_id");
        $data['add_js'] = 'js/site_list_forms.js';
        $this->load->view('page',$data);
    }
    public function inventory_locations_form($ref=null){
        $this->load->helper('core/inventory_helper');
        $this->load->model('core/inventory_model');
        $inv_location = array();
        $access = array();
        if($ref != null){
            $inv_locations = $this->inventory_model->get_inventory_locations($ref);
            $inv_location = $inv_locations[0];
        }

        $this->data['code'] = inventoryLocationsForm($inv_location);
         // $this->data['load_js'] = 'site/admin';
        // $this->data['use_js'] = 'paymentTermsJs';
        $this->load->view('load',$this->data);
    }
    public function inventory_locations_db(){
        $this->load->model('core/inventory_model');

        // $inactive_val = 0;
        // if($this->input->post('inactive') == '' || $this->input->post('inactive') == 0)
            // $inactive_val = 0;
        // else
            // $inactive_val = 1;

        $items = array(
            "loc_code"=>$this->input->post('loc_code'),
            "location_name"=>$this->input->post('location_name'),
            "contact_person"=>$this->input->post('contact_person'),
            "address"=>$this->input->post('address'),
            "phone"=>$this->input->post('phone'),
            "fax"=>$this->input->post('fax'),
            "email"=>$this->input->post('email')
        );

        if($this->input->post('location_id')){
            $this->inventory_model->update_inventory_locations($items,$this->input->post('location_id'));
            $id = $this->input->post('location_id');
            $act = 'update';
            $msg = 'Updated Inventory Location : '.$this->input->post('location_name');
        } else{
            $id = $this->inventory_model->add_inventory_locations($items);
            $act = 'add';
            $msg = 'Added Inventory Location : '.$this->input->post('location_name');
        }

        echo json_encode(array("id"=>$id, "desc"=>$this->input->post('location_name'),"act"=>$act,'msg'=>$msg));
    }
    //********************Inventory Locations*****Allyn*****end
    //********************Inventory Adjustment*****Allyn*****start
	public function inventory_adjustment_form($trx_id=null){
        $this->load->model('core/inventory_model');
        $this->load->helper('core/inventory_helper');

		$next_ref = $this->site_model->get_next_ref(INVENTORY_ADJUSTMENT);
        $type_no = $next_ref->next_type_no;
        $reference = $next_ref->next_ref;

        $data = $this->syter->spawn('inv_adjustment');
        $data['page_title'] = "Inventory Adjustment Entry";

        $data['code'] = inventoryAdjustmentFormLoad($trx_id, $type_no, $reference);
        $data['add_css'] = 'js/plugins/typeaheadmap/typeaheadmap.css';
        $data['add_js'] = array('js/plugins/typeaheadmap/typeaheadmap.js');
        $data['load_js'] = 'core/inventory.php';
        $data['use_js'] = 'inventoryAdjustmentJS';
        $this->load->view('page',$data);
    }
	public function get_inv_item_details($item_id=null,$from_loc=null,$asJson=true){
	// public function get_inv_item_details($item_id=null,$from_loc=null,$asJson=false){
        $json = array();
        $items = $this->inventory_model->get_inventory_item($item_id);
        $item = $items[0];
		// echo "this location:".$from_loc."<br>";
		// $qoh = $this->inventory_model->get_item_qoh($item_id, $loc_code);

        $json['item_id'] = $item->id;
        $json['uom'] = $item->uom_id;
        $json['price'] = $item->standard_cost;
        $json['from_loc'] = $from_loc;

		$qoh = $this->inventory_model->get_item_qoh($item->id, $from_loc);
		$json['qoh'] = $qoh->qoh;

        $where = array('uom_id'=>$item->uom_id);
        $uoms = $this->inventory_model->get_inventory_item_details($where,'uoms');

        $opts = array();
        $opts[$uoms[0]->name] = $uoms[0]->name;
        // if($item->no_per_pack > 0)
        //     $opts['Pack(@'.$item->no_per_pack.' '.$item->uom.')'] = $item->uom."-".'pack-'.$item->no_per_pack;
        // if($item->no_per_case > 0)
        //     $opts['Case(@'.$item->no_per_case.' Packs)'] = $item->uom."-".'case-'.$item->no_per_case;

        $json['opts'] =  $opts;
        // $json['ppack'] = $item->no_per_pack;
        // $json['pcase'] = $item->no_per_case;
        echo json_encode($json);
    }
	public function inventory_adjustment_db(){
        $this->load->model('core/inventory_model');
        // $type_no = $this->inventory_model->get_next_type_no(INVENTORY_ADJUSTMENT); //old
		$next_ref = $this->site_model->get_next_ref(INVENTORY_ADJUSTMENT);
        $type_no = $next_ref->next_type_no;
        $reference = ($this->input->post('reference') ? $this->input->post('reference') : $next_ref->next_ref);

		$user = $this->session->userdata('user');

        $items = array(
            "item_id"=>$this->input->post('item_id'),
            "trans_type"=>INVENTORY_ADJUSTMENT,
            "type_no"=>$type_no,
            "trans_date"=>date2Sql($this->input->post('trans_date')),
            "loc_code"=>$this->input->post('from_loc'),
            "person_id"=>$user['id'],
            "qty"=>$this->input->post('qty_delivered'),
            "visible"=>1,
			"reference"=>$reference,
			"movement_type"=>$this->input->post('movement_type')
        );
        // echo var_dump($items);
        // if($this->input->post('form_mod_id')){
            // $this->sales_model->update_so_header($items,$this->input->post('form_mod_id'));
            // $id = $this->input->post('form_mod_id');
            // $act = 'update';
            // // $msg = 'Updated Sales Order Details '.$this->input->post('name');
            // $msg = 'Updated Sales Order Details ';
        // }else{
            $id = $this->inventory_model->add_inventory_adjustment($items);
            // $upd_ref = $this->inventory_model->update_trans_types_next_ref($type_no, INVENTORY_ADJUSTMENT); //old
            $refs = array(
                'trans_type' => INVENTORY_ADJUSTMENT,
                'type_no' => $type_no,
                'reference' => $reference
                );

			$this->site_model->add_trans_ref($refs);
			$act = 'add';
            // $msg = 'Added  new Sales Order '.$this->input->post('name');
            $msg = 'Added Inventory Adjustment';
        // }

        echo json_encode(array("id"=>$id,"desc"=>'',"act"=>$act,'msg'=>$msg));
    }
	public function view_inventory_adjustment($trx_id=null,$trans_type=null,$type_no=null,$ref=null){
        $this->load->model('core/inventory_model');
        $this->load->helper('core/inventory_helper');

		if ($trx_id != null) {
            $details = $this->inventory_model->get_item_movement_details($trx_id,$trans_type,$type_no,$ref);
            $header = $details[0];
        }

        $data = $this->syter->spawn('inv_adjustment');
        $data['page_title'] = "Inventory Adjustment Entry";

        $data['code'] = viewInventoryAdjustmentForm($details,$header);
        $data['add_css'] = 'js/plugins/typeaheadmap/typeaheadmap.css';
        $data['add_js'] = array('js/plugins/typeaheadmap/typeaheadmap.js');
        $data['load_js'] = 'core/inventory.php';
        $data['use_js'] = 'inventoryAdjustmentJS';
        $this->load->view('load',$data);
    }
	//-----------NEW
	public function inv_adjustment_form($adj_id=null){

		$data = $this->syter->spawn('inv_adjustment');
		$data['page_title'] = "Inventory Adjustment Entry";

		$data['code'] = inventoryAdjustmentHeaderPage($adj_id, $type_no, $reference);
        $data['add_css'] = 'js/plugins/typeaheadmap/typeaheadmap.css';
        $data['add_js'] = array('js/plugins/typeaheadmap/typeaheadmap.js');
        $data['load_js'] = 'core/inventory.php';
        $data['use_js'] = 'inventoryAdjustmentHeaderJS';
        $this->load->view('page',$data);
	}
	public function adjustment_details_load($adj_id=null){
        $po=array();
        $type_no = null;
        // if($po_id != null){
            // $pos = $this->purchasing_model->get_po_header($po_id);
            // $po=$pos[0];
        // }else{
            // $getter = $this->site_model->get_next_ref(PURCHASE_ORDER);
            // $type_no = $getter->next_ref;
        // }
		$next_ref = $this->site_model->get_next_ref(INVENTORY_ADJUSTMENT);
        $type_no = $next_ref->next_type_no;
        $reference = $next_ref->next_ref;

        $data['code'] = iaHeaderDetailsLoad($adj_id, $type_no, $reference);
        $data['load_js'] = 'core/inventory.php';
        $data['use_js'] = 'invAdjustmentHeaderDetailsLoadJs';
        $this->load->view('load',$data);
    }
	public function inv_adjustment_header_details_db(){

        $getter_types = $this->site_model->get_next_ref(PURCHASE_ORDER);
        $type_no = $getter_types->next_type_no;

        $user = $this->session->userdata('user');
        $user['id'];

        $items = array(
            "supplier_id"=>$this->input->post('supplier_id'),
            "comments"=>$this->input->post('comments'),
            "ord_date"=>date2Sql($this->input->post('ord_date')),
            "reference"=>$this->input->post('reference'),
            "requisition_no"=>$this->input->post('requisition_no'),
            "into_stock_location"=>$this->input->post('into_stock_location'),
            "delivery_address"=>$this->input->post('delivery_address'),
            "person_id"=>$user['id'],
            "order_no"=>$type_no,
        );

        if($this->input->post('form_mod_id')){
            $this->purchasing_model->update_header($items,$this->input->post('form_mod_id'));
            $id = $this->input->post('form_mod_id');
            $act = 'update';
            $msg = 'Details has been updated.';
        }else{

            //insert sa trans_ref
            $trans_items = array(
                'trans_type'=>PURCHASE_ORDER,
                'type_no'=>$type_no,
                'reference'=>$this->input->post('reference')
            );
            $this->site_model->add_trans_ref($trans_items);

            $id = $this->purchasing_model->add_header($items);
            //update trans types
            //$upd_next_type_no = $this->site_model->update_trans_types_next_type_no($type_no, PURCHASE_ORDER);

            // $next_ref = $this->site_model->increment($this->input->post('reference'));
            // $upd_next_ref = $this->site_model->update_trans_types_next_ref($next_ref, PURCHASE_ORDER);
            $act = 'add';
            $msg = 'Details has been saved.';
            // $msg = $aw;
        }

        echo json_encode(array("id"=>$id,"desc"=>$this->input->post('name'),"act"=>$act,'msg'=>$msg));
    }
	public function adjustment_items_load($order_no=null){
        $po_items=array();
        if($order_no != null){
            $pos = $this->purchasing_model->get_po_items($order_no);
            if($pos)
            	$po_items=$pos[0];
        }
        $data['code'] = poItemsLoad($po_items,$order_no);
        $data['load_js'] = 'core/purchasing.php';
        $data['use_js'] = 'poItemsJs';
        $this->load->view('load',$data);
    }
    public function get_item_details($item_id=null,$asJson=true){
        $json = array();
        $items = $this->purchasing_model->get_item($item_id);
        $item = $items[0];

        $json['item_id'] = $item->id;
        $json['uom'] = $item->uom_id;
        $json['standard_cost'] = $item->standard_cost;

        $where = array('uom_id'=>$item->uom_id);
        $uoms = $this->purchasing_model->get_details($where,'uoms');

        $opts = array();
        $opts[$uoms[0]->name] = $uoms[0]->name;
        // if($item->no_per_pack > 0)
        //     $opts['Pack(@'.$item->no_per_pack.' '.$item->uom.')'] = $item->uom."-".'pack-'.$item->no_per_pack;
        // if($item->no_per_case > 0)
        //     $opts['Case(@'.$item->no_per_case.' Packs)'] = $item->uom."-".'case-'.$item->no_per_case;

        $json['opts'] =  $opts;
        // $json['ppack'] = $item->no_per_pack;
        // $json['pcase'] = $item->no_per_case;
        echo json_encode($json);
    }
    public function add_item(){
        $quantity = $this->input->post('quantity_ordered');
        $unit_price = $this->input->post('unit_price');
        $line_total = $this->input->post('quantity_ordered') * $this->input->post('unit_price');

        if($this->input->post('discount_percent') != 0){
            $disc1 = $this->input->post('discount_percent') / 100;
            $disc1_val = $unit_price * $disc1;

            $vals = $unit_price - $disc1_val;

            if($this->input->post('discount_percent2') != 0){
                $disc2 = $this->input->post('discount_percent2') / 100;
                $vals2 = $vals * $disc2;
                $vals = $vals - $vals2;

                if($this->input->post('discount_percent3') != 0){
                    $disc3 = $this->input->post('discount_percent3') / 100;
                    $vals3 = $vals * $disc3;
                    $vals = $vals - $vals3;
                }

            }

            $line_total = $vals * $quantity;
        }




        $items = array(
            "order_id"=>$this->input->post('order_no'),
            "item_code"=>$this->input->post('item'),
            "delivery_date"=>date2Sql($this->input->post('delivery_date')),
            "stk_units"=>$this->input->post('select-uom'),
            "quantity_ordered"=>$this->input->post('quantity_ordered'),
            "unit_price"=>$this->input->post('unit_price'),
            "discount_percent"=>$this->input->post('discount_percent'),
            "discount_percent2"=>$this->input->post('discount_percent2'),
            "discount_percent3"=>$this->input->post('discount_percent3'),
            "client_code"=>$this->input->post('client_code'),
            "line_total"=>$line_total,
        );

        // if($this->input->post('form_mod_id')){
        //     $this->purchasing_model->update_header($items,$this->input->post('form_mod_id'));
        //     $id = $this->input->post('form_mod_id');
        //     $act = 'update';
        //     $msg = 'Details has been updated.';
        // }else{
            $id = $this->purchasing_model->add_items($items);
            $act = 'add';
            $msg = 'Item has been added.';
        //}

        echo json_encode(array("id"=>$id,"desc"=>$this->input->post('order_no'),"act"=>$act,'msg'=>$msg,'order_no'=>$this->input->post('order_no')));
    }
    public function get_items_added($order_no=null,$asJson=true){
    	$pos = array();
    	$pos = $this->purchasing_model->get_po_items($order_no);

    	$code = tableItems($pos);

        echo json_encode(array("code"=>$code));
    }
    public function delete_item($ref=null){

            $id = $this->purchasing_model->delete_item($ref);
            $msg = 'Item has been deleted.';

        echo json_encode(array("msg"=>$msg));
    }
    //********************Inventory Adjustment*****Allyn*****end
	// ======================================================================================= //
    //          INQUIRIES
    // ======================================================================================= //
	public function item_movement_inquiry()
    {
        $data = $this->syter->spawn('item_movement');

        $data['page_title'] = fa('fa-bar-chart')." Item Movement Inquiry";


        $data['code'] = build_item_movement_inquiry();
        $data['add_css'][] = 'css/daterangepicker/daterangepicker-bs3.css';
        $data['add_js'][] = 'js/plugins/daterangepicker/daterangepicker.js';

        $data['load_js'] = 'core/inventory.php';
        $data['use_js'] = 'itemMovementSearchJs';
        $this->load->view('page',$data);
    }
    public function movement_inquiry_results()
    {
        if (!$this->input->post())
            header('Location:'.base_url().'inventory/item_movement_inquiry');

        $item_id = $this->input->post('item_id');
        $loc_code = $this->input->post('loc_code');

        $daterange = $this->input->post('daterange');
        $dates = explode(" to ",$daterange);
        $date_from = (empty($dates[0]) ? date('Y-m-d') : date('Y-m-d',strtotime($dates[0])));
        $date_to = (empty($dates[1]) ? date('Y-m-d') : date('Y-m-d',strtotime($dates[1])));

        $results = $this->inventory_model->get_item_movement($item_id, $loc_code, $date_from, $date_to);
        $data['code'] = build_so_display($results, $item_id, $loc_code, $date_from, $date_to);
        $this->load->view('load',$data);
    }

    //////////////////////////////////JED////////////////////////////////
    //////////////////////////////////////////////////////////////////////
    public function hardware_movement_inquiry()
    {
        $data = $this->syter->spawn('hardware_movement');

        $data['page_title'] = fa('fa-bar-chart')." Hardware Movement Inquiry";


        $data['code'] = build_hware_movement_inquiry();
        $data['add_css'][] = 'css/daterangepicker/daterangepicker-bs3.css';
        $data['add_js'][] = 'js/plugins/daterangepicker/daterangepicker.js';

        $data['load_js'] = 'core/inventory.php';
        $data['use_js'] = 'itemHardwareSearchJs';
        $this->load->view('page',$data);
    }
    public function hware_inquiry_results()
    {
        if (!$this->input->post())
            header('Location:'.base_url().'inventory/hardware_movement_inquiry');

        $item_id = $this->input->post('item_id');
        $loc_code = $this->input->post('loc_code');

        $daterange = $this->input->post('daterange');
        $dates = explode(" to ",$daterange);
        $date_from = (empty($dates[0]) ? date('Y-m-d') : date('Y-m-d',strtotime($dates[0])));
        $date_to = (empty($dates[1]) ? date('Y-m-d') : date('Y-m-d',strtotime($dates[1])));

        $results = $this->inventory_model->get_hardware_movement($item_id, $loc_code, $date_from, $date_to);
        $data['code'] = build_hw_display($results, $item_id, $loc_code, $date_from, $date_to);
        $this->load->view('load',$data);
    }
    public function view_hardware_adjustment($trx_id)
    {
    	$details = $this->inventory_model->get_hw_trans_header(
    		array(array('key'=>'non_stock_moves.counter',
    			'value'=>$trx_id,
    			'escape'=>true)));

        $data = $this->syter->spawn('inv_adjustment');
        $data['page_title'] = "Hardware Movement Entry";

        $data['code'] = viewHardwareMovementBox($details);
        // $data['add_css'] = 'js/plugins/typeaheadmap/typeaheadmap.css';
        // $data['add_js'] = array('js/plugins/typeaheadmap/typeaheadmap.js');
        $data['load_js'] = 'core/inventory.php';
        $data['use_js'] = 'inventoryAdjustmentJS';
        $this->load->view('load',$data);
    }
    public function multiple_adjustment_form($trx_id=null){
        $this->load->model('core/inventory_model');
        $this->load->helper('core/inventory_helper');

        $this->session->unset_userData('adj_session');

        $data = $this->syter->spawn('mul_adjustment');
        $data['page_title'] = "Multiple Adjustment Entry";

        $next_ref = $this->site_model->get_next_ref(INVENTORY_ADJUSTMENT);
        $type_no = $next_ref->next_type_no;
        $reference = $next_ref->next_ref;

        // $data['code'] = inventoryAdjustmentFormLoad($trx_id, $type_no, $reference);
        // $data['add_css'] = 'js/plugins/typeaheadmap/typeaheadmap.css';
        // $data['add_js'] = array('js/plugins/typeaheadmap/typeaheadmap.js');
        // $data['load_js'] = 'core/inventory.php';
        // $data['use_js'] = 'inventoryAdjustmentJS';
        // $this->load->view('page',$data);

		$data['code'] = MultipleAdjPage($type_no, $reference);
        $data['add_css'] = 'js/plugins/typeaheadmap/typeaheadmap.css';
        $data['add_js'] = array('js/plugins/typeaheadmap/typeaheadmap.js');
        $data['load_js'] = 'core/inventory.php';
        $data['use_js'] = 'MulAdjJS';
        $this->load->view('page',$data);
    }
    public function multiple_adj_details(){

        $next_ref = $this->site_model->get_next_ref(INVENTORY_ADJUSTMENT);
        $type_no = $next_ref->next_type_no;
        $reference = $next_ref->next_ref;

        $data['code'] = multipleAdjFormLoad($type_no, $reference);
        $data['add_css'] = 'js/plugins/typeaheadmap/typeaheadmap.css';
        $data['add_js'] = array('js/plugins/typeaheadmap/typeaheadmap.js');
        $data['load_js'] = 'core/inventory.php';
        $data['use_js'] = 'multipleAdjustmentPageJS';
        $this->load->view('load',$data);

    }
    public function multiAdj_items_load(){
        $adj_session = array();
        if($this->session->userData('adj_session'))
            $adj_session = $this->session->userData('adj_session');


        $data['code'] = adjItemsLoad($adj_session);
        $data['load_js'] = 'core/inventory.php';
        $data['use_js'] = 'multipleAdjustmentJS';
        $this->load->view('load',$data);
    }
    public function add_adj_session(){
        $adj_session = array();
        if($this->session->userData('adj_session'))
            $adj_session = $this->session->userData('adj_session');

        $item_id = $this->input->post('item_id');
        $qty = $this->input->post('qty_delivered');
        $uom = $this->input->post('select-uom');
        $price = $this->input->post('unit_price');
        // $val = $this->input->post('val');
        // $poref = $this->input->post('poref');
        // $inv = $this->input->post('inv');
        // $ltotal = $this->input->post('linetotal');

        $adj_session[] = array(
            'item_id'=>$item_id,
            'qty'=>$qty,
            'uom'=>$uom,
            'price'=>$price
        );

        $this->session->set_userData('adj_session',$adj_session);

        // var_dump($adj_session);

    }
    public function remove_adj_session(){
        $adj_session = array();
        if($this->session->userData('adj_session'))
            $adj_session = $this->session->userData('adj_session');

        $ref = $this->input->post('ref');
        unset($adj_session[$ref]);

        $this->session->set_userData('adj_session',$adj_session);

        //var_dump($suppinv_sess);

    }
    public function multiple_adjustment_db(){


    	$next_ref = $this->site_model->get_next_ref(INVENTORY_ADJUSTMENT);
        $type_no = $next_ref->next_type_no;
        $reference = ($this->input->post('reference') ? $this->input->post('reference') : $next_ref->next_ref);

		$user = $this->session->userdata('user');
		$from_loc = $this->input->post('from_loc');
		$trans_date = $this->input->post('trans_date');
		$movement_type = $this->input->post('movement_type');


		$adj_session = array();
        if($this->session->userData('adj_session'))
            $adj_session = $this->session->userData('adj_session');

        $counter = 0;
        if(count($adj_session) > 0){

        	foreach($adj_session as $key => $val){

               $items = array(
		            "item_id"=>$val['item_id'],
		            "trans_type"=>INVENTORY_ADJUSTMENT,
		            "type_no"=>$type_no,
		            "trans_date"=>date2Sql($trans_date),
		            "loc_code"=>$from_loc,
		            "person_id"=>$user['id'],
		            "qty"=>$val['qty'],
		            "visible"=>1,
					"reference"=>$reference,
					"movement_type"=>$movement_type
		        );
                $id = $this->inventory_model->add_inventory_adjustment($items);
                $counter++;

            }


        }
        if($counter > 0){
        	$refs = array(
                'trans_type' => INVENTORY_ADJUSTMENT,
                'type_no' => $type_no,
                'reference' => $reference
                );

			$this->site_model->add_trans_ref($refs);
		}
        site_alert('Adjustments has been processed.','success');
        $this->session->unset_userData('adj_session');
        //echo $this->input->post('hline_total');
    }
	//-----LISTING TYPE OF MAINTENANCE-----APM-----START
	//-----UOM-----START
	public function uoms($ref='')
	{
		$data = $this->syter->spawn('inventory');
		$data['page_subtitle'] = "Units of Measurement ( UOM ) Maintenance";
		$uoms = $this->inventory_model->get_uom_list();
		//echo $this->db->last_query();
		$data['code'] = uomListPage($uoms);
		$this->load->view('page',$data);
	}
	public function manage_uoms($uom_id=null){
        // $data = $this->syter->spawn('products_master');
        $data = $this->syter->spawn('inventory');
        $data['page_subtitle'] = "Manage UOM";
        $items = null;
        $receive_cart = array();

        if($uom_id != null){
           	$details = $this->inventory_model->get_uom_list($uom_id);
            $items = $details[0];
        }

        $data['code'] = manage_uom_form($items);

        $data['add_js'] = 'js/site_list_forms.js';
        $data['load_js'] = "core/inventory.php";
        $data['use_js'] = "inventoryUomJS";
        $this->load->view('page',$data);
    }
	public function uom_details_db()
	{
		// if (!$this->input->post())
			// header("Location:".base_url()."items");
		$user = $this->session->userdata('user');
		$status = "";
		$items = array(
			'unit_code' => $this->input->post('unit_code'),
			'description' => $this->input->post('description'),
			'qty' => $this->input->post('qty'),
			'inactive' => $this->input->post('inactive'),
		);
		
		$mode = $this->input->post('mode');
		// echo "Mode : ".$mode."<br>";
		
		if($mode == 'add')
			$product_code_exist = $this->inventory_model->uom_name_exist_add_mode($this->input->post('unit_code'));
		else if($mode == 'edit')
			$product_code_exist = $this->inventory_model->uom_name_exist_edit_mode($this->input->post('unit_code'), $this->input->post('id'));
		
		// echo "Product Code exist : ".$product_code_exist."<br>";
		
		if($product_code_exist){
			$id = '';
			$msg = "WARNING : UOM Name [ ".$this->input->post('unit_code')." ] already exists!";
			$status = "warning";
		}else{
			if ($this->input->post('id')) {
				$id = $this->input->post('id');
				// echo "This unit code:".$this->input->post('unit_code')."<br>";
				// echo var_dump($items);
				$this->inventory_model->update_uom($items,$id);
				$msg = "Updated UOM : ".ucwords($this->input->post('unit_code'));
				$status = "success";
			}else{
				$id = $this->inventory_model->add_uom($items);
				$this->inventory_model->add_per_branch_uom($items);
				##########AUDIT TRAIL [START]##########
				$audit_items = array(
				'type'=>0,
				'trans_no'=>0,
				'type_desc'=>ADD_UNIT_OF_MEASURE,
				'description'=>'uom_id:'.$id.'||unit_code:"'.strtoupper($this->input->post('unit_code')).'"||description:"'.ucfirst($this->input->post('description')).'"',
				'user'=>$user['id']
				);
				
				$audit_id = $this->inventory_model->write_to_audit_trail($audit_items);
				##########AUDIT TRAIL [END]##########
				
				$msg = "Added New UOM : ".ucwords($this->input->post('unit_code'));
				$status = "success";
			}
		}
		
		echo json_encode(array('status'=>$status, 'id'=>$id,'msg'=>$msg));
	}
	public function confirm_uom($unit_code=null){
        $data['code'] = confirm_a_form($unit_code);

        $data['add_js'] = 'js/site_list_forms.js';
        // $data['load_js'] = "core/inventory.php";
        // $data['use_js'] = "inventoryUomJS";
        $this->load->view('load',$data);
    }
	//-----UOM-----END
	//-----LISTING TYPE OF MAINTENANCE-----APM-----END

	//<------------stock category---------->//
	
	public function stock_category($ref=''){
	
		$data = $this->syter->spawn('inventory');
		$data['page_subtitle'] = "Stock Categories / Maintenance";
		$Category = $this->inventory_model->get_stock_category();
		//echo $this->db->last_query();
		
        $data['add_js'] = 'js/site_list_forms.js';
        $data['load_js'] = "core/inventory.php";
        $data['use_js'] = "sampleJS";
		
		$data['code'] = Stock_Category_Page($Category);
		$this->load->view('page',$data);
	}

	//-----ADD and EDIT
	public function manage_stock_category($id=null){
        // $data = $this->syter->spawn('products_master');
        $data = $this->syter->spawn('inventory');
        $data['page_subtitle'] = "Manage Stock Category";
        $items = null;
        $receive_cart = array();

        if($id != null){
           	$details = $this->inventory_model->get_stock_category($id);
            $items = $details[0];
        }

        $data['code'] = manage_stock_category_form($items);

        $data['add_js'] = 'js/site_list_forms.js';
        $data['load_js'] = "core/inventory.php";
        $data['use_js'] = "categoryJS";
        $this->load->view('page',$data);
    }
	
	//insert update
	public function stock_category_details_db(){
		$user = $this->session->userdata('user');
		$status = "";
		$items = array(
			'id' => $this->input->post('id'),
			'short_desc' => $this->input->post('short_desc'),
			'description' => $this->input->post('description'),
			'subcat_id' => $this->input->post('subcat_id'),
			'inactive' => $this->input->post('inactive'),
		);
		
		$mode = $this->input->post('mode');
		// echo "Mode : ".$mode."<br>";	
		if($mode == 'add')
			$product_code_exist = $this->inventory_model->category_code_exist_add_mode($this->input->post('description'));
		else if($mode == 'edit')
			$product_code_exist = $this->inventory_model->category_code_exist_edit_mode($this->input->post('description'), $this->input->post('id'));
		
		// echo "Product Code exist : ".$product_code_exist."<br>";
		
		if($product_code_exist){
			$id = '';
			$msg = "WARNING : Stock Category Name [ ".$this->input->post('description')." ] already exists!";
			$status = "warning";
		}else{
		
			if ($this->input->post('id')) {
				$id = $this->input->post('id');
				$this->inventory_model->update_category($items,$id);
				$msg = "Updated Stock Category Name : ".ucwords($this->input->post('description'));
				$status = "success";
			}else{
				$id = $this->inventory_model->add_category($items);
				##########AUDIT TRAIL [START]##########
				$audit_items = array(
				'type'=>0,
				'trans_no'=>0,
				'type_desc'=>ADD_STOCK_CATEGORY,
				'description'=>'id:'.$id.'||short_desc:"'.strtoupper($this->input->post('short_desc')).'"||description:"'.ucfirst($this->input->post('description')).'"',
				'user'=>$user['id']
				);
				
				$audit_id = $this->inventory_model->write_to_audit_trail($audit_items);
				##########AUDIT TRAIL [END]##########
				$msg = "Added Stock Category Name: ".ucwords($this->input->post('description'));
				$status = "success";
			}
		}
		
		// echo var_dump($items)."<br>";
		// echo "Current Status : ".$status."<br>";
		echo json_encode(array('status'=>$status, 'id'=>$id,'msg'=>$msg));
	}
	//<-----------stock category end ------ >//
	
	//-----Stock Location----START
	public function stock_locations($ref=''){
		$data = $this->syter->spawn('inventory');
		$data['page_subtitle'] = "Stock Locations Management";
		$stockLocation = $this->inventory_model->get_stock_locations();
		//echo $this->db->last_query();
		$data['code'] = stockLocationPage($stockLocation);
		$data['add_js'] = 'js/site_list_forms.js';
        $data['load_js'] = "core/inventory.php";
		$data['use_js'] = "StockLocationJS";
		$this->load->view('page',$data);
    }
	public function manage_stock_locations($stc_id=null){
     
        $data = $this->syter->spawn();
		$stc = null;
       if (is_null($stc_id)){
			$data['page_title'] = fa('fa-archive fa-fw')." Add New Stock Location";
		}else {
			$stc= $this->inventory_model->get_stock_locations($stc_id);
			$stc = $stc[0];
			if (!empty($stc->id)) {
				$data['page_title'] = fa('fa-archive fa-fw')." ".iSetObj($stc,'loc_code');
			} else {
				header('Location:'.base_url().'inventory/manage_stock_locations');
			}
		}
        $data['code'] = stockLocationsForm($stc);

        $data['add_js'] = 'js/site_list_forms.js';
        $data['load_js'] = "core/inventory.php";
        $data['use_js'] = "StockLocationJS";
        $this->load->view('page',$data);
    }
	public function stock_details_db()
	{
		// if (!$this->input->post())
			// header("Location:".base_url()."items");
		$user = $this->session->userdata('user');
		$status = "";
		$items = array(
			'loc_code' => $this->input->post('loc_code'),
			'loc_name' => $this->input->post('loc_name'),
			'address' => $this->input->post('address'),
			'inactive' => $this->input->post('inactive'),
		);
		
		$mode = $this->input->post('mode');
		// echo "Mode : ".$mode."<br>";
		
		if($mode == 'add')
			$loc_code_exist = $this->inventory_model->stock_location_code_exist_add_mode($this->input->post('loc_code'));
		else if($mode == 'edit')
			$loc_code_exist = $this->inventory_model->stock_location_code_exist_edit_mode($this->input->post('loc_code'), $this->input->post('id'));
		
		// echo "Product Code exist : ".$product_code_exist."<br>";
		
		if($loc_code_exist){
			$id = '';
			$msg = "WARNING : Location Code [ ".$this->input->post('loc_code')." ] already exists!";
			$status = "warning";
		}else{
			if ($this->input->post('id')) {
				$id = $this->input->post('id');
				$this->inventory_model->update_stock_locations($items,$id);
				$msg = "Updated Location : ".ucwords($this->input->post('loc_name'));
				$status = "success";
			}else{
				$id = $this->inventory_model->add_stock_locations($items);
				##########AUDIT TRAIL [START]##########
				$audit_items = array(
				'type'=>0,
				'trans_no'=>0,
				'type_desc'=>ADD_STOCK_LOCATION,
				'description'=>'id:'.$id.'||loc_code:"'.strtoupper($this->input->post('loc_code')).'"||loc_name:"'.ucfirst($this->input->post('loc_name')).'"',
				'user'=>$user['id']
				);
				
				$audit_id = $this->inventory_model->write_to_audit_trail($audit_items);
				##########AUDIT TRAIL [END]##########
				$msg = "Added New Stock Location: ".ucwords($this->input->post('loc_name'));
				$status = "success";
			}
		}
		
		// echo var_dump($items)."<br>";
		// echo "Current Status : ".$status."<br>";
		echo json_encode(array('status'=>$status, 'id'=>$id,'msg'=>$msg));
	}
	//-----Stock Location----END
	
	//-----POS DISCOUNTS-----CSR-----START
	public function discounts($ref=''){
	
		$data = $this->syter->spawn('inventory');
		$data['page_subtitle'] = "Discounts / Maintenance";
		$Category = $this->inventory_model->get_discounts();
		//echo $this->db->last_query();
		
        $data['add_js'] = 'js/site_list_forms.js';
        $data['load_js'] = "core/inventory.php"; //-----js not needed - temporarily 1
        $data['use_js'] = "sampleJS"; //-----js not needed - temporarily 2
		
		$data['code'] = discounts_page($Category);
		$this->load->view('page',$data);
	}
	
	//-----ADD and EDIT
	public function manage_discount($id=null){
        // $data = $this->syter->spawn('products_master');
        $data = $this->syter->spawn('inventory');
        $data['page_subtitle'] = "Manage Discounts";
        $items = null;
        $receive_cart = array();

        if($id != null){
           	$details = $this->inventory_model->get_discounts($id);
            $items = $details[0];
        }

        $data['code'] = manage_discount_form($items);

        $data['add_js'] = 'js/site_list_forms.js';
        $data['load_js'] = "core/inventory.php";
        $data['use_js'] = "posDiscountsJS";
        $this->load->view('page',$data);
    }
	//-----POS DISCOUNTS-----CSR-----END
	
	
	//---> add stock start
	
	
    private function add_stocks_container($ref,&$data)
	{
		if (!strcasecmp($ref, 'new'))
			$data['page_subtitle'] = "New Stock Item";
		else
			$data['page_subtitle'] = "Edit Stock Item";

		$data['code'] = add_build_stock_container($ref);
		$data['load_js'] = "core/inventory.php";
		$data['use_js'] = "addstockMasterJS";
	}
	
	public function add_stock_main_form($ref)
	{
		$active_pane = '';
		$items = array();
		if($ref != 'new'){
			$data = explode('|',urldecode($ref));
			$id = $data[0]; 
			$active_pane = $data[1]; 	
		}

		//$active_pane = $data[1]; 
		$data['page_subtitle'] = "New Stock Item";
		// echo "Ref val : ".$ref."<br>";
		if (strcasecmp($ref,'new')) {
			// $results = $this->inventory_model->get_stocks(array('stock_id'=>$ref)); //for multiple columns in where clause
			$results = $this->inventory_model->get_stocks_temp($id);
			if ($results) {
				$items = $results[0];
			//	$data['page_subtitle'] = "Edit Stock Item";
			}
			
		}
		$data['code'] = add_build_stock_main_form($items,$active_pane);
		$data['load_js'] = "core/inventory.php";
		$data['use_js'] = "addstockMasterFormJS";
		$this->load->view('load',$data);
	}
	
	
	//stock ---- db
	
	public function add_stock_db()
	{
		$audit_items = $disc_type_items = $card_type_items = $br_all_det = $cos_items = $bs_stock = array();
		$stock_code_exist = $status = $stock_disc_exists = $stock_crd_type_exists = "";
		# get user data
		$user = $this->session->userdata('user');
		$items = array(
			'description' =>ucfirst($this->input->post('description')),
			'stock_code' => strtoupper($this->input->post('stock_code')),
			'category_id' => $this->input->post('category_id'),
			'report_uom' => $this->input->post('report_uom'),
			'report_qty' => $this->input->post('report_qty'),
			'tax_type_id' => (int) $this->input->post('tax_type_id'),
			'mb_flag' => $this->input->post('mb_flag'),
			'is_consigned' => (int) $this->input->post('is_consigned'),
			'is_saleable' => (int) $this->input->post('is_saleable'),
			// 'standard_cost' => $this->input->post('standard_cost'),
			// 'last_cost' => $this->input->post('last_cost'),
			'sales_account' => (int) $this->input->post('sales_account'),
			'cogs_account' => (int) $this->input->post('cogs_account'),
			'inventory_account' => (int) $this->input->post('inventory_account'),
			'adjustment_account' => (int) $this->input->post('adjustment_account'),
			'assembly_cost_account' => (int) $this->input->post('assembly_cost_account'),
		);

		$mode = $this->input->post('mode');
		// echo "Mode : ".$mode."<br>";
		
		if($mode == 'add'){
			$stock_code_exist = $this->inventory_model->stock_code_exists_add_mode($this->input->post('stock_code'));
			$stock_code_exist_temp = $this->inventory_model->stock_code_exists_add_mode_temp($this->input->post('stock_code'));
		}else if($mode == 'edit'){
			$stock_code_exist = $this->inventory_model->stock_code_exists_edit_mode($this->input->post('stock_code'), $this->input->post('stock_id'));
			$stock_code_exist_temp = $this->inventory_model->stock_code_exists_edit_mode_temp($this->input->post('stock_code'), $this->input->post('stock_id'));
		}
		if($stock_code_exist){
			$id = '';
			$msg = "WARNING : Stock Code [ ".$this->input->post('stock_code')." ] already exists!";
			$status = "warning";
		}else if($stock_code_exist_temp){
			$id = '';
			$msg = "WARNING : Stock Code [ ".$this->input->post('stock_code')." ] is for approval!";
			$status = "warning";
		}else{
			// echo var_dump($items);
			if ($this->input->post('stock_id')) {
				// echo "Stock ID - update : ".$this->input->post('stock_id'); //-----uncomment for debugging purpose/s
				
				// // $this->inventory_model->update_stock_master_item($items,array('id'=>$this->input->post('stock_id'))); //multiple WHERE clause content
				$id = $this->input->post('stock_id');
				$this->inventory_model->update_stock_master_item_temp($items,$this->input->post('stock_id')); // MMS COMMENT THIS LINE FOR STOCK LOGS PURPOSES
				
				##########AUDIT TRAIL [START]##########
					//-----Audit trail for editing is under JS/jquery
				##########AUDIT TRAIL [END]##########
				
				//-----Discounts-----START
				$disc_type_items = $this->inventory_model->get_pos_discount_types();
				foreach($disc_type_items as $disc_vals){
					$stock_disc_exists = $this->inventory_model->validate_stock_discount_temp($id, $disc_vals->id);
					if(!$stock_disc_exists){
						// echo "BRR7~~~<br>";
						$stock_disc_items = array(
							'stock_id'=>$id,
							'sales_type_id'=>1,
							'pos_discount_id'=>$disc_vals->id,
							'disc_enabled'=>$this->input->post($disc_vals->short_desc.'_disc'),
							'inactive'=>0,
						);
						$id2 = $this->inventory_model->write_stock_discount($stock_disc_items); //temp
					}else{
						// echo "BRR2~~~<br>";
						$stock_disc_items = array(
							'stock_id'=>$id,
							'sales_type_id'=>1,
							'pos_discount_id'=>$disc_vals->id,
							'disc_enabled'=>$this->input->post($disc_vals->short_desc.'_disc'),
							'inactive'=>0,
						);
						$id2 = $this->inventory_model->update_stock_discount_temp($stock_disc_items, $this->input->post('stock_id'), $disc_vals->id);// MMS COMMENT THIS LINE FOR STOCK LOGS PURPOSES
					}
				}
				//-----Discounts-----END
				
				//-----Allowed Cards-----START
				$card_type_items = $this->inventory_model->get_customer_card_types();
				foreach($card_type_items as $crd_vals){
					$stock_crd_type_exists = $this->inventory_model->validate_stock_card_type_temp($id, $crd_vals->id);
					if(!$stock_crd_type_exists){
						// echo "BRR1~~~<br>";
						$stock_card_items = array(
							'stock_id'=>$id,
							'sales_type_id'=>1,
							'card_type_id'=>$crd_vals->id,
							'is_enabled'=>$this->input->post($crd_vals->name.'_crd'),
							'inactive'=>0,
						);
						$id3 = $this->inventory_model->write_stock_card_type($stock_card_items); //temp table
					}else{
						// echo "BRR2~~~<br>";
						$stock_card_items = array(
							'stock_id'=>$id,
							'sales_type_id'=>1,
							'card_type_id'=>$crd_vals->id,
							'is_enabled'=>$this->input->post($crd_vals->name.'_crd'),
							'inactive'=>0,
						);
					$id3 = $this->inventory_model->update_stock_card_type_temp($stock_card_items, $this->input->post('stock_id'), $crd_vals->id); // MMS COMMENT THIS LINE FOR STOCK LOGS PURPOSES
					}
				}
				//-----Allowed Cards-----END
				//-----Cost of Sales per branch-----START
				$br_all_det = $this->inventory_model->get_active_branches();
				foreach($br_all_det as $all_br_vals){
					$cos_items = array(
						'stock_id'=>$id,
						'branch_id'=>$all_br_vals->id,
						'cost_of_sales'=>$this->input->post($all_br_vals->code.'_cost_of_sales'),
					);
					$id4 = $this->inventory_model->update_stock_cost_of_sales($cos_items);
					
						
							// if($all_br_vals->has_sa == 1){
								// $bs_stock2 = array(
									// 'stock_id'=>$id,
									// 'branch_id'=>$all_br_vals->id,
									// 'qty'=>0,
									// 'cost_of_sales'=>$this->input->post($all_br_vals->code.'_cost_of_sales'),
									// 'stock_loc_id'=>1
									// );
								  // $this->inventory_model->write_branch_stocks_temp($bs_stock2);
							// }
							
							// elseif($all_br_vals->has_sr == 1){
								// $bs_stock3 = array(
									// 'stock_id'=>$id,
									// 'branch_id'=>$all_br_vals->id,
									// 'qty'=>0,
									// 'cost_of_sales'=>$this->input->post($all_br_vals->code.'_cost_of_sales'),
									// 'stock_loc_id'=>2
									// );
								 // $this->inventory_model->write_branch_stocks_temp($bs_stock3);
							// }
							
							// elseif($all_br_vals->has_bo  == 1){
								// $bs_stock5 = array(
									// 'stock_id'=>$id,
									// 'branch_id'=>$all_br_vals->id,
									// 'qty'=>0,
									// 'cost_of_sales'=>$this->input->post($all_br_vals->code.'_cost_of_sales'),
									// 'stock_loc_id'=>3
									// );
								 // $this->inventory_model->write_branch_stocks_temp($bs_stock5);
							// }
				}
				//-----Cost of Sales per branch-----END
				$msg = "Updated Stock : ".ucwords($this->input->post('description'));
				$status = "success";
			} else {
				// echo "Stock ID - add : ".$this->input->post('stock_id'); //-----uncomment for debugging purpose/s
				$id = $this->inventory_model->write_stock_master_item($items); //temp table
				
				##########AUDIT TRAIL [START]##########
				$audit_items = array(
				'type'=>0,
				'trans_no'=>0,
				'type_desc'=>ADD_STOCK,
				'description'=>'stock_id:'.$id.'||stock_code:"'.strtoupper($this->input->post('stock_code')).'"||description:"'.ucfirst($this->input->post('description')).'"',
				'user'=>$user['id']
				);
				
				$audit_id = $this->inventory_model->write_to_audit_trail($audit_items);
				##########AUDIT TRAIL [END]##########
				
				//-----Discounts-----START
				$disc_type_items = $this->inventory_model->get_pos_discount_types();
				foreach($disc_type_items as $disc_vals){
					$stock_disc_exists = $this->inventory_model->validate_stock_discount_temp($id, $disc_vals->id);
					if(!$stock_disc_exists){
						// echo "BRR3~~~<br>";
						$stock_disc_items = array(
							'stock_id'=>$id,
							'sales_type_id'=>1,
							'pos_discount_id'=>$disc_vals->id,
							'disc_enabled'=>$this->input->post($disc_vals->short_desc.'_disc'),
							'inactive'=>0,
						);
						$id2 = $this->inventory_model->write_stock_discount($stock_disc_items);
					}
				}
				//-----Discounts-----END
				//-----Allowed Cards-----START
				$card_type_items = $this->inventory_model->get_customer_card_types();
				foreach($card_type_items as $crd_vals){
					$stock_crd_type_exists = $this->inventory_model->validate_stock_card_type_temp($id, $crd_vals->id);
					if(!$stock_crd_type_exists){
						// echo "BRR1~~~<br>";
						$stock_card_items = array(
							'stock_id'=>$id,
							'sales_type_id'=>1,
							'card_type_id'=>$crd_vals->id,
							'is_enabled'=>$this->input->post($crd_vals->name.'_crd'),
							'inactive'=>0,
						);
						$id3 = $this->inventory_model->write_stock_card_type($stock_card_items);
					}else{
						// echo "BRR2~~~<br>";
						$stock_card_items = array(
							'stock_id'=>$id,
							'sales_type_id'=>1,
							'card_type_id'=>$crd_vals->id,
							'is_enabled'=>$this->input->post($crd_vals->name.'_crd'),
							'inactive'=>0,
						);
						$id3 = $this->inventory_model->update_stock_card_type_temp($stock_card_items, $id, $crd_vals->id); // MMS COMMENT THIS LINE FOR STOCK LOGS PURPOSES
					}
				}
				//-----Allowed Cards-----END
				//-----Cost of Sales per branch-----START
				$br_all_det = $this->inventory_model->get_active_branches();
				foreach($br_all_det as $all_br_vals){
					$cos_items = array(
						'stock_id'=>$id,
						'branch_id'=>$all_br_vals->id,
						'cost_of_sales'=>$this->input->post($all_br_vals->code.'_cost_of_sales'),
					);
					$id4 = $this->inventory_model->write_stock_cost_of_sales($cos_items);
					
					
					if($all_br_vals->has_sa == 1){
						$bs_stock2 = array(
							'stock_id'=>$id,
							'branch_id'=>$all_br_vals->id,
							'qty'=>0,
						  //'cost_of_sales'=>$this->input->post($all_br_vals->code.'_cost_of_sales'),
							'stock_loc_id'=>1
							);
						 $this->inventory_model->write_branch_stocks_temp($bs_stock2);
				
					}
					if($all_br_vals->has_sr == 1){
						$bs_stock3 = array(
							'stock_id'=>$id,
							'branch_id'=>$all_br_vals->id,
							'qty'=>0,
						//	'cost_of_sales'=>$this->input->post($all_br_vals->code.'_cost_of_sales'),
							'stock_loc_id'=>2
							);
						 $this->inventory_model->write_branch_stocks_temp($bs_stock3);
						
					}
					
					if($all_br_vals->has_bo  == 1){
						$bs_stock4 = array(
							'stock_id'=>$id,
							'branch_id'=>$all_br_vals->id,
							'qty'=>0,
						//	'cost_of_sales'=>$this->input->post($all_br_vals->code.'_cost_of_sales'),
							'stock_loc_id'=>3
							);
					  $this->inventory_model->write_branch_stocks_temp($bs_stock4);
						
					}
					
		
				}
				//-----Cost of Sales per branch-----END
				$msg = "Added New Stock : ".ucwords($this->input->post('description'));
				$status = "success";
			}
		}
		echo json_encode(array('status'=>$status, 'id'=>$id,'msg'=>$msg));
		
	}
	
	
	
	######SUPPLIER######*********************######SUPPLIER######
	public function add_supplier_stock_form($ref)
	{
		$items = $barcode_prices = array();
		// $data['page_subtitle'] = "New Inventory Item";
		if (strcasecmp($ref,'new')) {
			// $results = $this->inventory_model->get_items(array('a.id'=>$ref));
			$results = $this->inventory_model->get_all_supplier_stocks_temp($ref);
			if ($results) {
				$items = $results[0];
				// $data['page_subtitle'] = "Edit Inventory Item";
			}
		}
		// echo $this->inventory_model->db->last_query();
		// echo var_dump($items);
		$data['code'] = add_build_supplier_stock_form($items, $ref, $barcode_prices);
		$data['load_js'] = "core/inventory.php";
		$data['use_js'] = "addsupplierStockFormJs";
		$this->load->view('load',$data);
	}
	
	public function add_supplier_stock_db()
	{
		$items = $br_all_det = $all_data = array();
		$id2  = $saving_type = $supp_mode = $mode_stat = $status = $msg = "";
		$saving_type = $this->input->post('saving_type');
		
		$supp_mode = $this->input->post('supp_mode');
		$disc_type1 = $this->input->post('disc_type1');
		$disc_type2 = $this->input->post('disc_type2');
		$disc_type3 = $this->input->post('disc_type3');
		$default = (int)$this->input->post('is_default');
		$user = $this->session->userdata('user');
		
		$id = explode('|',urldecode($this->input->post('hidden_stock_id')));
		
		if($saving_type == 'single'){

			if($supp_mode == 'add'){
				
				$items = array(
				'stock_id'=>$id[0],
				'supp_stock_code'=>$this->input->post('supp_stock_code'),
				'description'=>$this->input->post('description'),
				'supp_id'=>(int)$this->input->post('supp_id'),
				'branch_id'=>$this->input->post('hidden_branch_id'),
				// 'branch_id'=>$this->input->post('branch_id'),
				'uom'=>$this->input->post('uom'),
				'unit_cost'=>$this->input->post('unit_cost'),
				'qty'=>$this->input->post('qty'),
				'disc_percent1' => ($disc_type1 == 'percent' ? $this->input->post('discount1') : 0),
				'disc_percent2' => ($disc_type2 == 'percent' ? $this->input->post('discount2') : 0),
				'disc_percent3' => ($disc_type3 == 'percent' ? $this->input->post('discount3') : 0),
				'disc_amount1' => ($disc_type1 == 'amount' ? $this->input->post('discount1') : 0),
				'disc_amount2' => ($disc_type2 == 'amount' ? $this->input->post('discount2') : 0),
				'disc_amount3' => ($disc_type3 == 'amount' ? $this->input->post('discount3') : 0),
				'avg_cost'=>$this->input->post('avg_cost'),
				'net_cost'=>$this->input->post('net_cost'),
				'avg_net_cost'=>$this->input->post('avg_net_cost'),
				'is_default'=>(int)$this->input->post('is_default'),
				'inactive'=>(int)$this->input->post('inactive'),
				'added_by'=>$user['id'],
				'datetime_added'=>date('Y-m-d H:i:s')
				);
			//	 echo var_dump($items);
				$id = $this->inventory_model->write_supplier_stock_item($items);
				$msg = "Added New Supplier Stock : ".ucwords($this->input->post('supp_stock_code'));
				$status = "success";
				$form_mode = "add";
			}else{
				$items = array(
				'stock_id'=>$id[0],
				'supp_stock_code'=>$this->input->post('supp_stock_code'),
				'description'=>$this->input->post('description'),
				'supp_id'=>$this->input->post('hidden_supplier_id'),
				'branch_id'=>$this->input->post('hidden_branch_id'),
				'uom'=>$this->input->post('hidden_stock_uom'),
				'unit_cost'=>$this->input->post('unit_cost'),
				'qty'=>$this->input->post('qty'),
				'disc_percent1' => ($disc_type1 == 'percent' ? $this->input->post('discount1') : 0),
				'disc_percent2' => ($disc_type2 == 'percent' ? $this->input->post('discount2') : 0),
				'disc_percent3' => ($disc_type3 == 'percent' ? $this->input->post('discount3') : 0),
				'disc_amount1' => ($disc_type1 == 'amount' ? $this->input->post('discount1') : 0),
				'disc_amount2' => ($disc_type2 == 'amount' ? $this->input->post('discount2') : 0),
				'disc_amount3' => ($disc_type3 == 'amount' ? $this->input->post('discount3') : 0),
				'avg_cost'=>$this->input->post('avg_cost'),
				'net_cost'=>$this->input->post('net_cost'),
				'avg_net_cost'=>$this->input->post('avg_net_cost'),
				'is_default'=>(int)$this->input->post('is_default'),
				'inactive'=>(int)$this->input->post('inactive'),
				'added_by'=>$user['id'],
				'datetime_added'=>date('Y-m-d H:i:s')
				);
				// echo var_dump($items);
			//	 echo var_dump($items);
				$this->inventory_model->update_supplier_stock_item($items,$this->input->post('hidden_supplier_stock_id'));
				$msg = "Updated Supplier Stock : ".ucwords($this->input->post('supp_stock_code'));
				$status = "success";
				$form_mode = "edit";
			}
			echo json_encode(array('result'=>$status,'mode_stat'=>$mode_stat, 'msg'=>$msg, 'stock_id'=>$id[0], 'supp_stock_code'=>$this->input->post('supp_stock_code'), 'branch'=>$this->input->post('hidden_branch_id'), 'form_mode'=>$form_mode));
		}else{
			//----------ALL
			// echo "ALL BRANCHES BTN<br>";
			$disc_type1 = $this->input->post('disc_type1');
			$disc_type2 = $this->input->post('disc_type2');
			$disc_type3 = $this->input->post('disc_type3');
			$default = (int)$this->input->post('is_default');
			
			 //echo $disc_type1."---".$disc_type2."~~~".$disc_type3."===<br>";
			
			$br_all_det = $this->inventory_model->get_active_branches();
			foreach($br_all_det as $all_br_vals){
				if($supp_mode == 'add'){
					$all_data = array(
					'stock_id'=>$id[0],
					'supp_stock_code'=>$this->input->post('supp_stock_code'),
					'description'=>$this->input->post('description'),
					'supp_id'=>(int)$this->input->post('supp_id'),
					'branch_id'=>$all_br_vals->id,
					// 'branch_id'=>$this->input->post('branch_id'),
					'uom'=>$this->input->post('uom'),
					'unit_cost'=>$this->input->post('unit_cost'),
					'qty'=>$this->input->post('qty'),
					'disc_percent1' => ($disc_type1 == 'percent' ? ($this->input->post('discount1')+0) : 0),
					'disc_percent2' => ($disc_type2 == 'percent' ? ($this->input->post('discount2')+0) : 0),
					'disc_percent3' => ($disc_type3 == 'percent' ? ($this->input->post('discount3')+0) : 0),
					'disc_amount1' => ($disc_type1 == 'amount' ? ($this->input->post('discount1')+0) : 0),
					'disc_amount2' => ($disc_type2 == 'amount' ? ($this->input->post('discount2')+0) : 0),
					'disc_amount3' => ($disc_type3 == 'amount' ? ($this->input->post('discount3')+0) : 0),
					'avg_cost'=>$this->input->post('avg_cost'),
					'net_cost'=>$this->input->post('net_cost'),
					'avg_net_cost'=>$this->input->post('avg_net_cost'),
					'is_default'=>$default,
					'inactive'=>(int)$this->input->post('inactive'),
					'added_by'=>$user['id'],
					'datetime_added'=>date('Y-m-d H:i:s')
					);
					// echo var_dump($all_data);
					// $id = $this->inventory_model->write_supplier_stock_item($items);
					$id2 = $this->inventory_model->write_supplier_stock_item_all_branches($all_data);
					$msg = "Added New Supplier Stock : ".ucwords($this->input->post('supp_stock_code'));
					//$msg =  $id2;
					$status = "success";
					$form_mode = "add";
				}else{
					
					
					$all_data = array(
					'stock_id'=>$id[0],
					'supp_stock_code'=>$this->input->post('supp_stock_code'),
					'description'=>$this->input->post('description'),
					'supp_id'=>$this->input->post('hidden_supplier_id'),
					// 'branch_id'=>$this->input->post('hidden_branch_id'),
					'branch_id'=>$all_br_vals->id,
					'uom'=>$this->input->post('hidden_stock_uom'),
					'unit_cost'=>$this->input->post('unit_cost'),
					'qty'=>$this->input->post('qty'),
					'disc_percent1' => ($disc_type1 == 'percent' ? ($this->input->post('discount1')+0) : 0),
					'disc_percent2' => ($disc_type2 == 'percent' ? ($this->input->post('discount2')+0) : 0),
					'disc_percent3' => ($disc_type3 == 'percent' ? ($this->input->post('discount3')+0) : 0),
					'disc_amount1' => ($disc_type1 == 'amount' ? ($this->input->post('discount1')+0) : 0),
					'disc_amount2' => ($disc_type2 == 'amount' ? ($this->input->post('discount2')+0) : 0),
					'disc_amount3' => ($disc_type3 == 'amount' ? ($this->input->post('discount3')+0) : 0),
					'avg_cost'=>$this->input->post('avg_cost'),
					'net_cost'=>$this->input->post('net_cost'),
					'avg_net_cost'=>$this->input->post('avg_net_cost'),
					'is_default'=>$default,
					'inactive'=>(int)$this->input->post('inactive'),
					'added_by'=>$user['id'],
					'datetime_added'=>date('Y-m-d H:i:s')
					);
				//	 echo var_dump($all_data);
					// $this->inventory_model->update_supplier_stock_item($items,$this->input->post('hidden_supplier_stock_id'));
					$id2 = $this->inventory_model->write_supplier_stock_item_all_branches($all_data);
					$msg = "Updated Supplier Stock : ".ucwords($this->input->post('supp_stock_code'));
					
					$status = "success";
					$form_mode = "edit";
				}
				
			}
			//----------ALL
			echo json_encode(array('result'=>$status,'mode_stat'=>$mode_stat, 'msg'=>$msg, 'stock_id'=>$id[0], 'supp_stock_code'=>$this->input->post('supp_stock_code'), 'branch'=>'all', 'form_mode'=>$form_mode));
		}
			
		
	}
	
	
	public function load_supplier_stocks_add($supp_stock_id=null){
		$items = $barcode_prices = array();
		$ref = $this->input->post('ref');
		
		// echo "Ref: $ref <br>";
		if (strcasecmp($ref,'new')) {
				$results = $this->inventory_model->get_supplier_stocks_temp($ref);
			if ($results) {
				$items = $results;
			}
		}
		$data['code'] = add_build_supplier_stocks_list($results, (!empty($ref) ? $ref : null));
		//-----TEMP SCRIPT
		$data['load_js'] = "core/inventory.php";
		$data['use_js'] = "addreloadSupplierStockDetailsJs";
		//-----TEMP SCRIPT
		$this->load->view('load',$data);
	}
	
	
	
	
	
	
	####################*********ADD**BARCODE*************###################
	
	public function add_stock_barcode_form($ref)
	{
		$items = $barcode_prices = array();
		// $data['page_subtitle'] = "New Inventory Item";
		if (strcasecmp($ref,'new')) {
			$results = $this->inventory_model->get_stocks_temp($ref);
			if ($results) {
				$items = $results[0];
			}
		}
		$data['code'] = add_build_stock_barcode_form($items, $ref, $barcode_prices);
		$data['load_js'] = "core/inventory.php";
		$data['use_js'] = "addstockBarcodeFormJs";
		$this->load->view('load',$data);
	}
	
	public function add_load_stock_barcode_prices(){
		$barcode = $this->input->post('barcode');
		$data['code'] = add_build_stock_barcode_price_list(!empty($barcode) ? $barcode : null);
		//-----TEMP SCRIPT
		$data['load_js'] = "core/inventory.php";
		$data['use_js'] = "addreloadBarcodeDetailsJs";
		//-----TEMP SCRIPT
		$this->load->view('load',$data);
	}
	
public function add_stock_barcode_db()
	{
		$br_all_det = $br_det = $sales_type_items = $price_items = array();
		$id2 = $br_res = $barcode_exists = $barcode_price_exists = "";
		$user = $this->session->userdata('user');
		$mode = $this->input->post('mode');
		$barcode_mode = $this->input->post('barcode_mode');
		$id = explode('|',urldecode($this->input->post('hidden_stock_id')));

		
		if($mode == 'add'){
			$items = array(
				'stock_id' => $id[0],
				'barcode' => $this->input->post('barcodes'),
				'short_desc' => $this->input->post('short_desc'),
				'description' => $this->input->post('description'),
				'uom' => $this->input->post('uom'),
				'qty' => $this->input->post('qty'),
				'sales_type_id' => (int)$this->input->post('sales_type_id'),
				'inactive' => $this->input->post('inactive'),
			);
		//	echo var_dump($items);
			$barcode_exists = $this->inventory_model->barcode_exists_add_mode($this->input->post('barcodes'));
			$barcode_exists_temp = $this->inventory_model->barcode_exists_add_mode_temp($this->input->post('barcodes'));
		}else{
			
			//-----NOTE: correct items to be updated. UOM should NOT BE EDITABLE, only the description of the stock barcode item.
			$user = $this->session->userdata('user');
			$items = array(
				// 'stock_id' => $id[0],
				// 'barcode' => $this->input->post('barcodes'),
				// 'short_desc' => $this->input->post('short_desc'),
				// 'short_desc_old' => $this->input->post('short_desc_old'),
				// 'desc_old' => $this->input->post('desc_old'),
				// 'description' => $this->input->post('description'),
				// 'branch_id' => $this->input->post('branch_id'),
				// 'user'=>$user['id'],
				// 'inactive' => $this->input->post('inactive')
				
				'stock_id' => $id[0],
				'barcode' => $this->input->post('barcodes'),
				'short_desc' => $this->input->post('short_desc'),
				'description' => $this->input->post('description'),
				'uom' => $this->input->post('hidden_uomss'),
				'qty' => $this->input->post('qty'),
				'sales_type_id' => (int)$this->input->post('sales_type_id'),
				'inactive' => $this->input->post('inactive')
			);
			//echo var_dump($items);
			$barcode_exists = $this->inventory_model->barcode_exists_edit_mode($this->input->post('barcodes'),$id[0]);
			$barcode_exists_temp = $this->inventory_model->barcode_exists_edit_mode_temp($this->input->post('barcodes'),$id[0]);
		}

		if($barcode_exists){
			$id = '';
			$msg = "WARNING : Barcode [ ".$this->input->post('barcode')." ] already exists!".'->'.$this->input->post('barcodes');
			$status = "warning";
		}else if($barcode_exists_temp){
			$id = '';
				$msg = "WARNING : Barcode [ ".$this->input->post('barcode')." ] is for approval!".'->'.$this->input->post('barcodes');
			$status = "warning";
		}else{
			// echo var_dump($items);
			if ($barcode_mode == 'add') {
				$id = $this->inventory_model->write_stock_barcode_item($items);
				//echo $id.'------';
				//-----Pricing-----START
				$br_all_det = $this->inventory_model->get_active_branches();

					$sales_type_items = $this->inventory_model->get_sales_types($this->input->post('sales_type_id'));
					// foreach($sales_type_items as $sti_vals){

								foreach($br_all_det as $all_br_vals){

										$price_items = array(
											'barcode'=>$this->input->post('barcodes'),
											// 'sales_type_id'=>$sti_vals->id,
											'sales_type_id'=>(int)$this->input->post('sales_type_id'),
											// 'price'=>$this->input->post($all_br_vals->code.'_'.$sti_vals->sales_type.'_price'),
											'price'=>$this->input->post($all_br_vals->code.'_price'),
											'branch_id'=>$all_br_vals->id,
										);
										$id2 = $this->inventory_model->write_stock_barcode_price($price_items,$user['id']);
										// echo var_dump($price_items);

								}

					// }

				//-----Pricing-----END
				$msg = "Added New Stock Barcode : ".ucwords($this->input->post('description'));
				$status = "success";
				
			} else {
		///--------------------------********************-------------------------
				
				$id = $this->inventory_model->write_stock_barcode_item($items);
				//echo $id.'------';
				//-----Pricing-----START
				$br_all_det = $this->inventory_model->get_active_branches();

					$sales_type_items = $this->inventory_model->get_sales_types($this->input->post('sales_type_id'));
					// foreach($sales_type_items as $sti_vals){

								foreach($br_all_det as $all_br_vals){

										$price_items = array(
											'barcode'=>$this->input->post('barcodes'),
											// 'sales_type_id'=>$sti_vals->id,
											'sales_type_id'=>(int)$this->input->post('sales_type_id'),
											// 'price'=>$this->input->post($all_br_vals->code.'_'.$sti_vals->sales_type.'_price'),
											'price'=>$this->input->post($all_br_vals->code.'_price'),
											'branch_id'=>$all_br_vals->id,
										);
										$id2 = $this->inventory_model->write_stock_barcode_price($price_items,$user['id']);
										// echo var_dump($price_items);

								}

					// }
				
				//-----Pricing-----END
			//----------------------------********************-------------------------------
				//$msg = "Updated Stock Barcode : ".ucwords($this->input->post('description'));
				$msg = " Stock Barcode has been updated : ".ucwords($this->input->post('description'));
				$status = "success";
				//$status =  $res;
			}
		}
		echo json_encode(array('result'=>$status,'msg'=>$msg, 'stock_id'=>$this->input->post('stock_id'), 'barcode'=>$this->input->post('barcode')));
	}
	
	public function add_load_stock_barcodes(){
		$items = $barcode_prices = array();
		$ref = $this->input->post('ref');

		if (strcasecmp($ref,'new')) {
			$results = $this->inventory_model->get_stock_barcodes_temp($ref);
			if ($results) {
				$items = $results;
			}
		}
		$data['code'] = add_build_stock_barcodes_list($items, (!empty($ref) ? $ref : null));
		//-----TEMP SCRIPT
		$data['load_js'] = "core/inventory.php";
		$data['use_js'] = "addreloadBarcodeDetailsJs";
		//-----TEMP SCRIPT
		$this->load->view('load',$data);
	}
	
	
	
//--->end
	

	//-----STOCKS MASTER [MAIN]-----APM-----START
	public function stock_master($ref='')
	{
		$data = $this->syter->spawn('inventory');
		$user = $this->session->userdata('user');
		
		// echo var_dump($user);
		if($ref == 'new') {
			$this->add_stocks_container($ref,$data);	
			//$this->stocks_container($ref,$data);
		}
		else if(strpos(urldecode($ref),'|') !== false){
			$this->add_stocks_container($ref,$data);	
			//$this->stocks_container($ref,$data);
		}elseif($ref != 'new' && $ref != '' ){
			$this->stocks_container($ref,$data);	
		}else{
			if($user['role'] == 'Administrator')
				$results = $this->inventory_model->get_stocks();
			else if($user['role'] == 'Purchaser')
				$results = $this->inventory_model->get_purchaser_stocks($user['id']);
			else
				$results = $this->inventory_model->get_stocks();
			
			$data['page_subtitle'] = "Stock Maintenance";
			$data['code'] = build_stock_display($results);
		}
		$this->load->view('page',$data);
	}
	private function stocks_container($ref,&$data)
	{
		if (!strcasecmp($ref, 'new'))
			$data['page_subtitle'] = "New Stock Item";
		else
			$data['page_subtitle'] = "Edit Stock Item";

		$data['code'] = build_stock_container($ref);
		$data['load_js'] = "core/inventory.php";
		$data['use_js'] = "stockMasterJS";
	}
	public function stock_main_form($ref)
	{
		$items = array();
		$data['page_subtitle'] = "New Stock Item";
		// echo "Ref val : ".$ref."<br>";
		if (strcasecmp($ref,'new')) {
			// $results = $this->inventory_model->get_stocks(array('stock_id'=>$ref)); //for multiple columns in where clause
			$results = $this->inventory_model->get_stocks($ref);
			if ($results) {
				$items = $results[0];
				$data['page_subtitle'] = "Edit Stock Item";
			}
		}
		$data['code'] = build_stock_main_form($items);
		$data['load_js'] = "core/inventory.php";
		$data['use_js'] = "stockMasterFormJS";
		$this->load->view('load',$data);
	}
	public function get_uom_qty(){
		$qty='';
		$uom = $this->input->post('uom');
		$qty = $this->inventory_model->get_uom_qty($uom);
		echo $qty;
	}
	public function get_branch_code(){
		$branch_code='';
		$branch_id = $this->input->post('branch_id');
		$branch_code = $this->inventory_model->get_branch_code_from_id($branch_id);
		echo $branch_code;
	}

	public function get_branch_id_from_code(){
		$branch_id='';
		$branch_code = $this->input->post('branch_code');
		// $branch_id = $this->inventory_model->get_branch_code_from_id($branch_code);
		$branch_id = $this->inventory_model->get_branch_id_from_code($branch_code);
		echo $branch_id;
	}
	public function get_supp_name(){
		$supp_name='';
		$supp_id = $this->input->post('supp_id');
		$supp_name = $this->inventory_model->get_supp_name_from_id($supp_id);
		echo $supp_name;
	}
	public function get_supp_stock_uom(){
		$uom_val='';
		$uom = $this->input->post('uom');
		$uom_val = $this->inventory_model->get_uom_code($uom);
		echo $uom_val;
	}
	public function stock_db()
	{
		$audit_items = $disc_type_items = $card_type_items = $br_all_det = $cos_items = $bs_stock = array();
		$stock_code_exist = $status = $stock_disc_exists = $stock_crd_type_exists = "";
		# get user data
		$user = $this->session->userdata('user');
		$items = array(
			'description' =>ucfirst($this->input->post('description')),
			'stock_code' => strtoupper($this->input->post('stock_code')),
			'category_id' => $this->input->post('category_id'),
			'report_uom' => $this->input->post('report_uom'),
			'report_qty' => $this->input->post('report_qty'),
			'tax_type_id' => (int) $this->input->post('tax_type_id'),
			'mb_flag' => $this->input->post('mb_flag'),
			'is_consigned' => (int) $this->input->post('is_consigned'),
			'is_saleable' => (int) $this->input->post('is_saleable'),
			// 'standard_cost' => $this->input->post('standard_cost'),
			// 'last_cost' => $this->input->post('last_cost'),
			'sales_account' => (int) $this->input->post('sales_account'),
			'cogs_account' => (int) $this->input->post('cogs_account'),
			'inventory_account' => (int) $this->input->post('inventory_account'),
			'adjustment_account' => (int) $this->input->post('adjustment_account'),
			'assembly_cost_account' => (int) $this->input->post('assembly_cost_account'),
		);

		$mode = $this->input->post('mode');
		// echo "Mode : ".$mode."<br>";
		
		if($mode == 'add'){
			$stock_code_exist = $this->inventory_model->stock_code_exists_add_mode($this->input->post('stock_code'));
			$stock_code_exist_temp = $this->inventory_model->stock_code_exists_add_mode_temp($this->input->post('stock_code'));
		}else if($mode == 'edit'){
			$stock_code_exist = $this->inventory_model->stock_code_exists_edit_mode($this->input->post('stock_code'), $this->input->post('stock_id'));
			$stock_code_exist_temp = $this->inventory_model->stock_code_exists_edit_mode_temp($this->input->post('stock_code'), $this->input->post('stock_id'));
		}
		if($stock_code_exist){
			$id = '';
			$msg = "WARNING : Stock Code [ ".$this->input->post('stock_code')." ] already exists!";
			$status = "warning";
		}else if($stock_code_exist_temp){
			$id = '';
			$msg = "WARNING : Stock Code [ ".$this->input->post('stock_code')." ] is for approval!";
			$status = "warning";
		}else{
			// echo var_dump($items);
			if ($this->input->post('stock_id')) {
				// echo "Stock ID - update : ".$this->input->post('stock_id'); //-----uncomment for debugging purpose/s
				
				// // $this->inventory_model->update_stock_master_item($items,array('id'=>$this->input->post('stock_id'))); //multiple WHERE clause content
				$id = $this->input->post('stock_id');
				//$this->inventory_model->update_stock_master_item($items,$this->input->post('stock_id')); // MMS COMMENT THIS LINE FOR STOCK LOGS PURPOSES
				
				##########AUDIT TRAIL [START]##########
					//-----Audit trail for editing is under JS/jquery
				##########AUDIT TRAIL [END]##########
				
				//-----Discounts-----START
				$disc_type_items = $this->inventory_model->get_pos_discount_types();
				foreach($disc_type_items as $disc_vals){
					$stock_disc_exists = $this->inventory_model->validate_stock_discount($id, $disc_vals->id);
					if(!$stock_disc_exists){
						// echo "BRR7~~~<br>";
						$stock_disc_items = array(
							'stock_id'=>$id,
							'sales_type_id'=>1,
							'pos_discount_id'=>$disc_vals->id,
							'disc_enabled'=>$this->input->post($disc_vals->short_desc.'_disc'),
							'inactive'=>0,
						);
						$id2 = $this->inventory_model->write_stock_discount($stock_disc_items);
					}else{
						// echo "BRR2~~~<br>";
						$stock_disc_items = array(
							'stock_id'=>$id,
							'sales_type_id'=>1,
							'pos_discount_id'=>$disc_vals->id,
							'disc_enabled'=>$this->input->post($disc_vals->short_desc.'_disc'),
							'inactive'=>0,
						);
					//	$id2 = $this->inventory_model->update_stock_discount($stock_disc_items, $this->input->post('stock_id'), $disc_vals->id);// MMS COMMENT THIS LINE FOR STOCK LOGS PURPOSES
					}
				}
				//-----Discounts-----END
				
				//-----Allowed Cards-----START
				$card_type_items = $this->inventory_model->get_customer_card_types();
				foreach($card_type_items as $crd_vals){
					$stock_crd_type_exists = $this->inventory_model->validate_stock_card_type($id, $crd_vals->id);
					if(!$stock_crd_type_exists){
						// echo "BRR1~~~<br>";
						$stock_card_items = array(
							'stock_id'=>$id,
							'sales_type_id'=>1,
							'card_type_id'=>$crd_vals->id,
							'is_enabled'=>$this->input->post($crd_vals->name.'_crd'),
							'inactive'=>0,
						);
						$id3 = $this->inventory_model->write_stock_card_type($stock_card_items);
					}else{
						// echo "BRR2~~~<br>";
						$stock_card_items = array(
							'stock_id'=>$id,
							'sales_type_id'=>1,
							'card_type_id'=>$crd_vals->id,
							'is_enabled'=>$this->input->post($crd_vals->name.'_crd'),
							'inactive'=>0,
						);
						//$id3 = $this->inventory_model->update_stock_card_type($stock_card_items, $this->input->post('stock_id'), $crd_vals->id); // MMS COMMENT THIS LINE FOR STOCK LOGS PURPOSES
					}
				}
				//-----Allowed Cards-----END
				//-----Cost of Sales per branch-----START
				$br_all_det = $this->inventory_model->get_active_branches();
				foreach($br_all_det as $all_br_vals){
					$cos_items = array(
						'stock_id'=>$id,
						'branch_id'=>$all_br_vals->id,
						'cost_of_sales'=>$this->input->post($all_br_vals->code.'_cost_of_sales'),
					);
					$id4 = $this->inventory_model->update_stock_cost_of_sales($cos_items);
					
						
							// if($all_br_vals->has_sa == 1){
								// $bs_stock2 = array(
									// 'stock_id'=>$id,
									// 'branch_id'=>$all_br_vals->id,
									// 'qty'=>0,
									// 'cost_of_sales'=>$this->input->post($all_br_vals->code.'_cost_of_sales'),
									// 'stock_loc_id'=>1
									// );
								  // $this->inventory_model->write_branch_stocks_temp($bs_stock2);
							// }
							
							// elseif($all_br_vals->has_sr == 1){
								// $bs_stock3 = array(
									// 'stock_id'=>$id,
									// 'branch_id'=>$all_br_vals->id,
									// 'qty'=>0,
									// 'cost_of_sales'=>$this->input->post($all_br_vals->code.'_cost_of_sales'),
									// 'stock_loc_id'=>2
									// );
								 // $this->inventory_model->write_branch_stocks_temp($bs_stock3);
							// }
							
							// elseif($all_br_vals->has_bo  == 1){
								// $bs_stock5 = array(
									// 'stock_id'=>$id,
									// 'branch_id'=>$all_br_vals->id,
									// 'qty'=>0,
									// 'cost_of_sales'=>$this->input->post($all_br_vals->code.'_cost_of_sales'),
									// 'stock_loc_id'=>3
									// );
								 // $this->inventory_model->write_branch_stocks_temp($bs_stock5);
							// }
				}
				//-----Cost of Sales per branch-----END
				$msg = "Updated Stock : ".ucwords($this->input->post('description'));
				$status = "success";
			} else {
				// echo "Stock ID - add : ".$this->input->post('stock_id'); //-----uncomment for debugging purpose/s
				$id = $this->inventory_model->write_stock_master_item($items);
				
				##########AUDIT TRAIL [START]##########
				$audit_items = array(
				'type'=>0,
				'trans_no'=>0,
				'type_desc'=>ADD_STOCK,
				'description'=>'stock_id:'.$id.'||stock_code:"'.strtoupper($this->input->post('stock_code')).'"||description:"'.ucfirst($this->input->post('description')).'"',
				'user'=>$user['id']
				);
				
				$audit_id = $this->inventory_model->write_to_audit_trail($audit_items);
				##########AUDIT TRAIL [END]##########
				
				//-----Discounts-----START
				$disc_type_items = $this->inventory_model->get_pos_discount_types();
				foreach($disc_type_items as $disc_vals){
					$stock_disc_exists = $this->inventory_model->validate_stock_discount($id, $disc_vals->id);
					if(!$stock_disc_exists){
						// echo "BRR3~~~<br>";
						$stock_disc_items = array(
							'stock_id'=>$id,
							'sales_type_id'=>1,
							'pos_discount_id'=>$disc_vals->id,
							'disc_enabled'=>$this->input->post($disc_vals->short_desc.'_disc'),
							'inactive'=>0,
						);
						$id2 = $this->inventory_model->write_stock_discount($stock_disc_items);
					}
				}
				//-----Discounts-----END
				//-----Allowed Cards-----START
				$card_type_items = $this->inventory_model->get_customer_card_types();
				foreach($card_type_items as $crd_vals){
					$stock_crd_type_exists = $this->inventory_model->validate_stock_card_type($id, $crd_vals->id);
					if(!$stock_crd_type_exists){
						// echo "BRR1~~~<br>";
						$stock_card_items = array(
							'stock_id'=>$id,
							'sales_type_id'=>1,
							'card_type_id'=>$crd_vals->id,
							'is_enabled'=>$this->input->post($crd_vals->name.'_crd'),
							'inactive'=>0,
						);
						$id3 = $this->inventory_model->write_stock_card_type($stock_card_items);
					}else{
						// echo "BRR2~~~<br>";
						$stock_card_items = array(
							'stock_id'=>$id,
							'sales_type_id'=>1,
							'card_type_id'=>$crd_vals->id,
							'is_enabled'=>$this->input->post($crd_vals->name.'_crd'),
							'inactive'=>0,
						);
					//	$id3 = $this->inventory_model->update_stock_card_type($stock_card_items, $id, $crd_vals->id); // MMS COMMENT THIS LINE FOR STOCK LOGS PURPOSES
					}
				}
				//-----Allowed Cards-----END
				//-----Cost of Sales per branch-----START
				$br_all_det = $this->inventory_model->get_active_branches();
				foreach($br_all_det as $all_br_vals){
					$cos_items = array(
						'stock_id'=>$id,
						'branch_id'=>$all_br_vals->id,
						'cost_of_sales'=>$this->input->post($all_br_vals->code.'_cost_of_sales'),
					);
					$id4 = $this->inventory_model->write_stock_cost_of_sales($cos_items);
					
					
					if($all_br_vals->has_sa == 1){
						$bs_stock2 = array(
							'stock_id'=>$id,
							'branch_id'=>$all_br_vals->id,
							'qty'=>0,
						  //'cost_of_sales'=>$this->input->post($all_br_vals->code.'_cost_of_sales'),
							'stock_loc_id'=>1
							);
						 $this->inventory_model->write_branch_stocks_temp($bs_stock2);
				
					}
					if($all_br_vals->has_sr == 1){
						$bs_stock3 = array(
							'stock_id'=>$id,
							'branch_id'=>$all_br_vals->id,
							'qty'=>0,
						//	'cost_of_sales'=>$this->input->post($all_br_vals->code.'_cost_of_sales'),
							'stock_loc_id'=>2
							);
						 $this->inventory_model->write_branch_stocks_temp($bs_stock3);
						
					}
					
					if($all_br_vals->has_bo  == 1){
						$bs_stock4 = array(
							'stock_id'=>$id,
							'branch_id'=>$all_br_vals->id,
							'qty'=>0,
						//	'cost_of_sales'=>$this->input->post($all_br_vals->code.'_cost_of_sales'),
							'stock_loc_id'=>3
							);
					  $this->inventory_model->write_branch_stocks_temp($bs_stock4);
						
					}
					
		
				}
				//-----Cost of Sales per branch-----END
				$msg = "Added New Stock : ".ucwords($this->input->post('description'));
				$status = "success";
			}
		}
		echo json_encode(array('status'=>$status, 'id'=>$id,'msg'=>$msg));
		
	}
	//-----STOCKS MASTER [MAIN]-----APM-----END
	//-----STOCKS MASTER [BARCODE DETAILS]-----APM-----START
	public function stock_barcode_form($ref)
	{
		// echo 'haha';
		$items = $barcode_prices = array();
		// $data['page_subtitle'] = "New Inventory Item";
		if (strcasecmp($ref,'new')) {
			// $results = $this->inventory_model->get_items(array('a.id'=>$ref));
			$results = $this->inventory_model->get_stocks($ref);
			if ($results) {
				$items = $results[0];
				// $data['page_subtitle'] = "Edit Inventory Item";
			}
		}
		// $barcode_prices = $this->inventory_model->get_stock_barcode_prices($barcode=null);
		
		// echo var_dump($items);
		$data['code'] = build_stock_barcode_form($items, $ref, $barcode_prices);
		$data['load_js'] = "core/inventory.php";
		$data['use_js'] = "stockBarcodeFormJs";
		$this->load->view('load',$data);
	}
	#ORIGINAL SCRIPT - 07 07 2015 09 27 AM
	// public function stock_barcode_db()
	// {
		// $br_all_det = $br_det = $sales_type_items = $price_items = array();
		// $id2 = $br_res = $barcode_exists = $barcode_price_exists = "";
		// $user = $this->session->userdata('user');
		// $mode = $this->input->post('mode');
		// $barcode_mode = $this->input->post('barcode_mode');
		
		// if($mode == 'add'){
			// $items = array(
				// 'stock_id' => $this->input->post('stock_id'),
				// 'barcode' => $this->input->post('barcode'),
				// 'short_desc' => $this->input->post('short_desc'),
				// 'description' => $this->input->post('description'),
				// 'uom' => $this->input->post('uom'),
				// 'qty' => $this->input->post('qty'),
				// 'retail_price' => $this->input->post('retail_price'),
				// 'wholesale_price' => $this->input->post('wholesale_price'),
				// 'inactive' => $this->input->post('inactive'),
			// );
			// $barcode_exists = $this->inventory_model->barcode_exists_add_mode($this->input->post('barcode'));
			// $barcode_exists_temp = $this->inventory_model->barcode_exists_add_mode_temp($this->input->post('barcode'));
		// }else{
			
			// //-----NOTE: correct items to be updated. UOM should NOT BE EDITABLE, only the description of the stock barcode item.
			// $user = $this->session->userdata('user');
			// $items = array(
				// 'stock_id' => $this->input->post('stock_id'),
				// 'barcode' => $this->input->post('barcode'),
				// 'short_desc' => $this->input->post('short_desc'),
				// 'short_desc_old' => $this->input->post('short_desc_old'),
				// 'desc_old' => $this->input->post('desc_old'),
				// 'description' => $this->input->post('description'),
				// 'branch_id' => $this->input->post('branch_id'),
				// 'user'=>$user['id'],
				// 'inactive' => $this->input->post('inactive')
			// );
			
			// /*
			// $items = array(
				// 'uom' => $this->input->post('uom'),
				// 'qty' => $this->input->post('qty'),
				// 'description' => $this->input->post('description'),
				// 'inactive' => $this->input->post('inactive'),
			// );
			// */
			// $barcode_exists = $this->inventory_model->barcode_exists_edit_mode($this->input->post('barcode'), $this->input->post('stock_id'));
			// $barcode_exists_temp = $this->inventory_model->barcode_exists_edit_mode_temp($this->input->post('barcode'), $this->input->post('stock_id'));
		// }
		// // $barcode_exists = $this->inventory_model->validate_barcode($this->input->post('barcode'),  $this->input->post('mode'), (!empty($this->input->post('id')) ? $this->input->post('id') : ''));
		
		// // echo "Barcode exists : ".$barcode_exists." <=====> ".$mode."<br><br><br>";
		// if($barcode_exists){
			// $id = '';
			// $msg = "WARNING : Barcode [ ".$this->input->post('barcode')." ] already exists!";
			// $status = "warning";
		// }else if($barcode_exists_temp){
			// $id = '';
				// $msg = "WARNING : Barcode [ ".$this->input->post('barcode')." ] is for approval!";
			// $status = "warning";
		// }else{
			// // echo var_dump($items);
			// if ($barcode_mode == 'add') {
				// $id = $this->inventory_model->write_stock_barcode_item($items);
				// //echo $id.'------';
				// //-----Pricing-----START
				// $br_all_det = $this->inventory_model->get_active_branches();
				// // foreach($br_all_det as $all_br_vals){
					// $sales_type_items = $this->inventory_model->get_sales_types();
					// foreach($sales_type_items as $sti_vals){
						// // $barcode_price_exists = $this->inventory_model->validate_barcode_price($this->input->post('barcode'), $sti_vals->id);
							// // if(!$barcode_price_exists){
								// foreach($br_all_det as $all_br_vals){
									// // echo $all_br_vals->id."<~~~>".$this->input->post('branch_id')."<br>";
									// // if($all_br_vals->id == $this->input->post('branch_id')){
										// $price_items = array(
											// 'barcode'=>$this->input->post('barcode'),
											// 'sales_type_id'=>$sti_vals->id,
											// 'price'=>$this->input->post($all_br_vals->code.'_'.$sti_vals->sales_type.'_price'),
											// 'branch_id'=>$all_br_vals->id,
										// );
										// $id2 = $this->inventory_model->write_stock_barcode_price($price_items,$user['id']);
										// // echo var_dump($price_items);
									// // }
								// }
							// // }
					// }
				// // }
				
				// //-----Pricing-----END
				// $msg = "Added New Stock Barcode : ".ucwords($this->input->post('description'));
				// $status = "success";
				
			// } else {
		// ///--------------------------********************-------------------------
			// // $this->inventory_model->update_stock_barcode_item($items,array('id'=>$this->input->post('id'))); //multiple cols for checking
		  
		     // $res =  $this->inventory_model->write_stock_logs($items); //multiple cols for checking
		  
				// // $this->inventory_model->update_stock_barcode_item($items,$this->input->post('barcode'));
				
				// // //-----Pricing-----START
				// $br_all_det = $this->inventory_model->get_active_branches();
				// // foreach($br_all_det as $all_br_vals){
					// $sales_type_items = $this->inventory_model->get_sales_types();
					// foreach($sales_type_items as $sti_vals){
						// // $barcode_price_exists = $this->inventory_model->validate_barcode_price($this->input->post('barcode'), $sti_vals->id);
							// // if(!$barcode_price_exists){
								// foreach($br_all_det as $all_br_vals){
									// // echo $all_br_vals->id."<~~~>".$this->input->post('branch_id')."<br>";
									// // if($all_br_vals->id == $this->input->post('branch_id')){
										// $price_items = array(
											// 'barcode'=>$this->input->post('barcode'),
											// 'sales_type_id'=>$sti_vals->id,
											// 'price'=>$this->input->post($all_br_vals->code.'_'.$sti_vals->sales_type.'_price'),
											// 'branch_id'=>$all_br_vals->id,
										// );
							     	// //$id2 = $this->inventory_model->write_stock_barcode_price($price_items);
							     	// $id2 = $this->inventory_model->write_stock_prices_logs($price_items);
									// // echo var_dump($price_items);
									// // }
								// }
							// // }
					// }
				// // }
				
				// //-----Pricing-----END
			// //----------------------------********************-------------------------------
				// //$msg = "Updated Stock Barcode : ".ucwords($this->input->post('description'));
				// $msg = " Stock Barcode is for Approval : ".ucwords($this->input->post('description'));
				// $status = "success";
				// //$status =  $res;
			// }
		// }
		// echo json_encode(array('result'=>$status,'msg'=>$msg, 'stock_id'=>$this->input->post('stock_id'), 'barcode'=>$this->input->post('barcode')));
	// }
	public function stock_barcode_db()
	{
		$br_all_det = $br_det = $sales_type_items = $price_items = array();
		$id2 = $br_res = $barcode_exists = $barcode_price_exists = "";
		$user = $this->session->userdata('user');
		$mode = $this->input->post('mode');
		$barcode_mode = $this->input->post('barcode_mode');
		
		if($mode == 'add'){
			$items = array(
				'stock_id' => $this->input->post('stock_id'),
				'barcode' => $this->input->post('barcode'),
				'short_desc' => $this->input->post('short_desc'),
				'description' => $this->input->post('description'),
				'uom' => $this->input->post('uom'),
				'qty' => $this->input->post('qty'),
				'sales_type_id' => (int)$this->input->post('sales_type_id'),
				'inactive' => $this->input->post('inactive'),
			);
			$barcode_exists = $this->inventory_model->barcode_exists_add_mode($this->input->post('barcode'));
			$barcode_exists_temp = $this->inventory_model->barcode_exists_add_mode_temp($this->input->post('barcode'));
		}else{
			
			//-----NOTE: correct items to be updated. UOM should NOT BE EDITABLE, only the description of the stock barcode item.
			$user = $this->session->userdata('user');
			$items = array(
				'stock_id' => $this->input->post('stock_id'),
				'barcode' => $this->input->post('barcode'),
				'short_desc' => $this->input->post('short_desc'),
				'short_desc_old' => $this->input->post('short_desc_old'),
				'desc_old' => $this->input->post('desc_old'),
				'description' => $this->input->post('description'),
				'branch_id' => $this->input->post('branch_id'),
				'user'=>$user['id'],
				'inactive' => $this->input->post('inactive')
			);
			
			/*
			$items = array(
				'uom' => $this->input->post('uom'),
				'qty' => $this->input->post('qty'),
				'description' => $this->input->post('description'),
				'inactive' => $this->input->post('inactive'),
			);
			*/
			$barcode_exists = $this->inventory_model->barcode_exists_edit_mode($this->input->post('barcode'), $this->input->post('stock_id'));
			$barcode_exists_temp = $this->inventory_model->barcode_exists_edit_mode_temp($this->input->post('barcode'), $this->input->post('stock_id'));
		}
		// $barcode_exists = $this->inventory_model->validate_barcode($this->input->post('barcode'),  $this->input->post('mode'), (!empty($this->input->post('id')) ? $this->input->post('id') : ''));
		
		// echo "Barcode exists : ".$barcode_exists." <=====> ".$mode."<br><br><br>";
		if($barcode_exists){
			$id = '';
			$msg = "WARNING : Barcode [ ".$this->input->post('barcode')." ] already exists!";
			$status = "warning";
		}else if($barcode_exists_temp){
			$id = '';
				$msg = "WARNING : Barcode [ ".$this->input->post('barcode')." ] is for approval!";
			$status = "warning";
		}else{
			// echo var_dump($items);
			if ($barcode_mode == 'add') {
				$id = $this->inventory_model->write_stock_barcode_item($items);
				//echo $id.'------';
				//-----Pricing-----START
				$br_all_det = $this->inventory_model->get_active_branches();

					$sales_type_items = $this->inventory_model->get_sales_types($this->input->post('sales_type_id'));
					// foreach($sales_type_items as $sti_vals){

								foreach($br_all_det as $all_br_vals){

										$price_items = array(
											'barcode'=>$this->input->post('barcode'),
											// 'sales_type_id'=>$sti_vals->id,
											'sales_type_id'=>(int)$this->input->post('sales_type_id'),
											// 'price'=>$this->input->post($all_br_vals->code.'_'.$sti_vals->sales_type.'_price'),
											'price'=>$this->input->post($all_br_vals->code.'_price'),
											'branch_id'=>$all_br_vals->id,
										);
										$id2 = $this->inventory_model->write_stock_barcode_price($price_items,$user['id']);
										// echo var_dump($price_items);

								}

					// }

				//-----Pricing-----END
				$msg = "Added New Stock Barcode : ".ucwords($this->input->post('description'));
				$status = "success";
				
			} else {
		///--------------------------********************-------------------------
			// $this->inventory_model->update_stock_barcode_item($items,array('id'=>$this->input->post('id'))); //multiple cols for checking
		  
				//$res =  $this->inventory_model->write_stock_logs($items); //multiple cols for checking
		  
				// $this->inventory_model->update_stock_barcode_item($items,$this->input->post('barcode'));
				
				// //-----Pricing-----START
				$br_all_det = $this->inventory_model->get_active_branches();
				// foreach($br_all_det as $all_br_vals){
					$sales_type_items = $this->inventory_model->get_sales_types();
					foreach($sales_type_items as $sti_vals){

								foreach($br_all_det as $all_br_vals){
										$price_items = array(
											'barcode'=>$this->input->post('barcode'),
											'sales_type_id'=>$sti_vals->id,
											'price'=>$this->input->post($all_br_vals->code.'_'.$sti_vals->sales_type.'_price'),
											'branch_id'=>$all_br_vals->id,
										);
							     	//$id2 = $this->inventory_model->write_stock_barcode_price($price_items);
							     // 	$id2 = $this->inventory_model->write_stock_prices_logs($price_items);
	
								}
					}
				
				//-----Pricing-----END
			//----------------------------********************-------------------------------
				//$msg = "Updated Stock Barcode : ".ucwords($this->input->post('description'));
				$msg = " Stock Barcode is for Approval : ".ucwords($this->input->post('description'));
				$status = "success";
				//$status =  $res;
			}
		}
		echo json_encode(array('result'=>$status,'msg'=>$msg, 'stock_id'=>$this->input->post('stock_id'), 'barcode'=>$this->input->post('barcode')));
	}
	public function load_stock_barcodes(){
		$items = $barcode_prices = array();
		$ref = $this->input->post('ref');
		// echo "Ref : ".$ref."<br>";
		// $data['page_subtitle'] = "New Inventory Item";
		if (strcasecmp($ref,'new')) {
			$results = $this->inventory_model->get_stock_barcodes($ref);
			if ($results) {
				$items = $results;
				// $barcode_prices = $this->inventory_model->get_stock_barcode_prices($items[0]->barcode);
				// $data['page_subtitle'] = "Edit Inventory Item";
			}
		}
		// echo var_dump($items)."<~~<~~<br>";
		// $data['code'] = build_stock_barcodes_list($items, (!empty($ref) ? $ref : null), $barcode_prices );
		$data['code'] = build_stock_barcodes_list($items, (!empty($ref) ? $ref : null));
		//-----TEMP SCRIPT
		$data['load_js'] = "core/inventory.php";
		$data['use_js'] = "reloadBarcodeDetailsJs";
		//-----TEMP SCRIPT
		$this->load->view('load',$data);
	}
	public function load_stock_barcode_prices(){
		$barcode = $this->input->post('barcode');
		$data['code'] = build_stock_barcode_price_list(!empty($barcode) ? $barcode : null);
		//-----TEMP SCRIPT
		$data['load_js'] = "core/inventory.php";
		$data['use_js'] = "reloadBarcodePriceDetailsJs";
		//-----TEMP SCRIPT
		$this->load->view('load',$data);
	}
	public function view_stock_barcode_details_pop($trx_id=null, $barcode=null){
		$this->load->model('core/inventory_model');
		$this->load->helper('core/inventory_helper');

		if ($trx_id != null) {
			$details = $this->inventory_model->get_stock_barcode_details($trx_id);
			$header = $details[0];
		}

		$data = $this->syter->spawn('inventory');
		$data['page_title'] = "Stock Barcode Details";

		$data['code'] = viewStockBarcodeDetailsPopForm($details,$header);
		$data['add_css'] = 'js/plugins/typeaheadmap/typeaheadmap.css';
		$data['add_js'] = array('js/plugins/typeaheadmap/typeaheadmap.js');
		$this->load->view('load',$data);
	}
	//-----STOCKS MASTER [BARCODE DETAILS]-----APM-----END
	//-----STOCKS MASTER [SUPPLIER DETAILS]-----APM-----START
	public function supplier_stock_form($ref)
	{
		$items = $barcode_prices = array();
		// $data['page_subtitle'] = "New Inventory Item";
		if (strcasecmp($ref,'new')) {
			// $results = $this->inventory_model->get_items(array('a.id'=>$ref));
			$results = $this->inventory_model->get_all_supplier_stocks($ref);
			if ($results) {
				$items = $results[0];
				// $data['page_subtitle'] = "Edit Inventory Item";
			}
		}
		// echo $this->inventory_model->db->last_query();
		// echo var_dump($items);
		$data['code'] = build_supplier_stock_form($items, $ref, $barcode_prices);
		$data['load_js'] = "core/inventory.php";
		$data['use_js'] = "supplierStockFormJs";
		$this->load->view('load',$data);
	}
	public function supplier_stock_db()
	{
		$items = $br_all_det = $all_data = array();
		$id2  = $saving_type = $supp_mode = $mode_stat = $status = $msg = "";
		$saving_type = $this->input->post('saving_type');
		
		$supp_mode = $this->input->post('supp_mode');
		$disc_type1 = $this->input->post('disc_type1');
		$disc_type2 = $this->input->post('disc_type2');
		$disc_type3 = $this->input->post('disc_type3');
		$default = (int)$this->input->post('is_default');
		$user = $this->session->userdata('user');
		if($saving_type == 'single'){
			// echo "ONE BRANCH BTN<br>";
			if($supp_mode == 'add'){
				
				$items = array(
				'stock_id'=>$this->input->post('hidden_stock_id'),
				'supp_stock_code'=>$this->input->post('supp_stock_code'),
				'description'=>$this->input->post('description'),
				'supp_id'=>(int)$this->input->post('supp_id'),
				'branch_id'=>$this->input->post('hidden_branch_id'),
				// 'branch_id'=>$this->input->post('branch_id'),
				'uom'=>$this->input->post('uom'),
				'unit_cost'=>$this->input->post('unit_cost'),
				'qty'=>$this->input->post('qty'),
				'disc_percent1' => ($disc_type1 == 'percent' ? $this->input->post('discount1') : 0),
				'disc_percent2' => ($disc_type2 == 'percent' ? $this->input->post('discount2') : 0),
				'disc_percent3' => ($disc_type3 == 'percent' ? $this->input->post('discount3') : 0),
				'disc_amount1' => ($disc_type1 == 'amount' ? $this->input->post('discount1') : 0),
				'disc_amount2' => ($disc_type2 == 'amount' ? $this->input->post('discount2') : 0),
				'disc_amount3' => ($disc_type3 == 'amount' ? $this->input->post('discount3') : 0),
				'avg_cost'=>$this->input->post('avg_cost'),
				'net_cost'=>$this->input->post('net_cost'),
				'avg_net_cost'=>$this->input->post('avg_net_cost'),
				'is_default'=>(int)$this->input->post('is_default'),
				'inactive'=>(int)$this->input->post('inactive'),
				'added_by'=>$user['id'],
				'datetime_added'=>date('Y-m-d H:i:s')
				);
				// echo var_dump($items);
				$id = $this->inventory_model->write_supplier_stock_item($items);
				$msg = "Added New Supplier Stock : ".ucwords($this->input->post('supp_stock_code'));
				$status = "success";
				$form_mode = "add";
			}else{
				$items = array(
				'stock_id'=>$this->input->post('hidden_stock_id'),
				'supp_stock_code'=>$this->input->post('supp_stock_code'),
				'description'=>$this->input->post('description'),
				'supp_id'=>$this->input->post('hidden_supplier_id'),
				'branch_id'=>$this->input->post('hidden_branch_id'),
				'uom'=>$this->input->post('hidden_stock_uom'),
				'unit_cost'=>$this->input->post('unit_cost'),
				'qty'=>$this->input->post('qty'),
				'disc_percent1' => ($disc_type1 == 'percent' ? $this->input->post('discount1') : 0),
				'disc_percent2' => ($disc_type2 == 'percent' ? $this->input->post('discount2') : 0),
				'disc_percent3' => ($disc_type3 == 'percent' ? $this->input->post('discount3') : 0),
				'disc_amount1' => ($disc_type1 == 'amount' ? $this->input->post('discount1') : 0),
				'disc_amount2' => ($disc_type2 == 'amount' ? $this->input->post('discount2') : 0),
				'disc_amount3' => ($disc_type3 == 'amount' ? $this->input->post('discount3') : 0),
				'avg_cost'=>$this->input->post('avg_cost'),
				'net_cost'=>$this->input->post('net_cost'),
				'avg_net_cost'=>$this->input->post('avg_net_cost'),
				'is_default'=>(int)$this->input->post('is_default'),
				'inactive'=>(int)$this->input->post('inactive'),
				'added_by'=>$user['id'],
				'datetime_added'=>date('Y-m-d H:i:s')
				);
				// echo var_dump($items);
			//	$this->inventory_model->update_supplier_stock_item($items,$this->input->post('hidden_supplier_stock_id'));
				$msg = "Updated Supplier Stock : ".ucwords($this->input->post('supp_stock_code'));
				$status = "success";
				$form_mode = "edit";
			}
			echo json_encode(array('result'=>$status,'mode_stat'=>$mode_stat, 'msg'=>$msg, 'stock_id'=>$this->input->post('hidden_stock_id'), 'supp_stock_code'=>$this->input->post('supp_stock_code'), 'branch'=>$this->input->post('hidden_branch_id'), 'form_mode'=>$form_mode));
		}else{
			//----------ALL
			// echo "ALL BRANCHES BTN<br>";
			$disc_type1 = $this->input->post('disc_type1');
			$disc_type2 = $this->input->post('disc_type2');
			$disc_type3 = $this->input->post('disc_type3');
			$default = (int)$this->input->post('is_default');
			
			// echo $disc_type1."---".$disc_type2."~~~".$disc_type3."===<br>";
			
			$br_all_det = $this->inventory_model->get_active_branches();
			foreach($br_all_det as $all_br_vals){
				if($supp_mode == 'add'){
					$all_data = array(
					'stock_id'=>$this->input->post('hidden_stock_id'),
					'supp_stock_code'=>$this->input->post('supp_stock_code'),
					'description'=>$this->input->post('description'),
					'supp_id'=>(int)$this->input->post('supp_id'),
					'branch_id'=>$all_br_vals->id,
					// 'branch_id'=>$this->input->post('branch_id'),
					'uom'=>$this->input->post('uom'),
					'unit_cost'=>$this->input->post('unit_cost'),
					'qty'=>$this->input->post('qty'),
					'disc_percent1' => ($disc_type1 == 'percent' ? ($this->input->post('discount1')+0) : 0),
					'disc_percent2' => ($disc_type2 == 'percent' ? ($this->input->post('discount2')+0) : 0),
					'disc_percent3' => ($disc_type3 == 'percent' ? ($this->input->post('discount3')+0) : 0),
					'disc_amount1' => ($disc_type1 == 'amount' ? ($this->input->post('discount1')+0) : 0),
					'disc_amount2' => ($disc_type2 == 'amount' ? ($this->input->post('discount2')+0) : 0),
					'disc_amount3' => ($disc_type3 == 'amount' ? ($this->input->post('discount3')+0) : 0),
					'avg_cost'=>$this->input->post('avg_cost'),
					'net_cost'=>$this->input->post('net_cost'),
					'avg_net_cost'=>$this->input->post('avg_net_cost'),
					'is_default'=>$default,
					'inactive'=>(int)$this->input->post('inactive'),
					'added_by'=>$user['id'],
					'datetime_added'=>date('Y-m-d H:i:s')
					);
					// echo var_dump($all_data);
					// $id = $this->inventory_model->write_supplier_stock_item($items);
					$id2 = $this->inventory_model->write_supplier_stock_item_all_branches($all_data);
					$msg = "Added New Supplier Stock : ".ucwords($this->input->post('supp_stock_code'));
					//$msg =  $id2;
					$status = "success";
					$form_mode = "add";
				}else{
					$all_data = array(
					'stock_id'=>$this->input->post('hidden_stock_id'),
					'supp_stock_code'=>$this->input->post('supp_stock_code'),
					'description'=>$this->input->post('description'),
					'supp_id'=>$this->input->post('hidden_supplier_id'),
					// 'branch_id'=>$this->input->post('hidden_branch_id'),
					'branch_id'=>$all_br_vals->id,
					'uom'=>$this->input->post('hidden_stock_uom'),
					'unit_cost'=>$this->input->post('unit_cost'),
					'qty'=>$this->input->post('qty'),
					'disc_percent1' => ($disc_type1 == 'percent' ? ($this->input->post('discount1')+0) : 0),
					'disc_percent2' => ($disc_type2 == 'percent' ? ($this->input->post('discount2')+0) : 0),
					'disc_percent3' => ($disc_type3 == 'percent' ? ($this->input->post('discount3')+0) : 0),
					'disc_amount1' => ($disc_type1 == 'amount' ? ($this->input->post('discount1')+0) : 0),
					'disc_amount2' => ($disc_type2 == 'amount' ? ($this->input->post('discount2')+0) : 0),
					'disc_amount3' => ($disc_type3 == 'amount' ? ($this->input->post('discount3')+0) : 0),
					'avg_cost'=>$this->input->post('avg_cost'),
					'net_cost'=>$this->input->post('net_cost'),
					'avg_net_cost'=>$this->input->post('avg_net_cost'),
					'is_default'=>$default,
					'inactive'=>(int)$this->input->post('inactive'),
					'added_by'=>$user['id'],
					'datetime_added'=>date('Y-m-d H:i:s')
					);
					// echo var_dump($all_data);
					// $this->inventory_model->update_supplier_stock_item($items,$this->input->post('hidden_supplier_stock_id'));
			//		$id2 = $this->inventory_model->write_supplier_stock_item_all_branches($all_data);
					$msg = "Updated Supplier Stock : ".ucwords($this->input->post('supp_stock_code'));
					
					$status = "success";
					$form_mode = "edit";
				}
				
			}
			//----------ALL
			echo json_encode(array('result'=>$status,'mode_stat'=>$mode_stat, 'msg'=>$msg, 'stock_id'=>$this->input->post('hidden_stock_id'), 'supp_stock_code'=>$this->input->post('supp_stock_code'), 'branch'=>'all', 'form_mode'=>$form_mode));
		}
			
		
	}
	// public function supplier_stock_db()
	// {
		// $br_all_det = $br_det = $sales_type_items = $price_items = array();
		// $brag = $su_id = $br_id = $id2 = $br_res = $supp_stock_code_exists = $barcode_price_exists = "";

		// $mode = $this->input->post('mode');
		
		// if($mode == 'add'){
			// //-----ADD
			// $brag = $this->input->post('supp_id');
		// }else{
			// //----EDIT
			// $brag = $this->input->post('hidden_supplier_id');
		// }
		// echo "BRAG : ".$brag."<br>";
		// echo "UOMO : ".$this->input->post('uom')."<br>";
		
		// $supp_stock_id = $this->input->post('hidden_supp_stock_id');
		// $br_id = $this->inventory_model->get_branch_id_from_code($this->input->post('branch_id'));
		// $su_id = $this->inventory_model->get_supp_id_from_name($this->input->post('supp_id'));
		// $supp_stock_mode = $this->input->post('supp_stock_mode');
		
		// $disc_type1 = $this->input->post('disc_type1');
		// $disc_type2 = $this->input->post('disc_type2');
		// $disc_type3 = $this->input->post('disc_type3');
		
		// // echo "Supp Stock Code: ".$this->input->post('supp_stock_code')." UOM: ".$this->input->post('uom')." &&& ID: ".$this->input->post('hidden_supp_stock_id')." <hr><br>";
		// // echo $disc_type1."---".$disc_type2."---".$disc_type3."<br>";
		
		// if($mode == 'add'){
			// $items = array(
				// 'stock_id' => $this->input->post('hidden_stock_id'),
				// 'supp_stock_code' => $this->input->post('supp_stock_code'),
				// 'description' => $this->input->post('description'),
				// // 'supp_id' => $su_id,
				// 'supp_id' => $brag,
				// 'branch_id' => $br_id,
				// 'uom' => $this->input->post('uom'),
				// 'unit_cost' => $this->input->post('unit_cost'),
				// 'disc_percent1' => ($disc_type1 == 'percent' ? $this->input->post('discount1') : 0),
				// 'disc_percent2' => ($disc_type2 == 'percent' ? $this->input->post('discount2') : 0),
				// 'disc_percent3' => ($disc_type3 == 'percent' ? $this->input->post('discount3') : 0),
				// 'disc_amount1' => ($disc_type1 == 'amount' ? $this->input->post('discount1') : 0),
				// 'disc_amount2' => ($disc_type2 == 'amount' ? $this->input->post('discount2') : 0),
				// 'disc_amount3' => ($disc_type3 == 'amount' ? $this->input->post('discount3') : 0),
				// 'avg_cost' => $this->input->post('avg_cost'),
				// 'net_cost' => $this->input->post('net_cost'),
				// 'avg_net_cost' => $this->input->post('avg_net_cost'),
				// 'inactive' => (int)$this->input->post('inactive'),
			// );
			// $supp_stock_code_exists = $this->inventory_model->supp_stock_exists_add_mode($this->input->post('supp_stock_code'), $this->input->post('uom'));
		// }else{
			// // $items = array(
				// // 'description' => $this->input->post('description'),
				// // 'inactive' => (int)$this->input->post('inactive'),
			// // );
			// $items = array(
				// 'stock_id' => $this->input->post('hidden_stock_id'),
				// 'supp_stock_code' => $this->input->post('supp_stock_code'),
				// 'description' => $this->input->post('description'),
				// // 'supp_id' => $su_id,
				// 'supp_id' => $brag,
				// 'branch_id' => $br_id,
				// 'uom' => $this->input->post('uom'),
				// 'unit_cost' => $this->input->post('unit_cost'),
				// 'disc_percent1' => ($disc_type1 == 'percent' ? $this->input->post('discount1') : 0),
				// 'disc_percent2' => ($disc_type2 == 'percent' ? $this->input->post('discount2') : 0),
				// 'disc_percent3' => ($disc_type3 == 'percent' ? $this->input->post('discount3') : 0),
				// 'disc_amount1' => ($disc_type1 == 'amount' ? $this->input->post('discount1') : 0),
				// 'disc_amount2' => ($disc_type2 == 'amount' ? $this->input->post('discount2') : 0),
				// 'disc_amount3' => ($disc_type3 == 'amount' ? $this->input->post('discount3') : 0),
				// 'avg_cost' => $this->input->post('avg_cost'),
				// 'net_cost' => $this->input->post('net_cost'),
				// 'avg_net_cost' => $this->input->post('avg_net_cost'),
				// 'inactive' => (int)$this->input->post('inactive'),
			// );
			// $supp_stock_code_exists = $this->inventory_model->supp_stock_exists_edit_mode($this->input->post('supp_stock_code'), $this->input->post('uom'), $supp_stock_id);
		// }
		// echo var_dump($items);
		// // echo var_dump($this->input->post)."~~";
		// // // echo "Barcode exists : ".$barcode_exists." <=====> ".$mode."<br><br><br>";
		// if($supp_stock_code_exists){
			// $id = '';
			// $msg = "WARNING : Supplier Stock Code [ ".$this->input->post('supp_stock_code')." ] and UOM already exists!";
			// $status = "warning";
		// }else{
			// // if ($barcode_mode == 'add') { //-----orig
			// if ($mode == 'add') {
				// $id = $this->inventory_model->write_supplier_stock_item($items);
				// $msg = "Added New Supplier Stock : ".ucwords($this->input->post('supp_stock_code'));
				// $status = "success";
				
			// } else {
				// $this->inventory_model->update_supplier_stock_item($items,$supp_stock_id);
				
				// //-----Pricing-----START
				// $br_all_det = $this->inventory_model->get_active_branches();
					// $sales_type_items = $this->inventory_model->get_sales_types();
					// foreach($sales_type_items as $sti_vals){

						// foreach($br_all_det as $all_br_vals){

								// $price_items = array(
									// 'barcode'=>$this->input->post('barcode'),
									// 'sales_type_id'=>$sti_vals->id,
									// 'price'=>$this->input->post($all_br_vals->code.'_'.$sti_vals->sales_type.'_price'),
									// 'branch_id'=>$all_br_vals->id,
								// );
								// $id2 = $this->inventory_model->write_stock_barcode_price($price_items);
								// // echo var_dump($price_items);

						// }

					// }

				
				// //-----Pricing-----END
				
				// $msg = "Updated Supplier Stock : ".ucwords($this->input->post('supp_stock_code'));
				// $status = "success";
			// // }
			// }
		// }
		// echo json_encode(array('result'=>$status,'msg'=>$msg));
	// }
	/*
	public function load_supplier_stocks(){
		$items = $barcode_prices = array();
		$ref = $this->input->post('ref');
		
		// echo "Ref: $ref <br>";
		if (strcasecmp($ref,'new')) {
			// $results = $this->inventory_model->get_items(array('a.id'=>$ref));
			$results = $this->inventory_model->get_supplier_stocks($ref);
			if ($results) {
				$items = $results;
				// $barcode_prices = $this->inventory_model->get_stock_barcode_prices($items[0]->barcode);
				// $data['page_subtitle'] = "Edit Inventory Item";
			}
		}
		// echo var_dump($items)." <~~ <br>";
		// $data['code'] = build_stock_barcodes_list($items, (!empty($ref) ? $ref : null), $barcode_prices );
		$data['code'] = build_supplier_stocks_list($items, (!empty($ref) ? $ref : null));
		//-----TEMP SCRIPT
		$data['load_js'] = "core/inventory.php";
		$data['use_js'] = "reloadSupplierStockDetailsJs";
		//-----TEMP SCRIPT
		$this->load->view('load',$data);
	}
	*/
	public function load_supplier_stocks($supp_stock_id=null){
		$items = $barcode_prices = array();
		$ref = $this->input->post('ref');
		
		// echo "Ref: $ref <br>";
		if (strcasecmp($ref,'new')) {
			// if($supp_stock_id != '' || $supp_stock_id != 0)
				// $results = $this->inventory_model->get_supplier_stocks_detail($ref, $supp_stock_id);
			// }else{
				// $results = $this->inventory_model->get_supplier_stocks($ref);
			// }
				$results = $this->inventory_model->get_supplier_stocks($ref);
			if ($results) {
				$items = $results;
				// $barcode_prices = $this->inventory_model->get_stock_barcode_prices($items[0]->barcode);
				// $data['page_subtitle'] = "Edit Inventory Item";
			}
		}
		// echo var_dump($items)." <~~ <br>";
		// $data['code'] = build_stock_barcodes_list($items, (!empty($ref) ? $ref : null), $barcode_prices );
		$data['code'] = build_supplier_stocks_list($items, (!empty($ref) ? $ref : null));
		//-----TEMP SCRIPT
		$data['load_js'] = "core/inventory.php";
		$data['use_js'] = "reloadSupplierStockDetailsJs";
		//-----TEMP SCRIPT
		$this->load->view('load',$data);
	}
	public function load_srp_popup($barcode=null, $sales_type_id=null, $uom=null, $qty=null, $stock_id=null, $branch_id=null, $price=0, $hidden_avg_net_cost=null, $hidden_cost_of_sales=null, $pk_id=null){
		$srp_det = array(
		'barcode'=>$barcode,
		'sales_type_id'=>$sales_type_id,
		'uom'=>$uom,
		'qty'=>$qty,
		'stock_id'=>$stock_id,
		'price'=>$price,
		'hidden_avg_net_cost'=>$hidden_avg_net_cost,
		'hidden_cost_of_sales'=>$hidden_cost_of_sales,
		'pk_id'=>$pk_id,
		);
		
		// $data['code'] = srp_popup_form($uom, $qty, $stock_id, $branch_id, $price, $hidden_avg_net_cost, $hidden_cost_of_sales, $pk_id); //-----ORIGINAL
		$data['code'] = srp_popup_form($branch_id, $srp_det);

        $data['add_js'] = 'js/site_list_forms.js';
        $data['load_js'] = "core/inventory.php";
        $data['use_js'] = "srpPopJS";
        $this->load->view('load',$data);
    }
	/////rhan marginal
	public function load_marginal_markdown_popup($branch_id=null, $stock_id=null, $barcode=null, $sales_type_id=null, $price=null,$latest_landed_cost=null){
		
	 $sb_det = array(
		'stock_id'=>$stock_id,
		'barcode'=>$barcode,
		'sales_type_id'=>$sales_type_id,
		//'price'=>$price,
		);
		
		$data['code'] = marginal_markdown_popup_form($latest_landed_cost,$sb_det,$branch_id);

		$data['add_js'] = 'js/site_list_forms.js';
		$data['load_js'] = "core/inventory.php";
		$data['use_js'] = "marginalMarkdownPopJS";
		// echo var_dump($data);
		$this->load->view('load',$data);
    }
	//rhan end 
	
	public function load_sched_markdown_popup($branch_id=null, $stock_id=null, $barcode=null, $sales_type_id=null, $price=null){
		// $sb_det = array();
		// echo $stock_id."~~".$barcode."~~".$price."<br>";
		
		$sb_det = array(
		'stock_id'=>$stock_id,
		'barcode'=>$barcode,
		'sales_type_id'=>$sales_type_id,
		'price'=>$price,
		);
		
		$data['code'] = sched_markdown_popup_form($branch_id, $sb_det);

		$data['add_js'] = 'js/site_list_forms.js';
		$data['load_js'] = "core/inventory.php";
		$data['use_js'] = "schedMarkdownPopJS";
		// echo var_dump($data);
		$this->load->view('load',$data);
    }
	/*
	public function single_sched_markdown_db()
	{
		$msg = "Updates Scheduled Markdown for ONE branch only.-->".$this->input->post('test_var');
		$items = array();
		// echo json_encode(array('result'=>$status,'mode_stat'=>$mode_stat, 'msg'=>$msg));
		echo json_encode(array('result'=>'success', 'msg'=>$msg));
		
	}
	public function all_sched_markdown_db()
	{
		$msg = "Update Scheduled Markdown for ALL BRANCHES.-->".$this->input->post('test_var');
		echo json_encode(array('result'=>'success', 'msg'=>$msg));
	}
	*/
	public function marginal_markdown_db()
	{
		$saving_type = $this->input->post('saving_type');
		$branch_id	= $this->input->post('hidden_marginal_branch_id');
		$all_branch = $marginal1 = $marginal2 = $marginal3 = $marginal_det = array();
		$user = $this->session->userdata('user');
		if($saving_type == 'all'){
			$all_branch = $this->inventory_model->get_active_branches();
									  
			foreach($all_branch as $all_br_vals){
				
				if($this->input->post('unit_price1') != '') {
					
					$marginal1 = array(
								'stock_id'=>$this->input->post('hidden_marginal_stock_id'),
								'sales_type_id'=>$this->input->post('hidden_marginal_sales_type_id'),
								'barcode'=>$this->input->post('hidden_marginal_barcode'),
								'branch_id'=>$all_br_vals->id,
								'qty'=>$this->input->post('qty1'),
								'markup'=>$this->input->post('markup1'),
								'unit_price'=>$this->input->post('unit_price1'),
								'datetime_added'=>date("Y-m-d H:i:s"),
								'modified_by'=>$user['id']
									  );
								 $this->inventory_model->write_marginal($marginal1);
				}
						
				if($this->input->post('unit_price2') != ''){
						$marginal2  = array(
									'stock_id'=>$this->input->post('hidden_marginal_stock_id'),
									'sales_type_id'=>$this->input->post('hidden_marginal_sales_type_id'),
									'barcode'=>$this->input->post('hidden_marginal_barcode'),
									'branch_id'=>$all_br_vals->id,
									'qty'=>$this->input->post('qty2'),
									'markup'=>$this->input->post('markup2'),
									'unit_price'=>$this->input->post('unit_price2'),
									'datetime_added'=>date("Y-m-d H:i:s"),
									'modified_by'=>$user['id']
									);
									$this->inventory_model->write_marginal($marginal2);
				}
									
				if($this->input->post('unit_price3') != ''){
						$marginal3  = array(
										'stock_id'=>$this->input->post('hidden_marginal_stock_id'),
										'sales_type_id'=>$this->input->post('hidden_marginal_sales_type_id'),
										'barcode'=>$this->input->post('hidden_marginal_barcode'),
										'branch_id'=>$all_br_vals->id,
										'qty'=>$this->input->post('qty3'),
										'markup'=>$this->input->post('markup3'),
										'unit_price'=>$this->input->post('unit_price3'),
										'datetime_added'=>date("Y-m-d H:i:s"),
										'modified_by'=>$user['id']
										);
									 $this->inventory_model->write_marginal($marginal3);
				}	
								
						
			}
		
			echo json_encode(array('result'=>'success', 'msg'=>'ff'));
		}else{
			
			if($this->input->post('unit_price1') != ''){
				$marginal1 = array(
						'stock_id'=>$this->input->post('hidden_marginal_stock_id'),
						'sales_type_id'=>$this->input->post('hidden_marginal_sales_type_id'),
						'barcode'=>$this->input->post('hidden_marginal_barcode'),
						'branch_id'=>$branch_id,
						'qty'=>$this->input->post('qty1'),
						'markup'=>$this->input->post('markup1'),
						'unit_price'=>$this->input->post('unit_price1'),
						'datetime_added'=>date("Y-m-d H:i:s"),
						'modified_by'=>$user['id']
							  );
						$res = $this->inventory_model->write_marginal($marginal1);
			}
			if($this->input->post('unit_price2') != ''){
					$marginal2  = array(
								'stock_id'=>$this->input->post('hidden_marginal_stock_id'),
								'sales_type_id'=>$this->input->post('hidden_marginal_sales_type_id'),
								'barcode'=>$this->input->post('hidden_marginal_barcode'),
								'branch_id'=>$branch_id,
								'qty'=>$this->input->post('qty2'),
								'markup'=>$this->input->post('markup2'),
								'unit_price'=>$this->input->post('unit_price2'),
								'datetime_added'=>date("Y-m-d H:i:s"),
								'modified_by'=>$user['id']
								);
								$this->inventory_model->write_marginal($marginal2);	
			}
			
			if($this->input->post('unit_price3') != ''){
					$marginal3  = array(
								'stock_id'=>$this->input->post('hidden_marginal_stock_id'),
								'sales_type_id'=>$this->input->post('hidden_marginal_sales_type_id'),
								'barcode'=>$this->input->post('hidden_marginal_barcode'),
								'branch_id'=>$branch_id,
								'qty'=>$this->input->post('qty3'),
								'markup'=>$this->input->post('markup3'),
								'unit_price'=>$this->input->post('unit_price3'),
								'datetime_added'=>date("Y-m-d H:i:s"),
								'modified_by'=>$user['id']
								);
								$this->inventory_model->write_marginal($marginal3);	
			}				
			echo json_encode(array('result'=>'success', 'msg'=>'ff'));
		}
		
	}
	public function sched_markdown_db()
	{
		$br_all_det = $items = $audit_items = array();
		$user = $this->session->userdata('user');
		if($this->input->post('saving_type') == 'all'){
			$br_all_det = $this->inventory_model->get_active_branches();
			foreach($br_all_det as $all_br_vals){
				$items = array(
				'stock_id'=>$this->input->post('hidden_stock_id'),
				'barcode'=>$this->input->post('hidden_barcode'),
				'branch_id'=>$all_br_vals->id,
				'sales_type_id'=>$this->input->post('hidden_sales_type_id'),
				'start_date'=>date('Y-m-d', strtotime($this->input->post('start_date'))),
				'end_date'=>date('Y-m-d', strtotime($this->input->post('end_date'))),
				'start_time'=>date('H:i:s', strtotime($this->input->post('start_time'))),
				'end_time'=>date('H:i:s', strtotime($this->input->post('end_time'))),
				'markdown'=>$this->input->post('markdown'),
				'original_price'=>$this->input->post('hidden_original_price'),
				'discounted_price'=>$this->input->post('discounted_price'),
				'datetime_added'=>date("Y-m-d H:i:s"),
				'added_by'=>$user['id'],
				'inactive'=>(int)$this->input->post('inactive'),
				);
			
				$id = $this->inventory_model->write_sched_stock_barcode_markdown_all_branches($items);
				
				$audit_items = array(
				'type'=>0,
				'trans_no'=>0,
				'type_desc'=>ADD_ALL_STOCK_MARKDOWN,
				'description'=>'pk_id:'.$id.'||stock_id:'.$this->input->post('hidden_stock_id').'||barcode:"'.$this->input->post('hidden_barcode').'"||branch_id:"'.$all_br_vals->id.'"',
				'user'=>$user['id']
				);
				
				$audit_id = $this->inventory_model->write_to_audit_trail($audit_items);
			
			}
			
			$msg = "Update Scheduled Markdown for ALL BRANCHES.-->".$this->input->post('saving_type');
			$status = "success";
		}else{
			$items = array(
			'stock_id'=>$this->input->post('hidden_stock_id'),
			'barcode'=>$this->input->post('hidden_barcode'),
			'branch_id'=>$this->input->post('cc_hidden_branch_id'),
			'sales_type_id'=>$this->input->post('hidden_sales_type_id'),
			'start_date'=>date('Y-m-d', strtotime($this->input->post('start_date'))),
			'end_date'=>date('Y-m-d', strtotime($this->input->post('end_date'))),
			'start_time'=>date('H:i:s', strtotime($this->input->post('start_time'))),
			'end_time'=>date('H:i:s', strtotime($this->input->post('end_time'))),
			'markdown'=>$this->input->post('markdown'),
			'original_price'=>$this->input->post('hidden_original_price'),
			'discounted_price'=>$this->input->post('discounted_price'),
			'datetime_added'=>date("Y-m-d H:i:s"),
			'added_by'=>$user['id'],
			'inactive'=>(int)$this->input->post('inactive'),
			);
			// "SELECT * FROM audit_trail WHERE type_desc = '".ADD_ALL_STOCK_MARKDOWN."'"; 
			// // $id = $this->inventory_model->write_sched_stock_barcode_markdown($items);
			$id = $this->inventory_model->write_sched_stock_barcode_markdown_all_branches($items);
			$msg = "Updates Scheduled Markdown for ONE branch only.-->".$this->input->post('saving_type');
			$status = "success";
			
			$audit_items = array(
			'type'=>0,
			'trans_no'=>0,
			'type_desc'=>ADD_SINGLE_STOCK_MARKDOWN,
			'description'=>'pk_id:'.$id.'||stock_id:'.$this->input->post('hidden_stock_id').'||barcode:"'.$this->input->post('hidden_barcode').'"||branch_id:"'.$this->input->post('cc_hidden_branch_id').'"',
			'user'=>$user['id']
			);
			
			$audit_id = $this->inventory_model->write_to_audit_trail($audit_items);
			
		}
		
		echo json_encode(array('result'=>$status, 'msg'=>$msg));
	}
	public function srp_db()
	{
		$br_all_det = $items = $audit_items = array();
		$user = $this->session->userdata('user');
		
		//---hidden_pk_id
		$primary_id = $this->input->post('hidden_pk_id');
		$stock_id = $this->input->post('hidden_stock_id');
		
		if($this->input->post('saving_type') == 'all'){
			$br_all_det = $this->inventory_model->get_active_branches();
			foreach($br_all_det as $all_br_vals){
				$items = array(
				// 'stock_id'=>$this->input->post('hidden_stock_id'),
				'barcode'=>$this->input->post('hidden_barcode'),
				'sales_type_id'=>$this->input->post('hidden_sales_type_id'),
				'price'=>$this->input->post('prevailing_unit_price'),
				'branch_id'=>$all_br_vals->id,
				'computed_srp'=>$this->input->post('computed_srp'),
				'prevailing_unit_price'=>$this->input->post('prevailing_unit_price'),
				'landed_cost_markup'=>$this->input->post('landed_cost_markup'),
				'cost_of_sales_markup'=>$this->input->post('cost_of_sales_markup'),
				);
			
				$id = $this->inventory_model->write_stock_barcode_srp_all_branches($items);
				
				// $audit_items = array(
				// 'type'=>0,
				// 'trans_no'=>0,
				// 'type_desc'=>ADD_ALL_STOCK_MARKDOWN,
				// 'description'=>'pk_id:'.$id.'||stock_id:'.$this->input->post('hidden_stock_id').'||barcode:"'.$this->input->post('hidden_barcode').'"||branch_id:"'.$all_br_vals->id.'"',
				// 'user'=>$user['id']
				// );
				
				// $audit_id = $this->inventory_model->write_to_audit_trail($audit_items);
			
			}
			
			// $msg = "Update SRP for ALL BRANCHES.-->".$this->input->post('saving_type');
			$msg = "Update SRP for ALL BRANCHES.";
			$status = "success";
		}else{
			$items = array(
			// 'stock_id'=>$this->input->post('hidden_stock_id'),
			'barcode'=>$this->input->post('hidden_barcode'),
			'sales_type_id'=>$this->input->post('hidden_sales_type_id'),
			'price'=>$this->input->post('prevailing_unit_price'),
			'branch_id'=>$this->input->post('cc_hidden_branch_id'),
			'computed_srp'=>$this->input->post('computed_srp'),
			'prevailing_unit_price'=>$this->input->post('prevailing_unit_price'),
			'landed_cost_markup'=>$this->input->post('landed_cost_markup'),
			'cost_of_sales_markup'=>$this->input->post('cost_of_sales_markup'),
			);
			// "SELECT * FROM audit_trail WHERE type_desc = '".ADD_ALL_STOCK_MARKDOWN."'"; 
			// // $id = $this->inventory_model->write_sched_stock_barcode_markdown($items);
			$id = $this->inventory_model->write_stock_barcode_srp_all_branches($items);
			// $msg = "Updates SRP for ONE branch only.-->".$this->input->post('saving_type');
			$msg = "Updated SRP for ONE branch only.";
			$status = "success";
			
			// $audit_items = array(
			// 'type'=>0,
			// 'trans_no'=>0,
			// 'type_desc'=>ADD_SINGLE_STOCK_MARKDOWN,
			// 'description'=>'pk_id:'.$id.'||stock_id:'.$this->input->post('hidden_stock_id').'||barcode:"'.$this->input->post('hidden_barcode').'"||branch_id:"'.$this->input->post('cc_hidden_branch_id').'"',
			// 'user'=>$user['id']
			// );
			
			// $audit_id = $this->inventory_model->write_to_audit_trail($audit_items);
			
		}
		
		echo json_encode(array('result'=>$status, 'msg'=>$msg, 'pk_id'=>$primary_id, 'stock_id'=>$stock_id, 'items'=>$items));
	}
	//-----STOCKS MASTER [SUPPLIER DETAILS]-----APM-----END
	
	//-----STOCK LOGS-----MMS-----START
	public function stock_master_write_to_stock_logs(){
		$audit_items = array();
		
		
		$type_desc = $this->input->post('type_desc');
		$data_for_stock_logs = $this->input->post('data_for_stock_logs');
		$id_and_affected_values = explode('::',$data_for_stock_logs);
		$stock_id  = explode(':' , $id_and_affected_values[0]);
		$affected_values = $id_and_affected_values[1];
		$user = $this->session->userdata('user');
		
		$stock_master_logs = array(
								'type'=>$type_desc,
								'branch'=>'All',
								'stock_id'=>$stock_id[1],
								'affected_field_values'=>$affected_values,
								'modified_by'=>$user['id']
								   );
								   
		if($affected_values != ''){
		$res = $this->inventory_model->write_to_stock_logs_for_sm($stock_master_logs);
		// echo $res;
		// echo count(explode('||',$affected_values));
		}
		
	}
	//-----STOCK LOGS-----MMS-----END
	
	//-----SUPPLIER STOCK LOGS-----MMS-----START
	public function suplier_master_write_to_stock_logs(){
		$audit_items = array();
		$branch_id = $this->input->post('branch');
		$type_desc = $this->input->post('type_desc');
		$data_for_stock_logs = $this->input->post('data_for_stock_logs');
		$id_and_affected_values = explode('::',$data_for_stock_logs);
		$stock_id  = explode(':' , $id_and_affected_values[0]);
		$affected_values = $id_and_affected_values[1];
		$user = $this->session->userdata('user');
		
		$stock_master_logs = array(
								'type'=>$type_desc,
								'branch'=>$branch_id,
								'supplier_stock_code'=>$stock_id[1],
								'stock_id'=>$stock_id[3],
								'affected_field_values'=>$affected_values,
								'modified_by'=>$user['id']
								   );
								   
		if($affected_values != ''){
		$res = $this->inventory_model->write_to_stock_logs_for_sm($stock_master_logs);
		// echo count(explode('||',$affected_values));
		}
		 echo $res ;
		
	}
	//-----SUPPLIER STOCK LOGS-----MMS-----END
	//rhan start write to stock_deletion for approval
		 public function write_to_db_barcode_prices_approval(){
			
			 $stock_id = $this->input->post('stock_id');
			 $barcode = $this->input->post('barcode');
			 $branch = $this->input->post('branch');
			 $sales_type_id = $this->input->post('sale_type_id');
			 $affected_values = $this->input->post('affected_values');
			 $user = $this->session->userdata('user');
			
			 $stock_barcode_prices_data = array(
									'stock_id'=> $stock_id,
									'barcode'=> $barcode,
									'branch'=> $branch,
									'sale_type_id'=>$sales_type_id,
									'affected_values'=>$affected_values,
									'modified_by'=> $user['id']
									);
			 
			 $this->inventory_model->write_to_barcode_prices_approval($stock_barcode_prices_data);
		 }
	//rhan end
	
	
	//-----INV AUDIT TRAIL-----APM-----START
	public function write_to_db_audit_trail(){
		$audit_items = array();
		$stock_id = $this->input->post('stock_id');
		$type_desc = $this->input->post('type_desc');
		$items = $this->input->post('form_vals');
		$items = substr($items, 0, -4);
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
		$this->inventory_model->write_to_audit_trail($audit_items);
		// echo json_encode(array('result'=>'success', 'msg'=>$msg, 'id'=>$stock_id));
		
	}
	//-----INV AUDIT TRAIL-----APM-----END
	//-----INVENTORY MOVEMENTS-----APM-----START
	//-----Movement Types Maintenance-----START
	public function movement_types($ref=''){
		$data = $this->syter->spawn('inventory');
		$data['page_subtitle'] = "Movement Types";
		$types = $this->inventory_model->get_movement_types();
		//echo $this->db->last_query();
		
        $data['add_js'] = 'js/site_list_forms.js';
        $data['load_js'] = "core/inventory.php";
        $data['use_js'] = "sampleJS";
		
		$data['code'] = build_movement_types_maintenance_list($types);
		$this->load->view('page',$data);
	}
	//-----ADD and EDIT
	public function manage_movement_type($id=null){
        $data = $this->syter->spawn('inventory');
        $data['page_subtitle'] = "Manage Movement Type";
        $items = null;
        $receive_cart = array();

        if($id != null){
           	$details = $this->inventory_model->get_movement_types($id);
            $items = $details[0];
        }

        $data['code'] = build_movement_types_maintenance_form($items);

        $data['add_js'] = 'js/site_list_forms.js';
        $data['load_js'] = "core/inventory.php";
        $data['use_js'] = "movementTypeJs";
        $this->load->view('page',$data);
    }
	public function movement_type_db(){
		$user = $this->session->userdata('user');
		$status = "";
		$items = array(
			// 'id' => $this->input->post('id'),
			'description' => $this->input->post('description'),
			'is_adjustment' => (int)$this->input->post('is_adjustment'),
			'is_positive' => (int)$this->input->post('is_positive'),
			// 'inactive' => $this->input->post('inactive'),
		);
		
		$mode = $this->input->post('mode');
		if($mode == 'add')
			$movement_type_exist = $this->inventory_model->movement_type_exist_add_mode($this->input->post('description'));
		else if($mode == 'edit')
			$movement_type_exist = $this->inventory_model->movement_type_exist_edit_mode($this->input->post('description'), $this->input->post('movement_type_id'));
		
		// echo "Movement Type exist : ".$movement_type_exist."<br>";
		
		if($movement_type_exist){
			$id = '';
			$msg = "WARNING : Movement Type [ ".$this->input->post('description')." ] already exists!";
			$status = "warning";
		}else{
		
			if ($this->input->post('movement_type_id')) {
				$id = $this->input->post('movement_type_id');
				$this->inventory_model->update_movement_type($items,$id);
				$msg = "Updated Movement Type : ".ucwords($this->input->post('description'));
				$status = "success";
			}else{
				$id = $this->inventory_model->add_movement_type($items);
				##########AUDIT TRAIL [START]##########
				$audit_items = array(
				'type'=>0,
				'trans_no'=>0,
				'type_desc'=>ADD_MOVEMENT_TYPE,
				'description'=>'id:'.$id.'||description:"'.ucfirst($this->input->post('description')).'"',
				'user'=>$user['id']
				);
				
				$audit_id = $this->inventory_model->write_to_audit_trail($audit_items);
				##########AUDIT TRAIL [END]##########
				$msg = "Added Movement Type : ".ucwords($this->input->post('description'));
				$status = "success";
			}
		}

		echo json_encode(array('status'=>$status, 'id'=>$id,'msg'=>$msg));
	}
	//-----Movement Types Maintenance-----END
	//-----INVENTORY MOVEMENTS-----APM-----END
	public function movements_inq($ref){
		//echo $ref;
		//	$date_start = $this->input->post('date_start');	
		//	$date_end = $this->input->post('date_end');	
			$items = array();
		// if (strcasecmp($ref,'new')) {
			// // $results = $this->inventory_model->get_movements_details_approval($ref); //-----OLD
			// $results = $this->inventory_model->get_stock_movements_from_main($ref);
		// // echo $this->inv_transactions_model->db->last_query();
			// if ($results) {
				// $items = $results;
			// }
		// }
		if($ref != ''){
			$results = $this->inventory_model->get_stock_movements_from_main($ref);
			if ($results) {
				$items = $results;
			}
		}
		//echo var_dump($results);
		$data['load_js'] = 'core/inventory.php';
        $data['use_js'] = 'MovementSearchJs';
		$data['code'] = build_movements_inq_form($ref, $items);
		$this->load->view('load',$data);
	}
	public function movements_result(){
		 $stock_id = $this->input->post('stock_id');
		 $start_date = date('Y-m-d', strtotime($this->input->post('start_date')));
		 $end_date = date('Y-m-d', strtotime($this->input->post('end_date')));
		// $results = $this->inventory_model->get_search_movements_details($stock_id, $start_date, $end_date); //-----OLD
		$results = $this->inventory_model->search_stock_movements_from_main($stock_id, $start_date, $end_date);
		$data['load_js'] = 'core/inventory.php';
        $data['use_js'] = 'MovementSearchJs';
	
		$data['code'] = build_movement_display($results);
		$this->load->view('load',$data);
	}
}