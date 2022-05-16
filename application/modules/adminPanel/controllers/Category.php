<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends Admin_controller  {

    public function __construct()
	{
		parent::__construct();
		$this->path = $this->config->item('category');
	}

	private $table = 'category';
	protected $redirect = 'category';
	protected $title = 'Category';
	protected $name = 'category';
	
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
        $this->load->model('Category_model', 'data');
        $fetch_data = $this->data->make_datatables();
        $sr = $this->input->get('start') + 1;
        $data = [];

        foreach($fetch_data as $row)
        {
            $sub_array = [];
            $sub_array[] = $sr;
            $sub_array[] = $row->cat_name;
            $sub_array[] = img(['src' => $this->path.$row->image, 'width' => '100', 'height' => '100']);
            
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