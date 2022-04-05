<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sales_reports extends CI_Controller {
    var $data = null;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('core/sales_model');
        $this->load->model('site/site_model');
        $this->load->helper('site/site_forms_helper');
        $this->load->helper('core/sales_reports_helper');
        $this->load->helper('pdf_helper');
    }
    ###############################################################################################################
    #
    #       S E A R C H   F U N C T I O N S
    #
    ###############################################################################################################
    public function search_inventory()
    {
        if ( !$this->input->post() )
            header('sales/reports/item_sales');

        $reference = $this->input->post('q');
        $items = $this->sales_model->search_items($reference);
        $json_array = array();
        foreach ($items as $res) {
            $json_array[] = array(
                'Id'=>$res->id,
                'Text'=>$res->name,
                'Subtext' => $res->item_code,
            );
        }
        echo json_encode($json_array);
    }
    public function search_debtor()
    {
        if ( !$this->input->post() )
            header('sales/reports/customer_balances');

        $reference = $this->input->post('q');
        $debtors   = $this->sales_model->search_debtors($reference);
        $json_array = array();
        foreach ($items as $res) {
            $json_array[] = array(
                'Id'   => $res->debtor_id,
                'Text' => $res->name
            );
        }
        echo json_encode($json_array);
    }
    /*
    public function search_sales_delivery()
    {
        if (!$this->input->post())
            header('Location:pending_deliveries');

        $reference = $this->input->post('q');

        $where_array = array();
        $where_array[] = array('key'=>'debtor_trans.trans_type','value'=>DELIVERY_NOTE,'escape'=>true);
        $where_array[] = array('key'=>'debtor_trans.tar_trans_type IS NULL','value'=>null,'escape'=>false);
        $where_array[] = array('key'=>'debtor_trans.tar_type_no IS NULL','value'=>null,'escape'=>false);
        if ($reference !== "")
            $where_array[] = array('key'=>'debtor_trans.reference LIKE ','value'=>"%$reference%",'escape'=>true);

        $results = $this->sales_model->get_delivery_header($where_array,true,10);

        $json_array = array();
        foreach ($results as $val) {
            $json_array[] = array(
                'Id' => $val->id,
                'Text' => $val->reference,
                'Subtext' => '<br/>'.$val->customer_branch.'<br/>Created on '.$val->created_on
                );
        }
        echo json_encode($json_array);
    }
    */
    ###############################################################################################################
    #
    #       R E P O R T    P A G E S
    #
    ###############################################################################################################
    /**
     * Sales report by item
     * @return null
     */
    public function item_sales()
    {
        $data = $this->syter->spawn('sales');

        $data['page_title'] = fa('fa fa-cube')." Item Sales";
        $data['page_subtitle'] = "Sales Report by item";
        $data['code'] = build_item_sales_report();
        $data['add_js'] = array(
            'js/plugins/bootstrap-select/bootstrap-select.min.js',
            'js/plugins/bootstrap-select/ajax-bootstrap-select.min.js',
            'js/plugins/daterangepicker/daterangepicker.js'
        );
        $data['add_css'] = array(
            'css/bootstrap-select/bootstrap-select.css',
            'css/bootstrap-select/ajax-bootstrap-select.css',
            'css/daterangepicker/daterangepicker-bs3.css'
        );
        $data['load_js'] = 'core/sales_reports.php';
        $data['use_js'] = 'itemsSalesJs';
        $this->load->view('page',$data);
    }
    /**
     * Loads Item search result
     * @return null
     */
    public function item_sales_results()
    {
        if ( !$this->input->post() )
            header(base_url().'sales/reports/item_sales');

        $daterange = $this->input->post('daterange');
        $dates = explode(" to ",$daterange);
        $date_from = (empty($dates[0]) ? date('Y-m-d') : date('Y-m-d',strtotime($dates[0])));
        $date_to = (empty($dates[1]) ? date('Y-m-d') : date('Y-m-d',strtotime($dates[1])));
    }
    /**
     * Customer balances
     * @return null
     */
    public function customer_balances()
    {
        $data = $this->syter->spawn('sales_reports');

        $data['page_title'] = fa('fa-question-circle')." Customer Balances";

        $data['code'] = build_customer_balances();
        $data['add_css'][] = 'css/daterangepicker/daterangepicker-bs3.css';
        $data['add_js'][] = 'js/plugins/daterangepicker/daterangepicker.js';
        $data['load_js'] = 'core/sales_reports.php';
        $data['use_js'] = 'customerBalancesSearchJs';
        $this->load->view('page',$data);
    }
    /**
     * Loads Customer balances result
     * @return null
     */
    public function customer_balances_result()
    {
        if (!$this->input->post())
            header(base_url().'sales/reports/customer_balances');

        $debtor_id   = $this->input->post('debtor_id') ?: "";
        $ending_date = $this->input->post('ending_date');
        $ending_date = $ending_date ? date('Y-m-d',strtotime($ending_date)) : date('Y-m-d');


        $debtors = $this->sales_model->search_debtors("",$debtor_id);

        $where_array = array();
        $where_array[] = array('key'=>'debtor_trans.trans_date <=','value'=>$ending_date,'escape'=>true);
        if ($debtor_id)
            $where_array[] = array('key'=>'debtor_trans.debtor_id','value'=>$debtor_id,'escape'=>true);

        $previous_balances = $this->sales_model->debtor_previous_balances($where_array);
        $current_balances  = $this->sales_model->debtor_bal_transactions($where_array);

        $rows = array();
        foreach ($debtors as $val) {
            $rows[$val->debtor_id] = array(
                'code' => $val->debtor_code,
                'name' => $val->name,
                'data' => array());
        }
        foreach ($previous_balances as $vv) {
            if (!isset($rows[$vv->debtor_id]))
                continue;

            $rows[$vv->debtor_id]['data']['prev'][$vv->fiscal_end] = $vv->balance;
        }
        foreach ($current_balances as $xx=>$vvv) {
            if (!isset($rows[$vvv->debtor_id]))
                continue;


            $rows[$vvv->debtor_id]['data']['curr'][] =
                array(
                    'trans_name'       => $vvv->trans_name,
                    'trans_ref'        => $vvv->trans_ref,
                    'trans_date'       => $vvv->trans_date,
                    'due_date'         => $vvv->due_date,
                    'trans_amount'     => $vvv->trans_amount,
                    'allocated_amount' => $vvv->allocated_amount,
                );
        }
        if ($this->session->userdata('_customer_bals')) {
            $this->session->unset_userdata('_customer_bals');
        }
        $this->session->set_userdata('_customer_bals',array('rows'=>$rows,'end_date'=>$ending_date));
        if ($this->input->post('as_pdf')) {
            $this->customer_balances_pdf();
            return;
        }

        $data['code'] = build_customer_balances_result($rows);
        $data['load_js'] = 'core/sales_reports.php';
        $data['use_js'] = 'customerBalancesResultsJs';
        $this->load->view('load',$data);
    }
    public function customer_balances_pdf()
    {
        $bal = $this->session->userdata('_customer_bals');
        $user = $this->session->userdata('user');

        $current_fiscal_year = $this->site_model->get_custom_val('fiscal_years',array('begin_date','end_date'),'is_closed',0);

        if (!$bal) {
            site_alert('Customer balances information has not been found. Unable to load PDF.');
            header('Location:'.base_url().'sales/reports/customer_balances');
        }

        $data['rows'] = $bal['rows'];
        $data['end_date'] = $bal['end_date'];
        $data['user'] = $user;
        $data['curr_fiscal_year'] = $current_fiscal_year;
        $this->load->view('contents/prints/print_customer_balances',$data);
    }
    public function tester()
    {
        $as = $this->sales_model->debtor_bal_transactions();
    }
}