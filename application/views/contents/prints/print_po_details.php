<?php
	declare_tcpdf();
	$CI =& get_instance();
	
	date_default_timezone_set('Asia/Manila');
	
	$filename = "Purchase Order Details.pdf";
	$title = "Purchase Order Details";
	
	// class MyTCPDF extends TCPDF {
		// public function Footer(){
			// $this->SetY(4);
			// // $this->SetFont('helvetica','',10);
			// $this->SetFont('helvetica','',10);
			// $this->Cell(210, 0, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
		// }
	// }
	
	// $pdf = new MyTCPDF("L", "mm", 'FOLIO', true, 'UTF-8', false);
	$pdf = new TCPDF("L", "mm", 'FOLIO', true, 'UTF-8', false);
	
	$pdf->SetTitle($title);
	$pdf->SetTopMargin(10);
	$pdf->SetLeftMargin(10);
	$pdf->SetRightMargin(10);
	$pdf->SetFooterMargin(10);
	$pdf->SetAutoPageBreak(true, 15);
	// $pdf->SetAuthor('Author');
	$pdf->SetDisplayMode('real','default');
	$pdf->setPrintHeader(false);
	$pdf->setPrintFooter(true);
	
	$pdf->AddPage();
	$pdf->SetFont('helvetica', '', 10);
	
	$rep_content = "
	Purchase Order Details<br><br>
	<table width=\"100%\" cellpadding=\"1px\" border=\"1px\">
		<tr>
			<td style=\"font-size: 10px; font-weight: bold; text-align: center;\">Name</td>
			<td style=\"font-size: 10px; font-weight: bold; text-align: center;\" colspan=\"2\">Absences</td>
			<td style=\"font-size: 10px; font-weight: bold; text-align: center;\" colspan=\"2\">Undertime</td>
			<td style=\"font-size: 10px; font-weight: bold; text-align: center;\" colspan=\"2\">Tardiness</td>
			<td style=\"font-size: 10px; font-weight: bold; text-align: center;\">O.B.</td>
		</tr>
		<tr>
			<td style=\"font-size: 10px; font-weight: bold; font-style: italic; text-align: center;\">&nbsp;</td>
			<td style=\"font-size: 10px; font-weight: bold; font-style: italic; text-align: center;\">Frequency</td>
			<td style=\"font-size: 10px; font-weight: bold; font-style: italic; text-align: center;\">Total Hrs.</td>
			
			<td style=\"font-size: 10px; font-weight: bold; text-align: center;\">Frequency</td>
			<td style=\"font-size: 10px; font-weight: bold; text-align: center;\">Total Mins.</td>
			
			<td style=\"font-size: 10px; font-weight: bold; text-align: center;\">Frequency</td>
			<td style=\"font-size: 10px; font-weight: bold; text-align: center;\">Total Mins.</td>
			
			<td style=\"font-size: 10px; font-weight: bold; text-align: center;\">Frequency</td>
		</tr>
	";
	
	$rep_content .= "	
	</table>
	";
	
	$pdf->writeHTML($rep_content,true,false,false,false,'');
		
	// $pdf->Output($filename, 'E');
	return $pdf->Output($filename, 'S');
	// die();
	
	
	
?>