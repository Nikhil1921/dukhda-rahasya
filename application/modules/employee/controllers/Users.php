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
        $data['title'] = $this->title;
        $data['name'] = $this->name;
        $data['url'] = $this->redirect;
        $data['operation'] = "List";
        $data['datatable'] = "$this->redirect/get";
        /* $plan = $this->main->get('purchased_plans', 'UNIX_TIMESTAMP(DATE_ADD(FROM_UNIXTIME(created_at), INTERVAL validity DAY)) AS expiry, created_at', ['UNIX_TIMESTAMP(DATE_ADD(FROM_UNIXTIME(created_at), INTERVAL validity DAY)) >= ' => time()]); */
        
		return $this->template->load('template', "$this->redirect/home", $data);
	}

	public function get()
    {
        check_ajax();
        $this->load->model('Users_model', 'data');
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
            
            if($this->data->plan_purchased($row->id))
                $action .= anchor($this->redirect."/chat/".e_id($row->id), '<i class="fa fa-comments"></i> Chat</a>', 'class="dropdown-item" target="_blank"');

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

    public function chat($id)
	{
		if($this->input->is_ajax_request()){
			$options = [
				'cluster' => 'ap2',
				'encrypted' => true
			];

			$pusher = new Pusher\Pusher('1bcc03ffc88b92ba0906', '8bf81f16e0fd1337000f', '1407436', $options);
			
			$data = ['message' => $this->input->post('message'), 'sender' => "Admin", 'dt' => date('d-m-Y h:i a')];

            $post = [
                'message'      => $data['message'],
                'created_at'   => time(),
                'created_by'   => $this->session->auth,
                'u_id'         => d_id($id),
                'message_type' => 'Admin'
            ];

            $pusher->trigger($id.'_channel', 'my-event', $data);
            
            echo ($this->main->add($post, 'chats')) ? 'success' : 'error';

		}else{
            $data['title'] = $this->title;
            $data['name'] = $this->name;
            $data['url'] = $this->redirect;
            $data['operation'] = "Chat";
            $data['chat'] = true;
			$data['id'] = $id;
			$data['data'] = $this->main->get($this->table, 'name', ['id' => d_id($id)]);
            if($data['data'])
            {
                $data['data']['chats'] = $this->main->getAll('chats', 'message, created_at, message_type', ['u_id' => d_id($id)], '', 100);
                
                return $this->template->load('template', "$this->redirect/chat", $data);
            }else
                return $this->error_404();
		}
	}
}