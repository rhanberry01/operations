<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$nav = array();
	
		
	$Operation['negative_inventory'] = array('title'=>'Negative Inventory ','path'=>'operation/negative_inventory','exclude'=>0);
	$Operation['no_display'] = array('title'=>'No Display','path'=>'operation/no_display','exclude'=>0);
	$Operation['cycle_count'] = array('title'=>'Cycle Count','path'=>'operation/cycle_count','exclude'=>0);
	$Operation['recount'] = array('title'=>'Manual Count','path'=>'operation/recount','exclude'=>0);
	$Operation['smart'] = array('title'=>'POS Eload Transactions','path'=>'operation/smart','exclude'=>0);
	$Operation['view_data'] = array('title'=>'Product History','path'=>'operation/view_data','exclude'=>0);
	$nav['operation'] = array('title'=>'<i class="fa fa-cubes"></i> <span>Inventory</span>','path'=>$Operation,'exclude'=>0);

	$Sales['Csales'] = array('title'=>'View Finished Sales','path'=>'sales/Csales','exclude'=>0);
	$nav['sales'] = array('title' => '<i class="fa fa-cube"></i> <span>Sales Checking<span>','path' => $Sales,'exclude'=>0);
	
	// $cycle['add_sku'] = array('title'=>'Add SKU','path'=>'cycle/add_sku','exclude'=>0);
	// $cycle['SKU_reload'] = array('title'=>'SKU Cycle Count List','path'=>'cycle/SKU_reload','exclude'=>0);
	// $nav['cycle'] = array('title'=>'<i class="fa fa-history"></i> <span>Cycle Count</span>','path'=>$cycle,'exclude'=>0);
	
	$controlSettings['user'] = array('title'=>'Users','path'=>'operation/users','exclude'=>0);
	$controlSettings['roles'] = array('title'=>'Roles','path'=>'admin/roles','exclude'=>0);
	$nav['control'] = array('title'=>'<i class="fa fa-gears"></i> <span>Setup</span>','path'=>$controlSettings,'exclude'=>0);
	// LAWRENZE
	$nav['price_match'] = array('title'=>'<i class="fa fa-file"></i> <span>Price Match Report</span>','path'=>'operation/price_match_report','exclude'=>0);
	// ./LAWRENZE
	$nav['logout'] = array('title'=>'<i class="fa fa-sign-out"></i> <span>Logout</span>','path'=>'site/go_logout','exclude'=>1);
	$config['sideNav'] = $nav;
