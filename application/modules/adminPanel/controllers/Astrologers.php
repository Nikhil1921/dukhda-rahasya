<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Astrologers extends Admin_controller  {

    public function __construct()
	{
		parent::__construct();
		$this->path = $this->config->item('category');
	}

	private $table = 'astrologers';
	protected $redirect = 'astrologers';
	protected $title = 'Astrologer';
	protected $name = 'astrologers';
	
	public function index()
	{
        $data['title'] = $this->title;
        $data['name'] = $this->name;
        $data['url'] = $this->redirect;
        $data['operation'] = "List";
        $data['datatable'] = "$this->redirect/get";
		
		return $this->template->load('template', "$this->redirect/home", $data);
	}

    public function get()
    {
        check_ajax();
        $this->load->model('Astrologer_model', 'data');
        $fetch_data = $this->data->make_datatables();
        $sr = $this->input->get('start') + 1;
        $data = [];

        foreach($fetch_data as $row)
        {
            $sub_array = [];
            $sub_array[] = $sr;
            $sub_array[] = $row->name;
            $sub_array[] = $row->place;
            $sub_array[] = $row->education;
            $sub_array[] = $row->experience;
            $sub_array[] = $row->price;
            $sub_array[] = $this->data->getAstCats($row->id);
            
            $data[] = $sub_array;  
            $sr++;
        }

        $output = [
            "draw"              => intval($this->input->get('draw')),  
            "recordsTotal"      => $this->data->count(),
            "recordsFiltered"   => $this->data->get_filtered_data(),
            "data"              => $data
        ];
        
        die(json_encode($output));
    }
}