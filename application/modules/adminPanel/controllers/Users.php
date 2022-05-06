<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends Admin_controller  {

    public function __construct()
	{
		parent::__construct();
		$this->path = $this->config->item('users');
	}

	private $table = 'users';
	protected $redirect = 'users';
	protected $title = 'User';
	protected $name = 'users';
	
	public function index()
	{
        check_access($this->name, 'view');

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
        $this->load->model('Users_model', 'data');
        $fetch_data = $this->data->make_datatables();
        $sr = $this->input->get('start') + 1;
        $status = verify_access($this->name, 'status');
        $update = verify_access($this->name, 'update');
        $data = [];

        foreach($fetch_data as $row)
        {
            $sub_array = [];
            $sub_array[] = $sr;
            $sub_array[] = $row->name;
            $sub_array[] = $row->mobile;
            $sub_array[] = $row->email;
            $sub_array[] = $row->create_date;
            $sub_array[] = $row->create_time;
            $sub_array[] = date_diff(date_create(date('Y-m-d')), date_create($row->dob))->format('%y');
            if ($status)
                $sub_array[] = form_open($this->redirect.'/change-status', 'id="status_'.e_id($row->id).'"', ['id' => e_id($row->id), 'status' => $row->is_blocked ? 0 : 1]).
                '<a class="btn btn-pill btn-outline-'.($row->is_blocked ? 'danger' : 'success').' btn-air-'.($row->is_blocked ? 'success' : 'danger').' btn-xs" onclick=\'script.delete("status_'.e_id($row->id).'"); return false;\' href="javascript:;">'.($row->is_blocked ? 'Blocked' : 'Unblocked').'</a>'.
                form_close();
            else
                $sub_array[] = '<a class="btn btn-pill btn-outline-'.($row->is_blocked ? 'danger' : 'success').' btn-air-'.($row->is_blocked ? 'success' : 'danger').' btn-xs" href="javascript:;">'.($row->is_blocked ? 'Blocked' : 'Unblocked').'</a>';

            $action = '<div class="btn-group" role="group"><button class="btn btn-success dropdown-toggle" id="btnGroupVerticalDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="icon-settings"></span></button><div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1" x-placement="bottom-start">';
                
            if ($update)
                $action .= anchor($this->redirect."/update/".e_id($row->id), '<i class="fa fa-edit"></i> Edit</a>', 'class="dropdown-item"');
        
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

    public function change_status()
    {
        check_access($this->name, 'status');

        $this->form_validation->set_rules('id', '', 'required|is_natural');
        $this->form_validation->set_rules('status', '', 'required|is_natural');
        
        if ($this->form_validation->run() == FALSE)
            flashMsg(0, "", "Some required fields are missing.", $this->redirect);
        else{
            $id = $this->main->update(['id' => d_id($this->input->post('id'))], ['is_blocked' => $this->input->post('status')], $this->table);
            flashMsg($id, "$this->title updated.", "$this->title not updated.", $this->redirect);
        }
    }

    public function update($id)
	{
        check_access($this->name, 'update');

        $this->form_validation->set_rules($this->validate);

        if ($this->form_validation->run() == FALSE)
        {
            $data['title'] = $this->title;
            $data['name'] = $this->name;
            $data['operation'] = "Update";
            $data['url'] = $this->redirect;
            $data['data'] = $this->main->get($this->table, 'name, mobile, email, gender, dob, image', ['id' => d_id($id)]);
            
            return $this->template->load('template', "$this->redirect/form", $data);
        }else{
            $post = [
                'name'   => $this->input->post('name'),
                'mobile' => $this->input->post('mobile'),
                'email'  => $this->input->post('email'),
                'gender' => $this->input->post('gender'),
                'dob'    => $this->input->post('dob'),
            ];
            
            if($this->input->post('password'))
			    $post['password'] = my_crypt($this->input->post('password'));

            if (!empty($_FILES['image']['name'])) {
                $image = $this->uploadImage('image');
                if ($image['error'] == TRUE)
                    flashMsg(0, "", $image["message"], "$this->redirect/update/$id");
                else{
                    if (is_file($this->path.$this->input->post('image')))
                        unlink($this->path.$this->input->post('image'));
                    $post['image'] = $image['message'];
                }
            }
            
            $id = $this->main->update(['id' => d_id($id)], $post, $this->table);

            flashMsg($id, "$this->title updated.", "$this->title not updated. Try again.", $this->redirect);
        }
	}

    public function mobile_check($str)
    {
        $check = $this->uri->segment(4) ? d_id($this->uri->segment(4)) : 0;
        $where = ['mobile' => $str, 'id != ' => $check];
        
        if ($this->main->check($this->table, $where, 'id'))
        {
            $this->form_validation->set_message('mobile_check', 'The %s is already in use');
            return FALSE;
        } else
            return TRUE;
    }

    public function email_check($str)
    {
        $check = $this->uri->segment(4) ? d_id($this->uri->segment(4)) : 0;
        $where = ['email' => $str, 'id != ' => $check];
        
        if ($this->main->check($this->table, $where, 'id'))
        {
            $this->form_validation->set_message('email_check', 'The %s is already in use');
            return FALSE;
        } else
            return TRUE;
    }

    protected $validate = [
        [
            'field' => 'name',
            'label' => 'Lab name',
            'rules' => 'required|max_length[100]|trim',
            'errors' => [
                'required' => "%s is required",
                'max_length' => "Max 100 chars allowed.",
            ],
        ],
        [
            'field' => 'mobile',
            'label' => 'Mobile no.',
            'rules' => 'required|exact_length[10]|is_natural|callback_mobile_check|trim',
            'errors' => [
                'required' => "%s is required",
                'exact_length' => "%s is invalid",
                'is_natural' => "%s is invalid",
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
            'field' => 'dob',
            'label' => 'Date of birth',
            'rules' => 'required|trim',
            'errors' => [
                'required' => "%s is required",
            ],
        ],
    ];
}