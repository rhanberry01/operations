<?php
	//--------------------- DAN ------------------------//
ini_set('MAX_EXECUTION_TIME', -1);
ini_set('mssql.connect_timeout',0);
ini_set('mssql.timeout',0);
set_time_limit(0);	
ini_set('memory_limit', '-1');


	$CI =& get_instance();
	$user = $this->session->userdata('user');
	date_default_timezone_set('Asia/Manila');
	$title = "Checking Sales";



	$logo = BASEPATH.'../img/header_logo.png';
	$no = 0;
	$total = 0;
    $det = array();
    if($print_items['barcode']){
	    $det = $CI->sales_model->get_fsales_data($print_items['user_branch'],$print_items['from_date'],$print_items['t_date'],$print_items['barcode']);
    }else{
	    $det = $CI->sales_model->get_fsales_data_($print_items['user_branch'],$print_items['from_date'],$print_items['t_date'],$print_items['barcode']);
    }

	$content = "
		<table width=\"70%\" cellpadding=\"3px\" border=\"0px\">
		<tr>
            <td style=\"font-size: 16px; font-weight: bold; text-align: center; background-color:#b30000;color:white;\">lineID</td>
            <td style=\"font-size: 12px; font-weight: bold; text-align: center; background-color:#b30000;color:white;\">ProductCode</td>
            <td style=\"font-size: 12px; font-weight: bold; text-align: center; background-color:#b30000;color:white;\">Transaction No</td>
            <td style=\"font-size: 12px; font-weight: bold; text-align: center; background-color:#b30000;color:white;\">Barcode</td>
            <td style=\"font-size: 12px; font-weight: bold; text-align: center; background-color:#b30000;color:white;\">Description</td>
            <td style=\"font-size: 12px; font-weight: bold; text-align: center; background-color:#b30000;color:white;\">UOM</td>
            <td style=\"font-size: 12px; font-weight: bold; text-align: center; background-color:#b30000;color:white;\">Qty</td>	
            <td style=\"font-size: 12px; font-weight: bold; text-align: center; background-color:#b30000;color:white;\">Packing</td>
            <td style=\"font-size: 12px; font-weight: bold; text-align: center; background-color:#b30000;color:white;\">TotalQty</td>	
            <td style=\"font-size: 12px; font-weight: bold; text-align: center; background-color:#b30000;color:white;\">AverageUnitCost</td>
            <td style=\"font-size: 12px; font-weight: bold; text-align: center; background-color:#b30000;color:white;\">LandedCost</td>
            <td style=\"font-size: 12px; font-weight: bold; text-align: center; background-color:#b30000;color:white;\">Price</td>	
            <td style=\"font-size: 12px; font-weight: bold; text-align: center; background-color:#b30000;color:white;\">Extended</td>	
            <td style=\"font-size: 12px; font-weight: bold; text-align: center; background-color:#b30000;color:white;\">PriceModeCode</td>	
            <td style=\"font-size: 12px; font-weight: bold; text-align: center; background-color:#b30000;color:white;\">UserID</td>	
            <td style=\"font-size: 12px; font-weight: bold; text-align: center; background-color:#b30000;color:white;\">Price Override</td>	
            <td style=\"font-size: 12px; font-weight: bold; text-align: center; background-color:#b30000;color:white;\">TerminalNo</td>	
            <td style=\"font-size: 12px; font-weight: bold; text-align: center; background-color:#b30000;color:white;\">LogDate</td>	
            <td style=\"font-size: 12px; font-weight: bold; text-align: center; background-color:#b30000;color:white;\">Return</td>	
            <td style=\"font-size: 12px; font-weight: bold; text-align: center; background-color:#b30000;color:white;\">Voided</td>	
		</tr>
		";
			$content .="<tbody>";
			
			if($det){
					foreach ($det as $val) {
                        $userc = $CI->sales_model->get_cashier_user($print_items['user_branch'],$val->UserID);
					$content .= "	
					<tr>

						<td style=\"font-size: 12px; font-weight: none; text-align: center;\">".$val->lineID."</td>
						<td style=\"font-size: 12px; font-weight: none; text-align: center;\">".$val->ProductCode."</td>
						<td style=\"font-size: 12px; font-weight: none; text-align: center;\">".$val->TransactionNo."</td>
						<td style=\"font-size: 12px; font-weight: none; text-align: center;\">".$val->Barcode."</td>
                        <td style=\"font-size: 12px; font-weight: none; text-align: center;\">".$val->Description."</td>
                        <td style=\"font-size: 12px; font-weight: none; text-align: center;\">".$val->UOM."</td>
                        <td style=\"font-size: 12px; font-weight: none; text-align: center;\">".$val->Qty."</td>
                        <td style=\"font-size: 12px; font-weight: none; text-align: center;\">".$val->Packing."</td>
                        <td style=\"font-size: 12px; font-weight: none; text-align: center;\">".$val->TotalQty."</td>
                        <td style=\"font-size: 12px; font-weight: none; text-align: center;\">".$val->AverageUnitCost."</td>
                        <td style=\"font-size: 12px; font-weight: none; text-align: center;\">".$val->LandedCost."</td>
                        <td style=\"font-size: 12px; font-weight: none; text-align: center;\">".$val->Price."</td>
                        <td style=\"font-size: 12px; font-weight: none; text-align: center;\">".$val->Extended."</td>
                        <td style=\"font-size: 12px; font-weight: none; text-align: center;\">".$val->PriceModeCode."</td>         <td style=\"font-size: 12px; font-weight: none; text-align: center;\">".$userc."</td>
                        <td style=\"font-size: 12px; font-weight: none; text-align: center;\">".$val->PriceOverride."</td>         <td style=\"font-size: 12px; font-weight: none; text-align: center;\">".$val->TerminalNo."</td>
                        <td style=\"font-size: 12px; font-weight: none; text-align: center;\">".$val->LogDate."</td>               <td style=\"font-size: 12px; font-weight: none; text-align: center;\">".$val->return."</td>
                        <td style=\"font-size: 12px; font-weight: none; text-align: center;\">".$val->voided."</td>
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
    
	//--------------------- DAN ------------------------//
?>