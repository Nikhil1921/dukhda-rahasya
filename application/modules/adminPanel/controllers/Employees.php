<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Employees extends Admin_controller  {

    public function __construct()
	{
		parent::__construct();
		$this->path = $this->config->item('users');
	}

	protected $table = 'employees';
	protected $redirect = 'employees';
	protected $title = 'Employee';
	protected $name = 'employees';
	
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
        $this->load->model('Employees_model', 'data');
        $fetch_data = $this->data->make_datatables();
        $sr = $this->input->get('start') + 1;
        $data = [];

        foreach($fetch_data as $row)
        {
            $sub_array = [];
            $sub_array[] = $sr;
            $sub_array[] = $row->name;
            $sub_array[] = $row->mobile;
            $sub_array[] = $row->email;

            $action = '<div class="btn-group" role="group"><button class="btn btn-success dropdown-toggle" id="btnGroupVerticalDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="icon-settings"></span></button><div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1" x-placement="bottom-start">';
            
            $action .= anchor($this->redirect."/add-update/".e_id($row->id), '<i class="fa fa-edit"></i> Edit</a>', 'class="dropdown-item"');

            /* $action .= form_open($this->redirect.'/delete', 'id="'.e_id($row->id).'"', ['id' => e_id($row->id)]).
                '<a class="dropdown-item" onclick="script.delete('.e_id($row->id).'); return false;" href=""><i class="fa fa-trash"></i> Delete</a>'.
                form_close(); */

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

    public function add_update($id=0)
	{
        $this->form_validation->set_rules($this->validate);

        if ($this->form_validation->run() == FALSE)
        {
            $data['title'] = $this->title;
            $data['name'] = $this->name;
            $data['operation'] = $id === 0 ? "Add" : "Update";
            $data['url'] = $this->redirect;
            $data['packages'] = $this->main->getAll('packages', 'id, price', ['is_deleted' => 0]);

            if($id !== 0) $data['data'] = $this->main->get($this->table, 'name, mobile, email, pack_id, password', ['id' => d_id($id)]);
            
            return $this->template->load('template', "$this->redirect/form", $data);
        }else{
            $post = [
                'name' => $this->input->post('name'),
                'mobile' => $this->input->post('mobile'),
                'email' => $this->input->post('email'),
                'pack_id'  => d_id($this->input->post('pack_id'))
            ];

            if ($this->input->post('password'))
                $post['password'] = my_crypt($this->input->post('password'));

            if ($id === 0)
                $post['create_at'] = time();
                
            $uid = ($id === 0) ? $this->main->add($post, $this->table) : $this->main->update(['id' => d_id($id)], $post, $this->table);
            $msg = ($id === 0) ? 'added' : 'updated';

            flashMsg($uid, "$this->title $msg.", "$this->title not $msg. Try again.", $this->redirect);
        }
	}

    public function mobile_check($str)
    {
        $id = $this->uri->segment(4) ? $this->uri->segment(4) : 0;
        
        $where = ['mobile' => $str, 'id != ' => d_id($id)];
        
        if ($this->main->check($this->table, $where, 'id'))
        {
            $this->form_validation->set_message('mobile_check', 'The %s is already in use');
            return FALSE;
        } else
            return TRUE;
    }

    public function email_check($str)
    {   
        $id = $this->uri->segment(4) ? $this->uri->segment(4) : 0;
        
        $where = ['email' => $str, 'id != ' => d_id($id)];
        
        if ($this->main->check($this->table, $where, 'id'))
        {
            $this->form_validation->set_message('email_check', 'The %s is already in use');
            return FALSE;
        } else
            return TRUE;
    }

    public function password_check($str)
    {   
        if (!$this->uri->segment(4) && !$str)
        {
            $this->form_validation->set_message('password_check', '%s is required');
            return FALSE;
        } else
            return TRUE;
    }

    protected $validate = [
        [
            'field' => 'name',
            'label' => 'Name',
            'rules' => 'required|max_length[50]|alpha_numeric_spaces|trim',
            'errors' => [
                'required' => "%s is required",
                'max_length' => "Max 50 chars allowed.",
                'alpha_numeric_spaces' => "Only characters and numbers are allowed.",
            ],
        ],
        [
            'field' => 'mobile',
            'label' => 'Mobile no.',
            'rules' => 'required|exact_length[10]|is_numeric|callback_mobile_check|trim',
            'errors' => [
                'required' => "%s is required",
                'exact_length' => "%s is invalid",
                'is_numeric' => "%s is invalid",
            ],
        ],
        [
            'field' => 'pack_id',
            'label' => 'Package',
            'rules' => 'required|is_numeric|trim',
            'errors' => [
                'required' => "%s is required",
                'is_numeric' => "%s is invalid",
            ],
        ],
        [
            'field' => 'email',
            'label' => 'Email',
            'rules' => 'required|max_length[100]|valid_email|callback_email_check|trim',
            'errors' => [
                'required' => "%s is required",
                'max_length' => "Max 100 chars allowed.",
                'valid_email' => "%s is invalid",
            ],
        ],
        [
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'max_length[100]|callback_password_check|trim',
            'errors' => [
                'max_length' => "Max 100 chars allowed.",
            ],
        ],
    ];
}