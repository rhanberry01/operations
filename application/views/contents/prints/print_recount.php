<?php
	$CI =& get_instance();
	$user = $this->session->userdata('user');
	date_default_timezone_set('Asia/Manila');
	/*$Vname = $CI->sales_model->GetOfftakeName($print_items['branch'],$print_items['description']);
	$BranchName = $CI->sales_model->GetBranchName($print_items['branch']);*/
	$title =  "RECOUNT _".$print_items['date_']."";
	
	
	$rep_content = "";
	$logo = BASEPATH.'../img/header_logo.png';
	$no = 0;
	$total = 0;
	$sales = 0;
	$profit = 0;
	$costofsales = 0;

	$det = array();

	$det = $CI->operation->r_get_auto_details2();
	//$det = $CI->operation->get_no_display_search($print_items['branch'],str_replace('-','/',$print_items['date_']));

	$content = "
		<table width=\"70%\" cellpadding=\"3px\" border=\"0px\">
					<tr>
			<td style=\"font-size: 12px; font-weight: bold; text-align: center;\">PRODUCT ID</td>
			<td style=\"font-size: 12px; font-weight: bold; text-align: center;\">BARCODE</td>
			<td style=\"font-size: 12px; font-weight: bold; text-align: center;\">DESCRIPTION</td>
			<td style=\"font-size: 12px; font-weight: bold; text-align: center;\">UOM</td>
			<td style=\"font-size: 12px; font-weight: bold; text-align: center;\">COST OF SALES</td>
			<td style=\"font-size: 12px; font-weight: bold; text-align: center;\">QUANTITY INVENTORY</td>
					
		</tr>
		";

			$content .="<tbody>";
			
			if($det){

					foreach ($det as $val) {


					$content .= "	

					<tr>
						<td style=\"font-size: 12px; font-weight: none; text-align: center;\">".$val->ProductID."</td>
						<td style=\"font-size: 12px; font-weight: none; text-align: center;\">".$val->Barcode."</td>
						<td style=\"font-size: 12px; font-weight: none; text-align: center;\">".$val->Description."</td>
						<td style=\"font-size: 12px; font-weight: none; text-align: center;\">".$val->uom."</td>
						<td style=\"font-size: 12px; font-weight: none; text-align: center;\">".$val->CostOfSales."</td>
						<td style=\"font-size: 12px; font-weight: none; text-align: center;\">".$val->SellingArea."</td>
					
					</tr>";


				}
			}
		
				
				$content .= "</tbody></table>";
	
		ob_start();
		echo $content;
		$output = ob_get_clean();
		
		header("Content-type: application/x-msdownload; charset=UTF-8"); 
		header("Content-Disposition: attachment; filename=$title - ".date('d F Y').".xls");
		header("Pragma: no-cache"); 
		header("Expires: 0"); 
		echo $output;
	
?>