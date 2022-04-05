<?php


ini_set('MAX_EXECUTION_TIME', -1);
ini_set('mssql.connect_timeout',0);
ini_set('mssql.timeout',0);
set_time_limit(0);	
ini_set('memory_limit', '-1');

	$CI =& get_instance();
	$user = $this->session->userdata('user');
	date_default_timezone_set('Asia/Manila');
	$title = "Smart Transaction";
	$rep_content = "";
	$emp_abs_array = $monthly_absences_items = array();
	$no = 0;
	$total = 0;
	$det = array();
	$det = $CI->operation->get_smart_display_search($print_items['branch'],$print_items['or_num']);


	 $content ="
		<table width=\"70%\" cellpadding=\"3px\" border=\"0px\">
					<tr>
			<td style=\"font-size: 12px; font-weight: bold; text-align: center;\">Transaction Date</td>			
			<td style=\"font-size: 12px; font-weight: bold; text-align: center;\">Plan Code</td>
			<td style=\"font-size: 12px; font-weight: bold; text-align: center;\">Transaction Type</td>
			<td style=\"font-size: 12px; font-weight: bold; text-align: center;\">Branch Code</td>			
			<td style=\"font-size: 12px; font-weight: bold; text-align: center;\">OR No.</td>	
			<td style=\"font-size: 12px; font-weight: bold; text-align: center;\">Source Account</td>
			<td style=\"font-size: 12px; font-weight: bold; text-align: center;\">Amount Deduct</td>
			<td style=\"font-size: 12px; font-weight: bold; text-align: center;\">Target Sub-Account</td>
			<td style=\"font-size: 12px; font-weight: bold; text-align: center;\">Terminal ID</td>			
			<td style=\"font-size: 12px; font-weight: bold; text-align: center;\">Address</td>			
			<td style=\"font-size: 12px; font-weight: bold; text-align: center;\">Response Code</td>			
			<td style=\"font-size: 12px; font-weight: bold; text-align: center;\">Response Description</td>			
		</tr>
	 ";

	 $content .= "<tbody>";
	 	foreach ($det as $val) {
			$content .= "	

					<tr>
						<td style=\"font-size: 12px; font-weight: none; text-align: center;\">".$val->trans_date."</td>
						<td style=\"font-size: 12px; font-weight: none; text-align: center;\">".$val->planCode."</td>
						<td style=\"font-size: 12px; font-weight: none; text-align: center;\">".$val->transactionType."</td>
						<td style=\"font-size: 12px; font-weight: none; text-align: center;\">".$val->BranchCode."</td>
						<td style=\"font-size: 12px; font-weight: none; text-align: center;\">".$val->ORNo."</td>
						<td style=\"font-size: 12px; font-weight: none; text-align: center;\">".$val->sourceAccount."</td>
						<td style=\"font-size: 12px; font-weight: none; text-align: center;\">".$val->amountDeduct."</td>
						<td style=\"font-size: 12px; font-weight: none; text-align: center;\">".$val->targetSubsAccount."</td>
						<td style=\"font-size: 12px; font-weight: none; text-align: center;\">".$val->terminalID."</td>
						<td style=\"font-size: 12px; font-weight: none; text-align: center;\">".$val->address."</td>
						<td style=\"font-size: 12px; font-weight: none; text-align: center;\">".$val->respcode."</td>
						<td style=\"font-size: 12px; font-weight: none; text-align: center;\">".$val->respcodedesc."</td>
					</tr>
					";
		}
	 "</tbody></table>";

		ob_start();
		echo $content;
		$output = ob_get_clean();
		
		header("Content-type: application/x-msdownload; charset=UTF-8"); 
		header("Content-Disposition: attachment; filename=$title - ".date('d F Y').".xls");
		header("Pragma: no-cache"); 
		header("Expires: 0"); 
		echo $output;
?>