<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Po_inquiries extends CI_Controller {
	var $data = null;
	public function __construct()
	{
		parent::__construct();
		$this->load->model('core/po_inquiries_model');
		$this->load->model('site/site_model');
		$this->load->helper('core/po_helper');
		$this->load->helper('core/po_inquiries_helper');
		$this->load->model('core/po_model');
		$this->load->model('core/main_model');
		$this->load->helper('pdf_helper');
	}
	public function index()
	{

	}
	public function approval_inquiry_container($act_tabs = null){
		
		//$act_tabs = $this->input->post('tab_action');

		$data = $this->syter->spawn('inventory');
		$data['page_title'] = "Approval Inquiry";
		$data['code'] = approval_header_page($act_tabs);
        $data['load_js'] = 'core/po_inquiries.php';
        $data['use_js'] = 'approvalInquiryJs';
        $this->load->view('page',$data);
	}
	// PO Approval - Mhae (start)
	public function purchase_orders_approval($ref='')
	{
		$data = $this->syter->spawn('purchasing');
		$data['page_subtitle'] = "Puchase Movements Approval";
		$Category = $this->po_inquiries_model->get_purchase_orders_approval();
		//echo $this->db->last_query();
		
        $data['add_js'] = 'js/site_list_forms.js';
        $data['load_js'] = "core/po_inquiries.php";
        $data['use_js'] = "PurchaseOrdersApprovalJS";
		
		$data['code'] = purchase_orders_approval($Category);
		$this->load->view('load',$data);
	}
	public function reject_added_purchase_orders($ref='')
	{
		$user = $this->session->userdata('user');
		$_id = $this->input->post('_id');
		$remarks = $this->input->post('remarks');	
		$items = array(
			'status' => 2,
			'posted_by' => $user['id'],
			'date_posted'=> date("Y-m-d H:i:s"),
			'approval_remarks' => $remarks
		);
		$results = $this->po_inquiries_model->reject_added_purchase_orders($items, $_id);
		##########AUDIT TRAIL [START]##########
			$audit_items = array(
			'type'=>0,
			'trans_no'=>0,
			'type_desc'=>REJECTED_PURCHASE_ORDER,
			'description'=>'id:'.$_id.'||remarks:"'.$remarks.'"',
			'user'=>$user['id']
			);
			
			$audit_id = $this->po_inquiries_model->write_to_audit_trail($audit_items);
		##########AUDIT TRAIL [END]##########
		echo $results;
	}
	public function approve_added_purchase_orders($ref='')
	{
		$this->load->model('core/main_model');
		$id = $this->input->post('_id');	
		$user = $this->session->userdata('user');
		$results = $this->main_model->approve_added_purchase_orders($id, $user['id']);
		$result_ = $this->po_inquiries_model->get_purchase_orders_approval($id);
		foreach($result_ as $val){
			$branch_code  = $this->po_inquiries_model->get_branch_code($val->branch_id);
			$created_by  = $this->po_inquiries_model->get_user_name($val->created_by);
			$delivery_date = $val->delivery_date; 
		}
		##########AUDIT TRAIL [START]##########
			$audit_items = array(
			'type'=>0,
			'trans_no'=>0,
			'type_desc'=>APPROVED_PURCHASE_ORDER,
			'description'=>'id:'.$id.'||branch_code:"'.$branch_code.'||created_by:"'.$created_by.'||delivery_date:"'.date('Y-M-d', strtotime($delivery_date)).'"',
			'user'=>$user['id']
			);
			
			$audit_id = $this->po_inquiries_model->write_to_audit_trail($audit_items);
		##########AUDIT TRAIL [END]##########
		echo $results ;
	}
	public function get_all_checked_added_purchased_order()
	{
		$this->load->model('core/main_model');
		$ids = $this->input->post('ids');	
		$user = $this->session->userdata('user');
	//	echo $ids;
		$num = 0;
		
		$purchase_ids = array();
		$ids_count = count($ids); 
				while($ids_count != $num){
						$num = $num + 1;
					$con_id  = explode('|',$ids[$num-1]);
					if($con_id[0] == 'true'){
						array_push($purchase_ids,$con_id[1]);
					$result_ = $this->po_inquiries_model->get_purchase_orders_approval($con_id[1]);
					foreach($result_ as $val){
						$branch_code  = $this->po_inquiries_model->get_branch_code($val->branch_id);
						$created_by  = $this->po_inquiries_model->get_user_name($val->created_by);
						$delivery_date = $val->delivery_date; 
					}
					##########AUDIT TRAIL [START]##########
						$audit_items = array(
						'type'=>0,
						'trans_no'=>0,
						'type_desc'=>APPROVED_PURCHASE_ORDER,
						'description'=>'id:'.$con_id[1].'||branch_code:"'.$branch_code.'||created_by:"'.$created_by.'||delivery_date:"'.date('Y-M-d', strtotime($delivery_date)).'"',
						'user'=>$user['id']
						);
						
						$audit_id = $this->po_inquiries_model->write_to_audit_trail($audit_items);
					##########AUDIT TRAIL [END]##########
					}
				}
		$results = $this->main_model->multiple_approve_added_purchase_orders($purchase_ids, $user['id']);
		echo $results;
		//echo $movement_ids;
	}
	// PO Approval - Mhae (end)
	//----------PO ENTRY POP-UP VIEW----------APM----------START
	public function po_entry_popup($po_id){
		// echo "Purchase Order No: ".$po_id."<br>";
		$res = $this->po_model->get_purch_orders($po_id);
		$sub_items = $this->po_model->get_purch_order_details($po_id);
		$items = $res[0];
		$data['code'] = build_po_entry_popup_form($po_id, $items, $sub_items);
		$data['add_js'] = 'js/site_list_forms.js';
		$data['load_js'] = "core/po_inquiries.php";
		$data['use_js'] = "poEntryPopJS";
		$this->load->view('load',$data);
	}
	//----------PO ENTRY POP-UP VIEW----------APM----------END
	public function po_lists_inquiry_container($act_tabs = null){
		
		//$act_tabs = $this->input->post('tab_action');

		$data = $this->syter->spawn('inventory');
		$data['page_title'] = "Purchase Order List";
		$data['code'] = po_lists_header_page($act_tabs);
        $data['load_js'] = 'core/po_inquiries.php';
        $data['use_js'] = 'approvalInquiryJs';
        $this->load->view('page',$data);
	}
	public function po_lists($ref='')
	{
		$data = $this->syter->spawn('purchasing');
		$data['page_subtitle'] = "Puchase Movements Approval";
		$Category = $this->po_inquiries_model->get_purchase_orders_approval();
		//echo $this->db->last_query();
		
        $data['add_js'] = 'js/site_list_forms.js';
        $data['load_js'] = "core/po_inquiries.php";
        $data['use_js'] = "PurchaseOrdersApprovalJS";
		
		$data['code'] = purchase_order_lists($Category);
		$this->load->view('load',$data);
	}
	//----------APM----------START
	public function send_email($type=null, $details=null){
		 $mail = new PHPMailer();
		 
		 $this->load->model('core/mail_model');
		 
		$thisrow = $this->mail_model->email_configuration();
		$e_config = $thisrow[0];

		//------------GMAIL
        $mail->IsSMTP(); // we are going to use SMTP
        $mail->SMTPAuth   = true; // enabled SMTP authentication
        $mail->SMTPSecure = "ssl";  // prefix for secure protocol to connect to the server
        $mail->Host       = $e_config->host_name; //"smtp.gmail.com";      // setting GMail as our SMTP server
        $mail->Port       = $e_config->port_number;  //465;                   // SMTP port to connect to GMail
        $mail->Username   = $e_config->username; //"myusername@gmail.com";  // user email address
        $mail->Password   = $e_config->password; //"testmail00000"; //"password";            // password in GMail
        // $mail->SetFrom('mytest.email00000@gmail.com', 'HRIS');  //Who is sending the email
        $mail->SetFrom($e_config->sender_email, 'DATACENTER');  //Who is sending the email
        // $mail->AddReplyTo("allynmacalinao@yahoo.com","Firstname2 Lastname2");  //email address that receives the response
		
		switch($type){
			case 'test' : 
				// $mail->Subject    = $details['emp_full_name']." - Employee Update for Approval";
				
				$mail->Subject    = "Extension of Delivery Date for PO #".$details['order_no'];
					$body = "<p>Good day ".$details['supplier_name'].",</p>
									<br>
									Delivery Date for unserved PO # ".$details['order_no']." was changed from ".date('M-d-Y', strtotime($details['old_delivery_date']))." to <b>".date('M-d-Y', strtotime($details['new_delivery_date']))."</b>
									<br>
									<!--a href='http://tumblr.com'>Click this link to redirect...</a-->
									<b><i>Kindly deliver on or before the expected delivery date.</i></b>
									<br>
									<br>
									<hr>
									<label style='font-size: 12px; font-family: Trebuchet MS; color: red;'>This is a system generated email. Please do not reply to this message.</label>
									";
					// $mail->Body      = $body; //alt
					$mail->MsgHTML($body);
					$mail->AltBody    = "To view the message, please use an HTML compatible email viewer."; // optional, comment out and test
					
					// echo var_dump($e_config);
					
					//one recipient
					$hr_email = "allynmacalinao@gmail.com";
					// $hr_email = $e_config->sender_email;
					$mail->AddAddress($hr_email, $details['supplier_name']);
					
					/* //many recipients
					$recipients = array('allynmacalinao@yahoo.com' => 'HR Dept. Head');
					foreach($recipients as $email => $name)
					{
					   $mail->AddAddress($email, $name);
					   // $mail->AddCC($email, $name); //for CC
					}
					*/
					
					/*$mail->AddAttachment('system_attachments/Requirements.txt');
					$mail->AddAttachment('system_attachments/Map.jpg');*/
					break; //end of hr_emp_log_notification
		}
		
		if(!$mail->Send()) {
			// echo "=====Di nagsend====".$mail->ErrorInfo;
            // $data["message"] = "Error: " . $mail->ErrorInfo;
			// display_msg("error","Error: " . $mail->ErrorInfo);
			// echo $mail->ErrorInfo;
			echo "warning";
			$mail->ClearAddresses();
			$mail->ClearAttachments();
        } else {
            // echo "=====Nagsend";
			// $data["message"] = "Message sent correctly!";
			$mail->ClearAddresses();
			$mail->ClearAttachments();
			// display_msg("success","Request sent!");
			// echo "Request Sent!";
			echo "success";
        }
		 
	}
	//----------APM----------START
}