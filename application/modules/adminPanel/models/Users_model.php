<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Users_model extends MY_Model
{
	public $table = "users u";
	public $select_column = ['u.id', 'u.name', 'u.mobile', 'u.email', 'u.create_at'];
	public $search_column = ['u.name', 'u.mobile', 'u.email', 'u.create_at'];
    public $order_column = [null, 'u.name', 'u.mobile', 'u.email', 'u.create_at', null];
	public $order = ['u.id' => 'DESC'];

	public function make_query()
	{  
		$this->db->select($this->select_column)
            	 ->from($this->table);

        $this->datatable();
	}

	public function count()
	{
		$this->db->select('u.id')
		         ->from($this->table);
		            	
		return $this->db->get()->num_rows();
	}
}