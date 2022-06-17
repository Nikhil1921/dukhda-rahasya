<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Payments extends Admin_controller  {

    public function __construct()
	{
		parent::__construct();
		$this->path = $this->config->item('payments');
	}

	private $table = 'purchased_plans';
	protected $redirect = 'payments';
	protected $title = 'Payment';
	protected $name = 'payments';
	
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
        $this->load->model('Payments_model', 'data');
        $fetch_data = $this->data->make_datatables();
        $sr = $this->input->get('start') + 1;
        $data = [];

        foreach($fetch_data as $row)
        {
            $sub_array = [];
            $sub_array[] = $sr;
            $sub_array[] = $row->name;
            $sub_array[] = date("d-m-Y", $row->created_at);
            $sub_array[] = $row->price;
            $sub_array[] = $row->is_approved ? '<span class="badge badge-success">Approved</span>' : '<span class="badge badge-danger">Pending</span>';
            $sub_array[] = '<a href="'.base_url($this->path.$row->payment_id).'" target="_blank">'.img($this->path.$row->payment_id, '', 'height="50"').'</a>';

            $action = '<div class="btn-group" role="group"><button class="btn btn-success dropdown-toggle" id="btnGroupVerticalDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="icon-settings"></span></button><div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1" x-placement="bottom-start">';
            
            $action .= $row->is_approved ? '<a class="dropdown-item" href="javascript:;"><i class="fa fa-thumbs-up"></i> Approved</a>' : form_open($this->redirect.'/approve', 'id="'.e_id($row->id).'"', ['id' => e_id($row->id)]).
                '<a class="dropdown-item" onclick="script.delete('.e_id($row->id).'); return false;" href=""><i class="fa fa-thumbs-up"></i> Approve</a>'.
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

    public function approve()
    {
        $this->form_validation->set_rules('id', 'id', 'required|is_natural');
        
        if ($this->form_validation->run() == FALSE)
            flashMsg(0, "", "Some required fields are missing.", $this->redirect);
        else{
            $id = $this->main->update(['id' => d_id($this->input->post('id'))], ['is_approved' => 1], $this->table);
            
            flashMsg($id, "$this->title approved.", "$this->title not approved.", $this->redirect);
        }
    }
}