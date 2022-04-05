<?php


ini_set('MAX_EXECUTION_TIME', -1);
ini_set('mssql.connect_timeout',0);
ini_set('mssql.timeout',0);
set_time_limit(0);	
ini_set('memory_limit', '-1');

	$CI =& get_instance();
	$user = $this->session->userdata('user');
	date_default_timezone_set('Asia/Manila');
	$title = "Negative Inventory Excel";
	$rep_content = "";
	$emp_abs_array = $monthly_absences_items = array();
	$no = 0;
	$total = 0;
	$det = array();
	$det = $CI->operation->get_sort_details($print_items['category'],$print_items['supplier']);


	$content = "<table width=\"70%\" cellpadding=\"3px\" border=\"0px\">";

	// if($print_items['category'] != ""){
	//  $content .="
	// 	<table width=\"70%\" cellpadding=\"3px\" border=\"0px\">
	// 	<tr>
	// 		<td style=\"font-size: 16px; font-weight: bold; text-align: center; background-color:#b30000;color:white\">CATEGORY: ".$print_items['category']."</td>
	// 	</tr>
	//  ";
	// }

	 $content .="
	
		<tr>
			<td style=\"font-size: 16px; font-weight: bold; text-align: center; background-color:#b30000;color:white\">VENDOR CODE</td>
			<td style=\"font-size: 16px; font-weight: bold; text-align: center; background-color:#b30000;color:white\">VENDOR NAME</td>
			<td style=\"font-size: 16px; font-weight: bold; text-align: center; background-color:#b30000;color:white\">PRODUCT CATEGORY</td>
			<td style=\"font-size: 16px; font-weight: bold; text-align: center; background-color:#b30000;color:white\">PRODUCT CODE</td>
			<td style=\"font-size: 16px; font-weight: bold; text-align: center; background-color:#b30000;color:white\">DESCRIPTION</td>
			<td style=\"font-size: 16px; font-weight: bold; text-align: center; background-color:#b30000;color:white\">NEGATIVE QUANTITY</td>
		</tr>
	 ";

	 $content .= "<tbody>";
	 	foreach ($det as $val) {
			$content .= "	

					<tr>
						<td style=\"font-size: 12px; font-weight: bold; text-align: center;\">".$val->vendorcode."</td>
						<td style=\"font-size: 12px; font-weight: bold; text-align: center;\">".$val->vendor."</td>
						<td style=\"font-size: 12px; font-weight: bold; text-align: center;\">".$val->category."</td>
						<td style=\"font-size: 12px; font-weight: bold; text-align: center;mso-number-format:\@;width:200px;\">".$val->ProductCode."</td>
						<td style=\"font-size: 12px; font-weight: bold; text-align: center;\">".$val->Description."</td>
						<td style=\"font-size: 12px; font-weight: bold; text-align: center;\">".$val->SellingArea."</td>
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