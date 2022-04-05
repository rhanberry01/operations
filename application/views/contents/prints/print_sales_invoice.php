<?php

	declare_tcpdf();
	$CI =& get_instance();
	$CI->load->model('sales/sales_model');

	date_default_timezone_set('Asia/Manila');


	$filename = "Invoice.pdf";
	$title = "Sales Invoice";

	class MyTCPDF extends TCPDF {
		public function Footer(){
			$this->SetY(4);
			// $this->SetFont('helvetica','',10);
			$this->SetFont('helvetica','',10);
			$this->Cell(210, 0, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
		}
	}

	$pdf = new MyTCPDF("P", "mm", 'LETTER', true, 'UTF-8', false);

	$pdf->SetTitle($title);
	$pdf->SetTopMargin(10);
	$pdf->SetLeftMargin(10);
	$pdf->SetRightMargin(10);
	$pdf->SetFooterMargin(10);
	$pdf->SetAutoPageBreak(false, 85);
	// $pdf->SetAuthor('Author');
	$pdf->SetDisplayMode('real','default');
	$pdf->setPrintHeader(false);
	$pdf->setPrintFooter(true);


	// =============================================================================================================================== //
	$pdf->AddPage();
	$pdf->SetFont('helvetica', '', 19);

	//$pdf->Image('img/BON-invoice.jpg', 0, 0, 150, 2000, '', '', 'T', false, 300, '', false, true, 1, true, false, false);


// 	$txt2 = <<<EOD
// 	<b>BON INDUSTRIAL SALES</b>
// EOD;
// 	// $pdf->MultiCell(70, 40, $txt2, 1, 'J', false, 1, 15, 10, true, 0, false, true, 0, 'T', false);
// 	$pdf->writeHTML($txt2, true, false, false, false, '');

// $html = '<span style="text-align:justify;text-align:center"><b>BON INDUSTRIAL SALES</b></span>';
// $pdf->writeHTML($html, true, 0, true, true);

// $pdf->SetFont('helvetica', '', 8);
// $html = '<span style="text-align:justify;text-align:center">35 Macopa St., Sta. Mesa Heights, Quezon City, Metro Manila<br>
// 			Tels.: 749-3672, 740-0458, 732-0570<br>
// 			742-2693, 741-4203, 781-2740 * Fax: 712-4771
// </span><br>';
// $pdf->writeHTML($html, true, 0, true, true);

// $pdf->line(28,44,80,44);
// $pdf->line(90,44,147,44);


// $pdf->line(31,49,80,49);
// $pdf->line(101,49,147,49);
// $pdf->line(157,49,200,49);

// $pdf->line(41,54,80,54);
// $pdf->line(86,54,147,54);
// $pdf->line(154,54,200,54);


// $pdf->SetFont('helvetica', '', 11);
// $html = '<div style="padding-left:500px;">
// <table border="0" width="100%">
// 	<tr>
// 		<td align="left">Sold to</td>
// 		<td>TIN:</td>
// 		<td></td>
// 	</tr>
// 	<tr>
// 		<td>Address</td>
// 		<td>Bus. Style:</td>
// 		<td>Date</td>
// 	</tr>
// 	<tr>
// 		<td>Res. Cert. No.</td>
// 		<td>At</td>
// 		<td>On</td>
// 	</tr>

// </table>
// </div>';
// // $pdf->writeHTML($html, true, false, true, false, 'center');
// $pdf->writeHTMLCell(200, 0, 15, 40, $html, 0, 1, 0, true, 'L');

$pdf->Image('img/BON-new-invoice.jpg', 0, 0, 310, 310, '', '', '', false, 300, '', false, true, 0, true, false, false);


$where = array('debtor_id'=>$head->debtor_id);
$deb_name = $CI->sales_model->get_details($where,'debtor_master');

$pdf->SetFont('helvetica', '', 13);
$html = ''.$deb_name[0]->name;
$pdf->writeHTMLCell(118, 0, 32, 35, $html, 0, 1, 0, true, 'L');


$where = array('debtor_branch_id'=>$head->debtor_branch_id);
$branch_name = $CI->sales_model->get_details($where,'debtor_branches');
// //branch name
// $pdf->SetFont('helvetica', '', 9);
// $html = ''.$branch_name[0]->branch_name;
// $pdf->writeHTMLCell(118, 0, 32, 50, $html, 0, 1, 0, true, 'L');

//get tax type of tax group
// $where = array('tax_group_id'=>$branch_name[0]->tax_grp);
// $t_type = $CI->sales_model->get_details($where,'tax_group_items');
// $tax_type = $t_type[0]->tax_type_id;


$pdf->SetFont('helvetica', '', 9);
// $html = ''.$deb_name[0]->address;
$html = ''.$deb_name[0]->address;
$pdf->writeHTMLCell(118, 0, 28, 48, $html, 0, 1, 0, true, 'L');

//////business style
$html = ''.$deb_name[0]->business_style;
$pdf->writeHTMLCell(100, 0, 32, 53, $html, 0, 0, 0, true, 'L');

//////TIN
$html = ''.$deb_name[0]->tax_no;
$pdf->writeHTMLCell(100, 0, 113, 53, $html, 0, 0, 0, true, 'L');

// terms
$payment_term = $CI->site_model->get_custom_val('payment_terms','term_name','payment_id',$deb_name[0]->payment_term);
$pdf->writeHTMLCell(200, 0, 25, 74, $payment_term->term_name, 0, 1, 0, true, 'L');

// trans date
$html = ''.sql2Date($head->trans_date);
$pdf->writeHTMLCell(200, 0, 25, 58.5, $html, 0, 1, 0, true, 'L');

$html = ''.$deb_name[0]->address;
$pdf->writeHTMLCell(200, 0, 37, 79, $html, 0, 1, 0, true, 'L');

$pdf->ln(15);

$pdf->SetFont('helvetica', 'B', 16);

$cur_y = $pdf->GetY();
$pdf->SetY(250);
$pdf->cell(55,0,'',0,0,'L');
$pdf->cell(85,0,$head->reference,0,0,'L');
$pdf->SetY($cur_y);


$pdf->SetFont('helvetica', '', 9);
// $html = '<div style="padding-left:500px;">
// <table border="1" width="100%" cellspacing ="2.6">';
// 	// $html ='';
// 	//$ctr = 0;

// 	// $pdf->writeHTMLCell(180, 86, 4, 107, $html, 1, 0, 0, true, 'L');
// $pdf->writeHTML($html, true, false, true, false, 'center');


	$grand_total = 0;
	$lns = 5;


	$zero_rated = 0;
	$vatables = 0;
	$vat_exempt = 0;
	$tester = 0;
	// $html ='';
	$prev_dr = '';
	foreach($invoice_details as $k => $v){
	// while($tester != 30){

		if ($prev_dr != $v->reference) {
			$pdf->SetFont('helvetica', 'B', 9);
			//$pdf->cell(27,0,'Delivery #',0,0,'L');
			$pdf->SetFont('helvetica', 'B',9);
			$pdf->cell(195,0,'Delivery # '.$v->reference.' - '.date('m/d/Y',strtotime($v->trans_date)),0,0,'C');
			// $pdf->cell(50,0,$v->reference,0,0,'L');
			// $pdf->cell(120,0,$description,0,0,'C');
			// $pdf->cell(22.3,0,Num($v->unit_price),0,0,'R');
			// $pdf->cell(31,0,Num($total),0,0,'R');
			$pdf->ln(5.35);
			$pdf->ln(5.35);
			$pdf->SetFont('helvetica', '');
			$prev_dr = $v->reference;
		}


		$total = $v->qty * $v->unit_price;

		if($v->stock_category == LOCAL_ITEM){
			$where = array('id'=>$v->stock_id);
			$item_name = $CI->sales_model->get_details($where,'non_stock_master');
			$description = '['.$item_name[0]->name.'] '.$item_name[0]->description;

		}else{
			$where = array('id'=>$v->stock_id);
			$item_name = $CI->sales_model->get_details($where,'stock_master');
			$description = $item_name[0]->name;
		}

		$where = array('uom_id'=>$v->uom_id);
		$item_uom = $CI->sales_model->get_details($where,'uoms');

		$item_tax_type = $item_name[0]->item_tax_type;

		$len = strlen($description);
		if($len > 60){

			$arr2 = str_split($description, 60);
			$counter = 1;
			foreach($arr2 as $k => $vv){
				if($counter == 1){
					$pdf->cell(16,0,$v->qty,0,0,'R');
					$pdf->cell(15,0,$item_uom[0]->name,0,0,'L');
					$pdf->cell(116,0,$vv,0,0,'C');
					$pdf->cell(27,0,Num($v->unit_price),0,0,'R');
					$pdf->cell(29.5,0,Num($total),0,0,'R');
					$pdf->ln(5.35);
				}else{
					$pdf->cell(31,0,'',0,0,'R');
					$pdf->cell(116,0,$vv,0,0,'C');
					$pdf->ln(5.35);
				}
			$counter++;
			}

			// $pdf->cell(26,0,$v->qty,0,0,'R');
			// $pdf->cell(120,0,$desc,0,0,'C');
			// $pdf->cell(22.3,0,Num($v->unit_price),0,0,'R');
			// $pdf->cell(31,0,Num($total),0,0,'R');
			// $pdf->ln(5.35);
			// $pdf->cell(26,0,'',0,0,'R');
			// $pdf->cell(120,0,$desc,1,0,'C');
		}else{
			$pdf->cell(16,0,$v->qty,0,0,'R');
			$pdf->cell(15,0,$item_uom[0]->name,0,0,'L');
			$pdf->cell(116,0,$description,0,0,'C');
			$pdf->cell(27,0,Num($v->unit_price),0,0,'R');
			$pdf->cell(29.5,0,Num($total),0,0,'R');
			$pdf->ln(5.35);
		}

			// $pdf->cell(26,0,$description,0,0,'R');


		$grand_total += $total;

			if($pdf->GetY() > 175){
				$pdf->AddPage();
				$pdf->SetFont('helvetica', '', 19);
				$pdf->Image('img/BON-new-invoice.jpg', 0, 0, 310, 310, '', '', '', false, 300, '', false, true, 0, true, false, false);

				// $where = array('debtor_id'=>$head->debtor_id);
				// $deb_name = $CI->sales_model->get_details($where,'debtor_master');

				// $pdf->SetFont('helvetica', '', 13);
				// $html = ''.$deb_name[0]->name;
				// $pdf->writeHTMLCell(118, 0, 32, 35, $html, 1, 1, 0, true, 'C');

				// $where = array('debtor_branch_id'=>$head->debtor_branch_id);
				// $branch_name = $CI->sales_model->get_details($where,'debtor_branches');

				// $pdf->SetFont('helvetica', '', 9);
				// $html = ''.$branch_name[0]->branch_name;
				// $pdf->writeHTMLCell(118, 0, 32, 50, $html, 1, 1, 0, true, 'C');


				// $pdf->SetFont('helvetica', '', 9);
				// $html = ''.$deb_name[0]->address;
				// $pdf->writeHTMLCell(118, 0, 32, 52, $html, 1, 1, 0, true, 'C');

				// //////business style
				// $html = ''.$deb_name[0]->business_style;
				// $pdf->writeHTMLCell(100, 0, 35, 63, $html, 0, 0, 0, true, 'L');

				// $html = ''.sql2Date($head->trans_date);
				// $pdf->SetY($cur_y);

				// $pdf->SetFont('helvetica', '', 9);

				////////////////////////////
				$where = array('debtor_id'=>$head->debtor_id);
				$deb_name = $CI->sales_model->get_details($where,'debtor_master');

				$pdf->SetFont('helvetica', '', 13);
				$html = ''.$deb_name[0]->name;
				$pdf->writeHTMLCell(118, 0, 32, 35, $html, 0, 1, 0, true, 'L');


				$where = array('debtor_branch_id'=>$head->debtor_branch_id);
				$branch_name = $CI->sales_model->get_details($where,'debtor_branches');


				$pdf->SetFont('helvetica', '', 9);
				// $html = ''.$deb_name[0]->address;
				$html = ''.$deb_name[0]->address;
				$pdf->writeHTMLCell(118, 0, 28, 48, $html, 0, 1, 0, true, 'L');

				//////business style
				$html = ''.$deb_name[0]->business_style;
				$pdf->writeHTMLCell(100, 0, 32, 53, $html, 0, 0, 0, true, 'L');

				//////TIN
				$html = ''.$deb_name[0]->tax_no;
				$pdf->writeHTMLCell(100, 0, 113, 53, $html, 0, 0, 0, true, 'L');

				// terms
				$payment_term = $CI->site_model->get_custom_val('payment_terms','term_name','payment_id',$deb_name[0]->payment_term);
				$pdf->writeHTMLCell(200, 0, 25, 74, $payment_term->term_name, 0, 1, 0, true, 'L');

				// trans date
				$html = ''.sql2Date($head->trans_date);
				$pdf->writeHTMLCell(200, 0, 25, 58.5, $html, 0, 1, 0, true, 'L');

				$html = ''.$deb_name[0]->address;
				$pdf->writeHTMLCell(200, 0, 37, 79, $html, 0, 1, 0, true, 'L');

				$pdf->ln(15);

				$pdf->SetFont('helvetica', 'B', 14);

				$cur_y = $pdf->GetY();
				$pdf->SetY(250);
				$pdf->cell(55,0,'',0,0,'L');
				$pdf->cell(85,0,$head->reference,0,0,'L');
				$pdf->SetY($cur_y);


				$pdf->SetFont('helvetica', '', 9);
			}

			// $tester++;
	}



	// for($i=1;$i<=20;$i++){
	// $pdf->cell(26,0,'77',0,0,'C');
	// $pdf->cell(120,0,'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaa|aaaaaaaaaaaaaaaaaaa|aaaaaaaaa',0,0,'C');
	// $pdf->cell(22.3,0,'44',0,0,'R');
	// $pdf->cell(31,0,$pdf->GetY(),0,0,'R');
	// $pdf->ln(5.35);

	// if($pdf->GetY() > 188.5){
	// 		$pdf->AddPage();
	// 		$pdf->SetFont('helvetica', '', 19);
	// 		$pdf->Image('img/BON-invoice.jpg', 0, 0, 220, 280, '', '', '', false, 300, '', false, true, 0, true, false, false);

	// 		$where = array('debtor_id'=>$head->debtor_id);
	// 		$deb_name = $CI->sales_model->get_details($where,'debtor_master');

	// 		$pdf->SetFont('helvetica', '', 13);
	// 		$html = ''.$deb_name[0]->name;
	// 		$pdf->writeHTMLCell(118, 0, 32, 45, $html, 1, 1, 0, true, 'C');

	// 		$pdf->SetFont('helvetica', '', 9);
	// 		$html = ''.$deb_name[0]->address;
	// 		$pdf->writeHTMLCell(118, 0, 32, 52, $html, 1, 1, 0, true, 'C');

	// 		$html = ''.sql2Date($head->trans_date);
	// 		$pdf->writeHTMLCell(200, 0, 33, 69, $html, 0, 1, 0, true, 'L');

	// 		$pdf->ln(35);

	// 		$pdf->SetFont('helvetica', '', 9);

	// 	}

	//  }

	if($print == 'wbd'){
		if($branch_name[0]->tax_grp == 2){
			///////////zero rated
			//left side--------------------
			//vatable
			$pdf->writeHTMLCell(33, 86, 122, 195, "0.00", 0, 0, 0, true, 'R');
			//vat ex sales
			$pdf->writeHTMLCell(33, 86, 122, 201, "0.00", 0, 0, 0, true, 'R');
			//zero rated sales
			$pdf->writeHTMLCell(33, 86, 122, 206, Num($grand_total), 0, 0, 0, true, 'R');
			//total sales
			//$pdf->writeHTMLCell(33, 86, 178, 215, Num($grand_total), 0, 0, 0, true, 'R');
			//vat
			$pdf->writeHTMLCell(33, 86, 122, 211, "0.00", 0, 0, 0, true, 'R');

			//right side----------------------------
			//total sales vat inclusive
			$pdf->writeHTMLCell(33, 86, 180, 184, "0.00", 0, 0, 0, true, 'R');
			//less vat
			$pdf->writeHTMLCell(33, 86, 180, 190, "0.00", 0, 0, 0, true, 'R');
			//amount net of vat
			$pdf->writeHTMLCell(33, 86, 180, 195, "0.00", 0, 0, 0, true, 'R');
			//less pwd discount
			$pdf->writeHTMLCell(33, 86, 180, 201, "0.00", 0, 0, 0, true, 'R');
			//amt due
			$pdf->writeHTMLCell(33, 86, 180, 206, Num($grand_total), 0, 0, 0, true, 'R');
			//add vat
			$pdf->writeHTMLCell(33, 86, 180, 211, "0.00", 0, 0, 0, true, 'R');


			//grandtotal
			$pdf->writeHTMLCell(33, 86, 180, 216, Num($grand_total), 0, 0, 0, true, 'R');
		}else if($branch_name[0]->tax_grp == 3){
			//vat exempt
			//left side--------------------
			//vatable
			$pdf->writeHTMLCell(33, 86, 122, 195, "0.00", 0, 0, 0, true, 'R');
			//vat ex sales
			$pdf->writeHTMLCell(33, 86, 122, 201, "0.00", 0, 0, 0, true, 'R');
			//zero rated sales
			$pdf->writeHTMLCell(33, 86, 122, 206, Num($grand_total), 0, 0, 0, true, 'R');
			//total sales
			//$pdf->writeHTMLCell(33, 86, 178, 215, Num($grand_total), 0, 0, 0, true, 'R');
			//vat
			$pdf->writeHTMLCell(33, 86, 122, 211, "0.00", 0, 0, 0, true, 'R');

			//right side----------------------------
			//total sales vat inclusive
			$pdf->writeHTMLCell(33, 86, 180, 184, "0.00", 0, 0, 0, true, 'R');
			//less vat
			$pdf->writeHTMLCell(33, 86, 180, 190, "0.00", 0, 0, 0, true, 'R');
			//amount net of vat
			$pdf->writeHTMLCell(33, 86, 180, 195, "0.00", 0, 0, 0, true, 'R');
			//less pwd discount
			$pdf->writeHTMLCell(33, 86, 180, 201, "0.00", 0, 0, 0, true, 'R');
			//amt due
			$pdf->writeHTMLCell(33, 86, 180, 206, Num($grand_total), 0, 0, 0, true, 'R');
			//add vat
			$pdf->writeHTMLCell(33, 86, 180, 211, "0.00", 0, 0, 0, true, 'R');


			//grandtotal
			$pdf->writeHTMLCell(33, 86, 180, 216, Num($grand_total), 0, 0, 0, true, 'R');
		}else if($branch_name[0]->tax_grp == 1){
			//vatables

			$vatable = $grand_total / 1.12;
			$vat = $grand_total - $vatable;
			//left------------------------------
			$pdf->writeHTMLCell(33, 86, 122, 195, Num($vatable), 0, 0, 0, true, 'R');
			//vat ex sales
			$pdf->writeHTMLCell(33, 86, 122, 201, "0.00", 0, 0, 0, true, 'R');
			//zero rated sales
			$pdf->writeHTMLCell(33, 86, 122, 206, "0.00", 0, 0, 0, true, 'R');
			//total sales
			//$pdf->writeHTMLCell(33, 86, 178, 215, Num($grand_total), 0, 0, 0, true, 'R');
			//vat
			$pdf->writeHTMLCell(33, 86, 122, 211, Num($vat), 0, 0, 0, true, 'R');

			//right-----------------------------
			//total sales vat inclusive
			$pdf->writeHTMLCell(33, 86, 180, 184, Num($grand_total), 0, 0, 0, true, 'R');
			//less vat
			$pdf->writeHTMLCell(33, 86, 180, 190, Num($vat), 0, 0, 0, true, 'R');
			//amount net of vat
			$pdf->writeHTMLCell(33, 86, 180, 195, Num($vatable), 0, 0, 0, true, 'R');
			//less pwd discount
			$pdf->writeHTMLCell(33, 86, 180, 201, "0.00", 0, 0, 0, true, 'R');
			//amt due
			$pdf->writeHTMLCell(33, 86, 180, 206, Num($grand_total), 0, 0, 0, true, 'R');
			//add vat
			$pdf->writeHTMLCell(33, 86, 180, 211, "0.00", 0, 0, 0, true, 'R');

			//grandtotal
			$pdf->writeHTMLCell(33, 86, 180, 216, Num($grand_total), 0, 0, 0, true, 'R');

		}else if($branch_name[0]->tax_grp == 4){
			//tax exclusive

			$vatable = $grand_total / 1.12;
			$vat_add = $grand_total * 0.12;
			$vat = $grand_total - $vatable;
			//left------------------
			$pdf->writeHTMLCell(33, 86, 122, 195, "0.00", 0, 0, 0, true, 'R');
			//vat ex sales
			$pdf->writeHTMLCell(33, 86, 122, 201, "0.00", 0, 0, 0, true, 'R');
			//zero rated sales
			$pdf->writeHTMLCell(33, 86, 122, 206, "0.00", 0, 0, 0, true, 'R');
			//total sales
			//$pdf->writeHTMLCell(33, 86, 178, 215, Num($grand_total), 0, 0, 0, true, 'R');
			//vat
			$pdf->writeHTMLCell(33, 86, 122, 211, "0.00", 0, 0, 0, true, 'R');

			//right-----------------
			//total sales vat inclusive
			$pdf->writeHTMLCell(33, 86, 180, 184, "0.00", 0, 0, 0, true, 'R');
			//less vat
			$pdf->writeHTMLCell(33, 86, 180, 190, "0.00", 0, 0, 0, true, 'R');
			//amount net of vat
			$pdf->writeHTMLCell(33, 86, 180, 195, Num($grand_total), 0, 0, 0, true, 'R');
			//less pwd discount
			$pdf->writeHTMLCell(33, 86, 180, 201, "0.00", 0, 0, 0, true, 'R');
			//amt due
			$pdf->writeHTMLCell(33, 86, 180, 206, Num($grand_total), 0, 0, 0, true, 'R');
			//add vat
			$pdf->writeHTMLCell(33, 86, 180, 211, Num($vat_add), 0, 0, 0, true, 'R');


			//grandtotal
			$pdf->writeHTMLCell(33, 86, 180, 216, Num($grand_total + $vat_add), 0, 0, 0, true, 'R');

		}
	}else{
		$pdf->writeHTMLCell(33, 86, 180, 190, "", 0, 0, 0, true, 'R');
		//vat ex sales
		$pdf->writeHTMLCell(33, 86, 180, 195, "", 0, 0, 0, true, 'R');
		//zero rated sales
		$pdf->writeHTMLCell(33, 86, 180, 201, "", 0, 0, 0, true, 'R');
		//total sales
		$pdf->writeHTMLCell(33, 86, 180, 206, "", 0, 0, 0, true, 'R');
		//vat
		$pdf->writeHTMLCell(33, 86, 180, 211, "", 0, 0, 0, true, 'R');
		//grandtotal
		$pdf->writeHTMLCell(33, 86, 180, 216, Num($grand_total), 0, 0, 0, true, 'R');
	}





// $html .= '</table>
// </div>';
// $pdf->writeHTML($html, true, false, true, false, 'center');
// $pdf->writeHTMLCell(180, 86, 4, 107, $html, 1, 0, 0, true, 'L');

// $pdf->line(31,193,80,193);
//$pdf->GetY();
// $pdf->cell(26,0,$pdf->GetY(),0,0,'R');

	$pdf->Output($filename, 'I');

?>