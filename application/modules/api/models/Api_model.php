<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Api_model extends MY_Model
{
    public function __construct()
	{
		parent::__construct();
		$this->banners = $this->config->item('banners');
		$this->category = $this->config->item('category');
		$this->astrologers = $this->config->item('astrologers');
	}

    protected $table = 'users';

    public function getProfile($where)
    {
        return $this->db->select('id, name, mobile, email')
                        ->from($this->table)
                        ->where($where)
                        ->where(['is_deleted' => 0])
                        ->get()
                        ->row_array();
    }

    public function getBanners()
    {
        return $this->db->select('CONCAT("'.base_url($this->banners).'", banner) banner')
                        ->from('banners')
                        ->get()
                        ->result_array();
    }

    public function getCategoryList()
    {
        return $this->db->select('id, cat_name, CONCAT("'.base_url($this->category).'", image) image')
                        ->from('category')
                        ->where('is_deleted', 0)
                        ->get()
                        ->result_array();
    }

    public function getPackagesList()
    {
        return $this->db->select('id, p_name, price, validity')
                        ->from('packages')
                        ->where('is_deleted', 0)
                        ->get()
                        ->result_array();
    }

    public function getAstrologers($c_id=0)
    {
        $this->db->select('a.id, a.name, a.pack_id, a.place, a.experience, a.education, p.p_name, p.price, p.validity, CONCAT("'.base_url($this->astrologers).'", image) image')
                 ->where('a.is_deleted', 0)
                 ->join('astrologers a', 'ac.ast_id = a.id')
                 ->join('packages p', 'a.pack_id = p.id');

        if($c_id > 0) $asts = $this->db->where('ac.is_deleted', $c_id);

        $asts = $this->db->group_by('ac.ast_id')
                         ->get('astrologers_category ac')
                         ->result_array();

        $asts = array_map(function($ast){
            $ast['cats'] = $this->db->select('c.cat_name, c.id')
                                    ->where('c.is_deleted', 0)
                                    ->where('ac.ast_id', $ast['id'])
                                    ->join('category c', 'ac.cat_id = c.id')
                                    ->get('astrologers_category ac')
                                    ->result();
            return $ast;
        }, $asts);
        /* $asts = $this->db->select('a.id, a.name, a.pack_id, a.place, a.experience, a.education, p.p_name, p.price, p.validity')
                        ->from('astrologers a')
                        ->where('a.is_deleted', 0)
                        ->join('packages p', 'a.pack_id = p.id')
                        ->get()
                        ->result_array();

        $asts = array_map(function($ast){
            $ast['cats'] = $this->db->select('c.cat_name')
                                    ->where('c.is_deleted', 0)
                                    ->where('ac.ast_id', $ast['id'])
                                    ->join('category c', 'ac.cat_id = c.id')
                                    ->get('astrologers_category ac')
                                    ->result();
            return $ast;
        }, $asts);
         */
        return $asts;
    }
}