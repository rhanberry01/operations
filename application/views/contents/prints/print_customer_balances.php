<?php

	function pageHead(&$pdf,$end_date,$fiscal_year,$user)
	{
		$pdf->AddPage();
		$pdf->SetFont('times', 'B', 22);
		$pdf->Cell(0,0,'BON Industrial Sales',0,1,'L');

		$pdf->SetLineWidth(0.5);
		$pdf->SetDrawColor(80,80,80);
		$pdf->Line($pdf->GetX(),$pdf->GetY(),206,$pdf->GetY());

		$pdf->SetY($pdf->GetY() + 2);
		$pdf->SetFont('helvetica', 'B', 12);
		$pdf->Cell(0,0,'Customer Balances',0,1,'L');
		$pdf->SetFont('helvetica', '', 8.5);
		$pdf->Cell(25,6,'Active fiscal year:',0,0,'L');
		if ($fiscal_year) {
			$pdf->Cell(70,6,date('j F Y',strtotime($fiscal_year->begin_date))."  -  ".date('j F Y',strtotime($fiscal_year->end_date)),0,0,'L');
		}
		else
			$pdf->Cell(70,6,'None',0,0,'L');
		$pdf->Cell(20,6,'Printed by:',0,0,'L');
		$pdf->Cell(65,6,$user['full_name'],0,1,'L');
		$pdf->Cell(25,6,'End Date:',0,0,'L');
		$pdf->Cell(70,6,date('j F Y',strtotime($end_date)),0,0,'L');
		$pdf->Cell(20,6,'Print Date:',0,0,'L');
		$pdf->Cell(65,6,date('j F Y    h:i T'),0,1,'L');

		$pdf->SetLineWidth(0.5);
		$pdf->SetDrawColor(80,80,80);
		$pdf->SetY($pdf->GetY() + 2);
		$pdf->Line($pdf->GetX(),$pdf->GetY(),206,$pdf->GetY());

		$pdf->SetFont('helvetica', '', 10.5);
	}
	function printColumnNames(&$pdf)
	{
		$pdf->Ln();
		$pdf->SetFont('','I',8.5);
		$pdf->Cell(34,6,'Transaction Type',1,0,'C');
		$pdf->Cell(30,6,'Reference',1,0,'C');
		$pdf->Cell(23,6,'Trans Date',1,0,'C');
		$pdf->Cell(23,6,'Due Date',1,0,'C');
		$pdf->Cell(29,6,'Charges',1,0,'C');
		$pdf->Cell(28,6,'Credits',1,0,'C');
		$pdf->Cell(29,6,'Outstanding',1,1,'C');
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

	$y_limit = 240;

	$filename = "Customer Balances.pdf";
	$title = "Sales Invoice";

	class MyTCPDF extends TCPDF {
		public function Footer(){
			$this->SetY(15);
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

	pageHead($pdf,$end_date,$curr_fiscal_year,$user);

	$is_empty = true;

	foreach ($rows as $val) {
		if (!$val['data'])
			continue;

		$is_empty = false;

		$debt_charge = $debt_cred = $debt_out = 0;

		$pdf->SetY($pdf->GetY() + 3);
		$pdf->SetFont('helvetica','B',12);
		$pdf->Cell(0,8,'['.$val['code'].'] '.$val['name'],0);

		printColumnNames($pdf);


		$pdf->SetFont('','',9);


		if (isset($val['data']['prev'])) {
			foreach ($val['data']['prev'] as $fiscal_end => $bal) {
				if ($pdf->GetY() > $y_limit) {
					pageHead($pdf,$end_date,$curr_fiscal_year,$user);
					printColumnNames($pdf);
				}
				$pdf->SetFillColor(245,245,245);
				$pdf->Cell(167, 6, 'Outstanding balances from the fiscal year ending on '.date('F j Y',strtotime($fiscal_end)), 0, 0, 'L', true);
				$pdf->Cell(29, 6, number_format($bal,2), 0, 1, 'R', true);

				$debt_out += $bal;
			}
		}

		if (isset($val['data']['curr'])) {
			foreach ($val['data']['curr'] as $vv) {
				if ($pdf->GetY() > $y_limit) {
					pageHead($pdf,$end_date,$curr_fiscal_year,$user);
					printColumnNames($pdf);
				}

				$pdf->Cell(34, 6, $vv['trans_name'], 0, 0, 'L');
				$pdf->Cell(30, 6, $vv['trans_ref'], 0, 0, 'L');
				$pdf->Cell(23, 6, $vv['trans_date'], 0,0,'C');
				$pdf->Cell(23, 6, $vv['due_date'], 0,0,'C');

				if ($vv['trans_amount'] > 0) {
					$outstanding = $vv['trans_amount'] - $vv['allocated_amount'];

					$pdf->Cell(29, 6, number_format($vv['trans_amount'],2), 0, 0, 'R');
					$pdf->Cell(28, 6, "", 0, 0, 'R');
					$pdf->Cell(29, 6, $outstanding ? number_format($outstanding,2) : "",0,1,'R');

					$debt_charge += $vv['trans_amount'];
					$debt_out    += $outstanding;
				} else {
					$disp_amount = abs($vv['trans_amount']);
					$outstanding = $vv['trans_amount'] + $vv['allocated_amount'];

					$pdf->Cell(29, 6, "", 0, 0, 'R');
					$pdf->Cell(28, 6, number_format($disp_amount,2), 0, 0, 'R');
					$pdf->Cell(29, 6, $outstanding ? number_format($outstanding,2) : "",0,1,'R');

					$debt_cred += $disp_amount;
					$debt_out  += $outstanding;
				}
			}
		}

		$pdf->SetFont('','B',9);
		$pdf->SetFillColor(221,234,231);
		$pdf->Cell(110, 6, strtoupper('['.$val['code'].'] '.$val['name']).' TOTAL', 0, 0, 'C', true);
		$pdf->Cell(29, 6, number_format($debt_charge,2), 0, 0, 'R', true);
		$pdf->Cell(28, 6, number_format(abs($debt_cred),2), 0, 0, 'R', true);
		$pdf->Cell(29, 6, number_format($debt_out,2), 0, 1, 'R', true);
	}

	$pdf->Output($filename, 'I');

?>