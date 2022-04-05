<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Audit extends CI_Controller {
	var $data = null;
	public function __construct()
	{
		parent::__construct();
		$this->load->model('core/audit_model');
		$this->load->model('site/site_model');
		$this->load->helper('core/audit_helper');
	}
	public function index($act_tabs = null)
	{
		$data = $this->syter->spawn('audit');
		$data['page_title'] = "Audit Trail";
		$data['code'] = audit_header_page($act_tabs);
        $data['load_js'] = 'core/audit.php';
        $data['use_js'] = 'AuditTabJs';
        $this->load->view('page',$data);
	}
	public function audit_trail($ref='')
	{
		$data = $this->syter->spawn('audit');
		// if ($ref) {
			// $this->stocks_container($ref,$data);
		// } else {
			$data['page_subtitle'] = "Audit Trail";
			$results = $this->audit_model->get_audit_trail();
		// }

        $data['add_js'] = 'js/site_list_forms.js';
		$data['load_js'] = "core/audit.php";
		$data['use_js'] = "auditJs";
		$data['code'] = build_audit_trail_list($results);
		$this->load->view('load',$data);
		
		
	
	}
	
}