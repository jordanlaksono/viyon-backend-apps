<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_department extends CI_Model {

	var $table = 't_departement';
	var $column_order = array('f_deptid','f_deptname','f_status',null); //set column field database for datatable orderable
	var $column_search = array('f_deptid','f_deptname','f_status'); //set column field database for datatable searchable just title , author , category are searchable
    var $order = array('f_deptid' => 'asc'); // default order

    private function _get_datatables_query() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
		$request = json_decode(file_get_contents('php://input'), true);
		
		$this->db->from($this->table);
		
		$i = 0;
		foreach ($this->column_search as $item) {
			if (@$request['search']["value"]) {
				if ($i===0) {
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $request['search']["value"]);
				} else {
					$this->db->or_like($item, $request['search']["value"]);
			}
			
			if (count($this->column_search) - 1 == $i)
				$this->db->group_end();
			}

			$i++;
		}

		if (isset($request['order'])) {
			$this->db->order_by($this->column_order[$request['order']['0']['column']], $request['order']['0']['dir']);
		} else if (isset($this->order)) {
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function count_filtered() {
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	function count_all() {
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

	public function get_datatables() {
		$this->_get_datatables_query();
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
        $request = json_decode(file_get_contents('php://input'), true);
		if (@$request['length'] != -1) {
			$this->db->limit(@$request['length'], @$request['start']);
		}

		$query = $this->db->get();
		return $query->result();
    }

    function where_max(){
		return $this->db->query('SELECT f_deptid AS maxs FROM t_departement order by f_deptid desc limit 1 ');
    }
	
	public function updateDepartment($id, $blogData)
	{
		$this->db->where('f_deptid', $id);
		$this->db->update('t_departement', $blogData);
	}

	public function get_by_id2($id)
	{
	  $this->db->from('t_departement');
	  $this->db->where('f_deptid', $id);
	  $query = $this->db->get();
	  return $query->row();
	}

	public function deleteDepartment($id)
	{
		$this->db->where('f_deptid', $id);
		$this->db->delete('t_departement');
	}
    
}    