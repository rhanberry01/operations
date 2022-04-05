<?php
	$CI =& get_instance();
	$user = $this->session->userdata('user');
	date_default_timezone_set('Asia/Manila');
	/*$Vname = $CI->sales_model->GetOfftakeName($print_items['branch'],$print_items['description']);
	$BranchName = $CI->sales_model->GetBranchName($print_items['branch']);*/
	$title =  "POSSIBLE NO DISPLAY _".$print_items['date_']."";
	
	$user_id = $user['id']; 
    $user_branch = $user['branch']; 
    $aria_db = $this->operation->get_aria_db($user_branch);

	$rep_content = "";
	$logo = BASEPATH.'../img/header_logo.png';
	$no = 0;
	$total = 0;
	$sales = 0;
	$profit = 0;
	$costofsales = 0;

	$det = array();
	
	$det = $CI->operation->get_no_display_search($print_items['branch'],str_replace('-','/',$print_items['date_']));

	$content = "
		<table width=\"70%\" cellpadding=\"3px\" border=\"0px\">
			<tr>
				<td colspan='7'>Branch: ".$aria_db->description."</td>
			</tr>
					<tr>
			<td style=\"font-size: 12px; font-weight: bold; text-align: center;\">PRODUCT ID</td>
			<td style=\"font-size: 12px; font-weight: bold; text-align: center;\">DESCRIPTION</td>
			<td style=\"font-size: 12px; font-weight: bold; text-align: center;\">CURRENT INV AS OF '".$print_items['date_']."'</td>
			<td style=\"font-size: 12px; font-weight: bold; text-align: center;\">PASE 30 DAYS SALES</td>
			<td style=\"font-size: 12px; font-weight: bold; text-align: center;\">AVERAGE SALES</td>
			<td style=\"font-size: 12px; font-weight: bold; text-align: center;\">PAST 1 DAY SALES</td>
			<td style=\"font-size: 12px; font-weight: bold; text-align: center;\">REMARKS</td>				
		</tr>
		";

			$content .="<tbody>";
			
			if($det){

					foreach ($det as $val) {


					$content .= "	

					<tr>
						<td style=\"font-size: 12px; font-weight: none; text-align: center;\">".$val->productid."</td>
						<td style=\"font-size: 12px; font-weight: none; text-align: center;\">".$val->descripiton."</td>
						<td style=\"font-size: 12px; font-weight: none; text-align: center;\">".$val->currentinventory."</td>
						<td style=\"font-size: 12px; font-weight: none; text-align: center;\">".$val->past30days."</td>
						<td style=\"font-size: 12px; font-weight: none; text-align: center;\">".$val->average."</td>
						<td style=\"font-size: 12px; font-weight: none; text-align: center;\">".$val->past2days."</td>
						<td style=\"font-size: 12px; font-weight: none; text-align: center;\">".$val->remarks."</td>

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