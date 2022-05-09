<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Employees_model extends MY_Model
{
	public $table = "employees e";
	public $select_column = ['e.id', 'e.name', 'e.mobile', 'e.email'];
	public $search_column = ['e.name', 'e.mobile', 'e.email'];
    public $order_column = [null, 'e.name', 'e.mobile', 'e.email', null];
	public $order = ['e.id' => 'DESC'];

	public function make_query()
	{  
		$this->db->select($this->select_column)
            	 ->from($this->table)
				 ->where('e.is_deleted', 0);

        $this->datatable();
	}

	public function count()
	{
		$this->db->select('e.id')
		         ->from($this->table)
				 ->where('e.is_deleted', 0);
		            	
		return $this->db->get()->num_rows();
	}
}