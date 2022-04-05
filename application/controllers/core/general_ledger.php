<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class General_ledger extends CI_Controller {
	var $data = null;
	public function __construct()
	{
		parent::__construct();
		$this->load->model('core/gl_model');
		$this->load->helper('core/gl_helper');
	}
	public function account_classes()
	{
		$this->load->helper('site/site_forms_helper');
		$results = $this->gl_model->get_chart_classes();
		$data = $this->syter->spawn('general_ledger');
		$data['page_subtitle'] = "Account Classes Management";
		$data['code'] = site_list_form(
			"general_ledger/account_classes_form",
			"account_classes_form",
			"Account Classes",
			$results,
			array('class_name'),
			'id');
		$data['add_js'] = 'js/site_list_forms.js';
		$this->load->view('page',$data);
	}
	public function account_classes_form($ref=null)
	{
		$classes = array();
		if ($ref) {
			$class = $this->gl_model->get_chart_classes(array('id'=>$ref));
			if ($class)
				$classes = $class[0];
		}
		$data['code'] = build_account_classes_form($classes);
		$data['load_js'] = "core/general_ledger.php";
		$data['use_js'] = "classFormContainerJs";
		$this->load->view('load',$data);
	}
	public function account_classes_db()
	{
		$items = array(
			'class_name' => $this->input->post('class_name'),
			'display_on_balance_sheet' =>  isset($_POST['display_on_balance_sheet']) ? 1 : 0
		);
		if (!$this->input->post('id')) {
			$id = $this->gl_model->write_chart_classes($items);
			$act = 'add';
			$msg = "Successfully added new account class";
		} else {
			$id = $this->input->post('id');
			$this->gl_model->change_chart_classes($items,array('id'=>$id));
			$act = 'update';
			$msg = 'Successfully updated account class';
		}
		echo json_encode(array('id'=>$id,'desc'=>$items['class_name'],'act'=>$act,'msg'=>$msg));
	}
	public function account_types($ref='')
	{
		$data = $this->syter->spawn('general_ledger');
		if ($ref) {
			$this->account_type_container($ref,$data);
		} else {
			$results = $this->gl_model->get_chart_types();
			$data['page_subtitle'] = "Account Types Management";
			$data['code'] = build_account_types_display($results);
		}
		$this->load->view('page',$data);
	}
	private function account_type_container($ref,&$data)
	{
		if (!strcasecmp($ref, 'new')) {
			$data['page_subtitle'] = "New Account Type";
		} else {
			$data['page_subtitle'] = "Edit Account Type";
		}
		$data['code'] = build_account_type_container($ref);
		$data['load_js'] = "core/general_ledger.php";
		$data['use_js'] = "typeFormContainerJs";
	}
	public function account_type_form($ref)
	{
		$account_type = array();
		if (!strcasecmp($ref, 'new')) {
			$data['page_subtitle'] = "New Account Type";
		} else {
			$results = $this->gl_model->get_chart_types(array('chart_types.id'=>$ref));
			if ($results)
				$account_type = $results[0];
			$data['page_subtitle'] = "Edit Account Type";
		}
		$data['code'] = build_account_type_form($account_type);
		$data['load_js'] = "core/general_ledger.php";
		$data['use_js'] = "typeFormJs";
		$this->load->view('load',$data);
	}
	public function account_type_db()
	{
		$items = array(
			'type_name' => $this->input->post('type_name'),
			'parent' => ($this->input->post('parent') ? $this->input->post('parent') : null),
			'class_id' => $this->input->post('class_id'),
			);
		if (!$this->input->post('id')) {
			$id = $this->gl_model->write_chart_types($items);
			echo json_encode(array('result'=>'success','msg'=>"Successfully added new Account Type"));
		} else {
			$id = $this->input->post('id');
			if ($items['parent'] == $id) {
				echo json_encode(array('result'=>'error','msg'=>"Account Type cannot become sub-type of itself"));
			} else {
				$this->gl_model->change_chart_types($items,array('id'=>$id));
				echo json_encode(array('result'=>'success','msg'=>"Successfully updated Account Type"));
			}
		}
	}
	public function accounts($ref='')
	{
		$data = $this->syter->spawn('general_ledger');
		if ($ref) {
			$this->accounts_container($ref,$data);
		} else {
			$results = $this->gl_model->get_chart_master();
			$data['page_subtitle'] = "GL Accounts Management";
			$data['code'] = build_accounts_display($results);
		}
		$data['load_js'] = "core/general_ledger.php";
		$data['use_js'] = "accountFormContainerJs";
		$this->load->view('page',$data);
	}
	private function accounts_container($ref,&$data)
	{
		if (!strcasecmp($ref, 'new')) {
			$data['page_subtitle'] = "New Account Type";
		} else {
			$data['page_subtitle'] = "Edit Account Type";
		}
		$data['code'] = build_account_container($ref);
	}
	public function account_form($ref)
	{
		$account_type = array();
		if (!strcasecmp($ref, 'new')) {
			$data['page_subtitle'] = "New GL Account";
		} else {
			$results = $this->gl_model->get_chart_master(array('chart_master.account_code'=>$ref));
			if ($results)
				$account_type = $results[0];
			$data['page_subtitle'] = "Edit GL Account";
		}
		$data['code'] = build_account_form($account_type);
		$data['load_js'] = "core/general_ledger.php";
		$data['use_js'] = "accountFormJs";
		$this->load->view('load',$data);
	}
	public function account_db()
	{
		if (!$this->input->post())
			header('Location:'.base_url().'accounts');

		$checker = $this->gl_model->get_chart_master(array('chart_master.account_code'=>$this->input->post('account_code')));
		$items = array(
			'account_name' => $this->input->post('account_name'),
			'account_type' => $this->input->post('account_type'),
			'tax_type_id' => $this->input->post('tax_type_id')
			);
		if (!$checker) {
			$items['account_code'] = $this->input->post('account_code');
			$result = $this->gl_model->write_chart_master($items);
			echo json_encode($result);
		} else {
			$this->gl_model->change_chart_master($items,array('account_code'=>$this->input->post('account_code')));
			echo json_encode(array('result'=>'success','msg'=>'Successfully updated account'));
		}
	}
}