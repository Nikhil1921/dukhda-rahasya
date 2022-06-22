<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Users_model extends MY_Model
{
	public $table = "users u";
	public $select_column = ['u.id', 'u.name', 'u.mobile', 'u.email'];
	public $search_column = ['u.name', 'u.mobile', 'u.email'];
    public $order_column = [null, 'u.name', 'u.mobile', 'u.email', null];
	public $order = ['u.id' => 'DESC'];

	public function make_query()
	{  
		$this->db->select($this->select_column)
            	 ->from($this->table)
				 ->where('is_deleted', 0);

        $this->datatable();
	}

	public function count()
	{
		$this->db->select('u.id')
		         ->from($this->table)
				 ->where('is_deleted', 0);
		            	
		return $this->db->get()->num_rows();
	}
}