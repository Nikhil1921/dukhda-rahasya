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

	public function plan_purchased($id)
	{
		$this->db->select('id')
		         ->from('purchased_plans')
				 ->where('UNIX_TIMESTAMP(DATE_ADD(FROM_UNIXTIME(created_at), INTERVAL validity DAY)) >= ', time())
				 ->where('u_id', $id);
		            	
		return $this->db->get()->row();
	}
}