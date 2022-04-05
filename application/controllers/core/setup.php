<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setup extends CI_Controller {
	//-----------Branch Details-----start-----allyn
	public function details(){
        $this->load->model('core/setup_model');
        $this->load->helper('core/setup_helper');
        $details = $this->setup_model->get_details(1);
		$det = $details[0];
        $data = $this->syter->spawn('setup');
        //$data['page_subtitle'] = 'Edit Branch Setup';
        $data['code'] = makeDetailsForm($det);
        // $data['add_js'] = array('js/plugins/timepicker/bootstrap-timepicker.min.js');
        // $data['add_css'] = array('css/timepicker/bootstrap-timepicker.min.css');
		$data['load_js'] = 'core/setup.php';
		$data['use_js'] = 'detailsJs';
        $this->load->view('page',$data);
    }
    public function details_db(){
        $this->load->model('core/setup_model');

        // $img = '';
        // $img = $_FILES['complogo']['tmp_name'];
            // $img = file_get_contents($tmp_name);
        // if(is_uploaded_file($_FILES['complogo']['tmp_name'])){
        //     $tmp_name = $_FILES['complogo']['tmp_name'];
        //     $img = file_get_contents($tmp_name);
        // }
        // echo 'IMAGE : '.$img;

        if($this->input->post('sil') != null){
            $sil = 1;
        }else{
            $sil = 0;
        }
        if($this->input->post('scl') != null){
            $scl = 1;
        }else{
            $scl = 0;
        }
        if($this->input->post('spl') != null){
            $spl = 1;
        }else{
            $spl = 0;
        }


        $items = array(
            "company_name"=>$this->input->post('company_name'),
            "tax_ref"=>$this->input->post('tax_ref'),
            "currency"=>$this->input->post('currency'),
            "address"=>$this->input->post('address'),
            "email"=>$this->input->post('email'),
            "address"=>$this->input->post('address'),
            "domicile"=>$this->input->post('domicile'),
            "official_no"=>$this->input->post('official_no'),
            "tax_prd"=>$this->input->post('tax_prd'),
            "tax_last_prd"=>$this->input->post('tax_last_prd'),
            "fiscal_year"=>$this->input->post('fiscal_year'),
            "phone"=>$this->input->post('phone'),
            "facsimile_no"=>$this->input->post('facsimile_no'),
            "dimension" => $this->input->post('dimension'),
            "price_calc" => $this->input->post('price_calc'),
            "sil" => $sil,
            "scl" => $scl,
            "spl" => $spl,
            // "img"=>$img
            // "currency"=>$this->input->post('currency')
        );

            $this->setup_model->update_details($items, 1);
            // $id = $this->input->post('cat_id');
            $act = 'update';
            $msg = 'Company Setup has been updated';

        echo json_encode(array('msg'=>$msg));
    }
	//-----------Branch Details-----end-----allyn
}