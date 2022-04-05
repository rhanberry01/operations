<?php
class Receiving_model extends CI_Model{
	public function __construct(){
		parent::__construct();
	}
	public function get_purch_order_info($po_reference=null){
		$sql = "SELECT * FROM purch_orders WHERE reference = '$po_reference'";
		$query = $this->db->query($sql);
		$row = $query->row();
		// echo $sql."<br>";
		if (!empty($row))
			return $row;
		else
			return false;
	}
	public function get_supplier_name($supplier_id=null){
		$sql = "SELECT supp_name FROM supplier_master WHERE supplier_id = '$supplier_id' ";
		// echo $sql."<br>";
		$query = $this->db->query($sql);
		$row = $query->row();
		if ($row != null)
			return $row->supp_name;
		else
			return false;
	}
	public function get_barcode_stock_id($barcode=null){
		$sql = "SELECT stock_id FROM stock_barcodes_new WHERE barcode = '$barcode' ";
		// echo $sql."<br>";
		$query = $this->db->query($sql);
		$row = $query->row();
		if ($row != null)
			return $row->stock_id;
		else
			return false;
	}
	public function get_barcode_uom($barcode=null){
		$sql = "SELECT uom FROM stock_barcodes_new WHERE barcode = '$barcode' ";
		// echo $sql."<br>";
		$query = $this->db->query($sql);
		$row = $query->row();
		if ($row != null)
			return $row->uom;
		else
			return false;
	}
	public function get_barcode_description($barcode=null){
		$sql = "SELECT description FROM stock_barcodes_new WHERE barcode = '$barcode' ";
		// echo $sql."<br>";
		$query = $this->db->query($sql);
		$row = $query->row();
		if ($row != null)
			return $row->description;
		else
			return false;
	}
	public function get_uom_qty($uom=null){
		$sql = "SELECT qty FROM stock_uoms WHERE unit_code = '$uom' ";
		// echo $sql."<br>";
		$query = $this->db->query($sql);
		$row = $query->row();
		if ($row != null)
			return $row->qty;
		else
			return false;
	}
	public function validate_receiving_item_from_po($po_order_no=null, $po_reference=null, $barcode=null, $uom=null){
		$status = "";
		$sql = "SELECT * FROM `stock_barcodes_new` WHERE barcode = '$barcode' and uom='$uom'";
		// echo $sql."<br>";
		$query = $this->db->query($sql);
		$row = $query->row();
		if ($row != null){
			$sql2 = "SELECT * FROM purch_order_details WHERE order_no = $po_order_no AND stock_id = ".$row->stock_id." AND uom = '".$row->uom."' ";
			// echo $sql2."<br>";
			$query2 = $this->db->query($sql2);
			$row2 = $query2->row();
			if($row2 != null){
				// echo "INCLUDED IN PURCHASE ORDER ITEMS";
				// $status = $row2;
				// echo $status;
				return $row2;
			}else{
				// echo "NOT IN PURCHASE ORDER ITEMS";
				// $status = "error";
				return false;
			}
		}else{
			return false;
			// echo "NONE";
			// $status = "error";
		}
		// return $status;
	}
	public function write_to_receiving_headers_temp($items){
		$this->db->insert('receiving_headers_temp',$items);
		$id = $this->db->insert_id();
		return $id;
	}
	public function update_receiving_headers_temp($items, $receiving_id=null, $purch_order_no=null, $po_reference=null){
		$this->db->where('id', $receiving_id);
		$this->db->where('purch_order_no', $purch_order_no);
		$this->db->where('po_reference', $po_reference);
		$this->db->update('receiving_headers_temp', $items);

		return $this->db->last_query();
	}
	public function write_to_receiving_details_temp($items)
	{
		$this->db->insert('receiving_details_temp',$items);
		$id = $this->db->insert_id();
		return $id;
	}
	public function validate_temp_receiving_header_if_existing($po_order_no=null, $po_reference=null){
		$sql = "SELECT * FROM `receiving_headers_temp` WHERE purch_order_no = $po_order_no AND po_reference='$po_reference' AND posted=0";
		$query = $this->db->query($sql);
		$row = $query->row();
		if ($row != null){
			return true;
		}else{
			return false;
		}
	}
	public function get_temp_receiving_header($po_order_no=null, $po_reference=null){
		$sql = "SELECT * FROM `receiving_headers_temp` WHERE purch_order_no = $po_order_no AND po_reference='$po_reference' AND posted=0";
		$query = $this->db->query($sql);
		$row = $query->row();
		if ($row != null){
			// $res = $row[0];
			return $row;
		}else{
			return false;
		}
	}
	public function get_temp_receiving_header_list($receiving_id=null){
		$sql = "SELECT * FROM `receiving_headers_temp`";
		$sql .= " WHERE posted=0";
		if($receiving_id != '')
			$sql .= " AND id=$receiving_id";
		$query = $this->db->query($sql);
		// echo $sql."<br>";
		$result = $query->result();
		return $result;
	}
	public function get_purch_order_header_for_reference($po_order_no=null, $po_reference=null){
		$sql = "SELECT * FROM `purch_orders` WHERE order_no = $po_order_no AND reference='$po_reference'";
		$query = $this->db->query($sql);
		$row = $query->row();
		if ($row != null){
			// $res = $row[0];
			return $row;
		}else{
			return false;
		}
	}
	public function get_temp_receiving_header_for_posting($temp_receiving_id=null, $po_order_no=null, $po_reference=null){
		$sql = "SELECT * FROM `receiving_headers_temp` WHERE id=$temp_receiving_id AND purch_order_no = $po_order_no AND po_reference='$po_reference' AND posted=0";
		$query = $this->db->query($sql);
		$row = $query->row();
		if ($row != null){
			// $res = $row[0];
			return $row;
		}else{
			return false;
		}
	}
	public function get_temp_receiving_details_for_posting($temp_receiving_id=null, $po_order_no=null, $po_reference=null){
		$sql = "SELECT * 
					FROM receiving_headers_temp main
					JOIN receiving_details_temp sub
					ON main.id = sub.temp_receiving_id
					WHERE sub.temp_receiving_id = $temp_receiving_id
					AND main.purch_order_no = $po_order_no
					AND main.po_reference='$po_reference'
					ORDER BY last_scanned DESC
					";
		$query = $this->db->query($sql);
		// echo $sql."<br>";
		$result = $query->result();
		return $result;
	}
	public function get_receiving_details_temp($po_order_no=null, $po_reference=null){
		$sql = "SELECT * 
					FROM receiving_headers_temp main
					JOIN receiving_details_temp sub
					ON main.id = sub.temp_receiving_id
					WHERE main.purch_order_no = $po_order_no
					AND main.po_reference='$po_reference'
					ORDER BY last_scanned DESC
					";
		$query = $this->db->query($sql);
		// echo $sql."<br>";
		$result = $query->result();
		return $result;
	}
	public function delete_receiving_details_temp_line_item($id=null){
		$this->db->where('line_id', $id);
		$this->db->delete('receiving_details_temp');
	}
	public function validate_receiving_details_temp_if_item_exists($receiving_id=null, $stock_id=null, $barcode=null, $uom=null){
		$sql = "SELECT * FROM `receiving_details_temp` WHERE temp_receiving_id = $receiving_id AND stock_id=$stock_id AND barcode='$barcode' AND uom='$uom'";
		$query = $this->db->query($sql);
		$row = $query->row();
		if ($row != null){
			return true;
		}else{
			return false;
		}
	}
	public function get_purch_order_details_line_item_qty_ordered($order_no=null, $stock_id=null, $uom=null){
		$sql = "SELECT * FROM `purch_order_details` WHERE order_no = $order_no AND stock_id=$stock_id AND uom='$uom'";
		$query = $this->db->query($sql);
		$row = $query->row();
		if ($row != null){
			return $row->qty_ordered;
		}else{
			return false;
		}
	}
	public function reset_last_scanned_item($receiving_id=null, $stock_id=null, $barcode=null, $uom=null){
		$item=array();
		$item = array("last_scanned"=>0);
		$this->db->where('temp_receiving_id',$receiving_id);
		// $this->db->where('stock_id',$stock_id);
		// $this->db->where('barcode',$barcode);
		// $this->db->where('uom',$uom);
		$this->db->where('last_scanned',1);
		$this->db->update('receiving_details_temp',$item);
		// echo $this->db->last_query();
	}
	public function add_to_existing_receiving_detail_temp_item($order_no=null, $receiving_id=null, $stock_id=null, $barcode=null, $uom=null, $add_qty=0){
		$po_qty_ordered = $this->get_purch_order_details_line_item_qty_ordered($order_no, $stock_id, $uom);
		// echo $add_qty."<===>".$po_qty_ordered."<br>";

			$sql = "SELECT * FROM `receiving_details_temp` WHERE temp_receiving_id = $receiving_id AND stock_id=$stock_id AND barcode='$barcode' AND uom='$uom'";
			$query = $this->db->query($sql);
			$row = $query->row();
				
				if(($row->qty_received+$add_qty) < $po_qty_ordered){
					
					$this->reset_last_scanned_item($receiving_id, $stock_id, $barcode, $uom);
					
					$items=array(
						"qty_received"=>($add_qty == '' ? ($row->qty_received+1) : ($row->qty_received+$add_qty)),
						"last_scanned"=>1
					);
					
					$this->db->where('temp_receiving_id',$receiving_id);
					$this->db->where('stock_id',$stock_id);
					$this->db->where('barcode',$barcode);
					$this->db->where('uom',$uom);
					$this->db->update('receiving_details_temp',$items);
					return true;
				}else if(($row->qty_received+$add_qty) > $po_qty_ordered){
					return false;
				}

	}
	public function write_to_receiving_headers($items){
		$this->db->insert('receiving_headers',$items);
		$id = $this->db->insert_id();
		return $id;
	}
	public function write_to_receiving_details($items)
	{
		$this->db->insert('receiving_details',$items);
		$id = $this->db->insert_id();
		return $id;
	}
	public function get_branch_stock_cost_of_sales_row($stock_id=null, $branch_id=null){
		$sql = "SELECT * FROM `stock_cost_of_sales` WHERE stock_id = $stock_id AND branch_id=$branch_id";
		$query = $this->db->query($sql);
		$row = $query->row();
		if ($row != null){
			// $res = $row[0];
			return $row;
		}else{
			return false;
		}
	}
	public function get_branch_stock_qty_row($stock_id=null, $branch_id=null){
		$sql = "SELECT SUM(qty) as qty FROM `branch_stocks` WHERE stock_id = $stock_id AND branch_id=$branch_id";
		$query = $this->db->query($sql);
		$row = $query->row();
		if ($row != null){
			// $res = $row[0];
			return $row;
		}else{
			return false;
		}
	}
	public function get_branch_stock_qty_row_per_stock_loc($stock_id=null, $branch_id=null, $stock_loc_id=null){
		$sql = "SELECT * FROM `branch_stocks` WHERE stock_id = $stock_id AND branch_id=$branch_id AND stock_loc_id=$stock_loc_id";
		$query = $this->db->query($sql);
		$row = $query->row();
		if ($row != null){
			// $res = $row[0];
			return $row;
		}else{
			return false;
		}
	}
	public function update_branch_stock_cost_of_sales($stock_id=null, $branch_id=null, $items=array()){
		$this->db->where('stock_id', $stock_id);
		$this->db->where('branch_id', $branch_id);
		$this->db->update('stock_cost_of_sales', $items);

		return $this->db->last_query();
	}
	// // public function update_branch_stock_qty($stock_id=null, $branch_id=null, $stock_loc_id=null, $items=array()){
		// // $this->db->where('stock_id', $stock_id);
		// // $this->db->where('branch_id', $branch_id);
		// // $this->db->where('stock_loc_id', $stock_loc_id);
		// // $this->db->update('branch_stocks', $items);

