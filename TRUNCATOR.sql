TRUNCATE `ci_sessions`;
TRUNCATE `cn_trans_items`;
TRUNCATE `debtor_trans`;
TRUNCATE `debtor_trans_details`;
TRUNCATE `delivery_details`;
-- TRUNCATE `non_stock_moves`;
DELETE FROM `non_stock_moves` WHERE `movement_type` <> 'beginning';
TRUNCATE `payment_allocations`;
TRUNCATE `purch_order_details`;
TRUNCATE `purch_orders`;
TRUNCATE `sales_deliveries`;
TRUNCATE `sales_order_details`;
TRUNCATE `sales_orders`;
TRUNCATE `sales_trans_items`;
-- TRUNCATE `stock_moves`;
DELETE FROM `stock_moves` WHERE `movement_type` <> 'beginning';
TRUNCATE `supplier_allocations`;
TRUNCATE `supplier_invoice_items`;
TRUNCATE `supplier_invoices`;
TRUNCATE `supplier_payments`;
TRUNCATE `trans_refs`;

UPDATE `trans_types` SET `next_type_no` = 1, `next_ref` = '0000001';