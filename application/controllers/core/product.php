<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product extends CI_Controller {
	var $data = null;
	public function __construct()
	{
		parent::__construct();
		$this->load->model('core/product_model');
		$this->load->helper('core/product_helper');
	}
	//-----LISTING
	public function products($ref='')
	{
		// $data = $this->syter->spawn('products_master');
		$data = $this->syter->spawn('products');
		$data['page_subtitle'] = "Product Master / Maintenance";
		$product = $this->product_model->get_products();
		//echo $this->db->last_query();
		$data['code'] = productPage($product);
		$this->load->view('page',$data);
	}
	//-----ADD and EDIT
	public function manage_products($product_id=null){
        // $data = $this->syter->spawn('products_master');
        $data = $this->syter->spawn('products');
        $data['page_subtitle'] = "Manage Product";
        $items = null;
        $receive_cart = array();

        if($product_id != null){
           	$details = $this->product_model->get_products($product_id);
            $items = $details[0];
        }

        $data['code'] = manage_product_form($items);

        $data['add_js'] = 'js/site_list_forms.js';
        $data['load_js'] = "core/product.php";
        $data['use_js'] = "productJS";
        $this->load->view('page',$data);
    }
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
			$product_code_exist = $this->product_model->product_code_exist_add_mode($this->input->post('product_code'));
		else if($mode == 'edit')
			$product_code_exist = $this->product_model->product_code_exist_edit_mode($this->input->post('product_code'), $this->input->post('product_id'));
		
		// echo "Product Code exist : ".$product_code_exist."<br>";
		
		if($product_code_exist){
			$id = '';
			$msg = "WARNING : Product Code [ ".$this->input->post('product_code')." ] already exists!";
			$status = "warning";
		}else{
			if ($this->input->post('product_id')) {
				$id = $this->input->post('product_id');
				$this->product_model->update_product($items,$id);
				$msg = "Updated Product : ".ucwords($this->input->post('product_name'));
				$status = "success";
			}else{
				$id = $this->product_model->add_product($items);
				$msg = "Added New Product: ".ucwords($this->input->post('product_name'));
				$status = "success";
			}
		}
		
		// echo var_dump($items)."<br>";
		// echo "Current Status : ".$status."<br>";
		echo json_encode(array('status'=>$status, 'id'=>$id,'msg'=>$msg));
	}
	//-----DB Validation
	public function validate_product_code(){
		$this->load->model('core/product_model');
		
	}
	
}