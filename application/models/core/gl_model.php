<?php
class Gl_model extends CI_Model{
	public function __construct(){
		parent::__construct();
	}
	public function get_chart_master($where=null)
	{
		$this->db->select('
			chart_master.*,
			chart_types.type_name account_type_name,
			tax_types.type_name tax_type_name
			');
		$this->db->from('chart_master');
		$this->db->join('chart_types','chart_master.account_type = chart_types.id');
		$this->db->join('tax_types','chart_master.tax_type_id = tax_types.tax_type_id');
		if ($where)
			$this->db->where($where);
		$query = $this->db->get();
		return $query->result();
	}
	public function write_chart_master($items)
	{
		if ($this->db->insert('chart_master',$items)) {
			return array('result'=>'success','msg'=> 'Successfully added new account');
		} else {
			if ($this->db->_error_number() == 1062)
			return array('result'=>'error','msg'=>'Account code already exists');
		}
	}
	public function change_chart_master($items,$where=null)
	{
		if ($where)
			$this->db->where($where);
		$this->db->update('chart_master',$items);
	}
	public function get_chart_types($where=null)
	{
		$this->db->select('chart_types.id,
			chart_types.type_name,
			chart_types.class_id,
			chart_classes.class_name,
			chart_types.parent,
			parent.type_name as parent_name
			');
		$this->db->from('chart_types');
		$this->db->join('chart_classes','chart_types.class_id = chart_classes.id');
		$this->db->join('chart_types as parent',' chart_types.parent = parent.id','left');
		if ($where)
			$this->db->where($where);
		$this->db->order_by('chart_types.id ASC');
		$query = $this->db->get();
		return $query->result();
	}
	public function write_chart_types($items)
	{
		$this->db->insert('chart_types',$items);
		$id = $this->db->insert_id();
		return $id;
	}
	public function change_chart_types($items,$where=null)
	{
		if ($where)
			$this->db->where($where);
		$this->db->update('chart_types',$items);
	}
	public function get_chart_classes($where=null)
	{
		$this->db->select('*');
		$this->db->from('chart_classes');
		if ($where)
			$this->db->where($where);
		$query = $this->db->get();
		return $query->result();
	}
	public function write_chart_classes($items)
	{
		$this->db->insert('chart_classes',$items);
		$id = $this->db->insert_id();
		return $id;
	}
	public function change_chart_classes($items,$where=null)
	{
		if ($where)
			$this->db->where($where);
		$this->db->update('chart_classes',$items);
	}
}