		// // return $this->db->last_query();
	// // }
	public function update_branch_stock_qty($stock_id=null, $branch_id=null, $stock_loc_id=null, $new_qty = 0){
		$sql = "UPDATE branch_stocks 
					SET qty = (qty+".$new_qty.")
					WHERE stock_id = $stock_id
					AND branch_id = $branch_id
					AND stock_loc_id = $stock_loc_id
					";
		$this->db->query($sql);
	}
	public function write_to_stock_moves_branch($items)
	{
		$this->db->insert('stock_moves_branch',$items);
		$id = $this->db->insert_id();
		return $id;
	}
	public function get_barcode_from_stock_id_and_uom($stock_id=null, $uom=null){
		$sql = "SELECT barcode FROM stock_barcodes_new WHERE stock_id = $stock_id AND uom = '$uom' ";
		// echo $sql."<br>";
		$query = $this->db->query($sql);
		$row = $query->row();
		if ($row != null)
			return $row->barcode;
		else
			return false;
	}
	public function get_from_purch_order_details_line_item($po_order_no=null, $stock_id=null){
		$sql = "SELECT * FROM `purch_order_details` WHERE order_no = $po_order_no AND stock_id=$stock_id";
		$query = $this->db->query($sql);
		$row = $query->row();
		if ($row != null){
			// $res = $row[0];
			return $row;
		}else{
			return false;
		}
	}
	//-----AUDIT TRAIL-----APM-----START
	public function write_to_audit_trail($items=array())
	{
		$this->db->insert('audit_trail',$items);
		$id = $this->db->insert_id();
		return $id;
	}
	//-----AUDIT TRAIL-----APM-----END
	public function get_posted_receiving_header_list($receiving_id=null){
		$sql = "SELECT * FROM `receiving_headers`";
		$sql .= " WHERE status=1";
		if($receiving_id != '')
			$sql .= " AND id=$receiving_id";
		$query = $this->db->query($sql);
		// echo $sql."<br>";
		$result = $query->result();
		return $result;
	}

	public function get_posted_header_details_posted($receiving_id=null, $branch_id=null){
		$sql = "SELECT * FROM `receiving_headers`";
		// $sql .= " WHERE posted=0";
		if($receiving_id != '')
			$sql .= " WHERE id=$receiving_id AND branch_id=$branch_id";
		$query = $this->db->query($sql);
		// echo $sql."<br>";
		$result = $query->result();
		return $result;
	}
	public function get_receiving_details($po_order_no=null, $po_reference=null){
		$sql = "SELECT * 
					FROM receiving_headers main
					JOIN receiving_details sub
					ON main.id = sub.receiving_id AND main.branch_id = sub.branch_id
					WHERE main.purch_order_no = $po_order_no
					AND main.reference='$po_reference'";
		$query = $this->db->query($sql);
		// echo $sql."<br>";
		$result = $query->result();
		return $result;
	}
	public function get_user_name($id=null){
		$sql = "SELECT fname,mname,lname,suffix FROM users WHERE id=".$id;
		$query = mysql_query($sql);
		$result = mysql_fetch_object($query); 
		return $result->fname.' '.$result->mname.' '.$result->lname.' '.$result->suffix;
	}
}