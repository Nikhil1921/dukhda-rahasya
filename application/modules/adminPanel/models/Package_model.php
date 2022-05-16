<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Package_model extends MY_Model
{
	public $table = "packages p";
	public $select_column = ['p.id', 'p.p_name', 'p.price', 'p.validity'];
	public $search_column = ['p.p_name', 'p.price', 'p.validity'];
    public $order_column = [null, 'p.p_name', 'p.price', 'p.validity', null];
	public $order = ['p.id' => 'DESC'];

	public function make_query()
	{  
		$this->db->select($this->select_column)
            	 ->from($this->table)
				 ->where('p.is_deleted', 0);

        $this->datatable();
	}

	public function count()
	{
		$this->db->select('p.id')
		         ->from($this->table)
				 ->where('p.is_deleted', 0);
		            	
		return $this->db->get()->num_rows();
	}
}