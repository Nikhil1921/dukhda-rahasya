<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class MY_Model extends CI_Model
{
    public function add($post, $table)
	{
		if ($this->db->insert($table, $post)) {
			$id = $this->db->insert_id();
			return ($id) ? $id : true;
		}else
			return false;
	}

	public function get($table, $select, $where)
	{
		$result = $this->db->select($select)
						->from($table)
						->where($where)
						->get()
						->row_array();

		return ($result !== false) ? $result : false;
	}

	public function getAll($table, $select, $where, $order_by = '', $limit = '')
	{
		$this->db->select($select)
					->from($table)
					->where($where);

		if ($order_by != '') 
			$this->db->order_by($order_by);
		
		if ($limit != '') 
			$this->db->limit($limit);
		
		return  $this->db->get()
						->result_array();
	}

	public function check($table, $where, $select)
	{
		$check = $this->db->select($select)
						->from($table)
						->where($where)
						->get()
						->row_array();
		if ($check) 
			return $check[$select];
		else
			return false;
	}

	public function update($where, $post, $table)
	{
		return $this->db->where($where)->update($table, $post);
	}

	public function delete($table, $where)
	{
		return $this->db->delete($table, $where);
	}

	public function make_datatables()
	{  
	   $this->make_query();  
	   if($_GET["length"] != -1)  
	   {  
	        $this->db->limit($_GET['length'], $_GET['start']);
	   }  
	   $query = $this->db->get();
	   return $query->result();
	}  

	public function get_filtered_data(){  
	   $this->make_query();  
	   $query = $this->db->get();  

	   return $query->num_rows();
	}

	public function datatable()
	{
		$i = 0;

        foreach ($this->search_column as $item) 
        {
            if($_GET['search']['value']) 
            {
                if($i===0) 
                {
                    $this->db->group_start(); 
                    $this->db->like($item, $_GET['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_GET['search']['value']);
                }
 
                if(count($this->search_column) - 1 == $i) 
                    $this->db->group_end(); 
            }
            $i++;
        }
         
        if(isset($_GET['order'])) 
        {
            $this->db->order_by($this->order_column[$_GET['order']['0']['column']], $_GET['order']['0']['dir']);
        }
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
	}

	public function counter($table, $where)
	{
		return $this->db->get_where($table, $where)->num_rows();
	}
}