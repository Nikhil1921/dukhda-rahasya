<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Users_model extends MY_Model
{
	public $table = "users u";
	public $select_column = ['u.id', 'u.name', 'u.mobile', 'u.email', 'UNIX_TIMESTAMP(DATE_ADD(FROM_UNIXTIME(pp.created_at), INTERVAL pp.validity DAY)) AS expiry'];
	public $search_column = ['u.name', 'u.mobile', 'u.email'];
    public $order_column = [null, 'u.name', 'u.mobile', 'u.email', null];
	public $order = ['u.id' => 'DESC'];

	public function make_query()
	{  
		$this->db->select($this->select_column)
            	 ->from($this->table)
				 ->where('u.is_deleted', 0)
				 ->join('purchased_plans pp', 'pp.u_id = u.id')
				 ->where('pp.is_approved', 1)
				 ->where('pp.pack_id', $this->user->pack_id)
				 ->having('expiry > ', time());

        $this->datatable();
	}

	public function count()
	{
		$this->db->select('u.id, UNIX_TIMESTAMP(DATE_ADD(FROM_UNIXTIME(pp.created_at), INTERVAL pp.validity DAY)) AS expiry')
		         ->from($this->table)
				 ->where('u.is_deleted', 0)
				 ->join('purchased_plans pp', 'pp.u_id = u.id')
				 ->where('pp.is_approved', 1)
				 ->where('pp.pack_id', $this->user->pack_id)
				 ->having('expiry > ', time());
		            	
		return $this->db->get()->num_rows();
	}
}