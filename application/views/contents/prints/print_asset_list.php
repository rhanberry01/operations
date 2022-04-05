<?php
	$CI =& get_instance();
	$user = $this->session->userdata('user');
	date_default_timezone_set('Asia/Manila');
	
	$filename = "ado-ribells.pdf";
	$title = "ASSETS LIST";

	$rep_content = "";
	$no = 0;
	$det = array();
	$det = $CI->asset_model->get_asset_list($print_items['c_branch'],$print_items['asset_no'],$print_items['assined_p']);
	$rep_content = "
	<table width=\"100%\" cellpadding=\"1px\" border=\"1px\">
		<tr>
			<td style=\"font-size: 12px; font-weight: bold; text-align: center;\">Current Branch</td>
			<td style=\"font-size: 12px; font-weight: bold; text-align: center;\">Asset No</td>
			<td style=\"font-size: 12px; font-weight: bold; text-align: center;\">Description</td>
			<td style=\"font-size: 12px; font-weight: bold; text-align: center;\">Assigned Person</td>
			<td style=\"font-size: 12px; font-weight: bold; text-align: center;\">Date Acquired</td>
			<td style=\"font-size: 12px; font-weight: bold; text-align: center;\">Supplier</td>
			<td style=\"font-size: 12px; font-weight: bold; text-align: center;\">Invoice</td>
			<td style=\"font-size: 12px; font-weight: bold; text-align: center;\">Serial</td>
		</tr>
		";
	
	//echo var_dump($print_items);
	foreach ($det as $val) {

		$assigned_person = '';
		if ($val->assign_to == '-') {

			$assigned_person = 'No Assigned Person';

		}else{

			$assigned_person = $val->assign_to;
		}

		$rep_content .= "	
			<tr>
			<td style=\"font-size: 12px; font-weight: none; text-align: center;\">".$val->c_branch_code."</td>
			<td style=\"font-size: 12px; font-weight: none; text-align: center;\">".$val->asset_no."</td>
			<td style=\"font-size: 12px; font-weight: none; text-align: center;\">".$val->item_description."</td>
			<td style=\"font-size: 12px; font-weight: none; text-align: center;\">".$assigned_person."</td>
			<td style=\"font-size: 12px; font-weight: none; text-align: center;\">".$val->date_acquired."</td>
			<td style=\"font-size: 12px; font-weight: none; text-align: center;\">".$val->supplier."</td>
			<td style=\"font-size: 12px; font-weight: none; text-align: center;\">".$val->invoice_no."</td>
			<td style=\"font-size: 12px; font-weight: none; text-align: center;\">".$val->serial_no."</td>
		</tr>";
	}
	// $rep_content .= "	
	// 		<tr>
	// 		<td style=\"font-size: 12px; font-weight: none; text-align: center;\"></td>
	// 		<td style=\"font-size: 12px; font-weight: bold; text-align: center;\">Total:</td>
	// 		<td style=\"font-size: 12px; font-weight: none; text-align: center;\"></td>
	// 		<td style=\"font-size: 12px; font-weight: bold; text-align: center;\">".$total."</td>
	// 		<td style=\"font-size: 12px; font-weight: none; text-align: center;\"></td>
	// 		<td style=\"font-size: 12px; font-weight: none; text-align: center;\"></td>
	// 	</tr>";
	// $rep_content .= "	
	// </table>";
	
	
		ob_start();
		echo $rep_content;
		$output = ob_get_clean();
		
		header("Content-type: application/x-msdownload; charset=UTF-8"); 
		header("Content-Disposition: attachment; filename=$title - ".date('d F Y').".xls");
		header("Pragma: no-cache"); 
		header("Expires: 0"); 
		echo $output;
	
?>