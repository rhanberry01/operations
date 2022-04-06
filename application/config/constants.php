<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);
/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

#DEFINE TERMINAL DETAILS
define('TERMINAL_ID',			'1');

define('BRANCH_OP','TMAR2');

#DEFINE BRANCH DETAILS
define('BRANCH_CODE',			'IFOODSBRNCH001');

define('SALES_TRANS',			'10');
define('SALES_VOID_TRANS',		'11');
define('RECEIVE_TRANS',			'20');
define('ADJUSTMENT_TRANS',		'30');

#DEFINE BASE_TAX
define('BASE_TAX',0.12); // Please use base tax form (eg. 0.12) not num form (12)
define('DISCOUNT_THRESHOLD',10);

define('JOURNAL_ENTRY',1);
define('BANK_PAYMENT',2);
define('BANK_DEPOSIT',3);
define('FUNDS_TRANSFER',4);
define('SALES_INVOICE',5);
define('CUSTOMER_CREDIT_NOTE',6);
define('CUSTOMER_PAYMENT',7);
define('DELIVERY_NOTE',8);
define('LOCATION_TRANSFER',9);
define('INVENTORY_ADJUSTMENT',10);
define('PURCHASE_ORDER',11);
define('SUPPLIER_INVOICE',12);
define('SUPPLIER_CREDIT_NOTE',13);
define('SUPPLIER_PAYMENT',14);
define('PURCHASE_ORDER_DELIVERY',15);
define('WORK_ORDER',16);
define('WORK_ORDER_ISSUE',17);
define('WORK_ORDER_PRODUCTION',18);
define('SALES_ORDER',19);
define('COST_UPDATE',20);
define('DIMENSION',21);
define('CASH_INVOICE',22);
define('DELIVERY_RETURN',23);
define('POSITIVE_ADJUSTMENT',24);
define('NEGATIVE_ADJUSTMENT',25);

define('LOCAL_ITEM','HW-LOCAL'); # Value must be equal to that of DB views

#AUDIT TRAIL
define('ADD_STOCK', 'Add Stock');
define('ADD_BARCODE', 'Add Stock Barcode');
define('ADD_BARCODE_PRICE', 'Add Stock Barcode Price');
define('ADD_SUPP_STOCK', 'Add Supplier Stock');
define('ADD_SINGLE_STOCK_MARKDOWN', 'Add Single Stock Barcode Markdown');
define('ADD_ALL_STOCK_MARKDOWN', 'Add Stock Barcode Markdown - All Branches');
define('ADD_STOCK_COST_OF_SALES', 'Add Stock Cost of Sales');
define('ADD_CUSTOMER', 'Add Customer');
define('ADD_CUSTOMER_CARD_TYPES', 'Add Customer Card Types');
define('ADD_CUSTOMER_CARDS', 'Add Customer Cards');
define('ADD_SALES_PERSONS', 'Add Sales Persons');
define('ADD_CUSTOMER_BRANCHES', 'Add Customer Branches');
define('ADD_CURRENCY', 'Add Currency');
define('ADD_BRANCH', 'Add Branch');
define('ADD_PAYMENT_TYPE', 'Add Payment Type');
define('ADD_PAYMENT_TYPE_CODE', 'Add Payment Type Code');
define('ADD_ACQUIRING_BANKS', 'Add Acquiring Bank');
define('ADD_DISCOUNT_TYPE', 'Add Discount Type');
define('ADD_UNIT_OF_MEASURE', 'Add Unit of Measurement');
define('ADD_STOCK_LOCATION', 'Add Stock Location');
define('ADD_STOCK_CATEGORY', 'Add Stock Category');
define('ADD_USER', 'Add New User');
define('ADD_MOVEMENT_TYPE', 'Add Movement Type');
define('ADDED_MOVEMENT_ENTRY', 'Added Movement Entry');
define('ADDED_PURCHASE_ORDER', 'Added Purchase Orders');
define('ADDED_BRANCH_COUNTER', 'Added Branch Counter');
define('APPROVED_STOCK', 'Approved Stock');
define('APPROVED_STOCK_BARCODE_PRICE', 'Approved Stock Barcode Price');
define('APPROVED_SUPPLIER_STOCK', 'Approved Supplier Stock');
define('APPROVED_SCHEDULE_MARKDOWN', 'Approved Schedule Markdown');
define('APPROVED_MOVEMENT_ENTRY', 'Approved Movement Entry');
define('APPROVED_PURCHASE_ORDER', 'Approved Purchase Orders');
define('APPROVED_BILLER_CODE', 'Approved Biller Code');
define('APPROVED_STOCK_DELETION', 'Approved Stock Deletion');
define('APPROVED_MARGINAL_MARKDOWN', 'Approved Marginal Markdown');
define('APPROVED_UPDATE_STOCK_GENERAL_AND_COST_DETAILS', 'Approved Updated Stock General and Stock Details');
define('REJECTED_UPDATE_STOCK_GENERAL_AND_COST_DETAILS', 'Rejected Updated Stock General and Stock Details');
define('APPROVED_UPDATE_STOCK_BARCODES_AND_PRICES', 'Approved Updated Stock Barcodes and Prices');
define('REJECTED_UPDATE_STOCK_BARCODES_AND_PRICES', 'Rejected Updated Stock Barcodes and Prices');
define('REJECTED_MARGINAL_MARKDOWN', 'Rejected Marginal Markdown');
define('REJECTED_STOCK_BARCODE_PRICE', 'Rejected Stock Barcode Price');
define('REJECTED_SUPPLIER_STOCK', 'Rejected Supplier Stock');
define('REJECTED_SCHEDULE_MARKDOWN', 'Rejected Schedule Markdown');
define('REJECTED_MOVEMENT_ENTRY', 'Rejected Movement Entry');
define('REJECTED_STOCK_DELETION', 'Rejected Stock Deletion');
define('REJECTED_STOCK', 'Rejected Stock');
define('REJECTED_PURCHASE_ORDER', 'Rejected Purchase Orders');
define('REJECTED_BILLER_CODE', 'Rejected Biller Code');
define('RECEIVE_PURCHASE_ORDER', 'Received Purchase Order Delivery');

define('EDIT_STOCK', 'Edit Stock');
define('EDIT_BARCODE', 'Edit Stock Barcode');
define('EDIT_BARCODE_PRICE', 'Edit Stock Barcode Price');
define('EDIT_SUPP_STOCK', 'Edit Supplier Stock');

define('DELETE_STOCK', 'Remove Stock');
define('DELETE_BARCODE', 'Remove Stock Barcode');
define('DELETE_BARCODE_PRICE', 'Remove Stock Barcode Price');
define('DELETE_SUPP_STOCK', 'Remove Supplier Stock');
define('CANCELED_PURCHASE_ORDER', 'Canceled Purchase Orders');
define('EXTEND_DELIVERY_DATE', 'Extend Delivery Date');
define('GENERATE_NEW_PURCHASE_ORDERS', 'Generate New Purchase Orders');

define('CRITICAL_QTY', 10);

define('COMPANY_NAME','SAN ROQUE SUPERMARKET RETAIL SYSTEMS, INC.');

define('FIVES_SPACES','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');


define('BRANCH', 'TAQU');

define('SELLING_AREA', 1);
define('STOCK_ROOM', 2);
define('BO_ROOM', 3);

define('OVERSTOCK_DAYS', 30);

define('BRANCH_ID', 1); //-----NOVA BRANCH-----PERO SA MAIN DATACENTER walang bearing to

define('ADMINISTRATOR', 1);
define('DEPT_HEAD', 2);
/* End of file constants.php */
/* Location: ./application/config/constants.php */