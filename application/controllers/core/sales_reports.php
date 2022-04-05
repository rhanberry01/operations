<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sales_reports extends CI_Controller {
	var $data = null;
	public function __construct()
	{
		parent::__construct();
		$this->load->model('core/sales_reports_model');
		$this->load->model('site/site_model');
		$this->load->helper('core/sales_reports_helper');
	}
	public function index()
	{
		$data = $this->syter->spawn('sales_reports');
		$data['page_subtitle'] = "Sales Reports";
		$data['code'] = sales_reports();
		$data['add_js'] = 'js/site_list_forms.js';
        $data['load_js'] = "core/sales_reports.php";
        $data['use_js'] = "salesReportsJs";
		$this->load->view('page',$data);
	}
	public function reports($branch_id, $occurrence_id){
		date_default_timezone_set('Asia/Manila');
		$this->load->library('My_TCPDF');
		// $pdf = new TCPDF("P", "mm", 'FOLIO', true, 'UTF-8', false);
		$pdf = new TCPDF("L", PDF_UNIT, 'Folio', false, 'UTF-8', false);
		
		$logo = BASEPATH.'../img/header_logo.png';
		$occurence = '';
		$main_items = $this->sales_reports_model->get_branch_details($branch_id);
		$this_item = $main_items[0];
		//$sub_items = $this->po_model->get_purch_order_details($po_order_no);
		if($occurrence_id == 0)
			$occurrence = 'Daily Sales';
		else if($occurrence_id == 1)
			$occurrence = 'Monthly Sales';
		else if($occurrence_id == 2)
			$occurrence = 'Yearly Sales';
			
		$filename = "Sales Reports.pdf";
		$title = "Sales Reports ".$this_item->name;
		//$tin = $this->po_model->get_branch_tin(branch_id);
		
		//$supplier = $this->po_model->get_supplier_details($this_item->supplier_id);
		//$supplier_det = $supplier[0];
		
		//$pdf->po_no = $this_item->reference;
		
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_BOTTOM);
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(true);
		
		$pdf->AddPage();
		
		$pdf->SetFont('helvetica', 'B', 15);
		$pdf->Image($logo,10,10,0,20);
		$pdf->Cell(265, 15, $this_item->name, 0, false, 'R', 0, '', 0, false, 'M', 'M');
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(10, 100, 'TIN: '.$this_item->tin, 0, false, 'L', 0, '', 0, false, 'M', 'M');
		$pdf->Ln(5);
        $pdf->SetFont('helvetica', 'B', 12);
		$pdf->Cell(300, 15,$occurrence, 0, false, 'R', 0, '', 0, false, 'M', 'M');
        $pdf->Ln(5);
        $pdf->SetFont('helvetica', 'B', 12);
		$pdf->Cell(300, 15, 'Terminal', 0, false, 'R', 0, '', 0, false, 'M', 'M');
        $pdf->Ln(5);
        $pdf->SetFont('helvetica', 'B', 12);
		$pdf->Cell(300, 15, "PERMIT NO:", 0, false, 'R', 0, '', 0, false, 'M', 'M');
        $pdf->Ln(5);
		$pdf->SetFont('helvetica', 'B', 12);
		$pdf->Cell(300, 15, 'MIN:', 0, false, 'R', 0, '', 0, false, 'M', 'M');
		
		// $w = array(70, 90, 55,60);
		// $pdf->Ln(10);
		// $pdf->SetFont('helvetica', null, 10);
		// $pdf->Cell(80, 15, "Supplier", 0, false, 'L', 0, '', 0, false, 'M', 'M');
		// $pdf->Cell(100, 15, "Recieve At", 0, false, 'L', 0, '', 0, false, 'M', 'M');
		
		// $pdf->Ln(1.5);
		// $pdf->SetFont('helvetica', 'B', 12);
		// $pdf->MultiCell(80, 15,$supplier_det->supp_name,0,'L',false,0);
		// $pdf->MultiCell(100, 15, COMPANY_NAME,0,'L',false,1);
		
		// $pdf->SetFont('helvetica', null, 9);
		// $pdf->Cell(80, 15, $supplier_det->address, 0, false, 'L', 0, '', 0, false, 'M', 'M');
		// $pdf->Cell(100, 15, $this_item->delivery_address, 0, false, 'L', 0, '', 0, false, 'M', 'M');
		// $pdf->SetFont('helvetica', 'B', 12);
		// $pdf->Ln(4);
		// $pdf->SetFont('helvetica', null, 9);
		// $pdf->Cell(80, 15, $supplier_det->contact_person, 0, false, 'L', 0, '', 0, false, 'M', 'M');
		// $pdf->Cell(100, 15, $tin, 0, false, 'L', 0, '', 0, false, 'M', 'M');
		$pdf->Ln(5); 
		
		$pdf->SetFont('helvetica', 'B',8);
		$header = array();
		$header = array('Date', "INV. # \n FROM", "INV. # \n TO", 'ENDING BALANCE',' TOTAL SALES ', 'VAT' , 'VATable SALES', 'VAT Excempt', 'ZERO RATED SALES', 'LINE DISCOUNT', 'SENIO CITIZEN DISCOUNT', 'PWD DISCOUNT', 'RETURNS', 'VOID', 'Z COUNTER');
		// $header2 = array('', 'FROM', 'TO','', '' , '', '', '', 'LINE DISCOUNT', 'SENIO CITIZEN DISCOUNT', 'PWD DISCOUNT', 'RETURNS', 'VOID', 'Z COUNTER');
	    // Header
	    // $w = array(20, 30, 20, 20, 20, 25, 25, 20, 20, 20, 20, 20, 20, 20);
	    $w = array(20, 30, 30, 20, 20, 20, 25, 25, 20, 20, 20, 20, 20, 20, 20);
	    $num_headers = count($header);
	    for($i = 0; $i < $num_headers; $i++) {
	        if($i > 2){
				$pdf->Cell($w[$i], 10, $header[$i], 1, 0, 'R', false, 0, 1, true);
	        }
	        else
		        $pdf->Cell($w[$i], 10, $header[$i], 1, 0, 'L', false, 0, 1, true);
	    }
        $pdf->Ln(6);
		//Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='M') {
		 $fill = 0;
		// $po_total=0;
	    // $qty_total=0;
		
		// foreach($sub_items as $val){
			// $pdf->SetFont('courier', null, 8);
	        // $pdf->Cell($w[0], 6, $this->po_model->get_supplier_stock_code_from_stock_id($val->stock_id), 0, 0, 'L', $fill);
			// $pdf->SetFont('courier', 'B', 9);
	        // $pdf->Cell($w[1], 6, ' '.$val->description, 0, 0, 'L', $fill);
	        // $pdf->Cell($w[2], 6, ' '.$val->uom, 0, 0, 'L', $fill);
	        // $pdf->Cell($w[3], 6, ' '.num($val->qty_ordered).' ', 0, 0, 'R', $fill);
	        // $pdf->Cell($w[4], 6, ' '.num($val->unit_cost).' ', 0, 0, 'R', $fill);
	       	// // $total = $row->ord_qty * $row->unit_price; //original
	       	// $total = $val->extended;
	        // // $discTxt = "";
			// // if($row->discounts != "" || $row->discounts != 0){
				// // $discounts = explode(',', $row->discounts);
				// // foreach ($discounts as $discs) {
					// // $disc = explode('=>',$discs);
					// // if (count($disc) <= 1)
						// // continue;
					// // $discTxt .= $disc[0];
					// // $total -= $disc[1];
				// // }
			// // }
	        // $pdf->Cell($w[5], 6, num($total), 0, 0, 'R', $fill);
	        // $po_total += $total;
	        // $qty_total += $val->qty_ordered;
	        // $pdf->Ln(4);
		// }
		
		// //~~~~~~~~~FOR TOTALS~~~~~~~~~~//
		// $pdf->SetFont('courier', null, 9);
		// $pdf->Ln(6);
		// $pdf->Cell($w[0], 6, '', 0, 0, 'L', $fill);
        // $pdf->Cell($w[1], 6, '', 0, 0, 'L', $fill);
        // $pdf->SetFont('helvetica', 'B', 14);
        // $pdf->Cell($w[2], 6, '', 0, 0, 'R', $fill);
        // $pdf->Cell($w[3], 6, 'Total Qty', 0, 0, 'R', $fill);
        // $pdf->Cell($w[4], 6, null, 0, 0, 'R', $fill);
		
		// $pdf->SetFont('helvetica', 'B', 14);
        // $pdf->Cell($w[5], 6, 'Grand Total', 0, 0, 'R', $fill);
		
		// $pdf->Ln(6);
        // $pdf->Cell($w[0], 6, '', 0, 0, 'L', $fill);
        // $pdf->Cell($w[1], 6, '', 0, 0, 'L', $fill);
        // $pdf->SetFont('helvetica', 'B', 14);
        // $pdf->Cell($w[2], 6, '', 0, 0, 'R', $fill);
        // $pdf->Cell($w[3], 6, num($qty_total), 0, 0, 'R', $fill);
		
		// $pdf->Cell($w[4], 6, null, 0, 0, 'R', $fill);
		
		// $pdf->SetFont('helvetica', 'B', 14);
        // $pdf->Cell($w[5], 6,  num($po_total), 0, 0, 'R', $fill);
		
		// $pdf->Ln(8);
		
		// if ($pdf->GetY() > $pdf->getPageHeight() - (PDF_MARGIN_BOTTOM+13))
			// $pdf->AddPage();
		
		// $pdf->SetFont('helvetica', 'B', 12);
   		// $pdf->Cell($w[0], 6, "Remarks", 0, 0, 'L', $fill);
   		// $pdf->SetFont('helvetica', '', 8);
        // $pdf->Cell($w[1], 6, null, 0, 0, 'R', $fill);
        // $pdf->Cell($w[2], 6, null, 0, 0, 'R', $fill);
        // $pdf->Cell($w[3], 6, null, 0, 0, 'R', $fill);
        // $pdf->Cell($w[4], 6, null, 0, 0, 'R', $fill);
        // $pdf->Cell($w[5], 6, null, 0, 0, 'L', $fill);
		
		// if(count($this_item->comments) > 0 )
		// {
	        // $pdf->Ln(5);
			// $pdf->SetFont('helvetica', null, 11);
	   		// $pdf->Cell($w[0], 6, $this_item->comments, 0, 0, 'L', $fill);
	        // $pdf->Cell($w[1], 6, null, 0, 0, 'R', $fill);
	        // $pdf->Cell($w[2], 6, null, 0, 0, 'L', $fill);
	        // $pdf->Cell($w[3], 6, null, 0, 0, 'R', $fill);
	        // $pdf->Cell($w[4], 6, null, 0, 0, 'R', $fill);
	        // $pdf->Cell($w[5], 6, null, 0, 0, 'R', $fill);
    	// }
		
        // $pdf->Ln();
		
		// //~~~~~~~~~FOR SIGNATURES~~~~~~~~~~//
		// // $prepared_by = $this->po_model->get_po_prepared_by(16, $branch->order_no);
		// // $prepared_by_sign = $prepared_by[0]->sign;
		// // $prepared_by = $prepared_by[0]->prepared_by;
		
		// // $approved_by = $this->po_model->get_po_approved_by(16, $branch->order_no);
		// // $approved_by_sign = $approved_by[0]->sign;
		// // $approved_by = $approved_by[0]->approved_by;
		
		// $prepared_by = $this_item->created_by;
		// $prepared_by_sign = $this_item->created_by;
		
		// $approved_by = $this_item->posted_by;
		// $approved_by_sign = $this_item->posted_by;
		
		// $p_sign = BASEPATH.'../signatures/'.$prepared_by_sign.'.png';
		// $a_sign = BASEPATH.'../signatures/'.$approved_by_sign.'.png';

		// if ($pdf->GetY() > $pdf->getPageHeight() - (PDF_MARGIN_BOTTOM+150))
			// $pdf->AddPage();
			
		// $pdf->SetY($pdf->getPageHeight() - (PDF_MARGIN_BOTTOM+150));
		// $ww = 43;
		
		// $pdf->SetFont('helvetica', '', 10);
		// $pdf->Cell($ww-5, 5, '', 'LT', 0, 'L', $fill);
		// $pdf->SetFont('helvetica', 'B', 10); 
   		// $pdf->Cell($ww, 5, '', 'RT', 0, 'L', $fill);
		// $pdf->SetFont('helvetica', '', 10);
   		// $pdf->Cell($ww-4, 5, '', 'LT', 0, 'L', $fill);
		// $pdf->SetFont('helvetica', 'B', 10);
		// $pdf->Cell($ww, 5, '', 'RT', 0, 'L', $fill);
		// $pdf->SetFont('helvetica', '', 10);
   		// $pdf->Cell($ww-3, 5, '', 'LT', 0, 'L', $fill);
		// $pdf->SetFont('helvetica', 'B', 10);
		// $pdf->Cell($ww, 5, '', 'RT', 0, 'L', $fill);
		// $pdf->SetFont('helvetica', '', 10);
   		// $pdf->Cell($ww-2, 5, '', 'LT', 0, 'L', $fill);
		// $pdf->SetFont('helvetica', 'B', 10);
		// $pdf->Cell($ww, 5, '', 'RT', 0, 'L', $fill);
        // $pdf->Ln();
		
		
		// $pdf->SetFont('helvetica', '', 10);
   		// $pdf->Cell($ww-13, 6, 'Prepared by: ', 'LB', 0, 'L', $fill);
		// $pdf->SetFont('helvetica', 'B', 10);
   		// $pdf->Cell($ww+6, 6, $this->po_model->get_user_name($prepared_by), 'RB', 0, 'L', $fill);
		// $pdf->SetFont('helvetica', '', 10);
   		// $pdf->Cell($ww-8, 6, 'Checked by: ', 'LB', 0, 'L', $fill);
		// $pdf->SetFont('helvetica', 'B', 10);
		// $pdf->Cell($ww, 6, '', 'RB', 0, 'L', $fill);
		// $pdf->SetFont('helvetica', '', 10);
   		// $pdf->Cell($ww-13, 6, 'Approved by: ', 'LB', 0, 'L', $fill);
		// $pdf->SetFont('helvetica', 'B', 10);
		// $pdf->Cell($ww+5, 6, ($approved_by != '' ? $this->po_model->get_user_name($approved_by) : ''), 'RB', 0, 'L', $fill);
		
		
		// if ($prepared_by_sign != ''){
			// $pdf->Image($p_sign,30,244,0,20);
		// }

		// if ($approved_by_sign != ''){
			// // $pdf->Image($a_sign,154,249,0,20);
			// $pdf->Image($a_sign,154,244,0,20);
		// }
		
		// // $pdf->Ln();
		
		// $pdf->SetFont('helvetica', null, 8);
		// $pdf->SetY($pdf->getPageHeight() - (PDF_MARGIN_BOTTOM+4));
		// // $pdf->SetY($pdf->getPageHeight() - (PDF_MARGIN_BOTTOM));
		
		return $pdf->Output($filename, 'I');
		
	}
	public function e_sales($branch_id, $occurrence_id){
		date_default_timezone_set('Asia/Manila');
		$this->load->library('My_TCPDF');
		$CI =& get_instance();
		
		$pdf = new TCPDF("L", PDF_UNIT, 'Folio', false, 'UTF-8', false);
		
		$logo = BASEPATH.'../img/header_logo.png';
		$occurence = '';
		$main_items = $this->sales_reports_model->get_branch_details($branch_id);
		$this_item = $main_items[0];
		//$sub_items = $this->po_model->get_purch_order_details($po_order_no);
		if($occurrence_id == 0)
			$occurrence = 'Daily Sales';
		else if($occurrence_id == 1)
			$occurrence = 'Monthly Sales';
		else if($occurrence_id == 2)
			$occurrence = 'Yearly Sales';
			
		$filename = "Sales Reports.pdf";
		$title = "Sales Reports ".$this_item->name;
		
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_BOTTOM);
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(true);
		
		$pdf->AddPage();
		
		$pdf->SetFont('helvetica', '', 15);
		$payreg_content = "
		<table width=\"100%\" cellpadding=\"1px\" border=\"0px\">
			<tr>
				<td width=\"20%\">
					<img src=\"$logo\" style=\"width:150px;height:75px;\">
				</td>
				<td width=\"80%\">
					<table width=\"100%\" cellpadding=\"1px\" border=\"0px\">
						";
						
					$payreg_content .= "<tr>";
						$payreg_content .= "	<td width=\"60%\" style=\"text-align:right;\"><b>".COMPANY_NAME."</b></td>";
						
						$pdf->SetFont('courier', '', 10);
						$payreg_content .= "	<td width=\"40%\" style=\"text-align:right;\"><b>TIN : ".$this_item->tin."</b></td>";
					$payreg_content .= "</tr>";
					
					$payreg_content .= "<tr>";
						$payreg_content .= "	<td width=\"60%\" style=\"text-align:right;\"></td>";
						
						$pdf->SetFont('courier', '', 10);
						$payreg_content .= "	<td width=\"40%\" style=\"text-align:right;\"><b>$occurrence</b></td>";
					$payreg_content .= "</tr>";
					
					$payreg_content .= "<tr>";
						$payreg_content .= "	<td width=\"60%\" style=\"text-align:right;\"></td>";
						
						$pdf->SetFont('courier', '', 10);
						$payreg_content .= "	<td width=\"40%\" style=\"text-align:right;\"><b>Terminal 008</b></td>";
					$payreg_content .= "</tr>";
					
					$payreg_content .= "<tr>";
						$payreg_content .= "	<td width=\"60%\" style=\"text-align:right;\"></td>";
						
						$pdf->SetFont('courier', '', 10);
						$payreg_content .= "	<td width=\"40%\" style=\"text-align:right;\"><b>PERMIT NO:</b></td>";
					$payreg_content .= "</tr>";
					
					$payreg_content .= "<tr>";
						$payreg_content .= "	<td width=\"60%\" style=\"text-align:right;\"></td>";
						
						$pdf->SetFont('courier', '', 10);
						$payreg_content .= "	<td width=\"40%\" style=\"text-align:right;\"><b>MIN:</b></td>";
					$payreg_content .= "</tr>";
						
			$pdf->SetFont('helvetica', '', 15);
			$payreg_content .= "
					</table>
				</td>
			</tr>
		</table>
		";
			
		//-----HEADERS
		// $payreg_content .= "
		// <table width=\"100%\" cellpadding=\"1px\" border=\"1px\">
			// <tr>
				// <td style=\"text-align:center;\"> </td>
				// <td style=\"text-align:center; font-size:12px;\" colspan=\"2\">INVOICE NUMBER</td>
				// <td style=\"text-align:center;\"> </td>
				// <td style=\"text-align:center;\"> </td>
				// <td style=\"text-align:center;\"> </td>
				// <td style=\"text-align:center;\"> </td>
				// <td style=\"text-align:center;\"> </td>
				// <td style=\"text-align:center;\"> </td>
				// <td style=\"text-align:center;\"> </td>
				// <td style=\"text-align:center;\"> </td>
				// <td style=\"text-align:center;\"> </td>
				// <td style=\"text-align:center;\"> </td>
				// <td style=\"text-align:center;\"> </td>
				// <td style=\"text-align:center;\"> </td>
			// </tr>
			// ";
			// $payreg_content .= "
			// <tr>
				// <td style=\"text-align:center; font-size:12px;\">Date</td>
				// <td style=\"text-align:center; font-size:12px;\">FROM</td>
				// <td style=\"text-align:center; font-size:12px;\">TO</td>
				// <td style=\"text-align:center; font-size:12px;\">Ending<br>Balance</td>
				// <td style=\"text-align:center; font-size:12px;\">Total<br>Sales</td>
				// <td style=\"text-align:center; font-size:12px;\">VAT</td>
				// <td style=\"text-align:center; font-size:12px;\">Vatable<br>Sales</td>
				// <td style=\"text-align:center; font-size:12px;\">VAT<br>Exempt</td>
				// <td style=\"text-align:center; font-size:12px;\">Zero<br>Rated<br>Sales</td>
				// <td style=\"text-align:center; font-size:12px;\">Line<br>Discount</td>
				// <td style=\"text-align:center; font-size:12px;\">Senior<br>Citizen<br>Discount</td>
				// <td style=\"text-align:center; font-size:12px;\">PWD<br>Discount</td>
				// <td style=\"text-align:center; font-size:12px;\">Returns</td>
				// <td style=\"text-align:center; font-size:12px;\">Void</td>
				// <td style=\"text-align:center; font-size:12px;\">Z-Counter</td>
			// </tr>
		// </table>
		// ";
		// $pdf->writeHTML($payreg_content,true,false,false,false,'');
		
			
			
		$pdf->writeHTML($payreg_content,true,false,false,false,'');
		$content = "
		<table width=\"100%\" cellpadding=\"1px\" border=\"1px\">
		<thead>
			<tr>
				<th style=\"text-align:center;\"> </th>
				<th style=\"text-align:center; font-size:12px;\" colspan=\"2\">INVOICE NUMBER</th>
				<th style=\"text-align:center;\"> </th>
				<th style=\"text-align:center;\"> </th>
				<th style=\"text-align:center;\"> </th>
				<th style=\"text-align:center;\"> </th>
				<th style=\"text-align:center;\"> </th>
				<th style=\"text-align:center;\"> </th>
				<th style=\"text-align:center;\"> </th>
				<th style=\"text-align:center;\"> </th>
				<th style=\"text-align:center;\"> </th>
				<th style=\"text-align:center;\"> </th>
				<th style=\"text-align:center;\"> </th>
				<th style=\"text-align:center;\"> </th>
			</tr>
			";
			$content .= "
			<tr>
				<th style=\"text-align:center; font-size:12px;\">Date</th>
				<th style=\"text-align:center; font-size:12px;\">FROM</th>
				<th style=\"text-align:center; font-size:12px;\">TO</th>
				<th style=\"text-align:center; font-size:12px;\">Ending<br>Balance</th>
				<th style=\"text-align:center; font-size:12px;\">Total<br>Sales</th>
				<th style=\"text-align:center; font-size:12px;\">VAT</th>
				<th style=\"text-align:center; font-size:12px;\">Vatable<br>Sales</th>
				<th style=\"text-align:center; font-size:12px;\">VAT<br>Exempt</th>
				<th style=\"text-align:center; font-size:12px;\">Zero<br>Rated<br>Sales</th>
				<th style=\"text-align:center; font-size:12px;\">Line<br>Discount</th>
				<th style=\"text-align:center; font-size:12px;\">Senior<br>Citizen<br>Discount</th>
				<th style=\"text-align:center; font-size:12px;\">PWD<br>Discount</th>
				<th style=\"text-align:center; font-size:12px;\">Returns</th>
				<th style=\"text-align:center; font-size:12px;\">Void</th>
				<th style=\"text-align:center; font-size:12px;\">Z-Counter</th>
			</tr>
			</thead>";
			$a = 100;
			$b = 100;
			$content .="<tbody>";
		while($a != 0){
			$content .= "<tr>
								<td style=\"text-align:center; font-size:10px;\">4/12013</td>
								<td style=\"text-align:center; font-size:10px;\">00157465</td>
								<td style=\"text-align:center; font-size:10px;\">00157542</td>
								<td style=\"text-align:center; font-size:10px;\">170,737.82</td>
								<td style=\"text-align:center; font-size:10px;\">85316.00</td>
								<td style=\"text-align:center; font-size:10px;\">8,952.25</td>
								<td style=\"text-align:center; font-size:10px;\">74,602.10</td>
								<td style=\"text-align:center; font-size:10px;\">1,761.65</td>
								<td style=\"text-align:center; font-size:10px;\">0.00</td>
								<td style=\"text-align:center; font-size:11px;\">0.00</td>
								<td style=\"text-align:center; font-size:10px;\">0.00</td>
								<td style=\"text-align:center; font-size:10px;\">0.00</td>
								<td style=\"text-align:center; font-size:10px;\">-229.00</td>
								<td style=\"text-align:center; font-size:10px;\">0.00</td>
								<td style=\"text-align:center; font-size:10px;\">1620</td>
								</tr>";
			$a--;
		}
			$content .= "</tbody></table>";
		
		$pdf->writeHTML($content,true,false,false,false,'');
	
		$pdf->Output($filename, 'I');
		
	}
}