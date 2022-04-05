<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cashier extends CI_Controller {
	var $data = null;
	public function __construct()
	{
		parent::__construct();
		$this->load->model('core/cashier_model');
		$this->load->helper('core/cashier_helper');
	}
	
	//main cashier page
	public function search_barcode($barcode = NULL){
		$data = $this->syter->spawn('cashier');
		$data['page_subtitle'] = "Add Items";
		$items = $this->cashier_model->get_items();
		$dis_type = $this->cashier_model->get_discount();
        $data['load_js'] = "core/cashier.php";
        $data['use_js'] = "barcodeJS";
		$data['code'] = cashier_Page_form($items, $dis_type);
		$this->load->view('page',$data);
	}
	
	//scanned items
    public function load_purchases(){    	
		$barcode = $this->input->post('barcode');
		$items = $this->cashier_model->get_items();		
        $data['code'] = list_purchases_form($items); 
        $this->load->view('load',$data);
    }
    //total amount
    public function load_amount_purchases(){    	
		//$dis_type = $this->input->post('disc_type');	
		$dis_type = $this->cashier_model->get_discount();
		$items = $this->cashier_model->get_items();		
        $data['code'] = amount_purchase_form($items, $dis_type); 
        $this->load->view('load',$data);
    }
	//load discount type
    public function discount_type(){    	
		$pwd = $this->input->post('pwd');
		$sc = $this->input->post('sc');
		$this->cashier_model->update_discount($pwd, $sc);	
		$dis_type = $this->cashier_model->get_discount();
		$items = $this->cashier_model->get_items();					
        $data['code'] = amount_purchase_form($items, $dis_type); 
        $this->load->view('load',$data);
    }
	
	public function add_product(){
		    $barcode = $this->input->post('barcode');
			$stock = $this->cashier_model->check_product($barcode);
			if($stock){	
				$res = mysql_fetch_object($stock);
				//$price = $this->cashier_model->get_item_price($res->barcode, 1);					
				//$discount = $this->cashier_model->get_item_price($res->barcode, 1);					
	           		$rows = array(
	           					  'Productid' => $res->stock_id, 
	           					  'Barcode' => $res->barcode, 
	           					  'Description' => $res->description,  
	           					  'UOM' => $res->uom, 
	           					  'Price'=> 0,  
	           					  'Qty'=> $res->qty, 
	           					  'LDiscount' => 0,	  
	           					  'Extended' => 0, 
	           					  'Points' => 0);
					$id = $this->cashier_model->add_item($rows);
			}
			if($id){
				$status ='success';
				$msg='item added';
			}
		echo $status.'|'.$msg;
    }
	public function price_inq(){
	    $barcode = $this->input->post('barcode');
		//$items = $this->cashier_model->get_items();			
		$stock = $this->cashier_model->price_inq_on_db($barcode);	
		//$stock = mysql_fetch_object($stock);			
    	$data['code'] = price_inq_form($stock);
		//if($stock){
		//	$status ='success';
		//	$msg='item added';
		//} 
		//echo $status.'|'.$msg;
        $this->load->view('load',$data);
    }
	public function look_up(){
	    $description = $this->input->post('description');
		//$items = $this->cashier_model->get_items();			
		$stock = $this->cashier_model->look_up_on_db($description);	
		//$stock = mysql_fetch_object($stock);			
    	$data['code'] = look_up_form($stock);
		//if($stock){
		//	$status ='success';
		//	$msg='item added';
		//} 
		//echo $status.'|'.$msg;
        $this->load->view('load',$data);
    }
	public function check_pass(){
	    $username = $this->input->post('uname');
	    $password = $this->input->post('pass');
		$authorize = $this->cashier_model->check_password($username,$password);	
		if($authorize)	{			
			$status ='success';
			$msg='user is authorized';
		}else{
			$status = $msg = '';
		}	
		//$stock = $this->cashier_model->price_inq_on_db($barcode);	
		//$stock = mysql_fetch_object($stock);			
    	//$data['code'] = price_inq_form($stock);
		//if($stock){
		//	$status ='success';
		//	$msg='item added';
		//} 
		//echo $status.'|'.$msg;
		echo $status.'|'.$msg;
        //$this->load->view('load',$data);
    }
	public function void_all_scanned(){
			$stock = $this->cashier_model->void_scanned();
		/*	if($stock){	
				$res = mysql_fetch_object($stock);
	           		$rows = array(
	           					  'Productid' => $res->item_code, 
	           					  'Barcode' => $res->barcode, 
	           					  'Description' => $res->name,  
	           					  'UOM' => $res->uom_id, 
	           					  'Price'=> $res->sales_price,  
	           					  'Qty' => 0,  
	           					  'LDiscount' => 0,	  
	           					  'Extended' => $res->sales_price, 
	           					  'Points' => 0);
					$id = $this->cashier_model->add_item($rows);
			}*/
			if($stock){
				$status ='success';
				$msg='all scanned voided';
			}
			//*/
		echo $status.'|'.$msg;
    }
    
	public function void_line(){
	    $id = $this->input->post('line_id');
		$stock = $this->cashier_model->void_scanned($id);
		if($stock){
			$status ='success';
			$msg    ='all scanned voided';
		}	
		echo $status.'|'.$msg;
    }
	public function line_void_scanned_items($trx_id=null, $barcode=null){
		$details = $this->cashier_model->get_items();
		$data = $this->syter->spawn('cashier');
		$data['page_title'] = "Scanned Items";
		$data['code'] = view_for_line_void_form($details);
		//$data['add_css '] = 'js/plugins/typeaheadmap/typeaheadmap.css';
		//$data['add_js']= array('js/plugins/typeaheadmap/typeaheadmap.js');
		$data['load_js'] = 'core/cashier.php'; //needed if form is used
		$data['use_js'] = 'linevoidJS'; //needed if form is used
		$this->load->view('load',$data);
	}
	//-----tender types
    public function payment_type($sales_id=null){    	
        $this->load->model('cashier_model');
        $data = $this->syter->spawn('cashier');
		$data['page_subtitle'] = "Payment Types";
		$p_types = $this->cashier_model->get_payment_types();
		
        $data['code'] = Settle_Page_Form($p_types);  
        $data['load_js'] = "core/cashier.php";
        $data['use_js'] = 'settleJs';
        $this->load->view('page',$data);
    }
	
	public function get_tender_type_details(){
	    $pt = $this->input->post('payment_type');
		$details = $this->cashier_model->get_payment_types_details($pt);
		$res = mysql_fetch_object($details);
		if($details){
			$typeid = $res->id;
			$iscash = $res->is_cash;
			//$iscash = $res->is_cash;
		}	else{
			$iscash = $accountno = $apprno = $banktype = 0;
		}
		echo $typeid.'|'.$iscash.'|'.$msg.'|'.$status.'|'.$msg;
    }
    
	//-----ADD and EDIT	
    public function total_trans($asJson=true,$cart=null,$disc_cart=null,$charge_cart=null){
        $trans_cart = array();
        if($this->session->userData('trans_cart')){
            $trans_cart = $this->session->userData('trans_cart');
        }
        $trans_mod_cart = array();
        if($this->session->userData('trans_mod_cart')){
            $trans_mod_cart = $this->session->userData('trans_mod_cart');
        }
        if(is_array($cart)){
            $trans_cart = $cart;
        }
        $total = 0;
        $discount = 0;
        if(count($trans_cart) > 0){
            foreach ($trans_cart as $trans_id => $trans){
                if(isset($trans['cost']))
                    $cost = $trans['cost'];
                if(isset($trans['price']))
                    $cost = $trans['price'];

                if(isset($trans['modifiers'])){
                    foreach ($trans['modifiers'] as $trans_mod_id => $mod) {
                        if($trans_id == $mod['line_id'])
                            $cost += $mod['price'];
                    }
                }

                else{
                    if(count($trans_mod_cart) > 0){
                        foreach ($trans_mod_cart as $trans_mod_id => $mod) {
                            if($trans_id == $mod['trans_id'])
                                $cost += $mod['cost'];
                        }
                    }
                }
                $total += $trans['qty'] * $cost;
            }
        }
        $trans_disc_cart = sess('trans_disc_cart');
        if(is_array($disc_cart)){
            $trans_disc_cart = $disc_cart;
        }
        $discs = array();
        if(count($trans_disc_cart) > 0 ){
            foreach ($trans_disc_cart as $disc_id => $row) {
                $rate = $row['disc_rate'];
                switch ($row['disc_type']) {
                    case "item":
                            $item_cost = 0;
                            foreach ($row['items'] as $line) {
                                if(isset($trans_cart[$line])){
                                    if(isset($trans_cart[$line]['cost']))
                                        $cost =  $trans_cart[$line]['cost'];
                                    if(isset( $trans_cart[$line]['price']))
                                        $cost =  $trans_cart[$line]['price'];
                                    $item_cost += $cost;
                                    ###
                                    if(isset($trans_cart[$line]['modifiers'])){
                                        foreach ($trans_cart[$line]['modifiers'] as $trans_mod_id => $mod) {
                                            if($line == $mod['line_id'])
                                                $item_cost += $mod['price'];
                                        }
                                    }
                                    else{
                                        if(count($trans_mod_cart) > 0){
                                            foreach ($trans_mod_cart as $trans_mod_id => $mod) {
                                                if($line == $mod['trans_id']){
                                                    $item_cost += $mod['cost'];
                                                }
                                            }
                                        }
                                    }
                                    ####
                                }
                            }
                            $discs[] = array('type'=>$row['disc_code'],'amount'=>($rate / 100) * $item_cost);
                            $discount += ($rate / 100) * $item_cost;
                            $total -= $discount;
                            break;
                    case "equal":
                            $divi = $total/$row['guest'];
                            $discs[] = array('type'=>$row['disc_code'],'amount'=>($rate / 100) * $divi);
                            $discount += ($rate / 100) * $divi;
                            $total -= $discount;
                            break;
                    default:
                        $discs[] = array('type'=>$row['disc_code'],'amount'=>($rate / 100) * $total);
                        $discount += ($rate / 100) * $total;
                        $total -= $discount;
                }
            }
        }
        $trans_charge_cart = sess('trans_charge_cart');
        if(is_array($charge_cart)){
            $trans_charge_cart = $charge_cart;
        }
        #CHARGES
        $charges = array();
        $total_charges = 0;
        if(count($trans_charge_cart) > 0 ){
            $tax = $this->get_tax_rates(false);
            $am = 0;
            if(count($tax) > 0){
                $taxable_amount = 0;
                $not_taxable_amount = 0;
                foreach ($trans_cart as $trans_id => $v) {
                    if(isset($v['cost']))
                        $cost = $v['cost'];
                    if(isset($v['price']))
                        $cost = $v['price'];
                    ####################
                    if(isset($v['modifiers'])){
                        foreach ($v['modifiers'] as $trans_mod_id => $m) {
                            if($trans_id == $m['line_id']){
                                $cost += $m['price'];
                            }
                        }
                    }
                    else{
                        if(count($trans_mod_cart) > 0){
                            foreach ($trans_mod_cart as $trans_mod_id => $m) {
                                if($trans_id == $m['trans_id']){
                                    $cost += $m['cost'];
                                }
                            }
                        }
                    }
                    ####################
                    foreach ($trans_disc_cart as $disc_id => $row) {
                        $rate = $row['disc_rate'];
                        switch ($row['disc_type']) {
                            case "item":
                                    if( in_array($trans_id, $row['items'])){
                                        $discount = ($rate / 100) * $cost;
                                        $cost -= $discount;
                                    }
                                    break;
                            case "equal":
                                    $divi = $cost/$row['guest'];
                                    $discount = ($rate / 100) * $divi;
                                    $cost -= $discount;
                                    break;
                            default:
                                $discount = ($rate / 100) * $cost;
                                $cost -= $discount;
                        }
                    }

                    if($v['no_tax'] == 0){
                        $taxable_amount += $cost * $v['qty'];
                    }
                    else{
                        $not_taxable_amount += $cost * $v['cost'];
                    }
                }

                $am = $taxable_amount;
                $trans_sales_tax = array();
                foreach ($tax as $tax_id => $tx) {
                    $rate = ($tx['rate'] / 100);
                    $tax_value = ($am / ($rate + 1) ) * $rate;
                    $am -= $tax_value;
                }
            }
            else{
                $am = $total;
            }
            foreach ($trans_charge_cart as $charge_id => $opt) {
                $charge_amount = $opt['amount'];
                if($opt['absolute'] == 0){
                    $charge_amount = ($opt['amount'] / 100) * $am;
                }
                $charges[$charge_id] = array('code'=>$opt['code'],
                                   'name'=>$opt['name'],
                                   'amount'=>$charge_amount,
                                   );
                $total_charges += $charge_amount;
            }
            $total += $total_charges;
        }

        if($asJson)
            echo json_encode(array('total'=>$total,'discount'=>$discount,'discs'=>$discs,'charge'=>$total_charges,'charges'=>$charges));
        else
            return array('total'=>$total,'discount'=>$discount,'discs'=>$discs,'charge'=>$total_charges,'charges'=>$charges);
    }
   // public function get_tax_rates($asJson=true,$tax_id=null){
    /*
	//-----DB VALIDATION/INSERT/UPDATE
	public function product_details_db()
	{
		// if (!$this->input->post())
			// header("Location:".base_url()."items");
		$status = "";
		$items = array(
			'product_code' => $this->input->post('product_code'),
			'product_name' => $this->input->post('product_name'),
			'inactive' => $this->input->post('inactive'),
		);
		
		$mode = $this->input->post('mode');
		// echo "Mode : ".$mode."<br>";
		
		if($mode == 'add')
			$product_code_exist = $this->cashier_model->product_code_exist_add_mode($this->input->post('product_code'));
		else if($mode == 'edit')
			$product_code_exist = $this->cashier_model->product_code_exist_edit_mode($this->input->post('product_code'), $this->input->post('product_id'));
		
		// echo "Product Code exist : ".$product_code_exist."<br>";
		
		if($product_code_exist){
			$id = '';
			$msg = "WARNING : Product Code [ ".$this->input->post('product_code')." ] already exists!";
			$status = "warning";
		}else{
			if ($this->input->post('product_id')) {
				$id = $this->input->post('product_id');
				$this->cashier_model->update_product($items,$id);
				$msg = "Updated Product : ".ucwords($this->input->post('product_name'));
				$status = "success";
			}else{
				$id = $this->cashier_model->add_product($items);
				$msg = "Added New Product: ".ucwords($this->input->post('product_name'));
				$status = "success";
			}
		}
		
		// echo var_dump($items)."<br>";
		// echo "Current Status : ".$status."<br>";
		echo json_encode(array('status'=>$status, 'id'=>$id,'msg'=>$msg));
	}
*/
	//-----DB Validation
	public function validate_product_code(){
		$this->load->model('core/cashier_model');
		
	}
	
}