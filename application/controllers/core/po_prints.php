<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Po_prints extends CI_Controller {
	var $data = array();
	public function __construct(){
        parent::__construct();	    
        $this->load->model('core/po_model');
        $this->load->model('site/site_model');	
    }
	public function po($po_order_no=''){
		date_default_timezone_set('Asia/Manila');
		$this->load->library('My_TCPDF');
		// $pdf = new TCPDF("P", "mm", 'FOLIO', true, 'UTF-8', false);
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'Letter', false, 'UTF-8', false);
		
		$main_items = $this->po_model->get_purch_orders($po_order_no);
		$this_item = $main_items[0];
		$sub_items = $this->po_model->get_purch_order_details($po_order_no);
		
		$filename = "Purchase Order Details.pdf";
		$title = "Purchase Order Details for ".$this_item->reference;
		$tin = $this->po_model->get_branch_tin($this_item->branch_id);
		
		$supplier = $this->po_model->get_supplier_details($this_item->supplier_id);
		$supplier_det = $supplier[0];
		
		$pdf->po_no = $this_item->reference;
		
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_BOTTOM);
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(true);
		
		$pdf->AddPage();
		
		$pdf->SetFont('helvetica', 'B', 15);
		$pdf->Cell(150, 15, COMPANY_NAME, 0, false, 'L', 0, '', 0, false, 'M', 'M');
		$pdf->Cell(70, 15, "Purchase Order", 0, false, 'L', 0, '', 0, false, 'M', 'M');
		$pdf->Ln(5);
        $pdf->SetFont('helvetica', null, 12);
		$pdf->Cell(150, 15, $this_item->delivery_address, 0, false, 'L', 0, '', 0, false, 'M', 'M');
        $pdf->SetFont('helvetica', null, 10);
		$pdf->Cell(70, 15, "No.", 0, false, 'L', 0, '', 0, false, 'M', 'M');
        $pdf->Ln(5);
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(150, 15, $tin, 0, false, 'L', 0, '', 0, false, 'M', 'M');
		$pdf->Cell(70, 15, $this_item->reference, 0, false, 'L', 0, '', 0, false, 'M', 'M');
        $pdf->Ln(5);
        $pdf->SetFont('helvetica', null, 10);
		$pdf->Cell(150, 15, "", 0, false, 'L', 0, '', 0, false, 'M', 'M');
		$pdf->Cell(70, 15, "Delivery Date", 0, false, 'L', 0, '', 0, false, 'M', 'M');
        $pdf->Ln(5);
		$pdf->Cell(150, 15, "", 0, false, 'L', 0, '', 0, false, 'M', 'M');
		$pdf->SetFont('helvetica', 'B', 10);
		$pdf->Cell(70, 15, sql2Date($this_item->delivery_date), 0, false, 'L', 0, '', 0, false, 'M', 'M');
		
		$w = array(70, 90, 55,60);
		$pdf->Ln(10);
		$pdf->SetFont('helvetica', null, 10);
		$pdf->Cell(80, 15, "Supplier", 0, false, 'L', 0, '', 0, false, 'M', 'M');
		$pdf->Cell(100, 15, "Recieve At", 0, false, 'L', 0, '', 0, false, 'M', 'M');
		
		$pdf->Ln(1.5);
		$pdf->SetFont('helvetica', 'B', 12);
		$pdf->MultiCell(80, 15,$supplier_det->supp_name,0,'L',false,0);
		$pdf->MultiCell(100, 15, COMPANY_NAME,0,'L',false,1);
		
		$pdf->SetFont('helvetica', null, 9);
		$pdf->Cell(80, 15, $supplier_det->address, 0, false, 'L', 0, '', 0, false, 'M', 'M');
		$pdf->Cell(100, 15, $this_item->delivery_address, 0, false, 'L', 0, '', 0, false, 'M', 'M');
		$pdf->SetFont('helvetica', 'B', 12);
		$pdf->Ln(4);
		$pdf->SetFont('helvetica', null, 9);
		$pdf->Cell(80, 15, $supplier_det->contact_person, 0, false, 'L', 0, '', 0, false, 'M', 'M');
		$pdf->Cell(100, 15, $tin, 0, false, 'L', 0, '', 0, false, 'M', 'M');
		$pdf->Ln(5);
		
		$pdf->SetFont('helvetica', 'B', 12);
		$header = array();
		$header = array('Code', '   Particulars ', ' UOM ',' Qty ', 'Price  ' , '  Extended');
	    // Header
	    $w = array(25, 90, 15 , 15, 20 ,  20 );
	    $num_headers = count($header);
	    for($i = 0; $i < $num_headers; $i++) {
	        if($i > 2){
	        	$pdf->Cell($w[$i], 7, $header[$i], 0, 0, 'R', 0);
	        }
	        else
		        $pdf->Cell($w[$i], 7, $header[$i], 0, 0, 'L', 0);
	    }
        $pdf->Ln(6);
		
		$fill = 0;
		$po_total=0;
	    $qty_total=0;
		
		foreach($sub_items as $val){
			$pdf->SetFont('courier', null, 8);
	        $pdf->Cell($w[0], 6, $this->po_model->get_supplier_stock_code_from_stock_id($val->stock_id), 0, 0, 'L', $fill);
			$pdf->SetFont('courier', 'B', 9);
	        $pdf->Cell($w[1], 6, ' '.$val->description, 0, 0, 'L', $fill);
	        $pdf->Cell($w[2], 6, ' '.$val->uom, 0, 0, 'L', $fill);
	        $pdf->Cell($w[3], 6, ' '.num($val->qty_ordered).' ', 0, 0, 'R', $fill);
	        $pdf->Cell($w[4], 6, ' '.num($val->unit_cost).' ', 0, 0, 'R', $fill);
	       	// $total = $row->ord_qty * $row->unit_price; //original
	       	$total = $val->extended;
	        // $discTxt = "";
			// if($row->discounts != "" || $row->discounts != 0){
				// $discounts = explode(',', $row->discounts);
				// foreach ($discounts as $discs) {
					// $disc = explode('=>',$discs);
					// if (count($disc) <= 1)
						// continue;
					// $discTxt .= $disc[0];
					// $total -= $disc[1];
				// }
			// }
	        $pdf->Cell($w[5], 6, num($total), 0, 0, 'R', $fill);
	        $po_total += $total;
	        $qty_total += $val->qty_ordered;
	        $pdf->Ln(4);
		}
		
		//~~~~~~~~~FOR TOTALS~~~~~~~~~~//
		$pdf->SetFont('courier', null, 9);
		$pdf->Ln(6);
		$pdf->Cell($w[0], 6, '', 0, 0, 'L', $fill);
        $pdf->Cell($w[1], 6, '', 0, 0, 'L', $fill);
        $pdf->SetFont('helvetica', 'B', 14);
        $pdf->Cell($w[2], 6, '', 0, 0, 'R', $fill);
        $pdf->Cell($w[3], 6, 'Total Qty', 0, 0, 'R', $fill);
        $pdf->Cell($w[4], 6, null, 0, 0, 'R', $fill);
		
		$pdf->SetFont('helvetica', 'B', 14);
        $pdf->Cell($w[5], 6, 'Grand Total', 0, 0, 'R', $fill);
		
		$pdf->Ln(6);
        $pdf->Cell($w[0], 6, '', 0, 0, 'L', $fill);
        $pdf->Cell($w[1], 6, '', 0, 0, 'L', $fill);
        $pdf->SetFont('helvetica', 'B', 14);
        $pdf->Cell($w[2], 6, '', 0, 0, 'R', $fill);
        $pdf->Cell($w[3], 6, num($qty_total), 0, 0, 'R', $fill);
		
		$pdf->Cell($w[4], 6, null, 0, 0, 'R', $fill);
		
		$pdf->SetFont('helvetica', 'B', 14);
        $pdf->Cell($w[5], 6,  num($po_total), 0, 0, 'R', $fill);
		
		$pdf->Ln(8);
		
		if ($pdf->GetY() > $pdf->getPageHeight() - (PDF_MARGIN_BOTTOM+13))
			$pdf->AddPage();
		
		$pdf->SetFont('helvetica', 'B', 12);
   		$pdf->Cell($w[0], 6, "Remarks", 0, 0, 'L', $fill);
   		$pdf->SetFont('helvetica', '', 8);
        $pdf->Cell($w[1], 6, null, 0, 0, 'R', $fill);
        $pdf->Cell($w[2], 6, null, 0, 0, 'R', $fill);
        $pdf->Cell($w[3], 6, null, 0, 0, 'R', $fill);
        $pdf->Cell($w[4], 6, null, 0, 0, 'R', $fill);
        $pdf->Cell($w[5], 6, null, 0, 0, 'L', $fill);
		
		if(count($this_item->comments) > 0 )
		{
	        $pdf->Ln(5);
			$pdf->SetFont('helvetica', null, 11);
	   		$pdf->Cell($w[0], 6, $this_item->comments, 0, 0, 'L', $fill);
	        $pdf->Cell($w[1], 6, null, 0, 0, 'R', $fill);
	        $pdf->Cell($w[2], 6, null, 0, 0, 'L', $fill);
	        $pdf->Cell($w[3], 6, null, 0, 0, 'R', $fill);
	        $pdf->Cell($w[4], 6, null, 0, 0, 'R', $fill);
	        $pdf->Cell($w[5], 6, null, 0, 0, 'R', $fill);
    	}
		
        $pdf->Ln();
		
		//~~~~~~~~~FOR SIGNATURES~~~~~~~~~~//
		// $prepared_by = $this->po_model->get_po_prepared_by(16, $branch->order_no);
		// $prepared_by_sign = $prepared_by[0]->sign;
		// $prepared_by = $prepared_by[0]->prepared_by;
		
		// $approved_by = $this->po_model->get_po_approved_by(16, $branch->order_no);
		// $approved_by_sign = $approved_by[0]->sign;
		// $approved_by = $approved_by[0]->approved_by;
		
		$prepared_by = $this_item->created_by;
		$prepared_by_sign = $this_item->created_by;
		
		$approved_by = $this_item->posted_by;
		$approved_by_sign = $this_item->posted_by;
		
		$p_sign = BASEPATH.'../signatures/'.$prepared_by_sign.'.png';
		$a_sign = BASEPATH.'../signatures/'.$approved_by_sign.'.png';

		if ($pdf->GetY() > $pdf->getPageHeight() - (PDF_MARGIN_BOTTOM+13))
			$pdf->AddPage();
			
		$pdf->SetY($pdf->getPageHeight() - (PDF_MARGIN_BOTTOM+13));
		$ww = 35;
		
		$pdf->SetFont('helvetica', '', 10);
		$pdf->Cell($ww-7, 6, '', 'LT', 0, 'L', $fill);
		$pdf->SetFont('helvetica', 'B', 10);
   		$pdf->Cell($ww, 6, '', 'RT', 0, 'L', $fill);
		$pdf->SetFont('helvetica', '', 10);
   		$pdf->Cell($ww-8, 6, '', 'LT', 0, 'L', $fill);
		$pdf->SetFont('helvetica', 'B', 10);
		$pdf->Cell($ww, 6, '', 'RT', 0, 'L', $fill);
		$pdf->SetFont('helvetica', '', 10);
   		$pdf->Cell($ww-8, 6, '', 'LT', 0, 'L', $fill);
		$pdf->SetFont('helvetica', 'B', 10);
		$pdf->Cell($ww, 6, '', 'RT', 0, 'L', $fill);
        $pdf->Ln();
		
		
		$pdf->SetFont('helvetica', '', 10);
   		$pdf->Cell($ww-13, 6, 'Prepared by: ', 'LB', 0, 'L', $fill);
		$pdf->SetFont('helvetica', 'B', 10);
   		$pdf->Cell($ww+6, 6, $this->po_model->get_user_name($prepared_by), 'RB', 0, 'L', $fill);
		$pdf->SetFont('helvetica', '', 10);
   		$pdf->Cell($ww-8, 6, 'Checked by: ', 'LB', 0, 'L', $fill);
		$pdf->SetFont('helvetica', 'B', 10);
		$pdf->Cell($ww, 6, '', 'RB', 0, 'L', $fill);
		$pdf->SetFont('helvetica', '', 10);
   		$pdf->Cell($ww-13, 6, 'Approved by: ', 'LB', 0, 'L', $fill);
		$pdf->SetFont('helvetica', 'B', 10);
		$pdf->Cell($ww+5, 6, ($approved_by != '' ? $this->po_model->get_user_name($approved_by) : ''), 'RB', 0, 'L', $fill);
		
		
		if ($prepared_by_sign != ''){
			$pdf->Image($p_sign,30,244,0,20);
		}

		if ($approved_by_sign != ''){
			// $pdf->Image($a_sign,154,249,0,20);
			$pdf->Image($a_sign,154,244,0,20);
		}
		
		// $pdf->Ln();
		
		$pdf->SetFont('helvetica', null, 8);
		$pdf->SetY($pdf->getPageHeight() - (PDF_MARGIN_BOTTOM+4));
		// $pdf->SetY($pdf->getPageHeight() - (PDF_MARGIN_BOTTOM));
		
		return $pdf->Output($filename, 'I');
		
	}
}