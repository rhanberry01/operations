<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Purchasing extends CI_Controller {
	var $data = null;
	public function __construct()
	{
		parent::__construct();
		$this->load->model('core/purchasing_model');
		$this->load->model('site/site_model');
		$this->load->helper('site/site_forms_helper');
		$this->load->helper('core/purchasing_helper');
	}
	//********************Suppliers*****Allyn*****start
	public function suppliers()
	{
		$data = $this->syter->spawn('suppliers');

		$suppliers = $this->purchasing_model->get_supplier();
		$data['page_title'] = fa('fa-user fa-fw')."Suppliers";
		$data['code'] = suppliers_display($suppliers);

		$this->load->view('page',$data);
	}
	public function supplier_setup($supplier_id = null)
	{
		$data = $this->syter->spawn();

		if (is_null($supplier_id)){
			$data['page_title'] = fa('fa-user fa-fw')." Add New Supplier";
		}else {
			$supplier = $this->purchasing_model->get_supplier($supplier_id);
			$supplier = $supplier[0];
			if (!empty($supplier->supplier_id)) {
				// $data['page_title'] = fa('fa-user fa-fw')." ".iSetObj($supplier,'lname'.', '.'fname');
				$data['page_title'] = fa('fa-user fa-fw')." ".iSetObj($supplier,'supp_name');
				// if (!empty($supplier->update_date))
					// $data['page_subtitle'] = "Last updated ".$supplier->update_date;

			} else {
				header('Location:'.base_url().'purchasing/supplier_setup');
			}
		}

		$data['code'] = suppliers_form_container($supplier_id);
		$data['load_js'] = "core/purchasing.php";
		$data['use_js'] = "supplierFormContainerJs";

		$this->load->view('page',$data);
	}
	public function supplier_load($supplier_id = null)
	{
		$details = array();
		if (!is_null($supplier_id))
			$item = $this->purchasing_model->get_supplier($supplier_id);
		if (!empty($item))
			$details = $item[0];

		$data['code'] = suppliers_details_form($details,$supplier_id);
		$data['load_js'] = "core/purchasing.php";
		$data['use_js'] = "supplierDetailsJs";
		$this->load->view('load',$data);
	}
	public function supplier_details_db($fromDel=false)
	{
		// if (!$this->input->post())
			// header("Location:".base_url()."items");

		$items = array(
			'supplier_code' => $this->input->post('supplier_code'),
			'supp_name' => $this->input->post('supp_name'),
			'address' => $this->input->post('address'),
			'email' => $this->input->post('email'),
			'bank_account' => $this->input->post('bank_account'),
			'curr_code' => $this->input->post('curr_code'),
			'payment_terms' => $this->input->post('payment_terms'),
			'tax_group_id' => $this->input->post('tax_group_id'),
			'telno' => $this->input->post('telno'),
			'contact_person' => $this->input->post('contact_person'),
			'faxno' => $this->input->post('faxno'),
			'dr_inv' => (int)$this->input->post('dr_inv'),
			'inactive' => (int)$this->input->post('inactive'),
		);

		if($fromDel){
			// unset($items['tax_exempt']);
			unset($items['inactive']);
		}

		if ($this->input->post('supplier_id')) {
			$id = $this->input->post('supplier_id');
			$this->purchasing_model->update_supplier($items,$id);
			$msg = "Updated Supplier: ".ucwords($items['supp_name']);
		} else {
			$id = $this->purchasing_model->add_supplier($items);
			$msg = "Added New Supplier: ".ucwords($items['supp_name']);
		}

		echo json_encode(array('id'=>$id,'msg'=>$msg));
	}
	//********************Suppliers*****Allyn*****end
	//********************PO ENTRY NEW*****Allyn*****start
	public function purchase_order_form($po_id=null){

		$data = $this->syter->spawn('purchase_orders');
		$data['page_title'] = "Purchase Order Entry";

		$data['code'] = purchaseHeaderPage($po_id);
        $data['add_css'] = 'js/plugins/typeaheadmap/typeaheadmap.css';
        $data['add_js'] = array('js/plugins/typeaheadmap/typeaheadmap.js');
        $data['load_js'] = 'core/purchasing.php';
        $data['use_js'] = 'purchaseOrderHeaderJS';
        $this->load->view('page',$data);
	}
	public function details_load($po_id=null){
        $po=array();
        $type_no = null;
        if($po_id != null){
            $pos = $this->purchasing_model->get_po_header($po_id);
            $po=$pos[0];
        }else{
            $getter = $this->site_model->get_next_ref(PURCHASE_ORDER);
            $type_no = $getter->next_ref;
        }

        $data['code'] = poHeaderDetailsLoad($po,$po_id, $type_no);
        $data['load_js'] = 'core/purchasing.php';
        $data['use_js'] = 'poHeaderDetailsLoadJs';
        $this->load->view('load',$data);
    }
	public function po_header_details_db(){

        $getter_types = $this->site_model->get_next_ref(PURCHASE_ORDER);
        $type_no = $getter_types->next_type_no;
        $reference = ($this->input->post('reference') ? $this->input->post('reference') : $getter_types->next_ref);

        $reference = $this->site_model->check_duplicate_ref(PURCHASE_ORDER,$reference);


        $user = $this->session->userdata('user');
        $user['id'];

        $items = array(
            "supplier_id"=>$this->input->post('supplier_id'),
            "branch_id"=>$this->input->post('branch_id'),
            "comments"=>$this->input->post('comments'),
            "ord_date"=>date2Sql($this->input->post('ord_date')),
            "reference"=>$reference,
            "requisition_no"=>$this->input->post('requisition_no'),
            // "into_stock_location"=>$this->input->post('into_stock_location'),
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
                'reference'=>$reference
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
	public function items_load($order_no=null){
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
	//********************PO ENTRY NEW*****Allyn*****end
	//*********************Jed*******************
	public function purchase_order_form_OLD($po_id=null){

		$data = $this->syter->spawn('purchase_orders');
		$data['page_title'] = "Purchase Order Entry";

		$data['code'] = purchaseHeaderPage($po_id);
        $data['add_css'] = 'js/plugins/typeaheadmap/typeaheadmap.css';
        $data['add_js'] = array('js/plugins/typeaheadmap/typeaheadmap.js');
        $data['load_js'] = 'core/purchasing.php';
        $data['use_js'] = 'purchaseOrderHeaderJS';
        $this->load->view('page',$data);
	}
	public function details_load_OLD($po_id=null){
        $po=array();
        $type_no = null;
        if($po_id != null){
            $pos = $this->purchasing_model->get_po_header($po_id);
            $po=$pos[0];
        }else{
            $getter = $this->site_model->get_next_ref(PURCHASE_ORDER);
            $type_no = $getter->next_ref;
        }

        $data['code'] = poHeaderDetailsLoad($po,$po_id, $type_no);
        $data['load_js'] = 'core/purchasing.php';
        $data['use_js'] = 'poHeaderDetailsLoadJs';
        $this->load->view('load',$data);
    }
	public function po_header_details_db_OLD(){

        $getter_types = $this->site_model->get_next_ref(PURCHASE_ORDER);
        $type_no = $getter_types->next_type_no;
        $reference = ($this->input->post('reference') ? $this->input->post('reference') : $getter_types->next_ref);

        $reference = $this->site_model->check_duplicate_ref(PURCHASE_ORDER,$reference);


        $user = $this->session->userdata('user');
        $user['id'];

        $items = array(
            "supplier_id"=>$this->input->post('supplier_id'),
            "comments"=>$this->input->post('comments'),
            "ord_date"=>date2Sql($this->input->post('ord_date')),
            "delivery_date"=>date2Sql($this->input->post('ord_date')),
            "reference"=>$reference,
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
                'reference'=>$reference
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
    public function items_load_OLD($order_no=null){
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

        $json['stock_id'] = $item->id;
        $json['uom'] = $item->uom;
        $json['unit_cost'] = $item->unit_cost;

        // $this->load->model('core/inventory_model');
        // $qoh = $this->inventory_model->get_item_qoh($item->id);
        // $json['qoh'] = $qoh->qoh;

        $where = array('unit_code'=>$item->uom);
        $uoms = $this->purchasing_model->get_details($where,'stock_uoms');

        $opts = array();
        $opts[$uoms[0]->unit_code] = $uoms[0]->unit_code;
        // if($item->no_per_pack > 0)
        //     $opts['Pack(@'.$item->no_per_pack.' '.$item->uom.')'] = $item->uom."-".'pack-'.$item->no_per_pack;
        // if($item->no_per_case > 0)
        //     $opts['Case(@'.$item->no_per_case.' Packs)'] = $item->uom."-".'case-'.$item->no_per_case;

        $json['opts'] =  $opts;
        // $json['ppack'] = $item->no_per_pack;
        // $json['pcase'] = $item->no_per_case;
        echo json_encode($json);
    }
	public function get_item_details_OLD($item_id=null,$asJson=true){
        $json = array();
        $items = $this->purchasing_model->get_item($item_id);
        $item = $items[0];

        $json['item_id'] = $item->id;
        $json['uom'] = $item->uom_id;
        $json['standard_cost'] = $item->standard_cost;

        $this->load->model('core/inventory_model');
        $qoh = $this->inventory_model->get_item_qoh($item->id);
        $json['qoh'] = $qoh->qoh;

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
            "stock_id"=>$this->input->post('item'),
            "delivery_date"=>date2Sql($this->input->post('delivery_date')),
            // "stk_units"=>$this->input->post('select-uom'),
            "uom"=>$this->input->post('select-uom'),
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
	public function add_item_OLD(){
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
	public function get_items_added_OLD($order_no=null,$asJson=true){
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
	public function delete_item_OLD($ref=null){

            $id = $this->purchasing_model->delete_item($ref);
            $msg = 'Item has been deleted.';

        echo json_encode(array("msg"=>$msg));
    }

    // ======================================================================================= //
    //          outstanding purchase
    // ======================================================================================= //
    public function purch_outstanding()
    {
        $data = $this->syter->spawn('purchasing');

        $data['page_title'] = fa('fa-question-circle')." Outstanding Purchase Orders Maintenance";


        $data['code'] = build_purch_order_inquiry();
        $data['add_css'][] = 'css/daterangepicker/daterangepicker-bs3.css';
        $data['add_js'][] = 'js/plugins/daterangepicker/daterangepicker.js';

        $data['load_js'] = 'core/purchasing.php';
        $data['use_js'] = 'purchOrderSearchJs';
        $this->load->view('page',$data);
    }

    public function po_inquiry_results()
    {
        // if (!$this->input->post())
        //     header('Location:'.base_url().'purchasing/purch_outstanding');
        $where_array = array();
        if($this->input->post('supplier_id') && $this->input->post('daterange')){

            $supplier_id = $this->input->post('supplier_id');

            $daterange = $this->input->post('daterange');
            $dates = explode(" to ",$daterange);
            $date_from = (empty($dates[0]) ? date('Y-m-d') : date('Y-m-d',strtotime($dates[0])));
            $date_to = (empty($dates[1]) ? date('Y-m-d') : date('Y-m-d',strtotime($dates[1])));

            $where_array = array();
            $where_array['purch_orders.supplier_id'] = (int) $supplier_id;
            $where_array['purch_orders.ord_date >=']=$date_from;
            $where_array['purch_orders.ord_date <=']=$date_to;

        }

        $results = $this->purchasing_model->get_po_header2($where_array);
        // echo $this->db->last_query();
        $data['code'] = build_po_display($results);
        $this->load->view('load',$data);
    }
    /////////

    public function purchase_order_receive($po_id=null){
        $po_items=array();
        $po=array();
        if($po_id != null){
            $pos = $this->purchasing_model->get_po_header($po_id);
            $po=$pos[0];


            $pos_item = $this->purchasing_model->get_po_items($po_id);
            if($pos_item)
                $po_items=$pos[0];

        }

        $data = $this->syter->spawn('purchase_orders');
        $data['page_title'] = " Receiving for Purchase Order #".$po->reference;

        $getter = $this->site_model->get_next_ref(SUPPLIER_INVOICE);
        $type_no = $getter->next_ref;

        $data['code'] = purchaseReceivePage($po,$po_id,$po_items,$type_no);
        $data['add_css'] = 'js/plugins/typeaheadmap/typeaheadmap.css';
        $data['add_js'] = array('js/plugins/typeaheadmap/typeaheadmap.js');
        $data['load_js'] = 'core/purchasing.php';
        $data['use_js'] = 'purchaseOrderReceiveJS';
        $this->load->view('page',$data);
    }

    public function details_load_receive($po_id=null){
        $po=array();
        if($po_id != null){
            $pos = $this->purchasing_model->get_po_header($po_id);
            $po=$pos[0];
        }
        $data['code'] = poHeaderDetailsLoadReceive($po,$po_id);
        $data['load_js'] = 'core/purchasing.php';
        $data['use_js'] = 'poHeaderDetailsLoadJs';
        $this->load->view('load',$data);
    }
    public function items_load_receive($order_no=null){
        $po_items=array();
        if($order_no != null){
            $pos = $this->purchasing_model->get_po_items($order_no);
            if($pos)
                $po_items=$pos[0];
        }
        $data['code'] = poItemsLoadReceive($po_items,$order_no);
        $data['load_js'] = 'core/purchasing.php';
        $data['use_js'] = 'poItemsReceiveJs';
        $this->load->view('load',$data);
    }
    public function get_items_received($order_no=null,$asJson=true){
        $pos = array();
        $pos = $this->purchasing_model->get_po_items($order_no);

        $code = tableItemsReceived($pos);

        echo json_encode(array("code"=>$code));
    }
    public function save_receive(){

        $counter = 0;
        $get_to_types = $this->site_model->get_next_ref(PURCHASE_ORDER_DELIVERY);
        $type_no = $get_to_types->next_type_no;
        $reference = $get_to_types->next_ref;

        $all_total_ordered = 0;
        $all_this_delivery = 0;

        //var_dump($this->input->post('delivery'));
        foreach ($this->input->post('delivery') as $po_detail_item => $detail_val) {

            $where['purch_order_details.po_detail_item'] = (int) $po_detail_item;
            $po_detail = $this->purchasing_model->get_po_items_details($where);

            $all_total_ordered += $po_detail[0]->quantity_ordered;
            $all_this_delivery += $po_detail[0]->quantity_received + $detail_val;
            //echo $detail_val."---";
            if($detail_val != 0){
                //echo $detail_val."--";


                //var_dump($po_detail)."<br>";
                $act_price = $po_detail[0]->unit_price;
                $std_cost_unit = $po_detail[0]->unit_price;

                $quantity_received = $po_detail[0]->quantity_received + $detail_val;
                $left_qty = $po_detail[0]->quantity_ordered - $quantity_received;

                //echo $quantity_received.'--'.$left_qty;

                $line_total = $left_qty * $po_detail[0]->unit_price;
                $vals = $po_detail[0]->unit_price;
                if($po_detail[0]->discount_percent != 0){
                    $disc1 = $po_detail[0]->discount_percent / 100;
                    $disc1_val = $po_detail[0]->unit_price * $disc1;

                    $vals = $po_detail[0]->unit_price - $disc1_val;

                    if($po_detail[0]->discount_percent2 != 0){
                        $disc2 = $po_detail[0]->discount_percent2 / 100;
                        $vals2 = $vals * $disc2;
                        $vals = $vals - $vals2;

                        if($po_detail[0]->discount_percent3 != 0){
                            $disc3 = $po_detail[0]->discount_percent3 / 100;
                            $vals3 = $vals * $disc3;
                            $vals = $vals - $vals3;
                        }

                    }

                    $line_total = $vals * $left_qty;
                }

                // echo $line_total;

                $items = array(
                    'act_price'=>$act_price,
                    'std_cost_unit'=>$std_cost_unit,
                    'quantity_received'=>$quantity_received,
                    'line_total'=>$line_total
                );

                // var_dump($items);
                $this->purchasing_model->update_po_details($items,$po_detail_item);

                // ///////insert sa delivery details
                $line_total2 = $vals * $detail_val;


                $del_items = array(
                    'order_id'=>$po_detail[0]->order_id,
                    'po_detail_item'=>$po_detail[0]->po_detail_item,
                    'item_id'=>$po_detail[0]->item_code,
                    'qty_received'=>$detail_val,
                    'line_total'=>$line_total2,
                    'date_delivered'=>date2Sql($this->input->post('date_delivered')),
                    'reference'=>$reference,
                    'order_no'=>$type_no
                );

                //var_dump($del_items);

                $id = $this->purchasing_model->add_delivery($del_items);

                //////insert sa stockmoves

                $user = $this->session->userdata('user');
                $user['id'];
                $stock_items = array(
                    'item_id'=>$po_detail[0]->item_code,
                    'trans_type'=>PURCHASE_ORDER_DELIVERY,
                    'type_no'=>$type_no,
                    'trans_date'=>date2Sql($this->input->post('date_delivered')),
                    'loc_code'=>$this->input->post('into_stock_location'),
                    'qty'=>$detail_val,
                    'person_id'=>$user['id'],
                    'visible'=>1,
					'reference'=>$reference,
					'movement_type'=>'adjustment',
                    'reference_link'=>$id
                );

                $stock_id = $this->purchasing_model->add_stockmoves($stock_items);

                $counter++;
            }else{
                //echo 'ssssssss';
            }
        }

        //echo $all_total_ordered.'---'.$all_this_delivery;

        if($all_total_ordered == $all_this_delivery){
            //echo 'pumasok---'.$this->input->post('form_mod_id');
            $items = array(
                'status'=>'complete'
            );
            $this->purchasing_model->update_header($items,$this->input->post('form_mod_id'));
        }

        if($counter > 0){

            //$upd_ref = $this->site_model->update_trans_types_next_ref($type_no, PURCHASE_ORDER_DELIVERY);
            $trans_items = array(
                'trans_type'=>PURCHASE_ORDER_DELIVERY,
                'type_no'=>$type_no,
                'reference'=>$reference
            );
            $this->site_model->add_trans_ref($trans_items);
        }

        site_alert('Purchase Order Delivery has been processed.','success');
    }
    public function save_receive_and_invoice(){

        $ctr_inv = 0;
        $counter = 0;
        $gtotal=0;
        $get_to_types = $this->site_model->get_next_ref(PURCHASE_ORDER_DELIVERY);
        $type_no = $get_to_types->next_type_no;
        $reference = $get_to_types->next_ref;

        $all_total_ordered = 0;
        $all_this_delivery = 0;


        $id_trans = 0;
        //var_dump($this->input->post('delivery'));
        foreach ($this->input->post('delivery') as $po_detail_item => $detail_val) {

            $where['purch_order_details.po_detail_item'] = (int) $po_detail_item;
            $po_detail = $this->purchasing_model->get_po_items_details($where);

            $all_total_ordered += $po_detail[0]->quantity_ordered;
            $all_this_delivery += $po_detail[0]->quantity_received + $detail_val;
            //echo $detail_val."---";
            if($detail_val != 0){
                //echo $detail_val."--";
                //var_dump($po_detail)."<br>";
                $act_price = $po_detail[0]->unit_price;
                $std_cost_unit = $po_detail[0]->unit_price;

                $quantity_received = $po_detail[0]->quantity_received + $detail_val;
                $left_qty = $po_detail[0]->quantity_ordered - $quantity_received;

                //echo $quantity_received.'--'.$left_qty;

                $line_total = $left_qty * $po_detail[0]->unit_price;
                $vals = $po_detail[0]->unit_price;
                if($po_detail[0]->discount_percent != 0){
                    $disc1 = $po_detail[0]->discount_percent / 100;
                    $disc1_val = $po_detail[0]->unit_price * $disc1;

                    $vals = $po_detail[0]->unit_price - $disc1_val;

                    if($po_detail[0]->discount_percent2 != 0){
                        $disc2 = $po_detail[0]->discount_percent2 / 100;
                        $vals2 = $vals * $disc2;
                        $vals = $vals - $vals2;

                        if($po_detail[0]->discount_percent3 != 0){
                            $disc3 = $po_detail[0]->discount_percent3 / 100;
                            $vals3 = $vals * $disc3;
                            $vals = $vals - $vals3;
                        }

                    }

                    $line_total = $vals * $left_qty;
                }

                // echo $line_total;

                $items = array(
                    'act_price'=>$act_price,
                    'std_cost_unit'=>$std_cost_unit,
                    'quantity_received'=>$quantity_received,
                    'line_total'=>$line_total
                );

                // var_dump($items);
                $this->purchasing_model->update_po_details($items,$po_detail_item);

                // ///////insert sa delivery details
                $line_total2 = $vals * $detail_val;

                $gtotal += $line_total2;

                $del_items = array(
                    'order_id'=>$po_detail[0]->order_id,
                    'po_detail_item'=>$po_detail[0]->po_detail_item,
                    'item_id'=>$po_detail[0]->item_code,
                    'qty_received'=>$detail_val,
                    'line_total'=>$line_total2,
                    'date_delivered'=>date2Sql($this->input->post('date_delivered')),
                    'reference'=>$reference,
                    'order_no'=>$type_no
                );

                //var_dump($del_items);

                $id = $this->purchasing_model->add_delivery($del_items);


                if($ctr_inv == 0){
                    $getter = $this->site_model->get_next_ref(SUPPLIER_INVOICE);
                    $type_no1 = $getter->next_type_no;

                    $reference = ($this->input->post('inv_reference') ? $this->input->post('inv_reference') : $getter->next_ref);

                    $reference = $this->site_model->check_duplicate_ref(SUPPLIER_INVOICE,$reference);

                        $inv_item = array(
                        'trans_type'=>SUPPLIER_INVOICE,
                        'order_no'=>$type_no1,
                        'reference'=>$reference,
                        'supplier_id'=>$this->input->post('supplier_id'),
                        'supp_reference'=>$this->input->post('requisition_no'),
                        'trans_date'=>date2Sql($this->input->post('ord_date')),
                        'due_date'=>date2Sql($this->input->post('due_date'))
                    );

                    $id_trans = $this->purchasing_model->add_supp_invoices($inv_item);

                    $trans_items = array(
                        'trans_type'=>SUPPLIER_INVOICE,
                        'type_no'=>$type_no,
                        'reference'=>$reference
                    );
                    $this->site_model->add_trans_ref($trans_items);
                }
                $ctr_inv++;


                //////////pag update ng qty invoice sa delivery_details
                $where2['delivery_details.delivery_id'] = (int) $id;
                $deliv_details = $this->purchasing_model->get_deliveries($where2);

                $t_invoice = $detail_val + $deliv_details[0]->qty_invoice;
                $items = array(
                    'qty_invoice'=>$t_invoice
                );
                $this->purchasing_model->update_delivery($items,$id);

                $inv_items = array(
                    'delivery_id'=>$id,
                    'supp_invoice_transno'=>$id_trans,
                    'qty_invoice'=>$detail_val,
                    'line_total'=>$line_total2
                );
                $this->purchasing_model->add_supp_invoices_items($inv_items);
                // $ctr_inv++;
                //////////////////////////////////////////////////////////

                $user = $this->session->userdata('user');
                $user['id'];
                $stock_items = array(
                    'item_id'=>$po_detail[0]->item_code,
                    'trans_type'=>PURCHASE_ORDER_DELIVERY,
                    'type_no'=>$type_no,
                    'trans_date'=>date2Sql($this->input->post('date_delivered')),
                    'loc_code'=>$this->input->post('into_stock_location'),
                    'qty'=>$detail_val,
                    'person_id'=>$user['id'],
                    'visible'=>1,
                    'reference'=>$reference,
                    'movement_type'=>'adjustment'
                );

                $stock_id = $this->purchasing_model->add_stockmoves($stock_items);

                $counter++;
            }else{
                //echo 'ssssssss';
            }
        }

        //echo $all_total_ordered.'---'.$all_this_delivery;

        if($all_total_ordered == $all_this_delivery){
            //echo 'pumasok---'.$this->input->post('form_mod_id');
            $items = array(
                'status'=>'complete'
            );
            $this->purchasing_model->update_header($items,$this->input->post('form_mod_id'));
        }

        if($counter > 0){

            //$upd_ref = $this->site_model->update_trans_types_next_ref($type_no, PURCHASE_ORDER_DELIVERY);
            $trans_items = array(
                'trans_type'=>PURCHASE_ORDER_DELIVERY,
                'type_no'=>$type_no,
                'reference'=>$reference
            );
            $this->site_model->add_trans_ref($trans_items);
        }

        if($ctr_inv > 0){

            //$upd_ref = $this->site_model->update_trans_types_next_ref($type_no, PURCHASE_ORDER_DELIVERY);
            $updts = array(
                'ov_amount'=>$gtotal
            );
            $this->purchasing_model->update_invoices($updts,$id_trans);
        }

        //site_alert('Purchase Order Delivery has been processed.','success');

        //////////////////////////invoicing

        // $suppinv_sess = array();
        // if($this->session->userData('suppinv_sess'))
        //     $suppinv_sess = $this->session->userData('suppinv_sess');

        // $counter = 0;
        // if($deliv_ids){
        //     foreach($deliv_ids as $key => $val){
        //         $t_invoice = $val['val'] + $val['inv'];
        //         $items = array(
        //             'qty_invoice'=>$t_invoice
        //         );
        //         $this->purchasing_model->update_delivery($items,$val['ref']);

        //     }

        //     $inv_item = array(
        //         'trans_type'=>SUPPLIER_INVOICE,
        //         'order_no'=>$type_no,
        //         'reference'=>$this->input->post('reference'),
        //         'supplier_id'=>$this->input->post('supplier_id'),
        //         'supp_reference'=>$this->input->post('supp_reference'),
        //         'trans_date'=>date2Sql($this->input->post('trans_date')),
        //         'due_date'=>date2Sql($this->input->post('due_date')),
        //         'ov_amount'=>$this->input->post('hline_total')
        //     );

        //     $this->purchasing_model->add_supp_invoices($inv_item);
        //     $counter++;
        // }

        // if($counter > 0){
        //      $trans_items = array(
        //         'trans_type'=>SUPPLIER_INVOICE,
        //         'type_no'=>$type_no,
        //         'reference'=>$this->input->post('reference')
        //     );
        //     $this->site_model->add_trans_ref($trans_items);
        //     //$upd_ref = $this->site_model->update_trans_types_next_ref($type_no, SUPPLIER_INVOICE);
        // }
        site_alert('Purchase Order has been received and invoiced.','success');


    }
    public function purchase_order_close($po_id=null){

        $items = array(
            'close_po'=>1,
            'status'=>'complete'
        );
        $this->purchasing_model->update_header($items,$po_id);

        site_alert('Purchase Order Closed.','warning');

    }

    /////////////////Purchase order inquiry//////////////////////
    /////////////////////////////////////////////////////////////
    public function purch_order_inquiry()
    {
        $data = $this->syter->spawn('purchasing');

        $data['page_title'] = fa('fa-question-circle')." Purchase Order Inquiry";


        $data['code'] = build_po_inquiry();
        $data['add_css'][] = 'css/daterangepicker/daterangepicker-bs3.css';
        $data['add_js'][] = 'js/plugins/daterangepicker/daterangepicker.js';

        $data['load_js'] = 'core/purchasing.php';
        $data['use_js'] = 'purchOrderInquirySearchJs';
        $this->load->view('page',$data);
    }
    public function po_inquiry_detail_results()
    {
        $where_array = array();
        if($this->input->post('supplier_id')){

            $supplier_id = $this->input->post('supplier_id');
            $where_array['purch_orders.supplier_id'] = (int) $supplier_id;

            if($this->input->post('daterange')){
                $daterange = $this->input->post('daterange');
                $dates = explode(" to ",$daterange);
                $date_from = (empty($dates[0]) ? date('Y-m-d') : date('Y-m-d',strtotime($dates[0])));
                $date_to = (empty($dates[1]) ? date('Y-m-d') : date('Y-m-d',strtotime($dates[1])));

                //$where_array = array();
                $where_array['purch_orders.ord_date >=']=$date_from;
                $where_array['purch_orders.ord_date <=']=$date_to;
            }

            if($this->input->post('person_id')){
                $person_id = $this->input->post('person_id');
                $where_array['purch_orders.person_id'] = (int) $person_id;
            }
        }

        $results = $this->purchasing_model->get_po_header($where_array);
        // echo $this->db->last_query();

        $data['load_js'] = 'core/purchasing.php';
        $data['use_js'] = 'purchOrderInquiryResultJs';
        $data['code'] = build_po_inq_display($results);
        $this->load->view('load',$data);
    }
    public function po_inquiry_form($po_id=null){

        $data = $this->syter->spawn('purchase_orders');
        $data['page_title'] = "Purchase Order";

        $data['code'] = purchaseHeaderPageInquiry($po_id);
        $data['add_css'] = 'js/plugins/typeaheadmap/typeaheadmap.css';
        $data['add_js'] = array('js/plugins/typeaheadmap/typeaheadmap.js');
        $data['load_js'] = 'core/purchasing.php';
        $data['use_js'] = 'purchaseOrderHeaderInquiryJS';
        $this->load->view('page',$data);
    }
    public function po_resource_person()
    {
        $this->make->sForm('#',array('id'=>'frm-reso-p'));
            $this->make->input('Attention','attention','','',array('class'=>'rOkay'));
            $this->make->input('Noted by','noted_by','','',array('class'=>'rOkay'));
            $this->make->input('Approved by','approved_by','','',array('class'=>'rOkay'));
        $this->make->eForm();

        $data['code'] = $this->make->code();
        $this->load->view('load',$data);
    }
    public function po_print_excel($order_no=null)
    {
        $this->load->library('excel');

        if (!$order_no)
            header('Location:'.base_url().'purchasing/purch_order_inquiry');

        $where_array = array(array('key'=>'purch_orders.order_no','value'=>$order_no,'escape'=>true));
        $header  = $this->purchasing_model->get_po_header_w_supp($where_array);

        $where_array = array(array('key'=>'purch_orders.order_no','value'=>$order_no,'escape'=>true));
        $details = $this->purchasing_model->get_po_items_w_master($where_array);

        if (!$header)
            header('Location:'.base_url().'purchasing/purch_order_inquiry');

        $header = $header[0];
        $sheet  = $this->excel->getActiveSheet();

        $rc = 1;

        $sheet->getCell('A'.$rc)->setValue('BON Industrial Sales');
        $sheet->getStyle('A'.$rc)->getFont()->setName('Times New Roman');
        $sheet->getStyle('A'.$rc)->getFont()->setBold(true);
        $sheet->getStyle('A'.$rc)->getFont()->setSize(24);
        $rc++;

        $sheet->getCell('A'.$rc)->setValue('35 Macopa St. Sta Mesa Heights, Quezon City, Philippines'); $rc++;
        $sheet->getCell('A'.$rc)->setValue('Tel. Nos.: (632) 734-2740 to 44, 733-1532, 733-1569, 733-1541, 733-1542'); $rc++;
        $sheet->getCell('A'.$rc)->setValue('Fax No.: (632) 712-4771 / 732-0008'); $rc++;
        $sheet->getCell('A'.$rc)->setValue('Email: bonindustrial@skyinet.net'); $rc++;
        $sheet->getStyle('A'.($rc-4).':A'.$rc)->getFont()->setName('Arial');
        $sheet->getStyle('A'.($rc-4).':A'.$rc)->getFont()->setSize(11);
        $rc++;

        $sheet->getCell('A'.$rc)->setValue(date('j F Y',strtotime($header->ord_date)));
        $sheet->getStyle('A'.$rc)->getFont()->setName('Arial');
        $sheet->getStyle('A'.$rc)->getFont()->setSize(11);
        $rc++;

        $sheet->getCell('A'.$rc)->setValue(strtoupper($header->supplier_name)); $rc++;
        $sheet->getCell('A'.$rc)->setValue($header->supplier_address); $rc++;
        $sheet->getCell('A'.$rc)->setValue('Tel. No.: '.$header->supplier_tel); $rc++;
        $sheet->getCell('A'.$rc)->setValue('Fax No.: '.$header->supplier_fax); $rc++;
        $sheet->getStyle('A'.($rc-4).':A'.$rc)->getFont()->setName('Arial');
        $sheet->getStyle('A'.($rc-4).':A'.$rc)->getFont()->setSize(11);
        $rc++;

        if ($this->input->post('attention')) {
            $sheet->getCell('A'.$rc)->setValue('Attention: '.$this->input->post('attention'));
            $sheet->getStyle('A'.$rc)->getFont()->setName('Arial');
            $sheet->getStyle('A'.$rc)->getFont()->setSize(11);
            $rc+=2;
        }

        $sheet->mergeCells('A'.$rc.':G'.$rc);
        $sheet->getCell('A'.$rc)->setValue('PURCHASE ORDER '.strtoupper($header->reference));
        $sheet->getStyle('A'.$rc)->getFont()->setName('Arial');
        $sheet->getStyle('A'.$rc)->getFont()->setBold(true);
        $sheet->getStyle('A'.$rc)->getFont()->setSize(13);
        $sheet->getStyle('A'.$rc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $rc+=2;

        $sheet->getCell('A'.$rc)->setValue('Item No');
        $sheet->getCell('B'.$rc)->setValue('Code');
        $sheet->getCell('C'.$rc)->setValue('Description');
        $sheet->getCell('D'.$rc)->setValue('Grade');
        $sheet->getCell('E'.$rc)->setValue('Price');
        $sheet->getCell('F'.$rc)->setValue('Qty');
        $sheet->getCell('G'.$rc)->setValue('Total');
        $sheet->getStyle('A'.$rc.':G'.$rc)->getFont()->setName('Arial');
        $sheet->getStyle('A'.$rc.':G'.$rc)->getFont()->setBold(true);
        $sheet->getStyle('A'.$rc.':G'.$rc)->getFont()->setSize(11);
        $sheet->getStyle('A'.$rc.':G'.$rc)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
        $sheet->getStyle('A'.$rc.':G'.$rc)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
        $sheet->getStyle('A'.$rc.':G'.$rc)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
        $sheet->getStyle('A'.$rc.':G'.$rc)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
        $sheet->getStyle('A'.$rc.':G'.$rc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A'.$rc.':G'.$rc)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_JUSTIFY);
        $rc++;

        $start_rc = $rc;
        $counter = 1;
        foreach ($details as $val) {
            $sheet->getCell('A'.$rc)->setValue($counter);
            $sheet->getCell('B'.$rc)->setValue($val->item_code);
            $sheet->getCell('C'.$rc)->setValue($val->name);
            $sheet->getCell('D'.$rc)->setValue($val->grade);
            $sheet->getCell('E'.$rc)->setValue('');
            $sheet->getCell('F'.$rc)->setValue(num($val->quantity_ordered));
            $sheet->getCell('G'.$rc)->setValue('');

            $sheet->getStyle('A'.$rc.':G'.$rc)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
            $sheet->getStyle('A'.$rc.':G'.$rc)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
            $sheet->getStyle('A'.$rc.':G'.$rc)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
            $sheet->getStyle('A'.$rc.':G'.$rc)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

            $sheet->getStyle('A'.$rc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle('A'.$rc)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

            $sheet->getStyle('B'.$rc.':D'.$rc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('B'.$rc.':D'.$rc)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

            $sheet->getStyle('F'.$rc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle('F'.$rc)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $rc++;
            $counter++;
        }

        $sheet->getStyle('A'.($rc-1).':G'.($rc-1))->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);

        $sheet->getStyle('A'.$start_rc.':G'.($rc-1))->getFont()->setName('Arial');
        $sheet->getStyle('A'.$start_rc.':G'.($rc-1))->getFont()->setBold(false);
        $sheet->getStyle('A'.$start_rc.':G'.($rc-1))->getFont()->setSize(11);
        $rc++;

        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        // $sheet->getColumnDimension('H')->setAutoSize(true);

        $sheet->getCell('A'.$rc)->setValue('Prepared by:');
        $sheet->getCell('C'.$rc)->setValue('Noted by:');
        $sheet->getCell('E'.$rc)->setValue('Approved by:');
        $rc+=2;

        $sheet->getCell('A'.$rc)->setValue(implode(' ',array($header->person_fname,$header->person_mname,$header->person_lname)));
        $sheet->getCell('C'.$rc)->setValue($this->input->post('noted_by'));
        $sheet->getCell('E'.$rc)->setValue($this->input->post('approved_by'));
        $sheet->getStyle('A'.$rc.':G'.$rc)->getFont()->setBold(true);
        $sheet->getStyle('A'.$rc.':G'.$rc)->getFont()->setItalic(true);

        $filename='Purchase Order '.strtoupper($header->reference).'.xlsx';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
        $objWriter->save('php://output');
    }
    public function po_print_pdf($order_no=null)
    {
        if (!$order_no)
            header('Location:'.base_url().'purchasing/purch_order_inquiry');

        $where_array = array(array('key'=>'purch_orders.order_no','value'=>$order_no,'escape'=>true));
        $header  = $this->purchasing_model->get_po_header_w_supp($where_array);

        $where_array = array(array('key'=>'purch_orders.order_no','value'=>$order_no,'escape'=>true));
        $details = $this->purchasing_model->get_po_items_w_master($where_array);

        if (!$header)
            header('Location:'.base_url().'purchasing/purch_order_inquiry');

        $this->load->helper('pdf_helper');

        $header = $header[0];
        $data['header'] = $header;
        $data['details'] = $details;
        $data['attention'] = $this->input->post('attention');
        $data['noted_by'] = $this->input->post('noted_by');
        $data['approved_by'] = $this->input->post('approved_by');

        $this->load->view('contents/prints/print_purchase_order',$data);
    }
    public function details_load_inq($po_id=null){
        $po=array();
        $type_no = null;
        if($po_id != null){
            $pos = $this->purchasing_model->get_po_header($po_id);
            $po=$pos[0];
        }else{
            $type_no = $this->site_model->get_next_ref(PURCHASE_ORDER);
        }

        $data['code'] = poHeaderDetailsInquiry($po,$po_id, $type_no);
        $data['load_js'] = 'core/purchasing.php';
        $data['use_js'] = 'poHeaderDetailsLoadJs';
        $this->load->view('load',$data);
    }
    public function items_load_inquiry($order_no=null){
        $po_items=array();
        if($order_no != null){
            $pos = $this->purchasing_model->get_po_items($order_no);
            if($pos)
                $po_items=$pos[0];
        }
        $data['code'] = poItemsLoadInquiry($po_items,$order_no);
        $data['load_js'] = 'core/purchasing.php';
        $data['use_js'] = 'poItemsInquiryJs';
        $this->load->view('load',$data);
    }

    public function get_po_items_inquiry($order_no=null,$asJson=true){
        $pos = array();
        $pos = $this->purchasing_model->get_po_items($order_no);

        $received = $this->purchasing_model->get_delivery_items($order_no);

        $code = tableItems_inquiry($pos,$received);

        echo json_encode(array("code"=>$code));
    }

    ////////////////supplier invoice/////////////////////
    /////////////////////////////////////////////////////
    public function supplier_invoices(){
        // $this->session->unset_userData('suppinv_sess');
        $data = $this->syter->spawn('purchase_orders');

        $rec = $this->purchasing_model->get_delivery_items();
        //$det = $details[0];
        //$data['page_subtitle'] = 'Edit Branch Setup';
        $data['code'] = suppInvoiceForm($rec);
        // $data['add_js'] = array('js/plugins/timepicker/bootstrap-timepicker.min.js');
        // $data['add_css'] = array('css/timepicker/bootstrap-timepicker.min.css');
        $data['load_js'] = 'core/purchasing.php';
        $data['use_js'] = 'suppInvoiceJS';
        $this->load->view('page',$data);
    }
    public function supp_header_load(){

        $getter = $this->site_model->get_next_ref(SUPPLIER_INVOICE);
        $type_no = $getter->next_ref;


        $data['code'] = suppInvHead($type_no);
        $data['load_js'] = 'core/purchasing.php';
        $data['use_js'] = 'suppHeadJS';
        $this->load->view('load',$data);
    }
    public function supp_invoice_item(){
        $suppinv_sess = array();
        if($this->session->userData('suppinv_sess'))
            $suppinv_sess = $this->session->userData('suppinv_sess');

        $received = $this->purchasing_model->get_delivery_items();

        $data['code'] = tableItems_suppinvoice($received,$suppinv_sess);
        $data['load_js'] = 'core/purchasing.php';
        $data['use_js'] = 'suppItemsJS';
        $this->load->view('load',$data);
    }
    public function supp_invoice_session(){
        $suppinv_sess = array();
        if($this->session->userData('suppinv_sess'))
            $suppinv_sess = $this->session->userData('suppinv_sess');

        $ref = $this->input->post('ref');
        $val = $this->input->post('val');
        $poref = $this->input->post('poref');
        $inv = $this->input->post('inv');
        $ltotal = $this->input->post('linetotal');

        $suppinv_sess[$ref] = array(
            'ref'=>$ref,
            'val'=>$val,
            'inv'=>$inv,
            'poref'=>$poref,
            'ltotal'=>$ltotal
        );

        $this->session->set_userData('suppinv_sess',$suppinv_sess);

        //var_dump($suppinv_sess);

    }
    public function remove_invoice_session(){
        $suppinv_sess = array();
        if($this->session->userData('suppinv_sess'))
            $suppinv_sess = $this->session->userData('suppinv_sess');

        $ref = $this->input->post('ref');
        unset($suppinv_sess[$ref]);

        $this->session->set_userData('suppinv_sess',$suppinv_sess);

        //var_dump($suppinv_sess);

    }
    public function view_suppinv_added(){
        $suppinv_sess = array();
        if($this->session->userData('suppinv_sess'))
            $suppinv_sess = $this->session->userData('suppinv_sess');

        $data['code'] = tableItems_addedinvoice($suppinv_sess);
        $data['load_js'] = 'core/purchasing.php';
        $data['use_js'] = 'suppAddedJS';
        $this->load->view('load',$data);
    }
    public function supp_invoice_db(){
        $getter = $this->site_model->get_next_ref(SUPPLIER_INVOICE);
        $type_no = $getter->next_type_no;

        $reference = ($this->input->post('reference') ? $this->input->post('reference') : $getter->next_ref);

        $reference = $this->site_model->check_duplicate_ref(SUPPLIER_INVOICE,$reference);

        $suppinv_sess = array();
        if($this->session->userData('suppinv_sess'))
            $suppinv_sess = $this->session->userData('suppinv_sess');

        $counter = 0;
        if(count($suppinv_sess) > 0){
            $inv_item = array(
                'trans_type'=>SUPPLIER_INVOICE,
                'order_no'=>$type_no,
                'reference'=>$reference,
                'supplier_id'=>$this->input->post('supplier_id'),
                'supp_reference'=>$this->input->post('supp_reference'),
                'trans_date'=>date2Sql($this->input->post('trans_date')),
                'due_date'=>date2Sql($this->input->post('due_date')),
                'ov_amount'=>$this->input->post('hline_total')
            );

            $id = $this->purchasing_model->add_supp_invoices($inv_item);

            foreach($suppinv_sess as $key => $val){
                $t_invoice = $val['val'] + $val['inv'];
                $items = array(
                    'qty_invoice'=>$t_invoice
                );
                $this->purchasing_model->update_delivery($items,$val['ref']);


                $inv_items = array(
                    'delivery_id'=>$val['ref'],
                    'supp_invoice_transno'=>$id,
                    'qty_invoice'=>$val['val'],
                    'line_total'=>$val['ltotal']
                );
                $this->purchasing_model->add_supp_invoices_items($inv_items);

            }

            $counter++;
        }

        if($counter > 0){
             $trans_items = array(
                'trans_type'=>SUPPLIER_INVOICE,
                'type_no'=>$type_no,
                'reference'=>$reference
            );
            $this->site_model->add_trans_ref($trans_items);
            //$upd_ref = $this->site_model->update_trans_types_next_ref($type_no, SUPPLIER_INVOICE);
        }
        site_alert('Supplier invoice has been processed.','success');
        $this->session->unset_userData('suppinv_sess');
        //echo $this->input->post('hline_total');
    }

    ///////////////supp payment///////////////////////////
    ///////////////supp payment///////////////////////////
    public function supp_payment_form($po_id=null){

        $data = $this->syter->spawn('purchase_orders');
        $data['page_title'] = "Supplier Payment Entry";

        $data['code'] = suppPaymentHeaderPage($po_id);
        $data['add_css'] = 'js/plugins/typeaheadmap/typeaheadmap.css';
        $data['add_js'] = array('js/plugins/typeaheadmap/typeaheadmap.js');

        $data['add_css'] = 'css/daterangepicker/daterangepicker-bs3.css';
        $data['add_js'] = 'js/plugins/daterangepicker/daterangepicker.js';

        $data['load_js'] = 'core/purchasing.php';
        $data['use_js'] = 'suppPaymentHeaderJS';
        $this->load->view('page',$data);
    }
    public function supp_payment_details_load($po_id=null){

        $getter = $this->site_model->get_next_ref(SUPPLIER_PAYMENT);
        $type_no = $getter->next_ref;

        $data['code'] = spHeaderDetailsLoad($type_no);

        $data['load_js'] = 'core/purchasing.php';
        $data['use_js'] = 'spHeaderDetailsLoadJs';
        $this->load->view('load',$data);
    }
    public function supp_allocation_results()
    {
        // if (!$this->input->post())
        //     header('Location:'.base_url().'purchasing/purch_outstanding');
        // $where_array = array();
        // if($this->input->post('supplier_id') && $this->input->post('daterange')){

            $supplier_id = $this->input->post('supplier_id');

            $daterange = $this->input->post('daterange');

            // if($this->input->post('show_settled')){
            //     $check = 1;
            // }else{
            //     $check = 0;
            // }
            $dates = explode(" to ",$daterange);
            $date_from = (empty($dates[0]) ? date('Y-m-d') : date('Y-m-d',strtotime($dates[0])));
            $date_to = (empty($dates[1]) ? date('Y-m-d') : date('Y-m-d',strtotime($dates[1])));

            $where_array = array();
            $where_array['supplier_payments.supplier_id'] = (int) $supplier_id;
            $where_array['supplier_payments.date >=']=$date_from;
            $where_array['supplier_payments.date <=']=$date_to;

        // }


        $data = $this->syter->spawn('purchasing');

        $data['page_title'] = fa('fa-question-circle')." Suppliers Allocation";


        //$data['code'] = build_purch_order_inquiry();



        $results = $this->purchasing_model->get_supp_allocations($where_array);
        //echo $this->db->last_query();
        $data['code'] = build_suppalloc_display($results);
        $data['add_css'][] = 'css/daterangepicker/daterangepicker-bs3.css';
        $data['add_js'][] = 'js/plugins/daterangepicker/daterangepicker.js';

        $data['load_js'] = 'core/purchasing.php';
        $data['use_js'] = 'purchOrderSearchJs';
        $this->load->view('load',$data);
    }
    public function supp_payment_db(){
        $getter = $this->site_model->get_next_ref(SUPPLIER_PAYMENT);
        $type_no = $getter->next_type_no;

        $items = array(
            'trans_type'=>SUPPLIER_PAYMENT,
            'order_no'=>$type_no,
            'reference'=>$this->input->post('reference'),
            'supplier_id'=>$this->input->post('supplier_id'),
            'supp_reference'=>$this->input->post('supp_ref'),
            'date'=>date2Sql($this->input->post('order_date')),
            'pay_type'=>$this->input->post('bank_payment_type'),
            'bank_acct'=>$this->input->post('into_bank_acct'),
            'amount'=>$this->input->post('amount'),
            'amount_discount'=>$this->input->post('amount_discount'),
            'ewt'=>$this->input->post('ewt'),
            'memo'=>$this->input->post('memo'),
        );

        $this->purchasing_model->add_supp_payment($items);


        $trans_items = array(
            'trans_type'=>SUPPLIER_PAYMENT,
            'type_no'=>$type_no,
            'reference'=>$this->input->post('reference')
        );
        $this->site_model->add_trans_ref($trans_items);

        site_alert('Supplier Payment has been saved.','success');
        //echo $this->input->post('hline_total');
    }
    public function allocation_form($payment_id=null,$supplier_id=null,$date=null,$totals=null,$trans_no=null,$trans_type=null){

        $data = $this->syter->spawn('purchase_orders');
        $data['page_title'] = "Allocate Supplier Payment";

        //$type_no = $this->site_model->get_next_ref(SUPPLIER_PAYMENT);
        $where_array = array();
        $where_array['supplier_invoices.supplier_id'] = (int) $supplier_id;
        $results = $this->purchasing_model->get_supp_invoices($where_array);
        //echo $this->db->last_query();
        $results2 = $this->purchasing_model->get_payments_totals($where_array);


        $data['code'] = allocForm($results, $payment_id, $date, $totals, $supplier_id, $trans_no, $trans_type, $results2);
        $data['add_css'] = 'js/plugins/typeaheadmap/typeaheadmap.css';
        $data['add_js'] = array('js/plugins/typeaheadmap/typeaheadmap.js');

        $data['add_css'] = 'css/daterangepicker/daterangepicker-bs3.css';
        $data['add_js'] = 'js/plugins/daterangepicker/daterangepicker.js';

        $data['load_js'] = 'core/purchasing.php';
        $data['use_js'] = 'allocationJS';
        $this->load->view('page',$data);
    }
    public function allocation_db(){
        //$type_no = $this->site_model->get_next_ref(SUPPLIER_PAYMENT);
        //echo 'weeeeeeeeeeeeee';

        foreach($this->input->post('allocate') as $trans_id => $alloc_val){

            if($alloc_val != 0){
                $results = $this->purchasing_model->get_supp_invoices($trans_id);
                $res = $results[0];

                $alloc = $res->alloc + $alloc_val;

                // if($alloc == $res->ov_amount){
                //     $paid = 1;
                // }else{
                //     $paid = 0;

                // }

                $items = array(
                    'alloc'=>$alloc,
                    'paid'=>1
                );

                $this->purchasing_model->update_invoices($items,$trans_id);
                $rec = "";
                if($this->input->post('supp_receipt')){
                    $rec = $this->input->post('supp_receipt');
                }
                $alloc_items = array(
                    'amount'=>$alloc_val,
                    'date_alloc'=>$this->input->post('date_alloc'),
                    'trans_no_to'=>$res->order_no,
                    'trans_type_to'=>$res->trans_type,
                    'trans_no_from'=>$this->input->post('trans_no'),
                    'trans_type_from'=>$this->input->post('trans_type'),
                    'supp_receipt'=>$rec,
                );

                $this->purchasing_model->add_supp_allocation($alloc_items);

            }
        }

        site_alert('Payment has been allocated.','success');
    }


    public function supp_creditnote_inquiry()
    {
        $data = $this->syter->spawn('purchasing');

        $data['page_title'] = fa('fa-question-circle')." Supplier Credit Note";


        $data['code'] = build_creditnote_inquiry();
        $data['add_css'][] = 'css/daterangepicker/daterangepicker-bs3.css';
        $data['add_js'][] = 'js/plugins/daterangepicker/daterangepicker.js';

        $data['load_js'] = 'core/purchasing.php';
        $data['use_js'] = 'creditnoteInquirySearchJs';
        $this->load->view('page',$data);
    }
    public function cn_inquiry_detail_results()
    {
        // if (!$this->input->post())
        //     header('Location:'.base_url().'purchasing/purch_outstanding');
        $where_array = array();
        if($this->input->post('supplier_id')){

            $supplier_id = $this->input->post('supplier_id');
            $where_array['supplier_invoices.supplier_id'] = (int) $supplier_id;
            $where_array['supplier_invoices.paid'] = 0;

            if($this->input->post('daterange')){
                $daterange = $this->input->post('daterange');
                $dates = explode(" to ",$daterange);
                $date_from = (empty($dates[0]) ? date('Y-m-d') : date('Y-m-d',strtotime($dates[0])));
                $date_to = (empty($dates[1]) ? date('Y-m-d') : date('Y-m-d',strtotime($dates[1])));

                //$where_array = array();
                $where_array['supplier_invoices.trans_date >=']=$date_from;
                $where_array['supplier_invoices.trans_date <=']=$date_to;
            }

            // $daterange = $this->input->post('daterange');
            // $dates = explode(" to ",$daterange);
            // $date_from = (empty($dates[0]) ? date('Y-m-d') : date('Y-m-d',strtotime($dates[0])));
            // $date_to = (empty($dates[1]) ? date('Y-m-d') : date('Y-m-d',strtotime($dates[1])));

            // $where_array = array();
            // $where_array['purch_orders.ord_date >=']=$date_from;
            // $where_array['purch_orders.ord_date <=']=$date_to;

        }

        $results = $this->purchasing_model->get_supplier_invoices($where_array);
        // echo $this->db->last_query();
        $data['code'] = build_creditnote_inq_display($results);
        $this->load->view('load',$data);
    }

    public function supplier_credit_note($trans_no=null,$supp_id=null,$reference=null){
        // $this->session->unset_userData('suppinv_sess');
        $data = $this->syter->spawn('purchase_orders');
        $data['page_title'] = "Supplier Credit Note for Invoice #".$reference;

        //$rec = $this->purchasing_model->get_delivery_items();
        //$det = $details[0];
        //$data['page_subtitle'] = 'Edit Branch Setup';
        $data['code'] = suppcreditNoteForm($supp_id,$trans_no);
        // $data['add_js'] = array('js/plugins/timepicker/bootstrap-timepicker.min.js');
        // $data['add_css'] = array('css/timepicker/bootstrap-timepicker.min.css');
        $data['load_js'] = 'core/purchasing.php';
        $data['use_js'] = 'creditNoteJS';
        $this->load->view('page',$data);
    }
    public function creditnote_header_load($supp_id=null,$trans_no=null){

        $return_sess = array();
        if($this->session->userData('return_sess'))
            $return_sess = $this->session->userData('return_sess');

        $getter = $this->site_model->get_next_ref(SUPPLIER_CREDIT_NOTE);
        $type_no = $getter->next_ref;

        $where_array['supplier_invoices.trans_no'] = (int) $trans_no;
        $results = $this->purchasing_model->get_items_creditnote($where_array);

        // var_dump($results);

        $data['code'] = creditNoteHead($type_no,$supp_id,$results,$return_sess);
        $data['load_js'] = 'core/purchasing.php';
        $data['use_js'] = 'creditnoteHeadJS';
        $this->load->view('load',$data);
    }
    public function view_return_added(){
        $return_sess = array();
        if($this->session->userData('return_sess'))
            $return_sess = $this->session->userData('return_sess');

        $data['code'] = tableItems_addedreturn($return_sess);
        $data['load_js'] = 'core/purchasing.php';
        $data['use_js'] = 'creditItemsJS';
        $this->load->view('load',$data);
    }
    public function credit_note_session(){
        $return_sess = array();
        if($this->session->userData('return_sess'))
            $return_sess = $this->session->userData('return_sess');

        $ref = $this->input->post('ref');
        $val = $this->input->post('val');
        $deliv_id = $this->input->post('deliv_id');
        $item_id = $this->input->post('item_id');
        $inv_transno = $this->input->post('inv_transno');


        $where = array('supplier_invoice_items.id'=>$ref);
        $detail = $this->purchasing_model->get_items_creditnote($where);
        $det = $detail[0];

        $line_total = $val * $det->unit_price;
        $vals = $det->unit_price;
        if($det->discount_percent != 0){
            $disc1 = $det->discount_percent / 100;
            $disc1_val = $det->unit_price * $disc1;

            $vals = $det->unit_price - $disc1_val;

            if($det->discount_percent2 != 0){
                $disc2 = $det->discount_percent2 / 100;
                $vals2 = $vals * $disc2;
                $vals = $vals - $vals2;

                if($det->discount_percent3 != 0){
                    $disc3 = $det->discount_percent3 / 100;
                    $vals3 = $vals * $disc3;
                    $vals = $vals - $vals3;
                }

            }

            $line_total = $vals * $val;
        }
        // $ltotal = $this->input->post('linetotal');

        $return_sess[$ref] = array(
            'ref'=>$ref,
            'val'=>$val,
            'deliv_id'=>$inv,
            'inv_transno'=>$inv_transno,
            'line_total'=>$line_total,
            'item_id'=>$item_id
        );

        $this->session->set_userData('return_sess',$return_sess);

        //var_dump($suppinv_sess);

    }
    public function remove_creditnote_session(){
        $return_sess = array();
        if($this->session->userData('return_sess'))
            $return_sess = $this->session->userData('return_sess');

        $ref = $this->input->post('ref');
        unset($return_sess[$ref]);

        $this->session->set_userData('return_sess',$return_sess);

        //var_dump($suppinv_sess);

    }
    public function credit_note_db(){
        $getter = $this->site_model->get_next_ref(SUPPLIER_CREDIT_NOTE);
        $type_no = $getter->next_type_no;

        $reference = ($this->input->post('reference') ? $this->input->post('reference') : $getter->next_ref);

        $reference = $this->site_model->check_duplicate_ref(SUPPLIER_CREDIT_NOTE,$reference);

        $return_sess = array();
        if($this->session->userData('return_sess'))
            $return_sess = $this->session->userData('return_sess');

        $total_return = 0;
        $counter = 0;
        if(count($return_sess) > 0){
        $inv_transno = 0;
            // $inv_item = array(
            //     'trans_type'=>SUPPLIER_INVOICE,
            //     'order_no'=>$type_no,
            //     'reference'=>$reference,
            //     'supplier_id'=>$this->input->post('supplier_id'),
            //     'supp_reference'=>$this->input->post('supp_reference'),
            //     'trans_date'=>date2Sql($this->input->post('trans_date')),
            //     'due_date'=>date2Sql($this->input->post('due_date')),
            //     'ov_amount'=>$this->input->post('hline_total')
            // );

            // $id = $this->purchasing_model->add_supp_invoices($inv_item);

            foreach($return_sess as $key => $val){
                $total_return += $val['line_total'];
                $inv_transno = $val['inv_transno'];
                // $items = array(
                //     'qty_invoice'=>$t_invoice
                // );
                $where = array('supplier_invoice_items.id'=>$val['ref']);
                $cnotes = $this->purchasing_model->get_item_cnote($where);
                $cn = $cnotes[0];

                if($val['val'] == $cn->qty_invoice){
                    $return = 1;
                }else{
                    $return = 0;
                }

                $updts1 = array(
                    'returned'=>$return,
                    'qty_returned'=>$val['val'] + $cn->qty_returned,
                    'line_total_returned'=>$val['line_total'] + $cn->line_total_returned
                );
                $this->purchasing_model->update_invoice_items($updts1,$val['ref']);

                //////insert sa stockmoves
                $user = $this->session->userdata('user');
                $user['id'];
                $stock_items = array(
                    'item_id'=>$val['item_id'],
                    'trans_type'=>SUPPLIER_CREDIT_NOTE,
                    'type_no'=>$type_no,
                    'trans_date'=>date2Sql($this->input->post('return_date')),
                    'loc_code'=>'PHP',
                    'qty'=>$val['val'] * -1,
                    'person_id'=>$user['id'],
                    'visible'=>1,
                    'reference'=>$reference,
                    'movement_type'=>'adjustment'
                );

                $stock_id = $this->purchasing_model->add_stockmoves($stock_items);
                //////////////////////////////////////
                // $inv_items = array(
                //     'delivery_id'=>$val['ref'],
                //     'supp_invoice_transno'=>$id,
                //     'qty_invoice'=>$val['val'],
                //     'line_total'=>$val['ltotal']
                // );
                // $this->purchasing_model->add_supp_invoices_items($inv_items);

            }

            $counter++;

            $items = array(
                'trans_type'=>SUPPLIER_CREDIT_NOTE,
                'order_no'=>$type_no,
                'reference'=>$reference,
                'supplier_id'=>$this->input->post('supp_id'),
                'supp_reference'=>$this->input->post('supp_reference'),
                'date'=>date2Sql($this->input->post('return_date')),
                'pay_type'=>'Cash',
                'bank_acct'=>'1',
                'amount'=>$total_return,
                'amount_discount'=>0,
                'ewt'=>0,
                'memo'=>$this->input->post('comments'),
            );

            $this->purchasing_model->add_supp_payment($items);

            $wheres = array('supplier_invoices.trans_no'=>$inv_transno);
            $get_invs = $this->purchasing_model->get_supplier_invoices($wheres);

            $updts = array(
                'ov_gst'=>$total_return + $get_invs[0]->ov_gst
            );
            $this->purchasing_model->update_invoices($updts,$inv_transno);

            $trans_items = array(
                'trans_type'=>SUPPLIER_CREDIT_NOTE,
                'type_no'=>$type_no,
                'reference'=>$reference
            );
            $this->site_model->add_trans_ref($trans_items);

            $this->session->unset_userData('return_sess');
            site_alert('Supplier Credit has been processed.','success');

        }

        // if($counter > 0){
        //      $trans_items = array(
        //         'trans_type'=>SUPPLIER_INVOICE,
        //         'type_no'=>$type_no,
        //         'reference'=>$reference
        //     );
        //     $this->site_model->add_trans_ref($trans_items);
        //     //$upd_ref = $this->site_model->update_trans_types_next_ref($type_no, SUPPLIER_INVOICE);
        // }
        // site_alert('Supplier invoice has been processed.','success');

        //echo $this->input->post('hline_total');
    }


    // public function load_invoice_drop($supp_id=null){

    //     $where['supplier_invoices.supplier_id'] = (int) $supp_id;
    //     $check_invoices = $this->purchasing_model->get_supplier_invoices($where);

    //     if($check_invoices)
    //         $code = invoiceDrop($supp_id);
    //     else
    //         $code = "";
    //     // supplierInvoiceDrop($label=null,$nameID=null,$value=null,$placeholder=null,$params=array(),$sup_id=null){
    //     echo json_encode(array("code"=>$code));
    // }
    public function supplier_payments_inq()
    {
        $data = $this->syter->spawn('purchasing');

        $data['page_title'] = fa('fa-question-circle')." Supplier Payments";


        $data['code'] = build_payments_inquiry();
        $data['add_css'][] = 'css/daterangepicker/daterangepicker-bs3.css';
        $data['add_js'][] = 'js/plugins/daterangepicker/daterangepicker.js';

        $data['load_js'] = 'core/purchasing.php';
        $data['use_js'] = 'suppPaymentHeaderJS';
        $this->load->view('page',$data);
    }



}