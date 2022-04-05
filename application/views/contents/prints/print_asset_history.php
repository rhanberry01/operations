<?php
	$CI =& get_instance();
	$user = $this->session->userdata('user');
	date_default_timezone_set('Asia/Manila');
	
	$filename = "ado-ribells.pdf";
	$title = "ASSETS LIST";
	$asset_no = $CI->asset_model->get_asset_no($asset_id['id']);
	$rep_content = "";
	$no = 0;
	$det = array();
	$det = $CI->asset_model->get_asset_history_details($asset_id['id']);
	$rep_content = "
	<table width=\"100%\" cellpadding=\"3px\" border=\"0px\">";
		$rep_content .="<tbody>";
			$rep_content .= "<tr>
			<td colspan=\"5\" width=\"20%\" style=\"text-align:center; font-size:15px;\"><b>".$asset_no."</b></td>
		</tr>";
	
		
	$rep_content .= "</tbody></table>";

	$rep_content .= "
	<table width=\"100%\" cellpadding=\"1px\" border=\"1px\">
		<tr>
			<td style=\"font-size: 12px; font-weight: bold; text-align: center;\">Branch</td>
			<td style=\"font-size: 12px; font-weight: bold; text-align: center;\">Department</td>
			<td style=\"font-size: 12px; font-weight: bold; text-align: center;\">Time</td>
			<td style=\"font-size: 12px; font-weight: bold; text-align: center;\">Nature Of Movement</td>
			<td style=\"font-size: 12px; font-weight: bold; text-align: center;\">Remarks</td>
		</tr>
		";
	
	foreach ($det as $val) {

		$type = '';
		if($val->type == 'OUT'){
			$type = 'TRANSFER OUT';
		}elseif($val->type == 'IN'){
			$type = 'TRANSFER IN';
		}else{
			$type = '';
		}

		$department = $CI->asset_model->department_name($val->department_code);
		$branch = $CI->asset_model->get_branch_desc($val->branch_code);

		$rep_content .= "	
			<tr>
			<td style=\"font-size: 12px; font-weight: none; text-align: center;\">".$branch."</td>
			<td style=\"font-size: 12px; font-weight: none; text-align: center;\">".$department."</td>
			<td style=\"font-size: 12px; font-weight: none; text-align: center;\">".date("Y-m-d h:i:sa",strtotime($val->stamp))."</td>
			<td style=\"font-size: 12px; font-weight: none; text-align: center;\">".$type."</td>
			<td style=\"font-size: 12px; font-weight: none; text-align: center;\"></td>
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