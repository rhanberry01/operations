<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "site";
$route['404_override'] = '';


$route['login'] = "site/login";

# USER #
	$route['user'] = "core/user";
	$route['user/(:any)'] = "core/user/$1";

# ADMIN #
	$route['admin'] = "core/admin";
	$route['admin/(:any)'] = "core/admin/$1";

# WAGON #
	$route['wagon'] = "core/wagon";
	$route['wagon/(:any)'] = "core/wagon/$1";

# SALES
	$route['sales/reports'] = "core/sales_reports";
	$route['sales/reports/(:any)'] = "core/sales_reports/$1";
	$route['sales'] = "core/sales";
	$route['sales/(:any)'] = "core/sales/$1";
# SALES REPORTS	
	$route['sales_reports'] = "core/sales_reports";
	$route['sales_reports/(:any)'] = "core/sales_reports/$1";
	
# PURCHASING - OLD PO #
	$route['purchasing'] = "core/purchasing";
	$route['purchasing/(:any)'] = "core/purchasing/$1";

# NEW PO #
	$route['po'] = "core/po";
	$route['po/(:any)'] = "core/po/$1";

	$route['po_inquiries'] = "core/po_inquiries";
	$route['po_inquiries/(:any)'] = "core/po_inquiries/$1";
	
	$route['po_prints/(:any)'] = "core/po_prints/$1";

# RECEIVING - NEW #
	$route['receiving'] = "core/receiving";
	$route['receiving/(:any)'] = "core/receiving/$1";
	
# INVENTORY #
	$route['inventory'] = "core/inventory";
	$route['inventory/(:any)'] = "core/inventory/$1";
	
	$route['inv_inquiries'] = "core/inv_inquiries";
	$route['inv_inquiries/(:any)'] = "core/inv_inquiries/$1";
	
	$route['upd_inquiries'] = "core/upd_inquiries";
	$route['upd_inquiries/(:any)'] = "core/upd_inquiries/$1";
	
	$route['inv_transactions'] = "core/inv_transactions";
	$route['inv_transactions/(:any)'] = "core/inv_transactions/$1";

# GENERAL LEDGER
	$route['general_ledger'] = "core/general_ledger";
	$route['general_ledger/(:any)'] = "core/general_ledger/$1";

# setup #
	$route['setup'] = "core/setup";
	$route['setup/(:any)'] = "core/setup/$1";

# customer #
	$route['customer'] = "core/customer";
	$route['customer/(:any)'] = "core/customer/$1";
	
# product - test #
	$route['product'] = "core/product";
	$route['product/(:any)'] = "core/product/$1";
	
# cashier - test #	
	$route['cashier'] = "core/cashier";
	$route['cashier/(:any)'] = "core/cashier/$1";
	
# AUDIT TRAIL #
	$route['audit'] = "core/audit";
	$route['audit/(:any)'] = "core/audit/$1";
	
# AUDIT TRAIL #
	$route['main_uploader'] = "core/main_uploader";
	$route['main_uploader/(:any)'] = "core/main_uploader/$1";
	
# POS #
	$route['pos'] = "core/pos";
	$route['pos/(:any)'] = "core/pos/$1";
	
# Asset #
	$route['asset'] = "core/asset";
	$route['asset/(:any)'] = "core/asset/$1";

# Operation #
	$route['operation'] = "core/operation";
	$route['operation/(:any)'] = "core/operation/$1";

# Cycle #
	$route['cycle'] = "core/cycle";
	$route['cycle/(:any)'] = "core/cycle/$1";

/* End of file routes.php */
/* Location: ./application/config/routes.php */