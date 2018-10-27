<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
* 
*/
class Crud extends CI_Model
{
	
	public function insert($table, $data)
	{
		return $this->db->insert($table, $data);
	}
	public function search($table, $data)
	{
		return $this->db->get_where($table, $data);
	}
	public function search_select($table, $select, $where)
	{
		$this->db->select($select);
		$this->db->from($table);
		$this->db->where($where);
		return $this->db->get();
	}
	public function search_select_group($table, $select, $where, $group_by)
	{
		$this->db->select($select);
		$this->db->from($table);
		$this->db->where($where);
		$this->db->group_by($group_by);
		return $this->db->get();
	}
	public function search_select_order($table, $select, $where, $order_by)
	{
		$this->db->select($select);
		$this->db->from($table);
		$this->db->where($where);
		$this->db->order_by($order_by['order'], $order_by['by']);
		return $this->db->get();
	}
	public function view($table)
	{
		$data = $this->db->get($table);
		return $data->result_array();
	}
	public function view_select($table, $select)
	{
		$this->db->select($select);
		$this->db->from($table);
		return $this->db->get();
	}
	public function view_order($table, $order_by)
	{
		$this->db->select('*');
		$this->db->from($table);
		$this->db->order_by($order_by['order'], $order_by['by']);
		return $data = $this->db->get();
	}
	public function update($table, $where, $data)
	{
		$this->db->where($where);
		$this->db->update($table, $data);
	}

	public function delete($table, $data)
	{
		return $this->db->delete($table, $data);
	}
	public function like($table, $data) {
		$this->db->select('*');
		$this->db->from($table);
		$this->db->or_like($data);
		return $this->db->get();
	}
	public function like_or($table, $data, $datas) {
		$this->db->select('*');
		$this->db->from($table);
		$this->db->or_like($data);
		$this->db->where($datas);
		return $this->db->get();
	}

	public function multijoinwhere($table, $join, $where, $order_by, $select)
	{
		$this->db->select($select);
		$this->db->from($table);
		foreach ($join as $data => $value) {
			$this->db->join($data, $value, 'left');
		}
		$this->db->where($where);
		$this->db->order_by($order_by['order'], $order_by['by']);
		return $this->db->get();
	}
	public function multijoin($table, $join, $order_by, $select)
	{
		$this->db->select($select);
		$this->db->from($table);
		foreach ($join as $data => $value) {
			$this->db->join($data, $value, 'left');
		}
		$this->db->order_by($order_by['order'], $order_by['by']);
		return $this->db->get();

	}

	public function query($query)
	{
		$query = $this->db->query($query);
		return $query->result_array();
	}

	public function sql_query($query)
	{
		return $this->db->query($query);
	}
}
?>