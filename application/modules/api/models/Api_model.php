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
        $this->users = $this->config->item('users');
	}

    protected $table = 'users';

    public function getProfile($where)
    {
        return $this->db->select('id, name, mobile, email, CONCAT("'.base_url($this->users).'", image) image')
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
        return $this->db->select('id, cat_name, CONCAT("'.base_url($this->category).'", image, "?v=1.0.1") image')
                        ->from('category')
                        ->where('is_deleted', 0)
                        ->get()
                        ->result_array();
    }

    public function getPackagesList()
    {
        return $this->db->select('id, p_name, price, validity, daily_validity')
                        ->from('packages')
                        ->where('is_deleted', 0)
                        ->get()
                        ->result_array();
    }

    public function getAstrologers($get=[])
    {
        $this->db->select('a.id, a.name, a.pack_id, a.place, a.experience, a.education, p.p_name, p.price, p.validity, CONCAT("'.base_url($this->astrologers).'", image) image, p.daily_validity')
                 ->where('a.is_deleted', 0)
                 ->join('astrologers a', 'ac.ast_id = a.id')
                 ->join('packages p', 'a.pack_id = p.id');

        if(isset($get['c_id']) > 0) $asts = $this->db->where('ac.cat_id', $get['c_id']);
        
        if(isset($get['pack_id']) > 0) $asts = $this->db->where('p.id', $get['pack_id']);

        $asts = $this->db->group_by('ac.ast_id')
                         ->get('astrologers_category ac')
                         ->result_array();

        $asts = array_map(function($ast) {
            $ast['cats'] = $this->db->select('c.cat_name, c.id')
                                    ->where('c.is_deleted', 0)
                                    ->where('ac.ast_id', $ast['id'])
                                    ->join('category c', 'ac.cat_id = c.id')
                                    ->get('astrologers_category ac')
                                    ->result();
            return $ast;
        }, $asts);
        
        return $asts;
    }

    public function purchased_plans()
    {
        return array_map(function($plan){
            $plan['purchase_date'] = date("d-m-Y", $plan['purchase_date']);
            $plan['expired'] = date("d-m-Y", strtotime('- '.$plan['validity'].' Days')) <= $plan['purchase_date'] ? false : true;
            
            return $plan;
        }, $this->db->select('pp.created_at AS purchase_date, pp.price, pp.validity, pp.daily_validity, pp.payment_id, pp.is_approved')
                    ->from('purchased_plans pp')
                    ->where(['u_id' => $this->api])
                    ->join('packages p', 'pp.pack_id = p.id')
                    ->order_by("pp.id DESC")
                    ->get()
                    ->result_array());
    }

    public function chat_timer($api)
    {
        return $this->db->select('t_time')
                        ->from('chat_timer')
                        ->where(['u_id' => $api, 't_date' => date('Y-m-d')])
                        ->get()
                        ->row_array();
    }
}