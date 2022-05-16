<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Astrologer_model extends MY_Model
{
	public $table = "astrologers a";
	public $select_column = ['a.id', 'a.name', 'a.place', 'a.education', 'a.experience', 'p.price'];
	public $search_column = ['a.name', 'a.place', 'a.education', 'a.experience', 'p.price'];
    public $order_column = [null, 'a.name', 'a.place', 'a.education', 'a.experience', 'p.price', null];
	public $order = ['a.id' => 'DESC'];

	public function make_query()
	{  
		$this->db->select($this->select_column)
            	 ->from($this->table)
				 ->where('a.is_deleted', 0)
				 ->join('packages p', 'p.id = a.pack_id');

        $this->datatable();
	}

	public function count()
	{
		$this->db->select('a.id')
		         ->from($this->table)
				 ->where('a.is_deleted', 0)
				 ->join('packages p', 'p.id = a.pack_id');
		            	
		return $this->db->get()->num_rows();
	}

	public function getAstCats($id)
	{
		$cats = $this->db->select('c.cat_name')
						 ->from('category c')
						 ->where('c.is_deleted', 0)
						 ->where('ac.ast_id', $id)
						 ->join('astrologers_category ac', 'ac.cat_id = c.id')
						 ->get()
						 ->result();
		            	
		if($cats)
			return implode(', ', array_map(function($cat){ return $cat->cat_name; }, $cats));
		else
			return "NA";
	}
}