<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Payments_model extends MY_Model
{
	public $table = "purchased_plans pp";
	public $select_column = ['pp.id', 'u.name', 'pp.created_at', 'pp.price', 'pp.is_approved', 'pp.payment_id'];
	public $search_column = ['u.name', 'pp.created_at', 'pp.price', 'pp.is_approved'];
    public $order_column = [null, 'u.name', 'pp.created_at', 'pp.price', 'pp.is_approved', null, null];
	public $order = ['pp.id' => 'DESC'];

	public function make_query()
	{  
		$this->db->select($this->select_column)
            	 ->from($this->table)
				 ->where('u.is_deleted', 0)
				 ->join('users u', 'u.id = pp.u_id');

        $this->datatable();
	}

	public function count()
	{
		$this->db->select('pp.id')
		         ->from($this->table)
				 ->where('u.is_deleted', 0)
				 ->join('users u', 'u.id = pp.u_id');
		            	
		return $this->db->get()->num_rows();
	}
}