<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Category_model extends MY_Model
{
	public $table = "category c";
	public $select_column = ['c.id', 'c.cat_name', 'c.image'];
	public $search_column = ['c.cat_name', 'c.image'];
    public $order_column = [null, 'c.cat_name', null, null];
	public $order = ['c.id' => 'DESC'];

	public function make_query()
	{  
		$this->db->select($this->select_column)
            	 ->from($this->table)
				 ->where('c.is_deleted', 0);

        $this->datatable();
	}

	public function count()
	{
		$this->db->select('c.id')
		         ->from($this->table)
				 ->where('c.is_deleted', 0);
		            	
		return $this->db->get()->num_rows();
	}
}