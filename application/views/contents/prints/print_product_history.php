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
	$title = "Product History";



	$logo = BASEPATH.'../img/header_logo.png';
	$no = 0;
	$total = 0;
	$det = array();
	$det = $CI->operation->get_view_data_display_search($print_items['user_branch'],$print_items['description'],$print_items['barcode'],$print_items['fdate'],$print_items['tdate']);
	

	$content = "
		<table width=\"70%\" cellpadding=\"3px\" border=\"0px\">
		<tr>
			<td style=\"font-size: 16px; font-weight: bold; text-align: center; background-color:#b30000;color:white;\">Barcode</td>
			<td style=\"font-size: 12px; font-weight: bold; text-align: center; background-color:#b30000;color:white;\">Transaction ID</td>
			<td style=\"font-size: 12px; font-weight: bold; text-align: center; background-color:#b30000;color:white;\">Transaction #</td>
			<td style=\"font-size: 12px; font-weight: bold; text-align: center; background-color:#b30000;color:white;\">Date Posted</td>
			<td style=\"font-size: 12px; font-weight: bold; text-align: center; background-color:#b30000;color:white;\">Status</td>
			<td style=\"font-size: 12px; font-weight: bold; text-align: center; background-color:#b30000;color:white;\">Selling Area Stock</td>
            <td style=\"font-size: 12px; font-weight: bold; text-align: center; background-color:#b30000;color:white;\">Selling Area In</td>	
            <td style=\"font-size: 12px; font-weight: bold; text-align: center; background-color:#b30000;color:white;\">Selling Area Out</td>
            <td style=\"font-size: 12px; font-weight: bold; text-align: center; background-color:#b30000;color:white;\">Damage In</td>	
            <td style=\"font-size: 12px; font-weight: bold; text-align: center; background-color:#b30000;color:white;\">Damage Out</td>
            <td style=\"font-size: 12px; font-weight: bold; text-align: center; background-color:#b30000;color:white;\">Unitcost</td>
			<td style=\"font-size: 12px; font-weight: bold; text-align: center; background-color:#b30000;color:white;\">Posted by</td>	
		</tr>
		";
			$content .="<tbody>";
			
			if($det){
					foreach ($det as $val) {
						
					$BeginningStockRoom = $val->BeginningStockRoom == NULL ? '0' : $val->BeginningStockRoom;
					$StockRoomIn =	$val->StockRoomIn == NULL ? '0' : $val->StockRoomIn;
					$StockRoomOut = $val->StockRoomOut == NULL ? '0' : $val->StockRoomOut;
					$UnitCost = $val->UnitCost == NULL ? '0' : $val->UnitCost;
					$Name = $val->Name == NULL ? 'N/A' : $val->Name;

					$content .= "	
					<tr>

						<td style=\"font-size: 12px; font-weight: none; text-align: center;\">".$val->Barcode."</td>
						<td style=\"font-size: 12px; font-weight: none; text-align: center;\">".$val->TransactionID."</td>
						<td style=\"font-size: 12px; font-weight: none; text-align: center;\">".$val->TransactionNo."</td>
						<td style=\"font-size: 12px; font-weight: none; text-align: center;\">".$val->DatePosted."</td>
						<td style=\"font-size: 12px; font-weight: none; text-align: center;\">".$val->Description2."</td>
						<td style=\"font-size: 12px; font-weight: none; text-align: center;\">".$BeginningStockRoom."</td>
                        <td style=\"font-size: 12px; font-weight: none; text-align: center;\">".$val->SellingAreaIn."</td>
						<td style=\"font-size: 12px; font-weight: none; text-align: center;\">".$val->SellingAreaOut."</td>
						<td style=\"font-size: 12px; font-weight: none; text-align: center;\">".$StockRoomIn."</td>
						<td style=\"font-size: 12px; font-weight: none; text-align: center;\">".$StockRoomOut."</td>
						<td style=\"font-size: 12px; font-weight: none; text-align: center;\">".$UnitCost."</td>
						<td style=\"font-size: 12px; font-weight: none; text-align: center;\">".$Name."</td>
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