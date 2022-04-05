<?php
	$CI =& get_instance();
	$user = $this->session->userdata('user');
	date_default_timezone_set('Asia/Manila');
	/*$Vname = $CI->sales_model->GetOfftakeName($print_items['branch'],$print_items['description']);
	$BranchName = $CI->sales_model->GetBranchName($print_items['branch']);*/
	
	//$id = $print_item['id'];
	$rep_content = "";
	$logo = BASEPATH.'../img/header_logo.png';
	$no = 0;
	$total = 0;
	$sales = 0;
	$profit = 0;
	$costofsales = 0;
	$category = "";
	$det = array();
	  $det = $CI->operation->get_variance_report_details($print_items['id']);

	$content = "
		<table width=\"70%\" cellpadding=\"3px\" border=\"0px\">
					<tr>
			<td style=\"font-size: 12px; font-weight: bold; text-align: center;\">Transaction#</td>
			<td style=\"font-size: 12px; font-weight: bold; text-align: center;\">Product ID</td>
			<td style=\"font-size: 12px; font-weight: bold; text-align: center;\">Description</td>
			<td style=\"font-size: 12px; font-weight: bold; text-align: center;\">Barcode</td>
			<td style=\"font-size: 12px; font-weight: bold; text-align: center;\">Actual QTY</td>
			<td style=\"font-size: 12px; font-weight: bold; text-align: center;\">Database QTY(SA)</td>
			<td style=\"font-size: 12px; font-weight: bold; text-align: center;\">Database QTY(BO)</td>
			<td style=\"font-size: 12px; font-weight: bold; text-align: center;\">Variance</td>
			<td style=\"font-size: 12px; font-weight: bold; text-align: center;\">Cost Of Sale</td>
			<td style=\"font-size: 12px; font-weight: bold; text-align: center;\">Total Cost</td>
			<td style=\"font-size: 12px; font-weight: bold; text-align: center;\">Movement</td>
					
		</tr>
		";

			$content .="<tbody>";
			
			if($det){

					foreach ($det as $val) {

					$total_cost = ($val->TransNo != "") ? ((double)$val->Variance * (double)$val->CostOfSale) : "";
					$category = $val->CategoryName;
					$movement = ((double)$val->Variance > 0) ? "Inventory Gain" : (($val->TransNo != "") ? "Inventory Loss": "");
					$content .= "	
	
					<tr>
						<td style=\"font-size: 12px; font-weight: none; text-align: center;\">".$val->TransNo."</td>
						<td style=\"font-size: 12px; font-weight: none; text-align: center;\">".$val->ProductID."</td>
						<td style=\"font-size: 12px; font-weight: none; text-align: center;\">".$val->Description."</td>
						<td style=\"font-size: 12px; font-weight: none; text-align: center;\">".$val->Barcode."</td>
						<td style=\"font-size: 12px; font-weight: none; text-align: center;\">".$val->ActualCount."</td>
						<td style=\"font-size: 12px; font-weight: none; text-align: center;\">".$val->FreezeInv."</td>
						<td style=\"font-size: 12px; font-weight: none; text-align: center;\">".$val->Damaged."</td>
						<td style=\"font-size: 12px; font-weight: none; text-align: center;\">".$val->Variance."</td>
						<td style=\"font-size: 12px; font-weight: none; text-align: center;\">".$val->CostOfSale."</td>
						<td style=\"font-size: 12px; font-weight: none; text-align: center;\">".$total_cost."</td>
						<td style=\"font-size: 12px; font-weight: none; text-align: center;\">".$movement."</td>

					
					</tr>";


				}
			}else
			{
					$content .= 
					"<tr>
						<td style=\"font-size: 12px; font-weight: none; text-align: center;\">Empty</td>
						
					
					</tr>";
			}
		
				
				$content .= "</tbody></table>";
	
		ob_start();
		echo $content;
		$output = ob_get_clean();
		
		$title =  "VARIANCE REPORT ".$print_items['branch']." $category";

		header("Content-type: application/x-msdownload; charset=UTF-8"); 
		header("Content-Disposition: attachment; filename=$title - ".date('d F Y').".xls");
		header("Pragma: no-cache"); 
		header("Expires: 0"); 
		echo $output;
	
?>