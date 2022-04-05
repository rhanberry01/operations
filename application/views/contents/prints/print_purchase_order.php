<?php

	function pageHead(&$pdf,$header,$attention)
	{
		$pdf->AddPage();
		$pdf->SetFont('times', 'B', 24);
		$pdf->Cell(0,0,'BON Industrial Sales',0,1,'L');
		$pdf->SetFont('helvetica', '', 11);
		$pdf->Cell(0,0,'35 Macopa St. Sta Mesa Heights, Quezon City, Philippines',0,1,'L');
		$pdf->Cell(0,0,'Tel. Nos.: (632) 734-2740 to 44, 733-1532, 733-1569, 733-1541, 733-1542',0,1,'L');
		$pdf->Cell(0,0,'Fax No.: (632) 712-4771 / 732-0008',0,1,'L');
		$pdf->Cell(0,0,'Email: bonindustrial@skyinet.net',0,1,'L');

		$pdf->Ln();

		$pdf->Cell(0,0,date('j F Y',strtotime($header->ord_date)),0,1);

		$pdf->Ln();

		$pdf->Cell(0,0,strtoupper($header->supplier_name),0,1,'L');
		$pdf->Cell(0,0,$header->supplier_address,0,1,'L');
		$pdf->Cell(0,0,'Tel. No.: '.$header->supplier_tel,0,1,'L');
		$pdf->Cell(0,0,'Fax No.: '.$header->supplier_fax,0,1,'L');

		$pdf->Ln();
		$pdf->SetFont('helvetica', 'B', 13);
		$pdf->Cell(0,0,'Purchase Order '.strtoupper($header->reference),0,1,'C');

		$pdf->Ln();
		$pdf->SetFont('helvetica', 'B', 10.5);
		$pdf->Cell(16,6.5,'Item No.','LTB',0,'C');
		$pdf->Cell(30,6.5,'Code','TB',0,'C');
		$pdf->Cell(50,6.5,'Description','TB',0,'C');
		$pdf->Cell(25,6.5,'Grade','TB',0,'C');
		$pdf->Cell(25,6.5,'Price','TB',0,'C');
		$pdf->Cell(20,6.5,'Qty','TB',0,'C');
		$pdf->Cell(25,6.5,'Total','RTB',1,'C');

		$pdf->SetFont('helvetica', '', 10.5);
	}
	function pageBot(&$pdf,$header,$noted_by,$approved_by)
	{
		$pdf->Ln();
		$pdf->Ln();

		$pdf->SetFont('helvetica', '', 10.5);
		$pdf->Cell(70,0,'Prepared by',0,0,'L');
		$pdf->Cell(65,0,'Noted by',0,0,'L');
		$pdf->Cell(55,0,'Approved by',0,1,'L');

		$pdf->Ln();
		$pdf->Ln();

		$pdf->SetFont('helvetica', 'BI', 10.5);
		$pdf->Cell(70,0,implode(' ',array($header->person_fname,$header->person_mname,$header->person_lname)),0,0,'L');
		$pdf->Cell(65,0,$noted_by,0,0,'L');
		$pdf->Cell(55,0,$approved_by,0,1,'L');
	}

	declare_tcpdf();
	$CI =& get_instance();

	$y_limit = 219;

	$filename = "Purchase Order".strtoupper($header->reference).".pdf";
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
	pageHead($pdf,$header,$attention);
	$counter = 1;
	foreach ($details as $val) {
		$pdf->Cell(16,6.5,$counter,'LTB',0,'R');

		$start_size = 11;
		do {
			$start_size -= 0.5;
			$width = $pdf->GetStringWidth($val->item_code,'helvetica','',$start_size);
		} while ($width > 29);
		$pdf->SetFont('helvetica','',$start_size);
		$pdf->Cell(30,6.5,$val->item_code,'TB',0,'L');

		$start_size = 11;
		do {
			$start_size -= 0.5;
			$width = $pdf->GetStringWidth($val->name,'helvetica','',$start_size);
		} while ($width > 51);
		$pdf->SetFont('helvetica','',$start_size);
		$pdf->Cell(50,6.5,$val->name,'TB',0,'L');


		$start_size = 11;
		do {
			$start_size -= 0.5;
			$width = $pdf->GetStringWidth($val->grade,'helvetica','',$start_size);
		} while ($width > 51);
		$pdf->SetFont('helvetica','',$start_size);
		$pdf->Cell(25,6.5,$val->grade,'TB',0,'C');
		// $pdf->Cell(50,6.5,$val->name,'TB',0,'L');
		$pdf->SetFont('helvetica','',11);
		$pdf->Cell(25,6.5,'','TB',0,'C');

		$start_size = 11;
		do {
			$start_size -= 0.5;
			$width = $pdf->GetStringWidth($val->quantity_ordered,'helvetica','',$start_size);
		} while ($width > 51);
		$pdf->SetFont('helvetica','',$start_size);
		$pdf->Cell(20,6.5,$val->quantity_ordered,'TB',0,'R');

		$pdf->SetFont('helvetica','',11);
		$pdf->Cell(25,6.5,'','RTB',1,'C');
		$counter++;
		if ($pdf->getY() > $y_limit) {
			pageBot($pdf,$header,$noted_by,$approved_by);
			pageHead($pdf,$header,$attention);
		}
	}
	pageBot($pdf,$header,$noted_by,$approved_by);

	// $pdf->Cell(195,0,'Purchase Order '.strtoupper($header->reference),1,1,'C');





	$pdf->Output($filename, 'I');

?>