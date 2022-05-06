<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Banners extends Admin_controller  {

    public function __construct()
	{
		parent::__construct();
		$this->path = $this->config->item('banners');
	}

	private $table = 'banners';
	protected $redirect = 'banners';
	protected $title = 'Banner';
	protected $name = 'banner';
	
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
        $this->load->model('Banner_model', 'data');
        $fetch_data = $this->data->make_datatables();
        $sr = $this->input->get('start') + 1;
        $data = [];

        foreach($fetch_data as $row)
        {
            $sub_array = [];
            $sub_array[] = $sr;
            $sub_array[] = img(['src' => $this->path.$row->banner, 'width' => '100%', 'height' => '50']);
            
            $action = '<div class="btn-group" role="group"><button class="btn btn-success dropdown-toggle" id="btnGroupVerticalDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="icon-settings"></span></button><div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1" x-placement="bottom-start">';
            
            $action .= form_open($this->redirect.'/delete', 'id="'.e_id($row->id).'"', ['id' => e_id($row->id), 'banner' => $row->banner]).
                '<a class="dropdown-item" onclick="script.delete('.e_id($row->id).'); return false;" href=""><i class="fa fa-trash"></i> Delete</a>'.
                form_close();

            $action .= '</div></div>';
            $sub_array[] = $action;

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

    public function upload()
	{
        $image = $this->uploadImage('image');
        
        if ($image['error'] == TRUE)
            flashMsg(0, "", $image["message"], $this->redirect);
        else{
            $id = $this->main->add(['banner' => $image['message']], $this->table);
            flashMsg($id, "$this->title added.", "$this->title not added. Try again.", $this->redirect);
        }
	}

	public function delete()
    {
        $this->form_validation->set_rules('id', 'id', 'required|is_natural');
        $this->form_validation->set_rules('banner', 'banner', 'required');
        
        if ($this->form_validation->run() == FALSE)
            flashMsg(0, "", "Some required fields are missing.", $this->redirect);
        else{
            $id = $this->main->delete($this->table, ['id' => d_id($this->input->post('id'))]);
            
            if($id && is_file($this->path.$this->input->post('banner'))) 
                unlink($this->path.$this->input->post('banner'));
            
            flashMsg($id, "$this->title deleted.", "$this->title not deleted.", $this->redirect);
        }
    }
}